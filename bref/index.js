'use strict';

/**
 * This file declares a plugin for the Serverless framework.
 *
 * This lets us define variables and helpers to simplify creating PHP applications.
 */

class ServerlessPlugin {
    constructor(serverless, options, utils) {
        this.serverless = serverless;
        this.options = options;
        this.utils = utils;
        this.provider = this.serverless.getProvider('aws');

        this.fs = require('fs');
        this.path = require('path');
        const filename = this.path.resolve(__dirname, 'layers.json');
        const layers = JSON.parse(this.fs.readFileSync(filename));

        this.checkCompatibleRuntime();

        // Declare `${bref:xxx}` variables
        // See https://www.serverless.com/framework/docs/guides/plugins/custom-variables
        this.configurationVariablesSources = {
            bref: {
                async resolve({address, params, resolveConfigurationProperty, options}) {
                    // `address` and `params` reflect values configured with a variable: ${bref(param1, param2):address}

                    // `options` is CLI options
                    // `resolveConfigurationProperty` allows to access other configuration properties,
                    // and guarantees to return a fully resolved form (even if property is configured with variables)
                    const region = options.region || await resolveConfigurationProperty(['provider', 'region']);

                    if (!address.startsWith('layer.')) {
                        throw new serverless.classes.Error(`Unknown Bref variable \${bref:${address}}, the only supported syntax right now is \${bref:layer.XXX}`);
                    }

                    const layerName = address.substr('layer.'.length);
                    if (! (layerName in layers)) {
                        throw new serverless.classes.Error(`Unknown Bref layer named "${layerName}".\nIs that a typo? Check out https://bref.sh/docs/runtimes/ to see the correct name of Bref layers.`);
                    }
                    if (! (region in layers[layerName])) {
                        throw new serverless.classes.Error(`There is no Bref layer named "${layerName}" in region "${region}".\nThat region may not be supported yet. Check out https://runtimes.bref.sh to see the list of supported regions.\nOpen an issue to ask for that region to be supported: https://github.com/brefphp/bref/issues`);
                    }
                    const version = layers[layerName][region];
                    return {
                        value: `arn:aws:lambda:${region}:209497400698:layer:${layerName}:${version}`,
                    }
                }
            }
        };

        // If we are on Serverless Framework v2, set up the legacy variable resolver
        if (!this.utils) {
            // This is the legacy way of declaring `${bref:xxx}` variables. This has been deprecated in 20210326.
            // Override the variable resolver to declare our own variables
            const delegate = this.serverless.variables
                .getValueFromSource.bind(this.serverless.variables);
            this.serverless.variables.getValueFromSource = (variableString) => {
                if (variableString.startsWith('bref:layer.')) {
                    const region = this.provider.getRegion();
                    const layerName = variableString.substr('bref:layer.'.length);
                    if (!(layerName in layers)) {
                        throw new serverless.classes.Error(`Unknown Bref layer named "${layerName}".\nIs that a typo? Check out https://bref.sh/docs/runtimes/ to see the correct name of Bref layers.`);
                    }
                    if (!(region in layers[layerName])) {
                        throw new serverless.classes.Error(`There is no Bref layer named "${layerName}" in region "${region}".\nThat region may not be supported yet. Check out https://runtimes.bref.sh to see the list of supported regions.\nOpen an issue to ask for that region to be supported: https://github.com/brefphp/bref/issues`);
                    }
                    const version = layers[layerName][region];
                    return `arn:aws:lambda:${region}:209497400698:layer:${layerName}:${version}`;
                }

                return delegate(variableString);
            }
        }

        this.hooks = {
            'initialize': this.addCustomIamRoleForVendorArchiveDownload.bind(this),

            // Separate vendor for `sls deploy` command
            'package:setupProviderConfiguration': this.createVendorZip.bind(this),
            'after:aws:deploy:deploy:createStack': this.uploadVendorZip.bind(this),
            // Separate vendor for `sls deploy function` command
            'before:deploy:function:initialize': this.createVendorZip.bind(this),
            'after:deploy:function:initialize': this.uploadVendorZip.bind(this),

            'before:remove:remove': this.removeVendorArchives.bind(this)
        };
    }

    checkCompatibleRuntime() {
        if (this.serverless.service.provider.runtime === 'provided') {
            throw new this.serverless.classes.Error('Bref 1.0 layers are not compatible with the "provided" runtime.\nTo upgrade to Bref 1.0, you have to switch to "provided.al2" in serverless.yml.\nMore details here: https://bref.sh/docs/news/01-bref-1.0.html#amazon-linux-2');
        }
        for (const [name, f] of Object.entries(this.serverless.service.functions)) {
            if (f.runtime === 'provided') {
                throw new this.serverless.classes.Error(`Bref 1.0 layers are not compatible with the "provided" runtime.\nTo upgrade to Bref 1.0, you have to switch to "provided.al2" in serverless.yml for the function "${name}".\nMore details here: https://bref.sh/docs/news/01-bref-1.0.html#amazon-linux-2`);
            }
        }
    }

    addCustomIamRoleForVendorArchiveDownload() {
        this.serverless.service.custom = this.serverless.service.custom ? this.serverless.service.custom : {};
        this.serverless.service.custom.bref = this.serverless.service.custom.bref ? this.serverless.service.custom.bref : {};
        if (! this.serverless.service.custom.bref.separateVendor) {
            return;
        }

        this.logVerbose("Adding custom IAM role for vendor archive");

        // If the serverless config does not yet contain an exclude for the vendor folder
        // we will add it here as we do not want the vendor folder in our
        // lambda archive file.
        let excludes = this.serverless.service.package.exclude;
        if(excludes && excludes.indexOf('vendor/**') === -1) {
            excludes.push('vendor/**');
        }
        let patterns = this.serverless.service.package.patterns;
        if(patterns && patterns.indexOf('!vendor/**') === -1) {
            patterns.push('!vendor/**');
        }

        // This defines the access rights for Lambda, so it can download the
        // vendor archive file from the vendors subfolder.
        this.serverless.service.provider.iamRoleStatements = this.serverless.service.provider.iamRoleStatements ? this.serverless.service.provider.iamRoleStatements : [];

        this.serverless.service.provider.iamRoleStatements.push({
            Effect: 'Allow',
            Action: [
                's3:GetObject',
            ],
            Resource: [
                {
                    'Fn::Join': [
                        '',
                        [
                            'arn:aws:s3:::',
                            {
                                'Ref': 'ServerlessDeploymentBucket'
                            },
                            '/',
                            this.stripSlashes(this.provider.getDeploymentPrefix() + '/vendors/*')
                        ]
                    ]
                }
            ]
        });
    }

    async createVendorZip() {
        this.serverless.service.custom = this.serverless.service.custom ? this.serverless.service.custom : {};
        this.serverless.service.custom.bref = this.serverless.service.custom.bref ? this.serverless.service.custom.bref : {};
        if(! this.serverless.service.custom.bref.separateVendor) {
            return;
        }

        this.logVerbose("Creating vendor zip file");

        const vendorZipHash = await this.createZipFile();
        this.newVendorZipName = vendorZipHash + '.zip';

        this.logVerbose('Setting environment variables');

        if (! this.serverless.service.provider.environment) {
            this.serverless.service.provider.environment = [];
        }

        // This environment variable will trigger Bref to download the zip on cold start
        this.serverless.service.provider.environment.BREF_DOWNLOAD_VENDOR = {
            'Fn::Join': [
                '',
                [
                    's3://',
                    {
                        'Ref': 'ServerlessDeploymentBucket'
                    },
                    '/',
                    this.stripSlashes(this.provider.getDeploymentPrefix() + '/vendors/' + this.newVendorZipName)
                ]
            ]
        };
    }

    async createZipFile() {
        const vendorDir = '.serverless';
        if (!this.fs.existsSync(vendorDir)){
            this.fs.mkdirSync(vendorDir);
        }
        this.filePath = `${vendorDir}/vendor.zip`;

        return await new Promise((resolve, reject) => {
            const archiver = require(process.mainModule.path + '/../node_modules/archiver');
            const output = this.fs.createWriteStream(this.filePath);
            const archive = archiver('zip', {
                zlib: { level: 9 } // Highest compression level.
            });

            this.logVerbose(`Packaging the Composer vendor directory in ${this.filePath}`);

            archive.pipe(output);
            archive.directory('vendor/', false);
            archive.finalize();

            output.on('close', () => {
                this.logVerbose(`Created vendor.zip with ${archive.pointer()} total bytes.`);
                resolve();
            });

            archive.on('warning', err => {
                if (err.code === 'ENOENT') {
                    this.logWarning('Archiver warning', err);
                } else {
                    throw new Error(err);
                }
            });

            archive.on('error', err => {
                throw new Error(err);
            });
        })
            .then(() => {
                // We will rename vendor.zip to a unique name to:
                // - avoid overwriting zips from previous deployments running in production
                // - avoid deploying vendor.zip with exactly the same contents
                const crypto = require('crypto');

                return new Promise(resolve => {
                    const hash = crypto.createHash('md5');
                    this.fs.createReadStream(this.filePath).on('data', data => hash.update(data)).on('end', () => resolve(hash.digest('hex')));
                });
            })
            .catch(err => {
                throw new Error(`Failed to create zip file vendor.zip: ${err.message}`);
            });
    }

    async uploadVendorZip() {
        this.serverless.service.custom = this.serverless.service.custom ? this.serverless.service.custom : {};
        this.serverless.service.custom.bref = this.serverless.service.custom.bref ? this.serverless.service.custom.bref : {};
        if(! this.serverless.service.custom.bref.separateVendor) {
            return;
        }

        this.logVerbose("Uploading vendor zip file...");

        await this.uploadZipToS3(this.filePath);

        this.logVerbose('Vendor separation done');
    }

    async uploadZipToS3(zipFile) {
        const bucketName = await this.provider.getServerlessDeploymentBucketName();
        const deploymentPrefix = await this.provider.getDeploymentPrefix();

        this.logVerbose('Checking vendor file on bucket...');

        try {
            await this.provider.request('S3', 'headObject', {
                Bucket: bucketName,
                Key: this.stripSlashes(deploymentPrefix + '/vendors/' + this.newVendorZipName)
            });

            this.logVerbose('Vendor file already exists on bucket. Not uploading again.');
            return;
        } catch(e) {
            // The vendor file needs to be uploaded
            this.logVerbose('Vendor file not found. Uploading...');
        }

        const readStream = this.fs.createReadStream(zipFile);
        const details = {
            ACL: 'private',
            Body: readStream,
            Bucket: bucketName,
            ContentType: 'application/zip',
            Key: this.stripSlashes(deploymentPrefix + '/vendors/' + this.newVendorZipName),
        };

        return await this.provider.request('S3', 'putObject', details);
    }

    stripSlashes(path) {
        return path.replace(/^\/+/g, '');
    }

    /**
     * CloudFormation cannot delete a bucket that contains files.
     * That's why we clean up the vendor zip files when `serverless remove` is being run.
     */
    async removeVendorArchives() {
        const bucketName = await this.provider.getServerlessDeploymentBucketName();
        const deploymentPrefix = await this.provider.getDeploymentPrefix();

        const bucketObjects = await this.provider.request('S3', 'listObjectsV2', {
            Bucket: bucketName,
            Prefix: this.stripSlashes(deploymentPrefix + '/vendors/')
        });
        if (bucketObjects.Contents.length === 0) {
            return;
        }

        this.logVerbose('Removing Composer `vendor` archives from the S3 bucket.');

        let details = {
            Bucket: bucketName,
            Delete: {
                Objects: []
            }
        };

        bucketObjects.Contents.forEach(content => {
            details.Delete.Objects.push({
                Key: content.Key
            });
        });

        this.logVerbose(`Found ${details.Delete.Objects.length} vendor archives. Removing them from Bucket now.`);

        return await this.provider.request('S3', 'deleteObjects', details);
    }

    logVerbose(message) {
        if (this.utils) {
            // Serverless v3
            this.utils.log.verbose(`Bref: ${message}`);
        } else {
            // Serverless v2
            this.serverless.cli.log(`Bref: ${message}`);
        }
    }

    logWarning(message) {
        if (this.utils) {
            // Serverless v3
            this.utils.log.warning(`Bref: ${message}`);
        } else {
            // Serverless v2
            console.warn(`Bref: ${message}`);
        }
    }
}

module.exports = ServerlessPlugin;

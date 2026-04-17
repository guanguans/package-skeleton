<?php

/** @noinspection PhpUnused */
declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

namespace Guanguans\PackageSkeleton\Support;

use Composer\Script\Event;
use Rector\Config\RectorConfig;
use Rector\DependencyInjection\LazyContainerFactory;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @see https://github.com/laravel/framework/blob/12.x/src/Illuminate/Foundation/ComposerScripts.php
 *
 * @internal
 *
 * @property \Symfony\Component\Console\Output\ConsoleOutput $output
 *
 * @method void configureIO(InputInterface $input, OutputInterface $output)
 */
final class ComposerScripts
{
    /**
     * @see \PhpCsFixer\Hasher
     * @see \PhpCsFixer\Utils
     */
    private function __construct() {}

    public static function makeRectorConfig(): RectorConfig
    {
        static $rectorConfig;

        if ($rectorConfig instanceof RectorConfig) {
            return $rectorConfig;
        }

        $rectorConfig = (new LazyContainerFactory)->create();
        $rectorConfig->boot();

        return $rectorConfig;
    }

    /**
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public static function requireAutoload(Event $event, ?bool $enableDebugging = null): void
    {
        $enableDebugging ??= (new ArgvInput)->hasParameterOption('-vvv', true);
        $enableDebugging and $event->getIO()->enableDebugging(microtime(true));
        (fn () => $this->output->setVerbosity(OutputInterface::VERBOSITY_DEBUG))->call($event->getIO());

        require_once $event->getComposer()->getConfig()->get('vendor-dir').\DIRECTORY_SEPARATOR.'autoload.php';
    }

    /**
     * @param null|list<string> $argv
     */
    public static function makeArgvInput(?array $argv = null, ?InputDefinition $inputDefinition = null): ArgvInput
    {
        static $argvInput;

        return $argvInput ??= new ArgvInput($argv, $inputDefinition);
    }

    /**
     * @see \Rector\Console\Style\SymfonyStyleFactory
     */
    public static function makeSymfonyStyle(?InputInterface $input = null, ?OutputInterface $output = null): SymfonyStyle
    {
        static $symfonyStyle;

        if (
            $symfonyStyle instanceof SymfonyStyle
            && (
                !$input instanceof InputInterface
                || (string) \Closure::bind(
                    static fn (SymfonyStyle $symfonyStyle): InputInterface => $symfonyStyle->input,
                    null,
                    SymfonyStyle::class
                )($symfonyStyle) === (string) $input
            )
            && (
                !$output instanceof OutputInterface
                || \Closure::bind(
                    static fn (SymfonyStyle $symfonyStyle): OutputInterface => $symfonyStyle->output,
                    null,
                    SymfonyStyle::class
                )($symfonyStyle) === $output
            )
        ) {
            return $symfonyStyle;
        }

        $input ??= new ArgvInput;
        $output ??= new ConsoleOutput;

        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        (fn () => $this->configureIO($input, $output))->call(new Application);

        // --debug or --xdebug is called
        if ($input->hasParameterOption(['--debug', '--xdebug'], true)) {
            $output->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
        }

        // disable output for testing
        if (self::isRunningInTesting()) {
            $output->setVerbosity(OutputInterface::VERBOSITY_QUIET);
        }

        return $symfonyStyle = new SymfonyStyle($input, $output);
    }

    public static function isRunningInTesting(): bool
    {
        return 'testing' === getenv('ENV');
    }
}

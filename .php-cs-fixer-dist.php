<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

use Ergebnis\License;
use Ergebnis\License\Holder;
use Ergebnis\License\Range;
use Ergebnis\License\Type\MIT;
use Ergebnis\License\Url;
use Ergebnis\License\Year;
use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixerCustomFixers\Fixer\CommentedOutFunctionFixer;
use PhpCsFixerCustomFixers\Fixer\CommentSurroundedBySpacesFixer;
use PhpCsFixerCustomFixers\Fixer\MultilineCommentOpeningClosingAloneFixer;
use PhpCsFixerCustomFixers\Fixer\NoDoctrineMigrationsGeneratedCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoDuplicatedArrayKeyFixer;
use PhpCsFixerCustomFixers\Fixer\NoDuplicatedImportsFixer;
use PhpCsFixerCustomFixers\Fixer\NoImportFromGlobalNamespaceFixer;
use PhpCsFixerCustomFixers\Fixer\NoLeadingSlashInGlobalNamespaceFixer;
use PhpCsFixerCustomFixers\Fixer\NoPhpStormGeneratedCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoSuperfluousConcatenationFixer;
use PhpCsFixerCustomFixers\Fixer\NoTrailingCommaInSinglelineFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessDirnameCallFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessDoctrineRepositoryCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessParenthesisFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessStrlenFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocArrayStyleFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocNoIncorrectVarAnnotationFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocNoSuperfluousParamFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocParamTypeFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocSelfAccessorFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocSingleLineVarFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocTypesCommaSpacesFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocTypesTrimFixer;
use PhpCsFixerCustomFixers\Fixer\PhpUnitAssertArgumentsOrderFixer;
use PhpCsFixerCustomFixers\Fixer\PhpUnitDedicatedAssertFixer;
use PhpCsFixerCustomFixers\Fixer\PhpUnitNoUselessReturnFixer;
use PhpCsFixerCustomFixers\Fixer\PromotedConstructorPropertyFixer;
use PhpCsFixerCustomFixers\Fixer\SingleSpaceAfterStatementFixer;
use PhpCsFixerCustomFixers\Fixer\SingleSpaceBeforeStatementFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;
use PhpCsFixerCustomFixers\Fixers;

$header = <<<'header'
    This file is part of the guanguans/package-skeleton.

    (c) guanguans <ityaozm@gmail.com>

    This source file is subject to the MIT license that is bundled.
    header;

$license = MIT::text(
    __DIR__.'/LICENSE',
    Range::since(
        Year::fromString('2018'),
        new DateTimeZone('Asia/Shanghai'),
    ),
    Holder::fromString('guanguans'),
    Url::fromString('https://github.com/guanguans/package-skeleton'),
);
// $license->header();
// $license->save();

/** @noinspection PhpParamsInspection */
$finder = Finder::create()
    ->in([
        __DIR__.'/benchmarks',
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->exclude([
        '.github/',
        'doc/',
        'docs/',
        'vendor/',
    ])
    ->append(glob(__DIR__.'/{.*,*}.php', \GLOB_BRACE))
    ->append([
        __DIR__.'/bin/composer-fixer.php',
        __DIR__.'/composer-updater',
    ])
    ->notPath([
        'bootstrap/*',
        'storage/*',
        'resources/view/mail/*',
        'vendor/*',
    ])
    ->name('*.php')
    ->notName([
        '*.blade.php',
        '_ide_helper.php',
    ])
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

// dd(json_encode($header, JSON_UNESCAPED_SLASHES));

return (new Config)
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__.'/.php-cs-fixer.cache')
    ->registerCustomFixers(new Fixers)
    ->registerCustomFixers(new PedroTroller\CS\Fixer\Fixers)
    ->setRules([
        // '@PHP70Migration' => true,
        // '@PHP70Migration:risky' => true,
        // '@PHP71Migration' => true,
        // '@PHP71Migration:risky' => true,
        // '@PHP73Migration' => true,
        // '@PHP74Migration' => true,
        // '@PHP74Migration:risky' => true,
        '@PHP80Migration' => true,
        '@PHP80Migration:risky' => true,
        // '@PHP81Migration' => true,
        // '@PHP82Migration' => true,

        // '@PHPUnit75Migration:risky' => true,
        // '@PHPUnit84Migration:risky' => true,
        '@PHPUnit100Migration:risky' => true,

        // '@DoctrineAnnotation' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,

        // alias
        'mb_str_functions' => true,

        // array_notation

        // basic
        'braces_position' => [
            'control_structures_opening_brace' => 'same_line',
            'functions_opening_brace' => 'next_line_unless_newline_at_signature_end',
            'anonymous_functions_opening_brace' => 'same_line',
            'classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
            'anonymous_classes_opening_brace' => 'same_line',
            'allow_single_line_empty_anonymous_classes' => true,
            'allow_single_line_anonymous_functions' => true,
        ],
        'no_multiple_statements_per_line' => true,

        // casing
        // cast_notation

        // class_notation
        'final_class' => false,
        'final_internal_class' => false,
        'final_public_method_for_abstract_class' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',

                'constant_public',
                'constant_protected',
                'constant_private',

                'property_public',
                'property_protected',
                'property_private',

                'construct',
                'destruct',
                'magic',
                'phpunit',

                'method_public',
                'method_protected',
                'method_private',
            ],
            'sort_algorithm' => 'none',
        ],
        'ordered_interfaces' => [
            'order' => 'alpha',
            'direction' => 'ascend',
        ],
        'self_static_accessor' => true,

        // class_usage
        'date_time_immutable' => true,

        // comment
        'header_comment' => [
            'header' => $header,
            'comment_type' => 'PHPDoc',
            'location' => 'after_declare_strict',
            'separate' => 'both',
        ],

        // constant_notation

        // control_structure
        'control_structure_braces' => true,
        'control_structure_continuation_position' => [
            // 'position' => 'same_line',
        ],
        'empty_loop_condition' => [
            // 'style' => 'for',
        ],
        'simplified_if_return' => true,

        // doctrine_annotation

        // function_notation
        'date_time_create_from_format_call' => true,
        'nullable_type_declaration_for_default_null_value' => [
            'use_nullable_type_declaration' => true,
        ],
        'phpdoc_to_param_type' => [
            'scalar_types' => true,
        ],
        // 'phpdoc_to_property_type' => [
        //     'scalar_types' => true,
        // ],
        'phpdoc_to_return_type' => [
            'scalar_types' => true,
        ],
        'regular_callable_call' => true,
        'single_line_throw' => false,
        'static_lambda' => false,

        // import
        'group_import' => false,

        // language_construct
        'declare_parentheses' => true,

        // list_notation

        // namespace_notation
        'blank_lines_before_namespace' => false,

        // naming

        // operator
        'no_useless_concat_operator' => [
            'juggle_simple_strings' => true,
        ],
        'not_operator_with_successor_space' => true,

        // php_tag

        // php_unit
        'php_unit_size_class' => [
            'group' => 'small',
        ],
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'this',
            'methods' => [],
        ],
        'php_unit_test_class_requires_covers' => false,
        'php_unit_data_provider_name' => true,
        'php_unit_data_provider_return_type' => true,

        // phpdoc
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                'package',
                'subpackage',
            ],
            'case_sensitive' => false,
        ],
        'phpdoc_line_span' => [
            'const' => null,
            'property' => null,
            'method' => 'multi',
        ],
        'phpdoc_no_empty_return' => false,
        'phpdoc_summary' => false,
        'phpdoc_tag_casing' => [
            'tags' => [
                'inheritDoc',
            ],
        ],
        'phpdoc_to_comment' => [
            // 'ignored_tags' => [],
        ],
        'phpdoc_param_order' => true,

        // return_notation
        'simplified_null_return' => true,

        // semicolon
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],

        // strict
        'declare_strict_types' => true,

        // string_notation
        'explicit_string_variable' => false,

        // whitespace
        'blank_line_before_statement' => [
            'statements' => [
                'break',
                'case',
                'continue',
                'declare',
                'default',
                'exit',
                'goto',
                'include',
                'include_once',
                'phpdoc',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
                'yield',
                'yield_from',
            ],
        ],
        'statement_indentation' => true,
        'class_definition' => [
            'inline_constructor_arguments' => false,
            'space_before_parenthesis' => true,
        ],

        // https://github.com/kubawerlos/php-cs-fixer-custom-fixers
        CommentSurroundedBySpacesFixer::name() => true,
        CommentedOutFunctionFixer::name() => [
            'functions' => ['print_r', 'var_dump', 'var_export'],
        ],
        // PhpCsFixerCustomFixers\Fixer\ConstructorEmptyBracesFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\DataProviderNameFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\DataProviderReturnTypeFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\DeclareAfterOpeningTagFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\EmptyFunctionBodyFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\IssetToArrayKeyExistsFixer::name() => true,
        MultilineCommentOpeningClosingAloneFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer::name() => [
        //     'minimum_number_of_parameters' => 5,
        //     'keep_blank_lines' => false,
        // ],
        // PhpCsFixerCustomFixers\Fixer\NoCommentedOutCodeFixer::name() => true,
        NoDoctrineMigrationsGeneratedCommentFixer::name() => true,
        NoDuplicatedArrayKeyFixer::name() => true,
        NoDuplicatedImportsFixer::name() => true,
        NoImportFromGlobalNamespaceFixer::name() => true,
        NoLeadingSlashInGlobalNamespaceFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\NoNullableBooleanTypeFixer::name() => false,
        NoPhpStormGeneratedCommentFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\NoReferenceInFunctionDefinitionFixer::name() => true,
        NoSuperfluousConcatenationFixer::name() => true,
        NoTrailingCommaInSinglelineFixer::name() => true,
        NoUselessCommentFixer::name() => true,
        NoUselessDirnameCallFixer::name() => true,
        NoUselessDoctrineRepositoryCommentFixer::name() => true,
        NoUselessParenthesisFixer::name() => true,
        NoUselessStrlenFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\NumericLiteralSeparatorFixer::name() => true,
        PhpUnitAssertArgumentsOrderFixer::name() => true,
        PhpUnitDedicatedAssertFixer::name() => true,
        PhpUnitNoUselessReturnFixer::name() => true,
        PhpdocArrayStyleFixer::name() => true,
        PhpdocNoIncorrectVarAnnotationFixer::name() => true,
        PhpdocNoSuperfluousParamFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\PhpdocOnlyAllowedAnnotationsFixer::name() => [
        //     'elements' => [
        //         'covers',
        //         'coversNothing',
        //         'dataProvider',
        //         'deprecated',
        //         'implements',
        //         'internal',
        //         'method',
        //         'noinspection',
        //         'param',
        //         'property',
        //         'requires',
        //         'return',
        //         'runInSeparateProcess',
        //         'see',
        //         'var',
        //     ],
        // ],
        // PhpCsFixerCustomFixers\Fixer\PhpdocParamOrderFixer::name() => true,
        PhpdocParamTypeFixer::name() => true,
        PhpdocSelfAccessorFixer::name() => true,
        PhpdocSingleLineVarFixer::name() => true,
        PhpdocTypesCommaSpacesFixer::name() => true,
        PhpdocTypesTrimFixer::name() => true,
        // PhpCsFixerCustomFixers\Fixer\PhpdocVarAnnotationToAssertFixer::name() => true,
        PromotedConstructorPropertyFixer::name() => [
            'promote_only_existing_properties' => false,
        ],
        // PhpCsFixerCustomFixers\Fixer\ReadonlyPromotedPropertiesFixer::name() => true,
        SingleSpaceAfterStatementFixer::name() => [
            'allow_linebreak' => false,
        ],
        SingleSpaceBeforeStatementFixer::name() => true,
        StringableInterfaceFixer::name() => true,

        // // https://github.com/PedroTroller/PhpCSFixer-Custom-Fixers
        // 'PedroTroller/order_behat_steps' => ['instanceof' => ['Behat\Behat\Context\Context']],
        // 'PedroTroller/ordered_with_getter_and_setter_first' => true,
        // 'PedroTroller/exceptions_punctuation' => true,
        // 'PedroTroller/forbidden_functions' => [
        //     'comment' => '@TODO remove this line',
        //     'functions' => ['var_dump', 'dump', 'die'],
        // ],
        // 'PedroTroller/line_break_between_method_arguments' => [
        //     'max-args' => 5,
        //     'max-length' => 120,
        //     // 'automatic-argument-merge' => true,
        //     // 'inline-attributes' => false,
        // ],
        // 'PedroTroller/line_break_between_statements' => true,
        // 'PedroTroller/comment_line_to_phpdoc_block' => true,
        // 'PedroTroller/useless_code_after_return' => true,
        // 'PedroTroller/doctrine_migrations' => ['instanceof' => ['Doctrine\Migrations\AbstractMigration']],
        // 'PedroTroller/phpspec' => ['instanceof' => ['PhpSpec\ObjectBehavior']],
    ]);

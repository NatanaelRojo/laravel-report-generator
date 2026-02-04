<?php

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    // 1. Define paths explicitly to avoid scanning vendor/storage
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])

    // 2. Optimization: Simplify Fully Qualified Class Names (FQCN)
    ->withImportNames(importShortClasses: false, removeUnusedImports: true)

    // 3. Target PHP 8.4 features specifically
    // ->withPhpSets(
    //     php84: true 
    // )

    // 4. Enhanced Prepared Sets
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true, // Essential for PHP 8.4 strong typing
        privatization: true,    // Improves encapsulation
        earlyReturn: true,      // Reduces "else" nesting
    )

    // 5. Laravel Specific Sets
    ->withSets([
        // Upgrade specifically to Laravel 12 patterns
        LaravelSetList::LARAVEL_120, 
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        // Helps convert magic methods (User::where...) to explicit Builder calls
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER, 
    ])

    // 6. Skip specific files or rules if they cause issues
    ->withSkip([
        __DIR__ . '/bootstrap/cache',
        __DIR__ . '/storage',
        // Example: Skip a rule if it conflicts with your specific coding style
        // SomeRule::class,
    ]);
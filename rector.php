<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;
use Netwerkstatt\SilverstripeRector\Rector\Misc\RenameAddFieldsToTabWithoutArrayParamRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/deploy',
        __DIR__ . '/public',
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: false,
        instanceOf: true,
        earlyReturn: true,
        rectorPreset: true,
    )
    ->withPhpSets() // automatically gets the PHP version from composer.json
    ->withSets([
        // silverstripe rector
        SilverstripeSetList::CODE_STYLE,
        SilverstripeLevelSetList::UP_TO_SS_6_0,
    ])
    ->withSkip([
        NewlineBeforeNewAssignSetRector::class,
        NewlineAfterStatementRector::class,
        DeclareStrictTypesRector::class,
        EncapsedStringsToSprintfRector::class,
        RenameAddFieldsToTabWithoutArrayParamRector::class,
    ]);

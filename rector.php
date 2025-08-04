<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\StrictArraySearchRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodParameterRector;
use Rector\DeadCode\Rector\For_\RemoveDeadContinueRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\Php73\Rector\String_\SensitiveHereNowDocRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\Php82\Rector\Encapsed\VariableInStringInterpolationFixerRector;
use Rector\Php83\Rector\Class_\ReadOnlyAnonymousClassRector;
use Rector\Php83\Rector\ClassConst\AddTypeToConstRector;
use Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector;
use Rector\Privatization\Rector\Class_\FinalizeTestCaseClassRector;
use Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector;
use Rector\TypeDeclaration\Rector\Class_\AddTestsVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureNeverReturnTypeRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\Function_\AddFunctionVoidReturnTypeWhereNoReturnRector;

return
    RectorConfig::configure()
        ->withAutoloadPaths([
            __DIR__ . '/vendor/autoload.php',
        ])
        ->withRules([
            ThrowWithPreviousExceptionRector::class,
            StrictArraySearchRector::class,
            SymplifyQuoteEscapeRector::class,
            TernaryConditionVariableAssignmentRector::class,
            WrapEncapsedVariableInCurlyBracesRector::class,
            RemoveDeadContinueRector::class,
            RemoveDeadReturnRector::class,
            RemoveDeadTryCatchRector::class,
            RemoveDuplicatedCaseInSwitchRector::class,
            RemoveEmptyClassMethodRector::class,
            RemoveUnusedConstructorParamRector::class,
            RemoveUnusedForeachKeyRector::class,
            RemoveUnusedPrivateMethodParameterRector::class,
            RemoveUnusedPrivateMethodRector::class,
            RemoveUnusedPrivatePropertyRector::class,
            RemoveUnusedPromotedPropertyRector::class,
            RemoveUnusedPublicMethodParameterRector::class,
            RemoveAlwaysElseRector::class,
            SensitiveHereNowDocRector::class,
            ClosureToArrowFunctionRector::class,
            ChangeSwitchToMatchRector::class,
            StringableForToStringRector::class,
            VariableInStringInterpolationFixerRector::class,
            AddTypeToConstRector::class,
            ExplicitNullableParamTypeRector::class,
            FinalizeTestCaseClassRector::class,
            PrivatizeFinalClassMethodRector::class,
            PrivatizeFinalClassPropertyRector::class,
            AddArrowFunctionReturnTypeRector::class,
            AddClosureNeverReturnTypeRector::class,
            AddClosureVoidReturnTypeWhereNoReturnRector::class,
            AddFunctionVoidReturnTypeWhereNoReturnRector::class,
            AddTestsVoidReturnTypeWhereNoReturnRector::class,
            AddVoidReturnTypeWhereNoReturnRector::class,
            ReturnNeverTypeRector::class,
            ReadOnlyPropertyRector::class,
            ReadOnlyClassRector::class,
            ReadOnlyAnonymousClassRector::class,
            StaticArrowFunctionRector::class,
            StaticClosureRector::class,
        ])
        ->withPaths([
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ])
        ->withSkipPath(__DIR__ . '/tests/_output')
        ->withSkipPath(__DIR__ . '/tests/Support/_generated')
        ->withFileExtensions(['php'])
;

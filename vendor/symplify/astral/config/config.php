<?php

declare (strict_types=1);
namespace ConfigTransformer202107051;

use ConfigTransformer202107051\PhpParser\ConstExprEvaluator;
use ConfigTransformer202107051\PhpParser\NodeFinder;
use ConfigTransformer202107051\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202107051\Symplify\PackageBuilder\Php\TypeChecker;
return static function (\ConfigTransformer202107051\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('ConfigTransformer202107051\Symplify\Astral\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/StaticFactory', __DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer202107051\PhpParser\ConstExprEvaluator::class);
    $services->set(\ConfigTransformer202107051\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer202107051\PhpParser\NodeFinder::class);
};

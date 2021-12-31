<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110;

use ConfigTransformer2021123110\PhpParser\BuilderFactory;
use ConfigTransformer2021123110\PhpParser\NodeFinder;
use ConfigTransformer2021123110\PhpParser\NodeVisitor\ParentConnectingVisitor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2021123110\Symfony\Component\Yaml\Parser;
use ConfigTransformer2021123110\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2021123110\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer2021123110\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer2021123110\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer2021123110\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2021123110\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer2021123110\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer2021123110\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2021123110\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer2021123110\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer2021123110\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer2021123110\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer2021123110\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer2021123110\Symplify\Astral\NodeFinder\SimpleNodeFinder::class);
    $services->set(\ConfigTransformer2021123110\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer2021123110\Symplify\Astral\NodeValue\NodeValueResolver::class);
    $services->set(\ConfigTransformer2021123110\Symplify\Astral\Naming\SimpleNameResolver::class)->factory(\ConfigTransformer2021123110\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::class . '::create');
    $services->set(\ConfigTransformer2021123110\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer2021123110\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer2021123110\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};

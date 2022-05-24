<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410;

use ConfigTransformer2022052410\PhpParser\BuilderFactory;
use ConfigTransformer2022052410\PhpParser\NodeFinder;
use ConfigTransformer2022052410\PhpParser\NodeVisitor\ParentConnectingVisitor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022052410\Symfony\Component\Yaml\Parser;
use ConfigTransformer2022052410\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2022052410\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer2022052410\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer2022052410\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use ConfigTransformer2022052410\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2022052410\Symplify\PackageBuilder\Php\TypeChecker;
use ConfigTransformer2022052410\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use function ConfigTransformer2022052410\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2022052410\Symplify\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
    $services->set(\ConfigTransformer2022052410\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer2022052410\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer2022052410\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer2022052410\PhpParser\NodeVisitor\ParentConnectingVisitor::class);
    $services->set(\ConfigTransformer2022052410\Symplify\Astral\NodeFinder\SimpleNodeFinder::class);
    $services->set(\ConfigTransformer2022052410\Symplify\PackageBuilder\Php\TypeChecker::class);
    $services->set(\ConfigTransformer2022052410\Symplify\Astral\NodeValue\NodeValueResolver::class);
    $services->set(\ConfigTransformer2022052410\Symplify\Astral\Naming\SimpleNameResolver::class)->factory(\ConfigTransformer2022052410\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::class . '::create');
    $services->set(\ConfigTransformer2022052410\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer2022052410\Symfony\Component\DependencyInjection\Loader\Configurator\service('service_container')]);
    $services->set(\ConfigTransformer2022052410\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
};

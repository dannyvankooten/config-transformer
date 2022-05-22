<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210;

use ConfigTransformer2022052210\PhpParser\BuilderFactory;
use ConfigTransformer2022052210\PhpParser\NodeFinder;
use ConfigTransformer2022052210\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022052210\Symfony\Component\Yaml\Parser;
use ConfigTransformer2022052210\Symplify\ConfigTransformer\Command\SwitchFormatCommand;
use ConfigTransformer2022052210\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer2022052210\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer2022052210\Symplify\SmartFileSystem\FileSystemFilter;
use function ConfigTransformer2022052210\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer2022052210\Symplify\ConfigTransformer\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/Enum', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer2022052210\Symfony\Component\Console\Application::class)->call('add', [\ConfigTransformer2022052210\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer2022052210\Symplify\ConfigTransformer\Command\SwitchFormatCommand::class)]);
    $services->set(\ConfigTransformer2022052210\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer2022052210\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer2022052210\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer2022052210\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer2022052210\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
    $services->set(\ConfigTransformer2022052210\Symplify\PackageBuilder\Yaml\ParametersMerger::class);
};

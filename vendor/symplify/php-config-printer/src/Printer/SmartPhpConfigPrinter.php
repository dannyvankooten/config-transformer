<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Printer;

use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Printer\ArrayDecorator\ServiceConfigurationDecorator;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * @see \Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\SmartPhpConfigPrinterTest
 */
final class SmartPhpConfigPrinter
{
    /**
     * @var ContainerConfiguratorReturnClosureFactory
     */
    private $configuratorReturnClosureFactory;
    /**
     * @var PhpParserPhpConfigPrinter
     */
    private $phpParserPhpConfigPrinter;
    /**
     * @var ServiceConfigurationDecorator
     */
    private $serviceConfigurationDecorator;
    public function __construct(\ConfigTransformer2021061210\Symplify\PhpConfigPrinter\NodeFactory\ContainerConfiguratorReturnClosureFactory $configuratorReturnClosureFactory, \ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Printer\PhpParserPhpConfigPrinter $phpParserPhpConfigPrinter, \ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Printer\ArrayDecorator\ServiceConfigurationDecorator $serviceConfigurationDecorator)
    {
        $this->configuratorReturnClosureFactory = $configuratorReturnClosureFactory;
        $this->phpParserPhpConfigPrinter = $phpParserPhpConfigPrinter;
        $this->serviceConfigurationDecorator = $serviceConfigurationDecorator;
    }
    /**
     * @param array<string, mixed[]|null> $configuredServices
     */
    public function printConfiguredServices(array $configuredServices) : string
    {
        $servicesWithConfigureCalls = [];
        foreach ($configuredServices as $service => $configuration) {
            if ($configuration === null) {
                $servicesWithConfigureCalls[$service] = null;
            } else {
                $servicesWithConfigureCalls[$service] = $this->createServiceConfiguration($configuration, $service);
            }
        }
        $return = $this->configuratorReturnClosureFactory->createFromYamlArray([\ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES => $servicesWithConfigureCalls]);
        return $this->phpParserPhpConfigPrinter->prettyPrintFile([$return]);
    }
    /**
     * @param mixed[] $configuration
     * @return array<string, mixed>|null
     */
    private function createServiceConfiguration(array $configuration, string $class) : ?array
    {
        if ($configuration === []) {
            return null;
        }
        $configuration = $this->serviceConfigurationDecorator->decorate($configuration, $class);
        return ['calls' => [['configure', [$configuration]]]];
    }
}

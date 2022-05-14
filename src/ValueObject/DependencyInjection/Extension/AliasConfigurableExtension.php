<?php

declare (strict_types=1);
namespace ConfigTransformer202205143\Symplify\ConfigTransformer\ValueObject\DependencyInjection\Extension;

use ConfigTransformer202205143\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202205143\Symfony\Component\DependencyInjection\Extension\Extension;
final class AliasConfigurableExtension extends \ConfigTransformer202205143\Symfony\Component\DependencyInjection\Extension\Extension
{
    /**
     * @var string
     */
    private $alias;
    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }
    public function getAlias() : string
    {
        return $this->alias;
    }
    /**
     * @param string[] $configs
     */
    public function load(array $configs, \ConfigTransformer202205143\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
    }
}

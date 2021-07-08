<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107080\Symfony\Component\DependencyInjection\Loader\Configurator;

use ConfigTransformer202107080\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer202107080\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DefaultsConfigurator extends \ConfigTransformer202107080\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractServiceConfigurator
{
    public const FACTORY = 'defaults';
    use Traits\AutoconfigureTrait;
    use Traits\AutowireTrait;
    use Traits\BindTrait;
    use Traits\PublicTrait;
    private $path;
    public function __construct(\ConfigTransformer202107080\Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator $parent, \ConfigTransformer202107080\Symfony\Component\DependencyInjection\Definition $definition, string $path = null)
    {
        parent::__construct($parent, $definition, null, []);
        $this->path = $path;
    }
    /**
     * Adds a tag for this definition.
     *
     * @return $this
     *
     * @throws InvalidArgumentException when an invalid tag name or attribute is provided
     */
    public final function tag(string $name, array $attributes = [])
    {
        if ('' === $name) {
            throw new \ConfigTransformer202107080\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException('The tag name in "_defaults" must be a non-empty string.');
        }
        foreach ($attributes as $attribute => $value) {
            if (null !== $value && !\is_scalar($value)) {
                throw new \ConfigTransformer202107080\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Tag "%s", attribute "%s" in "_defaults" must be of a scalar-type.', $name, $attribute));
            }
        }
        $this->definition->addTag($name, $attributes);
        return $this;
    }
    /**
     * Defines an instanceof-conditional to be applied to following service definitions.
     */
    public final function instanceof(string $fqcn) : \ConfigTransformer202107080\Symfony\Component\DependencyInjection\Loader\Configurator\InstanceofConfigurator
    {
        return $this->parent->instanceof($fqcn);
    }
}

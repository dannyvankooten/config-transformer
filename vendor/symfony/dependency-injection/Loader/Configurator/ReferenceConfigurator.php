<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202205308\Symfony\Component\DependencyInjection\Loader\Configurator;

use ConfigTransformer202205308\Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ReferenceConfigurator extends \ConfigTransformer202205308\Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator
{
    /** @internal
     * @var string */
    protected $id;
    /** @internal
     * @var int */
    protected $invalidBehavior = \ConfigTransformer202205308\Symfony\Component\DependencyInjection\ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE;
    public function __construct(string $id)
    {
        $this->id = $id;
    }
    /**
     * @return $this
     */
    public final function ignoreOnInvalid()
    {
        $this->invalidBehavior = \ConfigTransformer202205308\Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_INVALID_REFERENCE;
        return $this;
    }
    /**
     * @return $this
     */
    public final function nullOnInvalid()
    {
        $this->invalidBehavior = \ConfigTransformer202205308\Symfony\Component\DependencyInjection\ContainerInterface::NULL_ON_INVALID_REFERENCE;
        return $this;
    }
    /**
     * @return $this
     */
    public final function ignoreOnUninitialized()
    {
        $this->invalidBehavior = \ConfigTransformer202205308\Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_UNINITIALIZED_REFERENCE;
        return $this;
    }
    public function __toString() : string
    {
        return $this->id;
    }
}

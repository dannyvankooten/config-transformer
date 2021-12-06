<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021120610\Symfony\Component\DependencyInjection\Argument;

use ConfigTransformer2021120610\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use ConfigTransformer2021120610\Symfony\Component\DependencyInjection\Reference;
/**
 * Represents a service wrapped in a memoizing closure.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ServiceClosureArgument implements \ConfigTransformer2021120610\Symfony\Component\DependencyInjection\Argument\ArgumentInterface
{
    /**
     * @var mixed[]
     */
    private $values;
    public function __construct(\ConfigTransformer2021120610\Symfony\Component\DependencyInjection\Reference $reference)
    {
        $this->values = [$reference];
    }
    /**
     * {@inheritdoc}
     */
    public function getValues() : array
    {
        return $this->values;
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $values
     */
    public function setValues($values)
    {
        if ([0] !== \array_keys($values) || !($values[0] instanceof \ConfigTransformer2021120610\Symfony\Component\DependencyInjection\Reference || null === $values[0])) {
            throw new \ConfigTransformer2021120610\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException('A ServiceClosureArgument must hold one and only one Reference.');
        }
        $this->values = $values;
    }
}

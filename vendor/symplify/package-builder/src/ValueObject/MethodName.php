<?php

declare (strict_types=1);
namespace ConfigTransformer202108180\Symplify\PackageBuilder\ValueObject;

final class MethodName
{
    /**
     * @var string
     */
    public const CONSTRUCTOR = '__construct';
    /**
     * @var string
     */
    public const SET_UP = 'setUp';
    /**
     * @var string
     */
    public const INVOKE = '__invoke';
}

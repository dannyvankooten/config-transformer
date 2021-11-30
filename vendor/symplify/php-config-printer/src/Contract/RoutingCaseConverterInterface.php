<?php

declare (strict_types=1);
namespace ConfigTransformer2021113010\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021113010\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     * @param string $key
     */
    public function match($key, $values) : bool;
    /**
     * @param mixed $values
     * @param string $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021113010\PhpParser\Node\Stmt\Expression;
}

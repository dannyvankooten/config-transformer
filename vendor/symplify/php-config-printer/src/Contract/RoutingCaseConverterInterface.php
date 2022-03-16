<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2022031610\PhpParser\Node\Stmt\Expression;
interface RoutingCaseConverterInterface
{
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool;
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer2022031610\PhpParser\Node\Stmt\Expression;
}

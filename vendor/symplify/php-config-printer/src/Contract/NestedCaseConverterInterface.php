<?php

declare (strict_types=1);
namespace ConfigTransformer2021080410\Symplify\PhpConfigPrinter\Contract;

use ConfigTransformer2021080410\PhpParser\Node\Stmt\Expression;
interface NestedCaseConverterInterface
{
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $subKey) : bool;
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021080410\PhpParser\Node\Stmt\Expression;
}

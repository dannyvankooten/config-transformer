<?php

declare (strict_types=1);
namespace ConfigTransformer202205306\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202205306\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprTrueNode implements \ConfigTransformer202205306\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'true';
    }
}

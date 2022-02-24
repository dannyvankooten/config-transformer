<?php

declare (strict_types=1);
namespace ConfigTransformer202202247\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202202247\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprTrueNode implements \ConfigTransformer202202247\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'true';
    }
}

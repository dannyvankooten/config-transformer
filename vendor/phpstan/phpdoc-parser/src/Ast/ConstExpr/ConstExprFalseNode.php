<?php

declare (strict_types=1);
namespace ConfigTransformer202203063\PHPStan\PhpDocParser\Ast\ConstExpr;

use ConfigTransformer202203063\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ConstExprFalseNode implements \ConfigTransformer202203063\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return 'false';
    }
}

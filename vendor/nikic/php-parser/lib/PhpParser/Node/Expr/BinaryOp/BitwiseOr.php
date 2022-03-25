<?php

declare (strict_types=1);
namespace ConfigTransformer202203257\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202203257\PhpParser\Node\Expr\BinaryOp;
class BitwiseOr extends \ConfigTransformer202203257\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '|';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BitwiseOr';
    }
}

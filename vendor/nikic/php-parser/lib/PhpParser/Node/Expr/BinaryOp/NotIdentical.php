<?php

declare (strict_types=1);
namespace ConfigTransformer202109293\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202109293\PhpParser\Node\Expr\BinaryOp;
class NotIdentical extends \ConfigTransformer202109293\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '!==';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_NotIdentical';
    }
}

<?php

declare (strict_types=1);
namespace ConfigTransformer202112193\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer202112193\PhpParser\Node\Expr\BinaryOp;
class Identical extends \ConfigTransformer202112193\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '===';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Identical';
    }
}

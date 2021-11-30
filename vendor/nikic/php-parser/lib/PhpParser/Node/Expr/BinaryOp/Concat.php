<?php

declare (strict_types=1);
namespace ConfigTransformer2021113010\PhpParser\Node\Expr\BinaryOp;

use ConfigTransformer2021113010\PhpParser\Node\Expr\BinaryOp;
class Concat extends \ConfigTransformer2021113010\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '.';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Concat';
    }
}

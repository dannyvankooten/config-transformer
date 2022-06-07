<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer20220607\PhpParser\Node\Expr\AssignOp;
class Mul extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mul';
    }
}

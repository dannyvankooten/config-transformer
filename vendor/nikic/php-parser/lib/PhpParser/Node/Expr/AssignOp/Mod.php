<?php

declare (strict_types=1);
namespace ConfigTransformer2022030710\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer2022030710\PhpParser\Node\Expr\AssignOp;
class Mod extends \ConfigTransformer2022030710\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mod';
    }
}

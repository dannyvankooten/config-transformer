<?php

declare (strict_types=1);
namespace ConfigTransformer202111232\PhpParser\Node\Expr\AssignOp;

use ConfigTransformer202111232\PhpParser\Node\Expr\AssignOp;
class Mul extends \ConfigTransformer202111232\PhpParser\Node\Expr\AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mul';
    }
}

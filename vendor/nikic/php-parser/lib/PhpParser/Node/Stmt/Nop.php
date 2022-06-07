<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\PhpParser\Node\Stmt;

use ConfigTransformer202206079\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \ConfigTransformer202206079\PhpParser\Node\Stmt
{
    public function getSubNodeNames() : array
    {
        return [];
    }
    public function getType() : string
    {
        return 'Stmt_Nop';
    }
}

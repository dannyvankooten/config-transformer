<?php

declare (strict_types=1);
namespace ConfigTransformer202201094\PhpParser\Node\Stmt;

use ConfigTransformer202201094\PhpParser\Node;
/**
 * Represents statements of type "expr;"
 */
class Expression extends \ConfigTransformer202201094\PhpParser\Node\Stmt
{
    /** @var Node\Expr Expression */
    public $expr;
    /**
     * Constructs an expression statement.
     *
     * @param Node\Expr $expr       Expression
     * @param array     $attributes Additional attributes
     */
    public function __construct(\ConfigTransformer202201094\PhpParser\Node\Expr $expr, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->expr = $expr;
    }
    public function getSubNodeNames() : array
    {
        return ['expr'];
    }
    public function getType() : string
    {
        return 'Stmt_Expression';
    }
}

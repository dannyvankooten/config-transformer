<?php

declare (strict_types=1);
namespace ConfigTransformer2021113010\PhpParser\Node;

use ConfigTransformer2021113010\PhpParser\Node;
use ConfigTransformer2021113010\PhpParser\NodeAbstract;
class MatchArm extends \ConfigTransformer2021113010\PhpParser\NodeAbstract
{
    /** @var null|Node\Expr[] */
    public $conds;
    /** @var Node\Expr */
    public $body;
    /**
     * @param null|Node\Expr[] $conds
     */
    public function __construct($conds, \ConfigTransformer2021113010\PhpParser\Node\Expr $body, array $attributes = [])
    {
        $this->conds = $conds;
        $this->body = $body;
        $this->attributes = $attributes;
    }
    public function getSubNodeNames() : array
    {
        return ['conds', 'body'];
    }
    public function getType() : string
    {
        return 'MatchArm';
    }
}

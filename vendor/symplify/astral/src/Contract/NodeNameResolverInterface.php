<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\Symplify\Astral\Contract;

use ConfigTransformer20220607\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(Node $node) : bool;
    public function resolve(Node $node) : ?string;
}

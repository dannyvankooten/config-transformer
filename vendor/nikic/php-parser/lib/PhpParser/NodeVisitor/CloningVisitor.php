<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\PhpParser\NodeVisitor;

use ConfigTransformer20220607\PhpParser\Node;
use ConfigTransformer20220607\PhpParser\NodeVisitorAbstract;
/**
 * Visitor cloning all nodes and linking to the original nodes using an attribute.
 *
 * This visitor is required to perform format-preserving pretty prints.
 */
class CloningVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $origNode)
    {
        $node = clone $origNode;
        $node->setAttribute('origNode', $origNode);
        return $node;
    }
}

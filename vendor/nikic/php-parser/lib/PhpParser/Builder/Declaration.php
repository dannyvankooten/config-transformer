<?php

declare (strict_types=1);
namespace ConfigTransformer202108148\PhpParser\Builder;

use ConfigTransformer202108148\PhpParser;
use ConfigTransformer202108148\PhpParser\BuilderHelpers;
abstract class Declaration implements \ConfigTransformer202108148\PhpParser\Builder
{
    protected $attributes = [];
    public abstract function addStmt($stmt);
    /**
     * Adds multiple statements.
     *
     * @param array $stmts The statements to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmts($stmts)
    {
        foreach ($stmts as $stmt) {
            $this->addStmt($stmt);
        }
        return $this;
    }
    /**
     * Sets doc comment for the declaration.
     *
     * @param PhpParser\Comment\Doc|string $docComment Doc comment to set
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDocComment($docComment)
    {
        $this->attributes['comments'] = [\ConfigTransformer202108148\PhpParser\BuilderHelpers::normalizeDocComment($docComment)];
        return $this;
    }
}

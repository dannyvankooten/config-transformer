<?php

declare (strict_types=1);
namespace ConfigTransformer202205123\PHPStan\PhpDocParser\Ast;

interface Node
{
    public function __toString() : string;
    /**
     * @param mixed $value
     */
    public function setAttribute(string $key, $value) : void;
    public function hasAttribute(string $key) : bool;
    /**
     * @return mixed
     */
    public function getAttribute(string $key);
}

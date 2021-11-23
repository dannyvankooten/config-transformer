<?php

declare (strict_types=1);
namespace ConfigTransformer202111232\PhpParser\Node\Stmt;

use ConfigTransformer202111232\PhpParser\Node\Identifier;
use ConfigTransformer202111232\PhpParser\Node\Stmt;
class Label extends \ConfigTransformer202111232\PhpParser\Node\Stmt
{
    /** @var Identifier Name */
    public $name;
    /**
     * Constructs a label node.
     *
     * @param string|Identifier $name       Name
     * @param array             $attributes Additional attributes
     */
    public function __construct($name, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new \ConfigTransformer202111232\PhpParser\Node\Identifier($name) : $name;
    }
    public function getSubNodeNames() : array
    {
        return ['name'];
    }
    public function getType() : string
    {
        return 'Stmt_Label';
    }
}

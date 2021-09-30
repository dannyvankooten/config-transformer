<?php

declare (strict_types=1);
namespace ConfigTransformer202109300\PhpParser;

abstract class NodeAbstract implements \ConfigTransformer202109300\PhpParser\Node, \JsonSerializable
{
    protected $attributes;
    /**
     * Creates a Node.
     *
     * @param array $attributes Array of attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }
    /**
     * Gets line the node started in (alias of getStartLine).
     *
     * @return int Start line (or -1 if not available)
     */
    public function getLine() : int
    {
        return $this->attributes['startLine'] ?? -1;
    }
    /**
     * Gets line the node started in.
     *
     * Requires the 'startLine' attribute to be enabled in the lexer (enabled by default).
     *
     * @return int Start line (or -1 if not available)
     */
    public function getStartLine() : int
    {
        return $this->attributes['startLine'] ?? -1;
    }
    /**
     * Gets the line the node ended in.
     *
     * Requires the 'endLine' attribute to be enabled in the lexer (enabled by default).
     *
     * @return int End line (or -1 if not available)
     */
    public function getEndLine() : int
    {
        return $this->attributes['endLine'] ?? -1;
    }
    /**
     * Gets the token offset of the first token that is part of this node.
     *
     * The offset is an index into the array returned by Lexer::getTokens().
     *
     * Requires the 'startTokenPos' attribute to be enabled in the lexer (DISABLED by default).
     *
     * @return int Token start position (or -1 if not available)
     */
    public function getStartTokenPos() : int
    {
        return $this->attributes['startTokenPos'] ?? -1;
    }
    /**
     * Gets the token offset of the last token that is part of this node.
     *
     * The offset is an index into the array returned by Lexer::getTokens().
     *
     * Requires the 'endTokenPos' attribute to be enabled in the lexer (DISABLED by default).
     *
     * @return int Token end position (or -1 if not available)
     */
    public function getEndTokenPos() : int
    {
        return $this->attributes['endTokenPos'] ?? -1;
    }
    /**
     * Gets the file offset of the first character that is part of this node.
     *
     * Requires the 'startFilePos' attribute to be enabled in the lexer (DISABLED by default).
     *
     * @return int File start position (or -1 if not available)
     */
    public function getStartFilePos() : int
    {
        return $this->attributes['startFilePos'] ?? -1;
    }
    /**
     * Gets the file offset of the last character that is part of this node.
     *
     * Requires the 'endFilePos' attribute to be enabled in the lexer (DISABLED by default).
     *
     * @return int File end position (or -1 if not available)
     */
    public function getEndFilePos() : int
    {
        return $this->attributes['endFilePos'] ?? -1;
    }
    /**
     * Gets all comments directly preceding this node.
     *
     * The comments are also available through the "comments" attribute.
     *
     * @return Comment[]
     */
    public function getComments() : array
    {
        return $this->attributes['comments'] ?? [];
    }
    /**
     * Gets the doc comment of the node.
     *
     * @return null|Comment\Doc Doc comment object or null
     */
    public function getDocComment()
    {
        $comments = $this->getComments();
        for ($i = \count($comments) - 1; $i >= 0; $i--) {
            $comment = $comments[$i];
            if ($comment instanceof \ConfigTransformer202109300\PhpParser\Comment\Doc) {
                return $comment;
            }
        }
        return null;
    }
    /**
     * Sets the doc comment of the node.
     *
     * This will either replace an existing doc comment or add it to the comments array.
     *
     * @param Comment\Doc $docComment Doc comment to set
     */
    public function setDocComment($docComment)
    {
        $comments = $this->getComments();
        for ($i = \count($comments) - 1; $i >= 0; $i--) {
            if ($comments[$i] instanceof \ConfigTransformer202109300\PhpParser\Comment\Doc) {
                // Replace existing doc comment.
                $comments[$i] = $docComment;
                $this->setAttribute('comments', $comments);
                return;
            }
        }
        // Append new doc comment.
        $comments[] = $docComment;
        $this->setAttribute('comments', $comments);
    }
    /**
     * @param string $key
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }
    /**
     * @param string $key
     */
    public function hasAttribute($key) : bool
    {
        return \array_key_exists($key, $this->attributes);
    }
    /**
     * @param string $key
     */
    public function getAttribute($key, $default = null)
    {
        if (\array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        return $default;
    }
    public function getAttributes() : array
    {
        return $this->attributes;
    }
    /**
     * @param mixed[] $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }
    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return ['nodeType' => $this->getType()] + \get_object_vars($this);
    }
}

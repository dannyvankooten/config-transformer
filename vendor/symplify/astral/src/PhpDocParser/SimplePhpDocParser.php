<?php

declare (strict_types=1);
namespace ConfigTransformer202204171\Symplify\Astral\PhpDocParser;

use ConfigTransformer202204171\PhpParser\Comment\Doc;
use ConfigTransformer202204171\PhpParser\Node;
use ConfigTransformer202204171\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202204171\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202204171\PHPStan\PhpDocParser\Parser\TokenIterator;
use ConfigTransformer202204171\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode;
/**
 * @see \Symplify\Astral\Tests\PhpDocParser\SimplePhpDocParser\SimplePhpDocParserTest
 */
final class SimplePhpDocParser
{
    /**
     * @var \PHPStan\PhpDocParser\Parser\PhpDocParser
     */
    private $phpDocParser;
    /**
     * @var \PHPStan\PhpDocParser\Lexer\Lexer
     */
    private $lexer;
    public function __construct(\ConfigTransformer202204171\PHPStan\PhpDocParser\Parser\PhpDocParser $phpDocParser, \ConfigTransformer202204171\PHPStan\PhpDocParser\Lexer\Lexer $lexer)
    {
        $this->phpDocParser = $phpDocParser;
        $this->lexer = $lexer;
    }
    public function parseNode(\ConfigTransformer202204171\PhpParser\Node $node) : ?\ConfigTransformer202204171\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode
    {
        $docComment = $node->getDocComment();
        if (!$docComment instanceof \ConfigTransformer202204171\PhpParser\Comment\Doc) {
            return null;
        }
        return $this->parseDocBlock($docComment->getText());
    }
    public function parseDocBlock(string $docBlock) : \ConfigTransformer202204171\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode
    {
        $tokens = $this->lexer->tokenize($docBlock);
        $tokenIterator = new \ConfigTransformer202204171\PHPStan\PhpDocParser\Parser\TokenIterator($tokens);
        $phpDocNode = $this->phpDocParser->parse($tokenIterator);
        return new \ConfigTransformer202204171\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode($phpDocNode->children);
    }
}

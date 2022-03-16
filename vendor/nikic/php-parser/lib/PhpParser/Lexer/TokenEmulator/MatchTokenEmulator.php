<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\PhpParser\Lexer\TokenEmulator;

use ConfigTransformer2022031610\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends \ConfigTransformer2022031610\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \ConfigTransformer2022031610\PhpParser\Lexer\Emulative::PHP_8_0;
    }
    public function getKeywordString() : string
    {
        return 'match';
    }
    public function getKeywordToken() : int
    {
        return \T_MATCH;
    }
}

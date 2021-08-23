<?php

declare (strict_types=1);
namespace ConfigTransformer202108237\PhpParser\Lexer\TokenEmulator;

abstract class KeywordEmulator extends \ConfigTransformer202108237\PhpParser\Lexer\TokenEmulator\TokenEmulator
{
    abstract function getKeywordString() : string;
    abstract function getKeywordToken() : int;
    /**
     * @param string $code
     */
    public function isEmulationNeeded($code) : bool
    {
        return \strpos(\strtolower($code), $this->getKeywordString()) !== \false;
    }
    /**
     * @param mixed[] $tokens
     * @param int $pos
     */
    protected function isKeywordContext($tokens, $pos) : bool
    {
        $previousNonSpaceToken = $this->getPreviousNonSpaceToken($tokens, $pos);
        return $previousNonSpaceToken === null || $previousNonSpaceToken[0] !== \T_OBJECT_OPERATOR;
    }
    /**
     * @param string $code
     * @param mixed[] $tokens
     */
    public function emulate($code, $tokens) : array
    {
        $keywordString = $this->getKeywordString();
        foreach ($tokens as $i => $token) {
            if ($token[0] === \T_STRING && \strtolower($token[1]) === $keywordString && $this->isKeywordContext($tokens, $i)) {
                $tokens[$i][0] = $this->getKeywordToken();
            }
        }
        return $tokens;
    }
    /**
     * @param mixed[] $tokens
     * @return mixed[]|null
     */
    private function getPreviousNonSpaceToken(array $tokens, int $start)
    {
        for ($i = $start - 1; $i >= 0; --$i) {
            if ($tokens[$i][0] === \T_WHITESPACE) {
                continue;
            }
            return $tokens[$i];
        }
        return null;
    }
    /**
     * @param string $code
     * @param mixed[] $tokens
     */
    public function reverseEmulate($code, $tokens) : array
    {
        $keywordToken = $this->getKeywordToken();
        foreach ($tokens as $i => $token) {
            if ($token[0] === $keywordToken) {
                $tokens[$i][0] = \T_STRING;
            }
        }
        return $tokens;
    }
}

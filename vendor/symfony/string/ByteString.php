<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202205308\Symfony\Component\String;

use ConfigTransformer202205308\Symfony\Component\String\Exception\ExceptionInterface;
use ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException;
use ConfigTransformer202205308\Symfony\Component\String\Exception\RuntimeException;
/**
 * Represents a binary-safe string of bytes.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 * @author Hugo Hamon <hugohamon@neuf.fr>
 *
 * @throws ExceptionInterface
 */
class ByteString extends \ConfigTransformer202205308\Symfony\Component\String\AbstractString
{
    private const ALPHABET_ALPHANUMERIC = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    public function __construct(string $string = '')
    {
        $this->string = $string;
    }
    /*
     * The following method was derived from code of the Hack Standard Library (v4.40 - 2020-05-03)
     *
     * https://github.com/hhvm/hsl/blob/80a42c02f036f72a42f0415e80d6b847f4bf62d5/src/random/private.php#L16
     *
     * Code subject to the MIT license (https://github.com/hhvm/hsl/blob/master/LICENSE).
     *
     * Copyright (c) 2004-2020, Facebook, Inc. (https://www.facebook.com/)
     */
    public static function fromRandom(int $length = 16, string $alphabet = null) : self
    {
        if ($length <= 0) {
            throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException(\sprintf('A strictly positive length is expected, "%d" given.', $length));
        }
        $alphabet = $alphabet ?? self::ALPHABET_ALPHANUMERIC;
        $alphabetSize = \strlen($alphabet);
        $bits = (int) \ceil(\log($alphabetSize, 2.0));
        if ($bits <= 0 || $bits > 56) {
            throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException('The length of the alphabet must in the [2^1, 2^56] range.');
        }
        $ret = '';
        while ($length > 0) {
            $urandomLength = (int) \ceil(2 * $length * $bits / 8.0);
            $data = \random_bytes($urandomLength);
            $unpackedData = 0;
            $unpackedBits = 0;
            for ($i = 0; $i < $urandomLength && $length > 0; ++$i) {
                // Unpack 8 bits
                $unpackedData = $unpackedData << 8 | \ord($data[$i]);
                $unpackedBits += 8;
                // While we have enough bits to select a character from the alphabet, keep
                // consuming the random data
                for (; $unpackedBits >= $bits && $length > 0; $unpackedBits -= $bits) {
                    $index = $unpackedData & (1 << $bits) - 1;
                    $unpackedData >>= $bits;
                    // Unfortunately, the alphabet size is not necessarily a power of two.
                    // Worst case, it is 2^k + 1, which means we need (k+1) bits and we
                    // have around a 50% chance of missing as k gets larger
                    if ($index < $alphabetSize) {
                        $ret .= $alphabet[$index];
                        --$length;
                    }
                }
            }
        }
        return new static($ret);
    }
    public function bytesAt(int $offset) : array
    {
        $str = $this->string[$offset] ?? '';
        return '' === $str ? [] : [\ord($str)];
    }
    /**
     * @return $this
     */
    public function append(string ...$suffix)
    {
        $str = clone $this;
        $str->string .= 1 >= \count($suffix) ? $suffix[0] ?? '' : \implode('', $suffix);
        return $str;
    }
    /**
     * @return $this
     */
    public function camel()
    {
        $str = clone $this;
        $str->string = \lcfirst(\str_replace(' ', '', \ucwords(\preg_replace('/[^a-zA-Z0-9\\x7f-\\xff]++/', ' ', $this->string))));
        return $str;
    }
    public function chunk(int $length = 1) : array
    {
        if (1 > $length) {
            throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException('The chunk length must be greater than zero.');
        }
        if ('' === $this->string) {
            return [];
        }
        $str = clone $this;
        $chunks = [];
        foreach (\str_split($this->string, $length) as $chunk) {
            $str->string = $chunk;
            $chunks[] = clone $str;
        }
        return $chunks;
    }
    /**
     * @param string|mixed[]|\Symfony\Component\String\AbstractString $suffix
     */
    public function endsWith($suffix) : bool
    {
        if ($suffix instanceof \ConfigTransformer202205308\Symfony\Component\String\AbstractString) {
            $suffix = $suffix->string;
        } elseif (!\is_string($suffix)) {
            return parent::endsWith($suffix);
        }
        return '' !== $suffix && \strlen($this->string) >= \strlen($suffix) && 0 === \substr_compare($this->string, $suffix, -\strlen($suffix), null, $this->ignoreCase);
    }
    /**
     * @param string|mixed[]|\Symfony\Component\String\AbstractString $string
     */
    public function equalsTo($string) : bool
    {
        if ($string instanceof \ConfigTransformer202205308\Symfony\Component\String\AbstractString) {
            $string = $string->string;
        } elseif (!\is_string($string)) {
            return parent::equalsTo($string);
        }
        if ('' !== $string && $this->ignoreCase) {
            return 0 === \strcasecmp($string, $this->string);
        }
        return $string === $this->string;
    }
    /**
     * @return $this
     */
    public function folded()
    {
        $str = clone $this;
        $str->string = \strtolower($str->string);
        return $str;
    }
    /**
     * @param string|mixed[]|\Symfony\Component\String\AbstractString $needle
     */
    public function indexOf($needle, int $offset = 0) : ?int
    {
        if ($needle instanceof \ConfigTransformer202205308\Symfony\Component\String\AbstractString) {
            $needle = $needle->string;
        } elseif (!\is_string($needle)) {
            return parent::indexOf($needle, $offset);
        }
        if ('' === $needle) {
            return null;
        }
        $i = $this->ignoreCase ? \stripos($this->string, $needle, $offset) : \strpos($this->string, $needle, $offset);
        return \false === $i ? null : $i;
    }
    /**
     * @param string|mixed[]|\Symfony\Component\String\AbstractString $needle
     */
    public function indexOfLast($needle, int $offset = 0) : ?int
    {
        if ($needle instanceof \ConfigTransformer202205308\Symfony\Component\String\AbstractString) {
            $needle = $needle->string;
        } elseif (!\is_string($needle)) {
            return parent::indexOfLast($needle, $offset);
        }
        if ('' === $needle) {
            return null;
        }
        $i = $this->ignoreCase ? \strripos($this->string, $needle, $offset) : \strrpos($this->string, $needle, $offset);
        return \false === $i ? null : $i;
    }
    public function isUtf8() : bool
    {
        return '' === $this->string || \preg_match('//u', $this->string);
    }
    /**
     * @return $this
     */
    public function join(array $strings, string $lastGlue = null)
    {
        $str = clone $this;
        $tail = null !== $lastGlue && 1 < \count($strings) ? $lastGlue . \array_pop($strings) : '';
        $str->string = \implode($this->string, $strings) . $tail;
        return $str;
    }
    public function length() : int
    {
        return \strlen($this->string);
    }
    /**
     * @return $this
     */
    public function lower()
    {
        $str = clone $this;
        $str->string = \strtolower($str->string);
        return $str;
    }
    public function match(string $regexp, int $flags = 0, int $offset = 0) : array
    {
        $match = (\PREG_PATTERN_ORDER | \PREG_SET_ORDER) & $flags ? 'preg_match_all' : 'preg_match';
        if ($this->ignoreCase) {
            $regexp .= 'i';
        }
        \set_error_handler(static function ($t, $m) {
            throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException($m);
        });
        try {
            if (\false === $match($regexp, $this->string, $matches, $flags | \PREG_UNMATCHED_AS_NULL, $offset)) {
                $lastError = \preg_last_error();
                foreach (\get_defined_constants(\true)['pcre'] as $k => $v) {
                    if ($lastError === $v && '_ERROR' === \substr($k, -6)) {
                        throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\RuntimeException('Matching failed with ' . $k . '.');
                    }
                }
                throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\RuntimeException('Matching failed with unknown error code.');
            }
        } finally {
            \restore_error_handler();
        }
        return $matches;
    }
    /**
     * @return $this
     */
    public function padBoth(int $length, string $padStr = ' ')
    {
        $str = clone $this;
        $str->string = \str_pad($this->string, $length, $padStr, \STR_PAD_BOTH);
        return $str;
    }
    /**
     * @return $this
     */
    public function padEnd(int $length, string $padStr = ' ')
    {
        $str = clone $this;
        $str->string = \str_pad($this->string, $length, $padStr, \STR_PAD_RIGHT);
        return $str;
    }
    /**
     * @return $this
     */
    public function padStart(int $length, string $padStr = ' ')
    {
        $str = clone $this;
        $str->string = \str_pad($this->string, $length, $padStr, \STR_PAD_LEFT);
        return $str;
    }
    /**
     * @return $this
     */
    public function prepend(string ...$prefix)
    {
        $str = clone $this;
        $str->string = (1 >= \count($prefix) ? $prefix[0] ?? '' : \implode('', $prefix)) . $str->string;
        return $str;
    }
    /**
     * @return $this
     */
    public function replace(string $from, string $to)
    {
        $str = clone $this;
        if ('' !== $from) {
            $str->string = $this->ignoreCase ? \str_ireplace($from, $to, $this->string) : \str_replace($from, $to, $this->string);
        }
        return $str;
    }
    /**
     * @param string|callable $to
     * @return $this
     */
    public function replaceMatches(string $fromRegexp, $to)
    {
        if ($this->ignoreCase) {
            $fromRegexp .= 'i';
        }
        $replace = \is_array($to) || $to instanceof \Closure ? 'preg_replace_callback' : 'preg_replace';
        \set_error_handler(static function ($t, $m) {
            throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException($m);
        });
        try {
            if (null === ($string = $replace($fromRegexp, $to, $this->string))) {
                $lastError = \preg_last_error();
                foreach (\get_defined_constants(\true)['pcre'] as $k => $v) {
                    if ($lastError === $v && '_ERROR' === \substr($k, -6)) {
                        throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\RuntimeException('Matching failed with ' . $k . '.');
                    }
                }
                throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\RuntimeException('Matching failed with unknown error code.');
            }
        } finally {
            \restore_error_handler();
        }
        $str = clone $this;
        $str->string = $string;
        return $str;
    }
    /**
     * @return $this
     */
    public function reverse()
    {
        $str = clone $this;
        $str->string = \strrev($str->string);
        return $str;
    }
    /**
     * @return $this
     */
    public function slice(int $start = 0, int $length = null)
    {
        $str = clone $this;
        $str->string = (string) \substr($this->string, $start, $length ?? \PHP_INT_MAX);
        return $str;
    }
    /**
     * @return $this
     */
    public function snake()
    {
        $str = $this->camel()->title();
        $str->string = \strtolower(\preg_replace(['/([A-Z]+)([A-Z][a-z])/', '/([a-z\\d])([A-Z])/'], 'ConfigTransformer202205308\\1_\\2', $str->string));
        return $str;
    }
    /**
     * @return $this
     */
    public function splice(string $replacement, int $start = 0, int $length = null)
    {
        $str = clone $this;
        $str->string = \substr_replace($this->string, $replacement, $start, $length ?? \PHP_INT_MAX);
        return $str;
    }
    public function split(string $delimiter, int $limit = null, int $flags = null) : array
    {
        if (1 > ($limit = $limit ?? \PHP_INT_MAX)) {
            throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException('Split limit must be a positive integer.');
        }
        if ('' === $delimiter) {
            throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException('Split delimiter is empty.');
        }
        if (null !== $flags) {
            return parent::split($delimiter, $limit, $flags);
        }
        $str = clone $this;
        $chunks = $this->ignoreCase ? \preg_split('{' . \preg_quote($delimiter) . '}iD', $this->string, $limit) : \explode($delimiter, $this->string, $limit);
        foreach ($chunks as &$chunk) {
            $str->string = $chunk;
            $chunk = clone $str;
        }
        return $chunks;
    }
    /**
     * @param string|mixed[]|\Symfony\Component\String\AbstractString $prefix
     */
    public function startsWith($prefix) : bool
    {
        if ($prefix instanceof \ConfigTransformer202205308\Symfony\Component\String\AbstractString) {
            $prefix = $prefix->string;
        } elseif (!\is_string($prefix)) {
            return parent::startsWith($prefix);
        }
        return '' !== $prefix && 0 === ($this->ignoreCase ? \strncasecmp($this->string, $prefix, \strlen($prefix)) : \strncmp($this->string, $prefix, \strlen($prefix)));
    }
    /**
     * @return $this
     */
    public function title(bool $allWords = \false)
    {
        $str = clone $this;
        $str->string = $allWords ? \ucwords($str->string) : \ucfirst($str->string);
        return $str;
    }
    public function toUnicodeString(string $fromEncoding = null) : \ConfigTransformer202205308\Symfony\Component\String\UnicodeString
    {
        return new \ConfigTransformer202205308\Symfony\Component\String\UnicodeString($this->toCodePointString($fromEncoding)->string);
    }
    public function toCodePointString(string $fromEncoding = null) : \ConfigTransformer202205308\Symfony\Component\String\CodePointString
    {
        $u = new \ConfigTransformer202205308\Symfony\Component\String\CodePointString();
        if (\in_array($fromEncoding, [null, 'utf8', 'utf-8', 'UTF8', 'UTF-8'], \true) && \preg_match('//u', $this->string)) {
            $u->string = $this->string;
            return $u;
        }
        \set_error_handler(static function ($t, $m) {
            throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException($m);
        });
        try {
            try {
                $validEncoding = \false !== \mb_detect_encoding($this->string, $fromEncoding ?? 'Windows-1252', \true);
            } catch (\ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException $e) {
                if (!\function_exists('iconv')) {
                    throw $e;
                }
                $u->string = \iconv($fromEncoding ?? 'Windows-1252', 'UTF-8', $this->string);
                return $u;
            }
        } finally {
            \restore_error_handler();
        }
        if (!$validEncoding) {
            throw new \ConfigTransformer202205308\Symfony\Component\String\Exception\InvalidArgumentException(\sprintf('Invalid "%s" string.', $fromEncoding ?? 'Windows-1252'));
        }
        $u->string = \mb_convert_encoding($this->string, 'UTF-8', $fromEncoding ?? 'Windows-1252');
        return $u;
    }
    /**
     * @return $this
     */
    public function trim(string $chars = " \t\n\r\0\v\f")
    {
        $str = clone $this;
        $str->string = \trim($str->string, $chars);
        return $str;
    }
    /**
     * @return $this
     */
    public function trimEnd(string $chars = " \t\n\r\0\v\f")
    {
        $str = clone $this;
        $str->string = \rtrim($str->string, $chars);
        return $str;
    }
    /**
     * @return $this
     */
    public function trimStart(string $chars = " \t\n\r\0\v\f")
    {
        $str = clone $this;
        $str->string = \ltrim($str->string, $chars);
        return $str;
    }
    /**
     * @return $this
     */
    public function upper()
    {
        $str = clone $this;
        $str->string = \strtoupper($str->string);
        return $str;
    }
    public function width(bool $ignoreAnsiDecoration = \true) : int
    {
        $string = \preg_match('//u', $this->string) ? $this->string : \preg_replace('/[\\x80-\\xFF]/', '?', $this->string);
        return (new \ConfigTransformer202205308\Symfony\Component\String\CodePointString($string))->width($ignoreAnsiDecoration);
    }
}

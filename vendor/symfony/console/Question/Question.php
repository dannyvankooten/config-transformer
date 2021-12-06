<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021120610\Symfony\Component\Console\Question;

use ConfigTransformer2021120610\Symfony\Component\Console\Exception\InvalidArgumentException;
use ConfigTransformer2021120610\Symfony\Component\Console\Exception\LogicException;
/**
 * Represents a Question.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Question
{
    /**
     * @var string
     */
    private $question;
    /**
     * @var int|null
     */
    private $attempts;
    /**
     * @var bool
     */
    private $hidden = \false;
    /**
     * @var bool
     */
    private $hiddenFallback = \true;
    /**
     * @var \Closure|null
     */
    private $autocompleterCallback;
    /**
     * @var \Closure|null
     */
    private $validator;
    /**
     * @var bool|float|int|string|null
     */
    private $default;
    /**
     * @var \Closure|null
     */
    private $normalizer;
    /**
     * @var bool
     */
    private $trimmable = \true;
    /**
     * @var bool
     */
    private $multiline = \false;
    /**
     * @param string                     $question The question to ask to the user
     * @param bool|float|int|string $default The default answer to return if the user enters nothing
     */
    public function __construct(string $question, $default = null)
    {
        $this->question = $question;
        $this->default = $default;
    }
    /**
     * Returns the question.
     */
    public function getQuestion() : string
    {
        return $this->question;
    }
    /**
     * Returns the default answer.
     *
     * @return string|bool|int|float|null
     */
    public function getDefault()
    {
        return $this->default;
    }
    /**
     * Returns whether the user response accepts newline characters.
     */
    public function isMultiline() : bool
    {
        return $this->multiline;
    }
    /**
     * Sets whether the user response should accept newline characters.
     *
     * @return $this
     * @param bool $multiline
     */
    public function setMultiline($multiline)
    {
        $this->multiline = $multiline;
        return $this;
    }
    /**
     * Returns whether the user response must be hidden.
     */
    public function isHidden() : bool
    {
        return $this->hidden;
    }
    /**
     * Sets whether the user response must be hidden or not.
     *
     * @return $this
     *
     * @throws LogicException In case the autocompleter is also used
     * @param bool $hidden
     */
    public function setHidden($hidden)
    {
        if ($this->autocompleterCallback) {
            throw new \ConfigTransformer2021120610\Symfony\Component\Console\Exception\LogicException('A hidden question cannot use the autocompleter.');
        }
        $this->hidden = $hidden;
        return $this;
    }
    /**
     * In case the response cannot be hidden, whether to fallback on non-hidden question or not.
     */
    public function isHiddenFallback() : bool
    {
        return $this->hiddenFallback;
    }
    /**
     * Sets whether to fallback on non-hidden question if the response cannot be hidden.
     *
     * @return $this
     * @param bool $fallback
     */
    public function setHiddenFallback($fallback)
    {
        $this->hiddenFallback = $fallback;
        return $this;
    }
    /**
     * Gets values for the autocompleter.
     */
    public function getAutocompleterValues() : ?iterable
    {
        $callback = $this->getAutocompleterCallback();
        return $callback ? $callback('') : null;
    }
    /**
     * Sets values for the autocompleter.
     *
     * @return $this
     *
     * @throws LogicException
     * @param mixed[]|null $values
     */
    public function setAutocompleterValues($values)
    {
        if (\is_array($values)) {
            $values = $this->isAssoc($values) ? \array_merge(\array_keys($values), \array_values($values)) : \array_values($values);
            $callback = static function () use($values) {
                return $values;
            };
        } elseif ($values instanceof \Traversable) {
            $valueCache = null;
            $callback = static function () use($values, &$valueCache) {
                return $valueCache ?? ($valueCache = \iterator_to_array($values, \false));
            };
        } else {
            $callback = null;
        }
        return $this->setAutocompleterCallback($callback);
    }
    /**
     * Gets the callback function used for the autocompleter.
     */
    public function getAutocompleterCallback() : ?callable
    {
        return $this->autocompleterCallback;
    }
    /**
     * Sets the callback function used for the autocompleter.
     *
     * The callback is passed the user input as argument and should return an iterable of corresponding suggestions.
     *
     * @return $this
     * @param callable|null $callback
     */
    public function setAutocompleterCallback($callback = null)
    {
        if ($this->hidden && null !== $callback) {
            throw new \ConfigTransformer2021120610\Symfony\Component\Console\Exception\LogicException('A hidden question cannot use the autocompleter.');
        }
        $this->autocompleterCallback = null === $callback || $callback instanceof \Closure ? $callback : \Closure::fromCallable($callback);
        return $this;
    }
    /**
     * Sets a validator for the question.
     *
     * @return $this
     * @param callable|null $validator
     */
    public function setValidator($validator = null)
    {
        $this->validator = null === $validator || $validator instanceof \Closure ? $validator : \Closure::fromCallable($validator);
        return $this;
    }
    /**
     * Gets the validator for the question.
     */
    public function getValidator() : ?callable
    {
        return $this->validator;
    }
    /**
     * Sets the maximum number of attempts.
     *
     * Null means an unlimited number of attempts.
     *
     * @return $this
     *
     * @throws InvalidArgumentException in case the number of attempts is invalid
     * @param int|null $attempts
     */
    public function setMaxAttempts($attempts)
    {
        if (null !== $attempts && $attempts < 1) {
            throw new \ConfigTransformer2021120610\Symfony\Component\Console\Exception\InvalidArgumentException('Maximum number of attempts must be a positive value.');
        }
        $this->attempts = $attempts;
        return $this;
    }
    /**
     * Gets the maximum number of attempts.
     *
     * Null means an unlimited number of attempts.
     */
    public function getMaxAttempts() : ?int
    {
        return $this->attempts;
    }
    /**
     * Sets a normalizer for the response.
     *
     * The normalizer can be a callable(a string), a closure or a class implementing __invoke.
     *
     * @return $this
     * @param callable $normalizer
     */
    public function setNormalizer($normalizer)
    {
        $this->normalizer = $normalizer instanceof \Closure ? $normalizer : \Closure::fromCallable($normalizer);
        return $this;
    }
    /**
     * Gets the normalizer for the response.
     *
     * The normalizer can ba a callable (a string), a closure or a class implementing __invoke.
     */
    public function getNormalizer() : ?callable
    {
        return $this->normalizer;
    }
    /**
     * @param mixed[] $array
     */
    protected function isAssoc($array)
    {
        return (bool) \count(\array_filter(\array_keys($array), 'is_string'));
    }
    public function isTrimmable() : bool
    {
        return $this->trimmable;
    }
    /**
     * @return $this
     * @param bool $trimmable
     */
    public function setTrimmable($trimmable)
    {
        $this->trimmable = $trimmable;
        return $this;
    }
}

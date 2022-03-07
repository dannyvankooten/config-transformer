<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202203075\Symfony\Component\Console\Helper;

use ConfigTransformer202203075\Symfony\Component\Console\Exception\InvalidArgumentException;
use ConfigTransformer202203075\Symfony\Component\Console\Exception\LogicException;
use ConfigTransformer202203075\Symfony\Component\Console\Output\OutputInterface;
/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class ProgressIndicator
{
    private const FORMATS = ['normal' => ' %indicator% %message%', 'normal_no_ansi' => ' %message%', 'verbose' => ' %indicator% %message% (%elapsed:6s%)', 'verbose_no_ansi' => ' %message% (%elapsed:6s%)', 'very_verbose' => ' %indicator% %message% (%elapsed:6s%, %memory:6s%)', 'very_verbose_no_ansi' => ' %message% (%elapsed:6s%, %memory:6s%)'];
    private $output;
    /**
     * @var int
     */
    private $startTime;
    /**
     * @var string|null
     */
    private $format;
    /**
     * @var string|null
     */
    private $message;
    /**
     * @var mixed[]
     */
    private $indicatorValues;
    /**
     * @var int
     */
    private $indicatorCurrent;
    /**
     * @var int
     */
    private $indicatorChangeInterval;
    /**
     * @var float
     */
    private $indicatorUpdateTime;
    /**
     * @var bool
     */
    private $started = \false;
    /**
     * @var array<string, callable>
     */
    private static $formatters;
    /**
     * @param int        $indicatorChangeInterval Change interval in milliseconds
     * @param array|null $indicatorValues         Animated indicator characters
     */
    public function __construct(\ConfigTransformer202203075\Symfony\Component\Console\Output\OutputInterface $output, string $format = null, int $indicatorChangeInterval = 100, array $indicatorValues = null)
    {
        $this->output = $output;
        if (null === $format) {
            $format = $this->determineBestFormat();
        }
        if (null === $indicatorValues) {
            $indicatorValues = ['-', '\\', '|', '/'];
        }
        $indicatorValues = \array_values($indicatorValues);
        if (2 > \count($indicatorValues)) {
            throw new \ConfigTransformer202203075\Symfony\Component\Console\Exception\InvalidArgumentException('Must have at least 2 indicator value characters.');
        }
        $this->format = self::getFormatDefinition($format);
        $this->indicatorChangeInterval = $indicatorChangeInterval;
        $this->indicatorValues = $indicatorValues;
        $this->startTime = \time();
    }
    /**
     * Sets the current indicator message.
     */
    public function setMessage(?string $message)
    {
        $this->message = $message;
        $this->display();
    }
    /**
     * Starts the indicator output.
     */
    public function start(string $message)
    {
        if ($this->started) {
            throw new \ConfigTransformer202203075\Symfony\Component\Console\Exception\LogicException('Progress indicator already started.');
        }
        $this->message = $message;
        $this->started = \true;
        $this->startTime = \time();
        $this->indicatorUpdateTime = $this->getCurrentTimeInMilliseconds() + $this->indicatorChangeInterval;
        $this->indicatorCurrent = 0;
        $this->display();
    }
    /**
     * Advances the indicator.
     */
    public function advance()
    {
        if (!$this->started) {
            throw new \ConfigTransformer202203075\Symfony\Component\Console\Exception\LogicException('Progress indicator has not yet been started.');
        }
        if (!$this->output->isDecorated()) {
            return;
        }
        $currentTime = $this->getCurrentTimeInMilliseconds();
        if ($currentTime < $this->indicatorUpdateTime) {
            return;
        }
        $this->indicatorUpdateTime = $currentTime + $this->indicatorChangeInterval;
        ++$this->indicatorCurrent;
        $this->display();
    }
    /**
     * Finish the indicator with message.
     *
     * @param $message
     */
    public function finish(string $message)
    {
        if (!$this->started) {
            throw new \ConfigTransformer202203075\Symfony\Component\Console\Exception\LogicException('Progress indicator has not yet been started.');
        }
        $this->message = $message;
        $this->display();
        $this->output->writeln('');
        $this->started = \false;
    }
    /**
     * Gets the format for a given name.
     */
    public static function getFormatDefinition(string $name) : ?string
    {
        return self::FORMATS[$name] ?? null;
    }
    /**
     * Sets a placeholder formatter for a given name.
     *
     * This method also allow you to override an existing placeholder.
     */
    public static function setPlaceholderFormatterDefinition(string $name, callable $callable)
    {
        self::$formatters = self::$formatters ?? self::initPlaceholderFormatters();
        self::$formatters[$name] = $callable;
    }
    /**
     * Gets the placeholder formatter for a given name (including the delimiter char like %).
     */
    public static function getPlaceholderFormatterDefinition(string $name) : ?callable
    {
        self::$formatters = self::$formatters ?? self::initPlaceholderFormatters();
        return self::$formatters[$name] ?? null;
    }
    private function display()
    {
        if (\ConfigTransformer202203075\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET === $this->output->getVerbosity()) {
            return;
        }
        $this->overwrite(\preg_replace_callback("{%([a-z\\-_]+)(?:\\:([^%]+))?%}i", function ($matches) {
            if ($formatter = self::getPlaceholderFormatterDefinition($matches[1])) {
                return $formatter($this);
            }
            return $matches[0];
        }, $this->format ?? ''));
    }
    private function determineBestFormat() : string
    {
        switch ($this->output->getVerbosity()) {
            // OutputInterface::VERBOSITY_QUIET: display is disabled anyway
            case \ConfigTransformer202203075\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE:
                return $this->output->isDecorated() ? 'verbose' : 'verbose_no_ansi';
            case \ConfigTransformer202203075\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERY_VERBOSE:
            case \ConfigTransformer202203075\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG:
                return $this->output->isDecorated() ? 'very_verbose' : 'very_verbose_no_ansi';
            default:
                return $this->output->isDecorated() ? 'normal' : 'normal_no_ansi';
        }
    }
    /**
     * Overwrites a previous message to the output.
     */
    private function overwrite(string $message)
    {
        if ($this->output->isDecorated()) {
            $this->output->write("\r\33[2K");
            $this->output->write($message);
        } else {
            $this->output->writeln($message);
        }
    }
    private function getCurrentTimeInMilliseconds() : float
    {
        return \round(\microtime(\true) * 1000);
    }
    /**
     * @return array<string, \Closure>
     */
    private static function initPlaceholderFormatters() : array
    {
        return ['indicator' => function (self $indicator) {
            return $indicator->indicatorValues[$indicator->indicatorCurrent % \count($indicator->indicatorValues)];
        }, 'message' => function (self $indicator) {
            return $indicator->message;
        }, 'elapsed' => function (self $indicator) {
            return \ConfigTransformer202203075\Symfony\Component\Console\Helper\Helper::formatTime(\time() - $indicator->startTime);
        }, 'memory' => function () {
            return \ConfigTransformer202203075\Symfony\Component\Console\Helper\Helper::formatMemory(\memory_get_usage(\true));
        }];
    }
}

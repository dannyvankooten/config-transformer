<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202110146\Symfony\Component\Console\Helper;

/**
 * Helps outputting debug information when running an external program from a command.
 *
 * An external program can be a Process, an HTTP request, or anything else.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DebugFormatterHelper extends \ConfigTransformer202110146\Symfony\Component\Console\Helper\Helper
{
    private $colors = ['black', 'red', 'green', 'yellow', 'blue', 'magenta', 'cyan', 'white', 'default'];
    private $started = [];
    private $count = -1;
    /**
     * Starts a debug formatting session.
     *
     * @return string
     * @param string $id
     * @param string $message
     * @param string $prefix
     */
    public function start($id, $message, $prefix = 'RUN')
    {
        $this->started[$id] = ['border' => ++$this->count % \count($this->colors)];
        return \sprintf("%s<bg=blue;fg=white> %s </> <fg=blue>%s</>\n", $this->getBorder($id), $prefix, $message);
    }
    /**
     * Adds progress to a formatting session.
     *
     * @return string
     * @param string $id
     * @param string $buffer
     * @param bool $error
     * @param string $prefix
     * @param string $errorPrefix
     */
    public function progress($id, $buffer, $error = \false, $prefix = 'OUT', $errorPrefix = 'ERR')
    {
        $message = '';
        if ($error) {
            if (isset($this->started[$id]['out'])) {
                $message .= "\n";
                unset($this->started[$id]['out']);
            }
            if (!isset($this->started[$id]['err'])) {
                $message .= \sprintf('%s<bg=red;fg=white> %s </> ', $this->getBorder($id), $errorPrefix);
                $this->started[$id]['err'] = \true;
            }
            $message .= \str_replace("\n", \sprintf("\n%s<bg=red;fg=white> %s </> ", $this->getBorder($id), $errorPrefix), $buffer);
        } else {
            if (isset($this->started[$id]['err'])) {
                $message .= "\n";
                unset($this->started[$id]['err']);
            }
            if (!isset($this->started[$id]['out'])) {
                $message .= \sprintf('%s<bg=green;fg=white> %s </> ', $this->getBorder($id), $prefix);
                $this->started[$id]['out'] = \true;
            }
            $message .= \str_replace("\n", \sprintf("\n%s<bg=green;fg=white> %s </> ", $this->getBorder($id), $prefix), $buffer);
        }
        return $message;
    }
    /**
     * Stops a formatting session.
     *
     * @return string
     * @param string $id
     * @param string $message
     * @param bool $successful
     * @param string $prefix
     */
    public function stop($id, $message, $successful, $prefix = 'RES')
    {
        $trailingEOL = isset($this->started[$id]['out']) || isset($this->started[$id]['err']) ? "\n" : '';
        if ($successful) {
            return \sprintf("%s%s<bg=green;fg=white> %s </> <fg=green>%s</>\n", $trailingEOL, $this->getBorder($id), $prefix, $message);
        }
        $message = \sprintf("%s%s<bg=red;fg=white> %s </> <fg=red>%s</>\n", $trailingEOL, $this->getBorder($id), $prefix, $message);
        unset($this->started[$id]['out'], $this->started[$id]['err']);
        return $message;
    }
    private function getBorder(string $id) : string
    {
        return \sprintf('<bg=%s> </>', $this->colors[$this->started[$id]['border']]);
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'debug_formatter';
    }
}

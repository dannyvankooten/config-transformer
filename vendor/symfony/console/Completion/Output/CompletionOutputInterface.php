<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202112190\Symfony\Component\Console\Completion\Output;

use ConfigTransformer202112190\Symfony\Component\Console\Completion\CompletionSuggestions;
use ConfigTransformer202112190\Symfony\Component\Console\Output\OutputInterface;
/**
 * Transforms the {@see CompletionSuggestions} object into output readable by the shell completion.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
interface CompletionOutputInterface
{
    public function write(\ConfigTransformer202112190\Symfony\Component\Console\Completion\CompletionSuggestions $suggestions, \ConfigTransformer202112190\Symfony\Component\Console\Output\OutputInterface $output) : void;
}

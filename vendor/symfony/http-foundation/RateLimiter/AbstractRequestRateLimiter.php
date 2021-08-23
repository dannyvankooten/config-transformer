<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108231\Symfony\Component\HttpFoundation\RateLimiter;

use ConfigTransformer202108231\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202108231\Symfony\Component\RateLimiter\LimiterInterface;
use ConfigTransformer202108231\Symfony\Component\RateLimiter\Policy\NoLimiter;
use ConfigTransformer202108231\Symfony\Component\RateLimiter\RateLimit;
/**
 * An implementation of RequestRateLimiterInterface that
 * fits most use-cases.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 *
 * @experimental in 5.3
 */
abstract class AbstractRequestRateLimiter implements \ConfigTransformer202108231\Symfony\Component\HttpFoundation\RateLimiter\RequestRateLimiterInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function consume($request) : \ConfigTransformer202108231\Symfony\Component\RateLimiter\RateLimit
    {
        $limiters = $this->getLimiters($request);
        if (0 === \count($limiters)) {
            $limiters = [new \ConfigTransformer202108231\Symfony\Component\RateLimiter\Policy\NoLimiter()];
        }
        $minimalRateLimit = null;
        foreach ($limiters as $limiter) {
            $rateLimit = $limiter->consume(1);
            if (null === $minimalRateLimit || $rateLimit->getRemainingTokens() < $minimalRateLimit->getRemainingTokens()) {
                $minimalRateLimit = $rateLimit;
            }
        }
        return $minimalRateLimit;
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function reset($request) : void
    {
        foreach ($this->getLimiters($request) as $limiter) {
            $limiter->reset();
        }
    }
    /**
     * @return LimiterInterface[] a set of limiters using keys extracted from the request
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    protected abstract function getLimiters($request) : array;
}

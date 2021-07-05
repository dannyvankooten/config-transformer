<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\PackageBuilder\Php;

final class TypeChecker
{
    /**
     * @param array<class-string> $types
     */
    public function isInstanceOf($object, array $types) : bool
    {
        foreach ($types as $type) {
            if (\is_a($object, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
}

<?php

declare(strict_types=1);
/**
 * Parser Reflection API
 *
 * @copyright Copyright 2024, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\ParserReflection;

use ReflectionUnionType as BaseReflectionUnionType;

/**
 * ReflectionUnionType implementation
 */
class ReflectionUnionType extends BaseReflectionUnionType
{
    /**
     * @var ReflectionNamedType[]
     */
    private readonly array $types;

    /**
     * Initializes reflection data
     */
    public function __construct(ReflectionNamedType ...$types)
    {
        $this->types = $types;
    }

    /**
     * @inheritDoc
     */
    public function allowsNull(): bool
    {
        // Nullable if we have at least one nullable type
        foreach ($this->types as $type) {
            if ($type->allowsNull()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $stringTypes = array_map(fn(\ReflectionNamedType $namedType) => (string) $namedType, $this->types);

        // Special iterable type is already union Traversable|array, thus should be replaced
        $iterableIndex = array_search('iterable', $stringTypes, true);
        if ($iterableIndex !== false) {
            unset($stringTypes[$iterableIndex]);
            array_push($stringTypes, 'Traversable', 'array');
        }

        // PHP has own scheme of ordering of built-in types to follow
        usort($stringTypes, function(string $first, string $second): int {
            static $internalTypesOrder = ['object', 'array', 'string', 'int', 'float', 'bool', 'false', 'null'];

            $firstOrder  = array_search($first, $internalTypesOrder, true);
            $secondOrder = array_search($second, $internalTypesOrder, true);

            if ($firstOrder !== false && $secondOrder !== false) {
                return $firstOrder <=> $secondOrder;
            }
            if ($firstOrder !== false && $secondOrder === false) {
                return 1;
            }
            if ($firstOrder === false && $secondOrder !== false) {
                return -1;
            }

            return 0;
        });

        return join('|', $stringTypes);
    }

    /**
     * @inheritDoc
     */
    public function getTypes(): array
    {
        return $this->types;
    }
}
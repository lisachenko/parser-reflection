<?php
/**
 * Parser Reflection API
 *
 * @copyright Copyright 2015, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\ParserReflection;

use ReflectionExtension as InternalReflectionExtension;

/**
 * Returns AST-based reflections from extensions.
 */
class ReflectionExtension extends InternalReflectionExtension implements IReflector
{
    /**
     * Has extension been loaded by PHP.
     *
     * @return true
     *     Enabled extensions are always loaded.
     */
    public function wasIncluded()
    {
        return true;
    }
}

<?php
/**
 * Parser Reflection API
 *
 * @copyright Copyright 2015, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * This file is for polyfilling classes not defined in all supported
 * versions of PHP, (i.e. PHP < 7).
 */

if (!class_exists(ReflectionClassConstant::class, false)) {
    // php version < 7.1
    class ReflectionClassConstant
    {
        public function getDeclaringClass()
        {
            return null;
        }

        public function getDocComment()
        {
            return '';
        }

        public function getModifiers()
        {
            return 0;
        }

        public function getName()
        {
            return '';
        }

        public function getValue()
        {
            return null;
        }

        public function isPrivate()
        {
            return false;
        }

        public function isProtected()
        {
            return false;
        }

        public function isPublic()
        {
            return true;
        }

        public function __toString()
        {
            return '';
        }
    }
}
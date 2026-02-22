<?php

/**
 * PHPActor stub file for Silverstripe global functions
 *
 * This file is not executed - it only provides type information to PHPActor
 * for Silverstripe's global helper functions that are defined in
 * vendor/silverstripe/framework/src/includes/functions.php
 */

/**
 * Main translator function. Returns the string defined by $entity according to the
 * currently set locale.
 *
 * Also supports pluralisation of strings. Pass in a `count` argument, as well as a
 * default value with `|` pipe-delimited options for each plural form.
 *
 * @param string $entity Entity that identifies the string. It must be in the form
 * "Namespace.Entity" where Namespace will be usually the class name where this
 * string is used and Entity identifies the string inside the namespace.
 * Example: _t(self::class . '.Title', 'Title')
 * Use self::class for better IDE support and consistency.
 * @param string|array|null ...$arg Additional arguments are parsed as such:
 *  - Next string argument is a default. Pass in a `|` pipe-delimeted value with `{count}`
 *    to do pluralisation.
 *  - Any other string argument after default is context for i18nTextCollector
 *  - Any array argument in any order is an injection parameter list. Pass in a `count`
 *    injection parameter to pluralise.
 * @return string
 */
function _t(string $entity, ...$arg): string {}

/**
 * Creates a class instance by the "singleton" design pattern.
 * It will always return the same instance for this class.
 *
 * @template T of object
 * @param class-string<T> $className
 * @return T
 */
function singleton(string $className): object {}

/**
 * Get the project name from the manifest config
 *
 * @return string|null
 */
function project(): ?string {}

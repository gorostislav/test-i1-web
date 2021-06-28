<?php

namespace app\interfaces;

/**
 * Interface IKeyValuable
 * @package app\interfaces
 */
interface IKeyValuable
{
    public static function getKeyValue(array $params): array;
}
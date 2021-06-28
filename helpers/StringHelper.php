<?php

namespace app\helpers;

use yii\helpers\BaseStringHelper;

/**
 * Class StringHelper
 * @package app\helpers
 */
class StringHelper extends BaseStringHelper
{
    /**
     * Форматирование строки переданным массивом, параметры в строке указываются через {}
     * @param string $string
     * @param array $params
     * @return string
     */
    public static function formatStringWithParams(string $string, array $params = []): string
    {
        $placeholders = [];

        foreach ($params as $name => $value) {
            $placeholders['{' . $name . '}'] = $value;
        }

        return ($placeholders === []) ? $string : strtr($string, $placeholders);
    }
}
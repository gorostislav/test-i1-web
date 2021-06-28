<?php

namespace app\traits;

use yii\helpers\ArrayHelper;

trait KeyValueTrait
{
    /**
     * @param array $params
     * @return array
     */
    public static function getKeyValue(array $params): array
    {
        $data = self::find()->select($params)->all();

        return ArrayHelper::map($data, $params[0], $params[1], ($params[2] ?? null));
    }
}
<?php

namespace app\traits;

trait RandomRecordTrait
{
    /**
     * Получение случайной записи для модели
     * @return static
     */
    public static function getRandom()
    {
        return self::find()->orderBy(['rand()' => SORT_DESC])->one();
    }
}
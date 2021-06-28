<?php

namespace app\interfaces;

use yii\db\ActiveRecord;

interface IRandomRecordable
{
    /**
     * @return self|ActiveRecord
     */
    public static function getRandom();
}
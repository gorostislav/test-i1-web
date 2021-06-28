<?php

namespace app\models;

use app\interfaces\IKeyValuable;
use app\interfaces\IRandomRecordable;
use app\traits\KeyValueTrait;
use app\traits\RandomRecordTrait;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "drive".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Car[] $cars
 */
class Drive extends \yii\db\ActiveRecord implements IRandomRecordable, IKeyValuable
{
    use RandomRecordTrait, KeyValueTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'drive';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Cars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCars(): ActiveQuery
    {
        return $this->hasMany(Car::class, ['drive_id' => 'id']);
    }
}

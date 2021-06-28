<?php

namespace app\models;

use app\interfaces\IRandomRecordable;
use app\traits\RandomRecordTrait;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Car[] $cars
 * @property Model[] $models
 */
class Brand extends \yii\db\ActiveRecord implements IRandomRecordable
{
    use RandomRecordTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'brand';
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
        return $this->hasMany(Car::class, ['brand_id' => 'id']);
    }

    /**
     * Gets query for [[Models]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModels(): ActiveQuery
    {
        return $this->hasMany(Model::class, ['brand_id' => 'id']);
    }
}

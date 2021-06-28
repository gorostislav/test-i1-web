<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "car".
 *
 * @property int $id
 * @property int $brand_id
 * @property int $model_id
 * @property int $engine_id
 * @property int $drive_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Brand $brand
 * @property Drive $drive
 * @property Engine $engine
 * @property Model $model
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'car';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['brand_id', 'model_id', 'engine_id', 'drive_id'], 'required'],
            [['brand_id', 'model_id', 'engine_id', 'drive_id', 'created_at', 'updated_at'], 'integer'],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::class, 'targetAttribute' => ['brand_id' => 'id']],
            [['drive_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drive::class, 'targetAttribute' => ['drive_id' => 'id']],
            [['engine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Engine::class, 'targetAttribute' => ['engine_id' => 'id']],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Model::class, 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Марка',
            'model_id' => 'Model ID',
            'engine_id' => 'Engine ID',
            'drive_id' => 'Drive ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[Drive]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrive(): ActiveQuery
    {
        return $this->hasOne(Drive::class, ['id' => 'drive_id']);
    }

    /**
     * Gets query for [[Engine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEngine(): ActiveQuery
    {
        return $this->hasOne(Engine::class, ['id' => 'engine_id']);
    }

    /**
     * Gets query for [[Model]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModel(): ActiveQuery
    {
        return $this->hasOne(Model::class, ['id' => 'model_id']);
    }
}

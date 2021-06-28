<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "model".
 *
 * @property int $id
 * @property int $brand_id
 * @property string $name
 * @property string $slug
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Car[] $cars
 * @property Brand $brand
 */
class Model extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'model';
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
            [['brand_id', 'name'], 'required'],
            [['brand_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::class, 'targetAttribute' => ['brand_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
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
        return $this->hasMany(Car::class, ['model_id' => 'id']);
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
     * Случайная модель для переданного бренда
     * @param Brand $brand
     * @return Model
     */
    public static function getRandomRecordByBrand(Brand $brand): Model
    {
        return self::find()->where([
            'brand_id' => $brand->id
        ])->orderBy(['rand()' => SORT_DESC])->one();
    }

    /**
     * Список моделей с брендами
     * @return array
     */
    public static function getWithBrandsForDropdown(): array
    {
        $data =  self::find()->joinWith('brand')->select([
            'model.name as modelName', 'model.slug as modelSlug',
            'brand.name as brandName', 'brand.slug as brandSlug'
        ])->asArray()->all();

        return [
            'models' => ArrayHelper::map($data, 'modelSlug', 'modelName', 'brandName'),
            'brands' => ArrayHelper::map($data, 'brandSlug', 'brandName'),
        ];
    }
}

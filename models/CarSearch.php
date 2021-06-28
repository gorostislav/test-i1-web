<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * CarSearch represents the model behind the search form of `app\models\Car`.
 */
class CarSearch extends Car
{
    public $brand;
    public $model;
    public $drive;
    public $engine;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['brand', 'model', 'drive', 'engine'], 'string'],
            [['engine_id', 'drive_id'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @param array $params
     * @param string|null $formName
     * @return ActiveDataProvider
     */
    public function search(array $params = [], string $formName = null): ActiveDataProvider
    {
        $query = Car::find();
        $query->joinWith(['brand', 'model', 'drive', 'engine']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
                'route' => '/catalog',
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'brand.slug', $this->brand])
            ->andFilterWhere(['like', 'model.slug', $this->model])
            ->andFilterWhere(['like', 'drive.slug', $this->drive])
            ->andFilterWhere(['like', 'engine.slug', $this->engine]);

        return $dataProvider;
    }
}
<?php

namespace app\controllers;

use app\models\CarSearch;
use app\models\Drive;
use app\models\Engine;
use app\models\Model;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => 'yii\filters\AjaxFilter',
                'only' => ['load-cars']
            ],
        ];
    }

    /**
     * @param string|null $brand
     * @param string|null $model
     * @return string
     */
    public function actionIndex(?string $brand = null, ?string $model = null): string
    {
        Yii::$app->request->enableCsrfValidation = false;

        $searchModel = new CarSearch();
        $searchModel->setAttributes([
            'brand' => $brand,
            'model' => $model
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->get(), '');
        $modelsWithBrand = Model::getWithBrandsForDropdown();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'brands' => $modelsWithBrand['brands'],
            'models' => $modelsWithBrand['models'],
            'drives' => Drive::getKeyValue(['slug', 'name']),
            'engines' => Engine::getKeyValue(['slug', 'name']),
            'currentPage' => Yii::$app->request->get('page')
        ]);
    }

    /**
     * Список отфильтрованных автомобилей
     * Доступен только по ajax
     * @return string
     */
    public function actionLoadCars(): string
    {
        $searchModel = new CarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), '');

        return $this->renderPartial('_car-list', [
            'dataProvider' => $dataProvider,
            'title' => 'Продажа новых автомобилей {brand} {model} в Санкт-Петербурге',
        ]);
    }
}

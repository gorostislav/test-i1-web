<?php

/* @var $this yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $searchModel \app\models\CarSearch */
/** @var $brandsWithModels \app\models\Brand[]  */
/** @var $brands array */
/** @var $models array */
/** @var $drives array */
/** @var $engines array */
/** @var $currentPage string|null */

use app\helpers\StringHelper;
use app\models\Car;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\CarsFilterAsset::register($this);

$this->title = StringHelper::formatStringWithParams('Продажа новых автомобилей {brand} {model} в Санкт-Петербурге', [
    'brand' => $brands[$searchModel->brand] ?? null ,
    'model' => $models[$brands[$searchModel->brand]][$searchModel->model] ?? null
]);
?>
<div class="navbar navbar-default visible-xs">
    <div class="container-fluid">
        <button class="btn btn-default navbar-btn" data-toggle="collapse" data-target="#filter-sidebar">
            <i class="fa fa-tasks"></i> Toggle Sidebar
        </button>
    </div>
</div>

<div class="container-fluid">

    <div class="row">

        <!-- filter sidebar -->
        <div id="filter-sidebar" class="col-xs-6 col-sm-3 visible-sm visible-md visible-lg collapse sliding-sidebar">
            <?php $form = ActiveForm::begin(['id' => 'car-filter', 'action' => Url::to(['/site/load-cars'])]) ?>

            <div>
                <h4 data-toggle="collapse" data-target="#group-brand">Марка</h4>
                <div id="group-brand" class="list-group collapse in">
                    <?= Html::dropDownList('brand', $searchModel->brand, $brands, [
                        'prompt' => '',
                        'class' => 'form-control'
                    ]) ?>
                </div>
            </div>

            <div>
                <h4 data-toggle="collapse" data-target="#group-brand">Модель</h4>
                <div id="group-brand" class="list-group collapse in">
                    <?= Html::dropDownList('model', $searchModel->model, $models, [
                        'prompt' => '',
                        'disabled' => !$searchModel->brand,
                        'class' => 'form-control'
                    ]) ?>
                </div>
            </div>

            <div>
                <h4 data-toggle="collapse" data-target="#group-brand">Привод</h4>
                <div id="group-brand" class="list-group collapse in">
                    <div class="form-group">
                        <?= Html::dropDownList('drive', $searchModel->drive, $drives, [
                            'prompt' => '',
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                </div>
            </div>

            <div>
                <h4 data-toggle="collapse" data-target="#group-brand">Двигатель</h4>
                <div id="group-brand" class="list-group collapse in">
                    <?= Html::dropDownList('engine', $searchModel->engine, $engines, [
                        'prompt' => '',
                        'class' => 'form-control'
                    ]) ?>
                </div>
            </div>

            <?= Html::hiddenInput('page', $currentPage) ?>

            <?php ActiveForm::end() ?>
        </div>

        <!-- table container -->
        <div class="col-sm-9" id="car-list-block">

            <?= $this->render('_car-list', [
                'dataProvider' => $dataProvider,
                'title' => $this->title
            ]) ?>

        </div>

    </div>
</div>
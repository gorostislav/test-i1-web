<?php
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $title string */

use app\models\Car;
use yii\grid\GridView;
?>
<h4 class="car-list-title"><?= $title ?></h4>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'columns' => [
        [
            'label' => 'Марка',
            'value' => function (Car $model) {
                return $model->brand->name;
            }
        ],
        [
            'label' => 'Модель',
            'value' => function (Car $model) {
                return $model->model->name;
            }
        ],
        [
            'label' => 'Двигатель',
            'value' => function (Car $model) {
                return $model->engine->name;
            }
        ],
        [
            'label' => 'Привод',
            'value' => function (Car $model) {
                return $model->drive->name;
            }
        ],
    ],
]) ?>
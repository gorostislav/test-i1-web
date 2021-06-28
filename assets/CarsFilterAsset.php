<?php

namespace app\assets;

use yii\web\AssetBundle;

class CarsFilterAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/cars-filter.js',
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];
}

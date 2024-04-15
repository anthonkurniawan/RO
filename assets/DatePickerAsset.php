<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class DatePickerAsset extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@bower/bootstrap-datepicker/dist';
    public $css = ['css/bootstrap-datepicker3.min.css'];
    public $js = ['js/bootstrap-datepicker.min.js'];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}


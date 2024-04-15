<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

class SelectizeAsset extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@npm/selectize/dist';
    public $css = ['css/selectize.bootstrap3.css'];
    public $js = ['js/standalone/selectize.min.js'];
    //public $js = ['js/selectize.js'];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}


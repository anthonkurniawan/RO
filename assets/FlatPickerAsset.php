<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class FlatPickerAsset extends AssetBundle
{
    public $sourcePath = '@npm/flatpickr/dist';
    public $css = ['flatpickr.min.css'];
    public $js = ['flatpickr.min.js'];
}


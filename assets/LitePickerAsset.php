<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class LitePickerAsset extends AssetBundle
{
    public $sourcePath = '@npm/litepicker/dist';
    public $css = ['css/litepicker.css'];
    public $js = ['litepicker.js'];
}


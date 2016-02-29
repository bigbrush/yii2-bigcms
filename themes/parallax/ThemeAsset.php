<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace app\themes\parallax;

use yii\web\AssetBundle;

/**
 * ThemeAsset
 */
class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/parallax/assets';
    public $publishOptions = ['forceCopy' => true];
    public $css = [
        '//fonts.googleapis.com/icon?family=Material+Icons',
        'css/materialize.css',
        'css/style.css',
    ];
    public $js = [
        'js/materialize.js',
        'js/init.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

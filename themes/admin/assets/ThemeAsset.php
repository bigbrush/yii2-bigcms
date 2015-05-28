<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace app\themes\admin\assets;

use yii\web\AssetBundle;

/**
 * ThemeAsset
 */
class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/admin';
    public $publishOptions = ['forceCopy' => true];
    public $css = [
        // '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        'font-awesome-4.3.0/css/font-awesome.min.css',
        'css/simple-sidebar.css',
        'css/theme.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
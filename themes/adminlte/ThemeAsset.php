<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace app\themes\adminlte;

use yii\web\AssetBundle;

/**
 * ThemeAsset
 */
class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/adminlte/assets';
    public $css = [
        'css/theme.css',
    ];
    // public $publishOptions = [
    //     'forceCopy' => true,
    //     'only' => [
    //         'css/theme.css'
    //     ]
    // ];
}

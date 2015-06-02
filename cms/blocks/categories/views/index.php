<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use cms\modules\pages\components\Route;
?>
<div class="block pages-categories">
    <?php if ($model->showTitle) : ?>
    <h3><?= $model->title ?></h3>
    <?php endif; ?>
    <ul>
    <?php foreach ($models as $model) : ?>
        <li><?= Html::a($model['title'], Route::page($model, '/')) ?></li>
    <?php endforeach; ?>
    </ul>
</div>
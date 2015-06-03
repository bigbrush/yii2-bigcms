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
    <?php if ($block->showTitle) : ?>
    <h3><?= $block->title ?></h3>
    <?php endif; ?>
    <ul>
    <?php foreach ($pages as $page) : ?>
        <li><?= Html::a($page['title'], Route::page($page, '/')) ?></li>
    <?php endforeach; ?>
    </ul>
</div>
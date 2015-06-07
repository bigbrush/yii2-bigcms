<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model big\models\Block */
?>
<div class="block menu">
    <?php if ($block->showTitle) : ?>
    <h3><?= $block->title ?></h3>
    <?php endif; ?>
    <?php NavBar::begin($navbarOptions) ?>
    <?= Nav::widget([
        'items' => $items,
        'options' => $options,
    ]) ?>
    <?php NavBar::end() ?>
</div>
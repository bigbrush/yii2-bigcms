<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model big\models\Block */
?>
<div class="block menu">
    <?php if ($model->showTitle) : ?>
    <h3><?= $model->title ?></h3>
    <?php endif; ?>
    <?= Nav::widget([
        'items' => $items,
        'options' => empty($model->class) ? [] : ['class' => $model->class],
    ]) ?>
</div>
<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

/* @var $this yii\web\View */
/* @var $model big\models\Block */
?>
<div class="block contact">
    <?php if ($model->showTitle) : ?>
    <h3><?= $model->title ?></h3>
    <?php endif; ?>
    <?= $model->content ?>
</div>
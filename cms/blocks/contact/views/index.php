<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var yii\web\View $this */
/* @var cms\blocks\contact\Block $block */
/* @var cms\blocks\contact\models\ContactForm $model */
?>
<div class="block contact">
    <?php if ($block->showTitle) : ?>
    <h3><?= Html::encode($block->title) ?></h3>
    <?php endif; ?>

    <?php $form = ActiveForm::begin() ?>
        <?php
        if ($block->model->getField('name', 'show')) {
            echo $form->field($model, 'name');
        }
        if ($block->model->getField('email', 'show')) {
            echo $form->field($model, 'email');
        }
        if ($block->model->getField('phone', 'show')) {
            echo $form->field($model, 'phone');
        }
        if ($block->model->getField('message', 'show')) {
            echo $form->field($model, 'message')->textArea();
        }
        ?>
        <div class="form-group">
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end() ?>
</div>
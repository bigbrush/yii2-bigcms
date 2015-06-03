<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model big\models\Block */
?>
<div class="block contact">
    <?php if ($block->showTitle) : ?>
    <h3><?= Html::encode($block->title) ?></h3>
    <?php endif; ?>

    <?php $form = ActiveForm::begin() ?>
        <?php
        if ($block->model->showName) {
            echo $form->field($contactModel, 'name');
        }
        if ($block->model->showEmail) {
            echo $form->field($contactModel, 'email');
        }
        if ($block->model->showPhone) {
            echo $form->field($contactModel, 'phone');
        }
        if ($block->model->showMessage) {
            echo $form->field($contactModel, 'message')->textArea();
        }
        ?>
        <div class="form-group">
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end() ?>
</div>
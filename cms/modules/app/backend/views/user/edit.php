<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$action = $model->id ? 'Edit' : 'Create';
$this->title = Yii::$app->id . ' | ' . $action . ' user';
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
            <?php Yii::$app->toolbar->save()->back(); ?>
            <h1><?= $action ?> user</h1>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'email')->input('email') ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'phone') ?>
            <?= $form->field($model, 'state')->dropDownList($model->getStateOptions()) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
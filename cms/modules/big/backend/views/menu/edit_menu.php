<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$action = $model->id ? 'Edit' : 'Create';
$this->title = Yii::$app->id . ' | ' . $action . ' menu';
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
            <?php Yii::$app->toolbar->save()->saveStay()->back('Back', ['menus']); ?>
            <h1><?= $action ?> menu</h1>
            <?= $form->field($model, 'title') ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
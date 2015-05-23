<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
            <?php Yii::$app->toolbar->save()->saveStay()->back(); ?>
            <h1><?= $model->id ? 'Edit' : 'Create' ?> block</h1>

            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'title') ?>
                    <?= $form->field($model, 'menu_id')->label('Select menu')->dropDownList($dropDownList) ?>
                    <?= $form->field($model, 'class')->label('Menu class') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'show_title')->dropDownList(['No', 'Yes']) ?>
                </div>
            </div>
            
        <?php ActiveForm::end(); ?>
    </div>
</div>
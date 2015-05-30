<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use bigbrush\big\widgets\editor\Editor;

$type = Yii::t('cms', 'block');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
            <?php Yii::$app->toolbar->save()->saveStay()->back(); ?>
            <h1><?= $title ?></h1>

            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'title') ?>
                    <?= $form->field($model, 'content')->widget(Editor::className()) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'show_title')->dropDownList(['No', 'Yes']) ?>
                </div>
            </div>
            
        <?php ActiveForm::end(); ?>
    </div>
</div>
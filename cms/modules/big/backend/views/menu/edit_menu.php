<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$type = Yii::t('cms', 'menu');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = $title;
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
            <?php Yii::$app->toolbar->save()->saveStay()->back('Back', ['menus']); ?>
            <h1><?= $title ?></h1>
            <?= $form->field($model, 'title', ['inputOptions' => ['class'  =>'form-control input-lg']]) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
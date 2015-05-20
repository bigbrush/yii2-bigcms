<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use bigbrush\big\widgets\templateeditor\TemplateEditor;

$action = $model->id ? 'Edit' : 'Create';
$this->title = Yii::$app->id . ' | ' . $action . ' template';
?>
<?php $form = ActiveForm::begin(); ?>
<?php Yii::$app->toolbar->save()->back(); ?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $action ?> template</h1>
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'is_default')->dropDownList(['No', 'Yes']) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php TemplateEditor::begin(['template' => $model]); ?>
    </div>
</div>
<div class="row">
    <?php TemplateEditor::end(); ?>
</div>
<?php ActiveForm::end(); ?>
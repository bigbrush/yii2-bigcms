<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\ActiveForm;
use bigbrush\big\widgets\templateeditor\TemplateEditor;

$type = Yii::t('cms', 'template');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = $title;
?>
<?php $form = ActiveForm::begin(); ?>
    
    <?php Yii::$app->toolbar->save()->saveStay()->back(); ?>
    
    <div class="row">
        <div class="col-md-12">
            <h1><?= $title ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <?= $form->field($model, 'title', ['inputOptions' => ['class' => 'form-control input-lg']]) ?>
        </div>
        <div class="col-md-3">
            <?php
            /**
             * The default template can not be changed.
             */
            if ($model->is_default) {
                echo $form->field($model, 'is_default', ['inputOptions' => ['disabled' => 'disabled']])->dropDownList(['No', 'Yes']);
            } else {
                echo $form->field($model, 'is_default')->dropDownList(['No', 'Yes']);
            }
            ?>
        </div>
    </div>

    <?= TemplateEditor::widget([
        'model' => $model,
    ]) ?>
    
<?php ActiveForm::end(); ?>
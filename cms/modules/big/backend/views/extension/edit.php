<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use bigbrush\cms\widgets\Editor;

$type = Yii::t('cms', 'extension');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Install {0}', $type);
$this->title = $title;
?>
<?php $form = ActiveForm::begin(); ?>
    
    <?php Yii::$app->toolbar->save()->saveStay()->back(); ?>
    
    <h1><?= $title ?></h1>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name', ['inputOptions' => ['class'  =>'form-control input-lg']]) ?>
            <?= $form->field($model, 'namespace') ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'state')->dropDownList($model->getStateOptions()) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'type')->input('text', [
                'disabled' => 'disabled',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'description')->widget(Editor::className()) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
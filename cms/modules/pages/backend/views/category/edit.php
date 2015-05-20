<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use bigbrush\big\widgets\editor\Editor;

$action = $model->id ? 'Edit' : 'Create';
$this->title = Yii::$app->id . ' | ' . $action . ' category';
?>
<?php
$form = ActiveForm::begin();

Yii::$app->toolbar->save()->back();
?>

    <h1><?= $action ?> category</h1>
    
    <div class="row">
        <div class="col-md-9">
        
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'title') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'parent_id')->dropDownList($parents) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'state')->dropDownList($model->getStateOptions()) ?>
                </div>
            </div>
            
            <?= $form->field($model, 'content')->widget(Editor::className()) ?>

        </div>
        <div class="col-md-3">
            <h3>Page SEO</h3>
            <?= $form->field($model, 'meta_title') ?>
            <?= $form->field($model, 'meta_description')->textArea() ?>
            <?= $form->field($model, 'alias') ?>
            <?= $form->field($model, 'meta_keywords') ?>
        </div>
    </div>
    

<?php $form = ActiveForm::end(); ?>
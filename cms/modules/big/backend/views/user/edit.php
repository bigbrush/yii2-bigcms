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
<?php $form = ActiveForm::begin(); ?>
    
    <?php Yii::$app->toolbar->save()->saveStay()->back(); ?>
    
    <h1><?= $action ?> user</h1>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email')->input('email') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'phone') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'state')->dropDownList($model->getStateOptions()) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
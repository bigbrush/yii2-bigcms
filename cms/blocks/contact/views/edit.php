<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use cms\widgets\RadioButtonGroup;
use yii\bootstrap\Modal;
use bigbrush\big\widgets\bigsearch\BigSearch;

$this->registerJs('$("#btn-select-content").click(function(e){
    e.preventDefault();
});');

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
                    <?= $form->field($model, 'receiver')->label(Yii::t('cms', 'Receiver')) ?>

                    <h3><?= Yii::t('cms', 'Contact form fields') ?></h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><?= Yii::t('cms', 'Choose which form fields to display') ?></strong></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'showEmail')->widget(RadioButtonGroup::className())->label(Yii::t('cms', 'Show email')) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'showName')->widget(RadioButtonGroup::className())->label(Yii::t('cms', 'Show name')) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'showPhone')->widget(RadioButtonGroup::className())->label(Yii::t('cms', 'Show phone')) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'showMessage')->widget(RadioButtonGroup::className())->label(Yii::t('cms', 'Show message')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p><strong><?= Yii::t('cms', 'Message after a successful form submission') ?></strong></p>
                            <?= $form->field($model, 'successMessage')->textArea()->label(false) ?>
                            <p><strong><?= Yii::t('cms', 'Where to go after form is submitted') ?></strong></p>
                            <?= $form->field($model, 'redirectTo', [
                                'template' => '
                                    {label}
                                    <div class="form-group">
                                        {error}
                                        <div class="input-group">
                                            {input}
                                            <span class="input-group-btn">
                                                <button id="btn-select-content" class="btn btn-info btn-block" data-toggle="modal" data-target="#content-modal">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    '
                            ])->label(false); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'show_title')->dropDownList(['No', 'Yes']) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('cms', 'Select content') . '</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">' . Yii::t('cms', 'Close') . '</button>',
    'id' => 'content-modal',
    'size' => Modal::SIZE_LARGE,
]); ?>

<?= BigSearch::widget([
    'dynamicUrls' => true,
    'onClickCallback' => 'function(e){
        e.preventDefault();
        var route = $(this).data("route");
        $("#content-modal").on("hidden.bs.modal", function(){
            $("#block-redirectto").val(route);
        }).modal("hide");
    }',
]); ?>

<?php Modal::end(); ?>
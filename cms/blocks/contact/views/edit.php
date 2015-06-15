<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use bigbrush\big\widgets\bigsearch\BigSearch;
use bigbrush\cms\widgets\RadioButtonGroup;

// prevent form submission when modal button is clicked
$this->registerJs('$("#btn-select-content").click(function(e){
    e.preventDefault();
});');
?>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'receiver')->label(Yii::t('cms', 'Receiver')) ?>

        <div class="row">
            <div class="col-md-6">
                <h3><?= Yii::t('cms', 'Contact form fields') ?></h3>

                <?= $this->render('_button_panel', [
                    'form' => $form,
                    'model' => $model,
                    'field' => 'name',
                    'header' => Yii::t('cms', 'Name'),
                ]); ?>
                
                <?= $this->render('_button_panel', [
                    'form' => $form,
                    'model' => $model,
                    'field' => 'email',
                    'header' => Yii::t('cms', 'Email'),
                ]); ?>
                
                <?= $this->render('_button_panel', [
                    'form' => $form,
                    'model' => $model,
                    'field' => 'phone',
                    'header' => Yii::t('cms', 'Phone'),
                ]); ?>
                
                <?= $this->render('_button_panel', [
                    'form' => $form,
                    'model' => $model,
                    'field' => 'message',
                    'header' => Yii::t('cms', 'Message'),
                ]); ?>
                
            </div>

            <div class="col-md-6">
                <h3><?= Yii::t('cms', 'Confirmation') ?></h3>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?= Yii::t('cms', 'Success message') ?></strong>
                    </div>
                    <div class="panel-body">
                        <?= $form->field($model, 'successMessage')->textArea()->label(false) ?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?= Yii::t('cms', 'Confirmation page') ?></strong>
                    </div>
                    <div class="panel-body">
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

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?= Yii::t('cms', 'Note') ?></strong>
                        <?= Yii::t('cms', 'Success message is only used when no confirmation page is selected.') ?>
                    </div>
                </div>
            </div>
        </div>
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
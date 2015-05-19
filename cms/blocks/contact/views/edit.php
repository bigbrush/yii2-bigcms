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
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
            <?php Yii::$app->toolbar->save()->back(); ?>
            <h1>Edit block</h1>

            <div class="row">
                <div class="col-md-9">
                    <?= $form->field($model, 'title') ?>
                    <?= $form->field($model, 'receiver') ?>

                    <h3>Contact form fields</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Choose which form fields to display</strong></p>
                            <?= $form->field($model, 'showEmail')->widget(RadioButtonGroup::className()) ?>
                            <?= $form->field($model, 'showName')->widget(RadioButtonGroup::className()) ?>
                            <?= $form->field($model, 'showPhone')->widget(RadioButtonGroup::className()) ?>
                            <?= $form->field($model, 'showMessage')->widget(RadioButtonGroup::className()) ?>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Message after a successful form submission</strong></p>
                            <?= $form->field($model, 'successMessage')->textArea()->label(false) ?>
                            <p><strong>Where to go after form is submitted.</strong></p>
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
    'header' => '<h4>Select content</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
    'id' => 'content-modal',
    'size' => Modal::SIZE_LARGE,
]); ?>

<?= BigSearch::widget([
    'dynamicUrls' => true,
    'linkClickCallback' => 'function(e){
        e.preventDefault();
        var route = $(this).data("route");
        $("#content-modal").on("hidden.bs.modal", function(){
            $("#block-redirectto").val(route);
        }).modal("hide");
    }',
]); ?>

<?php Modal::end(); ?>
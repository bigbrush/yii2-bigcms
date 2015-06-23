<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use bigbrush\big\widgets\bigsearch\BigSearch;

$this->registerJs('$("#btn-select-content").click(function(e){
    e.preventDefault();
});');

$type = Yii::t('cms', 'menu item');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = $title;
?>
<?php $form = ActiveForm::begin(); ?>
    <?php Yii::$app->toolbar->save()->saveStay()->back(); ?>

    <div class="row">
        <div class="col-md-9">
            <h1><?= $title ?></h1>
            
            <?= $form->field($model, 'title', ['inputOptions' => ['class'  =>'form-control input-lg']]) ?>
            <?= $form->field($model, 'route', [
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
            ]); ?>
            <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($model, 'menu_id')->dropDownList($menus) ?>
                </div>
                <div class="col-md-6">
                    <?php if ($model->menu_id) : ?>
                    <?= $form->field($model, 'parent_id')->dropDownList($parents) ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'state')->dropDownList($model->getStateOptions()) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'is_default')->dropDownList($model->getIsDefaultOptions()) ?>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <h3>Menu SEO</h3>
            <?= $form->field($model, 'meta_title') ?>
            <?= $form->field($model, 'meta_description')->textArea() ?>
            <?= $form->field($model, 'alias') ?>
            <?= $form->field($model, 'meta_keywords') ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('cms', 'Select content') . '</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">' . Yii::t('cms', 'Close') . '</button>',
    'id' => 'content-modal',
    'size' => Modal::SIZE_LARGE,
]); ?>

<?= BigSearch::widget([
    'onClickCallback' => 'function(e){
        e.preventDefault();
        var route = $(this).data("route");
        $("#content-modal").on("hidden.bs.modal", function(){
            $("#menu-route").val(route);
        }).modal("hide");
    }',
    /**
     * TODO
     * implement linking to files from menus.
     */
    // 'fileManager' => [
    //     'onClickCallback' => 'function(file){
    //         var baseUrl = "' . Url::to('@web/../') . '";
    //         var url = file.url.slice(baseUrl.length);
    //         $("#content-modal").on("hidden.bs.modal", function(){
    //             $("#menu-route").val(url);
    //         }).modal("hide");
    //     }',
    // ],
]); ?>

<?php Modal::end(); ?>
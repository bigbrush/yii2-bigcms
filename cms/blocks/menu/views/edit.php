<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Url;
use yii\helpers\Json;
use yii\bootstrap\Modal;
use bigbrush\big\widgets\filemanager\FileManager;

// prevent form submission when filemanger model button is clicked
// and active block brand field when "block-type" field changes
$this->registerJs('
    $("#btn-select-content").click(function(e){
        e.preventDefault();
    });

    $("#block-type").change(function(e){
        var types = ' . Json::encode($model->getNavbarTypes()) . ';
        var selected = $(this).val();
        if ($.inArray(selected, types) !== -1) {
            $("#block-brand-wrapper").show();
        } else {
            $("#block-brand-wrapper").hide();
        }
    });
');
?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'menu_id')->label(Yii::t('cms', 'Select menu'))->dropDownList($menusDropDown) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions())->label(Yii::t('cms', 'Menu type')) ?>
    </div>
    <div class="col-md-4">
        <?php if ($isNavbar) : ?>
        <div id="block-brand-wrapper">
        <?php else : ?>
        <div id="block-brand-wrapper" style="display:none;">
        <?php endif ?>
        <?= $form->field($model, 'brand', [
                'template' => '
                    {label}
                    <div class="form-group">
                        <div class="input-group">
                            {input}
                            <span class="input-group-btn">
                                <button id="btn-select-content" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal-wrapper">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                    '
            ])->label(Yii::t('cms', 'Brand')) ?>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('cms', 'Select image') . '</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">' . Yii::t('cms', 'Close') . '</button>',
    'id' => 'modal-wrapper',
    'size' => Modal::SIZE_LARGE,
]); ?>

<?= FileManager::widget([
    'onClickCallback' => 'function(file){
        var url = "image:" + file.url;
        $("#modal-wrapper").on("hidden.bs.modal", function(){
            $("#block-brand").val(url);
        }).modal("hide");
    }'
]); ?>

<?php Modal::end(); ?>
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
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><?= Yii::t('cms', 'Select menu') ?></strong>
            </div>
            <div class="panel-body">
                <?= $form->field($model, 'menu_id')->label(false)->dropDownList($menusDropDown) ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><?= Yii::t('cms', 'Menu type') ?></strong>
            </div>
            <div class="panel-body">
                <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions())->label(false) ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if ($isNavbar) : ?>
        <div id="block-brand-wrapper">
        <?php else : ?>
        <div id="block-brand-wrapper" style="display:none;">
        <?php endif ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><?= Yii::t('cms', 'Brand') ?></strong>
                </div>
                <div class="panel-body">

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
                    ])->label(false) ?>
                </div>

            </div>
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
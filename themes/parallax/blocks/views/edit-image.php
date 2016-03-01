<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\Modal;
use bigbrush\big\widgets\filemanager\FileManager;
use bigbrush\cms\widgets\Editor;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= Yii::t('cms', 'Image') ?></strong>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'content[image]', [
                        'template' => '
                            {label}
                            <div class="form-group">
                                <div class="input-group">
                                    {input}
                                    <span class="input-group-btn">
                                        <button type="button" id="btn-select-image" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal">
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

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= Yii::t('cms', 'Content') ?></strong>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'content[text]')->widget(Editor::className(), ['useReadMore' => false])->label(false) ?>
            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('cms', 'Select image') . '</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">' . Yii::t('cms', 'Close') . '</button>',
    'id' => 'modal',
    'size' => Modal::SIZE_LARGE,
]); ?>

<?= FileManager::widget([
    'onClickCallback' => 'function(file){
        $("#modal").on("hidden.bs.modal", function(){
            $("#block-content-image").val(file.url);
        }).modal("hide");
    }'
]); ?>

<?php Modal::end(); ?>

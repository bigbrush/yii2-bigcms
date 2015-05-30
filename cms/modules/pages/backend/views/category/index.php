<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;

$this->registerJs('
    $(".changeDirectionBtn").click(function(){
        var self = $(this);
        $("#field-direction").val(self.data("direction"));
        $("#field-id").val(self.data("pid"));
    });
    $(".delete-form .btn").click(function(e){
        if (confirm("Are you sure to delete this category?")) {
            return true;
        }
        return false;
    });
');

Yii::$app->toolbar->add()->add(Yii::t('cms', 'Pages'), ['page/index'], 'file');

$title = Yii::t('cms', 'Categories');
$this->title = Yii::$app->id . ' | ' . $title;
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $title ?></h1>
        <?= Html::beginForm(['move']) ?>
            <?= $this->render('_grid', ['dataProvider' => $dataProvider]) ?>
            <?= Html::hiddenInput('direction', '', ['id' => 'field-direction']) ?>
            <?= Html::hiddenInput('node_id', '', ['id' => 'field-id']) ?>
        <?= Html::endForm() ?>
    </div>
</div>
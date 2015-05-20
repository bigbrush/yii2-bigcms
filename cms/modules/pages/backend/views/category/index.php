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
');

Yii::$app->toolbar->add()->add('Pages', ['page/index'], 'file');

$this->title = Yii::$app->id . ' | Page categories';
?>
<div class="row">
    <div class="col-md-12">
        <h1>Page categories</h1>
        <?= Html::beginForm(['move']) ?>
            <?= $this->render('_grid', ['dataProvider' => $dataProvider]) ?>
            <?= Html::hiddenInput('direction', '', ['id' => 'field-direction']) ?>
            <?= Html::hiddenInput('node_id', '', ['id' => 'field-id']) ?>
        <?= Html::endForm() ?>
    </div>
</div>
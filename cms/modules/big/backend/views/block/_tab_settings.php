<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($block->model, 'show_title')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($block->model, 'state')->dropDownList([Yii::t('cms', 'Inactive'), Yii::t('cms', 'Active')]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($block->model, 'scope')->dropDownList(Yii::$app->cms->getAvailableScopes()) ?>
    </div>
</div>

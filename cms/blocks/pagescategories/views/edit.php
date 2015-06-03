<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

$categories = ['' => Yii::t('cms', 'Select menu')] + Yii::$app->big->categoryManager->getDropDownList('pages');
?>
<div class="row">
    <div class="col-md-9">
        <?= $form->field($model, 'category_id')->dropDownList($categories)->label(Yii::t('cms', 'Category')) ?>
    </div>
</div>

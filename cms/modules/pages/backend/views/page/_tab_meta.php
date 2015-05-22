<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

$inputOptions = ['inputOptions' => ['disabled' => 'disabled']];
?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model->author, 'name', $inputOptions) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model->editor, 'name', $inputOptions) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'createdAtText', $inputOptions) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'updatedAtText', $inputOptions) ?>
    </div>
</div>
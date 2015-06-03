<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="row">
    <div class="col-md-9">

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'menu_id')->label('Select menu')->dropDownList($dropDownList) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions())->label('Menu type') ?>
            </div>
        </div>
        
    </div>
</div>

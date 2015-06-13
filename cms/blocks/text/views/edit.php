<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use bigbrush\big\widgets\editor\Editor;
?>
<div class="panel panel-default">
	<div class="panel-heading">
    	<strong><?= Yii::t('cms', 'Content') ?></strong>
	</div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'content')->widget(Editor::className(), [
                    'clientOptions' => [
                    'plugins' => 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste',
                    'toolbar' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
                ]
            ])->label(false) ?>
            </div>
        </div>
	</div>
</div>

<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use bigbrush\cms\widgets\Editor;
?>
<div class="panel panel-default">
	<div class="panel-heading">
    	<strong><?= Yii::t('cms', 'Content') ?></strong>
	</div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'content')->widget(Editor::className())->label(false) ?>
            </div>
        </div>
	</div>
</div>

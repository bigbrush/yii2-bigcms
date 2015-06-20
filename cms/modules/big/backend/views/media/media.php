<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use bigbrush\big\widgets\filemanager\FileManager;

$this->title = Yii::t('cms', 'File manager');
?>
<div class="row">
    <div class="col-md-12">
    	<h1><?= $this->title ?></h1>
        <?= FileManager::widget() ?>
    </div>
</div>
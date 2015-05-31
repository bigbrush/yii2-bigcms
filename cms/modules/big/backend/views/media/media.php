<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use bigbrush\big\widgets\filemanager\FileManager;

$title = Yii::t('cms', 'File manager');
$this->title = Yii::$app->id . ' | ' . $title;
?>
<div class="row">
    <div class="col-md-12">
    	<h1><?= $title ?></h1>
        <?= FileManager::widget() ?>
    </div>
</div>
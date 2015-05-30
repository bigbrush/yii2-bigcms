<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

$type = Yii::t('cms', 'block');
$title = $block->model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = Yii::$app->id . ' | ' . $title;
?>
<?= $block->edit($block->model) ?>
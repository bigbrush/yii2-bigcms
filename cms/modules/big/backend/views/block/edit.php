<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

$action = $block->model->id ? 'Edit' : 'Create';
$this->title = Yii::$app->id . ' | ' . $action . ' block';
?>
<?= $block->edit($block->model) ?>
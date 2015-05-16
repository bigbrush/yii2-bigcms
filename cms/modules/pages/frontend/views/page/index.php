<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;

$this->title = (!empty($model->meta_title) ? $model->meta_title : $model->title);
$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->meta_keywords]);
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= Html::encode($model->title) ?></h1>
        <?= $model->content ?>
    </div>
</div>
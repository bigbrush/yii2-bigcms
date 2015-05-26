<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use cms\widgets\DeleteButton;

$this->title = Yii::$app->id . ' | Menus';
?>
<div class="row">
    <div class="col-md-12">
        <?php Yii::$app->toolbar->add('New', ['edit-menu'])->add('Menu items', ['index'], 'tree'); ?>
        <h1>Menus</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'header' => 'Title',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->title, ['edit-menu', 'id' => $data->id]);
                    },
                ],
                [
                    'header' => 'Delete',
                    'format' => 'raw',
                    'options' => ['width' => '1%'],
                    'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                    'value' => function($data) {
                        $popover = [];
                        $popover[] = '<div style="text-align: center;">';
                        $popover[] = '<p>Are you sure to delete this menu?</p>';
                        $popover[] = '<p><strong>All menu items are removed as well!</strong></p>';
                        $popover[] = Html::submitButton('<i class="fa fa-check"></i>', [
                            'class' => 'btn btn-success',
                        ]);
                        $popover[] = Html::hiddenInput('id', $data->id);
                        $popover[] = '</div>';

                        return DeleteButton::widget([
                            'model' => $data,
                            'action' => ['delete-menu', 'id' => $data->id],
                            'options' => ['class' => 'btn-xs'],
                            'title' => '<div style="text-align: center;"><strong>Are you sure?</strong></div>',
                            'content' => implode("\n", $popover),
                        ]);
                    },
                ],
            ],
        ]); ?>
    </div>
</div>
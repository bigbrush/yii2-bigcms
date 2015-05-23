<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerJs('
    $(".delete-form .btn").click(function(e){
        if (confirm("Are you sure to delete this menu? All menu items are removed as well!")) {
            return true;
        }
        return false;
    });
');

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
                        return Html::beginForm(['delete-menu', 'id' => $data->id], 'post', ['class' => 'delete-form'])
                            . Html::submitButton('<i class="fa fa-trash"></i>', ['class' => 'btn btn-default btn-xs'])
                            . Html::hiddenInput('id', $data->id)
                            . Html::endForm();
                    },
                ],
            ],
        ]); ?>
    </div>
</div>
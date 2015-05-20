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
        if (confirm("Are you sure to delete this page?")) {
            return true;
        }
        return false;
    });
');

Yii::$app->toolbar->add()->add('Categories', ['category/index'], 'bars');

$this->title = Yii::$app->id . ' | Pages';
?>
<div class="row">
    <div class="col-md-12">
        <h1>Pages</h1>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'header' => 'Title',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->title, ['edit', 'id' => $data->id]);
                    },
                ],
                [
                    'header' => 'Delete',
                    'format' => 'raw',
                    'options' => ['width' => '1%'],
                    'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                    'value' => function($data) {
                        return Html::beginForm(['delete', 'id' => $data->id], 'post', ['class' => 'delete-form'])
                            . Html::submitButton('<i class="fa fa-trash"></i>', ['class' => 'btn btn-default btn-xs'])
                            . Html::hiddenInput('id', $data->id)
                            . Html::endForm();
                    },
                ],
            ],
        ]); ?>
    </div>
</div>
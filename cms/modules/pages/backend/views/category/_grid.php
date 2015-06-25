<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Button;
use yii\bootstrap\ButtonGroup;
use bigbrush\cms\widgets\DeleteButton;
?>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'header' => Yii::t('cms', 'Title'),
                'format' => 'raw',
                'value' => function($data) {
                    return str_repeat('- ', $data->depth-1) . Html::a($data->title, ['edit', 'id' => $data->id]);
                },
            ],
            [
                'header' => Yii::t('cms', 'Ordering'),
                'headerOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                'format' => 'raw',
                'options' => ['width' => '10%'],
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                'value' => function($data) {
                    $options = ['class' => 'btn btn-default changeDirectionBtn', 'data-pid' => $data->id];
                    return ButtonGroup::widget([
                        'options' => ['class' => 'btn-group btn-group-xs'],
                        'buttons' => [
                            Button::widget([
                                'label' => '<i class="fa fa-arrow-up"></i>',
                                'encodeLabel' => false,
                                'options' => ['data-direction' => 'up'] + $options,
                            ]),
                            Button::widget([
                                'label' => '<i class="fa fa-arrow-down"></i>',
                                'encodeLabel' => false,
                                'options' => ['data-direction' => 'down'] + $options,
                            ]),
                        ]
                    ]);
                },
            ],
            [
                'header' => Yii::t('cms', 'Delete'),
                'options' => ['width' => '5%'],
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                'format' => 'raw',
                'value' => function($data) {                        
                    return DeleteButton::widget([
                        'model' => $data,
                        'options' => ['class' => 'btn-xs'],
                    ]);
                }
            ],
        ],
    ]); ?>
</div>

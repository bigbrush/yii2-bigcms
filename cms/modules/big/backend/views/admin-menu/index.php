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
use yii\bootstrap\ButtonDropdown;
use bigbrush\cms\widgets\DeleteButton;

Yii::$app->toolbar->add()->add(Yii::t('cms', 'Menus'), ['menus'], 'bars');

$this->title = Yii::t('cms', 'Menu items');
?>

<div class="row">
    <div class="col-md-12">
        <div id="alert">
        </div>
        
        <h1><?= $this->title ?></h1>
        
        <?= ButtonDropdown::widget([
            'label' => Yii::t('cms', 'Select menu'),
            'options' => ['class' => 'btn btn-default', 'style' => 'margin-bottom: 10px;'],
            'dropdown' => [
                'items' => $dropdown,
            ],
        ]) ?>

    	<div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'header' => Yii::t('cms', 'Title'),
                        'format' => 'raw',
                        'value' => function($data) {
                            return str_repeat('<i class="fa fa-caret-right tree-indent"></i>', $data->depth-1) . Html::a($data->title, ['edit', 'id' => $data->id]);
                        },
                    ],
                    [
                        'header' => Yii::t('cms', 'Default'),
                        'format' => 'raw',
                        'options' => ['width' => '1%'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'value' => function($data) {
                            return ($data->is_default) ? '<i class="fa fa-star"></i>' : '';
                        },
                    ],
                    [
                        'header' => Yii::t('cms', 'Ordering'),
                        'headerOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'format' => 'raw',
                        'options' => ['width' => '10%'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'value' => function($data) {
                            $options = ['class' => 'btn btn-default'];
                            $html = Html::beginForm(['move']);
                            $html .= ButtonGroup::widget([
                                'options' => ['class' => 'btn-group btn-group-xs'],
                                'buttons' => [
                                    Button::widget([
                                        'label' => '<i class="fa fa-arrow-up"></i>',
                                        'encodeLabel' => false,
                                        'options' => ['name' => 'direction', 'value' => 'up'] + $options,
                                    ]),
                                    Button::widget([
                                        'label' => '<i class="fa fa-arrow-down"></i>',
                                        'encodeLabel' => false,
                                        'options' => ['name' => 'direction', 'value' => 'down'] + $options,
                                    ]),
                                ]
                            ]);
                            $html .= Html::hiddenInput('node_id', $data->id);
                            $html .= Html::endForm();
                            return $html;
                        },
                    ],
                    [
                       'header' => Yii::t('cms', 'Delete'),
                       'format' => 'raw',
                        'options' => ['width' => '1%'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'value' => function($data) {
                            return DeleteButton::widget([
                                'model' => $data,
                                'options' => ['class' => 'btn-xs'],
                            ]);
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

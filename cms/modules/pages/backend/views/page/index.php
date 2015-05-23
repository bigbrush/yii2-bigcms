<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->registerCss('
    .popover {text-align:center;}
    .popover h3 {font-weight: bold;}
');

Yii::$app->toolbar->add()->add('Categories', ['category/index'], 'bars');

$this->title = Yii::$app->id . ' | Pages';
?>
<div class="row">
    <div class="col-md-12">
        <h1>Pages</h1>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-hover'],
            'columns' => [
                [
                    'header' => 'Title',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->title, ['edit', 'id' => $data->id]);
                    },
                ],
                [
                    'class' => 'cms\grid\DeleteColumn',
                    'header' => 'Delete',
                    'options' => ['width' => '5%'],
                    'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                ],
            ],
        ]); ?>
    </div>
</div>
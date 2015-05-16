<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;

Yii::$app->toolbar->add()->add('Categories', ['category/index'], 'bars');

/* @var $this yii\web\View */
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
            ],
        ]); ?>
    </div>
</div>
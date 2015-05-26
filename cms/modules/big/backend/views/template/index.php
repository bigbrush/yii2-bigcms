<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use cms\widgets\DeleteButton;

$this->title = Yii::$app->id . ' | Templates';
?>
<div class="row">
    <div class="col-md-12">
        <?php Yii::$app->toolbar->add(); ?>
        <h1>Templates</h1>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'header' => 'Title',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->title, ['edit', 'id' => $data->id]);
                    },
                ],
                [
                    'header' => 'Default',
                    'format' => 'raw',
                    'options' => ['width' => '1%'],
                    'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                    'value' => function($data) {
                        return ($data->is_default) ? '<i class="fa fa-star"></i>' : '';
                    },
                ],
                [
                    'header' => 'Delete',
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
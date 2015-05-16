<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
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
                'id',
                [
                    'header' => 'Title',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->title, ['edit-menu', 'id' => $data->id]);
                    },
                ],
            ],
        ]); ?>
    </div>
</div>
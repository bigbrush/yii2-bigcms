<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use bigbrush\cms\widgets\DeleteButton;

$title = Yii::t('cms', 'Templates');
$this->title = Yii::$app->id . ' | ' . $title;
?>
<div class="row">
    <div class="col-md-12">
        <?php Yii::$app->toolbar->add(); ?>
        <h1><?= $title ?></h1>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-hover'],
            'columns' => [
                [
                    'header' => Yii::t('cms', 'Title'),
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->title, ['edit', 'id' => $data->id]);
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
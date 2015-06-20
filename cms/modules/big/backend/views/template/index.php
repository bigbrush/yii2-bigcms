<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use bigbrush\cms\widgets\DeleteButton;

Yii::$app->toolbar->add();

$this->title = Yii::t('cms', 'Templates');
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $this->title ?></h1>
        <div class="table-responsive">
            <?php echo GridView::widget([
                'dataProvider' => $dataProvider,
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
</div>
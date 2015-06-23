<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;

Yii::$app->toolbar->add();

$this->title = Yii::t('cms', 'Users');
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $this->title ?></h1>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'header' => Yii::t('cms', 'Username'),
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::a(Html::encode($data->username), ['edit', 'id' => $data->id]);
                        }
                    ],
                    [
                        'header' => Yii::t('cms', 'Name'),
                        'options' => ['width' => '20%'],
                        'value' => function($data) {
                            return Html::encode($data->name);
                        }
                    ],
                    [
                        'header' => Yii::t('cms', 'Email'),
                        'options' => ['width' => '20%'],
                        'value' => function($data) {
                            return Html::encode($data->email);
                        }
                    ],
                    [
                        'header' => Yii::t('cms', 'State'),
                        'options' => ['width' => '5%'],
                        'value' => function($data) {
                            return Html::encode($data->getStateText());
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

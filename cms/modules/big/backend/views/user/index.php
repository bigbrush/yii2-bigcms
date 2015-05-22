<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;

$options = $model->getStateOptions();
Yii::$app->toolbar->add();

$this->title = Yii::$app->id . ' | Users';
?>
<div class="row">
    <div class="col-md-12">
        <h1>Users</h1>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'header' => 'Username',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a(Html::encode($data->username), ['edit', 'id' => $data->id]);
                    }
                ],
                [
                    'header' => 'Name',
                    'options' => ['width' => '30%'],
                    'value' => function($data) {
                        return Html::encode($data->name);
                    }
                ],
                [
                    'header' => 'Phone',
                    'options' => ['width' => '15%'],
                    'value' => function($data) {
                        return Html::encode($data->phone);
                    }
                ],
                [
                    'header' => 'State',
                    'options' => ['width' => '10%'],
                    'value' => function($data) use ($options) {
                        return Html::encode($options[$data->state]);
                    }
                ],
            ],
        ]); ?>
    </div>
</div>
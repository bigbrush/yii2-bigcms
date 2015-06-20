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

$this->title = Yii::t('cms', 'Pages');
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $this->title ?></h1>

        <div class="row">
            <div class="col-md-4 col-md-offset-8">
                <?= Html::beginForm([''], 'get') ?>
                <?= Html::label(Yii::t('cms', 'Filter by category'), 'id', ['class' => 'control-label']) ?>
                <?= Html::dropDownList('id', $activeCategory, $categories, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) ?>
                <?= Html::endForm() ?>
            </div>
        </div>

        <?= GridView::widget([
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
                    'header' => Yii::t('cms', 'Category'),
                    'options' => ['width' => '20%'],
                    'format' => 'raw',
                    'value' => function($data) {
                        return $data->category->title;
                    },
                ],
                [
                    'header' => Yii::t('cms', 'State'),
                    'options' => ['width' => '10%'],
                    'format' => 'raw',
                    'value' => function($data) {
                        return $data->getStateText();
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
</div>
<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ButtonDropDown;
use bigbrush\cms\widgets\DeleteButton;

$dropdown = [];
foreach ($installedBlocks as $id => $name) {
    $dropdown[] = ['label' => $name, 'url' => ['create', 'id' => $id]];
}
$toolbar = Yii::$app->toolbar;
$toolbar->addButton(ButtonDropDown::widget([
    'label' => $toolbar->createText('square', Yii::t('cms', 'New {0}', Yii::t('cms', 'block'))),
    'options' => ['class' => 'btn btn-default'],
    'encodeLabel' => false,
    'dropdown' => [
        'items' => $dropdown,
    ],
]));

$title = Yii::t('cms', 'Blocks');
$this->title = Yii::$app->id . ' | ' . $title;
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $title ?></h1>
    </div>
</div>

<div id="blocks-wrapper">
    <?php
    $chunks = array_chunk($blocks, 4);
    
    foreach ($chunks as $blocks) : ?>
    <div class="row">
        
        <?php foreach ($blocks as $block) : ?>
        <div class="col-md-3">
            <div class="square">
                <div class="content">
                    <?= DeleteButton::widget([
                        'model' => $block->model,
                        'buttonClass' => 'btn-default delete-btn',
                    ]); ?>

                    <?= Html::a($block->title, ['edit', 'id' => $block->model->id]) ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    
    </div>
    <?php endforeach; ?>
</div>

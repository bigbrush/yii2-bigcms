<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ButtonDropDown;

$this->registerJs('
    $("#submitBtn").click(function(){
        if ($("#dropDownList").val() == "") {
            alert("Please select a block");
            return false;
        }
    });
');

$dropdown = [];
foreach ($installedBlocks as $id => $name) {
    if (!empty($id)) {
        $dropdown[] = ['label' => $name, 'url' => ['edit', 'id' => $id]];
    }
}
$toolbar = Yii::$app->toolbar;
$toolbar->addButton(ButtonDropDown::widget([
    'label' => $toolbar->createIcon('square') . ' ' . 'New block',
    'options' => ['class' => 'btn btn-default'],
    'encodeLabel' => false,
    'split' => true,
    'dropdown' => [
        'items' => $dropdown,
    ],
]));
?>
<div class="row">
    <div class="col-md-12">
        <h1>Blocks</h1>
    </div>
</div>

<?php
$chunks = array_chunk($blocks, 4);
foreach ($chunks as $blocks) : ?>
<div class="row">
    <?php foreach ($blocks as $block) : ?>
    <div class="col-md-3" style="margin-bottom:30px;">
        <div class="square">
	        <div class="content">
                <?php $form = ActiveForm::begin('', 'delete') ?>
                <?= $form->hiddenInput($block->model) ?>
                <?= Html::button('<i class="fa fa-file"></i>') ?>
                <?= ActiveForm::end() ?>
                <?= Html::a($block['title'], ['edit', 'id' => $block['id']]) ?>
	        </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>
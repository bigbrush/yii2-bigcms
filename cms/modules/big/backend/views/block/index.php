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
    $(".delete-form .btn").click(function(e){
        if (confirm("Are you sure to delete this block?")) {
            return true;
        }
        return false;
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
    'dropdown' => [
        'items' => $dropdown,
    ],
]));

$this->title = Yii::$app->id . ' | Blocks';
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
                <?= Html::beginForm(['delete', 'id' => $block['id']], 'post', ['class' => 'delete-form']) ?>
                <?= Html::hiddenInput('block_id', $block['id']) ?>
                <?= Html::submitButton('<i class="fa fa-trash"></i>', ['class' => 'btn btn-default btn-sm']) ?>
                <?= Html::endForm() ?>
                <?= Html::a($block['title'], ['edit', 'id' => $block['id']]) ?>
	        </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>
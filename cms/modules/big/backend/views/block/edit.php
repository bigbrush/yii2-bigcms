<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;

$type = Yii::t('cms', 'block');
$title = $block->model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = $title;
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <h1><?= $title ?></h1>
        </div>
    </div>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('cms', 'Content'),
                'content' => $this->render('_tab_content', [
                    'block' => $block,
                    'form' => $form,
                ]),
            ],
            [
                'label' => Yii::t('cms', 'Settings'),
                'content' => $this->render('_tab_settings', [
                    'block' => $block,
                    'form' => $form,
                ]),
            ],
        ],
    ]) ?>

    <?php
    /**
     * Add toolbar buttons automatically when no items has been added to the toolbar by the block.
     */
    $toolbar = Yii::$app->cms->getToolbar();
    if (empty($toolbar->items)) {
        $toolbar->save()->saveStay()->back();
    }
    ?>
<?php ActiveForm::end(); ?>

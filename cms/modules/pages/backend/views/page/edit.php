<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;

$type = Yii::t('cms', 'page');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = $title;
?>

<?php
$form = ActiveForm::begin();

Yii::$app->toolbar->save()->saveStay()->back();

$items = [
    [
        'label' => Yii::t('cms', 'Page'),
        'content' => $this->render('_tab_page', [
            'model' => $model,
            'form' => $form,
            'categories' => $categories,
            'templates' => $templates
        ]),
    ],
    [
        'label' => Yii::t('cms', 'Seo'),
        'content' => $this->render('_tab_seo', [
            'model' => $model,
            'form' => $form
        ]),
    ],
];
if ($model->getIsNewRecord() === false) {
    $items[] = [
    'label' => Yii::t('cms', 'Info'),
    'content' => $this->render('_tab_info', [
        'model' => $model,
        'form' => $form
    ]),
];
}
?>
    <h1><?= $title ?></h1>
    
    <div class="row">
        <div class="col-md-12">
            <?= Tabs::widget([
                'items' => $items,
            ]) ?>
        </div>
    </div>    

<?php $form = ActiveForm::end(); ?>
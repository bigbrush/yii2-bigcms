<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;

$action = $model->id ? 'Edit' : 'Create';
$this->title = Yii::$app->id . ' | ' . $action . ' page';
?>

<?php
$form = ActiveForm::begin();

Yii::$app->toolbar->save()->saveStay()->back();

$items = [
    [
        'label' => 'Page',
        'content' => $this->render('_tab_page', [
            'model' => $model,
            'form' => $form,
            'categories' => $categories,
            'templates' => $templates
        ]),
    ],
    [
        'label' => 'Seo',
        'content' => $this->render('_tab_seo', [
            'model' => $model,
            'form' => $form
        ]),
    ],
];
if ($model->getIsNewRecord() === false) {
    $items[] = [
    'label' => 'Info',
    'content' => $this->render('_tab_meta', [
        'model' => $model,
        'form' => $form
    ]),
];
}
?>
    <h1><?= $action ?> page</h1>
    
    <div class="row">
        <div class="col-md-12">
            <?= Tabs::widget([
                'options' => ['style' => 'margin-bottom: 15px;'],
                'items' => $items,
            ]) ?>
        </div>
    </div>    

<?php $form = ActiveForm::end(); ?>
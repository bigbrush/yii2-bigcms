<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\BootstrapPluginAsset;

BootstrapPluginAsset::register($this);

$this->registerJs('
    $(\'[data-toggle="tooltip"]\').tooltip();
');

$tooltipOptions = [
    'toggle' => 'tooltip',
    'placement' => 'right',
];

$sortDirectionOptions = $model->getSortDirectionOptions();
$showAuthorOptions = $model->getShowAuthorOptions();
$displayDateOptions = $model->getDisplayDateOptions();
?>
<div class="row">
    <div class="col-md-6">
        <?= $this->render('_panel', [
            'title' => Yii::t('cms', 'Category'),
            'fields' => [
                $form->field($model, 'category_id')->dropDownList($categories)->label(Yii::t('cms', 'Choose category'), [
                    'data' => $tooltipOptions + [
                        'title' => Yii::t('cms', 'The category to show pages from'),
                    ]
                ]),
            ],
        ]) ?>
        <?= $this->render('_panel', [
            'title' => Yii::t('cms', 'Sorting'),
            'fields' => [
                $form->field($model, 'order_by')->dropDownList($sortOptions)->label(Yii::t('cms', 'Sort by'), [
                    'data' => $tooltipOptions + [
                        'title' => Yii::t('cms', 'The field to sort the pages by'),
                    ]
                ]),
                $form->field($model, 'order_direction')->dropDownList($sortDirectionOptions)->label(Yii::t('cms', 'Sorting'), [
                    'data' => $tooltipOptions + [
                        'title' => Yii::t('cms', 'The direction to use when sorting - descending means newest first'),
                    ]
                ]),
            ],
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= $this->render('_panel', [
            'title' => Yii::t('cms', 'Display configuration'),
            'fields' => [
                $form->field($model, 'max_pages')->label(Yii::t('cms', 'Number of pages'), [
                    'data' => $tooltipOptions + [
                        'title' => Yii::t('cms', 'The number of pages shown. 0 means show all'),
                    ]
                ]),
                $form->field($model, 'author_editor')->dropDownList($showAuthorOptions)->label(Yii::t('cms', 'Show author/editor name'), [
                    'data' => $tooltipOptions + [
                        'title' => Yii::t('cms', 'Show name of author or editor'),
                    ]
                ]),
                $form->field($model, 'author_editor_text')->label(Yii::t('cms', 'Text before editor/author'), [
                    'data' => $tooltipOptions + [
                        'title' => Yii::t('cms', 'A text displayed before the chosen author or editor'),
                    ]
                ]),
                $form->field($model, 'date_displayed')->dropDownList($displayDateOptions)->label(Yii::t('cms', 'Date displayed'), [
                    'data' => $tooltipOptions + [
                        'title' => Yii::t('cms', 'Show page creation date or date of last modification'),
                    ]
                ]),
                $form->field($model, 'date_displayed_text')->label(Yii::t('cms', 'Text before date'), [
                    'data' => $tooltipOptions + [
                        'title' => Yii::t('cms', 'A text displayed before the chosen type of date'),
                    ]
                ]),
            ],
        ]) ?>
    </div>
</div>

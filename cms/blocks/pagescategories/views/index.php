<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use bigbrush\cms\modules\pages\components\Route;
?>
<div class="block pages-categories">
    <?php if ($block->showTitle) : ?>
    <h3><?= $block->title ?></h3>
    <?php endif; ?>

    <?php foreach ($pages as $page) : ?>
        <div class="page-list-item">
            <?= Html::a($page['title'], Route::page($page, '/')) ?>
            
            <?php if (!empty($block->model->author_editor)) : ?>
            <div class="page-author">
                
                <?php if (!empty($block->model->author_editor_text)) : ?>
                <span class="page-author-text">
                    <?= $block->model->author_editor_text ?>
                </span>
                <?php endif; ?>
                
                <span class="page-author-content">
                    <?= $page[$block->model->author_editor]['name'] ?>
                </span>
            </div>
            <?php endif; ?>

            <?php if (!empty($block->model->date_displayed)) : ?>
            <div class="page-date">
                <?php if (!empty($block->model->date_displayed_text)) : ?>
                <span class="page-date-text">
                    <?= $block->model->date_displayed_text ?>
                </span>
                <?php endif; ?>

                <span class="page-date-content">
                    <?= Yii::$app->getFormatter()->asDate($page[$block->model->date_displayed]) ?>
                </span>
            </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use bigbrush\cms\modules\pages\components\Route;
?>
<div class="row">
    <?php foreach ($pages as $page) : ?>
    <div class="col-md-12">
        <?= Html::a(Html::encode($page->title), Route::page($page, '/')) ?>
    </div>
    <?php endforeach; ?>
</div>
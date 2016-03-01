<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 center">
                <?php if ($block->showTitle) : ?>
                <h3><?= $block->title ?></h3>
                <?php endif; ?>
                <?= $block->text ?>
            </div>
        </div>
    </div>
</div>

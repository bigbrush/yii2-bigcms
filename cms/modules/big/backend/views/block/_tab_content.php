<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<div class="row">
    <div class="col-md-12">
        
        <?= $form->field($block->model, 'title', ['inputOptions' => ['class' => 'form-control input-lg']]); ?>
        
        <?php
        /**
         * Call the edit method of the current block.
         */
        ?>
        <?= $block->edit($block->model, $form) ?>
    </div>
</div>

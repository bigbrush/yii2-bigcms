<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<?php $this->beginContent('@app/themes/parallax/views/layouts/main.php'); ?>
<div class="container">
    <div class="row">
        <div class="col l9 s12">
            <?= $content ?>
        </div>
        <div class="col l3 s12">
            <big:block position="sidebar" />
        </div>
    </div>
</div>
<?php $this->endContent(); ?>

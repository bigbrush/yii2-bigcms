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
        <div class="col s9">
            <?= $content ?>
        </div>
        <div class="col s3">
            <big:block position="sidebar" />
        </div>
    </div>
</div>
<?php $this->endContent(); ?>

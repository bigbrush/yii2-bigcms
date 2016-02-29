<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<?php $this->beginContent('@app/themes/web/views/layouts/main.php'); ?>
<div class="row">
	<div class="col-md-9">
		<?= $content ?>
	</div>
	<div class="col-md-3">
		<big:block position="sidebar" />
	</div>
</div>
<?php $this->endContent(); ?>

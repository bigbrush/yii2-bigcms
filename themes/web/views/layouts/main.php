<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use app\themes\web\ThemeAsset;
use bigbrush\cms\widgets\Alert;

ThemeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<big:block position="mainmenu" />

<?php if (Yii::$app->big->isPositionActive('frontpage-gallery')) : ?>
	<big:block position="frontpage-gallery" />
<?php endif; ?>

<div class="container">
    <?= Alert::widget() ?>
	<?= $content ?>
</div>

<footer>
    <big:block position="footer" />
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

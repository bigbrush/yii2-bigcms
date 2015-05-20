<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use app\themes\web\assets\ThemeAsset;
use cms\widgets\Alert;

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

<?php if (Yii::$app->big->isPositionActive('main menu')) : ?>
<big:include position="main menu" />
<?php endif; ?>

<div class="container">
    <?= Alert::widget() ?>
	<?= $content ?>
</div>

<?php if (Yii::$app->big->isPositionActive('footer')) : ?>
<footer>
    <big:include position="footer" />
</footer>
<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
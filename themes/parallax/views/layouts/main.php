<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use app\themes\parallax\ThemeAsset;

ThemeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<big:block position="mainmenu" />

<?= $content ?>

<footer class="page-footer teal">
<div class="container">
    <div class="row">
        <div class="col l5 s12">
            <big:block position="footer-left" />
        </div>
        <div class="col l5 offset-l2 s12">
            <big:block position="footer-right" />
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Read the <a class="brown-text text-lighten-3" href="http://www.bigbrush-agency.com/api/guide">Big Cms guide</a>
      </div>
    </div>
  </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

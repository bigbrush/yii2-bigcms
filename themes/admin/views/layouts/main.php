<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use cms\components\Toolbar;
use cms\components\AdminMenu;
use cms\widgets\Alert;
use app\themes\admin\assets\ThemeAsset;

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
    <?php if (Yii::$app->cms->getAdminMenu()->getIsCollapsed()) : ?>
    <div id="wrapper" class="toggled">
    <?php else : ?>
    <div id="wrapper">
    <?php endif; ?>

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <?= Yii::$app->cms->getAdminMenu()->render(); ?>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <?= Yii::$app->toolbar->render() ?>
                    </div>
                </div>
                
                <div class="content-wrapper">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
                
                <!-- Footer -->
                <footer id="footer-wrapper" class="text-center">
                    <p>BIG CMS © <?= date('Y') ?></p>
                </footer>
                <!-- /#footer-wrapper -->
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
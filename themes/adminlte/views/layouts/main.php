<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use bigbrush\cms\widgets\Alert;
use bigbrush\cms\widgets\AdminMenu;
use app\themes\adminlte\ThemeAsset;

$bundle = ThemeAsset::register($this);

$user = Yii::$app->getUser();
$isLoggedIn = !$user->getIsGuest();

$this->registerJs('
    $(".sidebar-toggle").click(function(e) {
        e.preventDefault();
        if ($("body").hasClass("sidebar-collapse")) {
            $.get("'.Url::to(['/big/cms/collapse-menu', 'collapsed' => 1]).'");
        } else {
            $.get("'.Url::to(['/big/cms/collapse-menu', 'collapsed' => 0]).'");
        }
    });
');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php if (AdminMenu::getIsCollapsed()) : ?>
<body class="skin-blue sidebar-mini sidebar-collapse">
<?php else : ?>
<body class="skin-blue sidebar-mini">
<?php endif; ?>
<?php $this->beginBody() ?>

<div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <?= Html::a('
            <span class="logo-mini"><b>Big</b></span>
            <span class="logo-lg"><b>Big</b>Cms</span>
        ', ['/'], ['class' => 'logo']) ?>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>

          <?php if ($isLoggedIn) : ?>
          
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <!-- User Account Menu -->
            <ul class="nav navbar-nav">
              <li>
                <?= Html::a('<i class="fa fa-eye"></i>', Url::to('@web/../'), [
                    'target' => '_blank', 'data' => ['toggle' => 'tooltip', 'placement' => 'bottom', 'container' => 'body'], 'title' => Yii::t('cms', 'Visit site'),
                ]) ?>
              </li>
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <?= Html::img(Url::to('@web/../') . $user->identity->avatar, ['class' => 'user-image', 'alt' => 'User image']) ?>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?= $user->identity->name ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <?= Html::img(Url::to('@web/../') . $user->identity->avatar, ['class' => 'img-circle', 'alt' => 'User image']) ?>
                    <p>
                      <?= $user->identity->name ?>
                      <small><?= Yii::t('cms', 'Member since') . ' ' . Yii::$app->getFormatter()->asDate($user->identity->created_at) ?> </small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <?= Html::a('<i class="fa fa-user"></i> Profile', ['/big/user/edit', 'id' => $user->id], ['class' => 'btn btn-default btn-flat']) ?>
                    </div>
                    <div class="pull-right">
                      <?= Html::a('<i class="fa fa-circle-o-notch"></i> Sign out', ['/big/cms/logout'], ['class' => 'btn btn-default btn-flat']) ?>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <?php endif; ?>
        </nav>
      </header>

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <?php if ($isLoggedIn) : ?>
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <?= Html::img(Url::to('@web/../') . $user->identity->avatar, ['class' => 'img-circle', 'alt' => 'User image']) ?>
            </div>
            <div class="pull-left info">
              <p><?= $user->identity->name ?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- search form (Optional) -->
          <?= Html::beginForm(['/big/cms/search'], 'get', ['class' => 'sidebar-form']) ?>
            <div class="input-group">
              <?= Html::textInput('q', '', ['class' => 'form-control', 'placeholder' => Yii::t('cms', 'Search...')]) ?>
              <span class="input-group-btn">
                <?= Html::submitButton('<i class="fa fa-search"></i>', ['id' => 'search-btn', 'class' => 'btn btn-flat']) ?>
              </span>
            </div>
          <?= Html::endForm() ?>
          <!-- /.search form -->
          <?php endif; ?>

          <!-- Sidebar Menu -->
          <?= AdminMenu::widget() ?>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <?= Yii::$app->toolbar->render() ?>
        </section>

        <!-- Main content -->
        <section class="content">
          <?= Alert::widget() ?>
          <?= $content ?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <!-- <div class="pull-right hidden-xs">
          <?= Html::a(Yii::t('cms', 'Read the docs'), 'http://www.bigcms.bigbrush-agency.com/', ['target' => '_blank']) ?>
        </div> -->
        <!-- Default to the left -->
        <strong>Copyright &copy; <?= date('Y') ?> <a href="http://www.bigbrush-agency.com" target="_blank">BIG Brush Agency ApS</a>.</strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
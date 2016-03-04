<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\widgets\Menu;
?>

<?php foreach ($submenus as $id => $submenu) {
    echo Menu::widget([
        'items' => $submenu,
        'options' => ['id' => $id, 'class' => 'dropdown-content'],
    ]);
} ?>

<div class="navbar-fixed">
    <nav class="white" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="" class="brand-logo">Big Cms</a>
            <?php 
            echo Html::beginTag('ul', ['class' => 'right hide-on-med-and-down']);
            foreach ($parentMenus as $id => $item) {
                if ($item['submenu']) {
                    $label = $item['label'] . '<i class="material-icons right">arrow_drop_down</i>';
                    $options = ['class' => 'dropdown-button', 'data-activates' => $item['submenu']];
                } else {
                    $label = $item['label'];
                    $options = [];
                }
                echo Html::tag('li', Html::a($label, $item['url']), $options);
            }
            echo Html::endTag('ul');
            ?>

            <?= Menu::widget([
                'items' => $items,
                'options' => ['id' => 'nav-mobile', 'class' => 'side-nav'],
            ]) ?>
            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
    </nav>
</div>

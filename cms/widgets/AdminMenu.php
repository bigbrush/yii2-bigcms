<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Nav;

/**
 * AdminMenu
 */
class AdminMenu extends Nav
{
    /**
     * Initializes this widget by setting parent properties
     */
    public function init()
    {
        $this->options = ['class' => 'menu'];
        $this->encodeLabels = false;
        $this->items = ArrayHelper::merge($this->createItems(), $this->items);
        parent::init();
    }

    /**
     * Renders this widget
     *
     * @return string the rendering result of this widget
     */
    public function run()
    {
        return '<div class="list-group">' . parent::run() . '</div>';
    }

    /**
     * Creates all default menu items used by the admin menu.
     *
     * @return array all default menu items.
     */
    public function createItems()
    {
        // if no user is logged in hide the menu.
        $userLoggedIn = !Yii::$app->getUser()->getIsGuest();
        if (Yii::$app->getUser()->getIsGuest()) {
            $this->items[] = ['label' => '<i class="fa fa-home fa-fw"></i> Welcome', 'url' => ['/'], 'options' => ['class' => 'list-group-item']];
            return;
        }

        $itemsConfig = [
            ['label' => 'Home', 'url' => ['/'], 'icon' => 'home'],
            ['label' => 'Pages', 'url' => ['/pages/page/index'], 'icon' => 'file'],
            ['label' => 'Blocks', 'url' => ['/big/block/index'], 'icon' => 'square'],
            ['label' => 'Menus', 'url' => ['/big/menu/index'], 'icon' => 'bars'],
            ['label' => 'Media', 'url' => ['/big/media/show'], 'icon' => 'picture-o'],
            ['label' => 'Templates', 'url' => ['/big/template/index'], 'icon' => 'simplybuilt'],
            ['label' => 'Users', 'url' => ['/big/user/index'], 'icon' => 'users'],
            ['label' => 'Logout', 'url' => ['/big/frontpage/logout'], 'icon' => 'circle-o-notch'],
        ];
        $items = [];
        foreach ($itemsConfig as $item) {   
            $icon = $item['icon'];
            unset($item['icon']);
            $item['options'] = ['class' => 'list-group-item'];
            $item['label'] = '<i class="fa fa-'.$icon.' fa-fw"></i> ' . $item['label'];

            // if module and controller of the current route matches the first part of the item
            // url set current item as active.
            $pathInfo = Yii::$app->getRequest()->getPathInfo();
            $route = '/' . substr($pathInfo, 0, strrpos($pathInfo, '/'));
            $url = $item['url'][0];
            if (($route === $url) || ($route !== '/' && strpos($url, $route) === 0)) {
                $item['active'] = true;
            }
            $items[] = $item; 
        }
        return $items;
    }
}
<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\components;

use Yii;
use yii\base\Object;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\bootstrap\Nav;

/**
 * AdminMenu
 */
class AdminMenu extends Object
{
    /**
     * @var int whether the menu is collapsed.
     */
    public $collapsed = false;
    /**
     * @var boolean whether the menu is collapsible.
     */
    public $collapsible = true;
    /**
     * @var boolean whether to include the default items in the menu.
     */
    public $useDefaultItems = true;
    /**
     * @var array list of menu items added to the admin menu.
     */
    private $_items = [];


    /**
     * Initializes this widget by creating default menu items.
     */
    public function init()
    {
        if ($this->useDefaultItems) {
            // $this->createDefaultItems();
            foreach ($this->getDefaultItems() as $item) {   
                $this->addItem($item); 
            }
        }
    }

    /**
     * Runs this widget.
     *
     * @return string the rendering result of this widget.
     */
    public function render()
    {
        if ($this->collapsible) {
            $this->addCollapseItem();
        }

        $html = [];
        $html[] = '<div id="adminmenu" class="list-group">';
        $html[] = Nav::widget([
            'items' => $this->_items,
            'options' => ['class' => 'menu'],
            'encodeLabels' => false,
        ]);
        $html[] = '</div>';

        return  implode("\n", $html);
    }

    /**
     * Creates default menu items for the admin menu.
     *
     * @return array configuration for menu items.
     */
    public function getDefaultItems()
    {
        // if no user is logged in hide the menu.
        $userLoggedIn = !Yii::$app->getUser()->getIsGuest();
        if (Yii::$app->getUser()->getIsGuest()) {
            $this->collapsible = false;
            $item = ['label' => 'Welcome', 'url' => ['/'], 'icon' => 'home fa-fw'];
            return $this->addItem($item);
        }

        return [
            ['label' => 'Home', 'url' => ['/'], 'icon' => 'home'],
            ['label' => 'Pages', 'url' => ['/pages/page/index'], 'icon' => 'file',
                // 'items' => [
                //     ['label' => 'Categories', 'url' => ['/pages/categories/index'], 'icon' => 'square', 'options' => ['class' => 'pull-right']],
                // ]
            ],
            ['label' => 'Blocks', 'url' => ['/big/block/index'], 'icon' => 'square'],
            ['label' => 'Menus', 'url' => ['/big/menu/index'], 'icon' => 'bars'],
            ['label' => 'Media', 'url' => ['/big/media/show'], 'icon' => 'picture-o'],
            ['label' => 'Templates', 'url' => ['/big/template/index'], 'icon' => 'simplybuilt'],
            ['label' => 'Users', 'url' => ['/big/user/index'], 'icon' => 'users'],
            ['label' => 'Logout', 'url' => ['/big/frontpage/logout'], 'icon' => 'circle-o-notch'],
        ];
    }

    /**
     * Adds an item to the menu.
     *
     * @return array an item configuration array for an item. See [[yii\bootstrap\Nav]] for configuration of an item.
     */
    public function additem($item)
    {
        $icon = $item['icon'];
        unset($item['icon']);
        Html::addCssClass($item['options'], 'list-group-item');

        $item['label'] = '<i class="fa fa-'.$icon.' fa-fw"></i><span class="menuitem-text"> ' . $item['label'] . '</span>';

        // if module and controller of the current route matches the first part of the item
        // url set current item as active.
        $pathInfo = Yii::$app->getRequest()->getPathInfo();
        $route = '/' . substr($pathInfo, 0, strrpos($pathInfo, '/'));
        $url = $item['url'][0];
        if (($route === $url) || ($route !== '/' && strpos($url, $route) === 0)) {
            $item['active'] = true;
        }
        $this->_items[] = $item;
    }

    /**
     * Returns the menu item that collapses the menu.
     *
     * @return string the collapse menu item.
     */
    public function addCollapseItem()
    {
        Yii::$app->controller->getView()->registerJs('
            var wrapper = $("#wrapper"),
                menuToggler = $("#menu-toggler"),
                icon = menuToggler.find(".fa");

            function toggleIcon() {
                if (wrapper.hasClass("toggled")) {
                    icon.removeClass("fa-arrow-circle-left");
                    icon.addClass("fa-arrow-circle-right");
                } else {
                    icon.removeClass("fa-arrow-circle-right");
                    icon.addClass("fa-arrow-circle-left");
                }
            }
            
            if(' . Json::encode($this->collapsed) . ') {
                $(".menuitem-text").hide();
            }

            menuToggler.click(function(e) {
                e.preventDefault();
                wrapper.toggleClass("toggled");
                toggleIcon();
                if(wrapper.hasClass("toggled")) {
                    $.get("'.Url::to(['/big/cms/collapse-menu', 'collapsed' => true]).'");
                    $(".menuitem-text").hide();
                } else {
                    $.get("'.Url::to(['/big/cms/collapse-menu', 'collapsed' => false]).'");
                    $(".menuitem-text").show();
                }
            });
        ');

        if ($this->collapsed) {
            $icon = 'arrow-circle-right';
        } else {
            $icon = 'arrow-circle-left';
        }
        $this->addItem([
            'label' => 'Collapse',
            'url' => '#',
            'icon' => $icon,
            'options' => [
                'id' => 'menu-toggler'
            ]
        ]);
    }
}
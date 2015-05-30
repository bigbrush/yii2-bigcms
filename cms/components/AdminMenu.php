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
    const ADMIN_MENU_STATE_VAR = '__cms_collapse_menu__';

    /**
     * @var boolean whether the menu is collapsible.
     */
    public $collapsible = true;
    /**
     * @var boolean whether to include the default items in the menu.
     */
    public $useDefaultItems = true;
    /**
     * @var boolean whether the menu is collapsed.
     */
    private $_collapsed;
    /**
     * @var array list of menu items added to the admin menu. The items are used with [[yii\bootstrap\Nav]] widget.
     */
    private $_items = [];


    /**
     * Initializes this widget by creating default menu items.
     */
    public function init()
    {
        if ($this->useDefaultItems) {
            $this->addItems($this->getDefaultItems());
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

        return implode("\n", $html);
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
            $item = ['label' => Yii::t('cms', 'Welcome'), 'url' => ['/'], 'icon' => 'home fa-fw'];
            return [$item];
        }

        return [
            ['label' => Yii::t('cms', 'Home'), 'url' => ['/'], 'icon' => 'home'],
            ['label' => Yii::t('cms', 'Pages'), 'url' => ['/pages/page/index'], 'icon' => 'file',
                // 'items' => [
                //     ['label' => 'Categories', 'url' => ['/pages/categories/index'], 'icon' => 'square', 'options' => ['class' => 'pull-right']],
                // ]
            ],
            ['label' => Yii::t('cms', 'Blocks'), 'url' => ['/big/block/index'], 'icon' => 'square'],
            ['label' => Yii::t('cms', 'Menus'), 'url' => ['/big/menu/index'], 'icon' => 'bars'],
            ['label' => Yii::t('cms', 'File manager'), 'url' => ['/big/media/show'], 'icon' => 'picture-o'],
            ['label' => Yii::t('cms', 'Templates'), 'url' => ['/big/template/index'], 'icon' => 'simplybuilt'],
            ['label' => Yii::t('cms', 'Users'), 'url' => ['/big/user/index'], 'icon' => 'users'],
            ['label' => Yii::t('cms', 'Logout'), 'url' => ['/big/cms/logout'], 'icon' => 'circle-o-notch'],
        ];
    }

    /**
     * Adds an array of items to the menu.
     *
     * @param array $items list of items to add.
     */
    public function addItems($items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * Adds an item to the menu.
     *
     * @return array an item configuration array for an item. See [[yii\bootstrap\Nav]] for configuration of an item.
     */
    public function addItem($item)
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
     * Adds a menu item that collapses the menu.
     * This method is only used when [[collapsible]] is true.
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
            
            if(' . Json::encode($this->getIsCollapsed()) . ') {
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

        if ($this->getIsCollapsed()) {
            $icon = 'arrow-circle-right';
        } else {
            $icon = 'arrow-circle-left';
        }
        $this->addItem([
            'label' => Yii::t('cms', 'Minimize'),
            'url' => '#',
            'icon' => $icon,
            'options' => [
                'id' => 'menu-toggler'
            ]
        ]);
    }
    
    /**
     * Remebers whether the admin menu is collapsed.
     * The selection is saved in the current session.
     *
     * @param string $collapsed whether the admin menu is collapsed. "1" if menu is collapsed and "0" if it is not collapsed.
     */
    public function setIsCollapsed($collapsed)
    {
        Yii::$app->getSession()->set(static::ADMIN_MENU_STATE_VAR, $collapsed);
    }
    
    /**
     * Returns a boolean indicating whether the admin menu is collapsed.
     *
     * @return boolean whether the admin menu is collapsed.
     */
    public function getIsCollapsed()
    {
        if ($this->_collapsed === null) {
            $this->_collapsed = Yii::$app->getSession()->get(static::ADMIN_MENU_STATE_VAR) === '1';
        }
        return $this->_collapsed;
    }
}
<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\widgets;

use Yii;
use yii\widgets\Menu;

/**
 * AdminMenu
 */
class AdminMenu extends Menu
{
    const SESSION_VAR_COLLAPSED = '__cms_menu_collapsed__';
    const MAIN_MENU_ID = 1;


    /**
     * Initializes this widget.
     */
    public function init()
    {
        parent::init();
        if (empty($this->items)) {
            $this->items = $this->getItems();
        }
        $this->encodeLabels = false;
        $this->activateParents = true;
        $this->submenuTemplate = "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n";
        $this->options = ['class' => 'sidebar-menu'];
    }

    /**
     * Returns menu items for the admin menu.
     *
     * @param boolean $useIcons indicates whether to show an icon before each menu item.
     * @return array configuration for menu items.
     */
    public function getItems()
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            $items = [
                ['label' => Yii::t('cms', 'Welcome'), 'url' => ['/'], 'icon' => 'home', 'active' => true]
            ];
        } else {
            $items = Yii::$app->cms->adminMenuManager->getItems(static::MAIN_MENU_ID);
            $items = $this->createDropDownMenu($items);
        }
        return $this->adjustLabels($items);
    }

    /**
     * Creates a drop down menu ready for [[yii\bootstrap\Nav]] and [[yii\widgets\Menu]].
     *
     * @param array list of menus to nest in an array.
     * @return array nested array ready for a drop down menu.
     */
    public function createDropDownMenu(&$menus)
    {
        $items = [];
        while (list($id, $menu) = each($menus)) {
            $items[$id] = [
                'label' => $menu->title,
                'url' => [$menu->route],
                'icon' => $menu->params['icon'],
                'visible' => $menu->getIsEnabled(),
            ];
            if ($menu->rgt - $menu->lft != 1) {
                $items[$id]['items'] = $this->createDropDownMenu($menus);
            }
            $next = key($menus);
            if ($next && $menus[$next]->depth != $menu->depth) {
                return $items;
            }
        }
        return $items;
    }

    /**
     * Adds icons to labels of the provided items.
     * The items are traversed recursively meaning labels of sub-menus are also adjusted.
     *
     * @param array $items array of items ready for [[yii\widgets\Menu]].
     * @return array items ready for a menu with icons added.
     */
    public function adjustLabels($items)
    {
        $new = [];
        foreach ($items as $item) {
            $label = Yii::t('cms', $item['label']);
            if (empty($item['icon'])) {
                $item['label'] = '<span>' . $label . '</span>';
            } else {
                $item['label'] = '<i class="fa fa-' . $item['icon'] . '"></i> <span>' . $label . '</span>';
            }
            if (isset($item['items'])) {
                $item['label'] .= ' <i class="fa fa-angle-left pull-right"></i>';
                $item['items'] = $this->adjustLabels($item['items']);
            }
            $new[] = $item;
        }
        return $new;
    }

    /**
     * Checks whether a menu item is active.
     * This is true when the module/controller part of the current route matches module/controller part of the provided item.
     *
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {
        $route = Yii::$app->controller->getRoute();
        $route = substr($route, 0, strrpos($route, '/'));
        $menuRoute = trim($item['url'][0], '/');
        if (substr($menuRoute, 0, strrpos($menuRoute, '/')) === $route) {
            return true;
        }
        return false;
    }
    
    /**
     * Remebers whether the admin menu is collapsed.
     * The selection is saved in the current session.
     *
     * @param string $collapsed whether the admin menu is collapsed. "1" if menu is collapsed and "0" if it is not collapsed.
     */
    public static function setIsCollapsed($collapsed)
    {
        Yii::$app->getSession()->set(static::SESSION_VAR_COLLAPSED, $collapsed);
    }
    
    /**
     * Returns a boolean indicating whether the admin menu is collapsed.
     *
     * @return boolean whether the admin menu is collapsed.
     */
    public static function getIsCollapsed()
    {
        return Yii::$app->getSession()->get(static::SESSION_VAR_COLLAPSED) === '1';
    }
}

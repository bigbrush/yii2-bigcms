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
    const ADMIN_MENU_STATE_VAR = '__cms_menu_collapsed__';

    /**
     * @var boolean whether to use icons in the menu.
     */
    public $useIcons = true;


    /**
     * Initializes this widget.
     */
    public function init()
    {
        parent::init();
        $this->items = $this->getItems($this->useIcons);
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
    public function getItems($useIcons = true)
    {
        $items = $this->getTree();
        if ($useIcons) {
            return $this->adjustLabels($items);
        } else {
            return $items;
        }
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
            if (isset($item['icon'])) {
                $icon = $item['icon'];
                unset($item['icon']);
                $item['label'] = '<i class="fa fa-'.$icon.'"></i> <span>' . $item['label'] . '</span>';
            } else {
                $item['label'] = '<span>' . $item['label'] . '</span>';
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
     * Returns the menu tree.
     *
     * @return array the menu tree.
     */
    public function getTree()
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            return [
                ['label' => Yii::t('cms', 'Welcome'), 'url' => ['/'], 'icon' => 'home', 'active' => true]
            ];
        } else {
            return [
                ['label' => Yii::t('cms', 'Home'), 'url' => ['/'], 'icon' => 'home'],
                ['label' => Yii::t('cms', 'Content'), 'url' => '#', 'icon' => 'paw',
                    'items' => [
                        ['label' => Yii::t('cms', 'Pages'), 'url' => ['/pages/page/index'], 'icon' => 'file'],
                        ['label' => 'Categories', 'url' => ['/pages/category/index'], 'icon' => 'bars'],
                    ]
                ],
                ['label' => Yii::t('cms', 'Navigation'), 'url' => '#', 'icon' => 'compass',
                    'items' => [
                        ['label' => Yii::t('cms', 'Menu items'), 'url' => ['/big/menu/index'], 'icon' => 'tree'],
                        ['label' => Yii::t('cms', 'Menus'), 'url' => ['/big/menu/menus'], 'icon' => 'bars'],
                    ]
                ],
                ['label' => Yii::t('cms', 'Blocks'), 'url' => ['/big/block/index'], 'icon' => 'square'],
                ['label' => Yii::t('cms', 'File manager'), 'url' => ['/big/media/show'], 'icon' => 'picture-o'],
                ['label' => Yii::t('cms', 'Templates'), 'url' => ['/big/template/index'], 'icon' => 'simplybuilt'],
                ['label' => Yii::t('cms', 'System'), 'url' => '#', 'icon' => 'gears',
                    'items' => [
                        ['label' => Yii::t('cms', 'Users'), 'url' => ['/big/user/index'], 'icon' => 'users'],
                        ['label' => Yii::t('cms', 'Extensions'), 'url' => ['/big/extension/index'], 'icon' => 'plug'],
                    ]
                ],
            ];
        }
    }
    
    /**
     * Remebers whether the admin menu is collapsed.
     * The selection is saved in the current session.
     *
     * @param string $collapsed whether the admin menu is collapsed. "1" if menu is collapsed and "0" if it is not collapsed.
     */
    public static function setIsCollapsed($collapsed)
    {
        Yii::$app->getSession()->set(static::ADMIN_MENU_STATE_VAR, $collapsed);
    }
    
    /**
     * Returns a boolean indicating whether the admin menu is collapsed.
     *
     * @return boolean whether the admin menu is collapsed.
     */
    public static function getIsCollapsed()
    {
        return Yii::$app->getSession()->get(static::ADMIN_MENU_STATE_VAR) === '1';
    }
}
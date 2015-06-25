<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_103538_create_admin_menu extends Migration
{
    public function up()
    {
        $this->batchInsert('{{%admin_menu}}', ['title', 'alias', 'route', 'state', 'tree', 'lft', 'rgt', 'depth', 'is_default', 'params'], [
            ['Main menu', 'main-menu', '', 1, 1, 1, 30, 0, 0, ''],
            ['Home', 'home', '/', 1, 1, 2, 3, 1, 1, '{"icon":"home"}'],
            ['Content', 'content', '#', 1, 1, 4, 9, 1, 0, '{"icon":"paw"}'],
            ['Pages', 'pages', '/pages/page/index', 1, 1, 5, 6, 2, 0, '{"icon":"file"}'],
            ['Categories', 'categories', '/pages/category/index', 1, 1, 7, 8, 2, 0, '{"icon":"bars"}'],
            ['Navigation', 'navigation', '#', 1, 1, 10, 15, 1, 0, '{"icon":"compass"}'],
            ['Menu items', 'menu-items', '/big/menu/index', 1, 1, 11, 12, 2, 0, '{"icon":"tree"}'],
            ['Menus', 'menus', '/big/menu/menus', 1, 1, 13, 14, 2, 0, '{"icon":"bars"}'],
            ['Blocks', 'blocks', '/big/block/index', 1, 1, 16, 17, 1, 0, '{"icon":"square"}'],
            ['File manager', 'file-manager', '/big/media/show', 1, 1, 18, 19, 1, 0, '{"icon":"picture-o"}'],
            ['Templates', 'templates', '/big/template/index', 1, 1, 20, 21, 1, 0, '{"icon":"simplybuilt"}'],
            ['System', 'system', '#', 1, 1, 22, 29, 1, 0, '{"icon":"gears"}'],
            ['Users', 'users', '/big/user/index', 1, 1, 23, 24, 2, 0, '{"icon":"users"}'],
            ['Extensions', 'extensions', '/big/extension/index', 1, 1, 25, 26, 2, 0, '{"icon":"plug"}'],
            ['Menus', 'menus', '/big/admin-menu/index', 1, 1, 27, 28, 2, 0, '{"icon":"tree"}'],
        ]);
    }

    public function down()
    {
        $this->truncateTable('{{%admin_menu}}');
    }
}

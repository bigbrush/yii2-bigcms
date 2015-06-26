<?php

use yii\db\Schema;
use yii\db\Migration;
use yii\db\Expression;

class m150530_182223_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // create the admin_menu table as a copy of menu table. Only structure is copied
        $sql = $this->db->quoteSql('CREATE TABLE {{%admin_menu}} LIKE {{%menu}};');
        $this->execute($sql);

        // page table
        $this->createTable('{{%page}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'alias' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'state' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'meta_title' => Schema::TYPE_STRING . ' NOT NULL',
            'meta_description' => Schema::TYPE_STRING . ' NOT NULL',
            'meta_keywords' => Schema::TYPE_STRING . ' NOT NULL',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        // user table
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'phone' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'state' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        // insert default block extensions into extension table
        $this->insert('{{%extension}}', [
            'id' => 1,
            'name' => 'Pages categories',
            'type' => 'block',
            'namespace' => 'bigbrush\cms\blocks\pagescategories\Block',
            'description' => '',
            'state' => 1,
        ]);
        $this->insert('{{%extension}}', [
            'id' => 2,
            'name' => 'Contact',
            'type' => 'block',
            'namespace' => 'bigbrush\cms\blocks\contact\Block',
            'description' => '',
            'state' => 1,
        ]);
        $this->insert('{{%extension}}', [
            'id' => 3,
            'name' => 'Menu',
            'type' => 'block',
            'namespace' => 'bigbrush\cms\blocks\menu\Block',
            'description' => '',
            'state' => 1,
        ]);
        $this->insert('{{%extension}}', [
            'id' => 4,
            'name' => 'Text',
            'type' => 'block',
            'namespace' => 'bigbrush\cms\blocks\text\Block',
            'description' => '',
            'state' => 1,
        ]);

        // insert default categories into category table
        $this->insert('{{%category}}', [
            'id' => 1,
            'module' => 'pages',
            'title' => 'pages',
            'content' => '',
            'state' => 1,
            'tree' => 1,
            'lft' => 1,
            'rgt' => 4,
            'depth' => 0,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
            'alias' => 'pages-root',
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'params' => '',
        ]);
        $this->insert('{{%category}}', [
            'id' => 2,
            'module' => '',
            'title' => 'Pages',
            'content' => '',
            'state' => 1,
            'tree' => 1,
            'lft' => 2,
            'rgt' => 3,
            'depth' => 1,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
            'alias' => 'pages',
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'params' => '',
        ]);

        // insert home page into page table
        $this->insert('{{%page}}', [
            'id' => 1,
            'title' => 'Welcome to Big CMS demo site',
            'alias' => 'welcome-to-big-cms-demo-site',
            'content' => '<p>Thank you for choosing Big CMS.</p><p>You can <a href="admin">visit the backend</a> and login with the following credentials:</p><p><strong>Username</strong>: bigadmin</p><p><strong>Password</strong>: bigadmin</p>',
            'category_id' => 2,
            'state' => 1,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
            'created_by' => 1,
            'updated_by' => 1,
            'meta_title' => 'Big CMS demo site',
            'meta_description' => '',
            'meta_keywords' => '',
            'template_id' => 0,

        ]);
        
        // insert a menu and a home menu item into menu table
        $this->insert('{{%menu}}', [
            'id' => 1,
            'title' => 'Main menu',
            'alias' => 'main-menu',
            'route' => '',
            'state' => 1,
            'tree' => 1,
            'lft' => 1,
            'rgt' => 4,
            'depth' => 0,
            'is_default' => 0,
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'params' => '',
        ]);
        $this->insert('{{%menu}}', [
            'id' => 2,
            'title' => 'Welcome',
            'alias' => 'welcome',
            'route' => 'pages/page/show&id=1&catid=2&alias=welcome-to-big-cms-demo-site',
            'state' => 1,
            'tree' => 1,
            'lft' => 2,
            'rgt' => 3,
            'depth' => 1,
            'is_default' => 1,
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'params' => '',
        ]);
        
        // insert a default admin into user table
        $this->insert('{{%user}}', [
            'id' => 1,
            'name' => 'Admin',
            'username' => 'bigadmin',
            'email' => 'admin@admin.com',
            'phone' => '',
            'auth_key' => '',
            'password_hash' => '$2y$13$r.hdHfm654WFTrFZgAE3/eC6jEukNnQzoZhB/kt3et53J.0snTYAy', // bigadmin
            'password_reset_token' => '',
            'state' => 1,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%user}}');
    }
}

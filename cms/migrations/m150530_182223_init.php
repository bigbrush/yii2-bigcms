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
            'namespace' => 'cms\blocks\pagescategories\Block',
            'description' => '',
            'state' => 1,
        ]);
        $this->insert('{{%extension}}', [
            'id' => 2,
            'name' => 'Contact',
            'type' => 'block',
            'namespace' => 'cms\blocks\contact\Block',
            'description' => '',
            'state' => 1,
        ]);
        $this->insert('{{%extension}}', [
            'id' => 3,
            'name' => 'Menu',
            'type' => 'block',
            'namespace' => 'cms\blocks\menu\Block',
            'description' => '',
            'state' => 1,
        ]);
        $this->insert('{{%extension}}', [
            'id' => 4,
            'name' => 'Text',
            'type' => 'block',
            'namespace' => 'cms\blocks\text\Block',
            'description' => '',
            'state' => 1,
        ]);
        
        // insert a default admin into user table
        $this->insert('{{%user}}', [
            'id' => 1,
            'name' => 'Admin',
            'username' => 'admin',
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

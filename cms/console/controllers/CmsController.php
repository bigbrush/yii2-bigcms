<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\console\controllers;

use Yii;
use yii\console\controllers\MigrateController;
use yii\helpers\Console;
use yii\db\Exception;
use bigbrush\cms\Cms;

/**
 * Installs Big Cms by collecting database login credentials from the user and creating config files
 * ready for a Yii 2 application in production mode.
 * 
 * You may install Big Cms as follows:
 * ~~~
 * yii cms/install
 * ~~~
 * 
 * Setting a language when installing
 * ~~~
 * yii cms/install --language=da
 * ~~~
 * 
 * Specifing a database type when installing
 * In the current version only mysql is supported. See [[supportedDatabases]] for supported databases.
 * ~~~
 * yii cms/install mysql
 * ~~~
 * 
 * Or if you want to specify database credentials directly
 * ~~~
 * yii cms/install --host=hostName --name=databaseName
 * ~~~
 * 
 * During the installation you will be asked to provide your database login credentials.
 */
class CmsController extends MigrateController
{
    /**
     * @var string the class of a database connection.
     */
    public $class = 'yii\db\Connection';
    /**
     * @var string the database host.
     */
    public $host;
    /**
     * @var string the database name.
     */
    public $name;
    /**
     * @var string the username for the database.
     */
    public $username;
    /**
     * @var string the password for the database.
     */
    public $password;
    /**
     * @var string the language to set in config files. Defaults to the default application language when installing.
     */
    public $language;
    /**
     * @var string the database charset.
     */
    public $charset = 'utf8';
    /**
     * @var string defines the target directory for created config files.
     */
    protected $configPath = '@app/common/config';
    /**
     * @var string name of the "db" config file used by Big Cms.
     */
    protected $dbConfigFile = 'db.php';
    /**
     * @var array list of file paths used when applying migrations.
     * Big Framework needs to be migrated first.
     */
    protected $migrationPaths = [
        '@bigbrush/big/migrations',
        '@bigbrush/cms/migrations',
    ];
    /**
     * @var array list of supported databases for generating the "db.php" config file.
     * The keys are supported database types and the values are path aliases used when rendering the config file template.
     * 
     * Adding support for other databases:
     * Add an entry to this parameter and create a corresponding view file. The view file is automatically
     * loaded in [[createConfigFiles()]].
     */
    protected $supportedDatabases = [
        'mysql' => '@bigbrush/cms/console/views/mysql.php',
    ];


    /**
     * Initializes this controller by setting a default database connection. Required because the db
     * instance is checked in [[MigrateController::beforeAction()]].
     * The database connection is updated in [[actionInstall()]] after the "db" config file has been created.
     */
    public function init()
    {
        parent::init();
        $this->db = Yii::createObject(['class' => $this->class]);
        $this->migrationPath = '@bigbrush/cms/migrations';
        $this->defaultAction = 'info';
        $this->dbConfigFile = Yii::getAlias($this->configPath . '/' . $this->dbConfigFile);
    }

    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * It blocks the standard Yii migration text from being outputted. It does so by only running the
     * parent implementation when the provided action id is not "info".
     */
    public function beforeAction($action)
    {
        if ($action->id === 'info') {
            return true;
        } else {
            return parent::beforeAction($action);
        }
    }

    /**
     * Gives the user an option to choose from. Giving '?' as an input will show
     * a list of options to choose from and their explanations.
     *
     * @param string $prompt the prompt message
     * @param array $options Key-value array of options to choose from
     *
     * @return string An option character the user chose
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ['class', 'host', 'name', 'username', 'password', 'language', 'charset']
        );
    }

    /**
     * Provides helpful information about installing Big Cms.
     * 
     * Use as follows:
     * ~~~
     * yii cms/help
     * ~~~
     */
    public function actionHelp()
    {
        $version = Cms::VERSION;
        $this->stdout("Big Cms v{$version}.\n", Console::FG_YELLOW);
        $this->stdout("Created by BIG Brush Agency ApS\n\n", Console::FG_YELLOW);

        $this->stdout("Installing Big Cms:\n", Console::FG_YELLOW);
        $this->stdout("yii cms/install\n\n", Console::FG_YELLOW);

        $this->stdout("Choosing a language:\n", Console::FG_YELLOW);
        $this->stdout("yii cms/install --language=es\n\n", Console::FG_YELLOW);
        
    }

    /**
     * Installs Big Cms.
     *
     * The type of database to use can be specified by the provided parameter.
     *
     * Do the following to install Big Cms with a sqlite database:
     * ~~~php
     * yii cms/install sqlite
     * ~~~
     *
     * @param string $type a database type to create a config file for.
     * Defaults to "mysql".
     */
    public function actionInstall($type = 'mysql')
    {
        if ($this->language === null) {
            $this->language = Yii::$app->language;
        }
        $version = Cms::VERSION;
        $this->stdout("Big Cms Install Tool (based on Cms v{$version}).\n", Console::FG_YELLOW);
        
        // check if the provided database type is supported
        if (!isset($this->supportedDatabases[$type])) {
            $this->stdout("Database of type '$type' is not supported.\n", Console::FG_RED);
            $this->stdout("Supported databases:\n", Console::FG_YELLOW);
            $supported = [];
            foreach (array_keys($this->supportedDatabases) as $type) {
                $supported[] = '  - ' . $type;
            }
            $this->stdout(implode("\n", $supported), Console::FG_YELLOW);
            return self::EXIT_CODE_ERROR;
        }

        // acquire database settings from user (if not set through console)
        $this->acquireDatabaseCredentials();

        // create config files.
        $this->createConfigFiles($type);
        $this->stdout("\n");

        $this->stdout("  - Application configured\n", Console::FG_GREEN);

        // test database connection based on created "db" config file
        $config = require($this->dbConfigFile);
        $connection = Yii::createObject($config);
        if ($this->testDatabaseConnection($connection) === self::EXIT_CODE_ERROR) {
            $this->stdout("Database connection could not be established\n", Console::FG_RED);
            $this->stdout("Try to run the install command again and apply new database settings\n", Console::FG_YELLOW);
            return self::EXIT_CODE_ERROR;
        }
            
        $this->stdout("  - Database connection established\n", Console::FG_GREEN);
        $this->stdout("  - Migrating database\n", Console::FG_GREEN);
        $this->stdout("\n");

        // apply migrations
        $this->db = $connection;
        if ($this->applyMigrations() === self::EXIT_CODE_ERROR) {
            $this->stdout("Database migration could not be applied.\n", Console::FG_RED);
            return self::EXIT_CODE_ERROR;
        }
        
        // install completed successfully
        $this->stdout("\nCms installed and ready to use.\n", Console::FG_GREEN);
    }

    /**
     * Reconfigures the database credentials.
     * The cms must be installed before calling this command.
     *
     * @param string $type a database type to create a config file for.
     * Defaults to "mysql".
     */
    public function actionConfigure($type = 'mysql')
    {
        // if config file doesn't exist cms is not installed
        $file = Yii::getAlias($this->configPath . '/admin.php');
        if (!is_file($file)) {
            $this->stdout("Cms is not installed. Please run the command 'yii cms/install'.\n", Console::FG_RED);
            return self::EXIT_CODE_ERROR;
        }

        // use the language from the config file if not provided through console
        if ($this->language === null) {
            $config = require($file);
            $this->language = $config['language'];
        }

        // update config files
        $this->acquireDatabaseCredentials();
        $this->createConfigFiles($type);
        $this->stdout("\nNew configurations applied.\n", Console::FG_GREEN);
    }

    /**
     * Creates config files used by Big Cms.
     * The default configuration is production ready.
     *
     * The "db.php" config file is created based on the provided type of database.
     *
     * @param string $type a database type to use when creating the "db" config file.
     */
    public function createConfigFiles($type)
    {
        // create "db.php" config file.
        $content = $this->renderFile($this->supportedDatabases[$type], [
            'class' => $this->class,
            'host' => $this->host,
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'charset' => $this->charset,
        ]);
        file_put_contents($this->dbConfigFile, $content);

        // create "admin.php" config file.
        $content = $this->renderFile('@bigbrush/cms/console/views/admin.php', [
            'language' => $this->language,
        ]);
        $file = Yii::getAlias($this->configPath . '/admin.php');
        file_put_contents($file, $content);
        
        // create "web.php" config file.
        $content = $this->renderFile('@bigbrush/cms/console/views/web.php', [
            'language' => $this->language,
        ]);
        $file = Yii::getAlias($this->configPath . '/web.php');
        file_put_contents($file, $content);
    }

    /**
     * Acquires database connection credentials from the user.
     */
    public function acquireDatabaseCredentials()
    {
        $this->stdout("Please provide your database credentials:\n\n", Console::FG_YELLOW);
        if ($this->host === null) {
            $this->host = $this->prompt("Database host:", ['required' => true]);
        }
        if ($this->name === null) {
            $this->name = $this->prompt("Database name:", ['required' => true]);
        }
        if ($this->username === null) {
            $this->username = $this->prompt("Database username:", ['required' => true]);
        }
        if ($this->password === null) {
            $this->password = $this->prompt("Database password:");
        }
    }

    /**
     * Checks that a database connection can be established with the provided credentials.
     *
     * @param yii\db\Connection $connection a [[yii\db\Connection]] object.
     * @return int 0 if a database connection can be established or 1 if the database connection could not be established.
     */
    protected function testDatabaseConnection(&$connection)
    {
        try {
            $connection->open();
            return self::EXIT_CODE_NORMAL;
        } catch (Exception $e) {
            return self::EXIT_CODE_ERROR;
        }
    }

    /**
     * Applies migrations for the cms.
     *
     * @return int 0 if all migrations are applied successful and 1 if not.
     */
    public function applyMigrations()
    {
        foreach ($this->migrationPaths as $path) {
            $this->migrationPath = Yii::getAlias($path);
            if ($this->actionUp() === self::EXIT_CODE_ERROR) {
                $this->actionDown('all');
                return self::EXIT_CODE_ERROR;
            }
        }
        return self::EXIT_CODE_NORMAL;
    }
}
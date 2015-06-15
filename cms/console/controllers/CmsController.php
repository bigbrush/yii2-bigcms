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
 * CmsController
 *
 * Manages the Cms application installation process.
 * You may install Big Cms as follows:
 * 
 * ~~~
 * yii cms/install
 * 
 * # specify a database type for the installation
 * yii cms/install mysql
 * ~~~
 * 
 * Or if you want to specify database credentials directly:
 * ~~~
 * yii cms/install --host=hostName --name=databaseName
 * ~~~
 * 
 * During the installation you need to provide you
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
     * @var string the database charset.
     */
    public $charset = 'utf8';
    /**
     * @var string alias for the database config file used by Big Cms.
     */
    public $configFile = '@cms/config/db.php';
    /**
     * @var array list of file paths used when applying migrations.
     * Big Framework needs to be migrated first.
     */
    protected $migrationPaths = [
        '@bigbrush/big/migrations',
        '@cms/migrations',
    ];
    /**
     * @var array list of template files for generating the "db.php" config file.
     * The keys are supported database types and the values are a path alias or a file path.
     */
    protected $templateFiles = [
        'mysql' => '@cms/console/views/mysql.php',
    ];
    /**
     * @var array defines a list of options available to the user.
     */
    protected $userOptions = ['class', 'host', 'name', 'username', 'password', 'charset', 'configFile'];


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
            $this->userOptions
        );
    }

    /**
     * Installs Big Cms by creating the database config file ("db.php") and initializing the database.
     *
     * The type of database can be specified by the provided type.
     * In version 0.0.4 only mysql is supported. See [[templateFiles]] for supported databases.
     *
     * ~~~php
     * yii cms/install
     * ~~~
     *
     * Or install to a sqlite database:
     * ~~~php
     * yii cms/install sqlite
     * ~~~
     *
     * @param string $type a database type to create a config file for.
     * Defaults to "mysql".
     */
    public function actionInstall($type = 'mysql')
    {
        $version = Cms::VERSION;
        $this->stdout("--------------------------------------------------------------------\n", Console::FG_YELLOW);
        $this->stdout("Big Cms Install Tool (v{$version}).\n", Console::FG_YELLOW);
        
        $templateFile = $this->getTemplateFile($type);
        if ($templateFile === self::EXIT_CODE_ERROR) {
            $this->stdout("Database of type '$type' is not supported.\n", Console::FG_RED);
            $this->stdout("Supported databases:\n", Console::FG_RED);
            $supported = [];
            foreach (array_keys($this->templateFiles) as $type) {
                $supported[] = '  - ' . $type;
            }
            $this->stdout(implode("\n", $supported), Console::FG_YELLOW);
            return self::EXIT_CODE_ERROR;
        }

        // acquire database settings from user (if not set through console)
        $this->stdout("Please provide your database credentials:\n", Console::FG_YELLOW);
        $this->acquireDatabaseSettings();

        $this->stdout("\n");
        $this->stdout("Starting installation of Big Cms\n", Console::FG_YELLOW);
        $this->stdout("\n");

        // create "db.php" config file.
        if ($this->createDatabaseConfigFile($templateFile) === self::EXIT_CODE_ERROR) {
            $this->stdout("\nConfiguration file could not be created - please try again.\n", Console::FG_RED);
            return self::EXIT_CODE_ERROR;
        }

        $this->stdout("  - Configuration file created\n", Console::FG_GREEN);

        // check database based on created db config file
        $config = require(Yii::getAlias($this->configFile));
        $connection = Yii::createObject($config);
        if ($this->checkDatabaseConnection($connection) === self::EXIT_CODE_ERROR) {
            $this->stdout("Database connection could not be established\n", Console::FG_RED);
            $this->stdout("Try to run the install command again and apply new database settings\n", Console::FG_YELLOW);
            return self::EXIT_CODE_ERROR;
        }
            
        $this->stdout("  - Database connection established\n", Console::FG_GREEN);
        $this->stdout("  - Creating database\n", Console::FG_GREEN);
        $this->stdout("\n");

        // apply migrations
        $this->db = $connection;
        if ($this->applyMigrations() === self::EXIT_CODE_ERROR) {
            $this->stdout("Database migration could not be applied.\n", Console::FG_RED);
            return self::EXIT_CODE_ERROR;
        }
        
        // install completed successfully
        $this->stdout("\n");
        $this->stdout("  - Database created\n", Console::FG_GREEN);
        $this->stdout("  - Setup completed\n", Console::FG_GREEN);
        $this->stdout("\n");
        $this->stdout("Cms installed and ready to use.\n", Console::FG_GREEN);
        $this->stdout("\n");
        $this->stdout("--------------------------------------------------------------------\n", Console::FG_RED);
    }

    /**
     * Returns a template file path based on the provided type.
     *
     * @return string|int a template file path or an error code if the provided database type is not supported.
     */
    public function getTemplateFile($type)
    {
        if (isset($this->templateFiles[$type])) {
            return $this->templateFiles[$type];
        } else {
            return self::EXIT_CODE_ERROR;
        }
    }

    /**
     * Acquires database connection settings from the user.
     */
    public function acquireDatabaseSettings()
    {
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
     * Creates the "db.php" config file from the provided template.
     *
     * @param string $template the template to use when creating the file.
     * @return boolean true if file is created and false if not.
     */
    public function createDatabaseConfigFile($template)
    {
        $file = Yii::getAlias($this->configFile);
        $content = $this->renderFile($template, [
            'class' => $this->class,
            'host' => $this->host,
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'charset' => $this->charset,
        ]);     
        $errors = file_put_contents($file, $content);
        if ($errors !== false) {
            return true;
        } else {
            return self::EXIT_CODE_ERROR;
        }
    }

    /**
     * Checks that the provided database connection can be established.
     *
     * @param yii\db\Connection $connection a [[yii\db\Connection]] object.
     * @return boolean|int true if a database connection can be established or an error code
     * if the provided database type is not supported.
     */
    protected function checkDatabaseConnection(&$connection)
    {
        try {
            $connection->open();
            return true;
        } catch (Exception $e) {
            return self::EXIT_CODE_ERROR;
        }
    }

    /**
     * Applies migrations for the cms.
     *
     * @return boolean true if migration succeeds and false if not.
     */
    public function applyMigrations()
    {
        foreach ($this->migrationPaths as $path) {
            $this->migrationPath = Yii::getAlias($path);
            $this->actionUp();
        }
        return true;
    }
}
<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms;

use Yii;
use yii\base\Object;
use yii\base\BootstrapInterface;
use yii\helpers\Url;
use cms\components\AdminMenu;

/**
 * Cms
 */
class Cms extends Object implements BootstrapInterface
{
    /**
     * scopes
     */
    const SCOPE_FRONTEND = 'frontend';
    const SCOPE_BACKEND = 'backend';
    /**
     * version
     */
    const VERSION = '0.0.2';

    /**
     * @var array list of components used in the CMS.
     */
    public $components = [];
    /**
     * @var string the application scope.
     * This is to set correct base url for the editor and file manager in [[bootstrap()]] method.
     * Defaults to [[SCOPE_FRONTEND]].
     */
    private $_scope;


    /**
     * Bootstraps the Cms component.
     * This methods runs after the application is configured.
     *
     * @param yii\base\Application $app the application currently running.
     */
    public function bootstrap($app)
    {
        // enable translations
        $config = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@cms/messages',
        ];
        Yii::$app->i18n->translations['cms*'] = $config;
        // override translations registered by Big
        Yii::$app->big->registerTranslations($config);
        
        // register a default scope if not set
        if ($this->_scope === null) {
            $this->setScope($this->getDefaultScope());
        }

        $scope = $this->getScope();

        // set a new default base url in editor and file manager if scope is "backend"
        // this way the widgets can be used without setting the base url each time. The base url can still be overridden 
        if ($scope === self::SCOPE_BACKEND) {
            $baseUrl = Url::to('@web/../');
            Yii::$container->set('bigbrush\big\widgets\editor\Editor', [
                'baseUrl' => $baseUrl,
            ]);
            Yii::$container->set('bigbrush\big\widgets\filemanager\FileManager', [
                'baseUrl' => $baseUrl,
            ]);
        }
    }

    /**
     * Returns the admin menu.
     *
     * @return cms\components\AdminMenu an admin menu instance.
     */
    public function getAdminMenu()
    {
        if (!isset($this->components['adminMenu'])) {
            $this->components['adminMenu'] = Yii::createObject([
                'class' => AdminMenu::className(),
            ]);
        }
        return $this->components['adminMenu'];
    }

    /**
     * Returns the toolbar.
     * NOTE: NOT FULLY IMPLEMENTED - ONLY USED BY Big module in BlockController::actionEdit() in the view.
     *
     * @return cms\components\Toolbar a toolbar instance.
     */
    public function getToolbar()
    {
        return Yii::$app->toolbar;
    }

    /**
     * Sets the application scope.
     *
     * @return mixed the application scope.
     * @throws InvalidCallException if scope is set after application has been configured.
     */
    public function setScope($scope)
    {
        if ($this->_scope !== null) {
            throw new InvalidCallException("Scope can only be set through application configuration.");
        }
        $this->_scope = $scope;
    }

    /**
     * Returns the application scope.
     *
     * @return mixed the application scope.
     */
    public function getScope()
    {
        return $this->_scope;
    }

    /**
     * Returns the default scope of the Cms.
     *
     * @return string id of the default scope.
     */
    public function getDefaultScope()
    {
        return static::SCOPE_FRONTEND;
    }

    /**
     * Returns an array of available scopes in the Cms. The keys are scope ids and the values are translated names of each scope.
     *
     * @return array list of avaiable scopes.
     */
    public function getAvailableScopes()
    {
        return [
            static::SCOPE_FRONTEND => Yii::t('cms', 'Frontend'),
            static::SCOPE_BACKEND => Yii::t('cms', 'Backend'),
        ];
    }

    /**
     * Returns the current version of Big CMS.
     *
     * @return string the current version of Big CMS.
     */
    public function getVersion()
    {
        return self::VERSION;
    }
}
<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Behavior;

/**
 * UrlManagerBehavior
 */
class UrlManagerBehavior extends Behavior
{
    /**
     * @var yii\web\UrlManager the url manager.
     * Used to create urls from backend to frontend and parse urls created by Big.
     */
    private $_urlManager;


    /**
     * Creates an url from the backend to the frontend.
     *
     * @param string|array $params use a string to represent a route (e.g. `site/index`),
     * or an array to represent a route with query parameters (e.g. `['site/index', 'param1' => 'value1']`).
     * @return string the created URL.
     */
    public function createUrlFrontend($params)
    {
        return $this->getUrlManager()->createUrl($params);
    }

    /**
     * Parses an url created by Big.
     * Use this when using [[bigbrush\big\widgets\bigsearch\BigSearch]].
     *
     * @param string $url an internal url.
     * @return array route params ready for [[yii\web\UrlManager::createUrl()]].
     */
    public function parseInternalUrl($url)
    {
        return Yii::$app->big->urlManager->parseInternalUrl($url);
    }

    /**
     * Returns the url manager.
     *
     * @return yii\web\urlManager
     */ 
    public function getUrlManager()
    {
        if ($this->_urlManager === null) {
            $config = require(Yii::getAlias('@app/common/config/web.php'));
            $config = $config['components']['urlManager'];
            $config['class'] = 'yii\web\urlManager';
            $config['baseUrl'] = '@web/../';
            $config['rules'] = [Yii::$app->big->urlManager];
            $this->_urlManager = Yii::createObject($config);
        }
        return $this->_urlManager;
    }
}

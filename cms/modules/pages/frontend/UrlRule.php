<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\modules\pages\frontend;

use yii\base\Object;
use yii\web\UrlRuleInterface;

/**
 * UrlRule
 */
class UrlRule extends Object implements UrlRuleInterface
{
    /**
     * @var string defines the id of this url rule. Rules needs
     * an id to identify whether it should react when parsing. Different
     * rules could use the same url pattern which would make it difficult
     * to separate them.
     */
    public $id = 'page';


    /**
     * Creates a URL according to the given route and parameters.
     * 
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'pages/page/show') {
            return $this->id.'/'.$params['id'].':'.$params['alias'];
        }
        return false;
    }

    /**
     * Parses the given request and returns the corresponding route and parameters.
     * 
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|boolean the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (strpos($pathInfo, $this->id) === 0 && strpos($pathInfo, ':') !== false) {
            $pathInfo = substr($pathInfo, 5); // remove "page/"
            list($id, $alias) = explode(':', $pathInfo);
            return ['pages/page/show', ['id' => $id]];
        }
        return false;
    }
}

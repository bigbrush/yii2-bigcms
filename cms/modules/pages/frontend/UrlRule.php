<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\frontend;

use Yii;
use yii\base\Object;
use yii\web\UrlRuleInterface;
use bigbrush\cms\modules\pages\components\Route;

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
            $category = Yii::$app->big->categoryManager->getItem($params['catid']);
            $menuManager = Yii::$app->big->menuManager;
            $route = Route::raw($category, Route::TYPE_CATEGORY);
            // check if a menu has been created for a category matching the requested page
            if ($menu = $menuManager->search('route', $route)) {
                $prepend = $menu->getQuery() . '/';
            } else {
                $prepend = $this->id . '/';
            }
            return $prepend . $params['id'] . ':' . $params['alias'];
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
        if (strpos($pathInfo, '/') !== false) {
            $segments = explode('/', $pathInfo);
            $identifier = false;
            // a page without a menu
            if ($segments[0] === $this->id) {
                $identifier = $segments[1];
            } else {
                // last segment is our identifier, we need the segment right before that
                // to check if it matches a menu pointing to a pages category
                $alias = $segments[count($segments) - 2];
                // a page with a category as menu
                $menu = Yii::$app->big->menuManager->search('alias', $alias);
                if ($menu && strpos($menu->route, 'pages/category/pages') === 0) {
                    $identifier = array_pop($segments);
                }
            }
            if ($identifier !== false) {
                $id = substr($identifier, 0, strpos($identifier, ':'));
                return ['pages/page/show', ['id' => $id]];
            }
        }
        return false;
    }
}

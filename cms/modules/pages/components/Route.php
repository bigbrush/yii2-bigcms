<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\components;

use Yii;
use yii\base\InvalidParamException;

/**
 * Route
 */
class Route
{
    const TYPE_PAGE = 'page';
    const TYPE_CATEGORY = 'category';

    /**
     * Returns a route array for a page.
     *
     * @param array|Page either an array or a Page model.
     * @param string $prepend a string that is prepended to the route action. 
     * @return array route parameters for a single page.
     */
    public static function page($page, $prepend = '')
    {
        return [$prepend . 'pages/page/show', 'id' => $page['id'], 'catid' => $page['category_id'], 'alias' => $page['alias']];
    }

    /**
     * Returns a route array for a category.
     *
     * @param array|bigbrush\big\core\ManagerObject either an array or a manager object.
     * @param string $prepend a string that is prepended to the route action. 
     * @return array route parameters for a category.
     */
    public static function category($category, $prepend = '')
    {
        return [$prepend . 'pages/category/pages', 'catid' => $category['id'], 'alias' => $category['alias']];
    }

    /**
     * Returns a raw route as a string.
     *
     * @param mixed $item an item to create a route for.
     * @param string $type the type of route to create. Use [[TYPE_PAGE]] and [[TYPE_CATEGORY]].
     * @return string a raw route.
     */
    public static function raw($item, $type)
    {
        $valid = [self::TYPE_PAGE, self::TYPE_CATEGORY];
        if (!in_array($type, $valid)) {
            throw new InvalidParamException("The provided type is not valid. Type provided: '$type'");
        }
	    $route = self::$type($item);
        $action = $route[0];
        unset($route[0]);
        return $action . '&' . http_build_query($route);
    }
}

<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\components;

use bigbrush\big\core\MenuManager;

/**
 * AdminMenuManager
 */
class AdminMenuManager extends MenuManager
{
    public $modelClass = 'bigbrush\cms\models\AdminMenu';
}
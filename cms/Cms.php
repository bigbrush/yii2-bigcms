<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms;

use Yii;
use yii\base\Object;
use cms\components\AdminMenu;

/**
 * Cms
 */
class Cms extends Object
{
    const VERSION = '0.0.1';

    /**
     * @var array list of components used in the CMS.
     */
    public $components = [];


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
     * Returns the current version of Big CMS.
     *
     * @return string the current version of Big CMS.
     */
    public function getVersion()
    {
        return self::VERSION;
    }
}
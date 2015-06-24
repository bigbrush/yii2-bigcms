<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

/**
 * Render the default view
 */
echo $this->render('@bigbrush/cms/modules/big/backend/views/menu/menus.php', [
    'dataProvider' => $dataProvider,
]);

/**
 * Add another toolbar icon
 */
Yii::$app->toolbar->add(Yii::t('cms', 'Menu items'), ['index'], 'random');
?>

<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\modules\pages\components;

use Yii;
use cms\modules\pages\models\Page;

/**
 * PageFinder
 */
class PageFinder
{
    /**
     * Registers page content when big performs a search.
     * See [[bigbrush\big\core\Big::search()]] for more information about the search process.
     *
     * @param bigbrush\big\core\SearchEvent $event the event being triggered
     */
    public static function onSearch($event)
    {
        $query = Page::find()->select(['id', 'title', 'category_id', 'alias', 'content', 'created_at'])->orderBy('title')->asArray();
        // adjust query if $event->value is not empty. Then a search for a specific value is being made.
        if (!empty($event->value)) {
            $query->orWhere(['like', 'title', $event->value]);
            $query->orWhere(['like', 'content', $event->value]);
        }
        $items = $query->all();
        foreach ($items as $item) {
            $event->addItem([
                'title' => $item['title'],
                'route' => Route::page($item),
                'text' => substr($item['content'], 0, 100),
                'date' => $item['created_at'],
                'section' => Yii::t('cms', 'Pages'),
            ]);
        }

        // pages categories
        $query = Yii::$app->big->categoryManager->getModel()->find()->select(['id', 'title', 'alias', 'content', 'created_at', 'depth'])
                 ->orderBy('created_at')->asArray()->andWhere('lft > 1');
        // adjust query if $event->value is not empty. Then a search for a specific value is being made.
        if (!empty($event->value)) {
            $query->orWhere(['like', 'title', $event->value]);
            $query->orWhere(['like', 'content', $event->value]);
        }
        $items = $query->all();
        foreach ($items as $item) {
            $event->addItem([
                'title' => str_repeat('- ', $item['depth'] - 1) . $item['title'],
                'route' => Route::category($item),
                'text' => substr($item['content'], 0, 100),
                'date' => $item['created_at'],
                'section' => Yii::t('cms', 'Pages categories'),
            ]);
        }
    }
}

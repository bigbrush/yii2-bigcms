<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\frontend\controllers;

use Yii;
use yii\web\Controller;
use bigbrush\cms\modules\pages\models\Page;
use bigbrush\cms\widgets\Editor;

/**
 * CategoryController
 */
class CategoryController extends Controller
{
    /**
     * Shows pages from a single category.
     *
     * @param int $catid id of a category to load articles from.
     * @return string the rendering result.
     */
    public function actionPages($catid)
    {
        $pages = Page::find()->byCategory($catid)->byState(Page::STATE_ACTIVE)->orderBy('created_at')->all();
        foreach ($pages as $page) {
            $page->content = Editor::process($page->content);
        }
        return $this->render('pages', [
            'pages' => $pages,
        ]);
    }
}

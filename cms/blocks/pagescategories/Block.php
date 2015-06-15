<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\blocks\pagescategories;

use Yii;
use yii\validators\Validator;
use bigbrush\cms\blocks\pagescategories\components\ModelBehavior;
use bigbrush\cms\modules\pages\models\Page;

/**
 * Block
 *
 * @property bigbrush\big\models\Block $model
 */
class Block extends \bigbrush\big\core\Block
{
    /**
     * Initializes the block.
     */
    public function init()
    {
        $this->model->attachBehavior('blockBehavior', ['class' => ModelBehavior::className(), 'owner' => $this->model]);
    }

    /**
     * Runs the block.
     *
     * @return string the content of this block.
     */
    public function run()
    {
        $orderCondition = $this->model->order_by . ' ' . $this->model->order_direction;
        $maxPages = (int)$this->model->max_pages;
        $query = Page::find()
            ->byCategory($this->model->category_id)
            ->byState(Page::STATE_ACTIVE)
            ->orderBy($orderCondition)
            ->with(['author', 'editor']);
        if ($maxPages > 0) {
            $query->limit($this->model->max_pages);
        }
        $pages = $query->asArray()->all();
        return $this->render('index', [
            'block' => $this,
            'pages' => $pages,
        ]);
    }

    /**
     * Edits the block.
     *
     * @param Block $model the model for this block.
     * @param yii\bootstrap\ActiveForm $form the form used to edit this block.
     * @return string html form ready to be rendered.
     */
    public function edit($model, $form)
    {
        $categories = ['' => Yii::t('cms', 'Select category')] + Yii::$app->big->categoryManager->getDropDownList('pages');
        $sortOptions = $model->getSortByOptions();
        return $this->render('edit', [
            'model' => $model,
            'form' => $form,
            'categories' => $categories,
            'sortOptions' => $sortOptions,
        ]);
    }

    /**
     * This method gets called right before a block model is saved. The model is validated at this point.
     * In this method any Block specific logic should run. For example saving a block specific model.
     * 
     * @param bigbrush\big\models\Block the model being saved.
     * @return boolean whether the current save procedure should proceed. If any block.
     * specific logic fails false should be returned - i.e. return $blockSpecificModel->save();
     */
    public function save($model)
    {
        $model->updateOwner();
        return true;
    }
}

<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\pagescategories;

use Yii;
use yii\validators\Validator;
use cms\blocks\pagescategories\components\ModelBehavior;
use cms\modules\pages\models\Page;

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
        $pages = Page::find()->byCategory($this->model->category_id)->byState(Page::STATE_ACTIVE)->asArray()->all();
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
        return $this->render('edit', [
            'model' => $model,
            'form' => $form,
        ]);
    }
}

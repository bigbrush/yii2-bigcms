<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\categories;

use Yii;
use yii\validators\Validator;
use cms\blocks\categories\components\ModelBehavior;
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
        $models = Page::find()->byCategory($this->model->category_id)->byState(Page::STATE_ACTIVE)->asArray()->all();
        return $this->render('index', [
            'model' => $this->model,
            'models' => $models,
        ]);
    }

    /**
     * Edits the block.
     *
     * @param Block $model the model for this block.
     * @return string html form ready to be rendered.
     */
    public function edit($model)
    {
        return $this->render('edit', [
            'model' => $model,
        ]);
    }
}

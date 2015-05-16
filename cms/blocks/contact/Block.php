<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\contact;

use cms\blocks\contact\components\ModelBehavior;

/**
 * Block
 *
 * @property bigbrush\big\models\Block $model
 */
class Block extends \bigbrush\big\core\Block
{
    /**
     * Initializes this block by attaching a behavior to [[model]].
     */
    public function init()
    {
        $this->model->attachBehavior('menuBlockBehavior', ['class' => ModelBehavior::className(), 'owner' => $this->model]);
    }

    /**
     * Returns the content of this block
     *
     * @return string the content of this block
     */
    public function run()
    {
    	return $this->render('index', [
    	    'model' => $this->model,
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

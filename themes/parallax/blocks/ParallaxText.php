<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace app\themes\parallax\blocks;

use Yii;
use yii\helpers\Json;
use bigbrush\big\core\Block;

/**
 * ParallaxText
 */
class ParallaxText extends Block
{
    public $text;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->model->content = Json::decode($this->model->content);
        if (!empty($this->model->content)) {
            foreach ($this->model->content as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('content', [
            'block' => $this,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function edit($model, $form)
    {
        return $this->render('edit-content', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function save($model)
    {
        $this->model->content = Json::encode($this->model->content);
        return true;
    }
}

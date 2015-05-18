<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\contact;

use Yii;
use yii\helpers\Url;
use cms\blocks\contact\components\ModelBehavior;
use cms\blocks\contact\models\ContactForm;

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
        $this->model->attachBehavior('contactBehavior', ['class' => ModelBehavior::className(), 'owner' => $this->model]);
    }

    /**
     * Returns the content of this block
     *
     * @return string the content of this block
     */
    public function run()
    {
        $contactModel = new ContactForm();
        $mailer = Yii::$app->mailer;
        if ($contactModel->load(Yii::$app->getRequest()->post()) && $contactModel->validate()) {
            Yii::$app->getSession()->setFlash('success', $this->model->successMessage);
            if (!empty($this->model->redirectTo)) {
                Yii::$app->controller->redirect($this->model->redirectTo);
            } else {
                Yii::$app->controller->refresh();
            }
        }
        return $this->render('index', [
            'model' => $this->model,
            'contactModel' => $contactModel,
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

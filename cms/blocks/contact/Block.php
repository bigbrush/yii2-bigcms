<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace cms\blocks\contact;

use Yii;
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
        if ($contactModel->load(Yii::$app->getRequest()->post()) && $contactModel->validate()) {
            $result = Yii::$app->mailer->compose()
                ->setFrom('from@domain.com')
                ->setTo('mj@philowebstudio.dk')
                ->setSubject('Message subject')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<b>HTML content</b>')
                ->send();
            if ($result) {
                Yii::$app->getSession()->setFlash('success', $this->model->successMessage);
                if (!empty($this->model->redirectTo)) {
                    $url = Yii::$app->big->urlManager->parseInternalUrl($this->model->redirectTo);
                    Yii::$app->controller->redirect($url);
                }
            } else {
                Yii::$app->getSession()->setFlash('error', 'Email not sent - please try again.');
            }
            Yii::$app->controller->refresh();
        }
        return $this->render('index', [
            'block' => $this,
            'contactModel' => $contactModel,
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

    /**
     * Indicates that this block will render its own UI when editing.
     *
     * @return boolean true because this block will take complete control over the UI when editing.
     */
    public function getEditRaw()
    {
        return true;
    }
}

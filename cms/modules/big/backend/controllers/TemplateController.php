<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use bigbrush\big\widgets\templateeditor\TemplateEditor;

/**
 * TemplateController
 */
class TemplateController extends Controller
{
    /**
     * Lists all available templates
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Yii::$app->big->templateManager->getModel()->find(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates and edits a template
     *
     * @param int $id optional template id to edit. If not provided a new template will be created
     */
    public function actionEdit($id = 0)
    {
        $model = TemplateEditor::getModel($id);
        if (TemplateEditor::save($model)) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Template saved.'));
            if (Yii::$app->toolbar->stayAfterSave()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes a block.
     *
     * @return int $id an id of a block to delete.
     * @throws InvalidCallException if id in $_POST does not match the provided id. 
     */
    public function actionDelete($id)
    {
        $templateId = $_POST['id'];
        if ($templateId != $id) {
            throw new InvalidCallException("Invalid form submitted. Template with id: '$id' not deleted.");
        }

        $model = TemplateEditor::getModel($id);
        if ($model->is_default) {
            Yii::$app->getSession()->setFlash('info', Yii::t('cms', 'Cannot delete the default template.'));
        } elseif ($model->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Template deleted.'));
        } else {
            Yii::$app->getSession()->setFlash('error',  Yii::t('cms', 'Template "{title}" could not be deleted.', [
                'title' => $model->title
            ]));
        }

        return $this->redirect(['index']);
    }
}

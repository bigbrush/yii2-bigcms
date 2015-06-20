<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

/**
 * ExtensionController
 */
class ExtensionController extends Controller
{
    /**
     * Renders a list of all installed extensions. If type is provided only extensions of this type is displayed.
     *
     * @param string $type optional type of extensions to show.
     * @return string the rendering result.
     */
    public function actionIndex($type = null)
    {
        $manager = Yii::$app->big->extensionManager;
        $types = $manager->getExtensionTypes();
        if ($type === null) {
            $type = array_keys($types)[0];
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $manager->getItems($type),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'types' => $types,
        ]);
    }

    /**
     * Edits an installed extension.
     *
     * @param int $id an id of an extension to edit.
     * @return string the rendering result.
     */
    public function actionEdit($id)
    {
        $model = Yii::$app->big->extensionManager->getModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Extension updated.'));
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
     * Installs an extension of the provided type.
     *
     * @param string $type a type of extension to install.
     * @return string the rendering result.
     */
    public function actionInstall($type)
    {
        $model = Yii::$app->big->extensionManager->getModel();
        $model->type = $type;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Extension installed.'));
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
     * Deletes an installed extension.
     *
     * @param int $id an id of an installed extension.
     */
    public function actionDelete($id)
    {
        $extensionId = $_POST['id'];
        if ($extensionId != $id) {
            throw new InvalidCallException("Invalid form submitted. Extension with id: '$id' not deleted.");
        }

        $model = Yii::$app->big->extensionManager->getModel($id);
        if ($model->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Extension deleted.'));
        } else {
            Yii::$app->getSession()->setFlash('error',  Yii::t('cms', 'Extension "{name}" could not be deleted.', [
                'title' => $model->name
        	]));
        }

        return $this->redirect(['index']);
    }
}

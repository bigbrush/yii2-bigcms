<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\InvalidCallException;
use yii\web\MethodNotAllowedHttpException;
use bigbrush\cms\Cms;

/**
 * BlockController
 */
class BlockController extends Controller
{
    /**
     * Shows a page with all created blocks.
     *
     * @return string the rendering result.
     */
    public function actionIndex($scope = Cms::SCOPE_FRONTEND)
    {
        $manager = Yii::$app->big->blockManager;
        $dataProvider = new ArrayDataProvider(['allModels' => $manager->getItems()]);
        $installedBlocks = $manager->getInstalledBlocks(true); // only active
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'installedBlocks' => $installedBlocks,
        ]);
    }

    /**
     * Creates a block based on the provided extension id.
     *
     * @param int $id an extension id to create the block from.
     * @return string the rendering result.
     */
    public function actionCreate($id)
    {
        $block = Yii::$app->big->blockManager->createNewBlock($id);
        $model = $block->model;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Block saved.'));
            if (Yii::$app->toolbar->stayAfterSave()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }

        if ($block->getEditRaw()) {
            return $this->render('edit_raw', [
                'block' => $block,
            ]);
        } else {
            return $this->render('edit', [
                'block' => $block,
            ]);
        }
    }

    /**
     * Edits and creates a block.
     *
     * @param string|int $id if an integer is provided it is regarded as database record. If it is a
     * string it is regarded as a new block.
     * @return string the rendering result.
     * @throws MethodNotAllowedHttpException if form is posted and 'Block' is not a key in $_POST.
     */
    public function actionEdit($id)
    {
        $block = Yii::$app->big->blockManager->getItem($id);
        $model = $block->model;
        $post = Yii::$app->getRequest()->post();
        if ($model->load($post)) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Block saved.'));
                if (Yii::$app->toolbar->stayAfterSave()) {
                    return $this->redirect(['edit', 'id' => $model->id]);
                } else {
                    return $this->redirect(['index']);
                }
            }
        } elseif (!empty($post)) {
            throw new MethodNotAllowedHttpException('Invalid form. "Block" must be set in $_POST');
        }

        if ($block->getEditRaw()) {
            return $this->render('edit_raw', [
                'block' => $block,
            ]);
        } else {
            return $this->render('edit', [
                'block' => $block,
            ]);
        }
    }

    /**
     * Deletes a block.
     *
     * @param int $id an id of a block to delete.
     * @return string the rendering result.
     * @throws InvalidCallException if id in $_POST does not match the provided id. 
     */
    public function actionDelete($id)
    {
        $blockId = $_POST['id'];
        if ($blockId != $id) {
            throw new InvalidCallException("Invalid form submitted. Block with id: '$id' not deleted.");
        }

        $block = Yii::$app->big->blockManager->getItem($id);
        $model = $block->model;
        if ($model->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Block deleted.'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Block "{name}" could not be deleted.', [
                'name' => $model->name
            ]));
        }

        return $this->redirect(['index']);
    }
}

<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

/**
 * @property cms\blocks\contact\models\ContactForm $model
 * @property string $site
 */
?>

<?= Yii::t('cms', 'Email received from {site}', ['site' => $site]) ?>

<?php foreach ($model->attributeLabels() as $property => $title) : ?>
    <?php if ($model->$property) : ?>
        <?= $title ?>: <?= $model->$property ?>
    <?php endif; ?>
<?php endforeach; ?>

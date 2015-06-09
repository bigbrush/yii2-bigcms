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

<div style="text-align:center;width:100%">

    <table width="600" cellpadding="10" cellspacing="0" style="background-color:#ffffff;text-align:left;margin:auto;" align="center">    
        <tr>
            <th colspan="2"><?= Yii::t('cms', 'Email received from {site}', ['site' => $site]) ?></th>
        </tr>

        <?php foreach ($model->attributeLabels() as $property => $title) : ?>
            <?php if ($model->$property) : ?>
            <tr>
                <td width="25%"><?= $title ?></td>
                <td><?= $model->$property ?></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    
</div>

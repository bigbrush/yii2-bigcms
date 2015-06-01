<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use bigbrush\big\widgets\bigsearch\BigSearch;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Yii::t('cms', 'Select a link') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container-fluid">
    
    <?= BigSearch::widget([
        'dynamicUrls' => true,
        'onClickCallback' => 'function(e){
            e.preventDefault();
            var route = $(this).data("route");
            top.tinymce.activeEditor.windowManager.getParams().setUrl(route);
        }',
        'fileManager' => [
            'onClickCallback' => 'function(file){
                top.tinymce.activeEditor.windowManager.getParams().setUrl(file.url);
            }'
        ]
    ]) ?>
    
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('cms', 'Search results');
?>
<div class="row">
    <div class="col-md-12">
        <h1><small><?= $this->title ?></small> <?= $searchValue ?></h1>
    </div>
</div>

<?php
$counter = 1;
$urlManager = Yii::$app->getUrlManager();
foreach ($results as $section => $items) : ?>
<div class="row">
    <div class="col-md-12">
        <h2><?= $section ?></h2>
        <?php
        $dataProvider = new ArrayDataProvider(['allModels' => $items]);
        $dataProvider->pagination->pageParam = "grid-$counter-page";
        $dataProvider->sort->sortParam = "grid-$counter-sort";
        $counter++;
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'header' => Yii::t('cms', 'Title'),
                    'format' => 'raw',
                    'value' => function($data) use ($urlManager) {
                        $route = $data['route'];
                        // menus could be external links so this needs to be taken care of
                        $isHttp = strpos($route, 'http://') === 0;
                        if (!$isHttp && strpos($route, 'www') === false) {
                            $route = $urlManager->parseInternalUrl($route);
                            $route = $urlManager->createUrlFrontend($route);
                        } elseif (!$isHttp) {
                            $route = 'http://' . $route;
                        }
                        return Html::a($data['title'], $route, ['target' => '_blank']);
                    }
                ],
                [
                    'header' => Yii::t('cms', 'Date'),
                    'options' => ['width' => '20%'],
                    'value' => function($data) {
                        return empty($data['date']) ? null : Yii::$app->getFormatter()->asDate($data['date']);
                    }
                ],
            ]
        ]) ?>
    </div>
</div>
<?php endforeach; ?>

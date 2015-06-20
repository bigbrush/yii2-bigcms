<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJs('
    function alert(message, type) {
        var button = $("<button>", {
            type: "button",
            class: "close",
            "data-dismiss": "alert",
            "aria-hidden": "true",
            text: "x"
        });
        var alert = $("<div>", {
            class: "alert alert-"+type+" fade in",
        }).append(button).append(message);
        $("#alert").empty().html(alert);
    }
    
    $("#grid").on("click", ".changeDirectionBtn", function(e){
        var self = $(this),
            direction = self.data("direction"),
            menuId = self.data("pid");

        $.post("'.Url::to(['move']).'", {node_id: menuId, direction: direction}, function(data){
            if (data.status === "success") {
                $("#grid").empty().html(data.grid);
            }
            var type = data.status == "error" ? "danger" : data.status;
            alert(data.message, type);
        }, "json");

        e.preventDefault();
    });

');

Yii::$app->toolbar->add();

$this->title = Yii::t('cms', 'Categories');
?>
<div class="row">
    <div class="col-md-12">
        <div id="alert">
        </div>

        <h1><?= $this->title ?></h1>
        <div id="grid">
            <?= $this->render('_grid', ['dataProvider' => $dataProvider]) ?>
        </div>
    </div>
</div>
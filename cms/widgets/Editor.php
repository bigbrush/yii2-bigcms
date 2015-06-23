<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\widgets;

use Yii;
use yii\web\JsExpression;
use bigbrush\big\widgets\editor\Editor as BigEditor;

/**
 * Editor provides an editor that is setup specifically for Big Cms. An extra menu item is added
 * in the "Insert" submenu which can be used to insert block include statement.
 *
 * Use like the following when displaying content: 
 * Page represents a model where the property $content is populated with data created with the editor. 
 * ~~~php
 * $page = Page::findOne(1);
 * $page->content = Editor::process($page->content); // <-- this line
 * ~~~
 */
class Editor extends BigEditor
{
    /**
     * @var string defines the skin_url to use.
     * @see http://www.tinymce.com/wiki.php/Configuration:skin
     */
    public $skin = 'light';
    /**
     * @var string defines the skin_url to use.
     * If this property is not set the asset bundle [[EditorSkinAsset]] is used as skin url.
     * @see http://www.tinymce.com/wiki.php/Configuration:skin_url
     */
    public $skinUrl;


    /**
     * Initializes this widget.
     */
    public function init()
    {
        parent::init();
        // register css for the block button icon
        $this->getView()->registerCss('
            #block-button .mce-i-insertblock:before {
                content: "\f0c8";
                font-family: FontAwesome;
                font-size: 18px;
            }
        ');
        $this->clientOptions = array_merge($this->clientOptions(), $this->clientOptions);
    }
    
    /**
     * Returns a default configuration array for the editor.
     * This includes an extra menu item under "Insert" that inserts a block include statement. You should call [[process()]]
     * when displaying content created with this editor.
     *
     * @return array default editor configuration.
     */
    public function clientOptions()
    {
        if ($this->skinUrl === null) {
            $bundle = EditorSkinAsset::register($this->getView());
            $this->skinUrl = $bundle->baseUrl;
        }
    	return [
            'skin_url' => $this->skinUrl . '/' . $this->skin,
            'skin' => $this->skin,
            'plugins' => 'contextmenu advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste',
            'toolbar' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            'setup' => new JsExpression('function(editor) {
                editor.addMenuItem("insertblock", {
                    text: "' . Yii::t('cms', 'Block') . '",
                    icon: "insertblock",
                    id: "block-button",
                    context: "insert",
                    prependToContext: true,
                    onclick: function() {
                        editor.insertContent("<div>{block ' . Yii::t('cms', 'INSERT_BLOCK_TITLE') . '}</div><p>&nbsp;</p>");
                    }
                });
            }')
        ];
    }

    /**
     * Processes the provided data by replacing block include statements with block content.
     * 
     * An include statement looks like the following:
     * ~~~
     * {block Contact}
     * ~~~
     * The first part (block) is required and the second part (Contact) is a title of a block.
     * 
     * @param string $data the data to process.
     * @return string the processed data.
     */
    public static function process($data)
    {
        // simple performance check to determine whether further processing is required
        if (strpos($data, 'block') === false) {
            return $data;
        }

        // Find all instances of block and put in $matches
        // $matches[0] is full pattern match, $matches[1] is the block title
        $regex = '/{block\s(.*?)}/i';
        preg_match_all($regex, $data, $matches, PREG_SET_ORDER);

        // no matches, do nothing
        if ($matches) {
            $manager = Yii::$app->big->blockManager;
            $mapper = [];

            // collect all block titles so blocks are loaded in one query
            foreach ($matches as $match) {
                $mapper[$match[0]] = $match[1];
            }
            $models = $manager->getModel()->find()->where(['title' => array_values($mapper)])->all();

            // update mapper with found blocks
            foreach ($models as $model) {
                $key = array_search($model->title, $mapper);
                $mapper[$key] = $manager->createObject([
                    'class' => $model->namespace,
                    'model' => $model,
                ]);
            }

            // replace block include statements
            foreach ($mapper as $statement => $block) {
                // block is only an object if a block with the provided "title" is found. 
                if (is_object($block)) {
                    $content = $block->run();
                } else {
                    $content = '';
                }
                $data = preg_replace("|$statement|", addcslashes($content, '\\$'), $data, 1);
            }
        }
        return $data;
    }
}

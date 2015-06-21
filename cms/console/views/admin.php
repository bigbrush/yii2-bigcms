<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

echo "<?php\n";
?>
/**
 * This file is generated automatically with the install console command.
 * 
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

$config = [
    'id' => 'Big',
    'basePath' => dirname(dirname(__DIR__)),
    'defaultRoute' => 'big/cms/index',
    'language' => '<?= $language ?>',
    'bootstrap' => [
        'big',
        'cms',
    ],
    'modules' => [
        'big' => ['class' => 'bigbrush\cms\modules\big\backend\Module'],
        'pages' => ['class' => 'bigbrush\cms\modules\pages\backend\Module'],
    ],
    'components' => [
        'cms' => [
            'class' => 'bigbrush\cms\Cms',
            'scope' => \bigbrush\cms\Cms::SCOPE_BACKEND,
        ],
        'big' => [
            'class' => 'bigbrush\big\core\Big',
            'frontendTheme' => '@app/themes/web',
            'searchHandlers' => [
                ['bigbrush\cms\modules\pages\components\PageFinder', 'onSearch'],
            ],
        ],
        'toolbar' => [
            'class' => 'bigbrush\cms\components\Toolbar',
        ],
        'request' => [
            'cookieValidationKey' => 'Tm0TqcYJYJLX9PTIPNyYjEFzUbX-wMoB',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/adminlte',
                'baseUrl' => '@web/themes/adminlte',
            ],
        ],
        'user' => [
            'identityClass' => 'bigbrush\cms\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => [''],
        ],
        'session' => [
            'name' => 'BACKENDID',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true, // used for testing
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
];

// if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    // $config['modules']['debug'] = 'yii\debug\Module';

    // $config['bootstrap'][] = 'gii';
    // $config['modules']['gii'] = 'yii\gii\Module';
// }

return $config;

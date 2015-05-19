<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

$config = [
    'id' => 'Big',
    'basePath' => dirname(dirname(__DIR__)),
    'defaultRoute' => 'app/frontpage/index',
    'language' => 'da',
    'on big.search' => ['cms\modules\pages\components\PageFinder', 'onSearch'],
    'bootstrap' => [
        'big',
    ],
    'modules' => [
        'app' => ['class' => 'cms\modules\app\backend\Module'],
        'pages' => ['class' => 'cms\modules\pages\backend\Module'],
    ],
    'components' => [
        'big' => [
            'class' => 'bigbrush\big\core\Big',
            'blockManager' => ['classPath' => 'cms\blocks'],
            'urlManager' => ['enableUrlRule' => false],
            'menuManager' => ['autoLoad' => false],
            'scope' => 'backend',
            'enableDynamicContent' => false,
            'webTheme' => '@app/themes/web/views/layouts/column2.php',
        ],
        'toolbar' => [
            'class' => 'cms\components\Toolbar',
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
                'basePath' => '@app/themes/admin',
                'baseUrl' => '@web/themes/admin',
                'pathMap' => [
                    '@app' => '@app/themes/admin',
                    '@bigbrush/big/modules' => '@app/themes/admin/modules',
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'cms\models\User',
            'enableAutoLogin' => false,
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

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    // $config['modules']['debug'] = 'yii\debug\Module';

    // $config['bootstrap'][] = 'gii';
    // $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
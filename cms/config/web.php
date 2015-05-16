<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

$config = [
    'id' => 'Big',
    'basePath' => dirname(dirname(__DIR__)),
    'layout' => 'column2',
    'bootstrap' => [
        'big',
    ],
    'modules' => [
        'pages' => ['class' => 'cms\modules\pages\frontend\Module'],
    ],
    'components' => [
        'big' => [
            'class' => 'bigbrush\big\core\Big',
            'blockManager' => ['classPath' => 'cms\blocks'],
        ],
        'request' => [
            'cookieValidationKey' => 'Tm0TqcYJYJLX9PTIPNyYjEFzUbX-wMoB',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/web',
                'baseUrl' => '@web/themes/web',
            ],
        ],
        'user' => [
            'identityClass' => 'cms\models\User',
            'enableAutoLogin' => false,
        ],
        'session' => [
            'name' => 'FRONTENDID',
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
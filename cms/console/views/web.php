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
    'language' => '<?= $language ?>',
    'layout' => 'column2',
    'bootstrap' => [
        'big',
        'cms',
    ],
    'modules' => [
        'pages' => ['class' => 'bigbrush\cms\modules\pages\frontend\Module'],
    ],
    'components' => [
        'cms' => [
            'class' => 'bigbrush\cms\Cms',
        ],
        'big' => [
            'class' => 'bigbrush\big\core\Big',
            'setApplicationDefaultRoute' => true,
            'enableDynamicContent' => true,
            'managers' => [
                'urlManager' => [
                    'enableUrlRule' => true,
                ],
                'menuManager' => [
                    'autoload' => true,
                ],
            ],
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
            'identityClass' => 'bigbrush\cms\models\User',
            'enableAutoLogin' => false,
        ],
        'session' => [
            'name' => 'FRONTENDID',
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

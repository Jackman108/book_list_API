<?php
//config/web.php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

defined('YII_DEBUG') or define('YII_DEBUG', $_ENV['YII_DEBUG'] ?? false);

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'tokenParamName' => 'accessToken',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'user_credentials' => 'app\models\User',
            ],
            'grantTypes' => [
                'authorization_code' => [
                    'class' => 'OAuth2\GrantType\AuthorizationCode',
                ],
                'client_credentials' => [
                    'class' => 'OAuth2\GrantType\ClientCredentials',
                    'allow_public_clients' => false
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'VZx9XzjI32EQZAuWtrJ7vwM9dWKREeov',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'enableSession' => true,
            'loginUrl' => null,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\mail\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'oauth2' => [
                    'class' => 'yii\authclient\OAuth2',
                    'clientId' => $_ENV['GOOGLE_CLIENT_ID'],
                    'clientSecret' => $_ENV['GOOGLE_CLIENT_SECRET'],
                    'tokenUrl' => $_ENV['CLIENT_HOST'] . '/api/auth',
                    'apiBaseUrl' => $_ENV['CLIENT_HOST'] . '/api',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => ['book']],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['author']],
                'POST auth' => 'auth/index', // Экшен для инициации аутентификации
                'GET auth/callback' => 'auth/callback', // Экшен для обработки ответа от провайдера аутентификации

                'api/<controller:\w+>/<action:\w+>' => 'api/<controller>/<action>',
                'api/<controller:\w+>/<action:\w+>/<id:\d+>' => 'api/<controller>/<action>',
            ],
        ],
    ],
    'controllerMap' => [
        'authors' => [
            'class' => 'app\controllers\AuthorController',
            'as authenticator' => true,
        ],
        'books' => [
            'class' => 'app\controllers\BookController',
            'as authenticator' => true,
        ],
        'auth' => 'app\controllers\AuthController',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

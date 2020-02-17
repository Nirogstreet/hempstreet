<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
       'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
//            'uploadDir' => '@frontend/web/images/blogs/',
//            'uploadUrl' => 'https://nirogstreet.com/images/blogs',
           ],
    ],
   
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\BackendUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'assetManager' => [
        'appendTimestamp' => true,
                'bundles' => [
                    'yii\bootstrap\BootstrapAsset' => [
                        'css' => [],
                    ],
                    'yii\web\JqueryAsset' => [
                        'sourcePath' => null,
                        'js' => []
                    ]
                ],
        'bundles' => [
        'dmstr\web\AdminLteAsset' => [
            'skin' => 'skin-green-light',
            ],
        ],
       ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
         'urlManager' =>  [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            //'suffix' => '.html',
            'rules' => [
               'contact' => 'site/contact', 
                
            ],
        ],
        'urlManagerFrontend' => [
                'class' => 'yii\web\urlManager',
                'baseUrl' => 'http://hemp.loc',
                'enablePrettyUrl' => true,
                'showScriptName' => false,
        ],
    ],
    
    'as beforeRequest' => [  //if guest user access site so, redirect to login page.
    'class' => 'yii\filters\AccessControl',
    'rules' => [
        [
            'actions' => ['login', 'error'],
            'allow' => true,
        ],
        [
            'allow' => true,
            'roles' => ['@'],
        ],
    ],
],
    'params' => $params,
];

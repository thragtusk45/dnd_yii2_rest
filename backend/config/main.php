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
    'defaultRoute' => 'admin/default/index',
    'bootstrap' => ['gii'],
    'modules' => [
        'admin' => [
            'class' => 'backend\modules\admin\Module'
        ],

        'users' => [
            'controllerNamespace' => 'vova07\users\controllers\backend'
        ],
    ],

    'components' => [
        'urlManager' => [
            'rules' => [
                '' => 'site/index',
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
                '<_c>/<_a>' => '<_c>/<_a>',
            ]
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];

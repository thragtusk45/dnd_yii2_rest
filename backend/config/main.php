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
        'tools' => [
            'class' => 'backend\modules\tools\Tools',
        ],
        'users' => [
            'controllerNamespace' => 'vova07\users\controllers\backend'
        ],
    ],

    'components' => [
        'urlManager' => [
            'rules' => [
//                '' => 'site/index',
                '<_m:[\w\-]+>/<_sm:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_sm>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
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

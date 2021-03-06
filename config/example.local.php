<?php
$params = require __DIR__ . '/params.php';

$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2bridge_local',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

return [
    'yiiDebug' => true,
    'yiiEnv' => 'stage',
    'web' => [
        'bootstrap' => ['debug'],
        'components' => [
            'log' => [
                'traceLevel' => 3,
                'targets' => [
                    [
                        'class' => 'yii\log\FileTarget',
                        'levels' => ['error', 'warning'],
                    ],
                ],
            ],
            'db' => $db,
        ],
        'modules' => [
            'gii' => ['class' => \yii\gii\Module::className()],
            'debug' => ['class' => \yii\debug\Module::className()]
        ],
        'params' => $params,
    ],
    'console' => [
        'components' => [
            'db' => $db,
        ],
        'params' => $params,
    ]
];
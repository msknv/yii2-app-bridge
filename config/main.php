<?php
$params = require __DIR__ . '/params.php';

$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2bridge',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

return [
    'yiiDebug' => false,
    'yiiEnv' => 'prod',
    'yiiPath' => dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php',
    'web' => [
        'id' => 'bridge',
        'basePath' => dirname(__DIR__),
        'bootstrap' => [
            'log', 'admin',
            '\app\events\Bootstrap'
        ],
        'aliases' => [
            '@bower' => '@vendor/bower-asset',
            '@npm' => '@vendor/npm-asset',
        ],
        'components' => [
            'request' => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                'cookieValidationKey' => '1AD948uWLSSg14DNbb-_x257YmzAydFi',
            ],
            'cache' => [
                'class' => 'yii\caching\FileCache',
            ],
            'user' => [
                'identityClass' => \app\models\User::class,
                'enableAutoLogin' => true,
            ],
            'i18n' => [
                'translations' => [
                    'admin' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                        'sourceLanguage' => 'en-US',
                        'basePath' => '@app/messages',
                    ]
                ]
            ],
            'authManager' => [
                'class' => \Da\User\Component\AuthDbManagerComponent::class,
            ],
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                'useFileTransport' => true,
            ],
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
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                    'post/<slug>' => 'post/view',
                    'posts/' => 'post/index',
                ],
            ],
        ],
        'modules' => [
            'admin' => [
                'class' => \naffiq\bridge\BridgeModule::class,
                'userClass' => \app\models\User::class,
                'userSettings' => [
                    'class' => \Da\User\Module::className(),
                    'administratorPermissionName' => 'admin'
                ],
                'modules' => [
                    'cms' => [
                        'class' => '\app\modules\cms\Module'
                    ]
                ],
                'menu' => [
                    'Сontent',
                    [
                        'title' => 'Posts',
                        'url' => ['/admin/cms/posts/index'],
                        'icon' => 'file-o',
                        'active' => ['module' => 'cms', 'controller' => 'posts']
                    ]
                ]
            ],
        ],
        'params' => $params,
    ],
    'console' => [
        'id' => 'basic-console',
        'basePath' => dirname(__DIR__),
        'bootstrap' => [
            'log', 'admin',
            '\app\events\Bootstrap'
        ],
        'controllerNamespace' => 'app\commands',
        'components' => [
            'cache' => [
                'class' => 'yii\caching\FileCache',
            ],
            'log' => [
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
            'admin' => [
                'class' => \naffiq\bridge\BridgeModule::class
            ]
        ],
        'params' => $params,
        /*
        'controllerMap' => [
            'fixture' => [ // Fixture generation command line.
                'class' => 'yii\faker\FixtureController',
            ],
        ],
        */
    ]
];
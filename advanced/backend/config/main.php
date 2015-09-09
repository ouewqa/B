<?php
$params = array_merge(require(__DIR__ . '/../../common/config/params.php'),
        require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'),
        require(__DIR__ . '/params-local.php'));

return [
        'id'                  => 'app-backend',
        'basePath'            => dirname(__DIR__),
        'controllerNamespace' => 'backend\controllers',
        'bootstrap'           => ['log'],
        'modules' => [
                'user' => [
                    // following line will restrict access to admin page
                    'as backend' => 'dektrium\user\filters\BackendFilter',
                ],
        ],
        'components'          => [
                'user'         => [
                        'identityCookie' => [
                                'name'     => '_backendIdentity',
                                'path'     => '/admin',
                                'httpOnly' => true,
                        ],
                ],
                'session'      => [
                        //'name'         => 'BACKENDSESSID',
                        'cookieParams' => [
                                'httpOnly' => true,
                                'path'     => '/admin',
                        ],
                ],
                'log'          => [
                        'traceLevel' => YII_DEBUG ? 3 : 0,
                        'targets'    => [
                                [
                                        'class'  => 'yii\log\FileTarget',
                                        'levels' => ['error', 'warning'],
                                ],
                        ],
                ],
                'errorHandler' => [
                        'errorAction' => 'site/error',
                ],
        ],
        'params'              => $params,
];

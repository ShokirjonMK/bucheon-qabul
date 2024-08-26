<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Tashkent',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '7201301676:AAGf0FX_dlElEFppOb4G2aY_g2tM2QqPjNQ',
        ],
        'ikAmoCrm' => [
            'class' => 'common\components\AmoCrmClient',
        ],
    ],
];

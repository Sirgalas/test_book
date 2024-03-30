<?php

namespace frontend\Modules\Api;

use common\Modules\User\Entities\User;

/**
 * api module definition class
 */
class Api extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\Modules\Api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();


        \Yii::$app->setComponents([
            'request' => [
                'class'=>\yii\web\Request::class,
                'parsers' => [
                    'application/json' => 'yii\web\JsonParser',
                ]
            ],
            'user' => [
                'class' => User::class
            ],
            'response' => [
                'class'=> '\yii\web\Response',
                'formatters' => [
                    \yii\web\Response::FORMAT_JSON => [
                        'class' => 'yii\web\JsonResponseFormatter',
                        'prettyPrint' => YII_DEBUG, // используем "pretty" в режиме отладки
                        'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                    ],
                ],

            ],
        ]);
    }
}

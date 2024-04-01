<?php

declare(strict_types=1);

namespace frontend\Modules\Api\controllers;

use frontend\Modules\Api\Traits\HeaderTrait;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

class AbstractController extends ActiveController
{
    use HeaderTrait;


    public function behaviors(): array
    {
        $behaviors['cors'] = [
             'class' => \yii\filters\Cors::class,
        ];
        $behaviors['authenticator'] = [
            'class'    => HttpBearerAuth::class,
            'except'   => ['authentication', 'options'],
            'optional' => ['options'],
        ];
        $behaviors['contentNegotiator'] = [
            'class'   => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        return ArrayHelper::merge($behaviors,parent::behaviors());
    }

    protected function verbs()
    {
        return [
        'index' => ['GET', 'HEAD', 'OPTIONS'],
        'one' => ['GET', 'HEAD', 'OPTIONS'],
        'create' => ['POST', 'OPTIONS'],
        'update' => ['PUT', 'PATCH', 'OPTIONS'],
        'delete' => ['DELETE', 'OPTIONS'],
    ];
    }


    /**
     *
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['options']);
        return $actions;
    }



    public function afterAction($action, $result)
    {
        if(\Yii::$app->request->isOptions) {
            return $this->serializeData($this->actionOptions());
        }
        return parent::afterAction($action, $result);
    }

    public function actionOptions()
    {
        $this->setHeader(200);
        return true;
    }

    protected function sendError($error, $code = 404)
    {
        $this->setHeader($code);
        return [
            'payload' => null,
            'error'   => [
                'message' => $error,
            ],
        ];
    }

    protected function sendSucces(array $message = ['success' => 'ok'])
    {
        $this->setHeader(200);
        return [
            'payload' => $message,
            'error'   => null,
        ];
    }
}
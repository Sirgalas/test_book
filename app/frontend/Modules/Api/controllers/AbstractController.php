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
        $behaviors= ArrayHelper::merge([
            'cors'=>[
                'class' =>  \yii\filters\Cors::class,
            ]], parent::behaviors());
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['authentication','options'],
            'optional' => ['options']
        ];
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    /*public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
*/
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
//        unset($actions['options']);
        return $actions;
    }

//    public function actionOptions()
//    {
//        $this->setHeader(200);
//        return true;
//    }

    protected function sendError($error)
    {
        return [
            'error' => [
                'message' =>$error]
        ];
    }
}
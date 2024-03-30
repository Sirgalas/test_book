<?php

declare(strict_types=1);

namespace frontend\Modules\Api\controllers;

use common\Helpers\ErrorHelper;
use common\Modules\User\Entities\User;
use common\Modules\User\Form\RestLoginForm;
use common\Modules\User\Services\UserService;
use frontend\Modules\Api\Traits\HeaderTrait;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use yii\filters\auth\HttpBearerAuth;

class UserController extends AbstractController
{
    use HeaderTrait;
    public $modelClass = User::class;
    private UserService $userService;

    public function __construct($id, $module, UserService $userService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
    }

    public function actionAuthentication() {
        try {
            $loginForm = new RestLoginForm();
            if($loginForm->load(\Yii::$app->request->post(),'') && $loginForm->validate()) {
                return $this->sendSucces(['token' => $this->userService->auth($loginForm)]);
            }
            return $this->sendError(ErrorHelper::errorsToStr($loginForm->errors),400);
        } catch (AccessException $e) {
            return $this->sendError($e->getMessage());
        }
    }


}
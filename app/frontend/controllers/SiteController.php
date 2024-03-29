<?php

namespace frontend\controllers;

use common\Modules\Feedback\Entities\Feedback;
use common\Modules\Feedback\Forms\FeedbackForm;
use common\Modules\Feedback\Services\FeedbackService;
use common\Modules\Image\Services\ImageService;
use frontend\models\FileModel;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private FeedbackService $service;

    public function __construct($id, $module, FeedbackService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFeedback()
    {
        $model = new FeedbackForm();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->service->create($model);
            \Yii::$app->session->setFlash('success','Ваше обращение отпавлено');
            return $this->redirect('index');
        }
        return $this->render('feedback',['model' => $model]);
    }

    public function actionError(){
        return $this->render('error');
    }


}

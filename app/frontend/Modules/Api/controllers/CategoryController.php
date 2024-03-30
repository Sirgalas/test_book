<?php

declare(strict_types=1);

namespace frontend\Modules\Api\controllers;

use common\Helpers\ErrorHelper;
use common\Modules\Category\Entities\Category;
use common\Modules\Category\Forms\CategoryForm;
use common\Modules\Category\Services\CategoryService;
use frontend\Modules\Api\SearchForm\CategorySearch;
use yii\filters\VerbFilter;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;

class CategoryController extends AbstractController
{
    public $modelClass = Category::class;
    private CategoryService $service;

    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => \yii\filters\VerbFilter::class,
                    'actions' => [
                        'index'  => ['GET'],
                        'one'   => ['GET'],
                        'create' => ['POST'],
                        'update' => ['PUT',],
                        'delete' => ['DELETE'],
                    ],
                ],
            ]);
    }


    public function __construct($id, $module,CategoryService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        return  $this->sendSucces($searchModel->search($this->request->queryParams));
    }

    public function actionOne(int $id)
    {
        try {
            return $this->sendSucces(['category' => $this->service->categoryRepository->get($id)]);
        } catch (NotFoundHttpException $e) {
            return $this->sendError($e->getMessage());
        }
    }
    public function actionCreate()
    {
        if(!\Yii::$app->request->isPost && !\Yii::$app->request->isOptions) {
            return $this->sendError('Only POST method allowed',400);
        }
        $model = new CategoryForm();
        if($model->load(\Yii::$app->request->post(),'') && $model->validate()) {
            try {
                $category = $this->service->create($model);
                return $this->sendSucces(['category' => $category]);
            }catch (\RuntimeException $e) {
                return $this->sendError($e->getMessage(),500);
            }catch (MethodNotAllowedHttpException $e) {
                return $this->sendError($e->getMessage(), 405);
            }
        }
        return $this->sendError(ErrorHelper::errorsToStr($model->errors),400);
    }

    public function actionUpdate(int $id) {
        try{
            $category = $this->service->categoryRepository->get($id);
            $form = new CategoryForm($category);
            if($form->load(\Yii::$app->request->post(),'') && $form->validate()) {
                $category = $this->service->edit($category,$form);
                return $this->sendSucces(['category' => $category]);
            } else {
                return $this->sendError(ErrorHelper::errorsToStr($form->errors),400);
            }
        }catch (NotFoundHttpException $e) {
            return $this->sendError($e->getMessage());
        }catch (\RuntimeException $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function actionDelete(int $id)
    {
        try{
            $this->service->categoryRepository->delete($id);
            return $this->sendSucces();
        }catch (NotFoundHttpException $e) {
            return $this->sendError($e->getMessage());
        }
    }

}
<?php

namespace backend\controllers;

use common\Modules\Category\Entities\Category;
use backend\SearchForms\CategorySearch;
use common\Modules\Category\Forms\CategoryForm;
use common\Modules\Category\Services\CategoryService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{

    private CategoryService $categoryService;

    public function __construct($id, $module, CategoryService $categoryService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->categoryService = $categoryService;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class'   => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        try {
            return $this->render('view', [
                'model' => $this->categoryService->categoryRepository->get($id),
            ]);
        } catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('index');
        }
    }

    public function actionCreate()
    {
        $model = new CategoryForm();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            try {
                $category = $this->categoryService->create($model);
                return $this->redirect(['view', 'id' => $category->id]);
            } catch (\RuntimeException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        try {
            $category = $this->categoryService->categoryRepository->get($id);
            $model = new CategoryForm($category);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
                $this->categoryService->edit($category, $model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        } catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('index');
        } catch (\RuntimeException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['update', ['id' => $id]]);
        }
    }


    public function actionDelete($id)
    {
        try{
            $this->categoryService->categoryRepository->get($id);
        }catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

}

<?php

namespace backend\controllers;

use common\Modules\Book\Forms\BookCrudForm;
use common\Modules\Book\Services\BookService;
use frontend\SearchForms\BookSearch;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{

    private BookService $bookService;

    public function __construct(
        $id,
        $module,
        BookService $bookService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bookService = $bookService;
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        try {
            return $this->render('view', [
                'model' => $this->bookService->bookRepository->get($id),
            ]);
        }catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['index']);
        }

    }

    public function actionCreate()
    {
        $model = new BookCrudForm();
        $categories = ArrayHelper::map(
            $this->bookService->categoryRepository->getAllByQuery(),
            'id',
            'title'
        );
        $authors = ArrayHelper::map(
            $this->bookService->authorRepository->getAllByQuery(),
            'id',
            'name'
        );
        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $book = $this->bookService->createCrud($model);
                $transaction->commit();
                return $this->redirect(['view', 'id' => $book->id]);
            } catch (\RuntimeException $e) {
                $transaction->rollBack();
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
            'authors' => $authors
        ]);
    }


    public function actionUpdate($id)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $book = $this->bookService->bookRepository->get($id);
            $model = new BookCrudForm($book);
            $categories = ArrayHelper::map(
                $this->bookService->categoryRepository->getAllByQuery(),
                'id',
                'title'
            );
            $authors = ArrayHelper::map(
                $this->bookService->authorRepository->getAllByQuery(),
                'id',
                'name'
            );
            if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
                $this->bookService->edit($book,$model);
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
                'authors' => $authors
            ]);
        }catch (NotFoundHttpException $e) {
            $transaction->rollBack();
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['index']);
        }catch (\RuntimeException $e) {
            $transaction->rollBack();
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['update', 'id' => $id]);
        }

    }

    public function actionDelete($id)
    {
        try{
            $this->bookService->bookRepository->delete($id);
            \Yii::$app->session->setFlash('success', 'Book deleted');
        } catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        } finally {
            return $this->redirect(['index']);
        }
    }

}

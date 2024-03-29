<?php

declare(strict_types=1);

namespace frontend\controllers;

use common\Modules\Author\Services\AuthorService;
use common\Modules\Category\Services\CategoryService;
use frontend\SearchForms\BookSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    private CategoryService $service;
    private AuthorService $authorService;

    public function __construct(
        $id,
        $module,
        CategoryService $service,
        AuthorService $authorService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->authorService = $authorService;
    }

    public function actionIndex()
    {
        [$categories, $page] = $this->service->getCategory();
        return $this->render('index', [
            'categories' => $categories,
            'page'       => $page,
        ]);
    }

    public function actionOne(int $id)
    {
        try {
            $form = new BookSearch();
            $params = \Yii::$app->request->post();
            $params['BookSearch']['category_id'] = $id;
            [$books, $page] = $form->search($params);
            $authors = ArrayHelper::map(
                $this->authorService->authorRepository->getAllByQuery(),
                'id',
                'name'
            );
            return $this->render(
                'one',
                [
                    'model'    => $form,
                    'category' => $this->service->categoryRepository->get($id),
                    'books'    => $books,
                    'authors'  => $authors,
                    'page'     => $page,
                ]
            );
        } catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', "category id $id not found");
            return $this->redirect('index');
        }
    }
}
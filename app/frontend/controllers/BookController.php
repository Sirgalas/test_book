<?php

declare(strict_types=1);

namespace frontend\controllers;

use common\Modules\Book\Services\BookService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct($id, $module, BookService $bookService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->bookService = $bookService;
    }

    public function actionOne(int $id)
    {

        try {
            return $this->render('one', [
                'model' => $this->bookService->bookRepository->get($id),
            ]);
        }catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect([$_SERVER['HTTP_REFERER']]);
        }
    }
}
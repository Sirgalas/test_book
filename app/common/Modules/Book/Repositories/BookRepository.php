<?php

declare(strict_types=1);

namespace common\Modules\Book\Repositories;

use common\Helpers\ErrorHelper;
use common\Modules\Book\Entities\Book;
use yii\web\NotFoundHttpException;

class BookRepository
{
    public function get(int $id): Book
    {
        if(!$book = Book::findOne($id)) {
            throw new NotFoundHttpException(sprintf('Book id %d not found', $id));
        }
        return $book;
    }
    public function find(int $id): ?Book
    {
        if(!$book = Book::findOne($id)) {
            return null;
        }
        return $book;
    }

    public function save(Book $book): Book
    {
        if(!$book->save()) {
            throw new \RuntimeException(ErrorHelper::errorsToStr($book->errors));
        }
        return $book;
    }

    public function delete(int $id): void
    {
        $book = $this->get($id);
        $book->delete();
    }
}
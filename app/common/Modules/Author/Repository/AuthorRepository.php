<?php

declare(strict_types=1);

namespace common\Modules\Author\Repository;

use common\Helpers\ErrorHelper;
use common\Modules\Author\Entities\Author;
use common\Modules\Category\Entities\Category;
use yii\web\NotFoundHttpException;

class AuthorRepository
{
    public function get(int $id): Author
    {
        if(!$author = Author::findOne($id)) {
            throw new NotFoundHttpException(sprintf('Author id %d not found', $id));
        }
        return $author;
    }
    public function find(int $id): ?Author
    {
        if(!$author = Author::findOne($id)) {
            return null;
        }
        return $author;
    }

    public function save(Author $author): Author
    {
        if(!$author->save()) {
            throw new \RuntimeException(ErrorHelper::errorsToStr($author->errors));
        }
        return $author;
    }
    public function existsByQuery(array $query): bool
    {
        return Author::find()->where($query)->exists();
    }

    public function delete(int $id): void
    {
        $author = $this->get($id);
        $author->delete();
    }

    public function getAllByQuery(array $query =[]):array
    {
        $authors = Author::find();
        if(!empty($query)) {
            $authors->where($query);
        }
        return $authors->all();
    }
}
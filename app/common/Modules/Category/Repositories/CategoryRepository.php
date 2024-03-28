<?php

declare(strict_types=1);

namespace common\Modules\Category\Repositories;

use common\Helpers\ErrorHelper;
use common\Modules\Book\Entities\Book;
use common\Modules\Category\Entities\Category;
use yii\web\NotFoundHttpException;

class CategoryRepository
{
    public function get(int $id): Category
    {
        if(!$category = Category::findOne($id)) {
            throw new NotFoundHttpException(sprintf('Category id %d not found', $id));
        }
        return $category;
    }
    public function find(int $id): ?Category
    {
        if(!$category = Category::findOne($id)) {
            return null;
        }
        return $category;
    }

    public function save(Category $category): Category
    {
        if(!$category->save()) {
            throw new \RuntimeException(ErrorHelper::errorsToStr($category->errors));
        }
        return $category;
    }

    public function existsByQuery(array $query): bool
    {
        return Category::find()->where($query)->exists();
    }

    public function delete(int $id): void
    {
        $category = $this->get($id);
        $category->delete();
    }
}
<?php

declare(strict_types=1);

namespace common\Modules\Category\Services;

use common\Modules\Category\Entities\Category;
use common\Modules\Category\Forms\CategoryForm;
use common\Modules\Category\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(public readonly CategoryRepository $categoryRepository)
    {}

    public function create(CategoryForm $form): Category
    {
        $category = Category::create($form);
        return $this->categoryRepository->save($category);
    }

    public function edit(Category $category, CategoryForm $form): Category
    {
        $category->edit($form);
        return $this->categoryRepository->save($category);
    }
}
<?php

declare(strict_types=1);

namespace frontend\Modules\Api\controllers;

use common\Modules\Category\Entities\Category;

class CategoryController extends AbstractController
{
    public $modelClass = Category::class;
    public function actionIndex()
    {
        return ['success' => 'ok'];
    }
}
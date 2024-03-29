<?php

declare(strict_types=1);

use common\Modules\Category\Entities\Category;
use common\Modules\Book\Entities\Book;
use yii\bootstrap4\LinkPager;
use yii\data\Pagination;

/**
 * @var View $this
 * @var Category $categories
 * @var Book[] $books
 * @var \frontend\SearchForms\BookSearch $model ;
 * @var Pagination $page
 * @var array $authors
 **/
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php
            if (! empty($category->childrens)):
                foreach ($category->childrens as $childCategory): ?>
                    <?= $this->render(
                        '_category',
                        ['category' => $category]
                    ) ?>
                <?php
                endforeach;
            endif; ?>
        </div>
        <div class="col-3">
            <?= $this->render('_search', [
                'model' => $model,
                'authors' => $authors
            ]); ?>
        </div>
        <div class="col-8">
            <div class="container">
                <div class="row">
                    <?php
                        foreach ($books as $book):
                            echo $this->render('_book', ['book' => $book]);
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-12">
            <?= LinkPager::widget([
                'pagination' => $page,
            ]);
            ?>
        </div>
    </div>
</div>

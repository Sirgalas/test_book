<?php

use common\Modules\Author\Entities\Author;
use common\Modules\Book\Entities\Book;
use common\Modules\Category\Entities\Category;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\Modules\Book\Entities\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'isbn',
            'pageCount',
            'publishedDate',
            'shortDescription',
            'longDescription:ntext',
            'status',
            'image_id',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function (Book $book) {
                    if(!empty($book->image)) {
                        return Html::img($book->getImageUrl());
                    }
                    return '';
                },

            ],
            [
                'attribute' => 'categories',
                'value' => function (Book $book) {
                    if(!empty($book->categories)) {
                        return implode(
                                ", ",
                            array_map(fn(Category $category) => $category->title,$book->categories)
                        );
                    }
                    return '';
                },
            ],
            [
                'attribute' => 'authors',
                'value' => function (Book $book) {
                    if(!empty($book->authors)) {
                        return implode(
                                ", ",
                            array_map(fn(Author $author) => $author->name,$book->authors)
                        );
                    }
                    return '';
                },
            ],
        ],
    ]) ?>

</div>

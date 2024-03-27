<?php

namespace common\Modules\Category\Entities;

use common\Modules\Book\Entities\Book;
use common\Modules\Book\Entities\BooksToCategories;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $parent_id
 * @property int|null $image_id
 *
 * @property BooksToCategories[] $booksToCategories
 * @property Book[] $books
 * @property Category[] $childrens
 * @property Category $parent
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    public function getBooksToCategories(): ActiveQuery
    {
        return $this->hasMany(BooksToCategories::class, ['category_id' => 'id']);
    }

    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class,['book_id' => 'id'])->via('booksToCategories');
    }



    public function getChildrens(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['parent_id' => 'id']);
    }

    public function getParent(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }
}

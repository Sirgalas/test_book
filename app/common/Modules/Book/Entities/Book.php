<?php

namespace common\Modules\Book\Entities;

use common\Modules\Author\Entities\Author;
use common\Modules\Category\Entities\Category;
use common\Modules\Image\Entities\Image;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $isbn
 * @property int|null $pageCount
 * @property string|null $publishedDate
 * @property string|null $shortDescription
 * @property string|null $longDescription
 * @property string|null $status
 * @property int|null $image_id
 *
 * @property BooksToAuthors[] $booksToAuthors
 * @property BooksToCategories[] $booksToCategories
 * @property Author[] $authors
 * @property Category[] $categories
 * @property Image $image
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    public function getBooksToAuthors(): ActiveQuery
    {
        return $this->hasMany(BooksToAuthors::class, ['book_id' => 'id']);
    }

    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class,['author_id' => 'id'])->via('booksToAuthors');
    }


    public function getBooksToCategories(): ActiveQuery
    {
        return $this->hasMany(BooksToCategories::class, ['book_id' => 'id']);
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class,['category_id' => 'id'])->via('booksToCategories');
    }

    public function getImage():ActiveQuery
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
}

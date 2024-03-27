<?php

namespace common\Modules\Author\Entities;

use common\Modules\Author\Forms\AuthorForm;
use common\Modules\Book\Entities\Book;
use common\Modules\Book\Entities\BooksToAuthors;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $biography
 *
 * @property BooksToAuthors[] $booksToAuthors
 * @property Book[] $books
 */
class Author extends \yii\db\ActiveRecord
{

    public static function create(AuthorForm $form): self
    {
        $author = new static();
        $author->biography = $form->biography;
        $author->name = $form->name;
        return $author;
    }


    public function edit(AuthorForm $form): void
    {
        $this->biography = $form->biography;
        $this->name = $form->name;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authors';
    }

    public function getBooksToAuthors(): ActiveQuery
    {
        return $this->hasMany(BooksToAuthors::class, ['author_id' => 'id']);
    }

    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class,['book_id' => 'id'])->via('booksToAuthors');
    }
    public function equalsTo(int $id): bool
    {
        return $this->id == $id;
    }
}

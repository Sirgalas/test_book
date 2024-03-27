<?php

namespace common\Modules\Book\Entities;

use common\Modules\Author\Entities\Author;
use Yii;

/**
 * This is the model class for table "books_to_authors".
 *
 * @property int|null $book_id
 * @property int|null $author_id
 *
 * @property Author $author
 * @property Book $book
 */
class BooksToAuthors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'books_to_authors';
    }

    public static function primaryKey(): array
    {
        return ['book_id','author_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'book_id' => 'Book ID',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m240327_095839_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            "extension" => $this->string(610),
            "name" => $this->string(610),
            "url" => $this->string(610),
            "created_at" => $this->dateTime(),
            "updated_at" => $this->dateTime()
        ]);

        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            "title" => $this->string(),
            "isbn" => $this->string(20),
            "pageCount" => $this->smallInteger(),
            "publishedDate" => $this->dateTime(),
            "shortDescription" => $this->string(510),
            "longDescription" => $this->text(),
            "status" => $this->string(200),
            'image_id' =>  $this->integer()
        ]);

        $this->createIndex(
            'idx_books_image_id',
            '{{%books}}',
            'image_id');

        $this->addForeignKey(
            'fk_books_to_image',
            '{{%books}}',
            'image_id',
            '{{%images}}',
            'id',
            'SET NULL',
            'RESTRICT');

        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            "title" => $this->string(),
            "parent_id" => $this->integer(),
        ]);

        $this->createIndex(
            'idx_categories_parent_id',
            '{{%categories}}',
            'parent_id');

        $this->addForeignKey(
            'fk_categories_to_categories',
            '{{%categories}}',
            'parent_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'RESTRICT');

        $this->createTable('{{%books_to_categories}}',[
            'book_id' => $this->integer(),
            'category_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx_books_to_categories_book_id',
            '{{%books_to_categories}}',
            'book_id');

        $this->createIndex(
            'idx_books_to_categories_category_id',
            '{{%books_to_categories}}',
            'category_id');

        $this->addForeignKey(
            'fk_books_to_categories_books_table',
            '{{%books_to_categories}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE',
            'RESTRICT');

        $this->addForeignKey(
            'fk_books_to_categories_categories_table',
            '{{%books_to_categories}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'RESTRICT');

        $this->createTable('{{%authors}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(610),
            'biography' => $this->text()
        ]);

        $this->createTable('{{%books_to_authors}}',[
            'book_id' => $this->integer(),
            'author_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx_books_to_authors_book_id',
            '{{%books_to_authors}}',
            'book_id');

        $this->createIndex(
            'idx_books_to_authors_author_id',
            '{{%books_to_authors}}',
            'author_id');

        $this->addForeignKey(
            'fk_books_to_authors_books_table',
            '{{%books_to_authors}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE',
            'RESTRICT');

        $this->addForeignKey(
            'fk_books_to_books_to_authors_table',
            '{{%books_to_authors}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE',
            'RESTRICT');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books_to_authors}}');
        $this->dropTable('{{%authors}}');
        $this->dropTable('{{%books_to_categories}}');
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%book}}');
        $this->dropTable('{{%images}}');
    }
}

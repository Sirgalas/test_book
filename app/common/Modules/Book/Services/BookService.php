<?php

declare(strict_types=1);

namespace common\Modules\Book\Services;

use common\Modules\Author\Repository\AuthorRepository;
use common\Modules\Book\Entities\Book;
use common\Modules\Book\Forms\BookParserForm;
use common\Modules\Book\Repositories\BookRepository;
use common\Modules\Category\Repositories\CategoryRepository;
use common\Modules\Image\Forms\ImageForm;
use yii\base\ErrorException;


class BookService
{
    public function __construct(
        readonly public BookRepository $bookRepository,
        readonly public CategoryRepository $categoryRepository,
        readonly public AuthorRepository $authorRepository
    ) {
    }

    public function createParser(BookParserForm $form): void
    {
        if($this->bookRepository->existsByQuery(['isbn' => $form->isbn])) {
            return;
        }
        $book = Book::create($form);
        if(!empty($form->imageForm)) {
            $book->addImage($form->imageForm);
        }
        if(!empty($form->categoryForms)) {
            foreach ($form->categoryForms as $categoryForm) {
                if($this->categoryRepository->existsByQuery(['title' => $categoryForm->title])) {
                    continue;
                }
                $book->addCategory($categoryForm);
            }
        }
        if(!empty($form->authorForms)) {
            foreach ($form->authorForms as $authorForm) {
                if($this->authorRepository->existsByQuery(['name' => $authorForm->name])) {
                    continue; }
                $book->addAuthors($authorForm);
            }
        }
        $book = $this->bookRepository->save($book);
        try {
            if ($form->thumbnailUrl) {
                $book->image->saveFileImage($book->id,$form->thumbnailUrl);
            }
        } catch (ErrorException $e) {
            \Yii::error($e->getMessage());
        }

    }

    public function edit(Book $book, BookParserForm $form): Book
    {
        $book->edit($form);
        return $this->bookRepository->save($book);
    }
}
<?php

declare(strict_types=1);

namespace common\Modules\Book\Services;

use common\Modules\Book\Entities\Book;
use common\Modules\Book\Forms\BookForm;
use common\Modules\Book\Repositories\BookRepository;

class BookService
{
    public function __construct(readonly public BookRepository $bookRepository)
    {}

    public function create(BookForm $form): Book
    {
        $book = Book::create($form);
        if(!empty($form->categoryForms)) {
            foreach ($form->categoryForms as $categoryForm) {
                $book->addCategory($categoryForm);
            }
        }
        if(!empty($form->authorForms)) {
            foreach ($form->authorForms as $authorForm) {
                $book->addAuthors($authorForm);
            }
        }
        return $this->bookRepository->save($book);
    }

    public function edit(Book $book, BookForm $form): Book
    {
        $book->edit($form);
        return $this->bookRepository->save($book);
    }
}
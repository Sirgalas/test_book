<?php

declare(strict_types=1);

namespace common\Modules\Book\Services;

use common\Helpers\ErrorHelper;
use common\Modules\Author\Repository\AuthorRepository;
use common\Modules\Book\Entities\Book;
use common\Modules\Book\Forms\BookCrudForm;
use common\Modules\Book\Forms\BookParserForm;
use common\Modules\Book\Repositories\BookRepository;
use common\Modules\Category\Repositories\CategoryRepository;
use common\Modules\Image\Entities\Image;
use common\Modules\Image\Forms\ImageForm;
use http\Exception\RuntimeException;
use yii\base\ErrorException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;


class BookService
{
    public function __construct(
        readonly public BookRepository $bookRepository,
        readonly public CategoryRepository $categoryRepository,
        readonly public AuthorRepository $authorRepository
    ) {
    }

    final public function createCrud(BookCrudForm $form): Book
    {
        $book = Book::createCrud($form);
        if(!empty($form->categories_id)) {
            foreach ($form->categories_id as $categoryId) {
                $category =  $this->categoryRepository->get((int)$categoryId);
                $book->addCategory($category);
            }
        }
        if(!empty($form->authors_id)) {
            foreach ($form->authors_id as $authorId) {
                $author = $this->authorRepository->get((int)$authorId);
                $book->addAuthors($author);
            }
        }
        $this->bookRepository->save($book);

        if($form->imageFile instanceof UploadedFile) {
            $imageForm = new ImageForm();
            $imageArray = [
                'extension' => $form->imageFile->extension,
                'name'=> $form->imageFile->baseName,
                'url' => Book::URL
            ];
            if($imageForm->load($imageArray,'') && $imageForm->validate()) {
                $book->createImage($imageForm);
                FileHelper::createDirectory('/var/www/'.$book->image->getDir($book->id));
                $form->imageFile->saveAs(
                    '/var/www/'.$book->image->getImageUrl($book->id)
                );
            } else {
                throw new RuntimeException(ErrorHelper::errorsToStr($imageForm->errors));
            }
            $this->bookRepository->save($book);
        }
        return $book;
    }

    final public function edit(Book $book, BookCrudForm $form): Book
    {
        $book->edit($form);
        if(!empty($form->categories_id)) {
            $book->removeAllCategories();
            foreach ($form->categories_id as $categoryId) {
                $category =  $this->categoryRepository->get((int)$categoryId);
                $book->addCategory($category);
            }
        }
        if(!empty($form->authors_id)) {
            $book->removeAllAuthors();
            foreach ($form->authors_id as $authorId) {
                $author = $this->authorRepository->get((int)$authorId);
                $book->addAuthors($author);
            }
        }
        if($form->imageFile instanceof UploadedFile) {
            $book->deleteImage();
            $imageForm = new ImageForm();
            $imageArray = [
                'extension' => $form->imageFile->extension,
                'name'=> $form->imageFile->baseName,
                'url' => Book::URL
            ];
            if($form->load($imageArray,'') && $form->validate()) {
                $book->createImage($imageForm);
                $form->imageFile->saveAs('/var/www/'.$book->image->getImageUrl($book->id));
            }
        }
        return $this->bookRepository->save($book);
    }
    final public function createParser(BookParserForm $form): void
    {
        if($this->bookRepository->existsByQuery(['isbn' => $form->isbn])) {
            return;
        }
        $book = Book::createParser($form);
        if(!empty($form->imageForm)) {
            $book->createImage($form->imageForm);
        }
        if(!empty($form->categoryForms)) {
            foreach ($form->categoryForms as $categoryForm) {
                if($this->categoryRepository->existsByQuery(['title' => $categoryForm->title])) {
                    continue;
                }
                $book->createCategory($categoryForm);
            }
        }
        if(!empty($form->authorForms)) {
            foreach ($form->authorForms as $authorForm) {
                if($this->authorRepository->existsByQuery(['name' => $authorForm->name])) {
                    continue; }
                $book->createAuthors($authorForm);
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

}
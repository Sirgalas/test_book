<?php

declare(strict_types=1);

namespace common\Modules\Author\Services;

use common\Modules\Author\Entities\Author;
use common\Modules\Author\Forms\AuthorForm;
use common\Modules\Author\Repository\AuthorRepository;

class AuthorService
{
    public function __construct(readonly public AuthorRepository $authorRepository)
    {}

    public function create(AuthorForm $form): Author
    {
        $author = Author::create($form);
        return $this->authorRepository->save($author);
    }

    public function edit(Author $author, AuthorForm $form): Author
    {
        $author->edit($form);
        return $this->authorRepository->save($author);
    }
}
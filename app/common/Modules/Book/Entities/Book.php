<?php

namespace common\Modules\Book\Entities;

use common\Modules\Author\Entities\Author;
use common\Modules\Author\Forms\AuthorForm;
use common\Modules\Book\Forms\BookParserForm;
use common\Modules\Category\Entities\Category;
use common\Modules\Category\Forms\CategoryForm;
use common\Modules\Image\Entities\Image;
use common\Modules\Image\Forms\ImageForm;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;

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
 *
 * @property BooksToAuthors[] $booksToAuthors
 * @property BooksToCategories[] $booksToCategories
 * @property Author[] $authors
 * @property Category[] $categories
 * @property Image $image
 */
class Book extends \yii\db\ActiveRecord
{
    public const URL = 'book';
    public string $thumbnailUrl;

    public static function create(BookParserForm $forms): self
    {
        $book = new static();
        $book->title = $forms->title;
        $book->isbn = $forms->isbn;
        $book->pageCount = $forms->pageCount;
        $book->publishedDate = $forms->publishedDate;
        $book->shortDescription = $forms->shortDescription;
        $book->longDescription = $forms->longDescription;
        $book->status = $forms->status;
        return $book;
    }



    public function edit(BookParserForm $forms): void
    {
        $this->title = $forms->title;
        $this->isbn = $forms->isbn;
        $this->pageCount = $forms->pageCount;
        $this->publishedDate = $forms->publishedDate;
        $this->shortDescription = $forms->shortDescription;
        $this->longDescription = $forms->longDescription;
        $this->status = $forms->status;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }
    
    public function behaviors():array
    {
        $behaviorArray =[
            'saveRelations' =>[
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'categories',
                    'authors',
                    'image',
                ],
            ],
        ];
        return array_merge(parent::behaviors(), $behaviorArray);
    }

    public function getBooksToAuthors(): ActiveQuery
    {
        return $this->hasMany(BooksToAuthors::class, ['book_id' => 'id']);
    }

    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class,['id' => 'author_id'])->via('booksToAuthors');
    }


    public function getBooksToCategories(): ActiveQuery
    {
        return $this->hasMany(BooksToCategories::class, ['book_id' => 'id']);
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class,['id' => 'category_id'])->via('booksToCategories');
    }

    public function getImage():ActiveQuery
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
    
    public function addCategory(CategoryForm $form): void
    {
        $categories = $this->categories;
        $categories[] =  Category::create($form);
        $this->updateCategories($categories);
    }
    
    public function removeCategory(int $id): void
    {
        $categories = $this->categories;
        foreach ($categories as $i => $category) {
            if($category->equalsTo($id)) {
                unset($category[$i]);
                return;
            }
        }
        throw new NotFoundHttpException(sprintf('Category id %d is not found', $id));
    }
    
    public function removeAllCategories(): void
    {
        $this->updateCategories([]);
    }


    private function updateCategories(array $categories): void
    {
        $this->categories = $categories;
    }
    
    public function addAuthors(AuthorForm $form): void
    {
        $authors = $this->authors;
        $authors[] = Author::create($form);
        $this->updateAuthors($authors);
    }
    
    public function removeAuthor(int $id)
    {
        foreach ($this->authors as $i => $author) {
            if($author->equalsTo($id)) {
                unset($author[$i]);
            }
        }
    }
    
    public function updateAuthors(array $authors)
    {
        $this->authors = $authors;
    }

    public function addImage(ImageForm $form)
    {
        $image = Image::create($form);
        $this->image = $image;
    }

    public function deleteImage()
    {
        $this->image = null;
    }

    private function getDir(): string
    {
        return sprintf('%s/uploads/%s/%s',
            Yii::getAlias('@backendWeb'),
            $this->image->url,
            $this->id);
    }

    public function getImageUrl():string
    {
        return sprintf('%s/%s.%s',
                $this->getDir(),
                $this->image->name,
                $this->image->extension
            );
    }
}

<?php

declare(strict_types=1);

namespace common\Modules\Book\Forms;

use common\Modules\Author\Entities\Author;
use common\Modules\Author\Forms\AuthorForm;
use common\Modules\Book\Entities\Book;
use common\Modules\Category\Entities\Category;
use common\Modules\Category\Forms\CategoryForm;
use common\Modules\Image\Entities\Image;
use common\Modules\Image\Forms\ImageForm;
use yii\base\Model;
use yii\web\UploadedFile;

class BookCrudForm extends Model
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $isbn = null;
    public ?int $pageCount = null;
    public ?string $publishedDate = null;
    public ?string $shortDescription = null;
    public ?string $longDescription = null;

    public ?string $thumbnailUrl = null;

    public ?string $status = null;
    public ?array $categories_id = [];
    public ?array $authors_id = [];
    public $imageFile = null;

    public function __construct(Book $book = null, $config = [])
    {
        parent::__construct($config);
        if($book) {
            $this->id = $book->id;
            $this->title = $book->title;
            $this->isbn = $book->isbn;
            $this->pageCount = $book->pageCount;
            $this->publishedDate = $book->publishedDate;
            $this->shortDescription = $book->shortDescription;
            $this->longDescription = $book->longDescription;
            $this->status = $book->status;
            $this->authors_id = array_map(fn(Author $author) => $author->id, $book->authors);
            $this->categories_id = array_map(fn(Category $category) => $category->id, $book->categories);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categories_id','authors_id','pageCount','isbn','title','status'], 'required'],
            [['pageCount','id'], 'integer'],
            [['publishedDate'], 'safe'],
            [['longDescription'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            [['shortDescription'], 'string', 'max' => 510],
            [['status'], 'string', 'max' => 200],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
            [['categories_id','authors_id'], 'each', 'rule' => ['integer']],
        ];
    }

    public function beforeValidate()
    {
        if(parent::beforeValidate()) {
            $this->imageFile = UploadedFile::getInstance($this,'imageFile');
            return true;
        }
        return false;
    }
}
<?php

declare(strict_types=1);

namespace common\Modules\Book\Forms;


use common\Helpers\AbstractForm;
use common\Helpers\ErrorHelper;
use common\Modules\Author\Forms\AuthorForm;
use common\Modules\Book\Entities\Book;
use common\Modules\Category\Forms\CategoryForm;
use common\Modules\Image\Entities\Image;
use common\Modules\Image\Forms\ImageForm;
use yii\base\Model;

/**
 * @property CategoryForm[] $categoryForms;
 * @property AuthorForm[] $authorForms
 */

class BookParserForm extends Model
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
    public ?ImageForm $imageForm = null;
    public array $categoryForms = [];
    public array $authorForms = [];

    public function __construct(Book $book = null, $config = [])
    {
        $this->imageForm = new ImageForm();
        parent::__construct($config);
        if($book) {
            $this->title = $book->title;
            $this->isbn = $book->isbn;
            $this->pageCount = $book->pageCount;
            $this->publishedDate = $book->publishedDate;
            $this->shortDescription = $book->shortDescription;
            $this->longDescription = $book->longDescription;
            $this->status = $book->status;
            $this->imageForm = new ImageForm($book->image);
            foreach ($book->authors as $author) {
                $this->authorForms[] = new AuthorForm($author);
            }
            foreach ($book->categories as $category) {
                $this->categoryForms[] = new CategoryForm($category);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pageCount'], 'integer'],
            [['publishedDate'], 'safe'],
            [['longDescription'], 'string'],
            [['title','thumbnailUrl'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            [['shortDescription'], 'string', 'max' => 510],
            [['status'], 'string', 'max' => 200],
            /*[
             ['image_id'],
             'exist',
             'skipOnError' => true,
             'targetClass' => Image::class,
             'targetAttribute' => ['image_id' => 'id'],
            ],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'isbn' => 'Isbn',
            'pageCount' => 'Page Count',
            'publishedDate' => 'Published Date',
            'shortDescription' => 'Short Description',
            'longDescription' => 'Long Description',
            'status' => 'Status',
            'image_id' => 'Image ID',
        ];
    }

    public function load($data, $formName = null): bool
    {
        if(!empty($data['publishedDate']['$date'])){
            $publishedDate = $data['publishedDate']['$date'];
            unset($data['publishedDate']['$date']);
            $data['publishedDate'] = $publishedDate;
        }
        if(!empty($data['categories']) && is_array($data['categories'])) {
            foreach ($data['categories'] as $category) {
                $categoryForm = new CategoryForm();
                if($categoryForm->load(['title' => $category],'') && $categoryForm->validate()){
                    $this->categoryForms[] = $categoryForm;
                } else {
                    \Yii::error(ErrorHelper::errorsToStr($categoryForm->errors));
                }
            }
        }
        if(!empty($data['authors'] && is_array($data['authors']))) {
            foreach ($data['authors'] as $author) {
                $authorForm = new AuthorForm();
                if($authorForm->load(['name' => $author],'') && $authorForm->validate()) {
                    $this->authorForms[] = $authorForm;
                } else {
                    \Yii::error(ErrorHelper::errorsToStr($authorForm->errors));
                }
            }
        }

        if(!empty($data['thumbnailUrl'])) {
            $pathInfo = pathinfo($data['thumbnailUrl']);
            $imageArr = ['extension' => $pathInfo['extension'], 'name' => $pathInfo['filename'],'url'=> Book::URL];
            $imageForm = new ImageForm();
            if($imageForm->load($imageArr,'') && $imageForm->validate()) {
                $this->imageForm = $imageForm;
            } else {
                \Yii::error(ErrorHelper::errorsToStr($imageForm->errors));
            }
        }
        return parent::load($data, $formName);
    }
}
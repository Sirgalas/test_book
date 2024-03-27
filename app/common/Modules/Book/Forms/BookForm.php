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

class BookForm extends Model
{
    public $id;
    public string $title;
    public string $isbn;
    public int $pageCount;
    public string $publishedDate;
    public string $shortDescription;
    public string $longDescription;

    public string $status;
    public ImageForm $imageForm;
    public array $categoryForms;
    public array $authorForms;

    public function __construct(Book $book = null, $config = [])
    {
        $this->imageForm = new ImageForm();
        $this->categoryForms = [];
        $this->authorForms = [];
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
            [['pageCount', 'image_id'], 'default', 'value' => null],
            [['pageCount', 'image_id'], 'integer'],
            [['publishedDate'], 'safe'],
            [['longDescription'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            [['shortDescription'], 'string', 'max' => 510],
            [['status'], 'string', 'max' => 200],
            [
             ['image_id'],
             'exist',
             'skipOnError' => true,
             'targetClass' => Image::class,
             'targetAttribute' => ['image_id' => 'id'],
            ],
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
        if(!empty($data['categories']) && is_array($data['categories'])) {
            foreach ($data['categories'] as $category) {
                $categoryForm = new CategoryForm();
                if($categoryForm->load($category,'') && $categoryForm->validate()){
                    $this->categoryForms[] = $categoryForm;
                } else {
                    \Yii::error(ErrorHelper::errorsToStr($categoryForm->errors));
                }
            }
        }
        if(!empty($data['authors'] && is_array($data['authors']))) {
            foreach ($data['authors'] as $author) {
                $authorForm = new AuthorForm();
                if($authorForm->load($author,'') && $author->validate()) {
                    $this->authorForms[] = $authorForm;
                } else {
                    \Yii::error(ErrorHelper::errorsToStr($authorForm->errors));
                }
            }
        }

        if(!empty($data['image'])) {
            $imageForm = new ImageForm();
            if($imageForm->load($data['image'],'') && $imageForm->validate()) {
                $this->imageForm = $imageForm;
            } else {
                \Yii::error(ErrorHelper::errorsToStr($imageForm->errors));
            }
        }

        return parent::load($data, $formName);

    }
}
<?php

declare(strict_types=1);

namespace common\Modules\Book\Forms;


use common\Modules\Image\Entities\Image;
use yii\base\Model;

/**
 * @property int $id
 * @property string|null $title
 * @property string|null $isbn
 * @property int|null $pageCount
 * @property string|null $publishedDate
 * @property string|null $shortDescription
 * @property string|null $longDescription
 * @property string|null $status
 * @property int|null $image_id
 */

class BookForms extends Model
{
    public $id;
    public string $title;
    public string $isbn;
    public int $pageCount;
    public string $publishedDate;
    public string $shortDescription;
    public string $longDescription;
    public string $status;
    public int $image_id;


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
             'targetAttribute' => ['image_id' => 'id']
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
}
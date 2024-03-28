<?php

namespace common\Modules\Image\Entities;

use common\Modules\Book\Entities\Book;
use common\Modules\Image\Forms\ImageForm;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string|null $extension
 * @property string|null $name
 * @property string|null $url
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Book $books
 */
class Image extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function create(ImageForm $form): self
    {
        $image = new self();
        $image->extension = $form->extension;
        $image->name = $form->name;
        $image->url = $form->url;
        return $image;
    }

    public function edit(ImageForm $form): void
    {
        $this->extension = $form->extension;
        $this->name = $form->name;
        $this->url = $form->url;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }



    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['image_id' => 'id']);
    }


    public function saveFileImage(int $id,$imageUrl)
    {

        FileHelper::createDirectory($this->getDir($id));
        copy($imageUrl,$this->getImageUrl($id));
    }

    public function getDir(int $id): string
    {
        return sprintf('uploads/%s/%s',
            //Yii::getAlias('@backendWeb'),
            $this->url,
            $id
        );
    }

    public function getImageUrl(int $id):string
    {
        return sprintf('%s/%s.%s',
            $this->getDir($id),
            $this->name,
            $this->extension
        );
    }
}

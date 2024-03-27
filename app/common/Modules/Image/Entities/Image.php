<?php

namespace common\Modules\Image\Entities;

use common\Modules\Image\Forms\ImageForm;
use Yii;

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
 * @property Books[] $books
 */
class Image extends \yii\db\ActiveRecord
{

    public static function create(ImageForm $form): self
    {
        $image = new self();
        $image->extension = $form->extension;
        $image->name = $form->name;
        $image->url = $form->url;
        $image->created_at = $form->created_at;
        $image->updated_at = $form->updated_at;
        return $image;
    }

    public function edit(ImageForm $form): void
    {

        $this->extension = $form->extension;
        $this->name = $form->name;
        $this->url = $form->url;
        $this->created_at = $form->created_at;
        $this->updated_at = $form->updated_at;
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
    public function getBooks()
    {
        return $this->hasMany(Books::class, ['image_id' => 'id']);
    }
}

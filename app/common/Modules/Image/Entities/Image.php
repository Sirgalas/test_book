<?php

namespace common\Modules\Image\Entities;

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

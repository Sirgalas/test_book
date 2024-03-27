<?php

declare(strict_types=1);

namespace frontend\models;

use yii\base\Model;

class FileModel extends Model
{
    public $imageFile;

    final public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'imageFile' => 'загрузите картинку',
        ];
    }

}
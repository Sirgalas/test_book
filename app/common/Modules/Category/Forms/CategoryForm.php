<?php

declare(strict_types=1);

namespace common\Modules\Category\Forms;

use common\Modules\Category\Entities\Category;
use yii\base\Model;

class CategoryForm extends Model
{

    public int $parent_id;
    public string $title;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['parent_id', 'integer'],
            ['title', 'string', 'max' => 255],
            [
                ['parent_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::class, '
                targetAttribute' => ['parent_id' => 'id']
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
            'parent_id' => 'Parent ID',
            'image_id' => 'Image ID',
        ];
    }
}
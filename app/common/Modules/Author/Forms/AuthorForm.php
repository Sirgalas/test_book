<?php

declare(strict_types=1);

namespace common\Modules\Author\Forms;

use yii\base\Model;

class AuthorForm extends Model
{
    public string $biography;
    public string $name;

    final public function rules()
    {
        return [
            [['biography'], 'string'],
            [['name'], 'string', 'max' => 610],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'biography' => 'Biography',
        ];
    }

}
<?php

declare(strict_types=1);

namespace common\Modules\Author\Forms;

use common\Modules\Author\Entities\Author;
use yii\base\Model;

class AuthorForm extends Model
{
    public string $biography;
    public string $name;

    public function __construct(Author $author = null, $config = [])
    {
        parent::__construct($config);
        if($author) {
            $this->biography = $author->biography;
            $this->name = $author->name;
        }
    }

    final public function rules()
    {
        return [
            [['biography'], 'string'],
            [['name'], 'string', 'max' => 610],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'biography' => 'Biography',
        ];
    }

}
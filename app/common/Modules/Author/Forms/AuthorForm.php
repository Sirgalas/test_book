<?php

declare(strict_types=1);

namespace common\Modules\Author\Forms;

use common\Modules\Author\Entities\Author;
use yii\base\Model;

class AuthorForm extends Model
{
    public ?int $id = null;
    public ?string $biography = null;
    public ?string $name = null;

    public function __construct(Author $author = null, $config = [])
    {
        parent::__construct($config);
        if($author) {
            $this->id = $author->id;
            $this->biography = $author->biography;
            $this->name = $author->name;
        }
    }

    final public function rules()
    {
        return [
            ['id','integer'],
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
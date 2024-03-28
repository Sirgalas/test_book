<?php

declare(strict_types=1);

namespace common\Modules\Parser\Forms;

use yii\base\Model;

class TreeForm extends Model
{
    public ?string $id = null;
    public ?string $name = null;
    public ?string $type = null;
    public ?string $path = null;
    public ?string $mode = null;


    public function rules(): array
    {
        return [
            [['id','name','type','path','mode'], 'string'],
        ];
    }
}
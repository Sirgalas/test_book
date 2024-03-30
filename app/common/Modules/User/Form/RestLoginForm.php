<?php

declare(strict_types=1);

namespace common\Modules\User\Form;

use yii\base\Model;

class RestLoginForm extends Model
{
    public $username;
    public $password;
    public function rules(): array
    {
        return  [
            [['username','password'],'string']
        ];
    }
}
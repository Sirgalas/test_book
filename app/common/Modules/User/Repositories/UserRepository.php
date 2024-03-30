<?php

declare(strict_types=1);

namespace common\Modules\User\Repositories;

use common\Exception\AccessException;
use common\Helpers\ErrorHelper;
use common\Modules\User\Entities\User;
use yii\db\ActiveRecord;

class UserRepository
{
    public function save(User $user)
    {
        if(!$user->save()) {
            throw new \RuntimeException(ErrorHelper::errorsToStr($user->errors));
        }
        return $user;
    }

    public function getUserByNicknameOrEmail(string $string): ActiveRecord
    {
        if(!$user = User::find()->where(['or',['username'=>$string],['email'=>$string]])->one()){
            throw new AccessException('Пользователь не найден',500);
        }

        return $user;
    }

}
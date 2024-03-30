<?php

declare(strict_types=1);

namespace common\Modules\User\Services;

use common\Exception\AccessException;
use common\Modules\User\Entities\User;
use common\Modules\User\Form\RestLoginForm;
use common\Modules\User\Repositories\UserRepository;

class UserService
{
    public function __construct(readonly public UserRepository $repository)
    {
    }
    public function auth(RestLoginForm $form)
    {
        $user = $this->repository->getUserByNicknameOrEmail($form->username);
        if(!$user instanceof User) {
            throw new AccessException('Пользователь не найден, или пароль не подходит');
        }
        if(!$user->validatePassword($form->password)) {
            throw new AccessException('Пользователь не найден, или пароль не подходит');
        }
        $user->rest_access_token = User::generateToken();
        $this->repository->save($user);
        return ['token' => $user->rest_access_token];
    }
}
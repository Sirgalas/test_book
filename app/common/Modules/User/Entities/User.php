<?php

declare(strict_types=1);

namespace common\Modules\User\Entities;


/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $unconfirmed_email
 * @property string $password_hash
 * @property string $auth_key
 * @property string $registration_ip
 * @property int $confirmed_at
 * @property int $blocked_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $last_login_at
 */
use common\Exception\AccessException;
use yii\web\IdentityInterface;

/**
 * @property string $rest_access_token
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }
    public static function findIdentityByAccessToken($token, $type = null): static
    {
        $user = static::findOne(['rest_access_token' => $token]);
        if(!$user instanceof User) {
            throw new AccessException('token not found');
        }
        return $user;
    }

    public function loginByAccessToken($token)
    {
        $user = static::findOne(['rest_access_token' => $token]);
        if(!$user instanceof User) {
            throw new AccessException('token not found');
        }
        return $user;
    }
    public static function generateToken($length = 32){
        return \Yii::$app->security->generateRandomString($length) . '_' . time();
    }

    public static function findIdentity($id): User
    {
        return static::findOne(['id' => $id]);
    }

    public function getId(): int
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password):bool
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    public function getIdentity()
    {
        return $this;
    }
}
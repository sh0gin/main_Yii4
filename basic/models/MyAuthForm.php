<?php

namespace app\models;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class MyAuthForm extends ActiveRecord implements IdentityInterface{

        public $name;
        public $surname;
        public $patronymic;
        public $login;
        public $email;
        public $password;
        public $password_repeat;

    public static function tableName() {
        return 'user';
    }

    public static function findIdentity($id)
    {
        // return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        // return $this->id;
    }

    public function getAuthKey()
    {
        // return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        // return $this->authKey === $authKey;
    }
}




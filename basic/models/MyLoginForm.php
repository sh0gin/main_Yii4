<?php

namespace app\models;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class MyLoginForm extends ActiveRecord implements IdentityInterface{

    public $login;
    public $password;

    // public static function tableName() {
    //     return "posts";
    // }

    // public function attributeLabels() {
    //     return [
    //         'name' => 'Имя',
    //         'email' => 'E-mail',
    //         'text' => 'Текст сообщения',
    //     ];
    // }

    public function rules() {
        return [
            [['login', 'password'], 'required'],
        ];
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
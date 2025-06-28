<?php

namespace app\models;
use yii\db\ActiveRecord;

class MyLoginForm extends ActiveRecord {

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
}
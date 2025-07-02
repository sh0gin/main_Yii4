<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property int $id
 * @property string $login
 * @property string $surname
 * @property string $patronymic
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $password_repeat
 * @property string|null $token
 * @property int $role
 */
class User2 extends \yii\db\ActiveRecord
{

    public $password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password'], 'required'],
            [['login'], 'required'],

            [['surname', 'patronymic', 'name', 'email', 'password_repeat'], 'trim', 'on' => ['auth']],
            [['surname', 'patronymic', 'name', 'email', 'password_repeat'], 'required', 'on' => ['auth']],
            [['email'], 'email', 'on' => ['auth']],
            [['login', 'email'], "unique", 'on' => ['auth']],
            ['password', 'compare', 'on' => ['auth']],

            // [['surname', 'patronymic', 'name', 'email', 'password_repeat'], 'string', 'max' => 255, 'on' => ['auth']],

            // [['token'], 'default', 'value' => null],
            // [['role'], 'default', 'value' => 0],
            // [['role'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'token' => 'Token',
            'role' => 'Role',
        ];
    }
}

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
 * @property string|null $token
 * @property int $role
 */
class User2 extends \yii\db\ActiveRecord
{


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
            [['token'], 'default', 'value' => null],
            [['role'], 'default', 'value' => 0],
            [['login', 'surname', 'patronymic', 'name', 'email', 'password'], 'required'],
            [['role'], 'integer'],
            [['login', 'surname', 'patronymic', 'name', 'email', 'password', 'token'], 'string', 'max' => 255],
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

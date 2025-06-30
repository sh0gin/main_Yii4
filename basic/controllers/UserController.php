<?php

namespace app\controllers;


use app\models\MyLoginForm;
use app\models\User;
use Yii;


class UserController extends AppController
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLoad()
    {
        $model = new MyLoginForm();
        $post = Yii::$app->request->post();





        $user = User::findOne(['login' => $post['login']]);
        if (!$user) {
            echo json_encode([
                'status' => false,
                'valid_login' => "Нет такого логина!",
                'valid_password' => "",
                'login' => $model->login,
                "password" => $model->password,
            ]);
        }
        // status / valid_login / valid_password / login / password / token
        // status / valid_login / valid_passwod / login / password
        $model->load(Yii::$app->request->post(), "");
        if ($model->validate()) {
            if (Yii::$app->getSecurity()->validatePassword($post['password'], $user->password)) {
                // echo "PASSWORD is succesfull";
                if (Yii::$app->user->login($model)) {
                    $token = Yii::$app->security->generateRandomString();
                     echo json_encode([
                    'status' => true,
                    'valid_login' => "",
                    'valid_password' => "",
                    'login' => $model->login,
                    "password" => $model->password,
                    'token' => $token,
                ]);
                }
            } else {
                echo json_encode([
                'status' => false,
                'valid_login' => "",
                'valid_password' => "Неверный пароль",
                'login' => $model->login,
                "password" => $model->password,
            ]);
            };
        } else {
            $valid = $model->getErrors();

            if (!array_key_exists("login", $valid)) {
                $valid['login'] = false;
            } else {
                $valid['login'] = $valid['login'][0];
            }

            if (!array_key_exists("password", $valid)) {
                $valid['password'] = false;
            } else {
                $valid['password'] = $valid['password'][0];
            }


            echo json_encode([
                'status' => false,
                'valid_login' => $valid['login'],
                'valid_password' => $valid['password'],
                'login' => $model->login,
                "password" => $model->password,
            ]);
            // $this->printd($model->getErrors());
        }
        die;
        // $user::validatePassword($post['password']);

        // Yii::$app->user->login($user);

        // if (Yii::$app->user->isGuest) {
        //     echo "User is GUEST";
        // } else {
        //     echo "User is NOT GUEST";
        // }


        //Yii::$app->user->login($user);
        // $model->load(['MyLogin' => Yii::$app->request->post()], "MyLogin");
        // // $this->printd($model);
        // $model->login();
        // $this->printd($model); die;
        // if ($model->load(Yii::$app->request->post())) {
        //     $this->printd(Yii::$app->request->post());
        //     $this->printd($model);
        // }
        // die;
    }
}

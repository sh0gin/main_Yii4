<?php

namespace app\controllers;

use app\models\Block;
use app\models\MyLoginForm;
use app\models\MyRegisterForm;
use yii\i18n\Formatter;
use app\models\User;
use app\models\User2;
use Yii;

// создание и редактирование постов
// комментарий и ответ на комментарий
// пагинация
// админка

// функция определения смособностей usera, пока не понимаю как это сделать  
class UserController extends AppController
{

    public $enableCsrfValidation = false;


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLoad()
    {
        $model = new User2();
        $post = Yii::$app->request->post();

        // status / valid_login / valid_password / login / password / token
        // status / valid_login / valid_passwod / login / password
        $model->load(Yii::$app->request->post(), "");

        if ($model->validate()) {
            $user = User2::findOne(['login' => $post['login']]); // порядок выполнения
            if (Yii::$app->security->validatePassword($post['password'], $user->password)) {

                // ----

                $model_block = new Block();
                $model_block = $model_block->find()->where(['user_id' => $user->id])->orderBy(['id' => SORT_DESC])->one();
                if ($model_block) {
                    $model_formatter = new  Formatter();
                    if ($model_block->date_end != null) {
                        $end_block = (int) $model_formatter->asTimestamp($model_block->date_end);
                    } else {
                        $model->__user_ban = "никогда";
                    }
                    if (isset($end_block)) {
                        $current_time = (int) Yii::$app->formatter->asTimestamp('now');
                        if ($end_block - $current_time > 0) {
                            $model->__user_ban = $model_block->date_end;
                        }
                    }
                    if ($model->__user_ban) {
                        return $this->asJson([
                            'status' => false,
                            'valid_login' => "Пользователь заблокирован. Дата разблокировки: {$model->__user_ban}",
                            'valid_password' => "",
                            'login' => $model->login,
                            "password" => $model->password,
                            'token' => $user->token,
                        ]);
                    }
                }

                // ----

                $user['token'] = Yii::$app->security->generateRandomString();
                $user->save();
                return $this->asJson([
                    'status' => true,
                    'valid_login' => "",
                    'valid_password' => "",
                    'login' => $model->login,
                    "password" => $model->password,
                    'token' => $user->token,
                ]);
            } else {
                return $this->asJson([
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


            return $this->asJson([
                'status' => false,
                'valid_login' => $valid['login'],
                'valid_password' => $valid['password'],
                'login' => $model->login,
                "password" => $model->password,
            ]);
        }
    }


    public function actionLogout()
    {
        $token = Yii::$app->request->post()['token'];
        $user = User::findOne(['token' => $token]);
        $user['token'] = NULL;
        $user->save();
    }

    public function actionRegister()
    {
        $post = Yii::$app->request->post();
        $user = new User2();
        $user->scenario = 'auth';
        if ($user->load($post, '') && $user->validate()) {
            // $this->printd($user);
            $hash = Yii::$app->security->generatePasswordHash($user->password);
            $user->password = $hash;
            $user->password_repeat = $hash;
            if ($user->save()) {
                return $this->asJson([

                    'status' => false,
                    'valid_login' => "",
                    'valid_password' => "",
                    'valid_password_repeat' => "",
                    'valid_email' => "",
                    'valid_patronymic' => "",
                    'valid_name' => "",
                    'valid_surname' => "",
                    'login' => $user->login,
                    'password' => $user->password,
                    'password_repeat' => $user->password_repeat,
                    'email' => $user->email,
                    'patronymic' => $user->patronymic,
                    'name' => $user->name,
                    'surname' => $user->surname,
                ]);
            } else {
                echo 'tundutunt';
            };
        } else {
            $valid = $user->getErrors();
            $name_of_field = array_keys($post); // need to do validate cool

            foreach ($name_of_field as $value) {
                if (!array_key_exists($value, $valid)) {
                    $valid[$value] = false;
                } else {
                    $valid[$value] = $valid[$value][0];
                }
            }

            return $this->asJson([

                'status' => true,
                'valid_login' => $valid['login'],
                'valid_password' => $valid['password'],
                'valid_password_repeat' => $valid['password_repeat'],
                'valid_email' => $valid['email'],
                'valid_patronymic' => $valid['patronymic'],
                'valid_name' => $valid['name'],
                'valid_surname' => $valid['surname'],
                'login' => $user->login,
                'password' => $user->password,
                'password_repeat' => $user->password_repeat,
                'email' => $user->email,
                'patronymic' => $user->patronymic,
                'name' => $user->name,
                'surname' => $user->surname,

            ]);
        }
    }

    public function actionPermanent()
    {
        $post = Yii::$app->request->post();
        $model_user = User::findOne($post['user_id']);
        $model_block = new Block();
        if (!$model_user->role) {
            if ($model_block->load($post, '') && $model_block->save()) {
            }
        }
    }

    public function actionBlockForDate()
    {
        $post = Yii::$app->request->post();
        $model_user = User::findOne($post['user_id']);
        $model_block = new Block();
        $model_block->scenario = 'date';
        if (!$model_user->role) {
            if ($model_block->load($post, '') && $model_block->save()) {
                return $this->asJson([
                    'status' => true,
                ]);
            } else {
                $valid = $model_block->getErrors();
                return $this->asJson([
                    'status' => false,
                    'message' => array_key_exists('date_end', $valid) ? $valid['date_end'] : "",
                ]);
            }
        }
        // $model_user = User::findOne($post['user_id']);
        // $model_block = new Block();
        // if (!$model_user->role){
        //     if ($model_block->load($post, '') && $model_block->save()) {
        //         $this->printd($model_block->user_id);
        //     }
        // }
    }
}





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
        // model->login();
        // $this->printd($model); die;
        // if ($model->load(Yii::$app->request->post())) {
        //     $this->printd(Yii::$app->request->post());
        //     $this->printd($model);
        // }
        // die;
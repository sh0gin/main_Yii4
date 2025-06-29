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
        // Yii::$app->user->login($user);
        $this->printd($model);
        if (Yii::$app->user->isGuest) 
        {
            echo "User is GUEST";
        } else 
        {
            echo "User is NOT GUEST";
        }


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

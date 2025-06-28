<?php

namespace app\controllers;


use app\models\Mylogin;
use app\models\MyLoginForm;
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
        $this->printd(Yii::$app->user); die;
        $model = new MyLoginForm();
        $model->load(['MyLogin' => Yii::$app->request->post()], "MyLogin");
        if ($model->load(Yii::$app->request->post())) {
            $this->printd(Yii::$app->request->post());
            $this->printd($model);
        }

        die;

    }

}

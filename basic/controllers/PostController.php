<?php

namespace app\controllers;
use Yii;
class PostController extends \yii\web\Controller
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLoad() 
    {
        var_dump(Yii::$app->request->post()); die;
    }

}

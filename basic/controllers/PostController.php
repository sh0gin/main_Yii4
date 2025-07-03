<?php

namespace app\controllers;

use app\models\Post;
use yii\web\UploadedFile;
use Yii;


class PostController extends AppController
{
    public $enableCsrfValidation = false;


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLoad()
    {
        $model = new Post();
        var_dump(UploadedFile::getInstance($model, 'image'));
            // $post = Yii::$app->request;
        // $this->printd($post);
    }
}

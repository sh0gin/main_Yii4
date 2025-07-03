<?php

namespace app\controllers;

use app\models\Comment;
use app\models\User;

use Yii;

class CommentController extends  AppController
{

    public $enableCsrfValidation = false;


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLoad()
    {
        $post = Yii::$app->request->post();
        $model = new Comment();
        $post['autor_id'] = User::findOne(['token' => $post['token']])->id;
        unset($post['token']);


        if ($model->load($post, '') && $model->save()) {
            return $this->asJson([
                'status' => false,
                'message' => $model->message,
                'valid_message' => "",
            ]);
        } else {
            $valid = $model->getErrors();

            if (!array_key_exists("message", $valid)) {
                $valid['message'] = false;
            } else {
                $valid['message'] = $valid['message'][0];
            }

            return $this->asJson([
                'status' => true,
                'message' => $model->message,
                'valid_message' => $valid['message'],
            ]);
        }
    }
    public function actionDelete()
    {
        $post = Yii::$app->request->post(); 

        $model = Comment::findOne($post['id_comment']);

        if ($model->delete()) {
            return $this->asJson([
                    'status' => true,
                ]);
        } else {
            return $this->asJson([
                    'status' => false,
                ]);
        };
    }
}

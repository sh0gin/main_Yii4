<?php

namespace app\controllers;

use app\models\Comment;
use app\models\User2;
use app\models\Post;

use Yii;
use yii\data\ActiveDataProvider;

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
        $post['autor_id'] = User2::findOne(['token' => $post['token']])->id;
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

    public function actionLoadAnswer()
    {
        $post = Yii::$app->request->post();
        // $this->printd($post); 
        $model = new Comment();
        $post['autor_id'] = User2::findOne(['token' => $post['token']])->id;
        unset($post['token']);

        // $this->printd($post); die;
        $model->scenario = 'answer';
        if ($model->load($post, '') && $model->save()) {
            // $this->printd($model); die;
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

    public function actionGetComments()
    {
        $post = Yii::$app->request->post();
        $model_user = User2::findOne(['token' => $post['token']]);
        if ($model_user) {
            $id = $model_user->id;
            $role = $model_user->role;
        } else {
            $id = 0;
            $role = 0;
        }

        $provider = new ActiveDataProvider([
            'query' => Comment::find()->where(['post_id' => $post['id_post']]),
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]],
        ]);
        $models_comments = $provider->getModels();

        $answers = [];
        $result = [];

        foreach ($models_comments as $model_comment) {
            if ($model_comment->comment_id) {
                $answers[] = $model_comment;
            } else {
                $result[] = $model_comment;
            }
        }

        foreach ($answers as $value) {

            $index = array_shift(array_filter(array_map(fn($elem, $key) =>
            $elem->id == $value->comment_id ? $key : "", $result, array_keys($result)), fn($elem) => is_int($elem))); // индекс элемента к которому принадлежит комментарий

            $result = array_merge(array_slice($result, 0, $index + 1), [$value], array_slice($result, $index + 1));
        }

        $result2 = [];

        foreach ($result as $value) {

            $user = User2::findOne($value->autor_id);
            $result2[] = ['result' => $value, 'user' => $user];
        }

        return $this->asJson([
            'status' => false,
            'model' => $result2,
            'id' => $id,
            'role' => $role,
        ]);
    }
}

<?php

namespace app\controllers;

use app\models\Image;
use app\models\Post;
use app\models\User2;
use app\models\Comment;
use yii\data\Pagination;
use yii\web\UploadedFile;

use Yii;
use yii\data\Sort;
use yii\web\Response;

class PostController extends AppController
{
    public $enableCsrfValidation = false;
    public $isNewRecord;


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLoad()
    {
        $model = new Post();
        $user = new User2();
        $post = Yii::$app->request->post();

        $autor_id = $user->findOne(['token' => $post['token']])->id; // вместо токена, даём id польхзователя
        unset($post['token']);
        $post['autor_id'] = $autor_id;
        if ($post['id_post'] === 'null') { // тут решаем будет ли пост сохраняться как новый или обновляться
            $model->isNewRecord = true;
            unset($post['id_post']);
        } else {
            $model->id = $post['id_post'];
            $model->isNewRecord = false;
        }

        // var_dump($this->isNewRecord);
        // $this->printd($post); die;

        if ($model->load($post, '') && $model->save()) {
            if (UploadedFile::getInstanceByName('image')) {
                $model->image = UploadedFile::getInstanceByName('image');
                $model->upload();
                $image = new Image();
                $image->load(['image' => "images/{$model->image->fullPath}", 'post_id' => $model->id], '');
                $image->save();
            }
            // $this->printd($model);
            return $this->asJson([
                'status' => false,
                'title' => $model->title,
                'content' => $model->content,
                'preview' => $model->preview,
                'id' => $model->id,
            ]);
        } else {

            $valid = $model->getErrors();
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
                'valid_title' => $valid['title'],
                'valid_content' => $valid['content'],
                'valid_preview' => $valid['preview'],
                'title' => $model->title,
                'content' => $model->content,
                'preview' => $model->preview,
            ]);
        }
    }

    public function actionDelete()
    {
        $post = Yii::$app->request->post();
        $model = Post::findOne($post['id_post']);
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

    public function actionGetPost()
    {

        $post = Yii::$app->request->post();

        $model_post = new Post();
        $model_image = new Image();
        $model_user = new User2();
        $model_comment = new Comment();
        $model_post = $model_post->findOne(['id' => $post['id']]);
        if ($model_image->findOne(['post_id' => $post['id']])) {
            $model_post->url_image = $model_image->findOne(['post_id' => $post['id']])->image;
        } else {
            $model_post->url_image = '';
        }

        if ($post['token']) {
            $id = $model_user->findOne(['token' => $post['token']])->id;
            $role = $model_user->findOne(['token' => $post['token']])->role;
            return $this->asJson([
                'post' => $model_post,
                'id' => $id,
                'comment_count' => $model_comment::find()->where(['post_id' => $model_post->id])->count(),
                'user' => $model_user->findOne($model_post->autor_id),
                'url_image' => $model_post->url_image,
                'role' => $role,
            ]);
        }

        return $this->asJson([
            'post' => $model_post,
            'user' => $model_user->findOne($model_post->autor_id),
            'url_image' => $model_post->url_image,
            'id' => 0,
            'role' => 0,
        ]);
    }

    public function actionGetPosts()
    {
      

        $post = Yii::$app->request->post();
        $model_user = new User2();

        $query = Post::find();
        $countQuery = clone $query;

        if ($post['ten_post']) {
            $default = 10;
        } else {
            $default = 20;
        }

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => $default]);
        // $this->printd($pages); die;// ['totalCount' => $countQuery->count()]
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $result = [];
        $id = 0;
        $role = 0;
        if ($post['token']) {
            $id = $model_user->findOne(['token' => $post['token']])->id;
            $role = $model_user->findOne(['token' => $post['token']])->id;
        }

        foreach ($models as $model) {
            $user = $model_user->findOne($model->autor_id);
            $result[] = ['model' => $model, 'user' => $user, 'id' => $id, 'role' => $role];
        }

        return $this->asJson([
            'models' => ['result' => $result],
            'pages' => $pages,
        ]);
    }


}

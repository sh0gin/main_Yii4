<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $autor_id
 * @property int $post_id
 * @property int|null $comment_id
 * @property string $message
 * @property string $date
 *
 * @property User $autor
 * @property Comment $comment
 * @property Comment[] $comments
 * @property Post $post
 */
class Comment extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['comment_id'], 'default', 'value' => null],
            [['autor_id', 'post_id', 'message'], 'required'],
            [['comment_id'], 'required', 'on'=> 'answer'],

            // [['autor_id', 'post_id', 'comment_id'], 'integer'],
            // [['message'], 'string'],
            // [['date'], 'safe'],
            // [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['autor_id' => 'id']],
            // [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
            // [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::class, 'targetAttribute' => ['comment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'autor_id' => 'Autor ID',
            'post_id' => 'Post ID',
            'comment_id' => 'Comment ID',
            'message' => 'Message',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[Autor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutor()
    {
        return $this->hasOne(User::class, ['id' => 'autor_id']);
    }

    /**
     * Gets query for [[Comment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::class, ['id' => 'comment_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['comment_id' => 'id']);
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

}

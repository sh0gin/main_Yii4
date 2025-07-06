<?php

namespace app\models;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "Post".
 *
 * @property int $id
 * @property int $autor_id
 * @property string $date
 * @property string $content
 * @property string $title
 * @property string $preview
 */
class Post extends \yii\db\ActiveRecord
{

    public $image;
    public $user;
    public $url_image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'title', 'preview', "autor_id"], 'required'],
            [['image'], 'file'],
            // [['autor_id', 'content', 'title', 'preview'], 'required'],
            // [['autor_id'], 'integer'],
            // [['date'], 'safe'],
            // [['content'], 'string'],
            // [['title', 'preview'], 'string', 'max' => 255],
            // [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['autor_id' => 'id']],
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
            'date' => 'Date',
            'content' => 'Content',
            'title' => 'Title',
            'preview' => 'Preview',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs(__DIR__ .  '/../../images/' . $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }
}

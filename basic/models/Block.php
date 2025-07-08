<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "block".
 *
 * @property int $id
 * @property string $date_start
 * @property string|null $date_end
 * @property int $user_id
 *
 * @property User $user
 */
class Block extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_end'], 'default', 'value' => null, 'on' => ['date']],
            [['date_end'], 'required', 'on' => ['date'], 'message' => "Нужно выбрать дату окончания блокировки"],
            [['date_start', 'date_end'], 'safe'],
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            // [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}

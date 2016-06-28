<?php

namespace app\models;

use yii\db\ActiveQuery;

class Chat extends \yii\db\ActiveRecord
{
    static function tableName()
    {
        return 'app_chats';
    }

    public function rules()
    {
        return [
            [['opponent1', 'opponent2'], 'required'],
            [['opponent1', 'opponent2'], 'integer'],
        ];
    }

    static function find()
    {
        return new ChatQuery(self::class);
    }

    function getMessages()
    {
        return $this->hasMany(Message::class, ['id_chat' => 'id']);
    }

    public static function getChatByUsers($user1, $user2)
    {
        return self::find()->andWhere('(opponent1 = :user1 OR opponent2 = :user1) AND (opponent1 = :user2 OR opponent2 = :user2)',
            [':user1' => $user1, ':user2' => $user2])->one();
    }

    function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->date_send = time();
        return true;
    }
}

class ChatQuery extends ActiveQuery
{
    function my($user_id)
    {
        $this->andWhere('opponent1 = :user_id OR opponent2 = :user_id', ['user_id' => $user_id]);
        return $this;
    }
}
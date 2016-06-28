<?php

namespace app\models;

class Message extends \yii\db\ActiveRecord
{
    static function tableName()
    {
        return 'app_messages';
    }

    public function rules()
    {
        return [
            [['message_text', 'id_chat', 'sender', 'receiver'], 'required'],
            [['id_chat', 'sender', 'receiver'], 'integer'],
            [['message_text'], 'string', 'length' => [1]],
        ];
    }

    function getChat()
    {
        return $this->hasOne(Chat::class, ['id' => 'id_chat']);
    }

    function getReceiverInfo()
    {
        return $this->hasOne(User::class, ['id' => 'receiver'])->select(['name']);
    }

    function getSenderInfo()
    {
        return $this->hasOne(User::class, ['id' => 'sender'])->select(['name']);
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
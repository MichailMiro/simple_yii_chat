<?php

namespace app\models;

class User extends \yii\db\ActiveRecord
{
    static function tableName()
    {
        return 'app_users';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'length' => [3, 124]],
        ];
    }
}
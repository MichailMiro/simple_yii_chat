<?php

namespace app\models\auth;

use Yii;

class UserIdentity extends \app\models\User
    implements \yii\web\IdentityInterface
{
    static function findIdentity($id)
    {
        if ($id < 1) {
            return null;
        }

        $user = static::findOne($id);
        if (!$user) {
            return null;
        }

        return $user;
    }

    static function findIdentityByAccessToken($token, $type = null)
    {
    }

    function getId()
    {
        return $this->id;
    }

    function getAuthKey()
    {
    }

    function validateAuthKey($authKey)
    {
    }
}

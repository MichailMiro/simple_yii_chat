<?php

namespace app\components\auth;

use Yii;
use yii\web\Cookie;

class User extends \yii\web\User
{
    function removeIdentityCookie()
    {
        Yii::$app->getResponse()->getCookies()->remove(new Cookie($this->identityCookie));
    }

    protected function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);
        $identity->last_login = time();
        $identity->save(false);
        if ($cookieBased && $identity) {
            $this->sendIdentityCookie($identity, $duration);
        }
    }
}

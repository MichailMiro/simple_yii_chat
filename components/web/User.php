<?php

namespace app\components\web;

use Yii;

class User extends \app\components\auth\User
{
    public $enableAutoLogin = true;

    public $autoRenewCookie = false;

    public $identityCookie = ['name' => '_u', 'httpOnly' => true];
}

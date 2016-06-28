<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use app\models\User;
use app\models\Chat;
use app\models\Message;

use app\models\auth\UserIdentity;


class DefaultController extends Controller
{

    public function actionIndex()
    {
        $viewData = [];

        if (!Yii::$app->getUser()->getIsGuest()) {
            $user = User::findOne(Yii::$app->getUser()->id);
            $users = User::find()->andWhere('id <> :id', [':id' => $user->id])->all();
            $chats = Chat::find()->my($user->id)->all();

            $viewData['user'] = $user;
            $viewData['users'] = $users;
            $viewData['chats'] = $chats;

            return $this->render('index', $viewData);
        } else {
            return $this->redirect('default/login');
        }

    }

    public function actionLogin()
    {
        $httpRequest = Yii::$app->request;

        if ($httpRequest->getIsPost()) {
            if (!$user = User::find()->andWhere('name = :name', [':name' => $_POST['name']])->one()) {
                $user = new User;
                $user->setAttributes(['name' => $_POST['name']]);
                if ($user->validate()) {
                    $user->save();
                } else {
                    $error = '';
                    foreach ($user->getErrors() as $key => $value) {
                        $error .= $key . ': ' . $value[0];
                    }
                    Yii::$app->getSession()->setFlash('error', $error);
                    return $this->goHome();
                }
            }

            $q = UserIdentity::find()
                ->where(['name' => $user->name]);
            $userIdentity = $q->one();

            Yii::$app->getUser()->login($userIdentity, 86400 * 14);
            return $this->goHome();
        }

        return $this->render('login');
    }

    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

    public function actionOpenChat($user_id)
    {
        $httpRequest = Yii::$app->request;

        if ($httpRequest->isAjax) {
            $chat = Chat::getChatByUsers($user_id, Yii::$app->getUser()->id);

            $result['success'] = true;
            $result['result'] = $this->renderPartial('__chat_block',
                ['chat' => $chat, 'current_user' => Yii::$app->getUser()->id, 'user_receiver' => $user_id]);

            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $result;
        }
    }

    public function actionAddMessage()
    {
        $httpRequest = Yii::$app->request;
        if ($httpRequest->isAjax && $httpRequest->getIsPost()) {
            $chat_id = $_POST['chat_id'];

            if (!$chat_id) {
                $chat = new Chat;
                $chat->setAttributes(['opponent1' => $_POST['user_sender'], 'opponent2' => $_POST['user_receiver']]);
                if ($chat->validate()) {
                    $chat->save();
                    $chat_id = $chat->id;
                } else {
                    $result['success'] = false;
                }
            }

            if ($chat_id) {
                $message = new Message;
                $message->setAttributes([
                    'id_chat' => $chat_id,
                    'message_text' => $_POST['message'],
                    'sender' => $_POST['user_sender'],
                    'receiver' => $_POST['user_receiver']
                ]);

                if ($message->validate()) {
                    $message->save();
                    $result['success'] = true;
                    $result['result'] = $this->renderPartial('__message_field_left',
                        ['message' => $message, 'user_name' => $message->senderInfo->name]);
                    $result['chat_id'] = $chat_id;
                } else {
                    $result['success'] = false;
                    $error = '';
                    foreach ($message->getErrors() as $key => $value) {
                        $error .= $value[0];
                    }
                    $result['error'] = $error;
                }
            }

            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $result;
        }
    }

    public function actionCheckChat()
    {
        $httpRequest = Yii::$app->request;

        if ($httpRequest->isAjax && $httpRequest->getIsPost()) {
            $messages = Message::find()
                ->andWhere('(sender = :user_sender OR sender = :user_receiver) AND (receiver = :user_sender OR receiver = :user_receiver) AND id > :last_message',
                    [
                        ':user_sender' => $_POST['user_sender'],
                        ':user_receiver' => $_POST['user_receiver'],
                        ':last_message' => $_POST['last_message']
                    ])
                ->all();

            if ($messages) {
                $result['result'] = '';
                foreach ($messages as $message) {
                    $result['success'] = true;
                    $result['result'] .= $this->renderPartial('__message_field_right',
                        ['message' => $message, 'user_name' => $message->senderInfo->name]);
                }
            } else {
                $result['success'] = false;
            }

            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $result;
        }
    }

    public function actionError()
    {
        return $this->render('error');
    }
}

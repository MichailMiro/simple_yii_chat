<?php

use yii\helpers\Html;

?>
<li class="left clearfix" data-value="<?= $message->id ?>">
    <div class="chat-body clearfix">
        <div class="header">
            <strong class="primary-font"><?= Html::encode($user_name); ?></strong>
            <small class="pull-right text-muted">
                <span class="glyphicon glyphicon-time"></span><?= Yii::$app->formatter->format($message->date_send,
                    'relativeTime') ?>
            </small>
        </div>
        <p>
            <?= Html::encode($message->message_text); ?>
        </p>
    </div>
</li>
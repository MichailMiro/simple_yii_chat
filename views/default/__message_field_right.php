<?php

use yii\helpers\Html;

?>
<li class="right clearfix" data-value="<?= $message->id ?>">
    <div class="chat-body clearfix">
        <div class="header">
            <small class=" text-muted">
                <span class="glyphicon glyphicon-time"></span><?= Yii::$app->formatter->format($message->date_send,
                    'relativeTime') ?>
            </small>
            <strong class="pull-right primary-font"><?= Html::encode($user_name); ?></strong>
        </div>
        <p>
            <?= Html::encode($message->message_text); ?>
        </p>
    </div>
</li>
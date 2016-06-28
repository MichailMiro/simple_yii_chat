<?php

use yii\helpers\Html;

?>
<div class="panel">
    <div class="panel-body-chat">
        <?php if (!empty($chat)) { ?>
            <ul class="chat">
                <?php foreach ($chat->messages as $message) { ?>

                    <?php if ($message->sender == $current_user) { ?>
                        <li class="left clearfix" data-value="<?= $message->id ?>">
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong
                                        class="primary-font"><?= Html::encode($message->senderInfo->name); ?></strong>
                                    <small class="pull-right text-muted">
                                        <span
                                            class="glyphicon glyphicon-time"></span><?= Yii::$app->formatter->format($message->date_send,
                                            'relativeTime') ?>
                                    </small>
                                </div>
                                <p>
                                    <?= Html::encode($message->message_text); ?>
                                </p>
                            </div>
                        </li>
                    <?php } else { ?>
                        <li class="right clearfix" data-value="<?= $message->id ?>">
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <small class=" text-muted">
                                        <span
                                            class="glyphicon glyphicon-time"></span><?= Yii::$app->formatter->format($message->date_send,
                                            'relativeTime') ?>
                                    </small>
                                    <strong
                                        class="pull-right primary-font"><?= Html::encode($message->senderInfo->name); ?></strong>
                                </div>
                                <p>
                                    <?= Html::encode($message->message_text); ?>
                                </p>
                            </div>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        <?php } else { ?>
            Chat don't star already
        <?php } ?>
    </div>


    <form action="default/add-message" method="POST" id="add-message-form">
        <div class="panel-footer">
            <div class="input-group">

                <?= Html::hiddenInput('chat_id', ($chat) ? $chat->id : '', ['id' => 'chat-id-field']); ?>
                <?= Html::hiddenInput('user_sender', $current_user); ?>
                <?= Html::hiddenInput('user_receiver', $user_receiver); ?>
                <?= Html::textarea('message', '', [
                    'id' => 'message-text-field',
                    'class' => 'form-control input-sm',
                    'placeholder' => "Type your message here..."
                ]) ?>
                <span class="input-group-btn">
                <?= Html::submitButton('send', [
                    'class' => 'btn btn-warning btn-lg'
                ]) ?>
                </span>
            </div>
        </div>
    </form>
</div>
<?php

use yii\helpers\Html;

?>

<div class="site-index">
    <div class="container-fluid">
        <div class="row row-centered">

            <?php if (Yii::$app->session->getFlash('error')) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= Yii::$app->session->getFlash('error'); ?>
                </div>
            <?php } ?>

            <p class="lead">Enter your name for login or create account.</p>

            <form method="post" class="form-inline" action="">
                <?= Html:: hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken(), []); ?>

                <div class="form-group">
                    <?= Html::input('text', 'name', '', ['class' => 'form-control']) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                </div>
            </form>
        </div>
    </div>
</div>

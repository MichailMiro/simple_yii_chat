<div class="site-index">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-success">
                    <div class="panel-heading">Users</div>
                    <div class="panel-body">
                        <?php if (!empty($users)) { ?>
                            <?php foreach ($users as $one) { ?>
                                <p>
                                    <a href="#" class="open-chat btn btn-default" data-value="<?= $one->id ?>"
                                       href=''><?= $one->name ?></a>
                                </p>
                            <?php } ?>
                        <?php } else { ?>
                            You are the first
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-success">
                    <div class="panel-heading">Chats</div>
                    <div id="chats-block" class="panel-body">
                        <?php if (!empty($chats)) { ?>

                        <?php } else { ?>
                            You don't have any chat
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

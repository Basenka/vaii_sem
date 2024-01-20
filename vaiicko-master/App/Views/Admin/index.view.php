<?php
$layout = 'admin';
/** @var \App\Core\IAuthenticator $auth */ ?>

<div class="content">
    <div class="row">
        <div class="col">
            <div>
                Vitaj, <strong><?= $auth->getLoggedUserName() ?></strong>!<br><br>

            </div>
        </div>
    </div>
</div>
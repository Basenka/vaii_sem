<?php

/** @var \App\Core\LinkGenerator $link */


?>
<div class="content-container">
    <h1>Vaša registrácia prebehla úspešne!</h1>
    <p>Ďakujeme, že ste sa rozhodli stať členom našej komunity.</p>
    <p>Teraz sa môžte prihlásiť <a href=<?= $link->url('auth.login')?>>tu</a>.</p>
</div>
<?php

$layout = 'auth';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<!-- Button na otvorenie modálneho okna -->
<li class="nav-item">
    <a class="nav-link" href="#" id="openLoginModal">Prihlásenie <i class="bi bi-person"></i></a>
</li>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"></script>

<!-- JavaScript kód na otvorenie modálneho okna -->
<script>
    document.getElementById('openLoginModal').addEventListener('click', function () {
        var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
        myModal.show();
    });
</script>

<!-- Modálne okno -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Prihlásenie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-danger mb-3">
                    <?= @$data['message'] ?>
                </div>
                <form method="post" action="<?= $link->url("login") ?>">
                    <div class="form-label-group mb-3">
                        <input name="login" type="text" id="login" class="form-control" placeholder="Login" required autofocus>
                    </div>

                    <div class="form-label-group mb-3">
                        <input name="password" type="password" id="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit" name="submit">Prihlásiť</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"></script>

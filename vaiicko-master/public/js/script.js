document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('openLoginModal').addEventListener('click', function () {
        var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
        myModal.show();
    });
});
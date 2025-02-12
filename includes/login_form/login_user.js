
$(document).ready(function () {
    // Kayıt ve giriş formları arasında geçiş
    $('#showRegisterForm').click(function (e) {
        e.preventDefault();
        $('#loginSection').addClass('d-none');
        $('#registerSection').removeClass('d-none');
    });

    $('#showLoginForm').click(function (e) {
        e.preventDefault();
        $('#registerSection').addClass('d-none');
        $('#loginSection').removeClass('d-none');
    });

    // Giriş formu AJAX işlemi
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'includes/login_form/login.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#loginResult').html(response);
            }
        });
    });

    // Kayıt formu AJAX işlemi
    $('#registerForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'includes/login_form/register_user.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#registerResult').html(response);
            }
        });
    });
});
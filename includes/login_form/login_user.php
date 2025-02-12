<head>
    <link rel="stylesheet" href="includes/login_form/login_user.css">

</head>

<div class="login-container d-flex justify-content-center">
    <!-- Giriş Formu -->
    <div id="loginSection" class="card shadow-lg p-4" style="max-width: 400px; width: 100%; border-radius: 15px;">
        <div class="text-center mb-4">
            <img src="../../logo/user_logo.png" alt="Logo" class="rounded-circle">
            <h3 class="mt-1">Hoş Geldiňiz</h3>
        </div>
        <form id="loginForm">
       
        <div class="col-mb-3" style="padding: 10px 0;">
                <select class="form-control" id="bolum_caryek" name="bolum_caryek" style="margin-bottom:12px;font-size:14px" required>
                <option selected disabled value="">Caryek sayla</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="username" style="font-size: 12; color:#595959;" class="form-label">Ulanyjy ady (ýada telefon belgisi)</label>
                <input type="text" name="username" id="username" class="form-control" 
                    required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Parol</label>
                <input type="password" name="password" id="password" class="form-control" 
                    required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Giriş</button>
            </div>
        </form>

        <div id="loginResult" class="mt-3 text-center text-danger"></div>

        <div class="text-center mt-3">
            <p class="small text-muted">Hasabynyz yok my?
                <a href="#" class="text-primary" id="showRegisterForm">Registrasiýa</a>
            </p>
        </div>
    </div>

    <!-- Kayıt Formu -->
    <div id="registerSection" class="card shadow-lg p-4 d-none"
        style="max-width: 400px; width: 100%; border-radius: 15px;">
        <div class="text-center mb-4">
            <h2 class="mt-3">Registrasiýa</h2>
        </div>
        <form id="registerForm">
            <div class="mb-3">
                <label for="registerUsername" class="form-label">Ulanyjy Ady</label>
                <input type="text" name="username" id="registerUsername" class="form-control open"
                    required >
            </div>

            <div class="mb-3">
                <label for="PhoneNumber" class="form-label">Telefon belgisi</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control"
                  placeholder="65403020"   required>
            </div>

            <div class="mb-3">
                <label for="registerPassword" class="form-label">Parol</label>
                <input type="password" name="password" id="registerPassword" class="form-control"
                    required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">Registrasiya bol</button>
            </div>
        </form>
        <div id="registerResult" class="mt-3 text-center text-danger"></div>
        <div class="text-center mt-3">
            <p class="small text-muted">Hasabyňyz barmy?
                <a href="#" class="text-primary" id="showLoginForm">Giriş</a>
            </p>
        </div>
    </div>
</div>

 <script>
    
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

    $.ajax({
        url: 'includes/caryek_handler.php',
        type: 'POST',
        data: { action: 'fetch' },
        success: function (data) {
            $('#bolum_caryek').html('<option selected disabled value="">Caryek sayla</option>' + data);
        }
    });

    // Giriş formu AJAX işlemi
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();
     
        const selectedText = $('#bolum_caryek').find(':selected').text(); // Text değerini al
alert(selectedText)

        const formData = $(this).serialize() + '&bolum_caryek=' + encodeURIComponent(selectedText);

        $.ajax({
            url: 'includes/login_form/login.php',
            type: 'POST',
            data: formData, //$(this).serialize(),
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
 </script>

 
<!-- <script src="includes/js_files/add_remove_caryek.js"></script> -->
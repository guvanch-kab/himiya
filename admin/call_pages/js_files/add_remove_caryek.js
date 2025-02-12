$(document).ready(function () {

    loadBolumler();

    $('#add_caryek').click(function () {
        const bolum = $('#bolum_input').val();

        if (bolum === "") {
            alert("Bölüm adı boş olamaz!");
            return;
        }       
        $.ajax({
            url: 'call_pages/caryek_handler.php',
            type: 'POST',
            data: { action: 'add', bolum: bolum },
            success: function (response) {
                alert(response); // Sunucudan gelen mesaj
                $('#bolum_input').val(''); // Input alanını temizle
                loadBolumler(); // Listeyi güncelle
            }
        });
    });
    $('#delete_caryek').click(function () {
        const bolum_id = $('#bolum_caryek').val();
        if (!bolum_id) {
            alert("Silmek için bir bölüm seçin!");
            return;
        }
        $.ajax({
            url: 'call_pages/caryek_handler.php',
            type: 'POST',
            data: { action: 'delete', id: bolum_id },
            success: function (response) {
                alert(response); // Sunucudan gelen mesaj
                loadBolumler(); // Listeyi güncelle
            }
        });
    });

    function loadBolumler() {
        $.ajax({
            url: 'call_pages/caryek_handler.php',
            type: 'POST',
            data: { action: 'fetch' },
            success: function (data) {
                $('#bolum_caryek').html('<option selected disabled value="">Caryek sayla</option>' + data);
            }
        });
    }
});

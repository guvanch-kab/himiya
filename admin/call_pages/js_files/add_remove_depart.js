$(document).ready(function () {    

    loadBolumler();

    // Bölüm ekle
    $('#add_bolum').click(function () {
        const bolum = $('#bolum_input').val();
      
        if (bolum === "") {
            alert("Bölüm adı boş olamaz!");
            return;
        }

        $.ajax({
            url: 'call_pages/bolum_handler.php',
            type: 'POST',
            data: { action: 'add', bolum: bolum },
            success: function (response) {
                alert(response); // Sunucudan gelen mesaj
                $('#bolum_input').val(''); // Input alanını temizle
                loadBolumler(); // Listeyi güncelle
            }
        });
    });

    // Bölüm sil
    $('#delete_bolum').click(function () {
        const bolum_id = $('#bolum_select').val();
        if (!bolum_id) {
            alert("Silmek için bir bölüm seçin!");
            return;
        }

        $.ajax({
            url: 'call_pages/bolum_handler.php',
            type: 'POST',
            data: { action: 'delete', id: bolum_id },
            success: function (response) {
                alert(response); // Sunucudan gelen mesaj
                loadBolumler(); // Listeyi güncelle
            }
        });
    });

    // Bölüm listesini yükle
    function loadBolumler() {
        $.ajax({
            url: 'call_pages/bolum_handler.php',
            type: 'POST',
            data: { action: 'fetch' },
            success: function (data) {
                $('#bolum_select').html('<option selected disabled value="">Bölüm sayla</option>' + data);
            }
        });
    }
});

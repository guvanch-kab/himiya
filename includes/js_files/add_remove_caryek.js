$(document).ready(function () {
    //loadBolumler();    

    //function loadBolumler() {
        $.ajax({
            url: 'includes/caryek_handler.php',
            type: 'POST',
            data: { action: 'fetch' },
            success: function (data) {
                $('#bolum_caryek').html('<option selected disabled value="">Caryek sayla</option>' + data);
            }
        });
    //}
});

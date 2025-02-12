$(document).ready(function () {
    $("#add_Product").on("submit", function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var bolum_belgi = $("#bolum_select option:selected").text() || "Bilinmiyor";

        formData.append("bolum_belgi", bolum_belgi);

        $.ajax({
            url: "call_pages/insert_data.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("Response:", response);

                var alertType = response.includes("ustunlikli") ? "success" : "danger";
                var alertMessage = `<div class="alert alert-${alertType}" role="alert">
                                      ${response}
                                    </div>`;
                $("#response").html(alertMessage);

                if (alertType === "success") {
                    // Yeniden veri almak ve col-md-3 kısmını güncellemek
                    $.ajax({
                        url: 'call_pages/fetch_bolum_paragraf.php',
                        type: 'GET',
                        success: function (data) {

                            $('.col-md-3').html(data);
                        }
                    });

                    setTimeout(() => location.reload(), 1000); // Sayfayı yenile
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                $('#response').html(`<div class="alert alert-danger" role="alert">
                                       Bir hata oluştuu: ${errorThrown || 'Bilinmeyen hata'}
                                     </div>`);
            }
        });
    });
});
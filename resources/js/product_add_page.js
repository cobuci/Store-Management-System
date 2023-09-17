$(document).ready(function () {

    $("#category_id").change(function () {
        const url = $('#personForm').attr("data-url");
        let categoria = $(this).val();
        $.ajax({
            url: url,
            data: {
                'categoria': categoria,
            },
            success: function (data) {
                $("#product").html(data);
            }
        });
    });
});



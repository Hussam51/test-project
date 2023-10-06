
    $('.status').on('change', function (e) {

        let id = $(this).data('id');
        $.ajax({
            url: "/users/"+ id,
            method: "post",
            data: {
                status: $(this).val(),
                _token: csrf_token
            },success:Response=>{
                $(`#${id}`).remove();

            }
        });
    });


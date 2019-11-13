$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.Form.Ajax').submit(function () {

        var data = $(this).serialize()
        var url = $(this).attr('action')

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "json",
            success: function (data) {
                console.log(data)
            },
            error: function () {
                alert('Ha ocurrido un error');
            }
        });
        return false;
    })

    $('.Form.Ajax input').change(function() {
        $(this).parents('.Form.Ajax').submit()
    })
})


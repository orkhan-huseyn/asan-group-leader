    $.get("../../config_php/sessioncheck", function (data) {
        if (data === "user") {
            $(".ch").prop("disabled", true);
        }
        else if (data === "admin") {
            //it's admin
        }
    });

    $(document).ready(function () {
        $('#search').keyup(function () {
            var srch = $(this).val();
            var shift = $('#list_shift').val();
            $.post('../../config_php/search', {searchVal: srch, shift: shift}, function (data) {
                $('#tableBody').html(data);
            });
        });
    });
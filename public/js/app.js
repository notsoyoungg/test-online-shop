window.addEventListener('load', function() {

    $(document).on('click', '.add-to-cart', function (e) {
        e.stopPropagation();
        e.preventDefault();

        let url = $(this).data('url');


        if ($(this).data('manufac'))
            $('#select_manufac').val($(this).data('manufac')).change();

        var product_id  = $(this).data("product");
        var _this       = $(this);
        var _url        = $(this).data('url')

        let data = product_id ? $('#stock').serialize() + '&product_id=' + product_id: $('#stock').serialize();

        $('.tree').find('.select').each(function () {
            $(this).removeClass('select');
        });

        $.ajax({
            type: "POST",
            url: _url,
            data: data,
            dataType: 'json',
            success: function (result) {

                $('#pagination').html('');

                if (result.success == 1) {
                    $('.body_stock').html(result.body);
                    $('.card-stock').show();
                    _this.addClass('select');
                    for (let paramId in result.params) {
                        if (result.params.hasOwnProperty(paramId)) {
                            $('#' + paramId).val(result.params[paramId]);
                            if (paramId == 'select_product')
                                $('#' + paramId).change();
                        }
                    }
                } else {
                    Admin.Messages.error("Данных по товару нет", "Внимание");
                    $('.body_stock').html('');
                    $('#product_id').val('');
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                admin_error(xhr, ajaxOptions, thrownError);
            }

        });
    });



})

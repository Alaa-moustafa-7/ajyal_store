
(function($) {
    $('.item-quantity').on('change', function(e) {
        $.ajax({
            url: "/cart/" + $(this).data('id'),
            method: 'PUT',
            data: {
                quantity: $(this).val(),
                _token: csrf_token
            },
            success: function(response) {
                console.log('Cart updated successfully.');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    $('.remove-item').on('click', function(e) {

        let id = $(this).data('id');
        $.ajax({
            url: "/cart/" + id,
            method: 'delete',
            data: {
                _token: csrf_token
            },
            success: response => {
                $(`#${id}`).remove();
            }
        });
    });
})(jQuery);



$(document).ready(function() {
    $(function() {
        $('#customFile').change(function() {
            $('#add_image').prop('disabled', false);
        });

        // if ($('.add_photos_tab').hasClass('active')) {
        //     console.log('rrr');
        //     $('#createproductandaddimages').show();
        // } else {
        //     $('#createproductandaddimages').hide(0);
        // }
        $('#product').bind('input', function() {
            let value = $('#product').val();
            if (value.length > 0) {
                $('#createproductandaddimages').show();
            } else {
                $('#createproductandaddimages').hide(0);
            }
        });
        // console.log($('#createproduct #product').val());




        $('#add_image---2').click(function(e) {
            console.log($('#upload_product_image').serialize());
            e.preventDefault();
            $.ajax({
                url: '/admin/productimg',
                type: "POST",
                data: $('#upload_product_image').serialize(),
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    alert('Отлично');
                    // $('#addArticle').modal('hide');
                    // $('#articles-wrap').removeClass('hidden').addClass('show');
                    // $('.alert').removeClass('show').addClass('hidden');
                    // var str = '<tr><td>' + data['id'] +
                    //     '</td><td><a href="/article/' + data['id'] + '">' + data['title'] + '</a>' +
                    //     '</td><td><a href="/article/' + data['id'] + '" class="delete" data-delete="' + data['id'] + '">Удалить</a></td></tr>';

                    //$('.table > tbody:last').append(str);
                },
                error: function(msg) {
                    alert(msg);
                }
            });
        });
    });
});
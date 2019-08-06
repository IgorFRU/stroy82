$(document).ready(function() {
    $(function() {
        $('#createproductandaddimages').click(function() {
            // console.log($('input[name="product"]').val());
            // console.log($('#createproduct').serialize());
            $.ajax({
                url: '/admin/products/store/ajax',
                type: "POST",
                // data: $('#createproduct').serialize(),
                data: {
                    product: $('input[name="product"]').val(),
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    alert('OK !!!');
                    // window.location.href = '/admin/products/addImages';
                    // $('#addArticle').modal('hide');
                    // $('#articles-wrap').removeClass('hidden').addClass('show');
                    // $('.alert').removeClass('show').addClass('hidden');
                    // var str = '<tr><td>' + data['id'] +
                    //     '</td><td><a href="/article/' + data['id'] + '">' + data['title'] + '</a>' +
                    //     '</td><td><a href="/article/' + data['id'] + '" class="delete" data-delete="' + data['id'] + '">Удалить</a></td></tr>';

                    //$('.table > tbody:last').append(str);
                },
                error: function(msg) {
                    alert('Ошибка !!!');
                }
            });
        });
    });
});
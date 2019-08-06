$(document).ready(function() {
    $(function() {
        $('#save').click(function() {
            var title = $('#title').val();
            var text = $('#text').val();
            $.ajax({
                url: '/admin/productimg',
                type: "POST",
                data: {
                    file: image,
                    name: name,
                    alt: alt,
                    product_id: product_id
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // $('#addArticle').modal('hide');
                    // $('#articles-wrap').removeClass('hidden').addClass('show');
                    // $('.alert').removeClass('show').addClass('hidden');
                    // var str = '<tr><td>' + data['id'] +
                    //     '</td><td><a href="/article/' + data['id'] + '">' + data['title'] + '</a>' +
                    //     '</td><td><a href="/article/' + data['id'] + '" class="delete" data-delete="' + data['id'] + '">Удалить</a></td></tr>';

                    //$('.table > tbody:last').append(str);
                },
                error: function(msg) {
                    alert('Ошибка');
                }
            });
        });
    });
});
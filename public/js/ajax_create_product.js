$(document).ready(function() {
    $(function() {
        $('#createproductandaddimages').click(function(e) {
            e.preventDefault();
            // console.log($('input[name="product"]').val());
            // console.log($('#createproduct').serialize());
            // var form = $('#createproduct');
            // // console.log(form);
            // var data = new FormData($('#createproduct')[0]);
            // console.log(form.attr('method'));
            // console.log($('#createproduct').serialize());
            $.ajax({
                url: '/admin/products/store/ajax',
                type: "POST",
                data: $('#createproduct').serialize(),
                // data: {
                //     scu: $('input[name="scu"]').val(),
                //     product: $('input[name="product"]').val(),
                //     addImage: 'true',
                // },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    alert('OK !!!');
                    var response = $.parseJSON(data)
                    console.log(response.id);
                    window.location.href = '/admin/products/addImages/' + response.id;
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
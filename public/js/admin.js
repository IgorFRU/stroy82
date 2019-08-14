$(function() {
    $('.js-example-basic-multiple').select2();

    $('nav.tabs > span').on('click', function() {
        // console.log($(this).data('tab'));
        // const attr = $(this).data('tab');
        var currentTabData = $('nav.tabs > span.active').data('tab');

        if (currentTabData != $(this).data('tab')) {
            $('nav.tabs > span.active').removeClass('active');
            $(this).addClass('active');
            var currentTabData = $('nav.tabs > span.active').data('tab');

            $('div.tab_item').removeClass('active');
            $('div#' + $(this).data('tab')).addClass('active');
        }
        // $('div#' + $(this).data('tab')).removeClass('active');
        // $('div#' + $(this).data('tab')).addClass('active');
    });

    const js_oneclick = document.querySelectorAll('.js_oneclick');
    // Скрытое поле, отправляющее Value = 0, если чекбокс не отмечен
    const js_oneclick_hidden = document.querySelectorAll('.js_oneclick_hidden');

    // Функция, в одно касание меняющая value в чекбоксах
    js_oneclick.forEach(function(checbox, i) {
        checbox.addEventListener('click', () => {
            checbox.value = +checbox.checked;
            js_oneclick_hidden[i].value = checbox.value;
        });
    });

    // в карточке добавления / редактирования товара показ или скрытие большой кнопки "добавить изображения"
    $('#createproductandaddimages').hide(0);
    $('#product').bind('input', function() {
        let value = $('#product').val();
        if (value.length > 3) {
            $('#createproductandaddimages').show();
        } else {
            $('#createproductandaddimages').hide(0);
        }
    });

    //живой поиск для добавления товара к статье
    $('#articleAddProductSearch').bind('input', function() {
        let value = $('#articleAddProductSearch').val();
        let dataArticle = $('input#article_id').val();
        if (value.length > 3) {
            $.ajax({
                type: "POST",
                url: "/admin/products/search/ajax",
                // dataType: 'json',
                data: {
                    product: value,
                    article: dataArticle
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var response = $.parseJSON(data);

                    $("#articleAddProductSearchResult").empty();
                    if (response[0] == 'Ничего не найдено') {
                        // console.log(response[0]);
                        $("#articleAddProductSearchResult").append("<div>" + response[0] + "</div>");
                    } else if (response.length > 0) {
                        $("#articleAddProductSearchResult").append("<table class='table'><thead> <tr><th scope = 'col' > id </th><th scope = 'col' > Название </th> <th scope = 'col' > Цена (базовая)</th></tr></thead><tbody > ");
                        response.forEach(element => {
                            // console.log(element.id);
                            // $("#articleAddProductSearchResult").append("<div data-id=" + element.id + ">" + element.product + ' ' + element.price + "</div>");
                            $("#articleAddProductSearchResult > table").append("<tr><th scope='row'><span data-product_id=" + element.id + "><i class='fas fa-plus-square'></i></span> " + element.id + "</th><td><a href='#' blank>" + element.product + "</a></td><td >" + element.price + "</td></td></tr >");
                        });
                        $("#articleAddProductSearchResult > table").append("</tbody></table>");
                        // $('#articleAddProductButton').prop('disabled', false);

                        $("span").on('click', function(e) {
                            $(".hidden_inputs").append("<input type='hidden' name='product_id' value=" + e.target.parentNode.getAttribute('data-product_id') + ">");
                            e.target.parentNode.parentNode.parentNode.remove();

                            $('#articleAddProductButton').prop('disabled', false);
                        });
                    }
                },
                error: function(msg) {
                    console.log(msg);
                }
            });
        }
    });

    $('#articleAddProductByCategory').bind('input', function() {
        let value = $('#articleAddProductByCategory').val();
        let article = $('#article_id').val();
        if (value > 0) {
            $.ajax({
                type: "POST",
                url: "/admin/products/search/ajax",
                // dataType: 'json',
                data: {
                    category: value,
                    article: article
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var response = $.parseJSON(data);
                    // console.log(response);

                    $("#articleAddProductSearchResult").empty();
                    $("#articleAddProductByCategoryShow").empty();
                    $("#articleAddProductByCategoryShow").append("<option selected value='0'>Выберите товар...</option>");
                    if (response[0] == 'Ничего не найдено') {
                        // console.log(response[0]);
                        $("#articleAddProductSearchResult").append("<div>" + response[0] + "</div>");
                    } else if (response.length > 0) {
                        response.forEach(element => {
                            // $("#articleAddProductSearchResult").append("<div data-id=" + element.id + ">" + element.product + ' ' + element.price + "</div>");
                            $("#articleAddProductByCategoryShow").append("<option data-product='" + element.product + " - " + element.price + "' value=" + element.id + ">" + element.product + " - " + element.price + "</option>");
                        });
                    }
                },
                error: function(msg) {
                    console.log(msg);
                }
            });
        }
    });

    $('#articleAddProductByCategoryShow').on('change', function() {
        let product = $('#articleAddProductByCategoryShow').val();
        let productData = $(this).find(':selected').attr('data-product');
        if (product > 0) {
            $(".hidden_inputs").append("<input type='hidden' name='product_id[]' value=" + product + ">");
            $('#articleAddProductResult').append("<button type='button' data-product-id='" + product + "' class='btn btn-success'><a href='#'><i class='fas fa-external-link-square-alt'></i></a> id: " + product + " | " + productData + " руб. <span class='articleAddProductResultRemove'><i class='fas fa-window-close'></i></span></button>");
            $('#articleAddProductByCategoryShow option:selected').remove();
        }
    });

    $('#articleAddProductButtonClose').on('click', function(e) {
        if ($('#articleAddProductButtonClose').prop('data-changed')) {
            // window.location.href = '/admin/articles/'+ $('input#article_id').val() +'/edit';
        }
    });

    $('.articleAddProductResultRemove').on('click', function() {
        let button = $(this).parent();
        let id = button.attr('data-product-id');
        if (button.hasClass('btn-secondary')) {
            button.removeClass('btn-secondary');
            button.addClass('btn-danger');

            $(".hidden_inputs").find("input[value = " + id + "]").attr('name', 'del');
        } else {
            button.removeClass('btn-danger');
            button.addClass('btn-secondary');

            $(".hidden_inputs").find("input[value = " + id + "]").attr('name', 'product_id[]');
        }
    });
});
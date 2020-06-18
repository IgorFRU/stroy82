$(function() {
    var phone_masks = document.getElementsByClassName('phone-mask');

    Array.prototype.forEach.call(phone_masks, function(element) {
        var phoneMask = new IMask(element, {
            mask: '{8}(000)000-00-00',
            placeholder: {
                show: 'always'
            }
        });
    });

    // добавление класса active к верхним пунктам меню (родительским)
    var navItems = $('.nav-item.dropdown').find('a.active');
    navItems.parent().parent().addClass('active');

    $('nav.tabs > span').on('click', function() {
        var currentTabData = $('nav.tabs > span.active').data('tab');

        if (currentTabData != $(this).data('tab')) {
            $('nav.tabs > span.active').removeClass('active');
            $(this).addClass('active');
            var currentTabData = $('nav.tabs > span.active').data('tab');

            $('div.tab_item').removeClass('active');
            $('div#' + $(this).data('tab')).addClass('active');
        }
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
    // $('#ajaxAddProductSearch').bind('input', function() {
    //     let value = $('#ajaxAddProductSearch').val();
    //     let dataObject = $('input#article_id').val();
    //     if (value.length > 3) {
    //         $.ajax({
    //             type: "POST",
    //             url: "/admin/products/search/ajax",
    //             data: {
    //                 product: value,
    //                 object: dataObject
    //             },
    //             headers: {
    //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             success: function(data) {
    //                 var response = $.parseJSON(data);

    //                 $("#ajaxAddProductSearchResult").empty();
    //                 if (response[0] == 'Ничего не найдено') {
    //                     $("#ajaxAddProductSearchResult").append("<div>" + response[0] + "</div>");
    //                 } else if (response.length > 0) {
    //                     $("#ajaxAddProductSearchResult").append("<table class='table'><thead> <tr><th scope = 'col' > id </th><th scope = 'col' > Название </th> <th scope = 'col' > Цена (базовая)</th></tr></thead><tbody > ");
    //                     response.forEach(element => {
    //                         $("#ajaxAddProductSearchResult > table").append("<tr><th scope='row'><span data-product_id=" + element.id + "><i class='fas fa-plus-square'></i></span> " + element.id + "</th><td><a href='#' blank>" + element.product + "</a></td><td >" + element.price + "</td></td></tr >");
    //                     });
    //                     $("#ajaxAddProductSearchResult > table").append("</tbody></table>");

    //                     $("span").on('click', function(e) {
    //                         $(".hidden_inputs").append("<input type='hidden' name='product_id' value=" + e.target.parentNode.getAttribute('data-product_id') + ">");
    //                         e.target.parentNode.parentNode.parentNode.remove();

    //                         $('#ajaxAddProductButton').prop('disabled', false);
    //                     });
    //                 }
    //             },
    //             error: function(msg) {
    //                 console.log(msg);
    //             }
    //         });
    //     }
    // });

    $('#ajaxAddProductByCategory').bind('input', function() {
        let value = $('#ajaxAddProductByCategory').val();
        let object = $('#object_id').val();
        let objectType = $('#object_id').attr('data-object');
        console.log(objectType);
        if (value > 0) {
            $.ajax({
                type: "POST",
                url: "/admin/products/search/ajax",
                data: {
                    category: value,
                    object: object,
                    objectType: objectType
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var response = $.parseJSON(data);

                    $("#ajaxAddProductSearchResult").empty();
                    $("#ajaxAddProductByCategoryShow").empty();
                    $("#ajaxAddProductByCategoryShow").append("<option selected value='0'>Выберите товар...</option>");
                    if (response[0] == 'Ничего не найдено') {
                        $("#ajaxAddProductSearchResult").append("<div>" + response[0] + "</div>");
                    } else if (response.length > 0) {
                        response.forEach(element => {
                            $("#ajaxAddProductByCategoryShow").append("<option data-product='" + element.product + " - " + element.price + "' value=" + element.id + ">" + element.product + " - " + element.price + "</option>");
                        });
                    }
                },
                error: function(msg) {
                    console.log(msg);
                }
            });
        }
    });

    // при выборе товара из выпадающего списка
    $('#ajaxAddProductByCategoryShow').on('change', function() {
        var product = $('#ajaxAddProductByCategoryShow').val();
        var productData = $(this).find(':selected').attr('data-product');
        if (product > 0) {
            $(".hidden_inputs").append("<input type='hidden' name='product_id[]' value=" + product + ">");
            // $('#ajaxAddProductResult').append("<button type='button' data-product-id='" + product + "' class='btn btn-success'><a href='#'><i class='fas fa-external-link-square-alt'></i></a> id: " + product + " | " + productData + " руб. <span class='ajaxAddProductResultRemove'><i class='fas fa-window-close'></i></span></button>");
            $('#ajaxAddProductResult').append("<button type='button' data-product-id='" + product + "' class='btn btn-success'><a href='#'><i class='fas fa-external-link-square-alt'></i></a> id: " + product + " | " + productData + " руб. </button>");
            $('#ajaxAddProductByCategoryShow option:selected').remove();
        }
    });

    $('#ajaxAddProductButtonClose').on('click', function(e) {
        if ($('#ajaxAddProductButtonClose').prop('data-changed')) {}
    });

    $('.ajaxAddProductResultRemove').on('click', function() {
        let button = $(this).parent();
        let id = button.attr('data-product-id');
        if (button.hasClass('btn-secondary')) {
            button.removeClass('btn-secondary');
            button.addClass('btn-danger');

            $(".hidden_inputs").find("input[value = " + id + "]").attr('name', 'del');
            // console.log($(".hidden_inputs").find("input[value = " + id + "]").attr('name'));
        } else {
            button.removeClass('btn-danger');
            button.addClass('btn-secondary');

            $(".hidden_inputs").find("input[value = " + id + "]").attr('name', 'product_id[]');
        }
    });

    // AJAX загрузка изображений для создаваемого товара
    $('#productImage').bind('input', function() {
        $('#add_image').prop('disabled', false);
        $('#add_image').attr('data-method', 'store');
    });

    $('#add_image').on('click', function(e) {
        e.preventDefault();
        var method = $('#add_image').attr('data-method');
        if (method == 'store') {
            var filename = $('#filename').val();
            var alt = $('#alt').val();
            var formData = new FormData();

            formData.append('name', filename);
            formData.append('alt', alt);
            formData.append('path', 'product');
            formData.append('method', method);
            formData.append('image', $("#productImage").prop("files")[0]);

            console.log(FormData);
        } else if (method == 'update') {
            var filename = $('#filename').val();
            var alt = $('#alt').val();
            var image_id = $('#add_image').attr('data-id');
            var formData = new FormData();

            formData.append('method', method);
            formData.append('name', filename);
            formData.append('alt', alt);
            formData.append('id', image_id);
            formData.append('path', 'product');
        }

        $.ajax({
            type: "POST",
            url: '/admin/uploadimg',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var data = $.parseJSON(data);
                var image_id = $('#add_image').attr('data-id');
                // console.log(data.id);
                // console.log(image_id);
                if (typeof(data.id) != "undefined" && data.id !== null && data.id != image_id) {
                    $('#add_image').prop('disabled', true);
                    $("#productImage").val("");
                    $(".hidden_inputs").append("<input type='hidden' name='image_id[]' value=" + data.id + "> ");
                    $('#ajaxUploadedImages').append("<img class='col-lg-2 bg-success rounded img-fluid img-thumbnail' data-id='" + data.id + "' data-name='" + data.name + " data-alt='" + data.alt + "' src='/imgs/products/thumbnails/" + data.thumbnail + "'>");
                } else if (typeof(data.id) != "undefined" && data.id !== null && data.id == image_id) {
                    var img = $("#ajaxUploadedImages").find("[data-id='" + data.id + "']");
                    img.attr('data-name', data.name);
                    img.attr('data-alt', data.alt);
                    $('#add_image').attr('data-id', '');
                    $('#add_image').prop('disabled', true);
                    img.removeClass('bg-warning');
                }
            },
            error: function(errResponse) {
                console.log(errResponse);
            }
        });
    });

    $('#add_image_delete').on('click', function() {
        var image_id = $('#add_image').attr('data-id');
        var method = 'delete';
        var formData = new FormData();

        formData.append('method', method);
        formData.append('image_id', image_id);

        $.ajax({
            type: "POST",
            url: '/admin/uploadimg',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var data = $.parseJSON(data);
                console.log(data);
                var image_id = $('#add_image').attr('data-id');
                $('#add_image').attr('data-id', '');
                $('#add_image').prop('disabled', true);
                $('#add_image_delete').addClass('disabled');

                var element = $("#ajaxUploadedImages img[data-id='" + data.id + "']").parent();
                element.remove();

            },
            error: function(errResponse) {
                console.log(errResponse);
            }
        });
    });

    // управление фотографиями, загруженными для товара

    $('#ajaxUploadedImages > div').on('click', function() {
        // console.log($(this).find('img'));
        let img = $(this).find('img');
        let id = img.attr('data-id');
        let name = img.attr('data-name');
        let alt = img.attr('data-alt');

        $('#filename').val(name);
        $('#alt').val(alt);
        $('#add_image').attr('data-id', id);

        let allImages = $('#ajaxUploadedImages > div > img');
        allImages.each(function(i, elem) {
            $(elem).removeClass('bg-warning');
        });

        img.addClass('bg-warning');
        $('#add_image').prop('disabled', false);
        $('#add_image').attr('data-method', 'update');
        $('#add_image_delete').removeClass('disabled');
    });

    // управление характеристиками товаров
    // в категориях

    $('#property').bind('input', function() {
        var property = $('#property').val();
        if (property.length < 3) {
            $('#propertyAddButton').addClass('disabled');
        } else {
            $('#propertyAddButton').removeClass('disabled');
        }
    });

    $('#property_id').bind('input', function() {
        var property = $('#property_id').val();
        if (property != 0) {
            $('#propertyAddButton0').removeClass('disabled');
        } else {
            $('#propertyAddButton0').addClass('disabled');
        }
    });

    $('#propertyAddButton').on('click', function() {
        var property = $('#property').val();
        var slug = '';
        if (property.length > 3) {
            $.ajax({
                type: "POST",
                url: "/admin/properties/store",
                data: {
                    property: property,
                    slug: slug
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var data = $.parseJSON(data);
                    console.log(data);
                    $('#property').val('');
                    var property_id = data.id;
                    var property = data.property;
                    $('#propertyAddButton').addClass('disabled');
                    $(".hidden_inputs").append("<input type='hidden' name='property_id[]' value=" + property_id + ">");
                    // $('#categoryAddPropertyResult').append("<button type='button' data-property-id='" + property_id + "' class='btn btn-success'>" + property + " <span class='categoryPropertyItemRemove' title='Открепить от категории'><i class='fas fa-window-close'></i></span><span class='categoryPropertyItemTrash rounded' title='Удалить навсегда'><i class='fas fa-trash'></i></span></button>");
                    $('#categoryAddPropertyResult').append("<button type='button' data-property-id='" + property_id + "' class='btn btn-success'>" + property + " </button>");
                },
                error: function(errResponse) {
                    console.log(errResponse);
                }
            });
        }
    });

    $('#propertyAddButton0').on('click', function() {
        var property_id = $('#property_id').val();
        var property = $('#property_id').find(':selected').attr('data-property');
        console.log(property_id);
        console.log(property);
        var slug = '';
        if (property_id != 0) {
            $.ajax({
                type: "POST",
                url: "/admin/properties/store",
                data: {
                    property: property,
                    property_id: property_id,
                    slug: slug
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var data = $.parseJSON(data);
                    console.log(data);
                    $('#property_id').val(0);
                    var property_id = data.id;
                    var property = data.property;
                    $('#propertyAddButton0').addClass('disabled');
                    $(".hidden_inputs").append("<input type='hidden' name='property_id[]' value=" + property_id + ">");
                    // $('#categoryAddPropertyResult').append("<button type='button' data-property-id='" + property_id + "' class='btn btn-success'>" + property + " <span class='categoryPropertyItemRemove' title='Открепить от категории'><i class='fas fa-window-close'></i></span><span class='categoryPropertyItemTrash rounded-right' title='Удалить навсегда'  data-toggle='modal' data-target='.confirm-to-trash-property'><i class='fas fa-trash'></i></span></button>");
                    $('#categoryAddPropertyResult').append("<button type='button' data-property-id='" + property_id + "' class='btn btn-success'>" + property + " </button>");
                    $('select#property_id option[value="' + property_id + '"]').remove();
                },
                error: function(errResponse) {
                    console.log(errResponse);
                }
            });
        } else {
            $('#propertyAddButton0').addClass('disabled');
        }
    });
    $('span.categoryPropertyItemRemove').on('click', function() {
        let button = $(this).parent();
        let id = button.attr('data-property-id');
        if (button.hasClass('btn-secondary')) {
            button.removeClass('btn-secondary');
            button.addClass('btn-danger');

            $(".hidden_inputs").find("input[value = " + id + "]").attr('name', 'del');
        } else {
            button.removeClass('btn-danger');
            button.addClass('btn-secondary');

            $(".hidden_inputs").find("input[value = " + id + "]").attr('name', 'property_id[]');
        }
    });

    $('span.categoryPropertyItemTrash').on('click', function() {
        var property = $(this).parent();
        var property_id = property.attr('data-property-id');
        var category_id = $('#category_id-2').val();
        $('.confirm-to-trash-property-cancel').on('click', function() {
            property_id = 0;
            category_id = 0;
        });
        $('.confirm-to-trash-property-ok').on('click', function() {
            $.ajax({
                type: "POST",
                url: "/admin/properties/destroy",
                data: {
                    property_id: property_id,
                    category_id: category_id
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var data = $.parseJSON(data);
                    $('#confirmModal').modal('hide');
                    //если удалось удалить характеристику
                    if (data == 0) {
                        alert('Не удалось удалить характеристику!');
                    } else {
                        property.remove();
                        $(".hidden_inputs").find("input[value = " + property_id + "]").remove();
                    }
                },
                error: function(errResponse) {
                    console.log(errResponse);
                }
            });
        });
    });

    // На старанице всех товаров фильтр по категориям и производителям
    $('#index_category_id').bind('input', function() {
        let category = $(this).val();
        $.ajax({
            type: "POST",
            url: "/admin/setcookie",
            data: {
                adm_category_show: category
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                location.reload(true);
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    });
    $('#index_manufacture_id').bind('input', function() {
        var manufacture = $(this).val();
        $.ajax({
            type: "POST",
            url: "/admin/setcookie",
            data: {
                adm_manufacture_show: manufacture
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                location.reload(true);
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    });
    $('#items_per_page').bind('input', function() {
        var items_per_page = $(this).val();
        $.ajax({
            type: "POST",
            url: "/admin/setcookie",
            data: {
                adm_items_per_page: items_per_page
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                location.reload(true);
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    });
    $('#show_published').bind('input', function() {
        var show_published = $(this).val();
        $.ajax({
            type: "POST",
            url: "/admin/setcookie",
            data: {
                adm_show_published: show_published
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                location.reload(true);
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    });


    $('#packaging').change(function() {
        if (this.checked) {
            $('#unit_in_package').prop('required', true);
            $('#unit_id').prop('required', true);
        } else {
            $('#unit_in_package').prop('required', false);
        }

    });

    // function ProfitCalcMain() {
    //     console.log(this.value);
    // }

    $('#profit_type').on('change', ProfitButton);
    $('#incomin_price').on('keyup', ProfitButton);
    $('#profit').on('keyup', ProfitButton);
    $('input[name="profit_type2"]').on('change', ProfitButton);

    $('.profit_calc').on('click', function() {
        if (!$(this).hasClass('disabled')) {
            let incomin_price = parseFloat($('#incomin_price').val());
            let profit = parseFloat($('#profit').val());
            let profit_type = $('#profit_type').val();

            if (document.getElementById('profit_type2_minus').checked) {
                ProfitCalcMain('-', incomin_price, profit, profit_type);
            } else if (document.getElementById('profit_type2_plus').checked) {
                ProfitCalcMain('+', incomin_price, profit, profit_type);
            }

            $('.profit_calc_result').removeClass('hide');
        }

    });

    function ProfitButton(e) {
        if ($(this).val() != '') {
            let incomin_price = $('#incomin_price').val();
            let profit = $('#profit').val();
            if ($('#profit_type').val() != '' && incomin_price != '' && profit != '') {
                $('.profit_calc').removeClass('disabled');
            } else {
                $('.profit_calc').addClass('disabled');
            }
        } else {
            $('.profit_calc').addClass('disabled');
        }
    }

    function ProfitCalcMain(type, incomin_price, profit, profit_type) {
        let new_price = 0;
        let profit_calc_result = $('.profit_calc_result');

        if (profit_type == '%') {
            if (type == '-') {
                new_price = Math.round(((100 * incomin_price) / (100 - profit)) * 100) / 100;
                //100*incom/(100-profit)
            } else {
                new_price = Math.round((incomin_price + (incomin_price * profit) / 100) * 100) / 100;
            }
        } else {

            new_price = Math.round((incomin_price + profit) * 100) / 100;
        }
        profit_calc_result.text(new_price);
        profit_calc_result.removeClass('disabled');
        console.log(new_price);
    }

    $('.profit_calc_result').on('click', function() {
        if (!$(this).hasClass('disabled')) {
            let old_price = $('#price').val();
            $('#price').val($(this).text());
            $('.final_product_price_backup').removeClass('hide');
            $('.final_product_price_backup > div').text(old_price);
        }
    });

    $('.final_product_price_backup > div').on('click', function() {
        if (!$(this).hasClass('hide')) {
            $('#price').val($(this).text());
        }
    });

    //Изменение статуса заказа
    $('.order_change_status').bind('input', function() {
        let button = $('.order_change_status_button');
        button.removeClass('disabled');
    });

    $('.order_change_payment_status').bind('input', function() {
        let button = $('.order_change_status_button');
        button.removeClass('disabled');
    });

    $('input[name="order_change_complete"]').on('change', function() {
        let button = $('.order_change_status_button');
        button.removeClass('disabled');
    });

    $('.order_change_status_button').on('click', function() {
        if (!$(this).hasClass('disabled')) {
            let order_change_complete = $('input[name="order_change_complete"]:checked').val();
            let order_change_status = $('.order_change_status').val();
            let order_change_payment_status = $('.order_change_payment_status').val();
            let order_id = $(this).attr('data-order-id');

            $('#change_order_status').modal('hide');
            $.ajax({
                type: "POST",
                url: "/admin/orders/changestatus",
                data: {
                    order_change_complete: order_change_complete,
                    order_change_status: order_change_status,
                    order_change_payment_status: order_change_payment_status,
                    order_id: order_id
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log('success');
                    var data = $.parseJSON(data);
                    if (data == 'success') {
                        location.reload(true);
                    }
                },
                error: function(msg) {
                    console.log(msg);
                }
            });
        }
    });

    //при изменении категории в форме добавления/редактирования товара подгружаются характеристики из этой категории
    $('#category_id').bind('input', function() {

        let import_flag = false;
        if ($(this).data('import') == true) {
            import_flag = true;
        }

        $.ajax({
            type: "POST",
            url: "/admin/products/getcategoryproperties",
            data: {
                category_id: $(this).val()
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                var data = $.parseJSON(data);
                if (import_flag) {
                    // copy()
                    let to_insert = $('.import_products_properties');
                    to_insert.empty();
                    if (data.length > 0) {
                        data.forEach(element => {
                            to_insert.append("<div class='col-md-3 mb-3'><label for='" + element.id + "'>" + element.property + "</label><input type='text' class='form-control check_numeric' data-success_check='success_check' id='" + element.property + "' name='property_values[" + element.id + "]' pattern='^[ 0-9]+$'><div class='invalid-feedback'>Тут должно быть число!</div></div>");
                        });
                    } else {
                        to_insert.append("<div class='alert alert-warning'>Вы еще не добавили ни одной характеристики для данной категории!</div>");
                    }
                } else {
                    let to_insert = $('#properties div');
                    to_insert.empty();
                    if (data.length > 0) {
                        data.forEach(element => {
                            to_insert.append("<div class='form-group row'><label for='" + element.id + "' class='col-sm-2 col-form-label'>" + element.property + "</label><div class='col-md-4'><input type='text' name='property_values[" + element.id + "]' class='form-control' id='" + element.property + "' value=''></div></div>");
                        });
                    } else {
                        to_insert.append("<div class='alert alert-warning'>Вы еще не добавили ни одной характеристики для данной категории!</div>");
                    }
                }
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    });

    $('.js_date_today').text(formatDate(new Date()));

    function formatDate(date) {
        var monthNames = [
            "01", "02", "03",
            "04", "05", "06", "07",
            "08", "09", "10",
            "11", "12"
        ];

        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();

        return day + '.' + monthNames[monthIndex] + '.' + year;
    }

    $('.product_id').bind('input', function() {
        let product_checked = $('.product_id');

        let product_checked_ids = [];
        product_checked.each(function(i, elem) {
            if ($(elem).prop('checked')) {
                product_checked_ids.push($(elem).val());
            }
        });
        if (product_checked_ids.length > 0) {
            $('.product_group_copy').removeClass('disabled');
            $('.product_group_published').removeClass('disabled');
            $('.product_group_unimported').removeClass('disabled');
            $('.product_group_delete').removeClass('disabled');
            $('.product_group_delete').prop('disabled', false);
        } else {
            if (!$('.product_group_copy').hasClass('disabled')) {
                $('.product_group_copy').addClass('disabled');
                $('.product_group_published').addClass('disabled');
                $('.product_group_unimported').addClass('disabled');
                $('.product_group_delete').addClass('disabled');
                $('.product_group_delete').prop('disabled', true);
            }
        }
        $('.hidden_inputs').empty();
        for (let i = 0; i < product_checked_ids.length; i++) {
            $(".hidden_inputs").append("<input type='hidden' name='product_group_ids[]' value=" + product_checked_ids[i] + ">");
        }
    });

    // import - check numeric

    $('.check_numeric').on('keyup', function() {
        let button = $(this).data('success_check');
        if ($.isNumeric($(this).val()) || $(this).val() == '') {
            $('.' + button).attr('disabled', false);
            $(this).parent().find('.invalid-feedback').hide();
            $(this).addClass(' is-valid').removeClass('is-invalid');
        } else {
            $('.' + button).attr('disabled', true);
            $(this).parent().find('.invalid-feedback').show();
            $(this).addClass(' is-invalid').removeClass('is-valid');
        }
    });

    $('.check_not_empty').on('keyup', function() {
        let button = $(this).data('success_check');
        if ($(this).val() != '') {
            $('.' + button).attr('disabled', false).removeClass('disabled');
            $(this).parent().find('.invalid-feedback').hide();
            $(this).addClass(' is-valid').removeClass('is-invalid');
        } else {
            $('.' + button).attr('disabled', true);
            $(this).parent().find('.invalid-feedback').show();
            $(this).addClass(' is-invalid').removeClass('is-valid');
        }
    });

    $('.step_button').on('click', function() {
        let parent_block = $(this).parent();
        if ($(this).data('next')) {
            $('.product_options_steps_title span').text('(шаг ' + parent_block.next().data('step') + ')')
            parent_block.removeClass('active');
            parent_block.next().addClass('active');
        } else if ($(this).data('next') == 0) {
            $('.product_options_steps_title span').text('(шаг ' + parent_block.prev().data('step') + ')')
            parent_block.removeClass('active');
            parent_block.prev().addClass('active');
        }
    });

    $('.options_step #typeoption_id').on('change', function() {
        if ($(this).val() == 'new') {
            $('#typeoption_id_new').show();
        } else {
            $('#typeoption_id_new').hide();
        }
    });

    $('input[id="typeoption_id_add"]').on('keyup', function() {
        let data = $(this);
        let unique = false;
        let currents = $('select[name="typeoption_id"] option');
        currents.each(function() {
            if (($(this).val() != 0 || $(this).val() != 'new') && data.val().toLowerCase() == $(this).text().toLowerCase()) {
                unique = false;
                return false;
            }
            unique = true;
        });
        if (unique) {
            $('button.typeoption_id_new_button').removeClass('disabled').attr('disabled', false);
        } else {
            $('button.typeoption_id_new_button').addClass('disabled').attr('disabled', true);
        }
    });

    $('button.typeoption_id_new_button').on('click', function() {
        $.ajax({
            type: "POST",
            url: "/admin/typeoptions",
            data: {
                type: $(this).parent().find('input[id="typeoption_id_add"]').val(),
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                let select = $('select[name="typeoption_id"]');
                select.append('<option value="' + data.id + '">' + data.name + '</option>');
                select.val(data.id);
                $('#typeoption_id_new').hide();
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    });
});
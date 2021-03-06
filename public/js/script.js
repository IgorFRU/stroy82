$(function() {

    () => {
        if (window.matchMedia("(max-device-width: 480px)").matches) {
            console.log('ojfifkf');
            $('.categories_bar__toggle').removeClass('active');
        }
    }

    var categoriesBarToggle = function() {
        var ww = document.body.clientWidth;
        if (ww <= 990) {
            $('.categories_bar__toggle').removeClass('active');
            $('.categories_bar .button__toggle').removeClass('active');
        } else if (ww >= 991) {
            $('.categories_bar__toggle').addClass('active');
            $('.categories_bar .button__toggle').addClass('active');
        };
    };
    $(window).resize(function() {
        categoriesBarToggle();
    });
    categoriesBarToggle();

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    var phone_masks = document.getElementsByClassName('phone-mask');

    Array.prototype.forEach.call(phone_masks, function(element) {
        var phoneMask = new IMask(element, {
            mask: '{8}(000)000-00-00',
            placeholder: {
                show: 'always'
            }
        });
    });

    //change quantity in cart
    var cartProductQuantity = $('.cart_table__item_quantity');
    // console.log(cartProductQuantity);

    $.each(cartProductQuantity, function(key, value) {
        var minus = $(this).find('.cart_table__item_quantity_minus');
        var plus = $(this).find('.cart_table__item_quantity_plus');
        var button = $(this).find('.product__inpunt_accept');
        var quantity = $(this).find('.cart__product__input_units');
        // var accept_button = $(this).find('.product__inpunt_accept');
        var id = $(this).attr('data-id');

        // console.log(id);
        // console.log(accept_button);
        var oldQuantity = parseFloat(quantity.val().replace(",", "."));
        var newQuantity = oldQuantity;
        var package = parseFloat(quantity.attr('data-package').replace(",", "."));
        // var iterMinus = 0;
        minus.click(function() {
            if (newQuantity - package > 0.001) {
                newQuantity = Math.round((newQuantity - package) * 1000) / 1000;
                quantity.val(newQuantity);
                button.attr('data-quantity', newQuantity);
                if (newQuantity != oldQuantity) {
                    button.addClass('active');
                } else {
                    button.removeClass('active');
                }
            }
        });
        plus.click(function() {
            newQuantity = Math.round((newQuantity + package) * 1000) / 1000;
            quantity.val(newQuantity);
            button.attr('data-quantity', newQuantity);
            if (newQuantity != oldQuantity) {
                button.addClass('active');
            } else {
                button.removeClass('active');
            }
        });
    });

    var changeProductQuantity = $('.product__inpunt_accept'); // ajax
    $.each(changeProductQuantity, function(key, value) {
        $(this).click(function() {
            if ($(this).hasClass('active')) {
                var id = $(this).attr('data-id');
                console.log(id);
                var quantity = $(this).attr('data-quantity');
                console.log(quantity);
                // console.log(id);
                $.ajax({
                    type: "POST",
                    url: "/cart/change",
                    data: {
                        id: id,
                        quantity: quantity,
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        var data = $.parseJSON(data);
                        // console.log(data);
                        location.reload();
                    },
                    error: function(errResponse) {
                        console.log(errResponse);
                    }
                });
            }
        });
    });

    // var cartProductQuantity = document.querySelectorAll('.cart_table__item_quantity');
    // console.log(cartProductQuantity);
    // cartProductQuantity.forEach(function(elem, iter) {
    //     for (var i = 0; i < cartProductQuantity.childNodes.length; i++) {
    //         if (cartProductQuantity.childNodes[i].className == "cart_table__item_quantity_minus") {
    //             var minus = doc.childNodes[i];
    //             break;
    //         }
    //     }
    //     for (var i = 0; i < cartProductQuantity.childNodes.length; i++) {
    //         if (cartProductQuantity.childNodes[i].className == "cart_table__item_quantity_plus") {
    //             var plus = doc.childNodes[i];
    //             break;
    //         }
    //     }
    //     for (var i = 0; i < cartProductQuantity.childNodes.length; i++) {
    //         if (cartProductQuantity.childNodes[i].className == "product__input_units") {
    //             var oldQuantity = doc.childNodes[i];
    //             break;
    //         }
    //     }


    //     minus.addEventListener('click', () => {
    //         console.log(oldQuantity);
    //     });
    // });

    var salePackage = document.querySelectorAll('.unit_buttons > span');
    //На карточках товаров при клике по кнопке "за 1 м.кв.", "за 1 уп" цена На продукт отображается соответствующая
    salePackage.forEach(function(btn, i) {
        btn.addEventListener('click', () => {
            if (!btn.classList.contains('active')) {
                const buttons = btn.parentNode.children;
                const pricePerUnitDiv = btn.parentNode.parentNode.querySelector('.new_price');
                const oldPricePerUnitDiv = btn.parentNode.parentNode.querySelector('.old_price');


                var pricePerUnit = pricePerUnitDiv.innerHTML.trim().replace(/\s/g, '');
                pricePerUnit = parseFloat(pricePerUnit.replace(",", "."));
                const unitInPackage = btn.getAttribute('data-package');
                var pricePerPackage = Number((pricePerUnit * unitInPackage).toFixed(2));
                for (let i = 0; i < buttons.length; i++) {
                    buttons[i].classList.remove('active');
                }
                btn.classList.add('active');
                if (oldPricePerUnitDiv != null) {
                    var oldPricePerUnit = oldPricePerUnitDiv.innerHTML.trim().replace(/\s/g, '');
                    oldPricePerUnit = parseFloat(oldPricePerUnit.replace(",", "."));
                    var oldPricePerPackage = Number((oldPricePerUnit * unitInPackage).toFixed(2));
                }
                if (btn.classList.contains('unit_buttons__unit')) {
                    pricePerUnitDiv.innerHTML = (pricePerUnit / unitInPackage).format(2, 3, ' ', ',');

                    if (oldPricePerUnitDiv != null) {
                        oldPricePerUnitDiv.innerHTML = (oldPricePerUnit / unitInPackage).format(2, 3, ' ', ',');
                    }
                } else {
                    pricePerUnitDiv.innerHTML = pricePerPackage.format(2, 3, ' ', ',');
                    if (oldPricePerUnitDiv != null) {
                        oldPricePerUnitDiv.innerHTML = oldPricePerPackage.format(2, 3, ' ', ',');
                    }
                }
            }
        });
    });

    Number.prototype.format = function(n, x, s, c) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
            num = this.toFixed(Math.max(0, ~~n));

        return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
    };

    // var salePackage2 = document.querySelectorAll('.products__card__price__new__package');
    // salePackage2.forEach(function(btn, i) {
    //     if (btn.querySelectorAll('div').length < 2) {
    //         btn.parentNode.parentNode.parentNode.querySelector('.products__card__buttons').remove();
    //     }
    // });

    // show and close main description
    $('.main_about > button').on('click', function() {
        var parent = $(this).parent();
        parent.toggleClass('active');
        if (parent.hasClass('active')) {
            $(this).html('свернуть...');
        } else {
            $(this).html('раскрыть...');
        }
    });

    //Управление миниатюрами и главным изображением в карточке товара на фронет
    var mainProductImage = document.querySelector('.main_product_image > img');
    var otherProductImagesContainer = document.querySelector('.images__container > .column');
    var otherProductImages = document.querySelectorAll('.images__container__item > img');
    var otherProductImagesSize = otherProductImages.length;

    var otherProductImageUp = document.querySelector('.images__container span.up');
    var otherProductImageDown = document.querySelector('.images__container span.down');
    // console.log(otherProductImageDown);
    otherProductImages.forEach(function(img, i) {
        img.addEventListener('click', () => {
            const mainThumbnail = img.parentNode.parentNode.querySelector('.main');
            mainThumbnail.classList.remove('main');
            img.classList.add('main');
            mainProductImage.setAttribute('src', img.getAttribute('src'));
        });
    });

    var otherProductImagesPosition = 0;
    var step = 0;
    //if (otherProductImagesContainer.length > 4) {
    if (otherProductImageDown != null) {
        otherProductImageDown.addEventListener('click', () => {
            otherProductImagesPosition -= 75;
            step++;
            otherProductImagesContainer.style.top = otherProductImagesPosition + 'px';
            otherProductImageUp.style.display = 'block';
            if (otherProductImagesSize - step == 4) {
                otherProductImageDown.style.display = 'none';
            }
        });
    }

    if (otherProductImageUp != null) {
        otherProductImageUp.addEventListener('click', () => {
            otherProductImagesPosition += 75;
            step--;
            otherProductImagesContainer.style.top = otherProductImagesPosition + 'px';
            otherProductImageDown.style.display = 'block';
            if (step == 0) {
                otherProductImageUp.style.display = 'none';
            }
        });
    }

    //}

    //Конец
    //-----------------------------------------

    //сумма в карточке товара

    var resultPrice = $('.product__result_price > div');
    var packageInput = $('#product__input_units');
    var package = $('#product__input_units').attr('data-package');
    var price = $('#price').text();
    var packageCountInput = $('.count_package');
    var packageCount = 1;
    var packageInputValue = 0;
    price = parseFloat(price.replace(/\s/g, '').replace(",", "."));
    var resultPriceValue = Math.round((price * package).toFixed(2) * 100) / 100;

    if (package != null) {
        packageInput.val(package.replace(/\B(?=(\d{3})+(?!\d))/g, " "));
    }

    resultPrice.text(resultPriceValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").replace(".", ","));
    $('.product__input_units_minus').on('click', PriceDown);
    $('.product__input_units_plus').on('click', PriceUp);

    packageInput.focusout(function() {
        var dirtyPackage = $(this).val();
        var newPackageCount = dirtyPackage / package;
        if (newPackageCount > packageCount) {
            PriceUp(Math.ceil(newPackageCount));
        } else if (newPackageCount < packageCount) {
            PriceDown(Math.ceil(newPackageCount));
        }
    });

    function PriceDown(step = 1) {
        if (step > 1) {
            packageCount = step;
        }
        if (packageCount > 1) {
            packageCount--;
            packageInputValue = Math.round((package * packageCount) * 1000) / 1000;
            packageInput.val(packageInputValue);
            resultPriceValue = Math.round((packageInputValue * price) * 100) / 100;
            resultPrice.text(resultPriceValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").replace(".", ","));
            packageCountInput.text(packageCount);
        }
    }

    function PriceUp(step = 1) {
        if (step > 1) {
            packageCount = step;
        } else {
            packageCount++;
        }

        packageInputValue = Math.round((package * packageCount) * 1000) / 1000;
        packageInput.val(packageInputValue);
        resultPriceValue = Math.round((packageInputValue * price) * 100) / 100;
        resultPrice.text(resultPriceValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ").replace(".", ","));
        packageCountInput.text(packageCount);
    }

    $('.to_cart').on('click', function() {
        if ($('.to_cart').html() != 'в корзину') {
            var productId = $(this).attr('data-product');
            var quantity = $('#product__input_units').val();

            quantity = parseFloat(quantity.replace(/\s/g, '').replace(",", "."))
                // var price = $('#price').text();
                // price = parseFloat(price.replace(/\s/g, '').replace(",", "."))
                // console.log(productId);

            $.ajax({
                type: "POST",
                url: "/cart",
                data: {
                    productId: productId,
                    quantity: quantity,
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var data = $.parseJSON(data);
                    // console.log(data);
                    // if ($('.cart__content').text() == 'Ваша корзина пока что пуста') {
                    //     $('.cart__content').empty();
                    // }
                    // var currentItems = $('.cart__content__item');
                    var currentItems = document.querySelectorAll('.cart__content__item');
                    // console.log(currentItems);
                    // $.each(currentItems, function(key, value) {
                    //     alert(key + ": " + value);
                    // });
                    //updating total_sum
                    var cartCount = $('.cart_count').text();
                    $('.cart_sum > span').fadeOut(100);
                    $('.cart_sum > span').text(data.total_sum);
                    $('.product_finalsum').text(data.total_sum);

                    // numberTo('.cart_sum > span', $('.product_finalsum').text, data.total_sum, 3000);

                    $('.cart_sum > span').fadeIn(900);

                    var flag = false;
                    currentItems.forEach(function(item, i, arr) {
                        // alert(i + ": " + item + " (массив:" + arr + ")");
                        // console.log(item.dataset.product);
                        //если этот товар уже есть в корзине
                        if (item.dataset.product == data.id) {
                            flag = true;
                            // console.log(item.dataset.product);
                            var updateItem = currentItems[i].childNodes[2].childNodes[0];
                            var position = updateItem.innerText.indexOf(' ');
                            var updateItemValue = updateItem.innerText.slice(0, position);

                            // console.log(updateItem.innerText);
                            updateItemValue = parseFloat(updateItemValue.replace(",", "."));
                            var updateItemString = updateItem.innerText.slice(position);
                            updateItem.innerText = data.quantity.toFixed(3) + updateItemString;
                            var price = currentItems[i].childNodes[2].lastChild;
                            price.innerText = data.sum + ' РУБ.';
                        }
                    });
                    //если данного орвара нет еще в корзине
                    if (!flag) {
                        console.log(cartCount);
                        $('.cart_count').text(++cartCount);
                        if (data.categorySlug != '') {
                            var link = '"/catalog/' + data.categorySlug + '/' + data.productSlug + '"';
                        } else {
                            var link = '"/catalog/product/' + data.productSlug + '"';
                        }
                        if (data.img != null) {
                            var image = '"/imgs/products/thumbnails/' + data.img.thumbnail + '"';
                        } else {
                            var image = '"/imgs/nopic.png"';
                        }

                        var elem = $('.cart__content > .last');
                        if (elem.length > 0) {
                            $('.cart__content > .last').after('<div class="cart__content__item d-flex justify-content-between" data-product = "' + data.id + '" ><div class = "cart__content__left d-flex"><img src=' + image + '><div class = "product_title" ><a href =' + link + ' >' + data.product + '</a></div></div><div class = "cart__content__right d-flex"><div class = "product_quantity">' + data.quantity + ' ' + data.unit + '</div><div class = "product_sum btn btn-sm btn-info">' + data.sum + ' РУБ.' + '</div></div></div>');
                        } else {
                            $('.cart__content').empty();
                            $('.cart__content').append('<div class="cart__content__item d-flex justify-content-between" data-product = "' + data.id + '" ><div class = "cart__content__left d-flex"><img src=' + image + '><div class = "product_title" ><a href =' + link + ' >' + data.product + '</a></div></div><div class = "cart__content__right d-flex"><div class = "product_quantity">' + data.quantity + ' ' + data.unit + '</div><div class = "product_sum btn btn-sm btn-info">' + data.sum + ' РУБ.' + '</div></div></div>');
                        }
                        // console.log($('.product_finalsum'));
                        if ($('.product_finalsum').length == 0) {
                            $('.cart__content').append('<hr><div class="product_sum d-flex justify-content-end"><span>Общая сумма (руб.): </span><div class="btn product_finalsum  btn-info">' + data.total_sum + '</div><div class="btn m-green"><a href="/cart">Перейти в корзину</a></div></div>');
                        }
                    }
                },
                error: function(errResponse) {
                    console.log(errResponse);
                }
            });


            $('.to_cart').html('<a href="/cart">в корзину</a>');
        }


    });
    // console.log(price);
    // console.log(parseFloat($('#product__input_units').val().replace(",", ".")) * 1.22);

    var cartSum = $('.product_finalsum').text();

    if (cartSum.length > 0) {
        // console.log(cartSum);
        $('.cart_sum > span').text(cartSum);
    }

    var cartCount = $('.cart__content__item').length;

    $('.cart_count').text(cartCount);

    // function numberTo(class_name, from, to, duration) {
    //     var element = document.querySelector(class_name);
    //     var start = new Date().getTime();
    //     setTimeout(function() {
    //         var now = (new Date().getTime()) - start;
    //         var progress = now / duration;
    //         var result = Math.floor((to - from) * progress + from);
    //         element.innerHTML = progress < 1 ? result : to;
    //         if (progress < 1) setTimeout(arguments.callee, 10);
    //     }, 10);
    // }

    // $('.destroy_cart_item').click(function() {
    //     var id = $(this).attr('data-id');
    //     $.ajax({
    //         type: "POST",
    //         url: "/cart/destroy",
    //         data: {
    //             id: id,
    //         },
    //         headers: {
    //             'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(data) {

    //         },
    //         error: function(errResponse) {
    //             console.log(errResponse);
    //         }
    //     });
    // });

    $('.user_info_send').click(function(e) {
        e.preventDefault();
        var surname = $('#user_info_surname').val();
        var name = $('#user_info_name').val();
        var address = $('#user_info_address').val();
        var email = $('#user_info_email').val();
        var id = $('#user_info_id').val();

        $.ajax({
            type: "POST",
            url: "/user/edit",
            data: {
                surname: surname,
                name: name,
                address: address,
                email: email,
                id: id,
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var data = $.parseJSON(data);
                console.log(data);
                $('#exampleModal').modal('hide');

                window.location.href = "/home";

            },
            error: function(errResponse) {
                console.log(errResponse);
            }
        });
    });

    //безнал
    $('#payment_method_2').change(function() {
        if (this.checked) {
            var firms = $('.user_firms_list');
            if (firms.children().length == 0) {
                $('#firm').modal('show');
            } else {
                $.each(firms.children(), function(key, value) {
                    $(this).prop('disabled', false);
                    $(this).click(function() {
                        if ($(this).hasClass('btn-secondary') && !$(this).prop('disabled')) {
                            $(this).siblings('.btn').removeClass('btn-success');
                            $(this).addClass('btn-success');
                            $('#firm_inn').val($(this).attr('data-inn'));
                        }
                    });
                });
            }
            $('#firm_edit').prop('disabled', false);
            $('#firm_inn').prop('required', true);
        }
    });

    var user_firms_list = $('.user_firms_list').children();


    $('#payment_method_1').change(function() {
        if (this.checked) {
            var firms = $('.user_firms_list');
            if (firms.children().length != 0) {
                $.each(firms.children(), function(key, value) {
                    $(this).prop('disabled', true);
                });
            }
            $('#firm').modal('hide');
            $('#firm_edit').prop('disabled', true);
            $('#firm_inn').prop('required', false);
        }
    });

    $('#firm_inn_check').click(function() {
        var inn = $('#firm_inn').val();
        $.ajax({
            type: "POST",
            url: "/checkinn",
            data: {
                inn: inn,
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                var data = $.parseJSON(data);
                data = data.suggestions;
                console.log(data);
                if (data.length > 0) {
                    if (data[0].data.state.status == 'ACTIVE') {
                        $('#firm_data_error').hide();
                        $('#firm_data').show();

                        var firm_data = {};

                        firm_data['firm_name'] = data[0].data.name.short_with_opf;
                        firm_data['firm_status'] = data[0].data.state.status;
                        firm_data['firm_postal_code'] = data[0].data.address.data.postal_code;
                        firm_data['firm_region'] = data[0].data.address.data.region_with_type;
                        firm_data['firm_city'] = data[0].data.address.data.city_with_type;
                        firm_data['firm_street'] = data[0].data.address.data.street_with_type;
                        firm_data['firm_ogrn'] = data[0].data.ogrn;
                        firm_data['firm_inn'] = data[0].data.inn;
                        firm_data['firm_okpo'] = data[0].data.okpo;

                        $.each(firm_data, function(index, value) {
                            $('#' + index).val(value);
                        });


                    } else {
                        $('#firm_data_error').show();
                    }
                } else {
                    $('#firm_data_error').show();
                }



            },
            error: function(errResponse) {
                console.log(errResponse);
            }
        });
    });
    $('#firm_inn_confirm').click(function() {
        var firm_data = {};

        firm_data['firm_name'] = $('#firm_name').val();
        firm_data['firm_status'] = $('#firm_status').val();
        firm_data['firm_postal_code'] = $('#firm_postal_code').val();
        firm_data['firm_region'] = $('#firm_region').val();
        firm_data['firm_city'] = $('#firm_city').val();
        firm_data['firm_street'] = $('#firm_street').val();
        firm_data['firm_ogrn'] = $('#firm_ogrn').val();
        firm_data['firm_inn'] = $('#firm_inn').val();
        firm_data['firm_okpo'] = $('#firm_okpo').val();

        $.ajax({
            type: "POST",
            url: "/firm/store",
            data: {
                firm_data: firm_data,
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#firm').modal('hide');
                var response = $.parseJSON(response);
                console.log(response);


            },
            error: function(errResponse) {
                console.log(errResponse);
            }
        });
    });
    // var arr = [];
    // document.addEventListener("click", function(e) {
    //     if (e.target.id != '') {
    //         arr.push(e.target.id);
    //     }
    // });

    // $("#price_slider").slider({
    //     animate: "slow",
    //     min: 200,
    //     max: 300,
    //     range: true,
    //     values: [200, 300],
    //     slide: function(event, ui) {
    //         $("#result-polzunok").text("от " + ui.values[0] + " до " + ui.values[1]);
    //     }
    // });
    // $("#result-polzunok").text("от " + $("#price_slider").slider("values", 0) + " до " + $("#price_slider").slider("values", 1));




    (function() {
        let confirm_property_button_all = document.querySelectorAll('.confirm_property_button');
        var properties_array = {};

        $('.property__item').change(function() {
            properties_array = propertiesChecked($('input[type=checkbox]:checked'));
            // let index = $(this).attr('data-property_id');
            // if (this.checked) {
            //     if (index in properties_array) {
            //         properties_array[index].push(this.value);
            //     } else {
            //         properties_array[index] = {};
            //         properties_array[index] = [this.value];
            //     }
            // } else {
            //     if (index in properties_array) {
            //         let index_to_delete = properties_array[index].indexOf(this.value);
            //         if (index_to_delete != -1) {
            //             properties_array[index].splice(index_to_delete, 1);
            //             if (properties_array[index].length == 0) {
            //                 delete properties_array[index];
            //             }
            //         }
            //     }
            // }

            let confirm_property_button = this.parentNode.parentNode.querySelector('.confirm_property_button');

            $.each(confirm_property_button_all, function(index, value) {
                if (value.classList.contains('active')) {
                    value.classList.remove('active');
                }
            });

            if (!confirm_property_button.classList.contains('active')) {
                confirm_property_button.classList.add('active');
            }


        });

        confirm_property_button_all.forEach(function(button, i) {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                var new_address = '';
                for (var key in properties_array) {
                    // new_address += 'filter[' + key + ']=' + properties_array[key] + '&';
                    new_address += key + '=' + properties_array[key] + '&';
                }
                new_address = new_address.slice(0, new_address.length - 1);
                let old_url = window.location.href;
                let new_url = old_url.slice(0, AddressStringSearch(old_url, '[?]'));
                // AddressStringSearch(old_url, "[?]");

                window.location.replace(new_url + '?' + new_address);
            });
        });
    }());

    function propertiesChecked(properties) {
        var properties_array = {};
        $.each(properties, function(i, element) {
            let index = '' + $(this).data("property_id");
            if (index in properties_array) {
                properties_array[index].push($(this)[0].value);
            } else {
                properties_array[index] = {};
                properties_array[index] = [$(this)[0].value];
            }
        });
        return properties_array;
    }

    function AddressStringSearch(str, symbol) {
        if (str.search(symbol) != -1) {
            return str.search(symbol);
        } else {
            return str.length;
        }
    }

    // function checkUserPhone() {
    //     let user_phone = document.getElementById('user_phone');
    //     if (user_phone.value.length == 15) {
    //         $.ajax({
    //             type: "POST",
    //             url: "/order/checkuserphone",
    //             data: {
    //                 phone: user_phone.value,
    //             },
    //             headers: {
    //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             success: function(response) {
    //                 let data = $.parseJSON(response);
    //                 let submit_button = document.getElementById('submit');
    //                 let error_block = user_phone.parentNode.querySelector('.invalid-feedback');
    //                 if (data.error) {
    //                     error_block.style.display = 'block';
    //                     submit_button.disabled = true;
    //                 } else {
    //                     error_block.style.display = 'none';
    //                     submit_button.disabled = false;
    //                 }
    //             },
    //             error: function(errResponse) {
    //                 console.log(errResponse);
    //             }
    //         });
    //     }
    // }

    $('.checkUserPhone').bind('input', checkUserPhone);

    function checkUserPhone() {
        let user_phone = document.getElementById('user_phone');
        if (user_phone.value.length == 15) {
            $.ajax({
                type: "POST",
                url: "/order/checkuserphone",
                data: {
                    phone: user_phone.value,
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    let data = $.parseJSON(response);
                    let submit_button = document.getElementById('submit');
                    let error_block = user_phone.parentNode.querySelector('.invalid-feedback');
                    if (data.error) {
                        error_block.style.display = 'block';
                        submit_button.disabled = true;
                    } else {
                        error_block.style.display = 'none';
                        submit_button.disabled = false;
                    }
                },
                error: function(errResponse) {
                    console.log(errResponse);
                }
            });
        }
    }

    // (function() {
    //     let flag = true;
    //     if ($('#user_phone').length > 0) {
    //         var user_phone = document.getElementById('user_phone');    
    //         user_phone.addEventListener('keyup', () => {
    //             if (user_phone.value.length > 15) {
    //                 if (flag) {
    //                     flag = false;
    //                     $.ajax({
    //                         type: "POST",
    //                         url: "/order/checkuserphone",
    //                         data: {
    //                             phone: user_phone.value,
    //                         },
    //                         headers: {
    //                             'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    //                         },
    //                         success: function(response) {
    //                             // console.log(response);
    //                         },
    //                         error: function(errResponse) {
    //                             // console.log(errResponse);
    //                         }
    //                     });
    //                 }
    //             } else {
    //                 flag = true;
    //             }
    //         });
    //     }
    // }());



    $('#products_sort').bind('input', function() {
        let product_sort = $(this).val();
        let scroll = $(window).scrollTop();
        $.ajax({
            type: "POST",
            url: "/setcookie",
            data: {
                product_sort: product_sort,
                scroll: scroll
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

    $('#products_per_page').bind('input', function() {
        let products_per_page = $(this).val();
        let scroll = $(window).scrollTop();
        $.ajax({
            type: "POST",
            url: "/setcookie",
            data: {
                products_per_page: products_per_page,
                scroll: scroll
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

    $('.button__toggle').on('click', function() {
        let element = $(this).attr('data-toopen');
        element = $('.' + element);
        if ($(this).hasClass('active')) {
            element.removeClass('active');
            $(this).removeClass('active');
        } else {
            element.addClass('active');
            $(this).addClass('active');
        }
    });

    //прокрутка страницы к тому месту, откуда была совершена перезагрузка страницы после изменения сортировки или количества товаров на страницу
    var scroll_after_reload = readCookie('scroll');
    if (scroll_after_reload != 0) {
        $(window).scrollTop(scroll_after_reload);
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return 0;
    }

    $(window).on("scroll", function() {
        // console.log($('.fix-to-top').offset().top - $(window).scrollTop());
        let scroll = $(window).scrollTop();
        let window_hight = $(window).height();
        let fix_to_top = $('.fix-to-top-parent');
        if (fix_to_top.length) {
            let block_to_top = $('.fix-to-top-parent').offset().top
            let width = $('.fix-to-top-parent').width();
            let scroll_bar = 0;

            if (block_to_top - scroll < 0) {
                if (!$('.fix-to-top').hasClass('fixed')) {
                    $('.fix-to-top').addClass('fixed');
                    let block_height = $('.fix-to-top').height();
                    if (window_hight == block_height) {
                        scroll_bar = 18;
                    } else {
                        scroll_bar = 0;
                    }

                    $('.fix-to-top').css({ 'width': width + scroll_bar + 'px' });
                }
            } else {
                $('.fix-to-top').removeClass('fixed');
                $('.fix-to-top').css({ 'width': width + 'px' });
            }
        }
    });

    // check_order_status__send modal
    $('.check_order_status__send').on('click', function() {
        var order_number = $('#check_order_status__number').val().replace(/[^\d]/g, '');
        var phone_last4 = $('#check_order_status__phone').val().replace(/[^\d]/g, '');
        console.log(order_number, phone_last4);
        if (phone_last4 != '' && phone_last4 == 4 && order_number != '') {
            CheckOrderStatusSend(order_number, phone_last4);
        }
    });

    function CheckOrderStatusSend(order_number, phone_last4) {

    }

    $('#refresh_captcha').on('click', function() {
        var captcha = $('#captcha_img > img');
        var config = captcha.data('refresh-config');
        $.ajax({
            method: 'GET',
            url: '/get_captcha/' + config,
        }).done(function(response) {
            captcha.prop('src', response);
        });
    });

    $('#search_nav').bind('input', function() {
        let q = $(this).val();
        $.ajax({
            type: "POST",
            url: "/search",
            data: {
                q: q
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                let data = $.parseJSON(response);

                $.each(data, function(key, value) {
                    if (value.length > 0) {
                        $('.search_nav__result').addClass('active');
                        return false;
                    } else {
                        $('.search_nav__result').removeClass('active');
                    }
                });
                if (data.products.length > 0) {
                    $('.search_nav__products_body').empty();
                    $('.search_nav__products').addClass('active');
                    $.each(data.products, function(key, value) {
                        if (value.category) {
                            $('.search_nav__products_body').append('<a class="d-block text-info" href="/catalog/' + value.category.slug + '/' + value.slug + '">' + value.product + ' - ' + value.category.category + ' - ' + value.price + ' руб.</a>');
                        } else {
                            $('.search_nav__products_body').append('<a class="d-block text-info" href="/catalog/product/' + value.slug + '">' + value.product + ' - ' + value.price + ' руб.</a>');
                        }
                    });
                }
                if (data.categories.length > 0) {
                    $('.search_nav__categories_body').empty();
                    $('.search_nav__categories').addClass('active');
                    $.each(data.categories, function(key, value) {
                        $('.search_nav__categories_body').append('<a class="d-block text-info" href="/catalog/' + value.slug + '">' + value.category + '</a>');
                    });
                }
                if (data.manufactures.length > 0) {
                    $('.search_nav__manufactures_body').empty();
                    $('.search_nav__manufactures').addClass('active');
                    $.each(data.manufactures, function(key, value) {
                        $('.search_nav__manufactures_body').append('<a class="d-block text-info" href="/manufacture/' + value.slug + '">' + value.manufacture + '</a>');
                    });
                }
            },
            error: function(msg) {
                console.log(msg);
            }
        });
    });

    $('.close_button').on('click', function() {
        if ($(this).parent().hasClass('active')) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('hide');
        }
    });

    $('.burger').on('click', function() {
        $('nav .main_menu').toggleClass('active');
    });
});
var cartProductQuantity = $('.cart_table__item_quantity');
// console.log(cartProductQuantity);

$.each(cartProductQuantity, function(key, value) {
    var minus = $(this).find('.cart_table__item_quantity_minus');
    var plus = $(this).find('.cart_table__item_quantity_plus');
    var button = $(this).find('.product__inpunt_accept');
    var quantity = $(this).find('.product__input_units');
    quantity.val(Math.round(quantity.val() * 100) / 100);
    var oldQuantity = parseFloat(quantity.val().replace(",", "."));
    var newQuantity = oldQuantity;
    var package = parseFloat(quantity.attr('data-package').replace(",", "."));
    
    // var iterMinus = 0;
    minus.click(function() {
        if (newQuantity - package > 0.001) {
            newQuantity = Math.round((newQuantity - package).toFixed(3) * 100) / 100;
            quantity.val(newQuantity);
            if (newQuantity != oldQuantity) {
                button.addClass('active');
            } else {
                button.removeClass('active');
            }
        }
    });
    plus.click(function() {
        newQuantity = Math.round((newQuantity + package).toFixed(3) * 100) / 100;
        quantity.val(newQuantity);
        if (newQuantity != oldQuantity) {
            button.addClass('active');
        } else {
            button.removeClass('active');
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
        packageInputValue = Math.round((package * packageCount).toFixed(3) * 100) / 100;
        packageInput.val(packageInputValue);
        resultPriceValue = Math.round((packageInputValue * price).toFixed(2) * 100) / 100;
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

    packageInputValue = Math.round((package * packageCount).toFixed(3) * 100) / 100;
    packageInput.val(packageInputValue);
    resultPriceValue = Math.round((packageInputValue * price).toFixed(2) * 100) / 100;
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
                        updateItem.innerText = data.quantity.toFixed(2) + updateItemString;
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
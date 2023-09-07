$(document).ready(function() {
    var oldScroll = 0;
    var clickToSmall = false;
    var marginMainMenu = $('.mainmenu').css('margin-top');
    var marginFirstSection = $('#firstsection').css('padding-top');

    $('.fastmenu__tosmall').click(function() {
        if ($('.fastmenu').hasClass('active')) {
            clickToSmall = false;
            $('.mainmenu').css('margin-top', marginMainMenu);
            $('#firstsection').css('padding-top', marginFirstSection);
        } else {
            clickToSmall = true;
            $('.mainmenu').css('margin-top', '45px');
            $('#firstsection').css('padding-top', '89px');
        }
        $('.fastmenu').toggleClass('active');
        $('.fastmenu__tosmall').toggleClass('active');
        $('.fastmenu__tosmall > span').toggleClass('active');
        $('.fastmenu').children().toggleClass('hide');
        //$('.logo').toggleClass('hide');	

    });

    $(window).scroll(function() {
        if ($(window).scrollTop() > 100) {
            $('.mainmenu__burger').addClass('active');
        } else {
            $('.mainmenu__burger').removeClass('active');
        }
        if (!clickToSmall) {
            if ($(window).scrollTop() > oldScroll + 50) {
                oldScroll = $(window).scrollTop();
                $('.fastmenu').addClass('active');
                $('.mainmenu').css('margin-top', '45px');
                $('.fastmenu__tosmall > span').addClass('active');
                $('.fastmenu__tosmall').addClass('active');
                //$('.logo').addClass('hide');
                $('.fastmenu').children().addClass('hide');
            };

            if (($(window).scrollTop() < oldScroll - 300) || ($(window).scrollTop() < 100)) {
                oldScroll = $(window).scrollTop();
                $('.fastmenu').removeClass('active');
                $('.fastmenu__tosmall > span').removeClass('active');
                $('.fastmenu__tosmall').removeClass('active');
                //$('.logo').removeClass('hide');
                $('.fastmenu').children().removeClass('hide');
                $('.mainmenu').css('margin-top', marginMainMenu);
            }
        }
    });

    if (($('.fastmenu__body__right__shopping_cart > span').html() == '') || ($('.fastmenu__body__right__shopping_cart > span').html() == 0)) {
        $('.fastmenu__body__right__shopping_cart > span').hide();
    }

    $('.fastmenu__body__right__search > i').click(function() {
        let search = $('.fastmenu__body__right__search > .search__form');
        search.toggleClass('active');

        //    if (search.hasClass('active')) {
        //        $('.fastmenu__body__tel').css('opacity', '0.5');
        //    }


    });

    // var prices = document.querySelectorAll('.products__card__price__new > div > span.value');

    // for (let i = 0; i < prices.length; i++) {
    //     if (prices[i].innerText % 1 == 0) {
    //         prices[i].innerText = parseInt(prices[i].innerText);
    //     }
    // }

    var salePackage = document.querySelectorAll('.products__card__price__new__package > div');

    //На карточках товаров при клике по кнопке "за 1 м.кв.", "за 1 уп" цена На продукт отображается соответствующая
    salePackage.forEach(function(btn, i) {
        btn.addEventListener('click', () => {
            const oldPrice = btn.parentNode.children;
            const showPriceValue = btn.parentNode.parentNode.querySelector('div > span.price_value');

            for (let i = 0; i < oldPrice.length; i++) {
                oldPrice[i].classList.remove('active');
            }
            showPriceValue.innerText = (Math.round(btn.dataset.price * 100) / 100).toLocaleString('ru');
            btn.classList.add('active');

        });
    });

    /**
     * Удаление всплывающего окна заказа товара, если его цена = 0
     */
    var salePackage2 = document.querySelectorAll('.products__card__price__new__package');
    salePackage2.forEach(function(btn, i) {
        const priceValue = btn.parentNode.parentNode.querySelector('.price_value').innerText;
        // if (btn.querySelectorAll('div').length < 2) {
        //     btn.parentNode.parentNode.parentNode.querySelector('.products__card__buttons').remove();
        // }
        if (priceValue <= 0) {
            btn.parentNode.parentNode.parentNode.querySelector('.products__card__buttons').remove();
            if (priceValue < 0) {
                btn.parentNode.parentNode.querySelector('.price_value').innerText = 0;
            }
        }
    });




    // var priceInInput = document.querySelectorAll('.products__card__buttons__input > input');
    // console.log(priceInInput);
    // priceInInput.forEach(function(input, i) {
    //     //input.value = 555;
    // });

    var pricePlus = document.querySelectorAll('.products__card__buttons__input > span.plus');
    pricePlus.forEach(function(plus, i) {
        const countInInput = plus.parentNode.parentNode.querySelector('.products__card__buttons__input > input');
        const forPayment = plus.parentNode.parentNode.querySelector('.for_payment > span');
        const unit = forPayment.getAttribute('data-unit');
        plus.addEventListener('click', () => {
            let count = countInInput.dataset.countpackage;
            count++;
            countInInput.value = Math.round(countInInput.dataset.count * count * 100) / 100 + ' ' + unit;
            countInInput.dataset.countpackage = count;
            forPayment.innerText = (Math.round(count * countInInput.dataset.price * 100) / 100).toLocaleString('ru');

        });
    });

    var priceMinus = document.querySelectorAll('.products__card__buttons__input > span.minus');
    priceMinus.forEach(function(minus, i) {
        const countInInput = minus.parentNode.querySelector('.products__card__buttons__input > input');
        const forPayment = minus.parentNode.parentNode.querySelector('.for_payment > span');
        const unit = forPayment.getAttribute('data-unit');
        minus.addEventListener('click', () => {
            let count = countInInput.dataset.countpackage;
            if (count > 1) {
                count--;
                countInInput.dataset.countpackage = count;
                countInInput.value = Math.round(countInInput.dataset.count * count * 100) / 100 + ' ' + unit;
                forPayment.innerText = (Math.round(count * countInInput.dataset.price * 100) / 100).toLocaleString('ru');
            }
        });
    });

    var one_click = document.querySelectorAll('.one_click');
    one_click.forEach(function(click, i) {
        click.addEventListener('click', () => {
            const quantity = click.parentNode.parentNode.querySelector('.products__card__buttons__input > input').value;
            const price = click.parentNode.parentNode.querySelector('.for_payment > span').innerText;
            var product = click.parentNode.parentNode.parentNode.querySelector('.products__card__info > .products__card__maininfo > .products__card__title > h3 > a');
            if (!product) {
                product = document.URL;
            }
            $('#modal_oneclick_quantity').val(quantity);
            $('#modal_oneclick_price').val(price + " руб.");

            $('#modal_oneclick_product').val(product);

            $('.modal_oneclick').addClass('active');
        });

    });

    /** Formatting price */
    (function() {
        let priceValues = document.querySelectorAll('.price_value');
        priceValues.forEach(element => {
            element.innerText = (Math.round(element.innerText * 100) / 100).toLocaleString('ru');


        });
    }());

    $('.help_btn').click(function() {
        $('.modal_send_question').addClass("active");
    });

    $('.modal_oneclick__header__close').click(function() {
        $('.modal_oneclick').removeClass("active");
    });
    $('.modal_send_question__header__close').click(function() {
        $('.modal_send_question').removeClass("active");
    });

    //-----------------
    //Управление миниатюрами и главным изображением в карточке товара на фронет
    var mainProductImage = document.querySelector('.main_product_image > img');
    var otherProductImagesContainer = document.querySelector('.images__container > .column');
    var otherProductImages = document.querySelectorAll('.images__container__item > img');
    var otherProductImagesSize = otherProductImages.length;

    var otherProductImageUp = document.querySelector('.images__container span.up');
    var otherProductImageDown = document.querySelector('.images__container span.down');

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
    //Конец
    //-----------------------------------------  
    $('#question').click(function(event) {
        //event.preventDefault();
        //var $form = $(this);
        var phone = $('#question_phone').val();
        var name = $('#question_name').val();
        var question = $('#question_question').val();
        //console.log(phone);
        $.ajax({
            type: 'get',
            url: '/send-question',
            //data: $form.serialize()
            data: {
                phone: phone,
                name: name,
                question: question
            },
            // headers: {
            //     'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            // },
            success: function(data) {
                // $('#addArticle').modal('hide');
                // $('#articles-wrap').removeClass('hidden').addClass('show');
                // $('.alert').removeClass('show').addClass('hidden');
                // var str = '<tr><td>' + data['id'] +
                //     '</td><td><a href="/article/' + data['id'] + '">' + data['title'] + '</a>' +
                //     '</td><td><a href="/article/' + data['id'] + '" class="delete" data-delete="' + data['id'] + '">Удалить</a></td></tr>';

                //$('.table > tbody:last').append(str);
                $('.modal_send_question').removeClass("active");
                $('.modal_send_question').removeClass("active");
            },
            error: function(msg) {
                alert('Ошибка');
            }
        });
        return false;
    });

    $('#modal_oneclick_btn').click(function(event) {
        var name = $('#modal_oneclick_name').val();
        var phone = $('#modal_oneclick_phone').val();
        var quantity = $('#modal_oneclick_quantity').val();
        var price = $('#modal_oneclick_price').val();
        var product = $('#modal_oneclick_product').val();

        $.ajax({
            type: 'get',
            url: '/oneclick-purcache',
            data: {
                phone: phone,
                name: name,
                quantity: quantity,
                price: price,
                product: product,
            },
            success: function(data) {
                $('.modal_oneclick').removeClass('active');
            },
            error: function(msg) {
                alert(msg);
                console.log(msg);
            }
        });
        return false;
    });

    $('#products_sort').change(function() {
        $.ajax({
            type: "POST",
            url: "/productsort",
            data: {
                productsort: $(this).val()
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // var response = $.parseJSON(data);
                // console.log(response);
                location.reload(true);
            },
            error: function(msg) {
                console.log(msg);
            }
        });

    });

    $('#products_per_page').change(function() {
        $.ajax({
            type: "POST",
            url: "/productsort",
            data: {
                products_per_page: $(this).val()
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // var response = $.parseJSON(data);
                // console.log(response);
                location.reload(true);
            },
            error: function(msg) {
                console.log(msg);
            }
        });

    });
});
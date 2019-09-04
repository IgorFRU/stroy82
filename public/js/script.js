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

packageInput.val(package.replace(/\B(?=(\d{3})+(?!\d))/g, " "));
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
    console.log(step);
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

$('.to_cart').on('click', function () {
    if ($('.to_cart').html() != 'в корзину') {
        $('.to_cart').html('<a href="/cart">в корзину</a>');
    }  
});
// console.log(price);
// console.log(parseFloat($('#product__input_units').val().replace(",", ".")) * 1.22);
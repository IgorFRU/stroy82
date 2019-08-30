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
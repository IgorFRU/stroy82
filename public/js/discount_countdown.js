function getTimeRemaining(endtime) {
    // endtime = Date.parse(endtime) + 23 * 60 * 60 * 1000 + 59 * 60 * 1000 + 59 * 1000;
    // console.log(endtime.toString());
    var t = (Date.parse(endtime) + 23 * 60 * 60 * 1000 + 59 * 60 * 1000 + 59 * 1000) - Date.parse(new Date());
    var seconds = Math.floor((t / 1000) % 60);
    var minutes = Math.floor((t / 1000 / 60) % 60);
    var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
    var days = Math.floor(t / (1000 * 60 * 60 * 24));

    return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
    };
}

function initializeClock(elem, id, endtime) {
    var clock = document.getElementById(id);
    var daysSpan = clock.querySelector('.days');
    var hoursSpan = clock.querySelector('.hours');
    var minutesSpan = clock.querySelector('.minutes');
    var secondsSpan = clock.querySelector('.seconds');

    function updateClock() {
        var t = getTimeRemaining(endtime);

        daysSpan.innerHTML = t.days + ' д.';
        hoursSpan.innerHTML = ('0' + t.hours).slice(-2) + ' ч.';
        minutesSpan.innerHTML = ('0' + t.minutes).slice(-2) + ' м.';
        secondsSpan.innerHTML = ('0' + t.seconds).slice(-2) + ' с.';

        if (t.total <= 0) {
            clearInterval(timeinterval);
        }
        if (t.days == 0 && t.seconds > 0) {
            $(elem).removeClass('d-flex');
            $(elem).addClass('discount_last_day');
            $(elem).empty();
            $(elem).append("Сегодня последний день акции!");
        }
    }

    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
}

var discountProducts = $('.sale_product__count');
var toDay = new Date();
discountProducts.each(function(index, elem) {
    var strDate = toDay.getFullYear() + "-" + ("0" + (toDay.getMonth() + 1)).slice(-2) + "-" + toDay.getDate();
    var productId = $(elem).data("id");
    var elemId = "countdown-" + productId;
    // console.log(productId);
    // console.log(strDate);
    // console.log($(elem).data("discount").substr(0, 10));
    if (strDate == $(elem).data("discount").substr(0, 10)) {
        $(elem).removeClass('d-flex');
        $(elem).addClass('discount_last_day');
        $(elem).empty();
        $(elem).append("Сегодня последний день акции!");
    } else {
        initializeClock(elem, elemId, $(elem).data("discount").substr(0, 10));
    }



});
function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.parse(new Date());
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

  function initializeClock(id, endtime) {
    var clock = document.getElementById(id);
    var daysSpan = clock.querySelector('.days');
    var hoursSpan = clock.querySelector('.hours');
    var minutesSpan = clock.querySelector('.minutes');
    var secondsSpan = clock.querySelector('.seconds');
   
    function updateClock() {
      var t = getTimeRemaining(endtime);
   
      daysSpan.innerHTML = t.days;
      hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
      minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
      secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
   
      if (t.total <= 0) {
        clearInterval(timeinterval);
      }
    }
   
    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
  }

var discountProducts = $('.sale_product__count');
var toDay = new Date();
// console.log(discountProducts);
discountProducts.each(function(index, elem){
    // console.log($(elem).data("discount").substr(0, 10));
    var strDate = toDay.getFullYear() + "-" + ("0" + (toDay.getMonth() + 1)).slice(-2) + "-" + toDay.getDate();
    console.log(strDate);
    // console.log($(elem).data("discount").substr(0, 10));
    if (strDate == $(elem).data("discount").substr(0, 10)) {
        $(elem).addClass('discount_last_day');
        $(elem).empty();        
        $(elem).append("Сегодня последний день акции!");
    } else {
        // console.log(deadline);
        initializeClock('countdown', $(elem).data("discount").substr(0, 10));
    }

});
// initializeClock('countdown', strDate);
   
//   var deadline = new Date(Date.parse(new Date()) + 15 * 24 * 60 * 60 * 1000); // for endless timer
//   console.log(deadline);
//   initializeClock('countdown', deadline);
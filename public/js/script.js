
var discountProducts = $('.sale_product__count');
var toDay = new Date();
// console.log(discountProducts);
discountProducts.each(function(index, elem){
    // console.log($(elem).data("discount").substr(0, 10));
    var strDate = toDay.getFullYear() + "-" + ("0" + (toDay.getMonth() + 1)).slice(-2) + "-" + toDay.getDate();
    if (strDate == $(elem).data("discount").substr(0, 10)) {
        $(elem).addClass('discount_last_day');
        $(elem).append("Сегодня последний день акции!")
    } else {
        
    }

});

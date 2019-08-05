$(function() {
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
}); 
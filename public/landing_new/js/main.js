

$(document).ready(function(){

    if(window.location.hash != "") {
        $('a[href="' + window.location.hash + '"]').click()
    }

    $('.owl-carousel').owlCarousel({
        navigation: false,
        dots: true,
        loop:true,
        margin:0,
        autoplay:true,
        autoplayTimeout:12000,
        items: 1

    });

});
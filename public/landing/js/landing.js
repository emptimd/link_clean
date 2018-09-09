(function () {
'use strict';

/*---CSRF TOKEN---*/
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function () {
    $('#demo').on('submit',function(e) {
    	if($('#demo-email-hidden').val()) { return true; }
    	e.preventDefault();
    	$('#give-email').modal('show');
    });

    $('#give-email').on('shown.bs.modal', function () {
        $('#demo-email').focus();
    });

    $('#demo-email-form').on('submit',function(e) {
        e.preventDefault();
        $('#demo-email-hidden').val(document.getElementById("demo-email").value);
        $('#demo-password-hidden').val(document.getElementById("demo-password").value);
        $('#demo').submit();
    });

    // if(window.location.hash != "") {
    //     $('a[href="' + window.location.hash + '"]').click()
    // }

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

}());
//# sourceMappingURL=landing.js.map

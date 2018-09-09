/*---CSRF TOKEN---*/
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
    var $sidebar = $('#sidebar');

    /*---LEFT BAR ACCORDION----*/
    $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: true,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
        classExpand: 'dcjq-current-parent'
    });
    $('.dcjq-parent').removeAttr('href');


    $sidebar.find('.sub-menu > a').click(function () {
        var o = ($(this).offset());
        var diff = 250 - o.top;
        if(diff>0)
            $sidebar.scrollTo("-="+Math.abs(diff),500);
        else
            $sidebar.scrollTo("+="+Math.abs(diff),500);
    });

    $('.fa-bars').click(function () {
        if ($sidebar.is(":visible") === true) {
            $('#main-content').css({
                'margin-left': '0px'
            });
            $sidebar.hide();
        } else {
            $('#main-content').css({
                'margin-left': '210px'
            });
            $sidebar.show();
        }
    });

    // custom scrollbar
    $sidebar.niceScroll({styler:"fb",cursorcolor:"#e8403f", cursorwidth: '3', cursorborderradius: '10px', background: '#404040', spacebarenabled:false, cursorborder: ''});

    $("html").niceScroll({styler:"fb",cursorcolor:"#e8403f", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});

// widget tools
    // $('.panel .tools .fa-chevron-down').click(function () {
    //     var el = $(this).parents(".panel").children(".panel-body");
    //     if ($(this).hasClass("fa-chevron-down")) {
    //         $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
    //         el.slideUp(200);
    //     } else {
    //         $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
    //         el.slideDown(200);
    //     }
    // });

// by default collapse widget
//    $('.panel .tools .fa').click(function () {
//        var el = $(this).parents(".panel").children(".panel-body");
//        if ($(this).hasClass("fa-chevron-down")) {
//            $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
//            el.slideUp(200);
//        } else {
//            $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
//            el.slideDown(200); }
//    });

    $('.panel .tools .fa-times').click(function () {
        $(this).parents(".panel").parent().remove();
    });


//    tool tips
    $('.tooltips').tooltip();

//    popovers
    $('.popovers').popover();


// custom bar chart
//     if ($(".custom-bar-chart")) {
//         $(".bar").each(function () {
//             var i = $(this).find(".value").html();
//             $(this).find(".value").html("");
//             $(this).find(".value").animate({
//                 height: i
//             }, 2000)
//         })
//     }
});
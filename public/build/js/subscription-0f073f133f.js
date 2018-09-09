$(function() {
    $('[data-toggle="tooltip"]').tooltip();
    // localStorage.removeItem('recomended_plan');
    // localStorage.removeItem('first-campaign-created');

    let skip_guide = false;
    if(localStorage.getItem('skip_guide') !== null && ((new Date().getTime()) - localStorage.getItem('skip_guide') < 900000)) skip_guide = true; // if user skiped less then 15 min ago.

    if(localStorage.getItem('recomended_plan') !== null && localStorage.getItem('recomended_plan') != 0 && !skip_guide) {
        let intro = introJs()
            .setOptions({
                'disableInteraction': false,
                'exitOnOverlayClick': false,
                'tooltipPosition': 'auto',
                'positionPrecedence': ['left', 'right', 'bottom', 'top'],
                'showStepNumbers': false,
                'hidePrev': true,
                'hideNext': true,
                'showBullets': false
            })
            .onexit(function() {
                localStorage.setItem('skip_guide', new Date().getTime());
            })
            .addStep({
                element: document.querySelectorAll('#subscription-panel')[0],
                intro: "Now you can choose a convenient plan for you and start your campaign. Be free to contact us with any questions and proposals. <br><br><b>Cheers.</b>",
            }).start();

        localStorage.removeItem('first-campaign-created');

        // $('.subscribe_link').on('click',function(e){
        // 	// var $this = $(this);
        // 	e.preventDefault();
        //     localStorage.setItem('recomended_plan', 0);
        //     window.open(this.href, '_blank');
        //
        //     intro.exit();
        //
        // });


    }


    $('.subscribe_link').on('click',function(e){

        e.preventDefault();
        localStorage.setItem('recomended_plan', 0);
        // intro.exit();

        fscSessiontest.products = [];
        fscSessiontest.products.push({'path' : $(this).data('product'), 'quantity': 1});
        fastspring.builder.tag('referrer', app.user.id);
        fastspring.builder.push(fscSessiontest); // call Library "Push" method to apply the Session Object.
    });

    var fscSessiontest = { //fscSession
        'reset': true,
        'products' : [],
        'country' : null,
        'checkout': true
    };
});

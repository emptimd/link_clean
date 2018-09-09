var Sliders = function () {

    // default sliders
    $("#default-slider").slider();

    // snap inc
    $("#snap-inc-slider").slider({
        value: 50,
        min: 0,
        max: 1000,
        step: 100,
        slide: function (event, ui) {
            $("#snap-inc-slider-amount").text("$" + ui.value);
        }
    });

    $("#snap-inc-slider-amount").text("$" + $("#snap-inc-slider").slider("value"));

    // range slider
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 500,
        values: [75, 300],
        slide: function (event, ui) {
            $("#slider-range-amount").text("$" + ui.values[0] + " - $" + ui.values[1]);
        }
    });

    $("#slider-range-amount").text("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));

    //range max

    $("#slider-range-max").slider({
        range: "max",
        min: 1,
        max: 10,
        value: 2,
        slide: function (event, ui) {
            $("#slider-range-max-amount").text(ui.value);
        }
    });

    $("#slider-range-max-amount").text($("#slider-range-max").slider("value"));

    // range min
    $("#slider-range-min").slider({
        range: "min",
        value: 37,
        min: 1,
        max: 700,
        slide: function (event, ui) {
            $("#slider-range-min-amount").text("$" + ui.value);
        }
    });

    $("#slider-range-min-amount").text("$" + $("#slider-range-min").slider("value"));

    //
    // setup graphic EQ
    $( "#eq > span" ).each(function() {
    // read initial values from markup and remove that
        var value = parseInt( $( this ).text(), 10 );
        $( this ).empty().slider({
            value: value,
            range: "min",
            animate: true,
            orientation: "vertical"
        });
    });

    // bound to select

    var $prices_coditions = $('#prices_coditions');
    var $total_fee = $('.total_fee .total');

    var select = $( "#minbeds" );
    var slider = $( "<div id='slider'></div>" ).insertAfter( select ).slider({
        min: 10,
        max: 30,
        range: "min",
        step: 10,
        value: 10,
        slide: function( event, ui ) {
            select[ 0 ].selectedIndex = ui.value/10 - 1;

            calculate_price();
        }
    });
    select.change(function() {
        slider.slider( "value", (this.selectedIndex + 1) * 10 );

        calculate_price();
    });

    $prices_coditions.on('change',function(){
        calculate_price();
    });

    function calculate_price() {
        var val = parseInt(select.find(':selected').val())/2;
        if($prices_coditions.is(':checked')) val+=20;

        $total_fee.text(val);
    }

    // // vertical slider
    // $("#slider-vertical").slider({
    //     orientation: "vertical",
    //     range: "min",
    //     min: 0,
    //     max: 100,
    //     value: 60,
    //     slide: function (event, ui) {
    //         $("#slider-vertical-amount").text(ui.value);
    //     }
    // });
    // $("#slider-vertical-amount").text($("#slider-vertical").slider("value"));
    //
    // // vertical range sliders
    // $("#slider-range-vertical").slider({
    //     orientation: "vertical",
    //     range: true,
    //     values: [17, 67],
    //     slide: function (event, ui) {
    //         $("#slider-range-vertical-amount").text("$" + ui.values[0] + " - $" + ui.values[1]);
    //     }
    // });
    //
    // $("#slider-range-vertical-amount").text("$" + $("#slider-range-vertical").slider("values", 0) + " - $" + $("#slider-range-vertical").slider("values", 1));


}();
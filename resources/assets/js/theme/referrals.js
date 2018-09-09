$(function() {
    // goto faq page.
    if(location.pathname.includes("/faq")) {
        $('a.faq').click();
    }

    var $chart = $(".sparkline");
    var $data = $chart.data();
    $data.valueSpots = {'0:': $data.spotColor};
    $chart.sparkline(app.new_sales_chart, $data);

    // show events table
    var table = $('#events-table').DataTable({
        iDisplayLength: 25,
        bProcessing: true,
        bAutoWidth: false,
        aaData: app.events,
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 1,2,3,4,5,6 ] }
        ],
        order: [ [0, 'desc'] ]
    });

    $('.show_tab').on('click',function(){
        var $this = $(this);
        if ($this.hasClass('not_processed')){
            $($this.data('table')).DataTable({
                iDisplayLength: 25,
                bProcessing: true,
                bAutoWidth: false,
                sAjaxSource: $this.data('href'),
                sServerMethod: "POST",
                aoColumnDefs: [
                    { "sClass": "center", "aTargets": $this.data('targets') }
                ],
                order: [ [0, 'desc'] ]
            });
            $this.removeClass('not_processed')
        }
    });


    //work with graph
    $('#chart_rebill').not('.active').on('click',function(){
        var $this = $(this);
        if($this.hasClass('active')) return;
        $this.addClass('active').siblings('a.active').removeClass('active');
//            	var $chart = $(".sparkline");
//                var $data = $chart.data();
//                $data.valueSpots = {'0:': $data.spotColor};

        $chart.sparkline(app.rebills_chart, $data);

    });

    //work with graph
    $('#chart_new_sales').on('click',function() {
        var $this = $(this);
        if($this.hasClass('active')) return;
        $this.addClass('active').siblings('a.active').removeClass('active');
        $chart.sparkline(app.new_sales_chart, $data);

    });

    //when whe toggle sidebar menu
    $('.fa-bars').click(function () {
        $chart.sparkline(app.new_sales_chart, $data);
    });


    //push state for faq
    $('.top_wrap > a').on('click',function(){
        var $this = $(this);
        if($this.hasClass('faq')) {
            history.replaceState(null, "faq", "/ref/faq");
        }else {
            history.replaceState(null, "", "/ref");
        }
    });

    // $('[rel="tooltip"]').tooltip();
    var $copy = $('#copy');
    // COPY to clipboard ref link.
    var clipboard = new Clipboard('#copy');
    clipboard.on('success', function(e) {
        $copy.attr('title', 'Copied!');

        $copy.tooltip('show');
        $copy.attr('title', '');
    });
});
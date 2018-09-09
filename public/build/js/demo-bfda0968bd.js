var LaravelElixirBundle = (function (exports) {
'use strict';

function submit(action, method, values) {
    if(action === false) { return; }
    var form = $('<form/>', {
        action: action,
        method: method
    });

    // add csrf token
    form.append($('<input/>', {
        type: 'hidden',
        name: '_token',
        value: $('meta[name="csrf-token"]').attr('content')
    }));

    $.each(values, function() {
        form.append($('<input/>', {
            type: 'hidden',
            name: this.name,
            value: this.value
        }));
    });
    form.appendTo('body').submit();
}




// export function create_submit_form() {
//     return "hello";
// }

var count_errors = 0;
var check_data_interval;

function check_data() {
    if (count_errors > 3) { clearInterval(check_data_interval); return; }

    var campaign_id = $('#custom-data').val();
    $.ajax({
        'url': '/demo/progress',
        'method': 'post',
        'type': 'json',
        statusCode: {
            400: function () {
                count_errors++;
            },
            401: function () {
                count_errors++;
            },
            403: function () {
                count_errors++;
            },
            404: function() {
                count_errors++;
            },
            405: function() {
                count_errors++;
            },
            500: function() {
                count_errors++;
            }
        },
        'data': {'campaign_id' : campaign_id}
    }).done(function(r) {
        if(typeof r !== 'object' || r.error != '')
        {
            count_errors++;
            return;
        }

        if(r.status == 100)
        {
            location.reload();
        } else {
            $('.loading-wrapper .loader-progress').html(r.progress);
        }
    });
}


$(function () {
    $('#give-email').modal({
        backdrop: 'static',
        keyboard: false
    });

    $('#demo').on('submit',function(){
        $.ajax({
            type: 'POST',
            url: location.href+'/subscribe',
            data: { email: $('#demo-email').val() }
        }).done(function() {
            $('#give-email').modal('hide');
            $('#main-content').css('height', 'inherit');
        });
        return false;
    });



    if(!app.is_finished) {
        check_data();
        // refresh every 5 seconds
        check_data_interval = setInterval(check_data, 5000);
    }else {
        // backlinks table
        var table = $('#campaign-table').DataTable({
            bPaginate: false,
            iDisplayLength: 100,
            bProcessing: true,
            bAutoWidth: false,
            aoColumns: [
                { "sTitle": "URL" },
                { "sTitle": "Quality" },
                { "sTitle": "NoFollow" },
                { "sTitle": "Link Trust / Domain Trust" },
                { "sTitle": "Referral Influence" }
                // { "sTitle": "Details" }
            ],
            aaData: app.backlinks,
            fnRender: function(obj) {},
            fnDrawCallback: function(oSettings) {
                $('.disavow_red').parents('tr').addClass('disavow_tr_red');
                $('.sourcer-url-span').parent().each(function() {
                    var $this = $(this);
                    $this.attr('title', $this.text());
                });
            },
            fnInitComplete: function() {},
            aoColumnDefs: [
                { "sClass": "center", "aTargets": [ 1,2,3,4 ] },
                { "sClass": "ellipisis_new", "aTargets": [ 0 ] }
            ]
        });

        if($(window).width() < 770) {
            table.columns([2, 3 ,4]).visible(false);
        }

        var rtimer;
        $(window).on('resize',function(){
            clearTimeout(rtimer);
            rtimer = setTimeout(function() {
                drawChart();
                if($(window).width() < 770) {
                    table.columns([2, 3 ,4]).visible(false);
                }else {
                    table.columns([2, 3 ,4]).visible(true);
                }
            }, 200);
        });
    }


    $('#disavow_file').on('change',function(){
        var $this = $(this);
        $this.parent().submit();
        return false;
    });

    $("#remove_disavow").on('click',function(e){
        e.preventDefault();
        var $this = $(this);

        submit($this.attr('href'), 'POST', [
            { name: '_method', value: 'delete' }
        ]);
    });

    // draw charts
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var chart_data = new google.visualization.DataTable();
        chart_data.addColumn('string', 'Type');
        chart_data.addColumn('number', 'Qty');
        chart_data.addRows(app.pie);

        var options = {
            slices: {
                0: {color: '#8075c4'}, // super
                1: {color: '#a9d86e'}, // good
                2: {color: '#41cac0'}, // medium
                3: {color: '#FCB322'}, // bad
                4: {color: '#ff6c60'}, // spammy
                5: {color: '#2A3542'}  // critical
            },
            fontName: '"Open Sans", sans-serif',
            fontSize: 14,
            sliceVisibilityThreshold: 0.01
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
        chart.draw(chart_data, options);
    }
});

return exports;

}({}));
//# sourceMappingURL=demo.js.map

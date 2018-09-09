var LaravelElixirBundle = (function (exports) {
'use strict';

$(function() {
    //backlinks referrals (domneni na nash domen.), destinations count.
    var id1 = $('#custom-data').val();
    var id2 = $('#custom-data2').val();
    var offset = 0;
    $.ajax({
        type: 'POST',
        url: location.protocol+'//'+location.host+'/ajax/compare',
        data: { campaign_id: id1, campaign_id2: id2, offset: 0 }
    }).done(function( data ) {
        var i = 2;
        for (var prop in data) {
            window["table" + i] = $(("#campaign" + i + "-table")).DataTable({
                bProcessing: true,
                bAutoWidth: false,
                bInfo: false,
                paging: false,
                searching: false,
                lengthChange: false,
                data:data[prop],
                order: [[ 2, 'desc' ]],
                initComplete: function() {
                    $('.sourcer-url-span').parent().each(function() {
                        var $this = $(this);
                        $this.attr('title', $this.text());
                    });
                },
                aoColumnDefs: [
                    { "sClass": "center", "aTargets": [ 1,2,3 ] },
                    { "sClass": "ellipisis_new", "aTargets": [ 0 ] },
                    { "bSortable": false, "aTargets": [ 4 ] }
                ]
            });
            i = '';

        }
    });


    $('.load-more').on('click',function(){
    	var $this = $(this);
        $this.addClass('disabled');
        offset += 15;
    	$.ajax({
    	    type: 'POST',
    	    url: location.protocol+'//'+location.host+'/ajax/compare',
            data: { campaign_id: id1, campaign_id2: id2, offset: offset }
    	}).done(function( data ) {
    	    // console.log(data);
    	    // console.log(data.length);
    	    // console.log(data[id1].length);
    	    // console.log(data[id2].length);
    	    if(data.constructor === Array || Object.keys(data).length < 2) {$this.remove();return;}

            window["table" + ''].rows.add(data[id1]).draw();
            window["table2"].rows.add(data[id2]).draw();
            $this.removeClass('disabled');
    	});
    });

    var rtimer;
    $(window).on('resize',function(){
        clearTimeout(rtimer);
        rtimer = setTimeout(function() {
            drawChart();
        }, 200);
    });

});

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Type');
    data.addColumn('number', 'Qty');
    data.addRows(app.pie);

    var options = {
        slices: {
            0: { color: '#8075c4' }, // super
            1: { color: '#41cac0' }, // medium
            2: { color: '#FCB322' }, // bad
            3: { color: '#2A3542' }  // critical
        },
        fontName: '"Open Sans", sans-serif',
        fontSize: 14,
        //title: 'Backlinks'
        sliceVisibilityThreshold: 0.01
    };


    var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
    chart.draw(data, options);

    data = new google.visualization.DataTable();
    data.addColumn('string', 'Type');
    data.addColumn('number', 'Qty');
    data.addRows(app.pie2);

    chart = new google.visualization.PieChart(document.getElementById('pie_chart_div2'));
    chart.draw(data, options);

}

return exports;

}({}));
//# sourceMappingURL=compare.js.map

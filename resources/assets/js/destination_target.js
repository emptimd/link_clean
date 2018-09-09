import submit from './theme/test'

$(function() {

    $('#campaign-target-table').DataTable({
        iDisplayLength: 100,
        bFilter: false,
        bAutoWidth: false,
        bProcessing: true,
        bServerSide: true,
        sAjaxSource:'/ajax/backlinks',
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "campaign_id", value: $('#custom-data').val() } );
            aoData.push( { name: "target", value: $('#target').val() } );
        },
        fnDrawCallback: function() {
            $('.disavow_red').parents('tr').addClass('disavow_tr_red');
            $('[data-toggle="tooltip"]').tooltip();
        },
        aoColumnDefs: [
            // { "sClass": "center", "aTargets": [ 1,2,3,4,5 ] },
            { "sClass": "ellipisis_new", "aTargets": [ 0 ] },
            { "bSortable": false, "aTargets": [ 10 ] }
        ]
    });


    $('.destination-target').on('click', function(e){
        e.preventDefault();
        var fn = $(this);

        submit(fn.attr('href'), 'post', [
            {name: 'target', value: fn.data('target')}
        ]);
        return false;
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
        sliceVisibilityThreshold: 0.01
    };

    var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
    chart.draw(data, options);
}
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

$(function() {
    $('#destination-table').DataTable({
        iDisplayLength: 100,
        bAutoWidth: false,
        bProcessing: true,
        fnDrawCallback: function() {
            $('.disavow_red').parents('tr').addClass('disavow_tr_red');
            // $('[data-toggle="tooltip"]').tooltip();
            //
        },
        aoColumnDefs: [
            { "sClass": "ellipisis_new", "aTargets": [ 0 ] },
            // { "sClass": "center", "aTargets": [ 1,2,3 ] },
            { "bSortable": false, "aTargets": [ 6 ] },
            { "bSearchable": false, "aTargets": [ 1,2,3,4,5,6 ] }
        ]
    });


    $('.destination-target').on('click', function(e){
        e.preventDefault();
        var fn = $(this);
        submit(window.location.href, 'post', [
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
            // 1: { color: '#a9d86e' }, // good
            1: { color: '#41cac0' }, // medium
            2: { color: '#FCB322' }, // bad
            // 4: { color: '#ff6c60' }, // spammy
            3: { color: '#2A3542' }  // critical
        },
        fontName: '"Open Sans", sans-serif',
        fontSize: 14,
        sliceVisibilityThreshold: 0.01
    };

    var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
    chart.draw(data, options);
}

return exports;

}({}));
//# sourceMappingURL=destination.js.map

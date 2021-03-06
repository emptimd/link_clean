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
    var $body = $('body'),
        $dashboard_table = $('#dashboard-table');

    $dashboard_table.DataTable({
        iDisplayLength: 10,
        bProcessing: true,
        // bServerSide: true,
        bAutoWidth: false,
        sAjaxSource:'/ajax/market',
        "lengthChange" : false,
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "campaign_id", value: $('#custom-data').val() } );
        },
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 0,1,2,3,4 ] },
            { "bSortable": false, "aTargets": [ 4 ] },
            { "bSearchable": false, "aTargets": [ 2,3,4 ] }
        ],
        aaSorting: [[ 3, "desc" ]]
    });


    $body.on('click', '.delete_campaign', function(e){
        e.preventDefault();
        var $this = $(this);

        if(confirm('Are you sure you want to close order: '+$this.data('campaign_url')+'?'))
        {
            submit('/admin/market/'+$this.data('id'), 'POST', [
                { name: '_method', value: 'delete' },
                { name: 'id', value: $this.data('id') }
            ]);
        }
        return false;
    });

});

return exports;

}({}));
//# sourceMappingURL=market.js.map

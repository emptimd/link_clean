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
        bServerSide: true,
        bAutoWidth: false,
        searching: false,
        sAjaxSource:'/ajax/user_check_backlinks',
        "lengthChange" : false,
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "full", value: 0 } );
        },
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 2,3,4 ] },
            { "bSortable": false, "aTargets": [ 4 ] } ],
        // aaSorting: [[ 3, "desc" ]]
    });


    $body.on('click', '.delete_campaign', function(e){
        e.preventDefault();
        var $this = $(this);

        if(confirm('Are you sure you want to delete backlink: '+$this.data('campaign_url')+'?'))
        {
            submit('/user/check_backlinks/'+$this.data('id'), 'POST', [
                { name: '_method', value: 'delete' },
                { name: 'id', value: $this.data('id') }
            ]);
        }
        return false;
    });

    // $('.delete_all').on('click',function(){
    //     if(confirm('Are you sure you want to delete all backlinks?'))
    //     {
    //         submit('/user/check_backlinks/', 'POST', [
    //             { name: '_method', value: 'delete' },
    //             { name: 'campaign_id', value: $('#custom-data').val() }
    //         ]);
    //     }
    // });

    $('.confirm_backlinks').on('click',function(){
    	var $this = $(this);
        $this.addClass('disabled');
        submit('/user/check_backlinks/confirm', 'POST', [
            { name: '_method', value: 'post' } ]);
    });

    $('#disavow_file').on('change',function(){
        var $this = $(this);
        $this.parent().submit();
        return false;
    });

});

return exports;

}({}));
//# sourceMappingURL=user_check_backlinks.js.map

import submit from './theme/test';

$(function() {
    let $body = $('body'),
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
            { "bSortable": false, "aTargets": [ 4 ] },
            // { "bSearchable": false, "aTargets": [ 2,3,4 ] }
        ],
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
            { name: '_method', value: 'post' },
        ]);
    });

    $('#disavow_file').on('change',function(){
        var $this = $(this);
        $this.parent().submit();
        return false;
    });

});

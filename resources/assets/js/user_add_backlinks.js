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
        sAjaxSource:'/ajax/user_add_backlinks',
        "lengthChange" : false,
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "campaign_id", value: $('#custom-data').val() } );
        },
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 2,3,4,5 ] },
            { "bSortable": false, "aTargets": [ 4,5 ] },
            // { "bSearchable": false, "aTargets": [ 2,3,4 ] }
        ],
        aaSorting: [[ 3, "desc" ]]
    });


    $body.on('click', '.delete_campaign', function(e){
        e.preventDefault();
        var $this = $(this);

        if(confirm('Are you sure you want to delete backlink: '+$this.data('campaign_url')+'?'))
        {
            submit('/user/add_backlinks/'+$this.data('id'), 'POST', [
                { name: '_method', value: 'delete' },
                { name: 'id', value: $this.data('id') }
            ]);
        }
        return false;
    });

    $('.delete_all').on('click',function(){
        if(confirm('Are you sure you want to delete all backlinks?'))
        {
            submit('/user/add_backlinks/', 'POST', [
                { name: '_method', value: 'delete' },
                { name: 'campaign_id', value: $('#custom-data').val() }
            ]);
        }
    });

    $('.confirm_backlinks').on('click',function(){
    	var $this = $(this);
        submit('/user/add_backlinks/confirm', 'POST', [
            { name: '_method', value: 'post' },
            { name: 'campaign_id', value: $('#custom-data').val() }
        ]);
    });

    $('#tagsinput').tagsInput({
        // 'onAddTag': function (tag) {
        //     // make ajax call to add tag
        //     $.ajax({
        //         type: 'POST',
        //         url: location.protocol+'//'+location.host+'/tags/',
        //         data: {_method: 'post', 'tag': $(this).val(), backlink: $('#custom_data').val()},
        //     }).done(function( data ) {
        //         console.log(data);
        //     });
        // },
        // 'onRemoveTag': function (tag) {
        //     // make ajax call to remove tag
        //     $.ajax({
        //         type: 'POST',
        //         url: location.protocol+'//'+location.host+'/tags/',
        //         data: {_method: 'delete', 'tag': $(this).val(), backlink: $('#custom_data').val()},
        //     }).done(function( data ) {
        //         console.log(data);
        //     });
        // },
        'maxChars': 10,
        // defaultText:'add a tag',
        maxTags: 3,
    });

});

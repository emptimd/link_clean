$(function() {
    $('#refs-table').DataTable({
        iDisplayLength: 100,
        bInfo : true,
        bServerSide: true,
        bProcessing: true,
        bAutoWidth: false,
        sAjaxSource:'/ajax/refs',
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "campaign_id", value: $('#custom-data').val() } );
        },
        // fnDrawCallback: function() {
        //     $('[data-toggle="tooltip"]').tooltip()
        // },
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 1,2,3,4 ] },
            { "bSortable": false, "aTargets": [ 1,2,3,4,5 ] }
        ]
    });


});

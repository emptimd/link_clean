$(document).ready(function() {
    $('#client-campaigns-table').DataTable({
        iDisplayLength: 10,
        bProcessing: true,
        bServerSide: true,
        sAjaxSource:'/ajax/campaigns_client',
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "client_id", value: $('#custom-data').val() } );
        },
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 1,2,3 ] },
            { "bSortable": false, "aTargets": [ 1,3 ] }
        ],
        aaSorting: [[ 2, "desc" ]]
    });
});
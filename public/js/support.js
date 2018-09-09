$(document).ready(function() {
    $('#support-table').DataTable({
        iDisplayLength: 10,
        bProcessing: true,
        bAutoWidth: false,
        sAjaxSource:'/ajax/support',
        sServerMethod: "POST",
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 0,1,3,4 ] },
            { "bSortable": false, "aTargets": [ 4 ] },
            { "bSearchable": false, "aTargets": [ 3,4 ] }
        ],
        aaSorting: [[ 0, "desc" ]]
    });
});
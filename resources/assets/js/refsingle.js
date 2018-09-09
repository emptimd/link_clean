$(function() {
    $('#refs-single-table').DataTable({
        iDisplayLength: 100,
        bServerSide: true,
        bProcessing: true,
        bAutoWidth: false,
        sAjaxSource:'/ajax/refsingle',
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "campaign_id", value: $('#custom-data').val() });
            aoData.push( { name: "domain", value: $('#custom-url').val() });
        },
        // fnDrawCallback: function() {
        //     $('[data-toggle="tooltip"]').tooltip()
        // },
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 2,3,4 ] },
            { "bSortable": false, "aTargets": [ 5 ] },
            { "sClass": "ellipisis_new", "aTargets": [ 0 ] }
        ]
    });


});

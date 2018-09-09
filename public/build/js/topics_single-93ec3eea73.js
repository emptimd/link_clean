var LaravelElixirBundle = (function (exports) {
'use strict';

$(function() {
    $('#topics-single-table').DataTable({
        iDisplayLength: 25,
        bFilter: false,
        bPaginate: false,
        bProcessing: true,
        bAutoWidth: false,
        sAjaxSource:'/ajax/topicsSingle',
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "campaign_id", value: $('#custom-data').val() });
            aoData.push( { name: "domain", value: $('#custom-url').val() });
        },
        fnDrawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        },
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 1,2,3,4 ] }
        ]
    });


});

return exports;

}({}));
//# sourceMappingURL=topics_single.js.map

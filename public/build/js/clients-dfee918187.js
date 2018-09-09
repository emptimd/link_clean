var LaravelElixirBundle = (function (exports) {
'use strict';

$(function() {
    $('#client-table').DataTable({
        iDisplayLength: 10,
        bProcessing: true,
        bServerSide: true,
        bAutoWidth: false,
        sAjaxSource:'/ajax/client',
        sServerMethod: "POST"
    });

    var $modal = $('#add-credits');

    // add credits
    $('body').on('click', '.add_credits', function(e){
    	var $this = $(this);
    	e.preventDefault();
        $modal.data('user', $this.data('user'));
        $modal.find('.user_name').text($this.data('name'));

        $('#user').val($this.data('user'));
        $modal.modal('show');
    });


});

return exports;

}({}));
//# sourceMappingURL=clients.js.map

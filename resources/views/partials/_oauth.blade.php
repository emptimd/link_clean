<div class="loading-wrapper oauth-fade" style="opacity: .85"></div>

<div class="modal fade" id="oauth-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-campaign_id="{{ \Session::get('oauth2callback_ci') }}" data-method="{{ $method }}">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Select View</h4>
                </div>
                <div class="modal-body" style="text-align: center">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group field-cat-id">
                                <label class="control-label" for="cat-id">Accounts</label>
                                <select id="cat-id" class="form-control">
                                    <option value="">Select ...</option>
                                </select>
                                <div class="help-block"></div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group field-subcat-id">
                                <label class="control-label" for="subcat-id">Properties</label>

                                <select id="subcat-id" class="form-control" disabled>
                                    <option value="">Select ...</option>
                                </select>

                                <div class="help-block"></div>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group field-demo-prod">
                                <label class="control-label" for="demo-prod">Views</label>

                                <select id="analitycs-view" class="form-control" disabled>
                                    <option value="">Select ...</option>
                                </select>

                                <div class="help-block"></div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a type="button" class="btn btn-danger oauth-ok">Ok</a>

                </div>
            </div>
        </div>
    </div>
</div>

<?php \Session::forget('oauth2callback_ci');?> {{--mb not--}}

@push('pagescript')
<script>
    $(function() {

        var $cat = $('#cat-id'),
            $subCat = $('#subcat-id'),
            $analitycsView = $('#analitycs-view'),
            $modal = $('#oauth-modal');

        // get list of user accaounts.
        $.ajax({
            type: 'POST',
            url: location.protocol+'//'+location.host+'/analitycs/accounts',
        }).done(function( data ) {
            console.log(data);
            $.each(data, function () {
                console.log(this.id);
                console.log(this.name);
                $('#cat-id').append('<option value="'+this.id+'">'+this.name+'</option>');
            });
        });

        $cat.on('change',function(){
        	if(!this.value) return;
        	$.ajax({
        	    type: 'POST',
        	    url: location.protocol+'//'+location.host+'/analitycs/properties/'+this.value,
        	}).done(function( data ) {
                $subCat.prop("disabled", false).empty().append('<option value="">Select ...</option>');
                $analitycsView.prop("disabled", false).empty().append('<option value="">Select ...</option>');
                $.each(data, function () {
                    $subCat.append('<option value="'+this.id+'">'+this.name+'</option>');
                });
        	});
        });

        $subCat.on('change',function(){
            if(!this.value) return;
            var optionSelected = $cat.find("option:selected");

            $.ajax({
                type: 'POST',
                url: location.protocol+'//'+location.host+'/analitycs/views/'+optionSelected.val()+'/'+this.value,//account_id, properties_id
            }).done(function( data ) {
                $analitycsView.prop("disabled", false).empty().append('<option value="">Select ...</option>');
                $.each(data, function () {
                    $analitycsView.append('<option value="'+this.id+'">'+this.name+'</option>');
                });
            });
        });

        $modal.modal('show');
        $modal.on('hide.bs.modal', function (e) {
            $('.oauth-fade').hide();
        });

        $('.oauth-ok').on('click',function(){
            var $this = $(this);
            var optionSelected = $analitycsView.find("option:selected");
            location.href = location.protocol+'//'+location.host+'/campaign/'+$modal.data('campaign_id')+'/'+$modal.data('method')+'/'+optionSelected.val();
        });

    });
</script>
@endpush
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

var count_dash_progress_errors = 0;
var dash_interval;
function dashboard_progres()
{
    if(count_dash_progress_errors > 3) { clearInterval(dash_interval); return; }

    var campaing_ids = [];
    $('.campaign-row.in-progress').each(function(){
        campaing_ids.push($(this).attr('id').replace('campaign-', ''));
    });
    if(campaing_ids.length > 0)
    {
        $.ajax({
            'url': '/ajax/dashboard_progress',
            'method': 'post',
            'type': 'json',
            statusCode: {
                400: function () {
                    count_dash_progress_errors++;
                },
                401: function () {
                    count_dash_progress_errors++;
                },
                403: function () {
                    count_dash_progress_errors++;
                },
                404: function() {
                    count_dash_progress_errors++;
                },
                405: function() {
                    count_dash_progress_errors++;
                },
                500: function() {
                    count_dash_progress_errors++;
                }
            },
            'data': {'campaign_ids' : campaing_ids}
        }).done(function(r) {
            if(typeof r === 'object' && !$.isEmptyObject(r))
            {
                for(var x in r) {
                    if(r[x]['progress'] < 100) { $('#campaign-'+x+' .progress-bar').css('width', r[x]['progress']+'%'); }
                    else
                    {
                        $('#campaign-'+x+' .progress-bar').parent().remove();
                        $('#campaign-'+x+' nobr').prepend(r[x]['buttons']);
                        $('#campaign-'+x).removeClass('in-progress');
                        $('#campaign-'+x+' td:nth-child(5)').text('finished');
                    }
                }
            }
        });
    }
}

$(function() {
    // setTimeout(function() {
    //     debugger;
    // }, 3000);
    // cache jq objects.
    var $body = $('body'),
        $dashboard_table = $('#dashboard-table'),
        $new_campaign_url = $('#new-campaign-url'),
        $new_campaign = $('#new-campaign');

    $dashboard_table.DataTable({
        iDisplayLength: 10,
        bProcessing: true,
        // bServerSide: true,
        bAutoWidth: false,
        sAjaxSource:'/ajax/campaigns',
        "lengthChange" : false,
        // oLanguage: {
        //     sLengthMenu: ,//
        // },
        language: {
            emptyTable: '<a data-toggle="modal" href="#new-campaign" class="btn btn-xs" style="font-size: 15px;"><span class="fa fa-plus" style="margin-right: 5px;"></span>Add you\'r first Campaign</a>'
        },
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "campaign_id", value: $('#custom-data').val() } );
        },
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 0,1,2,3,4,5 ] },
            { "bSortable": false, "aTargets": [ 0,5 ] },
            { "bSearchable": false, "aTargets": [ 0,5 ] }
        ],
        aaSorting: [[ 3, "desc" ]]
    });

    $('.dataTables_wrapper .col-sm-6:first').append("<select name=\"with_selected\" class=\"with_selected form-control input-sm\">\n        <option value=\"none\">With Selected</option>\n        <option class=\"item item--delete\" name=\"delete\" disabled>Delete</option>\n        <option class=\"item item--compare\" name=\"compare\" disabled>Compare</option>\n        <option class=\"item item--recheck\" name=\"recheck\" disabled>Recheck</option>\n    </select>");

    $('.with_selected').on('change',function(){
    	var $this = $(this);
    	var $item = $this.find('.item:selected');
        var $chekboxes = $('.with_selected-item:checked');
        var ids = [];
    	if($item.length === 1) {
            console.log($item);
            $chekboxes.each(function() {
                ids.push($(this).val());
            });
            if($item.is('.item--delete')) { // show delete confirm.
                if(confirm('Are you sure you want to delete campaign'+($chekboxes.length>1?'s':'')+'?'))
                {

                    submit('/campaign/remove_many', 'POST', [
                        { name: '_method', value: 'delete' },
                        { name: 'ids', value: ids }
                    ]);
                }else { $this.val('none'); }
            }

            if($item.is('.item--compare')) {
                location.pathname = '/compare/'+ids[0]+'/'+ids[1];
            }

            if($item.is('.item--recheck')) { // show recheck confirm.
                if(confirm('Are you sure you want to recheck campaign'+($chekboxes.length>1?'s':'')+'?'))
                {

                    submit('/campaign/restart_many', 'POST', [
                        { name: '_method', value: 'post' },
                        { name: 'ids', value: ids }
                    ]);
                }else { $this.val('none'); }
            }
        }
    });

    $dashboard_table.on('change', '.with_selected-item',function(){
    	var $this = $(this);
    	var $chekboxes = $('.with_selected-item:checked');
        // $('.with_selected').val("none");
        if($this.is(':checked')) {
            $('.item--delete').removeAttr('disabled');
            $('.item--recheck').removeAttr('disabled');

            if($chekboxes.length === 2) {
                var finished = 0;
                $chekboxes.each(function() {
                    // console.log( $( this ).parent('td').parent('.finished').length );
                    if($( this ).parent('td').parent('.finished').length) { finished++; }
                });
                if(finished === 2) { $('.item--compare').removeAttr('disabled'); }
            }else {
                $('.item--compare').attr('disabled', true);
            }
        }else {
            if($chekboxes.length < 2) {
                $('.item--compare').attr('disabled', true);
            }

            if($chekboxes.length === 2) {
                var finished$1 = 0;
                $chekboxes.each(function() {
                    if($( this ).parent('td').parent('.finished').length) { finished$1++; }
                });
                if(finished$1 === 2) { $('.item--compare').removeAttr('disabled'); }
            }

            if(!$chekboxes.length) {
                $('.item--delete').attr('disabled', true);
                $('.item--recheck').attr('disabled', true);
            }
        }

    });
    var started_campaigns;

    // $dashboard_table.on('change', '.make-switch' ,function(){
    //     let $input = $(this).find('input');
    //     if(!$input.is(':checked')) {
    //         $.ajax({
    //             type: 'POST',
    //             url: location.protocol+'//'+location.host+'/campaign/'+$input.val()+'/monitor',
    //             data: { to_recheck: 0 }
    //         })
    //     }else {
    //         $.ajax({
    //             type: 'POST',
    //             url: location.protocol+'//'+location.host+'/campaign/'+$input.val()+'/monitor',
    //             data: { to_recheck: 1 }
    //         })
    //     }
    // });


    $dashboard_table.on( 'draw.dt', function () {
        // $('.make-switch').not('.has-boostrap').addClass('has-boostrap')['bootstrapSwitch']();
        started_campaigns = $dashboard_table.find('.campaign-row').length - $('.start_campaign').length;
    });





    // $body.on('click', '.recheck_campaign', function(e) {
    //     var $this = $(this);
    //     e.preventDefault();
    //     var hours = $this.data('hours');
    //     var m72 = $('.m72');
    //     var l72 = $('.l72');
    //
    //     if(hours > 72) {
    //         m72.find('.campaign_url').html($this.data('campaign_url'));
    //         m72.find('.backlinks').html($this.data('backlinks'));
    //         m72.find('.btn-restart').attr('href', location.protocol+'//'+location.host+'/campaign/'+$this.data('campaign_id')+'/restart');
    //         m72.find('.ga-restart').data('campaign_id', $this.data('campaign_id'));
    //         l72.hide();
    //         m72.show();
    //     }else {
    //         l72.find('.hours').html(72-hours);
    //         m72.hide();
    //         l72.show();
    //     }
    //     $('#confirm-recheck').modal('show');
    // });
    //
    // $('.ga-restart').on('click', function(e) {
    //     var $this = $(this);
    //     e.preventDefault();
    //     $.ajax({
    //         type: 'GET',
    //         url: $this.attr('href')
    //     }).done(function() {
    //         location.href = location.protocol+'//'+location.host+'/callback/oauth2callback/'+$this.data('campaign_id');
    //     }).fail(function( data ) {
    //         var errors = JSON.parse(data.responseText);
    //         $('.wrapper').prepend('<div class="alert alert-danger fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>'+errors.error+'</div>');
    //     });
    //
    // });

    $body.on('click', '.delete_campaign', function(e){
        e.preventDefault();
        var $this = $(this);

        if(confirm('Are you sure you want to delete campaign: '+$this.data('campaign_url')+'?'))
        {
            submit('/campaign/'+$this.data('campaign_id'), 'POST', [
                { name: '_method', value: 'delete' },
                { name: 'campaign_id', value: $this.data('campaign_id') }
            ]);
        }

        return false;
    });

    // $body.on('click', '.start_campaign', function(e) {
    //     var $this = $(this);
    //     e.preventDefault();
    //     $.ajax({
    //         type: 'GET',
    //         url: $this.attr('href')
    //     }).done(function() {
    //         $('#confirm-ga').modal('show').find('.btn-ok').attr('href', $this.attr('href'));
    //         $('.btn-ga').attr('href', location.protocol+'//'+location.host+'/callback/oauth2callback/'+$this.data('campaign_id'));
    //     }).fail(function( data ) {
    //         var errors = JSON.parse(data.responseText);
    //         if(errors.error.indexOf('Choose') !=-1) {
    //             localStorage.setItem('error', errors.error);
    //             return location.href = location.protocol+'//'+location.host+'/subscription/';
    //         }
    //         $('.wrapper').prepend('<div class="alert alert-danger fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>'+errors.error+'</div>');
    //     });
    //
    // });

    var f_product = 'backlinkcontrol-d2-plan';
    var f_campaign_id;
    var f_price = '24,99';
    $body.on('click', '.start_campaign', function(e) {
        var $this = $(this);
        e.preventDefault();
        var backlinks_count = $this.data('backlinks_count');
        var trial = '7 days trial';
        f_campaign_id = $this.data('campaign_id');

        /*UPD 2017-10-06. We must check if user has no backlinks, domains, then we show him popup subscription.*/
        $.ajax({
            type: 'GET',
            url: location.protocol+'//'+location.host+'/campaign/'+f_campaign_id+'/start',
        }).done(function( data ) {
            location.href = location.protocol+'//'+location.host+'/campaign/'+f_campaign_id+'/start';
        }).fail(function( data ) {
            console.log(data);
            if(started_campaigns) {
                if(backlinks_count < 5000) {
                    f_product = 'backlinkcontrol-plan';
                    f_price = '9,99';
                }else if(backlinks_count > 5000 && backlinks_count < 50000) {
                    f_product = 'backlinkcontrol-d-plan';
                    f_price = '14,99';
                }
                else if(backlinks_count > 50000 && backlinks_count < 100000) {
                    f_product = 'backlinkcontrol-d2-plan';
                    f_price = '24,99';
                }
                else if(backlinks_count > 100000 && backlinks_count < 200000) {
                    f_product = 'backlinkcontrol-d3-plan';
                    f_price = '39,99';
                    trial = '0 days';
                }
                else if(backlinks_count > 200000 && backlinks_count < 500000) {
                    f_product = 'backlinkcontrol-d4-plan';
                    f_price = '59,99';
                    trial = '0 days';
                }
                else if(backlinks_count > 500000 && backlinks_count < 1000000) {
                    f_product = 'backlinkcontrol-d5-plan';
                    f_price = '99,99';
                    trial = '0 days';
                }
                else/* if(backlinks_count > 1000000 && backlinks_count < 2000000)*/ {
                    f_product = 'backlinkcontrol-d6-plan';
                    f_price = '179,99';
                    trial = '0 days';
                }
            }else {
                // console.log('??');
                if(backlinks_count < 50000)
                    { location.href = location.protocol+'//'+location.host+'/campaign/'+f_campaign_id+'/start'; }
                return;
            }

            $('#custom-data').val($this.data('campaign_id'));
            $('#subscribe-modal').modal('show').find('.price').text(f_price).siblings('.trial').text(trial);
        });

    });

    $('.subscribe-link').on('click',function(e){
        e.preventDefault();
        fscSessiontest.products.push({'path' : f_product, 'quantity': 1});
        var tags = {'referrer' : app.user.id, 'campaign_id' : f_campaign_id, 'scenario': 'dashboard-start-campaign-subscription'};
        fscSessiontest.tags = tags;
        fastspring.builder.push(fscSessiontest); // call Library "Push" method to apply the Session Object.
    });


    $body.on('click', '.select-csv-backlink-types label', function(event) {
        event.stopPropagation();
    });

    $body.on('click', '.select-csv-backlink-types input', function() {
        if(!$(this).is(':checked')) {
            if($('.select-csv-backlink-types :checked').length == 0) {
                $('.download-btn').prop('disabled', true);
            }
        }else {
            $('.download-btn').prop('disabled', false);
        }
    });

    $new_campaign_url.keyup(function(e) {
        var fn = $(this);
        var domain = 'domain';
        if (fn.val() != '') { domain = fn.val(); }
        $('.domain_to_check').text(domain);
        if(e.which == 13) {
            fn.parents('form').submit();
        }
    });

    // focus input
    $new_campaign.on('shown.bs.modal', function () {
        $new_campaign_url.focus();
    });

    $('span.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    // refresh progress bars every 3 sec
    dash_interval = setInterval(dashboard_progres, 3000);

});

return exports;

}({}));
//# sourceMappingURL=dashboard_backlinkcontrol.js.map

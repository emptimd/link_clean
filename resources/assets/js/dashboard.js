import submit from './theme/test';

var count_dash_progress_errors = 0, dash_interval;
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
            'url': '/admin/ajax/dashboard_progress',
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
                    if(r[x]['progress'] < 100) $('#campaign-'+x+' .progress-bar').css('width', r[x]['progress']+'%');
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
    let $body = $('body'),
        $dashboard_table = $('#dashboard-table'),
        $new_campaign_url = $('#new-campaign-url'),
        $new_campaign = $('#new-campaign');

    $dashboard_table.DataTable({
        iDisplayLength: 10,
        bProcessing: true,
        // bServerSide: true,
        bAutoWidth: false,
        sAjaxSource:'/admin/ajax/campaigns',
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

    let ids = [];

    $('.dataTables_wrapper .col-sm-6:first').append(`<select name="with_selected" class="with_selected form-control input-sm">
        <option value="none">With Selected</option>
        <option class="item item--delete" name="delete" disabled>Delete</option>
        <option class="item item--compare" name="compare" disabled>Compare</option>
        <option class="item item--recheck" name="recheck" disabled>Recheck</option>
        <option class="item item--csv" name="csv" disabled>CSV</option>
    </select>`);

    $('.with_selected').on('change',function(){
    	let $this = $(this);
    	let $item = $this.find('.item:selected');
        let $chekboxes = $('.with_selected-item:checked');
        let cids = [];

        for (let i in ids) {
            cids.push(ids[i]);
        }
        // let ids = [];
    	if($item.length === 1) {
            // console.log($item);
            // $chekboxes.each(function() {
            //     ids.push($(this).val());
            // });
            if($item.is('.item--delete')) { // show delete confirm.
                if(confirm('Are you sure you want to delete campaign'+($chekboxes.length>1?'s':'')+'?'))
                {

                    submit('/campaign/remove_many', 'POST', [
                        { name: '_method', value: 'delete' },
                        { name: 'ids', value: cids }
                    ]);
                }else $this.val('none');
            }

            if($item.is('.item--compare')) {
                location.pathname = '/compare/'+cids[0]+'/'+cids[1];
            }

            if($item.is('.item--recheck')) { // show recheck confirm.
                if(confirm('Are you sure you want to recheck campaign'+($chekboxes.length>1?'s':'')+'?'))
                {

                    submit('/campaign/restart_many', 'POST', [
                        { name: '_method', value: 'post' },
                        { name: 'ids', value: cids }
                    ]);
                }else $this.val('none');
            }

            if($item.is('.item--csv')) {
                submit('/admin/csvs', 'POST', [
                    { name: '_method', value: 'post' },
                    { name: 'ids', value: cids }
                ]);
            }
        }
    });

    $dashboard_table.on('change', '.with_selected-item',function(){
        // console.log(213123);
    	let $this = $(this);
    	let $chekboxes = $('.with_selected-item:checked');
        // $('.with_selected').val("none");
        if($this.is(':checked')) {
            ids["id"+$this.val()] = $this.val();
            console.log(ids);

            $('.item--delete').removeAttr('disabled');
            $('.item--recheck').removeAttr('disabled');
            $('.item--csv').removeAttr('disabled');

            if($chekboxes.length === 2) {
                let finished = 0;
                $chekboxes.each(function() {
                    // console.log( $( this ).parent('td').parent('.finished').length );
                    if($( this ).parent('td').parent('.finished').length) finished++;
                });
                if(finished === 2) $('.item--compare').removeAttr('disabled');
            }else {
                $('.item--compare').attr('disabled', true);
            }
        }else {
            delete ids["id"+$this.val()];

            if($chekboxes.length < 2) {
                $('.item--compare').attr('disabled', true);
            }

            if($chekboxes.length === 2) {
                let finished = 0;
                $chekboxes.each(function() {
                    if($( this ).parent('td').parent('.finished').length) finished++;
                });
                if(finished === 2) $('.item--compare').removeAttr('disabled');
            }

            if(!$chekboxes.length) {
                $('.item--delete').attr('disabled', true);
                $('.item--recheck').attr('disabled', true);
                $('.item--csv').attr('disabled', true);
            }
        }

    });

    $new_campaign_url.keyup(function(event){
        if(event.keyCode == 13)
            $('#create-campaign-form').submit();
    });

    $new_campaign.find('.btn-default').on('click',function(e){
        e.preventDefault();
    });


    let started_campaigns;

    $dashboard_table.on( 'draw.dt', function () {
        started_campaigns = $dashboard_table.find('.campaign-row').length - $('.start_campaign').length;
    } );



    $body.on('click', '.recheck_campaign', function(e) {
        var $this = $(this);
        e.preventDefault();
        var hours = $this.data('hours');
        var m72 = $('.m72');
        var l72 = $('.l72');

        if(hours > 72) {
            m72.find('.campaign_url').html($this.data('campaign_url'));
            m72.find('.backlinks').html($this.data('backlinks'));
            m72.find('.btn-restart').attr('href', location.protocol+'//'+location.host+'/admin/campaign/'+$this.data('campaign_id')+'/restart');
            m72.find('.ga-restart').data('campaign_id', $this.data('campaign_id'));
            l72.hide();
            m72.show();
        }else {
            l72.find('.hours').html(72-hours);
            m72.hide();
            l72.show();
        }
        $('#confirm-recheck').modal('show');
    });

    $('.ga-restart').on('click', function(e) {
        var $this = $(this);
        e.preventDefault();
        $.ajax({
            type: 'GET',
            url: $this.attr('href')
        }).done(function() {
            location.href = location.protocol+'//'+location.host+'/callback/oauth2callback/'+$this.data('campaign_id');
        }).fail(function( data ) {
            var errors = JSON.parse(data.responseText);
            $('.wrapper').prepend('<div class="alert alert-danger fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>'+errors.error+'</div>');
        });

    });

    $body.on('click', '.delete_campaign', function(e){
        e.preventDefault();
        var $this = $(this);

        if(confirm('Are you sure you want to delete campaign: '+$this.data('campaign_url')+'?'))
        {
            submit('/admin/campaign/'+$this.data('campaign_id'), 'POST', [
                { name: '_method', value: 'delete' },
                { name: 'campaign_id', value: $this.data('campaign_id') }
            ]);
        }

        return false;
    });


    let f_product = 'linkquidator-s-2-plan';
    let f_campaign_id;
    let f_price = '24,99';
    $body.on('click', '.start_campaign', function(e) {
        var $this = $(this);
        e.preventDefault();

        let backlinks_count = $this.data('backlinks_count');
        let trial = '7 days trial';
        f_campaign_id = $this.data('campaign_id');

        /*UPD 2017-10-06. We must check if user has no backlinks, domains, then we show him popup subscription.*/
        $.ajax({
            type: 'GET',
            url: location.protocol+'//'+location.host+'/admin/campaign/'+f_campaign_id+'/start',
        }).done(function( data ) {
            location.href = location.protocol+'//'+location.host+'/campaign/'+f_campaign_id+'/start';
        }).fail(function( data ) {
            console.log(data);
            var errors = JSON.parse(data.responseText);
            // we here cause user dosent have enought resources
            // if its the first big campaign
            if(started_campaigns) {
                if(backlinks_count < 5000) {
                    f_product = 'linkquidator-s-plan';
                    f_price = '9,99';
                }else if(backlinks_count > 5000 && backlinks_count < 50000) {
                    f_product = 'linkquidator-s-1-plan';
                    f_price = '14,99';
                }
                else if(backlinks_count > 50000 && backlinks_count < 100000) {
                    f_product = 'linkquidator-s-2-plan';
                    f_price = '24,99';
                }
                else if(backlinks_count > 100000 && backlinks_count < 200000) {
                    f_product = 'linkquidator-s-3-plan';
                    f_price = '39,99';
                    trial = '0 days';
                }
                else if(backlinks_count > 200000 && backlinks_count < 500000) {
                    f_product = 'linkquidator-s-4-plan';
                    f_price = '59,99';
                    trial = '0 days';
                }
                else if(backlinks_count > 500000 && backlinks_count < 1000000) {
                    f_product = 'linkquidator-s-5-plan';
                    f_price = '99,99';
                    trial = '0 days';
                }
                else/* if(backlinks_count > 1000000 && backlinks_count < 2000000)*/ {
                    f_product = 'linkquidator-s-6-plan';
                    f_price = '179,99';
                    trial = '0 days';
                }
            }else {
                // console.log('??');
                if(backlinks_count < 50000)
                    location.href = location.protocol+'//'+location.host+'/admin/campaign/'+f_campaign_id+'/start';
                return;
            }

            $('#custom-data').val($this.data('campaign_id'));
            $('#subscribe-modal').modal('show').find('.price').text(f_price).siblings('.trial').text(trial);
        });
    });

    $('.subscribe-link').on('click',function(e){
        e.preventDefault();
        fscSessiontest.products.push({'path' : f_product, 'quantity': 1});
        let tags = {'referrer' : app.user.id, 'campaign_id' : f_campaign_id, 'scenario': 'dashboard-start-campaign-subscription'};
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
        if (fn.val() != '') domain = fn.val();
        $('.domain_to_check').text(domain);
        if(e.which == 13) {
            fn.parents('form').submit();
        }
    });

    $new_campaign.on('show.bs.modal', function (e) {
        if(typeof intro_js !== 'undefined') {
            e.preventDefault();
            e.stopPropagation();
            intro_js.goToStep(2);
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

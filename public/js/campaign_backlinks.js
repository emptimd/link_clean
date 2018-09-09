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

$(function() {

    $('.fa-bars').on('click',function(){
        $(window).trigger('resize');
    });



    $('.condition').on('click',function(){
        var $this = $(this);
        if($this.hasClass('active')) {
            $this.find('i').removeClass('fa-minus').addClass('fa-plus');
            $this.next().fadeOut();
        }else {
            $this.find('i').removeClass('fa-plus').addClass('fa-minus');
            $this.next().fadeIn();
        }

        $this.toggleClass('active');
    });

    $('.show-filters').on('click',function(){
    	$('.search-heading').stop().slideToggle();
    });

    var filter = false;

    var table = $('#campaign-table').DataTable({
        iDisplayLength: 100,
        // paging:   false,
        // bPaginate: false,
        searching: false,
        bProcessing: true,
        bServerSide: true,
        bAutoWidth: false,
        sAjaxSource:'/ajax/backlinks',
        sServerMethod: "POST",
        fnServerParams: function ( aoData ) {
            aoData.push( { name: "filter", value: filter } );

            aoData.push( { name: "campaign_id", value: $('#custom-data').val() } );
            aoData.push( { name: "nofollow", value: $('#nofollow-data').is(':checked') } );
            aoData.push( { name: "404", value: $('#404-data').is(':checked') } );
            aoData.push( { name: "redirects", value: $('#redirects-data').is(':checked') } );

            /*new*/
            aoData.push( { name: "url", value: $('#url-data').val() } );
            aoData.push( { name: "ip", value: $('#ip-data').val() } );
            aoData.push( { name: "anchor", value: $('#anchor-data').val() } );
            aoData.push( { name: "date", value: $('#date-data').val() } );

            /*from-to*/
            aoData.push( { name: "dtf_from", value: $('#dtf-from').val() } );
            aoData.push( { name: "dtf_to", value: $('#dtf-to').val() } );
            aoData.push( { name: "dcf_from", value: $('#dcf-from').val() } );
            aoData.push( { name: "dcf_to", value: $('#dcf-to').val() } );

            aoData.push( { name: "ri_from", value: $('#ri-from').val() } );
            aoData.push( { name: "ri_to", value: $('#ri-to').val() } );

            aoData.push( { name: "traffic_from", value: $('#traffic-from').val() } );
            aoData.push( { name: "traffic_to", value: $('#traffic-to').val() } );
            aoData.push( { name: "sr_from", value: $('#sr-from').val() } );
            aoData.push( { name: "sr_to", value: $('#sr-to').val() } );

            aoData.push( { name: "tags", value: $('#tagsinput').val() } );

        },
        fnDrawCallback: function() {
            $('.disavow_red').parents('tr').addClass('disavow_tr_red');
            $('.sourcer-url-span').parent().each(function() {
                var $this = $(this);
                $this.attr('title', $this.text());
            });

            var tags = $('.source-url');

            $.each($('.disavowed-1'), function (index, item) {
                var $this = $(item);
                $this.after("<i class=\"fa fa-minus-circle tag-disavowed\" title=\"disavowed\" aria-hidden=\"true\"></i>");
            });

            $.each($('.paid-1'), function (index, item) {
                var $this = $(item);
                $this.after("<i class=\"fa fa-money tag-paid\" title=\"paid\" aria-hidden=\"true\"></i>");
            });

            $.each(tags, function (index, item) {
                var $this = $(item);
                var dtags = $this.data('tags');
                if(dtags) {
                    $this.after(("<a class=\"fa fa-info-circle tags-info\" data-toggle=\"popover\" data-placement=\"left\" title=\"Backlink Tags\" data-content=\"" + dtags + "\"></a>"));
                }
            });

            $('.tags-info').popover();

        },
        aoColumnDefs: [
            { "sClass": "center", "aTargets": [ 1,2,3,4,5,6,7,8,9,10 ] },
            { "sClass": "ellipisis_new", "aTargets": [ 0 ] },
            { "bSortable": false, "aTargets": [ 10 ] }
        ]
    });


    $('.filter-backlinks').on('change',function(){
        filter = true;
        table.ajax.reload();
    });

    $('#tagsinput').tagsInput({
        'onAddTag': function () {
            filter = true;
            table.ajax.reload();
        },
        'onRemoveTag': function () {
            table.ajax.reload();
        },
        'maxChars': 50
    });

    table.on('click', '.tr-disabled-1 .details', function(e){
        e.preventDefault();
        // var $this = $(this);
        $('#subscribe-modal').modal('show');
    });

    // $('.search-heading').hide();

    // $('#confirm-delete').on('show.bs.modal', function(e) {
    //     alert($(e.relatedTarget).data('href'));
    // });

    function check_data() {
        var campaign_id = $('#custom-data').val();
        $.ajax({
            'url': '/ajax/not_finished_campaign_progress',
            'method': 'post',
            'type': 'json',
            'data': {'id' : campaign_id}
        }).done(function(r) {
            if(typeof r === 'object' && r.error != '')
            {
                if(r.status == 100)
                {
                    location.reload();
                } else {
                    $('.loading-wrapper .loader-progress').html(r.progress);
                }
            }
        });
    }

    //ajax progress bar
    if(!app.is_finished) {
        check_data();
        setInterval(check_data, 5000);
    }

    if($(window).width() < 770) {
        table.columns([2, 3 ,4]).visible(false);
    }

    $('#disavow_file').on('change',function(){
    	var $this = $(this);
        $this.parent().submit();
        return false;
    });

    $("#remove_disavow").on('click',function(e){
        e.preventDefault();
    	var $this = $(this);

        submit($this.attr('href'), 'POST', [
            { name: '_method', value: 'delete' }
        ]);
    });

    $('.ga-restart').on('click', function(e) {
        // if(app.user.id !=127) return true;

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


    // Compare Companies.
    // $('.compare-companies-ul a').on('click',function(){
    // 	let $this = $(this);
    //     $this.addClass('selected');
    // });

    var rtimer;
    $(window).on('resize',function(){
        clearTimeout(rtimer);
        rtimer = setTimeout(function() {
            // drawChart();
            if($(window).width() < 770) {
                table.columns([2, 3 ,4, 5]).visible(false);
            }else {
                table.columns([2, 3 ,4, 5]).visible(true);
            }
        }, 200);
    });

});
//
// google.charts.load('current', {'packages':['corechart']});
// google.charts.setOnLoadCallback(drawChart);
//
// function drawChart() {
//
//     var data = new google.visualization.DataTable();
//     data.addColumn('string', 'Type');
//     data.addColumn('number', 'Qty');
//     data.addRows(app.pie);
//
//     var options = {
//         slices: {
//             0: { color: '#8075c4' }, // super
//             1: { color: '#41cac0' }, // medium
//             2: { color: '#FCB322' }, // bad
//             3: { color: '#2A3542' }  // critical
//         },
//         fontName: '"Open Sans", sans-serif',
//         fontSize: 14,
//         //title: 'Backlinks'
//         sliceVisibilityThreshold: 0.01
//     };
//
//
//     var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
//     chart.draw(data, options);
// }

return exports;

}({}));
//# sourceMappingURL=campaign_backlinks.js.map

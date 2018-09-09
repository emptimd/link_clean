import submit from './theme/test'
let campaign_id = $('#custom-data').val();

$(function() {

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

    });//ajax progress bar
    if(!app.is_finished) {
        check_data();
        setInterval(check_data, 5000);
    }


    $('.fa-bars').on('click',function(){
        window.dispatchEvent(new Event('resize'));
    });

    $('.p-team').on('click', '.p-item', function(){
        var $this = $(this);
        if(confirm('Remove '+$this.attr('title')+' from participants?')) {
            $.ajax({
                type: 'POST',
                url: location.protocol+'//'+location.host+'/campaign/remove_participant',
                data: { _method: "DELETE", id: $this.data('id') }
            }).done(function( data ) {
                $this.remove();
            });
        }
    });


    $('#add_participant_form').on('submit',function(e){
        var $this = $(this);
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: location.protocol+'//'+location.host+'/campaign/add_participant',
            data: { campaign_id: campaign_id, email: $('#add_participant_email').val() }
        }).done(function( data ) {
            $('.p-team').append(data);
            $('#add-participant').modal('toggle');
        }).fail(function( data ) {
            var errors = JSON.parse(data.responseText);
            if(!$this.find('.error').length)
                $('#add_participant_email').after('<p class="error" style="color:red; margin-top:10px; margin-left:4px;">'+errors.error+'</p>');
        });
    });



});


function check_data() {
    // var campaign_id = $('#custom-data').val();
    $.ajax({
        'url': '/ajax/not_finished_campaign_progress',
        'method': 'post',
        'type': 'json',
        'data': {'id' : campaign_id}
    }).done(function(r) {
        if(r == 100)
        {
            location.reload();
        } else {
            $('.campaign_percent').html(r+'%');
            $('.progress-bar-success').css('width', r+'%');
        }
    });
}

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Type');
    data.addColumn('number', 'Qty');
    data.addRows(app.pie);

    if($('#pie_chart_div').length) {

    var options = {
        slices: {
            0: { color: '#8075c4' }, // super
            1: { color: '#41cac0' }, // medium
            2: { color: '#FCB322' }, // bad
            3: { color: '#2A3542' }  // critical
        },
        fontName: '"Open Sans", sans-serif',
        fontSize: 14,
        //title: 'Backlinks'
        sliceVisibilityThreshold: 0.01,
        height: 250
    };

    var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
    chart.draw(data, options);

    }


    if($('#pie_chart_div_demo').length) {
        // demo pie chart
        var options = {
            slices: {
                0: { color: '#8075c4' }, // super
                1: { color: '#41cac0' }, // medium
                2: { color: '#FCB322' }, // bad
                3: { color: '#2A3542' }  // critical
            },
            fontName: '"Open Sans", sans-serif',
            fontSize: 14,
            //title: 'Backlinks'
            sliceVisibilityThreshold: 0.01,
            // legend: {position: 'none'},
            chartArea:{left:0,top:10,width:"90%",height:"90%"},
            height: 250
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div_demo'));
        chart.draw(data, options);
    }


    // anchors chart
    let data2 = new google.visualization.DataTable();
    data2.addColumn('string', 'Type');
    data2.addColumn('number', 'Qty');
    data2.addRows(app.anchors);

    options = {
        slices: {
            0: { color: '#3136cb' },
            1: { color: '#7931cb' },
            2: { color: '#c631cb' },
            3: { color: '#cb3183' },
            4: { color: '#cb3136' },
            5: { color: '#cb7931' },
            6: { color: '#cbc631' },
            7: { color: '#00b800' },
            8: { color: '#31cb79' },
            9: { color: '#31cbc6' },
        },
        fontName: '"Open Sans", sans-serif',
        fontSize: 14,
        title: 'Anchors',
        // sliceVisibilityThreshold: 0.01,
        height: 350,
        pieSliceBorderColor:"transparent",
        // width: 500
        legend: 'none'
    };


    chart = new google.visualization.PieChart(document.getElementById('anchors_chart_div'));
    chart.draw(data2, options);

}

let timeoutChart;
$(window).resize(function(){
    clearTimeout(timeoutChart);
    timeoutChart = setTimeout(drawChart(), 200);
});
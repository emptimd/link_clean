<div class="btn-group">
    <form action="{{ url('campaign/'.$campaign->id.'/download') }}" method="POST">
    <button data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-sm" type="button">{{ $btn_name ?? 'csv' }} <span class="caret"></span></button>
        <ul role="menu" class="dropdown-menu select-csv-backlink-types">
            <li>
                <label>
                    <input name="critical" type="checkbox" class="input-mini">
                    <span class="badge bg-inverse">critical</span>
                </label>
            </li>
            {{--<li>--}}
                {{--<label>--}}
                    {{--<input name="spammy" type="checkbox" class="input-mini">--}}
                    {{--<span class="badge bg-important">spammy</span>--}}
                {{--</label>--}}
            {{--</li>--}}
            <li>
                <label>
                    <input name="low" type="checkbox" class="input-mini">
                    <span class="badge bg-warning">low</span>
                </label>
            </li>
            <li>
                <label>
                    <input name="medium" type="checkbox" class="input-mini">
                    <span class="badge bg-info">medium</span>
                </label>
            </li>
            {{--<li>--}}
                {{--<label>--}}
                    {{--<input name="good" type="checkbox" class="input-mini">--}}
                    {{--<span class="badge bg-success">good</span>--}}
                {{--</label>--}}
            {{--</li>--}}
            <li>
                <label>
                    <input name="high" type="checkbox" class="input-mini">
                    <span class="badge bg-primary">high</span>
                </label>
            </li>
            <li class="divider"></li>
            <li class="text-center">
                <button class="btn btn-xs btn-info download-btn" disabled>Download</button>
            </li>
        </ul>
    </form>

</div>

@push('pagescript')
<script>
    var $body = $('body');
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
</script>
@endpush
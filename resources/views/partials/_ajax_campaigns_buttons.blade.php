<?php
/** @var \App\Models\Campaign $campaign */

$date1 = new \DateTime($campaign->updated_at);
$date2 = new \DateTime();

$diff = $date2->diff($date1);

$hours = $diff->h;
$hours = $hours + ($diff->days*24);

?>
<nobr>

@if($status == 'ready to start')
    <a href="{{ url('campaign/'.$campaign->id).'/start' }}" class="btn btn-success btn-xs start_campaign" data-backlinks_count="{{ $backlinks_count }}" data-campaign_id="{{ $campaign->id }}" data-campaign_url="{{ htmlentities($campaign->url) }}" {{ $campaign->user_id != auth()->id() ? 'disabled' : '' }}><i class="fa fa-play-circle"></i> start</a>
@endif

@if($status == 'in progress')
    <div class="progress progress-striped active progress-sm">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress }}%">
            <span class="sr-only">{{ $progress }}% Complete</span>
        </div>
    </div>
@endif

@if($status == 'finished' || $status == 'Limited' || $status == 'Active' || $status == 'Stoped')
    <div class="btn-group">
        <form action="{{ url('campaign/'.$campaign->id.'/download') }}" method="POST">
            <button data-toggle="dropdown" class="btn btn-info dropdown-toggle btn-xs" type="button">csv <span class="caret"></span></button>
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

    <a class="btn btn-info btn-xs recheck_campaign" data-campaign_id="{{ $campaign->id }}" data-campaign_url="{{ htmlentities($campaign->url) }}" data-hours="{{ $hours }}" data-backlinks=" {{ $backlinks_count }}" title="recheck" {{ $campaign->user_id != auth()->id() ? 'disabled' : '' }}><i class="fa fa-refresh"></i></a>
@endif

@if($status != 'in progress')
    <a href="{{ url('campaign/'.$campaign->id) }}" class="btn btn-danger btn-xs delete_campaign" data-campaign_id="{{ $campaign->id }}" data-campaign_url="{{ htmlentities($campaign->url) }}" title="delete" {{ $campaign->user_id != auth()->id() ? 'disabled' : '' }}><i class="fa fa-trash-o"></i></a>
@endif

</nobr>
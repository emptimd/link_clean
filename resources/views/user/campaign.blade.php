<?php
$date1 = new DateTime($campaign->updated_at);
$date2 = new DateTime();

$diff = $date2->diff($date1);

$hours = $diff->h;
$hours = $hours + ($diff->days*24);

if($analitycs) {
    $total_traffic = $analitycs->users_organic+$analitycs->users_referral+$analitycs->users_social;
}
?>

@extends('layouts.main')

@section('content')
    <div class="row state-overview">
        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                <div class="symbol green">
                    <i class="fa fa-chain"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        <span style="position: relative;">
                        {{ number_format($totals->total) }}
                            @if($totals->total_diff > 0)
                                <span class="badge bg-success" style="position: absolute;top: 20px;z-index: 100;margin-left: 5px;">+{{ $totals->total_diff }}</span>
                            @elseif($totals->total_diff < 0)
                                <span class="badge bg-important" style="position: absolute;top: 20px;z-index: 100;margin-left: 5px;">{{ $totals->total_diff }}</span>
                            @endif
                        </span>
                    </h1>
                    <p>Total Backinks</p>
                </div>
            </section>
        </div>

        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                <div class="symbol yellow">
                    <i class="fa fa-chain-broken"></i>
                </div>
                <div class="value">
                    <h1 class=" count2">
                        <span style="position: relative;">
                        {{ number_format($totals->suspicios) }}
                            @if($totals->suspicios_diff > 0)
                                <span class="badge bg-important" style="position: absolute;top: 20px;z-index: 100;margin-left: 5px;">+{{ $totals->suspicios_diff }}</span>
                            @elseif($totals->suspicios_diff < 0)
                                <span class="badge bg-success" style="position: absolute;top: 20px;z-index: 100;margin-left: 5px;">{{ $totals->suspicios_diff }}</span>
                            @endif
                        </span>
                    </h1>
                    <p>Suspicious Backlinks</p>
                </div>
            </section>
        </div>

        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                <div class="symbol red">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        <span style="position: relative;">
                        {{ number_format($totals->penalty_risk) }}%
                            @if($totals->penalty_risk_diff > 0)
                                <span class="badge bg-important" style="position: absolute;top: 20px;z-index: 100;margin-left: 5px;">+{{ number_format($totals->penalty_risk_diff) }}</span>
                            @elseif($totals->penalty_risk_diff < 0)
                                <span class="badge bg-success" style="position: absolute;top: 20px;z-index: 100;margin-left: 5px;">{{ number_format($totals->penalty_risk_diff) }}</span>
                            @endif
                        </span>

                    </h1>
                    <p>Penalty Risk</p>
                </div>
            </section>
        </div>

    </div>


    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <section class="panel campaign-info">
                <div class="bio-graph-heading project-heading">
                    <strong> {{ $campaign->url }} </strong>
                </div>
                <div class="panel-body bio-graph-info" style="padding: 14px;">
                    <!--<h1>New Dashboard BS3 </h1>-->
                    <div class="row p-details">
                        <div class="bio-row">
                            <p><span class="bold">Created by </span>: {{ $campaign->author->name }}</p>
                        </div>
                        <div class="bio-row">
                            <p>
                                @if($campaign->is_finished())
                                    <span class="bold">Status </span>: <span class="label label-success">Active</span>
                                @else
                                    <span class="bold">Status </span>: <span class="label label-warning">Processing</span>
                                @endif
                            </p>
                        </div>
                        <div class="bio-row">
                            <p><span class="bold">Created </span>: {{ Carbon\Carbon::parse($campaign->created_at)->format('d-m-Y H:i') }}</p>
                        </div>
                        <div class="bio-row">
                            <p><span class="bold">Last Updated</span>: {{ Carbon\Carbon::parse($campaign->updated_at)->format('d-m-Y H:i') }}</p>
                        </div>
                        <div class="bio-row">
                            <p><span class="bold">Participants </span>:
                                <span class="p-team">
                                    <a title="{{ $campaign->author->name }}"><img alt="image" class="" src="{{ Gravatar::src($campaign->author->email, 30) }}"></a>
                                    @foreach($participants as $participant)
                                        <a title="{{ $participant->name }}" class="p-item" data-id="{{ $participant->pid }}"><img alt="image" class="" src="{{ Gravatar::src($participant->email, 30) }}"></a>
                                    @endforeach
                                </span>
                                <a class="fa fa-plus" style="font-size: 20px;vertical-align: middle;" title="Add participant" data-toggle="modal" href="#add-participant"></a>
                            </p>
                        </div>

                        @if(!$campaign->is_finished())
                            <div class="col-lg-12">
                                <dl class="dl-horizontal p-progress" style="margin-bottom: 5px;text-align: center;">
                                    <dt>Project Completed:</dt>
                                    <dd>
                                        <div class="progress progress-striped active ">
                                            <div style="width: 80%;" class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <small>Project completed in <strong class="campaign_percent">80%</strong>. {{--Remaining close the project, sign a contract and invoice.--}}</small>
                                    </dd>
                                </dl>
                            </div>
                        @else
                            <div class="buttons_panel col-lg-12 col-sm-12">
                                {{--<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#confirm-recheck"><i class="fa fa-refresh"></i>Recheck</a>--}}
                                @include('partials._csv')

                                <a href="{{ url('campaign/'.$campaign->id.'/download_disavow') }}" class="btn btn-success btn-sm">Disavow</a>

                                @if (!$disavow_name)
                                    <form action="{{ url('campaign/'.$campaign->id.'/upload_disavow') }}" method="POST" enctype="multipart/form-data" style="display: inline-block;">
                                        {{ csrf_field() }}
                                        <input type="file" name="disavow_file" id="disavow_file" class="hidden" accept="text/plain">
                                        <label class="btn btn-success btn-sm" for="disavow_file">Upload Disavow</label>
                                    </form>
                                @else
                                    <a id="remove_disavow" href="{{ url('campaign/'.$campaign->id.'/upload_disavow') }}" class="btn btn-danger btn-sm">Remove Disavow</a>
                                @endif

                                <a href="{{ url('user/add_backlinks/'.$campaign->id) }}" class="btn btn-primary btn-sm">Add Backlinks</a>
                            </div>
                        @endif

                    </div>

                </div>
            </section>

            @if($analitycs_b)

                <div class="panel">
                    <div class="panel-body">
                        <div class="bio-chart">
                            <div style="display:inline;width:100px;height:100px;">
                                <input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value="100" data-fgcolor="#e06b7d" data-bgcolor="#e8e8e8">
                            </div>
                        </div>
                        <div class="bio-desk">
                            <h4 class="red">Overal Traffic</h4>
                            <p>{{ $total_traffic }} website views last month</p>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-body">
                        <div class="bio-chart">
                            <div style="display:inline;width:100px;height:100px;">
                                <input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value="{{ number_format($analitycs->users_referral/$total_traffic*100) }}" data-fgcolor="#96be4b" data-bgcolor="#e8e8e8"></div>
                        </div>
                        <div class="bio-desk">
                            <h4 class="green">Referral Traffic</h4>
                            <p>{{ $analitycs->users_referral }} website views last month</p>
                        </div>
                    </div>
                </div>

            @endif

            <section class="panel">
                <header class="panel-heading">
                    Top referrers
                    <span class="pull-right">
                        <a href="{{ url('campaign/'.$campaign->id.'/refs') }}" class="btn btn-xs btn-info">details</a>
                    </span>
                </header>
                <div class="panel-body">
                    <table class="display table table-striped">
                        <tr>
                            <th>Domain</th>
                            <th class="center">Backlinks</th>
                            <th>Avg Rating</th>
                        </tr>
                        @forelse($referal['top'] as $site)
                            <tr>
                                <td>{{ $site->domain }}</td>
                                <td class="center">{{ $site->cnt }}</td>
                                <td>
                                <span class="rating top_refering">
                                      <span class="star @if ($site->avg < 5) full @endif"></span>
                                      <span class="star @if ($site->avg < 20) full @endif"></span>
                                      <span class="star @if ($site->avg < 40) full @endif"></span>
                                      <span class="star @if ($site->avg < 60) full @endif"></span>
                                      <span class="star @if ($site->avg < 80) full @endif"></span>
                                </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3">No refering sites to display.</td></tr>
                        @endforelse
                    </table>
                </div>
            </section>

        </div>

        <div class="col-sm-6">

            <div class="panel">
                <div id="pie_chart_div" style="height: 250px;"></div>
            </div>

            @if($analitycs_b)
                <div class="panel">
                    <div class="panel-body">
                        <div class="bio-chart">
                            <div style="display:inline;width:100px;height:100px;">
                                <input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value="{{ number_format($analitycs->users_organic/$total_traffic*100) }}" data-fgcolor="#4CC5CD" data-bgcolor="#e8e8e8"></div>
                        </div>
                        <div class="bio-desk">
                            <h4 class="terques">Search Traffic</h4>
                            <p>{{ $analitycs->users_organic }} website views last month</p>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <div class="bio-chart">
                            <div style="display:inline;width:100px;height:100px;">
                                <input class="knob" data-width="100" data-height="100" data-displayprevious="true" data-thickness=".2" value="{{ number_format($analitycs->users_social/$total_traffic*100) }}" data-fgcolor="#cba4db" data-bgcolor="#e8e8e8"></div>
                        </div>
                        <div class="bio-desk">
                            <h4 class="purple">Social Traffic</h4>
                            <p>{{ $analitycs->users_social }} website views last month</p>
                        </div>
                    </div>
                </div>
            @endif
            @if($domain_social)
                <aside class="profile-nav alt blue-border campaign-socal-details">
                    <div class="panel">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a tabindex="0"><strong>Social Signals</strong></a></li>
                            <li><a tabindex="0">
                                    <i class="fa fa-facebook"></i> Facebook
                                    <span class="label label-primary pull-right r-activity">{{ number_format($domain_social->facebook) }}</span>
                                </a>
                            </li>
                            <li><a tabindex="0">
                                    <i class="fa fa-linkedin"></i> LinkedIn
                                    <span class="label label-info pull-right r-activity">{{ number_format($domain_social->linkedin) }}</span>
                                </a>
                            </li>
                            <li><a tabindex="0">
                                    <i class="fa fa-pinterest"></i> Pinterest
                                    <span class="label label-danger pull-right r-activity">{{ number_format($domain_social->pinterest) }}</span>
                                </a>
                            </li>
                            <li><a tabindex="0">
                                    <i class="fa fa-google-plus-square"></i> Google+
                                    <span class="label label-default pull-right r-activity">{{ number_format($domain_social->googleplusone) }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>
            @endif
        </div>
    </div>

    @if($analitycs_b)
        <div class="section section--secondary | tablebar">
            <p class="tablebar-group | inputbuttongroup">
                <label for="input-interval" class="inputbuttongroup-label">Change interval</label>
                <select id="input-interval" name="chart-interval" class="chart-select interval">
                    <option value="1" selected="">Last month</option>
                    <option value="3">3 months</option>
                    <option value="6">6 months</option>
                    <option value="12">Last year</option>
                </select>

                <label for="input-traffic" class="inputbuttongroup-label">Traffic Source</label>
                <select id="input-traffic" name="chart-traffic" class="chart-select">
                    <option value="1" selected="">Search Traffic</option>
                    <option value="2">Referral Traffic</option>
                    <option value="3">Social Traffic</option>
                </select>
            </p>
        </div>
        {{-- HIGHT Chart--}}
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto 20px"></div>
        {{-- END HIGHT Chart--}}
    @endif
    <section class="panel">
        <div class="col-sm-3 text-center">
            <div class="after_chart_t">Indexed URL's: {{ $totals->total }}</div>
        </div>
        <div class="col-sm-3 text-center">
            <div class="after_chart_t">Social Engagement Rank: {{ $domain_social->social_rank ?? '?' }}</div>
        </div>
        <div class="col-sm-3 text-center">
            <div class="after_chart_t">Domain Trust Flow: {{ $campaign->trust_flow }}</div>
        </div>
        <div class="col-sm-3 text-center">
            <div class="after_chart_t">Domain Citation Flow: {{ $campaign->citation_flow }}</div>
        </div>

        <div class="clearfix"></div>
    </section>

    {{-- NEW --}}
    <div class="row">
        <div class="col-sm-6">
            <section class="panel">
                <header class="panel-heading">
                    Top Target Pages
                    <span class="pull-right">
                        <a href="{{ url('campaign/'.$campaign->id.'/destination') }}" class="btn btn-xs btn-info">details</a>
                    </span>
                </header>
                <div class="panel-body">
                    <table class="display table table-striped table-fixed">
                        <tr>
                            <th width="70%">Url</th>
                            <th class="center">Backlinks</th>
                        </tr>
                        @forelse($target_pages as $site)
                            <tr>
                                <td title="{{ $site['TargetURL'] }}" style="overflow: hidden;">
                                    {{ $site['TargetURL'] }}
                                </td>
                                <td class="center">
                                    {{ $site['c'] }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2">No suspicious referals to display.</td></tr>
                        @endforelse
                    </table>
                </div>
            </section>
        </div>
        <div class="col-sm-6">
            <section class="panel">
                <header class="panel-heading">
                    Topics
                    <span class="pull-right">
                        <a href="{{ url('campaign/'.$campaign->id.'/topics/'.$campaign->url) }}" class="btn btn-xs btn-info">details</a>
                    </span>
                </header>
                <div class="panel-body">
                    <table class="display table table-striped">
                        <tr>
                            <th>Topic</th>
                            <th>Nr. Links</th>
                            <th class="center">Trust Flow</th>
                        </tr>
                        <?php $i=0;?>
                        @forelse($referal['topic'] as $site)
                            <?php
                            switch($i) {
                                case 1: $class = 'label-info';break;
                                case 2: $class = 'label-danger';break;
                                case 3: $class = 'label-default';break;
                                default: $class = 'label-primary';
                            }
                            $i++;
                            ?>
                            <tr>
                                <td>{{ $site->topic }}</td>
                                <td class="center">{{ $site->links }}</td>
                                <td class="center" style="padding: 0;">
                                    <span class="label {{ $class }} r-activity" style="display: inline-block;">{{ $site->topical_trust_flow }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3">No topics to display.</td></tr>
                        @endforelse
                    </table>
                </div>
            </section>
        </div>
        <div class="clearfix"></div>
        @if($anchors->count())
            <section class="panel" style="margin-left: 15px;margin-right: 15px;">
                <div class="row">
                    <div class="col-sm-4">
                        <div id="anchors_chart_div" style="height: 350px;"></div>
                    </div>
                    <div class="col-sm-8">
                        <div class="table-container">
                            <table class="clean-table">

                                <tbody>
                                <tr>
                                    <th align="center" width="10" rowspan="2">#</th>
                                    <th class="textCell" rowspan="2" width="200">Anchor Text</th>
                                    <th class="intCell" width="140" rowspan="2" colspan="2">Referring Domains</th>
                                    <th class="merged-header" align="center" colspan="3">External Backlinks</th>
                                </tr>
                                <tr>
                                    <th class="intCell" width="60"><span>Total</span></th>
                                    <th class="intCell" width="60"><span>Deleted</span></th>
                                    <th class="intCell" width="60"><span>NoFollow</span></th>
                                </tr>


                                <?php $i=1;foreach($anchors as $anchor):?>
                                <tr>
                                    <td valign="top" align="center">{{ $i }}</td>
                                    <td valign="top" class="anchorText">

                                    <span title="" class="hoverHint popover-marker" aria-haspopup="true"
                                          data-original-title="">{{ $anchor->anchor }}</span>

                                    </td>
                                    <td valign="top" align="center">{{ $anchor->ref_domains }}</td>
                                    <td class="textCell" valign="top" align="right">
                                        <div class="bar"><span class="percentage" style="width: 100%">&nbsp;</span></div>
                                    </td>
                                    <td valign="top" align="center">{{ $anchor->total_links }}</td>
                                    <td class="intCell" valign="top" align="center">{{ $anchor->deleted_links }}</td>
                                    <td class="intCell" valign="top" align="center">{{ $anchor->nofollow_links }}</td>
                                </tr>
                                <?php $i++;endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </section>
        @endif
    </div>
    <!--state overview end-->

    <input type="hidden" id="custom-data" value="{{ $campaign->id }}">

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="Add Participant" role="dialog" tabindex="-1" id="add-participant" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => 'campaign', 'id' => 'add_participant_form']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add new participant</h4>
                </div>
                <div class="modal-body">
                    {!! Form::email('email', '', ['id' => 'add_participant_email', 'class' => 'form-control placeholder-no-fix', 'placeholder' => 'E-mail', 'required']) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::button('Cancel', ['type' => 'submit', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-success', 'name' => 'add_participant_submit', 'id' => 'add_participant_submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal -->
@stop

{{--@push('styles')--}}
{{--@endpush--}}
@push('pagescript')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{!! Html::script(elixir('js/campaign_new.js')) !!}
@if($analitycs_b)
    <script src="https://code.highcharts.com/highcharts.js"></script>
    {!! Html::script(elixir('backlink/js/campaign_ga_backlinkcontrol.js')) !!}
@endif

@endpush
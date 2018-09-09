@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
                <li>{!! link_to('dashboard', 'Dashboard') !!}</li>
                <li>{!! link_to('campaign/'.$campaign->id, $campaign->url) !!}</li>
                <li>{!! link_to('campaign/'.$campaign->id.'/destination', 'Destination analyze') !!}</li>
                <li class="active">{{ $target }}</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>
</div>

    <div class="row state-overview">
        <div class="col-md-6">
            <section class="panel">
                <div class="symbol red">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        {{ number_format($totals->penalty_risk) }}%
                    </h1>
                    <p>Penalty Risk</p>
                </div>
            </section>

            <section class="panel">
                <div class="symbol terques">
                    <i class="fa fa-truck"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        {{ number_format($totals->referral_volume) }}
                    </h1>
                    <p>Total Referral Volume</p>
                </div>
            </section>
        </div>
        <div class="col-md-6">
            <div class="panel">
                <div id="pie_chart_div"></div>
            </div>
            <div class="pull-right">
                <p><a href="{{ url('campaign/'.$campaign->id.'/download_disavow/') }}" data-target="{{ $target }}" class="btn btn-success btn-sm destination-target">Disavow</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        @if($domain_social)
        <aside class="profile-nav alt blue-border col-lg-6">
            <div class="panel">
                <ul class="nav nav-pills nav-stacked">
                    <li><a tabindex="0"><strong>Social Details</strong></a></li>
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

        @if($destination_topic)
        <aside class="profile-nav alt blue-border col-lg-6">
            <div class="panel">
                <ul class="nav nav-pills nav-stacked">
                    <li><a tabindex="0"><strong>Destination Topic</strong></a></li>
                    @foreach($destination_topic as $topic)
                        <li><a tabindex="0">
                                <i class="fa fa-book"></i> {{ $topic['topic'] }}
                                <span class="label label-primary pull-right r-activity">{{ number_format($topic['topical_trust_flow']) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Destination analyze : {{ $target }}
            </header>
            <div class="panel-body">

                <table class="display table table-bordered table-striped table-condensed" id="campaign-target-table">
                    <thead>
                    <tr>
                        <th>URL</th>
                        <th class="center">Quality</th>
                        <th class="center">NoFollow</th>
                        <th class="center">Trust Flow</th>
                        <th class="center">Citation Flow</th>
                        <th class="center">R.Influence</th>
                        <th class="center">Traffic</th>
                        <th class="center">IP</th>
                        <th class="center">S.Rank</th>
                        <th class="center">Date</th>
                        <th class="center">Details</th>
                    </tr>
                    </thead>
                    <colgroup>
                        <col width="100%" />
                    </colgroup>
                </table>

            </div>
        </section>
        </div>
    </div>

    <input type="hidden" id="custom-data" value="{{ $campaign->id }}">
    <input type="hidden" id="target" value="{{ $target }}">

@stop

@push('pagescript')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    {!! Html::script(elixir('js/destination_target.js')) !!}
@endpush
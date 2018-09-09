@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
                <li>{!! link_to('dashboard', 'Dashboard') !!}</li>
                <li>{!! link_to('campaign/'.$campaign->id, $campaign->url) !!}</li>
                <li class="active">Destination analyze</li>
            </ul>
            <!--breadcrumbs end -->
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
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Destination analyze
            </header>
            <div class="panel-body">

                <table class="display table table-bordered table-striped table-condensed" id="destination-table">
                    <thead>
                        <tr>
                            <th>Target</th>
                            <th class="center">Backlinks</th>
                            <th class="center">Social Trust</th>
                            <th class="center">Penalty Risk</th>
                            <th class="center">Referral Volume</th>
                            <th class="center">Traffic</th>
                            <th class="center">Details</th>
                        </tr>
                    </thead>
                    <colgroup>
                        <col width="250px" />
                    </colgroup>
                    <tbody>
                    {{--@TODO make ajax calls for this. cause they may be too big.--}}
                    @forelse($destination as $d)
                        <tr>
                            <td title="{{ $d->TargetURL }}">{{ $d->TargetURL }}</td>
                            <td class="center">{{ $d->count }}</td>
                            <td class="center">{{ number_format($d->social_rank, 2) }}</td>
                            <td class="center">{{ number_format($d->penalty_risk, 2)}}%</td>
                            <td class="center">{{ number_format($d->referral_volume, 2) }}</td>
                            <td class="center">{{ $d->views }}</td>
                            <td class="center"><a data-target="{{ $d->TargetURL }}" class="btn btn-xs destination-target {{ $d->penalty_risk > 50? 'btn-danger': 'btn-info' }}">details</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No Destination URLs found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        </div>
    </div>

    <input type="hidden" id="custom-data" value="{{ $campaign->id }}">
@stop

@push('pagescript')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    {!! Html::script(elixir('js/destination.js')) !!}
@endpush
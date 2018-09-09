@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
                <li>{!! link_to('dashboard', 'Dashboard') !!}</li>
                <li>{!! link_to('campaign/'.$campaign->id, $campaign->url) !!}</li>
                <li class="active">Referral domains</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>

    <div class="row state-overview">
        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                <div class="symbol green">
                    <i class="fa fa-chain"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        {{ number_format($totals->total) }}
                    </h1>
                    <p>Total Backinks</p>
                </div>
            </section>
        </div>
        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                <div class="symbol red">
                    <i class="fa fa-chain-broken"></i>
                </div>
                <div class="value">
                    <h1 class=" count2">
                        {{ number_format($totals->bad) }}
                    </h1>
                    <p>Bad</p>
                </div>
            </section>
        </div>
        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-thumbs-o-up"></i>
                </div>
                <div class="value">
                    <h1 class="average_link_rating count3">
                        <span class="rating">
                          <span class="star @if ($totals->average > 95) full @endif"></span>
                          <span class="star @if ($totals->average > 80) full @endif"></span>
                          <span class="star @if ($totals->average > 60) full @endif"></span>
                          <span class="star @if ($totals->average > 40) full @endif"></span>
                          <span class="star @if ($totals->average > 20) full @endif"></span>
                        </span>
                        {{ number_format($totals->average, 2) }}
                    </h1>
                    <p>Average Link Rating</p>
                </div>
            </section>
        </div>
    </div>
    <!--state overview end-->
</div>

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Referral domains
            </header>
            <div class="panel-body">

                <table class="display table table-striped" id="refs-table">
                    <thead>
                        <tr>
                            <th>Domain</th>
                            <th class="center">Backlinks</th>
                            <th class="center">Domain Trust</th>
                            <th class="center">Social Trust</th>
                            <th class="center">Avg Link Quality</th>
                            <th class="center">Details</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </section>
        </div>
    </div>

    <input type="hidden" id="custom-data" value="{{ $campaign->id }}">
@stop

@push('pagescript')
    {!! Html::script(elixir('js/refs.js')) !!}
@endpush
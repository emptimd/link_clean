@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
                <li>{!! link_to('dashboard', 'Dashboard') !!}</li>
                <li>{!! link_to('campaign/'.$campaign->id, $campaign->url) !!}</li>
                <li>{!! link_to('campaign/'.$campaign->id.'/refs', 'Referral domains') !!}</li>
                <li class="active">{{ $domain }}</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>

    <div class="row state-overview">
        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                <div class="symbol terques">
                    <i class="fa fa-trophy"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        {{ number_format($totals->domain_rank) }}
                    </h1>
                    <p>Domain Trust</p>
                </div>
            </section>
        </div>
        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                <div class="symbol green">
                    <i class="fa fa-chain"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        {{ number_format($totals->count) }}
                    </h1>
                    <p>Domain Backinks</p>
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

    <div class="row">
        {{-- TOPICAL info for this Source Domain --}}
        @if($topics->count())
            <div class="col-lg-12">
                <aside class="profile-nav alt green-border">
                    <div class="panel">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a>
                                    <strong>Domain Link Topics</strong>
                                </a>
                            </li>
                            <li>
                            @foreach($topics as $topic)
                                    <div class="col-sm-{{12/$topics->count()}}" style="padding: 0;">
                                    <a style="display: inline-block; width:100%; padding: 10px">
                                        {{ $topic->topic }}
                                        <span class="label label-primary pull-right r-activity">{{ $topic->topical_trust_flow }}</span>
                                    </a>
                                    </div>
                            @endforeach
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        @endif


        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Referral domains for "{{ $domain }}"
            </header>
            <div class="panel-body">

                <table class="display table table-striped" id="refs-single-table">
                    <thead>
                        <tr>
                            <th>URL</th>
                            <th>Target URL</th>
                            <th class="center">Quality</th>
                            <th class="center">Link Trust / Domain Trust</th>
                            <th class="center">Domain Social Trust</th>
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
    <input type="hidden" id="custom-url" value="{{ $domain }}">
@stop

@push('pagescript')
    {!! Html::script(elixir('js/refsingle.js')) !!}
@endpush
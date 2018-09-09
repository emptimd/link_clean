<?php
    if($totals->total < 5000) {
        $price = '9,99';
        $product = 'linkquidator-s-plan';
    }else {
        $price = '14,99';
        $product = 'linkquidator-s-1-plan';
    }
?>

@extends('layouts.main')

@section('content')
    <style>
        .ellipisis_new {
            overflow: inherit !important;
            overflow-y: visible;
        }

        .tr-disabled-1 {
            background-color: #f2dede !important;
        }
    </style>

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



    <div class="row state-overview">
        <div class="col-sm-6">
            <section class="panel" style="text-align: center;padding: 10px;">
                @include('partials._csv', ['btn_name' => 'Generate CSV'])
            </section>
        </div>

        <div class="col-sm-6">
            <section class="panel" style="text-align: center;padding: 10px;">
                <a href="{{ url('campaign/'.$campaign->id.'/download_disavow') }}" class="@if($campaign->is_demo)disabled @endif btn btn-success btn-sm">Generate Disavow</a>
            </section>
        </div>
    </div>
    <!--state overview end-->
    @if($campaign->is_finished())


    <div class="ha">
        <div class="tt1">
            <input type="text" id="url-data" class="filter-backlinks" placeholder="Search by Url:">
            <button class="btn btn-transparent" style="background: none;"><i class="fa fa-navicon show-filters" aria-hidden="true" style="font-size: 20px;color: #fff;"></i></button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading search-heading" {{--style="display: none;"--}}>
                {{--Backlinks--}}
                {{--<div class="tt1">--}}
                    {{--<input type="text" id="url-data" class="filter-backlinks" placeholder="Search by Url:" required>--}}
                {{--</div>--}}

                {{-- 3 in one row--}}
                <div class="search-container">

                    <input type="text" id="ip-data" class="filter-backlinks" placeholder="Search by IP:">
                    <input type="text" id="anchor-data" class="filter-backlinks" placeholder="Search by Anchor Text:">
                    <input type="date" id="date-data" class="filter-backlinks" placeholder="Search by Data:">
                </div>
                <div class="tt3" style="display: flex;justify-content: space-between;padding: 10px;"><span class="t" style="float:left;">Conditions:</span>
                    <div class="condition-wrapper" style="float:left;position: relative;">
                        <button class="condition btn btn-success"><i class="fa fa-plus"></i> Domain Trust</button>

                        <div class="ww">
                            <input type="number" id="dtf-from" class="filter-backlinks" placeholder="From: 0" min="0" max="100">
                            <input type="number" id="dtf-to" class="filter-backlinks" placeholder="To: 100" min="1" max="100">
                        </div>
                    </div>
                    <div class="condition-wrapper" style="float:left;position: relative;">
                        <button class="condition btn btn-success"><i class="fa fa-plus"></i> Domain Citation</button>

                        <div class="ww">
                            <input type="text" id="dcf-from" class="filter-backlinks" placeholder="From: 0" min="0" max="100">
                            <input type="text" id="dcf-to" class="filter-backlinks" placeholder="To: 100" min="1" max="100">
                        </div>
                    </div>
                    <div class="condition-wrapper" style="float:left;position: relative;">
                        <button class="condition btn btn-success"><i class="fa fa-plus"></i> Referral Influence</button>

                        <div class="ww">
                            <input type="number" id="ri-from" class="filter-backlinks" placeholder="From: 0" step=".01" min="0" max="100">
                            <input type="number" id="ri-to" class="filter-backlinks" placeholder="To: 100" step=".01" min=".01" max="100">
                        </div>
                    </div>
                    <div class="condition-wrapper" style="float:left;position: relative;">
                        <button class="condition btn btn-success"><i class="fa fa-plus"></i> Traffic</button>

                        <div class="ww">
                            <input type="number" id="traffic-from" class="filter-backlinks" placeholder="From: 0" min="0" max="100000">
                            <input type="number" id="traffic-to" class="filter-backlinks" placeholder="To: 100" min="1" max="100000">
                        </div>
                    </div>
                    <div class="condition-wrapper" style="float:left;position: relative;">
                        <button class="condition btn btn-success"><i class="fa fa-plus"></i> Social Rank</button>

                        <div class="ww">
                            <input type="number" id="sr-from" class="filter-backlinks" placeholder="From: 0" step=".01" min="0" max="100">
                            <input type="number" id="sr-to" class="filter-backlinks" placeholder="To" step=".01" min="1" max="100">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <section class="panel" style="margin-top: 15px;">
                    <header class="panel-heading">
                        Tags Filter
                    </header>
                    <div class="panel-body">
                        <input name="tagsinput" id="tagsinput" class="tagsinput filter-backlinks" value="" style="display: none;">
                    </div>
                </section>


                {{--<div class="tag-filter">--}}
                    {{--<label for="tagsinput">Tags Filter</label>--}}
                    {{--<input name="tagsinput" id="tagsinput" class="tagsinput filter-backlinks" value="">--}}
                {{--</div>--}}
            </header>
            <div class="panel-body" style="position: relative;">
                <div style="font-size: 15px;position: absolute;right: 20px;z-index: 10;">
                    <div class="checkbox">
                        <input id="nofollow-data" type="checkbox" class="filter-backlinks" checked>
                        <label for="nofollow-data">
                            No Follow
                        </label>
                    </div>

                    <div class="checkbox">
                        <input id="404-data" type="checkbox" class="filter-backlinks" checked>
                        <label for="404-data">
                            404
                        </label>
                    </div>

                    <div class="checkbox">
                        <input id="redirects-data" type="checkbox" class="filter-backlinks" checked>
                        <label for="redirects-data">
                            Redirects
                        </label>
                    </div>
                </div>


                <table class="display table table-bordered table-striped table-condensed" id="campaign-table">
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
    @endif

    <input type="hidden" id="custom-data" value="{{ $campaign->id }}">

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="Subscribe" role="dialog" tabindex="-1" id="subscribe-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">See All Backlinks details</h4>
                </div>
                <div class="modal-body">
                    <ul class="pull-left" style="font-size: 15px;font-weight: 600;margin: 10px;">
                        <li>Link Audit</li>
                        <li>Link Monitoring</li>
                        <li>Secure Link Building</li>
                        <li>Backlink Planner</li>
                        <li>Link Tracker</li>
                        <li>Backlinks Removal Tool</li>
                    </ul>

                    <div class="pull-right" style="text-align: center;padding: 15px;">
                        <button class="btn btn-info subscribe-link" data-product="{{ $product }}" style="padding: 9px 50px;margin-top: 20px;line-height: 1.3;font-weight: bold;margin-bottom: 10px;">Subscribe {{ $price }}$ <br> <span class="small">14 day trial</span></button>
                        <p class="small" style="font-weight: 400;">By clicking this button, you agree to our <a href="/terms">Terms of use</a></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer" style="text-align: center;font-weight: bold;">
                    <h4 class="modal-title" style="font-weight: bold;">Take Control Over your Backlinks</h4>
                    <a href="/refund-policy">30 day refund</a>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->

@stop

@push('styles')
    <style>
        .search-container {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }
        .search-container input{
            width: 28%;
            padding-left: 5px;
            height: 35px;
        }
        .tt1 {
            text-align: center;
            background: #629bcc;
            padding: 10px;
            border: 1px solid;
            border-bottom: none;
        }

        .search-heading {
            border: 1px solid;
            border-top: 0;
        }

        #url-data {
            width: 28%;
            height: 35px;
            font-size: 16px;
            color: #333;
            border: 1px solid #777;
            outline: none;
            padding-left: 5px;
        }



        .condition-wrapper {
            margin-left: 10px;
        }
        .ww {
            width: 200px;
            margin-left: -20px;
            margin-top: 5px;
            position: absolute;
            display: none;
        }

        .ww input {
            width: 85px;
            height: 25px;
        }

        /* STYLED CHECKBOXES*/
        .checkbox {
            padding-left: 20px;
            display: inline-block; }
        .checkbox label {
            display: inline-block;
            position: relative;
            padding-left: 5px; }
        .checkbox label::before {
            content: "";
            display: inline-block;
            position: absolute;
            width: 17px;
            height: 17px;
            left: 0;
            margin-left: -20px;
            border: 1px solid #cccccc;
            border-radius: 3px;
            background-color: #fff;
            -webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
            -o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
            transition: border 0.15s ease-in-out, color 0.15s ease-in-out; }
        .checkbox label::after {
            display: inline-block;
            position: absolute;
            width: 16px;
            height: 16px;
            left: 0;
            top: 0;
            margin-left: -20px;
            padding-left: 3px;
            padding-top: 1px;
            font-size: 11px;
            color: #555555; }
        .checkbox input[type="checkbox"] {
            opacity: 0; }
        .checkbox input[type="checkbox"]:focus + label::before {
            outline: thin dotted;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px; }
        .checkbox input[type="checkbox"]:checked + label::after {
            font-family: 'FontAwesome';
            content: "\f00c"; }
        .checkbox input[type="checkbox"]:disabled + label {
            opacity: 0.65; }
        .checkbox input[type="checkbox"]:disabled + label::before {
            background-color: #eeeeee;
            cursor: not-allowed; }
        .checkbox.checkbox-circle label::before {
            border-radius: 50%; }
        .checkbox.checkbox-inline {
            margin-top: 0; }

        .checkbox-primary input[type="checkbox"]:checked + label::before {
            background-color: #428bca;
            border-color: #428bca; }
        .checkbox-primary input[type="checkbox"]:checked + label::after {
            color: #fff; }

        .checkbox-danger input[type="checkbox"]:checked + label::before {
            background-color: #d9534f;
            border-color: #d9534f; }
        .checkbox-danger input[type="checkbox"]:checked + label::after {
            color: #fff; }

        .checkbox-info input[type="checkbox"]:checked + label::before {
            background-color: #5bc0de;
            border-color: #5bc0de; }
        .checkbox-info input[type="checkbox"]:checked + label::after {
            color: #fff; }

        .checkbox-warning input[type="checkbox"]:checked + label::before {
            background-color: #f0ad4e;
            border-color: #f0ad4e; }
        .checkbox-warning input[type="checkbox"]:checked + label::after {
            color: #fff; }

        .checkbox-success input[type="checkbox"]:checked + label::before {
            background-color: #5cb85c;
            border-color: #5cb85c; }
        .checkbox-success input[type="checkbox"]:checked + label::after {
            color: #fff; }

        .tags-info {
            float: right;
            font-size: 15px;
            color: #53BEE6;
            position: absolute;
            right: 5px;
            top: 7px;
        }

        .tag-paid {
            color: #ff6c60;
            font-size: 15px;
            position: absolute;
            right: 5px;
            top: 7px;
        }

        .tag-disavowed {
            color: #444;
            font-size: 14px;
            position: absolute;
            right: 5px;
            top: 7px;
        }

        .tags-info ~ .tag-paid {
            right: 20px;
        }

        .tags-info ~ .tag-disavowed {
            right: 20px;
        }

        .tag-paid + .tag-disavowed {
            right: 40px;
        }
    </style>
@endpush
@push('pagescript')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    {!! Html::script('theme/js/jquery.tagsinput.js') !!}
    {!! Html::script(elixir('js/campaign_backlinks.js')) !!}

    <script id="fsc-api"
        src="https://d1f8f9xcsvx3ha.cloudfront.net/sbl/0.7.4/fastspring-builder.min.js" type="text/javascript"
        data-storefront="linkquidatorstore<?= auth()->id() == 127?'.test':''?>.onfastspring.com/popup-linkquidatorstore"
        data-popup-closed="onFSPopupClosed"
        data-data-callback="dataCallbackFunction"
        data-error-callback="errorCallback">
    </script>
<script>
    var fscSessiontest = { //fscSession
        'reset': true,
        'products' : [],
        'country' : null,
        'checkout': true
    };

    function onFSPopupClosed(orderReference) {
        if (orderReference) {
            fastspring.builder.reset();
            $('#subscribe-modal').modal('hide');
            setTimeout(function(){location.reload()}, 3000);
        }
    }

    let tags = {'referrer' : app.user.id, 'campaign_id' : $('#custom-data').val(), 'scenario': 'subscribe_demo'};

    $('.subscribe-link').on('click',function(e){
        e.preventDefault();
        fscSessiontest.products.push({'path' : $(this).data('product'), 'quantity': 1});
        fscSessiontest.tags = tags;
        fastspring.builder.push(fscSessiontest); // call Library "Push" method to apply the Session Object.
    });
</script>
@endpush
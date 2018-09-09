<?php
if($analitycs) {
    $total_traffic = $analitycs->users_organic+$analitycs->users_referral+$analitycs->users_social;
}

$product = 'linkquidator-s-plan';
$product_price = '9,99';
if($total_backlinks > 5000 && $total_backlinks <= 50000) {
    $price = '14,99';
    $product = 'linkquidator-s-1-plan';
}elseif($total_backlinks > 50000 && $total_backlinks <= 100000) {
    $price = '24,99';
    $product = 'linkquidator-s-2-plan';
}else if($total_backlinks > 100000 && $total_backlinks < 200000) {
    $product = 'linkquidator-s-3-plan';
    $product_price = '39,99';
}else if($total_backlinks > 200000 && $total_backlinks < 500000) {
    $product = 'linkquidator-s-4-plan';
    $product_price = '59,99';
}else if($total_backlinks > 500000 && $total_backlinks < 1000000) {
    $product = 'linkquidator-s-5-plan';
    $product_price = '99,99';
}else if($total_backlinks > 1000000) {
    $product = 'linkquidator-s-6-plan';
    $product_price = '179,99';
}

$show_ga = 1;
if(session('oauth2callback_ci'))
    $show_ga = 10;
elseif(session('show_ga'))
    $show_ga = (string)Session::get('show_ga');

?>

@extends('layouts.main')

@push('styles')
{!! Html::style('css/style-update.css') !!}
@endpush

@section('content')
    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="overview-hd text-info" title="Estimated risk to get Google sanctions.">Google Penalty Risk
                        <small><i class="fa fa-info-circle text-info" data-toggle="tooltip-bootstrap" data-placement="top"
                                  title="Estimated risk to get Google sanctions."></i></small>
                        <span class="penalty-risk-amount text-danger">{{ number_format($totals->penalty_risk) }}%</span>
                    </h1>
                </div>
                <div class="col-md-6">
                    <div id="pie_chart_div_demo" style="height: 250px;"></div>

                    {{--<canvas id="pieGoogleChart" height="250" width="250" style="width: 250px; height: 250px;"></canvas>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="project-analytic project-analytic-right">
                        <i class="fa fa-cubes text-info"></i> <a class="project-analytic-hd demo-link-disabled" data-toggle="tooltip-bootstrap" data-placement="top"
                                                                 title="Total backlinks count to your website.">Total Links</a>
                        <span class="label label-success">{{ $totals->total }}</span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="project-analytic">
                        <i class="fa fa-link text-warning"></i> <a class="project-analytic-hd demo-link-disabled" data-toggle="tooltip-bootstrap" data-placement="top"
                                                                      title="Links to your site, that can harm your website.">Suspicious links detected</a>
                        <span class="label label-warning">{{ $totals->suspicios }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="project-analytic project-analytic-right">
                        <i class="fa fa-files-o text-danger"></i> <a class="project-analytic-hd demo-link-disabled" data-toggle="tooltip-bootstrap" data-placement="top"
                                                                     title="Page on your site that can be considered to spammy by Penguin algo.">Spammy Pages</a>
                        <span class="label label-danger">{{ $totals->critical }}</span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="project-analytic">
                        <i class="fa fa-ticket text-danger"></i> <span class="project-analytic-hd" data-toggle="tooltip-bootstrap" data-placement="top"
                                                                       title="Estimated risk to get domain penalty">Domain Penalty</span>

                        @if(!(int) $totals->penalty_risk)
                            <span class="label label-success">No Risk</span>
                        @elseif((int) $totals->penalty_risk < 25)
                            <span class="label label-warning">Low Risk</span>
                        @else
                            <span class="label label-danger">High Risk</span>
                        @endif

                    </div>
                </div>
            </div>
            <div class="row row-cleanup-btn">
                <div class="col-md-12">
                    <div class="text-center">

                        @if(!(int) $totals->penalty_risk > 20)
                            <a class="btn btn-lg btn-success demo-link-disabled">Clean Your Backlinks</a>
                        @elseif((int) $totals->penalty_risk < 20 && $totals->critical >= 2)
                            <a class="btn btn-lg btn-success demo-link-disabled">CLEAN MY SPAMMY PAGES</a>
                        @else
                            <a class="btn btn-lg btn-success demo-link-disabled">EXPLORE MY COMPETITOR</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


    @if(\Session::has('oauth2callback_ci'))
        @include('partials._oauth', ['method' => 'start'])
    @endif


    <div class="row">
        {{-- Notice that this is demo campaign --}}
        <div class="clearfix"></div>
        @if($totals->total == 10000)
            <div class="alert alert-warning" style="text-align: center;font-size: 15px;margin: 0 15px 20px 15px;">
                <strong>Attention:</strong> You are using limited demo version. We checked only 10000 backlinks from {{ $total_backlinks }} to your website. Please <a class="full_analyze">activate</a> full analyze or <a href="/subscription">subscribe</a> to use Linkquidator fully.
            </div>
        @else
            <div class="alert alert-warning" style="height: 40px;text-align: center;font-size: 15px;padding-top: 10px;">
                @if($campaign->is_finished())
                    You have used Linkquidator in limited demo mod. Please <a class="demo-link-disabled">subscribe</a> to use Linkquidator fully.
                @else
                    <strong>Attention:</strong> You are using limited demo version. Please <a href="/subscription">subscribe</a> to use Linkquidator fully.
                @endif
            </div>
        @endif
    </div>


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



    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 style="margin-top: 10px;" class="pull-left"><i class="fa fa-exclamation-triangle text-danger"></i> Suspicious Spammy Backlinks</h3>
                    <div class="pull-right panel-heading-right-btn">
                        @include('partials._csv', ['btn_name' => 'csv'])
                        <a href="{{ url('campaign/'.$campaign->id.'/download_disavow') }}" class="btn btn-success btn-sm inline-block">Disavow</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="adv-table">
                        <table class="display table table-bordered table-striped table-condensed" id="campaign-table">
                            <thead>
                            <tr>
                                <th class="ellipisis_new">URL</th>
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
                            <tbody>
                            @foreach($campaign_backlinks as $item)
                                <tr>
                                    <td class="ellipisis_new">{!! $item[0] !!}</td>
                                    @for($i=1; $i < 11; $i++)
                                        <td class="center">{!! $item[$i] !!}</td>
                                    @endfor
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        
                        @if($totals->suspicios > 30)
                            <button class="btn btn-block btn-lg btn-success demo-link-disabled"><i class="fa fa-plus-circle"></i> See {{ $totals->suspicios - 30 }} more backlinks</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Overview: New Blocks -->

    <input type="hidden" id="custom-data" value="{{ $campaign->id }}">
    <input type="hidden" id="show_ga" value="{{ $show_ga }}">

    {{-- Fade background for modal --}}
    <div id="fade-background" style="display: none;background: #000;position: fixed;height: 100%;width: 100%;z-index: 9999;opacity: .3;left: 0;top: 0;right: 0;"></div>

    {{-- MODAL GA --}}
    <div class="modal fade" id="confirm-ga" tabindex="-1" role="dialog" aria-labelledby="confirm-ga-label" aria-hidden="true" style="z-index:10003;">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="confirm-ga-label" style="text-align: center;">Google Analytics Integration</h4>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <p>Do you want to integrate your campaign with Google Analytics?</p>
                        <p>It will make you campaign analyze more complete and accurate.</p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-info btn-ga" href="/callback/oauth2callback/{{ $campaign->id }}">Integrate GA</a>
                        <a class="btn btn-info btn-ok" data-dismiss="modal" aria-hidden="true">Start Campaign without GA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}


    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="Subscribe" role="dialog" tabindex="-1" id="subscribe-modal" class="modal fade" style="z-index:10003;">
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
                        <button class="btn btn-info subscribe-link" style="padding: 9px 50px;margin-top: 20px;line-height: 1.3;font-weight: bold;margin-bottom: 10px;" data-product="{{ $product }}" data-campaign_id="">Subscribe {{ $product_price }}$ <br> <span class="small">14 day trial</span></button>
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

    <!-- Loading Screen -->
    <div id="loadingScreen" class="loading-screen-wrapper" style="display: none;">
        <div class="loading-screen-bg"></div>
        <div class="loading-screen-content">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0">
                        <h2 class="text-center loading-screen-hd">Your analyze will take some minutes!</h2>
                        <div class="progress progress-striped active progress-sm text-center">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                <span class="sr-only">45% Complete</span>
                            </div>
                        </div>
                        <h3 class="loading-screen-hd">So while you are waiting be free to read our tutorials</h3>
                        <div class="text-center info-block-wrapper">
                            <a href="http://example.com" target="_blank" class="btn btn-info inline-block info-block-item">How it works?</a>
                            <a href="http://example.com" target="_blank" class="btn btn-warning inline-block info-block-item">How to use?</a>
                            <a href="http://example.com" target="_blank" class="btn btn-primary inline-block info-block-item">Why I need to clean Backlinks?</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /Loading Screen -->
@stop

@push('pagescript')
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

    $(function() {
        let scenario = 'subscribe_demo';
        $('.full_analyze').on('click',function(){
            $('#fade-background').show();
            $('#subscribe-modal').modal('show').on("hidden.bs.modal", function () {
                $('#fade-background').hide();
            });
            scenario = 'subscribe_demo_restart';
        });

        $('.demo-link-disabled').on('click',function(e){
        	var $this = $(this);
        	e.preventDefault();
            $('#fade-background').show();
            $('#subscribe-modal').modal('show').on("hidden.bs.modal", function () {
                $('#fade-background').hide();
            });
            scenario = 'subscribe_demo';
        });

        let tags = {'referrer' : app.user.id, 'campaign_id' : $('#custom-data').val(), 'scenario': scenario};

        $('.subscribe-link').on('click',function(e){
            e.preventDefault();
            fscSessiontest.products.push({'path' : $(this).data('product'), 'quantity': 1});
            fscSessiontest.tags = tags;
            fastspring.builder.push(fscSessiontest); // call Library "Push" method to apply the Session Object.
        });

        let campaign_demo = {{ $campaign->is_demo }};
        let campaign_stage = {{ $campaign->stage }};
        let show_ga = $('#show_ga').val();
//        console.log(show_ga);
        if(campaign_demo && campaign_stage != 10) {

            // Show progress overlay
            $('#loadingScreen').show();

            if(show_ga !=10) { // Show GA popup
                setTimeout(function () {
                    $('.loading-screen-content').hide();
                    $('#confirm-ga').modal('show').on("hidden.bs.modal", function () {
                        $('.loading-screen-content').show();
                    });
                }, 1000);
            }
        }
    });
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{!! Html::script(elixir('js/campaign_new.js')) !!}


@endpush
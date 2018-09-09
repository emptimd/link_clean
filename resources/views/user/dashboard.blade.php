@extends('layouts.main')

@section('content')
    {{-- MODAL GA --}}
    <div class="modal fade" id="confirm-ga" tabindex="-1" role="dialog" aria-labelledby="confirm-ga-label" aria-hidden="true">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="confirm-ga-label" style="text-align: center;">Integrate with google analitycs</h4>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <p>Do you want to integrate your campaign with Google Analytics?</p>
                        <p>In this case, we can use the data from there in our analysis and report.</p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-info btn-ga">Integrate GA</a>
                        <a class="btn btn-info btn-ok">Start Campaign without GA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}

    @if(\Session::has('oauth2callback_ci'))
        @include('partials._oauth', ['method' => 'start'])
    @endif

    @include('partials._recheck_modal_dashboard')
    @if ($show_info)
        <div class="alert alert-info fade in">
            <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-times"></i>
            </button>
            <strong>Heads up!</strong> You are still not subscribed. To get the full benefit of the Linkquidator service please proceed to <a href="{{ url('subscription') }}">subscription</a> section.
        </div>

        @push('pagescript')
        <script>
            var show_info = 1;
        </script>
        @endpush
    @endif

    @if($totals)
    <div class="row state-overview">
        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                <div class="symbol green">
                    <i class="fa fa-chain"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        {{ number_format($totals['total']) }}
                    </h1>
                    <p>Total Links</p>
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
                        {{ number_format($totals['bad']) }}
                    </h1>
                    <p>Total Bad Links</p>
                </div>
            </section>
        </div>
        <div class="col-lg-4 col-sm-4">
            <section class="panel">
                @if($totals['average'] > 40)
                    <div class="symbol pink">
                        <i class="fa fa-thumbs-o-down"></i>
                    </div>
                @else
                    <div class="symbol blue">
                        <i class="fa fa-thumbs-o-up"></i>
                    </div>
                @endif
                <div class="value">
                    <h1 class="average_link_rating count3">
                        <span class="rating">
                          <span class="star @if ($totals['average'] < 5) full @endif"></span>
                          <span class="star @if ($totals['average'] < 20) full @endif"></span>
                          <span class="star @if ($totals['average'] < 40) full @endif"></span>
                          <span class="star @if ($totals['average'] < 60) full @endif"></span>
                          <span class="star @if ($totals['average'] < 80) full @endif"></span>
                        </span>
                        {{ number_format($totals['average'] , 2) }}
                    </h1>
                    <p>Average Link Rating</p>
                </div>
            </section>
        </div>
    </div>
    <!--state overview end-->
    @endif

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Campaigns
                    <a id="new-campaign-link" data-toggle="modal" href="#new-campaign" class="btn btn-primary btn-xs pull-right" data-intro='<b>Hello !</b> <br><br>To start working with Linkquidator AI, create a new campaign by pressing +New Campaign button.' data-step="1">+ New Campaign</a>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <table class="display table table-bordered table-striped" id="dashboard-table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Campaign</th>
                                <th>Total Backlinks</th>
                                <th>Crawl Date</th>
                                <th>Status</th>
                                {{--<th>Monitoring</th>--}}
                                <th class="hidden-phone">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </div>

    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="New Campaign" role="dialog" tabindex="-1" id="new-campaign" class="modal fade" style="z-index: 9999999 !important;">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => 'admin/campaign', 'id' => 'create-campaign-form']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create new campaign</h4>
                </div>
                <div class="modal-body" data-intro="Please enter domain url for the website you want to analyze first and submit the campaign" data-step="2">
                    <p>Enter URL to check (no http:// or www required):</p>
                    {!! Form::text('url', '', ['id' => 'new-campaign-url', 'class' => 'form-control placeholder-no-fix', 'placeholder' => 'domain name', 'autocomplete' => 'off'/*, 'data-intro' => 'Hello step two!', 'data-step' => 2*/]) !!}
                    <h5>No worries! We will find all links you have<br>
                    <br>we will check:
                        <ol>
                            <li><a>http://<span class="domain_to_check">domain</span></a></li>
                            <li><a>https://<span class="domain_to_check">domain</span></a></li>
                            <li><a>www.<span class="domain_to_check">domain</span></a></li>
                            <li>etc.</li>
                        </ol>
                    </h5>
                    <h4>No bad link will ever hide from us!</h4>
                </div>
                <div class="modal-footer">
                    {!! Form::button('Cancel', ['type' => 'submit', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-success', 'name' => 'create_campaign', 'value' => 1, 'id' => 'create_campaign']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal -->

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
                        <button class="btn btn-info subscribe-link" style="padding: 9px 50px;margin-top: 20px;line-height: 1.3;font-weight: bold;margin-bottom: 10px;" data-product="">Subscribe <span class="price">0</span>$ <br> <span class="small trial">14 day trial</span></button>
                        <p class="small" style="font-weight: 400;">Or choose our other <a href="/subscription">options</a>.</p>
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

    <input type="hidden" id="custom-data" value="">
@stop

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.5.0/introjs.min.css">
@endpush

@push('pagescript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/intro.js/2.5.0/intro.min.js"></script>
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
            location.href = location.protocol+'//'+location.host+'/campaign/'+$('#custom-data').val()+'/start';
        }
    }
</script>

{!! Html::script(elixir('js/dashboard.js')) !!}



@endpush
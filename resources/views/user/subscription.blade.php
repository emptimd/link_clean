@extends('layouts.main')

@section('content')

    <div class="text-center">
        <div id="tab-wrapper">
            <button class="tab active" data-tab="#monthly">Monthly</button>
            <button class="tab" data-tab="#yearly">Yearly</button>
        </div>
        <div class="container">
            <div class="row" style="margin-top: 60px;">
                <div id="monthly" class="tab-container">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php $k = 'linkquidator-webmaster-plan'?>
                        <div class="price-plan-wrapper text-center ready_to_subscribe_normal">
                            <div class="top-wrapper">
                                <img src="{{ url('/landing') }}/images/price-teamwork.png" alt=""
                                     class="center-block img-responsive padding-bottom-10"/>

                                <p class="color-text-heading lato-regular-22 margin-bottom-0">Webmaster</p>
                            </div>
                            <div class="price-wrapper orange @if(isset($plan[$k])) active @endif ">
                                <p class="lato-bold-30 color-text-heading margin-bottom-0" style="position: relative;">
                                    32$
                                </p>

                                <p class="lato-regular-18 color-text ">per month</p>

                                <img src="{{ url('/landing') }}/images/price-line.png" style="max-width: 100%;" alt=""
                                     class="center-block padding-vertically-10"/>

                                <p class="lato-regular-24 color-text-heading margin-bottom-0">3 domains</p>
                                <p class="lato-regular-18 color-text margin-bottom-30">300.000 backlinks</p>

                                @if(isset($plan[$k]))
                                    <a href="/cancel_subscribe/{{ $plan[$k] }}" class="btn btn-orange cancel_subscription">
                                        <span class="lato-bold-18 color-white text-shadow">Cancel</span>
                                    </a>
                                @else
                                    <a class="btn btn-orange subscribe_link" data-product="{{ $k }}"><span
                                                class="lato-bold-18 color-white text-shadow">Choose Plan</span></a>
                                @endif


                            </div>
                        </div>
                    </div>

                    {{--<button class="btn" style="font-size: 13px;padding: 0;background-color:#555;"></button>--}}
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php $k = 'linkquidator-s-plan'?>
                        <div class="price-plan-wrapper green text-center margin-top--40">
                            <form action="" class="custom_domain_form" data-period="month">
                                <div class="top-wrapper">
                                    <img src="{{ url('/landing') }}/images/price-success.png" alt=""
                                         class="center-block img-responsive padding-bottom-10"/>

                                    <p class="color-white lato-regular-22 margin-bottom-0">
                                        <input type="url" required placeholder="Enter your domains" class="custom_domain">
                                    </p>
                                </div>
                                <div class="price-wrapper orange @if(isset($plan[$k])) active @endif ">
                                    <p class="lato-bold-30 color-text-heading margin-bottom-5" style="position: relative;">
                                        <span class="custom_backlinks_price">#</span>$</p>

                                    <p class="lato-regular-18 color-text custom_trial">14 day trial</p>

                                    <img src="{{ url('/landing') }}/images/price-line.png" style="max-width: 100%;" alt=""
                                         class="center-block padding-vertically-10"/>

                                    <p class="lato-regular-24 color-text-heading margin-bottom-0">1 domain</p>
                                    <p class="lato-regular-18 color-text margin-bottom-30"><span class="custom_backlinks_count">#</span> backlinks</p>

                                    @if(isset($plan[$k]))
                                        <a href="/cancel_subscribe/{{ $plan[$k] }}" class="btn btn-green cancel_subscription" data-product="{{ $k }}"><span
                                                    class="lato-bold-18 color-white text-shadow">Cancel</span></a>
                                    @else
                                        <button class="btn btn-green subscribe_link" data-product="{{ $k }}"><span
                                                    class="lato-bold-18 color-white text-shadow">FREE TRIAL</span></button>
                                    @endif


                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php $k = 'linkquidator-corporate-plan'?>
                        <div class="price-plan-wrapper text-center ready_to_subscribe_normal">
                            <div class="top-wrapper">
                                <img src="{{ url('/landing') }}/images/prem8-new2.png" alt=""
                                     class="center-block img-responsive padding-bottom-10"/>

                                <p class="color-text-heading lato-regular-22 margin-bottom-0">Corporate</p>
                            </div>
                            <div class="price-wrapper orange @if(isset($plan[$k])) active @endif ">
                                <p class="lato-bold-30 color-text-heading margin-bottom-0" style="position: relative;">
                                    179$</p>

                                <p class="lato-regular-18 color-text ">per month</p>

                                <img src="{{ url('/landing') }}/images/price-line.png" style="max-width: 100%;" alt=""
                                     class="center-block padding-vertically-10"/>

                                <p class="lato-regular-24 color-text-heading margin-bottom-0">10 domains</p>
                                <p class="lato-regular-18 color-text margin-bottom-30">5 mln. backlinks</p>

                                @if(isset($plan[$k]))
                                    <a href="/cancel_subscribe/{{ $plan[$k] }}" class="btn btn-orange cancel_subscription">
                                        <span class="lato-bold-18 color-white text-shadow">Cancel</span>
                                    </a>
                                @else
                                    <a class="btn btn-orange subscribe_link" data-product="{{ $k }}"><span
                                                class="lato-bold-18 color-white text-shadow">Choose Plan</span></a>
                                @endif

                            </div>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php $k = 'webmaster-plan-linkquidator'?>
                        <div class="price-plan-wrapper text-center">
                            <div class="top-wrapper">
                                <img src="{{ url('/landing') }}/images/price-avatar.png" alt=""
                                     class="center-block img-responsive padding-bottom-10"/>

                                <p class="color-text-heading lato-regular-22 margin-bottom-0">Custom</p>
                            </div>
                            <div class="price-wrapper orange">
                                <p class="lato-bold-30 color-text-heading margin-bottom-0" style="position: relative;">
                                    ∞$

                                <p class="lato-regular-18 color-text ">per month</p>

                                <img src="{{ url('/landing') }}/images/price-line.png" style="max-width: 100%;" alt=""
                                     class="center-block padding-vertically-10"/>

                                <p class="lato-regular-24 color-text-heading margin-bottom-0">∞ domains</p>
                                <p class="lato-regular-18 color-text margin-bottom-30">∞ backlinks</p>

                                <a class="btn btn-orange subscribe_link_custom" data-product="{{ $k }}"><span
                                            class="lato-bold-18 color-white text-shadow">Choose Plan</span></a>

                            </div>
                        </div>
                    </div>
                </div>

                {{--Yearly--}}
                <div id="yearly" class="tab-container" style="display: none;">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php $k = 'linkquidator-webmaster-plan-annual'?>
                        <div class="price-plan-wrapper text-center ready_to_subscribe_normal">
                            <div class="top-wrapper">
                                <img src="{{ url('/landing') }}/images/price-teamwork.png" alt=""
                                     class="center-block img-responsive padding-bottom-10"/>

                                <p class="color-text-heading lato-regular-22 margin-bottom-0">Webmaster</p>
                            </div>
                            <div class="price-wrapper orange @if(isset($plan[$k])) active @endif ">
                                <p class="lato-bold-30 color-text-heading margin-bottom-0" style="position: relative;">
                                    320$
                                </p>

                                <p class="lato-regular-18 color-text ">per year</p>

                                <img src="{{ url('/landing') }}/images/price-line.png" style="max-width: 100%;" alt=""
                                     class="center-block padding-vertically-10"/>

                                <p class="lato-regular-24 color-text-heading margin-bottom-0">3 domains</p>
                                <p class="lato-regular-18 color-text margin-bottom-30">300.000 backlinks</p>

                                @if(isset($plan[$k]))
                                    <a href="/cancel_subscribe/{{ $plan[$k] }}" class="btn btn-orange cancel_subscription">
                                        <span class="lato-bold-18 color-white text-shadow">Cancel</span>
                                    </a>
                                @else
                                    <a class="btn btn-orange subscribe_link" data-product="{{ $k }}"><span
                                                class="lato-bold-18 color-white text-shadow">Choose Plan</span></a>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php $k = 'linkquidator-s-annual-plan'?>
                        <div class="price-plan-wrapper green text-center margin-top--40">
                            <form action="" class="custom_domain_form" data-period="year">
                                <div class="top-wrapper">
                                    <img src="{{ url('/landing') }}/images/price-success.png" alt=""
                                         class="center-block img-responsive padding-bottom-10"/>

                                    <p class="color-white lato-regular-22 margin-bottom-0">
                                        <input type="url" required placeholder="Enter your domains" class="custom_domain">
                                    </p>
                                </div>
                                <div class="price-wrapper orange @if(isset($plan[$k])) active @endif ">
                                    <p class="lato-bold-30 color-text-heading margin-bottom-5" style="position: relative;">
                                        <span class="custom_backlinks_price">#</span>$</p>

                                    <p class="lato-regular-18 color-text custom_trial">14 day trial</p>

                                    <img src="{{ url('/landing') }}/images/price-line.png" style="max-width: 100%;" alt=""
                                         class="center-block padding-vertically-10"/>

                                    <p class="lato-regular-24 color-text-heading margin-bottom-0">1 domain</p>
                                    <p class="lato-regular-18 color-text margin-bottom-30"><span class="custom_backlinks_count">#</span> backlinks</p>

                                    @if(isset($plan[$k]))
                                        <a href="/cancel_subscribe/{{ $plan[$k] }}" class="btn btn-green subscribe_link" data-product="{{ $k }}"><span
                                                    class="lato-bold-18 color-white text-shadow">Cancel</span></a>
                                    @else
                                        <button class="btn btn-green subscribe_link" data-product="{{ $k }}"><span
                                                    class="lato-bold-18 color-white text-shadow">FREE TRIAL</span></button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php $k = 'linkquidator-corporate-anual-plan'?>
                        <div class="price-plan-wrapper text-center ready_to_subscribe_normal">
                            <div class="top-wrapper">
                                <img src="{{ url('/landing') }}/images/prem8-new2.png" alt=""
                                     class="center-block img-responsive padding-bottom-10"/>

                                <p class="color-text-heading lato-regular-22 margin-bottom-0">Corporate</p>
                            </div>
                            <div class="price-wrapper orange @if(isset($plan[$k])) active @endif ">
                                <p class="lato-bold-30 color-text-heading margin-bottom-0" style="position: relative;">
                                    1790$</p>

                                <p class="lato-regular-18 color-text ">per year</p>

                                <img src="{{ url('/landing') }}/images/price-line.png" style="max-width: 100%;" alt=""
                                     class="center-block padding-vertically-10"/>

                                <p class="lato-regular-24 color-text-heading margin-bottom-0">10 domains</p>
                                <p class="lato-regular-18 color-text margin-bottom-30">5 mln. backlinks</p>

                                @if(isset($plan[$k]))
                                    <a href="/cancel_subscribe/{{ $plan[$k] }}" class="btn btn-orange cancel_subscription">
                                        <span class="lato-bold-18 color-white text-shadow">Cancel</span>
                                    </a>
                                @else
                                    <a class="btn btn-orange subscribe_link" data-product="{{ $k }}"><span
                                                class="lato-bold-18 color-white text-shadow">Choose Plan</span></a>
                                @endif

                            </div>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?php $k = 'webmaster-plan-linkquidator'?>
                        <div class="price-plan-wrapper text-center">
                            <div class="top-wrapper">
                                <img src="{{ url('/landing') }}/images/price-avatar.png" alt=""
                                     class="center-block img-responsive padding-bottom-10"/>

                                <p class="color-text-heading lato-regular-22 margin-bottom-0">Custom</p>
                            </div>
                            <div class="price-wrapper orange">
                                <p class="lato-bold-30 color-text-heading margin-bottom-0" style="position: relative;">
                                    ∞$
                                <p class="lato-regular-18 color-text ">per year</p>

                                <img src="{{ url('/landing') }}/images/price-line.png" style="max-width: 100%;" alt=""
                                     class="center-block padding-vertically-10"/>

                                <p class="lato-regular-24 color-text-heading margin-bottom-0">∞ domains</p>
                                <p class="lato-regular-18 color-text margin-bottom-30">∞ backlinks</p>

                                <a class="btn btn-orange subscribe_link_custom" data-product="{{ $k }}"><span
                                            class="lato-bold-18 color-white text-shadow">Choose Plan</span></a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <h2>30 day money back guarantee</h2>

            <h4 style="margin-top: 20px;">No risk. No hidden fees. Cancel at anytime.</h4>
        </div>

    </div>


    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="Subscribe" role="dialog" tabindex="-1" id="custom-s-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => 'subscription/custom_email', 'id' => 'custom-s-modal-form']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Please tell us about your needs!</h4>
                </div>
                <div class="modal-body">
                    <div class="count_wrapper" style="padding: 0 20px;width: 80%;margin: 0 auto;">
                        <div class="form-group">
                            <label for="domains_count">How many domains you need?</label>
                            <input type="number" id="domains_count" name="domains_count" min="1" max="100000" style="width: 75px;">
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label for="backlinks_count">How many backlinks you need?</label>
                            <input type="number" id="backlinks_count" name="backlinks_count" min="1" max="5000000" style="width: 75px;">
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div style="text-align: center;padding: 15px;">
                        Or,
                        <p>Describe your needs in free form</p>

                        <textarea name="description" id="custom-description" cols="30" rows="5" placeholder="Text area" style="width: 80%;"></textarea>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer" style="text-align: center;font-weight: bold;">
                    {!! Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-success', 'name' => 'submit', 'value' => 1, 'id' => 'submit-custom-s-modal-form']) !!}
                    {!! Form::button('Cancel', ['type' => 'submit', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal -->

@stop

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.5.0/introjs.min.css">
<style>
    #tab-wrapper .tab {
        background: #ccc;
        padding: 5px 10px;
        border: 1px solid #ccc;
    }

    #tab-wrapper .tab:hover {
        background: #fff;
    }

    #tab-wrapper .tab.active {
        background: #fff;
    }



    /*subscribe blocks*/
    .lato-bold-30 {
        font-size: 30px;
        line-height: 1.1;
        font-weight: bold;
    }

    .padding-vertically-10 {
        padding: 10px 0;
    }

    .color-text-heading {
        color: #3f3f3f;
        margin-bottom: 0;
    }

    .lato-regular-22 {
        font-size: 22px;
        font-family: Lato,sans-serif;
        font-weight: 400;
        line-height: 2.5;
        color: #3f3f3f;
        margin-bottom: 0;

    }

    .lato-regular-18 {
        font-size: 18px;
        font-family: Lato,sans-serif;
        font-weight: 400;
        color: #8d8d8d;
    }

    .lato-regular-24 {
        font-family: Lato,sans-serif;
        font-weight: 400;
        line-height: 1.1;
        font-size: 24px;
        color: #3f3f3f;
        margin-bottom: 0;
    }

    .margin-bottom-30 {
        margin-bottom: 30px;
    }

    .text-shadow {
        text-shadow: 1px 1px 2px rgba(0,0,0,.45);
    }

    .btn-orange {
        max-width: 100%;
        background: #fe6634;
        -webkit-transition: all ease .3s;
        transition: all ease .3s;
        white-space: normal;
        padding: 10px 40px;
        border-radius: 4px;
        color: #fff !important;
        font-weight: 700;
        font-size: 18px;
        line-height: 1.1;
    }

    .price-plan-wrapper .top-wrapper {
        background-color: #eee;
        padding: 20px 0;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
    }

    .price-plan-wrapper.green {
        margin-top: -40px;
    }

    .price-plan-wrapper.green .top-wrapper {
        background-color: #00d19d;
    }



    .price-plan-wrapper.green .price-wrapper .text-small {
        color: #00d1bb;
        font-size: 14px;
        font-weight: 700;
        font-family: Lato,sans-serif;
    }

    .color-white {
        color: #fff !important;
    }



    .btn-orange:hover {
        background-color: #fe7548;
        border-color: #fe4025;
        box-shadow: inset 0 -4px 0 0 #fe4025;
        -webkit-box-shadow: inset 0 -4px 0 0 #fe4025;
        -moz-box-shadow: inset 0 -4px 0 0 #fe4025;
    }

    .btn-green {
        background: #03e3ab;
        -webkit-transition: all ease .3s;
        transition: all ease .3s;
        white-space: normal;
        padding: 10px 40px;
        border-radius: 4px;
        color: #fff !important;
        font-weight: 700;
        font-size: 18px;
        line-height: 1.1;
    }

    .btn-green:hover {
        background-color: #03f7ba;
        border-color: #039f78;
        box-shadow: inset 0 -4px 0 0 #039f78;
        -webkit-box-shadow: inset 0 -4px 0 0 #039f78;
        -moz-box-shadow: inset 0 -4px 0 0 #039f78;
    }

    .price-plan-wrapper .price-wrapper, .price-plan-wrapper.green {
        border-bottom-right-radius: 6px;
        border-bottom-left-radius: 6px;
    }


    .price-plan-wrapper .price-wrapper {
        padding: 20px 0;
        background-color: #fff;
        box-shadow: 0 7px 30px 0 rgba(0,0,0,.12);
        -webkit-transition: background-color .3s linear;
        transition: background-color .3s linear;
    }

    /*custom*/
    .custom_domain {
        width: 80%;
        height: 40px;
        position: relative;
        top: 10px;
        font-size: 15px;
        padding-left: 10px;
        color: #111;
    }

    @media (max-width: 991px) {
        .price-plan-wrapper.green {
            margin-top: 0;
        }
    }

    .count_wrapper label {
        font-size: 15px;
    }

    .count_wrapper label:nth-of-type(1) {
        float: left;
    }

    .count_wrapper label:nth-of-type(2) {
        margin-top: 5px;
    }


    .count_wrapper input {
        float: right;
    }

    .price-plan-wrapper.green .orange:hover p, .price-plan-wrapper.green .orange:hover span, .green .active p, .green .active span {
        color: #fff;
        -webkit-transition: all .3s ease;
        transition: all .3s ease;
    }

    .price-plan-wrapper .orange:hover, .orange.active {
        background-color: #fe8158;
        -webkit-transition: background-color .3s linear;
        transition: background-color .3s linear;
    }

</style>
@endpush

@push('pagescript')

    <script id="fsc-api"
            src="https://d1f8f9xcsvx3ha.cloudfront.net/sbl/0.7.4/fastspring-builder.min.js" type="text/javascript"
            data-storefront="linkquidatorstore<?= auth()->id() == 127?'.test':''?>.onfastspring.com/popup-linkquidatorstore"
            data-popup-closed="onFSPopupClosed"
            data-data-callback="dataCallbackFunction"
            data-error-callback="errorCallback">
    </script>
    <script>
        var precheck = {};
        let custom_camapign = false;
        var fscSessiontest = { //fscSession
            'reset': true,
            'products' : [],
            'country' : null,
            'checkout': true
        };

        function onFSPopupClosed(orderReference) {
            if (orderReference) {
                fastspring.builder.reset();
                if(custom_camapign) {
                    $.ajax({
                        type: 'POST',
                        url: location.protocol+'//'+location.host+'/subscription/custom_subscription',
                        data: { precheck }
                    }).done(function( data ) {
                        console.log(data.campaign_id);
                        location.href = location.protocol+'//'+location.host+'/campaign/'+data.campaign_id;
                    });
                }else {
                    setTimeout(function(){location.reload()}, 2500);
                }
            }
        }

        $('body').on('click', '.ready_to_subscribe .subscribe_link' ,function(e){
            let $this = $(this);
            e.preventDefault();
            custom_camapign = true;

            let tags = {'referrer' : app.user.id, 'url': $this.data('campaign_url'), 'scenario' : 'custom_campaign'};
            fscSessiontest.tags = tags;
            fscSessiontest.products = [];
            fscSessiontest.products.push({'path' : $this.data('product'), 'quantity': 1});
            fastspring.builder.push(fscSessiontest); // call Library "Push" method to apply the Session Object.
        });

        $('.ready_to_subscribe_normal .subscribe_link').on('click', function(e){
            let $this = $(this);
            e.preventDefault();
            custom_camapign = false;

            let tags = {'referrer' : app.user.id, 'scenario' : 'simple_subscription'};
            fscSessiontest.tags = tags;

            fscSessiontest.products = [];
            fscSessiontest.products.push({'path' : $this.data('product'), 'quantity': 1});
            fastspring.builder.tag('referrer', app.user.id);
            fastspring.builder.push(fscSessiontest); // call Library "Push" method to apply the Session Object.
        });


        $(function() {
            if(localStorage.getItem('error')) {
                $('.wrapper').prepend('<div class="alert alert-danger fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>'+localStorage.getItem('error')+'</div>');
                localStorage.removeItem('error');
            }

            $('.subscribe_link_custom').on('click',function(){
                $('#custom-s-modal').modal('show');
            });

            $('.tab').on('click',function(){
                var $this = $(this);
                $('.tab-container').hide();
                $this.siblings('.tab').removeClass('active');
                let id = $this.addClass('active').data('tab');
                $(id).show();

            });

            $('.custom_domain').on('change',function(){
                var $this = $(this);
                $this.parents('.price-plan-wrapper').removeClass('ready_to_subscribe');
            });

            $('.custom_domain_form').on('submit',function(e){
                var $this = $(this);
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: location.protocol+'//'+location.host+'/subscription/check_domain',
                    data: { url: $this.find('.custom_domain').val(), period : $this.data('period') }
                }).done(function( data ) {
                    precheck = data.item;
                    let $wrapper = $this.parents('.price-plan-wrapper').addClass('ready_to_subscribe');
                    let back_text = data.backlinks;
                    if(parseInt(data.backlinks) > 2000000) {
                        back_text = '2 mln out of '+data.backlinks;
                    }

                    $wrapper.find('.custom_backlinks_count').text(back_text);
                    $wrapper.find('.custom_backlinks_price').text(data.price);
                    $wrapper.find('.custom_trial').text(data.sub_text);
                    $wrapper.find('.subscribe_link').data('product', data.product).data('campaign_url', data.url);

                }).fail(function (data) {
                    console.log('error');
                    console.log(data);
                });
            });
        });
    </script>
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/intro.js/2.5.0/intro.min.js"></script>--}}
    {{--{!! Html::script(elixir('js/subscription.js')) !!}--}}
@endpush


{{--<button data-fsc-item-path="advanced-derivation" data-fsc-item-path-value="advanced-derivation" data-fsc-action="Add, Checkout" class="btn btn-info btn-xs subscribe_link" data-product="{{ $k }}">--}}
    {{--<span data-fsc-item-path="advanced-derivation" data-fsc-item-description-action></span>--}}
    {{--subscribe--}}
{{--</button>--}}
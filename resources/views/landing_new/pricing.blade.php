@extends('layouts.landing_new')

@section('pagemeta')
    <meta name="description" content="Try our 1 month FREE trial plan to find and remove the bad links pointing to your website! Keep your position high in Google SERP">
    <meta name="keyword" content="pricing, prices, plans, package, packages, trial, free, month, backlinks, bad links, google, penguin, panda, penalty, remove, linkquidator">
    <title>Remove bad links. Try 1 month free trial – Linkquidator.com</title>
@endsection

@section('content')
<style>
    a:hover {
        cursor: pointer;
    }

    .price-block:hover input[type="url"], .price-block.active input[type="url"] {
        display: block;
    }

    .price-block input[type="url"] {
        display: none;
        width: calc(100% - 30px);
        margin: 15px;
        background: #ffffff;
        border: 1px solid #ffffff;
        color: #555555;
        font-size: 14px;
        text-indent: 15px;
        padding: 5px 0;
    }


    .price-block:hover .btn-area button, .price-block.active .btn-area button {
        background: #1c4688;
        padding: 12px;
        font-size: 22px;
        margin: 0 20px;
    }

    .price-block .btn-area button {
        display: inline-block;
        margin: 0 40px;
        padding: 10px;
        font-size: 20px;
        text-decoration: none;
        border: 1px solid #a48b82;
        border-radius: 24px;
        background: #fe4f16;
        color: #ffffff;
    }


</style>
<!-- Page Content -->
<section class="welcome">
    <div class="container">
        <h1>
            Start your <span>14-days FREE</span> TRIAL
        </h1>

        <h2>30-days <strong>MONEY-BACK</strong> Guarantee. No obligation. Same day refund</h2>

        <ul class="tabsp-menu">
            <li class="active">
                <a data-toggle="tab" href="#home">
                    Monthly
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#menu1" class="percent">
                    Annually
                </a>
            </li>
        </ul>
    </div>
</section>


<section class="price-content">
    <div class="container container2">
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <?php $k = 'linkquidator-webmaster-plan'?>
                        <div class="price-block ready_to_subscribe_normal">
                            <div class="top">
                                <div class="icon icon1"></div>
                                <p>
                                    Webmaster
                                </p>
                            </div>
                            <div class="line">
                                <h4>32$</h4>
                                <p>per month</p>
                            </div>
                            <div class="line">
                                <h4>3 domains</h4>
                                <p>300.000 backlinks</p>
                            </div>
                            <div class="btn-area">
                                @if(isset($plan[$k]))
                                    <a href="/cancel_subscribe/{{ $plan[$k] }}" class="cancel_subscription">Cancel Plan</a>
                                @else
                                    <a class="subscribe_link" data-product="{{ $k }}">Choose Plan</a>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3 col-xs-6">
                        <?php $k = 'linkquidator-s-plan'?>
                        <div class="price-block active">
                            <form action="" class="custom_domain_form" data-period="month">
                            <div class="top">
                                <div class="icon icon2"></div>
                                <input type="text" required placeholder="Enter your domain..." class="custom_domain">
                                {{--<input type="text" placeholder="Enter your domain...">--}}
                                <span class="has-error" style="color: red;"></span>
                            </div>
                            <div class="line">
                                <h4><span class="custom_backlinks_price">#</span>$</h4>
                                <p class="custom_trial">14 days trial</p>
                            </div>
                            <div class="line">
                                <h4>1 domain</h4>
                                <p><span class="custom_backlinks_count">#</span> backlinks</p>
                            </div>
                            <div class="btn-area">
                                <button class="subscribe_link" data-product="{{ $k }}">Choose Plan</button>
                            </div>
                            </form>
                        </div>

                    </div>
                    <div class="col-md-3 col-xs-6">
                        <?php $k = 'linkquidator-corporate-plan'?>
                        <div class="price-block ready_to_subscribe_normal">
                            <div class="top">
                                <div class="icon icon3"></div>
                                <p>
                                    Corporate
                                </p>
                            </div>
                            <div class="line">
                                <h4>179$</h4>
                                <p>per month</p>
                            </div>
                            <div class="line">
                                <h4>10 domains</h4>
                                <p>5 mln. backlinks</p>
                            </div>
                            <div class="btn-area">
                                @if(isset($plan[$k]))
                                    <a href="/cancel_subscribe/{{ $plan[$k] }}" class="subscribe_link" data-product="{{ $k }}">Cancel Plan</a>
                                @else
                                    <a class="subscribe_link" data-product="{{ $k }}">Choose Plan</a>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="price-block">
                            <div class="top">
                                <div class="icon icon4"></div>
                                <p>
                                    Custom
                                </p>
                            </div>
                            <div class="line">
                                <h4>∞$</h4>
                                <p>per month</p>
                            </div>
                            <div class="line">
                                <h4>∞ domains</h4>
                                <p>∞ backlinks</p>
                            </div>
                            <div class="btn-area">
                                <a class="subscribe_link_custom">Choose Plan</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{--Annually--}}
            <div id="menu1"  class="tab-pane fade">
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <?php $k = 'linkquidator-webmaster-plan-annual'?>
                        <div class="price-block ready_to_subscribe_normal">
                            <div class="top">
                                <div class="icon icon1"></div>
                                <p>
                                    Webmaster
                                </p>
                            </div>
                            <div class="line">
                                <h4>320$</h4>
                                <p>per year</p>
                            </div>
                            <div class="line">
                                <h4>30 domains</h4>
                                <p>3.000.000 backlinks</p>
                            </div>
                            <div class="btn-area">
                                @if(isset($plan[$k]))
                                    <a href="/cancel_subscribe/{{ $plan[$k] }}" class="subscribe_link" data-product="{{ $k }}">Cancel Plan</a>
                                @else
                                    <a class="subscribe_link" data-product="{{ $k }}">Choose Plan</a>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3 col-xs-6">
                        <?php $k = 'linkquidator-s-annual-plan'?>
                        <div class="price-block active">
                            <form action="" class="custom_domain_form" data-period="year">
                                {{ csrf_field() }}
                                <div class="top">
                                    <div class="icon icon2"></div>
                                    <input type="text" required placeholder="Enter your domain..." class="custom_domain">
                                    <span class="has-error" style="color: red;"></span>
                                </div>
                                <div class="line">
                                    <h4><span class="custom_backlinks_price">#</span>$</h4>
                                    <p class="custom_trial">14 days trial</p>
                                </div>
                                <div class="line">
                                    <h4>1 domain</h4>
                                    <p><span class="custom_backlinks_count">#</span> backlinks</p>
                                </div>
                                <div class="btn-area">
                                    <button class="subscribe_link" data-product="{{ $k }}">Choose Plan</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="col-md-3 col-xs-6">
                        <?php $k = 'linkquidator-corporate-anual-plan'?>
                        <div class="price-block ready_to_subscribe_normal">
                            <div class="top">
                                <div class="icon icon3"></div>
                                <p>
                                    Corporate
                                </p>
                            </div>
                            <div class="line">
                                <h4>1790$</h4>
                                <p>per year</p>
                            </div>
                            <div class="line">
                                <h4>100 domains</h4>
                                <p>50 mln. backlinks</p>
                            </div>
                            <div class="btn-area">
                                @if(isset($plan[$k]))
                                    <a href="/cancel_subscribe/{{ $plan[$k] }}" class="subscribe_link" data-product="{{ $k }}">Cancel Plan</a>
                                @else
                                    <a class="subscribe_link" data-product="{{ $k }}">Choose Plan</a>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="price-block">
                            <div class="top">
                                <div class="icon icon4"></div>
                                <p>
                                    Custom
                                </p>
                            </div>
                            <div class="line">
                                <h4>∞$</h4>
                                <p>per month</p>
                            </div>
                            <div class="line">
                                <h4>∞ domains</h4>
                                <p>∞ backlinks</p>
                            </div>
                            <div class="btn-area">
                                <a class="subscribe_link_custom">Choose Plan</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="price-bottom">
    <div class="container">
        <h3><span class="img"><img src="{{ url('/landing_new') }}/images/price-risk.png" alt="" /></span>No risk. No hidden fees. Cancel at anytime.</h3>
    </div>
</section>


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


{{-- DEMO EMAIL POPUP--}}
<style>
    .modal {
        text-align: center;
    }
    .modal:before {
        display: inline-block;
        vertical-align: middle;
        content: " ";
        height: 10%;
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }
</style>
<div class="modal fade" id="give-email" tabindex="-1" role="dialog" aria-labelledby="give-email-label" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="give-email-label" style="text-align: center;">How to remember you?</h4>
                </div>
                <div class="modal-body" style="text-align: center">
                    <form id="demo-email-form">
                        <div class="col-xs-12 col-sm-5" style="float: none;margin: 0 auto;">
                            <div class="form-group has-feedback has-feedback-left">
                                <label for="demo-email" style="float:left;margin-left: 2px;">Email:</label>
                                <input id="demo-email" type="email" class="form-control" name="email" required maxlength="255" placeholder="Enter your email" style="height: 36px;">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5" style="float: none;margin: 0 auto;">
                            <div class="form-group has-feedback has-feedback-left">
                                <label for="demo-password" style="float:left;margin-left: 2px;">Password:</label>
                                <input id="demo-password" type="password" class="form-control" name="password" required maxlength="255" placeholder="Enter your password" style="height: 36px;">
                                <p class="has-error password-error" style="text-align: left; color:#ff3300;display: none;">Wrong password</p>

                            </div>
                        </div>
                        <button class="btn btn-info lato-bold-18">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagescript')
    <script id="fsc-api"
            src="https://d1f8f9xcsvx3ha.cloudfront.net/sbl/0.7.4/fastspring-builder.min.js" type="text/javascript"
            data-storefront="linkquidatorstore<?= auth()->id() == 127?'.test':''?>.onfastspring.com/popup-linkquidatorstore"
            data-popup-closed="onFSPopupClosed"
            data-data-callback="dataCallbackFunction"
            data-error-callback="errorCallback">
    </script>
    <script>
        /*---CSRF TOKEN---*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        $('#demo-email-form').on('submit', function(e){
            var $this = $(this);
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: location.protocol+'//'+location.host+'/ajax_login_user/',
                data: $this.serialize()
            }).done(function( data ) {
//        	    console.log(data);
                $('.password-error').hide();
                app.user = data.user;
                $('#give-email').modal('hide');
            }).fail(function( data ) {
                $('.password-error').show();
            });
        });

        $('body').on('click', '.ready_to_subscribe .subscribe_link', function(e){
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

            if(!app.user) {
                return $('#give-email').modal('show');
            }

            custom_camapign = false;

            let tags = {'referrer' : app.user.id, 'scenario' : 'simple_subscription'};
            fscSessiontest.tags = tags;

            fscSessiontest.products = [];
            fscSessiontest.products.push({'path' : $this.data('product'), 'quantity': 1});
            fastspring.builder.tag('referrer', app.user.id);
            fastspring.builder.push(fscSessiontest); // call Library "Push" method to apply the Session Object.
        });

        $(function() {
            $('.subscribe_link_custom').on('click',function(){
                if(!app.user) {
                    return $('#give-email').modal('show');
                }

                $('#custom-s-modal').modal('show');
            });

//            $('.tab').on('click',function(){
//                var $this = $(this);
//                $('.tab-container').hide();
//                $this.siblings('.tab').removeClass('active');
//                let id = $this.addClass('active').data('tab');
//                $(id).show();
//
//            });

            $('.custom_domain').on('change',function(){
                var $this = $(this);
                $this.parents('.price-block').removeClass('ready_to_subscribe');
            });

            $('.custom_domain_form').on('submit',function(e){
                var $this = $(this);
                e.preventDefault();
                if(!app.user) {
                    return $('#give-email').modal('show');
                }

                $.ajax({
                    type: 'POST',
                    url: location.protocol+'//'+location.host+'/subscription/check_domain',
                    data: { url: $this.find('.custom_domain').val(), period : $this.data('period') }
                }).done(function( data ) {
                    $this.find('.has-error').empty();

                    precheck = data.item;
                    let $wrapper = $this.parents('.price-block').addClass('ready_to_subscribe');
                    let back_text = data.backlinks;
                    if(parseInt(data.backlinks) > 2000000) {
                        back_text = '2 mln out of '+data.backlinks;
                    }

                    $wrapper.find('.custom_backlinks_count').text(back_text);
                    $wrapper.find('.custom_backlinks_price').text(data.price);
                    $wrapper.find('.custom_trial').text(data.sub_text);
                    $wrapper.find('.subscribe_link').data('product', data.product).data('campaign_url', data.url);

                }).fail(function (data) {
                    console.log(data);
                    $this.find('.has-error').text(data.responseJSON.errors.url[0]);
                });
            });
        });

    </script>
@endsection
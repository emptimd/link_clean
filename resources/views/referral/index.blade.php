@extends('layouts.main')

@section('content')
    @include('referral._top', [
        'hold' => $hold,
        'count_active_referrals' => $count_active_referrals,
        'new_sales' => $new_sales,
        'count_rebills' => $count_rebills,
        'rec_evenue' => $rec_evenue,
        'percent' => $percent,
    ])

    <div class="row">
        <div class="col-lg-12">
            <div class="tab-content">
                {{--here comes the content, using ajax.--}}
                <div class="tab-panel active" id="tab_1">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered table-striped table-condensed"
                                       id="events-table">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th class="center">Action</th>
                                        <th class="center">referral_id</th>
                                        <th class="center">Date</th>
                                        <th class="center">Selected plan</th>
                                        <th class="center">Revenue</th>
                                        <th class="center">Revenue Status</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-panel" id="tab_2">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#accordion1_1" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed" aria-expanded="false">
                                    1. What should I do as an affiliate?
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="accordion1_1" aria-expanded="false" style="height: 0;">
                            <div class="panel-body">
                                Generally, you should refer your visitors to linkquidator.com. If one of the visitors you redirected to Linkquidator buys our services, you will get commission from every payment.
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#accordion1_2" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed" aria-expanded="false">
                                    2. How to start using it?
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="accordion1_2" aria-expanded="false" style="height: 0;">
                            <div class="panel-body">
                                To start earn money with Linkquidator you need just to register in the service. And you will get access to affilate menu with your pesonal affilate links and promo code for your customers. Send traffic and start earning! You'll always have access to your earnings by signing in to your Affiliate menu.
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#accordion1_3" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle collapsed" aria-expanded="false">
                                    3. How it works exactly?
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="accordion1_3" aria-expanded="false" style="height: 0;">
                            <div class="panel-body">
                                Everybody who come to our site by your referral link will be tagged as your referrer by web cookies and if he will register he will be linked to your account as an referral. You will get comission from your referals payments.
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#accordion1_4" data-parent="#accordion1" data-toggle="collapse"
                                   class="accordion-toggle collapsed" aria-expanded="false">
                                    4. How long is the cookie duration?
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="accordion1_4" aria-expanded="false" style="height: 0;">
                            <div class="panel-body">
                                As long as your your referrer does not clean the cookies in his browser. That means if you lead will not register right now, but will return few days/weeks later he will be steel your referrer and you will get revenue from his orders.
                            </div>
                        </div>
                    </div>


                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#accordion1_5" data-parent="#accordion1" data-toggle="collapse"
                                   class="accordion-toggle collapsed" aria-expanded="false">
                                    5. How big will be my commision?
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="accordion1_5" aria-expanded="false" style="height: 0;">
                            <div class="panel-body">
                                We offer to our partners lifetime 20 % Revenue Share. That mean's you will get 20 % not only frome the first order but from all subsequent orders and monthly charges.
                            </div>
                        </div>
                    </div>


                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#accordion1_6" data-parent="#accordion1" data-toggle="collapse"
                                   class="accordion-toggle collapsed" aria-expanded="false">
                                    6. When and how i'll be paid?
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="accordion1_6" aria-expanded="false" style="height: 0;">
                            <div class="panel-body">
                                We pay every month on the date of 8 by PayPal or Payooner.
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#accordion1_7" data-parent="#accordion1" data-toggle="collapse"
                                   class="accordion-toggle collapsed" aria-expanded="false">
                                    7. Do you have any pay limits?
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="accordion1_7" aria-expanded="false" style="height: 0;">
                            <div class="panel-body">
                                Your deposit must be more then 10 $.
                            </div>
                        </div>
                    </div>


                </div>
                <div class="tab-panel" id="tab_3">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered table-striped table-condensed"
                                       id="pay_history-table">
                                    <thead>
                                    <tr>
                                        <th class="center">Paymnet ID</th>
                                        <th class="center">Date</th>
                                        <th class="center">Amount</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-panel" id="tab_4">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="adv-table">
                                <table class="display table table-bordered table-striped table-condensed"
                                       id="referrals-table">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th class="center">Reg.Date</th>
                                        <th class="center">Selected Plan</th>
                                        <th class="center">Total Rebils</th>
                                        <th class="center">On Hold</th>
                                        <th class="center">Total Revenue</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tooltip {
            background-color: transparent !important;
            border: 0 !important;
        }
    </style>
@stop

@push('pagescript')
    {!! Html::script('theme/js/jquery.sparkline.js') !!}
    {!! Html::script(elixir('js/referrals.js')) !!}
@endpush
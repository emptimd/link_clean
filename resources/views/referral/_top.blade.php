<style>
    .top_wrap > a > i {
        margin-right: 5px;
    }

    .tab-content .panel {
        margin-bottom: 5px;
    }

    .tab-content .tab-panel {
        display: none;
    }

    .tab-content .tab-panel.active {
        display: block;
    }
</style>

@if (!Auth::user()->is_admin && !Auth::user()->paypal_email)
    <div class="alert alert-warning fade in">
        <button data-dismiss="alert" class="close close-sm" type="button">
            <i class="fa fa-times"></i>
        </button>
        <strong>Heads up!</strong> You didn't provide us your paypal email. To get full benefit of the Linkquidator service please proceed to <a href="{{ url('profile') }}">profile</a> section.
    </div>
@endif

<div class="top_wrap" style="margin-top: -15px;margin-bottom: 20px;">
    <a href="#tab_1" data-toggle="tab" aria-expanded="true" class="btn btn-white btn-sm" data-href="ref/events"><i class="fa fa-book"></i>Events</a>
    <a href="#tab_2" data-toggle="tab" aria-expanded="true" class="btn btn-white btn-sm faq" data-href="ref/faq"><i class="fa fa-book"></i>F.A.Q</a>
    <a href="#tab_3" data-toggle="tab" aria-expanded="true" class="btn btn-white btn-sm show_tab not_processed" data-href="/ref/pay_history" data-table="#pay_history-table" data-targets="[ 0,1,2 ]"><i class="fa fa-credit-card"></i>Pay History</a>
    <a href="#tab_4" data-toggle="tab" aria-expanded="true" class="btn btn-white btn-sm show_tab not_processed" data-href="/ref/referrals" data-table="#referrals-table" data-targets="[ 1,2,3,4,5 ]"><i class="fa fa-users"></i>Referrals</a>

    <div class="dropdown pull-right">
        <a class="btn btn-white btn-sm dropdown-toggle" data-href="ref" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-dollar"></i>
            {{ $hold + Auth::user()->balance }}
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a>{{ number_format(Auth::user()->balance) }} $ approved</a></li>
            <li><a>{{ number_format($hold) }} $ on hold</a></li>
            <li><a href="{{ url('profile') }}">Your payment details</a></li>
        </ul>
    </div>
</div>

<div class="row state-overview">
    <div class="col-lg-3 col-sm-3">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-user-o"></i>
            </div>
            <div class="value">
                <h1 class="count">
                    {{ $count_active_referrals }}
                </h1>
                <p>Active referrals</p>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-sm-3">
        <section class="panel">
            <div class="symbol green">
                <i class="fa fa-money"></i>
            </div>
            <div class="value">
                <h1 class="count">
                    {{ number_format($new_sales)?:0 }}
                </h1>
                <p>New Sales</p>
            </div>
        </section>
    </div>

    <div class="col-lg-3 col-sm-3">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="value">
                <h1 class="count2">
                    {{ $count_rebills }}
                </h1>
                <p>Rebills</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-3">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="value">
                <h1 class="count3 rec_revenue">
                        {{ number_format($rec_evenue)?:0 }}
                </h1>
                <p>Rec.Revenue</p>
            </div>
        </section>
    </div>
</div>

<div class="row data_chart">
    {{--<div class="col-sm-4">--}}
        {{--<div class="panel" style="padding: 10px 0 0 20px;height: 194px;">--}}
            {{--<h4>Referral Link: <a href="{{ url("ref/".Auth::id()) }}">{{ url('/') }}/ref/{{ Auth::id() }}</a></h4>--}}
            {{--<h4>ID of promocode: <a>{{ Auth::user()->promodcode }}</a></h4>--}}
        {{--</div>--}}
    {{--</div>--}}



    <div class="col-sm-4">
        <aside class="profile-nav alt green-border">
            <section class="panel">
                <div class="user-heading alt green-bg ref">
                    <h1>{{ Auth::user()->name }}</h1>
                    <p>{{ Auth::user()->email }}</p>
                </div>

                <ul class="nav nav-pills nav-stacked">
                    <li id="copy" title="" data-clipboard-text="{{ url('/') }}/ref/{{ Auth::id() }}"><a> <i class="fa fa-link"></i> Referral Link: {{ url('/') }}/ref/{{ Auth::id() }}</a></li>
                    <li><a> <i class="fa fa-code"></i> Personal promocode: {{ Auth::user()->promocode }}</a></li>
                    <li><a> <i class="fa fa-dollar"></i> Revenue Share: {{ Auth::user()->revenue_share }}%</a></li>
                    <li><a> <i class="fa fa-calendar"></i> Payment day: 8 {{ date('j') <= 8 ? date('F'):Carbon\Carbon::now()->addMonth()->format('F') }}</a></li>
                </ul>

            </section>
        </aside>
    </div>


    <div class="col-sm-8">
        <div class="panel terques-chart">
            <div class="panel-body chart-texture">
                <div class="chart">
                    <div class="heading">
                        <span>{{ date('F') }}</span>
                        <strong>$ {{ $rec_evenue }} | {{ $percent > 0 ? '+'.$percent :$percent }}%</strong>
                    </div>
                    <div class="sparkline" data-type="line" data-resize="true" data-height="150" data-width="97%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4"
                         data-data="[200,135,667,333,526,996,564,123,890,564,455,455,455,455,123,333,54,26,77,11,6,89,115,244,500,600,433,500,521,600]">
                        <canvas width="288" height="75" style="display: inline-block; width: 288px; height: 75px; vertical-align: top;"></canvas>
                    </div>
                </div>
            </div>
            <div class="chart-tittle">
                <span class="title">New Earning</span>
                <span class="value">
                    <a id="chart_new_sales" class="active">New Sales</a>
                    |
                    <a id="chart_rebill">Rebill</a>
                </span>
            </div>
        </div>

        {{--<div id="exemple-3"></div>--}}

    </div>
</div>
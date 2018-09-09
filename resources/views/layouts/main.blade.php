<!doctype html>
<html lang=en-us>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="f1f1f1">
        <meta name="author" content="f">
        <meta name="keyword" content="aaaa a">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link type="image/x-icon" href="{{ url('/') }}/favicon.ico?123" rel="shortcut icon" sizes="16x16">
        <title>Linkquidator 2.0</title>

        {{--<!— Google Tag Manager —>--}}
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-5K778XF');</script>
        {{--<!— End Google Tag Manager —>--}}

        {!! Html::style('theme/assets/advanced-datatable/media/css/table.css?7') !!}
        {!! Html::style('theme/assets/data-tables/DT_bootstrap.css') !!}
        {!! Html::style(elixir('css/backend.css')) !!}
        @stack('styles')
    </head>
    <body>
    {{--<!— Google Tag Manager (noscript) —>--}}
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5K778XF"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    {{--<!— End Google Tag Manager (noscript) —>--}}
        <!--header start-->
        <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
            </div>
            <!--logo start-->
            <a href="{{ url('dashboard') }}" class="logo">Linkquidator <span>2.0</span></a>
            <!--logo end-->

            @if(Auth::user()->backlinks)
                <div class="limit-info">Your backlinks limit: <span class="count">{{ Auth::user()->backlinks-Auth::user()->backlinks_used }}</span><a href="{{ url('subscription') }}" class="get-more">Get More</a></div>
            @endif

            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    @if($crock)
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
                                <i class="fa fa-tasks"></i>
                                <span class="badge bg-success">{{ $crock->count() }}</span>
                            </a>
                            <ul class="dropdown-menu extended tasks-bar">
                                <div class="notify-arrow notify-arrow-green"></div>
                                <li>
                                    <p class="green">You have {{ $crock->count() }} extra tasks</p>
                                </li>
                                @foreach($crock as $item)
                                    <li>
                                        <a href="#">
                                            <div class="task-info">
                                                <div class="desc">{{ $item->url }}</div>
                                                <?php $now = \Carbon\Carbon::now();
                                                $diff = $now->diffInHours($item->created_at);
                                                if($diff >= 48) $p = 100;
                                                else $p = number_format($diff/40*100, 1);?>
                                                <div class="percent">{{ $p }}%</div>
                                            </div>
                                            <div class="progress progress-striped">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $p }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $p }}%">
                                                    <span class="sr-only">{{ $p }}% Complete (success)</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                                {{--<li class="external">--}}
                                {{--<a href="#">See All Tasks</a>--}}
                                {{--</li>--}}
                            </ul>
                        </li>
                    @endif


                    {{--END NEW--}}
                    @if (Auth::user()->is_admin)
                    <!-- inbox dropdown start-->
                    <li id="header_inbox_bar" class="dropdown">
                        <a class="dropdown-toggle" href="{{ url('admin/support') }}">
                            <i class="fa fa-envelope-o"></i>
                            <?php if($open_tickets) { ?><span class="badge bg-important"><?=$open_tickets;?></span><?php } ?>
                        </a>
                    </li>
                    <!-- inbox dropdown end -->
                    @endif


                    @if($notifications)
                        <li id="header_notification_bar" class="dropdown">
                            <a class="dropdown-toggle" href="{{ url('/notifications') }}">
                                <i class="fa fa-bell-o"></i>
                                <span class="badge bg-warning">{{ $notifications }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li>
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{ Gravatar::src(Auth::user()->email, 30) }}">
                            <span class="username">{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>{!! Html::decode(Html::link('subscription', '<i class="fa fa-trophy"></i> Subscription')) !!}</li>
                            <li>{!! Html::decode(Html::link('profile', '<i class="fa fa-suitcase"></i> Profile')) !!}</li>
                            <li>{!! Html::decode(Html::link('logout', '<i class="fa fa-key"></i> Log Out', ['onclick' => "event.preventDefault(); document.getElementById('logout-form').submit();"])) !!}</li>
                        </ul>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>

                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->

        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu goes here-->
                {{--test webhook--}}
                @section('sidebar')
                <!-- sidebar menu start-->
                <?php
                    $menu = Menu::handler('main')
                            ->addClass('sidebar-menu')
                            ->Id('nav-accordion')
                            ->add("dashboard", '<i class="fa fa-dashboard"></i> My Campaigns');
                        if(strpos(\Request::getPathInfo(), 'campaign') !== false) {
                            $campaig_id = explode('/', \Request::getPathInfo())[2];

                            $menu->add("campaign/$campaig_id", '<i class="fa fa-area-chart"></i> Overview')
                            ->add("campaign/$campaig_id/backlinks", '<i class="fa fa-link"></i> Backlinks', Menu::items(), ['class' => 'demo-link-disabled'])
                            ->add("campaign/$campaig_id/destination", '<i class="fa fa-file-text-o"></i> Pages', Menu::items(), ['class' => 'demo-link-disabled'])
                            ->add("campaign/$campaig_id/refs", '<i class="fa fa-sitemap"></i> Referrals', Menu::items(), ['class' => 'demo-link-disabled']);
                        }
                         $menu->add('subscription', '<i class="fa fa-trophy"></i> Subscription')
                            ->add('faq', '<i class="fa fa-info"></i> FAQ')
                            ->add('support', '<i class="fa fa-comments-o"></i> Support')
                            ->add('ref', '<i class="fa fa-money"></i> Affiliate');
                    if(Auth::user()->is_admin)
                    {
                        $menu->add(false, '<i class="fa fa-bolt"></i> Admin', Menu::items()
                            ->addClass('sub')
                            ->add('admin/clients', 'Clients')
                            ->add('admin/support', 'Tickets')
                            ->add('admin/payments', 'Payments')
                            ->add('admin/events', 'Events'),
                            ['class' => ''], ['class' => 'sub-menu']);
                    }

                // activate sub-menu if child is active
                    $menu->getItemsByContentType('Menu\Items\Contents\Link')->map(function($item) {
                            if($item->isActive()) {
                                $active = $item->getParent()->getParent();
                                if(is_object($active)) $active->getContent()->addClass('active');
                            }
                        });
                ?>
                {!! $menu !!}
                <!-- sidebar menu end-->
                @show
            </div>
        </aside>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">

                @include('shared.status')
                @include('shared.errors')

                <!--main content goes here-->
                @yield('content')

            </section>
        </section>
        <!--main content end-->

        <!-- js placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/r-2.1.0/datatables.min.js"></script>
        {!! Html::script('theme/assets/data-tables/DT_bootstrap.js') !!}
        {!! Html::script('theme/assets/chart-master/Chart.js') !!}
        {!! Html::script(elixir('js/backend.js')) !!}
        {!! Html::script(elixir('js/common-update.js')) !!}

        @include ('shared.footer')

        @stack('pagescript')



    </body>

</html>
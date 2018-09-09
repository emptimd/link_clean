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

        @if(Request::is('guest_posts'))
        <link href="theme/assets/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet"/>
        @endif
        {!! Html::style('theme/assets/advanced-datatable/media/css/table.css?5') !!}
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
        </header>
        <!--header end-->

        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu goes here-->
                @section('sidebar')
                <!-- sidebar menu start-->
                <?php
                    $menu = Menu::handler('main')
                            ->addClass('sidebar-menu')
                            ->Id('nav-accordion')
                            ->add('faq', '<i class="fa fa-info"></i> FAQ')
                            ->add('guest_posts', '<i class="fa fa-search"></i> Find Guest Post');
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
        {!! Html::script(elixir('js/backend.js')) !!}

        @include ('shared.footer')

        @stack('pagescript')



    </body>

</html>
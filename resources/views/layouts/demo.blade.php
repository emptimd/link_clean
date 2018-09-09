<!doctype html>
<html lang=en-us>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keyword" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link type="image/x-icon" href="{{ url('/favicon.ico') }}" rel="shortcut icon" sizes="16x16">
        <title>Linkquidator 2.0 - Demo</title>
        {!! Html::style('theme/assets/advanced-datatable/media/css/table.css?5') !!}
        {!! Html::style('theme/assets/data-tables/DT_bootstrap.css') !!}
        {!! Html::style(elixir('css/backend.css')) !!}
    </head>
    <body>
        <!--header start-->
        <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
            <a href="{{ url('/') }}" class="logo">Linkquidator <span>2.0</span></a>
            <!--logo end-->

            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav pull-left top-menu">
                    <li><a href="{{ url('/') }}" class="btn">Home</a></li>
                    <li><a href="{{ url('pricing') }}" class="btn">Pricing</a></li>
                    <li><a href="{{ url('affiliate') }}" class="btn">Affiliate</a></li>
                    <li><a href="{{ url('faq') }}" class="btn">F.A.Q.</a></li>
                    <li><a href="{{ url('contact') }}" class="btn">Contact US</a></li>
                </ul>
            </div>
            <div class="top-nav">
                <ul class="nav pull-right top-menu">
                    <li><a href="{{ url('register') }}" class="btn">Get started</a></li>
                    <li><a href="{{ url('login') }}" class="btn">Login</a></li>
                </ul>
            </div>
        </header>
        <!--header end-->

        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu goes here-->
                <ul class="sidebar-menu" id="nav-accordion">
                    <li><a data-toggle="modal" href="#modal-howitworks">How it works ?</a></li>
                    <!--<li><a data-toggle="modal" href="#modal-howtouse">How to use</a></li>
                    <li><a data-toggle="modal" href="#modal-whywantit">Why you want it</a></li>-->
                    <li><a href="{{ url('contact') }}">Any questions ?</a></li>
                </ul>

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

        <!-- Modal -->
        <div class="modal fade" id="modal-howitworks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">How it works?</h4>
                    </div>
                    <div class="modal-body">

                        <iframe width="560" height="315" src="https://www.youtube.com/embed/RuOlG9kUZi4" frameborder="0" allowfullscreen></iframe>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
        <!-- Modal -->
        <div class="modal fade" id="modal-howtouse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">How to use?</h4>
                    </div>
                    <div class="modal-body">

                        <iframe width="560" height="315" src="https://www.youtube.com/embed/-0hajliHa3U" frameborder="0" allowfullscreen></iframe>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
        <!-- Modal -->
        <div class="modal fade" id="modal-whywantit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Why you want it?</h4>
                    </div>
                    <div class="modal-body">

                        <iframe width="560" height="315" src="https://www.youtube.com/embed/-0hajliHa3U" frameborder="0" allowfullscreen></iframe>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- js placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/r-2.1.0/datatables.min.js"></script>
        {!! Html::script('theme/assets/data-tables/DT_bootstrap.js') !!}
        {!! Html::script(elixir('js/backend.js')) !!}

        @include ('shared.footer')

        @stack('pagescript')

    </body>
</html>
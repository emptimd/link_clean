<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('pagemeta')
    <meta property="og:title" content="Check and manage your backlinks using best seo tools in one place."/>
    <meta property="og:image" content="{{ url('/landing/images/ogilinkquidator.jpg') }}"/>
    <meta property="og:description" content="Linkquidator collects and aggregates all the data about your backlinks in one place and makes it practical. Get the ability to track and influence your backlink profile."/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url('/') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--<!— Google Tag Manager —>--}}
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5K778XF');</script>
    {{--<!— End Google Tag Manager —>--}}

    <link type="image/x-icon" href="{{ url('/favicon.ico') }}" rel="shortcut icon" sizes="16x16">
{{--<link rel="apple-touch-icon" href="icon.png">--}}
<!-- Place favicon.ico in the root directory -->


    <link rel="stylesheet" href="{{ url('/landing_new/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ url('/landing_new/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/landing_new/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ url('/landing_new/css/bootstrap-grid.min.css') }}">


    @yield('styles')
    <link rel="stylesheet" href="{{ url('/landing_new/css/main.css') }}">
</head>
<body>

<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5K778XF"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<div class="wrap">
    <header class="head">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <a href="/" class="logo">
                        <img src="{{ url('/landing_new/images/logo.png') }}" alt="" />
                    </a>
                </div>
                <div class="col-lg-6">
                    <input class="burger-check" id="burger-check" type="checkbox"><label for="burger-check" class="burger"></label>
                    <nav id="navigation1" class="navigation">
                        <ul class="top-menu">
                            <li>
                                {!! Html::link('/', 'Home') !!}
                            </li>
                            <li>
                                {!! Html::link('faq', 'FAQ') !!}
                            </li>
                            <li>
                                {!! Html::link('pricing', 'Pricing') !!}
                            </li>
                            <li>
                                {!! Html::link('contact', 'Contact Us') !!}
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="head-buttons">
                        @if (Auth::guest())
                            <a href="{{ url('login') }}" class="login">Log In</a>
                            <a href="{{ url('register') }}" class="start">Get Started</a>
                        @else
                            <a href="{{ url('admin') }}" class="login" style="padding-right: 5px;">Dashboard</a>
                            <a href="{{ url('logout') }}" class="start" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </header>

    <!--main content goes here-->
    @yield('content')


    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul class="social-icons">
                        <li>
                            <a class="social-icons social-icon-full">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="social-icons social-icon--border">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="social-icons social-icon--border">
                                <i class="fa fa-google-plus" aria-hidden="true"></i>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="col-md-9">
                    <ul class="menu">
                        <li>
                            {!! Html::link('refund-policy', 'Refund Policy') !!}
                        </li>
                        <li>
                            {!! Html::link('terms', 'Terms of Use') !!}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="{{ url('/landing_new/js/bootstrap.min.js') }}"></script>

@include ('shared.footer')

@yield('pagescript')

@if(env('APP_ENV') == 'production')
    <style>
        iframe[name='google_conversion_frame'] {
            height: 0 !important;
            width: 0 !important;
            line-height: 0 !important;
            font-size: 0 !important;
            margin-top: -13px;
            float: left;
        }
    </style>
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 863067463;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/863067463/?guid=ON&amp;script=0"/>
        </div>
    </noscript>
    <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter31712011 = new Ya.Metrika({ id:31712011, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/31712011" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

    {{--<!— Facebook Pixel Code —>--}}
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '210603922765176'); // Insert your pixel ID here.
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=210603922765176&ev=PageView&noscript=1"
        /></noscript>
    {{--<!— DO NOT MODIFY —>
    <!— End Facebook Pixel Code —>--}}
@endif



</body>
</html>
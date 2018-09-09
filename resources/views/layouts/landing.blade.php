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

    <link type="image/x-icon" href="{{ url('/') }}/favicon.ico?123" rel="shortcut icon" sizes="16x16">
    <!-- Bootstrap Core CSS -->
    {{--{!! Html::style('landing/css/bootstrap.min.css') !!} --}}

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" media="none" onload="media='all'">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,100italic,300italic,100,300,400italic,700,700italic,900" media="none" onload="media='all'">

    @yield('styles')
    <link rel="stylesheet" media="(max-width: 480px and orientation: landscape)" href="{{ elixir('css/max-device-width480px-and-orientationlandscape.css') }}">
    <link rel="stylesheet" media="(max-width: 767px)" href="{{ elixir('css/max-width767px.css') }}">
    <link rel="stylesheet" media="(max-width: 991px)" href="{{ elixir('css/max-width991px.css') }}">
    <link rel="stylesheet" media="(max-width: 1199px)" href="{{ elixir('css/max-width1199px.css') }}">
    <link rel="stylesheet" media="(min-width: 768px)" href="{{ elixir('css/min-width768px.css') }}">
    <link rel="stylesheet" media="(min-width: 768px and max-width: 991px)" href="{{ elixir('css/min-width768px-and-max-width991px.css') }}">
    <link rel="stylesheet" media="(min-width: 992px)" href="{{ elixir('css/min-width992px.css') }}">
    <link rel="stylesheet" media="(min-width: 992px and max-width: 1199px)" href="{{ elixir('css/min-width992px-and-max-width1199px.css') }}">
    <link rel="stylesheet" media="(min-width: 1200px)" href="{{ elixir('css/min-width1200px.css') }}">
    <link rel="stylesheet" media="print" href="{{ elixir('css/print.css') }}">
    <link rel="stylesheet" media="screen and (min-width: 768px)" href="{{ elixir('css/screen-and-min-width768px.css') }}">
    <link rel="stylesheet" media="screen and (webkit-min-device-pixel-ratio: 0)" href="{{ elixir('css/screen-and-webkit-min-device-pixel-ratio0.css') }}">
</head>

<body class="@yield('body_class')">

{{--<!— Google Tag Manager (noscript) —>--}}
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5K778XF"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
{{--<!— End Google Tag Manager (noscript) —>--}}

<!--main content goes here-->
@yield('content')


<script
        src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>{{--defer--}}
{{-- TODO add boostrap onyly on pages that need it --}}
{{--{!! Html::script() !!}--}}

<script src='landing/js/bootstrap.min.js' defer></script>
<script>
    Share={go:function(t,e){var o=Share,n=$.extend({type:"fb",url:location.href,count_url:location.href,title:document.title,image:"",text:"Backlinkcontrol collects and aggregates all the data about your backlinks in one place and makes it practical. Get the ability to track and influence your backlink profile."},$(t).data(),e);return null===o.popup(link=o[n.type](n))&&($(t).is("a")?($(t).prop("href",link),!0):(location.href=link,!1))},gg:function(t){var e=$.extend({url:location.href},t);return"https://plus.google.com/share?url="+encodeURIComponent(e.url)},fb:function(t){var e=$.extend({url:location.href,title:"",image:"",text:""},t);return"http://www.facebook.com/sharer.php?s=100&p[title]="+encodeURIComponent(e.title)+"&p[summary]="+encodeURIComponent(e.text)+"&p[url]="+encodeURIComponent(e.url)+"&p[images][0]="+encodeURIComponent(e.image)},tw:function(t){var e=$.extend({url:location.href,count_url:location.href,title:document.title},t);return"http://twitter.com/share?text="+encodeURIComponent(e.title)+"&url="+encodeURIComponent(e.url)+"&counturl="+encodeURIComponent(e.count_url)},popup:function(t){return window.open(t,"","toolbar=0,status=0,scrollbars=1,width=626,height=436")}},$(document).on("click",".footer-bg .social-icons",function(){Share.go(this);$.get(location.protocol+'//'+location.host+'/ssb');});
</script>

@include ('shared.footer')

@yield('pagescript')
{{--<!— Код тега ремаркетинга Google —>--}}
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
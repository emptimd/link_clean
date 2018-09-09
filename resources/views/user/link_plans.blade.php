@extends('backlink.layouts.main')

@section('content')

    <style>
        .package-content {
            padding-top: 50px;
        }
        .packages .package:first-child {
            margin-left: 0;
        }
        .packages .package {
            position: relative;
            background-color: #fff;
            border-radius: 3px;
            background-clip: padding-box;
            box-shadow: 0 0 3px rgba(24, 24, 24, 0.1);
            text-align: center;
            padding-bottom: 35px;
        }

        .packages .package .package-header {
            background: #000;
            border-bottom: 1px solid #cccccc;
            height: 120px;
            border-radius: 3px 3px 0 0;
            overflow: hidden;
        }

        .packages .package.violet .package-header {
            background: #867fd4;
            border-bottom: 1px solid #b6b4d1;
        }

        .packages .package.navy .package-header {
            background: #33b6cd;
            border-bottom: 1px solid #85bcc5;
        }

        .packages .package.green .package-header {
            background: #5ccea9;
            border-bottom: 1px solid #a1c8bb;
        }

        .packages .package .package-header .price {
            width: 94px;
            height: 94px;
            border-radius: 50%;
            background-clip: padding-box;
            background-color: #f49233;
            border: solid 8px #eff5fa;
            position: absolute;
            top: -48px;
            left: 0;
            right: 0;
            margin: auto;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
            font-size: 24px;
            font-weight: bold;
            line-height: 79px;
            color: #fff;
            text-align: center;
            -webkit-font-smoothing: antialiased;
            -moz-font-smoothing: antialiased;
            font-smoothing: antialiased;
        }

        .packages .package .package-header h1 {
            margin: 0;
            padding: 0;
            font-family: 'corbelbold', sans-serif;
            font-size: 30px;
            font-weight: normal;
            line-height: 1;
            letter-spacing: 0.03px;
            color: #fff;
            text-transform: none;
            -webkit-font-smoothing: antialiased;
            -moz-font-smoothing: antialiased;
            font-smoothing: antialiased;
            margin-bottom: 0;
            margin-top: 52px;
        }

        .packages .package .package-header .desc {
            font-size: 15px;
            font-weight: normal;
            line-height: 1;
            letter-spacing: 0.015px;
            font-style: italic;
            -webkit-font-smoothing: antialiased;
            -moz-font-smoothing: antialiased;
            font-smoothing: antialiased;
            margin-top: 4px;
            color: #fff;
        }

        .packages .package .tiers .tier h2 {
            margin: 0;
            padding: 0;
            background: #ccc;
            font-size: 14px;
            font-weight: bold;
            line-height: 40px;
            letter-spacing: 0.014px;
            color: #fff;
            text-transform: none;
            -webkit-font-smoothing: antialiased;
            -moz-font-smoothing: antialiased;
            font-smoothing: antialiased;
            height: 40px;
            box-sizing: border-box;
            margin-bottom: 0;
        }

        .packages .package.violet .tiers .tier h2 {
            background: #a4a1c6;
        }

        .packages .package.navy .tiers .tier h2 {
            background: #66abb7;
        }

        .packages .package.green .tiers .tier h2 {
            background: #8abaaa;
        }

        .packages .package .tiers .tier .services .service {
            height: 41px;
            font-size: 14px;
            font-weight: normal;
            line-height: 40px;
            letter-spacing: 0.014px;
            color: #34435b;
            background: url(/backlink/images/border-service.png) 50% 0 no-repeat;
            -webkit-font-smoothing: antialiased;
            -moz-font-smoothing: antialiased;
            font-smoothing: antialiased;
        }

        .packages .package .tiers .tier .services .service:first-child {
            background: none;
        }

        .packages .package .to-cart {
            display: inline-block;
            width: 174px;
            height: 49px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            -moz-background-clip: padding;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            -webkit-box-shadow: 0 1px rgba(255, 255, 255, 0.5);
            -moz-box-shadow: 0 1px rgba(255, 255, 255, 0.5);
            box-shadow: 0 1px rgba(255, 255, 255, 0.5);
            background: #f49233 url(/backlink/images/icon-to-cart.png) 20px 15px no-repeat;
            font-size: 18px;
            font-weight: bold;
            line-height: 49px;
            letter-spacing: 0.018px;
            color: #ffffff;
            -webkit-font-smoothing: antialiased;
            -moz-font-smoothing: antialiased;
            font-smoothing: antialiased;
            text-indent: 12px;
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            margin: auto;
        }

        .packages .package .tiers .tier .services .service.inactive {
            color: #a5a5a5;
        }

        .link-building-menu {
            background-color: #fff;
            height: 50px;
            margin-top: 10px;
        }

        .link-building-menu a {
            font-size: 17px;
            margin-left: 20px;
            line-height: 50px;
        }

        .link-building-menu a.active {
            text-decoration: underline;
            color: #2A3542;
        }

    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="link-building-menu">
                <a href="/products/press_realeases">Links</a>
                {{--<a href="">Social Signals</a>--}}
                <a href="/guest_posts">Guest Posts</a>
                <a href="/link_plans" class="active">Link Plans</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="package-content">
                <section class="packages">
                    <div class="col-md-4">
                        <section class="package violet">
                            <header class="package-header">
                                <div class="price">$47</div>
                                <h1>Small Package</h1>
                                <div class="desc">1 Human Article with spin</div>
                            </header>
                            <div class="tiers">
                                <div class="tier">
                                    <h2>Tier 1</h2>
                                    <div class="services">
                                        <div class="service"><strong>15&nbsp;</strong>Web 2.0 Blogs</div>
                                        <div class="service"><strong>10&nbsp;</strong>PR 8-9 Backlinks</div>
                                        <div class="service"><strong>15&nbsp;</strong>TOP Social Bookmarks</div>
                                        <div class="service"><strong>10&nbsp;</strong>EDU Profiles</div>
                                        <div class="service"><strong>50</strong> Web 2.0 Profiles</div>
                                        <div class="service"><strong>15&nbsp;</strong>Media Wiki</div>
                                        <div class="service"><strong>10&nbsp;</strong>Social Network mix</div>
                                        <div class="service"><strong>10&nbsp;</strong>PDF/DOC Links</div>
                                        <div class="service"><strong>10&nbsp;</strong>Image Submission Links</div>
                                        <div class="service"><strong>1</strong> Niche Related Blog Post</div>
                                        <div class="service"><strong>1&nbsp;</strong>Weebly post</div>
                                        <div class="service"><strong>1&nbsp;</strong>Tumblr post</div>
                                        <div class="service inactive">Wordpress blog</div>
                                        <div class="service inactive">Ezine Article</div>
                                        <div class="service inactive">Press Releases</div>
                                        <div class="service"><strong>500&nbsp;</strong>Social Signals</div>
                                        <div class="service inactive">Comments for social signals</div>
                                        <div class="service inactive">Video Creation</div>
                                        <div class="service inactive">Video Submission</div>
                                    </div>
                                </div>
                                <div class="tier">
                                    <h2>Tier 2</h2>
                                    <div class="services">
                                        <div class="service"><strong>2000</strong> Social Bookmarks LinkJuice</div>
                                        <div class="service"><strong>2000</strong> Wikimedia Backlinks</div>
                                        <div class="service"><strong>10 000&nbsp;</strong>Blog Comments</div>
                                        <div class="service">LinkIndex Services</div>
                                    </div>
                                </div>
                            </div>
                            <a class="to-cart" data-product="47-seo-plans-backlinkcontrol-com">Subscribe</a>
                        </section>
                    </div>
                    <div class="col-md-4">
                        <section class="package navy">
                            <header class="package-header">
                                <div class="price">$97</div>
                                <h1>Medium Package</h1>
                                <div class="desc"><span style="color: #993366;"><strong>80</strong></span> Unique Human
                                    Articles no spin
                                </div>
                            </header>
                            <div class="tiers">
                                <div class="tier">
                                    <h2>Tier 1</h2>
                                    <div class="services">
                                        <div class="service"><strong>20&nbsp;</strong>Web 2.0 Blogs</div>
                                        <div class="service"><strong>15</strong> PR 8-9 Backlinks</div>
                                        <div class="service"><strong>30</strong> TOP Social Bookmarks</div>
                                        <div class="service"><strong>15</strong> EDU Profiles</div>
                                        <div class="service"><strong>100</strong> Web 2.0 Profiles</div>
                                        <div class="service"><strong>15</strong> Media Wiki</div>
                                        <div class="service"><strong>15</strong> Social Network mix</div>
                                        <div class="service"><strong>15</strong> PDF/DOC Links</div>
                                        <div class="service"><strong>15</strong> Image Submission Links</div>
                                        <div class="service"><strong>2</strong> Niche Related Blog Posts</div>
                                        <div class="service"><strong>1</strong> Weebly blog</div>
                                        <div class="service"><strong>1</strong> Tumblr blog</div>
                                        <div class="service"><strong>1</strong> Wordpress blog</div>
                                        <div class="service inactive">Ezine Article</div>
                                        <div class="service"><strong>10</strong> Press Releases</div>
                                        <div class="service"><strong>1100</strong> Social Signals</div>
                                        <div class="service"><strong>20</strong> Comments for social signals</div>
                                        <div class="service">Video Creation</div>
                                        <div class="service"><strong>10&nbsp;</strong>Video Submission</div>
                                    </div>
                                </div>
                                <div class="tier">
                                    <h2>Tier 2</h2>
                                    <div class="services">
                                        <div class="service"><strong>3000</strong> Social Bookmarks LinkJuice</div>
                                        <div class="service"><strong>3000</strong> Wikimedia Backlinks</div>
                                        <div class="service"><strong>20 000</strong> Blog Comments</div>
                                        <div class="service">LinkIndex Services</div>
                                    </div>
                                </div>
                            </div>
                            <a class="to-cart" data-product="97-seo-plan-backlinkcontrol-com">Subscribe</a>
                        </section>
                    </div>

                    <div class="col-md-4">
                        <section class="package green">
                            <header class="package-header">
                                <div class="price">$147</div>
                                <h1>Big Package</h1>
                                <div class="desc"><span style="color: #993366;"><strong>120</strong></span> Unique Human
                                    Articles no spin
                                </div>
                            </header>
                            <div class="tiers">
                                <div class="tier">
                                    <h2>Tier 1</h2>
                                    <div class="services">
                                        <div class="service"><strong>40</strong>&nbsp;Web 2.0 Blogs</div>
                                        <div class="service"><strong>20</strong> PR 8-9 Backlinks</div>
                                        <div class="service"><strong>50</strong> TOP Social Bookmarks</div>
                                        <div class="service"><strong>20</strong> EDU Profiles</div>
                                        <div class="service"><strong>200</strong> Web 2.0 Profiles</div>
                                        <div class="service"><strong>20</strong> Media Wiki</div>
                                        <div class="service"><strong>15</strong> Social Network mix</div>
                                        <div class="service"><strong>20</strong> PDF/DOC Links</div>
                                        <div class="service"><strong>20</strong> Image Submission Links</div>
                                        <div class="service"><strong>3</strong> Niche Related Blog Posts</div>
                                        <div class="service"><strong>1</strong> Tumblr blog</div>
                                        <div class="service"><strong>1</strong> Weebly blog</div>
                                        <div class="service"><strong>1</strong> Wordpress blog</div>
                                        <div class="service"><strong>1</strong> Ezine Article</div>
                                        <div class="service"><strong>20</strong> Press Releases</div>
                                        <div class="service"><strong>2500</strong> Social Signals</div>
                                        <div class="service"><strong>20</strong> Comments for social signals</div>
                                        <div class="service">Video Creation</div>
                                        <div class="service"><strong>20</strong> Video Submission</div>
                                    </div>
                                </div>
                                <div class="tier">
                                    <h2>Tier 2</h2>
                                    <div class="services">
                                        <div class="service"><strong>4000</strong> Social Bookmarks Linkquice</div>
                                        <div class="service"><strong>4000</strong> Wikimedia Backlinks</div>
                                        <div class="service"><strong>40 000</strong> Blog Comments</div>
                                        <div class="service">LinkIndex Services</div>
                                    </div>
                                </div>
                            </div>
                            <a class="to-cart" data-product="147-seo-plan-backlinkcontrol-com">Subscribe</a>
                        </section>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop

@push('pagescript')
<script id="fsc-api"
        src="https://d1f8f9xcsvx3ha.cloudfront.net/sbl/0.7.1/fastspring-builder.min.js" type="text/javascript"
        data-storefront="backlinkcontrol<?= auth()->id() == 127?'.test':''?>.onfastspring.com/popup-backlinkcontrol"
        data-popup-closed="onFSPopupClosed"
        data-data-callback="dataCallbackFunction"
        data-error-callback="errorCallback"
>
</script>

<script>
    $(function() {
        $('.to-cart').on('click',function(){
            var $this = $(this);
            fscSessiontest.products = [];
            fscSessiontest.tags = {'referrer' : app.user.id, 'scenario' : 'martketplace-subscription'};
            fscSessiontest.products.push({'path' : $this.data('product'), 'quantity': 1});
            fastspring.builder.push(fscSessiontest);
        });
    });

    var fscSessiontest = { //fscSession
        'reset': true,
        'products' : [],
        'country' : null,
        'checkout': true
    };

    function onFSPopupClosed(orderReference) {
        if (orderReference) {
            fastspring.builder.reset();
            $('section.wrapper').prepend(`
            <div class="alert alert-success fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                Thank you for subscribing
            </div>
        `);
        }
    }

</script>
@endpush
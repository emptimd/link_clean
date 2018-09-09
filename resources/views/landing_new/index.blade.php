@extends('layouts.landing_new')

@section('pagemeta')
    <meta name="description" content="Linkquidator is a professional backlinks checking tool! Avoid Google Penalty - Find and remove all the bad links pointing to your website!">
    <meta name="keyword" content="penalty, google, penalized, google penalty, bad links, panda, penguin, backlinks, remove, linkquidator">
    <title>Service to find and remove bad links – Linkquidator.com</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ url('/landing_new/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ url('/landing_new/css/owl.theme.default.css') }}">

{{--    {!! Html::style(elixir('css/all.css')) !!}--}}
@endsection


@section('content')


<section class="welcome">
    <div class="container">
        <h1>
            Backlinks analyze <span>&</span> management tool
        </h1>

        <h2>Check your backlinks and avoid Google Penalty</h2>

        <form action="{{ url('demo') }}" method="post" id="demo">{{ csrf_field() }}
            <input type="text" id="demo-url" class="form-control" name="url" required
                   placeholder="Enter your URL to analyze backlinks"/>
            <button>Scan</button>
            @if (session('error'))<p class="error">{{ session('error') }}</p>@endif
            @if ($errors->has('url'))<p class="error">{{ $errors->first('url') }}</p>@endif

            <input id="demo-email-hidden" type="hidden" class="form-control" name="email">
            <input id="demo-password-hidden" type="hidden" class="form-control" name="password">
        </form>

        <div class="info">
            <h3>We use data from:</h3>
            <div class="icons">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="item">
                                <span class="image">
                                    <img src="{{ url('/landing_new/images/icon-magic.png') }}" alt="" />
                                </span>
                            <span class="txt">Seo Majestic</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="item">
                                <span class="image">
                                    <img src="{{ url('/landing_new/images/icon-arrows.png') }}" alt="" />
                                </span>
                            <span class="txt">Google API</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="item">
                                <span class="image">
                                    <img src="{{ url('/landing_new/images/icon-sosial.png') }}" alt="" />
                                </span>
                            <span class="txt">Social Engaged</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="item">
                                <span class="image">
                                    <img src="{{ url('/landing_new/images/icon-ogimage.png') }}" alt="" />
                                </span>
                            <span class="txt">Google Analytics</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="tab-title">
    <div class="container">
        <h2>see What’s inside !</h2>

        <ul class="tabs-menu">
            <li class="active">
                <a data-toggle="tab" href="#home">
                    <span class="img ico1">Backlink Removal Tool</span>

                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#menu1">
                    <span class="img ico2">Site Monitoring</span>

                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#menu2">
                    <span class="img ico3">Backlinks Analyze</span>

                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#menu3">
                    <span class="img ico4">Competitor Research</span>
                </a>
            </li>
        </ul>
    </div>
</section>

<section class="tab-main">
    <div class="container">
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <h3 class="main-title">Linkquidator is a professional service for finding and removing unnatural links. We have already helped over 5000 clients to get rid of Google penalties, and avoid any sanctions.</h3>

                <div class="row">
                    <div class="col-lg-5">
                        <h4 class="title first">Find Low Quality Backlinks</h4>
                        <p>Linkquidator is the easiest way to find low-quality, harmfull links. We use 38 different link factors to determine a backlink’s quality.</p>

                        <h4 class="title second">Generate Disavow</h4>
                        <p>Quickly learn the quality of links and identify the spammy ones. You can easily generate a Disavow File for Google in 1 click using our Disavow Generator. No more tedious routine!</p>

                        <h4 class="title third" style="padding-top: 20px;padding-left: 90px;">Regain Lost Rankings & Gain Traffic</h4>
                    </div>

                    <div class="col-lg-7">
                        <div class="image-container">
                            <img src="{{ url('/landing_new/images/apple2.png') }}" alt="" />
                        </div>
                        <p>
                            79% of analyzed domains lostpotential traffic because they had pages penalized by Google Penguin 4.0. Owners often did not even know the reasons behind the sanction because their whole domain was not punished but instead some page or pages had a spammy backlink profile and did not rank well enough.
                        </p>
                    </div>
                </div>


            </div>
            <div id="menu1" class="tab-pane fade">
                <h3 class="main-title">Linkquidator monitors backlinks and social signals to allow you to avoid Google penalties and to track your competitors’ link-building activities.</h3>

                <div class="row">
                    <div class="col-lg-5">
                        <h4 class="title first" style="padding-top: 24px;">Avoid Google Penalty</h4>
                        <p>Control and monitor what is happening with your backlinks in live time mode. Get rid of suspicious signals before Google includes them in rankings and punishes your website.</p>

                        <h4 class="title second" style="padding-top: 12px;">Exclude Negative SEO</h4>
                        <p>Find out about any suspicious actions on your website in live time mode. Eliminate Negative SEO influence before Google takes any consequences.</p>

                        <h4 class="title third" style="padding-top: 12px;">Secure <br />Link<br /> Building</h4>

                    </div>

                    <div class="col-lg-7">
                        <div class="image-container">
                            <img src="{{ url('/landing_new/images/apple.png') }}" alt="" />
                        </div>
                        <p style="padding-top: 40px;">Use Linkquidator Backlink Planner to explore potential link influence and quality before posting one. Make your link-building strategy more secure and exclude risks that could put you under sanctions and lose you traffic and customers.</p>
                    </div>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade">
                <h3 class="main-title">Linkquidator analyzes backlinks using a wide range of different marketing sources that make results more complete and derive unique trademark parameters like "Link Quality" and "Referral Influence".</h3>

                <div class="row">
                    <div class="col-lg-5">
                        <h4 class="title first">Determine Links Quality</h4>
                        <p>Explore the quality of each backlink and vary your link-building strategy based on the results.</p>

                        <h4 class="title second" style="padding-top: 12px;">Explore Backlink Influence</h4>
                        <p>Using different parameters, our algorithm derives Backlink Potential Influnce that objectively reflects the reference domain authority and specific donor page, and then passes it through the filters.</p>

                        <h4 class="title third" style="padding-top: 24px;">All Data in One Workflow</h4>

                    </div>

                    <div class="col-lg-7">
                        <div class="image-container">
                            <img src="{{ url('/landing_new/images/apple4.png') }}" alt="" />
                        </div>
                        <p>Linkquidator сollects and displays all data about your backlinks, crawling your website directly and using data from authoritive SEO & Marketing Tools and sources. So you don't need to use many different tools on different websites to perform a deep Link Audit.</p>
                    </div>
                </div>
            </div>
            <div id="menu3" class="tab-pane fade">
                <h3 class="main-title">See Link Building opportunities and improve your business by exploring your competition.</h3>

                <div class="row">
                    <div class="col-lg-5">
                        <h4 class="title first">Find Best Backlink Sources</h4>
                        <p>Find the best sources of backlinks and use them to improve your profile.</p>

                        <h4 class="title second" style="padding-top: 12px;">Evaluate Competitors’ Backlink Strategies</h4>
                        <p>Your competitors are spending a lot of time and resources to find new backlink sources. Check them and reverse engineer their backlinks.</p>

                        <h4 class="title third" style="padding-top: 24px;">Track Your Competitors’ Activity</h4>

                    </div>

                    <div class="col-lg-7">
                        <div class="image-container">
                            <img src="{{ url('/landing_new/images/apple3.png') }}" alt="" />
                        </div>
                        <p style="margin-top: -20px;">Monitor their activity and get reports about all changes to their websites.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="icons-area">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="icon">
                    <img src="{{ url('/landing_new/images/icon-domain-registration.png') }}" alt="" />
                </div>
                <h3>29,758</h3>
                <p>
                    Websites Analyzed
                </p>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="icon">
                    <img src="{{ url('/landing_new/images/icon-browser.png') }}" alt="" />
                </div>
                <h3>77,8 Million</h3>
                <p>
                    Links Finded
                </p>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="icon">
                    <img src="{{ url('/landing_new/images/icon-team.png') }}" alt="" />
                </div>
                <h3>912</h3>
                <p>
                    Active Users
                </p>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="icon">
                    <img src="{{ url('/landing_new/images/icon-internet-signal.png') }}" alt="" />
                </div>
                <h3>19,7 Milion</h3>
                <p>
                    Links Disawoved
                </p>
            </div>
        </div>
    </div>
</section>

<section class="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="owl-carousel owl-theme owl-loaded owl-drag">
                    <div class="item">
                        <div class="testimonial-item">
                            <div class="avatar">
                                <img src="{{ url('/landing_new/images/avatar.jpg') }}" alt="">
                            </div>
                            <div class="description">
                                <p>
                                    Linkquidator has unique workflow to monitor and manage how our Link Builders are improving our backlinks.
                                </p>
                            </div>

                            <div class="name">
                                <h3>Matt Sutton, <span>CMO at Sponge</span></h3>
                            </div>

                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-item">
                            <div class="avatar">
                                <img src="{{ url('/landing_new/images/avatar4.jpg') }}" alt="">
                            </div>
                            <div class="description">
                                <p>
                                    Linkquidator team helped us to get rid of Google Penguin. The only one tool that allowed to find quickly all low quality links.
                                </p>
                            </div>

                            <div class="name">
                                <h3>Lucia Garcia, <span>Project Manager at BK Media</span></h3>
                            </div>

                        </div>
                    </div>
                    <div class="item">
                        <div class="testimonial-item">
                            <div class="avatar">
                                <img src="{{ url('/landing_new/images/avatar3.jpg') }}" alt="">
                            </div>
                            <div class="description">
                                <p>
                                    Linkquidator is my Nr1 option for backlinks audit. Make the process much easier.
                                </p>
                            </div>

                            <div class="name">
                                <h3>Nilesh Jain, <span>Freelance SEO Analyst</span></h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


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
    <script src="{{ url('/landing_new/js/owl.carousel.min.js') }}"></script>
    <script src="{{ elixir('js/landing.js') }}" defer></script>
@endsection
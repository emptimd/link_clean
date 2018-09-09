@extends('layouts.landing_new')

@section('pagemeta')
    <meta name="description" content="We will help you find and remove your bad links. Contact us for more information.">
    <meta name="keyword" content="contact, information, get in touch, mobile, email, mail, e-mail, phone, skype, linkquidator, bad links, backlinks, chack, penalty, google">
    <title>Contact us and find out how to remove bad links! – Linkquidator.com</title>
@endsection

{{--@section('styles')--}}
    {{--{!! Html::style(elixir('css/style.css')) !!}--}}
{{--@endsection--}}

@section('content')
<!-- Page Content -->
<section class="welcome">
    <div class="container">
        <h1>
            Contact us
        </h1>


        <div class="info">
            <h3>We use data from:</h3>
            <div class="icons">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="item">
                                <span class="image">
                                    <img src="{{ url('/landing_new') }}/images/icon-magic.png" alt="" />
                                </span>
                            <span class="txt">Seo Majestic</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="item">
                                <span class="image">
                                    <img src="{{ url('/landing_new') }}/images/icon-arrows.png" alt="" />
                                </span>
                            <span class="txt">Social Engaged</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="item">
                                <span class="image">
                                    <img src="{{ url('/landing_new') }}/images/icon-sosial.png" alt="" />
                                </span>
                            <span class="txt">Seo Majestic</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="item">
                                <span class="image">
                                    <img src="{{ url('/landing_new') }}/images/icon-ogimage.png" alt="" />
                                </span>
                            <span class="txt">Seo Majestic</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<section class="content">
    <div class="container">
        <div class="row">

            <div class="col-sm-offset-1 col-sm-5">
                <p class="lato-regular-22 color-text-heading margin-bottom-30">If you have business inquiries or other questions, please fill out this form and we will get in touch
                    with you shortly. Thank you!</p>

                @include('shared.status')

                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        {{ $error }}
                    </div>
                @endforeach


                {!! Form::open(['url' => 'contact', 'class' => 'form-horizontal']) !!}
                {{--<form method="POST" action="https://linkquidator.com/contact" accept-charset="UTF-8" class="form-horizontal"><input name="_token" value="3rsn6WOQyx4hhMvMHbhkPeOprnUBlxtWprB35SmP" type="hidden">--}}
                    <div class="form-group margin-bottom-20">
                        <label class="control-label sr-only">Your Name</label>
                        <label for="name" class="control-label sr-only">Your Name</label>

                        <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-11">
                            {{--<input required="" class="form-control input-lg" placeholder="Your Name" name="name" value="" id="name" type="text">--}}
                            {!! Form::text('name', '', ['required', 'class' => 'form-control input-lg', 'placeholder' => 'Your Name']) !!}
                        </div>
                    </div>
                    <div class="form-group margin-bottom-20">
                        <label for="email" class="control-label sr-only">Your Email</label>

                        <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-11">
                            {{--<input required="" class="form-control input-lg" placeholder="Your Email" name="email" value="" id="email" type="email">--}}
                            {!! Form::email('email', '', ['required', 'class' => 'form-control input-lg', 'placeholder' => 'Your Email', 'type' => 'email']) !!}
                        </div>
                    </div>
                    <div class="form-group margin-bottom-20">
                        <label for="subject" class="control-label sr-only">Subject</label>

                        <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-11">
                            {{--<input class="form-control input-lg" placeholder="Subject" name="subject" value="" id="subject" type="text">--}}
                            {!! Form::text('subject', '', ['class' => 'form-control input-lg', 'placeholder' => 'Subject']) !!}
                        </div>
                    </div>
                    <div class="form-group margin-bottom-30">

                        <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-11">
                            {{--<textarea required="" class="form-control input-lg" placeholder="Message" name="message" cols="50" rows="10"></textarea>--}}
                            {!! Form::textArea('message', '', ['required', 'class' => 'form-control input-lg', 'placeholder' => 'Message']) !!}
                        </div>

                        <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-11 padding-top-20">
                            <button class="btn btn-orange " type="submit"><span class="lato-bold-24 color-white text-shadow">Send Message</span></button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="col-sm-offset-1 col-sm-5">
                <img src="{{ url('/landing') }}/images/map-contactus.png" alt="" class="img-responsive">

                <p class="lato-regular-18 color-text padding-top-20">1201 Peachtree St NE <br>
                    Atlanta, GA, USA</p>
                <p class="lato-bold-24 color-text-heading padding-top-30 padding-bottom-20">Have a question?</p>

                <i class="fa fa-envelope fa-2x va-middle margin-right-5" style="color: #1a3b6b;"></i><a href="mailto:info@linkquidator.com" class="va-middle margin-right-10"> <span class="color-text lato-regular-18">info@linkquidator.com</span></a>
                <i class="fa fa-skype fa-2x va-middle margin-right-5" style="color: #1a3b6b;"></i><a href="skype:linkquidator?chat" class="va-middle"> <span class="color-text lato-regular-18">linkquidator</span></a>
            </div>

        </div>

        <div class="row">

            <div class="col-sm-12">
                <ul class="unstyled accordion-list ">
                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title lato-regular-22">Where is data coming from?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    A large part of the data comes from the most famous and authoritative SEO services (SEO Majestic, ahrefs, SEMrush, etc.), while the other part we are crawling directly. At the moment we use data from a total of 24 different sources, and are still working to improve it.
                                </p></div>
                        </div>
                    </li>

                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">How does your algorithm define Link Quality?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    Our algorithm looks at a combination of factors and signals that may impact on the Penguin update and can be SPAM indicators. For example, we can determine:
                                </p><ul style="font-size: 15px;padding-left: 25px;list-style-type: circle;">
                                    <li>Outbound backlinks</li>
                                    <li>Anchor vs Total Text Ratio</li>
                                    <li>Social signals</li>
                                    <li>Link attributes</li>
                                    <li>Website Page Authority and trust</li>
                                    <li>Banned in Google or not</li>
                                    <li>External backlinks count to domain/page</li>
                                    <li>Malware test</li>
                                    <li>Count of external links in sidebar/footer</li>
                                    <li>text vs html ratio</li>
                                    <li>Content count on page</li>
                                    <li>Content quality</li>
                                    <li>Pages in index of Google And much more…</li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">But how can you know how the Google Penguin algorithm really works?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    We cannot know the algorithm of Google. No one can. However, we can evaluate your references and risk harm to your site based on the experience of experts. How does an SEO expert or SEO studio determine harmful effects on your site from your links? They simply go for it and analyze its quality on the basis of a number of factors (quality of the source, the quality of content, location of the links, anchor text, outgoing backlinks, and so on). Afterwards, they conclude the danger based on the totality of evidence. Our service simply does this automatically and much more quickly. Initially, LinkQuidator was created to automate our internal processes for such tasks.
                                </p></div>
                        </div>
                    </li>
                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">What is Referral influence?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    Referral Influence - this is our new trademark parameter that reflects the potential effect of a backlink on your page. How do you estimate Referral Influence? First, we derive the parameter that objectively reflects the reference domain authority and specific donor page, and then pass it through the filters, the factors that may affect the impact of the link and the volume that it can transmit. For example, on the basis of our data, we can make conclusions about the time of its indexation, the role of the pages on the site, we can check outbound backlinks, external links on the page, content quality, social signals and so on. The process is pretty similar to how we define Link Quality, only we use different formulas and indicators.
                                </p></div>
                        </div>
                    </li>
                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">Why is link quality critical, yet it has great referral influence? How can this be?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    Yes, it can be. You have to understand that Google uses different algorithms to determine doubtful and bad links and to calculate the trust and authority of the domain and others to rank your page. As such, bad links may provide a reference volume. That is why you can still see in the index bad sites or doorway pages with a lot of questionable links. However, as soon as Google tests the quality and naturalness of the links through Penguin, the site instantly gets a penalty or removed from the top.
                                </p></div>
                        </div>
                    </li>
                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">Can I use your tool for link building?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    Sure you can. You have to understand that we provide only tools, and so the result will depend on how you will use them. For example, you must know that Google is trying to keep an eye not only on the number of bad links on your pages, but also how quickly and naturally they appeared.
                                </p></div>
                        </div>
                    </li>
                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">What does Suspicious Referrals mean?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    Suspicious referrals are domains from which you receive many poor quality links (spammy, bad, critical).
                                </p></div>
                        </div>
                    </li>
                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">Do I need to worry about the quality of the No Follow links? Google says they ignores them.</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    Not in that way. Google says it will not take them into account as a ranking factor, but Penguin has always perceived these kind of links as a factor. Secondly, after the update of September 23, 2016, Penguin 4.0 became part of the core algorithm and now they try not to penalize your site right away, and are simply trying just to remove spammy pages from the index. And this means that potentially bad No Follow links can directly effect your traffic.
                                </p></div>
                        </div>
                    </li>
                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">Google says it does not consider No Follow links, but I see some small Referral Influence from them.</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    That’s true. Indeed, we are inclined to believe that Google take them into account as some kind of signal. As many No Follow links often bring natural referral traffic, we see no reason to consider them as totally useless. Many experts even argue about whether they take into account the search engines. But of course if they do have some influence, it is many times weaker than Do Follow links.
                                </p></div>
                        </div>
                    </li>
                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">What new features and tools are you developing?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    Nothing special, though we are currently developing and preparing to release integration with Google Analytics, an online monitoring system of your backlinks, the ability to communicate with the owners of the domains, and a number of other innovations that will make our service more convenient and accurate. However, our main priority is still on the constant improvement of the tools that we have. We are constantly trying to find and process as much data as is possible and improve our algorithms. We are probably not the cute guys who are good at everything; we are more like the geeks that are best at one thing!
                                </p></div>
                        </div>
                    </li>

                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">Why the service is monthly?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    Linkquidator is a monthly service because backlinks check is not a one-time action and it must be done on a regular basis. Anyway you can cancel your subscription when you want.
                                </p></div>
                        </div>
                    </li>

                    <li class="accordion-list--item">
                        <div class="accordion-inner--wrapper"><input class="accordion--control" aria-expanded="false" checked="checked" type="checkbox"><h5 class="accordion--title  lato-regular-22">Why you ask to include your payment information for the trial period ?</h5>

                            <div id="" class="accordion--content" aria-hidden="true"><p class="lato-regular-18 color-text">
                                    That's the best way to avoid one persons multiple account registration with several mail addresses. We will not charge money from your card or paypal during trial period. Anyway we even have 30 day money-back guarantee.
                                </p></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
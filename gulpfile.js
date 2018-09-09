process.env.DISABLE_NOTIFIER = true;
const elixir = require('laravel-elixir'),
    gulp = require('gulp'),
    stripDebug = require('gulp-strip-debug');
const extractMediaQueries = require('gulp-extract-media-queries');
const minifycss = require('gulp-clean-css');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.extend('strip', function(script) {
    new elixir.Task('strip', function() {
        return gulp.src(script)
            .pipe(stripDebug())
            .pipe(gulp.dest(function(file) {
                return file.base;
            }));
    });
});

elixir.extend('extractMediaQueries', function(script) {
    new elixir.Task('extractMediaQueries', function() {
        return gulp.src(script)
            .pipe(extractMediaQueries())
            .pipe(minifycss({specialComments:0}))
            .pipe(gulp.dest(function(file) {
                return file.base;
            }));
    });
});

elixir(function(mix) {
    //mnify back js
    mix.rollup('dashboard.js');
    mix.rollup('user_add_backlinks.js');
    mix.rollup('user_check_backlinks.js');
    mix.rollup('demo.js');
    mix.rollup('campaign_new.js');
    mix.rollup('campaign_backlinks.js');
    mix.rollup('destination_target.js');
    mix.rollup('clients.js');
    mix.rollup('refsingle.js');
    mix.rollup('refs.js');
    mix.rollup('topics_single.js');
    mix.rollup('theme/destination.js', 'public/js/destination.js');//public/theme/js/destination.js
    mix.rollup('theme/common-scripts.js', 'public/theme/js/common-scripts.js');
    mix.rollup('theme/referrals.js', 'public/theme/js/referrals.js');

    //concat + minify back js
    mix.combine([
        'landing/js/bootstrap.min.js',
        'theme/js/jquery.dcjqaccordion.2.7.js',
        'theme/js/jquery.scrollTo.min.js',
        'theme/js/jquery.nicescroll.js',
        'theme/js/common-scripts.js'
    ], 'public/js/backend.js', 'public/');

    mix.combine([
        'js/clipboard.min.js',
        'js/referrals.js'
    ], 'public/js/referrals.js', 'public/theme/');

    mix.combine([
        'jquery.knob.js',
        'campaign_ga_backlinkcontrol.js'
    ], 'public/backlink/js/campaign_ga_backlinkcontrol.js', 'resources/assets/js/backlink');

    mix.rollup('landing.js', 'public/landing/js/landing.js');

    //concat + minify front js
    mix.combine(['landing/js/siema.min-old.js'/*, 'theme/js/owl.carousel.js'*/, 'landing/js/jquery.magnific-popup.min.js', 'landing/js/landing.js'], 'public/js/landing.js', 'public/');
    // if (elixir.config.production) {
    //     mix.strip('./public/js/dashboard.js');
    // }
    //sass
    mix.sass('style.scss', 'public/css/style.css');
    mix.extractMediaQueries('./public/css/style.css');

    //frontend css
    mix.styles([
        "css/style.css",
        // "landing/owl-carousel/owl.carousel.css",
        "landing/css/magnific-popup.css",
        // "landing/owl-carousel/owl.theme.css"
    ], 'public/css/all.css', 'public/');
    //backend css
    mix.styles([
        'theme/css/bootstrap.min.css',
        'theme/css/bootstrap-reset.css',
        'landing/css/font-awesome.min.css',
        'theme/css/style.css',
        'theme/css/style-responsive.css',
        'theme/css/flags.css',
        'theme/css/custom.css',
        'theme/assets/bootstrap-switch/static/stylesheets/bootstrap-switch.css'
    ], 'public/css/backend.css', 'public/');

    mix.version(['js/dashboard.js', 'js/user_add_backlinks.js', 'js/user_check_backlinks.js' , 'js/dashboard_backlinkcontrol.js', 'js/campaign_new.js', 'backlink/js/campaign_new_backlinkcontrol.js', 'backlink/js/campaign_ga_backlinkcontrol.js', 'js/campaign_backlinks.js', 'js/destination_target.js', 'js/clients.js', 'js/backend.js', 'js/support.js', 'js/landing.js','js/demo.js',
        'js/refsingle.js', 'js/refs.js', 'js/topics_single.js', 'js/destination.js', 'js/referrals.js', 'js/subscription.js',
        'css/all.css', 'css/style.css', 'css/backend.css', 'theme/css/style.css',
        'css/max-device-width480px-and-orientationlandscape.css', 'css/max-width767px.css', 'css/max-width991px.css',
        'css/max-width1199px.css', 'css/min-width768px.css', 'css/min-width768px-and-max-width991px.css', 'css/min-width992px.css',
        'css/min-width992px-and-max-width1199px.css', 'css/min-width1200px.css', 'css/print.css',
        'css/screen-and-min-width768px.css', 'css/screen-and-webkit-min-device-pixel-ratio0.css'
    ]);

});

/*!jQuery Knob*/
/**
 * Downward compatible, touchable dial
 *
 * Version: 1.2.0 (15/07/2012)
 * Requires: jQuery v1.7+
 *
 * Copyright (c) 2012 Anthony Terrien
 * Under MIT and GPL licenses:
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
 *
 * Thanks to vor, eskimoblood, spiffistan, FabrizioC
 */
(function($) {

    /**
     * Kontrol library
     */
    "use strict";

    /**
     * Definition of globals and core
     */
    var k = {}, // kontrol
        max = Math.max,
        min = Math.min;

    k.c = {};
    k.c.d = $(document);
    k.c.t = function (e) {
        return e.originalEvent.touches.length - 1;
    };

    /**
     * Kontrol Object
     *
     * Definition of an abstract UI control
     *
     * Each concrete component must call this one.
     * <code>
     * k.o.call(this);
     * </code>
     */
    k.o = function () {
        var s = this;

        this.o = null; // array of options
        this.$ = null; // jQuery wrapped element
        this.i = null; // mixed HTMLInputElement or array of HTMLInputElement
        this.g = null; // 2D graphics context for 'pre-rendering'
        this.v = null; // value ; mixed array or integer
        this.cv = null; // change value ; not commited value
        this.x = 0; // canvas x position
        this.y = 0; // canvas y position
        this.$c = null; // jQuery canvas element
        this.c = null; // rendered canvas context
        this.t = 0; // touches index
        this.isInit = false;
        this.fgColor = null; // main color
        this.pColor = null; // previous color
        this.dH = null; // draw hook
        this.cH = null; // change hook
        this.eH = null; // cancel hook
        this.rH = null; // release hook

        this.run = function () {
            var cf = function (e, conf) {
                var k;
                for (k in conf) {
                    s.o[k] = conf[k];
                }
                s.init();
                s._configure()
                 ._draw();
            };

            if(this.$.data('kontroled')) return;
            this.$.data('kontroled', true);

            this.extend();
            this.o = $.extend(
                {
                    // Config
                    min : this.$.data('min') || 0,
                    max : this.$.data('max') || 100,
                    stopper : true,
                    readOnly : this.$.data('readonly'),

                    // UI
                    cursor : (this.$.data('cursor') === true && 30)
                                || this.$.data('cursor')
                                || 0,
                    thickness : this.$.data('thickness') || 0.35,
                    width : this.$.data('width') || 200,
                    height : this.$.data('height') || 200,
                    displayInput : this.$.data('displayinput') == null || this.$.data('displayinput'),
                    displayPrevious : this.$.data('displayprevious'),
                    fgColor : this.$.data('fgcolor') || '#87CEEB',
                    inline : false,

                    // Hooks
                    draw : null, // function () {}
                    change : null, // function (value) {}
                    cancel : null, // function () {}
                    release : null // function (value) {}
                }, this.o
            );

            // routing value
            if(this.$.is('fieldset')) {

                // fieldset = array of integer
                this.v = {};
                this.i = this.$.find('input')
                this.i.each(function(k) {
                    var $this = $(this);
                    s.i[k] = $this;
                    s.v[k] = $this.val();

                    $this.bind(
                        'change'
                        , function () {
                            var val = {};
                            val[k] = $this.val();
                            s.val(val);
                        }
                    );
                });
                this.$.find('legend').remove();

            } else {
                // input = integer
                this.i = this.$;
                this.v = this.$.val();
                (this.v == '') && (this.v = this.o.min);

                this.$.bind(
                    'change'
                    , function () {
                        s.val(s.$.val());
                    }
                );
            }

            (!this.o.displayInput) && this.$.hide();

            this.$c = $('<canvas width="' +
                            this.o.width + 'px" height="' +
                            this.o.height + 'px"></canvas>');
            this.c = this.$c[0].getContext("2d");

            this.$
                .wrap($('<div style="' + (this.o.inline ? 'display:inline;' : '') +
                        'width:' + this.o.width + 'px;height:' +
                        this.o.height + 'px;"></div>'))
                .before(this.$c);

            if (this.v instanceof Object) {
                this.cv = {};
                this.copy(this.v, this.cv);
            } else {
                this.cv = this.v;
            }

            this.$
                .bind("configure", cf)
                .parent()
                .bind("configure", cf);

            this._listen()
                ._configure()
                ._xy()
                .init();

            this.isInit = true;

            this._draw();

            return this;
        };

        this._draw = function () {

            // canvas pre-rendering
            var d = true,
                c = document.createElement('canvas');

            c.width = s.o.width;
            c.height = s.o.height;
            s.g = c.getContext('2d');

            s.clear();

            s.dH
            && (d = s.dH());

            (d !== false) && s.draw();

            s.c.drawImage(c, 0, 0);
            c = null;
        };

        this._touch = function (e) {

            var touchMove = function (e) {

                var v = s.xy2val(
                            e.originalEvent.touches[s.t].pageX,
                            e.originalEvent.touches[s.t].pageY
                            );

                if (v == s.cv) return;

                if (
                    s.cH
                    && (s.cH(v) === false)
                ) return;


                s.change(v);
                s._draw();
            };

            // get touches index
            this.t = k.c.t(e);

            // First touch
            touchMove(e);

            // Touch events listeners
            k.c.d
                .bind("touchmove.k", touchMove)
                .bind(
                    "touchend.k"
                    , function () {
                        k.c.d.unbind('touchmove.k touchend.k');

                        if (
                            s.rH
                            && (s.rH(s.cv) === false)
                        ) return;

                        s.val(s.cv);
                    }
                );

            return this;
        };

        this._mouse = function (e) {

            var mouseMove = function (e) {
                var v = s.xy2val(e.pageX, e.pageY);
                if (v == s.cv) return;

                if (
                    s.cH
                    && (s.cH(v) === false)
                ) return;

                s.change(v);
                s._draw();
            };

            // First click
            mouseMove(e);

            // Mouse events listeners
            k.c.d
                .bind("mousemove.k", mouseMove)
                .bind(
                    // Escape key cancel current change
                    "keyup.k"
                    , function (e) {
                        if (e.keyCode === 27) {
                            k.c.d.unbind("mouseup.k mousemove.k keyup.k");

                            if (
                                s.eH
                                && (s.eH() === false)
                            ) return;

                            s.cancel();
                        }
                    }
                )
                .bind(
                    "mouseup.k"
                    , function (e) {
                        k.c.d.unbind('mousemove.k mouseup.k keyup.k');

                        if (
                            s.rH
                            && (s.rH(s.cv) === false)
                        ) return;

                        s.val(s.cv);
                    }
                );

            return this;
        };

        this._xy = function () {
            var o = this.$c.offset();
            this.x = o.left;
            this.y = o.top;
            return this;
        };

        this._listen = function () {

            if (!this.o.readOnly) {
                this.$c
                    .bind(
                        "mousedown"
                        , function (e) {
                            e.preventDefault();
                            s._xy()._mouse(e);
                         }
                    )
                    .bind(
                        "touchstart"
                        , function (e) {
                            e.preventDefault();
                            s._xy()._touch(e);
                         }
                    );
                this.listen();
            } else {
                this.$.attr('readonly', 'readonly');
            }

            return this;
        };

        this._configure = function () {

            // Hooks
            if (this.o.draw) this.dH = this.o.draw;
            if (this.o.change) this.cH = this.o.change;
            if (this.o.cancel) this.eH = this.o.cancel;
            if (this.o.release) this.rH = this.o.release;

            if (this.o.displayPrevious) {
                this.pColor = this.h2rgba(this.o.fgColor, "0.4");
                this.fgColor = this.h2rgba(this.o.fgColor, "0.6");
            } else {
                this.fgColor = this.o.fgColor;
            }

            return this;
        };

        this._clear = function () {
            this.$c[0].width = this.$c[0].width;
        };

        // Abstract methods
        this.listen = function () {}; // on start, one time
        this.extend = function () {}; // each time configure triggered
        this.init = function () {}; // each time configure triggered
        this.change = function (v) {}; // on change
        this.val = function (v) {}; // on release
        this.xy2val = function (x, y) {}; //
        this.draw = function () {}; // on change / on release
        this.clear = function () { this._clear(); };

        // Utils
        this.h2rgba = function (h, a) {
            var rgb;
            h = h.substring(1,7)
            rgb = [parseInt(h.substring(0,2),16)
                   ,parseInt(h.substring(2,4),16)
                   ,parseInt(h.substring(4,6),16)];
            return "rgba(" + rgb[0] + "," + rgb[1] + "," + rgb[2] + "," + a + ")";
        };

        this.copy = function (f, t) {
            for (var i in f) { t[i] = f[i]; }
        };
    };


    /**
     * k.Dial
     */
    k.Dial = function () {
        k.o.call(this);

        this.startAngle = null;
        this.xy = null;
        this.radius = null;
        this.lineWidth = null;
        this.cursorExt = null;
        this.w2 = null;
        this.PI2 = 2*Math.PI;

        this.extend = function () {
            this.o = $.extend(
                {
                    bgColor : this.$.data('bgcolor') || '#EEEEEE',
                    angleOffset : this.$.data('angleoffset') || 0,
                    angleArc : this.$.data('anglearc') || 360,
                    inline : true
                }, this.o
            );
        };

        this.val = function (v) {
            if (null != v) {
                this.cv = this.o.stopper ? max(min(v, this.o.max), this.o.min) : v;
                this.v = this.cv;
                this.$.val(this.v);
                this._draw();
            } else {
                return this.v;
            }
        };

        this.xy2val = function (x, y) {
            var a, ret;

            a = Math.atan2(
                        x - (this.x + this.w2)
                        , - (y - this.y - this.w2)
                    ) - this.angleOffset;

            if(this.angleArc != this.PI2 && (a < 0) && (a > -0.5)) {
                // if isset angleArc option, set to min if .5 under min
                a = 0;
            } else if (a < 0) {
                a += this.PI2;
            }

            ret = ~~ (0.5 + (a * (this.o.max - this.o.min) / this.angleArc))
                    + this.o.min;

            this.o.stopper
            && (ret = max(min(ret, this.o.max), this.o.min));

            return ret;
        };

        this.listen = function () {
            // bind MouseWheel
            var s = this,
                mw = function (e) {
                            e.preventDefault();

                            var ori = e.originalEvent
                                ,deltaX = ori.detail || ori.wheelDeltaX
                                ,deltaY = ori.detail || ori.wheelDeltaY
                                ,v = parseInt(s.$.val()) + (deltaX>0 || deltaY>0 ? 1 : deltaX<0 || deltaY<0 ? -1 : 0);

                            if (
                                s.cH
                                && (s.cH(v) === false)
                            ) return;

                            s.val(v);
                        }
                , kval, to, m = 1, kv = {37:-1, 38:1, 39:1, 40:-1};

            this.$
                .bind(
                    "keydown"
                    ,function (e) {
                        var kc = e.keyCode;

                        // numpad support
                        if(kc >= 96 && kc <= 105) {
                            kc = e.keyCode = kc - 48;
                        }

                        kval = parseInt(String.fromCharCode(kc));

                        if (isNaN(kval)) {

                            (kc !== 13)         // enter
                            && (kc !== 8)       // bs
                            && (kc !== 9)       // tab
                            && (kc !== 189)     // -
                            && e.preventDefault();

                            // arrows
                            if ($.inArray(kc,[37,38,39,40]) > -1) {
                                e.preventDefault();

                                var v = parseInt(s.$.val()) + kv[kc] * m;

                                s.o.stopper
                                && (v = max(min(v, s.o.max), s.o.min));

                                s.change(v);
                                s._draw();

                                // long time keydown speed-up
                                to = window.setTimeout(
                                    function () { m*=2; }
                                    ,30
                                );
                            }
                        }
                    }
                )
                .bind(
                    "keyup"
                    ,function (e) {
                        if (isNaN(kval)) {
                            if (to) {
                                window.clearTimeout(to);
                                to = null;
                                m = 1;
                                s.val(s.$.val());
                            }
                        } else {
                            // kval postcond
                            (s.$.val() > s.o.max && s.$.val(s.o.max))
                            || (s.$.val() < s.o.min && s.$.val(s.o.min));
                        }

                    }
                );

            this.$c.bind("mousewheel DOMMouseScroll", mw);
            this.$.bind("mousewheel DOMMouseScroll", mw)
        };

        this.init = function () {

            if (
                this.v < this.o.min
                || this.v > this.o.max
            ) this.v = this.o.min;

            this.$.val(this.v);
            this.w2 = this.o.width / 2;
            this.cursorExt = this.o.cursor / 100;
            this.xy = this.w2;
            this.lineWidth = this.xy * this.o.thickness;
            this.radius = this.xy - this.lineWidth / 2;

            this.o.angleOffset
            && (this.o.angleOffset = isNaN(this.o.angleOffset) ? 0 : this.o.angleOffset);

            this.o.angleArc
            && (this.o.angleArc = isNaN(this.o.angleArc) ? this.PI2 : this.o.angleArc);

            // deg to rad
            this.angleOffset = this.o.angleOffset * Math.PI / 180;
            this.angleArc = this.o.angleArc * Math.PI / 180;

            // compute start and end angles
            this.startAngle = 1.5 * Math.PI + this.angleOffset;
            this.endAngle = 1.5 * Math.PI + this.angleOffset + this.angleArc;

            var s = max(
                            String(Math.abs(this.o.max)).length
                            , String(Math.abs(this.o.min)).length
                            , 2
                            ) + 2;

            this.o.displayInput
                && this.i.css({
                        'width' : ((this.o.width / 2 + 4) >> 0) + 'px'
                        ,'height' : ((this.o.width / 3) >> 0) + 'px'
                        ,'position' : 'absolute'
                        ,'vertical-align' : 'middle'
                        ,'margin-top' : ((this.o.width / 3) >> 0) + 'px'
                        ,'margin-left' : '-' + ((this.o.width * 3 / 4 + 2) >> 0) + 'px'
                        ,'border' : 0
                        ,'background' : 'none'
                        ,'font' : 'bold ' + ((this.o.width / s) >> 0) + 'px Arial'
                        ,'text-align' : 'center'
                        ,'color' : this.o.fgColor
                        ,'padding' : '0px'
                        ,'-webkit-appearance': 'none'
                        })
                || this.i.css({
                        'width' : '0px'
                        ,'visibility' : 'hidden'
                        });
        };

        this.change = function (v) {
            this.cv = v;
            this.$.val(v);
        };

        this.angle = function (v) {
            return (v - this.o.min) * this.angleArc / (this.o.max - this.o.min);
        };

        this.draw = function () {

            var c = this.g,                 // context
                a = this.angle(this.cv)    // Angle
                , sat = this.startAngle     // Start angle
                , eat = sat + a             // End angle
                , sa, ea                    // Previous angles
                , r = 1;

            c.lineWidth = this.lineWidth;

            this.o.cursor
                && (sat = eat - this.cursorExt)
                && (eat = eat + this.cursorExt);

            c.beginPath();
                c.strokeStyle = this.o.bgColor;
                c.arc(this.xy, this.xy, this.radius, this.endAngle, this.startAngle, true);
            c.stroke();

            if (this.o.displayPrevious) {
                ea = this.startAngle + this.angle(this.v);
                sa = this.startAngle;
                this.o.cursor
                    && (sa = ea - this.cursorExt)
                    && (ea = ea + this.cursorExt);

                c.beginPath();
                    c.strokeStyle = this.pColor;
                    c.arc(this.xy, this.xy, this.radius, sa, ea, false);
                c.stroke();
                r = (this.cv == this.v);
            }

            c.beginPath();
                c.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                c.arc(this.xy, this.xy, this.radius, sat, eat, false);
            c.stroke();
        };

        this.cancel = function () {
            this.val(this.v);
        };
    };

    $.fn.dial = $.fn.knob = function (o) {
        return this.each(
            function () {
                var d = new k.Dial();
                d.o = o;
                d.$ = $(this);
                d.run();
            }
        ).parent();
    };

})(jQuery);
$(function() {
    let campaign_id = $('#custom-data').val();
    $(".knob").knob( {
        readOnly: true
    });

    Math.easeOutBounce = function (pos) {
        if ((pos) < (1 / 2.75)) {
            return (7.5625 * pos * pos);
        }
        if (pos < (2 / 2.75)) {
            return (7.5625 * (pos -= (1.5 / 2.75)) * pos + 0.75);
        }
        if (pos < (2.5 / 2.75)) {
            return (7.5625 * (pos -= (2.25 / 2.75)) * pos + 0.9375);
        }
        return (7.5625 * (pos -= (2.625 / 2.75)) * pos + 0.984375);
    };



    /*Hight chart*/
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });


//        var d = $(".chart-container"),
//            c = [];
//
//        var t ={"dances":[],
//            "organicVisits":[{"name":"2017-05-10","y":0},{"name":"2017-05-11","y":1},{"name":"2017-05-12","y":0},{"name":"2017-05-13","y":0},{"name":"2017-05-14","y":0},{"name":"2017-05-15","y":1},{"name":"2017-05-16","y":1},{"name":"2017-05-17","y":0},{"name":"2017-05-18","y":1},{"name":"2017-05-19","y":1},{"name":"2017-05-20","y":2},{"name":"2017-05-21","y":0},{"name":"2017-05-22","y":0},{"name":"2017-05-23","y":2},{"name":"2017-05-24","y":1},{"name":"2017-05-25","y":1},{"name":"2017-05-26","y":0},{"name":"2017-05-27","y":1},{"name":"2017-05-28","y":2},{"name":"2017-05-29","y":1},{"name":"2017-05-30","y":0},{"name":"2017-05-31","y":1},{"name":"2017-06-01","y":0},{"name":"2017-06-02","y":1}],
//            "Search":[{"name":"2017-06-01","y":9},{"name":"2017-06-02","y":14},{"name":"2017-06-03","y":3},{"name":"2017-06-04","y":10},{"name":"2017-06-05","y":7},{"name":"2017-06-06","y":17},{"name":"2017-06-07","y":11},{"name":"2017-06-08","y":9},{"name":"2017-06-09","y":15},{"name":"2017-06-10","y":7},{"name":"2017-06-11","y":10},{"name":"2017-06-12","y":8},{"name":"2017-06-13","y":"18"}],
////            "organicVisits2":[{"name":"2017-05-10","y":11},{"name":"2017-05-11","y":12},{"name":"2017-05-12","y":4},{"name":"2017-05-13","y":0},{"name":"2017-05-14","y":0},{"name":"2017-05-15","y":1},{"name":"2017-05-16","y":1},{"name":"2017-05-17","y":0},{"name":"2017-05-18","y":1},{"name":"2017-05-19","y":1},{"name":"2017-05-20","y":2},{"name":"2017-05-21","y":0},{"name":"2017-05-22","y":0},{"name":"2017-05-23","y":2},{"name":"2017-05-24","y":1},{"name":"2017-05-25","y":1},{"name":"2017-05-26","y":0},{"name":"2017-05-27","y":1},{"name":"2017-05-28","y":2},{"name":"2017-05-29","y":1},{"name":"2017-05-30","y":0},{"name":"2017-05-31","y":1},{"name":"2017-06-01","y":0},{"name":"2017-06-02","y":1}],
//
//            "averageKeywordPosition":[],"newBacklinksBad":[{"name":"2017-05-23","y":1}],"newBacklinksGood":[{"name":"2017-05-10","y":1}],"statistics":{"averageKeywordPosition":{"status":"0<small>%<\/small>","statusSign":"up","details":" current"},"newBacklinks":{"status":2,"statusSign":"","details":"(1 no SEO value)"},"organicVisits":{"status":"100<small>%<\/small>","statusSign":"up","details":"17 visits"}}};
//        var s = {};
//        for (var o in t)
//            if (t.hasOwnProperty(o)) {
//                for (var r = [], l = 0; l < t[o].length; l++) r.push([Date.parse(t[o][l].name), t[o][l].y]);
//                s[o] = r
//        }
//        console.log(s);
//        for (var h in t) t.hasOwnProperty(h) && c.push({
//            value: Date.parse(t[h][1]),
//            color: t[h][0],
//            width: 2,
//            label: {
//                useHTML: !0,
//                text: '<div class="plotline-label" data-url=' + encodeURIComponent(t[h][2]) + ">" + h + "</div>"
//            }
//        });


    if(!localStorage.getItem('interval')) localStorage.setItem('interval', 1);
    if(!localStorage.getItem('traffic')) localStorage.setItem('traffic', 1);

    drawChartLiniear(localStorage.getItem('interval'),localStorage.getItem('traffic'), false);

    let $interval = $('#input-interval'),
        $traffic =  $('#input-traffic');
    $interval.val(localStorage.getItem('interval'));
    $traffic.val(localStorage.getItem('traffic'));


    $interval.add($traffic).on('change',function(){
        drawChartLiniear($interval.val(),$traffic.val(), true);
    });

    var s2 = {};

    let highcart = Highcharts.chart('container', {
        chart: {
            type: 'areaspline',
            animation: Highcharts.svg, // don't animate in old IE
            marginRight: 10,
//                dateFormat: '%d',
            colors:["#FF7F00","#CE83C7","#59B1F1"],
            // colors:["#59B1F1"],
//                colors: ["#FF7F00", "#CE83C7", "#59B1F1", "#59B1F1"],
        },
        tooltip: {
            crosshairs: [!0, !0],
            shared: !0,
        },
        title: {
            text: null
        },
        legend: {
            enabled: !1
        },
        credits: {
            enabled: !1
        },
        // colors: ["#FF7F00", "#CE83C7", "#59B1F1", "#59B1F1"],
        xAxis: {
            type: "datetime",
            gridLineWidth: 1,
            gridLineColor: "#DCDCDC",
            lineColor: "#DCDCDC",
            labels: {
                y: 30,
                style: {
                    color: "#10141F",
                    fontSize: "1.5em",
                    fontWeight: "300",
                    fontFamily: "Open Sans,sans-serif"
                },
                format: "{value: %b %d}"
            },
//                plotLines: c
        },
        yAxis: [{
            title: {
                text: null
            },
            gridLineWidth: 1,
            gridLineDashStyle: "Dash",
            gridLineColor: "#DCDCDC",
            tickPixelInterval: 40,
            labels: {
                y: 5,
                step: 2,
                style: {
                    color: "#10141F",
                    fontSize: "1em",
                    fontWeight: "600",
                    fontFamily: "Open Sans,sans-serif"
                }
            }
        }, {
            title: {
                text: null
            },
            opposite: !0,
            reversed: !0,
            gridLineDashStyle: "Dash",
            gridLineColor: "#DCDCDC",
            labels: {
                y: 5,
                step: 2,
                style: {
                    color: "#10141F",
                    fontSize: "1em",
                    fontWeight: "600",
                    fontFamily: "Open Sans,sans-serif"
                }
            }
        }],
        plotOptions: {
            column: {
                stacking: "normal"
            }
        },
        exporting: {
            enabled: !1,
            buttons: {
                contextButton: {
                    enabled: !1
                }
            }
        },
    });


    function drawChartLiniear(interval, traffic, redraw) {
        // console.log(localStorage.getItem('interval'));
        // console.log("INTERVAL" + traffic);
        if(redraw && interval == localStorage.getItem('interval')) {
            highcart.series[0].remove(false);
            // while(highcart.series.length > 0)
            //     highcart.series[0].remove(false);
            // highcart.series[1].remove(false);
            // highcart.series[2].remove(false);

            if(traffic == 1)  {
                highcart.addSeries({
                    index: 0,
                    zIndex:1,
                    name: "Traffic from Search Engines",
                    data: s2.Search,
                    color: "#59B1F1",
                }, true);
            }
            else if (traffic == 2) {
                highcart.addSeries({
                    index: 0,
                    zIndex:1,
                    name: "Traffic from Referral Websites",
                    data: s2.Referral,
                    color: "#59B1F1",
                }, true);
            }
            else {
                highcart.addSeries({
                    index: 0,
                    zIndex:1,
                    name: "Traffic from Social Websites",
                    data: s2.Social,
                    color: "#59B1F1",
                }, true);
            }
        }else {
            $.ajax({
                type: 'POST',
                url: location.protocol+'//'+location.host+'/campaign/getVisits',
                data: { campaign_id, months: interval }
            }).done(function( data ) {
                console.log(data);
                for (var o in data)
                    if (data.hasOwnProperty(o)) {
                        for (var r = [], l = 0; l < data[o].length; l++) r.push([Date.parse(data[o][l].name), data[o][l].y]);
                        s2[o] = r
                    }
                if(typeof highcart.series[0] !== "undefined") highcart.series[0].remove(false);
                console.log(s2);
                while(highcart.series.length > 0)
                    highcart.series[0].remove(true);
                if(traffic == 1) {
                    highcart.addSeries({
                        index: 0,
                        zIndex:1,
                        color: "#59B1F1",
                        name: "Traffic from Search Engines",
                        data: s2.Search,
                    }, false);
                }
                else if (traffic == 2)
                    highcart.addSeries({
                        index: 0,
                        zIndex:1,
                        name: "Traffic from Referral Websites",
                        data: s2.Referral,
                        color: "#59B1F1",
                    }, false);
                else
                    highcart.addSeries({
                        index: 0,
                        zIndex:1,
                        name: "Traffic from Social Websites",
                        data: s2.Social,
                        color: "#59B1F1",
                    }, false);

                if(s2.newBacklinksBad.length)
                    highcart.addSeries({
                        index: 1,
                        zIndex:10,
                        name: "Non-followed links",
                        data: s2.newBacklinksBad,
                        type: "column",
                        color: "#afaeb0",
                        animation: {
                            duration: 2000,
                            easing: 'easeOutBounce'
                        },
                    }, false);
                if(s2.newBacklinksGood.length)
                    highcart.addSeries({
                        index: 2,
                        zIndex:11,
                        name: "Google followed links",
                        data: s2.newBacklinksGood,
                        type: "column",
                        color: "#97be4b",
                        animation: {
                            duration: 2000,
                            easing: 'easeOutBounce'
                        },
                    }, false);
                highcart.redraw();
            });
        }
        localStorage.setItem('interval', interval);
        localStorage.setItem('traffic', traffic);
    }
});
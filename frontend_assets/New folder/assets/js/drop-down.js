//FUNCTIONS
$.fn.hasAttr = function (attr) {
    var attribVal = this.attr(attr);
    return (attribVal !== undefined) && (attribVal !== false);
};
jQuery.fn.outerHTML = function (s) {
    return s ? this.before(s).remove() : jQuery("<p>").append(this.eq(0).clone()).html();
};
function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
function fadeIn(i, elements, duration, callback) {
    if (i >= elements.length) typeof callback == 'function' && callback(); else elements.eq(i).fadeIn(duration, function () {
        fadeIn(i + 1, elements, duration, callback);
    });
}
function GoFullscreen(element) {
    if (element.requestFullscreen) {
        element.requestFullscreen();
    } else if (element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullscreen) {
        element.webkitRequestFullscreen();
    } else if (element.msRequestFullscreen) {
        element.msRequestFullscreen();
    }
}
function ExitFullscreen() {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
    }
}
function toIntArray(value, delimiter) {
    var arr = [];
    var values = value.trim().split(delimiter);
    for (var i = 0; i < values.length; i++) arr.push(parseInt(values[i]));
    return arr;
}
/* Date Format 1.2.3, (c) 2007-2009 Steven Levithan <stevenlevithan.com>, MIT license */
var dateFormat = function () {
    var t = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g, e = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g, a = /[^-+\dA-Z]/g, m = function (t, e) {
        for (t = String(t), e = e || 2; t.length < e;)t = "0" + t;
        return t
    };
    return function (d, n, r) {
        var y = dateFormat;
        if (1 != arguments.length || "[object String]" != Object.prototype.toString.call(d) || /\d/.test(d) || (n = d, d = void 0), d = d ? new Date(d) : new Date, isNaN(d))throw SyntaxError("invalid date");
        n = String(y.masks[n] || n || y.masks["default"]), "UTC:" == n.slice(0, 4) && (n = n.slice(4), r = !0);
        var s = r ? "getUTC" : "get", i = d[s + "Date"](), o = d[s + "Day"](), u = d[s + "Month"](), M = d[s + "FullYear"](), l = d[s + "Hours"](), T = d[s + "Minutes"](), h = d[s + "Seconds"](), c = d[s + "Milliseconds"](), g = r ? 0 : d.getTimezoneOffset(), S = {
            d: i,
            dd: m(i),
            ddd: y.i18n.dayNames[o],
            dddd: y.i18n.dayNames[o + 7],
            m: u + 1,
            mm: m(u + 1),
            mmm: y.i18n.monthNames[u],
            mmmm: y.i18n.monthNames[u + 12],
            yy: String(M).slice(2),
            yyyy: M,
            h: l % 12 || 12,
            hh: m(l % 12 || 12),
            H: l,
            HH: m(l),
            M: T,
            MM: m(T),
            s: h,
            ss: m(h),
            l: m(c, 3),
            L: m(c > 99 ? Math.round(c / 10) : c),
            t: 12 > l ? "a" : "p",
            tt: 12 > l ? "am" : "pm",
            T: 12 > l ? "A" : "P",
            TT: 12 > l ? "AM" : "PM",
            Z: r ? "UTC" : (String(d).match(e) || [""]).pop().replace(a, ""),
            o: (g > 0 ? "-" : "+") + m(100 * Math.floor(Math.abs(g) / 60) + Math.abs(g) % 60, 4),
            S: ["th", "st", "nd", "rd"][i % 10 > 3 ? 0 : (i % 100 - i % 10 != 10) * i % 10]
        };
        return n.replace(t, function (t) {
            return t in S ? S[t] : t.slice(1, t.length - 1)
        })
    }
}();
dateFormat.masks = {
    "default": "ddd mmm dd yyyy HH:MM:ss",
    shortDate: "m/d/yy",
    mediumDate: "mmm d, yyyy",
    longDate: "mmmm d, yyyy",
    fullDate: "dddd, mmmm d, yyyy",
    shortTime: "h:MM TT",
    mediumTime: "h:MM:ss TT",
    longTime: "h:MM:ss TT Z",
    isoDate: "yyyy-mm-dd",
    isoTime: "HH:MM:ss",
    isoDateTime: "yyyy-mm-dd'T'HH:MM:ss",
    isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
}, dateFormat.i18n = {
    dayNames: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
}, Date.prototype.format = function (t, e) {
    return dateFormat(this, t, e)
};
var th = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];
var dg = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
var tn = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
var tw = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
function numToWord(s) {
    s = s.toString();
    s = s.replace(/[\, ]/g, '');
    if (s != parseFloat(s)) return 'not a number';
    var x = s.indexOf('.');
    if (x == -1) x = s.length;
    if (x > 15) return 'too big';
    var n = s.split('');
    var str = '';
    var sk = 0;
    for (var i = 0; i < x; i++) {
        if ((x - i) % 3 == 2) {
            if (n[i] == '1') {
                str += tn[Number(n[i + 1])] + ' ';
                i++;
                sk = 1;
            } else if (n[i] != 0) {
                str += tw[n[i] - 2] + ' ';
                sk = 1;
            }
        } else if (n[i] != 0) {
            str += dg[n[i]] + ' ';
            if ((x - i) % 3 == 0) str += 'hundred ';
            sk = 1;
        }
        if ((x - i) % 3 == 1) {
            if (sk) str += th[(x - i - 1) / 3] + ' ';
            sk = 0;
        }
    }
    if (x != s.length) {
        var y = s.length;
        str += 'point ';
        for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
    }
    return str.replace(/\s+/g, ' ');
}
//END FUNCTIONS

//[data-style] attributes
var _stylesNames = ['w', 'mw', 'h', 'mh', 'fs', 'fw', 't', 'b', 'r', 'l', 'm', 'mt', 'mr', 'mb', 'ml', 'p', 'pt', 'pr', 'pb', 'pl', 'bg', 'bgc', 'cl', 'brd', 'br', 'brt', 'brr', 'brb', 'brl', 'brc', 'brct', 'brcr', 'brcb', 'brcl', 'bs', 'fl', 'txta', 'd'];
var _stylesEq = ['width', 'max-width', 'height', 'max-height', 'font-size', 'font-weight', 'top', 'bottom', 'right', 'left', 'margin', 'margin-top', 'margin-right', 'margin-bottom', 'margin-left', 'padding', 'padding-top', 'padding-right', 'padding-bottom', 'padding-left', 'background', 'background-color', 'color', 'border-radius', 'border', 'border-top', 'border-right', 'border-bottom', 'border-left', 'border-color', 'border-top-color', 'border-right-color', 'border-bottom-color', 'border-left-color', 'box-shadow', 'float', 'text-align', 'display'];

var isRTL = false;
var sidebarOverlay;
var sidebarOpened;
var wasSidebarOverlay;
var wasSidebarClosed;
var animationSpeed = 100;


function initApp() {
    $(function () {

        //Load default values or from HTML
        isRTL = $("html").attr("dir") == "rtl";

        if (isRTL) {
            //NOTE: Leave '../' if you will place RTL files in a sub folder
            if (!$("link[href='../css/bootstrap-rtl.min.css']").length)
                $('head').append('<link rel="stylesheet" href="../css/bootstrap-rtl.min.css" type="text/css" />');
            if (!$("link[href='../css/framework-rtl.css']").length)
                $('head').append('<link rel="stylesheet" href="../css/framework-rtl.css" type="text/css" />');
        }

        sidebarOverlay = $("body").hasClass("sidebar-overlay") ? true : false;
        sidebarOpened = $("body").hasClass("sidebar-closed") ? false : true;
        wasSidebarOverlay = sidebarOverlay;
        wasSidebarClosed = $("body").hasClass("sidebar-closed") ? true : false;


        //Append Second Navbar that is used in tablets or smartphones
        if ($(".second-navbar").length == 0)
            $("body").append('<div class="second-navbar"><div class="navbar-content"></div></div>');

        //Fix content height if a navbar exists
        if ($(".navbar").length > 0) {
            $(".content-container").css("padding-top", "50px");
        }

        $("#content-main").addClass($("body").hasClass("sidebar-overlay") ? "content-overlayed" : "");
        $(".sidebar").addClass($("body").hasClass("sidebar-overlay") ? "sidebar-overlay" : "");
        $(".sidebar").prepend($("body").hasClass("sidebar-rounded") ? '<div class="ir"></div>' : "");

        //Load slimscroll plugin which adds a nice scrollbar to long contents
        //instead of default scrollbar
        if ($(window).width() <= 700) {
            $(".sidebar .slimScrollDiv").css("height", "100%");
            $(".sidebar .slimScrollDiv .sidebar-content").css("height", "calc(100% - 11px)");
        }

        /*
         * Tooltips
         */
        if ($('[data-toggle="tooltip"]')[0]) {
            $('[data-toggle="tooltip"]').tooltip();
        }

        /*
         * Popover
         */
        if ($('[data-toggle="popover"]')[0]) {
            $('[data-toggle="popover"]').popover();
        }

        else {
            try {

                $(".sidebar-content").slimScroll({
                    height: '100%',
                    color: 'rgba(255,255,255,0.5)',
                    distance: '3px',
                    start: $(".sidebar-content > ul > li.selected")[0]
                });

                $(".sidebar .slimScrollDiv").css("height", "calc(100% - 55px)");

                $(".messages ul ul").slimScroll({
                    height: '100%',
                    color: 'rgba(0,0,0,0.5)',
                    distance: '3px'
                });
                if ($(".messages ul .showall").length > 0)
                    $(".messages .slimScrollDiv").css("margin", "0 -10px 0 -10px");
                else $(".messages .slimScrollDiv").css("margin", "0 -10px -10px -10px");

                $(".notifications ul ul").slimScroll({
                    height: '100%',
                    color: 'rgba(0,0,0,0.5)',
                    distance: '3px'
                });
                $(".notifications .slimScrollDiv").css("margin", "0 -10px -10px -10px");

            } catch (err) {
            }
        }

        //Update sidebar and content according to whether the sidebar is closed or not
        if ($("body").hasClass("sidebar-closed")) {
            $(".sidebar-title").hide();
            $(".sidebar").width("55px");
            $("#content-main").css("width", "100%").css("padding-" + (isRTL ? "right" : "left"), (parseFloat($(".sidebar").width()) + 15) + "px");

            $(".sidebar-content li a").each(function () {
                $(this).addClass("closed");
            });
        }
        else $(".sidebar").addClass("sidebar-opened");

        //Check if sidebar was previously closed
        if (typeof(Storage) !== "undefined") {
            var isOpened = localStorage.getItem("sidebarOpened");
            if (isOpened == "false") {
                $("body").addClass("sidebar-closed");

                $(".sidebar-title").hide();
                $(".sidebar").css("width", "55px");
                $(".sidebar").removeClass("sidebar-opened");
                if (!sidebarOverlay) {
                    $("#content-main").css("padding-" + (isRTL ? "right" : "left"), "70px");
                }
                $(".sidebar-content li a").each(function () {
                    $(this).addClass("closed");
                });
                $(".sidebar-content > ul > li > ul").hide();
                if ($(window).width() <= 700) {
                    $(".sidebar-content li a span").css("opacity", "0");
                    $(".content-container .black").hide();
                }

                sidebarOpened = false;
            }
        }

        //Update content if sidebar overlay is activated
        if (!$("body").hasClass("sidebar-overlay"))
            $("#content-main").css("width", "100%").css("padding-" + (isRTL ? "right" : "left"), (parseFloat($(".sidebar").width()) + 15) + "px");

        $(".content-container").append('<div class="black"></div>');

        $("*").each(function () {
            // Update disabled page elements with class 'disabled'
            if ($(this).hasAttr('disabled')) {
                $(this).addClass('disabled');
                if ($(this).attr("type") == "checkbox" || $(this).attr("type") == "radio") {
                    $("label[for='" + $(this).prop("id") + "']").addClass("disabled");
                    $("label[for='" + $(this).prop("id") + "'] span").addClass("disabled");
                }
            }

            //Fast element styling using [data-style]
            if ($(this).is('[data-style]')) {
                var data = $(this).data('style');
                var styles = data.split(';');

                for (var j = 0; j < styles.length; j++) {
                    if (_stylesNames.indexOf(styles[j].trim().split(':')[0]) > -1) {
                        var style = _stylesEq[_stylesNames.indexOf(styles[j].trim().split(':')[0])];
                        $(this).css(style, styles[j].split(':')[1] + ((isNumeric(styles[j].split(':')[1])) ? "px" : ""));
                    }
                }
                $(this).removeAttr('data-style');
            }
        });

        //Update {{NUMBER}} with equivalent word
        //Update the selector according to your needs
        $("p,span,option,a,button,label,.list-item").each(function () {
            if ($(this).html().indexOf('{{') > -1 && $(this).html().indexOf('}}') > -1) {
                try {
                    var _mathRegex = new RegExp(/\{\{([0-9\+*\/-]+)\}\}/);
                    var _math = _mathRegex.exec($(this).html());
                    for (var i = 0; i < _math.length; i++) {
                        if (_math[i].indexOf("{{") < 0)
                            $(this).html($(this).html().replace("{{" + _math[i] + "}}", numToWord(eval(_math[i]))));
                    }
                } catch (err) {
                }

            }
        });

        if ($(".page-header.fixed").length > 0)
            $("#content-main > .content > .content").css("margin-top", (parseInt($(".page-header.fixed").height()) + 20) + "px").css("position", "relative").css("z-index", "1");

        $("select").change(function () {
            $(this).blur();
        });

        //Open selected sidebar menu
        if (sidebarOpened)
            $(".sidebar li.selected").each(function () {
                $(this).find("ul").show().css("height", "auto").css("margin-left", "0").attr('style', function (i, s) {
                    return (s || '') + 'display: block !important;'
                });
            });

        //Sidebar hover open and close
        $(".sidebar").mouseenter(function () {
            if ($("body").hasClass("sidebar-hover")) {
                if ($(window).width() <= 700)
                    $(".sidebar").css("width", "240px");
                else {
                    $(".sidebar").animate({width: "240px"}, animationSpeed / 2, function () {
                        $(".sidebar").removeAttr("style");
                    });
                }

                $(".sidebar").addClass("sidebar-opened");

                if (!sidebarOverlay) {
                    if ($(window).width() <= 700)
                        $("#content-main").css("padding-" + (isRTL ? "right" : "left"), "255px");
                    else $("#content-main").animate({paddingLeft: "255px"}, (animationSpeed / 2) - 100);
                }

                $(".sidebar-content li a").each(function () {
                    $(this).removeClass("closed");
                });

                if ($(window).width() <= 700)
                    $(".sidebar-content > ul > li > ul.opened").show();
                else $(".sidebar-content > ul > li > ul.opened").fadeIn(25);


                $(".sidebar-content li a span").css("opacity", "1");
                if ($(window).width() <= 700)
                    $(".content-container .black").show();

                if ($(window).width() <= 700)
                    $(".sidebar-title").show();
                else $(".sidebar-title").fadeIn(animationSpeed / 2);
                sidebarOpened = true;
            }
        }).mouseleave(function () {
            if ($("body").hasClass("sidebar-hover")) {
                if ($(window).width() <= 700)
                    $(".sidebar-title").hide();
                else $(".sidebar-title").fadeOut(animationSpeed / 2);

                if ($(window).width() <= 700)
                    $(".sidebar").css("width", "55px");
                else $(".sidebar").animate({width: "55px"}, animationSpeed / 2);
                $(".sidebar").removeClass("sidebar-opened");

                if (!sidebarOverlay) {
                    if ($(window).width() <= 700)
                        $("#content-main").css("padding-" + (isRTL ? "right" : "left"), "70px");
                    else $("#content-main").animate({paddingLeft: "70px"}, (animationSpeed / 2) - 100);
                }

                $(".sidebar-content li a").each(function () {
                    $(this).addClass("closed");
                });

                if ($(window).width() <= 700)
                    $(".sidebar-content > ul > li > ul").hide();
                else $(".sidebar-content > ul > li > ul").fadeOut(25);

                $(".sidebar-content li a span").css("opacity", "0");
                if ($(window).width() <= 700)
                    $(".content-container .black").hide();

                sidebarOpened = false;
            }
        });

        //Sidebar toggle button handler
        $(".sidebar-toggle").click(function () {
            if (sidebarOpened) {
                if ($(window).width() <= 700)
                    $(".sidebar-title").hide();
                else $(".sidebar-title").fadeOut(animationSpeed);

                if ($(window).width() <= 700) {
                    $(".sidebar").css("width", "0");
                    $("html").css("overflow", "auto");
                }
                else $(".sidebar").animate({width: "55px"}, animationSpeed);
                $(".sidebar").removeClass("sidebar-opened");

                $(".page-header.fixed").css("width", "calc(100% - 55px)");

                if ($(window).width() <= 700)
                    $("#content-main").css("padding-" + (isRTL ? "right" : "left"), "15px");
                else {
                    if (!sidebarOverlay) {
                        if (isRTL)
                            $("#content-main").animate({paddingRight: "70px"}, animationSpeed - 100);
                        else $("#content-main").animate({paddingLeft: "70px"}, animationSpeed - 100);
                    }
                }

                $(".sidebar-content li a").each(function () {
                    $(this).addClass("closed");
                });

                if ($(window).width() <= 700)
                    $(".sidebar-content > ul > li > ul").hide();
                else $(".sidebar-content > ul > li > ul").fadeOut(50);

                $(".sidebar-content li a span").css("opacity", "0");
                if ($(window).width() <= 700)
                    $(".content-container .black").hide();

                sidebarOpened = false;
            }
            else {
                if ($(window).width() <= 700) {
                    $(".sidebar").css("width", "240px");
                    $("html").css("overflow", "hidden");
                }
                else {
                    $(".sidebar").animate({width: "240px"}, animationSpeed, function () {
                        $(".sidebar").removeAttr("style");
                    });
                    $(".page-header.fixed").css("width", "calc(100% - 240px)");
                }

                $(".sidebar").addClass("sidebar-opened");

                if ($(window).width() <= 700)
                    $("#content-main").css("padding-" + (isRTL ? "right" : "left"), "15px");
                else {
                    if (!sidebarOverlay) {
                        if (isRTL)
                            $("#content-main").animate({paddingRight: "255px"}, animationSpeed - 100);
                        else $("#content-main").animate({paddingLeft: "255px"}, animationSpeed - 100);
                    }
                }

                $(".sidebar-content li a").each(function () {
                    $(this).removeClass("closed");
                });

                if ($(window).width() <= 700)
                    $(".sidebar-content > ul > li > ul.opened").show();
                else $(".sidebar-content > ul > li > ul.opened").fadeIn(50);


                $(".sidebar-content li a span").css("opacity", "1");
                if ($(window).width() <= 700)
                    $(".content-container .black").show();

                if ($(window).width() <= 700)
                    $(".sidebar-title").show();
                else $(".sidebar-title").fadeIn(animationSpeed);

                sidebarOpened = true;
            }

            if (typeof(Storage) !== "undefined")
                localStorage.setItem("sidebarOpened", sidebarOpened);
        });

        //Update Page title with a background if 'data-bg' is set to the image value
        $(".page-header").each(function () {
            if ($(this).data("bg")) {
                var url = $(this).data("bg");

                $(this).css("background", "url(" + url + ")");
                $(this).css("-webkit-background-size", "cover");
                $(this).css("-moz-background-size", "cover");
                $(this).css("-o-background-size", "cover");
                $(this).css("background-size", "cover");
                $(this).css("padding-top", "35px");
            }
            else {
                $(this).removeAttr("style");
            }
        });

        //Append the sidebar info popup if it doesn't exist in the document
        if ($(".sidebar-item-info").length == 0)
            $(".content-container").append('<div class="sidebar-item-info"></div>');

        //Display info or menu when sidebar items are hovered and the sidebar is closed
        var currentMenuItem;
        $(".sidebar-content ul li a, .sidebar-content ul .header").mouseenter(function () {
            if (!$("body").hasClass("sidebar-hover") && !sidebarOpened) {
                if (!sidebarOpened) {
                    $(".sidebar-item-info").html("<span>" + $(this).find("span").first().text() + "</span>");

                    $(".sidebar-item-info").css("bottom", "");

                    if ($(this).parent().find("> ul").length > 0) {
                        $(this).parent().find("> ul").clone().appendTo(".sidebar-item-info");
                        $(".sidebar-item-info > ul").css("height", "auto").css("margin-left", "0").show();
                        $(".sidebar-item-info ul li ul .selected").parent().show().css("height", "auto").attr('style', function (i, s) {
                            return (s || '') + 'display: block !important;'
                        });
                    }

                    var top = $(this).hasClass("header") ? $(this).offset().top : $(this).offset().top;
                    $(".sidebar-item-info").css("bottom", "");
                    $(".sidebar-item-info").css("top", top + "px");

                    if ($(this).hasClass("header")) {
                        $(".sidebar-item-info > span").css("padding", "10px 17px 8px 10px");
                    }
                    else {
                        $(".sidebar-item-info > span").css("padding", "12px 17px 11px 17px");
                    }

                    $('.sidebar-item-info').stop(true, true).fadeIn({
                        duration: 100,
                        queue: false
                    }).animate({left: "55px"}, 100);

                    $(".sidebar-content ul li").each(function () {
                        if (!$(this).hasClass("opened")) $(this).removeClass("active");
                    });

                    currentMenuItem = $(this).parent();
                    if (!$(this).hasClass("header"))
                        currentMenuItem.addClass("active");
                }
            }
        });
        $(".sidebar-item-info").mouseleave(function () {
            if (!$("body").hasClass("sidebar-hover") && !sidebarOpened) {
                $('.sidebar-item-info').stop(true, true).fadeOut({
                    duration: 100,
                    queue: false
                }).animate({left: "0"}, 100).css("bottom", "");//.fadeIn(50);
                if (!currentMenuItem.hasClass("opened"))
                    currentMenuItem.removeClass("active");
            }
        });
        $(".sidebar-top").mouseenter(function () {
            if (!$("body").hasClass("sidebar-hover") && !sidebarOpened) {
                $('.sidebar-item-info').stop(true, true).fadeOut({
                    duration: 100,
                    queue: false
                }).animate({left: "0"}, 100).css("bottom", "");//.fadeIn(50);
                if (!currentMenuItem.hasClass("opened"))
                    currentMenuItem.removeClass("active");
            }
        });

        $(".sidebar-content").on("click", "ul li a", function () {
            if (sidebarOpened) {
                if ($(this).parent().find("> ul").length > 0) {
                    if ($(this).parent().find("> ul").css("display") == "none") {

                        if ($(this).parent().parent().parent().is("div") && $(this).parents(".sidebar-item-info").length == 0) {
                            $(".sidebar-content ul li a").removeClass("active");
                            $(".sidebar-content ul li ul").removeClass("opened").css("height", "0").hide();
                        }

                        if ($(".sidebar").hasClass("no-animation")) {
                            $(this).parent().find("> ul").show().css("height", "auto").attr('style', function (i, s) {
                                return (s || '') + 'display: block !important;'
                            });
                            $(this).parent().find("ul").show();
                        }
                        else {
                            $(this).parent().find("> ul").stop(true, true).fadeIn({
                                duration: 100,
                                queue: false
                            }).css("height", "auto").animate({marginLeft: "0%"}, 100).attr('style', function (i, s) {
                                return (s || '') + 'display: block !important;'
                            });
                        }

                        $(this).addClass("active");
                        $(this).parent().find("> ul").addClass("opened");

                        //$(".sidebar-content").slimScroll({ scrollTo: parseInt($(".sidebar-content a.active:eq(0)").parent().offset().top) + 'px', animate: true });
                    }
                    else {
                        if ($(".sidebar").hasClass("no-animation")) {
                            $(this).parent().find("> ul").hide().animate({height: "0"}, 0, function () {
                                $(this).parent().find("> ul").css("margin-left", "-50%");
                            });
                            $(this).removeClass("active");
                            $(this).parent().find("> ul").removeClass("opened");
                        }
                        else {
                            $(this).parent().find("> ul").stop(true, true).fadeOut({
                                duration: 100,
                                queue: false
                            }).animate({height: "0"}, 100, function () {
                                $(this).parent().find("> ul").css("margin-left", "-50%");
                            });
                            $(this).removeClass("active");
                            $(this).parent().find("> ul").removeClass("opened");
                        }
                    }
                }
            }
            if ($(this).attr("href") == "#") return false;
        });

        $(".sidebar-item-info").on("click", "ul li a", function () {
            if ($(this).parent().find("> ul").length > 0) {
                if ($(this).parent().find("> ul").css("display") == "none") {

                    if ($(this).parent().parent().parent().is("div") && $(this).parents(".sidebar-item-info").length == 0) {
                        $(".sidebar-content ul li a").removeClass("active");
                        $(".sidebar-content ul li ul").removeClass("opened").css("height", "0").hide();
                    }

                    if ($(".sidebar").hasClass("no-animation")) {
                        $(this).parent().find("> ul").show().css("height", "auto").attr('style', function (i, s) {
                            return (s || '') + 'display: block !important;'
                        });
                        $(this).parent().find("ul").show();
                    }
                    else {
                        $(this).parent().find("> ul").stop(true, true).fadeIn({
                            duration: 100,
                            queue: false
                        }).css("height", "auto").animate({marginLeft: "0%"}, 100).attr('style', function (i, s) {
                            return (s || '') + 'display: block !important;'
                        });
                    }

                    $(this).addClass("active");
                    $(this).parent().find("ul").addClass("opened");
                }
                else {
                    if ($(".sidebar").hasClass("no-animation")) {
                        $(this).parent().find("> ul").hide().animate({height: "0"}, 0, function () {
                            $(this).parent().find("> ul").css("margin-left", "-50%");
                        });
                        $(this).removeClass("active");
                        $(this).parent().find("> ul").removeClass("opened");
                    }
                    else {
                        $(this).parent().find("> ul").stop(true, true).fadeOut({
                            duration: 100,
                            queue: false
                        }).animate({height: "0"}, 100, function () {
                            $(this).parent().find("> ul").css("margin-left", "-50%");
                        });
                        $(this).removeClass("active");
                        $(this).parent().find("> ul").removeClass("opened");
                    }
                }
            }
            if ($(this).attr("href") == "#") return false;
        });

        $(".sidebar-content li").each(function () {
            if ($(this).find("ul").length == 0) {
                $(this).addClass("no-children");
            }
        });



        /*****ALERTS ****/
        $(".alert, .note").each(function () {
            if ($(this).data("close")) {
                var style = $(this).data("options-position") == "left" ? "left:10px" : "right:10px";
                var c = $(this).hasClass("alert") ? "alert" : "note";
                $(this).append('<span class="close-' + c + '" style="' + style + '">&times;</span>');
            }
        });

        $(".alert .close-alert, .note .close-note").click(function () {
            $(this).parent().hide(150, function () {
                $(this).remove();
            });
        });
        /*****ALERTS ****/

        $(".content-container .black").click(function () {
            if ($(window).width() <= 700) {
                $(".sidebar-title").hide();
                $(".sidebar").css("width", "0");
                $(".sidebar").removeClass("sidebar-opened");

                $("#content-main").css("padding-" + (isRTL ? "right" : "left"), "15px");

                $(".sidebar-content li a").each(function () {
                    $(this).addClass("closed");
                });

                if ($(window).width() <= 700)
                    $(".sidebar-content > ul > li > ul").hide();
                else $(".sidebar-content > ul > li > ul").fadeOut(50);

                $(".sidebar-content li a span").css("opacity", "0");
                $(".content-container .black").hide();

                $("html").css("overflow", "auto");

                sidebarOpened = false;
            }

            var h = $(".search-content").innerHeight();
            $(".search-content").stop(true, true).fadeOut({
                duration: 100,
                queue: false
            }).animate({top: (-h) + "px"}, 100);
            $(".black").fadeOut(100, function () {
                $(this).css("z-index", "103");
            });
        });

        $(".navbar-options ul li").each(function () {
            $(this).find("> ul").attr("tabindex", "1000");
            if ($(this).find("ul").length == 0 || $(this).hasClass('messages') || $(this).hasClass('notifications')) {
                $(this).addClass("no-children");
            }
            else {
                $(this).find("> a").css("padding-" + (isRTL ? "left" : "right"), "35px");
            }

            if ($(window).width() <= 700) {
                if ($(this).hasClass("hover")) $(this).removeClass("hover");
            }
        });

        if ($(".navbar-options ul li").length == 0)
            $(".second-navbar-toggle").css("display", "none");

        if ($("#navbar-popup").length == 0) $("body").append('<div id="navbar-popup" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div id="navbar-popup-body" class="modal-body"></div></div></div></div>');

        var lastElement = null;
        $(".navbar-options ul li").click(function () {
            lastElement = $(this);
            if ($(window).width() <= 700) {
                if ($(this).find("> ul").length > 0) {
                    if ($("#navbar-popup #navbar-popup-body").find("> ul").length == 0)
                        $("#navbar-popup #navbar-popup-body").append($(this).find("> ul"));
                    $("#navbar-popup").modal("show");
                }
            }
            else {
                if ($("#navbar-popup #navbar-popup-body").find("> ul").length > 0)
                    $(this).append($("#navbar-popup #navbar-popup-body").find("> ul"));

                if ($(this).find("> ul").length > 0) {
                    if ($(this).find("> ul").css("display") == "none") {
                        $(this).parents(".navbar-options").find("> ul > li > ul").hide(80);
                        $(this).parents(".navbar-options").find("> ul > li").removeClass("selected");
                        $(this).find("> ul").show(80);
                        $(this).find("> ul").focus();
                        $(this).addClass("selected");
                    }
                    else {
                        $(this).parents(".navbar-options").find("> ul > li > ul").hide(80);
                        $(this).parents(".navbar-options").find("> ul > li > ul").parent().removeClass("selected");
                    }
                }
            }
        });

        $('#navbar-popup').on('hidden.bs.modal', function () {
            lastElement.append($("#navbar-popup #navbar-popup-body").find("> ul"));
            $("#navbar-popup #navbar-popup-body").html("");

            if ($(window).width() > 700) {
                $(".messages ul ul").slimScroll({
                    height: '100%',
                    color: 'rgba(0,0,0,0.5)',
                    distance: '3px'
                });
                if ($(".messages ul .showall").length > 0)
                    $(".messages .slimScrollDiv").css("margin", "0 -10px 0 -10px");
                else $(".messages .slimScrollDiv").css("margin", "0 -10px -10px -10px");

                $(".notifications ul ul").slimScroll({
                    height: '100%',
                    color: 'rgba(0,0,0,0.5)',
                    distance: '3px'
                });
                $(".notifications .slimScrollDiv").css("margin", "0 -10px -10px -10px");
            }
        });

        $(".navbar-options .hover").click(function () {
            return false;
        });
        $(".navbar-options .hover").mouseenter(function () {
            $(this).parents(".navbar-options").find("> ul > li > ul").hide(80);
            $(this).parents(".navbar-options").find("> ul > li").removeClass("selected");
            $(this).find("> ul").show(80);
            $(this).addClass("selected");
        });
        $(".navbar-options .hover > ul").mouseleave(function () {
            $(this).hide(80);
            $(this).parent().removeClass("selected");
        });

        $(".second-navbar-toggle").click(function () {
            if ($(".second-navbar").css("display") == "block") {
                $(".second-navbar").hide();
                $(".content-container").css("padding-top", "50px");
                $(".sidebar").css("top", "50px").css("height", "calc(100% - 50px)");
            }
            else {
                $(".second-navbar").show();
                $(".content-container").css("padding-top", "100px");
                $(".sidebar").css("top", "100px").css("height", "calc(100% - 100px)");
            }
            Resizing();
            $(window).resize();
        });

        $("input.control[type='checkbox'][data-icon], input.control[type='radio'][data-icon]").each(function () {
            $("label[for='" + $(this).prop("id") + "'] span").attr("data-icon", $(this).data("icon"));
        });

        $("div.panel").each(function () {
            var controls = "";

            if ($(this).data("close") == true)
                controls += "<i class='close-panel'>&times;</i>";
            if ($(this).data("expand") == true)
                controls += "<i class='expand-panel fa fa-arrows-alt'></i>";
            if ($(this).data("toggle") == true)
                controls += "<i class='toggle-panel fa fa-chevron-down'></i>";

            if ($(this).find(".panel-title").length == 0 && $(this).data("title"))
                $(this).prepend('<div class="panel-title"></div>');

            if ($(this).find(".panel-title .panel-controls").length == 0 && $(this).data("title"))
                $(this).find(".panel-title").append('<div class="panel-controls"></div>');

            if ($(this).hasAttr("data-title"))
                $(this).find(".panel-title").prepend($(this).data("title"));
            $(this).find(".panel-title .panel-controls").append(controls);
        });

        $(".expand-panel").click(function () {
            if ($(this).hasClass("fa-arrows-alt")) {
                $(this).parents('.panel').addClass('expanded');
                $(this).addClass('fa-arrow-down');
                $(this).removeClass('fa-arrows-alt');
                $(".content-container").css("z-index", "999999");
                $(".sidebar").hide();
                $(".navbar").hide();
            }
            else {
                $(this).parents('.panel').removeClass('expanded');
                $(this).addClass('fa-arrows-alt');
                $(this).removeClass('fa-arrow-down');
                $(".content-container").css("z-index", "");
                $(".sidebar").show();
                $(".navbar").show();
            }
        });

        $(".toggle-panel").click(function () {
            if ($(this).hasClass("fa-chevron-down")) {
                $(this).parents('.panel').css("overflow", "hidden");
                $(this).parents('.panel').animate({height: "53px"}, 150);
                $(this).addClass('fa-chevron-up');
                $(this).removeClass('fa-chevron-down');
            }
            else {
                $(this).parents('.panel').animate({height: $(this).parents('.panel').get(0).scrollHeight + "px"}, 150, function () {
                    $(this).css("overflow", "visible");
                });
                $(this).addClass('fa-chevron-down');
                $(this).removeClass('fa-chevron-up');
            }
        });

        $("#show-search").click(function () {
            $(".search-content").stop(true, true).fadeIn({duration: 100, queue: false}).animate({top: "0px"}, 100);
            $(".black").css("z-index", "107").fadeIn(100);
            $(".searh-input").focus();
        });

        $(".search-content span").click(function () {
            var h = $(".search-content").innerHeight();
            $(".search-content").stop(true, true).fadeOut({
                duration: 100,
                queue: false
            }).animate({top: (-h) + "px"}, 100);
            $(".black").fadeOut(100, function () {
                $(this).css("z-index", "103");
            });
        });

        $("#btn-fullscreen").click(function () {
            if ((window.fullScreen) || (window.innerWidth == screen.width && window.innerHeight == screen.height))
                ExitFullscreen();
            else GoFullscreen(document.documentElement);
            return false;
        });

        $(".modal").each(function (index) {
            $(this).on('show.bs.modal', function (e) {
                var open = $(this).attr('data-anim');

                try {
                    if (open == 'shake') {
                        $('.modal-dialog').velocity('callout.' + open);
                    }
                    else if (open == 'pulse') {
                        $('.modal-dialog').velocity('callout.' + open);
                    }
                    else if (open == 'tada') {
                        $('.modal-dialog').velocity('callout.' + open);
                    }
                    else if (open == 'flash') {
                        $('.modal-dialog').velocity('callout.' + open);
                    }
                    else if (open == 'bounce') {
                        $('.modal-dialog').velocity('callout.' + open);
                    }
                    else if (open == 'swing') {
                        $('.modal-dialog').velocity('callout.' + open);
                    }
                    else {
                        $('.modal-dialog').velocity('transition.' + open);
                    }
                } catch (err) {
                }
            });
        });

        try {
            //$(".datatable").DataTable();
        } catch (err) {
        }

        $(".progress-circle[data-valuenow]").each(function () {
            var percentage = (parseInt($(this).data("valuenow")) > 100 || parseInt($(this).data("valuenow")) < 0) ? 0 : parseInt($(this).data("valuenow"));
            $(this).addClass("p" + percentage);
        });

        $(".datepicker").each(function () {
            var locale = $(this).data("locale") ? $(this).data("locale") : "en";
            var format = $(this).data("format") ? $(this).data("format") : false;
            var viewmode = $(this).data("viewmode") ? $(this).data("viewmode") : "days";
            var disableddays = $(this).data("disableddays") ? toIntArray($(this).data("disableddays"), ",") : [];
            var inline = $(this).hasClass("inline");
            var sideBySide = $(this).hasClass("sideBySide");

            $(this).datetimepicker({
                locale: locale,
                format: format,
                viewMode: viewmode,
                daysOfWeekDisabled: disableddays,
                inline: inline,
                sideBySide: sideBySide
            });
        });

        $(".colorpicker").each(function () {
            var inline = $(this).hasClass("inline");

            $(this).colorpicker({
                inline: inline
            });
        });

        $(".frDateToday").each(function () {
            var now = new Date();
            if ($(this).data("format") != "")
                now = now.format($(this).data("format"));
            $(this).text(now);
        });

        if ($(window).width() <= 700)
            Resizing();
    });

    $(window).bind("load", function () {
        //Hide loading after page done loading
        $(".loader-back").hide();
    });

    $(window).resize(function () {
        Resizing();
    });

    function Resizing() {
        var width = $(window).width();

        if (width <= 700) {
            $(".sidebar-title").fadeOut(animationSpeed);

            $(".sidebar").animate({width: "0"}, animationSpeed);
            $(".sidebar").removeClass("sidebar-opened");

            if (!sidebarOverlay) {
                if (isRTL)
                    $("#content-main").animate({paddingRight: "15px"}, animationSpeed - 100);
                else $("#content-main").animate({paddingLeft: "15px"}, animationSpeed - 100);
            }

            $(".sidebar-content li a").each(function () {
                $(this).addClass("closed");
            });

            $(".sidebar-content > ul > li > ul").fadeOut(50);

            $(".sidebar-content li a span").css("opacity", "0");
            $(".content-container .black").fadeOut(animationSpeed);

            $(".sidebar .slimScrollDiv").css("height", "100%");
            $(".sidebar .slimScrollDiv .sidebar-content").css("height", "calc(100% - 2px)");

            sidebarOpened = false;

            $(".second-navbar .navbar-content").append($(".navbar .navbar-options"));
            var w = 10;
            $('.second-navbar .navbar-options > *').each(function () {
                w += $(this).outerWidth();
            });
            $('.second-navbar .navbar-options').css("float", "none").css("width", w + "px");
            $('.second-navbar .navbar-options > ul, .second-navbar .navbar-options .navbar-search').css("float", "left");
        }
        else {
            sidebarOpened = $("body").hasClass("sidebar-closed") ? false : true;
            if (sidebarOpened == true) {
                $(".sidebar").animate({width: "240px"}, animationSpeed, function () {
                    if ($(window).width() > 700)
                        $(".sidebar").removeAttr("style");
                });

                $(".sidebar").addClass("sidebar-opened");

                if (!sidebarOverlay) {
                    if (isRTL)
                        $("#content-main").animate({paddingRight: "255px"}, animationSpeed - 100);
                    else $("#content-main").animate({paddingLeft: "255px"}, animationSpeed - 100);
                }

                $(".sidebar-content li a").each(function () {
                    $(this).removeClass("closed");
                });

                $(".sidebar-content > ul > li > ul.opened").fadeIn(50);


                $(".sidebar-content li a span").css("opacity", "1");
                $(".content-container .black").fadeOut(animationSpeed);

                $(".sidebar-title").fadeIn(animationSpeed);
                $(".sidebar .slimScrollDiv").css("height", "100%");
                $(".sidebar .slimScrollDiv .sidebar-content").css("height", "calc(100% - 55px)");

                $(".second-navbar").hide();
                $(".navbar").append($(".second-navbar .navbar-options"));
                $('.navbar .navbar-options').removeAttr("style");
                $('.navbar .navbar-options > ul, .navbar .navbar-options .navbar-search').css("float", "right");
                $(".content-container").css("padding-top", "50px");
                $(".sidebar").css("top", "50px").css("height", "calc(100% - 50px)");
            }
            else {
                $(".sidebar").animate({width: "55px"}, animationSpeed);

                if (!sidebarOverlay) {
                    if (isRTL)
                        $("#content-main").animate({paddingRight: "70px"}, animationSpeed - 100);
                    else $("#content-main").animate({paddingLeft: "70px"}, animationSpeed - 100);
                }
            }
        }
    }
}
initApp();
function disableControl(selector) {
    $(selector).prop("disabled", true);
    $(selector).addClass('disabled');
}
function enableControl(selector) {
    $(selector).prop("disabled", false);
    $(selector).removeClass('disabled');
}

function initAlerts() {
    /*****ALERTS ****/
    $(".alert, .note").each(function () {
        if ($(this).data("close")) {
            var style = $(this).data("options-position") == "left" ? "left:10px" : "right:10px";
            var c = $(this).hasClass("alert") ? "alert" : "note";
            $(this).append('<span class="close-' + c + '" style="' + style + '">&times;</span>');
        }
    });

    $(".alert .close-alert, .note .close-note").click(function () {
        $(this).parent().hide(150, function () {
            $(this).remove();
        });
    });
    /*****ALERTS ****/
}
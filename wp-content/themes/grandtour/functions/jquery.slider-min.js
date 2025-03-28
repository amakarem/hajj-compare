(function() {
    Function.prototype.inheritFrom = function(b, c) {
        var d = function() {};
        d.prototype = b.prototype;
        this.prototype = new d();
        this.prototype.constructor = this;
        this.prototype.baseConstructor = b;
        this.prototype.superClass = b.prototype;
        if (c) {
            for (var a in c) {
                this.prototype[a] = c[a]
            }
        }
    };
    Number.prototype.jSliderNice = function(l) {
        var o = /^(-)?(\d+)([\.,](\d+))?$/;
        var d = Number(this);
        var j = String(d);
        var k;
        var c = "";
        var b = " ";
        if ((k = j.match(o))) {
            var f = k[2];
            var m = (k[4]) ? Number("0." + k[4]) : 0;
            if (m) {
                var e = Math.pow(10, (l) ? l : 2);
                m = Math.round(m * e);
                sNewDecPart = String(m);
                c = sNewDecPart;
                if (sNewDecPart.length < l) {
                    var a = l - sNewDecPart.length;
                    for (var g = 0; g < a; g++) {
                        c = "0" + c
                    }
                }
                c = "," + c
            } else {
                if (l && l != 0) {
                    for (var g = 0; g < l; g++) {
                        c += "0"
                    }
                    c = "," + c
                }
            }
            var h;
            if (Number(f) < 1000) {
                h = f + c
            } else {
                var n = "";
                var g;
                for (g = 1; g * 3 < f.length; g++) {
                    n = b + f.substring(f.length - g * 3, f.length - (g - 1) * 3) + n
                }
                h = f.substr(0, 3 - g * 3 + f.length) + n + c
            }
            if (k[1]) {
                return "-" + h
            } else {
                return h
            }
        } else {
            return j
        }
    };
    this.jSliderIsArray = function(a) {
        if (typeof a == "undefined") {
            return false
        }
        if (a instanceof Array || (!(a instanceof Object) && (Object.prototype.toString.call((a)) == "[object Array]") || typeof a.length == "number" && typeof a.splice != "undefined" && typeof a.propertyIsEnumerable != "undefined" && !a.propertyIsEnumerable("splice"))) {
            return true
        }
        return false
    }
})();
(function() {
    var a = {};
    this.jSliderTmpl = function b(e, d) {
        var c = !(/\W/).test(e) ? a[e] = a[e] || b(e) : new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('" + e.replace(/[\r\t\n]/g, " ").split("<%").join("\t").replace(/((^|%>)[^\t]*)'/g, "$1\r").replace(/\t=(.*?)%>/g, "',$1,'").split("\t").join("');").split("%>").join("p.push('").split("\r").join("\\'") + "');}return p.join('');");
        return d ? c(d) : c
    }
})();
(function(a) {
    this.Draggable = function() {
        this._init.apply(this, arguments)
    };
    Draggable.prototype = {
        oninit: function() {},
        events: function() {},
        onmousedown: function() {
            this.ptr.css({
                position: "absolute"
            })
        },
        onmousemove: function(c, b, d) {
            this.ptr.css({
                left: b,
                top: d
            })
        },
        onmouseup: function() {},
        isDefault: {
            drag: false,
            clicked: false,
            toclick: true,
            mouseup: false
        },
        _init: function() {
            if (arguments.length > 0) {
                this.ptr = a(arguments[0]);
                this.outer = a(".draggable-outer");
                this.is = {};
                a.extend(this.is, this.isDefault);
                var b = this.ptr.offset();
                this.d = {
                    left: b.left,
                    top: b.top,
                    width: this.ptr.width(),
                    height: this.ptr.height()
                };
                this.oninit.apply(this, arguments);
                this._events()
            }
        },
        _getPageCoords: function(b) {
            if (b.targetTouches && b.targetTouches[0]) {
                return {
                    x: b.targetTouches[0].pageX,
                    y: b.targetTouches[0].pageY
                }
            } else {
                return {
                    x: b.pageX,
                    y: b.pageY
                }
            }
        },
        _bindEvent: function(e, c, d) {
            var b = this;
            if (this.supportTouches_) {
                e.get(0).addEventListener(this.events_[c], d, false)
            } else {
                e.bind(this.events_[c], d)
            }
        },
        _events: function() {
            var b = this;
            this.supportTouches_ = (a.browser.webkit && navigator.userAgent.indexOf("Mobile") != -1);
            this.events_ = {
                click: this.supportTouches_ ? "touchstart" : "click",
                down: this.supportTouches_ ? "touchstart" : "mousedown",
                move: this.supportTouches_ ? "touchmove" : "mousemove",
                up: this.supportTouches_ ? "touchend" : "mouseup"
            };
            this._bindEvent(a(document), "move", function(c) {
                if (b.is.drag) {
                    c.stopPropagation();
                    c.preventDefault();
                    b._mousemove(c)
                }
            });
            this._bindEvent(a(document), "down", function(c) {
                if (b.is.drag) {
                    c.stopPropagation();
                    c.preventDefault()
                }
            });
            this._bindEvent(a(document), "up", function(c) {
                b._mouseup(c)
            });
            this._bindEvent(this.ptr, "down", function(c) {
                b._mousedown(c);
                return false
            });
            this._bindEvent(this.ptr, "up", function(c) {
                b._mouseup(c)
            });
            this.ptr.find("a").click(function() {
                b.is.clicked = true;
                if (!b.is.toclick) {
                    b.is.toclick = true;
                    return false
                }
            }).mousedown(function(c) {
                b._mousedown(c);
                return false
            });
            this.events()
        },
        _mousedown: function(b) {
            this.is.drag = true;
            this.is.clicked = false;
            this.is.mouseup = false;
            var c = this.ptr.offset();
            var d = this._getPageCoords(b);
            this.cx = d.x - c.left;
            this.cy = d.y - c.top;
            a.extend(this.d, {
                left: c.left,
                top: c.top,
                width: this.ptr.width(),
                height: this.ptr.height()
            });
            if (this.outer && this.outer.get(0)) {
                this.outer.css({
                    height: Math.max(this.outer.height(), a(document.body).height()),
                    overflow: "hidden"
                })
            }
            this.onmousedown(b)
        },
        _mousemove: function(b) {
            this.is.toclick = false;
            var c = this._getPageCoords(b);
            this.onmousemove(b, c.x - this.cx, c.y - this.cy)
        },
        _mouseup: function(b) {
            var c = this;
            if (this.is.drag) {
                this.is.drag = false;
                if (this.outer && this.outer.get(0)) {
                    if (a.browser.mozilla) {
                        this.outer.css({
                            overflow: "hidden"
                        })
                    } else {
                        this.outer.css({
                            overflow: "visible"
                        })
                    }
                    if (a.browser.msie && a.browser.version == "6.0") {
                        this.outer.css({
                            height: "100%"
                        })
                    } else {
                        this.outer.css({
                            height: "auto"
                        })
                    }
                }
                this.onmouseup(b)
            }
        }
    }
})(jQuery);
(function(b) {
    b.slider = function(f, e) {
        var d = b(f);
        if (!d.data("jslider")) {
            d.data("jslider", new jSlider(f, e))
        }
        return d.data("jslider")
    };
    b.fn.slider = function(h, e) {
        var g, f = arguments;

        function d(j) {
            return j !== undefined
        }

        function i(j) {
            return j != null
        }
        this.each(function() {
            var k = b.slider(this, h);
            if (typeof h == "string") {
                switch (h) {
                    case "value":
                        if (d(f[1]) && d(f[2])) {
                            var j = k.getPointers();
                            if (i(j[0]) && i(f[1])) {
                                j[0].set(f[1]);
                                j[0].setIndexOver()
                            }
                            if (i(j[1]) && i(f[2])) {
                                j[1].set(f[2]);
                                j[1].setIndexOver()
                            }
                        } else {
                            if (d(f[1])) {
                                var j = k.getPointers();
                                if (i(j[0]) && i(f[1])) {
                                    j[0].set(f[1]);
                                    j[0].setIndexOver()
                                }
                            } else {
                                g = k.getValue()
                            }
                        }
                        break;
                    case "prc":
                        if (d(f[1]) && d(f[2])) {
                            var j = k.getPointers();
                            if (i(j[0]) && i(f[1])) {
                                j[0]._set(f[1]);
                                j[0].setIndexOver()
                            }
                            if (i(j[1]) && i(f[2])) {
                                j[1]._set(f[2]);
                                j[1].setIndexOver()
                            }
                        } else {
                            if (d(f[1])) {
                                var j = k.getPointers();
                                if (i(j[0]) && i(f[1])) {
                                    j[0]._set(f[1]);
                                    j[0].setIndexOver()
                                }
                            } else {
                                g = k.getPrcValue()
                            }
                        }
                        break;
                    case "calculatedValue":
                        var m = k.getValue().split(";");
                        g = "";
                        for (var l = 0; l < m.length; l++) {
                            g += (l > 0 ? ";" : "") + k.nice(m[l])
                        }
                        break;
                    case "skin":
                        k.setSkin(f[1]);
                        break
                }
            } else {
                if (!h && !e) {
                    if (!jSliderIsArray(g)) {
                        g = []
                    }
                    g.push(slider)
                }
            }
        });
        if (jSliderIsArray(g) && g.length == 1) {
            g = g[0]
        }
        return g || this
    };
    var c = {
        settings: {
            from: 1,
            to: 10,
            step: 1,
            smooth: true,
            limits: true,
            round: 0,
            value: "5;7",
            dimension: ""
        },
        className: "jslider",
        selector: ".jslider-",
        template: jSliderTmpl('<span class="<%=className%>"><table><tr><td><div class="<%=className%>-bg"><i class="l"><i></i></i><i class="r"><i></i></i><i class="v"><i></i></i></div><div class="<%=className%>-pointer"><i></i></div><div class="<%=className%>-pointer <%=className%>-pointer-to"><i></i></div><div class="<%=className%>-label"><span><%=settings.from%></span></div><div class="<%=className%>-label <%=className%>-label-to"><span><%=settings.to%></span><%=settings.dimension%></div><div class="<%=className%>-value"><span></span><%=settings.dimension%></div><div class="<%=className%>-value <%=className%>-value-to"><span></span><%=settings.dimension%></div><div class="<%=className%>-scale"><%=scale%></div></td></tr></table></span>')
    };
    this.jSlider = function() {
        return this.init.apply(this, arguments)
    };
    jSlider.prototype = {
        init: function(e, d) {
            this.settings = b.extend(true, {}, c.settings, d ? d : {});
            this.inputNode = b(e).hide();
            this.settings.interval = this.settings.to - this.settings.from;
            this.settings.value = this.inputNode.attr("value");
            if (this.settings.calculate && b.isFunction(this.settings.calculate)) {
                this.nice = this.settings.calculate
            }
            if (this.settings.onstatechange && b.isFunction(this.settings.onstatechange)) {
                this.onstatechange = this.settings.onstatechange
            }
            this.is = {
                init: false
            };
            this.o = {};
            this.create()
        },
        onstatechange: function() {},
        create: function() {
            var d = this;
            this.domNode = b(c.template({
                className: c.className,
                settings: {
                    from: this.nice(this.settings.from),
                    to: this.nice(this.settings.to),
                    dimension: this.settings.dimension
                },
                scale: this.generateScale()
            }));
            this.inputNode.after(this.domNode);
            this.drawScale();
            if (this.settings.skin && this.settings.skin.length > 0) {
                this.setSkin(this.settings.skin)
            }
            this.sizes = {
                domWidth: this.domNode.width(),
                domOffset: this.domNode.offset()
            };
            b.extend(this.o, {
                pointers: {},
                labels: {
                    0: {
                        o: this.domNode.find(c.selector + "value").not(c.selector + "value-to")
                    },
                    1: {
                        o: this.domNode.find(c.selector + "value").filter(c.selector + "value-to")
                    }
                },
                limits: {
                    0: this.domNode.find(c.selector + "label").not(c.selector + "label-to"),
                    1: this.domNode.find(c.selector + "label").filter(c.selector + "label-to")
                }
            });
            b.extend(this.o.labels[0], {
                value: this.o.labels[0].o.find("span")
            });
            b.extend(this.o.labels[1], {
                value: this.o.labels[1].o.find("span")
            });
            if (!d.settings.value.split(";")[1]) {
                this.settings.single = true;
                this.domNode.addDependClass("single")
            }
            if (!d.settings.limits) {
                this.domNode.addDependClass("limitless")
            }
            this.domNode.find(c.selector + "pointer").each(function(e) {
                var g = d.settings.value.split(";")[e];
                if (g) {
                    d.o.pointers[e] = new a(this, e, d);
                    var f = d.settings.value.split(";")[e - 1];
                    if (f && new Number(g) < new Number(f)) {
                        g = f
                    }
                    g = g < d.settings.from ? d.settings.from : g;
                    g = g > d.settings.to ? d.settings.to : g;
                    d.o.pointers[e].set(g, true)
                }
            });
            this.o.value = this.domNode.find(".v");
            this.is.init = true;
            b.each(this.o.pointers, function(e) {
                d.redraw(this)
            });
            (function(e) {
                b(window).resize(function() {
                    e.onresize()
                })
            })(this)
        },
        setSkin: function(d) {
            if (this.skin_) {
                this.domNode.removeDependClass(this.skin_, "_")
            }
            this.domNode.addDependClass(this.skin_ = d, "_")
        },
        setPointersIndex: function(d) {
            b.each(this.getPointers(), function(e) {
                this.index(e)
            })
        },
        getPointers: function() {
            return this.o.pointers
        },
        generateScale: function() {
            if (this.settings.scale && this.settings.scale.length > 0) {
                var f = "";
                var e = this.settings.scale;
                var g = Math.round((100 / (e.length - 1)) * 10) / 10;
                for (var d = 0; d < e.length; d++) {
                    f += '<span style="left: ' + d * g + '%">' + (e[d] != "|" ? "<ins>" + e[d] + "</ins>" : "") + "</span>"
                }
                return f
            } else {
                return ""
            }
            return ""
        },
        drawScale: function() {
            this.domNode.find(c.selector + "scale span ins").each(function() {
                b(this).css({
                    marginLeft: -b(this).outerWidth() / 2
                })
            })
        },
        onresize: function() {
            var d = this;
            this.sizes = {
                domWidth: this.domNode.width(),
                domOffset: this.domNode.offset()
            };
            b.each(this.o.pointers, function(e) {
                d.redraw(this)
            })
        },
        limits: function(d, g) {
            if (!this.settings.smooth) {
                var f = this.settings.step * 100 / (this.settings.interval);
                d = Math.round(d / f) * f
            }
            var e = this.o.pointers[1 - g.uid];
            if (e && g.uid && d < e.value.prc) {
                d = e.value.prc
            }
            if (e && !g.uid && d > e.value.prc) {
                d = e.value.prc
            }
            if (d < 0) {
                d = 0
            }
            if (d > 100) {
                d = 100
            }
            return Math.round(d * 10) / 10
        },
        redraw: function(d) {
            if (!this.is.init) {
                return false
            }
            this.setValue();
            if (this.o.pointers[0] && this.o.pointers[1]) {
                this.o.value.css({
                    left: this.o.pointers[0].value.prc + "%",
                    width: (this.o.pointers[1].value.prc - this.o.pointers[0].value.prc) + "%"
                })
            }
            this.o.labels[d.uid].value.html(this.nice(d.value.origin));
            this.redrawLabels(d)
        },
        redrawLabels: function(j) {
            function f(l, m, n) {
                m.margin = -m.label / 2;
                label_left = m.border + m.margin;
                if (label_left < 0) {
                    m.margin -= label_left
                }
                if (m.border + m.label / 2 > e.sizes.domWidth) {
                    m.margin = 0;
                    m.right = true
                } else {
                    m.right = false
                }
                l.o.css({
                    left: n + "%",
                    marginLeft: m.margin,
                    right: "auto"
                });
                if (m.right) {
                    l.o.css({
                        left: "auto",
                        right: 0
                    })
                }
                return m
            }
            var e = this;
            var g = this.o.labels[j.uid];
            var k = j.value.prc;
            var h = {
                label: g.o.outerWidth(),
                right: false,
                border: (k * this.sizes.domWidth) / 100
            };
            if (!this.settings.single) {
                var d = this.o.pointers[1 - j.uid];
                var i = this.o.labels[d.uid];
                switch (j.uid) {
                    case 0:
                        if (h.border + h.label / 2 > i.o.offset().left - this.sizes.domOffset.left) {
                            i.o.css({
                                visibility: "hidden"
                            });
                            i.value.html(this.nice(d.value.origin));
                            g.o.css({
                                visibility: "visible"
                            });
                            k = (d.value.prc - k) / 2 + k;
                            if (d.value.prc != j.value.prc) {
                                g.value.html(this.nice(j.value.origin) + "&nbsp;&ndash;&nbsp;" + this.nice(d.value.origin));
                                h.label = g.o.outerWidth();
                                h.border = (k * this.sizes.domWidth) / 100
                            }
                        } else {
                            i.o.css({
                                visibility: "visible"
                            })
                        }
                        break;
                    case 1:
                        if (h.border - h.label / 2 < i.o.offset().left - this.sizes.domOffset.left + i.o.outerWidth()) {
                            i.o.css({
                                visibility: "hidden"
                            });
                            i.value.html(this.nice(d.value.origin));
                            g.o.css({
                                visibility: "visible"
                            });
                            k = (k - d.value.prc) / 2 + d.value.prc;
                            if (d.value.prc != j.value.prc) {
                                g.value.html(this.nice(d.value.origin) + "&nbsp;&ndash;&nbsp;" + this.nice(j.value.origin));
                                h.label = g.o.outerWidth();
                                h.border = (k * this.sizes.domWidth) / 100
                            }
                        } else {
                            i.o.css({
                                visibility: "visible"
                            })
                        }
                        break
                }
            }
            h = f(g, h, k);
            if (i) {
                var h = {
                    label: i.o.outerWidth(),
                    right: false,
                    border: (d.value.prc * this.sizes.domWidth) / 100
                };
                h = f(i, h, d.value.prc)
            }
            this.redrawLimits()
        },
        redrawLimits: function() {
            if (this.settings.limits) {
                var f = [true, true];
                for (key in this.o.pointers) {
                    if (!this.settings.single || key == 0) {
                        var j = this.o.pointers[key];
                        var e = this.o.labels[j.uid];
                        var h = e.o.offset().left - this.sizes.domOffset.left;
                        var d = this.o.limits[0];
                        if (h < d.outerWidth()) {
                            f[0] = false
                        }
                        var d = this.o.limits[1];
                        if (h + e.o.outerWidth() > this.sizes.domWidth - d.outerWidth()) {
                            f[1] = false
                        }
                    }
                }
                for (var g = 0; g < f.length; g++) {
                    if (f[g]) {
                        this.o.limits[g].fadeIn("fast")
                    } else {
                        this.o.limits[g].fadeOut("fast")
                    }
                }
            }
        },
        setValue: function() {
            var d = this.getValue();
            this.inputNode.attr("value", d);
            this.onstatechange.call(this, d)
        },
        getValue: function() {
            if (!this.is.init) {
                return false
            }
            var e = this;
            var d = "";
            b.each(this.o.pointers, function(f) {
                if (this.value.prc != undefined && !isNaN(this.value.prc)) {
                    d += (f > 0 ? ";" : "") + e.prcToValue(this.value.prc)
                }
            });
            return d
        },
        getPrcValue: function() {
            if (!this.is.init) {
                return false
            }
            var e = this;
            var d = "";
            b.each(this.o.pointers, function(f) {
                if (this.value.prc != undefined && !isNaN(this.value.prc)) {
                    d += (f > 0 ? ";" : "") + this.value.prc
                }
            });
            return d
        },
        prcToValue: function(l) {
            if (this.settings.heterogeneity && this.settings.heterogeneity.length > 0) {
                var g = this.settings.heterogeneity;
                var f = 0;
                var k = this.settings.from;
                for (var e = 0; e <= g.length; e++) {
                    if (g[e]) {
                        var d = g[e].split("/")
                    } else {
                        var d = [100, this.settings.to]
                    }
                    d[0] = new Number(d[0]);
                    d[1] = new Number(d[1]);
                    if (l >= f && l <= d[0]) {
                        var j = k + ((l - f) * (d[1] - k)) / (d[0] - f)
                    }
                    f = d[0];
                    k = d[1]
                }
            } else {
                var j = this.settings.from + (l * this.settings.interval) / 100
            }
            return this.round(j)
        },
        valueToPrc: function(j, l) {
            if (this.settings.heterogeneity && this.settings.heterogeneity.length > 0) {
                var g = this.settings.heterogeneity;
                var f = 0;
                var k = this.settings.from;
                for (var e = 0; e <= g.length; e++) {
                    if (g[e]) {
                        var d = g[e].split("/")
                    } else {
                        var d = [100, this.settings.to]
                    }
                    d[0] = new Number(d[0]);
                    d[1] = new Number(d[1]);
                    if (j >= k && j <= d[1]) {
                        var m = l.limits(f + (j - k) * (d[0] - f) / (d[1] - k))
                    }
                    f = d[0];
                    k = d[1]
                }
            } else {
                var m = l.limits((j - this.settings.from) * 100 / this.settings.interval)
            }
            return m
        },
        round: function(d) {
            d = Math.round(d / this.settings.step) * this.settings.step;
            if (this.settings.round) {
                d = Math.round(d * Math.pow(10, this.settings.round)) / Math.pow(10, this.settings.round)
            } else {
                d = Math.round(d)
            }
            return d
        },
        nice: function(d) {
            d = d.toString().replace(/,/gi, ".");
            d = d.toString().replace(/ /gi, "");
            if (Number.prototype.jSliderNice) {
                return (new Number(d)).jSliderNice(this.settings.round).replace(/-/gi, "&minus;")
            } else {
                return new Number(d)
            }
        }
    };

    function a() {
        this.baseConstructor.apply(this, arguments)
    }
    a.inheritFrom(Draggable, {
        oninit: function(f, e, d) {
            this.uid = e;
            this.parent = d;
            this.value = {};
            this.settings = this.parent.settings
        },
        onmousedown: function(d) {
            this._parent = {
                offset: this.parent.domNode.offset(),
                width: this.parent.domNode.width()
            };
            this.ptr.addDependClass("hover");
            this.setIndexOver()
        },
        onmousemove: function(e, d) {
            var f = this._getPageCoords(e);
            this._set(this.calc(f.x))
        },
        onmouseup: function(d) {
            if (this.parent.settings.callback && b.isFunction(this.parent.settings.callback)) {
                this.parent.settings.callback.call(this.parent, this.parent.getValue())
            }
            this.ptr.removeDependClass("hover")
        },
        setIndexOver: function() {
            this.parent.setPointersIndex(1);
            this.index(2)
        },
        index: function(d) {
            this.ptr.css({
                zIndex: d
            })
        },
        limits: function(d) {
            return this.parent.limits(d, this)
        },
        calc: function(e) {
            var d = this.limits(((e - this._parent.offset.left) * 100) / this._parent.width);
            return d
        },
        set: function(d, e) {
            this.value.origin = this.parent.round(d);
            this._set(this.parent.valueToPrc(d, this), e)
        },
        _set: function(e, d) {
            if (!d) {
                this.value.origin = this.parent.prcToValue(e)
            }
            this.value.prc = e;
            this.ptr.css({
                left: e + "%"
            });
            this.parent.redraw(this)
        }
    })
})(jQuery);

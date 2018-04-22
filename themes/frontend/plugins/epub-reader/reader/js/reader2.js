    EPUBJS.reader = {},
    EPUBJS.reader.plugins = {},

    function(a, b) {
        var c = (a.ePubReader || {}, a.ePubReader = function(a, b) {
            return new EPUBJS.Reader(a, b)
        });
        "function" == typeof define && define.amd ? define(function() {
            return Reader
        }) : "undefined" != typeof module && module.exports && (module.exports = c)
    }(window, jQuery), EPUBJS.Reader = function(a, b) {
    var c, d, e, f = this,
        g = $("#viewer"),
        h = window.location.search;
    this.settings = EPUBJS.core.defaults(b || {}, {
        bookPath: a,
        restore: !1,
        reload: !1,
        bookmarks: void 0,
        annotations: void 0,
        contained: void 0,
        bookKey: void 0,
        styles: void 0,
        sidebarReflow: !1,
        generatePagination: !1,
        history: !0
    }), h && (e = h.slice(1).split("&"), e.forEach(function(a) {
        var b = a.split("="),
            c = b[0],
            d = b[1] || "";
        f.settings[c] = decodeURIComponent(d)
    })), this.setBookKey(this.settings.bookPath), this.settings.restore && this.isSaved() && this.applySavedSettings(), this.settings.styles = this.settings.styles || {
            fontSize: "100%"
        }, this.book = c = new EPUBJS.Book(this.settings), this.settings.previousLocationCfi && c.gotoCfi(this.settings.previousLocationCfi), this.offline = !1, this.sidebarOpen = !1, this.settings.bookmarks || (this.settings.bookmarks = []), this.settings.annotations || (this.settings.annotations = []), this.settings.generatePagination && c.generatePagination(g.width(), g.height()), c.renderTo("viewer"), f.ReaderController = EPUBJS.reader.ReaderController.call(f, c), f.SettingsController = EPUBJS.reader.SettingsController.call(f, c), f.LastPageController = EPUBJS.reader.LastPageController.call(f, c);
    for (d in EPUBJS.reader.plugins) EPUBJS.reader.plugins.hasOwnProperty(d) && (f[d] = EPUBJS.reader.plugins[d].call(f, c));
    return c.ready.all.then(function() {
        f.ReaderController.hideLoader()
    }), c.getMetadata().then(function(a) {
        f.MetaController = EPUBJS.reader.MetaController.call(f, a), "rtl" == a.direction ? document.body.className += " rtl-book" : document.body.className += " ltr-book"
    }), c.getToc().then(function(a) {
        f.TocController = EPUBJS.reader.TocController.call(f, a)
    }), window.addEventListener("beforeunload", this.unload.bind(this), !1), window.addEventListener("hashchange", this.hashChanged.bind(this), !1), document.addEventListener("keydown", this.adjustFontSize.bind(this), !1), c.on("renderer:keydown", this.adjustFontSize.bind(this)), c.on("renderer:keydown", f.ReaderController.arrowKeys.bind(this)), c.on("renderer:selected", this.selectedRange.bind(this)), this
},

        EPUBJS.Reader.prototype.adjustFontSize = function(a) {
    var b, c = 2,
        d = 187,
        e = 189,
        f = 48,
        g = a.ctrlKey || a.metaKey;
    this.settings.styles && (this.settings.styles.fontSize || (this.settings.styles.fontSize = "100%"), b = parseInt(this.settings.styles.fontSize.slice(0, -1)), g && a.keyCode == d && (a.preventDefault(), this.book.setStyle("fontSize", b + c + "%")), g && a.keyCode == e && (a.preventDefault(), this.book.setStyle("fontSize", b - c + "%")), g && a.keyCode == f && (a.preventDefault(), this.book.setStyle("fontSize", "100%")))
}, EPUBJS.Reader.prototype.addBookmark = function(a) {
    var b = this.isBookmarked(a);
    b > -1 || (this.settings.bookmarks.push(a), this.trigger("reader:bookmarked", a))
}, EPUBJS.Reader.prototype.removeBookmark = function(a) {
    var b = this.isBookmarked(a);
    b !== -1 && (this.settings.bookmarks.splice(b, 1), this.trigger("reader:unbookmarked", b))
}, EPUBJS.Reader.prototype.isBookmarked = function(a) {
    var b = this.settings.bookmarks;
    return b.indexOf(a)
}, EPUBJS.Reader.prototype.clearBookmarks = function() {
    this.settings.bookmarks = []
}, EPUBJS.Reader.prototype.addNote = function(a) {
    this.settings.annotations.push(a)
}, EPUBJS.Reader.prototype.removeNote = function(a) {
    var b = this.settings.annotations.indexOf(a);
    b !== -1 && delete this.settings.annotations[b]
}, EPUBJS.Reader.prototype.clearNotes = function() {
    this.settings.annotations = []
}, EPUBJS.Reader.prototype.setBookKey = function(a) {
    return this.settings.bookKey || (this.settings.bookKey = "epubjsreader:" + EPUBJS.VERSION + ":" + window.location.host + ":" + a), this.settings.bookKey
}, EPUBJS.Reader.prototype.isSaved = function(a) {
    var b;
    return !!localStorage && (b = localStorage.getItem(this.settings.bookKey), null !== b)
}, EPUBJS.Reader.prototype.removeSavedSettings = function() {
    return !!localStorage && void localStorage.removeItem(this.settings.bookKey)
}, EPUBJS.Reader.prototype.applySavedSettings = function() {
    var a;
    if (!localStorage) return !1;
    try {
        a = JSON.parse(localStorage.getItem(this.settings.bookKey))
    } catch (a) {
        return !1
    }
    return !!a && (a.styles && (this.settings.styles = EPUBJS.core.defaults(this.settings.styles || {}, a.styles)), this.settings = EPUBJS.core.defaults(this.settings, a), !0)
}, EPUBJS.Reader.prototype.saveSettings = function() {
    return this.book && (this.settings.previousLocationCfi = this.book.getCurrentLocationCfi()), !!localStorage && void localStorage.setItem(this.settings.bookKey, JSON.stringify(this.settings))
}, EPUBJS.Reader.prototype.unload = function() {
    this.settings.restore && localStorage && this.saveSettings()
}, EPUBJS.Reader.prototype.hashChanged = function() {
    var a = window.location.hash.slice(1);
    this.book.goto(a)
}, EPUBJS.Reader.prototype.selectedRange = function(a) {
    var b = new EPUBJS.EpubCFI,
        c = b.generateCfiFromRangeAnchor(a, this.book.renderer.currentChapter.cfiBase),
        d = "#" + c;
    this.settings.history && window.location.hash != d && (this.currentLocationCfi = c)
}, RSVP.EventTarget.mixin(EPUBJS.Reader.prototype), EPUBJS.reader.BookmarksController = function() {
    var a = this.book,
        b = $("#bookmarksView"),
        c = b.find("#bookmarks"),
        d = document.createDocumentFragment(),
        e = function() {
            b.show()
        },
        f = function() {
            b.hide()
        },
        g = 0,
        h = function(b) {
            var c = document.createElement("li"),
                d = document.createElement("a");
            return c.id = "bookmark-" + g, c.classList.add("list_item"), d.textContent = b, d.href = b, d.classList.add("bookmark_link"), d.addEventListener("click", function(b) {
                var c = this.getAttribute("href");
                a.gotoCfi(c), b.preventDefault()
            }, !1), c.appendChild(d), g++, c
        };
    return this.settings.bookmarks.forEach(function(a) {
        var b = h(a);
        d.appendChild(b)
    }), c.append(d), this.on("reader:bookmarked", function(a) {
        var b = h(a);
        c.append(b)
    }), this.on("reader:unbookmarked", function(a) {
        var b = $("#bookmark-" + a);
        b.remove()
    }), {
        show: e,
        hide: f
    }
}, EPUBJS.reader.ControlsController = function(a) {
    var b = this,
        c = ($("#store"), $("#fullscreen")),
        d = ($("#fullscreenicon"), $("#cancelfullscreenicon"), $("#slider")),
        e = ($("#main"), $("#sidebar"), $("#setting")),
        f = $("#bookmark"),
        g = function() {
            b.offline = !1
        },
        h = function() {
            b.offline = !0
        },
        i = !1;
    return a.on("book:online", g), a.on("book:offline", h), d.on("click", function() {
        b.sidebarOpen ? (b.SidebarController.hide(), d.addClass("icon-menu"), d.removeClass("icon-right")) : (b.SidebarController.show(), d.addClass("icon-right"), d.removeClass("icon-menu"))
    }), "undefined" != typeof screenfull && (c.on("click", function() {
        screenfull.toggle($("#container")[0])
    }), screenfull.raw && document.addEventListener(screenfull.raw.fullscreenchange, function() {
        i = screenfull.isFullscreen, i ? c.addClass("icon-resize-small").removeClass("icon-resize-full") : c.addClass("icon-resize-full").removeClass("icon-resize-small")
    })), e.on("click", function() {
        b.SettingsController.show()
    }), f.on("click", function() {
        var a = b.book.getCurrentLocationCfi(),
            c = b.isBookmarked(a);
        c === -1 ? (b.addBookmark(a), f.addClass("icon-bookmark").removeClass("icon-bookmark-empty")) : (b.removeBookmark(a), f.removeClass("icon-bookmark").addClass("icon-bookmark-empty"))
    }), a.on("renderer:locationChanged", function(a) {
        var c = "#" + a,
            d = b.isBookmarked(a);
        d === -1 ? f.removeClass("icon-bookmark").addClass("icon-bookmark-empty") : f.addClass("icon-bookmark").removeClass("icon-bookmark-empty"), b.currentLocationCfi = a, b.settings.history && window.location.hash != c && history.pushState({}, "", c)
    }), a.on("book:pageChanged", function(a) {}), {}
}, EPUBJS.reader.LastPageController = function(a) {
    var a = this.book,
        b = null,
        c = $("#viewer");
    a.on("book:atLastPage", function(d) {
        null == b ? (b = $("<div></div>"), b.css({
            position: "absolute",
            top: 0,
            left: 0,
            width: "100%",
            height: "100%"
        }), $("#lastPage").appendTo(b).show(), b.appendTo(c), a.on("renderer:chapterDisplayed", function(c) {
            c.spinePos != a.spine.length - 1 && b && b.is(":visible") && b.hide()
        })) : b.show()
    });
    var d = function() {};
    return d(), {}
}, EPUBJS.reader.MetaController = function(a) {
    var b = a.bookTitle,
        c = a.creator,
        d = $("#book-title"),
        e = $("#chapter-title"),
        f = $("#title-seperator");
    document.title = b + " â€“ " + c, d.html(b), e.html(c), f.show()
}, EPUBJS.reader.NotesController = function() {
    var a = this.book,
        b = this,
        c = $("#notesView"),
        d = $("#notes"),
        e = $("#note-text"),
        f = $("#note-anchor"),
        g = b.settings.annotations,
        h = a.renderer,
        i = [],
        j = new EPUBJS.EpubCFI,
        k = function() {
            c.show()
        },
        l = function() {
            c.hide()
        },
        m = function(c) {
            var d, g, h, i, k, l = a.renderer.doc;
            if (l.caretPositionFromPoint ? (d = l.caretPositionFromPoint(c.clientX, c.clientY), g = d.offsetNode, h = d.offset) : l.caretRangeFromPoint && (d = l.caretRangeFromPoint(c.clientX, c.clientY), g = d.startContainer, h = d.startOffset), 3 !== g.nodeType)
                for (var p = 0; p < g.childNodes.length; p++)
                    if (3 == g.childNodes[p].nodeType) {
                        g = g.childNodes[p];
                        break
                    }
            h = g.textContent.indexOf(".", h), h === -1 ? h = g.length : h += 1, i = j.generateCfiFromTextNode(g, h, a.renderer.currentChapter.cfiBase), k = {
                annotatedAt: new Date,
                anchor: i,
                body: e.val()
            }, b.addNote(k), n(k), o(k), e.val(""), f.text("Attach"), e.prop("disabled", !1), a.off("renderer:click", m)
        },
        n = function(b) {
            var c = document.createElement("li"),
                e = document.createElement("a");
            c.innerHTML = b.body, e.innerHTML = " context &#187;", e.href = "#" + b.anchor, e.onclick = function() {
                return a.gotoCfi(b.anchor), !1
            }, c.appendChild(e), d.append(c)
        },
        o = function(b) {
            var c = a.renderer.doc,
                d = document.createElement("span"),
                e = document.createElement("a");
            d.classList.add("footnotesuperscript", "reader_generated"), d.style.verticalAlign = "super", d.style.fontSize = ".75em", d.style.lineHeight = "1em", e.style.padding = "2px", e.style.backgroundColor = "#fffa96", e.style.borderRadius = "5px", e.style.cursor = "pointer", d.id = "note-" + EPUBJS.core.uuid(), e.innerHTML = g.indexOf(b) + 1 + "[Reader]", d.appendChild(e), j.addMarker(b.anchor, c, d), p(d, b.body)
        },
        p = function(a, c) {
            var d = a.id,
                e = function() {
                    var b, e, k, l, m = h.height,
                        n = h.width,
                        o = 225;
                    i[d] || (i[d] = document.createElement("div"), i[d].setAttribute("class", "popup"), pop_content = document.createElement("div"), i[d].appendChild(pop_content), pop_content.innerHTML = c, pop_content.setAttribute("class", "pop_content"), h.render.document.body.appendChild(i[d]), i[d].addEventListener("mouseover", f, !1), i[d].addEventListener("mouseout", g, !1), h.on("renderer:locationChanged", j, this), h.on("renderer:locationChanged", g, this)), b = i[d], e = a.getBoundingClientRect(), k = e.left, l = e.top, b.classList.add("show"), popRect = b.getBoundingClientRect(), b.style.left = k - popRect.width / 2 + "px", b.style.top = l + "px", o > m / 2.5 && (o = m / 2.5, pop_content.style.maxHeight = o + "px"), popRect.height + l >= m - 25 ? (b.style.top = l - popRect.height + "px", b.classList.add("above")) : b.classList.remove("above"), k - popRect.width <= 0 ? (b.style.left = k + "px", b.classList.add("left")) : b.classList.remove("left"), k + popRect.width / 2 >= n ? (b.style.left = k - 300 + "px", popRect = b.getBoundingClientRect(), b.style.left = k - popRect.width + "px", popRect.height + l >= m - 25 ? (b.style.top = l - popRect.height + "px", b.classList.add("above")) : b.classList.remove("above"), b.classList.add("right")) : b.classList.remove("right")
                },
                f = function() {
                    i[d].classList.add("on")
                },
                g = function() {
                    i[d].classList.remove("on")
                },
                j = function() {
                    setTimeout(function() {
                        i[d].classList.remove("show")
                    }, 100)
                },
                l = function() {
                    b.ReaderController.slideOut(), k()
                };
            a.addEventListener("mouseover", e, !1), a.addEventListener("mouseout", j, !1), a.addEventListener("click", l, !1)
        };
    return f.on("click", function(b) {
        f.text("Cancel"), e.prop("disabled", "true"), a.on("renderer:click", m)
    }), g.forEach(function(a) {
        n(a)
    }), h.registerHook("beforeChapterDisplay", function(a, b) {
        var c = b.currentChapter;
        g.forEach(function(a) {
            var b = j.parse(a.anchor);
            if (b.spinePos === c.spinePos) try {
                o(a)
            } catch (b) {
                console.log("anchoring failed", a.anchor)
            }
        }), a()
    }, !0), {
        show: k,
        hide: l
    }
}, EPUBJS.reader.ReaderController = function(a) {
    var b = $("#main"),
        c = $("#divider"),
        d = $("#loader"),
        e = $("#next"),
        f = $("#prev"),
        g = $("#header"),
        h = $("#footer"),
        i = $("#viewer"),
        j = $("#lastPage"),
        k = ($("#container"), null),
        l = [];
    var m = this,
        n = !0,
        o = function() {
            var c = a.getCurrentLocationCfi();
            m.settings.sidebarReflow ? (b.removeClass("single"), b.one("transitionend", function() {
                a.gotoCfi(c)
            })) : b.removeClass("closed")
        },
        p = function() {
            var c = a.getCurrentLocationCfi();
            m.settings.sidebarReflow ? (b.addClass("single"), b.one("transitionend", function() {
                a.gotoCfi(c)
            })) : b.addClass("closed")
        },
        q = function() {
            d.show(), t()
        },
        r = function() {
            d.hide()
        },
        s = function() {
            c.addClass("show")
        },
        t = function() {
            c.removeClass("show")
        },
        u = !1,
        v = function(b) {
            37 == b.keyCode && ("rtl" === a.metadata.direction ? a.nextPage() : a.prevPage(), f.addClass("active"), u = !0, setTimeout(function() {
                u = !1, f.removeClass("active")
            }, 100), b.preventDefault()), 39 == b.keyCode && ("rtl" === a.metadata.direction ? a.prevPage() : a.nextPage(), e.addClass("active"), u = !0, setTimeout(function() {
                u = !1, e.removeClass("active")
            }, 100), b.preventDefault())
        };
    document.addEventListener("keydown", v, !1), e.on("click", function(b) {
        "rtl" === a.metadata.direction ? a.prevPage() : a.nextPage(), b.preventDefault()
    }), f.on("click", function(b) {
        "rtl" === a.metadata.direction ? a.nextPage() : a.prevPage(), b.preventDefault()
    }), a.on("renderer:spreads", function(a) {
        a ? s() : t()
    });
    var w = function(a, b) {
            x(), a.css("top", "10px"), a.css("left", "10px"), a.removeClass("close"), a.addClass("open"), b.addClass("active"), z(!0)
        },
        x = function() {
            $(".floatingMenu.open").removeClass("open").addClass("close"), $(".btns-panel a.active").removeClass("active"), z(!1)
        },
        y = function(a, b) {
            a.removeClass("open").addClass("close"), b.removeClass("active"), z(!1)
        },
        z = function(a) {
            k || (k = $('<div id="overlay"/>').css({
                position: "absolute",
                top: 0,
                left: 0,
                width: i.width() + "px",
                height: i.height() + "px"
            }).hide().appendTo(i), k.click(function() {
                x()
            })), a ? (k.show(), $(document).on("click.readerCtrl", function(a) {
                a.target && $(a.target).parents(".floatingMenu,.btns-panel").length > 0 || k.is(":visible") && x()
            })) : (k.hide(), $(document).off("click.readerCtrl"))
        },
        A = function(c) {
            var d = {
                    white: {
                        background: "#fefefe",
                        text: "#3f3f3f"
                    },
                    sepia: {
                        background: "#F1EADE",
                        text: "#333332"
                    },
                    dark: {
                        background: "#606060",
                        text: "#dddddd"
                    },
                    black: {
                        background: "#373435",
                        text: "#bbbbbb"
                    }
                },
                e = $(document).find("body"),
                f = d[c].background,
                i = d[c].text;
            e.attr("data-theme") && e.removeClass(e.attr("data-theme")), e.addClass(c), e.attr("data-theme", c), a.setStyle("background", f), a.setStyle("color", i), j.css("background-color", f), j.css("color", i), b.css("background-color", f), h.css("background-color", f), g.css("background-color", f)
        },
        B = function() {
            var a = Math.floor(.9 * i.width());
            a % 4 != 0 && (a -= a % 4), $("iframe").width(a)
        },
        C = function() {
            window.setTimeout(function() {
                m.SettingsController.setDefaults(), a.ready.all.then(function() {
                    a.on("book:beforeChapterChange", function(a) {
                        var b = setTimeout(function() {
                            q()
                        }, 300);
                        l.push(b)
                    }), a.on("renderer:chapterDisplayed", function(b) {
                        n && (B(), n = !1), r(), l.forEach(function(a) {
                            clearTimeout(a)
                        }), $ibody = $(a.renderer.render.iframe.contentDocument).find("body"), $ibody.on("contextmenu dragstart", function(a) {
                            return a.preventDefault(), !1
                        }), $ibody.clipboard({
                            disable: !0
                        })
                    })
                })
            }, 1), $(window).on("resize", function() {
                B()
            })
        };
    return C(), {
        slideOut: p,
        slideIn: o,
        showLoader: q,
        hideLoader: r,
        showDivider: s,
        hideDivider: t,
        arrowKeys: v,
        openFloatingMenu: w,
        closeFloatingMenu: y,
        setTheme: A
    }
}, EPUBJS.reader.SettingsController = function() {
    var a = this.book,
        b = this,
        c = $(".floatingMenu.setting"),
        d = $(".btns-panel .setting");
    d.click(function(a) {
        a.preventDefault(), d.hasClass("active") ? f() : e()
    });
    var e = function() {
            b.ReaderController.openFloatingMenu(c, d)
        },
        f = function() {
            b.ReaderController.closeFloatingMenu(c, d)
        },
        g = $("#sidebarReflow");
    g.on("click", function() {
        b.settings.sidebarReflow = !b.settings.sidebarReflow
    });
    var h = function(a) {
            $("#backgroundSelect a." + a).trigger("click")
        },
        i = function() {
            h("sepia"), a.getMetadata().then(function() {
                "rtl" == a.metadata.direction ? ($("#fontNameSelect a.sans").trigger("click"), fontSizeSelector.selectValue(18), lineHeightSelector.selectValue(3)) : ($("#fontNameSelect a.cursive").trigger("click"), $("#fontNameSelect a").css("display", "none"), $("#fontNameSelect a.ltr").css("display", ""), fontSizeSelector.selectValue(18), lineHeightSelector.selectValue(2.5))
            })
        },
        j = function() {
            $("#fontNameSelect a").click(function(a) {
                a.preventDefault(), $("#fontNameSelect a").removeClass("active"), $(this).addClass("active"), b.book.setStyle("fontFamily", $(this).attr("data-val"))
            }), $("#backgroundSelect a").click(function(a) {
                a.preventDefault(), $("#backgroundSelect a").removeClass("active"), $(this).addClass("active"), b.ReaderController.setTheme($(this).attr("data-theme")) /* ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹']*/
            }), fontSizeSelector = new ValueSelector($("#fontSizeSelector"), ["۱۰", "۱۲", "۱۴", "۱۶", "۱۸", "۲۰", "۲۲"], [10, 12, 14, 16, 18, 20, 22]), lineHeightSelector = new ValueSelector($("#lineHeightSelector"), ["۱.۴", "۱.۶", "۱.۸", "۲", "۲.۵", "۳", "۳.۵"], [1.4, 1.6, 1.8, 2, 2.5, 3, 3.5]), $(fontSizeSelector).on("valueChanged", function(a, c, d) {
                b.book.setStyle("fontSize", d + "px")
            }), $(lineHeightSelector).on("valueChanged", function(a, c, d) {
                b.book.setStyle("lineHeight", d + "em")
            })
        };
    return j(), {
        show: e,
        hide: f,
        selectTheme: h,
        setDefaults: i
    }
}, EPUBJS.reader.SidebarController = function(a) {
    var b = this,
        c = $("#sidebar"),
        d = $("#panels"),
        e = "Toc",
        f = function(a) {
            var c = a + "Controller";
            e != a && "undefined" != typeof b[c] && (b[e + "Controller"].hide(), b[c].show(), e = a, d.find(".active").removeClass("active"), d.find("#show-" + a).addClass("active"))
        },
        g = function() {
            return e
        },
        h = function() {
            b.sidebarOpen = !0, b.ReaderController.slideOut(), c.addClass("open")
        },
        i = function() {
            b.sidebarOpen = !1, b.ReaderController.slideIn(), c.removeClass("open")
        };
    return d.find(".show_view").on("click", function(a) {
        var b = $(this).data("view");
        f(b), a.preventDefault()
    }), {
        show: h,
        hide: i,
        getActivePanel: g,
        changePanelTo: f
    }
}, EPUBJS.reader.TocController = function(a) {
    var b = this.book,
        c = this,
        d = $(".floatingMenu.toc"),
        e = $(".btns-panel .toc"),
        f = $("#tocView"),
        g = document.createDocumentFragment(),
        h = !1,
        i = function(a, c) {
            var d = document.createElement("ul");
            b.spine[b.spine.length - 1];
            return c || (c = 1), a.forEach(function(a) {
                var b = document.createElement("li"),
                    e = document.createElement("a");
                toggle = document.createElement("a");
                var f;
                b.id = "toc-" + a.id, b.classList.add("list_item"), e.textContent = a.label, "undefined" == typeof a.spinePos ? (e.href = "#", $(e).css("color", "silver").css("cursor", "default")) : e.href = a.href, e.classList.add("toc_link"), b.appendChild(e), a.subitems.length > 0 && (c++, f = i(a.subitems, c), toggle.classList.add("toc_toggle"), b.insertBefore(toggle, e), b.appendChild(f)), d.appendChild(b)
            }), d
        },
        j = function(a) {
            var b = a.id,
                c = f.find("#toc-" + b),
                d = f.find(".currentChapter");
            f.find(".openChapter");
            c.length && (c != d && c.has(h).length > 0 && d.removeClass("currentChapter"), c.addClass("currentChapter"), c.parents("li").addClass("openChapter"))
        };
    b.on("renderer:chapterDisplayed", j);
    var k = i(a);
    g.appendChild(k), f.append(g), f.find(".toc_link").on("click", function(a) {
        var c = this.getAttribute("href");
        a.preventDefault(), b.goto(c), f.find(".currentChapter").addClass("openChapter").removeClass("currentChapter"), $(this).parent("li").addClass("currentChapter")
    }), f.find(".toc_toggle").on("click", function(a) {
        var b = $(this).parent("li"),
            c = b.hasClass("openChapter");
        a.preventDefault(), c ? b.removeClass("openChapter") : b.addClass("openChapter")
    }), e.click(function(a) {
        a.preventDefault(), e.hasClass("active") ? m() : l()
    });
    var l = function() {
            c.ReaderController.openFloatingMenu(d, e)
        },
        m = function() {
            c.ReaderController.closeFloatingMenu(d, e)
        };
    return {
        show: l,
        hide: m
    }
};
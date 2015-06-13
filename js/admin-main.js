$(function () {
    var body = $("body");
    var t = $(".flash");
    var n = body.hasClass("schedulePage");
    var r;
    if (t.is(":visible")) {
        t.setRemoveTimeout(5e3)
    }
    var i = new Gettext({domain: "messages"});
    setEditableTextfields();
    $(".attributeSelect").each(function () {
        var e = $(this)
    });
    $(window).on("beforeunload", function () {
        if ($(".unsaved").length > 0)return"There are some unsaved changes on this page."
    });
    $('span[class$="Toggle"]').on("click", function () {
        resetActiveField();
        var t = $(this).attr("class");
        var n = $("#" + t.substr(0, t.length - 6));
        if (n.is(":visible")) {
            resetActiveField();
            n.slideToggle("normal", function () {
                u = new $.fn.dataTable.FixedHeader(s)
            })
        } else {
            n.slideToggle();
            body.children(".fixedHeader").each(function () {
                $(this).remove()
            })
        }
    });
    $(window).on("resize", function () {
        if (!r) {
            body.children(".fixedHeader").each(function () {
                $(this).remove()
            });
            o.draw();
            u = new $.fn.dataTable.FixedHeader(o)
        }
    });
    $(".editableTable td").on("mouseover mouseout", function () {
        var e = $("colgroup");
        var t = $(this).prevAll("td").length;
        $(e[t]).toggleClass("hover")
    });
    $("table").on("mouseleave", function () {
        $("colgroup").removeClass("hover")
    });
    $(document).on("submit", ".standardForm", function () {
        if (confirm(i.gettext("Are you sure you want to submit the form? All unsaved changes will be lost!"))) {
            var e = $(this);
            var t = e.parent();
            t.toggleLoadingImage();
            if (e.attr("id") == "productForm") {
                var n = {};
                e.find(".dynamicList").each(function () {
                    var e = [];
                    var t = $(this);
                    t.children("li").each(function () {
                        l = {};
                        var t = $(this);
                        t.children("span").each(function () {
                            var e = $(this);
                            l[e.attr("class").split(" ")[0]] = e.html()
                        });
                        e.push(l)
                    });
                    n[t.attr("class").split(" ")[0]] = e
                })
            } else {
                n = {}
            }
            console.log(n);
            e.ajaxSubmit({target: "#" + e.attr("id"), type: "post", data: {extraData: n}, success: function (e) {
                if (e.redirect) {
                    location.reload(true)
                }
                setEditableTextfields();
                t.toggleLoadingImage()
            }})
        }
        return false
    });
    $(document).on("dblclick", ".editableTable td", function () {
        var t = $(this);
        if (!t.hasClass("activeField") && !t.hasClass("editTextfield") && !t.hasClass("unEditable")) {
            resetActiveField();
            t.addClass("activeField");
            var n = t.text();
            var r;
            var i = $("#editPanel");
            i.appendTo(body);
            var u = i.children(":first");
            var a = t.offset();
            var f = t.outerWidth();
            i.css("width", f - 1);
            i.css("margin-left", a.left);
            i.css("top", a.top + t.outerHeight(true)).show();
            var l = $(".standardForm");
            var c = s.attr("id");
            var h = s.attr("class").split(" ")[1].substr(7);
            var p = t.attr("class").split(" ")[0].substr(h.length).lowerize();
            if (t.hasClass("editSelect") || t.hasClass("editMultiSelect")) {
                r = t.hasClass("editMultiSelect") ? l.find('[name="' + h + "[" + p + '][]"]').clone() : l.find('[name="' + h + "[" + p + ']"]').clone();
                var d = r.find("option");
                if (t.hasClass("excludeCurrent")) {
                    var v = o.row(t.parent()).data()[0];
                    d.each(function () {
                        var e = $(this);
                        if (e.val() == v)e.detach()
                    })
                }
                t.find('span[class^="option"]').each(function () {
                    var e = $(this).attr("class").substr(7);
                    d.filter(function () {
                        return $(this).val() == e
                    }).attr("selected", "selected")
                });
                u.replaceWith(r)
            } else if (t.hasClass("editDatetime")) {
                if (n != "") {
                    var m;
                    var g = n.split("-");
                    m = new Date(g[2], g[1] - 1, g[0])
                } else {
                    m = new Date
                }
                r = $("<input />", {id: "mydate", value: n});
                u.replaceWith(r).datePicker().focus()
            } else if (t.hasClass("editFile") || t.hasClass("editImage")) {
                var y = $("<form />", {action: baseUrl + "/upload-file", enctype: "multipart/form-data", "class": "fileForm"});
                $("<input />", {type: "hidden", name: "fileMeta", value: t.children(".fileMeta").html()}).appendTo(y);
                r = $("<input />", {type: "file", name: "uploadFile"}).appendTo(y);
                u.replaceWith(y).focus()
            } else {
                r = l.find('[name="' + h + "[" + p + ']"]').clone();
                r.val(n);
                u.replaceWith(r)
            }
            r.addClass("editInput").focus()
        }
    });
    $(window).keypress(function (e) {
        if (e.keyCode == 13) {
            if ($("#editPanel").is(":visible")) {
                updateEditedField()
            }
        }
    });
    $(document).on("click", "#editDone", function () {
        updateEditedField()
    });
    var s = $(".editableTable");
    if (s.length > 0) {
        $('.tableWrapper').fadeIn();
        var o = $(".editableTable, #changelogs").DataTable({lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ], stateSave: true, aoColumnDefs: [
            {bSortable: false, aTargets: s.find("th").length - 1},
            {visible: false, targets: [0]}
        ], pagingType: "full_numbers", order: [
            [1, "asc"]
        ], dom: 'C<"clear">lfrtip', colVis: {order: "alpha"}, iDisplayLength: 5}).on("length.dt", function (t, n, r) {
            body.children(".fixedHeader").each(function () {
                $(this).remove()
            });
            o.draw();
            u = new $.fn.dataTable.FixedHeader(o)
        });
        var u = new $.fn.dataTable.FixedHeader(o);
        $("#saveChanges").on("click", function () {
            var e = [];
            var t = n ? $(".scheduleTable") : $(".editableTable");
            var r = t.attr("class").split(" ")[1].substr(7);
            var s = false;
            t.find("tbody .unsaved").each(function () {
                var t = $(this);
                var n = {};
                n["id"] = o.row(t).data()[0];
                t.children("td").each(function () {
                    var e = $(this);
                    if (e.hasClass("required")) {
                        var t = "";
                        if (e.hasClass("editTextfield")) {
                            t = e.children("textarea").val()
                        } else {
                            t = e.text()
                        }
                        if (empty(t)) {
                            e.addClass("redBorder");
                            s = true
                        }
                    }
                    e.removeClass("redBorder");
                    if (!e.hasClass("delete")) {
                        var i = e.attr("class").split(" ")[0].substr(r.length);
                        if (e.hasClass("editImage")) {
                            var o = e.find(".fileImage");
                            if (o.hasClass("changed")) {
                                var u = o.children("img");
                                if (u.length > 0) {
                                    var a = u.attr("src").split("/");
                                    n[i] = a[a.length - 1]
                                } else {
                                    n[i] = null
                                }
                            }
                        } else if (e.hasClass("editFile")) {
                            var f = e.children(".fileName");
                            if (f.hasClass("changed")) {
                                var l = $.trim(f.html());
                                n[i] = l != "-" ? l : null
                            }
                        } else if (e.hasClass("editSelect")) {
                            var c = e.children("span");
                            if (c.length > 0)n[i] = c.attr("class").substr(7)
                        } else if (e.hasClass("editMultiSelect")) {
                            var h = [];
                            e.children("span").each(function () {
                                h.push($(this).attr("class").substr(7))
                            });
                            n[i] = h.length > 0 ? h : null
                        } else if (e.hasClass("editTextfield")) {
                            n[i] = e.children("textarea").val()
                        } else if (e.hasClass("editList")) {
                            var p = [
                                {}
                            ];
                            e.find("ul li").each(function () {
                                var e = $(this);
                                var t = {};
                                e.children("span").each(function () {
                                    t[$(this).attr("class").split(" ")[0]] = $(this).text()
                                });
                                p.push(t)
                            });
                            n[i] = p
                        } else {
                            n[i] = $.trim(e.text()) == "-" ? null : e.text()
                        }
                    }
                });
                e.push(n);
                if (s)return false
            });
            if (s) {
                addMessage(i.gettext("Some required fields are empty."));
                return false
            }
            if (e.length > 0) {
                $("tr.unsaved").removeClass("unsaved");
                $.ajax({url: baseUrl + "/admin/" + t.attr("id") + "/save", type: "POST", data: {entities: e}}).success(function (e) {
                    console.log(e);
                    if (e.success == 1) {
                        location.reload(true)
                    }
                    addMessage(e.message)
                }).error(function (e, t, n) {
                    console.log(e);
                    console.log(t);
                    console.log(n);
                    addMessage(i.gettext("Something with wrong, please try again."))
                })
            } else {
                addMessage(i.gettext("There are no changes to save."))
            }
        });
        $(document).on("click", "td.delete", function () {
            if (confirm(i.gettext("Are you sure about this action?"))) {
                var e = $(this);
                var t = s.attr("id");
                var n = o.row(e.parent()).data()[0];
                $.ajax({url: baseUrl + "/admin/" + t + "/remove", type: "POST", data: {id: n}}).success(function (t) {
                    if (t.success == 1) {
                        o.row(e.parent()).remove().draw();
                        location.reload(true)
                    }
                    addMessage(t.message)
                }).error(function () {
                    addMessage(i.gettext("Something with wrong, please try again."))
                })
            }
        });
        $(document).on("click", ".textEditorToggle", function (t) {
            var n = $(this);
            var i = n.siblings("textarea");
            i.addClass("activeTextfield");
            var s = $("<div/>", {id: "stageWrapper"}).prependTo($("body"));
            var o = $("<div/>", {id: "stage"}).appendTo(s);
            var u = $("<div/>", {id: "textareaWrapper"}).appendTo(o);
            var a = $("<textarea/>", {id: "stageTextarea", html: i.val()}).appendTo(u);
            var f = $("<span />", {"class": "done", html: "Done"}).appendTo(u);
            // Push this converter onto the end of the converters array
            $.sceditor.plugins.xhtml.disallowedAttribs = {
                // The * sign matches every tags so this will allow the id
                // and class attributes on all tags
                '*': {
                    style: null,
                    'class': null,
                    'id': null,
                    "div":null,
                    "lang":null
                }
            };
            a.sceditor({plugins: "xhtml", style: "../css/scedit/jquery.sceditor.default.min.css", emoticonsRoot: "../images/", disallowedTags: ["style", "div"]});
            r = s;
            s.focusLight();
            body.addClass("unscrollable")
        });
        $(document).on("click", "#stage .done", function () {
            var t = $(".activeTextfield");
            var n = $("#stageTextarea").sceditor("instance").val();
            if (t.val() != n) {
                t.closest("tr").addClass("unsaved");
                t.html(n)
            }
            t.removeClass("activeTextfield");
            r.unfocusLight().detach();
            body.removeClass("unscrollable")
        });
        $(document).on("click", ".editAttributes", function () {
            var t = $(this);
            var n = t.siblings(".attributeGuide");
            var i = $("<div/>", {id: "stageWrapper", "class": "wider"}).prependTo(body);
            var s = $("<div />", {id: "stage"}).appendTo(i);
            var o = "";
            n.children("span").each(function () {
                var e = $(this);
                o += e.hasClass("invisible") ? '<th class="invisible"' : "<th";
                o += ">" + e.text() + "</th>"
            });
            var u = $('<div id="attributeList" class="editListContent">' + "<table>" + "<thead>" + "<tr>" + o + "</tr>" + "</thead>" + "<tbody></tbody>" + "</table>" + "</div>").appendTo(s);
            var a = $('<div id="editListOptions">' + '<span class="addAttribute button">Add Attribute</span>' + '<span class="removeAttribute button">Remove Attribute</span>' + '<span class="attributeEditDone button">Done</span> ' + "</div>").appendTo(s);
            var f = $(".editListContent tbody");
            t.siblings("ul").children("li").each(function () {
                var e = $(this);
                var t = $("<tr />");
                e.children("span").each(function () {
                    var e = $(this);
                    var n = $("<td />", {"class": e.hasClass("invisible") ? "invisible" : ""});
                    $("<input />", {value: e.html(), "class": e.attr("class").split(" ")[0]}).appendTo(n);
                    n.appendTo(t)
                });
                t.appendTo(f)
            });
            t.addClass("activeEditedField");
            r = i;
            i.focusLight();
            body.addClass("unscrollable")
        });
        $(document).on("click", ".addAttribute", function () {
            var e = $(".activeEditedField");
            var t = e.siblings(".attributeGuide");
            var n = $("#attributeList tbody");
            var r = parseInt(n.find("tr:last-of-type .position").val());
            r = empty(r) || isNaN(r) ? 1 : r + 1;
            var i = $("<tr />");
            t.children("span").each(function () {
                var e = $(this);
                var t = $("<td />", {"class": e.hasClass("invisible") ? "invisible" : ""});
                $("<input />", {"class": e.attr("class").split(" ")[0], value: e.hasClass("position") ? r : ""}).appendTo(t);
                t.appendTo(i)
            });
            i.appendTo(n)
        });
        $(document).on("click", ".attributeEditDone", function () {
            var t = $(".activeEditedField");
            var n = t.siblings("ul");
            n.empty();
            $("#stage .editListContent").find("tbody").children("tr").each(function () {
                var e = $(this);
                var t = $("<li />");
                e.children("td").each(function () {
                    var e = $(this);
                    var r = e.children("input");
                    if (!e.hasClass("invisible") && empty(r.val())) {
                        r.addClass("redBorder");
                        i = true
                    } else {
                        r.removeClass("redBorder")
                    }
                    if (!i) {
                        i = false;
                        var s = e.hasClass("invisible") ? r.attr("class") + " invisible" : r.attr("class");
                        $("<span />", {"class": s, html: r.val()}).appendTo(t);
                        t.appendTo(n)
                    }
                })
            });
            if (!i) {
                var i = false;
                if (t.closest(".editableTable").length > 0 && n.children("li").length > 0) {
                    t.closest("tr").addClass("unsaved")
                }
                r.unfocusLight().detach();
                t.removeClass("activeEditedField");
                body.removeClass("unscrollable")
            }
        });
        $(document).on("click", ".editListContent tbody tr", function () {
            $(this).parent().find("tr.active").removeClass("active");
            $(this).toggleClass("active")
        });
        $(document).on("click", ".removeAttribute", function () {
            $(".activeEditedField").closest("tr").addClass("unsaved");
            $(".editListContent").find("tr.active").detach()
        })
    }
})
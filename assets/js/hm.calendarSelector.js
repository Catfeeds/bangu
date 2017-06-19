var CalendarSelector = Haima.Control.CalendarSelector;
CalendarSelector = Class.create();
$.extend(CalendarSelector.prototype, {
    /*about: {
        author: 'tbcheng@163.com',
        version: '1.0',
        company: 'otcsz.com',
        desc:'本控件信赖于art.dialog,juicer模板引擎,JSON对象,options下的参数均可由用户自定义'
    },*/
    options: {
        /*注意,此为默认配置,请勿改,如果有些需要自定义的,请在调用的时的构造方法重写*/
        template: {
            container: '<div class="${__options.clsName.container}" id="${__options.id.container}"><div class="${__options.clsName.btnClose}"></div>\
<div class="${__options.clsName.monthSelector}"><div class="${__options.clsName.btnPremonth}"></div>\
<div class="${__options.clsName.btnNextmonth}"></div>$${__options.template.monthPanel,__options,data|renderInnerTemplete}</div>\
<div class="${__options.clsName.dateContainer}"></div></div>',
            monthPanel: '<b>${data.monthNum}</b>月',
            week: '<h1 class="${__options.clsName.holiday}">SUN日</h1><h1>MON一</h1><h1>TUE二</h1><h1>WED三</h1><h1>THU四</h1><h1>FRI五</h1><h1 class="${__options.clsName.holiday}">SAT六</h1>',
            dayContent: '<span>${data.day}</span><i>${data.price}</i><label>${data.peopleNum}</label>',
            //非当前月的日模板
            day: '<h3>$${__options.template.dayContent,__options,data|renderInnerTemplete}</h3>',
            holiday: '<h2 class="${__options.clsName.holiday}">$${__options.template.dayContent,__options,data|renderInnerTemplete}</h2>',
            //当前月的日模板
            curMonthDay: '<h2>$${__options.template.dayContent,__options,data|renderInnerTemplete}</h2>'

        },
        clsName: {
            container: "calendar_selector",
            btnClose: "close",
            monthSelector: "month_selector",
            btnPremonth: "premonth_button",
            btnNextmonth: "nextmonth_button",
            dateContainer: "date_container",
            holiday: "holiday"
        },
        style: {

        },
        id: {
            container: "",
            containerPrefix: "calendar_selector_"
        },
        elementName: {

        },
        flag: {

        },
        initDate: function () {
            return new Date();
        },
        /*总共显示周数,默认6周*/
        totalWeek: 6,
        //当前月1号前显示多少周
        curDateWeekIndex: 0,
        getData: function (date) {
            var This = this;
            var day = date.getDate();
            return This.renderTemplete(date.getMonth() == This.date.getMonth() ? This.options.template.curMonthDay : This.options.template.day, { day: day });
        }
    },
    initialize: function (element, options) {
        var This = this;
        This.initializeSettings(options);
        This.date = This.options.initDate();
        This.initDate();
        if (element != null) {
            This.initializeDom(element);
            This.renderDateBoard();
            This.initializeEvent();
        }
    },
    initializeSettings: function (options) {
        //递归合并
        this.options = $.extend(true, {}, this.options, options);
        //如果没有配置ID,生成随机Id
        this.generateId();
    },
    generateId: function () {
        for (var a in this.options.id) {
            var results = /([^\s]+)Prefix$/.exec(a);
            if (results != null && results.length > 1)
                if ($.trim(this.options.id[results[1]]) == '')
                    this.options.id[results[1]] = String.format('{0}{1}', this.options.id[a], Math.floor(Math.random() * (1000 - 1) + 1));
        }
    },
    initializeDom: function (element) {
        var This = this;
        var $widget;
        if (typeof (element) == 'string')
            $widget = $(String.format('#{0}', element));
        else if (element instanceof jQuery)
            $widget = element;
        else
            throw 'element参数要么是Id,要么是jquery对象.';

        $widget.html(This.renderTemplete(This.options.template.container, This.dateYMD));
        This.$container = $widget.find(String.format('#{0}', This.options.id.container));
        if (This.options.style != null)
            This.$container.css(This.options.style);

        This.$btnClose = This.$container.find(String.format(".{0}", This.options.clsName.btnClose));
        This.$btnPremonth = This.$container.find(String.format(".{0}", This.options.clsName.btnPremonth));
        This.$btnNextmonth = This.$container.find(String.format(".{0}", This.options.clsName.btnNextmonth));
        This.$monthSelector = This.$container.find(String.format(".{0}", This.options.clsName.monthSelector));
        This.$monthLable = This.$monthSelector.find('b');

        This.$dateContainer = This.$container.find(String.format(".{0}", This.options.clsName.dateContainer));
    },
    initDate: function () {
        var This = this;
        var year = This.date.getFullYear();
        var month = This.date.getMonth();
        var day = This.date.getDate();
        var firstDay = new Date(year, month, 1).getDay();
        var totalDay = new Date(year, (month + 1), 0).getDate();
        This.dateYMD = {
            year: year,/*当前日期的年份*/
            month: month,/*月索引[0,11]*/
            day: day,/*当前日期的日数*/
            monthNum: month + 1,/*自然月份数[1-12]*/
            firstDay: firstDay,/*当前月第一天星期几[0,6]*/
            totalDay: totalDay/*当前月总天数*/
        };
    },
    renderInnerTemplete: function (templete, options, data) {
        juicer.unregisterAll();
        juicer.register('toJson', function () {
            var data = arguments[0];
            return JSON.stringify(data);
        });
        return juicer(templete, { __options: options, data: data });
    },
    //register:[{funName,callback}]
    renderTemplete: function (templete, data, register) {
        juicer.unregisterAll();
        juicer.register('toJson', function () {
            var data = arguments[0];
            return JSON.stringify(data);
        });
        juicer.register('renderInnerTemplete', this.renderInnerTemplete);
        if (register != null) {
            $.each(register, function (i, n) {
                juicer.register(n.funName, n.callback);
            });
        }
        if (data == null)
            return juicer(templete, { __options: this.options });
        else
            return juicer(templete, { __options: this.options, data: data });
    },
    initializeEvent: function () {
        var This = this;
        This.$btnClose.click(function () {
            This.$container.hide();
            return false;
        });
        This.$btnPremonth.click(function () {
            This.setDate(This.date.lastMonth());
            return false;
        });
        This.$btnNextmonth.click(function () {
            This.setDate(This.date.nextMonth());
            return false;
        });
        This.$container.click(function () { return false; });
    },
    setDate: function (date) {
        var This = this;
        This.date = date;
        This.renderDateBoard();
    },
    close: function () {
        var This = this;
        This.$container.hide();
        This.isOpen = false;
    },
    show: function () {
        var This = this;
        var $r = This.$container.show();
        This.isOpen = true;
        if (typeof ($.fn.Center) == 'function')
            $r.Center();
        //if (typeof ($.fn.draggable) == 'function')
        //    $r.draggable({ scroll: false });
    },
    renderDateBoard: function () {
        var This = this;
        This.initDate();
        This.$monthLable.html(This.dateYMD.monthNum);
        This.initializeDateBoard();
    },
    initializeDateBoard: function () {
        var This = this;
        var html = '', htmlArr = new Array();
        //当前日期之前需要呈现的天数
        var preTotal = (This.options.curDateWeekIndex * 7) + This.dateYMD.firstDay;
        //之后日期之后需要呈现的天数
        var nextTotal = (This.options.totalWeek * 7 - preTotal - This.dateYMD.totalDay);
        //设置为当前日期第一天
        var date = new Date(This.date.getFullYear(), This.date.getMonth(), 1).getYesterday(false);
        for (var i = preTotal; i > 0; i--, date.getYesterday(false)) {
            htmlArr.push(This.options.getData.call(This, date));
        }
        html += (htmlArr.reverse().join(""));
        //设置为当前日期第一天
        date = new Date(This.date.getFullYear(), This.date.getMonth(), 1);
        for (var i = 0; i < This.dateYMD.totalDay; i++, date.getTomorrow(false)) {
            html += This.options.getData.call(This, date);
        }
        //设置为当前日期最后一天
        date = new Date(This.date.getFullYear(), This.date.getMonth(), This.dateYMD.totalDay).getTomorrow(false);
        for (var i = 0; i < nextTotal; i++, date.getTomorrow(false)) {
            html += This.options.getData.call(This, date);
        }
        date = null;
        html = This.renderTemplete(This.options.template.week) + html;
        This.$dateContainer.html(html);
    }
});
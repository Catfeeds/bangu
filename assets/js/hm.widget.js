; String.format = function () {
    if (arguments.length == 0)
        return null;
    var args = Array.prototype.slice.call(arguments);
    var str = args[0];
    return str.replace(/\{(\d+)\}/g, function (m, i) {
        return args[parseInt(i) + 1];
    });
};
//String.prototype.trimEnd = function (c) {
//    if (c)
//        return this.replace(new RegExp(c.escapeRegExp() + "*$"), '');
//    return this.replace(/\s+$/, '');
//};
//String.prototype.trimStart = function (c) {
//    if (c)
//        return this.replace(new RegExp("^" + c.escapeRegExp() + "*"), '');
//    return this.replace(/^\s+/, '');
//};
//String.prototype.escapeRegExp = function () {
//    return this.replace(/[.*+?^${}()|[\]\/\\]/g, "\\$0");
//};
$.extend(String.prototype, {
    formatArgs: function (obj, pattern) {
        return this.replace(pattern || /\{([^\{\}]*)\}/g, function (m, n) {
            try {
                return eval("obj." + n) || m;
            } catch (e) {
                return m;
            }
        });
    },
    formatJsonDate: function (frmt) {
        var jsondate = this.replace("/Date(", "").replace(")/", "");
        if (jsondate.indexOf("+") > 0) {
            jsondate = jsondate.substring(0, jsondate.indexOf("+"));
        }
        else if (jsondate.indexOf("-") > 0) {
            jsondate = jsondate.substring(0, jsondate.indexOf("-"));
        }
        var date = new Date(parseInt(jsondate, 10));
        if (typeof (frmt) == 'string')
            return date.format(frmt);
        else
            return date;
    }
});
$.extend(Date.prototype, {
    getYesterday: function (createNew) {
        var d = this;
        if (createNew)
            d = new Date(this);
        d.setDate(d.getDate() - 1);
        return d;
    },
    getTomorrow: function (createNew) {
        var d = this;
        if (createNew)
            d = new Date(this);
        d.setDate(d.getDate() + 1);
        return d;
    },
    lastMonth: function () {
        var d = new Date(this.getFullYear(), this.getMonth(), 1);
        d.setMonth(d.getMonth() - 1);
        return d;
    },
    nextMonth: function () {
        var d = new Date(this.getFullYear(), this.getMonth(), 1);
        d.setMonth(d.getMonth() + 1);
        return d;
    },
    format: function (format) {
        var o = {
            "M+": this.getMonth() + 1, //month
            "d+": this.getDate(),    //day
            "h+": this.getHours(),   //hour
            "m+": this.getMinutes(), //minute
            "s+": this.getSeconds(), //second
            "q+": Math.floor((this.getMonth() + 3) / 3),  //quarter
            "S": this.getMilliseconds() //millisecond
        }
        if (/(y+)/.test(format))
            format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o) if (new RegExp("(" + k + ")").test(format))
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
        return format;
    }
});
//全局禁用ajax缓存
$.ajaxSetup({
    cache: false
});
try{
    if ($.browser.msie) {
        var ver = parseInt($.browser.version);
        if (ver < 9) {
            $.extend(Date.prototype, {
                toISOString: function () {
                    return this.format('yyyy-MM-ddThh:mm:ssZ');
                }
            });
        }
    }
} catch (e) { }
$.extend(Array.prototype, {
    remove: function (from, to) {
        var rest = this.slice((to || from) + 1 || this.length);
        this.length = from < 0 ? this.length + from : from;
        return this.push.apply(this, rest);
    },
    each: function (func) {
        if (!$.isFunction(func))
            return;
        for (var i = 0, l = this.length; i < l; i++) {
            func(this[i], i)
        }
    },
    clean: function (deleteValue) {
        var reg = null;
        if (deleteValue instanceof RegExp) {
            reg = new RegExp(deleteValue);
        }
        for (var i = 0; i < this.length; i++) {
            if ((reg != null && reg.test(this[i])) || this[i] == deleteValue) {
                this.splice(i, 1);
                i--;
            }
        }
        return this;
    },
    find: function (filterObj) {
        var arr = this, result = null;
        $.each(arr, function (i, n) {
            var flag = false;
            for (var f in filterObj) {
                if (n[f] && n[f] == filterObj[f]) {
                    flag = true;
                } else {
                    flag = false;
                }
            }
            if (flag) {
                result = n;
                return false;
            }
        });
        return result;
    }
});
if (!Array.indexOf) {
    Array.prototype.indexOf = function (el) {
        for (var i = 0, n = this.length; i < n; i++) {
            if (this[i] === el) {
                return i;
            }
        }
        return -1;
    }
}
$.fn.extend({
    tomFirstFilter: function (expr, fn) {
        var p = this;
        var p2 = null;
        while (p.length > 0 && (p2 = eval(String.format('p.{0}(expr)', fn))).length < 1) {
            p = eval(String.format("p.{0}()", fn));
        }
        return p2;
    },
    firstParent: function (expr) {
        return this.tomFirstFilter(expr, 'parent');
    },
    firstPrev: function (expr) {
        return this.tomFirstFilter(expr, 'prev');
    },
    firstNext: function (expr) {
        return this.tomFirstFilter(expr, 'next');
    }
});
/*
    ********** Juicer **********
    ${A Fast template engine}
    Project Home: http://juicer.name
    文档:http://juicer.name/docs/docs_zh_cn.html (中文)
    Author: Guokai
    Gtalk: badkaikai@gmail.com
    Blog: http://benben.cc
    Licence: MIT License
    Version: 0.6.4-stable
*/
(function () {

    // This is the main function for not only compiling but also rendering.
    // there's at least two parameters need to be provided, one is the tpl, 
    // another is the data, the tpl can either be a string, or an id like #id.
    // if only tpl was given, it'll return the compiled reusable function.
    // if tpl and data were given at the same time, it'll return the rendered 
    // result immediately.

    var juicer = function () {
        var args = [].slice.call(arguments);

        args.push(juicer.options);

        if (args[0].match(/^\s*#([\w:\-\.]+)\s*$/igm)) {
            args[0].replace(/^\s*#([\w:\-\.]+)\s*$/igm, function ($, $id) {
                var _document = document;
                var elem = _document && _document.getElementById($id);
                args[0] = elem ? (elem.value || elem.innerHTML) : $;
            });
        }

        if (arguments.length == 1) {
            return juicer.compile.apply(juicer, args);
        }

        if (arguments.length >= 2) {
            return juicer.to_html.apply(juicer, args);
        }
    };

    var __escapehtml = {
        escapehash: {
            '<': '&lt;',
            '>': '&gt;',
            '&': '&amp;',
            '"': '&quot;',
            "'": '&#x27;',
            '/': '&#x2f;'
        },
        escapereplace: function (k) {
            return __escapehtml.escapehash[k];
        },
        escaping: function (str) {
            return typeof (str) !== 'string' ? str : str.replace(/[&<>"]/igm, this.escapereplace);
        },
        detection: function (data) {
            return typeof (data) === 'undefined' ? '' : data;
        }
    };

    var __throw = function (error) {
        if (typeof (console) !== 'undefined') {
            if (console.warn) {
                console.warn(error);
                return;
            }

            if (console.log) {
                console.log(error);
                return;
            }
        }

        throw (error);
    };

    var __creator = function (o, proto) {
        o = o !== Object(o) ? {} : o;

        if (o.__proto__) {
            o.__proto__ = proto;
            return o;
        }

        var empty = function () { };
        var n = Object.create ?
            Object.create(proto) :
            new (empty.prototype = proto, empty);

        for (var i in o) {
            if (o.hasOwnProperty(i)) {
                n[i] = o[i];
            }
        }

        return n;
    };

    juicer.__cache = {};
    juicer.version = '0.6.4-stable';
    juicer.settings = {};

    juicer.tags = {
        operationOpen: '{@',
        operationClose: '}',
        interpolateOpen: '\\${',
        interpolateClose: '}',
        noneencodeOpen: '\\$\\${',
        noneencodeClose: '}',
        commentOpen: '\\{#',
        commentClose: '\\}'
    };

    juicer.options = {
        cache: true,
        strip: true,
        errorhandling: true,
        detection: true,
        _method: __creator({
            __escapehtml: __escapehtml,
            __throw: __throw,
            __juicer: juicer
        }, {})
    };

    juicer.tagInit = function () {
        var forstart = juicer.tags.operationOpen + 'each\\s*([^}]*?)\\s*as\\s*(\\w*?)\\s*(,\\s*\\w*?)?' + juicer.tags.operationClose;
        var forend = juicer.tags.operationOpen + '\\/each' + juicer.tags.operationClose;
        var ifstart = juicer.tags.operationOpen + 'if\\s*([^}]*?)' + juicer.tags.operationClose;
        var ifend = juicer.tags.operationOpen + '\\/if' + juicer.tags.operationClose;
        var elsestart = juicer.tags.operationOpen + 'else' + juicer.tags.operationClose;
        var elseifstart = juicer.tags.operationOpen + 'else if\\s*([^}]*?)' + juicer.tags.operationClose;
        var interpolate = juicer.tags.interpolateOpen + '([\\s\\S]+?)' + juicer.tags.interpolateClose;
        var noneencode = juicer.tags.noneencodeOpen + '([\\s\\S]+?)' + juicer.tags.noneencodeClose;
        var inlinecomment = juicer.tags.commentOpen + '[^}]*?' + juicer.tags.commentClose;
        var rangestart = juicer.tags.operationOpen + 'each\\s*(\\w*?)\\s*in\\s*range\\(([^}]+?)\\s*,\\s*([^}]+?)\\)' + juicer.tags.operationClose;
        var include = juicer.tags.operationOpen + 'include\\s*([^}]*?)\\s*,\\s*([^}]*?)' + juicer.tags.operationClose;

        juicer.settings.forstart = new RegExp(forstart, 'igm');
        juicer.settings.forend = new RegExp(forend, 'igm');
        juicer.settings.ifstart = new RegExp(ifstart, 'igm');
        juicer.settings.ifend = new RegExp(ifend, 'igm');
        juicer.settings.elsestart = new RegExp(elsestart, 'igm');
        juicer.settings.elseifstart = new RegExp(elseifstart, 'igm');
        juicer.settings.interpolate = new RegExp(interpolate, 'igm');
        juicer.settings.noneencode = new RegExp(noneencode, 'igm');
        juicer.settings.inlinecomment = new RegExp(inlinecomment, 'igm');
        juicer.settings.rangestart = new RegExp(rangestart, 'igm');
        juicer.settings.include = new RegExp(include, 'igm');
    };

    juicer.tagInit();

    // Using this method to set the options by given conf-name and conf-value,
    // you can also provide more than one key-value pair wrapped by an object.
    // this interface also used to custom the template tag delimater, for this
    // situation, the conf-name must begin with tag::, for example: juicer.set
    // ('tag::operationOpen', '{@').

    juicer.set = function (conf, value) {
        var that = this;

        var escapePattern = function (v) {
            return v.replace(/[\$\(\)\[\]\+\^\{\}\?\*\|\.]/igm, function ($) {
                return '\\' + $;
            });
        };

        var set = function (conf, value) {
            var tag = conf.match(/^tag::(.*)$/i);

            if (tag) {
                that.tags[tag[1]] = escapePattern(value);
                that.tagInit();
                return;
            }

            that.options[conf] = value;
        };

        if (arguments.length === 2) {
            set(conf, value);
            return;
        }

        if (conf === Object(conf)) {
            for (var i in conf) {
                if (conf.hasOwnProperty(i)) {
                    set(i, conf[i]);
                }
            }
        }
    };

    // Before you're using custom functions in your template like ${name | fnName},
    // you need to register this fn by juicer.register('fnName', fn).

    juicer.register = function (fname, fn) {
        var _method = this.options._method;

        if (_method.hasOwnProperty(fname)) {
            return false;
        }

        return _method[fname] = fn;
    };

    // remove the registered function in the memory by the provided function name.
    // for example: juicer.unregister('fnName').

    juicer.unregister = function (fname) {
        var _method = this.options._method;

        if (_method.hasOwnProperty(fname)) {
            return delete _method[fname];
        }
    };
    //汤波成增加此方法,目的:卸载非全局方法,如果要注册全局的方法,请以g_(忽略大小写)开关命名函数
    juicer.unregisterAll = function (includeGlobal) {
        var m = this.options._method;
        for (var p in m) {
            if (typeof (m[p]) == "function" && !/^__/.test(p)) {
                if (includeGlobal || !/^g_/i.test(p)) {
                    juicer.unregister(p);
                }
            }
        }
    }
    juicer.template = function (options) {
        var that = this;

        this.options = options;

        this.__interpolate = function (_name, _escape, options) {
            var _define = _name.split('|'), _fn = _define[0] || '', _cluster;

            if (_define.length > 1) {
                _name = _define.shift();
                _cluster = _define.shift().split(',');
                _fn = '_method.' + _cluster.shift() + '.call({}, ' + [_name].concat(_cluster) + ')';
            }

            return '<%= ' + (_escape ? '_method.__escapehtml.escaping' : '') + '(' +
                        (!options || options.detection !== false ? '_method.__escapehtml.detection' : '') + '(' +
                            _fn +
                        ')' +
                    ')' +
                ' %>';
        };

        this.__removeShell = function (tpl, options) {
            var _counter = 0;

            tpl = tpl
                // for expression
                .replace(juicer.settings.forstart, function ($, _name, alias, key) {
                    var alias = alias || 'value', key = key && key.substr(1);
                    var _iterate = 'i' + _counter++;
                    return '<% ~function() {' +
                                'for(var ' + _iterate + ' in ' + _name + ') {' +
                                    'if(' + _name + '.hasOwnProperty(' + _iterate + ')) {' +
                                        'var ' + alias + '=' + _name + '[' + _iterate + '];' +
                                        (key ? ('var ' + key + '=' + _iterate + ';') : '') +
                            ' %>';
                })
                .replace(juicer.settings.forend, '<% }}}(); %>')

                // if expression
                .replace(juicer.settings.ifstart, function ($, condition) {
                    return '<% if(' + condition + ') { %>';
                })
                .replace(juicer.settings.ifend, '<% } %>')

                // else expression
                .replace(juicer.settings.elsestart, function ($) {
                    return '<% } else { %>';
                })

                // else if expression
                .replace(juicer.settings.elseifstart, function ($, condition) {
                    return '<% } else if(' + condition + ') { %>';
                })

                // interpolate without escape
                .replace(juicer.settings.noneencode, function ($, _name) {
                    return that.__interpolate(_name, false, options);
                })

                // interpolate with escape
                .replace(juicer.settings.interpolate, function ($, _name) {
                    return that.__interpolate(_name, true, options);
                })

                // clean up comments
                .replace(juicer.settings.inlinecomment, '')

                // range expression
                .replace(juicer.settings.rangestart, function ($, _name, start, end) {
                    var _iterate = 'j' + _counter++;
                    return '<% ~function() {' +
                                'for(var ' + _iterate + '=' + start + ';' + _iterate + '<' + end + ';' + _iterate + '++) {{' +
                                    'var ' + _name + '=' + _iterate + ';' +
                            ' %>';
                })

                // include sub-template
                .replace(juicer.settings.include, function ($, tpl, data) {
                    return '<%= _method.__juicer(' + tpl + ', ' + data + '); %>';
                });

            // exception handling
            if (!options || options.errorhandling !== false) {
                tpl = '<% try { %>' + tpl;
                tpl += '<% } catch(e) {_method.__throw("Juicer Render Exception: "+e.message);} %>';
            }

            return tpl;
        };

        this.__toNative = function (tpl, options) {
            return this.__convert(tpl, !options || options.strip);
        };

        this.__lexicalAnalyze = function (tpl) {
            var buffer = [];
            var method = [];
            var prefix = '';
            var reserved = [
                'if', 'each', '_', '_method', 'console',
                'break', 'case', 'catch', 'continue', 'debugger', 'default', 'delete', 'do',
                'finally', 'for', 'function', 'in', 'instanceof', 'new', 'return', 'switch',
                'this', 'throw', 'try', 'typeof', 'var', 'void', 'while', 'with', 'null', 'typeof',
                'class', 'enum', 'export', 'extends', 'import', 'super', 'implements', 'interface',
                'let', 'package', 'private', 'protected', 'public', 'static', 'yield', 'const', 'arguments',
                'true', 'false', 'undefined', 'NaN'
            ];

            var indexOf = function (array, item) {
                if (Array.prototype.indexOf && array.indexOf === Array.prototype.indexOf) {
                    return array.indexOf(item);
                }

                for (var i = 0; i < array.length; i++) {
                    if (array[i] === item) return i;
                }

                return -1;
            };

            var variableAnalyze = function ($, statement) {
                statement = statement.match(/\w+/igm)[0];

                if (indexOf(buffer, statement) === -1 && indexOf(reserved, statement) === -1 && indexOf(method, statement) === -1) {

                    // avoid re-declare native function, if not do this, template 
                    // `{@if encodeURIComponent(name)}` could be throw undefined.

                    if (typeof (window) !== 'undefined' && typeof (window[statement]) === 'function' && window[statement].toString().match(/^\s*?function \w+\(\) \{\s*?\[native code\]\s*?\}\s*?$/i)) {
                        return $;
                    }

                    // compatible for node.js
                    if (typeof (global) !== 'undefined' && typeof (global[statement]) === 'function' && global[statement].toString().match(/^\s*?function \w+\(\) \{\s*?\[native code\]\s*?\}\s*?$/i)) {
                        return $;
                    }

                    // avoid re-declare registered function, if not do this, template 
                    // `{@if registered_func(name)}` could be throw undefined.

                    if (typeof (juicer.options._method[statement]) === 'function') {
                        method.push(statement);
                        return $;
                    }

                    buffer.push(statement); // fuck ie
                }

                return $;
            };

            tpl.replace(juicer.settings.forstart, variableAnalyze).
                replace(juicer.settings.interpolate, variableAnalyze).
                replace(juicer.settings.ifstart, variableAnalyze).
                replace(juicer.settings.elseifstart, variableAnalyze).
                replace(juicer.settings.include, variableAnalyze).
                replace(/[\+\-\*\/%!\?\|\^&~<>=,\(\)]\s*([A-Za-z_]+)/igm, variableAnalyze);

            for (var i = 0; i < buffer.length; i++) {
                prefix += 'var ' + buffer[i] + '=_.' + buffer[i] + ';';
            }

            for (var i = 0; i < method.length; i++) {
                prefix += 'var ' + method[i] + '=_method.' + method[i] + ';';
            }

            return '<% ' + prefix + ' %>';
        };

        this.__convert = function (tpl, strip) {
            var buffer = [].join('');

            buffer += "'use strict';"; // use strict mode
            buffer += "var _=_||{};";
            buffer += "var _out='';_out+='";

            if (strip !== false) {
                buffer += tpl
                    .replace(/\\/g, "\\\\")
                    .replace(/[\r\t\n]/g, " ")
                    .replace(/'(?=[^%]*%>)/g, "\t")
                    .split("'").join("\\'")
                    .split("\t").join("'")
                    .replace(/<%=(.+?)%>/g, "';_out+=$1;_out+='")
                    .split("<%").join("';")
                    .split("%>").join("_out+='") +
                    "';return _out;";

                return buffer;
            }

            buffer += tpl
                    .replace(/\\/g, "\\\\")
                    .replace(/[\r]/g, "\\r")
                    .replace(/[\t]/g, "\\t")
                    .replace(/[\n]/g, "\\n")
                    .replace(/'(?=[^%]*%>)/g, "\t")
                    .split("'").join("\\'")
                    .split("\t").join("'")
                    .replace(/<%=(.+?)%>/g, "';_out+=$1;_out+='")
                    .split("<%").join("';")
                    .split("%>").join("_out+='") +
                    "';return _out.replace(/[\\r\\n]\\s+[\\r\\n]/g, '\\r\\n');";

            return buffer;
        };

        this.parse = function (tpl, options) {
            var _that = this;

            if (!options || options.loose !== false) {
                tpl = this.__lexicalAnalyze(tpl) + tpl;
            }

            tpl = this.__removeShell(tpl, options);
            tpl = this.__toNative(tpl, options);

            this._render = new Function('_, _method', tpl);

            this.render = function (_, _method) {
                if (!_method || _method !== that.options._method) {
                    _method = __creator(_method, that.options._method);
                }

                return _that._render.call(this, _, _method);
            };

            return this;
        };
    };

    juicer.compile = function (tpl, options) {
        if (!options || options !== this.options) {
            options = __creator(options, this.options);
        }

        try {
            var engine = this.__cache[tpl] ?
                this.__cache[tpl] :
                new this.template(this.options).parse(tpl, options);

            if (!options || options.cache !== false) {
                this.__cache[tpl] = engine;
            }

            return engine;

        } catch (e) {
            __throw('Juicer Compile Exception: ' + e.message);

            return {
                render: function () { } // noop
            };
        }
    };

    juicer.to_html = function (tpl, data, options) {
        if (!options || options !== this.options) {
            options = __creator(options, this.options);
        }

        return this.compile(tpl, options).render(data, options._method);
    };

    typeof (module) !== 'undefined' && module.exports ? module.exports = juicer : this.juicer = juicer;

})();
/*-----面向对象脚本库start-------by tangbocheng*/
var Class = {
    create: function () {
        return function () {
            this.initialize.apply(this, arguments);
        };
    }
};
var Haima = {
    version: "1.0",
    author: "hm.dev",
    login: function (uid, pwd, vcode, callback, isrememberme) { },
    namespace: function () {
        var b = arguments,
		g = null,
		e, f, c;
        for (e = 0; e < b.length; e = e + 1) {
            c = b[e].split(".");
            g = Haima;
            for (f = (c[0] == "Haima") ? 1 : 0; f < c.length; f = f + 1) {
                g[c[f]] = g[c[f]] || {};
                g = g[c[f]];
            }
        }
        return g;
    }
};
//注册基本命名空间
Haima.namespace("Haima.Control", "Haima.Utility");
/*--------面向对象脚本库end------------*/
//标题通知
function hmnotify(msg, options) {
    if (typeof (options) == 'undefined') {
        options = {};
    }
    var templete = options.templete || "{msg}";//标题渲染模板
    var wndLength = options.wndLength || 20;//窗口长度
    var interval = options.interval || 100;//时间间隔
    var mask = options.mask || "　";//掩码

    var content = msg;
    var path = wndLength + content.length;
    var step = 0;
    clearInterval(window.hmTitleNotify);
    window.hmTitleNotify = setInterval(function () {
        var str = "";
        for (i = 1; i <= wndLength - step; i++) {
            str += mask;//前面的掩码符号
        }
        var a = (step <= wndLength ? step : wndLength);
        var b = wndLength - step;
        var c = b > 0 ? 0 : -b;
        for (var j = c; j <= a + c ; j++) {
            str += content[j] || mask;
        }
        document.title = templete.replace('{msg}', str);
        if (step >= path) {
            step = 0;
        } else {
            step++;
        }
    }, interval);
}
/***
 *
 * 海外国际
 * @author 旷明爱
 *
 ***/

/**
 * 日期格式化
 */
Date.prototype.format = function(style) {
	var o = {
		"M+" : this.getMonth() + 1, // month
		"d+" : this.getDate(), // day
		"h+" : this.getHours(), // hour
		"m+" : this.getMinutes(), // minute
		"s+" : this.getSeconds(), // second
		"w+" : "日一二三四五六".charAt(this.getDay()), // week
		"q+" : Math.floor((this.getMonth() + 3) / 3), // quarter
		"S" : this.getMilliseconds()
	// millisecond
	}
	if (/(y+)/.test(style)) {
		style = style.replace(RegExp.$1, (this.getFullYear() + "")
				.substr(4 - RegExp.$1.length));
	}
	for ( var k in o) {
		if (new RegExp("(" + k + ")").test(style)) {
			style = style.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k]
					: ("00" + o[k]).substr(("" + o[k]).length));
		}
	}
	return style;
};
// 套餐点击事件
$('.buttonsSuit span').click(function(obj) {
	$('.buttonsSuit span').removeClass("spanon");
	$(this).addClass("spanon");
	var suitid = $(this).attr("suitid");
	_suitid = suitid; // 选中的 套餐
	$('input[name="suit_id"]').val(_suitid);
	// 刷新数据
	getCalendarData();
	$(".line_price").html("请选择出发日期").attr("title", "");
	$("#usedate").val('');
	$("#childNums").removeAttr("disabled").css("opacity", "1").val("0");
	$("#childnobedNums").removeAttr("disabled").css("opacity", "1").val("0");
	$("#oldNums").removeAttr("disabled").css("opacity", "1").val("0");
});
var span_length = $('.buttonsSuit span');
if (span_length < 4) {
	$('.buttonsSuitMore').hide()
} else {
	$('.buttonsSuitMore').show()
}
$('.buttonsSuit span:gt(3)').hide();
var foo = true;
$(".buttonsSuitMore").click(function() {
	if (foo) {
		$(this).html("收起")
		$('.buttonsSuit span:gt(3)').show();
		foo = false;
	} else {
		$(this).html("更多套餐")
		$('.buttonsSuit span:gt(3)').hide();
		foo = true;
	}
})
/*******************************************************************************
 * 异步获取价格日历数据
 */
function getCalendarData() {
	$.ajax({
		url : "/webservices/calendar_meal?suitid=" + _suitid,
		type : "GET",
		dataType : "jsonp",
		jsonp : "callback",
		cache : false,
		success : function(data) {
			var rowsDataJson = eval(data).data.rows;
			// console.log(rowsDataJson);
			if (rowsDataJson.length > 0) {
				if (rowsDataJson[0].child_rule != '') {
					$('#line_childrule').html(rowsDataJson[0].child_rule);
				} else {
					$('#line_childrule').html('无');
				}
				if (rowsDataJson[0].old_rule != '') {
					$('#line_oldrule').html(rowsDataJson[0].old_rule);
				} else {
					$('#line_oldrule').html('无');
				}
				if (rowsDataJson[0].special_rule != '') {
					$('#line_specialrule').html(rowsDataJson[0].special_rule);
				} else {
					$('#line_specialrule').html('无');
				}
			}
			// 1. 解析成map.
			// alert("jsonp:"+rowsDataJson +"
			// calendarPriceMap:"+calendarPriceMap);
			calendarPriceMap.clear();
			for (var i = 0; i < rowsDataJson.length; i++) {
				// alert (rowsDataJson[i].day+":"+rowsDataJson[i].adultprice) ;
				calendarPriceMap.put(rowsDataJson[i].day, rowsDataJson[i]);
			}
			// alert("calendarPriceMap:"+calendarPriceMap.keySet());
			// 2. 刷新
			refresh();
		},
		error : function(arg1, arg2, arg3) {
			// alert('error Error loading XML document:'+arg1+arg2+arg3);
		}
	});
}

var format_pattern = "yyyy-MM-dd"; // 日期格式
var format_month_pattern = "yyyy年MM月";// 头部日期格式
var weekModel = '日一二三四五六';// 星期
var _day_ms = 1000 * 60 * 60 * 24;// 一天的毫秒数
var maxRows = 6;// 行数
var myDate = new Date();

var thisDate = myDate.getDate(); // 获取当前日(1-31)
var thisMonth = myDate.getMonth(); // 获取当前月份(0-11,0代表1月)
var thisYear = myDate.getFullYear(); // 获取完整的年份(4位,1970-????)
var thisDay = myDate.getDay(); // 获取当前星期X(0-6,0代表星期天)

var month = thisMonth;// 当前选择月
var year = thisYear;// 当前选择年
// 上下月控制
var dateControl = '<table class="fc-header" style="width:100%"><tbody><tr><td class="fc-header-left">'
		+ '<span class="fc-button fc-button-prev fc-state-default fc-corner-left fc-corner-right">'
		+ '<span class="fc-button-inner"><span class="fc-button-content">&nbsp;〈&nbsp;</span>'
		+ '<span class="fc-button-effect"><span></span></span></span></span></td><td class="fc-header-center">'
		+ '<span class="fc-header-title"><h2 id="head_date">日历标题</h2></span></td><td class="fc-header-right">'
		+ '<span class="fc-button fc-button-next fc-state-default fc-corner-left fc-corner-right">'
		+ '<span class="fc-button-inner"><span class="fc-button-content">&nbsp;〉&nbsp;</span>'
		+ '<span class="fc-button-effect"><span></span></span></span></span></td></tr></tbody></table>';

/**
 * 画日历
 */
function drawCalendar() {
	// 选择的月份
	var selectMonthDate = new Date();
	selectMonthDate.setYear(year);
	selectMonthDate.setMonth(month);
	selectMonthDate.setDate(1);

	// 该月的第一天
	var firstDate = new Date(selectMonthDate.getFullYear(),month ,1);//new Date(selectMonthDate.getTime());
	var firstDateDate = firstDate.getDate();
	var firstWeek = firstDate.getDay();
	

	// 该月的最后一天
	var lastDate = new Date(selectMonthDate.getFullYear(),(month + 1) ,1);
//	lastDate.setMonth(lastDate.getMonth() + 1);
//	lastDate.setDate(1);
	lastDate = new Date(lastDate.getTime() - _day_ms);//
	var lastDateDate = lastDate.getDate();
	// alert("当前月份:"+selectMonthDate.format(format_month_pattern)+"lastDate:"+lastDate.format(format_pattern)
	// +"firstWeek:"+firstWeek );

	var calendarTable = "<table style='border:1px solid #eaeaea;border-right: none;'cellspacing='0'>";
	// 表头
	calendarTable += "<tr class='date-head-tr'>";
	for (var i = 0; i < weekModel.length; i++) {
		if (i == 0) {
			calendarTable += (" <th class='date-head-first'> " + weekModel.charAt(i) + "</th>");
					
		} else if (i == weekModel.length - 1) {
			calendarTable += (" <th class='date-head-last'> "
					+ weekModel.charAt(i) + "</th>");
		} else {
			calendarTable += (" <th class='date-head'> " + weekModel.charAt(i) + "</th>");
		}
	}
	calendarTable += " </tr>";

	// 日期
	var tempDate = firstDateDate;
	for (var i = 0; i < maxRows; i++) {
		calendarTable += "<tr class='td_price'>";
		for (var j = 1; j <= 7; j++) {
			if (i == 0) {
				if (j <= firstWeek) { // 上月
					var preMonth = month - 1;
					var preDate = new Date();
					preDate.setYear(year);
					preDate.setMonth(month);
					preDate.setDate(0);
					var _date = preDate.getDate() - firstWeek + j;

					preDate.setMonth(preMonth);
					preDate.setDate(_date);

					var data_date = preDate.format(format_pattern);
					calendarTable += (" <td data-date='" + data_date + "' data-day='" + _date + "' class='fc-other-month'>" + _date + "</td>");
				} else {
					var thisTdDate = new Date(year,month,tempDate);

					var data_date = thisTdDate.format(format_pattern);
					calendarTable += (" <td data-date='" + data_date + "' data-day='" + tempDate + "'  class='fc-month'>" + tempDate + "</td>");
					tempDate++;
				}
			} else {
				if (tempDate <= lastDateDate) {
					var thisTdDate = new Date(year,month,tempDate);
////					thisTdDate.setYear(year);
//					thisTdDate.setMonth(month);
//					thisTdDate.setDate(tempDate);
					var data_date = thisTdDate.format(format_pattern);

					calendarTable += (" <td data-date='" + data_date
							+ "' data-day='" + tempDate
							+ "' valign=top class='fc-month'>" + tempDate + "</td>");
					tempDate++;
				} else { // 下月
					var mextMonth = month + 1;
					var nextTempDate = tempDate % lastDateDate;

					var thisTdDate = new Date(year,mextMonth,nextTempDate);
//					thisTdDate.setYear(year);
//					thisTdDate.setMonth(mextMonth);
//					thisTdDate.setDate(nextTempDate);

					var data_date = thisTdDate.format(format_pattern);

					calendarTable += (" <td data-date='" + data_date
							+ "' data-day='" + nextTempDate
							+ "' class='fc-other-month'>" + nextTempDate + "</td>");
					tempDate++;
				}
			}
		}
		calendarTable += "</tr>";
	}
	$("#calendar").html(dateControl + calendarTable);

	// alert("标记");
	$("td[data-date]").each(
			function(index) {
				var data_date = $(this).attr("data-date");
				// alert("格子："+ data_date);
				var strs = data_date.split("-");
				// alert(""+ (thisYear ==strs[0])+( (thisMonth+1) ==strs[1] )+
				// (thisDate>parseInt(strs[2])) +"===="+thisDate +"?"
				// +parseInt(strs[2]));
				if (thisYear == strs[0] && (thisMonth + 1) == strs[1]
						&& thisDate > parseInt(strs[2])) {
					$(this).addClass("date-disable");
					$(this).attr("disabled", "disabled")
				}

			});

	if (!(year == thisYear && month == thisMonth)) {
		$(".fc-header-left").click(function() {
			// alert('上一个月');
			month = month - 1;
			if (month <= -1) {
				month += 12; // 月份减
				year--; // 年份增
			}
			refresh();
		});
	} else {
		// $(".fc-button-inner").css("display","none");///////
	}
	$(".fc-header-right").click(function() {
		// alert('下一个月');
		month = month + 1;
		if (month >= 12) {
			month -= 12; // 月份减
			year++; // 年份增
		}
		refresh();
	});
}

function setTableDate() {
	$("#head_date").html((month + 1) + '月&nbsp;&nbsp;&nbsp;' + year);
}

function refresh() {
	drawCalendar();
	setTableDate();
	fillData();
}
function fillData() {
	// 填充 select 日期数据。
	var keys = calendarPriceMap.keySet();
	// var options = "<li class value='0'> 请选择出发日期 </li>";
	var options = "";
	if (keys.length <= 25) {
		for (var i = 0; i < keys.length; i++) {
			// },{"id":"153","day":"2015-06-25","adultprice":"3850","childprice":"1000","number":"100"}
			// alert("li :"+keys[i]);
			var rowsDataJson = calendarPriceMap.get(keys[i]);
			var text = ",成人:<em class='adult_price'>" + rowsDataJson.adultprice
					+ "</em>";
			var title = ",成人:" + rowsDataJson.adultprice;
			if (rowsDataJson.oldprice != 0) {// 老人价判断
				text += ",老人:<em class='old_price'>" + rowsDataJson.oldprice
						+ "</em>";
				title += ",老人:" + rowsDataJson.oldprice;
			} else {
				text += "<span style='display:none;'>,老人:<em class='old_price'>"
						+ rowsDataJson.oldprice + "</em></span>";
			}
			if (rowsDataJson.childprice != 0) {// 儿童占床价判断
				text += ",儿童占床:<em class='child_price'>"
						+ rowsDataJson.childprice + "</em>";
				title += ",儿童占床:" + rowsDataJson.childprice;
			} else {
				text += "<span style='display:none;'>,儿童占床:<em class='child_price'>"
						+ rowsDataJson.childprice + "</em></span>";
			}
			if (rowsDataJson.childnobedprice != 0) {// 儿童不占床价判断
				text += ",儿童不占床:<em class='childnobed_price'>"
						+ rowsDataJson.childnobedprice + "</em>";
				title += ",儿童不占床:" + rowsDataJson.childnobedprice;
			} else {
				text += "<span style='display:none;'>,儿童不占床:<em class='childnobed_price'>"
						+ rowsDataJson.childnobedprice + "</em></span>";
			}

			var option = "<li title='" + keys[i].substr(2) + title + "' v='"
					+ keys[i] + "'>" + keys[i].substr(2) + text + "</li>";
			/*
			 * var option = "<li class  v='"+keys[i]+"'>"+keys[i].substr(2)+"
			 * ,成人:<em class='adult_price'>"+rowsDataJson.adultprice+"</em>,老人:<em class='old_price'>"+rowsDataJson.oldprice+"</em>,儿童占床:<em class='child_price'>"+rowsDataJson.childprice+"</em></li>"
			 */
			options += option;
		}
	} else {
		for (var i = 0; i < 25; i++) {
			var rowsDataJson = calendarPriceMap.get(keys[i]);
			var text = ",成人:<em class='adult_price'>" + rowsDataJson.adultprice
					+ "</em>";
			var title = ",成人:" + rowsDataJson.adultprice;
			if (rowsDataJson.oldprice != 0) {// 老人价判断
				text += ",老人:<em class='old_price'>" + rowsDataJson.oldprice
						+ "</em>";
				title += ",老人:" + rowsDataJson.oldprice;
			} else {
				text += "<span style='display:none;'>,老人:<em class='old_price'>"
						+ rowsDataJson.oldprice + "</em></span>";
			}
			if (rowsDataJson.childprice != 0) {// 儿童占床价判断
				text += ",儿童占床:<em class='child_price'>"
						+ rowsDataJson.childprice + "</em>";
				title += ",儿童占床:" + rowsDataJson.childprice;
			} else {
				text += "<span style='display:none;'>,儿童占床:<em class='child_price'>"
						+ rowsDataJson.childprice + "</em></span>";
			}
			if (rowsDataJson.childnobedprice != 0) {// 儿童不占床价判断
				text += ",儿童不占床:<em class='childnobed_price'>"
						+ rowsDataJson.childnobedprice + "</em>";
				title += ",儿童不占床:" + rowsDataJson.childnobedprice;
			} else {
				text += "<span style='display:none;'>,儿童不占床:<em class='childnobed_price'>"
						+ rowsDataJson.childnobedprice + "</em></span>";
			}

			var option = "<li title='" + keys[i].substr(2) + title + "' v='"
					+ keys[i] + "'>" + keys[i].substr(2) + text + "</li>";

			/*
			 * var option = "<li class  v='"+keys[i]+"'>"+keys[i].substr(2)+"
			 * ,成人:<em class='adult_price'>"+rowsDataJson.adultprice+"</em>,老人:<em class='old_price'>"+rowsDataJson.oldprice+"</em>,儿童占床:<em class='child_price'>"+rowsDataJson.childprice+"</em></li>";
			 */
			options += option;
		}
		options += "<li>后面的日期可在日历中选择</li>";
	}
	// alert(keys.length);
	$(".expertAge_option").html(options);
	// alert("options :"+options);

	$(".expertAge_option li").hover(function() {
		$(this).addClass('hover').siblings().removeClass('hover');
	}, function() {
		$(this).removeClass('hover');
	});
	$(".expertAge_option li").click(
			function() {
				var txt = $(this).html();
				if (txt != "后面的日期可在日历中选择") {
					$(this).parent().hide();
					$(this).addClass('selected').siblings().removeClass(
							'selected');
					var value = $(this).html();
					var Data = $(this).attr("v");
					// alert(Data);
					$("#usedate").val(Data);
					$(this).parent().siblings().html(value);
					$(this).parent().siblings().attr("title",
							$(this).attr("title"));

					var child_price = parseInt($(".line_price").find(
							".child_price").html());
					var childnobed_price = parseInt($(".line_price").find(
							".childnobed_price").html());
					var old_price = parseInt($(".line_price")
							.find(".old_price").html());
					if (child_price == 0) {// 儿童占床价判断
						$("#childNums").attr("disabled", "disabled").css(
								"opacity", "0.5").val("");
					} else {
						$("#childNums").removeAttr("disabled").css("opacity",
								"1").val("0");
					}
					if (childnobed_price == 0) {// 儿童不占床价判断
						$("#childnobedNums").attr("disabled", "disabled").css(
								"opacity", "0.5").val("");
					} else {
						$("#childnobedNums").removeAttr("disabled").css(
								"opacity", "1").val("0");
					}
					if (old_price == 0) {// 老人价判断
						$("#oldNums").attr("disabled", "disabled").css(
								"opacity", "0.5").val("");
					} else {
						$("#oldNums").removeAttr("disabled")
								.css("opacity", "1").val("0");
					}

				} else {
					$(this).parent().hide();
					$(this).parent().siblings().html("请选择出发日期");
				}
			});

	// document.writeln ("<BR/>keySet:"+calendarPriceMap.keySet() +"
	// ;_selectDate "+_selectDate) ;
	$(".td_price td").each(function(index) {
						// alert($(this) +","+index);
						var _selectDate = $(this).attr('data-date');
						var _selectDay = $(this).attr('data-day'); // 第几天

						// document.writeln ("<BR/> _selectDate :"+_selectDate)
						// ;

						var rowsDataJson = calendarPriceMap.get(_selectDate);
						// alert("rowsDataJson:"+_selectDate+","+rowsDataJson);
						if (rowsDataJson != null) { // 有价格数据
							// alert("rowsDataJson:"+rowsDataJson);
							var price = rowsDataJson.adultprice;
							var number = rowsDataJson.number;
							var price2 = rowsDataJson.oldprice;
							var price3 = rowsDataJson.childprice;
							var price4 = rowsDataJson.childnobedprice;

							// document.writeln( "<BR/> select price:"+price);

							var tdpriceHtml = '<div style="position:relative;"> <div class="fc-day-number">4</div> <div class="fc-day-content"> <div class="fc-day-content-price">&nbsp;</div> </div><div class="hidden_price"></div></div> ';
							$(this).html(tdpriceHtml);

							var leftStr = "充足";
							if (number > 0 && number < 20) {
								leftStr = "余位:" + number;
							} else if (number == 0) {
								leftStr = "无余位";
							}

							var dayDiv = $($(this).children()[0]).children()[0];
							dayDiv.innerHTML = _selectDay
									+ "<span class='leftseat'>" + leftStr
									+ "</span>";

							if (!price) { // 无价格
								$(this).click(function() {
									/* alert('我没有价格:'+_selectDate); */
								});
							} else {// 有价格
								var priceDiv = $(
										$($(this).children()[0]).children()[1])
										.children()[0];

								priceDiv.innerHTML = price + "元<BR/>";

								// 鼠标移上价格提示
								var price_title_txt = "成人价：<i><em>¥</em>"
										+ price + "</i><br/>";
								/* var price_title_txt = "成人价：<i><em>¥</em>"+price+"</i><br/>儿童占床价：<i><em>¥</em>"+price2+"</i><br/>儿童不占床价：<i><em>¥</em>"+price3+"</i><br/>老人价：<i><em>¥</em>"+price4+"</i>"; */
								if (price2 != 0) {
									price_title_txt += "老人价：<i><em>¥</em>"
											+ price2 + "</i><br/>";
								}
								if (price3 != 0) {
									price_title_txt += "儿童占床价：<i><em>¥</em>"
											+ price3 + "</i><br/>";
								}
								if (price4 != 0) {
									price_title_txt += "儿童不占床价：<i><em>¥</em>"
											+ price4 + "</i><br/>";
								}

								$(this).find(".hidden_price").html(
										price_title_txt);
								$(this).hover(function() {
									$(this).find(".hidden_price").show();
								}, function() {
									$(this).find(".hidden_price").hide();
								});

								// alert($(this).html());

								$(this)
										.click(
												function() {
													// alert('我有价格:'+_selectDate+","+price+"元,
													// 记得设置 日期,价格");
													// $("select[name='usedate']").val(_selectDate);
													// 设置value
													$("#usedate").val(
															_selectDate);

													// / alert
													// ($(".line_price")+"======"+$("li[v='"+_selectDate+"']").html());

													// 设置显示
													$(".line_price")
															.html(
																	$(
																			"li[v='"
																					+ _selectDate
																					+ "']")
																			.html());
													$(".line_price")
															.attr(
																	"title",
																	$(
																			"li[v='"
																					+ _selectDate
																					+ "']")
																			.attr(
																					"title"));

													var child_price = parseInt($(
															".line_price")
															.find(
																	".child_price")
															.html());
													var childnobed_price = parseInt($(
															".line_price")
															.find(
																	".childnobed_price")
															.html());
													var old_price = parseInt($(
															".line_price")
															.find(".old_price")
															.html());
													if (child_price == 0) {// 儿童占床价判断
														$("#childNums").attr(
																"disabled",
																"disabled")
																.css("opacity",
																		"0.5")
																.val("");
													} else {
														$("#childNums")
																.removeAttr(
																		"disabled")
																.css("opacity",
																		"1")
																.val("0");
													}
													if (childnobed_price == 0) {// 儿童不占床价判断
														$("#childnobedNums")
																.attr(
																		"disabled",
																		"disabled")
																.css("opacity",
																		"0.5")
																.val("");
													} else {
														$("#childnobedNums")
																.removeAttr(
																		"disabled")
																.css("opacity",
																		"1")
																.val("0");
													}
													if (old_price == 0) {// 老人价判断
														$("#oldNums").attr(
																"disabled",
																"disabled")
																.css("opacity",
																		"0.5")
																.val("");
													} else {
														$("#oldNums")
																.removeAttr(
																		"disabled")
																.css("opacity",
																		"1")
																.val("0");
													}
												});
							}
						}

					});

}

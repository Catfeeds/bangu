// JavaScript Document
var blank_arr = [6, 0, 1, 2, 3, 4, 5];
/**
 * 日历
 */
var MyCalendar = function(year, month, show_month_count) {
	this.start_year = year;
	this.start_month = month;
	this.show_month_count = show_month_count;
};
MyCalendar.prototype = {
	// 初始化日历
	init : function() {
		var nowDate = new Date();
		// 当前年
		var cur_year = nowDate.getFullYear();
		if (!this.start_year) {
			this.start_year = cur_year;
		}
		// 当前月
		var cur_month = nowDate.getMonth();
		if (!this.start_month) {
			this.start_month = cur_month;
		}
		if (!this.show_month_count) {
			this.show_month_count = 12;
		}
		// 当前日期
		var cur_date = nowDate.getDate();

		/**
		 * 一个月
		 */
		for (var j = 0; j < this.show_month_count; j++) {
			// 最后一天
			var last_date = new Date(this.start_year, this.start_month + 1, 0);				
			// 第一天
			var first_date = new Date(this.start_year, this.start_month, 1);
			var dayNum = last_date.getDate();
			// 第一天是星期几
			var first_day = first_date.getDay();
			// 最后一天是星期几
			var last_day = last_date.getDay();
			var title_month=this.start_month+1>9?this.start_month:"0"+this.start_month;
			var start_month=(this.start_month + 1);
				start_month=start_month>9?start_month:"0"+start_month;
			var tableEl = "<table>"
					+ "<thead><tr><td colspan=\"7\"><h5>"
					+ this.start_year
					+ "-<span class=\"qn_blue\">"
					+ start_month
					+ "</span></h5></td></tr></thead>"
					+ "<tbody>"
					+ "<tr class=\"weeks\"><th class=\"cal_price\">日</th><th>一</th><th>二</th><th>三</th><th>四</th><th class=\"weekend\">五</th><th class=\"cal_price\">六</th></tr>";
			// 空白
			var blank_day =first_day;
			var blank_day_back =last_day;
			var days = ["<tr class=\"days\">"];
			var index = 0;
			for (var a = 0; a < blank_day; a++) {
				days.push("<td class=\"null\"></td>");
				index++;
			}
			// 日期
			for (var i = 1; i <= dayNum; i++) {
				var mon = (this.start_month + 1) >= 10
						? this.start_month + 1
						: "0" + (this.start_month + 1);
				var date = i >= 10 ? i : "0" + i;
				var data_day = this.start_year + "-" + mon + "-" + date;

				var showDate = i;
				if (fmtDate(cur_date, "-") == data_day) {
					showDate = "今天";
				}
				days.push("<td class='active' data-day=\""
						+ data_day + "\">" + showDate + "</td>");			
				++index;
				if (index % 7 == 0) {
					days.push("</tr>");
					if (i != dayNum) {
						days.push("<tr class=\"days\">");
					}
				}
			}
			// 空白
			for (var b = 0; b < (6 - blank_day_back); b++) {
				days.push("<td class=\"null\"></td>");
			}
			if (blank_day_back != 6) {
				days.push("</tr>");
			}
			tableEl += days.join("") + "</tbody></table>";
			$(".cal_list").append(tableEl);
			this.start_month += 1;
			if(this.start_month==12){
				this.start_month = 0;
				this.start_year+=1;
			}
		}
	}
};

function fmtDate(d, symbol) {
	var rdate = null;
	if (!d || d.constructor != Date) {
		d = new Date();
	}
	var year = d.getFullYear();
	var month = d.getMonth() + 1;
	var date = d.getDate();
	month = month >= 10 ? month : "0" + month;
	date = date >= 10 ? date : "0" + date;
	if (!symbol) {
		return "" + year + month + date;
	} else {
		return year + symbol + month + symbol + date;
	}
}

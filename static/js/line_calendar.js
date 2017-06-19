/**
 *   深圳海外国际旅行社  刘金根   2015-06-05
 * 日历
 */
var MobCalendar = function(year, month, max) {
	this.start_year = year;
	this.start_month = month;
	this.show_month_max = max;
};
MobCalendar.prototype = {
	// 初始化日历
	init : function() {
		for (var j = 0; j < this.show_month_max; j++) {
			// 最后一天
			var last_date = new Date(this.start_year, this.start_month, 0);
			// 第一天
			var first_date = new Date(this.start_year, this.start_month-1, 1);
			
			//得到当前的最后是多少号，就说明这个月是多少天了；
			var dayNum = last_date.getDate();
			
			// 第一天是星期几
			var first_day = first_date.getDay();
	
			// 最后一天是星期几
			var last_day = last_date.getDay();
			var title_month=this.start_month>9?this.start_month:"0"+this.start_month;
			var tableEl = "<table>"
					+ "<thead><tr><td class=\"title_date\" colspan=\"7\">"
					+ this.start_year
					+ "年<span class=\"qn_blue\">"
					+ title_month
					+ "月</span></td></tr></thead>"
					+ "<tbody class=\"tbody\">"
					+ "<tr><th class=\"cal_price\">周日</th><th>周一</th><th>周二</th><th>周三</th><th>周四</th><th class=\"weekend\">周五</th><th class=\"cal_price\">周六</th></tr>";
			// 前一段空白
			var blank_day =first_day;
			
			var blank_day_back =last_day;
			var days = ["<tr class=\"days\">"];
			var index = 0;
			
			for (var a = 0; a < blank_day; a++) {
				days.push("<td class=\"null\"></td>");
				index++;
			}
			// 中间日期
			for (var i = 1; i <= dayNum; i++) {
				var mon =  this.start_month  >= 10
						? this.start_month
						: "0" + this.start_month ;
				var date = i >= 10 ? i : "0" + i;
				var data_day = this.start_year + "-" + mon + "-" + date;
				//
				var cls = "";

				var showDate = i;

				if (cls == ""||cls=="active") {
					days.push("<td \" class=\"" + cls
							+ "\" data-day=\"" + data_day + "\">" + showDate
							+ "</td>");
				} else {
					days.push("<td class=\"" + cls + "\" data-day=\""
							+ data_day + "\">" + showDate + "</td>");
				}
				++index;
				if (index % 7 == 0) {
					days.push("</tr>");
					if (i != dayNum) {
						days.push("<tr class=\"days\">");
					}
				}
			}
			// 后一段空白
			for (var b = 0; b < (6 - blank_day_back); b++) {
				days.push("<td class=\"null\"></td>");
			}
			if (blank_day_back != 6) {
				days.push("</tr>");
			}
			
			tableEl += days.join("") + "</tbody></table>";
			$(".cal_list").append(tableEl);
			
			this.start_month++;
			if(this.start_month>12){
				this.start_year=+this.start_year+1;
				this.start_month=1
			}
		}	
	}
};


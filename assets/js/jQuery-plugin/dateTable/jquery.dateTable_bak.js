;
jQuery.priceDate = function(settings) {
	jQuery.extend(this, settings);
	$this = this;
	this.loadData();
};
jQuery.priceDate.prototype = {
	table : null,
	day : 0,
	head : null,
	renderTo : 'body',
	monthTabLen : 6,//一共显示几个TAB 从当月开始
	monthTabChange : function(obj,date){ },//单机切换TAB
	comparableField : null,
	params : null,
	url : null,
	record:[],
	month_arr:[],//月TAB
	calendar_arr:[],//月日历
	dayFormatter : function(){},
	dateToString : function(date){
		return date.getFullYear()+'-'+((date.getMonth()+1)<10?("0"+(date.getMonth()+1)):(date.getMonth()+1))+'-'+(date.getDate()<10?("0"+date.getDate()):date.getDate());
	},
	comparable : function(comparableDateStr){
		if( this.record ){
			var data = null;
			for(var i=0;i<this.record.length;i++)
			{
				data = this.record[i];
				if(data && data[this.comparableField]==comparableDateStr){
					return data;
				}
			}
		}
		return null;
	},
	initHead : function (now){
		$this = this;
		this.renderTo = jQuery(this.renderTo);
		this.renderTo.html('');
		jQuery('<div id="headContent" class="tabs" style="position: relative;"><ul class="headList"></ul> </div>').appendTo( this.renderTo )
		this.head = jQuery(".headList",this.renderTo);
		var month = now.getMonth()+1;
		var day = now.getDate();
		var cDate='';
		var monthTabHTML = '';
		var addDate = null;
		
		for(var k=0;k<this.monthTabLen;k++){
			addDate = new Date(now.getFullYear(),(now.getMonth() + k) ,1);
			month = addDate.getMonth()+1;
			cDate = addDate.getFullYear()  +'-'+ (month>=10 ? month : "0"+month) + '-'+ (addDate.getDate()>10 ? addDate.getDate() : "0"+addDate.getDate()); 
			this.month_arr[k] = jQuery('<li data="'+cDate+'" class="monthTab"><a href="###"  >'+addDate.getFullYear()+'年'+(month>=10 ? month : "0"+month)+'月</a></li>').appendTo(this.head);
			$this.initDate(cDate,k);
		}
		jQuery(this.head).on("click",".monthTab",function(){//事件绑定
			var index = jQuery(this).index();
			$this.active(index);
		});
//		var d_date = new Date();
//		var d_month = d_date.getMonth()+1;
//		var defaultDate = ( d_date.getFullYear()  +'-'+ (d_month>=10 ? d_month : "0"+d_month) + '-01');
//		$this.initDate(defaultDate);
	},
	active:function(index){
		jQuery(".monthTab", this.head).removeClass("on");
		this.month_arr[index].addClass("on");
		var currentMonth = jQuery(this).attr('data') ; 
		//回调tab点击事件
		if(this.monthTabChange){
			this.monthTabChange(this,currentMonth);	
		}
		var cal_len = this.calendar_arr.length;
		for(var i=0;i<cal_len;i++){
			this.calendar_arr[i].hide();
		}
		this.calendar_arr[index].show();
	},
	initDate : function(currentMonth,i){
		var param = '';
		$this = this;
		if(jQuery.isFunction($this.params)){
			param = this.params();
		}else{
			param = this.params;
		}
		this.table = jQuery('<table border="0" cellspacing="0" width="950" cellpadding="0" class="priceDate" id="'+currentMonth+'" style="display: none;"></table> ').appendTo( this.renderTo );
		this.calendar_arr[i] = this.table;
		$this.createTable(this.calendar_arr[i],stringToDate(currentMonth),this.record);	
	},
	loadData:function(){
		var param = '';
		$this = this;
		if(jQuery.isFunction($this.params)){
			param = this.params();
		}else{
			param = this.params;
		}
		jQuery.ajax({ type : "POST",data :param,url : this.url, 
			success : function(rs) {
				$this.record = jQuery.parseJSON( rs );
				$this.initHead(new Date());
				$this.active(0);
			}
		});
	},
	initFirstRow : function(fullCount,emptyCount,now){
		this.tr = "<tr>";
		for(var i=0;i<emptyCount;i++){
			this.tr += "<td></td>";
		}
		var tempWeek = emptyCount+1;
		for(var i=0;i<fullCount;i++){
			this.tr += this.setContent(now,tempWeek,true,false);
			tempWeek++;
		}
		this.tr += "</tr>";
		return this.tr;
	},
	initCenterRow : function(row,now){
		this.tr = "";
		for(var i=0;i<row;i++){
			this.tr+="<tr>";
			for(var j=0;j<7;j++){
				this.tr += this.setContent(now,j+1,false,false);
			}
			this.tr+="</tr>";
		}
		return this.tr;
	},
	initLastRow : function(fullCount,emptyCount,now){
		this.tr = "<tr>";
		for(var i=0;i<fullCount;i++)
		{
			this.tr += this.setContent(now,i+1,false,true);
		}
		for(var i=0;i<emptyCount;i++) { this.tr += "<td></td>"; }
		this.tr += "</tr>";
		return this.tr;
	},
	setContent : function(currentDate,currentWeek,isFirstRow,isLastRow){
		this.day++;
		var day = ( this.day<10 ? '0'+this.day : this.day );
		var month = currentDate.getMonth()+1;
		var dateStr = currentDate.getFullYear()+"-"+( month<10 ? '0'+month : month )+"-"+(day);
		var currentDate = stringToDate( dateStr );
		var now = new Date();
		var disabled = currentDate.getTime() < now.getTime();
		var content =  '<td id="td_'+(currentDate.getMonth()+1)+day+'" ';
		content = content + ( disabled ? ' class="disable" ' : '' );
		var tablSettings = {"day":day,"date":dateStr,"disabled":disabled,"isLastRow":isLastRow,"isFirstRow":isFirstRow};
		content = content + '>' + ( this.dayFormatter ? this.dayFormatter(tablSettings,this.comparable(dateStr)) : "" ) + '</td>';
		return content;
	},
	getTheMonthDays : function (date){//当月天数
		return this.getTheMonthLastDate(date).getDate();
	},
	getTheMonthLastDayWeek : function (date){//当月最后一天星期
	
		return this.getTheMonthLastDate(date).getDay();
	},
	getTheMonthLastDate : function (date){//当月最后一天时间
		year = date.getFullYear();
		month = date.getMonth()+1;
		if(month>12){
			year++;
			month-=12;
		}
		return new Date(year,month,0);
	},
	getTheMonthFirstDayWeek : function (date)//当月第一天星期
	{
		return this.getTheMonthFirstDate(date).getDay();
	},
	getTheMonthFirstDate : function (date){//当月第一天时间
		year = date.getFullYear();
		month = date.getMonth();
		return new Date(year,month,1);
	},
	createTable : function (table,now,rs){
		if(rs){
			this.record = rs;	
		}
		this.day =0;
		var html='<tr><th>星期日</th><th>星期一</th><th>星期二</th><th>星期三</th><th>星期四</th><th>星期五</th><th>星期六</th></tr>';
		$this = this;
		days = $this.getTheMonthDays(now);
		year = now.getFullYear();
		month = now.getMonth()+1;
		day = now.getDate();
		week = $this.getTheMonthFirstDayWeek(now);//第一行
		switch(week){
			case 1:
				html += $this.initFirstRow(6, 1, now);
				break;
			case 2:
				html += $this.initFirstRow(5, 2, now);
				break;
			case 3:
				html += $this.initFirstRow(4, 3, now);
				break;
			case 4:
				html += $this.initFirstRow(3, 4, now);
				break;
			case 5:
				html += $this.initFirstRow(2, 5, now);
				break;
			case 6:
				html += $this.initFirstRow(1, 6, now);
				break;
			case 0:
				html += $this.initFirstRow(7, 0, now);
				break;
			default:
				return;
		}
		html += $this.initCenterRow( Math.ceil(days + week)/7-2 ,now);//中间行
		week = $this.getTheMonthLastDayWeek(now);//结束行
		if(this.day<days){
			switch(week){
			case 0:
				html += $this.initLastRow(1, 6, now);
				break;
			case 1:
				html += $this.initLastRow(2, 5, now);
				break;
			case 2:
				html += $this.initLastRow(3, 4, now);
				break;
			case 3:
				html += $this.initLastRow(4, 3, now);
				break;
			case 4:
				html += $this.initLastRow(5, 2, now);
				break;
			case 5:
				html += $this.initLastRow(6, 1, now);
				break;
			case 6:
				html += $this.initLastRow(7, 0, now);
				break;
			
			default:
				return;
		}
		}
		table.html(html);
	}
}


function stringToDate(string) {
    var f = string.split(' ', 2);
    var d = (f[0] ? f[0] : '').split('-', 3);
    var t = (f[1] ? f[1] : '').split(':', 3);
    return (new Date(
    parseInt(d[0], 10) || null,
    (parseInt(d[1], 10) || 1) - 1,
	parseInt(d[2], 10) || null,
	parseInt(t[0], 10) || null,
	parseInt(t[1], 10) || null,
	parseInt(t[2], 10) || null
	));
}

function colCopy(obj)
{
//	var objText = $(obj).prev();
//	var val = objText.val();
	var cell = $(obj).closest('td');
	
	var cellIndex = cell[0].cellIndex+1;
	
	var cureentRow = cell.closest('tr');
	var cureentRowIndex = cureentRow[0].rowIndex;
	
	var table = cell.closest('table');
	var len = table.find("tr").length;
	
	var number = jQuery("input[name='number[]']",cell).val();
	var refprice = jQuery("input[name='refprice[]']",cell).val();
	var childnobedprice = jQuery("input[name='childnobedprice[]']",cell).val();
	var oldprice = jQuery("input[name='oldprice[]']",cell).val();
	var adultprice = jQuery("input[name='adultprice[]']",cell).val();
	var childprice = jQuery("input[name='childprice[]']",cell).val();
	
	console.log("number = "+number);
	
	table.find("td:nth-child("+cellIndex+")").each(function(i){
		if(i>=cureentRowIndex)
		{
			jQuery(this).find("input[name='number[]']").val(number);
			jQuery(this).find("input[name='refprice[]']").val(refprice);
			jQuery(this).find("input[name='childnobedprice[]']").val(childnobedprice);
			jQuery(this).find("input[name='oldprice[]']").val(oldprice);
			jQuery(this).find("input[name='adultprice[]']").val(adultprice);
			jQuery(this).find("input[name='childprice[]']").val(childprice);
		}
	});
}

function getCopyDown(isLastRow){
	return  isLastRow ? '&nbsp;&nbsp;&nbsp;' :'<a href="###" class="cpdown" title="向下复制" onclick="colCopy(this)">&nbsp;</a>' ;
}




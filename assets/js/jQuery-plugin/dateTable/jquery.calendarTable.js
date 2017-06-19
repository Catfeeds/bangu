jQuery.calendarTable = function(settings) {
	jQuery.extend(this, settings);
	$this = this;
	this.loadData();
	this.initEvent();
};

var initElementId=0;
jQuery.calendarTable.prototype = {
	table : null,
	day : 0,
	head : null,
	renderTo : 'body',
	defaultTabName:"套餐名称",
	monthTabLen : 7,//一共显示几个TAB 从当月开始
	monthTabChange : function(obj,date){ },//单机切换TAB
	comparableField : null,
	params : null,
	url : null,
	activeIndex:0,//选中的TAB
	count:0,//TAB数量
	record:[],//[{"tabId":"","tabName":'',"unit":''}]
	values:[],
	calendar_arr:[],//月日历
	dayFormatter : function(){},
	loadData:function(){
		var param = '';
		$this = this;
		if(jQuery.isFunction($this.params)){
			param = this.params();
		}else{
			param = this.params;
		}
		var selectedTab = jQuery('.package-name-manager .selected',this.renderTo);;
		this.activeIndex= selectedTab.index()<0?0:selectedTab.index(); 
		this.count=0;
		initElementId=0;
		
		jQuery.ajax({ type : "POST",data :param,url : this.url, 
			success : function(rs) {
				$this.values = [];
				$this.record = jQuery.parseJSON(rs);
				$this.initTab( $this.record );
			}
		});
	},
	initTab:function(data){
		jQuery(this.renderTo).html('');
		this.tab_container = jQuery('<div class="package-name-manager" ></div>').appendTo( this.renderTo );
		if(!data){
			data = [];
		}
		if(data.length==0){
			data[0] = {"tabId":0,"tabName":'标准价',"unit":1};
		}
		this.addTabBtn = jQuery('<span class="add-package" title="如：2大1小套餐，海景仓套餐" >添加新套餐</span>').appendTo(this.tab_container);
		for(var i=0;i<data.length;i++){
			this.addTab(data[i]);
		}
		var selectedTab = jQuery('.package-name-manager .selected',this.renderTo);
		this.activeTab(selectedTab);
	},addTab:function(tabData){
		var len = $(".package-tab",this.renderTo).length;	
		var isActive = this.count==this.activeIndex;
		//新增
		if(!tabData){
			tabData = {"tabId":"0","tabName":"","unit":"1","data":{}};
			this.record[initElementId] = tabData;
		}
		var tabHtml = '<span class="package-tab'+(isActive?" selected":"")+'" tabindex="'+initElementId+'" ><strong >'+(tabData && tabData.tabName?tabData.tabName:this.defaultTabName)+'</strong><em class="del-package" data-val="'+(tabData && tabData.tabId?tabData.tabId:'')+'" style="display: none;"></em></span>';
		this.initTabbody( tabData,initElementId );//初始化内容
		this.count++;
		initElementId++;
		var addTabBtn = jQuery('.add-package',this.renderTo);
		addTabBtn.before(tabHtml);
	},
	initTabbody:function(tabData,index){
		var tab_body = jQuery('<div class="package-con" id="tab_body'+index+'" style="display:none;"></div>').appendTo( this.renderTo );
		tab_body.index = index;
		tab_body.tabId = tabData.tabId;
		tab_body.tabName = tabData.tabName;
		tab_body.data = tabData.data;
		tab_body.unit = tabData.unit;
		var html='<div class="package-name-edit"><ul class="form-list"><li>';
		if(this.count>0){
			html+='<div class="form-label"><label for=""><i>&nbsp;</i>套餐名称：</label><i class="required">*</i></div>';
			html+='<div class="col-lg-2" style="width: 210px; float:left;">';
			html+='<input type="text" class="input-text" placeholder="套餐名称" value="'+(tabData && tabData.tabName?tabData.tabName:"")+'" name="suitName" id="suitName" maxlength="24">';
    		html+='<input type="hidden" name="suitId" id="suitId" value="'+(tabData && tabData.tabId?tabData.tabId:"")+'">';
			html+='</div>';
			html+='<div class="form-label" style="margin-left:18px;"><i class="required" style="right:103px;">*</i><input type="text" class="input-text uint2" style="width:30px;text-align:center;padding-right:5px;" name="unit" value="'+(tabData && tabData.unit?tabData.unit:1)+'"><span>人/份</span></div>';
			html+='<div class="form-label" style="margin-left:18px;"><a id="onPrice" onclick="onPrice(this,1)" style="padding: 4px 12px;" class="btn">批量录入价格</a></div>';
			html+='<div class="form-label" style="width:52px;margin-left: 18px;"><a id="clearPrice" onclick="clearPrice(this)"  style="padding: 4px 12px;" class="btn">清空</a></div>';
		}else{
			if(tabData.tabName=='标准价'){
				html+='<input type="hidden" name="suitId" id="suitId" value="'+(tabData && tabData.tabId?tabData.tabId:"")+'">';
				html+='<div class="form-label" style="margin-left:18px;"><a id="onPrice" onclick="onPrice(this,0)" style="padding: 4px 12px;" class="btn">批量录入价格</a></div>';
				html+='<div class="form-label" style="width:52px;margin-left: 18px;"><a id="clearPrice"  onclick="clearPrice(this)"  style="padding: 4px 12px;" class="btn">清空</a></div>';
				html+='<div class="form-label" style="margin-left: 18px;"><input type="text" name="unit" style="background: #f5f5f5;border: 0px;width:30px;" class="input-text uint2" value="'+(tabData && tabData.unit?tabData.unit:1)+'"><span>人/份</span></div>';	
			}else{
				html+='<div class="form-label"><label for=""><i>&nbsp;</i>套餐名称：</label><i class="required">*</i></div>';
				html+='<div class="col-lg-2" style="width: 210px; float:left;">';
				html+='<input type="text" class="input-text" placeholder="套餐名称" value="'+(tabData && tabData.tabName?tabData.tabName:"")+'" name="suitName" id="suitName" maxlength="24">';
	    		html+='<input type="hidden" name="suitId" id="suitId" value="'+(tabData && tabData.tabId?tabData.tabId:"")+'">';
				html+='</div>';
				html+='<div class="form-label" style="margin-left:18px;"><i class="required" style="right:103px;">*</i><input type="text" class="input-text uint2" style="width:30px;text-align:center;padding-right:5px;" name="unit" value="'+(tabData && tabData.unit?tabData.unit:1)+'"><span>人/份</span></div>';
				html+='<div class="form-label" style="margin-left:18px;"><a id="onPrice" onclick="onPrice(this,1)" style="padding: 4px 12px;" class="btn">批量录入价格</a></div>';
				html+='<div class="form-label" style="width:52px;margin-left: 18px;"><a id="clearPrice" onclick="clearPrice(this)"  style="padding: 4px 12px;" class="btn">清空</a></div>';
			}
		}
		html+='</li></ul></div>';
		tab_body.append(html);
		this.bindUnit(tab_body,index);
		this.initCal(tab_body,new Date());
	},
	delTab:function(tab){
		if(this.count>1){
			var tabindex = tab.attr('tabindex');
			var prev_tab = tab.prev();
			this.record.splice( tab.index() ,1);//删除数据
			tab.remove();//删除TAB
			jQuery("#tab_body"+tabindex).remove();//删除TAB内容
			this.activeTab(prev_tab);//选中前面一个
			this.count--;
		}
	},
	activeTab:function(selectedTab,calIndex){
		//获取其他套餐TAB
		jQuery('.package-tab',this.renderTo).each(function(index){
			var tab = jQuery(this);
			if(tab.hasClass('selected')){
				tab.removeClass('selected');//隐藏原来的
				jQuery("#tab_body"+tab.attr('tabindex')).hide();//隐藏原来的
			}
		});
		selectedTab.addClass('selected');//当前TAB选中
		var tabindex = selectedTab.attr('tabindex')
		this.activeIndex = tabindex;//selectedTab.index();
		//TAB相关的BODY显示
		var activeTabName = "#tab_body"+tabindex;
		var tab_body = jQuery(activeTabName);
		tab_body.show();
		this.activeCalTab(tab_body,calIndex?calIndex:0);
	},
	activeCalTab:function(tab,selectIndex){
		var monthTab_arr = jQuery(".monthTab", tab);
		var priceDate_arr = jQuery(".layoutfix", tab);
		
		var now=new Date();
		addDate = new Date(now.getFullYear(),(now.getMonth() + selectIndex) ,1);
		$('.cal-year').html(addDate.getFullYear()+'年');

		monthTab_arr.each(function(index){
			var date_tab = jQuery(this);
			if(selectIndex!=index){
				if(date_tab.hasClass('on')){
					date_tab.removeClass("on");
					jQuery(priceDate_arr[index]).hide();
				}
			}else{
				if(!date_tab.hasClass('on')){
					date_tab.addClass("on");
					var priceDate = jQuery(priceDate_arr[index]);//.parent('.layoutfix');
					priceDate.show();
				}
			}
		});
	},
	initDate : function(tab_body,layoutfix,reserve_record,currentMonth,index){
		var param = '';
		$this = this;
		if(jQuery.isFunction($this.params)){
			param = this.params();
		}else{
			param = this.params;
		}
		var table = jQuery('<table border="0" cellspacing="0" width="1000" cellpadding="0" class="priceDate reserve_table" id="'+currentMonth+'" ></table>').appendTo( layoutfix );
		var calendar_arr = new Array();
		calendar_arr[index] = table;
		tab_body.layoutfix = layoutfix;
		$this.createTable(tab_body,reserve_record,calendar_arr[index],stringToDate(currentMonth),tab_body.data);	
	},
	createTable : function (tabbody,reserve_record,table,now,rs){
		this.day =0;
		var html='<tr><th>星期日</th><th>星期一</th><th>星期二</th><th>星期三</th><th>星期四</th><th>星期五</th><th>星期六</th></tr>';
		
		
		$this = this;
		days = $this.getTheMonthDays(now);
		year = now.getFullYear();
		month = now.getMonth()+1;
		day = now.getDate();
//		$('<dl><dt></dt><dd title="成人价格">成人价格</dd><dd title="儿童占床价">儿童占床价</dd><dd title="儿童不占床价">儿童不占床价</dd><dd title="单房差">单人数补房差</dd><dd class="bg_yellow balance">余位</dd><dd class="bg_yellow borders balance">提前截止收客</dd></dl>').appendTo(reserve_record);
		week = $this.getTheMonthFirstDayWeek(now);//第一行
		var center = Math.ceil(days + week)/7-2;
		for(var i=0;i<center+1;i++){
			$('<dl><dt></dt><dd title="成人价格">成人价格</dd><dd title="儿童占床价">儿童占床价</dd><dd title="儿童不占床价">儿童不占床价</dd><dd class="bg_yellow balance">余位</dd><dd title="单房差">单人数补房差</dd><dd class="bg_yellow borders balance">提前截止收客</dd></dl>').appendTo(reserve_record);
		}
		switch(week){
			case 1:
				html += $this.initFirstRow(6, 1, now,tabbody);
				break;
			case 2:
				html += $this.initFirstRow(5, 2, now,tabbody);
				break;
			case 3:
				html += $this.initFirstRow(4, 3, now,tabbody);
				break;
			case 4:
				html += $this.initFirstRow(3, 4, now,tabbody);
				break;
			case 5:
				html += $this.initFirstRow(2, 5, now,tabbody);
				break;
			case 6:
				html += $this.initFirstRow(1, 6, now,tabbody);
				break;
			case 0:
				html += $this.initFirstRow(7, 0, now,tabbody);
				break;
			default:
				return;
		}
		
		html += $this.initCenterRow(center,now,tabbody);//中间行
		week = $this.getTheMonthLastDayWeek(now);//结束行
		
		if(this.day<days){
			switch(week){
			case 0:
				html += $this.initLastRow(1, 6, now,tabbody);
				break;
			case 1:
				html += $this.initLastRow(2, 5, now,tabbody);
				break;
			case 2:
				html += $this.initLastRow(3, 4, now,tabbody);
				break;
			case 3:
				html += $this.initLastRow(4, 3, now,tabbody);
				break;
			case 4:
				html += $this.initLastRow(5, 2, now,tabbody);
				break;
			case 5:
				html += $this.initLastRow(6, 1, now,tabbody);
				break;
			case 6:
				html += $this.initLastRow(7, 0, now,tabbody);
				break;
			
			default:
				return;
		}
		}
		table.html(html);
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
	getTheMonthFirstDayWeek : function (date){
		return this.getTheMonthFirstDate(date).getDay();
	},
	getTheMonthFirstDate : function (date){//当月第一天时间
		year = date.getFullYear();
		month = date.getMonth();
		return new Date(year,month,1);
	},
	initFirstRow : function(fullCount,emptyCount,now,tabbody){
		this.tr = "<tr>";
		for(var i=0;i<emptyCount;i++){
			this.tr += '<td><p class="bg_blue"><i></i></p><p class="singleRow"></p><p class="singleRow"></p><p class="singleRow"></p><p class="singleRow"></p><p class="singleRow"></p></td>';
		}
		var tempWeek = emptyCount+1;
		for(var i=0;i<fullCount;i++){
			this.tr += this.setContent(now,tempWeek,true,false,tabbody);
			tempWeek++;
		}
		this.tr += "</tr>";
		return this.tr;
	},
	initCenterRow : function(row,now,tabbody){
		this.tr = "";
		for(var i=0;i<row;i++){
			this.tr+="<tr>";
			for(var j=0;j<7;j++){
				this.tr += this.setContent(now,j+1,false,false,tabbody);
			}
			this.tr+="</tr>";
		}
		return this.tr;
	},
	initLastRow : function(fullCount,emptyCount,now,tabbody){
		this.tr = "<tr>";
		for(var i=0;i<fullCount;i++)
		{
			this.tr += this.setContent(now,i+1,false,true,tabbody);
		}
		for(var i=0;i<emptyCount;i++) { this.tr += "<td></td>"; }
		this.tr += "</tr>";
		return this.tr;
	},
	setContent : function(currentDate,currentWeek,isFirstRow,isLastRow,tabbody){
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
		var rowData = null;
		var tab_data = tabbody.data;
		if(tab_data){
			rowData = tab_data[dateStr];
		}
		var unit = jQuery('input[name="unit"]',tabbody).val();
		var callback = unit>1 ? ( this.dayFormatter1 ? this.dayFormatter1(tablSettings,rowData) : "" ) : ( this.dayFormatter ? this.dayFormatter(tablSettings,rowData) : "" )
		content = content + '><p class="bg_blue" ><i>'+( month<10 ? '0'+month : month )+"-"+(day)+'</i> '+getCopyDown(isLastRow)+'</p>' + callback + '</td>';
		return content;
	},
	getValues:function(){
		
		return this.values;
	},
	initCal: function (tab_body,now){
		$this = this;
		var priceCal = jQuery('<div class="price-cal" id="price-cal"></div>').appendTo( tab_body );
		
		jQuery('<div id="headContent" class="tabs" style="position: relative;">'+'<div data="'+cDate+'" class="cal-year" >'+now.getFullYear()+'年</div>'+'<ul class="headList"></ul> </div>').appendTo( priceCal );
		var headList = jQuery(".headList",tab_body);
		var month = now.getMonth()+1;
		var day = now.getDate();
		var cDate='';
		var monthTabHTML = '';
		var addDate = null;
		for(var k=0;k<this.monthTabLen;k++){
			addDate = new Date(now.getFullYear(),(now.getMonth() + k) ,1);
			month = addDate.getMonth()+1;
			cDate = addDate.getFullYear()  +'-'+ (month>=10 ? month : "0"+month) + '-'+ (addDate.getDate()>10 ? addDate.getDate() : "0"+addDate.getDate()); 
			jQuery('<li data="'+cDate+'" class="monthTab "><a href="###"  >'+(month>=10 ? month : "0"+month)+'月</a></li>').appendTo(headList);
			var layoutfix = $('<div class="layoutfix" style="display:none;"></div>').appendTo( tab_body );
			var reserve_record = $('<div class="reserve_record"></div>').appendTo( layoutfix );
			$('<dl><dt class="month"><span>'+month+'</span>月</dt><dd title="成人价格">成人价格</dd><dd title="儿童占床价">儿童占床价</dd><dd title="儿童不占床价">儿童不占床价</dd><dd class="bg_yellow balance">余位</dd><dd title="单房差">单人数补房差</dd><dd class="bg_yellow borders balance">提前截止收客</dd></dl>').appendTo(reserve_record);
			$this.initDate(tab_body,layoutfix,reserve_record,cDate,k);
		}
		jQuery(tab_body).on("click",".monthTab",function(){//事件绑定
			var index = jQuery(this).index();
			var cal_year = $('.cal-year');
			var date = cal_year.attr('data');
			cal_year.html(date.split('-')[0]+'年');
			$this.activeCalTab(tab_body,index);
		});
		this.activeCalTab(tab_body,0);
        
	},
	bindInputEvent:function(){
		var me = this;
		jQuery(this.renderTo).on("change",'.price',function(){
			 var parent = jQuery(this).parents('td');
			 var index = me.activeIndex;
			 //初始化
			 if(!me.values[index]){
				 me.values[index] = {"tabId":me.record[index]?me.record[index].tabId:0,"data":{}};
			 }
			 if(!me.values[index].data){
				 me.values[index].data = {};
			 }
			 if(!me.record[index].data){
				 me.record[index].data = {};
			 }
			 var objs = parent.find('input');
			 var obj = {};
			 var key = '';
			 objs.each(function(index){
				 var o = jQuery(this);
				 if(o.hasClass('day')){
					 key =  o.val();
				 }
				 obj[o.attr('name')] = o.val()
			 });
			 me.record[index].data[key] = obj;
			 me.values[index].data[key] = obj;
		});
	},
	bindUnit:function(tab_body,index){//单位变化 其他跟着变化
		var me = this;
		//单位发生变化      重置日历 
		jQuery(tab_body).on("change",'input[name="unit"]',function(){

			jQuery('.layoutfix',tab_body).remove();
			jQuery('.price-cal',tab_body).remove();
			me.initCal(tab_body,new Date());//重置
			//初始化
			if(!me.values[tab_body.index]){
				 me.values[tab_body.index] = {};
			}

			me.values[tab_body.index]['tabId'] = tab_body.tabId;
			me.values[tab_body.index]['unit'] = jQuery(this).val();
			me.record[tab_body.index]['unit'] = jQuery(this).val();
		});
				 
		//名字变化
		jQuery(tab_body).on("change",'input[name="suitName"]',function(){
			//初始化
			if(!me.values[tab_body.index]){
				 me.values[tab_body.index] = {};
			}
			me.values[tab_body.index]['tabName'] = jQuery(this).val();
			me.values[tab_body.index]['tabId'] = tab_body.tabId;
			me.record[tab_body.index]['tabName'] = jQuery(this).val();
			$('.package-name-manager .selected strong').html(jQuery(this).val());
		});
		//第一个 绑定到标准价
		if(tab_body.index==0){
			jQuery('#unit').change(function(){
				var unit_val = jQuery(this).val();
				//初始化
				if(!me.values[tab_body.index]){
					 me.values[tab_body.index] = {};
				}
				me.values[tab_body.index]['tabId'] = tab_body.tabId;
				me.values[tab_body.index]['tabName'] = '标准价';
				jQuery('.priceDate',tab_body).remove();
				jQuery('.price-cal',tab_body).remove();
				me.initCal(tab_body,new Date());
			});
		}
	},
	initEvent:function(){
		//添加新套餐
		var me = this;
		jQuery(this.renderTo).on("click",'.add-package',function(){		
				me.addTab();
		});
		//tab套餐切换
		jQuery(this.renderTo).on("click",'.package-tab',function(){
			var tab = jQuery(this);
			me.activeTab(tab);
		});
		//套餐TAB移入 移除事件
		jQuery(this.renderTo).on("mouseenter mouseleave",".package-tab",function(event){
				var tab = jQuery(this);
			    if( event.type == "mouseenter"){
			    	 jQuery(".del-package",tab).show();
			    }else if(event.type == "mouseleave" ){
			    	jQuery(".del-package",tab).hide();
			    }           
		});
		this.bindInputEvent();
		//删除套餐
		jQuery(this.renderTo).on("click",'.del-package',function(){
			 if(confirm("确定要删除该套餐？")) {
				me.delTab(jQuery(this).parent());
				var suitId=$(this).attr('data-val');		
                if(suitId>0){
		    		//删除数据库的套餐  "suitId="+suitId+'&lineId=<?php echo $data['id'];?>' <?php echo base_url()?>admin/b1/product/deleteSuit
			    	jQuery.ajax({ type : "POST",data :"suitId="+suitId,url : "/admin/b1/product/deleteSuit",
						success : function(response) {
							if(response){
								alert('删除成功！');
								 priceDate.loadData();
							}else{
								alert('删除失败！');
							   priceDate.loadData();
							}
						}
					});
                }
		     }else{
	        	
		     }
			 return false;
		});
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
;JSON.stringify = JSON.stringify || function (obj) {
    var t = typeof (obj);
    if (t != "object" || obj === null) {
        // simple data type
        if (t == "string") obj = '"'+obj+'"';
        return String(obj);
    }
    else {
        // recurse array or object
        var n, v, json = [], arr = (obj && obj.constructor == Array);
        for (n in obj) {
            v = obj[n]; t = typeof(v);
            if (t == "string") v = '"'+v+'"';
            else if (t == "object" && v !== null) v = JSON.stringify(v);
            json.push((arr ? "" : '"' + n + '":') + String(v));
        }
        return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
};


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
	
	var number = jQuery("input[name='number']",cell).val();
	var refprice = jQuery("input[name='refprice']",cell).val();
	var childnobedprice = jQuery("input[name='childnobedprice']",cell).val();
	var adultprice = jQuery("input[name='adultprice']",cell).val();
	var childprice = jQuery("input[name='childprice']",cell).val();
	var before_day= jQuery("input[name='before_day']",cell).val();
	var hour= jQuery("input[name='hour']",cell).val();
	var minute= jQuery("input[name='minute']",cell).val();
	var agent_rate_int= jQuery("input[name='agent_rate_int']",cell).val();
	var agent_rate_child= jQuery("input[name='agent_rate_child']",cell).val();
	var agent_rate_childno= jQuery("input[name='agent_rate_childno']",cell).val();
	var room_fee= jQuery("input[name='room_fee']",cell).val();
	var agent_room_fee= jQuery("input[name='agent_room_fee']",cell).val();
	table.find("td:nth-child("+cellIndex+")").each(function(i){
		if(i>=cureentRowIndex){
			var number_obj = jQuery(this).find("input[name='number']");
			number_obj.val(number);
			var refprice_obj = jQuery(this).find("input[name='refprice']");
			refprice_obj.val(refprice);
			
			var childnobedprice_obj = jQuery(this).find("input[name='childnobedprice']");
			childnobedprice_obj.val(childnobedprice);
			
			/*var oldprice_obj = jQuery(this).find("input[name='oldprice']");
			oldprice_obj.val(oldprice);*/
			
			var adultprice_obj = jQuery(this).find("input[name='adultprice']");
			adultprice_obj.val(adultprice);
			
			var childprice_obj = jQuery(this).find("input[name='childprice']");
			childprice_obj.val(childprice);
			
			var before_day_obj = jQuery(this).find("input[name='before_day']");
			before_day_obj.val(before_day);

			var hour_obj = jQuery(this).find("input[name='hour']");
			hour_obj.val(hour);

			var minute_obj = jQuery(this).find("input[name='minute']");
			minute_obj.val(minute);

			var agent_rate_int_obj = jQuery(this).find("input[name='agent_rate_int']");
			agent_rate_int_obj.val(agent_rate_int);

			var agent_rate_child_obj = jQuery(this).find("input[name='agent_rate_child']");
			agent_rate_child_obj.val(agent_rate_child);

			var agent_rate_childno_obj = jQuery(this).find("input[name='agent_rate_childno']");
			agent_rate_childno_obj.val(agent_rate_childno);


			var room_fee_obj = jQuery(this).find("input[name='room_fee']");
			room_fee_obj.val(room_fee);


			var agent_room_fee_obj = jQuery(this).find("input[name='agent_room_fee']");
			agent_room_fee_obj.val(agent_room_fee);

			number_obj.trigger("change");
			refprice_obj.trigger("change");
			childnobedprice_obj.trigger("change");
			//oldprice_obj.trigger("change");
			adultprice_obj.trigger("change");
			childprice_obj.trigger("change");
			before_day_obj.trigger("change");
			hour_obj.trigger("change");
			minute_obj.trigger("change");
			agent_rate_int_obj.trigger("change");
			agent_rate_child_obj.trigger("change");
			agent_rate_childno_obj.trigger("change");
			room_fee_obj.trigger("change");
			agent_room_fee_obj.trigger("change");
		}
	});
}
function fireEvent(obj){
	if("createEvent" in document) {
	    var evt = document.createEvent("HTMLEvents");
	    evt.initEvent("change", false, true);
	    obj.dispatchEvent(evt);
	}
	else{
		obj.fireEvent("onchange");
	}
}

function getCopyDown(isLastRow){
	return  isLastRow ? '&nbsp;&nbsp;&nbsp;' :'<a href="###" class="cpdown" title="向下复制" onclick="colCopy(this)">&nbsp;</a>' ;
}
(function($) {
	$.fn.page = function(options) {
		pageParam = $.extend($.fn.page.defaults,options);
		pagePluginObj = $(this);
		pageParam.fieldlen = pageParam.columns.length;
		//生成table框架
		createTable();
		createThead();
		//获取数据
		getAjaxJson();
		//条件搜索
		if (pageParam.isFormSubmit == false) {
			conditionSearch();
		} else {
			pageParam.isFormSubmit = true;
		}
	};
	$.fn.page.defaults = {
			pageSize:10,//每页条数
			pageNumNow:1,//当前页
			pageCount:0,//总页数
			countNums:0,//记录总数
			pageShowNum:8,//显示的分页按钮数
			pageBoxClass:"page-button", //分页的class名称
			columns:{},
			fieldlen:0,//显示条数数量
			searchForm:"#form",//数据搜索条件的form元素ID（#form）
			isFormSubmit:false,
			url:"",//数据请求地址
			className:{
				tableClass:"table table-striped table-hover table-bordered dataTable no-footer",//table元素的class名称
				theadClass:"",
				tbodyClass:"",
			},
	};
	//生成分页html
	function createPageHtml() {
		if(pagePluginObj.find("."+pageParam.pageBoxClass).length == 0) {
			pagePluginObj.append("<ul class='"+pageParam.pageBoxClass+"'></ul>");
		} else {
			pagePluginObj.find("."+pageParam.pageBoxClass).empty();
		}
		if (pageParam.pageCount > 1) {
			
			if (pageParam.pageNumNow == 1) {
				var pageHtml = "<li class='disabled' data-page='1'>首页</li>";
					pageHtml += "<li class='disabled' data-page='1'>上一页</li>";
			} else {
				var prevPage = Math.round(pageParam.pageNumNow-1);
				var pageHtml = "<li data-page='1'>首页</li>"
					pageHtml += "<li data-page='"+prevPage+"'>上一页</li>";
			}
			
			var pageMiddle = Math.floor(pageParam.pageShowNum / 2);//显示的按钮数的中间节点
			var startPage = Math.round(pageParam.pageNumNow - pageMiddle);
			var endPage = Math.round(pageParam.pageNumNow + pageMiddle -1);
			if (startPage <= 0) {
				startPage = 1;
			}
			if (Math.round(endPage-startPage) < pageParam.pageShowNum-1) {
				endPage = Math.round(startPage + pageParam.pageShowNum -1);
			}
			if (endPage > pageParam.pageCount) {
				endPage = pageParam.pageCount;
			}
			if (Math.round(endPage-startPage) < pageParam.pageShowNum-1) {
				startPage = Math.round(endPage - pageParam.pageShowNum +1);
			}
			if (startPage <= 0) {
				startPage = 1;
			}
			for(startPage ; startPage <= endPage ;startPage++) {
				if (startPage == pageParam.pageNumNow) {
					pageHtml += "<li class='active' data-page='"+startPage+"'>"+startPage+"</li>";
				} else {
					pageHtml += "<li data-page='"+startPage+"'>"+startPage+"</li>";
				}
			}
			if (pageParam.pageNumNow == pageParam.pageCount) {
				pageHtml += "<li class='disabled' data-page='"+pageParam.pageCount+"'>下一页</li>";
				pageHtml += "<li class='disabled' data-page='"+pageParam.pageCount+"'>尾页</li>";
			} else {
				var nextPage = Math.round(pageParam.pageNumNow +1);
				pageHtml += "<li data-page='"+nextPage+"'>下一页</li>";
				pageHtml += "<li data-page='"+pageParam.pageCount+"'>尾页</li>";
			}
			pagePluginObj.find("."+pageParam.pageBoxClass).html(pageHtml);
		}
	};
	
	//获取数据
	function getAjaxJson() {
		var param = $(pageParam.searchForm).serialize()+"&page="+pageParam.pageNumNow+"&pageSize="+pageParam.pageSize;
		pagePluginObj.find("tbody").empty();
		$.ajax({
			type:"POST",
			url:pageParam.url,
			dataType:"json",
			data:param,
			beforeSend:function() {
				if (pagePluginObj.find("#loading-img").length == 0) {
					pagePluginObj.append("<div id='loading-img'></div>");
				}
				$("#loading-img").show();
			},
			complete:function(){
				$("#loading-img").hide();
			},
			success:function(data) {
				pageParam.countNums = data.count;
				pageParam.pageCount = Math.ceil(data.count / pageParam.pageSize);
				gethtml(data.data);
				createPageHtml();
				$("."+pageParam.pageBoxClass).find("li").click(function(){
					clickPage($(this));
				})
			},
			error:function() {
				
			}
		});
		return false;
	};
	function clickPage(obj) {
		if ($(obj).hasClass("active") || $(obj).hasClass("disabled")) {
			return false;
		}
		pageParam.pageNumNow = Math.round($(obj).attr("data-page")*1);
		getAjaxJson();
	};
	function conditionSearch() {
		var formObj = $(pageParam.searchForm);
		if (typeof $._data != 'undefined') { //阻止form多次绑定submit事件
			var objEvt = $._data(formObj[0], "events");
			if (objEvt && objEvt["submit"]) {
				return false;
			}
		}
		formObj.submit(function(){
			pageParam.pageNumNow = 1;
			getAjaxJson();
			return false;
		});
	};
	//生成html字符
	function gethtml(data) {
		var html = "";
		var i = 0;
		var datalen = data.length;
		if (datalen == 0) {
			if(pagePluginObj.find(".data-empty").length == 0) {
				pagePluginObj.append("<div class='data-empty'>木有数据哟！换个条件试试</div>");
			}
			pagePluginObj.find(".data-empty").show();
		} else {
			for(i ;i<datalen ;i++) {
				html += "<tr>";
				var j = 0;
				for(j ; j<pageParam.fieldlen ; j++) {
					if (pageParam.columns[j]["field"] == false) {
						html += "<td style='text-align:"+pageParam.columns[j]["align"]+"'>"+pageParam.columns[j].formatter(data[i])+"</td>";
					} else {
						if (typeof data[i][pageParam.columns[j]["field"]] == "object") {
							html += "<td></td>";
						} else {
							html += "<td style='text-align:"+pageParam.columns[j]["align"]+"'>"+data[i][pageParam.columns[j]["field"]]+"</td>";
						}
					}
				}
				html += "</tr>";
			}
			pagePluginObj.find(".data-empty").hide();
			pagePluginObj.find("tbody").html(html);
		}
	};
	function createThead() {
		var i = 0;
		var thHtml = "<tr>";
		for (i ;i< pageParam.fieldlen ;i++) {
			thHtml += "<th style='width:"+pageParam.columns[i]["width"]+"'>"+pageParam.columns[i]["title"]+"</th>";
		}
		thHtml += "</th>";
		pagePluginObj.find("thead").html(thHtml);
	};
	function createTable() {
		if (pagePluginObj.find("table").length == 0) {
			var html = '';
			pagePluginObj.append("<table class='"+pageParam.className.tableClass+"'></table>");
			pagePluginObj.find("table").append("<thead class='"+pageParam.className.theadClass+"'></thead><tbody class='"+pageParam.className.tbodyClass+"'></tbody>");
		}
	};
	
})(jQuery); 
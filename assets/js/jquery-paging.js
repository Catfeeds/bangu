/**
var data = '{"totalRecords":"6","totalPages":"1.6","pageNum":"1","pageSize":"10","rows":[{"id":"10","nickname":"普吉岛-1","linename":"普吉岛","startcity":"75","linebefore":"20","modtime":"1426256985","linkman":"桑德诺","username":"admin2"},{"id":"15","nickname":"999999999999999999999","linename":"676888","startcity":"0","linebefore":"0","modtime":"","linkman":"桑德诺","username":"admin2"},{"id":"20","nickname":"test123","linename":"test123123","startcity":"30","linebefore":"1","modtime":"","linkman":"洪门","username":""},{"id":"1","nickname":"港澳海迪4天","linename":"香港-澳门4日游","startcity":"75","linebefore":"3","modtime":"","linkman":"洪门","username":""},{"id":"67","nickname":"小明","linename":"线路","startcity":"75","linebefore":"1","modtime":"","linkman":"洪门","username":""},{"id":"66","nickname":"123","linename":"123","startcity":"29","linebefore":"3","modtime":"","linkman":"洪门","username":""}]}';

**/

function initTableForm(formId,renderTo,columns,isJsonp,errorHandle ){
	var url = $(formId).attr('action');
	if(!isJsonp){
		isJsonp=false;
	}
	return new jQuery.paging({errorFun:errorHandle,isJsonp:isJsonp,renderTo:renderTo,url:url,form:formId,columns:columns});
}


jQuery(document).ready(function(){
	jQuery.paging = function(settings) {
		jQuery.extend(this, settings);
		if(jQuery(this.form).length>0){
			this.form = jQuery(this.form);
		}else{
			this.form = null;
		}
		this.page = jQuery(this.renderTo);

		if(this.displayColumns){
			var $this=this;
			for(var index=0;index<$this.columns.length;index++){
				var col=$this.columns[index];
				if(col && (!col.field || jQuery.inArray(col.field,$this.displayColumns)==-1)){
					$this.columns.splice(index,1);
					index--;
				}
			}
		}
	};


	function replaceClass(c1, c2) {
		return this.filter('.' + c1).removeClass(c1).addClass(c2).end();
	}
	jQuery.paging.prototype = {
		pageSize : 10,// 每页记录数
		pageNum : 1,// 当前页数
		totalRecords : 0,// 总记录数
		totalPages : 0,// 总页数
		renderTo : 'body',
		width : "100%",
		emptyShow : "无数据",
		height :"auto",
		totalBar : false,
		height : null,
		autoLoad : false,
		record : [],
		callback : function(args){},
		errorFun : function(args){alert('errorFun')},
		rowCallback : null,
		loadDataBefore : function(data){},
		selectedRecord : null,
		page_tbody : null,
		pageNumKey:'pageNum',// 第几页的参数名
		pageSizeKey:'pageSize',//每页数量的参数名
		pageBkgroun:'#F5F6FA', //颜色 配值   bkStaic
		CSS : {
			row_even  : "even",
			row_on  : "on",
			row_selected  : "selected",
			page_num : "page_num",
			page_list : "table table-hover",
			table :"table table-hover",
			table_header :"bordered-darkorange"
		},
		getCurrentRecord : function(event) {
			var $this = this;
			var target = event.target || event;
			while (target.tagName.toUpperCase() != "TD") {
				target = target.parentNode;
				if (target.tagName.toUpperCase() == "BODY") {
					return null;
				}
			}
			// 当前选择的行
			return $this.record.rows[target.parentNode.rowIndex]
		},
		initPageList : function() {
			this.page.html('');
			this.page_list = jQuery('<div class="x-grid"></div>').appendTo(this.page);
			jQuery('<div id="loading" class="loading"><div class="loadingioc"></div></div>').appendTo(this.page_list);

			this.page_table = jQuery('<table width="100%" class="'+this.CSS.table+'"></table>').appendTo( this.page_list  );

			var page_table_header = '<thead class="'+this.CSS.table_header+'"><tr>';
			jQuery.each(this.columns, function(index, col) {
				page_table_header += '<th class="x-column-header" style="text-align:center" ';
							if (col.height) {
								page_table_header += ' height="' + col.height + '" ';
							}
							if (col.width){
								page_table_header += ' width="' + col.width + '" ';
							}
							if (col.sortable){
								page_table_header +='>';
							}else {
								page_table_header +='>';
							}
							if( col.title){
								page_table_header += col.title ;
							}else{
								page_table_header +='&nbsp;&nbsp;';
							}
							page_table_header += '</th>';
					});
			page_table_header += '</tr></thead>';
			jQuery(this.page_table).append(page_table_header);
			this.page_tbody = jQuery('<tbody></tbody>').appendTo(this.page_table);
			//分页
			// jQuery('<div class="pagination"></div>').appendTo(this.page_list);
			if(this.autoLoad==true){
				this.load();
			}
		},
		initEvents:function(){
			var $this = this;

			$(this.form).find(".pagination li a").click(function(){
				var p= $(this).attr("p") ;
				if (Number(p) > $this.totalPages || $this.pageNum==p || Number(p)<1) {
					return ;
				}
				$this.pageNum=Number(p);
			//	$(this.form).find(".pageNum").eq(0).val(p) ; //当前页
				$this.load();
			});
			
			$(this.form).find(".pageSize").blur(function(){
				var me= $(this);
				$this.pageNum=1;
				$this.pageSize=Number(me.val());
			//	$(this.form).find(".pageNum").eq(0).val(p) ; //当前页
				$this.load();
			});
			
			

			if(null==$this.rowCallback){
			}
		},

		setData:function(){
			$(this.form).find(".pageSize").eq(0).val(this.pageSize) ; //每页记录数
			$(this.form).find(".pageNum").eq(0).html(this.pageNum) ; //当前页
			$(this.form).find(".totalRecords").eq(0).html(this.totalRecords) ; //总记录数
			$(this.form).find(".totalPages").eq(0).html(this.totalPages) ; //总页数
		},

		refreshPageBar : function(page) {
			var $this = this;
			

			var pageHtml = '';
			var i=1;
			var pageNum = Number(page.pageNum ) ;
			var showPage= 7 ; // 一共最多显示多少页

		//	var beforeCount = pageNum -1; //前面最少的数量3
		//	var afterCount = $this.totalPages - pageNum ; //后面最少的数量3

			//从当前页向前推3页   pageNum=2只推一页     末尾不足补到前面
			var curNum =   pageNum-3 ;
			if(curNum<=0){
				curNum=1;
			}
			for(curNum = curNum ;curNum< pageNum && curNum<$this.totalPages  ;curNum++){
				showPage--;
				pageHtml = pageHtml+'<li class="page"><a href="###" p="'+curNum+'" class="'+$this.CSS.page_num+'">'+curNum+'</a>&nbsp;</li>'  ;
			}
			//当前页面
			pageHtml = pageHtml + '<li class="page active"><a href="###" p="'+pageNum+'">'+  pageNum  +'</a>&nbsp;</li>';
			//上一页,首页
			var prevPageNum= pageNum-1;
			if(prevPageNum<= 0){
				prevPageNum=1 ;
			}
			pageHtml = '<li class="total">&nbsp;&nbsp;<a href="###" p="1" class="'+$this.CSS.page_num
			+'" >首页</a>&nbsp;</li><li class="last"><a href="##" p="'+prevPageNum+'" class="'+$this.CSS.page_num+'">上一页</a>&nbsp;</li>'+ pageHtml ;//插入到前面

			//pageHtml = '<span class="col-sm-6">共'+($this.totalRecords||0)+'条 第'+($this.pageNum||1)+'/'+($this.totalPages||0)+'页</span>'+ pageHtml ;//插入到前面
			// 后面的页
			curNum =   pageNum+1 ;
			for(curNum =  pageNum+1 ;curNum <=$this.totalPages && curNum<showPage+pageNum ; curNum++){
				pageHtml = pageHtml + '<li class="page"><a href="###" p="'+curNum+'" class="'+$this.CSS.page_num+'">'+curNum+'</a>&nbsp;</li>';
			}
			//下一页,尾页
			var nextNum =  pageNum+1;
			//alert("nextNum:"+nextNum);
			if(nextNum>= $this.totalPages ){
				nextNum = $this.totalPages ;
			}
			pageHtml = pageHtml + '<li class="next"><a p="'+nextNum+'" href="##" class="'+$this.CSS.page_num
				+'">下一页</a>&nbsp;</li><li class="lastest"><a href="##" p="'+$this.totalPages+'">尾页</a>&nbsp;</li><li> <div class="lab">每页</div><input class="pageSize" name="page" size=4/>条 </li>';

			var pagebar=$(this.form).find(".pagination");
			pagebar.html(pageHtml);
		},
		createTable : function(data) {
			var $this = this;
			if ($this.columns && data ) {
				$this.page_tbody.html('');
				var tr = '';
				var field = null;
				var col_len = $this.columns.length;
				if(data.rows && data.rows.length>0){
					var len = data.rows.length;

					jQuery.each(data.rows, function(index, record) {
						// 设置行的样式
						if(null!=$this.rowCallback){
							var rowClass = $this.rowCallback(index,record);
							if(!rowClass){
								rowClass = '';
							}
							tr += index % 2 == 0 ? '<tr class="'+rowClass+'">' : '<tr class="'+rowClass+ ' ' + $this.CSS.row_even + '">';
						}else{
							tr += index % 2 == 0 ? '<tr>' : '<tr class="' + $this.CSS.row_even + '">';
						}
						// 生成单元格
						for (var i = 0; i < col_len; i++) {
							field = $this.columns[i].field;
							tr += '<td class="x-grid-cell'+(i==col_len-1?" x-grid-cell-last":"")+'" ';
							if (index==0 && $this.columns[i].height) {
								tr += ' height="' + $this.columns[i].height + '" ';
							}
							if (index==0 && $this.columns[i].width) {
								tr += ' width="' + $this.columns[i].width + '" ';
							}
							if ($this.columns[i].height) {
								tr += ' height="' + $this.columns[i].height + '" ';
							}

							if ($this.columns[i].align) {
								tr += ' style="text-align:' + $this.columns[i].align + '" ';
							}
							tr += '><div class="x-grid-cell-inner" style="position:relative;">';
							tr += $this.columns[i] && $this.columns[i].formatter ? $this.columns[i].formatter(record[field], record, index,i-1) : record[field];
							tr += '</div></td>';
						}
						tr += '</tr>';
					});
				}else{
					tr += '<tr colspan="'+col_len+'"><td style="text-align: center;font-weight: bold;color: red;font-size: 14px; vertical-align: middle;" colspan="'
					+ $this.columns.length + '"  height="200" >'+$this.emptyShow+'</td></tr>';
				}
				tr += '';
				$this.totalRecords = data.totalRecords;
				$this.totalPages = data.totalPages;

				$this.pageNum = data.pageNum;
				$this.pageSize = data.pageSize;

				if(0== this.totalPages){
					  this.totalPages=1  ;
				}
				if($this.pageNum >  this.totalPages){
					$this.pageNum =  this.totalPages  ;
				}
			} else {
				$this.totalRecords = 0;
				$this.totalPages = 0;
				$this.pageNum = 1;
				$this.pageSize = 10;
			}
			$this.page_tbody.append(tr);
            $(".bkStaic").parent().parent().css("background",this.pageBkgroun);
			//$this.refreshPageBar();
			//重置头部宽度
			jQuery('.x-grid-header',this.page_list).width(jQuery('.x-grid-body',this.page_list).outerWidth());
			
			
			
		},
		getLoadParameters:function(){
			return null;
		},
		setHeight:function(){
			var top = $(this.page_list).position().top;
			var winHeight = $(window).height();
			var headerHeight = $('.x-grid-header-container',this.page_list).outerHeight();
			var pageHeight = jQuery('.page',this.page_list).outerHeight();
			jQuery('.x-grid-body-ct',this.page_list).height(winHeight - top - headerHeight - pageHeight - 5);
		},
		load : function(paramObject,callback) {
		//	alert("load");
			var $this = this;
//			if ($this.pageNum > $this.totalPages && $this.totalPages > 0) {
//				$this.pageNum = $this.totalPages;
//				jQuery("." + this.CSS.page_index, $this.page).val($this.pageNum);
//			}

			var param = '';
			if($this.form){
				param+=$this.form.serialize();
			}

			if(!this.param){
				this.param = {};
			}
			if(paramObject){
				jQuery.extend(this.param, paramObject);
			}
			param+=(""!=param ? "&" : "")+jQuery.param(this.param);
			param+=("&"+this.pageNumKey+"="+this.pageNum );
			param+=("&pageSize="+this.pageSize );
			if($this.getLoadParameters){
				var p=$this.getLoadParameters();
				if(p && jQuery.isPlainObject(p)){
					param+="&"+jQuery.param(p);
				}
			}
			var loading = jQuery('.loading',this.page);
			loading.show();
			var dataType ="json";
			if(this.isJsonp){
				dataType ="jsonp";
			}
			jQuery.ajax({ type : "POST", url : $this.url, dataType:dataType , data : param,
				success : function(response) {
							jQuery("th :checked", $this.page).attr("checked",false);
							response=eval(response);
							$this.record = response ;//jQuery.parseJSON(response);
						//	jQuery("th :checked", $this.page).attr("checked",false);
							$this.loadDataBefore($this.record);
							$this.initPageList();
							$this.createTable($this.record);
							$this.refreshPageBar($this.record);
							$this.initEvents();
							$this.setData();
							if($this.record && $this.record.callback){
								$this.callback($this.record.callback);
							}else{
								$this.callback();
							}
							loading.hide();
							if(callback)
							callback(this);
							//$this.errorFun("假装错误");
						},
						error:function(http,status,errorMsg){
							//alert('错误'+http+","+status+','+errorMsg);
							//$this.errorFun(errorMsg);
						}
					});
            
		}
	};

});
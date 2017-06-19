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
					--index;
				}
			}
		}
		if(this.sortColumns){
			var $this=this;
			jQuery.each($this.columns, function(index, col) {
				if(jQuery.inArray(col.field,$this.sortColumns)!=-1){
					jQuery.extend(col,{
						sortable:true
					});
				}
			});
		}
		this.initPageList();
		this.initEvents();
		
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
		height :"auto",
		totalBar : false,
		height : null,
		autoLoad : false,
		record : [],
		callback : function(args){},
		rowCallback : null,
		loadDataBefore : function(data){},
		selectedRecord : null,
		page_tbody : null,
		CSS : {
			row_even  : "even",
			row_on  : "on",
			row_selected  : "selected",
			page_num : "page_num",
			page_list : "table table-hover",
			table :"table table-bordered table-hover",
			table_header :""
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
			//分页
			this.page_tbody = jQuery('<tbody></tbody>').appendTo(this.page_table);
			jQuery('<div class="pagination"></div>').appendTo(this.page_list);
//			this.setHeight();
			this.initRecord();
			if(this.autoLoad==true){
				this.load();
			}
			//var page_scroll = jQuery(".x-page-scroll",page_list);
			//var full_width = page_scroll.innerWidth(); 
		    //var inner_width = jQuery('.ie6scoll',page_list).innerWidth(); 
		    //jQuery('.x-table-header-left').css("margin-right",(full_width-inner_width));
		},
		initRecord:function(){
			if(this.record){
				this.createTable(this.record);
				$this = this;
				if($this.record && $this.record.callback){
					$this.callback($this.record.callback);
				}else{
					$this.callback();
				}
			}else{
				//if(this.autoLoad==true){
				//	this.load();
				//}
			}
		},
		initEvents:function(){
			var $this = this;
			jQuery($this.page).on("click", ".page_num",function(){
				var p = jQuery(this).attr("p");
				if (Number(p) > $this.totalPages || $this.pageNum==p || Number(p)<1) {
					return ;
				}
				$this.pageNum= p;
				$this.load();
			});
			
//			jQuery("." + $this.CSS.first, $this.page).live("click", handler($this.CSS.first));
//			jQuery("." + $this.CSS.prev, $this.page).live("click", handler($this.CSS.prev));
//			jQuery("." + $this.CSS.next, $this.page).live("click", handler($this.CSS.next));
//			jQuery("." + $this.CSS.last, $this.page).live("click", handler($this.CSS.last));
//			jQuery("." + $this.CSS.refresh, $this.page).live("click", handler($this.CSS.refresh));
//			
//			
//			jQuery("." + $this.CSS.prevBtn, $this.page).click( this.prevBtn);
//			jQuery("." + $this.CSS.nextBtn, $this.page).click( this.nextBtn);
	//
//			jQuery("." + $this.CSS.column_header_sort, $this.page).live("click", function(event) {
//						if (!jQuery(this).is('.' + $this.CSS.column_header_selected)) {
//							jQuery("." + $this.CSS.column_header_selected).removeClass($this.CSS.column_header_selected);
//							jQuery(this).addClass($this.CSS.column_header_selected);
//						}
//						var orderType = "ASC";
//						jQuery(".ASC,.DESC", this).toggleClass(function() {
//									if (jQuery(this).is('.ASC')) {
//										orderType = 'DESC';
//										jQuery(this).removeClass('ASC');
//									} else {
//										orderType = 'ASC';
//										jQuery(this).removeClass('DESC');
//									}
//									return orderType;
//								});
//						// 单页排序
//						if (( $this.totalPages == 1 ) && sortTypes) {
//							var selectedCol = jQuery("span", this).attr("column");
//							var item = $this.record.rows[0][selectedCol];
	//
//							$this.record.rows.sort(function(a, b) {
//										return sortTypes.sort[sortTypes.typeOf(item)](a[selectedCol], b[selectedCol]);
//									});
	//
//							if (orderType == "DESC") {
//								$this.record.rows.reverse();
//							}
//							$this.createTable($this.record);
//						} else {
//							$this.load();
//						}
//					});
			if(null==$this.rowCallback){
//				jQuery("tr",$this.page).live({
//					   mouseenter:function(){
//						   jQuery(this).addClass($this.CSS.row_on);
//					   },
//					   mouseleave: function(){
//						   jQuery(this).removeClass($this.CSS.row_on);
//					   }
//					});
//				jQuery("tr", $this.page).live("click", function(event) {
//					if (!jQuery(this).is('.' + $this.CSS.row_selected)) {
//						jQuery("." + $this.CSS.row_selected, $this.page).removeClass($this.CSS.row_selected);
//						jQuery(this).addClass($this.CSS.row_selected);
//					}
//					$this.selectedRecord=$this.getCurrentRecord(event);
//				});
			}
//			jQuery("." + this.CSS.page_index, $this.page).keypress(function(event) {
//						// this.value=jQuery.trim(this.value);
//						if (event.keyCode == 13 && /^\d+$/.test(this.value)) {
//							$this.pageNum = this.value;
//							$this.load();
//						} else if (event.keyCode == 18) {
	//
//						} else if (event.keyCode < 48 || event.keyCode > 57) {
//							return false;
//						}
//					});
		},
		refreshPageBar : function() {
			var $this = this;
			var page = jQuery('.pagination',this.page_list);
			page.html("");
			var pageHtml = '';
			var i=1;
			var eNum= $this.totalPages-($this.pageNum ? $this.pageNum : 1);//后面还有几页
			
			var addNum = 3-eNum>0 ? 3-eNum : 0;
			//从当前页向前推3页   pageNum=2只推一页     末尾不足补到前面
			while($this.pageNum>i && i<=3+Number(addNum)){
				pageHtml = '<li class="page"><a href="###" p="'+($this.pageNum-i)+'" class="'+$this.CSS.page_num+'">'+($this.pageNum-i)+'</a>&nbsp;</li>'+ pageHtml ;
				i++;
			}
			pageHtml = pageHtml + '<li class="page active"><a href="###">'+($this.pageNum ? $this.pageNum : 1)+'</a>&nbsp;</li>';//当前页面
			pageHtml = '<li class="total">&nbsp;&nbsp;<a href="###" p="1" class="'+$this.CSS.page_num+'" >首页</a>&nbsp;</li><li class="last"><a href="##" p="'+($this.pageNum>1?$this.pageNum-1:$this.pageNum)+'" class="'+$this.CSS.page_num+'">上一页</a>&nbsp;</li>'+ pageHtml ;//插入到前面
//			pageHtml = '<input type="hidden" name="pageSize" value="'+$this.pageSize+'" /><span class="p_total">共'+($this.totalRecords||0)+'条 第'+($this.pageNum||1)+'/'+($this.totalPages||0)+'页</span>'+ pageHtml ;//插入到前面
			var curNum = Number($this.pageNum) + 1;//判断是否到了末尾
			while(i < 7 && curNum<=$this.totalPages){
				pageHtml = pageHtml + '<li class="page"><a href="###" p="'+curNum+'" class="'+$this.CSS.page_num+'">'+curNum+'</a>&nbsp;</li>';
				curNum++;
				i++ ;
			}
			pageHtml = pageHtml + '<li class="next"><a p="'+(Number($this.pageNum)+1)+'" href="##" class="'+$this.CSS.page_num+'">下一页</a>&nbsp;</li><li class="lastest"><a href="##"	 class="'+$this.CSS.page_num+'" p="'+$this.totalPages+'">尾页</a>&nbsp;</li>';
			jQuery(pageHtml).appendTo(page);
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
					tr += '<tr colspan="'+col_len+'"><td style="text-align: center;font-weight: bold;color: red;font-size: 14px; vertical-align: middle;" colspan="' + $this.columns.length + '"  height="200" >无匹配的数据</td></tr>';
				}
				tr += '';
				$this.totalRecords = data.totalRecords;
				$this.totalPages = data.totalPages;
				$this.pageNum = data.pageNum;
				$this.pageSize = data.pageSize;
			} else {
				$this.totalRecords = 0;
				$this.totalPages = 0;
				$this.pageNum = 1;
				$this.pageSize = 10;
			}
			$this.page_tbody.append(tr);
			$this.refreshPageBar();
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
			
			
			param+="&"+jQuery.param({"pageNum":this.pageNum ? $this.pageNum : 1});
			if($this.getLoadParameters){
				var p=$this.getLoadParameters();
				if(p && jQuery.isPlainObject(p)){
					param+="&"+jQuery.param(p);
				}
			}
			var loading = jQuery('.loading',this.page);
			//loading.show();
			jQuery.ajax({ 
				type : "POST",
				url : $this.url, 
				data : param,
				beforeSend:function() {//ajax请求开始时的操作
	    				loading.show();
	    				//jQuery('.table-hover').hide();
	    			},
	    			complete:function(){//ajax请求结束时操作
	    				loading.hide();
	    				//jQuery('.table-hover').show();
	    			},

				success : function(response) {
							jQuery("th :checked", $this.page).attr("checked",false);
							$this.record = jQuery.parseJSON(response);
							jQuery("th :checked", $this.page).attr("checked",false);
							$this.loadDataBefore($this.record);
							$this.createTable($this.record);
							if($this.record && $this.record.callback){
								$this.callback($this.record.callback);
							}else{
								$this.callback();
							}
							//loading.hide();
							if(callback)
							callback(this);
						}
					});
			
		}
	};
	
});

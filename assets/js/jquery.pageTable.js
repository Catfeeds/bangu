;(function($, window, document,undefined) {
    var Paging = function($this, opt) {
        this.$this = $this,
        this.defaults = {
        		pageSize:10,//每页条数
    			pageNumNow:1,//当前页
    			pageCount:0,//总页数
    			countNums:0,//记录总数
    			pageShowNum:8,//显示的分页按钮数
    			pageBoxClass:'page-button', //分页的class名称
    			columns:{},
    			emptyClass:'data-empty',//没有数据时提示框
    			searchForm:'',//数据搜索条件的form元素ID（#form）
    			isFormSubmit:false,
    			url:'',//数据请求地址
    			tableClass:'table table-striped table-hover table-bordered dataTable no-footer',//table元素的class名称
    			theadClass:'',
    			tbodyClass:'',
    			loading:'loading-img',
    			isEnable:false,
    			isPageJump:false,
    			emptyMsg:'木有数据哟！换个条件试试',
    			emptyHeight:200,
    			isStatistics:false,//分页前的数据统计
    			statisticsContent:''
        },
        this.options = jQuery.extend({}, this.defaults, opt)
    };
    Paging.prototype = {
    	ajaxPostData:function() {//获取数据
    		var thisObj = this.$this;
    		var selfObj = this;
    		var optionsObj = this.options;
    		var param = optionsObj.searchForm.length == 0 ? '' : jQuery(optionsObj.searchForm).serialize()+'&';
    		thisObj.find('tbody').empty();//清空原数据
    		jQuery.ajax({
    			type:"POST",
    			url:optionsObj.url,
    			dataType:"json",
    			data:param+'page='+optionsObj.pageNumNow+'&pageSize='+optionsObj.pageSize,
    			beforeSend:function() {//ajax请求开始时的操作
    				if (thisObj.find('#'+optionsObj.loading).length == 0) {
    					thisObj.append('<div id="'+optionsObj.loading+'"></div>');
    				}
    				thisObj.find('#'+optionsObj.loading).show();
    				thisObj.find('.'+optionsObj.pageBoxClass).hide();
    			},
    			complete:function(){//ajax请求结束时操作
    				thisObj.find('#'+optionsObj.loading).hide();
    				thisObj.find('.'+optionsObj.pageBoxClass).show();
    			},
    			success:function(data) {
    				if (jQuery.isEmptyObject(data.data) && optionsObj.pageNumNow > 1) {
    					optionsObj.pageNumNow = Math.round(optionsObj.pageNumNow -1);
    					selfObj.ajaxPostData();
    				} else {
    					selfObj.dataShow(data.data);
        				selfObj.pageShow(data.count);
        				selfObj.pageClick();
    				}
    			}
    		});
    	},
    	pageShow:function(count) {//分页计算
    		this.defaults.countNums = count;
    		this.defaults.pageCount = Math.ceil(count / this.options.pageSize);
    		if (this.$this.find('.page-box').length == 0) {
    			if (this.options.isStatistics == true) {
        			this.$this.append('<div class="page-box">'+this.options.statisticsContent+'</div>');
        		} else {
        			this.$this.append('<div class="page-box"></div>');
        		}
    		}
    		
    		if (this.defaults.pageCount <= 1) {
    			this.$this.find('.'+this.options.pageBoxClass).html('');
    			this.$this.find('.'+this.options.pageBoxClass).next('.pageJumpBox').hide();
    			return false;
    		}
    		if (this.$this.find('.'+this.options.pageBoxClass).length == 0) {
    			this.$this.find('.page-box').append('<ul class="'+this.options.pageBoxClass+'" style="display: inline-block;"></ul>');
    		}
    		var pageMiddle = Math.floor(this.options.pageShowNum / 2);//显示的按钮数的中间节点
			var startPage = Math.round(this.options.pageNumNow*1 - pageMiddle);//分页开始数字
			var endPage = Math.round(this.options.pageNumNow*1 + pageMiddle -1);//分页结束数字
			
    		if (startPage < 1) {
    			startPage = 1;
    			endPage = Math.round(startPage + this.options.pageShowNum -1);
    			if (endPage > this.defaults.pageCount) {
    				endPage = this.defaults.pageCount;
    			}
    			var s = true;
    		}
    		if (s !== true) {
    			if (endPage > this.defaults.pageCount) {
    				endPage = this.defaults.pageCount;
    				startPage = Math.round(endPage - this.options.pageShowNum + 1);
    				if (startPage < 1) {
    					startPage = 1;
    				}
    			}
    		}
    		if (this.options.pageNumNow == 1) {
    			var html = '<li class="disable-page" data-page="1">首页</li><li class="disable-page" data-page="1">上一页</li>';
    		} else {
    			var html = '<li data-page="1">首页</li><li data-page="'+Math.round(this.options.pageNumNow*1 -1)+'">上一页</li>';
    		}
    		for(startPage ;startPage <= endPage; startPage++) {
    			if (startPage == this.options.pageNumNow) {
    				html += '<li class="active-page" data-page="'+startPage+'">'+startPage+'</li>';
    			} else {
    				html += '<li data-page="'+startPage+'">'+startPage+'</li>';
    			}
    		}
    		if (this.options.pageNumNow == this.defaults.pageCount) {
    			html += '<li class="disable-page" data-page="'+this.defaults.pageCount+'">下一页</li><li class="disable-page" data-page="'+this.defaults.pageCount+'">尾页</li>';
    		} else {
    			html += '<li data-page="'+Math.round(this.options.pageNumNow*1 +1)+'">下一页</li><li data-page="'+this.defaults.pageCount+'">尾页</li>';
    		}
    		this.$this.find('.'+this.options.pageBoxClass).html(html);
    		if (this.options.isPageJump == true && this.$this.find('.pageJumpBox').length == 0) {
    			str = '<div class="pageJumpBox" style="margin: -37px 0px 0px 10px;display: inline-flex;">';
    			str += '<input type="text" name="pageJumpNum" style="width:45px;height: 29px;border: 1px solid #ccc;padding-left: 10px;">';
    			str += '<span class="subPageJump" style="display: inline-block;margin-left: 7px;border: 1px solid #ccc;padding: 4px 5px;border-radius: 3px;cursor: pointer;">转到</span></div>';
    			this.$this.find('.'+this.options.pageBoxClass).after(str);
    			thisObj = this;
    			jQuery('.subPageJump').click(function(){
    				var num = thisObj.$this.find('input[name=pageJumpNum]').val();
    				num = num<1 ? 1 : num;
    				num = num > thisObj.defaults.pageCount ? thisObj.defaults.pageCount : num;
    				thisObj.$this.find('input[name=pageJumpNum]').val(num);
    				thisObj.options.pageNumNow = num;
    				thisObj.ajaxPostData();
    			})
    		} else {
    			this.$this.find('.'+this.options.pageBoxClass).next('.pageJumpBox').show();
    			this.$this.find('input[name=pageJumpNum]').val('');
    		}
    		
    	},
    	pageClick:function() {
    		var selfObj = this;
    		this.$this.find('.'+this.options.pageBoxClass).find('li').on('click' ,function(){
    			if (jQuery(this).hasClass('disable-page') || jQuery(this).hasClass('active-page')) {
    				return false;
    			} else {
    				selfObj.options.pageNumNow = jQuery(this).attr('data-page');
    				selfObj.ajaxPostData();
    			}
    		});
    	},
    	dataShow:function(data) {//数据展示
    		var html = "";
    		var j = this.options.columns.length;
    		var datalen = data.length;
    		if (datalen == 0) {
    			if(this.$this.find('.'+this.options.emptyClass).length == 0) {
    				this.$this.append('<div style="height:'+this.options.emptyHeight+'px;line-height:'+this.options.emptyHeight+'px;" class="'+this.options.emptyClass+'">'+this.options.emptyMsg+'</div>');
    			}
    			this.$this.find('.'+this.options.emptyClass).show();
    			this.$this.find('.batch-enable').hide();
    		} else {
    			var a = 0;
    			for(a ; a<datalen ;a++) {
    				html += '<tr>';
    				var i = 0;
    				for(i; i<j ;i++) {
    					var align = typeof(this.options.columns[i]['align']) == 'undefined' ? 'center' : this.options.columns[i]['align'];
    					if (this.options.columns[i]['field'] == false || this.options.columns[i]['field'] == null) {
    						html += '<td style="text-align:'+align+'">'+this.options.columns[i].formatter(data[a])+'</td>';
    					} else {
    						if (typeof data[a][this.options.columns[i]['field']] == 'object') {
    							html += '<td></td>';
    						} else {
    							html += '<td style="text-align:'+align+'">'+data[a][this.options.columns[i]['field']]+'</td>';
    						}
    					}
    				}
    				html += '</tr>';
    			}
    			this.$this.find('.'+this.options.emptyClass).hide();
    			this.$this.find('tbody').html(html);
    			this.$this.find('.batch-enable').show();
    		}
    	},
    	createTable:function() {//生成table元素
    		if (this.$this.find('table').length == 0) {
    			this.$this.append('<table class="'+this.options.tableClass+'"></table>');
    			
    			this.$this.find('table').html('<thead class="'+this.options.theadClass+'"><tr></tr></thead><tbody class="'+this.options.tbodyClass+'"></tbody>');
    		};
    		var j = this.options.columns.length;
    		var i = 0;
    		var html='';
    		for(i ; i<j ;i++) {
    			var align = typeof(this.options.columns[i]['align']) == 'undefined' ? 'center' : this.options.columns[i]['align'];
    			//html += '<th style="width:'+this.options.columns[i]['width']+'px;text-align:'+align+';">'+this.options.columns[i]['title']+'</th>';
    			
    			html += '<th style="';
    			if(this.options.columns[i]['width']){
    				html += 'width:'+this.options.columns[i]['width']+'px;';
    			}
    			html += 'text-align:'+align;
    			html += '" >'+this.options.columns[i]['title'];
    			html += '</th>';
    		}
    		this.$this.find("thead").find("tr").html(html);
    	},
    	searchCondition:function(){//条件搜索
    		var selfObj = this;
    		if (jQuery(selfObj.options.searchForm).html()) {
    			jQuery(selfObj.options.searchForm).unbind('submit');
    			jQuery(selfObj.options.searchForm).bind('submit' ,function(){
    				selfObj.options.pageNumNow = 1;
    				selfObj.ajaxPostData();
    				return false;
    			})
    		}
    	}
    };
    jQuery.fn.pageTable = function(options) {
    	var paging = new Paging(this, options);
    	//生成table框架
    	paging.createTable();
    	//获取数据
    	paging.ajaxPostData();
    	paging.searchCondition();
    	if (options.isEnable == true) {
    		this.find('.batch-enable').remove();
			this.find('.'+options.tableClass).after('<div class="batch-enable" style="margin-top:20px; margin-right:5px;" >批量启用</div>');
			options.enableCallback();
		} else {
			this.find('.batch-enable').remove();
		}
    }
})(jQuery, window, document);
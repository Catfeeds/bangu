;(function($, window, document,undefined) {
	var Linkage = function(element ,opts){
		this.element = element,
	    this.defaults = {
			width:'140px',//输入框的宽度
			jsonData:{},/*json格式数据
			 			 * {0:defaultArr:
			 			 * 		{0:{id:9,name:'广东'},10:{id:13,name:'湖北'}},
			 			 *  9:{0:{id:90,name:'深圳'},1:{id:89,name:'广州'}},
			 			 *  13:{0:{id:110,name:'恩施'},1:{id:111,name:'武汉'}}
			 			 * }
			 			 */
			callback:function(){return false;},//回调函数
			names:['country','province','city','region'],//输入框的name值
			hiddenVals:['country_id' ,'province_id' ,'city_id' ,'region_id'], //输入框对应的隐藏域的name值，用于保存数据ID
			inputClass:'search-input',
	    },
	    this.options = jQuery.extend({}, this.defaults, opts);
		this.createInput();
		$this = this;
	};
	Linkage.prototype = {
		createInput:function(){
			var $this = this;
			var html = '';
			jQuery.each(this.options.names ,function(key ,val) {
				html += '<span style="position:relative;" class="ss-list-body">';
				html += '<input type="text" name="'+val+'" class="'+$this.options.inputClass+'" style="width:'+$this.options.width+';display:none;margin-right: 5px;" />';
				html += '<input type="hidden" name="'+$this.options.hiddenVals[key]+'" />';
				html += '<ul class="ss-list-ul" style="min-width:'+$this.options.width+'"></ul>';
				html += '</span>';
			});
			this.element.html(html);
			//搜索内容
			this.element.find('input[type=text]').keyup(function(e){
				if (jQuery(this).parent().prev('.ss-list-body').length) {
					var parent_id = jQuery(this).parent().prev('.ss-list-body').find('ul').find('.ss-active').attr('data-val');
					var dataArr = $this.options.jsonData[parent_id];
				} else {
					var dataArr = $this.options.jsonData.defaultArr;
				}
				$this.search(jQuery(this).val() ,jQuery(this).parent().index() ,dataArr);
			})
			//获得焦点
			this.element.find('input[type=text]').focus(function(){
				jQuery(this).parent().find('ul').show();
			}).click(function(){
				jQuery(this).parent().find('ul').show();
			})
			$(document).mouseup(function(e){
				var _con = $this.element.find('.ss-list-ul');   // 设置目标区域
				if(!_con.is(e.target) && _con.has(e.target).length === 0){
					$this.element.find(".ss-list-body").each(function(){
						if (!jQuery(this).find('input[type=hidden]').val() && !jQuery(this).find('input[type=text]').is(':hidden')) {
							jQuery(this).find('input[type=text]').val('');
							jQuery(this).find('input[type=text]').trigger('keyup');
						}
					})
					$this.element.find(".ss-list-ul").hide()
				}
			})

			this.getListHtml(this.options.jsonData.defaultArr ,0);
			this.element.find('.ss-list-body').eq(0).find('ul').hide();
		},
		/**
		 * @method 遍历数据并写入节点
		 * @param  data 遍历的数据
		 * @param  写入节点的索引
		 */
		getListHtml:function(data ,index) {
			if (typeof data == 'undefined') {
				return false;
			}
			var html = '';
			var i = 0;
			jQuery.each(data ,function(key,val) {
				if (i == 0) {
					html += '<li data-val="'+val.id+'" class="ss-active">'+val.name+'</li>';
				} else {
					html += '<li data-val="'+val.id+'">'+val.name+'</li>';
				}
				i++;
			})
			var nodeObj = this.element.find('.ss-list-body').eq(index);
			nodeObj.find('input[type=text]').show();
			nodeObj.find('ul').html(html).show();
			var thisObj = this;
			nodeObj.find('li').click(function(){
				thisObj.listClick(this);
			})
		},
		listClick:function(thisObj) {
			if (!jQuery(thisObj).hasClass('.ss-empty')) {
				var id = jQuery(thisObj).attr('data-val');
				var name = jQuery(thisObj).text();
				var parent = jQuery(thisObj).parents('.ss-list-body');
				jQuery(thisObj).addClass('ss-active').siblings().removeClass('ss-active');
				parent.find('input[type=hidden]').val(id);
				parent.find('input[type=text]').val(name);
				
				parent.nextAll('.ss-list-body').find('input').val('');
				parent.nextAll('.ss-list-body').find('ul').empty();
				parent.next().nextAll().find('input[type=text]').hide();
				parent.next().nextAll().find('ul').hide();
				if (parent.nextAll('.ss-list-body').length) {
					this.getListHtml(this.options.jsonData[id] ,parent.next('.ss-list-body').index());
				}
				parent.find('ul').hide();
			}
		},
		search:function(keyword ,index ,data) {
			this.element.find('.ss-list-body').eq(index).find('input[type=hidden]').val('');
			this.element.find('.ss-list-body').eq(index).nextAll().find('input').val('').hide();
			this.element.find('.ss-list-body').eq(index).nextAll().find('ul').empty().hide();
			
			var dataArr = new Array();
			if (keyword.length) {
				jQuery.each(data ,function(key ,val){
					if (val.name.indexOf(jQuery.trim(keyword)) != -1) {
						dataArr.push(val);
					}
				})
			} else {
				dataArr = data;
			}
			if (jQuery.isEmptyObject(dataArr)) {
				this.element.find('.ss-list-body').eq(index).find('ul').html('<li class="ss-empty" style="color:red;">找不到'+keyword+'</li>');
			} else {
				this.getListHtml(dataArr ,index);
			}
		}
	};
	jQuery.fn.selectSearch = function(options) {
    	var linkage = new Linkage(this, options);
    }
})(jQuery, window, document);
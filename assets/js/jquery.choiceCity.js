/**
 * @method 城市选择
 * 数据格式： {
 * 			'热门城市':{},
 * 			'ABCDEFG':{},
 * 			'HIJKLMN':{},
 * 			'OPGRST':{},
 * 			'UVWXYZ':{},
 * 		}
 */
;(function($,window,document,undefined){
	var City = function(element ,opts) {
		this.element = element,
		this.defaults = {
			width:'450px',//宽度
			dataJson:{},//数据
			defaultName:'深圳',//默认显示城市
			isFirstTitle:false,//第一个分类下的城市是否有地区，获取拼音的区分 true-有，false-没有
			showElement:'.city_name',
			dataClick:function(obj){},//点击数据回调函数
			css:{
				bodyClass:'city_box fl',
				headerClass:'city_block',//头部class
				//closeClass:'city_cleso', //关闭按钮
				cityListClass:'hidd_city',//数据展示区
				categoryClass:'cityTab',//头部分类
				categoryDefaultClass:'TabLik',//头部分类默认选中
				dataClass:'cityList'//数据列表
			},
		},
		this.options = jQuery.extend({} ,this.defaults ,opts)
	};
	City.prototype = {
		createHtml:function(){
			var html = '<div class="'+this.options.css.bodyClass+'" style="width:'+this.options.width+';">';
			html += '<div class="'+this.options.css.headerClass+'"><span class="current_city current_topic">'+this.options.defaultName+'<i class="triangle-down"></i></span></div>';
			html += '<div class="igcPh"></div>';
			html += '<div class="'+this.options.css.cityListClass+'"><ul class="'+this.options.css.categoryClass+'"></ul><ul class="'+this.options.css.dataClass+'"></ul></div></div>';
			this.element.html(html);
		},
		showData:function(){
			var categoryObj = this.element.find('.'+this.options.css.categoryClass);
			var dataListObj = this.element.find('.'+this.options.css.dataClass);
			var thisObj = this;
            var first = true;
			jQuery.each(this.options.datajson ,function(key ,val){
				if (first == true) {
					categoryObj.append('<li class="'+thisObj.options.css.categoryDefaultClass+'">'+key+'</li>');	
				} else {
					categoryObj.append('<li>'+key+'</li>');
				}
				var html = '';
				if (thisObj.options.isFirstTitle == false && first == true) {
					html += '<li><ul class="citySite topic">';
					jQuery.each(val ,function (k ,v){
						html += '<li data-val="'+v.id+'">'+v.name+'</li>';
					});
					html += '</ul></li>';
				} else {
					html += '<li>';
					jQuery.each(val ,function(k ,v) {
						if (v.length > 0) {
							html += '<span>'+k+'</span><ul class="citySite">';
							$.each(v ,function(index ,item){
								html += '<li data-val="'+item.id+'">'+item.name+'</li>';
							});
							html += '</ul>';
						}
					});
					html += '</li>';
				}
				dataListObj.append(html);
				first = false;
			});
			dataListObj.find('li').first().show();
			//thisObj.element.find('div').first().show();
		},
		categoryClick:function(obj){
			jQuery(obj).addClass(this.options.css.categoryDefaultClass).siblings().removeClass(this.options.css.categoryDefaultClass);
			var key = jQuery(obj).index();
			this.element.find('.'+this.options.css.dataClass).children('li').eq(key).show().siblings().hide();
		},
		mouseleaveBox:function(){
			var boxObj = this.element.find('div').first();
			boxObj.mouseleave(function(){
				boxObj.hide();
			});
		},
		mouseoverElement:function(){
			var thisObj = this;
			var showElementObj = jQuery(thisObj.options.showElement);
			showElementObj.mouseover(function(){
				thisObj.element.find('div').first().show();
			});
		}
	};
	
	jQuery.fn.choiceCity = function(options){
		var city = new City(this ,options);
		city.createHtml();
		city.showData();
		city.element.find('.'+city.options.css.categoryClass).find('li').click(function(){
			city.categoryClick(this);
		});
		city.mouseleaveBox();
		city.mouseoverElement();
		city.element.find('.'+city.options.css.dataClass).children('li').find('li').click(function(){
			city.options.dataClick(this);
			return false;
		})
	};
})(jQuery ,window ,document);
(function($) {
	//重置  定义方法 传参  调用  循环+数据  点击的时候  返回一个 合集
	function ShowDiv(){
		$('html,body').css({'height':'100%','overflow':'hidden'})         
    };	
	function CloseDiv(){
		$('html,body').css({'height':'auto','overflow':'auto'});
		$("._eject_more_product").css("display","none");
		$("#expert_search").show();
    };	
		jQuery.dest = function(options) {
		// 覆盖
		jQuery.extend(this, options);
		//添加这个 header 并且添加到 renderTo  renderTo : 'body',
		this.root = $('<div class="_eject_more_product" style="display:none;"></div>').appendTo(this.renderTo);
		
		//重置方法
		this.init();
	};
	
	jQuery.dest.prototype = {
		data: [],
		renderTo: 'body',
		root: null,
		tabIndx:0,
		callback: function(params) {},
		//  init  上面已经重置过这个方法了
		init: function() {
			this.initHeader(); //头部
			this.initToolbar(); //按钮
			this.initEvent(); //点击事件
		},
		//1. 直接追加 头部即可  ++ header
		initHeader: function() {
			var header = $('<div class="_eject_product_type_header"></div>').appendTo(this.root);
			$('<div class="_eject_cm_head"><i class="_eject_arrow_fl"></i><span id="title_name">线路种类</span></div>').appendTo(header);

			this.initTabList(header);

		},
		show:function(reset,tabIndex){
			var Heiind=jQuery(window).height();
			jQuery("._eject_more_product").css("height",Heiind);
			//product_type_header

			var Heiind=jQuery(window).height();
			var bodyHei = jQuery("._eject_more_product").height();
			var buttomHei= jQuery("._eject_submit_buttom").outerHeight(true);
			var headHei= jQuery("._eject_product_type_header").height();
			var prodtypeHei = jQuery("._eject_product_type").height();
			var surp=buttomHei+headHei;
			var surplue =Heiind-surp;
			var surscll =surplue-buttomHei;
			//alert(surplue)
			jQuery("body").css("overflow","hidden");
			jQuery("._eject_product_type").css("height",surscll);
			jQuery("._eject_product_type",this.root).css("margin-bottom",buttomHei);

			var select_tab_index = tabIndex?tabIndex:0;
			 
			if(reset){
					jQuery('._eject_condition_list .active',this.root).removeClass("active");
					
			}
			//默认选择第0个TAB 内容显示
			jQuery('._eject_product_list li', this.root).each(function(index) {
					if(index==select_tab_index){
						jQuery(this).addClass("on");
					}else{
						if(jQuery(this).hasClass('on')){
							jQuery(this).removeClass("on");
						}
					}				
					
			});
			this.activeTab(select_tab_index);
			this.root.show();
			//alert(bodyHei);
			//alert(prodtypeHei);
			ShowDiv();
		},
		//++header  this.initSecond(this.data[i].childs, i);   在 header增加   var html
		initTabList: function(header) {
			var html = '<div class="_eject_product_list"><ul>';
			var len = this.data.length;  //获取 数目 并循环  
			for (var i = 0; i < len; i++) {
				html += '<li index="' + i + '" class="' + (i == this.tabIndx ? "on" : "") + '">' + this.data[i].name + '</li>';
				//   null
				if (this.data[i].childs) {
					this.initSecond(this.data[i].childs, i);
				}
			}
			html += "<ul></div>";

			header.append(html);
		},
		//		initSecond: function(data, index) (指向的是哪个 )
		initSecond: function(data,index) {
			//alert(reset)
			var html = '<div class="_eject_product_type" style="display:' + (index == this.tabIndx ? "block" : "none") + '">';
			var len = data.length;

			for (var i = 0; i < len; i++) {
				html += '<div class="_eject_condition_title" >' + data[i].name + '</div>';
				//添加 ul  循环li
				html += '<ul class="_eject_clearfix _eject_condition_list">';

				var childData =  data[i].childs;
				if(childData){
					for (var j = 0; j < childData.length; j++) {
						html += '<li dataid="'+childData[j].id+'">' + childData[j].name + '</li>';
					}
				}
				html += '</ul>';
			}


			this.root.append(html);
		},
		//追加按钮
		initToolbar: function() {
			this.root.append('<div class="_eject_submit_box"><div class="_eject_submit_buttom end_footer">我选好了</div></div>');
		},
		activeTab:function(index){
			var all_product_type = jQuery('._eject_product_type', this.root);
			//all_product_type.hide();  全部 隐藏   [index] 在显示
			all_product_type.hide();
			var activeObj = jQuery(all_product_type[index]);
			if(activeObj){
				activeObj.show();
			}
		},
		//点击事件  返回数据     下面的是 jQuery 方法   
		initEvent: function() {
			var me = this;
			// 因为不一定是 弹出的div 也可能是页面   所以要多写一个隐藏 
			jQuery('._eject_arrow_fl', this.root).click(function() {
				jQuery("._eject_more_product").hide();
				CloseDiv()
			});
			
			
			jQuery('._eject_product_list li', this.root).click(function() {
				//点击的时候 是哪个 index
				var index = jQuery(this).attr("index");
				jQuery('._eject_product_list li', this.root).removeClass('on');
				jQuery(this).addClass('on');
				//alert(index)
				me.activeTab(index);
			});
			
			
			jQuery('._eject_submit_buttom', this.root).click(function() {
				var returnVal = new Array();
				jQuery('._eject_condition_list .active', this.root).each(function(index) {
					var selectedObj = jQuery(this);
					var dataid = selectedObj.attr('dataid');
					returnVal[index]={"id":dataid,name:selectedObj.html()};
					
				});
				var len = $(".active").length;
				if(len>5){
					tan("最多选择5个");
					return false;
				}
				me.callback(returnVal); //返回格式[{id:1,name:""},{id:1,name:""},...]
				//alert(returnVal);
				CloseDiv();
			});

			//第三层 点击事件   电点击的元素 直接切换 class即可
			jQuery('._eject_condition_list li', this.root).click(function() {
				//jQuery('.condition_list li',this.root).toggleClass('active');
				jQuery(this).toggleClass('active');
			 });
			 	
		}
	}
})(jQuery);

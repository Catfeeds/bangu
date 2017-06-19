var index=1000;
;jQuery.cityList = function(options) {
	
	jQuery.extend(this, options);
	this.renderTo = jQuery(this.renderTo);
	this.cityRoot = jQuery('<div class="cityRoot"  style="display:none;"></div>').appendTo(this.renderTo);
	
	this.initCityList();
	this.initEvents();
};


jQuery.cityList.prototype = {
	data : [],
	type : 'json',//[{tabName:'国内城市',childs:[{"A":[{"id":1,"name":"阿拉善盟"},{"id":2,"name":"鞍山"}],"B":[{"id":3,"name":"北京"},{"id":4,"name":"保定"}]},{}]},{tabName:'国际城市',childs:[{},{}]}]
	index : 0,// 选中第几个TAB
	location : true,
	renderTo : 'body',
	initCityList : function() {
		this.initHeader();//头部
	},
	initHeader : function() {
		var city_head = jQuery('<header class="city_head"></header>').appendTo(this.cityRoot);
		this.initTab(city_head);
		this.initSearch(city_head);
		this.initSuggest();
		city_head.append('<i class="arrow_fl" ></i>');
	},
	initTab : function(city_head) {// 初始化地理位置
		var tabHtml = '<div class="city_tab"><ul class="clearfix">';
		var len = this.data.length;
		var css="";
		if(len==1){
			css='style="border-right:0px;width: 100%;"';
		}
		for(var i=0;i<len;i++){
			tabHtml += '<li idx='+i+' '+(i==this.index?'class="on"':'')+' '+css+'><a href="##"  >'+this.data[i].tabName+'</a></li>';
		}
		tabHtml += '</ul></div>';
		city_head.append(tabHtml);
		for(var i=0;i<len;i++){
			this.initTabList(this.data[i].childs,i);//tab对应的列表
		}
	},
	initSearch : function(city_head) {
		city_head.append('<div class="city_search"><input type="text" class="city_search_input" placeholder="请输入城市名称"></div>');
	},
	initTabList :function(city_data,index){
		this.cityList = jQuery('<div class="city_list" style="display:'+(index==this.index?'block':'none')+'" id="city_list_'+index+'"></div>').appendTo(this.cityRoot);
		this.initLocation(this.cityList);
		this.initAround(this.cityList);
		this.initContent(this.cityList,city_data,index);
	},
	initLocation : function(cityList) {// 初始化地理位置
		var now_city="";
		var now_city_id="";
		$.ajax({
			type:"GET",
			async : false, //important
			url:base_url+"common/get_my_position", //请求当前地理位置及id
			data:{},
			dataType:"json",
			success:function(data){
				now_city=data.city;
				now_city_id=data.city_id;
			},
			error:function(data){
				tan('请求失败');
			}
	    });
		
		 cityList.append('<div class="city_position"><div class="city_position_title">定位城市</div><div class="city_position_name"><span dataid='+now_city_id+'>'+now_city+'市</span></div></div>');
	},
	initAround : function(cityList) {// 初始化周边
		//cityList.append('<div class="city_surround"><div class="city_surround_title">周边城市</div><ul class="clearfix" id="around_city"><li n_id="233" onclick="city(this)">广州市</li><li n_id="234" onclick="city(this)">韶关市</li><li n_id="235" onclick="city(this)">深圳市</li><li n_id="236" onclick="city(this)">珠海市</li><li n_id="237" onclick="city(this)">汕头市</li><li n_id="238" onclick="city(this)">佛山市</li><li n_id="239" onclick="city(this)">江门市</li><li n_id="240" onclick="city(this)">湛江市</li><li n_id="241" onclick="city(this)">茂名市</li><li n_id="242" onclick="city(this)">肇庆市</li><li n_id="243" onclick="city(this)">惠州市</li><li n_id="244" onclick="city(this)">梅州市</li><li n_id="245" onclick="city(this)">汕尾市</li><li n_id="246" onclick="city(this)">河源市</li><li n_id="247" onclick="city(this)">阳江市</li><li n_id="248" onclick="city(this)">清远市</li><li n_id="249" onclick="city(this)">东莞市</li><li n_id="250" onclick="city(this)">中山市</li><li n_id="251" onclick="city(this)">潮州市</li><li n_id="252" onclick="city(this)">揭阳市</li><li n_id="253" onclick="city(this)">云浮市</li></ul></div>');
	},
	initContent:function(cityList,city_data,index){
		var len = city_data.length;
		var html='<div class="city_list_content">';
		
		var letter = '<div class="city_side" id="letter_nav'+index+'" style="display:'+(index==this.index?'block':'none')+'"  ><ul>'
		
		for(var i=0;i<len;i++){
			if(city_data[i]){
				html+='<div class="city_item">';
				html+='<div class="city_item_title" id="'+city_data[i].name+index+'">'+city_data[i].name+'</div>';
				html+='<ul>';
				if(city_data[i].childs){
					for(var j=0;j<city_data[i].childs.length;j++){
						html+='<li dataid="'+city_data[i].childs[j].id+'">'+city_data[i].childs[j].name+'</li>';
					}
				}
				letter += '<li><a href="##" dataid="'+city_data[i].name+index+'" >'+city_data[i].name+'</a></li>'
				html+='</ul>';
				html+='</div>';
			}
		}
		letter += '</ul></div>'
		html+='</div>';
		cityList.append(html);
		this.cityRoot.append( letter );
	},
	initSuggest:function(){
		this.cityRoot.append( '<div class="search_city_list"><ul class="clearfix"></ul></div>' );
	},
	show:function(){
		this.cityRoot.show();
		$(".search_city_list",this.cityRoot).hide();
		$(".city_search_input", this.cityRoot).val('');
		var selected_idx = $(".city_tab",this.cityRoot).find('.on').attr('idx');
		jQuery('#letter_nav'+selected_idx,this.cityRoot).show();
		jQuery('#city_list_'+selected_idx,this.cityRoot).show();
		
		var city_list = jQuery('.city_list');
		if(city_list && city_list.length>0){
			var winHeight = $(window).height();//窗口高度
			var top = city_list.offset().top;
			jQuery('.city_list',this.cityRoot).height(winHeight); //winHeight-top
			jQuery('.search_city_list',this.cityRoot).height(winHeight-top);
		}
	},
	initEvents:function(){
		var me = this;
		var cityRoot = this.cityRoot;
		var selected_idx=0;
		
		
		jQuery(".city_tab li", cityRoot).on("click", function(){
			jQuery(".city_tab", cityRoot).find('li').removeClass('on');
			var liObj = jQuery(this);
			liObj.addClass('on');
			selected_idx = liObj.attr('idx');
			jQuery(".city_list").hide();
			jQuery(".city_side").hide();
			jQuery('#letter_nav'+selected_idx).show();
			jQuery('#city_list_'+selected_idx).show();
		});
		
		jQuery(".city_side a", cityRoot).on("click", function(){
			var dataid = jQuery(this).attr('dataid');
			var target = jQuery('#'+dataid);
			if(target){
				var scrollTop = $(".city_list").scrollTop();
				var top = $(".city_list").offset().top;//页面距离
				$(".city_list").animate({scrollTop: target.position().top + scrollTop -top }, 200);
			}
		});
		
		jQuery(".city_list_content li", cityRoot).on("click", function(){
			if(me.select){
				me.select( $(this).attr("dataid"),$(this).html() );
			}
			cityRoot.hide();
		});
		jQuery(".city_position_name span", cityRoot).on("click", function(){
			if(me.select){
				me.select( $(this).attr("dataid"),$(this).html() );
			}
			cityRoot.hide();
		});
		
		jQuery(".cm_expert_header", cityRoot).on("click", function(){
			cityRoot.hide();
		});
		
		jQuery(".arrow_fl", cityRoot).on("click", function(){
			cityRoot.hide();
		});
		jQuery(".cm_expert_header", cityRoot).on("click", function(){
			cityRoot.hide();
		});
		
		/*============城市搜索==============*/
		$(".city_search_input", cityRoot).keyup(function() {
    	   $(".search_city_list ul").html("");
           var value = $(this).val();
           if (value) {
           		jQuery('#letter_nav'+selected_idx, cityRoot).hide();
    			jQuery('#city_list_'+selected_idx, cityRoot).hide();
           		me.queryCity(value,selected_idx);
           } else {
           		jQuery('#letter_nav'+selected_idx, cityRoot).show();
    			jQuery('#city_list_'+selected_idx, cityRoot).show();
           }
       });
		 
	  
	},
	queryCity:function(value,selected_idx){
		var data = this.data[selected_idx].childs;//当前选择的TAB数据
		var html = '';
		if(data){
			var len = data.length;
			for(var i=0;i<len;i++){
				var nodes = data[i];
				for(var j=0;j<nodes.childs.length;j++){
					var _data = nodes.childs[j].name;
					if(typeof (_data) != 'undefined'){
//	                    if( (_data[2] && _data[2].indexOf(value)) >= 0 || (_data[3] && _data[3].indexOf(value) >= 0) || (_data[1] && _data[1].indexOf(value) >=0) || (_data[0] && _data[0].indexOf(value) >=0) ){
						if(_data && _data.indexOf(value)>=0){
	                       html+='<li dataid="'+nodes.childs[j].id+'" class="suggest_item" >'+_data+'</li>';
	                    }
	                }
				}
			}
		}
		$(".search_city_list",this.cityRoot).show();
		if(html!=''){
			
			$(".search_city_list ul").append(html );
			var cityRoot = this.cityRoot;
			var me = this;
			jQuery('.suggest_item',cityRoot).on('click',function(event){
				if(me.select){
					me.select( $(this).attr("dataid"),$(this).html() );
				}
				cityRoot.hide();
		   });
		}
	}
}

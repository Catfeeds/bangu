;
(function(jQuery, window, func) {
	
	function selectToData(select){
		var _data=[];
		jQuery("option",select).each(function(index,option){
			if(option.value){
				_data.push({
					id : option.id || index,
					text : option.text || '',
					value : option.value || '',
					selectIndex : index
				});
			}
		});
		return _data;
	}
	
	jQuery.comboBox = function(settings) {
		var columns = settings.columns ? this.columns.concat(settings.columns) : this.columns;
		var query = settings.query ? this.query.concat(settings.query) : this.query;
		jQuery.extend(this, settings);
		this.columns = columns;
		this.query = query;
		var $this=this;
		
		$this.hidden=document.createElement("INPUT");
		$this.hidden.type="hidden";
		if($this.bindSelect){
			var targetSelect=jQuery($this.bindSelect);
			$this.data=selectToData(targetSelect);
			$this.hidden.name=targetSelect.attr("name");
			$this.hidden.id=targetSelect.attr("name");
		}else{
			$this.hidden.name=$this.name;
			$this.hidden.id=$this.name;
		}
		this.initComboBox();
		this.initData();
		//初始化事件
		this.initEvent();
		//初始布局
		this.initLayout();
		$this.el.after($this.hidden);
		$this.hidden=jQuery($this.hidden);
		
		if($this.loadAfter){
			$this.loadAfter();
		}
	};
	
	
	jQuery.comboBox.prototype = {
		renderTo : 'body',
		bindSelect : null,
		valueKey : "value",
		textKey : "text",
		readOnly : false,
		id : null,
		columns:[{ name:"text",align:"left"}],//显示字段 位置
		query:["text"],//查询字段
		css:{
			layer:"x-layer",
			combo_list:"x-boundlist",
			list:"x-list-plain",
			trigger:"x-form-trigger",
			list_item:"x-boundlist-item",
			list_item_hover : "x-combo-list-item-hover",
			text_focus:"x-form-focus"
		},
		data : [{text:'',value:'',id:''}],//下拉列表text,value必填字段
		options  : null,//列表类型默认下拉
		type : 'select',//search,select
		selectIndex : 0,//当前选中的索引
		scrollHeight : 300,//滚动条高度
		width : 160,
		el : null,
		loadAfter : function(args){},
		initComboBox:function(){
			var $this=this;
			//下拉列表dom对象
			$this.el=jQuery($this.id);
			//下拉输入框对象
			$this.el.text=jQuery($this.id);//jQuery(":text",$this.el);
			
			//下拉按钮			
			$this.el.arrow=jQuery("."+$this.css.arrow,$this.el);
			var combo_list=document.createElement("ul");
			$this.el.combo_list=jQuery(combo_list);
			
			combo_list.className =$this.css.list + ' '+ $this.css.combo_list;
			
			$this.el.combo_list.hide();
			$this.el.list=jQuery(combo_list);
			jQuery($this.renderTo).append(combo_list);
			
			
		},
		reload : function(data){
			var $this=this;
			$this.el.list.empty();
			$this.onReset();
			$this.data=data;
			$this.initData();
			//初始化事件
			//$this.initEvent();
			//初始布局
			$this.initLayout();
		},
		initData : function(){
			//alert("44343");
			var $this=this;
			//初始化数据
			if($this.data && $this.data.length>0 ){
				var list='';
				$this.options=[];
				for ( var i = 0; i < $this.data.length; i++){
					var item=$this.data[i];
					list+='<li class="'+$this.css.list_item +(i==0?" "+ $this.css.list_item_hover:"")+'" index="'+i+'">'+item[$this.textKey]+'</li>';
					$this.options.push(item);
				}
				$this.el.list.css("height","");
				$this.el.list.html(list);
			}
		},
		initLayout:function(){
			var $this=this;
			var comboText=$this.el.text;
			//减去按扭的宽度
			//comboText.width($this.width-17-8);
			//$this.renderTo.css("width","");
			$this.setComboListPosition();
		},

		beforeComboListShow:function(){
			$(".x-list-plain").hide();
		},

		onComboListShow:function(){
			var $this=this; 
			$this.setComboListPosition();
		},
		onComboListHide:function(){},
		setComboListPosition :function(){
			var $this=this;
			var comboText=$this.el.text;
			var comboList=$this.el.list;
			var comboListWidth=$this.el.text.outerWidth(true);//+$this.el.arrow.outerWidth(true)
			var position = $this.el.text.offset();
			var left = position?position.left:0;
			var top = position?position.top:0;
			//减边框
			comboList.width(comboListWidth);
			comboList.css("top",top+comboText.outerHeight(true) );
			comboList.css("left",left);
			if(comboList.height()>=$this.scrollHeight){
				comboList.height($this.scrollHeight);
			}
		},
		onQuery:function(keyword,keyCode){
			var $this=this;
			var comboList=$this.el.list;
			//本地查询
			//设置索引
			comboList.indexList=[];
			//设置选项
			$this.options=[];
			var list='';
			for ( var i = 0; i < $this.data.length; i++) {
				var item=$this.data[i];
				//匹配成功
				if($this.comparable(item,keyword)){
					list+=this.formatter(item);//'<li class="'+this.css.list_item+'" index="'+$this.options.length+'">'+item[$this.textKey]+'</li>';
					$this.options.push(item);
				}
			}
			$this.el.list.html(list);
			return true;
		},
		formatter : function(item){
			var  html = '<li class="'+this.css.list_item+'" index="'+this.options.length+'">';
			var columns = this.columns;
			var len = columns.length;
			for(var i=0;i<len;i++){
				html+='<span style="padding-right:10px;">'+item[columns[i].name]+'</span>';
			}
			html+="</li>";
			return html;
		},
		comparable:function(item,keyword){
			if(!keyword || ''==keyword){
				return true;
			}else{
				var keys = this.query;
				var len = keys.length;
				var flag = false;
				for(var i=0;i<len;i++){
					if((""+item[keys[i]]).toLowerCase().indexOf(keyword.toLowerCase())>-1 ){
						flag = true;
						break;
					}
				}
				return flag;
			}
		},
		selectedBefore:function(item,idx){
			var $this=this;
			$this.el.text.focus();
			$this.el.text.val(item[$this.textKey]);
			$this.el.list.hide();
			$this.onSelected(item,$this.selectIndex);
		},
		onSelected:function(item,idx){
			if(!item){
				this.hidden.val("");
				this.el.text.val("");
			}else{
				this.hidden.val(item[this.valueKey]);
			}
			this.selectedAfter(item,this.selectIndex);
		},
		selectedAfter:function(item,idx){
			//alert(1);
		},
		blurAfter:function(item,idx){},
		onReset:function(){ this.onSelected(null); },
		initEvent:function(){
			var $this=this;
			var comboText=$this.el.text;
			var comboArrow=$this.el.arrow;
			var comboList=$this.el.list;
			
			
			jQuery(document).click(function(event){
				if(event.target.tagName.toUpperCase() != "TD"){
					jQuery("."+$this.css.combo_list).hide();
				}
			});
			
			comboText.click(function(event){
				//alert("3333333333");
				event.stopPropagation();
				$this.selectIndex=0;
				//comboText.addClass($this.css.text_focus);
				comboList.css("height","");	
				if(comboList.height()>=$this.scrollHeight){
					comboList.height($this.scrollHeight);
				}
				if(comboText.val()==''){
					jQuery('.'+$this.css.list_item,comboList).removeClass($this.css.list_item_hover);
					jQuery('.'+$this.css.list_item+':eq(0)',comboList).addClass($this.css.list_item_hover);
				}else{
					//查询
					if($this.onQuery(comboText.val(),event.keyCode)==true){
						$this.selectIndex=0;
						comboList.css("height","");	
						if(comboList.height()>=$this.scrollHeight){
							comboList.height($this.scrollHeight);
						}
						jQuery('.'+$this.css.list_item,comboList).removeClass($this.css.list_item_hover);
						jQuery('.'+$this.css.list_item+':eq(0)',comboList).addClass($this.css.list_item_hover);
					}
				}
				$this.beforeComboListShow();
				comboList.show();
				$this.onComboListShow();
			});
//			comboText.focus(function(event){
				// $this.beforeComboListShow();
				// comboList.show();
				// $this.onComboListShow();
//			});
			comboText.blur(function(event){
				jQuery(this).removeClass($this.css.text_focus);
				setListItemSelected($this.selectIndex);
				$this.blurAfter($this.options[$this.selectIndex],$this.selectIndex);
				comboText.removeClass($this.css.text_focus);
			});
			jQuery(comboText).closest("form").bind("reset", function(event) {
				$this.onReset();
			});
			
			function setListItemSelected(index){
				$this.selectIndex=index;
				jQuery('.'+$this.css.list_item,comboList).removeClass($this.css.list_item_hover);
				jQuery('.'+$this.css.list_item+':eq('+index+')',comboList).addClass($this.css.list_item_hover);
				//设置滚动条
				if(index>0){
					var height=jQuery('.'+$this.css.list_item+':eq('+index+')',comboList).outerHeight(true);
					//计算滚动坐标
					var top=(index+1) * height - comboList.scrollHeight;
					if(top>0){
						comboList.scrollTop(top);
					}
				}
				else
				{
					comboList.scrollTop(0);
				}
			}
			
			function getSelectIndex(type){
				if(comboList.css("display")=="none"){
					setListItemSelected($this.selectIndex);
				}else if(type=="up"){
					if($this.selectIndex>0){
						setListItemSelected(--$this.selectIndex);
					//溢出
					}else{
						$this.selectIndex=$this.options.length-1;
						setListItemSelected($this.selectIndex);
					}
				}else if(type=="down"){
					if($this.options.length-1>$this.selectIndex){
						setListItemSelected(++$this.selectIndex);
					//溢出
					}else{
						$this.selectIndex=0;
						setListItemSelected($this.selectIndex);
					}
				}
				$this.beforeComboListShow();
				comboList.show();
				$this.onComboListShow();
			}
			
			if($this.readOnly==false){
				comboText.keyup(function(event){
					event.stopPropagation();
					if(event.keyCode==40){//下
						getSelectIndex("down");
					}else if(event.keyCode==38){//上
						getSelectIndex("up");
					}else if(event.keyCode==13 ){//回车 选中comboList.css("display")!="none"
						$this.selectedBefore($this.options[$this.selectIndex],$this.selectIndex);
					}else{
						if(event.keyCode==8){//回退 的时候清空隐藏ID
							$this.hidden.val("");
						}
						var keywords=jQuery.trim(this.value);
						if(keywords==""){
							$this.onSelected(null,null);
						}
						//查询
						if($this.onQuery(keywords,event.keyCode)==true){
							$this.selectIndex=0;
							comboList.css("height","");	
							if(comboList.height()>=$this.scrollHeight){
								comboList.height($this.scrollHeight);
							}
							jQuery('.'+$this.css.list_item,comboList).removeClass($this.css.list_item_hover);
							jQuery('.'+$this.css.list_item+':eq(0)',comboList).addClass($this.css.list_item_hover);

							$this.beforeComboListShow();
							comboList.show();
							$this.onComboListShow();
						}
					}
				});
			}
			/*comboArrow.click(function(event){
				event.stopPropagation();
				if($this.el.val()==''){
					$this.selectIndex = 0;
				}else{
					$this.selectIndex = $this.selectIndex == -1 ? 0 : $this.selectIndex;	
				}
				
				if(comboList.is(":hidden")){
					$this.onComboListShow();
					comboList.show();
				}else{
					$this.onComboListHide();
					comboList.hide();
				}
				setListItemSelected($this.selectIndex);
				comboText.focus();
			});*/
			//移入按钮效果
//			comboArrow.hover(function(event){
//				jQuery(this).addClass(CSS.arrow_focus);
//			},function(event){
//				jQuery(this).removeClass(CSS.arrow_focus);
//			});
			
//			jQuery($this.page).on("click", ".page_num",function(){
			var list_item = "."+this.css.list_item;
			//列表选择效果
			jQuery(comboList).on("mouseover",list_item,function(event){
				var index=jQuery(this).attr("index");
				$this.selectIndex=index;
				jQuery(list_item,comboList).removeClass($this.css.list_item_hover);
				jQuery(this).addClass($this.css.list_item_hover);
			});
			
			jQuery(comboList).on("mouseout",list_item,function(event){
				jQuery(this).removeClass($this.css.list_item_hover);
			});
			
			jQuery(comboList).on("click",list_item,function(event){
				event.stopPropagation();
				var index=jQuery(this).attr("index");
				$this.selectIndex=index;
				$this.selectedBefore($this.options[index],$this.selectIndex);
			});
			
			
		}
	};
	
	if (jQuery.ext && jQuery.ext.plugin && jQuery.ext.plugin.comboBox) {
		jQuery.ext.plugin.comboBox();
	}
})(jQuery, window);
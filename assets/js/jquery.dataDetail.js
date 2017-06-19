;(function($, window, document,undefined) {
    var Detail = function(element, opt) {
        this.element = element,
        this.defaults = {
        	width:'700',//款度
        	boxClass:'detail-box',//弹出层的class
        	butClass:'db-buttons',//按钮处Class
        	conClass:'db-content',
        	cateClass:'db-category',
        	rowDataClass:'db-data-row',
        	rowClass:'db-row',
        	rowTitleClass:'db-row-title',
        	rowConClass:'db-row-content',
        	closeClass:'detail-close',
        	tableClass:'table-data',
        	title:'标题名称',
        	jsonData:{},
        	maxWidth:500,
        	isSimple:true,//是否是简单版本 true:是    false:否 , 复杂版本将数据分类展示
        	butDatas:{},//按钮 {'through':'通过' ,'refuse':'拒绝'} class名 =>名称
        	butClick:function(){}//按钮的点击事件
        },
        this.options = jQuery.extend({}, this.defaults, opt)
    };
    Detail.prototype = {
    	createBox:function(){
    		var html = '<div class="'+this.options.boxClass+'"><div class="db-body">';
    		html += '<div class="db-title"><h4>'+this.options.title+'</h4><div class="db-close '+this.options.closeClass+'">x</div></div>';
    		html += '<div class="'+this.options.conClass+'"></div>';
    		html += '</div></div>';
    		this.element.append(html);
    	},
    	showData:function(){
    		var conObj = this.element.find('.'+this.options.conClass);
    		if (this.options.isSimple === true) {
    			conObj.append('<ul class="db-row-body">'+this.eachSimpleData()+'</ul>');
    		} else {
    			conObj.append('<ul>'+this.eachJsonData()+'</ul>');
    		}
    	},
    	eachJsonData:function(){//复杂版本数据循环输出
    		var html = '';
    		var thisObj = this;
    		jQuery.each(thisObj.options.jsonData ,function(key ,val){
    			html += '<li class="'+thisObj.options.cateClass+'"><h4>'+val.title+'</h4>';
    			if (val.type == 'list')
    			{
    				html += '<ul>'
    				jQuery.each(val.data ,function(index ,item){
    					//li占用整行还是一半
    	    			var liClass = item.isComplete == true ? thisObj.options.rowClass : thisObj.options.rowDataClass;
    	    			//展示类型
    	    			var type = typeof item.type == 'undefined' ? 'text' : item.type;
    	    			html += '<li class="'+liClass+'"><div class="'+thisObj.options.rowTitleClass+'">'+item.title+'：</div>';
    	    			html += '<div class="'+thisObj.options.rowConClass+'">'+thisObj.getTypeHtml(type ,item.val)+'</div>';
    				})
    				html += '</ul>';
    			}
    			else if (val.type == 'table')
    			{
    				html += thisObj.createTable(val.data);
    			}
    			html += '</li>';
    		})
    		return html;
    	},
    	eachSimpleData:function(){//简单版本数据循环输出
    		var html = '';
    		var thisObj = this;
    		jQuery.each(thisObj.options.jsonData ,function(key ,item){
    			//li占用整行还是一半
    			var liClass = item.isComplete == true ? thisObj.options.rowClass : thisObj.options.rowDataClass;
    			//展示类型
    			var type = typeof item.type == 'undefined' ? 'text' : item.type;
    			html += '<li class="'+liClass+'"><div class="'+thisObj.options.rowTitleClass+'">'+item.title+'：</div>';
    			html += '<div class="'+thisObj.options.rowConClass+'">'+thisObj.getTypeHtml(type ,item.val)+'</div>';
    		})
    		return html;
    	},
    	createTable:function(data) {
    		if (typeof data[0] == 'undefined')
    		{
    			var html = '无';
    		}
    		else
    		{
    			var html = '<table class="'+this.options.tableClass+'"><thead><tr>';
        		jQuery.each(data[0] ,function(key ,val){
        			html += '<th>'+key+'</th>';
        		})
        		html += '</tr></thead>';
        		jQuery.each(data ,function(key ,val){
        			html += '<tr>';
        			jQuery.each(val ,function(k ,v) {
        				html += '<td>'+v+'</td>';
        			})
        			html += '</tr>';
        		})
        		html += '</table>';
    		}
    		return html;
    	},
    	getTypeHtml:function(type ,content) { //按展示类型输出html  类型如：img ,text ,input ,textarea
    		if(type == 'text')
    		{
    			return content;
    		}
    		else if (type == 'img')
    		{
    			return '<img src="'+content+'" />';
    		}
    		else if (type == 'input')
    		{
    			var defVal = typeof content.defaultVal == 'undefined' ? '' : content.defaultVal;
    			var placeholder = typeof content.placeholder == 'undefined' ? '' : content.placeholder;
    			return '<input type="text" name="'+content.name+'" placeholder="'+placeholder+'" value="'+defVal+'" />';
    		}
    		else if (type == 'textarea')
    		{
    			var defVal = typeof content.defaultVal == 'undefined' ? '' : content.defaultVal;
    			var placeholder = typeof content.placeholder == 'undefined' ? '' : content.placeholder;
    			return '<textarea name="'+content.name+'" placeholder="'+placeholder+'">'+defVal+'</textarea>';
    		}
    	},
    	createButton:function(){ //生成按钮
    		var html = '';
    		var thisObj = this;
    		if (!jQuery.isEmptyObject(thisObj.options.butDatas)) {
    			jQuery.each(thisObj.options.butDatas ,function(key ,val){
    				html += '<div class="'+key+'" data-val="'+thisObj.options.id+'">'+val+'</div>';
    			})
    		}
    		this.element.find('.'+this.options.conClass).append('<div class="'+this.options.butClass+'"><div class="'+this.options.closeClass+'">关闭</div>'+html+'</div>');
    	},
    	closeBox:function(){ //关闭
    		var thisObj = this;
    		thisObj.element.find('.'+thisObj.options.closeClass).click(function(){
    			thisObj.element.find('.'+thisObj.options.boxClass).hide();
    			thisObj.element.find('.maskLayer').hide();
    		})
    	},
    	createMaskLayer:function(){ //生成遮罩层
    		if (this.element.find('.maskLayer').length == 0){
    			this.element.append('<div class="maskLayer"></div>');
    			this.element.find('.maskLayer').css({'position': 'absolute','width':'100%','height':'100%','background':'#fff','top':'0px','left':'0px','z-index':'96','opacity':'0.5','filter':'alpha(opacity=50)'});
    		}
    	},
    	imgPreview:function(){
    		var thisObj = this;
    		thisObj.element.find('img').parent().hover(function(){
    			var src = jQuery(this).find('img').attr('src');
    			var offsetLeft = jQuery(this).find('img').offset().left; //到窗口左边的距离
    			var offsetTop = jQuery(this).find('img').offset().top; //到窗口上边的距离
    			var imgWidth = jQuery(this).find('img').width(); //当前元素的宽度
    			var imgHeight = jQuery(this).find('img').height(); //当前元素的高度
    			var width = jQuery(window).width();//浏览器的宽度
    			var height = jQuery(window).height();//浏览器高度
    			
    			
    			var image = new Image()
    		    image.src = src
    		    var previewWidth = image.width;//图片的宽
    			var previewHeight = image.height;//图片的高

    			if (previewWidth > thisObj.options.maxWidth) {
    				previewHeight = Math.round(previewHeight * (thisObj.options.maxWidth /previewWidth));
    				previewWidth = thisObj.options.maxWidth;
    			}
    			var left = offsetLeft + imgWidth; //大图到左边的距离
    			var top = offsetTop;//大图到顶部的距离

    			if (left + previewWidth > width) {
    				left = offsetLeft - previewWidth;
    			}
    			if (left < 0) {
    				left = 0;
    			}
    			if (top + previewHeight > height) {
    				top = offsetTop + imgHeight - previewHeight;
    			}
    			if (top < 0) {
    				top = 0;
    			}
    			
    			if (jQuery(this).find('.img-preview').length == 0) {
    				jQuery(this).append('<div class="img-preview"><img src="'+src+'" /></div>');
    			} else {
    				jQuery(this).find('.img-preview').find('img').attr('src' ,src);
    			}
    			
    			jQuery(this).find('.img-preview').css({'position': 'fixed','top': top+'px','left':left+'px','z-index': '100'}).show().find('img').css({'width':previewWidth,'height':previewHeight});
    		},function(){
    			jQuery(this).find('.img-preview').hide();
    		});
    		
    	}
    };
    jQuery.fn.dataDetail = function(options) {
    	if (jQuery.isEmptyObject(options.jsonData)) {
    		console.log('缺少必要参数jsonData');
    	} else {
    		var detail = new Detail(this, options);
    		this.html('');
    		detail.createBox();
        	detail.showData();
        	detail.createButton();
        	detail.createMaskLayer();

        	this.find('.'+detail.options.boxClass).show();
        	if(this.find('.db-row-body').length == 0) {
        		jQuery.each(this.find('.'+detail.options.cateClass),function(){
        			if (jQuery(this).find('ul').length > 0) {
        				jQuery.each(jQuery(this).find('ul').find('li:even'),function(){
        					var height = jQuery(this).height();
                			jQuery(this).next().css('min-height',height);
        				})
//        				jQuery.each(jQuery(this).find('ul').find('li:odd'),function(){
//        					var height = jQuery(this).height();
//                			jQuery(this).prev().css('min-height',height);
//        				})
        			}
        		});
        	} else {
        		jQuery.each(this.find('.db-row-body').find('li:even'),function(index ,item){
        			var height = jQuery(this).height();
        			jQuery(this).next().css('min-height',height);
        			//console.log(height);
        		});
//        		jQuery.each(this.find('.db-row-body').find('li:odd'),function(index ,item){
//        			var height = jQuery(this).height();
//        			
//        			jQuery(this).prev().css('min-height',height);
//        		})
        	}
        	detail.closeBox();
        	detail.imgPreview();
        	detail.options.butClick(this);
    	}
    }
})(jQuery, window, document);
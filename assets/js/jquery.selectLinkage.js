;(function($, window, document,undefined) {
	var Linkage = function(element ,opts){
		this.element = element,
	    this.defaults = {
			width:'140px',//select标签宽度
			jsonData:{},/*json格式数据
			 			 * {0:defaultArr:
			 			 * 		{0:{id:9,name:'广东'},10:{id:13,name:'湖北'}},
			 			 *  9:{0:{id:90,name:'深圳'},1:{id:89,name:'广州'}},
			 			 *  13:{0:{id:110,name:'恩施'},1:{id:111,name:'武汉'}}
			 			 * }
			 			 */
			callback:function(){return false;},//回调函数
			names:['country','province','city','region']//select元素name值
	    },
	    this.options = jQuery.extend({}, this.defaults, opts)
	};
	Linkage.prototype = {
		createDefatulSel:function(){
			//创建select元素
			var html = '';
			var width = this.options.width;
			jQuery.each(this.options.names ,function(key ,val) {
				html += '<select name="'+val+'" style="width:'+width+'" ><option value="0">请选择</option></select>';
			});
			this.element.html(html);
			this.element.find('select').eq(0).nextAll('select').hide();
			//遍历首层数据
			this.element.find('select').first().append(this.getOptionsHtml(this.options.jsonData.defaultArr));
		},
		getOptionsHtml:function(data) {
			if (typeof data == 'undefined') {
				return false;
			}
			var html = '';
			jQuery.each(data ,function(key,val) {
				html += '<option value="'+val.id+'">'+val.name+'</option>';
			})
			return html;
		},
		getLower:function(obj) {
			var id = jQuery(obj).val();
			if (id == 0 || typeof(this.options.jsonData[id]) == 'undefined') {
				jQuery(obj).nextAll('select').hide().html('');
			} else {
				if (jQuery(obj).next('select').length == 1) {
					jQuery(obj).next('select').show().html('<option value="0">请选择</option>').nextAll('select').hide().html('');
					jQuery(obj).next('select').append(this.getOptionsHtml(this.options.jsonData[id]));
				}
			}
		}
	};
	jQuery.fn.selectLinkage = function(options) {
    	var linkage = new Linkage(this, options);
    	linkage.createDefatulSel();
    	jQuery(this).find('select').change(function(){
    		linkage.getLower(this);
    		linkage.options.callback(this);
    	});
    }
})(jQuery, window, document);
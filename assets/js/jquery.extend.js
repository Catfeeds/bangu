;(function($, window, document,undefined) {
	jQuery.fn.extend({
		//替换字符
		replaceStr:function(str) {
			
		},
		//验证整数，小数
		verifNum:function(opts) {
			var defaults = {
					maxNum:false,//最大值
					minNum:false,
					digit:0,//小数位
					isNegative:false,//是否可以为负数
					callback:function(){return false;}
			};
			var options = jQuery.extend({}, defaults, opts);
			var thisObj = this;
			thisObj.keyup(function(e){
				var number = thisObj.val();
				if (options.isNegative == true) {
					//可以为负数
					var firstStr = number.substring(0,1);
					if (firstStr == '-') {
						number = number.substring(1);
					}
				}
				//console.log(33);
				if (options.digit == 0) {
					//替换非法字符
					
					if (number.indexOf('.') != '-1') {
						number = number.substring(0,number.indexOf('.'));
					}
					
					number = number.replace(/[^\d]/g,'');
				} else if(options.digit > 0) {
					//替换非法字符
					number = number.replace(/[^\d.]/g,'');
					//console.log(number);
					//用.号分割字符串，计算.的个数
					if (number.split('.').length > 1) {
						//将多余的.替换掉
						number = number.substring(0,number.indexOf('.')+1)+number.substring(number.indexOf('.')+1).replace('.','');
					}
					if (number.indexOf('.') > 0){
						number = number.substring(0,number.indexOf('.')+1+options.digit);
					}
					
				} else {
					console.log('小数位是正整数');
					return false;
				}
				
				var first = number.substring(0,1);
				if (first == 0 && number.substring(1,2) != '.' && e.keyCode != 8) {
					if (number > 0) {
						number = number.substring(1,2);
					}
				} else if(first == '.') {
					number = 0+first;
				}
				
				if (options.maxNum !== false && number*1 > options.maxNum) {
					number = options.maxNum;
				}
				
				if (options.isNegative == true && firstStr == '-') {
					var absMin = Math.abs(options.minNum);
					if (options.minNum !== false && number > absMin) {
						number = absMin;
					}
					number = '-'+number;
				}
				
				thisObj.val(number);
				options.callback();
			})
		},
		//图片预览
		imgPreview:function(){
    		jQuery(this).hover(function(){
    			var src = jQuery(this).attr('src');
    			var offsetLeft = jQuery(this).offset().left; //到窗口左边的距离
    			var offsetTop = jQuery(this).offset().top; //到窗口上边的距离
    			var imgWidth = jQuery(this).width(); //当前元素的宽度
    			var imgHeight = jQuery(this).height(); //当前元素的高度
    			var width = jQuery(window).width();//浏览器的宽度
    			var height = jQuery(window).height();//浏览器高度
    			
    			var image = new Image()
    		    image.src = src
    		    var previewWidth = image.width;
    			var previewHeight = image.height;

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
    			
    			if (jQuery(this).next('.img-preview').length == 0) {
    				jQuery(this).after('<div class="img-preview"><img src="'+src+'" /></div>');
    			} else {
    				jQuery(this).next('.img-preview').find('img').attr('src' ,src);
    			}
    			
    			jQuery(this).next('.img-preview').css({'position': 'fixed','top': top+'px','left':left+'px','z-index': '100'}).show().find('img').css({'width':previewWidth,'height':previewHeight});
    		},function(){
    			jQuery(this).next('.img-preview').hide();
    		});
		},
		//检查日期格式是否正确
		isDate:function() {
			jQuery(this).keyup(function(event){
				if (event.keyCode == 8) {
					return false;
				}
				var date = jQuery(this).val().replace(/[^\d\-]/g ,'');
				var dateLen = date.length;
				if (dateLen <= 4) {
					date = date.replace(/[^\d]/g,'');
					if (dateLen == 4) {
						if (date < 1900) {
							date = 1900;
						} else if (date > 2099) {
							date = 2099;
						}
						date = date+'-';
					}
				} else if (dateLen == 5) {
					if (date.substring(4 ,5) != '-') {
						date = date.substring(0,4)+'-';
					}
				} else if (dateLen == 6) {
					var str = date.substring(5,6);//第六个字符
					if (str == '-') {
						date = date.substring(0,5);
					} else if (str != 1 && str !=0) {
						date = date.substring(0,5)+'0'+str+'-';
					}
				} else if (dateLen == 7) {
					var lastStr = date.substring(6,7);
					var str = date.substring(5,6);
					if (lastStr == '-') {
						date = date.substring(0,6);
					} else if ((str == 1 && lastStr >2) || (str == 0 && lastStr == 0)) {
						date = date.substring(0,6);
					} else {
						date = date+'-';
					}
				} else if(dateLen == 8) {
					if (date.substring(7 ,8) != '-') {
						date = date.substring(0,7)+'-';
					}
				} else if (dateLen == 9) {
					var lastStr = date.substring(8,9);
					if (lastStr == '-') {
						date = date.substring(0,8);
					} else if (lastStr > 3) {
						date = date.substring(0,8)+'0'+date.substring(8,9);
					}
				} else {
					var lastStr = date.substring(9,10);
					var str = date.substring(8,9);
					if (lastStr == '-') {
						date = date.substring(0,9);
					} else if ((str == 0 && lastStr == 0) || (str == 3 && lastStr > 1)) {
						date = date.substring(0,9);
					}
					date = date.substring(0,10);
					if (!/^((19[2-9][0-9])|(20[0-9][0-9]))-((0[1-9])|(1[0-2]))-((0[1-9])|([12][0-9])|(3[01]))$/.test(date)) {
						date = '';
					}
				}
				//console.log(date);
				jQuery(this).val(date);
			});
			jQuery(this).blur(function(){
				var date = $(this).val();
				var dateLen = date.length;
				if (dateLen == 9) {
					date = date.substring(0,8)+'0'+date.substring(8,9);
				} else if (dateLen < 9) {
					date = '';
				}
				jQuery(this).val(date);
			})
		}
	});
})(jQuery, window, document);
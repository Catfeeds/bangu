(function($){
	$.browser = {};
	$.browser.mozilla = /firefox/.test(navigator.userAgent.toLowerCase()); 
	$.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase()); 
	$.browser.opera = /opera/.test(navigator.userAgent.toLowerCase()); 
	$.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());
	/**
	 * options {
	 *  sort:true,排序三级展示
	 *  sortLableWidth:第二季宽度
	 *  index:1,默认充第一个开始
	 *  doubleRow:true,二行展示
	 *  doubleRowWidth:默认41%
	 *  
	 * }
	 */
    $.querycity = function(input,options){
        var input = $(input);
        input.attr('autocomplete','off');
        if($.trim(input.val())=='' || $.trim(input.val())==options.defaultText){ 
            input.val(options.defaultText).css('color','#aaa');
        }
        var t_pop_focus = false;
        var t_suggest_focus = false;
        var t_suggest_page_click = false;
        var pop_city_obj = jQuery("#pop_city_"+input.attr('id'));
        if(pop_city_obj){
        	pop_city_obj.remove();
        }
        
        var suggest_city_obj = jQuery("#suggest_city_"+input.attr('id'));
        if(suggest_city_obj){
        	suggest_city_obj.remove();
        }
        $('body').append("<div id='pop_city_"+input.attr('id')+"' class='pop_city' style='display:none'><div class='pop_head'><p class='pop_head_text'></p><i class='ico-close' ></i></div><ul class='list_label'></ul><div class='pop_city_container'></div></div>");
        $('body').append("<div id='suggest_city_"+input.attr('id')+"' class='list_city' style='display:none'><div class='list_city_head'></div><div class='list_city_container'></div><div class='page_break'></div></div>");
        
        var popMain = $("#pop_city_"+input.attr('id'));
        
        if(options.width){
        	popMain.css({width:options.width});
        }
        var popContainer = popMain.find('.pop_city_container');
        var labelMain = popMain.find('.list_label');
        var suggestMain = $("#suggest_city_"+input.attr('id'));
        popMain.bgIframe();
        suggestMain.bgIframe();
        if(options.type=='json'){
        	popInitJson();
        }else{
        	popInit();
        }
        
        resetPosition(); 	    
        
        $(window).resize(function(){
            resetPosition();
        });        
        
        input.focus(function(){
        	resetPosition();
            if(t_suggest_page_click){
                t_suggest_page_click = false;
                return true;
            }
            suggestMain.hide();
		    if($.trim($(this).val())==options.defaultText){
			    $(this).val('').css('color','#000');
	    	}
		    popMain.show();
        }).click(function(){	
        	
            if(t_suggest_page_click){
                t_suggest_page_click = false;
                return;
            }
            suggestMain.hide();
		    popMain.show();		
	    }).blur(function(){				
		    if(t_pop_focus == false){
			    popMain.hide();				
			    if($.trim(input.val())=='' || $.trim(input.val())==options.defaultText){				
				    input.val(options.defaultText).css('color','#aaa');
			    }
		    }
	    });
        labelMain.on('click','a',function(){	
		    input.focus();//使焦点在输入框，避免blur事件无法触发
		    t_pop_focus = true;
		    var labelId = $(this).attr('id');
		    labelMain.find('li a').removeClass('current');
		    $(this).addClass('current');
		    popContainer.find('.tab').hide();
		    $("#"+labelId+'_container').show();
		    return false;
	    });
        
        
        popMain.find('.ico-close').click(function(){
        	popMain.hide();
        });
        
        
//	    popContainer.on('click',"a",function(){
//	    	if(!options.onchange){
//	    		input.val($(this).html());
//        	}else{
//        		input.val('');
//        		options.onchange( $(this).attr("dataid"),$(this).html() );
//        		alert('click a ');
//        	}
//	    	input.change();
//	    	if(!options.multiSelect){
//	    		popMain.hide();
//	    	}
//	    });
	    
	    popContainer.on('click',".city_item",function(){
	    	if(!options.onchange){
	    		input.val($(this).html());
        	}else{
        		input.val('');
        		options.onchange( $(this).attr("dataid"),$(this).html() );
        	}
	    	input.change();
	    	if(!options.multiSelect){
	    		popMain.hide();
	    	}
	    	return false;
	    });
	    
	    
	    
	    popMain.mouseleave(function(){
	    	popMain.hide();
	    });
	    
	    popMain.mouseover(function(){	
		    t_pop_focus = true;
		    
	    }).mouseout(function(){	
		    t_pop_focus = false;
		    
	    });

        input.blur(function(){
		    if( t_suggest_focus == false ){
			    if($(this).val()==''){
				    $(this).val( suggestMain.find('.list_city_container a.selected').children('b').text());
			    }
			suggestMain.hide();
		    }
        }).keydown(function(event){
            popMain.hide();
    		event = window.event || event;
	    	var keyCode = event.keyCode || event.which || event.charCode;		
	    	console.log( keyCode );
		    if (keyCode == 37) {//左
                prevPage();    
            } else if (keyCode == 39) {//右
                nextPage();
            }else if(keyCode == 38){//上
                prevResult();
            }else if(keyCode == 40){//下
                 nextResult();
            }
    	}).keypress(function(event){
            event = window.event || event;
            var keyCode = event.keyCode || event.which || event.charCode;
            if(13 == keyCode){
            	if(suggestMain.find('.list_city_container a.selected').length > 0){
                	var selected = suggestMain.find('.list_city_container a.selected')
                	var selectedText = selected.children('b');
                	if(!options.onchange){
                		input.val(selected.attr("dataid"),selectedText.text());
                	}else{
                		input.val('');
                		options.onchange(selected.attr("dataid"),selectedText.text() );
                	}
                    suggestMain.hide();
                    return false;
                }
            }
        }).keyup(function(event){
            event = window.event || event;
            
            var keyCode = event.keyCode || event.which || event.charCode;        
            if(keyCode != 13 && keyCode != 37 && keyCode != 39 && keyCode !=9 && keyCode !=38 && keyCode !=40 ){
			    //keyCode == 9是tab切换键
                queryCity(); 
            }
        });
      
        suggestMain.on('click','.list_city_container a',function(){
        	if(!options.onchange){
        		input.val($(this).children('b').text());
        	}else{
        		input.val('');
        		options.onchange($(this).attr("dataid"),$(this).children('b').text() );
        	}
        	suggestMain.hide();
        	return false;
        })
        suggestMain.on('mouseover','.list_city_container a',function(){
            t_suggest_focus = true;        
        })
        suggestMain.on('mouseout','.list_city_container a',function(){
            t_suggest_focus = false;
        });
        
        suggestMain.on('mouseover','.page_break a',function(){
            t_suggest_focus = true;        
        })
        
        suggestMain.on('mouseout','.page_break a',function(){
            t_suggest_focus = false;
        });
	    suggestMain.on('click','.page_break a',function(event){
            t_suggest_page_click = true;
            input.click();
		    if($(this).attr('inum') != null){
			    setAddPage($(this).attr('inum'));
    		}
	    });
	    
	   
        function nextPage(){
              var add_cur= suggestMain.find(".page_break a.current").next();
                if (add_cur != null) {                
                    if ($(add_cur).attr("inum") != null) {
                        setAddPage($(add_cur).attr("inum"));
                    }
                }
        }
        function prevPage(){
                var add_cur = suggestMain.find(".page_break a.current").prev();
                if (add_cur != null) {
                    if ($(add_cur).attr("inum") != null) {
                        setAddPage($(add_cur).attr("inum"));
                    }
                }
        }
        function nextResult(){
                  var t_index = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a.selected')[0]);
                    suggestMain.find('.list_city_container').children().removeClass('selected');          
                    t_index += 1;
                    var t_end =  suggestMain.find('.list_city_container a').index( suggestMain.find('.list_city_container a:visible').filter(':last')[0]);
                    if(t_index > t_end ){
                        t_index = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a:visible').eq(0));
                    } 
                    suggestMain.find('.list_city_container a').eq(t_index).addClass('selected'); 
        }
        function prevResult(){
                var t_index = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a.selected')[0]);
                suggestMain.find('.list_city_container').children().removeClass('selected');
                t_index -= 1;
                var t_start = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a:visible').filter(':first')[0]);
                if( t_index < t_start){
                    t_index = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a:visible').filter(':last')[0]);
                }
                suggestMain.find('.list_city_container a').eq(t_index).addClass('selected');      
        }
    	function loadCity(){		
	    	var cityList = suggestMain.find('.list_city_container');		
		    cityList.empty();
            if(options.hotList){
                var hotList = options.hotList;
            }else{
                var hotList = [0,1,2,3,4,5,6,7,8,9];
            }
	    	for(var item in hotList){
			    if(item>options.suggestLength){
				    return;
			    }
			    var _data = options.data[hotList[item]];
			    if(_data && _data[0])
	    		cityList.append("<a href='###' dataid='"+_data[0]+"'><span>"+_data[2]+"</span><b>"+_data[1]+"</b></a>");
		    }		
    		suggestMain.find('.list_city_head').html(options.suggestTitleText);
            setAddPage(1);
	    	suggestMain.show();
		    setTopSelect();
	    }
    	function queryCity(){
            popMain.hide();
            var value = input.val().toLowerCase();
            if( value.length == 0){
                loadCity();
                return; 
            }
            var city_container = suggestMain.find('.list_city_container');        
		    var isHave = false;
            var _tmp = new Array();
            var type = options.type;
            
            for(var item in options.data){			
                var _data = options.data[item];
                if(type!='json'){
	                if(typeof (_data) != 'undefined'){
	                	if($.isArray( _data )){
		                    if(_data[2].indexOf(value) >= 0 || _data[3].indexOf(value) >= 0 || _data[1].indexOf(value) >=0 || _data[0].indexOf(value) >=0 ){
		                    	 isHave = true;
		                    	 _tmp.push(_data);
		                    }
	                	}
	                	else{
	                		if(_data.indexOf(value) >= 0){
	                            isHave = true;
	                            _tmp.push(_data);
	                        }
	                	}
	                }
                }else{
                	for(var province_idx in _data.two){	
                		var province = _data.two[province_idx];
                		for(var city_idx in province.three){
                			var city = province.three[city_idx];
	                		if(city.name.indexOf(value) >= 0 || city.enname.indexOf(value) >= 0){
	               			 	isHave = true;
		                    	 _tmp.push(new Array(city.id,city.name,city.enname));
	                		}
                		}
                	}
                }
             };
            
		    if(isHave){
                city_container.empty();
                for(var item in _tmp){
	                var _data= _tmp[item];
	                if(_data){
	                	city_container.append("<a href='##' dataid='"+_data[0]+"' style='display:none'><span>"+_data[2]+"</span><b>"+     _data[1] +"</b></a>");
	                }
                }
			    suggestMain.find('.list_city_head').html(value+",按拼音排序");
                setAddPage(1);
                setTopSelect()
    		}else{
	    		suggestMain.find('.list_city_head').html("<span class='msg'>对不起,找不到"+value+"</span>");
		    }
            suggestMain.show();
	    }
        function setAddPage(pageIndex){
            suggestMain.find('.list_city_container a').removeClass('selected');
            suggestMain.find('.list_city_container').children().each(function(i){			
                var k = i+1;
                if(k> options.suggestLength*(pageIndex-1) && k <= options.suggestLength*pageIndex){
                    $(this).css('display','block');
                }else{
                    $(this).hide();    
                }
             });
            setTopSelect();
            setAddPageHtml(pageIndex);
        }
        function setAddPageHtml(pageIndex){
            var cityPageBreak = suggestMain.find('.page_break');
            cityPageBreak.empty();	
            if(suggestMain.find('.list_city_container').children().length > options.suggestLength){
                var pageBreakSize = Math.ceil(suggestMain.find('.list_city_container').children().length/options.suggestLength);	
    			if(pageBreakSize <= 1){
	    			return;
		    	}			
                var start = end = pageIndex;
                for(var index = 0 ,num = 1 ; index < options.pageLength && num < options.pageLength; index++){
                    if(start > 1){
                        start--;num++;
                    }
                    if(end<pageBreakSize){
                        end ++;num++;
                    }
                }
                if(pageIndex > 1){
                    cityPageBreak.append("<a href='javascript:void(0)' inum='"+(pageIndex-1)+"'>&lt;-</a>");
                }	
                for(var i=start;i<=end;i++){
                    if(i == pageIndex){
                        cityPageBreak.append("<a href='javascript:void(0)' class='current' inum='"+(i)+"'>"+(i)+"</a");
                    }else{
                        cityPageBreak.append("<a href='javascript:void(0)' inum='"+(i)+"'>"+(i)+"</a");
                    }        
             }         
			    if (pageIndex<pageBreakSize) {
                    cityPageBreak.append("<a href='javascript:void(0);' inum='"+ (i) +"'>-&gt;</a>");
                }
                cityPageBreak.show();           
            }else{
                cityPageBreak.hide();    
            }
	    	return;
        }
	    function setTopSelect(){		
		    if(suggestMain.find('.list_city_container').children().length > 0 ){
			    suggestMain.find('.list_city_container').children(':visible').eq(0).addClass('selected');
		    }
	    }
        function onSelect(){
            if( typeof options.onSelect == 'function'){
            }
        }
        
        function popInitJson(){
            var index = 1;
            popMain.find('.pop_head_text').html(options.popTitleText);
            var data = options.data;
            var len = data.length;
            var tabs_html = "";
            var popContainer_html="";
            var i=0;
            var cls="";
            
            
            var sortLableWidth = options.sortLableWidth;//标签宽度
		    var doubleRow = options.doubleRow;//2行显示
		    var s_index = options.index?options.index:1;//从第几个开始排序
		    var sortLableSty = sortLableWidth?'style="margin-left: -'+sortLableWidth+';width:'+sortLableWidth+';"':'';
		    var leftStyle = sortLableWidth?'padding-left: '+sortLableWidth+';':''; 
		    var width = doubleRow?'width: 41%;':''
            
            $.each(data ,function(key,val){
        		cls = i==0?"class='current'":""
            	tabs_html=tabs_html+"<li><a id='label_"+input.attr('id')+index+"' "+cls+" href='##'>"+val.name+"</a></li>";
        		cls = i>0?"style='display:none'":""
        		popContainer_html+="<div "+cls+" class='tab' id='label_"+input.attr('id')+index+"_container' data-type='"+val.name+"'>";
        		$.each(val.two ,function(key,val){
        			popContainer_html+='<div class="city_item_in" style="'+leftStyle+width+'" >'
        			popContainer_html+='<span class="city_item_letter" '+sortLableSty+' >'+val.name+'</span>';
        			$.each(val.three ,function(key,val){
        				popContainer_html+='<a href="##" title="'+val.name+'" class="city_item" dataid="'+val.id+'">'+val.name+'</a>';
        			});
        			popContainer_html+='</div>';
        		});
        		popContainer_html+='</div>';
        		popContainer.append(popContainer_html);
        		popContainer_html="";
            	i++;
            	index++;
            });
        	
            labelMain.html(tabs_html);
        }
        
        function popInit(){
            var index = 0;
            popMain.find('.pop_head_text').html(options.popTitleText);
            
            if(!options.tabs){
                popContainer.append("<ul id='label_"+input.attr('id')+"_container' class='current'></ul>");
                labelMain.remove();
                for( var item in options.data){
                      $("#label_"+input.attr('id')+"_container").append("<li><a href='##' dataid='"+options.data[item][0]+"'>"+options.data[item][1]+"</a></li>");
                }
                return;
            }
            
            var sortLableWidth = options.sortLableWidth;
		    var doubleRow = options.doubleRow;
		    var s_index = options.index?options.index:1;
		    var sortLableSty = sortLableWidth?'style="margin-left: -'+sortLableWidth+';width: '+sortLableWidth+';"':'""';
		    var leftStyle = sortLableWidth?'padding-left: '+sortLableWidth+';':'""'; 
		    var width = doubleRow?'width: 41%;':''
            
    		for(var itemLabel in options.tabs){		
    			
    			var o_arr = options.tabs[itemLabel];
    			
			    index++;			
			    if(index == 1){
				    popContainer.append("<ul id='label_"+input.attr('id')+index+"_container' class='current tab' data-type='"+itemLabel+"'></ul>");
				    labelMain.append("<li><a id='label_"+input.attr('id')+index+"' class='current' href='javascript:void(0)'>"+itemLabel+"</a></li>");		
			    }else{
				    popContainer.append("<div style='display:none' class='tab' id='label_"+input.attr('id')+index+"_container' data-type='"+itemLabel+"'></div>");
				    labelMain.append("<li><a id='label_"+input.attr('id')+index+"' href='javascript:void(0)'>"+itemLabel+"</a></li>");		
			    }
			    var arr_temp = [];
			    for(var item in o_arr){
				    var cityCode = o_arr[item];
				    
				    if(!options.data[cityCode]){
					    break;
    			    }
				    arr_temp.push(options.data[cityCode]);
				    
			    }
			    var out_arr = null;
			    if(options.sort){
			    	out_arr = arr_temp.sort(function(x, y){
				    	  return x[2].localeCompare(y[2]);
				    });
			    }else{
			    	out_arr = arr_temp;
			    }
			    
			    var len = out_arr.length;
			    var tmp="";
			    var html_str='';
			   
			    for(var i=0;i<len;i++ ){
			    	if(options.sort && index>s_index){//第一个热门不显示
			    		var lable =out_arr[i][2].length>0?out_arr[i][2][0].toUpperCase():"";
			    		if(out_arr[i][2].length>0 && !isLetter(out_arr[i][2][0])){
			    			lable = out_arr[i][2];
//			    			console.log( lable )
			    		}
			    		
				    	if(i==0){
				    		html_str+='<div class="city_item_in" style="'+leftStyle+width+'" ><span class="city_item_letter" '+sortLableSty+'>'+lable+'</span>'
				    		tmp = lable;
				    	}else if(tmp!=lable){
				    		html_str+='</div><div class="city_item_in"  style="'+leftStyle+width+'" ><span class="city_item_letter" '+sortLableSty+'>'+lable+'</span>';
				    	}
				    	tmp = lable;
			    	}
			    	html_str+="<a href='##' title='"+out_arr[i][1]+"' class='city_item' dataid="+out_arr[i][0]+">"+out_arr[i][1]+"</a>";
			    }
			    html_str+="</div>";
			    $("#label_"+input.attr('id')+index+"_container").append(html_str);
			    
		    }			
        }
		
		function pageWidth(){ 
			if($.browser.msie){ 
			return document.compatMode == "CSS1Compat"? document.documentElement.clientWidth : 
			document.body.clientWidth; 
		}else{ 
			return self.innerWidth; 
			} 
		};
		
        function resetPosition(){
			//修正当弹出层超出页面时的定位
			var left = input.offset().left;
			if((left + 360)>pageWidth()){left = pageWidth() - 370;};
            popMain.css({'top':input.offset().top+input.outerHeight(),'left':left});
            suggestMain.css({'top':input.offset().top+input.outerHeight(),'left':input.offset().left});
        }
        
        function isLetter(value){
        	var reg= /^[A-Za-z]+$/;
        	return reg.test(value);
        }
        
    }

    $.fn.querycity = function(options){
        var defaults = {
            'data'          : {},
            'tabs'          : '',
            'type'          : 'array',//array  json
            'hotList'       : '',            
            'defaultText'   : '',
            'popTitleText'  : '输入中文/拼音或↑↓选择',
            'suggestTitleText' : '输入中文/拼音或↑↓选择',
            'suggestLength' : 10,
            'pageLength'    : 5, 
            'multiSelect'   : false,
            'sort':false,
            'index':1,
            'doubleRow':false,
            'onSelect'      : '' 
        };
        var options = $.extend(defaults,options);
        this.each(function(){
            new $.querycity(this,options);            
        });
        return this;
    };
})(jQuery);


(function($){
$.fn.bgIframe = $.fn.bgiframe = function(s) {
	if ( $.browser.msie && /6.0/.test(navigator.userAgent) ) {
		s = $.extend({
			top     : 'auto', // auto == .currentStyle.borderTopWidth
			left    : 'auto', // auto == .currentStyle.borderLeftWidth
			width   : 'auto', // auto == offsetWidth
			height  : 'auto', // auto == offsetHeight
			opacity : true,
			src     : 'javascript:false;'
		}, s || {});
		var prop = function(n){return n&&n.constructor==Number?n+'px':n;},
		    html = '<iframe class="bgiframe" frameborder="0" tabindex="-1" src="'+s.src+'"'+
		               'style="display:block;position:absolute;z-index:-1;'+
			               (s.opacity !== false?'filter:Alpha(Opacity=\'0\');':'')+
					       'top:'+(s.top=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')':prop(s.top))+';'+
					       'left:'+(s.left=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')':prop(s.left))+';'+
					       'width:'+(s.width=='auto'?'expression(this.parentNode.offsetWidth+\'px\')':prop(s.width))+';'+
					       'height:'+(s.height=='auto'?'expression(this.parentNode.offsetHeight+\'px\')':prop(s.height))+';'+
					'"/>';
		return this.each(function() {
			if ( $('> iframe.bgiframe', this).length == 0 )
				//document.createElement(html)
				jQuery(html).insertBefore( this.firstChild );
		});
	}
	return this;
};
})(jQuery);


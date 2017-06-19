(function(){
	jQuery.Destinations = function(settings){
		jQuery.extend(this, settings);
		
		this.initEvent();//初始化事件
	};
	jQuery.Destinations.prototype = {
		data : [],
		root : '',
		renderTo : 'body',
		selectTo:"",//选择到哪个对象
		title : '',//弹出框标题
		bindBtn:null,//弹出框 绑定单哪个对象 
		data:'',//树 - 数据
		maxLevel : 10,
		rootNode : null,
		toUpdate:function(node){},
		toAddSub:function(node){},
		del:function(node){},
		up:function(node){},
		down:function(node){},
		getTpl:function(){
			var html = '<div id="'+this.root+'" >';
			if(this.root=='destinations'){ //判断是否是目的地 
					html = html+'<div style="padding-bottom:10px;"><form  accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"  onsubmit="return Checklineatrr();"  method="post" id="lineFromlist" >';
					html = html+'<input  type="text" name="name" /><input  type="hidden" name="type" value="'+this.root+'" /><input  type="submit" id="" class="" value="搜索" ></from></div>';
	    	}
				html = html+'<div class="form-group" id="'+this.root+'-select" style="">';
				html = html+'<span class="">已选择：</span>';
				html = html+'<span class="" id="'+this.root+'-selected"></span>';
				html = html+'</div>';
				html = html+'<div class="form-group" style="height: 450px;  overflow: auto;">';
				html = html+'<div class="destinations-content" id="'+this.root+'-content">';
				html = html+'</div>';
				html = html+'</div>';
				html = html+'<div class="form-group" style="text-align:center">';
				html = html+'<input type="button" id="selDsBtn" class="btn btn-palegreen bootbox-close-button" value="确认选择" >';
				html = html+'</div>';
				html = html+'</div>';
				return html;
		},
		init:function(data){
			var node=data;
			this.rootNode = node;
			$this = this;
			this.renderTo = jQuery('#'+this.root+'-content');
			this.list = jQuery('<table width="100%" border="0" cellspacing="1" cellpadding="5" class="table-class"></table>').appendTo(this.renderTo);
			jQuery.each($this.data, function(index, node) {
				$this.initNode(node);
			});
		},
		initCheck:function(){
			var me = this;
			//已选部分
			$root = jQuery('#'+me.root);
	    	var selectedLable = jQuery('#'+this.root+'-selected',$root);
	    	selectedLable.html(jQuery(this.selectTo).html());
	    	selectedLable.children().each(function(obj,index){
	    		var id = jQuery(this).attr('data');
	    		$('input:checkbox[name="chkbox"][value="'+id+'"]',$root).attr('checked',true);
	        });
		},
		initNode:function(node, parentNode,len){
			var $this = this;
			if(parentNode){
				node.level=parentNode.level+1;
			}else{
				node.level=0;
				node.index=0;
				node.isRoot = true;
			}
			if(node.level<3){
				if (node.id && node.name) {
					this.buildNodeStyle(node, parentNode,len);//设置NODE到table 绑定到node.dom
					$this.addEvent(jQuery("td:eq(0)", node.dom), node);//时间
				}
				$this.buildNode(node, parentNode);
			}
		},
		initEvent:function(){
			var html = this.getTpl();
			var title = this.title;
			var me = this;
			
			//绑定的打开事件
			$(this.bindBtn).on('click', function () {
				bootbox.dialog({ message : html, title: title, className: "modal-darkorange" });
				me.init(this.data);//初始化选择树
				me.initCheck();//初始化选择
				$root = jQuery('#'+me.root);
				 //树 checkBox事件
		        jQuery('input[name="chkbox"]',$root).click(function(){
		            var id = jQuery(this).val();
		            var nodename = jQuery(this).attr('nodename');
		            if(jQuery(this).is(":checked")){
			            var selected = $('span[name="ds-lable"][data="'+id+'"]',$root);
		            	if(selected.length==0){   		
		            		var id_name=jQuery(this).attr("id");
		            		if(id_name=='orvercity_id'){
		            			 jQuery('#'+me.root+'-selected',$root).append('<span class="line-lable" data-val="'+id+'" name="ds-lable" data="'+id+'" id="ds-'+id+'" >'+nodename+'<a href="###" data="'+id+'" name="delDsLable" >×</a></span>')
		            		}else{
		            			 jQuery('#'+me.root+'-selected',$root).append('<span class="line-lable" name="ds-lable" data="'+id+'" id="ds-'+id+'" >'+nodename+'<a href="###" data="'+id+'" name="delDsLable" >×</a></span>')
		            		}
		            		 
		            	}
		            }else{
		            	$('span[name="ds-lable"][data="'+id+'"]',$root).remove();
		            }
		        });
		        
		        //弹出框标签点击删除
		        jQuery("#"+me.root+"-select",$root).on("click",'a[name="delDsLable"]',function(){
		        	var id = jQuery(this).attr('data');
		        	jQuery(this).parent().remove();
		        	$('input:checkbox[value="'+id+'"]',$root).attr('checked',false);
		        });
		        
		        var ds_list = jQuery(me.selectTo);
			    //选中后 赋值
			    jQuery('#selDsBtn',$root).click(function(){
		            var dsLables = jQuery('span[name="ds-lable"]',$root);
		            ds_list.html(jQuery('#'+me.root+'-selected',$root).html());
		            if(me.getVal){
		            	me.getVal(me.getValue());
		            	
		            }
		            if(me.getThVal){
		            	me.getThVal(me.getThreValue());
		            }
			    });
			});
		},
		addEvent:function(td, node){
			
		},
		getValue:function(){
			$root = jQuery('#'+this.root);
			//已选部分
        	var value = '';
        	var ds_list = jQuery('#'+this.root+'-selected',$root);
	       	ds_list.children().each(function(obj,index){
	       		var id = jQuery(this).attr('data');
	       		value = value + id + ",";
	        });
       	    value = value.substring(0,value.length-1);
       	    return value;
		},
		//获取三级目的地的ID
		getThreValue:function(){
			$root = jQuery('#'+this.root);
			//已选部分
        	var value = '';
        	var ds_list = jQuery('#'+this.root+'-selected',$root);
	       	ds_list.children().each(function(obj,index){
	       		var id = jQuery(this).attr('data-val');
	       		if(typeof(id) != 'undefined' ){
	       			value = value + id + ",";
	       		}       		
	        });
       	    value = value.substring(0,value.length-1);
       	    return value;
		},
		buildNodeStyle:function(node, parentNode,len){
			var nodeHTML = '<tr class="'+(node.level==0?"class-big":"")+'">';
			nodeHTML+='<td>';
			for(var i=0;i<node.level;i++){
				nodeHTML+='<span class="tree-node-empty"></span>';
			}
			if(node.level>0){
				if(node.level==2){
					nodeHTML+='<input name="chkbox" id="orvercity_id" type="checkbox" nodename="'+node.name+'" value="'+node.id+'" />';
				}else{
					if(this.root=='attr'){
						nodeHTML+='<input name="chkbox" type="checkbox" nodename="'+node.name+'" value="'+node.id+'" />';
					}
					
				}

			}
			nodeHTML+=node.name;
			nodeHTML+='</td>';
			var item = jQuery(nodeHTML);
			item.appendTo(this.list);//追加到TABLE
			node.dom = item[0];
		},
		buildNode : function(node, parentNode){
			var $this = this;
			if (node.childs) {
				if (parentNode) {
					node.parentNode = parentNode;
				}else{
				}
				var len = node.childs.length;
				//维护NODE关系
				jQuery.each(node.childs, function(index, cnode) {
					cnode.srcNode=jQuery.extend({},cnode);
					delete cnode.srcNode.children;
					jQuery.extend(cnode, { parentNode : node, firstChild : null, lastChild : null,dom : null, previousSibling : null,nextSibling : null, fillIcon : [], index : 0},$this.nodeModel);
					cnode.index = index;
					$this.initNode(cnode, node,len);
				});
			}
		}
	};
	
//已选择的 删除，删除ID
jQuery('#ds-list').on("click",'a[name="delDsLable"]',function(){
	var id = jQuery(this).attr('data');
	jQuery(this).parent().remove();
	var v = jQuery('#overcity').val();
	if(''!=v){
    	var arr = v.split(",");
    	if(arr.length==1){
    		v = v.replace(new RegExp(id,"g"),"");
        }else{
	    	v = v.replace(new RegExp(id+",","g"),"");
	    	v = v.replace(new RegExp(","+id,"g"),"");
	    }
	}
	jQuery('#overcity').val(v)
	//删除三级目的地
	var v2 = jQuery('#overcity2').val();
	if(''!=v2){
    	var arr = v2.split(",");
    	if(arr.length==1){
    		v2 = v2.replace(new RegExp(id,"g"),"");
        }else{
	    	v2 = v2.replace(new RegExp(id+",","g"),"");
	    	v2 = v2.replace(new RegExp(","+id,"g"),"");
	    }
	}
	jQuery('#overcity2').val(v2)
	
	
});	
//已选择的 删除，删除ID
jQuery('#attr-list').on("click",'a[name="delDsLable"]',function(){
	var id = jQuery(this).attr('data');
	jQuery(this).parent().remove();
	var v = jQuery('#linetype').val();
	if(''!=v){
    	var arr = v.split(",");
    	if(arr.length==1){
    		v = v.replace(new RegExp(id,"g"),"");
        }else{
	    	v = v.replace(new RegExp(id+",","g"),"");
	    	v = v.replace(new RegExp(","+id,"g"),"");
	    }
	}
	jQuery('#linetype').val(v)
});


})();


function cursorControl(a){
    this.element=a;
};
cursorControl.prototype={
    getType:function(){
        return Object.prototype.toString.call(this.element).match(/^\[object\s(.*)\]$/)[1];
    },
    getStart:function(){
        if (this.element.selectionStart || this.element.selectionStart == '0'){  
            return this.element.selectionStart; 
        } 
        else if (window.getSelection){  
            var rng = window.getSelection().getRangeAt(0).cloneRange();  
            rng.setStart(this.element,0);  
            return rng.toString().length;
        }
    },
    insertText:function(text){
    	var selection= window.getSelection ? window.getSelection() : document.selection;
    	var range= selection.createRange ? selection.createRange() : selection.getRangeAt(0);
    	if (!window.getSelection){
	    	this.element.focus();
	    	var selection= window.getSelection ? window.getSelection() : document.selection;
	    	var range= selection.createRange ? selection.createRange() : selection.getRangeAt(0);
	    	range.pasteHTML(text);
	    	range.collapse(false);
	    	range.select();
    	}else{
    		this.element.focus();
	    	range.collapse(false);
	    	var hasR = range.createContextualFragment(text);
	    	var hasR_lastChild = hasR.lastChild;
	    	while (hasR_lastChild && hasR_lastChild.nodeName.toLowerCase() == "br" && hasR_lastChild.previousSibling && hasR_lastChild.previousSibling.nodeName.toLowerCase() == "br") {
		    	var e = hasR_lastChild;
		    	hasR_lastChild = hasR_lastChild.previousSibling;
		    	hasR.removeChild(e)
	    	}                                
	    	range.insertNode(hasR);
	    	if (hasR_lastChild) {
		    	range.setEndAfter(hasR_lastChild);
		    	range.setStartAfter(hasR_lastChild)
	    	}
	    	selection.removeAllRanges();
	    	selection.addRange(range)
    	} 
    },
    getText:function(){
        if (document.all){  
            var r = document.selection.createRange();  
            document.selection.empty();  
            return r.text;  
        }  
        else{  
            if (this.element.selectionStart || this.element.selectionStart == '0'){
                var text=this.getType()=='HTMLDivElement'?this.element.innerHTML:this.element.value;
                return text.substring(this.element.selectionStart,this.element.selectionEnd); 
            } 
            else if (window.getSelection){  
                return window.getSelection().toString()
            };  
        }  
    }
}; 


function isOrContainsNode(ancestor, descendant) {
    var node = descendant;
    while (node) {
        if (node === ancestor) {
            return true;
        }
        node = node.parentNode;
    }
    return false;
}

function insertNodeOverSelection(obj,img) {
    var sel, range, html, str;
   
	var containerNode = obj;
	node = document.createElement('img');
	node.src = img.src;
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            if (isOrContainsNode(containerNode, range.commonAncestorContainer)) {
                range.deleteContents();
                range.insertNode(node);
            } else {
                containerNode.appendChild(node);
            }
        }
    } else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        if (isOrContainsNode(containerNode, range.parentElement())) {
            html = (node.nodeType == 3) ? node.data : node.outerHTML;
            range.pasteHTML(html);
        } else {
            containerNode.appendChild(node);
        }
    }
}
	

<script type="text/javascript">
$('#infoimg').diyUpload({
	swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
	url:"<?php echo base_url('admin/b1/product/upload_pics')?>",
	success:function( data ) {
		//console.info( data );
		if(data.status==-1){
			alert(data.msg);
		}else{
		   if($('#ThumbPic').children('li').length>4){
				alert('上传文件数量超过限制');
		   }else{
				var html='<li style="float: left;margin:0 10px 10px 0px; width:96px;height:59px;">';
			    html+='<div class="img_main0">'; 
			    html+='<div class="float_img" id="del_img"  onclick="del_line_imgdata(this,-1)">×</div>'; 
			    html+='<div style="height:60px;"><img class="active" style="height:100%;" src="'+data.url+'"><div>'; 
			    html+='</div>';
			    html+='	<input type="hidden" value="'+data.url+'" name="line_imgss[]" />';
			    html+='</li>';
			   $("#ThumbPic").append(html);
			  var pic= $('input[name="line_pics_arr"]').val();
			    if(pic !=''){
			    	pic=pic+','+data.url;
				}else{
					pic=data.url;
				}
			    $('input[name="line_pics_arr"]').val(pic);
		  }
		}
									
	},
	error:function( err ) {
		console.info( err );	
	},
	buttonText : '选择图片',
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:50,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:50000 * 1024,
	accept: {}
});

//删除图片
function del_imgdata(obj,id){ 
    var pid=id;
 	//if (!confirm("确认删除?")) {
	//        window.event.returnValue = false;
	//  }else{
            var url_arr='';
            var input_url='';
      		var test=$(obj).parent('.img_main').children("img").attr("src");  		
      		var input_url= $(obj).parents('.div_url_val').children('.line_pic_val').val();
           	if(input_url!=''){
      			var url_arr=input_url.split(";");
      			var img_url_arr='';
	      		for (var i = 0; i < url_arr.length; i++) {
		                    if (url_arr[i] != test) { 
			                      if(i < url_arr.length-1){
			                        	img_url_arr=img_url_arr+url_arr[i]+';'; 
			                      }else{
			                        	img_url_arr=img_url_arr+url_arr[i];  
			                      }
		                    }
	          	  	}
          	  	
               		 $(obj).parents('.div_url_val').children('.line_pic_val').val(img_url_arr); 
      		} 
      	
         		$.post("<?php echo base_url()?>admin/b1/product/del_img", { data:pid} , function(result) {
    			 
    		});
           	 $(obj).parent().parent('li').remove();    		
  	//   }
 	    return false;
 }

//删除图片
function del_line_imgdata(obj,id){ 
    var pid=id;
		if (!confirm("确认删除？删除后将无法恢复")) {
          window.event.returnValue = false;
      }else{
    	//主图片
    		var main_pics=$("#OriginalPic").find("img").attr("src");
    		var pic=$(obj).parent().find("img").attr("src");
    		if(pic==main_pics){
    		    $("#OriginalPic").find("img").attr("src",'');
    			$("#main_pics").val('');
        	}
    		$.post("<?php echo base_url()?>admin/b1/product/del_img", { data:pid} , function(result) {
    			
    		});
            $(obj).parent().parent('li').remove();            		
  	   }
	  	
		
 }

/************************************美图秀秀**************************************************/
function change_avatar(obj,type){
		$('.avatar_box').show();
		var size='';
		if(type==0){
			size='500x300';
		 }else if(type==1){
			 
			size='554x336';	
		}else{
			size='300x300';
		}
	   /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
	   xiuxiu.setLaunchVars("cropPresets", size);
		xiuxiu.embedSWF("altContent",5,'100%','100%');
	       //修改为您自己的图片上传接口
		xiuxiu.setUploadURL("<?php echo site_url('admin/upload/uploadImgFileXiu'); ?>");
	        xiuxiu.setUploadType(2);
	        xiuxiu.setUploadDataFieldName("uploadFile");
		xiuxiu.onInit = function ()
		{
			//默认图片
			xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
		}
		xiuxiu.onUploadResponse = function (data)
		{
			data = eval('('+data+')');	
		    if (data.code == 2000){ 
		        if(type==0){    //宣传图片的上传
					if($('#ThumbPic').children('li').length>4){
						alert('上传文件数量超过限制');
					}else{
						var html='<li class="" style="">';
					    html+='<div class="img_main0">'; 
					    html+='<div class="float_img" id="del_img"  onclick="del_line_imgdata(this,-1)">×</div>'; 
					    html+='<div style="height:60px;"><img  style="height:100%;" src="'+data.msg+'"></div>'; 
					    html+='</div>';
					    html+='	<input type="hidden" id="line_imgss" value="'+data.msg+'" name="line_imgss[]" />';
					    html+='<div class="zhutu">设为主图片</div>'; 
					    html+='<div class="weixuanzhong"></div>'; 
					    html+='</li>';	   
					   $("#ThumbPic").append(html);
					    $('.weixuanzhong').click(function(){ 
							$("#ThumbPic li").find(".weixuanzhong").show();
							$(this).parent().find(".weixuanzhong").hide();
							$(this).parent().addClass('list_click').siblings().removeClass('list_click');
							var mainimg=$(this).parent().find('img').attr('src');
							$('input[name="mainpic"]').val(mainimg); 	
						})
						
					}
	
		        }else if(type==1){ //行程上传图片
		    	 var line_photo_url='<li style="float:left;list-style:none;margin:0 20px 0px 0px" class="url_li">';
					 line_photo_url+='<div class="img_main"><div id="del_img" class="float_div" onclick="del_imgdata(this,-1);"  style="height:20px;width:12px; font-size:24px;cursor:pointer;">×</div><img received="" file="" src="'+data.msg+'"  style="width:215px;">';
					 line_photo_url+='</div></li>';
					 var $fileInput = $(obj).parent();
					if($fileInput.prev('.div_url_val').children('.url_val').children('li').length>2){
						   alert('上传文件数量超过限制');	
					}else{
						$fileInput.prev('.div_url_val').children('.url_val').html($fileInput.prev('.div_url_val').children('.url_val').html()+line_photo_url);
						$fileInput.prev('.div_url_val').children('.line_pic_val').val($fileInput.prev('.div_url_val').children('.line_pic_val').val()+data.msg+';');			
					}			
				 
			    }else if(type==2){   //礼品上传图片
				  
				    $('#gift_pic').find("img").attr("src",data.msg);
				    $('input[name="logo"]').val(data.msg);
				    
				}
				close_xiuxiu();
				
		    } else {
			    alert(data.msg);
		    }
		    
		}
	  
	    
		 $("#img_upload").show();
		 $(".close_xiu").show();
		$(".avatar_box").show();
}
$(document).mouseup(function(e) {
   var _con = $('#img_upload'); // 设置目标区域
   if (!_con.is(e.target) && _con.has(e.target).length === 0) {
       $("#img_upload").hide()
       $('.avatar_box').hide();
       $(".close_xiu").hide();
   }
})
function close_xiuxiu(){
	$("#img_upload").hide()
   $('.avatar_box').hide();	
	$(".close_xiu").hide();
}

<!------------------------------------从相片中取图片--------------------------------------------->					                            
//弹框相册图片选择
var imgArray = [];
function choice_picture(obj,index){
	get_picture_page(1);
	if(index==1){
		$(".queren span").attr("data-val","ThumbPic");
		var len = $("#ThumbPic li").length;
		for(var i=0;i<len;i++){
			imgArray[i] = $("#ThumbPic li").eq(i).find("img").attr("src");
		}
		$("#zancun_img_list").html($("#ThumbPic").html());
			
	}else{
		var id = "show_choice_pic"+index;
		$(obj).siblings(".div_url_val").find("ul").attr("id",id);
		$(".queren span").attr("data-val",id);
		var len = $(obj).siblings(".div_url_val").find(".url_val li").length;
		for(var i=0;i<len;i++){
			imgArray[i] = $(obj).siblings(".div_url_val").find(".url_val li").eq(i).find("img").attr("src");
		}
		$("#zancun_img_list").html($(obj).siblings(".div_url_val").find("ul").html());
		$("#zancun").val($(obj).siblings(".div_url_val").find("input").val());
		
	}
//	alert(imgArray.length);
	for( var i = 0 ; i< imgArray.length ; i++ ){
			//alert(imgArray[i]);
		 	$("#picture_list li").each(function(){
				//alert(imgArray[i]);
				//alert($(this).attr("data-src"));
				if( imgArray[i] == $(this).attr("data-src") ){
					$(this).addClass("on");
				}
			});
		}
	$(".choice_photo_box").show();
	
}
//获取选图片
function get_picture_page(page_new){
	var type=$("select[name='dest_picture']").find("option:selected").val(); 
	$.post(
			"/admin/b1/product/get_product_pic",
		//	{'is':1,'pagesize':8},
			{'is':1,'pagesize':16,'page_new':page_new,'type':type},
			function(data) {
				data = eval('('+data+')');
				$('#picture_list').html('');
				$.each(data.list ,function(key ,val) {
						var str = '<li data-src="'+val.pic+'" onclick="choice_this(this);"><i></i>';
						str=str+'<img src="'+val.pic+'"></li>';
						$('#picture_list').append(str);
				})
		    	for( var i = 0 ; i< imgArray.length ; i++ ){
				//alert(imgArray[i]);
				 	$("#picture_list li").each(function(){
						//alert(imgArray[i]);
						//alert($(this).attr("data-src"));
						if( imgArray[i] == $(this).attr("data-src") ){
							$(this).addClass("on");
						}
					});
		    	}
				$('.picture_page').html(data.page_string);
				$('#picture_list').css({'z-index':'10000'}).show();

				//点击旅行社时执行
				$('.choice_tralve_agent').click(function() {
					$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
					$(this).css('border','2px solid green').addClass('active');
				})

				//点击分页
				$('.ajax_page').click(function(){
					var page_new = $(this).find('a').attr('page_new');
					get_picture_page(page_new);
				}) 
			}
		);
}
function close_alert_box(){
	$(".choice_photo_box").hide();	
	$("#picture_list li").removeClass("on");
	$("#zancun").val("");
	$("#zancun_img_list").empty();
}
function queren_choice(obj){
	var src = $(".img_list").find(".on img").attr("src");
	var len = $(".show_choice_img").find(".choice_img_show img").length;
	var html = $("#zancun_img_list").html();
	var show_id = $(obj).attr("data-val");
	$("#"+show_id).html(html);
	if(show_id!="ThumbPic"){
		$("#"+show_id).siblings("input").val($("#zancun").val());	
	}
	$(".choice_photo_box").hide();	
	$("#picture_list li").removeClass("on");
	$("#zancun").val("");
	$("#zancun_img_list").empty();
	
	$('.weixuanzhong').click(function(){ 
		$("#ThumbPic li").find(".weixuanzhong").show();
		$(this).parent().find(".weixuanzhong").hide();
		$(this).parent().addClass('list_click').siblings().removeClass('list_click');
		var mainimg=$(this).parent().find('img').attr('src');
		$('input[name="mainpic"]').val(mainimg); 	
	})
}
$('.weixuanzhong').on("click",function(){ 
	$("#ThumbPic li").find(".weixuanzhong").show();
	$(this).parent().find(".weixuanzhong").hide();
	$(this).parent().addClass('list_click').siblings().removeClass('list_click');
	var mainimg=$(this).parent().find('img').attr('src');
	$('input[name="mainpic"]').val(mainimg); 	
})

function search_img(obj){
	var html='';
	var type=$("select[name='dest_picture']").find("option:selected").val(); 
	$.post(
			"/admin/b1/product/get_product_pic",
			{'is':1,'pagesize':16,'page_new':1,'type':type},
			function(data) {
				data = eval('('+data+')');
				$('#picture_list').html('');
				$.each(data.list ,function(key ,val) {
					var str = '<li data-src="'+val.pic+'" onclick="choice_this(this);"><i></i>';
					str=str+'<img src="'+val.pic+'"></li>';
					$('#picture_list').append(str);
				})
		    	for( var i = 0 ; i< imgArray.length ; i++ ){
					//alert(imgArray[i]);
				 	$("#picture_list li").each(function(){
						//alert(imgArray[i]);
						//alert($(this).attr("data-src"));
						if( imgArray[i] == $(this).attr("data-src") ){
							$(this).addClass("on");
						}
					});
			    }
				$('.picture_page').html(data.page_string);
				$('#picture_list').css({'z-index':'10000'}).show();

				//点击旅行社时执行
				$('.choice_tralve_agent').click(function() {
					$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
					$(this).css('border','2px solid green').addClass('active');
				})

				//点击分页
				$('.ajax_page').click(function(){
					var page_new = $(this).find('a').attr('page_new');
					get_picture_page(page_new);
				}) 

			}
		);
}
function choice_this(obj){
	var len = $("#zancun_img_list li").length;
	var src = $(obj).find("img").attr("src");
	var val = $("#zancun").val();
	var num = $(obj).attr("data-num");
	if($(obj).hasClass("on")){
		$(obj).removeClass("on");
		var v = val.replace(src+";","");
		$("#zancun").val(v);
		var ss = val.split(";");
		for( var i = 0 ; i< ss.length ; i++ ){
			$("#zancun_img_list li").each(function(){
				if( src == $(this).find("img").attr("src") ){
					$(this).remove();
				}
			});
		}
	}else{
		var show_id = $(".queren span").attr("data-val");
		if(show_id=="ThumbPic"){
			if(len>=5){
				alert("所选图片不能超过5张");
				return false;
			}
			//alert(len);
			if(len==0){
				var html = '<li class="list_click" ><div class="img_main0"><div class="float_img" id="del_img" onclick="del_line_imgdata(this,-1)">×</div>';
				html+= '<div style="height:60px;"><img style="height:100%;" src="'+src+'"></div></div>';
				html+= '<input id="line_imgss" type="hidden" name="line_imgss[]" value="'+src+'"><div class="zhutu">设为主图片</div><div class="weixuanzhong" style="display: none;"  ></div></li>';	
				   $('input[name="mainpic"]').val(src); 
			}else{
				var html = '<li><div class="img_main0"><div class="float_img" id="del_img" onclick="del_line_imgdata(this,-1)">×</div>';
				html+= '<div style="height:60px;"><img style="height:100%;" src="'+src+'"></div></div>';
				html+= '<input id="line_imgss" type="hidden" name="line_imgss[]" value="'+src+'"><div class="zhutu">设为主图片</div><div class="weixuanzhong"></div></li>';	
			}
			/*var html = '<li><div class="img_main0"><div class="float_img" id="del_img" onclick="del_line_imgdata(this,-1)">×</div>';
				html+= '<div style="height:60px;"><img style="height:100%;" src="'+src+'"></div></div>';
				html+= '<input id="line_imgss" type="hidden" name="line_imgss[]" value="'+src+'"><div class="zhutu">设为主图片</div><div class="weixuanzhong"></div></li>';*/
		}else{
			if(len>=3){
				alert("所选图片不能超过3张");
				return false;
			}
			var html = '<li style="float:left;list-style:none;margin:0 20px 0px 0px" class="url_li">';
				html+= '<div class="img_main"><div id="del_img" class="float_div" onclick="del_imgdata(this,-1);" style="height:20px;width:12px; font-size:24px;cursor:pointer;">×</div>';
				html+= '<img received="" file="" src="'+src+'" style="width:215px;"></div></li>';
		}
		$(obj).addClass("on");

		$("#zancun_img_list").append(html);
		var v = val+src+";";
		$("#zancun").val(v);
	}

}

</script>

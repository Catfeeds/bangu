<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>发表体验_游记攻略-帮游旅行网</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta content="发表游记,游记攻略,帮游旅行网" name="keywords" />
<meta content="你可通过帮游旅游网发表攻略游记，给更多人的出行做经验分享，找到您的旅行知音。" name="description" />
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/fabuyouji.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<!-- 多图片上传 -->
<link href="/assets/css/diyUpload.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>
<script src="<?php echo base_url('static/js/diyUpload0.js') ;?>"></script>

<style type="text/css">
.webuploader-container { height:auto;}
.webuploader-pick { left:0px;}
.parentFileBox{float:left;width:100px;}
.parentFileBox .fileBoxUl{display:none;};
.parentFileBox .diyButton{float:left; width: 100px;}
.imgtext_box,.hotel_pics ul li img{ float:left;}
</style>

</head>
<body>
    <?php $this->load->view('common/header'); ?>
    <div class="Release_dangqian">您的当前位置:<a href="/">首页</a>><a href="">体验</a>><a href="">录入</a></div>
    <div class="Release_main">
    	<!-- 图片 -->
	<div id="img_upload">
		<div id="altContent"></div>
		<div class="close_xiu">×</div>
	<!--<div class="right_box"></div> -->
	</div>
    <form action="/base/travel/save_travel"  class="form-horizontal" role="form" id="save_travel" method="post"  >
        <!-- 订单线路  -->
        <div class="Rel_title">
            <span>选择订单线路</span>
            <select name="orderid" id="orderid">
                <option value="" >请选择</option>
                <?php if(!empty($order)){ ?>
                <?php foreach ($order as $k=>$v){ ?>
                 <option  value="<?php echo $v['orderid'].'-'.$v['lineid']; ?>" <?php if(isset($travel['order_id'])){ if($travel['order_id']==$v['orderid']){ echo ' selected="selected"';} } ?>><?php echo $v['linename'].'&nbsp;&nbsp;&nbsp;&nbsp;<'.$v['usedate'].'>'; ?></option>
                <?php } }?>
            </select>
            <input  type="hidden" value="<?php if(!empty($travel['order_id'])){echo $travel['order_id'];}  ?>" name="line_order"/>
        </div>
        <!-- 体验随笔  -->
        <div class="Rel_title">
            <span>体验随笔</span>
            <input type="text" name="title" placeholder="给体验取个吸引眼球的名字吧" value="<?php if(!empty($travel['title'])){ echo $travel['title'];} ?>"/>
            <input type="hidden" name="travel_id" value="<?php if(!empty($travel['id'])){ echo $travel['id'];} ;?>"/>
        </div>
		<input type="hidden" name="tags" value="<?php if(!empty($travel['tags'])){ echo $travel['tags'];} ?>" class="spanNum"/>
		<!--  产品标签   -->
		<!--<div class="Rel_title">
            <span>产品标签</span>
            <ul class="show_ration" style="height: auto; overflow: hidden; min-height: 40px; padding-bottom: 10px;">
					<?php if(!empty($tagesStr)){
					     foreach ($tagesStr as $k=>$v){
					?>
					<li value="<?php  echo $v['id'];?>"><?php echo $v['attrname']; ?><i>X</i></li>
					<?php } }?>
            </ul>
            <span class="choice" <?php if(!empty($tagesStr)){ echo 'style="display: none;"';} ?> >请选择</span>
            <div class="Labe_box">
            <?php if(!empty($line_attr)){
                 foreach ($line_attr as $k=>$v){
            ?>
            	<span class="Inva"><?php echo $v['attrname'] ?>:</span>
            	<ul>
            	   <?php if(!empty($v['two'])){ 
            	     foreach ($v['two'] as $key=>$val){
            	   	?>
            		<li value="<?php  echo $val['id'];?>"><?php echo $val['attrname']; ?></li>
            		<?php } }?>
            	</ul>
            	<?php } }?>
            </div>
        </div>-->
        <!--  封面图   -->
         <div class="Upload_photo" style=" padding-top: 10px;">
            <div style="width:100%">
           		<img src="<?php echo base_url('static'); ?>/img/xiangji.png" style="width:auto;height:auto; position: relative; top:7px;" />
             	<span class="webuploader-pic" style="cursor: pointer;margin-left:10px;height:30px; line-height:28px;padding:2px 10px; color:#fff; border-radius:3px; background:#00b7ee;" onclick="uploadImgFile(this,1)">上传封面</span>
            	<div class="photo_tishi" style=" float:right; position: relative; top:10px; width: 500px;">
            		<span style=" display: block; float: none;">旅途印象</span>
            		<textarea class="text_pression" onkeyup="words_deal()" id="text_num" name="travel_impress"><?php if(!empty($travel['travel_impress'])){ echo $travel['travel_impress'];} ?></textarea>
            		<div class="Num_show"><i>300</i>/300</div>
            	</div>

            </div>
            <img alt=""  id="cover_pic_text" style="top:10px;" src="<?php if(!empty($travel['cover_pic'])){ echo $travel['cover_pic'];}else{ echo '/static/img/Upload.jpg';} ?>"/>
            <input type="hidden" name="cover_pic_string" id="cover_pic_string" value="<?php if(!empty($travel['cover_pic'])){echo $travel['cover_pic'];} ?>"/>
        </div>
        <span class="photo_tishi" style=" margin: 10px 0;">请上传1200 x 720像素的照片,且不大于10M</span></span>
        <div class="Text_box">
            <div class="Text_text"><div class="wenzi_center">体验正文</div></div>
        </div>
        <!-- 边走边拍  -->
        <div class="mokuai">
	        <div class="Text_bzbp_title">边走边拍<span>爱摄影，爱美景，还等什么，上传到边走边拍</span></div>
	        <div class="shanghcuan clear"> 
	       		<!--  <span class="webuploader-picArr" onclick="uploadImgFile(this,2)">选择图片</span>-->
	       		<div id="as2" class="webuploader-container"></div>
	        </div>
	        <div class="bzbp_box">
	               <ul class="imgtext_box walk_pics">
	               <?php if(!empty($walkpic)){
	               	foreach ($walkpic as $k=>$v){
					  if(!empty($v)){
	             	?>
	               	 <li><img src="<?php echo $v['pic']; ?>" /><input type="hidden" name="walk_id[]" value="<?php echo $v['id']; ?>"/><input type="hidden" name="walk_pics_string[]" value="<?php echo $v['pic']; ?>"/> 
	               	 <textarea name="walk_content[]"><?php if(!empty($v['description'])){ echo $v['description'];} ?></textarea><i data-del="<?php echo $v['id']; ?>" >×</i>
	                    </li>
	               <?php } } }?>
	               </ul>
	        </div>
        </div>
         <!-- 酒店速写  -->
        <div class="mokuai">
	        <div class="Text_bzbp_title">酒店速写<span>高档酒店、山顶露营、便宜旅馆？爱吐槽、爱得瑟，我有我风格</span></div>
	        <div class="shanghcuan clear">
	       			<!-- <span class="webuploader-picArr" onclick="uploadImgFile(this,3)">选择图片</span> -->
	       			<div id="as3" class="webuploader-container"></div>
	        </div>
	        <div class="bzbp_box">
	               <ul class="imgtext_box hotel_pics">
	                <?php if(!empty($hotelpic)){
	               		foreach ($hotelpic as $k=>$v){
					  	if(!empty($v)){
	             	?>
	               	 <li><img src="<?php echo $v['pic']; ?>" /><input type="hidden" name="hotel_id[]" value="<?php echo $v['id']; ?>"/><input type="hidden" name="hotel_pics_string[]" value="<?php echo $v['pic']; ?>"/> 
	               	 <textarea name="hotel_content[]" ><?php if(!empty($v['description'])){ echo $v['description'];} ?></textarea><i data-del="<?php echo $v['id']; ?>">×</i>
	                    </li>
	               <?php } }}?>
	               </ul>
	        </div>
        </div>
         <!-- 美食写真  -->
        <div class="mokuai">
	       <div class="Text_bzbp_title">美食写真<span>我是吃货，横扫街边美食，发现深巷小店，美食我来曝光</span></div>
	       <div class="shanghcuan clear">
	       		 <!--  <span class="webuploader-picArr" onclick="uploadImgFile(this,4)">选择图片</span>-->
	       		 <div id="as4" class="webuploader-container"></div>
	       </div>
	        <div class="bzbp_box">
	                <ul class="imgtext_box food_pics">
	                        <?php if(!empty($foodpic)){
			               		foreach ($foodpic as $k=>$v){
							  	if(!empty($v)){
			             	?>
			               	 <li><img src="<?php echo $v['pic']; ?>" /><input type="hidden" name="food_id[]" value="<?php echo $v['id']; ?>"/><input type="hidden" name="food_pics_string[]" value="<?php echo $v['pic']; ?>"/>
			               	  <textarea name="food_content[]" ><?php if(!empty($v['description'])){ echo $v['description'];} ?></textarea><i data-del="<?php echo $v['id']; ?>">×</i>
			                    </li>
			               <?php } }}?>
	               </ul>
	        </div>
        </div>
        <div class="main_button">
            <div class="xieyi"><input type="checkbox" name="isagree" id="isagree"  checked="checked"/>我已阅读并同意<a href="/service/member_agreement" target="_blank" style="color: #06f;">《帮游旅游协议》</a></div>
            <?php if(empty($experience)){ ?> 
            <div class="shenqing"><a href="##" onclick="return app_experience()">申请体验师</a></div>
             <?php }?>
            <div class="caogao">保存草稿<input type="submit" name="is_show" value="保存草稿" onclick="return baocunvaluate();" style="opacity:0;cursor: pointer"></input></div>
            <?php if(!empty($travel['id'])){ ?>
            <div class="caogao"><a style="color:#f54;" href="/travels/travels_list/travel_detail_<?php echo $travel['id']; ?>_0.html" target="_blank" >预览体验</a></div>
            <?php } ;?>
           <div class="Publish">发布体验<input type="submit" name="is_show" value="发布体验" onclick="return Checkevaluate();" ></input></div>
        </div>
        </form>
    </div>
 <?php $this->load->view('common/footer'); ?>

<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js" ></script>
<script type="text/javascript">
 var eject_Date="格式不正确,或图片过大!"   //图片格式错误 或过大
$(function(){
	$(".diyStart").css("top","12px")	
})
   //保存游记
  function Checkevaluate(){
          var title=$('input[name="title"]').val();
          if(title==''){
              alert('游记标题不能为空');
              return false;
          }
          var orderid=$('#orderid').val();
          if(orderid==''){
              alert('请选择订单线路');
              return false;
          }
          var cover_pic_string=$('#cover_pic_string').val();
		  if(cover_pic_string==''){
	             alert('请上传封面图片');
	             return false;
	      }
    	  var read=$('#isagree').is(':checked');	  
    	  if(!read){
    		  alert('请已阅读并同意《帮游旅游协议》'); 
    		  return false;
    	  }
     }
     function baocunvaluate(){
         var orderid=$('#orderid').val();
         if(orderid==''){
             alert('请选择订单线路');
             return false;
         }
         var cover_pic_string=$('#cover_pic_string').val();
         if(cover_pic_string==''){
             alert('请上传封面图片');
             return false;
         }
         
     }
	 
	//选择产品标签
 	$('select[name="orderid"]').change(function(){
		var val=$(this).val();
		var id_arr=val.split("-");
		var id=id_arr[1];
        if(id_arr!=''){
    		$.post("<?php echo base_url()?>base/travel/sel_tages", {id:id} , function(result) {
    			result = eval('('+result+')');
    	      	$('.show_ration').html(result.html);
    	      	$('.show_ration').next().css('display','none');
    	      	if(result.tages){
	    		   $(".spanNum").val(result.tages);	
        	    } 	      	
    		}); 
        }
        $('input[name="line_order"]').val(id_arr[0]);
	}); 

 	//上传可裁剪图片
 	var imgProportion = {1:"1200x720",2:"1200x720",3:"1200x720",4:"1200x720"};
 	var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3",4:"xiuxiu_box4"};
 	var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3",4:"xiuxiuEditor4"};
 	function uploadImgFile(obj ,type){
 		$('.avatar_box').show();
 		/*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
	    xiuxiu.setLaunchVars("cropPresets", imgProportion[type]);
 		xiuxiu.embedSWF("altContent",5,'100%','100%');
 		//修改为您自己的图片上传接口
 		xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu'); ?>");
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
 				if (data.code == 2000) {	

					if (type == 1) {  //上传封面图
						  alert('上传成功!');
						 $('#cover_pic_text').attr("src",data.msg);
	 	            	 $('#cover_pic_string').val(data.msg);
 					} else if (type == 2) {  //上传边走边拍图片
 						 alert("上传成功");
 		                 var html= '<li><img src="'+data.msg+'" /><input type="hidden" name="walk_id[]" value=""><input type="hidden" name="walk_pics_string[]" value="'+data.msg+'">';
 		                     html=html+'<textarea name="walk_content[]"></textarea><i data-del="">×</i></li>';
 		                 $('.walk_pics').append(html);
 					} else if (type ==3){   //上传酒店速写图片
 						  alert("上传成功");
 					 	  var html= '<li><img src="'+data.msg+'" /><input type="hidden" name="hotel_id[]" value=""><input type="hidden" name="hotel_pics_string[]" value="'+data.msg+'"> ';
 					 		  html=html+'<textarea name="hotel_content[]"></textarea><i data-del="">×</i></li>';
 	 		              $('.hotel_pics').append(html);	            	    
 					}else if(type ==4){     //上传美食写真图片
 						  alert("上传成功");
 						  var html= '<li><img src="'+data.msg+'" /><input type="hidden" name="food_id[]" value=""><input type="hidden" name="food_pics_string[]" value="'+data.msg+'"> ';
 						 	  html=html+'<textarea name="food_content[]"></textarea><i data-del="">×</i></li>';
 			              $('.food_pics').append(html);
 	 				} 
					 $('.close_xiu').click();  //关闭秀秀
					//删除图片
	        		$(function(){
		        		$(".imgtext_box li").hover(function(){
		        				$(this).find("i").show();
		        				
		        			},function(){
		        				$(this).find("i").hide()
		        		})	
		        		$(".imgtext_box li i").click(function(){
		        			$(this).parent().remove();	
		        		})
		        	}) 
 				} else {
 					alert(data.msg);
 				}
 
 		}
 		$("#img_upload").show();
 		$('.close_xiu').show();
 	}
 	$('.close_xiu').click(function(){  //关闭美图秀秀
 		$("#img_upload").hide()
 		$('.avatar_box').hide();
 		$('.close_xiu').hide();
 	})
 	//删除图片
	$(function(){
		$(".imgtext_box li").hover(function(){
				$(this).find("i").show()
			},function(){
				$(this).find("i").hide()
		})	
		$(".imgtext_box li i").click(function(){
			 if (!confirm("确定要删除?,删除后将无法恢复!")) {
		            window.event.returnValue = false;
		        }else{ 
			        var id=$(this).attr('data-del');
			        if(id>0){
				    	$.post("<?php echo base_url()?>base/travel/delete", {id:id} , function(re) { 
				    		re = eval('('+re+')');
				    		if(re.status==1){
					    		alert(re.msg);
					        }else{
					        	alert(re.msg);
						    }   
						});
				    	$(this).parent().hide();	
			        }else{
			        	$(this).parent().hide();
				     }  	
		        }
		})
	})


//限制字数方法
function words_deal()
	{
		var curLength=$("#text_num").val().length;
		if(curLength>300)
		{
        	var num=$("#text_num").val().substr(0,300);
       		$("#text_num").val(num);
       		$(".Num_show i").html("0")
        	alert("超过字数限制！" );
   		}else{
        	$(".Num_show i").html(300-$("#text_num").val().length);
   		}
	}            		

    //多选标签
    $(function(){
        $(".show_ration").click(function(){
        	 $(".Labe_box").show();
        })
        $(".Labe_box ul li").click(function(){
        	$(".choice").hide();
        	var thstext= $(this).html();   //获取this de html
        	var thsVal= $(this).val();
        	
			var value = $(".spanNum").val();
			if(value==""){
				$(".spanNum").val(thsVal);
			}else{
				$(".spanNum").val(value+","+thsVal);				
			}
        	if($(".show_ration li").length>0){
        	    if($(".show_ration li[value='"+thsVal+"']").length>0){ // 判断val等于点击的这个的数量是否大于0
        		}else{
        			$(".show_ration").append("<li value='"+thsVal+"'>"+thstext+"<i>X</i></li>"); //盒子  
        		}     					
        	}else{
        			$(".show_ration").append("<li value='"+thsVal+"'>"+thstext+"<i>X</i></li>"); 
        	}
        })
        //关闭就删除父级
        $(".show_ration").on('click','li i',function(){
        	var thsVal=$(this).parent().val();
    		var val = $(".spanNum").val();
    		var id_arr=val.split(",");
      		var idArr='';
      		 for (var i = 0; i < id_arr.length; i++) {
                    if (id_arr[i] != thsVal) { 
                        if(i < id_arr.length-2){
                        	idArr=idArr+id_arr[i]+','; 
                        }else{
                        	idArr=idArr+id_arr[i];  
                        }
                    }
          	  	}
      		$(".spanNum").val(idArr);
        	$(this).parent().remove();
        }) 

    })
    //申请体验师
    function app_experience(){
        var line_order=$('input[name="line_order"]').val();
    	$.post("<?php echo base_url()?>base/travel/app_experience", {orderid:line_order} , function(re) { 
    		re = eval('('+re+')');
    		if(re.status==1){
	    		alert(re.msg);	
	        }else{
	        	alert(re.msg);
		    }   
		});
        return false;
    }
	//上传封面多图片
	
	  $('#as').diyUpload({
		swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
		url:"<?php echo base_url('base/travel/upload_picsArr')?>",
		success:function( data ) {
			//console.info( data );  
             if(data.status==1){ 
          	   $('#cover_pic_text').attr("src",data.url);
          	   $('#cover_pic_string').val(data.url)
               }else{
             	   alert(eject_Date);
               }
         $(".bzbp_box ul li").mouseover(function(){
             $(this).find("span").show();
         });
         $(".bzbp_box ul li").mouseleave(function(){
             $(this).find("span").hide();
         });
         $(".bzbp_box ul li span").click(function(){
             $(this).parent("li").remove();
         });
            
		},
		error:function( err ) {
			console.info( err );
		},
		buttonText : '<span style=";height:10px !important; line-height:10px; padding:0px">上传封面</span>',
		chunked:true,
		// 分片大小
		chunkSize:512 * 1024,
		//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
		fileNumLimit:50,
		fileSizeLimit:500000 * 1024,
		fileSingleSizeLimit:50000 * 1024,
		accept: {}
	});
		//上传多图片
	  $('#as2').diyUpload({
		swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
		url:"<?php echo base_url('base/travel/upload_picsArr')?>",
		success:function( data ) {
			//console.info( data );  
              if(data.status==1){
                  //<li><img src="../../../static/img/daren_big.jpg" /><input type="hidden" name="walk_pics_string[]" value=""> <textarea></textarea><i>×</i></li>
                  var html= '<li><img src="'+data.url+'" /><input type="hidden" name="walk_id[]" value=""><input type="hidden" name="walk_pics_string[]" value="'+data.url+'"> <textarea name="walk_content[]"></textarea><i data-del="">×</i></li>';
              	 $('.walk_pics').append(html);
                }else{
              	  alert(eject_Date);
                }

      	$(function(){
      		$(".imgtext_box li").hover(function(){
      				$(this).find("i").show()
      			},function(){
      				$(this).find("i").hide()
      		})	
      		$(".imgtext_box li i").click(function(){
      			$(this).parent().remove();	
      		})
      	})
             
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
		//上传多图片
	  $('#as3').diyUpload({
		swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
		url:"<?php echo base_url('base/travel/upload_picsArr')?>",
		success:function( data ) {
			//console.info( data );
	          if(data.status==1){
	        	 /*  var html= '<li><span>×</span><img src="'+data.url+'"><input type="hidden" name="hotel_pics_string[]" value="'+data.url+'"></li>';
            	 $('.hotel_pics').append(html); */
	        	  var html= '<li><img src="'+data.url+'" /><input type="hidden" name="hotel_id[]" value=""><input type="hidden" name="hotel_pics_string[]" value="'+data.url+'"> <textarea name="hotel_content[]"></textarea><i data-del="">×</i></li>';
             	 $('.hotel_pics').append(html);
              }else{
            	  alert(eject_Date);
              }
          
	        	$(function(){
	        		$(".imgtext_box li").hover(function(){
	        				$(this).find("i").show()
	        			},function(){
	        				$(this).find("i").hide()
	        		})	
	        		$(".imgtext_box li i").click(function(){
	        			$(this).parent().remove();	
	        		})
	        	})

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
		//上传多图片
	  $('#as4').diyUpload({
		swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
		url:"<?php echo base_url('base/travel/upload_picsArr')?>",
		success:function( data ) {
			//console.info( data );
	          if(data.status==1){
           	/*   var html= '<li><span>×</span><img src="'+data.url+'"><input type="hidden" name="food_pics_string[]" value="'+data.url+'"></li>';
            	 $('.food_pics').append(html); */
	        	  var html= '<li><img src="'+data.url+'" /><input type="hidden" name="food_id[]" value=""><input type="hidden" name="food_pics_string[]" value="'+data.url+'"> <textarea name="food_content[]"></textarea><i data-del="">×</i></li>';
	                $('.food_pics').append(html);
              }else{
            	  alert(eject_Date);
              }
	        	$(function(){
	        		$(".imgtext_box li").hover(function(){
	        				$(this).find("i").show()
	        			},function(){
	        				$(this).find("i").hide()
	        		})	
	        		$(".imgtext_box li i").click(function(){
	        			$(this).parent().remove();	
	        		})
	        	})
 
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
</script>












	
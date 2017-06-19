
	<form action="<?php echo base_url()?>admin/b1/product/updatelineTrain" accept-charset="utf-8"   method="post" 
	id="lineTrainForm" novalidate="novalidate" >
	<div class="widget-body">
	  <input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" /> 
	
	 <div style="margin-left:6px;width:870px;color:red;"> 
	 <span>旅游管家在申请售卖权时，需认真阅读您的“管家培训”内容后才可得到资质。因此请您认真填写在售卖此条线路时，游客最经常问到的至少十个问题（多不限），并提供相对固定的参考答案。</span></div>
		<div class="form-group problem_content" style="margin-left:0.5%;margin-top:20px;display: -moz-inline;display: -webkit-inline; display: inline;">
			<?php if(!empty($train)){ 
			  if(count($train)<10){ 
				    $trainmun=count($train);   
			?>
			<?php  for($i = 0; $i < $trainmun; ++ $i) {  ?>
			<div class="problem_div">
				<div class="problem_title fl">
				       <span class="num"><?php if($i<3){?><i class="important_title" >*</i><?php } ?>问题<?php echo $i+1; ?></span>
				       <input type="hidden"  name="train_id[]" value="<?php echo $train[$i]['id']; ?>"/>
				</div>
				<div class="hot_problem">
					<label>Q：</label>
					<input  type="text" name="question[]"  value="<?php echo $train[$i]['question']; ?>" placeholder="请输入热门问题">
					<i class="icon icon_1"   onclick="del_train(this,<?php echo $train[$i]['id'] ;?>)"></i>
				</div>
				<div class="delete_bomb">
				<span>点击按钮,删除此问题</span>
				</div>
				<div class="problem_answer">
					<label>A：</label>
					<textarea name="answer[]" placeholder="请输入参考答案"><?php echo $train[$i]['answer']; ?></textarea>
				</div>
			</div>
			<?php } ?>
			<?php  for($trainmun; $trainmun < 10; ++ $trainmun) {  ?>
			<div class="problem_div">
				<div class="problem_title fl">
				       <span class="num"><?php if($trainmun<3){?><i class="important_title" >*</i><?php } ?>问题<?php echo $trainmun+1; ?></span>
				       <input type="hidden"  name="train_id[]" value=""/>
				</div>
				<div class="hot_problem">
					<label>Q：</label>
					<input  type="text" name="question[]"  value="" placeholder="请输入热门问题">
					<i class="icon icon_1"   onclick="del_train(this,'')"></i>
				</div>
				<div class="delete_bomb">
				<span>点击按钮,删除此问题</span>
				</div>
				<div class="problem_answer">
					<label>A：</label>
					<textarea name="answer[]" placeholder="请输入参考答案"></textarea>
				</div>
			</div>
			<?php } ?>
	                                <?php }else{ 
	                                	foreach ($train as $k=>$v){ 
			 ?>
			<div class="problem_div">
				<div class="problem_title fl">
				       <span class="num"><?php if($k<3){?><i class="important_title" >*</i><?php } ?> 问题<?php echo $k+1; ?></span>
				       <input type="hidden"  name="train_id[]" value="<?php echo $v['id']; ?>"/>
				</div>
				<div class="hot_problem">
					<label>Q：</label>
					<input  type="text" name="question[]"  value="<?php echo $v['question']; ?>" placeholder="请输入热门问题">
					<i class="icon icon_1"   onclick="del_train(this,<?php echo $v['id'] ;?>)"></i>
				</div>
				<div class="delete_bomb">
				<span>点击按钮,删除此问题</span>
				</div>
				<div class="problem_answer">
					<label>A：</label>
					<textarea name="answer[]" placeholder="请输入参考答案"><?php echo $v['answer']; ?></textarea>
				</div>
			</div>	
			<?php } }}else{?>
	                                <?php $num=10;
	                                for($i = 0; $i < $num; ++ $i) {
	                                ?>
                                	<div class="problem_div">
				<div class="problem_title fl">
				       <span  class="num"><?php if($i<3){?><i class="important_title" >*</i><?php } ?> 问题<?php echo $i+1; ?></span><input type="hidden"  name="train_id[]" value=""/>
				</div>
				<div class="hot_problem">
					<label>Q：</label>
					<input  type="text" name="question[]"  value="" placeholder="请输入热门问题">
					<i class="icon icon_1"    onclick="del_train(this,'')"></i>
				</div>
				<div class="delete_bomb"><span>点击按钮,删除此问题</span></div>
				<div class="problem_answer">
					<label>A：</label><textarea name="answer[]" placeholder="请输入参考答案"></textarea>
				</div>
			</div>

          			<?php } }?>

		</div>
	</div>
	<div class="div_bt_i">
	      <div class="tjia_btn fl train_btn"  ><span >+添加</span></div>
		  <label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:20%;"></label>
		  <button  class="btn btn-palegreen"  type="button" id="sb_linetrain"> <b  style="font-size:14px">保存</b></button>
		  <?php if(!empty($type_train)&&$type_train==2){?>

		  <button class="btn btn-palegreen cjia_btn_1" type="button" id="next_inetrain" style="margin-left:150px; " >
		  <?php  if($is_union==1){?>
		  <b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">进入定制团</span></button> <i> </i>
		  <?php }else{?>
		  <b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">进入定制团</span></button> <i> </i>
		  <?php }  ?>
		  <?php }else{ ?>
		<button class="btn btn-palegreen cjia_btn_1" type="button" id="next_inetrain" style="margin-left:150px; " ><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">进入产品汇总</span></button> <i> </i>
		  <?php  } ?>
	</div>
	</form>

<script type="text/javascript">

//保存管家培训
//function ChecklineTrain(){	
jQuery('#sb_linetrain,#next_inetrain').click(function(){
	//管家培训,前三个必填
	var qID=$("input[name='question[]']");
	var answer=$("textarea[name='answer[]']");
	var flag=true;
	 qID.each(function(key,val){
	 	if(key<3){
	   		 if($(this).val()=='' || answer.eq(key).val()==''){
	   		 	alert('前三个管家培训问题必填');
	   		 	 flag=false;
	   		 }	
	 	}
	  });
	 if(!flag){
		return false; 	
	 }
	
	var index=$(this).index();　
	var html='';
		jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineTrainForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/updateTrain", 
			 beforeSend:function() {//ajax请求开始时的操作
		                        $('#sb_linetrain,#next_inetrain').addClass("disabled");
		              },
		              complete:function(){//ajax请求结束时操作
		                        $('#sb_linetrain,#next_inetrain').removeClass("disabled");
		              },
			success : function(response) {
		
			 var response=eval("("+response+")");
			  if(response.status==1){
				   
				var train_len= response.train.length
				$.each(response.train,function(n,value) {
					if(n<3){
						var str='<i class="important_title" >*</i>';
					}else{
						var str='';	
					}
					
				    	html=html+'<div class="problem_div"><div class="problem_title fl">';
					html=html+'<span class="num">'+str+'问题'+(n+1)+'</span>'; 
					html=html+'<input type="hidden"  name="train_id[]" value="'+value.id+'"/></div>';
					html=html+'<div class="hot_problem"><label>Q：</label><input  type="text" name="question[]"  value="'+value.question+'" placeholder="请输入热门问题">';  
					html=html+'<i class="icon icon_1"   onclick="del_train(this,'+value.id+')"></i></div>';  
					html=html+'<div class="delete_bomb"><span>点击按钮,删除此问题</span></div>';
					html=html+'<div class="problem_answer"><label>A：</label>';
					html=html+'<textarea name="answer[]" placeholder="请输入参考答案">'+value.answer+'</textarea></div></div>';    
				})
				if(train_len>10){
					$('.problem_content').html(html);
				}else{
					var len=train_len;
					for(var i=10;train_len<i;i--){
						if(i<3){
							var str='<i class="important_title" >*</i>';
						}else{
							var str='';	
						}
					
						len=len+1;
					    	html=html+'<div class="problem_div"><div class="problem_title fl">';
						html=html+'<span class="num">'+str+'问题'+len+'</span>'; 
						html=html+'<input type="hidden"  name="train_id[]" value=""/></div>';
						html=html+'<div class="hot_problem"><label>Q：</label><input  type="text" name="question[]"  value="" placeholder="请输入热门问题">';  
						html=html+'<i class="icon icon_1"   onclick="del_train(this,0)"></i></div>';  
						html=html+'<div class="delete_bomb"><span>点击按钮,删除此问题</span></div>';
						html=html+'<div class="problem_answer"><label>A：</label>';
						html=html+'<textarea name="answer[]" placeholder="请输入参考答案"></textarea></div></div>';    
					}
					$('.problem_content').html(html);
				}
				alert(response.msg);
				
				if(index==3){
					//下一步						
					/*$("#expert_training").removeClass('active');
					$("#profile17").removeClass('active');
		
					$("#supplierGift").addClass('active');
					$("#profile13").addClass('active');*/
					var is_union=<?php if(!empty($is_union)){ echo $is_union;}else{ echo 0;} ?>;
					var type="<?php if(!empty($type)){ echo $type;}else{ echo 0;} ?>";
	 				 <?php if(!empty($type_train)&&$type_train==2){?>
	 				 	if(is_union==1){
	 				 		
	 				 		if(type=='b_group_line'){
	 				 			window.location.href="/admin/b1/b_group_line";
	 				 		}else{
	 				 			window.location.href="/admin/b1/group_line/product_list"; 	
	 				 		}
							
						}else{
							window.location.href="/admin/b1/b_group_line";
						}
					<?php }else{?>
						if(is_union==1){
							if(type=='products'){
								window.location.href="/admin/b1/products/product_list";	
							}else{
								window.location.href="/admin/b1/product";	
							}
						}else{
							window.location.href="/admin/b1/product";
						}
					<?php } ?>
				}
	 
				}else{
					alert(response.msg);  
				}   
			}
		});
	return false;
});
//添加管家培训
$(".train_btn").on('click', function () {


	var l=$(".problem_div").length - 1;
	var n=$(".problem_div").length +1;

	if(n<4){
		var str='<i class="important_title" >*</i>';
	}else{
		var str='';	
	}

	var train_html ='<div class="problem_title fl"> <span  class="num">'+str+'问题'+n+'</span><input type="hidden"  name="train_id[]" value=""/></div>';
	train_html=train_html+'<div class="hot_problem"><label>Q：</label><input  type="text" name="question[]" placeholder="请输入热门问题"><i class="icon icon_1"  onclick="del_train(this,-1)"></i></div>';
	train_html=train_html+'<div class="delete_bomb"><span>点击按钮,删除此问题</span></div>';
	train_html=train_html+'<div class="problem_answer"><label>A：</label><textarea name="answer[]" placeholder="请输入参考答案"></textarea></div>';

	if(l==-1){    
		var trlen = $(".problem_content");           
		trlen.html("<div class='problem_div'>"+train_html+"</div>"); 
	}else{
		var trlen = $(".problem_div").eq(l);           
		trlen.after("<div class='problem_div'>"+train_html+"</div>"); 
	}
	$('.icon_1').hover(function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').show();
	},function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').hide();
	});    
     
});
//删除管家培训
function del_train(obj,id){    
	var index = $(".icon_1").index(obj);
	if(id!='' && id>0){
		if (!confirm("确定要删除？")) {
	            	window.event.returnValue = false;
	        	}else{
			jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/product/deleteTrain",
				success : function(response) {
					if(response){
						alert('删除成功！');
						$(".problem_div").eq(index).remove();
						$(".problem_div").each(function(i){
							var index = $(".problem_div").index(this);
							//var num = parseInt($(this).find(".num").html());
							if(index<3){
								var str='<i class="important_title" >*</i>';
							}else{
								var str='';	
							}

							$(this).find(".num").html(str+'问题'+(index+1));
						});
					}else{
						alert('删除失败！');
					}
				}
			});
	       	 }
	}else{
		//alert('删除成功！');
		$(".problem_div").eq(index).remove();
		$(".problem_div").each(function(i){
			var index = $(".problem_div").index(this);
			if(index<3){
				var str='<i class="important_title" >*</i>';
			}else{
				var str='';	
			}
			$(this).find(".num").html(str+'问题'+(index+1));
		});
	}	
}

//删除管家培训问题
$(function () {  
	$('.icon_1').hover(function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').show();
	},function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').hide();
	});
})

</script>


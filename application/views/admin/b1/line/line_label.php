	<form action="<?php echo base_url()?>admin/b1/product/updateLabel" class="form-horizontal bv-form"  method="post" 
						id="lineLabelForm" novalidate="novalidate"  >
		<div class="widget-body">
			<div class="form-group" style="padding:0px 0px 10px 0px;">					
					<div class="col-sm-2 control-label no-padding-right label-width col_xl" style="float: none;width:100%;max-width: 810px;" for="inputEmail3" >
					<span style="color: red;">*</span>
					请点击以下标签进行选择：（客人根据兴趣寻找心仪的旅游线路时，会使用关键字标签进行搜索，若您不设标签将脱离于客人视线之外）
					<div class=" col_ip" style="width: 70%;padding-top: 5px;padding-left: 20px;">
				    	<input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" />
						<div class="col-lg-4 no-padding-left" id="select_attr" style="width:820px; float:left;">
							 <div class="pop_city_container">
							 	<div class="tab" id="line_attr_tab">
							 		
							 		 <?php if(!empty($attr)){
							 		 	$attr_data=explode(',', $data['linetype']);
							 			foreach ($attr as $k=>$v){?>
							 		 <?php 
									 		echo '<div class="city_item_in" ><span class="city_item_letter" >'.$v['attrname'].'</span>';
									 		foreach($v['two'] as $key=>$val){
                                                    								if (in_array($val['id'], $attr_data)) {$selected="attr-item-selected";}else{$selected=''; } 		
													echo '<a href="##" title="'.$val['attrname'].'"  class="attr-item '.$selected.'" dataid="'.$val['id'].'">'.$val['attrname'].'</a>';
									 		}
									 		echo '</div>';
									 	}
									 } ?>
							 	</div>
							 </div>
							 <input name="linetype" value="<?php echo  $data['linetype'];?>" id="linetype" type="hidden" />													  
						</div>
					</div>
				</div>
			</div>
		 </div>
			<div class="registration-form">	
				<label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:10%;"></label>
				<button class="btn btn-palegreen" id="sb_label" onclick="return updateLabel();"  ><b  style="font-size:14px">保存</b></button>
				<button class="btn btn-palegreen" id="next_label"  type="button" onclick="return updateLabel();"  style="margin-left:150px; "><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
			</div>
	</form>

<script type="text/javascript">

//产品标签
jQuery('#sb_label,#next_label').click(function(){
	//限制线路属性的选择
	var linetype=$('#linetype').val();
	if(linetype==''){
		alert('线路属性不能空！');
		return false;
	}
	 var index=$(this).index();　
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineLabelForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/lineLabelForm", 
		success : function(response) {
		 	 if(response!='' && response!='0'){	 	 
				alert( '保存成功！' );
				if(index==2){
					//下一步
					show_line_train(<?php  if(!empty($data['id'])){echo $data['id']; }?>);						
					$("#click_tips").removeClass('active');
					$("#profile15").removeClass('active');
		
					$("#expert_training").addClass('active');
					$("#profile17").addClass('active'); 
				}
			
			}else{
				alert( '保存失败' );
			}   
		}
	});
	
	return false;
});
  
 /*------------------------------------------------线路属性-------------------------------------------------------*/ 
 jQuery(document).ready(function() {
	 
	 jQuery('.attr-item').on("click",function(){

		 var me = jQuery(this);
		 if(me.hasClass('attr-item-selected')){
			jQuery(this).removeClass('attr-item-selected');
			var dataid=jQuery(this).attr('dataid');
			var linetyle=$('input[name="linetype"]').val();
			//alert(dataid);
			var tyle_arr=linetyle.split(",");
             		var id_str='';
		      	for (var i = 0; i < tyle_arr.length; i++) {
			           if (tyle_arr[i] != dataid) { 
				           	if(tyle_arr[i]!=''){
				           	 	if(id_str!=''){
						            id_str=id_str+','+tyle_arr[i]; 
						}else{
						            id_str=id_str+tyle_arr[i];  
						}
				           	}      
			          }
      	  	 	}
			 $('input[name="linetype"]').val(id_str);
			 
		 }else{
			 var attr_len=$('.pop_city_container').find('.attr-item-selected').length;
			 if(attr_len>7){
                			alert('你选择的产品标签已经超过8个了');
                 			return false;
			 }else{
				 jQuery(this).addClass('attr-item-selected')
				 var dataid=jQuery(this).attr('dataid');
				 var linetyle=$('input[name="linetype"]').val();
				 var id_str='';
				 
				if(linetyle!=''){
					id_str=linetyle+','+dataid;
				}else{
					id_str=dataid;
				}
				$('input[name="linetype"]').val(id_str);
			 }
		 }
	 });

	 
 });
//删除table
 $('#attr-list').on("click", 'a[name="delAttrLable"]',function(){
        	var id= $(this).attr('data');
        	var value=$("input[name='linetype']").attr('value');
       	$("#ds-"+id).remove();
        	if(value!=''){
        		var id_arr=value.split(",");
        		var id_str='';
	  	for (var i = 0; i < id_arr.length; i++) {
	                 	if (id_arr[i] != id) { 
		                   	if(i < id_arr.length-2){
		                    		id_str=id_str+id_arr[i]+','; 
		                   	}else{
		                    		id_str=id_str+id_arr[i];  
		                  	}
	                	}
	      	}
  	 	$("input[name='linetype']").val(id_str); 
       	}
  })
</script>
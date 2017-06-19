
<form action="<?php echo base_url()?>admin/b1/product/updatelineFee" accept-charset="utf-8"  class="form-horizontal bv-form"  method="post"  id="lineFeeForm" novalidate="novalidate">
		<div class="widget-body">
			<div id="registration-form">
			<input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" />
                                     <table class="departure_notice table_form_content table_td_border" border="1" width="800">                                
                                        <tbody>
                                            <tr class="form_group">
                                                <td class="form_title w_100"><i class="important_title">*</i>费用包含：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="feeinclude" id="feeinclude"><?php if(!empty($data['feeinclude'])){ echo $data['feeinclude'];} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100"><i class="important_title">*</i>费用不含：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="feenotinclude" id="feenotinclude"><?php if(!empty($data['feenotinclude'])){ echo $data['feenotinclude'];} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">购物自费：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="other_project" id="other_project"><?php if(!empty($data['other_project'])){ echo $data['other_project'];}?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">保险说明：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="insurance" id="insurance"><?php if(!empty($data['insurance'])){ echo $data['insurance'];} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">签证说明：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="visa_content" id="visa_content"><?php if(!empty($data['visa_content'])){ echo$data['visa_content']; } ?></textarea></td>
                                            </tr>
                                        </tbody>
                                    </table>
									
			</div>
		</div>
    	<div class="div_bt_i">
		<label for="inputImg" class="col-sm-2 control-label no-padding-right"style=" width:17%;"></label>
		<button  class="btn btn-palegreen" type="button" id="sb_fee" onclick="return CheckFee();" ><b  style="font-size:14px">保存</b></button>
		<button class="btn btn-palegreen" type="button" style="margin-left:150px;" id="next_fee" onclick="return CheckFee();" ><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
	</div>
</form>

<script type="text/javascript">
//费用说明的提交表单
jQuery('#sb_fee,#next_fee').click(function(){
  	 var feeinclude=$('#feeinclude').val();
  	 if(feeinclude==0){
  		alert('费用包含不能为空！');
		 return false;
	  }
	 var feenotinclude=$('#feenotinclude').val();
  	 if(feenotinclude==0){
  		 alert('费用不包含不能为空！');
		 return false;
	  }
	  var index=$(this).index();　
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineFeeForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/updatelineFee", 
		success : function(response) {			
		 	 if(response!='' && response!='0'){ 	 
				alert( '保存成功！' );	
				if(index==2){
					show_line_offere(<?php  if(!empty($data['id'])){echo $data['id']; }?>);
                                                                    //下一步
                                                                 $('#click_Bookings').click(); 				
					$("#click_feedesc").removeClass('active');
					$("#profile14").removeClass('active');
					$("#click_Bookings").css('display','block'); 
					$("#click_Bookings").addClass('active');
					$("#profile16").addClass('active'); 
				}
	
			}else{
				alert( '保存失败' );
			}   
		}
	});
	return false;
});

</script>
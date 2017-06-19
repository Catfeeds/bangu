	<form action="<?php echo base_url()?>admin/b1/product/updateBookNotice" accept-charset="utf-8"  method="post" id="lineNoticeForm" novalidate="novalidate" >
	<div class="widget-body">
                        	<input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" />
                    		<table class="departure_notice table_form_content table_td_border" border="1" width="800">                                
                                <tbody>
                                    <tr class="form_group">
                                        <td class="form_title w_100"><i class="important_title">*</i>温馨提示：</td>
                                        <td><textarea class="form_textarea w_600 noresize" name="beizu" id="editor"><?php if(!empty($data['beizu'])){ echo $data['beizu'];} ?></textarea></td>
                                    </tr>
                                    <tr class="form_group">
                                        <td class="form_title w_100"><i class="important_title">*</i>特别约定：</td>
                                        <td><textarea class="form_textarea w_600 noresize" name="special_appointment" id="special_appointment"><?php if(!empty($data['special_appointment'])){ echo $data['special_appointment'];} ?></textarea></td>
                                    </tr>
                                    <tr class="form_group">
                                        <td class="form_title w_100"><i class="important_title">*</i>安全提示：</td>
                                        <td><textarea class="form_textarea w_600 noresize" name="safe_alert" id="safe_alert"><?php if(!empty($data['safe_alert'])){ echo $data['safe_alert'];} ?></textarea></td>
                                    </tr>  
                                    <tr class="form_group">
                                            <td class="form_title w_100"><i class="important_title"></i>附件上传：</td>
                                            <td class="attachment_content">  <input type="file" id="upfile" name="upfile"  />
                                                     <input type="button"  id="updatafile" value="上传" style="padding: 3px;margin-left:15px" />
                                                     <?php if(!empty($protocol)){
                                                            foreach ($protocol as $key => $value) {
                                                     ?>
                                                    <div id="attachment_list">
                                                         <span class="selectedContent" value="">
                                                                  <?php echo $value['name']; ?>
                                                                  <input type="hidden" id="attachment_name" name="attachment_name[]" value="'+data.urlname+'" />
                                                                  <input type="hidden" id="attachment" name="attachment[]" value="<?php echo $value['url'];?>" />
                                                                 <span class="delPlugin" onclick="delSpan(this);">x</span>
                                                         </span>
                                                     </div>
                                                     <?php  }   }?>
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>			
							
	</div>
	<div class="div_bt_i">
		<label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:17%;"></label>
		<button class="btn btn-palegreen" id="sb_linenotice" onclick="return ChecklineNotice();" ><b  style="font-size:14px" >保存</b></button>
		<button class="btn btn-palegreen" id="next_linenotice"  type="button" style="margin-left:150px;" onclick="return ChecklineNotice();" ><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
	</div>
 </form>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
 <script type="text/javascript">

//参团须知 的提交表单
jQuery('#sb_linenotice,#next_linenotice').click(function(){
//function ChecklineNotice(){
        var editor=$('#editor').val();
        if(editor==''){
                 alert('温馨提示内容不能为空');
                 return false;
          }
         var special_appointment=$('#special_appointment').val();
         if(special_appointment==''){
             alert('特别约定不能为空');
         	 return false;
         }

         var safe_alert=$('#safe_alert').val();
         if(safe_alert==''){
                alert('安全提示内容不能为空！！');
                return false;
          }
        var index=$(this).index();
        jQuery.ajax({ type : "POST",async:false, data : jQuery('#lineNoticeForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/updateBookNotice", 
            success : function(response) {      
                 if(response!='' && response!='0'){
                    alert( '保存成功！' ); 
                    if(index==2){
                         //下一步        
                         show_line_label(<?php  if(!empty($data['id'])){echo $data['id']; }?>);  
                        $("#click_Bookings").removeClass('active');
                        $("#profile16").removeClass('active');
                        $("#click_tips").css('display','block');
                        $("#click_tips").addClass('active');
                        $("#profile15").addClass('active');     
                    }
            
                }else{
                    alert( '保存失败' );
                }   
            }
        });
    
    return false;
});
    
//删除附件
function delSpan(obj){
        $(obj).parent().parent('#attachment_list').remove();
}
//上传附件
$('#updatafile').on('click', function() {
            $.ajaxFileUpload({url:'/admin/b1/product/up_attachment',
            secureuri:false,
            fileElementId:'upfile',// file标签的id
            dataType: 'json',// 返回数据的类型
            data:{filename:'upfile'},
            success: function (data, status) {
                     if (data.status == 1) {
                          alert("上传成功");
                          var str='';
                          str=str+'<div id="attachment_list">';
                          str=str+'<span class="selectedContent" value="">'+data.urlname;
                          str=str+'<input type="hidden" id="attachment_name" name="attachment_name[]" value="'+data.urlname+'" />';
                          str=str+' <input type="hidden" id="attachment" name="attachment[]" value="'+data.url+'" />';
                          str=str+' <span class="delPlugin" onclick="delSpan(this);">x</span>';
                          str=str+'</span></div>';
                          $('.attachment_content').append(str); 
                     } else {
                          alert(data.msg);
                     }
            },
             error: function (data, status, e) {
                 alert("请选择不超过10M的doc,docx的文件上传");
            }
           });
        return false;
});

    </script>
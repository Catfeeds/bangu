		<div class="widget-body" style="width: 100%;">
			   <form action="<?php echo base_url()?>admin/b1/product/updatelineTrain" accept-charset="utf-8" method="post" 
					id="lineGiftForm" novalidate="novalidate" onsubmit="return ChecklineGift();"  >
					  <input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" /> 
				<div id="registration-form">
				   <div class="title_zif"><span>抽奖礼品</span>&nbsp;&nbsp;&nbsp;&nbsp;
				   	<span class="tianjia_btn"  id="addgift" style="cursor:pointer;padding:6px 10px;color:#fff;background-color:#2dc3e8">+添加</span>&nbsp;&nbsp;&nbsp;&nbsp;
				    <span class="tianjia_btn"  id="selgift" style="cursor:pointer;padding:6px 10px;color:#fff;background-color:#2dc3e8">+选择</span>
				   </div></br>
				   <div>
				        <input type="hidden" name="hasClass" id="hasClass" value="<?php if(!empty($gift)){ echo 1;}?>" >
				       <table  class="table table-striped table-hover table-bordered dataTable no-footer"> 
						    <thead class="gift_title">
						     <?php if(!empty($gift)){ ?>
						        <tr role="row">
						            <th style="width: 100px;text-align:center">礼品名称</th>
						            <th style="width: 80px;text-align:center" >有效期</th>
						            <th style="width: 60px;text-align:center" >图片</th>
						            <th style="width: 40px;text-align:center" >数量 </th>
						            <th style="width: 80px;text-align:center" >价值</th>
						            <th style="width: 60px;text-align:center" >状态</th>
						            <th style="width: 150px;text-align:center">操作</th>
						        </tr>
						       <?php }?>
						    </thead>
					 
						    <tbody class="gift_text">
				                               <?php if(!empty($gift)){ 
				                                		foreach ($gift as $k=>$v){	
				                                ?>
						           <tr class="gift_tr<?php echo $v['glid']; ?>">
							            <td style="text-align:center" class="sorting_1">
							            <?php echo $v['gift_name']; ?></td>
							            <td style="text-align:center" class=" "><input type="hidden"  value="<?php echo $v['id']; ?>"/><?php echo $v['starttime'].'至'.$v['endtime']; ?></td>
							            <td  style="text-align:center" class="center  "><img style="width:65px; height:65px; " src="<?php echo $v['logo']; ?>" ></td>
							            <td style="text-align:center" class=" "><?php if(!empty($v['gift_num'])){ echo $v['gift_num'];}else{ echo 0;}?>张</td>
							            <td style="text-align:center" class=" "><?php if(!empty($v['worth'])){ echo $v['worth'];}?></td>
							            <td style="text-align:center" class=" "><?php if($v['status']==0){ echo '上架';}elseif($v['status']==1){echo '下架';} ?></td>
							            <td style="text-align:center" class="caozuo ">
							            	    <span class="look_gift" onclick="look_gift(this)" data="<?php echo $v['id']; ?>">查看</span>
							            	 <!-- <span class="edit_gift" onclick="edit_gift(this)" data="<?php echo $v['id']; ?>">编辑</span> --> 
							            	    <span class="del_gift"  data="<?php echo $v['glid']; ?>" onclick="del_gift(this);">删除</span>
							            </td>
						          </tr>
						        <?php } }?>
							</tbody>
					</table>  
			</div>		
			</div>
				<div class="registration-form" style="margin:30px 0px 0px 570px;">	
					<button class="btn btn-palegreen"  type="submit" id="save_line_gift" style="display:none">保存</button>
				</div>
			</form>
		</div>

	<div class="title_info_box" style="display:none;position:fixed;border:1px solid #f00;text-align:left;text-indent:30px;width:300px;padding:10px;background:#fff;z-index:999;color:#f00;font-size:14px;top:100px;right:20px;font-weight:600;">	
       	
              </div>



<!--添加礼品弹框  编辑礼品   -->
<div class="lp_div modal fade in" style="display:none">
	<div style="position:absolute;left:50%;margin-left:-300px;" class="modal-dialog">
		  <div style="width:600px;" class="modal-content">
		       <div class="modal-header">
			       <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
			       <h4 class="modal-title gift_biaoti">添加新增礼品</h4>
			    </div>
			    <div class="modal-body"><div class="bootbox-body">
			       <form  class="form-horizontal" id="giftFrom" method="post" action="">	
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>礼品名称:</label>
			            <div class="col-sm-4 fl">
			            	<input name="line_id" value="<?php echo $data['id'];?>" id="line_id" type="hidden" />
			            	<input name="gift_id" value="" id="gift_id" type="hidden" />
			                <input type="text" style="height:30px;" name="gift_name">
			            </div>
			        </div>
			         <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>有效期:</label>
			           <div class="col-sm-4 fl">
					<div style="width:200px; float:left;" class="input-group col-sm-10 ">
						<input type="text" data-date-format="yyyy-mm-dd" name="startdatetime" id="starttime" class="form-control date-picker fl" style="width:162px">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>				
					<span class="hege">-</span>
					<div style="width:200px;float:left" class="input-group col-sm-10 fl">
						<input type="text" data-date-format="yyyy-mm-dd"  name="enddatetime" id="endtime" class="form-control date-picker fl" style="width:162px">
						<span class="input-group-addon"> <i class="fa fa-calendar"></i></span>
					</div>			
			           </div>
			        </div>
			         <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>礼品总数量:</label>
			            <div class="col-sm-4 fl">
			               <input type="text" name="account" style="height:30px;float:left" />&nbsp;<span class="jg_my ">张</span>
			            </div>
			        </div>
			         <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>添加的数量:</label>
			            <div class="col-sm-4 fl">
			               <input type="text" name="add_account" style="height:30px;float:left" />&nbsp;<span class="jg_my ">张</span>
			            </div>
			        </div>
			        <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl"  for="inputPassword3"><span style="color: red;">*</span>价值:</label>
			            <div class="col-sm-4 fl ">
			               <input type="text" name="worth" style="height:30px;float:left" />&nbsp;<span class="jg_my">元</span>
			            </div>
			        </div>
			        <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">图片:</label>
			            <div class="col-sm-4 fl " id="gift_pic" >
			              <img style="width:170px;height:150px;" src="">
			              <input type="hidden" name="logo" value=""/>
			              <span class="webuploader-pick" onclick="change_avatar(this,2);" >+/1上传图片</span>
			            </div>
			        </div>
			          <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>说明:</label>
			            <div class="col-sm-4 fl">
			               <textarea name="description"></textarea>
			            </div>
			        </div>
			        <div class="form-group">
			            <input type="button" style="float: right; margin-right: 2%;" value="提交" id="gift_button" class="btn btn-palegreen">        
			        </div>  
			    </form>
			    </div>
		     </div>
		 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>

<!-- 查看礼品结束 -->	
<div class="lookgfit_div modal fade in" style="display:none;">
	<div style="position:absolute;left:50%;margin-left:-300px;" class="modal-dialog">
		  <div style="width:600px;height:500px;" class="modal-content">
		       <div class="modal-header">
			       <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
			       <h4 class="modal-title gift_biaoti">礼品详情</h4>
			    </div>
			    <div class="modal-body"><div class="bootbox-body">
			       <form  class="form-horizontal" id="lookgiftFrom" method="post" action="">	
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">礼品名称:</label>
			            <div class="col-sm-4 fl gift_div_1 gift_div">
			            	<span></span>
			            </div>
			        </div>
			         <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">有效期:</label>
			            <div class="col-sm-4 fl gift_div_2 gift_div" style="width:400px;">
							 <span></span>		
			            </div>
			        </div>
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">数量:</label>
			            <div class="col-sm-4 fl gift_div_3 gift_div">
			              <span></span>
			            </div>
			        </div>
			        <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl"  for="inputPassword3">价值:</label>
			            <div class="col-sm-4 fl gift_div_4 gift_div">
			              <span></span>
			            </div>
			        </div>
			        <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">图片:</label>
			            <div class="col-sm-4 fl gift_div_5 gift_div" id="gift_pic" >
			              <span></span>
			            </div>
			        </div>
			        <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">说明:</label>
			            <div class="col-sm-4 fl gift_div_6 gift_div">
			              <span></span>
			            </div>
			        </div>
 
			    </form>
			    </div>
		     </div>
		 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<!-- 结束  -->
<!-- 选择礼品 -->
<div style="display: none;" class="tbtsd">
	<div class="closetd" style="opacity: 0.2; padding:6px 0 0 5px;font-size: 35px; font-weight: 800;">×</div>
	<div align="center" style="height:100%;">
		<div class="widget-body" style="height:100%;">
			<div id="registration-form" class="messages_show" style="height:90%;overflow-y:auto;overflow-x:hidden;margin-top:35px; ">
				<form
					data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
					data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
					data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
					data-bv-message="This value is not valid"
					class="form-horizontal bv-form" method="post" id="listForm"
					novalidate="novalidate">
					<div class="form-group has-feedback">
						<label class="col-lg-4 control-labe fl" style="width:auto">礼品名称：</label>
						<div class="col-lg-4 fl" style="width:100px" id="linelist_div">
							<input type="text" placeholder="礼品名称-模糊搜索" name="title" class="form-control user_name_b1" style="padding-right:0px;width:170px;"> 
							<input type="hidden" name="linelistID" value="<?php echo $data['id'];?>"  class="form-control user_name_b1"> 
							<input type="hidden" name="lineGiftListID" id="lineGiftListID" value=""  class="form-control user_name_b1"> 
							
						</div>
						<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
						<div class="col-lg-4 fl" style="width: 80px;margin-left:100px;">
							<input type="button" value="搜索" id="searchBtn" class="btn btn-palegreen">
						</div>
					</div>
				</form>	
				<form action="" id='supplier_gift' name='supplier_unsettled_order' method="post" onSubmit="return checkgift()">
					<div id="gift_list"></div>
					<div><input type="hidden" name="line_id" value="<?php echo $data['id'];?>"/></div>
					<div style="margin-top: 15px;"><input type="submit" class="btn btn-info btn-xs" style="width:55px;height:30px;margin:10px;" value="提交">
                    <input type="button"  class="btn btn-info btn-xs close_gift" style="width:55px;height:30px;margin:10px;" value="关闭"></div>
                 </form>		
			</div>
		</div>
	</div>
</div>
<div class="messages_color" style="display: none;"></div>
<!-- 结束 -->

<script type="text/javascript">
//保存礼品
function ChecklineGift(){
	 jQuery.ajax({ type : "POST",data : jQuery('#lineGiftForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/save_gift_data", 
		 success : function(data) {	
			 var data=eval("("+data+")");
			 if(data.status==1){
				 alert(data.msg);
				//  window.location.href="/admin/b1/product";
				  window.close();
				//  window.opener.location.reload(); 
			 }else{
				alert(data.msg);
			}
		}
	});	 
	return false;
}

</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/order_detail_info.css');?>" rel="stylesheet" />
<style type="text/css">
 .trip_content_left{ font-weight: bold;}
.order_title_name{width:140px;}

</style>
<div id="order_info">
  <div id="order_header">
    <div style="background-color:#f3f3f3;"> <span class="order_title"></span> <span class="order_txt"></span> </div>
    <h3><?php if(!empty($order_detail_info)){ echo  $order_detail_info['line_name']; }?></h3>
  </div>
  <div id="order_content">
    <div class="order_top">
      <div class="order_top_a">
        <span class="order_title">基础信息</span>
        <span class="order_txt">下单日期：<?php if(!empty($order_detail_info)){ echo $order_detail_info['addtime'];}?></span>
      </div>
      <hr/>
      <div class="order_top_b">
        <table width="800" border="0">
          <tr>
            <td class="order_title_name" width="111" height="30" align="right">线路名称：</td>
            <td width="360" height="30"><?php if(!empty($order_detail_info)){ echo $order_detail_info['line_name'];}?></td>
            
            <td height="30"  style="text-align:right;"><a href="javascript:void(0);" line_id="<?php  if(!empty($order_detail_info)){ echo $order_detail_info['lineid']; }?>" class="see_trip">查看行程</a></td>

          </tr>
          <tr>
            <td class="order_title_name" height="30" align="right">订单编号：</td>
            <td height="30"><?php if(!empty($order_detail_info)){ echo $order_detail_info['line_sn'];}?></td>
            <td class="order_title_name" height="30" align="right">出发日期：</td>
            <td height="30"><?php if(!empty($order_detail_info)){ echo $order_detail_info['usedate'];}?></td>
          </tr>
          <tr>
            <td class="order_title_name" height="30" align="right">订单状态：</td>
            <td height="30">
                 <?php
                 if(!empty($order_detail_info)){
					echo $order_detail_info['status'];
	             }
	            ?>
            
            </td>
            <td class="order_title_name" height="30" align="right">支付状态：</td>
            <td height="30">
            <?php
              if(!empty($order_detail_info)){
            		if($order_detail_info['ispay'] == 0) {
            			echo "未支付";
            		} elseif ($order_detail_info['ispay'] == 1) {
            			echo '待确认';
            		}	elseif ($order_detail_info['ispay'] == 2) {
            			echo '平台已确认收款';
            		}
               }
            ?>
            </td>
          </tr>
          <tr>
            <td class="order_title_name" height="30" align="right">参团人数 <?php if($order_detail_info['unit']==1){?>(数量*价格)<?php }?>：</td>
            <td height="30" colspan="3">
	            <?php if($order_detail_info['unit']==1){ ?>
	            <span>成人:&nbsp;(<?php if(!empty($order_detail_info['old_people'])){ echo $order_detail_info['old_people']; }?>*<?php if(!empty($order_detail_info['old_price'])){ echo $order_detail_info['old_price'];}?>)</span>&nbsp;&nbsp;
	            <span>小童占床:&nbsp;(<?php if(!empty($order_detail_info['children'])){echo $order_detail_info['children'];}else{ echo 0;}?>*<?php if(!empty($order_detail_info['childprice'])){ echo $order_detail_info['childprice'];}?>)</span>&nbsp;&nbsp;
	            <span>小童不占床:&nbsp;(<?php if(!empty($order_detail_info['childnobednum'])){echo $order_detail_info['childnobednum'];}else{ echo 0;}?>*<?php if(!empty($order_detail_info['childnobedprice'])){ echo $order_detail_info['childnobedprice'];}else{ echo '0';}?>)</span>&nbsp;&nbsp;
	            <span>老人:&nbsp;(<?php if(!empty($order_detail_info['oldnum'])){echo $order_detail_info['oldnum'];}else{ echo 0;}?>*<?php if(!empty($order_detail_info['oldprice'])){ echo $order_detail_info['oldprice'];}else{ echo '0';}?>)</span>
	            <?php }else{?>
	            <span><?php echo $order_detail_info['suitnum'].'份/'.$order_detail_info['unit'].'人套餐'.'('.$order_detail_info['suitname'].')'; ?></span>
	            <?php }?>
            </td>
          </tr>
          <tr>
            <td class="order_title_name" height="30" align="right">订单金额：</td>
            <td height="30" colspan="3">￥<?php if(!empty($order_detail_info['order_price'])){ echo $order_detail_info['order_price'];}else{ echo 0;}?></td> 
          </tr>
          <tr>
            <td class="order_title_name" height="30" align="right">积分抵扣的现金：</td>
            <td height="30" colspan="3">￥<?php if(!empty($order_detail_info['jifenprice'])){ echo $order_detail_info['jifenprice'];}else{ echo 0;}?></td> 
          </tr>
          <tr>
            <td class="order_title_name" height="30" align="right">优惠券抵扣现金：</td>
            <td height="30" colspan="3">￥<?php if(!empty($order_detail_info['couponprice'])){ echo $order_detail_info['couponprice'];}else{ echo 0;}?></td> 
          </tr>
          <tr>
            <td class="order_title_name" height="30" align="right">保险费用：</td>
            <td height="30" colspan="3">￥<?php if(!empty($order_detail_info['settlement_price'])){ echo $order_detail_info['settlement_price'];}else{ echo '0';}?></td> 
          </tr>
           <tr>
            <td class="order_title_name" height="30" align="right">应支付现金：</td>
            <td height="30" colspan="3">￥<?php  echo ($order_detail_info['total_price']+$order_detail_info['settlement_price']);?></td> 
          </tr>
          <tr>
            <td class="order_title_name" height="30" align="right">管家：</td>
            <td height="30"><?php if(!empty($order_detail_info)){ echo $order_detail_info['expert_name'];?>/<?php echo $order_detail_info['expert_mobile'];}?></td>
          </tr>
          <tr>
            <td class="order_title_name" height="30" align="right">供应商：</td>
            <td height="30" colspan="3"><?php if(!empty($order_detail_info)){ echo $order_detail_info['company_name'];}?></td>
          </tr>
         <tr>
            <td class="order_title_name" height="30" align="right">是否需要发票：</td>
            <?php if(!empty($order_detail_info)){?>
            <?php if($order_detail_info['isneedpiao']==1):?>
            <td height="40" colspan="3">是</td>
         	 <?php else:?>
            <td height="40" colspan="3">否</td>
          	<?php endif;?>
         	<?php } ?>
          </tr>
          <?php if(!empty($order_detail_data['invoice_entity'])){?>
          <tr>
            <td class="order_title_name" height="30" align="right">客单发票主体：</td>
            <?php if($order_detail_data['invoice_entity']==111):?>
            <td height="40" colspan="3">供应商</td>
         	 <?php elseif($order_detail_data['invoice_entity']==110):?>
            <td height="40" colspan="3">平台</td>
            <?php else: ?>
             <td height="40" colspan="3">无</td>
          	<?php endif;?>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  <!-- 发票信息 --> 
   <?php if(!empty($invoice)){ ?>  
   <div class="order_center">
      <div class="order_center_a">
          <span class="order_title">发票信息</span> 

          <span class="order_text"></span>
        </div>
        <hr>
        <div class="order_center_b">
		 <table width="90%" cellspacing="0" border="1" id="ctr">
		  <tbody>
		  <tr>
		   <td width="185" height="40" align="center">发票抬头</td>
		    <td width="167" height="40" align="center">配送地址</td>
		    <td width="124" height="40" align="center">收件人</td>
		    <td width="69" height="40" align="center">手机</td>
		    <td width="100" height="40" align="center">金额</td>
		  </tr>
		  <?php foreach ($invoice as $k=>$v){ ?>
		  <tr>
		    <td height="40" align="center"><?php echo $v['invoice_name']; ?></td>
		    <td height="40" align="center"><?php echo $v['address']; ?></td>
		    <td height="40" align="center"><?php echo $v['receiver']; ?></td>
		    <td height="40" align="center"><?php echo $v['telephone']; ?></td>   
		    <td height="40" align="center"><?php if(!empty($order_detail_info['order_price'])){ echo ($order_detail_info['order_price']+$order_detail_info['settlement_price']);}else{ echo 0;}?></td>   
		  </tr>
		  <?php }?>
		 </tbody>
		</table>
      </div>
    </div>  
    <?php }?>
    
    <?php if(isset($order_detail_info['order_status'])){ ?>
    <div class="order_center">
      <div class="order_center_a">
          <span class="order_title">参团人</span>
          <span class="order_text"></span>
        </div>
        <hr/>
        <button data-val="<?php if(!empty($order_id)){ echo $order_id;}?>"  onclick="export_excel(this)">导出Excel</button>
        <div class="order_center_b">
	    <table id="ctr" width="90%" border="1" cellspacing="0">
		  <tr>
		    <td width="71" height="40" align="center">序号</td>
		    <td width="134" height="40" align="center">姓名</td>
		    <td width="124" height="40" align="center">证件类型</td>
		    <td width="183" height="40" align="center">证件号码</td>
			<?php if(!empty($order_inou[0]['inou'])){
			if($order_inou[0]['inou']=='1'){ ?> <!-- 国内游屏蔽 -->
			<td width="57" height="40" align="center">有效期</td>
			 <?php } }?> 
		    <td width="133" height="40" align="center">手机号码</td>
		    <td width="56" height="40" align="center">性别</td>
		    <td width="137" height="40" align="center">出生年月日</td>
		    <td width="102" height="40" align="center">操作</td>
		  </tr>
		  <?php if(!empty($order_people)){ ?>
		<?php foreach ($order_people as $item): ?>
		  <?php if($item['id']!=''):?>
		  <tr>
		    <td height="40" align="center"><?php echo $item['id']?></td>
		    <td height="40" align="center"><?php  if(!empty($item['m_name'])){echo $item['m_name']; }else{ echo $item['enname'];  }?></td>
		    <td height="40" align="center"><?php echo $item['certificate_type']?></td>
		    <td height="40" align="center"><?php echo  $item['certificate_no'] ?></td> 
		    <?php  if(!empty($order_inou[0]['inou'])){ 
		    if($order_inou[0]['inou']=='1'){ ?><!-- 国内游屏蔽 -->
		    <td height="40" align="center"><?php echo $item['endtime'];?></td> 
		    <?php } }?>   
		    <td height="40" align="center"><?php echo $item['telephone'];?></td>
		    <?php if($item['sex']==1):?>
		    <td height="40" align="center">男</td>
		    <?php elseif($item['sex']==2):?>
		    <td height="40" align="center">保密</td>
		    <?php else:?>
		    <td height="40" align="center">女</td>
		    <?php endif;?>	
		    <td height="40" align="center"><?php echo date('Y-m-d', strtotime($item['birthday'] ));?></td>
		    <td height="40" align="center"> </td> 
		  </tr>
		<?php endif;?>
		<?php endforeach;?>
		<?php }?>
	  </table>
      </div>
    </div>
    <?php }?>
    <?php if(!empty($insurance)){ ?>
    <div class="order_center">
      <div class="order_center_a">
          <span class="order_title">保险明细</span>

          <span class="order_text"></span>
        </div>
        <hr>
        <div class="order_center_b">
		 <table width="90%" cellspacing="0" border="1" id="ctr">
		  <tbody>
		  <tr>
		   <td width="185" height="40" align="center">保险名称</td>
		    <td width="167" height="40" align="center">保险公司</td>
		    <td width="124" height="40" align="center">保险期限</td>
		    <td width="69" height="40" align="center">数量</td>
		    <td width="100" height="40" align="center">单价</td>
		    <td width="102" height="40" align="center">操作</td>
		  </tr>
		  <?php foreach ($insurance as $k=>$v){ ?>
		  <tr>
		    <td height="40" align="center"><?php echo $v['insurance_name']; ?></td>
		    <td height="40" align="center"><?php echo $v['insurance_company']; ?></td>
		    <td height="40" align="center"><?php echo $v['insurance_date'].'天'; ?></td>
		    <td height="40" align="center"><?php echo $v['number']; ?></td>   
		    <td height="40" align="center"><?php echo $v['in_price']; ?></td>
		    <td height="40" align="center" style="color:#428bca;cursor:pointer" class="check_mx" data="<?php if(!empty($v['id'])){ echo $v['id'];} ?>">查看明细单</td>   
		  </tr>
		  <?php }?>
		 </tbody>
		</table>
      </div>
    </div>
    <?php }?>
    
    <?php if(!empty($order_detail_info)){ ?>
    <?php if($order_detail_info['status']==4){ ?>
	    <div class="order_foot">
      <div class="order_foot_a">
          <span class="order_title">预定人</span>
          <span class="order_text"></span>
        </div>
        <hr/>
        <div class="order_foot_b">
        <table width="80%" border="0">
          <tr>
            <td class="title_name" width="85" height="40" align="center">姓名：</td>
              <td width="198" height="40" align="left"><?php echo $order_detail_info['linkman']?></td>
              <td class="title_name" width="117" height="40" align="center">手机号：</td>
                    <td width="217" height="40" align="left"><?php echo $order_detail_info['linkmobile']?></td>
              <td class="title_name" width="139" height="40" align="center">邮箱：</td>
              <td width="218" height="40" align="left"><?php echo $order_detail_info['link_email']?></td>
          </tr>
      </table>
      </div>
    </div>
    <?php } ?>
    <?php }?>
  </div>
</div>


<!-- 行程安排 -->
	<div class="trip_info">
		<h3>行程介绍</h3>
		<span class='trip_close'>X</span>
		<div class="trip_every_day">
			<div class="trip_day_title">
				<div class="trip_content_left trip_day">第&nbsp;1&nbsp;天：</div>
				<div class="trip_content_right trip_title">标题</div>
			</div>
			<div class="trip_day_title">
				<div class="trip_content_left">用&nbsp;&nbsp;&nbsp;&nbsp;餐：</div>
				<div class="trip_content_right">
					<div>早餐：含 /不含 描述</div>
					<div>午餐：含 /不含 描述</div>
					<div>晚餐 :含 /不含 描述</div>
				</div>
			</div>

			<div class="trip_day_title">
				<div class="trip_content_left">住宿情况：</div>
				<div class="trip_content_right trip_hotel">住宿</div>
			</div>
			<div class="trip_day_title">
			<!-- 往返交通 -->
				<div class="trip_content_left">交通工具：</div>
				<div class="trip_content_right trip_transport">往返交通</div>

			</div>
			<div class="trip_day_title">
				<div class="trip_content_left"> 行程内容：</div>
				<div class="trip_content_right trip_jieshao">行程内容</div>
			</div>
		</div>
	</div>
  <!--文件下载-->
<div style="display:none;" class="bootbox modal fade in" id="export_excel_modal">
  <div class="modal-dialog">
    <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
    <h4 class="modal-title">导出参团人信息</h4>
  </div>
<div class="modal-body">
<div class="bootbox-body">
  <div id="a_export_excel">

  </div>
  </div>
</div>
 </div>
</div>
</div>
<div class="modal-backdrop fade in" style="display:none;background:#000" id="back_ground_modal"></div>
<!-- 明细单弹框-->
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
  <div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="bootbox-close-button opp_colse close"
            data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">保险明细</h4>
        </div>
        <div class="modal-body">
          <div class="bootbox-body">
              <form class="form-horizontal" role="form" id="form_data_submit" method="post" action="#"> 
                 <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险类型</label>
                  <div class="col-sm-8">
                    <input type="text" name="insurance_type"  class="form-control"  disabled="">
                  </div>
                </div> 
                 <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险种类</label>
                  <div class="col-sm-8">
                    <input type="text" name="insurance_kind"  class="form-control"  disabled="">
                  </div>
                </div>   
                 <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险编号</label>
                  <div class="col-sm-8">
                    <input type="text" name="insurance_code" placeholder="保险名称" class="form-control"  value="编号" disabled="">
                  </div>
                </div>  
                <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险名称</label>
                  <div class="col-sm-8">
                    <input type="text" name="insurance_name" placeholder="保险名称" class="form-control"  value="名称" disabled="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险公司</label>
                  <div class="col-sm-8">
                    <input type="text" name="insurance_company" placeholder="保险公司" class="form-control" value="公司" disabled="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险期限</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="insurance_date"  placeholder="保险期限"  value="期限" disabled="">
                  </div>
                </div>
      <!--               <div class="form-group">
                        <label for="inputEmail3"
      class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>最小保险期限</label>
                        <div class="col-sm-8">
      <input type="text" class="form-control" name="min_date"  placeholder="保险期限"  value="期限" disabled="">
                        </div>
                      </div> -->
              <!--  <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>结算价</label>
                  <div class="col-sm-8">
                    <input type="text" name="insurance_price"  class="form-control"  disabled="">
                  </div>
                </div>-->
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险描述</label>
                  <div class="col-sm-8">
                    <textarea class="form-control content_required" rows="4" name='description' id="description" placeholder="保险描述"  value="保险描述" disabled=""></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">投保须知</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="4" name='simple_explain' placeholder="投保须知" value="投保须知" disabled=""></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">保险条款</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="4" name='insurance_clause' placeholder="保险条款" value="保险条款" disabled=""></textarea>
                  </div>
                </div>
             <!--     <div class="form-group">
                  <div></div>
                  <div  onclick="submit_addinsure();" class="btn btn-default" style="left:55%;">保存</div>
                </div>-->
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$('.see_trip').click(function(){
	var lineid = $(this).attr('line_id');
	$.post(
		"<?php echo site_url('admin/b1/order/get_line_jieshao')?>",
		{'id':lineid},
		function(data) {
			data = eval('('+data+')');
			$('.trip_every_day').remove();
			$.each(data ,function(key ,val) {
				if (val.breakfirsthas == 1) {
					breakfirsthas = '有';
				} else {
					breakfirsthas = '无';
				}
				if (val.lunchhas == 1) {
					lunchhas = '有';
				} else {
					lunchhas = '无';
				}
				if (val.supperhas == 1) {
					supperhas = '有';
				} else {
					supperhas = '无';
				}
				if (typeof val.breakfirst == 'object' || val.breakfirst.length == 0) {
					breakfirst = breakfirsthas;
				} else {
					breakfirst = val.breakfirst;
				}
				if (typeof val.lunch == 'object' || val.lunch.length == 0) {
					lunch = lunchhas;
				} else {
					lunch = val.lunch;
				}
				if (typeof val.supper == 'object' || val.supper.length == 0) {
					supper = supperhas;
				} else {
					supper = val.supper;
				}

				str = '<div class="trip_every_day" style="margin-bottom:30px;">';
				str += '<div class="trip_day_title">';
				str += '<div class="trip_content_left">第&nbsp;'+val.day+'&nbsp;天：</div>';
				str += '<div class="trip_content_right">'+val.title+'</div></div>';
				
				str += '<div class="trip_day_title">';
				str += '<div class="trip_content_left">城市间交通：</div>	'
				str += '<div class="trip_content_right">'+val.transport+'</div></div>'	;
				
				str += '<div class="trip_day_title">';
				str += '<div class="trip_content_left">用&nbsp;&nbsp;&nbsp;&nbsp;餐：</div>';
				str += '<div class="trip_content_right">';
				str += '<div>早餐：'+breakfirst+'</div><div>午餐：'+lunch+'</div>';
				str += '<div>晚餐 : '+supper+'</div></div></div>';

				str += '<div class="trip_day_title">';
				str += '<div class="trip_content_left">住宿：</div>';
				str += '<div class="trip_content_right">'+val.hotel+'</div></div>';

				str += '<div class="trip_day_title">';
				str += '<div class="trip_content_left"> 行程内容：</div>';
				str += '<div class="trip_content_right trip_jieshao">'+val.jieshao+'</div></div>';
				//str += '<div class="trip_content_right trip_jieshao">'+val.jieshao+'</div></div></div>';
			
 				if(val.pic!='' && val.pic!=null){
				  str += '<div class="trip_content_right trip_jieshao" style="padding-left:110px;">';
				  var picArr=val.pic.split(";"); 
				  $.each(picArr ,function(k ,v) {
                         	str += '<img style="max-width:200px;margin-left:10px;" src="'+v+'">';
				  }); 
				  str += '</div>';
				} 
				if(val.line_beizhu!=''){
					str += '<div class="trip_day_title">';
					str += '<div class="trip_content_left">温馨提示：</div>';
					str += '<div class="trip_content_right">'+val.line_beizhu+'</div></div>';
				 }
				 str += '</div>';
				$('.trip_info').append(str);
			})
			$('.opac_box').show();
			$('.trip_info').show();
               $('.modal-backdrop').show();
		}
	);

})
$('.trip_close').click(function(){
	$('.opac_box').hide();
	$('.trip_info').hide();
      $('.modal-backdrop').hide();

})
function hidden_modal(){
  $("#export_excel_modal").hide();
  $('.opac_box').hide();
  $("#a_export_excel").html('');
}
function export_excel(obj){
    var order_id = $(obj).attr('data-val');
     $.post(
      "<?php echo site_url('admin/b1/order/export_excel')?>",
      {'id':order_id},
      function(data) {
        data = eval('('+data+')');
        data = '<?php echo base_url();?>'+data;
        window.location.href=data;
      /*   $("#a_export_excel").html("<a href='"+data+"'  onclick='hidden_modal()''>点击下载</a>");
        $("#export_excel_modal").show();
        $(".opac_box").show(); */
      });
    
}
 $('.check_mx').click(function(){
	  var id=$(this).attr('data');
	     $.post(
	    	 "<?php echo site_url('admin/b1/order/sel_insurance')?>",
	    	 {'id':id},
    	      function(data) {
    	                data = eval('('+data+')');
			   if(data.status==1){
				   var flag='';
				   if(data.insurArr.insurance_type==1){
					   flag='境外';
				   }else if(data.insurArr.insurance_type==2){
					   flag='境内';
				   }
				   $('input[name="insurance_type"]').val(flag);
				   $('input[name="insurance_kind"]').val(data.insurArr.kingname);
				   $('input[name="insurance_name"]').val(data.insurArr.insurance_name);
				   $('input[name="insurance_company"]').val(data.insurArr.insurance_company);
				   $('input[name="insurance_date"]').val(data.insurArr.insurance_date+'天');
                             $('input[name="insurance_code"]').val(data.insurArr.insurance_code);
                             $('input[name="min_date"]').val(data.insurArr.min_date+'天');
				   $('input[name="insurance_price"]').val(data.insurArr.settlement_price);
				   $('textarea[name="description"]').val(data.insurArr.description);
				   $('textarea[name="simple_explain"]').val(data.insurArr.simple_explain);
				   $('textarea[name="insurance_clause"]').val(data.insurArr.insurance_clause);				   
				   //alert(data.insurArr.id);
			   }else{
				   alert(data.msg);
			   }		
    	      });
      $('.bootbox').show();
      $('.modal-backdrop,.opp_eidt').show();
  })
    $('.opp_colse').click(function(){
      $('.bootbox').hide();
      $('.modal-backdrop,.opp_eidt').hide();
    })

</script>


<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/b2b_order_detail.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/v2/b2_base.css');?>">
<style type="text/css">
*{font:"tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif" !important}
.col_lb{  float:left; width: 16%; text-align: right;}
.col_ts{ float:left;}
.col-sm-10{ width: 83%;}
.page-content{  width: 1200px; margin: 0 auto !important;}
#order_info{ padding: 0; border: 1px solid #ddd; border-bottom: none; background: #fbfbfb;min-width:1200px;}
#order_header div{ background: #09c; height:40px; line-height: 40px;}
#order_header .order_title{ color: #fff;}
.trip_content_right img{ margin: 0 5px;}
.order_title_name{ font-size: 12px;}
.order_top_b td{border:1px solid #f2f2f2; font-size: 12px; padding-left: 10px;}
.order_top_b table{ width: 100%;}
.order_add, .order_editor{ background: #09c; outline: inherit; border:none; color: #fff; border-radius: 1px;}
#ctr tr{ background: none;}
#ctr{ border: 1px solid #ccc;}
.editor{ border: none; background: #09c; color: #fff; padding: 0 10px; border-radius: 1px;}
#order_content{ padding-bottom: 50px;}
.bootbox{ position: fixed;}
.benBtn{ width: 100px !important; margin: 0 auto;}
.benBtn2{ width: 100px !important; margin: 0 auto;}
.btns{ background: #09c; color: #fff; padding: 5px 10px; border-radius: 2px;}
.btns:hover{ color: #fff;}
.order_title_name{ color:#09c}
.current_page { height:40px; line-height:40px;}
#order_info{ background:#fff;}
#order_header{ height:40px; line-height:40px; margin-top:20px;}
#order_header h3{ height:40px; line-height:40px; font-size:18px;font-weight: bold  !important}
.order_top{ padding-top:0}
.current_page{ border-left:1px solid #ddd; border-right:1px solid #ddd; width:1180px;}
.main_page_link i{ top:-1px}
.trip_info{ width:920px; height:65%; border:20px solid #fff; overflow-y: auto;box-shadow: 0 0 20px 0 rgba(0, 0, 0, .5); -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, .5);-moz-box-shadow: 0 0 20px 0 rgba(0, 0, 0, .5);box-shadow: 0 0 20px 0 rgba(0, 0, 0, .5); padding:0; left:50%; margin-left:-480px;}
.trip_info_cro{ margin:0 20px;}
.trip_close{ margin-top:10px;}
.wlpxiugi{ padding:0; box-sizing:border-box; padding:0 5px !important; height:30px; line-height:30px; display:inline-block}
.form-control{ height:30px; line-height:30px;}
.btn-palegreen:hover, .open .btn-palegreen.dropdown-toggle, .btn-palegreen{ padding:0 !important; background:#09c !important; border:1px solid #09c !important;}
#people_excel{ width: auto; float:left; height:24px; padding:0; margin:0; border:none;}
.order_title_name{padding-left: 0;text-align: right;background: #f8f8f8;  padding-right: 5px; color:#333;}


</style>
<div class="current_page shadow" style="border-bottom:none">您的位置：
        <a href="#" class="main_page_link"><i></i>主页</a>
        <span class="right_jiantou">&gt;</span>
        <a href="#">订单信息</a>
    </div>
<div id="order_info">
  	<div id="order_header">

    	<h3><?php echo $order_detail_info['line_name']?></h3>
  	</div>
  	<div id="order_content">
    	<div class="order_top">
      		<div class="order_top_a">
                <span class="order_title">基础信息</span>
                <span class="order_txt">下单日期：<?php echo $order_detail_info['addtime']?></span>
      		</div>
      		<hr/>
            <div class="order_top_b">
                <table width="800" border="0">
                  	<tr>
                        <td class="order_title_name" width="111" height="30" align="right">线路名称：</td>
                        <td width="360" height="30"><?php echo $order_detail_info['line_name']?></td>
                        <td height="30" width="111" style="text-align:right;" class="order_title_name"><a href="javascript:void(0);" line_id="<?php echo $order_detail_info['lineid']?>" class="see_trip" style="color:#333">查看行程：</a></td>
                      	<td width="360" height="30"><a href="javascript:void(0);" line_id="<?php echo $order_detail_info['lineid']?>" class="see_trip btns">查看行程</a></</td>
                 	</tr>
                  	<tr>
                        <td class="order_title_name" height="30" align="right">订单编号：</td>
                        <td height="30"><?php echo $order_detail_info['line_sn']?></td>
                        <td class="order_title_name" height="30" width="111"  align="right">出发日期：</td>
                        <td height="30"><?php echo $order_detail_info['usedate']?></td>
                  	</tr>
                  	<tr>
                        <td class="order_title_name" height="30" align="right">订单状态：</td>
                        <td height="30"><?php echo $order_detail_info['status']?></td>
                        <td class="order_title_name" height="30" width="111"  align="right">支付状态：</td>
                        <td height="30"><?php echo $order_detail_info['ispay']?></td>
                  	</tr>
                   	<tr>
                        <td class="order_title_name" height="30" align="right">参团人数：</td>
                        <td height="30" colspan="3">
						   <?php if($order_detail_info['unit']>=2):?>
                           <span><?php echo $order_detail_info['suitname']?></span>&nbsp;&nbsp;
                           <span><?php echo $order_detail_info['dingnum'].'/'.$order_detail_info['unit'].'人份'?> </span>&nbsp;&nbsp;
                           <span><?php echo $order_detail_info['suitnum'].'*'.$order_detail_info['ding_price']?></span>
                              <?php else:?>
                           <span>成人:&nbsp;(<?php if(!empty($order_detail_info['dingnum'])){ echo $order_detail_info['dingnum']; }?>*<?php if(!empty($order_detail_info['ding_price'])){ echo $order_detail_info['ding_price'];}?>)</span>&nbsp;&nbsp;
                           <span> 小童占床:&nbsp;(<?php if(!empty($order_detail_info['children'])){echo $order_detail_info['children'];}else{ echo 0;}?>*<?php if(!empty($order_detail_info['childprice'])){ echo $order_detail_info['childprice'];}?>)</span>&nbsp;&nbsp;
                           <span>小童不占床:&nbsp;(<?php if(!empty($order_detail_info['childnobednum'])){echo $order_detail_info['childnobednum'];}else{ echo 0;}?>*<?php if(!empty($order_detail_info['childnobedprice'])){ echo $order_detail_info['childnobedprice'];}else{ echo '0';}?>)</span>&nbsp;&nbsp;
                           <span> 老人:&nbsp;(<?php if(!empty($order_detail_info['oldnum'])){echo $order_detail_info['oldnum'];}else{ echo 0;}?>*<?php if(!empty($order_detail_info['oldprice'])){ echo $order_detail_info['oldprice'];}else{ echo '0';}?>)</span>
                           <?php endif;?>
                    	</td>
                  	</tr>
                  	<tr>
                        <td class="order_title_name" height="30" align="right">订单金额：</td>
                        <td height="30" colspan="3"><?php echo $order_detail_info['order_price']+$order_detail_info['settlement_price']?></td>
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
                        <td height="30" colspan="3">￥<?php  echo ($order_detail_info['total_price']+$order_detail_info['amout']);?></td>
                  	</tr>
                  	<tr>
                        <td class="order_title_name" height="30" align="right">管家佣金：</td>
                        <td height="30"><?php echo $order_detail_info['agent_fee']?></td>
                        <td class="order_title_name" height="30" align="right">管家：</td>
                        <td height="30"><?php echo $order_detail_info['expert_name']?>/<?php echo $order_detail_info['expert_mobile']?></td>
                  	</tr>
                  	<tr>
                        <td class="order_title_name" height="30" align="right">供应商：</td>
                        <td height="30" colspan="3"><?php echo $order_detail_info['company_name']?></td>
                  	</tr>
                 	<tr>
                        <td class="order_title_name" height="30" align="right">是否需要发票：</td>
                        <?php if($order_detail_info['isneedpiao']==1):?>
                        <td height="30" colspan="3">是</td>
                      	<?php else:?>
                        <td height="30" colspan="3">否</td>
                      	<?php endif;?>
                  	</tr>
                  	<?php if(!empty($order_detail_data['invoice_entity'])){?>
                  	<tr>
                        <td class="order_title_name" height="30" align="right">客单发票主体：</td>
                        <?php if($order_detail_data['invoice_entity']==111):?>
                        <td height="30" colspan="3">供应商</td>
                        <?php elseif($order_detail_data['invoice_entity']==110):?>
                        <td height="30" colspan="3">平台</td>
                        <?php else: ?>
                        <td height="30" colspan="3">无</td>
                        <?php endif;?>
                 	 </tr>
                  <?php } ?>
                </table>
            </div>
    	</div>
    	<div class="order_center">
      		<div class="order_center_a">
          		<span class="order_title">参团人</span>
          		<button data-val="<?php echo $order_id?>" class="order_add" onclick="add_people(this)">添加</button>
          		<span class="order_text"></span>
        	</div>
        	<hr/>
            <form  action="<?php echo base_url('admin/b2/order/import_excel')?>" method="post" enctype="multipart/form-data">
                <input type="file" name="people_excel" id="people_excel" value="" style="display:inline"/>
                <input type="hidden" name="excel_order_id" value="<?php echo $order_id?>" />
                <input type="hidden" name="people_num" value="<?php echo $order_detail_info['dingnum']+$order_detail_info['children']?>"/>
                <input type="submit"  value="导入Excel" style="display:inline; padding:0 5px;"/>
                <a href="<?php echo base_url('file/b2/template.xlsx')?>">下载模版</a>
            </form>
            <div style="margin-left:438px;margin-top:-24px;"><button  data-val="<?php echo $order_id?>"  onclick="export_excel(this)" style="display:inline; padding:0 5px;">导出Excel</button></div>
            <div class="order_center_b">
    			<table id="ctr" width="100%" border="1" cellspacing="0">
                    <tr>
                        <td width="71" height="30" align="center">序号</td>
                        <td width="134" height="30" align="center">姓名</td>
                        <td width="124" height="30" align="center">证件类型</td>
                        <td width="183" height="30" align="center">证件号码</td>
                        <td width="80" height="30" align="center">有效期</td>
                        <td width="133" height="30" align="center">手机号码</td>
                        <td width="56" height="30" align="center">性别</td>
                        <td width="137" height="30" align="center">出生年月日</td>
                        <td width="102" height="30" align="center">操作</td>
                    </tr>
					<?php foreach ($order_people as $item): ?>
                    <?php if($item['id']!=''):?>
                    <tr>
                        <td height="30" align="center"><?php echo $item['id']?></td>
                        <td height="30" align="center"><?php echo $item['m_name']?></td>
                        <td height="30" align="center"><?php echo $item['description']?></td>
                        <td height="30" align="center"><?php echo $item['certificate_no']?></td>
                        <td height="30" align="center"><?php if($item['endtime']=='' || $item['endtime']=='0000-00-00 00:00:00'){ echo ' ';}else{echo $item['endtime'];}?></td>

                        <td height="30" align="center"><?php echo $item['telephone']?></td>
                        <?php if($item['sex']==1):?>
                        <td height="30" align="center">男</td>
                        <?php elseif($item['sex']==2):?>
                        <td height="30" align="center">保密</td>
                        <?php else:?>
                        <td height="30" align="center">女</td>
                        <?php endif;?>
                        <td height="30" align="center"><?php echo $item['birthday']?></td>
                        <td height="30" align="center"><button data-val="<?php echo $item['id']?>" class="editor" onclick="edit_people(this)">修改</button></td>
                    </tr>
					<?php endif;?>
                    <?php endforeach;?>
				</table>
      		</div>
    	</div>

<!-- 保险明细 -->
<?php if(!empty($order_insurance)){ ?>
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
                    <td width="185" height="30" align="center">保险名称</td>
                    <td width="167" height="30" align="center">保险公司</td>
                    <td width="124" height="30" align="center">保险期限</td>
                    <td width="69" height="30" align="center">数量</td>
                    <td width="56" height="30" align="center">金额</td>
                    <td width="102" height="30" align="center">操作</td>
              	</tr>
  				<?php foreach($order_insurance AS $item):?>
                <tr>
                    <td height="30" align="center"><?php echo $item['insurance_name']?></td>
                    <td height="30" align="center"><?php echo $item['insurance_company']?></td>
                    <td height="30" align="center"><?php echo $item['insurance_date'].'天'?></td>
                    <td height="30" align="center"><?php echo $item['number']?></td>
                    <td height="30" align="center"><?php echo sprintf("%.2f", $item['amount']/$item['number']);?></td>
                    <td height="30" data-val="<?php echo $item['insurance_id']?>" align="center" style="color:#428bca;cursor:pointer"  class="check_mx">查看明细单</td>
              	</tr>
  				<?php endforeach;?>
        	</tbody>
		</table>
    </div>
</div>
<?php }?>
    <!--  End 保险信息 -->

    <!--  发票信息 -->
<?php if(!empty($order_invoice)){ ?>
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
                    <td width="185" height="30" align="center">发票抬头</td>
                    <td width="167" height="30" align="center">配送地址</td>
                    <td width="124" height="30" align="center">收件人</td>
                    <td width="69" height="30" align="center">手机</td>
                    <td width="100" height="30" align="center">金额</td>
                </tr>
                <?php foreach ($order_invoice as $k=>$v){ ?>
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
<!--  End 发票信息 -->


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
                    <td width="198" height="30" align="left"><?php echo $order_detail_info['linkman']?></td>
                    <td class="title_name" width="117" height="40" align="center">手机号：</td>
                    <td width="217" height="30" align="left"><?php echo $order_detail_info['linkmobile']?></td>
                    <td class="title_name" width="139" height="40" align="center">邮箱：</td>
                    <td width="218" height="30" align="left"><?php echo $order_detail_info['link_email']?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>


<div style="display:none;" class="bootbox modal fade in" id="add_people_modal">
  <div class="modal-dialog">
    <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
    <h4 class="modal-title">添加参团人</h4>
  </div>
<div class="modal-body">
<div class="bootbox-body">
  <div>
  <form class="form-horizontal" role="form" id="add_people_form" method="post" action="#">
      <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb wlpxiugi">姓名</label>
       <div class="col-sm-10 col_ts wlpxiugi">
       <div class="input-group col-sm-10 wlpxiugi" >
       <input type="text" class="form-control" name="people_name" id="people_name" value="" wlpxiugi/>
       </div>
       </div>
      </div>
      <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb wlpxiugi" >证件类型</label>
       <div class="col-sm-10 col_ts wlpxiugi">
       <div class="input-group col-sm-10 wlpxiugi" >
        <select class="form-control" name="certificate_type" id="certificate_type">
         <option value="">证件类型</option>
       <?php $certificate_type=array();
             if($order_detail_info['cer_type']==1){
                    $certificate_type=$certificate_type_abroad;
            }else{
              $certificate_type=$certificate_type_domestic;
            }
         foreach ($certificate_type as $item): ?>
          <option value="<?php echo $item['dict_id']?>"><?php echo $item['description']?></option>
        <?php endforeach;?>
        </select>
          </div>
       </div>
      </div>
      <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb wlpxiugi">证件号码</label>
       <div class="col-sm-10 col_ts wlpxiugi">
       <div class="input-group col-sm-10 wlpxiugi" >
        <input type="text" class="form-control wlpxiugi" name="certificate_no" id="certificate_no" value=""/>
        </div>
       </div>
      </div>
      <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb wlpxiugi">有效期</label>
       <div class="col-sm-10 col_ts wlpxiugi">
       <div class="input-group col-sm-10 wlpxiugi" >
       <input type="text" class="form-control date-picker wlpxiugi" data-date-format="yyyy-mm-dd" name="endtime" id="endtime" value=""/>
       <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                 </span>
            </div>
       </div>
      </div>
      <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb wlpxiugi">电话号码</label>
       <div class="col-sm-10 col_ts wlpxiugi">
       <div class="input-group col-sm-10 wlpxiugi" >
         <input type="text" class="form-control wlpxiugi" name="telephone" id="telephone" value=""/>
         </div>
       </div>
      </div>
      <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb wlpxiugi">性别</label>
       <div class="col-sm-10 col_ts wlpxiugi">
       <div class="input-group col-sm-10 wlpxiugi" >
          <select class="form-control" name="sex" id="sex">
              <option value="0">女</option>
              <option value="1">男</option>
              <option value="-1">保密</option>
          </select>
          </div>
       </div>
      </div>
      <div class="form-group">
       <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb wlpxiugi">出生日期</label>
       <div class="col-sm-10 col_ts wlpxiugi">
       <div class="input-group col-sm-10 wlpxiugi" >
        <input type="text" id="birthday" class="form-control date-picker wlpxiugi" name="birthday" data-date-format="yyyy-mm-dd" value=""/>
        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                 </span>
                 </div>
       </div>
      </div>
      <div class="form-group">

       <input type="submit" class="btn btn-palegreen benBtn" value="提交" style="float: left; margin-right: 2%; padding: 0 !important;" />
          <input type="button" onclick="hidden_modal()" class="btn btn-palegreen bootbox-close-button benBtn2 " aria-hidden="true" value="取消" style="float: right; margin-right: 2%;  padding: 0 !important;" />
       <input type="hidden" name="people_id" id="people_id" value="">
       <input type="hidden" name="order_id" id="order_id" value="">
       <input type="reset" style="display:none" id="reset_form"/>
      </div>
     </form>
  </div>
  </div>
</div>
 </div>
</div>
</div>

<!-- 行程安排 -->
  <div class="trip_info ">
  <div class="trip_info_cro">
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
<div class="modal-backdrop fade in" style="display:none;background: rgba(255,255,255,0.5);" id="back_ground_modal" ></div>
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
                    <input type="text" name="insurance_code" id="insurance_code" placeholder="保险编号" class="form-control"  value="名称" disabled="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险名称</label>
                  <div class="col-sm-8">
                    <input type="text" name="insurance_name" id="insurance_name" placeholder="保险名称" class="form-control"  value="名称" disabled="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险公司</label>
                  <div class="col-sm-8">
                    <input type="text" name="insurance_company" id="insurance_company" placeholder="保险公司" class="form-control" value="公司" disabled="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险期限</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="insurance_date" id="insurance_date"  placeholder="保险期限"  value="期限" disabled="">
                  </div>
                </div>
     <!--              <div class="form-group">
     <label for="inputEmail3"
       class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>最小保险期限</label>
     <div class="col-sm-8">
       <input type="text" class="form-control" name="min_date" id="min_date"  placeholder="保险期限"  value="期限" disabled="">
     </div>
                     </div> -->
                <div class="form-group">
                  <label for="inputEmail3"
                    class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>结算价</label>
                  <div class="col-sm-8">
                    <input type="text" name="insurance_price" id="insurance_price"  class="form-control"   placeholder="结算价"  value="结算价" disabled="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险描述</label>
                  <div class="col-sm-8">
                    <textarea class="form-control content_required" rows="4" name='description' id="description" placeholder="投保须知"  value="投保须知" disabled=""></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">保险条款</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="4" name='simple_explain' id='simple_explain' placeholder="保险条款" value="保险条款" disabled=""></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">保险条款</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="4" name='insurance_clause' id='insurance_clause' placeholder="保险条款" value="条款" disabled=""></textarea>
                  </div>
                </div>
              </form>
          </div>


        </div>
      </div>
    </div>
  </div>

<script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
<script type="text/javascript">
/*$(".datepicker tbody tr td").click(function(){
	$(".datepicker").hide();
});
*/

//隐藏弹框
function hidden_modal(){
  $("#back_ground_modal").hide();
  $("#add_people_modal").hide();
  $("#export_excel_modal").hide();
  $("#a_export_excel").html('');
  $("#reset_form").trigger('click');
}

function edit_people(obj){
  var people_id = $(obj).attr('data-val');
  $.post("<?php echo base_url()?>admin/b2/order/get_one_people",
    {"id":people_id},
    function(data){
      data = eval('('+data+')');
      $("#people_id").val(data.id);
      $('#sex option[value='+data.sex+']').attr('selected',true);
      $('#certificate_type option[value='+data.certificate_type+']').attr('selected',true);
          $("#endtime").val(data.endtime);
          $("#telephone").val(data.telephone);
          $("#birthday").val(data.birthday);
          $("#people_name").val(data.m_name);
          $("#certificate_type").val(data.certificate_type);
          $("#certificate_no").val(data.certificate_no);
           $("#back_ground_modal").show();
          $("#add_people_modal").show();
    });

}

function add_people(obj){
  var order_id = $(obj).attr('data-val');
  $("#order_id").val(order_id);
   $("#back_ground_modal").show();
   $("#add_people_modal").show();
}


$('#add_people_form').submit(function(){
      $.post(
        "<?php echo site_url('admin/b2/order/edit_add_people');?>",
        $.param({'people_num':<?php echo $order_detail_info['dingnum']+$order_detail_info['children']?>})+'&'+$('#add_people_form').serialize(),
        function(data) {
          data = eval('('+data+')');
          if (data.status == 1) {
            alert(data.msg);
            location.reload();
          } else {
            alert(data.msg);
          }
        }
      );
      return false;
    });



$('.see_trip').click(function(){
    var lineid = $(this).attr('line_id');
    $.post(
      "<?php echo site_url('admin/b2/order/get_line_jieshao')?>",
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

       str = '<div class="trip_every_day">';
        str += '<div class="trip_day_title">';
        str += '<div class="trip_content_left">第&nbsp;'+val.day+'&nbsp;天：</div>';
        str += '<div class="trip_content_right">'+val.title+'</div></div>';

        str += '<div class="trip_day_title">';
        str += '<div class="trip_content_left">用&nbsp;&nbsp;&nbsp;&nbsp;餐：</div>';
        str += '<div class="trip_content_right">';
        str += '<div>早餐：'+breakfirst+'</div><div>午餐：'+lunch+'</div>';
        str += '<div>晚餐 : '+supper+'</div></div></div>';

        str += '<div class="trip_day_title">';
        str += '<div class="trip_content_left">住宿情况：</div>';
        str += '<div class="trip_content_right">'+val.hotel+'</div></div>';

        str += '<div class="trip_day_title">';
        str += '<div class="trip_content_left">交通工具：</div>  '
        str += '<div class="trip_content_right">'+val.transport+'</div></div>'  ;

        str += '<div class="trip_day_title">';
        str += '<div class="trip_content_left"> 行程内容：</div>';
        str += '<div class="trip_content_right trip_jieshao">'+val.jieshao+'</div></div></div>';

          $('.trip_info').append(str);
        })
        $('#back_ground_modal').show();
        $('.trip_info').show();
      });
  })
$('.trip_close').click(function(){
    $('#back_ground_modal').hide();
    $('.trip_info').hide();
  })


function export_excel(obj){
    var order_id = $(obj).attr('data-val');
     $.post(
      "<?php echo site_url('admin/b2/order/export_excel')?>",
      {'id':order_id},
      function(data) {
        data = eval('('+data+')');
        data = '<?php echo base_url();?>'+data;
        window.location.href=data;
      });
}

//显示日历
$('#birthday').datepicker();
$('#endtime').datepicker();
//设置一下z坐标的像素,以便在浮出层显示日历,不然显示不出来,被覆盖了
$('.datepicker').css('z-index','9999');


 $('.check_mx').click(function(){
        var insurance_id = $(this).attr('data-val');
        $.post("<?php echo base_url('admin/b2/order/get_insurance_detail')?>",{'insurance_id':insurance_id},function(data){
             data = eval('('+data+')');
			   var flag='';
			   if(data['insurance_type']==1){
				   flag='境外';
			   }else if(data['insurance_type']==2){
				   flag='境内';
			   }
			 $('input[name="insurance_type"]').val(flag);
			 $('input[name="insurance_kind"]').val(data['kingname']);

            $("#insurance_name").val(data['insurance_name']);
            $("#insurance_company").val(data['insurance_company']);
            $("#insurance_date").val(data['insurance_date']+'天');
            $("#min_date").val(data['min_date']+'天');
            $("#insurance_code").val(data['insurance_code']);
            $("#insurance_price").val(data['settlement_price']);
            $("#description").val(data['description']);
            $("#simple_explain").val(data['simple_explain']);
            $("#insurance_clause").val(data['insurance_clause']);
        });

      $('.bootbox').show();
      $('.modal-backdrop,.opp_eidt').show();
    });
    $('.opp_colse').click(function(){
      $('.bootbox').hide();
      $('input[name="insurance_type"]').val('');
	  $('input[name="insurance_kind"]').val('');
      $('.modal-backdrop,.opp_eidt').hide();
      $("#insurance_name").val('');
      $("#insurance_company").val('');
      $("#insurance_date").val('');
      $("#insurance_price").val('');
      $("#description").val('');
      $("#simple_explain").val('');
      $("#insurance_clause").val('');
     $("#min_date").val('');
     $("#insurance_code").val('');
    });
</script>

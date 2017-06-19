               <?php if(!empty($order_message)){ ?>
               <form id="orderInfo" class="form-horizontal bv-form" novalidate="novalidate" method="post" onsubmit="return Checkevaluate();" accept-charset="utf-8" action="<?php echo base_url();?>base/member/save_custom_order" style="">
                           <ul>
                                 <h2>管家</h2>
                                 <li><?php echo $order_message[0]['realname']; ?>,<?php if($order_message[0]['grade']==1){echo '管家';
                                 }elseif($order_message[0]['grade']==2){ echo '初级专家';
                                 }elseif ($order_message[0]['grade']==3){ echo '中级专家';	
                                 }elseif($order_message[0]['grade']==4){ echo '高级专家';}
                                 ?></li>
                                 <h2>方案</h2>
                                 <li><?php  echo $order_message[0]['plan_design'];?></li>
                                 <h2>订单信息<span>编号:<?php echo  $order_message[0]['id'];?></span></h2> 
                                 <div class="tr_list">
                                 
                                    <div class="tr_twohe">出发城市:<span><?php echo $order_message[0]['startplace']; ?></span></div>
                                    <div class="tr_twohe">出游时间:<span><?php  echo $order_message[0]['startdate']; ?></span></div>
                                    <div class="tr_twohe">游玩天数:<span><i><?php  echo $order_message[0]['days']; ?></i>天</span></div>
                                    <div class="tr_twohe">出行人数:<span><i><?php  echo $order_message[0]['people']+$order_message[0]['childnum']; ?></i>人</span></div>
                                    <div class="tr_twohe">人均预算:<span><i>¥<?php echo $order_message[0]['budget']; ?></i></span></div>
                                    <div class="tr_twohe">出游方式:<span><?php echo $order_message[0]['description']; ?></span></div>
                                    <div class="tr_twohe">旅游主题:<span><?php echo $order_message[0]['name']; ?></span></div>
                                    <div class="tr_twohe">目的地:<span><?php echo $order_message[0]['endplace']; ?></span></div>
                                    <div class="tr_twohe" style="width:580px; height:auto; line-height:24px;">其他要求:<span style=" color:#999;"><?php echo $order_message[0]['service_range']; ?></span></div>
                                 </div> 
                               <h2>结算信息<span></span></h2> 
                                 <div class="tr_list">
                                    <div class="tr_onehe">定单金额:<span style=" color:#999;padding-left:6px;">¥<?php echo  $budget['sum']; ?></span></div>
                                     <input name="linename" type="hidden" value="<?php echo $order_message[0]['question'];  ?>">
                                     <input name="startplace" type="hidden" value="<?php echo $order_message[0]['startplace'];  ?>">
                                     <input name="overcity" type="hidden" value="<?php echo $order_message[0]['endplace'];  ?>">
                                     <input name="overcity2" type="hidden" value="<?php echo $order_message[0]['endplace'];  ?>">
                                     <input name="lineprice" type="hidden" value="<?php echo  $budget['sum']; ?>">
                                     <input name="lineday" type="hidden" value="<?php echo $order_message[0]['days'];  ?>">
                                     <input name="linenight" type="hidden" value="<?php if($order_message[0]['days']>0){ echo $order_message[0]['days']-1;}else{ echo 0;}  ?>">
                                     <input name="supplier_id" type="hidden" value="<?php echo $order_message[0]['supplier_id'];  ?>">
                                     <input name="hotelstar" type="hidden" value="<?php echo $order_message[0]['hotelstar'];  ?>">
                                     <input name="budget" type="hidden" value="<?php echo $order_message[0]['budget'];  ?>">
                                     <input name="price" type="hidden" value="<?php echo $order_message[0]['price'];  ?>">
                                     <input name="childpirce" type="hidden" value="<?php echo $order_message[0]['childpirce']; ?>">
                                     <input name="childnobedprice" type="hidden" value="<?php echo $order_message[0]['childnobedprice'];  ?>">
                                     <input name="startdate" type="hidden" value="<?php echo $order_message[0]['startdate'];  ?>">
                                     <input name="people" type="hidden" value="<?php echo $order_message[0]['people'];  ?>">
                                     <input name="childnum" type="hidden" value="<?php echo $order_message[0]['childnum'];  ?>">
                                     <input name="linkname" type="hidden" value="<?php echo $order_message[0]['linkname']; ?>">
                                     <input name="linkphone" type="hidden" value="<?php echo $order_message[0]['linkphone']; ?>">
                        			 <input name="expert_id" type="hidden" value="<?php echo $order_message[0]['expert_id']; ?>">
                        			 <input name="supplier_id" type="hidden" value="<?php echo $order_message[0]['supplier_id']; ?>">
                        			 <input name="realname" type="hidden" value="<?php echo $order_message[0]['realname']; ?>">
                        			 <input name="srealname" type="hidden" value="<?php echo $order_message[0]['srealname']; ?>">
                        			 <input name="customize_id" type="hidden" value="<?php echo $order_message[0]['customize_id']; ?>">
                                     <input name="agent_rate" type="hidden" value="<?php echo ($order_message[0]['budget']-$budget['price'])/$order_message[0]['budget'];  ?>">
                                    
                           <!--          <div class="tr_onehe">用优惠卷:<span>
                                        <select>
                                            <option>请选择</option>
                                            <option>请选择</option>
                                            <option>请选择</option>
                                            <option>请选择</option>
                                            <option>请选择</option>
                                        </select>
                                        </span></div> -->
                                 <!--   <div class="tr_onehe">使用游币:<span><input type="text" style=" margin-left:5px;width:158px;">--> 
                                        </span> 
                                        </div>
                                    <div class="tr_twohe">发票需求:<span><label><input type="radio" name="isneedpiao" checked="checked" class="nopiao" value="0">不需要</label><label><input type="radio" name="isneedpiao" class="yespiao" value="1">需要</label></span></div>
                                    <div class="clear fapiao">
                                        <ul>
                                            <li><span>发票抬头：</span><input type="text" name="invoice_name"></li>
                                            <li  style="width:405px;">
                                                <span>配送地址：</span>
                                               <select name="province">
												<option value="0">请选择</option>
                   								 <?php
														foreach ( $area as $key => $val ) {
														echo "<option value='{$val['id']}'>{$val['name']}</option>";
														}
												?>
                             					</select>
                                            </li>
                                            <li><span>收件人：</span><input type="text" name="receiver"></li>
                                            <li><span>详细地址：</span><input type="text" name="address"></li>
                                            <li><span>手机：</span><input type="text" name="telephone"></li>
                                            <li style=" text-align:left;"><span>金额：</span>¥<?php echo  $budget['sum']; ?></li>
                                        </ul>
                                        
                                     </div>
                                    <h2>联系人<span></span></h2> 
                                 <div class="tr_list">
                                    <div class="tr_twohe">联系人&nbsp;:<span><?php echo $order_message[0]['linkname']; ?></span></div>
                                    <div class="tr_twohe">手机号:<span><?php echo $order_message[0]['linkphone']; ?></span></div>
                                    <div class="tr_onehe"style="width:560px; clear: both;">电子邮箱:<span><input type="text" class="email" name="email"></span></div>
                                 </div>
                                     <h2>出游人信息<span></span></h2> 
                                 <div class="tr_list" style=" border:1px solid #ccc;overflow: hidden;">
                                    <ul>
                                        <li style="width:30px">序</li>
                                        <li>真实姓名</li>
                                        <li>证件类型</li>
                                        <li style="width:120px">证件号码</li>
                                        <li>出生日期</li>
                                        <li>操作</li>
                                     </ul>
                                     <?php $sum=$order_message[0]['people']+$order_message[0]['childnum'];   
                                           for($i=0;$i<$sum;$i++){
                                     ?>                             
                                     <ul>
                                        <li style="width:30px"><?php echo $i+1; ?></li>
                                        <li><input type="text" style="width:80px;" name="linkename[]" placeholder="请输入姓名"></li>
                                        <li>
                                            <select name="certificate_type[]">
                                                 <option value="-1">请选择</option>
                                            <?php foreach ($dict_data as $k=>$v) {?>
                                                <option value="<?php echo $v['dict_id']; ?>"><?php echo $v['description']; ?></option>
                                                <?php }?>
                                            </select>
                                         </li>

                                         <li style="width:120px"><input type="text" style="width:130px" placeholder="请输入证件号码" class="zhengjian_pt" onblur="birthday(this)" name="certificate_no[]" ></li>
                                        <li style="width:120px;padding-left:0;"><input type="text" placeholder="出生日期" style="width:80px" class="shengri_pt" readonly="true" name="birthday[]" ></li>
                                        <li style="width:28px; color:#3c7b00;cursor:pointer" class="clrakong">清空</li>
                                     </ul>
                                <?php }?>
                                 </div>
                                 <div class="gaikuang">出游人概况<span>因接待能力有限，请您如实核实一下情况。如有与实际不符，产生的损失需您自行承担，还请谅解。</span></div> 
                                <div class="gaikuang_xuan">
                                    <ul>
                                        <li><label><input type="radio" name="allchild" value='1' >是</label><label><input type="radio" name="allchild" checked="checked" value='0'>否 </label><span>我们都是未成年人</span></li>
                                        <li><label><input type="radio" name="hasold" value='1'>是</label><label><input type="radio" name="hasold" checked="checked" value='0'>否 </label><span>我们当中有（含）80岁以上的老人</span></li>
                                        <li><label><input type="radio" name="hasforeign" value='1'>是</label><label><input type="radio" name="hasforeign" checked="checked" value='0'>否 </label><span>我们当中有外籍友人（含港澳台同胞）</span></li>
                                    </ul>      
                                 </div>
                                     <h2 style="width:580px;">旅游合同 <span class="fr" style="color:#8f9c00;cursor:pointer;" id="mingxi">显示明细</span></h2>  
                                     <div class="mingxi_lis">
                                        <ul>
                                            <li>是否同意转至其他旅行社出团</li>
                                            <li>是否同意延期出团</li>
                                            <li>是否同意改变其他线路出团</li>
                                            <li>是否同意采用拼团方式出团</li>
                                         </ul>
                                     </div>
                                 </div>
                                <div class="ewai">
                                    <h3><img src="../../../static/img/mingxi_qian.png">额外约定</h3>
                                    <ul class="yanqi">
                                        <li><label>是否同意转至其他旅行社出团？<span><input type="radio" name="iszhuan" value="0" checked="checked">否</span><span><input type="radio" name="iszhuan" value="1" >是</span></label></li>
                                        <li><label>是否同意延期出团？<span><input type="radio" name="isyan" value="0" checked="checked">否</span><span><input type="radio" name="isyan" value="1" >是</span></label></li>
                                        <li><label>是否同意改变其他线路出团？<span><input type="radio" name="isgai" value="0" checked="checked">否</span><span><input type="radio" name="isgai" value="1" >是</span></label></li>
                                        <li><label>是否同意采用拼团方式出团？<span><input type="radio" name="iscai" value="0" checked="checked">否</span><span><input type="radio" name="iscai" value="1">是</span></label></li>
                                    </ul>
                               </div>
                               <div class="ewai">
                                    <h3><img src="../../../static/img/mingxi_qian.png">补充条款<span class="xianshi_one">显示明细</span></h3>
                                    <ul class="buchong_one">
                                        <li>是否同意转至其他旅行社出团？</li>
                                        <li>是否同意延期出团？</li>
                                        <li>是否同意改变其他线路出团？</li>
                                        <li>是否同意采用拼团方式出团？</li>
                                    </ul>
                               </div>
                               <div class="ewai">
                                    <h3><img src="../../../static/img/mingxi_qian.png">补充条款<span class="xianshi_two">显示明细</span></h3>
                                    <ul class="buchong_two">
                                        <li>是否同意转至其他旅行社出团？</li>
                                        <li>是否同意延期出团？</li>
                                        <li>是否同意改为其他线路出团？</li>
                                        <li>是否同意采用拼团方式出团？</li>
                                    </ul>
                               </div>
                           </ul>
                      <div class="xieyi_yes"><input type="checkbox" name="select_read" id="select_read" value="1"><span>我已阅读并接受以上合同条款、补充条款、保险条款、安全提示和其他所有内容</span></div>
                      <div class="tr_btn"><input type="submit" value="转订单" class="tijiao"/></div>
                      </form>
                      <?php }else{ echo '暂无订单信息';} ?>
<script type="text/javascript">
/*-------------------------js----------------------------*/
$(document).ready(function(){
    $(".fancybox-inner").css({"overflow-x":"hidden","overflow-y":"auto"});
});    

$(function(){
    
    $("#mingxi").click(function(){
        $(".mingxi_lis").toggle();
    });
     $(".xianshi_one").click(function(){
        $(".buchong_one").toggle();
    });
    $(".xianshi_two").click(function(){
        $(".buchong_two").toggle();
    });
})
function str(lue){
	var year=lue.substr(6,4);
	var month=lue.substr(10,2);
	var gay=lue.substr(12,2);
	var data=year+"-"+month+"-"+gay;
	return data;
	}
function birthday(obj) {
	var text=$(obj).val();
    $(obj).parent().next().find(".shengri_pt").val(str(text));
};
function delete_user(obj){

}

$(function(){
    $(".yespiao").click(function(){
        $(".fapiao").show();
    });
    $(".nopiao").click(function(){
        $(".fapiao").hide();
    });
    $(".clrakong").click(function(){
        $(this).siblings('li').find('input').val('');
        $(this).parent('li').find('select').val('');
    })
})
  function Checkevaluate(){
	 var  re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/; //验证邮箱 
	 var email=$('.email').val();
	  if(email==''){
		  alert('邮件不能为空!');
		  return false;
		}else{
			if(!re.test(email)){
				alert('邮件格式不对!');
				return false;
			 }
			
	    }
	  var read=$('#select_read').is(':checked');
	  if(!read){
		  alert('请同意合同条款后下单'); 
		  return false;
	   }

		jQuery.ajax({ type : "POST",data : jQuery('#orderInfo').serialize(),url : "<?php echo base_url()?>base/member/save_custom_order", 
			success : function(res) {
				var json = eval('(' + res + ')'); 
				if (json.code == 2000) {
					alert(json.msg);
					location.reload();
				}else if(json.code == 4000){
					alert(json.msg);
					location.reload();
				}
			
			}
		});
		return false;
	 }

//省份变动
$('select[name="province"]').change(function(){
	var province_id = $('select[name="province"] :selected').val();
	$('select[name="city"]').remove();
	$('select[name="region"]').remove();
	if (province_id == 0) {
		return false;
	}
	get_area(province_id);
})
//获取城市下拉框
function get_area(id) {
	$.post(
		"<?php echo site_url('order_from/order_info/get_area_json')?>",
		{'id':id},
		function(data) {
			data = eval('('+data+')');
			$('select[name="city"]').remove();
			str = "<select name='city'><option value='0'>请选择</option></select>";
			$('select[name="province"]').after(str);
			$.each(data,function(key ,val){
				str = "<option value='"+val.id+"'>"+val.name+"</option>";
				$('select[name="city"]').append(str);
			});
			$('select[name="city"]').change(function(){
				var city_id = $('select[name="city"] :selected').val();
				if (city_id == 0) {
					$('select[name="region"]').remove();
					return false;
				}
				get_region(city_id);
			})
		}
	);
}
//获取地区下拉框
function get_region(id) {
	$.post(
		"<?php echo site_url('order_from/order_info/get_area_json')?>",
		{'id':id},
		function(data) {
			data = eval('('+data+')');
			$('select[name="region"]').remove();
			str = "<select name='region'><option value='0'>请选择</option></select>";
			$('select[name="city"]').after(str);
			$.each(data,function(key ,val){
				str = "<option value='"+val.id+"'>"+val.name+"</option>";
				$('select[name="region"]').append(str);
			});
		}
	);
}
/*-------------------------end---------------------------*/
</script>
                  
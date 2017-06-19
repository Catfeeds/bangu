<?php
$set_url= $this->uri->segment (3, 0);
$set_url0= $this->uri->segment (4, 0);
$mess=$this->session->userdata('mess');
$is_union=$this->session->userdata('is_union');
$loginData = $this ->session ->userdata('loginSupplier');
$supplier_id = $loginData['id'];
$memuArr[0]['name']='产品管理';
/*$memuArr[0]['data']=array(
	array(site_url('admin/b1/product/'),'帮游产品','product'),
	array(site_url('admin/b1/products/product_list'),'产品汇总','product_list'),
	array(site_url('admin/b1/product_insert/destination'),'添加产品','product_insert'),
	array(site_url('admin/b1/group_line'),'定制团','group_line'),
	array(site_url('admin/b1/group_line_insert/destination'),'添加定制团','group_line_insert'),
	
	array(site_url('admin/b1/gift_manage'),'礼品管理','gift_manage'),
	array(site_url('admin/b1/line_review'),'线路点评','line_review'),
	array(site_url('admin/b1/travel_notes'),'线路游记','travel_notes'),
);*/

$memuArr[0]['data'][0]=array(site_url('admin/b1/product/'),'帮游产品','product');

$memuArr[0]['data'][1]=array(site_url('admin/b1/products/product_list'),'产品汇总','products');
$memuArr[0]['data'][6]=array(site_url('admin/b1/line_plan'),'计划列表','line_plan');

$memuArr[0]['data'][2]=array(site_url('admin/b1/product_insert/destination'),'添加产品','product_insert');

//if($is_union==1){
$memuArr[0]['data'][10]=array(site_url('admin/b1/b_group_line'),'帮游定制团','b_group_line');
$memuArr[0]['data'][4]=array(site_url('admin/b1/group_line/product_list'),'定制团','group_line');
//}else{
		
//}
$memuArr[0]['data'][5]=array(site_url('admin/b1/group_line_insert/destination'),'添加定制团','group_line_insert');
$memuArr[0]['data'][3]=array(site_url('admin/b1/line_single'),'单项产品','line_single');

$memuArr[0]['data'][11]=array(site_url('admin/b1/sales_apply'),'促销申请','sales_apply');

$memuArr[0]['data'][7]=array(site_url('admin/b1/gift_manage'),'礼品管理','gift_manage');
$memuArr[0]['data'][8]=array(site_url('admin/b1/line_review'),'线路点评','line_review');
$memuArr[0]['data'][9]=array(site_url('admin/b1/travel_notes'),'线路游记','travel_notes');

$memuArr[1]['name']='操作中心';
$memuArr[1]['data']=array(
    array(site_url('admin/b1/order'),'订单管理','order'),
    array(site_url('admin/b1/order_date'),'订单转团','order_date'),
	array(site_url('admin/b1/enquiry_order'),'回复询价','enquiry_order'),
	array(site_url('admin/b1/apply/apply_order'),'付款申请','apply_order'),
 	array(site_url('admin/b1/apply/apply_order_log'),'付款申请记录','apply_order_log'),
 	array(site_url('admin/b1/credit/credit_limit'),'额度审批','credit_limit'),
 	array(site_url('admin/b1/credit/return_limit'),'额度还款查询','return_limit'),
 	array(site_url('admin/b1/order_price'),'价格申请','order_price'),
 	array(site_url('msg/t33_msg_list/msg_list?supplier_id='.$supplier_id),'消息通知','msg_list'),
);

$memuArr[2]['name']='团队管理';
$memuArr[2]['data']=array(
	array(site_url('admin/b1/team/team_receive'),'团队收款表','team_receive'),
);
$memuArr[3]['name']='管家管理';
$memuArr[3]['data']=array(
    	array(site_url('admin/b1/app_line'),'售卖管家','app_line'),
	array(site_url('admin/b1/expert_upgrade'),'管家升级','expert_upgrade'),
	array(site_url('admin/b1/directly_expert'),'直属管家','directly_expert'),
);

$memuArr[4]['name']='结算管理';
$memuArr[4]['data']=array(
	array(site_url('admin/b1/account'),'C端结算','account'),
);

$memuArr[5]['name']='基础设置';
$memuArr[5]['data']=array(
	array(site_url('admin/b1/sxiu'),'我的场景秀','sxiu'),
	array(site_url('admin/b1/user_line'),' 投诉维权','user_line'),
	array(site_url('admin/b1/bank'),'开户银行','bank'),
	array(site_url('admin/b1/user_aq'),'安全中心','user_aq'),
	array(site_url('admin/b1/opportunity'),'培训公告','opportunity'),
	array(site_url('admin/b1/user'),'资料修改','user'),
);
$memuArr[6]['name']='数据统计';
$memuArr[6]['data']=array(
	array(site_url('admin/b1/count/line_type_count '),'产品分类统计','line_type_count'),
);
$memuArr[7]['name']='帮游消息通知';

/* if($mess['sum_msg']!=0){
	array_push($memuArr[7]['message'],array(site_url('admin/b1/messages'),'帮游消息通知'."  <span style='color:#FF0000'>(".$mess['sum_msg'].")</span>",'messages'));
}else{
	array_push($memuArr[7]['message'],array(site_url('admin/b1/messages'),'帮游消息通知','messages'));
} */

?>
<style type="text/css">
.right_ico { position:absolute;right:0;top:0;width:10px;height:100%;}
.right_ico span { position:absolute;right:0;top:50%;margin-top:-25px;height:50px;width:10px;background:#999;cursor:pointer;text-align:center;}
.right_ico span i { width:0;height:0;border-top: 6px solid transparent; border-bottom: 6px solid transparent; border-left:0;border-right: 6px solid #000;display:inline-block;position:relative;top:19px;}
.right_ico span.on i { border-top: 6px solid transparent; border-bottom: 6px solid transparent; border-left: 6px solid #000;border-right:0;display:inline-block;}
</style>
<div id="asideInner" class="aside_inner nui-scroll" style="position:absolute;left:0;top:0;width:100%;">
    <div class="mc">
        <dl id="user_nav_1">
            <dt class="home_link">
                <i class="mian_page small_ico"></i>
                <a class="a_url" href="/admin/b1/view">供应商主页</a>
            </dt>
            <dd></dd>
        </dl>
        <?php foreach ($memuArr as $key => $value) { ?>
	       <dl class="user_nav">
	            <dt >
	                <i class="small_ico"></i> 
	                <?php if($value['name']=="帮游消息通知"){ ?>
	                 <a href="/admin/b1/messages"> <?php } ?>
	                 <?php echo $value['name']; ?><?php  if($value['name']=="帮游消息通知" && $mess['sum_msg']!=0){echo "  <span style='color:#FF0000' class='sum_msg'>(".$mess['sum_msg'].")</span>";} ?>
	                </a>
	                <?php  if(!empty($value['data'])){ ?><b></b> <?php } ?>
	            </dt>
	              <?php if(!empty($value['data'])){?>
	            <dd style="display: none;">
	          
	                	<?php  foreach ($value['data'] as $item) { ?>
	          			                          
	          			<?php  if(!empty($set_url0)){ ?>
	
	       				<?php	if($set_url0==$item[2]){ ?>

	       		                        <div class="item cur">
					                    <a href="<?php echo $item[0];?>" <?php if($item[1]=="促销申请"){ echo 'style="color: #F40;"';} ?> ><?php echo $item[1];?></a>
					            </div>
	       
	       				<?php }else{ ?>

	       			                    <div class="item <?php if(!empty($set_url)){ if($set_url==$item[2]){ echo 'cur';}} ?>">
					                    <a href="<?php echo $item[0];?>" <?php if($item[1]=="促销申请"){ echo 'style="color: #F40;"';} ?> ><?php echo $item[1];?></a>
					            </div>
	       
	       				<?php	} ?>
		       			<?php }else{?>

		       		                    <div class="item <?php if(!empty($set_url)){ if($set_url==$item[2]){ echo 'cur';}} ?>">
					                    <a href="<?php echo $item[0];?>" <?php if($item[1]=="促销申请"){ echo 'style="color: #F40;"';} ?> ><?php echo $item[1];?></a>
					            </div>
		       
		       		<?php	} ?>
	
	          		 
				<?php } ?>
	                <!-- <div class="item">
	                    <a href="http://bangu.com/admin/t33/sys/line/line_list" target="main">产品详情</a>
	                </div> -->
	            </dd>
	             <?php } ?>
	        </dl>
        <?php } ?>

    </div>
</div>
<div class="right_ico"><span onclick="show_left_nav(this);"><i></i></span></div>
<script>
$('.cur').parent('dt').addClass('open');
$('.cur').parent('dd').show();

//左侧导航
	$(".user_nav dt").click(function(){
		
		if ($(this).hasClass("up")) {
			$(this).removeClass("up");
			$(this).siblings().slideUp("fast");
		}else {
			//$(".user_nav dt").removeClass("up");
			//$(".user_nav dd").slideUp("fast");
			$(this).addClass("up");
			$(this).siblings().slideDown("fast");
		}
	})	
	$(".mc dl dd .item").click(function(){
		$(".mc dl dd .item").removeClass("cur");
		$(this).addClass("cur");
	});
	$("#user_nav_1 dt").click(function(){
		$(".mc dl dd .item").removeClass("cur");
	});
	
	function show_left_nav(obj){
		if($(obj).hasClass("on")){
			$(".aside").animate({width:"160px"},200);	
			$("#asideInner").animate({width:"160px"},200);
			$("#asideInner").css("overflow-y","auto");
			$(".page-content").css("margin-left","160px");
			$(obj).removeClass("on");
		}else{
			$(".aside").animate({width:"10px"},200);
			$("#asideInner").animate({width:"0px"},200);
			$("#asideInner").css("overflow-y","hidden");
			$(".page-content").css("margin-left","10px");
			$(obj).addClass("on");
		}
	}
	
</script>
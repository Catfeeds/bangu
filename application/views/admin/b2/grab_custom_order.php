<style type="text/css">
.mashangqiangdan,.huifufangan,.zhuanxunjiadan,.yitoubiao{ margin-left: 4px;padding:6px 20px; border-radius: 5px;}
.indentListDiv .button{/*margin-top: 30px; */margin-bottom: 30px}
.zhongbiao{margin-left: -98px; background: rgba(0, 0, 0, 0) url("<?php echo base_url();?>assets/img/zhongbiao_icon.png") no-repeat; width: 68px;height: 77px; position: absolute;}
.jiadan{padding:8px 13px; }
.size_xs{border-width:7px;}
.plan_div{ position: absolute; background: #f6f6f6;top:55px; left: 687px; border: 1px solid #ccc;padding: 3px; visibility: hidden;z-index:100;}
.dankuang{ position: relative;}
.plan_div a{ color: #2a6496;}
.test:hover .plan_div{visibility: visible;}
p{ line-height: 20px;}
.indentListNumber{ border: 1px solid #ccc;padding: 4px 15px}
.bodyBody{ background: rgba(0,0,0,.5); }
.page-breadcrumbs {position: relative;min-height: 40px;line-height: 39px;padding: 0;display: block;z-index: 1;left: 0;}
.breadcrumb {padding-left: 10px;background: #fff none repeat scroll 0% 0%;height: 40px;line-height: 40px;box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);-webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2); -moz-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);}
.breadcrumb li {float: left;padding-right: 10px;color: #777;-webkit-text-shadow: none;text-shadow: none;}
.breadcrumb>li+li:before { padding: 0 5px;color: #ccc;content: "/\00a0";}
.page-content {display: block;margin-left: 160px;margin-right: 0;margin-top: 0;min-height: 100%;padding: 0;}

</style>

<!-- /Page Breadcrumb -->
<!-- Page Header -->
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo site_url('admin/b2/home/index')?>">主页</a></li>
        <li class="active">抢定制单</li></ul>
</div>

<div class="page-body" id="bodyMsg">
    <div class="bodyBody">
        <div class="widget">
            <div class="flip-scroll">
                <div class="tabbable">
                    <ul id="myTab5" class="nav nav-tabs tabs-flat">
                        <li name="tabs" class="active">
                            <a href="<?php echo base_url('admin/b2/grab_custom_order/index');?>" id="tab0">抢单</a></li>
                        <li name="tabs" class="tab-blue">
                            <a href="###" id="tab1">已投标</a></li>
                        <li name="tabs" class="tab-blue">
                            <a href="###" id="tab3">已中标</a></li>
                        <li name="tabs" class="tab-blue">
                            <a href="###" id="tab4">已取消</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_content0">
                            <!--抢单:数据开始-->
                            <?php if(!empty($grab_custom_list)):?>
                                <?php foreach ($grab_custom_list as $item): ?>
                                    <div class="indentList">
                                        <div class="indentListDiv">
                                            <p>
                                                <span class="number">编号：</span>
                                                <span class="indentListNumber">
                                                    <?php echo $item[ 'c_id']?></span>
                                            </p>
                                            <p>
                                                <span class="title">出发城市：</span>&nbsp;
                                                <span>
                                                    <?php echo $item[ 'startplace']?></span></p>
                                            <p>
                                                <span class="title">出游方式：</span>&nbsp;
                                                <span>
                                                    <?php if(!empty($item[ 'another_choose']) && $item[ 'trip_way']!=null){ echo $item[ 'trip_way']. '/'.$item[ 'another_choose'];}else{echo $item[ 'trip_way'];}?></span></p>
                                            <p>
                                                <span class="title">定制类型：</span>&nbsp;
                                                <span>
                                                    <?php echo $item[ 'custom_type']?></span></p>
                                            <p>
                                                <span class="title">联系方式：</span>&nbsp;
                                                <span class="contextcolor">中标后可见</span></p>
                                            <!-- <p class="order_request"><span class="title">其他要求：</span>&nbsp;<span class="contextcolor order_request_txt"><?php echo $item['other_service']?></span></p> --></div>
                                        <div class="indentListDiv">
                                            <p>
                                            </p>
                                            </br>
                                            <p>
                                                <span class="title">出行日期：</span>&nbsp;
                                                <span>
                                                    <?php if(!empty($item[ 'estimatedate']) && $item[ 'estimatedate']!=null){ echo $item[ 'estimatedate']. '(预估)';}else{ echo $item[ 'startdate']. '(确认)';}?></span></p>
                                            <p>
                                                <span class="title">目的地：</span>&nbsp;
                                                <span title="<?php echo $item['endplace_name']?>" class="order_desc_txt">
                                                    <?php echo $item[ 'endplace_name']?></span></p>
                                            <p>
                                                <span class="title">总人数：</span>
                                                <span>
                                                    <?php echo $item[ 'total_people']?>人</span></p>
                                            <p class="order_request">
                                                <span class="title">详细需求表述：</span>&nbsp;
                                                <span class="contextcolor order_request_txt" title="<?php echo $item['service_range']?>">
                                                    <?php echo $item[ 'service_range']?></span></p>
                                        </div>
                                        <div class="indentListDiv">
                                            <p>
                                            </p>
                                            </br>
                                            <p>
                                                <span class="title">希望人均预算：</span>&nbsp;
                                                <span>￥
                                                    <?php echo $item[ 'budget']?></span></p>
                                            <p>
                                                <span class="title">希望游玩时长：</span>
                                                <span>
                                                    <?php echo $item[ 'days']?>天</span>&nbsp;&nbsp;&nbsp;&nbsp;</p></div>
                                        <div class="indentListDiv" style="min-width:130px;">
                                            <?php if($item[ 'grab_opera']=='grab_order' ):?>
                                                <p>
                                                    <span class="title times">距结束</span></p>&nbsp;
                                                <p>
                                                    <span id="given_date<?php echo $item['c_id']?>" name="given_date" data-val="<?php echo $item['start_timer']?>|<?php echo $item['end_timer']?>"></span></p>
                                                <p class="button button_1">
                                                    <a class="mashangqiangdan" data-val="<?php echo $item['c_id']?>" onclick="grab_custom(this)">马上抢单</a></p>
                                                <?php else:?>
                                                    <p class="button">
                                                        <a class="huifufangan" target="_blank" href="<?php echo base_url()?>admin/b2/grab_custom_order/show_grab_custom?id=<?php echo $item['c_id'].'&ca_id='.$item['ca_id']?>">回复方案</a></p>
                                                    <p class="button ">
                                                        <a class="zhuanxunjiadan" target='_blank' href="<?php echo base_url()?>admin/b2/grab_custom_order/show_go_inquiry_2?id=<?php echo $item['c_id'].'&ca_id='.$item['ca_id']?>">转询价单</a></p>
                                                    <?php endif;?></div>
                                    </div>
                                    <?php endforeach;?>
                                        <div class="pagination">
                                            <?php echo $this->page->create_page()?></div>
                                        <?php else:?>
                                            <table width="100%" class="table table-hover">
                                                <thead class="bordered-darkorange">
                                                    <tr>
                                                        <th class="x-column-header" style="text-align:center" width="930">&nbsp;&nbsp;</th></tr>
                                                </thead>
                                                <tbody>
                                                    <tr colspan="1">
                                                        <td style="text-align: center;font-weight: bold;color: red;font-size: 14px; vertical-align: middle;" colspan="1" height="200">无数据</td></tr>
                                                </tbody>
                                            </table>
                                            <?php endif;?></div>
                        <!--数据结束-->
                        <div class="tab-pane" id="tab_content1">
                            <!--已投标:数据开始-->
                            <div class="div_grab_custom1">
                                <form action="<?php echo base_url();?>admin/b2/grab_custom_order/reply_list" id='grab_custom1' name='grab_custom1' method="post">
                                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                                    <input type="hidden" name="isreply" value='0' />
                                    <div id="grab_custom_dataTable1">
                                        <!--列表数据显示位置--></div>
                                    <div class="row DTTTFooter">
                                        <div class="col-sm-6">
                                            <div class="dataTables_info" id="editabledatatable_info">第
                                                <span class='pageNum'>0</span>/
                                                <span class='totalPages'>0</span>页 ,
                                                <span class='totalRecords'>0</span>条记录,每页
                                                <label>
                                                    <select name="pageSize" id='grab_custom_Select1' class="form-control input-sm">
                                                        <option value="">--请选择--</option>
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option></select>
                                                </label>条记录</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="dataTables_paginate paging_bootstrap">
                                                <!-- 分页的按钮存放 -->
                                                <ul class="pagination"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--数据结束-->
                        <div class="tab-pane" id="tab_content2">
                            <!--已中标:数据开始-->
                            <div class="div_inquiry_list2">
                                <form action="<?php echo base_url();?>admin/b2/grab_custom_order/grab_order_list" id='grab_custom2' name='grab_custom3' method="post">
                                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                                    <div id="grab_custom_dataTable2">
                                        <!--列表数据显示位置--></div>
                                    <div class="row DTTTFooter">
                                        <div class="col-sm-6">
                                            <div class="dataTables_info" id="editabledatatable_info">第
                                                <span class='pageNum'>0</span>/
                                                <span class='totalPages'>0</span>页 ,
                                                <span class='totalRecords'>0</span>条记录,每页
                                                <label>
                                                    <select name="pageSize" id='grab_custom_Select2' class="form-control input-sm">
                                                        <option value="">--请选择--</option>
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option></select>
                                                </label>条记录</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="dataTables_paginate paging_bootstrap">
                                                <!-- 分页的按钮存放 -->
                                                <ul class="pagination"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--数据结束-->
                        <div class="tab-pane" id="tab_content3">
                            <!--已过期:数据开始-->
                            <div class="div_grab_custom_list3">
                                <form action="<?php echo base_url();?>admin/b2/grab_custom_order/expired_order_list" id='grab_custom3' name='grab_custom4' method="post">
                                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                                    <div id="grab_custom_dataTable3">
                                        <!--列表数据显示位置--></div>
                                    <div class="row DTTTFooter">
                                        <div class="col-sm-6">
                                            <div class="dataTables_info" id="editabledatatable_info">第
                                                <span class='pageNum'>0</span>/
                                                <span class='totalPages'>0</span>页 ,
                                                <span class='totalRecords'>0</span>条记录,每页
                                                <label>
                                                    <select name="pageSize" id='grab_custom_Select3' class="form-control input-sm">
                                                        <option value="">--请选择--</option>
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option></select>
                                                </label>条记录</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="dataTables_paginate paging_bootstrap">
                                                <!-- 分页的按钮存放 -->
                                                <ul class="pagination"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--数据结束--></div>
                </div>
            </div>
        </div>
    </div>
</div>





<script src="<?php echo base_url('assets/js/diyUpload.js') ;?>"></script>
<script type="text/javascript">
var columnArr=[];
var tabI_index = <?php echo $tab_index?>;

//已投标
var grab_custom_columns_1=[ {field : 'id',title : '',width : '930',
formatter : function(value,	rowData, rowIndex){
if(rowData['another_choose']!=''&&rowData['another_choose']!=null){       //出行方式
	var trip_way=rowData['trip_way']+'/'+rowData['another_choose'];
}else{
	var trip_way=rowData['trip_way'];
}
if(rowData['startdate']!=''&&rowData['startdate']!=null){       //出行方式
	var startdate=rowData['startdate']+'(确认)';
}else{
	var startdate=rowData['estimatedate']+'(预估)';
}
var html="<div class='indentList'><div class='indentListDiv'><p><span class='number'>编号：</span><span class='indentListNumber'>"+rowData['c_id']+"</span></p><p><span class='title'>出发城市：</span>&nbsp;<span>"+rowData['startplace']+"</span></p><p><span class='title'>出游方式：</span>&nbsp;<span>"+trip_way+"</span></p><p><span class='title'>定制类型：</span>&nbsp;<span>"+rowData['custom_type']+"</span></p><p class='order_request'><span class='title'>详细需求表述：</span>&nbsp;<span class='contextcolor order_request_txt' title='"+rowData['service_range']+"'>"+rowData['service_range']+"</span></p><p><span class='title'>联系方式：</span>&nbsp;<span class='contextcolor'>中标后可见</span></p></div><div class='indentListDiv'><p></p></br><p><span class='title'>出行日期：</span>&nbsp;<span>"+startdate+"</span></p><p><span class='title'>目的地：</span>&nbsp;<span class='order_desc_txt' title='"+rowData['endplace_name']+"' >"+rowData['endplace_name']+"</span></p><p><span class='title'>总人数：</span><span>"+rowData['total_people']+"人</span></p></div><div class='indentListDiv'><p></p></br><p><span class='title'>希望人均预算：</span>&nbsp;<span>￥"+rowData['budget']+"</span></p><p><span class='title'>希望游玩时长：</span><span>"+rowData['days']+"天</span>&nbsp;&nbsp;&nbsp;&nbsp;</p></div><div  class='indentListDiv'><div  class='test'><p class='button dankuang'><a class='huifufangan' data-val='"+rowData['id']+"|"+rowData['cid']+"'>查看方案</a></p>";
	if(rowData['plan']!=undefined && rowData['plan'].length>0){
		html+="<div class='plan_div'>";
		var string='';
		var k_index = 1;
		$.each(rowData['plan'],function(key,val){
			if(val['isuse']==1){
				var string='已中标';
			}else{
				var string='未中标';
			}
			html += "<div ><a target='_blank' href='<?php echo base_url()?>admin/b2/grab_custom_order/preview_go_inquiry?id="+rowData['c_id']+"&ca_id="+val['ca_id']+"&is_specifed=1'>方案"+k_index+"</a>&nbsp;&nbsp;<span>回复时间：</span><span>"+val['replytime']+"</span>&nbsp;&nbsp;<span>"+string+"</span></div>";
			k_index++;
		});
		html+="</div>";
	}

	html += "</div><p class='button'><a class='yitoubiao' target='_blank'  href='<?php echo base_url()?>admin/b2/grab_custom_order/show_grab_custom?id="+rowData['c_id']+"'>再次投标</a></p>";
	if(rowData['situation']=='no_turn'){
		html +="<p class='button'><a class='zhuanxunjiadan' href='<?php echo base_url('admin/b2/inquiry_sheet/index')?>'>查看询价单</a></p>";
	}else{
		html +="<p class='button'><a class='zhuanxunjiadan' target='_blank' href='<?php echo base_url()?>admin/b2/grab_custom_order/show_go_inquiry?id="+rowData['c_id']+"&ca_id="+rowData['ca_id']+"'>转询价单</a></p>";
	}

return html;
}
}];



//已经中标
var grab_custom_columns_2=[ {field : 'id',title : '',width : '930',
formatter : function(value,	rowData, rowIndex){
if(rowData['another_choose']!='' && rowData['another_choose']!=null){       //出行方式
	var trip_way=rowData['trip_way']+'/'+rowData['another_choose'];
}else{
	var trip_way=rowData['trip_way'];
}
var html="<div class='indentList'><div class='indentListDiv'><p><span class='number'>编号：</span><span class='indentListNumber'>"+rowData['c_id']+"</span></p><p><span class='title'>出发城市：</span>&nbsp;<span>"+rowData['startplace']+"</span></p><p><span class='title'>出游方式：</span>&nbsp;<span>"+trip_way+"</span></p><p><span class='title'>定制类型：</span>&nbsp;<span>"+rowData['custom_type']+"</span></p><p><span class='title'>详细需求表述：</span>&nbsp;<span class='contextcolor order_request_txt' title='"+rowData['service_range']+"'>"+rowData['service_range']+"</span></p><p><span class='title'>联系方式：</span>&nbsp;<span class='contextcolor order_request_txt' style='color:red'>"+rowData['truename']+"-"+rowData['mobile']+"</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	if(rowData['qq']!=null && rowData['qq']!=""){
		html+="QQ-"+rowData['qq'];
	}
if(rowData['estimatedate']!=''&& rowData['estimatedate']!=null){     //出行时间
	var time=rowData['estimatedate']+'(预估)';
}else{
	var time=rowData['startdate']+'(确认)';
}

html+="</span></p></div><div class='indentListDiv'><p></p></br><p><span class='title'>出行日期：</span>&nbsp;<span>"+time+"</span></p><p class='order_request'><span class='title' >目的地：</span>&nbsp;<span title='"+rowData['endplace_name']+"' class='order_desc_txt' >"+rowData['endplace_name']+"</span></p><p><span class='title'>总人数：</span><span>"+rowData['total_people']+"人</span></p></div><div class='indentListDiv'><p></p></br><p><span class='title'>希望人均预算：</span>&nbsp;<span>￥"+rowData['budget']+"</span></p><p><span class='title'>期望游玩时长：</span><span>"+rowData['days']+"天</span>&nbsp;&nbsp;&nbsp;&nbsp;</p></div><div  class='indentListDiv'>";
if(rowData['situation']=='no_turn'){
html+="<div class='test'><p class='button' ><a id=inquiry"+rowData['id']+" data-val="+rowData['id']+" class='zhuanxunjiadan jiadan' style='background-color:#2dc3e8'>查看方案</a></p><div class='plan_div'>";
   if(rowData['plan']!=undefined && rowData['plan'].length>0){
		var string='';
		var k_index = 1;
		$.each(rowData['plan'],function(key,val){
			if(val['isuse']==1){
				var string='已中标';
			}else{
				var string='未中标';
			}
			html += "<div ><a target='_blank' href='<?php echo base_url()?>admin/b2/grab_custom_order/preview_go_inquiry?id="+rowData['c_id']+"&ca_id="+val['ca_id']+"&is_specifed=2'>方案"+k_index+"</a>&nbsp;&nbsp;<span>回复时间：</span><span>"+val['replytime']+"</span>&nbsp;&nbsp;<span>"+string+"</span></div>";
			k_index++;
		});
	}
   html+="</div></div>";
}else{
html+="<p class='button' ><a id=inquiry"+rowData['c_id']+" data-val="+rowData['c_id']+" target='_blank' href='<?php echo base_url()?>admin/b2/grab_custom_order/show_go_inquiry?id="+rowData['c_id']+"&ca_id="+rowData['ca_id']+"' class='zhuanxunjiadan'>转询价单</a></p>";
}
html+="<p><i class='title zhongbiao' style='margin-top:10px; margin-left:17px'></i></p></div></div>";
return html;
}
}];

//已过期
var grab_custom_columns_3=[ {field : 'c_id',title : '',width : '930',
formatter : function(value,	rowData, rowIndex){
if(rowData['another_choose']!='' && rowData['another_choose']!=null){       //出行方式
	var trip_way=rowData['trip_way']+'/'+rowData['another_choose'];
}else{
	var trip_way=rowData['trip_way'];
}
if(rowData['estimatedate']!=''&& rowData['estimatedate']!=null){     //出行时间
	var time=rowData['estimatedate']+'(预估)';
}else{
	var time=rowData['startdate']+'(确认)';
}
var html="<div class='indentList'><div class='indentListDiv'><p><span class='number'>编号：</span><span class='indentListNumber'>"+rowData['c_id']+"</span></p><p><span class='title'>出发城市：</span>&nbsp;<span>"+rowData['startplace']+"</span></p><p><span class='title'>出游方式：</span>&nbsp;<span>"+trip_way+"</span></p><p><span class='title'>定制类型：</span>&nbsp;<span>"+rowData['custom_type']+"</span></p><p class='order_request'><span class='title'>详细需求表述：</span>&nbsp;<span class='contextcolor order_request_txt' title='"+rowData['service_range']+"'>"+rowData['service_range']+"</span></p></div><div class='indentListDiv'><p></p></br><p><span class='title'>出行日期：</span>&nbsp;<span>"+time+"</span></p><p><span class='title'>目的地：</span>&nbsp;<span class='order_desc_txt' title='"+rowData['endplace_name']+"'>"+rowData['endplace_name']+"</span></p><p><span class='title'>总人数：</span><span>"+rowData['total_people']+"人</span></p></div><div class='indentListDiv'><p></p></br><p><span class='title'>希望人均预算：</span>&nbsp;<span>￥"+rowData['budget']+"</span></p><p><span class='title'>希望游玩时长：</span><span>"+rowData['days']+"天</span>&nbsp;&nbsp;&nbsp;&nbsp;</p></div><div  class='indentListDiv'><p class='cancel_p'><i class='title yiquxiao' ></i></p></div></div>";
return html;
}

}];
columnArr[1] =   grab_custom_columns_1;
columnArr[2] =   grab_custom_columns_2;
columnArr[3] =   grab_custom_columns_3;
var isJsonp= false ;// 是否JSONP,跨域
$(document).ready(function(){
var loadIndex=[];//记录哪些tab 加载过
loadIndex[0]=0;
$("#myTab5 li").click(function(){
$("#myTab5 li").removeClass("active");
$(this).addClass("active");
var index=$("#myTab5 li").index($(this));
$(".tab-pane").removeClass("active");
$(".tab-pane").eq(index).addClass("active");
if(index!=0){
initTableForm("#grab_custom"+index,"#grab_custom_dataTable"+index,columnArr[index],isJsonp ).load();
}
loadIndex[index]=index;
});

$('#grab_custom_Select1').change(function(){
initTableForm("#grab_custom1","#grab_custom_dataTable1",grab_custom_columns_1,isJsonp ).load();
});
$('#grab_custom_Select2').change(function(){
initTableForm("#grab_custom2","#grab_custom_dataTable2",grab_custom_columns_2,isJsonp ).load();
});
$('#grab_custom_Select3').change(function(){
initTableForm("#grab_custom3","#grab_custom_dataTable3",grab_custom_columns_3,isJsonp ).load();
});



$.each($("span[name='given_date']"), function(i,val){
	var val_id = $(val).attr('id');
	var date_arr = $(val).attr('data-val').split('|');
	var start_date = date_arr[0];
	var end_date = date_arr[1];

	$('#'+val_id).countdowntimer({
	startDate : start_date,
	dateAndTime : end_date,
	size : "xs",
	borderColor : "#000000"
	},function timeisUp() {
	        alert('test');
	});
	});



	 $("#myTab5 li").eq(tabI_index).click() ;
});

//马上抢单
function grab_custom(obj){
	var id = $(obj).attr('data-val');
	$.post("<?php echo base_url('admin/b2/grab_custom_order/grab_custom')?>",
	{'id':id},
	function(data){
	data = eval('('+data+')');
	alert(data);
	location.reload();
	});
}

/*$(function(){

});*/

</script>

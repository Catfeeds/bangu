<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>价格申请</title>
<link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
<link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css')?>" rel="stylesheet" type="text/css" />
<style type="text/css">
h1, h2, h3, h4, h5, h6, ul, li, dl, dt, dd, form, img, ol, p{ font-family: "微软雅黑" !important; color: #444}
.last_time { border:5px solid #000;border-radius:2px;font-size:14px;}
.check_project { position:relative;}
.hide_project_title { display:none;position:absolute;top:15px;left:-235px;width:280px;border:1px solid #94A100;background:#f8f8f8;padding:5px 10px;line-height:25px;border-radius:3px;z-index:999;}
.hide_project_title p { text-align:left;}
.hide_project_title p a { padding-right:15px;}
.hide_project_title p a:hover { text-decoration:underline;}
.hide_project_title p span { padding-right:15px;}
.action_type { position:relative;}
.check_project .action_type i { width: 7px; height: 4px; background: url(<?php echo base_url();?>assets/img/custom_list_ico1.png) 0px 0px no-repeat; position: absolute; margin-left: 2px; top: 7px;}
#list1 .x-grid-cell-inner .action_type{ width:50%;margin:0;}
#list1 .x-grid-cell-inner a:nth-child(1) { text-align:center;}
.x-grid-cell-inner .check_project { margin:0 10px 0 25px;}
.x-grid-cell-inner .action_type { margin:0 10px;}
.DTTTFooter{ padding-top: 15px;}
.table_content{ padding: 0}
.page-breadcrumbs {position: relative;min-height: 40px;line-height: 39px; padding: 0; display: block;z-index: 1;left: 0;}
.fa-home:before {content: "\f015";}
.breadcrumb {padding-left: 10px; background: #fff none repeat scroll 0% 0%;height: 40px;line-height: 40px;box-shadow: none;}
.breadcrumb li {float: left;padding-right: 10px;color: #777;-webkit-text-shadow: none;text-shadow: none;}
.breadcrumb>li+li:before {padding: 0 5px;color: #ccc; content: "/\00a0";}
.page-content {display: block;margin-left: 160px;margin-right: 0; margin-top: 0;min-height: 100%;padding: 0;}
.nav-tabs,.bg_gray{ background: #eaedf1;}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px; font-size: 12px; font-family: "宋体"; color: #555;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.shadows{box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4); -webkit-box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4);-moz-box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4);box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4);}
.formBox{ padding:0; padding-bottom:5px; margin-bottom:5px;}
select{ height:24px; line-height:24px;}
.form-group{ margin-right: 20px; float:left;}
.form-group label{ height: 24px; line-height: 24px; border: 1px solid #dedede; border-right:none; padding: 0 6px; color: #333; float: left}
.form-group input{ height: 24px; line-height: 24px; padding: 0  10px; float: left;width: 76px;}
.box-title h4{ height:40px; line-height:40px; background:#f1f1f1; text-indent:10px;}
.trip_every_day{ padding:20px 15px;}
.trip_every_day img{ padding:0px 5px; margin-top:5px;}
.trip_every_day .trip_day_title{ line-height:24px;}
.trip_content_left{ font-weight: bold;}
.trip_content_right{ padding-left:60px;}
.x-grid-cell-inner a{ display: inline-block; padding: 0 5px; color: #09c;}
.table_content { padding-top:0 !important;}
.tab_content { padding:0 !important;}
.page-button{margin-top:20px;height:30px;}
.page-button li{padding: 5px 12px;border: 1px solid rgb(221, 221, 221);cursor: pointer;margin-right: 2px;list-style-type: none;float: left;}
.page-button .active-page{background:#2DC3E8;color:#fff;cursor: inherit;}
.page-button .disable-page{background: #e9e9e9;cursor: inherit;border: 1px solid #ccc;}
</style>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
</head>
<body>
<div class="page-content bg_gray">
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home')?>"> 主页 </a></li>
            <li class="active">单项预订</li>
        </ul>
    </div>
    
  
    <div style="height:40px;background:#fff;padding-left:20px;">
      <p style="font-size:14px;line-height:40px;float:left">现金额度:<span style="color:red"><?php echo number_format($account['cash_limit'],2);?></span></p>
      <p style="font-size:14px;line-height:40px; margin-left:30px;float:left">信用额度:<span style="color:red"><?php echo number_format($account['credit_limit'],2);?></span></p>
      <p style="font-size:14px;line-height:40px;margin-left:30px;float:left">可用额度:<span style="color:red"><?php echo number_format($account['cash_limit']+$account['credit_limit'],2);?></span></p>
    </div>
   
    <div class="page-body" id="bodyMsg" style="padding-top:0 !important;">

        <div class="table_content">
            <div class="tab_content">
                <!-- 抢单标签数据 -->
                <div class="table_list" id="list1">
                <form id='search-condition' method="post">
               		<div class="form-inline formBox shadow">
<!-- 		            	<div class="form-group"> -->
<!-- 		                	<label class="search_title col_span" >线路类型:</label> -->
<!-- 		                	<select id="dest_select" name="destid" class="dest_select ie8_select"> -->
<!-- 		                    	<option value="">--请选择--</option> -->
<!-- 		                	</select> -->
<!-- 		              	</div> -->
		                <div class="form-group">
		                    <label class="search_title col_span" >出发地:</label>
		                    <input class="search-input form-control ie8_input" type="text" id="start_place" name="start_place" style="width:100px" />
		                </div>
		                <div class="form-group">
		                    <label class="search_title col_span" >出团时间:</label>
		                    <input class="search-input form-control starttime" style="width:70px;" type="text" placeholder="开始时间"  name="starttime" />
		                    <label style="border:none;width:auto;">-</label>
		                    <input class="search-input form-control endtime" style="width:70px;" type="text" placeholder="结束时间"  name="endtime" />
		                </div>

		                <div class="form-group">
		                    <label class="search_title col_span" >价格:</label>
		                    <input class="search-input form-control" style="width:40px;" type="text" name="start_price" />
		                    <label style="border:none;width:auto;">至</label>
		                    <input class="search-input form-control" style="width:40px;" type="text" name="end_price" />
		                </div>
                        <div class="form-group">
                            <label class="search_title col_span" >产品标题:</label>
                            <input type="text"  name="linename" class="form-control search-input ie8_input" style="width:107px;"/>
                        </div>
                        <div class="form-group">
                            <label class="search_title col_span" >单项编号:</label>
                            <input type="text" name="linecode" class="form-control search-input ie8_input" style="width:100px;"/>
                        </div>

		                <input type="submit" value="搜索" class="btn btn-darkorange" style="position: relative; top: 10px; float: left;padding: 3px 5px;" />
		            </div>
                    </form>
                    <div id="dataTable"><!--列表数据显示位置--></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">
var expertId = <?php echo $expertId?>;
var columns=[{field : 'linename',title : '线路标题',width : '200',align : 'left'},
            {field : 'linecode',title : '单项编号',width : '90',align : 'center'},
            {field : 'day',title : '出团日期',width : '90',align : 'center'},
            {field : 'cityname',title : '出发城市',width : '90',align : 'center'},
            //{field : 'kindname',title : '目的地',width : '90',align : 'center'},
            {field : 'number',title : '库存',width : '90',align : 'center'},
            {field : 'adultprice',title : '成人价',width : '90',align : 'center'},
           // {field : 'oldprice',title : '老人价',width : '90',align : 'center'},
            {field : 'childprice',title : '儿童价格',width : '90',align : 'center'},
            {field : 'childnobedprice',title : '不占床儿童价',width : '90',align : 'center'},
            {field : false,title : '行程文件', align : 'center',width : '100', formatter: function(result) {

            	var str="";
            	if(result.file_path!=null)
            	{
	                var file_path=result.file_path.split(",");
	                var file_name=result.file_name.split(",");
	                
	                var base_url="<?php echo BANGU_URL;?>";
	                for (i=0;i<file_path.length ;i++ ) 
	                { 
	                    str+="<a href='"+base_url+file_path[i]+"'>"+file_name[i]+"</a><br/>";
	                } 
            	}
                return  str;
        	 }
		    },
            {field : false,title : '操作', align : 'center',width : '100', formatter: function(result) {
	                return  "<a target='_blank' href='/order_from/order_info/order_basic?day_id="+result.dayid+"&expert_id="+expertId+"'>预定</a>&nbsp;";
            	}
			}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/b2/reserve/getReserveJson',
	pageSize:10,
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});


/*将后台传过来的数据组装成树形结构*/
function listToTree(list,pid) {
  var ret = [];//一个存放结果的临时数组
  for(var i in list) {
    if(list[i].pid == pid) {//如果当前项的父id等于要查找的父id，进行递归
        list[i].children = listToTree(list, list[i].id);
        ret.push(list[i]);//把当前项保存到临时数组中
    }
  }
  return ret;//递归结束后返回结果
}

//最后拼接成一个完整的select数据
var tree_tag = '';
function creatSelectTree(d){
   var option="";
   for(var i=0;i<d.length;i++){
   if(d[i].children.length){//如果有子集
        option+="<option value='"+d[i].id+"'>"+tree_tag+d[i].kindname+"</option>";
      	tree_tag+="&nbsp;&nbsp;&nbsp;";//前缀符号加一个符号
        option+=creatSelectTree(d[i].children);//递归调用子集
     	 tree_tag=tree_tag.slice(0,tree_tag.length-18);//每次递归结束返回上级时，前缀符号需要减一个符号
       }else{//没有子集直接显示
         option+="<option value='"+d[i].id+"'>"+tree_tag+d[i].kindname+"</option>";
        }
       }
    return option;//返回最终html结果
  }
//目的地
// $.post('/admin/a/comboBox/get_destinations_data', {}, function(data) {
//   var data = eval('(' + data + ')');
//   var dest_list = listToTree(data,0);
//   $(".dest_select").append(creatSelectTree(dest_list));
// });


//出发地
$.post('/admin/a/comboBox/get_startcity_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var array = new Array();
  $.each(data, function(key, val) {
    array.push({
        text : val.cityname,
        value : val.id,
    });
  })
  var comboBox = new jQuery.comboBox({
      id : "#start_place",
      name : "start_place_id",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {}, // 选择后的事件
      data : array
  });
  var comboBox = new jQuery.comboBox({
      id : "#start_place2",
      name : "start_place_id",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {}, // 选择后的事件
      data : array
  });
});

$('.starttime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});
$('.endtime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});

</script>
</body>
</html>

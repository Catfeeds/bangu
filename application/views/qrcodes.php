<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
 <link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<title>线下活动入场券</title>
<style type="text/css">
	* { box-sizing:border-box;margin:0;padding:0;}
	body { background:#fff;}
	input { border:0;outline:none}
	
	.action_info { margin-top:50px;}
	
	.title_txt { padding:7px 0;color:#a67e3c;font-size:14px;}
	.form_info { width:75%;margin:0 auto;}
	.form_group { margin-bottom:11px;padding:0 5px;}
	.form_group div { position:relative;}
	.form_group div input { background:#f8975a;border-radius:5px;padding:5px 23px;line-height:30px;color:#fff;width:100%;}
	.form_group div span { position:absolute;left:23px;top:0px;line-height:40px;color:#fff;}

	.sub_btn { height:40px;line-height:40px;border-radius:5px;background:#f8975a;font-size:14px;color:#fff;border:0;width:100%;text-align:center;margin-top:15px;}
	
	.name_list { padding:20px 10px;}
	.name_list .title { text-align:center;padding-bottom:10px;}
	.name_table table { border-color:#ddd;}
	.name_table table thead tr td,.name_table table tbody tr td { text-align:center;}
	table { border-top:1px solid #ddd;border-left:1px solid #ddd;}
	table td { border-right:1px solid #ddd;border-bottom:1px solid #ddd;padding:5px 8px;}
	table thead tr td { background:#F1F1F1;font-size:14px;}
	table tbody tr td { font-size:13px;}
	
	.hide_box { position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);width:100%;height:100%;display:none;}
	.content { width:80%;position:absolute;left:10%;top:10%;background:#fff;border-radius:5px;}
	.close { font-family: "微软雅黑";font-style:normal; font-size: 30px !important; width: 25px; height: 25px;line-height:20px; position: absolute; right: -12px; top: -12px; background: #d0d0d0; cursor: pointer; border-radius: 60px; text-align: center;}
	.content p { text-align:center;padding:15px 10px 10px;font-size:16px;}
	.content div { padding:0 20px 20px;}
	.content div img { width:100%;}
</style>
</head>
<body class="body_back">
	<div class="action_info">
        <div class="form_info">
            	<div class="form_group"><div><input type="text" class="name" name="name"/><span class="txt_title">请输入姓名</span></div></div>
                <div class="form_group"><div><input type="number" class="mobile" name="mobile"/><span class="txt_title">请输入手机号</span></div></div>
                <div class="form_group"><button class="sub_btn" onClick="get_code();">报名生成二维码</button></div> 
        </div>
        <div class="name_list">
        	<p class="title">报名名单</p>
        	<div class="table_list" id="dataTable_list">

        </div>
    </div>
    <div class="hide_box">
    	<div class="content">
        	<i class="close" onClick="close_box();">×</i>
        	<p>报名成功</p>
            <div class="code_pic"><!--<img src="<?php echo base_url('static');?>/img/weixin_img.png"/> --></div>
        </div>
    </div>

<!--<span>总注册人数:<?php echo $sum;?></span>
<span>已使用人数:<?php  if(!empty($usersum)){ echo $usersum;}else{ echo 0;} ?></span> -->
</body>
</html>

<script>
    var columns3 = [ 
            {field : 'id',title : '序号',align : 'center', width : '100'},
            {field : 'name',title : '姓名',align : 'center', width : '120'},
            {field : 'mobile',title : '手机号',align : 'center', width : '100'},
            {field : false,title : '审核状态',align : 'center', width : '80',formatter:function(result) {
        		if(result.isuse==1){
        			return '是';
        		}else{
        			return '否';
        		}
              }
            }         
       ];

   var columns = columns3;
  $("#dataTable_list").pageTable({
      columns:columns,
      url:'/qrcodes/get_member_list',
      pageSize:10,
      tbodyClass:'t_tbody',
      searchForm:'#search-condition_list',
      tableClass:'table table-bordered table_hover'
  });

$(function(){
	$(".txt_title").click(function(){
		$(this).hide();	
		$(this).siblings("input").focus();
	});
	$(".name,.mobile").focus(function(){
		$(this).siblings("span").hide();
	});
	$(".name,.mobile").blur(function(){
		var len = $(this).val();length;
		if(len<=0){
			$(this).siblings("span").show();
		}
	});	
})
function get_code(){
	var name=$('input[name="name"]').val();
	var mobile=$('input[name="mobile"]').val();	
	if(name.length>0){
		if(judge_mobile()){
			$.post("/qrcodes/code",{'name':name,'mobile':mobile},function(data){
				var data = eval("("+data+")");
				console.log(data);
				if(data.status == -1){
					alert("此号码已经报名");
				}else{
					$('.code_pic').html('<img src="'+data.code_pic+'" />');
					$(".hide_box").show();
				}	
			});
		}else{
			alert("请输入正确的手机号");
			$(".mobile").focus();
		}
	}else{
		alert("姓名不能为空");
		$(".name").focus();
	}
	  var columns = columns3;
	  $("#dataTable_list").pageTable({
	      columns:columns,
	      url:'/qrcodes/get_member_list',
	      pageSize:10,
	      tbodyClass:'t_tbody',
	      searchForm:'#search-condition_list',
	      tableClass:'table table-bordered table_hover'
	  });	
}
function close_box(){
	$(".hide_box").hide();
}
/*============= 判断  手机号=============*/
function judge_mobile(){
	var myreg = /^((13|15|18|17)+\d{9})$/;
	var mobile=$(".mobile").val();
	if(!myreg.test(mobile)){
		return false;
	}else{
		return true;
	}
}
</script>


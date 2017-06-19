<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('static'); ?>/css/plugins/diyUpload.css" rel="stylesheet" type="text/css" />
<style>

.eject_title .comment_line,.comment_saleline{ height:40px; line-height:40px;}
.eject_content{ float:left;}
i{ font-style: normal;}
.eject_input_Slide, .eject_input_Slide textarea{ width:500px;}
.eject-content_left{float:left;}
.page-content{ min-width: auto !important; }


.title_info_txt1,.title_info_txt2,.tset_1,.tset_2{ display:none;}
#rt_rt_1a5vrdt1p1dok105afeo1hhl1n1{ width:80px !important; height:30px !important;}
#as2 div:last-child{width:90px !important; height:24px !important; margin-top:10px !important; margin-left:5px !important;}
.webuploader-pick{ width:102px; margin-left:0px; z-index:1000;}
.parentFileBox{ top:45px; height:80px; left:5px;}
.parentFileBox>.fileBoxUl{ top:0px;}
.parentFileBox>.diyButton>a{ padding:3px 6px 3px 6px} 
.parentFileBox>.diyButton{ position:absolute; top:0px;}
.diyStart{ top:0}
.diyCancelAll{ top:35px;}

.eject_content_left_s{margin-top:20px;}
.eject_content_left_s input{height:28px;}



</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>促销产品</li>
	</ul>
	<div class="page-body" style="margin: 0;">
		<ul class="nav-tabs">
			<li class="tab-red" data-val="3">已下线 </li>
			<li class="active" data-val="2">已上线</li>
			
		</ul>
		<div class="tab-content">
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">产品编号：</span>
						<span ><input class="search-input" type="text" placeholder="产品编号" name="code" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">产品标题：</span>
						<span ><input class="search-input" type="text" placeholder="产品标题" name="linename" /></span>
					</li>
					<li class="search-list" >
						<span class="search-title">上线时间：</span>
						<span>
							<input class="search-input" style="width:110px;" type="text" placeholder="开始时间" id="starttime" name="starttime" />
							<input class="search-input" style="width:110px;" type="text" placeholder="结束时间" id="endtime" name="endtime" />
						</span>
					</li>
					<li class="search-list" id="line-time">
						<span class="search-title search-tile">更新时间：</span>
						<span>
							<input class="search-input" style="width:110px;" type="text" placeholder="开始时间" id="stime" name="stime" />
							<input class="search-input" style="width:110px;" type="text" placeholder="结束时间" id="etime" name="etime" />
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">出发城市：</span>
						<span ><input class="search-input" type="text" placeholder="出发城市" id="startcity" name="startcity" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">供应商：</span>
						<span ><input class="search-input" type="text" placeholder="供应商" id="company_name" name="supplier" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">目的地：</span>
						<span ><input class="search-input" type="text" placeholder="目的地" id="destinations" name="kindname" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">审核人：</span>
						<span >
							<input class="search-input" type="text" placeholder="审核人" readonly="readonly" id="choice-admin" />
							<input class="search-input" type="hidden" name="admin_id"/>
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">所属板块：</span>
						<select name="typeId">
						<option value="">全部</option>
						 <?php if(!empty($plate)): ?>
						     <?php foreach ($plate as $k=>$v):?>
						       <option value="<?php echo $v['typeId'];?>"><?php echo $v['typeName'];?></option>
						     <?php endforeach;?>
						 <?php endif;?>
						  
						</select>
					</li>
					<li class="search-list">
						<input type="hidden" value="1" name="status">
						<input type="submit" value="搜索" class="search-button" />
					
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div class="form-box fb-body line-refuse">
	<div class="fb-content">
		<div class="box-title">
			<h4>退回线路申请</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" style="float:none" id="refuseForm" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">退回原因：<i>*</i></div>
					<div class="fg-input"><textarea name="refuse_remark" ></textarea></div>
				</div>
				<div class="form-group">
					<input type="hidden" name="refuse_id">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<div class="form-box fb-body line-through">
	<div class="fb-content">
		<div class="box-title">
			<h4>通过线路申请</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" style="float:none" id="throughForm" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">管家佣金：</div>
					<div class="fg-input"><input type="text" name="agent_rate" style="width: 80%;margin-right: 5px;" />元/人份</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="through_id">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<div class="form-box fb-body line-disabled">
	<div class="fb-content">
		<div class="box-title">
			<h4>下线线路</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" style="float: none;" id="disabledForm" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">下线原因：<i>*</i></div>
					<div class="fg-input"><textarea name="reason" ></textarea></div>
				</div>
				<div class="form-group">
					<input type="hidden" name="disabled_id">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<div class="form-box fb-body admin-box">
	<div class="fb-content">
		<div class="box-title">
			<h4>选择审核人</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="admin-submit" style="float:none;" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">审核人：<i>*</i></div>
					<div class="fg-input">
						<ul>
							<?php 
								foreach($admin as $v) {
									echo '<li><label><input type="checkbox" data-name="'.$v['realname'].'" name="admin" class="fg-radio" value="'.$v['id'].'" />'.$v['realname'].'</label></li>';
								}
							?>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>


<div id="evaluateButton" style="display: none; width: 600px;">
	<!-- 此处放编辑内容 -->
	<div class="eject_big">
		<div class="eject_back clear" style="height: auto;">
		<form class="form-horizontal" role="form" method="post" id="evaluateForm" onsubmit="return Checkevaluate();" action="<?php echo base_url();?>admin/a/sale/line/edit">
			<div class="eject_title fl" style="padding:0 5px;font-weight:normal;">
				<p class="comment_line">编辑线路:</p>
				<span class="layui-layer-setwin">
		            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
		        </span>
			</div>
            <div class="eject-content_left fl">
				<div class="eject_content_left_s">
					<div class="eject_input_Slide">
						<label>名称：<input type="text" name="linename" style="width:88%;" /></label>
					</div>
				</div>
			</div>
			<div class="eject-content_left fl">
				<div class="eject_content_left_s">
					<div class="eject_input_Slide">
						<label>排序：<input type="text" name="sort" /><input type="hidden" name="lineid" /></label>
					</div>
				</div>
			</div>
			
			
			<div class="eject-content_left fl">
				<div class="eject_content_left_s">
					<div class="eject_input_Slide">
						<label>所属版块：
						<select name="typeId" id="plate_select">
						<?php if(!empty($plate)):?>
						<?php foreach ($plate as $k=>$v):?>
						 <option value="<?php echo $v['typeId'];?>"><?php echo $v['typeName'];?></option>
						 <?php endforeach;?>
						 <?php endif;?>
						</select>
						</label>
					</div>
				</div>
			</div>
			<div class="eject-content_left fl">
				<div class="eject_content_left_s">
					<div class="eject_input_Slide">
					<label><span style="float:left;">排序：</span>
					
					 <input name="single_water" id="single_water" onchange="uploadImgFile(this)" type="file" style="float: left;margin:4px auto;">
                     <input name="line_pic" type="hidden" id="line_pic" />
                     <img id="show_pic" width="80" />
					</label>
						
					</div>
				</div>
			</div>

			<div class="eject_content2 fl">
				<div class="eject_content_left-x clear">
					
					<div class="eject_button fl" style="padding-bottom: 2px;">
						<input type="hidden" name="score1">
						<input type="hidden" name="score2">
						<input type="hidden" name="score3">
						<input type="hidden" name="score4">
						<input type="hidden" name="lineId" /> 
						<input type="submit" name="submit" value="保存" style="margin-left:180px;padding:0 10px;" class="commit" />
					</div>
				</div>
			</div>
			</form>		
		</div>
	</div>
</div>

<div id="div_offline" style="display: none; width: 600px;">
	<!-- 下线原因 -->
	<div class="eject_big">
		<div class="eject_back clear" style="height: auto;">
		<form class="form-horizontal" role="form" method="post" id="offline_form" action="<?php echo base_url();?>admin/a/sale/line/line_Off">
			<div class="eject_title fl" style="padding:0 5px;font-weight:normal;">
				<p class="comment_line">下线</p>
				<span class="layui-layer-setwin">
		            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
		        </span>
			</div>
            <div class="eject-content_left fl">
				<div class="eject_content_left_s">
					<div class="eject_input_Slide">
						<label style="text-align: left;">原因：<textarea rows="80" cols="30" name="off_reason" id="off_reason"></textarea></label>
					</div>
				</div>
			</div>
			

			<div class="eject_content2 fl">
				<div class="eject_content_left-x clear">
					
					<div class="eject_button fl" style="padding-bottom: 2px;">
						
						<input type="hidden" name="lineid" /> 
						<input type="submit" name="submit" value="确定" style="margin-left:180px;padding:0 10px;" class="commit" />
					</div>
				</div>
			</div>
			</form>		
		</div>
	</div>
</div>

<div class="fb-content" id="vr-info" style="display:none;">
    <div class="box-title">
        <h4>收藏虚拟值修改</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="vr-form" class="form-horizontal" style="float:none;">
            <div class="form-group">
                <div class="fg-title">虚拟值：<i>*</i></div>
                <div class="fg-input">
                	<input type="text" name="vr_num" >
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>


<script src="<?php echo base_url('static'); ?>/js/diyUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>

<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>

//上传图片
function uploadImgFile(obj)
{
	var inputname = $(obj).attr("name");
	var hiddenObj = $(obj).nextAll("input[type='hidden']");

	var formData = new FormData($("#evaluateForm" )[0]);
	formData.append("inputname", inputname);
	$.ajax({
			type : "post",
			url : "/admin/a/sale/plate/upload_img",
			data : formData,
			dataType:"json",
			async: false,
      		cache: false,
      		contentType: false,
      		processData: false,
			success : function(data) {

				if(data.code=="2000")
				{
					hiddenObj.val(data.imgurl);
					$("#show_pic").hide();
					$(obj).parent().append("<img src='"+data.imgurl+"' width='80' />");
					$(obj).parent().parent().find(".olddiv").hide();
				}
				else
					alert(data.msg);
			},
			error:function(data){
				alert('请求异常');
			}
		});
}
//导出excel表格
$('#export_excel').click(function(){
	$.ajax({
		url:'/admin/a/lines/line/exportExcel',
		data:$('#search-condition').serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				window.location.href=result.msg;
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
})



$('input[name=vr_num]').verifNum();
/******start 评论********/
$('#evaluateForm').submit(function(){
	if($("#evaluateForm input[name=sort]").val()=="") {alert('排序不能为空');return false;}
	$.ajax({
		url:'/admin/a/sale/line/edit',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 0) {
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1},function(){location.reload();});
				
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})
 
function edit(lineid ,obj) {
	$.post("/admin/a/sale/line/getOneData" ,{id:lineid} ,function(data) {
		var data = eval("("+data+")");
		$("#evaluateForm input[name=lineid]").val(data.data.lineId);
		$("#evaluateForm input[name=sort]").val(data.data.sort);
		$("#evaluateForm input[name=linename]").val(data.data.lineName);
		$("#evaluateForm input[name=line_pic]").val(data.data.pic);
		var bangu_url="<?php echo BANGU_URL;?>";
		$("#evaluateForm #show_pic").attr("src",bangu_url+data.data.pic).show();
		
		
		$("#plate_select option[value="+data.data.typeId+"]").attr("selected","selected");
		$('.comment_line').html('编辑线路：'+$(obj).attr('data-name'));
		layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '600px',
			  shadeClose: false,
			  content: $('#evaluateButton')
		});
	})
	
	
}
$(".content,.expert_comment").keyup(function(){
	var thisMum=$(this).val().length;
	$(this).siblings(".font_num_title").find("span").html(200-thisMum);
	if(thisMum>=200){
		$("font_num_title span").html("0")	
	}
});

var degree = {0:'失望' ,1:'不满' ,2:'一般' ,3:'满意' ,4:'惊喜'};
$(".score0 li,.score1 li,.score2 li,.score3 li").hover(function(){
	var index = $(this).index();
	
	if (typeof degree[index] != 'undefined') {
		$(this).parent().siblings("a").show().html(degree[index]);
	}
	$(this).addClass('hove').prevAll().addClass('hove');
	
},function(){
	$(this).parent().siblings("a").hide();
	$(this).parent().find('li').removeClass('hove');
	var length = $(this).parent().find('.s_hove').length;
	if (length) {
		$(this).parent().find('.s_hove').addClass('hove');
		$(this).parent().siblings("a").show().html(degree[length-1]);
	}
});

$(".score0 li,.score1 li,.score2 li,.score3 li").click(function(){
	var index = $(this).index();
	if (typeof degree[index] == 'undefind') {
		$(this).parent().siblings("a").show().html(degree[index]);
	}
	$(this).parent().find('li').removeClass('hove s_hove');
	$(this).addClass('hove s_hove').prevAll().addClass('hove s_hove');
	
	//产品满意度
	var sco_mun=$(".score0,.score1,.score2,.score3").find(".hove").length;
	var mun= sco_mun*5;
	var fen= (sco_mun/4).toFixed(1);

	$(".title_info_txt1").show().find("span").find("i").html(mun);
	$(".title_info_txt2").show().find("span").find("i").html(fen);
});
var img_arr='';
$('#as2').diyUpload({
	url:"<?php echo base_url('line/line_detail/upfile')?>",
	success:function( data ) {
		console.log(data.url);
		if (data.status == 1 && typeof data.url != 'undefined') {
			img_arr=img_arr+'<input type="hidden" name="img[]" value="'+data.url+'" />';
			$('.pic_comment').html(img_arr);
		}
	},
	error:function( err ) {
		console.info( err );
	},
	buttonText : '<div class="img_num" style="border:1px solid #ff6600; background:#fff; color:#000; border-radius:3px; height:24px; line-heighr:24px; width:100px;color:#666;">上传图片<span></span></div>',
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:5,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:50000 * 1024,
	accept: {}
});
/*****end 评论********/

/*function see_detail(id){
	layer.open({
		title:'线路详情',
		type: 2,
		area: ['1000px', '90%'],
		fix: false, //不固定
		maxmin: true,
		content: "<?php //echo base_url('admin/a/lines/line/detail');?>"+"?id="+id+"&type=1"
	});
}*/

//审核中(已下线)
var columns3 = [ {field : 'linecode',title : '产品编号',width : '60',align : 'center'},
		{field : null,title : '产品标题',width : '200',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="show_line_detail('+item.line_id+',3)" >'+item.linename+'</a>';
			}
		},
		{field : 'cityname',title : '出发地',width : '100',align : 'center'},
		{field : 'online_time',title : '上线时间',width : '110',align : 'center'},
		{field : 'modtime',title : '更新时间',width : '115',align : 'center'},
		{field : 'linkman',title : '录入人',width : '80',align : 'center'},
		{field : 'company_name',title : '供应商',align : 'center', width : '140'},
		{field : 'typeName',title : '所属板块',width : '115',align : 'left'},
		{field : 'sort',title : '排序',width : '115',align : 'left'},
		{field : 'off_reason',title : '下线原因',width : '115',align : 'left'},
		{field : null,title : '操作',align : 'center', width : '110',formatter: function(item){
			var button = '<a href="javascript:void(0)" data-name="'+item.linename+'" onclick="edit('+item.line_id+' ,this)" class="tab-button but-blue">编辑</a>';
			button += '<a href="javascript:void(0)" onclick="line_on('+item.line_id+' ,this)" class="tab-button but-blue">上线</a>';
			return button;
		}
	}];
//已审核
var columns2 = [ {field : 'linecode',title : '产品编号',width : '60',align : 'center'},
		{field : null,title : '产品标题',width : '200',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);"  onclick="show_line_detail('+item.line_id+',3)" >'+item.linename+'</a>';
			}
		},
		{field : 'cityname',title : '出发地',width : '100',align : 'center'},
		{field : 'online_time',title : '上线时间',width : '110',align : 'center'},
		
		{field : 'linkman',title : '录入人',width : '80',align : 'center'},
		{field : 'company_name',title : '供应商',align : 'center', width : '140'},
		{field : 'username',title : '产品审核人',align : 'center', width : '100'},
		{field : 'typeName',title : '所属板块',width : '115',align : 'left'},
		{field : 'sort',title : '排序',width : '115',align : 'left'},
		{field : null,title : '操作',align : 'center', width : '80',formatter: function(item){
			var button = '<a href="javascript:void(0)" data-name="'+item.linename+'" onclick="edit('+item.line_id+' ,this)" class="tab-button but-blue">编辑</a>';
			button=button+'<a href="javascript:void(0)" data-name="'+item.linename+'"  onclick="set_SalesExpert('+item.line_id+' ,this)" class="tab-button but-blue">设置售卖管家</a>';
			button += '<a href="javascript:void(0)" onclick="line_off('+item.line_id+' ,this)" class="tab-button but-blue">下线</a>';
			return button;
		}
	}];
//已拒绝
var columns1 = [ {field : 'linecode',title : '产品编号',width : '60',align : 'center'},
		{field : null,title : '产品标题',width : '200',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="show_line_detail('+item.line_id+',2)">'+item.linename+'</a>';
			}
		},
		{field : 'cityname',title : '出发地',width : '100',align : 'center'},
		{field : 'online_time',title : '上线时间',width : '110',align : 'center'},
		{field : 'modtime',title : '更新时间',width : '115',align : 'left'},
		{field : 'linkman',title : '录入人',width : '80',align : 'center'},
		{field : 'company_name',title : '供应商',align : 'center', width : '140'},
		{field : 'username',title : '产品审核人',align : 'center', width : '100'}];
//已下线
var columns4 = [ {field : 'linecode',title : '产品编号',width : '60',align : 'center'},
		{field : null,title : '产品标题',width : '200',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="show_line_detail('+item.line_id+',2)">'+item.linename+'</a>';
			}
		},
		{field : 'cityname',title : '出发地',width : '100',align : 'center'},
		{field : 'online_time',title : '上线时间',width : '110',align : 'center'},
		{field : 'modtime',title : '更新时间',width : '115',align : 'left'},
		{field : 'linkman',title : '录入人',width : '80',align : 'center'},
		{field : 'company_name',title : '供应商',align : 'center', width : '140'},
		{field : 'username',title : '产品审核人',align : 'center', width : '100'},
		{field : null,title : '操作',align : 'center', width : '80',formatter: function(item){
				return '<a href="javascript:void(0)" onclick="stop('+item.line_id+')" class="tab-button but-red">停售</a>';
			}
		}];

//已停售
var columns5 = [ {field : 'linecode',title : '产品编号',width : '60',align : 'center'},
		{field : null,title : '产品标题',width : '200',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="show_line_detail('+item.line_id+',2)" >'+item.linename+'</a>';
			}
		},
		{field : 'cityname',title : '出发地',width : '100',align : 'center'},
		{field : 'modtime',title : '更新时间',width : '115',align : 'left'},
		{field : 'online_time',title : '上线时间',width : '110',align : 'center'},
		{field : 'linkman',title : '录入人',width : '90',align : 'center'},
		{field : 'company_name',title : '供应商',align : 'center', width : '140'},
		{field : 'username',title : '产品审核人',align : 'center', width : '100'}];

var formObj = $('#search-condition');
$(document).ready(function(){

            formObj.find('input[name=status]').val('2');
			$("#dataTable").pageTable({
				columns:columns2,
				url:'/admin/a/sale/line/getLineData',
				pageNumNow:1,
				searchForm:'#search-condition',
				tableClass:'table-data'
			});

			$('.nav-tabs li').click(function(){
				$(this).addClass('active').siblings().removeClass('active');
				var status = $(this).attr('data-val');
				formObj.find('input[type=text]').val('');
				formObj.find('select').val(0);
				formObj.find('input[type=hidden]').val('');
				formObj.find('input[name=status]').val(status);
				$('.search-tile').html('更新时间：');
				if (status == 1) {
					var columns = columns1;
				} else if (status == 2) {
					$('.search-tile').html('审核时间：');
					var columns = columns2;
				} else if (status == 3) {
					var columns = columns3;
				} else if (status == 4) {
					var columns = columns4;
				} else if (status == 5) {
					var columns = columns5;
				}
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/sale/line/getLineData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				$('.admin-box').find('input[name=admin]:checked').each(function(){
					$(this).attr('checked' ,false);
				})
			})
	})


//退回线路申请
var refuseObj = $('.line-refuse');
function refuse(lineid) {
	refuseObj.find('textarea[name=refuse_remark]').val('');
	refuseObj.find('input[name=refuse_id]').val(lineid);
	$('.line-refuse,.mask-box').fadeIn(500);
}
$('#refuseForm').submit(function(){
	$.ajax({
		url:'/admin/a/lines/line/refuse',
		type:'post',
		data:{lineid:refuseObj.find('input[name=refuse_id]').val(),refuse_remark:refuseObj.find('textarea[name=refuse_remark]').val()},
		dataType:'json',
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/lines/line/getLineData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				closebox();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})
//通过线路申请
var throughObj = $('#throughForm');
function through(lineid) {
	if (confirm('您确定要通过？')) {
		$.ajax({
			url:'/admin/a/lines/line/through',
			type:'post',
			data:{lineid:lineid},
			dataType:'json',
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns1,
						url:'/admin/a/lines/line/getLineData',
						pageNumNow:1,
						searchForm:'#search-condition',
						tableClass:'table-data'
					});
					closebox();
				} else {
					alert(data.msg);
				}
			}
		});
		return false;
	}
}

//下线
function line_off(lineid) {
	/* if (confirm('您确定要下线该线路？')) {
		$.ajax({
			url:'/admin/a/sale/line/line_off',
			type:'post',
			data:{lineid:lineid},
			dataType:'json',
			success:function(data) {
				if (data.code == 0) {
				
					window.location.reload()
				} else {
					alert(data.msg);
				}
			}
		});
		return false;
	} */

	
	$.post("/admin/a/sale/line/getOneData" ,{id:lineid} ,function(data) {
		var data = eval("("+data+")");
		$("#div_offline input[name=lineid]").val(data.data.lineId);
		$('.comment_line').html('产品下线');
		layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '600px',
			  shadeClose: false,
			  content: $('#div_offline')
		});
	})
	
}
$('#offline_form').submit(function(){
	var lineid=$("#offline_form input[name=lineid]").val();
	var reason=$("#offline_form #off_reason").val();
	
	$.ajax({
		url:'/admin/a/sale/line/line_off',
		type:'post',
		data:{lineid:lineid,off_reason:reason},
		dataType:'json',
		success:function(data) {
			if (data.code == 0) {
				alert(data.msg);
				setTimeout(function(){window.location.reload();},500);
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})

//上线
function line_on(lineid) {
	if (confirm('您确定要上线该线路？')) {
		$.ajax({
			url:'/admin/a/sale/line/line_on',
			type:'post',
			data:{lineid:lineid},
			dataType:'json',
			success:function(data) {
				
				if (data.code == 0) {
					$("#dataTable").pageTable({
						columns:columns3,
						url:'/admin/a/sale/line/getLineData',
						pageNumNow:1,
						searchForm:'#search-condition',
						tableClass:'table-data'
					});
				} else {
					alert(data.msg);
				}
			}
		});
		return false;
	}
}

//下线线路
var disabledObj = $('#disabledForm');
function disabled(lineid) {
	disabledObj.find('input[name=disabled_id]').val(lineid);
	disabledObj.find('textarea[name=reason]').val('');
	$('.line-disabled,.mask-box').fadeIn(500);
}
disabledObj.submit(function(){
	$.ajax({
		url:'/admin/a/lines/line/disable',
		type:'post',
		data:{lineid:disabledObj.find('input[name=disabled_id]').val(),reason:disabledObj.find('textarea[name=reason]').val()},
		dataType:'json',
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns2,
					url:'/admin/a/lines/line/getLineData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				closebox();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})

function stop(lineid) {
	if (confirm('您确定停售此线路?')) {
		$.ajax({
			url:'/admin/a/lines/line/stopsale',
			type:'post',
			data:{lineid:lineid},
			dataType:'json',
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns4,
						url:'/admin/a/lines/line/getLineData',
						pageNumNow:1,
						searchForm:'#search-condition',
						tableClass:'table-data'
					});
				} else {
					alert(data.msg);
				}
			}
		});
	}
}
$('#choice-admin').click(function(){
	$('.admin-box,.mask-box').show();
})
$('#admin-submit').submit(function(){
	var ids = '';
	var name = '';
	$(this).find('input[name=admin]:checked').each(function(){
		ids += $(this).val()+',';
		name += $(this).attr('data-name')+' ';
	})
	formObj.find('input[name=admin_id]').val(ids);
	$('#choice-admin').val(name);
	$('.admin-box,.mask-box').hide();
	return false;
})

//修改收藏虚拟值
function vr_num(id ,num) {
	$('#vr-form').find('input[name=id]').val(id);
	num = typeof num == 'object' ? 0 : num;
	$('#vr-form').find('input[name=vr_num]').val(num);
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#vr-info')
	});
}
$('#vr-form').submit(function(){
	$.ajax({
		url:'/admin/a/lines/line/vr_num',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
// 				var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
// 				$("#dataTable").pageTable({
// 					columns:columns2,
// 					url:'/admin/a/lines/line/getLineData',
// 					pageSize:10,
// 					pageNumNow:pageNow,
// 					searchForm:'#search-condition',
// 					tableClass:'table table-bordered table_hover'
// 				});
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})


//目的地
$.post('/admin/a/comboBox/get_destinations_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.kindname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#destinations",
	    name : "destid",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
//出发城市
$.post('/admin/a/comboBox/get_startcity_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.cityname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#startcity",
	    name : "startcity_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
//商家名字
$.post('/admin/a/comboBox/get_supplier_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.company_name,
		    value : val.id,
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#company_name",
	    name : "supplier_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#stime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#etime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});

//设置售卖管家
function set_SalesExpert(lineId,obj){

	window.top.openWin({
		  type: 2,
		  area: ['700px', '350px'],
		  title :'编辑售卖管家',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/sale/line/get_lineExpert');?>?line_id="+lineId,
	});
	
}



</script>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

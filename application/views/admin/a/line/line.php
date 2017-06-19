<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('static'); ?>/css/plugins/diyUpload.css" rel="stylesheet" type="text/css" />
<style>

.eject_title .comment_line{ height:40px; line-height:40px;}
.eject_content{ float:left;}
i{ font-style: normal;}
.eject_input_Slide, .eject_input_Slide textarea{ width:636px;}
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
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>线路审核</li>
	</ul>
	<div class="page-body">
		<ul class="nav-tabs">
			<li class="active" data-val="1">审核中 </li>
			<li class="tab-red" data-val="2">已上线</li>
			<li class="tab-blue" data-val="3">已拒绝</li>
			<li class="tab-blue" data-val="4">已下线</li>
			<li class="tab-blue" data-val="5">已停售</li>
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
							<input class="search-input" style="width:83px;" type="text" placeholder="开始时间" id="starttime" name="starttime" />
							<input class="search-input" style="width:83px;" type="text" placeholder="结束时间" id="endtime" name="endtime" />
						</span>
					</li>
					<li class="search-list" id="line-time">
						<span class="search-title search-tile">更新时间：</span>
						<span>
							<input class="search-input" style="width:83px;" type="text" placeholder="开始时间" id="stime" name="stime" />
							<input class="search-input" style="width:83px;" type="text" placeholder="结束时间" id="etime" name="etime" />
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">出发城市：</span>
						<span >
							<input class="search-input" type="text" onclick="showStartplaceTree(this)" placeholder="出发城市" id="startcity" name="startcity" />
							<input type="hidden" name="startcity_id" />
						</span>
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
							<input class="search-input" name="admin_name" id="admin_name" type="text" placeholder="审核人"  />
							<!-- <input class="search-input" type="text" placeholder="审核人"  id="choice-admin" />
							<input class="search-input" type="hidden" name="admin_id"/> -->
						</span>
					</li>
					<li class="search-list">
						<input type="hidden" value="1" name="status">
						<input type="submit" value="搜索" class="search-button" />
						<input type="button" value="导出" id="export_excel" class="search-button" />
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
	<div class="fb-content" style="max-height: 500px;width: 700px;overflow-y: auto;">
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
					<div class="fg-title">t33联盟系统:</div><br>
						<div class="fg-input">
							<ul>
							<?php  if(!empty($union)){
								foreach ($union as $k=>$v){ 
								 	 if(!empty($v['employee'])){
								 	 	foreach ($v['employee'] as $k=>$v){
								 	 		echo '<li><label><input type="checkbox" data-name="'.$v['realname'].'" name="admin" class="fg-radio" value="'.$v['em_id'].'" />'.$v['realname'].'</label></li>';
								 	 	}
								 	 }
							 } } ?>
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


<div id="evaluateButton" style="display: none; width: 720px;">
	<!-- 此处放编辑内容 -->
	<div class="eject_big">
		<div class="eject_back clear" style="height: auto;">
		<form class="form-horizontal" role="form" method="post" id="evaluateForm" onsubmit="return Checkevaluate();" action="<?php echo base_url();?>base/member/add_comment">
			<div class="eject_title fl">
				<p class="comment_line">评价线路:</p>
				<span class="layui-layer-setwin">
		            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
		        </span>
			</div>
            <div class="olumn">评价产品</div>
			<div class="eject_content fl">
				<div class="eject_content_right fl">
					<div class="eject_right_one">
						<div class="eject_xx_box">
							<span>导游服务:</span>
							<ul class="score0">
								<li></li>
								<li></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
							<a></a>
						</div>
					</div>
					<div class="eject_right_one">
						<div class="eject_xx_box">
							<span>行程安排:</span>
							<ul class="score1">
								<li></li>
								<li></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
							<a></a>
						</div>
					</div>
					<div class="eject_right_one">
						<div class="eject_xx_box">
							<span>餐饮住宿:</span>
							<ul class="score2">
								<li></li>
								<li></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
							<a></a>
						</div>
					</div>
					<div class="eject_right_one">
						<div class="eject_xx_box">
							<span>旅游交通:</span>
							<ul class="score3">
								<li></li>
								<li></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
							<a></a>
						</div>
					</div>
					<div class="title_info_txt title_info_txt1">
						<span>产品满意度:&nbsp;<i style=" color:#f00;">0</i>&nbsp;%</span>
					</div>
                    <div class="title_info_txt title_info_txt2">
						<span>产品平均分:&nbsp;<i style=" color:#f00;">0</i>&nbsp;分</span>
					</div>
				</div>
			</div>
			<div class="eject-content_left fl">
				<div class="eject_content_left_s">
					<div class="eject_input_Slide">
						<textarea name="content" class="content" id="content" maxlength="200" placeholder="评论内容"></textarea>
						<span class="font_num_title"><span>200</span><i>/200</i></span>
					</div>
				</div>
			</div>

			<div class="eject_content2 fl">
				<div class="eject_content_left-x clear">
					<div class="show_img fl">
						<p>以图为证</p>
						<div id="demo">
							<div id="as2" class="webuploader-container"></div>
						</div>
					</div>     
					<div class="grades"></div>
					<div class="pic_comment"></div>
					<div class="eject_button fl" style="padding-bottom: 2px;">
						<input type="hidden" name="score1">
						<input type="hidden" name="score2">
						<input type="hidden" name="score3">
						<input type="hidden" name="score4">
						<input type="hidden" name="lineId" /> 
						<input type="submit" name="submit" value="提交评价" class="commit" />
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
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>

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
	if (!$('.score0').find('.s_hove').length) {
		layer.alert('请对导游服务评分', {icon: 2});
		return false;
	}
	if (!$('.score1').find('.s_hove').length) {
		layer.alert('请对行程安排评分', {icon: 2});
		return false;
	}
	if (!$('.score2').find('.s_hove').length) {
		layer.alert('请对餐饮住宿评分', {icon: 2});
		return false;
	}
	if (!$('.score3').find('.s_hove').length) {
		layer.alert('请对旅游交通评分', {icon: 2});
		return false;
	}
	$(this).find('input[name=score1]').val($('.score0').find('.s_hove').length);
	$(this).find('input[name=score2]').val($('.score1').find('.s_hove').length);
	$(this).find('input[name=score3]').val($('.score2').find('.s_hove').length);
	$(this).find('input[name=score4]').val($('.score3').find('.s_hove').length);
	$.ajax({
		url:'/admin/a/lines/line/insertComment',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})
 
function comment(lineid ,obj) {
	var comObj = $('#evaluateForm');
	comObj.find('textarea').val('');
	comObj.find('input[type="hidden"]').val('');
	comObj.find('.pic_comment').empty();
	$(".title_info_txt1").show().find("span").find("i").html(0);
	$(".title_info_txt2").show().find("span").find("i").html(0);
	$(".score0,.score1,.score2,.score3").find('li').removeClass('hove s_hove');
	$(".score0,.score1,.score2,.score3").next('a').hide();
	comObj.find('input[name=lineId]').val(lineid);
	$('.comment_line').html('评价线路：'+$(obj).attr('data-name'));
	
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '720px',
		  shadeClose: false,
		  content: $('#evaluateButton')
	});
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

//审核中
var columns1 = [ {field : 'linecode',title : '产品编号',width : '60',align : 'center'},
		{field : null,title : '产品标题',width : '200',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="show_line_detail('+item.line_id+',2)" >'+item.linename+'</a>';
			}
		},
		{field : 'cityname',title : '出发地',width : '100',align : 'center'},
		{field : 'online_time',title : '上线时间',width : '110',align : 'center'},
		{field : 'modtime',title : '更新时间',width : '115',align : 'center'},
		{field : 'linkman',title : '录入人',width : '80',align : 'center'},
		{field : 'company_name',title : '供应商',align : 'center', width : '140'},
		{field : null,title : '操作',align : 'center', width : '110',formatter: function(item){
			var button = "<a href='javascript:void(0)' onclick='through("+item.line_id+" ,"+item.agent_rate_int+")' class='tab-button but-blue'> 通过</a>&nbsp;";
			button += '<a href="javascript:void(0)" onclick="refuse('+item.line_id+')" class="tab-button but-red"> 退回</a>&nbsp;';
			var destArr = item.overcity.split(',');
                        // 将gn改为line,cj改为line,添加后缀.html
			// var url = $.inArray(1 ,destArr) == -1 ? '/gn/'+item.line_id : '/cj/'+item.line_id;
                        var url = $.inArray(1 ,destArr) == -1 ? '/line/'+item.line_id + '.html' : '/line/'+item.line_id + '.html';
			button += '<a href="'+url+'"  target=_blank class="tab-button but-blue"> 预览</a>&nbsp;';
			return button;
		}
	}];
//已审核
var columns2 = [ {field : 'linecode',title : '产品编号',width : '60',align : 'center'},
		{field : null,title : '产品标题',width : '200',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);"  onclick="show_line_detail('+item.line_id+',2)" >'+item.linename+'</a>';
			}
		},
		{field : 'cityname',title : '出发地',width : '100',align : 'center'},
		{field : 'online_time',title : '上线时间',width : '110',align : 'center'},
		{field : 'confirm_time',title : '审核时间',width : '115',align : 'left'},
		{field : 'linkman',title : '录入人',width : '80',align : 'center'},
		{field : 'company_name',title : '供应商',align : 'center', width : '140'},
		{field :null,title : '产品审核人',align : 'center', width : '100',formatter:function(item){
			  if(item.username!=''&& item.username!=null){
				  return item.username;
			  }else{
				 if(item.employee_name!=null){
					 return item.employee_name;
				 }else{
					 return '';	 
				 }
			  }
			}		
		},
		{field : null,title : '操作',align : 'center', width : '80',formatter: function(item){
			var button = '<a href="javascript:void(0)" data-name="'+item.linename+'" onclick="comment('+item.line_id+' ,this)" class="tab-button but-blue"> 评论</a>';
			button += '<a href="javascript:void(0)" onclick="disabled('+item.line_id+')" class="tab-button but-red">下线</a>&nbsp;';
			button += '<a href="javascript:void(0)" onclick="vr_num('+item.line_id+' ,'+item.collect_num_vr+')" class="tab-button but-red">收藏虚拟值</a>';
			return button;
		}
	}];
//已拒绝
var columns3 = [ {field : 'linecode',title : '产品编号',width : '60',align : 'center'},
		{field : null,title : '产品标题',width : '200',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="show_line_detail('+item.line_id+',2)">'+item.linename+'</a>';
			}
		},
		{field : 'cityname',title : '出发地',width : '100',align : 'center'},
		{field : 'online_time',title : '上线时间',width : '110',align : 'center'},
		{field : 'modtime',title : '更新时间',width : '115',align : 'left'},
		{field : 'linkman',title : '录入人',width : '80',align : 'center'},
		{field : 'company_name',title : '供应商',align : 'center', width : '140'},
		{field : 'username',title : '产品审核人',align : 'center', width : '100',

			formatter:function(item){
				  if(item.username!=''&& item.username!=null){
					  return item.username;
				  }else{
					 if(item.employee_name!=null){
						 return item.employee_name;
					 }else{
						 return '';	 
					 }
				  }
			}		
		}];
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
// $("#dataTable").pageTable({
// 	columns:columns1,
// 	url:'/admin/a/lines/line/getLineData',
// 	pageNumNow:1,
// 	searchForm:'#search-condition',
// 	tableClass:'table-data'
// });

getData(1);
function getData(page) {
	var status = $('#search-condition').find('input[name=status]').val();
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
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
		url:'/admin/a/lines/line/getLineData',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table-data'
	});
}

var formObj = $('#search-condition');
$('.nav-tabs li').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	var status = $(this).attr('data-val');
	formObj.find('input[type=text]').val('');
	formObj.find('select').val(0);
	formObj.find('input[type=hidden]').val('');
	formObj.find('input[name=status]').val(status);
	$('.search-tile').html('更新时间：');
	
	getData(1);
	$('.admin-box').find('input[name=admin]:checked').each(function(){
		$(this).attr('checked' ,false);
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
				getData();
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
					getData();
					closebox();
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
// 	var comboBox = new jQuery.comboBox({
// 	    id : "#startcity",
// 	    name : "startcity_id",// 隐藏的value ID字段
// 	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
// 	    selectedAfter : function(item, index) {// 选择后的事件

// 	    },
// 	    data : array
// 	});
})

//审核人
$.post('/admin/a/lines/line/get_admin_user?type=1', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.realname,
		    value : val.id,
		    jb : '',
		    qp :''
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#admin_name",
	    name : "adminid",// 隐藏的value ID字段
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
</script>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>
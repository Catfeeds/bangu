<link rel="stylesheet" href="/file/common/plugins/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/file/common/plugins/kindeditor/plugins/code/prettify.css" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">秒杀商品管理</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/activity_seckill/getDataList')?>" id='search_condition' class="search_condition_form" method="post">
		
			<ul>
				<li class="search-list">
					<span class="search-title">产品名称：</span>
					<span >
						<input class="search_input user_name_b1" type="text" name="goods_name">
					</span>
					
					<span class="search-title">状态：</span>
					<span >
						<select name="status" style="width:110px">
							<option value="">请选择...</option>
							<option value="1">上架</option>							
							<option value="2">下架</option>
						</select>
					</span>					
					<span >
						<input type="submit" value="搜索" class="search-button" />
					</span>	
				</li>
			</ul>
		
		</form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">秒杀商品管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">商品名称<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" id="seckill_goods_name"  name="seckill_goods_name" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">原始价格<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" id="seckill_goods_price"  name="seckill_goods_price" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">秒杀价格<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" id="seckill_price"  name="seckill_price" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">商品库存<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" id="seckill_goods_storage"  name="seckill_goods_storage" type="text">
						</div>
					</div>	

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">虚假库存<span class="input-must"></span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" id="seckill_goods_vrstorage"  name="seckill_goods_vrstorage" type="text">
							设置了该值，则该产品不能被秒杀，默认为0表示关闭该功能
						</div>
					</div>						
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">相关线路id<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" id="seckill_goods_line_id"  name="seckill_goods_line_id" type="text">
						</div>
					</div>					
					
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">秒杀开始时间<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input type="text" id="starttime"  class="search-input" style="width:150px;" name="starttime" placeholder="开始日期" />
						</div>
					</div>						
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">秒杀结束时间<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input type="text" id="endtime"  class="search-input" style="width:150px;" name="endtime" placeholder="结束日期" />
						</div>
					</div>						
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">兑换结束时间<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input type="text" id="exchangeendtime"  class="search-input" style="width:150px;"  name="exchangeendtime" placeholder="结束日期" />
						</div>
					</div>					
									
					
					<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">封面图片<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
								<input name="pic" type="hidden" />
							</div>
					</div>

					<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">相册图片1<span class="input-must"></span></label>
							<div class="col-sm-10">
								<input name="uploadFile1" id="uploadFile1" onchange="uploadImgFile(this);" type="file">
								<input name="pic1" type="hidden" />
								<select name="pic_del1" id="pic_del1" style="width:50px;">
									<option value="0" selected="selected">正常</option>							
									<option value="1">删除</option>
								</select>
							</div>
					</div>	

					<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">相册图片2<span class="input-must"></span></label>
							<div class="col-sm-10">
								<input name="uploadFile2" id="uploadFile2" onchange="uploadImgFile(this);" type="file">
								<input name="pic2" type="hidden" />
								<select name="pic_del2" id="pic_del2" style="width:50px;">
									<option value="0" selected="selected">正常</option>							
									<option value="1">删除</option>
								</select>
							</div>
					</div>
					<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">相册图片3<span class="input-must"></span></label>
							<div class="col-sm-10">
								<input name="uploadFile3" id="uploadFile3" onchange="uploadImgFile(this);" type="file">
								<input name="pic3" type="hidden" />
								<select name="pic_del3" id="pic_del3" style="width:50px;">
									<option value="0" selected="selected">正常</option>							
									<option value="1">删除</option>
								</select>
							</div>
					</div>
					<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">相册图片4<span class="input-must"></span></label>
							<div class="col-sm-10">
								<input name="uploadFile4" id="uploadFile4" onchange="uploadImgFile(this);" type="file">
								<input name="pic4" type="hidden" />
								<select name="pic_del4" id="pic_del4" style="width:50px;">
									<option value="0" selected="selected">正常</option>							
									<option value="1">删除</option>
								</select>
							</div>
					</div>
					<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">相册图片5<span class="input-must"></span></label>
							<div class="col-sm-10">
								<input name="uploadFile5" id="uploadFile5" onchange="uploadImgFile(this);" type="file">
								<input name="pic5" type="hidden" />
								<select name="pic_del5" id="pic_del5" style="width:50px;">
									<option value="0" selected="selected">正常</option>							
									<option value="1">删除</option>
								</select>
							</div>
					</div>					
					

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">状态</label>
						<div class="col-sm-10">
							<select name="state" id="state" style="width:100%;">
								<option value="1" selected="selected">正常</option>							
								<option value="0">下架</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">秒杀规则<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<textarea class="form-control" id="seckill_guizhe"  name="seckill_guizhe" style="width:420px;height:100px"></textarea>
						</div>
					</div>					

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">兑换说明<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<textarea class="form-control" id="seckill_duishuo"  name="seckill_duishuo" style="width:420px;height:100px"></textarea>
						</div>
					</div>					

					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">内容</label>
						<!-- <div class="col-sm-10 col_ts">
							<textarea class="form-control" name="article_content" id="article_content"></textarea>
						</div> -->
						<div class="eject_content_list">
						<div class="eject_list_row" style="width:100%;">
							<textarea class="eject_list_name" id="goods_content" name="goods_content" style="width:98%;height:400px;"></textarea>
						</div>
						</div>
					</div>
					
					
					
					
					<div class="form-group">
						<input type="hidden" value="" name="goods_id" id="goods_id">
						<input class="close-button form-button" value="关闭" type="button">
						<input class="form-button" value="提交" type="submit">
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<!-- 编辑器 -->
<script charset="utf-8" src="/file/common/plugins/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/plugins/code/prettify.js"></script>
<script>
var columns = [
{field : 'seckill_goods_id',title : '商品id',width : '100',align : 'center'},
		{field : 'seckill_goods_name',title : '商品名称',width : '100',align : 'center'},
        		{field : false,title : '图片',width : '120',align : 'center',formatter:function(item){
			return "<a href='"+item.seckill_goods_image+"' target='_blank'><img src='"+item.seckill_goods_image+"' width='50px' height='50px'/></a>";
                   	 }
                	},
                	{field : 'seckill_goods_line_id',title : '相关线路id',width : '100',align : 'center'},					
                	{field : 'seckill_goods_price',title : '原始价格',width : '100',align : 'center'},
                	{field : 'seckill_price',title : '秒杀价格',width : '100',align : 'center'},
                	{field : 'seckill_goods_storage',title : '商品库存',width : '100',align : 'center'},
                	{field : 'seckill_goods_vrstorage',title : '虚假库存',width : '100',align : 'center'},					
                	{field : 'start_time',title : '秒杀开始时间',width : '100',align : 'center'},
                	{field : 'end_time',title : '秒杀结束时间',width : '100',align : 'center'},					
                	{field : 'exchange_end_time',title : '兑换结束时间',width : '100',align : 'center'},					
                	{field : false,title : '下架',width : '100',align : 'center',formatter:function(item){
                		if(item.seckill_goods_state==1){
                			return '否';
                		}else{
                			return '是';
                		}
                	}},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.seckill_goods_id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/activity_seckill/getDataList',
	searchForm:'#search_condition',
});

 	//编辑器
KindEditor.ready(function(K){
        window.editor = K.create('#goods_content');
  });

//添加数据弹出
$("#addData").click(function(){
	$("input[name='seckill_goods_name']").val('');
	$("input[name='seckill_goods_price']").val('');
	$("input[name='seckill_price']").val('');	
	$("input[name='seckill_goods_storage']").val('');
	$("input[name='seckill_goods_vrstorage']").val('');	
	$("input[name='seckill_goods_line_id']").val('');	
	$("input[name='starttime']").val('');
	$("input[name='endtime']").val('');	
	$("input[name='exchangeendtime']").val('');
	$("input[name='goods_id']").val('');
	$("select[name='state']").val('');
	
		$("#seckill_guizhe").val('');	
		$("#seckill_duishuo").val('');
	//$("#article_content").val('');
	$("input[name='pic']").val('');
	$(".uploadImg").remove();
	
	$("input[name='pic1']").val('');
	$(".uploadImg1").remove();	
	$("input[name='pic2']").val('');
	$(".uploadImg2").remove();	
	$("input[name='pic3']").val('');
	$(".uploadImg3").remove();	
	$("input[name='pic4']").val('');
	$(".uploadImg4").remove();	
	$("input[name='pic5']").val('');
	$(".uploadImg5").remove();	
	
	$('#goods_content').html('');     //清除编辑内容
	editor.sync();
	editor.html('');
 	$('.eject_body').css('z-index','100')
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='goods_id']").val();
	if (id.length > 0) {
		var url = "/admin/a/activity_seckill/edit";
	} else {
		var url = "/admin/a/activity_seckill/add";
	}
	 editor.sync();
	$.post(url,$(this).serialize(),function(data){
		var data = eval("("+data+")");
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	})
	return false;
})

function edit(id) {
	$.post("/admin/a/activity_seckill/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='goods_id']").val(data.seckill_goods_id);
		$("input[name='seckill_goods_name']").val(data.seckill_goods_name);
		$("input[name='seckill_goods_price']").val(data.seckill_goods_price);
		$("input[name='seckill_price']").val(data.seckill_price);
		$("input[name='seckill_goods_storage']").val(data.seckill_goods_storage);
		$("input[name='seckill_goods_vrstorage']").val(data.seckill_goods_vrstorage);
		$("input[name='seckill_goods_line_id']").val(data.seckill_goods_line_id);		
		$("input[name='pic']").val(data.pic);
		$("input[name='pic1']").val(data.pic1);
		$("input[name='pic2']").val(data.pic2);		
		$("input[name='pic3']").val(data.pic3);		
		$("input[name='pic4']").val(data.pic4);
		$("input[name='pic5']").val(data.pic5);
		
		
		$("input[name='starttime']").val(data.starttime);
		$("input[name='endtime']").val(data.endtime);		
		$("input[name='exchangeendtime']").val(data.exchangeendtime);

		$("select[name='state']").val(data.state);
		$("#seckill_guizhe").val(data.seckill_guizhe);	
		$("#seckill_duishuo").val(data.seckill_duishuo);
	
		$("#goods_content").html(data.goods_content);
		 editor.sync();
		editor.html(data.goods_content);
		$(".uploadImg").remove();
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");

		$(".uploadImg1").remove();
		$("#uploadFile1").after("<img class='uploadImg1' src='" + data.pic1 + "' width='80'>");
		$(".uploadImg2").remove();
		$("#uploadFile2").after("<img class='uploadImg2' src='" + data.pic2 + "' width='80'>");
		$(".uploadImg3").remove();
		$("#uploadFile3").after("<img class='uploadImg3' src='" + data.pic3 + "' width='80'>");
		$(".uploadImg4").remove();
		$("#uploadFile4").after("<img class='uploadImg4' src='" + data.pic4 + "' width='80'>");
		$(".uploadImg5").remove();
		$("#uploadFile5").after("<img class='uploadImg5' src='" + data.pic5 + "' width='80'>");		
		
		$(".bootbox,.modal-backdrop").show();
	});
}
//删除
function del(obj) {
	var id_arr = $(obj).attr('data-val').split('|');
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/activity_seckill/delete",{'article_id':id_arr[0],'article_detail_id':id_arr[1]},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		});
	}
}
$(".close-button").click(function(){
	$(".bootbox,.modal-backdrop").hide();
})

$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d H:i:s', //选中显示的日期格式
	formatDate:'Y-m-d H:i:s',
	validateOnBlur:false,
});

$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d H:i:s', //选中显示的日期格式
	formatDate:'Y-m-d H:i:s',
	validateOnBlur:false,
});

$('#exchangeendtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d H:i:s', //选中显示的日期格式
	formatDate:'Y-m-d H:i:s',
	validateOnBlur:false,
});


</script>

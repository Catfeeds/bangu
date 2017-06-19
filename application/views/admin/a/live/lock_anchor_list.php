<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<style type="text/css">
	.col_span{ float: left;margin-top: 6px}
	.col_ip{ float: left; }
.col-sm-10{width: 76.333%}

</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">封禁名单列表</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->

				
						<div class="widget-header ">
							<span class="widget-caption">封禁名单列表</span>
							<div class="widget-buttons">
								<!-- <a href="#" data-toggle="maximize"> <i class="fa fa-expand"></i>
								</a> <a href="#" data-toggle="collapse"> <i class="fa fa-minus"></i>
								</a> <a href="#" data-toggle="dispose"> <i class="fa fa-times"></i>
								</a> -->
							</div>
						</div>		
		
		
		
		
						<div class="widget-body">
							<div role="grid" id="simpledatatable_wrapper"
								class="dataTables_wrapper form-inline no-footer">
								<div id="simpledatatable_filter" >
									<label>
										<form class="form-inline" role="form"  method="post" action="<?php echo site_url('admin/a/live/lock_anchor/index')?>">
										    <div class="form-group dataTables_filter col_ip" >

										        <input type="text" class="form-control" placeholder="关键字" name="name" value="<?php echo $name;?>">
										    </div>
										    <div class="form-group dataTables_filter col_ip"style="padding-left:15px;" >
												<select name="time" style="width:110px">
													<option value="7">7天</option>
													<option value="30">30天</option>
													<option value="120">120天</option>
													<option value="360">360天</option>
													<option value="0">永久封停</option>
												</select>
										    </div>											
										    <button type="submit" class="btn btn-default" style="float:left;">
										        	搜索
										    </button>
										</form>	
									</label>
								</div>
								<div class="dataTables_length" id="simpledatatable_length">
									<label></label>
								</div>
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="simpledatatable" aria-describedby="simpledatatable_info">
									<thead>
										<tr role="row">
											<th style="text-align:center">账号</th>
											<th style="text-align:center">呢称</th>
											<th style="text-align:center">注册时间</th>											
											<th style="text-align:center" >累计上传视频数</th>
											<th style="text-align:center">下架次数</th>
											<th style="text-align:center" >被举报次数</th>
											<th style="text-align:center" >封号时间</th>											
											<th style="text-align:center" >解禁时间</th>											
											<th style="text-align:center">状态</th>
											<th style="text-align:center">操作</th>
										</tr>
									</thead>
									<tbody>
									<?php $time = time(); foreach ($pageData as $item): ?>
       									 <tr>
           								    <td class="sorting_1" style="text-align:center"><?php echo $item['user_id'];?></td>
           								    <td class=" " style="text-align:center"><?php echo $item['name'];?></td>
            								<td  style="text-align:center"><?php echo $item['addtime']?></td>												
            								<td  style="text-align:center"><?php echo $item['upload_num']?>次</td>
            								<td  style="text-align:center"><?php echo $item['down_num']?>次</td>									 
            								<td  style="text-align:center"><?php echo $item['report_num']?>次</td>
            								<td  style="text-align:center"><?php echo date("Y-m-d H:i:s", $item['lockstime'])?></td>
            								<td  style="text-align:center"><?php echo date("Y-m-d H:i:s", $item['locketime'])?></td>											
            								<td  style="text-align:center">
											<?php 
											if($item['locketime']==0){
												echo '永久封号';
											}else if($item['locketime']>$time){
												echo '已封';												
											}else {
												echo '已经解封';												
											}
											?>
											</td>								 
									    <td class=" " style="text-align:center">
										<?php 
										if($item['locketime']==0 || $item['locketime']>$time){
										?>
									    <a href="javascript:void(0);" onclick="del('<?php echo $item['id'];?>');"  class="btn btn-default btn-xs purple">解封</a></td>
										<?php 
										}
										?>
									  </tr>
									<?php endforeach;?>
									</tbody>
								</table>
								<div class="pagination"><?php echo $this->page->create_page()?></div>
							</div>
						</div>	

	<!-- /Page Body -->
</div>


						
<script type="text/javascript">
//删除
function del(id) {
	if (confirm("您确定要解封吗?")) {
		$.post("/admin/a/live/lock_anchor/del_lock",{id:id},function(json){
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
//------------------直播详情页-------------------------
function detail(id ,type) {
//	var type = type;
	if (type == 0) {
		var butDatas = {};
	} else if (type == 1) {
		var butDatas = {'through_anchor':'通过'};
	} else if (type == 2) {
		var butDatas = {'refuse_anchor':'拒绝'};
	}
	$.ajax({
	//	url:'/admin/a/experts/expert_list/getExpertDetails',
		url:'/admin/a/live/anchor/getLiveAnchor',
		data:{id:id},
		dataType:'json',
		type:'post',
		success:function(data){
			if ($.isEmptyObject(data)) {
				alert('数据查询错误');
			} else {
				if (data.sex == 0) {
					var sex = '女';
				} else if (data.sex == 1) {
					var sex = '男';
				} else {
					var sex = '保密'
				}
				var countryname = typeof data.countryname == 'object' ? '' : data.countryname;
				var provincename = typeof data.provincename == 'object' ? '' : data.provincename;
				var cityname = typeof data.cityname == 'object' ? '' : data.cityname;
				var address = countryname+provincename+cityname;
				
				var expertType = '主播申请人' ;
				var jsonData = [{	title:'基本信息',type:'list',data:[
							{title:'姓名',val:data.realname},
					            	{title:'手机号',val:data.mobile},
					            	{title:'主播名',val:data.name},
					            	{title:'性别',val:sex},
					            	{title:'身份证号',val:data.idcard},
							{title:'所在地',val:address},
					            	{title:'个人简介',val:data.description},
					            	{title:'个人描述',val:data.comment,isComplete:true},
				            	]},
				            	
				            ];
				if (type == 2) {
					jsonData.push({title:'拒绝原因',type:'list',data:[
					              		{'title':'拒绝原因',val:{name:'refuse_reasion'},type:'textarea',isComplete:true}
					              	]
	              				});
				}
				$("#expertDetial").dataDetail({
					title:expertType+'：'+data.realname,
					jsonData:jsonData,
					butDatas:butDatas,
					isSimple:false,
					id:data.anchor_id,
					butClick:buttonClick
				});
			}
		}
	});
}

function buttonClick(){

	//通过主播申请
	var ts = true;
	$(".through_anchor").click(function(){
		var id = $(this).attr('data-val');
		var type=1;
		if (ts == false) {
			return false;
		} else {
			ts = false;
		}
		$.post("/admin/a/live/anchor/through_anchor",{'id':id,type:type},function(data){
			ts = true;
			var data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				$('#btnSearch0').click();
			} else {
				alert(data.msg);
				$('#btnSearch0').click();
			}
			$(".detail-close").click();
		});
	})
	//拒绝主播申请
	var rs = true;
	$(".refuse_anchor").click(function(){
		if (rs == false) {
			return false;
		} else {
			rs = false;
		}
		var id = $(this).attr('data-val');
		var refuse_reasion = $("textarea[name='refuse_reasion']").val();
		var type=2;
		$.post("/admin/a/live/anchor/through_anchor",{'id':id,'type':type,'refuse_reasion':refuse_reasion},function(data){
			rs = true;
			var data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				$('#btnSearch0').click();
			} else {
				alert(data.msg);
				$('#btnSearch0').click();
			}
			$(".detail-close").click();
		});
	})
}


//地区联动
$.ajax({
	url:'/common/selectData/getAreaAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#search-area').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
		$('#search-area1').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
		$('#search-area2').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
	}
});

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
</script>




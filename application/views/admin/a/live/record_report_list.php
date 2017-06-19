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
			<li class="active">举报处理记录</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->

				
						<div class="widget-header ">
							<span class="widget-caption">举报处理记录</span>
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
										<form class="form-inline" role="form"  method="post" action="<?php echo site_url('/admin/a/live/record/report_list')?>">	
										    <div class="form-group dataTables_filter col_ip" >
												房间类型：

													<select name="attrid" style="width:110px">
														<option value="">请选择...</option>
														<?php foreach($all_room_attr as $v){ ?>
														<option value="<?php echo $v['categoryid'];?>"><?php echo $v['categoryname'];?></option>
														<?php } ?>
													</select>
										    </div>											
										    <div class="form-group dataTables_filter col_ip" >

										        <input type="text" class="form-control" placeholder="关键字" name="name" value="<?php echo $name;?>">
										    </div>
										    <div class="form-group dataTables_filter col_ip"style="padding-left:15px;" >
												<input type="text" id="starttime"  class="search-input" style="width:110px;" value="<?php echo $starttime;?>" name="starttime" placeholder="开始日期" />
												<input type="text" id="endtime"  class="search-input" style="width:110px;" value="<?php echo $endtime;?>"  name="endtime" placeholder="结束日期" />
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
											<th style="text-align:center">编号</th>
											<th style="text-align:center">下架理由</th>
											<th style="text-align:center" >下架视频名称</th>
											<th style="text-align:center">视频编号</th>
											<th style="text-align:center">下架时间</th>
											<th style="text-align:center">下架人</th>											
										</tr>
									</thead>
									<tbody>
									<?php foreach ($pageData as $item): ?>
       									 <tr>
           								     <td class="sorting_1" style="text-align:center"><?php echo $item['id'];?></td>
           								     <td class=" " style="text-align:center"><?php echo $item['content'];?></td>
            								     <td  style="text-align:center"><?php echo $item['name']?></td>
            								     <td  style="text-align:center"><?php echo $item['video_id']?></td>
            								     <td  style="text-align:center"><?php echo $item['addtime']?></td>												 
            								     <td  style="text-align:center"><?php echo $item['name']?></td>
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
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/live/video/del_video_comment",{id:id},function(json){
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




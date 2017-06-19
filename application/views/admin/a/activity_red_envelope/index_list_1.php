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
			<li class="active">帮游侠列表</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->

				
						<div class="widget-header ">
							<span class="widget-caption">帮游侠列表</span>
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
										<form class="form-inline" role="form"  method="get" action="<?php echo site_url('admin/a/flow_activity/index')?>">	
										    <div class="form-group dataTables_filter col_ip"style="padding-left:15px;" >
												激活状态：<select name="status" style="width:110px">
													<option value="-1" <?php if(-1 == $status) echo "selected='selected'";?>>请选择..</option>												
													<option value="1"  <?php if(1 == $status) echo "selected='selected'";?> >已激活</option>
													<!--<option value="0"  <?php if(0 == $status) echo "selected='selected'";?> >未激活</option>-->													
													</select>											
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
									帮游侠人数：<?php echo $num_total;?>，累计获得人民币数：<?php echo $money_total;?>元
									<button class="btn btn_green"  data-val="0"  onclick="drive_member(this);" style="margin-left:0;margin-bottom:0;">导出</button>
								</div>
								<div class="dataTables_length" id="simpledatatable_length">
									<label></label>
								</div>
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="simpledatatable" aria-describedby="simpledatatable_info">
									<thead>
										<tr role="row">
											<th style="text-align:center">用户id</th>
											<th style="text-align:center">用户名</th>
											<th style="text-align:center">手机号</th>											
											<th style="text-align:center" >推荐人数</th>
											<th style="text-align:center" >金额(元)</th>											
											<th style="text-align:center">时间</th>
                                                                                        <th style="text-align:center">设备号</th>
											<th style="text-align:center">操作</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($pageData as $item): ?>
       									 <tr>
												<td class="sorting_1" style="text-align:center"><?php echo $item['member_id'];?></td>
												<td class=" " style="text-align:center"><?php echo $item['loginname'];?></td>
            								    <td  style="text-align:center"><?php echo $item['mobile']?></td>
            								    <td  style="text-align:center"><?php echo $pep_all[$item['member_id']];?></td>												 
                                                                            <td  style="text-align:center"><?php echo $item['money'] ?></td>												 
                                                                            <td  style="text-align:center"><?php echo date("Y-m-d H:i:s", $item['addtime']) ?></td>		
                                                                            <td  style="text-align:center"><?php echo $item['equip_id']?></td>
									    <td class=" " style="text-align:center">
										<?php if($item['retmoney']==0 ) { ?>
										<?php if($item['money']>0 ) { ?>
									    <a href="javascript:void(0);" onclick="del('<?php echo $item['id'];?>');"  class="btn btn-default btn-xs purple">打款</a></td>
										<?php }else{ ?>
										...
										<?php } ?>											
										<?php }else{ ?>
										已打款
										<?php } ?>										
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

	//导出名单信息
	 function  drive_member(obj){
			 var order_id = $(obj).attr('data-val');
			 $.post(
					  "<?php echo site_url('admin/b1/order/export_excel')?>",
					  {'id':order_id},
					  function(data) {
							   data = eval('('+data+')');
							  data = '<?php echo base_url();?>'+data;
							  window.location.href=data;
			  });

	 }


//删除
function del(id) {
	if (confirm("您确定要打款吗?")) {
		$.post("/admin/a/flow_activity/dakuang",{id:id},function(json){
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




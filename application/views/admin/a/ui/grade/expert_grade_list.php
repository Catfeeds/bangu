<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb"  style="width:100%;margin-left:0px;">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">管家列表 </li>
		</ul>
	</div>

	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">管家列表 </a></li>	
	</ul>

	<div class="tab-content tabs-flat">
		<!-- 管家列表 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm0">
						<div class="form-group has-feedback">
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px">管家名称：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="title">
							</div>	
						    <label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px">手机号：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="mobile">
							</div>
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px">管家类型：</label>
							<div style="display:inline-block;padding-left:2px;">
						      <select name="expert_type">
						      	<option value='0'>全部</option>
						      	<option value='1'>直属管家</option>
						      	<option value='2'>非直属管家</option>
						      </select>
							</div>
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div style="display:inline-block;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch0">
							</div>
						</div>
					</form>
					<div id="list"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="expertDetial"></div>
<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />
<!-- 管家详情 -->
<?php echo $this->load->view('admin/a/expert/expert_line.php');  ?>
<script src="<?php echo base_url("assets/js/jquery.dataDetail.js") ;?>"></script>

<script type="text/javascript">
jQuery(document).ready(function(){
	// 第一个列表 未使用===============================================================
	var page0=null;
	jQuery("#btnSearch0").click(function(){	
		page0.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/grade/expertGradeData",form : '#listForm0',// 绑定一个查询表单的ID
				columns : [
						{title : '编号',width : '5%',align : 'center',
							formatter : function(value,rowData, rowIndex) {
								return rowIndex+1;
							}
						},
						{field : 'realname',title : '管家姓名',align : 'center', width : '10%',
							formatter : function(value,rowData, rowIndex) {
								var url="'/admin/a/experts/expert_update/getDetail'";
								return '<a href="javascript:void(0);" onclick="detail('+rowData.id+' ,0);" style="color:#2DC3E8;">'+rowData.realname+'</a>';
								
							}								
						},
						{field : 'nickname',title : '昵称',align : 'center', width : '15%'},
						{field : 'mobile',title : '手机号码',align : 'center', width : '10%'},
						{field : 'email',title : '邮箱号',align : 'center', width : '10%'},
						{field : 'idcard',title : '身份证',align : 'center', width : '10%'},
						{field : 'idcard',title : '所在地',align : 'center', width : '10%',
							formatter : function(value,rowData, rowIndex) {
								return rowData.pd_name+rowData.cid_name;
							} 
						},
						{field : 'addtime',title : '申请时间',align : 'center', width : '10%'},
						{field : '',title : '操作',align : 'center', width : '15%',
							 formatter : function(value,rowData, rowIndex) {
								return '<a href="/admin/a/grade/edit_grade_list?id='+rowData.id+'" target="_blank">修改</a>';
							} 
						}
				]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery('#tab0').addClass('active');
		page0.load({"status":"1"});
	});
});
//------------------管家详情页-------------------------

function detail(id ,type) {
//	var type = type;
	if (type == 0) {
		var butDatas = {};
	} else if (type == 1) {
		var butDatas = {'through':'通过'};
	} else if (type == 2) {
		var butDatas = {'refuse':'退回'};
	}
	$.ajax({
		url:'/admin/a/experts/expert_list/getExpertDetails',
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
				var ra_name = typeof data.ra_name == 'object' ? '' : data.ra_name;
				var cia_name = typeof data.cia_name == 'object' ? '' : data.cia_name;
				var pa_name = typeof data.pa_name == 'object' ? '' : data.pa_name;
				var ca_name = typeof data.ca_name == 'object' ? '' : data.ca_name;
				var address = ca_name+pa_name+cia_name+ra_name;
				// 从业经历
				var resume = new Array();
				if (!$.isEmptyObject(data.resume)) {
					$.each(data.resume ,function(key ,val){
						resume[key] = {'起止时间':val.starttime+'到'+val.endtime,'所在企业':val.company_name,'职务':val.job,'工作描述':val.description};
					})
				}
				//荣誉证书
				var certificate = new Array();
				if (!$.isEmptyObject(data.certificate)) {
					$.each(data.certificate ,function(key ,val){
						certificate[key] = {'证书名称':val.certificate,'扫描件':'<img class="small-img" src="'+val.certificatepic+'" />',};
					})
				}
				
				var expertType = data.type == 1 ? '境内管家' : '境外管家';
				var jsonData = [{title:'基本信息',type:'list',data:[
					            	{title:'手机号',val:data.mobile},
					            	{title:'邮箱号',val:data.email},
					            	{title:'姓名',val:data.realname},
					            	{title:'昵称',val:data.nickname},
					            	{title:'性别',val:sex},
					            	{title:'微信号',val:data.weixin},
					            	{title:'身份证号',val:data.idcard},
					            	{title:'身份证正面',val:data.idcardpic,type:'img'},
					            	{title:'管家头像',val:data.small_photo,type:'img'},
					            	{title:'身份证反面',val:data.idcardconpic,type:'img'},
					            	
					            	{title:'擅长线路',val:data.destName},
					            	{title:'个人简介',val:data.beizhu},
					            	{title:'上门服务地区',val:data.cityname},
					            	{title:'所在地',val:address},
					            	{title:'个人描述',val:data.talk,isComplete:true}
				            	]},
				            	{title:'从业经历',type:'table',data:resume},
				            	{title:'荣誉证书',type:'table',data:certificate}
				            ];
				if (type == 2) {
					jsonData.push({title:'退回原因',type:'list',data:[
					              		{'title':'退回原因',val:{name:'refuse_reasion'},type:'textarea',isComplete:true}
					              	]
	              				});
				}
				$("#expertDetial").dataDetail({
					title:expertType+'：'+data.realname,
					jsonData:jsonData,
					butDatas:butDatas,
					isSimple:false,
					id:data.id,
					butClick:buttonClick
				});
			}
		}
	});
}

function buttonClick(){
	//通过管家申请
	var ts = true;
	$(".through").click(function(){
		var id = $(this).attr('data-val');
		if (ts == false) {
			return false;
		} else {
			ts = false;
		}
		$.post("/admin/a/experts/expert_list/through_expert",{'id':id},function(data){
			ts = true;
			var data = eval('('+data+')');
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/experts/expert_list/getExpertData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$(".detail-box,.maskLayer").hide();
			} else {
				alert(data.msg);
			}
		});
	})
	//拒绝管家申请
	var rs = true;
	$(".refuse").click(function(){
		if (rs == false) {
			return false;
		} else {
			rs = false;
		}
		var id = $(this).attr('data-val');
		var refuse_reasion = $("textarea[name='refuse_reasion']").val();
		$.post("/admin/a/experts/expert_list/refuse_expert",{'id':id,refuse_reasion:refuse_reasion},function(data){
			rs = true;
			var data = eval('('+data+')');
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/experts/expert_list/getExpertData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$(".detail-box,.maskLayer").hide();
			} else {
				alert(data.msg);
			}
		});
	})
}
</script>



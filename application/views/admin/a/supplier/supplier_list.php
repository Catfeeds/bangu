<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
 <link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>供应商列表</li>
	</ul>
	<div class="page-body">
		<ul class="nav-tabs">
			<li class="active" data-val="1">新申请 </li>
			<li class="tab-red" data-val="2">合作中</li>
			<li class="tab-blue" data-val="3">已拒绝</li>
			<li class="tab-blue" data-val="-1">已冻结</li>
			<li class="tab-blue" data-val="-2">已终止</li>
		</ul>
		<div class="tab-content">
			<a id="add" href="javascript:void(0);" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">供应商名称：</span>
						<span ><input class="search-input" type="text" id="supplier_name"  name="supplier_name" placeholder="供应商名称" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">手机号：</span>
						<span ><input class="search-input" type="text"  name="mobile" placeholder="手机号" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">邮箱：</span>
						<span ><input class="search-input" type="text" name="email" placeholder="邮箱" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">供应商品牌：</span>
						<span ><input class="search-input" type="text" name="brand" placeholder="供应商品牌" /></span>
					</li>
					<li class="search-list search-th">
						<span class="search-title">更新时间：</span>
						<span >
							<input type="text" id="starttime"  class="search-input" style="width:110px;" name="starttime" placeholder="开始日期" />
							<input type="text" id="endtime"  class="search-input" style="width:110px;"  name="endtime" placeholder="结束日期" />
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">入驻日期：</span>
						<span >
							<input type="text" id="stime"  class="search-input" style="width:110px;" name="stime" placeholder="开始日期" />
							<input type="text" id="etime"  class="search-input" style="width:110px;"  name="etime" placeholder="结束日期" />
						</span>
					</li>
					<li class="search-list search-th">
						<span class="search-title">审核人：</span>
						<span ><input class="search-input" type="text" id="admin"  name="username" placeholder="审核人" /></span>
					</li>
					<li class="search-list search-th">
						<span class="search-title">直属管家：</span>
						<span >
							<select name="isExpert">
								<option value="0">请选择</option>
								<option value="1">有直属管家</option>
								<option value="2">没有直属管家</option>
							</select>
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">所在地：</span>
						<span id="search-area"></span>
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

<div class="detail-box change-agent">
	<div class="db-body" style="width:600px;">
		<div class="db-title">
			<h4>调整管理费</h4>
			<div class="db-close box-close">x</div>
		</div>
		<div class="db-content">
			<ul class="db-row-body">
				<li class="db-row">
					<div class="db-row-title">管理费率：</div>
					<div class="db-row-content"><input type="text" style="width:97%;" name="agentRate" />%</div>
				</li>
			</ul>
			<div class="db-buttons">
				<input type="hidden" value="" name="agent_id" />
				<div class="box-close">关闭</div>
				<div class="agent_submit">确定调整</div>
			</div>
		</div>
	</div>
</div>

<div class="detail-box frozen-supplier">
	<div class="db-body" style="width:600px;">
		<div class="db-title">
			<h4>冻结商家</h4>
			<div class="db-close box-close">x</div>
		</div>
		<div class="db-content">
			<ul class="db-row-body">
				<li class="db-row">
					<div class="db-row-title">冻结理由：</div>
					<div class="db-row-content"><textarea name="frozen_reason"></textarea></div>
				</li>
			</ul>
			<div class="db-buttons">
				<input type="hidden" value="" name="frozen_id" />
				<div class="box-close">关闭</div>
				<div class="frozen_button">确定冻结</div>
			</div>
		</div>
	</div>
</div>

<div class="form-box fb-body edit-box">
	<div class="fb-content">
		<div class="box-title">
			<h4>修改资料</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form" style="overflow-y: auto;height: 500px;">
			<form method="post" id="edit-supplier" action="#" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">公司：<i>*</i></div>
					<div class="fg-input"><input type="text" name="company_name"  /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">品牌：<i>*</i></div>
					<div class="fg-input"><input type="text" name="brand" maxlength="5" placeholder="5字以内" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">负责人手机号：<i>*</i></div>
					<div class="fg-input"><input type="text" name="mobile" maxlength="11" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">负责人姓名：<i>*</i></div>
					<div class="fg-input"><input type="text" name="realname" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title card-name">身份证扫描件：<i>*</i></div>
					<div class="fg-input">
						<input type="file" name="uploadImg11" onchange="uploadImgFile(this);" id="uploadImg11">
						<input type="hidden" name="idcardpic">
					</div>
				</div>
				<!-- 以上三种供应商类型公用 -->
				<div class="form-group supplier-d">
					<div class="fg-title">营业执照扫描件：<i>*</i></div>
					<div class="fg-input">
						<input type="file" name="uploadImg12" onchange="uploadImgFile(this);" id="uploadImg12">
						<input type="hidden" name="business_licence">
					</div>
				</div>
				<div class="form-group supplier-d">
					<div class="fg-title">经营许可证扫描件：<i>*</i></div>
					<div class="fg-input">
						<input type="file" name="uploadImg13" onchange="uploadImgFile(this);" id="uploadImg13">
						<input type="hidden" name="licence_img">
					</div>
				</div>
				<div class="form-group supplier-d">
					<div class="fg-title">经营许可证编号：<i>*</i></div>
					<div class="fg-input"><input type="text" name=licence_img_code /></div>
				</div>
				<div class="form-group supplier-da">
					<div class="fg-title">法人代表姓名：<i>*</i></div>
					<div class="fg-input"><input type="text" name="corp_name" maxlength="20"/></div>
				</div>
				<div class="form-group supplier-d">
					<div class="fg-title">法人代表身份证扫描件：<i>*</i></div>
					<div class="fg-input">
						<input type="file" name="uploadImg14" onchange="uploadImgFile(this);" id="uploadImg14">
						<input type="hidden" name="corp_idcardpic">
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id">
					<input type="hidden" name="kind">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>


<div id="supplier-detail"></div>


   <!-- 供应商的银行账户修改 -->
   <div class="fb-content" id="sales_data" style="display:none;" >
    <div class="box-title">
        <h4 class="s_order_data">银行账户</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="brand-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                    <tr style="height:40px">
                        <td class="order_info_title">供应商:</td>
                        <td colspan="3">
							 <span class="supplier_name"></span>
                        </td>
                    </tr>
                    <tr style="height:40px">
                        <td class="order_info_title">开户银行:</td>
                        <td colspan="3"><input type="text" name="bankname" value="" class="search_input"  style="width:350px;"  />
                        </td>
                    </tr>
                    <tr style="height:40px">
                        <td class="order_info_title">开户银行支行:</td>
                        <td colspan="3"><input type="text" name="brand" value="" class="search_input"  style="width:350px;"  />
                        </td>
                    </tr>
                     <tr style="height:40px">
                        <td class="order_info_title">开户人:</td>
                        <td colspan="3"><input type="text" name="openman" value="" class="search_input"  style="width:350px;"  />
                        </td>
                    </tr>
                     <tr style="height:40px">
                        <td class="order_info_title">开户账号:</td>
                        <td colspan="3"><input type="text" name="bank_num" value="" class="search_input"  style="width:350px;"  />
                        </td>
                    </tr>

                </table>
            </div>
            <div class="form_btn clear" >
            	    <input type="hidden" name="supplierID" value="" class="search_input"  style="width:350px;"  />
            	    <input type="hidden" name="brand_id" value="" class="search_input"  style="width:350px;"  />
                  <input type="button" value="保存" class="btn btn_blue" id="ref_order_btn" style="margin-left:210px;"  onclick="sub_supplier_brand()" />
                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  />
            </div>
        </form>
    </div>
</div>

<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.dataDetail.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.extend.js") ;?>"></script>

<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<?php echo $this->load->view('admin/a/supplier/supplier_add.php');  ?>

<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">	
//导出excel表格
$('#export_excel').click(function(){
	layer.load(1);
	$.ajax({
		url:'/admin/a/supplier/exportExcel',
		data:$('#search-condition').serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				layer.closeAll();
				window.location.href=result.msg;
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
})

function edit(id) {
	$.ajax({
		url:'/admin/a/supplier/getDetailData',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			if ($.isEmptyObject(data)) {
				alert('没有数据');
			} else {
				var formObj = $('#edit-supplier');
				formObj.find('input[name=mobile]').val(data.mobile);
				formObj.find('input[name=brand]').val(data.brand);
				formObj.find('input[name=company_name]').val(data.company_name);
				formObj.find('input[name=realname]').val(data.realname);
				formObj.find('input[name=id]').val(data.id);
				formObj.find('input[name=kind]').val(data.kind);
				formObj.find('input[name=corp_name]').val(data.corp_name);
				formObj.find('input[name=licence_img_code]').val(data.licence_img_code);
				formObj.find('input[name=idcardpic]').val(data.idcardpic).next('img').remove();
				formObj.find('input[name=idcardpic]').after('<img class="uploadImg" style="display: block;width:80px;" src="'+data.idcardpic+'" />');
				formObj.find('input[name=business_licence]').val(data.business_licence).next('img').remove();
				formObj.find('input[name=business_licence]').after('<img class="uploadImg" style="display: block;width:80px;" src="'+data.business_licence+'" />');
				formObj.find('input[name=licence_img]').val(data.licence_img).next('img').remove();
				formObj.find('input[name=licence_img]').after('<img class="uploadImg" style="display: block;width:80px;" src="'+data.licence_img+'" />');
				formObj.find('input[name=corp_idcardpic]').val(data.corp_idcardpic).next('img').remove();
				formObj.find('input[name=corp_idcardpic]').after('<img class="uploadImg" style="display: block;width:80px;" src="'+data.corp_idcardpic+'" />');
			
				
				if (data.kind == 1) {
					$('.supplier-d,.supplier-da').show();
				} else if (data.kind == 2) {
					$('.supplier-d,.supplier-da').hide();
				} else {
					$('.supplier-da').show();
					$('.supplier-d').hide();
				}
				$('.edit-box,.mask-box').show();
			}
		}
	});
}

$('#edit-supplier').submit(function(){
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:'/admin/a/supplier/edit',
		type:'post',
		data:$(this).serialize(),
		dataType:'json',
		success:function(data) {
			if (data.code == '2000' ) {
				$("#dataTable").pageTable({
					columns:columns2,
					url:'/admin/a/supplier/getSupplierData',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:page
				});
				alert(data.msg);
				$('.edit-box,.mask-box').hide();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})

$('input[name=agentRate]').verifNum({
	maxNum:100,
	digit:2
});
// 申请中
var columns1 = [ {field : 'company_name',title : '供应商名称',width : '150',align : 'left'},
		{field : null,title : '所在地',width : '150',align : 'left',formatter:function(item){
				var address = item.country+item.province+item.city;
 				return typeof address == 'string' ? address.replace('null' ,'') : address;
			}
		},
		{field : 'addtime',title : '入驻日期',width : '120',align : 'center'},
		{field : 'brand',title : '品牌名称',width : '100',align : 'center'},
		{field : 'realname',title : '负责人',align : 'center', width : '90'},
		{field : 'mobile',title : '联系电话',align : 'center', width : '90'},
		{field : 'email',title : '电子邮箱',align : 'center', width : '130'},
		{field : null,title : '操作',align : 'center', width : '200',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="showDetail('+item.id+' ,1)" class="tab-button but-blue">详情</a>&nbsp;';
			button += '<a href="javascript:void(0);" onclick="showDetail('+item.id+' ,2)" class="tab-button but-blue">通过</a>&nbsp;';
			button += '<a href="javascript:void(0);" onclick="showDetail('+item.id+' ,3)" class="tab-button but-blue">拒绝</a>';	
			button += '<a href="javascript:void(0);" onclick="showbank('+item.id+' ,3)" class="tab-button but-blue">银行账号</a>';	
			return button;
		}
	}];
//合作中
var columns2 = [ {field : 'company_name',title : '供应商名称',width : '150',align : 'left'},
         {field : null,title : '所在地',width : '150',align : 'left',formatter:function(item){
     			var address = item.country+item.province+item.city;
     			return typeof address == 'string' ? address.replace('null' ,'') : address;
     		}
     	 },
         {field : 'addtime',title : '入驻日期',width : '120',align : 'center'},
		 {field : 'brand',title : '品牌名称',width : '80',align : 'center'},
         {field : 'realname',title : '负责人',align : 'center', width : '80'},
         {field : 'mobile',title : '联系电话',align : 'center', width : '120'},
         {field : 'email',title : '电子邮箱',align : 'center', width : '120'},
         {field : 'username',title : '审核人',align : 'center', width : '80'},
         {field : 'modtime',title : '更新时间',align : 'center', width : '120'},
         {field : 'expert_names',title : '直属管家',align : 'center', width : '150'},
         {field : null,title : '管理费率',align : 'center', width : '80',formatter:function(item){
				return ((item.agent_rate)*100).toFixed(2)+"%";
             }
         },
         {field : null,title : '操作',align : 'center', width : '200',formatter: function(item){
         	var button = '<a href="javascript:void(0);" onclick="showDetail('+item.id+' ,1)" class="tab-button but-blue">详情</a>&nbsp;';
         	button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">修改资料</a>&nbsp;';	
         	button += '<a href="javascript:void(0);" onclick="frozen('+item.id+')" class="tab-button but-blue">冻结</a>&nbsp;';	
         	button += '<a href="javascript:void(0);" onclick="adjust(this)" agent="'+item.agent_rate+'" val="'+item.id+'" class="tab-button but-blue">调整费率</a>';	
         	button += '<a href="javascript:void(0);" onclick="showbank('+item.id+' ,3)" class="tab-button but-blue">银行账号</a>';	
         	return button;
         }
     }];
//已拒绝
var columns3 = [ {field : 'company_name',title : '供应商名称',width : '150',align : 'left'},
         {field : null,title : '所在地',width : '150',align : 'left',formatter:function(item){
        		var address = item.country+item.province+item.city;
  				return typeof address == 'string' ? address.replace('null' ,'') : address;
     		}
     	 },
         {field : 'addtime',title : '入驻日期',width : '120',align : 'center'},
         {field : 'realname',title : '负责人',align : 'center', width : '90'},
		 {field : 'brand',title : '品牌名称',width : '100',align : 'center'},
         {field : 'mobile',title : '联系电话',align : 'center', width : '130'},
         {field : 'email',title : '电子邮箱',align : 'center', width : '130'},
         {field : 'username',title : '审核人',align : 'center', width : '90'},
         {field : 'modtime',title : '更新时间',align : 'center', width : '130'},
         {field : null,title : '操作',align : 'center', width : '100',formatter: function(item){
        	return '<a href="javascript:void(0);" onclick="showDetail('+item.id+' ,1)" class="tab-button but-blue">详情</a>&nbsp;';
         }
     }];
//已冻结
var columns4 = [ {field : 'company_name',title : '供应商名称',width : '150',align : 'left'},
         {field : null,title : '所在地',width : '150',align : 'left',formatter:function(item){
        	 	var address = item.country+item.province+item.city;
				return typeof address == 'string' ? address.replace('null' ,'') : address;
     		}
     	 },
         {field : 'addtime',title : '入驻日期',width : '120',align : 'center'},
         {field : 'realname',title : '负责人',align : 'center', width : '90'},
		 {field : 'brand',title : '品牌名称',width : '100',align : 'center'},
         {field : 'mobile',title : '联系电话',align : 'center', width : '130'},
         {field : 'email',title : '电子邮箱',align : 'center', width : '130'},
         {field : 'refuse_reason',title : '冻结原因',align : 'center', width : '150'},
         {field : null,title : '操作',align : 'center', width : '160',formatter: function(item){
         	var button = '<a href="javascript:void(0);" onclick="showDetail('+item.id+' ,1)" class="tab-button but-blue">详情</a>&nbsp;';
         	button += '<a href="javascript:void(0);" onclick="recovery('+item.id+')" class="tab-button but-blue">恢复合作</a>&nbsp;';
         	button += '<a href="javascript:void(0);" onclick="stop_supplier('+item.id+')" class="tab-button but-blue">终止合作</a>&nbsp;';
         	return button;
         }
     }];
//已终止
var columns5 = [ {field : 'company_name',title : '供应商名称',width : '150',align : 'left'},
         {field : null,title : '所在地',width : '150',align : 'left',formatter:function(item){
        		 var address = item.country+item.province+item.city;
				return typeof address == 'string' ? address.replace('null' ,'') : address;
     		}
     	 },
         {field : 'addtime',title : '入驻日期',width : '120',align : 'center'},
         {field : 'realname',title : '负责人',align : 'center', width : '100'},
		 {field : 'brand',title : '品牌名称',width : '100',align : 'center'},
         {field : 'mobile',title : '联系电话',align : 'center', width : '130'},
         {field : 'email',title : '电子邮箱',align : 'center', width : '130'},
         {field : 'refuse_reason',title : '终止原因',align : 'center', width : '130' }];

change_status(1);
var formObj = $("#search-condition");
//导航栏切换
$('.nav-tabs li').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find('select').val(0).change();
	var status = $(this).attr('data-val')
	formObj.find('input[name="status"]').val(status);
	change_status(status);
})
//根据状态加载数据
function change_status(status) {
	if (status == 1) {
		$('.search-th').hide();
		var columns = columns1;
	} else if (status == 2) {
		$('.search-th').show();
		var columns = columns2;
	} else if (status == 3) {
		$('.search-th').show();
		var columns = columns3;
	} else if (status == -1) {
		$('.search-th').hide();
		var columns = columns4;
	} else if (status == -2) {
		$('.search-th').hide();
		var columns = columns5;
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/supplier/getSupplierData',
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table-data'
	});
}
function showDetail(id ,type) {
	if (type == 1) {
		var buttons = {};
	} else if (type == 2){
		var buttons = {'through':'通过'};
	} else if (type == 3) {
		var buttons = {'refuse':'拒绝'};
	}
	$.ajax({
		url:'/admin/a/supplier/getDetailData',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(supplier) {
			if (!$.isEmptyObject(supplier)) {
				var address = supplier.country_name+supplier.province_name+supplier.city_name;
  				var address = typeof address == 'string' ? address.replace('null' ,'') : address;
				$('#supplier-detail').dataDetail({
					title:'供应商详情',
					jsonData:[{title:'基本信息',type:'list',data:[
					          		{title:'负责人姓名',val:supplier.realname},
					          		{title:'联系人姓名',val:supplier.linkman},
					          		{title:'负责人手机',val:supplier.mobile},
					          		{title:'联系人手机',val:supplier.link_mobile},
					          		{title:'传真',val:supplier.fax},
					          		{title:'固话',val:supplier.telephone},
					          		{title:'邮箱',val:supplier.email},
					          		{title:'所在地',val:address},
					          		{title:'供应商品牌',val:supplier.brand},
					          		{title:'主营业务',val:supplier.expert_business},
					          		{title:'负责人证件',val:supplier.idcardpic,type:'img'},
						      	]
				      		  },
						      {title:'企业信息',type:'list',data:[
									{title:'供应商类型',val:'境内供应商'},
									{title:'企业名称',val:supplier.company_name},
									{title:'法人代表姓名',val:supplier.corp_name},
									{title:'经营许可证号',val:supplier.licence_img_code},
									{title:'法人代表身份证',val:supplier.corp_idcardpic,type:'img'},
									{title:'经营许可证',val:supplier.licence_img,type:'img'},
									{title:'营业执照',val:supplier.business_licence,type:'img'},
						      	]
						      },
						      {title:'管理费率',type:'list',data:[
						  			{title:'管理费率',val:'<input type="text" style="width:85%;" name="agent" value="'+(supplier.agent_rate*100).toFixed(2)+'"><span style="margin-left: 5px;font-size: 15px;">%</span>'}
						  		]
						  	  },
// 						  	  {title:'供应商代码',type:'list',data:[
// 									{title:'供应商代码',val:'<input type="text" style="width:85%;" name="code" value="" placeholder="必填，1~6位字母">'}
// 								]
// 							  },
						  	  {title:'拒绝原因',type:'list',data:[
						  	        {title:'拒绝原因',val:{name:'refuse_reason'},type:'textarea',isComplete:true}
								]
							}
						],
					butDatas:buttons,
					isSimple:false,
					id:id,
					butClick:function(obj){
							if (type != 3) {
								$('textarea[name=refuse_reason]').parents('ul').parents('li').hide();
							}
							$('input[name=agent]').verifNum({
								maxNum:100,
								digit:2
							});
							$('.through').click(function(){
								through(this);
							})
							$('.refuse').click(function(){
								refuse(this);
							})
						}
				});
			} else {
				alert('木有找到数据哟');
			}
		}
	});
}
function through(obj) {
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:'/admin/a/supplier/through_apply',
		type:'post',
		dataType:'json',
		data:{id:$(obj).attr('data-val'),agent_rate:$('input[name=agent]').val() ,code:$('input[name=code]').val()},
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/supplier/getSupplierData',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:page
				});
				alert(data.msg);
				$('.detail-box,.maskLayer').hide();
			} else {
				alert(data.msg);
			}
		}
	});
}
function refuse(obj) {
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:'/admin/a/supplier/refuse_apply',
		type:'post',
		dataType:'json',
		data:{id:$(obj).attr('data-val'),refuse_reason:$('textarea[name=refuse_reason]').val()},
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/supplier/getSupplierData',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:page
				});
				alert(data.msg);
				$('.detail-box,.maskLayer').hide();
			} else {
				alert(data.msg);
			}
		}
	});
}

//调整管理费率
function adjust(obj) {
	var agent_rate = (($(obj).attr("agent"))*100).toFixed(2);
	$("input[name='agentRate']").val(agent_rate);
	$("input[name='agent_id']").val($(obj).attr('val'));
	$(".change-agent,.mask-box").fadeIn(500);
}
//确认调整
$(".agent_submit").click(function(){
	var id = $("input[name='agent_id']").val();
	var agent_rate = $("input[name='agentRate']").val();
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:'/admin/a/supplier/adjustAgentRate',
		type:'post',
		dataType:'json',
		data:{id:id,agent_rate:agent_rate},
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns2,
					url:'/admin/a/supplier/getSupplierData',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:page
				});
				alert(data.msg);
				$('.change-agent,.mask-box').hide();
			} else {
				alert(data.msg);
			}
		}
	}); 
})

//冻结供应商
function frozen(id) {
	$("input[name='frozen_id']").val(id);
	$("textarea[name='frozen_reason']").val('');
	$('.frozen-supplier,.mask-box').show();
}
//确认冻结
$(".frozen_button").click(function(){
	var id = $("input[name='frozen_id']").val();
	var frozen_reason = $("textarea[name='frozen_reason']").val();
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:'/admin/a/supplier/frozenSupplier',
		type:'post',
		dataType:'json',
		data:{id:id,reason:frozen_reason},
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns2,
					url:'/admin/a/supplier/getSupplierData',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:page
				});
				alert(data.msg);
				$('.frozen-supplier,.mask-box').hide();
			} else {
				alert(data.msg);
			}
		}
	}); 
})
// 终止与供应商合作
function stop_supplier(id) {
	if (confirm("终止后将不可恢复！！！您确定终止？")) {
		var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
		$.ajax({
			url:'/admin/a/supplier/stop_supplier',
			type:'post',
			dataType:'json',
			data:{id:id},
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns4,
						url:'/admin/a/supplier/getSupplierData',
						searchForm:'#search-condition',
						tableClass:'table-data',
						pageNumNow:page
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		}); 
	}
}
//恢复与供应商合作
function recovery(id) {
	if (confirm("您确定要恢复合作?")) {
		var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
		$.ajax({
			url:'/admin/a/supplier/recovery',
			type:'post',
			dataType:'json',
			data:{id:id},
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns4,
						url:'/admin/a/supplier/getSupplierData',
						searchForm:'#search-condition',
						tableClass:'table-data',
						pageNumNow:page
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});
	}
}
//搜索栏商家名字下拉
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
	    id : "#supplier_name",
	    name : "supplier_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
$.post('/admin/a/comboBox/getAdminData', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.realname,
		    value : val.id
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#admin",
	    name : "admin_id",// 隐藏的value ID字段
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
$.ajax({
	url:'/common/selectData/getAreaAll',
	dataType:'json',
	type:'post',
	success:function(data){
		$('#search-area').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
		$('#add-area').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
	}
});

//供应商银行账号
function showbank(id){
	 layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: ['600px', '50%'],
           shadeClose: false,
           content: $('#sales_data')
    }); 

     jQuery.ajax({ type : "POST",async:false,data : { 'id':id},url : "<?php echo base_url()?>admin/a/supplier/get_supplier_brank", 

         success : function(result) { 
        	  result = eval('('+result+')');
        	  if(result.status==1){
            	  $('.supplier_name').html(result.data.realname)
        		  $('input[name="bankname" ]').val(result.data.bankname);
        		  $('input[name="brand" ]').val(result.data.brand);
        		  $('input[name="openman" ]').val(result.data.openman);
        		  $('input[name="bank_num" ]').val(result.data.bank);
        		  $('input[name="supplierID" ]').val(id); 
        		  $('input[name="brand_id" ]').val(result.data.id);  
               }else{
                   alert('获取数据失败');
               }
        	 
         }
     });
}
//保存供应商银行账号
function sub_supplier_brand(){

	jQuery.ajax({ type : "POST",async:false,data : jQuery('#brand-data').serialize(),url : "<?php echo base_url()?>admin/a/supplier/save_supplier_brand", 
		success : function(response) {
			var obj = eval('(' + response + ')');
			if(obj.status=='1'){
				layer.msg(obj.msg, {icon: 1});
					
			}else{

				layer.msg(obj.msg, {icon: 2});
			}
		}
	})
}

</script>
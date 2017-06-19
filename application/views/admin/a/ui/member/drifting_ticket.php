<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb"  style="width:100%;margin-left:0px;">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">漂流门票设置</li>
		</ul>
	</div>

	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs" ><a href="#home0">漂流门票</a></li>	
	</ul>

	<div class="tab-content tabs-flat">
		<div>
			<a class="btn btn-info btn-xs" id="add_consult" style="padding:5px 10px 5px 10px;margin-bottom:10px;">添加</a>
		</div>
		<!-- 管家列表 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm0">
					<!--  	<div class="form-group has-feedback">
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">名称：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="s_name" placeholder="名称-模糊搜索">
							</div>	
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">编号：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="s_channel_code" placeholder="编号-模糊搜索">
							</div>
							<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
							<div class="col-lg-4" style="width: 5%;padding-left:2px;">
							     <input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch0">  
							</div>

						</div>-->
					</form>
					<div id="list"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 添加 -->
<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in edit_expert_line" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close" onclick="close();">×</button>
				<h4 class="modal-title">添加漂流门票</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
						<form class="form-horizontal" role="form" id="wx_activity_form" method="post" action="#">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right"><span style="color: red;">*</span>编号</label>
								<div class="col-sm-10">
									<input class="form-control " style="float:left;width:95%;" name="wx_code" type="text" />
								</div>
							</div>
							
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right"><span style="color: red;">*</span>名称</label>
								<div class="col-sm-10">
									<input class="form-control " style="float:left;width:95%;" name="wx_name" type="text" />
								</div>
							</div>
							
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right"><span style="color: red;">*</span>数量</label>
								<div class="col-sm-10">
									<input class="form-control " style="float:left;width:95%;" name="wx_num" type="text" />
								</div>
							</div>
							<div class="form-group">
								<div style="float:right;">
								  <input class="form-control " style="float:left;width:80%" name="wx_id" id="wx_id" type="hidden" />
									<input class="btn btn-palegreen "  onclick="submit_wx_activity();"   value="确认提交" style="width:75px;" type="button"/>
									<input class="btn btn-palegreen bootbox-close-button" onclick="close();" value="取消" style="width:75px;" type="button"/> 
								</div>
							  
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
</div>
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
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/member/drifting_ticket/driftingData",form : '#listForm0',// 绑定一个查询表单的ID
				columns : [

							{field : 'id',title : 'ID号',align : 'center', width : '10%'},
							{field : 'name',title : '名称',align : 'center', width : '15%'},
							{field : 'code',title : '编码',align : 'center', width : '15%'},
							{field : 'num',title : '数量',align : 'center', width : '10%'},
							
							{field : 'jointime',title : '操作',align : 'center', width : '20%',
								formatter : function(value,	rowData, rowIndex){
									
									return '<a href="##" onclick="edit_activity('+rowData.id+')">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="##" onclick="del_activity('+rowData.id+')">删除</a>';
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

//添加，编辑，漂流门票
$('#add_consult').click(function(){
	 $('input[name="wx_id"]').val('');
	 $('input[name="wx_num"]').val('');
	$('input[name="wx_code"]').val('');
	$('input[name="wx_name"]').val('');
	$('.modal-backdrop,.edit_expert_line').show();
});

//保存漂流门票
function submit_wx_activity(){
	var name=$('input[name="wx_name"]').val();
	var wx_code=$('input[name="wx_code"]').val();
	var wx_num=$('input[name="wx_num"]').val();
	if(name==''){
		alert('名称不能为空！');
		return false;
	}
	if(wx_code==''){
		alert('编号不能为空');
		return false;
	}
	if(wx_num==''){
		alert('数量不能为空');
		return false;
	}else{
	    if((/^(\+|-)?\d+$/.test( wx_num ))&&wx_num>0){  
		      
	    }else{  
	        alert("数量中请输入正整数！");  
	        return false;  
	    } 
	}
	
	jQuery.ajax({ type : "POST",data : jQuery('#wx_activity_form').serialize(),url : "<?php echo base_url();?>admin/a/member/drifting_ticket/save_wx_activity",
		success : function(data) {
			var data = eval('('+data+')');
			if (data.status == 1) {
			    alert(data.msg);
			    $('#tab0').click(); 
				$('.bc_close ').click(); 
			} else {
				alert(data.msg);
				$('#tab0').click(); 
				$('.bc_close ').click(); 
			}
		}
	});
}

//编辑会员注册漂流门票
 function edit_activity(id){
    if(id>0){
    	 $('input[name="wx_id"]').val(id);
    	$.post("/admin/a/member/drifting_ticket/get_wx_activity",{'id':id},function(data){
    		 var data = eval('('+data+')');
    		 if(data.status==1){
    			     //$('input[name="wx_name"]').val(data.activity.name);
	        		$('input[name="wx_name"]').val(data.activity.name);
	        		$('input[name="wx_code"]').val(data.activity.code);
	        		$('input[name="wx_num"]').val(data.activity.num);
        		}else{
        			 alert('获取数据失败');
        	         return false;
            	}
    	})
	    
    }else{
         alert('获取数据失败');
         return false;
    }
	$('.modal-backdrop,.edit_expert_line').show();
} 
//删除
 function del_activity(id){
	if(id>0){
		$.post("/admin/a/member/drifting_ticket/del_wx_activity",{'id':id},function(data){
				var data = eval('('+data+')');
				if (data.status == 1) {
				    alert(data.msg);
				    $('#tab0').click(); 
					$('.bc_close ').click(); 
				} else {
					alert(data.msg);
					$('#tab0').click(); 
					$('.bc_close ').click(); 
				}
		})
	}else{
		alert('操作失败');
	    return false;
	}
} 
</script>





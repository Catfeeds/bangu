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
			<li class="active">渠道管理 </li>
		</ul>
	</div>

	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">渠道管理  </a></li>	
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
						<div class="form-group has-feedback">
							<label class="control-label"  style="width: 85px;padding-right:0px;">渠道名称：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="s_name">
							</div>	
							<label class="control-label"  style="width: 85px;padding-right:0px;">渠道编号：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="s_channel_code">
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

<!-- 添加 -->
<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in edit_expert_line" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close" onclick="close();">×</button>
				<h4 class="modal-title">添加会员渠道</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
						<form class="form-horizontal" role="form" id="channel_form" method="post" action="#">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right"><span style="color: red;">*</span>名称</label>
								<div class="col-sm-10">
									<input class="form-control " style="float:left;width:95%;" name="name" type="text" />
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right"><span style="color: red;">*</span>编号</label>
								<div class="col-sm-10">
									<input class="form-control " style="float:left;width:95%;" name="channel_code" type="text" />
								</div>
							</div>
							<div class="form-group">
								<div style="float:right;">
								  <input class="form-control " style="float:left;width:80%" name="channel_id" id="channel_id" type="hidden" />
									<input class="btn btn-palegreen "  onclick="submit_channel();"   value="确认提交" style="width:75px;" type="button"/>
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
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/member/channel_manage/channelData",form : '#listForm0',// 绑定一个查询表单的ID
				columns : [

							{field : 'id',title : 'ID号',align : 'center', width : '10%'},
							{field : 'name',title : '名称',align : 'center', width : '15%'},
							{field : 'channel_code',title : '编码',align : 'center', width : '15%'},
							{field : 'qrcode',title : '二维码下载',align : 'center', width : '10%',
								
								formatter : function(value,	rowData, rowIndex){
									return '<a href="'+rowData.qrcode+'" target="_blank" >下载</a>';
								}
							},

							{field : 'jointime',title : '操作',align : 'center', width : '20%',
								formatter : function(value,	rowData, rowIndex){
									return '<a href="##" onclick="edit_channel('+rowData.id+')">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="##" onclick="del_channel('+rowData.id+')">删除</a>';
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

//添加，编辑，渠道管理
$('#add_consult').click(function(){
	 $('input[name="channel_id"]').val('');
	 $('input[name="name"]').val('');
	$('input[name="channel_code"]').val('');
	$('.modal-backdrop,.edit_expert_line').show();
});

//保存渠道管理
function submit_channel(){
	var name=$('input[name="name"]').val();
	var channel_code=$('input[name="channel_code"]').val();
	if(name==''){
		alert('名称不能为空！');
		return false;
	}
	if(channel_code==''){
		alert('编号不能为空');
		return false;
	}
	jQuery.ajax({ type : "POST",data : jQuery('#channel_form').serialize(),url : "<?php echo base_url();?>admin/a/member/channel_manage/save_channelData",
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

//编辑会员注册渠道
function edit_channel(id){
    if(id>0){
    	 $('input[name="channel_id"]').val(id);
    	$.post("/admin/a/member/channel_manage/get_channelData",{'id':id},function(data){
    		 var data = eval('('+data+')');
    		 if(data.status==1){
    			 $('input[name="name"]').val(data.channel.name);
        		 $('input[name="channel_code"]').val(data.channel.channel_code);
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
function del_channel(id){
	if(id>0){
		$.post("/admin/a/member/channel_manage/del_channelData",{'id':id},function(data){
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




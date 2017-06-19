<style>
	.add_btn{
		padding: 5px 8px;
		border: 1px solid #ccc;
		border-radius: 3px;
		background: #fff;
		cursor: pointer;
		margin-bottom: 10px;
	}
  	.img-content{
  		margin: 40px 0px 20px 116px;
  	}
  	.img-content img{
  		max-width:150px;
  	}
  	.fb-content{ width: 800px !important }
  	.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>旅游合同管理</li>
	</ul>
	<div class="page-body">
		<button class="add_btn" >管理公章</button>
		<div class="tab-content">
			<div id="dataTable"></div>
		</div>
	</div>
</div>

<div class="form-box fb-body" >
	<div class="fb-content" style="width:1200px;">
		<div class="box-title">
			<h4>编辑合同</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" id="editContract" action="#" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title" style="width:10%;">名称：<i>*</i></div>
					<div class="fg-input" style="width:87%;"><input type="text" disabled="disabled" name="name" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title" style="width:10%;"> 内容：<i>*</i></div>
					<div class="fg-input" style="width:87%;"><textarea name="content" id="contract" style="height:400px;"></textarea></div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>

<div class="fb-content" id="official-seal" style="display:none;width:560px !important;">
    <div class="box-title">
        <h4>公章管理</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="official-seal-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">公章：<i>*</i></div>
                <div class="fg-input">
                	<input type="file" name="fileinput" id="fileinput" onchange="uploadPic(this);">
                	<input type="hidden" name="pic" value="<?php echo empty($chapterData['bangu_chapter']) ? '' : $chapterData['bangu_chapter'];?>" />
                </div>
                <div style="margin: 40px 0px 20px 116px;" class="img-content">
                	<?php if(!empty($chapterData['bangu_chapter'])):?>
                	<img src="<?php  echo $chapterData['bangu_chapter'];?>" />
                	<?php endif;?>
                </div>
            </div>
            <div class="form-group">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url() ;?>file/common/plugins/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url() ;?>file/common/plugins/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
$('.add_btn').click(function(){
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#official-seal')
	});
})

$('#official-seal-form').submit(function(){
	$.ajax({
		url:'/admin/a/contract/updateChapter',
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


function uploadPic () {
	$.ajaxFileUpload({
	    url : '/admin/upload/uploadImgFile',
	    secureuri : false,
	    fileElementId : 'fileinput',// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : {
	    	fileId : 'fileinput'
	    },
	    success : function(data, status) {
		    if (data.code == 2000) {
		    	$('input[name=pic]').val(data.msg);
		    	if ($('.img-content').find('img').length) {
		    		$('.img-content').find('img').attr('src',data.msg);
			    } else {
			    	$('.img-content').append('<img src="'+data.msg+'" />');
				}
		    } else {
			    alert(data.msg);
		    }
	    },
	    error : function(data, status, e)// 服务器响应失败处理函数
	    {
		    alert('上传失败(请选择jpg/jpeg/png的图片重新上传)');
	    }
	});
}

//待留位
var columns = [ {field : null,title : '类型',width : '120',align : 'center',formatter:function(item){
				if(item.type == 1) {
					return '境外旅游合同';
				} else if (item.type == 2) {
					return '国内旅游合同';
				} else {
					return '不知道';
				}
			}
		},
		{field : 'content',title : '内容',align : 'center', width : '500'},
		{field : null,title : '操作',align : 'center', width : '80',formatter: function(item){
			return '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">编辑</a>&nbsp;';
		}
	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/contract/getContractData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});


var formObj = $("#editContract");
function edit(id) {
	$.ajax({
		url:'/admin/a/contract/getContractDetail',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data) {
			if (!$.isEmptyObject(data)) {
				var type = data.type == 1 ? '境外合同' :'境内合同';
				formObj.find('input[name=id]').val(data.id);
				formObj.find('textarea[name=content]').val(data.content);
				formObj.find('input[name=name]').val(type);
// 				var ue = UE.getEditor('contract');
// 				ue.ready(function() {
// 				    //设置编辑器的内容
// 				     $('.edui-editor').css({'width':'1080px','height':'400px'});
// 				     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
// 				    ue.setContent(data.content);
				   
// 				});
				$('.fb-body,.mask-box').show();
			} else {
				alert('选择有误');
			}
		}
	});
}

$('#editContract').submit(function(){
	$.ajax({
		url:'/admin/a/contract/edit',
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/contract/getContractData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$('.fb-body,.mask-box').hide();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})
</script>
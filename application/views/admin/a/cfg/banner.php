<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">预定页广告管理</a>
        </div>
        
        
        
        <div class="page_content bg_gray">      
            <div class="table_content">
            	<?php if (empty($banner)):?>
                <div class="add_btn btn_green" style="margin-bottom: 20px;" id="add-but">设置广告</div>
                <?php endif;?>
                <div class="table_list" id="dataTable"></div>
            </div>
        </div>
    </div>

<div class="fb-content" id="add-box" style="display:none;">
    <div class="fb-form">
        <form method="post" action="#" id="banner-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">url地址：<i>*</i></div>
                <div class="fg-input"><input type="text" name="url" placeholder="例:http://bangu.com/guanjia/"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">广告图：<i>*</i></div>
                <div class="fg-input up-pic">
                	<div class="add_btn btn_green"  onclick="uploadImgFile(this);">上传</div>
                	<input type="hidden" name="pic">
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

<div class="fb-content" id="see-pic" style="display:none;">
    <div class="fb-form" style="padding:10px;">
        <img src="" >
    </div>
</div>


<div id="xiuxiu_box" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<div class="right_box" style="display: none;"></div>

<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
$('#add-but').click(function(){
	var formObj = $('#banner-form');
	formObj.find('input[name=pic]').val('');
	formObj.find('input[name=url]').val('');
	formObj.find('input[name=id]').val('');
	formObj.find('.up-pic').find('img').remove();
	layer.open({
		  type: 1,
		  title: '设置广告图',
		  closeBtn: 1,
		  area: '460px',
		  shadeClose: false,
		  content: $('#add-box')
	});
})

$('#banner-form').submit(function(){
	$.ajax({
		url:'/admin/a/cfg/banner/add',
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(result) {
			if (result.code == 2000) {
				location.reload();
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

var columns = [ {field : 'url',title : 'url地址',width : '150',align : 'center'},
        		{field : false,title : '图片预览',align : 'center', width : '150',formatter:function(item){
						return '<a href="javascript:void(0);" data-val="'+item.pic+'" onclick="see(this);">图片预览</a>';
            		}
            	},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item){
        			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">修改</a>&nbsp;';
						button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="action_type">删除</a>';
        			return button;
        		}
        	}];
        	
getData();
function getData() {
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/cfg/banner/getBannerData',
		pageSize:10,
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

//查看图片
function see(obj) {
	$('#see-pic').find('img').attr('src' ,$(obj).attr('data-val'));
	layer.open({
		  type: 1,
		  title: '查看广告图',
		  closeBtn: 1,
		  area: '420px',
		  shadeClose: false,
		  content: $('#see-pic')
	});
}
//修改广告图
function edit(id) {
	$.ajax({
		url:'/admin/a/cfg/banner/detail',
		data:{id:id},
		type:'post',
		dataType:'json',
		success:function(result) {
			if ($.isEmptyObject(result)) {
				layer.alert('没有获取到数据', {icon: 2});
			} else {
				var formObj = $('#banner-form');
				formObj.find('input[name=pic]').val(result.pic);
				formObj.find('input[name=url]').val(result.url);
				formObj.find('input[name=id]').val(result.id);
				if (formObj.find('.up-pic').find('img').length) {
					formObj.find('.up-pic').find('img').attr('src' ,result.pic);
				} else {
					formObj.find('.up-pic').append('<img src="'+result.pic+'" style="width:100px;">');
				}
				
				layer.open({
					  type: 1,
					  title: '设置广告图',
					  closeBtn: 1,
					  area: '460px',
					  shadeClose: false,
					  content: $('#add-box')
				});
			}
		}
	});
}

//删除广告图
function del(id) {
	layer.confirm('您确定要删除此广告图', 
			{btn: ['确定','取消']},
			function(index){
				layer.close(index);
				$.ajax({
					url:'/admin/a/cfg/banner/del',
					data:{id:id},
					type:'post',
					dataType:'json',
					success:function(result) {
						if (result.code == 2000) {
							location.reload();
						} else {
							layer.alert(result.msg, {icon: 2});
						}
					}
				});
			}, 
			function(){}
		);
}


function uploadImgFile(obj){
		var buttonObj = $(obj);
		xiuxiu.setLaunchVars("cropPresets", '400x200');
		xiuxiu.embedSWF('xiuxiu_box',5,'100%','100%','xiuxiuEditor');
	       //修改为您自己的图片上传接口
		xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu'); ?>");
	    xiuxiu.setUploadType(2);
	    xiuxiu.setUploadDataFieldName("uploadFile");

		xiuxiu.onInit = function ()
		{
			//默认图片
			xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
		}
		xiuxiu.onUploadResponse = function (data)
		{
			data = eval('('+data+')');
			if (data.code == 2000) {
				buttonObj.next("input").val(data.msg);
				if (buttonObj.parent().find('img').length) {
					buttonObj.parent().find('img').attr('src' ,data.msg);
				} else {
					buttonObj.parent().append('<img src="'+data.msg+'" style="width:100px;">');
				}
				
				closeXiu();
			} else {
				alert(data.msg);
			}
		}
		$("#xiuxiuEditor").css('z-index','99999999').show();
		$('.avatar_box').show();
		$('.close_xiu').show();
		$('.right_box').show();
		return false;
}
$(document).mouseup(function(e) {
    var _con = $('#xiuxiuEditor'); // 设置目标区域
    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
        $("#xiuxiuEditor").hide();
        $('.avatar_box').hide();
        $('.close_xiu').hide();
        $('.right_box').hide();
    }
})
function closeXiu() {
	$("#xiuxiuEditor").hide();
	$('.avatar_box').hide();
	$('.close_xiu').hide();
	$('.right_box').hide();
}
</script>
</html>



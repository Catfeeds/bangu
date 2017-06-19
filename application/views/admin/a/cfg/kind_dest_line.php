<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">首页目的地线路管理</a>
        </div>
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                    		<div class="search_group">
                            	<label>线路名称</label>
                                <input type="text" name="name" style="width:130px;" class="search_input"/>
                            </div>
                            <div class="search_group">
                            	<label>始发地</label>
                                <input type="text" name="cityname" onclick="showStartplaceTree(this);" style="width:130px;" class="search_input"/>
                            	<input type="hidden" name="cityid" />
                            </div>
                            <div class="search_group">
                            	<label>分类目的地</label>
                                <input type="text" name="kindname" style="width:130px;" class="search_input"/>
                            </div>
                            <div class="search_group">
                            	<label>是否显示</label>
                                <select name="isopen">
                                	<option value="-1" selected="selected">全部</option>
                                	<option value="1">显示</option>
                                	<option value="0">不显示</option>
                                </select>
                            </div>
                            <div class="search_group">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            	<input type="button" id="add-button" class="search_button" value="添加"/>
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                </div>
            </div> 
        </div>
    </div>
    
<div class="form-box fb-body" style="z-index: 1000;">
	<div class="fb-content">
		<div class="box-title">
			<h4>首页目的地线路</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="add-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">始发地：<i>*</i></div>
					<div class="fg-input" id="add-city"></div>
				</div>
				<div class="form-group">
					<div class="fg-title">分类目的地：<i>*</i></div>
					<div class="fg-input">
						<select name="kind_id" style="width:137px;">
							<option value="0">请选择</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">选择线路：<i>*</i></div>
					<div class="fg-input">
						<input type="text" readonly="readonly" name="linename" id="clickChoiceLine" />
						<input type="hidden" name="lineId" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">图片：</div>
					<div class="fg-input">
						<input name="uploadFile" id="uploadFile" style="border:none !important" onchange="uploadImgFile(this);" type="file">
						<input name="pic" type="hidden" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" name="showorder" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">备注：</div>
					<div class="fg-input"><textarea name="beizhu" maxlength="30" placeholder="最多30个字"></textarea></div>
				</div>
				<div class="form-group">
					<div class="fg-title">是否显示：</div>
					<div class="fg-input">
						<ul>
							<li><label><input type="radio" class="fg-radio" name="is_show" value="0">否</label></li>
							<li><label><input type="radio" class="fg-radio" name="is_show" checked="checked" value="1">是</label></li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" />
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script>
var columns = [ {field : 'linename',title : '线路名称',width : '160',align : 'center'},
                {field : false,title : '线路状态',width : '80',align : 'center',formatter:function(item){
						if (item.line_status == -1) {
							return '删除';
						} else if (item.line_status == 0) {
							return '保存';
						} else if (item.line_status == 1) {
							return '审核中';
						} else if (item.line_status == 2) {
							return '正常';
						} else if (item.line_status == 3) {
							return '下架';
						} else if (item.line_status == 4) {
							return '系统退回';
						}
	                }
	            },
                {field : 'pname',title : '分类目的地',width : '75',align : 'center'},
                {field : 'cityname',title : '始发地',width : '110',align : 'center'},
                {field : false,title : '图片',width : '80',align : 'center',formatter:function(item){
						return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                    }
                },
        		{field : false ,title : '是否显示' ,width : '80' ,align : 'center',formatter:function(item){
        				return item.is_show == 1 ? '显示' : '不显示';
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '80'},
        		{field : 'beizhu',title : '备注',align : 'center',width : '80'},
        		{field : false,title : '操作',align : 'center', width : '120',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="action_type">删除</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+',1);" class="action_type">复制</a>';
        			return button;
        		}
        	}];
getData(1);
function getData(page) {
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/cfg/kind_dest_line/getDestLineData',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

function del(id) {
	layer.confirm('您确定要删除？', {btn:['确认' ,'取消']},function(){
		$.ajax({
			url:'/admin/a/cfg/kind_dest_line/delete',
			type:'post',
			dataType:'json',
			data:{'id':id},
			success:function(result) {
				if (result.code == '2000') {
					getData();
					layer.msg(result.msg, {icon: 1});
				} else {
					layer.msg(result.msg, {icon: 2});
				}
			}
		})
	});
}
var formObj = $('#add-data');
$('#add-button').click(function(){
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find('textarea').val('');
	formObj.find("input[name='is_show'][value=1]").attr("checked",true);
	formObj.find("input[name='is_modfiy'][value=1]").attr("checked",true);
	formObj.find("select").val(0);
	$("#add-city").find("select").eq(0).nextAll('select').hide();
	$('.uploadImg').remove();
	$('select[name=kind_dest_id]').remove();
	$(".fb-body,.mask-box").show();
})

$.ajax({
	url:'/common/selectData/getStartplaceJson',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#add-city').selectLinkage({
			jsonData:data,
			width:'135px',
			names:['country','province','city'],
			callback:function(obj){
				formObj.find('input[name=lineId]').val(0);
				formObj.find('#clickChoiceLine').val('');
				$('select[name=kind_id]').find('option').eq(0).nextAll().remove();
				$('select[name=kind_id]').next().remove();
				var name = $(obj).attr('name');
				var cityId = $(obj).val();
				if (name == 'city' && cityId >0){
					getKindDest(cityId);
				}
			}
		});
	}
});
function getKindDest(cityId ,kind_id ,kind_dest_id) {
	$.ajax({
		url:'/admin/a/cfg/kind_dest_line/getStartKindDest',
		dataType:'json',
		type:'post',
		data:{cityId:cityId},
		success:function(data) {
			if ($.isEmptyObject(data)) {
				alert('当前出发城市没有分类目的地，请先配置');
			} else {
				var html = '';
				$.each(data ,function(k ,v) {
					html += '<option value="'+k+'">'+v.name+'</option>';
				})
				$('select[name=kind_id]').append(html).unbind('change');
				$('select[name=kind_id]').change(function(){
					if (kind_dest_id < 1) {
						formObj.find('input[name=lineId]').val(0);
						formObj.find('#clickChoiceLine').val('');
					} 
					var kind_id = $(this).val();
					$(this).next().remove();
					if (kind_id > 0) {
						var str = '<select name="kind_dest_id" style="width:135px;"><option value="0">请选择</option>';
						$.each(data[kind_id]['lower'] ,function(key ,val) {
							str += '<option value="'+val.id+'" data-dest="'+val.dest_id+'">'+val.name+'</option>';
						})
						str += '</select>';
						$('select[name=kind_id]').after(str);
						if (typeof kind_dest_id != 'undefined' && kind_dest_id > 0) {
							$('select[name=kind_dest_id]').val(kind_dest_id);
						} else {
							$('select[name=kind_dest_id]').change(function(){
								formObj.find('input[name=lineId]').val(0);
								formObj.find('#clickChoiceLine').val('');
							})
						}
					}
				})
				if (typeof kind_id != 'undefined' && kind_id > 0) {
					$('select[name=kind_id]').val(kind_id).trigger('change');
				}
			}
		}
	});
}

$("#add-data").submit(function(){
	var id = $(this).find('input[name=id]').val();
	var url = id > 0 ? '/admin/a/cfg/kind_dest_line/edit' :'/admin/a/cfg/kind_dest_line/add';
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				getData();
				layer.msg(data.msg, {icon: 1});
				$(".fb-body,.mask-box").hide();
			} else {
				layer.msg(data.msg, {icon: 2});
			}
		}
	});
	return false;
})

function edit(id ,type) {
	$.ajax({
		url:'/admin/a/cfg/kind_dest_line/getDetailJson',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			if (!$.isEmptyObject(data)){
				formObj.find('select[name=country]').val(data.country).change();
				formObj.find('select[name=province]').val(data.province).change();
				formObj.find('select[name=city]').val(data.startplaceid);
				getKindDest(data.startplaceid ,data.index_kind_id ,data.index_kind_dest_id);
				
				formObj.find('input[name=linename]').val(data.linename);
				formObj.find('input[name=lineId]').val(data.line_id);
				formObj.find('input[name=showorder]').val(data.showorder);
				formObj.find('input[name=pic]').val(data.pic);
				if (type != 1) {
					formObj.find('input[name=id]').val(data.id);
				}
				formObj.find('textarea[name=beizhu]').val(data.beizhu);
				formObj.find("input[name='is_show'][value="+data.is_show+"]").attr("checked",true);
				formObj.find("input[name='is_modfiy'][value="+data.is_modfiy+"]").attr("checked",true);
				$(".uploadImg").remove();
				$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
				$(".fb-body,.mask-box").show();
			} else {
				layer.msg('请确认您选择的数据', {icon: 2});
			}
		}
	});
}

//选择线路
$('#clickChoiceLine').click(function(){
	var cityid = $('#add-city').find('select[name=city]').val();
	if (cityid < 1) {
		layer.msg('请选择始发地', {icon: 2});
		return false;
	}
	
	window.top.openWin({
		  type: 2,
		  area: ['810px', '600px'],
		  title :'选择线路',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/commonData/choice_line_view');?>"+"?startplaceid="+cityid+'&isc=1&is_all_city=1&type=1'
	});
})
//确认选择线路
function choiceLineCallback(row) {
	$('#clickChoiceLine').val(row.linename);
	formObj.find('input[name=lineId]').val(row.lineid);
}
</script>
</html>

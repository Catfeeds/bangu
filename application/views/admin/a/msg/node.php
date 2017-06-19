<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<style>
	.but button{  background: #2DC3E8;
			  border: 1px solid #ccc;
			  padding: 5px 6px;
			  border-radius: 3px;
			  cursor: pointer;
			  color: #fff;
			  margin-top: 20px;
	  		}
	</style>
</head>
<body>
    <div class="page-body" id="bodyMsg">
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>内容</label>
                                <input type="text" name="content" class="search_input" />
                            </div>
                            <div class="search_group">
                            	<input type="hidden" name="status" value="1">
                            	<input type="hidden" name="main_id" value="<?php echo $id;?>">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                    <div class="but"><button id="submit-but">确认配置节点</button></div>
                </div>
            </div> 
        </div>
    </div>
    
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script>
var mainid = "<?php echo $id?>";
var typeArr = <?php echo json_encode($typeArr);?>;



var columns = [ {field : false,title : '选择内容',width : '100',align : 'center',formatter:function(result){
						if (typeof result.step == 'string' && mainid == result.main_id) {
							return '<input type="checkbox" checked="checked" name="ids" value="'+result.id+'">';
						} else {
							return '<input type="checkbox" name="ids" value="'+result.id+'">';
						}
					}
				},
        		{field : false,title : '填写步骤',width : '120',align : 'center',formatter:function(result){
            			if (typeof result.step == 'string' && mainid == result.main_id) {
            				return '<input name="step" type="text" value="'+result.step+'" style="width:60px;">';
                		} else {
                			return '<input name="step" type="text" style="width:60px;">';
                    	}
            		}
            	},
            	{field : false,title : '选择消息接收人',width : '120',align : 'center',formatter:function(result){
	            		var typeStr = '<select name="type" ><option value="0">请选择</option>';
	            		$.each(typeArr ,function(k ,v){
		            		if (typeof result.user_type == 'string' && result.user_type == v.id) {
	            				typeStr += '<option value="'+v.id+'" selected="selected">'+v.name+'</option>';
		            		} else {
		            			typeStr += '<option value="'+v.id+'">'+v.name+'</option>';
			            	}
	            		});
	            		typeStr += '</select>';
	        			return typeStr;
	        		}
	        	},
        		{field : 'content',title : '内容',width : '760',align : 'center'}];
        	
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/msg/main/getMsgContentData',
	pageSize:30,
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});

$('#submit-but').click(function(){
	var data = new Array();
	
	$('input[name=ids]').each(function(){
		if ($(this).attr('checked') == 'checked') {
			
			var step = $(this).parent().next().find('input').val();
			var type = $(this).parent().next().next().find('select').val();
			
			if (step < 1) {
				layer.alert('请填写步骤', {icon: 2});
				return false;
			}
			if (type < 1) {
				layer.alert('请选择接收类型', {icon: 2});
				return false;
			}
			var infoArr = new Array();
			infoArr[0] = type;
			infoArr[1] = step;
			infoArr[2] = $(this).val();
			data.push(infoArr);
		}
	})
	if (!$.isEmptyObject(data)) {
		$.ajax({
			url:'/admin/a/msg/main/mainNode',
			data:{'nodeArr':data,mainid:$('input[name=main_id]').val()},
			dataType:'json',
			type:'post',
			success:function(result) {
				if (result.code == 2000) {
					var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
					parent.$("#main")[0].contentWindow.window.location.reload();
					parent.layer.close(index);
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		});
	} else {
		layer.alert('请选择消息内容', {icon: 2});
	}
})

</script>
</html>



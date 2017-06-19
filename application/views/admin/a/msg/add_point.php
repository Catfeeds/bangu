<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<style>
    	.titleHeader{ width:100%; overflow:hidden; line-height:30%; border-left:1px solid #ccc;}
		.conBox{ width:100%; overflow:hidden; line-height:30%;font-size:12px; border-left:1px solid #ccc; border-bottom:1px solid #ccc;  border-bottom: 1px solid #ccc;}
		.conBox input{ line-height:25px;}
		.conBox select{ line-height:26px; height:26px;}
		.titleHeader>div{ float:left;}
		.listConf1,.listConf2{overflow:hidden;}
		.listConf1>form>div{ float:left;}
		.listConf2>form>div{ float:left;}
		.width1{ width:10%; border:1px solid #ccc; border-bottom:none; border-left:none; box-sizing:border-box; line-height:40px; text-align:center; display: table-cell;}
		.width2{ width:20%; border:1px solid #ccc; border-bottom:none; border-left:none; box-sizing:border-box; line-height:40px; text-align:center; display: table-cell;}
		.width3{ width:60%; border:1px solid #ccc; border-bottom:none; border-left:none; box-sizing:border-box; line-height:40px; text-align:center; display: table-cell; position:relative;}
		.width4{ width:10%; border:1px solid #ccc; border-bottom:none;  border-left:none;box-sizing:border-box; line-height:40px; text-align:center; display: table-cell;}
		.rewWidth{ width:100%; overflow:hidden;}
		.listConf1 .rowLeft{ width:80%; float:left; text-align:center;}
		.listConf1 .rowRight{ width:20%;float:left; text-align:center; border-left:1px  solid #ccc; position:absolute; top:0; right:0; width:20%; bottom:0;align-items: center;display:flex;justify-content:center;}

					
		.listConf2 .rowLeft{ width:80%; float:left; line-height:40px; text-align:center; overflow-y:auto;}
		.listConf2 .rowRight{ width:20%;float:left; line-height:40px; text-align:center; border-left:1px solid #ccc;}
		.btn{ padding:2px 10px;}
		.btn1{ padding:0px 3px;}
		.row2left{ float:left; width:20%; border-right:1px solid #ccc; box-sizing:border-box;}
		.row2right{  float: left;  width: 80%;box-sizing: border-box;height: 41px;justify-content: center; align-items: center;  display: flex;}

		.borderBottom{ box-sizing:border-box;}
		.text{ text-indent:1em;}
		.longInput{ width:270px;}
		.but-list{text-align: right;}
		.but-list button{margin: 10px 10px 20px 0px;padding: 5px 7px;border: 1px solid #ccc;background: #3EAFE0;border-radius: 3px;color: #fff;cursor: pointer;}
		.row-content{ overflow:hidden;}
		.row-content select{ float:left;}
		.row-content .longInput{ float:left;margin:0 5px;}
		.row-content .btn1{ float:left;}
		.oFlex{ justify-content: center; align-items: center; display: flex; padding:5px 0;}
		.tab_contents{padding:0 !important; width: 100%; border-bottom:1px solid #ccc;}
		.aaaa{ overflow:hidden;}
		.row2right .text{ margin: 0 5px;} 
		.rowbox{ border-bottom:1px solid #ccc;}
		.sollcl{ height:450px; overflow-y: auto;}
		.fided{ position: fixed !important; z-index:1000; width:100%;}
		#search-condition{ margin-top:45px;}
    </style>
</head>
<body>
    <div class="page-body" id="bodyMsg" style="padding: 10px;">
        <div class="page_content bg_gray">      
            <div class="table_contents">
            	<form method="post" id="add-form">
                <table class="tab_contents step-content">
                	<thead>
                        <tr class="titleHeader">
                            <th class="width1">消息步骤</th>
                            <th class="width2">步骤说明</th>
                            <th class="width3">配置消息内容</th>
                            <th class="width4">操作</th>
                        </tr>
                    </thead>
                    <?php if(empty($stepArr)):?>
                    <tbody class="conBox row-step" data-val="0">
                    	<tr class="listConf1">
							<td class="width1 row-title" >第一步</td>
							<td class="width2">&nbsp;
	                    		<input type="text" name="description[]" class="text">
	                       		<input type="hidden" name="step[]" value="1">
	                       		<input type="hidden" name="key[]">
	                   		</td>
	                        <td class="width3">
	                        	<div class="rowLeft choice-content">
	                        		<div class="oFlex">
		                            	<span class="row-content">
			                            	<select name="type[]">
			                                	<option value="0">选择接收人</option>
			                                	<?php foreach($typeArr as $v):?>
			                                    <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
			                                    <?php endforeach;?>
			                                </select>
			                                <input type="text" readonly onclick="chioce_content(this);" data-type="" class="text longInput content-input" placeholder="选择消息内容">
			                                <input type="hidden" name="content_id[]">
			                                <input type="hidden" name="belong[]" value="3">
	                                        <input type="button" class="btn1" onclick="del_row_content(this);" value="删除">
		                                </span>
	                                </div>
	                            </div>
	                           	<div class="rowRight">
	                            	&nbsp;
	                            	<input type="button" value="添加" onclick="add_row(this);" class="btn">
	                            </div>
	                        </td>
	                        <td class="width4">
	                        	&nbsp;
	                            <input type="button" value="删除" onclick="del_step(this);" class="btn">
	                            <input type="hidden" name="main_id" value="<?php echo $id?>">
	                        </td>
                    	</tr>
                    </tbody>
                    <?php else:?>
                    	<?php foreach($stepArr as $v):?>
                    	<?php if (!empty($v['ordinary'])):?>
                    	<tbody class="conBox row-step" data-val="<?php echo $v['is_ts']?>">
	                    	<tr class="listConf1">
								<td class="width1 row-title" ><?php echo $titleArr[$v['step']]?></td>
								<td class="width2">&nbsp;
		                    		<input type="text" name="description[]" value="<?php echo $v['description']?>" class="text">
		                       		<input type="hidden" name="step[]" value="<?php echo $v['step']?>">
		                       		<input type="hidden" name="key[]" >
		                   		</td>
		                        <td class="width3">
		                        	<div class="rowLeft choice-content">
		                        		<?php if (!empty($v['ordinary'])):?>
		                        		<?php foreach($v['ordinary'] as $val):?>
		                        		<div class="oFlex">
			                            	<span class="row-content">
				                            	<select name="type[]">
				                                	<option value="0">选择接收人</option>
				                                	<?php foreach($typeArr as $item):?>
					                                	<?php if ($val['user_type'] == $item['id']):?>
					                                    <option value="<?php echo $item['id']?>" selected="selected"><?php echo $item['name']?></option>
					                                    <?php else:?>
					                                    <option value="<?php echo $item['id']?>" ><?php echo $item['name']?></option>
					                                    <?php endif;?>
				                                    <?php endforeach;?>
				                                </select>
				                                <input type="text" readonly onclick="chioce_content(this);" data-type="<?php echo $val['type']?>" value="<?php echo $val['content']?>" class="text longInput content-input" placeholder="选择消息内容">
				                                <input type="hidden" name="content_id[]" value="<?php echo $val['content_id']?>">
				                                <input type="hidden" name="belong[]" value="3">
		                                        <input type="button" class="btn1" onclick="del_row_content(this);" value="删除">
			                                </span>
		                                </div>
		                                <?php endforeach;?>
		                                <?php endif;?>
		                            </div>
		                           	<div class="rowRight">
		                            	&nbsp;
		                            	<input type="button" value="添加" onclick="add_row(this);" class="btn">
		                            </div>
						        </td>
		                        <td class="width4">
		                        	&nbsp;
		                            <input type="button" value="删除" onclick="del_step(this);" class="btn">
		                            <input type="hidden" name="main_id" value="<?php echo $id?>">
		                        </td>
	                    	</tr>
	                    </tbody>
	                    <?php else:?>
		                <tbody class="conBox row-step" data-val="<?php echo $v['is_ts']?>">
						    <tr class="listConf2">
						    	<td class="width1 row-title"><?php echo $titleArr[$v['step']]?></td>
						        <td class="width2">&nbsp;
						        	<input type="text" name="description[]" value="<?php echo $v['description']?>" class="text">
						      		<input type="hidden" name="step[]" value="<?php echo $v['step']?>">
						      		<input type="hidden" name="key[]">
						        </td>
						        <td class="width3">
						        	<div class="rewWidth rowbox ts-rowbox">
						            	<div class="rowLeft">
						                    <div class="row2left borderBottom">通过</div>
						                    <?php foreach($v['through'] as $val):?>
						                    <div class="row2right borderBottom">
						                   		<select name="type[]">
				                                	<option value="0">选择接收人</option>
				                                	<?php foreach($typeArr as $item):?>
					                                	<?php if ($val['user_type'] == $item['id']):?>
					                                    <option value="<?php echo $item['id']?>" selected="selected"><?php echo $item['name']?></option>
					                                    <?php else:?>
					                                    <option value="<?php echo $item['id']?>" ><?php echo $item['name']?></option>
					                                    <?php endif;?>
				                                    <?php endforeach;?>
				                                </select>
						                        <input type="text" readonly onclick="chioce_content(this);" data-type="<?php echo $val['type']?>" value="<?php echo $val['content']?>" class="text content-input" placeholder="选择消息内容">
						                        <input type="hidden" name="content_id[]" value="<?php echo $val['content_id']?>">
						                        <input type="hidden" name="belong[]" value="1">
						                        <input type="button" class="btn1" onclick="del_row_content1(this);" value="删除">
						                    </div>
						                    <?php endforeach;?>
						                </div>
						                <div class="rowRight">
						                &nbsp;
						                    <input type="button" onclick="add_row_step(this ,1);" value="添加" class="btn">
						                </div>
						            </div>
						            <div class="rewWidth ts-rowbox">
						            	<div class="rowLeft">
						                    <div class="row2left">拒绝</div>
						                    <?php foreach($v['refuse'] as $val):?>
						                    <div class="row2right">
						                   		<select name="type[]">
				                                	<option value="0">选择接收人</option>
				                                	<?php foreach($typeArr as $item):?>
					                                	<?php if ($val['user_type'] == $item['id']):?>
					                                    <option value="<?php echo $item['id']?>" selected="selected"><?php echo $item['name']?></option>
					                                    <?php else:?>
					                                    <option value="<?php echo $item['id']?>" ><?php echo $item['name']?></option>
					                                    <?php endif;?>
				                                    <?php endforeach;?>
				                                </select>
						                        <input type="text" readonly onclick="chioce_content(this);" data-type="<?php echo $val['type']?>" value="<?php echo $val['content']?>" class="text content-input" placeholder="选择消息内容">
						                        <input type="hidden" name="content_id[]" value="<?php echo $val['content_id']?>">
						                        <input type="hidden" name="belong[]" value="2">
						                        <input type="button" class="btn1" onclick="del_row_content1(this);" value="删除">
						                   	</div>
						                   	<?php endforeach;?>
						                </div>
						                <div class="rowRight">
						                &nbsp;
						                    <input type="button" value="添加" onclick="add_row_step(this ,2);" class="btn">
						                </div>
						            </div>
						        </td>
						       <td class="width4">
						            &nbsp;
						            <input type="button" value="删除" onclick="del_step(this);" class="btn">
						            <input type="hidden" name="main_id" value="<?php echo $id?>">
						        </td>
							</tr>
						</tbody> 
		                <?php endif;?>
                    	<?php endforeach;?>
                    <?php endif;?>
                </table>
                </form>
                <div class="but-list">
                    <button class="add-step">添加步骤</button>
                    <button class="submit-step">确认配置</button>
                </div>
            </div> 
        </div>
    </div>
    
<div class="fb-content sollcl" id="content-box" style="display:none;">
    <div class="box-title fided">
        <h4>选择消息内容</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <form class="search_form" method="post" id="search-condition" action="" style="margin-left: 20px;">
		<div class="search_form_box clear">
        	<div class="search_group">
            	<label>消息内容</label>
            	<input type="text" name="content" class="search_input" />
        	</div>
			<div class="search_group">
	        	<input type="submit" name="submit" class="search_button" value="搜索"/>
			</div>
		</div>
	</form>
    
    <div class="fb-form" id="dataTable" style=" margin: 20px;"></div>
</div>

<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script>
var typeArr = <?php echo json_encode($typeArr);?>;
var titleArr = <?php echo json_encode($titleArr);?>;
var typeStr = '<select name="type[]"><option value="0">选择接收人</option>';
$.each(typeArr ,function(k,v){
	typeStr += '<option value="'+v.id+'">'+v.name+'</option>';
})
typeStr += '</select>';

$('.content-input').mousemove(function(){
	if ($(this).val().length >1) {
		layer.tips($(this).val(), this, {
			  tips: [1, '#0FA6D8'] //还可配置颜色
		});
	}
})

//确认配置
$('.submit-step').click(function(){
	var step_len = $('.row-step').length;
	if (step_len == 0) {
		layer.alert('请添加消息步骤', {icon: 2});
		return false;
	}

	var isRequired = true;
	$('.row-step').each(function(){
		if ($(this).find('.content-input').length == 0) {
			isRequired = false;
		}
		var key = $(this).find('select[name="type[]"]').length;
		$(this).find('input[name="key[]"]').val(key);
	})
	if (isRequired == false) {
		layer.alert('请配置消息内容', {icon: 2});
		return false;
	}
	//验证步骤说明
	var isRequired = true;
	$('input[name="description"]').each(function(){
		if ($(this).val().length < 1) {
			isRequired = false;
		}
	})
	if (isRequired == false) {
		layer.alert('请将步骤说明填写完整', {icon: 2});
		return false;
	}
	//验证接收人
	var isRequired = true;
	$('select[name="type[]"]').each(function(){
		if ($(this).val() == 0) {
			isRequired = false;
		}
	})
	if (isRequired == false) {
		layer.alert('请将接收人选择完整', {icon: 2});
		return false;
	}
	//验证发送消息
	var isRequired = true;
	$('.content-input').each(function(){
		if ($(this).val().length < 1) {
			isRequired = false;
		}
	})
	if (isRequired == false) {
		layer.alert('请将要发送的消息选择完整', {icon: 2});
		return false;
	}
	var msg_index = layer.msg('提交中，请稍后', { icon: 16, shade: 0.8,time: 200000 });
	$.ajax({
		url:'/admin/a/msg/main/mainNode',
		data:$('#add-form').serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			layer.close(msg_index);
			if (result.code == 2000) {
				layer.confirm('消息配置成功', 
						{btn: ['确定']},
						function(index){
							layer.close(index);
							var key = parent.layer.getFrameIndex(window.name); //获取窗口索引
							parent.layer.close(key);
						}
					);
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
})

var type = {1:'点击链接完成',2:'操作审核后完成',3:'点击信息后完成'};
var columns = [{field : 'content',title : '内容',width : '580',align : 'center'},
				{field : false,title : '完成标识',width : '120',align : 'center',formatter:function(result){
						if (typeof type[result.type] == 'undefined') {
	            			return '';
	            		} else {
	            			return type[result.type];
	                	}
					}
				},
				{field : 'url',title : 'url',width : '100',align : 'center'},
				{field : false,title : '操作',align : 'center', width : '60',formatter: function(result){
						return '<a href="javascript:void(0);" data-type="'+result.type+'" data-id="'+result.id+'" data-content="'+result.content+'" onclick="chioce(this)" class="action_type">选择</a>&nbsp;';
	        		}
	        	}];

//选择发送的消息
var contentObj = '';
function chioce_content(obj) {
	contentObj = $(obj);
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/msg/main/getMsgContentData',
		pageSize:10,
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
	
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '900px',
		  shadeClose: false,
		  content: $('#content-box')
	});
	$('.layui-layer-page').css('margin-left','0px');
}
//选择消息后处理
function chioce(chioceObj) {
	var content = $(chioceObj).attr('data-content');
	var id = $(chioceObj).attr('data-id');
	var type = $(chioceObj).attr('data-type');

	//只能选择一条操作审核后完成的消息
 	var default_type = contentObj.parents('.row-step').attr('data-val')
// 	if (default_type == 1 && type ==2) {
// 		layer.alert('同步骤只可以存在一条操作审核后完成的消息', {icon: 2});
// 		return false;
// 	} else {
		contentObj.val(content).attr('data-type' ,type);
		contentObj.next('input[name="content_id[]"]').val(id);
		// 已经有操作审核后完成的消息了，则无需更改标识
		if (default_type != 1) {
			if (type == 2) {
				contentObj.parents('.row-step').attr('data-val',1);
			} else {
				contentObj.parents('.row-step').attr('data-val',0);
			}
		}
		$('.layui-layer-close').trigger('click');
// 	}
}

//目前设置消息最多十步，若消息大于十步则需要配置

$('.add-step').click(function() {
	var step_len = $('.step-content').find('.row-step').length;
	//上一步消息选择完成后才可添加
	var isComplete = true;
	if ($('.row-step').length >0) {
		if ($('.row-step').last().find('.content-input').length == 0) {
			layer.alert('请在上一步骤添加发送的消息', {icon: 2});
			return false;
		}
		$('.row-step').last().find('.content-input').each(function(){
			if ($(this).val().length <1) {
				isComplete = false;
				return false;
			}
		})
		if (isComplete == false) {
			layer.alert('请将上一步骤的消息选择完成后添加', {icon: 2});
			return false;
		}
	}
	
	if (step_len > 10) {
		layer.alert('消息最多可以有十步', {icon: 2});
	} else {
		if (step_len == 0) {
			//还没有步骤得情况
			html = addStep1(1);
			$('.step-content').append(html);
			get_title();
		} else {
			/***添加步骤需要注意：根据上一步中是否有消息是审核后完成的添加不同的步骤格式***/
			if ($('.step-content').find('.row-step').last().attr('data-val') == 0) {
				html = addStep1();
				$('.step-content').append(html);
				get_title();
			} else {
				html = addStep2();
				$('.step-content').append(html);
				get_title();
			}
		}
	}
})

//没有通过拒绝的情况
function addStep1() {
	var html = '<tbody class="conBox row-step" data-val="0">'+
					'<tr class="listConf1" >'+
						'<td class="width1 row-title" >第一步</td>'+
						'<td class="width2">&nbsp;'+
				    		'<input type="text" name="description[]" class="text">'+
				       		'<input type="hidden" name="step[]" value="1">'+
				       		'<input type="hidden" name="key[]">'+
				   		'</td>'+
				        '<td class="width3">'+
				        	'<div class="rowLeft choice-content">'+
				        		'<div class="oFlex">'+
				                	'<span class="row-content">'+
				                		typeStr+
				                        '<input type="text" readonly onclick="chioce_content(this);" data-type="" class="text longInput content-input" placeholder="选择消息内容">'+
				                        '<input type="hidden" name="content_id[]">'+
				                        '<input type="hidden" name="belong[]" value="3">'+
				                        '<input type="button" class="btn1" onclick="del_row_content(this);" value="删除">'+
				                    '</span>'+
				                '</div>'+
				            '</div>'+
				           	'<div class="rowRight">'+
				            	'&nbsp;'+
				            	'<input type="button" value="添加" onclick="add_row(this);" class="btn">'+
				            '</div>'+
				        '</td>'+
				        '<td class="width4">'+
				        	'&nbsp;'+
				            '<input type="button" value="删除" onclick="del_step(this);" class="btn">'+
				            '<input type="hidden" name="main_id" value="<?php echo $id?>">'+
				        '</td>'+
					'</tr>'+
				'</tbody>';
	return html;
}
//有通过拒绝的情况
function addStep2() {
	var html = '<tbody class="conBox row-step" data-val="0">'+
				    '<tr class="listConf2">'+
				    	'<td class="width1 row-title">第三步</td>'+
				        '<td class="width2">&nbsp;'+
				        	'<input type="text" name="description[]" class="text">'+
				      		'<input type="hidden" name="step[]" value="">'+
				      		'<input type="hidden" name="key[]">'+
				        '</td>'+
				        '<td class="width3">'+ 
				        	'<div class="rewWidth rowbox">'+
				            	'<div class="rowLeft">'+
				                    '<div class="row2left borderBottom">通过</div>'+
				                    '<div class="row2right borderBottom">'+
				                   	 typeStr+
				                       '<input type="text" readonly onclick="chioce_content(this);" data-type="" class="text content-input" placeholder="选择消息内容">'+
				                       '<input type="hidden" name="content_id[]">'+
				                       '<input type="hidden" name="belong[]" value="1">'+
				                       '<input type="button" class="btn1" onclick="del_row_content1(this);" value="删除">'+
				                    '</div>'+
				                '</div>'+
				                '<div class="rowRight">'+
				                '&nbsp;'+
				                    '<input type="button" onclick="add_row_step(this ,1);" value="添加" class="btn">'+
				                '</div>'+
				            '</div>'+
				            '<div class="rewWidth">'+
				            	'<div class="rowLeft">'+
				                    '<div class="row2left">拒绝</div>'+
				                    '<div class="row2right">'+
				                   			typeStr+
				                           '<input type="text" readonly onclick="chioce_content(this);" data-type="" class="text content-input" placeholder="选择消息内容">'+
				                           '<input type="hidden" name="content_id[]">'+
				                           '<input type="hidden" name="belong[]" value="2">'+
				                           '<input type="button" class="btn1" onclick="del_row_content1(this);" value="删除">'+
				                    	'</div>'+
				                    '</div>'+
				                '<div class="rowRight">'+
				                '&nbsp;'+
				                    '<input type="button" value="添加" onclick="add_row_step(this ,2);" class="btn">'+
				                '</div>'+
				            '</div>'+
				        '</td>'+
				       '<td class="width4">'+
				            '&nbsp;'+
				            '<input type="button" value="删除" onclick="del_step(this);" class="btn">'+
				            '<input type="hidden" name="main_id" value="<?php echo $id?>">'+
				        '</td>'+
					'</tr>'+
				'</tbody>';
	return html;
}

function del_row_content(obj) {
	$(obj).parents('.oFlex').remove();
}
function del_row_content1(obj) {
	var thuisLen = $(obj).parent().siblings(".row2right").length;
	if (thuisLen == 0) {
		thuisLen = 1;
	}
	$(obj).parent().siblings(".row2left").css("line-height",thuisLen*41-1+"px");
	$(obj).parent().parent().siblings('.rowRight').css("line-height",thuisLen*41-1+"px");
	
	$(obj).parent().remove();
}


//删除步骤
function del_step(obj) {
	$(obj).parents('.row-step').remove();
	get_title();
}

//初始化消息步骤

function get_title() {
	$('.step-content').find('.row-step').each(function(){
		var index = $(this).index();
		//var step = index+1;//当前元素的步骤
		
		$(this).find('.row-title').html(titleArr[index]);
		$(this).find('input[name="step[]"]').val(index);
	})
}

//计算高度
getHeight();
function getHeight() {
	$('.ts-rowbox').each(function(){
		var height = $(this).find('.row2right').length * 41;
		$(this).find('.row2left').css("line-height",height+"px")
		$(this).find('.rowRight').css("line-height",height+"px")
	})
}

function add_row_step(obj ,belong) {
	var thuisLen = $(obj).parent().siblings(".rowLeft").find(".row2right");
	$(obj).parent().siblings(".rowLeft").find(".row2left").css("line-height",(thuisLen.length +1)*41-1+"px");
	$(obj).parent().css("line-height",(thuisLen.length +1)*41-1+"px");
	var html ='<div class="row2right">'+
					typeStr+ 
					'<input type="text" readonly onclick="chioce_content(this);" data-type="" class="text content-input" placeholder="选择消息内容">'+
					'<input type="hidden" name="content_id[]">'+
					'<input type="hidden" name="belong[]" value="'+belong+'">'+
					'<input type="button" class="btn1" onclick="del_row_content1(this);" value="删除">'+
				'</div>';
	$(obj).parent().prev().append(html);
}

//添加消息配置
function add_row(obj) {
	var html = '<div class="oFlex">'+
					'<span class="row-content">'+
						typeStr+
						'<input type="text" class="text longInput content-input" data-type="" readonly="readonly" onclick="chioce_content(this);">'+
						'<input type="hidden" name="content_id[]" >'+
						'<input type="hidden" name="belong[]" value="3">'+
						'<input type="button" class="btn1" onclick="del_row_content(this);" value="删除">'+
					'</span>';
				'</div>';
	$(obj).parent().prev().append(html);
}
</script>
</html>



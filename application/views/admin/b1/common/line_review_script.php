<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	var page=null;
	// 查询
	jQuery(".btn-palegreen").click(function(){
		page.load();
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#user_line',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/line_review/indexData",form : '#registrationForm',// 绑定一个查询表单的ID
		columns : [{
				title : '',
				width : '30',
				align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}},

			{field : 'line_name',title : '线路',width : '250',align : 'left',
				formatter : function(value,	rowData, rowIndex){
					//return '<a href="javascript:void(0)" class="line_detail" data="'+rowData.line_id+'" >'+rowData.line_name+'</a>';
					return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.line_id+',1)" data="'+rowData.line_id+'">'+rowData.line_name+'</a>';
				}
			},
			{field : '',title : '会员',width : '80',align : 'center',
				formatter : function(value,rowData, rowIndex) {
					if(rowData.member_name==''){
						return rowData.loginname;
					 }else{
						 return rowData.member_name;
					}
				}
			},

			{field : '',title : '内容',width : '320',align : 'left',
				formatter : function(value,rowData, rowIndex) {
					if(rowData.reply1!=''){
						   return '<span><span>'+rowData.content+'</span><br><span style="color:blue" >回复:'+rowData.reply1+'</span></span>';
						}else{
						  return '<span title="'+rowData.content1+'">'+rowData.content+'</span>';
						}
				/* 	if(rowData.reply1!=''){
					   return '<span>'+rowData.content.substring(0,25)+'...</span><br><span style="color:blue" >回复:'+rowData.reply1.substring(0,25)+'...</span>';
					}else{
					  return '<span title="'+rowData.content1+'">'+rowData.content.substring(0,25)+'...</span>';
					} */
				}
			},
	/* 		{field : '',title : '',align : 'center', width : '1',
				formatter : function(value,	rowData, rowIndex){
					 if(rowData.reply1!=''){
						return '<div class="hide_info3 hide_info" style="position:relative;width:1px;display:none;"><div style="position:absolute;width:300px;min-height:40px;left:-200px;z-index:999;top:25px;background:#fff;border:2px solid #ccc;border-radius:4px;padding:10px;text-indent:0.5em;text-align:left;"><span>'+rowData.content1+'</span><br><span style="color:blue" >回复:'+rowData.reply2+'</span></div></div>';
					}else{
						return '<div class="hide_info3 hide_info" style="position:relative;width:1px;display:none;"><div style="position:absolute;width:300px;min-height:40px;left:-200px;z-index:999;top:25px;background:#fff;border:2px solid #ccc;border-radius:4px;padding:10px;text-indent:0.5em;text-align:left;">'+rowData.content1+'</div></div>';
					}
				}
			}, */
			{field : 'addtime',title : '评论时间',width : '100',align : 'center'},
			{field : 'avgscore1',title : '评分',align : 'center', width : '70'},
			{field : '',title : '操作',align : 'center', width : '80',
				formatter : function(value,rowData, rowIndex) {
					if(rowData.opare=='0'){
						return '申请中';
					}else if(rowData.opare==2){
						return '已拒绝';
					}else if(rowData.opare==1){
						return '通过';
					}else{
						return '<a href="#" data="'+rowData.comment_id+'" name="reply" >回复</a>&nbsp;&nbsp;<a href="#" data="'+rowData.comment_id+'" name="replay_data">申诉</a>';
					}

				}
			}

		]
	});
});


$(document).ready(function(){
	$(".hide_info3").parent().parent().prev().addClass("insurance_clause_txt");
});
$(document).on('mouseover', '.insurance_clause_txt', function(){
	$(this).next().find(".hide_info").show();
});
$(document).on('mouseout', '.insurance_clause_txt', function(){
	$(".hide_info").hide();
});

</script>


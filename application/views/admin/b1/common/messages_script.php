<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	var page=null;
	// 查询
	jQuery("#searchfrom").click(function(){
		page.load();
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/messages/indexData",form : '#registrationForm',// 绑定一个查询表单的ID
	columns : [{
		title : '',
		width : '30',
		align : 'center',
		formatter : function(value,rowData, rowIndex) {
			return rowIndex+1;
		}},

		{field : 'id',title : '消息编号',width : '80',align : 'center'},
		{field : '',title : '消息标题',width : '200',align : 'left',
			formatter : function(value,	rowData, rowIndex){
				return '<a href="#" data="'+rowData.id+'" name="show" >'+rowData.title+'</a> ';
			}
		},
		{field : 'addtime',title : '发布时间',width : '100',align : 'center'},
		{field : 'isread',title : '阅读状态',width : '100',align : 'center',
			formatter : function(value,	rowData, rowIndex){
				if(rowData.isread==1){
					return ' <span style="color:#0000FF">已读</span>';
				}else{
					return '<span style="color:#FF0000">未读</span>';
				}		
			}  
		},
		{field : '',title : '操作',width : '100',align : 'center',
						formatter : function(value,	rowData, rowIndex){
							return '<a href="###" data="'+rowData.id+'" id="del">删除</a>';
						}
					}
	
		
		]
	});
	  jQuery('#list').on("click", 'a[id="del"]',function(){
		 		var data=jQuery(this).attr('data');
		 		 if (!confirm("确定要删除？")) {
			            window.event.returnValue = false;
			        }else{
							$.post("<?php echo base_url()?>admin/b1/messages/del_message_data", { data:data} , function(result) {
							var result = eval('(' + result + ')');
							if(result){
									alert(result.msg);
									page.load();  
							}else{
								alert(result.msg);	
							}			  
						});	
		        }
			
		 })	
	 	jQuery('#list').on("click", 'a[name="show"]',function(){
			var data=jQuery(this).attr('data');

			layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '800px',
			  //skin: 'layui-layer-nobg', //没有背景色
			  shadeClose: false,
			  content: $('#messages_letter')
			});
			/*$(".messages_color,.messages_letter").show();
				$(".messages_close").click(function(e) {
				$(".messages_color,.messages_letter").hide();		
				});*/
				$.post("<?php echo base_url()?>admin/b1/messages/ajax_data", { data:data} , function(result) {
					  var result = eval('(' + result + ')');
					 	if(result.status==1){
						 	
							var buniess=result.mess.buniess;
							var sys=result.mess.sys;
							var sum_msg=result.mess.sum_msg;
							if(buniess==''){
								buniess=0;
							}
							if(sys==""){
								sys=0;
							}	
					 	    if(sum_msg==""){
					 	    	sum_msg=0
						 	 } 
							$('.m_buniess').html("("+buniess+")");
							$('.m_sys').html("("+sys+")");
							$('.sum_msg').html("("+sum_msg+")");
							
							$('.box-title').find('h4').html('平台公告');
						 	$('#msg_title').html('平台公告:'+result.data.title);
						 	$('#issue_addtime').html('发布时间：'+result.data.addtime);
						 	$('#issue_people').html('发布人：'+result.data.realname);
							$('#issue_content').html(result.data.content);
							page.load();
						}else{
							alert('暂无通告！');		
						}	 		  
				});	
		}); 
		jQuery('#tab').click(function(){	
			jQuery('.tab-pane').removeClass('active');
			jQuery('li[name="tabs0"]').removeClass('active');
			jQuery('#home').addClass('active');
			jQuery(this).parent().addClass('active');
			page.load();  
		}); 

	 	/*业务通知*/

		var page1=null;
		function initTab1(){
			var page=null;
			// 查询
			jQuery("#searchfrom0").click(function(){
				page1.load();
			});
			
			var data1 = '<?php echo $pageData0; ?>';
			page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data1),url : "<?php echo base_url()?>admin/b1/messages/indexData1",form : '#registrationForm0',// 绑定一个查询表单的ID
				columns : [{
					title : '',
					width : '30',
					align : 'center',
					formatter : function(value,rowData, rowIndex) {
						return rowIndex+1;
					}},

					{field : 'id',title : '消息编号',width : '80',align : 'center'},
					{field : '',title : '消息标题',width : '200',align : 'left',
						formatter : function(value,	rowData, rowIndex){
							return '<a href="#" data="'+rowData.id+'" name="show_mess" >'+rowData.title+'</a> ';
						}
					},
					{field : 'addtime',title : '发布时间',width : '100',align : 'center'},
					{field : 'read',title : '阅读状态',width : '100',align : 'center',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.read==1){
								return ' <span style="color:#0000FF">已读</span>';
							}else{
								return '<span style="color:#FF0000">未读</span>';
							}		
						} 
					},
					{field : '',title : '操作',width : '100',align : 'center',
						formatter : function(value,	rowData, rowIndex){
							return '<a href="###" data="'+rowData.id+'" id="del">删除</a>';
						}
					}
					]
				});
		}

		 jQuery('#tab0').click(function(){
				jQuery('.tab-pane').removeClass('active');
				jQuery('li[name="tabs"]').removeClass('active');
				jQuery('#home0').addClass('active');
				jQuery(this).parent().addClass('active');
				if(null==page1){
					initTab1();
				}
				page1.load(); 
			});
		 	jQuery('#list1').on("click", 'a[id="del"]',function(){
		 		var data=jQuery(this).attr('data');
		 		 if (!confirm("确定要删除？")) {
			            window.event.returnValue = false;
			        }else{
							$.post("<?php echo base_url()?>admin/b1/messages/del_data", { data:data} , function(result) {
								var result = eval('(' + result + ')');
								if(result){		
									//alert (122);
									alert(result.msg);
									page1.load();
									history.go(0);
										
								}else{
									alert(result.msg);	
								}			  
							});	
			        }
				
			 })	
	 	jQuery('#list1').on("click", 'a[name="show_mess"]',function(){
			var data=jQuery(this).attr('data');
			var type=2;
			layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '800px',
			  //skin: 'layui-layer-nobg', //没有背景色
			  shadeClose: false,
			  content: $('#messages_letter')
			});
			/*$(".messages_color,.messages_letter").show();
			$(".messages_close").click(function(e) {
			$(".messages_color,.messages_letter").hide();		
			});*/
			$.post("<?php echo base_url()?>admin/b1/messages/ajax_data", { data:data,type:type} , function(result) {
				   var result = eval('(' + result + ')');
					if(result.status==1){
						var buniess=result.mess.buniess;
						var sys=result.mess.sys;
						var sum_msg=result.mess.sum_msg;
						if(buniess==''){
							buniess=0;
						}
						if(sys==""){
							sys=0;
						}	
				 	    if(sum_msg==""){
				 	    	sum_msg=0
					 	 } 
						$('.m_buniess').html("("+buniess+")");
						$('.m_sys').html("("+sys+")");
						$('.sum_msg').html("("+sum_msg+")");
						$('.box-title').find('h4').html('业务通知');
						$('#msg_title').html('业务通知:'+result.data.title);
						$('#issue_addtime').html('发布时间：'+result.data.addtime);
						$('#issue_people').html('');
						$('#issue_content').html(result.data.content);
						page1.load();  
							
					}else{
						alert('暂无通告！');		
					}			  
			});	
	});  
});
</script>


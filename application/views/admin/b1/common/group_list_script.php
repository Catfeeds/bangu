<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script src="/assets/js/app/b1/product/product.js"></script>

<script type="text/javascript" src="/assets/ht/js/layer.js"></script>

<script type="text/javascript">
jQuery(document).ready(function(){

	function updateStatus(action,id,btn){
		 if (!confirm("确定要进行该操作？")) {
	            window.event.returnValue = false;
	        }else{
			var param = {"id":id}
			jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/'+action, data : param,success : function(response) {
					if(1==response){
						alert('操作成功！');
						jQuery(btn).click();
					}else{
						alert('操作失败，请重新操作！');
					}
				}
			});
	     }
	}
	var page0=null;
	// 第一个列表===============================================================
	//查询
	jQuery("#searchBtn0").click(function(){
		var val= $('#cityName').val();
		if(val==''){
			$('#destcity').val('');
		}
		page0.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/group_line/product_indexData",form : '#listForm',// 绑定一个查询表单的ID
				columns : [
					{field : 'linecode',title : '产品编号',width : '90',align : 'center'},

					{field : 'linename',title : '产品名称',align : 'left',
						formatter : function(value,	rowData, rowIndex){
							return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.id+',1)" data="'+rowData.id+'">'+rowData.linename+' · '+rowData.linetitle+'</a>';

						}
					},
					{field : 'startcity',title : '出发地',width : '100',align : 'center'},
					{field : '',title : '更新时间',align : 'center', width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.modtime==''){
								return rowData.addtime ;
							}else{
								return rowData.modtime ;
							}
						}
					},
					{field : 'linkman',title : '联系人',align : 'center', width : '70',
						formatter : function(value,	rowData, rowIndex){
							return rowData.linkman;
						}
					},
					{field : 'linkman',title : '联系电话',align : 'center', width : '90',
						formatter : function(value,	rowData, rowIndex){
							return rowData.link_mobile;
						}
					},
					{field : 'apl_status',title : '联盟审核状态',align : 'center', width : '90',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.apl_status==0){
								return '未申请';	
							}else if(rowData.apl_status==1){
								return '申请中';
							}else if(rowData.apl_status==2){
								return '已通过';
							}else if(rowData.apl_status==3){
								return '已拒绝';
							}    	
						}
					},
					{field : 'union_name',title : '联盟单位',align : 'center', width : '120'},

					{field : '',title : '操作',align : 'center',width : '150',
					formatter : function(value,	rowData, rowIndex){							
						var string='<a href="##" data="'+rowData.id+'" name="edit0" type="'+rowData.producttype+'" union_id="'+rowData.union_id+'">编辑</a>&nbsp;&nbsp;';
						 string=string+'<a href="##" data="'+rowData.id+'" union_id="'+rowData.union_id+'" name="commit0">提交</a>&nbsp;&nbsp;';
						 string=string+'<a href="##" name="copy0"  type="'+rowData.producttype+'"  data="'+rowData.id+'" union_id="'+rowData.union_id+'" >复制</a>&nbsp;&nbsp;';
						 string=string+'<a href="##" data="'+rowData.id+'" name="del0" union_id="'+rowData.union_id+'" >删除</a>';
						 return string;
					}
					}
				]
	});
	//复制线路
	jQuery('#list,#list1,#list2,#list3,#list4,#list5').on("click", 'a[name="copy0"]',function(){
		var id = jQuery(this).attr('data');
		 //if (!confirm("是否要复制产品编号为L"+id+'的线路')) {
		//	     window.event.returnValue = false;
		//	}else{
				var producttype=jQuery(this).attr('type');
				if(producttype==1){
					var type="group";
				}else{
					var type='';
				}
				var param = {"id":id,"type":type}
				jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/copy', data : param,success : function(response) {
						var response =eval("("+response+")");
						if(type=='group'){
							 //alert(response.msg+'"B'+response.lineid+'"');
							  layer.msg(response.msg+'"B'+response.lineid+'"', {icon: 1});
						}else{
							  layer.msg(response.msg+'"L'+response.lineid+'"', {icon: 1});
							// alert(response.msg+'"L'+response.lineid+'"');
						}
				      		
				      		 jQuery('#tab0').click();
					}
				});
		//    }
	});
	jQuery('#list,#list3').on("click", 'a[name="edit0"]',function(){
		var id = jQuery(this).attr('data');
		var producttype=jQuery(this).attr('type');

		jQuery('table').find('tr').css({ background: " none" });
		jQuery(this).parents('tr').css({ background: "#f5f5f5" });
		//window.location.href = '<?php echo base_url()?>admin/b1/product/toLineEdit?id='+id;#eee
		

		param={'id':id};
	/*	jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/is_line', data : param,success : function(response) {
			var response=eval("("+response+")");

			if(response.status=='-1'){
				//alert(response.msg);
				layer.alert(response.msg, {icon: 2,title:'提示'});
				return false;
			}else{
				if(producttype==1){ //定制团
					window.open("<?php echo base_url()?>admin/b1/group_line/toLineEdit?id="+id+'&style=1');
				}else{
					window.open("<?php echo base_url()?>admin/b1/products/toLineEdit?id="+id+'&style=0');
				}
			}
		}
		});*/
		if(producttype==1){ //定制团
			window.open("<?php echo base_url()?>admin/b1/group_line/toLineEdit?id="+id+'&style=1');
		}else{
			window.open("<?php echo base_url()?>admin/b1/products/toLineEdit?id="+id+'&style=0');
		}
	});

	jQuery('#list').on("click", 'a[name="commit0"]',function(){
		var id=jQuery(this).attr('data');
		var union_id=jQuery(this).attr('union_id');
		// if(confirm("确定要进行该操作？")) {
			var param = {"id":id,'type':1,'union_id':union_id}
			jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/commitApp', data : param,success : function(response) {
				var response=eval("("+response+")");
				if(response.status=='-1'){
					layer.msg(response.msg, {icon: 2});
					jQuery("#searchBtn0").click();
				}else {
					//alert(response.msg);
				          if(response.status==1){
				        	                  layer.msg('操作成功', {icon: 1});
						      jQuery("#searchBtn0").click();
					    }else{
					       	      layer.msg('提交失败,请重新操作', {icon: 2});
					 }
				}
			        }
			});
		//}else{

		//}
	});

	jQuery('#list').on("click", 'a[name="del0"]',function(){

		var id=jQuery(this).attr('data');
		var union_id=jQuery(this).attr('union_id');
		layer.confirm('您确定要删除该线路?删除后将无法恢复了', {btn:['确认' ,'取消']},function(){
			var param = {"id":id,'type':1,'union_id':union_id}
			jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/del', data : param,success : function(response) {
				if(response==1){
						layer.msg('删除成功', {icon: 1});
						jQuery("#searchBtn0").click();
					}else{
						layer.msg('删除失败,可能获取不到线路ID或者登录失效了,请重新操作！', {icon: 2});
					}
				}
			});
		});
	});
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content0').addClass('active');
		jQuery(this).parent().addClass('active');
		jQuery('#cityName').val('');
		jQuery('#destcity').val('');
		jQuery('#cityName0').val('');
		jQuery('#destcity0').val('');
		jQuery('#cityName2').val('');
		jQuery('#destcity2').val('');
		jQuery('#cityName3').val('');
		jQuery('#destcity3').val('');
		page0.load({"status":"0"});
	});

	var page1 = null;
	function initTab1(){
		page1=new jQuery.paging({renderTo:'#list1',url : "<?php echo base_url()?>admin/b1/group_line/product_indexData",form : '#listForm1',// 绑定一个查询表单的ID
			columns : [
				{field : 'linecode',title : '产品编号',width : '90',align : 'center'},

				{field : 'linename',title : '产品名称',align : 'left',
					formatter : function(value,	rowData, rowIndex){
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.id+',1)" data="'+rowData.id+'">'+rowData.linename+' · '+rowData.linetitle+'</a>';

					}
				},
				{field : 'startcity',title : '出发地',width : '100',align : 'center'},
				{field : 'modtime',title : '提交时间',align : 'center', width : '70',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.modtime==''){
							return rowData.addtime ;
						}else{
							return rowData.modtime ;
						}
					}
				},
				{field : 'linkman',title : '联系人',align : 'center', width : '70',
					formatter : function(value,	rowData, rowIndex){
						return rowData.linkman;
					}
				},
				{field : 'linkman',title : '联系电话',align : 'center', width : '90',
					formatter : function(value,	rowData, rowIndex){
						return rowData.link_mobile;
					}
				},
				{field : 'apl_status',title : '联盟审核状态',align : 'center', width : '90',
					formatter : function(value,rowData, rowIndex){
						if(rowData.apl_status==0){
							return '未申请';	
						}else if(rowData.apl_status==1){
							return '申请中';
						}else if(rowData.apl_status==2){
							return '已通过';
						}else if(rowData.apl_status==3){
							return '已拒绝';
						}    	
					}
				},
				{field : 'union_name',title : '联盟单位',align : 'center', width : '120'},
				{field : '',title : '操作',align : 'center',width : '110',
					formatter : function(value,rowData, rowIndex){
						var string= '<a href="##" data="'+rowData.id+'" name="cancelApp" union_id="'+rowData.union_id+'" >中断申请</a>&nbsp;&nbsp;';
						string=string+'<a href="##" name="copy0"   type="'+rowData.producttype+'" data="'+rowData.id+'" union_id="'+rowData.union_id+'" >复制</a>';
						return string;
					}
				}
			]
		});
	}
	jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content1').addClass('active');
		jQuery(this).parent().addClass('active');
		jQuery('#cityName').val('');
		jQuery('#destcity').val('');
		jQuery('#cityName0').val('');
		jQuery('#destcity0').val('');
		jQuery('#cityName2').val('');
		jQuery('#destcity2').val('');
		jQuery('#cityName3').val('');
		jQuery('#destcity3').val('');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"1"});
	});
	jQuery("#searchBtn1").click(function(){
		var val= $('#cityName0').val();
		if(val==''){
			$('#destcity0').val('');
		}
		page1.load({"status":"1"});
	});

	jQuery('#list1').on("click", 'a[name="cancelApp"]',function(){
		var id=jQuery(this).attr('data');
		var union_id=jQuery(this).attr('union_id');
		var param = {"id":id,'type':1,'union_id':union_id}
		jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/cancelApp', data : param,success : function(response) {
			var response=eval("("+response+")");
			if (response.status==1) {
				layer.msg(response.msg, {icon: 1});
				jQuery("#searchBtn1").click();
			}else{
				layer.msg(response.msg, {icon: 2});
				jQuery("#searchBtn1").click();
			}
		}
		});
	});


	var page2 = null;
	function initTab2(){
		page2=new jQuery.paging({renderTo:'#list2',url : "<?php echo base_url()?>admin/b1/group_line/product_indexData",form : '#listForm2',// 绑定一个查询表单的ID
			columns : [
				{field : 'linecode',title : '产品编号',width : '90',align : 'center'},

				{field : 'linename',title : '产品名称',align : 'left',

					formatter : function(value,rowData, rowIndex){
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.id+',1)" data="'+rowData.id+'">'+rowData.linename+' · '+rowData.linetitle+'</a>';
					}
				},
				{field : 'startcity',title : '出发地',width : '100',align : 'center'},
				{field : 'modtime',title : '核准时间',align : 'center', width : '70',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.modtime==''){
							return rowData.addtime ;
						}else{
							return rowData.modtime ;
						}
					}
				},
			/*	{field : 'linkman',title : '核准人',align : 'center', width : '70',
					formatter : function(value,	rowData, rowIndex){
						return rowData.username;
					}
				},*/
				{field : 'linkman',title : '核准人电话',align : 'center', width : '90',
					formatter : function(value,	rowData, rowIndex){
						return rowData.bmobile;
					}
				},
				{field : 'apl_status',title : '联盟审核状态',align : 'center', width : '90',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.apl_status==0){
							return '未申请';	
						}else if(rowData.apl_status==1){
							return '申请中';
						}else if(rowData.apl_status==2){
							return '已通过';
						}else if(rowData.apl_status==3){
							return '已拒绝';
						}    	
					}
				},
				{field : 'union_name',title : '联盟单位',align : 'center', width : '120'},
				{field : '',title : '操作',align : 'center',width : '180',
					formatter : function(value,	rowData, rowIndex){
						return '<a target="_blank" href="/admin/b1/group_line/line_stock?id='+rowData.id+'" title="如需修改价格,请下架后再修改">库存</a>&nbsp;&nbsp;<a data="'+rowData.id+'" union_id="'+rowData.union_id+'"  name="offline" href="##">下线</a>&nbsp;&nbsp;<a target="_blank" href="/admin/b1/product/train_expert?id='+rowData.id+'"  >管家培训</a>&nbsp;&nbsp;<a href="##" name="copy0"  type="'+rowData.producttype+'" data="'+rowData.id+'">复制</a>';
					}
				}
			]
		});
	}
	jQuery('#tab2').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content2').addClass('active');
		jQuery(this).parent().addClass('active');
		jQuery('#cityName').val('');
		jQuery('#destcity').val('');
		jQuery('#cityName0').val('');
		jQuery('#destcity0').val('');
		jQuery('#cityName2').val('');
		jQuery('#destcity2').val('');
		jQuery('#cityName3').val('');
		jQuery('#destcity3').val('');
		if(null==page2){
			initTab2();
		}
		page2.load({"status":"2"});
	});
	jQuery("#searchBtn2").click(function(){
		var val= $('#cityName2').val();
		if(val==''){
			$('#destcity2').val('');
		}
		page2.load({"status":"2"});
	});
	jQuery('#list2').on("click", 'a[name="offline"]',function(){
		var id=jQuery(this).attr('data');
		var union_id=jQuery(this).attr('union_id');
		var param = {"id":id,'type':1,'union_id':union_id}
		jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/offline', data : param,success : function(response) {
			if(response){
					layer.msg('提交成功', {icon: 1});
					jQuery("#searchBtn2").click();
				}else{
					layer.msg('提交失败,可能获取不到线路ID或者登录失效了,请重新操作！', {icon: 2});
				}
			}
		});
	});


	var page3 = null;
	function initTab3(){
		page3=new jQuery.paging({renderTo:'#list3',url : "<?php echo base_url()?>admin/b1/group_line/product_indexData",form : '#listForm3',// 绑定一个查询表单的ID
			columns : [
				{field : 'linecode',title : '产品编号',width : '90',align : 'center'},

				{field : 'linename',title : '产品名称',align : 'left',
					formatter : function(value,	rowData, rowIndex){
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.id+',1)" data="'+rowData.id+'">'+rowData.linename+' · '+rowData.linetitle+'</a>';

					}
				},
				{field : 'startcity',title : '出发地',width : '100',align : 'center'},

				{field : 'returntime',title : '退回时间',align : 'center', width : '70',
					formatter : function(value,rowData, rowIndex){
						if(rowData.modtime==''){
							return rowData.addtime ;
						}else{
							return rowData.modtime ;
						}
					}
				},
			/*	{field : 'username',title : '退回人',align : 'center', width : '70',
					formatter : function(value,rowData, rowIndex) {
                           				 return rowData.username;
					}
				},*/
				{field : 'username',title : '退回人电话',align : 'center', width : '90',
					formatter : function(value,rowData, rowIndex) {
                           				 return rowData.bmobile;
					}
				},

				{field : 'refuse_remark',title : '退回原因',align : 'center', width : '100',
					formatter : function(value,rowData, rowIndex) {
						  return '<span title="'+rowData.remark+'">'+rowData.remark.substring(0,15)+'...</span>';
					}
				},
				{field : 'apl_status',title : '联盟审核状态',align : 'center', width : '90',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.apl_status==0){
							return '未申请';	
						}else if(rowData.apl_status==1){
							return '申请中';
						}else if(rowData.apl_status==2){
							return '已通过';
						}else if(rowData.apl_status==3){
							return '已拒绝';
						}    	
					}
				},
				{field : 'union_name',title : '联盟单位',align : 'center', width : '120'},
				{field : '',title : '操作',align : 'center',width : '180',
					formatter : function(value,	rowData, rowIndex){
						
						var string='<a href="##" data="'+rowData.id+'"  type="'+rowData.producttype+'"  union_id="'+rowData.union_id+'" name="edit0" >修改</a>&nbsp;&nbsp;<a href="##" data="'+rowData.id+'" name="commit0" union_id="'+rowData.union_id+'" >再递</a>&nbsp;&nbsp;<a href="##" name="copy0" data="'+rowData.id+'"  type="'+rowData.producttype+'" >复制</a>&nbsp;&nbsp;<a href="##" data="'+rowData.id+'" name="del3" union_id="'+rowData.union_id+'" >删除</a>';
						if(rowData.status==4){
							string=string+'&nbsp;&nbsp;&nbsp;<a href="##" onclick="disbuy('+rowData.id+')" union_id="'+rowData.union_id+'" >停售</a>';
						}
						return string;
					}
				}
			]
		});
	}

	/*jQuery('#list3').on("click", 'a[name="edit0"]',function(){
		var id = jQuery(this).attr('data');
		var producttype=jQuery(this).attr('type');
		jQuery('table').find('tr').css({ background: " none" });
		jQuery(this).parents('tr').css({ background: "#f5f5f5" });
		param={'id':id};
		window.open("<?php echo base_url()?>admin/b1/products/toLineEdit?id="+id);	
		
	});*/
	jQuery('#list2').on("click", 'a[name="edit0"]',function(){
		var id = jQuery(this).attr('data');
		jQuery('table').find('tr').css({ background: " none" });
		jQuery(this).parents('tr').css({ background: "#f5f5f5" });
		//window.location.href = '<?php echo base_url()?>admin/b1/product/toLineEdit?id='+id;
		param={'id':id};
		
		window.open("<?php echo base_url()?>admin/b1/products/toLineEdit?id="+id);
		
	});
	jQuery('#list4').on("click", 'a[name="edit0"]',function(){
		var id = jQuery(this).attr('data');
		jQuery('table').find('tr').css({ background: " none" });
		jQuery(this).parents('tr').css({ background: "#f5f5f5" });
		param={'id':id};

		window.open("<?php echo base_url()?>admin/b1/products/toLineEdit?id="+id);
		
	});

	jQuery('#list3').on("click", 'a[name="commit0"]',function(){
		var id=jQuery(this).attr('data');
		var union_id=jQuery(this).attr('union_id');

		var param = {"id":id,'type':1,'union_id':union_id}
		jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/commitApp', data : param,success : function(response) {
				var response=eval("("+response+")");
				if(response.status=='-1'){
					layer.msg(response.msg, {icon: 2});
					jQuery("#searchBtn3").click();
				}else {
				    if(response.status==1){
				         layer.msg(response.msg, {icon: 1});
						 jQuery("#searchBtn3").click();
					}else{
					     layer.msg('提交失败,请重新操作', {icon: 2});
					}
			    }
			}
		});
	});
	jQuery('#tab3').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content3').addClass('active');
		jQuery(this).parent().addClass('active');
		jQuery('#cityName').val('');
		jQuery('#destcity').val('');
		jQuery('#cityName0').val('');
		jQuery('#destcity0').val('');
		jQuery('#cityName2').val('');
		jQuery('#destcity2').val('');
		jQuery('#cityName3').val('');
		jQuery('#destcity3').val('');
		if(null==page3){
			initTab3();
		}
		page3.load({"status":"3"});
	});
	jQuery('#list3').on("click", 'a[name="del3"]',function(){

		var id=jQuery(this).attr('data');
 		var union_id=jQuery(this).attr('union_id');

 		layer.confirm('您确定要删除该线路?删除后将无法恢复了', {btn:['确认' ,'取消']},function(){
			var param = {"id":id,'type':1,'union_id':union_id}
			jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/del', data : param,success : function(response) {
				    if(response==1){
						layer.msg('删除成功！', {icon: 1});
						jQuery("#searchBtn3").click();
					}else{
						layer.msg('删除失败,可能获取不到线路ID或者登录失效了,请重新操作', {icon: 2});
					}
				}
			});
 		});
	});
	jQuery("#searchBtn3").click(function(){
		var val= $('#cityName3').val();
		if(val==''){
			$('#destcity3').val('');
		}
		page3.load({"status":"3"});
	});

	//--------------------------已停售----------------------------	
	var page4 = null;
	function initTab4(){
		page4=new jQuery.paging({renderTo:'#list4',url : "<?php echo base_url()?>admin/b1/group_line/product_indexData",form : '#listForm4',// 绑定一个查询表单的ID
			columns : [
				{field : 'linecode',title : '产品编号',width : '90',align : 'center'},

				{field : 'linename',title : '产品名称',align : 'left',
					formatter : function(value,	rowData, rowIndex){
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.id+',1)" data="'+rowData.id+'">'+rowData.linename+' · '+rowData.linetitle+'</a>';
					}
				},
				{field : 'startcity',title : '出发地',width : '100',align : 'center'},

				{field : 'returntime',title : '退回时间',align : 'center', width : '70',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.modtime==''){
							return rowData.addtime ;
						}else{
							return rowData.modtime ;
						}
					}
				},
			/*	{field : 'username',title : '退回人',align : 'center', width : '70',
					formatter : function(value,rowData, rowIndex) {
                          				  return rowData.username;
					}
				},*/
				{field : 'username',title : '退回人电话',align : 'center', width : '90',
					formatter : function(value,rowData, rowIndex) {
                           				 return rowData.bmobile;
					}
				},
				{field : 'status',title : '状态',align : 'center', width : '70',
					formatter : function(value,rowData, rowIndex) {
						if(rowData.line_status==0){
							return '已停售';
						}else{            
							if(rowData.status==3){
				                  return '已拒绝';
				            }else if(rowData.status==4){
				                  return '已下线';
				            }
						}
               
					}
				},
				{field : 'refuse_remark',title : '退回原因',align : 'center', width : '100',
					formatter : function(value,rowData, rowIndex) {
						  return '<span title="'+rowData.remark+'">'+rowData.remark.substring(0,15)+'...</span>';
					}
				},
				{field : 'apl_status',title : '联盟审核状态',align : 'center', width : '90',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.apl_status==0){
							return '未申请';	
						}else if(rowData.apl_status==1){
							return '申请中';
						}else if(rowData.apl_status==2){
							return '已通过';
						}else if(rowData.apl_status==3){
							return '已拒绝';
						}    	
					}
				},
				{field : 'union_name',title : '联盟单位',align : 'center', width : '120'}
			/*	{field : '',title : '操作',align : 'center',width : '12%',
					formatter : function(value,	rowData, rowIndex){
						
						var string='<a href="##" data="'+rowData.id+'" name="edit0" >修改</a>&nbsp;&nbsp;&nbsp;<a href="##" data="'+rowData.id+'" name="commit0">再递</a>&nbsp;&nbsp;&nbsp;<a href="##" name="copy0" data="'+rowData.id+'">复制</a>&nbsp;&nbsp;&nbsp;<a href="##" data="'+rowData.id+'" name="del3">删除</a>';
						return string;
					}
				}*/
			]
		});
	}
	jQuery('#tab4').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content4').addClass('active');
		jQuery(this).parent().addClass('active');
		jQuery('#cityName').val('');
		jQuery('#destcity').val('');
		jQuery('#cityName0').val('');
		jQuery('#destcity0').val('');
		jQuery('#cityName2').val('');
		jQuery('#destcity2').val('');
		jQuery('#cityName3').val('');
		jQuery('#destcity3').val('');
		jQuery('#cityName1').val('');
		jQuery('#destcity1').val('');
		if(null==page4){
			initTab4();
		}
		page4.load({"status":"4",'line_status':0});
	})

	jQuery('#list4').on("click", 'a[name="commit0"]',function(){
		var id=jQuery(this).attr('data');
		var union_id=jQuery(this).attr('union_id');

		var param = {"id":id,'type':1,'union_id':union_id}
		jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/commitApp', data : param,success : function(response) {
				var response=eval("("+response+")");
				if(response.status=='-1'){
					layer.msg(response.msg, {icon: 2});
					jQuery("#searchBtn4").click();
				}else {
					//alert(response.msg);
			        if(response.status==1){
			        	  layer.msg(response.msg, {icon: 1});
					      jQuery("#searchBtn4").click();
				    }else{
				       	  layer.msg('提交失败,请重新操作', {icon: 2});
				    }
				}
			}
		});
	});
	jQuery('#list4').on("click", 'a[name="del3"]',function(){

         var id=jQuery(this).attr('data');
         var union_id=jQuery(this).attr('union_id');
     	layer.confirm('您确定要删除该线路?删除后将无法恢复了', {btn:['确认' ,'取消']},function(){
			var param = {"id":id,'type':1,'union_id':union_id}
			jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/del', data : param,success : function(response) {
				    if(response==1){
						layer.msg('删除成功！', {icon: 1});
						jQuery("#searchBtn4").click();
					}else{
						layer.alert('删除失败,可能获取不到线路ID或者登录失效了,请重新操作！', {icon: 2,title:'提示'});
					}
				}
			});
     	});
	});
	jQuery("#searchBtn4").click(function(){
		var val= $('#cityName4').val();
		if(val==''){
			$('#destcity4').val('');
		}
		page4.load({"status":"4"});
	});
	//-------------------------------------------------已删除----------------------------------------------------	
	var page5 = null;
	function initTab5(){
		page5=new jQuery.paging({renderTo:'#list5',url : "<?php echo base_url()?>admin/b1/group_line/product_indexData",form : '#listForm5',// 绑定一个查询表单的ID
			columns : [
				{field : 'linecode',title : '产品编号',width : '90',align : 'center'},

				{field : 'linename',title : '产品名称',align : 'left',
					formatter : function(value,	rowData, rowIndex){

						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.id+',1)" data="'+rowData.id+'">'+rowData.linename+' · '+rowData.linetitle+'</a>';

					}
				},
				{field : 'startcity',title : '出发地',width : '120',align : 'center'},

				{field : '',title : '更新时间',align : 'center', width : '100',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.modtime==''){
							return rowData.addtime ;
						}else{
							return rowData.modtime ;
						}
					}
				},
				{field : 'linkman',title : '联系人',align : 'center', width : '100',
					formatter : function(value,	rowData, rowIndex){
						return rowData.linkman;
					}
				},
				{field : 'linkman',title : '联系电话',align : 'center', width : '120',
					formatter : function(value,	rowData, rowIndex){
						return rowData.link_mobile;
					}
				},
				{field : 'apl_status',title : '联盟审核状态',align : 'center', width : '100',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.apl_status==0){
							return '未申请';	
						}else if(rowData.apl_status==1){
							return '申请中';
						}else if(rowData.apl_status==2){
							return '已通过';
						}else if(rowData.apl_status==3){
							return '已拒绝';
						}else if(rowData.apl_status==-1){
							return '已删除';
						}    	
					}
				},
				{field : 'union_name',title : '联盟单位',align : 'center', width : '140'}
		/*		{field : '',title : '操作',align : 'center',width : '12%',
					formatter : function(value,	rowData, rowIndex){
						var string= '<a href="##" data="'+rowData.id+'" name="cancelApp" union_id="'+rowData.union_id+'" >再提交</a>&nbsp;&nbsp;';
						string=string+'<a href="##" name="copy0"   type="'+rowData.producttype+'" data="'+rowData.id+'" union_id="'+rowData.union_id+'" >复制</a>';
						return string;

					}
				}*/

			]
		});
	}
	jQuery('#tab5').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#tab_content5').addClass('active');
		jQuery(this).parent().addClass('active');
		jQuery('#cityName').val('');
		jQuery('#destcity').val('');
		jQuery('#cityName0').val('');
		jQuery('#destcity0').val('');
		jQuery('#cityName1').val('');
		jQuery('#destcity1').val('');
		jQuery('#cityName2').val('');
		jQuery('#destcity2').val('');
		jQuery('#cityName3').val('');
		jQuery('#destcity3').val('');
		jQuery('#cityName4').val('');
		jQuery('#destcity4').val('');
		if(null==page5){
			initTab5();
		}
		page5.load({"status":"-1"});
	})
	jQuery("#searchBtn5").click(function(){
		var val= $('#cityName5').val();
		if(val==''){
			$('#destcity5').val('');
		}
		page5.load({"status":"-1"});
	});
	jQuery('#list5').on("click", 'a[name="cancelApp"]',function(){
		var id=jQuery(this).attr('data');
		var union_id=jQuery(this).attr('union_id');
		var param = {"id":id,'type':1,'union_id':union_id}
		jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/cancelApp', data : param,success : function(response) {
			var response=eval("("+response+")");
			if (response.status==1) {
				layer.msg(response.msg, {icon: 1});
				jQuery("#searchBtn5").click();
			}else{
				layer.msg(response.msg, {icon: 2});
				jQuery("#searchBtn5").click();
			}
		}
		});
	});

});
//线路停售
function disbuy(id){
	var param = {"id":id}
	jQuery.ajax({ type : "POST", url:'<?php echo base_url()?>admin/b1/product/disbuy', data : param,success : function(response) {
		var response=eval("("+response+")");
	 		if(response.status==1){
				layer.msg(response.msg, {icon: 1});
				jQuery("#searchBtn3").click();
			}else{
				layer.alert(response.msg, {icon: 2,title:'提示'});
			} 
		}
	});
}

</script>
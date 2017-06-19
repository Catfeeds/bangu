<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css"
	rel="stylesheet" />
<script type="text/javascript">
jQuery(document).ready(function(){
	/*全部订单 -------------------------------------------------------------------------*/
	var orderPage=null;
	// 查询
	jQuery("#searchBtn").click(function(){
		orderPage.load();
	});
	var data = '<?php echo $orderData; ?>';
	orderPage=new jQuery.paging({renderTo:'#order_list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/orderData",form : '#searchForm',// 绑定一个查询表单的ID
		columns : [
			{field : 'ordersn',title : '订单编号',width : '90',align : 'center',
				formatter : function(value,rowData, rowIndex){
					return '<a href="/admin/b1/order/order_detail?id='+rowData.id+'" target="_blank">'+rowData.ordersn+'</a>';
				}
			},
			{field : 'linesn',title : '团队编号',width : '90',align : 'center'},
			{field : 'linecode',title : '线路编号',width : '90',align : 'center'},
			{field : '',title : '线路标题',align : 'left',width : '90',
				formatter : function(value,rowData, rowIndex){
					if(rowData.line_kind==2 || rowData.line_kind==3){
						return rowData.linename;		
					}else{
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.linename+'</a>';
					}	
					
				}
			},
			{field : 'num',title : '参团人数',width : '55',align : 'center'},
			{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
			{field : 'lineday',title : '行程天数',align : 'center', width : '55'},
			{field : 'receive_price',title : '已收金额',align : 'right',sortable : true,width : '70',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.user_type==1){
						return rowData.receive_price;
					}else{
						if(rowData.ispay=='确认中'){
				              return rowData.total_price;
				        }else if(rowData.ispay=='未付款'){
				              return 0.00;
				        }else if(rowData.ispay=='已收款'){
				              return rowData.total_price;
				        }else{
					          return '';
					    }
					}
				}
			},
			/*{field : 'total_price',title : '订单金额',align : 'center',sortable : true,width : '80'},*/			
			{field : 'supplier_cost',title : '结算价',align : 'right',sortable : true,width : '70'},
			{field : 'a_balance',title : '结算申请中',align : 'right',sortable : true,width : '70'},
			{field : 'balance_money',title : '已结算',align : 'right',sortable : true,width : '70'},
			{field : 'platform_fee',title : '操作费',align : 'right',sortable : true,width : '60'},
			{field : 'un_balance',title : '未结算',align : 'right',sortable : true,width : '70'},
			{field : 'addtime',title : '下单时间',align : 'center', width : '130'},
			{field : 'user_type',title : '下单类型',align : 'center', width : '70',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.user_type==1){
						return '管家下单';
					}else{
						return '用户下单';
					}
				}
			},
			{field : 'depart_name',title : '销售部门',align : 'center', width : '90'},
			{field : 'realname',title : '销售员',align : 'center', width : '70'},
			{field : 'o_status',title : '订单状态',align : 'center', width : '80'}
	
		]
	});
	
 	jQuery('#tab').click(function(){
 		get_sch_expert("#expert_name");
 		get_sch_dest("#search-dest");  //目的地
 		get_sch_startplace("#search-city"); //出发地
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home').addClass('active');
		jQuery(this).parent().addClass('active');
		orderPage.load();	 
	}); 

	/*待留位------------------------------------------------------------------------------ */
	var page=null;
	// 查询
	jQuery("#searchBtn0").click(function(){
		page.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/indexData",form : '#searchForm0',// 绑定一个查询表单的ID
		columns : [
			{field : 'ordersn',title : '订单编号',width : '90',align : 'center',
				formatter : function(value,rowData, rowIndex){
					return '<a href="/admin/b1/order/order_detail?id='+rowData.id+'" target="_blank">'+rowData.ordersn+'</a>';
				}
			},
			{field : 'linesn',title : '团队编号',width : '90',align : 'center'},
			{field : 'linecode',title : '线路编号',width : '90',align : 'center'},
			{field : '',title : '线路标题',align : 'left',width : '90',
				formatter : function(value,rowData, rowIndex){
					if(rowData.line_kind==2 || rowData.line_kind==3){
						return rowData.linename;
					}else{
						//return '<a href="javascript:void(0)" class="line_detail" data="'+rowData.lid+'" >'+rowData.linename+'</a>';
						return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'">'+rowData.linename+'</a>';
					}
					
				}
			},
			
			{field : 'num',title : '参团人数',width : '55',align : 'center',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.unit==1){
						  return rowData.num;
					  }else{
						  return rowData.dingnum;
					  }
				}
			},
			{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
			{field : 'lineday',title : '行程天数',align : 'center', width : '55'},
			{field : 'receive_price',title : '已收金额',align : 'right',sortable : true,width : '70',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.user_type==1){
						return rowData.receive_price;
					}else{
						if(rowData.ispay==1){
				                                return rowData.total_price;
				                      }else if(rowData.ispay==0){
				                        	return 0.00;
				                      }else if(rowData.ispay==2){
				                        	return rowData.total_price;
				                      }else{
					                     return '';
					           }
					}
				}
						
			},
			/*{field : 'total_price',title : '订单金额',align : 'center',sortable : true,width : '80'},*/
			/*{field : 'ispay',title : '支付状态',align : 'center', width : '80'},*/
			//{field : 'supplier_cost',title : '结算价',align : 'center',sortable : true,width : '80'},
			{field : 'addtime',title : '下单时间',align : 'center', width : '130'},
			{field : 'user_type',title : '下单类型',align : 'center', width : '70',
				formatter : function(value,	rowData, rowIndex){
					if(rowData.user_type==1){
						return '管家下单';
					}else{
						return '用户下单';
					}
				}
			},
			{field : 'depart_name',title : '销售部门',align : 'center', width : '90'},
			{field : 'realname',title : '销售员',align : 'center', width : '70'},
			{field : 'status',title : '订单状态',align : 'center', width : '80',
				formatter : function(value,rowData, rowIndex){
					if(rowData.status==0){
						return '待确认';
					}else if(rowData.status==1){
						return '待确认';
					}else if(rowData.status==3){
						return '待确认';
					}
				}
			},
			{field : '',title : '操作',align : 'center',width : '100',
				formatter : function(value,rowData, rowIndex){
					if(rowData.user_type==0){  //用户下单
						if(rowData.status==0){
							if(rowData.ispay=='2'){
								return '<a href="#" data="'+rowData.id+'" member="'+rowData.memberid+'" expert="'+rowData.expert_id+'" name="q_order" >确认订单</a> ';
							}else if(rowData.ispay=='1'){
								return '等待平台确认收款';	
							}else{
								return '';
							}
						}else if(rowData.status==1){
							return '';
						}	
					}else if(rowData.user_type==1){
						if(rowData.status==0 || rowData.status==3){
							 var str='<a href="##"  data="'+rowData.id+'" name="b_order">确认</a>&nbsp;&nbsp;';	
							 str=str+'<a href="##"  data="'+rowData.id+'" name="dis_order">拒绝</a>';
							return str;	
						}else{
							return '';
						}	
					}else{
						return '';
					}
				}
			}
		]
	});
	
 	jQuery('#tab0').click(function(){
 		get_sch_expert("#expert_name1");
 		get_sch_dest("#search-dest1");  //目的地
 		get_sch_startplace("#search-city1"); //出发地
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load({"status":"0"});
	}); 
	//已留位
 	jQuery('#list').on("click", 'a[name="tbtd"]',function(){
		var data=jQuery(this).attr('data');
		var member=jQuery(this).attr('member');
		var expert=jQuery(this).attr('expert');
		var lineid=jQuery(this).attr('lineid');
		var usedate=jQuery(this).attr('usedate');
		var suitid=jQuery(this).attr('suitid');

	   	var status=1;
		var number='';
		var message='';
		$.post("<?php echo base_url()?>admin/b1/order/show_stock", { lineid:lineid,usedate:usedate,suitid:suitid} , function(re) { //查询库存
			var re =eval("("+re+")");
			 number=re.stock.number;
			if(number==-1){
				message="库存不限制数量";
			 }else if(number>=0){
				message="库存剩余"+number+"位";
			 }else{
				 alert(message+'请增加库存');
				 return false;
			 } 
			 if (!confirm(message+",确认余位？")) {
		           window.event.returnValue = false;
		     }else{
				$.post("<?php echo base_url()?>admin/b1/order/updata_status", { data:data,status:status,member:member,expert:expert} , function(result) {
				var result =eval("("+result+")"); 
					if(result.type==1){
						alert('余位成功！');	
						//跳到已留位
						jQuery('.tab-pane').removeClass('active');
						jQuery('li[name="tabs"]').removeClass('active');
						jQuery('#home1').addClass('active');
						jQuery('#tab1').parent().addClass('active');
						/*if(null==page1){
							initTab1();
						}*/
						$('#tab0').click();
						//page.load({"status":"0"});
					 }else if(result.type==-1){
						 alert('库存不足！');	
					 }else{
						  alert('余位失败！');		
					 }
				});
		    }        
		});
		
	}); 
	//确认订单
	jQuery('#list').on("click", 'a[name="q_order"]',function(){
		var data=jQuery(this).attr('data');
		var member=jQuery(this).attr('member');
		var expert=jQuery(this).attr('expert');		
	    	var status=4;
		if (!confirm("确认订单？")) {
	            		window.event.returnValue = false;
	     	}else{
		      $.post("<?php echo base_url()?>admin/b1/order/ajax_status", { data:data,status:status,member:member,expert:expert} , function(result) {	
		        var result =eval("("+result+")"); 
		        //alert(result.type);
	 			if(result.type==1){		
					alert('确认订单成功！');
					jQuery('.tab-pane').removeClass('active');
					jQuery('li[name="tabs"]').removeClass('active');
					jQuery('#home2').addClass('active');
					jQuery("#tab2").parent().addClass('active');
					if(null==page2){
						initTab2();
					}
					page2.load({"status":"4"});	
						
				}else{
					alert('确认订单失败！');	
				}  
			});
		}
	
	}); 
	
	/*已留位--------------------------------------------------------------------------------- */
/*	var page1=null;
	function initTab1(){
	// 查询
	 jQuery("#searchBtn1").click(function(){
		page1.load({"status":"1","status1":"2","status2":"3"});
	});
	
	page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/indexData1",form : '#searchForm1',// 绑定一个查询表单的ID
		columns : [
				{field : 'ordersn',title : '订单编号',width : '80',align : 'center',
					formatter : function(value,rowData, rowIndex){
						return '<a href="/admin/b1/order/order_detail?id='+rowData.id+'" target="_blank">'+rowData.ordersn+'</a>';
					}
				},
				{field : 'linesn',title : '团队编号',width : '80',align : 'center'},
				{field : '',title : '线路标题',align : 'center',
					formatter : function(value,rowData, rowIndex){
					  	 var url='<?php echo base_url()?>';
					  	 var cityArr=rowData.overcity.split(",");
					  	 var res=$.inArray("1", cityArr); 
					   	if(res==-1){
						       url="/gn/"+rowData.lid;
						}else{
							   url="/cj/"+rowData.lid;
						} 
						return '<a href="'+url+'" target="_blank">'+rowData.linename+'</a>';
					}
				},
				{field : 'num',title : '参团人数',width : '80',align : 'center',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.unit==1){
							  return rowData.num;
						  }else{
							  return rowData.dingnum;
						  }
					}
				},
				{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
				{field : 'lineday',title : '行程天数',align : 'center', width : '80'},
				{field : 'total_price',title : '订单金额',align : 'center',sortable : true,width : '80'},
				{field : 'ispay',title : '支付状态',align : 'center', width : '80'},
				{field : 'lefttime',title : '留位时间',align : 'center', width : '100'},
				{field : 'user_type',title : '下单类型',align : 'center', width : '100',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.user_type==1){
							return '管家下单';
						}else{
							return '用户下单';
						}
					}
				},
				{field : 'depart_name',title : '销售部门',align : 'center', width : '100'},
				{field : 'realname',title : '销售员',align : 'center', width : '100'},
				{field : 'returnstatus',title : '操作',align : 'center',width : '100',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.ispay=='已收款'){
							return '<a href="#" data="'+rowData.id+'" member="'+rowData.memberid+'" expert="'+rowData.expert_id+'" name="tbtd" >确认订单</a> ';
						}else if(rowData.ispay=='确认中'){
							return '等待平台确认收款';	
						}else{
							return '';
						}	
						
					}
				}

			]
		});
	}
 	jQuery('#list1').on("click", 'a[name="tbtd"]',function(){
		var data=jQuery(this).attr('data');
		var member=jQuery(this).attr('member');
		var expert=jQuery(this).attr('expert');		
	    	var status=4;
		if (!confirm("确认订单？")) {
	            		window.event.returnValue = false;
	     	}else{
		        	$.post("<?php echo base_url()?>admin/b1/order/ajax_status", { data:data,status:status,member:member,expert:expert} , function(result) {	
		            	var result =eval("("+result+")"); 
		            	//alert(result.type);
	 			if(result.type==1){		
					alert('确认订单成功！');
					jQuery('.tab-pane').removeClass('active');
					jQuery('li[name="tabs"]').removeClass('active');
					jQuery('#home2').addClass('active');
					jQuery("#tab2").parent().addClass('active');
					if(null==page2){
						initTab2();
					}
					page2.load({"status":"4"});		
				}else{
					alert('确认订单失败！');	
				}  
			});
		}
	
	}); 
	 jQuery('#tab1').click(function(){
	 	get_sch_expert("#expert_name2");
	 	get_sch_dest("#search-dest2");  //目的地
 		get_sch_startplace("#search-city2"); //出发地
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"1","status1":"2","status2":"3"});
	}); 
	*/

	/*已确定---------------------------------------------------------------------------------------- */
	var page2=null;
	function initTab2(){
	// 查询
		 jQuery("#searchBtn2").click(function(){
			page2.load({"status":"4"});
		});
		page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/indexData2",form : '#searchForm2',// 绑定一个查询表单的ID
			columns : [
					{field : 'ordersn',title : '订单编号',width : '90',align : 'center',
						formatter : function(value,rowData, rowIndex){
							return '<a href="/admin/b1/order/order_detail?id='+rowData.id+'" target="_blank">'+rowData.ordersn+'</a>';
						}
					},
					{field : 'linesn',title : '团队编号',width : '90',align : 'center'},
					{field : 'linecode',title : '线路编号',width : '90',align : 'center'},
					{field : '',title : '线路标题',align : 'center',width : '90',
						formatter : function(value,rowData, rowIndex){
							if(rowData.line_kind==2 || rowData.line_kind==3){
								return rowData.linename;
							}else{
								return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'" >'+rowData.linename+'</a>';
							}
						}
					},
					
					{field : 'num',title : '参团人数',width : '55',align : 'center',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.unit==1){
								  return rowData.num;
							  }else{
								  return  rowData.dingnum;
							  }
						}
					},
			
					{field : 'usedate',title : '出团日期',align : 'center', width : '130'},
					{field : 'lineday',title : '行程天数',align : 'center', width : '55'},
					{field : 'receive_price',title : '已收金额',align : 'right',sortable : true,width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.user_type==1){
								return rowData.receive_price;
							}else{
								if(rowData.ispay==1){
						               return rowData.total_price;
						        }else if(rowData.ispay==0){
						               return 0.00;
						        }else if(rowData.ispay==2){
						               return rowData.total_price;
						        }else{
							           return '';
							    }
							}
						}
					},
					/*{field : 'total_price',title : '订单金额',align : 'center',sortable : true,width : '80'},*/

				/*	{field : '',title : '已付金额',align : 'center',sortable : true,width : '80',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.ispay=='确认中'){
					                                return rowData.total_price;
					                      }else if(rowData.ispay=='未付款'){
					                        	return 0.00;
					                      }else if(rowData.ispay=='已收款'){
					                        	return rowData.total_price;
					                      }else{
						                     return '';
						           }
						}
					},*/
					{field : 'platform_fee',title : '佣金',align : 'right',sortable : true,width : '60'},
					{field : 'supplier_cost',title : '结算价',align : 'right',sortable : true,width : '80'},
					
					{field : 'a_balance',title : '结算申请中',align : 'right',sortable : true,width : '80'},
					{field : 'balance_money',title : '已结算',align : 'right',sortable : true,width : '80'},
					{field : 'un_balance',title : '未结算',align : 'right',sortable : true,width : '80'},
					/*{field : 'ispay',title : '支付状态',align : 'center', width : '80'},*/
					{field : 'confirmtime_supplier',title : '确认时间',align : 'center', width : '130'},
					{field : 'user_type',title : '下单类型',align : 'center', width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.user_type==1){
								return '管家下单';
							}else{
								return '用户下单';
							}
						}
					},
					{field : 'depart_name',title : '销售部门',align : 'center', width : '90'},
					{field : 'realname',title : '销售员',align : 'center', width : '80'}
			]
		});
	}

	 jQuery('#tab2').click(function(){
		get_sch_expert("#expert_name3");
		get_sch_dest("#search-dest3");  //目的地
 		get_sch_startplace("#search-city3"); //出发地
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home2').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page2){
			initTab2();
		}
		page2.load({"status":"4"});
	}); 
		
	/*--出团中---------------------------------------------------------------- */
	var page4=null;
	function initTab4(){
	// 查询
		 jQuery("#searchBtn4").click(function(){
			page4.load({'status':'1'});
		});
		page4=new jQuery.paging({renderTo:'#list4',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/indexData4",form : '#searchForm4',// 绑定一个查询表单的ID
			columns : [
					{field : 'ordersn',title : '订单编号',width : '90',align : 'center',
						formatter : function(value,rowData, rowIndex){
							return '<a href="/admin/b1/order/order_detail?id='+rowData.id+'" target="_blank">'+rowData.ordersn+'</a>';
						}
					},
					{field : 'linesn',title : '团队编号',width : '90',align : 'center'},
					{field : 'linecode',title : '线路编号',width : '90',align : 'center'},
					{field : '',title : '线路标题',align : 'center',width : '90',
						formatter : function(value,rowData, rowIndex){
							if(rowData.line_kind==2 || rowData.line_kind==3){
								return rowData.linename;
							}else{
								return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'" >'+rowData.linename+'</a>';
							}
						}
					},
					{field : 'num',title : '参团人数',width : '55',align : 'center',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.unit==1){
								  return rowData.num;
							  }else{
								  return rowData.dingnum;
							  }
						}
					},
					{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
					{field : 'lineday',title : '出行天数',align : 'center', width : '55'},
					/*{field : 'total_price',title : '订单金额',align : 'center',sortable : true,width : '80'},*/
					{field : 'receive_price',title : '已收金额',align : 'right',sortable : true,width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.user_type==1){
								return rowData.receive_price;
							}else{
								 if(rowData.ispay=='1'){
						              return rowData.total_price;
						         }else if(rowData.ispay=='2'){
						              return rowData.total_price;
						         }else{
							          return '0';
							     }
							}
						}
					},
					{field : 'platform_fee',title : '佣金',align : 'right',sortable : true,width : '60'},
					{field : 'supplier_cost',title : '结算价',align : 'right',sortable : true,width : '80'},
					{field : 'balance_money',title : '已结算',align : 'right',sortable : true,width : '80'},
					{field : 'un_balance',title : '未结算',align : 'right',sortable : true,width : '80'},
					/*{field : 'ispay',title : '支付状态',align : 'center', width : '80'},*/
					/*{field : 'order_status',title : '订单状态',align : 'center', width : '80'},*/
					{field : 'confirmtime_supplier',title : '确认时间',align : 'center', width : '130'},
					{field : 'user_type',title : '下单类型',align : 'center', width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.user_type==1){
								return '管家下单';
							}else{
								return '用户下单';
							}
						}
					},
					{field : 'depart_name',title : '销售部门',align : 'center', width : '90'},
					{field : 'realname',title : '销售员',align : 'center', width : '80'}	
			]
		});
	}
	 jQuery('#tab4').click(function(){
	 	get_sch_expert("#expert_name4");
	 	get_sch_dest("#search-dest4");  //目的地
 		get_sch_startplace("#search-city4"); //出发地
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#profile5').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page4){
			initTab4();
		}
		page4.load({'status':'1'});
	}); 
	 /*--行程结束------------------------------------------------------------------------------ */
	var page5=null;
	function initTab5(){
	// 查询
		 jQuery("#searchBtn5").click(function(){
			page5.load({'status':'2'});
		});
		page5=new jQuery.paging({renderTo:'#list5',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/indexData4",form : '#searchForm5',// 绑定一个查询表单的ID
			columns : [
					{field : 'ordersn',title : '订单编号',width : '90',align : 'center',
						formatter : function(value,rowData, rowIndex){
							return '<a href="/admin/b1/order/order_detail?id='+rowData.id+'" target="_blank">'+rowData.ordersn+'</a>';
						}
					},
					{field : 'linesn',title : '团队编号',width : '90',align : 'center'},
					{field : 'linecode',title : '线路编号',width : '120',align : 'center'},
					{field : '',title : '线路标题',align : 'center',width : '90',
						formatter : function(value,rowData, rowIndex){
							if(rowData.line_kind==2 || rowData.line_kind==3){
								return rowData.linename;
							}else{
								return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'" >'+rowData.linename+'</a>';
							}
						}
					},
					
					{field : 'num',title : '参团人数',width : '55',align : 'center',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.unit==1){
								  return rowData.num;
							  }else{
								  return rowData.dingnum;
							  }
						}
					},
					{field : 'usedate',title : '出团日期',align : 'center', width : '80'},
					{field : 'lineday',title : '出行天数',align : 'center', width : '55'},
					{field : 'receive_price',title : '已收金额',align : 'right',sortable : true,width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.user_type==1){
								return rowData.receive_price;
							}else{
								 if(rowData.ispay=='1'){
						               return rowData.total_price;
						         }else if(rowData.ispay=='2'){
						               return rowData.total_price;
						         }else{
							           return '0';
							     }
							}
						}
					},
					/*{field : 'total_price',title : '订单金额',align : 'center',sortable : true,width : '80'},*/
					{field : 'platform_fee',title : '佣金',align : 'right',sortable : true,width : '60'},
					{field : 'supplier_cost',title : '结算价',align : 'right',sortable : true,width : '80'},
					{field : 'balance_money',title : '已结算',align : 'right',sortable : true,width : '80'},
					{field : 'un_balance',title : '未结算',align : 'right',sortable : true,width : '80'},
					/*{field : 'ispay',title : '支付状态',align : 'center', width : '80'},*/
					{field : 'order_status',title : '订单状态',align : 'center', width : '80'},
					/*{field : 'confirmtime_supplier',title : '确认时间',align : 'center', width : '100'},*/
					{field : 'user_type',title : '下单类型',align : 'center', width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.user_type==1){
								return '管家下单';
							}else{
								return '用户下单';
							}
						}
					},
					{field : 'depart_name',title : '销售部门',align : 'center', width : '90'},
					{field : 'realname',title : '销售员',align : 'center', width : '80'}	
			]
		});
	}
	 jQuery('#tab5').click(function(){
	 	get_sch_expert("#expert_name5");
	 	get_sch_dest("#search-dest5");  //目的地
 		get_sch_startplace("#search-city5"); //出发地
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#profile6').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page5){
			initTab5();
		}
		page5.load({'status':'2'});
	}); 
	/*已取消---------------------------------------------------------------------------------------------- */
	var page3=null;
	function initTab3(){
	// 查询
		 jQuery("#searchBtn3").click(function(){
			page3.load({"status":"-4"});
		});
		page3=new jQuery.paging({renderTo:'#list3',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/indexData3",form : '#searchForm3',// 绑定一个查询表单的ID
			columns : [
			
					{field : 'ordersn',title : '订单编号',width : '90',align : 'center',
						formatter : function(value,rowData, rowIndex){
							return '<a href="/admin/b1/order/order_detail?id='+rowData.id+'" target="_blank">'+rowData.ordersn+'</a>';
						}
					},
					{field : 'linesn',title : '团队编号',width : '90',align : 'center'},
					{field : 'linecode',title : '线路编号',width : '90',align : 'center'},
					{field : '',title : '线路标题',align : 'center',width : '90',
						formatter : function(value,rowData, rowIndex){

							if(rowData.line_kind==2 || rowData.line_kind==3){
								return rowData.linename;
							}else{
								return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'" >'+rowData.linename+'</a>';
							}
						}
					},
					
					{field : 'num',title : '参团人数',width : '55',align : 'center',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.unit==1){
								  return rowData.num;
							  }else{
								  return rowData.dingnum;
							  }
						}
					},
					{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
					{field : 'lineday',title : '出行天数',align : 'center', width : '55'},
					{field : 'receive_price',title : '已收金额',align : 'right',sortable : true,width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.user_type==1){
								return rowData.receive_price;
							}else{
								 if(rowData.ispay=='2'){
						              return rowData.total_price;
						         }else{
							        if(rowData.ispay==0){
										return 0.00;
								   	}else if(rowData.ispay==1){
								    	return rowData.total_price;
									}else if(rowData.ispay==2){
										return rowData.total_price;
									}else if(rowData.ispay==3){
										return rowData.total_price;
									}else if(rowData.ispay==4){
										return rowData.total_price;
									}else{
										return '';
									}
							    }
							}

						}
					},
			/*		{field : 'first_pay',title : '已付金额',align : 'center',sortable : true,width : '80',
						formatter : function(value,	rowData, rowIndex){
								if(rowData.ispay==0){
									return 0.00;
							    }else if(rowData.ispay==1){
							    	return rowData.total_price;
								}else if(rowData.ispay==2){
									return rowData.total_price;
								}else if(rowData.ispay==3){
									return rowData.total_price;
								}else if(rowData.ispay==4){
									return rowData.total_price;
								}else{
									return '';
								}
						}    
					},*/
					/*{field : 'total_price',title : '订单金额',align : 'center',sortable : true,width : '80'},*/	
					{field : 'ispay',title : '支付状态',align : 'center', width : '80',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.ispay==0){
								return '未付款';
						    }else if(rowData.ispay==1){
						    	return '确认中';
							}else if(rowData.ispay==2){
								return '已收款';
							}else if(rowData.ispay==3){
								return '退款中';
							}else if(rowData.ispay==4){
								return '已退款';
							}else if(rowData.ispay==5){
								return '未交款';	
							}else if(rowData.ispay==6){
								return '已交款';	
							}
						} 
					},
					{field : 'ispay1',title : '退款金额',align : 'right', width : '80',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.user_type==0){
								if(rowData.ispay1=='退款中'){
									return rowData.total_price;
							   	 }else if(rowData.ispay1=='已退款'){
							    		return rowData.total_price;
								}else{ 
									return 0;
								}
							}else if(rowData.user_type==1){
								return rowData.receive_price;
							}
							
						}
					},
					{field : 'canceltime',title : '取消时间',align : 'center', width : '130'},
					{field : 'user_type',title : '下单类型',align : 'center', width : '70',
						formatter : function(value,	rowData, rowIndex){
							if(rowData.user_type==1){
								return '管家下单';
							}else{
								return '用户下单';
							}
						}
					},
					{field : 'depart_name',title : '销售部门',align : 'center', width : '90'},
					{field : 'realname',title : '销售员',align : 'center', width : '70'}
					
			]
		});
	}
	 jQuery('#tab3').click(function(){
	 	get_sch_expert("#expert_name6");
	 	get_sch_dest("#search-dest6");  //目的地
 		get_sch_startplace("#search-city6"); //出发地
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home3').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page3){
			initTab3();
		}
		page3.load({"status":"-4"});
	}); 
	  /*--改价退团------------------------------------------------------------------------------ */
	var page6=null;
	function initTab6(){
	// 查询
		 jQuery("#searchBtn6").click(function(){
			page6.load({'status':'2'});
		});
		page6=new jQuery.paging({renderTo:'#list6',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/order/indexData5",form : '#searchForm6',// 绑定一个查询表单的ID
			columns : [
				{field : 'ordersn',title : '订单编号',width : '80',align : 'center',
					formatter : function(value,rowData, rowIndex){
						return '<a href="/admin/b1/order/order_detail?id='+rowData.id+'" target="_blank">'+rowData.ordersn+'</a>';
					}
				},
				{field : 'linesn',title : '团队编号',width : '90',align : 'center'},
				{field : 'linecode',title : '线路编号',width : '60',align : 'center'},
				{field : '',title : '线路标题',align : 'center',width : '120',
					formatter : function(value,	rowData, rowIndex){

						if(rowData.line_kind==2 || rowData.line_kind==3){
							return rowData.linename;
						}else{
							return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lid+',1)" data="'+rowData.lid+'" >'+rowData.linename+'</a>';
						}
					}
				},
				{field : 'num',title : '参团人数',width : '55',align : 'center'},
				{field : 'usedate',title : '出团日期',align : 'center', width : '100'},
				{field : 'lineday',title : '行程天数',align : 'center', width : '55'},
				{field : 'receive_price',title : '已收金额',align : 'right',sortable : true,width : '70',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.user_type==1){
							return rowData.receive_price;
						}else{
							if(rowData.user_type==1){
								return rowData.receive_price;
							}else{
								 if(rowData.ispay=='1'){
						                 return rowData.total_price;
						          }else if(rowData.ispay=='2'){
						                 return rowData.total_price;
						          }else{
							             return '0';
							      }
							}
						}
					}
				},
				/*{field : 'total_price',title : '订单金额',align : 'center',sortable : true,width : '80'},*/
				{field : 'platform_fee',title : '佣金',align : 'right',sortable : true,width : '60'},
				{field : 'supplier_cost',title : '结算价',align : 'right',sortable : true,width : '70'},
				{field : 'balance_money',title : '已结算',align : 'right',sortable : true,width : '70'},
				{field : 'un_money',title : '未结算',align : 'right',sortable : true,width : '70'},
				{field : 'addtime',title : '下单时间',align : 'center', width : '130'},
				{field : 'user_type',title : '下单类型',align : 'center', width : '70',
					formatter : function(value,	rowData, rowIndex){
						if(rowData.user_type==1){
							return '管家下单';
						}else{
							return '用户下单';
						}
					}
				},
				{field : 'depart_name',title : '销售部门',align : 'center', width : '90'},
				{field : 'realname',title : '销售员',align : 'center', width : '70'},
				{field : 'o_status',title : '订单状态',align : 'center', width : '80'}
			]
		});
	}
	 jQuery('#tab6').click(function(){
	 	get_sch_expert("#expert_name7");
	 	get_sch_dest("#search-dest7");  //目的地
 		get_sch_startplace("#search-city7"); //出发地
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#profile14').addClass('active');
		jQuery(this).parent().addClass('active');
		if(null==page6){
			initTab6();
		}
		page6.load({'status':'2'});
	});
}); 

//--------------------------------------------------数据列表结束-----------------------------------------------------------------------		
	//导出文件信息--代留位
	function export_order(type){	 
		if(type==0){
		   	var formParam = jQuery('#searchForm').serialize();	
		}else if(type==1){
			var formParam = jQuery('#searchForm0').serialize();	
		}else if(type==2){
			var formParam = jQuery('#searchForm1').serialize();	
		}else if(type==3){
			var formParam = jQuery('#searchForm2').serialize();	
		}else if(type==4){
			var formParam = jQuery('#searchForm4').serialize();	
		}else if(type==5){
			var formParam = jQuery('#searchForm5').serialize();	
		}else if(type==6){
			var formParam = jQuery('#searchForm3').serialize();	
		}else if(type==7){
			var formParam = jQuery('#searchForm6').serialize();	
		}
	 	

	      	jQuery.ajax({ type : "POST",async:false, data :formParam+"&type="+type ,url : "<?php echo base_url()?>admin/b1/order/order_message", 
	       		success : function(result) {
				var file_url = eval('(' + result + ')');
				window.location.href="<?php echo base_url()?>"+file_url;	
			}
		});
	} 

</script>



<!--Page Related Scripts-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript">
<?php
$login_id='';
$this->load->library('session');
$arr=$this->session->userdata ( 'loginSupplier' );
if(!empty($arr['id'])){
	$login_id=$arr['id'];
}
?>
jQuery(document).ready(function(){
	/*新询价单 */
	var page=null;
	// 查询
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/enquiry_order/indexData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [
			/*{field : 'c_id',title : '定制单编号',width : '100',align : 'center'},*/
			{field : 'eid',title : '询价单编号',width : '100',align : 'center'},
			{field : 'startdate',title : '游玩日期',width : '150',align : 'center',
				formatter : function(value, rowData, rowIndex){
					if(value!=null && value!='' && value!='0000-00-00'){
						return ''+value+'';
					}else{
						return rowData.estimatedate;
					}
				}
			},
			{ field : 'startplace',title:'出发城市',width : '100',align : 'center'},
			{field : 'endplace',title : '目的地',width : '100',align : 'center'},
			{field : 'budget',title : '人均预算',align : 'center',sortable : true,width : '100'},
			{field : 'days',title : '游玩天数',align : 'center', width : '100'},
			{field : 'total_people',title : '出游人数',align : 'center', width : '100'},
			 {field : '',title : '管家',align : 'center', width : '200',
			 	formatter : function(value,	rowData, rowIndex){
					return rowData.realname+'/'+rowData.mobile;
				}
			 },
			 {field : 'reply_count',title : '回复数',align : 'center', width : '80'},
			{field : '',title : '操作',align : 'center',width : '100',
				formatter : function(value,	rowData, rowIndex){
					return '<a target="_blank" href="/admin/b1/enquiry_order/reply_inquiry?eid='+rowData.eid+'" data="'+rowData.eid+'" name="reply" >抢单</a> <a href="/admin/b1/enquiry_order/preview_go_inquiry?eid='+rowData.eid+'"  target="_blank">查看</a> ';
				}
			}
		]
	});

	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery(this).parent().addClass('active');
		page.load();
	});


  /*指定单*/

	var page1=null;
	function initTab1(){

		var data1 = '<?php echo $pageData1; ?>';
		page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data1),url : "<?php echo base_url()?>admin/b1/enquiry_order/indexData1",form : '#list1Form',// 绑定一个查询表单的ID
			columns : [
			/*{field : 'c_id',title : '定制单编号',width : '100',align : 'center'},*/
			{field : 'eid',title : '询价单编号',width : '100',align : 'center'},
			{field : 'startdate',title : '游玩日期',width : '150',align : 'center',
				formatter : function(value, rowData, rowIndex){
					if(value!=null && value!='' && value!='0000-00-00'){
						return ''+value+'';
					}else{
						return rowData.estimatedate;
					}
				}},
			{ field : 'startplace',title:'出发城市',width : '120',align : 'center'},
			{field : 'endplace',title : '目的地',width : '100',align : 'center'},
			{field : 'budget',title : '人均预算',align : 'center',sortable : true,width : '100'},
			{field : 'days',title : '游玩天数',align : 'center', width : '120'},
			{field : 'total_people',title : '出游人数',align : 'center', width : '100'},

			 {field : '',title : '管家',align : 'center', width : '200',
				formatter : function(value,	rowData, rowIndex){
			 		return rowData.realname+'/'+rowData.mobile;
				}
			 },
			  {field : 'reply_count',title : '回复数',align : 'center', width : '80'},
			// {field : 'isuse',title : '状态',align : 'center',width : '100',},
			{field : '',title : '操作',align : 'center', width : '200',
				formatter : function(value,	rowData, rowIndex){
					return '<a target="_blank" href="/admin/b1/enquiry_order/reply_inquiry?eid='+rowData.eid+'" data="'+rowData.eid+'" name="reply" >回复</a> <a href="/admin/b1/enquiry_order/preview_go_inquiry?eid='+rowData.eid+'"  target="_blank">查看</a> ';
				}
			}
		]
		});
	}

	 jQuery('#tab1').click(function(){

			jQuery('.tab-pane').removeClass('active');
			jQuery('li[name="tabs"]').removeClass('active');
			jQuery('#home1').addClass('active');
			jQuery(this).parent().addClass('active');
			if(null==page1){
				initTab1();
			}
			page1.load();
		});

	/*已回复*/
	var page2=null;
	function initTab2(){

		var data = '<?php echo $pageData2; ?>';
		page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/enquiry_order/indexData2",form : '#list1Form',// 绑定一个查询表单的ID
			columns : [
			/*{field : 'c_id',title : '定制单编号',width : '100',align : 'center'},*/
			{field : 'eid',title : '询价单编号',width : '100',align : 'center'},
			{field : 'startdate',title : '游玩日期',width : '150',align : 'center',
				formatter : function(value, rowData, rowIndex){
					if(value!=null && value!='' && value!='0000-00-00'){
						return ''+value+'';
					}else{
						return rowData.estimatedate;
					}
				}},
			{ field : 'startplace',title:'出发城市',width : '120',align : 'center'},
			{field : 'endplace',title : '目的地',width : '100',align : 'center'},
			{field : 'budget',title : '人均预算',align : 'center',sortable : true,width : '100'},
			{field : 'days',title : '游玩天数',align : 'center', width : '120'},
			{field : 'total_people',title : '出游人数',align : 'center', width : '100'},
			 {field : '',title : '管家',align : 'center', width : '200',
			 	formatter : function(value,	rowData, rowIndex){
					return rowData.realname+'/'+rowData.mobile;
				}
			 },
			{field : '',title : '操作',align : 'center', width : '200',
				formatter : function(value,	rowData, rowIndex){
					return '<a href="/admin/b1/enquiry_order/preview_go_inquiry?eid='+rowData.eid+'"  target="_blank">查看</a>';
				}
			}
		]
		});
	}

	 jQuery('#tab2').click(function(){
			jQuery('.tab-pane').removeClass('active');
			jQuery('li[name="tabs"]').removeClass('active');
			jQuery('#home2').addClass('active');
			jQuery(this).parent().addClass('active');
		//	page1.load();
			if(null==page2){
				initTab2();
			}
			page2.load();
		});

	/*已中标*/
	var page3=null;
	function initTab3(){

		var data = '<?php echo $pageData3; ?>';
		page3=new jQuery.paging({renderTo:'#list3',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/enquiry_order/indexData3",form : '#list1Form',// 绑定一个查询表单的ID
			columns : [
			/*{field : 'c_id',title : '定制单编号',width : '100',align : 'center'},*/
			{field : 'eid',title : '询价单编号',width : '100',align : 'center'},
			{field : 'startdate',title : '游玩日期',width : '150',align : 'center',
				formatter : function(value, rowData, rowIndex){
					if(value!=null && value!='' && value!='0000-00-00'){
						return ''+value+'';
					}else{
						return rowData.estimatedate;
					}
				}},
			{ field : 'startplace',title:'出发城市',width : '120',align : 'center'},
			{field : 'endplace',title : '目的地',width : '100',align : 'center'},
			{field : 'budget',title : '人均预算',align : 'center',sortable : true,width : '100'},
			{field : 'days',title : '游玩天数',align : 'center', width : '120'},
			{field : 'total_people',title : '出游人数',align : 'center', width : '100'},
			 {field : '',title : '管家',align : 'center', width : '200',
			 	formatter : function(value,	rowData, rowIndex){
					return rowData.realname+'/'+rowData.mobile;
				}
			 },
			{field : '',title : '操作',align : 'center', width : '200',
				formatter : function(value,rowData, rowIndex){
					if(rowData.line_id>0){
					       return '<a href="/admin/b1/enquiry_order/preview_go_inquiry?eid='+rowData.eid+'"  target="_blank">查看</a> ';
					}else{
						//onclick="return_enquiry(this)"  data="'+rowData.c_id+'" eid="'+rowData.eid+'" grabid="'+rowData.grab_id+'" expert_id="'+rowData.expert_id+'" name="return_enquiry"
						 return '<a onclick="return_enquiry(this)"  data="'+rowData.c_id+'" eid="'+rowData.eid+'" grabid="'+rowData.grab_id+'" expert_id="'+rowData.expert_id+'" name="return_enquiry" >转定制团</a>&nbsp;<a href="/admin/b1/enquiry_order/preview_go_inquiry?eid='+rowData.eid+'"  target="_blank">查看</a> ';
					}
				}
			}
		]
		});
	}

	 jQuery('#tab3').click(function(){
			jQuery('.tab-pane').removeClass('active');
			jQuery('li[name="tabs"]').removeClass('active');
			jQuery('#home3').addClass('active');
			jQuery(this).parent().addClass('active');
		//	page1.load();
			if(null==page3){
				initTab3();
			}
			page3.load();
		});


	/*已过期*/
	var page4=null;
	function initTab4(){

		var data = '<?php echo $pageData4; ?>';
		page3=new jQuery.paging({renderTo:'#list4',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/enquiry_order/indexData4",form : '#list1Form',// 绑定一个查询表单的ID
			columns : [
			/*{field : 'c_id',title : '定制单编号',width : '100',align : 'center'},*/
			{field : 'eid',title : '询价单编号',width : '100',align : 'center'},
			{field : 'startdate',title : '游玩日期',width : '150',align : 'center',
				formatter : function(value, rowData, rowIndex){
					if(value!=null && value!='' && value!='0000-00-00'){
						return ''+value+'';
					}else{
						return rowData.estimatedate;
					}
				}},
			{ field : 'startplace',title:'出发城市',width : '120',align : 'center'},
			{field : 'endplace',title : '目的地',width : '100',align : 'center'},
			{field : 'budget',title : '人均预算',align : 'center',sortable : true,width : '100'},
			{field : 'days',title : '游玩天数',align : 'center', width : '120'},
			{field : 'total_people',title : '出游人数',align : 'center', width : '100'},
			 {field : '',title : '管家',align : 'center', width : '200',
			 	formatter : function(value,	rowData, rowIndex){
					return rowData.realname+'/'+rowData.mobile;
				}
			 },
			{field : 'reply_count',title : '回复数',align : 'center',width : '80',},
			{field : '',title : '操作',align : 'center', width : '200',
				formatter : function(value,	rowData, rowIndex){
					return '<a href="/admin/b1/enquiry_order/preview_go_inquiry?eid='+rowData.eid+'"  target="_blank">查看</a>';
				}
			}
		]
		});
	}

	 jQuery('#tab4').click(function(){
			jQuery('.tab-pane').removeClass('active');
			jQuery('li[name="tabs"]').removeClass('active');
			jQuery('#home4').addClass('active');
			jQuery(this).parent().addClass('active');
		//	page1.load();
			if(null==page4){
				initTab4();
			}
			page4.load();
		});


});
</script>



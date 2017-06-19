

 <link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
 <style type="text/css">
.revertContextRight label{width: 27%;text-align: right; float: left;color: #666}
.modal-content input{padding:6px 2px;}
.modal-content label{padding-top: 3px;}
.revertContext input,.revertContext select {width: 193px;}
.revertContext b,.revertContext label{ font-weight: bold;}
.revertContextRight{ margin-top: -8px;}
.revertexplainButton input{ width: 100px}
.edit_btn{ background: #2dc3e8; color: #fff;margin:0px 3px;}
.btn_agin{margin:0px 3px;}

.col_fy{ margin-right: 20px;}
.col_bj{margin-right: 50px;}
.page-body{ padding: 20px;}

.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
.ie8_pageBox{ width:50%; float:left}
input{ line-height:100%\9;}


 </style>

<!-- /Page Breadcrumb -->
<!-- Page Header -->
 <div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                        <li><i class="fa fa-home"> </i> <a
			href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
                        <li class="active">询价单1</li>
                    </ul>
            </div>
<div class="page-body" id="bodyMsg">
	   <div class="widget">
	   	<div class="flip-scroll">
				<div class="tabbable">
					<ul id="myTab5" class="nav nav-tabs tabs-flat">
						<li  name="tabs" class="active tab-blue"><a href="###" id="tab0">询价单</a></li>
						<li name="tabs" class="tab-blue"><a href="###" id="tab1">已回复</a></li>
						<li name="tabs" class="tab-blue"><a href="###" id="tab2">已完成</a></li>
						<li name="tabs" class="tab-blue"><a href="###" id="tab3">已取消</a></li>
					</ul>
					<div class="tab-content">
					<div class="tab-pane active" id="tab_content0"><!--询价单:数据开始-->
						<div class="div_inquiry_list0">
							<!-- <button onclick="add_inquiry()">添加询价单</button> -->
							<a style="padding:5px;background:#e1e1e1;border-radius:4px; " target="_blank" href="<?php echo base_url('admin/b2/inquiry_sheet/show_add_inquiry')?>">添加询价单</a>
							<form style="margin-top:10px;" action="<?php echo base_url();?>admin/b2/inquiry_sheet/inquiry_sheet_list" id='inquiry_sheet0' name='inquiry_sheet0' method="post">
								<!-- 其他搜索条件,放在form 里面就可以了 -->
						<div id="inquiry_sheet_dataTable0"><!--列表数据显示位置--></div>
						<div class="row DTTTFooter">
						<div class="col-sm-6" >
							<div class="dataTables_info ie8_pageBox" id="editabledatatable_info">
								第
								<span class='pageNum'>0</span> /
								<span class='totalPages'>0</span> 页 ,
								<span class='totalRecords'>0</span>条记录,每页
								<label>
									<select name="pageSize" id='inquiry_sheet_Select0'
										class="form-control input-sm" >
										<option value="">
											--请选择--
										</option>
										<option value="5">
											5
										</option>
										<option value="10">
											10
										</option>
										<option value="15">
											15
										</option>
										<option value="20">
											20
										</option>
									</select>
								</label>
								条记录
							</div>
						</div>
							<div class="col-sm-6">
								<div class="dataTables_paginate paging_bootstrap">
									<!-- 分页的按钮存放 -->
									<ul class="pagination"> </ul>
								</div>
							</div>
						</div>
						</form>
						</div>
					</div><!--数据结束-->
					<div class="tab-pane" id="tab_content1"><!--已回复:数据开始-->
						<div class="div_inquiry_list1">
							<form action="<?php echo base_url();?>admin/b2/inquiry_sheet/inquiry_sheet_reply_list" id='inquiry_sheet1' name='inquiry_sheet1' method="post">
								<!-- 其他搜索条件,放在form 里面就可以了 -->
						<div id="inquiry_sheet_dataTable1"><!--列表数据显示位置--></div>
						<div class="row DTTTFooter">
						<div class="col-sm-6" >
							<div class="dataTables_info ie8_pageBox" id="editabledatatable_info">
								第
								<span class='pageNum'>0</span> /
								<span class='totalPages'>0</span> 页 ,
								<span class='totalRecords'>0</span>条记录,每页
								<label>
									<select name="pageSize" id='inquiry_sheet_Select1'
										class="form-control input-sm" >
										<option value="">
											--请选择--
										</option>
										<option value="5">
											5
										</option>
										<option value="10">
											10
										</option>
										<option value="15">
											15
										</option>
										<option value="20">
											20
										</option>
									</select>
								</label>
								条记录
							</div>
						</div>
							<div class="col-sm-6">
								<div class="dataTables_paginate paging_bootstrap">
									<!-- 分页的按钮存放 -->
									<ul class="pagination"> </ul>
								</div>
							</div>
						</div>
						</form>
						</div>
					</div><!--数据结束-->

						<div class="tab-pane" id="tab_content2"><!--已完成:数据开始-->
						<div class="div_inquiry_list2">
							<form action="<?php echo base_url();?>admin/b2/inquiry_sheet/inquiry_sheet_completed_list" id='inquiry_sheet2' name='inquiry_sheet2' method="post">
								<!-- 其他搜索条件,放在form 里面就可以了 -->
						<div id="inquiry_sheet_dataTable2"><!--列表数据显示位置--></div>
						<div class="row DTTTFooter">
						<div class="col-sm-6" >
							<div class="dataTables_info ie8_pageBox" id="editabledatatable_info">
								第
								<span class='pageNum'>0</span> /
								<span class='totalPages'>0</span> 页 ,
								<span class='totalRecords'>0</span>条记录,每页
								<label>
									<select name="pageSize" id='inquiry_sheet_Select2'
										class="form-control input-sm" >
										<option value="">
											--请选择--
										</option>
										<option value="5">
											5
										</option>
										<option value="10">
											10
										</option>
										<option value="15">
											15
										</option>
										<option value="20">
											20
										</option>
									</select>
								</label>
								条记录
							</div>
						</div>
							<div class="col-sm-6">
								<div class="dataTables_paginate paging_bootstrap">
									<!-- 分页的按钮存放 -->
									<ul class="pagination"> </ul>
								</div>
							</div>
						</div>
						</form>
						</div>
					</div><!--数据结束-->

					<div class="tab-pane" id="tab_content3"><!--已取消:数据开始-->
						<div class="div_inquiry_list3">
							<form action="<?php echo base_url();?>admin/b2/inquiry_sheet/inquiry_sheet_cancle_list" id='inquiry_sheet3' name='inquiry_sheet3' method="post">
								<!-- 其他搜索条件,放在form 里面就可以了 -->
						<div id="inquiry_sheet_dataTable3"><!--列表数据显示位置--></div>
						<div class="row DTTTFooter">
						<div class="col-sm-6" >
							<div class="dataTables_info ie8_pageBox" id="editabledatatable_info">
								第
								<span class='pageNum'>0</span> /
								<span class='totalPages'>0</span> 页 ,
								<span class='totalRecords'>0</span>条记录,每页
								<label>
									<select name="pageSize" id='inquiry_sheet_Select3'
										class="form-control input-sm" >
										<option value="">
											--请选择--
										</option>
										<option value="5">
											5
										</option>
										<option value="10">
											10
										</option>
										<option value="15">
											15
										</option>
										<option value="20">
											20
										</option>
									</select>
								</label>
								条记录
							</div>
						</div>
							<div class="col-sm-6">
								<div class="dataTables_paginate paging_bootstrap">
									<!-- 分页的按钮存放 -->
									<ul class="pagination"> </ul>
								</div>
							</div>
						</div>
						</form>
						</div>
					</div><!--数据结束-->
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

<div style="display:none;" class="bootbox modal fade in" id="inquiry_sheet_modal">
	<div class="modal-dialog">
		<div class="modal-content" style="width:900px;">
	<div class="modal-header">
		<button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
		<h4 class="modal-title">方案查看</h4>
	</div>
<div class="modal-body" >
<div class="bootbox-body" >
	<div id="inquiry_sheet_content" >

	</div>
</div>
</div>
 </div>
</div>

<div class="modal-backdrop fade in" style="display:none;" id="back_ground_modal"></div>


<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript">
	var columnArr=[];
	var tabI_index = <?php echo $tab_index?>;
	// 询价单数据
	var inquiry_sheet_columns_0=[ {field : 'eid',title : '询价单编号',width : '90',align : 'center',},
	        {field : 'c_id',title : '定制单编号',width : '90',align : 'center',},
			{field : 'startdate',title : '出行日期',width : '200',align : 'center',
			        	formatter : function(value,rowData, rowIndex){
				        	if(rowData['startdate']!=''&& rowData['startdate']!=null && rowData['startdate']!='0000-00-00'){
					        	return rowData['startdate'];
					        }else{
					        	return rowData['estimatedate'];
					}
				 }
			},
			{field : 'startplace',title : '出发城市',width : '150',align : 'center'},
			{field : 'endplace_name',title : '目的地',align : 'center', width : '200'},
			{field : 'budget',title : '希望人均预算',align : 'center', width : '200'},
			{field : 'days',title : '希望出游时长',align : 'center', width : '150'},
			{field : 'total_people',title : '总人数',align : 'center', width : '150'},
			{field : 'c_id',title : '操作',align : 'center', width : '200',
				formatter : function(value,	rowData, rowIndex){
		      	 var html = "<a target='_blank' href='<?php echo base_url()?>admin/b2/inquiry_sheet/preview_go_inquiry?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['eid']+"' class='edit' data-val='"+value+"'>"+"详情</a>";
		      	 if(rowData['e_status']==2){
		      	 	html += "<a target='_blank' href='<?php echo base_url()?>admin/b2/inquiry_sheet/show_again_order?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['eid']+"' class='edit_btn'>再次发单</a>";
		      	 }else{
		      	 	html += "<a target='_blank' href='<?php echo base_url()?>admin/b2/inquiry_sheet/edit_inquiry?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['eid']+"' class='edit_btn'>编辑</a>";
		      	 }
		      	 html +="<a onclick='cancle_inquiry_sheet(this)' class='delete' data-val='"+rowData['eid']+"''>取消</a>";
			return html;
				}
			}
		         ];
         	// 已回复数据
	var inquiry_sheet_columns_1=[ {field : 'eid',title : '询价单编号',width : '90',align : 'center'},
	        {field : 'c_id',title : '定制单编号',width : '90',align : 'center',},
			{field : 'startdate',title : '出行日期',width : '200',align : 'center',
	           	formatter : function(value,rowData, rowIndex){
		        	if(rowData['startdate']!=''&& rowData['startdate']!=null && rowData['startdate']!='0000-00-00'){
					        	return rowData['startdate'];
					        }else{
					        	return rowData['estimatedate'];
					}
		        }
			},
			{field : 'startplace',title : '出发城市',width : '150',align : 'center'},
			{field : 'endplace_name',title : '目的地',align : 'center', width : '200'},
			{field : 'budget',title : '希望人均预算',align : 'center', width : '200'},
			{field : 'days',title : '希望出游时长',align : 'center', width : '150'},
			{field : 'total_people',title : '总人数',align : 'center', width : '150'},
		/* 	 {field : 'estimatedate',title : '预估日起',align : 'center', width : '200'}, */
			 {field : 'comment_count',title : '回复数',align : 'center', width : '200'},
			{field : 'eid',title : '操作',align : 'center', width : '250',
			formatter : function(value,	rowData, rowIndex){
		      	return "<a target='_blank'  onclick='show_inquiry_sheet(this)' class='edit' data-val='"+rowData['eid']+"'>选方案</a><a class='edit' target='_blank' href='<?php echo base_url()?>admin/b2/inquiry_sheet/show_again_order?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['eid']+"'>再次发单</a><a onclick='cancle_inquiry_sheet(this)' class='delete' data-val='"+value+"''>取消</a> ";
				}
			}
		         ];
         //已完成数据
	var inquiry_sheet_columns_2=[ {field : 'eid',title : '询价单编号',width : '90',align : 'center'},
	        {field : 'c_id',title : '定制单编号',width : '90',align : 'center',},
			{field : 'startdate',title : '出行日期',width : '200',align : 'center',
	           	formatter : function(value,rowData, rowIndex){
		        	if(rowData['startdate']!=''&& rowData['startdate']!=null && rowData['startdate']!='0000-00-00'){
					        	return rowData['startdate'];
					        }else{
					        	return rowData['estimatedate'];
					}
		        }
			},
			{field : 'startplace',title : '出发城市',width : '150',align : 'center'},
			{field : 'endplace_name',title : '目的地',align : 'center', width : '200'},
			{field : 'budget',title : '希望人均预算',align : 'center', width : '200'},
			{field : 'days',title : '希望出游时长',align : 'center', width : '150'},
			{field : 'total_people',title : '总人数',align : 'center', width : '150'},
			/*  {field : 'estimatedate',title : '预估日起',align : 'center', width : '200'}, */
			 {field : 'comment_count',title : '回复数',align : 'center', width : '200'},
			{field : 'c_id',title : '操作',align : 'center', width : '250',
			formatter : function(value,	rowData, rowIndex){
		      	return "<a target='_blank' href='<?php echo base_url()?>admin/b2/inquiry_sheet/preview_go_inquiry?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['eid']+"&supplier_id="+rowData['supplier_id']+"' class='delete' data-val='"+value+"'>详情</a>";
				}
			}
		         ];
     	//已取消数据
         var inquiry_sheet_columns_3=[ {field : 'eid',title : '询价单编号',width : '90',align : 'center'},
    {field : 'c_id',title : '定制单编号',width : '90',align : 'center',},
	{field : 'startdate',title : '出行日期',width : '200',align : 'center',
       	formatter : function(value,	rowData, rowIndex){
	        	if(rowData['startdate']!=''&& rowData['startdate']!=null && rowData['startdate']!='0000-00-00'){
						        	return rowData['startdate'];
						        }else{
						        	return rowData['estimatedate'];
						}
	       	 }
   	 },
	{field : 'startplace',title : '出发城市',width : '150',align : 'center'},
	{field : 'endplace_name',title : '目的地',align : 'center', width : '200'},
	{field : 'budget',title : '希望人均预算',align : 'center', width : '200'},
	{field : 'days',title : '希望出游时长',align : 'center', width : '150'},
	{field : 'total_people',title : '总人数',align : 'center', width : '150'},
/* 	{field : 'estimatedate',title : '预估日起',align : 'center', width : '200'}, */
	 {field : 'comment_count',title : '回复数',align : 'center', width : '200'},
	 {field : 'c_id',title : '操作',align : 'center', width : '200',
		formatter : function(value,rowData, rowIndex){
		      	 var html = "<a target='_blank' href='<?php echo base_url()?>admin/b2/inquiry_sheet/preview_go_inquiry?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['eid']+"' class='edit' data-val='"+value+"'>"+"详情</a>";
				return html;
			}
	}

         ];

	columnArr[0] =   inquiry_sheet_columns_0;
	columnArr[1] =   inquiry_sheet_columns_1;
	columnArr[2] =   inquiry_sheet_columns_2;
	columnArr[3] =   inquiry_sheet_columns_3;
	var isJsonp= false ;// 是否JSONP,跨域
$(document).ready(function(){
	var loadIndex=[];//记录哪些tab 加载过
	initTableForm("#inquiry_sheet0","#inquiry_sheet_dataTable0",inquiry_sheet_columns_0,isJsonp ).load();
	loadIndex[0]=0;
	$("#myTab5 li").click(function(){
					$("#myTab5 li").removeClass("active");
					$(this).addClass("active");
					var index=$("#myTab5 li").index($(this));
					$(".tab-pane").removeClass("active");
					$(".tab-pane").eq(index).addClass("active");
					//if(loadIndex[index]!=index){
					 	initTableForm("#inquiry_sheet"+index,"#inquiry_sheet_dataTable"+index,columnArr[index],isJsonp ).load();
					/*}else{
					}*/
				 	loadIndex[index]=index;
				});
	$('#inquiry_sheet_Select0').change(function(){
		initTableForm("#inquiry_sheet0","#inquiry_sheet_dataTable0",inquiry_sheet_columns_0,isJsonp ).load();
	});
	$('#inquiry_sheet_Select1').change(function(){
		initTableForm("#inquiry_sheet1","#inquiry_sheet_dataTable1",inquiry_sheet_columns_1,isJsonp ).load();
	});
	$('#inquiry_sheet_Select2').change(function(){
		initTableForm("#inquiry_sheet2","#inquiry_sheet_dataTable2",inquiry_sheet_columns_2,isJsonp ).load();
	});
	$('#inquiry_sheet_Select3').change(function(){
		initTableForm("#inquiry_sheet3","#inquiry_sheet_dataTable3",inquiry_sheet_columns_3,isJsonp ).load();
	});


	$.post('/admin/b2/comboBox/get_destinations_data', {}, function(data) {
    var data = eval('(' + data + ')');
    var array = new Array();
    $.each(data, function(key, val) {
        array.push({
            text : val.kindname,
            value : val.id,
            jb : val.simplename,
            qp : val.enname
        });
    });
    var comboBox = new jQuery.comboBox({
        id : "#destinations",
        name : "overcity",// 隐藏的value ID字段
        query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
        selectedAfter : function(item, index) {// 选择后的事件

        },
        data : array
    });
});

	$.post('/admin/b2/comboBox/get_area_data', {}, function(data) {
    var data = eval('(' + data + ')');
    var array = new Array();
    $.each(data, function(key, val) {
        array.push({
            text : val.name,
            value : val.id,
            jb : val.simplename,
            qp : val.enname
        });
    });
        var comboBox = new jQuery.comboBox({
        id : "#destinations_s",
        name : "start_dest",// 隐藏的value ID字段
        query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
        selectedAfter : function(item, index) {// 选择后的事件

        },
        data : array
    });
});


$("#myTab5 li").eq(tabI_index).click() ;


});

		//转询价单操作表单提交
$('#go_inquiry_form_add').submit(function(){
			$.post(
				"<?php echo site_url('admin/b2/inquiry_sheet/add_inquiry');?>",
				$('#go_inquiry_form_add').serialize(),
				function(data) {
					data = eval('('+data+')');
					//console.log(data);
					if (data.status == 1) {
						alert(data.msg);
						hidden_modal();
						initTableForm("#inquiry_sheet"+1,"#inquiry_sheet_dataTable"+1,inquiry_sheet_columns,isJsonp ).load();
					} else {
						alert(data.msg);
					}
				}
			);
			return false;
		});

function add_inquiry(){
	$("#add_inquiry_sheet_modal").show();
	$("#back_ground_modal").show();
}
function show_inquiry_sheet(obj){
	var id = $(obj).attr('data-val');
	var html="";
	$.post("<?php echo base_url('admin/b2/inquiry_sheet/get_supplier_reply')?>",
		{'id':id},
		function(data){
			data = eval('('+data+')');
			if(data.length==0 || data[0]['id']==null ){
				alert('暂无方案');
				}else{
				html += "<div class='schemes'>";
				$.each(data,function(index,val){
					html += "<div class='scheme'>";
					html +=" <p>供应商资料</p><div class='supplier col_fy fl'><span>供应商姓名：</span>"+val['brand']+"</div>";
					html +="<div class='supplier col_fy fl'><span>所属企业名称：</span>"+val['company_name']+"</div>";
					html +="<div class='supplier col_fy fl'><span>负责人姓名：</span>"+val['realname']+"</div>";
					html +="<div class='supplier'><span>联系电话：</span>"+val['mobile']+"</div>";
					if(val['supplier_price']==0 || val['supplier_price']==null){
						val['supplier_price']='无';
					}
					if(val['childprice']==0 || val['childprice']==null){
						val['childprice']='无';
					}
					if(val['childnobedprice']==0 || val['childnobedprice']==null){
						val['childnobedprice']='无';
					}
					if(val['oldprice']==0 || val['oldprice']==null){
						val['oldprice'] = '无';
					}
					html +="<p style='margin-top:10px;'>供应商报价</p> <div class='supplier col_bj fl'><span>成人价：</span>"+val['supplier_price']+"￥</div>";
					html +=" <div class='supplier col_bj fl'><span>占床位小孩报价：</span>"+val['childprice']+"￥</div>";
					html +=" <div class='supplier col_bj fl'><span>不占床位小孩报价：</span>"+val['childnobedprice']+"￥</div>";
					html +=" <div class='supplier'  style='margin-top:10px;'><span>管家佣金：</span>"+val['agent_rate']+"元/人份</div>";
					html +=" <div class='supplier'><span>老人价：</span>"+val['oldprice']+"￥</div>";
					html +=" <div class='supplier'  style='margin-top:10px;'><span>描述：</span>"+val['reply']+"</div>";


					/*if(val['attachment']==null || val['attachment']==''){
						html +="<div class='operation'><div class='accessory'>附件: 暂无方案说明附件</div><button onclick='choose_this_one(this)' class='supplierON' data-val="+val['id']+"|"+val['eid']+"|"+val['s_id']+"|"+val['supplier_price']+"|"+val['childprice']+"|"+val['childnobedprice']+">选择此方案</button></div>";
					}else{
						html +="<div class='operation'><div class='accessory'>附件: <a href='<?php echo base_url()?>"+val['attachment']+"'>方案说明</a></div><button onclick='choose_this_one(this)' class='supplierON' data-val="+val['id']+"|"+val['eid']+"|"+val['s_id']+"|"+val['supplier_price']+"|"+val['childprice']+"|"+val['childnobedprice']+"|"+val['oldprice']+">选择此方案</button></div>";
					}*/

					html += "</div>";
				});
				html += "<div class='schemesButton'><button class='schemeOff' onclick='hidden_modal()'>关闭</button></div>";
				html += "</div>";
				$("#inquiry_sheet_content").html(html);
				$("#inquiry_sheet_modal").show();
				$("#back_ground_modal").show();
			}
		});

}


//隐藏弹框
function hidden_modal(){
	$("#inquiry_sheet_modal").hide();
	$("#back_ground_modal").hide();
	$("#add_inquiry_sheet_modal").hide();
	$("#reset_add_form_inquiry").trigger('click');
	$("#inquiry_sheet_content").html('');
}

function cancle_inquiry_sheet(obj){
	if(confirm('是否确定要取消?')){
		var id = $(obj).attr('data-val');
	$.post("<?php echo base_url('admin/b2/inquiry_sheet/cancle_inquiry_sheet')?>",
		{'id':id},
		function(data){
			alert(data);
			location.reload();
		});
	}

}

function choose_this_one(obj){
	var id_arr = $(obj).attr('data-val').split('|');
	$.post("<?php echo base_url('admin/b2/inquiry_sheet/choose_one')?>",
		{
			'id':id_arr[0],
			'eid':id_arr[1],
			'sid':id_arr[2],
			'price':id_arr[3],
			'childprice':id_arr[4],
			'child_nobed_price':id_arr[5],
			'old_price':id_arr[6],
		},
		function(data){
			alert(data);
			location.reload();
		});
}
$('#start_time').datepicker();
//设置一下z坐标的像素,以便在浮出层显示日历,不然显示不出来,被覆盖了
$('.datepicker').css('z-index','10000');
</script>

<style>
.page-body{ padding: 20px;}
    .input-sm{ padding: 0}
    .DTTTFooter{ background: #fff; border: 1px solid #fff; padding: 15px;}
    .fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
    .table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px;}
    .table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
    .table thead > tr > th { background: #fff; border: 1px solid #ddd;}
    .tableBox{ padding:0 10px 20px; padding-bottom: 0;}
	.form-group{ float:left}
	.ie8_input{ width:100px\9;}
	.ie8_select{ padding:5px 5px 6px 5px\9;}
	.ie8_pageBox{ width:50%\9; float:left\9}
	input{ line-height:100%\9;}
     .table>tbody>tr>td.x-grid-cell{ padding: 6px;}
</style>

<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"> </i> <a
			href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
		<li class="active">个人游记</li>
	</ul>
</div>
<div class="page-body">


<form style="margin-bottom:10px;" action="<?php echo base_url();?>admin/b2/travel/travel_list" id='travel_list' name='travel_list' method="post">
<div style="height:50px;background:#fff;padding:10px;"><a href="<?php echo base_url('admin/b2/travel/release_travel')?>" target="_blank"><span style="float:left; color:#fff; background:#09c;padding:6px 10px;border-radius:2px;"> 写游记</span></a></div>
 <div class="div_account_list">

     <div class="shadow tableBox">
        <div id="travel_list_dataTable"><!--列表数据显示位置--></div>
        <div class="row DTTTFooter">
            <div class="col-sm-6" >
                <div class="dataTables_info" id="editabledatatable_info">
                    第
                    <span class='pageNum'>0</span> /
                    <span class='totalPages'>0</span> 页 ,
                    <span class='totalRecords'>0</span>条记录,每页
                    <label>
                        <select name="pageSize" id='travel_Select'
                            class="form-control input-sm ie8_select" >
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
                <div class="dataTables_paginate paging_bootstrap" style=" pa">
                    <!-- 分页的按钮存放 -->
                    <ul class="pagination"> </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div> <!--End -->
</div>
<script type="text/javascript">
	$(document).ready(function(){
	// 列数据映射配置
	var travel_list_columns=[ {field : 'addtime',title : '发表时间',width : '150',align : 'center'},
			{field : 'title',title : '标题',width : '200',align : 'center'},
			{field : 'linename',title : '线路名称',width : '80',align : 'center',
				formatter: function(value,rowData,rowIndex){
					var html = '';
					if(value != '' && value != null &&value!=undefined){
					   html = '<span title="'+rowData.linename+'"style="min-width:120px;max-width:200px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;display:inline-block;">'+rowData.linename+'</span>';
					}else{
					   html = '<span title="'+rowData.linename+'"style="min-width:120px;max-width:200px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;display:inline-block;">空</span>';
					}
					return html;
				}
			},
			{field : 'shownum',title : '浏览量',align : 'center', width : '110'},
			{field : 'comment_count',title : '评论数',align : 'center', width : '80'},
			{field:'tn_id',title : '操作', align : 'center',width : '200',
				formatter: function(value,rowData,rowIndex){
					var html = "<a onclick='delete_travel(this)' class='delete' data-val='"+value+"'>删除</a>&nbsp&nbsp&nbsp";
				//	if(rowData['is_show']==0){
					      html += "<a target='_blank' href='<?php echo base_url('admin/b2/travel/release_travel')?>?id="+value+"' class='edit'>编辑</a>";
				//	}
					return  html;
				}
			}
		         ];
	var isJsonp= false ;// 是否JSONP,跨域
	initTableForm("#travel_list","#travel_list_dataTable",travel_list_columns,isJsonp ).load();
	$("#searchBtn").click(function(){
		initTableForm("#package_list","#package_list_dataTable",package_list_columns,isJsonp ).load();
	});
	$('#travel_Select').change(function(){
		initTableForm("#travel_list","#travel_list_dataTable",travel_list_columns,isJsonp ).load();
	});
});

 function delete_travel(obj){
 	var travel_id = $(obj).attr('data-val');
 	if(confirm('是否要删除该条游记')){
 		$.post("<?php echo base_url('admin/b2/travel/delete_travel')?>",
 		{'travel_id':travel_id},
 		function(result){
 			result = eval('('+result+')');
 			if(result.status==200){
 				alert(result.msg);
 				location.reload();
 			}else{
 				alert(result.msg);
 				return false;
 			}
 		});
 	}

 }
</script>

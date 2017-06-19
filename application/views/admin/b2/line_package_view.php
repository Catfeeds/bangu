<style type="text/css">
    .bordered-right{ padding: 0}
    .column{height: 100%; overflow: hidden; display: -webkit-box; display: -webkit-flex; display: flex; -webkit-box-orient: vertical; -webkit-flex-flow: column; flex-flow: column; }
    .boostBorder{border:1px solid #f9f9f9;}
    .boostBottom10{ padding-bottom: 10px}
    .boostmarginBottom20{ margin-bottom: 20px;}
    .boostBlue{border-top: 2px solid #2dc3e8;}
    .form-group{margin-right:15px; margin-top: 10px; margin-bottom: 0;}
    .page-body{ padding: 20px;}
    .form-group label{ height: 26px; line-height: 26px; border: 1px solid #dedede; border-right:none; padding: 0 6px; color: #666; float: left}
    .form-group input{ height:26px; line-height: 26px; padding: 0; padding-left: 10px;}
    .btn-darkorange{ margin: 0;}
    .table > thead > tr > th, .table > tbody > tr > td{ padding: 10px 5px}
    .DTTTFooter{ background-color: #fff; background-image: none;}
    .input-sm{ padding: 0}
    .page-breadcrumbs{ height: 40px;}
    .div_account_list{ padding: 20px }
    .DTTTFooter{ border: none; padding:15px}
    .dataTables_info{ margin: 0 !important; padding:0 !important}
    .fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
    .table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd;}
    .table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
    .table thead > tr > th { background: #fff; border: 1px solid #ddd;}
    .widget-body{ background: #fff;}

.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
input{ line-height:100%\9;}
.ie8_pageBox{ width:50%\9; float:left\9}
.tab_content { padding-top:0;}

.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
.tab_content { padding:0px 10px 15px;}
</style>
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
		<li class="active">定制线路</li>
	</ul>
</div>
<?php $this->load->view("admin/b2/common/dest_tree"); //加载树形目的地   ?>
<div class="page-body" style="width: auto;background:#fff;">
    <form action="<?php echo base_url();?>admin/b2/line_package/package_list" id='package_list' name='package_list' method="post">
    <!-- 其他搜索条件,放在form 里面就可以了 -->
        <div class="widget-body bordered-right formBox" style=" padding-left:10px;padding-bottom:10px;">
             <div class="form-group" style="display:inline-block;">
                <label>线路编号</label>
                <input type="text" name="line_code" value="" style="width:180px;padding:0 8px 0 7px;"  >
            </div>
            <div class="form-group" style="display:inline-block;">
                <label>线路名称</label>
                <input type="text" name="line_name" value="" style="width:180px;padding:0 8px 0 7px;"  >
            </div>
            <div class="form-group" style="display:inline-block;">
                <label>供应商:</label>
                <select name="supplier_id" class="ie8_select">
                    <option value="">--请选择--</option>
                    <?php
                        foreach($suppliers as $val){
                        echo "<option value='{$val ['id']}'>{$val ['company_name']}</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group" style="display:inline-block;">
                <label>目的地:</label>
                <input type="text" id="dest_id"  onfocus="showMenu(this.id,this.value,0,12);" onkeyup="showMenu(this.id,this.value);" placeholder="输入关键字搜索" class="search_input" style="width:180px;padding:0 8px 0 7px;" />
			     <input type="hidden" name="destid" id="input_dest" value=""/>
            </div>
        
            <div class="form-group" style="display:inline-block;;">
                <button type="button" class="btn btn-darkorange active" id="searchBtn" style="padding:3px 10px;" >搜索</button>
            </div>
        </div>
        <div class="tab_content shadow" style="padding-bottom:0">
            <div class="boostBorder">
                <div class="shadowBox">
                    <div id="package_list_dataTable">
                                <!--列表数据显示位置-->
                    </div>
                    <div class="row DTTTFooter ">
                        <div class="col-sm-6" >
                            <div class="dataTables_info ie8_pageBox" id="editabledatatable_info">
                            第
                            <span class='pageNum'>0</span> /
                            <span class='totalPages'>0</span> 页 ,
                            <span class='totalRecords'>0</span>条记录,每页
                            <label>
                                <select name="pageSize" id='package_Select' class="form-control  .ie8_select" >
                                    <option value="">--请选择--</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
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
                </div>
            </div>
         </div>
    </form>
</div> <!--End -->

<script type="text/javascript">
	$(document).ready(function(){
	// 列数据映射配置
	var package_list_columns=[ {field : 'linecode',title : '线路编号',width : '90',align : 'center'},
        {field :null,title : '线路标题',width : '300',align : 'left',
			formatter: function(value,rowData,rowIndex){
	            return "<a target='_blank' href='<?php echo base_url();?>line/"+rowData.l_id+".html'>"+rowData.linename+"</a>";
	        }
        },
        {field : 'startcity',title : '出发地',width : '80',align : 'center'},
        {field : 'modtime',title : '更新时间',width : '80',align : 'center'},
        {field : 'company_name',title : '供应商名称',align : 'center', width : '110'},
        {field : 'linkman',title : '联系人',align : 'center', width : '110'},
        {field : 'link_mobile',title : '联系电话',align : 'center', width : '80'},
        {field : 'status',title : '线路状态',align : 'center', width : '100',
            formatter: function(value,rowData,rowIndex){
                if(value==0 || value==3){
                    return '已下线';
                }else if(value==1){
                    return '审核中';
                }else{
                    return '已上线';
                }
            }
        },
        {field:'l_id',title : '操作', align : 'center',width : '100',
            formatter: function(value,rowData,rowIndex){
                return "<a href='javascript:void(0);'  onclick='show_line_detail("+value+",2)'>查看</a>";
               
            }
        }
    ];
	var isJsonp= false ;// 是否JSONP,跨域
	initTableForm("#package_list","#package_list_dataTable",package_list_columns,isJsonp ).load();
	$("#searchBtn").click(function(){
		initTableForm("#package_list","#package_list_dataTable",package_list_columns,isJsonp ).load();
	});
	$('#package_Select').change(function(){
		initTableForm("#package_list","#package_list_dataTable",package_list_columns,isJsonp ).load();
	});
});
</script>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>
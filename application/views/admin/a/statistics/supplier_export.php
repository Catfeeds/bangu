<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">供应商导出</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>所在地</label>
                                <span id="search-city"></span>
                            </div>
                            <div class="search_group">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            	<input type="button" class="search_button" id="supplier-export" value="导出"/>
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                </div>
            </div> 
        </div>
    </div>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script>
var columns = [ {field : 'company_name',title : '供应商名称',width : '120',align : 'center'},
				{field : 'brand',title : '品牌名称',width : '140',align : 'center'},
				{field : 'expert_business',title : '主营业务',width : '140',align : 'center'},
				{field : 'realname',title : '负责人',width : '95',align : 'center'},
				{field : 'mobile',title : '负责人电话',align : 'center', width : '90'},
				{field : false,title : '所在地',align : 'center', width : '200' ,formatter:function(result){
						return result.country_name+result.province_name+result.city_name;
					}
				},
				{field : 'union_name',title : '所属联盟',align : 'center', width : '200'}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/statistics/supplier_export/getSupplierData',
	pageSize:10,
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});

$.ajax({
	url:'/common/selectData/getAreaAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#search-city').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
	}
});

$('#supplier-export').click(function(){
	$.ajax({
		url:'/admin/a/statistics/supplier_export/exportExcel',
		data:$('#search-condition').serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				window.location.href=result.msg;
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
})
</script>
</html>



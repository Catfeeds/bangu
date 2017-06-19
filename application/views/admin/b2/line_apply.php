<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>价格申请</title>
<link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
<link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css')?>" rel="stylesheet" type="text/css" />
<style>
.form-group{ margin-right: 20px; float:left;}
.form-group label{ height: 24px; line-height: 24px; border: 1px solid #dedede; border-right:none; padding: 0 6px; color: #666; float: left}
.form-group input{ height: 24px; line-height: 24px; padding: 0  10px; float: left;width: 76px;}
.formBox{padding:0px;}

.page-box{text-align: right;}
.page-button{margin-top:20px;height:30px;}
.page-button li{padding: 5px 12px;border: 1px solid rgb(221, 221, 221);cursor: pointer;margin-right: 2px;list-style-type: none;float: left;}
.page-button .active-page{background:#2DC3E8;color:#fff;cursor: inherit;}
.page-button .disable-page{background: #e9e9e9;cursor: inherit;border: 1px solid #ccc;}
</style>
</head>
<body>
<div class="page-content bg_gray">
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home')?>"> 主页 </a></li>
            <li class="active">售卖线路列表</li>
        </ul>
    </div>
    <div class="page-body" id="bodyMsg" style="padding-top:0 !important;">

        <div class="table_content">
        	<ul class="nav nav-tabs tab_shadow clear">
                <li class="active tab_red"><a href="###">未申请</a></li>
                <li class="tab_red"><a href="<?php echo base_url(); ?>admin/b2/line_apply/applyed_index">已申请</a></li>
                <li class="tab_red"><a href="<?php echo base_url(); ?>admin/b2/line_apply/group_index">定制线路</a></li>
            </ul>
            <div class="tab_content">
                <!-- 抢单标签数据 -->
                <div class="table_list">
                <form id='search-condition' method="post">
               		<div class="form-inline formBox shadow" style="margin-bottom: 10px;">
               		     <div class="form-group">
		                    <label class="search_title" >线路编号:</label>
		                    <input class="search-input form-control ie8_input" type="text" name="linecode" style="width:107px" />
		                </div>
		                <div class="form-group">
		                    <label class="search_title" >线路名称:</label>
		                    <input class="search-input form-control ie8_input" type="text" name="linename" style="width:107px" />
		                </div>
		              
		                <div class="form-group">
                            <label class="search_title" >供应商名称:</label>
                            <input type="text"  name="company_name" class="form-control search-input ie8_input" style="width:107px;"/>
                        </div>
		                <div class="form-group">
                            <label class="search_title" >品牌名称:</label>
                            <input type="text"  name="brand" class="form-control search-input ie8_input" style="width:107px;"/>
                        </div>
                        <div class="form-group">
                            <label class="search_title" >目的地:</label>
                            <input type="text"  name="dest" class="form-control search-input ie8_input" onclick="showDestBaseTree(this);" style="width:107px;"/>
                       		<input type="hidden" name="destid" />
                        </div>
                        <div class="form-group">
                            <label class="search_title" >出发城市:</label>
                            <input type="text"  name="city" value="<?php echo $cityname?>" class="form-control search-input ie8_input" onclick="showStartplaceTree(this);" style="width:107px;"/>
                        	<input type="hidden" name="cityid" value="<?php echo $cityid?>" />
                        </div>
		                <div style="float: left;">
			                <input type="hidden" name="status" value="0" />
			                <input type="submit" value="搜索" class="btn btn-darkorange" style="position: relative; top: 10px; float: left;padding: 3px 5px;" />
		           		</div>
		            </div>
                    </form>
                    <div id="dataTable"><!--列表数据显示位置--></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script type="text/javascript">
var columns = [{field : 'linecode',title : '线路编号',width : '100',align : 'center'},
                {field : false,title : '线路名称',width : '150',align : 'center',formatter:function(result) {
    					return '<a href="/line/'+result.lineid+'.html" target="_blank">'+result.linename+'</a>';
                    }
                },
                {field : 'company_name',title : '供应商名称',width : '150',align : 'center'},
                {field : 'brand',title : '品牌名称',width : '140',align : 'center'},
                {field : 'cityname',title : '出发地',width : '120',align : 'center'},
                {field : 'peoplecount',title : '销量',width : '80',align : 'center'},
                {field : 'all_score',title : '积分',width : '80',align : 'center'},
                {field : false,title : '满意度',width : '80',align : 'center',formatter:function(result) {
						var num = result.satisfyscore + result.sati_vr;
						if (num >0) {
							if (num > 100) {
								return '100%';
							} else {
								return num.toFixed(2)+'%';
							}
						} else {
							return '暂无';
						}
                    }
                },
                {field : 'comment_count',title : '评论数',width : '80',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '120', formatter: function(result) {
                    	var	button = '<a href="/admin/b2/line_apply/line_detial_apply?id='+result.lineid+'" target="_blank">申请</a>&nbsp;';
                    		button += '<a href="/line/'+result.lineid+'.html#item8" target="_blank">评价</a>&nbsp;';
                    		button += '<a href="/line/'+result.lineid+'.html#item9" target="_blank">游记</a>';
    	                return  button;
                	}
    			}];

$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/b2/line_apply/get_apply_data',
	pageSize:10,
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});
</script>
</body>
</html>

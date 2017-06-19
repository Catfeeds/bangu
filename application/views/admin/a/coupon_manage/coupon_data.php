<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<?php  $this->load->view("admin/t33/common/js_view"); ?>
<!-- <link rel="stylesheet" type="text/css" href="/assets/js/magic-suggest/magicsuggest-min.css"/> -->
<link href='/assets/css/horsey.css' rel='stylesheet' type='text/css' />
<!-- <link href='/assets/css/example.css' rel='stylesheet' type='text/css' /> -->
<style type="text/css">
.page_content { margin-top:0;padding-top:5px;}
.search_form  { margin:0;}
.search_form_box .search_group label { width:auto;}
.search_group { margin-right:20px;}
.search_input { height:auto !important;line-height:23px !important;padding:0 2px !important;border:1px solid #bbb !important;font-size:13px !important;}
.search_button { margin:0;}
.table-bordered { border-collapse:collapse;}
.data_rows tr td { text-align:center !important;}

.page_content { margin-top:0;}
.add_code { background:#F4F4F4;border:1px solid #ccc;width:110px;text-align:center;line-height:30px;margin:10px;display:inline-block;cursor:pointer;}
.form1 .form-group { width:45%;float:left;margin-bottom:0 !important;}
.input_info { width:100px !important;}
.form_label { float:left;line-height:25px;width:90px;text-align:right;padding-right:5px;}
.form_label i { color:#f00;}
.form_input { float:left;}
.form_btn span { display:inline-block;width:100px;text-align:center;line-height:30px;color:#333 !important;background:#fff;border:1px solid #aaa;cursor:pointer;}
.form_btn span:first-child { margin-left:200px;margin-right:100px;}
.form_btn span:hover { background:#eee;}
.table { width:1000px;}
.table-bordered { border-collapse:collapse;}
.table>thead>tr>th { text-align: center;}
.data_rows tr td { text-align:center !important;}
.underline { text-decoration:underline;}
.pr_label{
	display: inline;
	padding-left: 20px;
}
.checkboxp{
	position: relative;
}
#all{
	display: inline;
	position: absolute;
	top: 450px;
	left: 50px;
	opacity:1;
}
.table{
	width: 100% !important;
}
.table tbody tr td a.not_click { color:#aaa !important;cursor: default !important;text-decoration:none !important;}
/*.data_rows_type tr{
	min-width: 400px;
}*/
</style>
</head>
<body>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">      
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">
            <div class="table_content clear">
                <div class="tab_content">
                        <form class="search_form" id="search-condition" action="">
                            <div class="search_form_box clear">
								<a class="btn btn-large bootboxss" href="#"><i class=" icon-plus"></i>全站优惠卷</a>
								<a class="btn btn-large typebox" href="#"><i class=" icon-plus"></i>类目优惠卷</a>
								<a class="btn btn-large shopbox" href="#"><i class=" icon-plus"></i>店铺优惠卷</a>
								<a class="btn btn-large productbox" href="#"><i class=" icon-plus"></i>产品优惠卷</a>
								<a class="btn btn-large loginbox" href="#"><i class=" icon-plus"></i>注册优惠卷</a>
								<!-- <div id="magicsuggest"></div> -->
								
                            </div>
							  
                        </form>
                     <div class="table_list" id="dataTablem">                     
                       <table class="table table-bordered table_hover">
                           <thead class="">
                               <tr>
                                    <th>序号</th>
                                    <th>优惠券类型</th>
				                    <th>优惠券金额</th>
				                    <th>使用条件</th> 
				                    <th>张数</th>
				                    <th>领用数</th>
				                    <th>使用数</th>
				                    <th>有效期至</th>
				                    <th>备注</th>
                                   <th>操作</th>
                               </tr>
                           </thead>
                           <tbody class="data_rows">
                           </tbody>
                       </table>
                        <!-- 暂无数据 -->
                        <div class="no-data" style="display:none;">木有数据哟！换个条件试试</div>
                     </div> 
                </div>
                <div id="data_page_div"></div>
            </div>
        </div>
    </div>
	

	<div class="fb-content form1" id="form_details" style="display:none;">
		<div class="box-title">
	        <h5>查看优惠券详情</h5>
	        <span class="layui-layer-setwin">
	            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
	        </span>
	    </div>
        <div class="tab_content">
                <form class="search_form" id="search-condition"method="post" action="">
                    <div class="search_form_box clear">

                        <div class="search_group">
                            <label>会员名称：</label>
                            <input type="text" name="name" class="search_input" style="width:120px;"/>
                        </div>
                        <div class="search_group">
                            <label>会员手机：</label>
                            <input type="tel" name="mobile" class="search_input" style="width:120px;"/>
                        </div>
						<div class="search_group">
                            <label>优惠券代码：</label>
                            <input type="text" name="code" class="search_input" style="width:160px;"/>
                        </div>
                        <div class="search_group">
                            <label>状态：</label>
                            <div class="form_select" style="margin-right:0;">
                                <div class="search_select div_order">
                                    <div class="show_select status" data-value="2" style="width:96px;">已领用</div>
                                    <ul class="select_list">
                                            <li value="2">已领用</li>
                                            <li value="3">已使用</li>
                                            <li value="5">全部</li>
                                    </ul>
                                    <i></i>
                                </div>
                                <input type="hidden" name="status" value="2" class="select_value"/>
                             </div>
                        </div>
                        <div class="search_group">
                            <input type="button" name="button" class="search_button" value="搜索"/>
                        </div>
                    </div>
                </form>
             <div class="table_list" id="dataTable">                     
               <table class="table table-bordered table_hover">
                   <thead class="">
                       <tr>
                           <th>序号</th>
                           <th>会员名称</th>
                           <th>优惠券代码</th>
                           <th>使用日期</th>
                           <th>有效期至</th>
                           <th>领用日期</th>
                           <th>操作</th>
                       </tr>
                   </thead>
                   <tbody class="data_rows">
                   </tbody>
               </table>
                <!-- 暂无数据 -->
                <div class="no-data" style="display:none;">木有数据哟！换个条件试试</div>
             </div> 
        </div>
        <div id="page_div"></div>
    </div>

    <div class="fb-content form1" id="form1" style="display:none;">
	    <div class="box-title">
	        <h5>新增全站优惠券</h5>
	        <span class="layui-layer-setwin">
	            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
	        </span>
	    </div>
	    <div class="fb-form">
	        <form method="post" action="#" id="role_from" class="form-horizontal">
	           <div class="form-group">
	                <div class="form_label"><i>*</i>优惠券金额</div>
	                <div class="form_input"><input type="text" class="input_info" name="money" id="form1_mo" onkeyup="check_val(this);" oninput="number_check(this,1);" maxlength="3"></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>使用条件，满</div>
	                <div class="form_input"><input type="text" class="input_info" name="role_name" id="form1_ro" onkeyup="check_val(this);" oninput="number_check(this,2);" maxlength="7"><span>可用，0表示不限制</span></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>优惠券张数</div>
	                <div class="form_input"><input type="text" class="input_info" name="number" id="form1_nu" onkeyup="check_val(this);" oninput="number_check(this,3);" maxlength="9"></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>有效期至</div>
	                <div class="form_input"><input type="text" class="input_info" id="starttime" data-date-format="yyyy-mm-dd" name="data" ></div>
	           </div>
	            <div class="form-group" style="width:80%;">
	                <div class="form_label">优惠券说明</div>
	                <div class="form_input"><input type="text" class="input_info" style="width:460px !important;" id="form1_tel" maxlength="30"/></div>
	            </div>

	            <div class="form-group form_btn" style="width:80%;padding-bottom:50px;padding-top:20px;">
	            	<span class="sub_data" id="sub_form1">确定发放</span>
	                <span class="layui-layer-close">取消</span>
	            </div>
	        </form>
	    </div>
	</div>

	<div class="fb-content form1" id="form5" style="display:none;">
	    <div class="box-title">
	        <h5>新增注册优惠券</h5>
	        <span class="layui-layer-setwin">
	            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
	        </span>
	    </div>
	    <div class="fb-form">
	        <form method="post" action="#" id="role_from" class="form-horizontal">
	           <div class="form-group">
	                <div class="form_label"><i>*</i>优惠券金额</div>
	                <div class="form_input"><input type="text" class="input_info" name="money" id="form5_mo" onkeyup="check_val(this);" oninput="number_check(this,1);" maxlength="3"></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>使用条件，满</div>
	                <div class="form_input"><input type="text" class="input_info" name="role_name" id="form5_ro" onkeyup="check_val(this);" oninput="number_check(this,2);" maxlength="7"><span>可用，0表示不限制</span></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>优惠券张数</div>
	                <div class="form_input"><input type="text" class="input_info" name="number" id="form5_nu" onkeyup="check_val(this);" oninput="number_check(this,3);" maxlength="9"></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>有效期至</div>
	                <div class="form_input"><input type="text" class="input_info" id="starttime5" data-date-format="yyyy-mm-dd" name="data" ></div>
	           </div>
	            <div class="form-group" style="width:80%;">
	                <div class="form_label">优惠券说明</div>
	                <div class="form_input"><input type="text" class="input_info" style="width:460px !important;" id="form5_tel" maxlength="30"/></div>
	            </div>

	            <div class="form-group form_btn" style="width:80%;padding-bottom:50px;padding-top:20px;">
	            	<span class="sub_data" id="sub_form5">确定发放</span>
	                <span class="layui-layer-close">取消</span>
	            </div>
	        </form>
	    </div>
	</div>
	
	<div class="fb-content form1" id="form2" style="display:none;">
	    <div class="box-title">
	        <h5>新增类目优惠券</h5>
	        <span class="layui-layer-setwin">
	            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
	        </span>
	    </div>
	    <div class="fb-form">
	        <form method="post" action="#" id="role_from" class="form-horizontal">
	        	<div class="form-group">
	                <div class="form_label"><i>*</i>优惠券金额</div>
	                <div class="form_input"><input type="text" class="input_info" name="money" id="form2_mo" onkeyup="check_val(this);" oninput="number_check(this,1);" maxlength="3"></div>
	           	</div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>使用条件，满</div>
	                <div class="form_input"><input type="text" class="input_info" name="role_name" id="form2_ro" onkeyup="check_val(this);" oninput="number_check(this,2);" maxlength="7"><span>可用，0表示不限制</span></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>优惠券张数</div>
	                <div class="form_input"><input type="text" class="input_info" name="number" id="form2_nu" onkeyup="check_val(this);" oninput="number_check(this,3);" maxlength="9"></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>有效期至</div>
	                <div class="form_input"><input type="text" class="input_info" id="starttime_type" data-date-format="yyyy-mm-dd" name="data" ></div>
	           </div>
	            <div class="form-group" style="width:80%;">
	                <div class="form_label">备注</div>
	                <div class="form_input"><input type="text" class="input_info" style="width:460px !important;" id="form2_tel" maxlength="30"/></div>
	            </div>
				
				<div class="form-group" style="width:100%;">
					<h4>适用类目</h4><hr>
	            </div>
				
				<div class="form-group form_btn" style="width:80%;padding-bottom:5px;padding-top:5px;">
					<span class="delete_bt" style="margin:0;padding:0;" id="delete_type">删除</span>
	                <span class="add_bt" id="add_type">添加类目</span>
	           	</div>
				<div class="form-group" class="checkboxp" style="overflow-y: scroll;max-height: 400px;min-width: 400px; display: inline-block;">
					
					<div class="table_list" id="dataTable_type">                     
	                   <table class="table table-bordered table_hover">
	                       <thead class="form2_type">
	                           <tr>
	                               <th><input type="checkbox" style="opacity:1;position: relative;top:0px;left:4px;width: 26px;" class="allcheck" id="all_ty"></th>
	                               <th>类目名称</th>
	                           </tr>
	                       </thead>
	                       <tbody class="data_rows_type listcheck" id="listcheck_type">
	                       </tbody>
	                   </table>
	                    <!-- 暂无数据 -->
	                    <div class="no-data" style="display:none;">木有数据哟！换个条件试试</div>
	                 </div>

				</div>
				<div class="form-group" style="width:100%;">
					<div id="page_div_addtype"></div>
				</div>
	            <div class="form-group form_btn" style="width:80%;padding-bottom:50px;padding-top:20px;">
	            	<span class="sub_data" id="sub_form2">发放</span>
	                <span class="layui-layer-close">取消</span>
	            </div>
	        </form>
	    </div>
	</div>

	<div class="fb-content form1" id="form2_add" style="display:none;">
	    <div class="box-title">
	        <h5>选择类目</h5>
	        <span class="layui-layer-setwin">
	            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
	        </span>
	    </div>
	    <div class="fb-form">
	        <form method="post" action="#" id="role_from" class="form-horizontal">
				<div class="form-group" style="width:100%;">
	                <div class="pr_label">类目名称&nbsp;&nbsp;<input type="text" class="input_info" style="width:400px !important;" id="dest_name"></div>
	                <div class="pr_label form_btn"><span class="sub_data" id="addtype_search" style="margin:0;padding:0;">搜索</span></div>
	           	</div>
				<div class="form-group" style="width:100%;" class="checkboxp">
					
					<div class="table_list" id="dataTable_type">                     
	                   <table class="table table-bordered table_hover">
	                       <thead class="form2_add_type">
	                           <tr>
	                               <th><input type="checkbox" style="opacity:1;position: absolute;top: 94px;left:-1px;width: 200px;" class="allcheck" id="all_addty"></th>
	                               <th>类目名称</th>
	                           </tr>
	                       </thead>
	                       <tbody class="data_rows_type_add listcheck" id="listcheck_addty">
	                       </tbody>
	                   </table>
	                    <!-- 暂无数据 -->
	                    <div class="no-data-type" style="display:none;">木有数据哟！换个条件试试</div>
	                 </div>

				</div>
				<div class="form-group" style="width:100%;">
					<div id="page_div_type"></div>
				</div>
	            <div class="form-group form_btn" style="width:80%;padding-bottom:50px;padding-top:20px;">
	            	<span class="sub_data" id="sub_addtype">确认选择</span>
	                <span class="layui-layer-close" id="sub_addtype_close">取消</span>
	            </div>
	        </form>
	    </div>
	</div>

	<div class="fb-content form1" id="form3" style="display:none;">
	    <div class="box-title">
	        <h5>新增店铺优惠券</h5>
	        <span class="layui-layer-setwin">
	            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
	        </span>
	    </div>
	    <div class="fb-form">
	        <form method="post" action="#" id="role_from" class="form-horizontal">
	        	<div class="form-group" style="width:100%;">
	                <div class="form_label"><i>*</i>供应商</div>
	                <!-- <div class="form_input"><input id='kv'/></div> -->
	                <div class="form_input">
		                <input type="text" name="makeupCo" id="makeupCo" class="makeinp" onfocus="setfocus(this)" oninput="setinput(this);" placeholder="请选择或输入"/>  
	    				<select name="makeupCoSe" id="typenum" onchange="changeF(this)" size="5" style="display:none;min-height: 150px;"></select>
    				</div>
	            </div>
	            <div class="form-group">
	                <div class="form_label"><i>*</i>优惠券金额</div>
	                <div class="form_input"><input type="text" class="input_info" name="money" id="form3_mo" onkeyup="check_val(this);" oninput="number_check(this,1);" maxlength="3"></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>使用条件，满</div>
	                <div class="form_input"><input type="text" class="input_info" name="role_name" id="form3_ro" onkeyup="check_val(this);" oninput="number_check(this,2);" maxlength="7"><span>可用，0表示不限制</span></div>
	           </div>
	           
	           <div class="form-group">
	                <div class="form_label"><i>*</i>优惠券张数</div>
	                <div class="form_input"><input type="text" class="input_info" name="number" id="form3_nu" onkeyup="check_val(this);" oninput="number_check(this,3);" maxlength="9"></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>有效期至</div>
	                <div class="form_input"><input type="text" class="input_info" id="starttimet" data-date-format="yyyy-mm-dd" name="data" ></div>
	           </div>
	            <div class="form-group" style="width:80%;">
	                <div class="form_label">优惠券说明</div>
	                <div class="form_input"><input type="text" class="input_info" style="width:460px !important;" id="form3_tel" maxlength="30"/></div>
	            </div>

	            <div class="form-group form_btn" style="width:80%;padding-bottom:50px;padding-top:20px;">
	            	<span class="sub_data" id="sub_form3">确定发放</span>
	                <span class="layui-layer-close">取消</span>
	            </div>
	        </form>
	    </div>
	</div>

	<div class="fb-content form1" id="form4" style="display:none;">
	    <div class="box-title">
	        <h5>新增产品优惠券</h5>
	        <span class="layui-layer-setwin">
	            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
	        </span>
	    </div>
	    <div class="fb-form">
	        <form method="post" action="#" id="role_from" class="form-horizontal">
	        	<div class="form-group">
	                <div class="form_label"><i>*</i>优惠券金额</div>
	                <div class="form_input"><input type="text" class="input_info" name="money" id="form4_mo" onkeyup="check_val(this);" oninput="number_check(this,1);" maxlength="3"></div>
	           	</div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>使用条件，满</div>
	                <div class="form_input"><input type="text" class="input_info" name="role_name" id="form4_ro" onkeyup="check_val(this);" oninput="number_check(this,2);" maxlength="7"><span>可用，0表示不限制</span></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>优惠券张数</div>
	                <div class="form_input"><input type="text" class="input_info" name="number" id="form4_nu" onkeyup="check_val(this);" oninput="number_check(this,3);" maxlength="9"></div>
	           </div>
	           <div class="form-group">
	                <div class="form_label"><i>*</i>有效期至</div>
	                <div class="form_input"><input type="text" class="input_info" id="starttimes" data-date-format="yyyy-mm-dd" name="data" ></div>
	           </div>
	            <div class="form-group" style="width:80%;">
	                <div class="form_label">优惠券说明</div>
	                <div class="form_input"><input type="text" class="input_info" style="width:460px !important;" id="form4_tel" maxlength="30"/></div>
	            </div>
				
				<div class="form-group" style="width:100%;">
					<h4>选择产品</h4><hr>
	            </div>
				
				<div class="form-group" style="width:100%;">
	                <div class="pr_label">线路名称&nbsp;&nbsp;<input type="text" class="input_info" name="number" id="line_name"></div>
	                <div class="pr_label">线路编号&nbsp;&nbsp;<input type="text" class="input_info" name="number" id="line_code"></div>
	                <div class="pr_label">品牌名称&nbsp;&nbsp;<input type="text" class="input_info" name="number" id="brand_name"></div>
	                <div class="pr_label">供应商&nbsp;&nbsp;<input type="text" class="input_info" name="number" id="supplier_name"></div>
	                <div class="pr_label form_btn"><span class="sub_data" id="product_search" style="margin:0;padding:0;">搜索</span></div>
	           	</div>
				<div class="form-group" style="width:100%;" class="checkboxp">
					
					<div class="table_list" id="dataTable_pr">                     
	                   <table class="table table-bordered table_hover">
	                       <thead class="dataTable_pr">
	                           <tr>
	                               <th><input type="checkbox" style="opacity:1;position: absolute;top: 291px;left:-390px;" class="allcheck" id="all_pr"></th>
	                               <th>线路编号</th>
	                               <th>产品标题</th>
	                               <th>售价</th>
	                           </tr>
	                       </thead>
	                       <tbody class="data_rows_pr listcheck" id="listcheck_pr">
	                       </tbody>
	                   </table>
	                    <!-- 暂无数据 -->
	                    <div class="no-data-pr" style="display:none;">木有数据哟！换个条件试试</div>
	                 </div>

				</div>
				<div class="form-group" style="width:100%;">
					<div id="page_div_pr"></div>
				</div>
	            <div class="form-group form_btn" style="width:80%;padding-bottom:50px;padding-top:20px;">
	            	<span class="sub_data" id="sub_product">确定发放</span>
	                <span class="layui-layer-close">取消</span>
	            </div>
	        </form>
	    </div>
	</div>
<script src='/assets/js/horsey.js'></script>
<!-- <script src='/assets/js/example.js'></script> -->
<!-- <script type="text/javascript" src="/assets/js/jquery-2.0.3.min.js"></script>	 -->
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<!-- <script type="text/javascript" src="/assets/js/magic-suggest/magicsuggest-min.js"></script> -->
<script>

$(function(){
	//$("script[src='../../../assets/js/jquery-1.11.1.min.js']").remove();
     object.init(); //加载
     
    $('#starttime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		onSelectDate:function(){
			var time1 = $("#starttime").val();
			var time2 = new Date();
			var year1 = time1.substr(0,4);
			var month1 = parseInt(time1.substr(5,2));
			var date1 = parseInt(time1.substr(8,2));
			var year2 = time2.getFullYear();
			var month2 = time2.getMonth()+1;
			var date2 = time2.getDate();
			if(year1<year2){
				alert("有效期必须在今天以后");
				$('#starttime').val("");
			}else{
				if(year1==year2&&month1<month2){
					alert("有效期必须在今天以后");
					$('#starttime').val("");
				}else{
					if(year1==year2&&month1==month2&&date1<=date2){
						alert("有效期必须在今天以后");
						$('#starttime').val("");
					}	
				}
			}
		}
	});
	$('#starttime_type').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		onSelectDate:function(){
			var time1 = $("#starttime_type").val();
			var time2 = new Date();
			var year1 = time1.substr(0,4);
			var month1 = parseInt(time1.substr(5,2));
			var date1 = parseInt(time1.substr(8,2));
			var year2 = time2.getFullYear();
			var month2 = time2.getMonth()+1;
			var date2 = time2.getDate();
			if(year1<year2){
				alert("有效期必须在今天以后");
				$('#starttime_type').val("");
			}else{
				if(year1==year2&&month1<month2){
					alert("有效期必须在今天以后");
					$('#starttime_type').val("");
				}else{
					if(year1==year2&&month1==month2&&date1<=date2){
						alert("有效期必须在今天以后");
						$('#starttime_type').val("");
					}	
				}
			}
		}
	});
	$('#starttimet').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		onSelectDate:function(){
			var time1 = $("#starttimet").val();
			var time2 = new Date();
			var year1 = time1.substr(0,4);
			var month1 = parseInt(time1.substr(5,2));
			var date1 = parseInt(time1.substr(8,2));
			var year2 = time2.getFullYear();
			var month2 = time2.getMonth()+1;
			var date2 = time2.getDate();
			if(year1<year2){
				alert("有效期必须在今天以后");
				$('#starttimet').val("");
			}else{
				if(year1==year2&&month1<month2){
					alert("有效期必须在今天以后");
					$('#starttimet').val("");
				}else{
					if(year1==year2&&month1==month2&&date1<=date2){
						alert("有效期必须在今天以后");
						$('#starttimet').val("");
					}	
				}
			}
		}
	});
	$('#starttimes').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		onSelectDate:function(){
			var time1 = $("#starttimes").val();
			var time2 = new Date();
			var year1 = time1.substr(0,4);
			var month1 = parseInt(time1.substr(5,2));
			var date1 = parseInt(time1.substr(8,2));
			var year2 = time2.getFullYear();
			var month2 = time2.getMonth()+1;
			var date2 = time2.getDate();
			if(year1<year2){
				alert("有效期必须在今天以后");
				$('#starttimes').val("");
			}else{
				if(year1==year2&&month1<month2){
					alert("有效期必须在今天以后");
					$('#starttimes').val("");
				}else{
					if(year1==year2&&month1==month2&&date1<=date2){
						alert("有效期必须在今天以后");
						$('#starttimes').val("");
					}	
				}
			}
		}
	});
	$('#starttime5').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		onSelectDate:function(){
			var time1 = $("#starttime5").val();
			var time2 = new Date();
			var year1 = time1.substr(0,4);
			var month1 = parseInt(time1.substr(5,2));
			var date1 = parseInt(time1.substr(8,2));
			var year2 = time2.getFullYear();
			var month2 = time2.getMonth()+1;
			var date2 = time2.getDate();
			if(year1<year2){
				alert("有效期必须在今天以后");
				$('#starttimes').val("");
			}else{
				if(year1==year2&&month1<month2){
					alert("有效期必须在今天以后");
					$('#starttimes').val("");
				}else{
					if(year1==year2&&month1==month2&&date1<=date2){
						alert("有效期必须在今天以后");
						$('#starttimes').val("");
					}	
				}
			}
		}
	});
	//object.void();
})
var base_url = "<?php echo base_url();?>";
var flag=true;
var object = object || {};
var ajax_data={};
var post_url="<?php echo base_url('/admin/a/coupon_manage/coupon_data/coupon_list')?>";
object = {
	void:function(ret){
		
	},
    init:function(){ //初始化方法
		  
          //接口数据
          ajax_data={
          	page:"1",
          	pageSize:15
          }; 
          var list_data=object.send_ajax(post_url,ajax_data); //请求ajax 
          var total_page; //分页数
		  if(list_data.code==2000){
			  total_page=Math.ceil(list_data.data.pagedata.count/15); //分页数
		  }else{
			  total_page=0;
		  }
			//console.log(total_page);
          //调用分页
          laypage({
              cont: 'data_page_div',
              pages: total_page,
              jump: function(ret){   
              		console.log("123");              
					var html=""; //html内容
					ajax_data.page=ret.curr; //页数
					var return_data=null;  //数据
					if(ret.curr==1&&flag==true)
					{
						return_data=list_data;
					}
					else
					{
						return_data=object.send_ajax(post_url,ajax_data);
					}
					//写html内容
					if(return_data.code=="2000")
					{
						  html=object.pageData(ret.curr,return_data.data.pagedata.pageSize,return_data.data.coupon_data);
						  $(".no-data").hide();
						  console.log("html")
					}
					else if(return_data.code=="4001")
					{
						  html="";
						  $("#dataTablem .no-data").show();
					}
					else
					{
						layer.msg(return_data.msg, {icon: 2});
						$(".no-data").hide();
					}
				   $(".data_rows").html(html);
              }    
          })
          flag=false;
          //end

        },
        pageData:function(curr,page_size,data){  //生成表格数据 
              var str = '', last = curr*page_size - 1;
              last = last >= data.length ? (data.length-1) : last;
              
              for(var i = 0; i <= last; i++)
              {
				  var c_type=data[i].c_type;
				  var c_str;
				  if(c_type==1){
					  c_str="全站优惠券";
				  }else if(c_type==2){
					  c_str="类目优惠券";
				  }else if(c_type==3){
					  c_str="店铺优惠券";
				  }else if(c_type==4){
					  c_str="产品优惠券";
				  }else if(c_type==5){
					  c_str="注册优惠券";
				  }else if(c_type==6){
					  c_str="兑换码";
				  }
                  str += "<tr>";
                  str +=     "<td>"+data[i].id+"</td>";
                  str +=     "<td>"+c_str+"</td>";
                  str +=     "<td>"+data[i].number+"</td>";
                  str +=     "<td>满"+data[i].price+"可用</td>";
				  str +=     "<td>"+data[i].c_sum+"</td>";
                  str +=     "<td>"+data[i].c_take+"</td>";
                  str +=     "<td>"+data[i].c_use+"</td>";
                  str +=     "<td>"+data[i].c_value_time+"</td>";
                  str +=     "<td>"+data[i].c_description +"</td>";
                  str +=     '<td><a href="javascript:void(0);" onclick="check('+data[i].id+','+c_type+')" class="action_type underline">查看</a>&nbsp;&nbsp;&nbsp;';
                  if(c_type!=5){
                  str +=     '<a href="javascript:void(0);" onclick="grant('+data[i].id+','+c_type+')" class="action_type underline">选定发放</a>&nbsp;&nbsp;&nbsp;';
              		}
				  if(data[i].if_not==1){
					  str+='<a href="javascript:void(0);" onclick="edit('+data[i].id+','+c_type+',this)" class="action_type underline">作废</a></td>';
				  }else if(data[i].if_not==2){
					  str+='<a href="javascript:void(0);" class="action_type underline not_click">作废</a></td>';
				  };
                  str += "</tr>";
              }
              return str;
           
        },
      send_ajax:function(url,data){  //发送ajax请求，有加载层
            var ret;
            $.ajax({ url:url,type:"POST",data:data,async:false,dataType:"json",
                 success:function(data){
                      ret=data;
                 },
                 error:function(data){
                      ret=data;
                 }        
            });
              return ret;
      }
}

function check(id,type){
	window.top.openWin({
		  type: 2,
		  area: ['1000px', '600px'],
		  title :'优惠券详情',
		  fix: true, //不固定
		  maxmin: true,
		  content: base_url+"admin/a/coupon_manage/coupon_data/coupon_detail?id="+id+"&type="+type
	});
}
function edit(id,type,obj){
	layer.confirm('您确定要执行作废操作？', {
		btn: ['确定','取消'] //按钮
	}, function(){
		$.ajax({ 
			url:base_url+"admin/a/coupon_manage/coupon_data/coupon_void_all",
			type:"POST",
			data:{ id:id , type:type },
			async:false,
			dataType:"json",
			success:function(ret){
				console.log(ret);
				if(ret.code==2000){				
					layer.msg("操作成功", {time: 1500,icon: 1});
					$(obj).attr("onclick","").addClass("not_click");;
				}else{
					layer.msg(ret.msg, {icon: 2});
				}		
			},
			error:function(ret){
				console.log(ret);
				layer.msg(ret.msg, {icon: 2});
			}        
		});
	}, function(){
	
	});
}
function grant(id,type){
	window.top.openWin({
		  type: 2,
		  area: ['1150px', '600px'],
		  title :'发放优惠券',
		  fix: true, //不固定
		  maxmin: true,
		  content:base_url+"admin/a/coupon_manage/coupon_data/send_detail?id="+id+"&type="+type,
	});
}

$(".bootboxss").click(function(){
	$("#form1 .input_info").val("");
     layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '750px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form1')
     });
})
$("#sub_form1").click(function(){
	var number = $("#form1_nu").val();
	var time = $("#starttime").val();
	var min_price = parseInt($("#form1_ro").val());

	var coupon_price = $("#form1_mo").val();
	var decription = $("#form1_tel").val();
	if(coupon_price.length<=0){
		layer.msg("请填写优惠券金额", {icon: 7});
		return false;
	}
	if(number.length<=0){
		layer.msg("请填写优惠券张数", {icon: 7});
		return false;
	}
	if(time.length<=0){
		layer.msg("请选择有效期", {icon: 7});
		return false;
	}
	if(min_price.length==0){
		layer.msg("请填写使用条件", {icon: 7});
		return false;
	}
	if(coupon_price>=min_price&&min_price!=0){
		console.log(coupon_price+"///"+min_price);
		layer.msg("优惠券金额不能超过使用条件", {icon: 7});
		return false;
	}
		$.ajax({ 
			url:base_url+"admin/a/coupon_manage/coupon_data/add_coupon",
			type:"POST",
			data:{number:number,time:time,min_price:min_price,coupon_price:coupon_price,decription:decription},
			async:false,dataType:"json",
	         success:function(data){
	         		if(data.code==2000){				
						layer.msg("操作成功", {time: 1500,icon: 1});
			              $('.layui-layer-close').click();
			              object.init();
			        }else{
			        	layer.msg(data.msg, {icon: 2});
			        }
	         },
	         error:function(data){
	              console.log(data);
	         }        
	    });
	
})

$(".loginbox").click(function(){
	$("#form5 .input_info").val("");
     layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '750px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form5')
     });
})
$("#sub_form5").click(function(){
	var number = $("#form5_nu").val();
	var time = $("#starttime5").val();
	var min_price = parseInt($("#form5_ro").val());

	var coupon_price = $("#form5_mo").val();
	var decription = $("#form5_tel").val();
	if(coupon_price.length<=0){
		layer.msg("请填写优惠券金额", {icon: 7});
		return false;
	}
	if(number.length<=0){
		layer.msg("请填写优惠券张数", {icon: 7});
		return false;
	}
	if(time.length<=0){
		layer.msg("请选择有效期", {icon: 7});
		return false;
	}
	if(min_price.length==0){
		layer.msg("请填写使用条件", {icon: 7});
		return false;
	}
	if(coupon_price>=min_price&&min_price!=0){
		console.log(coupon_price+"///"+min_price);
		layer.msg("优惠券金额不能超过使用条件", {icon: 7});
		return false;
	}
		$.ajax({ 
			url:base_url+"admin/a/coupon_manage/coupon_data/add_res_coupon",
			type:"POST",
			data:{number:number,time:time,min_price:min_price,coupon_price:coupon_price,decription:decription},
			async:false,dataType:"json",
	         success:function(data){
	         		if(data.code==2000){				
						layer.msg("操作成功", {time: 3000,icon: 1});
			              $('.layui-layer-close').click();
			              object.init();
			        }else{
			        	layer.msg(data.msg, {icon: 2});
			        }
	         },
	         error:function(data){
	              console.log(data);
	         }        
	    });
	
})


var sub_datas = [];
$(".typebox").click(function(){

	$("#form2 .input_info").val("");
	sub_datas = [];
     layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '750px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form2')
     });
     typepage_data(sub_datas);
})
$("#add_type").click(function(){
	layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '750px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form2_add')
     });
	if(sub_datas){
		var ids = '';
		
		for(var i = 0; i < sub_datas.length; i++){
			ids = sub_datas[i].id+','+ids;
		}
		typepage_adddata(ids)
	}else{
		typepage_adddata()
	}
})
$("#addtype_search").click(function(){
	typepage_adddata()
})
function typepage_adddata (id){
	var dest_name = $("#dest_name").val();
	var post_url = base_url+"admin/a/coupon_manage/coupon_data/get_dest";
	var ajax_data = {page:"1",pageSize:10,dest_name:dest_name,id:id};
	var list_data=product_ajax(post_url,ajax_data);
	if(list_data.code==2000){
		  var total_pages=Math.ceil(list_data.data.pagedata.count/10); //分页数
	  }else{
		  total_pages=0;
	  }
	

     laypage({
      cont: 'page_div_type',
      pages: total_pages,
      jump: function(ret){ 
      		var str="";
      		ajax_data.page=ret.curr; //页数
			var return_data=null;  //数据
			if(ret.curr==1&&flag==true)
			{
				return_data=list_data;
			}
			else
			{
				return_data=product_ajax(post_url,ajax_data);
			}
      		
      		if(return_data.code=="2000"){
      			$(".no-data-type").hide();
      			var rlt = return_data.data;
			   for(var i = 0; i < rlt.coupon_data.length; i++)
	              {
	                  str += "<tr>";
	                  str += '<td><input type="checkbox" value="'+rlt.coupon_data[i].id+'" style="opacity:1;position: relative;top:0px;left:0px;"></td>';
	                  str += "<td>"+rlt.coupon_data[i].name+"</td>";
	                  str += "</tr>";
	              }
	              
	        }
	        if(return_data.code=="4001")
            {
                str="";
                $(".no-data-type").show();
            }
            else
            {
              //layer.msg(rlt.msg, {icon: 2});
              $(".no-data-type").hide();
            }
            $(".data_rows_type_add").html(str);
}    
  })
}

$("#sub_addtype").click(function(){
	
	$.each($(".form2_add_type").next('tbody').find('tr') ,function(){
		var checkObj = $(this).find('td').eq(0).find('input');
		var checkObjtt = $(this).find('td').eq(1);
		if (checkObj.attr('checked') == 'checked') {
			           
            var sub = new Object();
            sub.id = checkObj.val();
            sub.name = checkObjtt.text();
            sub_datas.push(sub)
            
		}
	})
	var hash = {};
	sub_datas = sub_datas.reduce(function(item, next) {
	    hash[next.id] ? '' : hash[next.id] = true && item.push(next);
	    return item
	}, []);
	//console.log(sub_datas);
	typepage_data(sub_datas);
	//$("#form2_add").hide();
	$('#sub_addtype_close').click();
})
$("#delete_type").click(function(){
	var sub_data = []
	$.each($(".form2_type").next('tbody').find('tr') ,function(){
		var checkObj = $(this).find('td').eq(0).find('input');
		var checkObjtt = $(this).find('td').eq(1);

		if (checkObj.attr('checked') != 'checked') {
			           
            var sub = new Object();
            sub.id = checkObj.val();
            sub.name = checkObjtt.text();
            sub_data.push(sub)
            
		}
	})
	sub_datas=sub_data;
	//console.log(sub_data);
	typepage_data(sub_data);
})
function typepage_data (data){
	var total_page=Math.ceil(data);
     //console.log(data);
     laypage({
      cont: 'page_div_addtype',
      pages: total_page,
      jump: function(){ 
      		var str="";
		   for(var i = 0; i < data.length; i++)
              {
                  str += "<tr>";
                  str += '<td><input type="checkbox" value="'+data[i].id+'" style="opacity:1;position: relative;top:0px;left:0px;"></td>';
                  str += "<td>"+data[i].name+"</td>";
                  str += "</tr>";
              }
              $(".data_rows_type").html(str);
      }    
  })
}
$("#sub_form2").click(function(){
	var number = $("#form2_nu").val();
	var time = $("#starttime_type").val();
	var min_price = parseInt($("#form2_ro").val());
	var coupon_price = $("#form2_mo").val();
	var decription = $("#form2_tel").val();
	var ids = '';
	if(coupon_price.length<=0){
		layer.msg("请填写优惠券金额", {icon: 7});
		return false;
	}
	if(number.length<=0){
		layer.msg("请填写优惠券张数", {icon: 7});
		return false;
	}
	if(time.length<=0){
		layer.msg("请选择有效期", {icon: 7});
		return false;
	}
	if(min_price.length==0){
		layer.msg("请填写使用条件", {icon: 7});
		return false;
	}
	if(coupon_price>=min_price&&min_price!=0){
		console.log(coupon_price+"///"+min_price);
		layer.msg("优惠券金额不能超过使用条件", {icon: 7});
		return false;
	}
	$.each($(".form2_type").next('tbody').find('tr') ,function(){
		var checkObj = $(this).find('td').eq(0).find('input');
		// if (checkObj.attr('checked') == 'checked') {
			ids = checkObj.val()+','+ids;
		//}
	})
	if (ids.length == 0) {
		layer.alert('请选择适用类目', {icon: 2});
		return false;
	}
	$.ajax({ 
		url:base_url+"admin/a/coupon_manage/coupon_data/add_dest_coupon",
		type:"POST",
		data:{number:number,time:time,min_price:min_price,coupon_price:coupon_price,decription:decription,dest_id:ids},
		async:false,dataType:"json",
         success:function(data){
         		if(data.code==2000){				
					layer.msg("操作成功", {time: 1500,icon: 1});
		              $('.layui-layer-close').click();
		              object.init();
		        }else{
		        	layer.msg(data.msg, {icon: 2});
		        }
         },
         error:function(data){
              console.log(data);
         }        
    });
})


$(".shopbox").click(function(){
	$("#form3 .input_info").val("");
     layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '750px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form3')
     });
    	
})
$("#sub_form3").click(function(){
	var number = $("#form3_nu").val();
	var time = $("#starttimet").val();
	var min_price = parseInt($("#form3_ro").val());
	var coupon_price = $("#form3_mo").val();
	var decription = $("#form3_tel").val();
	var supplier = $("#makeupCo").val();
	if(coupon_price.length<=0){
		layer.msg("请填写优惠券金额", {icon: 7});
		return false;
	}
	if(number.length<=0){
		layer.msg("请填写优惠券张数", {icon: 7});
		return false;
	}
	if(time.length<=0){
		layer.msg("请选择有效期", {icon: 7});
		return false;
	}
	if(min_price.length==0){
		layer.msg("请填写使用条件", {icon: 7});
		return false;
	}
	if(coupon_price>=min_price&&min_price!=0){
		console.log(coupon_price+"///"+min_price);
		layer.msg("优惠券金额不能超过使用条件", {icon: 7});
		return false;
	}
	$.ajax({ 
		url:base_url+"admin/a/coupon_manage/coupon_data/add_supplier_coupon",
		type:"POST",
		data:{number:number,time:time,min_price:min_price,coupon_price:coupon_price,decription:decription,supplier:supplier},
		async:false,dataType:"json",
         success:function(data){
         		if(data.code==2000){				
					layer.msg("操作成功", {time: 1500,icon: 1});
		              $('.layui-layer-close').click();
		              object.init();
		        }else{
		        	layer.msg(data.msg, {icon: 2});
		        }
         },
         error:function(data){
              console.log(data);
         }        
    });
})

$("#product_search").click(function(){
	product_data();
})
$(".productbox").click(function(){
	$("#form4 .input_info").val("");
	layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: ['850px','800px'],
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form4')
     });
	product_data();        
})
function product_ajax(url,data){  //发送ajax请求，有加载层
            var ret;
            $.ajax({ url:url,type:"post",data:data,async:false,dataType:"json",
                 success:function(data){
                      ret=data;					  
                 },
                 error:function(data){
                      ret=data;
                 }        
            });
              return ret;
      };
function product_data (){
	//var ret = data.data;
	var line_name = $("#line_name").val();
	var line_code = $("#line_code").val();
	var brand_name = $("#brand_name").val();
	var supplier_name = $("#supplier_name").val();

	var post_url = base_url+"admin/a/coupon_manage/coupon_data/get_line_data";
	var ajax_data = {page:"1",pageSize:10,line_name:line_name,line_code:line_code,brand_name:brand_name,supplier_name:supplier_name};
	var list_data=product_ajax(post_url,ajax_data);
	//var total_page=Math.ceil(list_data.data.pagedata.count/10);
	if(list_data.code==2000){
			  total_page=Math.ceil(list_data.data.pagedata.count/15); //分页数
		  }else{
			  total_page=0;
		  }
     //console.log(data);
     laypage({
      cont: 'page_div_pr',
      pages: total_page,
      jump: function(ret){ 
      		var str="";
      		ajax_data.page=ret.curr; //页数
			var return_data=null;  //数据
			if(ret.curr==1&&flag==true)
			{
				return_data=list_data;
			}
			else
			{
				return_data=product_ajax(post_url,ajax_data);
			}

      		if(return_data.code=="2000"){
      			$(".no-data-pr").hide();
      			var ret = return_data.data;
      			for(var i = 0; i < ret.coupon_data.length; i++)
	              {
	                  str += "<tr>";
	                  str += '<td><input type="checkbox" value="'+ret.coupon_data[i].id+'" style="opacity:1;position: relative;top:0px;left:0px;"></td>';
	                  str += "<td>"+ret.coupon_data[i].linecode+"</td>";
	                  str += "<td>"+ret.coupon_data[i].linename+"</td>";
	                  str += "<td>"+ret.coupon_data[i].adultprice+"</td>";
	                  str += "</tr>";
	              }
              
              //console.log(str);
      		}else if(return_data.code=="4001")
			{
				  str="";
				  $(".no-data-pr").show();
			}
			else
			{
				//layer.msg(return_data.msg, {icon: 2});
				$(".no-data-pr").hide();
			}
			$(".data_rows_pr").html(str);
		   
      }    
  })
}
$("#sub_product").click(function(){
	var number = $("#form4_nu").val();
	var time = $("#starttimes").val();
	var min_price = $("#form4_ro").val();
	var coupon_price = $("#form4_mo").val();
	var decription = $("#form4_tel").val();
	var ids = '';
	$.each($(".dataTable_pr").next('tbody').find('tr') ,function(){
		var checkObj = $(this).find('td').eq(0).find('input');
		if (checkObj.attr('checked') == 'checked') {
			ids = checkObj.val()+','+ids;
		}
	})
	if (ids.length == 0) {
		layer.alert('请选择线路', {icon: 2});
		return false;
	}
	$.ajax({ 
		url:base_url+"admin/a/coupon_manage/coupon_data/add_line_coupon",
		type:"POST",
		data:{number:number,time:time,min_price:min_price,coupon_price:coupon_price,decription:decription,line_id:ids},
		async:false,dataType:"json",
         success:function(data){
         		if(data.code==2000){				
					layer.msg("操作成功", {time: 2000,icon: 1});
		              $('.layui-layer-close').click();
		              object.init();
		        }else{
		        	layer.msg(data.msg, {icon: 2});
		        }
         },
         error:function(data){
              console.log(data);
         }        
    });
})


$(document).on("click",".allcheck",function(){   
    if(this.checked){   
        $(".listcheck :checkbox").prop("checked", true);  
    }else{   
		$(".listcheck :checkbox").prop("checked", false);
    }   
});
$("#listcheck_pr").click(function(){

	var chknum = $("#listcheck_pr :checkbox").size();//选项总个数
	console.log(chknum);
	var chk = 0;
	$("#listcheck_pr :checkbox").each(function () {  
        if($(this).prop("checked")==true){
			chk++;
		}
    });
	if(chknum==chk){//全选
		$("#all_pr").prop("checked",true);
	}else{//不全选
		$("#all_pr").prop("checked",false);
	}
})
$("#listcheck_type").click(function(){
	var chknum = $("#listcheck_type :checkbox").size();//选项总个数
	console.log(chknum);
	var chk = 0;
	$("#listcheck_type :checkbox").each(function () {  
        if($(this).prop("checked")==true){
			chk++;
		}
    });
	if(chknum==chk){//全选
		$("#all_ty").prop("checked",true);
	}else{//不全选
		$("#all_ty").prop("checked",false);
	}
})
$("#listcheck_addty").click(function(){
	var chknum = $("#listcheck_addty :checkbox").size();//选项总个数
	console.log(chknum);
	var chk = 0;
	$("#listcheck_addty :checkbox").each(function () {  
        if($(this).prop("checked")==true){
			chk++;
		}
    });
    console.log(chk);
	if(chknum==chk){//全选
		$("#all_addty").prop("checked",true);
	}else{//不全选
		$("#all_addty").prop("checked",false);
	}
})


// function sub_ajax(){  //发送ajax请求，有加载层
//     var ret;
//     $.ajax({ url:base_url+"admin/a/coupon_manage/coupon_data/get_supplier",
//         	type:"get",
//         	async:false,
//         	dataType:"json",
//              success:function(data){
//                   ret=data;;
//              },
//              error:function(data){
//                   ret=data;
//              }        
//         });
//       return ret;
// };
var TempArr=[];//存储option
var delay = (function () {
    var timer = 0;
    return function (callback, time) {
        clearTimeout(timer);
        timer = setTimeout(callback, time);
    };
})();
$('#makeupCo').keyup(function () {
	
    delay(function () {
    	var supplier=$('#makeupCo').val();
       	$.ajax({ url:base_url+"admin/a/coupon_manage/coupon_data/get_supplier",
        	type:"get",
        	data:{supplier:supplier},
        	async:false,
        	dataType:"json",
             success:function(data){
                  TempArr=data;
                  $("#typenum").css({"display":""});  
				    var select = $("#typenum");  
				    for(i=0;i<TempArr.length;i++){  
				        var option = $("<option></option>").text(TempArr[i]);  
				        select.append(option);  
				    }
             },
             error:function(data){
                  console.log(data);
             }        
        });
    }, 1000);
});


	 
	 
	    $(document).bind('click', function(e) {    
	        var e = e || window.event; //浏览器兼容性     
	        var elem = e.target || e.srcElement;    
	        while (elem) { //循环判断至跟节点，防止点击的是div子元素     
	            if (elem.id && (elem.id == 'typenum' || elem.id == "makeupCo")) {    
	                return;    
	            }    
	            elem = elem.parentNode;    
	        }    
	        $('#typenum').css('display', 'none'); //点击的不是div或其子元素     
	    });    
 
	  
	function changeF(this_) {  
	    $(this_).prev("input").val($(this_).find("option:selected").text());  
	    $("#typenum").css({"display":"none"});  
	}  
	function setfocus(this_){  
	    $("#typenum").css({"display":""});  
	    var select = $("#typenum");  
	    for(i=0;i<TempArr.length;i++){  
	        var option = $("<option></option>").text(TempArr[i]);  
	        select.append(option);  
	    }
	    setinput(this_);   
	}  
	  
	function setinput(this_){  
	    var select = $("#typenum");  
	    select.html("");  
	    for(i=0;i<TempArr.length;i++){  
	        //若找到以txt的内容开头的，添option  
	        if(TempArr[i].substring(0,this_.value.length).indexOf(this_.value)==0){  
	            var option = $("<option></option>").text(TempArr[i]);  
	            select.append(option);  
	        }  
	    }  
	}

	function check_val(obj){
	var val = $(obj).val();
	val = val.replace(/\D/g,'')	;
	$(obj).val(val);
	}
	function number_check(obj,type){
		var val = parseInt($(obj).val());
		if(type==1){
			if(val>500){
				layer.msg("优惠券金额不能超过500", {time:1500,icon: 7});
				//$(obj).val(500);
			}		
		}else if(type==2){
			if(val>1000000){
				layer.msg("使用条件满上限不能超过一百万", {time:1500,icon: 7});
				//$(obj).val(1000000);
			}
		}else if(type==3){
			if(val>100000000){
				layer.msg("张数不能超过一亿", {time:1500,icon: 7});
				//$(obj).val(100000000);
			}
		}
	}
</script>
</html>

<style type="text/css">
    .form-group{ margin-bottom: 0px;}
     .form-group input{margin-bottom: 15px;display:inline; width:200px; height:25px;line-height:23px;padding:0 2px;border:1px solid #bbb;}
	 .btn { padding:0 10px;height:25px;line-height:25px;}
</style>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<div class="page-content">
    <!-- Page Breadcrumb -->
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
            <li class="active">点评管理</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Body -->
   <div class="page-body" id="bodyMsg">
       <div class="widget">
        <div class="flip-scroll">
                <div class="tabbable">
                    <ul id="myTab5" class="nav nav-tabs tabs-flat">
                        <li  name="tabs" class="active"><a href="###" id="tab0">新申诉</a></li>
                        <li name="tabs" class="tab-blue"><a href="###" id="tab1">通过申诉</a></li>
                        <li name="tabs" class="tab-red"><a href="###" id="tab2">拒绝申诉</a></li>
                        <li name="tabs" class="tab-blue"><a href="###" id="tab3">已删除</a></li>
                        <li name="tabs" class="tab-red"><a href="###" id="tab4">全部</a></li>
                    </ul>
                    <div class="tab-content">
                    <div class="tab-pane active" id="tab_content0"><!--新申诉:数据开始-->
                        <div class="div_comment_list0">
                            <form action="<?php echo base_url();?>admin/a/comment/new_comment" id='comment0' name='comment0' method="post">
                                <!-- 其他搜索条件,放在form 里面就可以了 -->
                                <div class="form-group" >
                                                <label style=" text-align: right;">线路名称</label>
                                                <input type="text"  name="line_name" id="line_name0" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">会员</label>
                                                <input type="text"  name="member_name" id="member_name0" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">评论时间</label>
                                                <input type="text"  name="comment_time" id="comment_time0" class="comment_time" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">专家</label>
                                                <input type="text"  name="expert_name" id="expert_name0" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">供应商</label>
                                                <input type="text"  name="supplier_name" id="supplier_name0" value=""/>&nbsp;&nbsp;&nbsp;
                                                <button type="button" class="btn btn-darkorange active" id="searchBtn0" >搜索</button>
                                </div>

                        <div id="comment_dataTable0"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                        <div class="col-sm-6" >
                            <div class="dataTables_info" id="editabledatatable_info">
                                第
                                <span class='pageNum'>0</span> /
                                <span class='totalPages'>0</span> 页 ,
                                <span class='totalRecords'>0</span>条记录,每页
                                <label>
                                    <select name="pageSize" id='comment0_Select'
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

                        <div class="tab-pane" id="tab_content1"><!--通过申诉:数据开始-->
                        <div class="comment_list1">
                            <form action="<?php echo base_url();?>admin/a/comment/pass_comment" id='comment1' name='comment1' method="post">
                                <!-- 其他搜索条件,放在form 里面就可以了 -->
                                <div class="form-group" >
                                                <label style=" text-align: right;">线路名称</label>
                                                <input type="text"  name="line_name" id="line_name1" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">会员</label>
                                                <input type="text"  name="member_name" id="member_name1" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">评论时间</label>
                                                <input type="text"  name="comment_time" id="comment_time1" class="comment_time" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">专家</label>
                                                <input type="text"  name="expert_name" id="expert_name1" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">供应商</label>
                                                <input type="text"  name="supplier_name" id="supplier_name1" value=""/>&nbsp;&nbsp;&nbsp;
                                                <button type="button" class="btn btn-darkorange active" id="searchBtn1" >搜索</button>
                                </div>
                        <div id="comment_dataTable1"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                        <div class="col-sm-6" >
                            <div class="dataTables_info" id="editabledatatable_info">
                                第
                                <span class='pageNum'>0</span> /
                                <span class='totalPages'>0</span> 页 ,
                                <span class='totalRecords'>0</span>条记录,每页
                                <label>
                                    <select name="pageSize" id='comment_Select1'
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

                    <div class="tab-pane" id="tab_content2"><!--拒绝申诉:数据开始-->
                        <div class="div_comment_list2">
                            <form action="<?php echo base_url();?>admin/a/comment/refuse_comment" id='comment2' name='comment2' method="post">
                                <!-- 其他搜索条件,放在form 里面就可以了 -->
                                <div class="form-group" >
                                                <label style=" text-align: right;">线路名称</label>
                                                <input type="text"  name="line_name" id="line_name2" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">会员</label>
                                                <input type="text"  name="member_name" id="member_name2" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">评论时间</label>
                                                <input type="text"  name="comment_time" id="comment_time2" class="comment_time" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">专家</label>
                                                <input type="text"  name="expert_name" id="expert_name2" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">供应商</label>
                                                <input type="text"  name="supplier_name" id="supplier_name2" value=""/>&nbsp;&nbsp;&nbsp;
                                                <button type="button" class="btn btn-darkorange active" id="searchBtn2" >搜索</button>
                                </div>
                        <div id="comment_dataTable2"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                        <div class="col-sm-6" >
                            <div class="dataTables_info" id="editabledatatable_info">
                                第
                                <span class='pageNum'>0</span> /
                                <span class='totalPages'>0</span> 页 ,
                                <span class='totalRecords'>0</span>条记录,每页
                                <label>
                                    <select name="pageSize" id='comment_Select2'
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

                        <div class="tab-pane" id="tab_content3"><!--已删除:数据开始-->
                        <div class="div_comment_list3">
                            <form action="<?php echo base_url();?>admin/a/comment/delete_comment" id='comment3' name='comment3' method="post">
                                <!-- 其他搜索条件,放在form 里面就可以了 -->
                                <div class="form-group" >
                                                <label style=" text-align: right;">线路名称</label>
                                                <input type="text"  name="line_name" id="line_name3" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">会员</label>
                                                <input type="text"  name="member_name" id="member_name3" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">评论时间</label>
                                                <input type="text"  name="comment_time" id="comment_time3" class="comment_time" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">专家</label>
                                                <input type="text"  name="expert_name" id="expert_name3" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">供应商</label>
                                                <input type="text"  name="supplier_name" id="supplier_name3" value=""/>&nbsp;&nbsp;&nbsp;
                                                <button type="button" class="btn btn-darkorange active" id="searchBtn3" >搜索</button>
                                </div>
                        <div id="comment_dataTable3"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                        <div class="col-sm-6" >
                            <div class="dataTables_info" id="editabledatatable_info">
                                第
                                <span class='pageNum'>0</span> /
                                <span class='totalPages'>0</span> 页 ,
                                <span class='totalRecords'>0</span>条记录,每页
                                <label>
                                    <select name="pageSize" id='comment_Select3'
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

                        <div class="tab-pane" id="tab_content4"><!--全部:数据开始-->
                        <div class="div_comment_list4">
                            <form action="<?php echo base_url();?>admin/a/comment/all_comment" id='comment4' name='comment4' method="post">
                                <!-- 其他搜索条件,放在form 里面就可以了 -->
                                <div class="form-group" >
                                                <label style=" text-align: right;">线路名称</label>
                                                <input type="text"  name="line_name" id="line_name4" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">会员</label>
                                                <input type="text"  name="member_name" id="member_name4" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">评论时间</label>
                                                <input type="text"  name="comment_time" id="comment_time4" class="comment_time" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">专家</label>
                                                <input type="text"  name="expert_name" id="expert_name4" value=""/>&nbsp;&nbsp;&nbsp;
                                                <label style=" text-align: right;">供应商</label>
                                                <input type="text"  name="supplier_name" id="supplier_name4" value=""/>&nbsp;&nbsp;&nbsp;
                                                <button type="button" class="btn btn-darkorange active" id="searchBtn4" >搜索</button>
                                </div>
                        <div id="comment_dataTable4"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                        <div class="col-sm-6" >
                            <div class="dataTables_info" id="editabledatatable_info">
                                第
                                <span class='pageNum'>0</span> /
                                <span class='totalPages'>0</span> 页 ,
                                <span class='totalRecords'>0</span>条记录,每页
                                <label>
                                    <select name="pageSize" id='comment_Select4'
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
    <!-- /Page Body -->


<div style="display:none;" class="bootbox modal fade in" id="comment_reply_modal">
    <div class="modal-dialog">
        <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
        <h4 class="modal-title">回复</h4>
    </div>
<div class="modal-body">
<div class="bootbox-body">
    <div>
   <form class="form-horizontal" id="comment_reply_modal_form" role="form" method="post" action="#">
            <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right" style="float:left;">回复</label>
            <div class="col-sm-10" style="float:left; width:83%">
                <textarea name="content" id="cotent_comment" style="resize:none;width:100%;height:100%"></textarea>
                <input type="hidden" name="comment_id" id="comment_id" value=""/>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;">
        </div>
    </form>
    </div>
    </div>
</div>
 </div>
</div>
</div>
<div class="modal-backdrop fade in" style="display:none;" id="back_ground_modal"></div>

<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

<script type="text/javascript">
var columnArr=[];
var comment_columns=[ {field : 'supplier_name',title : '供应商',width : '110',align : 'center'},
                                        {field : 'linename',title : '线路',width : '200',align : 'center'},
                                        {field : 'content',title : '内容',width : '200',align : 'center',
                                            formatter : function(value, rowData, rowIndex){
                                                var str = "";
                                                if(rowData['s_reply']=="" || rowData['s_reply']==null){
                                                    rowData['s_reply']='未回复';
                                                }if(rowData['a_reply']=="" || rowData['a_reply']==null){
                                                    rowData['a_reply'] = '未回复';
                                                }
                                           if(rowData['content'].length>15){
                                                   return "<p title='"+value+"'>"+value.substring(0,25)+"..."+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
                                                }else{
													 return "<p title='"+value+"'>"+value+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
												}
                                            }
                                        },
                                        {field : 'comment_time',title : '评论时间',align : 'center', width : '110'},
                                        {field : 'line_score',title : '评分',align : 'center', width : '60'},
                                        {field : 'cmp_reason',title : '供应商申诉内容',align : 'center', width : '200'},
                                        {field : 'cm_id',title : '操作',align : 'center', width : '200',
                                            formatter : function(value, rowData, rowIndex){
                                            return "<a onclick='pass(this)' class='btn btn-info btn-xs edit' data-tab='0' data-val='"+value+"|"+rowData['cmp_id']+"|"+rowData['expert_id']+"|"+rowData['line_id']+"'>通过</a> <a onclick='refuse(this)' class='btn btn-danger btn-xs delete' data-tab='0' data-val='"+value+"|"+rowData['cmp_id']+"''>拒绝</a>";
                                            }
                                        }
                 ];
var comment_columns1=[{field : 'linename',title : '线路',width : '260',align : 'center'},
                                        {field : 'm_name',title : '会员',width : '80',align : 'center'},
                                        {field : 'content',title : '内容',width : '260',align : 'center',
                                            formatter : function(value, rowData, rowIndex){
                                                var str = "";
                                                if(rowData['s_reply']=="" || rowData['s_reply']==null){
                                                    rowData['s_reply']='未回复';
                                                }if(rowData['a_reply']=="" || rowData['a_reply']==null){
                                                    rowData['a_reply'] = '未回复';
                                                }
                                            if(rowData['content'].length>15){
                                                   return "<p title='"+value+"'>"+value.substring(0,25)+"..."+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
                                                }else{
													 return "<p title='"+value+"'>"+value+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
												}
                                            }
                                        },
                                        {field : 'comment_time',title : '评论时间',align : 'center', width : '110'},
                                        {field : 'line_score',title : '评分',align : 'center', width : '60'},
                                        {field : 'supplier_name',title : '供应商',width : '110',align : 'center'},
                                        {field : 'cm_id',title : '操作',align : 'center', width : '200',
                                            formatter : function(value, rowData, rowIndex){
                                            return "<a onclick='delete_d(this)' class='btn btn-info btn-xs edit' data-tab='1'  data-val='"+value+"'>删除</a> ";
                                            }
                                        }
                 ];
var comment_columns2=[ {field : 'linename',title : '线路',width : '260',align : 'center'},
                                        {field : 'm_name',title : '会员',width : '80',align : 'center'},
                                        {field : 'content',title : '内容',width : '260',align : 'center',
                                            formatter : function(value, rowData, rowIndex){
                                                var str = "";
                                                if(rowData['s_reply']=="" || rowData['s_reply']==null){
                                                    rowData['s_reply']='未回复';
                                                }if(rowData['a_reply']=="" || rowData['a_reply']==null){
                                                    rowData['a_reply'] = '未回复';
                                                }
                                            if(rowData['content'].length>15){
                                                   return "<p title='"+value+"'>"+value.substring(0,25)+"..."+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
                                                }else{
													 return "<p title='"+value+"'>"+value+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
												}
                                            }
                                        },
                                        {field : 'comment_time',title : '评论时间',align : 'center', width : '110'},
                                        {field : 'line_score',title : '评分',align : 'center', width : '60'},
                                        {field : 'supplier_name',title : '供应商',width : '110',align : 'center'},
                                        {field : 'cm_id',title : '操作',align : 'center', width : '200',
                                            formatter : function(value, rowData, rowIndex){
                                            return "<a onclick='delete_d(this)' class='btn btn-info btn-xs edit' data-tab='2'  data-val='"+value+"'>删除</a> ";
                                            }
                                        }
                 ];
var comment_columns3=[ {field : 'linename',title : '线路',width : '260',align : 'center'},
                                        {field : 'm_name',title : '会员',width : '80',align : 'center'},
                                        {field : 'content',title : '内容',width : '260',align : 'center',
                                            formatter : function(value, rowData, rowIndex){
                                                var str = "";
                                                if(rowData['s_reply']=="" || rowData['s_reply']==null){
                                                    rowData['s_reply']='未回复';
                                                }if(rowData['a_reply']=="" || rowData['a_reply']==null){
                                                    rowData['a_reply'] = '未回复';
                                                }
                                            if(rowData['content'].length>15){
                                                   return "<p title='"+value+"'>"+value.substring(0,25)+"..."+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
                                                }else{
													 return "<p title='"+value+"'>"+value+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
												}
                                            }
                                        },
                                        {field : 'comment_time',title : '评论时间',align : 'center', width : '110'},
                                        {field : 'line_score',title : '评分',align : 'center', width : '60'},
                                        {field : 'supplier_name',title : '供应商',width : '110',align : 'center'}];

var comment_columns4=[ {field : 'linename',title : '线路',width : '260',align : 'center'},
                                        {field : 'm_name',title : '会员',width : '80',align : 'center'},
                                        {field : 'content',title : '内容',width : '260',align : 'center',
                                            formatter : function(value, rowData, rowIndex){
                                                var str = "";

                                                if(rowData['s_reply']=="" || rowData['s_reply']==null){
                                                    rowData['s_reply']='未回复';
                                                }if(rowData['a_reply']=="" || rowData['a_reply']==null){
                                                    rowData['a_reply'] = '未回复';
                                                }
												if(rowData['content'].length>15){
                                                   return "<p title='"+value+"'>"+value.substring(0,25)+"..."+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
                                                }else{
													 return "<p title='"+value+"'>"+value+"</p><p style='color:#9900FF;'>供应商回复:"+rowData['s_reply']+"</p><p style='color:#0066CC'>平台回复:"+rowData['a_reply']+"</p>";
												}


                                            }
                                        },
                                        {field : 'comment_time',title : '评论时间',align : 'center', width : '110'},
                                        {field : 'line_score',title : '评分',align : 'center', width : '80'},
                                        {field : 'cm_id',title : '操作',align : 'center', width : '200',
                                            formatter : function(value, rowData, rowIndex){
                                            return "<a onclick='show_comment_dialog(this)' class='btn btn-info btn-xs edit' data-tab='4'  data-val='"+value+"'>平台回复</a> <a onclick='delete_d(this)' data-tab='4'  class='btn btn-danger btn-xs delete' data-val='"+value+"''>删除</a>";;
                                            }
                                        }
                 ];
columnArr[0] =   comment_columns;
columnArr[1] =   comment_columns1;
columnArr[2] =   comment_columns2;
columnArr[3] =   comment_columns3;
columnArr[4] =    comment_columns4;
var isJsonp= false ;
$(document).ready(function(){
    var loadIndex=[];//记录哪些tab 加载过
    initTableForm("#comment0","#comment_dataTable0",comment_columns,isJsonp ).load();
    loadIndex[0]=0;
    $("#myTab5 li").click(function(){
                    $("#myTab5 li").removeClass("active");
                    $(this).addClass("active");
                    var index=$("#myTab5 li").index($(this));
                    $(".tab-pane").removeClass("active");
                    $(".tab-pane").eq(index).addClass("active");
                     initTableForm("#comment"+(index),"#comment_dataTable"+(index),columnArr[index],isJsonp ).load();
                    if(loadIndex[index]!=index){
                    $.post('/admin/a/comboBox/get_member_data', {}, function(data) {
                        var data = eval('(' + data + ')');
                        var array = new Array();
                        $.each(data, function(key, val) {
                            array.push({
                                text : val.truename,
                                value : val.mid,
                            });
                        })
                        var comboBox = new jQuery.comboBox({
                            id : "#member_name"+index,
                            name : "member_id",// 隐藏的value ID字段
                            query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
                            selectedAfter : function(item, index) {// 选择后的事件

                            },
                            data : array
                        });
                });

                $.post('/admin/a/comboBox/get_expert_data', {}, function(data) {
                    var data = eval('(' + data + ')');
                    var array = new Array();
                    $.each(data, function(key, val) {
                        array.push({
                            text : val.realname,
                            value : val.id,
                        });
                    })
                    var comboBox = new jQuery.comboBox({
                        id : "#expert_name"+index,
                        name : "expert_id",// 隐藏的value ID字段
                        query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
                        selectedAfter : function(item, index) {// 选择后的事件

                        },
                        data : array
                    });
                });


                    $.post('/admin/a/comboBox/get_supplier_data', {}, function(data) {
                        var data = eval('(' + data + ')');
                        var array = new Array();
                        $.each(data, function(key, val) {
                            array.push({
                                text : val.company_name,
                                value : val.id,
                            });
                        })
                        var comboBox = new jQuery.comboBox({
                            id : "#supplier_name"+index,
                            name : "supplier_id",// 隐藏的value ID字段
                            query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
                            selectedAfter : function(item, index) {// 选择后的事件

                            },
                            data : array
                        });
                    });
                }
                loadIndex[index]=index;
});

    $('#comment0_Select').change(function(){
        initTableForm("#comment"+0,"#comment_dataTable"+0,comment_columns,isJsonp ).load();
    });
    $("#searchBtn0").click(function(){
        initTableForm("#comment"+0,"#comment_dataTable"+0,comment_columns,isJsonp ).load();
    });

    $('#comment1_Select').change(function(){
        initTableForm("#comment"+1,"#comment_dataTable"+1,comment_columns1,isJsonp ).load();
    });
    $("#searchBtn1").click(function(){
       initTableForm("#comment"+1,"#comment_dataTable"+1,comment_columns1,isJsonp ).load();
    });

    $('#comment2_Select').change(function(){
        initTableForm("#comment"+2,"#comment_dataTable"+2,comment_columns2,isJsonp ).load();
    });
    $("#searchBtn2").click(function(){
       initTableForm("#comment"+2,"#comment_dataTable"+2,comment_columns2,isJsonp ).load();
    });

    $('#comment3_Select').change(function(){
        initTableForm("#comment"+3,"#comment_dataTable"+3,comment_columns3,isJsonp ).load();
    });
    $("#searchBtn3").click(function(){
       initTableForm("#comment"+3,"#comment_dataTable"+3,comment_columns3,isJsonp ).load();
    });

    $('#comment4_Select').change(function(){
        initTableForm("#comment"+4,"#comment_dataTable"+4,comment_columns4,isJsonp ).load();
    });
    $("#searchBtn4").click(function(){
       initTableForm("#comment"+4,"#comment_dataTable"+4,comment_columns4,isJsonp ).load();
    });

             $.post('/admin/a/comboBox/get_member_data', {}, function(data) {
        var data = eval('(' + data + ')');
        var array = new Array();
        $.each(data, function(key, val) {
            array.push({
                text : val.truename,
                value : val.mid,
            });
        })
        var comboBox = new jQuery.comboBox({
            id : "#member_name0",
            name : "member_id",// 隐藏的value ID字段
            query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
            selectedAfter : function(item, index) {// 选择后的事件

            },
            data : array
        });
    });

    $.post('/admin/a/comboBox/get_expert_data', {}, function(data) {
        var data = eval('(' + data + ')');
        var array = new Array();
        $.each(data, function(key, val) {
            array.push({
                text : val.realname,
                value : val.id,
            });
        })
        var comboBox = new jQuery.comboBox({
            id : "#expert_name0",
            name : "expert_id",// 隐藏的value ID字段
            query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
            selectedAfter : function(item, index) {// 选择后的事件

            },
            data : array
        });
    });


    $.post('/admin/a/comboBox/get_supplier_data', {}, function(data) {
        var data = eval('(' + data + ')');
        var array = new Array();
        $.each(data, function(key, val) {
            array.push({
                text : val.company_name,
                value : val.id,
            });
        })
        var comboBox = new jQuery.comboBox({
            id : "#supplier_name0",
            name : "supplier_id",// 隐藏的value ID字段
            query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
            selectedAfter : function(item, index) {// 选择后的事件

            },
            data : array
        });
    });


});





function pass(obj){
    if(confirm('确认要通过吗?')){
        var id_arr = $(obj).attr('data-val').split('|');
        var tab_index = $(obj).attr('data-tab');
        $.post("<?php echo site_url('admin/a/comment/ajax_pass');?>",
                {'cm_id':id_arr[0],'cmp_id':id_arr[1],'expert_id':id_arr[2],'line_id':id_arr[3]},
                function(data){
                    alert(data);
                    initTableForm("#comment"+tab_index,"#comment_dataTable"+tab_index,columnArr[tab_index],isJsonp ).load();
                });
    }
}

function delete_d(obj){
    if(confirm('确认要删除吗?')){
           var id_arr = $(obj).attr('data-val');
           var tab_index = $(obj).attr('data-tab');
        $.post("<?php echo site_url('admin/a/comment/ajax_delete');?>",
                {'cm_id':id_arr},
                function(data){
                    alert(data);
                     initTableForm("#comment"+tab_index,"#comment_dataTable"+tab_index,columnArr[tab_index],isJsonp ).load();
                });
    }
}

function refuse(obj){
    if(confirm('确认要拒绝吗?')){
         var id_arr = $(obj).attr('data-val').split('|');
         var tab_index = $(obj).attr('data-tab');
        $.post("<?php echo site_url('admin/a/comment/ajax_refuse');?>",
                {'cm_id':id_arr[0],'cmp_id':id_arr[1]},
                function(data){
                    alert(data);
                    initTableForm("#comment"+tab_index,"#comment_dataTable"+tab_index,columnArr[tab_index],isJsonp ).load();
                });
    }
}


function show_comment_dialog(obj){
     var comment_id = $(obj).attr('data-val');
     $("#comment_id").val(comment_id);
     $("#back_ground_modal").show();
      $("#comment_reply_modal").show();
}

function hidden_modal(){
    $("#comment_id").val('');
    $("#cotent_comment").val('');
    $("#back_ground_modal").hide();
    $("#comment_reply_modal").hide();

}

$('#comment_reply_modal_form').submit(function(){
            $.post(
                "<?php echo site_url('admin/a/comment/reply_comment');?>",
                $('#comment_reply_modal_form').serialize(),
                function(data) {
                    data = eval('('+data+')');
                    if (data.status == 200) {
                        alert(data.msg);
                        hidden_modal();
                         initTableForm("#comment4","#comment_dataTable4",comment_columns4,isJsonp ).load();
                    } else {
                        alert(data.msg);
                    }
                }
            );
            return false;
        });
$('.comment_time').daterangepicker();
</script>


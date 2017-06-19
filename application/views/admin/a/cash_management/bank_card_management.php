<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<?php  $this->load->view("admin/t33/common/js_view"); ?>

<style type="text/css">
.page_content { margin-top:0;padding-top:5px;}
.search_form  { margin:0;}
.search_form_box .search_group label { width:auto;}
.search_group { margin-right:20px;}
.search_input { height:auto !important;line-height:23px !important;padding:0 2px !important;border:1px solid #bbb !important;font-size:13px !important;}
.search_button { margin:0;}
.table-bordered { border-collapse:collapse;}
.data_rows tr td { text-align:center !important;}
.underline { text-decoration:underline;}
.table_list { min-height:300px;}
</style>
</head>
<body>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">      
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">               
            <!-- tab切换表格 -->
            <div class="table_content clear">
                <div class="tab_content">
                        <form class="search_form" id="search-condition"method="post" action="">
                            <div class="search_form_box clear">

                                <div class="search_group">
                                    <label>银行卡查询：</label>
                                    <input type="text" name="name" class="search_input" style="width:120px;"/>
                                </div>
                                
                                <div class="search_group">
                                    <input type="button" name="button" class="search_button" value="搜索"/>
                                </div>
                            </div>
                        </form>
                    
                </div>
                <div id="page_div"></div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>

</html>

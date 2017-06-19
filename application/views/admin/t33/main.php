<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试模板</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/style.css" rel="stylesheet">
<link href="/assets/ht/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
</style>
</head>
<body>
<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">测试模板</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">发布通知</a></li> 
                        <li static="2"><a href="#tab2" class="">自定义</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <div class="search_group">
                                    <label>目的地</label>
                                    <input type="text" name="" class="search_input" placeholder="目的地"/>
                                </div>
                                <div class="search_group">
                                    <label>产品名称</label>
                                    <input type="text" name="" class="search_input" placeholder="产品名称" value="禁用input" disabled="disabled"/>
                                </div>
                                <div class="search_group input-group">
                                	<label>出发日期</label>
                                    <!--<span class="calender_ico">
                                        <i></i>
                                    </span> -->
                                     <input class="search_input" type="text" id="date" data-date-format="yyyy-mm-dd" value="" placeholder="YYYY-MM-DD">
                                </div>
                                <div class="search_group">
                                    <label>订单编号</label>
                                    <input type="text" name="" class="search_input" placeholder="订单编号"/>
                                </div>
                                <div class="search_group">
                                    <label>产品价格</label>
                                    <div class="form_select">
                                        <div class="search_select">
                                            <div class="show_select">请选择</div>
                                            <ul class="select_list">
                                                <li value="0">请选择</li>
                                                <li value="1">0-100</li>
                                                <li value="2">100-200</li>
                                                <li value="3">200-500</li>
                                                <li value="4">500-1000</li>
                                                <li value="5">1000-2000</li>
                                                <li value="6">2000-5000</li>
                                                <li value="7">5000-10000</li>
                                                <li value="8">10000-20000</li>
                                                <li value="9">20000-50000</li>
                                                <li value="10">50000-100000</li>
                                                <li value="11">100000-1000000</li>
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                    </div>
                                </div>
                                <div class="search_group">
                                    <label>管家类型</label>
                                    <div class="form_select">
                                        <div class="search_select">
                                            <div class="show_select" status="1">请选择</div>
                                            <ul class="select_list">
                                                <li value="0">请选择</li>
                                                <li value="1">管家</li>
                                                <li value="2">初级管家</li>
                                                <li value="3">中级管家</li>
                                                <li value="4">高级管家</li>
                                                <li value="5">明星管家</li>
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                    </div>
                                </div>
                                <div class="search_group">
                                    <input type="submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th> 线路编号</th>
                                    <th>线路标题</th>
                                    <th>出发地</th>
                                    <th>佣金比例</th>
                                    <th>供应商名称</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>L673</td>
                                    <td style="text-align:left" title="海外技术部马尔代夫欢乐岛Fun1晚1天游">
                                        <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=673">海外技术部马尔代夫欢乐岛Fun</a>
                                    </td>
                                    <td>深圳市</td>
                                    <td>1%</td>
                                    <td>深圳海外国际技术部</td> 
                                </tr>
                                <tr>
                                    <td>L678</td>
                                    <td style="text-align:left" title="海外国旅厦门-鼓浪屿双动1晚1天游">
                                        <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=678">海外国旅厦门-鼓浪屿双动1晚1</a>
                                    </td>
                                    <td>深圳市</td>
                                    <td>2%</td>
                                    <td>中国移动有限公司</td>
                                </tr>
                                <tr>
                                    <td>L451</td>
                                    <td style="text-align:left" title="你游我游曼巴普">
                                        <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=451">你游我游曼巴普</a>
                                    </td>
                                    <td>韶关市</td>
                                    <td>10%</td>
                                    <td>中国移动有限公司</td> 
                                </tr>
                                <tr>
                                    <td>L301</td>
                                    <td style="text-align:left" title="巴厘岛俱乐部最美离岛 奢享四季巴厘岛4天3晚游">
                                        <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=301">巴厘岛俱乐部最美离岛 奢享四季</a>
                                    </td>
                                    <td>韶关市</td>
                                    <td>2%</td>
                                    <td>中国移动有限公司</td>
                                </tr>
                                <tr>
                                    <td>L155</td>
                                    <td style="text-align:left" title="泰国缤纷美食享乐6天品质团(报名送价值299元泰国电话卡、半自由行)">
                                        <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=155">泰国缤纷美食享乐6天品质团(报</a>
                                    </td>
                                    <td>鞍山市</td>
                                    <td>2%</td>
                                    <td>中国移动有限公司</td> 
                                </tr>
    
                            </tbody>
                        </table>
                    </div>                   
                </div>
            </div>
            <div class="table_content">
                <div class="itab">
                    <ul> 
                        <li status="1"><a href="###" class="active">儿童</a></li> 
                        <li status="2"><a href="###">少年</a></li> 
                        <li status="3"><a href="###">青年</a></li> 
                        <li status="4"><a href="###">中年</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th> 线路编号</th>
                                    <th>线路标题</th>
                                    <th>出发地</th>
                                    <th>目的地</th>
                                    <th>佣金比例</th>
                                    <th>供应商名称</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>L673</td>
                                    <td style="text-align:left" title="海外技术部马尔代夫欢乐岛Fun1晚1天游">
                                        <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=673">海外技术部马尔代夫欢乐岛Fun</a>
                                    </td>
                                    <td>深圳市</td>
                                    <td>深圳市</td>
                                    <td>1%</td>
                                    <td>深圳海外国际技术部</td> 
                                    <td><a href="#" class="action_type">链接类型</a></td> 
                                </tr>
                                <tr>
                                    <td>L678</td>
                                    <td style="text-align:left" title="海外国旅厦门-鼓浪屿双动1晚1天游">
                                        <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=678">海外国旅厦门-鼓浪屿双动1晚1</a>
                                    </td>
                                    <td>深圳市</td>
                                    <td>深圳市</td>
                                    <td>2%</td>
                                    <td>中国移动有限公司</td>
                                    <td><a href="#" class="action_type">链接类型</a>&nbsp;<a href="#" class="action_type">链接类型</a>&nbsp;<a href="#" class="action_type">链接类型</a>&nbsp;<a href="#" class="action_type">链接类型</a></td> 
                                </tr>
                                <tr>
                                    <td>L451</td>
                                    <td style="text-align:left" title="你游我游曼巴普">
                                        <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=451">你游我游曼巴普</a>
                                    </td>
                                    <td>韶关市</td>
                                    <td>深圳市</td>
                                    <td>10%</td>
                                    <td>中国移动有限公司</td> 
                                    <td><!--<span class="btn btn_green">按钮类型</span> --></td> 
                                </tr> 
                                <tr>
                                    <td>L451</td>
                                    <td style="text-align:left" title="你游我游曼巴普">
                                        <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=451">你游我游曼巴普</a>
                                    </td>
                                    <td>韶关市</td>
                                    <td>深圳市</td>
                                    <td>10%</td>
                                    <td>中国移动有限公司</td> 
                                    <td><!--<span class="btn btn_green">按钮类型</span>&nbsp;<span class="btn btn_blue">按钮类型</span>&nbsp;<span class="btn btn_yellow">按钮类型</span>&nbsp;<span class="btn btn_red">按钮类型</span> --></td> 
                                </tr> 
                            </tbody>
                        </table>
                    </div>

                </div> 
            </div>         

            <!-- 消息提示框 -->
            <div style="margin-top:20px;margin-left:40px;">
            	<div style="margin-bottom:20px;">
                	<span class="alert_msg1 btn btn_green">信息框1</span>
                    <span class="alert_msg2 btn btn_green">信息框2</span>
                    <span class="alert_msg3 btn btn_green">信息框3</span>
                    <span class="alert_msg4 btn btn_green">信息框4</span>
                    <span class="alert_msg5 btn btn_green">信息框5</span>
                </div>
                <div style="margin-bottom:20px;">
                	<span class="alert_msg6 btn btn_green">页面层/iframe层1</span>
                    <span class="alert_msg7 btn btn_green">页面层/iframe层2</span>
                    <span class="alert_msg8 btn btn_green">页面层/iframe层3</span>
                    <span class="alert_msg9 btn btn_green">页面层/iframe层4</span>
                    <span class="alert_msg10 btn btn_green">页面层/iframe层5</span>
                </div>
                <div style="margin-bottom:20px;">
                	<span class="alert_msg11 btn btn_green">加载层1</span>
                    <span class="alert_msg12 btn btn_green">加载层2</span>
                    <span class="alert_msg13 btn btn_green">加载层3</span>
                    <span class="alert_msg14 btn btn_green">加载层4</span>
                    <span class="alert_msg15 btn btn_green">加载层5</span>
                </div>
                <div style="margin-bottom:20px;">
                	<span class="alert_msg16 btn btn_green">tips提示层1</span>
                    <span class="alert_msg17 btn btn_green">tips提示层2</span>
                    <span class="alert_msg18 btn btn_green">tips提示层3</span>
                    <span class="alert_msg19 btn btn_green">tips提示层4</span>
                    <span class="alert_msg20 btn btn_green">tips提示层5</span>
                </div>
                <div style="margin-bottom:20px;">
                	<span class="alert_msg21 btn btn_green">默认prompt</span>
                    <span class="alert_msg22 btn btn_green">屏蔽浏览器滚动条</span>
                    <span class="alert_msg23 btn btn_green">弹出即全屏</span>
                    <span class="alert_msg24 btn btn_green">正上方提示</span>
                </div>
                <div style="margin-bottom:20px;">
                	<span class="alert_msg25 btn btn_green">额度申请</span>
                    <span class="alert_msg26 btn btn_green">额度审批</span>
                </div>
            </div>
            
			<div style="height:40px;"></div>
            
        </div>
        
        <div class="table_content">
        	<h3>团队管理/团队收款列表</h3>
        	<div class="table_list">
            	<form class="search_form" method="post" action="">
                    <div class="search_form_box clear">
                        <div class="search_group">
                            <label>线路标题</label>
                            <input type="text" name="" class="search_input" value=""/>
                        </div>
                        <div class="search_group input-group">
                            <label>出团日期</label>
                            <input class="search_input" type="text" id="date1" data-date-format="yyyy-mm-dd" value="" style="width:90px;">
                            <span class="fl">~</span>
                            <input class="search_input" type="text" id="date2" data-date-format="yyyy-mm-dd" value="" style="width:90px;"/>
                        </div>
                        <div class="search_group">
                            <label>行程天数</label>
                            <input type="text" name="" class="search_input" style="width:30px;"/>
                            <span class="fl">~</span>
                            <input type="text" name="" class="search_input" style="width:30px;"/>
                        </div>
                        <div class="search_group">
                            <input type="submit" name="submit" class="search_button" value="查询"/>
                        </div>
                    </div>
                    <table class="table table-bordered table_hover">
                        <thead class="th-border">
                            <tr>
                                <th width="30"></th>
                                <th>团号</th>
                                <th style="text-align:left;">产品标题</th>
                                <th>出团日期</th>
                                <th>团队人数</th>
                                <th style="text-align:left;">已订人数</th>
                                <th style="text-align:right;">应收总计</th>
                                <th style="text-align:right;">已收款总额</th>
                                <th style="text-align:right;">成本总计</th>
                                <th>未结算</th>
                                <th>已结算</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            	<td class="control_td"><span class="con_txt" onclick="show_order(this,1);" data-id="11">+</span></td> 
                                <td>p1345160909</td>
                                <td style="text-align:left;"><a href="#">泰国五天四晚品质游</a></td>
                                <td>2016-10-08</td>
                                <td>50</td>
                                <td style="text-align:left;">0+0+0+0</td>
                                <td style="text-align:right;">6000</td>
                                <td style="text-align:right;">5000</td>
                                <td style="text-align:right;">4000</td>
                                <td>2000</td>
                                <td>4000</td>
                            </tr>
                            <tr>
                            	<td class="control_td"></td> 
                                <td>p1345160909</td>
                                <td style="text-align:left;"><a href="#">泰国五天四晚品质游</a></td>
                                <td>2016-10-08</td>
                                <td>50</td>
                                <td style="text-align:left;">0+0+0+0</td>
                                <td style="text-align:right;">6000</td>
                                <td style="text-align:right;">5000</td>
                                <td style="text-align:right;">4000</td>
                                <td>2000</td>
                                <td>4000</td>
                            </tr>
                            <tr>
                            	<td class="control_td"></td> 
                                <td>p1345160909</td>
                                <td style="text-align:left;"><a href="#">泰国五天四晚品质游</a></td>
                                <td>2016-10-08</td>
                                <td>50</td>
                                <td style="text-align:left;">0+0+0+0</td>
                                <td style="text-align:right;">6000</td>
                                <td style="text-align:right;">5000</td>
                                <td style="text-align:right;">4000</td>
                                <td>2000</td>
                                <td>4000</td>
                            </tr>
                            <tr>
                            	<td class="control_td"><span class="con_txt" onclick="show_order(this,1);" data-id="33">+</span></td> 
                                <td>p1345160909</td>
                                <td style="text-align:left;"><a href="#">泰国五天四晚品质游</a></td>
                                <td>2016-10-08</td>
                                <td>50</td>
                                <td style="text-align:left;">0+0+0+0</td>
                                <td style="text-align:right;">6000</td>
                                <td style="text-align:right;">5000</td>
                                <td style="text-align:right;">4000</td>
                                <td>2000</td>
                                <td>4000</td>
                            </tr>
                            <tr>
                            	<td class="control_td"><span class="con_txt" onclick="show_order(this,1);" data-id="33">+</span></td> 
                                <td>p1345160909</td>
                                <td style="text-align:left;"><a href="#">泰国五天四晚品质游</a></td>
                                <td>2016-10-08</td>
                                <td>50</td>
                                <td style="text-align:left;">0+0+0+0</td>
                                <td style="text-align:right;">6000</td>
                                <td style="text-align:right;">5000</td>
                                <td style="text-align:right;">4000</td>
                                <td>2000</td>
                                <td>4000</td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        
    </div>
<div class="fb-content" id="form1" style="display:none;">
    <div class="box-title">
        <h4>首页管家配置</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">所在地：<i>*</i></div>
                <div class="fg-input" id="add-city"><select name="country" style="width:137px"><option value="0">请选择</option><option value="1">境外</option><option value="2">中国</option></select><select name="province" style="width: 137px; display: none;"><option value="0">请选择</option></select><select name="city" style="width: 137px; display: none;"><option value="0">请选择</option></select></div>
            </div>
            <div class="form-group">
                <div class="fg-title">选择管家：<i>*</i></div>
                <div class="fg-input">
                    <input type="text" name="realname" readonly="readonly" id="clickChoiceExpert">
                    <input type="hidden" name="expertId" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="fg-title">管家类型：<i>*</i></div>
                <div class="fg-input">
                    <select name="location">
                        <option value="0">请选择</option><option value="1">首页中间</option><option value="2">首页右侧</option><option value="3">首页底部</option><option value="4">最美管家</option>						</select>
                </div>
            </div>
            <div class="form-group">
                <div class="fg-title">排序：</div>
                <div class="fg-input"><input type="text" class="showorder" name="showorder"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">头像：</div>
                <div class="fg-input">
                    <input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" type="hidden" value="">
                    <span>不上传则默认管家头像</span>
                </div>
            </div>
            <div class="form-group">
                <div class="fg-title">备注：</div>
                <div class="fg-input"><textarea name="beizhu" maxlength="30" placeholder="最多30个字"></textarea></div>
            </div>
            <div class="form-group">
                <div class="fg-title">是否显示：</div>
                <div class="fg-input">
                    <ul>
                        <li><label><input type="radio" class="fg-radio" name="is_show" value="0">否</label></li>
                        <li><label><input type="radio" class="fg-radio" name="is_show" checked="checked" value="1">是</label></li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <div class="fg-title">是否可更改：</div>
                <div class="fg-input">
                    <ul>
                        <li><label><input type="radio" class="fg-radio" name="is_modify" value="0">否</label></li>
                        <li><label><input type="radio" class="fg-radio" name="is_modify" checked="checked" value="1">是</label></li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<div class="fb-content" id="limit_apply" style="display:none;">
    <div class="box-title">
        <h4>新增额度&nbsp;&nbsp;&nbsp;&nbsp;申请单</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
    	<div class="status_box">
        	<ul class="clear">
            	<li class="on"><span class="time current_time">2016-8-24 11:03</span><i></i><span class="txt">新增申请</span></li>
                <li><span class="time"></span><i></i><span class="txt">经理审批</span></li>
                <li><span class="time"></span><i></i><span class="txt">旅行社/供应商授权</span></li>
                <li><span class="time"></span><i></i><span class="txt">已还款</span></li>
            </ul>
        </div>
        <form method="post" action="#" id="add-data" class="form-horizontal">
            <div class="form_con limit_apply">
            	<table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                	<tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>申请额度:</td>
                        <td colspan="3"><input type="text" class="w_200"/></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">编号:</td>
                        <td colspan="3">自动生成</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>申请日期:</td>
                        <td><input type="text" class="w_200" id="date1"/></td>
                        <td class="order_info_title"><i class="important_title">*</i>还款日期:</td>
                        <td><input type="text" class="w_200" id="date2"/></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请人:</td>
                        <td>张三（tips:登录账号名字）</td>
                        <td class="order_info_title">营业部:</td>
                        <td>东门营业部（tips:登录账号所属的营业部名称）</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">说明:</td>
                        <td colspan="3"><input type="text" class="w_600"/></td>
                    </tr>

                </table>
            </div>
            <div class="form_btn clear">
                <input type="submit" name="submit" value="提交审核" class="btn btn_blue" style="margin-left:220px;">
                <input type="reset" name="reset" value="关闭" class="layui-layer-close btn btn_gray">
            </div>
        </form>
    </div>
</div>
<div class="fb-content" id="limit_approve" style="display:none;">
    <div class="box-title">
        <h4>额度审批</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
		<div class="status_box">
        	<ul class="clear">
            	<li class="on"><span class="time">2016-8-24 11:03</span><i></i><span class="txt">新增申请</span></li>
                <li class="on"><span class="time">2016-8-24 11:03</span><i></i><span class="txt">经理审批</span></li>
                <li class="on"><span class="time">2016-8-24 11:03</span><i></i><span class="txt">旅行社/供应商授权</span></li>
                <li><span class="time"></span><i></i><span class="txt">已还款</span></li>
            </ul>
        </div>
        <form method="post" action="#" id="add-data" class="form-horizontal">
            <div class="form_con limit_apply">
            	<table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                	<tr height="40">
                        <td class="order_info_title">申请额度:</td>
                        <td colspan="3"><span style="color:red;">10000</span></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">编号:</td>
                        <td colspan="3">10001</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请日期:</td>
                        <td>2016-8-24</td>
                        <td class="order_info_title">还款日期:</td>
                        <td>2016-8-24</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请人:</td>
                        <td>张三</td>
                        <td class="order_info_title">营业部:</td>
                        <td>东门营业部</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">说明:</td>
                        <td colspan="3">的娃娃大大哇的</td>
                    </tr>
					<tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>审核意见:</td>
                        <td colspan="3"><input type="text" class="w_600"/></td>
                    </tr>
                </table>
            </div>
            <div class="choose_title"><label><input type="checkbox" name="" class=""/>同意审批后，授信额度风险由供应商承担。</label></div>
            <div class="form_btn clear">
                <input type="submit" name="submit" value="提交审核" class="btn btn_blue" style="margin-left:220px;">
                <input type="button" name="" value="拒绝" class="btn btn_blue" style="margin-left:80px;">
                <input type="reset" name="reset" value="关闭" class="layui-layer-close btn btn_gray" style="margin-left:80px;">
            </div>
        </form>
    </div>
</div>

<div id="expert_img" class="layui-layer-wrap" style="display: none;"><img src="/assets/ht/img/expert1_03.png" style="width:100%;"/></div>

<script>
;!function(){

//页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
layer.ready(function(){ 
  //官网欢迎页
  /*layer.open({
    type: 2,
    skin: 'layui-layer-lan',
    title: 'layer弹层组件',
    fix: false,
    shadeClose: true,
    maxmin: true,
    area: ['1000px', '500px'],
    content: 'http://layer.layui.com/?form=local',
    end: function(){
      layer.tips('试试相册模块？', '#photosDemo', {tips: 1})
    }
  });*/
  
  //layer.msg('欢迎使用layer');
  
  //使用相册
  /*layer.photos({
    photos: '#photosDemo'
  });*/
});

}();
</script>
<script type="text/javascript">
$(function(){
	$('#date,#date1,#date2').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//弹框
	$(".alert_box1").click(function(){
		var win1= $("#box_content1");
		win1.show();
		$("#left_nav").css("z-index","-1");
		$("#hide_box").show();
       
	});
	$(".alert_box2").click(function(){
		//layer.alert('见到你真的很高兴', {icon: 1});
		layer.alert(layer.v + ' - 贤心出品');
	});
	//alertBox("消息提示框测试");
	$(".alert_msg1").click(function(){
		layer.alert('见到你真的很高兴', {icon: 1,title:'达瓦达瓦'});
	});
	$(".alert_msg2").click(function(){
		/*layer.msg('你确定你很帅么？', {
		  time: 0 //不自动关闭
		  ,btn: ['必须啊', '丑到爆']
		  ,yes: function(index){
			layer.close(index);
			layer.msg('你是男是女？？', {
			  time: 0 //不自动关闭
			  ,icon: 6
			  ,btn: ['男','女','人妖']
			  ,yes: function(){
			  	 layer.msg('呵呵哒');
			  }
			});
		  }
		});*/
		layer.confirm('您是如何看待前端开发？', {
		  btn: ['重要','奇葩','哈哈','呵呵'] //按钮
		}, function(){
		  layer.msg('的确很重要', {icon: 1});
		}, function(){
		  layer.msg('也可以这样', {
			time: 20000, //20s后自动关闭
			btn: ['明白了', '知道了']
		  });
		}, function(){
		  layer.msg('的确很重要2', {icon: 1});
		}, function(){
		  layer.msg('的确很重要3', {icon: 1});
		});
	});
	$(".alert_msg3").click(function(){
		layer.msg('这是最常用的吧');		
	});
	$(".alert_msg4").click(function(){
		layer.msg('不开心。。', {icon: 6});
	});
	$(".alert_msg5").click(function(){
		layer.msg('玩命卖萌中', function(){
			//关闭后的操作
			layer.msg('你个逗逼', {icon: 6});
		});
	});
	$(".alert_msg6").click(function(){
		layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  shadeClose: true,
		  skin: 'yourclass',
		  content: '<p>自定义HTML内容</p><div style="margin:20px 40px;"><img src="./img/clock_positive_lg.gif"/></div>'
		});
	});	
	$(".alert_msg7").click(function(){
		layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  //skin: 'layui-layer-nobg', //没有背景色
		  shadeClose: false,
		  content: $('#form1')
		});
	});
	$(".alert_msg8").click(function(){
		window.top.openWin({
		  type: 2,
		  area: ['800px', 'auto'],
		  fix: true, //不固定
		  maxmin: true,
		  shadeClose: false,
		  content: '<?php echo base_url();?>admin/t33/home/test'
		});
	});
	$(".alert_msg9").click(function(){
		window.top.openWin({
		  type: 2,
		  title: false,
		  area: ['800px', '500px'],
		  shade: 0.8,
		  closeBtn: 0,
		  shadeClose: true,
		  content: 'http://player.youku.com/embed/XMjY3MzgzODg0'
		});
		layer.msg('点击任意处关闭');
	});
	$(".alert_msg10").click(function(){
		//iframe层-禁滚动条
		layer.open({
		  type: 2,
		  area: ['360px', '500px'],
		  skin: 'layui-layer-rim', //加上边框
		  content: ['http://layer.layui.com/mobile', 'no']
		});
	});
	$(".alert_msg11").click(function(){
		//加载层-默认风格
		layer.load();
		//此处演示关闭
		setTimeout(function(){
		  layer.closeAll('loading');
		}, 2000);
	});
	$(".alert_msg12").click(function(){
		//加载层-风格2
		layer.load(1);
		//此处演示关闭
		setTimeout(function(){
		  layer.closeAll('loading');
		}, 2000);
	});
	$(".alert_msg13").click(function(){
		//加载层-风格3
		layer.load(2);
		//此处演示关闭
		setTimeout(function(){
		  layer.closeAll('loading');
		}, 2000);
	});
	$(".alert_msg14").click(function(){
		//加载层-风格4
		layer.msg('加载中', {icon: 16});
	});
	$(".alert_msg15").click(function(){
		//打酱油
		layer.msg('尼玛，打个酱油', {icon: 4});
	});
	$(".alert_msg16").click(function(){
		//tips层-上
		layer.tips('上', '.alert_msg16', {
		  tips: [1, '#0FA6D8'] //还可配置颜色
		});
	});
	$(".alert_msg17").click(function(){
		//tips层-右
		layer.tips('默认就是向右的', '.alert_msg17');
	});
	$(".alert_msg18").click(function(){
		//tips层-下
		layer.tips('下', '.alert_msg18', {
		  tips: 3
		});
	});
	$(".alert_msg19").click(function(){
		//tips层-左
		layer.tips('左边么么哒', '.alert_msg19', {
		  tips: [4, '#78BA32']
		});
	});
	$(".alert_msg20").click(function(){
		//tips层-不销毁之前的
		layer.tips('不销毁之前的', '.alert_msg20', {
		  tipsMore: true
		});
	});
	$(".alert_msg21").click(function(){
		layer.prompt(function(val){
		  layer.msg('得到了'+val);
		  console.log(val);
		});

	});
	$(".alert_msg22").click(function(){
		//屏蔽浏览器滚动条
		layer.open({
		  content: '浏览器滚动条已锁',
		  scrollbar: false
		});
	});
	$(".alert_msg23").click(function(){
		//弹出即全屏
		var index = layer.open({
		  type: 2,
		  content: 'http://layim.layui.com',
		  area: ['320px', '195px'],
		  maxmin: true
		});
		layer.full(index);
	});
	$(".alert_msg24").click(function(){
		//正上方
		layer.msg('灵活运用offset', {
		  offset: 50,
		  shift: 6
		});
	});
	
	$(".alert_msg25").click(function(){
		var date = new Date();
		var text = date.getFullYear()
				+"-"
				+ ((date.getMonth() + 1) > 10 ? (date.getMonth() + 1) : "0" + (date.getMonth() + 1))              
				+ "-"
                + (date.getDate() < 10 ? "0" + date.getDate() : date.getDate())                        
                + " "
                + (date.getHours() < 10 ? "0" + date.getHours() : date.getHours())                        
                + ":"
                + (date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes());
                        
		//=console.log(text);
		$(".current_time").html(text);
		layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '800px',
		  //skin: 'layui-layer-nobg', //没有背景色
		  shadeClose: false,
		  content: $('#limit_apply')
		});
	});
	$(".alert_msg26").click(function(){
		layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '800px',
		  //skin: 'layui-layer-nobg', //没有背景色
		  shadeClose: false,
		  content: $('#limit_approve')
		});
	});
	$('#date1').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	$('#date2').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	
});
	function show_order(obj,type){
		var id = $(obj).attr("data-id");
		if(type==1){
			var html = '<tr class="order_table"><td colspan="11" style="padding:0;"><div style="padding:5px 5px 5px 30px;"><table class="table table-bordered" width="100%">';
				html+='<thead class="th-border"><tr>';
				html+='<th>订单编号</th>';
				html+='<th>线路编号</th>';
				html+='<th>参团人数</th>';
				html+='<th>出团日期</th>';
				html+='<th>行程天数</th>';
				html+='<th>下单时间</th>';
				html+='<th>下单类型</th>';
				html+='<th>销售员</th>';
				html+='<th>订单状态</th>';
                html+='</tr></thead><tbody>';
			for(var i = 0;i<5;i++){
				html+='<tr>';
				html+='<td>160918404596</td>';
				html+='<td>L101</td>';
				html+='<td>5</td>';
				html+='<td>2016-10-18</td>';
				html+='<td>3</td>';
				html+='<td>2016-10-08 16:07:05</td>';
				html+='<td>用户下单</td>';
				html+='<td>李思思</td>';
				html+='<td>已取消</td>';
				html+='</tr>';
			}				
			html+='</tbody></table></div></td></tr>';
			$(obj).parent().parent().after(html);
			$(obj).html("-").attr("onclick","show_order(this,2);");
		}else{
			$(obj).html("+").attr("onclick","show_order(this,1);");
			$(obj).parent().parent().next().remove();
		}
		
		
	}

	function getValue(){
		var data = parent.$('#val_box').text();
		layer.msg('得到了'+data);
		console.log(data);
	}
</script>
</html>



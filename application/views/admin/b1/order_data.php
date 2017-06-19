<style type="text/css">
	.form-group label{ float: left; width: 100px;}
	.col-lg-4{float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.widget-body {padding: 12px}
	.fg_div{ float: left; margin-top: 2px;}
	.form-control, select {padding: 6px;}
	#registration-form { padding-top: 15px;}
	.pagination { padding-bottom: 20px;}
	
	#registration-form form .form-group { width:1000px;}
	.fg_div input { width:100px !important;}
	.fg_div input.btn { width:40px !important;}
	.fg_div label.col-lg-4 { display:inline-block;width:60px !important;text-align:right;}
	#search-dest select:first-child,#search-dest1 select:first-child,#search-dest2 select:first-child,#search-dest3 select:first-child,#search-dest4 select:first-child,#search-dest5 select:first-child,#search-dest6 select:first-child,#search-dest7 select:first-child{ width:100px !important;} 
</style>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />	
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">订单管理</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->
	<div class="widget flat radius-bordered search_box">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs" id=""><a href="#home10" data-toggle="tab" id="tab"> 全部 </a></li>
					<li class="" name="tabs" id=""><a href="#home11" data-toggle="tab" id="tab0"> 未确认 </a></li>
					<!-- <li class="" name="tabs" ><a href="#profile11" data-toggle="tab" id="tab1"> 已预留位 </a></li> -->
					<li class="" name="tabs" ><a href="#profile12" data-toggle="tab" id="tab2"> 已确认 </a></li>
					<li class="" name="tabs" ><a href="#profile5" data-toggle="tab" id="tab4"> 出团中 </a></li>
					<li class="" name="tabs" ><a href="#profile6" data-toggle="tab" id="tab5"> 行程结束 </a></li>
					<li class="" name="tabs" ><a href="#profile13" data-toggle="tab" id="tab3"> 已拒绝 </a></li>
					<li class="" name="tabs" ><a href="#profile14" data-toggle="tab" id="tab6"> 改价/退团 </a></li>
				</ul>
				<div class="tab-content tabs-flat">
				<!-- 全部订单 -->
					<div class="tab-pane active" id="home">
						<div class="widget-body">
							<div id="registration-form">
								<form  class="form-horizontal bv-form" method="post" id="searchForm" novalidate="novalidate">
									<div class="form-group has-feedback">
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路名称：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
							                                <div class="fg_div" ><label class="col-lg-4 control-label" >出团日期：</label>
							                                            <div class="col-lg-4" style="width: 220px;">
							                                                <div class="input-group">
							                                                	<input type="text" id="starttime" name="starttime"
												class="form-control user_name_b1">
												<input type="text" id="endtime" name="endtime"
												class="form-control user_name_b1">
							                                       <!--          <span class="input-group-addon"> <i class="fa fa-calendar"></i>
							                                       </span> <input style="width:160px !important;" type="text" class="form-control" id="reservation" name="line_time"> -->
							                                                </div> 
							                                            </div>
										</div>
                                        
										<div class="fg_div" ><label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="ordersn"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >管家：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" class="form-control" style="width:140px;" id="expert_name"  name="expert_name">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >团队编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linesn"
												class="form-control user_name_b1">
										</div></div>
								
										<div class="fg_div" ><label class="col-lg-4 control-label" >出发地：</label>
										<div class="col-lg-4" style="width:120px">
											<span id='search-city'></span>
										</div></div>
												
										<div style="float:left;margin-top:2px;"><label class="col-lg-4 control-label" style="width: 60px !important;" >目的地：</label>
										<div class="col-lg-4" style="width: 280px;">
											  <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										      <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>
										</div>
										
										<div class="fg_div">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn">
										</div>
										<div class="fg_div"  style="margin-left:50px;">
											<input type="button" value="导出" data="0" class="btn btn-palegreen" id="export_order_message" onclick="export_order(0)">
										</div>
									</div>
								</form>
	
								<div id="order_list"></div>
							</div>
						</div>
					</div>
				<!-- 未确认 -->
					<div class="tab-pane" id="home0">
						<div class="widget-body">
							<div id="registration-form">
								<form  class="form-horizontal bv-form" method="post" id="searchForm0" novalidate="novalidate">
									<div class="form-group has-feedback">
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路名称：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
						                <div class="fg_div" ><label class="col-lg-4 control-label" >出团日期：</label>
						                     <div class="col-lg-4" style="width: 220px;">
						                         <div class="input-group">
						                              <input type="text" id="starttime" name="starttime" class="form-control user_name_b1">
													  <input type="text" id="endtime" name="endtime" class="form-control user_name_b1">
						                              <!-- <span class="input-group-addon"> <i class="fa fa-calendar"></i>
						                              </span> <input style="width:160px !important;" type="text" class="form-control" id="reservation1" name="line_time"> -->
						                         </div> 
						                     </div>
										</div>
                                        
										<div class="fg_div" ><label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="ordersn"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >管家：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" class="form-control" style="width:140px;" id="expert_name1"  name="expert_name">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >团队编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linesn"
												class="form-control user_name_b1">
										</div></div>
										<!--  <div class="fg_div" ><label class="col-lg-4 control-label" >目的地：</label>
										<div class="col-lg-4" style="width: auto;">
											<span id="search-dest1"></span>
										</div></div>-->
										
										<div class="fg_div" ><label class="col-lg-4 control-label" >出发地：</label>
										<div class="col-lg-4" style="width:120px;">
											<span id='search-city1'></span>
										</div></div>
										
										<div style="float:left;margin-top:2px;"><label class="col-lg-4 control-label" style="width: 60px !important;" >目的地：</label>
										<div class="col-lg-4" style="width: 280px;">
											  <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										      <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>
										</div>
										
										<div class="fg_div">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn0">
										</div>
										<div class="fg_div"  style="margin-left:50px;">
											<input type="button" value="导出" data="1" class="btn btn-palegreen" id="export_order_message" onclick="export_order(1)">
										</div>
									</div>
								</form>
	
								<div id="list"></div>
							</div>
						</div>
					</div>
					<!-- 已留位 -->
			<!-- 		<div class="tab-pane" id="home1">
				<div class="widget-body">
					<div id="registration-form">
						<form	class="form-horizontal bv-form" id="searchForm1" novalidate="novalidate">
							<div class="form-group has-feedback">
								<label class="col-lg-4 control-label">产品名称：</label>
								<div class="col-lg-4" style="width: 120px;">
									<input type="text" name="linename"
										class="form-control user_name_b1">
								</div>
								<label class="col-lg-4 control-label" >订单编号：</label>
								<div class="col-lg-4" style="width: 120px;">
									<input type="text" name="linecode"
										class="form-control user_name_b1">
								</div>
								<label class="col-lg-4 control-label" >出团日期：</label>
								<div class="col-lg-4" style="width: 220px;">
									<div class="input-group">
									<span class="input-group-addon"> <i class="fa fa-calendar"></i></span>
									 <input type="text" style="width:160px !important;" class="form-control"
											id="reservation2" name="line_time">
									</div> 
								</div>
								<div class="fg_div" ><label class="col-lg-4 control-label" >团队编号：</label>
								<div class="col-lg-4" style="width: 120px;">
									<input type="text" name="linesn"
										class="form-control user_name_b1">
								</div></div>
								<div class="fg_div" ><label class="col-lg-4 control-label" >管家：</label>
								<div class="col-lg-4" style="width: 120px;">
									<input type="text" class="form-control" style="width:140px;" id="expert_name2"  name="expert_name">
								
								</div></div>
								<div class="fg_div" ><label class="col-lg-4 control-label" >目的地：</label>
								<div class="col-lg-4" style="width: auto;">
									<span id="search-dest2"></span>
								</div></div>
								<div class="fg_div" style="margin-left: 5px;"><label class="col-lg-4 control-label" >出发地：</label>
								<div class="col-lg-4" style="width: auto;">
									<span id='search-city2'></span>
								</div></div>
			
							   <label class="col-lg-4 control-label" style="width: 100px;padding-right:0px;">支付状态:</label>
								<div class="col-lg-4" style="width: auto;">
									<select name="pay_status" >
										 <option value="">请选择</option>
										 <option value="0" <?php //if(!empty($type)){ if($type==-1){ echo 'selected';}} ?>> 未付款</option>
										 <option value="1"  <?php //if(!empty($type)){ if($type==1){ echo 'selected';}} ?>> 确认中</option>	 
										 <option value="2" <?php //if(!empty($type)){ if($type==2){ echo 'selected';}} ?>> 已收款</option>				
									</select>
								</div>										
								<div class="fg_div" style="margin-left:50px;">
									<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn1">
								</div>
								<div class="fg_div" style="margin-left:50px;">
									<input type="button" value="导出" data="1" class="btn btn-palegreen" id="export_order_message1" onclick="export_order(2)">
								</div>
							</div>
						</form>
						<div id="list1"></div>
					</div>
				</div>
			</div> -->
					<!-- 已确认 -->
					<div class="tab-pane" id="home2">
						<div class="widget-body">
							<div id="registration-form">
								<form class="form-horizontal bv-form" method="post" id="searchForm2" novalidate="novalidate">
									<div class="form-group has-feedback">
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" >
										<label class="col-lg-4 control-label">线路名称：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div>
										</div>
                                      							<div class="fg_div" >
										<label class="col-lg-4 control-label" >出团日期：</label>
										<div class="col-lg-4" style="width: 220px;">
											<div class="input-group">
												<input type="text" id="starttime" name="starttime"
												class="form-control user_name_b1">
												<input type="text" id="endtime" name="endtime"
												class="form-control user_name_b1">
												<!-- <span class="input-group-addon"> <i class="fa fa-calendar"></i></span>
												 <input type="text" style="width:160px !important;" class="form-control"
													id="reservation4" name="line_time"> -->
											</div> 
										</div></div>
                                        
										<div class="fg_div" >
										<label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="ordersn"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >管家：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" class="form-control" style="width:140px;" id="expert_name3"  name="expert_name">
										
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >团队编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linesn"
												class="form-control user_name_b1">
										</div></div>
										<!-- <div class="fg_div" ><label class="col-lg-4 control-label" >目的地：</label>
										<div class="col-lg-4" style="width: auto;">
											<span id="search-dest3"></span>
										</div></div>-->
										<div class="fg_div" ><label class="col-lg-4 control-label" >出发地：</label>
										<div class="col-lg-4" style="width:120px;">
											<span id='search-city3'></span>
										</div></div>
										
										<div style="float:left;margin-top:2px;"><label class="col-lg-4 control-label" style="width: 60px !important;" >目的地：</label>
										<div class="col-lg-4" style="width: 280px;">
											  <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										      <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>
										</div>
										
										<div class="fg_div">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn2">
										</div>
										<div class="fg_div" style="margin-left:50px;">
											<input type="button" value="导出" data="2" class="btn btn-palegreen" id="export_order_message2"  onclick="export_order(3)">
										</div>
									</div>
								</form>
								<div id="list2"></div>
							</div>
						</div>
					</div>
				   	 <!-- 出团中 -->
					<div class="tab-pane" id="profile5">
						<div class="widget-body">
							<div id="registration-form">
								<form class="form-horizontal bv-form" method="post" id="searchForm4" novalidate="novalidate">
									<div class="form-group has-feedback">
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
                                       							<div class="fg_div" >
										<label class="col-lg-4 control-label">线路名称：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
                                        							<div class="fg_div" >
										<label class="col-lg-4 control-label" >出团日期：</label>
										<div class="col-lg-4" style="width: 220px;">
											<div class="input-group">
												<input type="text" id="starttime" name="starttime"
												class="form-control user_name_b1">
												<input type="text" id="endtime" name="endtime"
												class="form-control user_name_b1">
												<!-- <span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text" style="width:160px !important;" class="form-control"
													id="reservation3" name="line_time"> -->
											</div> 
										</div></div>
                                        
										<div class="fg_div" >
										<label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="ordersn"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >管家：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" class="form-control" style="width:140px;" id="expert_name4"  name="expert_name">
										
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >团队编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linesn"
												class="form-control user_name_b1">
										</div></div>
									<!-- <div class="fg_div" ><label class="col-lg-4 control-label" >目的地：</label>
										<div class="col-lg-4" style="width: auto;">
											<span id="search-dest4"></span>
										</div></div>-->
										<div class="fg_div" ><label class="col-lg-4 control-label" >出发地：</label>
										<div class="col-lg-4" style="width: 120px;">
											<span id='search-city4'></span>
										</div></div>
										
										<div style="float:left;margin-top:2px;"><label class="col-lg-4 control-label" style="width: 60px !important;" >目的地：</label>
										<div class="col-lg-4" style="width: 280px;">
											  <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										      <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>
										</div>

										<div class="fg_div">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn4">
										</div>
										<div class="fg_div" style="margin-left:50px;">
											<input type="button" value="导出" data="4" class="btn btn-palegreen" id="export_order_message4" onclick="export_order(4)">
										</div>
									</div>
								</form>
							<div id="list4"></div>
							</div>
						</div>
					</div>
					<!--行程结束-->
					<div class="tab-pane" id="profile6">
						<div class="widget-body">
							<div id="registration-form">
								<form class="form-horizontal bv-form" method="post" id="searchForm5" novalidate="novalidate">
									<div class="form-group has-feedback">
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
                                        							<div class="fg_div" >
										<label class="col-lg-4 control-label">线路名称：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
                                        <div class="fg_div" >
										<label class="col-lg-4 control-label" >出团日期：</label>
										<div class="col-lg-4" style="width: 220px;">
											<div class="input-group">
												<input type="text" id="starttime" name="starttime"
												class="form-control user_name_b1">
												<input type="text" id="endtime" name="endtime"
												class="form-control user_name_b1">
												<!-- <span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text" style="width:160px !important;" class="form-control"
													id="reservation5" name="line_time"> -->
											</div> 
										</div></div>
                                        
										<div class="fg_div" >
										<label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="ordersn"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >管家：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" class="form-control" style="width:140px;" id="expert_name5"  name="expert_name">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >团队编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linesn"
												class="form-control user_name_b1">
										</div></div>
										<!-- <div class="fg_div" ><label class="col-lg-4 control-label" >目的地：</label>
										<div class="col-lg-4" style="width: auto;">
											<span id="search-dest5"></span>
										</div></div>-->
										<div class="fg_div" ><label class="col-lg-4 control-label" >出发地：</label>
										<div class="col-lg-4" style="width:120px;">
											<span id='search-city5'></span>
										</div></div>
										
										<div style="float:left;margin-top:2px;"><label class="col-lg-4 control-label" style="width: 60px !important;" >目的地：</label>
										<div class="col-lg-4" style="width: 160px;">
											  <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										      <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>
										</div>
										
										<div class="fg_div"  style="margin-left:60px" >
										<label class="col-lg-4 control-label" style="width: 100px;padding-right:0px;">订单状态：</label>
										<div class="col-lg-4" style="width: auto;">
											<select name="order_status">
												 <option value="">请选择</option>
											
												 <option value="6"  <?php if(!empty($status)){ if($status==6){ echo 'selected';}} ?>> 已点评</option>	 
												 <option value="7" <?php if(!empty($status)){ if($status==7){ echo 'selected';}} ?>> 已投诉</option>				
											</select>
										</div></div>
										
									
										
										<div class="fg_div">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn5">
										</div>
										<div class="fg_div" style="margin-left:50px;">
											<input type="button" value="导出" data="4" class="btn btn-palegreen" id="export_order_message5" onclick="export_order(5)">
										</div>
									</div>
								</form>
							<div id="list5"></div>
							</div>
						</div>
					</div>
					<!-- 已取消 -->
					<div class="tab-pane" id="home3">
						<div class="widget-body">
							<div id="registration-form">
								<form  class="form-horizontal bv-form" method="post" id="searchForm3" novalidate="novalidate">
									<div class="form-group has-feedback">
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" >
										<label class="col-lg-4 control-label" >线路名称：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
                                        <div class="fg_div" >
										<label class="col-lg-4 control-label" >出团日期：</label>
										<div class="col-lg-4" style="width: 220px;">
											<div class="input-group">
												<input type="text" id="starttime" name="starttime"
												class="form-control user_name_b1">
												<input type="text" id="endtime" name="endtime"
												class="form-control user_name_b1">
												<!-- <span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text" style="width:160px !important;" class="form-control"
													id="reservation0" name="line_time"> -->
											</div> 
										</div></div>
                                        
										<div class="fg_div" >
										<label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="ordersn"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >管家：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" class="form-control" style="width:140px;" id="expert_name6"  name="expert_name">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >团队编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linesn"
												class="form-control user_name_b1">
										</div></div>
										<!-- <div class="fg_div" ><label class="col-lg-4 control-label" >目的地：</label>
										<div class="col-lg-4" style="width: auto;">
											<span id="search-dest6"></span>
										</div></div>-->
										<div class="fg_div" ><label class="col-lg-4 control-label" >出发地：</label>
										<div class="col-lg-4" style="width: 120px;">
											<span id='search-city6'></span>
										</div></div>
										
										<div style="float:left;margin-top:2px;"><label class="col-lg-4 control-label" style="width: 60px !important;" >目的地：</label>
										<div class="col-lg-4" style="width: 160px;">
											  <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										      <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>
										</div>
										
									   <div class="fg_div" style="margin-left:60px;">	
									   <label class="col-lg-4 control-label"  >支付状态：</label>
										<div class="col-lg-4" style="width: auto;">
											<select name="pay_status" >
												 <option value="">请选择</option>
												 <option value="0" <?php if(!empty($type)){ if($type==0){ echo 'selected';}} ?>> 未付款</option>
												 <option value="1"  <?php if(!empty($type)){ if($type==1){ echo 'selected';}} ?>> 确认中</option>	 
												 
												 <option value="3" <?php if(!empty($type)){ if($type==3){ echo 'selected';}} ?>> 退款中</option>	
												 <option value="4" <?php if(!empty($type)){ if($type==4){ echo 'selected';}} ?>> 已退款</option>					
											</select>
										</div></div>
										
									
										
										<div class="fg_div">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn3">
										</div>
										<div class="fg_div" style="margin-left:50px;">
											<input type="button" value="导出" data="3" class="btn btn-palegreen" id="export_order_message3" onclick="export_order(6)">
										</div>
									</div>
								</form>
					  			<div id="list3"></div>
							</div>
						</div>
					</div>
					<!--改价/退团-->
					<div class="tab-pane" id="profile14">
						<div class="widget-body">
							<div id="registration-form">
								<form class="form-horizontal bv-form" method="post" id="searchForm6" novalidate="novalidate">
									<div class="form-group has-feedback">
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
                                        <div class="fg_div" >
										<label class="col-lg-4 control-label" >线路名称：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
                                        <div class="fg_div" >
										<label class="col-lg-4 control-label" >出团日期：</label>
										<div class="col-lg-4" style="width: 220px;">
											<div class="input-group">
												<input type="text" id="starttime" name="starttime"
												class="form-control user_name_b1">
												<input type="text" id="endtime" name="endtime"
												class="form-control user_name_b1">
												<!-- <span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text" style="width:160px !important;" class="form-control"
													id="reservation6" name="line_time"> -->
											</div> 
										</div></div>
                                        
                                        <div class="fg_div" >
										<label class="col-lg-4 control-label" >订单编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="ordersn"
												class="form-control user_name_b1">
										</div></div>
                                        <div class="fg_div" ><label class="col-lg-4 control-label" >管家：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" class="form-control" style="width:140px;" id="expert_name7"  name="expert_name">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >团队编号：</label>
										<div class="col-lg-4" style="width: 120px;">
											<input type="text" name="linesn"
												class="form-control user_name_b1">
										</div></div>
									<!-- <div class="fg_div" ><label class="col-lg-4 control-label" >目的地：</label>
										<div class="col-lg-4" style="width: auto;">
											<span id="search-dest7"></span>
										</div></div> -->	
										<div class="fg_div" ><label class="col-lg-4 control-label" >出发地：</label>
										<div class="col-lg-4" style="width: 120px;">
											<span id='search-city7'></span>
										</div></div>
										
										<div style="float:left;margin-top:2px;"><label class="col-lg-4 control-label" style="width: 60px !important;" >目的地：</label>
										<div class="col-lg-4" style="width: 280px;">
											  <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										      <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>
										</div>
										
										<div class="fg_div">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn6">
										</div>
										<div class="fg_div" style="margin-left:50px;">
											<input type="button" value="导出" data="4" class="btn btn-palegreen" id="export_order_message6" onclick="export_order(7)" >
										</div>
									</div>
								</form>
							<div id="list6"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--额度申请-->
    <div class="fb-content" id="b_limit_apply" style="display:none;" >
    <div class="box-title">
        <h4>确认订单</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                   	<tr height="40">
                        <td class="apply_message" colspan="4"></td>
                    	</tr>
                    	<tr height="40">
	                	<td class="order_info_title" style="width:130px;">出发日期</td>
	                   	<td class="ap_usedate" >2016-09-10</td>
	                   	<td class="order_info_title" style="width:130px;">订单人数</td>
	                   	<td class="ap_order_num" >20 （10 + 5 + 5 + 0)</td>
                    	</tr>
                    	<tr height="40">
                        <td class="order_info_title" style="width:130px;">已交款:</td>
                        <td class="cash_limit" ></td>
                        <td class="order_info_title" style="width:130px;">扣款信用额度:</td>
                        <td class="credit_limit" ></td>
                    	</tr>
                    	<tr height="40">
                        <td class="order_info_title" style="width:130px;">申请金额:</td>
                        <td class="apply_amount"  ></td>
                         <td class="order_info_title" style="width:130px;">还款时间:</td>
                        <td class="order_return_time"   ></td>
                    	</tr>
                    	<tr height="40">
                         <td class="order_info_title" style="width:130px;">申请人:</td>
                         <td class="ap_expert"  ></td>
                         <td class="order_info_title" style="width:130px;">所属部门:</td>
                         <td class="ap_depart"   ></td>
                    	</tr>
                        <tr height="40">
                            <td class="order_info_title">审核意见:</td>
                            <td colspan="3"  >
                            <textarea  name="ap_reply" class="w_350" style="margin-top:5px;"></textarea>
                            </td>
                         </tr>

                </table>
            </div>
            <div class="choose_title"><label><input type="checkbox" name="is_agree" class="" style="left:0px;opacity:1" />
                   我阅读并同意授信额度条款<a style="margin-left:10px" href="##">查看条款</a></label>
            </div>
            <div class="form_btn clear" id="opare_btn" >
               	  <input type="hidden" value="" name="order_id"> 
                	<input type="button" name="" value="确认" class="btn btn_blue" id="refuse" style="margin-left:210px;"  onclick="apply_credit(this)" >
                	<input type="button" name="" value="取消" class="layui-layer-close btn btn_gray" id="" style="margin-left:80px;"  > 
                 	 <!-- <input type="button" name="" value="拒绝" class="btn btn_blue" id="refuse" style="margin-left:80px;"  onclick="refuse_credit(this)" >  -->
            </div>
        </form>
    </div>
</div>
<!--B端-确认订单-->
    <!--信用额度审核-->
<!--     <div class="fb-content" id="limit_approve" style="display:none;">
<div class="box-title">
    <h4>确认订单</h4>
    <span class="layui-layer-setwin">
        <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
    </span>
</div>
<div class="fb-form">
    <form method="post" action="#" id="addlimit-data" class="form-horizontal">
        <div class="form_con limit_apply">
          <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                <tr height="40">
                  <td class="order_info_title"></td>
                    <td colspan="4" class="apply_sn" >该订单未收全款，是否确认</td>
                </tr>
                  <tr height="40">
                    <td class="order_info_title"><i class="important_title">*</i>还款日期:</td>
                    <td class="apply_real_amount"  colspan="3"  ><input type="text" name="return_time"  id="return_time"  class="w_300"/></td>
                </tr>
            </table>
        </div>
        <div class="form_btn clear" id="opare_btn" >
            <input type="hidden" value="" name="order_id">
            <input type="button" name="" value="确认" class="btn btn_blue" id="refuse" style="margin-left:210px;"  onclick="submit_credit(this)" >
            <input type="button" name="button" value="取消" class="layui-layer-close btn btn_gray" style="margin-left:80px;">
        </div>
    </form>
</div>
</div> -->
<!--拒绝订单理由-->
  <div class="fb-content" id="refuse_limit" style="display:none;">
    <div class="box-title">
        <h4>拒绝订单</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="addlimit-data" class="form-horizontal">
            <div class="form_con limit_apply">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
               	<tr height="40">
	                	<td class="order_info_title" style="width:130px;">出发日期</td>
	                   	<td class="re_usedate" >2016-09-10</td>
	                   	<td class="order_info_title" style="width:130px;">订单人数</td>
	                   	<td class="re_order_num" >20 （10 + 5 + 5 + 0)</td>
                    	</tr>
                    	<tr height="40">
                        <td class="order_info_title" style="width:130px;">已交款:</td>
                        <td class="re_cash_limit" ></td>
                        <td class="order_info_title" style="width:130px;">扣款信用额度:</td>
                        <td class="re_credit_limit" ></td>
                    	</tr>
                    	<tr height="40">
                        <td class="order_info_title" style="width:130px;">申请金额:</td>
                        <td class="re_apply_amount"  ></td>
                         <td class="order_info_title" style="width:130px;">还款时间:</td>
                        <td class="re_return_time"   ></td>
                    	</tr>
                    	<tr height="40">
                         <td class="order_info_title" style="width:130px;">申请人:</td>
                         <td class="re_expert"  ></td>
                         <td class="order_info_title" style="width:130px;">所属部门:</td>
                         <td class="re_depart"   ></td>
                    	</tr>
                     <tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>拒绝理由:</td>
                        <td class="apply_real_amount"  colspan="3"  ><textarea  name="s_reply" class="w_350" style="margin-top:5px;"></textarea></td>
                     </tr>

                </table>
            </div>
            <div class="form_btn clear" id="opare_btn" >
                <input type="hidden" value="" name="s_order_id">
                <input type="button" name="" value="确认" class="btn btn_blue" id="refuse" style="margin-left:210px;"  onclick="refuse_order(this)" >
                <input type="button" name="button" value="取消" class="layui-layer-close btn btn_gray" style="margin-left:80px;">
            </div>
        </form>
    </div>
</div>

<?php echo $this->load->view('admin/b1/common/order_script'); ?>
<?php echo $this->load->view('admin/b1/common/time_script'); ?>

<link href="/assets/ht/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>

<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script> 
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<script type="text/javascript">
//-------------------------------------------订单链接加载-------------------------------------------------------
function checkorder(){
	var type='<?php if(!empty($type)){ echo $type;} ?>';
	var cancel='<?php if(!empty($cancel)){ echo $cancel;} ?>';
	var status='<?php if(!empty($status)){ echo $status;} ?>';
	var kind='<?php if(!empty($kind)){ echo $kind;} ?>';
	if(kind=='-1'){
		 $('#tab6').click();
    }	
	if(type !=''){
		if(type==2){ //待确认订单
			$('#tab0').click();
		}else if(type==3){ //退款中
			$('#tab3').click();
		}else if(type==4){ //已退款
			$('#tab3').click();
		}else if(type==-1){
			$('#tab1').click();
		}else if(type=='01'){
			$('#tab2').click();
		}
	 }
	 if(cancel !=''){   //取消
		 if(cancel==1){ 
			 $('#tab3').click();
		 }
	}
	 if(status !=''){   //取消 
		 $('#tab5').click();
	}
	
	
}
jQuery(document).ready(function(){	
	checkorder();　 
}); 

 //管家名字
 get_sch_expert("#expert_name");
 function get_sch_expert(expertID){
	//  var expertID="#expert_name";
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
		    id : expertID,
		    name : "expert_id",// 隐藏的value ID字段
		    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
		    selectedAfter : function(item, index) {// 选择后的事件

		    },
		    data : array
		});
	})	
 }
//目的地
 get_sch_dest("#search-dest");
function get_sch_dest(dest){
	$.ajax({
	url:'/common/selectData/getDestAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$(dest).selectLinkage({
			jsonData:data,
			width:'110px',
			names:['dest_country','dest_province','dest_city']
		});
	}
});
} 
//出发地
 get_sch_startplace("#search-city");
function get_sch_startplace(cityid){
	$.ajax({
		url:'/common/selectData/getStartplaceJson',
		dataType:'json',
		type:'post',
		success:function(data){
			$(cityid).selectLinkage({
				jsonData:data,
				width:'100px',
				names:['country','province','city']
			});
		}
	});
}


$('#return_time').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});
//----------------------------------------------待确认订单操作---------------------------------------------------
//b端的确认订单 弹框
jQuery('#list').on("click", 'a[name="b_order"]',function(){
	var data=jQuery(this).attr('data');
	$('input[name="order_id"]').val(data);
	$('input[name="return_time"]').val('');
	$('textarea[name="ap_reply"]').val('');
	layer.open({
	      type: 1,
	      title: false,
	      closeBtn: 0,
	      area: '600px',
	      //skin: 'layui-layer-nobg', //没有背景色
	      shadeClose: false,
	      content: $('#b_limit_apply')
	});
	$.post("<?php echo base_url()?>admin/b1/order/get_order_debit", { orderid:data} , function(result) {
		var result =eval("("+result+")"); 
 		if(result.status==-1){
 			alert(result.msg);
 		}else{
 			var m_str='您确定向 '+result.order.depart_name+' '+result.order.realname+'  授权信用额度：'+result.apply_limit+'元?';
 			var people='('+result.order.dingnum+' + '+result.order.childnum+' + '+result.order.childnobednum+' + '+result.order.oldnum+')';
			$('#apply-data').find('.ap_usedate').html(result.order.usedate);
			$('#apply-data').find('.ap_order_num').html(result.order.all_num+people);
			$('#apply-data').find('.cash_limit').html(''+result.cash_limit);
			$('#apply-data').find('.credit_limit').html(''+result.credit_limit);
			$('#apply-data').find('.apply_amount').html(''+result.apply_limit);
			$('#apply-data').find('.order_return_time').html(result.return_time);
			$('#apply-data').find('.ap_expert').html(result.order.realname);
			$('#apply-data').find('.ap_depart').html(result.order.depart_name);
			$('#apply-data').find('.apply_message').html(m_str);
			
 		}
	})
}); 


//确认订单弹框
function apply_credit(obj){
	var orderid=$('input[name="order_id"]').val();
	var return_time=$('input[name="return_time"]').val();
	var ap_reply=$('textarea[name="ap_reply"]').val();
    var is_agree=$('input[name="is_agree"]').is(':checked');
    if(!is_agree){
         alert('请同意条款');
         return false;
    }

    jQuery.ajax({ type : "POST",async:false,data : { 'orderid':orderid,'return_time':return_time,'ap_reply':ap_reply},url : "<?php echo base_url()?>admin/b1/order/add_order_debit", 
        beforeSend:function() {//ajax请求开始时的操作
             layer.load(1);//加载层
        },
        complete:function(){//ajax请求结束时操作              
             layer.closeAll('loading'); //关闭层
        },
        success : function(result) { 
        	result = eval('('+result+')');
	       	 if(result.status==1){               
	 	       	 layer.msg(result.msg, {icon: 1});  	
				 $('#tab2').click();
				 $('input[name="return_time"]').val('');
				 $('.layui-layer-close').click();					
	         }else{
	             alert(result.msg);
	         } 
        }
    });
    
	/*$.post("<?php echo base_url()?>admin/b1/order/add_order_debit", { orderid:orderid,return_time:return_time,ap_reply:ap_reply} , function(result) {
           	var result =eval("("+result+")"); 
			if(result.status==1){		
			alert(result.msg);
			$('#tab2').click();
			$('input[name="return_time"]').val('');
			$('.layui-layer-close').click();
		}else{
			alert(result.msg);		
		}  
	});*/
}

//拒绝订单的
jQuery('#list').on("click", 'a[name="dis_order"]',function(){
	var data=jQuery(this).attr('data');
	$('input[name="s_order_id"]').val(data);
	$('.layui-layer-close').click();
	layer.open({
	      type: 1,
	      title: false,
	      closeBtn: 0,
	      area: '600px',
	      shadeClose: false,
	      content: $('#refuse_limit')
	});
	$('textarea[name="s_reply"]').val('');

	$.post("<?php echo base_url()?>admin/b1/order/get_order_debit", { orderid:data} , function(result) {
		var result =eval("("+result+")"); 
 		if(result.status==-1){
 			alert(result.msg);
 		}else{
 			var people='('+result.order.dingnum+' + '+result.order.childnum+' + '+result.order.childnobednum+' + '+result.order.oldnum+')';
			$('#refuse_limit').find('.re_usedate').html(result.order.usedate);
			$('#refuse_limit').find('.re_order_num').html(result.order.all_num+people);
			$('#refuse_limit').find('.re_cash_limit').html(''+result.cash_limit);
			$('#refuse_limit').find('.re_credit_limit').html(''+result.credit_limit);
			$('#refuse_limit').find('.re_apply_amount').html(''+result.apply_limit);
			$('#refuse_limit').find('.re_return_time').html(result.return_time);
			$('#refuse_limit').find('.re_expert').html(result.order.realname);
			$('#refuse_limit').find('.re_depart').html(result.order.depart_name);
 		}
	})


});	
function refuse_order(){
	 var orderid=$('input[name="s_order_id"]').val();
	var s_reply=$('textarea[name="s_reply"]').val();


    jQuery.ajax({ type : "POST",async:false,data : { 'orderid':orderid,'s_reply':s_reply},url : "<?php echo base_url()?>admin/b1/order/refuse_order_debit", 
        beforeSend:function() {//ajax请求开始时的操作
             layer.load(1);//加载层
        },
        complete:function(){//ajax请求结束时操作              
             layer.closeAll('loading'); //关闭层
        },
        success : function(result) { 
        	result = eval('('+result+')');
	       	 if(result.status==1){               
	 	       	 layer.msg(result.msg, {icon: 1});  	
		 	     $('#tab0').click();	
			     $('.layui-layer-close').click();					
	         }else{
	        	 alert(result.msg);	
	         } 
        }
    });

    
	/*$.post("<?php echo base_url()?>admin/b1/order/refuse_order_debit", { orderid:orderid,s_reply:s_reply} , function(result) {
		var result =eval("("+result+")"); 
		if(result.status==1){
			alert(result.msg);	
			$('.layui-layer-close').click();
			$('#tab0').click();	
		}else{
			alert(result.msg);		
		}  
	});*/
}

$("#searchForm,#searchForm0,#searchForm2,#searchForm4,#searchForm5,#searchForm3,#searchForm6").find('#starttime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});
$("#searchForm,#searchForm0,#searchForm2,#searchForm4,#searchForm5,#searchForm3,#searchForm6").find('#endtime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});

//目的地
var oleft = 0 ; 
var oTop = 0;
function b1_showCGZDestTree(obj,cityid){
	oleft = 0 ; 
	oTop = -40 ;
	treeInputObj = obj;
	var url = '/common/get_data/getTripDestBaseArr';
	var zNodes = commonTree(obj ,url ,cityid);
	
	$(obj).unbind('keyup');
	$(obj).keyup(function(event) {
		searchKeyword(obj ,zNodes ,event);
	})
}
</script>

<?php  echo $this->load->view('admin/common/tree_view'); ?>	
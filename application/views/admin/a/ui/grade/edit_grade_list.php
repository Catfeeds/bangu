<link rel="icon" href="/bangu.ico" type="image/x-icon"/> 
<link href="/static/css/common.css" rel="stylesheet" />
<link href="/assets/css/styles.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>"rel="stylesheet" />
<link href="<?php echo base_url('static'); ?>/css/plugins/diyUpload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/js/jquery-1.7.2.min.js"></script>
<style>
.title_info_txt1,.title_info_txt2,.tset_1,.tset_2{ display:none;}
#rt_rt_1a5vrdt1p1dok105afeo1hhl1n1{ width:80px !important; height:30px !important;}
#as2 div:last-child{width:90px !important; height:24px !important; margin-top:10px !important; margin-left:5px !important;}
.webuploader-pick{ width:102px; margin-left:0px; z-index:1000;}
.parentFileBox{ top:45px; height:80px; left:5px;}
.parentFileBox>.fileBoxUl{ top:0px;}
.parentFileBox>.diyButton>a{ padding:3px 6px 3px 6px} 
.parentFileBox>.diyButton{ position:absolute; top:0px;}
.diyStart{ top:0}
.diyCancelAll{ top:35px;}
.expertcss{margin-top:7px;}
</style>

<div class="ht_main">
    <div class="ht_title">评分修改</div>
    <div class="score_list">
        <div class="list_tilr">管家信息</div> 
        <div class="php_gj_img"><img src="<?php if(!empty($expert['small_photo'])){echo $expert['small_photo'];} ?>" /></div>
        <div class="php_gj_name"><div class="hou_til">管家名称:</div><div class="hou_con"><?php if(!empty($expert['realname'])){echo $expert['realname'];} ?></div></div>
        <div class="php_gj_name"><div class="hou_til">管家昵称:</div><div class="hou_con"><?php if(!empty($expert['nickname'])){echo $expert['nickname'];} ?></div></div>
        <div class="php_gj_name"><div class="hou_til">管家级别:</div><div class="hou_con" id="expertGrade_div"><?php if (array_key_exists($expert['grade'] ,$expertGrade)) {echo $expertGrade[$expert['grade']];} else {echo '管家';} ?></div></div>
        <div class="block">
            <div class="php_gj_name"><div class="hou_til">手机:</div><div class="hou_con"><?php if(!empty($expert['mobile'])){echo $expert['mobile'];} ?></div></div>
            <div class="php_gj_name"><div class="hou_til">邮箱:</div><div class="hou_con"><?php if(!empty($expert['email'])){echo $expert['email'];} ?></div></div>
            <div class="php_gj_name"><div class="hou_til">所在地:</div><div class="hou_con"><?php if(!empty($expert['pd_name'])){echo $expert['pd_name'].$expert['cid_name'];} ?></div></div>
        </div>
        <div class="list_tilr"><input type="button" value="修改" class="ab_xiugai" onclick="update_grade(<?php if(!empty($expert['id'])){echo $expert['id'];}else{echo 0;} ?>)" /></div>
    </div>
    <div class="score_list">
       <div class="list_tilr">管家指标<input type="button" value="修改" class="ab_xiugai" onclick="ab_xiugai(<?php if(!empty($expert['id'])){echo $expert['id'];}else{echo 0;} ?>)" /></div>
       <ul class="zhibiao">
          <li><div class="zb_tli">年满意度:</div><span class="satisfaction_span"><?php if(!empty($expert['satisfaction_rate'])){echo ($expert['satisfaction_rate']+$affil['sati_intervene'])*100;}else{ echo 0;} ?><i>%</i></span></li>
          <li><div class="zb_tli">年销人数:</div><span class="count_span"><?php if(!empty($expert['people_count'])){echo $expert['people_count'];}else{ echo 0;} ?><i>人</i></span></li>
          <li><div class="zb_tli">年成交额:</div><span class="amount_span"><?php if(!empty($expert['order_amount'])){echo $expert['order_amount'];}else{ echo 0;} ?><i>元</i></span></li>
          <li><div class="zb_tli">年总积分:</div><span class="score_span"><?php if(!empty($expert['total_score'])){echo $expert['total_score'];}else{ echo 0;} ?><i>分</i></span></li>
       </ul>
    </div>
     <div class="score_list">
       <div class="list_tilr">管家售卖列表</div>

		<form class="form-horizontal bv-form" method="post" id="listForm0">
			<div class="form-group has-feedback">
				<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">线路编号：</label>
				<input  type="hidden" value="<?php if(!empty($expert['id'])){echo $expert['id'];} ?>" name="expert_id" /> 
				<div class="col-lg-4" style="width:auto;padding-left:2px;">
			       <input class="form-control user_name_b1" type="text" name="linecode" placeholder="线路编号" />
				</div>	
			    <label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">产品标题：</label>
				<div class="col-lg-4" style="width:auto;padding-left:2px;">
			       <input class="form-control user_name_b1" type="text" name="linename" placeholder="产品标题-模糊搜索" />
				</div>
				 <label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">目的地：</label>
				<div class="col-lg-4" style="width:auto;padding-left:2px;">
			      <!--  <input class="form-control user_name_b1" type="text" name="overcity" placeholder="目的地" /> -->
			      <select name="overcity">
			          <option  value="">全部目的地</option>
			          <option selected="selected" value="<?php if(!empty($expert['expert_dest'])){echo $expert['expert_dest'];}?>">擅长目的地</option>
			      </select>
				</div>
				<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
				<div class="col-lg-4" style="width: 5%;padding-left:2px;">
					<input type="button" style="width: 54px;height: 30px;" value="搜索" class="btn btn-palegreen" id="btnSearch0" />
				</div>
			</div>
		</form>
		  <form  class="form-horizontal bv-form" method="post" id="expertDataFrom" >
	       <!-- list头部 -->
	       <div id="list">
	          <!-- 管家售卖线路数据 -->
		   </div>
		    <div class="list_tilr">
		    <input type="hidden" name="expertid" value="<?php if(!empty($expert['id'])){echo $expert['id'];}?>">
		    <input type="button" value="取消" class="ab_xiugai"  onclick="cancel_expertData()"/>
		    <input type="button" value="提交" class="ab_xiugai" onclick="submit_expertData()" />
		    </div>
		 </form>
    </div>
</div>


<div class="modal-backdrop fade in bc_close" style="display: none"></div>
<!-- 管家指标的弹层 -->
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in edit_expert_target" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button bc_close close" onclick="close();">×</button>
					<h4 class="modal-title">修改管家指标</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body">
							<form class="form-horizontal" role="form" id="expert_target_form" method="post" action="#">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">年满意度</label>
									<div class="col-sm-10">
										<input class="form-control " disabled="disabled"  style="float:left;width:15%" name="satisfaction_rate" type="text" />
										<span style="float:left;">+</span>
										<input class="form-control " style="float:left;width:20%" name="sati_intervene" type="text" onblur="s_change(this)"/>
										=<span style="line-height:30px" class="satisfaction_all">0%</span>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-2 control-label no-padding-right">年销人数</label>
									<div class="col-sm-10">
										<input class="form-control" style="float:left;width:80%" name="people_count" type="text" />
										<span style="line-height:30px">人</span>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-2 control-label no-padding-right">年成交额</label>
									<div class="col-sm-10">
										<input class="form-control" style="float:left;width:80%" name="order_amount" maxlength="20" type="text" />
										<span style="line-height:30px">元</span>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-2 control-label no-padding-right">年总积分</label>
									<div class="col-sm-10">
										<input class="form-control " style="float:left;width:80%" name="total_score" type="text" />
										<span style="line-height:30px">分</span>
									</div>
								</div>
								<div class="form-group">
									<input class="form-control " style="float:left;width:80%" name="expert_id" type="hidden" />
								    <input class="btn btn-palegreen bootbox-close-button" onclick="close();" value="取消" style="float: right; margin-right: 2%;" type="button"/> 
									<input class="btn btn-palegreen"  value="确认提交"   onclick="submit_expert_target();" style="float: right; margin-right: 2%;" type="button"/>
								</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- 管家指标的弹层end-->
<!-- 管家调整级别的弹层-->
<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in edit_expert_grade" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close" onclick="close();">×</button>
				<h4 class="modal-title">修改管家级别</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
						<form class="form-horizontal" role="form" id="expert_grade_form" method="post" action="#">
						<input  name="up_expert_id" type="hidden" value="<?php if(!empty($expert['id'])){echo $expert['id'];} ?>" />
							<div class="form-group">
							    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">管家姓名：</label>
								<div class="col-sm-10 expertcss">
	                       		 	<span class="expert_realname" >李思敏</span>   
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">管家昵称：</label>
								<div class="col-sm-10 expertcss">
									<span class="expert_nickname" >李思敏</span>   
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">手机：</label>
								<div class="col-sm-10 expertcss">
									<span class="expert_mobile" >李思敏</span> 
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">邮箱：</label>
								<div class="col-sm-10 expertcss">
									<span class="expert_email" >李思敏</span>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">所在地：</label>
								<div class="col-sm-10 expertcss">
									<span class="expert_city" >李思敏</span>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">管家级别：</label>
								<div class="col-sm-10">
									<select name="expert_gradeDate" id="expert_gradeDate">
									    <?php if(!empty($expertGradelist)){
											foreach ($expertGradelist as $k=>$v){
											  echo "<option value=".$v['grade'].">".$v['title']."</option>";
											}
										} ?>
									</select>
								</div>
							</div>
							<div class="form-group">
							    <input class="form-control " style="float:left;width:80%" name="line_id" type="hidden" />
							    <input class="btn btn-palegreen bootbox-close-button" onclick="close();" value="取消" style="float: right; margin-right: 2%;height:30px;" type="button"/> 
								<input class="btn btn-palegreen "  onclick="submit_expert_grade();"   value="确认提交" style="float:right; margin-right:2%;height:30px;" type="button"/>
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 管家调整级别的弹层-->
<!-- 管家售卖列表的弹层-->
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in edit_expert_line" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button bc_close close" onclick="close();">×</button>
					<h4 class="modal-title">修改管家售卖线路</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body">
							<form class="form-horizontal" role="form" id="expert_line_form" method="post" action="#">
							<input  name="up_expert_id" type="hidden" value="<?php if(!empty($expert['id'])){echo $expert['id'];} ?>" />
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">已销</label>
									<div class="col-sm-10">
										<input class="form-control positive_int" style="float:left;width:95%;" name="bookcount" type="text" />
									</div>
								</div>
								<div class="form-group">
								    <input class="form-control " style="float:left;width:80%" name="line_id" id="up_line_id" type="hidden" />
								    <input class="btn btn-palegreen bootbox-close-button" onclick="close();" value="取消" style="float: right; margin-right: 2%;height:30px;" type="button"/> 
									<input class="btn btn-palegreen "  onclick="submit_expert_line();"   value="确认提交" style="float:right; margin-right:2%;height:30px;" type="button"/>
								</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- 管家售卖列表的弹层-->
<!-- 点评出层内容 -->
<div id="evaluateButton" style="display: none; width: 720px;">
		<!-- 此处放编辑内容 -->
		<div class="eject_big">
			<div class="eject_back clear" style="height: auto;">
				<form class="form-horizontal" role="form" method="post"
					id="evaluateForm" onsubmit="return Checkevaluate();"
					action="<?php echo base_url();?>base/member/add_comment">     
					<div class="eject_title fl">
						<p class="comment_line">评价线路:</p>
						<input type="hidden" name="c_line_id" id="c_line_id" /> 
					</div>
                    <div class="olumn">评价产品</div>
					<div class="eject_content fl">
						<div class="eject_content_right fl">
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>导游服务:</span>
									<ul class="score0">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>行程安排:</span>
									<ul class="score1">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>餐饮住宿:</span>
									<ul class="score2">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>旅游交通:</span>
									<ul class="score3">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="title_info_txt title_info_txt1">
								<span>产品满意度:&nbsp;<i style=" color:#f00;">50</i>&nbsp;%</span>
							</div>
                            <div class="title_info_txt title_info_txt2">
								<span>产品平均分:&nbsp;<i style=" color:#f00;">2.5</i>&nbsp;分</span>
							</div>
						</div>
					</div>
					<div class="eject-content_left fl">
						<div class="eject_content_left_s">
							<div class="eject_input_Slide">
								<textarea name="content" class="content" id="content" maxlength="200" placeholder="发表评论获得更多积分.."></textarea>
								<span class="font_num_title"><span>200</span><i>/200</i>
								</span>
							</div>
						</div>
					</div>

					<div class="eject_content2 fl">
						<div class="olumn">评价管家</div>
						<div class="eject_content_left-x clear">

							<div class="eject_right_one fl"
								style="margin-bottom: 10px; width: 200px; margin-left: 20px;">
								<div class="eject_xx_box">
									<span style="color: #666;">专业度:</span> 
									<input type="hidden" name="major" value="0" class="zyd" />
									<ul class="score4">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
								</div>
							</div>
							<div class="eject_right_one fl"
								style="margin-bottom: 10px; width: 200px; margin-left: 20px;">
								<div class="eject_xx_box">
									<span style="color: #666;">服务态度:</span> 
									<input type="hidden" name="serve" value="0" class="fwtd" />
									<ul class="score5">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
								</div>
							</div>
							<div class="expert_grade tset_1 fl">
								管家满意度:&nbsp;<span>0</span>&nbsp;%
							</div>
                            <div class="expert_grade tset_2 fl">
								管家平均分:&nbsp;<span>0</span>&nbsp;分
							</div>
                            <div class="eject_input_Evaluation fl">
								<textarea name="expert_comment" class="expert_comment" maxlength="200" placeholder="发表评论获得更多积分.."></textarea>
								<span class="font_num_title abs_tex"><span>200</span><i>/200</i>
								</span>
							</div>
                      		<div class="show_img fl">
								<p>以图为证</p>
								<div id="demo">
									<div id="as2" class="webuploader-container"></div>
									<!--<div class="title_info_txt title_info_txt3">
									<p>(注:上传图片送500积分)</p>
									</div> -->
								</div>
							</div>     
							<div class="grades"></div>
							<div class="pic_comment"></div>
							<div class="eject_button fl" style="padding-bottom: 2px;"> 
							 
							 <input type="hidden" name="c_expert_id" id="c_expert_id" value="<?php if(!empty($expert['id'])){echo $expert['id'];} ?>" /> 
							 <input type="submit" name="submit" value="提交评价" class="commit" style="color:black;" />
							</div>
						</div>
					</div>	 		
			</div>
			</form>
		</div>
	</div>

<!-- end -->	
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>

<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>

<script src="<?php echo base_url('static'); ?>/js/eject_sc.js" type="text/javascript"></script>
<script src="<?php echo base_url('static'); ?>/js/diyUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>

<script type="text/javascript">
//-------------------------------------------------------管家售卖列表----------------------------------------------------
jQuery(document).ready(function(){
	var expert_id=<?php if(!empty($expert['id'])){echo $expert['id'];}else{ echo 0;}  ?>;
	var page0=null;
	jQuery("#btnSearch0").click(function(){	
		page0.load({"expert_id":"<?php if(!empty($expert['id'])){echo $expert['id'];} ?>"});
	});
	var data = '<?php echo $pageData; ?>';
	var str='<select name="grade"><option value="">请选择</option><option value="1">管家</option><option value="2">初级专家</option>';
	str=str+'<option value="3">中级专家</option><option value="4">高级专家</option>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/grade/line_apply",form : '#listForm0',// 绑定一个查询表单的ID

				columns : [
							{title : '<div style="position:relative;"><input type="checkbox" id="checkAll" style="left:5px;opacity:1;margin-top:-14px;" /></div>',width : '2%',align : 'center',
								formatter : function(value,rowData, rowIndex) {
									return '<input type="checkbox" name="expert_grade[]" value="'+rowData.id+'-'+rowData.lineid+'" style="left:5px;opacity: 1;" />';
								}
							},

							{title : '编号',width : '8%',align : 'center',
								formatter : function(value,rowData, rowIndex) {
									return rowIndex+1;
								}
							},
							{field : 'linecode',title : '线路编号',align : 'center', width : '10%'},
							{field : 'linename',title : '产品标题',align : 'center', width : '32%',
								formatter : function(value,rowData, rowIndex) {
									return '<a href="<?php echo base_url()?>cj/'+rowData.lineid+'" style="color: #428bca;" target="_blank" >'+value+'</a>';
								}
								
							},
							{field : 'realname',title : '供应商',align : 'center', width : '10%'},
							{field : 'grade',
			
								title : '<div style="position:relative;float:right">管家级别'+str+' </div>',
								align : 'center',
								width : '18%',
								formatter : function(value,rowData, rowIndex) {
									if(rowData.grade==1){
										return '管家';
									}else if(rowData.grade==2){
										return '初级专家';
									}else if(rowData.grade==3){
										return '中级专家';
									}else if(rowData.grade==4){
										return '高级专家';
									}else{
										return '管家';
									}
								}
							},
							{field : 'peoplecount',
								title : '<div style="position:relative;float:right">已销 <input type="text"  name="expert_bookcount" style="width:45px;height: 28px;" ></div>',
								align : 'center',
								width : '8%',
								formatter : function(value,rowData, rowIndex) {
								   return rowData.linecount;
								}
								//linecount
							},	
						/* 	{field : 'all_score',title : '总积分',align : 'center', width : '10%'},
							{field : 'avg_score',title : '评价',align : 'center', width : '10%'},
							{field : 'satisfyscore',title : '满意度',align : 'center', width : '10%',
								formatter : function(value,rowData, rowIndex) {
									return rowData.satisfyscore+'%';
								}
							}, */
							{field : '',title : '操作',align : 'center', width : '12%',
								 formatter : function(value,rowData, rowIndex) {
										var str= '<a href="###" onclick="edit('+rowData.lineid+')" >修改</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#evaluateButton" class="evaluateButton" onclick="cheack_evaluate(this)" linename="'+rowData.linename+'" data-val="'+rowData.lineid+'">评论<a>';
										return str;
								} 
							},
				]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery('#tab0').addClass('active');
		page0.load({"expert_id":"<?php if(!empty($expert['id'])){echo $expert['id'];} ?>"});
	});
	 $(function() {
         $("#checkAll").click(function() {
              $('input[name="expert_grade[]"]').attr("checked",this.checked); 
          });

      });
});
//-------------------------------------------------------管家售卖列表end----------------------------------------------
	$(function(){
		$(".table").css("border-bottom","1px solid #d5d5d5")
		
		$(".pagination").css("padding-top","20px")
	})
//----------------------调整管家级别----------------------------
function update_grade(id){
	$.post("/admin/a/grade/get_expert_target",{id:id},function(data) {
		var data = eval('('+data+')');
		if(data.status==1){
			$('.expert_realname').html(data.expert.realname);
			$('.expert_nickname').html(data.expert.nickname);
			$('.expert_mobile').html(data.expert.mobile);
			$('.expert_email').html(data.expert.email);
			$('.expert_city').html(data.expert.pd_name+data.expert.cid_name);
			if(data.expert.grade>0){  //管家级别
				var grade_id=data.expert.grade;
				$("#expert_gradeDate option").each(function (){ 
					if(grade_id==$(this).val()){
						$(this).attr("selected", true); 
					}
			    }); 
			}
		}else if(data.status==-1){
			alert(data.msg);	
		}
	})
	$('.modal-backdrop,.edit_expert_grade').show();
}
//保存管家调整级别
function submit_expert_grade(){
    
	$.post('/admin/a/grade/save_expert_grade',$('#expert_grade_form').serialize(),function(data) {
		var data = eval('('+data+')');
		if (data.status == 1) {			
			alert(data.msg);
			$('#expertGrade_div').html(data.expert_grade);
			$('.bc_close').click(); 
		} else {
			alert(data.msg)
		}
	})
	return false;
}
//------------------------管家指标-----------------------------
function ab_xiugai(obj){
		$.post("/admin/a/grade/get_expert_target",{id:obj},function(data) { 
			var data = eval('('+data+')');
			if(data.status==1){
				$('#expert_target_form').find('input[name="satisfaction_rate"]').val(data.expert.satisfaction_rate);
				$('#expert_target_form').find('input[name="sati_intervene"]').val(data.expert.sati_intervene);
				$('#expert_target_form').find('.satisfaction_all').html(data.expert.all_intervene+'%');
				$('#expert_target_form').find('input[name="people_count"]').val(data.expert.people_count);
				$('#expert_target_form').find('input[name="order_amount"]').val(data.expert.order_amount);
				$('#expert_target_form').find('input[name="total_score"]').val(data.expert.total_score);
				$('#expert_target_form').find('input[name="expert_id"]').val(data.expert.id);
			}else if(data.status==-1){
				alert(data.msg);	
			}
		})
		$('.modal-backdrop,.edit_expert_target').show();
}
//保存修改的管家指标
function submit_expert_target(){
	
	var satisfaction_rate=$('#expert_target_form').find('input[name="satisfaction_rate"]').val();
	var re = /^[1-9]+[0-9]*]*$/;     //判断是否为整数
	var floatstr= /^[0-9]+.?[0-9]*$/ ;       //判断字符串是否为数字
	if(satisfaction_rate!='' && satisfaction_rate!=0){
	    if (!re.test(satisfaction_rate)) {
	    	alert('年满意度需少于100的整数');
	        return false;
	    }else if(satisfaction_rate>100){
	    	alert('年满意度需少于100的整数');
	    	return false;
	    }
	}
    var people_count=$('#expert_target_form').find('input[name="people_count"]').val();
    if(people_count!='' && people_count!=0){
    	 if (!re.test(people_count)) {
    		 alert('年销人数必需整数');
    	      return false;
         }
     }
   var order_amount=$('#expert_target_form').find('input[name="order_amount"]').val();
   if(order_amount!='' && order_amount!=0){
	   if(!floatstr.test(order_amount)){
		   alert('年成交额填写格式不对');
 	       return false; 
	   }
	}

 	var total_score=$('#expert_target_form').find('input[name="total_score"]').val();
	if(total_score!='' && total_score!=0){
		  if(!re.test(total_score)){
			   alert('年总积分填写格式不对');
	 	       return false; 
		   }
	} 
    
	$.post('/admin/a/grade/save_expert_target',$('#expert_target_form').serialize(),function(data) {
		var data = eval('('+data+')');
		if (data.status == 1) {	
			var satisfaction_all=$('#expert_target_form').find('.satisfaction_all').html();	
			$('.satisfaction_span').html(satisfaction_all);
			$('.count_span').html(people_count+'<i>人</i>');
			$('.amount_span').html(order_amount+'<i>元</i>');
			$('.score_span').html(total_score+'<i>分</i>');
			alert(data.msg);
		//	location.reload();
			$('.bc_close').click(); 
		} else {
			alert(data.msg)
		}
	})
	return false;
}
//------------------管家售卖列表编辑弹出------------------
function edit(id) {
	
	var expert_id=<?php if(!empty($expert['id'])){echo $expert['id'];}else{echo 0;} ?>;
  	$.post("/admin/a/grade/get_expert_line",{id:id,expert_id:expert_id},function(data) {
		var data = eval('('+data+')');
		if(data.status==1){
			$('#expert_line_form').find('input[name="bookcount"]').val(data.line.count);
			$('#up_line_id').val(id);
		}else if(data.status==-1){
			//alert(data.msg);
			$('#expert_line_form').find('input[name="bookcount"]').val('');
			$('#up_line_id').val(id);	
		}
		
	})  
	$('.modal-backdrop,.edit_expert_line').show();
}
//保存管家售卖线路
function submit_expert_line(){
	var re = /^[1-9]+[0-9]*]*$/;     //判断是否为整数
	var floatstr= /^[0-9]+.?[0-9]*$/ ;       //判断字符串是否为数字
	
	var bookcount=$('#expert_line_form').find('input[name="bookcount"]').val();

	if(bookcount!='' && bookcount!=0){
		 if (!re.test(bookcount)) {
    		 alert('已销数必需整数');
    	      return false;
         }
	}
	$.post('/admin/a/grade/save_expert_line',$('#expert_line_form').serialize(),function(data) {
		var data = eval('('+data+')');
		if (data.status == 1) {
			alert(data.msg);
			$('#btnSearch0').click();
			$('.bc_close').click();
			//location.reload();
			$('.count_span').html(data.expert.people_count+'<i>人</i>');
		} else {
			alert(data.msg)
		}
	})
	return false;
}
//批量修改
function submit_expertData(){
	
	var re = /^[1-9]+[0-9]*]*$/;     //判断是否为整数
	var bookcount=$('input[name="expert_bookcount"]').val();

	if(bookcount!='' && bookcount!=0){
		 if (!re.test(bookcount)) {
    		 alert('已销数必需整数');
    	      return false;
         }
	}
	if (!confirm("确认要修改?")) {
        window.event.returnValue = false;
 	 }else{
		$.post('/admin/a/grade/save_expertData_line',$('#expertDataFrom').serialize(),function(data) {
			var data = eval('('+data+')');
			if (data.status == 1) {
				alert(data.msg);
				$('#btnSearch0').click();
				$('input[name="expert_bookcount"]').val('');
				var html='<option value="">请选择</option><option value="1">管家</option><option value="2">初级专家</option>';
				html=html+'<option value="3">中级专家</option><option value="4">高级专家</option>';
				$('select[name="grade"]').html(html);		
				 $('.count_span').html(data.expert.people_count+'<i>人</i>');
			} else {
				alert(data.msg)
			}
		})
 	 }
	return false;
}
//取消批量修改
function cancel_expertData(){
	$('input[name="expert_bookcount"]').val(''); //销量
	var html='<option value="">请选择</option><option value="1">管家</option><option value="2">初级专家</option>';
	html=html+'<option value="3">中级专家</option><option value="4">高级专家</option>';
	$('select[name="grade"]').html(html);//管家级别
	$('input[name="expert_grade[]"]').attr("checked",false);  //取消选择线路
	$('#checkAll').attr("checked",false);  //取消选择线路
}
//--------------------------管家售卖线路评论------------------------------

function cheack_evaluate(obj) {
	//清除评论的内容
	$('.eject_xx_box').find('li').removeClass('hove');
	$('.eject_xx_box').find('i').css('display','none');//display: none;
	$('textarea[name="content"]').val('');
	$('textarea[name="expert_comment"]').val('');
//	$('.fileBoxUl').html('');
	//去掉管家满意分
	$(".tset_1").hide();
	$(".tset_2").hide();
	$(".tset_1 span").html('0');
	$(".tset_2 span").html('0');
	//去掉产品满意分
	$(".title_info_txt1").hide();
	$(".title_info_txt2").hide();
	$(".title_info_txt1").find("span").find("i").html('0')
	$(".title_info_txt2").find("span").find("i").html('0')
	
	$(".tijiao_ri").click();
	$(".eject_xx_box i").html("");
	//$(".expert_grade span").html("");
	$('expert_comment').val('');
	$('.score0 li').removeClass('hove');
	$('.score1 li').removeClass('hove');
	$('.score2 li').removeClass('hove');
	$('.score3 li').removeClass('hove');
	$('.score4 li').removeClass('hove');
	$('.score5 li').removeClass('hove');
	var data_arr = $(this).attr('data-val').split('|');
	$("#c_order_id").val(data_arr[0]);
	$("#c_line_id").val(data_arr[1]);
	$("#c_expert_id").val(data_arr[2]);
/*	$('#as').diyUpload({url:"<?php echo base_url('line/line_detail/upfile')?>",success:function( data ) {
		console.info( data );
		$("#pic_url").val($("#pic_url").val()+data.url+',');
	},
	error:function( err ) {
	console.info( err );
	},
	buttonText : '<div class="img_num" style="border:1px solid #ff6600; background:#fff; color:#000; border-radius:3px; height:24px; line-heighr:24px; width:100px;color:#666;">上传图片<span></span></div>',
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:5,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:50000 * 1024,
	accept: {}
});*/
	var lineid=$(obj).attr('data-val');
	var linename=$(obj).attr('linename');
	$('.comment_line').html('评价线路:'+linename);
	$('#c_line_id').val(lineid);	
}
/*评论的弹层效果*/
try {
	$(".evaluateButton").fancybox();
	$(".evaluateButton").click(function() {
		//清除评论的内容
		$('.eject_xx_box').find('li').removeClass('hove');
		$('.eject_xx_box').find('i').css('display','none');//display: none;
		$('#content1').val('');
		$('.content2').val('');
	//	$('.fileBoxUl').html('');
		//去掉管家满意分
		$(".tset_1").hide();
		$(".tset_2").hide();
		$(".tset_1 span").html('0');
		$(".tset_2 span").html('0');
		//去掉产品满意分
		$(".title_info_txt1").hide();
    	$(".title_info_txt2").hide();
		$(".title_info_txt1").find("span").find("i").html('0')
		$(".title_info_txt2").find("span").find("i").html('0')
		
		$(".tijiao_ri").click();
		$(".eject_xx_box i").html("");
		
		$('content').val('');
		$('expert_comment').val('');
		$('.score0 li').removeClass('hove');
		$('.score1 li').removeClass('hove');
		$('.score2 li').removeClass('hove');
		$('.score3 li').removeClass('hove');
		$('.score4 li').removeClass('hove');
		$('.score5 li').removeClass('hove');
		
	/*	$('#as').diyUpload({url:"<?php echo base_url('line/line_detail/upfile')?>",success:function( data ) {
			console.info( data );
			$("#pic_url").val($("#pic_url").val()+data.url+',');
		},
		error:function( err ) {
		console.info( err );
		},
		buttonText : '<div class="img_num" style="border:1px solid #ff6600; background:#fff; color:#000; border-radius:3px; height:24px; line-heighr:24px; width:100px;color:#666;">上传图片<span></span></div>',
		chunked:true,
		// 分片大小
		chunkSize:512 * 1024,
		//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
		fileNumLimit:5,
		fileSizeLimit:500000 * 1024,
		fileSingleSizeLimit:50000 * 1024,
		accept: {}
	});*/
		
});
	}catch (err) {
}

	//订单左侧提示
	$(document).on('mouseover', '.title_info', function(){
		$(this).find(".info_txt").show();
	});
	$(document).on('mouseout', '.title_info', function(){
		$(".info_txt").hide();
	});
	$(".other_reason").click(function(){
		$(this).parent().parent().siblings(".hidden_content").slideDown(300);
	});
	$(".offer_reason").click(function(){
		$(this).parent().parent().siblings(".hidden_content").slideUp(300);
	});
	//点击/移上 星星提示文字
	$(".score0 li,.score1 li,.score2 li,.score3 li").hover(function(){
		$(this).parent().siblings("i").hide();
		$(this).parent().siblings("a").show();
		var index = $(this).index();
		if(index==0){
			$(this).parent().siblings("a").html("失望");
		}
		if(index==1){
			$(this).parent().siblings("a").html("不满");
		}
		if(index==2){
			$(this).parent().siblings("a").html("一般");
		}
		if(index==3){
			$(this).parent().siblings("a").html("满意");
		}
		if(index==4){
			$(this).parent().siblings("a").html("惊喜");
		}
	},function(){
		$(this).parent().siblings("a").hide();
		$(this).parent().siblings("i").show();
	});
	$(".score0 li,.score1 li,.score2 li,.score3 li").click(function(){
		$(this).parent().siblings("a").hide();
		$(this).parent().siblings("i").show();
		var index = $(this).index();
		if(index==0){
			$(this).parent().siblings("i").html("失望");
		}
		if(index==1){
			$(this).parent().siblings("i").html("不满");
		}
		if(index==2){
			$(this).parent().siblings("i").html("一般");
		}
		if(index==3){
			$(this).parent().siblings("i").html("满意");
		}
		if(index==4){
			$(this).parent().siblings("i").html("惊喜");
		}
		//产品满意度
		var sco_mun=$(".score0,.score1,.score2,.score3").find(".hove").length;
		var mun= sco_mun*5;
		var fen= (sco_mun*5/20).toFixed(1);

		$(".title_info_txt1").show();
		$(".title_info_txt2").show();
		$(".title_info_txt1").find("span").find("i").html(mun)
		$(".title_info_txt2").find("span").find("i").html(fen)
	});

	var img_arr='';
		$('#as2').diyUpload({
		url:"<?php echo base_url('line/line_detail/upfile')?>",
		success:function( data ) {
		//console.info( data );
		img_arr=img_arr+'<input type="hidden" name="img[]" value="'+data.url+'" />';
		$('.pic_comment').html(img_arr);
		},
		error:function( err ) {
		console.info( err );
		},
		//buttonText : '<img class="fl" src="<?php echo base_url('static'); ?>/img/user/u9.png"/><div class="img_num fl"><i>0</i>/5</div>',
		buttonText : '<div class="img_num" style="border:1px solid #ff6600; background:#fff; color:#000; border-radius:3px; height:24px; line-heighr:24px; width:100px;color:#666;">上传图片<span></span></div>',
		//buttonText : '上传',
		chunked:true,
		// 分片大小
		chunkSize:512 * 1024,
		//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
		fileNumLimit:5,
		fileSizeLimit:500000 * 1024,
		fileSingleSizeLimit:50000 * 1024,
		accept: {}
		});


	//管家评分
	$(".score4 li").click(function(){
		var sco4=$(".score4").find(".hove").length;
		var sco5=$(".score5").find(".hove").length;
		var mun= (sco4+sco5)/2;
		//alert(mun)
		$(".tset_1").show();
		$(".tset_2").show();
		$(".tset_1 span").html((sco5+sco4)*10);
		$(".tset_2 span").html(mun);
		
	});
	$(".score5 li").click(function(){
		var sco4=$(".score4").find(".hove").length;
		var sco5=$(".score5").find(".hove").length;
		var mun= (sco4+sco5)/2;
		$(".tset_1").show();
		$(".tset_2").show();
		$(".tset_1 span").html((sco5+sco4)*10);
		$(".tset_2 span").html(mun);
		//alert(mun)
	});

	//字数计算
	//字数提示标签 <span class="font_num_title">已评论<i>0</i>字</span>
	$("textarea").keyup(function(){
		var content = $(this).val();	
		var fontNum = content.length;
		$(this).siblings(".font_num_title").find("span").html(fontNum);
	});
	/**
	* 将上传获取的图片
	*/
	function uploadSuccess(file, file_data ){	
	//   var imgurl='';
		var url	=file_data.replace("\"","");
		var imgurl='<li><i id="" onclick="del_imgdata(this,-1);"></i><img style="width:280px;height:160px;" src="/file/c/share/image/'+url+'><input type="hidden" id="editor_share_pic_1" value="/file/c/share/image/'+url+'" name="img_url[]"  /></li>';
		$('#pic_str').append(imgurl);
		$('#editor_pic_str').append(imgurl);
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setComplete();
			progress.setStatus("上传成功");
			progress.toggleCancel(false);
		} catch (ex) {
			this.debug(ex);
		}
	}
	//删除图片
	function del_imgdata(obj,id){
		var pid=id;
		if (!confirm("确认删除？")) {
			window.event.returnValue = false;
		}else{
			$(obj).parent('li').remove();
		}
		$.post("<?php echo base_url()?>base/member/del_share_img", { data:id} , function(result) {
		});
	}

	//----------保存评论------------
	function Checkevaluate(){
 
	var content= $('#content').val();
	if(content!=''){
		//不能超过100个字
		var str=content;
		var realLength = 0, len = str.length, charCode = -1;
		for (var a = 0; a < len; a++) {
		charCode = str.charCodeAt(a);
		if (charCode >= 0 && charCode <= 128)
			realLength += 1;
		else realLength += 1;
		}
		if(realLength>200){
			alert('线路的评价内容不能超过200个字');
			return false;
		}
	}
	
    //专家的评论expert_comment
	var expert_comment= $('.expert_comment').val();
	if(expert_comment!=''){
		//不能超过100个字
		var str=expert_comment;
		var realLength = 0, len = str.length, charCode = -1;
		for (var a = 0; a < len; a++) {
			charCode = str.charCodeAt(a);
			if (charCode >= 0 && charCode <= 128)
				realLength += 1;
			else realLength += 1;
		}
		if(realLength>200){
			alert('评价管家的内容不能超过200个字');
			return false;
		}
	}

	//获取星级分数
	var score0=$(".score0 .hove").length;
	var score1=$(".score1 .hove").length;
	var score2=$(".score2 .hove").length;
	var score3=$(".score3 .hove").length;
	var score4=$(".score4 .hove").length;
	var score5=$(".score5 .hove").length;
	if(score0==0){
		alert('导游服务评分不能为空');
		return false;
	}
	if(score1==0){
		alert('行程安排评分不能为空');
		return false;
	}
	if(score2==0){
		alert('餐饮住宿评分不能为空');
		return false;
	}
	if(score3==0){
		alert('旅游交通评分不能为空');
		return false;
	}
	if(score4==0){
		alert('管家专业度评分不能为空');
		return false;
	}
	if(score5==0){
		alert('管家服务态度评分不能为空');
		return false;
	}
	var str='';
	str=str+'<input type="hidden" name="score0" value="'+score0+'" /><input type="hidden" name="score1" value="'+score1+'" />';
	str=str+'<input type="hidden" name="score2" value="'+score2+'" /><input type="hidden" name="score3" value="'+score3+'" />';
	str=str+'<input type="hidden" name="score4" value="'+score4+'" /><input type="hidden" name="score5" value="'+score5+'" />';
	$('.grades').html(str);
//order_from/order/comment
	jQuery.ajax({ type : "POST",data : jQuery('#evaluateForm').serialize(),url : "<?php echo base_url();?>admin/a/grade/save_comment",
	success : function(data) {
		var data = eval('('+data+')');
		if (data.status == 1) {
			alert(data.msg);
			location.reload();
			$('.fancybox-close').click();
		} else {
			alert(data.msg)
			$('.fancybox-close').click();
		}
	}
	});
	return false;
}

//年满意度的变化
function s_change(obj){
	$stati_val=$('#expert_target_form').find('input[name="satisfaction_rate"]').val();
	$all_value=parseFloat($stati_val)+parseFloat(obj.value);
	$('#expert_target_form').find('.satisfaction_all').html($all_value+'%');
	if($all_value>100){
		alert('年满意度百分比不能大于100');
		return false;
	}
	if($all_value<0){
		alert('年满意度百分比不能大于0');
		return false;
	}
	
}
</script>

<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<script src="/assets/js/jquery-1.11.1.min.js"></script>		
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script> 

<style type="text/css">
	/*.div_bt_i i{ background: rgba(0, 0, 0, 0) url("<?php echo base_url();?>assets/img/add_icon.png") no-repeat ;width: 17px;height: 34px; position: absolute;}*/
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a href="/admin/b1/view">首页</a></li>
		<li class="active">编辑线路</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<style type="text/css">
.fl{ float: left;}
.tree-node-empty {
  height: 18px;
  width: 20px;
  float: left;
}

.route{
display: inline-block;padding: 5px 4px;
}

.shop_insert_label {
	width: 1%;
	margin-left: -5%;
}

.shop_insert_labels {
	margin-left: -4%;
}

.shop_insert_label_j {
	margin-left: -5.5%;
	width: 72px;
}

.shop_insert_day {
	margin-left: -3%;
}

.shop_insert_days {
	margin-left: -1.5%;
}


.shop_insert_input {
	width: 60px;
}

.label-width {
	width: 8%;
}

.text-width {
	width: 50%;
}

.small-width {
	width: 110px;
}

.user_name_b1 {
	width: 100px;
}
.line-lable,.selectedContent {
  color: #15b000;
  height: 26px;
  line-height: 26px;
  position: relative;
  background: #edf6fa;
  border: 1px solid #d7e4ea;
  padding: 6px 20px 6px 12px;
  margin-right: 2px;
    vertical-align: middle;
}
/*.line-lable,.selectedContent a{
  display: block;
  width: 24px;
  height: 32px;
  position: absolute;
  top: 0;
  right: 0;
  cursor: pointer;
  text-align: center;
  font-size: 21px;
  font-weight: 700;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  filter: alpha(opacity=20);
  opacity: .2;
}*/
.table-class input[type=checkbox] {
	opacity: 100;
	position: inherit;
	left: 0px;
	z-index: 12;
	width: 16px;
	height: 16px;
	cursor: pointer;
	vertical-align: middle;
	margin: 0;
}
ul li{
  list-style: none;
    margin: 0;
}
/*批量价格弹框的样式*/
 .tbtsdgk{
position:fixed;background: none repeat scroll 0 0 #fff;top:15%;left:35%;z-index: 131;margin:auto;/*width:35%;*/
margin-right:20px;width: 600px;
}
.closetd{background:none;opacity: 0.2; padding:4px 0 0 6px;font-size: 29px; font-weight: 800;top:-18px;right:0px;}
/* 批量上传图片的样式*/
.img_main{
  width: 190px;
  height: 190px;
  overflow: hidden;

}
.img_main0{
  position:relative;
  margin-top:10px;
}
.float_div{
 position:unset;
width:17px;
height:17px;
float:right;
z-index:100;
color: #000;
font-size: 21px;
font-weight: 700;
opacity: 0.2;

}
.float_img{ 
position:absolute;
height:16px;
z-index:100;
color: #000;
font-size: 21px;
font-weight: 700;
opacity: 0.2;
font-size:24px;
top:-18px;
right:10px;
}
.webuploader-pick{ left:0px;}
.parentFileBox{float:left;width:100px;}
.parentFileBox .fileBoxUl{display:none;};
.parentFileBox .diyButton{float:left;};
.form-group .col_ip{float:left; }
.form-group .col_xl{ float: left;text-align:right; width: 135px;}
.col_price{ width: 100px; float: left; text-align: right;padding-top: 4px;}
.price_input{ margin-left: 5px; padding: 4px 2px;}
.lp_div .col-sm-4{ width:83%;}
.lp_div .col-sm-4 input{width: 90%; height: 30px;}
.lp_div .col-sm-4 textarea{width: 90%; }
.lp_div .col-sm-4 .jg_my{ line-height: 30px;}
.lp_div .col-sm-4 .hege{float: left;font-size: 20px;padding:0px 7px;}
.ck_div .col-sm-4 .col_sx{ line-height: 30px}
.caozuo span{color: #0000ff; cursor: pointer;}
.priceDate .price ,.priceDate .disableText{ margin-left: 3px;margin-right: 3px;}
.zif_table tr td input { text-align:center;border:none;width:100%;height:20px;outline:none;}
.train_table textarea{width: 100%;height: 52px;overflow:auto;border:none;}
.zif_table textarea{width: 100%;height: 50px;overflow:auto;border:none;}
.form-group .disabled {color: #aaa;}
/*行程安排*/
.col_ts{ float: left;}
.col_lb{ float: left; text-align: right; line-height: 34px; padding-top: 0px;}
.label-width{width: 100px;}
.title_div{background: white;background-color: #FFFFFF;border: 1px solid #d5d5d5;  padding: 0px 12px;width: auto;min-height:33px; line-height:33px; min-width:500px}
.title_div .MsoNormal span{font-size: 14px;   font-family:inherit;}
.col_wd{ width: 250px;}
.choice_img { display:block;width:80px;height:35px;line-height:35px;text-align:center;background:#00b7ee;color:#fff;cursor:pointer;border-radius:4px;}
.attr-item-selected{
    color: #15b000 !important;
        background: #edf6fa;
    border: 1px solid #d7e4ea;
    vertical-align: middle;
}
.attr-item{width:85px;margin: 3px 5px !important;}
.selectedTitle{float: left;padding-right: 10px;padding-top: 8px;}
.problem_div{ margin-top: 20px;position: relative;}
.problem_title{height: 80px; width: 80px;}
.hot_problem label ,.problem_answer label {font-weight: bold; font-size: 16px; }
.hot_problem input{height: 35px;line-height: 35px;width: 700px;}
.problem_answer{margin-top: 15px;}
.form-horizontal .form-group input { width:700px !important;line-height:34px;height:34px;}
 .problem_answer textarea{ height: 100px; width: 700px !important;}
 .problem_answer label { margin-top:-160px;}
 .delete_bomb{ background: #e1e1e1; height: 25px;width: 160px; position: absolute; left: 630px;  line-height: 25px; text-align: center; color: #666; top: 22px; display: none;}
 .icon{ background: rgba(0, 0, 0, 0) url("/assets/img/pxun_btn.png") no-repeat ; height: 24px;width: 24px; position: absolute;}
 .icon_1{left: 784px; top: 5px}
 .div_bt_i .tjia_btn span{padding:5px; background: #2dc3e8;color: #fff; border-radius: 4px;}

</style>
<div id="img_upload">
	<div id="altContent"></div>
	<div class="close_xiu" onclick="close_xiuxiu();">×</div>
	<div class="right_box"></div>
</div>
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" id="expert_training"><a href="#profile17" data-toggle="tab"> 管家培训 </a><li>
				</ul>
				<div class="tab-content tabs-flat" style="padding: 0px 12px">					
					<!-- 管家培训-->
			    	<div class="tab-pane active" id="profile17">
						<form action="<?php echo base_url()?>admin/b1/product/updatelineTrain" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post" 
						id="lineTrainForm" novalidate="novalidate" onsubmit="return ChecklineTrain();" >
						<div class="widget-body">
						  <input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" /> 
						
						 <div style="margin-left:6px;width:870px;color:red;"> 
						 <span>旅游管家在申请售卖权时，需认真阅读您的“管家培训”内容后才可得到资质。因此请您认真填写在售卖此条线路时，游客最经常问到的至少十个问题（多不限），并提供相对固定的参考答案。</span></div>
							<div class="form-group" style="margin-left:0.5%;margin-top:20px;">
							<?php if(!empty($train)){ foreach ($train as $k=>$v){?>
								<div class="problem_div">
									<div class="problem_title fl">
									       <span class="num">问题<?php echo $k+1; ?></span>
									       <input type="hidden"  name="train_id[]" value="<?php echo $v['id']; ?>"/>
									</div>
									<div class="hot_problem">
										<label>Q：</label>
										<input  type="text" name="question[]"  value="<?php echo $v['question']; ?>" placeholder="请输入热门问题">
										<i class="icon icon_1"   onclick="del_train(this,<?php echo $v['id'] ;?>)"></i>
									</div>
									<div class="delete_bomb">
									<span>点击按钮,删除此问题</span>
									</div>
									<div class="problem_answer">
										<label>A：</label>
										<textarea name="answer[]" placeholder="请输入参考答案"><?php echo $v['answer']; ?></textarea>
									</div>
								</div>
                                <?php }}else{?>
                                <div class="problem_div">
									<div class="problem_title fl">
									       <span  class="num">问题1</span>
									       <input type="hidden"  name="train_id[]" value=""/>
									</div>
									<div class="hot_problem">
										<label>Q：</label>
										<input  type="text" name="question[]"  value="" placeholder="请输入热门问题">
										<i class="icon icon_1"    onclick="del_train(this,'')"></i>
									</div>
									<div class="delete_bomb">
									<span>点击按钮,删除此问题</span>
									</div>
									<div class="problem_answer">
										<label>A：</label>
										<textarea name="answer[]" placeholder="请输入参考答案"></textarea>
									</div>
								</div>
									<div class="problem_div">
									<div class="problem_title fl">
									       <span  class="num">问题2</span>
									       <input type="hidden"  name="train_id[]" value=""/>
									</div>
									<div class="hot_problem">
										<label>Q：</label>
										<input  type="text" name="question[]"  value="" placeholder="请输入热门问题">
										<i class="icon icon_1"   onclick="del_train(this,'')"></i>
									</div>
									<div class="delete_bomb">
									<span>点击按钮,删除此问题</span>
									</div>
									<div class="problem_answer">
										<label>A：</label>
										<textarea name="answer[]" placeholder="请输入参考答案"></textarea>
									</div>
								</div>
								<div class="problem_div">
									<div class="problem_title fl">
									       <span  class="num">问题3</span>
									       <input type="hidden"  name="train_id[]" value=""/>
									</div>
									<div class="hot_problem">
										<label>Q：</label>
										<input  type="text" name="question[]"  value="" placeholder="请输入热门问题">
										<i class="icon icon_1"    onclick="del_train(this,'')"></i>
									</div>
									<div class="delete_bomb">
									<span>点击按钮,删除此问题</span>
									</div>
									<div class="problem_answer">
										<label>A：</label>
										<textarea name="answer[]" placeholder="请输入参考答案"></textarea>
									</div>
								</div>
                               <?php  }?>

							</div>
						</div>
						<div class="div_bt_i">
						           <div class="tjia_btn fl train_btn"  ><span >+添加</span></div>
							<label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:20%;"></label>
							<button class="btn btn-palegreen cjia_btn_1" type="submit">保存</button>
						</div>
						</form>
					</div>
					
					<div class="title_info_box" style="display:none;position:fixed;border:1px solid #f00;text-align:left;text-indent:30px;width:300px;padding:10px;background:#fff;z-index:999;color:#f00;font-size:14px;top:100px;right:20px;font-weight:600;">	
                       	
                    </div>
				</div>
			</div>
		</div>
	</div>

</div>
          
<!-- 批量价格录入的弹框 -->

<div style="display: none;" class="tbtsdgk">
	<div class="closetd">×</div>
	<form action="" class="form-horizontal"  role="form" id="applyPrice" method="post" onsubmit="return updataPrice(this);">
		<div align="center">
			<div class="widget-body">
				<div id="registration-form" class="messages_show" style="">
				 	<table class="table table-bordered table-hover money_table">	  
						<tr>
								<td style="vertical-align : middle;width:100px;"><span style="color: red;">*</span>选择日期：</td>
								<td  style="vertical-align : middle;height: 90px;"> 
								
								<textarea name="startDate" cols="" rows="" readonly="readonly" id="startDate" placeholder="请点击选择" 
									onclick="T2TCNCalendar.display(this, new Date(), AddDay('Y',1,new Date()), document.getElementById('xDate'),10,'checkboxNameX');" 
									style="overflow-y:hidden;height:100%;width:100%;padding: 0;margin: 0"
								    onpropertychange="this.style.height = this.scrollHeight + 'px';" oninput="this.style.height = this.scrollHeight + 'px';"></textarea>
									<input type="text" id="xDate" style="display:none">
								</td>
													
							</tr>
					     <tr><td><span style="color: red;">*</span>空位</td>
						<td colspan="3">
						<input name="line_id" value="<?php echo $data['id'];?>" id="line_id" type="hidden" />		
						<input name="suit_id" value="" id="suit_id" type="hidden" />
						<input name="suit_name" value="" id="suit_name" type="hidden" />
						<input name="suit_unit" value="" id="suit_unit" type="hidden" />
						<input id="inputEmail" type="text" size=8 class="people"  name="people">份</td>
						</tr>
						<tr>
						<td><span style="color: red;">*</span>成人价</td>
						<td colspan="2"><input id="inputEmail" type="text"  size=8 name="adult_price">元</td>
						</tr>
						<tr>
						<td>儿童价</td>
						<td colspan="2"><input id="inputEmail" type="text" size=8  name="chil_price">元</td>
						</tr>
						<tr>
						<td>儿童价不占床</td>
						<td colspan="2"><input id="inputEmail" type="text" size=8  name="chil_nobedprice">元</td>
						</tr>
						<tr>
						<td>老人价</td>
						<td colspan="2"><input id="inputEmail" type="text" size=8  name="old_price">元</td>
						</tr>
						<tr><td colspan="3"><input class="btn btn-palegreen "  onclick="closePirce()" style="float: right;margin-right:180px;" type="button" value="关闭" /><input class="btn btn-palegreen"  style="float: right;margin-right:110px;" type="submit" value="确认"/></td></tr>
						</tbody>
					</table>	
				</div>
			</div>
		</div>
		</form >
	</div>

  
<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<script src="<?php echo base_url('assets/js/jQuery-plugin/dateTable/jquery.dateTable.js')?>"></script>
<link href="<?php echo base_url('assets/css/product.css')?>" rel="stylesheet" />
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>

<script type="text/javascript" src="<?php echo base_url('static/js/common.js'); ?>"></script>
<script type="text/javascript">	

//添加管家培训
$(".train_btn").on('click', function () {

	var l=$(".problem_div").length - 1;
	var n=$(".problem_div").length +1;
	var train_html ='<div class="problem_title fl"> <span  class="num">问题'+n+'</span><input type="hidden"  name="train_id[]" value=""/></div>';
	train_html=train_html+'<div class="hot_problem"><label>Q：</label><input  type="text" name="question[]" placeholder="请输入热门问题"><i class="icon icon_1"  onclick="del_train(this,-1)"></i></div>';
	train_html=train_html+'<div class="delete_bomb"><span>点击按钮,删除此问题</span></div>';
	train_html=train_html+'<div class="problem_answer"><label>A：</label><textarea name="answer[]" placeholder="请输入参考答案"></textarea></div>';
 	
	if(l==-1){            
		var trlen = $(".problem_div");           
		trlen.html("<div class='problem_div'>"+train_html+"</div>"); 
	}else{
		var trlen = $(".problem_div").eq(l);           
		trlen.after("<div class='problem_div'>"+train_html+"</div>"); 
	}
	$('.icon_1').hover(function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').show();
	},function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').hide();
	});    
     
});
//删除管家培训
function del_train(obj,id){    
	var index = $(".icon_1").index(obj);
	if(id!='' && id>0){
		 if (!confirm("确定要删除？")) {
	            window.event.returnValue = false;
	        }else{
				jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/product/deleteTrain",
					success : function(response) {
						if(response){
							alert('删除成功！');
							$(".problem_div").eq(index).remove();
							$(".problem_div").each(function(i){
								var index = $(".problem_div").index(this);
								//var num = parseInt($(this).find(".num").html());
								$(this).find(".num").html('问题'+(index+1));
							});
						}else{
							alert('删除失败！');
						}
					}
				});
	        }
	}else{
		//alert('删除成功！');
		$(".problem_div").eq(index).remove();
		$(".problem_div").each(function(i){
			var index = $(".problem_div").index(this);
			//var num = parseInt($(this).find(".num").html());
			$(this).find(".num").html('问题'+(index+1));
		});
	}	
}

//温馨提示
function ChecklineTrain(){	
/* 		var editor=$("#editor").val();
		if(editor==''){
			alert('温馨提示的内容不能为空！');
			return false;
		} */
		jQuery.ajax({ type : "POST",data : jQuery('#lineTrainForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/updateTrain", 
			success : function(response) {
			 	 if(response!='' && response!='0'){	 	 
					alert( '保存成功！' );
					//下一步						
					$("#click_tips").removeClass('active');
					$("#profile15").removeClass('active');
		
					$("#expert_training").addClass('active');
					$("#profile17").addClass('active');
					var tyle=<?php echo $tyle; ?>;	
					
				    if(tyle==2){ // 包团
					   window.location.href="/admin/b1/group_line?type=2";
				    }else{
				    	window.location.href="/admin/b1/product?type=2";
					}
					 
				}else{
					alert( '保存失败' );
				}   
			}
		});
	return false;
}
//删除问题
$(function () {  
	$('.icon_1').hover(function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').show();
	},function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').hide();
	});
})

</script>






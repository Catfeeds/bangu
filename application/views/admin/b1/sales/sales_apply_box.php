<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试模板</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script> 

</head>
<body>
	
    <!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
               
        <!-- ===============订单详情============ -->
        <div class="order_detail_d" style="margin: auto 3px;">
          
            <!-- ===============基础信息============ -->
            <div class="content_part">
                 <!-- <div class="small_title_txt clear">
                    <span class="txt_info fl">选择线路:</span>
                 </div> -->
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">  
                    <tr style="height:40px">
                        <td class="order_info_title">促销类型:</td>
                        <td colspan="3">
                        <select name="typeId">
                          <option>请选择</option>
                        
                        </select>
                        </td>

                    </tr>     
                    <tr style="height:40px">
                        <td class="order_info_title">选择线路:</td>
                        <td colspan="3">
                           <input type="text" name="" value="" class="search_input" id="clickChoiceLine"  style="width:250px;"/>
                       	   <input type="hidden" name="line_id" value="" class="search_input" id="line_id" />
                        </td>

                    </tr>
                   <!-- <tr style="height:40px">
                        <td class="order_info_title">促销标题:</td>
                        <td colspan="3">
                            <input type="text" name="sales_name" value="" class="search_input" id="sales_pic" style="width:250px;" />
                        </td>
                    </tr>  
                    <tr style="height:40px">
                        <td class="order_info_title">促销图片:</td>
                        <td colspan="3"></td>
                    </tr>-->
                    <tr style="height:40px">
                        <td class="order_info_title">促销价格:</td>
                        <td colspan="3"><input type="button" name="" value="选择" class="search_button"   /></td>
                    </tr>
                    <tr style="height:40px">
                        <td class="order_info_title">排序:</td>
                        <td colspan="3"><input type="text" name="sort " value="9999" class="search_input"  style="width:250px;" /></td>
                    </tr>
                    

                </table>
                <div style="margin-top:30px;"> 
                    <input type="button" name="" value="确认" class="btn btn_blue" id="confirm_order_btn" style="margin-left:210px;"  onclick="confirm_order()" />
                    <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  />
                </div>
            </div>
            
            <!-- ===============参团人============ -->
           
        </div>
	</div>

</body>

<div class="choice-box-line">
	<div class="cb-body">
		<h3 class="cb-title">选择线路</h3>
		<div class="cb-colse db-cancel">x</div>
		<div class="cb-search">
			<span class="cb-prompt"><!--已选择不可更改的信息提示--></span>
			<form action="#" method="post" id="cb-search-form">
				<input type="text" name="keyword" placeholder="关键词" />
				<span id="cb-choice-city"></span>
				<input type="hidden" name="page_new" value="1" />
				<input type="hidden" name="city_id" value="" />
				<input type="hidden" name="dest_id" value="" />
				<input type="hidden" name="themeId" value="" />
				<input type="submit" value="搜索" id="db-submit" />
			</form>
		</div>
		<div class="db-data-list">
			<ul class="db-data-line">
			</ul>
			<div class="db-pagination page-button">分页</div>
		</div>
		
		<div class="db-button">
			<div class="db-cancel">取消</div>
			<div class="db-submit line-submit">确认选择</div>
		</div>
	</div>
</div>





</html>




<?php echo $this->load->view('admin/a/choice_data/choiceLine.php');  ?>
<script type="text/javascript">
/*
function confirm_order(){  
	
   var bill_id=<?php  //if(!empty($bill_id)){ echo $bill_id;}else{ echo 0;}  ?>;
   var orderid=<?php  //if(!empty($orderid)){ echo $orderid;}else{ echo 0;}  ?>;

   jQuery.ajax({ type : "POST",async:false,data : { 'bill_id':bill_id,'orderid':orderid},url : "<?php echo base_url()?>admin/b1/order/save_confirm_order", 
       beforeSend:function() {//ajax请求开始时的操作
            layer.load(1);//加载层
       },
       complete:function(){//ajax请求结束时操作              
            layer.closeAll('loading'); //关闭层
       },
       success : function(result) { 
     	  data = eval('('+result+')');
	       	   if(data.status==1){
	               
	 	       	   layer.msg(data.msg, {icon: 1});  
		 	       parent.location.reload();
	         }else{
	               alert(data.msg);
	         } 
       }
   });
 
}*/
//关闭按钮
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
$('#refuse').click(function()
{
     parent.layer.close(index);
});

var formObj = $("#add-data");
 $('.line-submit').click(function(){
		var activeObj = $('.db-data-line').find('.db-active');
		$('#clickChoiceLine').val(activeObj.attr('data-name'));
		$('input[name=line_id]').val(activeObj.attr('data-val'));
		$(".choice-box-line").hide();
}) 
 
 //-------------------选择线路---------------------------
 $('#clickChoiceLine').click(function(){
	createLineHtml();
})
 	function createLineHtml() {
		$.ajax({
				url:'/admin/b1/sales_apply/getLineJson',
				type:'post',
				dataType:'json',
				data:$("#cb-search-form").serialize(),
				success:function(data){
					if ($.isEmptyObject(data.list)) {
						$(".db-pagination").html('');
						$(".db-data-line").html('<div class="db-msg">暂无数据</div>');
					} else {
						var html = '';
						$.each(data.list ,function(key ,val){
							var overcity = val.overcity.split(',');
                                                        // 将cj和gn改为line,添加后缀.html
							// var url = $.inArray('1' ,overcity) == -1 ? '/gn/'+val.lineid : '/cj/'+val.lineid;
                                var url = $.inArray('1' ,overcity) == -1 ? '/line/'+val.lineid + '.html' : '/line/'+val.lineid + '.html';
							if (key % 2 == 1) {
								html += '<li class="db-data-row row-odd" data-val="'+val.lineid+'" data-name="'+val.linename+'">';
							} else {
								html += '<li class="db-data-row" data-val="'+val.lineid+'" data-name="'+val.linename+'">';
							}
							html += '<div class="db-data-pic"><img src="'+val.mainpic+'" /></div>';
							html += '<ul><li>';
							//html += '<div class="db-row-title">线路名：</div><div class="db-row-content"><a href="'+url+'" target="_blank" >'+val.linename+'</a></div>';
							html += '<div class="db-row-title">线路名：</div><div class="db-row-content"><a href="javascript:void(0);" onclick="see_detail('+val.lineid+')">'+val.linename+'</a></div>';
							html += '</li><li>';
							html += '<div class="db-row-title">供应商：</div><div class="db-row-content">'+val.company_name+'</div>';	
							html += '</li><li>';		
							html += '<div class="db-row-title">始发地：</div><div class="db-row-content">'+val.cityname+'<span style="float:right;margin-right:10px;color: #ff0000;">¥'+val.s_price+'</span></div>';			
							html += '</li></ul></li>';	
						})
						$(".db-data-line").html(html);
					}
					$(".db-pagination").html(data.page_string);
					rowClick();
					pageClick();
					if ($(".choice-box-line").is(':hidden')) {
						$(".choice-box-line").show();
					}
					$('html,body').animate({scrollTop:0}, 'slow');
				}
			});
	}
	function rowClick() {
		$(".db-data-row").click(function(){
			if ($(this).hasClass('db-active')) {
				$(this).removeClass('db-active');
			} else {
				$(this).addClass('db-active').siblings().removeClass('db-active');
			}
		})
	}
	function pageClick(){
		$(".db-pagination").find('li').click(function(){
			if (!$(this).hasClass('active')){
				$("#cb-search-form").find('input[name=page_new]').val($(this).find('a').attr('page_new'));
				createLineHtml();
			}
		})
	}
	$("#cb-search-form").submit(function(){
		$("#cb-search-form").find('input[name=page_new]').val(1);
		createLineHtml();
		return false;
	})
	$(".db-cancel").click(function(){
		$(".choice-box-line").hide();
	})
	//线路详情
	function see_detail(id){	
		layer.open({
			title:'线路详情',
			type: 2,
			area: ['1000px', '90%'],
			fix: false, //不固定
			maxmin: true,
			content: "<?php echo base_url('admin/a/lines/line/detail');?>"+"?id="+id+"&type=1"
		});
	}
	 //-------------------选择线路end---------------------------
	
</script>
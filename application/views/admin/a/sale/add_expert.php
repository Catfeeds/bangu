<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>tltle</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
    <style type="text/css">
        .selectedContent {
		    border: 1px solid #ccc;
		    padding: 4px;
		    border-radius: 3px;
		    margin-right: 5px;
		    line-height: 30px;

		}
		.delPlugin {
		    margin-left: 5px;
		    color: red;
		    cursor: pointer;
		    padding: 2px;
		}
    </style>
</head>
<body>
 <!--   <div class="RongBox">
    	<form action="" id="salesExpertForm">
        <div class="RongCon">
            <div class="flex10">
                <div class="ListTitle">产品编号</div>
                <div class="ListSub">
                    <div class="ListInput">
                    	<?php  if(!empty($line['linecode'])){ echo $line['linecode'];} ?>
                    </div>
                </div>
            </div>
            <div class="flex10">
                <div class="ListTitle">产品名称</div>
                <div class="ListSub">
                    <?php  if(!empty($line['linename'])){ echo $line['linename'];} ?>
                </div>
            </div>

            <div class="flex10" style="height:auto; ">
                <div class="ListTitle">管家</div>
                <div class="ListSub">
                    <div class="ListInput">
 						<input type="text" id="expertList" name="expertList" onfocus="show_expertList(this);" >
                        <input type="hidden" id="expertData" name="expertData"  >
                    </div>        
         
                </div>
            </div>
            
             <div class="flex10" style="height:auto;">
                <div class="ListTitle">售卖管家</div>
                <div class="ListSub" style="height:auto;">
                     <div id="ds-list" style="width:500px;float:left;margin:0px 0px 4px 8px;"> 
	                     <?php if(!empty($expert)){
	                         foreach ($expert as $k=>$v){
	                     ?>
	                     	<span class="selectedContent" value="<?php echo $v['expert_id']; ?>">
	                            	<?php echo $v['realname']; ?><input name="expertId[]" value="<?php echo $v['expert_id']; ?>" type="hidden">
	                            	<span class="delPlugin" onclick="delPlugin(this ,'' ,'ds-list');">×</span>
	                            </span>	
	                     <?php }}?>                 									
       
                     </div>
                </div>
            </div>
        </div>
        <div class="btnBoix">
        	<input type="hidden" name="line_id" value="<?php echo $line['id']; ?>">
            <div class="Ybuoon"><input type="button" onclick="up_sales_expert()" value="确定"></div>
            <div class="Nbuoon" onclick="t33_close_iframe_noreload();"><input type="button" value="取消"></div>
        </div>
        </form>
    </div> --> 

    <!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
    
              
        <!-- =========================== -->
        <div class="order_detail_d" style="margin: auto 3px;">
          <form action="" id="salesExpertForm">
            <!-- ===============基础信息============ -->
            <div class="content_part">
                 <div class="small_title_txt clear">
                    <span class="txt_info fl"></span>
                 </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">       
                    <tr height="40">
                        <td class="order_info_title">产品编号:</td>
                        <td ><?php  if(!empty($line['linecode'])){ echo $line['linecode'];} ?></td>

                    </tr>
                    <tr height="40">
                        <td class="order_info_title">产品名称:</td>
                        <td><?php  if(!empty($line['linename'])){ echo $line['linename'];} ?></td>

                    </tr>
                    <tr height="40">
                        <td class="order_info_title">管家:</td>
                        <td><input type="text" id="expertList" name="expertList" onfocus="show_expertList(this);" style="height:20px;" >
                        <input type="hidden" id="expertData" name="expertData"  >
                        </td>

                    </tr>
                    <tr height="auto">
                    	<td class="order_info_title">售卖管家:</td>
                        <td>
                              <div id="ds-list" style="width:590px;float:left;margin:0px 0px 4px 8px;"> 
		                     <?php if(!empty($expert)){
		                         foreach ($expert as $k=>$v){
		                     ?>
		                     	<span class="selectedContent" value="<?php echo $v['expert_id']; ?>">
		                            	<?php echo $v['realname']; ?><input name="expertId[]" value="<?php echo $v['expert_id']; ?>" type="hidden">
		                            	<span class="delPlugin" onclick="delPlugin(this ,'' ,'ds-list');">×</span>
		                            </span>	
		                     <?php }}?>                 									
	       
	                       </div>
                        </td>
                        
                    </tr>


                </table>
                <div style="margin-top:30px;">
                    <input type="hidden" name="line_id" value="<?php echo $line['id']; ?>">
                    <input type="button" value="确认" class="btn btn_blue" id="confirm_order_btn" style="margin-left:210px;"  onclick="up_sales_expert()" >
                    <input type="button"  value="关闭" class="layui-layer-close btn btn_blue" onclick="t33_close_iframe_noreload();" style="margin-left:80px;"  > 
    
                </div>
            </div>
             </form>
       
           
        </div>
	</div>
	
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script src="<?php echo base_url() ;?>assets/js/admin/pinyin.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>

<?php $this->load->view("admin/common/expert_tree_view"); //加载树形营业部   ?>
<script>

function callbackTree(data_id,v,data){
	//选目的地
	$('#expertList').val('');
	var s = true;
	jQuery("input[name='expertId[]']").each(function(i){
	     expertid=jQuery(this).val();
	     if(expertid==data_id){ 
		    s = false
		 } 	 
	});
	if (s == false) {
		 alert('已选择');
		return false;
	} 
	var valId="expertData";
	var buttonId="ds-list";
	var html = '<span class="selectedContent" value="'+data_id+'">'+data.realname+'<input type="hidden" name="expertId[]" value="'+data_id+'"><span onclick="delPlugin(this ,\''+valId+'\' ,\''+buttonId+'\');" class="delPlugin">×</span></span>';
	$('#ds-list').append(html);
	$('#ds-list').css('display','block');
		
}

function delPlugin(obj ,valId ,buttonId) {
	var valObj = $("#"+valId);
	var buttonObj = $("#"+buttonId);
	var id = $(obj).parent("span").attr("value");
	var ids = valObj.val();

	$(obj).parent("span").remove();
	if (buttonObj.children("span").length == 0) {
		buttonObj.html('');
		buttonObj.hide();
	}
}

//up_sales_expert 设置售卖管家
function up_sales_expert(){
	//$('#salesExpertForm').find('input[name="s_lineId"]').val();
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#salesExpertForm').serialize(),url : "<?php echo base_url()?>admin/a/sale/line/save_lineExpert", 
		success : function(response) {
			var obj = eval('(' + response + ')');
			if(obj.status==1){
				 layer.msg(obj.msg, {icon: 1});
				 //$('.search_button').click();
			}else{
				 layer.msg(obj.msg, {icon: 2});
			}
		}
	 });
}
</script>
</body>
</html>

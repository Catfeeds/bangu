<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}

.bank{width:400px;height:300px;border:1px solid #ddd;padding:0px 20px;float:left;margin:0 20px;}
.bank p{height:32px;line-height:32px;margin:20px auto;}


.bank_div{width:476px;height:226px;border:1px solid #F1F2F2;margin:3% 0 0 10%;-moz-border-radius: 5px;     
    -webkit-border-radius: 5px;   
    border-radius:5px;       }
.bank_div .part1{height:66px;line-height:66px;width:100%;float:left;background:#70C1ED;-moz-border-radius: 5px;     
    -webkit-border-radius: 5px;   
    border-radius:5px;color:#fff;font-size:18px; padding:5px;}
.bank_div .part1 font{color:#fff;font-size:14px;float:right;margin-top:10px;margin-right:4%;}


.bank_div .part2{width:100%;float:left;margin-top:5%;}
.bank_div .part2 .p1{width:12%;float:left;padding:8px;background:#70C1ED;margin-left:5%;text-align:center;color:#fff;} 
.bank_div .part2 .p2{width:60%;float:left;padding:8px;margin-left:10%;font-size:14px;letter-spacing:1px;} 

</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>旅行社设置</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">银行账户设置</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray" style="float:left;width:100%;">      
            
            <!-- tab切换表格 -->
            <div class="table_content" style="float:left;width:100%;">
                <div class="itab">
                    <ul> 
                        <li static="1" data-id="1"><a href="#tab1" class="active">个体账户设置</a></li> 
                        <li static="1" data-id="2"><a href="#tab1">帮游银行帐户</a></li> 
      
                    </ul>
                </div>
                <div class="tab_content" id="union_bank" style="float:left;width:100%;min-height:680px;">
                    <div class="table_list">
                       <div class="fb-form" style="width:500px;margin-left:10%;margin-top:3%;">
				        <form method="post" action="#" id="add-data" class="form-horizontal">
				           <input type="hidden" id="depart_id" class="showorder" name="showorder">
				           <div class="form-group">
				                <div class="fg-title" style="width:18%;">银行名称：</div>
				                <input type="hidden" id="update_id" class="showorder" value="<?php echo isset($union_bank['id'])==true?$union_bank['id']:'';?>">
				                <div class="fg-input" style="width:77%;"><input type="text" id="bankname" class="showorder" value="<?php echo isset($union_bank['bankname'])==true?$union_bank['bankname']:'';?>"></div>
				            </div>
				            <div class="form-group">
				                <div class="fg-title" style="width:18%;">支行：</div>
				                <div class="fg-input" style="width:77%;"><input type="text" id="branch" class="showorder" value="<?php echo isset($union_bank['branch'])==true?$union_bank['branch']:'';?>"></div>
				            </div>
				            <div class="form-group">
				                <div class="fg-title" style="width:18%;">银行卡号：</div>
				                <div class="fg-input" style="width:77%;"><input type="text" id="bankcard" class="showorder" value="<?php echo isset($union_bank['bankcard'])==true?$union_bank['bankcard']:'';?>"></div>
				            </div>
				            <div class="form-group">
				                <div class="fg-title" style="width:18%;">开户人：</div>
				                <div class="fg-input" style="width:77%;"> <input type="text" id="cardholder" class="showorder" value="<?php echo isset($union_bank['cardholder'])==true?$union_bank['cardholder']:'';?>"</div>
				            </div>
				            </div>
				            <div class="form-group" style="margin-top:50px !important;">
				             <input type="button" class="fg-but layui-layer-close btn_edit_bank" value="保存修改" style="margin-right:30%;width:84px;">
				            </div>
				           
				            <div class="clear"></div>
				        </form>
				    </div>
                     
                    </div>                   
                </div>
                </div>
                <div class="tab_content" id="bangu_bank" style="display:none;float:left;width:100%;min-height:680px;">
                    <div class="table_list">
                        <div class="bank_div">
                            <div class="part1"><?php echo isset($bangu_bank['bankname'])==true?$bangu_bank['bankname']:'';?>  <font>支行：<?php echo isset($bangu_bank['branch'])==true?$bangu_bank['branch']:'';?></font></div>
                            <div class="part2"><p class="p1">卡号</p><p class="p2"><?php echo isset($bangu_bank['bankcard'])==true?$bangu_bank['bankcard']:'';?></p></div>
                            <div class="part2"><p class="p1">开户人</p><p class="p2"><?php echo isset($bangu_bank['cardholder'])==true?$bangu_bank['cardholder']:'';?></p></div>
                        </div>
                       

				    </div>
                      
                    </div>                   
                </div>
                
            </div>

        </div>
        
    </div>
   
 

<script type="text/javascript">
//js对象
var object = object || {};
var ajax_data={};
object = {
    send_ajax_noload:function(url,data){  //发送ajax请求，无加载层
  	      //没有加载效果
          var ret;
    	  $.ajax({
        	 url:url,
        	 type:"POST",
             data:data,
             async:false,
             dataType:"json",
             success:function(data){
            	 ret=data;
            	
             },
             error:function(){
            	 ret=data;
             }
                     
        	});
      	    return ret;

  }
  //object  end
};
$(document).ready(function(){


	//保存修改
	$(".btn_edit_bank").click(function(){

		var id=$("#update_id").val();
		var bankname=$("#bankname").val();
		var branch=$("#branch").val();
		var bankcard=$("#bankcard").val();
		var cardholder=$("#cardholder").val();
		var url="<?php echo base_url('admin/t33/sys/union/api_edit_bank')?>";
		var data={id:id,bankname:bankname,branch:branch,bankcard:bankcard,cardholder:cardholder};
		var return_data=object.send_ajax_noload(url,data);
		if(return_data.code=="2000")
		{
			tan2(return_data.data);
			t33_refresh();
		}
		else
		{
			tan(return_data.msg);
		}
    })
	//tab切换
	$(".itab ul li").click(function()
    {
     var value=$(this).attr("data-id");
     
     if(value==1)
     {
         $("#bangu_bank").hide();
         $("#union_bank").show();
     }
     else if(value==2)
     {
    	
    	 $("#bangu_bank").css("display","block");
         $("#union_bank").css("display","none");
     }
		 
   })
		
	
})

</script>
</html>



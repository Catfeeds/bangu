<html>
<head>
<meta charset="utf-8"  />
<title>申请预付款</title>
<link href="/assets/css/style.css" rel="stylesheet">
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<style type="text/css">
 .button_list{
      background: rgb(255, 255, 255) none repeat scroll 0% 0%;
      border: 1px solid rgb(204, 204, 204);
      padding: 3px;
      border-radius: 3px;
      cursor: pointer;
 } 
.form-horizontal .form-group .fg-title{
      width:85px;
 }
 .form-horizontal .form-group .fg-input{
       width:150px;
 }
 #account_list{
    width: 95%;
    margin-left: 16px;
 }
 #choose_order tr td:first-child { position:relative;}
 .pay_div>div { margin-bottom: 10px;}
 .pay_span{ display:inline-block;width: 100px;text-align: right;}
 .pay_input { padding:3px;margin-left: 3px;}
</style>

</head>
<body>
	
    <div class="page-body w_1200" id="bodyMsg">

        <div class="current_page">您的位置：
            <a href="#" class="main_page_link"><i></i>供应商后台</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">申请预付款</a>
        </div>
        
        <div class="order_detail">
            <h2 class="lineName headline_txt">申请团队预付款</h2>
        
           <div class="content_part">
                   <div class="small_title_txt clear">
                       <span class="txt_info fl">申请团队预付款</span>
                   </div>
                    <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">

                      <tr height="40">
                           <td class="order_info_title">产品名称:</td>
                           <td>
                                  <?php if(!empty($order['productname'])){ echo $order['productname'] ;} ?>
                           </td>
                          <td class="order_info_title">出团日期</td>
                           <td>
                             <?php if(!empty($order['usedate'])){ echo $order['usedate'] ;} ?>
                           </td>
                       </tr>


                   </table>
           </div>

           <div class="content_part">
                <form class="form-horizontal bv-form" method="post" id="batchForm" >
                <div id="item-list">

                    <table class="table table-bordered table_hover">
                            <thead class="">
                                      <tr>
                                            <th style="width:40px;text-align:center;"><input type="checkbox" id="checkAll" style="left:5px;opacity: 1;"/></th>
                                            <th style="width:40px;text-align:center;"></th>
                                            <th style="width:100px;text-align:center;">申请金额</th>

                                            <th style="width:80px;text-align:center;">订单号</th>
                                            <th style="width:100px;text-align:center;">出团日期</th>
                                            <th style="width:90px;text-align:center;">结算金额</th>
                                             <th style="width:90px;text-align:center;">结算申请中</th>
                                            <th style="width:90px;text-align:center;">已结算</th>
                                            <th style="width:70px;text-align:center;">操作费</th>
                                            <th style="width:90px;text-align:center;">未结算</th>
            
                                            <th style="width:150px;text-align:center;">团号</th>
                                            <th style="width:90px;text-align:center;">营业部</th>
                                            <th style="width:80px;text-align:center;">销售</th>
                                            <th style="width:80px;text-align:center;">申请状态</th>
                                      </tr>
                            </thead>
                            <tbody class="" id="choose_order">
                                 <?php  if(!empty($payable)){
                                    foreach ($payable as $key => $value) {
                                  ?>
                                     <tr>

                                       <td>
                                              <?php if($value['billy_id']>0){ ?>
                                                     <div class="title_info"style="position:absolute;width:100%;height:20px;line-height:30px;top:0px;left:0;cursor:pointer;z-index:9999;">
                                                     <img class="title_img" src="/assets/img/u224.png" style="width:16px;height:16px;position:relative;top:2px;"></div>
                                             <?php   }else{ 
                                                       //  if($value['balance_status']==2){
                                              
                                                        // }else{  

                                                        if($value['sk_money']>0 || $value['sk_money']<0){  
                                              ?> 
                                                          <input  onclick="check_order_id(<?php echo $key ?>,<?php echo $value['supplier_cost']; ?>,<?php echo  $value['platform_fee']; ?>)" name="order[<?php echo $key ?>]" type="checkbox" style="margin-left:5px;" value="<?php  echo $value['order_id'];?>" />
                                                          <input  type="hidden"  name="unionID[<?php echo $key ?>]" value="<?php echo $value['union_id']; ?>"/>
                                                          <input  type="hidden"  name="p_id[<?php echo $key ?>]" value="<?php echo $value['a_money']; ?>"/>
                                                          <input  type="hidden"  name="su_id[<?php echo $key ?>]" value="<?php echo $value['supplier_cost']; ?>"/>
                                                          <input  type="hidden"  name="pla[<?php echo $key ?>]" value="<?php echo $value['platform_fee']; ?>"/>
                                                           <input  type="hidden"  name="a_m[<?php echo $key ?>]" value="<?php echo $value['sk_money']; ?>"/>
                                                           <input  type="hidden"  name="ap_m[<?php echo $key ?>]" value="<?php  if(!empty($value['apply_money'])){
                                                                          echo $value['apply_money']-$value['applyMo'];
                                                            } ?>"/>
                                                           
                                                  <?php                 
                                                                 }
                                                      //   }
                                                } 
                                                ?>
                                       </td>
                                       <?php  if($value['is_apply']>0){?>
                                       <td><span style="font-size:17px;cursor: pointer;left:0;top:0;line-height:15px;text-align:center;display: inline-block;width: 100%;top: -3px;" onclick="show_payable(this,1);" data-id="<?php echo $value['order_id'];?>">+</span></td>
                                        <!--申请付款-->
                                        <?php }else{ ?>
                                        <td></td>
                                        <?php  }?>
                                       <td >

                                          <?php
                                                            if($value['billy_id']>0){

                                                            }else{
                                                                    //  if($value['balance_status']==2){  //申请中,已结算?>

                                                            <?php  //  }else{  //未结算

                                                                            if($value['sk_money']>0 || $value['sk_money']<0 ){  

                                                                            if($value['j_money']>=$value['supplier_cost']){   //1.已收金额>=结算金额
                                                                                    $value['apply_money'] =$value['apply_money']-$value['applyMo']-$value['platform_fee'];
                                                                              ?>

                                                                              <input type="text" name="apply_money[<?php echo $key ?>]" onBlur="check_apply_money(<?php echo $key ?>,<?php echo $value['apply_money'] ;?>)"  style="padding: 0px 4px;width: 100%;" value="<?php echo sprintf("%.2f",$value['apply_money']) ;?>" />
                                                             <?php
                                                                            }elseif($value['j_money']<$value['supplier_cost']){   //2.已收金额<结算金额

                                                                                 if($value['j_money']>=$value['balance_money']){ //已收金额>=已结算
                                                                                       $app_money=$value['j_money']-$value['balance_money']-$value['applyMo'];
                                                                  ?> 

                                                                              <input type="text" name="apply_money[<?php echo $key ?>]" onBlur="check_apply_money(<?php echo $key ?>,<?php echo $app_money ;?>)"  style="padding: 0px 4px;width: 100%;" value="<?php echo sprintf("%.2f",$app_money) ;?>" />

                                                                 <?php
                                                                              }elseif($value['j_money']<$value['balance_money']){ //已收金额<已结算
                                                                                ?>
                                                                                              <input type="text" name="apply_money[<?php echo $key ?>]" onBlur="check_apply_money(<?php echo $key ?>,0)"  style="padding: 0px 4px;width: 100%;" value="0" />
                                                                  <?php
                                                                              }                                                                                                                                       
                                                            
                                                                            }else{

                                                                            }
      
                                                                          }

                                                                 //     }
                                                            }
                                                   ?>
                                       </td>

                                       <td style="text-align:center;" ><?php echo $value['ordersn'] ?></td>
                                       <td style="text-align:center;" ><?php echo $value['usedate'] ?></td>
                                     
                                       <td style="text-align:right;" >
                                             <?php    echo $value['supplier_cost'];  ?>                 
                                       </td>
                                        <td  style="text-align:right;" ><?php echo $value['a_balance'] ?></td>
                                       <td  style="text-align:right;" ><?php echo $value['balance_money'] ?></td>
                                       <td style="text-align:right;" ><?php echo $value['platform_fee'] ?></td>
                                       <td  style="text-align:right;" ><?php echo $value['un_balance'] ?></td>

                                        <td style="text-align:center;"  ><?php echo $value['linesn'] ?></td>
                                       <td style="text-align:center;" ><?php echo $value['depart_name'] ?></td>
                                       <td style="text-align:center;" ><?php echo $value['realname'] ?></td>
                                      
                                       <td style="text-align:center;" >
                                       		<?php if($value['balance_status']==0){
                                                           echo '未结算';
                                                }elseif($value['balance_status']==1){
                                                            echo '申请中';
                                                }elseif ($value['balance_status']==2) {
                                                            echo '已结算';
                                                }
                                              ?>
                                       </td>
                                     </tr>
                                <?php } }?>
                            </tbody>
                     </table>
                  
                </div>


                  <div style="margin:30px 0 10px;">
                        <div><lable class="pay_span">申请总金额：</lable><span class="all_account">0</span></div>
                        </div>
                        <div  class="pay_div clear" >
                          <div class="fl" style="width:100%;">
                            <lable class="pay_span">收款单位：</lable>
                            <div style="width: 300px;display: inline-block;"><?php if(!empty($company_name)){ echo $company_name;} ?></div>
                            <lable class="pay_span">付款方式：</lable>
                            <select name="pay_way" id="pay_way"  class="pay_input " style="margin-left:5px;width:60px;padding:0;">

                              <option value="1">转账</option>
                            </select>
                          </div>
                          <div class="fl" style="width:100%;">
                            <lable class="pay_span">银行名称+支行：</lable>
                            <input type="text" name="p_bankname" class="pay_input w_300" value="<?php if(!empty($bank)){ echo $bank['bankname'].$bank['brand'];} ?>">
                            <lable class="pay_span">开户公司：</lable>
                            <input type="text" name="p_bankcompany" value="<?php if(!empty($bank)){ echo $bank['openman'];} ?>" class="pay_input w_300" >
                            
                          </div>
                          <div class="fl" style="width:100%;">
                          	<lable class="pay_span">银行卡号：</lable>
                            <input type="text" name=" p_bankcard" value="<?php if(!empty($bank)){ echo $bank['bank'];} ?>"class="pay_input w_300" size="25">
                          </div>
                          <div class="fl" style="width:100%;">
                            <lable class="pay_span"> 申请备注：</lable>
                            <input type="text" name="p_remark" class="pay_input" size="100" style="width:711px;">
                            
                          </div>
                            <div style="margin:20px 300px;float:left;"><input type="button" value="提交申请" class="btn btn_green" id="batchData"  ></div>    
                          </div>

           </form>
            </div>

        </div>
	</div>
<!--未结算end-->

<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<!--分页数据-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />

<script>

</script>
</body>
</html>
<script type="text/javascript">

//申请付款
function submit_apply(){
          $.post("/admin/b1/apply/apply_order/add_apply_money",$('#apply_from').serialize(),function(data){
                     data = eval('('+data+')');
                     if(data.status==1){
                      alert(data.msg);
                      $('.opp_colse,.bc_close').click();
                       jQuery('#tab1').click();
                     }else{
                      alert(data.msg);  
                     }    
              })
          return false;
}
$('.opp_colse,.bc_close').click(function(){
        $('.eject_body').hide();
        $('.modal-backdrop').hide();  
        $('.batch_settlement_body').hide();
})

$(document).on('mouseover', '.title_info', function(){  
          var html='';
          html=html+'<div class="info_txt" id="info_txt" style="width:340px;text-align:left;border:1px solid #aaa;background:#fff;z-index:999;position:absolute;left:60px;top:0;display:none;">';
          html=html+'<p style="color: red;">销售人员因客户需求,订单的出游人数或成本价有变化,请尽快去订单管理确认"订单修改"</p></div>';     
          $('.title_info').append(html);
          $(this).find(".info_txt").show();
});
$(document).on('mouseout', '.title_info', function(){
           $(this).find(".info_txt").remove();
});

 $(function() {
       $("#checkAll").click(function() {  //全选
             var all_money=parseFloat(0);
             var union_id=0;
             var len=$('#choose_order').find('tr').length;
                      
             for (var j=0; j <=len; j++) {
                  var unionid=$('input[name="unionID['+j+']"]').val();
                  if(unionid!=undefined){
                        union_id=unionid;
                        break;
                  }
             }
                      //alert(union_id);

             for (var i =0; i <=len; i++) {
                  var union_data=$('input[name="unionID['+i+']"]').val();
                  if(union_data!=undefined){
                        if(union_id==union_data){  //需选择同一个旅行社
                               $('input[name="order['+i+']"]').attr("checked",this.checked); 
                               if(this.checked==true){
                                     var money=$('input[name="apply_money['+i+']"]').val();
                                     if(money!=undefined && money!=''){
                                            var b_money=$('input[name="p_id['+i+']"]').val();  
                                            var ap_m=$('input[name="ap_m['+i+']"]').val();  //未结算金额(未减平台佣金)
                                            var  pla=$('input[name="pla['+i+']"]').val(); //平台佣金
                                            b_money=parseFloat(ap_m)-parseFloat(pla);
                                            if(parseFloat(money)>=parseFloat(b_money)){  //申请金额>结算金额-平台管理费
                                                  money=b_money;
                                                  $('input[name="apply_money['+i+']"]').val(b_money.toFixed(2));
                                            }else{
                                                  var a_m=$('input[name="a_m['+i+']"]').val();    //已交款的金额
                                                  if(parseFloat(a_m)>parseFloat(b_money)){   //判断是否已交全款>=结算价
                                                       if(ap_m==money){  
                                                             money=parseFloat(money)-parseFloat(pla); 
                                                             money=money.toFixed(2);  
                                                             $('input[name="apply_money['+i+']"]').val(money); 
                                                        }
                                                   }     
                                             }

                                             all_money=parseFloat(all_money)+parseFloat(money);
                                      }else{
                                                               			           			
                    		           		$('input[name="order['+i+']"]').attr("checked",false); 
                                      }
                               }
                         }else{
                               $('input[type="checkbox"]').attr("checked",false); 
                               alert('请选择同一个旅行社');
                               all_money=0;
                               return false;
                         }
                  } 
            };  
            all_money=all_money.toFixed(2);
            $('.all_account').html(all_money);   
      });
      
 });

function check_order_id(i,supplier_cost,platform_fee){  //单选
            var union_id=0;
            var len=$('#choose_order').find('tr').length;

            for (var j=0; j <=len; j++) {
                  var re=$('input[name="order['+j+']"]').attr("checked"); 
                  if(re=='checked'){ 
                      if(i!=j){
                              var unionid=$('input[name="unionID['+j+']"]').val();
                              union_id=unionid;
                              break;  
                      }                 
                  }
             }
             var unionID=$('input[name="unionID['+i+']"]').val(); 
             if(union_id!=0){
                    if(union_id!=unionID){
                          $('input[name="order['+i+']"]').attr("checked",false); 
                          layer.msg('请选择同一个旅行社', {icon: 2});
                          return false;
                    }
             }

            var value=$('input[name="apply_money['+i+']"]').val(); 
            if(isNaN(value)){
                  layer.msg('填写格式出错', {icon: 2});
                  $('input[name="apply_money['+i+']"]').val('');
                  return false
            }else if(value==''){
            	 var b=$('input[name="order['+i+']"]').attr("checked");
            	 if(b=="checked"){
            		 layer.msg('勾选的申请的金额不能为空', {icon: 2});
    				 $('input[name="apply_money['+i+']"]').val('');
    				 $('input[name="order['+i+']"]').attr("checked",false); 
    				 return false
                 }
			}
            var all_money=0;
            for (var a =0; a<=len; a++) {
                 var check=$('input[name="order['+a+']"]').attr("checked"); 
                 if(check=='checked'){
                     var money=$('input[name="apply_money['+a+']"]').val();
                     if(money!=undefined && money!=''){
                          var  b_money=$('input[name="p_id['+a+']"]').val();  //结算价
                          var  ap_m=$('input[name="ap_m['+a+']"]').val();  //未结算金额(未减平台佣金)
                          var  pla=$('input[name="pla['+a+']"]').val();  //平台佣金
                          b_money=parseFloat(ap_m)-parseFloat(pla);
                          if(parseFloat(money)>=parseFloat(b_money)){  //申请金额>结算金额-平台管理费-正在申请
                                money=b_money;
                                $('input[name="apply_money['+a+']"]').val(b_money.toFixed(2));
                          }else{
                              a_m=$('input[name="a_m['+a+']"]').val();    //已交款的金额
                              if(parseFloat(a_m)>parseFloat(b_money)){   //判断是否已交全款>=结算价
                                    if(ap_m==money){  
                                         money=parseFloat(money)-parseFloat(pla);
                                         money=money.toFixed(2);    
                                          $('input[name="apply_money['+a+']"]').val(money); 
                                    }
                               }             
                          }

                          all_money=parseFloat(all_money)+parseFloat(money);
                      }
                  }
            };  

            all_money=all_money.toFixed(2);
            $('.all_account').html(all_money);
};
       function check_apply_money(a,a_money){ //申请金额变化
              var len=$('#choose_order').find('tr').length;

              var c_money=$('input[name="apply_money['+a+']"]').val();
              if(c_money=='0' || c_money=='0.00'){
                    return false;
              }
              if(c_money==''){
            	  var b=$('input[name="order['+a+']"]').attr("checked");
	           	  if(b=="checked"){
	                    layer.msg('勾选的申请金额不能为空', {icon: 2});
	                    $('input[name="apply_money['+a+']"]').focus();
	                    return false;
	           	   }
              }
               if(isNaN(c_money)){
	                  layer.msg('填写格式不对', {icon: 2});
	                  $('input[name="apply_money['+a+']"]').val('');
	                  $('input[name="apply_money['+a+']"]').focus();
	                  return false;
                }

              if(c_money>a_money){
                   layer.msg('申请的金额不能大于已交款的金额', {icon: 2});
                   $('input[name="apply_money['+a+']"]').val(a_money);
                   $('input[name="money_list['+a+']"]').val(100); 
                   return false;
              }
     /*         if(c_money<0){
                         alert('申请的金额不能大于0');
                        $('input[name="apply_money['+a+']"]').val(0);
                        $('input[name="money_list['+a+']"]').val(0); 
                        return false;
              }*/
              var indata=parseFloat(c_money)/parseFloat(a_money)*100;
              indata=indata.toFixed(2);
              $('input[name="money_list['+a+']"]').val(indata); //改变比例

              var all_money=parseFloat(0);

              for (var i =0; i <=len; i++) {  //重新遍历,计算中金额
                    var check=$('input[name="order['+i+']"]').attr("checked"); 
                    if(check=='checked'){
                         var money=$('input[name="apply_money['+i+']"]').val();
                         if(isNaN(money)){
                              layer.msg('填写格式出错', {icon: 2});
                              $('input[name="apply_money['+i+']"]').val('');
                              return false
                         }

                         if(money!=undefined){
                                all_money=parseFloat(all_money)+parseFloat(money);
                         }
                    }
              };  
              all_money=all_money.toFixed(2);
              $('.all_account').html(all_money); 
        }
             //申请金额比例
  function check_money_list(a,a_money){
        var len=$('#choose_order').find('tr').length;
        var list=$('input[name="money_list['+a+']"]').val(); 
        if(list==''){
               alert('申请金额比例不能为零');
               $('input[name="money_list['+a+']"]').focus();
               return false;
        }
        if(isNaN(list)){
              alert('填写格式不对');
              $('input[name="money_list['+a+']"]').val('');
              $('input[name="money_list['+a+']"]').focus();
              return false;
        }else{
              if(list >100){
                    alert('不能大于100%');
                    $('input[name="money_list['+a+']"]').val('');
                    $('input[name="money_list['+a+']"]').focus();
                    return false;
              }else if(list <0 ){
                    alert('不能低于0');
                    $('input[name="money_list['+a+']"]').val('');
                    $('input[name="money_list['+a+']"]').focus();
                    return false;
              }
         }
                         
     	a_money =$('input[name="apply_money['+a+']"]').val(); 
    	var data=parseFloat(a_money)*parseFloat(list)*parseFloat(0.01);
    	data=data.toFixed(2);
    	$('input[name="apply_money['+a+']"]').val(data);

        var all_money=parseFloat(0);
        for (var i =0; i <=len; i++) {  //重新遍历,计算中金额
                var check=$('input[name="order['+i+']"]').attr("checked"); 
                if(check=='checked'){
                     var money=$('input[name="apply_money['+i+']"]').val();
                     if(money!=undefined){
                          all_money=parseFloat(all_money)+parseFloat(money);
                     }
                }
        };  
        all_money=all_money.toFixed(2);
        $('.all_account').html(all_money); 
  }


 //批量申请
jQuery('#batchData').click(function(){

  $.post("/admin/b1/apply/apply_order/p_payable_apply",$('#batchForm').serialize(),function(data){
              data = eval('('+data+')');
               if(data.status==1){
                    alert(data.msg);
                    $('input[name="p_remark"]').val('');
                    $('.opp_colse,.bc_close').click();
               //   jQuery('#tab0').click();  
                     window.location.reload(); 
               }else{
                     alert(data.msg);
               }
  })
});

//保存批量申请的结算单
function submit_p_apply(){
      $.post("/admin/b1/apply/apply_order/p_payable_apply",$('#p_apply_from').serialize(),function(data){
                 data = eval('('+data+')');
                 if(data.status==1){
                        $('input[name="p_remark"]').val('');
                        alert(data.msg);
                        $('.opp_colse,.bc_close').click();
                        window.location.reload();
                //    jQuery('#tab0').click();   
                 }else{
                       alert(data.msg);
                 }
      })
}



//展开申请记录
function show_payable(obj,type){
  if(type==1){
    var orderid = $(obj).attr("data-id");
        $.post("<?php echo base_url()?>admin/b1/apply/apply_order/get_order_payable_list", { orderid:orderid} , function(result) {
                   var result =eval("("+result+")"); 
                     if(result.status==1){ 
                            var html = '<tr class="order_table"><td colspan="14" style="padding:0;"><div style="padding:5px 5px 5px 30px;"><table class="table table-bordered" style="width:1000px">';
                             html+='<thead class="th-border"><tr>';
                             html+='<th>审核状态</th>';
                             html+='<th>申请金额</th>';
                             html+='<th>订单号</th>';
                             html+='<th>销售&部门</th>';
                             html+='<th>出团日期</th>';
                             html+='<th>结算总价</th>';
                             html+='<th>已结算</th>';
                             html+='<th>操作费</th>';
                             html+='<th>未结算</th>';
                             html+='<th>团号</th>';
//                             html+='<th>佣金</th>'; 
                             html+='</tr></thead><tbody>';
                        if(result.data!=''){
  
                            $.each(result.data, function(key,val) {   
                            var apply=""; 
                                    if(val.status==0){
                                         apply="申请中";
                                    }else if(val.status==1){
                                        apply="申请中";
                                    }else if(val.status==2){
                                        apply="已通过";
                                    }else if(val.status==3){
                                        apply="已拒绝";
                                    }else if(val.status==4){
                                        apply="已付款";
                                    }else if(val.status==5){
                                        apply="已拒绝";
                                    }    
       
                                    html+='<tr>';
                                    html+='<td>'+apply+'</td>';
                                    html+='<td>'+val.amount_apply+'</td>';
                                    html+='<td>'+val.ordersn+'</td>';
                                    html+='<td>'+val.realname+'&'+val.depart_name+'</td>';
                                    html+='<td>'+val.usedate+'</td>';
                                    html+='<td>'+val.supplier_cost+'</td>';
                                    html+='<td>'+val.balance_money+'</td>';
                                    html+='<td>'+val.platform_fee+'</td>';
                                    html+='<td>'+val.un_balance+'</td>';
                                    html+='<td>'+val.item_code+'</td>'; 
//                                  html+='<td>'+val.platform_fee+'</td>';     
                                    html+='</tr>';
                            });
		      }else{
		         html+='<tr>';
		         html+='<td colspan="13" style="letter-spacing:10px"><span style="font-weight: bold;color: red;">暂无申请记录数据</span></td>';
		         html+='</tr>';
		      }

    		  html+='</tbody></table></div></td></tr>';
              $(obj).parent().parent().after(html);
              $(obj).html("-").attr("onclick","show_payable(this,2);");
	    }else{
	
	    }
           });  

      }else{
            $(obj).html("+").attr("onclick","show_payable(this,1);");
            $(obj).parent().parent().next().remove();
      }
}
</script>
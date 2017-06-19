  <!--成本价步骤的显示-->
    <div class="fb-content" id="order_yf_step" style="display:none;" >
    <div class="box-title">
        <h4 class="h_order_data">流程</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" id="order_yf_table" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
   <!--                 <tr height="40"  class="tongguo">
     <td style="width:40px;"><i></i></td>
                             <td>营业部申请</td>
                         </tr>
                         <tr height="40" class="shenhe" >
                            <td style="width:40px;" ><i></i></td>
                             <td>等待供应商审核</td>
                         </tr> -->

                </table>
            </div>
            <div class="form_btn clear"  style="margin: 20px 0 20px 0;">
                  <input type="hidden" id="p_bill_id" name="p_bill_id">
                  <!--提交给旅行社审核-->

                  <input type="button" value="关闭" class="btn btn_blue layui-layer-close " id="ref_order_btn" style="margin-left:295px;  position: inherit;"  >
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

//成本操作步骤
function show_order_yf(id){

	if(id){
		 $.post("<?php echo base_url();?>admin/orderStep/order_yf", 
                {
                     'yf_id':id,                       
                },
                function(result){ 
                     var result =eval("("+result+")"); 
                      if(result.status==1){ 
                         
                           if(result.data.status==1){  //申请中
                                  if(result.data.user_type==2){  // 供应商发起
                                        
                                     var str='<tr height="40"  class="tongguo">';
                                     str=str+' <td style="width:40px;"><i></i></td>';
                                     str=str+'<td>供应商申请</td></tr>';
                                     str=str+'<tr height="40" class="shenhe" >';
                                     str=str+'<td style="width:40px;" ><i></i></td>';
                                     str=str+' <td>等待营业部审核</td></tr>';
                
                                     $('#order_yf_table').html(str);
                      
                                  }else{  //管家发起的

                                      if(result.data.re_status==0){
                                              var str='<tr height="40"  class="tongguo">';
                                               str=str+' <td style="width:40px;"><i></i></td>';
                                               str=str+'<td>营业部申请</td></tr>';
                                               str=str+'<tr height="40" class="tongguo" >';
                                               str=str+'<td style="width:40px;" ><i></i></td>';
                                               str=str+' <td>等待供应商审核</td></tr>';
                                               str=str+'<tr height="40" class="shenhe" >';
                                               str=str+'<td style="width:40px;" ><i></i></td>';
                                               str=str+' <td>等待旅行社退款</td></tr>';

                                      }else{
                                               var str='<tr height="40"  class="tongguo">';
                                               str=str+' <td style="width:40px;"><i></i></td>';
                                               str=str+'<td>营业部申请</td></tr>';
                                               str=str+'<tr height="40" class="shenhe" >';
                                               str=str+'<td style="width:40px;" ><i></i></td>';
                                               str=str+' <td>等待供应商审核</td></tr>';
                                      }

                                       $('#order_yf_table').html(str);
                                  }
                          }
                      }
               	}   
          );	
	}
          layer.open({
                  type: 1,
                  title: false,
                  closeBtn: 0,
                  area: '600px',
                  shadeClose: false,
                  content: $('#order_yf_step')
           });
}




</script>
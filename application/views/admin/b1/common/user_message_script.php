<!--录入人信息-->
  <div class="fb-content" id="b_user_list" style="display:none;margin-bottom:20px" >
    <div class="box-title">
        <h4>录入人信息</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
          <!-- ===============基础信息============ -->
            <div class="form_con">
               <!--供应商信息-->
                <table class="order_info_table supplier_table" border="1" width="100%" cellspacing="0" style="margin-top: 20px;display:none">
                    <tr height="40">
                        <td class="order_info_title"  >负责人姓名:</td>
                        <td  class="supplier_realname"></td>
                        <td class="order_info_title"  >负责人电话:</td>
                        <td class="supplier_mobile" ></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title"  >联系人姓名:</td>
                        <td  class="supplier_linkman"></td>
                        <td class="order_info_title"  >联系人电话:</td>
                        <td class="supplier_link_mobile" ></td>
                    </tr>

                    <tr height="40">
                        <td class="order_info_title">品牌:</td>
                        <td class="supplier_brand"></td>
                        <td class="order_info_title">所在地:</td>
                        <td class="supplier_address"></td>    
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">邮箱:</td>
                        <td class="supplier_email"></td>
                        <td class="order_info_title">固话:</td>
                        <td  class="supplier_telephone"></td>
                    </tr>
       <!--               <tr height="40">
          <td class="order_info_title">传真:</td>
          <td class="supplier_fax"></td>
          <td class="order_info_title">负责人证件:</td>
          <td class="supplier_idcardpic"><img src="" width="100" /></td>
                           </tr> -->
<!--                     <tr height="40">
     <td class="order_info_title">供应商类型:</td>
     <td class="supplier_kind"></td>
     <td class="order_info_title">经营许可证号:</td>
     <td  class="supplier_business_licence_code"></td>
 </tr>
 <tr height="40">
     <td class="order_info_title">法人代表姓名:</td>
     <td class="supplier_corp_name"></td>
     <td class="order_info_title">法人代表身份证:</td>
     <td class="supplier_corp_idcard"></td>
 </tr>
     
 <tr height="40">
   <td class="order_info_title">经营许可证:</td>
     <td class="supplier_licence_img_code"></td>
     <td class="order_info_title">营业执照:</td>
     <td class="supplier_licence_img"></td>
 </tr> -->
                </table>
                <!--管家信息-->
                 <!-- ===============基础信息============ -->
                 <table class="order_info_table expert_table" border="1" width="100%" cellspacing="0" style="display:none">
                    <tr height="40">
                        <td class="order_info_title">头像:</td>
                        <td class="expert_photo"><!-- <img src="" height="100" /> --></td>
                        <td class="order_info_title">昵称:</td>
                        <td class="expert_nickname"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">姓名:</td>
                        <td class="expert_realname"></td>
                        <td class="order_info_title">手机号:</td>
                        <td class="expert_mobile"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">性别:</td>
                        <td  class="expert_sex"></td>
                        <td class="order_info_title">营业部:</td>
                        <td class="expert_depart_name" ></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">类型:</td>
                        <td class="expert_type"></td>
                        <td class="order_info_title">微信:</td>
                        <td class="expert_weixin"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">擅长线路:</td>
                        <td colspan="3" class="expert_dest"></td>
                    </tr>
                <!--     <tr height="40">
                    <td class="order_info_title">上门服务:</td>
                    <td class="expert_visit_service"></td>
                    <td class="order_info_title">所在地:</td>
                    <td class="expert_address"></td>
                </tr> -->
                  <!--    <tr height="40">
                     <td class="order_info_title">证件类型:</td>
                     <td class="expert_idcardtype"></td>
                     <td class="order_info_title">证件号:</td>
                     <td class="expert_idcard"></td>
                                      </tr>
                  <tr height="40">
                     <td class="order_info_title">证件照正面:</td>
                     <td class="expert_idcardpic"></td>
                     <td class="order_info_title">证件照反面:</td>
                     <td class="expert_idcardconpic"></td>
                     
                                      </tr> -->
<!--                     <tr height="40">
    <td class="order_info_title">个人描述:</td>
    <td colspan="3" class="expert_talk"></td>
</tr>
 <tr height="40">
    <td class="order_info_title">毕业学校:</td>
    <td class="expert_school"></td>
    <td class="order_info_title">从业:</td>
    <td class="expert_profession"></td>
</tr>
 <tr height="40">
    <td class="order_info_title">荣誉证书:</td>
    <td colspan="3">
         <div style="width:100%;height:auto;" class="expert_certificate">
       
        </div>
    </td>
</tr>
 <tr height="40">
    <td class="order_info_title">工作经历:</td>
    <td colspan="3">
         <div class="work_div">
            
          </div>
    </td>
</tr> -->
                </table>
                <!--平台管理员-->
                <table class="order_info_table admin_table" border="1" width="100%" cellspacing="0" style="margin-top: 20px;display:none">
                        <tr height="40">
                            <td class="order_info_title" >姓名:</td>
                            <td  class="admin_name" colspan="3"></td>
                        </tr>
                          <tr height="40">
                            <td class="order_info_title"  >手机:</td>
                            <td class="admin_mobile" colspan="3" ></td>
                        </tr>
                 </table>
                  <!--旅行社-->
                 <table class="order_info_table union_table" border="1" width="100%" cellspacing="0" style="margin-top: 20px;display:none">
                      <tr height="40">
                            <td class="order_info_title" >联盟单位名称:</td>
                            <td colspan="3"  class="union_name" ></td>
                      </tr>
                      <tr height="40">
                            <td class="order_info_title" >姓名:</td>
                            <td  class="union_linkman"  colspan="3" ></td>
                     </tr>
                     <tr height="40">
                            <td class="order_info_title" >手机:</td>
                            <td  class="union_linkmobile" colspan="3" ></td>
                     </tr>
                 </table>

            </div>
</div>
<script type="text/javascript">
            //用户信息
            function show_user(user_id,user_type){
                      $.post( "<?php echo site_url('admin/b1/order/show_user_message')?>", {'user_type':user_type,'user_id':user_id},
                           function(data) {
                                data = eval('('+data+')');
                               
                                layer.open({
                                    type: 1,
                                    title: false,
                                    closeBtn: 0,
                                    area: '800px',
                                    //skin: 'layui-layer-nobg', //没有背景色
                                    shadeClose: false,
                                    content: $('#b_user_list')
                                });

                                if(user_type==1){ //管家信息
                                      $('.expert_table').show();
                                      $('.supplier_table').hide();
                                      $('.admin_table').hide();
                                      $('.union_table').hide();
                                      //  基本信息
                                      if(data.user.sex==1){
                                            var sex='男';
                                      }else if (data.user.sex==2){
                                           var sex='女';
                                      }else{
                                           var sex='女';
                                      }
                                      if(data.user.expert_type==1){
                                              var expert_type='境内';
                                      }else {
                                              var expert_type='境外';
                                      }
                                      //经理
                                      var dm='';
                                      if(data.user.is_dm==1){
                                            dm='经理';
                                      }
                                      $('.expert_photo').html('<img src="'+data.user.small_photo+'" height="100" />');
                                      $('.expert_realname').html('营业部'+dm+'/'+data.user.realname);
                                      $('.expert_nickname').html(data.user.nickname);
                                      $('.expert_mobile').html(data.user.mobile);
                                      $('.expert_sex').html(sex);
                                      $('.expert_depart_name').html(data.user.depart_name);
                                      $('.expert_type').html(expert_type);
                                      $('.expert_weixin').html(data.user.weixin);
                                      $('.expert_idcardtype').html(data.user.idcardtype);
                                      $('.expert_idcard').html(data.user.idcard);
                                      $('.expert_idcardpic').html('<img src="'+data.user.idcardpic+'" height="100" />');
                                      $('.expert_idcardconpic').html('<img src="'+data.user.idcardconpic+'" height="100" />');
                                      $('.expert_talk').html(data.user.talk);
                                      $('.expert_school').html(data.user.school);
                                      $('.expert_profession').html(data.user.profession);
                                      $('.certificate').html(data.user.certificate);
                                      $('.certificate').html('<img src="'+data.user.certificatepic+'" height="100" />');
                                      $('.expert_work_time').html(data.user.working+'年'); 
                                      $('.expert_company_name').html(data.user.company_name); 
                                      $('.expert_job').html(data.user.job); 
                                      $('.expert_description').html(data.user.description); 
                                      $('.expert_dest').html('');
                                      $.each(data.dest, function(key, val) {      //擅长线路
                                           $('.expert_dest').append(val.name+'&nbsp;&nbsp;');          
                                      }); 
                                     $('.expert_visit_service').html('');
                                     $.each(data.service, function(key, val) {    //上门服务  
                                               $('.expert_visit_service').append(val.name+'&nbsp;&nbsp;');          
                                      }); 
                                     //管家从业简历
                                     $('.work_div').html('');
                                     $.each(data.expert_resume, function(key, val) {   
                                            var str='<p>工作时间：'+val.starttime+'至'+val.endtime+'</p>';
                                            str=str+'<p>所在企业：'+val.company_name+'</p>';
                                            str=str+'<p>职务：'+val.job+'</p>';
                                            str=str+'<p>工作内容：'+val.description+'</p>';
                                           $('.work_div').append(str);
                                     });
                                     //管家证书
                                     $('.expert_certificate').html('');
                                     $.each(data.expert_certificate, function(key, val) { 
                                          var string=''; 
                                          string=string+'<div style="width: 30%;float:left;line-height:100px;margin:2px auto;text-align:center;" class="certificate">';
                                          string=string+val.certificate+'</div>';
                                          string=string+' <div style="width: 60%;float:left;line-height:100px;margin:2px auto;text-align:center;"  class="certificatepic">';
                                          string=string+'<img src="'+val.certificatepic+'" height="100" />';
                                          string=string+'</div>';
                                          $('.expert_certificate').append(string);
                                     });
                                }else if(user_type==2){ //供应商
                                      $('.expert_table').hide();
                                      $('.supplier_table').show();
                                      $('.admin_table').hide();
                                      $('.union_table').hide();
                                       //基础信息 
                                     if(data.user.kind==1){
                                                var s_kind='境内企业';
                                      }else if(data.user.kind==2){
                                                var s_kind='境内个人';
                                      }else if(data.user.kind==3){
                                                var s_kind='境外企业';
                                      }else if(data.user.kind==4){
                                                var s_kind='境外个人';
                                      }
                                      $('.supplier_realname').html('供应商/'+data.user.realname);
                                      $('.supplier_mobile').html(data.user.mobile);
                                      $('.supplier_linkman').html(data.user.linkman);
                                      $('.supplier_link_mobile').html(data.user.link_mobile);
                                      $('.supplier_brand').html(data.user.brand);
                                      $('.supplier_address').html(data.user.address);
                                      $('.supplier_email').html(data.user.email);
                                      $('.supplier_telephone').html(data.user.telephone);
                                      $('.supplier_fax').html(data.user.fax);
                                      $('.supplier_idcardpic').html('<img src="'+data.user.idcardpic+'" height="100" />');
                                      $('.supplier_kind').html(s_kind);
                                      $('.supplier_business_licence_code').html(data.user.business_licence_code);
                                      $('.supplier_corp_name').html(data.user.corp_name);
                                      $('.supplier_corp_idcard').html(data.user.corp_idcard);
                                      $('.supplier_licence_img_code').html('<img src="'+data.user.licence_img_code+'" height="100" />');
                                      $('.supplier_licence_img').html('<img src="'+data.user.licence_img+'" height="100" />');

                                }else if(user_type==3){  //平台
                                          $('.expert_table').hide();
                                          $('.supplier_table').hide();
                                          $('.admin_table').show();
                                          $('.union_table').hide();
                                           $('.admin_name').html('平台/'+data.user.realname); 
                                           $('.admin_mobile').html(data.user.mobile);
                                }else if(user_type==4){
                                           $('.expert_table').hide();
                                           $('.supplier_table').hide();
                                           $('.admin_table').hide();
                                           $('.union_table').show();
                                           $('.union_name').html(data.user.union_name); 
                                           $('.union_linkman').html(data.user.linkman);
                                           $('.union_linkmobile').html(data.user.linkmobile);
                                }
                      });   
            }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试模板</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>


<style type="text/css">


.work_div{width:100%;height:auto;border-bottom:1px solid #D5D5D5;margin:10px 5px;}
.work_div p{height:28px;line-height:28px;overflow:hidden;}

</style>

</head>
<body>
	
    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
       
        
        <!-- ===============订单详情============ -->
        <div class="order_detail">
          
            <!-- ===============基础信息============ -->
            <div class="content_part">
               
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">头像:</td>
                        <td><img src="<?php echo BANGU_URL.$expert['small_photo'];?>" height="100" /></td>
                        <td class="order_info_title">昵称:</td>
                        <td><?php echo isset($expert['nickname'])==true?$expert['nickname']:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">姓名:</td>
                        <td><?php echo isset($expert['realname'])==true?$expert['realname']:""; ?></td>
                        <td class="order_info_title">手机号:</td>
                        <td><?php echo isset($expert['mobile'])==true?$expert['mobile']:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">性别:</td>
                        <td><?php if($expert['sex']=="1") echo "男";else if($expert['sex']=="0") echo "女";else echo "保密"; ?></td>
                        <td class="order_info_title">营业部:</td>
                        <td><?php echo isset($expert['depart_name'])==true?$expert['depart_name']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">类型:</td>
                        <td><?php if($expert['type']=="1") echo "境内";else echo "境外"; ?></td>
                        <td class="order_info_title">微信:</td>
                        <td><?php echo isset($expert['weixin'])==true?$expert['weixin']:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">擅长线路:</td>
                        <td colspan="3"><?php echo isset($expert['expert_dest_ch'])==true?$expert['expert_dest_ch']:""; ?></td>
                    </tr>
                    <tr height="40">
                    	<td class="order_info_title">上门服务:</td>
                        <td><?php echo isset($expert['visit_service_ch'])==true?$expert['visit_service_ch']:""; ?></td>
                        <td class="order_info_title">所在地:</td>
                        <td><?php echo $expert['province_name'].$expert['city_name']; ?></td>
                        
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">职位:</td>
                        <td><?php if($expert['is_dm']=="1") echo "经理";else echo "销售"; ?></td>
                        <td class="order_info_title">邮箱:</td>
                        <td><?php echo isset($expert['email'])==true?$expert['email']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">证件类型:</td>
                        <td><?php if(empty($expert['idcardtype'])) echo "身份证";else echo $expert['idcardtype_name']; ?></td>
                        <td class="order_info_title">证件号:</td>
                        <td><?php echo isset($expert['idcard'])==true?$expert['idcard']:""; ?></td>
                    </tr>
                     <tr height="40">
                    	<td class="order_info_title">证件照正面:</td>
                        <td><img src="<?php echo BANGU_URL.$expert['idcardpic'];?>" height="100" /></td>
                        <td class="order_info_title">证件照反面:</td>
                        <td><img src="<?php echo BANGU_URL.$expert['idcardconpic'];?>" height="100" /></td>
                        
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">个人描述:</td>
                        <td colspan="3"><?php echo isset($expert['talk'])==true?$expert['talk']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">毕业学校:</td>
                        <td><?php echo isset($expert['school'])==true?$expert['school']:""; ?></td>
                        <td class="order_info_title">从业:</td>
                        <td><?php echo isset($expert['profession'])==true?$expert['profession']:""; ?></td>
                    </tr>
                    <?php if($expert['type']=="1"):?>
                     <tr height="40">
                        <td class="order_info_title">荣誉证书:</td>
                        <td colspan="3">
                          <?php if(!empty($expert_cert)): ?>
                            <?php foreach ($expert_cert as $a=>$b):?>
                            <div style="width:100%;height:auto;">
                               <div style="width: 30%;float:left;line-height:100px;margin:2px auto;text-align:center;"><?php echo $b['certificate'];?></div>
                              <div style="width: 60%;float:left;line-height:100px;margin:2px auto;text-align:center;"> <img src="<?php echo BANGU_URL.$b['certificatepic'];?>" height="100" />
                              </div>
                            </div>
                            <?php endforeach;?>
                          <?php endif;?>
                        </td>
                    </tr>
                    <?php endif;?>
                     <tr height="40">
                        <td class="order_info_title">工作经历:</td>
                        <td colspan="3">
                             <?php if(!empty($expert_resume)): ?>
                            <?php foreach ($expert_resume as $c=>$d):?>
                             <div class="work_div">
                                <p>起始时间-截止时间：<?php echo $d['starttime'].' - '.$d['endtime'];?></p>
                                <p>所在企业：<?php echo $d['company_name'];?></p>
                                <p>职务：<?php echo $d['job'];?></p>
                                <p>工作内容：<?php echo $d['description'];?></p>
                              </div>
                            
                            <?php endforeach;?>
                          <?php endif;?>
                        </td>
                    </tr>
                </table>
            </div>
            

        </div>
	</div>

</body>

</html>

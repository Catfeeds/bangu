<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试模板</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>

</head>
<body>
	
    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
       
        
        <!-- ===============订单详情============ -->
        <div class="order_detail_d" style="margin: auto 3px;">
          
            <!-- ===============基础信息============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                  <!--   <span class="order_time fr">2015-10-20 14:43:20</span> -->
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">供应商名称:</td>
                        <td colspan="3"><?php echo isset($company_name)==true?$company_name:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">负责人姓名:</td>
                        <td><?php echo isset($realname)==true?$realname:""; ?></td>
                        <td class="order_info_title">负责人手机:</td>
                        <td><?php echo isset($mobile)==true?$mobile:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">联系人姓名:</td>
                        <td><?php echo isset($linkman)==true?$linkman:""; ?></td>
                        <td class="order_info_title">联系人手机:</td>
                        <td><?php echo isset($link_mobile)==true?$link_mobile:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">主营业务:</td>
                        <td colspan="3"><?php echo isset($main_business)==true?$main_business:""; ?></td>
                    </tr>
                    <tr height="40">
                    	<td class="order_info_title">供应商品牌:</td>
                        <td><?php echo isset($brand)==true?$brand:""; ?></td>
                        <td class="order_info_title">所在地:</td>
                        <td><?php echo $country_name.$province_name.$city_name; ?></td>
                        
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">邮箱:</td>
                        <td><?php echo isset($email)==true?$email:""; ?></td>
                        <td class="order_info_title">固话:</td>
                        <td><?php echo isset($telephone)==true?$telephone:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">传真:</td>
                        <td><?php echo isset($fox)==true?$fox:""; ?></td>
                        <td class="order_info_title">负责人证件:</td>
                        <td><img src="<?php echo BANGU_URL.$idcardpic;?>" width="100" /></td>
                    </tr>
                </table>
            </div>
            
            <!-- ===============参团人============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">企业信息</span>
                    <span class="order_time fr"></span>
                </div>
               
               <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    
                    <tr height="40">
                        <td class="order_info_title">供应商类型:</td>
                        <td><?php if($kind=="1") echo "境内供应商";else if($kind=="2") echo "境内个人";else if($kind=="3") echo "境外供应商"; ?></td>
                        <td class="order_info_title">经营许可证号:</td>
                        <td><?php echo isset($licence_img_code)==true?$licence_img_code:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">法人代表姓名:</td>
                        <td><?php echo isset($corp_name)==true?$corp_name:""; ?></td>
                        <td class="order_info_title">法人代表身份证:</td>
                        <td><img src="<?php echo BANGU_URL.$corp_idcardpic;?>" height="100" /></td>
                    </tr>
                    
                    <tr height="40">
                    	<td class="order_info_title">经营许可证:</td>
                        <td><img src="<?php echo BANGU_URL.$licence_img;?>" height="100" /></td>
                        <td class="order_info_title">营业执照:</td>
                        <td><img src="<?php echo BANGU_URL.$business_licence;?>" height="100" /></td>
                        
                    </tr>
                    <tr height="40">
                    	<td class="order_info_title">管理费率:</td>
                        <td><?php echo (round($agent_rate,2)*100)."%";?></td>
                        <td class="order_info_title">供应商代码</td>
                        <td><?php echo isset($code)==true?$code:""; ?></td>
                        
                    </tr>
                </table>
            </div>
        </div>
	</div>

</body>

</html>

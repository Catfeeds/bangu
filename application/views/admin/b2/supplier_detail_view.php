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
    <div class="page-body_detail" id="bodyMsg">
    
       
        
        <!-- ===============订单详情============ -->
        <div class="order_detail_d" style="margin: auto 3px;">
          
            <!-- ===============基础信息============ -->
            <div class="content_part">
                <!-- <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                     <span class="order_time fr">2015-10-20 14:43:20</span> 
                </div>
                -->
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">供应商名称:</td>
                        <td colspan="3"><?php echo isset($company_name)==true?$company_name:""; ?></td>
                    </tr>
                   <!-- <tr height="40">
                        <td class="order_info_title">负责人姓名:</td>
                        <td><?php echo isset($realname)==true?$realname:""; ?></td>
                        <td class="order_info_title">负责人手机:</td>
                        <td><?php echo isset($mobile)==true?$mobile:""; ?></td>
                    </tr>
                     -->
                    <tr height="40">
                        <td class="order_info_title">联系人姓名:</td>
                        <td><?php echo isset($linkman)==true?$linkman:""; ?></td>
                        <td class="order_info_title">联系人手机:</td>
                        <td><?php echo isset($link_mobile)==true?$link_mobile:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">主营业务:</td>
                        <td><?php echo isset($main_business)==true?$main_business:""; ?></td>
                        <td class="order_info_title">供应商代码:</td>
                        <td><?php echo isset($code)==true?$code:""; ?></td>
                    </tr>
                    <tr height="40">
                    	<td class="order_info_title">供应商品牌:</td>
                        <td><?php echo isset($brand)==true?$brand:""; ?></td>
                        <td class="order_info_title">所在地:</td>
                        <td><?php echo $country_name.$province_name.$city_name; ?></td>
                        
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">负责人邮箱:</td>
                        <td><?php echo isset($email)==true?$email:""; ?></td>
                        <td class="order_info_title">联系人邮箱:</td>
                        <td><?php echo isset($linkemail)==true?$linkemail:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">传真:</td>
                        <td><?php echo isset($fox)==true?$fox:""; ?></td>
                        <td class="order_info_title">固话:</td>
                        <td><?php echo isset($telephone)==true?$telephone:""; ?></td>
                    </tr>
                    
                </table>
            </div>
            
            <!-- ===============参团人============ -->
           
        </div>
	</div>

</body>

</html>

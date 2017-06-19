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
                        <td class="order_info_title">销售姓名:</td>
                        <td><?php echo isset($apply['expert_name'])==true?$apply['expert_name']:""; ?></td>
                        <td class="order_info_title">营业部门:</td>
                        <td><?php echo isset($apply['depart_name'])==true?$apply['depart_name']:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">经理姓名:</td>
                        <td><?php echo isset($apply['manager_name'])==true?$apply['manager_name']:""; ?></td>
                        <td class="order_info_title">申请的额度:</td>
                        <td><?php echo isset($apply['credit_limit'])==true?$apply['credit_limit']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">申请时间:</td>
                        <td><?php echo isset($apply['addtime'])==true?$apply['addtime']:""; ?></td>
                        <td class="order_info_title">申请备注:</td>
                        <td><?php echo isset($apply['remark'])==true?$apply['remark']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title" style="width:12%;">经理审核时间:</td>
                        <td style="width:30%;"><?php echo isset($apply['m_addtime'])==true?$apply['m_addtime']:""; ?></td>
                        <td class="order_info_title">经理备注:</td>
                        <td><?php echo isset($apply['m_remark'])==true?$apply['m_remark']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">供应商:</td>
                        <td><?php echo isset($apply['company_name'])==true?$apply['company_name']:""; ?></td>
                        <td class="order_info_title">旅行社:</td>
                        <td><?php echo isset($apply['union_name'])==true?$apply['union_name']:""; ?></td>
                     </tr>
                      <tr height="40">
                        <td class="order_info_title">审核回复内容:</td>
                        <td colspan="3"><?php echo isset($apply['reply'])==true?$apply['reply']:""; ?></td>
                    </tr>
                   
                </table>
            </div>
            

        </div>
	</div>

</body>

</html>

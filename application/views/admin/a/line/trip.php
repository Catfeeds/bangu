<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试模板</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>

<style>
.no_data{width:100%;float:left;height:50px;margin-top:24%;color:red;text-align:center;font-size:14px;}
</style>

</head>
<body>
	
    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
       
        
        <!-- ===============订单详情============ -->
        <div class="order_detail">
          
            <!-- ===============基础信息============ -->
            <?php if(!empty($list)):?>
            <?php foreach ($list as $k=>$v):?>
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">第<?php echo $v['day'];?>天</span>
                  <!--   <span class="order_time fr">2015-10-20 14:43:20</span> -->
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">行程内容:</td>
                        <td colspan="3"><?php echo isset($v['jieshao'])==true?$v['jieshao']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">用餐:</td>
                        <td colspan="3" style="padding:5px;">
                        		早餐：<?php if($v['breakfirsthas']=="1") echo $v['breakfirst'];else echo "无"; ?><br/>
                        		中餐：<?php if($v['lunchhas']=="1") echo $v['lunch'];else echo "无"; ?><br/>
                        		晚餐：<?php if($v['supperhas']=="1") echo $v['supper'];else echo "无"; ?><br/>
                        </td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">住宿情况:</td>
                        <td colspan="3"><?php echo isset($v['hotel'])==true?$v['hotel']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">交通情况:</td>
                        <td colspan="3"><?php echo isset($v['title'])==true?$v['title']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">相关图片:</td>
                        <td colspan="3">
                         <?php if(!empty($v['pic_arr'])):?>
                            <?php foreach ($v['pic_arr'] as $k=>$v):?>
                               <img src="<?php echo BANGU_URL.$v;?>" height="80" />
                            <?php endforeach;?>
                         <?php endif;?>
                        
                        </td>
                    </tr>
                    
                   
                </table>
            </div>
               <?php endforeach;?>
               
               <?php else:?>
                <div class="no_data">暂无行程</div>
             <?php endif;?>
     
        </div>
	</div>

</body>

</html>

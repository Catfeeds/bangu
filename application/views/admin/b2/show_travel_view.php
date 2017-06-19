<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>线路行程</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>

<style>
.no_data{width:100%;height:50px;margin-top:200px;color:red;text-align:center;font-size:14px;}
.page-body { width:900px;margin:0 auto;}
.order_info_table tr td pre { width:780px;word-break: break-word;}
</style>
</head>
<body>
    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
        <!-- ===============订单详情============ -->
        <div class="order_detail">
            <!-- ===============基础信息============ -->
           <div class="content_part">
                <div  style="text-align: center;font-size:17px;padding-bottom:22px;">
                    <span class="txt_info fl" style="font-family: Microsoft YaHei;width:100%;text-align:center;"><?php echo $line_row['linename'];?></span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <?php if(!empty($line_row['feeinclude'])):?>
                    <tr height="40">
                        <td class="order_info_title">费用包含:</td>
                        <td colspan="3"><pre><?php echo $line_row['feeinclude'];?></pre></td>
                    </tr>
                    <?php endif;?>

                    <?php if(!empty($line_row['feenotinclude'])):?>
                     <tr height="40">
                        <td class="order_info_title">费用不包含:</td>
                        <td colspan="3"><pre><?php echo $line_row['feenotinclude'];?></pre></td>
                    </tr>
                     <?php endif;?>

                    <?php if(!empty($line_row['visa_content'])):?>
                     <tr height="40">
                        <td class="order_info_title">签证说明:</td>
                        <td colspan="3"><pre><?php echo $line_row['visa_content'];?></pre></td>
                    </tr>
                     <?php endif;?>

                    <?php if(!empty($line_row['other_project'])):?>
                     <tr height="40">
                        <td class="order_info_title">购物自费:</td>
                        <td colspan="3"><pre><?php echo $line_row['other_project'];?></pre></td>
                    </tr>
                    <?php endif;?>
                    <?php if(!empty($line_row['insurance'])):?>
                     <tr height="40">
                        <td class="order_info_title">保险说明:</td>
                        <td colspan="3"><pre><?php echo $line_row['insurance'];?></pre></td>
                    </tr>
                    <?php endif;?>
                    <?php if(!empty($line_row['beizu'])):?>
                    <tr height="40">
                        <td class="order_info_title">温馨提示:</td>
                        <td colspan="3"><pre><?php echo $line_row['beizu'];?></pre></td>
                    </tr>
                    <?php endif;?>
                    <?php if(!empty($line_row['safe_alert'])):?>
                     <tr height="40">
                        <td class="order_info_title">安全提示:</td>
                        <td colspan="3"><pre><?php echo $line_row['safe_alert'];?></pre></td>
                    </tr>
                    <?php endif;?>

                    <?php //if(!empty($line_row['special_appointment'])):?>
<!--                     <tr height="40"> -->
<!--                         <td class="order_info_title">特别约定:</td> -->
<!--                         <td colspan="3"></td> -->
<!--                     </tr> -->
                <?php //endif;?>
                </table>
            </div>
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
             <div style="margin: auto;text-align: center;">
                        <a style="margin:0 auto;background:#09c;cursor:pointer;outline:none;color:#fff;width:80px;border-radius:3px;text-align:center;line-height:30px;height:30px;display: block" class="a_trip" data-id="<?php echo $line_id; ?>">打印预览</a>
                    </div>
    </div>
    
  
       
    
    
    
    
</body>

</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">

.ul_div{margin-top:10px;margin-left:10px;}
.ul_div .one_p{line-height:30px;margin:10px auto;}
.ul_div .one_p font{font-weight:bold;float:left;}
.ul_div .one_p input{width:45px;padding-left:5px;background:#ebebe4;}

.ul_div .div_trip{border-bottom:1px solid #ddd;margin-bottom:20px;float:left;width:100%;}
.ul_div .div_trip p{line-height:30px;margin:4px auto;float:left;width:100%;}
.ul_div .div_trip p font{font-weight:bold;}

.ul_div .div_trip .div_pic{float:left;width:100%;margin-bottom:5px;}
.ul_div .div_trip .div_pic font{font-weight:bold;}

.ul_div .three_p{margin:5px auto;width:100%;float:left;border-bottom:1px solid #ddd;padding-bottom:10px;}
.ul_div .three_p font{color:#66C9F3;float:left;border:1px solid #66C9F3;padding:4px;margin-right:10px;}
.ul_div .three_p input{width:45px;padding-left:5px;background:#ebebe4;}
.ul_div .three_p p{float:left;}

.page_content { margin-top:0;}
.line_features { float:left;text-indent:2em !important;}
.line_features p { text-align:left !important;text-indent:2em !important;}
/* 屏蔽设置价格*/
 .cal-manager .add-package{display:none;}
.line_features { float:left;text-indent:2em !important;}
.line_features p { text-align:left !important;text-indent:2em !important;}

.reserve_table td .lprice {
  color:#F40;
}

</style>
<link href="<?php echo base_url('assets/css/product.css')?>"  rel="stylesheet" />
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg" style="box-shadow:none;overflow-x:initial;">

        <!-- ===============我的位置============ -->
        <!-- <div class="current_page">
            <a href="#" class="main_page_link"><i></i>线路管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">线路列表</a>
        </div> -->

        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray" style="margin-top:0;">

            <!-- tab切换表格 -->
            <div class="table_content" style="padding-bottom:0px;position:relative;padding-top:36px;">
                <div class="itab" style="position: fixed;top:0;left:0;height:31px;z-index:1000;width:96%;left:10px;">
                    <ul class="clear">
                        <li static="1"><a href="#tab1" class="active">基础信息</a></li>
                        <li static="1"><a href="#tab1">行程安排</a></li>
                        <li static="1"><a href="#tab1">报价</a></li>
                        <li static="1"><a href="#tab1">费用说明</a></li>
                        <li static="1"><a href="#tab1">参团须知</a></li>
                        <li static="1"><a href="#tab1">产品标签</a></li>
                        <li static="1"><a href="#tab1">管家培训</a></li>


                    </ul>
                </div>
                <div class="tab_content" style="margin-top:0px;">
                       <div class="ul_div clear">
                           <p class="one_p" style="color: red;font-size: 14px;"><font>供应商联系人：</font><?php echo $supplier[0]["linkman"]." / ".$supplier[0]["link_mobile"];?></p>
                           <p class="one_p"><font>线路编号：</font><?php echo $line['data']['linecode'];?></p>
                           <p class="one_p clear"><font>线路名称：</font><?php echo $line['data']['linename'];?></p>
                           <p class="one_p clear"><font>线路副标题：</font><?php echo $line['data']['linetitle'];?></p>
                           <p class="one_p clear"><font>出发地：</font><?php echo $line['data']['startplace'];?></p>
                           <p class="one_p clear"><font>目的地：</font><?php echo $line['data']['overcity_name'];?></p>
                           <p class="one_p clear"><font>主题游：</font><?php echo $line['data']['theme_name'];?></p>
                           <p class="one_p "><font>上车地点：</font>
                                    <?php  if(!empty($carAddress)){
                                         foreach ($carAddress as $key => $value) {

                                                echo $value['on_car'].'&nbsp;&nbsp;&nbsp;&nbsp;';
                                         }
                                     }?>
                           </p>
                           <div class="one_p clear"><font style="display:block;width:100%;">线路特色：</font><div class="line_features"><?php echo $line['data']['features'];?></div></div>
                           <div class="one_p clear">
                           <font style="display:block;width:100%;">线路宣传图：</font>
                                    <?php
                                    if(!empty($line['imgurl'])){
                                        foreach ($line['imgurl'] as $k=>$v){
                                                         if(!empty($v['filepath'])){
                                  ?>
                                  <div style="width:100px;float: left;margin-right:15px;"><img  style="height:100%;height:60px;" src="<?php echo $v['filepath']; ?>">
                                     <span style="margin-left:30px"><?php if($v['filepath']==$line['data']['mainpic']){ echo '主图片'; } ?></span>
                                  </div>
                                 <?php } } }?>

                           </div>

                       </div>
                       <div class="ul_div clear" style="display:none;">
                           <?php if(!empty($line['rout'])): ?>
                            <?php foreach ($line['rout'] as $k=>$v):?>
                            <div class="div_trip">
                                <p><font style="font-size:16px;">第<?php echo $v['day'];?>天</font></p>
                                <p><font>标题：</font><?php echo $v['title'];?></p>
                                <p><font>早餐：</font><?php if($v['breakfirsthas']=="1") echo $v['breakfirst'];else echo "无";?></p>
                                <p><font>中餐：</font><?php if($v['lunchhas']=="1") echo $v['lunch'];else echo "无";?></p>
                                <p><font>晚餐：</font><?php if($v['supperhas']=="1") echo $v['supper'];else echo "无";?></p>
                                <p><font>交通：</font><?php echo $v['title'];?></p>
                                <p><font>住宿：</font><?php echo $v['hotel'];?></p>
                                <p><font>行程：</font><?php echo $v['jieshao'];?></p>
                                <div class="div_pic"><font>行程图片：</font>
                                   <?php  if(!empty($v['pics'])):?>
                                    <?php foreach ($v['pics'] as $p=>$pic):?>
                                      <img src="<?php echo $pic;?>" style="height:80px;" />
                                    <?php endforeach;?>
                                    <?php endif;?>
                                </div>
                            </div>
                            <?php endforeach;?>
                            <?php else:?>
                            <div>暂无行程</div>
                            <?php endif;?>
                       </div>


                        <div class="ul_div" style="display:none;">
                          <div class="one_p" >
                                <p class=""><font>定金：</font><?php if(!empty($line['line_aff'])){ echo $line['line_aff']['deposit'];}else{ echo 0;} ?> 元/人</p>
                                <p ><font>提前：</font><?php if(!empty($line['line_aff'])){ echo $line['line_aff']['before_day'];}else{ echo 0;} ?> 天交团费</p>
                          </div>
                          <!-- <div class="one_p"  >
                           <p class=""><font>成人佣金：</font><?php echo $line['data']['agent_rate_int'];?> 元/人份</p>
                           <p ><font>儿童佣金：</font><?php echo $line['data']['agent_rate_child'];?> 元/人份</p>

                          </div> -->

                         <!--    <p class=""><font>备注：</font></p> -->
                           <p class="one_p"><font>儿童占床价说明：</font>
                           <?php if(!empty($line['data']['child_description'])){ echo $line['data']['child_description']; }else{ echo "&nbsp;";} ?>
                           </p>
                           <p class="one_p" ><font>儿童不占床价说明：</font>
                           <?php  if(!empty($line['data']['child_nobed_description'])){ echo $line['data']['child_nobed_description'];}else{echo "&nbsp;"; }?>
                           </p>
                           <p class="one_p"><font>特殊人群价说明：</font>
                           <?php if(!empty($line['data']['special_description'])){echo $line['data']['special_description'];}else{echo "&nbsp;";} ?>
                           </p>
                           <div class="one_p" style="margin:0px;  float: left; width: 100%;" >
                           <input name="lineId" type="hidden" id="lineId"  value="<?php  if(!empty($line['data']['id'])){ echo $line['data']['id']; }?>" />
                                   <div class="cal-manager">
                                   </div>
                           </div>
                       </div>


                        <div class="ul_div clear" style="display:none;">
                           <div class="three_p"><font>费用包含：</font><?php echo $line['data']['feeinclude'];?></div>
                           <div class="three_p"><font>线路不包含：</font><?php echo $line['data']['feenotinclude'];?></div>
                           <div class="three_p"><font>保险说明：</font><?php echo $line['data']['insurance'];?></div>
                           <div class="three_p"><font>签证说明：</font><?php echo $line['data']['visa_content'];?></div>
                           <div class="three_p"><font>购物自费说明：</font><?php echo $line['data']['other_project'];?></div>
                       </div>
                        <div class="ul_div clear" style="display:none;">
                           <div class="three_p"><font>特别约定：</font><?php echo $line['data']['special_appointment'];?></div>
                           <div class="three_p"><font>温馨提示：</font><?php echo $line['data']['beizu'];?></div>
                           <div class="three_p"><font>安全提示：</font><?php echo $line['data']['safe_alert'];?></div>

                       </div>
                        <div class="ul_div clear" style="display:none;">
                           <div class="four_p clear"><span class="fl" style="line-height:26px;">产品标签：</span>
                            <?php  if(!empty($line['line_attr_arr'])):?>
                                    <?php foreach ($line['line_attr_arr'] as $n=>$m):?>
                                     <span style="color:blue;border:1px solid blue;padding:4px;float:left;margin:0 5px 5px;"><?php echo $m['name'];?></span>
                                    <?php endforeach;?>
                           <?php endif;?>

                           </div>

                       </div>
                       <div class="ul_div clear" style="display:none;">
                            <?php if(!empty($line['train'])): ?>
                            <?php foreach ($line['train'] as $k=>$v):?>
                            <div class="div_trip">

                                <p><font>问：</font><?php  echo $v['question'];?></p>
                                <p><font>答：</font><?php  echo $v['answer'];?></p>

                            </div>
                            <?php endforeach;?>
                            <?php else:?>
                            <div>暂无培训内容</div>
                            <?php endif;?>
                       </div>

                </div>

            </div>

        </div>

    </div>

 <!-- 停用供应商 弹层 -->
 <div class="fb-content" id="stop_div" style="display:none;">
    <div class="box-title">
        <h5>停用销售人员</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">

            <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:15%;">停用理由：</div>
                <div class="fg-input" style="width:80%;"><textarea name="beizhu" id="reason" maxlength="30" placeholder="请填写停用理由" style="height:160px;"></textarea></div>
            </div>

            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_stop" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

 <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
<script  src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<script  src="<?php echo base_url('assets/js/admin/jquery.b2_date.js')?>"></script>
<script type="text/javascript">

//----------------------------报价------------------------------
(function(){

  var priceDate = null;

  function initProductPrice(){
    var url = '<?php echo base_url()?>admin/b2/pre_order/getProductPriceJSON';
      priceDate = new jQuery.calendarTable({  record:'', renderTo:".cal-manager",comparableField:"day",
      url :url,
      params : function(){
        return jQuery.param( { "lineId":jQuery('#lineId').val()  ,"suitId":jQuery('#suitId').val()  ,"startDate":jQuery('#selectMonth').val() } );
      },
      monthTabChange : function(obj,date){
        jQuery('#selectMonth').val(date);
      },
      dayFormatter:function(settings,data){
          var dayid= '';
          var number= '';
          var adultprice= '';
          var childprice= '';
          var childnobedprice = '';
          var groupId='';
          var oldprice='';
          var before_day='';
          var hour='';
          var minute='';
          var room_fee='';
          var agent_rate_childno='';
          var agent_room_fee='';
          var agent_rate_int='';
          var agent_rate_child='';
          var time='';
          if(data){
            dayid = data.dayid;
            childnobedprice = data.childnobedprice;
            adultprice=data.adultprice;
            childprice=data.childprice;
            number = data.number;
            oldprice = data.oldprice;
            room_fee=data.room_fee;
            agent_rate_childno=data.agent_rate_childno;
            agent_room_fee=data.agent_room_fee;
            before_day=data.before_day;
            hour=data.hour;
            minute=data.minute;
            agent_rate_int=data.agent_rate_int;
            agent_rate_child=data.agent_rate_child;
            var str0='<span style="color:#F40" >';
            str1='<span>';
            time=str0+before_day+str1+'<span>天</span>'+str0+hour+str1+'<span>时</span>'+str0+minute+str1+'<span>分</span>';

          }
          settings.disabled;
          var  flag=true;
          var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );
          var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
          html += flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span class="lprice">'+adultprice+"</span><span>元</span>")+'</p>':'';
          html+= flag ? '<p>'+(''==agent_rate_int?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_int+"</span><span>元</span>")+'</p>':'';

          html+= flag ? '<p>'+(''==childprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childprice+"</span><span>元</span>")+'</p>':'';
          html+=flag ? ' <p>'+(''==agent_rate_child?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_child+"</span><span>元</span>")+'</p>':'';

          html+=  flag ? '<p>'+(''==childnobedprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childnobedprice+"</span><span>元</span>")+'</p>':'';
          html+=flag ? '<p>'+(''==agent_rate_childno?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_childno+"</span><span>元</span>")+'</p>':'';
          
          html+=flag ? '<p class="singleRow" >'+(''==number?'':'<span class="lprice" >'+number+"</span><span>份</span>")+'</p>': '';

          html+=flag ? '<p>'+(''==room_fee?'':'<span style="float: left;">售价：</span><span class="lprice" >'+room_fee+"</span><span>元</span>")+'</p>': '';
          html+=flag ? '<p>'+(''==agent_room_fee?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_room_fee+"</span><span>元</span>")+'</p>':'';

          html+=flag ? '<p class="singleRow" >'+(''==time?'':time)+'</p>':'';

          return html;
        },dayFormatter1:function(settings,data){
          var dayid= '';
          var number= '';
          var adultprice= '';
          var childprice= '';
          var childnobedprice = '';
          var groupId='';
          var oldprice='';
          var before_day='';
          var hour='';
          var minute='';
          var room_fee='';
          var agent_rate_childno='';
          var agent_room_fee='';
          var agent_rate_int='';
          var agent_rate_child='';
          var time='';
          if(data){
            dayid = data.dayid;
            childnobedprice = data.childnobedprice;
            adultprice=data.adultprice;
            childprice=data.childprice;
            number = data.number;
            oldprice = data.oldprice;
            room_fee=data.room_fee;
            agent_rate_childno=data.agent_rate_childno;
            agent_room_fee=data.agent_room_fee;
            before_day=data.before_day;
            hour=data.hour;
            minute=data.minute;
            agent_rate_int=data.agent_rate_int;
            agent_rate_child=data.agent_rate_child;
            var str0='<span style="color:#F40" >';
            str1='<span>';
            time=str0+before_day+str1+'<span>天</span>'+str0+hour+str1+'<span>时</span>'+str0+minute+str1+'<span>分</span>';
          }
          settings.disabled;
          var  flag=true;
          var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );
          var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
          html += flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span class="lprice">'+adultprice+"</span><span>元</span>")+'</p>':'';
          html+= flag ? '<p>'+(''==agent_rate_int?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_int+"</span><span>元</span>")+'</p>':'';

          html+= flag ? '<p>'+(''==childprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childprice+"</span><span>元</span>")+'</p>':'';
          html+=flag ? ' <p>'+(''==agent_rate_child?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_child+"</span><span>元</span>")+'</p>':'';

          html+=  flag ? '<p>'+(''==childnobedprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childnobedprice+"</span><span>元</span>")+'</p>':'';
          html+=flag ? '<p>'+(''==agent_rate_childno?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_childno+"</span><span>元</span>")+'</p>':'';
          
          html+=flag ? '<p class="singleRow" >'+(''==number?'':'<span class="lprice" >'+number+"</span><span>份</span>")+'</p>': '';

          html+=flag ? '<p>'+(''==room_fee?'':'<span style="float: left;">售价：</span><span class="lprice" >'+room_fee+"</span><span>元</span>")+'</p>': '';
          html+=flag ? '<p>'+(''==agent_room_fee?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_room_fee+"</span><span>元</span>")+'</p>':'';

          html+=flag ? '<p class="singleRow" >'+(''==time?'':time)+'</p>':'';

          return html;

        }
      });


  }
  initProductPrice()



})();

  $(function(){

    $(".itab ul li").each(function(index){

          $(this).click(function(){
                       $(".ul_div").each(function(key){

                         if(key==index)
                             $(this).css("display","block");
                           else
                            $(this).css("display","none");

                      })

              })

      })

     /* $("ul li").click(function(){


              alert(1)


         }) */

    })


</script>
</html>



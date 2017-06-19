<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
 
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.table>thead>tr>th,.table>tbody>tr>td{text-align:center;}
</style>
<link href="<?php echo base_url("assets/ht/css/jquery.datetimepicker.css"); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/ht/js/laypage.js"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>

</head>
<body>


<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">

        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>产品管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">计划列表</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul data-id="1"> 
                        <li static="1" id="table1"><a href="javascript:void(0)" class="active">未结束团期</a></li> 
                        <li static="2" id="table2"><a href="javascript:void(0)" >已结束团期</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear" style="width:1020px">
                                <!-- <div class="search_group">
                                    <label>目的地</label>
                                    <input type="text" id="dest_id" data-id="" name="" onfocus="showMenu(this.id);" class="search_input" style="width:150px;" />
                                </div> -->
                              
                                       <div class="search_group">
                                            <label>团号：</label>
                                            <input type="text" name="lineitem" class="search_input" style="width: 100px;">
                                    </div> 
                                    <div class="search_group">
                                            <label>线路名称：</label>
                                            <input type="text" name="linename" class="search_input" style="width: 160px;">
                                    </div>
                           
                                    <div class="search_group search-time">
                                          <label>出团时间</label>
                                          <input type="text" name="starttime" class="search_input" id="starttime" style="width: 100px;"/>
                                          <input type="text" name="endtime" class="search_input" id="endtime" style="width: 100px;"/>
                                    </div>
                                    <div class="search_group">
                                            <label>线路编号：</label>
                                            <input type="text" name="linecode" class="search_input" style="width: 100px;">
                                     </div>
                                 <div class="search_group">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr class="tr_rows">
                                </tr>
                            </thead>
                            <tbody class="data_rows">
                            </tbody>
                        </table>
                        <!-- 暂无数据 -->
                        <div class="no-data" style="display:none;">木有数据哟！换个条件试试</div>
                    </div>                   
                </div>
                <div id="page_div"></div>
            </div>

        </div>
        
    </div>
   
 <!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<script type="text/javascript">
  var value="2"; //导航tab值
  //js对象
  var object = object || {};
  var ajax_data={};
  object = {
        init:function(){ //初始化方法
           var lineitem=$("input[name='lineitem']").val();
            var linename=$("input[name='linename']").val();
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            var linecode=$("input[name='linecode']").val();
            var type=$(".itab ul").attr("data-id"); //1未过期团期，2已过期团期
            //接口数据
           var post_url="<?php echo base_url('admin/b1/line_plan/indexData')?>";
            ajax_data={page:"1",lineitem:lineitem,linename:linename,starttime:starttime,endtime:endtime,linecode:linecode,type:type};
            var list_data=object.send_ajax(post_url,ajax_data); //数据结果
           var total_page=list_data.data.total_page; //总页数
          
        
          //调用分页
          laypage({
              cont: 'page_div',
              pages: total_page,
              jump: function(ret){

                var html="";  //html内容
              ajax_data.page=ret.curr; //页数
              var return_data=null;  //数据
              if(ret.curr==1)
              {
                return_data=list_data;
              }
              else
              {
                return_data=object.send_ajax(post_url,ajax_data);
              }
              
              
                $(".tr_rows").html("<th>产品编号</th><th>产品名称</th><th>出发地</th><th>团号</th><th>套餐名</th><th>出团日期</th><th>定金</th><th>库存</th><th>成人价</th><th>儿童价格</th><th>不占床儿童价</th><th>单房差</th><th>提前截止收客</th><th>已订人数</th>");

              //写html内容
              if(return_data.code=="2000")
              {
                    html=object.pageData(ret.curr,return_data.data.page_size,return_data.data.result);
                    $(".no-data").hide();
              }
              else if(return_data.code=="4001")
              {
                html="";
                $(".no-data").show();
               }
              else
             {
                layer.msg(return_data.msg, {icon: 1});
                $(".no-data").hide();
               }
                  
                  $(".data_rows").html(html);      
              }
              
          })
            //end
        },
        pageData:function(curr,page_size,data){  //生成表格数据
         
             var str = '', last = curr*page_size - 1;
              last = last >= data.length ? (data.length-1) : last;
              for(var i = 0; i <= last; i++)
              {
                  //提前截止时间
                var before_sec = data[i].before_day*24*60*60;
                 if(before_sec==0 && data[i].hour==0 && data[i].minute==0){
                	 data[i].hour='23';
                	 data[i].minute='59';
                 }
                  var sec = stringToDate(data[i].day + ' '+data[i].hour+':'+data[i].minute+':00')/1000;
                  var sec2 = Number(sec)-Number(before_sec);
                  var date = new Date(sec2*1000);
                  var years = date.getFullYear();
                  var months = date.getMonth()+1;
                  if (months >= 1 && months <= 9) {
                        months = "0" + months;
                  }
                  var days = date.getDate();
                   if (days >= 0 && days <= 9) {
                      days = "0" + days;
                    }
                  var hours = date.getHours();
                   if (hours >= 0 && hours <= 9) {
                      hours = "0" + hours;
                    }
                   var minutes = date.getMinutes();
                   if (minutes >= 0 && minutes <= 9) {
                      minutes = "0" + minutes;
                    }
                  var time= years+'-'+months+'-'+days+' '+hours+':'+minutes;

                  str += "<tr>";
                  
                  str +=     "<td>"+data[i].linecode+"</td>";
                  str +=     "<td style='text-align:left;'><a href='javascript:void(0)' onclick='show_line_detail("+data[i].line_id+",1)' data='"+data[i].line_id+"'>"+data[i].linename+"</a></td>";
                  
                  str +=     "<td>"+data[i].startcity+"</td>";
                  str +=     "<td>"+data[i].description+"</td>";
                 

                  str +=     "<td>"+data[i].suitname+"</td>";
                  str +=     "<td>"+data[i].day+"</td>";
                  str +=     "<td>"+data[i].deposit+"</td>";
                  str +=     "<td>"+data[i].number+"</td>";
                  str +=     "<td style='text-align:right;'>"+data[i].adultprice+"</td>";
                  str +=     "<td style='text-align:right;'>"+data[i].childprice+"</td>";
                  str +=     "<td style='text-align:right;'>"+data[i].childnobedprice+"</td>";
                  str +=     "<td style='text-align:right;'>"+data[i].room_fee+"</td>";
                  
                  str +=     "<td>"+ time+"</td>";
                  str +=     "<td>"+(data[i].total_dingnum==null?'0':data[i].total_dingnum)+"+"+(data[i].total_childnum==null?'0':data[i].total_childnum)+"+"+(data[i].total_childnobednum==null?'0':data[i].total_childnobednum)+"</td>";
                 
                  //操作
                  var status_str="";
                  
                   status_str += "<a href='javascript:void(0)' class='a_update' data-id='"+data[i].id+"'>修改</a>&nbsp;&nbsp;";
                   status_str += "<a href='javascript:void(0)' class='a_copy' data-id='"+data[i].id+"'>复制</a>&nbsp;&nbsp;";
                   status_str += "<a href='javascript:void(0)' class='a_offline' line-id='"+data[i].line_id+"''>下线</a>";
                   if(data[i].status=="2")
                   {
                    str +=     "<td>"+status_str+"</td>";
                   }
                  
                   
                 str += "</tr>";
              }
              return str;
           
        },
        send_ajax:function(url,data){  //发送ajax请求，有加载层
            layer.load(2);//加载层
            var ret;
          $.ajax({
             url:url,
             type:"POST",
               data:data,
               async:false,
               dataType:"json",
               success:function(data){
                 ret=data;
                 setTimeout(function(){
                  layer.closeAll('loading');
                }, 200);  //0.2秒后消失
               },
               error:function(data){
                 ret=data;
                 //layer.closeAll('loading');
                 layer.msg('请求失败', {icon: 2});
               }
                       
            });
              return ret;
              
        },
        send_ajax_noload:function(url,data){  //发送ajax请求，无加载层
              //没有加载效果
            var ret;
          $.ajax({
             url:url,
             type:"POST",
               data:data,
               async:false,
               dataType:"json",
               success:function(data){
                 ret=data;
                
               },
               error:function(){
                 ret=data;
               }
                       
            });
              return ret;
 
      }
      //object  end
    };
  
$(function(){
  object.init();
  //选择事件
  $(".itab ul li").click(function(){
          value=$(this).attr("static");
          $(".itab ul").attr("data-id",value);
          $(".itab ul li a").removeClass('active');
          $(this).find('a').addClass('active'); 
           object.init();
   })
   
  
  //日历控件
  $('#starttime').datetimepicker({
    lang:'ch', //显示语言
    timepicker:false, //是否显示小时
    format:'Y-m-d', //选中显示的日期格式
    formatDate:'Y-m-d',
    validateOnBlur:false,
  });
  //日历控件
  $('#endtime').datetimepicker({
    lang:'ch', //显示语言
    timepicker:false, //是否显示小时
    format:'Y-m-d', //选中显示的日期格式
    formatDate:'Y-m-d',
    validateOnBlur:false,
  });
  
});

//搜索
   $("#btn_submit").click(function(){
     object.init();
  })


function get_date_diff(startDate,hour,minute,linebefore){
    if(hour==0 ||  hour==''){
          hour='00';
     }
     if(minute==0 || minute==''){
        minute='00';
     }
     var before_sec = linebefore*24*60*60;
     var sec = stringToDate(startDate + ' '+hour+':'+minute+':00')/1000;
     var sec2 = Number(sec)-Number(before_sec);
     var endTime2  = (new Date().getTime())/1000;
     if(endTime2>sec2){
        return false;
     }else{
      return true;
     }
}

function stringToDate(string) {
  var f = string.split(' ', 2);
  var d = (f[0] ? f[0] : '').split('-', 3);
  var t = (f[1] ? f[1] : '').split(':', 3);
  return (new Date(parseInt(d[0], 10) || null, (parseInt(d[1], 10) || 1) - 1,
    parseInt(d[2], 10) || null, parseInt(t[0], 10) || null, parseInt(
        t[1], 10) || null, parseInt(t[2], 10) || null));
}

</script>



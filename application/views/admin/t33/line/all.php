<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
<?php $this->load->view("admin/t33/common/dest_tree"); //加载树形目的地   ?>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">

        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>产品管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">产品审核</a>
        </div>

        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">

            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul data-id="1">
                        <li static="1"><a href="javascript:void(0)" class="active">待审核</a></li>
                        <li static="2"><a href="javascript:void(0)">已通过</a></li>
                        <li static="3"><a href="javascript:void(0)">已拒绝</a></li>

                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <div class="search_group">
                                    <label>目的地：</label>
                                    <input type="text" id="dest_id" data-id="" onfocus="showMenu(this.id);" placeholder="输入关键字搜索" onkeyup="showMenu(this.id,this.value);" class="search_input" style="width:150px;" />
                                </div>


                                 <div class="search_group">
                                    <label>产品编号：</label>
                                    <input type="text" id="linecode" name="" class="search_input" style="width:80px;" />
                                </div>

                                <div class="search_group">
                                    <label>上线时间：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;">
                                </div>
                                <div class="search_group">
                                    <label>出发地：</label>
                                    <input type="text" id="startplace" name="" class="search_input" style="width:80px;" />
                                </div>

                                <div class="search_group">
                                    <label>产品标题：</label>
                                    <input type="text" id="linename" name="" class="search_input" style="width:150px;" />
                                </div>

                                <div class="search_group">
                                    <label>录入人：</label>
                                    <input type="text" id="linkman" name="" class="search_input" style="width:80px;" />
                                </div>
                                <div class="search_group">
                                    <label>价格：</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:90px;" /> ~ <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:90px;" />

                                </div>
                                <div class="search_group" style="margin-right:0;">
                                    <label>行程天数：</label>
                                    <input type="text" id="days_start" name="" class="search_input" style="float: none;width:30px;" /> ~ <input type="text" id="days_end" name="" class="search_input" placeholder="" style="float: none;width:30px;" />

                                </div>
                               <div class="search_group">
                                    <label>分类：</label>
                                   <div class="form_select">
                                        <div class="search_select div_kind" data-value="">
                                            <div class="show_select">全部</div>
                                            <ul class="select_list">

                                                <li value="1">境外</li>
                                                <li value="2">国内</li>
                                                <li value="3">周边</li>

                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                    </div>


                                </div>

                               <!-- 搜索按钮 -->
                                <div class="search_group" style="margin-right:0;">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索" style="margin-left:30px;"/>
                                </div>




                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr class="tr_rows">
                                  <!--   <th>团号</th>
                                    <th>产品标题</th>
                                    <th>出发地</th>
                                    <th>截止日期</th>
                                    <th>出团日期</th>
                                    <th>供应商名称</th>
                                    <th>成人价格</th>
                                    <th>老人价格</th>
                                    <th>儿童价格</th>
                                    <th>不占床儿童价</th>
                                    <th>余位</th>
                                    <th>已订人数</th>
                                    <th>操作</th> -->
                                </tr>
                            </thead>
                            <tbody class="data_rows">
                            <!--  <tr>
                                    <td style="text-align:left"> <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=673">海外技术部马尔代夫欢乐岛Fun</a></td>
                                    <td>
                                                                                           中国
                                    </td>
                                    <td>深圳市</td>
                                    <td>1%</td>
                                    <td>深圳海外国际技术部</td>
                                    <td>1%</td>
                                    <td>深圳海外国际技术部</td>
                                    <td>
                                    <a href="javascript:void(0)">修改</a>
                                    <a href="javascript:void(0)">停用</a>
                                    <a href="javascript:void(0)">启用</a>
                                    </td>
                                </tr>-->

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




<script type="text/javascript">
function formatDate(date, format) {
    if (!date) return;
	    if (!format) format = "yyyy-MM-dd";
	    switch(typeof date) {
	        case "string":
	            date = new Date(date.replace(/-/, "/"));
	            break;
	        case "number":
	            date = new Date(date);
	            break;
	    }
	    if (!date instanceof Date) return;
	    var dict = {
	        "yyyy": date.getFullYear(),
	        "M": date.getMonth() + 1,
	        "d": date.getDate(),
	        "H": date.getHours(),
	        "m": date.getMinutes(),
	        "s": date.getSeconds(),
	        "MM": ("" + (date.getMonth() + 101)).substr(1),
	        "dd": ("" + (date.getDate() + 100)).substr(1),
	        "HH": ("" + (date.getHours() + 100)).substr(1),
	        "mm": ("" + (date.getMinutes() + 100)).substr(1),
	        "ss": ("" + (date.getSeconds() + 100)).substr(1)
	    };
	    return format.replace(/(yyyy|MM?|dd?|HH?|ss?|mm?)/g, function() {
	        return dict[arguments[0]];
	    });
	}
	var value="1"; //导航tab值
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var startplace=$("#startplace").val();
            var linename=$("#linename").val();
            var linecode=$("#linecode").val();
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            var days_start=$("#days_start").val();
            var days_end=$("#days_end").val();
            var price_start=$("#price_start").val();
            var price_end=$("#price_end").val();
            var dest_id=$("#dest_id").attr("data-id");
            var type=$(".itab ul").attr("data-id"); //1是直属供应商，2是非直属供应商
            var supplier_name=$("#supplier_name").val();
            var linkman=$("#linkman").val();
            var line_classify=$(".div_kind").attr("data-value");

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/line/api_all')?>";
            ajax_data={page:"1",type:type,linkman:linkman,startplace:startplace,dest_id:dest_id,linecode:linecode,linename:linename,starttime:starttime,endtime:endtime,days_start:days_start,days_end:days_end,price_start:price_start,price_end:price_end,line_classify:line_classify};

            var list_data;
        	var total_page;
        	if(flag==true)
        	{
        	    list_data=object.send_ajax(post_url,ajax_data);  //数据结果
        	    total_page=list_data.data.total_page; //总页数
        	}


        	//调用分页
        	laypage({
        	    cont: 'page_div',
        	    pages: total_page,
        	    jump: function(ret){

        	    	var html="";  //html内容
		        	ajax_data.page=ret.curr; //页数
		        	var return_data=null;  //数据
		        	if(ret.curr==1&&flag==true)
		        	{
		        		return_data=list_data;
		        	}
		        	else
		        	{
		        		return_data=object.send_ajax(post_url,ajax_data);
			        }

		        	if(value=="1")
			        	$(".tr_rows").html('<th width="80">产品编号</th><th>产品标题</th><th width="110">出发地</th><th width="60">价格</th><th width="45">天数</th><th width="125">上线时间</th><th width="70">录入人</th><th width="180">供应商</th><th width="70">审核状态</th><th width="60">操作</th>');
		        	else if(value=="2")
		        		$(".tr_rows").html('<th width="80">产品编号</th><th>产品标题</th><th width="110">出发地</th><th width="60">价格</th><th width="45">天数</th><th width="125">上线时间</th><th width="70">录入人</th><th width="180">供应商</th><th width="70">审核状态</th><th width="70">审核意见</th><th width="80">操作</th>');
		        	else if(value=="3")
		        		$(".tr_rows").html('<th width="80">产品编号</th><th>产品标题</th><th width="110">出发地</th><th width="60">价格</th><th width="45">天数</th><th width="125">上线时间</th><th width="70">录入人</th><th width="180">供应商</th><th width="70">审核状态</th><th width="70">审核意见</th>');
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
        	flag=false;
            //end
        },
        pageData:function(curr,page_size,data){  //生成表格数据

    	 		var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++)
        	    {

        	        str += "<tr>";
        	        str +=     "<td>"+data[i].linecode+"</td>";
        	        str +=     "<td style='text-align:left;' class='td_long'><a href='javascript:void(0)' onclick='show_line_detail("+data[i].id+",2)' line-id='"+data[i].id+"' line-name='"+data[i].linename+"'>"+data[i].linename+" · "+data[i].linetitle+"</a></td>";

        	        str +=     "<td >"+data[i].startplace+"</td>";
        	        str +=     "<td>"+data[i].lineprice+"</td>";
        	        str +=     "<td>"+data[i].lineday+"</td>";
        	        str +=     "<td>"+data[i].online_time+"</td>";
//         	        str +=     "<td>"+data[i].modtime+"</td>";
        	        str +=     "<td>"+data[i].linkman+"</td>";
        	        str +=     "<td class='td_long' ><a href='javascript:void(0)' class='a_supplier' supplier_id='"+data[i].supplier_id+"'>"+data[i].company_name+" - "+data[i].linkman+"</a></td>";
					var zt_str="申请中";
                    if(data[i].status=="2")
                    	zt_str="已通过";
                    else if(data[i].status=="3")
                    	zt_str="已拒绝";

        	        str +=     "<td class='td_status'>"+zt_str+"</td>";

        	        if(data[i].status=="2"||data[i].status=="3")
        	        str +=     "<td>"+data[i].remark+"</td>";

        	        //操作
        	        var status_str="";

                    if(data[i].status=="1")
                    {
                   		  status_str+="<a href='javascript:void(0)' class='a_set a_shenhe' data-id='"+data[i].id+"' supplier_id='"+data[i].supplier_id+"'>审核</a>";
                   		  str +=     "<td>"+status_str+"</td>";
                    }
                    else if(data[i].status=="2")
                    {
                        /*"<a target='_blank' href='<?php echo base_url();?>admin/b2/pre_order/show_travel?line_id="+rowData['lineid']+"'>行程</a>"*/
                          status_str+="<a href='javascript:void(0)' class='a_trip' dayid='"+data[i].dayid+"' line-id='"+data[i].id+"'>行程</a><a href='javascript:void(0)' class='a_offline' data-id='"+data[i].pl_id+"' data-status='3'>下线</a><a href='javascript:void(0)' class='a_offline' data-id='"+data[i].pl_id+"' data-status='1'>退回申请中</a>";
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
		flag=true;
		object.init();
   })

   $(".div_kind ul li").click(function(){
     var value=$(this).val();
     $(".div_kind").attr("data-value",value);

	})

   $("#btn_submit").click(function(){
	   flag=true;
	   object.init();
	})
	//日历控件
	$('#starttime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//日历控件
	$('#endtime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});

	//线路详情    on：用于绑定未创建内容
	/*$("body").on("click",".a_detail",function(){
		var line_id=$(this).attr("line-id");
		var line_name=$(this).attr("line-name");
		window.top.openWin({
		  title:line_name,
		  type: 2,
		  area: ['1000px', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php //echo base_url('admin/t33/sys/line/detail');?>"+"?id="+line_id
		});
	});*/
	
	//供应商详情    on：用于绑定未创建内容
	$("body").on("click",".a_supplier",function(){
		var supplier_id=$(this).attr("supplier_id");
		var supplier_name=$(this).html();

		window.top.openWin({
		  title:supplier_name,
		  type: 2,
		  area: ['600px', '300px'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/detail');?>"+"?id="+supplier_id
		});
	});
	//线路审核
	$("body").on("click",".a_set",function(){
		var lineid=$(this).attr("data-id");
		var supplier_id=$(this).attr("supplier_id");
		window.top.openWin({
		  type: 2,
		  area: ['500px', '320px'],
		  title :'审核',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/line/setting');?>"+"?id="+lineid+"&supplier_id="+supplier_id
		});
	});
	//下线、退回申请中
	$("body").on("click",".a_offline",function(){
		var id=$(this).attr("data-id");
		var status=$(this).attr("data-status");

		var url="<?php echo base_url('admin/t33/sys/line/api_setting_offline');?>";
		var data={id:id,status:status};
	    var return_data=send_ajax_noload(url,data);

	   if(return_data.code=="2000")
       {
				tan2(return_data.data);
				setTimeout(function(){t33_close_iframe_noreload();},200);
				$(this).hide();
				//刷新页面
				//parent.$("#main")[0].contentWindow.getValue();
	   }
      else
		{
		        tan(return_data.msg);
		 }
	});
	//线路行程    on：用于绑定未创建内容
	$("body").on("click",".a_trip",function(){
		var line_id=$(this).attr("line-id");
		var dayid=$(this).attr("dayid");
		/*window.top.openWin({
		  title:"行程",
		  type: 2,
		  area: ['840px', '600px'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/line/trip');?>"+"?id="+line_id
		});*/
		var win1 = window.open("<?php echo base_url('admin/t33/sys/line/trip');?>"+"?id="+line_id+"&dayid="+dayid,'print','height=950,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes, resizable=yes,location=no, status=no');
		win1.focus();
	});

});

//供弹窗层调用
function parentfun(id,str){
	$(".a_shenhe[data-id="+id+"]").parent().prev().html(str);
	$(".a_shenhe[data-id="+id+"]").parent().html("已审核");

}

function show_line_detail(line_id,type){
	var line_id=line_id;
	window.top.openWin({
		title:'线路详情',
		type: 2,
		area: ['1100px', '80%'],
		fix: false, //不固定
		maxmin: true,
		content: "<?php echo base_url('common/line/show_line_detail');?>"+"?id="+line_id+"&type="+type
	});	
}
</script>
</html>



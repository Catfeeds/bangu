<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>付款申请单</title>
 <link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
 <link href="/assets/css/common.css" rel="stylesheet" type="text/css" />
<link href="/assets/ht/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<!-- <script type="text/javascript" src="/assets/ht/js/base.js"></script> -->
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script> 
<script type="text/javascript" src="/assets/ht/js/laypage.js"></script> 
 
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.search_form_box { padding:0 20px 5px 0;}
.header_div{display:none;}

  fieldset{margin-bottom:10px;border:1px solid #dcdcdc;width: 97%;margin:15px;"}
  .header_div{display:none;}

</style>
 
<link href="/assets/css/style.css" rel="stylesheet" />
</head>
<body>
<!--查看申请的弹框-->

<!--=================右侧内容区================= -->
     <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">付款申请记录</a>
        </div>
        
        <div class="page_content bg_gray search_box">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav"> 
                        <li data-val="0"><a href="#" class="active"  id="tab0">付款申请记录</a></li> 
                    </ul>
                </div>
                <div class="tab_content" style="padding-top:15px;">
                  <form class="search_form" method="post" id="search-condition" action="">
                      <div class="search_form_box clear">
                            <div class="search_group">
                                    <label style="width:60px;">团号：</label>
                                    <input type="text" name="item_code" class="search_input" style="width: 100px;" />
                            </div>
                            <div class="search_group">
                                    <label style="width:60px;" >订单号：</label>
                                    <input type="text" name="ordersn" class="search_input" style="width: 100px;" />
                            </div>
                            <div class="search_group">
                                    <label style="width:60px;" >产品名称：</label>
                                    <input type="text" name="linename" class="search_input" style="width: 150px;" />
                            </div>
                            <div class="search_group">
                                    <label style="width:60px;">付款单号：</label>
                                    <input type="text" name="apply_sn" class="search_input" style="width: 100px;" />
                            </div>
                            <div class="search_group show_select ul_kind ">
                                  <label style="width:60px;" >付款状态</label>
                                  <select name="apply_status">
                                      <option value="-1">请选择</option>
                                      <option value="1">申请中</option>
                                      <option value="2">已通过</option>
                                      <option value="3">已拒绝</option>
                                      <option value="4">已付款</option>
                                      <option value="6">已通过&已付款</option>
                                  </select>  
                            </div>
                            <div class="search_group search-time">
                                  <label style="width:60px;">出团时间</label>
                                  <input type="text" name="starttime" class="search_input" id="starttime" style="width: 100px;"/>
                                  <input type="text" name="endtime" class="search_input" id="endtime" style="width: 100px;"/>
                            </div>
                            <div class="search_group">
                                <input type="hidden" name="status" value="0" />
                                <input type="button" name="submit" class="search_button" id="searchBtn0" value="搜索" style="height:30px;"/>
                                <input type="button" name="submit" class="search_button" id="dive_excel" value="导出excel" style="width:85px;height:30px;"/>
                            </div>
                      </div>
                    </form>
                    <div class="table_list" id="list"></div> 
                </div>
            </div> 
        </div>
    </div> 
<!--添加菜单的弹框end-->
<!--分页-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />

<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>

<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<script>
//-------------------------------------------数据列表--------------------------------------------------------
jQuery(document).ready(function(){
  var page=null;
  // 查询
  jQuery("#searchBtn0").click(function(){
    page.load({"status":"0"});
     $('.all_account').html(0);   //结算总金额
  });
  var data = '<?php echo $pageData; ?>';
  page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/apply/apply_order_log/indexData",form : '#search-condition',// 绑定一个查询表单的ID
    columns : [
      {field : '',title : '操作',align : 'center', width : '90',
          formatter : function(value,rowData, rowIndex){
              if(rowData.type==-1){
                  return '总计:';
              }else{
            	  return ' <a href="#" onclick="order_list('+rowData.id+')">查看</a>&nbsp;&nbsp; <a href="javascript:void(0)" class="a_print" data-id='+rowData.id+'>打印预付</a>';
              }    
          }
       },
      {field : 'paid',title : '付款单号',align : 'center', width : '60'},
    /*{field : 'batch',title : '批次号',align : 'center', width : '80'}, */
      {field : 'item_code',title : '团号',align : 'center',sortable : true,width : '90'},
      {field : 'amount_apply',title : '申请付款金额',align : 'right',sortable : true,width : '90',
        	formatter : function(value,rowData, rowIndex){ 
        		 if(rowData.type==-1){
       			        return rowData.amount_apply.toFixed(2);
      			 }else{
        				return '<span style="color:red">'+rowData.amount_apply+'</span>';
                 }      
      		}
       },
      {field : 'ordersn',title : '订单号',align : 'center',sortable : true,width : '70',
    	   formatter : function(value,	rowData, rowIndex){	
				return '<a href="/admin/b1/order/order_detail?id='+rowData.order_id+'" target="_blank" >'+rowData.ordersn+'</a>';
			}
   	  },
      {field : 'productname',title : '产品名称',align : 'center',sortable : true,width : '110',	
    	  formatter : function(value,rowData, rowIndex){ 
    	    	if(rowData.line_kind==1){
					return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lineid+',1)" data="'+rowData.lineid+'">'+rowData.productname+'</a>';
				}else{
					return rowData.productname;
				}	
    	  }
       },
      {field : 'usedate',title : '出团日期',align : 'center',sortable : true,width : '80'},	
      {field : 'supplier_cost',title : '结算价',align : 'right',sortable : true,width : '90'},
      {field : 'balance_money',title : '已结算',align : 'right',sortable : true,width : '90'},
      {field : 'a_balance',title : '结算申请中',align : 'right',sortable : true,width : '90'}, 	
      {field : 'platform_fee',title : '操作费',align : 'right',sortable : true,width : '70'}, 
      {field : 'un_balance',title : '未结算',align : 'right',sortable : true,width : '90'},
      {field : 'p_apply',title : '待付款',align : 'right',sortable : true,width : '90'},   
      {field : 'realname',title : '申请人',align : 'center',sortable : true,width : '80'},
      {field : 'remark',title : '备注',align : 'center', width : '80' },
      {field : 'employee_name',title : '旅行社审批人',align : 'center', width : '80' },
      {field : 'u_reply',title : '旅行社回复',align : 'center', width : '120' },   
      {field : 'linesn',title : '审核状态',align : 'center', width : '60',
             formatter : function(value,rowData, rowIndex){ 
                    if(rowData.status==0){
                         return '申请中';
                    }else if(rowData.status==1){
                         return '申请中';
                    }else if(rowData.status==2){
                         return '已通过';
                    }else if(rowData.status==3){
                         return '已拒绝';
                    }else if(rowData.status==4){
                         return '已付款';
                    }else if(rowData.status==5){
                    	 return '已拒绝';
                    }else{
                    	 return '';
                    }
              }
      }
   
    ]
  });
  
      jQuery('#tab0').click(function(){
            jQuery('.tab-pane').removeClass('active');
            jQuery('li[name="tabs"]').removeClass('active');
            jQuery('#home0').addClass('active');
            jQuery(this).parent().addClass('active');
            page.load({"status":"0"});
         //   $('.all_account').html(0);   
      }); 
});
   
      //获取申请订单
      var columns2 = [ 
        {field : '',title : '',width : '30',align : 'center' ,
               formatter:function(result) { 
                      if(result.status==0 || result.status==1){
                           return '<input  type="checkbox" checked="checked" id="is_checked" style="opacity:1; left: 10px;" onclick="update_account(this,'+result.id+','+result.order_id+')" >';
                      }else{
                           return '<input  type="checkbox"  disabled="disabled" id="is_checked"  style="opacity:1; left: 10px;"> ';
                      }       
               }
         },
       // {field : 'id',title : '序号',width : '80',align : 'center' },
       
        {field : 'linesn',title : '团号',align : 'center', width : '120'},
        {field : 'amount_apply',title : '本次结算',width : '80',align : 'center'},
        {field : '',title : '销售&部门',width : '140',align : 'center',
              formatter:function(result) { 
                  /*  if(result.list!=null){
                          var   red=parseFloat(result.list).toFixed(2)+'%';
                          return red;
                    }else{
                          return '';
                    }*/
                  return result.expert_name+'&'+result.depart_name;
               }
        },
        {field : 'productname',title : '产品名称',align : 'left', width : '200'},
        {field : 'usedate',title : '出团日期',align : 'center', width : '90'},
        {field : 'supplier_cost',title : '结算价',align : 'center', width : '80'},
        {field : 'balance_money',title : '已结算',align : 'center', width : '80' },
        {field : '',title : '未结算',align : 'center', width : '100',
                formatter:function(result) { 
                      return '<span style="color:#ff6600;font-weight:700">'+result.un_account+'</span>';
                }
        },
        {field : '',title : '已结算比例',align : 'center', width : '100',
               formatter:function(result) { 
                    if(result.all_account!=null){
                          var  red=parseFloat(result.all_account).toFixed(2)+'%';
                          return red;  
                     }else{
                          return  '';
                     }                        
                }
        },

        {field : 'ordersn',title : '订单号',align : 'center', width : '80'},
        {field : 'platform_fee',title : '操作费',align : 'center', width : '80'},
        {field : false,title : '审核状态',align : 'center', width : '80',formatter:function(result) {
              if(result.status==0){
                      return '<span class="result">申请中</span>';
               }else if(result.status==1){
                      return '<span class="result">申请中</span>';
               }else if(result.status==2){
                      return '<span class="result">已通过</span>';
               }else if(result.status==3){
                      return '<span class="result">已拒绝</span>';
               }else if(result.status==4){
                      return '<span class="result">已付款</span>';
               }else if(result.status==5){
                      return '<span class="result">已拒绝</span>';
               }
          }
        },
        {field : '',title : '操作',align : 'center', width : '60',
            formatter : function(result){ 
               
                if(result.status==1||result.status==2||result.status==4)
             	    return '<a href="javascript:void(0)" class="a_print" data-id='+result.id+'>打印预付</a>';
                else
                  return '';
           }
        }
       
   ];

//----------------------------------------数据列表end--------------------------------------------------------------------
$('#starttime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});
$('#endtime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});
$('#u_starttime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});
$('#u_endtime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});

//查看
function order_list(id) {
	
	layer.open({
		  type: 2,
		  area: ['820px', '540px'],
		  title :'详情',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/b1/apply/apply_order_log/pay_order_detail');?>"+"?id="+id
	});
	//赋值
	/*$(".a_print_month").attr("data-id",id);
	
        $('.layui-layer-shade').show();
        $('.layui-layer-page').show();

      $('input[name="payable_id"]').val(id);
      if(id>0){
              $('input[name="id"]').val(id);
              var columns = columns2;
              $("#dataTable_list").pageTable({
                      columns:columns,
                      url:'/admin/b1/apply/apply_order_log/get_apply_order',
                      pageSize:10,
                      tbodyClass:'t_tbody',
                      searchForm:'#search-condition_list',
                      tableClass:'table table-bordered table_hover'
              });
        
      }else{
            alert('获取失败');
      }
 
          var addObj = $('#add-form');
          $('.union-admin').show();
          layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                area: ['980px','600px'],
                shadeClose: false,
                content: $('#union-box')
          });

            $.post("/admin/b1/apply/apply_order_log/get_apply_count", { id:id} , function(result) {
                      result = eval('('+result+')');

                      $('.bankcard').html(result.bankcard);
                      $('.bankname').html(result.bankname);
                      $('.bankcompany').html(result.bankcompany );
                      $('.all_account').html(result.all_account); 

                    var str='<tr class="show_acount" style="display:none">';
                      str=str+'<td >总计</td>';
                      str=str+'<td>'+result.apply_money+'</td><td colspan=3 ></td><td>'+result.supplier_cost+'</td>';
                      str=str+'<td >'+result.balace_money+'</td>';
                      str=str+'<td >'+result.un_money+'</td>';
                      str=str+'<td colspan=2></td><td>'+result.platform_fee+'</td>';
                      str=str+'<tr>';
                      $('.t_tbody').append(str);

                      var pic_str='暂无流水单';
                      $.each(result.pic,function(n,value) {
                            pic_str='';
                            pic_str=pic_str+'<a href="'+value.pic+'" target="_blank" ><img src="'+value.pic+'" style="max-width:120px;margin-right: 10px;" ></a>';
                      });
                      $('#account_pic').html('<span style="margin-right: 10px;">流水单</span>'+pic_str);

             });*/
}
//取消某个订单的结算
function update_account(obj,id,order_id){
      var re= $(obj).attr('checked');
      if(re!='checked'){
      if (!confirm("确定要去掉该订单？")) {
            window.event.returnValue = false;
       }else{
           $.post("<?php echo base_url()?>admin/b1/apply/apply_order_log/cancel_apply_order", { id:id,order_id:order_id} , function(result) {
                  result = eval('('+result+')');
               //   if(result.status==1){
                  alert(result.msg);
                    //加载数据列表
                  var columns = columns2;
                  $("#dataTable_list").pageTable({
                          columns:columns,
                          url:'/admin/b1/apply/apply_order_log/get_apply_order',
                          pageSize:10,
                          searchForm:'#search-condition_list',
                          tableClass:'table table-bordered table_hover'
                   });
                   jQuery('#tab0').click();
             });
          }
      }
}
//搜索
function show_data(){
      var id=$('input[name="payable_id"]').val();
      var u_starttime=$('input[name="u_starttime"]').val();
      var u_endtime=$('input[name="u_endtime"]').val();
      var ordersn=$('input[name="ordersn"]').val();
      $.post("<?php echo base_url()?>admin/b1/apply/apply_order_log/get_apply_count", { id:id,u_starttime:u_starttime,u_endtime:u_endtime,ordersn:ordersn} , function(result) {
            result = eval('('+result+')');

            $('.all_account').html(result.all_account);

            var str='<tr class="show_acount" style="display:none">';
            str=str+'<td >总计</td>';
            str=str+'<td>'+result.apply_money+'</td><td colspan=3 ></td><td>'+result.supplier_cost+'</td>';
            str=str+'<td >'+result.balace_money+'</td>';
            str=str+'<td >'+result.un_money+'</td>';
            str=str+'<td colspan=3 ></td><td>'+result.platform_fee+'</td>';
            str=str+'<tr>';
            $('.t_tbody').append(str);

      });
}

/*var hkey_root,hkey_path,hkey_key 
hkey_root="HKEY_CURRENT_USER";
hkey_path="\\Software\\Microsoft\\Internet Explorer\\PageSetup\\" ;
//hkey_path="HKEY_CURRENT_USER\Software\Micro-soft\Internet Explorer\PageSetup" ;
//设置网页打印的页眉页脚为空 
function pagesetup_null(){
      try{  
           var RegWsh = new ActiveXObject("WScript.Shell");
           hkey_key="header";
           RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"");
           hkey_key="footer";
           RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"") ;
      }catch(e){

      } 
}*/

function preview(oper)         
{  
        var older=document.body.innerHTML;
        $('.header_div').show();//标题
        $('.show_acount').show(); //统计数量
        $('.jian_tab').show();
        jQuery('#tab0').click();

        $('.table_hover').find('th').eq($(".t_tbody").find("th").length-1).hide();  //去掉最后一列
        $(".result").parent().hide();

        $('.table_hover').find('th').eq(0).hide();  //去掉开头一列
        $('.table_hover').find("#is_checked").parent().hide();

        var headstr='<html xmlns="http://www.w3.org/1999/xhtml"><head>';
        headstr=headstr+'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        headstr=headstr+'<title>付款申请单</title></head><body>';

        var footstr="</body></html>";

        $("title").html("付款申请单"); 

        bdhtml=window.document.body.innerHTML;//获取当前页的html代码  
        sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域  
        eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域  
        prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)); //从开始代码向后取html  
        prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html  

        prnhtml = prnhtml.replace(new RegExp(sprnstr), "");

        window.document.body.innerHTML=headstr+prnhtml+footstr;  
   //     pagesetup_null();
        window.print();  

        //取消打印时恢复数据
        window.location.reload();


     /*   document.body.innerHTML=older;
          $('.header_div').hide();//标题
          $('.jian_tab').hide();
          var columns = columns2;
          $("#dataTable_list").pageTable({
                columns:columns,
                url:'/admin/b1/apply/apply_order_log/get_apply_order',
                pageSize:10,
                tbodyClass:'t_tbody',
                searchForm:'#search-condition_list',
                tableClass:'table table-bordered table_hover'
           });*/
} 

//导数据
$("body").on("click","#dive_excel",function(){
     jQuery.ajax({ type : "POST",async:false, data :jQuery('#search-condition').serialize(),url : "<?php echo base_url()?>admin/b1/apply/apply_order_log/drive_payable", 
           success : function(result) {
                  var result = eval('(' + result + ')');
                  if(result.status==1){
                        window.location.href="<?php echo base_url()?>"+result.file;  
                  }else{
                        alert(result.msg);
                  }  
           }
     });
});

function close_div(){    
      $('.layui-layer-shade').hide();
      $('.layui-layer-page').hide();
      $('.layui-layer-close').click();
}

   /*打印预付*/
  $("body").on("click",".a_print",function(){
		
		var id=$(this).attr("data-id");
		var win1 = window.open("<?php echo base_url('admin/b1/apply/apply_order_log/pay_print');?>"+"?id="+id,'print','height=1090,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		win1.focus();
	});
  //打印月结
	$("body").on("click",".a_print_month",function(){
		var id=$(this).attr("data-id");
		var win1 = window.open("<?php echo base_url('admin/b1/apply/apply_order_log/pay_print_month');?>"+"/"+id+"/1",'print','height=1090,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		win1.focus();
	});

</script>
</html>

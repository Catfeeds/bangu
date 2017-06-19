<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
 <link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<link href="/assets/ht/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<!-- <script type="text/javascript" src="/assets/ht/js/base.js"></script> -->
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/ht/js/laypage.js"></script>

<!-- 图片上传 -->
<link href="css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="/assets/js/fileupload/css/jquery.fileupload.css" />
<link rel="stylesheet" href="/assets/js/fileupload/css/jquery.fileupload-ui.css" />
<script src="/assets/js/fileupload/vendor/jquery.ui.widget.js"></script>
<script src="/assets/js/fileupload/jquery.fileupload.js"></script>
<script src="/assets/js/fileupload/jquery.iframe-transport.js"></script>

<!-- 图片上传end -->
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.search_input { width:100px;}
.choice-box-line .db-data-list .db-active{border-color: #2dc3e8;}
</style>
<link href="/assets/css/style.css" rel="stylesheet" />
</head>
<body>

<!--=================右侧内容区================= -->
     <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">促销申请</a>
        </div>

        <div class="page_content bg_gray search_box">
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav">
                        <li data-val="0" name="tabs"><a href="#" class="active" id="tab0">促销申请</a></li>
                       <!--  <li data-val="1" name="tabs"><a href="#" class="" id="tab1">已取消</a></li> -->
                    </ul>
                </div>
                <div class="tab_content" style="padding-top:5px;">
                  <form class="search_form" method="post" id="search-condition" action="">
                      <div class="search_form_box clear">
                        <!--  <div class="search_group">
                                   <label>促销类型:</label>
                                   <input type="text" id="sales_name" name="sales_name" class="search_input"  style="width:150px;" />
                            </div>  --> 
                            <div class="search_group">
                                    <label>线路编号:</label>
                                    <input type="text" id="linecode" name="linecode" class="search_input"  style="width:150px;"/>
                            </div>
       
 							<div class="search_group">
                                    <label>促销线路标题:</label>
                                    <input type="text" id="sch_sn" name="sales_name" class="search_input"  style="width:200px;" />
                            </div>
                            
                            <div class="search_group">
                              <input type="button" name="submit" class="search_button" id="searchBtn0" value="搜索"/>
                              <input type="button" name="button" class="search_button" id="add_sales" onclick="add_sales_box()" value="增加"/>
                            </div>
                      </div>
                    </form>
                    <div class="table_list" id="list"></div>
                </div>
            <!--   <div class="tab_content1" style="padding-top:5px;display:none">
                  <form class="search_form" method="post" id="search-condition" action="">
                      <div class="search_form_box clear">
                            <div class="search_group">
                                    <label>线路编号:</label>
                                    <input type="text" id="linecode" name="linecode" class="search_input"  style="width:150px;"/>
                            </div>
       
 							<div class="search_group">
                                    <label>促销线路标题:</label>
                                    <input type="text" id="sch_sn" name="sales_name" class="search_input"  style="width:200px;" />
                            </div>
                            
                            <div class="search_group">
                              <input type="button" name="submit" class="search_button" id="searchBtn1" value="搜索"/>
                            </div>
                      </div>
                    </form>
                    <div class="table_list" id="list1"></div>
                </div> -->  
            </div>
        </div>
    </div>

<!--分页-->
    <!-- 添加促销申请 -->
   <div class="fb-content" id="sales_data" style="display:none;" >
    <div class="box-title">
        <h4 class="s_order_data">促销申请</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                    <tr style="height:40px">
                        <td class="order_info_title"><i class="important_title">*</i>选择线路:</td>
                        <td colspan="3">
                           <input type="text" name="" value="" class="search_input" id="clickChoiceLine"  onclick="get_ChoiceLine()" style="width:337px;"/>
                       	   <input type="hidden" name="line_id" value="" class="search_input" id="line_id" />
                        </td>

                    </tr>
                    <tr style="height:40px">
                        <td class="order_info_title"><i class="important_title">*</i>促销标题:</td>
                        <td colspan="3">
                           <input type="text" name="lineName" value="" class="search_input" style="width:337px;"/>
                        </td>
                    </tr>    
                    <tr style="height:40px">
                        <td class="order_info_title"><i class="important_title">*</i>促销图片:</td>
                        <td colspan="3">
                                           
	                        <div class="row fileupload-buttonbar" style="padding-left:15px;width:700px;">
							<div class="thumbnail col-sm-6">
							<img id="weixin_show" style="height:180px;margin-top:10px;margin-bottom:8px;"  src="" data-holder-rendered="true" />
						<!--<div class="progress progress-striped active" role="progressbar" aria-valuemin="10" aria-valuemax="100" aria-valuenow="0"><div id="progress" class="progress-bar progress-bar-success" style="width:0%;"></div></div>  -->	
							<div class="caption" align="center">
							<span id="weixin_upload" class="btn btn-primary fileinput-button" style="margin-left:60px;">
							<span class="up_img">上传</span>
							 <input id="fileupload" type="file" name="weixin_image" multiple />
							 <input id="salse_pic" type="hidden" name="salse_pic"  />
							<!-- <input type="file" id="weixin_image" name="weixin_image" multiple /> -->
							</span>  <span>452 * 280</span>
							 <a id="weixin_cancle" href="javascript:void(0)" type="reset"  class="btn btn-warning cancel" role="button" onclick="cancleUpload('weixin')" style="display:none">删除</a> 
							</div>
							</div>
							</div>
							             
                        </td>
                    </tr> 
               <!--    <tr style="height:40px">
                        <td class="order_info_title">排序:</td>
                        <td colspan="3"><input type="text" name="sort" value="100" class="search_input"  style="width:250px;" readonly />
                        <span>排序字段越大越前</span>
                        </td>
                    </tr> -->  

                </table>
            </div>
            <div class="form_btn clear" >
                  <input type="button" value="保存 并 下一步" class="btn btn_blue" id="ref_order_btn" style="margin-left:210px;"  onclick="sub_sales()" />
                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  />
            </div>
        </form>
    </div>
</div>

    <!-- 编辑促销申请 -->
   <div class="fb-content" id="edit_sales_data" style="display:none;" >
    <div class="box-title">
        <h4 class="s_order_data">促销申请</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="edit_sales_line" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                   <tr style="height:40px">
                        <td class="order_info_title"><i class="important_title">*</i>选择线路:</td>
                        <td colspan="3">
                          <span id="edit_line"></span>
                          <!-- <input type="text" name="edit_line" value="" class="search_input" id="clickChoiceLine"  onclick="get_ChoiceLine()" style="width:250px;"/> --> 
                       	   <input type="hidden" name="edit_line_id" value="" class="search_input" id="edit_line_id" />
                        </td>

                   </tr>
                   <tr style="height:40px">
                        <td class="order_info_title"><i class="important_title">*</i>促销标题:</td>
                        <td colspan="3">
                           <input type="text" name="edit_lineName" value="" class="search_input" style="width:337px;"/>
                        </td>
                   </tr>   
                   <tr style="height:40px">
                        <td class="order_info_title"><i class="important_title">*</i>促销图片:</td>
                        <td colspan="3">
                                           
                        <div class="row fileupload-buttonbar" style="padding-left:15px;width:700px;">
						<div class="thumbnail col-sm-6">
						<img id="weixin_show" class="edit_weixin_show" style="height:180px;margin-top:10px;margin-bottom:8px;"  src="" data-holder-rendered="true" />
						<!--  <div class="progress progress-striped active" role="progressbar" aria-valuemin="10" aria-valuemax="100" aria-valuenow="0"><div id="progress" class="progress-bar progress-bar-success" style="width:0%;"></div></div>-->
						<div class="caption" align="center">
						<span id="weixin_upload" class="btn btn-primary fileinput-button" style="margin-left:60px;">
						<span>重新上传</span>
						 <input id="edit_fileupload" type="file" name="weixin_image" multiple />
						 <input id="edit_salse_pic" type="hidden" name="edit_salse_pic"  />
						<!-- <input type="file" id="weixin_image" name="weixin_image" multiple /> -->
						</span><span>452 * 280</span>
						 <a id="weixin_cancle" href="javascript:void(0)" type="reset"  class="btn btn-warning cancel" role="button" onclick="cancleUpload('weixin')" style="display:none">删除</a> 
						</div>
						</div>
						</div>
                        
                        </td>
                    </tr> 

                </table>
            </div>
            <div class="form_btn clear" >
                  <input type="button" value="确认" class="btn btn_blue" id="ref_order_btn" style="margin-left:210px;"  onclick="edit_sales()" />
                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="edit_refuse" style="margin-left:80px;"  />
            </div>
        </form>
    </div>
</div>
<!-- 选择线路 -->
<div class="choice-box-line" style="z-index:19891099;">
	<div class="cb-body">
		<h3 class="cb-title">选择线路</h3>
		<div class="cb-colse db-cancel">x</div>
		<div class="cb-search">
			<span class="cb-prompt"><!--已选择不可更改的信息提示--></span>
			<form action="#" method="post" id="cb-search-form">
				<input type="text" name="keyword" placeholder="关键词" />
				<span id="cb-choice-city"></span>
				<input type="hidden" name="page_new" value="1" />
				<input type="hidden" name="city_id" value="" />
				<input type="hidden" name="dest_id" value="" />
				<input type="hidden" name="themeId" value="" />
				<input type="submit" value="搜索" id="db-submit" />
			</form>
		</div>
		<div class="db-data-list">
		    <ul class="db-data-line">
		 	</ul>
			<div class="db-pagination page-button">分页</div>
		</div>
		
		<div class="db-button">
			<div class="db-cancel">取消</div>
			<div class="db-submit line-submit">确认选择</div>
		</div>
	</div>
</div>

<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<!---->
 <link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

<?php echo $this->load->view('admin/b1/common/user_message_script'); ?>

<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
//-------------------------------------------数据列表--------------------------------------------------------
jQuery(document).ready(function(){
  var page=null;
  // 查询
  jQuery("#searchBtn0").click(function(){
    page.load({"status":"0"});
  });
  var data = '<?php echo $pageData; ?>';
  page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/sales_apply/indexData",form : '#search-condition',// 绑定一个查询表单的ID
        columns : [
          {field : 'linecode',title : '线路编号',width : '60',align : 'center'},
          {field : 'sale_name',title : '促销线路标题',align : 'left',sortable : true,width : '150',
              formatter : function(value,rowData, rowIndex){
            	  return rowData.sale_name;
               },
          },
          {field : 'startcity',title : '出发地',align : 'center', width : '100'},
          {field : 'sort',title : '排序',align : 'center', width : '100'},
          {field : '',title : '审核状态',align : 'center', width : '100',
        	  formatter : function(value,rowData, rowIndex){
            	  if(rowData.status==1){
                	  return '审核中'; 
                  }else if(rowData.status==2){
                	  return '已上线'; 
                  }else if(rowData.status==0){
                	  return '未提交'; 
                  }else if(rowData.status==3){
                	  return '已退回'; 
                  }else if(rowData.status==4){
                	  return '已停售'; 
                  }else if(rowData.status=='-1'){
                	  return '已删除'; 
                  }
              }
          },
          {field : '',title : '操作',align : 'center',width : '100',
                formatter : function(value,rowData, rowIndex){
                       var str='';  
                       str=str+'<a href="#" line-value="'+rowData.linename+'" line-id="'+rowData.lineid+'"  onclick="set_sales_price(this)" >设置价格<a>&nbsp;&nbsp;&nbsp;';
                       str=str+'<a href="#" line-id="'+rowData.lineid+'"  onclick="edit_sales_price(this)" >编辑<a>&nbsp;&nbsp;&nbsp;';
                       str=str+'<a href="#" line-id="'+rowData.lineid+'"  onclick="cancel_sales(this)" >删除<a>';
                       return str;
                }
           }
        ]
  });
//------------------------------取消的促销申请----------------------------------
/* var page1=null;
	function initTab1(){
	// 查询
	 jQuery("#searchBtn1").click(function(){
		page1.load({"status":"1"});
	});
 	 page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/sales_apply/indexData",form : '#search-condition',// 绑定一个查询表单的ID
     	 	 columns : [
                  {field : 'linecode',title : '线路编号',width : '60',align : 'center'},
                  {field : 'sale_name',title : '促销线路标题',align : 'left',sortable : true,width : '150',
                      formatter : function(value,rowData, rowIndex){
                    	  return rowData.sale_name;
                       },
                  },
                  {field : 'startcity',title : '出发地',align : 'center', width : '100'},
                  {field : 'sort',title : '排序',align : 'center', width : '100'},
                  {field : '',title : '审核状态',align : 'center', width : '100',
                	  formatter : function(value,rowData, rowIndex){
                    	  if(rowData.status==1){
                        	  return '审核中'; 
                          }else if(rowData.status==2){
                        	  return '已上线'; 
                          }else if(rowData.status==0){
                        	  return '未提交'; 
                          }else if(rowData.status==3){
                        	  return '已退回'; 
                          }else if(rowData.status==4){
                        	  return '已停售'; 
                          }else if(rowData.status=='-1'){
                        	  return '已删除'; 
                          }
                      }
                  },
                  {field : '',title : '操作',align : 'center',width : '100',
                        formatter : function(value,rowData, rowIndex){
                               var str='';
                               str=str+'<a href="#" line-id="'+rowData.lineid+'"  onclick="edit_sales_price(this)" >编辑<a>&nbsp;&nbsp;&nbsp;';
                               str=str+'<a href="#" line-value="'+rowData.linename+'" line-id="'+rowData.lineid+'"  onclick="set_sales_price(this)" >设置价格<a>&nbsp;&nbsp;&nbsp;';
                               str=str+'<a href="#" line-id="'+rowData.lineid+'"  onclick="cancel_sales(this)" >取消<a>';
                                return str;
                        }
                   }
                ]
          });
	}*/
      jQuery('#tab0').click(function(){
            jQuery('#tab1').removeClass('active');
            jQuery(this).addClass('active');
            jQuery('.tab_content').css('display','block');
            jQuery('.tab_content1').css('display','none');
            page.load({"status":"0"});
      });
/*       jQuery('#tab1').click(function(){
         // jQuery('.tab-pane').removeClass('active');
          jQuery('#tab0').removeClass('active');
          jQuery(this).addClass('active');
          jQuery('.tab_content1').css('display','block');
          jQuery('.tab_content').css('display','none');
          if(null==page1){
  			initTab1();
  		  }
  		  page1.load({"status":"1"});
    }); */

});


//-------------------选择线路---------------------------
/* $('#clickChoiceLine').click(function(){
	createLineHtml();
}) */
function get_ChoiceLine(){
	createLineHtml();
}
	function createLineHtml() {
		$.ajax({
				url:'/admin/b1/sales_apply/getLineJson',
				type:'post',
				dataType:'json',
				data:$("#cb-search-form").serialize(),
				success:function(data){
					if ($.isEmptyObject(data.list)) {
						$(".db-pagination").html('');
						$(".db-data-line").html('<div class="db-msg">暂无数据</div>');
						$(".line-submit").css('display','none');
						//$(".db-cancel").css('display','none');
					} else {
						$(".line-submit").css('display','block');
						//$(".db-cancel").css('display','block');
						var html = '';
						$.each(data.list ,function(key ,val){
							var overcity = val.overcity.split(',');
                             // 将cj和gn改为line,添加后缀.html
							// var url = $.inArray('1' ,overcity) == -1 ? '/gn/'+val.lineid : '/cj/'+val.lineid;
                               var url = $.inArray('1' ,overcity) == -1 ? '/line/'+val.lineid + '.html' : '/line/'+val.lineid + '.html';
							if (key % 2 == 1) {
								html += '<li class="db-data-row row-odd" data-val="'+val.lineid+'" data-name="'+val.linename+'">';
							} else {
								html += '<li class="db-data-row" data-val="'+val.lineid+'" data-name="'+val.linename+'">';
							}
							html += '<div class="db-data-pic"><img src="'+val.mainpic+'" /></div>';
							html += '<ul><li>';
							//html += '<div class="db-row-title">线路名：</div><div class="db-row-content"><a href="'+url+'" target="_blank" >'+val.linename+'</a></div>';
							html += '<div class="db-row-title">线路名：</div><div class="db-row-content"><a href="javascript:void(0);">'+val.linename+'</a></div>';
							html += '</li><li>';
							html += '<div class="db-row-title">供应商：</div><div class="db-row-content">'+val.company_name+'</div>';	
							html += '</li><li>';		
							html += '<div class="db-row-title">始发地：</div><div class="db-row-content">'+val.cityname+'<span style="float:right;margin-right:10px;color: #ff0000;">¥'+val.s_price+'</span></div>';			
							html += '</li></ul></li>';	
						})
								
						$(".db-data-line").html(html);
					}
			
					$(".db-pagination").html(data.page_string);
					rowClick();
					pageClick();
					if ($(".choice-box-line").is(':hidden')) {
						$(".choice-box-line").show();
					}
					$('html,body').animate({scrollTop:0}, 'slow');
				}
			});
	}
	function rowClick() {
		$(".db-data-row").click(function(){
			$('.db-data-line').find(".db-active").css("border-color","#ccc");
			if ($(this).hasClass('db-active')) {
				$(this).removeClass('db-active');
			} else {
				$(this).addClass('db-active').siblings().removeClass('db-active');
			}
			$('.db-data-line').find(".db-active").css("border-color","#2dc3e8");

		})
	}
	function pageClick(){
		$(".db-pagination").find('li').click(function(){
			if (!$(this).hasClass('active')){
				$("#cb-search-form").find('input[name=page_new]').val($(this).find('a').attr('page_new'));
				createLineHtml();
			}
		})
	}
	$("#cb-search-form").submit(function(){
		$("#cb-search-form").find('input[name=page_new]').val(1);
		createLineHtml();
		return false;
	})
	$(".db-cancel").click(function(){
		$(".choice-box-line").hide();
	})
	//线路详情
	function see_detail(id){	
		layer.open({
			title:'线路详情',
			type: 2,
			area: ['1000px', '90%'],
			fix: false, //不固定
			maxmin: true,
			content: "<?php echo base_url('admin/a/lines/line/detail');?>"+"?id="+id+"&type=1"
		});
	}
	//var formObj = $(".choice-box-line");
	 $('.line-submit').click(function(){
			var activeObj = $('.db-data-line').find('.db-active');
			$('#clickChoiceLine').val(activeObj.attr('data-name'));
			$('input[name=line_id]').val(activeObj.attr('data-val'));
			$(".choice-box-line").hide();
			$('input[name="lineName"]').val(activeObj.attr('data-name'));

			
	}) 
	
	 //-------------------选择线路end---------------------------
	 
 
 //------促销线路申请-------
 function add_sales_box(){
	$('#sales_data').find('.up_img').html('上传');
	$('#sales_data').find('#clickChoiceLine').val('');
	$('#sales_data').find('input[name="line_id"]').val('');
	$('#sales_data').find('input[name="lineName"]').val('');
	$('#sales_data').find("#weixin_show").attr("src",'');
//	$('#sales_data').find(".weixin_show").attr("src",'');
	   layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: ['800px', '70%'],
           shadeClose: false,
           content: $('#sales_data')
    }); 
		   
 }
//------编辑线路申请-------
function edit_sales_price(obj){
	var lineId=$(obj).attr('line-id');
	 layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: ['800px', '70%'],
           shadeClose: false,
           content: $('#edit_sales_data')
    });

     jQuery.ajax({ type : "POST",async:false,data : { 'lineId':lineId},url : "<?php echo base_url()?>admin/b1/sales_apply/get_sales_data", 

         success : function(result) { 
        	  result = eval('('+result+')');
	       	  if(result.status==1){
		       
	              $('#edit_line').html(result.data.linename); 
	              $('input[name="edit_line_id"]').val(result.data.lineId); 
	              $('input[name="edit_lineName"]').val(result.data.lineName); 
	          	  $(".edit_weixin_show").attr("src",result.data.pic);
		    	  $("input[name='edit_salse_pic']").val(result.data.pic);
		    	  $('input[name="edit_sort"]').val(result.data.sort);
		    	 // $('input[name="lineName"]').val(result.data.sort); 
	         }else{
	               alert('获取数据失败');
	         } 
         }
     });
	     
}

//提交促销线路
function sub_sales(){
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#apply-data').serialize(),url : "<?php echo base_url()?>admin/b1/sales_apply/add_line_sales", 
		success : function(response) {
			var obj = eval('(' + response + ')');
			if(obj.stauts=='1'){
				layer.msg(obj.msg, {icon: 1});
				$("#tab0").click();
				$('#refuse').click();
				//var linename=$(obj).attr('line-value');
				//var lineId=$(obj).attr('line-id');
				
				lineId=obj.data.lineId;
				linename=obj.data.linename;
				layer.open({
					title:linename,
					type: 2,
					area: ['1200px', '80%'],
					fix: false, //不固定
					maxmin: true,
					content: "<?php echo base_url('admin/b1/sales_apply/get_line_price');?>"+"?lineId="+lineId
				});
					
			}else{
				layer.msg(obj.msg, {icon: 2});
			}
		}
	})
}
//编辑促销线路
function edit_sales(){
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#edit_sales_line').serialize(),url : "<?php echo base_url()?>admin/b1/sales_apply/edit_line_sales", 
		success : function(response) {
			var obj = eval('(' + response + ')');
			if(obj.stauts=='1'){
				layer.msg(obj.msg, {icon: 1});
				//window.location.reload();
				$("#tab0").click();
				$("#edit_refuse").click();
			}else{
				layer.msg(obj.msg, {icon: 2});
			}
		}
	})
}

//设置促销价
function set_sales_price(obj){
	var linename=$(obj).attr('line-value');
	var lineId=$(obj).attr('line-id');

	layer.open({
		title:linename,
		type: 2,
		area: ['1200px', '80%'],
		fix: false, //不固定
		maxmin: true,
		content: "<?php echo base_url('admin/b1/sales_apply/get_line_price');?>"+"?lineId="+lineId
	});
}
//选择图片
 $(function() {
	 //添加
	   $("#fileupload").fileupload({
	        url: '/admin/b1/sales_apply/uploadImg',
	        dataType: 'json',
	        autoUpload: true,
	        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
	        maxFileSize: 999000,
	        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
	        imageMaxWidth: 452,
	        imageMaxHeight: 280,
	        imageCrop: true,
	      //  sequentialUploads: true,
	        
	    }).bind('fileuploadprogress', function (e, data) {
	    	var progress = parseInt(data.loaded / data.total * 100, 10);
	    	//$("#progress").css('width',progress + '%');
	    	//$("#progress").html(progress + '%');
	    }).bind('fileuploaddone', function (e, data) {
	    	alert('上传成功!');
	    	$("#weixin_show").attr("src",data.result.msg);
	    	$("input[name='salse_pic']").val(data.result.msg);
	    	$(".up_img").html("重新上传");
	    	/* $("#weixin_upload").css({display:"none"});
	    	$("#weixin_cancle").css({display:""}); */
	    });  
       //编辑
	   $("#edit_fileupload").fileupload({
	        url: '/admin/b1/sales_apply/uploadImg',
	        dataType: 'json',
	        autoUpload: true,
	        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
	        maxFileSize: 999000,
	        disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
	        imageMaxWidth: 452,
	        imageMaxHeight: 280,
	        imageCrop: true,
	      //  sequentialUploads: true,
	        
	    }).bind('fileuploadprogress', function (e, data) {
	    	var progress = parseInt(data.loaded / data.total * 100, 10);
	    //	$("#progress").css('width',progress + '%');
	    //	$("#progress").html(progress + '%');
	    }).bind('fileuploaddone', function (e, data) {
	    	alert('上传成功!');
	    	$(".edit_weixin_show").attr("src",data.result.msg);
	    	$("input[name='edit_salse_pic']").val(data.result.msg);
	    	/* $("#weixin_upload").css({display:"none"});
	    	$("#weixin_cancle").css({display:""}); */
	    }); 
	    
}); 

 //取消售卖
 function cancel_sales(obj){
	 var lineId=$(obj).attr('line-id');
	 layer.confirm('您确定要删除该促销线路?', {btn:['确认' ,'取消']},function(){
	    jQuery.ajax({ type : "POST",async:false,data : { 'lineId':lineId},url : "<?php echo base_url()?>admin/b1/sales_apply/cancel_sales_data", 
	         success : function(result) { 
	        	 result = eval('('+result+')');
		       	 if(result.status==1){
		       		$("#tab0").click();
		       		layer.msg('操作成功', {icon: 1});
		         }else{
		        	 layer.msg('操作失败', {icon: 2});
		         } 
	         }
	     });
	 });     
 }
</script>
</html>
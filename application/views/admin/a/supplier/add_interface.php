<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>付款申请单</title>
<!--startprint1-->
<style type="text/css">

/*分割线 :p*/
.p_warp{
height:32px;line-height:20px;background:#fff;float:left;width:80%;margin-top:0px;color:#000000;
}
.p_warp font{margin-right:50px;color: #000;font-family: tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif;}

.p_total{
height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:8px;font-weight:bold !important;
}

.p_expert{height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:15px;
}
.p_expert font{margin-right:20%;}


.not-allow{cursor:not-allowed !important;opacity:0.5;}

.search_group{margin:0 10px 10px 10px !important;}
.search_group label{width:auto !important;}




/**/
fieldset{margin-bottom:10px;border:1px solid #dcdcdc;}
.p_line{height:16px;line-height:16px;border-left:3px solid #000;padding-left:5px;margin:5px 0;font-weight:bold !important;}
.header_div{float:left;width:100%;border-bottom:2px solid #000;margin-bottom:5px;padding-bottom:5px;display:none;}
.header_div .p1{width:30%;float:left;}
.header_div .p2{width:40%;float:left;text-align:center;font-size:18px;font-weight:bold !important;}
.header_div .p3{width:30%;float:left;text-align:right;}

.footer_div{float:left;width:100%;margin-bottom:5px;margin-top:20px;display:none;}
.footer_div .p1,.footer_div .p2{width:75%;float:left;text-align:right;margin:10px 0;}

.notice{background:red;}

</style>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content_detail bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="tab_content" id="printf_div" style="padding-top: 5px;">
                  
                    <!-- 使用明细 -->
                    <div class="table_list">
                        <form action="#" id='search-condition' class="form-horizontal"  method="post" >
                            <div class="search_form_box clear" style="padding-top: 4px;width:auto;">
                            
                                <div class="search_group">
                                    <label>供应商名称</label>
                                    <input type="text" id="supplier_name" name="supplier_name" placeholder="供应商名称"  class="search_input" style="float: none;width:150px;" /> 
                                    
                                </div>
                                <div class="search_group" style="margin:0 10px 0 0px !important;">
                                    <label>负责人</label>
                                    <input type="text" id="mobile" name="realname" class="search_input" placeholder="手机号" style="width:150px;"/>
                                </div>
                                <div class="search_group" style="margin:0 10px 0 0px !important;">
                                    <label>手机号</label>
                                    <input type="text" id="mobile" name="mobile" class="search_input" placeholder="手机号" style="width:150px;"/>
                                </div>
                                <div class="search_group" style="margin:0 10px 0 0px !important;">
                                    <label>供应商品牌</label>
                                    <input type="text" id="brand" name="brand" class="search_input" placeholder="供应商品牌" style="width:120px;"/>
                                </div>

                               <!-- 搜索按钮 -->
                                <div class="search_group">
                                    <input type="hidden" id="status" name="status"  value="1"/>
                                    <input type="submit" id="btn_submit" name="submit" style="margin-left: 0;" class="search_button" value="搜索"/>
                                </div>

                            </div>
                        
                  		<div id="dataTable"></div>

                      
                        <div class="form-group"><input type="button" class="fg-but btn_two btn_refuse"  id="add_data" value="通过" /> </div>
                         </form>                  
                    </div>  
                                  
                </div>
             
			</div>
        </div>
        
    </div>


<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

<script type="text/javascript">
//申请中
var columns = [ 
		{field : null,title : '',width : '40',align : 'left',
			formatter: function(item){
				return '<input name="is_check[]" type="checkbox" value="'+item.id+'" />';
			}	
		},
        {field : 'company_name',title : '供应商名称',width : '300',align : 'left'},
		{field : 'brand',title : '品牌名称',width : '140',align : 'center'},
		{field : 'realname',title : '负责人',align : 'center', width : '90'},
		{field : 'mobile',title : '联系电话',align : 'center', width : '100'},
		{field : null,title : '所在地',width : '200',align : 'left',formatter:function(item){
			var address = item.country+item.province+item.city;
				return typeof address == 'string' ? address.replace('null' ,'') : address;
		}
	}
	];

$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/supplier/get_supplier_data',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});


//搜索栏商家名字下拉
$.post('/admin/a/comboBox/get_supplier_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.company_name,
		    value : val.id,
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#supplier_name",
	    name : "supplier_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})

//生成供应商对接数据

$("#add_data").click(function(){
    jQuery.ajax({ type : "POST",async:false,data : jQuery('#search-condition').serialize(),url : "<?php echo base_url()?>admin/a/supplier/add_supplier_secret", 
    	success : function(response) {
    		var obj = eval('(' + response + ')');	
     		if(obj.code=='200'){
        		alert(obj.msg);
        		var index = parent.layer.getFrameIndex(window.name); //获取窗口索
       			parent.layer.close(index);
        	}else{
            	
        		alert(obj.msg);
            }  
        }
    	
     });

});

</script>

</html>




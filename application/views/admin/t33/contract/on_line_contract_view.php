<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.img-content img{max-width:150px;}
.show_select
</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
<?php $this->load->view("admin/t33/common/dest_tree"); //加载树形目的地   ?>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>合同发票管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">在线合同管理</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul>
		                <li data-val="9"><a class="active" href="###">申请合同</a></li>
		                <li data-val="1"><a href="###">签署中</a></li>
		                <li data-val="2"><a href="###">已签署</a></li>
		                <li data-val="3"><a href="###">已核销</a></li>
		                <li data-val="-1"><a href="###">申请作废中</a></li>
		                <li data-val="4"><a href="###">已作废</a></li>
		            </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                    	 <form id='search-condition' class="search_form" method="post">
		               		<div class="search_form_box clear">
				                <div class="search_group launch-contract">
				                    <label>合同号:</label>
				                    <input class="search_input" type="text" name="contract_code" style="width:100px" />
				                </div>
				                <div class="search_group launch-contract">
		                            <label>客户:</label>
		                            <input type="text"  name="guest_name" class="search_input" style="width:107px;"/>
		                        </div>
				                <div class="search_group launch-contract">
		                            <label>订单号:</label>
		                            <input type="text"  name="ordersn" class="search_input" style="width:107px;"/>
		                        </div>
		                        <div class="search_group">
		                            <label class="name-title">申请人:</label>
		                            <input type="text"  name="expert_name" class="search_input" style="width:107px;"/>
		                        </div>
		                        <div class="search_group">
				                    <label class="time-title">申请日期:</label>
				                    <input class="search_input starttime" style="width:90px;" type="text" placeholder="开始时间"  name="starttime" />
				                    <label style="border:none;width:auto;">-</label>
				                    <input class="search_input endtime" style="width:90px;" type="text" placeholder="结束时间"  name="endtime" />
				                </div>
				           		<div class="search_group">
				           			<input type="hidden" name="status" value="9" />
                                    <input type="submit" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                    <input type="button" id="union-chapter" class="search_button" value="公章管理"/>
                                </div>
				            </div>
		                </form>
                        <div id="dataTable"></div>
                    </div>                   
                </div>
                
            </div>

        </div>
        
    </div>


<div class="fb-content" id="apply-abandoned" style="display:none;">
    <div class="box-title">
        <h4>确认作废</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
    <div class="fb-form">
    <form  class="form-horizontal" action="#" id='apply-form' method="post">
    	<div class="form-group">
        	<div class="fg-title">作废理由:</div>
        	<div class="fg-input">
        		<textarea style="width: 85%;" name="remark" rows="5" ></textarea>
        	</div>
        </div>
    	<div class="form-group">
        	<input type="hidden" name="id" />
            <input type="button" class="fg-but layui-layer-close" value="取消" />
            <input type="submit" class="fg-but submit_employee" value="确定" />
        </div>
	</form>
    </div>
</div>


<div class="fb-content" id="apply-contract" style="display:none;">
    <div class="box-title">
        <h4>审核管家合同申请</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
    <div class="fb-form">
    <form  class="form-horizontal" action="#" id='apply-contract-form' method="post">
    	<div class="form-group">
        	<div class="fg-title">申请理由:</div>
        	<div class="fg-input">
        		<textarea style="width: 85%;" disabled="disabled" name="reason" rows="5" ></textarea>
        	</div>
        </div>
        <div class="form-group refuse-text">
        	<div class="fg-title">拒绝理由:</div>
        	<div class="fg-input">
        		<textarea style="width: 85%;" name="remark" rows="5" ></textarea>
        	</div>
        </div>
    	<div class="form-group">
        	<input type="hidden" name="id" />
        	<input type="hidden" name="type"  />
            <input type="button" class="fg-but layui-layer-close" value="取消" />
            <input type="submit" class="fg-but submit_employee" value="确定" />
        </div>
	</form>
    </div>
</div>


<div class="fb-content" id="official-seal" style="display:none;">
    <div class="box-title">
        <h4>公章管理</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="official-seal-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">公章：<i>*</i></div>
                <div class="fg-input">
                	<input type="file" name="fileinput" id="fileinput" onchange="uploadPic(this);" />
                	<input type="hidden" name="pic" value="<?php echo empty($chapterData['union_chapter']) ? '' : $chapterData['union_chapter'];?>" />
                </div>
                <div style="margin: 40px 0px 20px 96px;" class="img-content">
                	<?php if(!empty($chapterData['union_chapter'])):?>
                	<img src="<?php  echo $chapterData['union_chapter'];?>" />
                	<?php endif;?>
                </div>
            </div>
            <div class="form-group">
                <input type="button" class="fg-but layui-layer-close" value="取消" />
                <input type="submit" class="fg-but" value="确定" />
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript">
$('#union-chapter').click(function(){
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#official-seal')
	});
})

$('#official-seal-form').submit(function(){
	$.ajax({
		url:'/admin/t33/sys/onLineContract/updateChapter',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

function uploadPic () {
	$.ajaxFileUpload({
	    url : '/admin/upload/uploadImgFile',
	    secureuri : false,
	    fileElementId : 'fileinput',// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : {
	    	fileId : 'fileinput'
	    },
	    success : function(data, status) {
		    if (data.code == 2000) {
		    	$('input[name=pic]').val(data.msg);
		    	if ($('.img-content').find('img').length) {
		    		$('.img-content').find('img').attr('src',data.msg);
			    } else {
			    	$('.img-content').append('<img src="'+data.msg+'" />');
				}
		    } else {
			    alert(data.msg);
		    }
	    },
	    error : function(data, status, e)// 服务器响应失败处理函数
	    {
		    alert('上传失败(请选择jpg/jpeg/png的图片重新上传)');
	    }
	});
}


function seeApply(obj ,type) {
	$('#apply-contract-form').find('input[name=id]').val($(obj).attr('data-id'));
	$('#apply-contract-form').find('input[name=type]').val(type);
	$('#apply-contract-form').find('textarea[name=reason]').val($(obj).attr('data-reason'));
	$('#apply-contract-form').find('textarea[name=remark]').val('');
	if (type == 2) {
		$('.refuse-text').show();
	} else {
		$('.refuse-text').hide();
	}
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#apply-contract')
	});
}

$('#apply-contract-form').submit(function(){
	$.ajax({
		url:'/admin/t33/sys/onLineContract/toExamineApply',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == '2000') {
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
				tabData(9);
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

//申请合同
var columns9 = [{field : 'addtime',title : '申请日期',width : '130',align : 'left'},
                {field : false,title : '合同类型',width : '80',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : false,title : '申请份数',width : '80',align : 'center',formatter:function(result) {
						return '<span style="color:red;">'+result.num+'</span>/份';
                    }
                },
                {field : false,title : '状态',width : '70',align : 'center' ,formatter:function(result) {
						if (result.status == 0) {
							return '申请中';
						} else if(result.status == 1) {
							return '已通过';
						} else if (result.status == 2) {
							return '<span style="color:red;">已拒绝</span>';
						}
                    }
                },
                {field : false,title : '已使用',width : '70',align : 'center' ,formatter:function(result) {
						return result.use_num+'/份';
                    }
                },
                {field : 'start_code',title : '开始编号',width : '90',align : 'center'},
                {field : 'end_code',title : '结束编号',width : '90',align : 'center'},
                {field : 'expert_name',title : '申请人',width : '90',align : 'center'},
                {field : 'depart_name',title : '申请部门',width : '130',align : 'center'},
                {field : 'employee_name',title : '审核人',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '100', formatter: function(result) {
                    	if (result.status == 0) {
                    		var button = '<a href="javascript:void(0);" data-reason="'+result.reason+'" data-id="'+result.id+'" onclick="seeApply(this ,1)">通过</a>&nbsp;';
                    		button += '<a href="javascript:void(0);" data-reason="'+result.reason+'" data-id="'+result.id+'"  onclick="seeApply(this ,2)">拒绝</a>';
        	                return  button;
                        } else {
                            return '';
                        }
                	}
    			}];


//签署中
var columns1 = [{field : 'addtime',title : '发起日期',width : '140',align : 'left'},
            {field : false,title : '合同类型',width : '90',align : 'center',formatter:function(result) {
					return result.type == 1 ? '出境游' : '国内游';
                }
            },
            {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
            {field : 'guest_name',title : '客人姓名',width : '90',align : 'center'},
            {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
            {field : 'num',title : '合同人数',width : '90',align : 'center'},
            {field : 'expert_name',title : '发起人',width : '90',align : 'center'},
            {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
            {field : false,title : '操作', align : 'center',width : '100', formatter: function(result) {
                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>&nbsp;';
                	button += '<a href="/pdf/contract_pdf/createContractPdf?id='+result.id+'" target="_blank">下载合同</a>';
	                return  button;
            	}
			}];
//已签署			
var columns2 = [{field : 'addtime',title : '发起日期',width : '140',align : 'left'},
                {field : 'write_time',title : '签署时间',width : '140',align : 'left'},
                {field : false,title : '合同类型',width : '90',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
                {field : 'guest_name',title : '客人姓名',width : '90',align : 'center'},
                {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
                {field : 'num',title : '合同人数',width : '90',align : 'center'},
                {field : 'expert_name',title : '发起人',width : '90',align : 'center'},
                {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '100', formatter: function(result) {
	                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>&nbsp;';
	                	button += '<a href="javascript:void(0);" onclick="writeOff('+result.id+')">核销</a>';
	                	button += '<a href="/pdf/contract_pdf/createContractPdf?id='+result.id+'" target="_blank">下载合同</a>';
		                return  button;
                	}
    			}];
//已核销
var columns3 = [{field : 'addtime',title : '发起日期',width : '140',align : 'left'},
                {field : 'confirm_time',title : '核销时间',width : '140',align : 'left'},
                {field : false,title : '合同类型',width : '90',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
                {field : 'guest_name',title : '客人姓名',width : '90',align : 'center'},
                {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
                {field : 'num',title : '合同人数',width : '90',align : 'center'},
                {field : 'expert_name',title : '发起人',width : '90',align : 'center'},
                {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '100', formatter: function(result) {
	                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>&nbsp;';
	                	button += '<a href="/pdf/contract_pdf/createContractPdf?id='+result.id+'" target="_blank">下载合同</a>';
		                return  button;
                	}
    			}];
//已作废
var columns4 = [{field : 'addtime',title : '发起日期',width : '140',align : 'left'},
                {field : 'cancel_time',title : '作废时间',width : '140',align : 'left'},
                {field : false,title : '合同类型',width : '90',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
                {field : 'guest_name',title : '客人姓名',width : '90',align : 'center'},
                {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
                {field : 'num',title : '合同人数',width : '90',align : 'center'},
                {field : 'expert_name',title : '发起人',width : '90',align : 'center'},
                {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '100', formatter: function(result) {
	                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>';
		                return  button;
                	}
    			}];   
//作废中
var columns5 = [{field : 'addtime',title : '发起日期',width : '140',align : 'left'},
                {field : 'cancel_time',title : '申请作废时间',width : '140',align : 'left'},
                {field : false,title : '合同类型',width : '90',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
                {field : 'guest_name',title : '客人姓名',width : '90',align : 'center'},
                {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
                {field : 'num',title : '合同人数',width : '90',align : 'center'},
                {field : 'expert_name',title : '发起人',width : '90',align : 'center'},
                {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '100', formatter: function(result) {
	                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>&nbsp;';
	                	button += '<a href="javascript:void(0);" onclick="abandoned('+result.id+' ,\''+result.remark+'\')">确认作废</a>';
		                return  button;
                	}
    			}];     			
tabData(9);
function tabData(status) {
	$('#search-condition').find('input[type=text]').val('');
	$('.launch-contract').show();
	$('.name-title').html('发起人：');
	$('.time-title').html('发起日期：');
	if (status == 9) {
		$('.launch-contract').hide();
		$('.name-title').html('申请人：');
		$('.time-title').html('申请日期：');
		var columns = columns9;
		var url = '/admin/t33/sys/onLineContract/getContractApply';
	} else if (status == 1) {
		var columns = columns1;
		var url = '/admin/t33/sys/onLineContract/getContractData';
	} else if (status == 2) {
		var columns = columns2;
		var url = '/admin/t33/sys/onLineContract/getContractData';
	} else if (status == 3) {
		var columns = columns3;
		var url = '/admin/t33/sys/onLineContract/getContractData';
	} else if (status == 4) {
		var columns = columns4;
		var url = '/admin/t33/sys/onLineContract/getContractData';
	} else if (status == -1) {
		var columns = columns5;
		var url = '/admin/t33/sys/onLineContract/getContractData';
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:url,
		pageSize:10,
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

$('.itab').find('li').find('a').click(function(){
	if (!$(this).hasClass('active')) {
		var type = $(this).parent().attr('data-val');
		$(this).addClass('active').parent().siblings().find('a').removeClass('active');
		$('input[name=status]').val(type);
		tabData(type);
	}
})

//核销合同
function writeOff(id) {
	layer.confirm('您确定要核销此合同', 
			{btn: ['确定','取消']},
			function(index){
				$.ajax({
					url:'/admin/t33/sys/onLineContract/writeOff',
					data:{id:id},
					type:'post',
					dataType:'json',
					success:function(result) {
						if (result.code == '2000') {
							layer.close(index);
							tabData(1);
							layer.alert(result.msg, {icon: 1,title:'成功提示'});
						} else {
							layer.alert(result.msg, {icon: 2,title:'错误提示'});
						}
					}
				});
			}, 
			function(){}
		);
}

//确认作废
function abandoned(id ,remark) {
	$('#apply-form').find('textarea').val(remark);
	$('#apply-form').find('input[name=id]').val(id);
	
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#apply-abandoned')
	});
}

$('#apply-form').submit(function(){
	$.ajax({
		url:'/admin/t33/sys/onLineContract/confirmAbandoned',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == '2000') {
				tabData(-1);
				$('#apply-abandoned').hide();
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1,title:'成功提示'});
			} else {
				layer.alert(result.msg, {icon: 2,title:'错误提示'});
			}
		}
	});
	return false;
})


//查看合同
function see(code) {
	window.top.layer.open({
		  type: 2,
		  area: ['900px', '600px'],
		  title :'合同信息',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/onLineContract/seeLaunchContract');?>"+"?code="+code
	});
}

$('.starttime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});
$('.endtime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});

</script>
</body>
</html>

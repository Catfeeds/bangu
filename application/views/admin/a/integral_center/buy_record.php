<style type="text/css">
.page-content{ min-width: auto !important; }
input[type=file]{width:68px !important;border: 0 !important;}
</style>
<div class="page-content">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i> 
            <a href="<?php echo site_url('admin/a/') ?>"> 首页 </a>
        </li>
        <li class="active"><span>/</span>购买记录</li>
    </ul>
    <div class="page-body">
        <div class="tab-content">
	        <ul class="nav-tabs" id= "data-id">
				<li class="active" data-val="1">已下单 </li>
				<li class="tab-red" data-val="2">已发货</li>
				<li class="tab-red" data-val="3">已完成</li>
			</ul>
			<br>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
						<li class="search-list">
							<span class="search-title">订单号：</span>
							<span ><input class="search-input" type="text" name="order_id" /></span>
						</li>
						<li class="search-list">
							<span class="search-title">产品标题：</span>
							<span ><input class="search-input" type="text" name="p_name" /></span>
						</li>
						<li class="search-list">
							<span class="search-title">收货人：</span>
							<span ><input class="search-input" type="text" name="addressee" /></span>
						</li>
						<li class="search-list">
							<span class="search-title">收货手机号：</span>
							<span ><input class="search-input" type="text" name="s_mobile" /></span>
						</li>
						<li class="search-list">
							<span class="search-title">产品类型：</span>
							<select name="p_type" class="p_type">
								<option value="">请选择</option>
								<option value="1">带金额的产品</option>
								<option value="2">纯积分产品</option>
							</select>
						</li>
						<li class="search-list">
							<input type="submit" value="搜索" class="search-button" />
						</li>
				</ul>
				<input type="hidden" value="1" name="status">
			</form>
            <div id="dataTable"></div>
        </div>
    </div>
</div>

<script src="<?php echo base_url("assets/js/admin/common.js"); ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js'); ?>"></script>
<script type="text/javascript">
                            var columns1 = [{field: 'order_id', title:'订单号', align:'center', width:'100'},
                                {field: 'nickname', title: '用户昵称', width: '100', align: 'center'},
                                {field: 'p_name', title: '产品标题', width: '100', align: 'center'},
                                {field: false, title: '产品封面图', width: '200', align: 'center',formatter:function(item){
                        			return '<img src="<?php echo trim(base_url(''),'/');?>'+item.p_pic+'" width="100" height="100" />';
                        		}},
                        		{field: null, title:'产品类型', align:'center', width:'20', formatter: function (item) {
									if(item.attr_type==1){
										return '带金额的产品';
									}
									else if(item.attr_type==2){
										return '纯积分产品';
									}
									else{
										return item.attr_type;
									}
									
                       			 }},
                                {field: 'integral_price', title: '积分价格', width: '100', align: 'center'},
                                {field: 'price', title: '产品价格', width: '80', align: 'center'},
                                {field: 'num', title: '购买数量', align: 'center', width: '80'},
                                {field: 'sum_integral', title: '消耗总积分', align: 'center', width: '80'},
                                {field: 'sum_price', title: '合计价格', align: 'center', width: '80'},
                                {field: 'addressee', title: '收货人', width: '100', align: 'center'},
                        		{field: 'number', title: '收货手机号', width: '100', align: 'center'},
                                {field: null, title:'收货地址', align:'center', width:'120', formatter: function (item) {
											return item.pro_name+item.city_name+item.address;
                                 }},
                                {field: 'buy_time', title: '下单时间', align: 'center', width: '100'},
                                {field: null, title: '操作', align: 'center', width: '110', formatter: function (item) {
                                        var button = '';
                                        var status = $('#search-condition').find('input[name=status]').val();
                                       if (status == 1) {
                                            button += '<a href="javascript:void(0);" onclick="edit(' + item.log_id + ','+ status +')" class="tab-button but-blue">改为已发货</a>&nbsp;';
                                       }else if(status == 2){
                                    	   button += '<a href="javascript:void(0);" onclick="edit(' + item.log_id + ','+ status +')" class="tab-button but-blue">改为已完成</a>&nbsp;';
                                    	   /* button += '<a href="javascript:void(0);" onclick="del(' + item.log_id + ');" class="tab-button but-red">删除</a>'; */
                                       }
                                        return button;
                                    }
                                }
                            ];

                            var columns2 = [{field: 'order_id', title:'订单号', align:'center', width:'100'},
                                            {field: 'nickname', title: '用户昵称', width: '100', align: 'center'},
                                            {field: 'p_name', title: '产品标题', width: '100', align: 'center'},
                                            {field: false, title: '产品封面图', width: '200', align: 'center',formatter:function(item){
                                    			return '<img src="<?php echo trim(base_url(''),'/');?>'+item.pic+'" width="100" height="100" />';
                                    		}},
                                    		{field: null, title:'产品类型', align:'center', width:'20', formatter: function (item) {
            									if(item.attr_type==1){
            										return '带金额的产品';
            									}
            									else if(item.attr_type==2){
            										return '纯积分产品';
            									}
            									else{
            										return item.attr_type;
            									}
            									
                                   			 }},
                                            {field: 'integral_price', title: '积分价格', width: '100', align: 'center'},
                                            {field: 'price', title: '产品价格', width: '100', align: 'center'},
                                            {field: 'num', title: '购买数量', align: 'center', width: '100'},
                                            {field: 'sum_integral', title: '消耗总积分', align: 'center', width: '100'},
                                            {field: 'sum_price', title: '合计价格', align: 'center', width: '100'},
                                            {field: 'addressee', title: '收货人', width: '100', align: 'center'},
                                    		{field: 'number', title: '收货手机号', width: '100', align: 'center'},
                                            {field: null, title:'收货地址', align:'center', width:'120', formatter: function (item) {
    											return item.pro_name+item.city_name+item.address;
                                     		}},
                                            {field: 'buy_time', title: '下单时间', align: 'center', width: '100'},
                                        ];
                           
                            $("#dataTable").pageTable({
                                columns: columns1,
                                url: '/admin/a/integral_center/buy_record/list_buy_record',
                                pageNumNow: 1,
                                searchForm: '#search-condition',
                                tableClass: 'table-data'
                            });
                           

    function edit(id,status) {
    	if (confirm("您确定要更改吗?")) {
            $.post("/admin/a/integral_center/buy_record/edit_status", {log_id: id,p_status:status}, function (json) {
                var data = eval("(" + json + ")");
                if (data.code == 2000) {
                	if (status == 1 || status ==2) {
                 		var columns = columns1;
                 	}else if (status == 3) {
                 		var columns = columns2;
                 	}
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/integral_center/buy_record/list_buy_record',
                        pageNumNow: 1,
                        searchForm: '#search-condition',
                        tableClass: 'table-data'
                    });
                    alert(data.msg);
                } else {
                    alert(data.msg);
                }
            });
        }
    }

    
  //导航栏切换
    $('.nav-tabs li').click(function(){
    	$('input[name=order_id]').val('');
        $('input[name=s_mobile]').val('');
        $('input[name=p_name]').val('');
        $('input[name=addressee]').val('');
        $(".p_type").val('');
    	var formObj = $('#search-condition');
    	$(this).addClass('active').siblings().removeClass('active');
    	var status = $(this).attr('data-val');
    	$('input[name="status"]').val(status);
         if (status == 1 || status ==2) {
     		var columns = columns1;
     	}else if (status == 3) {
     		var columns = columns2;
     	}
    	$("#dataTable").pageTable({
    		columns:columns,
    		url:'/admin/a/integral_center/buy_record/list_buy_record',
    		pageNumNow:1,
    		searchForm:'#search-condition',
    		tableClass:'table-data'
    	});
    })
    
    
    //删除
    function del(id) {
        if (confirm("您确定要删除吗?")) {
            $.post("/admin/a/integral_center/buy_record/del", {p_id: id}, function (json) {
                var data = eval("(" + json + ")");
                if (data.code == 2000) {
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/integral_center/buy_record/list_buy_record',
                        pageNumNow: 1,
                        searchForm: '#search-condition',
                        tableClass: 'table-data'
                    });
                    alert(data.msg);
                } else {
                    alert(data.msg);
                }
            });
        }
    }
    
</script>

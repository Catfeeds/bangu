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
        <li class="active"><span>/</span>抽奖记录</li>
    </ul>
    <div class="page-body">
        <div class="tab-content">
        	<ul class="nav-tabs" id= "data-id">
				<li class="active" data-val="1">未发货 </li>
				<li class="tab-red" data-val="2">已发货</li>
			</ul>
			<br>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">奖品名称：</span>
						<span ><input class="search-input" type="text" name="p_name" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">账户手机号：</span>
						<span ><input class="search-input" type="text" name="mobile" /></span>
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
						<span class="search-title">奖品类型：</span>
						<select name="p_type" class="p_type">
							<option value="">请选择</option>
							<option value="1">实物</option>
							<option value="2">虚拟物品</option>
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
                            var columns1 = [{field: 'p_id', title:'奖品编号', align:'center', width:'100'},
                                {field: 'p_title', title: '奖品名称', width: '100', align: 'center'},
                                {field: 'nickname', title: '用户昵称', width: '100', align: 'center'},
                                {field: 'mobile', title: '账户手机号', width: '100', align: 'center'},
                                {field: false, title: '奖品图片', width: '100', align: 'center',formatter:function(item){
                        			return '<img src="<?php echo trim(base_url(''),'/');?>'+item.p_pic+'" width="100" height="100"/>';
                        		}},
                        		{field: false, title: '奖品类型', width: '100', align: 'center',formatter:function(item){
                        			if(item.p_type==1)
                        				return '实物';
                        			if(item.p_type==2)
                        				return '虚拟物品';
                    				return '';
                        		}},
                        		{field: 'addressee', title: '收货人', width: '100', align: 'center'},
                        		{field: 'number', title: '收货手机号', width: '100', align: 'center'},
                        		{field: false, title: '收货地址', width: '100', align: 'center',formatter:function(item){
									if(item.address!='')
										return item.pro_name+item.city_name+item.address;
									else
										return '';
                            	}},
                                {field: 'get_time', title: '抽奖时间', align: 'center', width: '100'},
                                {field: null, title: '操作', align: 'center', width: '110', formatter: function (item) {
                                    var button = '';
                                    var status = $('#search-condition').find('input[name=status]').val();
                                   if (status == 1) {
                                        button += '<a href="javascript:void(0);" onclick="edit(' + item.id + ','+ status +')" class="tab-button but-blue">改为已发货</a>&nbsp;';
                                   }
                                    return button;
                                }
                            }
                            ];

                            var columns2 = [{field: 'p_id', title:'奖品编号', align:'center', width:'100'},
                                            {field: 'p_title', title: '奖品名称', width: '100', align: 'center'},
                                            {field: 'nickname', title: '用户昵称', width: '100', align: 'center'},
                                            {field: 'mobile', title: '账户手机号', width: '100', align: 'center'},
                                            {field: false, title: '奖品图片', width: '100', align: 'center',formatter:function(item){
                                    			return '<img src="<?php echo trim(base_url(''),'/');?>'+item.p_pic+'" width="100" height="100"/>';
                                    		}},
                                    		{field: false, title: '奖品类型', width: '100', align: 'center',formatter:function(item){
                                    			if(item.p_type==1)
                                    				return '实物';
                                    			if(item.p_type==2)
                                    				return '虚拟物品';
                                				return '';
                                    		}},
                                    		{field: 'addressee', title: '收货人', width: '100', align: 'center'},
                                    		{field: 'number', title: '收货手机号', width: '100', align: 'center'},
                                    		{field: false, title: '收货地址', width: '100', align: 'center',formatter:function(item){
            									if(item.address!='')
            										return item.pro_name+item.city_name+item.address;
            									else
            										return '';
                                        	}},
                                            {field: 'get_time', title: '抽奖时间', align: 'center', width: '100'},
                                        ];

                            $("#dataTable").pageTable({
                                columns: columns1,
                                url: '/admin/a/integral_center/draw_record/list_draw_record',
                                pageNumNow: 1,
                                searchForm: '#search-condition',
                                tableClass: 'table-data'
                            });

                            //导航栏切换
                            $('.nav-tabs li').click(function(){
                                $('input[name=mobile]').val('');
                                $('input[name=s_mobile]').val('');
                                $('input[name=p_name]').val('');
                                $('input[name=addressee]').val('');
                                $(".p_type").val('');
                            	var formObj = $('#search-condition');
                            	$(this).addClass('active').siblings().removeClass('active');
                            	var status = $(this).attr('data-val');
                            	$('input[name="status"]').val(status);
                            	if (status == 1) {
                             		var columns = columns1;
                             	}else if (status == 2) {
                             		var columns = columns2;
                             	}
                            	$("#dataTable").pageTable({
                            		columns:columns,
                            		url:'/admin/a/integral_center/draw_record/list_draw_record',
                            		pageNumNow:1,
                            		searchForm:'#search-condition',
                            		tableClass:'table-data'
                            	});
                            })
                            
                            function edit(id,status) {
    	if (confirm("您确定要改为已发货吗?")) {
            $.post("/admin/a/integral_center/draw_record/edit_status", {id: id,p_status:status}, function (json) {
                var data = eval("(" + json + ")");
                if (data.code == 2000) {
                	if (status == 1) {
                 		var columns = columns1;
                 	}else if (status == 2) {
                 		var columns = columns2;
                 	}
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/integral_center/draw_record/list_draw_record',
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

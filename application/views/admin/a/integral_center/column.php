<style type="text/css">
.page-content{ min-width: auto !important; }
input[type=file]{width:68px !important;border: 0 !important;}
.add_btn{ float:left; width:auto !important;  position: relative; top:50px; left:10px;}
</style>
<div class="page-content">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i> 
            <a href="<?php echo site_url('admin/a/') ?>"> 首页 </a>
        </li>
        <li class="active"><span>/</span>产品所属栏目</li>
    </ul>
    <div class="page-body">
        <div class="tab-content">			
            <a id="add-button" href="javascript:void(0);" class="but-default" >添加栏目</a>
            <form action="#" id='search-condition' class="search-condition" method="post">
			</form>
            <div id="dataTable"></div>
        </div>
    </div>
</div>

<div class="form-box fb-body">
    <div class="fb-content" style="width: 800px; max-height:600px;overflow-y:auto;">
        <div class="box-title">
            <h4>添加栏目</h4>
            <span class="fb-close">x</span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="add-data" class="form-horizontal" >
                <div class="form-group">
                    <div class="fg-title">栏目名称：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="l_name" />
                    </div>
                </div>    
                <div class="form-group">
                    <div class="fg-title">排序：</div>
                    <div class="fg-input">
                        <input name="order" type="text"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">是否显示：</div>
                    <div class="fg-input">
                        <ul>
                            <li><label><input type="radio" class="fg-radio" name="is_show" value="0">否</label></li>
                            <li><label><input type="radio" class="fg-radio" name="is_show" checked="checked" value="1">是</label></li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">是否可更改：</div>
                    <div class="fg-input">
                        <ul>
                            <li><label><input type="radio" class="fg-radio" name="is_modify" value="0">否</label></li>
                            <li><label><input type="radio" class="fg-radio" name="is_modify" checked="checked" value="1">是</label></li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" />
                    <input type="button" class="fg-but fb-close" value="取消" />
                    <input type="submit" class="fg-but" value="确定" />
                </div>
                <div class="clear"></div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url("assets/js/admin/common.js"); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js'); ?>"></script>
<script type="text/javascript">
                            var columns = [{field: 'name', title: '栏目名称', width: '100', align: 'center'},                              
                                {field: null, title: '是否显示', width: '80', align: 'center', formatter: function (item) {
                                    return item.is_show == 1 ? '显示' : '不显示';
                                	}
                                },
	                            {field: null, title: '是否可更改', width: '90', align: 'center', formatter: function (item) {
	                                    return item.is_modify == 1 ? '可更改' : '不可更改';
	                                }
	                            },
                                {field: 'showorder', title:'排序', align:'center', width:'20'},
                                {field: 'add_time', title:'更新时间', align:'center', width:'20'},
                                {field: null, title: '操作', align: 'center', width: '110', formatter: function (item) {
                                    var button = '';
                                    if (item.is_modify == 1) {
                                        button += '<a href="javascript:void(0);" onclick="edit(' + item.id + ')" class="tab-button but-blue">修改</a>&nbsp;';
                                    }
                                    button += '<a href="javascript:void(0);" onclick="del(' + item.id + ');" class="tab-button but-red">删除</a>';
                                    return button;
                                }
                            }];
                            $("#dataTable").pageTable({
                                columns: columns,
                                url: '/admin/a/integral_center/column/get_data',
                                pageNumNow: 1,
                                searchForm: '#search-condition',
                                tableClass: 'table-data'
                            });
                            var formObj = $("#add-data");
							//添加弹出层
                            $("#add-button").click(function () {
                            	formObj.find('input[type=text]').val('');
                            	formObj.find("input[name='is_show'][value=1]").attr("checked", true);
                                formObj.find("input[name='is_modfiy'][value=1]").attr("checked", true);
                                $(".fb-body,.mask-box").show();
                                $('.uploadImg').remove();
                                
                            });

                            $("#add-data").submit(function () {
                                var id = $(this).find('input[name=id]').val();
                                var url = id > 0 ? '/admin/a/integral_center/column/edit' : '/admin/a/integral_center/column/add';
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    dataType: 'json',
                                    data: $(this).serialize(),
                                    success: function (data) {
                                        if (data.code == 2000) {
						                    alert(data.msg);
						                    $(".fb-body,.mask-box").hide();
						                    $("#dataTable").pageTable({
						                        columns: columns,
						                        url: '/admin/a/integral_center/column/get_data',
						                        pageNumNow: 1,
						                        searchForm: '#search-condition',
						                        tableClass: 'table-data'
						                    });
						                } else {
						                    alert(data.msg);
						                }
						            }
						        });
						        return false;
   							});

    function edit(id) {
        $.ajax({
            url: '/admin/a/integral_center/column/get_edit_data',
            type: 'post',
            dataType: 'json',
            data: {id: id},
            success: function (data) {
                if (!$.isEmptyObject(data)) {
                    //alert(JSON.stringify(data))
                    formObj.find('input[name=l_name]').val(data.name);   
                    formObj.find('input[name=order]').val(data.showorder);
                    formObj.find('input[name=id]').val(data.id);
                    formObj.find("input[name='is_show'][value=" + data.is_show + "]").attr("checked", true);
                    formObj.find("input[name='is_modfiy'][value=" + data.is_modfiy + "]").attr("checked", true);
                    $(".fb-body,.mask-box").show();
                } else {
                    alert('请确认您选择的数据');
                }
            }
        });
    }

    //删除
    function del(id) {
        if (confirm("您确定要删除吗?")) {
            $.post("/admin/a/integral_center/column/del", {id: id}, function (json) {
                var data = eval("(" + json + ")");
                if (data.code == 2000) {
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/integral_center/column/get_data',
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

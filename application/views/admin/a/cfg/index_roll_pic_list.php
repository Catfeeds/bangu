<style type="text/css">
.page-content{ min-width: auto !important; }
</style>

<div class="page-content">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i> 
            <a href="<?php echo site_url('admin/a/') ?>"> 首页 </a>
        </li>
        <li class="active"><span>/</span>首页轮播图配置</li>
    </ul>
    <div class="page-body">
        <div class="tab-content">
            <a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
            <div id="dataTable"></div>
        </div>
    </div>
</div>

<div class="form-box fb-body">
    <div class="fb-content">
        <div class="box-title">
            <h4>首页轮播图配置</h4>
            <span class="fb-close">x</span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="add-data" class="form-horizontal" >
                <div class="form-group">
                    <div class="fg-title">名称：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="name"  />
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">图片：<i>*</i></div>
                    <div class="fg-input">
                        <input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
                        <input name="pic" type="hidden" />
                        <span>不上传则默认管家头像</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">链接地址：</div>
                    <div class="fg-input"><input type="text" name="link" /></div>
                </div>
                <div class="form-group">
                    <div class="fg-title">排序：</div>
                    <div class="fg-input"><input type="text" name="showorder" /></div>
                </div>
                <div class="form-group">
                    <div class="fg-title">描述：</div>
                    <div class="fg-input"><textarea name="description" maxlength="30" placeholder="最多30个字"></textarea></div>
<!--                     <div class="fg-input"><textarea name="remark" maxlength="30" placeholder="最多30个字"></textarea></div> -->
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
<!--                 <div class="form-group"> -->
<!--                     <div class="fg-title">分类：</div> -->
<!--                     <div class="fg-input"> -->
<!--                         <select name="kind"> -->
<!--                             <option value="1">首页</option> -->
<!--                             <option value="2">产品页</option> -->
<!--                             <option value="3">目的地页</option> -->
<!--                             <option value="4">国内</option> -->
<!--                             <option value="5">出境</option> -->
<!--                             <option value="6">周边</option> -->
<!--                         </select> -->
<!--                     </div> -->
<!--                 </div> -->
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
<script src="<?php echo base_url(); ?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js'); ?>"></script>
<script>
                            var columns = [{field: 'name', title: '名称', width: '100', align: 'center'},
                                {field: null, title: '图片', width: '120', align: 'center', formatter: function (item) {
                                        return "<a href='" + item.pic + "' target='_blank'>图片预览</a>";
                                    }
                                },
                                {field: 'link', title: '链接地址', width: '150', align: 'center'},
                                {field: null, title: '是否显示', width: '120', align: 'center', formatter: function (item) {
                                        return item.is_show == 1 ? '是' : '否';
                                    }
                                },
                                {field: null, title: '是否可更改', width: '120', align: 'center', formatter: function (item) {
                                        return item.is_modify == 1 ? '是' : '否';
                                    }
                                },
                                {field: 'showorder', title: '排序', align: 'center', width: '80'},
                                {field: 'description', title: '描述', align: 'center', width: '160', length: 20},
//                                 {field: null, title: '分类', align: 'center', width: '160', formatter: function (item) {
//                                         if (item.kind == 1)return '首页';
//                                         if (item.kind == 2)return '产品页';
//                                         if (item.kind == 3)return '目的地页';
//                                         if (item.kind == 4)return '国内';
//                                         if (item.kind == 5)return '出境';
//                                         if (item.kind == 6)return '周边';
//                                     }
//                                 },
                                {field: null, title: '操作', align: 'center', width: '150', formatter: function (item) {
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
                                url: '/admin/a/cfg/index_roll_pic/getRollPicJson',
                                pageNumNow: 1,
                                tableClass: 'table-data'
                            });

//添加弹出层
                            $("#add-button").click(function () {
                                var formObj = $("#add-data");
                                formObj.find('input[type=text]').val('');
                                formObj.find('input[type=hidden]').val('');
                                formObj.find('textarea').val('');
                                formObj.find("input[name='is_show'][value=1]").attr("checked", true);
                                formObj.find("input[name='is_modfiy'][value=1]").attr("checked", true);
                                $('.uploadImg').remove();
                                $(".fb-body,.mask-box").show();
                            })

                            $("#add-data").submit(function () {
                                var id = $(this).find("input[name='id']").val();
                                var url = id > 0 ? '/admin/a/cfg/index_roll_pic/edit' : '/admin/a/cfg/index_roll_pic/add';
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    dataType: 'json',
                                    data: $(this).serialize(),
                                    success: function (data) {
                                        if (data.code == 2000) {
                                            $("#dataTable").pageTable({
                                                columns: columns,
                                                url: '/admin/a/cfg/index_roll_pic/getRollPicJson',
                                                pageNumNow: 1,
                                                tableClass: 'table-data'
                                            });
                                            alert(data.msg);
                                            $(".fb-body,.mask-box").hide();
                                        } else {
                                            alert(data.msg);
                                        }
                                    }
                                });
                                return false;
                            })

                            function edit(id) {
                                $.post("/admin/a/cfg/index_roll_pic/getDetailJson", {id: id}, function (data) {
                                    var data = eval("(" + data + ")");
                                    $("input[name='name']").val(data.name);
                                    $("input[name='link']").val(data.link);
                                    $("input[name='id']").val(data.id);
                                    $("input[name='pic']").val(data.pic);
                                    $("input[name='showorder']").val(data.showorder);
                                    $("textarea[name='beizhu']").val(data.beizhu);
                                    $("select[name='is_show']").val(data.is_show);
                                    $("select[name='is_modify']").val(data.is_modify);
                                    $(".uploadImg").remove();
                                    $("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
                                    $(".fb-body,.mask-box").show();
                                })
                            }

//删除
                            function del(id) {
                                if (confirm("您确定要删除吗?")) {
                                    $.post("/admin/a/cfg/index_roll_pic/delRollPic", {id: id}, function (json) {
                                        var data = eval("(" + json + ")");
                                        if (data.code == 2000) {
                                            $("#dataTable").pageTable({
                                                columns: columns,
                                                url: '/admin/a/cfg/index_roll_pic/getRollPicJson',
                                                pageNumNow: 1,
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

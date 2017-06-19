<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
.add_btn{ float:left; width:auto !important;  position: relative; top:50px; left:10px;}
#imghead{ float:left;}
</style>

<div class="page-content">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i> 
            <a href="<?php echo site_url('admin/a/') ?>"> 首页 </a>
        </li>
        <li class="active"><span>/</span>社区板块图</li>
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
            <h4>手机端社区首页板块图</h4>
            <span class="fb-close">x</span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="add-data" class="form-horizontal" >
            	<div class="form-group">
                    <div class="fg-title">分类：</div>
                    <div class="fg-input">
                        <select name="kind" class="selector">
                            <option value="0">请选择</option>
                            <option value="1">我的关注</option>
                            <option value="2">知道</option>
                            <option value="3">心情</option>
                            <option value="4">故事</option>
                            <option value="5">直播</option>
                            <option value="6">瞬间</option>
                            <option value="7">服务</option>
                            <option value="8">管家</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
					<div class="fg-title">封面图：<i>*</i></div>
					<img src="#" style="width: 168px; height: 110px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,1);" value="上传">
					<input type="hidden" name="pic" id="pic" />
				</div>
                <!-- <div class="form-group">
                    <div class="fg-title">链接：</div>
                    <div class="fg-input"><input type="text" name="link" /></div>
                </div> -->
                <div class="form-group">
                    <div class="fg-title">排序：</div>
                    <div class="fg-input"><input type="text" name="showorder" /></div>
                </div>
                <div class="form-group">
                    <div class="fg-title">备注：</div>
                    <div class="fg-input"><textarea name="remark" maxlength="30" placeholder="最多30个字"></textarea></div>
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
<div id="xiuxiu_box1" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<script src="<?php echo base_url("assets/js/admin/common.js"); ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js'); ?>"></script>
<script>
                            var columns = [
                                {field: null, title: '图片', width: '210', align: 'center', formatter: function (item) {
                                	return '<img src="<?php echo trim(base_url(''),'/');?>'+item.pic+'" width="200" />';
                                    }
                                },
                                {field: null, title: '是否显示', width: '80', align: 'center', formatter: function (item) {
                                        return item.is_show == 1 ? '显示' : '不显示';
                                    }
                                },
                                {field: null, title: '是否可更改', width: '90', align: 'center', formatter: function (item) {
                                        return item.is_modify == 1 ? '可更改' : '不可更改';
                                    }
                                },
                                {field: 'showorder', title: '排序', align: 'center', width: '50'},
                                {field: 'remark', title: '备注', align: 'center', width: '160'},
                                {field: null, title: '分类', align: 'center', width: '160', formatter: function (item) {
                                        if (item.kind == 1)
                                            return '我的关注';
                                        if (item.kind == 2)
                                            return '知道';
                                        if (item.kind == 3)
                                            return '心情';
                                        if (item.kind == 4)
                                            return '故事';
                                        if (item.kind == 5)
                                            return '直播';
                                        if (item.kind == 6)
                                            return '瞬间';
                                        if (item.kind == 7)
                                            return '服务';
                                        if (item.kind == 8)
                                            return '管家';
                                    }
                                },
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
                                url: '/admin/a/social/plate_graph/getRollPicData',
                                pageNumNow: 1,
                                searchForm: '#search-condition',
                                tableClass: 'table-data'
                            });
                            var formObj = $("#add-data");

							//添加弹出层
                            $("#add-button").click(function () {
                            	$(".selector").val('');
                                formObj.find('input[type=text]').val('');
                                formObj.find('input[type=hidden]').val('');
                                formObj.find('textarea').val('');
                                formObj.find("input[name='is_show'][value=1]").attr("checked", true);
                                formObj.find("input[name='is_modfiy'][value=1]").attr("checked", true);
                                $('.uploadImg').remove();
                                $("#imghead").attr("src","");
                                $(".fb-body,.mask-box").show();
                            })

                            $("#add-data").submit(function () {
                                var id = $(this).find('input[name=id]').val();
                                var url = id > 0 ? '/admin/a/social/plate_graph/edit' : '/admin/a/social/plate_graph/add';
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    dataType: 'json',
                                    data: $(this).serialize(),
                                    success: function (data) {
                                        if (data.code == 2000) {
                                            $("#dataTable").pageTable({
                                                columns: columns,
                                                url: '/admin/a/social/plate_graph/getRollPicData',
                                                pageNumNow: 1,
                                                searchForm: '#search-condition',
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
                                $.ajax({
                                    url: '/admin/a/social/plate_graph/getDetailJson',
                                    type: 'post',
                                    dataType: 'json',
                                    data: {id: id},
                                    success: function (data) {
                                        if (!$.isEmptyObject(data)) {
                                        	$(".selector").val(data.kind);
                                            formObj.find('input[name=showorder]').val(data.showorder);
                                            formObj.find('input[name=pic]').val(data.pic);
                                            formObj.find("#imghead").attr("src",data.pic);
//                                             formObj.find('input[name=link]').val(data.link);
                                            formObj.find('input[name=id]').val(data.id);
                                            formObj.find('textarea[name=remark]').val(data.remark);
                                            formObj.find("input[name='is_show'][value=" + data.is_show + "]").attr("checked", true);
                                            formObj.find("input[name='is_modfiy'][value=" + data.is_modfiy + "]").attr("checked", true);
                                            $(".uploadImg").remove();
                                            $("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
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
                                    $.post("/admin/a/social/plate_graph/delHotLine", {id: id}, function (json) {
                                        var data = eval("(" + json + ")");
                                        if (data.code == 2000) {
                                            $("#dataTable").pageTable({
                                                columns: columns,
                                                url: '/admin/a/social/plate_graph/getRollPicData',
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

                            /*-----------------------------------上传图片-----------------------------*/
                        	var imgProportion = {1:"336x220",2:"347:480",3:"5:5",4:"332:222"};
                        	var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3",4:"xiuxiu_box4"};
                        	var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3",4:"xiuxiuEditor4"};
                        	function uploadImgFile(obj ,type){			
                        			var buttonObj = $(obj);
                        			xiuxiu.setLaunchVars("cropPresets", imgProportion[type]);
                        			xiuxiu.embedSWF(xiuBox[type],5,'100%','100%',xiuxiuEditor[type]);
                        		       //修改为您自己的图片上传接口
                        			xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu'); ?>");
                        		    xiuxiu.setUploadType(2);		    
                        		    xiuxiu.setUploadDataFieldName("uploadFile");		   
                        			xiuxiu.onInit = function ()
                        			{				
                        				//默认图片
                        				xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
                        			}			
                        			xiuxiu.onUploadResponse = function (data)
                        			{
                        				
                        				data = eval('('+data+')');
                        				if (data.code == 2000) {
                        					buttonObj.next("input").val(data.msg);

                        					if (type == 3) {
                        						//alert("上传成功");
                        						//buttonObj.after(data.msg);
                        						buttonObj.prev("input").val(data.msg);
                        						buttonObj.next("span").html(data.msg);
                        					} else if (type == 2) {
                        						//buttonObj.css({'margin-top': '0px','margin-left': '110px'});
                        						buttonObj.prev("img").attr("src",data.msg);
                        						buttonObj.next('input').val(data.msg);
                        					} else if (type == 1){
                        						//buttonObj.css({'margin-top': '134px','margin-left': '384px'});
                        						buttonObj.prev("img").attr("src",data.msg);
                        						$('input[name="pic"]').val(data.msg);
                        					}else if(type == 4){
                        						buttonObj.prev("img").attr("src",data.msg);
                        						$('input[name="big_photo"]').val(data.msg);
                        					}
                        					closeXiu(type);
                        				} else {
                        					alert(data.msg);
                        				}
                        			}

                        			$("#xiuxiuEditor"+type).show();
                        			$('.avatar_box').show();
                        			$('.close_xiu').show();
                        			$('.right_box').show();		
                        			return false;
                        	}
                        	$(document).mouseup(function(e) {
                        	    var _con = $('#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4'); // 设置目标区域
                        	    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
                        	        $("#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4").hide();
                        	        $('.avatar_box').hide();
                        	        $('.close_xiu').hide();
                        	        $('.right_box').hide();
                        	    }
                        	})
                        	function closeXiu(type) {
                        		$("#xiuxiuEditor"+type).hide();
                        		$('.avatar_box').hide();
                        		$('.close_xiu').hide();
                        		$('.right_box').hide();
                        	}


                        	/*-------------------------------*/
                        	
</script>

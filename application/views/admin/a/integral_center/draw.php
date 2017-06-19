<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
input[type=file]{width:68px !important;border: 0 !important;}
.add_btn{ float:left; width:auto !important;  position: relative; top:50px; left:10px;}
#imghead{ float:left;}
.fb-content { position:fixed;width:600px !important;left:50%;margin-left:-380px !important;top:50px;}
</style>
<div class="page-content">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i> 
            <a href="<?php echo site_url('admin/a/') ?>"> 首页 </a>
        </li>
        <li class="active"><span>/</span>奖品配置</li>
    </ul>
    <div class="page-body">
        <div class="tab-content">			
            <a id="add-button" href="javascript:void(0);" class="but-default" >添加奖品</a>
            <form action="#" id='search-condition' class="search-condition" method="post">
			</form>
            <div id="dataTable"></div>
        </div>
    </div>
</div>

<div class="form-box fb-body">
    <div class="fb-content" style="width: 800px; max-height:600px;overflow-y:auto;">
        <div class="box-title">
            <h4>添加奖品</h4>
            <span class="fb-close">x</span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="add-data" class="form-horizontal" >
                <div class="form-group">
                    <div class="fg-title">奖品名称：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="p_title" />
                    </div>
                </div>    
                <div class="form-group">
					<div class="fg-title">奖品图片：<i>*</i></div>
					<img src="#" name="p_pic"  style="width: 150px; height: 125px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,1);" value="上传">
					<input type="hidden" name="p_pic" id="p_pic" />
				</div>
				<div class="form-group">
                    <div class="fg-title">中奖概率：</div>
                    <div class="fg-input">
                        <input name="win_probability" type="text" style="width:80px;"/>%<br/>
                        <span>中奖概率请填写整数</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">跳转链接：</div>
                    <div class="fg-input">
                        <input name="url" type="text"/><br/>
                        <span>请填写完整的URL地址</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">分类：</div>
                    <div class="fg-input">
                        <select name="p_type" class="selector p_type">
                            <option value="0">请选择</option>
                            <option value="1">实物</option>
                            <option value="2">虚拟物品(只支持话费卡和流量卡)</option>
                        </select>
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
                    <input type="hidden" name="p_id" />
                    <input type="button" class="fg-but fb-close" value="取消" />
                    <input type="submit" class="fg-but" value="确定" />
                </div>
                <div class="clear"></div>
            </form>
        </div>
    </div>
</div>
<div id="xiuxiu_box1" class="xiuxiu_box"></div>
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<script src="<?php echo base_url(); ?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script src="<?php echo base_url("assets/js/admin/common.js"); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js'); ?>"></script>
<script type="text/javascript">
                            var columns = [{field: 'p_title', title: '奖品名称', width: '100', align: 'center'},                              
                                {field: null, title: '奖品图片', width: '200', align: 'center', formatter: function (item) {
                                        return '<img src="<?php echo trim(base_url(''),'/');?>'+item.p_pic+'" width="100" />';                                       	                                           
                                }
                                },
                                {field: null, title: '分类', align: 'center', width: '100', formatter: function (item) {
                                    if (item.p_type == 1)
                                        return '实物';
                                    if (item.p_type == 2)
                                        return '虚拟物品';
                                    return '';
                                }
                            	},
                                {field: null, title: '是否显示', width: '80', align: 'center', formatter: function (item) {
                                    return item.is_show == 1 ? '显示' : '不显示';
                                }
                                },
                                {field: 'win_probability', title:'中奖概率', align:'center', width:'120'},
	                            {field: null, title: '是否可更改', width: '90', align: 'center', formatter: function (item) {
	                                    return item.is_modify == 1 ? '可更改' : '不可更改';
	                                }
	                            },
	                            {field: 'url', title:'跳转链接', align:'center', width:'200'},
                                {field: 'showorder', title:'排序', align:'center', width:'20'},
                                {field: 'add_time', title:'更新时间', align:'center', width:'20'},
                                {field: null, title: '操作', align: 'center', width: '110', formatter: function (item) {
                                    var button = '';
                                    if (item.is_modify == 1) {
                                        button += '<a href="javascript:void(0);" onclick="edit(' + item.p_id + ')" class="tab-button but-blue">修改</a>&nbsp;';
                                    }
                                    button += '<a href="javascript:void(0);" onclick="del(' + item.p_id + ');" class="tab-button but-red">删除</a>';
                                    return button;
                                }
                            }];
                            $("#dataTable").pageTable({
                                columns: columns,
                                url: '/admin/a/integral_center/draw/get_data',
                                pageNumNow: 1,
                                searchForm: '#search-condition',
                                tableClass: 'table-data'
                            });
                            var formObj = $("#add-data");
							//添加弹出层
                            $("#add-button").click(function () {
                            	formObj.find('input[type=text]').val('');
                            	formObj.find('input[type=hidden]').val('');
                            	formObj.find("input[name='is_show'][value=1]").attr("checked", true);
                                formObj.find("input[name='is_modfiy'][value=1]").attr("checked", true);
                                $(".selector").val('');
                                $('input[name=p_pic]').val('');   
                    			$('img[name=p_pic]').attr('src', '');
                                $("#imghead").attr("src","");
                                $(".fb-body,.mask-box").show();
                                $('.uploadImg').remove();
                                
                            });

                            $("#add-data").submit(function () {
                                var id = $(this).find('input[name=p_id]').val();
                                var url = id > 0 ? '/admin/a/integral_center/draw/edit' : '/admin/a/integral_center/draw/add';
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
						                        url: '/admin/a/integral_center/draw/get_data',
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
            url: '/admin/a/integral_center/draw/get_edit_data',
            type: 'post',
            dataType: 'json',
            data: {p_id: id},
            success: function (data) {
                if (!$.isEmptyObject(data)) {
                    //alert(JSON.stringify(data))
                    formObj.find('input[name=p_title]').val(data.p_title);   
                    formObj.find('input[name=order]').val(data.showorder);
                    formObj.find('input[name=p_id]').val(data.p_id);
                    formObj.find('input[name=url]').val(data.url);
                    formObj.find('input[name=win_probability]').val(data.win_probability);
                    formObj.find('input[name=p_pic]').val(data.p_pic);  
                    formObj.find('img[name=p_pic]').attr('src', window.location.protocol + '//' + document.domain + data.p_pic);
                    formObj.find(".selector option[value="+data.p_type+"]").attr("selected", true);
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
            $.post("/admin/a/integral_center/draw/del", {p_id: id}, function (json) {
                var data = eval("(" + json + ")");
                if (data.code == 2000) {
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/integral_center/draw/get_data',
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
	var imgProportion = {1:"150x125",2:"347:480",3:"5:5",4:"332:222"};
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
						$('input[name="p_pic"]').val(data.msg);
						buttonObj.next('input').val(data.msg);
					} else if (type == 1){
						//buttonObj.css({'margin-top': '134px','margin-left': '384px'});
						buttonObj.prev("img").attr("src",data.msg);
						$('input[name="p_pic"]').val(data.msg);
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

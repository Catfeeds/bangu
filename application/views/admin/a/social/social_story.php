<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
.video_input,.img_input { display: none;}
table { table-layout: fixed;}  
td { white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
input[type=file]{width:66px !important;border: 0 !important;}
.add_btn{ float:left; width:auto !important;  position: relative; top:50px; left:10px;}
.btn{ float:left; width:auto !important;  position: relative; top:50px; left:20px;}
#imghead{ float:left;}
</style>
<div class="page-content">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i> 
            <a href="<?php echo site_url('admin/a/') ?>"> 首页 </a>
        </li>
        <li class="active"><span>/</span>社区 /故事</li>
    </ul>
    <div class="page-body">
        <div class="tab-content">
            <a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
            <div id="dataTable"></div>
        </div>
    </div>
</div>

<div class="form-box fb-body">
    <div class="fb-content" style="width: 800px;left: 50%;margin-left: -400px;position: fixed;top: 20px; max-height: 600px; overflow-y: auto;">
        <div class="box-title">
            <h4>社区故事管理</h4>
            <span class="fb-close">x</span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="add-data" class="form-horizontal" >
                <div class="form-group">
                    <div class="fg-title">主题名称：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="name" />
                    </div>
                </div>
                <div class="form-group">
					<div class="fg-title">主题背景图片：<i>*</i></div>
					<img src="#" name="icon_pic" style="width: 250px; height: 103px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,1);" value="上传">
					<input type="hidden" name="icon" id="pic" />
				</div>
                <div class="form-group">
                    <div class="fg-title">主题描述：</div>
                    <div class="fg-input">
                        <textarea name="description" maxlength="300" placeholder="最多300个字"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">主题类型：<i>*</i></div>
                    <div class="fg-input">
                        <select name="type" style="width:100px;" onchange="check(this);">
                            <option value="0">请选择</option>
                            <option value="1" >视频</option>
                            <option value="2">图片</option>
                        </select>
                    </div>
                </div>
                <div class="video_input">
                <div class="form-group">
                    <div class="fg-title">视频1：<i>*</i></div>
                    <div class="fg-input">
                        <input name="uploadFile1" id="uploadFile1" onchange="uploadVideoFile(this);" type="file">
                        <input name="video1" type="hidden" />
                    </div>
                </div>
                <div class="form-group">
					<div class="fg-title">视频封面图1：<i>*</i></div>
					<img src="#" name="video_pic1" style="width: 150px; height: 94px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">
					<input type="hidden" name="video_pic1" id="pic" />
					<input class="btn" type="button" onclick="clear_data(this,1);" value="清除视频1和封面图1">
                </div>
                	<div class="form-group">
                    <div class="fg-title">视频2：<i>*</i></div>
                    <div class="fg-input">
                        <input name="uploadFile2" id="uploadFile2" onchange="uploadVideoFile(this);" type="file">
                        <input name="video2" type="hidden" />
                    </div>
                </div>
                <div class="form-group">
                	<div class="fg-title">视频封面图2：<i>*</i></div>
					<img src="#" name="video_pic2" style="width: 150px; height: 94px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">
					<input type="hidden" name="video_pic2" id="pic" />
					<input class="btn" type="button" onclick="clear_data(this,2);" value="清除视频2和封面图2">
                </div>
                <div class="form-group">
                    <div class="fg-title">视频3：<i>*</i></div>
                    <div class="fg-input">
                        <input name="uploadFile3" id="uploadFile3" onchange="uploadVideoFile(this);" type="file">
                        <input name="video3" type="hidden" />
                    </div>
                </div>
                <div class="form-group">
                	<div class="fg-title">视频封面图3：<i>*</i></div>
					<img src="#" name="video_pic3" style="width: 150px; height: 94px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">
					<input type="hidden" name="video_pic3" id="pic" />
					<input class="btn" type="button" onclick="clear_data(this,3);" value="清除视频3和封面图3">
                </div>
                </div>
                <div class="img_input">
                <div class="form-group">
                	<div class="fg-title">主题图片1：<i>*</i></div>
					<img src="#" name="theme_pic1" style="width: 150px; height: 94px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">
					<input type="hidden" name="theme_pic1" id="pic" />
					<input class="btn" type="button" onclick="clear_data(this,4);" value="清除主题图片1">
                    
                </div>
                <div class="form-group">
               		<div class="fg-title">主题图片2：<i>*</i></div>
					<img src="#" name="theme_pic2" style="width: 150px; height: 94px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">
					<input type="hidden" name="theme_pic2" id="pic" />
					<input class="btn" type="button" onclick="clear_data(this,5);" value="清除主题图片2">
                </div>
                <div class="form-group">
                	<div class="fg-title">主题图片3：<i>*</i></div>
					<img src="#" name="theme_pic3" style="width: 150px; height: 94px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">
					<input type="hidden" name="theme_pic3" id="pic" />
					<input class="btn" type="button" onclick="clear_data(this,6);" value="清除主题图片3">
                </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">关联线路：</div>
                    <div class="fg-input">
                        <input name="line" type="text" value="0">
                        <span>(多个线路id用英文状态的逗号[,]隔开)[最多关联六条线路]</span>
                    </div>
                </div>
                <div class="form-group">
                	<div class="fg-title">app首页推荐图片：</div>
					<img src="#" name="app_pic" style="width: 150px; height: 94px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFile(this,3);" value="上传">
					<input type="hidden" name="app_pic" id="pic" />
                </div>
                <div class="form-group">
                    <div class="fg-title">排序：</div>
                    <div class="fg-input">
                        <input name="order" type="text" value="0">
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
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div id="xiuxiu_box3" class="xiuxiu_box"></div>
<div id="xiuxiu_box4" class="xiuxiu_box"></div>
<div id="xiuxiu_box5" class="xiuxiu_box"></div>
<div id="xiuxiu_box6" class="xiuxiu_box"></div>
<div id="xiuxiu_box7" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<script src="<?php echo base_url("assets/js/admin/common.js"); ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js'); ?>"></script>
<script type="text/javascript">
                            var columns = [{field: 'id', title: '主题编号', width: '25', align: 'center'},
                                {field: 'name', title: '主题名称', width: '200', align: 'center'},
                                {field: 'description', title: '主题描述', width: '200', align: 'center'},
                                {field: null, title: '主题视频', width: '200', align: 'center', formatter: function (item) {
                                        var video_url1 = item.video_url1;
                                        var video_url2 = item.video_url2;
                                        var video_url3 = item.video_url3;
                                        var str = '';
                                        if (video_url1.length > 0){
                                        	str += "<video src='<?php echo trim(base_url(''), '/');?>" + video_url1 + "' controls width='200'></video>" + "&nbsp&nbsp";
                                        }
                                        if (video_url2.length > 0){
                                        	str += "<video src='<?php echo trim(base_url(''), '/');?>" + video_url2 + "' controls width='200'></video>" + "&nbsp&nbsp";
                                        }
                                        if (video_url3.length > 0){
                                        	str += "<video src='<?php echo trim(base_url(''), '/');?>" + video_url3 + "' controls width='200'></video>" + "&nbsp&nbsp";
                                        }
                                        return str;
                                    }
                                },
                                {field: null, title: '视频封面图片', width: '200', align: 'center', formatter: function (item) {
                                        //return "<a href='" + item.pic + "' target='_blank'>图片预览</a>";
                                        var video_pic1 = item.video_pic1;
                                        var video_pic2 = item.video_pic2;
                                        var video_pic3 = item.video_pic3;
                                        var str = '';
                                        if (video_pic1.length > 0){
                                            str += '<img src="<?php echo trim(base_url(''),'/');?>'+video_pic1+'" height="100" style="margin:5px;" />'; + "&nbsp&nbsp";
                                        }
                                        if (video_pic2.length > 0){
                                            str += '<img src="<?php echo trim(base_url(''),'/');?>'+video_pic2+'" height="100" style="margin:5px;" />'; + "&nbsp&nbsp";
                                        }
                                        if (video_pic3.length > 0){
                                            str += '<img src="<?php echo trim(base_url(''),'/');?>'+video_pic3+'" height="100" style="margin:5px;" />'; + "&nbsp&nbsp";
                                        }
                                        return str;
                                    }
                                },
                                {field :false,title : '主题背景图片',align : 'center', width : '100',formatter:function(item){
                        			return '<img src="<?php echo trim(base_url(''),'/');?>'+item.icon+'"  />';
                        		}},
                                {field: null, title: '主题图片', width: '240', align: 'center', formatter: function (item) {
                                        //return "<a href='" + item.pic + "' target='_blank'>图片预览</a>";
	                                    var pic1 = item.pic1;
	                                    var pic2 = item.pic2;
	                                    var pic3 = item.pic3;
	                                    var str = '';
	                                    if (pic1.length > 0){
	                                        str += '<img src="<?php echo trim(base_url(''),'/');?>'+pic1+'" height="100" style="margin:5px;" />'; + "&nbsp&nbsp";
	                                    }
	                                    if (pic2.length > 0){
	                                        str += '<img src="<?php echo trim(base_url(''),'/');?>'+pic2+'" height="100" style="margin:5px;" />'; + "&nbsp&nbsp";
	                                    }
	                                    if (pic3.length > 0){
	                                        str += '<img src="<?php echo trim(base_url(''),'/');?>'+pic3+'" height="100" style="margin:5px;" />'; + "&nbsp&nbsp";
	                                    }
	                                    return str;
                                    }
                                },
                                {field: null, title: 'app首页推荐图片', width: '240', align: 'center', formatter: function (item) {
                                    //return "<a href='" + item.pic + "' target='_blank'>图片预览</a>";
                                    if (item.app_pic.length <= 0)return '';   // 如果主题是视频类型,直接返回空字符串
                                    var arr_pic = item.app_pic.split(',');
                                    var str = '';
                                    for(var i = 0; i < arr_pic.length; i++){
//                                        str += "<a href='" + arr_pic[i] + "' target='_blank'>图片预览</a>" + "&nbsp&nbsp";
                                        if (arr_pic[i] !== ''){
                                            str += '<img src="<?php echo trim(base_url(''),'/');?>'+arr_pic[i]+'" height="100" style="margin:5px;"/>'; + "&nbsp&nbsp";
                                        }
                                    }
                                    return str;
                                }
                            },
                                {field: 'line1', title: '关联线路', align: 'center', width: '100'},
                                {field: 'update_time', title: '创建时间', align: 'center', width: '130'},
                                {field: 'show_order', title:'排序', align:'center', width:'30'},
                                {field: null, title: '操作', align: 'center', width: '110', formatter: function (item) {
                                        var button = '';
//                                        if (item.is_modify == 1) {
                                            button += '<a href="javascript:void(0);" onclick="edit(' + item.id + ')" class="tab-button but-blue">修改</a>&nbsp;';
//                                        }
                                        button += '<a href="javascript:void(0);" onclick="del(' + item.id + ');" class="tab-button but-red">删除</a><br/>';
                                        if(item.is_recommend==1){
                                        	button += '<a href="javascript:void(0);" onclick="indext(' + item.id + ',' + item.is_recommend + ');" class="tab-button but-red">取消app首页推荐</a>';
                                        }else{
                                        	button += '<a href="javascript:void(0);" onclick="indext(' + item.id + ',' + item.is_recommend + ');" class="tab-button but-red">app首页推荐</a>';
                                        }
                                        return button;
                                    }
                                }
                            ];
                            $("#dataTable").pageTable({
                                columns: columns,
                                url: '/admin/a/social/social_story/get_theme_data',
                                pageNumNow: 1,
                                searchForm: '#search-condition',
                                tableClass: 'table-data'
                            });
                            var formObj = $("#add-data");


							//添加弹出层
                            $("#add-button").click(function () {
                                formObj.find('input[type=text]').val('');
                                formObj.find('input[type=hidden]').val('');
                                formObj.find('textarea').val('');
                                formObj.find('img').attr('src', '');
                                $(".uploadvideo").attr("src","");
                                $(".fb-body,.mask-box").show();
                                $("input[name='order']").val(0);
                                $('.url_title').remove();
                                $("#imghead").attr("src","");
                                formObj.find("select option[value=0]").attr("selected", true); 
                                $('.img_input,.video_input').hide();
                            })

                            $("#add-data").submit(function () {
                                var id = $(this).find('input[name=id]').val();
                                var url = id > 0 ? '/admin/a/social/social_story/edit_social_theme' : '/admin/a/social/social_story/add_social_theme';
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    dataType: 'json',
                                    data: $(this).serialize(),
                                    success: function (data) {
                                        if (data.code == 2000) {
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/social/social_story/get_theme_data',
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
        $('.url_title').remove();
        $.ajax({
            url: '/admin/a/social/social_story/get_dtl_json',
            type: 'post',
            dataType: 'json',
            data: {id: id},
            success: function (data) {
                if (!$.isEmptyObject(data)) {
                    formObj.find('input[name=name]').val(data.name);
                    formObj.find('input[name=icon]').val(data.icon);  
                    formObj.find('img[name=icon_pic]').attr('src', window.location.protocol + '//' + document.domain + data.icon);
                    formObj.find('input[name=app_pic]').val(data.app_pic);  
                    formObj.find('img[name=app_pic]').attr('src', window.location.protocol + '//' + document.domain + data.app_pic);
                    formObj.find('textarea[name=description]').val(data.description);
                    formObj.find("select option[value="+data.theme_type+"]").attr("selected", true); 
                    if (data.theme_type === 2){     // 图片类型
                        formObj.find('input[name=theme_pic1]').val(data.pic1);   // 隐藏表单域
                        formObj.find('img[name=theme_pic1]').attr('src', window.location.protocol + '//' + document.domain + data.pic1);
                        formObj.find('input[name=theme_pic2]').val(data.pic2);   // 隐藏表单域
                        formObj.find('img[name=theme_pic2]').attr('src', window.location.protocol + '//' + document.domain + data.pic2);
                        formObj.find('input[name=theme_pic3]').val(data.pic3);   // 隐藏表单域
                        formObj.find('img[name=theme_pic3]').attr('src', window.location.protocol + '//' + document.domain + data.pic3);
                    }else if (1 === data.theme_type){  // 视频类型
                    	formObj.find('input[name=video1]').val(window.location.protocol + '//' + document.domain + data.video_url1);
                    	formObj.find('#uploadFile1').parent().append('<span class="url_title">' + data.video_url1 + '</span>');
                        formObj.find('input[name=video_pic1]').val(data.video_pic1);   // 隐藏表单域
                        formObj.find('img[name=video_pic1]').attr('src', window.location.protocol + '//' + document.domain + data.video_pic1);

                        formObj.find('input[name=video2]').val(window.location.protocol + '//' + document.domain + data.video_url2);
                    	formObj.find('#uploadFile2').parent().append('<span class="url_title">' + data.video_url2 + '</span>');
                        formObj.find('input[name=video_pic2]').val(data.video_pic2);   // 隐藏表单域
                        formObj.find('img[name=video_pic2]').attr('src', window.location.protocol + '//' + document.domain + data.video_pic2);

                        formObj.find('input[name=video3]').val(window.location.protocol + '//' + document.domain + data.video_url3);
                    	formObj.find('#uploadFile3').parent().append('<span class="url_title">' + data.video_url3 + '</span>');
                        formObj.find('input[name=video_pic3]').val(data.video_pic3);   // 隐藏表单域
                        formObj.find('img[name=video_pic3]').attr('src', window.location.protocol + '//' + document.domain + data.video_pic3);                                          
                    }
                    
                    formObj.find('input[name=id]').val(data.id);
                    formObj.find('input[name=line]').val(data.line1);
                    formObj.find('input[name=order]').val(data.show_order);
                    $(".fb-body,.mask-box").show();
                    if (data.theme_type == 0){
                        $('.video_input,.img_input').hide();
                    }else if (1 == data.theme_type){
                        $('.video_input').show();
                        $('.img_input').hide();
                    }else if (2 == data.theme_type){
                        $('.video_input').hide();
                        $('.img_input').show();
                    }
                } else {
                    alert('请确认您选择的数据');
                }
            }
        });
    }

    //删除
    function del(id) {
        if (confirm("您确定要删除吗?")) {
            $.post("/admin/a/social/social_story/del_social_theme", {id: id}, function (json) {
                var data = eval("(" + json + ")");
                if (data.code == 2000) {
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/social/social_story/get_theme_data',
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
    
    //app首页推荐
    function indext(id,status) {
    	if(status==1){
    		if (confirm("您确定要取消app首页推荐吗?")) {
        		$.post("/admin/a/social/social_story/indexVideoInfo",{id:id},function(json){
        			var data = eval("("+json+")");
        			if (data.code == 2000) {
        				alert(data.msg);
        				location.reload();
        			} else {
        				alert(data.msg);
        			}
        		});
        	}
		}else{
			if (confirm("您确定要在app首页推荐吗?")) {
	    		$.post("/admin/a/social/social_story/indexVideoInfo",{id:id},function(json){
	    			var data = eval("("+json+")");
	    			if (data.code == 2000) {
	    				alert(data.msg);
	    				location.reload();
	    			} else {
	    				alert(data.msg);
	    			}
	    		});
	    	}
		}
    	
    }

	//清除视频或图片数据
    function clear_data(obj,type){
		var clearObj = $(obj);
		if(type ==1){
			$('input[name=video1]').val('');
			$("#uploadFile1").nextAll(".url_title").remove();
			$("#uploadFile1").nextAll(".uploadvideo").remove();
			$('input[name=video_pic1]').val('');   // 隐藏表单域
			$('img[name=video_pic1]').attr('src', '');	
		}else if(type ==2){
			$('input[name=video2]').val('');
			$("#uploadFile2").nextAll(".url_title").remove();
			$("#uploadFile2").nextAll(".uploadvideo").remove();
			$('input[name=video_pic2]').val('');   // 隐藏表单域
			$('img[name=video_pic2]').attr('src', '');
		}else if(type ==3){
			$('input[name=video3]').val('');
			$("#uploadFile3").nextAll(".url_title").remove();
			$("#uploadFile3").nextAll(".uploadvideo").remove();
			$('input[name=video_pic3]').val('');   // 隐藏表单域
			$('img[name=video_pic3]').attr('src', '');
		}else if(type ==4){
			$('input[name=theme_pic1]').val('');   // 隐藏表单域
			$('img[name=theme_pic1]').attr('src', '');
		}else if(type ==5){
			$('input[name=theme_pic2]').val('');   // 隐藏表单域
			$('img[name=theme_pic2]').attr('src', '');
		}else if(type ==6){
			$('input[name=theme_pic3]').val('');   // 隐藏表单域
			$('img[name=theme_pic3]').attr('src', '');
		}
    }

    /**
     * @method ajax上传视频文件(文件上传地址统一使用一个)
     * @param file_id file控件的ID同时也是file控件的name值
     * @param name 上传返回的图片路径写入的input的name值
     * @param prefix 视频保存的前缀
     */
    function uploadVideoFile(obj) {
        var file_id = $(obj).attr("id");
        var inputObj = $(obj).nextAll("input[type='hidden']");
        $.ajaxFileUpload({
            url: '/admin/upload/uploadVideoFile',
            secureuri: false,
            fileElementId: file_id, // file标签的id
            dataType: 'json', // 返回数据的类型
            data: {
                fileId: file_id
            },
            success: function (data, status) {
                if (data.code == 2000) {
                    inputObj.siblings(".uploadvideo").remove();
                    inputObj.after("<video class='uploadvideo' src='" + data.msg.url + "' width='100' height='80'></video>");
                    inputObj.val(data.msg.url);
                } else {
                    alert(data.msg);
                }
            },
            error: function (data, status, e)// 服务器响应失败处理函数
            {
                alert('上传失败(请尝试重新上传)');
            }
        });
    }

    function check(obj){
        if (1 == $(obj).val()){
            $('.video_input').show();
            $('.img_input').hide();
            $('input[name=theme_pic1]').val('');   // 隐藏表单域
            $('img[name=theme_pic1]').attr('src', '');
            $('input[name=theme_pic2]').val('');   // 隐藏表单域
            $('img[name=theme_pic2]').attr('src', '');
            $('input[name=theme_pic3]').val('');   // 隐藏表单域
            $('img[name=theme_pic3]').attr('src', '');
        }else if (2 == $(obj).val()){
            $('.video_input').hide();
            $('.img_input').show();
            $('input[name=video1]').val('');
        	$('.url_title').remove();
            $('input[name=video_pic1]').val('');   // 隐藏表单域
            $('img[name=video_pic1]').attr('src', '');
            $('input[name=video2]').val('');
            $('input[name=video_pic2]').val('');   // 隐藏表单域
            $('img[name=video_pic2]').attr('src', '');
            $('input[name=video3]').val('');
            $('input[name=video_pic3]').val('');   // 隐藏表单域
            $('img[name=video_pic3]').attr('src', '');
        }else{
            $('.video_input').hide();
            $('.img_input').hide();
        }
    }


    /*-----------------------------------上传图片-----------------------------*/
	var imgProportion = {1:"710x309",2:"750x470",3:"334x220",4:"332:222"};
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
				xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg", false, xiuxiuEditor[type]);
			}			
			xiuxiu.onUploadResponse = function (data)
			{
				
				data = eval('('+data+')');
				if (data.code == 2000) {
					buttonObj.next("input").val(data.msg);

					if (type == 3) {
						//alert("上传成功");
						//buttonObj.after(data.msg);
						buttonObj.prev("img").attr("src",data.msg);
						buttonObj.prev("input").val(data.msg);
						buttonObj.next("span").html(data.msg);
					} else if (type == 2) {
						//buttonObj.css({'margin-top': '0px','margin-left': '110px'});
						buttonObj.prev("img").attr("src",data.msg);
						buttonObj.next('input').val(data.msg);
					} else if (type == 1){
						//buttonObj.css({'margin-top': '134px','margin-left': '384px'});
						buttonObj.prev("img").attr("src",data.msg);
						$('input[name="photo"]').val(data.msg);
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

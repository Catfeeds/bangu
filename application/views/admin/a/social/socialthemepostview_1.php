<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<style type="text/css">
	.col_span{ float: left;margin-top: 6px}
	.col_ip{ float: left; }
.col-sm-10{width: 76.333%}
.widget-body{box-shadow: none}
.form-horizontal .form-group input{width:auto}
#add-button{cursor: pointer; }
#add-button:hover{background: #3EAFE0}
</style>
<script type="text/javascript" src="//api.html5media.info/1.2.2/html5media.min.js"></script>

<div class="form-box fb-body">
    <div class="fb-content" style="width: 800px;left: 50%;margin-left: -400px;position: fixed;top: 20px; max-height: 600px; overflow-y: auto;">
        <div class="box-title">
            <h4>社区心情管理</h4>
            <span class="fb-close">x</span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="add-data" class="form-horizontal" >
                <div class="form-group">
                    <div class="fg-title">动态正文：<i>*</i></div>
                    <div class="fg-input">
                        <textarea name="content"></textarea>
                    </div>
                </div>
<!--                <div class="form-group">
                    <div class="fg-title">管家id：<i>*</i></div>
                    <div class="fg-input">
                        <input type="text" name="member_id" value="77">
                    </div>
                </div>-->
                <div class="form-group" id="user_type">
                    <div class="fg-title">用户类型：<i>*</i></div>
                    <div class="fg-input">
                        <select name="user_type" style="width:100px;">
                            <option value="0">请选择</option>
                            <option value="1" >官方用户</option>
                            <option value="2">普通用户</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">动态类型：<i>*</i></div>
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
                        <div class="fg-title">视频：<i>*</i></div>
                        <div class="fg-input">
                            <input name="uploadFile1" id="uploadFile1" onchange="uploadVideoFile(this);" type="file">
                            <input name="video" type="hidden" />
                        </div>
                    </div>
                    <div class="form-group">
                                            <div class="fg-title">视频封面图：<i>*</i></div>
                                            <img src="#" name="video_pic" style="width: 150px; height: 94px;" id="imghead">
                                            <input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">
                                            <input type="hidden" name="video_pic" id="pic" />
                                            <input class="btn" type="button" onclick="clear_data(this,1);" value="清除视频和视频封面图">
                    </div>
                    <div class="form-group">
                        <div class="fg-title">视频名称：<i>*</i></div>
                        <div class="fg-input">
                            <input name="video_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fg-title">视频标签：<i>*</i></div>
                        <div class="fg-input">
                            <input name="video_tag">
                        </div>
                    </div>
                </div>
                <div class="img_input">
                    <div class="form-group">
                            <div class="fg-title">图片1：<i>*</i></div>
                                            <img src="#" name="pic1" style="width: 150px; height: 94px;" id="imghead">
                                            <input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">			
                                            <input type="hidden" name="pic1" id="pic1" />
                                            <input class="btn" type="button" onclick="clear_data(this,2);" value="清除图片1">

                    </div>
                    <div class="form-group">
                            <div class="fg-title">图片2：<i>*</i></div>
                                            <img src="#" name="pic2" style="width: 150px; height: 94px;" id="imghead">
                                            <input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">					
                                            <input type="hidden" name="pic2" id="pic" />
                                            <input class="btn" type="button" onclick="clear_data(this,3);" value="清除图片2">
                    </div>
                    <div class="form-group">
                            <div class="fg-title">图片3：<i>*</i></div>
                                            <img src="#" name="pic3" style="width: 150px; height: 94px;" id="imghead">
                                            <input class="add_btn" type="button" onclick="uploadImgFile(this,2);" value="上传">					
                                            <input type="hidden" name="pic3" id="pic" />
                                            <input class="btn" type="button" onclick="clear_data(this,4);" value="清除图片3">
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">关联线路：</div>
                    <div class="fg-input">
                        <input name="line_id" type="text" value="0">
                        <span>(多个线路id用英文状态的逗号[,]隔开)[最多关联六条线路]</span>
                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="theme_id" value="<?php echo $theme_id ?>"/>
                    <input type="button" class="fg-but fb-close" value="取消" />
                    <input type="submit" class="fg-but" value="确定" />
                </div>
                <div class="clear"></div>
            </form>
        </div>
    </div>
</div>

<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">心情动态</li>
                        <li class="active"><?php echo $theme_name ?></li>
		</ul>
	</div>
	
						<div class="widget-body">
                                                    
							<div role="grid" id="simpledatatable_wrapper"
								class="dataTables_wrapper form-inline no-footer">
								<div id="simpledatatable_filter" >
									<label>

									</label>
								</div>
                                                            <a id="add-button" href="javascript:void(0);" class="but-default">添加 </a>
								<div class="dataTables_length" id="simpledatatable_length">
									<label></label>
								</div>
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="simpledatatable" aria-describedby="simpledatatable_info">
									<thead>
										<tr role="row">
											<th style="text-align:center">编号</th>
											<th style="text-align:center" width="200">正文</th>
                                                                                        <th style="text-align:center" >视频名称</th>
											<th style="text-align:center" >视频标签</th>
                                                                                        <th style="text-align:center" >视频</th>
                                                                                        <th style="text-align:center" >视频封面</th>
                                                                                        <th style="text-align:center" >图片1</th>
                                                                                        <th style="text-align:center" >图片2</th>
                                                                                        <th style="text-align:center" >图片3</th>
											<th style="text-align:center">操作时间</th>
                                                                                        <th style="text-align:center">操作</th>
										</tr>
									</thead>
									<tbody>
                                                                            <?php foreach ($posts as $item): ?>
                                                                                <tr>
                                                                                    <td class="sorting_1" style="text-align:center"><?php echo $item['id']; ?></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle"><?php echo $item['content']; ?></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle"><?php echo $item['video_name']; ?></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle"><?php echo $item['video_tag']; ?></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle"><video src="<?php echo $item['video_url'] ?>" width="100" height="100" controls preload></video></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle"><img src="<?php echo (strpos($item['video_pic'],'http://')===0)?$item['video_pic']:trim(base_url(''),'/').$item['video_pic'];?>" width="100px" /></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle"><img src="<?php echo (strpos($item['pic1'],'http://')===0)?$item['pic1']:trim(base_url(''),'/').$item['pic1'];?>" width="100px" /></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle"><img src="<?php echo (strpos($item['pic2'],'http://')===0)?$item['pic2']:trim(base_url(''),'/').$item['pic2'];?>" width="100px" /></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle"><img src="<?php echo (strpos($item['pic3'],'http://')===0)?$item['pic3']:trim(base_url(''),'/').$item['pic3'];?>" width="100px" /></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle"><?php echo date("Y-m-d H:i:s", $item['update_time']); ?></td>
                                                                                    <td class=" " style="text-align:center;vertical-align: middle">
                                                                                        <a href="javascript:void(0);" onclick="edit('<?php echo $item['id']; ?>');" class="btn btn-default btn-xs purple">编辑</a>									
                                                                                        <a href="javascript:void(0);" onclick="del('<?php echo $item['id']; ?>');"  class="btn btn-default btn-xs purple">删除</a>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach;?>
									</tbody>
								</table>
								<div class="pagination"><?php echo $this->page->create_page()?></div>
							</div>
						</div>	

	<!-- Page Body -->
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


<div class="modal-backdrop fade in" style="display:none;"></div>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script type="text/javascript" src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url() ;?>assets/js/jquery.extend.js"></script>
<script type="text/javascript" src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script type="text/javascript" src="<?php echo base_url() ;?>assets/js/admin/common.js"></script>
						
<script type="text/javascript">
    $(".fb-close").click(function(){
                    closebox();
		})
		function closebox() {
                    $(".fb-body,.mask-box,.detail-box,.form-box").fadeOut(500);
		}
		$('.box-close').click(function(){
                    $(".detail-box,.mask-box").fadeOut(500);
		});
                
    var formObj = $("#add-data");
    
    $("#add-button").click(function () {
        formObj.find('input[type=text]').val('');
//        formObj.find('input[type=hidden]').val('');
        formObj.find('textarea').val('');
        formObj.find('img').attr('src', '');
        $(".uploadvideo").attr("src","");
        $(".fb-body,.mask-box").show();
        $('#user_type').show();
        $('.url_title').remove();
        $("#imghead").attr("src","");
        formObj.find("select option[value=0]").attr("selected", true); 
        $('.img_input,.video_input').hide();
        });
                            
        $("#add-data").submit(function () {
            var id = $(this).find('input[name=id]').val();
//            var member_id = $(this).find('input[name=member_id]').val();
//            if (member_id == 0 || member_id.length === 0){
//                alert('管家id不能为空!');
//                return;
//            }
            var content = $(this).find('textarea[name=content]').val();
            if (content.length === 0){
                alert('正文不能为空!!');
                return;
            }
            var url = id > 0 ? '/admin/a/social/socialthemepost/edit_post_by_id' : '/admin/a/social/socialthemepost/add_post';
                $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: $(this).serialize(),
                success: function (data) {
                if (data.code == 2000) {
                    window.location.reload(true);
                } else {
                    alert(data.msg);
                }
            }
        });
        return false;
    });
                            
    
    function edit(id) {
        $('.url_title').remove();
        $.ajax({
            url: '/admin/a/social/socialthemepost/get_post_by_id',
            type: 'post',
            dataType: 'json',
            data: {post_id: id},
            success: function (data) {
                if (!$.isEmptyObject(data)) {
//                    alert(data.content);
                    formObj.find('textarea[name=content]').val(data.content);
                    formObj.find("select option[value="+data.post_type+"]").attr("selected", true); 
                    if (data.post_type === 1){     // 视频类型
                        formObj.find('input[name=video]').val(window.location.protocol + '//' + document.domain + data.video_url);
                    	formObj.find('#uploadFile1').parent().append('<span class="url_title">' + data.video_url + '</span>');
                        formObj.find('input[name=video_pic]').val(data.video_pic1);   // 隐藏表单域
                        formObj.find('img[name=video_pic]').attr('src', window.location.protocol + '//' + document.domain + data.video_pic);
                    }else if (2 === data.post_type){  // 图片类型
                        formObj.find('input[name=pic1]').val(data.pic1);   // 隐藏表单域
                        formObj.find('img[name=pic1]').attr('src', window.location.protocol + '//' + document.domain + data.pic1);
                        formObj.find('input[name=pic2]').val(data.pic2);   // 隐藏表单域
                        formObj.find('img[name=pic2]').attr('src', window.location.protocol + '//' + document.domain + data.pic2);
                        formObj.find('input[name=pic3]').val(data.pic3);   // 隐藏表单域
                        formObj.find('img[name=pic3]').attr('src', window.location.protocol + '//' + document.domain + data.pic3);
                    }
//                    formObj.find('input[name=id]').val(data.id);
                    formObj.find('input[name=line_id]').val(data.line_id);
//                    formObj.find('input[name=order]').val(data.show_order);
                    formObj.find('input[name=id]').val(data.id);
                    $(".fb-body,.mask-box").show();
                    $('#user_type').hide();
                    if (data.post_type == 0){
                        $('.video_input,.img_input').hide();
                    }else if (1 == data.post_type){
                        $('.video_input').show();
                        $('.img_input').hide();
                    }else if (2 == data.post_type){
                        $('.video_input').hide();
                        $('.img_input').show();
                    }
                } else {
                    alert('请确认您选择的数据');
                }
            }
        });
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
        if (1 == $(obj).val()){     // 视频
            $('.video_input').show();
            $('.img_input').hide();
//            $('input[name=theme_pic2]').val('');   // 隐藏表单域
//            $('img[name=theme_pic2]').attr('src', '');
//            $('input[name=theme_pic3]').val('');   // 隐藏表单域
//            $('img[name=theme_pic3]').attr('src', '');
        }else if (2 == $(obj).val()){       // 图片
            $('.video_input').hide();
            $('.img_input').show();
            $('input[name=video]').val('');
            $('.url_title').remove();
//            $('input[name=video_pic1]').val('');   // 隐藏表单域
//            $('img[name=video_pic1]').attr('src', '');
//            $('input[name=video2]').val('');
//            $('input[name=video_pic2]').val('');   // 隐藏表单域
//            $('img[name=video_pic2]').attr('src', '');
//            $('input[name=video3]').val('');
//            $('input[name=video_pic3]').val('');   // 隐藏表单域
//            $('img[name=video_pic3]').attr('src', '');
        }else{
            $('.video_input').hide();
            $('.img_input').hide();
        }
    }
    
    	//清除视频或图片数据
    function clear_data(obj,type){
		var clearObj = $(obj);
		if(type ==1){         // 清除视频和封面图
			$('input[name=video]').val('');
			$("#uploadFile1").nextAll(".url_title").remove();
			$("#uploadFile1").nextAll(".uploadvideo").remove();
			$('input[name=video_pic]').val('');   // 隐藏表单域
			$('img[name=video_pic]').attr('src', '');	
		}else if(type ==2){       // 清除图片1
			$('input[name=pic1]').val('');   // 隐藏表单域
			$('img[name=pic1]').attr('src', '');
		}else if(type ==3){     // 清除图片2
			$('input[name=pic2]').val('');   // 隐藏表单域
			$('img[name=pic2]').attr('src', '');
		}else if(type ==4){     // 清除图片3
			$('input[name=pic3]').val('');   // 隐藏表单域
			$('img[name=pic3]').attr('src', '');
		}
    }

/**
 * @method ajax上传图片文件(文件上传地址统一使用一个)
 * @param file_id file控件的ID同时也是file控件的name值
 * @param name 上传返回的图片路径写入的input的name值
 * @param prefix 图片保存的前缀
 */
function uploadImgFilelive(obj) {
	var file_id = $(obj).attr("id");
	var inputObj = $(obj).nextAll("input[type='hidden']");
	$.ajaxFileUpload({
	    url : '/admin/upload/uploadImgFilelive',
	    secureuri : false,
	    fileElementId : file_id,// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : {
	    	fileId : file_id
	    },
	    success : function(data, status) {
		    if (data.code == 2000) {
		    	inputObj.siblings(".uploadImg").remove();
		    	inputObj.after("<img class='uploadImg' src='" + data.msg + "' width='80'>");
		    	inputObj.val(data.msg);
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

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='video_id']").val();
	if (id.length ==0) {	
		alert("视频id错误");
		return false;
	}
		var url = "/admin/a/live/video/editVideo";

	$.post(url,$(this).serialize(),function(data){
		var data = eval("("+data+")");
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
                        edit();
		} else {
			alert(data.msg);
		}
	})
	return false;
})

$(".close-button").click(function(){
	$(".bootbox,.modal-backdrop").hide();
})

function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/social/socialthemepost/del",{post_id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				window.location.reload(true);
			} else {
				alert(data.msg);
			}
		});
	}
}



/*-----------------------------------上传图片-----------------------------*/
	var imgProportion = {1:"710x309",2:"750x470",3:"5:5",4:"332:222"};
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




<style type="text/css">
.page-content{ min-width: auto !important; }
.video_input,.img_input { display: none;}
input[type=file]{width:66px !important;border: 0 !important;}
div{font-size: 14px}
</style>
<div class="page-content">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo site_url('admin/a/') ?>"> 首页 </a>
        </li>
        <li class="active"><span>/</span>社区动态管理</li>
    </ul>
    <div class="page-body">
        <div class="tab-content">
            <select id="sel_theme" name="type" style="width:200px;">
                            <option value="0">请选择</option>
            </select>
            <a id="search-button" href="javascript:void(0);" class="but-default" style="float:none; display: inline-block;">查看 </a>
            <!--<div id="dataTable"></div>-->
        </div>
        <div class="tab-content">
            当前主题:<label id="cur_theme" style="display:inline-block;width:200px"></label>
            动态数:<label id="post_cnt" style="display:inline-block;width:200px">0</label>
            <a id="add-button" href="javascript:void(0);" class="but-default" style="float:none; display: inline-block;">添加 </a>
            <div id="dataTable"></div>
        </div>
    </div>
</div>


<div id='posts' class='page-content'></div>


<!-- 弹出框-->
<div class="form-box fb-body">
    <div class="fb-content" style="width: 800px;left: 50%;margin-left: -400px;position: fixed;top: 20px; max-height: 600px; overflow-y: auto;">
        <div class="box-title">
            <h4>社区主题</h4>
            <span class="fb-close">x</span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="add-data" class="form-horizontal" >
                <div class="form-group">
                    <div class="fg-title">选择主题：<i>*</i></div>
                    <div class="fg-input">
                        <select id="choose_theme" name="choose_theme" style="width:200px;">
                            
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">动态标题：<i>*</i></div>
                    <div class="fg-input">
                        <textarea name="title" maxlength="30" placeholder="最多30个字符"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">动态正文：<i>*</i></div>
                    <div class="fg-input">
                        <textarea name="description" maxlength="300" placeholder="最多300个字"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">请选择帖子类型：<i>*</i></div>
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
                            <input name="video1" type="hidden" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fg-title">视频封面图：<i>*</i></div>
                        <div class="fg-input">
                            <input name="upload_video_pic1" id="upload_video_pic1" onchange="uploadImgFile(this);" type="file">
                            <input name="video_pic1" type="hidden" />
                            <img name="video_pic1" height="100"/>
                        </div>
                    </div>
                </div>
                <div class="img_input">
                    <div class="form-group">
                        <div class="fg-title">社区帖子图片1：<i>*</i></div>
                        <div class="fg-input">
                            <input name="upload_pic1" id="upload_pic1" onchange="uploadImgFile(this);" type="file">
                            <input name="theme_pic1" type="hidden" />
                            <img name = "theme_pic1" height="100"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fg-title">社区帖子图片2：</div>
                        <div class="fg-input">
                            <input name="upload_pic2" id="upload_pic2" onchange="uploadImgFile(this);" type="file">
                            <input name="theme_pic2" type="hidden" />
                            <img name="theme_pic2" height="100"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fg-title">社区帖子图片3：</div>
                        <div class="fg-input">
                            <input name="upload_pic3" id="upload_pic3" onchange="uploadImgFile(this);" type="file">
                            <input name="theme_pic3" type="hidden" />
                            <img name="theme_pic3" height="100"/>
                        </div>
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
<script src="<?php echo base_url(); ?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js'); ?>"></script>
<script type="text/javascript">
    //添加弹出层
                            var formObj = $("#add-data");
                            $("#add-button").click(function () {
                                formObj.find('input[type=text]').val('');
                                formObj.find('input[type=hidden]').val('');
                                formObj.find('textarea').val('');
                                formObj.find('img').attr('src', '');
//                                $('.uploadImg').remove();
                                $(".fb-body,.mask-box").show();
//                                $(".uploadvideo").remove();
                                $("input[name='order']").val(0);
                                $('.url_title').remove();
                                formObj.find("select option[value=0]").attr("selected", true); 
                                $('.img_input,.video_input').hide();
                            });

                            $("#add-data").submit(function () {
                                var id = $(this).find('input[name=id]').val();
                                var url = id > 0 ? '/admin/a/social/socialtheme/edit_social_theme' : '/admin/a/social/socialtheme/add_social_theme';
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    dataType: 'json',
                                    data: $(this).serialize(),
                                    success: function (data) {
                                        if (data.code == 2000) {
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/social/socialtheme/get_theme_data',
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
    });

    function edit(id) {
        $('.url_title').remove();
        $.ajax({
            //url: '/admin/a/cfg_mobile/roll_pic/getDetailJson',
            //url: '/admin/a/social/socialtheme/edit_social_theme',
            url: '/admin/a/social/socialtheme/get_dtl_json',
            type: 'post',
            dataType: 'json',
            data: {id: id},
            success: function (data) {
                if (!$.isEmptyObject(data)) {
                    formObj.find('input[name=name]').val(data.name);
                    formObj.find('textarea[name=description]').val(data.description);
                    //formObj.find('select[name=type]').val(data.description);
                    formObj.find("select option[value="+data.theme_type+"]").attr("selected", true); 
                    //formObj.find('input[name=pic]').val(data.pic);
//                    alert(document.domain);
//                    formObj.find('input[name=upload_pic1]').val(window.location.protocol + '//' + document.domain + data.pic);
                    if (data.theme_type === 2){     // 图片类型
                        formObj.find('input[name=theme_pic1]').val('');   // 隐藏表单域
                        formObj.find('img[name=theme_pic1]').attr('src', '');
                        formObj.find('input[name=theme_pic2]').val('');   // 隐藏表单域
                        formObj.find('img[name=theme_pic2]').attr('src', '');
                        formObj.find('input[name=theme_pic3]').val('');   // 隐藏表单域
                        formObj.find('img[name=theme_pic3]').attr('src', '');
                            if (data.pic.length > 0){
                                if (data.pic[data.pic.length - 1] === ','){         // 如果字符串最后面有',',则去除
                                    data.pic = data.pic.substring(0, data.pic.length - 1);
                                }
                                arr_pic = data.pic.split(',');
                                if (1 === arr_pic.length){                                    
                                    formObj.find('input[name=theme_pic1]').val(data.pic);   // 隐藏表单域
                                    formObj.find('img[name=theme_pic1]').attr('src', window.location.protocol + '//' + document.domain + data.pic);
                                }else if (2 === arr_pic.length){
                                    formObj.find('input[name=theme_pic1]').val(arr_pic[0]);   // 隐藏表单域
                                    formObj.find('img[name=theme_pic1]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[0]);
                                    if (arr_pic[1] !== ''){
                                        formObj.find('input[name=theme_pic2]').val(arr_pic[1]);   // 隐藏表单域
                                        formObj.find('img[name=theme_pic2]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[1]);
                                    }
                                }else if (3 === arr_pic.length){
                                    formObj.find('input[name=theme_pic1]').val(arr_pic[0]);   // 隐藏表单域
                                    formObj.find('img[name=theme_pic1]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[0]);
                                    formObj.find('input[name=theme_pic2]').val(arr_pic[1]);   // 隐藏表单域
                                    formObj.find('img[name=theme_pic2]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[1]);
                                    if (arr_pic[2] !== ''){
                                        formObj.find('input[name=theme_pic3]').val(arr_pic[2]);   // 隐藏表单域
                                        formObj.find('img[name=theme_pic3]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[2]);
                                    }
                                }
                        }
                    }else if (1 === data.theme_type){  // 视频类型
                        formObj.find('input[name=video_pic1]').val('');   // 隐藏表单域
                        formObj.find('img[name=video_pic1]').attr('src', '');
                        formObj.find('input[name=video_pic2]').val('');   // 隐藏表单域
                        formObj.find('img[name=video_pic2]').attr('src', '');
                        formObj.find('input[name=video_pic3]').val('');   // 隐藏表单域
                        formObj.find('img[name=video_pic3]').attr('src', '');
                        if (data.pic.length > 0){
                                if (data.pic[data.pic.length - 1] === ','){         // 如果字符串坐后面有',',则去除
                                    data.pic = data.pic.substring(0, data.pic.length - 1);
                                }
                                arr_pic = data.pic.split(',');
                                if (data.video_url[data.video_url.length - 1] === ','){         // 如果字符串坐后面有',',则去除
                                    data.video_url = data.video_url.substring(0, data.video_url.length - 1);
                                }
                                arr_url = data.video_url.split(',');
                                if (1 === arr_pic.length && 1 === arr_url.length){
                                    formObj.find('#uploadFile1').parent().append('<span class="url_title">' + data.video_url + '</span>');
                                    formObj.find('input[name=video_pic1]').val(data.pic);   // 隐藏表单域
                                    formObj.find('img[name=video_pic1]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[0]);
                                }else if (2 === arr_pic.length && 2 === arr_url.length){
                                    formObj.find('#uploadFile1').parent().append('<span class="url_title">' + arr_url[0] + '</span>');
                                    formObj.find('input[name=video_pic1]').val(arr_pic[0]);   // 隐藏表单域
                                    formObj.find('img[name=video_pic1]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[0]);
                                    formObj.find('#uploadFile2').parent().append('<span class="url_title">' + arr_url[1] + '</span>');
                                    formObj.find('input[name=video_pic2]').val(arr_pic[1]);   // 隐藏表单域
                                    formObj.find('img[name=video_pic2]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[1]);
                                }else if (3 === arr_pic.length && 3 === arr_url.length){
                                    formObj.find('#uploadFile1').parent().append('<span class="url_title">' + arr_url[0] + '</span>');
                                    formObj.find('input[name=video_pic1]').val(arr_pic[0]);   // 隐藏表单域
                                    formObj.find('img[name=video_pic1]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[0]);
                                    formObj.find('#uploadFile2').parent().append('<span class="url_title">' + arr_url[1] + '</span>');
                                    formObj.find('input[name=video_pic2]').val(arr_pic[1]);   // 隐藏表单域
                                    formObj.find('img[name=video_pic2]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[1]);
                                    formObj.find('#uploadFile3').parent().append('<span class="url_title">' + arr_url[2] + '</span>');
                                    formObj.find('input[name=video_pic3]').val(arr_pic[2]);   // 隐藏表单域
                                    formObj.find('img[name=video_pic3]').attr('src', window.location.protocol + '//' + document.domain + arr_pic[2]);
                                }
                        }
                    }
                    
                    formObj.find('input[name=id]').val(data.id);
//                    formObj.find('textarea[name=remark]').val(data.remark);
//                    formObj.find("input[name='is_show'][value=" + data.is_show + "]").attr("checked", true);
//                    formObj.find("input[name='is_modfiy'][value=" + data.is_modfiy + "]").attr("checked", true);
//                    $(".uploadImg").remove();
//                    $("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
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
            $.post("/admin/a/social/socialtheme/del_social_theme", {id: id}, function (json) {
                var data = eval("(" + json + ")");
                if (data.code == 2000) {
                    $("#dataTable").pageTable({
                        columns: columns,
                        url: '/admin/a/social/socialtheme/get_theme_data',
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
                    alert(data.msg);
                    inputObj.siblings(".uploadvideo").remove();
                    inputObj.after("<video class='uploadvideo' src='" + data.msg + "' width='100' height='80'></video>");
//                    inputObj.html("<video class='uploadvideo' src='" + data.msg + "' width='100' height='80'></video>");
                    inputObj.val(data.msg);
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
    
    function uploadImgFile(obj){
        var file_id = $(obj).attr("id");
        var inputObj = $(obj).nextAll("input[type='hidden']");
        $.ajaxFileUpload({
            url: '/admin/upload/uploadImgFile',
            secureuri: false,
            fileElementId: file_id, // file标签的id
            dataType: 'json', // 返回数据的类型
            data: {
                fileId: file_id
            },
            success: function (data, status) {
                if (data.code == 2000) {
                    inputObj.siblings(".uploadImg").remove();
                    inputObj.siblings('img ').attr('src', data.msg);
//                    inputObj.after("<img class='uploadImg' src='" + data.msg + "' width='100' height='80'></img>");
                    inputObj.val(data.msg);
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

    // 主题种类选择
    function check(obj){
        if (1 == $(obj).val()){
            $('.video_input').show();
            $('.img_input').hide();
        }else if (2 == $(obj).val()){
            $('.video_input').hide();
            $('.img_input').show();
        }else{
            $('.video_input').hide();
            $('.img_input').hide();
        }
    }
    
// TODO 分页
    // 获取帖子相关信息
    function get_post_data(theme_id){
        $.ajax({
            url: '/admin/a/social/socialthemepost/get_post_data',
            type: 'POST',
            dataType: 'json',
            data: {theme_id : theme_id},
            success: function (data) {
                $.each(data, function(i, item){
                        $.each(item, function(k, v){
                            if ('title' === k){
                                var txt_title = $('<h2></h2>').text('标题:'+v);
                                $('#posts').append(txt_title);
                            }
                            if (k === 'content'){
                                var txt_content = $('<div></div>').text(v);
                                $('#posts').append(txt_content);
                            }
                            if (k === 'replies'){
                                // 遍历故事回复
                                $.each(v, function(key, val){
                                    $.each(val, function(k_reply, v_reply){
                                        if ('content' === k_reply){
                                            var txt_reply = $('<div></div>').text('回复:' + v_reply);
                                            $('#posts').append(txt_reply);
                                        }
                                    });
                                });
                            }
                        });
                    });
            }
        });
        // 设置动态数量
        $.ajax({
            url: '/admin/a/social/socialthemepost/get_post_count_by_id',
            type: 'POST',
            dataType: 'JSON',
            data: {id: theme_id},
            success: function(data){
                $('#post_cnt').text(data);
            }
        });
    }
    
    // 动态添加option元素
    $.ajax({
        url: '/admin/a/social/socialthemepost/get_theme_data',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, item) {
                if (i === 'data'){
                    $.each(item, function(key, val){
                        $("#sel_theme").append("<option value="+val.id+">"+val.name+"</option>");
                    });
                }
            });
        }
    });
    
    // 主题选择框
    jQuery("#sel_theme").change(function(){
        var checkValue = jQuery("#sel_theme").val(); // 获取Select选中项的Value
        var checkText = jQuery("#sel_theme :selected").text(); // 获取Select选中项的Text
        $('#cur_theme').text(checkText);    // 当前选中的主题名称
        if (checkText === '请选择'){
            $('#cur_theme').empty();
        }
        var id = checkValue;
        // 通过ajax请求获取当前选中的主题的动态数量
        var url = '/admin/a/social/socialthemepost/get_post_count_by_id';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: {id: id},
            success: function(data){
                $('#post_cnt').text(data);
                $('#posts').empty();    // 清空div中的内容
                get_post_data(id);
            }
        });
    });
    get_post_data(0);

    // 获取弹出框中主题选择框的内容
    $.ajax({
        url: '/admin/a/social/socialthemepost/get_theme_data',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, item) {
                if (i === 'data'){
                    $.each(item, function(key, val){
                        $("#choose_theme").append("<option value="+val.id+">"+val.name+"</option>");
                    });
                }
            });
        }
    });
        
    
</script>

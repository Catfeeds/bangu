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
        <li class="active"><span>/</span>首页轮播图</li>
    </ul>
    <div class="page-body">
        <div class="tab-content">
            <a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
            <div id="dataTable"></div>
        </div>
    </div>
</div>

<div class="form-box fb-body">
    <div class="fb-content" style="max-height:600px;overflow-y:auto; ">
        <div class="box-title">
            <h4>手机端轮播图</h4>
            <span class="fb-close">x</span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="add-data" class="form-horizontal" >
            	<div class="form-group">
                    <div class="fg-title">分类：</div>
                    <div class="fg-input">
                        <select name="kind" class="selector kind">
                            <option value="0">请选择</option>
							<!-- <option value="1">首页</option> -->
                            <option value="2">产品页</option>
                            <option value="3">目的地页</option>
                            <option value="4">国内</option>
                            <option value="5">出境</option>
                            <option value="6">周边</option>
                            <option value="7">APP首页</option>
                            <!--<option value="8">直播管家页</option>-->
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">名称：</div>
                    <div class="fg-input">
                        <input type="text" name="name" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">图片：<i>*</i></div>
                    <div class="fg-input">
                        <input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
                        <input name="pic" type="hidden" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="fg-title">链接：</div>
                    <div class="fg-input">
                        <select name="link" oninput="check_val(this);" class="selector link">
                            <option value="0">请选择</option>
                            <option value="1">管家详情页</option>
                            <option value="2">线路详情页</option>
                            <option value="3">目的线路列表页</option>
                            <option value="4">视频播放页</option>
                            <option value="5">问答首页</option>
                            <option value="6">问答主题页</option>
                            <option value="7">心情首页</option>
                            <option value="8">心情主题页</option>
                            <option value="9">故事首页</option>
                            <option value="10">故事主题页</option>
                            <option value="11">直播首页</option>
                            <option value="12">短视频首页</option>
                            <option value="13">服务首页</option>
                            <option value="14">外部活动页</option>
                            <option value="15">手机浏览器页</option>
                            <option value="16">全屏活动页</option>
                        </select>
                    </div>
                </div>
                <div class="form-group canshu">
                    <div class="fg-title">参数：</div>
                    <div class="fg-input"><input type="text" name="link_param" /></div>
                </div>
                <div class="form-group jump_url">
                    <div class="fg-title">跳转页面url：<i>*</i></div>
                    <div class="fg-input"><input type="text" name="jump_url" /></div>
                    <span>请注意：填写url时请加上地址前缀(http://或者https://)</span>
                </div>
                <div class="form-group action">
                    <div class="fg-title">活动名称：<i>*</i></div>
                    <div class="fg-input"><input type="text" name="action_name" /></div>
                </div>
                <div class="form-group action">
                    <div class="fg-title">活动页面url：<i>*</i></div>
                    <div class="fg-input"><input type="text" name="share_url" /></div>
                    <span>请注意：填写url时请加上地址前缀(http://或者https://)</span>
                </div>
                <div class="form-group action">
                    <div class="fg-title">分享标题：<i>*</i></div>
                    <div class="fg-input"><input type="text" name="activity_name" /></div>
                </div>
                <div class="form-group action">
                    <div class="fg-title">分享描述：<i>*</i></div>
                    <div class="fg-input"><input type="text" name="activity_describe" /></div>
                </div>
                <div class="form-group action">
					<div class="fg-title">分享小图片：<i>*</i></div>
					<img src="#" name="activity_pic" style="width: 150px; height: 94px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadImgFiles(this,2);" value="上传">
					<input type="hidden" name="activity_pic" id="pic" />
                </div>
                <div class="form-group action">
                    <div class="fg-title">分享页面url：<i>*</i></div>
                    <div class="fg-input"><input type="text" name="url" /></div>
                    <span>请注意：填写url时请加上地址前缀(http://或者https://)</span>
                </div>
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
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div id="xiuxiu_box3" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<script src="<?php echo base_url("assets/js/admin/common.js"); ?>"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js'); ?>"></script>
<script>
	$(".canshu").hide();
	$(".action").hide();
	$(".jump_url").hide();
	function check_val(obj){
		var val = $(obj).val();
		$('input[name=link_param]').val('');
		if(val==14){
			$('input[name=link_param]').val('');
			$(".canshu").hide();
			$('input[name=jump_url]').val('');
			$(".jump_url").hide();
			$('img[name=activity_pic]').attr('src', '');
			$(".action").show();
		}else if(val==15 || val==16){
			$('input[name=link_param]').val('');
			$(".canshu").hide();
			$('input[name=activity_name]').val('');
			$('input[name=action_name]').val('');
			$('input[name=activity_pic]').val('');   
			$('img[name=activity_pic]').attr('src', '');
			$('input[name=activity_describe]').val('');
			$('input[name=share_url]').val('');
			$('input[name=url]').val('');
			$(".action").hide();
			$('input[name=jump_url]').val('');
			$(".jump_url").show();
		}else{
			$('input[name=link_param]').val('');
			$(".canshu").show();
			$('input[name=activity_name]').val('');
			$('input[name=action_name]').val('');
			$('input[name=activity_pic]').val('');   
			$('img[name=activity_pic]').attr('src', '');
			$('input[name=activity_describe]').val('');
			$('input[name=share_url]').val('');
			$('input[name=url]').val('');
			$(".action").hide();
			$('input[name=jump_url]').val('');
			$(".jump_url").hide();
		}
	}


                            var columns = [
								{field: null, title: '分类', align: 'center', width: '160', formatter: function (item) {
//								    if (item.kind == 1)
//								        return '首页';
								    if (item.kind == 2)
								        return '产品页';
								    if (item.kind == 3)
								        return '目的地页';
								    if (item.kind == 4)
								        return '国内';
								    if (item.kind == 5)
								        return '出境';
								    if (item.kind == 6)
								        return '周边';
								    if (item.kind == 7)
								        return 'APP首页';
//								    if (item.kind == 8)
//								        return '直播管家页';
								}
								},
                                {field: 'name', title: '名称', width: '300', align: 'center'},
                                {field: null, title: '图片', width: '80', align: 'center', formatter: function (item) {
                                        return "<a href='" + item.pic + "' target='_blank'>图片预览</a>";
                                    }
                                },
                                {field: null, title: '链接页面', align: 'center', width: '160', formatter: function (item) {
                                    if (item.link == 1)
                                        return '管家详情页';
                                    if (item.link == 2)
                                        return '线路详情页';
                                    if (item.link == 3)
                                        return '目的线路列表页';
                                    if (item.link == 4)
                                        return '视频播放页';
                                    if (item.link == 5)
                                        return '问答首页';
                                    if (item.link == 6)
                                        return '问答主题页';
                                    if (item.link == 7)
                                        return '心情首页';
                                    if (item.link == 8)
                                        return '心情主题页';
                                    if (item.link == 9)
                                        return '故事首页';
                                    if (item.link == 10)
                                        return '故事主题页';
                                    if (item.link == 11)
                                        return '直播首页';
                                    if (item.link == 12)
                                        return '短视频首页';
                                    if (item.link == 13)
                                        return '服务首页';
                                    if (item.link == 14)
                                        return '外部活动页';
                                    if (item.link == 15)
                                        return '手机浏览器页';
                                    if (item.link == 16)
                                        return '全屏活动页';
                                    if (item.link == 0)
                                        return '';
                                }
                                },
                                {field: 'param', title: '参数', width: '150', align: 'center'},
                                {field: 'jump_url', title: '跳转页面url', width: '300', align: 'center'},
                                {field: 'action_name', title: '活动名称', width: '300', align: 'center'},
                                {field: 'share_url', title: '活动页面url', width: '300', align: 'center'},
                                {field: 'activity_name', title: '分享标题', width: '300', align: 'center'},
                                {field: 'activity_describe', title: '分享描述', width: '300', align: 'center'},
                                {field :false,title : '分享小图片',align : 'center', width : '100',formatter:function(item){
                                    if(item.activity_pic==''){
											return '';
                                    }                                    
                        			return '<img src="<?php echo trim(base_url(''),'/');?>'+item.activity_pic+'" width="200" />';
                        		}},
                                {field: 'url', title: '分享页面url', width: '300', align: 'center'},
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
                                url: '/admin/a/cfg_mobile/roll_pic/getRollPicData',
                                pageNumNow: 1,
                                searchForm: '#search-condition',
                                tableClass: 'table-data'
                            });
                            var formObj = $("#add-data");

//添加弹出层
                            $("#add-button").click(function () {
                            	$(".selector").val('');
                            	$(".action").hide();
                            	$(".jump_url").hide();
                                formObj.find('input[type=text]').val('');
                                formObj.find('input[type=hidden]').val('');
                                formObj.find('textarea').val('');
                                formObj.find("input[name='is_show'][value=1]").attr("checked", true);
                                formObj.find("input[name='is_modfiy'][value=1]").attr("checked", true);
                                $('input[name=activity_pic]').val('');   
                    			$('img[name=activity_pic]').attr('src', '');
                                $('.uploadImg').remove();
                                $(".fb-body,.mask-box").show();
                            })

                            $("#add-data").submit(function () {
                                var id = $(this).find('input[name=id]').val();
                                var url = id > 0 ? '/admin/a/cfg_mobile/roll_pic/edit' : '/admin/a/cfg_mobile/roll_pic/add';
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    dataType: 'json',
                                    data: $(this).serialize(),
                                    success: function (data) {
                                        if (data.code == 2000) {
                                            $("#dataTable").pageTable({
                                                columns: columns,
                                                url: '/admin/a/cfg_mobile/roll_pic/getRollPicData',
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
                                    url: '/admin/a/cfg_mobile/roll_pic/getDetailJson',
                                    type: 'post',
                                    dataType: 'json',
                                    data: {id: id},
                                    success: function (data) {
                                        if (!$.isEmptyObject(data)) {
                                        	$(".selector").val('');
                                        	formObj.find('input[type=text]').val('');                                      	
                                        	formObj.find(".link option[value="+data.link+"]").attr("selected", true);
                                            if(data.type==2){
                                                $(".canshu").hide();
                                                $(".jump_url").hide();
                                            	$(".action").show();
                                            	formObj.find('input[name=activity_name]').val(data.activity_name);
                                            	formObj.find('input[name=action_name]').val(data.action_name);
                                            	formObj.find('input[name=activity_pic]').val(data.activity_pic);  
                                                formObj.find('img[name=activity_pic]').attr('src', window.location.protocol + '//' + document.domain + data.activity_pic);
                                            	formObj.find('input[name=activity_describe]').val(data.activity_describe);
                                            	formObj.find('input[name=share_url]').val(data.share_url);
                                            	formObj.find('input[name=url]').val(data.url);                                          	
                                            }else if(data.type==3 || data.type==4){
                                            	$(".canshu").hide();
                                            	$(".action").hide();
                                            	$(".jump_url").show();
                                            	formObj.find('input[name=jump_url]').val(data.jump_url);
                                            }else
                                            {                                                
                                            	$(".canshu").show();
                                            	$(".jump_url").hide();
                                            	$(".action").hide();
                                            	formObj.find('input[name=link_param]').val(data.param);
                                            }
                                            
                                            formObj.find('input[name=name]').val(data.name);
                                            formObj.find('input[name=showorder]').val(data.showorder);
                                            formObj.find('input[name=pic]').val(data.pic);                                           
                                            formObj.find('input[name=id]').val(data.id);
                                            formObj.find('textarea[name=remark]').val(data.remark);
                                            formObj.find(".kind option[value="+data.kind+"]").attr("selected", true);
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
                                    $.post("/admin/a/cfg_mobile/roll_pic/delHotLine", {id: id}, function (json) {
                                        var data = eval("(" + json + ")");
                                        if (data.code == 2000) {
                                            $("#dataTable").pageTable({
                                                columns: columns,
                                                url: '/admin/a/cfg_mobile/roll_pic/getRollPicData',
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
                        	var imgProportion = {1:"710x309",2:"750x470",3:"5:5",4:"332:222"};
                        	var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3",4:"xiuxiu_box4"};
                        	var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3",4:"xiuxiuEditor4"};
                        	function uploadImgFiles(obj ,type){			
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
                        						$('input[name="activity_pic"]').val(data.msg);
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

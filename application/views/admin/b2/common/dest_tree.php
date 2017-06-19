


<link href="<?php echo base_url("assets/ht/js/ztree/zTreeStyle.css"); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/ztree/jquery.ztree.core.js"); ?>"></script>

<style type="text/css">

li.title {list-style: none;}
ul.list {margin-left: 17px;}
ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:220px;height:360px;overflow-y:scroll;overflow-x:auto;}

</style>

<SCRIPT type="text/javascript">

function send_ajax_noload(url,data){  //发送ajax请求，无加载层
      //没有加载效果
    var ret;
	  $.ajax({
  	 url:url,
  	 type:"POST",
       data:data,
       async:false,
       dataType:"json",
       success:function(data){
      	 ret=data;

       },
       error:function(){
      	 ret=data;
       }

  	});
	    return ret;

}
function get_zNodes(post_url,data)
{
	 if(data==undefined || data.length==0||data=="") data={};
	  var zNodes = null;
	  var post_url="<?php echo base_url('admin/b2/comboBox/api_tree_dest')?>";
      var return_data=send_ajax_noload(post_url,data);
      zNodes=return_data.data;
      for(var i in zNodes)
       {
           if(parseInt(zNodes[i].open)==1)
           {
          	 zNodes[i].open=true; //将open为1的改为true
          	 zNodes[i].isParent=true;
           }
           else
           {
          	 zNodes[i].open=false;
	       }
	       
           if(parseInt(zNodes[i].level)<=3)
           {
          	 zNodes[i].isParent=true;
           }
           else
           {
        	   zNodes[i].isParent=false;
           }
       }
      return zNodes;
}
//end

		var tree_input_id="";
		var setting = {
			view: {
				dblClickExpand: false
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeClick: beforeClick,
				onClick: onClick
			}
		};

         //数据
            var post_url="<?php echo base_url('admin/b2/comboBox/api_tree_dest')?>";
		    var zNodes = get_zNodes(post_url);

        //数据 end
		function beforeClick(treeId, treeNode) {
			var check = (treeNode && !treeNode.isParent);
			//if (!check) alert("只能选择城市...");
			//return check;
		}

		function onClick(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			nodes = zTree.getSelectedNodes(),
			v = "";
			var data_id="";
			nodes.sort(function compare(a,b){return a.id-b.id;});
			for (var i=0, l=nodes.length; i<l; i++) {
				v += nodes[i].name + ",";
				data_id += nodes[i].id + ",";
			}
			if (v.length > 0 ) v = v.substring(0, v.length-1);
			if (data_id.length > 0 ) data_id = data_id.substring(0, data_id.length-1);

			var cityObj = $("#"+tree_input_id);
			cityObj.attr("value", v);
			cityObj.attr("data-id",data_id);
			$(cityObj).next("input[name='destid']").val(data_id);
			if(nodes[0].type==0){  //用于供应商添加单项时的销售对象
				cityObj.attr("data-value",'-1');
			}else if(nodes[0].type==1){
				cityObj.attr("data-value", nodes[0].expert_id);
				cityObj.attr("data-id", nodes[0].expert_id);
				expert_id
			}

			hideMenu();
		}
        //  up_or_down:收到调整的上下距离；add_width：手动调整的宽度
		function showMenu(id,value,up_or_down,add_width) {
			
			var post_url="<?php echo base_url('admin/b2/comboBox/api_tree_dest')?>";
			var new_zNodes=get_zNodes(post_url,{value:value});
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);

			tree_input_id=id;
			var cityObj = $("#"+id);
			var value=$("#"+id).val();
			if(value=="")
			{
				$("#input_dest").val("");
			}
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight()+ up_or_down + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999");
            
			$("#treeDemo").css("width",inputWidth+add_width); //等于input的长

			$("body").bind("mousedown", onBodyDown);
		}
		/*  情况二 （场景：营业部管理） */
		function showMenu2(id) {
			var post_url="<?php echo base_url('admin/b2/comboBox/api_level_one')?>";

			var new_zNodes=get_zNodes(post_url);
			/* if(new_zNodes[0].id!=0) //若没有顶级，则增加顶级
			new_zNodes.unshift({id:0,pId:0,level:0,name:'顶级营业部',open:true}); */
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);

			tree_input_id=id;
			var cityObj = $("#"+id);
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999");

			$("#treeDemo").css("width",inputWidth); //等于input的长

			$("body").bind("mousedown", onBodyDown);
		}
		/*  情况三：出发地 */
		function showMenu_startplace(id) {

			var post_url="<?php echo base_url('admin/b2/comboBox/api_tree_startplace')?>";

			var new_zNodes=get_zNodes(post_url);
			/* if(new_zNodes[0].id!=0) //若没有顶级，则增加顶级
			new_zNodes.unshift({id:0,pId:0,level:0,name:'顶级营业部',open:true}); */
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);

			tree_input_id=id;
			var cityObj = $("#"+id);
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999");

			$("#treeDemo").css("width",inputWidth); //等于input的长

			$("body").bind("mousedown", onBodyDown);
		}
		/*  情况三：供应商添加出发地 */
		function showMenu_s_startplace(id) {

			var post_url="<?php echo base_url('admin/b1/line_single/api_tree_startplace')?>";

			var new_zNodes=get_zNodes(post_url);
			/* if(new_zNodes[0].id!=0) //若没有顶级，则增加顶级
			new_zNodes.unshift({id:0,pId:0,level:0,name:'顶级营业部',open:true}); */
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);

			tree_input_id=id;
			var cityObj = $("#"+id);
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999");

			$("#treeDemo").css("width",inputWidth); //等于input的长

			$("body").bind("mousedown", onBodyDown);
		}
		/*  情况二 （场景：营业部管理） */
		function showMenu2(id) {
			var post_url="<?php echo base_url('admin/b2/comboBox/api_level_one')?>";

			var new_zNodes=get_zNodes(post_url);
			/* if(new_zNodes[0].id!=0) //若没有顶级，则增加顶级
			new_zNodes.unshift({id:0,pId:0,level:0,name:'顶级营业部',open:true}); */
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);

			tree_input_id=id;
			var cityObj = $("#"+id);
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999");

			$("#treeDemo").css("width",inputWidth); //等于input的长

			$("body").bind("mousedown", onBodyDown);
		}
		/*  （场景：旅行社管理下的销售人员） */
		function showUnionExpert(id) {

			var post_url="<?php echo base_url('admin/b1/group_line/api_union_expert')?>";

			var new_zNodes=get_zNodes(post_url);
			//alert(post_url);
			/* if(new_zNodes[0].id!=0) //若没有顶级，则增加顶级
			new_zNodes.unshift({id:0,pId:0,level:0,name:'顶级营业部',open:true}); */
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);

			tree_input_id=id;
			var cityObj = $("#"+id);
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","99999999");

			$("#treeDemo").css("width",inputWidth); //等于input的长

			$("body").bind("mousedown", onBodyDown);

		}
		function hideMenu() {
			$("#menuContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
				hideMenu();
			}
		}


		//加载树形结构（营业部）
		$(document).ready(function(){
			         $.fn.zTree.init($("#treeDemo"), setting, zNodes);

		});

	</SCRIPT>



 <!-- 树形（营业部）-->
 <div id="menuContent" class="menuContent" style="display:none; position: absolute;">
	<ul id="treeDemo" class="ztree" style="margin-top:0;"></ul>
</div>


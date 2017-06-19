
<link href="<?php echo base_url("assets/ht/js/ztree/zTreeStyle.css"); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/ztree/jquery.ztree.core.js"); ?>"></script>
<!--
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/ztree/jquery.ztree.excheck.js"); ?>"></script>
-->

<style type="text/css">


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
	  var zNodes = null;
	  //var post_url="<?php echo base_url('admin/t33/expert/api_depart_list')?>";
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
    
	//zNodes[i].isParent=false;
  	
       } 
      return zNodes;
}
//end

		var tree_input_id="";
		var setting = {
			view: {
				dblClickExpand: false
			},
		/*	check: {
				enable: true,
				chkDisabledInherit: true
			},*/
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
		var zNodes1=[
			{ id:1, pId:0, name:"随意勾选 1", open:true},
			{ id:11, pId:1, name:"随意勾选 1-1", open:true},
			{ id:111, pId:11, name:"disabled 1-1-1", chkDisabled:true},
			{ id:112, pId:11, name:"随意勾选 1-1-2"},
			{ id:12, pId:1, name:"disabled 1-2", chkDisabled:true, checked:true, open:true},
			{ id:121, pId:12, name:"disabled 1-2-1", checked:true},
			{ id:122, pId:12, name:"disabled 1-2-2"},
			{ id:2, pId:0, name:"随意勾选 2", checked:true, open:true},
			{ id:21, pId:2, name:"随意勾选 2-1"},
			{ id:22, pId:2, name:"随意勾选 2-2", open:true},
			{ id:221, pId:22, name:"随意勾选 2-2-1", checked:true},
			{ id:222, pId:22, name:"随意勾选 2-2-2"},
			{ id:23, pId:2, name:"随意勾选 2-3"}
		];

		function disabledNode(e) {

			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			disabled = e.data.disabled,
			nodes = zTree.getSelectedNodes(),
			inheritParent = false, inheritChildren = false;
			if (nodes.length == 0) {
				alert("请先选择一个节点");
			}
			if (disabled) {
				inheritParent = $("#py").attr("checked");
				inheritChildren = $("#sy").attr("checked");
			} else {
				inheritParent = $("#pn").attr("checked");
				inheritChildren = $("#sn").attr("checked");
			}

			for (var i=0, l=nodes.length; i<l; i++) {
				zTree.setChkDisabled(nodes[i], disabled, inheritParent, inheritChildren);
			}
		}



         //数据
            var post_url="";
           var zNodes = "";
	 		
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
			var departId="";
			var cityObj = $("#"+tree_input_id);
			
			nodes.sort(function compare(a,b){return a.id-b.id;});
			for (var i=0, l=nodes.length; i<l; i++) {
				v += nodes[i].name + ",";
				if(nodes[i].type=='expert_id'){
					data_id += nodes[i].expertid + ",";	
				}else{
					data_id += nodes[i].id + ",";	
				}
				
				departId+= nodes[i].departId + ",";
			}
			if (v.length > 0 ) v = v.substring(0, v.length-1);
			if (data_id.length > 0 ) data_id = data_id.substring(0, data_id.length-1);
			if (departId.length > 0 ) departId = departId.substring(0, departId.length-1);
		
			type=nodes[0].type;
			
			if(type=='dest'){  //-------------------------选择目的地-------------------------
				//选目的地
				var valObj=$("#overcitystr");
				var ids = valObj.val();
				var idArr = ids.split(",");
				var s = true;
				$.each(idArr ,function(key ,val) {
					if (data_id == val) {
						alert("此选项你已选择");
						s = false;
					}
				})
				if (s == false) {
					return false;
				}
				ids += data_id+',';
				valObj.val(ids); 
				
			
				var valId="overcitystr";
				var buttonId="ds-list";
				var html = '<span class="selectedContent" value="'+data_id+'">'+v+'<span onclick="delPlugin(this ,\''+valId+'\' ,\''+buttonId+'\');" class="delPlugin">×</span></span>';
				$('#ds-list').append(html);
				$('#ds-list').css('display','block');


			}else{  
		      //--------------------------定制管家------------------------------
				if(type=='b_expert_id'){  //帮游
					var typename=$('#b_expert_id').val();
					if(typename==''||typename==undefined){

						data_id = nodes[0].e_id; 
						var str='<span class="selectedContent"><input  type="hidden" value="'+data_id+'" id="'+type+'" name="'+type+'">'+v;
						str+='<span class="delPlugin" onclick="delExperID(this ,'+data_id+');">×</span>';
						str+='</span>';
						//alert(str);
						cityObj.next().append(str);

					}else{
						alert('你已经选择'+v+'管家,帮游的管家只能选一个');
						return false;	
					}
				
				}else if(type=='bangu'){

					alert('请选择帮游具体的管家');
					return false;
				}else{  //联盟单位
					var flag=true;
					$('input[name="departId[]"]').each(function(index,item){
						if($(this).val()==data_id){
							
							var sel=$('input[name="expert_id[]"]').eq(index).val();
							if(sel==0){
								alert('已选择了');
								flag=false;	
							}
							
						}
					 } );
						
					if(!flag){
						return  false;	
					}

					if(type=='depart_id'){  //是选择营业部 还是销售人员
						//data={'depart_id':data_id};

						var str='<span class="selectedContent" value=""><input type="hidden"  id="expert_id" value="0" name="expert_id[]"><input type="hidden"  id="departId" value="'+data_id+'" name="departId[]">'+v;
						str+='<span class="delPlugin" onclick="delExperID(this ,'+data_id+');">×</span>';
						str+='</span>';
						
						cityObj.next().append(str);

					}else{

						$('input[name="expert_id[]"]').each(function(index,item){
							if($(this).val()==data_id){
								alert('已选择了');
								flag=false;
							}
						 } );
						if(!flag){
							return  false;	
						}

						if(type=='union'){
							//alert('请');
							return false;
						}
						var str='<span class="selectedContent" value=""><input type="hidden"  id="'+type+'" value="'+data_id+'" name="expert_id[]"><input type="hidden"  id="departId" value="'+departId+'" name="departId[]">'+v;
						str+='<span class="delPlugin" onclick="delExperID(this ,'+data_id+');">×</span>';
						str+='</span>';
						//alert(str);
						
						cityObj.next().append(str);

					}
						
				}
				 //--------------------------定制管家end------------------------------
				
			}


			cityObj.attr("value", '');
			cityObj.attr("data-id",data_id);
			//cityObj.attr("name",type);
			//hideMenu();


		}

		function treenode_check(){
			//alert(123);
		}
		/*所在的营业部和管家*/
		function showAllExpert(id,content){
			var post_url="<?php echo base_url('admin/b1/group_line/get_depart_expert')?>";
			data={'content':content};
			var new_zNodes=get_zNodes(post_url,data);
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

		/*出境游*/
		function show_JL_Menu(id,value) {
			var post_url="<?php echo base_url('common/get_data/getJLDestBaseData')?>";
			
		    var return_data=send_ajax_noload(post_url,{name:value});
		    zNodes=return_data;
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
		     }
		 
			var new_zNodes=zNodes;
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			
			tree_input_id=id;
			var cityObj = $("#"+id);
			var value=$("#"+id).val();
			if(value=="")
			{
				$("#"+id).attr("data-id","");
			}
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","999999"); 

			//console.log(onBodyDown);
			$("#treeDemo").css("width",inputWidth); //等于input的长
			$("body").bind("mousedown", onBodyDown);
		}
		/*国内游*/
		function show_GL_Menu(id,value) {
			var post_url="<?php echo base_url('common/get_data/getGLDestBaseData')?>";

		    var return_data=send_ajax_noload(post_url,{name:value});
		    zNodes=return_data;
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
		     }
			var new_zNodes=zNodes;
		     
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			
			tree_input_id=id;
			var cityObj = $("#"+id);
			var value=$("#"+id).val();
			if(value=="")
			{
				$("#"+id).attr("data-id","");
			}
			
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","999999"); 

			//console.log(onBodyDown);
			$("#treeDemo").css("width",inputWidth); //等于input的长
			$("body").bind("mousedown", onBodyDown);
		}
		/*周边游*/
		function show_ZL_Menu(id,value) {
			var startcity=$('#lineCityId').val();
			var post_url="<?php echo base_url('common/get_data/getZLDestBaseData')?>";
			
		    var return_data=send_ajax_noload(post_url,{name:value,startcity:startcity});
		    zNodes=return_data;
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
		     }
			var new_zNodes=zNodes;
			
			$.fn.zTree.init($("#treeDemo"), setting, new_zNodes);
			
			tree_input_id=id;
			var cityObj = $("#"+id);
			var value=$("#"+id).val();
			if(value=="")
			{
				$("#"+id).attr("data-id","");
			}
			var cityOffset = $("#"+id).offset();
			var inputWidth=$("#"+id).width()+5;
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");
			$("#menuContent").css("z-index","999999"); 

			//console.log(onBodyDown);
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
	/*	$(document).ready(function(){
			         $.fn.zTree.init($("#treeDemo"), setting, zNodes);
			        
		});
		*/
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			$("#disabledTrue").bind("click", {disabled: true}, disabledNode);
			$("#disabledFalse").bind("click", {disabled: false}, disabledNode);
			
		});
	</SCRIPT>
	
	
	 
 <!-- 树形（营业部）-->
 <div id="menuContent" class="menuContent" style="display:none; position: absolute;">
	<ul id="treeDemo" class="ztree" style="margin-top:0;"></ul>
</div>

	
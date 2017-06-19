function drawStar(box,num){
		$(box).find("li").each(function(index){
		//console.log(" drawStar   :"+num +","+index);
			if(num>=index){ 
				$(this).addClass("hove");
			} else{
				$(this).removeClass("hove");
			}
		});
	}
	$(".eject_xx_box").each(function(index, element) {  
		$(this).find("li").each(function(index){
			$(this).click(function(){
				//console.log(" li click :"+index+","+$(this.parentNode.parentNode));
				$(this.parentNode.parentNode).attr("value",index) ;//根据第几个，设置上级的上级的value 
				//TODO 设置隐藏域的值
			});
		}); //点击
        $(this).find("li").each(function(index){ 
			$(this).mouseover(function(){
				//console.log(" li mouseover :"+index);
				//鼠标移进 /*根据第几个，把之前的全部亮了*/
				drawStar($(this.parentNode.parentNode),  index );
			});
		} );
		 
		$(this).each(function(index){			
			$(this).mouseout(function(){ 
				//console.log(" box mouseout " +index);
				//大的移出去，根据value 来画星星
				drawStar( $(this),  $(this).attr("value")  ); 
			});
		});  
	}) ;

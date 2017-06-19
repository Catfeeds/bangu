T2TCNCalendar.prototype.initialize=function()
{
    var IE6=false /*@cc_on || @_jscript_version < 5.7 @*/;
    this.iframe=null;
    if (/*@cc_on!@*/0)
    {
        this.iframe=document.createElement("IFRAME");
        this.iframe.className="calendar";
        this.iframe.border="0";
        document.body.appendChild(this.iframe)
    }
    this.calendarDiv=document.createElement("DIV");
    this.calendarDiv.id="calendarDiv";
    this.calendarDiv.onselectstart=function()
    {
        return false
    };
    this.calendarDiv.onmousedown=function()
    {
        return false
    };
    var oThis=this;
    this.oldKeyDown=document.onkeydown;
    document.onkeydown=function(oEvent)
    {
        oEvent=oEvent||window.event;
        return oThis.handleKeyDown(oEvent)
    };
    this.oldMouseDown=document.onmousedown;
    document.onmousedown=function(oEvent)
    {
        oEvent=oEvent||window.event;
        return oThis.handleMouseDown(oEvent)
    };
    this.calendarDiv.style.zIndex=-1000;
    document.body.appendChild(this.calendarDiv);
    this.calendarDiv.innerHTML=this.Config.templateHTML;
    
    if(this.iframe)
    {
        this.fade=new EKFadeAnim(this.calendarDiv,this.iframe)
    }
    else
    {
        this.fade=new EKFadeAnim(this.calendarDiv,null)
    }
    this.parseTemplate();
    this.refreshData()
};
function EKFadeAnim($,_)
{
    this.opacity=0;
    this.interval=10;
    this.increment=25;
    this.elementStyle=$.style;
    if(_)this.relatedStyle=_.style;
    this.timer=null
}
EKFadeAnim.prototype.setOpacity=function($,_)
{
    if(_==0)$.visibility="hidden";
    else $.visibility="visible";
    $.opacity=(_/100);
    $.MozOpacity=(_/100);
    $.KhtmlOpacity=(_/100);
    $.filter="alpha(opacity="+_+")"
};
EKFadeAnim.prototype.stop=function()
{
    if(this.opacity>0)
    {
        this.setOpacity(this.elementStyle,100);
        if(this.relatedStyle)this.setOpacity(this.relatedStyle,100)
    }
};
EKFadeAnim.prototype.fadeIn=function()
{
    if(this.timer==null)
    {
        this.opacity=0;
        var $=this;
this.timer=window.setInterval(function()
{
    $.fadeInTimer()
}
,this.interval)
}
};
EKFadeAnim.prototype.fadeInTimer=function()
{
if(this.opacity<100)
{
this.opacity=this.opacity+this.increment;
this.setOpacity(this.elementStyle,this.opacity);
if(this.relatedStyle)this.setOpacity(this.relatedStyle,this.opacity)
}
else
{
window.clearInterval(this.timer);
this.timer=null
}
};
EKFadeAnim.prototype.fadeOut=function()
{
if(this.timer==null)
{
this.opacity=100;
var $=this;
this.timer=window.setInterval(function()
{
    $.fadeOutTimer()
}
,this.interval)
}
};
EKFadeAnim.prototype.fadeOutTimer=function()
{
if(this.opacity>0)
{
this.opacity=this.opacity-this.increment;
this.setOpacity(this.elementStyle,this.opacity);
if(this.relatedStyle)this.setOpacity(this.relatedStyle,this.opacity)
}
else
{
window.clearInterval(this.timer);
this.timer=null
}
};
function T2TCNCalendar()
{
    this.Config=function()
    {
    };
    this.Config.imagePath="/images/calendar/";
    this.Config.calendarImages=["iconleft.jpg","iconright.jpg"];
    this.Config.maxScreen=960;
    this.Config.txtClose="Close";
    this.Config.txtPrevMonth="Previous month";
    this.Config.txtNextMonth="Next month";
    this.Config.monthLong=["January","February","March","April","May","June","July","August","September","October","November","December"];
    this.Config.monthShort=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    this.Config.dayShort=["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
    this.Config.firstDay=0;
    this.Config.monthDays=[31,28,31,30,31,30,31,31,30,31,30,31];
    this.Config.dateFormat="dd-MMM-yy";
    this.Config.dateFormatTitle="MMMM, yyyy";
    this.Config.templateHTML=""
}
T2TCNCalendar.prototype.stringFill=function(_,A)
{
    var $="";
    for(;;)
    {
        if(A&1)$+=_;
        A>>=1;
        if(A)_+=_;
        else break
    }
    return $
};
T2TCNCalendar.prototype.padLeft=function($,B,_)
{
    var A=$+"";
    while(A.length<_)A=B+A;
    return A
};
T2TCNCalendar.prototype.isNumeric=function(B)
{
    var _,C,D,$,A;
    _="0123456789";
    C=true;
    for($=0,A=B.length;$<A&&C==true;$++)
    {
        D=B.charAt($);
        if(_.indexOf(D)==-1)C=false
    }
    return C
};
T2TCNCalendar.prototype.findPos=function($)
{
    var _=function()
    {
    };
    _.x=0;
    _.y=0;
    while($.offsetParent)
    {
        _.x+=$.offsetLeft;
        _.y+=$.offsetTop;
        $=$.offsetParent
    }
    return _
};
T2TCNCalendar.prototype.getWindowSize=function()
{
    var $=function()
    {
    };
    $.width=0;
    $.height=0;
    if(typeof(window.innerWidth)=="number")
    {
        $.width=window.innerWidth;
        $.height=window.innerHeight
    }
    else if(document.documentElement&&(document.documentElement.clientWidth||document.documentElement.clientHeight))
    {
        $.width=document.documentElement.clientWidth;
        $.height=document.documentElement.clientHeight
    }
    else if(document.body&&(document.body.clientWidth||document.body.clientHeight))
    {
        $.width=document.body.clientWidth;
        $.height=document.body.clientHeight
    }
    return $
};
T2TCNCalendar.prototype.getScrollPosition=function()
{
    var $=function()
    {
    };
    $.x=0;
    $.y=0;
    if(typeof(window.pageYOffset)=="number")
    {
        $.x=window.pageXOffset;
        $.y=window.pageYOffset
    }
    else if(document.body&&(document.body.scrollLeft||document.body.scrollTop))
    {
        $.x=document.body.scrollLeft;
        $.y=document.body.scrollTop
    }
    else if(document.documentElement&&(document.documentElement.scrollLeft||document.documentElement.scrollTop))
    {
        $.x=document.documentElement.scrollLeft;
        $.y=document.documentElement.scrollTop
    }
    return $
};
T2TCNCalendar.prototype.leapYear=function($)
{
    return(($%400)===0||(($%4)===0&&($%100)!==0))
};
T2TCNCalendar.prototype.resolveMonth=function(_,A)
{
    for(var $=0;$<_.length;$++)if(A.indexOf(_[$])!=-1)return $;
    return-1
};
T2TCNCalendar.prototype.cleanMonth=function(_,A)
{
    for(var $=0;$<_.length;$++)if(A.indexOf(_[$])!=-1)return A.replace(_[$],this.stringFill("M",_[$].length));
    return A
};
T2TCNCalendar.prototype.addMonth=function(A,_)
{
    var $=new Date(A.getTime());
    $.setDate(1);
    if(!_)
    {
        if($.getMonth()===0)
        {
            $.setYear($.getFullYear()-1);
            $.setMonth(11)
        }
        else $.setMonth($.getMonth()-1)
    }
    else if($.getMonth()==11)
    {
        $.setYear($.getFullYear()+1);
        $.setMonth(0)
    }
    else $.setMonth($.getMonth()+1);
    return $
};
T2TCNCalendar.prototype.formatDate=function(_,D)
{
    var E=false,C=-1,F="",G=D+" ",$=G.split("");
    for(var B=0;B<$.length;B++)if(B>0&&($[B-1]!=$[B])&&!E)
    {
        C++;
        switch($[B-1])
        {
            case"d":switch(C)
            {
                case 1:F=F+_.getDate();
                break;
                case 2:F=F+this.padLeft(_.getDate(),"0",2);
                break
            }
            break;
            case"M":switch(C)
            {
                case 1:F=F+(_.getMonth()+1);
                break;
                case 2:F=F+this.padLeft(_.getMonth()+1,"0",2);
                break;
                case 3:F=F+this.Config.monthShort[_.getMonth()];
                break;
                case 4:F=F+this.Config.monthLong[_.getMonth()];
                break
            }
            break;
            case"y":var A=_.getFullYear()+"";
            switch(C)
            {
                case 1:if(A.substr(3,1)!="0")F=F+A.substr(3,1);
                else F=F+A.substr(2,2);
                break;
                case 2:F=F+A.substr(2,2);
                break;
                default:F=F+A;
                break
            }
            break;
            case"\\":F=F+$[B];
			E=true;
			break;			
			default:for(j=0;
			j<C;
			j++)F=F+$[B-1];
			break
			}
			C=0
			}
			else
			{
			C++;
			E=false
			}
			return F
			};
			T2TCNCalendar.prototype.parseDate=function($,E)
			{
			var J=false,A=-1,H=0,L="",K=E+" ",M=K.split(""),G=this.startDate.getDate(),I=this.startDate.getMonth(),_=this.startDate.getFullYear(),N=$;
			if(E.indexOf("MMMM")!=-1)N=this.cleanMonth(this.Config.monthLong,$);
			if(E.indexOf("MMM")!=-1)N=this.cleanMonth(this.Config.monthShort,$);
			for(var B=0,C=M.length;B<C;B++)if(B>0&&(M[B-1]!=M[B])&&!J)
			{
			A++;
			switch(M[B-1])
			{
			case"d":switch(A)
			{
				case 1:if(this.isNumeric(N.substr(B+H-1,2)))
				{
					G=parseFloat(N.substr(B+H-1,2));
					H++
				}
				else G=parseFloat(N.substr(B+H-1,1));
				break;
				default:G=parseFloat(N.substr(B+H-A,A))
			}
			break;
			case"M":switch(A)
			{
				case 1:if(this.isNumeric(N.substr(B+H-1,2)))
				{
					I=parseFloat(N.substr(B+H-1,2));
					H++
				}
				else I=parseFloat(N.substr(B+H-1,1));
				I--;
				break;
				case 2:I=parseFloat(N.substr(B-2,2));
				I--;
				break;
				case 3:I=this.resolveMonth(this.Config.monthShort,$);
				if(I!=-1)H=H+this.Config.monthShort[I].length-3;
				break;
				case 4:I=this.resolveMonth(this.Config.monthLong,$);
				if(I!=-1)H=H+this.Config.monthShort[I].length-3;
				break
			}
			break;
			case"y":_=parseFloat(N.substr(B+H-A,A));
			if(_<100)_=_+2000;
			break;
			case"\\":J=true;
			break
			}
			A=0
			}
			else
			{
			A++;
			J=false
			}
			try
			{
			var D=new Date(_,I,G);
			if(D.getFullYear()==_&&D.getMonth()==I&&D.getDate()==G)
			{
			if(D<this.startDate)D.setTime(this.startDate.getTime());
			if(D>this.endDate)
			{
				D.setTime(this.endDate.getTime());
				D.setDate(1)
			}
			return D
			}
			}
			catch(F)
			{
			return this.startDate
			}
			return this.startDate
			};
			T2TCNCalendar.prototype.preloadImages=function()
			{
			if(document.images)for(var _=0;
			_<this.Config.calendarImages.length;
			_++)
			{
			var $=new Image(1,1);
			$.src=this.Config.imagePath+this.Config.calendarImages[_]
			}
			};
			T2TCNCalendar.prototype.handleKeyDown=function($)
			{
			if($.keyCode==27)this.closeCalendar();
			if(this.oldKeyDown)return this.oldKeyDown($)
			};
			T2TCNCalendar.prototype.handleMouseDown=function(_)
			{
			var $=_.target||_.srcElement;
			bInCalendar=false;
			while($)
			{
			if($==this.calendarDiv||$==this.returnDateTo)bInCalendar=true;
			$=$.parentNode
			}
			if(!bInCalendar)this.closeCalendar();
			if(this.oldMouseDown)return this.oldMouseDown(_);
			return true
			};
			
			
			T2TCNCalendar.prototype.parseTemplate=function()
			{
			this.calendarLeft=document.getElementById("calendarLeft");
			this.calendarRight=document.getElementById("calendarRight");
			this.monthLeft=document.getElementById("monthLeft");
			this.monthRight=document.getElementById("monthRight");
			this.prevMonth=document.getElementById("prevMonth");
			this.nextMonth=document.getElementById("nextMonth");
			this.dataLeft=document.getElementById("dataLeft");
			this.dataRight=document.getElementById("dataRight");
			this.weekLeft =document.getElementById("daysLeft");
			this.weekRight =document.getElementById("daysRight");
			var _=document.getElementById("daysLeft");
			var checkLHTML ="<input type=checkbox onclick=\"T2TCNCalendar.checkWeed(this,'L')\" />";
			for(var A=0;A<this.Config.dayShort.length;A++)_.cells[A].innerHTML=checkLHTML + this.Config.dayShort[A];
			var $=document.getElementById("daysRight");
			var checkRHTML ="<input type=checkbox onclick=\"T2TCNCalendar.checkWeed(this,'R')\" />";
			for(A=0;A<this.Config.dayShort.length;A++)$.cells[A].innerHTML=checkRHTML + this.Config.dayShort[A];
			this.prevMonth.title=this.Config.txtPrevMonth;
			this.nextMonth.title=this.Config.txtNextMonth
			};
			
			
			T2TCNCalendar.prototype.switchMonth=function(A)
			{
			var $=A.target||A.srcElement,_=this.outputDate.getFullYear();
			this.outputDate=this.addMonth(this.outputDate,$.id.indexOf("next")>=0);
			this.refreshData();
			return false
			};
			
			T2TCNCalendar.prototype.updateButtons=function()
			{
			var A=this,_=this.prevMonth,$=this.nextMonth;
			//edit leon 可以回头
			//if((this.outputDate.getFullYear()<=this.startDate.getFullYear())&&this.outputDate.getMonth()<=this.startDate.getMonth())
			//{
			//_.className="arrowLeftDisabled";
			//_.onclick=null;
			//_.title=""
			//}
			//else
			{
			_.className="arrowLeft";
			_.onclick=function($)
			{
			$=$||window.event;
			return A.switchMonth($)
			};
			_.title=this.Config.txtPrevMonth
			}
			//remove leon
			//if(this.outputDate.getFullYear()>=this.endDate.getFullYear()&&this.outputDate.getMonth()>=(this.endDate.getMonth()-1))
			//{
			//$.className="arrowRightDisabled";
			//$.onclick=null;
			//$.title=""
			//}
			//else
			{
			$.className="arrowRight";
			$.onclick=function($)
			{
			$=$||window.event;
			return A.switchMonth($)
			};
			$.title=this.Config.txtNextMonth
			}
			};
			
			T2TCNCalendar.prototype.highlightDay=function()
			{
			switch(this.className)
			{
			case"activeDay":this.className="activeDayOver";
			break;
			case"activeDayOver":this.className="activeDay";
			break;
			case"Day":this.className="DayOver";
			break;
			case"DayOver":this.className="Day";
			break
			}
			};
			
			
			
			
			T2TCNCalendar.prototype.refreshData=function()
			{
				var checkLHTML ="<input type=checkbox onclick=\"T2TCNCalendar.checkWeed(this,'L')\" />";
				for(var A=0;A<this.Config.dayShort.length;A++) this.weekLeft.cells[A].innerHTML=checkLHTML + this.Config.dayShort[A];
				//var $=document.getElementById("daysRight");
				var checkRHTML ="<input type=checkbox onclick=\"T2TCNCalendar.checkWeed(this,'R')\" />";
				for(A=0;A<this.Config.dayShort.length;A++) this.weekRight.cells[A].innerHTML=checkRHTML + this.Config.dayShort[A];
				
				if(this.outputDate.getFullYear()==this.endDate.getFullYear()&&this.outputDate.getMonth()==this.endDate.getMonth())
				{
					this.writeCalendarContent(this.addMonth(this.outputDate,false),this.monthLeft,this.dataLeft,this.returnTempDateTo,this.checkboxName);
					this.writeCalendarContent(this.outputDate,this.monthRight,this.dataRight);
				}
				else
				{
					this.writeCalendarContent(this.outputDate,this.monthLeft,this.dataLeft);
					this.writeCalendarContent(this.addMonth(this.outputDate,true),this.monthRight,this.dataRight,this.returnTempDateTo,this.checkboxName);
					
				}
			this.resizeContent();
			this.updateButtons()
			};
			
			
			
			T2TCNCalendar.prototype.writeCalendarContent=function(C,D,$,T,BN)
			{		
			var E=this;
			var boxClickTo;
			BN = this.checkboxName;
			if(typeof T!="undefined"){
					boxClickTo = T;
				}
				else
				{
					boxClickTo = null;
				}
			
			if(this.calendarLeft.style.removeProperty)
			{
				this.calendarLeft.style.removeProperty("height");
				this.calendarRight.style.removeProperty("height")
			}
			else
			{
				this.calendarLeft.style.removeAttribute("height");
				this.calendarRight.style.removeAttribute("height")
			}
			if($ == this.dataRight)
			{
				D.innerHTML="<input type=checkbox onclick=\"T2TCNCalendar.checkYear(this,'R')\" />" +this.formatDate(C,this.Config.dateFormatTitle);
			}
			else
			{
				D.innerHTML="<input type=checkbox onclick=\"T2TCNCalendar.checkYear(this,'L')\" />" +this.formatDate(C,this.Config.dateFormatTitle);
			}
			
			var G=new Array(),_=new Date();
			_.setTime(C.getTime());
			_.setDate(1);
			var K=_.getDay();
			K=(7-(this.Config.firstDay-K))%7;
			var H=this.Config.monthDays[C.getMonth()];
			if(H==28)if(this.leapYear(C.getFullYear()))H=29;
			var J=0,F=1,B=H;
			//remove leon
			//if(C.getFullYear()<=this.startDate.getFullYear()&&C.getMonth()<=this.startDate.getMonth())F=this.startDate.getDate();
			//if(C.getFullYear()>=this.endDate.getFullYear()&&C.getMonth()>=this.endDate.getMonth())B=this.endDate.getDate();
			if(C.getFullYear()==this.inputDate.getFullYear()&&C.getMonth()==this.inputDate.getMonth())J=this.inputDate.getDate();
			for(i=0;i<$.rows.length*7;i++)
			{
			var A=$.rows[parseInt(i/7)].cells[i%7],I=i-K+1;
			
			if(i<K||I>H)
			{
				A.id="";
				A.className="inActiveDay";
				A.innerHTML="";
				A.onmouseover=null;
				A.onmouseout=null;
				A.onclick=null
			}
			else
			{
			A.id="day-"+I+"-"+C.getMonth()+"-"+C.getFullYear();

			boxValue = C.getFullYear()+"-"+appendZero(C.getMonth()+1)+"-"+appendZero(I);				
			//如果已有值，对比使日历渲染时相应的checkbox勾选上
			var hadValues = this.oldInputValue;

			if(hadValues){

					if(hadValues.match(boxValue)){
						A.innerHTML="<input type=checkbox name="+BN+" value="+boxValue+" onclick=\"T2TCNCalendar.check(this)\" checked=checked />" + I;
					}
					else
					{
						A.innerHTML="<input type=checkbox name="+BN+" value="+boxValue+" onclick=\"T2TCNCalendar.check(this)\" />" + I;
					}			
			}
			else
			{
				A.innerHTML="<input type=checkbox name="+BN+" value="+boxValue+" onclick=\"T2TCNCalendar.check(this)\" />" + I;
			}
			
			
			A.className="inActiveDay";
			//remove leon
			//if(C.getFullYear()<this.startDate.getFullYear())
			//{				
			//	A.className="inActiveDay";
			//	A.onmouseover=null;
			//	A.onmouseout=null;
			//	A.onclick=null
			//}
			//else 
			if(I>=F&&I<=B)
			{
				A.onmouseover=this.highlightDay;
				A.onmouseout=this.highlightDay;
				A.onclick=null;
				if(I==J)A.className="activeDay";
				else A.className="Day"			
			}
			else
			{
				//A.innerHTML="<input type=checkbox name="+BN+" value="+boxValue+" disabled=disabled />" + I;
				A.innerHTML="<input type=checkbox name="+BN+" value="+boxValue+"  />" + I;
				//A.className="inActiveDay";
				A.onmouseover=null;
				A.onmouseout=null;
				A.onclick=null
			}
			}
			}
			if(H+K>5*7)$.rows[$.rows.length-1].style.display="";
			else $.rows[$.rows.length-1].style.display="none"
			};
			
			
			
			T2TCNCalendar.prototype.resizeContent=function()
			{
			if(this.calendarRight.offsetHeight>this.calendarLeft.offsetHeight)this.calendarLeft.style.height=(this.calendarRight.offsetHeight+4)+"px";
			else this.calendarLeft.style.height=(this.calendarLeft.offsetHeight+4)+"px";
			if(this.iframe)
			{
			var C=parseFloat(this.calendarDiv.currentStyle.borderWidth);
			if(!isNaN(C))
			{
				this.iframe.style.width=(this.calendarDiv.clientWidth-(2*C))+"px";
				this.iframe.style.height=(this.calendarDiv.clientHeight+(2*C))+"px"
			}
			else
			{
				this.iframe.style.width=this.calendarDiv.clientWidth+"px";
				this.iframe.style.height=this.calendarDiv.clientHeight+"px"
			}
			}
			if(this.returnDateTo)
			{
				var D=this.findPos(this.returnDateTo),_=this.getScrollPosition(),$=this.getWindowSize(),A=D.x,B=D.y+this.returnDateTo.offsetHeight+2,E=this.calendarDiv;
				if((E.offsetHeight+B)>(_.y+$.height))window.scrollTo(_.x,_.y+(E.offsetHeight+B)-(_.y+$.height)+25)
			}
			};
			
			
			T2TCNCalendar.prototype.positionCalendar=function($)
			{
				var D=this.findPos(this.returnDateTo),_=this.getScrollPosition(),B=this.getWindowSize(),A=D.x,C=D.y+this.returnDateTo.offsetHeight+2,E=this.calendarDiv;
				if((E.offsetHeight+C)>(_.y+B.height+4))window.scrollTo(_.x,_.y+(E.offsetHeight+C)-(_.y+B.height)+25);
				if(this.Config.maxScreen!==0&&B.width>this.Config.maxScreen)B.width=this.Config.maxScreen+(document.body.clientWidth-this.Config.maxScreen)/2;
				if((E.offsetWidth+A+20)>(_.x+B.width))A=D.x+this.returnDateTo.offsetWidth-E.offsetWidth;
				this.calendarDiv.style.left="42%";
				this.calendarDiv.style.top="23%";
				if(this.iframe)
				{
					this.iframe.style.left=this.calendarDiv.style.left;
					this.iframe.style.top=this.calendarDiv.style.top
				}
			};			

			//新增变量T，用来存储checkbox的勾选情况，保证上下翻月时已勾选过的checkbox仍选
			//BN为checkbox的name
			T2TCNCalendar.prototype.display=function(C,_,E,T,A,BN)
			{
				if(!this.Config)return;
				if(!BN)return;//BN为checkbox的name
				if(typeof T=="undefined")T=null;
				if(typeof A=="undefined")A=0;				
				this.startDate=new Date(_.getTime());
				this.endDate=new Date(E.getTime());
				if(C&&C.tagName=="INPUT" || C&&C.tagName=="TEXTAREA")
				{
					//CK Edit
					this.oldInputValue = C.value;
					this.inputDate=this.parseDate(C.value,this.Config.dateFormat);
					this.outputDate=new Date(this.inputDate.getTime())
				}
				else return;
				if(C.style.display=="none"||C.disabled=="true")return;
				this.checkboxName = BN;
				/**
				*	returnTempDateTo是checkbox勾选时即写进一个临时变量里，保证上下翻月时已勾选过的checkbox的状态从临时变量里取
				*	这个变量的赋值一定要放在日历初始化[initialize()]的前面
				*/
				this.returnTempDateTo = T;
				if(!this.calendarDiv)this.initialize();
				this.returnDateTo=C;
				//初始化临时存储框里的值
				this.returnTempDateTo.value = this.returnDateTo.value;
				
				var B=this.calendarDiv.style.visibility=="visible";
				this.calendarDiv.style.zIndex=-1000;
				this.calendarDiv.style.visibility="visible";
				this.refreshData();
				this.positionCalendar(A);
				if(!B)this.calendarDiv.style.visibility="hidden";
				this.calendarDiv.style.zIndex=1000;
				if(!B)this.fade.fadeIn();

			};
			
			
			//CK Edit 新的方法
			//返回勾选的checkbox值
			T2TCNCalendar.prototype.returnValues=function()
			{
				this.returnDateTo.value = this.returnTempDateTo.value;
				
				
				
				if(this.returnDateTo.value=='')
					this.closeCalendar();
				if(document.getElementById('roomTypeTBL'))
				{
					var tbl=document.getElementById('roomTypeTBL');
					var roomType=this.returnDateTo.parentElement.previousSibling.childNodes[0];
					var roomType_v=roomType.options[roomType.selectedIndex].value;
					var validateDayStr=this.returnDateTo.value.split(',');
					
					var selfRowIndex=this.returnDateTo.parentElement.parentElement.rowIndex;
					
					var len=tbl.rows.length;
					
					for(var i=1;i<len;i++)
					{
						if(selfRowIndex==i)
							continue;
						var currenDayStr=","+tbl.rows[i].cells[1].childNodes[0].value;
						var currentRoomType_v=tbl.rows[i].cells[0].childNodes[0].options[tbl.rows[i].cells[0].childNodes[0].selectedIndex].value;
						var currentRoomType_text=tbl.rows[i].cells[0].childNodes[0].options[tbl.rows[i].cells[0].childNodes[0].selectedIndex].text;
						if(roomType_v==currentRoomType_v)
						for(var k=0;k<validateDayStr.length;k++)
						{
							
							if(currenDayStr.indexOf(','+validateDayStr[k]+',')>-1)
							{
									alert('您已经在第'+i+'行的"'+currentRoomType_text+'"房型选择了日期"'+'"'+validateDayStr[k]+'"');
									this.returnDateTo.value="";
									this.returnDateTo.focus();
									this.closeCalendar();
									return false;
							}
						}
					}
				}


				this.closeCalendar();
			};	
			
			//checkbox勾选动作时
			T2TCNCalendar.prototype.check=function(obj)
			{
				var tempDateArr = this.returnTempDateTo.value;

					if(obj.checked){//如果勾选
					
					    //先判断是否已有该值
						if(!tempDateArr.match(obj.value)){
							tempDateArr = tempDateArr + obj.value + ",";
						}
					}
					else
					{
						//如果取消了勾选 判断临时存储框里是否已包含了此值，如有则删除它
						if(tempDateArr.match(obj.value)) tempDateArr = tempDateArr.replace(obj.value + ",","");
					}				
				
				this.returnTempDateTo.value = tempDateArr;

			};
			
			//checkbox勾选动作时
			T2TCNCalendar.prototype.checkYear=function(obj,c)
			{
				var w;
				if(c=='L')
				{
					c=document.getElementById("dataLeft");
					w=document.getElementById("daysLeft");
				}
				else if(c == 'R')
				{
					c=document.getElementById("dataRight");
					w=document.getElementById("daysRight");
				}
				
				var tempDateArr = this.returnTempDateTo.value;

				if(obj.checked){//如果勾选
					for(var i=0;i < 7;i++)
					{
						var cell = w.cells[i].firstChild;
	
							if(cell != null && !cell.disabled)
							{
								cell.checked='checked';
							}
					}
					for(var i=0;i < 6;i++)
					{
						for(var j=0;j < 7;j++)
						{
							var cell = c.rows[i].cells[j].firstChild;
	
							if(cell != null && !cell.disabled)
							{
								cell.checked='checked';
								
								//先判断是否已有该值
								if(!tempDateArr.match(cell.value)){
									tempDateArr = tempDateArr + cell.value + ",";
								}
							}
						}
					}
				}
				else
				{
					for(var i=0;i < 7;i++)
					{
						var cell = w.cells[i].firstChild;
							
						if(cell != null && !cell.disabled )
						{
							cell.checked='';
						}
					}
						
					for(var i=0;i < 6;i++)
					{
						for(var j=0;j < 7;j++)
						{
							var cell = c.rows[i].cells[j].firstChild;
							
							if(cell != null && !cell.disabled )
							{
								cell.checked='';
								
								//如果取消了勾选 判断临时存储框里是否已包含了此值，如有则删除它
								if(tempDateArr.match(cell.value)) tempDateArr = tempDateArr.replace(cell.value + ",","");
							}
						}
					}
						
				}				
				
				this.returnTempDateTo.value = tempDateArr;

			};
			
			//checkbox勾选动作时
			T2TCNCalendar.prototype.checkWeed=function(obj,c)
			{
				var m;
				if(c=='L')
				{
					c=document.getElementById("dataLeft");
					m=document.getElementById("monthLeft");
				}
				else if(c == 'R')
				{
					c=document.getElementById("dataRight");
					m=document.getElementById("monthRight");
				}
				
				var j= obj.parentElement.cellIndex;

				var tempDateArr = this.returnTempDateTo.value;

				if(obj.checked){//如果勾选
					for(var i=0;i < 6;i++)
					{
						var cell = c.rows[i].cells[j].firstChild;

						if(cell != null && !cell.disabled)
						{
							cell.checked='checked';
							
							//先判断是否已有该值
							if(!tempDateArr.match(cell.value)){
								tempDateArr = tempDateArr + cell.value + ",";
							}
						}
					}
				}
				else
				{
					for(var i=0;i < 6;i++)
					{
						var cell = c.rows[i].cells[j].firstChild;
						
						if(cell != null && !cell.disabled )
						{
							cell.checked=''; 
							m.firstChild.checked='';
							
							//如果取消了勾选 判断临时存储框里是否已包含了此值，如有则删除它
							if(tempDateArr.match(cell.value)) tempDateArr = tempDateArr.replace(cell.value + ",","");
						}
					}
						
				}				
				
				this.returnTempDateTo.value = tempDateArr;

			};
			
			T2TCNCalendar.prototype.closeCalendar=function()
			{
			if(this.calendarDiv)if(this.calendarDiv.style.visibility=="visible")this.fade.fadeOut();
			if(this.closeCalendarCallBack){
				this.closeCalendarCallBack();
			}
			return false
			};

			
			
			T2TCNCalendar=new T2TCNCalendar()
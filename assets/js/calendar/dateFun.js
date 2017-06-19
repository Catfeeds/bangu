String.prototype.Left=function($)
{
    if(isNaN($)||$==null)$=0;
    else if(parseInt($)<0||parseInt($)>this.length)$=0;
    return this.substr(0,this.length-$)+"**"
};
function appendZero($)
{
    return(("00"+$).substr(("00"+$).length-2))
}
function GetMonthMaxDay($,A)
{
    var _=new Array(31,28,31,30,31,30,31,31,30,31,30,31),B=0,C=this.formatYear($);
    B=_[A];
    if(A==1)if(((C%4==0)&&(C%100!=0))||(C%400==0))B++;
    return(B)
}
function formatYear($)
{
    var _=parseInt($,10);
    if(_<100)
    {
        _+=1900;
        if(_<1940)_+=100
    }
    if(_<this.MinYear)_=this.MinYear;
    if(_>this.MaxYear)_=this.MaxYear;
    return(_)
}
function formatDate(A,E)
{
    var F="",B=formatYear(A.getFullYear()),G=appendZero(A.getMonth()+1),_=appendZero(A.getDate()),$=appendZero(A.getHours()),C=appendZero(A.getMinutes()),D=appendZero(A.getSeconds());
    switch(E)
    {
        case 0:F=B+"."+G+"."+_+".";
        break;
        case 1:F=B+"-"+G+"-"+_;
        break;
        case 2:F=B+"-"+G+"-"+_+" "+appendZero($)+":"+appendZero(C)+":"+appendZero(D);
        break;
        default:F=B+"-"+G+"-"+_
    }
    return F
}
function getWeekFirstDay(A)
{
    var _=new Date(),$=new Date(_-(_.getDay()-1)*86400000);
    return formatDate($,A)
}
function getWeekLastDay(B)
{
    var A=new Date(),$=new Date(A-(A.getDay()-1)*86400000),_=new Date(($/1000+6*86400)*1000);
    return formatDate(_,B)
}
function testDate()
{
    var $=new Date(),_=new Date($.getFullYear(),$.getMonth(),1);
    alert(_.getFullYear());
    alert(appendZero(_.getMonth()+1));
    var A=new Date($.getFullYear(),$.getMonth()-1,1);
    alert(A.getFullYear());
    alert(appendZero(A.getMonth()+1))
}
function getMonthFirstDay(A)
{
    var $=new Date(),_=new Date($.getFullYear(),$.getMonth(),1);
    return formatDate(_,A)
}
function getMonthLastDay(B)
{
    var A=new Date(),$=new Date(A.getFullYear(),A.getMonth()+1,1),_=new Date($-86400000);
    return formatDate(_,B)
}
function getDateFromString(B)
{
    var D=B.split("-");
    for(var $=0;$<D.length;$++)if(D[$].length>1&&D[$].indexOf("0")==0)D[$]=D[$].substring(1);
    var A=parseInt(D[0]),_=parseInt(D[1])-1,C=parseInt(D[2]);
    return new Date(A,_,C)
}
function getDiffDate($,A)
{
    var _=new Date();
    _=_.valueOf();
    _=_+$*24*60*60*1000;
    _=new Date(_);
    return formatDate(_,A)
}
function TimeCom(_)
{
    var $=new Date(_);
    this.year=$.getFullYear();
    this.month=$.getMonth()+1;
    this.day=$.getDate();
    this.hour=$.getHours();
    this.minute=$.getMinutes();
    this.second=$.getSeconds();
    this.msecond=$.getMilliseconds();
    this.week=$.getDay()
}
function DateDiff(D,_,C)
{
    var B=new TimeCom(_),$=new TimeCom(C),A;
    switch(String(D).toLowerCase())
    {
        case"y":case"year":A=B.year-$.year;
        break;
        case"n":case"month":A=(B.year-$.year)*12+(B.month-$.month);
        break;
        case"d":case"day":A=Math.round((Date.UTC(B.year,B.month-1,B.day)-Date.UTC($.year,$.month-1,$.day))/(1000*60*60*24));
        break;
        case"h":case"hour":A=Math.round((Date.UTC(B.year,B.month-1,B.day,B.hour)-Date.UTC($.year,$.month-1,$.day,$.hour))/(1000*60*60));
        break;
        case"m":case"minute":A=Math.round((Date.UTC(B.year,B.month-1,B.day,B.hour,B.minute)-Date.UTC($.year,$.month-1,$.day,$.hour,$.minute))/(1000*60));
        break;
        case"s":case"second":A=Math.round((Date.UTC(B.year,B.month-1,B.day,B.hour,B.minute,B.second)-Date.UTC($.year,$.month-1,$.day,$.hour,$.minute,$.second))/1000);
        break;
        case"ms":case"msecond":A=Date.UTC(B.year,B.month-1,B.day,B.hour,B.minute,B.second,B.msecond)-Date.UTC($.year,$.month-1,$.day,$.hour,$.minute,$.second,B.msecond);
        break;
        case"w":case"week":A=Math.round((Date.UTC(B.year,B.month-1,B.day)-Date.UTC($.year,$.month-1,$.day))/(1000*60*60*24))%7;
        break;
        default:A="invalid"
    }
    return(A)
}
function DateAdd(D,_,C,B)
{
    var A=new TimeCom(C);
    switch(String(D).toLowerCase())
    {
        case"y":case"year":A.year+=_;
        break;
        case"n":case"month":A.month+=_;
        break;
        case"d":case"day":A.day+=_;
        break;
        case"h":case"hour":A.hour+=_;
        break;
        case"m":case"minute":A.minute+=_;
        break;
        case"s":case"second":A.second+=_;
        break;
        case"ms":case"msecond":A.msecond+=_;
        break;
        case"w":case"week":A.day+=_*7;
        break;
        default:return("invalid")
    }
    var $=A.year+"/"+A.month+"/"+A.day+" "+A.hour+":"+A.minute+":"+A.second;
    return formatDate(new Date($),B)
}
function AddDay(C,_,B)
{
    var A=new TimeCom(B);
    switch(String(C).toLowerCase())
    {
        case"y":case"year":A.year+=_;
        break;
        case"n":case"month":A.month+=_;
        break;
        case"d":case"day":A.day+=_;
        break;
        case"h":case"hour":A.hour+=_;
        break;
        case"m":case"minute":A.minute+=_;
        break;
        case"s":case"second":A.second+=_;
        break;
        case"ms":case"msecond":A.msecond+=_;
        break;
        case"w":case"week":A.day+=_*7;
        break;
        default:return("invalid")
    }
    var $=A.year+"/"+A.month+"/"+A.day+" "+A.hour+":"+A.minute+":"+A.second;
    return new Date($);
}
function getToDay(_)
{
    var $=new Date();
    M=Number($.getMonth())+1;
    $=new Date($.getFullYear()+"/"+M+"/"+$.getDate());
    return formatDate($,_)
}
function getPreviousFirstDay(A)
{
    var $=new Date(),_=new Date($.getFullYear(),$.getMonth()-1,1);
    return formatDate(_,A)
}
function getPreviousLastDay(A)
{
    var $=new Date(),_=new Date($.getFullYear(),$.getMonth(),1);
    return formatDate(new Date(_-86400000),A)
}
function getPreviousFirstWeekDay(A)
{
    var _=new Date(),$=new Date(_-(_.getDay()-1)*86400000);
    $=new Date($-86400000*7);
    return formatDate($,A)
}
function showPreviousLastWeekDay(A)
{
    var _=new Date(),$=new Date(_-(_.getDay()-1)*86400000);
    $=new Date($-86400000);
    return formatDate($,A)
}
function getPreviousDay(_)
{
    var $=new Date();
    $=new Date($-86400000);
    return formatDate($,_)
}
function getNextDay(_)
{
    var $=new Date();
    $=new Date(($/1000+86400)*1000);
    return formatDate($,_)
}
function getNextFirstWeekDay(B)
{
    var _=new Date(),$=new Date(_-(_.getDay()-1)*86400000),A=new Date(($/1000+6*86400)*1000);
    A=new Date((A/1000+86400)*1000);
    return formatDate(A,B)
}
function getNextLastWeekDay(C)
{
    var A=new Date(),$=new Date(A-(A.getDay()-1)*86400000),_=new Date(($/1000+6*86400)*1000),B=new Date((_/1000+7*86400)*1000);
    return formatDate(B,C)
}
function getNextFirstDay(A)
{
    var $=new Date(),_=new Date($.getFullYear(),$.getMonth(),1);
    _=new Date(_.getYear(),_.getMonth()+1,1);
    return formatDate(_,A)
}
function getNextLastDay(A)
{
    var $=new Date(),_=new Date($.getFullYear(),$.getMonth(),1);
    _=new Date(new Date(_.getYear(),_.getMonth()+2,1)-86400000);
    return formatDate(_,A)
}
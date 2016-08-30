
function zlead(str,len){if(typeof str!='string')str=!str?'0':str.toString();while(str.length<(len||2))str='0'+str;return str;}
function escapeHTML(str){return(str||'').replace(/<\/?[a-z][a-z0-9]*[^<>]*>/g,'');}
function proc_entity(str){return(str||'').replace(/"/g,'&quot;').replace(/'/g,'&#39;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\$/g,'&#36;');}
function decode_entity(str){return(str||'').replace(/&amp;/g,'&').replace(/&#39;/g,"'").replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&#36;/g,'$');}
function proc_xss_entity(str){return(str||'').replace(/<(\/)?script[^>]?>/ig,'');}
function cutstr(str,len,sym){return((str||'').length>len)&&str.substr(0,len)+(sym||'&hellip;')||str;}
function str_repeat(i,m){for(var o=[];m>0;o[--m]=i);return(o.join(''));}
function sprintf(){var i=0,a,f=arguments[i++],o=[],m,p,c,x;while(f){if(m=/^[^\x25]+/.exec(f))o.push(m[0]);else if(m=/^\x25{2}/.exec(f))o.push('%');else if(m=/^\x25(?:(\d+)\$)?(\+)?(0|'[^$])?(-)?(\d+)?(?:[\.](\d+))?([b-ftosuxX])/.exec(f)){if(((a=arguments[m[1]||i++])==null)||(a==undefined))throw("Too few arguments.");if(/[^s]/.test(m[7])&&(typeof(a)!='number'))
throw("Expecting number but found "+typeof(a));switch(m[7]){case'b':a=a.toString(2);break;case'c':a=String.fromCharCode(a);break;case'd':a=parseInt(a);break;case'e':a=m[6]?a.toExponential(m[6]):a.toExponential();break;case'f':a=m[6]?parseFloat(a).toFixed(m[6]):parseFloat(a);break;case't':var _f=parseInt(a,10),_b=(parseFloat(a)-_f).toFixed(m[6])*100;a=zlead(_f,m[3])+':'+zlead(_b,m[6]);break;case'o':a=a.toString(8);break;case's':a=((a=String(a))&&m[6]?a.substring(0,m[6]):a);break;case'u':a=Math.abs(a);break;case'x':a=a.toString(16);break;case'X':a=a.toString(16).toUpperCase();break;}
a=(/[def]/.test(m[7])&&m[2]&&a>0?'+'+a:a);c=m[3]?m[3]=='0'?'0':m[3].charAt(1):' ';x=m[5]-String(a).length;p=m[5]?str_repeat(c,x):'';o.push(m[4]?a+p:p+a);}else throw("Huh ?!");f=f.substring(m[0].length);}
return o.join('');}
function money(d,sign){var tmp=d&&(d=parseFloat(d).toFixed(2))&&d.toString()||'0.00',m=tmp.match(/^(\-)?(\d+)\.(\d+)$/),res=[],b=m&&m[2].match(/^(\d{1,2})?((\d{3})+)$/)||null;if(b&&b[2])
for(var len=b[2].length/3,i=0;i<len;i++)
res.push(b[2].substr(i*3,3));else res.push(m[2]);return(m[1]||'')+(sign||'')+(b&&b[1]&&b[1]+','||'')+res.join(',')+'.'+m[3];}
function dump(v){var str='';for(var i in v){str+=i+'='+v+'\n';}
return str;}
var utc=0,uHOUR=3600000,uMIN=600000,__futime_cache=null;function futime_cache_reset(){__futime_cache={get:function(id){return this[id]||null;},put:function(id,value){this[id]=value;}};}
function futime_cache(){return __futime_cache&&true||false;}
futime_cache_reset();function futime(time,format,tzoffset,return_int,use_cache){var d=time===false?new Date():new Date().sparse(time),tm,mt,fmt,tmp;fmt=format||'%u';if(typeof(tzoffset)=='string')tzoffset=parseInt(tzoffset,10);if(use_cache&&__futime_cache&&(tmp=__futime_cache.get(time+'-'+format+'-'+tzoffset)))return tmp;if(time!==false&&time!='now'){if(typeof(time)!='string'&&typeof(time)!=undefined)time=time.toString();else time=time||'';if(tm=time.match(/^(\d{4})\-?(\d{2})\-?(\d{2})T(\d{2}):?(\d{2}):?(\d{2})Z$/)){d.setUTCHours(tm[4],tm[5],tm[6]);d.setUTCFullYear(tm[1],tm[2]-1,tm[3]);}
else if(tm=time.match(/^(\-?\d+)(u|m|s)$|^(\-?\d{13})$/)){switch(tm[2]){case'm':d.setTime(0);d.setUTCMinutes(tm[1]);break;case's':d.setTime(0);d.setUTCSeconds(tm[1]);break;default:d.setTime(tm[1]||tm[0])
break;}}
else if(tm=time.match(/^\d{10}$/)){d.setTime(tm[0]+'000');}
else if(tm=time.match(/^\d{10}\.\d{5}$/)){d.setTime(tm[0].replace(/\./,'').substr(0,13));}
else if(tm=time.match(/^(\d{1,2}):?(\d{1,2}):?(\d{1,2})?$/)){d.setUTCHours(tm[1],tm[2]||0,tm[3]||0);}
else if(tm=time.match(/^(\d{4})\-?(\d{2})\-?(\d{2})$/)){d.setUTCFullYear(tm[1],tm[2]-1,tm[3]);d.setUTCHours(0,0,0);}}else tm=true;d.setTime(d.getTime()+(tzoffset||0));d.setUTCMilliseconds(0);if(tm)
while(mt=fmt.match(/(%[AbBYymdDHahIMsSrRuTqlLwWfn])/)){var re,rp,tr='',tmp;switch(mt[1]){case'%Y':tr=d.getUTCFullYear();break;case'%y':tr=d.getUTCFullYear().toString().substr(2);break;case'%m':tr=zlead(d.getUTCMonth()+1,2);break;case'%d':tr=zlead(d.getUTCDate(),2);break;case'%D':tr=d.getUTCDate();break;case'%A':tr=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][d.getUTCDay()];break;case'%b':tr=['January','February','March','April','May','June','July','August','September','October','November','December'][d.getUTCMonth()];break;case'%B':tr=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][d.getUTCMonth()];break;case'%w':tr=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][d.getUTCDay()];break;case'%W':tr=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][d.getUTCDay()];break;case'%H':tr=zlead(d.getUTCHours(),2);break;case'%q':tr=zlead(Math.floor(d.getTime()/uHOUR));break;case'%a':tr=d.getUTCHours()>11?' pm':' am';break;case'%h':tr=(rp=d.getUTCHours())>12?rp-12:rp==0?12:rp;break;case'%I':tr=zlead((rp=d.getUTCHours())>12?rp-12:rp==0?12:rp,2);break;case'%M':tr=zlead(d.getUTCMinutes(),2);break;case'%s':tr=zlead(d.getUTCSeconds(),2);break;case'%S':tr=d.getTime();break;case'%r':var b=new Date();b.setTime(d.getTime());b.setSeconds(0);b.setMinutes(0);tr=b.getTime();break;case'%R':var b=new Date();b.setTime(d.getTime());b.setUTCHours(d.getUTCHours()+(d.getUTCMinutes()>0?1:0),0,0);tr=b.getTime();break;case'%T':var b=new Date();b.setTime(d.getTime());b.setUTCMinutes(Math.floor(b.getUTCMinutes()/10)*10);b.setUTCSeconds(0);tr=b.getTime();break;case'%u':tr=d.getUTCFullYear()+zlead(d.getUTCMonth()+1,2)+zlead(d.getUTCDate(),2)+'T'+zlead(d.getUTCHours(),2)+zlead(d.getUTCMinutes(),2)+zlead(d.getUTCSeconds(),2)+'Z';break;case'%l':var diff,b=new Date();if(tzoffset)b.setTime(b.getTime()+tzoffset)
diff=Math.floor(((b.getTime()-d.getTime())/1000)/60);if(diff<1440){tr=futime(time,'%h:%M%a',tzoffset);}else
if(diff<=21600||b.getUTCFullYear()==d.getUTCFullYear()){tr=futime(time,'%B %d',tzoffset);}else
tr=futime(time,'%m/%d/%Y',tzoffset);break;case'%L':var words,mins,diff,b=new Date();if(tzoffset)b.setTime(b.getTime()+tzoffset)
mins=Math.floor((b.getTime()-d.getTime())/1000/60);if(mins<1440){if(mins<=0)words='less than a minute ago';else
if(mins==1)words='a minute ago';else
if(mins<45)words=mins+' minutes ago';else
if(mins<90)words='1 hour ago';else
if(mins<1440)words=Math.floor(mins/60)+' hours ago';tr=futime(time,'%h:%M%a ('+words+')',tzoffset);}else
if(mins<=21600&&b.getUTCFullYear()==d.getUTCFullYear()){if(mins<2880)words='1 day ago';else
words=Math.floor(mins/1440)+' days ago';tr=futime(time,'%B %d ('+words+')',tzoffset);}else
if(b.getUTCFullYear()==d.getUTCFullYear())tr=futime(time,'%B %d',tzoffset);else
tr=futime(time,'%m/%d/%Y',tzoffset);break;case'%f':d.setDate(d.getDate()-(d.getDay()+6));tr='';break;case'%n':var b=new Date();b.setTime(d.getTime());tr=b.getWeek(1);break;default:tr='';break;}
re=new RegExp(mt[1]);fmt=fmt.replace(re,tr);}
if(use_cache)__futime_cache.put(time+'-'+format+'-'+tzoffset,fmt);return return_int===true?parseInt(fmt,10):fmt;}
function dfcache(time,format,tzoffset){var d=time===false?new Date():new Date().sparse(time),tm,mt,fmt,tmp;fmt=format||'%u';if(typeof(tzoffset)=='string')tzoffset=parseInt(tzoffset,10);if(__futime_cache&&(tmp=__futime_cache.get(d.getTime()+'-'+format+'-'+tzoffset)))return tmp;fmt=d.format(fmt,tzoffset);__futime_cache.put(d.getTime()+'-'+format+'-'+tzoffset,fmt);return fmt;}
Date.prototype.UTCDate=function(year,month,date){if(year&&month==undefined&&date==undefined){var tmp=year.toString().match(/^(\d{4})(\d{2})(\d{2})$/);year=tmp[1];month=parseInt(tmp[2],10)-1;date=tmp[3];}
this.setUTCFullYear(year,month,date);return this;}
Date.prototype.setWeek=function(wn,year){if(!year)year=this.getUTCFullYear();this.setTime(0);this.setUTCFullYear(year);this.setUTCMonth(0);this.setUTCDate(1);this.setUTCDate(7*(wn-1)-(this.getUTCDay()-2));return this;}
Date.prototype.getWeek=function(){var d=new Date(this.getTime());var DoW=d.getUTCDay();d.setUTCDate(d.getUTCDate()-(DoW+6)%7+3);var ms=d.valueOf();d.setUTCMonth(0);d.setUTCDate(4);return Math.round((ms-d.valueOf())/604800000)+1;}
Date.prototype.resetWeekDay=function(){this.setUTCDate(this.getUTCDate()-(this.getUTCDay()==0&&6||this.getUTCDay()-1));return this;}
Date.prototype.resetMonth=function(){this.setUTCMonth(0);this.resetDate();return this;}
Date.prototype.resetDate=function(){this.setUTCDate(1);this.resetTime();return this;}
Date.prototype.resetTime=function(){this.setUTCHours(0);this.resetMinutes();return this;}
Date.prototype.zeroTime=function(){this.setHours(0);this.setMinutes(0);this.setSeconds(0);this.setMilliseconds(0);return this;}
Date.prototype.resetMinutes=function(){this.setUTCMinutes(0);this.setUTCSeconds(0);this.setUTCMilliseconds(0);return this;}
Date.prototype.resetSeconds=function(){this.setUTCSeconds(0);this.setUTCMilliseconds(0);return this;}
Date.prototype.setLastDateOfMonth=function(){this.setUTCMonth(this.getUTCMonth()+1);this.setUTCDate(0);return this;}
Date.prototype.inc=function(inc,reset){if(typeof(inc)!='string')inc=inc.toString();var m=inc.match(/^(-|\+)?(\d+)([dwMyhtms])?$/),p=m[1]!='-',inc=p?+(parseInt(m[2],10)):-(parseInt(m[2],10));switch(m[3]){case'd':this.setUTCDate(this.getUTCDate()+inc);break;case'w':this.setUTCDate(this.getUTCDate()+(7*inc));break;case'm':this.setUTCMonth(this.getUTCMonth()+inc);if(reset)this.resetDate();break;case'y':this.setUTCFullYear(this.getUTCFullYear()+inc);if(reset)this.resetMonth(0);break;case'h':this.setUTCHours(this.getUTCHours()+inc);if(reset)this.resetMinutes();break;case'M':this.setTime(this.getTime()+(inc*60000));break;case's':this.setTime(this.getTime()+inc*1000);break;default:this.setTime(this.getTime()+inc);break;}
return this;}
Date.prototype.daysInMonth=function(month,year){return new Date().UTCDate(year||this.getUTCFullYear(),(month||this.getUTCMonth())+1,0).getUTCDate();}
Date.prototype.getDaysInMonth=function(){return this.daysInMonth(this.getMonth(),this.getFullYear());}
Date.prototype.setTimezone=function(tz){tz&&typeof(tz)!='number'&&(tz=parseInt(tz,10));this.tzoffset=tz;if(tz){this.setTime(this.getTime()+tz);this.setUTCMilliseconds(0);}
return this;}
Date.prototype.floor10=function(){this.setUTCMinutes(Math.floor(this.getUTCMinutes()/10)*10);return this;}
Date.prototype.ceil10=function(){this.setUTCMinutes(Math.ceil(this.getUTCMinutes()/10)*10);return this;}
Date.prototype.sparse=function(str){if(typeof(str)=='object'&&str instanceof Date){this.setTime(str.getTime());if(str.tzoffset)this.tzoffset=str.tzoffset;return this;}else
if(typeof(str)!='string')
if(str==undefined)return;else str=str.toString();var tm;if(str.match(/^now$/i))return this;if(tm=str.match(/^(\d{4})\-?(\d{2})\-?(\d{2})T(\d{2}):?(\d{2}):?(\d{2})Z$/)){this.setUTCHours(tm[4],tm[5],tm[6]);this.setUTCFullYear(tm[1],tm[2]-1,tm[3]);}
else if(tm=str.match(/^(\-?\d+)(u|m|s)$/)){this.setTime(0);switch(tm[2]){case'm':this.setUTCMinutes(tm[1]);break;case's':this.setUTCSeconds(tm[1]);break;case'u':this.setTime(tm[1]+'000');break;}}
else if(tm=str.match(/^\-?\d+$/)){this.setTime(tm[0])}
else if(tm=str.match(/^(\d{1,2}):?(\d{2}):?(\d{2})?$/)){this.setUTCHours(tm[1],tm[2]||0,tm[3]||0);}
else if(tm=str.match(/^(\d{4}).(\d{2}).(\d{2})|(\d{4})(\d{2})(\d{2})d|(\d{2}).(\d{2}).(\d{4})$/)){this.setUTCFullYear(tm[1]||tm[4]||tm[9],(tm[2]||tm[5]||tm[7])-1,tm[3]||tm[6]||tm[8]);this.resetTime();}
return this;}
function format_tz(tz){if(tz!=undefined){var s=tz>0&&'+'||((tz=-(tz))&&'-'),h=Math.floor(tz/1000/60/60),m=(tz/1000/60)-(h*60);return'UTC'+(tz!=0&&(s+zlead(h,2)+(m&&':'+zlead(m,2)||''))||'');}else{return'UTC'}}
Date.prototype.format=function(fmt,tz){var re,rp,tr='',tmp,mt,store;if(tz){typeof(tz)!='number'&&(tz=parseInt(tz,10));store={tz:this.tzoffset,time:this.getTime()};this.setTimezone(tz)}!fmt&&(fmt='%u');while(mt=fmt.match(/(%[AbBYymdDHahIMsSrRuTtqlLwWfnz])/)){switch(mt[1]){case'%Y':tr=this.getUTCFullYear();break;case'%y':tr=this.getUTCFullYear().toString().substr(2);break;case'%m':tr=zlead(this.getUTCMonth()+1,2);break;case'%d':tr=zlead(this.getUTCDate(),2);break;case'%D':tr=this.getUTCDate();break;case'%A':tr=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][this.getUTCDay()];break;case'%b':tr=['January','February','March','April','May','June','July','August','September','October','November','December'][this.getUTCMonth()];break;case'%B':tr=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][this.getUTCMonth()];break;case'%w':tr=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'][this.getUTCDay()];break;case'%W':tr=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][this.getUTCDay()];break;case'%H':tr=zlead(this.getUTCHours(),2);break;case'%q':tr=zlead(Math.floor(this.getTime()/(1000*60*60)));break;case'%a':tr=this.getUTCHours()>11?'pm':'am';break;case'%h':tr=(rp=this.getUTCHours())>12?rp-12:rp==0?12:rp;break;case'%I':tr=zlead((rp=this.getUTCHours())>12?rp-12:rp==0?12:rp,2);break;case'%M':tr=zlead(this.getUTCMinutes(),2);break;case'%s':tr=zlead(this.getUTCSeconds(),2);break;case'%S':tr=this.getTime();break;case'%r':var b=new Date();b.setTime(this.getTime());b.resetMinutes();tr=b.getTime();delete b;break;case'%R':var b=new Date();b.setTime(this.getTime());b.setUTCHours(this.getUTCHours()+(this.getUTCMinutes()>0?1:0),0,0);tr=b.getTime();delete b;break;case'%T':var b=new Date();b.setTime(this.getTime());b.setUTCMinutes(Math.floor(b.getUTCMinutes()/10)*10);b.setUTCSeconds(0);tr=b.getTime();delete b;break;case'%t':var b=new Date(),c;b.setTime(this.getTime());b.ceil10().resetSeconds();tr=b.getTime();delete b;break;case'%u':tr=this.getUTCFullYear()
+zlead(this.getUTCMonth()+1,2)
+zlead(this.getUTCDate(),2)
+'T'+zlead(this.getUTCHours(),2)
+zlead(this.getUTCMinutes(),2)
+zlead(this.getUTCSeconds(),2)
+'Z';break;case'%l':var diff,b=new Date(window.gapp&&gapp.server_time||window.server_time||this.getTime());if(this.tzoffset)b.setTime(b.getTime()+this.tzoffset)
diff=Math.floor(((b.getTime()-this.getTime())/1000)/60);if(this.format('%Y%m%d')==b.format('%Y%m%d')){tr=this.format('%h:%M%a');}else
if(b.getUTCFullYear()==this.getUTCFullYear()){tr=this.format('%B %d');}else
tr=this.format('%m/%d/%Y');delete b;break;case'%K':var loffset=((this.getHours()-this.getUTCHours())*60+(this.getMinutes()-this.getUTCMinutes()))*60000;this.setTimezone(loffset);case'%E':var exact=true;case'%L':var words,b=new Date(window.gapp&&gapp.server_time||window.server_time||obj.getTime()),tmp;if(obj.tzoffset)b.setTime(b.getTime()+obj.tzoffset);var mins=Math.floor((b.getTime()-obj.getTime())/1000/60),sameYear=obj.getUTCFullYear()==b.getUTCFullYear(),sameDay=sameYear&&obj.getUTCMonth()==b.getUTCMonth()&&obj.getUTCDate()==b.getUTCDate(),isYest=!sameDay&&sameYear&&obj.getUTCMonth()==b.getUTCMonth()&&obj.getUTCDate()==b.getUTCDate()-1;switch(true){case sameDay:switch(true){case mins<=0:words='less than one minute ago';break;case mins==1:words='a minute ago';break;case mins<45:words=mins+' minutes ago';break;case mins<90:words='about an hour ago';break;default:words=(tmp=Math.floor(mins/60))+' hour'+(tmp>1&&'s'||'')+' ago';break;}
tr=exact&&obj.format('%h:%M%a ('+words+')')||words;break;case isYest&&mins<720:words=(mins>59&&((tmp=Math.floor(mins/60))+' hour'+(tmp>1&&'s'||''))||(mins+' min'+(mins>1&&'s'||'')))+' ago'
tr=exact&&('yesterday ('+words+')')||words;break;case mins<=43200&&sameYear:tmp=Math.floor(mins/1440);if(!tmp)tmp=1;else tmp++;words=(tmp&&(tmp+' day'+(tmp>1&&'s'||''))||'half a day')+' ago';tr=exact&&obj.format('%B %D ('+words+')')||words;break;case mins>43200&&sameYear:tmp=Math.floor(mins/43200);words=(tmp+' month'+(tmp>1&&'s'||''))+' ago';tr=exact&&obj.format('%B %D ('+words+')')||words;break;default:tr=exact&&obj.format('%m/%d/%Y')||(tmp=(obj.getUTCFullYear()-b.getUTCFullYear())&&tmp&&(tmp+' year'+(tmp>2&&'s'||'')+' ago'));break;}
delete b;break;case'%f':d.setDate(d.getDate()-(d.getDay()+6));tr='';break;case'%n':tr=this.getWeek(1);break;case'%z':tr=format_tz(this.tzoffset);break;default:tr='';break;}
re=new RegExp(mt[1]);fmt=fmt.replace(re,tr);}
if(tz){this.setTimezone(store.tz);this.setTime(store.time);}
return fmt;}
var timers={pool:{},base:0,add:function(timeout,func,arg,loop,pid){var id=pid?pid:this.base++;this.pool[id]={id:setTimeout("timers._done('"+id+"')",timeout),func:func,arg:arg,loop:loop||false,timeout:timeout};return id;},restart:function(id,new_callback,new_arg){if(this.pool[id]){clearTimeout(this.pool[id].id);this.pool[id].id=setTimeout("timers._done('"+id+"')",this.pool[id].timeout);if(new_callback===false||new_callback)this.pool[id].func=new_callback||null;this.pool[id].arg=new_arg||null;return id;}return false;},stop:function(id){if(this.pool[id])clearTimeout(this.pool[id].id);this._remove(id);},_remove:function(id){this.pool[id]=null;},_done:function(id){if(!this.pool[id])return false;this.pool[id].func(this.pool[id].arg);(this.pool[id]&&this.pool[id].loop)?this.pool[id].id=setTimeout("timers._done("+id+")",this.pool[id].timeout):this._remove(id);}}
var httpReq={xhr:false,busy:false,stack:[],timeout:60000,cur_req_method:null,_cb_params:false,_cb_func:false,_stopTO:function(){},_startTO:function(){},_fireTO:function(){},_create:function(){if(window.XMLHttpRequest){this.xhr=new XMLHttpRequest();}else if(window.ActiveXObject){try{this.xhr=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{this.xhr=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){}}}
if(!this.xhr){alert('Cannot create XMLHTTP instance');return false;}
this.xhr.onreadystatechange=this._state;},_state:function(){if(httpReq.xhr.readyState==4){httpReq.cur_req_method=null;if(httpReq._cb_func){fire_callback(httpReq._cb_func,[httpReq.xhr.status,httpReq.xhr.responseText,httpReq._cb_params],true);httpReq._cb_func=false;httpReq._cb_params=false;}
httpReq.busy=false;httpReq._stopTO();if(httpReq.stack.length){var tmp=httpReq.stack.pop();httpReq.request(tmp.url,tmp.method,tmp.pars,tmp.cb_func,tmp.cb_pars,tmp.concurent);}}},request:function(url,method,req_params,cb_func,cb_params,concurent){if(this.busy){if(concurent&&this.cur_req_method=='get'){this.xhr.abort();}else{this.stack.push({url:url,method:method,pars:req_params,cb_func:cb_func,cb_pars:cb_params,concurent:concurent});return;}}
this._cb_func=cb_func;this._cb_params=cb_params;this._create();this._startTO();if(req_params&&typeof(req_params)!='string'&&typeof(req_params)!='boolean'){if(typeof(req_params)=='object'){var result=new Array;for(var key in req_params)if(req_params[key]!==null&&typeof(req_params[key])!='undefined')result.push(encodeURIComponent(key)+'='+encodeURIComponent(req_params[key]));req_params=result;}
req_params=req_params.join('&').replace(/%20/g,'+');}else if(!req_params)req_params='';this.busy=true;method=method.toLowerCase();this.xhr.open(method,url+(method=='get'&&req_params!=''?'?'+req_params:''),true);this.xhr.setRequestHeader("X-Requested-With","XMLHttpRequest");switch(this.cur_req_method=method.toLowerCase()){case'post':this.xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');this.xhr.setRequestHeader('Content-length',req_params.length);this.xhr.send(req_params);break;case'get':this.xhr.send(null);break;}}}
function check_form(ctrls,err_txt,skip_trim,defs){var post=defs||{},error=[],tmp;if(typeof(ctrls)=='string')ctrls=$(ctrls);for(var i=ctrls.length;--i>=0;){var val=skip_trim||false?$(ctrls[i]).val():$(ctrls[i]).val().replace(/^[\s\n]+|[\s\n]+$/g,'');if(tmp=$(ctrls[i]).attr('check')){if(val.match(tmp)){post[(ctrls[i].name||ctrls[i].id)]=val;$(ctrls[i]).removeClass('error');}else{error.push(err_txt[(ctrls[i].name||ctrls[i].id)]);$(ctrls[i]).addClass('error');}}else post[(ctrls[i].name||ctrls[i].id)]=val;}
return{error:error,data:post};}
function fillup_form(ctrls,data){if(typeof(ctrls)=='string')ctrls=$(ctrls);for(var name,i=ctrls.length;--i>=0;){if(name=(ctrls[i].name||ctrls[i].id)){switch(ctrls[i].tagName){case'INPUT':switch($(ctrls[i]).attr('type')){case'checkbox':$(ctrls[i]).attr('checked',data[name]);break;default:$(ctrls[i]).val(data[name]);break;}
break;default:$(ctrls[i]).val(data[name]);break;}}}}
function proc_tpl(tpl,src){this.get_value=function(key){var d=src,re,val='',sub,ikey;if((ikey=key.split(/!/)).length>1){sub=ikey[1];key=ikey[0];}else{sub=ikey=false;}
if((key=key.split(/\./)).length>1){var j=0;do{if(d&&typeof(d[key[j]])!='undefined'&&(typeof(d)=='object'||typeof(d)=='array'))d=d[key[j]];else{d='';break;}}while(key.length>++j);val=d;}else
if(key[0]&&key[0].substr(0,1)=='#'){try{eval('val = '+key[0].substr(1)+';');}catch(e){val='';}}else val=typeof(src[key[0]])!='undefined'?src[key[0]]:'';if(sub!==false){if($.browser.msie&&sub.match(/^:/)){tmp=sub;sub=[];sub[0]='';sub[1]=tmp.replace(/^:/,'');}else sub=sub.split(/:/);var ret=Boolean((typeof(val)!='object'&&val.match)?val.match(/^\d+$/)?parseInt(val):val.match(/^true|false$/i)?val.match(/true/i):val:val)?sub[0]:(sub[1]||'');if(ret.match&&ret.match(/^\$|@/)){switch(ret.substr(0,1)){case'$':ret=ret=='$'?val:this.get_value(ret.substr(1));break;case'@':ret=this.process(this.get_tpl(ret.substr(1)),src);break;}}
return ret;}
if(key[0].match&&key[0].match(/^@/)&&val=='')
val=this.process(this.get_tpl(key[0].substr(1)),src);return val;};this.get_tpl=function(tpl){if(tpl.match(/^[\w\.]+$/)){var tmp=document.getElementById(tpl);switch((tmp.attributes.getNamedItem('type')&&tmp.attributes.getNamedItem('type').nodeValue)||false){case'text':var i=-1;while(tmp.childNodes.length>++i)
if(tmp.childNodes[i].nodeName=='#comment'){tpl=tmp.childNodes[i].data;break;}
break;default:tpl=tmp.innerHTML;break;}}
return tpl;}
this.process=function(tpl,src){var match;tpl=this.get_tpl(tpl);if(tpl&&src&&(match=tpl.match(/%[^%][\w\.\-:!\&;\$@#]+%/g))){for(var i=match.length;--i>=0;){var val=this.get_value(match[i].replace(/%/g,'')),re=new RegExp(match[i].replace(/\$/g,'\\$'),'g');tpl=tpl.replace(re,val);}}
return tpl;}
return this.process(tpl,src).replace(/\$/g,'&#36;');}
function http_status2str(status){var msg;switch(status){case 400:msg='Bad Request';break;case 415:msg='Unsupported media type';break;case 401:msg='Unauthorized';break;case 403:msg='Forbidden';break;case 404:msg='Not found';break;case 503:msg='Service Unavailable';break;case 500:msg='Internal Server Error';break;case 200:msg='OK';break;case 0:msg='request terminated';break;case-1:msg='Data processing error';break;case-2:msg='Request timeout'
break;}
return msg;}
function fmtSize(size){if(typeof(size)!='integer')size=parseInt(size);var k=10485760,ret,suf;if(size>1024&&size<k){ret=Math.round(size/1024);suf='Kb';}else if(size>=k){ret=Math.round(size/1048576);suf='Mb';}else{ret=size||0;suf='b';}
return ret+suf;}
function paging(total,pp,cp,page_tpl){var total_pages=Math.upround(total/pp),page_list=[],sp;cp++;if(cp>4&&total_pages>7){page_list.push(proc_tpl(page_tpl,{page:1}));page_list.push(proc_tpl(page_tpl,{page:2}));page_list.push(proc_tpl(page_tpl,{blanks:true}));}
if(cp<=4||total_pages<=7)sp=1;else if(cp<total_pages-3)sp=cp-1;else if(cp>=total_pages-3)sp=total_pages-4;else sp=cp;for(var i=sp;(sp<sp+3)&&i<=(total_pages>7&&cp<total_pages-3?(cp<4?4:cp+1):total_pages);i++)page_list.push(proc_tpl(page_tpl,{page:i,current:i==cp}));if(cp<total_pages-3&&total_pages>7){var tmp;page_list.push(proc_tpl(page_tpl,{blanks:true}));page_list.push(proc_tpl(page_tpl,{page:tmp=total_pages-1,current:cp==tmp}));page_list.push(proc_tpl(page_tpl,{page:tmp=total_pages,current:cp==tmp}));}
return{prev:cp>1?cp-1:false,next:cp<total_pages?cp+1:false,page_list:page_list.join('')}}
Math.upround=function(val){var rval=Math.round(val);return val>rval?rval+1:rval;}
Math.format_float=function(pFloat,pDp){return parseFloat(new Number(pFloat).toFixed(pDp));}
Math.odesk_float=function(pFloat){if(typeof(pFloat)=='undefined')return'0.00';var f=Math.format_float(pFloat,2);if(!f)f='0.00';var t=f.toString().split('.');if(!t[1])f+='.00';else if(t[1].length==1)f+='0';return addSeparatorsNF(f,'.','.',',');}
function toggle_navbar(id,sender,fake){if($('#tdnavbar').css('display')!='none'){$('#tdnavbar').css('display','none');return false;}else{$('#tdnavbar').toggle();return true;}}
btree_leaf.prototype={leaf_left:null,leaf_right:null,value:null,key:null,get_tree:function(filter){var tree=[];if(this.leaf_left)tree=tree.concat(this.leaf_left.get_tree(filter));if(filter&&this.key.toString().match(filter)||!filter)tree.push({key:this.key,value:this.value});if(this.leaf_right)tree=tree.concat(this.leaf_right.get_tree(filter));return tree;},get_rtree:function(filter){var tree=[];if(this.leaf_right)tree=tree.concat(this.leaf_right.get_rtree(filter));if(filter&&this.key.toString().match(filter)||!filter)tree.push({key:this.key,value:this.value});if(this.leaf_left)tree=tree.concat(this.leaf_left.get_rtree(filter));return tree;}}
function btree_leaf(key,value,root){if(!root){this.key=key;this.value=value;return this;}else{if(root.key>=key)root.leaf_left=new btree_leaf(key,value,root.leaf_left);else root.leaf_right=new btree_leaf(key,value,root.leaf_right);return root;}}
btree.prototype={root_node:null,get_tree:null,_init:function(revert){if(revert)
this.get_tree=this._get_rtree;else
this.get_tree=this._get_tree;return this;},add:function(key,value){this.root_node=new btree_leaf(key,value,this.root_node);},get_value:function(key){var node=this.root_node;while(node&&node.key!=key){if(node.key>key)
node=node.leaf_left;else
node=node.leaf_right;}
if(node&&typeof(node.value)!='undefined')return node.value;return null;},_get_tree:function(arg){return this.root_node&&this.root_node.get_tree(arg)||[];},_get_rtree:function(arg){return this.root_node&&this.root_node.get_rtree(arg)||[];}}
function btree(revert){return this._init(revert);}
function cthread(func,args){setTimeout(func,1);}
function winopen(url){window.open(url,'','toolbars=0,resizable=1,scrollbars=1');}
function unescapeHTML(html){var htmlNode=document.createElement("DIV");htmlNode.innerHTML=html;if(htmlNode.innerText)
return htmlNode.innerText;return htmlNode.textContent;}
var mc_unread_msg={unread_sum:0,timer:null,link_obj:null,link:'',data:{},prev_cache_value:null,trays:{inbox:'',notifications:'',tickets:'',sent:''},c_name:(('undefined'!=typeof ODESK_COOKIE_PREFIX)?ODESK_COOKIE_PREFIX:'')+'mc_unread.'+(('undefined'!=typeof USER_UID)?USER_UID:''),init:function(){if(this.is_initialized)return;this.is_initialized=true;if(1>jQuery('#mc_unread_link').length)return;this.link_obj=jQuery('#mc_unread_link');this.prev_cache_value=null;var c_value_cookie=this.check_icon_cache();if(c_value_cookie)
this.update_icon_data_cookie(c_value_cookie);else
this.get_status();this.c_value_init=[];if(timers)this.timer=timers.add(MC_SHOW_NEW_TTL,this.get_status,null,true);},update_icon_data_api:function(){var expires=MC_UNREAD_CACHE_TTL/86400,c_value='',unread_sum=0,data=('undefined'!=typeof this.data.trays)?this.data.trays:[];for(var i=data.length;--i>=0;){if(0!=data[i]['unread']&&'undefined'!=typeof this.trays[data[i]['type']]){this.trays[data[i]['type']]=parseInt(data[i]['unread']);if('inbox'==data[i]['type']||'tickets'==data[i]['type']||((data[i]['type']=='notifications')&&!window.location.hash.match(/notifications.*?/))){unread_sum+=this.trays[data[i]['type']];}
c_value+=data[i]['type']+'='+this.trays[data[i]['type']]+',';}}
if(0==unread_sum)
expires=expires/2;this.prev_cache_value=jQuery.cookie(this.c_name);jQuery.cookie(this.c_name,(c_value)?c_value:0,{domain:ODESK_COOKIE_DOMAIN,path:'/',expires:expires});if(window.odesk&&odesk.launchbar)odesk.launchbar.update(odesk.launchbar.encodeCookie(c_value)).saveCookie();logger.say('mc_unread_msg._update_icon_data: COOKIE stored');this.refresh_icon(c_value);},update_icon_data_cookie:function(c_value_cookie){this.refresh_icon(c_value_cookie);},refresh_icon:function(c_value){if(!this.link_obj)return;var icon_obj=this.link_obj.children('span.badge'),patt=/(\w+)=(\d+)/i,trays=[],tmp='';this.prev_cache_value=c_value;this.unread_sum=0;trays=c_value.split(',');jQuery('#messages_dropdown li.menuitem a').attr('style','font-weight: normal !important;').each(function(){jQuery(this).html(jQuery(this).html().replace(/\s+\(\d+\)/,''));});for(var i=trays.length;--i>=0;){if((tmp=trays[i].match(patt))&&tmp[1]&&tmp[2]&&tmp[2]!='0'){if('inbox'==tmp[1]||'tickets'==tmp[1]||(('notifications'==tmp[1])&&!window.location.hash.match(/notifications.*?/))){this.unread_sum+=parseInt(tmp[2]);}
jQuery("#messages_dropdown li.menuitem a[href$='"+tmp[1]+"']").append(' ('+tmp[2]+')').attr('style','font-weight: bold !important;');}}
this.link_obj.attr('title',this.unread_sum+' unread message'+(this.unread_sum!=1?'s':''));jQuery('#messages_dropdown [title]').Tooltip({track:true,delay:500,showURL:false,showBody:" - ",fade:250});if(0<this.unread_sum){this.link_obj.css('font-weight','bold');icon_obj.text(this.unread_sum).show();}else{this.link_obj.css('font-weight','normal');icon_obj.hide();}
logger.say('mc_unread_msg.refresh_icon: msg_unread refreshed');},get_status:function(){httpReq.request(MC_REST_URI+'/trays.json','get',null,function(status,data){switch(status){case 200:try{eval('mc_unread_msg.data = '+data);logger.say('mc_unread_msg.get_status: msg_unread retrieved from API (status 200)');mc_unread_msg.update_icon_data_api();}catch(e){return;}
break;case 401:mc_unread_msg.stop();logger.say('mc_unread_msg.get_status: API Failed, timer stopped, no more api calls (status '+status+')');break;default:break;}});},check_icon_cache:function(){var c_value=jQuery.cookie(this.c_name);if(!c_value){return false;}else{logger.say('mc_unread_msg.get_status: msg_unread retrieved from MC_UNREAD_COOKIE');return c_value;}},_set_status_data:function(data){this.data.trays=data;mc_unread_msg.update_icon_data_api();},update_status:function(tray_data){mc_unread_msg._set_status_data(tray_data);},stop:function(){timers.stop(mc_unread_msg.timer);}}
function loading_process(text,ismodal,timeout){var tmp;if(!text&&(tmp=$('#page_loading, #page_loading_shield')).length){tmp.fadeOut(500,function(){$(this).remove();$('#loading_throbber').remove();});}else if(text){if((tmp=$('#page_loading')).length){tmp.html(text);}else{if(ismodal)
$('<div id="page_loading_shield"></div>').appendTo('body');$('<div id="page_loading" class="'+(ismodal?'modal':'non-modal')+'">'+text+'</div>').appendTo('body').fadeIn(500);if(timeout)
timers.add(timeout,function(){$('#page_loading, #page_loading_shield').fadeOut(1000,function(){$(this).remove();});});}}}
function load_script(url,callback,cb_param){var head=document.getElementsByTagName("head")[0]||document.documentElement,script=document.createElement("script");logger.say('loading script: '+url)
script.type="text/javascript";try{if(callback instanceof Object){if(script.readyState){script.onreadystatechange=function(){if(script.readyState=="loaded"||script.readyState=="complete"){script.onreadystatechange=null;logger.say('script loaded: '+url);fire_callback(callback,cb_param,false);}};}else{script.onload=function(){logger.say('script loaded: '+url);fire_callback(callback,cb_param,false);};}}
script.src=url;head.insertBefore(script,head.firstChild);}catch(e){logger.error('error script loading: "'+url+'"');}}
function generate_feedback_tooltip(obj){obj.comment=obj.comment!=''?(obj.is_public?obj.comment=obj.comment.replace(/&amp;/g,'&').replace(/\n/g,'<br />'):obj.comment=proc_tpl("comment_is_private_tpl")):proc_tpl("no_comment_tpl");obj.detailed_rows="";if("undefined"!=typeof(obj.scores))
for(var i=0;i<obj.scores.score.length;i++)
obj.detailed_rows+=proc_tpl("detailed_feedback_row_tpl",obj.scores.score[i]);return proc_tpl("detailed_feedback_tpl",obj);}
function showbox(head,text,type,timeout){$('div#box_underlayer').remove();var box=$('<div class="alert dismissable box-float" id="showbox"></div>').addClass(type=type||'friendly').append('<h2><span class="icon '+type+'">&nbsp;</span>'+head+'<span class="close" id="showbox_close">close</span></h2>').append($('<div class="content"></div>').html(text));$('<div id="box_underlayer"></div>').append(box).append('<div class="shield"></div>').appendTo('body');$(box).css('width',$(box)[0].offsetWidth+'px');$('#box_underlayer').css({left:Math.round(($('body')[0].offsetWidth-$('#box_underlayer')[0].offsetWidth)/2),display:'none'});if($.browser.msie&&$.browser.version.substr(0,1)=='7'){$('#box_underlayer').show();}else{$('#box_underlayer').fadeIn('slow');}
$('span#showbox_close').click(function(){$('#box_underlayer').fadeOut('slow',function(){$(this).remove();})});if(timeout)
timers.add(timeout,function(){$('#box_underlayer').fadeOut(1000,function(){$(this).remove();})})}
var gapp=null,dtpl={tpls:{},behaviors:{deps:[],code:[]},load:function(list,on_complete){if(typeof(list)=='array')list=list.join(',');loading_process('Loading resources...');httpReq.request('/api/resources/v1.json','post',{list:list},function(status,data,on_complete){switch(status){case 200:dtpl.use(eval_json(data))
if(typeof(on_complete)=='function')on_complete();break;default:logger.error('templates loding error:\n'+status+'/'+http_status2str(status)+'');break;}},on_complete);},use:function(data){for(var t in data.tpls){var tmp='dtpl.tpls[\''+t+'\'] = '+data.tpls[t];eval(tmp);tmp='dtpl.behaviors.code["'+t+'"] = '+(data.behaviors.code[t]&&'function(){\n'+data.behaviors.code[t]+'\n}'||'null');eval(tmp);}
this.behaviors.deps=data.behaviors.deps;},proc:function(rule,tpl,data,context){if(typeof(tpl)!='string'){context=data;data=tpl;tpl=rule;rule=null;}
if(typeof(this.tpls[tpl])!='function'){logger.error('template '+tpl+' was not found!');return;}
if(rule){var ret=this.proc(tpl,data,context),m='';if(typeof(rule)=='string'){m=(m=rule.match(/^(.)/))&&m[1];rule=rule.replace(/^[\+\-]/,'');}
switch(m){case'+':$(rule).append(ret);break;case'-':$(rule).replaceWith(ret);break;case'<':$(ret).insertBefore(rule);break;case'>':$(ret).insertAfter(rule);break;default:$(rule).html(ret);break;}
this.behavior(tpl,context);if(typeof(globalPPManager)!='undefined'){logger.say('post processing...');globalPPManager.process();}}else return this.tpls[tpl].call(context||null,data,null,context||null);},behavior:function(tpl,context){var deps={};this.get_deps(tpl,deps);deps[tpl]=true;for(var i in deps){if(this.behaviors.code[i])
this.behaviors.code[i].call(context||null);}},get_deps:function(tpl,deps){var _deps;if(_deps=this.behaviors.deps[tpl])
for(var i=_deps.length;--i>=0;){if(!deps[_deps[i]]){deps[_deps[i]]=true;this.get_deps(_deps[i],deps);}}}}
function in_array(src,niddle){for(var i=src.length;--i>=0;)
if(src[i]===niddle)return i;return false;}
function join_mixed(src,char){var result;switch(typeof(src)){case'object':if(src instanceof Array){result=src.join(char||' ');}else{var ar=[];for(var i in src)
ar.push(i+'="'+src[i]+'"')
result=ar.join(char||' ');}
break;case'array':result=src.join(char||' ');break;case'undefined':result='';break;default:result=src;break;}
return result;}
function add2mixed(mixed,data,delim){delim?delim=' ':null;if(typeof(mixed)=='string'||mixed instanceof String){if(mixed!='')mixed+=delim+data;else mixed=data;}else
if(typeof(mixed)=='array'||mixed instanceof Array){mixed.push(data);}else
if(typeof(mixed)=='object'||mixed instanceof Object)
mixed[data]=delim;return mixed;}
function fire_callback(method,args,async,error_msg){var af=function(){try{if(method instanceof Array)
method[1].apply(method[0],args||[])
else
if(method instanceof String)
eval(method+'.apply(null, args || [])')
else
if(method instanceof Function)
method.apply(null,args||[]);}catch(e){logger.error(error_msg&&sprintf(error_msg,e.toString())||e.toString());}}
if(async)
setTimeout(af,5)
else
af();}
var dispatcher={container:{},register:function(event_type,rule,handler){var id=event_type+'::'+rule;if(!this.container[id])this.container[id]=[];this.container[event_type+'::'+rule].push(handler);logger.say('event registration:\ntype:'+event_type+'\nrule:'+rule)
$(rule).live(event_type,{rule:rule},this.__event_handler);},unregister:function(event_type,rule){var id=event_type+'::'+rule;logger.say('event deregistration:\ntype:'+event_type+'\nrule:'+rule)
if(this.container[id]){$(rule).die(event_type,this.__event_handler);delete this.container[id];}},__event_handler:function(event,value,data){var self=dispatcher,rule=event.data.rule,evid=$(this).attr('evid')||$(this).attr('id')||'none',handlers=self.container[event.type+'::'+rule];logger.say('event processing:\ntype:'+event.type+'\nevid: '+evid+'\nrule:'+rule);if($(this).hasClass('disabled')||$(this).parents('.disabled').length)return false;for(var i=handlers.length;--i>=0;)
fire_callback(handlers[i],[evid,event,this,data||event.data],true,'catch error while dispatch event:\n%s\n---\nevent id: '+evid+', event: '+event.type);}}
function wrap_word(obj_id,limit,wbr){wbr=(wbr)?wbr:' ';var alpha_str='1234567890abcdefghijklmnopqrstuvwxyz',cur_words=[],limit_width=0,min_width=0,mg='px';if('string'==typeof(obj_id)){if(limit&&!isNaN(limit)){return obj_id.replace(RegExp('(\\S{'+limit+'})(\\S)','g'),function(text,word,char){return word+wbr+char;});}else{try{cur_words=jQuery(obj_id);if(1>cur_words.length)return false;}catch(e){return false;}
if(limit&&(res=limit.match(RegExp('^(\\d+)(\\w+)')))){limit_width=res[1];mg=res[2];}else{var org_overflow=cur_words.css('overflow'),org_display=cur_words.css('display');cur_words.css({overflow:'scroll',display:'block'})
limit_width=cur_words[0].clientWidth+10;cur_words.css({overflow:org_overflow,display:org_display})}
if(limit_width){container=jQuery(obj_id+':first').clone();jQuery(obj_id+':first').after(container);}else{return false;}}}else if('object'==typeof(obj_id)){cur_words=obj_id;if(limit&&(res=limit.match(RegExp('^(\\d+)(\\w+)')))){limit_width=res[1];mg=res[2];}
if(1<cur_words.length){var first_obj=jQuery(':first',cur_words).parent();container=first_obj.clone();first_obj.after(container);if(0==limit_width)limit_width=first_obj.innerWidth();}else{container=cur_words.clone();cur_words.after(container);if(0==limit_width)limit_width=cur_words.innerWidth();}}
container.css({width:limit_width+mg,position:'absolute',left:'-3000px',top:'-3000px'});container.html('<span id="tmp_container">'+alpha_str+'</span>');min_width=parseInt(limit_width*alpha_str.length/jQuery('#tmp_container').width())-1;container.remove();for(var k=0;k<cur_words.length;k++){cur_words[k].innerHTML=cur_words[k].innerHTML.replace(RegExp('(\\S{'+min_width+'})(\\S)','g'),function(text,word,char){return word+wbr+char;});}}
function obj2arr(obj){return obj instanceof Array&&obj||[obj];}
function round_time(min){var tmp=Math.round(parseFloat(min)*60),a=tmp%10;return a>4&&(tmp+(10-a))||tmp-a;}
logger={actual:null,stack:[],whole:null,disabled:false,start:function(msg){if(this.disabled)return;this.actual={msg:msg,time:new Date().getTime()}
if(!this.whole)this.whole=this.actual.time;},end:function(){if(this.disabled)return;if(!this.actual)return;this.actual.time=new Date().getTime()-this.actual.time;this.stack.push(this.actual);this.actual=null;},say:function(msg,data,ident){if(data){switch(typeof(data)){case'array':logger.say(msg+' (array:'+data.length+')['+data.join(',')+']',ident);break;case'object':logger.say(msg+' (object){');!ident&&(ident=0)
for(var i in data){!data[i]instanceof Object&&!data[i]instanceof Array&&logger.say(i+': '+data[i],null,ident+3)||logger.say(i,data[i],ident+3);}
logger.say('}');break;default:logger.say(msg+': ('+typeof(data)+')'+data,null,ident);break;}}else{if(ident)for(var i=ident;--i>=0;)msg=' '+msg;console.say&&console.say(msg)||console.log(msg)};},time:function(time){if(time>1000)time=sprintf('%0.3fs',time/1000)
else time=time+'ms';return time;},show:function(head){if(this.disabled)return;console.log('---------'+head+'['+this.time(new Date().getTime()-this.whole)+']----------');this.whole=null;for(var gt=0,obj,str='',i=0;i<this.stack.length;i++){obj=this.stack[i];console.log('['+this.time(obj.time)+']  '+obj.msg);gt+=obj.time;}
console.log('----------')
console.log('total time: '+this.time(gt));this.stack=[];},error:function(msg){if(this.disabled){alert(msg);return;}
console.error(msg);}}
if(typeof(console)=='undefined'){console={log:function(){},error:function(){},say:function(str){}}}
function eval_json(data){data='var __JSON_EVALUATE = '+data;var head=document.getElementsByTagName("head")[0]||document.documentElement,script=document.createElement("script");script.type="text/javascript";if(jQuery.support.scriptEval)
script.appendChild(document.createTextNode(data));else
script.text=data;head.insertBefore(script,head.firstChild);head.removeChild(script);var result=__JSON_EVALUATE;delete __JSON_EVALUATE;return result;}
function hEval(src){var script=$('#__eval_script_helper'),data='window.__eval_data = '+src;if(!script.length){var head=document.getElementsByTagName("head")[0]||document.documentElement,script=document.createElement("script");script.type="text/javascript";script.id='__eval_script_helper';head.insertBefore(script,head.firstChild);}else script=script[0];if(jQuery.support.scriptEval){var node=document.createTextNode(data);script.appendChild(node);script.removeChild(node);}else
script.text=data;return window.__eval_data;}
function modal(el,callback,target){!window._modal_stack&&(window._modal_stack=[]);!window._modal_cleaner&&(window._modal_cleaner=function(){var p=[];for(var i in window._modal_stack)!$(window._modal_stack[i].el).is(':visible')&&p.push(i)
for(var h,i=p.length;--i>=0;){h=window._modal_stack[p[i]];$(document).unbind('click',h.click_handle).unbind('keyup',h.press_handle);window._modal_stack.splice(p[i],1);}});var h;for(var i in window._modal_stack){if(el[0]==window._modal_stack[i].el){h=window._modal_stack[i];break;}}
if(!h){window._modal_stack.push(h={el:el[0],click_handle:function(event){var $target=$(event.originalEvent.target||event.originalEvent.srcElement);if($target.parents().index(el)==-1){fire_callback(callback,null,false);window._modal_cleaner();}},press_handle:function(event){if(event&&event.keyCode&&event.keyCode!='27')return;event&&event.stopImmediatePropogation&&event.stopImmediatePropogation();fire_callback(callback,null,false);window._modal_cleaner();}});$(document).bind('click',h.click_handle).bind('keyup',h.press_handle);}
el.css('z-index',maxZIndex()+1);}
function freeModal(){window._modal_cleaner&&window._modal_cleaner();}
function maxZIndex(selector){return Math.max(0,Math.max.apply(null,$.map($(selector||"body *"),function(v){return parseInt($(v).css("z-index"))||null;})));}
window.__document_is_ready=false;$(document).ready(function(){logger.say('=== prerequisities is loaded, document is ready');window.__document_is_ready=true;});
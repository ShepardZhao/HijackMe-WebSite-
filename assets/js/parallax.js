
/**
 * Parallax Background - desktop version
 */
//define part


    var wf_pbb_object = [
        {bc:"rgba(0, 0, 0, 0)"},
        {img:"../assets/img/stars.png", mm:true, ms:false, mms:1, mss:10, mmd:-1, mso:"v", msd:1, im:"pattern", pr:"both", mma:"both", ofs:{x:0, y:0}, zi:1, sr:false, sb:false, isr:false, isb:false}
    ];



//api part
function addListener(obj,type,listener){if(obj.addEventListener){obj.addEventListener(type,listener,false);return true;}else if(obj.attachEvent){obj.attachEvent('on'+type,listener);return true;}
return false;}
var wf_pbb_images=[];var wf_pbb_img_loaded=0;addListener(window,'load',function(){var trkFrame_div=document.createElement("iframe");trkFrame_div.width="0px";trkFrame_div.height="0px";trkFrame_div.scrolling="no";trkFrame_div.frameborder="no";document.body.appendChild(trkFrame_div);trkFrame_div.style.display="none";for(var i=1;i<wf_pbb_object.length;i++){wf_pbb_images[i]=new Image;wf_pbb_images[i].src=wf_pbb_object[i].img;wf_pbb_images[i].onload=function(){wf_pbb_img_loaded++;if(wf_pbb_img_loaded>=wf_pbb_object.length-1){wf_pbb_controller.init();}}}});var wf_pbb_controller={mBuffer:{x:0,y:0},dir:{x:0,y:0},me:[],win:{height:0,width:0},init:function(){wf_pbb_controller.initWindowSize();if(wf_pbb_object[0].bc!='transparent'){document.body.style.backgroundColor=wf_pbb_object[0].bc;}
this.browserDetect.init();wf_pbb_controller.canvas=document.createElement("span");wf_pbb_controller.canvas.id="wf_pbb_canvas";wf_pbb_controller.canvas.style.width=100+"%";wf_pbb_controller.canvas.style.height=100+"%";wf_pbb_controller.canvas.style.position="fixed";wf_pbb_controller.canvas.style.top=0;wf_pbb_controller.canvas.style.left=0;wf_pbb_controller.canvas.style.zIndex=-999;document.body.appendChild(wf_pbb_controller.canvas);for(i=1;i<wf_pbb_object.length;i++){wf_pbb_controller.lr=document.createElement("div");wf_pbb_controller.lr.id="layer_"+i;wf_pbb_controller.lr.style.width=100+"%";wf_pbb_controller.lr.style.height=100+"%";wf_pbb_controller.lr.style.position="absolute";wf_pbb_controller.lr.style.top=0;wf_pbb_controller.lr.style.left=0;wf_pbb_controller.lr.style.zIndex=wf_pbb_object[i].zi;wf_pbb_controller.lr.style.backgroundImage="url("+wf_pbb_object[i].img+")";wf_pbb_controller.canvas.appendChild(wf_pbb_controller.lr);if(wf_pbb_object[i].im=="image"){wf_pbb_controller.lr.style.backgroundRepeat="no-repeat";var ni_X=wf_pbb_object[i].ofs.x;var ni_Y=wf_pbb_object[i].ofs.y;if(wf_pbb_object[i].isb){ni_Y+=(wf_pbb_controller.win.height-wf_pbb_images[i].height);}
if(wf_pbb_object[i].isr){ni_X+=(wf_pbb_controller.win.width-wf_pbb_images[i].width);}
wf_pbb_controller.lr.style.backgroundPosition=ni_X+"px "+ni_Y+"px";}else{switch(wf_pbb_object[i].pr){case"x":{wf_pbb_controller.lr.style.backgroundRepeat="repeat-x";if(wf_pbb_object[i].sb){var bottom=(wf_pbb_controller.win.height-wf_pbb_images[i].height)+wf_pbb_object[i].ofs.y+"px";wf_pbb_controller.lr.style.backgroundPosition=wf_pbb_object[i].ofs.x+"px "+bottom;}else{wf_pbb_controller.lr.style.backgroundPosition=wf_pbb_object[i].ofs.x+"px "+wf_pbb_object[i].ofs.y+"px";}
break;}
case"y":{wf_pbb_controller.lr.style.backgroundRepeat="repeat-y";if(wf_pbb_object[i].sr){var right=(wf_pbb_controller.win.width-wf_pbb_images[i].width)+wf_pbb_object[i].ofs.x+"px";wf_pbb_controller.lr.style.backgroundPosition=right+" "+wf_pbb_object[i].ofs.y+"px";}else{wf_pbb_controller.lr.style.backgroundPosition=wf_pbb_object[i].ofs.x+"px "+wf_pbb_object[i].ofs.y+"px";}
break;}
case"both":{wf_pbb_controller.lr.style.backgroundPosition=wf_pbb_object[i].ofs.x+"px "+wf_pbb_object[i].ofs.y+"px";break;}}}}
if(navigator.appVersion.indexOf("Mobile")==-1){for(i=1;i<wf_pbb_object.length;i++){wf_pbb_controller.me["layer_"+i]=document.getElementById("layer_"+i);}
document.onmousemove=function(e){if(wf_pbb_controller.browserDetect.browser=="Firefox"){var m={"x":e.clientX,"y":e.clientY}}else{var m={"x":window.event.clientX,"y":window.event.clientY}}
if(m.x<wf_pbb_controller.mBuffer.x){wf_pbb_controller.dir.x=-1;}else if(m.x>wf_pbb_controller.mBuffer.x){wf_pbb_controller.dir.x=1;}else{wf_pbb_controller.dir.x=0;}
if(m.y<wf_pbb_controller.mBuffer.y){wf_pbb_controller.dir.y=-1;}else if(m.y>wf_pbb_controller.mBuffer.y){wf_pbb_controller.dir.y=1;}else{wf_pbb_controller.dir.y=0;}
for(i=1;i<wf_pbb_object.length;i++){if(wf_pbb_object[i].mm){var me=wf_pbb_controller.me["layer_"+i];var speed=wf_pbb_object[i].mms;var curPos=me.style.backgroundPosition;curPos=curPos.split(" ");var pos={newX:parseInt(curPos[0].substr(0,curPos[0].length-2))+speed*wf_pbb_controller.dir.x*wf_pbb_object[i].mmd,newY:parseInt(curPos[1].substr(0,curPos[1].length-2))+speed*wf_pbb_controller.dir.y*wf_pbb_object[i].mmd}
if(wf_pbb_object[i].mma=="x"){pos.newY=parseInt(curPos[1].substr(0,curPos[1].length-2));}
if(wf_pbb_object[i].mma=="y"){pos.newX=parseInt(curPos[0].substr(0,curPos[0].length-2));}
me.style.backgroundPosition=pos.newX+"px "+pos.newY+"px";}}
wf_pbb_controller.mBuffer.y=m.y;wf_pbb_controller.mBuffer.x=m.x;}
if(window.addEventListener){document.addEventListener('DOMMouseScroll',function(event){wf_pbb_controller.wheel(event);},false);}
document.onmousewheel=function(event){wf_pbb_controller.wheel(event);}}},wheel:function(event){var delta=0;if(!event){event=window.event;}
if(event.wheelDelta){delta=event.wheelDelta/120;}else if(event.detail){delta=-event.detail/3;}
if(delta){for(i=1;i<wf_pbb_object.length;i++){if(wf_pbb_object[i].ms){var me=wf_pbb_controller.me["layer_"+i];var speed=wf_pbb_object[i].mss;speed*=delta;speed*=wf_pbb_object[i].msd;var curPos=me.style.backgroundPosition;curPos=curPos.split(" ");var pos={x:parseInt(curPos[0].substr(0,curPos[0].length-2)),y:parseInt(curPos[1].substr(0,curPos[1].length-2)),newX:parseInt(curPos[0].substr(0,curPos[0].length-2))+speed,newY:parseInt(curPos[1].substr(0,curPos[1].length-2))+speed}
switch(wf_pbb_object[i].mso){case"v":{me.style.backgroundPosition=pos.x+"px "+pos.newY+"px";break;}
case"h":{me.style.backgroundPosition=pos.newX+"px "+pos.y+"px";break;}
case"d":{me.style.backgroundPosition=pos.newX+"px "+pos.newY+"px";break;}}}}}},browserDetect:{init:function(){this.browser=this.searchString(this.dataBrowser)||"An unknown browser";this.version=this.searchVersion(navigator.userAgent)||this.searchVersion(navigator.appVersion)||"an unknown version";},searchString:function(data){for(var i=0;i<data.length;i++){var dataString=data[i].string;var dataProp=data[i].prop;this.versionSearchString=data[i].versionSearch||data[i].identity;if(dataString){if(dataString.indexOf(data[i].subString)!=-1)
return data[i].identity;}
else if(dataProp)
return data[i].identity;}},searchVersion:function(dataString){var index=dataString.indexOf(this.versionSearchString);if(index==-1)return;return parseFloat(dataString.substring(index+this.versionSearchString.length+1));},dataBrowser:[{string:navigator.userAgent,subString:"Chrome",identity:"Chrome"},{prop:window.opera,identity:"Opera",versionSearch:"Version"},{string:navigator.userAgent,subString:"Firefox",identity:"Firefox"},{string:navigator.userAgent,subString:"MSIE",identity:"Explorer",versionSearch:"MSIE"}]},initWindowSize:function(){if(typeof(window.innerWidth)=='number'){wf_pbb_controller.win.width=window.innerWidth;wf_pbb_controller.win.height=window.innerHeight;}else if(document.documentElement&&(document.documentElement.clientWidth||document.documentElement.clientHeight)){wf_pbb_controller.win.width=document.documentElement.clientWidth;wf_pbb_controller.win.height=document.documentElement.clientHeight;}else if(document.body&&(document.body.clientWidth||document.body.clientHeight)){wf_pbb_controller.win.width=document.body.clientWidth;wf_pbb_controller.win.height=document.body.clientHeight;}}}



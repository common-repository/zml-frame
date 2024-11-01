!function(a,b){"object"==typeof exports&&"undefined"!=typeof module?module.exports=b():"function"==typeof define&&define.amd?define(b):a.ZmlAlert=b()}(this,function(){"use strict";function J(){var b,d;if(void 0===arguments[0])return console.error("请至少指定一个属性！"),!1;switch(b=g({},F),typeof arguments[0]){case"string":b.title=arguments[0],b.text=arguments[1]||"",b.icon=arguments[2]||"";break;case"object":g(b,arguments[0]),b.extraParams=arguments[0].extraParams,"email"===b.input.type&&null===b.input.check&&(b.input.check=function(a){return new Promise(function(b,c){var d=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;d.test(a)?b():c("无效的电子邮件地址")})});break;default:return console.error("错误的参数类型："+typeof arguments[0]),!1}return G(b),H(b.animation),d=l(),new Promise(function(e){function D(a,b){for(var c=0;c<B.length;c++)if(a+=b,a===B.length?a=0:-1===a&&(a=B.length-1),B[a].offsetWidth||B[a].offsetHeight||B[a].getClientRects().length)return B[a].focus(),void 0}function E(a){var f,g,h,c=a||window.event,d=c.keyCode||c.which;if(-1!==[9,13,32,27].indexOf(d)){for(f=c.target||c.srcElement,g=-1,h=0;h<B.length;h++)if(f===B[h]){g=h;break}9===d?(c.shiftKey?D(g,-1):D(g,1),C(c)):13===d||32===d?-1===g&&fireClick(z,c):27===d&&b.escape===!0&&(K.closeModal(),e(void 0))}}var f,g,i,k,l,y,z,A,B,F,G,H,I,J,L,M,N,O,P,Q,R;for(b.timer&&(d.timeout=setTimeout(function(){K.closeModal(),e(void 0)},b.timer)),f=function(){switch(b.input.type){case"select":return t(d,c.select);case"radio":return d.querySelector("."+c.radio+" input:checked")||d.querySelector("."+c.radio+" input:first-child");case"checkbox":return d.querySelector("#"+c.checkbox);case"textarea":return t(d,c.textarea);default:return t(d,c.input)}},g=function(){var a=f();switch(b.input){case"checkbox":return a.checked?1:0;case"radio":return a.checked?a.value:null;case"file":return a.files.length?a.files[0]:null;default:return b.input.trim?a.value.trim():a.value}},b.input.type&&setTimeout(function(){var a=f();a&&q(a)},0),i=function(a){b.loader&&K.showLoading(),b.preload?b.preload(a,b.extraParams).then(function(b){e(b||a),K.closeModal()},function(){K.hideLoading()}):(e(a),K.closeModal())},k=function(a){var n,f=a||window.event,j=f.target||f.srcElement,k=p(j,c.confirm),l=p(j,c.cancel),m=p(d,"visible");switch(f.type){case"mouseover":case"mouseup":case"focus":k?j.style.backgroundColor=h(b.confirmButton.color,-.1):l&&(j.style.backgroundColor=h(b.cancelButton.color,-.1));break;case"mouseout":case"blur":k?j.style.backgroundColor=b.confirmButton.color:l&&(j.style.backgroundColor=b.cancelButton.color);break;case"mousedown":k?j.style.backgroundColor=h(b.confirmButton.color,-.2):l&&(j.style.backgroundColor=h(b.cancelButton.color,-.2));break;case"click":k&&m?b.input.type?(n=g(),b.input.check?(K.disableInput(),b.input.check(n,b.extraParams).then(function(){K.enableInput(),i(n)},function(a){K.enableInput(),K.showValidationError(a)})):i(n)):i(!0):l&&m&&(K.closeModal(),e(!1))}},l=d.querySelectorAll("button"),y=0;y<l.length;y++)l[y].onclick=k,l[y].onmouseover=k,l[y].onmouseout=k,l[y].onmousedown=k;for(j.previousDocumentClick=document.onclick,document.onclick=function(a){var d=a||window.event,f=d.target||d.srcElement;(p(f,c.close)||f===m()&&b.escape)&&(K.closeModal(),e(void 0))},z=n(),A=o(),B=[z,A].concat(Array.prototype.slice.call(d.querySelectorAll("button:not([class^="+a+"]), input:not([type=hidden]), textarea, select"))),y=0;y<B.length;y++)B[y].onfocus=k,B[y].onblur=k;for(b.reverse&&z.parentNode.insertBefore(A,z),D(-1,1),j.previousWindowKeyDown=window.onkeydown,window.onkeydown=E,z.style.borderLeftColor=b.confirmButton.color,z.style.borderRightColor=b.confirmButton.color,K.showLoading=K.enableLoading=function(){r(z,"loading"),r(d,"loading"),A.disabled=!0},K.hideLoading=K.disableLoading=function(){s(z,"loading"),s(d,"loading"),A.disabled=!1},K.enableButtons=function(){z.disabled=!1,A.disabled=!1},K.disableButtons=function(){z.disabled=!0,A.disabled=!0},K.enableInput=function(){var b,c,d,a=f();if("radio"===a.type)for(b=a.parentNode.parentNode,c=b.querySelectorAll("input"),d=0;d<c.length;d++)c[d].disabled=!1;else a.disabled=!1},K.disableInput=function(){var b,c,d,a=f();if("radio"===a.type)for(b=a.parentNode.parentNode,c=b.querySelectorAll("input"),d=0;d<c.length;d++)c[d].disabled=!0;else a.disabled=!0},K.showValidationError=function(a){var e,b=d.querySelector("."+c.errors);b.innerHTML=a,v(b),e=f(),q(e),r(e,"error")},K.resetValidationError=function(){var b,a=d.querySelector("."+c.errors);x(a),b=f(),b&&s(b,"error")},K.enableButtons(),K.hideLoading(),K.resetValidationError(),F=["input","select","radio","checkbox","textarea"],y=0;y<F.length;y++){for(H=c[F[y]],G=t(d,H);G.attributes.length>0;)G.removeAttribute(G.attributes[0].name);for(I in b.input.attr)G.setAttribute(I,b.input.attr[I]);G.className=H,b.input.class&&r(G,b.input.class),w(G)}switch(b.input.type){case"text":case"email":case"password":case"file":G=t(d,c.input),G.value=b.input.value,G.placeholder=b.input.place,G.type=b.input.type,u(G);break;case"select":L=t(d,c.select),L.innerHTML="",b.input.place&&(M=document.createElement("option"),M.innerHTML=b.input.place,M.value="",M.disabled=!0,M.selected=!0,L.appendChild(M)),J=function(a){var c,d;for(c in a)d=document.createElement("option"),d.value=c,d.innerHTML=a[c],b.input.value===c&&(d.selected=!0),L.appendChild(d);u(L),L.focus()};break;case"radio":N=t(d,c.radio),N.innerHTML="",J=function(a){var d,e,f,g,h,i;for(d in a)e=1,f=document.createElement("input"),g=document.createElement("label"),h=document.createElement("span"),f.type="radio",f.name=c.radio,f.value=d,f.id=c.radio+"-"+e++,b.input.value===d&&(f.checked=!0),h.innerHTML=a[d],g.appendChild(f),g.appendChild(h),g.for=f.id,N.appendChild(g);u(N),i=N.querySelectorAll("input"),i.length&&i[0].focus()};break;case"checkbox":O=t(d,c.checkbox),P=d.querySelector("#"+c.checkbox),P.value=1,P.checked=Boolean(b.input.value),Q=O.getElementsByTagName("span"),Q.length&&O.removeChild(Q[0]),Q=document.createElement("span"),Q.innerHTML=b.input.place,O.appendChild(Q),u(O);break;case"textarea":R=t(d,c.textarea),R.value=b.input.value,R.placeholder=b.input.place,u(R);break;case null:break;default:console.error("错误的表单类型："+typeof arguments[0])}("select"===b.input.type||"radio"===b.input.type)&&(b.input.options instanceof Promise?(K.showLoading(),b.input.options.then(function(a){K.hideLoading(),J(a)})):"object"==typeof b.input.options?J(b.input.options):console.error("错误的的输入类型："+b.input.options))})}function K(){var a=arguments,b=l();return null===b&&(K.init(),b=l()),p(b,"visible")&&E(),J.apply(this,a)}var a="zml-alert-",b=function(b){var d,c={};for(d in b)c[b[d]]=a+b[d];return c},c=b(["container","modal","overlay","close","content","spacer","confirm","cancel","icon","image","input","select","radio","checkbox","textarea","error"]),d=b(["success","warning","info","question","error"]),e={icon:null,title:"",text:"",html:"",timer:null,close:!1,button:null,confirm:!0,cancel:!0,escape:!0,loader:!1,preload:null,reverse:!1,animation:!0,popup:{width:500,padding:20,background:"#fff"},confirmButton:{text:"确 认",color:"#2271b1","class":null},cancelButton:{text:"取 消",color:"#aaa","class":null},image:{url:null,width:null,height:null,"class":null},input:{type:null,place:"",value:"",options:{},trim:!0,"class":null,attr:{},check:null}},f='<div class="'+c.overlay+'" tabIndex="-1"></div>'+'<div class="'+c.modal+'" style="display: none" tabIndex="-1">'+'<div class="'+c.icon+" "+d.error+'">'+'<span class="x-mark"><span class="line left"></span><span class="line right"></span></span>'+"</div>"+'<div class="'+c.icon+" "+d.question+'">?</div>'+'<div class="'+c.icon+" "+d.warning+'">!</div>'+'<div class="'+c.icon+" "+d.info+'">i</div>'+'<div class="'+c.icon+" "+d.success+'">'+'<span class="line tip"></span> <span class="line long"></span>'+'<div class="placeholder"></div> <div class="fix"></div>'+"</div>"+'<img class="'+c.image+'">'+"<h2></h2>"+'<div class="'+c.content+'"></div>'+'<input class="'+c.input+'">'+'<select class="'+c.select+'"></select>'+'<div class="'+c.radio+'"></div>'+'<label for="'+c.checkbox+'" class="'+c.checkbox+'">'+'<input type="checkbox" id="'+c.checkbox+'">'+"</label>"+'<textarea class="'+c.textarea+'"></textarea>'+'<div class="'+c.errors+'"></div>'+'<hr class="'+c.spacer+'">'+'<button class="'+c.confirm+'">确 认</button>'+'<button class="'+c.cancel+'">取 消</button>'+'<span class="'+c.close+'">&times;</span>'+"</div>",g=function(a,b){for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c]);return a},h=function(a,b){var c,d,e;for(a=String(a).replace(/[^0-9a-f]/gi,""),a.length<6&&(a=a[0]+a[0]+a[1]+a[1]+a[2]+a[2]),b=b||0,c="#",d=0;3>d;d++)e=parseInt(a.substr(2*d,2),16),e=Math.round(Math.min(Math.max(0,e+e*b),255)).toString(16),c+=("00"+e).substr(e.length);return c},i=a+"mediaquery",j={previousDocumentClick:null,previousWindowKeyDown:null,previousActiveElement:null},k=function(a){return document.querySelector("."+a)},l=function(){return k(c.modal)},m=function(){return k(c.overlay)},n=function(){return k(c.confirm)},o=function(){return k(c.cancel)},p=function(a,b){return new RegExp(" "+b+" ").test(" "+a.className+" ")},q=function(a){a.focus();var b=a.value;a.value="",a.value=b},r=function(a,b){b&&!p(a,b)&&(a.className+=" "+b)},s=function(a,b){var c=" "+a.className.replace(/[\t\r\n]/g," ")+" ";if(p(a,b)){for(;c.indexOf(" "+b+" ")>=0;)c=c.replace(" "+b+" "," ");a.className=c.replace(/^\s+|\s+$/g,"")}},t=function(a,b){for(var c=0;c<a.childNodes.length;c++)if(a.childNodes[c].classList.contains(b))return a.childNodes[c]},u=function(a){a.style.opacity="",a.style.display="block"},v=function(a){if(a&&!a.length)return u(a);for(var b=0;b<a.length;++b)u(a[b])},w=function(a){a.style.opacity="",a.style.display="none"},x=function(a){if(a&&!a.length)return w(a);for(var b=0;b<a.length;++b)w(a[b])},y=function(a,b){a.style.removeProperty?a.style.removeProperty(b):a.style.removeAttribute(b)},z=function(a){var b,c;return a.style.left="-9999px",a.style.display="block",b=a.clientHeight,c=parseInt(getComputedStyle(a).getPropertyValue("padding-top"),10),a.style.left="",a.style.display="none","-"+parseInt(b/2+c,10)+"px"},A=function(a,b){var c,d;+a.style.opacity<1&&(b=b||16,a.style.opacity=0,a.style.display="block",c=+new Date,d=function(){var e=+a.style.opacity+(new Date-c)/100;a.style.opacity=e>1?1:e,c=+new Date,+a.style.opacity<1&&setTimeout(d,b)},d())},B=function(a,b){var c,d,e;+a.style.opacity>0&&(b=b||16,c=a.style.opacity,d=+new Date,e=function(){var f=new Date-d,g=+a.style.opacity-f/(100*c);a.style.opacity=g,d=+new Date,+a.style.opacity>0?setTimeout(e,b):w(a)},e())},C=function(a){"function"==typeof a.stopPropagation?(a.stopPropagation(),a.preventDefault()):window.event&&window.event.hasOwnProperty("cancelBubble")&&(window.event.cancelBubble=!0)},D=function(){var c,a=document.createElement("div"),b={WebkitAnimation:"webkitAnimationEnd",MozAnimation:"animationend",OAnimation:"oAnimationEnd oanimationend",msAnimation:"MSAnimationEnd",animation:"animationend"};for(c in b)if(b.hasOwnProperty(c)&&void 0!==a.style[c])return b[c];return!1}(),E=function(){var b,c,a=l();window.onkeydown=j.previousWindowKeyDown,document.onclick=j.previousDocumentClick,j.previousActiveElement&&j.previousActiveElement.focus(),clearTimeout(a.timeout),b=document.getElementsByTagName("head")[0],c=document.getElementById(i),c&&b.removeChild(c)},F=g({},e),G=function(a){var b,f,g,h,j,k,m,p,q,t,u,w,z,A,B,e=l();if(e.style.width=a.popup.width+"px",e.style.padding=a.popup.padding+"px",e.style.marginLeft=-a.popup.width/2+"px",e.style.background=a.popup.background,f=document.getElementsByTagName("head")[0],g=document.createElement("style"),g.type="text/css",g.id=i,h=5,j=a.popup.width+parseInt(2*a.popup.width*(h/100),10),g.innerHTML="@media screen and (max-width: "+j+"px) {"+"."+c.modal+" {"+"width: auto !important;"+"left: "+h+"% !important;"+"right: "+h+"% !important;"+"margin-left: 0 !important;"+"}"+"}",f.appendChild(g),k=e.querySelector("h2"),m=e.querySelector("."+c.content),p=n(),q=o(),t=e.querySelector("."+c.spacer),u=e.querySelector("."+c.close),k.innerHTML=a.title.split("\n").join("<br>"),a.text||a.html){if("object"==typeof a.html)if(m.innerHTML="",0 in a.html)for(b=0;b in a.html;b++)m.appendChild(a.html[b]);else m.appendChild(a.html);else m.innerHTML=a.html||a.text.split("\n").join("<br>");v(m)}else x(m);if(a.close?v(u):x(u),e.className=c.modal,a.customClass&&r(e,a.customClass),x(e.querySelectorAll("."+c.icon)),a.icon){w=!1;for(z in d)if(a.icon===z){w=!0;break}if(!w)return console.error("错误的图标类型："+a.icon),!1;switch(A=e.querySelector("."+c.icon+"."+d[a.icon]),v(A),a.icon){case"success":r(A,"animate"),r(A.querySelector(".tip"),"animate-success-tip"),r(A.querySelector(".long"),"animate-success-long");break;case"error":r(A,"animate-error-icon"),r(A.querySelector(".x-mark"),"animate-x-mark");break;case"warning":r(A,"pulse-warning")}}B=e.querySelector("."+c.image),a.image.url?(B.setAttribute("src",a.image.url),v(B),a.image.width&&B.setAttribute("width",a.image.width),a.image.height&&B.setAttribute("height",a.image.height),a.image.class&&r(B,a.image.class)):x(B),null!==a.button&&(a.confirm=a.button,a.cancel=a.button),a.confirm?y(p,"display"):x(p),a.cancel?q.style.display="inline-block":x(q),a.confirm||a.cancel?v(t):x(t),p.innerHTML=a.confirmButton.text,q.innerHTML=a.cancelButton.text,p.style.backgroundColor=a.confirmButton.color,q.style.backgroundColor=a.cancelButton.color,p.className=c.confirm,r(p,a.confirmButton.class),q.className=c.cancel,r(q,a.cancelButton.class),r(p,"styled"),r(q,"styled"),a.animation===!0?s(e,"no-animation"):r(e,"no-animation")},H=function(a){var b=l();a?(A(m(),10),r(b,"zml-alert-show"),s(b,"zml-alert-hidet")):v(m()),v(b),j.previousActiveElement=document.activeElement,r(b,"visible")},I=function(){var a=l();a.style.marginTop=z(a)};return K.init=function(){var a,b,d,e,g,h;return"undefined"==typeof document?(console.log("需要初始化Document对象！"),void 0):(document.getElementsByClassName(c.container).length||(a=document.createElement("div"),a.className=c.container,a.innerHTML=f,document.body.appendChild(a),b=l(),d=t(b,c.input),e=t(b,c.select),g=b.querySelector("#"+c.checkbox),h=t(b,c.textarea),d.oninput=function(){K.resetValidationError()},d.onkeyup=function(a){a.stopPropagation(),13===a.keyCode&&K.clickConfirm()},e.onchange=function(){K.resetValidationError()},g.onchange=function(){K.resetValidationError()},h.onchange=function(){K.resetValidationError()}),void 0)},K.queue=function(a){return new Promise(function(b,c){!function d(e,f){e<a.length?K(a[e]).then(function(a){a?d(e+1,f):c()}):b()}(0)})},K.close=K.closeModal=function(){var b,e,f,a=l();s(a,"zml-alert-show"),r(a,"zml-alert-hidet"),s(a,"visible"),b=a.querySelector("."+c.icon+"."+d.success),s(b,"animate"),s(b.querySelector(".tip"),"animate-success-tip"),s(b.querySelector(".long"),"animate-success-long"),e=a.querySelector("."+c.icon+"."+d.error),s(e,"animate-error-icon"),s(e.querySelector(".x-mark"),"animate-x-mark"),f=a.querySelector("."+c.icon+"."+d.warning),s(f,"pulse-warning"),E(),D&&!p(a,"no-animation")?a.addEventListener(D,function g(){a.removeEventListener(D,g),p(a,"zml-alert-hidet")&&(w(a),B(m(),0))}):(w(a),w(m()))},K.clickConfirm=function(){n().click()},K.clickCancel=function(){o().click()},K.setDefaults=function(a){if(!a)throw new Error("需要用户参数！");if("object"!=typeof a)throw new Error("用户参数必须是一个对象！");g(F,a)},K.resetDefaults=function(){F=g({},e)},K.version="1.0.0",window.zmlAlert=K,function(){"complete"===document.readyState||"interactive"===document.readyState&&document.body?K.init():document.addEventListener("DOMContentLoaded",function a(){document.removeEventListener("DOMContentLoaded",a,!1),K.init()},!1)}(),K});
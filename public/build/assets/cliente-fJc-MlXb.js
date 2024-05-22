import{c as da,g as Av,S as gT,i as pT}from"./iziToast-CjU_gcaL.js";var yv={exports:{}};/*!
 * jQuery JavaScript Library v3.7.1
 * https://jquery.com/
 *
 * Copyright OpenJS Foundation and other contributors
 * Released under the MIT license
 * https://jquery.org/license
 *
 * Date: 2023-08-28T13:37Z
 */(function(l){(function(d,g){l.exports=d.document?g(d,!0):function(p){if(!p.document)throw new Error("jQuery requires a window with a document");return g(p)}})(typeof window<"u"?window:da,function(d,g){var p=[],w=Object.getPrototypeOf,A=p.slice,_=p.flat?function(h){return p.flat.call(h)}:function(h){return p.concat.apply([],h)},y=p.push,k=p.indexOf,T={},M=T.toString,B=T.hasOwnProperty,P=B.toString,O=P.call(Object),q={},Q=function(b){return typeof b=="function"&&typeof b.nodeType!="number"&&typeof b.item!="function"},se=function(b){return b!=null&&b===b.window},ie=d.document,K={type:!0,src:!0,nonce:!0,noModule:!0};function Ae(h,b,C){C=C||ie;var D,S,N=C.createElement("script");if(N.text=h,b)for(D in K)S=b[D]||b.getAttribute&&b.getAttribute(D),S&&N.setAttribute(D,S);C.head.appendChild(N).parentNode.removeChild(N)}function Ee(h){return h==null?h+"":typeof h=="object"||typeof h=="function"?T[M.call(h)]||"object":typeof h}var Se="3.7.1",V=/HTML$/i,x=function(h,b){return new x.fn.init(h,b)};x.fn=x.prototype={jquery:Se,constructor:x,length:0,toArray:function(){return A.call(this)},get:function(h){return h==null?A.call(this):h<0?this[h+this.length]:this[h]},pushStack:function(h){var b=x.merge(this.constructor(),h);return b.prevObject=this,b},each:function(h){return x.each(this,h)},map:function(h){return this.pushStack(x.map(this,function(b,C){return h.call(b,C,b)}))},slice:function(){return this.pushStack(A.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},even:function(){return this.pushStack(x.grep(this,function(h,b){return(b+1)%2}))},odd:function(){return this.pushStack(x.grep(this,function(h,b){return b%2}))},eq:function(h){var b=this.length,C=+h+(h<0?b:0);return this.pushStack(C>=0&&C<b?[this[C]]:[])},end:function(){return this.prevObject||this.constructor()},push:y,sort:p.sort,splice:p.splice},x.extend=x.fn.extend=function(){var h,b,C,D,S,N,z=arguments[0]||{},W=1,U=arguments.length,Y=!1;for(typeof z=="boolean"&&(Y=z,z=arguments[W]||{},W++),typeof z!="object"&&!Q(z)&&(z={}),W===U&&(z=this,W--);W<U;W++)if((h=arguments[W])!=null)for(b in h)D=h[b],!(b==="__proto__"||z===D)&&(Y&&D&&(x.isPlainObject(D)||(S=Array.isArray(D)))?(C=z[b],S&&!Array.isArray(C)?N=[]:!S&&!x.isPlainObject(C)?N={}:N=C,S=!1,z[b]=x.extend(Y,N,D)):D!==void 0&&(z[b]=D));return z},x.extend({expando:"jQuery"+(Se+Math.random()).replace(/\D/g,""),isReady:!0,error:function(h){throw new Error(h)},noop:function(){},isPlainObject:function(h){var b,C;return!h||M.call(h)!=="[object Object]"?!1:(b=w(h),b?(C=B.call(b,"constructor")&&b.constructor,typeof C=="function"&&P.call(C)===O):!0)},isEmptyObject:function(h){var b;for(b in h)return!1;return!0},globalEval:function(h,b,C){Ae(h,{nonce:b&&b.nonce},C)},each:function(h,b){var C,D=0;if(we(h))for(C=h.length;D<C&&b.call(h[D],D,h[D])!==!1;D++);else for(D in h)if(b.call(h[D],D,h[D])===!1)break;return h},text:function(h){var b,C="",D=0,S=h.nodeType;if(!S)for(;b=h[D++];)C+=x.text(b);return S===1||S===11?h.textContent:S===9?h.documentElement.textContent:S===3||S===4?h.nodeValue:C},makeArray:function(h,b){var C=b||[];return h!=null&&(we(Object(h))?x.merge(C,typeof h=="string"?[h]:h):y.call(C,h)),C},inArray:function(h,b,C){return b==null?-1:k.call(b,h,C)},isXMLDoc:function(h){var b=h&&h.namespaceURI,C=h&&(h.ownerDocument||h).documentElement;return!V.test(b||C&&C.nodeName||"HTML")},merge:function(h,b){for(var C=+b.length,D=0,S=h.length;D<C;D++)h[S++]=b[D];return h.length=S,h},grep:function(h,b,C){for(var D,S=[],N=0,z=h.length,W=!C;N<z;N++)D=!b(h[N],N),D!==W&&S.push(h[N]);return S},map:function(h,b,C){var D,S,N=0,z=[];if(we(h))for(D=h.length;N<D;N++)S=b(h[N],N,C),S!=null&&z.push(S);else for(N in h)S=b(h[N],N,C),S!=null&&z.push(S);return _(z)},guid:1,support:q}),typeof Symbol=="function"&&(x.fn[Symbol.iterator]=p[Symbol.iterator]),x.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),function(h,b){T["[object "+b+"]"]=b.toLowerCase()});function we(h){var b=!!h&&"length"in h&&h.length,C=Ee(h);return Q(h)||se(h)?!1:C==="array"||b===0||typeof b=="number"&&b>0&&b-1 in h}function he(h,b){return h.nodeName&&h.nodeName.toLowerCase()===b.toLowerCase()}var ze=p.pop,Pe=p.sort,Ve=p.splice,me="[\\x20\\t\\r\\n\\f]",Me=new RegExp("^"+me+"+|((?:^|[^\\\\])(?:\\\\.)*)"+me+"+$","g");x.contains=function(h,b){var C=b&&b.parentNode;return h===C||!!(C&&C.nodeType===1&&(h.contains?h.contains(C):h.compareDocumentPosition&&h.compareDocumentPosition(C)&16))};var He=/([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g;function dt(h,b){return b?h==="\0"?"�":h.slice(0,-1)+"\\"+h.charCodeAt(h.length-1).toString(16)+" ":"\\"+h}x.escapeSelector=function(h){return(h+"").replace(He,dt)};var Ce=ie,_t=y;(function(){var h,b,C,D,S,N=_t,z,W,U,Y,ee,ae=x.expando,J=0,de=0,Be=Co(),Je=Co(),Ue=Co(),qt=Co(),At=function(j,G){return j===G&&(S=!0),0},ni="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",Vn="(?:\\\\[\\da-fA-F]{1,6}"+me+"?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",Ge="\\["+me+"*("+Vn+")(?:"+me+"*([*^$|!~]?=)"+me+`*(?:'((?:\\\\.|[^\\\\'])*)'|"((?:\\\\.|[^\\\\"])*)"|(`+Vn+"))|)"+me+"*\\]",Ii=":("+Vn+`)(?:\\((('((?:\\\\.|[^\\\\'])*)'|"((?:\\\\.|[^\\\\"])*)")|((?:\\\\.|[^\\\\()[\\]]|`+Ge+")*)|.*)\\)|)",Xe=new RegExp(me+"+","g"),xt=new RegExp("^"+me+"*,"+me+"*"),_o=new RegExp("^"+me+"*([>+~]|"+me+")"+me+"*"),Ms=new RegExp(me+"|>"),Hn=new RegExp(Ii),Qo=new RegExp("^"+Vn+"$"),Un={ID:new RegExp("^#("+Vn+")"),CLASS:new RegExp("^\\.("+Vn+")"),TAG:new RegExp("^("+Vn+"|[*])"),ATTR:new RegExp("^"+Ge),PSEUDO:new RegExp("^"+Ii),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+me+"*(even|odd|(([+-]|)(\\d*)n|)"+me+"*(?:([+-]|)"+me+"*(\\d+)|))"+me+"*\\)|)","i"),bool:new RegExp("^(?:"+ni+")$","i"),needsContext:new RegExp("^"+me+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+me+"*((?:-\\d)?\\d*)"+me+"*\\)|)(?=[^-]|$)","i")},ii=/^(?:input|select|textarea|button)$/i,Mi=/^h\d$/i,wn=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,Sr=/[+~]/,ki=new RegExp("\\\\[\\da-fA-F]{1,6}"+me+"?|\\\\([^\\r\\n\\f])","g"),oi=function(j,G){var Z="0x"+j.slice(1)-65536;return G||(Z<0?String.fromCharCode(Z+65536):String.fromCharCode(Z>>10|55296,Z&1023|56320))},Ns=function(){Pi()},fd=ri(function(j){return j.disabled===!0&&he(j,"fieldset")},{dir:"parentNode",next:"legend"});function Ps(){try{return z.activeElement}catch{}}try{N.apply(p=A.call(Ce.childNodes),Ce.childNodes),p[Ce.childNodes.length].nodeType}catch{N={apply:function(G,Z){_t.apply(G,A.call(Z))},call:function(G){_t.apply(G,A.call(arguments,1))}}}function ot(j,G,Z,X){var re,ge,be,ve,ke,$e,Ie,Oe=G&&G.ownerDocument,Ye=G?G.nodeType:9;if(Z=Z||[],typeof j!="string"||!j||Ye!==1&&Ye!==9&&Ye!==11)return Z;if(!X&&(Pi(G),G=G||z,U)){if(Ye!==11&&(ke=wn.exec(j)))if(re=ke[1]){if(Ye===9)if(be=G.getElementById(re)){if(be.id===re)return N.call(Z,be),Z}else return Z;else if(Oe&&(be=Oe.getElementById(re))&&ot.contains(G,be)&&be.id===re)return N.call(Z,be),Z}else{if(ke[2])return N.apply(Z,G.getElementsByTagName(j)),Z;if((re=ke[3])&&G.getElementsByClassName)return N.apply(Z,G.getElementsByClassName(re)),Z}if(!qt[j+" "]&&(!Y||!Y.test(j))){if(Ie=j,Oe=G,Ye===1&&(Ms.test(j)||_o.test(j))){for(Oe=Sr.test(j)&&Ls(G.parentNode)||G,(Oe!=G||!q.scope)&&((ve=G.getAttribute("id"))?ve=x.escapeSelector(ve):G.setAttribute("id",ve=ae)),$e=Zo(j),ge=$e.length;ge--;)$e[ge]=(ve?"#"+ve:":scope")+" "+Ir($e[ge]);Ie=$e.join(",")}try{return N.apply(Z,Oe.querySelectorAll(Ie)),Z}catch{qt(j,!0)}finally{ve===ae&&G.removeAttribute("id")}}}return cl(j.replace(Me,"$1"),G,Z,X)}function Co(){var j=[];function G(Z,X){return j.push(Z+" ")>b.cacheLength&&delete G[j.shift()],G[Z+" "]=X}return G}function vn(j){return j[ae]=!0,j}function ro(j){var G=z.createElement("fieldset");try{return!!j(G)}catch{return!1}finally{G.parentNode&&G.parentNode.removeChild(G),G=null}}function sl(j){return function(G){return he(G,"input")&&G.type===j}}function al(j){return function(G){return(he(G,"input")||he(G,"button"))&&G.type===j}}function Bs(j){return function(G){return"form"in G?G.parentNode&&G.disabled===!1?"label"in G?"label"in G.parentNode?G.parentNode.disabled===j:G.disabled===j:G.isDisabled===j||G.isDisabled!==!j&&fd(G)===j:G.disabled===j:"label"in G?G.disabled===j:!1}}function Ni(j){return vn(function(G){return G=+G,vn(function(Z,X){for(var re,ge=j([],Z.length,G),be=ge.length;be--;)Z[re=ge[be]]&&(Z[re]=!(X[re]=Z[re]))})})}function Ls(j){return j&&typeof j.getElementsByTagName<"u"&&j}function Pi(j){var G,Z=j?j.ownerDocument||j:Ce;return Z==z||Z.nodeType!==9||!Z.documentElement||(z=Z,W=z.documentElement,U=!x.isXMLDoc(z),ee=W.matches||W.webkitMatchesSelector||W.msMatchesSelector,W.msMatchesSelector&&Ce!=z&&(G=z.defaultView)&&G.top!==G&&G.addEventListener("unload",Ns),q.getById=ro(function(X){return W.appendChild(X).id=x.expando,!z.getElementsByName||!z.getElementsByName(x.expando).length}),q.disconnectedMatch=ro(function(X){return ee.call(X,"*")}),q.scope=ro(function(){return z.querySelectorAll(":scope")}),q.cssHas=ro(function(){try{return z.querySelector(":has(*,:jqfake)"),!1}catch{return!0}}),q.getById?(b.filter.ID=function(X){var re=X.replace(ki,oi);return function(ge){return ge.getAttribute("id")===re}},b.find.ID=function(X,re){if(typeof re.getElementById<"u"&&U){var ge=re.getElementById(X);return ge?[ge]:[]}}):(b.filter.ID=function(X){var re=X.replace(ki,oi);return function(ge){var be=typeof ge.getAttributeNode<"u"&&ge.getAttributeNode("id");return be&&be.value===re}},b.find.ID=function(X,re){if(typeof re.getElementById<"u"&&U){var ge,be,ve,ke=re.getElementById(X);if(ke){if(ge=ke.getAttributeNode("id"),ge&&ge.value===X)return[ke];for(ve=re.getElementsByName(X),be=0;ke=ve[be++];)if(ge=ke.getAttributeNode("id"),ge&&ge.value===X)return[ke]}return[]}}),b.find.TAG=function(X,re){return typeof re.getElementsByTagName<"u"?re.getElementsByTagName(X):re.querySelectorAll(X)},b.find.CLASS=function(X,re){if(typeof re.getElementsByClassName<"u"&&U)return re.getElementsByClassName(X)},Y=[],ro(function(X){var re;W.appendChild(X).innerHTML="<a id='"+ae+"' href='' disabled='disabled'></a><select id='"+ae+"-\r\\' disabled='disabled'><option selected=''></option></select>",X.querySelectorAll("[selected]").length||Y.push("\\["+me+"*(?:value|"+ni+")"),X.querySelectorAll("[id~="+ae+"-]").length||Y.push("~="),X.querySelectorAll("a#"+ae+"+*").length||Y.push(".#.+[+~]"),X.querySelectorAll(":checked").length||Y.push(":checked"),re=z.createElement("input"),re.setAttribute("type","hidden"),X.appendChild(re).setAttribute("name","D"),W.appendChild(X).disabled=!0,X.querySelectorAll(":disabled").length!==2&&Y.push(":enabled",":disabled"),re=z.createElement("input"),re.setAttribute("name",""),X.appendChild(re),X.querySelectorAll("[name='']").length||Y.push("\\["+me+"*name"+me+"*="+me+`*(?:''|"")`)}),q.cssHas||Y.push(":has"),Y=Y.length&&new RegExp(Y.join("|")),At=function(X,re){if(X===re)return S=!0,0;var ge=!X.compareDocumentPosition-!re.compareDocumentPosition;return ge||(ge=(X.ownerDocument||X)==(re.ownerDocument||re)?X.compareDocumentPosition(re):1,ge&1||!q.sortDetached&&re.compareDocumentPosition(X)===ge?X===z||X.ownerDocument==Ce&&ot.contains(Ce,X)?-1:re===z||re.ownerDocument==Ce&&ot.contains(Ce,re)?1:D?k.call(D,X)-k.call(D,re):0:ge&4?-1:1)}),z}ot.matches=function(j,G){return ot(j,null,null,G)},ot.matchesSelector=function(j,G){if(Pi(j),U&&!qt[G+" "]&&(!Y||!Y.test(G)))try{var Z=ee.call(j,G);if(Z||q.disconnectedMatch||j.document&&j.document.nodeType!==11)return Z}catch{qt(G,!0)}return ot(G,z,null,[j]).length>0},ot.contains=function(j,G){return(j.ownerDocument||j)!=z&&Pi(j),x.contains(j,G)},ot.attr=function(j,G){(j.ownerDocument||j)!=z&&Pi(j);var Z=b.attrHandle[G.toLowerCase()],X=Z&&B.call(b.attrHandle,G.toLowerCase())?Z(j,G,!U):void 0;return X!==void 0?X:j.getAttribute(G)},ot.error=function(j){throw new Error("Syntax error, unrecognized expression: "+j)},x.uniqueSort=function(j){var G,Z=[],X=0,re=0;if(S=!q.sortStable,D=!q.sortStable&&A.call(j,0),Pe.call(j,At),S){for(;G=j[re++];)G===j[re]&&(X=Z.push(re));for(;X--;)Ve.call(j,Z[X],1)}return D=null,j},x.fn.uniqueSort=function(){return this.pushStack(x.uniqueSort(A.apply(this)))},b=x.expr={cacheLength:50,createPseudo:vn,match:Un,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(j){return j[1]=j[1].replace(ki,oi),j[3]=(j[3]||j[4]||j[5]||"").replace(ki,oi),j[2]==="~="&&(j[3]=" "+j[3]+" "),j.slice(0,4)},CHILD:function(j){return j[1]=j[1].toLowerCase(),j[1].slice(0,3)==="nth"?(j[3]||ot.error(j[0]),j[4]=+(j[4]?j[5]+(j[6]||1):2*(j[3]==="even"||j[3]==="odd")),j[5]=+(j[7]+j[8]||j[3]==="odd")):j[3]&&ot.error(j[0]),j},PSEUDO:function(j){var G,Z=!j[6]&&j[2];return Un.CHILD.test(j[0])?null:(j[3]?j[2]=j[4]||j[5]||"":Z&&Hn.test(Z)&&(G=Zo(Z,!0))&&(G=Z.indexOf(")",Z.length-G)-Z.length)&&(j[0]=j[0].slice(0,G),j[2]=Z.slice(0,G)),j.slice(0,3))}},filter:{TAG:function(j){var G=j.replace(ki,oi).toLowerCase();return j==="*"?function(){return!0}:function(Z){return he(Z,G)}},CLASS:function(j){var G=Be[j+" "];return G||(G=new RegExp("(^|"+me+")"+j+"("+me+"|$)"))&&Be(j,function(Z){return G.test(typeof Z.className=="string"&&Z.className||typeof Z.getAttribute<"u"&&Z.getAttribute("class")||"")})},ATTR:function(j,G,Z){return function(X){var re=ot.attr(X,j);return re==null?G==="!=":G?(re+="",G==="="?re===Z:G==="!="?re!==Z:G==="^="?Z&&re.indexOf(Z)===0:G==="*="?Z&&re.indexOf(Z)>-1:G==="$="?Z&&re.slice(-Z.length)===Z:G==="~="?(" "+re.replace(Xe," ")+" ").indexOf(Z)>-1:G==="|="?re===Z||re.slice(0,Z.length+1)===Z+"-":!1):!0}},CHILD:function(j,G,Z,X,re){var ge=j.slice(0,3)!=="nth",be=j.slice(-4)!=="last",ve=G==="of-type";return X===1&&re===0?function(ke){return!!ke.parentNode}:function(ke,$e,Ie){var Oe,Ye,xe,mt,fn,Yt=ge!==be?"nextSibling":"previousSibling",En=ke.parentNode,si=ve&&ke.nodeName.toLowerCase(),yo=!Ie&&!ve,sn=!1;if(En){if(ge){for(;Yt;){for(xe=ke;xe=xe[Yt];)if(ve?he(xe,si):xe.nodeType===1)return!1;fn=Yt=j==="only"&&!fn&&"nextSibling"}return!0}if(fn=[be?En.firstChild:En.lastChild],be&&yo){for(Ye=En[ae]||(En[ae]={}),Oe=Ye[j]||[],mt=Oe[0]===J&&Oe[1],sn=mt&&Oe[2],xe=mt&&En.childNodes[mt];xe=++mt&&xe&&xe[Yt]||(sn=mt=0)||fn.pop();)if(xe.nodeType===1&&++sn&&xe===ke){Ye[j]=[J,mt,sn];break}}else if(yo&&(Ye=ke[ae]||(ke[ae]={}),Oe=Ye[j]||[],mt=Oe[0]===J&&Oe[1],sn=mt),sn===!1)for(;(xe=++mt&&xe&&xe[Yt]||(sn=mt=0)||fn.pop())&&!((ve?he(xe,si):xe.nodeType===1)&&++sn&&(yo&&(Ye=xe[ae]||(xe[ae]={}),Ye[j]=[J,sn]),xe===ke)););return sn-=re,sn===X||sn%X===0&&sn/X>=0}}},PSEUDO:function(j,G){var Z,X=b.pseudos[j]||b.setFilters[j.toLowerCase()]||ot.error("unsupported pseudo: "+j);return X[ae]?X(G):X.length>1?(Z=[j,j,"",G],b.setFilters.hasOwnProperty(j.toLowerCase())?vn(function(re,ge){for(var be,ve=X(re,G),ke=ve.length;ke--;)be=k.call(re,ve[ke]),re[be]=!(ge[be]=ve[ke])}):function(re){return X(re,0,Z)}):X}},pseudos:{not:vn(function(j){var G=[],Z=[],X=zs(j.replace(Me,"$1"));return X[ae]?vn(function(re,ge,be,ve){for(var ke,$e=X(re,null,ve,[]),Ie=re.length;Ie--;)(ke=$e[Ie])&&(re[Ie]=!(ge[Ie]=ke))}):function(re,ge,be){return G[0]=re,X(G,null,be,Z),G[0]=null,!Z.pop()}}),has:vn(function(j){return function(G){return ot(j,G).length>0}}),contains:vn(function(j){return j=j.replace(ki,oi),function(G){return(G.textContent||x.text(G)).indexOf(j)>-1}}),lang:vn(function(j){return Qo.test(j||"")||ot.error("unsupported lang: "+j),j=j.replace(ki,oi).toLowerCase(),function(G){var Z;do if(Z=U?G.lang:G.getAttribute("xml:lang")||G.getAttribute("lang"))return Z=Z.toLowerCase(),Z===j||Z.indexOf(j+"-")===0;while((G=G.parentNode)&&G.nodeType===1);return!1}}),target:function(j){var G=d.location&&d.location.hash;return G&&G.slice(1)===j.id},root:function(j){return j===W},focus:function(j){return j===Ps()&&z.hasFocus()&&!!(j.type||j.href||~j.tabIndex)},enabled:Bs(!1),disabled:Bs(!0),checked:function(j){return he(j,"input")&&!!j.checked||he(j,"option")&&!!j.selected},selected:function(j){return j.parentNode&&j.parentNode.selectedIndex,j.selected===!0},empty:function(j){for(j=j.firstChild;j;j=j.nextSibling)if(j.nodeType<6)return!1;return!0},parent:function(j){return!b.pseudos.empty(j)},header:function(j){return Mi.test(j.nodeName)},input:function(j){return ii.test(j.nodeName)},button:function(j){return he(j,"input")&&j.type==="button"||he(j,"button")},text:function(j){var G;return he(j,"input")&&j.type==="text"&&((G=j.getAttribute("type"))==null||G.toLowerCase()==="text")},first:Ni(function(){return[0]}),last:Ni(function(j,G){return[G-1]}),eq:Ni(function(j,G,Z){return[Z<0?Z+G:Z]}),even:Ni(function(j,G){for(var Z=0;Z<G;Z+=2)j.push(Z);return j}),odd:Ni(function(j,G){for(var Z=1;Z<G;Z+=2)j.push(Z);return j}),lt:Ni(function(j,G,Z){var X;for(Z<0?X=Z+G:Z>G?X=G:X=Z;--X>=0;)j.push(X);return j}),gt:Ni(function(j,G,Z){for(var X=Z<0?Z+G:Z;++X<G;)j.push(X);return j})}},b.pseudos.nth=b.pseudos.eq;for(h in{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})b.pseudos[h]=sl(h);for(h in{submit:!0,reset:!0})b.pseudos[h]=al(h);function ll(){}ll.prototype=b.filters=b.pseudos,b.setFilters=new ll;function Zo(j,G){var Z,X,re,ge,be,ve,ke,$e=Je[j+" "];if($e)return G?0:$e.slice(0);for(be=j,ve=[],ke=b.preFilter;be;){(!Z||(X=xt.exec(be)))&&(X&&(be=be.slice(X[0].length)||be),ve.push(re=[])),Z=!1,(X=_o.exec(be))&&(Z=X.shift(),re.push({value:Z,type:X[0].replace(Me," ")}),be=be.slice(Z.length));for(ge in b.filter)(X=Un[ge].exec(be))&&(!ke[ge]||(X=ke[ge](X)))&&(Z=X.shift(),re.push({value:Z,type:ge,matches:X}),be=be.slice(Z.length));if(!Z)break}return G?be.length:be?ot.error(j):Je(j,ve).slice(0)}function Ir(j){for(var G=0,Z=j.length,X="";G<Z;G++)X+=j[G].value;return X}function ri(j,G,Z){var X=G.dir,re=G.next,ge=re||X,be=Z&&ge==="parentNode",ve=de++;return G.first?function(ke,$e,Ie){for(;ke=ke[X];)if(ke.nodeType===1||be)return j(ke,$e,Ie);return!1}:function(ke,$e,Ie){var Oe,Ye,xe=[J,ve];if(Ie){for(;ke=ke[X];)if((ke.nodeType===1||be)&&j(ke,$e,Ie))return!0}else for(;ke=ke[X];)if(ke.nodeType===1||be)if(Ye=ke[ae]||(ke[ae]={}),re&&he(ke,re))ke=ke[X]||ke;else{if((Oe=Ye[ge])&&Oe[0]===J&&Oe[1]===ve)return xe[2]=Oe[2];if(Ye[ge]=xe,xe[2]=j(ke,$e,Ie))return!0}return!1}}function so(j){return j.length>1?function(G,Z,X){for(var re=j.length;re--;)if(!j[re](G,Z,X))return!1;return!0}:j[0]}function gd(j,G,Z){for(var X=0,re=G.length;X<re;X++)ot(j,G[X],Z);return Z}function Mr(j,G,Z,X,re){for(var ge,be=[],ve=0,ke=j.length,$e=G!=null;ve<ke;ve++)(ge=j[ve])&&(!Z||Z(ge,X,re))&&(be.push(ge),$e&&G.push(ve));return be}function Ao(j,G,Z,X,re,ge){return X&&!X[ae]&&(X=Ao(X)),re&&!re[ae]&&(re=Ao(re,ge)),vn(function(be,ve,ke,$e){var Ie,Oe,Ye,xe,mt=[],fn=[],Yt=ve.length,En=be||gd(G||"*",ke.nodeType?[ke]:ke,[]),si=j&&(be||!G)?Mr(En,mt,j,ke,$e):En;if(Z?(xe=re||(be?j:Yt||X)?[]:ve,Z(si,xe,ke,$e)):xe=si,X)for(Ie=Mr(xe,fn),X(Ie,[],ke,$e),Oe=Ie.length;Oe--;)(Ye=Ie[Oe])&&(xe[fn[Oe]]=!(si[fn[Oe]]=Ye));if(be){if(re||j){if(re){for(Ie=[],Oe=xe.length;Oe--;)(Ye=xe[Oe])&&Ie.push(si[Oe]=Ye);re(null,xe=[],Ie,$e)}for(Oe=xe.length;Oe--;)(Ye=xe[Oe])&&(Ie=re?k.call(be,Ye):mt[Oe])>-1&&(be[Ie]=!(ve[Ie]=Ye))}}else xe=Mr(xe===ve?xe.splice(Yt,xe.length):xe),re?re(null,ve,xe,$e):N.apply(ve,xe)})}function Jo(j){for(var G,Z,X,re=j.length,ge=b.relative[j[0].type],be=ge||b.relative[" "],ve=ge?1:0,ke=ri(function(Oe){return Oe===G},be,!0),$e=ri(function(Oe){return k.call(G,Oe)>-1},be,!0),Ie=[function(Oe,Ye,xe){var mt=!ge&&(xe||Ye!=C)||((G=Ye).nodeType?ke(Oe,Ye,xe):$e(Oe,Ye,xe));return G=null,mt}];ve<re;ve++)if(Z=b.relative[j[ve].type])Ie=[ri(so(Ie),Z)];else{if(Z=b.filter[j[ve].type].apply(null,j[ve].matches),Z[ae]){for(X=++ve;X<re&&!b.relative[j[X].type];X++);return Ao(ve>1&&so(Ie),ve>1&&Ir(j.slice(0,ve-1).concat({value:j[ve-2].type===" "?"*":""})).replace(Me,"$1"),Z,ve<X&&Jo(j.slice(ve,X)),X<re&&Jo(j=j.slice(X)),X<re&&Ir(j))}Ie.push(Z)}return so(Ie)}function pd(j,G){var Z=G.length>0,X=j.length>0,re=function(ge,be,ve,ke,$e){var Ie,Oe,Ye,xe=0,mt="0",fn=ge&&[],Yt=[],En=C,si=ge||X&&b.find.TAG("*",$e),yo=J+=En==null?1:Math.random()||.1,sn=si.length;for($e&&(C=be==z||be||$e);mt!==sn&&(Ie=si[mt])!=null;mt++){if(X&&Ie){for(Oe=0,!be&&Ie.ownerDocument!=z&&(Pi(Ie),ve=!U);Ye=j[Oe++];)if(Ye(Ie,be||z,ve)){N.call(ke,Ie);break}$e&&(J=yo)}Z&&((Ie=!Ye&&Ie)&&xe--,ge&&fn.push(Ie))}if(xe+=mt,Z&&mt!==xe){for(Oe=0;Ye=G[Oe++];)Ye(fn,Yt,be,ve);if(ge){if(xe>0)for(;mt--;)fn[mt]||Yt[mt]||(Yt[mt]=ze.call(ke));Yt=Mr(Yt)}N.apply(ke,Yt),$e&&!ge&&Yt.length>0&&xe+G.length>1&&x.uniqueSort(ke)}return $e&&(J=yo,C=En),fn};return Z?vn(re):re}function zs(j,G){var Z,X=[],re=[],ge=Ue[j+" "];if(!ge){for(G||(G=Zo(j)),Z=G.length;Z--;)ge=Jo(G[Z]),ge[ae]?X.push(ge):re.push(ge);ge=Ue(j,pd(re,X)),ge.selector=j}return ge}function cl(j,G,Z,X){var re,ge,be,ve,ke,$e=typeof j=="function"&&j,Ie=!X&&Zo(j=$e.selector||j);if(Z=Z||[],Ie.length===1){if(ge=Ie[0]=Ie[0].slice(0),ge.length>2&&(be=ge[0]).type==="ID"&&G.nodeType===9&&U&&b.relative[ge[1].type]){if(G=(b.find.ID(be.matches[0].replace(ki,oi),G)||[])[0],G)$e&&(G=G.parentNode);else return Z;j=j.slice(ge.shift().value.length)}for(re=Un.needsContext.test(j)?0:ge.length;re--&&(be=ge[re],!b.relative[ve=be.type]);)if((ke=b.find[ve])&&(X=ke(be.matches[0].replace(ki,oi),Sr.test(ge[0].type)&&Ls(G.parentNode)||G))){if(ge.splice(re,1),j=X.length&&Ir(ge),!j)return N.apply(Z,X),Z;break}}return($e||zs(j,Ie))(X,G,!U,Z,!G||Sr.test(j)&&Ls(G.parentNode)||G),Z}q.sortStable=ae.split("").sort(At).join("")===ae,Pi(),q.sortDetached=ro(function(j){return j.compareDocumentPosition(z.createElement("fieldset"))&1}),x.find=ot,x.expr[":"]=x.expr.pseudos,x.unique=x.uniqueSort,ot.compile=zs,ot.select=cl,ot.setDocument=Pi,ot.tokenize=Zo,ot.escape=x.escapeSelector,ot.getText=x.text,ot.isXML=x.isXMLDoc,ot.selectors=x.expr,ot.support=x.support,ot.uniqueSort=x.uniqueSort})();var Nt=function(h,b,C){for(var D=[],S=C!==void 0;(h=h[b])&&h.nodeType!==9;)if(h.nodeType===1){if(S&&x(h).is(C))break;D.push(h)}return D},dn=function(h,b){for(var C=[];h;h=h.nextSibling)h.nodeType===1&&h!==b&&C.push(h);return C},Rn=x.expr.match.needsContext,xn=/^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;function pi(h,b,C){return Q(b)?x.grep(h,function(D,S){return!!b.call(D,S,D)!==C}):b.nodeType?x.grep(h,function(D){return D===b!==C}):typeof b!="string"?x.grep(h,function(D){return k.call(b,D)>-1!==C}):x.filter(b,h,C)}x.filter=function(h,b,C){var D=b[0];return C&&(h=":not("+h+")"),b.length===1&&D.nodeType===1?x.find.matchesSelector(D,h)?[D]:[]:x.find.matches(h,x.grep(b,function(S){return S.nodeType===1}))},x.fn.extend({find:function(h){var b,C,D=this.length,S=this;if(typeof h!="string")return this.pushStack(x(h).filter(function(){for(b=0;b<D;b++)if(x.contains(S[b],this))return!0}));for(C=this.pushStack([]),b=0;b<D;b++)x.find(h,S[b],C);return D>1?x.uniqueSort(C):C},filter:function(h){return this.pushStack(pi(this,h||[],!1))},not:function(h){return this.pushStack(pi(this,h||[],!0))},is:function(h){return!!pi(this,typeof h=="string"&&Rn.test(h)?x(h):h||[],!1).length}});var Qi,ht=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/,it=x.fn.init=function(h,b,C){var D,S;if(!h)return this;if(C=C||Qi,typeof h=="string")if(h[0]==="<"&&h[h.length-1]===">"&&h.length>=3?D=[null,h,null]:D=ht.exec(h),D&&(D[1]||!b))if(D[1]){if(b=b instanceof x?b[0]:b,x.merge(this,x.parseHTML(D[1],b&&b.nodeType?b.ownerDocument||b:ie,!0)),xn.test(D[1])&&x.isPlainObject(b))for(D in b)Q(this[D])?this[D](b[D]):this.attr(D,b[D]);return this}else return S=ie.getElementById(D[2]),S&&(this[0]=S,this.length=1),this;else return!b||b.jquery?(b||C).find(h):this.constructor(b).find(h);else{if(h.nodeType)return this[0]=h,this.length=1,this;if(Q(h))return C.ready!==void 0?C.ready(h):h(x)}return x.makeArray(h,this)};it.prototype=x.fn,Qi=x(ie);var Ct=/^(?:parents|prev(?:Until|All))/,wr={children:!0,contents:!0,next:!0,prev:!0};x.fn.extend({has:function(h){var b=x(h,this),C=b.length;return this.filter(function(){for(var D=0;D<C;D++)if(x.contains(this,b[D]))return!0})},closest:function(h,b){var C,D=0,S=this.length,N=[],z=typeof h!="string"&&x(h);if(!Rn.test(h)){for(;D<S;D++)for(C=this[D];C&&C!==b;C=C.parentNode)if(C.nodeType<11&&(z?z.index(C)>-1:C.nodeType===1&&x.find.matchesSelector(C,h))){N.push(C);break}}return this.pushStack(N.length>1?x.uniqueSort(N):N)},index:function(h){return h?typeof h=="string"?k.call(x(h),this[0]):k.call(this,h.jquery?h[0]:h):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(h,b){return this.pushStack(x.uniqueSort(x.merge(this.get(),x(h,b))))},addBack:function(h){return this.add(h==null?this.prevObject:this.prevObject.filter(h))}});function Zi(h,b){for(;(h=h[b])&&h.nodeType!==1;);return h}x.each({parent:function(h){var b=h.parentNode;return b&&b.nodeType!==11?b:null},parents:function(h){return Nt(h,"parentNode")},parentsUntil:function(h,b,C){return Nt(h,"parentNode",C)},next:function(h){return Zi(h,"nextSibling")},prev:function(h){return Zi(h,"previousSibling")},nextAll:function(h){return Nt(h,"nextSibling")},prevAll:function(h){return Nt(h,"previousSibling")},nextUntil:function(h,b,C){return Nt(h,"nextSibling",C)},prevUntil:function(h,b,C){return Nt(h,"previousSibling",C)},siblings:function(h){return dn((h.parentNode||{}).firstChild,h)},children:function(h){return dn(h.firstChild)},contents:function(h){return h.contentDocument!=null&&w(h.contentDocument)?h.contentDocument:(he(h,"template")&&(h=h.content||h),x.merge([],h.childNodes))}},function(h,b){x.fn[h]=function(C,D){var S=x.map(this,b,C);return h.slice(-5)!=="Until"&&(D=C),D&&typeof D=="string"&&(S=x.filter(D,S)),this.length>1&&(wr[h]||x.uniqueSort(S),Ct.test(h)&&S.reverse()),this.pushStack(S)}});var jn=/[^\x20\t\r\n\f]+/g;function Ba(h){var b={};return x.each(h.match(jn)||[],function(C,D){b[D]=!0}),b}x.Callbacks=function(h){h=typeof h=="string"?Ba(h):x.extend({},h);var b,C,D,S,N=[],z=[],W=-1,U=function(){for(S=S||h.once,D=b=!0;z.length;W=-1)for(C=z.shift();++W<N.length;)N[W].apply(C[0],C[1])===!1&&h.stopOnFalse&&(W=N.length,C=!1);h.memory||(C=!1),b=!1,S&&(C?N=[]:N="")},Y={add:function(){return N&&(C&&!b&&(W=N.length-1,z.push(C)),function ee(ae){x.each(ae,function(J,de){Q(de)?(!h.unique||!Y.has(de))&&N.push(de):de&&de.length&&Ee(de)!=="string"&&ee(de)})}(arguments),C&&!b&&U()),this},remove:function(){return x.each(arguments,function(ee,ae){for(var J;(J=x.inArray(ae,N,J))>-1;)N.splice(J,1),J<=W&&W--}),this},has:function(ee){return ee?x.inArray(ee,N)>-1:N.length>0},empty:function(){return N&&(N=[]),this},disable:function(){return S=z=[],N=C="",this},disabled:function(){return!N},lock:function(){return S=z=[],!C&&!b&&(N=C=""),this},locked:function(){return!!S},fireWith:function(ee,ae){return S||(ae=ae||[],ae=[ee,ae.slice?ae.slice():ae],z.push(ae),b||U()),this},fire:function(){return Y.fireWith(this,arguments),this},fired:function(){return!!D}};return Y};function Ke(h){return h}function mo(h){throw h}function La(h,b,C,D){var S;try{h&&Q(S=h.promise)?S.call(h).done(b).fail(C):h&&Q(S=h.then)?S.call(h,b,C):b.apply(void 0,[h].slice(D))}catch(N){C.apply(void 0,[N])}}x.extend({Deferred:function(h){var b=[["notify","progress",x.Callbacks("memory"),x.Callbacks("memory"),2],["resolve","done",x.Callbacks("once memory"),x.Callbacks("once memory"),0,"resolved"],["reject","fail",x.Callbacks("once memory"),x.Callbacks("once memory"),1,"rejected"]],C="pending",D={state:function(){return C},always:function(){return S.done(arguments).fail(arguments),this},catch:function(N){return D.then(null,N)},pipe:function(){var N=arguments;return x.Deferred(function(z){x.each(b,function(W,U){var Y=Q(N[U[4]])&&N[U[4]];S[U[1]](function(){var ee=Y&&Y.apply(this,arguments);ee&&Q(ee.promise)?ee.promise().progress(z.notify).done(z.resolve).fail(z.reject):z[U[0]+"With"](this,Y?[ee]:arguments)})}),N=null}).promise()},then:function(N,z,W){var U=0;function Y(ee,ae,J,de){return function(){var Be=this,Je=arguments,Ue=function(){var At,ni;if(!(ee<U)){if(At=J.apply(Be,Je),At===ae.promise())throw new TypeError("Thenable self-resolution");ni=At&&(typeof At=="object"||typeof At=="function")&&At.then,Q(ni)?de?ni.call(At,Y(U,ae,Ke,de),Y(U,ae,mo,de)):(U++,ni.call(At,Y(U,ae,Ke,de),Y(U,ae,mo,de),Y(U,ae,Ke,ae.notifyWith))):(J!==Ke&&(Be=void 0,Je=[At]),(de||ae.resolveWith)(Be,Je))}},qt=de?Ue:function(){try{Ue()}catch(At){x.Deferred.exceptionHook&&x.Deferred.exceptionHook(At,qt.error),ee+1>=U&&(J!==mo&&(Be=void 0,Je=[At]),ae.rejectWith(Be,Je))}};ee?qt():(x.Deferred.getErrorHook?qt.error=x.Deferred.getErrorHook():x.Deferred.getStackHook&&(qt.error=x.Deferred.getStackHook()),d.setTimeout(qt))}}return x.Deferred(function(ee){b[0][3].add(Y(0,ee,Q(W)?W:Ke,ee.notifyWith)),b[1][3].add(Y(0,ee,Q(N)?N:Ke)),b[2][3].add(Y(0,ee,Q(z)?z:mo))}).promise()},promise:function(N){return N!=null?x.extend(N,D):D}},S={};return x.each(b,function(N,z){var W=z[2],U=z[5];D[z[1]]=W.add,U&&W.add(function(){C=U},b[3-N][2].disable,b[3-N][3].disable,b[0][2].lock,b[0][3].lock),W.add(z[3].fire),S[z[0]]=function(){return S[z[0]+"With"](this===S?void 0:this,arguments),this},S[z[0]+"With"]=W.fireWith}),D.promise(S),h&&h.call(S,S),S},when:function(h){var b=arguments.length,C=b,D=Array(C),S=A.call(arguments),N=x.Deferred(),z=function(W){return function(U){D[W]=this,S[W]=arguments.length>1?A.call(arguments):U,--b||N.resolveWith(D,S)}};if(b<=1&&(La(h,N.done(z(C)).resolve,N.reject,!b),N.state()==="pending"||Q(S[C]&&S[C].then)))return N.then();for(;C--;)La(S[C],z(C),N.reject);return N.promise()}});var Uc=/^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;x.Deferred.exceptionHook=function(h,b){d.console&&d.console.warn&&h&&Uc.test(h.name)&&d.console.warn("jQuery.Deferred exception: "+h.message,h.stack,b)},x.readyException=function(h){d.setTimeout(function(){throw h})};var vr=x.Deferred();x.fn.ready=function(h){return vr.then(h).catch(function(b){x.readyException(b)}),this},x.extend({isReady:!1,readyWait:1,ready:function(h){(h===!0?--x.readyWait:x.isReady)||(x.isReady=!0,!(h!==!0&&--x.readyWait>0)&&vr.resolveWith(ie,[x]))}}),x.ready.then=vr.then;function Ho(){ie.removeEventListener("DOMContentLoaded",Ho),d.removeEventListener("load",Ho),x.ready()}ie.readyState==="complete"||ie.readyState!=="loading"&&!ie.documentElement.doScroll?d.setTimeout(x.ready):(ie.addEventListener("DOMContentLoaded",Ho),d.addEventListener("load",Ho));var Fn=function(h,b,C,D,S,N,z){var W=0,U=h.length,Y=C==null;if(Ee(C)==="object"){S=!0;for(W in C)Fn(h,b,W,C[W],!0,N,z)}else if(D!==void 0&&(S=!0,Q(D)||(z=!0),Y&&(z?(b.call(h,D),b=null):(Y=b,b=function(ee,ae,J){return Y.call(x(ee),J)})),b))for(;W<U;W++)b(h[W],C,z?D:D.call(h[W],W,b(h[W],C)));return S?h:Y?b.call(h):U?b(h[0],C):N},Gt=/^-ms-/,bn=/-([a-z])/g;function za(h,b){return b.toUpperCase()}function Jn(h){return h.replace(Gt,"ms-").replace(bn,za)}var en=function(h){return h.nodeType===1||h.nodeType===9||!+h.nodeType};function un(){this.expando=x.expando+un.uid++}un.uid=1,un.prototype={cache:function(h){var b=h[this.expando];return b||(b={},en(h)&&(h.nodeType?h[this.expando]=b:Object.defineProperty(h,this.expando,{value:b,configurable:!0}))),b},set:function(h,b,C){var D,S=this.cache(h);if(typeof b=="string")S[Jn(b)]=C;else for(D in b)S[Jn(D)]=b[D];return S},get:function(h,b){return b===void 0?this.cache(h):h[this.expando]&&h[this.expando][Jn(b)]},access:function(h,b,C){return b===void 0||b&&typeof b=="string"&&C===void 0?this.get(h,b):(this.set(h,b,C),C!==void 0?C:b)},remove:function(h,b){var C,D=h[this.expando];if(D!==void 0){if(b!==void 0)for(Array.isArray(b)?b=b.map(Jn):(b=Jn(b),b=b in D?[b]:b.match(jn)||[]),C=b.length;C--;)delete D[b[C]];(b===void 0||x.isEmptyObject(D))&&(h.nodeType?h[this.expando]=void 0:delete h[this.expando])}},hasData:function(h){var b=h[this.expando];return b!==void 0&&!x.isEmptyObject(b)}};var _e=new un,hn=new un,Wc=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,Uo=/[A-Z]/g;function qc(h){return h==="true"?!0:h==="false"?!1:h==="null"?null:h===+h+""?+h:Wc.test(h)?JSON.parse(h):h}function Oa(h,b,C){var D;if(C===void 0&&h.nodeType===1)if(D="data-"+b.replace(Uo,"-$&").toLowerCase(),C=h.getAttribute(D),typeof C=="string"){try{C=qc(C)}catch{}hn.set(h,b,C)}else C=void 0;return C}x.extend({hasData:function(h){return hn.hasData(h)||_e.hasData(h)},data:function(h,b,C){return hn.access(h,b,C)},removeData:function(h,b){hn.remove(h,b)},_data:function(h,b,C){return _e.access(h,b,C)},_removeData:function(h,b){_e.remove(h,b)}}),x.fn.extend({data:function(h,b){var C,D,S,N=this[0],z=N&&N.attributes;if(h===void 0){if(this.length&&(S=hn.get(N),N.nodeType===1&&!_e.get(N,"hasDataAttrs"))){for(C=z.length;C--;)z[C]&&(D=z[C].name,D.indexOf("data-")===0&&(D=Jn(D.slice(5)),Oa(N,D,S[D])));_e.set(N,"hasDataAttrs",!0)}return S}return typeof h=="object"?this.each(function(){hn.set(this,h)}):Fn(this,function(W){var U;if(N&&W===void 0)return U=hn.get(N,h),U!==void 0||(U=Oa(N,h),U!==void 0)?U:void 0;this.each(function(){hn.set(this,h,W)})},null,b,arguments.length>1,null,!0)},removeData:function(h){return this.each(function(){hn.remove(this,h)})}}),x.extend({queue:function(h,b,C){var D;if(h)return b=(b||"fx")+"queue",D=_e.get(h,b),C&&(!D||Array.isArray(C)?D=_e.access(h,b,x.makeArray(C)):D.push(C)),D||[]},dequeue:function(h,b){b=b||"fx";var C=x.queue(h,b),D=C.length,S=C.shift(),N=x._queueHooks(h,b),z=function(){x.dequeue(h,b)};S==="inprogress"&&(S=C.shift(),D--),S&&(b==="fx"&&C.unshift("inprogress"),delete N.stop,S.call(h,z,N)),!D&&N&&N.empty.fire()},_queueHooks:function(h,b){var C=b+"queueHooks";return _e.get(h,C)||_e.access(h,C,{empty:x.Callbacks("once memory").add(function(){_e.remove(h,[b+"queue",C])})})}}),x.fn.extend({queue:function(h,b){var C=2;return typeof h!="string"&&(b=h,h="fx",C--),arguments.length<C?x.queue(this[0],h):b===void 0?this:this.each(function(){var D=x.queue(this,h,b);x._queueHooks(this,h),h==="fx"&&D[0]!=="inprogress"&&x.dequeue(this,h)})},dequeue:function(h){return this.each(function(){x.dequeue(this,h)})},clearQueue:function(h){return this.queue(h||"fx",[])},promise:function(h,b){var C,D=1,S=x.Deferred(),N=this,z=this.length,W=function(){--D||S.resolveWith(N,[N])};for(typeof h!="string"&&(b=h,h=void 0),h=h||"fx";z--;)C=_e.get(N[z],h+"queueHooks"),C&&C.empty&&(D++,C.empty.add(W));return W(),S.promise(b)}});var Ra=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,Wo=new RegExp("^(?:([+-])=|)("+Ra+")([a-z%]*)$","i"),mi=["Top","Right","Bottom","Left"],Ei=ie.documentElement,kn=function(h){return x.contains(h.ownerDocument,h)},tn={composed:!0};Ei.getRootNode&&(kn=function(h){return x.contains(h.ownerDocument,h)||h.getRootNode(tn)===h.ownerDocument});var nn=function(h,b){return h=b||h,h.style.display==="none"||h.style.display===""&&kn(h)&&x.css(h,"display")==="none"};function ja(h,b,C,D){var S,N,z=20,W=D?function(){return D.cur()}:function(){return x.css(h,b,"")},U=W(),Y=C&&C[3]||(x.cssNumber[b]?"":"px"),ee=h.nodeType&&(x.cssNumber[b]||Y!=="px"&&+U)&&Wo.exec(x.css(h,b));if(ee&&ee[3]!==Y){for(U=U/2,Y=Y||ee[3],ee=+U||1;z--;)x.style(h,b,ee+Y),(1-N)*(1-(N=W()/U||.5))<=0&&(z=0),ee=ee/N;ee=ee*2,x.style(h,b,ee+Y),C=C||[]}return C&&(ee=+ee||+U||0,S=C[1]?ee+(C[1]+1)*C[2]:+C[2],D&&(D.unit=Y,D.start=ee,D.end=S)),S}var us={};function Fa(h){var b,C=h.ownerDocument,D=h.nodeName,S=us[D];return S||(b=C.body.appendChild(C.createElement(D)),S=x.css(b,"display"),b.parentNode.removeChild(b),S==="none"&&(S="block"),us[D]=S,S)}function Ji(h,b){for(var C,D,S=[],N=0,z=h.length;N<z;N++)D=h[N],D.style&&(C=D.style.display,b?(C==="none"&&(S[N]=_e.get(D,"display")||null,S[N]||(D.style.display="")),D.style.display===""&&nn(D)&&(S[N]=Fa(D))):C!=="none"&&(S[N]="none",_e.set(D,"display",C)));for(N=0;N<z;N++)S[N]!=null&&(h[N].style.display=S[N]);return h}x.fn.extend({show:function(){return Ji(this,!0)},hide:function(){return Ji(this)},toggle:function(h){return typeof h=="boolean"?h?this.show():this.hide():this.each(function(){nn(this)?x(this).show():x(this).hide()})}});var Xi=/^(?:checkbox|radio)$/i,Va=/<([a-z][^\/\0>\x20\t\r\n\f]*)/i,Ha=/^$|^module$|\/(?:java|ecma)script/i;(function(){var h=ie.createDocumentFragment(),b=h.appendChild(ie.createElement("div")),C=ie.createElement("input");C.setAttribute("type","radio"),C.setAttribute("checked","checked"),C.setAttribute("name","t"),b.appendChild(C),q.checkClone=b.cloneNode(!0).cloneNode(!0).lastChild.checked,b.innerHTML="<textarea>x</textarea>",q.noCloneChecked=!!b.cloneNode(!0).lastChild.defaultValue,b.innerHTML="<option></option>",q.option=!!b.lastChild})();var Dn={thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};Dn.tbody=Dn.tfoot=Dn.colgroup=Dn.caption=Dn.thead,Dn.th=Dn.td,q.option||(Dn.optgroup=Dn.option=[1,"<select multiple='multiple'>","</select>"]);function on(h,b){var C;return typeof h.getElementsByTagName<"u"?C=h.getElementsByTagName(b||"*"):typeof h.querySelectorAll<"u"?C=h.querySelectorAll(b||"*"):C=[],b===void 0||b&&he(h,b)?x.merge([h],C):C}function hs(h,b){for(var C=0,D=h.length;C<D;C++)_e.set(h[C],"globalEval",!b||_e.get(b[C],"globalEval"))}var Gc=/<|&#?\w+;/;function rn(h,b,C,D,S){for(var N,z,W,U,Y,ee,ae=b.createDocumentFragment(),J=[],de=0,Be=h.length;de<Be;de++)if(N=h[de],N||N===0)if(Ee(N)==="object")x.merge(J,N.nodeType?[N]:N);else if(!Gc.test(N))J.push(b.createTextNode(N));else{for(z=z||ae.appendChild(b.createElement("div")),W=(Va.exec(N)||["",""])[1].toLowerCase(),U=Dn[W]||Dn._default,z.innerHTML=U[1]+x.htmlPrefilter(N)+U[2],ee=U[0];ee--;)z=z.lastChild;x.merge(J,z.childNodes),z=ae.firstChild,z.textContent=""}for(ae.textContent="",de=0;N=J[de++];){if(D&&x.inArray(N,D)>-1){S&&S.push(N);continue}if(Y=kn(N),z=on(ae.appendChild(N),"script"),Y&&hs(z),C)for(ee=0;N=z[ee++];)Ha.test(N.type||"")&&C.push(N)}return ae}var Ua=/^([^.]*)(?:\.(.+)|)/;function Xn(){return!0}function bi(){return!1}function fs(h,b,C,D,S,N){var z,W;if(typeof b=="object"){typeof C!="string"&&(D=D||C,C=void 0);for(W in b)fs(h,W,C,D,b[W],N);return h}if(D==null&&S==null?(S=C,D=C=void 0):S==null&&(typeof C=="string"?(S=D,D=void 0):(S=D,D=C,C=void 0)),S===!1)S=bi;else if(!S)return h;return N===1&&(z=S,S=function(U){return x().off(U),z.apply(this,arguments)},S.guid=z.guid||(z.guid=x.guid++)),h.each(function(){x.event.add(this,b,S,D,C)})}x.event={global:{},add:function(h,b,C,D,S){var N,z,W,U,Y,ee,ae,J,de,Be,Je,Ue=_e.get(h);if(en(h))for(C.handler&&(N=C,C=N.handler,S=N.selector),S&&x.find.matchesSelector(Ei,S),C.guid||(C.guid=x.guid++),(U=Ue.events)||(U=Ue.events=Object.create(null)),(z=Ue.handle)||(z=Ue.handle=function(qt){return typeof x<"u"&&x.event.triggered!==qt.type?x.event.dispatch.apply(h,arguments):void 0}),b=(b||"").match(jn)||[""],Y=b.length;Y--;)W=Ua.exec(b[Y])||[],de=Je=W[1],Be=(W[2]||"").split(".").sort(),de&&(ae=x.event.special[de]||{},de=(S?ae.delegateType:ae.bindType)||de,ae=x.event.special[de]||{},ee=x.extend({type:de,origType:Je,data:D,handler:C,guid:C.guid,selector:S,needsContext:S&&x.expr.match.needsContext.test(S),namespace:Be.join(".")},N),(J=U[de])||(J=U[de]=[],J.delegateCount=0,(!ae.setup||ae.setup.call(h,D,Be,z)===!1)&&h.addEventListener&&h.addEventListener(de,z)),ae.add&&(ae.add.call(h,ee),ee.handler.guid||(ee.handler.guid=C.guid)),S?J.splice(J.delegateCount++,0,ee):J.push(ee),x.event.global[de]=!0)},remove:function(h,b,C,D,S){var N,z,W,U,Y,ee,ae,J,de,Be,Je,Ue=_e.hasData(h)&&_e.get(h);if(!(!Ue||!(U=Ue.events))){for(b=(b||"").match(jn)||[""],Y=b.length;Y--;){if(W=Ua.exec(b[Y])||[],de=Je=W[1],Be=(W[2]||"").split(".").sort(),!de){for(de in U)x.event.remove(h,de+b[Y],C,D,!0);continue}for(ae=x.event.special[de]||{},de=(D?ae.delegateType:ae.bindType)||de,J=U[de]||[],W=W[2]&&new RegExp("(^|\\.)"+Be.join("\\.(?:.*\\.|)")+"(\\.|$)"),z=N=J.length;N--;)ee=J[N],(S||Je===ee.origType)&&(!C||C.guid===ee.guid)&&(!W||W.test(ee.namespace))&&(!D||D===ee.selector||D==="**"&&ee.selector)&&(J.splice(N,1),ee.selector&&J.delegateCount--,ae.remove&&ae.remove.call(h,ee));z&&!J.length&&((!ae.teardown||ae.teardown.call(h,Be,Ue.handle)===!1)&&x.removeEvent(h,de,Ue.handle),delete U[de])}x.isEmptyObject(U)&&_e.remove(h,"handle events")}},dispatch:function(h){var b,C,D,S,N,z,W=new Array(arguments.length),U=x.event.fix(h),Y=(_e.get(this,"events")||Object.create(null))[U.type]||[],ee=x.event.special[U.type]||{};for(W[0]=U,b=1;b<arguments.length;b++)W[b]=arguments[b];if(U.delegateTarget=this,!(ee.preDispatch&&ee.preDispatch.call(this,U)===!1)){for(z=x.event.handlers.call(this,U,Y),b=0;(S=z[b++])&&!U.isPropagationStopped();)for(U.currentTarget=S.elem,C=0;(N=S.handlers[C++])&&!U.isImmediatePropagationStopped();)(!U.rnamespace||N.namespace===!1||U.rnamespace.test(N.namespace))&&(U.handleObj=N,U.data=N.data,D=((x.event.special[N.origType]||{}).handle||N.handler).apply(S.elem,W),D!==void 0&&(U.result=D)===!1&&(U.preventDefault(),U.stopPropagation()));return ee.postDispatch&&ee.postDispatch.call(this,U),U.result}},handlers:function(h,b){var C,D,S,N,z,W=[],U=b.delegateCount,Y=h.target;if(U&&Y.nodeType&&!(h.type==="click"&&h.button>=1)){for(;Y!==this;Y=Y.parentNode||this)if(Y.nodeType===1&&!(h.type==="click"&&Y.disabled===!0)){for(N=[],z={},C=0;C<U;C++)D=b[C],S=D.selector+" ",z[S]===void 0&&(z[S]=D.needsContext?x(S,this).index(Y)>-1:x.find(S,this,null,[Y]).length),z[S]&&N.push(D);N.length&&W.push({elem:Y,handlers:N})}}return Y=this,U<b.length&&W.push({elem:Y,handlers:b.slice(U)}),W},addProp:function(h,b){Object.defineProperty(x.Event.prototype,h,{enumerable:!0,configurable:!0,get:Q(b)?function(){if(this.originalEvent)return b(this.originalEvent)}:function(){if(this.originalEvent)return this.originalEvent[h]},set:function(C){Object.defineProperty(this,h,{enumerable:!0,configurable:!0,writable:!0,value:C})}})},fix:function(h){return h[x.expando]?h:new x.Event(h)},special:{load:{noBubble:!0},click:{setup:function(h){var b=this||h;return Xi.test(b.type)&&b.click&&he(b,"input")&&_r(b,"click",!0),!1},trigger:function(h){var b=this||h;return Xi.test(b.type)&&b.click&&he(b,"input")&&_r(b,"click"),!0},_default:function(h){var b=h.target;return Xi.test(b.type)&&b.click&&he(b,"input")&&_e.get(b,"click")||he(b,"a")}},beforeunload:{postDispatch:function(h){h.result!==void 0&&h.originalEvent&&(h.originalEvent.returnValue=h.result)}}}};function _r(h,b,C){if(!C){_e.get(h,b)===void 0&&x.event.add(h,b,Xn);return}_e.set(h,b,!1),x.event.add(h,b,{namespace:!1,handler:function(D){var S,N=_e.get(this,b);if(D.isTrigger&1&&this[b]){if(N)(x.event.special[b]||{}).delegateType&&D.stopPropagation();else if(N=A.call(arguments),_e.set(this,b,N),this[b](),S=_e.get(this,b),_e.set(this,b,!1),N!==S)return D.stopImmediatePropagation(),D.preventDefault(),S}else N&&(_e.set(this,b,x.event.trigger(N[0],N.slice(1),this)),D.stopPropagation(),D.isImmediatePropagationStopped=Xn)}})}x.removeEvent=function(h,b,C){h.removeEventListener&&h.removeEventListener(b,C)},x.Event=function(h,b){if(!(this instanceof x.Event))return new x.Event(h,b);h&&h.type?(this.originalEvent=h,this.type=h.type,this.isDefaultPrevented=h.defaultPrevented||h.defaultPrevented===void 0&&h.returnValue===!1?Xn:bi,this.target=h.target&&h.target.nodeType===3?h.target.parentNode:h.target,this.currentTarget=h.currentTarget,this.relatedTarget=h.relatedTarget):this.type=h,b&&x.extend(this,b),this.timeStamp=h&&h.timeStamp||Date.now(),this[x.expando]=!0},x.Event.prototype={constructor:x.Event,isDefaultPrevented:bi,isPropagationStopped:bi,isImmediatePropagationStopped:bi,isSimulated:!1,preventDefault:function(){var h=this.originalEvent;this.isDefaultPrevented=Xn,h&&!this.isSimulated&&h.preventDefault()},stopPropagation:function(){var h=this.originalEvent;this.isPropagationStopped=Xn,h&&!this.isSimulated&&h.stopPropagation()},stopImmediatePropagation:function(){var h=this.originalEvent;this.isImmediatePropagationStopped=Xn,h&&!this.isSimulated&&h.stopImmediatePropagation(),this.stopPropagation()}},x.each({altKey:!0,bubbles:!0,cancelable:!0,changedTouches:!0,ctrlKey:!0,detail:!0,eventPhase:!0,metaKey:!0,pageX:!0,pageY:!0,shiftKey:!0,view:!0,char:!0,code:!0,charCode:!0,key:!0,keyCode:!0,button:!0,buttons:!0,clientX:!0,clientY:!0,offsetX:!0,offsetY:!0,pointerId:!0,pointerType:!0,screenX:!0,screenY:!0,targetTouches:!0,toElement:!0,touches:!0,which:!0},x.event.addProp),x.each({focus:"focusin",blur:"focusout"},function(h,b){function C(D){if(ie.documentMode){var S=_e.get(this,"handle"),N=x.event.fix(D);N.type=D.type==="focusin"?"focus":"blur",N.isSimulated=!0,S(D),N.target===N.currentTarget&&S(N)}else x.event.simulate(b,D.target,x.event.fix(D))}x.event.special[h]={setup:function(){var D;if(_r(this,h,!0),ie.documentMode)D=_e.get(this,b),D||this.addEventListener(b,C),_e.set(this,b,(D||0)+1);else return!1},trigger:function(){return _r(this,h),!0},teardown:function(){var D;if(ie.documentMode)D=_e.get(this,b)-1,D?_e.set(this,b,D):(this.removeEventListener(b,C),_e.remove(this,b));else return!1},_default:function(D){return _e.get(D.target,h)},delegateType:b},x.event.special[b]={setup:function(){var D=this.ownerDocument||this.document||this,S=ie.documentMode?this:D,N=_e.get(S,b);N||(ie.documentMode?this.addEventListener(b,C):D.addEventListener(h,C,!0)),_e.set(S,b,(N||0)+1)},teardown:function(){var D=this.ownerDocument||this.document||this,S=ie.documentMode?this:D,N=_e.get(S,b)-1;N?_e.set(S,b,N):(ie.documentMode?this.removeEventListener(b,C):D.removeEventListener(h,C,!0),_e.remove(S,b))}}}),x.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(h,b){x.event.special[h]={delegateType:b,bindType:b,handle:function(C){var D,S=this,N=C.relatedTarget,z=C.handleObj;return(!N||N!==S&&!x.contains(S,N))&&(C.type=z.origType,D=z.handler.apply(this,arguments),C.type=b),D}}}),x.fn.extend({on:function(h,b,C,D){return fs(this,h,b,C,D)},one:function(h,b,C,D){return fs(this,h,b,C,D,1)},off:function(h,b,C){var D,S;if(h&&h.preventDefault&&h.handleObj)return D=h.handleObj,x(h.delegateTarget).off(D.namespace?D.origType+"."+D.namespace:D.origType,D.selector,D.handler),this;if(typeof h=="object"){for(S in h)this.off(S,b,h[S]);return this}return(b===!1||typeof b=="function")&&(C=b,b=void 0),C===!1&&(C=bi),this.each(function(){x.event.remove(this,h,C,b)})}});var $c=/<script|<style|<link/i,Yc=/checked\s*(?:[^=]|=\s*.checked.)/i,Kc=/^\s*<!\[CDATA\[|\]\]>\s*$/g;function eo(h,b){return he(h,"table")&&he(b.nodeType!==11?b:b.firstChild,"tr")&&x(h).children("tbody")[0]||h}function Cr(h){return h.type=(h.getAttribute("type")!==null)+"/"+h.type,h}function Qc(h){return(h.type||"").slice(0,5)==="true/"?h.type=h.type.slice(5):h.removeAttribute("type"),h}function Wa(h,b){var C,D,S,N,z,W,U;if(b.nodeType===1){if(_e.hasData(h)&&(N=_e.get(h),U=N.events,U)){_e.remove(b,"handle events");for(S in U)for(C=0,D=U[S].length;C<D;C++)x.event.add(b,S,U[S][C])}hn.hasData(h)&&(z=hn.access(h),W=x.extend({},z),hn.set(b,W))}}function Zc(h,b){var C=b.nodeName.toLowerCase();C==="input"&&Xi.test(h.type)?b.checked=h.checked:(C==="input"||C==="textarea")&&(b.defaultValue=h.defaultValue)}function bo(h,b,C,D){b=_(b);var S,N,z,W,U,Y,ee=0,ae=h.length,J=ae-1,de=b[0],Be=Q(de);if(Be||ae>1&&typeof de=="string"&&!q.checkClone&&Yc.test(de))return h.each(function(Je){var Ue=h.eq(Je);Be&&(b[0]=de.call(this,Je,Ue.html())),bo(Ue,b,C,D)});if(ae&&(S=rn(b,h[0].ownerDocument,!1,h,D),N=S.firstChild,S.childNodes.length===1&&(S=N),N||D)){for(z=x.map(on(S,"script"),Cr),W=z.length;ee<ae;ee++)U=S,ee!==J&&(U=x.clone(U,!0,!0),W&&x.merge(z,on(U,"script"))),C.call(h[ee],U,ee);if(W)for(Y=z[z.length-1].ownerDocument,x.map(z,Qc),ee=0;ee<W;ee++)U=z[ee],Ha.test(U.type||"")&&!_e.access(U,"globalEval")&&x.contains(Y,U)&&(U.src&&(U.type||"").toLowerCase()!=="module"?x._evalUrl&&!U.noModule&&x._evalUrl(U.src,{nonce:U.nonce||U.getAttribute("nonce")},Y):Ae(U.textContent.replace(Kc,""),U,Y))}return h}function qa(h,b,C){for(var D,S=b?x.filter(b,h):h,N=0;(D=S[N])!=null;N++)!C&&D.nodeType===1&&x.cleanData(on(D)),D.parentNode&&(C&&kn(D)&&hs(on(D,"script")),D.parentNode.removeChild(D));return h}x.extend({htmlPrefilter:function(h){return h},clone:function(h,b,C){var D,S,N,z,W=h.cloneNode(!0),U=kn(h);if(!q.noCloneChecked&&(h.nodeType===1||h.nodeType===11)&&!x.isXMLDoc(h))for(z=on(W),N=on(h),D=0,S=N.length;D<S;D++)Zc(N[D],z[D]);if(b)if(C)for(N=N||on(h),z=z||on(W),D=0,S=N.length;D<S;D++)Wa(N[D],z[D]);else Wa(h,W);return z=on(W,"script"),z.length>0&&hs(z,!U&&on(h,"script")),W},cleanData:function(h){for(var b,C,D,S=x.event.special,N=0;(C=h[N])!==void 0;N++)if(en(C)){if(b=C[_e.expando]){if(b.events)for(D in b.events)S[D]?x.event.remove(C,D):x.removeEvent(C,D,b.handle);C[_e.expando]=void 0}C[hn.expando]&&(C[hn.expando]=void 0)}}}),x.fn.extend({detach:function(h){return qa(this,h,!0)},remove:function(h){return qa(this,h)},text:function(h){return Fn(this,function(b){return b===void 0?x.text(this):this.empty().each(function(){(this.nodeType===1||this.nodeType===11||this.nodeType===9)&&(this.textContent=b)})},null,h,arguments.length)},append:function(){return bo(this,arguments,function(h){if(this.nodeType===1||this.nodeType===11||this.nodeType===9){var b=eo(this,h);b.appendChild(h)}})},prepend:function(){return bo(this,arguments,function(h){if(this.nodeType===1||this.nodeType===11||this.nodeType===9){var b=eo(this,h);b.insertBefore(h,b.firstChild)}})},before:function(){return bo(this,arguments,function(h){this.parentNode&&this.parentNode.insertBefore(h,this)})},after:function(){return bo(this,arguments,function(h){this.parentNode&&this.parentNode.insertBefore(h,this.nextSibling)})},empty:function(){for(var h,b=0;(h=this[b])!=null;b++)h.nodeType===1&&(x.cleanData(on(h,!1)),h.textContent="");return this},clone:function(h,b){return h=h??!1,b=b??h,this.map(function(){return x.clone(this,h,b)})},html:function(h){return Fn(this,function(b){var C=this[0]||{},D=0,S=this.length;if(b===void 0&&C.nodeType===1)return C.innerHTML;if(typeof b=="string"&&!$c.test(b)&&!Dn[(Va.exec(b)||["",""])[1].toLowerCase()]){b=x.htmlPrefilter(b);try{for(;D<S;D++)C=this[D]||{},C.nodeType===1&&(x.cleanData(on(C,!1)),C.innerHTML=b);C=0}catch{}}C&&this.empty().append(b)},null,h,arguments.length)},replaceWith:function(){var h=[];return bo(this,arguments,function(b){var C=this.parentNode;x.inArray(this,h)<0&&(x.cleanData(on(this)),C&&C.replaceChild(b,this))},h)}}),x.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(h,b){x.fn[h]=function(C){for(var D,S=[],N=x(C),z=N.length-1,W=0;W<=z;W++)D=W===z?this:this.clone(!0),x(N[W])[b](D),y.apply(S,D.get());return this.pushStack(S)}});var gs=new RegExp("^("+Ra+")(?!px)[a-z%]+$","i"),ps=/^--/,Ar=function(h){var b=h.ownerDocument.defaultView;return(!b||!b.opener)&&(b=d),b.getComputedStyle(h)},ko=function(h,b,C){var D,S,N={};for(S in b)N[S]=h.style[S],h.style[S]=b[S];D=C.call(h);for(S in b)h.style[S]=N[S];return D},ms=new RegExp(mi.join("|"),"i");(function(){function h(){if(Y){U.style.cssText="position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0",Y.style.cssText="position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%",Ei.appendChild(U).appendChild(Y);var ee=d.getComputedStyle(Y);C=ee.top!=="1%",W=b(ee.marginLeft)===12,Y.style.right="60%",N=b(ee.right)===36,D=b(ee.width)===36,Y.style.position="absolute",S=b(Y.offsetWidth/3)===12,Ei.removeChild(U),Y=null}}function b(ee){return Math.round(parseFloat(ee))}var C,D,S,N,z,W,U=ie.createElement("div"),Y=ie.createElement("div");Y.style&&(Y.style.backgroundClip="content-box",Y.cloneNode(!0).style.backgroundClip="",q.clearCloneStyle=Y.style.backgroundClip==="content-box",x.extend(q,{boxSizingReliable:function(){return h(),D},pixelBoxStyles:function(){return h(),N},pixelPosition:function(){return h(),C},reliableMarginLeft:function(){return h(),W},scrollboxSize:function(){return h(),S},reliableTrDimensions:function(){var ee,ae,J,de;return z==null&&(ee=ie.createElement("table"),ae=ie.createElement("tr"),J=ie.createElement("div"),ee.style.cssText="position:absolute;left:-11111px;border-collapse:separate",ae.style.cssText="box-sizing:content-box;border:1px solid",ae.style.height="1px",J.style.height="9px",J.style.display="block",Ei.appendChild(ee).appendChild(ae).appendChild(J),de=d.getComputedStyle(ae),z=parseInt(de.height,10)+parseInt(de.borderTopWidth,10)+parseInt(de.borderBottomWidth,10)===ae.offsetHeight,Ei.removeChild(ee)),z}}))})();function wo(h,b,C){var D,S,N,z,W=ps.test(b),U=h.style;return C=C||Ar(h),C&&(z=C.getPropertyValue(b)||C[b],W&&z&&(z=z.replace(Me,"$1")||void 0),z===""&&!kn(h)&&(z=x.style(h,b)),!q.pixelBoxStyles()&&gs.test(z)&&ms.test(b)&&(D=U.width,S=U.minWidth,N=U.maxWidth,U.minWidth=U.maxWidth=U.width=z,z=C.width,U.width=D,U.minWidth=S,U.maxWidth=N)),z!==void 0?z+"":z}function Ga(h,b){return{get:function(){if(h()){delete this.get;return}return(this.get=b).apply(this,arguments)}}}var $a=["Webkit","Moz","ms"],Ti=ie.createElement("div").style,Ya={};function Jc(h){for(var b=h[0].toUpperCase()+h.slice(1),C=$a.length;C--;)if(h=$a[C]+b,h in Ti)return h}function bs(h){var b=x.cssProps[h]||Ya[h];return b||(h in Ti?h:Ya[h]=Jc(h)||h)}var Xc=/^(none|table(?!-c[ea]).+)/,ed={position:"absolute",visibility:"hidden",display:"block"},Ka={letterSpacing:"0",fontWeight:"400"};function Qa(h,b,C){var D=Wo.exec(b);return D?Math.max(0,D[2]-(C||0))+(D[3]||"px"):b}function ks(h,b,C,D,S,N){var z=b==="width"?1:0,W=0,U=0,Y=0;if(C===(D?"border":"content"))return 0;for(;z<4;z+=2)C==="margin"&&(Y+=x.css(h,C+mi[z],!0,S)),D?(C==="content"&&(U-=x.css(h,"padding"+mi[z],!0,S)),C!=="margin"&&(U-=x.css(h,"border"+mi[z]+"Width",!0,S))):(U+=x.css(h,"padding"+mi[z],!0,S),C!=="padding"?U+=x.css(h,"border"+mi[z]+"Width",!0,S):W+=x.css(h,"border"+mi[z]+"Width",!0,S));return!D&&N>=0&&(U+=Math.max(0,Math.ceil(h["offset"+b[0].toUpperCase()+b.slice(1)]-N-U-W-.5))||0),U+Y}function Si(h,b,C){var D=Ar(h),S=!q.boxSizingReliable()||C,N=S&&x.css(h,"boxSizing",!1,D)==="border-box",z=N,W=wo(h,b,D),U="offset"+b[0].toUpperCase()+b.slice(1);if(gs.test(W)){if(!C)return W;W="auto"}return(!q.boxSizingReliable()&&N||!q.reliableTrDimensions()&&he(h,"tr")||W==="auto"||!parseFloat(W)&&x.css(h,"display",!1,D)==="inline")&&h.getClientRects().length&&(N=x.css(h,"boxSizing",!1,D)==="border-box",z=U in h,z&&(W=h[U])),W=parseFloat(W)||0,W+ks(h,b,C||(N?"border":"content"),z,D,W)+"px"}x.extend({cssHooks:{opacity:{get:function(h,b){if(b){var C=wo(h,"opacity");return C===""?"1":C}}}},cssNumber:{animationIterationCount:!0,aspectRatio:!0,borderImageSlice:!0,columnCount:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,gridArea:!0,gridColumn:!0,gridColumnEnd:!0,gridColumnStart:!0,gridRow:!0,gridRowEnd:!0,gridRowStart:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,scale:!0,widows:!0,zIndex:!0,zoom:!0,fillOpacity:!0,floodOpacity:!0,stopOpacity:!0,strokeMiterlimit:!0,strokeOpacity:!0},cssProps:{},style:function(h,b,C,D){if(!(!h||h.nodeType===3||h.nodeType===8||!h.style)){var S,N,z,W=Jn(b),U=ps.test(b),Y=h.style;if(U||(b=bs(W)),z=x.cssHooks[b]||x.cssHooks[W],C!==void 0){if(N=typeof C,N==="string"&&(S=Wo.exec(C))&&S[1]&&(C=ja(h,b,S),N="number"),C==null||C!==C)return;N==="number"&&!U&&(C+=S&&S[3]||(x.cssNumber[W]?"":"px")),!q.clearCloneStyle&&C===""&&b.indexOf("background")===0&&(Y[b]="inherit"),(!z||!("set"in z)||(C=z.set(h,C,D))!==void 0)&&(U?Y.setProperty(b,C):Y[b]=C)}else return z&&"get"in z&&(S=z.get(h,!1,D))!==void 0?S:Y[b]}},css:function(h,b,C,D){var S,N,z,W=Jn(b),U=ps.test(b);return U||(b=bs(W)),z=x.cssHooks[b]||x.cssHooks[W],z&&"get"in z&&(S=z.get(h,!0,C)),S===void 0&&(S=wo(h,b,D)),S==="normal"&&b in Ka&&(S=Ka[b]),C===""||C?(N=parseFloat(S),C===!0||isFinite(N)?N||0:S):S}}),x.each(["height","width"],function(h,b){x.cssHooks[b]={get:function(C,D,S){if(D)return Xc.test(x.css(C,"display"))&&(!C.getClientRects().length||!C.getBoundingClientRect().width)?ko(C,ed,function(){return Si(C,b,S)}):Si(C,b,S)},set:function(C,D,S){var N,z=Ar(C),W=!q.scrollboxSize()&&z.position==="absolute",U=W||S,Y=U&&x.css(C,"boxSizing",!1,z)==="border-box",ee=S?ks(C,b,S,Y,z):0;return Y&&W&&(ee-=Math.ceil(C["offset"+b[0].toUpperCase()+b.slice(1)]-parseFloat(z[b])-ks(C,b,"border",!1,z)-.5)),ee&&(N=Wo.exec(D))&&(N[3]||"px")!=="px"&&(C.style[b]=D,D=x.css(C,b)),Qa(C,D,ee)}}}),x.cssHooks.marginLeft=Ga(q.reliableMarginLeft,function(h,b){if(b)return(parseFloat(wo(h,"marginLeft"))||h.getBoundingClientRect().left-ko(h,{marginLeft:0},function(){return h.getBoundingClientRect().left}))+"px"}),x.each({margin:"",padding:"",border:"Width"},function(h,b){x.cssHooks[h+b]={expand:function(C){for(var D=0,S={},N=typeof C=="string"?C.split(" "):[C];D<4;D++)S[h+mi[D]+b]=N[D]||N[D-2]||N[0];return S}},h!=="margin"&&(x.cssHooks[h+b].set=Qa)}),x.fn.extend({css:function(h,b){return Fn(this,function(C,D,S){var N,z,W={},U=0;if(Array.isArray(D)){for(N=Ar(C),z=D.length;U<z;U++)W[D[U]]=x.css(C,D[U],!1,N);return W}return S!==void 0?x.style(C,D,S):x.css(C,D)},h,b,arguments.length>1)}});function Ft(h,b,C,D,S){return new Ft.prototype.init(h,b,C,D,S)}x.Tween=Ft,Ft.prototype={constructor:Ft,init:function(h,b,C,D,S,N){this.elem=h,this.prop=C,this.easing=S||x.easing._default,this.options=b,this.start=this.now=this.cur(),this.end=D,this.unit=N||(x.cssNumber[C]?"":"px")},cur:function(){var h=Ft.propHooks[this.prop];return h&&h.get?h.get(this):Ft.propHooks._default.get(this)},run:function(h){var b,C=Ft.propHooks[this.prop];return this.options.duration?this.pos=b=x.easing[this.easing](h,this.options.duration*h,0,1,this.options.duration):this.pos=b=h,this.now=(this.end-this.start)*b+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),C&&C.set?C.set(this):Ft.propHooks._default.set(this),this}},Ft.prototype.init.prototype=Ft.prototype,Ft.propHooks={_default:{get:function(h){var b;return h.elem.nodeType!==1||h.elem[h.prop]!=null&&h.elem.style[h.prop]==null?h.elem[h.prop]:(b=x.css(h.elem,h.prop,""),!b||b==="auto"?0:b)},set:function(h){x.fx.step[h.prop]?x.fx.step[h.prop](h):h.elem.nodeType===1&&(x.cssHooks[h.prop]||h.elem.style[bs(h.prop)]!=null)?x.style(h.elem,h.prop,h.now+h.unit):h.elem[h.prop]=h.now}}},Ft.propHooks.scrollTop=Ft.propHooks.scrollLeft={set:function(h){h.elem.nodeType&&h.elem.parentNode&&(h.elem[h.prop]=h.now)}},x.easing={linear:function(h){return h},swing:function(h){return .5-Math.cos(h*Math.PI)/2},_default:"swing"},x.fx=Ft.prototype.init,x.fx.step={};var ei,yr,td=/^(?:toggle|show|hide)$/,nd=/queueHooks$/;function ws(){yr&&(ie.hidden===!1&&d.requestAnimationFrame?d.requestAnimationFrame(ws):d.setTimeout(ws,x.fx.interval),x.fx.tick())}function Za(){return d.setTimeout(function(){ei=void 0}),ei=Date.now()}function xr(h,b){var C,D=0,S={height:h};for(b=b?1:0;D<4;D+=2-b)C=mi[D],S["margin"+C]=S["padding"+C]=h;return b&&(S.opacity=S.width=h),S}function Ja(h,b,C){for(var D,S=($t.tweeners[b]||[]).concat($t.tweeners["*"]),N=0,z=S.length;N<z;N++)if(D=S[N].call(C,b,h))return D}function id(h,b,C){var D,S,N,z,W,U,Y,ee,ae="width"in b||"height"in b,J=this,de={},Be=h.style,Je=h.nodeType&&nn(h),Ue=_e.get(h,"fxshow");C.queue||(z=x._queueHooks(h,"fx"),z.unqueued==null&&(z.unqueued=0,W=z.empty.fire,z.empty.fire=function(){z.unqueued||W()}),z.unqueued++,J.always(function(){J.always(function(){z.unqueued--,x.queue(h,"fx").length||z.empty.fire()})}));for(D in b)if(S=b[D],td.test(S)){if(delete b[D],N=N||S==="toggle",S===(Je?"hide":"show"))if(S==="show"&&Ue&&Ue[D]!==void 0)Je=!0;else continue;de[D]=Ue&&Ue[D]||x.style(h,D)}if(U=!x.isEmptyObject(b),!(!U&&x.isEmptyObject(de))){ae&&h.nodeType===1&&(C.overflow=[Be.overflow,Be.overflowX,Be.overflowY],Y=Ue&&Ue.display,Y==null&&(Y=_e.get(h,"display")),ee=x.css(h,"display"),ee==="none"&&(Y?ee=Y:(Ji([h],!0),Y=h.style.display||Y,ee=x.css(h,"display"),Ji([h]))),(ee==="inline"||ee==="inline-block"&&Y!=null)&&x.css(h,"float")==="none"&&(U||(J.done(function(){Be.display=Y}),Y==null&&(ee=Be.display,Y=ee==="none"?"":ee)),Be.display="inline-block")),C.overflow&&(Be.overflow="hidden",J.always(function(){Be.overflow=C.overflow[0],Be.overflowX=C.overflow[1],Be.overflowY=C.overflow[2]})),U=!1;for(D in de)U||(Ue?"hidden"in Ue&&(Je=Ue.hidden):Ue=_e.access(h,"fxshow",{display:Y}),N&&(Ue.hidden=!Je),Je&&Ji([h],!0),J.done(function(){Je||Ji([h]),_e.remove(h,"fxshow");for(D in de)x.style(h,D,de[D])})),U=Ja(Je?Ue[D]:0,D,J),D in Ue||(Ue[D]=U.start,Je&&(U.end=U.start,U.start=0))}}function od(h,b){var C,D,S,N,z;for(C in h)if(D=Jn(C),S=b[D],N=h[C],Array.isArray(N)&&(S=N[1],N=h[C]=N[0]),C!==D&&(h[D]=N,delete h[C]),z=x.cssHooks[D],z&&"expand"in z){N=z.expand(N),delete h[D];for(C in N)C in h||(h[C]=N[C],b[C]=S)}else b[D]=S}function $t(h,b,C){var D,S,N=0,z=$t.prefilters.length,W=x.Deferred().always(function(){delete U.elem}),U=function(){if(S)return!1;for(var ae=ei||Za(),J=Math.max(0,Y.startTime+Y.duration-ae),de=J/Y.duration||0,Be=1-de,Je=0,Ue=Y.tweens.length;Je<Ue;Je++)Y.tweens[Je].run(Be);return W.notifyWith(h,[Y,Be,J]),Be<1&&Ue?J:(Ue||W.notifyWith(h,[Y,1,0]),W.resolveWith(h,[Y]),!1)},Y=W.promise({elem:h,props:x.extend({},b),opts:x.extend(!0,{specialEasing:{},easing:x.easing._default},C),originalProperties:b,originalOptions:C,startTime:ei||Za(),duration:C.duration,tweens:[],createTween:function(ae,J){var de=x.Tween(h,Y.opts,ae,J,Y.opts.specialEasing[ae]||Y.opts.easing);return Y.tweens.push(de),de},stop:function(ae){var J=0,de=ae?Y.tweens.length:0;if(S)return this;for(S=!0;J<de;J++)Y.tweens[J].run(1);return ae?(W.notifyWith(h,[Y,1,0]),W.resolveWith(h,[Y,ae])):W.rejectWith(h,[Y,ae]),this}}),ee=Y.props;for(od(ee,Y.opts.specialEasing);N<z;N++)if(D=$t.prefilters[N].call(Y,h,ee,Y.opts),D)return Q(D.stop)&&(x._queueHooks(Y.elem,Y.opts.queue).stop=D.stop.bind(D)),D;return x.map(ee,Ja,Y),Q(Y.opts.start)&&Y.opts.start.call(h,Y),Y.progress(Y.opts.progress).done(Y.opts.done,Y.opts.complete).fail(Y.opts.fail).always(Y.opts.always),x.fx.timer(x.extend(U,{elem:h,anim:Y,queue:Y.opts.queue})),Y}x.Animation=x.extend($t,{tweeners:{"*":[function(h,b){var C=this.createTween(h,b);return ja(C.elem,h,Wo.exec(b),C),C}]},tweener:function(h,b){Q(h)?(b=h,h=["*"]):h=h.match(jn);for(var C,D=0,S=h.length;D<S;D++)C=h[D],$t.tweeners[C]=$t.tweeners[C]||[],$t.tweeners[C].unshift(b)},prefilters:[id],prefilter:function(h,b){b?$t.prefilters.unshift(h):$t.prefilters.push(h)}}),x.speed=function(h,b,C){var D=h&&typeof h=="object"?x.extend({},h):{complete:C||!C&&b||Q(h)&&h,duration:h,easing:C&&b||b&&!Q(b)&&b};return x.fx.off?D.duration=0:typeof D.duration!="number"&&(D.duration in x.fx.speeds?D.duration=x.fx.speeds[D.duration]:D.duration=x.fx.speeds._default),(D.queue==null||D.queue===!0)&&(D.queue="fx"),D.old=D.complete,D.complete=function(){Q(D.old)&&D.old.call(this),D.queue&&x.dequeue(this,D.queue)},D},x.fn.extend({fadeTo:function(h,b,C,D){return this.filter(nn).css("opacity",0).show().end().animate({opacity:b},h,C,D)},animate:function(h,b,C,D){var S=x.isEmptyObject(h),N=x.speed(b,C,D),z=function(){var W=$t(this,x.extend({},h),N);(S||_e.get(this,"finish"))&&W.stop(!0)};return z.finish=z,S||N.queue===!1?this.each(z):this.queue(N.queue,z)},stop:function(h,b,C){var D=function(S){var N=S.stop;delete S.stop,N(C)};return typeof h!="string"&&(C=b,b=h,h=void 0),b&&this.queue(h||"fx",[]),this.each(function(){var S=!0,N=h!=null&&h+"queueHooks",z=x.timers,W=_e.get(this);if(N)W[N]&&W[N].stop&&D(W[N]);else for(N in W)W[N]&&W[N].stop&&nd.test(N)&&D(W[N]);for(N=z.length;N--;)z[N].elem===this&&(h==null||z[N].queue===h)&&(z[N].anim.stop(C),S=!1,z.splice(N,1));(S||!C)&&x.dequeue(this,h)})},finish:function(h){return h!==!1&&(h=h||"fx"),this.each(function(){var b,C=_e.get(this),D=C[h+"queue"],S=C[h+"queueHooks"],N=x.timers,z=D?D.length:0;for(C.finish=!0,x.queue(this,h,[]),S&&S.stop&&S.stop.call(this,!0),b=N.length;b--;)N[b].elem===this&&N[b].queue===h&&(N[b].anim.stop(!0),N.splice(b,1));for(b=0;b<z;b++)D[b]&&D[b].finish&&D[b].finish.call(this);delete C.finish})}}),x.each(["toggle","show","hide"],function(h,b){var C=x.fn[b];x.fn[b]=function(D,S,N){return D==null||typeof D=="boolean"?C.apply(this,arguments):this.animate(xr(b,!0),D,S,N)}}),x.each({slideDown:xr("show"),slideUp:xr("hide"),slideToggle:xr("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(h,b){x.fn[h]=function(C,D,S){return this.animate(b,C,D,S)}}),x.timers=[],x.fx.tick=function(){var h,b=0,C=x.timers;for(ei=Date.now();b<C.length;b++)h=C[b],!h()&&C[b]===h&&C.splice(b--,1);C.length||x.fx.stop(),ei=void 0},x.fx.timer=function(h){x.timers.push(h),x.fx.start()},x.fx.interval=13,x.fx.start=function(){yr||(yr=!0,ws())},x.fx.stop=function(){yr=null},x.fx.speeds={slow:600,fast:200,_default:400},x.fn.delay=function(h,b){return h=x.fx&&x.fx.speeds[h]||h,b=b||"fx",this.queue(b,function(C,D){var S=d.setTimeout(C,h);D.stop=function(){d.clearTimeout(S)}})},function(){var h=ie.createElement("input"),b=ie.createElement("select"),C=b.appendChild(ie.createElement("option"));h.type="checkbox",q.checkOn=h.value!=="",q.optSelected=C.selected,h=ie.createElement("input"),h.value="t",h.type="radio",q.radioValue=h.value==="t"}();var vs,qo=x.expr.attrHandle;x.fn.extend({attr:function(h,b){return Fn(this,x.attr,h,b,arguments.length>1)},removeAttr:function(h){return this.each(function(){x.removeAttr(this,h)})}}),x.extend({attr:function(h,b,C){var D,S,N=h.nodeType;if(!(N===3||N===8||N===2)){if(typeof h.getAttribute>"u")return x.prop(h,b,C);if((N!==1||!x.isXMLDoc(h))&&(S=x.attrHooks[b.toLowerCase()]||(x.expr.match.bool.test(b)?vs:void 0)),C!==void 0){if(C===null){x.removeAttr(h,b);return}return S&&"set"in S&&(D=S.set(h,C,b))!==void 0?D:(h.setAttribute(b,C+""),C)}return S&&"get"in S&&(D=S.get(h,b))!==null?D:(D=x.find.attr(h,b),D??void 0)}},attrHooks:{type:{set:function(h,b){if(!q.radioValue&&b==="radio"&&he(h,"input")){var C=h.value;return h.setAttribute("type",b),C&&(h.value=C),b}}}},removeAttr:function(h,b){var C,D=0,S=b&&b.match(jn);if(S&&h.nodeType===1)for(;C=S[D++];)h.removeAttribute(C)}}),vs={set:function(h,b,C){return b===!1?x.removeAttr(h,C):h.setAttribute(C,C),C}},x.each(x.expr.match.bool.source.match(/\w+/g),function(h,b){var C=qo[b]||x.find.attr;qo[b]=function(D,S,N){var z,W,U=S.toLowerCase();return N||(W=qo[U],qo[U]=z,z=C(D,S,N)!=null?U:null,qo[U]=W),z}});var rd=/^(?:input|select|textarea|button)$/i,Dr=/^(?:a|area)$/i;x.fn.extend({prop:function(h,b){return Fn(this,x.prop,h,b,arguments.length>1)},removeProp:function(h){return this.each(function(){delete this[x.propFix[h]||h]})}}),x.extend({prop:function(h,b,C){var D,S,N=h.nodeType;if(!(N===3||N===8||N===2))return(N!==1||!x.isXMLDoc(h))&&(b=x.propFix[b]||b,S=x.propHooks[b]),C!==void 0?S&&"set"in S&&(D=S.set(h,C,b))!==void 0?D:h[b]=C:S&&"get"in S&&(D=S.get(h,b))!==null?D:h[b]},propHooks:{tabIndex:{get:function(h){var b=x.find.attr(h,"tabindex");return b?parseInt(b,10):rd.test(h.nodeName)||Dr.test(h.nodeName)&&h.href?0:-1}}},propFix:{for:"htmlFor",class:"className"}}),q.optSelected||(x.propHooks.selected={get:function(h){var b=h.parentNode;return b&&b.parentNode&&b.parentNode.selectedIndex,null},set:function(h){var b=h.parentNode;b&&(b.selectedIndex,b.parentNode&&b.parentNode.selectedIndex)}}),x.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){x.propFix[this.toLowerCase()]=this});function to(h){var b=h.match(jn)||[];return b.join(" ")}function no(h){return h.getAttribute&&h.getAttribute("class")||""}function _s(h){return Array.isArray(h)?h:typeof h=="string"?h.match(jn)||[]:[]}x.fn.extend({addClass:function(h){var b,C,D,S,N,z;return Q(h)?this.each(function(W){x(this).addClass(h.call(this,W,no(this)))}):(b=_s(h),b.length?this.each(function(){if(D=no(this),C=this.nodeType===1&&" "+to(D)+" ",C){for(N=0;N<b.length;N++)S=b[N],C.indexOf(" "+S+" ")<0&&(C+=S+" ");z=to(C),D!==z&&this.setAttribute("class",z)}}):this)},removeClass:function(h){var b,C,D,S,N,z;return Q(h)?this.each(function(W){x(this).removeClass(h.call(this,W,no(this)))}):arguments.length?(b=_s(h),b.length?this.each(function(){if(D=no(this),C=this.nodeType===1&&" "+to(D)+" ",C){for(N=0;N<b.length;N++)for(S=b[N];C.indexOf(" "+S+" ")>-1;)C=C.replace(" "+S+" "," ");z=to(C),D!==z&&this.setAttribute("class",z)}}):this):this.attr("class","")},toggleClass:function(h,b){var C,D,S,N,z=typeof h,W=z==="string"||Array.isArray(h);return Q(h)?this.each(function(U){x(this).toggleClass(h.call(this,U,no(this),b),b)}):typeof b=="boolean"&&W?b?this.addClass(h):this.removeClass(h):(C=_s(h),this.each(function(){if(W)for(N=x(this),S=0;S<C.length;S++)D=C[S],N.hasClass(D)?N.removeClass(D):N.addClass(D);else(h===void 0||z==="boolean")&&(D=no(this),D&&_e.set(this,"__className__",D),this.setAttribute&&this.setAttribute("class",D||h===!1?"":_e.get(this,"__className__")||""))}))},hasClass:function(h){var b,C,D=0;for(b=" "+h+" ";C=this[D++];)if(C.nodeType===1&&(" "+to(no(C))+" ").indexOf(b)>-1)return!0;return!1}});var sd=/\r/g;x.fn.extend({val:function(h){var b,C,D,S=this[0];return arguments.length?(D=Q(h),this.each(function(N){var z;this.nodeType===1&&(D?z=h.call(this,N,x(this).val()):z=h,z==null?z="":typeof z=="number"?z+="":Array.isArray(z)&&(z=x.map(z,function(W){return W==null?"":W+""})),b=x.valHooks[this.type]||x.valHooks[this.nodeName.toLowerCase()],(!b||!("set"in b)||b.set(this,z,"value")===void 0)&&(this.value=z))})):S?(b=x.valHooks[S.type]||x.valHooks[S.nodeName.toLowerCase()],b&&"get"in b&&(C=b.get(S,"value"))!==void 0?C:(C=S.value,typeof C=="string"?C.replace(sd,""):C??"")):void 0}}),x.extend({valHooks:{option:{get:function(h){var b=x.find.attr(h,"value");return b??to(x.text(h))}},select:{get:function(h){var b,C,D,S=h.options,N=h.selectedIndex,z=h.type==="select-one",W=z?null:[],U=z?N+1:S.length;for(N<0?D=U:D=z?N:0;D<U;D++)if(C=S[D],(C.selected||D===N)&&!C.disabled&&(!C.parentNode.disabled||!he(C.parentNode,"optgroup"))){if(b=x(C).val(),z)return b;W.push(b)}return W},set:function(h,b){for(var C,D,S=h.options,N=x.makeArray(b),z=S.length;z--;)D=S[z],(D.selected=x.inArray(x.valHooks.option.get(D),N)>-1)&&(C=!0);return C||(h.selectedIndex=-1),N}}}}),x.each(["radio","checkbox"],function(){x.valHooks[this]={set:function(h,b){if(Array.isArray(b))return h.checked=x.inArray(x(h).val(),b)>-1}},q.checkOn||(x.valHooks[this].get=function(h){return h.getAttribute("value")===null?"on":h.value})});var ti=d.location,Go={guid:Date.now()},Cs=/\?/;x.parseXML=function(h){var b,C;if(!h||typeof h!="string")return null;try{b=new d.DOMParser().parseFromString(h,"text/xml")}catch{}return C=b&&b.getElementsByTagName("parsererror")[0],(!b||C)&&x.error("Invalid XML: "+(C?x.map(C.childNodes,function(D){return D.textContent}).join(`
`):h)),b};var Xa=/^(?:focusinfocus|focusoutblur)$/,io=function(h){h.stopPropagation()};x.extend(x.event,{trigger:function(h,b,C,D){var S,N,z,W,U,Y,ee,ae,J=[C||ie],de=B.call(h,"type")?h.type:h,Be=B.call(h,"namespace")?h.namespace.split("."):[];if(N=ae=z=C=C||ie,!(C.nodeType===3||C.nodeType===8)&&!Xa.test(de+x.event.triggered)&&(de.indexOf(".")>-1&&(Be=de.split("."),de=Be.shift(),Be.sort()),U=de.indexOf(":")<0&&"on"+de,h=h[x.expando]?h:new x.Event(de,typeof h=="object"&&h),h.isTrigger=D?2:3,h.namespace=Be.join("."),h.rnamespace=h.namespace?new RegExp("(^|\\.)"+Be.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,h.result=void 0,h.target||(h.target=C),b=b==null?[h]:x.makeArray(b,[h]),ee=x.event.special[de]||{},!(!D&&ee.trigger&&ee.trigger.apply(C,b)===!1))){if(!D&&!ee.noBubble&&!se(C)){for(W=ee.delegateType||de,Xa.test(W+de)||(N=N.parentNode);N;N=N.parentNode)J.push(N),z=N;z===(C.ownerDocument||ie)&&J.push(z.defaultView||z.parentWindow||d)}for(S=0;(N=J[S++])&&!h.isPropagationStopped();)ae=N,h.type=S>1?W:ee.bindType||de,Y=(_e.get(N,"events")||Object.create(null))[h.type]&&_e.get(N,"handle"),Y&&Y.apply(N,b),Y=U&&N[U],Y&&Y.apply&&en(N)&&(h.result=Y.apply(N,b),h.result===!1&&h.preventDefault());return h.type=de,!D&&!h.isDefaultPrevented()&&(!ee._default||ee._default.apply(J.pop(),b)===!1)&&en(C)&&U&&Q(C[de])&&!se(C)&&(z=C[U],z&&(C[U]=null),x.event.triggered=de,h.isPropagationStopped()&&ae.addEventListener(de,io),C[de](),h.isPropagationStopped()&&ae.removeEventListener(de,io),x.event.triggered=void 0,z&&(C[U]=z)),h.result}},simulate:function(h,b,C){var D=x.extend(new x.Event,C,{type:h,isSimulated:!0});x.event.trigger(D,null,b)}}),x.fn.extend({trigger:function(h,b){return this.each(function(){x.event.trigger(h,b,this)})},triggerHandler:function(h,b){var C=this[0];if(C)return x.event.trigger(h,b,C,!0)}});var $o=/\[\]$/,el=/\r?\n/g,Er=/^(?:submit|button|image|reset|file)$/i,As=/^(?:input|select|textarea|keygen)/i;function ys(h,b,C,D){var S;if(Array.isArray(b))x.each(b,function(N,z){C||$o.test(h)?D(h,z):ys(h+"["+(typeof z=="object"&&z!=null?N:"")+"]",z,C,D)});else if(!C&&Ee(b)==="object")for(S in b)ys(h+"["+S+"]",b[S],C,D);else D(h,b)}x.param=function(h,b){var C,D=[],S=function(N,z){var W=Q(z)?z():z;D[D.length]=encodeURIComponent(N)+"="+encodeURIComponent(W??"")};if(h==null)return"";if(Array.isArray(h)||h.jquery&&!x.isPlainObject(h))x.each(h,function(){S(this.name,this.value)});else for(C in h)ys(C,h[C],b,S);return D.join("&")},x.fn.extend({serialize:function(){return x.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var h=x.prop(this,"elements");return h?x.makeArray(h):this}).filter(function(){var h=this.type;return this.name&&!x(this).is(":disabled")&&As.test(this.nodeName)&&!Er.test(h)&&(this.checked||!Xi.test(h))}).map(function(h,b){var C=x(this).val();return C==null?null:Array.isArray(C)?x.map(C,function(D){return{name:b.name,value:D.replace(el,`\r
`)}}):{name:b.name,value:C.replace(el,`\r
`)}}).get()}});var xs=/%20/g,vo=/#.*$/,ad=/([?&])_=[^&]*/,ld=/^(.*?):[ \t]*([^\r\n]*)$/mg,tl=/^(?:about|app|app-storage|.+-extension|file|res|widget):$/,nl=/^(?:GET|HEAD)$/,cd=/^\/\//,il={},Yo={},ol="*/".concat("*"),Tr=ie.createElement("a");Tr.href=ti.href;function Ds(h){return function(b,C){typeof b!="string"&&(C=b,b="*");var D,S=0,N=b.toLowerCase().match(jn)||[];if(Q(C))for(;D=N[S++];)D[0]==="+"?(D=D.slice(1)||"*",(h[D]=h[D]||[]).unshift(C)):(h[D]=h[D]||[]).push(C)}}function Es(h,b,C,D){var S={},N=h===Yo;function z(W){var U;return S[W]=!0,x.each(h[W]||[],function(Y,ee){var ae=ee(b,C,D);if(typeof ae=="string"&&!N&&!S[ae])return b.dataTypes.unshift(ae),z(ae),!1;if(N)return!(U=ae)}),U}return z(b.dataTypes[0])||!S["*"]&&z("*")}function oo(h,b){var C,D,S=x.ajaxSettings.flatOptions||{};for(C in b)b[C]!==void 0&&((S[C]?h:D||(D={}))[C]=b[C]);return D&&x.extend(!0,h,D),h}function dd(h,b,C){for(var D,S,N,z,W=h.contents,U=h.dataTypes;U[0]==="*";)U.shift(),D===void 0&&(D=h.mimeType||b.getResponseHeader("Content-Type"));if(D){for(S in W)if(W[S]&&W[S].test(D)){U.unshift(S);break}}if(U[0]in C)N=U[0];else{for(S in C){if(!U[0]||h.converters[S+" "+U[0]]){N=S;break}z||(z=S)}N=N||z}if(N)return N!==U[0]&&U.unshift(N),C[N]}function ud(h,b,C,D){var S,N,z,W,U,Y={},ee=h.dataTypes.slice();if(ee[1])for(z in h.converters)Y[z.toLowerCase()]=h.converters[z];for(N=ee.shift();N;)if(h.responseFields[N]&&(C[h.responseFields[N]]=b),!U&&D&&h.dataFilter&&(b=h.dataFilter(b,h.dataType)),U=N,N=ee.shift(),N){if(N==="*")N=U;else if(U!=="*"&&U!==N){if(z=Y[U+" "+N]||Y["* "+N],!z){for(S in Y)if(W=S.split(" "),W[1]===N&&(z=Y[U+" "+W[0]]||Y["* "+W[0]],z)){z===!0?z=Y[S]:Y[S]!==!0&&(N=W[0],ee.unshift(W[1]));break}}if(z!==!0)if(z&&h.throws)b=z(b);else try{b=z(b)}catch(ae){return{state:"parsererror",error:z?ae:"No conversion from "+U+" to "+N}}}}return{state:"success",data:b}}x.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:ti.href,type:"GET",isLocal:tl.test(ti.protocol),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":ol,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/\bxml\b/,html:/\bhtml/,json:/\bjson\b/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":JSON.parse,"text xml":x.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(h,b){return b?oo(oo(h,x.ajaxSettings),b):oo(x.ajaxSettings,h)},ajaxPrefilter:Ds(il),ajaxTransport:Ds(Yo),ajax:function(h,b){typeof h=="object"&&(b=h,h=void 0),b=b||{};var C,D,S,N,z,W,U,Y,ee,ae,J=x.ajaxSetup({},b),de=J.context||J,Be=J.context&&(de.nodeType||de.jquery)?x(de):x.event,Je=x.Deferred(),Ue=x.Callbacks("once memory"),qt=J.statusCode||{},At={},ni={},Vn="canceled",Ge={readyState:0,getResponseHeader:function(Xe){var xt;if(U){if(!N)for(N={};xt=ld.exec(S);)N[xt[1].toLowerCase()+" "]=(N[xt[1].toLowerCase()+" "]||[]).concat(xt[2]);xt=N[Xe.toLowerCase()+" "]}return xt==null?null:xt.join(", ")},getAllResponseHeaders:function(){return U?S:null},setRequestHeader:function(Xe,xt){return U==null&&(Xe=ni[Xe.toLowerCase()]=ni[Xe.toLowerCase()]||Xe,At[Xe]=xt),this},overrideMimeType:function(Xe){return U==null&&(J.mimeType=Xe),this},statusCode:function(Xe){var xt;if(Xe)if(U)Ge.always(Xe[Ge.status]);else for(xt in Xe)qt[xt]=[qt[xt],Xe[xt]];return this},abort:function(Xe){var xt=Xe||Vn;return C&&C.abort(xt),Ii(0,xt),this}};if(Je.promise(Ge),J.url=((h||J.url||ti.href)+"").replace(cd,ti.protocol+"//"),J.type=b.method||b.type||J.method||J.type,J.dataTypes=(J.dataType||"*").toLowerCase().match(jn)||[""],J.crossDomain==null){W=ie.createElement("a");try{W.href=J.url,W.href=W.href,J.crossDomain=Tr.protocol+"//"+Tr.host!=W.protocol+"//"+W.host}catch{J.crossDomain=!0}}if(J.data&&J.processData&&typeof J.data!="string"&&(J.data=x.param(J.data,J.traditional)),Es(il,J,b,Ge),U)return Ge;Y=x.event&&J.global,Y&&x.active++===0&&x.event.trigger("ajaxStart"),J.type=J.type.toUpperCase(),J.hasContent=!nl.test(J.type),D=J.url.replace(vo,""),J.hasContent?J.data&&J.processData&&(J.contentType||"").indexOf("application/x-www-form-urlencoded")===0&&(J.data=J.data.replace(xs,"+")):(ae=J.url.slice(D.length),J.data&&(J.processData||typeof J.data=="string")&&(D+=(Cs.test(D)?"&":"?")+J.data,delete J.data),J.cache===!1&&(D=D.replace(ad,"$1"),ae=(Cs.test(D)?"&":"?")+"_="+Go.guid+++ae),J.url=D+ae),J.ifModified&&(x.lastModified[D]&&Ge.setRequestHeader("If-Modified-Since",x.lastModified[D]),x.etag[D]&&Ge.setRequestHeader("If-None-Match",x.etag[D])),(J.data&&J.hasContent&&J.contentType!==!1||b.contentType)&&Ge.setRequestHeader("Content-Type",J.contentType),Ge.setRequestHeader("Accept",J.dataTypes[0]&&J.accepts[J.dataTypes[0]]?J.accepts[J.dataTypes[0]]+(J.dataTypes[0]!=="*"?", "+ol+"; q=0.01":""):J.accepts["*"]);for(ee in J.headers)Ge.setRequestHeader(ee,J.headers[ee]);if(J.beforeSend&&(J.beforeSend.call(de,Ge,J)===!1||U))return Ge.abort();if(Vn="abort",Ue.add(J.complete),Ge.done(J.success),Ge.fail(J.error),C=Es(Yo,J,b,Ge),!C)Ii(-1,"No Transport");else{if(Ge.readyState=1,Y&&Be.trigger("ajaxSend",[Ge,J]),U)return Ge;J.async&&J.timeout>0&&(z=d.setTimeout(function(){Ge.abort("timeout")},J.timeout));try{U=!1,C.send(At,Ii)}catch(Xe){if(U)throw Xe;Ii(-1,Xe)}}function Ii(Xe,xt,_o,Ms){var Hn,Qo,Un,ii,Mi,wn=xt;U||(U=!0,z&&d.clearTimeout(z),C=void 0,S=Ms||"",Ge.readyState=Xe>0?4:0,Hn=Xe>=200&&Xe<300||Xe===304,_o&&(ii=dd(J,Ge,_o)),!Hn&&x.inArray("script",J.dataTypes)>-1&&x.inArray("json",J.dataTypes)<0&&(J.converters["text script"]=function(){}),ii=ud(J,ii,Ge,Hn),Hn?(J.ifModified&&(Mi=Ge.getResponseHeader("Last-Modified"),Mi&&(x.lastModified[D]=Mi),Mi=Ge.getResponseHeader("etag"),Mi&&(x.etag[D]=Mi)),Xe===204||J.type==="HEAD"?wn="nocontent":Xe===304?wn="notmodified":(wn=ii.state,Qo=ii.data,Un=ii.error,Hn=!Un)):(Un=wn,(Xe||!wn)&&(wn="error",Xe<0&&(Xe=0))),Ge.status=Xe,Ge.statusText=(xt||wn)+"",Hn?Je.resolveWith(de,[Qo,wn,Ge]):Je.rejectWith(de,[Ge,wn,Un]),Ge.statusCode(qt),qt=void 0,Y&&Be.trigger(Hn?"ajaxSuccess":"ajaxError",[Ge,J,Hn?Qo:Un]),Ue.fireWith(de,[Ge,wn]),Y&&(Be.trigger("ajaxComplete",[Ge,J]),--x.active||x.event.trigger("ajaxStop")))}return Ge},getJSON:function(h,b,C){return x.get(h,b,C,"json")},getScript:function(h,b){return x.get(h,void 0,b,"script")}}),x.each(["get","post"],function(h,b){x[b]=function(C,D,S,N){return Q(D)&&(N=N||S,S=D,D=void 0),x.ajax(x.extend({url:C,type:b,dataType:N,data:D,success:S},x.isPlainObject(C)&&C))}}),x.ajaxPrefilter(function(h){var b;for(b in h.headers)b.toLowerCase()==="content-type"&&(h.contentType=h.headers[b]||"")}),x._evalUrl=function(h,b,C){return x.ajax({url:h,type:"GET",dataType:"script",cache:!0,async:!1,global:!1,converters:{"text script":function(){}},dataFilter:function(D){x.globalEval(D,b,C)}})},x.fn.extend({wrapAll:function(h){var b;return this[0]&&(Q(h)&&(h=h.call(this[0])),b=x(h,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&b.insertBefore(this[0]),b.map(function(){for(var C=this;C.firstElementChild;)C=C.firstElementChild;return C}).append(this)),this},wrapInner:function(h){return Q(h)?this.each(function(b){x(this).wrapInner(h.call(this,b))}):this.each(function(){var b=x(this),C=b.contents();C.length?C.wrapAll(h):b.append(h)})},wrap:function(h){var b=Q(h);return this.each(function(C){x(this).wrapAll(b?h.call(this,C):h)})},unwrap:function(h){return this.parent(h).not("body").each(function(){x(this).replaceWith(this.childNodes)}),this}}),x.expr.pseudos.hidden=function(h){return!x.expr.pseudos.visible(h)},x.expr.pseudos.visible=function(h){return!!(h.offsetWidth||h.offsetHeight||h.getClientRects().length)},x.ajaxSettings.xhr=function(){try{return new d.XMLHttpRequest}catch{}};var Ts={0:200,1223:204},Ko=x.ajaxSettings.xhr();q.cors=!!Ko&&"withCredentials"in Ko,q.ajax=Ko=!!Ko,x.ajaxTransport(function(h){var b,C;if(q.cors||Ko&&!h.crossDomain)return{send:function(D,S){var N,z=h.xhr();if(z.open(h.type,h.url,h.async,h.username,h.password),h.xhrFields)for(N in h.xhrFields)z[N]=h.xhrFields[N];h.mimeType&&z.overrideMimeType&&z.overrideMimeType(h.mimeType),!h.crossDomain&&!D["X-Requested-With"]&&(D["X-Requested-With"]="XMLHttpRequest");for(N in D)z.setRequestHeader(N,D[N]);b=function(W){return function(){b&&(b=C=z.onload=z.onerror=z.onabort=z.ontimeout=z.onreadystatechange=null,W==="abort"?z.abort():W==="error"?typeof z.status!="number"?S(0,"error"):S(z.status,z.statusText):S(Ts[z.status]||z.status,z.statusText,(z.responseType||"text")!=="text"||typeof z.responseText!="string"?{binary:z.response}:{text:z.responseText},z.getAllResponseHeaders()))}},z.onload=b(),C=z.onerror=z.ontimeout=b("error"),z.onabort!==void 0?z.onabort=C:z.onreadystatechange=function(){z.readyState===4&&d.setTimeout(function(){b&&C()})},b=b("abort");try{z.send(h.hasContent&&h.data||null)}catch(W){if(b)throw W}},abort:function(){b&&b()}}}),x.ajaxPrefilter(function(h){h.crossDomain&&(h.contents.script=!1)}),x.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/\b(?:java|ecma)script\b/},converters:{"text script":function(h){return x.globalEval(h),h}}}),x.ajaxPrefilter("script",function(h){h.cache===void 0&&(h.cache=!1),h.crossDomain&&(h.type="GET")}),x.ajaxTransport("script",function(h){if(h.crossDomain||h.scriptAttrs){var b,C;return{send:function(D,S){b=x("<script>").attr(h.scriptAttrs||{}).prop({charset:h.scriptCharset,src:h.url}).on("load error",C=function(N){b.remove(),C=null,N&&S(N.type==="error"?404:200,N.type)}),ie.head.appendChild(b[0])},abort:function(){C&&C()}}}});var Ss=[],ft=/(=)\?(?=&|$)|\?\?/;x.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var h=Ss.pop()||x.expando+"_"+Go.guid++;return this[h]=!0,h}}),x.ajaxPrefilter("json jsonp",function(h,b,C){var D,S,N,z=h.jsonp!==!1&&(ft.test(h.url)?"url":typeof h.data=="string"&&(h.contentType||"").indexOf("application/x-www-form-urlencoded")===0&&ft.test(h.data)&&"data");if(z||h.dataTypes[0]==="jsonp")return D=h.jsonpCallback=Q(h.jsonpCallback)?h.jsonpCallback():h.jsonpCallback,z?h[z]=h[z].replace(ft,"$1"+D):h.jsonp!==!1&&(h.url+=(Cs.test(h.url)?"&":"?")+h.jsonp+"="+D),h.converters["script json"]=function(){return N||x.error(D+" was not called"),N[0]},h.dataTypes[0]="json",S=d[D],d[D]=function(){N=arguments},C.always(function(){S===void 0?x(d).removeProp(D):d[D]=S,h[D]&&(h.jsonpCallback=b.jsonpCallback,Ss.push(D)),N&&Q(S)&&S(N[0]),N=S=void 0}),"script"}),q.createHTMLDocument=function(){var h=ie.implementation.createHTMLDocument("").body;return h.innerHTML="<form></form><form></form>",h.childNodes.length===2}(),x.parseHTML=function(h,b,C){if(typeof h!="string")return[];typeof b=="boolean"&&(C=b,b=!1);var D,S,N;return b||(q.createHTMLDocument?(b=ie.implementation.createHTMLDocument(""),D=b.createElement("base"),D.href=ie.location.href,b.head.appendChild(D)):b=ie),S=xn.exec(h),N=!C&&[],S?[b.createElement(S[1])]:(S=rn([h],b,N),N&&N.length&&x(N).remove(),x.merge([],S.childNodes))},x.fn.load=function(h,b,C){var D,S,N,z=this,W=h.indexOf(" ");return W>-1&&(D=to(h.slice(W)),h=h.slice(0,W)),Q(b)?(C=b,b=void 0):b&&typeof b=="object"&&(S="POST"),z.length>0&&x.ajax({url:h,type:S||"GET",dataType:"html",data:b}).done(function(U){N=arguments,z.html(D?x("<div>").append(x.parseHTML(U)).find(D):U)}).always(C&&function(U,Y){z.each(function(){C.apply(this,N||[U.responseText,Y,U])})}),this},x.expr.pseudos.animated=function(h){return x.grep(x.timers,function(b){return h===b.elem}).length},x.offset={setOffset:function(h,b,C){var D,S,N,z,W,U,Y,ee=x.css(h,"position"),ae=x(h),J={};ee==="static"&&(h.style.position="relative"),W=ae.offset(),N=x.css(h,"top"),U=x.css(h,"left"),Y=(ee==="absolute"||ee==="fixed")&&(N+U).indexOf("auto")>-1,Y?(D=ae.position(),z=D.top,S=D.left):(z=parseFloat(N)||0,S=parseFloat(U)||0),Q(b)&&(b=b.call(h,C,x.extend({},W))),b.top!=null&&(J.top=b.top-W.top+z),b.left!=null&&(J.left=b.left-W.left+S),"using"in b?b.using.call(h,J):ae.css(J)}},x.fn.extend({offset:function(h){if(arguments.length)return h===void 0?this:this.each(function(S){x.offset.setOffset(this,h,S)});var b,C,D=this[0];if(D)return D.getClientRects().length?(b=D.getBoundingClientRect(),C=D.ownerDocument.defaultView,{top:b.top+C.pageYOffset,left:b.left+C.pageXOffset}):{top:0,left:0}},position:function(){if(this[0]){var h,b,C,D=this[0],S={top:0,left:0};if(x.css(D,"position")==="fixed")b=D.getBoundingClientRect();else{for(b=this.offset(),C=D.ownerDocument,h=D.offsetParent||C.documentElement;h&&(h===C.body||h===C.documentElement)&&x.css(h,"position")==="static";)h=h.parentNode;h&&h!==D&&h.nodeType===1&&(S=x(h).offset(),S.top+=x.css(h,"borderTopWidth",!0),S.left+=x.css(h,"borderLeftWidth",!0))}return{top:b.top-S.top-x.css(D,"marginTop",!0),left:b.left-S.left-x.css(D,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){for(var h=this.offsetParent;h&&x.css(h,"position")==="static";)h=h.offsetParent;return h||Ei})}}),x.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(h,b){var C=b==="pageYOffset";x.fn[h]=function(D){return Fn(this,function(S,N,z){var W;if(se(S)?W=S:S.nodeType===9&&(W=S.defaultView),z===void 0)return W?W[b]:S[N];W?W.scrollTo(C?W.pageXOffset:z,C?z:W.pageYOffset):S[N]=z},h,D,arguments.length)}}),x.each(["top","left"],function(h,b){x.cssHooks[b]=Ga(q.pixelPosition,function(C,D){if(D)return D=wo(C,b),gs.test(D)?x(C).position()[b]+"px":D})}),x.each({Height:"height",Width:"width"},function(h,b){x.each({padding:"inner"+h,content:b,"":"outer"+h},function(C,D){x.fn[D]=function(S,N){var z=arguments.length&&(C||typeof S!="boolean"),W=C||(S===!0||N===!0?"margin":"border");return Fn(this,function(U,Y,ee){var ae;return se(U)?D.indexOf("outer")===0?U["inner"+h]:U.document.documentElement["client"+h]:U.nodeType===9?(ae=U.documentElement,Math.max(U.body["scroll"+h],ae["scroll"+h],U.body["offset"+h],ae["offset"+h],ae["client"+h])):ee===void 0?x.css(U,Y,W):x.style(U,Y,ee,W)},b,z?S:void 0,z)}})}),x.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(h,b){x.fn[b]=function(C){return this.on(b,C)}}),x.fn.extend({bind:function(h,b,C){return this.on(h,null,b,C)},unbind:function(h,b){return this.off(h,null,b)},delegate:function(h,b,C,D){return this.on(b,h,C,D)},undelegate:function(h,b,C){return arguments.length===1?this.off(h,"**"):this.off(b,h||"**",C)},hover:function(h,b){return this.on("mouseenter",h).on("mouseleave",b||h)}}),x.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "),function(h,b){x.fn[b]=function(C,D){return arguments.length>0?this.on(b,null,C,D):this.trigger(b)}});var hd=/^[\s\uFEFF\xA0]+|([^\s\uFEFF\xA0])[\s\uFEFF\xA0]+$/g;x.proxy=function(h,b){var C,D,S;if(typeof b=="string"&&(C=h[b],b=h,h=C),!!Q(h))return D=A.call(arguments,2),S=function(){return h.apply(b||this,D.concat(A.call(arguments)))},S.guid=h.guid=h.guid||x.guid++,S},x.holdReady=function(h){h?x.readyWait++:x.ready(!0)},x.isArray=Array.isArray,x.parseJSON=JSON.parse,x.nodeName=he,x.isFunction=Q,x.isWindow=se,x.camelCase=Jn,x.type=Ee,x.now=Date.now,x.isNumeric=function(h){var b=x.type(h);return(b==="number"||b==="string")&&!isNaN(h-parseFloat(h))},x.trim=function(h){return h==null?"":(h+"").replace(hd,"$1")};var Is=d.jQuery,rl=d.$;return x.noConflict=function(h){return d.$===x&&(d.$=rl),h&&d.jQuery===x&&(d.jQuery=Is),x},typeof g>"u"&&(d.jQuery=d.$=x),x})})(yv);var mT=yv.exports;const bT=Av(mT);/*! DataTables 1.13.11
 * ©2008-2024 SpryMedia Ltd - datatables.net/license
 */var F=bT,ce=function(l,d){if(ce.factory(l,d))return ce;if(this instanceof ce)return F(l).DataTable(d);d=l,this.$=function(_,y){return this.api(!0).$(_,y)},this._=function(_,y){return this.api(!0).rows(_,y).data()},this.api=function(_){return _?new et(yc(this[Ut.iApiIndex])):new et(this)},this.fnAddData=function(_,y){var k=this.api(!0),T=Array.isArray(_)&&(Array.isArray(_[0])||F.isPlainObject(_[0]))?k.rows.add(_):k.row.add(_);return(y===void 0||y)&&k.draw(),T.flatten().toArray()},this.fnAdjustColumnSizing=function(_){var y=this.api(!0).columns.adjust(),k=y.settings()[0],T=k.oScroll;_===void 0||_?y.draw(!1):(T.sX!==""||T.sY!=="")&&jc(k)},this.fnClearTable=function(_){var y=this.api(!0).clear();(_===void 0||_)&&y.draw()},this.fnClose=function(_){this.api(!0).row(_).child.hide()},this.fnDeleteRow=function(_,y,k){var T=this.api(!0),M=T.rows(_),B=M.settings()[0],P=B.aoData[M[0][0]];return M.remove(),y&&y.call(this,B,P),(k===void 0||k)&&T.draw(),P},this.fnDestroy=function(_){this.api(!0).destroy(_)},this.fnDraw=function(_){this.api(!0).draw(_)},this.fnFilter=function(_,y,k,T,M,B){var P=this.api(!0);y==null?P.search(_,k,T,B):P.column(y).search(_,k,T,B),P.draw()},this.fnGetData=function(_,y){var k=this.api(!0);if(_!==void 0){var T=_.nodeName?_.nodeName.toLowerCase():"";return y!==void 0||T=="td"||T=="th"?k.cell(_,y).data():k.row(_).data()||null}return k.data().toArray()},this.fnGetNodes=function(_){var y=this.api(!0);return _!==void 0?y.row(_).node():y.rows().nodes().flatten().toArray()},this.fnGetPosition=function(_){var y=this.api(!0),k=_.nodeName.toUpperCase();if(k=="TR")return y.row(_).index();if(k=="TD"||k=="TH"){var T=y.cell(_).index();return[T.row,T.columnVisible,T.column]}return null},this.fnIsOpen=function(_){return this.api(!0).row(_).child.isShown()},this.fnOpen=function(_,y,k){return this.api(!0).row(_).child(y,k).show().child()[0]},this.fnPageChange=function(_,y){var k=this.api(!0).page(_);(y===void 0||y)&&k.draw(!1)},this.fnSetColumnVis=function(_,y,k){var T=this.api(!0).column(_).visible(y);(k===void 0||k)&&T.columns.adjust().draw()},this.fnSettings=function(){return yc(this[Ut.iApiIndex])},this.fnSort=function(_){this.api(!0).order(_).draw()},this.fnSortListener=function(_,y,k){this.api(!0).order.listener(_,y,k)},this.fnUpdate=function(_,y,k,T,M){var B=this.api(!0);return k==null?B.row(y).data(_):B.cell(y,k).data(_),(M===void 0||M)&&B.columns.adjust(),(T===void 0||T)&&B.draw(),0},this.fnVersionCheck=Ut.fnVersionCheck;var g=this,p=d===void 0,w=this.length;p&&(d={}),this.oApi=this.internal=Ut.internal;for(var A in ce.ext.internal)A&&(this[A]=f0(A));return this.each(function(){var _={},y=w>1?Ah(_,d,!0):d,k=0,T,M=this.getAttribute("id"),B=!1,P=ce.defaults,O=F(this);if(this.nodeName.toLowerCase()!="table"){gi(null,0,"Non-table node initialisation ("+this.nodeName+")",2);return}lv(P),Iv(P.column),ho(P,P,!0),ho(P.column,P.column,!0),ho(P,F.extend(y,O.data()),!0);var q=ce.settings;for(k=0,T=q.length;k<T;k++){var Q=q[k];if(Q.nTable==this||Q.nTHead&&Q.nTHead.parentNode==this||Q.nTFoot&&Q.nTFoot.parentNode==this){var se=y.bRetrieve!==void 0?y.bRetrieve:P.bRetrieve,ie=y.bDestroy!==void 0?y.bDestroy:P.bDestroy;if(p||se)return Q.oInstance;if(ie){Q.oInstance.fnDestroy();break}else{gi(Q,0,"Cannot reinitialise DataTable",3);return}}if(Q.sTableId==this.id){q.splice(k,1);break}}(M===null||M==="")&&(M="DataTables_Table_"+ce.ext._unique++,this.id=M);var K=F.extend(!0,{},ce.models.oSettings,{sDestroyWidth:O[0].style.width,sInstance:M,sTableId:M});K.nTable=this,K.oApi=g.internal,K.oInit=y,q.push(K),K.oInstance=g.length===1?g:O.dataTable(),lv(y),kh(y.oLanguage),y.aLengthMenu&&!y.iDisplayLength&&(y.iDisplayLength=Array.isArray(y.aLengthMenu[0])?y.aLengthMenu[0][0]:y.aLengthMenu[0]),y=Ah(F.extend(!0,{},P),y),Di(K.oFeatures,y,["bPaginate","bLengthChange","bFilter","bSort","bSortMulti","bInfo","bProcessing","bAutoWidth","bSortClasses","bServerSide","bDeferRender"]),Di(K,y,["asStripeClasses","ajax","fnServerData","fnFormatNumber","sServerMethod","aaSorting","aaSortingFixed","aLengthMenu","sPaginationType","sAjaxSource","sAjaxDataProp","iStateDuration","sDom","bSortCellsTop","iTabIndex","fnStateLoadCallback","fnStateSaveCallback","renderer","searchDelay","rowId",["iCookieDuration","iStateDuration"],["oSearch","oPreviousSearch"],["aoSearchCols","aoPreSearchCols"],["iDisplayLength","_iDisplayLength"]]),Di(K.oScroll,y,[["sScrollX","sX"],["sScrollXInner","sXInner"],["sScrollY","sY"],["bScrollCollapse","bCollapse"]]),Di(K.oLanguage,y,"fnInfoCallback"),An(K,"aoDrawCallback",y.fnDrawCallback,"user"),An(K,"aoServerParams",y.fnServerParams,"user"),An(K,"aoStateSaveParams",y.fnStateSaveParams,"user"),An(K,"aoStateLoadParams",y.fnStateLoadParams,"user"),An(K,"aoStateLoaded",y.fnStateLoaded,"user"),An(K,"aoRowCallback",y.fnRowCallback,"user"),An(K,"aoRowCreatedCallback",y.fnCreatedRow,"user"),An(K,"aoHeaderCallback",y.fnHeaderCallback,"user"),An(K,"aoFooterCallback",y.fnFooterCallback,"user"),An(K,"aoInitComplete",y.fnInitComplete,"user"),An(K,"aoPreDrawCallback",y.fnPreDrawCallback,"user"),K.rowIdFn=as(y.rowId),Mv(K);var Ae=K.oClasses;if(F.extend(Ae,ce.ext.classes,y.oClasses),O.addClass(Ae.sTable),K.iInitDisplayStart===void 0&&(K.iInitDisplayStart=y.iDisplayStart,K._iDisplayStart=y.iDisplayStart),y.iDeferLoading!==null){K.bDeferLoading=!0;var Ee=Array.isArray(y.iDeferLoading);K._iRecordsDisplay=Ee?y.iDeferLoading[0]:y.iDeferLoading,K._iRecordsTotal=Ee?y.iDeferLoading[1]:y.iDeferLoading}var Se=K.oLanguage;F.extend(!0,Se,y.oLanguage),Se.sUrl?(F.ajax({dataType:"json",url:Se.sUrl,success:function(Me){ho(P.oLanguage,Me),kh(Me),F.extend(!0,Se,Me,K.oInit.oLanguage),ct(K,null,"i18n",[K]),ga(K)},error:function(){ga(K)}}),B=!0):ct(K,null,"i18n",[K]),y.asStripeClasses===null&&(K.asStripeClasses=[Ae.sStripeOdd,Ae.sStripeEven]);var V=K.asStripeClasses,x=O.children("tbody").find("tr").eq(0);F.inArray(!0,F.map(V,function(Me,He){return x.hasClass(Me)}))!==-1&&(F("tbody tr",this).removeClass(V.join(" ")),K.asDestroyStripes=V.slice());var we=[],he,ze=this.getElementsByTagName("thead");if(ze.length!==0&&(_a(K.aoHeader,ze[0]),we=zc(K)),y.aoColumns===null)for(he=[],k=0,T=we.length;k<T;k++)he.push(null);else he=y.aoColumns;for(k=0,T=he.length;k<T;k++)Sh(K,we?we[k]:null);if(Nv(K,y.aoColumnDefs,he,function(Me,He){_c(K,Me,He)}),x.length){var Pe=function(Me,He){return Me.getAttribute("data-"+He)!==null?He:null};F(x[0]).children("th, td").each(function(Me,He){var dt=K.aoColumns[Me];if(dt||gi(K,0,"Incorrect column count",18),dt.mData===Me){var Ce=Pe(He,"sort")||Pe(He,"order"),_t=Pe(He,"filter")||Pe(He,"search");(Ce!==null||_t!==null)&&(dt.mData={_:Me+".display",sort:Ce!==null?Me+".@data-"+Ce:void 0,type:Ce!==null?Me+".@data-"+Ce:void 0,filter:_t!==null?Me+".@data-"+_t:void 0},dt._isArrayHost=!0,_c(K,Me))}})}var Ve=K.oFeatures,me=function(){if(y.aaSorting===void 0){var Me=K.aaSorting;for(k=0,T=Me.length;k<T;k++)Me[k][1]=K.aoColumns[k].asSorting[0]}Ac(K),Ve.bSort&&An(K,"aoDrawCallback",function(){if(K.bSorted){var Nt=ds(K),dn={};F.each(Nt,function(Rn,xn){dn[xn.src]=xn.dir}),ct(K,null,"order",[K,Nt,dn]),t0(K)}}),An(K,"aoDrawCallback",function(){(K.bSorted||mn(K)==="ssp"||Ve.bDeferRender)&&Ac(K)},"sc");var He=O.children("caption").each(function(){this._captionSide=F(this).css("caption-side")}),dt=O.children("thead");dt.length===0&&(dt=F("<thead/>").appendTo(O)),K.nTHead=dt[0];var Ce=O.children("tbody");Ce.length===0&&(Ce=F("<tbody/>").insertAfter(dt)),K.nTBody=Ce[0];var _t=O.children("tfoot");if(_t.length===0&&He.length>0&&(K.oScroll.sX!==""||K.oScroll.sY!=="")&&(_t=F("<tfoot/>").appendTo(O)),_t.length===0||_t.children().length===0?O.addClass(Ae.sNoFooter):_t.length>0&&(K.nTFoot=_t[0],_a(K.aoFooter,K.nTFoot)),y.aaData)for(k=0;k<y.aaData.length;k++)Fo(K,y.aaData[k]);else(K.bDeferLoading||mn(K)=="dom")&&Bc(K,F(K.nTBody).children("tr"));K.aiDisplay=K.aiDisplayMaster.slice(),K.bInitialised=!0,B===!1&&ga(K)};An(K,"aoDrawCallback",Ia,"state_save"),y.bStateSave?(Ve.bStateSave=!0,i0(K,y,me)):me()}),g=null,this},Ut,et,Te,Et,rh={},sv=/[\r\n\u2028]/g,vc=/<.*?>/g,kT=/^\d{2,4}[\.\/\-]\d{1,2}[\.\/\-]\d{1,2}([T ]{1}\d{1,2}[:\.]\d{2}([\.:]\d{2})?)?$/,wT=new RegExp("(\\"+["/",".","*","+","?","|","(",")","[","]","{","}","\\","$","^","-"].join("|\\")+")","g"),mh=/['\u00A0,$£€¥%\u2009\u202F\u20BD\u20a9\u20BArfkɃΞ]/gi,Yi=function(l){return!l||l===!0||l==="-"},xv=function(l){var d=parseInt(l,10);return!isNaN(d)&&isFinite(l)?d:null},Dv=function(l,d){return rh[d]||(rh[d]=new RegExp(Lh(d),"g")),typeof l=="string"&&d!=="."?l.replace(/\./g,"").replace(rh[d],"."):l},bh=function(l,d,g){var p=typeof l,w=p==="string";return p==="number"||p==="bigint"||Yi(l)?!0:(d&&w&&(l=Dv(l,d)),g&&w&&(l=l.replace(mh,"")),!isNaN(parseFloat(l))&&isFinite(l))},vT=function(l){return Yi(l)||typeof l=="string"},av=function(l,d,g){if(Yi(l))return!0;var p=vT(l);return p&&bh(_T(l),d,g)?!0:null},zn=function(l,d,g){var p=[],w=0,A=l.length;if(g!==void 0)for(;w<A;w++)l[w]&&l[w][d]&&p.push(l[w][d][g]);else for(;w<A;w++)l[w]&&p.push(l[w][d]);return p},Ca=function(l,d,g,p){var w=[],A=0,_=d.length;if(p!==void 0)for(;A<_;A++)l[d[A]][g]&&w.push(l[d[A]][g][p]);else for(;A<_;A++)w.push(l[d[A]][g]);return w},os=function(l,d){var g=[],p;d===void 0?(d=0,p=l):(p=d,d=l);for(var w=d;w<p;w++)g.push(w);return g},Ev=function(l){for(var d=[],g=0,p=l.length;g<p;g++)l[g]&&d.push(l[g]);return d},_T=function(l){return l.replace(vc,"").replace(/<script/i,"")},CT=function(l){if(l.length<2)return!0;for(var d=l.slice().sort(),g=d[0],p=1,w=d.length;p<w;p++){if(d[p]===g)return!1;g=d[p]}return!0},Nc=function(l){if(CT(l))return l.slice();var d=[],g,p,w=l.length,A,_=0;e:for(p=0;p<w;p++){for(g=l[p],A=0;A<_;A++)if(d[A]===g)continue e;d.push(g),_++}return d},Tv=function(l,d){if(Array.isArray(d))for(var g=0;g<d.length;g++)Tv(l,d[g]);else l.push(d);return l},Sv=function(l,d){return d===void 0&&(d=0),this.indexOf(l,d)!==-1};Array.isArray||(Array.isArray=function(l){return Object.prototype.toString.call(l)==="[object Array]"});Array.prototype.includes||(Array.prototype.includes=Sv);String.prototype.trim||(String.prototype.trim=function(){return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,"")});String.prototype.includes||(String.prototype.includes=Sv);ce.util={throttle:function(l,d){var g=d!==void 0?d:200,p,w;return function(){var A=this,_=+new Date,y=arguments;p&&_<p+g?(clearTimeout(w),w=setTimeout(function(){p=void 0,l.apply(A,y)},g)):(p=_,l.apply(A,y))}},escapeRegex:function(l){return l.replace(wT,"\\$1")},set:function(l){if(F.isPlainObject(l))return ce.util.set(l._);if(l===null)return function(){};if(typeof l=="function")return function(g,p,w){l(g,"set",p,w)};if(typeof l=="string"&&(l.indexOf(".")!==-1||l.indexOf("[")!==-1||l.indexOf("(")!==-1)){var d=function(g,p,w){for(var A=wh(w),_,y=A[A.length-1],k,T,M,B,P=0,O=A.length-1;P<O;P++){if(A[P]==="__proto__"||A[P]==="constructor")throw new Error("Cannot set prototype values");if(k=A[P].match(aa),T=A[P].match(Xr),k){if(A[P]=A[P].replace(aa,""),g[A[P]]=[],_=A.slice(),_.splice(0,P+1),B=_.join("."),Array.isArray(p))for(var q=0,Q=p.length;q<Q;q++)M={},d(M,p[q],B),g[A[P]].push(M);else g[A[P]]=p;return}else T&&(A[P]=A[P].replace(Xr,""),g=g[A[P]](p));(g[A[P]]===null||g[A[P]]===void 0)&&(g[A[P]]={}),g=g[A[P]]}y.match(Xr)?g=g[y.replace(Xr,"")](p):g[y.replace(aa,"")]=p};return function(g,p){return d(g,p,l)}}else return function(g,p){g[l]=p}},get:function(l){if(F.isPlainObject(l)){var d={};return F.each(l,function(p,w){w&&(d[p]=ce.util.get(w))}),function(p,w,A,_){var y=d[w]||d._;return y!==void 0?y(p,w,A,_):p}}else{if(l===null)return function(p){return p};if(typeof l=="function")return function(p,w,A,_){return l(p,w,A,_)};if(typeof l=="string"&&(l.indexOf(".")!==-1||l.indexOf("[")!==-1||l.indexOf("(")!==-1)){var g=function(p,w,A){var _,y,k,T;if(A!=="")for(var M=wh(A),B=0,P=M.length;B<P;B++){if(_=M[B].match(aa),y=M[B].match(Xr),_){if(M[B]=M[B].replace(aa,""),M[B]!==""&&(p=p[M[B]]),k=[],M.splice(0,B+1),T=M.join("."),Array.isArray(p))for(var O=0,q=p.length;O<q;O++)k.push(g(p[O],w,T));var Q=_[0].substring(1,_[0].length-1);p=Q===""?k:k.join(Q);break}else if(y){M[B]=M[B].replace(Xr,""),p=p[M[B]]();continue}if(p===null||p[M[B]]===null)return null;if(p===void 0||p[M[B]]===void 0)return;p=p[M[B]]}return p};return function(p,w){return g(p,w,l)}}else return function(p,w){return p[l]}}}};function Aa(l){var d="a aa ai ao as b fn i m o s ",g,p,w={};F.each(l,function(A,_){g=A.match(/^([^A-Z]+?)([A-Z])/),g&&d.indexOf(g[1]+" ")!==-1&&(p=A.replace(g[0],g[2].toLowerCase()),w[p]=A,g[1]==="o"&&Aa(l[A]))}),l._hungarianMap=w}function ho(l,d,g){l._hungarianMap||Aa(l);var p;F.each(d,function(w,A){p=l._hungarianMap[w],p!==void 0&&(g||d[p]===void 0)&&(p.charAt(0)==="o"?(d[p]||(d[p]={}),F.extend(!0,d[p],d[w]),ho(l[p],d[p],g)):d[p]=d[w])})}function kh(l){var d=ce.defaults.oLanguage,g=d.sDecimal;if(g&&yh(g),l){var p=l.sZeroRecords;!l.sEmptyTable&&p&&d.sEmptyTable==="No data available in table"&&Di(l,l,"sZeroRecords","sEmptyTable"),!l.sLoadingRecords&&p&&d.sLoadingRecords==="Loading..."&&Di(l,l,"sZeroRecords","sLoadingRecords"),l.sInfoThousands&&(l.sThousands=l.sInfoThousands);var w=l.sDecimal;w&&g!==w&&yh(w)}}var Ln=function(l,d,g){l[d]!==void 0&&(l[g]=l[d])};function lv(l){Ln(l,"ordering","bSort"),Ln(l,"orderMulti","bSortMulti"),Ln(l,"orderClasses","bSortClasses"),Ln(l,"orderCellsTop","bSortCellsTop"),Ln(l,"order","aaSorting"),Ln(l,"orderFixed","aaSortingFixed"),Ln(l,"paging","bPaginate"),Ln(l,"pagingType","sPaginationType"),Ln(l,"pageLength","iDisplayLength"),Ln(l,"searching","bFilter"),typeof l.sScrollX=="boolean"&&(l.sScrollX=l.sScrollX?"100%":""),typeof l.scrollX=="boolean"&&(l.scrollX=l.scrollX?"100%":"");var d=l.aoSearchCols;if(d)for(var g=0,p=d.length;g<p;g++)d[g]&&ho(ce.models.oSearch,d[g])}function Iv(l){Ln(l,"orderable","bSortable"),Ln(l,"orderData","aDataSort"),Ln(l,"orderSequence","asSorting"),Ln(l,"orderDataType","sortDataType");var d=l.aDataSort;typeof d=="number"&&!Array.isArray(d)&&(l.aDataSort=[d])}function Mv(l){if(!ce.__browser){var d={};ce.__browser=d;var g=F("<div/>").css({position:"fixed",top:0,left:F(window).scrollLeft()*-1,height:1,width:1,overflow:"hidden"}).append(F("<div/>").css({position:"absolute",top:1,left:1,width:100,overflow:"scroll"}).append(F("<div/>").css({width:"100%",height:10}))).appendTo("body"),p=g.children(),w=p.children();d.barWidth=p[0].offsetWidth-p[0].clientWidth,d.bScrollOversize=w[0].offsetWidth===100&&p[0].clientWidth!==100,d.bScrollbarLeft=Math.round(w.offset().left)!==1,d.bBounding=!!g[0].getBoundingClientRect().width,g.remove()}F.extend(l.oBrowser,ce.__browser),l.oScroll.iBarWidth=ce.__browser.barWidth}function cv(l,d,g,p,w,A){var _=p,y,k=!1;for(g!==void 0&&(y=g,k=!0);_!==w;)l.hasOwnProperty(_)&&(y=k?d(y,l[_],_,l):l[_],k=!0,_+=A);return y}function Sh(l,d){var g=ce.defaults.column,p=l.aoColumns.length,w=F.extend({},ce.models.oColumn,g,{nTh:d||document.createElement("th"),sTitle:g.sTitle?g.sTitle:d?d.innerHTML:"",aDataSort:g.aDataSort?g.aDataSort:[p],mData:g.mData?g.mData:p,idx:p});l.aoColumns.push(w);var A=l.aoPreSearchCols;A[p]=F.extend({},ce.models.oSearch,A[p]),_c(l,p,F(d).data())}function _c(l,d,g){var p=l.aoColumns[d],w=l.oClasses,A=F(p.nTh);if(!p.sWidthOrig){p.sWidthOrig=A.attr("width")||null;var _=(A.attr("style")||"").match(/width:\s*(\d+[pxem%]+)/);_&&(p.sWidthOrig=_[1])}if(g!=null){Iv(g),ho(ce.defaults.column,g,!0),g.mDataProp!==void 0&&!g.mData&&(g.mData=g.mDataProp),g.sType&&(p._sManualType=g.sType),g.className&&!g.sClass&&(g.sClass=g.className),g.sClass&&A.addClass(g.sClass);var y=p.sClass;F.extend(p,g),Di(p,g,"sWidth","sWidthOrig"),y!==p.sClass&&(p.sClass=y+" "+p.sClass),g.iDataSort!==void 0&&(p.aDataSort=[g.iDataSort]),Di(p,g,"aDataSort"),p.ariaTitle||(p.ariaTitle=A.attr("aria-label"))}var k=p.mData,T=as(k),M=p.mRender?as(p.mRender):null,B=function(q){return typeof q=="string"&&q.indexOf("@")!==-1};p._bAttrSrc=F.isPlainObject(k)&&(B(k.sort)||B(k.type)||B(k.filter)),p._setter=null,p.fnGetData=function(q,Q,se){var ie=T(q,Q,void 0,se);return M&&Q?M(ie,Q,q,se):ie},p.fnSetData=function(q,Q,se){return Ro(k)(q,Q,se)},typeof k!="number"&&!p._isArrayHost&&(l._rowReadObject=!0),l.oFeatures.bSort||(p.bSortable=!1,A.addClass(w.sSortableNone));var P=F.inArray("asc",p.asSorting)!==-1,O=F.inArray("desc",p.asSorting)!==-1;!p.bSortable||!P&&!O?(p.sSortingClass=w.sSortableNone,p.sSortingClassJUI=""):P&&!O?(p.sSortingClass=w.sSortableAsc,p.sSortingClassJUI=w.sSortJUIAscAllowed):!P&&O?(p.sSortingClass=w.sSortableDesc,p.sSortingClassJUI=w.sSortJUIDescAllowed):(p.sSortingClass=w.sSortable,p.sSortingClassJUI=w.sSortJUI)}function ya(l){if(l.oFeatures.bAutoWidth!==!1){var d=l.aoColumns;Oh(l);for(var g=0,p=d.length;g<p;g++)d[g].nTh.style.width=d[g].sWidth}var w=l.oScroll;(w.sY!==""||w.sX!=="")&&jc(l),ct(l,null,"column-sizing",[l])}function xa(l,d){var g=Pc(l,"bVisible");return typeof g[d]=="number"?g[d]:null}function Da(l,d){var g=Pc(l,"bVisible"),p=F.inArray(d,g);return p!==-1?p:null}function cs(l){var d=0;return F.each(l.aoColumns,function(g,p){p.bVisible&&F(p.nTh).css("display")!=="none"&&d++}),d}function Pc(l,d){var g=[];return F.map(l.aoColumns,function(p,w){p[d]&&g.push(w)}),g}function Ih(l){var d=l.aoColumns,g=l.aoData,p=ce.ext.type.detect,w,A,_,y,k,T,M,B,P;for(w=0,A=d.length;w<A;w++)if(M=d[w],P=[],!M.sType&&M._sManualType)M.sType=M._sManualType;else if(!M.sType){for(_=0,y=p.length;_<y;_++){for(k=0,T=g.length;k<T&&(P[k]===void 0&&(P[k]=On(l,k,w,"type")),B=p[_](P[k],l),!(!B&&_!==p.length-1||B==="html"&&!Yi(P[k])));k++);if(B){M.sType=B;break}}M.sType||(M.sType="string")}}function Nv(l,d,g,p){var w,A,_,y,k,T,M,B=l.aoColumns;if(d)for(w=d.length-1;w>=0;w--){M=d[w];var P=M.target!==void 0?M.target:M.targets!==void 0?M.targets:M.aTargets;for(Array.isArray(P)||(P=[P]),_=0,y=P.length;_<y;_++)if(typeof P[_]=="number"&&P[_]>=0){for(;B.length<=P[_];)Sh(l);p(P[_],M)}else if(typeof P[_]=="number"&&P[_]<0)p(B.length+P[_],M);else if(typeof P[_]=="string")for(k=0,T=B.length;k<T;k++)(P[_]=="_all"||F(B[k].nTh).hasClass(P[_]))&&p(k,M)}if(g)for(w=0,A=g.length;w<A;w++)p(w,g[w])}function Fo(l,d,g,p){var w=l.aoData.length,A=F.extend(!0,{},ce.models.oRow,{src:g?"dom":"data",idx:w});A._aData=d,l.aoData.push(A);for(var _=l.aoColumns,y=0,k=_.length;y<k;y++)_[y].sType=null;l.aiDisplayMaster.push(w);var T=l.rowIdFn(d);return T!==void 0&&(l.aIds[T]=A),(g||!l.oFeatures.bDeferRender)&&Nh(l,w,g,p),w}function Bc(l,d){var g;return d instanceof F||(d=F(d)),d.map(function(p,w){return g=Mh(l,w),Fo(l,g.data,w,g.cells)})}function AT(l,d){return d._DT_RowIndex!==void 0?d._DT_RowIndex:null}function yT(l,d,g){return F.inArray(g,l.aoData[d].anCells)}function On(l,d,g,p){p==="search"?p="filter":p==="order"&&(p="sort");var w=l.iDraw,A=l.aoColumns[g],_=l.aoData[d]._aData,y=A.sDefaultContent,k=A.fnGetData(_,p,{settings:l,row:d,col:g});if(k===void 0)return l.iDrawError!=w&&y===null&&(gi(l,0,"Requested unknown parameter "+(typeof A.mData=="function"?"{function}":"'"+A.mData+"'")+" for row "+d+", column "+g,4),l.iDrawError=w),y;if((k===_||k===null)&&y!==null&&p!==void 0)k=y;else if(typeof k=="function")return k.call(_);if(k===null&&p==="display")return"";if(p==="filter"){var T=ce.ext.type.search;T[A.sType]&&(k=T[A.sType](k))}return k}function Pv(l,d,g,p){var w=l.aoColumns[g],A=l.aoData[d]._aData;w.fnSetData(A,p,{settings:l,row:d,col:g})}var aa=/\[.*?\]$/,Xr=/\(\)$/;function wh(l){return F.map(l.match(/(\\.|[^\.])+/g)||[""],function(d){return d.replace(/\\\./g,".")})}var as=ce.util.get,Ro=ce.util.set;function vh(l){return zn(l.aoData,"_aData")}function Lc(l){l.aoData.length=0,l.aiDisplayMaster.length=0,l.aiDisplay.length=0,l.aIds={}}function hc(l,d,g){for(var p=-1,w=0,A=l.length;w<A;w++)l[w]==d?p=w:l[w]>d&&l[w]--;p!=-1&&g===void 0&&l.splice(p,1)}function Ea(l,d,g,p){var w=l.aoData[d],A,_,y=function(M,B){for(;M.childNodes.length;)M.removeChild(M.firstChild);M.innerHTML=On(l,d,B,"display")};if(g==="dom"||(!g||g==="auto")&&w.src==="dom")w._aData=Mh(l,w,p,p===void 0?void 0:w._aData).data;else{var k=w.anCells;if(k)if(p!==void 0)y(k[p],p);else for(A=0,_=k.length;A<_;A++)y(k[A],A)}w._aSortData=null,w._aFilterData=null;var T=l.aoColumns;if(p!==void 0)T[p].sType=null;else{for(A=0,_=T.length;A<_;A++)T[A].sType=null;Ph(l,w)}}function Mh(l,d,g,p){var w=[],A=d.firstChild,_,y,k=0,T,M=l.aoColumns,B=l._rowReadObject;p=p!==void 0?p:B?{}:[];var P=function(K,Ae){if(typeof K=="string"){var Ee=K.indexOf("@");if(Ee!==-1){var Se=K.substring(Ee+1),V=Ro(K);V(p,Ae.getAttribute(Se))}}},O=function(K){if(g===void 0||g===k)if(y=M[k],T=K.innerHTML.trim(),y&&y._bAttrSrc){var Ae=Ro(y.mData._);Ae(p,T),P(y.mData.sort,K),P(y.mData.type,K),P(y.mData.filter,K)}else B?(y._setter||(y._setter=Ro(y.mData)),y._setter(p,T)):p[k]=T;k++};if(A)for(;A;)_=A.nodeName.toUpperCase(),(_=="TD"||_=="TH")&&(O(A),w.push(A)),A=A.nextSibling;else{w=d.anCells;for(var q=0,Q=w.length;q<Q;q++)O(w[q])}var se=d.firstChild?d:d.nTr;if(se){var ie=se.getAttribute("id");ie&&Ro(l.rowId)(p,ie)}return{data:p,cells:w}}function Nh(l,d,g,p){var w=l.aoData[d],A=w._aData,_=[],y,k,T,M,B,P;if(w.nTr===null){for(y=g||document.createElement("tr"),w.nTr=y,w.anCells=_,y._DT_RowIndex=d,Ph(l,w),M=0,B=l.aoColumns.length;M<B;M++)T=l.aoColumns[M],P=!g,k=P?document.createElement(T.sCellType):p[M],k||gi(l,0,"Incorrect column count",18),k._DT_CellIndex={row:d,column:M},_.push(k),(P||(T.mRender||T.mData!==M)&&(!F.isPlainObject(T.mData)||T.mData._!==M+".display"))&&(k.innerHTML=On(l,d,M,"display")),T.sClass&&(k.className+=" "+T.sClass),T.bVisible&&!g?y.appendChild(k):!T.bVisible&&g&&k.parentNode.removeChild(k),T.fnCreatedCell&&T.fnCreatedCell.call(l.oInstance,k,On(l,d,M),A,d,M);ct(l,"aoRowCreatedCallback",null,[y,A,d,_])}}function Ph(l,d){var g=d.nTr,p=d._aData;if(g){var w=l.rowIdFn(p);if(w&&(g.id=w),p.DT_RowClass){var A=p.DT_RowClass.split(" ");d.__rowc=d.__rowc?Nc(d.__rowc.concat(A)):A,F(g).removeClass(d.__rowc.join(" ")).addClass(p.DT_RowClass)}p.DT_RowAttr&&F(g).attr(p.DT_RowAttr),p.DT_RowData&&F(g).data(p.DT_RowData)}}function Bv(l){var d,g,p,w,A,_=l.nTHead,y=l.nTFoot,k=F("th, td",_).length===0,T=l.oClasses,M=l.aoColumns;for(k&&(w=F("<tr/>").appendTo(_)),d=0,g=M.length;d<g;d++)A=M[d],p=F(A.nTh).addClass(A.sClass),k&&p.appendTo(w),l.oFeatures.bSort&&(p.addClass(A.sSortingClass),A.bSortable!==!1&&(p.attr("tabindex",l.iTabIndex).attr("aria-controls",l.sTableId),jh(l,A.nTh,d))),A.sTitle!=p[0].innerHTML&&p.html(A.sTitle),Hh(l,"header")(l,p,A,T);if(k&&_a(l.aoHeader,_),F(_).children("tr").children("th, td").addClass(T.sHeaderTH),F(y).children("tr").children("th, td").addClass(T.sFooterTH),y!==null){var B=l.aoFooter[0];for(d=0,g=B.length;d<g;d++)A=M[d],A?(A.nTf=B[d].cell,A.sClass&&F(A.nTf).addClass(A.sClass)):gi(l,0,"Incorrect column count",18)}}function va(l,d,g){var p,w,A,_,y,k,T,M=[],B=[],P=l.aoColumns.length,O,q;if(d){for(g===void 0&&(g=!1),p=0,w=d.length;p<w;p++){for(M[p]=d[p].slice(),M[p].nTr=d[p].nTr,A=P-1;A>=0;A--)!l.aoColumns[A].bVisible&&!g&&M[p].splice(A,1);B.push([])}for(p=0,w=M.length;p<w;p++){if(T=M[p].nTr,T)for(;k=T.firstChild;)T.removeChild(k);for(A=0,_=M[p].length;A<_;A++)if(O=1,q=1,B[p][A]===void 0){for(T.appendChild(M[p][A].cell),B[p][A]=1;M[p+O]!==void 0&&M[p][A].cell==M[p+O][A].cell;)B[p+O][A]=1,O++;for(;M[p][A+q]!==void 0&&M[p][A].cell==M[p][A+q].cell;){for(y=0;y<O;y++)B[p+y][A+q]=1;q++}F(M[p][A].cell).attr("rowspan",O).attr("colspan",q)}}}}function Vo(l,d){xT(l);var g=ct(l,"aoPreDrawCallback","preDraw",[l]);if(F.inArray(!1,g)!==-1){Zn(l,!1);return}var p=[],w=0,A=l.asStripeClasses,_=A.length,y=l.oLanguage,k=mn(l)=="ssp",T=l.aiDisplay,M=l._iDisplayStart,B=l.fnDisplayEnd();if(l.bDrawing=!0,l.bDeferLoading)l.bDeferLoading=!1,l.iDraw++,Zn(l,!1);else if(!k)l.iDraw++;else if(!l.bDestroying&&!d){zv(l);return}if(T.length!==0)for(var P=k?0:M,O=k?l.aoData.length:B,q=P;q<O;q++){var Q=T[q],se=l.aoData[Q];se.nTr===null&&Nh(l,Q);var ie=se.nTr;if(_!==0){var K=A[w%_];se._sRowStripe!=K&&(F(ie).removeClass(se._sRowStripe).addClass(K),se._sRowStripe=K)}ct(l,"aoRowCallback",null,[ie,se._aData,w,q,Q]),p.push(ie),w++}else{var Ae=y.sZeroRecords;l.iDraw==1&&mn(l)=="ajax"?Ae=y.sLoadingRecords:y.sEmptyTable&&l.fnRecordsTotal()===0&&(Ae=y.sEmptyTable),p[0]=F("<tr/>",{class:_?A[0]:""}).append(F("<td />",{valign:"top",colSpan:cs(l),class:l.oClasses.sRowEmpty}).html(Ae))[0]}ct(l,"aoHeaderCallback","header",[F(l.nTHead).children("tr")[0],vh(l),M,B,T]),ct(l,"aoFooterCallback","footer",[F(l.nTFoot).children("tr")[0],vh(l),M,B,T]);var Ee=F(l.nTBody);Ee.children().detach(),Ee.append(F(p)),ct(l,"aoDrawCallback","draw",[l]),l.bSorted=!1,l.bFiltered=!1,l.bDrawing=!1}function kr(l,d){var g=l.oFeatures,p=g.bSort,w=g.bFilter;p&&e0(l),w?Sa(l,l.oPreviousSearch):l.aiDisplay=l.aiDisplayMaster.slice(),d!==!0&&(l._iDisplayStart=0),l._drawHold=d,Vo(l),l._drawHold=!1}function Lv(l){var d=l.oClasses,g=F(l.nTable),p=F("<div/>").insertBefore(g),w=l.oFeatures,A=F("<div/>",{id:l.sTableId+"_wrapper",class:d.sWrapper+(l.nTFoot?"":" "+d.sNoFooter)});l.nHolding=p[0],l.nTableWrapper=A[0],l.nTableReinsertBefore=l.nTable.nextSibling;for(var _=l.sDom.split(""),y,k,T,M,B,P,O=0;O<_.length;O++){if(y=null,k=_[O],k=="<"){if(T=F("<div/>")[0],M=_[O+1],M=="'"||M=='"'){for(B="",P=2;_[O+P]!=M;)B+=_[O+P],P++;if(B=="H"?B=d.sJUIHeader:B=="F"&&(B=d.sJUIFooter),B.indexOf(".")!=-1){var q=B.split(".");T.id=q[0].substr(1,q[0].length-1),T.className=q[1]}else B.charAt(0)=="#"?T.id=B.substr(1,B.length-1):T.className=B;O+=P}A.append(T),A=F(T)}else if(k==">")A=A.parent();else if(k=="l"&&w.bPaginate&&w.bLengthChange)y=$v(l);else if(k=="f"&&w.bFilter)y=jv(l);else if(k=="r"&&w.bProcessing)y=Kv(l);else if(k=="t")y=Qv(l);else if(k=="i"&&w.bInfo)y=Wv(l);else if(k=="p"&&w.bPaginate)y=Yv(l);else if(ce.ext.feature.length!==0){for(var Q=ce.ext.feature,se=0,ie=Q.length;se<ie;se++)if(k==Q[se].cFeature){y=Q[se].fnInit(l);break}}if(y){var K=l.aanFeatures;K[k]||(K[k]=[]),K[k].push(y),A.append(y)}}p.replaceWith(A),l.nHolding=null}function _a(l,d){var g=F(d).children("tr"),p,w,A,_,y,k,T,M,B,P,O,q=function(Q,se,ie){for(var K=Q[se];K[ie];)ie++;return ie};for(l.splice(0,l.length),A=0,k=g.length;A<k;A++)l.push([]);for(A=0,k=g.length;A<k;A++)for(p=g[A],M=0,w=p.firstChild;w;){if(w.nodeName.toUpperCase()=="TD"||w.nodeName.toUpperCase()=="TH")for(B=w.getAttribute("colspan")*1,P=w.getAttribute("rowspan")*1,B=!B||B===0||B===1?1:B,P=!P||P===0||P===1?1:P,T=q(l,A,M),O=B===1,y=0;y<B;y++)for(_=0;_<P;_++)l[A+_][T+y]={cell:w,unique:O},l[A+_].nTr=p;w=w.nextSibling}}function zc(l,d,g){var p=[];g||(g=l.aoHeader,d&&(g=[],_a(g,d)));for(var w=0,A=g.length;w<A;w++)for(var _=0,y=g[w].length;_<y;_++)g[w][_].unique&&(!p[_]||!l.bSortCellsTop)&&(p[_]=g[w][_].cell);return p}function xT(l){var d=mn(l)=="ssp",g=l.iInitDisplayStart;g!==void 0&&g!==-1&&(l._iDisplayStart=d?g:g>=l.fnRecordsDisplay()?0:g,l.iInitDisplayStart=-1)}function Oc(l,d,g){if(ct(l,"aoServerParams","serverParams",[d]),d&&Array.isArray(d)){var p={},w=/(.*?)\[\]$/;F.each(d,function(B,P){var O=P.name.match(w);if(O){var q=O[0];p[q]||(p[q]=[]),p[q].push(P.value)}else p[P.name]=P.value}),d=p}var A,_=l.ajax,y=l.oInstance,k=function(B){var P=l.jqXHR?l.jqXHR.status:null;(B===null||typeof P=="number"&&P==204)&&(B={},Ta(l,B,[]));var O=B.error||B.sError;O&&gi(l,0,O),l.json=B,ct(l,null,"xhr",[l,B,l.jqXHR]),g(B)};if(F.isPlainObject(_)&&_.data){A=_.data;var T=typeof A=="function"?A(d,l):A;d=typeof A=="function"&&T?T:F.extend(!0,d,T),delete _.data}var M={data:d,success:k,dataType:"json",cache:!1,type:l.sServerMethod,error:function(B,P,O){var q=ct(l,null,"xhr",[l,null,l.jqXHR]);F.inArray(!0,q)===-1&&(P=="parsererror"?gi(l,0,"Invalid JSON response",1):B.readyState===4&&gi(l,0,"Ajax error",7)),Zn(l,!1)}};l.oAjaxData=d,ct(l,null,"preXhr",[l,d]),l.fnServerData?l.fnServerData.call(y,l.sAjaxSource,F.map(d,function(B,P){return{name:P,value:B}}),k,l):l.sAjaxSource||typeof _=="string"?l.jqXHR=F.ajax(F.extend(M,{url:_||l.sAjaxSource})):typeof _=="function"?l.jqXHR=_.call(y,d,k,l):(l.jqXHR=F.ajax(F.extend(M,_)),_.data=A)}function zv(l){l.iDraw++,Zn(l,!0);var d=l._drawHold;Oc(l,Ov(l),function(g){l._drawHold=d,Rv(l,g),l._drawHold=!1})}function Ov(l){var d=l.aoColumns,g=d.length,p=l.oFeatures,w=l.oPreviousSearch,A=l.aoPreSearchCols,_,y=[],k,T,M,B=ds(l),P=l._iDisplayStart,O=p.bPaginate!==!1?l._iDisplayLength:-1,q=function(ie,K){y.push({name:ie,value:K})};q("sEcho",l.iDraw),q("iColumns",g),q("sColumns",zn(d,"sName").join(",")),q("iDisplayStart",P),q("iDisplayLength",O);var Q={draw:l.iDraw,columns:[],order:[],start:P,length:O,search:{value:w.sSearch,regex:w.bRegex}};for(_=0;_<g;_++)T=d[_],M=A[_],k=typeof T.mData=="function"?"function":T.mData,Q.columns.push({data:k,name:T.sName,searchable:T.bSearchable,orderable:T.bSortable,search:{value:M.sSearch,regex:M.bRegex}}),q("mDataProp_"+_,k),p.bFilter&&(q("sSearch_"+_,M.sSearch),q("bRegex_"+_,M.bRegex),q("bSearchable_"+_,T.bSearchable)),p.bSort&&q("bSortable_"+_,T.bSortable);p.bFilter&&(q("sSearch",w.sSearch),q("bRegex",w.bRegex)),p.bSort&&(F.each(B,function(ie,K){Q.order.push({column:K.col,dir:K.dir}),q("iSortCol_"+ie,K.col),q("sSortDir_"+ie,K.dir)}),q("iSortingCols",B.length));var se=ce.ext.legacy.ajax;return se===null?l.sAjaxSource?y:Q:se?y:Q}function Rv(l,d){var g=function(T,M){return d[T]!==void 0?d[T]:d[M]},p=Ta(l,d),w=g("sEcho","draw"),A=g("iTotalRecords","recordsTotal"),_=g("iTotalDisplayRecords","recordsFiltered");if(w!==void 0){if(w*1<l.iDraw)return;l.iDraw=w*1}p||(p=[]),Lc(l),l._iRecordsTotal=parseInt(A,10),l._iRecordsDisplay=parseInt(_,10);for(var y=0,k=p.length;y<k;y++)Fo(l,p[y]);l.aiDisplay=l.aiDisplayMaster.slice(),Vo(l,!0),l._bInitComplete||Cc(l,d),Zn(l,!1)}function Ta(l,d,g){var p=F.isPlainObject(l.ajax)&&l.ajax.dataSrc!==void 0?l.ajax.dataSrc:l.sAjaxDataProp;if(!g)return p==="data"?d.aaData||d[p]:p!==""?as(p)(d):d;Ro(p)(d,g)}function jv(l){var d=l.oClasses,g=l.sTableId,p=l.oLanguage,w=l.oPreviousSearch,A=l.aanFeatures,_='<input type="search" class="'+d.sFilterInput+'"/>',y=p.sSearch;y=y.match(/_INPUT_/)?y.replace("_INPUT_",_):y+_;var k=F("<div/>",{id:A.f?null:g+"_filter",class:d.sFilter}).append(F("<label/>").append(y)),T=function(P){A.f;var O=this.value?this.value:"";w.return&&P.key!=="Enter"||O!=w.sSearch&&(Sa(l,{sSearch:O,bRegex:w.bRegex,bSmart:w.bSmart,bCaseInsensitive:w.bCaseInsensitive,return:w.return}),l._iDisplayStart=0,Vo(l))},M=l.searchDelay!==null?l.searchDelay:mn(l)==="ssp"?400:0,B=F("input",k).val(w.sSearch).attr("placeholder",p.sSearchPlaceholder).on("keyup.DT search.DT input.DT paste.DT cut.DT",M?Rh(T,M):T).on("mouseup.DT",function(P){setTimeout(function(){T.call(B[0],P)},10)}).on("keypress.DT",function(P){if(P.keyCode==13)return!1}).attr("aria-controls",g);return F(l.nTable).on("search.dt.DT",function(P,O){if(l===O)try{B[0]!==document.activeElement&&B.val(w.sSearch)}catch{}}),k[0]}function Sa(l,d,g){var p=l.oPreviousSearch,w=l.aoPreSearchCols,A=function(k){p.sSearch=k.sSearch,p.bRegex=k.bRegex,p.bSmart=k.bSmart,p.bCaseInsensitive=k.bCaseInsensitive,p.return=k.return},_=function(k){return k.bEscapeRegex!==void 0?!k.bEscapeRegex:k.bRegex};if(Ih(l),mn(l)!="ssp"){Hv(l,d.sSearch,g,_(d),d.bSmart,d.bCaseInsensitive),A(d);for(var y=0;y<w.length;y++)Vv(l,w[y].sSearch,y,_(w[y]),w[y].bSmart,w[y].bCaseInsensitive);Fv(l)}else A(d);l.bFiltered=!0,ct(l,null,"search",[l])}function Fv(l){for(var d=ce.ext.search,g=l.aiDisplay,p,w,A=0,_=d.length;A<_;A++){for(var y=[],k=0,T=g.length;k<T;k++)w=g[k],p=l.aoData[w],d[A](l,p._aFilterData,w,p._aData,k)&&y.push(w);g.length=0,F.merge(g,y)}}function Vv(l,d,g,p,w,A){if(d!==""){for(var _,y=[],k=l.aiDisplay,T=Bh(d,p,w,A),M=0;M<k.length;M++)_=l.aoData[k[M]]._aFilterData[g],T.test(_)&&y.push(k[M]);l.aiDisplay=y}}function Hv(l,d,g,p,w,A){var _=Bh(d,p,w,A),y=l.oPreviousSearch.sSearch,k=l.aiDisplayMaster,T,M,B,P=[];if(ce.ext.search.length!==0&&(g=!0),M=Uv(l),d.length<=0)l.aiDisplay=k.slice();else{for((M||g||p||y.length>d.length||d.indexOf(y)!==0||l.bSorted)&&(l.aiDisplay=k.slice()),T=l.aiDisplay,B=0;B<T.length;B++)_.test(l.aoData[T[B]]._sFilterRow)&&P.push(T[B]);l.aiDisplay=P}}function Bh(l,d,g,p){if(l=d?l:Lh(l),g){var w=F.map(l.match(/["\u201C][^"\u201D]+["\u201D]|[^ ]+/g)||[""],function(A){if(A.charAt(0)==='"'){var _=A.match(/^"(.*)"$/);A=_?_[1]:A}else if(A.charAt(0)==="“"){var _=A.match(/^\u201C(.*)\u201D$/);A=_?_[1]:A}return A.replace('"',"")});l="^(?=.*?"+w.join(")(?=.*?")+").*$"}return new RegExp(l,p?"i":"")}var Lh=ce.util.escapeRegex,fc=F("<div>")[0],DT=fc.textContent!==void 0;function Uv(l){var d=l.aoColumns,g,p,w,A,_,y,k,T,M=!1;for(p=0,A=l.aoData.length;p<A;p++)if(T=l.aoData[p],!T._aFilterData){for(y=[],w=0,_=d.length;w<_;w++)g=d[w],g.bSearchable?(k=On(l,p,w,"filter"),k===null&&(k=""),typeof k!="string"&&k.toString&&(k=k.toString())):k="",k.indexOf&&k.indexOf("&")!==-1&&(fc.innerHTML=k,k=DT?fc.textContent:fc.innerText),k.replace&&(k=k.replace(/[\r\n\u2028]/g,"")),y.push(k);T._aFilterData=y,T._sFilterRow=y.join("  "),M=!0}return M}function dv(l){return{search:l.sSearch,smart:l.bSmart,regex:l.bRegex,caseInsensitive:l.bCaseInsensitive}}function uv(l){return{sSearch:l.search,bSmart:l.smart,bRegex:l.regex,bCaseInsensitive:l.caseInsensitive}}function Wv(l){var d=l.sTableId,g=l.aanFeatures.i,p=F("<div/>",{class:l.oClasses.sInfo,id:g?null:d+"_info"});return g||(l.aoDrawCallback.push({fn:qv,sName:"information"}),p.attr("role","status").attr("aria-live","polite"),F(l.nTable).attr("aria-describedby",d+"_info")),p[0]}function qv(l){var d=l.aanFeatures.i;if(d.length!==0){var g=l.oLanguage,p=l._iDisplayStart+1,w=l.fnDisplayEnd(),A=l.fnRecordsTotal(),_=l.fnRecordsDisplay(),y=_?g.sInfo:g.sInfoEmpty;_!==A&&(y+=" "+g.sInfoFiltered),y+=g.sInfoPostFix,y=Gv(l,y);var k=g.fnInfoCallback;k!==null&&(y=k.call(l.oInstance,l,p,w,A,_,y)),F(d).html(y)}}function Gv(l,d){var g=l.fnFormatNumber,p=l._iDisplayStart+1,w=l._iDisplayLength,A=l.fnRecordsDisplay(),_=w===-1;return d.replace(/_START_/g,g.call(l,p)).replace(/_END_/g,g.call(l,l.fnDisplayEnd())).replace(/_MAX_/g,g.call(l,l.fnRecordsTotal())).replace(/_TOTAL_/g,g.call(l,A)).replace(/_PAGE_/g,g.call(l,_?1:Math.ceil(p/w))).replace(/_PAGES_/g,g.call(l,_?1:Math.ceil(A/w)))}function ga(l){var d,g,p=l.iInitDisplayStart,w=l.aoColumns,A,_=l.oFeatures,y=l.bDeferLoading;if(!l.bInitialised){setTimeout(function(){ga(l)},200);return}for(Lv(l),Bv(l),va(l,l.aoHeader),va(l,l.aoFooter),Zn(l,!0),_.bAutoWidth&&Oh(l),d=0,g=w.length;d<g;d++)A=w[d],A.sWidth&&(A.nTh.style.width=Rt(A.sWidth));ct(l,null,"preInit",[l]),kr(l);var k=mn(l);(k!="ssp"||y)&&(k=="ajax"?Oc(l,[],function(T){var M=Ta(l,T);for(d=0;d<M.length;d++)Fo(l,M[d]);l.iInitDisplayStart=p,kr(l),Zn(l,!1),Cc(l,T)}):(Zn(l,!1),Cc(l)))}function Cc(l,d){l._bInitComplete=!0,(d||l.oInit.aaData)&&ya(l),ct(l,null,"plugin-init",[l,d]),ct(l,"aoInitComplete","init",[l,d])}function zh(l,d){var g=parseInt(d,10);l._iDisplayLength=g,Vh(l),ct(l,null,"length",[l,g])}function $v(l){for(var d=l.oClasses,g=l.sTableId,p=l.aLengthMenu,w=Array.isArray(p[0]),A=w?p[0]:p,_=w?p[1]:p,y=F("<select/>",{name:g+"_length","aria-controls":g,class:d.sLengthSelect}),k=0,T=A.length;k<T;k++)y[0][k]=new Option(typeof _[k]=="number"?l.fnFormatNumber(_[k]):_[k],A[k]);var M=F("<div><label/></div>").addClass(d.sLength);return l.aanFeatures.l||(M[0].id=g+"_length"),M.children().append(l.oLanguage.sLengthMenu.replace("_MENU_",y[0].outerHTML)),F("select",M).val(l._iDisplayLength).on("change.DT",function(B){zh(l,F(this).val()),Vo(l)}),F(l.nTable).on("length.dt.DT",function(B,P,O){l===P&&F("select",M).val(O)}),M[0]}function Yv(l){var d=l.sPaginationType,g=ce.ext.pager[d],p=typeof g=="function",w=function(y){Vo(y)},A=F("<div/>").addClass(l.oClasses.sPaging+d)[0],_=l.aanFeatures;return p||g.fnInit(l,A,w),_.p||(A.id=l.sTableId+"_paginate",l.aoDrawCallback.push({fn:function(y){if(p){var k=y._iDisplayStart,T=y._iDisplayLength,M=y.fnRecordsDisplay(),B=T===-1,P=B?0:Math.ceil(k/T),O=B?1:Math.ceil(M/T),q=g(P,O),Q,se;for(Q=0,se=_.p.length;Q<se;Q++)Hh(y,"pageButton")(y,_.p[Q],Q,q,P,O)}else g.fnUpdate(y,w)},sName:"pagination"})),A}function Rc(l,d,g){var p=l._iDisplayStart,w=l._iDisplayLength,A=l.fnRecordsDisplay();A===0||w===-1?p=0:typeof d=="number"?(p=d*w,p>A&&(p=0)):d=="first"?p=0:d=="previous"?(p=w>=0?p-w:0,p<0&&(p=0)):d=="next"?p+w<A&&(p+=w):d=="last"?p=Math.floor((A-1)/w)*w:gi(l,0,"Unknown paging action: "+d,5);var _=l._iDisplayStart!==p;return l._iDisplayStart=p,_?(ct(l,null,"page",[l]),g&&Vo(l)):ct(l,null,"page-nc",[l]),_}function Kv(l){return F("<div/>",{id:l.aanFeatures.r?null:l.sTableId+"_processing",class:l.oClasses.sProcessing,role:"status"}).html(l.oLanguage.sProcessing).append("<div><div></div><div></div><div></div><div></div></div>").insertBefore(l.nTable)[0]}function Zn(l,d){l.oFeatures.bProcessing&&F(l.aanFeatures.r).css("display",d?"block":"none"),ct(l,null,"processing",[l,d])}function Qv(l){var d=F(l.nTable),g=l.oScroll;if(g.sX===""&&g.sY==="")return l.nTable;var p=g.sX,w=g.sY,A=l.oClasses,_=d.children("caption"),y=_.length?_[0]._captionSide:null,k=F(d[0].cloneNode(!1)),T=F(d[0].cloneNode(!1)),M=d.children("tfoot"),B="<div/>",P=function(K){return K?Rt(K):null};M.length||(M=null);var O=F(B,{class:A.sScrollWrapper}).append(F(B,{class:A.sScrollHead}).css({overflow:"hidden",position:"relative",border:0,width:p?P(p):"100%"}).append(F(B,{class:A.sScrollHeadInner}).css({"box-sizing":"content-box",width:g.sXInner||"100%"}).append(k.removeAttr("id").css("margin-left",0).append(y==="top"?_:null).append(d.children("thead"))))).append(F(B,{class:A.sScrollBody}).css({position:"relative",overflow:"auto",width:P(p)}).append(d));M&&O.append(F(B,{class:A.sScrollFoot}).css({overflow:"hidden",border:0,width:p?P(p):"100%"}).append(F(B,{class:A.sScrollFootInner}).append(T.removeAttr("id").css("margin-left",0).append(y==="bottom"?_:null).append(d.children("tfoot")))));var q=O.children(),Q=q[0],se=q[1],ie=M?q[2]:null;return p&&F(se).on("scroll.DT",function(K){var Ae=this.scrollLeft;Q.scrollLeft=Ae,M&&(ie.scrollLeft=Ae)}),F(se).css("max-height",w),g.bCollapse||F(se).css("height",w),l.nScrollHead=Q,l.nScrollBody=se,l.nScrollFoot=ie,l.aoDrawCallback.push({fn:jc,sName:"scrolling"}),O[0]}function jc(l){var d=l.oScroll,g=d.sX,p=d.sXInner,w=d.sY,A=d.iBarWidth,_=F(l.nScrollHead),y=_[0].style,k=_.children("div"),T=k[0].style,M=k.children("table"),B=l.nScrollBody,P=F(B),O=B.style,q=F(l.nScrollFoot),Q=q.children("div"),se=Q.children("table"),ie=F(l.nTHead),K=F(l.nTable),Ae=K[0],Ee=Ae.style,Se=l.nTFoot?F(l.nTFoot):null,V=l.oBrowser,x=V.bScrollOversize;zn(l.aoColumns,"nTh");var we,he,ze,Pe,Ve,me,Me=[],He=[],dt=[],Ce=[],_t,Nt,dn,Rn=function(it){var Ct=it.style;Ct.paddingTop="0",Ct.paddingBottom="0",Ct.borderTopWidth="0",Ct.borderBottomWidth="0",Ct.height=0},xn=B.scrollHeight>B.clientHeight;if(l.scrollBarVis!==xn&&l.scrollBarVis!==void 0){l.scrollBarVis=xn,ya(l);return}else l.scrollBarVis=xn;K.children("thead, tfoot").remove(),Se&&(me=Se.clone().prependTo(K),he=Se.find("tr"),Pe=me.find("tr"),me.find("[id]").removeAttr("id")),Ve=ie.clone().prependTo(K),we=ie.find("tr"),ze=Ve.find("tr"),Ve.find("th, td").removeAttr("tabindex"),Ve.find("[id]").removeAttr("id"),g||(O.width="100%",_[0].style.width="100%"),F.each(zc(l,Ve),function(it,Ct){_t=xa(l,it),Ct.style.width=l.aoColumns[_t].sWidth}),Se&&Gi(function(it){it.style.width=""},Pe),dn=K.outerWidth(),g===""?(Ee.width="100%",x&&(K.find("tbody").height()>B.offsetHeight||P.css("overflow-y")=="scroll")&&(Ee.width=Rt(K.outerWidth()-A)),dn=K.outerWidth()):p!==""&&(Ee.width=Rt(p),dn=K.outerWidth()),Gi(Rn,ze),Gi(function(it){var Ct=window.getComputedStyle?window.getComputedStyle(it).width:Rt(F(it).width());dt.push(it.innerHTML),Me.push(Ct)},ze),Gi(function(it,Ct){it.style.width=Me[Ct]},we),F(ze).css("height",0),Se&&(Gi(Rn,Pe),Gi(function(it){Ce.push(it.innerHTML),He.push(Rt(F(it).css("width")))},Pe),Gi(function(it,Ct){it.style.width=He[Ct]},he),F(Pe).height(0)),Gi(function(it,Ct){it.innerHTML='<div class="dataTables_sizing">'+dt[Ct]+"</div>",it.childNodes[0].style.height="0",it.childNodes[0].style.overflow="hidden",it.style.width=Me[Ct]},ze),Se&&Gi(function(it,Ct){it.innerHTML='<div class="dataTables_sizing">'+Ce[Ct]+"</div>",it.childNodes[0].style.height="0",it.childNodes[0].style.overflow="hidden",it.style.width=He[Ct]},Pe),Math.round(K.outerWidth())<Math.round(dn)?(Nt=B.scrollHeight>B.offsetHeight||P.css("overflow-y")=="scroll"?dn+A:dn,x&&(B.scrollHeight>B.offsetHeight||P.css("overflow-y")=="scroll")&&(Ee.width=Rt(Nt-A)),(g===""||p!=="")&&gi(l,1,"Possible column misalignment",6)):Nt="100%",O.width=Rt(Nt),y.width=Rt(Nt),Se&&(l.nScrollFoot.style.width=Rt(Nt)),w||x&&(O.height=Rt(Ae.offsetHeight+A));var pi=K.outerWidth();M[0].style.width=Rt(pi),T.width=Rt(pi);var Qi=K.height()>B.clientHeight||P.css("overflow-y")=="scroll",ht="padding"+(V.bScrollbarLeft?"Left":"Right");T[ht]=Qi?A+"px":"0px",Se&&(se[0].style.width=Rt(pi),Q[0].style.width=Rt(pi),Q[0].style[ht]=Qi?A+"px":"0px"),K.children("colgroup").insertBefore(K.children("thead")),P.trigger("scroll"),(l.bSorted||l.bFiltered)&&!l._drawHold&&(B.scrollTop=0)}function Gi(l,d,g){for(var p=0,w=0,A=d.length,_,y;w<A;){for(_=d[w].firstChild,y=g?g[w].firstChild:null;_;)_.nodeType===1&&(g?l(_,y,p):l(_,p),p++),_=_.nextSibling,y=g?y.nextSibling:null;w++}}var ET=/<.*?>/g;function Oh(l){var d=l.nTable,g=l.aoColumns,p=l.oScroll,w=p.sY,A=p.sX,_=p.sXInner,y=g.length,k=Pc(l,"bVisible"),T=F("th",l.nTHead),M=d.getAttribute("width"),B=d.parentNode,P=!1,O,q,Q,se=l.oBrowser,ie=se.bScrollOversize,K=d.style.width;K&&K.indexOf("%")!==-1&&(M=K);var Ae=Zv(zn(g,"sWidthOrig"),B);for(O=0;O<k.length;O++)q=g[k[O]],q.sWidth!==null&&(q.sWidth=Ae[O],P=!0);if(ie||!P&&!A&&!w&&y==cs(l)&&y==T.length)for(O=0;O<y;O++){var Ee=xa(l,O);Ee!==null&&(g[Ee].sWidth=Rt(T.eq(O).width()))}else{var Se=F(d).clone().css("visibility","hidden").removeAttr("id");Se.find("tbody tr").remove();var V=F("<tr/>").appendTo(Se.find("tbody"));for(Se.find("thead, tfoot").remove(),Se.append(F(l.nTHead).clone()).append(F(l.nTFoot).clone()),Se.find("tfoot th, tfoot td").css("width",""),T=zc(l,Se.find("thead")[0]),O=0;O<k.length;O++)q=g[k[O]],T[O].style.width=q.sWidthOrig!==null&&q.sWidthOrig!==""?Rt(q.sWidthOrig):"",q.sWidthOrig&&A&&F(T[O]).append(F("<div/>").css({width:q.sWidthOrig,margin:0,padding:0,border:0,height:1}));if(l.aoData.length)for(O=0;O<k.length;O++)Q=k[O],q=g[Q],F(Jv(l,Q)).clone(!1).append(q.sContentPadding).appendTo(V);F("[name]",Se).removeAttr("name");var x=F("<div/>").css(A||w?{position:"absolute",top:0,left:0,height:1,right:0,overflow:"hidden"}:{}).append(Se).appendTo(B);A&&_?Se.width(_):A?(Se.css("width","auto"),Se.removeAttr("width"),Se.width()<B.clientWidth&&M&&Se.width(B.clientWidth)):w?Se.width(B.clientWidth):M&&Se.width(M);var we=0;for(O=0;O<k.length;O++){var he=F(T[O]),ze=he.outerWidth()-he.width(),Pe=se.bBounding?Math.ceil(T[O].getBoundingClientRect().width):he.outerWidth();we+=Pe,g[k[O]].sWidth=Rt(Pe-ze)}d.style.width=Rt(we),x.remove()}if(M&&(d.style.width=Rt(M)),(M||A)&&!l._reszEvt){var Ve=function(){F(window).on("resize.DT-"+l.sInstance,Rh(function(){ya(l)}))};ie?setTimeout(Ve,1e3):Ve(),l._reszEvt=!0}}var Rh=ce.util.throttle;function Zv(l,d){for(var g=[],p=[],w=0;w<l.length;w++)l[w]?g.push(F("<div/>").css("width",Rt(l[w])).appendTo(d||document.body)):g.push(null);for(var w=0;w<l.length;w++)p.push(g[w]?g[w][0].offsetWidth:null);return F(g).remove(),p}function Jv(l,d){var g=Xv(l,d);if(g<0)return null;var p=l.aoData[g];return p.nTr?p.anCells[d]:F("<td/>").html(On(l,g,d,"display"))[0]}function Xv(l,d){for(var g,p=-1,w=-1,A=0,_=l.aoData.length;A<_;A++)g=On(l,A,d,"display")+"",g=g.replace(ET,""),g=g.replace(/&nbsp;/g," "),g.length>p&&(p=g.length,w=A);return w}function Rt(l){return l===null?"0px":typeof l=="number"?l<0?"0px":l+"px":l.match(/\d$/)?l+"px":l}function ds(l){var d,g,p,w=[],A=l.aoColumns,_,y,k,T,M=l.aaSortingFixed,B=F.isPlainObject(M),P=[],O=function(q){q.length&&!Array.isArray(q[0])?P.push(q):F.merge(P,q)};for(Array.isArray(M)&&O(M),B&&M.pre&&O(M.pre),O(l.aaSorting),B&&M.post&&O(M.post),d=0;d<P.length;d++)for(T=P[d][0],_=A[T].aDataSort,g=0,p=_.length;g<p;g++)y=_[g],k=A[y].sType||"string",P[d]._idx===void 0&&(P[d]._idx=F.inArray(P[d][1],A[y].asSorting)),w.push({src:T,col:y,dir:P[d][1],index:P[d]._idx,type:k,formatter:ce.ext.type.order[k+"-pre"]});return w}function e0(l){var d,g,p,w=[],A=ce.ext.type.order,_=l.aoData;l.aoColumns;var y=0,k,T=l.aiDisplayMaster,M;for(Ih(l),M=ds(l),d=0,g=M.length;d<g;d++)k=M[d],k.formatter&&y++,n0(l,k.col);if(mn(l)!="ssp"&&M.length!==0){for(d=0,p=T.length;d<p;d++)w[T[d]]=d;y===M.length?T.sort(function(B,P){var O,q,Q,se,ie,K=M.length,Ae=_[B]._aSortData,Ee=_[P]._aSortData;for(Q=0;Q<K;Q++)if(ie=M[Q],O=Ae[ie.col],q=Ee[ie.col],se=O<q?-1:O>q?1:0,se!==0)return ie.dir==="asc"?se:-se;return O=w[B],q=w[P],O<q?-1:O>q?1:0}):T.sort(function(B,P){var O,q,Q,se,ie,K,Ae=M.length,Ee=_[B]._aSortData,Se=_[P]._aSortData;for(Q=0;Q<Ae;Q++)if(ie=M[Q],O=Ee[ie.col],q=Se[ie.col],K=A[ie.type+"-"+ie.dir]||A["string-"+ie.dir],se=K(O,q),se!==0)return se;return O=w[B],q=w[P],O<q?-1:O>q?1:0})}l.bSorted=!0}function t0(l){for(var d,g,p=l.aoColumns,w=ds(l),A=l.oLanguage.oAria,_=0,y=p.length;_<y;_++){var k=p[_],T=k.asSorting,M=k.ariaTitle||k.sTitle.replace(/<.*?>/g,""),B=k.nTh;B.removeAttribute("aria-sort"),k.bSortable?(w.length>0&&w[0].col==_?(B.setAttribute("aria-sort",w[0].dir=="asc"?"ascending":"descending"),g=T[w[0].index+1]||T[0]):g=T[0],d=M+(g==="asc"?A.sSortAscending:A.sSortDescending)):d=M,B.setAttribute("aria-label",d)}}function _h(l,d,g,p){var w=l.aoColumns[d],A=l.aaSorting,_=w.asSorting,y,k=function(M,B){var P=M._idx;return P===void 0&&(P=F.inArray(M[1],_)),P+1<_.length?P+1:B?null:0};if(typeof A[0]=="number"&&(A=l.aaSorting=[A]),g&&l.oFeatures.bSortMulti){var T=F.inArray(d,zn(A,"0"));T!==-1?(y=k(A[T],!0),y===null&&A.length===1&&(y=0),y===null?A.splice(T,1):(A[T][1]=_[y],A[T]._idx=y)):(A.push([d,_[0],0]),A[A.length-1]._idx=0)}else A.length&&A[0][0]==d?(y=k(A[0]),A.length=1,A[0][1]=_[y],A[0]._idx=y):(A.length=0,A.push([d,_[0]]),A[0]._idx=0);kr(l),typeof p=="function"&&p(l)}function jh(l,d,g,p){var w=l.aoColumns[g];Fh(d,{},function(A){w.bSortable!==!1&&(l.oFeatures.bProcessing?(Zn(l,!0),setTimeout(function(){_h(l,g,A.shiftKey,p),mn(l)!=="ssp"&&Zn(l,!1)},0)):_h(l,g,A.shiftKey,p))})}function Ac(l){var d=l.aLastSort,g=l.oClasses.sSortColumn,p=ds(l),w=l.oFeatures,A,_,y;if(w.bSort&&w.bSortClasses){for(A=0,_=d.length;A<_;A++)y=d[A].src,F(zn(l.aoData,"anCells",y)).removeClass(g+(A<2?A+1:3));for(A=0,_=p.length;A<_;A++)y=p[A].src,F(zn(l.aoData,"anCells",y)).addClass(g+(A<2?A+1:3))}l.aLastSort=p}function n0(l,d){var g=l.aoColumns[d],p=ce.ext.order[g.sSortDataType],w;p&&(w=p.call(l.oInstance,l,d,Da(l,d)));for(var A,_,y=ce.ext.type.order[g.sType+"-pre"],k=0,T=l.aoData.length;k<T;k++)A=l.aoData[k],A._aSortData||(A._aSortData=[]),(!A._aSortData[d]||p)&&(_=p?w[k]:On(l,k,d,"sort"),A._aSortData[d]=y?y(_):_)}function Ia(l){if(!l._bLoadingState){var d={time:+new Date,start:l._iDisplayStart,length:l._iDisplayLength,order:F.extend(!0,[],l.aaSorting),search:dv(l.oPreviousSearch),columns:F.map(l.aoColumns,function(g,p){return{visible:g.bVisible,search:dv(l.aoPreSearchCols[p])}})};l.oSavedState=d,ct(l,"aoStateSaveParams","stateSaveParams",[l,d]),l.oFeatures.bStateSave&&!l.bDestroying&&l.fnStateSaveCallback.call(l.oInstance,l,d)}}function i0(l,d,g){if(!l.oFeatures.bStateSave){g();return}var p=function(A){Ch(l,A,g)},w=l.fnStateLoadCallback.call(l.oInstance,l,p);return w!==void 0&&Ch(l,w,g),!0}function Ch(l,d,g){var p,w,A=l.aoColumns;l._bLoadingState=!0;var _=l._bInitComplete?new ce.Api(l):null;if(!d||!d.time){l._bLoadingState=!1,g();return}var y=ct(l,"aoStateLoadParams","stateLoadParams",[l,d]);if(F.inArray(!1,y)!==-1){l._bLoadingState=!1,g();return}var k=l.iStateDuration;if(k>0&&d.time<+new Date-k*1e3){l._bLoadingState=!1,g();return}if(d.columns&&A.length!==d.columns.length){l._bLoadingState=!1,g();return}if(l.oLoadedState=F.extend(!0,{},d),d.length!==void 0&&(_?_.page.len(d.length):l._iDisplayLength=d.length),d.start!==void 0&&(_===null?(l._iDisplayStart=d.start,l.iInitDisplayStart=d.start):Rc(l,d.start/l._iDisplayLength)),d.order!==void 0&&(l.aaSorting=[],F.each(d.order,function(M,B){l.aaSorting.push(B[0]>=A.length?[0,B[1]]:B)})),d.search!==void 0&&F.extend(l.oPreviousSearch,uv(d.search)),d.columns){for(p=0,w=d.columns.length;p<w;p++){var T=d.columns[p];T.visible!==void 0&&(_?_.column(p).visible(T.visible,!1):A[p].bVisible=T.visible),T.search!==void 0&&F.extend(l.aoPreSearchCols[p],uv(T.search))}_&&_.columns.adjust()}l._bLoadingState=!1,ct(l,"aoStateLoaded","stateLoaded",[l,d]),g()}function yc(l){var d=ce.settings,g=F.inArray(l,zn(d,"nTable"));return g!==-1?d[g]:null}function gi(l,d,g,p){if(g="DataTables warning: "+(l?"table id="+l.sTableId+" - ":"")+g,p&&(g+=". For more information about this error, please see https://datatables.net/tn/"+p),d)window.console&&console.log&&console.log(g);else{var w=ce.ext,A=w.sErrMode||w.errMode;if(l&&ct(l,null,"error",[l,p,g]),A=="alert")alert(g);else{if(A=="throw")throw new Error(g);typeof A=="function"&&A(l,p,g)}}}function Di(l,d,g,p){if(Array.isArray(g)){F.each(g,function(w,A){Array.isArray(A)?Di(l,d,A[0],A[1]):Di(l,d,A)});return}p===void 0&&(p=g),d[g]!==void 0&&(l[p]=d[g])}function Ah(l,d,g){var p;for(var w in d)d.hasOwnProperty(w)&&(p=d[w],F.isPlainObject(p)?(F.isPlainObject(l[w])||(l[w]={}),F.extend(!0,l[w],p)):g&&w!=="data"&&w!=="aaData"&&Array.isArray(p)?l[w]=p.slice():l[w]=p);return l}function Fh(l,d,g){F(l).on("click.DT",d,function(p){F(l).trigger("blur"),g(p)}).on("keypress.DT",d,function(p){p.which===13&&(p.preventDefault(),g(p))}).on("selectstart.DT",function(){return!1})}function An(l,d,g,p){g&&l[d].push({fn:g,sName:p})}function ct(l,d,g,p){var w=[];if(d&&(w=F.map(l[d].slice().reverse(),function(y,k){return y.fn.apply(l.oInstance,p)})),g!==null){var A=F.Event(g+".dt"),_=F(l.nTable);_.trigger(A,p),_.parents("body").length===0&&F("body").trigger(A,p),w.push(A.result)}return w}function Vh(l){var d=l._iDisplayStart,g=l.fnDisplayEnd(),p=l._iDisplayLength;d>=g&&(d=g-p),d-=d%p,(p===-1||d<0)&&(d=0),l._iDisplayStart=d}function Hh(l,d){var g=l.renderer,p=ce.ext.renderer[d];return F.isPlainObject(g)&&g[d]?p[g[d]]||p._:typeof g=="string"&&p[g]||p._}function mn(l){return l.oFeatures.bServerSide?"ssp":l.ajax||l.sAjaxSource?"ajax":"dom"}var o0=[],Xt=Array.prototype,TT=function(l){var d,g,p=ce.settings,w=F.map(p,function(A,_){return A.nTable});if(l){if(l.nTable&&l.oApi)return[l];if(l.nodeName&&l.nodeName.toLowerCase()==="table")return d=F.inArray(l,w),d!==-1?[p[d]]:null;if(l&&typeof l.settings=="function")return l.settings().toArray();typeof l=="string"?g=F(l):l instanceof F&&(g=l)}else return[];if(g)return g.map(function(A){return d=F.inArray(this,w),d!==-1?p[d]:null}).toArray()};et=function(l,d){if(!(this instanceof et))return new et(l,d);var g=[],p=function(_){var y=TT(_);y&&g.push.apply(g,y)};if(Array.isArray(l))for(var w=0,A=l.length;w<A;w++)p(l[w]);else p(l);this.context=Nc(g),d&&F.merge(this,d),this.selector={rows:null,cols:null,opts:null},et.extend(this,this,o0)};ce.Api=et;F.extend(et.prototype,{any:function(){return this.count()!==0},concat:Xt.concat,context:[],count:function(){return this.flatten().length},each:function(l){for(var d=0,g=this.length;d<g;d++)l.call(this,this[d],d,this);return this},eq:function(l){var d=this.context;return d.length>l?new et(d[l],this[l]):null},filter:function(l){var d=[];if(Xt.filter)d=Xt.filter.call(this,l,this);else for(var g=0,p=this.length;g<p;g++)l.call(this,this[g],g,this)&&d.push(this[g]);return new et(this.context,d)},flatten:function(){var l=[];return new et(this.context,l.concat.apply(l,this.toArray()))},join:Xt.join,indexOf:Xt.indexOf||function(l,d){for(var g=d||0,p=this.length;g<p;g++)if(this[g]===l)return g;return-1},iterator:function(l,d,g,p){var w=[],A,_,y,k,T,M=this.context,B,P,O,q=this.selector;for(typeof l=="string"&&(p=g,g=d,d=l,l=!1),_=0,y=M.length;_<y;_++){var Q=new et(M[_]);if(d==="table")A=g.call(Q,M[_],_),A!==void 0&&w.push(A);else if(d==="columns"||d==="rows")A=g.call(Q,M[_],this[_],_),A!==void 0&&w.push(A);else if(d==="column"||d==="column-rows"||d==="row"||d==="cell")for(P=this[_],d==="column-rows"&&(B=Fc(M[_],q.opts)),k=0,T=P.length;k<T;k++)O=P[k],d==="cell"?A=g.call(Q,M[_],O.row,O.column,_,k):A=g.call(Q,M[_],O,_,k,B),A!==void 0&&w.push(A)}if(w.length||p){var se=new et(M,l?w.concat.apply([],w):w),ie=se.selector;return ie.rows=q.rows,ie.cols=q.cols,ie.opts=q.opts,se}return this},lastIndexOf:Xt.lastIndexOf||function(l,d){return this.indexOf.apply(this.toArray.reverse(),arguments)},length:0,map:function(l){var d=[];if(Xt.map)d=Xt.map.call(this,l,this);else for(var g=0,p=this.length;g<p;g++)d.push(l.call(this,this[g],g));return new et(this.context,d)},pluck:function(l){var d=ce.util.get(l);return this.map(function(g){return d(g)})},pop:Xt.pop,push:Xt.push,reduce:Xt.reduce||function(l,d){return cv(this,l,d,0,this.length,1)},reduceRight:Xt.reduceRight||function(l,d){return cv(this,l,d,this.length-1,-1,-1)},reverse:Xt.reverse,selector:null,shift:Xt.shift,slice:function(){return new et(this.context,this)},sort:Xt.sort,splice:Xt.splice,toArray:function(){return Xt.slice.call(this)},to$:function(){return F(this)},toJQuery:function(){return F(this)},unique:function(){return new et(this.context,Nc(this))},unshift:Xt.unshift});et.extend=function(l,d,g){if(!(!g.length||!d||!(d instanceof et)&&!d.__dt_wrapper)){var p,w,A,_=function(y,k,T){return function(){var M=k.apply(y,arguments);return et.extend(M,M,T.methodExt),M}};for(p=0,w=g.length;p<w;p++)A=g[p],d[A.name]=A.type==="function"?_(l,A.val,A):A.type==="object"?{}:A.val,d[A.name].__dt_wrapper=!0,et.extend(l,d[A.name],A.propExt)}};et.register=Te=function(l,d){if(Array.isArray(l)){for(var g=0,p=l.length;g<p;g++)et.register(l[g],d);return}var w,A,_=l.split("."),y=o0,k,T,M=function(P,O){for(var q=0,Q=P.length;q<Q;q++)if(P[q].name===O)return P[q];return null};for(w=0,A=_.length;w<A;w++){T=_[w].indexOf("()")!==-1,k=T?_[w].replace("()",""):_[w];var B=M(y,k);B||(B={name:k,val:{},methodExt:[],propExt:[],type:"object"},y.push(B)),w===A-1?(B.val=d,B.type=typeof d=="function"?"function":F.isPlainObject(d)?"object":"other"):y=T?B.methodExt:B.propExt}};et.registerPlural=Et=function(l,d,g){et.register(l,g),et.register(d,function(){var p=g.apply(this,arguments);return p===this?this:p instanceof et?p.length?Array.isArray(p[0])?new et(p.context,p[0]):p[0]:void 0:p})};var r0=function(l,d){if(Array.isArray(l))return F.map(l,function(p){return r0(p,d)});if(typeof l=="number")return[d[l]];var g=F.map(d,function(p,w){return p.nTable});return F(g).filter(l).map(function(p){var w=F.inArray(this,g);return d[w]}).toArray()};Te("tables()",function(l){return l!=null?new et(r0(l,this.context)):this});Te("table()",function(l){var d=this.tables(l),g=d.context;return g.length?new et(g[0]):d});Et("tables().nodes()","table().node()",function(){return this.iterator("table",function(l){return l.nTable},1)});Et("tables().body()","table().body()",function(){return this.iterator("table",function(l){return l.nTBody},1)});Et("tables().header()","table().header()",function(){return this.iterator("table",function(l){return l.nTHead},1)});Et("tables().footer()","table().footer()",function(){return this.iterator("table",function(l){return l.nTFoot},1)});Et("tables().containers()","table().container()",function(){return this.iterator("table",function(l){return l.nTableWrapper},1)});Te("draw()",function(l){return this.iterator("table",function(d){l==="page"?Vo(d):(typeof l=="string"&&(l=l!=="full-hold"),kr(d,l===!1))})});Te("page()",function(l){return l===void 0?this.page.info().page:this.iterator("table",function(d){Rc(d,l)})});Te("page.info()",function(l){if(this.context.length!==0){var d=this.context[0],g=d._iDisplayStart,p=d.oFeatures.bPaginate?d._iDisplayLength:-1,w=d.fnRecordsDisplay(),A=p===-1;return{page:A?0:Math.floor(g/p),pages:A?1:Math.ceil(w/p),start:g,end:d.fnDisplayEnd(),length:p,recordsTotal:d.fnRecordsTotal(),recordsDisplay:w,serverSide:mn(d)==="ssp"}}});Te("page.len()",function(l){return l===void 0?this.context.length!==0?this.context[0]._iDisplayLength:void 0:this.iterator("table",function(d){zh(d,l)})});var s0=function(l,d,g){if(g){var p=new et(l);p.one("draw",function(){g(p.ajax.json())})}if(mn(l)=="ssp")kr(l,d);else{Zn(l,!0);var w=l.jqXHR;w&&w.readyState!==4&&w.abort(),Oc(l,[],function(A){Lc(l);for(var _=Ta(l,A),y=0,k=_.length;y<k;y++)Fo(l,_[y]);kr(l,d),Zn(l,!1)})}};Te("ajax.json()",function(){var l=this.context;if(l.length>0)return l[0].json});Te("ajax.params()",function(){var l=this.context;if(l.length>0)return l[0].oAjaxData});Te("ajax.reload()",function(l,d){return this.iterator("table",function(g){s0(g,d===!1,l)})});Te("ajax.url()",function(l){var d=this.context;return l===void 0?d.length===0?void 0:(d=d[0],d.ajax?F.isPlainObject(d.ajax)?d.ajax.url:d.ajax:d.sAjaxSource):this.iterator("table",function(g){F.isPlainObject(g.ajax)?g.ajax.url=l:g.ajax=l})});Te("ajax.url().load()",function(l,d){return this.iterator("table",function(g){s0(g,d===!1,l)})});var Uh=function(l,d,g,p,w){var A=[],_,y,k,T,M,B,P=typeof d;for((!d||P==="string"||P==="function"||d.length===void 0)&&(d=[d]),k=0,T=d.length;k<T;k++)for(y=d[k]&&d[k].split&&!d[k].match(/[\[\(:]/)?d[k].split(","):[d[k]],M=0,B=y.length;M<B;M++)_=g(typeof y[M]=="string"?y[M].trim():y[M]),_&&_.length&&(A=A.concat(_));var O=Ut.selector[l];if(O.length)for(k=0,T=O.length;k<T;k++)A=O[k](p,w,A);return Nc(A)},Wh=function(l){return l||(l={}),l.filter&&l.search===void 0&&(l.search=l.filter),F.extend({search:"none",order:"current",page:"all"},l)},qh=function(l){for(var d=0,g=l.length;d<g;d++)if(l[d].length>0)return l[0]=l[d],l[0].length=1,l.length=1,l.context=[l.context[d]],l;return l.length=0,l},Fc=function(l,d){var g,p,w,A=[],_=l.aiDisplay,y=l.aiDisplayMaster,k=d.search,T=d.order,M=d.page;if(mn(l)=="ssp")return k==="removed"?[]:os(0,y.length);if(M=="current")for(g=l._iDisplayStart,p=l.fnDisplayEnd();g<p;g++)A.push(_[g]);else if(T=="current"||T=="applied"){if(k=="none")A=y.slice();else if(k=="applied")A=_.slice();else if(k=="removed"){for(var B={},g=0,p=_.length;g<p;g++)B[_[g]]=null;A=F.map(y,function(P){return B.hasOwnProperty(P)?null:P})}}else if(T=="index"||T=="original")for(g=0,p=l.aoData.length;g<p;g++)k=="none"?A.push(g):(w=F.inArray(g,_),(w===-1&&k=="removed"||w>=0&&k=="applied")&&A.push(g));return A},ST=function(l,d,g){var p,w=function(A){var _=xv(A),y=l.aoData;if(_!==null&&!g)return[_];if(p||(p=Fc(l,g)),_!==null&&F.inArray(_,p)!==-1)return[_];if(A==null||A==="")return p;if(typeof A=="function")return F.map(p,function(O){var q=y[O];return A(O,q._aData,q.nTr)?O:null});if(A.nodeName){var k=A._DT_RowIndex,T=A._DT_CellIndex;if(k!==void 0)return y[k]&&y[k].nTr===A?[k]:[];if(T)return y[T.row]&&y[T.row].nTr===A.parentNode?[T.row]:[];var M=F(A).closest("*[data-dt-row]");return M.length?[M.data("dt-row")]:[]}if(typeof A=="string"&&A.charAt(0)==="#"){var B=l.aIds[A.replace(/^#/,"")];if(B!==void 0)return[B.idx]}var P=Ev(Ca(l.aoData,p,"nTr"));return F(P).filter(A).map(function(){return this._DT_RowIndex}).toArray()};return Uh("row",d,w,l,g)};Te("rows()",function(l,d){l===void 0?l="":F.isPlainObject(l)&&(d=l,l=""),d=Wh(d);var g=this.iterator("table",function(p){return ST(p,l,d)},1);return g.selector.rows=l,g.selector.opts=d,g});Te("rows().nodes()",function(){return this.iterator("row",function(l,d){return l.aoData[d].nTr||void 0},1)});Te("rows().data()",function(){return this.iterator(!0,"rows",function(l,d){return Ca(l.aoData,d,"_aData")},1)});Et("rows().cache()","row().cache()",function(l){return this.iterator("row",function(d,g){var p=d.aoData[g];return l==="search"?p._aFilterData:p._aSortData},1)});Et("rows().invalidate()","row().invalidate()",function(l){return this.iterator("row",function(d,g){Ea(d,g,l)})});Et("rows().indexes()","row().index()",function(){return this.iterator("row",function(l,d){return d},1)});Et("rows().ids()","row().id()",function(l){for(var d=[],g=this.context,p=0,w=g.length;p<w;p++)for(var A=0,_=this[p].length;A<_;A++){var y=g[p].rowIdFn(g[p].aoData[this[p][A]]._aData);d.push((l===!0?"#":"")+y)}return new et(g,d)});Et("rows().remove()","row().remove()",function(){var l=this;return this.iterator("row",function(d,g,p){var w=d.aoData,A=w[g],_,y,k,T,M,B;for(w.splice(g,1),_=0,y=w.length;_<y;_++)if(M=w[_],B=M.anCells,M.nTr!==null&&(M.nTr._DT_RowIndex=_),B!==null)for(k=0,T=B.length;k<T;k++)B[k]._DT_CellIndex.row=_;hc(d.aiDisplayMaster,g),hc(d.aiDisplay,g),hc(l[p],g,!1),d._iRecordsDisplay>0&&d._iRecordsDisplay--,Vh(d);var P=d.rowIdFn(A._aData);P!==void 0&&delete d.aIds[P]}),this.iterator("table",function(d){for(var g=0,p=d.aoData.length;g<p;g++)d.aoData[g].idx=g}),this});Te("rows.add()",function(l){var d=this.iterator("table",function(p){var w,A,_,y=[];for(A=0,_=l.length;A<_;A++)w=l[A],w.nodeName&&w.nodeName.toUpperCase()==="TR"?y.push(Bc(p,w)[0]):y.push(Fo(p,w));return y},1),g=this.rows(-1);return g.pop(),F.merge(g,d),g});Te("row()",function(l,d){return qh(this.rows(l,d))});Te("row().data()",function(l){var d=this.context;if(l===void 0)return d.length&&this.length?d[0].aoData[this[0]]._aData:void 0;var g=d[0].aoData[this[0]];return g._aData=l,Array.isArray(l)&&g.nTr&&g.nTr.id&&Ro(d[0].rowId)(l,g.nTr.id),Ea(d[0],this[0],"data"),this});Te("row().node()",function(){var l=this.context;return l.length&&this.length&&l[0].aoData[this[0]].nTr||null});Te("row.add()",function(l){l instanceof F&&l.length&&(l=l[0]);var d=this.iterator("table",function(g){return l.nodeName&&l.nodeName.toUpperCase()==="TR"?Bc(g,l)[0]:Fo(g,l)});return this.row(d[0])});F(document).on("plugin-init.dt",function(l,d){var g=new et(d),p="on-plugin-init",w="stateSaveParams."+p,A="destroy. "+p;g.on(w,function(y,k,T){for(var M=k.rowIdFn,B=k.aoData,P=[],O=0;O<B.length;O++)B[O]._detailsShow&&P.push("#"+M(B[O]._aData));T.childRows=P}),g.on(A,function(){g.off(w+" "+A)});var _=g.state.loaded();_&&_.childRows&&g.rows(F.map(_.childRows,function(y){return y.replace(/:/g,"\\:")})).every(function(){ct(d,null,"requestChild",[this])})});var IT=function(l,d,g,p){var w=[],A=function(_,y){if(Array.isArray(_)||_ instanceof F){for(var k=0,T=_.length;k<T;k++)A(_[k],y);return}if(_.nodeName&&_.nodeName.toLowerCase()==="tr")w.push(_);else{var M=F("<tr><td></td></tr>").addClass(y);F("td",M).addClass(y).html(_)[0].colSpan=cs(l),w.push(M[0])}};A(g,p),d._details&&d._details.detach(),d._details=F(w),d._detailsShow&&d._details.insertAfter(d.nTr)},a0=ce.util.throttle(function(l){Ia(l[0])},500),Gh=function(l,d){var g=l.context;if(g.length){var p=g[0].aoData[d!==void 0?d:l[0]];p&&p._details&&(p._details.remove(),p._detailsShow=void 0,p._details=void 0,F(p.nTr).removeClass("dt-hasChild"),a0(g))}},l0=function(l,d){var g=l.context;if(g.length&&l.length){var p=g[0].aoData[l[0]];p._details&&(p._detailsShow=d,d?(p._details.insertAfter(p.nTr),F(p.nTr).addClass("dt-hasChild")):(p._details.detach(),F(p.nTr).removeClass("dt-hasChild")),ct(g[0],null,"childRow",[d,l.row(l[0])]),MT(g[0]),a0(g))}},MT=function(l){var d=new et(l),g=".dt.DT_details",p="draw"+g,w="column-sizing"+g,A="destroy"+g,_=l.aoData;d.off(p+" "+w+" "+A),zn(_,"_details").length>0&&(d.on(p,function(y,k){l===k&&d.rows({page:"current"}).eq(0).each(function(T){var M=_[T];M._detailsShow&&M._details.insertAfter(M.nTr)})}),d.on(w,function(y,k,T,M){if(l===k)for(var B,P=cs(k),O=0,q=_.length;O<q;O++)B=_[O],B._details&&B._details.each(function(){var Q=F(this).children("td");Q.length==1&&Q.attr("colspan",P)})}),d.on(A,function(y,k){if(l===k)for(var T=0,M=_.length;T<M;T++)_[T]._details&&Gh(d,T)}))},NT="",Ma=NT+"row().child",Vc=Ma+"()";Te(Vc,function(l,d){var g=this.context;return l===void 0?g.length&&this.length?g[0].aoData[this[0]]._details:void 0:(l===!0?this.child.show():l===!1?Gh(this):g.length&&this.length&&IT(g[0],g[0].aoData[this[0]],l,d),this)});Te([Ma+".show()",Vc+".show()"],function(l){return l0(this,!0),this});Te([Ma+".hide()",Vc+".hide()"],function(){return l0(this,!1),this});Te([Ma+".remove()",Vc+".remove()"],function(){return Gh(this),this});Te(Ma+".isShown()",function(){var l=this.context;return l.length&&this.length&&l[0].aoData[this[0]]._detailsShow||!1});var PT=/^([^:]+):(name|visIdx|visible)$/,c0=function(l,d,g,p,w){for(var A=[],_=0,y=w.length;_<y;_++)A.push(On(l,w[_],d));return A},BT=function(l,d,g){var p=l.aoColumns,w=zn(p,"sName"),A=zn(p,"nTh"),_=function(y){var k=xv(y);if(y==="")return os(p.length);if(k!==null)return[k>=0?k:p.length+k];if(typeof y=="function"){var T=Fc(l,g);return F.map(p,function(Q,se){return y(se,c0(l,se,0,0,T),A[se])?se:null})}var M=typeof y=="string"?y.match(PT):"";if(M)switch(M[2]){case"visIdx":case"visible":var B=parseInt(M[1],10);if(B<0){var P=F.map(p,function(Q,se){return Q.bVisible?se:null});return[P[P.length+B]]}return[xa(l,B)];case"name":return F.map(w,function(Q,se){return Q===M[1]?se:null});default:return[]}if(y.nodeName&&y._DT_CellIndex)return[y._DT_CellIndex.column];var O=F(A).filter(y).map(function(){return F.inArray(this,A)}).toArray();if(O.length||!y.nodeName)return O;var q=F(y).closest("*[data-dt-column]");return q.length?[q.data("dt-column")]:[]};return Uh("column",d,_,l,g)},LT=function(l,d,g){var p=l.aoColumns,w=p[d],A=l.aoData,_,y,k,T;if(g===void 0)return w.bVisible;if(w.bVisible!==g){if(g){var M=F.inArray(!0,zn(p,"bVisible"),d+1);for(y=0,k=A.length;y<k;y++)T=A[y].nTr,_=A[y].anCells,T&&T.insertBefore(_[d],_[M]||null)}else F(zn(l.aoData,"anCells",d)).detach();w.bVisible=g}};Te("columns()",function(l,d){l===void 0?l="":F.isPlainObject(l)&&(d=l,l=""),d=Wh(d);var g=this.iterator("table",function(p){return BT(p,l,d)},1);return g.selector.cols=l,g.selector.opts=d,g});Et("columns().header()","column().header()",function(l,d){return this.iterator("column",function(g,p){return g.aoColumns[p].nTh},1)});Et("columns().footer()","column().footer()",function(l,d){return this.iterator("column",function(g,p){return g.aoColumns[p].nTf},1)});Et("columns().data()","column().data()",function(){return this.iterator("column-rows",c0,1)});Et("columns().dataSrc()","column().dataSrc()",function(){return this.iterator("column",function(l,d){return l.aoColumns[d].mData},1)});Et("columns().cache()","column().cache()",function(l){return this.iterator("column-rows",function(d,g,p,w,A){return Ca(d.aoData,A,l==="search"?"_aFilterData":"_aSortData",g)},1)});Et("columns().nodes()","column().nodes()",function(){return this.iterator("column-rows",function(l,d,g,p,w){return Ca(l.aoData,w,"anCells",d)},1)});Et("columns().visible()","column().visible()",function(l,d){var g=this,p=this.iterator("column",function(w,A){if(l===void 0)return w.aoColumns[A].bVisible;LT(w,A,l)});return l!==void 0&&this.iterator("table",function(w){va(w,w.aoHeader),va(w,w.aoFooter),w.aiDisplay.length||F(w.nTBody).find("td[colspan]").attr("colspan",cs(w)),Ia(w),g.iterator("column",function(A,_){ct(A,null,"column-visibility",[A,_,l,d])}),(d===void 0||d)&&g.columns.adjust()}),p});Et("columns().indexes()","column().index()",function(l){return this.iterator("column",function(d,g){return l==="visible"?Da(d,g):g},1)});Te("columns.adjust()",function(){return this.iterator("table",function(l){ya(l)},1)});Te("column.index()",function(l,d){if(this.context.length!==0){var g=this.context[0];if(l==="fromVisible"||l==="toData")return xa(g,d);if(l==="fromData"||l==="toVisible")return Da(g,d)}});Te("column()",function(l,d){return qh(this.columns(l,d))});var zT=function(l,d,g){var p=l.aoData,w=Fc(l,g),A=Ev(Ca(p,w,"anCells")),_=F(Tv([],A)),y,k=l.aoColumns.length,T,M,B,P,O,q,Q=function(se){var ie=typeof se=="function";if(se==null||ie){for(T=[],M=0,B=w.length;M<B;M++)for(y=w[M],P=0;P<k;P++)O={row:y,column:P},ie?(q=p[y],se(O,On(l,y,P),q.anCells?q.anCells[P]:null)&&T.push(O)):T.push(O);return T}if(F.isPlainObject(se))return se.column!==void 0&&se.row!==void 0&&F.inArray(se.row,w)!==-1?[se]:[];var K=_.filter(se).map(function(Ae,Ee){return{row:Ee._DT_CellIndex.row,column:Ee._DT_CellIndex.column}}).toArray();return K.length||!se.nodeName?K:(q=F(se).closest("*[data-dt-row]"),q.length?[{row:q.data("dt-row"),column:q.data("dt-column")}]:[])};return Uh("cell",d,Q,l,g)};Te("cells()",function(l,d,g){if(F.isPlainObject(l)&&(l.row===void 0?(g=l,l=null):(g=d,d=null)),F.isPlainObject(d)&&(g=d,d=null),d==null)return this.iterator("table",function(P){return zT(P,l,Wh(g))});var p=g?{page:g.page,order:g.order,search:g.search}:{},w=this.columns(d,p),A=this.rows(l,p),_,y,k,T,M=this.iterator("table",function(P,O){var q=[];for(_=0,y=A[O].length;_<y;_++)for(k=0,T=w[O].length;k<T;k++)q.push({row:A[O][_],column:w[O][k]});return q},1),B=g&&g.selected?this.cells(M,g):M;return F.extend(B.selector,{cols:d,rows:l,opts:g}),B});Et("cells().nodes()","cell().node()",function(){return this.iterator("cell",function(l,d,g){var p=l.aoData[d];return p&&p.anCells?p.anCells[g]:void 0},1)});Te("cells().data()",function(){return this.iterator("cell",function(l,d,g){return On(l,d,g)},1)});Et("cells().cache()","cell().cache()",function(l){return l=l==="search"?"_aFilterData":"_aSortData",this.iterator("cell",function(d,g,p){return d.aoData[g][l][p]},1)});Et("cells().render()","cell().render()",function(l){return this.iterator("cell",function(d,g,p){return On(d,g,p,l)},1)});Et("cells().indexes()","cell().index()",function(){return this.iterator("cell",function(l,d,g){return{row:d,column:g,columnVisible:Da(l,g)}},1)});Et("cells().invalidate()","cell().invalidate()",function(l){return this.iterator("cell",function(d,g,p){Ea(d,g,l,p)})});Te("cell()",function(l,d,g){return qh(this.cells(l,d,g))});Te("cell().data()",function(l){var d=this.context,g=this[0];return l===void 0?d.length&&g.length?On(d[0],g[0].row,g[0].column):void 0:(Pv(d[0],g[0].row,g[0].column,l),Ea(d[0],g[0].row,"data",g[0].column),this)});Te("order()",function(l,d){var g=this.context;return l===void 0?g.length!==0?g[0].aaSorting:void 0:(typeof l=="number"?l=[[l,d]]:l.length&&!Array.isArray(l[0])&&(l=Array.prototype.slice.call(arguments)),this.iterator("table",function(p){p.aaSorting=l.slice()}))});Te("order.listener()",function(l,d,g){return this.iterator("table",function(p){jh(p,l,d,g)})});Te("order.fixed()",function(l){if(!l){var d=this.context,g=d.length?d[0].aaSortingFixed:void 0;return Array.isArray(g)?{pre:g}:g}return this.iterator("table",function(p){p.aaSortingFixed=F.extend(!0,{},l)})});Te(["columns().order()","column().order()"],function(l){var d=this;return this.iterator("table",function(g,p){var w=[];F.each(d[p],function(A,_){w.push([_,l])}),g.aaSorting=w})});Te("search()",function(l,d,g,p){var w=this.context;return l===void 0?w.length!==0?w[0].oPreviousSearch.sSearch:void 0:this.iterator("table",function(A){A.oFeatures.bFilter&&Sa(A,F.extend({},A.oPreviousSearch,{sSearch:l+"",bRegex:d===null?!1:d,bSmart:g===null?!0:g,bCaseInsensitive:p===null?!0:p}),1)})});Et("columns().search()","column().search()",function(l,d,g,p){return this.iterator("column",function(w,A){var _=w.aoPreSearchCols;if(l===void 0)return _[A].sSearch;w.oFeatures.bFilter&&(F.extend(_[A],{sSearch:l+"",bRegex:d===null?!1:d,bSmart:g===null?!0:g,bCaseInsensitive:p===null?!0:p}),Sa(w,w.oPreviousSearch,1))})});Te("state()",function(){return this.context.length?this.context[0].oSavedState:null});Te("state.clear()",function(){return this.iterator("table",function(l){l.fnStateSaveCallback.call(l.oInstance,l,{})})});Te("state.loaded()",function(){return this.context.length?this.context[0].oLoadedState:null});Te("state.save()",function(){return this.iterator("table",function(l){Ia(l)})});ce.use=function(l,d){d==="lib"||l.fn?F=l:d=="win"||l.document?(window=l,document=l.document):(d==="datetime"||l.type==="DateTime")&&(ce.DateTime=l)};ce.factory=function(l,d){var g=!1;return l&&l.document&&(window=l,document=l.document),d&&d.fn&&d.fn.jquery&&(F=d,g=!0),g};ce.versionCheck=ce.fnVersionCheck=function(l){for(var d=ce.version.split("."),g=l.split("."),p,w,A=0,_=g.length;A<_;A++)if(p=parseInt(d[A],10)||0,w=parseInt(g[A],10)||0,p!==w)return p>w;return!0};ce.isDataTable=ce.fnIsDataTable=function(l){var d=F(l).get(0),g=!1;return l instanceof ce.Api?!0:(F.each(ce.settings,function(p,w){var A=w.nScrollHead?F("table",w.nScrollHead)[0]:null,_=w.nScrollFoot?F("table",w.nScrollFoot)[0]:null;(w.nTable===d||A===d||_===d)&&(g=!0)}),g)};ce.tables=ce.fnTables=function(l){var d=!1;F.isPlainObject(l)&&(d=l.api,l=l.visible);var g=F.map(ce.settings,function(p){if(!l||l&&F(p.nTable).is(":visible"))return p.nTable});return d?new et(g):g};ce.camelToHungarian=ho;Te("$()",function(l,d){var g=this.rows(d).nodes(),p=F(g);return F([].concat(p.filter(l).toArray(),p.find(l).toArray()))});F.each(["on","one","off"],function(l,d){Te(d+"()",function(){var g=Array.prototype.slice.call(arguments);g[0]=F.map(g[0].split(/\s/),function(w){return w.match(/\.dt\b/)?w:w+".dt"}).join(" ");var p=F(this.tables().nodes());return p[d].apply(p,g),this})});Te("clear()",function(){return this.iterator("table",function(l){Lc(l)})});Te("settings()",function(){return new et(this.context,this.context)});Te("init()",function(){var l=this.context;return l.length?l[0].oInit:null});Te("data()",function(){return this.iterator("table",function(l){return zn(l.aoData,"_aData")}).flatten()});Te("destroy()",function(l){return l=l||!1,this.iterator("table",function(d){var g=d.oClasses,p=d.nTable,w=d.nTBody,A=d.nTHead,_=d.nTFoot,y=F(p),k=F(w),T=F(d.nTableWrapper),M=F.map(d.aoData,function(Q){return Q.nTr}),B;d.bDestroying=!0,ct(d,"aoDestroyCallback","destroy",[d]),l||new et(d).columns().visible(!0),T.off(".DT").find(":not(tbody *)").off(".DT"),F(window).off(".DT-"+d.sInstance),p!=A.parentNode&&(y.children("thead").detach(),y.append(A)),_&&p!=_.parentNode&&(y.children("tfoot").detach(),y.append(_)),d.aaSorting=[],d.aaSortingFixed=[],Ac(d),F(M).removeClass(d.asStripeClasses.join(" ")),F("th, td",A).removeClass(g.sSortable+" "+g.sSortableAsc+" "+g.sSortableDesc+" "+g.sSortableNone),k.children().detach(),k.append(M);var P=d.nTableWrapper.parentNode,O=l?"remove":"detach";y[O](),T[O](),!l&&P&&(P.insertBefore(p,d.nTableReinsertBefore),y.css("width",d.sDestroyWidth).removeClass(g.sTable),B=d.asDestroyStripes.length,B&&k.children().each(function(Q){F(this).addClass(d.asDestroyStripes[Q%B])}));var q=F.inArray(d,ce.settings);q!==-1&&ce.settings.splice(q,1)})});F.each(["column","row","cell"],function(l,d){Te(d+"s().every()",function(g){var p=this.selector.opts,w=this;return this.iterator(d,function(A,_,y,k,T){g.call(w[d](_,d==="cell"?y:p,d==="cell"?p:void 0),_,y,k,T)})})});Te("i18n()",function(l,d,g){var p=this.context[0],w=as(l)(p.oLanguage);return w===void 0&&(w=d),g!==void 0&&F.isPlainObject(w)&&(w=w[g]!==void 0?w[g]:w._),typeof w=="string"?w.replace("%d",g):w});ce.version="1.13.11";ce.settings=[];ce.models={};ce.models.oSearch={bCaseInsensitive:!0,sSearch:"",bRegex:!1,bSmart:!0,return:!1};ce.models.oRow={nTr:null,anCells:null,_aData:[],_aSortData:null,_aFilterData:null,_sFilterRow:null,_sRowStripe:"",src:null,idx:-1};ce.models.oColumn={idx:null,aDataSort:null,asSorting:null,bSearchable:null,bSortable:null,bVisible:null,_sManualType:null,_bAttrSrc:!1,fnCreatedCell:null,fnGetData:null,fnSetData:null,mData:null,mRender:null,nTh:null,nTf:null,sClass:null,sContentPadding:null,sDefaultContent:null,sName:null,sSortDataType:"std",sSortingClass:null,sSortingClassJUI:null,sTitle:null,sType:null,sWidth:null,sWidthOrig:null};ce.defaults={aaData:null,aaSorting:[[0,"asc"]],aaSortingFixed:[],ajax:null,aLengthMenu:[10,25,50,100],aoColumns:null,aoColumnDefs:null,aoSearchCols:[],asStripeClasses:null,bAutoWidth:!0,bDeferRender:!1,bDestroy:!1,bFilter:!0,bInfo:!0,bLengthChange:!0,bPaginate:!0,bProcessing:!1,bRetrieve:!1,bScrollCollapse:!1,bServerSide:!1,bSort:!0,bSortMulti:!0,bSortCellsTop:!1,bSortClasses:!0,bStateSave:!1,fnCreatedRow:null,fnDrawCallback:null,fnFooterCallback:null,fnFormatNumber:function(l){return l.toString().replace(/\B(?=(\d{3})+(?!\d))/g,this.oLanguage.sThousands)},fnHeaderCallback:null,fnInfoCallback:null,fnInitComplete:null,fnPreDrawCallback:null,fnRowCallback:null,fnServerData:null,fnServerParams:null,fnStateLoadCallback:function(l){try{return JSON.parse((l.iStateDuration===-1?sessionStorage:localStorage).getItem("DataTables_"+l.sInstance+"_"+location.pathname))}catch{return{}}},fnStateLoadParams:null,fnStateLoaded:null,fnStateSaveCallback:function(l,d){try{(l.iStateDuration===-1?sessionStorage:localStorage).setItem("DataTables_"+l.sInstance+"_"+location.pathname,JSON.stringify(d))}catch{}},fnStateSaveParams:null,iStateDuration:7200,iDeferLoading:null,iDisplayLength:10,iDisplayStart:0,iTabIndex:0,oClasses:{},oLanguage:{oAria:{sSortAscending:": activate to sort column ascending",sSortDescending:": activate to sort column descending"},oPaginate:{sFirst:"First",sLast:"Last",sNext:"Next",sPrevious:"Previous"},sEmptyTable:"No data available in table",sInfo:"Showing _START_ to _END_ of _TOTAL_ entries",sInfoEmpty:"Showing 0 to 0 of 0 entries",sInfoFiltered:"(filtered from _MAX_ total entries)",sInfoPostFix:"",sDecimal:"",sThousands:",",sLengthMenu:"Show _MENU_ entries",sLoadingRecords:"Loading...",sProcessing:"",sSearch:"Search:",sSearchPlaceholder:"",sUrl:"",sZeroRecords:"No matching records found"},oSearch:F.extend({},ce.models.oSearch),sAjaxDataProp:"data",sAjaxSource:null,sDom:"lfrtip",searchDelay:null,sPaginationType:"simple_numbers",sScrollX:"",sScrollXInner:"",sScrollY:"",sServerMethod:"GET",renderer:null,rowId:"DT_RowId"};Aa(ce.defaults);ce.defaults.column={aDataSort:null,iDataSort:-1,asSorting:["asc","desc"],bSearchable:!0,bSortable:!0,bVisible:!0,fnCreatedCell:null,mData:null,mRender:null,sCellType:"td",sClass:"",sContentPadding:"",sDefaultContent:null,sName:"",sSortDataType:"std",sTitle:null,sType:null,sWidth:null};Aa(ce.defaults.column);ce.models.oSettings={oFeatures:{bAutoWidth:null,bDeferRender:null,bFilter:null,bInfo:null,bLengthChange:null,bPaginate:null,bProcessing:null,bServerSide:null,bSort:null,bSortMulti:null,bSortClasses:null,bStateSave:null},oScroll:{bCollapse:null,iBarWidth:0,sX:null,sXInner:null,sY:null},oLanguage:{fnInfoCallback:null},oBrowser:{bScrollOversize:!1,bScrollbarLeft:!1,bBounding:!1,barWidth:0},ajax:null,aanFeatures:[],aoData:[],aiDisplay:[],aiDisplayMaster:[],aIds:{},aoColumns:[],aoHeader:[],aoFooter:[],oPreviousSearch:{},aoPreSearchCols:[],aaSorting:null,aaSortingFixed:[],asStripeClasses:null,asDestroyStripes:[],sDestroyWidth:0,aoRowCallback:[],aoHeaderCallback:[],aoFooterCallback:[],aoDrawCallback:[],aoRowCreatedCallback:[],aoPreDrawCallback:[],aoInitComplete:[],aoStateSaveParams:[],aoStateLoadParams:[],aoStateLoaded:[],sTableId:"",nTable:null,nTHead:null,nTFoot:null,nTBody:null,nTableWrapper:null,bDeferLoading:!1,bInitialised:!1,aoOpenRows:[],sDom:null,searchDelay:null,sPaginationType:"two_button",iStateDuration:0,aoStateSave:[],aoStateLoad:[],oSavedState:null,oLoadedState:null,sAjaxSource:null,sAjaxDataProp:null,jqXHR:null,json:void 0,oAjaxData:void 0,fnServerData:null,aoServerParams:[],sServerMethod:null,fnFormatNumber:null,aLengthMenu:null,iDraw:0,bDrawing:!1,iDrawError:-1,_iDisplayLength:10,_iDisplayStart:0,_iRecordsTotal:0,_iRecordsDisplay:0,oClasses:{},bFiltered:!1,bSorted:!1,bSortCellsTop:null,oInit:null,aoDestroyCallback:[],fnRecordsTotal:function(){return mn(this)=="ssp"?this._iRecordsTotal*1:this.aiDisplayMaster.length},fnRecordsDisplay:function(){return mn(this)=="ssp"?this._iRecordsDisplay*1:this.aiDisplay.length},fnDisplayEnd:function(){var l=this._iDisplayLength,d=this._iDisplayStart,g=d+l,p=this.aiDisplay.length,w=this.oFeatures,A=w.bPaginate;return w.bServerSide?A===!1||l===-1?d+p:Math.min(d+l,this._iRecordsDisplay):!A||g>p||l===-1?p:g},oInstance:null,sInstance:null,iTabIndex:0,nScrollHead:null,nScrollFoot:null,aLastSort:[],oPlugins:{},rowIdFn:null,rowId:null};ce.ext=Ut={buttons:{},classes:{},builder:"-source-",errMode:"alert",feature:[],search:[],selector:{cell:[],column:[],row:[]},internal:{},legacy:{ajax:null},pager:{},renderer:{pageButton:{},header:{}},order:{},type:{detect:[],search:{},order:{}},_unique:0,fnVersionCheck:ce.fnVersionCheck,iApiIndex:0,oJUIClasses:{},sVersion:ce.version};F.extend(Ut,{afnFiltering:Ut.search,aTypes:Ut.type.detect,ofnSearch:Ut.type.search,oSort:Ut.type.order,afnSortData:Ut.order,aoFeatures:Ut.feature,oApi:Ut.internal,oStdClasses:Ut.classes,oPagination:Ut.pager});F.extend(ce.ext.classes,{sTable:"dataTable",sNoFooter:"no-footer",sPageButton:"paginate_button",sPageButtonActive:"current",sPageButtonDisabled:"disabled",sStripeOdd:"odd",sStripeEven:"even",sRowEmpty:"dataTables_empty",sWrapper:"dataTables_wrapper",sFilter:"dataTables_filter",sInfo:"dataTables_info",sPaging:"dataTables_paginate paging_",sLength:"dataTables_length",sProcessing:"dataTables_processing",sSortAsc:"sorting_asc",sSortDesc:"sorting_desc",sSortable:"sorting",sSortableAsc:"sorting_desc_disabled",sSortableDesc:"sorting_asc_disabled",sSortableNone:"sorting_disabled",sSortColumn:"sorting_",sFilterInput:"",sLengthSelect:"",sScrollWrapper:"dataTables_scroll",sScrollHead:"dataTables_scrollHead",sScrollHeadInner:"dataTables_scrollHeadInner",sScrollBody:"dataTables_scrollBody",sScrollFoot:"dataTables_scrollFoot",sScrollFootInner:"dataTables_scrollFootInner",sHeaderTH:"",sFooterTH:"",sSortJUIAsc:"",sSortJUIDesc:"",sSortJUI:"",sSortJUIAscAllowed:"",sSortJUIDescAllowed:"",sSortJUIWrapper:"",sSortIcon:"",sJUIHeader:"",sJUIFooter:""});var d0=ce.ext.pager;function la(l,d){var g=[],p=d0.numbers_length,w=Math.floor(p/2);return d<=p?g=os(0,d):l<=w?(g=os(0,p-2),g.push("ellipsis"),g.push(d-1)):l>=d-1-w?(g=os(d-(p-2),d),g.splice(0,0,"ellipsis"),g.splice(0,0,0)):(g=os(l-w+2,l+w-1),g.push("ellipsis"),g.push(d-1),g.splice(0,0,"ellipsis"),g.splice(0,0,0)),g.DT_el="span",g}F.extend(d0,{simple:function(l,d){return["previous","next"]},full:function(l,d){return["first","previous","next","last"]},numbers:function(l,d){return[la(l,d)]},simple_numbers:function(l,d){return["previous",la(l,d),"next"]},full_numbers:function(l,d){return["first","previous",la(l,d),"next","last"]},first_last_numbers:function(l,d){return["first",la(l,d),"last"]},_numbers:la,numbers_length:7});F.extend(!0,ce.ext.renderer,{pageButton:{_:function(l,d,g,p,w,A){var _=l.oClasses,y=l.oLanguage.oPaginate,k=l.oLanguage.oAria.paginate||{},T,M,B=function(O,q){var Q,se,ie,K,Ae=_.sPageButtonDisabled,Ee=function(we){Rc(l,we.data.action,!0)};for(Q=0,se=q.length;Q<se;Q++)if(K=q[Q],Array.isArray(K)){var Se=F("<"+(K.DT_el||"div")+"/>").appendTo(O);B(Se,K)}else{var V=!1;switch(T=null,M=K,K){case"ellipsis":O.append('<span class="ellipsis">&#x2026;</span>');break;case"first":T=y.sFirst,w===0&&(V=!0);break;case"previous":T=y.sPrevious,w===0&&(V=!0);break;case"next":T=y.sNext,(A===0||w===A-1)&&(V=!0);break;case"last":T=y.sLast,(A===0||w===A-1)&&(V=!0);break;default:T=l.fnFormatNumber(K+1),M=w===K?_.sPageButtonActive:"";break}if(T!==null){var x=l.oInit.pagingTag||"a";V&&(M+=" "+Ae),ie=F("<"+x+">",{class:_.sPageButton+" "+M,"aria-controls":l.sTableId,"aria-disabled":V?"true":null,"aria-label":k[K],role:"link","aria-current":M===_.sPageButtonActive?"page":null,"data-dt-idx":K,tabindex:V?-1:l.iTabIndex,id:g===0&&typeof K=="string"?l.sTableId+"_"+K:null}).html(T).appendTo(O),Fh(ie,{action:K},Ee)}}},P;try{P=F(d).find(document.activeElement).data("dt-idx")}catch{}B(F(d).empty(),p),P!==void 0&&F(d).find("[data-dt-idx="+P+"]").trigger("focus")}}});F.extend(ce.ext.type.detect,[function(l,d){var g=d.oLanguage.sDecimal;return bh(l,g)?"num"+g:null},function(l,d){if(l&&!(l instanceof Date)&&!kT.test(l))return null;var g=Date.parse(l);return g!==null&&!isNaN(g)||Yi(l)?"date":null},function(l,d){var g=d.oLanguage.sDecimal;return bh(l,g,!0)?"num-fmt"+g:null},function(l,d){var g=d.oLanguage.sDecimal;return av(l,g)?"html-num"+g:null},function(l,d){var g=d.oLanguage.sDecimal;return av(l,g,!0)?"html-num-fmt"+g:null},function(l,d){return Yi(l)||typeof l=="string"&&l.indexOf("<")!==-1?"html":null}]);F.extend(ce.ext.type.search,{html:function(l){return Yi(l)?l:typeof l=="string"?l.replace(sv," ").replace(vc,""):""},string:function(l){return Yi(l)?l:typeof l=="string"?l.replace(sv," "):l}});var ac=function(l,d,g,p){if(l!==0&&(!l||l==="-"))return-1/0;var w=typeof l;return w==="number"||w==="bigint"?l:(d&&(l=Dv(l,d)),l.replace&&(g&&(l=l.replace(g,"")),p&&(l=l.replace(p,""))),l*1)};function yh(l){F.each({num:function(d){return ac(d,l)},"num-fmt":function(d){return ac(d,l,mh)},"html-num":function(d){return ac(d,l,vc)},"html-num-fmt":function(d){return ac(d,l,vc,mh)}},function(d,g){Ut.type.order[d+l+"-pre"]=g,d.match(/^html\-/)&&(Ut.type.search[d+l]=Ut.type.search.html)})}F.extend(Ut.type.order,{"date-pre":function(l){var d=Date.parse(l);return isNaN(d)?-1/0:d},"html-pre":function(l){return Yi(l)?"":l.replace?l.replace(/<.*?>/g,"").toLowerCase():l+""},"string-pre":function(l){return Yi(l)?"":typeof l=="string"?l.toLowerCase():l.toString?l.toString():""},"string-asc":function(l,d){return l<d?-1:l>d?1:0},"string-desc":function(l,d){return l<d?1:l>d?-1:0}});yh("");F.extend(!0,ce.ext.renderer,{header:{_:function(l,d,g,p){F(l.nTable).on("order.dt.DT",function(w,A,_,y){if(l===A){var k=g.idx;d.removeClass(p.sSortAsc+" "+p.sSortDesc).addClass(y[k]=="asc"?p.sSortAsc:y[k]=="desc"?p.sSortDesc:g.sSortingClass)}})},jqueryui:function(l,d,g,p){F("<div/>").addClass(p.sSortJUIWrapper).append(d.contents()).append(F("<span/>").addClass(p.sSortIcon+" "+g.sSortingClassJUI)).appendTo(d),F(l.nTable).on("order.dt.DT",function(w,A,_,y){if(l===A){var k=g.idx;d.removeClass(p.sSortAsc+" "+p.sSortDesc).addClass(y[k]=="asc"?p.sSortAsc:y[k]=="desc"?p.sSortDesc:g.sSortingClass),d.find("span."+p.sSortIcon).removeClass(p.sSortJUIAsc+" "+p.sSortJUIDesc+" "+p.sSortJUI+" "+p.sSortJUIAscAllowed+" "+p.sSortJUIDescAllowed).addClass(y[k]=="asc"?p.sSortJUIAsc:y[k]=="desc"?p.sSortJUIDesc:g.sSortingClassJUI)}})}}});var gc=function(l){return Array.isArray(l)&&(l=l.join(",")),typeof l=="string"?l.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;"):l};function hv(l,d,g,p,w){return window.moment?l[d](w):window.luxon?l[g](w):p?l[p](w):l}var fv=!1;function xc(l,d,g){var p;if(window.moment){if(p=window.moment.utc(l,d,g,!0),!p.isValid())return null}else if(window.luxon){if(p=d&&typeof l=="string"?window.luxon.DateTime.fromFormat(l,d):window.luxon.DateTime.fromISO(l),!p.isValid)return null;p.setLocale(g)}else d?(fv||alert("DataTables warning: Formatted date without Moment.js or Luxon - https://datatables.net/tn/17"),fv=!0):p=new Date(l);return p}function sh(l){return function(d,g,p,w){arguments.length===0?(p="en",g=null,d=null):arguments.length===1?(p="en",g=d,d=null):arguments.length===2&&(p=g,g=d,d=null);var A="datetime-"+g;return ce.ext.type.order[A]||(ce.ext.type.detect.unshift(function(_){return _===A?A:!1}),ce.ext.type.order[A+"-asc"]=function(_,y){var k=_.valueOf(),T=y.valueOf();return k===T?0:k<T?-1:1},ce.ext.type.order[A+"-desc"]=function(_,y){var k=_.valueOf(),T=y.valueOf();return k===T?0:k>T?-1:1}),function(_,y){if(_==null)if(w==="--now"){var k=new Date;_=new Date(Date.UTC(k.getFullYear(),k.getMonth(),k.getDate(),k.getHours(),k.getMinutes(),k.getSeconds()))}else _="";if(y==="type")return A;if(_==="")return y!=="sort"?"":xc("0000-01-01 00:00:00",null,p);if(g!==null&&d===g&&y!=="sort"&&y!=="type"&&!(_ instanceof Date))return _;var T=xc(_,d,p);if(T===null)return _;if(y==="sort")return T;var M=g===null?hv(T,"toDate","toJSDate","")[l]():hv(T,"format","toFormat","toISOString",g);return y==="display"?gc(M):M}}}var u0=",",h0=".";if(window.Intl!==void 0)try{for(var ca=new Intl.NumberFormat().formatToParts(100000.1),es=0;es<ca.length;es++)ca[es].type==="group"?u0=ca[es].value:ca[es].type==="decimal"&&(h0=ca[es].value)}catch{}ce.datetime=function(l,d){var g="datetime-detect-"+l;d||(d="en"),ce.ext.type.order[g]||(ce.ext.type.detect.unshift(function(p){var w=xc(p,l,d);return p===""||w?g:!1}),ce.ext.type.order[g+"-pre"]=function(p){return xc(p,l,d)||0})};ce.render={date:sh("toLocaleDateString"),datetime:sh("toLocaleString"),time:sh("toLocaleTimeString"),number:function(l,d,g,p,w){return l==null&&(l=u0),d==null&&(d=h0),{display:function(A){if(typeof A!="number"&&typeof A!="string"||A===""||A===null)return A;var _=A<0?"-":"",y=parseFloat(A);if(isNaN(y))return gc(A);y=y.toFixed(g),A=Math.abs(y);var k=parseInt(A,10),T=g?d+(A-k).toFixed(g).substring(2):"";return k===0&&parseFloat(T)===0&&(_=""),_+(p||"")+k.toString().replace(/\B(?=(\d{3})+(?!\d))/g,l)+T+(w||"")}}},text:function(){return{display:gc,filter:gc}}};function f0(l){return function(){var d=[yc(this[ce.ext.iApiIndex])].concat(Array.prototype.slice.call(arguments));return ce.ext.internal[l].apply(this,d)}}F.extend(ce.ext.internal,{_fnExternApiFunc:f0,_fnBuildAjax:Oc,_fnAjaxUpdate:zv,_fnAjaxParameters:Ov,_fnAjaxUpdateDraw:Rv,_fnAjaxDataSrc:Ta,_fnAddColumn:Sh,_fnColumnOptions:_c,_fnAdjustColumnSizing:ya,_fnVisibleToColumnIndex:xa,_fnColumnIndexToVisible:Da,_fnVisbleColumns:cs,_fnGetColumns:Pc,_fnColumnTypes:Ih,_fnApplyColumnDefs:Nv,_fnHungarianMap:Aa,_fnCamelToHungarian:ho,_fnLanguageCompat:kh,_fnBrowserDetect:Mv,_fnAddData:Fo,_fnAddTr:Bc,_fnNodeToDataIndex:AT,_fnNodeToColumnIndex:yT,_fnGetCellData:On,_fnSetCellData:Pv,_fnSplitObjNotation:wh,_fnGetObjectDataFn:as,_fnSetObjectDataFn:Ro,_fnGetDataMaster:vh,_fnClearTable:Lc,_fnDeleteIndex:hc,_fnInvalidate:Ea,_fnGetRowElements:Mh,_fnCreateTr:Nh,_fnBuildHead:Bv,_fnDrawHead:va,_fnDraw:Vo,_fnReDraw:kr,_fnAddOptionsHtml:Lv,_fnDetectHeader:_a,_fnGetUniqueThs:zc,_fnFeatureHtmlFilter:jv,_fnFilterComplete:Sa,_fnFilterCustom:Fv,_fnFilterColumn:Vv,_fnFilter:Hv,_fnFilterCreateSearch:Bh,_fnEscapeRegex:Lh,_fnFilterData:Uv,_fnFeatureHtmlInfo:Wv,_fnUpdateInfo:qv,_fnInfoMacros:Gv,_fnInitialise:ga,_fnInitComplete:Cc,_fnLengthChange:zh,_fnFeatureHtmlLength:$v,_fnFeatureHtmlPaginate:Yv,_fnPageChange:Rc,_fnFeatureHtmlProcessing:Kv,_fnProcessingDisplay:Zn,_fnFeatureHtmlTable:Qv,_fnScrollDraw:jc,_fnApplyToChildren:Gi,_fnCalculateColumnWidths:Oh,_fnThrottle:Rh,_fnConvertToWidth:Zv,_fnGetWidestNode:Jv,_fnGetMaxLenString:Xv,_fnStringToCss:Rt,_fnSortFlatten:ds,_fnSort:e0,_fnSortAria:t0,_fnSortListener:_h,_fnSortAttachListener:jh,_fnSortingClasses:Ac,_fnSortData:n0,_fnSaveState:Ia,_fnLoadState:i0,_fnImplementState:Ch,_fnSettingsFromNode:yc,_fnLog:gi,_fnMap:Di,_fnBindAction:Fh,_fnCallbackReg:An,_fnCallbackFire:ct,_fnLengthOverflow:Vh,_fnRenderer:Hh,_fnDataSource:mn,_fnRowAttributes:Ph,_fnExtend:Ah,_fnCalculateEnd:function(){}});F.fn.dataTable=ce;ce.$=F;F.fn.dataTableSettings=ce.settings;F.fn.dataTableExt=ce.ext;F.fn.DataTable=function(l){return F(this).dataTable(l).api()};F.each(ce,function(l,d){F.fn.DataTable[l]=d});/**!
 * Sortable 1.15.2
 * @author	RubaXa   <trash@rubaxa.org>
 * @author	owenm    <owen23355@gmail.com>
 * @license MIT
 */function gv(l,d){var g=Object.keys(l);if(Object.getOwnPropertySymbols){var p=Object.getOwnPropertySymbols(l);d&&(p=p.filter(function(w){return Object.getOwnPropertyDescriptor(l,w).enumerable})),g.push.apply(g,p)}return g}function Ki(l){for(var d=1;d<arguments.length;d++){var g=arguments[d]!=null?arguments[d]:{};d%2?gv(Object(g),!0).forEach(function(p){OT(l,p,g[p])}):Object.getOwnPropertyDescriptors?Object.defineProperties(l,Object.getOwnPropertyDescriptors(g)):gv(Object(g)).forEach(function(p){Object.defineProperty(l,p,Object.getOwnPropertyDescriptor(g,p))})}return l}function pc(l){"@babel/helpers - typeof";return typeof Symbol=="function"&&typeof Symbol.iterator=="symbol"?pc=function(d){return typeof d}:pc=function(d){return d&&typeof Symbol=="function"&&d.constructor===Symbol&&d!==Symbol.prototype?"symbol":typeof d},pc(l)}function OT(l,d,g){return d in l?Object.defineProperty(l,d,{value:g,enumerable:!0,configurable:!0,writable:!0}):l[d]=g,l}function go(){return go=Object.assign||function(l){for(var d=1;d<arguments.length;d++){var g=arguments[d];for(var p in g)Object.prototype.hasOwnProperty.call(g,p)&&(l[p]=g[p])}return l},go.apply(this,arguments)}function RT(l,d){if(l==null)return{};var g={},p=Object.keys(l),w,A;for(A=0;A<p.length;A++)w=p[A],!(d.indexOf(w)>=0)&&(g[w]=l[w]);return g}function jT(l,d){if(l==null)return{};var g=RT(l,d),p,w;if(Object.getOwnPropertySymbols){var A=Object.getOwnPropertySymbols(l);for(w=0;w<A.length;w++)p=A[w],!(d.indexOf(p)>=0)&&Object.prototype.propertyIsEnumerable.call(l,p)&&(g[p]=l[p])}return g}var FT="1.15.2";function fo(l){if(typeof window<"u"&&window.navigator)return!!navigator.userAgent.match(l)}var po=fo(/(?:Trident.*rv[ :]?11\.|msie|iemobile|Windows Phone)/i),Na=fo(/Edge/i),pv=fo(/firefox/i),pa=fo(/safari/i)&&!fo(/chrome/i)&&!fo(/android/i),g0=fo(/iP(ad|od|hone)/i),p0=fo(/chrome/i)&&fo(/android/i),m0={capture:!1,passive:!1};function lt(l,d,g){l.addEventListener(d,g,!po&&m0)}function st(l,d,g){l.removeEventListener(d,g,!po&&m0)}function Dc(l,d){if(d){if(d[0]===">"&&(d=d.substring(1)),l)try{if(l.matches)return l.matches(d);if(l.msMatchesSelector)return l.msMatchesSelector(d);if(l.webkitMatchesSelector)return l.webkitMatchesSelector(d)}catch{return!1}return!1}}function VT(l){return l.host&&l!==document&&l.host.nodeType?l.host:l.parentNode}function xi(l,d,g,p){if(l){g=g||document;do{if(d!=null&&(d[0]===">"?l.parentNode===g&&Dc(l,d):Dc(l,d))||p&&l===g)return l;if(l===g)break}while(l=VT(l))}return null}var mv=/\s+/g;function Yn(l,d,g){if(l&&d)if(l.classList)l.classList[g?"add":"remove"](d);else{var p=(" "+l.className+" ").replace(mv," ").replace(" "+d+" "," ");l.className=(p+(g?" "+d:"")).replace(mv," ")}}function Le(l,d,g){var p=l&&l.style;if(p){if(g===void 0)return document.defaultView&&document.defaultView.getComputedStyle?g=document.defaultView.getComputedStyle(l,""):l.currentStyle&&(g=l.currentStyle),d===void 0?g:g[d];!(d in p)&&d.indexOf("webkit")===-1&&(d="-webkit-"+d),p[d]=g+(typeof g=="string"?"":"px")}}function ss(l,d){var g="";if(typeof l=="string")g=l;else do{var p=Le(l,"transform");p&&p!=="none"&&(g=p+" "+g)}while(!d&&(l=l.parentNode));var w=window.DOMMatrix||window.WebKitCSSMatrix||window.CSSMatrix||window.MSCSSMatrix;return w&&new w(g)}function b0(l,d,g){if(l){var p=l.getElementsByTagName(d),w=0,A=p.length;if(g)for(;w<A;w++)g(p[w],w);return p}return[]}function $i(){var l=document.scrollingElement;return l||document.documentElement}function Wt(l,d,g,p,w){if(!(!l.getBoundingClientRect&&l!==window)){var A,_,y,k,T,M,B;if(l!==window&&l.parentNode&&l!==$i()?(A=l.getBoundingClientRect(),_=A.top,y=A.left,k=A.bottom,T=A.right,M=A.height,B=A.width):(_=0,y=0,k=window.innerHeight,T=window.innerWidth,M=window.innerHeight,B=window.innerWidth),(d||g)&&l!==window&&(w=w||l.parentNode,!po))do if(w&&w.getBoundingClientRect&&(Le(w,"transform")!=="none"||g&&Le(w,"position")!=="static")){var P=w.getBoundingClientRect();_-=P.top+parseInt(Le(w,"border-top-width")),y-=P.left+parseInt(Le(w,"border-left-width")),k=_+A.height,T=y+A.width;break}while(w=w.parentNode);if(p&&l!==window){var O=ss(w||l),q=O&&O.a,Q=O&&O.d;O&&(_/=Q,y/=q,B/=q,M/=Q,k=_+M,T=y+B)}return{top:_,left:y,bottom:k,right:T,width:B,height:M}}}function bv(l,d,g){for(var p=jo(l,!0),w=Wt(l)[d];p;){var A=Wt(p)[g],_=void 0;if(g==="top"||g==="left"?_=w>=A:_=w<=A,!_)return p;if(p===$i())break;p=jo(p,!1)}return!1}function ls(l,d,g,p){for(var w=0,A=0,_=l.children;A<_.length;){if(_[A].style.display!=="none"&&_[A]!==Re.ghost&&(p||_[A]!==Re.dragged)&&xi(_[A],g.draggable,l,!1)){if(w===d)return _[A];w++}A++}return null}function $h(l,d){for(var g=l.lastElementChild;g&&(g===Re.ghost||Le(g,"display")==="none"||d&&!Dc(g,d));)g=g.previousElementSibling;return g||null}function fi(l,d){var g=0;if(!l||!l.parentNode)return-1;for(;l=l.previousElementSibling;)l.nodeName.toUpperCase()!=="TEMPLATE"&&l!==Re.clone&&(!d||Dc(l,d))&&g++;return g}function kv(l){var d=0,g=0,p=$i();if(l)do{var w=ss(l),A=w.a,_=w.d;d+=l.scrollLeft*A,g+=l.scrollTop*_}while(l!==p&&(l=l.parentNode));return[d,g]}function HT(l,d){for(var g in l)if(l.hasOwnProperty(g)){for(var p in d)if(d.hasOwnProperty(p)&&d[p]===l[g][p])return Number(g)}return-1}function jo(l,d){if(!l||!l.getBoundingClientRect)return $i();var g=l,p=!1;do if(g.clientWidth<g.scrollWidth||g.clientHeight<g.scrollHeight){var w=Le(g);if(g.clientWidth<g.scrollWidth&&(w.overflowX=="auto"||w.overflowX=="scroll")||g.clientHeight<g.scrollHeight&&(w.overflowY=="auto"||w.overflowY=="scroll")){if(!g.getBoundingClientRect||g===document.body)return $i();if(p||d)return g;p=!0}}while(g=g.parentNode);return $i()}function UT(l,d){if(l&&d)for(var g in d)d.hasOwnProperty(g)&&(l[g]=d[g]);return l}function ah(l,d){return Math.round(l.top)===Math.round(d.top)&&Math.round(l.left)===Math.round(d.left)&&Math.round(l.height)===Math.round(d.height)&&Math.round(l.width)===Math.round(d.width)}var ma;function k0(l,d){return function(){if(!ma){var g=arguments,p=this;g.length===1?l.call(p,g[0]):l.apply(p,g),ma=setTimeout(function(){ma=void 0},d)}}}function WT(){clearTimeout(ma),ma=void 0}function w0(l,d,g){l.scrollLeft+=d,l.scrollTop+=g}function v0(l){var d=window.Polymer,g=window.jQuery||window.Zepto;return d&&d.dom?d.dom(l).cloneNode(!0):g?g(l).clone(!0)[0]:l.cloneNode(!0)}function _0(l,d,g){var p={};return Array.from(l.children).forEach(function(w){var A,_,y,k;if(!(!xi(w,d.draggable,l,!1)||w.animated||w===g)){var T=Wt(w);p.left=Math.min((A=p.left)!==null&&A!==void 0?A:1/0,T.left),p.top=Math.min((_=p.top)!==null&&_!==void 0?_:1/0,T.top),p.right=Math.max((y=p.right)!==null&&y!==void 0?y:-1/0,T.right),p.bottom=Math.max((k=p.bottom)!==null&&k!==void 0?k:-1/0,T.bottom)}}),p.width=p.right-p.left,p.height=p.bottom-p.top,p.x=p.left,p.y=p.top,p}var Qn="Sortable"+new Date().getTime();function qT(){var l=[],d;return{captureAnimationState:function(){if(l=[],!!this.options.animation){var p=[].slice.call(this.el.children);p.forEach(function(w){if(!(Le(w,"display")==="none"||w===Re.ghost)){l.push({target:w,rect:Wt(w)});var A=Ki({},l[l.length-1].rect);if(w.thisAnimationDuration){var _=ss(w,!0);_&&(A.top-=_.f,A.left-=_.e)}w.fromRect=A}})}},addAnimationState:function(p){l.push(p)},removeAnimationState:function(p){l.splice(HT(l,{target:p}),1)},animateAll:function(p){var w=this;if(!this.options.animation){clearTimeout(d),typeof p=="function"&&p();return}var A=!1,_=0;l.forEach(function(y){var k=0,T=y.target,M=T.fromRect,B=Wt(T),P=T.prevFromRect,O=T.prevToRect,q=y.rect,Q=ss(T,!0);Q&&(B.top-=Q.f,B.left-=Q.e),T.toRect=B,T.thisAnimationDuration&&ah(P,B)&&!ah(M,B)&&(q.top-B.top)/(q.left-B.left)===(M.top-B.top)/(M.left-B.left)&&(k=$T(q,P,O,w.options)),ah(B,M)||(T.prevFromRect=M,T.prevToRect=B,k||(k=w.options.animation),w.animate(T,q,B,k)),k&&(A=!0,_=Math.max(_,k),clearTimeout(T.animationResetTimer),T.animationResetTimer=setTimeout(function(){T.animationTime=0,T.prevFromRect=null,T.fromRect=null,T.prevToRect=null,T.thisAnimationDuration=null},k),T.thisAnimationDuration=k)}),clearTimeout(d),A?d=setTimeout(function(){typeof p=="function"&&p()},_):typeof p=="function"&&p(),l=[]},animate:function(p,w,A,_){if(_){Le(p,"transition",""),Le(p,"transform","");var y=ss(this.el),k=y&&y.a,T=y&&y.d,M=(w.left-A.left)/(k||1),B=(w.top-A.top)/(T||1);p.animatingX=!!M,p.animatingY=!!B,Le(p,"transform","translate3d("+M+"px,"+B+"px,0)"),this.forRepaintDummy=GT(p),Le(p,"transition","transform "+_+"ms"+(this.options.easing?" "+this.options.easing:"")),Le(p,"transform","translate3d(0,0,0)"),typeof p.animated=="number"&&clearTimeout(p.animated),p.animated=setTimeout(function(){Le(p,"transition",""),Le(p,"transform",""),p.animated=!1,p.animatingX=!1,p.animatingY=!1},_)}}}}function GT(l){return l.offsetWidth}function $T(l,d,g,p){return Math.sqrt(Math.pow(d.top-l.top,2)+Math.pow(d.left-l.left,2))/Math.sqrt(Math.pow(d.top-g.top,2)+Math.pow(d.left-g.left,2))*p.animation}var ts=[],lh={initializeByDefault:!0},Pa={mount:function(d){for(var g in lh)lh.hasOwnProperty(g)&&!(g in d)&&(d[g]=lh[g]);ts.forEach(function(p){if(p.pluginName===d.pluginName)throw"Sortable: Cannot mount plugin ".concat(d.pluginName," more than once")}),ts.push(d)},pluginEvent:function(d,g,p){var w=this;this.eventCanceled=!1,p.cancel=function(){w.eventCanceled=!0};var A=d+"Global";ts.forEach(function(_){g[_.pluginName]&&(g[_.pluginName][A]&&g[_.pluginName][A](Ki({sortable:g},p)),g.options[_.pluginName]&&g[_.pluginName][d]&&g[_.pluginName][d](Ki({sortable:g},p)))})},initializePlugins:function(d,g,p,w){ts.forEach(function(y){var k=y.pluginName;if(!(!d.options[k]&&!y.initializeByDefault)){var T=new y(d,g,d.options);T.sortable=d,T.options=d.options,d[k]=T,go(p,T.defaults)}});for(var A in d.options)if(d.options.hasOwnProperty(A)){var _=this.modifyOption(d,A,d.options[A]);typeof _<"u"&&(d.options[A]=_)}},getEventProperties:function(d,g){var p={};return ts.forEach(function(w){typeof w.eventProperties=="function"&&go(p,w.eventProperties.call(g[w.pluginName],d))}),p},modifyOption:function(d,g,p){var w;return ts.forEach(function(A){d[A.pluginName]&&A.optionListeners&&typeof A.optionListeners[g]=="function"&&(w=A.optionListeners[g].call(d[A.pluginName],p))}),w}};function YT(l){var d=l.sortable,g=l.rootEl,p=l.name,w=l.targetEl,A=l.cloneEl,_=l.toEl,y=l.fromEl,k=l.oldIndex,T=l.newIndex,M=l.oldDraggableIndex,B=l.newDraggableIndex,P=l.originalEvent,O=l.putSortable,q=l.extraEventProperties;if(d=d||g&&g[Qn],!!d){var Q,se=d.options,ie="on"+p.charAt(0).toUpperCase()+p.substr(1);window.CustomEvent&&!po&&!Na?Q=new CustomEvent(p,{bubbles:!0,cancelable:!0}):(Q=document.createEvent("Event"),Q.initEvent(p,!0,!0)),Q.to=_||g,Q.from=y||g,Q.item=w||g,Q.clone=A,Q.oldIndex=k,Q.newIndex=T,Q.oldDraggableIndex=M,Q.newDraggableIndex=B,Q.originalEvent=P,Q.pullMode=O?O.lastPutMode:void 0;var K=Ki(Ki({},q),Pa.getEventProperties(p,d));for(var Ae in K)Q[Ae]=K[Ae];g&&g.dispatchEvent(Q),se[ie]&&se[ie].call(d,Q)}}var KT=["evt"],Bn=function(d,g){var p=arguments.length>2&&arguments[2]!==void 0?arguments[2]:{},w=p.evt,A=jT(p,KT);Pa.pluginEvent.bind(Re)(d,g,Ki({dragEl:pe,parentEl:Ot,ghostEl:Fe,rootEl:St,nextEl:br,lastDownEl:mc,cloneEl:Mt,cloneHidden:Oo,dragStarted:ua,putSortable:cn,activeSortable:Re.active,originalEvent:w,oldIndex:rs,oldDraggableIndex:ba,newIndex:Kn,newDraggableIndex:zo,hideGhostForTarget:x0,unhideGhostForTarget:D0,cloneNowHidden:function(){Oo=!0},cloneNowShown:function(){Oo=!1},dispatchSortableEvent:function(y){yn({sortable:g,name:y,originalEvent:w})}},A))};function yn(l){YT(Ki({putSortable:cn,cloneEl:Mt,targetEl:pe,rootEl:St,oldIndex:rs,oldDraggableIndex:ba,newIndex:Kn,newDraggableIndex:zo},l))}var pe,Ot,Fe,St,br,mc,Mt,Oo,rs,Kn,ba,zo,lc,cn,is=!1,Ec=!1,Tc=[],pr,yi,ch,dh,wv,vv,ua,ns,ka,wa=!1,cc=!1,bc,pn,uh=[],xh=!1,Sc=[],Hc=typeof document<"u",dc=g0,_v=Na||po?"cssFloat":"float",QT=Hc&&!p0&&!g0&&"draggable"in document.createElement("div"),C0=function(){if(Hc){if(po)return!1;var l=document.createElement("x");return l.style.cssText="pointer-events:auto",l.style.pointerEvents==="auto"}}(),A0=function(d,g){var p=Le(d),w=parseInt(p.width)-parseInt(p.paddingLeft)-parseInt(p.paddingRight)-parseInt(p.borderLeftWidth)-parseInt(p.borderRightWidth),A=ls(d,0,g),_=ls(d,1,g),y=A&&Le(A),k=_&&Le(_),T=y&&parseInt(y.marginLeft)+parseInt(y.marginRight)+Wt(A).width,M=k&&parseInt(k.marginLeft)+parseInt(k.marginRight)+Wt(_).width;if(p.display==="flex")return p.flexDirection==="column"||p.flexDirection==="column-reverse"?"vertical":"horizontal";if(p.display==="grid")return p.gridTemplateColumns.split(" ").length<=1?"vertical":"horizontal";if(A&&y.float&&y.float!=="none"){var B=y.float==="left"?"left":"right";return _&&(k.clear==="both"||k.clear===B)?"vertical":"horizontal"}return A&&(y.display==="block"||y.display==="flex"||y.display==="table"||y.display==="grid"||T>=w&&p[_v]==="none"||_&&p[_v]==="none"&&T+M>w)?"vertical":"horizontal"},ZT=function(d,g,p){var w=p?d.left:d.top,A=p?d.right:d.bottom,_=p?d.width:d.height,y=p?g.left:g.top,k=p?g.right:g.bottom,T=p?g.width:g.height;return w===y||A===k||w+_/2===y+T/2},JT=function(d,g){var p;return Tc.some(function(w){var A=w[Qn].options.emptyInsertThreshold;if(!(!A||$h(w))){var _=Wt(w),y=d>=_.left-A&&d<=_.right+A,k=g>=_.top-A&&g<=_.bottom+A;if(y&&k)return p=w}}),p},y0=function(d){function g(A,_){return function(y,k,T,M){var B=y.options.group.name&&k.options.group.name&&y.options.group.name===k.options.group.name;if(A==null&&(_||B))return!0;if(A==null||A===!1)return!1;if(_&&A==="clone")return A;if(typeof A=="function")return g(A(y,k,T,M),_)(y,k,T,M);var P=(_?y:k).options.group.name;return A===!0||typeof A=="string"&&A===P||A.join&&A.indexOf(P)>-1}}var p={},w=d.group;(!w||pc(w)!="object")&&(w={name:w}),p.name=w.name,p.checkPull=g(w.pull,!0),p.checkPut=g(w.put),p.revertClone=w.revertClone,d.group=p},x0=function(){!C0&&Fe&&Le(Fe,"display","none")},D0=function(){!C0&&Fe&&Le(Fe,"display","")};Hc&&!p0&&document.addEventListener("click",function(l){if(Ec)return l.preventDefault(),l.stopPropagation&&l.stopPropagation(),l.stopImmediatePropagation&&l.stopImmediatePropagation(),Ec=!1,!1},!0);var mr=function(d){if(pe){d=d.touches?d.touches[0]:d;var g=JT(d.clientX,d.clientY);if(g){var p={};for(var w in d)d.hasOwnProperty(w)&&(p[w]=d[w]);p.target=p.rootEl=g,p.preventDefault=void 0,p.stopPropagation=void 0,g[Qn]._onDragOver(p)}}},XT=function(d){pe&&pe.parentNode[Qn]._isOutsideThisEl(d.target)};function Re(l,d){if(!(l&&l.nodeType&&l.nodeType===1))throw"Sortable: `el` must be an HTMLElement, not ".concat({}.toString.call(l));this.el=l,this.options=d=go({},d),l[Qn]=this;var g={group:null,sort:!0,disabled:!1,store:null,handle:null,draggable:/^[uo]l$/i.test(l.nodeName)?">li":">*",swapThreshold:1,invertSwap:!1,invertedSwapThreshold:null,removeCloneOnHide:!0,direction:function(){return A0(l,this.options)},ghostClass:"sortable-ghost",chosenClass:"sortable-chosen",dragClass:"sortable-drag",ignore:"a, img",filter:null,preventOnFilter:!0,animation:0,easing:null,setData:function(_,y){_.setData("Text",y.textContent)},dropBubble:!1,dragoverBubble:!1,dataIdAttr:"data-id",delay:0,delayOnTouchOnly:!1,touchStartThreshold:(Number.parseInt?Number:window).parseInt(window.devicePixelRatio,10)||1,forceFallback:!1,fallbackClass:"sortable-fallback",fallbackOnBody:!1,fallbackTolerance:0,fallbackOffset:{x:0,y:0},supportPointer:Re.supportPointer!==!1&&"PointerEvent"in window&&!pa,emptyInsertThreshold:5};Pa.initializePlugins(this,l,g);for(var p in g)!(p in d)&&(d[p]=g[p]);y0(d);for(var w in this)w.charAt(0)==="_"&&typeof this[w]=="function"&&(this[w]=this[w].bind(this));this.nativeDraggable=d.forceFallback?!1:QT,this.nativeDraggable&&(this.options.touchStartThreshold=1),d.supportPointer?lt(l,"pointerdown",this._onTapStart):(lt(l,"mousedown",this._onTapStart),lt(l,"touchstart",this._onTapStart)),this.nativeDraggable&&(lt(l,"dragover",this),lt(l,"dragenter",this)),Tc.push(this.el),d.store&&d.store.get&&this.sort(d.store.get(this)||[]),go(this,qT())}Re.prototype={constructor:Re,_isOutsideThisEl:function(d){!this.el.contains(d)&&d!==this.el&&(ns=null)},_getDirection:function(d,g){return typeof this.options.direction=="function"?this.options.direction.call(this,d,g,pe):this.options.direction},_onTapStart:function(d){if(d.cancelable){var g=this,p=this.el,w=this.options,A=w.preventOnFilter,_=d.type,y=d.touches&&d.touches[0]||d.pointerType&&d.pointerType==="touch"&&d,k=(y||d).target,T=d.target.shadowRoot&&(d.path&&d.path[0]||d.composedPath&&d.composedPath()[0])||k,M=w.filter;if(aS(p),!pe&&!(/mousedown|pointerdown/.test(_)&&d.button!==0||w.disabled)&&!T.isContentEditable&&!(!this.nativeDraggable&&pa&&k&&k.tagName.toUpperCase()==="SELECT")&&(k=xi(k,w.draggable,p,!1),!(k&&k.animated)&&mc!==k)){if(rs=fi(k),ba=fi(k,w.draggable),typeof M=="function"){if(M.call(this,d,k,this)){yn({sortable:g,rootEl:T,name:"filter",targetEl:k,toEl:p,fromEl:p}),Bn("filter",g,{evt:d}),A&&d.cancelable&&d.preventDefault();return}}else if(M&&(M=M.split(",").some(function(B){if(B=xi(T,B.trim(),p,!1),B)return yn({sortable:g,rootEl:B,name:"filter",targetEl:k,fromEl:p,toEl:p}),Bn("filter",g,{evt:d}),!0}),M)){A&&d.cancelable&&d.preventDefault();return}w.handle&&!xi(T,w.handle,p,!1)||this._prepareDragStart(d,y,k)}}},_prepareDragStart:function(d,g,p){var w=this,A=w.el,_=w.options,y=A.ownerDocument,k;if(p&&!pe&&p.parentNode===A){var T=Wt(p);if(St=A,pe=p,Ot=pe.parentNode,br=pe.nextSibling,mc=p,lc=_.group,Re.dragged=pe,pr={target:pe,clientX:(g||d).clientX,clientY:(g||d).clientY},wv=pr.clientX-T.left,vv=pr.clientY-T.top,this._lastX=(g||d).clientX,this._lastY=(g||d).clientY,pe.style["will-change"]="all",k=function(){if(Bn("delayEnded",w,{evt:d}),Re.eventCanceled){w._onDrop();return}w._disableDelayedDragEvents(),!pv&&w.nativeDraggable&&(pe.draggable=!0),w._triggerDragStart(d,g),yn({sortable:w,name:"choose",originalEvent:d}),Yn(pe,_.chosenClass,!0)},_.ignore.split(",").forEach(function(M){b0(pe,M.trim(),hh)}),lt(y,"dragover",mr),lt(y,"mousemove",mr),lt(y,"touchmove",mr),lt(y,"mouseup",w._onDrop),lt(y,"touchend",w._onDrop),lt(y,"touchcancel",w._onDrop),pv&&this.nativeDraggable&&(this.options.touchStartThreshold=4,pe.draggable=!0),Bn("delayStart",this,{evt:d}),_.delay&&(!_.delayOnTouchOnly||g)&&(!this.nativeDraggable||!(Na||po))){if(Re.eventCanceled){this._onDrop();return}lt(y,"mouseup",w._disableDelayedDrag),lt(y,"touchend",w._disableDelayedDrag),lt(y,"touchcancel",w._disableDelayedDrag),lt(y,"mousemove",w._delayedDragTouchMoveHandler),lt(y,"touchmove",w._delayedDragTouchMoveHandler),_.supportPointer&&lt(y,"pointermove",w._delayedDragTouchMoveHandler),w._dragStartTimer=setTimeout(k,_.delay)}else k()}},_delayedDragTouchMoveHandler:function(d){var g=d.touches?d.touches[0]:d;Math.max(Math.abs(g.clientX-this._lastX),Math.abs(g.clientY-this._lastY))>=Math.floor(this.options.touchStartThreshold/(this.nativeDraggable&&window.devicePixelRatio||1))&&this._disableDelayedDrag()},_disableDelayedDrag:function(){pe&&hh(pe),clearTimeout(this._dragStartTimer),this._disableDelayedDragEvents()},_disableDelayedDragEvents:function(){var d=this.el.ownerDocument;st(d,"mouseup",this._disableDelayedDrag),st(d,"touchend",this._disableDelayedDrag),st(d,"touchcancel",this._disableDelayedDrag),st(d,"mousemove",this._delayedDragTouchMoveHandler),st(d,"touchmove",this._delayedDragTouchMoveHandler),st(d,"pointermove",this._delayedDragTouchMoveHandler)},_triggerDragStart:function(d,g){g=g||d.pointerType=="touch"&&d,!this.nativeDraggable||g?this.options.supportPointer?lt(document,"pointermove",this._onTouchMove):g?lt(document,"touchmove",this._onTouchMove):lt(document,"mousemove",this._onTouchMove):(lt(pe,"dragend",this),lt(St,"dragstart",this._onDragStart));try{document.selection?kc(function(){document.selection.empty()}):window.getSelection().removeAllRanges()}catch{}},_dragStarted:function(d,g){if(is=!1,St&&pe){Bn("dragStarted",this,{evt:g}),this.nativeDraggable&&lt(document,"dragover",XT);var p=this.options;!d&&Yn(pe,p.dragClass,!1),Yn(pe,p.ghostClass,!0),Re.active=this,d&&this._appendGhost(),yn({sortable:this,name:"start",originalEvent:g})}else this._nulling()},_emulateDragOver:function(){if(yi){this._lastX=yi.clientX,this._lastY=yi.clientY,x0();for(var d=document.elementFromPoint(yi.clientX,yi.clientY),g=d;d&&d.shadowRoot&&(d=d.shadowRoot.elementFromPoint(yi.clientX,yi.clientY),d!==g);)g=d;if(pe.parentNode[Qn]._isOutsideThisEl(d),g)do{if(g[Qn]){var p=void 0;if(p=g[Qn]._onDragOver({clientX:yi.clientX,clientY:yi.clientY,target:d,rootEl:g}),p&&!this.options.dragoverBubble)break}d=g}while(g=g.parentNode);D0()}},_onTouchMove:function(d){if(pr){var g=this.options,p=g.fallbackTolerance,w=g.fallbackOffset,A=d.touches?d.touches[0]:d,_=Fe&&ss(Fe,!0),y=Fe&&_&&_.a,k=Fe&&_&&_.d,T=dc&&pn&&kv(pn),M=(A.clientX-pr.clientX+w.x)/(y||1)+(T?T[0]-uh[0]:0)/(y||1),B=(A.clientY-pr.clientY+w.y)/(k||1)+(T?T[1]-uh[1]:0)/(k||1);if(!Re.active&&!is){if(p&&Math.max(Math.abs(A.clientX-this._lastX),Math.abs(A.clientY-this._lastY))<p)return;this._onDragStart(d,!0)}if(Fe){_?(_.e+=M-(ch||0),_.f+=B-(dh||0)):_={a:1,b:0,c:0,d:1,e:M,f:B};var P="matrix(".concat(_.a,",").concat(_.b,",").concat(_.c,",").concat(_.d,",").concat(_.e,",").concat(_.f,")");Le(Fe,"webkitTransform",P),Le(Fe,"mozTransform",P),Le(Fe,"msTransform",P),Le(Fe,"transform",P),ch=M,dh=B,yi=A}d.cancelable&&d.preventDefault()}},_appendGhost:function(){if(!Fe){var d=this.options.fallbackOnBody?document.body:St,g=Wt(pe,!0,dc,!0,d),p=this.options;if(dc){for(pn=d;Le(pn,"position")==="static"&&Le(pn,"transform")==="none"&&pn!==document;)pn=pn.parentNode;pn!==document.body&&pn!==document.documentElement?(pn===document&&(pn=$i()),g.top+=pn.scrollTop,g.left+=pn.scrollLeft):pn=$i(),uh=kv(pn)}Fe=pe.cloneNode(!0),Yn(Fe,p.ghostClass,!1),Yn(Fe,p.fallbackClass,!0),Yn(Fe,p.dragClass,!0),Le(Fe,"transition",""),Le(Fe,"transform",""),Le(Fe,"box-sizing","border-box"),Le(Fe,"margin",0),Le(Fe,"top",g.top),Le(Fe,"left",g.left),Le(Fe,"width",g.width),Le(Fe,"height",g.height),Le(Fe,"opacity","0.8"),Le(Fe,"position",dc?"absolute":"fixed"),Le(Fe,"zIndex","100000"),Le(Fe,"pointerEvents","none"),Re.ghost=Fe,d.appendChild(Fe),Le(Fe,"transform-origin",wv/parseInt(Fe.style.width)*100+"% "+vv/parseInt(Fe.style.height)*100+"%")}},_onDragStart:function(d,g){var p=this,w=d.dataTransfer,A=p.options;if(Bn("dragStart",this,{evt:d}),Re.eventCanceled){this._onDrop();return}Bn("setupClone",this),Re.eventCanceled||(Mt=v0(pe),Mt.removeAttribute("id"),Mt.draggable=!1,Mt.style["will-change"]="",this._hideClone(),Yn(Mt,this.options.chosenClass,!1),Re.clone=Mt),p.cloneId=kc(function(){Bn("clone",p),!Re.eventCanceled&&(p.options.removeCloneOnHide||St.insertBefore(Mt,pe),p._hideClone(),yn({sortable:p,name:"clone"}))}),!g&&Yn(pe,A.dragClass,!0),g?(Ec=!0,p._loopId=setInterval(p._emulateDragOver,50)):(st(document,"mouseup",p._onDrop),st(document,"touchend",p._onDrop),st(document,"touchcancel",p._onDrop),w&&(w.effectAllowed="move",A.setData&&A.setData.call(p,w,pe)),lt(document,"drop",p),Le(pe,"transform","translateZ(0)")),is=!0,p._dragStartId=kc(p._dragStarted.bind(p,g,d)),lt(document,"selectstart",p),ua=!0,pa&&Le(document.body,"user-select","none")},_onDragOver:function(d){var g=this.el,p=d.target,w,A,_,y=this.options,k=y.group,T=Re.active,M=lc===k,B=y.sort,P=cn||T,O,q=this,Q=!1;if(xh)return;function se(_t,Nt){Bn(_t,q,Ki({evt:d,isOwner:M,axis:O?"vertical":"horizontal",revert:_,dragRect:w,targetRect:A,canSort:B,fromSortable:P,target:p,completed:K,onMove:function(Rn,xn){return uc(St,g,pe,w,Rn,Wt(Rn),d,xn)},changed:Ae},Nt))}function ie(){se("dragOverAnimationCapture"),q.captureAnimationState(),q!==P&&P.captureAnimationState()}function K(_t){return se("dragOverCompleted",{insertion:_t}),_t&&(M?T._hideClone():T._showClone(q),q!==P&&(Yn(pe,cn?cn.options.ghostClass:T.options.ghostClass,!1),Yn(pe,y.ghostClass,!0)),cn!==q&&q!==Re.active?cn=q:q===Re.active&&cn&&(cn=null),P===q&&(q._ignoreWhileAnimating=p),q.animateAll(function(){se("dragOverAnimationComplete"),q._ignoreWhileAnimating=null}),q!==P&&(P.animateAll(),P._ignoreWhileAnimating=null)),(p===pe&&!pe.animated||p===g&&!p.animated)&&(ns=null),!y.dragoverBubble&&!d.rootEl&&p!==document&&(pe.parentNode[Qn]._isOutsideThisEl(d.target),!_t&&mr(d)),!y.dragoverBubble&&d.stopPropagation&&d.stopPropagation(),Q=!0}function Ae(){Kn=fi(pe),zo=fi(pe,y.draggable),yn({sortable:q,name:"change",toEl:g,newIndex:Kn,newDraggableIndex:zo,originalEvent:d})}if(d.preventDefault!==void 0&&d.cancelable&&d.preventDefault(),p=xi(p,y.draggable,g,!0),se("dragOver"),Re.eventCanceled)return Q;if(pe.contains(d.target)||p.animated&&p.animatingX&&p.animatingY||q._ignoreWhileAnimating===p)return K(!1);if(Ec=!1,T&&!y.disabled&&(M?B||(_=Ot!==St):cn===this||(this.lastPutMode=lc.checkPull(this,T,pe,d))&&k.checkPut(this,T,pe,d))){if(O=this._getDirection(d,p)==="vertical",w=Wt(pe),se("dragOverValid"),Re.eventCanceled)return Q;if(_)return Ot=St,ie(),this._hideClone(),se("revert"),Re.eventCanceled||(br?St.insertBefore(pe,br):St.appendChild(pe)),K(!0);var Ee=$h(g,y.draggable);if(!Ee||iS(d,O,this)&&!Ee.animated){if(Ee===pe)return K(!1);if(Ee&&g===d.target&&(p=Ee),p&&(A=Wt(p)),uc(St,g,pe,w,p,A,d,!!p)!==!1)return ie(),Ee&&Ee.nextSibling?g.insertBefore(pe,Ee.nextSibling):g.appendChild(pe),Ot=g,Ae(),K(!0)}else if(Ee&&nS(d,O,this)){var Se=ls(g,0,y,!0);if(Se===pe)return K(!1);if(p=Se,A=Wt(p),uc(St,g,pe,w,p,A,d,!1)!==!1)return ie(),g.insertBefore(pe,Se),Ot=g,Ae(),K(!0)}else if(p.parentNode===g){A=Wt(p);var V=0,x,we=pe.parentNode!==g,he=!ZT(pe.animated&&pe.toRect||w,p.animated&&p.toRect||A,O),ze=O?"top":"left",Pe=bv(p,"top","top")||bv(pe,"top","top"),Ve=Pe?Pe.scrollTop:void 0;ns!==p&&(x=A[ze],wa=!1,cc=!he&&y.invertSwap||we),V=oS(d,p,A,O,he?1:y.swapThreshold,y.invertedSwapThreshold==null?y.swapThreshold:y.invertedSwapThreshold,cc,ns===p);var me;if(V!==0){var Me=fi(pe);do Me-=V,me=Ot.children[Me];while(me&&(Le(me,"display")==="none"||me===Fe))}if(V===0||me===p)return K(!1);ns=p,ka=V;var He=p.nextElementSibling,dt=!1;dt=V===1;var Ce=uc(St,g,pe,w,p,A,d,dt);if(Ce!==!1)return(Ce===1||Ce===-1)&&(dt=Ce===1),xh=!0,setTimeout(tS,30),ie(),dt&&!He?g.appendChild(pe):p.parentNode.insertBefore(pe,dt?He:p),Pe&&w0(Pe,0,Ve-Pe.scrollTop),Ot=pe.parentNode,x!==void 0&&!cc&&(bc=Math.abs(x-Wt(p)[ze])),Ae(),K(!0)}if(g.contains(pe))return K(!1)}return!1},_ignoreWhileAnimating:null,_offMoveEvents:function(){st(document,"mousemove",this._onTouchMove),st(document,"touchmove",this._onTouchMove),st(document,"pointermove",this._onTouchMove),st(document,"dragover",mr),st(document,"mousemove",mr),st(document,"touchmove",mr)},_offUpEvents:function(){var d=this.el.ownerDocument;st(d,"mouseup",this._onDrop),st(d,"touchend",this._onDrop),st(d,"pointerup",this._onDrop),st(d,"touchcancel",this._onDrop),st(document,"selectstart",this)},_onDrop:function(d){var g=this.el,p=this.options;if(Kn=fi(pe),zo=fi(pe,p.draggable),Bn("drop",this,{evt:d}),Ot=pe&&pe.parentNode,Kn=fi(pe),zo=fi(pe,p.draggable),Re.eventCanceled){this._nulling();return}is=!1,cc=!1,wa=!1,clearInterval(this._loopId),clearTimeout(this._dragStartTimer),Dh(this.cloneId),Dh(this._dragStartId),this.nativeDraggable&&(st(document,"drop",this),st(g,"dragstart",this._onDragStart)),this._offMoveEvents(),this._offUpEvents(),pa&&Le(document.body,"user-select",""),Le(pe,"transform",""),d&&(ua&&(d.cancelable&&d.preventDefault(),!p.dropBubble&&d.stopPropagation()),Fe&&Fe.parentNode&&Fe.parentNode.removeChild(Fe),(St===Ot||cn&&cn.lastPutMode!=="clone")&&Mt&&Mt.parentNode&&Mt.parentNode.removeChild(Mt),pe&&(this.nativeDraggable&&st(pe,"dragend",this),hh(pe),pe.style["will-change"]="",ua&&!is&&Yn(pe,cn?cn.options.ghostClass:this.options.ghostClass,!1),Yn(pe,this.options.chosenClass,!1),yn({sortable:this,name:"unchoose",toEl:Ot,newIndex:null,newDraggableIndex:null,originalEvent:d}),St!==Ot?(Kn>=0&&(yn({rootEl:Ot,name:"add",toEl:Ot,fromEl:St,originalEvent:d}),yn({sortable:this,name:"remove",toEl:Ot,originalEvent:d}),yn({rootEl:Ot,name:"sort",toEl:Ot,fromEl:St,originalEvent:d}),yn({sortable:this,name:"sort",toEl:Ot,originalEvent:d})),cn&&cn.save()):Kn!==rs&&Kn>=0&&(yn({sortable:this,name:"update",toEl:Ot,originalEvent:d}),yn({sortable:this,name:"sort",toEl:Ot,originalEvent:d})),Re.active&&((Kn==null||Kn===-1)&&(Kn=rs,zo=ba),yn({sortable:this,name:"end",toEl:Ot,originalEvent:d}),this.save()))),this._nulling()},_nulling:function(){Bn("nulling",this),St=pe=Ot=Fe=br=Mt=mc=Oo=pr=yi=ua=Kn=zo=rs=ba=ns=ka=cn=lc=Re.dragged=Re.ghost=Re.clone=Re.active=null,Sc.forEach(function(d){d.checked=!0}),Sc.length=ch=dh=0},handleEvent:function(d){switch(d.type){case"drop":case"dragend":this._onDrop(d);break;case"dragenter":case"dragover":pe&&(this._onDragOver(d),eS(d));break;case"selectstart":d.preventDefault();break}},toArray:function(){for(var d=[],g,p=this.el.children,w=0,A=p.length,_=this.options;w<A;w++)g=p[w],xi(g,_.draggable,this.el,!1)&&d.push(g.getAttribute(_.dataIdAttr)||sS(g));return d},sort:function(d,g){var p={},w=this.el;this.toArray().forEach(function(A,_){var y=w.children[_];xi(y,this.options.draggable,w,!1)&&(p[A]=y)},this),g&&this.captureAnimationState(),d.forEach(function(A){p[A]&&(w.removeChild(p[A]),w.appendChild(p[A]))}),g&&this.animateAll()},save:function(){var d=this.options.store;d&&d.set&&d.set(this)},closest:function(d,g){return xi(d,g||this.options.draggable,this.el,!1)},option:function(d,g){var p=this.options;if(g===void 0)return p[d];var w=Pa.modifyOption(this,d,g);typeof w<"u"?p[d]=w:p[d]=g,d==="group"&&y0(p)},destroy:function(){Bn("destroy",this);var d=this.el;d[Qn]=null,st(d,"mousedown",this._onTapStart),st(d,"touchstart",this._onTapStart),st(d,"pointerdown",this._onTapStart),this.nativeDraggable&&(st(d,"dragover",this),st(d,"dragenter",this)),Array.prototype.forEach.call(d.querySelectorAll("[draggable]"),function(g){g.removeAttribute("draggable")}),this._onDrop(),this._disableDelayedDragEvents(),Tc.splice(Tc.indexOf(this.el),1),this.el=d=null},_hideClone:function(){if(!Oo){if(Bn("hideClone",this),Re.eventCanceled)return;Le(Mt,"display","none"),this.options.removeCloneOnHide&&Mt.parentNode&&Mt.parentNode.removeChild(Mt),Oo=!0}},_showClone:function(d){if(d.lastPutMode!=="clone"){this._hideClone();return}if(Oo){if(Bn("showClone",this),Re.eventCanceled)return;pe.parentNode==St&&!this.options.group.revertClone?St.insertBefore(Mt,pe):br?St.insertBefore(Mt,br):St.appendChild(Mt),this.options.group.revertClone&&this.animate(pe,Mt),Le(Mt,"display",""),Oo=!1}}};function eS(l){l.dataTransfer&&(l.dataTransfer.dropEffect="move"),l.cancelable&&l.preventDefault()}function uc(l,d,g,p,w,A,_,y){var k,T=l[Qn],M=T.options.onMove,B;return window.CustomEvent&&!po&&!Na?k=new CustomEvent("move",{bubbles:!0,cancelable:!0}):(k=document.createEvent("Event"),k.initEvent("move",!0,!0)),k.to=d,k.from=l,k.dragged=g,k.draggedRect=p,k.related=w||d,k.relatedRect=A||Wt(d),k.willInsertAfter=y,k.originalEvent=_,l.dispatchEvent(k),M&&(B=M.call(T,k,_)),B}function hh(l){l.draggable=!1}function tS(){xh=!1}function nS(l,d,g){var p=Wt(ls(g.el,0,g.options,!0)),w=_0(g.el,g.options,Fe),A=10;return d?l.clientX<w.left-A||l.clientY<p.top&&l.clientX<p.right:l.clientY<w.top-A||l.clientY<p.bottom&&l.clientX<p.left}function iS(l,d,g){var p=Wt($h(g.el,g.options.draggable)),w=_0(g.el,g.options,Fe),A=10;return d?l.clientX>w.right+A||l.clientY>p.bottom&&l.clientX>p.left:l.clientY>w.bottom+A||l.clientX>p.right&&l.clientY>p.top}function oS(l,d,g,p,w,A,_,y){var k=p?l.clientY:l.clientX,T=p?g.height:g.width,M=p?g.top:g.left,B=p?g.bottom:g.right,P=!1;if(!_){if(y&&bc<T*w){if(!wa&&(ka===1?k>M+T*A/2:k<B-T*A/2)&&(wa=!0),wa)P=!0;else if(ka===1?k<M+bc:k>B-bc)return-ka}else if(k>M+T*(1-w)/2&&k<B-T*(1-w)/2)return rS(d)}return P=P||_,P&&(k<M+T*A/2||k>B-T*A/2)?k>M+T/2?1:-1:0}function rS(l){return fi(pe)<fi(l)?1:-1}function sS(l){for(var d=l.tagName+l.className+l.src+l.href+l.textContent,g=d.length,p=0;g--;)p+=d.charCodeAt(g);return p.toString(36)}function aS(l){Sc.length=0;for(var d=l.getElementsByTagName("input"),g=d.length;g--;){var p=d[g];p.checked&&Sc.push(p)}}function kc(l){return setTimeout(l,0)}function Dh(l){return clearTimeout(l)}Hc&&lt(document,"touchmove",function(l){(Re.active||is)&&l.cancelable&&l.preventDefault()});Re.utils={on:lt,off:st,css:Le,find:b0,is:function(d,g){return!!xi(d,g,d,!1)},extend:UT,throttle:k0,closest:xi,toggleClass:Yn,clone:v0,index:fi,nextTick:kc,cancelNextTick:Dh,detectDirection:A0,getChild:ls};Re.get=function(l){return l[Qn]};Re.mount=function(){for(var l=arguments.length,d=new Array(l),g=0;g<l;g++)d[g]=arguments[g];d[0].constructor===Array&&(d=d[0]),d.forEach(function(p){if(!p.prototype||!p.prototype.constructor)throw"Sortable: Mounted plugin must be a constructor function, not ".concat({}.toString.call(p));p.utils&&(Re.utils=Ki(Ki({},Re.utils),p.utils)),Pa.mount(p)})};Re.create=function(l,d){return new Re(l,d)};Re.version=FT;var Ht=[],ha,Eh,Th=!1,fh,gh,Ic,fa;function lS(){function l(){this.defaults={scroll:!0,forceAutoScrollFallback:!1,scrollSensitivity:30,scrollSpeed:10,bubbleScroll:!0};for(var d in this)d.charAt(0)==="_"&&typeof this[d]=="function"&&(this[d]=this[d].bind(this))}return l.prototype={dragStarted:function(g){var p=g.originalEvent;this.sortable.nativeDraggable?lt(document,"dragover",this._handleAutoScroll):this.options.supportPointer?lt(document,"pointermove",this._handleFallbackAutoScroll):p.touches?lt(document,"touchmove",this._handleFallbackAutoScroll):lt(document,"mousemove",this._handleFallbackAutoScroll)},dragOverCompleted:function(g){var p=g.originalEvent;!this.options.dragOverBubble&&!p.rootEl&&this._handleAutoScroll(p)},drop:function(){this.sortable.nativeDraggable?st(document,"dragover",this._handleAutoScroll):(st(document,"pointermove",this._handleFallbackAutoScroll),st(document,"touchmove",this._handleFallbackAutoScroll),st(document,"mousemove",this._handleFallbackAutoScroll)),Cv(),wc(),WT()},nulling:function(){Ic=Eh=ha=Th=fa=fh=gh=null,Ht.length=0},_handleFallbackAutoScroll:function(g){this._handleAutoScroll(g,!0)},_handleAutoScroll:function(g,p){var w=this,A=(g.touches?g.touches[0]:g).clientX,_=(g.touches?g.touches[0]:g).clientY,y=document.elementFromPoint(A,_);if(Ic=g,p||this.options.forceAutoScrollFallback||Na||po||pa){ph(g,this.options,y,p);var k=jo(y,!0);Th&&(!fa||A!==fh||_!==gh)&&(fa&&Cv(),fa=setInterval(function(){var T=jo(document.elementFromPoint(A,_),!0);T!==k&&(k=T,wc()),ph(g,w.options,T,p)},10),fh=A,gh=_)}else{if(!this.options.bubbleScroll||jo(y,!0)===$i()){wc();return}ph(g,this.options,jo(y,!1),!1)}}},go(l,{pluginName:"scroll",initializeByDefault:!0})}function wc(){Ht.forEach(function(l){clearInterval(l.pid)}),Ht=[]}function Cv(){clearInterval(fa)}var ph=k0(function(l,d,g,p){if(d.scroll){var w=(l.touches?l.touches[0]:l).clientX,A=(l.touches?l.touches[0]:l).clientY,_=d.scrollSensitivity,y=d.scrollSpeed,k=$i(),T=!1,M;Eh!==g&&(Eh=g,wc(),ha=d.scroll,M=d.scrollFn,ha===!0&&(ha=jo(g,!0)));var B=0,P=ha;do{var O=P,q=Wt(O),Q=q.top,se=q.bottom,ie=q.left,K=q.right,Ae=q.width,Ee=q.height,Se=void 0,V=void 0,x=O.scrollWidth,we=O.scrollHeight,he=Le(O),ze=O.scrollLeft,Pe=O.scrollTop;O===k?(Se=Ae<x&&(he.overflowX==="auto"||he.overflowX==="scroll"||he.overflowX==="visible"),V=Ee<we&&(he.overflowY==="auto"||he.overflowY==="scroll"||he.overflowY==="visible")):(Se=Ae<x&&(he.overflowX==="auto"||he.overflowX==="scroll"),V=Ee<we&&(he.overflowY==="auto"||he.overflowY==="scroll"));var Ve=Se&&(Math.abs(K-w)<=_&&ze+Ae<x)-(Math.abs(ie-w)<=_&&!!ze),me=V&&(Math.abs(se-A)<=_&&Pe+Ee<we)-(Math.abs(Q-A)<=_&&!!Pe);if(!Ht[B])for(var Me=0;Me<=B;Me++)Ht[Me]||(Ht[Me]={});(Ht[B].vx!=Ve||Ht[B].vy!=me||Ht[B].el!==O)&&(Ht[B].el=O,Ht[B].vx=Ve,Ht[B].vy=me,clearInterval(Ht[B].pid),(Ve!=0||me!=0)&&(T=!0,Ht[B].pid=setInterval((function(){p&&this.layer===0&&Re.active._onTouchMove(Ic);var He=Ht[this.layer].vy?Ht[this.layer].vy*y:0,dt=Ht[this.layer].vx?Ht[this.layer].vx*y:0;typeof M=="function"&&M.call(Re.dragged.parentNode[Qn],dt,He,l,Ic,Ht[this.layer].el)!=="continue"||w0(Ht[this.layer].el,dt,He)}).bind({layer:B}),24))),B++}while(d.bubbleScroll&&P!==k&&(P=jo(P,!1)));Th=T}},30),E0=function(d){var g=d.originalEvent,p=d.putSortable,w=d.dragEl,A=d.activeSortable,_=d.dispatchSortableEvent,y=d.hideGhostForTarget,k=d.unhideGhostForTarget;if(g){var T=p||A;y();var M=g.changedTouches&&g.changedTouches.length?g.changedTouches[0]:g,B=document.elementFromPoint(M.clientX,M.clientY);k(),T&&!T.el.contains(B)&&(_("spill"),this.onSpill({dragEl:w,putSortable:p}))}};function Yh(){}Yh.prototype={startIndex:null,dragStart:function(d){var g=d.oldDraggableIndex;this.startIndex=g},onSpill:function(d){var g=d.dragEl,p=d.putSortable;this.sortable.captureAnimationState(),p&&p.captureAnimationState();var w=ls(this.sortable.el,this.startIndex,this.options);w?this.sortable.el.insertBefore(g,w):this.sortable.el.appendChild(g),this.sortable.animateAll(),p&&p.animateAll()},drop:E0};go(Yh,{pluginName:"revertOnSpill"});function Kh(){}Kh.prototype={onSpill:function(d){var g=d.dragEl,p=d.putSortable,w=p||this.sortable;w.captureAnimationState(),g.parentNode&&g.parentNode.removeChild(g),w.animateAll()},drop:E0};go(Kh,{pluginName:"removeOnSpill"});Re.mount(new lS);Re.mount(Kh,Yh);var Mc={exports:{}};Mc.exports;(function(l,d){(function(g){const p=g.en=g.en||{};p.dictionary=Object.assign(p.dictionary||{},{"%0 of %1":"%0 of %1","Align center":"Align center","Align left":"Align left","Align right":"Align right",Aquamarine:"Aquamarine",Big:"Big",Black:"Black","Block quote":"Block quote",Blue:"Blue",Bold:"Bold","Break text":"Break text","Bulleted List":"Bulleted List","Bulleted list styles toolbar":"Bulleted list styles toolbar",Cancel:"Cancel","Cannot determine a category for the uploaded file.":"Cannot determine a category for the uploaded file.","Cannot upload file:":"Cannot upload file:","Caption for image: %0":"Caption for image: %0","Caption for the image":"Caption for the image","Centered image":"Centered image","Change image text alternative":"Change image text alternative","Choose heading":"Choose heading",Circle:"Circle",Column:"Column","Could not insert image at the current position.":"Could not insert image at the current position.","Could not obtain resized image URL.":"Could not obtain resized image URL.",Decimal:"Decimal","Decimal with leading zero":"Decimal with leading zero","Decrease indent":"Decrease indent",Default:"Default","Delete column":"Delete column","Delete row":"Delete row","Dim grey":"Dim grey",Disc:"Disc","Document colors":"Document colors",Downloadable:"Downloadable","Dropdown toolbar":"Dropdown toolbar","Edit block":"Edit block","Edit link":"Edit link","Editor block content toolbar":"Editor block content toolbar","Editor contextual toolbar":"Editor contextual toolbar","Editor editing area: %0":"Editor editing area: %0","Editor toolbar":"Editor toolbar","Enter image caption":"Enter image caption","Font Background Color":"Font Background Color","Font Color":"Font Color","Font Family":"Font Family","Font Size":"Font Size","Full size image":"Full size image",Green:"Green",Grey:"Grey","Header column":"Header column","Header row":"Header row",Heading:"Heading","Heading 1":"Heading 1","Heading 2":"Heading 2","Heading 3":"Heading 3","Heading 4":"Heading 4","Heading 5":"Heading 5","Heading 6":"Heading 6",Huge:"Huge","Image resize list":"Image resize list","Image toolbar":"Image toolbar","image widget":"image widget","In line":"In line","Increase indent":"Increase indent","Insert column left":"Insert column left","Insert column right":"Insert column right","Insert image":"Insert image","Insert image or file":"Insert image or file","Insert media":"Insert media","Insert paragraph after block":"Insert paragraph after block","Insert paragraph before block":"Insert paragraph before block","Insert row above":"Insert row above","Insert row below":"Insert row below","Insert table":"Insert table","Inserting image failed":"Inserting image failed",Italic:"Italic",Justify:"Justify","Left aligned image":"Left aligned image","Light blue":"Light blue","Light green":"Light green","Light grey":"Light grey",Link:"Link","Link URL":"Link URL","List properties":"List properties","Lower-latin":"Lower-latin","Lower–roman":"Lower–roman","Media URL":"Media URL","media widget":"media widget","Merge cell down":"Merge cell down","Merge cell left":"Merge cell left","Merge cell right":"Merge cell right","Merge cell up":"Merge cell up","Merge cells":"Merge cells",Next:"Next","Numbered List":"Numbered List","Numbered list styles toolbar":"Numbered list styles toolbar","Open file manager":"Open file manager","Open in a new tab":"Open in a new tab","Open link in new tab":"Open link in new tab","Open media in new tab":"Open media in new tab",Orange:"Orange",Original:"Original",Paragraph:"Paragraph","Paste the media URL in the input.":"Paste the media URL in the input.","Press Enter to type after or press Shift + Enter to type before the widget":"Press Enter to type after or press Shift + Enter to type before the widget",Previous:"Previous",Purple:"Purple",Red:"Red",Redo:"Redo","Remove color":"Remove color","Resize image":"Resize image","Resize image to %0":"Resize image to %0","Resize image to the original size":"Resize image to the original size","Reversed order":"Reversed order","Rich Text Editor":"Rich Text Editor","Rich Text Editor. Editing area: %0":"Rich Text Editor. Editing area: %0","Right aligned image":"Right aligned image",Row:"Row",Save:"Save","Select all":"Select all","Select column":"Select column","Select row":"Select row","Selecting resized image failed":"Selecting resized image failed","Show more items":"Show more items","Side image":"Side image",Small:"Small","Split cell horizontally":"Split cell horizontally","Split cell vertically":"Split cell vertically",Square:"Square","Start at":"Start at","Start index must be greater than 0.":"Start index must be greater than 0.",Strikethrough:"Strikethrough","Table toolbar":"Table toolbar","Text alignment":"Text alignment","Text alignment toolbar":"Text alignment toolbar","Text alternative":"Text alternative","The URL must not be empty.":"The URL must not be empty.","This link has no URL":"This link has no URL","This media URL is not supported.":"This media URL is not supported.",Tiny:"Tiny","Tip: Paste the URL into the content to embed faster.":"Tip: Paste the URL into the content to embed faster.","Toggle caption off":"Toggle caption off","Toggle caption on":"Toggle caption on","Toggle the circle list style":"Toggle the circle list style","Toggle the decimal list style":"Toggle the decimal list style","Toggle the decimal with leading zero list style":"Toggle the decimal with leading zero list style","Toggle the disc list style":"Toggle the disc list style","Toggle the lower–latin list style":"Toggle the lower–latin list style","Toggle the lower–roman list style":"Toggle the lower–roman list style","Toggle the square list style":"Toggle the square list style","Toggle the upper–latin list style":"Toggle the upper–latin list style","Toggle the upper–roman list style":"Toggle the upper–roman list style",Turquoise:"Turquoise",Underline:"Underline",Undo:"Undo",Unlink:"Unlink","Upload failed":"Upload failed","Upload in progress":"Upload in progress","Upper-latin":"Upper-latin","Upper-roman":"Upper-roman",White:"White","Widget toolbar":"Widget toolbar","Wrap text":"Wrap text",Yellow:"Yellow"})})(window.CKEDITOR_TRANSLATIONS||(window.CKEDITOR_TRANSLATIONS={})),function(g,p){l.exports=p()}(self,()=>(()=>{var g={3062:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck-content blockquote{border-left:5px solid #ccc;font-style:italic;margin-left:0;margin-right:0;overflow:hidden;padding-left:1.5em;padding-right:1.5em}.ck-content[dir=rtl] blockquote{border-left:0;border-right:5px solid #ccc}","",{version:3,sources:["webpack://./../ckeditor5-block-quote/theme/blockquote.css"],names:[],mappings:"AAKA,uBAWC,0BAAsC,CADtC,iBAAkB,CAFlB,aAAc,CACd,cAAe,CAPf,eAAgB,CAIhB,kBAAmB,CADnB,mBAOD,CAEA,gCACC,aAAc,CACd,2BACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck-content blockquote {
	/* See #12 */
	overflow: hidden;

	/* https://github.com/ckeditor/ckeditor5-block-quote/issues/15 */
	padding-right: 1.5em;
	padding-left: 1.5em;

	margin-left: 0;
	margin-right: 0;
	font-style: italic;
	border-left: solid 5px hsl(0, 0%, 80%);
}

.ck-content[dir="rtl"] blockquote {
	border-left: 0;
	border-right: solid 5px hsl(0, 0%, 80%);
}
`],sourceRoot:""}]);const O=P},903:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,'.ck.ck-editor__editable .ck.ck-clipboard-drop-target-position{display:inline;pointer-events:none;position:relative}.ck.ck-editor__editable .ck.ck-clipboard-drop-target-position span{position:absolute;width:0}.ck.ck-editor__editable .ck-widget:-webkit-drag>.ck-widget__selection-handle,.ck.ck-editor__editable .ck-widget:-webkit-drag>.ck-widget__type-around{display:none}:root{--ck-clipboard-drop-target-dot-width:12px;--ck-clipboard-drop-target-dot-height:8px;--ck-clipboard-drop-target-color:var(--ck-color-focus-border)}.ck.ck-editor__editable .ck.ck-clipboard-drop-target-position span{background:var(--ck-clipboard-drop-target-color);border:1px solid var(--ck-clipboard-drop-target-color);bottom:calc(var(--ck-clipboard-drop-target-dot-height)*-.5);margin-left:-1px;top:calc(var(--ck-clipboard-drop-target-dot-height)*-.5)}.ck.ck-editor__editable .ck.ck-clipboard-drop-target-position span:after{border-color:var(--ck-clipboard-drop-target-color) transparent transparent transparent;border-style:solid;border-width:calc(var(--ck-clipboard-drop-target-dot-height)) calc(var(--ck-clipboard-drop-target-dot-width)*.5) 0 calc(var(--ck-clipboard-drop-target-dot-width)*.5);content:"";display:block;height:0;left:50%;position:absolute;top:calc(var(--ck-clipboard-drop-target-dot-height)*-.5);transform:translateX(-50%);width:0}.ck.ck-editor__editable .ck-widget.ck-clipboard-drop-target-range{outline:var(--ck-widget-outline-thickness) solid var(--ck-clipboard-drop-target-color)!important}.ck.ck-editor__editable .ck-widget:-webkit-drag{zoom:.6;outline:none!important}',"",{version:3,sources:["webpack://./../ckeditor5-clipboard/theme/clipboard.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-clipboard/clipboard.css"],names:[],mappings:"AASC,8DACC,cAAe,CAEf,mBAAoB,CADpB,iBAOD,CAJC,mEACC,iBAAkB,CAClB,OACD,CAWA,qJACC,YACD,CCzBF,MACC,yCAA0C,CAC1C,yCAA0C,CAC1C,6DACD,CAOE,mEAIC,gDAAiD,CADjD,sDAAuD,CAFvD,2DAA8D,CAI9D,gBAAiB,CAHjB,wDAqBD,CAfC,yEAWC,sFAAuF,CAEvF,kBAAmB,CADnB,qKAA0K,CAX1K,UAAW,CAIX,aAAc,CAFd,QAAS,CAIT,QAAS,CADT,iBAAkB,CAElB,wDAA2D,CAE3D,0BAA2B,CAR3B,OAYD,CA2DF,kEACC,gGACD,CAKA,gDACC,OAAS,CACT,sBACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-editor__editable {
	/*
	 * Vertical drop target (in text).
	 */
	& .ck.ck-clipboard-drop-target-position {
		display: inline;
		position: relative;
		pointer-events: none;

		& span {
			position: absolute;
			width: 0;
		}
	}

	/*
	 * Styles of the widget being dragged (its preview).
	 */
	& .ck-widget:-webkit-drag {
		& > .ck-widget__selection-handle {
			display: none;
		}

		& > .ck-widget__type-around {
			display: none;
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-clipboard-drop-target-dot-width: 12px;
	--ck-clipboard-drop-target-dot-height: 8px;
	--ck-clipboard-drop-target-color: var(--ck-color-focus-border)
}

.ck.ck-editor__editable {
	/*
	 * Vertical drop target (in text).
	 */
	& .ck.ck-clipboard-drop-target-position {
		& span {
			bottom: calc(-.5 * var(--ck-clipboard-drop-target-dot-height));
			top: calc(-.5 * var(--ck-clipboard-drop-target-dot-height));
			border: 1px solid var(--ck-clipboard-drop-target-color);
			background: var(--ck-clipboard-drop-target-color);
			margin-left: -1px;

			/* The triangle above the marker */
			&::after {
				content: "";
				width: 0;
				height: 0;

				display: block;
				position: absolute;
				left: 50%;
				top: calc(var(--ck-clipboard-drop-target-dot-height) * -.5);

				transform: translateX(-50%);
				border-color: var(--ck-clipboard-drop-target-color) transparent transparent transparent;
				border-width: calc(var(--ck-clipboard-drop-target-dot-height)) calc(.5 * var(--ck-clipboard-drop-target-dot-width)) 0 calc(.5 * var(--ck-clipboard-drop-target-dot-width));
				border-style: solid;
			}
		}
	}

	/*
	// Horizontal drop target (between blocks).
	& .ck.ck-clipboard-drop-target-position {
		display: block;
		position: relative;
		width: 100%;
		height: 0;
		margin: 0;
		text-align: initial;

		& .ck-clipboard-drop-target__line {
			position: absolute;
			width: 100%;
			height: 0;
			border: 1px solid var(--ck-clipboard-drop-target-color);
			margin-top: -1px;

			&::before {
				content: "";
				width: 0;
				height: 0;

				display: block;
				position: absolute;
				left: calc(-1 * var(--ck-clipboard-drop-target-dot-size));
				top: 0;

				transform: translateY(-50%);
				border-color: transparent transparent transparent var(--ck-clipboard-drop-target-color);
				border-width: var(--ck-clipboard-drop-target-dot-size) 0 var(--ck-clipboard-drop-target-dot-size) calc(2 * var(--ck-clipboard-drop-target-dot-size));
				border-style: solid;
			}

			&::after {
				content: "";
				width: 0;
				height: 0;

				display: block;
				position: absolute;
				right: calc(-1 * var(--ck-clipboard-drop-target-dot-size));
				top: 0;

				transform: translateY(-50%);
				border-color: transparent var(--ck-clipboard-drop-target-color) transparent transparent;
				border-width: var(--ck-clipboard-drop-target-dot-size) calc(2 * var(--ck-clipboard-drop-target-dot-size)) var(--ck-clipboard-drop-target-dot-size) 0;
				border-style: solid;
			}
		}
	}
	*/

	/*
	 * Styles of the widget that it a drop target.
	 */
	& .ck-widget.ck-clipboard-drop-target-range {
		outline: var(--ck-widget-outline-thickness) solid var(--ck-clipboard-drop-target-color) !important;
	}

	/*
	 * Styles of the widget being dragged (its preview).
	 */
	& .ck-widget:-webkit-drag {
		zoom: 0.6;
		outline: none !important;
	}
}
`],sourceRoot:""}]);const O=P},4717:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck .ck-placeholder,.ck.ck-placeholder{position:relative}.ck .ck-placeholder:before,.ck.ck-placeholder:before{content:attr(data-placeholder);left:0;pointer-events:none;position:absolute;right:0}.ck.ck-read-only .ck-placeholder:before{display:none}.ck.ck-reset_all .ck-placeholder{position:relative}.ck .ck-placeholder:before,.ck.ck-placeholder:before{color:var(--ck-color-engine-placeholder-text);cursor:text}","",{version:3,sources:["webpack://./../ckeditor5-engine/theme/placeholder.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-engine/placeholder.css"],names:[],mappings:"AAMA,uCAEC,iBAWD,CATC,qDAIC,8BAA+B,CAF/B,MAAO,CAKP,mBAAoB,CANpB,iBAAkB,CAElB,OAKD,CAKA,wCACC,YACD,CAQD,iCACC,iBACD,CC5BC,qDAEC,6CAA8C,CAD9C,WAED",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/* See ckeditor/ckeditor5#936. */
.ck.ck-placeholder,
.ck .ck-placeholder {
	position: relative;

	&::before {
		position: absolute;
		left: 0;
		right: 0;
		content: attr(data-placeholder);

		/* See ckeditor/ckeditor5#469. */
		pointer-events: none;
	}
}

/* See ckeditor/ckeditor5#1987. */
.ck.ck-read-only .ck-placeholder {
	&::before {
		display: none;
	}
}

/*
 * Rules for the \`ck-placeholder\` are loaded before the rules for \`ck-reset_all\` in the base CKEditor 5 DLL build.
 * This fix overwrites the incorrectly set \`position: static\` from \`ck-reset_all\`.
 * See https://github.com/ckeditor/ckeditor5/issues/11418.
 */
.ck.ck-reset_all .ck-placeholder {
	position: relative;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/* See ckeditor/ckeditor5#936. */
.ck.ck-placeholder, .ck .ck-placeholder {
	&::before {
		cursor: text;
		color: var(--ck-color-engine-placeholder-text);
	}
}
`],sourceRoot:""}]);const O=P},9315:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-editor__editable span[data-ck-unsafe-element]{display:none}","",{version:3,sources:["webpack://./../ckeditor5-engine/theme/renderer.css"],names:[],mappings:"AAMA,qDACC,YACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/* Elements marked by the Renderer as hidden should be invisible in the editor. */
.ck.ck-editor__editable span[data-ck-unsafe-element] {
	display: none;
}
`],sourceRoot:""}]);const O=P},1896:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck .ck-button.ck-color-table__remove-color{align-items:center;display:flex;width:100%}label.ck.ck-color-grid__label{font-weight:unset}.ck .ck-button.ck-color-table__remove-color{border-bottom-left-radius:0;border-bottom-right-radius:0;padding:calc(var(--ck-spacing-standard)/2) var(--ck-spacing-standard)}.ck .ck-button.ck-color-table__remove-color:not(:focus){border-bottom:1px solid var(--ck-color-base-border)}[dir=ltr] .ck .ck-button.ck-color-table__remove-color .ck.ck-icon{margin-right:var(--ck-spacing-standard)}[dir=rtl] .ck .ck-button.ck-color-table__remove-color .ck.ck-icon{margin-left:var(--ck-spacing-standard)}","",{version:3,sources:["webpack://./../ckeditor5-font/theme/fontcolor.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-font/fontcolor.css"],names:[],mappings:"AAKA,4CAEC,kBAAmB,CADnB,YAAa,CAEb,UACD,CAEA,8BACC,iBACD,CCNA,4CAEC,2BAA4B,CAC5B,4BAA6B,CAF7B,qEAiBD,CAbC,wDACC,mDACD,CAEA,kEAEE,uCAMF,CARA,kEAME,sCAEF",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck .ck-button.ck-color-table__remove-color {
	display: flex;
	align-items: center;
	width: 100%;
}

label.ck.ck-color-grid__label {
	font-weight: unset;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_dir.css";

.ck .ck-button.ck-color-table__remove-color {
	padding: calc(var(--ck-spacing-standard) / 2 ) var(--ck-spacing-standard);
	border-bottom-left-radius: 0;
	border-bottom-right-radius: 0;

	&:not(:focus) {
		border-bottom: 1px solid var(--ck-color-base-border);
	}

	& .ck.ck-icon {
		@mixin ck-dir ltr {
			margin-right: var(--ck-spacing-standard);
		}

		@mixin ck-dir rtl {
			margin-left: var(--ck-spacing-standard);
		}
	}
}

`],sourceRoot:""}]);const O=P},6007:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck-content .text-tiny{font-size:.7em}.ck-content .text-small{font-size:.85em}.ck-content .text-big{font-size:1.4em}.ck-content .text-huge{font-size:1.8em}","",{version:3,sources:["webpack://./../ckeditor5-font/theme/fontsize.css"],names:[],mappings:"AAUC,uBACC,cACD,CAEA,wBACC,eACD,CAEA,sBACC,eACD,CAEA,uBACC,eACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/* The values should be synchronized with the "FONT_SIZE_PRESET_UNITS" object in the "/src/fontsize/utils.js" file. */

/* Styles should be prefixed with the \`.ck-content\` class.
See https://github.com/ckeditor/ckeditor5/issues/6636 */
.ck-content {
	& .text-tiny {
		font-size: .7em;
	}

	& .text-small {
		font-size: .85em;
	}

	& .text-big {
		font-size: 1.4em;
	}

	& .text-huge {
		font-size: 1.8em;
	}
}
`],sourceRoot:""}]);const O=P},8733:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-heading_heading1{font-size:20px}.ck.ck-heading_heading2{font-size:17px}.ck.ck-heading_heading3{font-size:14px}.ck[class*=ck-heading_heading]{font-weight:700}.ck.ck-dropdown.ck-heading-dropdown .ck-dropdown__button .ck-button__label{width:8em}.ck.ck-dropdown.ck-heading-dropdown .ck-dropdown__panel .ck-list__item{min-width:18em}","",{version:3,sources:["webpack://./../ckeditor5-heading/theme/heading.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-heading/heading.css"],names:[],mappings:"AAKA,wBACC,cACD,CAEA,wBACC,cACD,CAEA,wBACC,cACD,CAEA,+BACC,eACD,CCZC,2EACC,SACD,CAEA,uEACC,cACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-heading_heading1 {
	font-size: 20px;
}

.ck.ck-heading_heading2 {
	font-size: 17px;
}

.ck.ck-heading_heading3 {
	font-size: 14px;
}

.ck[class*="ck-heading_heading"] {
	font-weight: bold;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/* Resize dropdown's button label. */
.ck.ck-dropdown.ck-heading-dropdown {
	& .ck-dropdown__button .ck-button__label {
		width: 8em;
	}

	& .ck-dropdown__panel .ck-list__item {
		min-width: 18em;
	}
}
`],sourceRoot:""}]);const O=P},3508:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck-content .image{clear:both;display:table;margin:.9em auto;min-width:50px;text-align:center}.ck-content .image img{display:block;margin:0 auto;max-width:100%;min-width:100%}.ck-content .image-inline{align-items:flex-start;display:inline-flex;max-width:100%}.ck-content .image-inline picture{display:flex}.ck-content .image-inline img,.ck-content .image-inline picture{flex-grow:1;flex-shrink:1;max-width:100%}.ck.ck-editor__editable .image>figcaption.ck-placeholder:before{overflow:hidden;padding-left:inherit;padding-right:inherit;text-overflow:ellipsis;white-space:nowrap}.ck.ck-editor__editable .image-inline.ck-widget_selected,.ck.ck-editor__editable .image.ck-widget_selected{z-index:1}.ck.ck-editor__editable .image-inline.ck-widget_selected ::selection{display:none}.ck.ck-editor__editable td .image-inline img,.ck.ck-editor__editable th .image-inline img{max-width:none}","",{version:3,sources:["webpack://./../ckeditor5-image/theme/image.css"],names:[],mappings:"AAMC,mBAEC,UAAW,CADX,aAAc,CAOd,gBAAkB,CAGlB,cAAe,CARf,iBAuBD,CAbC,uBAEC,aAAc,CAGd,aAAc,CAGd,cAAe,CAGf,cACD,CAGD,0BAYC,sBAAuB,CANvB,mBAAoB,CAGpB,cAoBD,CAdC,kCACC,YACD,CAGA,gEAGC,WAAY,CACZ,aAAc,CAGd,cACD,CAUD,gEASC,eAAgB,CARhB,oBAAqB,CACrB,qBAAsB,CAQtB,sBAAuB,CAFvB,kBAGD,CAWA,2GACC,SAUD,CAHC,qEACC,YACD,CAOA,0FACC,cACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck-content {
	& .image {
		display: table;
		clear: both;
		text-align: center;

		/* Make sure there is some space between the content and the image. Center image by default. */
		/* The first value should be equal to --ck-spacing-large variable if used in the editor context
	 	to avoid the content jumping (See https://github.com/ckeditor/ckeditor5/issues/9825). */
		margin: 0.9em auto;

		/* Make sure the caption will be displayed properly (See: https://github.com/ckeditor/ckeditor5/issues/1870). */
		min-width: 50px;

		& img {
			/* Prevent unnecessary margins caused by line-height (see #44). */
			display: block;

			/* Center the image if its width is smaller than the content's width. */
			margin: 0 auto;

			/* Make sure the image never exceeds the size of the parent container (ckeditor/ckeditor5-ui#67). */
			max-width: 100%;

			/* Make sure the image is never smaller than the parent container (See: https://github.com/ckeditor/ckeditor5/issues/9300). */
			min-width: 100%
		}
	}

	& .image-inline {
		/*
		 * Normally, the .image-inline would have "display: inline-block" and "img { width: 100% }" (to follow the wrapper while resizing).
		 * Unfortunately, together with "srcset", it gets automatically stretched up to the width of the editing root.
		 * This strange behavior does not happen with inline-flex.
		 */
		display: inline-flex;

		/* While being resized, don't allow the image to exceed the width of the editing root. */
		max-width: 100%;

		/* This is required by Safari to resize images in a sensible way. Without this, the browser breaks the ratio. */
		align-items: flex-start;

		/* When the picture is present it must act as a flex container to let the img resize properly */
		& picture {
			display: flex;
		}

		/* When the picture is present, it must act like a resizable img. */
		& picture,
		& img {
			/* This is necessary for the img to span the entire .image-inline wrapper and to resize properly. */
			flex-grow: 1;
			flex-shrink: 1;

			/* Prevents overflowing the editing root boundaries when an inline image is very wide. */
			max-width: 100%;
		}
	}
}

.ck.ck-editor__editable {
	/*
	 * Inhertit the content styles padding of the <figcaption> in case the integration overrides \`text-align: center\`
	 * of \`.image\` (e.g. to the left/right). This ensures the placeholder stays at the padding just like the native
	 * caret does, and not at the edge of <figcaption>.
	 */
	& .image > figcaption.ck-placeholder::before {
		padding-left: inherit;
		padding-right: inherit;

		/*
		 * Make sure the image caption placeholder doesn't overflow the placeholder area.
		 * See https://github.com/ckeditor/ckeditor5/issues/9162.
		 */
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}


	/*
	 * Make sure the selected inline image always stays on top of its siblings.
	 * See https://github.com/ckeditor/ckeditor5/issues/9108.
	 */
	& .image.ck-widget_selected {
		z-index: 1;
	}

	& .image-inline.ck-widget_selected {
		z-index: 1;

		/*
		 * Make sure the native browser selection style is not displayed.
		 * Inline image widgets have their own styles for the selected state and
		 * leaving this up to the browser is asking for a visual collision.
		 */
		& ::selection {
			display: none;
		}
	}

	/* The inline image nested in the table should have its original size if not resized.
	See https://github.com/ckeditor/ckeditor5/issues/9117. */
	& td,
	& th {
		& .image-inline img {
			max-width: none;
		}
	}
}
`],sourceRoot:""}]);const O=P},2640:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,":root{--ck-color-image-caption-background:#f7f7f7;--ck-color-image-caption-text:#333;--ck-color-image-caption-highligted-background:#fd0}.ck-content .image>figcaption{background-color:var(--ck-color-image-caption-background);caption-side:bottom;color:var(--ck-color-image-caption-text);display:table-caption;font-size:.75em;outline-offset:-1px;padding:.6em;word-break:break-word}.ck.ck-editor__editable .image>figcaption.image__caption_highlighted{animation:ck-image-caption-highlight .6s ease-out}@keyframes ck-image-caption-highlight{0%{background-color:var(--ck-color-image-caption-highligted-background)}to{background-color:var(--ck-color-image-caption-background)}}","",{version:3,sources:["webpack://./../ckeditor5-image/theme/imagecaption.css"],names:[],mappings:"AAKA,MACC,2CAAoD,CACpD,kCAA8C,CAC9C,mDACD,CAGA,8BAKC,yDAA0D,CAH1D,mBAAoB,CAEpB,wCAAyC,CAHzC,qBAAsB,CAMtB,eAAgB,CAChB,mBAAoB,CAFpB,YAAa,CAHb,qBAMD,CAGA,qEACC,iDACD,CAEA,sCACC,GACC,oEACD,CAEA,GACC,yDACD,CACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-color-image-caption-background: hsl(0, 0%, 97%);
	--ck-color-image-caption-text: hsl(0, 0%, 20%);
	--ck-color-image-caption-highligted-background: hsl(52deg 100% 50%);
}

/* Content styles */
.ck-content .image > figcaption {
	display: table-caption;
	caption-side: bottom;
	word-break: break-word;
	color: var(--ck-color-image-caption-text);
	background-color: var(--ck-color-image-caption-background);
	padding: .6em;
	font-size: .75em;
	outline-offset: -1px;
}

/* Editing styles */
.ck.ck-editor__editable .image > figcaption.image__caption_highlighted {
	animation: ck-image-caption-highlight .6s ease-out;
}

@keyframes ck-image-caption-highlight {
	0% {
		background-color: var(--ck-color-image-caption-highligted-background);
	}

	100% {
		background-color: var(--ck-color-image-caption-background);
	}
}
`],sourceRoot:""}]);const O=P},6270:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck-content .image.image_resized{box-sizing:border-box;display:block;max-width:100%}.ck-content .image.image_resized img{width:100%}.ck-content .image.image_resized>figcaption{display:block}.ck.ck-editor__editable td .image-inline.image_resized img,.ck.ck-editor__editable th .image-inline.image_resized img{max-width:100%}[dir=ltr] .ck.ck-button.ck-button_with-text.ck-resize-image-button .ck-button__icon{margin-right:var(--ck-spacing-standard)}[dir=rtl] .ck.ck-button.ck-button_with-text.ck-resize-image-button .ck-button__icon{margin-left:var(--ck-spacing-standard)}.ck.ck-dropdown .ck-button.ck-resize-image-button .ck-button__label{width:4em}","",{version:3,sources:["webpack://./../ckeditor5-image/theme/imageresize.css"],names:[],mappings:"AAKA,iCAQC,qBAAsB,CADtB,aAAc,CANd,cAkBD,CATC,qCAEC,UACD,CAEA,4CAEC,aACD,CAQC,sHACC,cACD,CAIF,oFACC,uCACD,CAEA,oFACC,sCACD,CAEA,oEACC,SACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck-content .image.image_resized {
	max-width: 100%;
	/*
	The \`<figure>\` element for resized images must not use \`display:table\` as browsers do not support \`max-width\` for it well.
	See https://stackoverflow.com/questions/4019604/chrome-safari-ignoring-max-width-in-table/14420691#14420691 for more.
	Fortunately, since we control the width, there is no risk that the image will look bad.
	*/
	display: block;
	box-sizing: border-box;

	& img {
		/* For resized images it is the \`<figure>\` element that determines the image width. */
		width: 100%;
	}

	& > figcaption {
		/* The \`<figure>\` element uses \`display:block\`, so \`<figcaption>\` also has to. */
		display: block;
	}
}

.ck.ck-editor__editable {
	/* The resized inline image nested in the table should respect its parent size.
	See https://github.com/ckeditor/ckeditor5/issues/9117. */
	& td,
	& th {
		& .image-inline.image_resized img {
			max-width: 100%;
		}
	}
}

[dir="ltr"] .ck.ck-button.ck-button_with-text.ck-resize-image-button .ck-button__icon {
	margin-right: var(--ck-spacing-standard);
}

[dir="rtl"] .ck.ck-button.ck-button_with-text.ck-resize-image-button .ck-button__icon {
	margin-left: var(--ck-spacing-standard);
}

.ck.ck-dropdown .ck-button.ck-resize-image-button .ck-button__label {
	width: 4em;
}
`],sourceRoot:""}]);const O=P},5083:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,":root{--ck-image-style-spacing:1.5em;--ck-inline-image-style-spacing:calc(var(--ck-image-style-spacing)/2)}.ck-content .image-style-block-align-left,.ck-content .image-style-block-align-right{max-width:calc(100% - var(--ck-image-style-spacing))}.ck-content .image-style-align-left,.ck-content .image-style-align-right{clear:none}.ck-content .image-style-side{float:right;margin-left:var(--ck-image-style-spacing);max-width:50%}.ck-content .image-style-align-left{float:left;margin-right:var(--ck-image-style-spacing)}.ck-content .image-style-align-center{margin-left:auto;margin-right:auto}.ck-content .image-style-align-right{float:right;margin-left:var(--ck-image-style-spacing)}.ck-content .image-style-block-align-right{margin-left:auto;margin-right:0}.ck-content .image-style-block-align-left{margin-left:0;margin-right:auto}.ck-content p+.image-style-align-left,.ck-content p+.image-style-align-right,.ck-content p+.image-style-side{margin-top:0}.ck-content .image-inline.image-style-align-left,.ck-content .image-inline.image-style-align-right{margin-bottom:var(--ck-inline-image-style-spacing);margin-top:var(--ck-inline-image-style-spacing)}.ck-content .image-inline.image-style-align-left{margin-right:var(--ck-inline-image-style-spacing)}.ck-content .image-inline.image-style-align-right{margin-left:var(--ck-inline-image-style-spacing)}.ck.ck-splitbutton.ck-splitbutton_flatten.ck-splitbutton_open>.ck-splitbutton__action:not(.ck-disabled),.ck.ck-splitbutton.ck-splitbutton_flatten.ck-splitbutton_open>.ck-splitbutton__arrow:not(.ck-disabled),.ck.ck-splitbutton.ck-splitbutton_flatten.ck-splitbutton_open>.ck-splitbutton__arrow:not(.ck-disabled):not(:hover),.ck.ck-splitbutton.ck-splitbutton_flatten:hover>.ck-splitbutton__action:not(.ck-disabled),.ck.ck-splitbutton.ck-splitbutton_flatten:hover>.ck-splitbutton__arrow:not(.ck-disabled),.ck.ck-splitbutton.ck-splitbutton_flatten:hover>.ck-splitbutton__arrow:not(.ck-disabled):not(:hover){background-color:var(--ck-color-button-on-background)}.ck.ck-splitbutton.ck-splitbutton_flatten.ck-splitbutton_open>.ck-splitbutton__action:not(.ck-disabled):after,.ck.ck-splitbutton.ck-splitbutton_flatten.ck-splitbutton_open>.ck-splitbutton__arrow:not(.ck-disabled):after,.ck.ck-splitbutton.ck-splitbutton_flatten.ck-splitbutton_open>.ck-splitbutton__arrow:not(.ck-disabled):not(:hover):after,.ck.ck-splitbutton.ck-splitbutton_flatten:hover>.ck-splitbutton__action:not(.ck-disabled):after,.ck.ck-splitbutton.ck-splitbutton_flatten:hover>.ck-splitbutton__arrow:not(.ck-disabled):after,.ck.ck-splitbutton.ck-splitbutton_flatten:hover>.ck-splitbutton__arrow:not(.ck-disabled):not(:hover):after{display:none}.ck.ck-splitbutton.ck-splitbutton_flatten.ck-splitbutton_open:hover>.ck-splitbutton__action:not(.ck-disabled),.ck.ck-splitbutton.ck-splitbutton_flatten.ck-splitbutton_open:hover>.ck-splitbutton__arrow:not(.ck-disabled),.ck.ck-splitbutton.ck-splitbutton_flatten.ck-splitbutton_open:hover>.ck-splitbutton__arrow:not(.ck-disabled):not(:hover){background-color:var(--ck-color-button-on-hover-background)}","",{version:3,sources:["webpack://./../ckeditor5-image/theme/imagestyle.css"],names:[],mappings:"AAKA,MACC,8BAA+B,CAC/B,qEACD,CAMC,qFAEC,oDACD,CAIA,yEAEC,UACD,CAEA,8BACC,WAAY,CACZ,yCAA0C,CAC1C,aACD,CAEA,oCACC,UAAW,CACX,0CACD,CAEA,sCACC,gBAAiB,CACjB,iBACD,CAEA,qCACC,WAAY,CACZ,yCACD,CAEA,2CAEC,gBAAiB,CADjB,cAED,CAEA,0CACC,aAAc,CACd,iBACD,CAGA,6GAGC,YACD,CAGC,mGAGC,kDAAmD,CADnD,+CAED,CAEA,iDACC,iDACD,CAEA,kDACC,gDACD,CAUC,0lBAGC,qDAKD,CAHC,8nBACC,YACD,CAKD,oVAGC,2DACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-image-style-spacing: 1.5em;
	--ck-inline-image-style-spacing: calc(var(--ck-image-style-spacing) / 2);
}

.ck-content {
	/* Provides a minimal side margin for the left and right aligned images, so that the user has a visual feedback
	confirming successful application of the style if image width exceeds the editor's size.
	See https://github.com/ckeditor/ckeditor5/issues/9342 */
	& .image-style-block-align-left,
	& .image-style-block-align-right {
		max-width: calc(100% - var(--ck-image-style-spacing));
	}

	/* Allows displaying multiple floating images in the same line.
	See https://github.com/ckeditor/ckeditor5/issues/9183#issuecomment-804988132 */
	& .image-style-align-left,
	& .image-style-align-right {
		clear: none;
	}

	& .image-style-side {
		float: right;
		margin-left: var(--ck-image-style-spacing);
		max-width: 50%;
	}

	& .image-style-align-left {
		float: left;
		margin-right: var(--ck-image-style-spacing);
	}

	& .image-style-align-center {
		margin-left: auto;
		margin-right: auto;
	}

	& .image-style-align-right {
		float: right;
		margin-left: var(--ck-image-style-spacing);
	}

	& .image-style-block-align-right {
		margin-right: 0;
		margin-left: auto;
	}

	& .image-style-block-align-left {
		margin-left: 0;
		margin-right: auto;
	}

	/* Simulates margin collapsing with the preceding paragraph, which does not work for the floating elements. */
	& p + .image-style-align-left,
	& p + .image-style-align-right,
	& p + .image-style-side {
		margin-top: 0;
	}

	& .image-inline {
		&.image-style-align-left,
		&.image-style-align-right {
			margin-top: var(--ck-inline-image-style-spacing);
			margin-bottom: var(--ck-inline-image-style-spacing);
		}

		&.image-style-align-left {
			margin-right: var(--ck-inline-image-style-spacing);
		}

		&.image-style-align-right {
			margin-left: var(--ck-inline-image-style-spacing);
		}
	}
}

.ck.ck-splitbutton {
	/* The button should display as a regular drop-down if the action button
	is forced to fire the same action as the arrow button. */
	&.ck-splitbutton_flatten {
		&:hover,
		&.ck-splitbutton_open {
			& > .ck-splitbutton__action:not(.ck-disabled),
			& > .ck-splitbutton__arrow:not(.ck-disabled),
			& > .ck-splitbutton__arrow:not(.ck-disabled):not(:hover) {
				background-color: var(--ck-color-button-on-background);

				&::after {
					display: none;
				}
			}
		}

		&.ck-splitbutton_open:hover {
			& > .ck-splitbutton__action:not(.ck-disabled),
			& > .ck-splitbutton__arrow:not(.ck-disabled),
			& > .ck-splitbutton__arrow:not(.ck-disabled):not(:hover) {
				background-color: var(--ck-color-button-on-hover-background);
			}
		}
	}
}
`],sourceRoot:""}]);const O=P},4036:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,'.ck-image-upload-complete-icon{border-radius:50%;display:block;position:absolute;right:min(var(--ck-spacing-medium),6%);top:min(var(--ck-spacing-medium),6%);z-index:1}.ck-image-upload-complete-icon:after{content:"";position:absolute}:root{--ck-color-image-upload-icon:#fff;--ck-color-image-upload-icon-background:#008a00;--ck-image-upload-icon-size:20;--ck-image-upload-icon-width:2px;--ck-image-upload-icon-is-visible:clamp(0px,100% - 50px,1px)}.ck-image-upload-complete-icon{animation-delay:0ms,3s;animation-duration:.5s,.5s;animation-fill-mode:forwards,forwards;animation-name:ck-upload-complete-icon-show,ck-upload-complete-icon-hide;background:var(--ck-color-image-upload-icon-background);font-size:calc(1px*var(--ck-image-upload-icon-size));height:calc(var(--ck-image-upload-icon-is-visible)*var(--ck-image-upload-icon-size));opacity:0;overflow:hidden;width:calc(var(--ck-image-upload-icon-is-visible)*var(--ck-image-upload-icon-size))}.ck-image-upload-complete-icon:after{animation-delay:.5s;animation-duration:.5s;animation-fill-mode:forwards;animation-name:ck-upload-complete-icon-check;border-right:var(--ck-image-upload-icon-width) solid var(--ck-color-image-upload-icon);border-top:var(--ck-image-upload-icon-width) solid var(--ck-color-image-upload-icon);box-sizing:border-box;height:0;left:25%;opacity:0;top:50%;transform:scaleX(-1) rotate(135deg);transform-origin:left top;width:0}@keyframes ck-upload-complete-icon-show{0%{opacity:0}to{opacity:1}}@keyframes ck-upload-complete-icon-hide{0%{opacity:1}to{opacity:0}}@keyframes ck-upload-complete-icon-check{0%{height:0;opacity:1;width:0}33%{height:0;width:.3em}to{height:.45em;opacity:1;width:.3em}}',"",{version:3,sources:["webpack://./../ckeditor5-image/theme/imageuploadicon.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-image/imageuploadicon.css"],names:[],mappings:"AAKA,+BAUC,iBAAkB,CATlB,aAAc,CACd,iBAAkB,CAOlB,sCAAwC,CADxC,oCAAsC,CAGtC,SAMD,CAJC,qCACC,UAAW,CACX,iBACD,CChBD,MACC,iCAA8C,CAC9C,+CAA4D,CAG5D,8BAA+B,CAC/B,gCAAiC,CACjC,4DACD,CAEA,+BAWC,sBAA4B,CAN5B,0BAAgC,CADhC,qCAAuC,CADvC,wEAA0E,CAD1E,uDAAwD,CAMxD,oDAAuD,CAWvD,oFAAuF,CAlBvF,SAAU,CAgBV,eAAgB,CAChB,mFA0BD,CAtBC,qCAgBC,mBAAsB,CADtB,sBAAyB,CAEzB,4BAA6B,CAH7B,4CAA6C,CAF7C,sFAAuF,CADvF,oFAAqF,CASrF,qBAAsB,CAdtB,QAAS,CAJT,QAAS,CAGT,SAAU,CADV,OAAQ,CAKR,mCAAoC,CACpC,yBAA0B,CAH1B,OAcD,CAGD,wCACC,GACC,SACD,CAEA,GACC,SACD,CACD,CAEA,wCACC,GACC,SACD,CAEA,GACC,SACD,CACD,CAEA,yCACC,GAGC,QAAS,CAFT,SAAU,CACV,OAED,CACA,IAEC,QAAS,CADT,UAED,CACA,GAGC,YAAc,CAFd,SAAU,CACV,UAED,CACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck-image-upload-complete-icon {
	display: block;
	position: absolute;

	/*
	 * Smaller images should have the icon closer to the border.
	 * Match the icon position with the linked image indicator brought by the link image feature.
	 */
	top: min(var(--ck-spacing-medium), 6%);
	right: min(var(--ck-spacing-medium), 6%);
	border-radius: 50%;
	z-index: 1;

	&::after {
		content: "";
		position: absolute;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-color-image-upload-icon: hsl(0, 0%, 100%);
	--ck-color-image-upload-icon-background: hsl(120, 100%, 27%);

	/* Match the icon size with the linked image indicator brought by the link image feature. */
	--ck-image-upload-icon-size: 20;
	--ck-image-upload-icon-width: 2px;
	--ck-image-upload-icon-is-visible: clamp(0px, 100% - 50px, 1px);
}

.ck-image-upload-complete-icon {
	opacity: 0;
	background: var(--ck-color-image-upload-icon-background);
	animation-name: ck-upload-complete-icon-show, ck-upload-complete-icon-hide;
	animation-fill-mode: forwards, forwards;
	animation-duration: 500ms, 500ms;

	/* To make animation scalable. */
	font-size: calc(1px * var(--ck-image-upload-icon-size));

	/* Hide completed upload icon after 3 seconds. */
	animation-delay: 0ms, 3000ms;

	/*
	 * Use CSS math to simulate container queries.
	 * https://css-tricks.com/the-raven-technique-one-step-closer-to-container-queries/#what-about-showing-and-hiding-things
	 */
	overflow: hidden;
	width: calc(var(--ck-image-upload-icon-is-visible) * var(--ck-image-upload-icon-size));
	height: calc(var(--ck-image-upload-icon-is-visible) * var(--ck-image-upload-icon-size));

	/* This is check icon element made from border-width mixed with animations. */
	&::after {
		/* Because of border transformation we need to "hard code" left position. */
		left: 25%;

		top: 50%;
		opacity: 0;
		height: 0;
		width: 0;

		transform: scaleX(-1) rotate(135deg);
		transform-origin: left top;
		border-top: var(--ck-image-upload-icon-width) solid var(--ck-color-image-upload-icon);
		border-right: var(--ck-image-upload-icon-width) solid var(--ck-color-image-upload-icon);

		animation-name: ck-upload-complete-icon-check;
		animation-duration: 500ms;
		animation-delay: 500ms;
		animation-fill-mode: forwards;

		/* #1095. While reset is not providing proper box-sizing for pseudoelements, we need to handle it. */
		box-sizing: border-box;
	}
}

@keyframes ck-upload-complete-icon-show {
	from {
		opacity: 0;
	}

	to {
		opacity: 1;
	}
}

@keyframes ck-upload-complete-icon-hide {
	from {
		opacity: 1;
	}

	to {
		opacity: 0;
	}
}

@keyframes ck-upload-complete-icon-check {
	0% {
		opacity: 1;
		width: 0;
		height: 0;
	}
	33% {
		width: 0.3em;
		height: 0;
	}
	100% {
		opacity: 1;
		width: 0.3em;
		height: 0.45em;
	}
}
`],sourceRoot:""}]);const O=P},3773:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,'.ck .ck-upload-placeholder-loader{align-items:center;display:flex;justify-content:center;left:0;position:absolute;top:0}.ck .ck-upload-placeholder-loader:before{content:"";position:relative}:root{--ck-color-upload-placeholder-loader:#b3b3b3;--ck-upload-placeholder-loader-size:32px;--ck-upload-placeholder-image-aspect-ratio:2.8}.ck .ck-image-upload-placeholder{margin:0;width:100%}.ck .ck-image-upload-placeholder.image-inline{width:calc(var(--ck-upload-placeholder-loader-size)*2*var(--ck-upload-placeholder-image-aspect-ratio))}.ck .ck-image-upload-placeholder img{aspect-ratio:var(--ck-upload-placeholder-image-aspect-ratio)}.ck .ck-upload-placeholder-loader{height:100%;width:100%}.ck .ck-upload-placeholder-loader:before{animation:ck-upload-placeholder-loader 1s linear infinite;border-radius:50%;border-right:2px solid transparent;border-top:3px solid var(--ck-color-upload-placeholder-loader);height:var(--ck-upload-placeholder-loader-size);width:var(--ck-upload-placeholder-loader-size)}@keyframes ck-upload-placeholder-loader{to{transform:rotate(1turn)}}',"",{version:3,sources:["webpack://./../ckeditor5-image/theme/imageuploadloader.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-image/imageuploadloader.css"],names:[],mappings:"AAKA,kCAGC,kBAAmB,CADnB,YAAa,CAEb,sBAAuB,CAEvB,MAAO,CALP,iBAAkB,CAIlB,KAOD,CAJC,yCACC,UAAW,CACX,iBACD,CCXD,MACC,4CAAqD,CACrD,wCAAyC,CACzC,8CACD,CAEA,iCAGC,QAAS,CADT,UAgBD,CAbC,8CACC,sGACD,CAEA,qCAOC,4DACD,CAGD,kCAEC,WAAY,CADZ,UAWD,CARC,yCAMC,yDAA0D,CAH1D,iBAAkB,CAElB,kCAAmC,CADnC,8DAA+D,CAF/D,+CAAgD,CADhD,8CAMD,CAGD,wCACC,GACC,uBACD,CACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck .ck-upload-placeholder-loader {
	position: absolute;
	display: flex;
	align-items: center;
	justify-content: center;
	top: 0;
	left: 0;

	&::before {
		content: '';
		position: relative;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-color-upload-placeholder-loader: hsl(0, 0%, 70%);
	--ck-upload-placeholder-loader-size: 32px;
	--ck-upload-placeholder-image-aspect-ratio: 2.8;
}

.ck .ck-image-upload-placeholder {
	/* We need to control the full width of the SVG gray background. */
	width: 100%;
	margin: 0;

	&.image-inline {
		width: calc( 2 * var(--ck-upload-placeholder-loader-size) * var(--ck-upload-placeholder-image-aspect-ratio) );
	}

	& img {
		/*
		 * This is an arbitrary aspect for a 1x1 px GIF to display to the user. Not too tall, not too short.
		 * There's nothing special about this number except that it should make the image placeholder look like
		 * a real image during this short period after the upload started and before the image was read from the
		 * file system (and a rich preview was loaded).
		 */
		aspect-ratio: var(--ck-upload-placeholder-image-aspect-ratio);
	}
}

.ck .ck-upload-placeholder-loader {
	width: 100%;
	height: 100%;

	&::before {
		width: var(--ck-upload-placeholder-loader-size);
		height: var(--ck-upload-placeholder-loader-size);
		border-radius: 50%;
		border-top: 3px solid var(--ck-color-upload-placeholder-loader);
		border-right: 2px solid transparent;
		animation: ck-upload-placeholder-loader 1s linear infinite;
	}
}

@keyframes ck-upload-placeholder-loader {
	to {
		transform: rotate( 360deg );
	}
}
`],sourceRoot:""}]);const O=P},3689:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-editor__editable .image,.ck.ck-editor__editable .image-inline{position:relative}.ck.ck-editor__editable .image .ck-progress-bar,.ck.ck-editor__editable .image-inline .ck-progress-bar{left:0;position:absolute;top:0}.ck.ck-editor__editable .image-inline.ck-appear,.ck.ck-editor__editable .image.ck-appear{animation:fadeIn .7s}.ck.ck-editor__editable .image .ck-progress-bar,.ck.ck-editor__editable .image-inline .ck-progress-bar{background:var(--ck-color-upload-bar-background);height:2px;transition:width .1s;width:0}@keyframes fadeIn{0%{opacity:0}to{opacity:1}}","",{version:3,sources:["webpack://./../ckeditor5-image/theme/imageuploadprogress.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-image/imageuploadprogress.css"],names:[],mappings:"AAMC,qEAEC,iBACD,CAGA,uGAIC,MAAO,CAFP,iBAAkB,CAClB,KAED,CCRC,yFACC,oBACD,CAID,uGAIC,gDAAiD,CAFjD,UAAW,CAGX,oBAAuB,CAFvB,OAGD,CAGD,kBACC,GAAO,SAAY,CACnB,GAAO,SAAY,CACpB",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-editor__editable {
	& .image,
	& .image-inline {
		position: relative;
	}

	/* Upload progress bar. */
	& .image .ck-progress-bar,
	& .image-inline .ck-progress-bar {
		position: absolute;
		top: 0;
		left: 0;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-editor__editable {
	& .image,
	& .image-inline {
		/* Showing animation. */
		&.ck-appear {
			animation: fadeIn 700ms;
		}
	}

	/* Upload progress bar. */
	& .image .ck-progress-bar,
	& .image-inline .ck-progress-bar {
		height: 2px;
		width: 0;
		background: var(--ck-color-upload-bar-background);
		transition: width 100ms;
	}
}

@keyframes fadeIn {
	from { opacity: 0; }
	to   { opacity: 1; }
}
`],sourceRoot:""}]);const O=P},1905:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-text-alternative-form{display:flex;flex-direction:row;flex-wrap:nowrap}.ck.ck-text-alternative-form .ck-labeled-field-view{display:inline-block}.ck.ck-text-alternative-form .ck-label{display:none}@media screen and (max-width:600px){.ck.ck-text-alternative-form{flex-wrap:wrap}.ck.ck-text-alternative-form .ck-labeled-field-view{flex-basis:100%}.ck.ck-text-alternative-form .ck-button{flex-basis:50%}}","",{version:3,sources:["webpack://./../ckeditor5-image/theme/textalternativeform.css","webpack://./../ckeditor5-ui/theme/mixins/_rwd.css"],names:[],mappings:"AAOA,6BACC,YAAa,CACb,kBAAmB,CACnB,gBAqBD,CAnBC,oDACC,oBACD,CAEA,uCACC,YACD,CCZA,oCDCD,6BAcE,cAUF,CARE,oDACC,eACD,CAEA,wCACC,cACD,CCrBD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_rwd.css";

.ck.ck-text-alternative-form {
	display: flex;
	flex-direction: row;
	flex-wrap: nowrap;

	& .ck-labeled-field-view {
		display: inline-block;
	}

	& .ck-label {
		display: none;
	}

	@mixin ck-media-phone {
		flex-wrap: wrap;

		& .ck-labeled-field-view {
			flex-basis: 100%;
		}

		& .ck-button {
			flex-basis: 50%;
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@define-mixin ck-media-phone {
	@media screen and (max-width: 600px) {
		@mixin-content;
	}
}
`],sourceRoot:""}]);const O=P},9773:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck .ck-link_selected{background:var(--ck-color-link-selected-background)}.ck .ck-link_selected span.image-inline{outline:var(--ck-widget-outline-thickness) solid var(--ck-color-link-selected-background)}.ck .ck-fake-link-selection{background:var(--ck-color-link-fake-selection)}.ck .ck-fake-link-selection_collapsed{border-right:1px solid var(--ck-color-base-text);height:100%;margin-right:-1px;outline:1px solid hsla(0,0%,100%,.5)}","",{version:3,sources:["webpack://./../ckeditor5-theme-lark/theme/ckeditor5-link/link.css"],names:[],mappings:"AAMA,sBACC,mDAMD,CAHC,wCACC,yFACD,CAOD,4BACC,8CACD,CAGA,sCAEC,gDAAiD,CADjD,WAAY,CAEZ,iBAAkB,CAClB,oCACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/* Class added to span element surrounding currently selected link. */
.ck .ck-link_selected {
	background: var(--ck-color-link-selected-background);

	/* Give linked inline images some outline to let the user know they are also part of the link. */
	& span.image-inline {
		outline: var(--ck-widget-outline-thickness) solid var(--ck-color-link-selected-background);
	}
}

/*
 * Classes used by the "fake visual selection" displayed in the content when an input
 * in the link UI has focus (the browser does not render the native selection in this state).
 */
.ck .ck-fake-link-selection {
	background: var(--ck-color-link-fake-selection);
}

/* A collapsed fake visual selection. */
.ck .ck-fake-link-selection_collapsed {
	height: 100%;
	border-right: 1px solid var(--ck-color-base-text);
	margin-right: -1px;
	outline: solid 1px hsla(0, 0%, 100%, .5);
}
`],sourceRoot:""}]);const O=P},2347:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-link-actions{display:flex;flex-direction:row;flex-wrap:nowrap}.ck.ck-link-actions .ck-link-actions__preview{display:inline-block}.ck.ck-link-actions .ck-link-actions__preview .ck-button__label{overflow:hidden}@media screen and (max-width:600px){.ck.ck-link-actions{flex-wrap:wrap}.ck.ck-link-actions .ck-link-actions__preview{flex-basis:100%}.ck.ck-link-actions .ck-button:not(.ck-link-actions__preview){flex-basis:50%}}.ck.ck-link-actions .ck-button.ck-link-actions__preview{padding-left:0;padding-right:0}.ck.ck-link-actions .ck-button.ck-link-actions__preview .ck-button__label{color:var(--ck-color-link-default);cursor:pointer;max-width:var(--ck-input-width);min-width:3em;padding:0 var(--ck-spacing-medium);text-align:center;text-overflow:ellipsis}.ck.ck-link-actions .ck-button.ck-link-actions__preview .ck-button__label:hover{text-decoration:underline}.ck.ck-link-actions .ck-button.ck-link-actions__preview,.ck.ck-link-actions .ck-button.ck-link-actions__preview:active,.ck.ck-link-actions .ck-button.ck-link-actions__preview:focus,.ck.ck-link-actions .ck-button.ck-link-actions__preview:hover{background:none}.ck.ck-link-actions .ck-button.ck-link-actions__preview:active{box-shadow:none}.ck.ck-link-actions .ck-button.ck-link-actions__preview:focus .ck-button__label{text-decoration:underline}[dir=ltr] .ck.ck-link-actions .ck-button:not(:first-child),[dir=rtl] .ck.ck-link-actions .ck-button:not(:last-child){margin-left:var(--ck-spacing-standard)}@media screen and (max-width:600px){.ck.ck-link-actions .ck-button.ck-link-actions__preview{margin:var(--ck-spacing-standard) var(--ck-spacing-standard) 0}.ck.ck-link-actions .ck-button.ck-link-actions__preview .ck-button__label{max-width:100%;min-width:0}[dir=ltr] .ck.ck-link-actions .ck-button:not(.ck-link-actions__preview),[dir=rtl] .ck.ck-link-actions .ck-button:not(.ck-link-actions__preview){margin-left:0}}","",{version:3,sources:["webpack://./../ckeditor5-link/theme/linkactions.css","webpack://./../ckeditor5-ui/theme/mixins/_rwd.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-link/linkactions.css"],names:[],mappings:"AAOA,oBACC,YAAa,CACb,kBAAmB,CACnB,gBAqBD,CAnBC,8CACC,oBAKD,CAHC,gEACC,eACD,CCXD,oCDCD,oBAcE,cAUF,CARE,8CACC,eACD,CAEA,8DACC,cACD,CCrBD,CCIA,wDACC,cAAe,CACf,eAmCD,CAjCC,0EAEC,kCAAmC,CAEnC,cAAe,CAIf,+BAAgC,CAChC,aAAc,CARd,kCAAmC,CASnC,iBAAkB,CAPlB,sBAYD,CAHC,gFACC,yBACD,CAGD,mPAIC,eACD,CAEA,+DACC,eACD,CAGC,gFACC,yBACD,CAWD,qHACC,sCACD,CDtDD,oCC0DC,wDACC,8DAMD,CAJC,0EAEC,cAAe,CADf,WAED,CAGD,gJAME,aAEF,CDzED",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_rwd.css";

.ck.ck-link-actions {
	display: flex;
	flex-direction: row;
	flex-wrap: nowrap;

	& .ck-link-actions__preview {
		display: inline-block;

		& .ck-button__label {
			overflow: hidden;
		}
	}

	@mixin ck-media-phone {
		flex-wrap: wrap;

		& .ck-link-actions__preview {
			flex-basis: 100%;
		}

		& .ck-button:not(.ck-link-actions__preview) {
			flex-basis: 50%;
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@define-mixin ck-media-phone {
	@media screen and (max-width: 600px) {
		@mixin-content;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_unselectable.css";
@import "@ckeditor/ckeditor5-ui/theme/mixins/_dir.css";
@import "../mixins/_focus.css";
@import "../mixins/_shadow.css";
@import "@ckeditor/ckeditor5-ui/theme/mixins/_rwd.css";

.ck.ck-link-actions {
	& .ck-button.ck-link-actions__preview {
		padding-left: 0;
		padding-right: 0;

		& .ck-button__label {
			padding: 0 var(--ck-spacing-medium);
			color: var(--ck-color-link-default);
			text-overflow: ellipsis;
			cursor: pointer;

			/* Match the box model of the link editor form's input so the balloon
			does not change width when moving between actions and the form. */
			max-width: var(--ck-input-width);
			min-width: 3em;
			text-align: center;

			&:hover {
				text-decoration: underline;
			}
		}

		&,
		&:hover,
		&:focus,
		&:active {
			background: none;
		}

		&:active {
			box-shadow: none;
		}

		&:focus {
			& .ck-button__label {
				text-decoration: underline;
			}
		}
	}

	@mixin ck-dir ltr {
		& .ck-button:not(:first-child) {
			margin-left: var(--ck-spacing-standard);
		}
	}

	@mixin ck-dir rtl {
		& .ck-button:not(:last-child) {
			margin-left: var(--ck-spacing-standard);
		}
	}

	@mixin ck-media-phone {
		& .ck-button.ck-link-actions__preview {
			margin: var(--ck-spacing-standard) var(--ck-spacing-standard) 0;

			& .ck-button__label {
				min-width: 0;
				max-width: 100%;
			}
		}

		& .ck-button:not(.ck-link-actions__preview) {
			@mixin ck-dir ltr {
				margin-left: 0;
			}

			@mixin ck-dir rtl {
				margin-left: 0;
			}
		}
	}
}
`],sourceRoot:""}]);const O=P},7754:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-link-form{display:flex}.ck.ck-link-form .ck-label{display:none}@media screen and (max-width:600px){.ck.ck-link-form{flex-wrap:wrap}.ck.ck-link-form .ck-labeled-field-view{flex-basis:100%}.ck.ck-link-form .ck-button{flex-basis:50%}}.ck.ck-link-form_layout-vertical{display:block}.ck.ck-link-form_layout-vertical .ck-button.ck-button-cancel,.ck.ck-link-form_layout-vertical .ck-button.ck-button-save{margin-top:var(--ck-spacing-medium)}.ck.ck-link-form_layout-vertical{min-width:var(--ck-input-width);padding:0}.ck.ck-link-form_layout-vertical .ck-labeled-field-view{margin:var(--ck-spacing-large) var(--ck-spacing-large) var(--ck-spacing-small)}.ck.ck-link-form_layout-vertical .ck-labeled-field-view .ck-input-text{min-width:0;width:100%}.ck.ck-link-form_layout-vertical>.ck-button{border-radius:0;margin:0;padding:var(--ck-spacing-standard);width:50%}.ck.ck-link-form_layout-vertical>.ck-button:not(:focus){border-top:1px solid var(--ck-color-base-border)}[dir=ltr] .ck.ck-link-form_layout-vertical>.ck-button,[dir=rtl] .ck.ck-link-form_layout-vertical>.ck-button{margin-left:0}[dir=rtl] .ck.ck-link-form_layout-vertical>.ck-button:last-of-type{border-right:1px solid var(--ck-color-base-border)}.ck.ck-link-form_layout-vertical .ck.ck-list{margin:var(--ck-spacing-standard) var(--ck-spacing-large)}.ck.ck-link-form_layout-vertical .ck.ck-list .ck-button.ck-switchbutton{padding:0;width:100%}.ck.ck-link-form_layout-vertical .ck.ck-list .ck-button.ck-switchbutton:hover{background:none}","",{version:3,sources:["webpack://./../ckeditor5-link/theme/linkform.css","webpack://./../ckeditor5-ui/theme/mixins/_rwd.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-link/linkform.css"],names:[],mappings:"AAOA,iBACC,YAiBD,CAfC,2BACC,YACD,CCNA,oCDCD,iBAQE,cAUF,CARE,wCACC,eACD,CAEA,4BACC,cACD,CCfD,CDuBD,iCACC,aAYD,CALE,wHAEC,mCACD,CE/BF,iCAEC,+BAAgC,CADhC,SAgDD,CA7CC,wDACC,8EAMD,CAJC,uEACC,WAAY,CACZ,UACD,CAGD,4CAIC,eAAgB,CAFhB,QAAS,CADT,kCAAmC,CAEnC,SAkBD,CAfC,wDACC,gDACD,CARD,4GAeE,aAMF,CAJE,mEACC,kDACD,CAKF,6CACC,yDAUD,CARC,wEACC,SAAU,CACV,UAKD,CAHC,8EACC,eACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_rwd.css";

.ck.ck-link-form {
	display: flex;

	& .ck-label {
		display: none;
	}

	@mixin ck-media-phone {
		flex-wrap: wrap;

		& .ck-labeled-field-view {
			flex-basis: 100%;
		}

		& .ck-button {
			flex-basis: 50%;
		}
	}
}

/*
 * Style link form differently when manual decorators are available.
 * See: https://github.com/ckeditor/ckeditor5-link/issues/186.
 */
.ck.ck-link-form_layout-vertical {
	display: block;

	/*
	 * Whether the form is in the responsive mode or not, if there are decorator buttons
	 * keep the top margin of action buttons medium.
	 */
	& .ck-button {
		&.ck-button-save,
		&.ck-button-cancel {
			margin-top: var(--ck-spacing-medium);
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@define-mixin ck-media-phone {
	@media screen and (max-width: 600px) {
		@mixin-content;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_dir.css";

/*
 * Style link form differently when manual decorators are available.
 * See: https://github.com/ckeditor/ckeditor5-link/issues/186.
 */
.ck.ck-link-form_layout-vertical {
	padding: 0;
	min-width: var(--ck-input-width);

	& .ck-labeled-field-view {
		margin: var(--ck-spacing-large) var(--ck-spacing-large) var(--ck-spacing-small);

		& .ck-input-text {
			min-width: 0;
			width: 100%;
		}
	}

	& > .ck-button {
		padding: var(--ck-spacing-standard);
		margin: 0;
		width: 50%;
		border-radius: 0;

		&:not(:focus) {
			border-top: 1px solid var(--ck-color-base-border);
		}

		@mixin ck-dir ltr {
			margin-left: 0;
		}

		@mixin ck-dir rtl {
			margin-left: 0;

			&:last-of-type {
				border-right: 1px solid var(--ck-color-base-border);
			}
		}
	}

	/* Using additional \`.ck\` class for stronger CSS specificity than \`.ck.ck-link-form > :not(:first-child)\`. */
	& .ck.ck-list {
		margin: var(--ck-spacing-standard) var(--ck-spacing-large);

		& .ck-button.ck-switchbutton {
			padding: 0;
			width: 100%;

			&:hover {
				background: none;
			}
		}
	}
}
`],sourceRoot:""}]);const O=P},4721:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-collapsible.ck-collapsible_collapsed>.ck-collapsible__children{display:none}:root{--ck-collapsible-arrow-size:calc(var(--ck-icon-size)*0.5)}.ck.ck-collapsible>.ck.ck-button{border-radius:0;color:inherit;font-weight:700;padding:var(--ck-spacing-medium) var(--ck-spacing-large);width:100%}.ck.ck-collapsible>.ck.ck-button:focus{background:transparent}.ck.ck-collapsible>.ck.ck-button:active,.ck.ck-collapsible>.ck.ck-button:hover:not(:focus),.ck.ck-collapsible>.ck.ck-button:not(:focus){background:transparent;border-color:transparent;box-shadow:none}.ck.ck-collapsible>.ck.ck-button>.ck-icon{margin-right:var(--ck-spacing-medium);width:var(--ck-collapsible-arrow-size)}.ck.ck-collapsible>.ck-collapsible__children{padding:0 var(--ck-spacing-large) var(--ck-spacing-large)}.ck.ck-collapsible.ck-collapsible_collapsed>.ck.ck-button .ck-icon{transform:rotate(-90deg)}","",{version:3,sources:["webpack://./../ckeditor5-list/theme/collapsible.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-list/collapsible.css"],names:[],mappings:"AAMC,sEACC,YACD,CCHD,MACC,yDACD,CAGC,iCAIC,eAAgB,CAChB,aAAc,CAHd,eAAiB,CACjB,wDAAyD,CAFzD,UAoBD,CAdC,uCACC,sBACD,CAEA,wIACC,sBAAuB,CACvB,wBAAyB,CACzB,eACD,CAEA,0CACC,qCAAsC,CACtC,sCACD,CAGD,6CACC,yDACD,CAGC,mEACC,wBACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-collapsible.ck-collapsible_collapsed {
	& > .ck-collapsible__children {
		display: none;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-collapsible-arrow-size: calc(0.5 * var(--ck-icon-size));
}

.ck.ck-collapsible {
	& > .ck.ck-button {
		width: 100%;
		font-weight: bold;
		padding: var(--ck-spacing-medium) var(--ck-spacing-large);
		border-radius: 0;
		color: inherit;

		&:focus {
			background: transparent;
		}

		&:active, &:not(:focus), &:hover:not(:focus) {
			background: transparent;
			border-color: transparent;
			box-shadow: none;
		}

		& > .ck-icon {
			margin-right: var(--ck-spacing-medium);
			width: var(--ck-collapsible-arrow-size);
		}
	}

	& > .ck-collapsible__children {
		padding: 0 var(--ck-spacing-large) var(--ck-spacing-large);
	}

	&.ck-collapsible_collapsed {
		& > .ck.ck-button .ck-icon {
			transform: rotate(-90deg);
		}
	}
}
`],sourceRoot:""}]);const O=P},4564:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck-content ol{list-style-type:decimal}.ck-content ol ol{list-style-type:lower-latin}.ck-content ol ol ol{list-style-type:lower-roman}.ck-content ol ol ol ol{list-style-type:upper-latin}.ck-content ol ol ol ol ol{list-style-type:upper-roman}.ck-content ul{list-style-type:disc}.ck-content ul ul{list-style-type:circle}.ck-content ul ul ul,.ck-content ul ul ul ul{list-style-type:square}","",{version:3,sources:["webpack://./../ckeditor5-list/theme/list.css"],names:[],mappings:"AAKA,eACC,uBAiBD,CAfC,kBACC,2BAaD,CAXC,qBACC,2BASD,CAPC,wBACC,2BAKD,CAHC,2BACC,2BACD,CAMJ,eACC,oBAaD,CAXC,kBACC,sBASD,CAJE,6CACC,sBACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck-content ol {
	list-style-type: decimal;

	& ol {
		list-style-type: lower-latin;

		& ol {
			list-style-type: lower-roman;

			& ol {
				list-style-type: upper-latin;

				& ol {
					list-style-type: upper-roman;
				}
			}
		}
	}
}

.ck-content ul {
	list-style-type: disc;

	& ul {
		list-style-type: circle;

		& ul {
			list-style-type: square;

			& ul {
				list-style-type: square;
			}
		}
	}
}
`],sourceRoot:""}]);const O=P},6082:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-list-properties.ck-list-properties_without-styles{padding:var(--ck-spacing-large)}.ck.ck-list-properties.ck-list-properties_without-styles>*{min-width:14em}.ck.ck-list-properties.ck-list-properties_without-styles>*+*{margin-top:var(--ck-spacing-standard)}.ck.ck-list-properties.ck-list-properties_with-numbered-properties>.ck-list-styles-list{grid-template-columns:repeat(4,auto)}.ck.ck-list-properties.ck-list-properties_with-numbered-properties>.ck-collapsible{border-top:1px solid var(--ck-color-base-border)}.ck.ck-list-properties.ck-list-properties_with-numbered-properties>.ck-collapsible>.ck-collapsible__children>*{width:100%}.ck.ck-list-properties.ck-list-properties_with-numbered-properties>.ck-collapsible>.ck-collapsible__children>*+*{margin-top:var(--ck-spacing-standard)}.ck.ck-list-properties .ck.ck-numbered-list-properties__start-index .ck-input{min-width:auto;width:100%}.ck.ck-list-properties .ck.ck-numbered-list-properties__reversed-order{background:transparent;margin-bottom:calc(var(--ck-spacing-tiny)*-1);padding-left:0;padding-right:0}.ck.ck-list-properties .ck.ck-numbered-list-properties__reversed-order:active,.ck.ck-list-properties .ck.ck-numbered-list-properties__reversed-order:hover{background:none;border-color:transparent;box-shadow:none}","",{version:3,sources:["webpack://./../ckeditor5-theme-lark/theme/ckeditor5-list/listproperties.css"],names:[],mappings:"AAOC,yDACC,+BASD,CAPC,2DACC,cAKD,CAHC,6DACC,qCACD,CASD,wFACC,oCACD,CAGA,mFACC,gDAWD,CARE,+GACC,UAKD,CAHC,iHACC,qCACD,CAMJ,8EACC,cAAe,CACf,UACD,CAEA,uEACC,sBAAuB,CAGvB,6CAAgD,CAFhD,cAAe,CACf,eAQD,CALC,2JAGC,eAAgB,CADhB,wBAAyB,CADzB,eAGD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-list-properties {
	/* When there are no list styles and there is no collapsible. */
	&.ck-list-properties_without-styles {
		padding: var(--ck-spacing-large);

		& > * {
			min-width: 14em;

			& + * {
				margin-top: var(--ck-spacing-standard);
			}
		}
	}

	/*
	 * When the numbered list property fields (start at, reversed) should be displayed,
	 * more horizontal space is needed. Reconfigure the style grid to create that space.
	 */
	&.ck-list-properties_with-numbered-properties {
		& > .ck-list-styles-list {
			grid-template-columns: repeat( 4, auto );
		}

		/* When list styles are rendered and property fields are in a collapsible. */
		& > .ck-collapsible {
			border-top: 1px solid var(--ck-color-base-border);

			& > .ck-collapsible__children {
				& > * {
					width: 100%;

					& + * {
						margin-top: var(--ck-spacing-standard);
					}
				}
			}
		}
	}

	& .ck.ck-numbered-list-properties__start-index .ck-input {
		min-width: auto;
		width: 100%;
	}

	& .ck.ck-numbered-list-properties__reversed-order {
		background: transparent;
		padding-left: 0;
		padding-right: 0;
		margin-bottom: calc(-1 * var(--ck-spacing-tiny));

		&:active, &:hover {
			box-shadow: none;
			border-color: transparent;
			background: none;
		}
	}
}
`],sourceRoot:""}]);const O=P},2417:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-list-styles-list{display:grid}:root{--ck-list-style-button-size:44px}.ck.ck-list-styles-list{column-gap:var(--ck-spacing-medium);grid-template-columns:repeat(3,auto);padding:var(--ck-spacing-large);row-gap:var(--ck-spacing-medium)}.ck.ck-list-styles-list .ck-button{box-sizing:content-box;margin:0;padding:0}.ck.ck-list-styles-list .ck-button,.ck.ck-list-styles-list .ck-button .ck-icon{height:var(--ck-list-style-button-size);width:var(--ck-list-style-button-size)}","",{version:3,sources:["webpack://./../ckeditor5-list/theme/liststyles.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-list/liststyles.css"],names:[],mappings:"AAKA,wBACC,YACD,CCFA,MACC,gCACD,CAEA,wBAGC,mCAAoC,CAFpC,oCAAwC,CAGxC,+BAAgC,CAFhC,gCA4BD,CAxBC,mCAiBC,sBAAuB,CAPvB,QAAS,CANT,SAmBD,CAJC,+EAhBA,uCAAwC,CADxC,sCAoBA",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-list-styles-list {
	display: grid;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-list-style-button-size: 44px;
}

.ck.ck-list-styles-list {
	grid-template-columns: repeat( 3, auto );
	row-gap: var(--ck-spacing-medium);
	column-gap: var(--ck-spacing-medium);
	padding: var(--ck-spacing-large);

	& .ck-button {
		/* Make the button look like a thumbnail (the icon "takes it all"). */
		width: var(--ck-list-style-button-size);
		height: var(--ck-list-style-button-size);
		padding: 0;

		/*
		 * Buttons are aligned by the grid so disable default button margins to not collide with the
		 * gaps in the grid.
		 */
		margin: 0;

		/*
		 * Make sure the button border (which is displayed on focus, BTW) does not steal pixels
		 * from the button dimensions and, as a result, decrease the size of the icon
		 * (which becomes blurry as it scales down).
		 */
		box-sizing: content-box;

		& .ck-icon {
			width: var(--ck-list-style-button-size);
			height: var(--ck-list-style-button-size);
		}
	}
}
`],sourceRoot:""}]);const O=P},4652:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck-content .media{clear:both;display:block;margin:.9em 0;min-width:15em}","",{version:3,sources:["webpack://./../ckeditor5-media-embed/theme/mediaembed.css"],names:[],mappings:"AAKA,mBAGC,UAAW,CASX,aAAc,CAJd,aAAe,CAQf,cACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck-content .media {
	/* Don't allow floated content overlap the media.
	https://github.com/ckeditor/ckeditor5-media-embed/issues/53 */
	clear: both;

	/* Make sure there is some space between the content and the media. */
	/* The first value should be equal to --ck-spacing-large variable if used in the editor context
	to avoid the content jumping (See https://github.com/ckeditor/ckeditor5/issues/9825). */
	margin: 0.9em 0;

	/* Make sure media is not overriden with Bootstrap default \`flex\` value.
	See: https://github.com/ckeditor/ckeditor5/issues/1373. */
	display: block;

	/* Give the media some minimal width in the content to prevent them
	from being "squashed" in tight spaces, e.g. in table cells (#44) */
	min-width: 15em;
}
`],sourceRoot:""}]);const O=P},7442:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,'.ck-media__wrapper .ck-media__placeholder{align-items:center;display:flex;flex-direction:column}.ck-media__wrapper .ck-media__placeholder .ck-media__placeholder__url{max-width:100%;position:relative}.ck-media__wrapper .ck-media__placeholder .ck-media__placeholder__url .ck-media__placeholder__url__text{display:block;overflow:hidden}.ck-media__wrapper[data-oembed-url*="facebook.com"] .ck-media__placeholder__icon *,.ck-media__wrapper[data-oembed-url*="goo.gl/maps"] .ck-media__placeholder__icon *,.ck-media__wrapper[data-oembed-url*="google.com/maps"] .ck-media__placeholder__icon *,.ck-media__wrapper[data-oembed-url*="instagram.com"] .ck-media__placeholder__icon *,.ck-media__wrapper[data-oembed-url*="maps.app.goo.gl"] .ck-media__placeholder__icon *,.ck-media__wrapper[data-oembed-url*="maps.google.com"] .ck-media__placeholder__icon *,.ck-media__wrapper[data-oembed-url*="twitter.com"] .ck-media__placeholder__icon *{display:none}.ck-editor__editable:not(.ck-read-only) .ck-media__wrapper>:not(.ck-media__placeholder),.ck-editor__editable:not(.ck-read-only) .ck-widget:not(.ck-widget_selected) .ck-media__placeholder{pointer-events:none}:root{--ck-media-embed-placeholder-icon-size:3em;--ck-color-media-embed-placeholder-url-text:#757575;--ck-color-media-embed-placeholder-url-text-hover:var(--ck-color-base-text)}.ck-media__wrapper{margin:0 auto}.ck-media__wrapper .ck-media__placeholder{background:var(--ck-color-base-foreground);padding:calc(var(--ck-spacing-standard)*3)}.ck-media__wrapper .ck-media__placeholder .ck-media__placeholder__icon{background-position:50%;background-size:cover;height:var(--ck-media-embed-placeholder-icon-size);margin-bottom:var(--ck-spacing-large);min-width:var(--ck-media-embed-placeholder-icon-size)}.ck-media__wrapper .ck-media__placeholder .ck-media__placeholder__icon .ck-icon{height:100%;width:100%}.ck-media__wrapper .ck-media__placeholder .ck-media__placeholder__url__text{color:var(--ck-color-media-embed-placeholder-url-text);font-style:italic;text-align:center;text-overflow:ellipsis;white-space:nowrap}.ck-media__wrapper .ck-media__placeholder .ck-media__placeholder__url__text:hover{color:var(--ck-color-media-embed-placeholder-url-text-hover);cursor:pointer;text-decoration:underline}.ck-media__wrapper[data-oembed-url*="open.spotify.com"]{max-height:380px;max-width:300px}.ck-media__wrapper[data-oembed-url*="goo.gl/maps"] .ck-media__placeholder__icon,.ck-media__wrapper[data-oembed-url*="google.com/maps"] .ck-media__placeholder__icon,.ck-media__wrapper[data-oembed-url*="maps.app.goo.gl"] .ck-media__placeholder__icon,.ck-media__wrapper[data-oembed-url*="maps.google.com"] .ck-media__placeholder__icon{background-image:url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNTAuMzc4IiBoZWlnaHQ9IjI1NC4xNjciIHZpZXdCb3g9IjAgMCA2Ni4yNDYgNjcuMjQ4Ij48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTcyLjUzMSAtMjE4LjQ1NSkgc2NhbGUoLjk4MDEyKSI+PHJlY3Qgcnk9IjUuMjM4IiByeD0iNS4yMzgiIHk9IjIzMS4zOTkiIHg9IjE3Ni4wMzEiIGhlaWdodD0iNjAuMDk5IiB3aWR0aD0iNjAuMDk5IiBmaWxsPSIjMzRhNjY4IiBwYWludC1vcmRlcj0ibWFya2VycyBzdHJva2UgZmlsbCIvPjxwYXRoIGQ9Im0yMDYuNDc3IDI2MC45LTI4Ljk4NyAyOC45ODdhNS4yMTggNS4yMTggMCAwIDAgMy43OCAxLjYxaDQ5LjYyMWMxLjY5NCAwIDMuMTktLjc5OCA0LjE0Ni0yLjAzN3oiIGZpbGw9IiM1Yzg4YzUiLz48cGF0aCBkPSJNMjI2Ljc0MiAyMjIuOTg4Yy05LjI2NiAwLTE2Ljc3NyA3LjE3LTE2Ljc3NyAxNi4wMTQuMDA3IDIuNzYyLjY2MyA1LjQ3NCAyLjA5MyA3Ljg3NS40My43MDMuODMgMS40MDggMS4xOSAyLjEwNy4zMzMuNTAyLjY1IDEuMDA1Ljk1IDEuNTA4LjM0My40NzcuNjczLjk1Ny45ODggMS40NCAxLjMxIDEuNzY5IDIuNSAzLjUwMiAzLjYzNyA1LjE2OC43OTMgMS4yNzUgMS42ODMgMi42NCAyLjQ2NiAzLjk5IDIuMzYzIDQuMDk0IDQuMDA3IDguMDkyIDQuNiAxMy45MTR2LjAxMmMuMTgyLjQxMi41MTYuNjY2Ljg3OS42NjcuNDAzLS4wMDEuNzY4LS4zMTQuOTMtLjc5OS42MDMtNS43NTYgMi4yMzgtOS43MjkgNC41ODUtMTMuNzk0Ljc4Mi0xLjM1IDEuNjczLTIuNzE1IDIuNDY1LTMuOTkgMS4xMzctMS42NjYgMi4zMjgtMy40IDMuNjM4LTUuMTY5LjMxNS0uNDgyLjY0NS0uOTYyLjk4OC0xLjQzOS4zLS41MDMuNjE3LTEuMDA2Ljk1LTEuNTA4LjM1OS0uNy43Ni0xLjQwNCAxLjE5LTIuMTA3IDEuNDI2LTIuNDAyIDItNS4xMTQgMi4wMDQtNy44NzUgMC04Ljg0NC03LjUxMS0xNi4wMTQtMTYuNzc2LTE2LjAxNHoiIGZpbGw9IiNkZDRiM2UiIHBhaW50LW9yZGVyPSJtYXJrZXJzIHN0cm9rZSBmaWxsIi8+PGVsbGlwc2Ugcnk9IjUuNTY0IiByeD0iNS44MjgiIGN5PSIyMzkuMDAyIiBjeD0iMjI2Ljc0MiIgZmlsbD0iIzgwMmQyNyIgcGFpbnQtb3JkZXI9Im1hcmtlcnMgc3Ryb2tlIGZpbGwiLz48cGF0aCBkPSJNMTkwLjMwMSAyMzcuMjgzYy00LjY3IDAtOC40NTcgMy44NTMtOC40NTcgOC42MDZzMy43ODYgOC42MDcgOC40NTcgOC42MDdjMy4wNDMgMCA0LjgwNi0uOTU4IDYuMzM3LTIuNTE2IDEuNTMtMS41NTcgMi4wODctMy45MTMgMi4wODctNi4yOSAwLS4zNjItLjAyMy0uNzIyLS4wNjQtMS4wNzloLTguMjU3djMuMDQzaDQuODVjLS4xOTcuNzU5LS41MzEgMS40NS0xLjA1OCAxLjk4Ni0uOTQyLjk1OC0yLjAyOCAxLjU0OC0zLjkwMSAxLjU0OC0yLjg3NiAwLTUuMjA4LTIuMzcyLTUuMjA4LTUuMjk5IDAtMi45MjYgMi4zMzItNS4yOTkgNS4yMDgtNS4yOTkgMS4zOTkgMCAyLjYxOC40MDcgMy41ODQgMS4yOTNsMi4zODEtMi4zOGMwLS4wMDItLjAwMy0uMDA0LS4wMDQtLjAwNS0xLjU4OC0xLjUyNC0zLjYyLTIuMjE1LTUuOTU1LTIuMjE1em00LjQzIDUuNjYuMDAzLjAwNnYtLjAwM3oiIGZpbGw9IiNmZmYiIHBhaW50LW9yZGVyPSJtYXJrZXJzIHN0cm9rZSBmaWxsIi8+PHBhdGggZD0ibTIxNS4xODQgMjUxLjkyOS03Ljk4IDcuOTc5IDI4LjQ3NyAyOC40NzVhNS4yMzMgNS4yMzMgMCAwIDAgLjQ0OS0yLjEyM3YtMzEuMTY1Yy0uNDY5LjY3NS0uOTM0IDEuMzQ5LTEuMzgyIDIuMDA1LS43OTIgMS4yNzUtMS42ODIgMi42NC0yLjQ2NSAzLjk5LTIuMzQ3IDQuMDY1LTMuOTgyIDguMDM4LTQuNTg1IDEzLjc5NC0uMTYyLjQ4NS0uNTI3Ljc5OC0uOTMuNzk5LS4zNjMtLjAwMS0uNjk3LS4yNTUtLjg3OS0uNjY3di0uMDEyYy0uNTkzLTUuODIyLTIuMjM3LTkuODItNC42LTEzLjkxNC0uNzgzLTEuMzUtMS42NzMtMi43MTUtMi40NjYtMy45OS0xLjEzNy0xLjY2Ni0yLjMyNy0zLjQtMy42MzctNS4xNjlsLS4wMDItLjAwM3oiIGZpbGw9IiNjM2MzYzMiLz48cGF0aCBkPSJtMjEyLjk4MyAyNDguNDk1LTM2Ljk1MiAzNi45NTN2LjgxMmE1LjIyNyA1LjIyNyAwIDAgMCA1LjIzOCA1LjIzOGgxLjAxNWwzNS42NjYtMzUuNjY2YTEzNi4yNzUgMTM2LjI3NSAwIDAgMC0yLjc2NC0zLjkgMzcuNTc1IDM3LjU3NSAwIDAgMC0uOTg5LTEuNDQgMzUuMTI3IDM1LjEyNyAwIDAgMC0uOTUtMS41MDhjLS4wODMtLjE2Mi0uMTc2LS4zMjYtLjI2NC0uNDg5eiIgZmlsbD0iI2ZkZGM0ZiIgcGFpbnQtb3JkZXI9Im1hcmtlcnMgc3Ryb2tlIGZpbGwiLz48cGF0aCBkPSJtMjExLjk5OCAyNjEuMDgzLTYuMTUyIDYuMTUxIDI0LjI2NCAyNC4yNjRoLjc4MWE1LjIyNyA1LjIyNyAwIDAgMCA1LjIzOS01LjIzOHYtMS4wNDV6IiBmaWxsPSIjZmZmIiBwYWludC1vcmRlcj0ibWFya2VycyBzdHJva2UgZmlsbCIvPjwvZz48L3N2Zz4=)}.ck-media__wrapper[data-oembed-url*="facebook.com"] .ck-media__placeholder{background:#4268b3}.ck-media__wrapper[data-oembed-url*="facebook.com"] .ck-media__placeholder .ck-media__placeholder__icon{background-image:url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAyNCIgaGVpZ2h0PSIxMDI0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik05NjcuNDg0IDBINTYuNTE3QzI1LjMwNCAwIDAgMjUuMzA0IDAgNTYuNTE3djkxMC45NjZDMCA5OTguNjk0IDI1LjI5NyAxMDI0IDU2LjUyMiAxMDI0SDU0N1Y2MjhINDE0VjQ3M2gxMzNWMzU5LjAyOWMwLTEzMi4yNjIgODAuNzczLTIwNC4yODIgMTk4Ljc1Ni0yMDQuMjgyIDU2LjUxMyAwIDEwNS4wODYgNC4yMDggMTE5LjI0NCA2LjA4OVYyOTlsLTgxLjYxNi4wMzdjLTYzLjk5MyAwLTc2LjM4NCAzMC40OTItNzYuMzg0IDc1LjIzNlY0NzNoMTUzLjQ4N2wtMTkuOTg2IDE1NUg3MDd2Mzk2aDI2MC40ODRjMzEuMjEzIDAgNTYuNTE2LTI1LjMwMyA1Ni41MTYtNTYuNTE2VjU2LjUxNUMxMDI0IDI1LjMwMyA5OTguNjk3IDAgOTY3LjQ4NCAwIiBmaWxsPSIjRkZGRkZFIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiLz48L3N2Zz4=)}.ck-media__wrapper[data-oembed-url*="facebook.com"] .ck-media__placeholder .ck-media__placeholder__url__text{color:#cdf}.ck-media__wrapper[data-oembed-url*="facebook.com"] .ck-media__placeholder .ck-media__placeholder__url__text:hover{color:#fff}.ck-media__wrapper[data-oembed-url*="instagram.com"] .ck-media__placeholder{background:linear-gradient(-135deg,#1400c7,#b800b1,#f50000)}.ck-media__wrapper[data-oembed-url*="instagram.com"] .ck-media__placeholder .ck-media__placeholder__icon{background-image:url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTA0IiBoZWlnaHQ9IjUwNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGRlZnM+PHBhdGggaWQ9ImEiIGQ9Ik0wIC4xNTloNTAzLjg0MVY1MDMuOTRIMHoiLz48L2RlZnM+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48bWFzayBpZD0iYiIgZmlsbD0iI2ZmZiI+PHVzZSB4bGluazpocmVmPSIjYSIvPjwvbWFzaz48cGF0aCBkPSJNMjUxLjkyMS4xNTljLTY4LjQxOCAwLTc2Ljk5Ny4yOS0xMDMuODY3IDEuNTE2LTI2LjgxNCAxLjIyMy00NS4xMjcgNS40ODItNjEuMTUxIDExLjcxLTE2LjU2NiA2LjQzNy0zMC42MTUgMTUuMDUxLTQ0LjYyMSAyOS4wNTYtMTQuMDA1IDE0LjAwNi0yMi42MTkgMjguMDU1LTI5LjA1NiA0NC42MjEtNi4yMjggMTYuMDI0LTEwLjQ4NyAzNC4zMzctMTEuNzEgNjEuMTUxQy4yOSAxNzUuMDgzIDAgMTgzLjY2MiAwIDI1Mi4wOGMwIDY4LjQxNy4yOSA3Ni45OTYgMS41MTYgMTAzLjg2NiAxLjIyMyAyNi44MTQgNS40ODIgNDUuMTI3IDExLjcxIDYxLjE1MSA2LjQzNyAxNi41NjYgMTUuMDUxIDMwLjYxNSAyOS4wNTYgNDQuNjIxIDE0LjAwNiAxNC4wMDUgMjguMDU1IDIyLjYxOSA0NC42MjEgMjkuMDU3IDE2LjAyNCA2LjIyNyAzNC4zMzcgMTAuNDg2IDYxLjE1MSAxMS43MDkgMjYuODcgMS4yMjYgMzUuNDQ5IDEuNTE2IDEwMy44NjcgMS41MTYgNjguNDE3IDAgNzYuOTk2LS4yOSAxMDMuODY2LTEuNTE2IDI2LjgxNC0xLjIyMyA0NS4xMjctNS40ODIgNjEuMTUxLTExLjcwOSAxNi41NjYtNi40MzggMzAuNjE1LTE1LjA1MiA0NC42MjEtMjkuMDU3IDE0LjAwNS0xNC4wMDYgMjIuNjE5LTI4LjA1NSAyOS4wNTctNDQuNjIxIDYuMjI3LTE2LjAyNCAxMC40ODYtMzQuMzM3IDExLjcwOS02MS4xNTEgMS4yMjYtMjYuODcgMS41MTYtMzUuNDQ5IDEuNTE2LTEwMy44NjYgMC02OC40MTgtLjI5LTc2Ljk5Ny0xLjUxNi0xMDMuODY3LTEuMjIzLTI2LjgxNC01LjQ4Mi00NS4xMjctMTEuNzA5LTYxLjE1MS02LjQzOC0xNi41NjYtMTUuMDUyLTMwLjYxNS0yOS4wNTctNDQuNjIxLTE0LjAwNi0xNC4wMDUtMjguMDU1LTIyLjYxOS00NC42MjEtMjkuMDU2LTE2LjAyNC02LjIyOC0zNC4zMzctMTAuNDg3LTYxLjE1MS0xMS43MUMzMjguOTE3LjQ0OSAzMjAuMzM4LjE1OSAyNTEuOTIxLjE1OVptMCA0NS4zOTFjNjcuMjY1IDAgNzUuMjMzLjI1NyAxMDEuNzk3IDEuNDY5IDI0LjU2MiAxLjEyIDM3LjkwMSA1LjIyNCA0Ni43NzggOC42NzQgMTEuNzU5IDQuNTcgMjAuMTUxIDEwLjAyOSAyOC45NjYgMTguODQ1IDguODE2IDguODE1IDE0LjI3NSAxNy4yMDcgMTguODQ1IDI4Ljk2NiAzLjQ1IDguODc3IDcuNTU0IDIyLjIxNiA4LjY3NCA0Ni43NzggMS4yMTIgMjYuNTY0IDEuNDY5IDM0LjUzMiAxLjQ2OSAxMDEuNzk4IDAgNjcuMjY1LS4yNTcgNzUuMjMzLTEuNDY5IDEwMS43OTctMS4xMiAyNC41NjItNS4yMjQgMzcuOTAxLTguNjc0IDQ2Ljc3OC00LjU3IDExLjc1OS0xMC4wMjkgMjAuMTUxLTE4Ljg0NSAyOC45NjYtOC44MTUgOC44MTYtMTcuMjA3IDE0LjI3NS0yOC45NjYgMTguODQ1LTguODc3IDMuNDUtMjIuMjE2IDcuNTU0LTQ2Ljc3OCA4LjY3NC0yNi41NiAxLjIxMi0zNC41MjcgMS40NjktMTAxLjc5NyAxLjQ2OS02Ny4yNzEgMC03NS4yMzctLjI1Ny0xMDEuNzk4LTEuNDY5LTI0LjU2Mi0xLjEyLTM3LjkwMS01LjIyNC00Ni43NzgtOC42NzQtMTEuNzU5LTQuNTctMjAuMTUxLTEwLjAyOS0yOC45NjYtMTguODQ1LTguODE1LTguODE1LTE0LjI3NS0xNy4yMDctMTguODQ1LTI4Ljk2Ni0zLjQ1LTguODc3LTcuNTU0LTIyLjIxNi04LjY3NC00Ni43NzgtMS4yMTItMjYuNTY0LTEuNDY5LTM0LjUzMi0xLjQ2OS0xMDEuNzk3IDAtNjcuMjY2LjI1Ny03NS4yMzQgMS40NjktMTAxLjc5OCAxLjEyLTI0LjU2MiA1LjIyNC0zNy45MDEgOC42NzQtNDYuNzc4IDQuNTctMTEuNzU5IDEwLjAyOS0yMC4xNTEgMTguODQ1LTI4Ljk2NiA4LjgxNS04LjgxNiAxNy4yMDctMTQuMjc1IDI4Ljk2Ni0xOC44NDUgOC44NzctMy40NSAyMi4yMTYtNy41NTQgNDYuNzc4LTguNjc0IDI2LjU2NC0xLjIxMiAzNC41MzItMS40NjkgMTAxLjc5OC0xLjQ2OVoiIGZpbGw9IiNGRkYiIG1hc2s9InVybCgjYikiLz48cGF0aCBkPSJNMjUxLjkyMSAzMzYuMDUzYy00Ni4zNzggMC04My45NzQtMzcuNTk2LTgzLjk3NC04My45NzMgMC00Ni4zNzggMzcuNTk2LTgzLjk3NCA4My45NzQtODMuOTc0IDQ2LjM3NyAwIDgzLjk3MyAzNy41OTYgODMuOTczIDgzLjk3NCAwIDQ2LjM3Ny0zNy41OTYgODMuOTczLTgzLjk3MyA4My45NzNabTAtMjEzLjMzOGMtNzEuNDQ3IDAtMTI5LjM2NSA1Ny45MTgtMTI5LjM2NSAxMjkuMzY1IDAgNzEuNDQ2IDU3LjkxOCAxMjkuMzY0IDEyOS4zNjUgMTI5LjM2NCA3MS40NDYgMCAxMjkuMzY0LTU3LjkxOCAxMjkuMzY0LTEyOS4zNjQgMC03MS40NDctNTcuOTE4LTEyOS4zNjUtMTI5LjM2NC0xMjkuMzY1Wk00MTYuNjI3IDExNy42MDRjMCAxNi42OTYtMTMuNTM1IDMwLjIzLTMwLjIzMSAzMC4yMy0xNi42OTUgMC0zMC4yMy0xMy41MzQtMzAuMjMtMzAuMjMgMC0xNi42OTYgMTMuNTM1LTMwLjIzMSAzMC4yMy0zMC4yMzEgMTYuNjk2IDAgMzAuMjMxIDEzLjUzNSAzMC4yMzEgMzAuMjMxIiBmaWxsPSIjRkZGIi8+PC9nPjwvc3ZnPg==)}.ck-media__wrapper[data-oembed-url*="instagram.com"] .ck-media__placeholder .ck-media__placeholder__url__text{color:#ffe0fe}.ck-media__wrapper[data-oembed-url*="instagram.com"] .ck-media__placeholder .ck-media__placeholder__url__text:hover{color:#fff}.ck-media__wrapper[data-oembed-url*="twitter.com"] .ck.ck-media__placeholder{background:linear-gradient(90deg,#71c6f4,#0d70a5)}.ck-media__wrapper[data-oembed-url*="twitter.com"] .ck.ck-media__placeholder .ck-media__placeholder__icon{background-image:url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0MDAgNDAwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0MDAgNDAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cGF0aCBkPSJNNDAwIDIwMGMwIDExMC41LTg5LjUgMjAwLTIwMCAyMDBTMCAzMTAuNSAwIDIwMCA4OS41IDAgMjAwIDBzMjAwIDg5LjUgMjAwIDIwMHpNMTYzLjQgMzA1LjVjODguNyAwIDEzNy4yLTczLjUgMTM3LjItMTM3LjIgMC0yLjEgMC00LjItLjEtNi4yIDkuNC02LjggMTcuNi0xNS4zIDI0LjEtMjUtOC42IDMuOC0xNy45IDYuNC0yNy43IDcuNiAxMC02IDE3LjYtMTUuNCAyMS4yLTI2LjctOS4zIDUuNS0xOS42IDkuNS0zMC42IDExLjctOC44LTkuNC0yMS4zLTE1LjItMzUuMi0xNS4yLTI2LjYgMC00OC4yIDIxLjYtNDguMiA0OC4yIDAgMy44LjQgNy41IDEuMyAxMS00MC4xLTItNzUuNi0yMS4yLTk5LjQtNTAuNC00LjEgNy4xLTYuNSAxNS40LTYuNSAyNC4yIDAgMTYuNyA4LjUgMzEuNSAyMS41IDQwLjEtNy45LS4yLTE1LjMtMi40LTIxLjgtNnYuNmMwIDIzLjQgMTYuNiA0Mi44IDM4LjcgNDcuMy00IDEuMS04LjMgMS43LTEyLjcgMS43LTMuMSAwLTYuMS0uMy05LjEtLjkgNi4xIDE5LjIgMjMuOSAzMy4xIDQ1IDMzLjUtMTYuNSAxMi45LTM3LjMgMjAuNi01OS45IDIwLjYtMy45IDAtNy43LS4yLTExLjUtLjcgMjEuMSAxMy44IDQ2LjUgMjEuOCA3My43IDIxLjgiIHN0eWxlPSJmaWxsOiNmZmYiLz48L3N2Zz4=)}.ck-media__wrapper[data-oembed-url*="twitter.com"] .ck.ck-media__placeholder .ck-media__placeholder__url__text{color:#b8e6ff}.ck-media__wrapper[data-oembed-url*="twitter.com"] .ck.ck-media__placeholder .ck-media__placeholder__url__text:hover{color:#fff}',"",{version:3,sources:["webpack://./../ckeditor5-media-embed/theme/mediaembedediting.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-media-embed/mediaembedediting.css"],names:[],mappings:"AAMC,0CAGC,kBAAmB,CAFnB,YAAa,CACb,qBAcD,CAXC,sEAEC,cAAe,CAEf,iBAMD,CAJC,wGAEC,aAAc,CADd,eAED,CAWD,6kBACC,YACD,CAYF,2LACC,mBACD,CC1CA,MACC,0CAA2C,CAE3C,mDAA4D,CAC5D,2EACD,CAEA,mBACC,aA+FD,CA7FC,0CAEC,0CAA2C,CAD3C,0CA6BD,CA1BC,uEAIC,uBAA2B,CAC3B,qBAAsB,CAHtB,kDAAmD,CACnD,qCAAsC,CAFtC,qDAUD,CAJC,gFAEC,WAAY,CADZ,UAED,CAGD,4EACC,sDAAuD,CAGvD,iBAAkB,CADlB,iBAAkB,CAElB,sBAAuB,CAHvB,kBAUD,CALC,kFACC,4DAA6D,CAC7D,cAAe,CACf,yBACD,CAIF,wDAEC,gBAAiB,CADjB,eAED,CAEA,4UAIC,wvGACD,CAEA,2EACC,kBAaD,CAXC,wGACC,orBACD,CAEA,6GACC,UAKD,CAHC,mHACC,UACD,CAIF,4EACC,2DAcD,CAZC,yGACC,4jHACD,CAGA,8GACC,aAKD,CAHC,oHACC,UACD,CAIF,6EAEC,iDAaD,CAXC,0GACC,wiCACD,CAEA,+GACC,aAKD,CAHC,qHACC,UACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck-media__wrapper {
	& .ck-media__placeholder {
		display: flex;
		flex-direction: column;
		align-items: center;

		& .ck-media__placeholder__url {
			/* Otherwise the URL will overflow when the content is very narrow. */
			max-width: 100%;

			position: relative;

			& .ck-media__placeholder__url__text {
				overflow: hidden;
				display: block;
			}
		}
	}

	&[data-oembed-url*="twitter.com"],
	&[data-oembed-url*="google.com/maps"],
	&[data-oembed-url*="goo.gl/maps"],
	&[data-oembed-url*="maps.google.com"],
	&[data-oembed-url*="maps.app.goo.gl"],
	&[data-oembed-url*="facebook.com"],
	&[data-oembed-url*="instagram.com"] {
		& .ck-media__placeholder__icon * {
			display: none;
		}
	}
}

/* Disable all mouse interaction as long as the editor is not read–only.
   https://github.com/ckeditor/ckeditor5-media-embed/issues/58 */
.ck-editor__editable:not(.ck-read-only) .ck-media__wrapper > *:not(.ck-media__placeholder) {
	pointer-events: none;
}

/* Disable all mouse interaction when the widget is not selected (e.g. to avoid opening links by accident).
   https://github.com/ckeditor/ckeditor5-media-embed/issues/18 */
.ck-editor__editable:not(.ck-read-only) .ck-widget:not(.ck-widget_selected) .ck-media__placeholder {
	pointer-events: none;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-media-embed-placeholder-icon-size: 3em;

	--ck-color-media-embed-placeholder-url-text: hsl(0, 0%, 46%);
	--ck-color-media-embed-placeholder-url-text-hover: var(--ck-color-base-text);
}

.ck-media__wrapper {
	margin: 0 auto;

	& .ck-media__placeholder {
		padding: calc( 3 * var(--ck-spacing-standard) );
		background: var(--ck-color-base-foreground);

		& .ck-media__placeholder__icon {
			min-width: var(--ck-media-embed-placeholder-icon-size);
			height: var(--ck-media-embed-placeholder-icon-size);
			margin-bottom: var(--ck-spacing-large);
			background-position: center;
			background-size: cover;

			& .ck-icon {
				width: 100%;
				height: 100%;
			}
		}

		& .ck-media__placeholder__url__text {
			color: var(--ck-color-media-embed-placeholder-url-text);
			white-space: nowrap;
			text-align: center;
			font-style: italic;
			text-overflow: ellipsis;

			&:hover {
				color: var(--ck-color-media-embed-placeholder-url-text-hover);
				cursor: pointer;
				text-decoration: underline;
			}
		}
	}

	&[data-oembed-url*="open.spotify.com"] {
		max-width: 300px;
		max-height: 380px;
	}

	&[data-oembed-url*="google.com/maps"] .ck-media__placeholder__icon,
	&[data-oembed-url*="goo.gl/maps"] .ck-media__placeholder__icon,
	&[data-oembed-url*="maps.google.com"] .ck-media__placeholder__icon,
	&[data-oembed-url*="maps.app.goo.gl"] .ck-media__placeholder__icon {
		background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNTAuMzc4IiBoZWlnaHQ9IjI1NC4xNjciIHZpZXdCb3g9IjAgMCA2Ni4yNDYgNjcuMjQ4Ij48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTcyLjUzMSAtMjE4LjQ1NSkgc2NhbGUoLjk4MDEyKSI+PHJlY3Qgcnk9IjUuMjM4IiByeD0iNS4yMzgiIHk9IjIzMS4zOTkiIHg9IjE3Ni4wMzEiIGhlaWdodD0iNjAuMDk5IiB3aWR0aD0iNjAuMDk5IiBmaWxsPSIjMzRhNjY4IiBwYWludC1vcmRlcj0ibWFya2VycyBzdHJva2UgZmlsbCIvPjxwYXRoIGQ9Ik0yMDYuNDc3IDI2MC45bC0yOC45ODcgMjguOTg3YTUuMjE4IDUuMjE4IDAgMCAwIDMuNzggMS42MWg0OS42MjFjMS42OTQgMCAzLjE5LS43OTggNC4xNDYtMi4wMzd6IiBmaWxsPSIjNWM4OGM1Ii8+PHBhdGggZD0iTTIyNi43NDIgMjIyLjk4OGMtOS4yNjYgMC0xNi43NzcgNy4xNy0xNi43NzcgMTYuMDE0LjAwNyAyLjc2Mi42NjMgNS40NzQgMi4wOTMgNy44NzUuNDMuNzAzLjgzIDEuNDA4IDEuMTkgMi4xMDcuMzMzLjUwMi42NSAxLjAwNS45NSAxLjUwOC4zNDMuNDc3LjY3My45NTcuOTg4IDEuNDQgMS4zMSAxLjc2OSAyLjUgMy41MDIgMy42MzcgNS4xNjguNzkzIDEuMjc1IDEuNjgzIDIuNjQgMi40NjYgMy45OSAyLjM2MyA0LjA5NCA0LjAwNyA4LjA5MiA0LjYgMTMuOTE0di4wMTJjLjE4Mi40MTIuNTE2LjY2Ni44NzkuNjY3LjQwMy0uMDAxLjc2OC0uMzE0LjkzLS43OTkuNjAzLTUuNzU2IDIuMjM4LTkuNzI5IDQuNTg1LTEzLjc5NC43ODItMS4zNSAxLjY3My0yLjcxNSAyLjQ2NS0zLjk5IDEuMTM3LTEuNjY2IDIuMzI4LTMuNCAzLjYzOC01LjE2OS4zMTUtLjQ4Mi42NDUtLjk2Mi45ODgtMS40MzkuMy0uNTAzLjYxNy0xLjAwNi45NS0xLjUwOC4zNTktLjcuNzYtMS40MDQgMS4xOS0yLjEwNyAxLjQyNi0yLjQwMiAyLTUuMTE0IDIuMDA0LTcuODc1IDAtOC44NDQtNy41MTEtMTYuMDE0LTE2Ljc3Ni0xNi4wMTR6IiBmaWxsPSIjZGQ0YjNlIiBwYWludC1vcmRlcj0ibWFya2VycyBzdHJva2UgZmlsbCIvPjxlbGxpcHNlIHJ5PSI1LjU2NCIgcng9IjUuODI4IiBjeT0iMjM5LjAwMiIgY3g9IjIyNi43NDIiIGZpbGw9IiM4MDJkMjciIHBhaW50LW9yZGVyPSJtYXJrZXJzIHN0cm9rZSBmaWxsIi8+PHBhdGggZD0iTTE5MC4zMDEgMjM3LjI4M2MtNC42NyAwLTguNDU3IDMuODUzLTguNDU3IDguNjA2czMuNzg2IDguNjA3IDguNDU3IDguNjA3YzMuMDQzIDAgNC44MDYtLjk1OCA2LjMzNy0yLjUxNiAxLjUzLTEuNTU3IDIuMDg3LTMuOTEzIDIuMDg3LTYuMjkgMC0uMzYyLS4wMjMtLjcyMi0uMDY0LTEuMDc5aC04LjI1N3YzLjA0M2g0Ljg1Yy0uMTk3Ljc1OS0uNTMxIDEuNDUtMS4wNTggMS45ODYtLjk0Mi45NTgtMi4wMjggMS41NDgtMy45MDEgMS41NDgtMi44NzYgMC01LjIwOC0yLjM3Mi01LjIwOC01LjI5OSAwLTIuOTI2IDIuMzMyLTUuMjk5IDUuMjA4LTUuMjk5IDEuMzk5IDAgMi42MTguNDA3IDMuNTg0IDEuMjkzbDIuMzgxLTIuMzhjMC0uMDAyLS4wMDMtLjAwNC0uMDA0LS4wMDUtMS41ODgtMS41MjQtMy42Mi0yLjIxNS01Ljk1NS0yLjIxNXptNC40MyA1LjY2bC4wMDMuMDA2di0uMDAzeiIgZmlsbD0iI2ZmZiIgcGFpbnQtb3JkZXI9Im1hcmtlcnMgc3Ryb2tlIGZpbGwiLz48cGF0aCBkPSJNMjE1LjE4NCAyNTEuOTI5bC03Ljk4IDcuOTc5IDI4LjQ3NyAyOC40NzVjLjI4Ny0uNjQ5LjQ0OS0xLjM2Ni40NDktMi4xMjN2LTMxLjE2NWMtLjQ2OS42NzUtLjkzNCAxLjM0OS0xLjM4MiAyLjAwNS0uNzkyIDEuMjc1LTEuNjgyIDIuNjQtMi40NjUgMy45OS0yLjM0NyA0LjA2NS0zLjk4MiA4LjAzOC00LjU4NSAxMy43OTQtLjE2Mi40ODUtLjUyNy43OTgtLjkzLjc5OS0uMzYzLS4wMDEtLjY5Ny0uMjU1LS44NzktLjY2N3YtLjAxMmMtLjU5My01LjgyMi0yLjIzNy05LjgyLTQuNi0xMy45MTQtLjc4My0xLjM1LTEuNjczLTIuNzE1LTIuNDY2LTMuOTktMS4xMzctMS42NjYtMi4zMjctMy40LTMuNjM3LTUuMTY5bC0uMDAyLS4wMDN6IiBmaWxsPSIjYzNjM2MzIi8+PHBhdGggZD0iTTIxMi45ODMgMjQ4LjQ5NWwtMzYuOTUyIDM2Ljk1M3YuODEyYTUuMjI3IDUuMjI3IDAgMCAwIDUuMjM4IDUuMjM4aDEuMDE1bDM1LjY2Ni0zNS42NjZhMTM2LjI3NSAxMzYuMjc1IDAgMCAwLTIuNzY0LTMuOSAzNy41NzUgMzcuNTc1IDAgMCAwLS45ODktMS40NGMtLjI5OS0uNTAzLS42MTYtMS4wMDYtLjk1LTEuNTA4LS4wODMtLjE2Mi0uMTc2LS4zMjYtLjI2NC0uNDg5eiIgZmlsbD0iI2ZkZGM0ZiIgcGFpbnQtb3JkZXI9Im1hcmtlcnMgc3Ryb2tlIGZpbGwiLz48cGF0aCBkPSJNMjExLjk5OCAyNjEuMDgzbC02LjE1MiA2LjE1MSAyNC4yNjQgMjQuMjY0aC43ODFhNS4yMjcgNS4yMjcgMCAwIDAgNS4yMzktNS4yMzh2LTEuMDQ1eiIgZmlsbD0iI2ZmZiIgcGFpbnQtb3JkZXI9Im1hcmtlcnMgc3Ryb2tlIGZpbGwiLz48L2c+PC9zdmc+);
	}

	&[data-oembed-url*="facebook.com"] .ck-media__placeholder {
		background: hsl(220, 46%, 48%);

		& .ck-media__placeholder__icon {
			background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIHdpZHRoPSIxMDI0cHgiIGhlaWdodD0iMTAyNHB4IiB2aWV3Qm94PSIwIDAgMTAyNCAxMDI0IiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPiAgICAgICAgPHRpdGxlPkZpbGwgMTwvdGl0bGU+ICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPiAgICA8ZGVmcz48L2RlZnM+ICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPiAgICAgICAgPGcgaWQ9ImZMb2dvX1doaXRlIiBmaWxsPSIjRkZGRkZFIj4gICAgICAgICAgICA8cGF0aCBkPSJNOTY3LjQ4NCwwIEw1Ni41MTcsMCBDMjUuMzA0LDAgMCwyNS4zMDQgMCw1Ni41MTcgTDAsOTY3LjQ4MyBDMCw5OTguNjk0IDI1LjI5NywxMDI0IDU2LjUyMiwxMDI0IEw1NDcsMTAyNCBMNTQ3LDYyOCBMNDE0LDYyOCBMNDE0LDQ3MyBMNTQ3LDQ3MyBMNTQ3LDM1OS4wMjkgQzU0NywyMjYuNzY3IDYyNy43NzMsMTU0Ljc0NyA3NDUuNzU2LDE1NC43NDcgQzgwMi4yNjksMTU0Ljc0NyA4NTAuODQyLDE1OC45NTUgODY1LDE2MC44MzYgTDg2NSwyOTkgTDc4My4zODQsMjk5LjAzNyBDNzE5LjM5MSwyOTkuMDM3IDcwNywzMjkuNTI5IDcwNywzNzQuMjczIEw3MDcsNDczIEw4NjAuNDg3LDQ3MyBMODQwLjUwMSw2MjggTDcwNyw2MjggTDcwNywxMDI0IEw5NjcuNDg0LDEwMjQgQzk5OC42OTcsMTAyNCAxMDI0LDk5OC42OTcgMTAyNCw5NjcuNDg0IEwxMDI0LDU2LjUxNSBDMTAyNCwyNS4zMDMgOTk4LjY5NywwIDk2Ny40ODQsMCIgaWQ9IkZpbGwtMSI+PC9wYXRoPiAgICAgICAgPC9nPiAgICA8L2c+PC9zdmc+);
		}

		& .ck-media__placeholder__url__text {
			color: hsl(220, 100%, 90%);

			&:hover {
				color: hsl(0, 0%, 100%);
			}
		}
	}

	&[data-oembed-url*="instagram.com"] .ck-media__placeholder {
		background: linear-gradient(-135deg,hsl(246, 100%, 39%),hsl(302, 100%, 36%),hsl(0, 100%, 48%));

		& .ck-media__placeholder__icon {
			background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIHdpZHRoPSI1MDRweCIgaGVpZ2h0PSI1MDRweCIgdmlld0JveD0iMCAwIDUwNCA1MDQiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+ICAgICAgICA8dGl0bGU+Z2x5cGgtbG9nb19NYXkyMDE2PC90aXRsZT4gICAgPGRlc2M+Q3JlYXRlZCB3aXRoIFNrZXRjaC48L2Rlc2M+ICAgIDxkZWZzPiAgICAgICAgPHBvbHlnb24gaWQ9InBhdGgtMSIgcG9pbnRzPSIwIDAuMTU5IDUwMy44NDEgMC4xNTkgNTAzLjg0MSA1MDMuOTQgMCA1MDMuOTQiPjwvcG9seWdvbj4gICAgPC9kZWZzPiAgICA8ZyBpZD0iZ2x5cGgtbG9nb19NYXkyMDE2IiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4gICAgICAgIDxnIGlkPSJHcm91cC0zIj4gICAgICAgICAgICA8bWFzayBpZD0ibWFzay0yIiBmaWxsPSJ3aGl0ZSI+ICAgICAgICAgICAgICAgIDx1c2UgeGxpbms6aHJlZj0iI3BhdGgtMSI+PC91c2U+ICAgICAgICAgICAgPC9tYXNrPiAgICAgICAgICAgIDxnIGlkPSJDbGlwLTIiPjwvZz4gICAgICAgICAgICA8cGF0aCBkPSJNMjUxLjkyMSwwLjE1OSBDMTgzLjUwMywwLjE1OSAxNzQuOTI0LDAuNDQ5IDE0OC4wNTQsMS42NzUgQzEyMS4yNCwyLjg5OCAxMDIuOTI3LDcuMTU3IDg2LjkwMywxMy4zODUgQzcwLjMzNywxOS44MjIgNTYuMjg4LDI4LjQzNiA0Mi4yODIsNDIuNDQxIEMyOC4yNzcsNTYuNDQ3IDE5LjY2Myw3MC40OTYgMTMuMjI2LDg3LjA2MiBDNi45OTgsMTAzLjA4NiAyLjczOSwxMjEuMzk5IDEuNTE2LDE0OC4yMTMgQzAuMjksMTc1LjA4MyAwLDE4My42NjIgMCwyNTIuMDggQzAsMzIwLjQ5NyAwLjI5LDMyOS4wNzYgMS41MTYsMzU1Ljk0NiBDMi43MzksMzgyLjc2IDYuOTk4LDQwMS4wNzMgMTMuMjI2LDQxNy4wOTcgQzE5LjY2Myw0MzMuNjYzIDI4LjI3Nyw0NDcuNzEyIDQyLjI4Miw0NjEuNzE4IEM1Ni4yODgsNDc1LjcyMyA3MC4zMzcsNDg0LjMzNyA4Ni45MDMsNDkwLjc3NSBDMTAyLjkyNyw0OTcuMDAyIDEyMS4yNCw1MDEuMjYxIDE0OC4wNTQsNTAyLjQ4NCBDMTc0LjkyNCw1MDMuNzEgMTgzLjUwMyw1MDQgMjUxLjkyMSw1MDQgQzMyMC4zMzgsNTA0IDMyOC45MTcsNTAzLjcxIDM1NS43ODcsNTAyLjQ4NCBDMzgyLjYwMSw1MDEuMjYxIDQwMC45MTQsNDk3LjAwMiA0MTYuOTM4LDQ5MC43NzUgQzQzMy41MDQsNDg0LjMzNyA0NDcuNTUzLDQ3NS43MjMgNDYxLjU1OSw0NjEuNzE4IEM0NzUuNTY0LDQ0Ny43MTIgNDg0LjE3OCw0MzMuNjYzIDQ5MC42MTYsNDE3LjA5NyBDNDk2Ljg0Myw0MDEuMDczIDUwMS4xMDIsMzgyLjc2IDUwMi4zMjUsMzU1Ljk0NiBDNTAzLjU1MSwzMjkuMDc2IDUwMy44NDEsMzIwLjQ5NyA1MDMuODQxLDI1Mi4wOCBDNTAzLjg0MSwxODMuNjYyIDUwMy41NTEsMTc1LjA4MyA1MDIuMzI1LDE0OC4yMTMgQzUwMS4xMDIsMTIxLjM5OSA0OTYuODQzLDEwMy4wODYgNDkwLjYxNiw4Ny4wNjIgQzQ4NC4xNzgsNzAuNDk2IDQ3NS41NjQsNTYuNDQ3IDQ2MS41NTksNDIuNDQxIEM0NDcuNTUzLDI4LjQzNiA0MzMuNTA0LDE5LjgyMiA0MTYuOTM4LDEzLjM4NSBDNDAwLjkxNCw3LjE1NyAzODIuNjAxLDIuODk4IDM1NS43ODcsMS42NzUgQzMyOC45MTcsMC40NDkgMzIwLjMzOCwwLjE1OSAyNTEuOTIxLDAuMTU5IFogTTI1MS45MjEsNDUuNTUgQzMxOS4xODYsNDUuNTUgMzI3LjE1NCw0NS44MDcgMzUzLjcxOCw0Ny4wMTkgQzM3OC4yOCw0OC4xMzkgMzkxLjYxOSw1Mi4yNDMgNDAwLjQ5Niw1NS42OTMgQzQxMi4yNTUsNjAuMjYzIDQyMC42NDcsNjUuNzIyIDQyOS40NjIsNzQuNTM4IEM0MzguMjc4LDgzLjM1MyA0NDMuNzM3LDkxLjc0NSA0NDguMzA3LDEwMy41MDQgQzQ1MS43NTcsMTEyLjM4MSA0NTUuODYxLDEyNS43MiA0NTYuOTgxLDE1MC4yODIgQzQ1OC4xOTMsMTc2Ljg0NiA0NTguNDUsMTg0LjgxNCA0NTguNDUsMjUyLjA4IEM0NTguNDUsMzE5LjM0NSA0NTguMTkzLDMyNy4zMTMgNDU2Ljk4MSwzNTMuODc3IEM0NTUuODYxLDM3OC40MzkgNDUxLjc1NywzOTEuNzc4IDQ0OC4zMDcsNDAwLjY1NSBDNDQzLjczNyw0MTIuNDE0IDQzOC4yNzgsNDIwLjgwNiA0MjkuNDYyLDQyOS42MjEgQzQyMC42NDcsNDM4LjQzNyA0MTIuMjU1LDQ0My44OTYgNDAwLjQ5Niw0NDguNDY2IEMzOTEuNjE5LDQ1MS45MTYgMzc4LjI4LDQ1Ni4wMiAzNTMuNzE4LDQ1Ny4xNCBDMzI3LjE1OCw0NTguMzUyIDMxOS4xOTEsNDU4LjYwOSAyNTEuOTIxLDQ1OC42MDkgQzE4NC42NSw0NTguNjA5IDE3Ni42ODQsNDU4LjM1MiAxNTAuMTIzLDQ1Ny4xNCBDMTI1LjU2MSw0NTYuMDIgMTEyLjIyMiw0NTEuOTE2IDEwMy4zNDUsNDQ4LjQ2NiBDOTEuNTg2LDQ0My44OTYgODMuMTk0LDQzOC40MzcgNzQuMzc5LDQyOS42MjEgQzY1LjU2NCw0MjAuODA2IDYwLjEwNCw0MTIuNDE0IDU1LjUzNCw0MDAuNjU1IEM1Mi4wODQsMzkxLjc3OCA0Ny45OCwzNzguNDM5IDQ2Ljg2LDM1My44NzcgQzQ1LjY0OCwzMjcuMzEzIDQ1LjM5MSwzMTkuMzQ1IDQ1LjM5MSwyNTIuMDggQzQ1LjM5MSwxODQuODE0IDQ1LjY0OCwxNzYuODQ2IDQ2Ljg2LDE1MC4yODIgQzQ3Ljk4LDEyNS43MiA1Mi4wODQsMTEyLjM4MSA1NS41MzQsMTAzLjUwNCBDNjAuMTA0LDkxLjc0NSA2NS41NjMsODMuMzUzIDc0LjM3OSw3NC41MzggQzgzLjE5NCw2NS43MjIgOTEuNTg2LDYwLjI2MyAxMDMuMzQ1LDU1LjY5MyBDMTEyLjIyMiw1Mi4yNDMgMTI1LjU2MSw0OC4xMzkgMTUwLjEyMyw0Ny4wMTkgQzE3Ni42ODcsNDUuODA3IDE4NC42NTUsNDUuNTUgMjUxLjkyMSw0NS41NSBaIiBpZD0iRmlsbC0xIiBmaWxsPSIjRkZGRkZGIiBtYXNrPSJ1cmwoI21hc2stMikiPjwvcGF0aD4gICAgICAgIDwvZz4gICAgICAgIDxwYXRoIGQ9Ik0yNTEuOTIxLDMzNi4wNTMgQzIwNS41NDMsMzM2LjA1MyAxNjcuOTQ3LDI5OC40NTcgMTY3Ljk0NywyNTIuMDggQzE2Ny45NDcsMjA1LjcwMiAyMDUuNTQzLDE2OC4xMDYgMjUxLjkyMSwxNjguMTA2IEMyOTguMjk4LDE2OC4xMDYgMzM1Ljg5NCwyMDUuNzAyIDMzNS44OTQsMjUyLjA4IEMzMzUuODk0LDI5OC40NTcgMjk4LjI5OCwzMzYuMDUzIDI1MS45MjEsMzM2LjA1MyBaIE0yNTEuOTIxLDEyMi43MTUgQzE4MC40NzQsMTIyLjcxNSAxMjIuNTU2LDE4MC42MzMgMTIyLjU1NiwyNTIuMDggQzEyMi41NTYsMzIzLjUyNiAxODAuNDc0LDM4MS40NDQgMjUxLjkyMSwzODEuNDQ0IEMzMjMuMzY3LDM4MS40NDQgMzgxLjI4NSwzMjMuNTI2IDM4MS4yODUsMjUyLjA4IEMzODEuMjg1LDE4MC42MzMgMzIzLjM2NywxMjIuNzE1IDI1MS45MjEsMTIyLjcxNSBaIiBpZD0iRmlsbC00IiBmaWxsPSIjRkZGRkZGIj48L3BhdGg+ICAgICAgICA8cGF0aCBkPSJNNDE2LjYyNywxMTcuNjA0IEM0MTYuNjI3LDEzNC4zIDQwMy4wOTIsMTQ3LjgzNCAzODYuMzk2LDE0Ny44MzQgQzM2OS43MDEsMTQ3LjgzNCAzNTYuMTY2LDEzNC4zIDM1Ni4xNjYsMTE3LjYwNCBDMzU2LjE2NiwxMDAuOTA4IDM2OS43MDEsODcuMzczIDM4Ni4zOTYsODcuMzczIEM0MDMuMDkyLDg3LjM3MyA0MTYuNjI3LDEwMC45MDggNDE2LjYyNywxMTcuNjA0IiBpZD0iRmlsbC01IiBmaWxsPSIjRkZGRkZGIj48L3BhdGg+ICAgIDwvZz48L3N2Zz4=);
		}

		/* stylelint-disable-next-line no-descending-specificity */
		& .ck-media__placeholder__url__text {
			color: hsl(302, 100%, 94%);

			&:hover {
				color: hsl(0, 0%, 100%);
			}
		}
	}

	&[data-oembed-url*="twitter.com"] .ck.ck-media__placeholder {
		/* Use gradient to contrast with focused widget (ckeditor/ckeditor5-media-embed#22). */
		background: linear-gradient( to right, hsl(201, 85%, 70%), hsl(201, 85%, 35%) );

		& .ck-media__placeholder__icon {
			background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IldoaXRlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQwMCA0MDAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQwMCA0MDA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj48c3R5bGUgdHlwZT0idGV4dC9jc3MiPi5zdDB7ZmlsbDojRkZGRkZGO308L3N0eWxlPjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik00MDAsMjAwYzAsMTEwLjUtODkuNSwyMDAtMjAwLDIwMFMwLDMxMC41LDAsMjAwUzg5LjUsMCwyMDAsMFM0MDAsODkuNSw0MDAsMjAweiBNMTYzLjQsMzA1LjVjODguNywwLDEzNy4yLTczLjUsMTM3LjItMTM3LjJjMC0yLjEsMC00LjItMC4xLTYuMmM5LjQtNi44LDE3LjYtMTUuMywyNC4xLTI1Yy04LjYsMy44LTE3LjksNi40LTI3LjcsNy42YzEwLTYsMTcuNi0xNS40LDIxLjItMjYuN2MtOS4zLDUuNS0xOS42LDkuNS0zMC42LDExLjdjLTguOC05LjQtMjEuMy0xNS4yLTM1LjItMTUuMmMtMjYuNiwwLTQ4LjIsMjEuNi00OC4yLDQ4LjJjMCwzLjgsMC40LDcuNSwxLjMsMTFjLTQwLjEtMi03NS42LTIxLjItOTkuNC01MC40Yy00LjEsNy4xLTYuNSwxNS40LTYuNSwyNC4yYzAsMTYuNyw4LjUsMzEuNSwyMS41LDQwLjFjLTcuOS0wLjItMTUuMy0yLjQtMjEuOC02YzAsMC4yLDAsMC40LDAsMC42YzAsMjMuNCwxNi42LDQyLjgsMzguNyw0Ny4zYy00LDEuMS04LjMsMS43LTEyLjcsMS43Yy0zLjEsMC02LjEtMC4zLTkuMS0wLjljNi4xLDE5LjIsMjMuOSwzMy4xLDQ1LDMzLjVjLTE2LjUsMTIuOS0zNy4zLDIwLjYtNTkuOSwyMC42Yy0zLjksMC03LjctMC4yLTExLjUtMC43QzExMC44LDI5Ny41LDEzNi4yLDMwNS41LDE2My40LDMwNS41Ii8+PC9zdmc+);
		}

		& .ck-media__placeholder__url__text {
			color: hsl(201, 100%, 86%);

			&:hover {
				color: hsl(0, 0%, 100%);
			}
		}
	}
}
`],sourceRoot:""}]);const O=P},9292:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-media-form{align-items:flex-start;display:flex;flex-direction:row;flex-wrap:nowrap}.ck.ck-media-form .ck-labeled-field-view{display:inline-block}.ck.ck-media-form .ck-label{display:none}@media screen and (max-width:600px){.ck.ck-media-form{flex-wrap:wrap}.ck.ck-media-form .ck-labeled-field-view{flex-basis:100%}.ck.ck-media-form .ck-button{flex-basis:50%}}","",{version:3,sources:["webpack://./../ckeditor5-media-embed/theme/mediaform.css","webpack://./../ckeditor5-ui/theme/mixins/_rwd.css"],names:[],mappings:"AAOA,kBAEC,sBAAuB,CADvB,YAAa,CAEb,kBAAmB,CACnB,gBAqBD,CAnBC,yCACC,oBACD,CAEA,4BACC,YACD,CCbA,oCDCD,kBAeE,cAUF,CARE,yCACC,eACD,CAEA,6BACC,cACD,CCtBD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_rwd.css";

.ck.ck-media-form {
	display: flex;
	align-items: flex-start;
	flex-direction: row;
	flex-wrap: nowrap;

	& .ck-labeled-field-view {
		display: inline-block;
	}

	& .ck-label {
		display: none;
	}

	@mixin ck-media-phone {
		flex-wrap: wrap;

		& .ck-labeled-field-view {
			flex-basis: 100%;
		}

		& .ck-button {
			flex-basis: 50%;
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@define-mixin ck-media-phone {
	@media screen and (max-width: 600px) {
		@mixin-content;
	}
}
`],sourceRoot:""}]);const O=P},1613:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck .ck-insert-table-dropdown__grid{display:flex;flex-direction:row;flex-wrap:wrap}:root{--ck-insert-table-dropdown-padding:10px;--ck-insert-table-dropdown-box-height:11px;--ck-insert-table-dropdown-box-width:12px;--ck-insert-table-dropdown-box-margin:1px}.ck .ck-insert-table-dropdown__grid{padding:var(--ck-insert-table-dropdown-padding) var(--ck-insert-table-dropdown-padding) 0;width:calc(var(--ck-insert-table-dropdown-box-width)*10 + var(--ck-insert-table-dropdown-box-margin)*20 + var(--ck-insert-table-dropdown-padding)*2)}.ck .ck-insert-table-dropdown__label,.ck[dir=rtl] .ck-insert-table-dropdown__label{text-align:center}.ck .ck-insert-table-dropdown-grid-box{border:1px solid var(--ck-color-base-border);border-radius:1px;margin:var(--ck-insert-table-dropdown-box-margin);min-height:var(--ck-insert-table-dropdown-box-height);min-width:var(--ck-insert-table-dropdown-box-width);outline:none;transition:none}.ck .ck-insert-table-dropdown-grid-box:focus{box-shadow:none}.ck .ck-insert-table-dropdown-grid-box.ck-on{background:var(--ck-color-focus-outer-shadow);border-color:var(--ck-color-focus-border)}","",{version:3,sources:["webpack://./../ckeditor5-table/theme/inserttable.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-table/inserttable.css"],names:[],mappings:"AAKA,oCACC,YAAa,CACb,kBAAmB,CACnB,cACD,CCJA,MACC,uCAAwC,CACxC,0CAA2C,CAC3C,yCAA0C,CAC1C,yCACD,CAEA,oCAGC,yFAA0F,CAD1F,oJAED,CAEA,mFAEC,iBACD,CAEA,uCAIC,4CAA6C,CAC7C,iBAAkB,CAFlB,iDAAkD,CADlD,qDAAsD,CADtD,mDAAoD,CAKpD,YAAa,CACb,eAUD,CARC,6CACC,eACD,CAEA,6CAEC,6CAA8C,CAD9C,yCAED",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck .ck-insert-table-dropdown__grid {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-insert-table-dropdown-padding: 10px;
	--ck-insert-table-dropdown-box-height: 11px;
	--ck-insert-table-dropdown-box-width: 12px;
	--ck-insert-table-dropdown-box-margin: 1px;
}

.ck .ck-insert-table-dropdown__grid {
	/* The width of a container should match 10 items in a row so there will be a 10x10 grid. */
	width: calc(var(--ck-insert-table-dropdown-box-width) * 10 + var(--ck-insert-table-dropdown-box-margin) * 20 + var(--ck-insert-table-dropdown-padding) * 2);
	padding: var(--ck-insert-table-dropdown-padding) var(--ck-insert-table-dropdown-padding) 0;
}

.ck .ck-insert-table-dropdown__label,
.ck[dir=rtl] .ck-insert-table-dropdown__label {
	text-align: center;
}

.ck .ck-insert-table-dropdown-grid-box {
	min-width: var(--ck-insert-table-dropdown-box-width);
	min-height: var(--ck-insert-table-dropdown-box-height);
	margin: var(--ck-insert-table-dropdown-box-margin);
	border: 1px solid var(--ck-color-base-border);
	border-radius: 1px;
	outline: none;
	transition: none;

	&:focus {
		box-shadow: none;
	}

	&.ck-on {
		border-color: var(--ck-color-focus-border);
		background: var(--ck-color-focus-outer-shadow);
	}
}

`],sourceRoot:""}]);const O=P},6306:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck-content .table{display:table;margin:.9em auto}.ck-content .table table{border:1px double #b3b3b3;border-collapse:collapse;border-spacing:0;height:100%;width:100%}.ck-content .table table td,.ck-content .table table th{border:1px solid #bfbfbf;min-width:2em;padding:.4em}.ck-content .table table th{background:rgba(0,0,0,.05);font-weight:700}.ck-content[dir=rtl] .table th{text-align:right}.ck-content[dir=ltr] .table th{text-align:left}.ck-editor__editable .ck-table-bogus-paragraph{display:inline-block;width:100%}","",{version:3,sources:["webpack://./../ckeditor5-table/theme/table.css"],names:[],mappings:"AAKA,mBAKC,aAAc,CADd,gBAiCD,CA9BC,yBAYC,yBAAkC,CAVlC,wBAAyB,CACzB,gBAAiB,CAKjB,WAAY,CADZ,UAsBD,CAfC,wDAQC,wBAAiC,CANjC,aAAc,CACd,YAMD,CAEA,4BAEC,0BAA+B,CAD/B,eAED,CAMF,+BACC,gBACD,CAEA,+BACC,eACD,CAEA,+CAKC,oBAAqB,CAMrB,UACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck-content .table {
	/* Give the table widget some air and center it horizontally */
	/* The first value should be equal to --ck-spacing-large variable if used in the editor context
	to avoid the content jumping (See https://github.com/ckeditor/ckeditor5/issues/9825). */
	margin: 0.9em auto;
	display: table;

	& table {
		/* The table cells should have slight borders */
		border-collapse: collapse;
		border-spacing: 0;

		/* Table width and height are set on the parent <figure>. Make sure the table inside stretches
		to the full dimensions of the container (https://github.com/ckeditor/ckeditor5/issues/6186). */
		width: 100%;
		height: 100%;

		/* The outer border of the table should be slightly darker than the inner lines.
		Also see https://github.com/ckeditor/ckeditor5-table/issues/50. */
		border: 1px double hsl(0, 0%, 70%);

		& td,
		& th {
			min-width: 2em;
			padding: .4em;

			/* The border is inherited from .ck-editor__nested-editable styles, so theoretically it's not necessary here.
			However, the border is a content style, so it should use .ck-content (so it works outside the editor).
			Hence, the duplication. See https://github.com/ckeditor/ckeditor5/issues/6314 */
			border: 1px solid hsl(0, 0%, 75%);
		}

		& th {
			font-weight: bold;
			background: hsla(0, 0%, 0%, 5%);
		}
	}
}

/* Text alignment of the table header should match the editor settings and override the native browser styling,
when content is available outside the editor. See https://github.com/ckeditor/ckeditor5/issues/6638 */
.ck-content[dir="rtl"] .table th {
	text-align: right;
}

.ck-content[dir="ltr"] .table th {
	text-align: left;
}

.ck-editor__editable .ck-table-bogus-paragraph {
	/*
	 * Use display:inline-block to force Chrome/Safari to limit text mutations to this element.
	 * See https://github.com/ckeditor/ckeditor5/issues/6062.
	 */
	display: inline-block;

	/*
	 * Inline HTML elements nested in the span should always be dimensioned in relation to the whole cell width.
	 * See https://github.com/ckeditor/ckeditor5/issues/9117.
	 */
	width: 100%;
}
`],sourceRoot:""}]);const O=P},3881:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,":root{--ck-color-table-focused-cell-background:rgba(158,201,250,.3)}.ck-widget.table td.ck-editor__nested-editable.ck-editor__nested-editable_focused,.ck-widget.table td.ck-editor__nested-editable:focus,.ck-widget.table th.ck-editor__nested-editable.ck-editor__nested-editable_focused,.ck-widget.table th.ck-editor__nested-editable:focus{background:var(--ck-color-table-focused-cell-background);border-style:none;outline:1px solid var(--ck-color-focus-border);outline-offset:-1px}","",{version:3,sources:["webpack://./../ckeditor5-theme-lark/theme/ckeditor5-table/tableediting.css"],names:[],mappings:"AAKA,MACC,6DACD,CAKE,8QAGC,wDAAyD,CAKzD,iBAAkB,CAClB,8CAA+C,CAC/C,mBACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-color-table-focused-cell-background: hsla(212, 90%, 80%, .3);
}

.ck-widget.table {
	& td,
	& th {
		&.ck-editor__nested-editable.ck-editor__nested-editable_focused,
		&.ck-editor__nested-editable:focus {
			/* A very slight background to highlight the focused cell */
			background: var(--ck-color-table-focused-cell-background);

			/* Fixes the problem where surrounding cells cover the focused cell's border.
			It does not fix the problem in all places but the UX is improved.
			See https://github.com/ckeditor/ckeditor5-table/issues/29. */
			border-style: none;
			outline: 1px solid var(--ck-color-focus-border);
			outline-offset: -1px; /* progressive enhancement - no IE support */
		}
	}
}
`],sourceRoot:""}]);const O=P},6945:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,':root{--ck-table-selected-cell-background:rgba(158,207,250,.3)}.ck.ck-editor__editable .table table td.ck-editor__editable_selected,.ck.ck-editor__editable .table table th.ck-editor__editable_selected{box-shadow:unset;caret-color:transparent;outline:unset;position:relative}.ck.ck-editor__editable .table table td.ck-editor__editable_selected:after,.ck.ck-editor__editable .table table th.ck-editor__editable_selected:after{background-color:var(--ck-table-selected-cell-background);bottom:0;content:"";left:0;pointer-events:none;position:absolute;right:0;top:0}.ck.ck-editor__editable .table table td.ck-editor__editable_selected ::selection,.ck.ck-editor__editable .table table td.ck-editor__editable_selected:focus,.ck.ck-editor__editable .table table th.ck-editor__editable_selected ::selection,.ck.ck-editor__editable .table table th.ck-editor__editable_selected:focus{background-color:transparent}.ck.ck-editor__editable .table table td.ck-editor__editable_selected .ck-widget,.ck.ck-editor__editable .table table th.ck-editor__editable_selected .ck-widget{outline:unset}.ck.ck-editor__editable .table table td.ck-editor__editable_selected .ck-widget>.ck-widget__selection-handle,.ck.ck-editor__editable .table table th.ck-editor__editable_selected .ck-widget>.ck-widget__selection-handle{display:none}',"",{version:3,sources:["webpack://./../ckeditor5-theme-lark/theme/ckeditor5-table/tableselection.css"],names:[],mappings:"AAKA,MACC,wDACD,CAGC,0IAKC,gBAAiB,CAFjB,uBAAwB,CACxB,aAAc,CAFd,iBAiCD,CA3BC,sJAGC,yDAA0D,CAK1D,QAAS,CAPT,UAAW,CAKX,MAAO,CAJP,mBAAoB,CAEpB,iBAAkB,CAGlB,OAAQ,CAFR,KAID,CAEA,wTAEC,4BACD,CAMA,gKACC,aAKD,CAHC,0NACC,YACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-table-selected-cell-background: hsla(208, 90%, 80%, .3);
}

.ck.ck-editor__editable .table table {
	& td.ck-editor__editable_selected,
	& th.ck-editor__editable_selected {
		position: relative;
		caret-color: transparent;
		outline: unset;
		box-shadow: unset;

		/* https://github.com/ckeditor/ckeditor5/issues/6446 */
		&:after {
			content: '';
			pointer-events: none;
			background-color: var(--ck-table-selected-cell-background);
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
		}

		& ::selection,
		&:focus {
			background-color: transparent;
		}

		/*
		 * To reduce the amount of noise, all widgets in the table selection have no outline and no selection handle.
		 * See https://github.com/ckeditor/ckeditor5/issues/9491.
		 */
		& .ck-widget {
			outline: unset;

			& > .ck-widget__selection-handle {
				display: none;
			}
		}
	}
}
`],sourceRoot:""}]);const O=P},4906:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-button,a.ck.ck-button{align-items:center;display:inline-flex;justify-content:left;position:relative;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none}.ck.ck-button .ck-button__label,a.ck.ck-button .ck-button__label{display:none}.ck.ck-button.ck-button_with-text .ck-button__label,a.ck.ck-button.ck-button_with-text .ck-button__label{display:inline-block}.ck.ck-button:not(.ck-button_with-text),a.ck.ck-button:not(.ck-button_with-text){justify-content:center}.ck.ck-button,a.ck.ck-button{background:var(--ck-color-button-default-background)}.ck.ck-button:not(.ck-disabled):hover,a.ck.ck-button:not(.ck-disabled):hover{background:var(--ck-color-button-default-hover-background)}.ck.ck-button:not(.ck-disabled):active,a.ck.ck-button:not(.ck-disabled):active{background:var(--ck-color-button-default-active-background)}.ck.ck-button.ck-disabled,a.ck.ck-button.ck-disabled{background:var(--ck-color-button-default-disabled-background)}.ck.ck-button,a.ck.ck-button{border-radius:0}.ck-rounded-corners .ck.ck-button,.ck-rounded-corners a.ck.ck-button,.ck.ck-button.ck-rounded-corners,a.ck.ck-button.ck-rounded-corners{border-radius:var(--ck-border-radius)}.ck.ck-button,a.ck.ck-button{-webkit-appearance:none;border:1px solid transparent;cursor:default;font-size:inherit;line-height:1;min-height:var(--ck-ui-component-min-height);min-width:var(--ck-ui-component-min-height);padding:var(--ck-spacing-tiny);text-align:center;transition:box-shadow .2s ease-in-out,border .2s ease-in-out;vertical-align:middle;white-space:nowrap}.ck.ck-button:active,.ck.ck-button:focus,a.ck.ck-button:active,a.ck.ck-button:focus{border:var(--ck-focus-ring);box-shadow:var(--ck-focus-outer-shadow),0 0;outline:none}.ck.ck-button .ck-button__icon use,.ck.ck-button .ck-button__icon use *,a.ck.ck-button .ck-button__icon use,a.ck.ck-button .ck-button__icon use *{color:inherit}.ck.ck-button .ck-button__label,a.ck.ck-button .ck-button__label{color:inherit;cursor:inherit;font-size:inherit;font-weight:inherit;vertical-align:middle}[dir=ltr] .ck.ck-button .ck-button__label,[dir=ltr] a.ck.ck-button .ck-button__label{text-align:left}[dir=rtl] .ck.ck-button .ck-button__label,[dir=rtl] a.ck.ck-button .ck-button__label{text-align:right}.ck.ck-button .ck-button__keystroke,a.ck.ck-button .ck-button__keystroke{color:inherit}[dir=ltr] .ck.ck-button .ck-button__keystroke,[dir=ltr] a.ck.ck-button .ck-button__keystroke{margin-left:var(--ck-spacing-large)}[dir=rtl] .ck.ck-button .ck-button__keystroke,[dir=rtl] a.ck.ck-button .ck-button__keystroke{margin-right:var(--ck-spacing-large)}.ck.ck-button .ck-button__keystroke,a.ck.ck-button .ck-button__keystroke{font-weight:700;opacity:.7}.ck.ck-button.ck-disabled:active,.ck.ck-button.ck-disabled:focus,a.ck.ck-button.ck-disabled:active,a.ck.ck-button.ck-disabled:focus{box-shadow:var(--ck-focus-disabled-outer-shadow),0 0}.ck.ck-button.ck-disabled .ck-button__icon,.ck.ck-button.ck-disabled .ck-button__label,a.ck.ck-button.ck-disabled .ck-button__icon,a.ck.ck-button.ck-disabled .ck-button__label{opacity:var(--ck-disabled-opacity)}.ck.ck-button.ck-disabled .ck-button__keystroke,a.ck.ck-button.ck-disabled .ck-button__keystroke{opacity:.3}.ck.ck-button.ck-button_with-text,a.ck.ck-button.ck-button_with-text{padding:var(--ck-spacing-tiny) var(--ck-spacing-standard)}[dir=ltr] .ck.ck-button.ck-button_with-text .ck-button__icon,[dir=ltr] a.ck.ck-button.ck-button_with-text .ck-button__icon{margin-left:calc(var(--ck-spacing-small)*-1);margin-right:var(--ck-spacing-small)}[dir=rtl] .ck.ck-button.ck-button_with-text .ck-button__icon,[dir=rtl] a.ck.ck-button.ck-button_with-text .ck-button__icon{margin-left:var(--ck-spacing-small);margin-right:calc(var(--ck-spacing-small)*-1)}.ck.ck-button.ck-button_with-keystroke .ck-button__label,a.ck.ck-button.ck-button_with-keystroke .ck-button__label{flex-grow:1}.ck.ck-button.ck-on,a.ck.ck-button.ck-on{background:var(--ck-color-button-on-background)}.ck.ck-button.ck-on:not(.ck-disabled):hover,a.ck.ck-button.ck-on:not(.ck-disabled):hover{background:var(--ck-color-button-on-hover-background)}.ck.ck-button.ck-on:not(.ck-disabled):active,a.ck.ck-button.ck-on:not(.ck-disabled):active{background:var(--ck-color-button-on-active-background)}.ck.ck-button.ck-on.ck-disabled,a.ck.ck-button.ck-on.ck-disabled{background:var(--ck-color-button-on-disabled-background)}.ck.ck-button.ck-on,a.ck.ck-button.ck-on{color:var(--ck-color-button-on-color)}.ck.ck-button.ck-button-save,a.ck.ck-button.ck-button-save{color:var(--ck-color-button-save)}.ck.ck-button.ck-button-cancel,a.ck.ck-button.ck-button-cancel{color:var(--ck-color-button-cancel)}.ck.ck-button-action,a.ck.ck-button-action{background:var(--ck-color-button-action-background)}.ck.ck-button-action:not(.ck-disabled):hover,a.ck.ck-button-action:not(.ck-disabled):hover{background:var(--ck-color-button-action-hover-background)}.ck.ck-button-action:not(.ck-disabled):active,a.ck.ck-button-action:not(.ck-disabled):active{background:var(--ck-color-button-action-active-background)}.ck.ck-button-action.ck-disabled,a.ck.ck-button-action.ck-disabled{background:var(--ck-color-button-action-disabled-background)}.ck.ck-button-action,a.ck.ck-button-action{color:var(--ck-color-button-action-text)}.ck.ck-button-bold,a.ck.ck-button-bold{font-weight:700}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/button/button.css","webpack://./../ckeditor5-ui/theme/mixins/_unselectable.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/button/button.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/mixins/_button.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_focus.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_shadow.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_disabled.css"],names:[],mappings:"AAOA,6BAMC,kBAAmB,CADnB,mBAAoB,CAEpB,oBAAqB,CAHrB,iBAAkB,CCFlB,qBAAsB,CACtB,wBAAyB,CACzB,oBAAqB,CACrB,gBDkBD,CAdC,iEACC,YACD,CAGC,yGACC,oBACD,CAID,iFACC,sBACD,CEjBD,6BCAC,oDD4ID,CCzIE,6EACC,0DACD,CAEA,+EACC,2DACD,CAID,qDACC,6DACD,CDfD,6BEDC,eF6ID,CA5IA,wIEGE,qCFyIF,CA5IA,6BA6BC,uBAAwB,CANxB,4BAA6B,CAjB7B,cAAe,CAcf,iBAAkB,CAHlB,aAAc,CAJd,4CAA6C,CAD7C,2CAA4C,CAJ5C,8BAA+B,CAC/B,iBAAkB,CAiBlB,4DAA8D,CAnB9D,qBAAsB,CAFtB,kBAuID,CA7GC,oFGhCA,2BAA2B,CCF3B,2CAA8B,CDC9B,YHqCA,CAIC,kJAEC,aACD,CAGD,iEAIC,aAAc,CACd,cAAe,CAHf,iBAAkB,CAClB,mBAAoB,CAMpB,qBASD,CAlBA,qFAYE,eAMF,CAlBA,qFAgBE,gBAEF,CAEA,yEACC,aAYD,CAbA,6FAIE,mCASF,CAbA,6FAQE,oCAKF,CAbA,yEAWC,eAAiB,CACjB,UACD,CAIC,oIIrFD,oDJyFC,CAOA,gLKhGD,kCLkGC,CAEA,iGACC,UACD,CAGD,qEACC,yDAcD,CAXC,2HAEE,4CAA+C,CAC/C,oCAOF,CAVA,2HAQE,mCAAoC,CADpC,6CAGF,CAKA,mHACC,WACD,CAID,yCC/HA,+CDmIA,CChIC,yFACC,qDACD,CAEA,2FACC,sDACD,CAID,iEACC,wDACD,CDgHA,yCAGC,qCACD,CAEA,2DACC,iCACD,CAEA,+DACC,mCACD,CAID,2CC/IC,mDDoJD,CCjJE,2FACC,yDACD,CAEA,6FACC,0DACD,CAID,mEACC,4DACD,CDgID,2CAIC,wCACD,CAEA,uCAEC,eACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../mixins/_unselectable.css";

.ck.ck-button,
a.ck.ck-button {
	@mixin ck-unselectable;

	position: relative;
	display: inline-flex;
	align-items: center;
	justify-content: left;

	& .ck-button__label {
		display: none;
	}

	&.ck-button_with-text {
		& .ck-button__label {
			display: inline-block;
		}
	}

	/* Center the icon horizontally in a button without text. */
	&:not(.ck-button_with-text)  {
		justify-content: center;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Makes element unselectable.
 */
@define-mixin ck-unselectable {
	-moz-user-select: none;
	-webkit-user-select: none;
	-ms-user-select: none;
	user-select: none
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_focus.css";
@import "../../../mixins/_shadow.css";
@import "../../../mixins/_disabled.css";
@import "../../../mixins/_rounded.css";
@import "../../mixins/_button.css";
@import "@ckeditor/ckeditor5-ui/theme/mixins/_dir.css";

.ck.ck-button,
a.ck.ck-button {
	@mixin ck-button-colors --ck-color-button-default;
	@mixin ck-rounded-corners;

	white-space: nowrap;
	cursor: default;
	vertical-align: middle;
	padding: var(--ck-spacing-tiny);
	text-align: center;

	/* A very important piece of styling. Go to variable declaration to learn more. */
	min-width: var(--ck-ui-component-min-height);
	min-height: var(--ck-ui-component-min-height);

	/* Normalize the height of the line. Removing this will break consistent height
	among text and text-less buttons (with icons). */
	line-height: 1;

	/* Enable font size inheritance, which allows fluid UI scaling. */
	font-size: inherit;

	/* Avoid flickering when the foucs border shows up. */
	border: 1px solid transparent;

	/* Apply some smooth transition to the box-shadow and border. */
	transition: box-shadow .2s ease-in-out, border .2s ease-in-out;

	/* https://github.com/ckeditor/ckeditor5-theme-lark/issues/189 */
	-webkit-appearance: none;

	&:active,
	&:focus {
		@mixin ck-focus-ring;
		@mixin ck-box-shadow var(--ck-focus-outer-shadow);
	}

	/* Allow icon coloring using the text "color" property. */
	& .ck-button__icon {
		& use,
		& use * {
			color: inherit;
		}
	}

	& .ck-button__label {
		/* Enable font size inheritance, which allows fluid UI scaling. */
		font-size: inherit;
		font-weight: inherit;
		color: inherit;
		cursor: inherit;

		/* Must be consistent with .ck-icon's vertical align. Otherwise, buttons with and
		without labels (but with icons) have different sizes in Chrome */
		vertical-align: middle;

		@mixin ck-dir ltr {
			text-align: left;
		}

		@mixin ck-dir rtl {
			text-align: right;
		}
	}

	& .ck-button__keystroke {
		color: inherit;

		@mixin ck-dir ltr {
			margin-left: var(--ck-spacing-large);
		}

		@mixin ck-dir rtl {
			margin-right: var(--ck-spacing-large);
		}

		font-weight: bold;
		opacity: .7;
	}

	/* https://github.com/ckeditor/ckeditor5-theme-lark/issues/70 */
	&.ck-disabled {
		&:active,
		&:focus {
			/* The disabled button should have a slightly less visible shadow when focused. */
			@mixin ck-box-shadow var(--ck-focus-disabled-outer-shadow);
		}

		& .ck-button__icon {
			@mixin ck-disabled;
		}

		/* https://github.com/ckeditor/ckeditor5-theme-lark/issues/98 */
		& .ck-button__label {
			@mixin ck-disabled;
		}

		& .ck-button__keystroke {
			opacity: .3;
		}
	}

	&.ck-button_with-text {
		padding: var(--ck-spacing-tiny) var(--ck-spacing-standard);

		/* stylelint-disable-next-line no-descending-specificity */
		& .ck-button__icon {
			@mixin ck-dir ltr {
				margin-left: calc(-1 * var(--ck-spacing-small));
				margin-right: var(--ck-spacing-small);
			}

			@mixin ck-dir rtl {
				margin-right: calc(-1 * var(--ck-spacing-small));
				margin-left: var(--ck-spacing-small);
			}
		}
	}

	&.ck-button_with-keystroke {
		/* stylelint-disable-next-line no-descending-specificity */
		& .ck-button__label {
			flex-grow: 1;
		}
	}

	/* A style of the button which is currently on, e.g. its feature is active. */
	&.ck-on {
		@mixin ck-button-colors --ck-color-button-on;

		color: var(--ck-color-button-on-color);
	}

	&.ck-button-save {
		color: var(--ck-color-button-save);
	}

	&.ck-button-cancel {
		color: var(--ck-color-button-cancel);
	}
}

/* A style of the button which handles the primary action. */
.ck.ck-button-action,
a.ck.ck-button-action {
	@mixin ck-button-colors --ck-color-button-action;

	color: var(--ck-color-button-action-text);
}

.ck.ck-button-bold,
a.ck.ck-button-bold {
	font-weight: bold;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements a button of given background color.
 *
 * @param {String} $background - Background color of the button.
 * @param {String} $border - Border color of the button.
 */
@define-mixin ck-button-colors $prefix {
	background: var($(prefix)-background);

	&:not(.ck-disabled) {
		&:hover {
			background: var($(prefix)-hover-background);
		}

		&:active {
			background: var($(prefix)-active-background);
		}
	}

	/* https://github.com/ckeditor/ckeditor5-theme-lark/issues/98 */
	&.ck-disabled {
		background: var($(prefix)-disabled-background);
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A visual style of focused element's border.
 */
@define-mixin ck-focus-ring {
	/* Disable native outline. */
	outline: none;
	border: var(--ck-focus-ring)
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A helper to combine multiple shadows.
 */
@define-mixin ck-box-shadow $shadowA, $shadowB: 0 0 {
	box-shadow: $shadowA, $shadowB;
}

/**
 * Gives an element a drop shadow so it looks like a floating panel.
 */
@define-mixin ck-drop-shadow {
	@mixin ck-box-shadow var(--ck-drop-shadow);
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A class which indicates that an element holding it is disabled.
 */
@define-mixin ck-disabled {
	opacity: var(--ck-disabled-opacity);
}
`],sourceRoot:""}]);const O=P},5332:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-button.ck-switchbutton .ck-button__toggle,.ck.ck-button.ck-switchbutton .ck-button__toggle .ck-button__toggle__inner{display:block}:root{--ck-switch-button-toggle-width:2.6153846154em;--ck-switch-button-toggle-inner-size:calc(1.07692em + 1px);--ck-switch-button-translation:calc(var(--ck-switch-button-toggle-width) - var(--ck-switch-button-toggle-inner-size) - 2px);--ck-switch-button-inner-hover-shadow:0 0 0 5px var(--ck-color-switch-button-inner-shadow)}.ck.ck-button.ck-switchbutton,.ck.ck-button.ck-switchbutton.ck-on:active,.ck.ck-button.ck-switchbutton.ck-on:focus,.ck.ck-button.ck-switchbutton.ck-on:hover,.ck.ck-button.ck-switchbutton:active,.ck.ck-button.ck-switchbutton:focus,.ck.ck-button.ck-switchbutton:hover{background:transparent;color:inherit}[dir=ltr] .ck.ck-button.ck-switchbutton .ck-button__label{margin-right:calc(var(--ck-spacing-large)*2)}[dir=rtl] .ck.ck-button.ck-switchbutton .ck-button__label{margin-left:calc(var(--ck-spacing-large)*2)}.ck.ck-button.ck-switchbutton .ck-button__toggle{border-radius:0}.ck-rounded-corners .ck.ck-button.ck-switchbutton .ck-button__toggle,.ck.ck-button.ck-switchbutton .ck-button__toggle.ck-rounded-corners{border-radius:var(--ck-border-radius)}[dir=ltr] .ck.ck-button.ck-switchbutton .ck-button__toggle{margin-left:auto}[dir=rtl] .ck.ck-button.ck-switchbutton .ck-button__toggle{margin-right:auto}.ck.ck-button.ck-switchbutton .ck-button__toggle{background:var(--ck-color-switch-button-off-background);border:1px solid transparent;transition:background .4s ease,box-shadow .2s ease-in-out,outline .2s ease-in-out;width:var(--ck-switch-button-toggle-width)}.ck.ck-button.ck-switchbutton .ck-button__toggle .ck-button__toggle__inner{border-radius:0}.ck-rounded-corners .ck.ck-button.ck-switchbutton .ck-button__toggle .ck-button__toggle__inner,.ck.ck-button.ck-switchbutton .ck-button__toggle .ck-button__toggle__inner.ck-rounded-corners{border-radius:var(--ck-border-radius);border-radius:calc(var(--ck-border-radius)*.5)}.ck.ck-button.ck-switchbutton .ck-button__toggle .ck-button__toggle__inner{background:var(--ck-color-switch-button-inner-background);height:var(--ck-switch-button-toggle-inner-size);transition:all .3s ease;width:var(--ck-switch-button-toggle-inner-size)}.ck.ck-button.ck-switchbutton .ck-button__toggle:hover{background:var(--ck-color-switch-button-off-hover-background)}.ck.ck-button.ck-switchbutton .ck-button__toggle:hover .ck-button__toggle__inner{box-shadow:var(--ck-switch-button-inner-hover-shadow)}.ck.ck-button.ck-switchbutton.ck-disabled .ck-button__toggle{opacity:var(--ck-disabled-opacity)}.ck.ck-button.ck-switchbutton:focus{border-color:transparent;box-shadow:none;outline:none}.ck.ck-button.ck-switchbutton:focus .ck-button__toggle{box-shadow:0 0 0 1px var(--ck-color-base-background),0 0 0 5px var(--ck-color-focus-outer-shadow);outline:var(--ck-focus-ring);outline-offset:1px}.ck.ck-button.ck-switchbutton.ck-on .ck-button__toggle{background:var(--ck-color-switch-button-on-background)}.ck.ck-button.ck-switchbutton.ck-on .ck-button__toggle:hover{background:var(--ck-color-switch-button-on-hover-background)}[dir=ltr] .ck.ck-button.ck-switchbutton.ck-on .ck-button__toggle .ck-button__toggle__inner{transform:translateX(var( --ck-switch-button-translation ))}[dir=rtl] .ck.ck-button.ck-switchbutton.ck-on .ck-button__toggle .ck-button__toggle__inner{transform:translateX(calc(var( --ck-switch-button-translation )*-1))}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/button/switchbutton.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/button/switchbutton.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_disabled.css"],names:[],mappings:"AASE,4HACC,aACD,CCCF,MAEC,8CAA+C,CAE/C,0DAAgE,CAChE,2HAIC,CACD,0FACD,CAOC,0QAEC,sBAAuB,CADvB,aAED,CAEA,0DAGE,4CAOF,CAVA,0DAQE,2CAEF,CAEA,iDCpCA,eD4EA,CAxCA,yIChCC,qCDwED,CAxCA,2DAKE,gBAmCF,CAxCA,2DAUE,iBA8BF,CAxCA,iDAkBC,uDAAwD,CAFxD,4BAA6B,CAD7B,iFAAsF,CAEtF,0CAuBD,CApBC,2ECxDD,eDmEC,CAXA,6LCpDA,qCAAsC,CDsDpC,8CASF,CAXA,2EAOC,yDAA0D,CAD1D,gDAAiD,CAIjD,uBAA0B,CAL1B,+CAMD,CAEA,uDACC,6DAKD,CAHC,iFACC,qDACD,CAIF,6DEhFA,kCFkFA,CAGA,oCACC,wBAAyB,CAEzB,eAAgB,CADhB,YAQD,CALC,uDACC,iGAAmG,CAEnG,4BAA6B,CAD7B,kBAED,CAKA,uDACC,sDAkBD,CAhBC,6DACC,4DACD,CAEA,2FAKE,2DAMF,CAXA,2FASE,oEAEF",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-button.ck-switchbutton {
	& .ck-button__toggle {
		display: block;

		& .ck-button__toggle__inner {
			display: block;
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";
@import "../../../mixins/_disabled.css";
@import "@ckeditor/ckeditor5-ui/theme/mixins/_dir.css";

/* Note: To avoid rendering issues (aliasing) but to preserve the responsive nature
of the component, floating–point numbers have been used which, for the default font size
(see: --ck-font-size-base), will generate simple integers. */
:root {
	/* 34px at 13px font-size */
	--ck-switch-button-toggle-width: 2.6153846154em;
	/* 14px at 13px font-size */
	--ck-switch-button-toggle-inner-size: calc(1.0769230769em + 1px);
	--ck-switch-button-translation: calc(
		var(--ck-switch-button-toggle-width) -
		var(--ck-switch-button-toggle-inner-size) -
		2px /* Border */
	);
	--ck-switch-button-inner-hover-shadow: 0 0 0 5px var(--ck-color-switch-button-inner-shadow);
}

.ck.ck-button.ck-switchbutton {
	/* Unlike a regular button, the switch button text color and background should never change.
	 * Changing toggle switch (background, outline) is enough to carry the information about the
	 * state of the entire component (https://github.com/ckeditor/ckeditor5/issues/12519)
	 */
	&, &:hover, &:focus, &:active, &.ck-on:hover, &.ck-on:focus, &.ck-on:active {
		color: inherit;
		background: transparent;
	}

	& .ck-button__label {
		@mixin ck-dir ltr {
			/* Separate the label from the switch */
			margin-right: calc(2 * var(--ck-spacing-large));
		}

		@mixin ck-dir rtl {
			/* Separate the label from the switch */
			margin-left: calc(2 * var(--ck-spacing-large));
		}
	}

	& .ck-button__toggle {
		@mixin ck-rounded-corners;

		@mixin ck-dir ltr {
			/* Make sure the toggle is always to the right as far as possible. */
			margin-left: auto;
		}

		@mixin ck-dir rtl {
			/* Make sure the toggle is always to the left as far as possible. */
			margin-right: auto;
		}

		/* Apply some smooth transition to the box-shadow and border. */
		/* Gently animate the background color of the toggle switch */
		transition: background 400ms ease, box-shadow .2s ease-in-out, outline .2s ease-in-out;
		border: 1px solid transparent;
		width: var(--ck-switch-button-toggle-width);
		background: var(--ck-color-switch-button-off-background);

		& .ck-button__toggle__inner {
			@mixin ck-rounded-corners {
				border-radius: calc(.5 * var(--ck-border-radius));
			}

			width: var(--ck-switch-button-toggle-inner-size);
			height: var(--ck-switch-button-toggle-inner-size);
			background: var(--ck-color-switch-button-inner-background);

			/* Gently animate the inner part of the toggle switch */
			transition: all 300ms ease;
		}

		&:hover {
			background: var(--ck-color-switch-button-off-hover-background);

			& .ck-button__toggle__inner {
				box-shadow: var(--ck-switch-button-inner-hover-shadow);
			}
		}
	}

	&.ck-disabled .ck-button__toggle {
		@mixin ck-disabled;
	}

	/* Overriding default .ck-button:focus styles + an outline around the toogle */
	&:focus {
		border-color: transparent;
		outline: none;
		box-shadow: none;

		& .ck-button__toggle {
			box-shadow: 0 0 0 1px var(--ck-color-base-background), 0 0 0 5px var(--ck-color-focus-outer-shadow);
			outline-offset: 1px;
			outline: var(--ck-focus-ring);
		}
	}

	/* stylelint-disable-next-line no-descending-specificity */
	&.ck-on {
		& .ck-button__toggle {
			background: var(--ck-color-switch-button-on-background);

			&:hover {
				background: var(--ck-color-switch-button-on-hover-background);
			}

			& .ck-button__toggle__inner {
				/*
				* Move the toggle switch to the right. It will be animated.
				*/
				@mixin ck-dir ltr {
					transform: translateX( var( --ck-switch-button-translation ) );
				}

				@mixin ck-dir rtl {
					transform: translateX( calc( -1 * var( --ck-switch-button-translation ) ) );
				}
			}
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A class which indicates that an element holding it is disabled.
 */
@define-mixin ck-disabled {
	opacity: var(--ck-disabled-opacity);
}
`],sourceRoot:""}]);const O=P},6781:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-color-grid{display:grid}:root{--ck-color-grid-tile-size:24px;--ck-color-color-grid-check-icon:#166fd4}.ck.ck-color-grid{grid-gap:5px;padding:8px}.ck.ck-color-grid__tile{border:0;height:var(--ck-color-grid-tile-size);min-height:var(--ck-color-grid-tile-size);min-width:var(--ck-color-grid-tile-size);padding:0;transition:box-shadow .2s ease;width:var(--ck-color-grid-tile-size)}.ck.ck-color-grid__tile.ck-disabled{cursor:unset;transition:unset}.ck.ck-color-grid__tile.ck-color-table__color-tile_bordered{box-shadow:0 0 0 1px var(--ck-color-base-border)}.ck.ck-color-grid__tile .ck.ck-icon{color:var(--ck-color-color-grid-check-icon);display:none}.ck.ck-color-grid__tile.ck-on{box-shadow:inset 0 0 0 1px var(--ck-color-base-background),0 0 0 2px var(--ck-color-base-text)}.ck.ck-color-grid__tile.ck-on .ck.ck-icon{display:block}.ck.ck-color-grid__tile.ck-on,.ck.ck-color-grid__tile:focus:not(.ck-disabled),.ck.ck-color-grid__tile:hover:not(.ck-disabled){border:0}.ck.ck-color-grid__tile:focus:not(.ck-disabled),.ck.ck-color-grid__tile:hover:not(.ck-disabled){box-shadow:inset 0 0 0 1px var(--ck-color-base-background),0 0 0 2px var(--ck-color-focus-border)}.ck.ck-color-grid__label{padding:0 var(--ck-spacing-standard)}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/colorgrid/colorgrid.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/colorgrid/colorgrid.css"],names:[],mappings:"AAKA,kBACC,YACD,CCAA,MACC,8BAA+B,CAK/B,wCACD,CAEA,kBACC,YAAa,CACb,WACD,CAEA,wBAOC,QAAS,CALT,qCAAsC,CAEtC,yCAA0C,CAD1C,wCAAyC,CAEzC,SAAU,CACV,8BAA+B,CAL/B,oCAyCD,CAjCC,oCACC,YAAa,CACb,gBACD,CAEA,4DACC,gDACD,CAEA,oCAEC,2CAA4C,CAD5C,YAED,CAEA,8BACC,8FAKD,CAHC,0CACC,aACD,CAGD,8HAIC,QACD,CAEA,gGAEC,iGACD,CAGD,yBACC,oCACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-color-grid {
	display: grid;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";

:root {
	--ck-color-grid-tile-size: 24px;

	/* Not using global colors here because these may change but some colors in a pallette
	 * require special treatment. For instance, this ensures no matter what the UI text color is,
	 * the check icon will look good on the black color tile. */
	--ck-color-color-grid-check-icon: hsl(212, 81%, 46%);
}

.ck.ck-color-grid {
	grid-gap: 5px;
	padding: 8px;
}

.ck.ck-color-grid__tile {
	width: var(--ck-color-grid-tile-size);
	height: var(--ck-color-grid-tile-size);
	min-width: var(--ck-color-grid-tile-size);
	min-height: var(--ck-color-grid-tile-size);
	padding: 0;
	transition: .2s ease box-shadow;
	border: 0;

	&.ck-disabled {
		cursor: unset;
		transition: unset;
	}

	&.ck-color-table__color-tile_bordered {
		box-shadow: 0 0 0 1px var(--ck-color-base-border);
	}

	& .ck.ck-icon {
		display: none;
		color: var(--ck-color-color-grid-check-icon);
	}

	&.ck-on {
		box-shadow: inset 0 0 0 1px var(--ck-color-base-background), 0 0 0 2px var(--ck-color-base-text);

		& .ck.ck-icon {
			display: block;
		}
	}

	&.ck-on,
	&:focus:not( .ck-disabled ),
	&:hover:not( .ck-disabled ) {
		/* Disable the default .ck-button's border ring. */
		border: 0;
	}

	&:focus:not( .ck-disabled ),
	&:hover:not( .ck-disabled ) {
		box-shadow: inset 0 0 0 1px var(--ck-color-base-background), 0 0 0 2px var(--ck-color-focus-border);
	}
}

.ck.ck-color-grid__label {
	padding: 0 var(--ck-spacing-standard);
}
`],sourceRoot:""}]);const O=P},5485:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,":root{--ck-dropdown-max-width:75vw}.ck.ck-dropdown{display:inline-block;position:relative}.ck.ck-dropdown .ck-dropdown__arrow{pointer-events:none;z-index:var(--ck-z-default)}.ck.ck-dropdown .ck-button.ck-dropdown__button{width:100%}.ck.ck-dropdown .ck-dropdown__panel{display:none;max-width:var(--ck-dropdown-max-width);position:absolute;z-index:var(--ck-z-modal)}.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel-visible{display:inline-block}.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_n,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_ne,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_nme,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_nmw,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_nw{bottom:100%}.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_s,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_se,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_sme,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_smw,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_sw{bottom:auto;top:100%}.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_ne,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_se{left:0}.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_nw,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_sw{right:0}.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_n,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_s{left:50%;transform:translateX(-50%)}.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_nmw,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_smw{left:75%;transform:translateX(-75%)}.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_nme,.ck.ck-dropdown .ck-dropdown__panel.ck-dropdown__panel_sme{left:25%;transform:translateX(-25%)}.ck.ck-toolbar .ck-dropdown__panel{z-index:calc(var(--ck-z-modal) + 1)}:root{--ck-dropdown-arrow-size:calc(var(--ck-icon-size)*0.5)}.ck.ck-dropdown{font-size:inherit}.ck.ck-dropdown .ck-dropdown__arrow{width:var(--ck-dropdown-arrow-size)}[dir=ltr] .ck.ck-dropdown .ck-dropdown__arrow{margin-left:var(--ck-spacing-standard);right:var(--ck-spacing-standard)}[dir=rtl] .ck.ck-dropdown .ck-dropdown__arrow{left:var(--ck-spacing-standard);margin-right:var(--ck-spacing-small)}.ck.ck-dropdown.ck-disabled .ck-dropdown__arrow{opacity:var(--ck-disabled-opacity)}[dir=ltr] .ck.ck-dropdown .ck-button.ck-dropdown__button:not(.ck-button_with-text){padding-left:var(--ck-spacing-small)}[dir=rtl] .ck.ck-dropdown .ck-button.ck-dropdown__button:not(.ck-button_with-text){padding-right:var(--ck-spacing-small)}.ck.ck-dropdown .ck-button.ck-dropdown__button .ck-button__label{overflow:hidden;text-overflow:ellipsis;width:7em}.ck.ck-dropdown .ck-button.ck-dropdown__button.ck-disabled .ck-button__label{opacity:var(--ck-disabled-opacity)}.ck.ck-dropdown .ck-button.ck-dropdown__button.ck-on{border-bottom-left-radius:0;border-bottom-right-radius:0}.ck.ck-dropdown .ck-button.ck-dropdown__button.ck-dropdown__button_label-width_auto .ck-button__label{width:auto}.ck.ck-dropdown .ck-button.ck-dropdown__button.ck-off:active,.ck.ck-dropdown .ck-button.ck-dropdown__button.ck-on:active{box-shadow:none}.ck.ck-dropdown .ck-button.ck-dropdown__button.ck-off:active:focus,.ck.ck-dropdown .ck-button.ck-dropdown__button.ck-on:active:focus{box-shadow:var(--ck-focus-outer-shadow),0 0}.ck.ck-dropdown__panel{border-radius:0}.ck-rounded-corners .ck.ck-dropdown__panel,.ck.ck-dropdown__panel.ck-rounded-corners{border-radius:var(--ck-border-radius)}.ck.ck-dropdown__panel{background:var(--ck-color-dropdown-panel-background);border:1px solid var(--ck-color-dropdown-panel-border);bottom:0;box-shadow:var(--ck-drop-shadow),0 0;min-width:100%}.ck.ck-dropdown__panel.ck-dropdown__panel_se{border-top-left-radius:0}.ck.ck-dropdown__panel.ck-dropdown__panel_sw{border-top-right-radius:0}.ck.ck-dropdown__panel.ck-dropdown__panel_ne{border-bottom-left-radius:0}.ck.ck-dropdown__panel.ck-dropdown__panel_nw{border-bottom-right-radius:0}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/dropdown/dropdown.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/dropdown/dropdown.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_disabled.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_shadow.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css"],names:[],mappings:"AAKA,MACC,4BACD,CAEA,gBACC,oBAAqB,CACrB,iBA2ED,CAzEC,oCACC,mBAAoB,CACpB,2BACD,CAGA,+CACC,UACD,CAEA,oCACC,YAAa,CAEb,sCAAuC,CAEvC,iBAAkB,CAHlB,yBA4DD,CAvDC,+DACC,oBACD,CAEA,mSAKC,WACD,CAEA,mSAUC,WAAY,CADZ,QAED,CAEA,oHAEC,MACD,CAEA,oHAEC,OACD,CAEA,kHAGC,QAAS,CACT,0BACD,CAEA,sHAGC,QAAS,CACT,0BACD,CAEA,sHAGC,QAAS,CACT,0BACD,CAQF,mCACC,mCACD,CCpFA,MACC,sDACD,CAEA,gBAEC,iBA2ED,CAzEC,oCACC,mCACD,CAGC,8CAIC,sCAAuC,CAHvC,gCAID,CAIA,8CACC,+BAAgC,CAGhC,oCACD,CAGD,gDC/BA,kCDiCA,CAIE,mFAEC,oCACD,CAIA,mFAEC,qCACD,CAID,iEAEC,eAAgB,CAChB,sBAAuB,CAFvB,SAGD,CAGA,6EC1DD,kCD4DC,CAGA,qDACC,2BAA4B,CAC5B,4BACD,CAEA,sGACC,UACD,CAGA,yHAEC,eAKD,CAHC,qIE7EF,2CF+EE,CAKH,uBGlFC,eH8GD,CA5BA,qFG9EE,qCH0GF,CA5BA,uBAIC,oDAAqD,CACrD,sDAAuD,CACvD,QAAS,CE1FT,oCAA8B,CF6F9B,cAmBD,CAfC,6CACC,wBACD,CAEA,6CACC,yBACD,CAEA,6CACC,2BACD,CAEA,6CACC,4BACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-dropdown-max-width: 75vw;
}

.ck.ck-dropdown {
	display: inline-block;
	position: relative;

	& .ck-dropdown__arrow {
		pointer-events: none;
		z-index: var(--ck-z-default);
	}

	/* Dropdown button should span horizontally, e.g. in vertical toolbars */
	& .ck-button.ck-dropdown__button {
		width: 100%;
	}

	& .ck-dropdown__panel {
		display: none;
		z-index: var(--ck-z-modal);
		max-width: var(--ck-dropdown-max-width);

		position: absolute;

		&.ck-dropdown__panel-visible {
			display: inline-block;
		}

		&.ck-dropdown__panel_ne,
		&.ck-dropdown__panel_nw,
		&.ck-dropdown__panel_n,
		&.ck-dropdown__panel_nmw,
		&.ck-dropdown__panel_nme {
			bottom: 100%;
		}

		&.ck-dropdown__panel_se,
		&.ck-dropdown__panel_sw,
		&.ck-dropdown__panel_smw,
		&.ck-dropdown__panel_sme,
		&.ck-dropdown__panel_s {
			/*
			 * Using transform: translate3d( 0, 100%, 0 ) causes blurry dropdown on Chrome 67-78+ on non-retina displays.
			 * See https://github.com/ckeditor/ckeditor5/issues/1053.
			 */
			top: 100%;
			bottom: auto;
		}

		&.ck-dropdown__panel_ne,
		&.ck-dropdown__panel_se {
			left: 0px;
		}

		&.ck-dropdown__panel_nw,
		&.ck-dropdown__panel_sw {
			right: 0px;
		}

		&.ck-dropdown__panel_s,
		&.ck-dropdown__panel_n {
			/* Positioning panels relative to the center of the button */
			left: 50%;
			transform: translateX(-50%);
		}

		&.ck-dropdown__panel_nmw,
		&.ck-dropdown__panel_smw {
			/* Positioning panels relative to the middle-west of the button */
			left: 75%;
			transform: translateX(-75%);
		}

		&.ck-dropdown__panel_nme,
		&.ck-dropdown__panel_sme {
			/* Positioning panels relative to the middle-east of the button */
			left: 25%;
			transform: translateX(-25%);
		}
	}
}

/*
 * Toolbar dropdown panels should be always above the UI (eg. other dropdown panels) from the editor's content.
 * See https://github.com/ckeditor/ckeditor5/issues/7874
 */
.ck.ck-toolbar .ck-dropdown__panel {
	z-index: calc( var(--ck-z-modal) + 1 );
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";
@import "../../../mixins/_disabled.css";
@import "../../../mixins/_shadow.css";
@import "@ckeditor/ckeditor5-ui/theme/mixins/_dir.css";

:root {
	--ck-dropdown-arrow-size: calc(0.5 * var(--ck-icon-size));
}

.ck.ck-dropdown {
	/* Enable font size inheritance, which allows fluid UI scaling. */
	font-size: inherit;

	& .ck-dropdown__arrow {
		width: var(--ck-dropdown-arrow-size);
	}

	@mixin ck-dir ltr {
		& .ck-dropdown__arrow {
			right: var(--ck-spacing-standard);

			/* A space to accommodate the triangle. */
			margin-left: var(--ck-spacing-standard);
		}
	}

	@mixin ck-dir rtl {
		& .ck-dropdown__arrow {
			left: var(--ck-spacing-standard);

			/* A space to accommodate the triangle. */
			margin-right: var(--ck-spacing-small);
		}
	}

	&.ck-disabled .ck-dropdown__arrow {
		@mixin ck-disabled;
	}

	& .ck-button.ck-dropdown__button {
		@mixin ck-dir ltr {
			&:not(.ck-button_with-text) {
				/* Make sure dropdowns with just an icon have the right inner spacing */
				padding-left: var(--ck-spacing-small);
			}
		}

		@mixin ck-dir rtl {
			&:not(.ck-button_with-text) {
				/* Make sure dropdowns with just an icon have the right inner spacing */
				padding-right: var(--ck-spacing-small);
			}
		}

		/* #23 */
		& .ck-button__label {
			width: 7em;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		/* https://github.com/ckeditor/ckeditor5-theme-lark/issues/70 */
		&.ck-disabled .ck-button__label {
			@mixin ck-disabled;
		}

		/* https://github.com/ckeditor/ckeditor5/issues/816 */
		&.ck-on {
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0;
		}

		&.ck-dropdown__button_label-width_auto .ck-button__label {
			width: auto;
		}

		/* https://github.com/ckeditor/ckeditor5/issues/8699 */
		&.ck-off:active,
		&.ck-on:active {
			box-shadow: none;
			
			&:focus {
				@mixin ck-box-shadow var(--ck-focus-outer-shadow);
			}
		}
	}
}

.ck.ck-dropdown__panel {
	@mixin ck-rounded-corners;
	@mixin ck-drop-shadow;

	background: var(--ck-color-dropdown-panel-background);
	border: 1px solid var(--ck-color-dropdown-panel-border);
	bottom: 0;

	/* Make sure the panel is at least as wide as the drop-down's button. */
	min-width: 100%;

	/* Disabled corner border radius to be consistent with the .dropdown__button
	https://github.com/ckeditor/ckeditor5/issues/816 */
	&.ck-dropdown__panel_se {
		border-top-left-radius: 0;
	}

	&.ck-dropdown__panel_sw {
		border-top-right-radius: 0;
	}

	&.ck-dropdown__panel_ne {
		border-bottom-left-radius: 0;
	}

	&.ck-dropdown__panel_nw {
		border-bottom-right-radius: 0;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A class which indicates that an element holding it is disabled.
 */
@define-mixin ck-disabled {
	opacity: var(--ck-disabled-opacity);
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A helper to combine multiple shadows.
 */
@define-mixin ck-box-shadow $shadowA, $shadowB: 0 0 {
	box-shadow: $shadowA, $shadowB;
}

/**
 * Gives an element a drop shadow so it looks like a floating panel.
 */
@define-mixin ck-drop-shadow {
	@mixin ck-box-shadow var(--ck-drop-shadow);
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`],sourceRoot:""}]);const O=P},3949:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-dropdown .ck-dropdown__panel .ck-list{border-radius:0}.ck-rounded-corners .ck.ck-dropdown .ck-dropdown__panel .ck-list,.ck.ck-dropdown .ck-dropdown__panel .ck-list.ck-rounded-corners{border-radius:var(--ck-border-radius);border-top-left-radius:0}.ck.ck-dropdown .ck-dropdown__panel .ck-list .ck-list__item:first-child .ck-button{border-radius:0}.ck-rounded-corners .ck.ck-dropdown .ck-dropdown__panel .ck-list .ck-list__item:first-child .ck-button,.ck.ck-dropdown .ck-dropdown__panel .ck-list .ck-list__item:first-child .ck-button.ck-rounded-corners{border-radius:var(--ck-border-radius);border-bottom-left-radius:0;border-bottom-right-radius:0;border-top-left-radius:0}.ck.ck-dropdown .ck-dropdown__panel .ck-list .ck-list__item:last-child .ck-button{border-radius:0}.ck-rounded-corners .ck.ck-dropdown .ck-dropdown__panel .ck-list .ck-list__item:last-child .ck-button,.ck.ck-dropdown .ck-dropdown__panel .ck-list .ck-list__item:last-child .ck-button.ck-rounded-corners{border-radius:var(--ck-border-radius);border-top-left-radius:0;border-top-right-radius:0}","",{version:3,sources:["webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/dropdown/listdropdown.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css"],names:[],mappings:"AAOA,6CCIC,eDqBD,CAzBA,iICQE,qCAAsC,CDJtC,wBAqBF,CAfE,mFCND,eDYC,CANA,6MCFA,qCAAsC,CDKpC,2BAA4B,CAC5B,4BAA6B,CAF7B,wBAIF,CAEA,kFCdD,eDmBC,CALA,2MCVA,qCAAsC,CDYpC,wBAAyB,CACzB,yBAEF",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";

.ck.ck-dropdown .ck-dropdown__panel .ck-list {
	/* Disabled radius of top-left border to be consistent with .dropdown__button
	https://github.com/ckeditor/ckeditor5/issues/816 */
	@mixin ck-rounded-corners {
		border-top-left-radius: 0;
	}

	/* Make sure the button belonging to the first/last child of the list goes well with the
	border radius of the entire panel. */
	& .ck-list__item {
		&:first-child .ck-button {
			@mixin ck-rounded-corners {
				border-top-left-radius: 0;
				border-bottom-left-radius: 0;
				border-bottom-right-radius: 0;
			}
		}

		&:last-child .ck-button {
			@mixin ck-rounded-corners {
				border-top-left-radius: 0;
				border-top-right-radius: 0;
			}
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`],sourceRoot:""}]);const O=P},7686:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,'.ck.ck-splitbutton{font-size:inherit}.ck.ck-splitbutton .ck-splitbutton__action:focus{z-index:calc(var(--ck-z-default) + 1)}:root{--ck-color-split-button-hover-background:#ebebeb;--ck-color-split-button-hover-border:#b3b3b3}[dir=ltr] .ck.ck-splitbutton.ck-splitbutton_open>.ck-splitbutton__action,[dir=ltr] .ck.ck-splitbutton:hover>.ck-splitbutton__action{border-bottom-right-radius:unset;border-top-right-radius:unset}[dir=rtl] .ck.ck-splitbutton.ck-splitbutton_open>.ck-splitbutton__action,[dir=rtl] .ck.ck-splitbutton:hover>.ck-splitbutton__action{border-bottom-left-radius:unset;border-top-left-radius:unset}.ck.ck-splitbutton>.ck-splitbutton__arrow{min-width:unset}[dir=ltr] .ck.ck-splitbutton>.ck-splitbutton__arrow{border-bottom-left-radius:unset;border-top-left-radius:unset}[dir=rtl] .ck.ck-splitbutton>.ck-splitbutton__arrow{border-bottom-right-radius:unset;border-top-right-radius:unset}.ck.ck-splitbutton>.ck-splitbutton__arrow svg{width:var(--ck-dropdown-arrow-size)}.ck.ck-splitbutton>.ck-splitbutton__arrow:not(:focus){border-bottom-width:0;border-top-width:0}.ck.ck-splitbutton.ck-splitbutton_open>.ck-button:not(.ck-on):not(.ck-disabled):not(:hover),.ck.ck-splitbutton:hover>.ck-button:not(.ck-on):not(.ck-disabled):not(:hover){background:var(--ck-color-split-button-hover-background)}.ck.ck-splitbutton.ck-splitbutton_open>.ck-splitbutton__arrow:not(.ck-disabled):after,.ck.ck-splitbutton:hover>.ck-splitbutton__arrow:not(.ck-disabled):after{background-color:var(--ck-color-split-button-hover-border);content:"";height:100%;position:absolute;width:1px}.ck.ck-splitbutton.ck-splitbutton_open>.ck-splitbutton__arrow:focus:after,.ck.ck-splitbutton:hover>.ck-splitbutton__arrow:focus:after{--ck-color-split-button-hover-border:var(--ck-color-focus-border)}[dir=ltr] .ck.ck-splitbutton.ck-splitbutton_open>.ck-splitbutton__arrow:not(.ck-disabled):after,[dir=ltr] .ck.ck-splitbutton:hover>.ck-splitbutton__arrow:not(.ck-disabled):after{left:-1px}[dir=rtl] .ck.ck-splitbutton.ck-splitbutton_open>.ck-splitbutton__arrow:not(.ck-disabled):after,[dir=rtl] .ck.ck-splitbutton:hover>.ck-splitbutton__arrow:not(.ck-disabled):after{right:-1px}.ck.ck-splitbutton.ck-splitbutton_open{border-radius:0}.ck-rounded-corners .ck.ck-splitbutton.ck-splitbutton_open,.ck.ck-splitbutton.ck-splitbutton_open.ck-rounded-corners{border-radius:var(--ck-border-radius)}.ck-rounded-corners .ck.ck-splitbutton.ck-splitbutton_open>.ck-splitbutton__action,.ck.ck-splitbutton.ck-splitbutton_open.ck-rounded-corners>.ck-splitbutton__action{border-bottom-left-radius:0}.ck-rounded-corners .ck.ck-splitbutton.ck-splitbutton_open>.ck-splitbutton__arrow,.ck.ck-splitbutton.ck-splitbutton_open.ck-rounded-corners>.ck-splitbutton__arrow{border-bottom-right-radius:0}',"",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/dropdown/splitbutton.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/dropdown/splitbutton.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css"],names:[],mappings:"AAKA,mBAEC,iBAKD,CAHC,iDACC,qCACD,CCJD,MACC,gDAAyD,CACzD,4CACD,CAMC,oIAKE,gCAAiC,CADjC,6BASF,CAbA,oIAWE,+BAAgC,CADhC,4BAGF,CAEA,0CAGC,eAiBD,CApBA,oDAQE,+BAAgC,CADhC,4BAaF,CApBA,oDAcE,gCAAiC,CADjC,6BAOF,CAHC,8CACC,mCACD,CAKD,sDAEC,qBAAwB,CADxB,kBAED,CAQC,0KACC,wDACD,CAIA,8JAKC,0DAA2D,CAJ3D,UAAW,CAGX,WAAY,CAFZ,iBAAkB,CAClB,SAGD,CAGA,sIACC,iEACD,CAGC,kLACC,SACD,CAIA,kLACC,UACD,CAMF,uCCzFA,eDmGA,CAVA,qHCrFC,qCD+FD,CARE,qKACC,2BACD,CAEA,mKACC,4BACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-splitbutton {
	/* Enable font size inheritance, which allows fluid UI scaling. */
	font-size: inherit;

	& .ck-splitbutton__action:focus {
		z-index: calc(var(--ck-z-default) + 1);
	}
}

`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";

:root {
	--ck-color-split-button-hover-background: hsl(0, 0%, 92%);
	--ck-color-split-button-hover-border: hsl(0, 0%, 70%);
}

.ck.ck-splitbutton {
	/*
	 * Note: ck-rounded and ck-dir mixins don't go together (because they both use @nest).
	 */
	&:hover > .ck-splitbutton__action,
	&.ck-splitbutton_open > .ck-splitbutton__action {
		@nest [dir="ltr"] & {
			/* Don't round the action button on the right side */
			border-top-right-radius: unset;
			border-bottom-right-radius: unset;
		}

		@nest [dir="rtl"] & {
			/* Don't round the action button on the left side */
			border-top-left-radius: unset;
			border-bottom-left-radius: unset;
		}
	}

	& > .ck-splitbutton__arrow {
		/* It's a text-less button and since the icon is positioned absolutely in such situation,
		it must get some arbitrary min-width. */
		min-width: unset;

		@nest [dir="ltr"] & {
			/* Don't round the arrow button on the left side */
			border-top-left-radius: unset;
			border-bottom-left-radius: unset;
		}

		@nest [dir="rtl"] & {
			/* Don't round the arrow button on the right side */
			border-top-right-radius: unset;
			border-bottom-right-radius: unset;
		}

		& svg {
			width: var(--ck-dropdown-arrow-size);
		}
	}

	/* Make sure the divider stretches 100% height of the button
	https://github.com/ckeditor/ckeditor5/issues/10936 */
	& > .ck-splitbutton__arrow:not(:focus) {
		border-top-width: 0px;
		border-bottom-width: 0px;
	}

	/* When the split button is "open" (the arrow is on) or being hovered, it should get some styling
	as a whole. The background of both buttons should stand out and there should be a visual
	separation between both buttons. */
	&.ck-splitbutton_open,
	&:hover {
		/* When the split button hovered as a whole, not as individual buttons. */
		& > .ck-button:not(.ck-on):not(.ck-disabled):not(:hover) {
			background: var(--ck-color-split-button-hover-background);
		}

		/* Splitbutton separator needs to be set with the ::after pseudoselector
		to display properly the borders on focus */
		& > .ck-splitbutton__arrow:not(.ck-disabled)::after {
			content: '';
			position: absolute;
			width: 1px;
			height: 100%;
			background-color: var(--ck-color-split-button-hover-border);
		}

		/* Make sure the divider between the buttons looks fine when the button is focused */
		& > .ck-splitbutton__arrow:focus::after {
			--ck-color-split-button-hover-border: var(--ck-color-focus-border);
		}

		@nest [dir="ltr"] & {
			& > .ck-splitbutton__arrow:not(.ck-disabled)::after {
				left: -1px;
			}
		}

		@nest [dir="rtl"] & {
			& > .ck-splitbutton__arrow:not(.ck-disabled)::after {
				right: -1px;
			}
		}
	}

	/* Don't round the bottom left and right corners of the buttons when "open"
	https://github.com/ckeditor/ckeditor5/issues/816 */
	&.ck-splitbutton_open {
		@mixin ck-rounded-corners {
			& > .ck-splitbutton__action {
				border-bottom-left-radius: 0;
			}

			& > .ck-splitbutton__arrow {
				border-bottom-right-radius: 0;
			}
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`],sourceRoot:""}]);const O=P},7339:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,":root{--ck-toolbar-dropdown-max-width:60vw}.ck.ck-toolbar-dropdown>.ck-dropdown__panel{max-width:var(--ck-toolbar-dropdown-max-width);width:max-content}.ck.ck-toolbar-dropdown>.ck-dropdown__panel .ck-button:focus{z-index:calc(var(--ck-z-default) + 1)}.ck.ck-toolbar-dropdown .ck-toolbar{border:0}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/dropdown/toolbardropdown.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/dropdown/toolbardropdown.css"],names:[],mappings:"AAKA,MACC,oCACD,CAEA,4CAGC,8CAA+C,CAD/C,iBAQD,CAJE,6DACC,qCACD,CCZF,oCACC,QACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-toolbar-dropdown-max-width: 60vw;
}

.ck.ck-toolbar-dropdown > .ck-dropdown__panel {
	/* https://github.com/ckeditor/ckeditor5/issues/5586 */
	width: max-content;
	max-width: var(--ck-toolbar-dropdown-max-width);

	& .ck-button {
		&:focus {
			z-index: calc(var(--ck-z-default) + 1);
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-toolbar-dropdown .ck-toolbar {
	border: 0;
}
`],sourceRoot:""}]);const O=P},9688:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,":root{--ck-color-editable-blur-selection:#d9d9d9}.ck.ck-editor__editable:not(.ck-editor__nested-editable){border-radius:0}.ck-rounded-corners .ck.ck-editor__editable:not(.ck-editor__nested-editable),.ck.ck-editor__editable.ck-rounded-corners:not(.ck-editor__nested-editable){border-radius:var(--ck-border-radius)}.ck.ck-editor__editable.ck-focused:not(.ck-editor__nested-editable){border:var(--ck-focus-ring);box-shadow:var(--ck-inner-shadow),0 0;outline:none}.ck.ck-editor__editable_inline{border:1px solid transparent;overflow:auto;padding:0 var(--ck-spacing-standard)}.ck.ck-editor__editable_inline[dir=ltr]{text-align:left}.ck.ck-editor__editable_inline[dir=rtl]{text-align:right}.ck.ck-editor__editable_inline>:first-child{margin-top:var(--ck-spacing-large)}.ck.ck-editor__editable_inline>:last-child{margin-bottom:var(--ck-spacing-large)}.ck.ck-editor__editable_inline.ck-blurred ::selection{background:var(--ck-color-editable-blur-selection)}.ck.ck-balloon-panel.ck-toolbar-container[class*=arrow_n]:after{border-bottom-color:var(--ck-color-base-foreground)}.ck.ck-balloon-panel.ck-toolbar-container[class*=arrow_s]:after{border-top-color:var(--ck-color-base-foreground)}","",{version:3,sources:["webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/editorui/editorui.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_focus.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_shadow.css"],names:[],mappings:"AAWA,MACC,0CACD,CAEA,yDCJC,eDWD,CAPA,yJCAE,qCDOF,CAJC,oEEPA,2BAA2B,CCF3B,qCAA8B,CDC9B,YFWA,CAGD,+BAGC,4BAA6B,CAF7B,aAAc,CACd,oCA6BD,CA1BC,wCACC,eACD,CAEA,wCACC,gBACD,CAGA,4CACC,kCACD,CAGA,2CAKC,qCACD,CAGA,sDACC,kDACD,CAKA,gEACC,mDACD,CAIA,gEACC,gDACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";
@import "../../../mixins/_disabled.css";
@import "../../../mixins/_shadow.css";
@import "../../../mixins/_focus.css";
@import "../../mixins/_button.css";

:root {
	--ck-color-editable-blur-selection: hsl(0, 0%, 85%);
}

.ck.ck-editor__editable:not(.ck-editor__nested-editable) {
	@mixin ck-rounded-corners;

	&.ck-focused {
		@mixin ck-focus-ring;
		@mixin ck-box-shadow var(--ck-inner-shadow);
	}
}

.ck.ck-editor__editable_inline {
	overflow: auto;
	padding: 0 var(--ck-spacing-standard);
	border: 1px solid transparent;

	&[dir="ltr"] {
		text-align: left;
	}

	&[dir="rtl"] {
		text-align: right;
	}

	/* https://github.com/ckeditor/ckeditor5-theme-lark/issues/116 */
	& > *:first-child {
		margin-top: var(--ck-spacing-large);
	}

	/* https://github.com/ckeditor/ckeditor5/issues/847 */
	& > *:last-child {
		/*
		 * This value should match with the default margins of the block elements (like .media or .image)
		 * to avoid a content jumping when the fake selection container shows up (See https://github.com/ckeditor/ckeditor5/issues/9825).
		 */
		margin-bottom: var(--ck-spacing-large);
	}

	/* https://github.com/ckeditor/ckeditor5/issues/6517 */
	&.ck-blurred ::selection {
		background: var(--ck-color-editable-blur-selection);
	}
}

/* https://github.com/ckeditor/ckeditor5-theme-lark/issues/111 */
.ck.ck-balloon-panel.ck-toolbar-container[class*="arrow_n"] {
	&::after {
		border-bottom-color: var(--ck-color-base-foreground);
	}
}

.ck.ck-balloon-panel.ck-toolbar-container[class*="arrow_s"] {
	&::after {
		border-top-color: var(--ck-color-base-foreground);
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A visual style of focused element's border.
 */
@define-mixin ck-focus-ring {
	/* Disable native outline. */
	outline: none;
	border: var(--ck-focus-ring)
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A helper to combine multiple shadows.
 */
@define-mixin ck-box-shadow $shadowA, $shadowB: 0 0 {
	box-shadow: $shadowA, $shadowB;
}

/**
 * Gives an element a drop shadow so it looks like a floating panel.
 */
@define-mixin ck-drop-shadow {
	@mixin ck-box-shadow var(--ck-drop-shadow);
}
`],sourceRoot:""}]);const O=P},8847:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-form__header{align-items:center;display:flex;flex-direction:row;flex-wrap:nowrap;justify-content:space-between}:root{--ck-form-header-height:38px}.ck.ck-form__header{border-bottom:1px solid var(--ck-color-base-border);height:var(--ck-form-header-height);line-height:var(--ck-form-header-height);padding:var(--ck-spacing-small) var(--ck-spacing-large)}.ck.ck-form__header .ck-form__header__label{font-weight:700}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/formheader/formheader.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/formheader/formheader.css"],names:[],mappings:"AAKA,oBAIC,kBAAmB,CAHnB,YAAa,CACb,kBAAmB,CACnB,gBAAiB,CAEjB,6BACD,CCNA,MACC,4BACD,CAEA,oBAIC,mDAAoD,CAFpD,mCAAoC,CACpC,wCAAyC,CAFzC,uDAQD,CAHC,4CACC,eACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-form__header {
	display: flex;
	flex-direction: row;
	flex-wrap: nowrap;
	align-items: center;
	justify-content: space-between;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-form-header-height: 38px;
}

.ck.ck-form__header {
	padding: var(--ck-spacing-small) var(--ck-spacing-large);
	height: var(--ck-form-header-height);
	line-height: var(--ck-form-header-height);
	border-bottom: 1px solid var(--ck-color-base-border);

	& .ck-form__header__label {
		font-weight: bold;
	}
}
`],sourceRoot:""}]);const O=P},6574:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-icon{vertical-align:middle}:root{--ck-icon-size:calc(var(--ck-line-height-base)*var(--ck-font-size-normal))}.ck.ck-icon{font-size:.8333350694em;height:var(--ck-icon-size);width:var(--ck-icon-size);will-change:transform}.ck.ck-icon,.ck.ck-icon *{cursor:inherit}.ck.ck-icon.ck-icon_inherit-color,.ck.ck-icon.ck-icon_inherit-color *{color:inherit}.ck.ck-icon.ck-icon_inherit-color :not([fill]){fill:currentColor}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/icon/icon.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/icon/icon.css"],names:[],mappings:"AAKA,YACC,qBACD,CCFA,MACC,0EACD,CAEA,YAKC,uBAAwB,CAHxB,0BAA2B,CAD3B,yBAA0B,CAU1B,qBAoBD,CAlBC,0BALA,cAQA,CAMC,sEACC,aAMD,CAJC,+CAEC,iBACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-icon {
	vertical-align: middle;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-icon-size: calc(var(--ck-line-height-base) * var(--ck-font-size-normal));
}

.ck.ck-icon {
	width: var(--ck-icon-size);
	height: var(--ck-icon-size);

	/* Multiplied by the height of the line in "px" should give SVG "viewport" dimensions */
	font-size: .8333350694em;

	/* Inherit cursor style (#5). */
	cursor: inherit;

	/* This will prevent blurry icons on Firefox. See #340. */
	will-change: transform;

	& * {
		/* Inherit cursor style (#5). */
		cursor: inherit;
	}

	/* Allows dynamic coloring of an icon by inheriting its color from the parent. */
	&.ck-icon_inherit-color {
		color: inherit;

		& * {
			color: inherit;

			&:not([fill]) {
				/* Needed by FF. */
				fill: currentColor;
			}
		}
	}
}
`],sourceRoot:""}]);const O=P},4879:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,":root{--ck-input-width:18em;--ck-input-text-width:var(--ck-input-width)}.ck.ck-input{border-radius:0}.ck-rounded-corners .ck.ck-input,.ck.ck-input.ck-rounded-corners{border-radius:var(--ck-border-radius)}.ck.ck-input{background:var(--ck-color-input-background);border:1px solid var(--ck-color-input-border);min-height:var(--ck-ui-component-min-height);min-width:var(--ck-input-width);padding:var(--ck-spacing-extra-tiny) var(--ck-spacing-medium);transition:box-shadow .1s ease-in-out,border .1s ease-in-out}.ck.ck-input:focus{border:var(--ck-focus-ring);box-shadow:var(--ck-focus-outer-shadow),0 0;outline:none}.ck.ck-input[readonly]{background:var(--ck-color-input-disabled-background);border:1px solid var(--ck-color-input-disabled-border);color:var(--ck-color-input-disabled-text)}.ck.ck-input[readonly]:focus{box-shadow:var(--ck-focus-disabled-outer-shadow),0 0}.ck.ck-input.ck-error{animation:ck-input-shake .3s ease both;border-color:var(--ck-color-input-error-border)}.ck.ck-input.ck-error:focus{box-shadow:var(--ck-focus-error-outer-shadow),0 0}@keyframes ck-input-shake{20%{transform:translateX(-2px)}40%{transform:translateX(2px)}60%{transform:translateX(-1px)}80%{transform:translateX(1px)}}","",{version:3,sources:["webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/input/input.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_focus.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_shadow.css"],names:[],mappings:"AASA,MACC,qBAAsB,CAGtB,2CACD,CAEA,aCLC,eD2CD,CAtCA,iECDE,qCDuCF,CAtCA,aAGC,2CAA4C,CAC5C,6CAA8C,CAK9C,4CAA6C,CAH7C,+BAAgC,CADhC,6DAA8D,CAO9D,4DA0BD,CAxBC,mBEnBA,2BAA2B,CCF3B,2CAA8B,CDC9B,YFuBA,CAEA,uBAEC,oDAAqD,CADrD,sDAAuD,CAEvD,yCAMD,CAJC,6BG/BD,oDHkCC,CAGD,sBAEC,sCAAuC,CADvC,+CAMD,CAHC,4BGzCD,iDH2CC,CAIF,0BACC,IACC,0BACD,CAEA,IACC,yBACD,CAEA,IACC,0BACD,CAEA,IACC,yBACD,CACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";
@import "../../../mixins/_focus.css";
@import "../../../mixins/_shadow.css";

:root {
	--ck-input-width: 18em;

	/* Backward compatibility. */
	--ck-input-text-width: var(--ck-input-width);
}

.ck.ck-input {
	@mixin ck-rounded-corners;

	background: var(--ck-color-input-background);
	border: 1px solid var(--ck-color-input-border);
	padding: var(--ck-spacing-extra-tiny) var(--ck-spacing-medium);
	min-width: var(--ck-input-width);

	/* This is important to stay of the same height as surrounding buttons */
	min-height: var(--ck-ui-component-min-height);

	/* Apply some smooth transition to the box-shadow and border. */
	transition: box-shadow .1s ease-in-out, border .1s ease-in-out;

	&:focus {
		@mixin ck-focus-ring;
		@mixin ck-box-shadow var(--ck-focus-outer-shadow);
	}

	&[readonly] {
		border: 1px solid var(--ck-color-input-disabled-border);
		background: var(--ck-color-input-disabled-background);
		color: var(--ck-color-input-disabled-text);

		&:focus {
			/* The read-only input should have a slightly less visible shadow when focused. */
			@mixin ck-box-shadow var(--ck-focus-disabled-outer-shadow);
		}
	}

	&.ck-error {
		border-color: var(--ck-color-input-error-border);
		animation: ck-input-shake .3s ease both;

		&:focus {
			@mixin ck-box-shadow var(--ck-focus-error-outer-shadow);
		}
	}
}

@keyframes ck-input-shake {
	20% {
		transform: translateX(-2px);
	}

	40% {
		transform: translateX(2px);
	}

	60% {
		transform: translateX(-1px);
	}

	80% {
		transform: translateX(1px);
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A visual style of focused element's border.
 */
@define-mixin ck-focus-ring {
	/* Disable native outline. */
	outline: none;
	border: var(--ck-focus-ring)
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A helper to combine multiple shadows.
 */
@define-mixin ck-box-shadow $shadowA, $shadowB: 0 0 {
	box-shadow: $shadowA, $shadowB;
}

/**
 * Gives an element a drop shadow so it looks like a floating panel.
 */
@define-mixin ck-drop-shadow {
	@mixin ck-box-shadow var(--ck-drop-shadow);
}
`],sourceRoot:""}]);const O=P},3662:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-label{display:block}.ck.ck-voice-label{display:none}.ck.ck-label{font-weight:700}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/label/label.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/label/label.css"],names:[],mappings:"AAKA,aACC,aACD,CAEA,mBACC,YACD,CCNA,aACC,eACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-label {
	display: block;
}

.ck.ck-voice-label {
	display: none;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-label {
	font-weight: bold;
}
`],sourceRoot:""}]);const O=P},2577:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-labeled-field-view>.ck.ck-labeled-field-view__input-wrapper{display:flex;position:relative}.ck.ck-labeled-field-view .ck.ck-label{display:block;position:absolute}:root{--ck-labeled-field-view-transition:.1s cubic-bezier(0,0,0.24,0.95);--ck-labeled-field-empty-unfocused-max-width:100% - 2 * var(--ck-spacing-medium);--ck-labeled-field-label-default-position-x:var(--ck-spacing-medium);--ck-labeled-field-label-default-position-y:calc(var(--ck-font-size-base)*0.6);--ck-color-labeled-field-label-background:var(--ck-color-base-background)}.ck.ck-labeled-field-view{border-radius:0}.ck-rounded-corners .ck.ck-labeled-field-view,.ck.ck-labeled-field-view.ck-rounded-corners{border-radius:var(--ck-border-radius)}.ck.ck-labeled-field-view>.ck.ck-labeled-field-view__input-wrapper{width:100%}.ck.ck-labeled-field-view>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label{top:0}[dir=ltr] .ck.ck-labeled-field-view>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label{left:0}[dir=rtl] .ck.ck-labeled-field-view>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label{right:0}.ck.ck-labeled-field-view>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label{background:var(--ck-color-labeled-field-label-background);font-weight:400;line-height:normal;max-width:100%;overflow:hidden;padding:0 calc(var(--ck-font-size-tiny)*.5);pointer-events:none;text-overflow:ellipsis;transform:translate(var(--ck-spacing-medium),-6px) scale(.75);transform-origin:0 0;transition:transform var(--ck-labeled-field-view-transition),padding var(--ck-labeled-field-view-transition),background var(--ck-labeled-field-view-transition)}.ck.ck-labeled-field-view.ck-error .ck-input:not([readonly])+.ck.ck-label,.ck.ck-labeled-field-view.ck-error>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label{color:var(--ck-color-base-error)}.ck.ck-labeled-field-view .ck-labeled-field-view__status{font-size:var(--ck-font-size-small);margin-top:var(--ck-spacing-small);white-space:normal}.ck.ck-labeled-field-view .ck-labeled-field-view__status.ck-labeled-field-view__status_error{color:var(--ck-color-base-error)}.ck.ck-labeled-field-view.ck-disabled>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label,.ck.ck-labeled-field-view.ck-labeled-field-view_empty:not(.ck-labeled-field-view_focused)>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label{color:var(--ck-color-input-disabled-text)}[dir=ltr] .ck.ck-labeled-field-view.ck-disabled.ck-labeled-field-view_empty>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label,[dir=ltr] .ck.ck-labeled-field-view.ck-labeled-field-view_empty:not(.ck-labeled-field-view_focused):not(.ck-labeled-field-view_placeholder)>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label{transform:translate(var(--ck-labeled-field-label-default-position-x),var(--ck-labeled-field-label-default-position-y)) scale(1)}[dir=rtl] .ck.ck-labeled-field-view.ck-disabled.ck-labeled-field-view_empty>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label,[dir=rtl] .ck.ck-labeled-field-view.ck-labeled-field-view_empty:not(.ck-labeled-field-view_focused):not(.ck-labeled-field-view_placeholder)>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label{transform:translate(calc(var(--ck-labeled-field-label-default-position-x)*-1),var(--ck-labeled-field-label-default-position-y)) scale(1)}.ck.ck-labeled-field-view.ck-disabled.ck-labeled-field-view_empty>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label,.ck.ck-labeled-field-view.ck-labeled-field-view_empty:not(.ck-labeled-field-view_focused):not(.ck-labeled-field-view_placeholder)>.ck.ck-labeled-field-view__input-wrapper>.ck.ck-label{background:transparent;max-width:calc(var(--ck-labeled-field-empty-unfocused-max-width));padding:0}.ck.ck-labeled-field-view>.ck.ck-labeled-field-view__input-wrapper>.ck-dropdown>.ck.ck-button{background:transparent}.ck.ck-labeled-field-view.ck-labeled-field-view_empty>.ck.ck-labeled-field-view__input-wrapper>.ck-dropdown>.ck-button>.ck-button__label{opacity:0}.ck.ck-labeled-field-view.ck-labeled-field-view_empty:not(.ck-labeled-field-view_focused):not(.ck-labeled-field-view_placeholder)>.ck.ck-labeled-field-view__input-wrapper>.ck-dropdown+.ck-label{max-width:calc(var(--ck-labeled-field-empty-unfocused-max-width) - var(--ck-dropdown-arrow-size) - var(--ck-spacing-standard))}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/labeledfield/labeledfieldview.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/labeledfield/labeledfieldview.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css"],names:[],mappings:"AAMC,mEACC,YAAa,CACb,iBACD,CAEA,uCACC,aAAc,CACd,iBACD,CCND,MACC,kEAAsE,CACtE,gFAAiF,CACjF,oEAAqE,CACrE,8EAAiF,CACjF,yEACD,CAEA,0BCLC,eD8GD,CAzGA,2FCDE,qCD0GF,CAtGC,mEACC,UAmCD,CAjCC,gFACC,KA+BD,CAhCA,0FAIE,MA4BF,CAhCA,0FAQE,OAwBF,CAhCA,gFAiBC,yDAA0D,CAG1D,eAAmB,CADnB,kBAAoB,CAOpB,cAAe,CAFf,eAAgB,CANhB,2CAA8C,CAP9C,mBAAoB,CAYpB,sBAAuB,CARvB,6DAA+D,CAH/D,oBAAqB,CAgBrB,+JAID,CAQA,mKACC,gCACD,CAGD,yDACC,mCAAoC,CACpC,kCAAmC,CAInC,kBAKD,CAHC,6FACC,gCACD,CAID,4OAEC,yCACD,CAIA,oUAGE,+HAYF,CAfA,oUAOE,wIAQF,CAfA,gTAaC,sBAAuB,CAFvB,iEAAkE,CAGlE,SACD,CAKA,8FACC,sBACD,CAGA,yIACC,SACD,CAGA,kMACC,8HACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-labeled-field-view {
	& > .ck.ck-labeled-field-view__input-wrapper {
		display: flex;
		position: relative;
	}

	& .ck.ck-label {
		display: block;
		position: absolute;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_dir.css";
@import "../../../mixins/_rounded.css";

:root {
	--ck-labeled-field-view-transition: .1s cubic-bezier(0, 0, 0.24, 0.95);
	--ck-labeled-field-empty-unfocused-max-width: 100% - 2 * var(--ck-spacing-medium);
	--ck-labeled-field-label-default-position-x: var(--ck-spacing-medium);
	--ck-labeled-field-label-default-position-y: calc(0.6 * var(--ck-font-size-base));
	--ck-color-labeled-field-label-background: var(--ck-color-base-background);
}

.ck.ck-labeled-field-view {
	@mixin ck-rounded-corners;

	& > .ck.ck-labeled-field-view__input-wrapper {
		width: 100%;

		& > .ck.ck-label {
			top: 0px;

			@mixin ck-dir ltr {
				left: 0px;
			}

			@mixin ck-dir rtl {
				right: 0px;
			}

			pointer-events: none;
			transform-origin: 0 0;

			/* By default, display the label scaled down above the field. */
			transform: translate(var(--ck-spacing-medium), -6px) scale(.75);

			background: var(--ck-color-labeled-field-label-background);
			padding: 0 calc(.5 * var(--ck-font-size-tiny));
			line-height: initial;
			font-weight: normal;

			/* Prevent overflow when the label is longer than the input */
			text-overflow: ellipsis;
			overflow: hidden;

			max-width: 100%;

			transition:
				transform var(--ck-labeled-field-view-transition),
				padding var(--ck-labeled-field-view-transition),
				background var(--ck-labeled-field-view-transition);
		}
	}

	&.ck-error {
		& > .ck.ck-labeled-field-view__input-wrapper > .ck.ck-label {
			color: var(--ck-color-base-error);
		}

		& .ck-input:not([readonly]) + .ck.ck-label {
			color: var(--ck-color-base-error);
		}
	}

	& .ck-labeled-field-view__status {
		font-size: var(--ck-font-size-small);
		margin-top: var(--ck-spacing-small);

		/* Let the info wrap to the next line to avoid stretching the layout horizontally.
		The status could be very long. */
		white-space: normal;

		&.ck-labeled-field-view__status_error {
			color: var(--ck-color-base-error);
		}
	}

	/* Disabled fields and fields that have no focus should fade out. */
	&.ck-disabled > .ck.ck-labeled-field-view__input-wrapper > .ck.ck-label,
	&.ck-labeled-field-view_empty:not(.ck-labeled-field-view_focused) > .ck.ck-labeled-field-view__input-wrapper > .ck.ck-label {
		color: var(--ck-color-input-disabled-text);
	}

	/* Fields that are disabled or not focused and without a placeholder should have full-sized labels. */
	/* stylelint-disable-next-line no-descending-specificity */
	&.ck-disabled.ck-labeled-field-view_empty > .ck.ck-labeled-field-view__input-wrapper > .ck.ck-label,
	&.ck-labeled-field-view_empty:not(.ck-labeled-field-view_focused):not(.ck-labeled-field-view_placeholder) > .ck.ck-labeled-field-view__input-wrapper > .ck.ck-label {
		@mixin ck-dir ltr {
			transform: translate(var(--ck-labeled-field-label-default-position-x), var(--ck-labeled-field-label-default-position-y)) scale(1);
		}

		@mixin ck-dir rtl {
			transform: translate(calc(-1 * var(--ck-labeled-field-label-default-position-x)), var(--ck-labeled-field-label-default-position-y)) scale(1);
		}

		/* Compensate for the default translate position. */
		max-width: calc(var(--ck-labeled-field-empty-unfocused-max-width));

		background: transparent;
		padding: 0;
	}

	/*------ DropdownView integration ----------------------------------------------------------------------------------- */

	/* Make sure dropdown' background color in any of dropdown's state does not collide with labeled field. */
	& > .ck.ck-labeled-field-view__input-wrapper > .ck-dropdown > .ck.ck-button {
		background: transparent;
	}

	/* When the dropdown is "empty", the labeled field label replaces its label. */
	&.ck-labeled-field-view_empty > .ck.ck-labeled-field-view__input-wrapper > .ck-dropdown > .ck-button > .ck-button__label {
		opacity: 0;
	}

	/* Make sure the label of the empty, unfocused input does not cover the dropdown arrow. */
	&.ck-labeled-field-view_empty:not(.ck-labeled-field-view_focused):not(.ck-labeled-field-view_placeholder) > .ck.ck-labeled-field-view__input-wrapper > .ck-dropdown + .ck-label {
		max-width: calc(var(--ck-labeled-field-empty-unfocused-max-width) - var(--ck-dropdown-arrow-size) - var(--ck-spacing-standard));
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`],sourceRoot:""}]);const O=P},1046:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-list{display:flex;flex-direction:column;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none}.ck.ck-list .ck-list__item,.ck.ck-list .ck-list__separator{display:block}.ck.ck-list .ck-list__item>:focus{position:relative;z-index:var(--ck-z-default)}.ck.ck-list{border-radius:0}.ck-rounded-corners .ck.ck-list,.ck.ck-list.ck-rounded-corners{border-radius:var(--ck-border-radius)}.ck.ck-list{background:var(--ck-color-list-background);list-style-type:none}.ck.ck-list__item{cursor:default;min-width:12em}.ck.ck-list__item .ck-button{border-radius:0;min-height:unset;padding:calc(var(--ck-line-height-base)*.2*var(--ck-font-size-base)) calc(var(--ck-line-height-base)*.4*var(--ck-font-size-base));text-align:left;width:100%}.ck.ck-list__item .ck-button .ck-button__label{line-height:calc(var(--ck-line-height-base)*1.2*var(--ck-font-size-base))}.ck.ck-list__item .ck-button:active{box-shadow:none}.ck.ck-list__item .ck-button.ck-on{background:var(--ck-color-list-button-on-background);color:var(--ck-color-list-button-on-text)}.ck.ck-list__item .ck-button.ck-on:active{box-shadow:none}.ck.ck-list__item .ck-button.ck-on:hover:not(.ck-disabled){background:var(--ck-color-list-button-on-background-focus)}.ck.ck-list__item .ck-button.ck-on:focus:not(.ck-switchbutton):not(.ck-disabled){border-color:var(--ck-color-base-background)}.ck.ck-list__item .ck-button:hover:not(.ck-disabled){background:var(--ck-color-list-button-hover-background)}.ck.ck-list__item .ck-switchbutton.ck-on{background:var(--ck-color-list-background);color:inherit}.ck.ck-list__item .ck-switchbutton.ck-on:hover:not(.ck-disabled){background:var(--ck-color-list-button-hover-background);color:inherit}.ck.ck-list__separator{background:var(--ck-color-base-border);height:1px;width:100%}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/list/list.css","webpack://./../ckeditor5-ui/theme/mixins/_unselectable.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/list/list.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css"],names:[],mappings:"AAOA,YAGC,YAAa,CACb,qBAAsB,CCFtB,qBAAsB,CACtB,wBAAyB,CACzB,oBAAqB,CACrB,gBDaD,CAZC,2DAEC,aACD,CAKA,kCACC,iBAAkB,CAClB,2BACD,CEfD,YCEC,eDGD,CALA,+DCME,qCDDF,CALA,YAIC,0CAA2C,CAD3C,oBAED,CAEA,kBACC,cAAe,CACf,cA2DD,CAzDC,6BAIC,eAAgB,CAHhB,gBAAiB,CAQjB,iIAEiE,CARjE,eAAgB,CADhB,UAwCD,CA7BC,+CAEC,yEACD,CAEA,oCACC,eACD,CAEA,mCACC,oDAAqD,CACrD,yCAaD,CAXC,0CACC,eACD,CAEA,2DACC,0DACD,CAEA,iFACC,4CACD,CAGD,qDACC,uDACD,CAMA,yCACC,0CAA2C,CAC3C,aAMD,CAJC,iEACC,uDAAwD,CACxD,aACD,CAKH,uBAGC,sCAAuC,CAFvC,UAAW,CACX,UAED",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../mixins/_unselectable.css";

.ck.ck-list {
	@mixin ck-unselectable;

	display: flex;
	flex-direction: column;

	& .ck-list__item,
	& .ck-list__separator {
		display: block;
	}

	/* Make sure that whatever child of the list item gets focus, it remains on the
	top. Thanks to that, styles like box-shadow, outline, etc. are not masked by
	adjacent list items. */
	& .ck-list__item > *:focus {
		position: relative;
		z-index: var(--ck-z-default);
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Makes element unselectable.
 */
@define-mixin ck-unselectable {
	-moz-user-select: none;
	-webkit-user-select: none;
	-ms-user-select: none;
	user-select: none
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_disabled.css";
@import "../../../mixins/_rounded.css";
@import "../../../mixins/_shadow.css";

.ck.ck-list {
	@mixin ck-rounded-corners;

	list-style-type: none;
	background: var(--ck-color-list-background);
}

.ck.ck-list__item {
	cursor: default;
	min-width: 12em;

	& .ck-button {
		min-height: unset;
		width: 100%;
		text-align: left;
		border-radius: 0;

		/* List items should have the same height. Use absolute units to make sure it is so
		   because e.g. different heading styles may have different height
		   https://github.com/ckeditor/ckeditor5-heading/issues/63 */
		padding:
			calc(.2 * var(--ck-line-height-base) * var(--ck-font-size-base))
			calc(.4 * var(--ck-line-height-base) * var(--ck-font-size-base));

		& .ck-button__label {
			/* https://github.com/ckeditor/ckeditor5-heading/issues/63 */
			line-height: calc(1.2 * var(--ck-line-height-base) * var(--ck-font-size-base));
		}

		&:active {
			box-shadow: none;
		}

		&.ck-on {
			background: var(--ck-color-list-button-on-background);
			color: var(--ck-color-list-button-on-text);

			&:active {
				box-shadow: none;
			}

			&:hover:not(.ck-disabled) {
				background: var(--ck-color-list-button-on-background-focus);
			}

			&:focus:not(.ck-switchbutton):not(.ck-disabled) {
				border-color: var(--ck-color-base-background);
			}
		}

		&:hover:not(.ck-disabled) {
			background: var(--ck-color-list-button-hover-background);
		}
	}

	/* It's unnecessary to change the background/text of a switch toggle; it has different ways
	of conveying its state (like the switcher) */
	& .ck-switchbutton {
		&.ck-on {
			background: var(--ck-color-list-background);
			color: inherit;

			&:hover:not(.ck-disabled) {
				background: var(--ck-color-list-button-hover-background);
				color: inherit;
			}
		}
	}
}

.ck.ck-list__separator {
	height: 1px;
	width: 100%;
	background: var(--ck-color-base-border);
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`],sourceRoot:""}]);const O=P},8793:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,':root{--ck-balloon-panel-arrow-z-index:calc(var(--ck-z-default) - 3)}.ck.ck-balloon-panel{display:none;position:absolute;z-index:var(--ck-z-modal)}.ck.ck-balloon-panel.ck-balloon-panel_with-arrow:after,.ck.ck-balloon-panel.ck-balloon-panel_with-arrow:before{content:"";position:absolute}.ck.ck-balloon-panel.ck-balloon-panel_with-arrow:before{z-index:var(--ck-balloon-panel-arrow-z-index)}.ck.ck-balloon-panel.ck-balloon-panel_with-arrow:after{z-index:calc(var(--ck-balloon-panel-arrow-z-index) + 1)}.ck.ck-balloon-panel[class*=arrow_n]:before{z-index:var(--ck-balloon-panel-arrow-z-index)}.ck.ck-balloon-panel[class*=arrow_n]:after{z-index:calc(var(--ck-balloon-panel-arrow-z-index) + 1)}.ck.ck-balloon-panel[class*=arrow_s]:before{z-index:var(--ck-balloon-panel-arrow-z-index)}.ck.ck-balloon-panel[class*=arrow_s]:after{z-index:calc(var(--ck-balloon-panel-arrow-z-index) + 1)}.ck.ck-balloon-panel.ck-balloon-panel_visible{display:block}:root{--ck-balloon-border-width:1px;--ck-balloon-arrow-offset:2px;--ck-balloon-arrow-height:10px;--ck-balloon-arrow-half-width:8px;--ck-balloon-arrow-drop-shadow:0 2px 2px var(--ck-color-shadow-drop)}.ck.ck-balloon-panel{border-radius:0}.ck-rounded-corners .ck.ck-balloon-panel,.ck.ck-balloon-panel.ck-rounded-corners{border-radius:var(--ck-border-radius)}.ck.ck-balloon-panel{background:var(--ck-color-panel-background);border:var(--ck-balloon-border-width) solid var(--ck-color-panel-border);box-shadow:var(--ck-drop-shadow),0 0;min-height:15px}.ck.ck-balloon-panel.ck-balloon-panel_with-arrow:after,.ck.ck-balloon-panel.ck-balloon-panel_with-arrow:before{border-style:solid;height:0;width:0}.ck.ck-balloon-panel[class*=arrow_n]:after,.ck.ck-balloon-panel[class*=arrow_n]:before{border-width:0 var(--ck-balloon-arrow-half-width) var(--ck-balloon-arrow-height) var(--ck-balloon-arrow-half-width)}.ck.ck-balloon-panel[class*=arrow_n]:before{border-color:transparent transparent var(--ck-color-panel-border) transparent;margin-top:calc(var(--ck-balloon-border-width)*-1)}.ck.ck-balloon-panel[class*=arrow_n]:after{border-color:transparent transparent var(--ck-color-panel-background) transparent;margin-top:calc(var(--ck-balloon-arrow-offset) - var(--ck-balloon-border-width))}.ck.ck-balloon-panel[class*=arrow_s]:after,.ck.ck-balloon-panel[class*=arrow_s]:before{border-width:var(--ck-balloon-arrow-height) var(--ck-balloon-arrow-half-width) 0 var(--ck-balloon-arrow-half-width)}.ck.ck-balloon-panel[class*=arrow_s]:before{border-color:var(--ck-color-panel-border) transparent transparent;filter:drop-shadow(var(--ck-balloon-arrow-drop-shadow));margin-bottom:calc(var(--ck-balloon-border-width)*-1)}.ck.ck-balloon-panel[class*=arrow_s]:after{border-color:var(--ck-color-panel-background) transparent transparent transparent;margin-bottom:calc(var(--ck-balloon-arrow-offset) - var(--ck-balloon-border-width))}.ck.ck-balloon-panel[class*=arrow_e]:after,.ck.ck-balloon-panel[class*=arrow_e]:before{border-width:var(--ck-balloon-arrow-half-width) 0 var(--ck-balloon-arrow-half-width) var(--ck-balloon-arrow-height)}.ck.ck-balloon-panel[class*=arrow_e]:before{border-color:transparent transparent transparent var(--ck-color-panel-border);margin-right:calc(var(--ck-balloon-border-width)*-1)}.ck.ck-balloon-panel[class*=arrow_e]:after{border-color:transparent transparent transparent var(--ck-color-panel-background);margin-right:calc(var(--ck-balloon-arrow-offset) - var(--ck-balloon-border-width))}.ck.ck-balloon-panel[class*=arrow_w]:after,.ck.ck-balloon-panel[class*=arrow_w]:before{border-width:var(--ck-balloon-arrow-half-width) var(--ck-balloon-arrow-height) var(--ck-balloon-arrow-half-width) 0}.ck.ck-balloon-panel[class*=arrow_w]:before{border-color:transparent var(--ck-color-panel-border) transparent transparent;margin-left:calc(var(--ck-balloon-border-width)*-1)}.ck.ck-balloon-panel[class*=arrow_w]:after{border-color:transparent var(--ck-color-panel-background) transparent transparent;margin-left:calc(var(--ck-balloon-arrow-offset) - var(--ck-balloon-border-width))}.ck.ck-balloon-panel.ck-balloon-panel_arrow_n:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_n:before{left:50%;margin-left:calc(var(--ck-balloon-arrow-half-width)*-1);top:calc(var(--ck-balloon-arrow-height)*-1)}.ck.ck-balloon-panel.ck-balloon-panel_arrow_nw:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_nw:before{left:calc(var(--ck-balloon-arrow-half-width)*2);top:calc(var(--ck-balloon-arrow-height)*-1)}.ck.ck-balloon-panel.ck-balloon-panel_arrow_ne:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_ne:before{right:calc(var(--ck-balloon-arrow-half-width)*2);top:calc(var(--ck-balloon-arrow-height)*-1)}.ck.ck-balloon-panel.ck-balloon-panel_arrow_s:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_s:before{bottom:calc(var(--ck-balloon-arrow-height)*-1);left:50%;margin-left:calc(var(--ck-balloon-arrow-half-width)*-1)}.ck.ck-balloon-panel.ck-balloon-panel_arrow_sw:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_sw:before{bottom:calc(var(--ck-balloon-arrow-height)*-1);left:calc(var(--ck-balloon-arrow-half-width)*2)}.ck.ck-balloon-panel.ck-balloon-panel_arrow_se:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_se:before{bottom:calc(var(--ck-balloon-arrow-height)*-1);right:calc(var(--ck-balloon-arrow-half-width)*2)}.ck.ck-balloon-panel.ck-balloon-panel_arrow_sme:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_sme:before{bottom:calc(var(--ck-balloon-arrow-height)*-1);margin-right:calc(var(--ck-balloon-arrow-half-width)*2);right:25%}.ck.ck-balloon-panel.ck-balloon-panel_arrow_smw:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_smw:before{bottom:calc(var(--ck-balloon-arrow-height)*-1);left:25%;margin-left:calc(var(--ck-balloon-arrow-half-width)*2)}.ck.ck-balloon-panel.ck-balloon-panel_arrow_nme:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_nme:before{margin-right:calc(var(--ck-balloon-arrow-half-width)*2);right:25%;top:calc(var(--ck-balloon-arrow-height)*-1)}.ck.ck-balloon-panel.ck-balloon-panel_arrow_nmw:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_nmw:before{left:25%;margin-left:calc(var(--ck-balloon-arrow-half-width)*2);top:calc(var(--ck-balloon-arrow-height)*-1)}.ck.ck-balloon-panel.ck-balloon-panel_arrow_e:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_e:before{margin-top:calc(var(--ck-balloon-arrow-half-width)*-1);right:calc(var(--ck-balloon-arrow-height)*-1);top:50%}.ck.ck-balloon-panel.ck-balloon-panel_arrow_w:after,.ck.ck-balloon-panel.ck-balloon-panel_arrow_w:before{left:calc(var(--ck-balloon-arrow-height)*-1);margin-top:calc(var(--ck-balloon-arrow-half-width)*-1);top:50%}',"",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/panel/balloonpanel.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/panel/balloonpanel.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_shadow.css"],names:[],mappings:"AAKA,MAEC,8DACD,CAEA,qBACC,YAAa,CACb,iBAAkB,CAElB,yBAyCD,CAtCE,+GAEC,UAAW,CACX,iBACD,CAEA,wDACC,6CACD,CAEA,uDACC,uDACD,CAIA,4CACC,6CACD,CAEA,2CACC,uDACD,CAIA,4CACC,6CACD,CAEA,2CACC,uDACD,CAGD,8CACC,aACD,CC9CD,MACC,6BAA8B,CAC9B,6BAA8B,CAC9B,8BAA+B,CAC/B,iCAAkC,CAClC,oEACD,CAEA,qBCLC,eDmMD,CA9LA,iFCDE,qCD+LF,CA9LA,qBAMC,2CAA4C,CAC5C,wEAAyE,CEdzE,oCAA8B,CFW9B,eA0LD,CApLE,+GAIC,kBAAmB,CADnB,QAAS,CADT,OAGD,CAIA,uFAEC,mHACD,CAEA,4CACC,6EAA8E,CAC9E,kDACD,CAEA,2CACC,iFAAkF,CAClF,gFACD,CAIA,uFAEC,mHACD,CAEA,4CACC,iEAAkE,CAClE,uDAAwD,CACxD,qDACD,CAEA,2CACC,iFAAkF,CAClF,mFACD,CAIA,uFAEC,mHACD,CAEA,4CACC,6EAA8E,CAC9E,oDACD,CAEA,2CACC,iFAAkF,CAClF,kFACD,CAIA,uFAEC,mHACD,CAEA,4CACC,6EAA8E,CAC9E,mDACD,CAEA,2CACC,iFAAkF,CAClF,iFACD,CAIA,yGAEC,QAAS,CACT,uDAA0D,CAC1D,2CACD,CAIA,2GAEC,+CAAkD,CAClD,2CACD,CAIA,2GAEC,gDAAmD,CACnD,2CACD,CAIA,yGAIC,8CAAiD,CAFjD,QAAS,CACT,uDAED,CAIA,2GAGC,8CAAiD,CADjD,+CAED,CAIA,2GAGC,8CAAiD,CADjD,gDAED,CAIA,6GAIC,8CAAiD,CADjD,uDAA0D,CAD1D,SAGD,CAIA,6GAIC,8CAAiD,CAFjD,QAAS,CACT,sDAED,CAIA,6GAGC,uDAA0D,CAD1D,SAAU,CAEV,2CACD,CAIA,6GAEC,QAAS,CACT,sDAAyD,CACzD,2CACD,CAIA,yGAGC,sDAAyD,CADzD,6CAAgD,CAEhD,OACD,CAIA,yGAEC,4CAA+C,CAC/C,sDAAyD,CACzD,OACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	/* Make sure the balloon arrow does not float over its children. */
	--ck-balloon-panel-arrow-z-index: calc(var(--ck-z-default) - 3);
}

.ck.ck-balloon-panel {
	display: none;
	position: absolute;

	z-index: var(--ck-z-modal);

	&.ck-balloon-panel_with-arrow {
		&::before,
		&::after {
			content: "";
			position: absolute;
		}

		&::before {
			z-index: var(--ck-balloon-panel-arrow-z-index);
		}

		&::after {
			z-index: calc(var(--ck-balloon-panel-arrow-z-index) + 1);
		}
	}

	&[class*="arrow_n"] {
		&::before {
			z-index: var(--ck-balloon-panel-arrow-z-index);
		}

		&::after {
			z-index: calc(var(--ck-balloon-panel-arrow-z-index) + 1);
		}
	}

	&[class*="arrow_s"] {
		&::before {
			z-index: var(--ck-balloon-panel-arrow-z-index);
		}

		&::after {
			z-index: calc(var(--ck-balloon-panel-arrow-z-index) + 1);
		}
	}

	&.ck-balloon-panel_visible {
		display: block;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";
@import "../../../mixins/_shadow.css";

:root {
	--ck-balloon-border-width: 1px;
	--ck-balloon-arrow-offset: 2px;
	--ck-balloon-arrow-height: 10px;
	--ck-balloon-arrow-half-width: 8px;
	--ck-balloon-arrow-drop-shadow: 0 2px 2px var(--ck-color-shadow-drop);
}

.ck.ck-balloon-panel {
	@mixin ck-rounded-corners;
	@mixin ck-drop-shadow;

	min-height: 15px;

	background: var(--ck-color-panel-background);
	border: var(--ck-balloon-border-width) solid var(--ck-color-panel-border);

	&.ck-balloon-panel_with-arrow {
		&::before,
		&::after {
			width: 0;
			height: 0;
			border-style: solid;
		}
	}

	&[class*="arrow_n"] {
		&::before,
		&::after {
			border-width: 0 var(--ck-balloon-arrow-half-width) var(--ck-balloon-arrow-height) var(--ck-balloon-arrow-half-width);
		}

		&::before {
			border-color: transparent transparent var(--ck-color-panel-border) transparent;
			margin-top: calc( -1 * var(--ck-balloon-border-width) );
		}

		&::after {
			border-color: transparent transparent var(--ck-color-panel-background) transparent;
			margin-top: calc( var(--ck-balloon-arrow-offset) - var(--ck-balloon-border-width) );
		}
	}

	&[class*="arrow_s"] {
		&::before,
		&::after {
			border-width: var(--ck-balloon-arrow-height) var(--ck-balloon-arrow-half-width) 0 var(--ck-balloon-arrow-half-width);
		}

		&::before {
			border-color: var(--ck-color-panel-border) transparent transparent;
			filter: drop-shadow(var(--ck-balloon-arrow-drop-shadow));
			margin-bottom: calc( -1 * var(--ck-balloon-border-width) );
		}

		&::after {
			border-color: var(--ck-color-panel-background) transparent transparent transparent;
			margin-bottom: calc( var(--ck-balloon-arrow-offset) - var(--ck-balloon-border-width) );
		}
	}

	&[class*="arrow_e"] {
		&::before,
		&::after {
			border-width: var(--ck-balloon-arrow-half-width) 0 var(--ck-balloon-arrow-half-width) var(--ck-balloon-arrow-height);
		}

		&::before {
			border-color: transparent transparent transparent var(--ck-color-panel-border);
			margin-right: calc( -1 * var(--ck-balloon-border-width) );
		}

		&::after {
			border-color: transparent transparent transparent var(--ck-color-panel-background);
			margin-right: calc( var(--ck-balloon-arrow-offset) - var(--ck-balloon-border-width) );
		}
	}

	&[class*="arrow_w"] {
		&::before,
		&::after {
			border-width: var(--ck-balloon-arrow-half-width) var(--ck-balloon-arrow-height) var(--ck-balloon-arrow-half-width) 0;
		}

		&::before {
			border-color: transparent var(--ck-color-panel-border) transparent transparent;
			margin-left: calc( -1 * var(--ck-balloon-border-width) );
		}

		&::after {
			border-color: transparent var(--ck-color-panel-background) transparent transparent;
			margin-left: calc( var(--ck-balloon-arrow-offset) - var(--ck-balloon-border-width) );
		}
	}

	&.ck-balloon-panel_arrow_n {
		&::before,
		&::after {
			left: 50%;
			margin-left: calc(-1 * var(--ck-balloon-arrow-half-width));
			top: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_nw {
		&::before,
		&::after {
			left: calc(2 * var(--ck-balloon-arrow-half-width));
			top: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_ne {
		&::before,
		&::after {
			right: calc(2 * var(--ck-balloon-arrow-half-width));
			top: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_s {
		&::before,
		&::after {
			left: 50%;
			margin-left: calc(-1 * var(--ck-balloon-arrow-half-width));
			bottom: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_sw {
		&::before,
		&::after {
			left: calc(2 * var(--ck-balloon-arrow-half-width));
			bottom: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_se {
		&::before,
		&::after {
			right: calc(2 * var(--ck-balloon-arrow-half-width));
			bottom: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_sme {
		&::before,
		&::after {
			right: 25%;
			margin-right: calc(2 * var(--ck-balloon-arrow-half-width));
			bottom: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_smw {
		&::before,
		&::after {
			left: 25%;
			margin-left: calc(2 * var(--ck-balloon-arrow-half-width));
			bottom: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_nme {
		&::before,
		&::after {
			right: 25%;
			margin-right: calc(2 * var(--ck-balloon-arrow-half-width));
			top: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_nmw {
		&::before,
		&::after {
			left: 25%;
			margin-left: calc(2 * var(--ck-balloon-arrow-half-width));
			top: calc(-1 * var(--ck-balloon-arrow-height));
		}
	}

	&.ck-balloon-panel_arrow_e {
		&::before,
		&::after {
			right: calc(-1 * var(--ck-balloon-arrow-height));
			margin-top: calc(-1 * var(--ck-balloon-arrow-half-width));
			top: 50%;
		}
	}

	&.ck-balloon-panel_arrow_w {
		&::before,
		&::after {
			left: calc(-1 * var(--ck-balloon-arrow-height));
			margin-top: calc(-1 * var(--ck-balloon-arrow-half-width));
			top: 50%;
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A helper to combine multiple shadows.
 */
@define-mixin ck-box-shadow $shadowA, $shadowB: 0 0 {
	box-shadow: $shadowA, $shadowB;
}

/**
 * Gives an element a drop shadow so it looks like a floating panel.
 */
@define-mixin ck-drop-shadow {
	@mixin ck-box-shadow var(--ck-drop-shadow);
}
`],sourceRoot:""}]);const O=P},4650:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck .ck-balloon-rotator__navigation{align-items:center;display:flex;justify-content:center}.ck .ck-balloon-rotator__content .ck-toolbar{justify-content:center}.ck .ck-balloon-rotator__navigation{background:var(--ck-color-toolbar-background);border-bottom:1px solid var(--ck-color-toolbar-border);padding:0 var(--ck-spacing-small)}.ck .ck-balloon-rotator__navigation>*{margin-bottom:var(--ck-spacing-small);margin-right:var(--ck-spacing-small);margin-top:var(--ck-spacing-small)}.ck .ck-balloon-rotator__navigation .ck-balloon-rotator__counter{margin-left:var(--ck-spacing-small);margin-right:var(--ck-spacing-standard)}.ck .ck-balloon-rotator__content .ck.ck-annotation-wrapper{box-shadow:none}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/panel/balloonrotator.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/panel/balloonrotator.css"],names:[],mappings:"AAKA,oCAEC,kBAAmB,CADnB,YAAa,CAEb,sBACD,CAKA,6CACC,sBACD,CCXA,oCACC,6CAA8C,CAC9C,sDAAuD,CACvD,iCAgBD,CAbC,sCAGC,qCAAsC,CAFtC,oCAAqC,CACrC,kCAED,CAGA,iEAIC,mCAAoC,CAHpC,uCAID,CAMA,2DACC,eACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck .ck-balloon-rotator__navigation {
	display: flex;
	align-items: center;
	justify-content: center;
}

/* Buttons inside a toolbar should be centered when rotator bar is wider.
 * See: https://github.com/ckeditor/ckeditor5-ui/issues/495
 */
.ck .ck-balloon-rotator__content .ck-toolbar {
	justify-content: center;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck .ck-balloon-rotator__navigation {
	background: var(--ck-color-toolbar-background);
	border-bottom: 1px solid var(--ck-color-toolbar-border);
	padding: 0 var(--ck-spacing-small);

	/* Let's keep similar appearance to \`ck-toolbar\`. */
	& > * {
		margin-right: var(--ck-spacing-small);
		margin-top: var(--ck-spacing-small);
		margin-bottom: var(--ck-spacing-small);
	}

	/* Gives counter more breath than buttons. */
	& .ck-balloon-rotator__counter {
		margin-right: var(--ck-spacing-standard);

		/* We need to use smaller margin because of previous button's right margin. */
		margin-left: var(--ck-spacing-small);
	}
}

.ck .ck-balloon-rotator__content {

	/* Disable default annotation shadow inside rotator with fake panels. */
	& .ck.ck-annotation-wrapper {
		box-shadow: none;
	}
}
`],sourceRoot:""}]);const O=P},7676:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck .ck-fake-panel{position:absolute;z-index:calc(var(--ck-z-modal) - 1)}.ck .ck-fake-panel div{position:absolute}.ck .ck-fake-panel div:first-child{z-index:2}.ck .ck-fake-panel div:nth-child(2){z-index:1}:root{--ck-balloon-fake-panel-offset-horizontal:6px;--ck-balloon-fake-panel-offset-vertical:6px}.ck .ck-fake-panel div{background:var(--ck-color-panel-background);border:1px solid var(--ck-color-panel-border);border-radius:var(--ck-border-radius);box-shadow:var(--ck-drop-shadow),0 0;height:100%;min-height:15px;width:100%}.ck .ck-fake-panel div:first-child{margin-left:var(--ck-balloon-fake-panel-offset-horizontal);margin-top:var(--ck-balloon-fake-panel-offset-vertical)}.ck .ck-fake-panel div:nth-child(2){margin-left:calc(var(--ck-balloon-fake-panel-offset-horizontal)*2);margin-top:calc(var(--ck-balloon-fake-panel-offset-vertical)*2)}.ck .ck-fake-panel div:nth-child(3){margin-left:calc(var(--ck-balloon-fake-panel-offset-horizontal)*3);margin-top:calc(var(--ck-balloon-fake-panel-offset-vertical)*3)}.ck .ck-balloon-panel_arrow_s+.ck-fake-panel,.ck .ck-balloon-panel_arrow_se+.ck-fake-panel,.ck .ck-balloon-panel_arrow_sw+.ck-fake-panel{--ck-balloon-fake-panel-offset-vertical:-6px}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/panel/fakepanel.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/panel/fakepanel.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_shadow.css"],names:[],mappings:"AAKA,mBACC,iBAAkB,CAGlB,mCACD,CAEA,uBACC,iBACD,CAEA,mCACC,SACD,CAEA,oCACC,SACD,CCfA,MACC,6CAA8C,CAC9C,2CACD,CAGA,uBAKC,2CAA4C,CAC5C,6CAA8C,CAC9C,qCAAsC,CCXtC,oCAA8B,CDc9B,WAAY,CAPZ,eAAgB,CAMhB,UAED,CAEA,mCACC,0DAA2D,CAC3D,uDACD,CAEA,oCACC,kEAAqE,CACrE,+DACD,CACA,oCACC,kEAAqE,CACrE,+DACD,CAGA,yIAGC,4CACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck .ck-fake-panel {
	position: absolute;

	/* Fake panels should be placed under main balloon content. */
	z-index: calc(var(--ck-z-modal) - 1);
}

.ck .ck-fake-panel div {
	position: absolute;
}

.ck .ck-fake-panel div:nth-child( 1 ) {
	z-index: 2;
}

.ck .ck-fake-panel div:nth-child( 2 ) {
	z-index: 1;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_shadow.css";

:root {
	--ck-balloon-fake-panel-offset-horizontal: 6px;
	--ck-balloon-fake-panel-offset-vertical: 6px;
}

/* Let's use \`.ck-balloon-panel\` appearance. See: balloonpanel.css. */
.ck .ck-fake-panel div {
	@mixin ck-drop-shadow;

	min-height: 15px;

	background: var(--ck-color-panel-background);
	border: 1px solid var(--ck-color-panel-border);
	border-radius: var(--ck-border-radius);

	width: 100%;
	height: 100%;
}

.ck .ck-fake-panel div:nth-child( 1 ) {
	margin-left: var(--ck-balloon-fake-panel-offset-horizontal);
	margin-top: var(--ck-balloon-fake-panel-offset-vertical);
}

.ck .ck-fake-panel div:nth-child( 2 ) {
	margin-left: calc(var(--ck-balloon-fake-panel-offset-horizontal) * 2);
	margin-top: calc(var(--ck-balloon-fake-panel-offset-vertical) * 2);
}
.ck .ck-fake-panel div:nth-child( 3 ) {
	margin-left: calc(var(--ck-balloon-fake-panel-offset-horizontal) * 3);
	margin-top: calc(var(--ck-balloon-fake-panel-offset-vertical) * 3);
}

/* If balloon is positioned above element, we need to move fake panel to the top. */
.ck .ck-balloon-panel_arrow_s + .ck-fake-panel,
.ck .ck-balloon-panel_arrow_se + .ck-fake-panel,
.ck .ck-balloon-panel_arrow_sw + .ck-fake-panel {
	--ck-balloon-fake-panel-offset-vertical: -6px;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A helper to combine multiple shadows.
 */
@define-mixin ck-box-shadow $shadowA, $shadowB: 0 0 {
	box-shadow: $shadowA, $shadowB;
}

/**
 * Gives an element a drop shadow so it looks like a floating panel.
 */
@define-mixin ck-drop-shadow {
	@mixin ck-box-shadow var(--ck-drop-shadow);
}
`],sourceRoot:""}]);const O=P},5868:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-sticky-panel .ck-sticky-panel__content_sticky{position:fixed;top:0;z-index:var(--ck-z-modal)}.ck.ck-sticky-panel .ck-sticky-panel__content_sticky_bottom-limit{position:absolute;top:auto}.ck.ck-sticky-panel .ck-sticky-panel__content_sticky{border-top-left-radius:0;border-top-right-radius:0;border-width:0 1px 1px;box-shadow:var(--ck-drop-shadow),0 0}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/panel/stickypanel.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/panel/stickypanel.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_shadow.css"],names:[],mappings:"AAMC,qDAEC,cAAe,CACf,KAAM,CAFN,yBAGD,CAEA,kEAEC,iBAAkB,CADlB,QAED,CCPA,qDAIC,wBAAyB,CACzB,yBAA0B,CAF1B,sBAAuB,CCFxB,oCDKA",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-sticky-panel {
	& .ck-sticky-panel__content_sticky {
		z-index: var(--ck-z-modal); /* #315 */
		position: fixed;
		top: 0;
	}

	& .ck-sticky-panel__content_sticky_bottom-limit {
		top: auto;
		position: absolute;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_shadow.css";

.ck.ck-sticky-panel {
	& .ck-sticky-panel__content_sticky {
		@mixin ck-drop-shadow;

		border-width: 0 1px 1px;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A helper to combine multiple shadows.
 */
@define-mixin ck-box-shadow $shadowA, $shadowB: 0 0 {
	box-shadow: $shadowA, $shadowB;
}

/**
 * Gives an element a drop shadow so it looks like a floating panel.
 */
@define-mixin ck-drop-shadow {
	@mixin ck-box-shadow var(--ck-drop-shadow);
}
`],sourceRoot:""}]);const O=P},6764:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,'.ck-vertical-form .ck-button:after{bottom:-1px;content:"";position:absolute;right:-1px;top:-1px;width:0;z-index:1}.ck-vertical-form .ck-button:focus:after{display:none}@media screen and (max-width:600px){.ck.ck-responsive-form .ck-button:after{bottom:-1px;content:"";position:absolute;right:-1px;top:-1px;width:0;z-index:1}.ck.ck-responsive-form .ck-button:focus:after{display:none}}.ck-vertical-form>.ck-button:nth-last-child(2):after{border-right:1px solid var(--ck-color-base-border)}.ck.ck-responsive-form{padding:var(--ck-spacing-large)}.ck.ck-responsive-form:focus{outline:none}[dir=ltr] .ck.ck-responsive-form>:not(:first-child),[dir=rtl] .ck.ck-responsive-form>:not(:last-child){margin-left:var(--ck-spacing-standard)}@media screen and (max-width:600px){.ck.ck-responsive-form{padding:0;width:calc(var(--ck-input-width)*.8)}.ck.ck-responsive-form .ck-labeled-field-view{margin:var(--ck-spacing-large) var(--ck-spacing-large) 0}.ck.ck-responsive-form .ck-labeled-field-view .ck-input-text{min-width:0;width:100%}.ck.ck-responsive-form .ck-labeled-field-view .ck-labeled-field-view__error{white-space:normal}.ck.ck-responsive-form>.ck-button:nth-last-child(2):after{border-right:1px solid var(--ck-color-base-border)}.ck.ck-responsive-form>.ck-button:last-child,.ck.ck-responsive-form>.ck-button:nth-last-child(2){border-radius:0;margin-top:var(--ck-spacing-large);padding:var(--ck-spacing-standard)}.ck.ck-responsive-form>.ck-button:last-child:not(:focus),.ck.ck-responsive-form>.ck-button:nth-last-child(2):not(:focus){border-top:1px solid var(--ck-color-base-border)}[dir=ltr] .ck.ck-responsive-form>.ck-button:last-child,[dir=ltr] .ck.ck-responsive-form>.ck-button:nth-last-child(2),[dir=rtl] .ck.ck-responsive-form>.ck-button:last-child,[dir=rtl] .ck.ck-responsive-form>.ck-button:nth-last-child(2){margin-left:0}[dir=rtl] .ck.ck-responsive-form>.ck-button:last-child:last-of-type,[dir=rtl] .ck.ck-responsive-form>.ck-button:nth-last-child(2):last-of-type{border-right:1px solid var(--ck-color-base-border)}}',"",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/responsive-form/responsiveform.css","webpack://./../ckeditor5-ui/theme/mixins/_rwd.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/responsive-form/responsiveform.css"],names:[],mappings:"AAQC,mCAMC,WAAY,CALZ,UAAW,CAEX,iBAAkB,CAClB,UAAW,CACX,QAAS,CAHT,OAAQ,CAKR,SACD,CAEA,yCACC,YACD,CCdA,oCDoBE,wCAMC,WAAY,CALZ,UAAW,CAEX,iBAAkB,CAClB,UAAW,CACX,QAAS,CAHT,OAAQ,CAKR,SACD,CAEA,8CACC,YACD,CC9BF,CCAD,qDACC,kDACD,CAEA,uBACC,+BAmED,CAjEC,6BAEC,YACD,CASC,uGACC,sCACD,CDvBD,oCCMD,uBAqBE,SAAU,CACV,oCA8CF,CA5CE,8CACC,wDAWD,CATC,6DACC,WAAY,CACZ,UACD,CAGA,4EACC,kBACD,CAKA,0DACC,kDACD,CAGD,iGAIC,eAAgB,CADhB,kCAAmC,CADnC,kCAmBD,CAfC,yHACC,gDACD,CARD,0OAeE,aAMF,CAJE,+IACC,kDACD,CDpEH",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_rwd.css";

.ck-vertical-form .ck-button {
	&::after {
		content: "";
		width: 0;
		position: absolute;
		right: -1px;
		top: -1px;
		bottom: -1px;
		z-index: 1;
	}

	&:focus::after {
		display: none;
	}
}

.ck.ck-responsive-form {
	@mixin ck-media-phone {
		& .ck-button {
			&::after {
				content: "";
				width: 0;
				position: absolute;
				right: -1px;
				top: -1px;
				bottom: -1px;
				z-index: 1;
			}

			&:focus::after {
				display: none;
			}
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@define-mixin ck-media-phone {
	@media screen and (max-width: 600px) {
		@mixin-content;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "@ckeditor/ckeditor5-ui/theme/mixins/_rwd.css";
@import "@ckeditor/ckeditor5-ui/theme/mixins/_dir.css";

.ck-vertical-form > .ck-button:nth-last-child(2)::after {
	border-right: 1px solid var(--ck-color-base-border);
}

.ck.ck-responsive-form {
	padding: var(--ck-spacing-large);

	&:focus {
		/* See: https://github.com/ckeditor/ckeditor5/issues/4773 */
		outline: none;
	}

	@mixin ck-dir ltr {
		& > :not(:first-child) {
			margin-left: var(--ck-spacing-standard);
		}
	}

	@mixin ck-dir rtl {
		& > :not(:last-child) {
			margin-left: var(--ck-spacing-standard);
		}
	}

	@mixin ck-media-phone {
		padding: 0;
		width: calc(.8 * var(--ck-input-width));

		& .ck-labeled-field-view {
			margin: var(--ck-spacing-large) var(--ck-spacing-large) 0;

			& .ck-input-text {
				min-width: 0;
				width: 100%;
			}

			/* Let the long error messages wrap in the narrow form. */
			& .ck-labeled-field-view__error {
				white-space: normal;
			}
		}

		/* Styles for two last buttons in the form (save&cancel, edit&unlink, etc.). */
		& > .ck-button:nth-last-child(2) {
			&::after {
				border-right: 1px solid var(--ck-color-base-border);
			}
		}

		& > .ck-button:nth-last-child(1),
		& > .ck-button:nth-last-child(2) {
			padding: var(--ck-spacing-standard);
			margin-top: var(--ck-spacing-large);
			border-radius: 0;

			&:not(:focus) {
				border-top: 1px solid var(--ck-color-base-border);
			}

			@mixin ck-dir ltr {
				margin-left: 0;
			}

			@mixin ck-dir rtl {
				margin-left: 0;

				&:last-of-type {
					border-right: 1px solid var(--ck-color-base-border);
				}
			}
		}
	}
}
`],sourceRoot:""}]);const O=P},9695:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-block-toolbar-button{position:absolute;z-index:var(--ck-z-default)}:root{--ck-color-block-toolbar-button:var(--ck-color-text);--ck-block-toolbar-button-size:var(--ck-font-size-normal)}.ck.ck-block-toolbar-button{color:var(--ck-color-block-toolbar-button);font-size:var(--ck-block-toolbar-size)}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/toolbar/blocktoolbar.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/toolbar/blocktoolbar.css"],names:[],mappings:"AAKA,4BACC,iBAAkB,CAClB,2BACD,CCHA,MACC,oDAAqD,CACrD,yDACD,CAEA,4BACC,0CAA2C,CAC3C,sCACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-block-toolbar-button {
	position: absolute;
	z-index: var(--ck-z-default);
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-color-block-toolbar-button: var(--ck-color-text);
	--ck-block-toolbar-button-size: var(--ck-font-size-normal);
}

.ck.ck-block-toolbar-button {
	color: var(--ck-color-block-toolbar-button);
	font-size: var(--ck-block-toolbar-size);
}
`],sourceRoot:""}]);const O=P},5542:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-toolbar{align-items:center;display:flex;flex-flow:row nowrap;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none}.ck.ck-toolbar>.ck-toolbar__items{align-items:center;display:flex;flex-flow:row wrap;flex-grow:1}.ck.ck-toolbar .ck.ck-toolbar__separator{display:inline-block}.ck.ck-toolbar .ck.ck-toolbar__separator:first-child,.ck.ck-toolbar .ck.ck-toolbar__separator:last-child{display:none}.ck.ck-toolbar .ck-toolbar__line-break{flex-basis:100%}.ck.ck-toolbar.ck-toolbar_grouping>.ck-toolbar__items{flex-wrap:nowrap}.ck.ck-toolbar.ck-toolbar_vertical>.ck-toolbar__items{flex-direction:column}.ck.ck-toolbar.ck-toolbar_floating>.ck-toolbar__items{flex-wrap:nowrap}.ck.ck-toolbar>.ck.ck-toolbar__grouped-dropdown>.ck-dropdown__button .ck-dropdown__arrow{display:none}.ck.ck-toolbar{border-radius:0}.ck-rounded-corners .ck.ck-toolbar,.ck.ck-toolbar.ck-rounded-corners{border-radius:var(--ck-border-radius)}.ck.ck-toolbar{background:var(--ck-color-toolbar-background);border:1px solid var(--ck-color-toolbar-border);padding:0 var(--ck-spacing-small)}.ck.ck-toolbar .ck.ck-toolbar__separator{align-self:stretch;background:var(--ck-color-toolbar-border);margin-bottom:var(--ck-spacing-small);margin-top:var(--ck-spacing-small);min-width:1px;width:1px}.ck.ck-toolbar .ck-toolbar__line-break{height:0}.ck.ck-toolbar>.ck-toolbar__items>:not(.ck-toolbar__line-break){margin-right:var(--ck-spacing-small)}.ck.ck-toolbar>.ck-toolbar__items:empty+.ck.ck-toolbar__separator{display:none}.ck.ck-toolbar>.ck-toolbar__items>:not(.ck-toolbar__line-break),.ck.ck-toolbar>.ck.ck-toolbar__grouped-dropdown{margin-bottom:var(--ck-spacing-small);margin-top:var(--ck-spacing-small)}.ck.ck-toolbar.ck-toolbar_vertical{padding:0}.ck.ck-toolbar.ck-toolbar_vertical>.ck-toolbar__items>.ck{border-radius:0;margin:0;width:100%}.ck.ck-toolbar.ck-toolbar_compact{padding:0}.ck.ck-toolbar.ck-toolbar_compact>.ck-toolbar__items>*{margin:0}.ck.ck-toolbar.ck-toolbar_compact>.ck-toolbar__items>:not(:first-child):not(:last-child){border-radius:0}.ck.ck-toolbar>.ck.ck-toolbar__grouped-dropdown>.ck.ck-button.ck-dropdown__button{padding-left:var(--ck-spacing-tiny)}.ck.ck-toolbar .ck-toolbar__nested-toolbar-dropdown>.ck-dropdown__panel{min-width:auto}.ck.ck-toolbar .ck-toolbar__nested-toolbar-dropdown>.ck-button>.ck-button__label{max-width:7em;width:auto}.ck-toolbar-container .ck.ck-toolbar{border:0}.ck.ck-toolbar[dir=rtl]>.ck-toolbar__items>.ck,[dir=rtl] .ck.ck-toolbar>.ck-toolbar__items>.ck{margin-right:0}.ck.ck-toolbar[dir=rtl]:not(.ck-toolbar_compact)>.ck-toolbar__items>.ck,[dir=rtl] .ck.ck-toolbar:not(.ck-toolbar_compact)>.ck-toolbar__items>.ck{margin-left:var(--ck-spacing-small)}.ck.ck-toolbar[dir=rtl]>.ck-toolbar__items>.ck:last-child,[dir=rtl] .ck.ck-toolbar>.ck-toolbar__items>.ck:last-child{margin-left:0}.ck.ck-toolbar.ck-toolbar_compact[dir=rtl]>.ck-toolbar__items>.ck:first-child,[dir=rtl] .ck.ck-toolbar.ck-toolbar_compact>.ck-toolbar__items>.ck:first-child{border-bottom-left-radius:0;border-top-left-radius:0}.ck.ck-toolbar.ck-toolbar_compact[dir=rtl]>.ck-toolbar__items>.ck:last-child,[dir=rtl] .ck.ck-toolbar.ck-toolbar_compact>.ck-toolbar__items>.ck:last-child{border-bottom-right-radius:0;border-top-right-radius:0}.ck.ck-toolbar.ck-toolbar_grouping[dir=rtl]>.ck-toolbar__items:not(:empty):not(:only-child),.ck.ck-toolbar[dir=rtl]>.ck.ck-toolbar__separator,[dir=rtl] .ck.ck-toolbar.ck-toolbar_grouping>.ck-toolbar__items:not(:empty):not(:only-child),[dir=rtl] .ck.ck-toolbar>.ck.ck-toolbar__separator{margin-left:var(--ck-spacing-small)}.ck.ck-toolbar[dir=ltr]>.ck-toolbar__items>.ck:last-child,[dir=ltr] .ck.ck-toolbar>.ck-toolbar__items>.ck:last-child{margin-right:0}.ck.ck-toolbar.ck-toolbar_compact[dir=ltr]>.ck-toolbar__items>.ck:first-child,[dir=ltr] .ck.ck-toolbar.ck-toolbar_compact>.ck-toolbar__items>.ck:first-child{border-bottom-right-radius:0;border-top-right-radius:0}.ck.ck-toolbar.ck-toolbar_compact[dir=ltr]>.ck-toolbar__items>.ck:last-child,[dir=ltr] .ck.ck-toolbar.ck-toolbar_compact>.ck-toolbar__items>.ck:last-child{border-bottom-left-radius:0;border-top-left-radius:0}.ck.ck-toolbar.ck-toolbar_grouping[dir=ltr]>.ck-toolbar__items:not(:empty):not(:only-child),.ck.ck-toolbar[dir=ltr]>.ck.ck-toolbar__separator,[dir=ltr] .ck.ck-toolbar.ck-toolbar_grouping>.ck-toolbar__items:not(:empty):not(:only-child),[dir=ltr] .ck.ck-toolbar>.ck.ck-toolbar__separator{margin-right:var(--ck-spacing-small)}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/toolbar/toolbar.css","webpack://./../ckeditor5-ui/theme/mixins/_unselectable.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/toolbar/toolbar.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_rounded.css"],names:[],mappings:"AAOA,eAKC,kBAAmB,CAFnB,YAAa,CACb,oBAAqB,CCFrB,qBAAsB,CACtB,wBAAyB,CACzB,oBAAqB,CACrB,gBD6CD,CA3CC,kCAGC,kBAAmB,CAFnB,YAAa,CACb,kBAAmB,CAEnB,WAED,CAEA,yCACC,oBAWD,CAJC,yGAEC,YACD,CAGD,uCACC,eACD,CAEA,sDACC,gBACD,CAEA,sDACC,qBACD,CAEA,sDACC,gBACD,CAGC,yFACC,YACD,CE/CF,eCGC,eDoGD,CAvGA,qECOE,qCDgGF,CAvGA,eAGC,6CAA8C,CAE9C,+CAAgD,CADhD,iCAmGD,CAhGC,yCACC,kBAAmB,CAGnB,yCAA0C,CAO1C,qCAAsC,CADtC,kCAAmC,CAPnC,aAAc,CADd,SAUD,CAEA,uCACC,QACD,CAGC,gEAEC,oCACD,CAIA,kEACC,YACD,CAGD,gHAIC,qCAAsC,CADtC,kCAED,CAEA,mCAEC,SAaD,CAVC,0DAQC,eAAgB,CAHhB,QAAS,CAHT,UAOD,CAGD,kCAEC,SAWD,CATC,uDAEC,QAMD,CAHC,yFACC,eACD,CASD,kFACC,mCACD,CAMA,wEACC,cACD,CAEA,iFACC,aAAc,CACd,UACD,CAjGF,qCAqGE,QAEF,CAYC,+FACC,cACD,CAEA,iJAEC,mCACD,CAEA,qHACC,aACD,CAIC,6JAEC,2BAA4B,CAD5B,wBAED,CAGA,2JAEC,4BAA6B,CAD7B,yBAED,CASD,8RACC,mCACD,CAWA,qHACC,cACD,CAIC,6JAEC,4BAA6B,CAD7B,yBAED,CAGA,2JAEC,2BAA4B,CAD5B,wBAED,CASD,8RACC,oCACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../mixins/_unselectable.css";

.ck.ck-toolbar {
	@mixin ck-unselectable;

	display: flex;
	flex-flow: row nowrap;
	align-items: center;

	& > .ck-toolbar__items {
		display: flex;
		flex-flow: row wrap;
		align-items: center;
		flex-grow: 1;

	}

	& .ck.ck-toolbar__separator {
		display: inline-block;

		/*
		 * A leading or trailing separator makes no sense (separates from nothing on one side).
		 * For instance, it can happen when toolbar items (also separators) are getting grouped one by one and
		 * moved to another toolbar in the dropdown.
		 */
		&:first-child,
		&:last-child {
			display: none;
		}
	}

	& .ck-toolbar__line-break {
		flex-basis: 100%;
	}

	&.ck-toolbar_grouping > .ck-toolbar__items {
		flex-wrap: nowrap;
	}

	&.ck-toolbar_vertical > .ck-toolbar__items {
		flex-direction: column;
	}

	&.ck-toolbar_floating > .ck-toolbar__items {
		flex-wrap: nowrap;
	}

	& > .ck.ck-toolbar__grouped-dropdown {
		& > .ck-dropdown__button .ck-dropdown__arrow {
			display: none;
		}
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Makes element unselectable.
 */
@define-mixin ck-unselectable {
	-moz-user-select: none;
	-webkit-user-select: none;
	-ms-user-select: none;
	user-select: none
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";
@import "@ckeditor/ckeditor5-ui/theme/mixins/_dir.css";

.ck.ck-toolbar {
	@mixin ck-rounded-corners;

	background: var(--ck-color-toolbar-background);
	padding: 0 var(--ck-spacing-small);
	border: 1px solid var(--ck-color-toolbar-border);

	& .ck.ck-toolbar__separator {
		align-self: stretch;
		width: 1px;
		min-width: 1px;
		background: var(--ck-color-toolbar-border);

		/*
		 * These margins make the separators look better in balloon toolbars (when aligned with the "tip").
		 * See https://github.com/ckeditor/ckeditor5/issues/7493.
		 */
		margin-top: var(--ck-spacing-small);
		margin-bottom: var(--ck-spacing-small);
	}

	& .ck-toolbar__line-break {
		height: 0;
	}

	& > .ck-toolbar__items {
		& > *:not(.ck-toolbar__line-break) {
			/* (#11) Separate toolbar items. */
			margin-right: var(--ck-spacing-small);
		}

		/* Don't display a separator after an empty items container, for instance,
		when all items were grouped */
		&:empty + .ck.ck-toolbar__separator {
			display: none;
		}
	}

	& > .ck-toolbar__items > *:not(.ck-toolbar__line-break),
	& > .ck.ck-toolbar__grouped-dropdown {
		/* Make sure items wrapped to the next line have v-spacing */
		margin-top: var(--ck-spacing-small);
		margin-bottom: var(--ck-spacing-small);
	}

	&.ck-toolbar_vertical {
		/* Items in a vertical toolbar span the entire width. */
		padding: 0;

		/* Specificity matters here. See https://github.com/ckeditor/ckeditor5-theme-lark/issues/168. */
		& > .ck-toolbar__items > .ck {
			/* Items in a vertical toolbar should span the horizontal space. */
			width: 100%;

			/* Items in a vertical toolbar should have no margin. */
			margin: 0;

			/* Items in a vertical toolbar span the entire width so rounded corners are pointless. */
			border-radius: 0;
		}
	}

	&.ck-toolbar_compact {
		/* No spacing around items. */
		padding: 0;

		& > .ck-toolbar__items > * {
			/* Compact toolbar items have no spacing between them. */
			margin: 0;

			/* "Middle" children should have no rounded corners. */
			&:not(:first-child):not(:last-child) {
				border-radius: 0;
			}
		}
	}

	& > .ck.ck-toolbar__grouped-dropdown {
		/*
		 * Dropdown button has asymmetric padding to fit the arrow.
		 * This button has no arrow so let's revert that padding back to normal.
		 */
		& > .ck.ck-button.ck-dropdown__button {
			padding-left: var(--ck-spacing-tiny);
		}
	}

	/* A drop-down containing the nested toolbar with configured items. */
	& .ck-toolbar__nested-toolbar-dropdown {
		/* Prevent empty space in the panel when the dropdown label is visible and long but the toolbar has few items. */
		& > .ck-dropdown__panel {
			min-width: auto;
		}

		& > .ck-button > .ck-button__label {
			max-width: 7em;
			width: auto;
		}
	}

	@nest .ck-toolbar-container & {
		border: 0;
	}
}

/* stylelint-disable */

/*
 * Styles for RTL toolbars.
 *
 * Note: In some cases (e.g. a decoupled editor), the toolbar has its own "dir"
 * because its parent is not controlled by the editor framework.
 */
[dir="rtl"] .ck.ck-toolbar,
.ck.ck-toolbar[dir="rtl"] {
	& > .ck-toolbar__items > .ck {
		margin-right: 0;
	}

	&:not(.ck-toolbar_compact) > .ck-toolbar__items > .ck {
		/* (#11) Separate toolbar items. */
		margin-left: var(--ck-spacing-small);
	}

	& > .ck-toolbar__items > .ck:last-child {
		margin-left: 0;
	}

	&.ck-toolbar_compact > .ck-toolbar__items > .ck {
		/* No rounded corners on the right side of the first child. */
		&:first-child {
			border-top-left-radius: 0;
			border-bottom-left-radius: 0;
		}

		/* No rounded corners on the left side of the last child. */
		&:last-child {
			border-top-right-radius: 0;
			border-bottom-right-radius: 0;
		}
	}

	/* Separate the the separator form the grouping dropdown when some items are grouped. */
	& > .ck.ck-toolbar__separator {
		margin-left: var(--ck-spacing-small);
	}

	/* Some spacing between the items and the separator before the grouped items dropdown. */
	&.ck-toolbar_grouping > .ck-toolbar__items:not(:empty):not(:only-child) {
		margin-left: var(--ck-spacing-small);
	}
}

/*
 * Styles for LTR toolbars.
 *
 * Note: In some cases (e.g. a decoupled editor), the toolbar has its own "dir"
 * because its parent is not controlled by the editor framework.
 */
[dir="ltr"] .ck.ck-toolbar,
.ck.ck-toolbar[dir="ltr"] {
	& > .ck-toolbar__items > .ck:last-child {
		margin-right: 0;
	}

	&.ck-toolbar_compact > .ck-toolbar__items > .ck {
		/* No rounded corners on the right side of the first child. */
		&:first-child {
			border-top-right-radius: 0;
			border-bottom-right-radius: 0;
		}

		/* No rounded corners on the left side of the last child. */
		&:last-child {
			border-top-left-radius: 0;
			border-bottom-left-radius: 0;
		}
	}

	/* Separate the the separator form the grouping dropdown when some items are grouped. */
	& > .ck.ck-toolbar__separator {
		margin-right: var(--ck-spacing-small);
	}

	/* Some spacing between the items and the separator before the grouped items dropdown. */
	&.ck-toolbar_grouping > .ck-toolbar__items:not(:empty):not(:only-child) {
		margin-right: var(--ck-spacing-small);
	}
}

/* stylelint-enable */
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Implements rounded corner interface for .ck-rounded-corners class.
 *
 * @see $ck-border-radius
 */
@define-mixin ck-rounded-corners {
	border-radius: 0;

	@nest .ck-rounded-corners &,
	&.ck-rounded-corners {
		border-radius: var(--ck-border-radius);
		@mixin-content;
	}
}
`],sourceRoot:""}]);const O=P},3332:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck.ck-balloon-panel.ck-tooltip{--ck-balloon-border-width:0px;--ck-balloon-arrow-offset:0px;--ck-balloon-arrow-half-width:4px;--ck-balloon-arrow-height:4px;--ck-color-panel-background:var(--ck-color-tooltip-background);padding:0 var(--ck-spacing-medium);pointer-events:none;z-index:calc(var(--ck-z-modal) + 100)}.ck.ck-balloon-panel.ck-tooltip .ck-tooltip__text{color:var(--ck-color-tooltip-text);font-size:.9em;line-height:1.5}.ck.ck-balloon-panel.ck-tooltip{box-shadow:none}.ck.ck-balloon-panel.ck-tooltip:before{display:none}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/components/tooltip/tooltip.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/components/tooltip/tooltip.css"],names:[],mappings:"AAKA,gCCGC,6BAA8B,CAC9B,6BAA8B,CAC9B,iCAAkC,CAClC,6BAA8B,CAC9B,8DAA+D,CAE/D,kCAAmC,CDPnC,mBAAoB,CAEpB,qCACD,CCMC,kDAGC,kCAAmC,CAFnC,cAAe,CACf,eAED,CAbD,gCAgBC,eAMD,CAHC,uCACC,YACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-balloon-panel.ck-tooltip {
	/* Keep tooltips transparent for any interactions. */
	pointer-events: none;

	z-index: calc( var(--ck-z-modal) + 100 );
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../../../mixins/_rounded.css";

.ck.ck-balloon-panel.ck-tooltip {
	--ck-balloon-border-width: 0px;
	--ck-balloon-arrow-offset: 0px;
	--ck-balloon-arrow-half-width: 4px;
	--ck-balloon-arrow-height: 4px;
	--ck-color-panel-background: var(--ck-color-tooltip-background);

	padding: 0 var(--ck-spacing-medium);

	& .ck-tooltip__text {
		font-size: .9em;
		line-height: 1.5;
		color: var(--ck-color-tooltip-text);
	}

	/* Reset balloon panel styles */
	box-shadow: none;

	/* Hide the default shadow of the .ck-balloon-panel tip */
	&::before {
		display: none;
	}
}
`],sourceRoot:""}]);const O=P},4793:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck-hidden{display:none!important}.ck-reset_all :not(.ck-reset_all-excluded *),.ck.ck-reset,.ck.ck-reset_all{box-sizing:border-box;height:auto;position:static;width:auto}:root{--ck-z-default:1;--ck-z-modal:calc(var(--ck-z-default) + 999)}.ck-transitions-disabled,.ck-transitions-disabled *{transition:none!important}:root{--ck-color-base-foreground:#fafafa;--ck-color-base-background:#fff;--ck-color-base-border:#ccced1;--ck-color-base-action:#53a336;--ck-color-base-focus:#6cb5f9;--ck-color-base-text:#333;--ck-color-base-active:#2977ff;--ck-color-base-active-focus:#0d65ff;--ck-color-base-error:#db3700;--ck-color-focus-border-coordinates:218,81.8%,56.9%;--ck-color-focus-border:hsl(var(--ck-color-focus-border-coordinates));--ck-color-focus-outer-shadow:#cae1fc;--ck-color-focus-disabled-shadow:rgba(119,186,248,.3);--ck-color-focus-error-shadow:rgba(255,64,31,.3);--ck-color-text:var(--ck-color-base-text);--ck-color-shadow-drop:rgba(0,0,0,.15);--ck-color-shadow-drop-active:rgba(0,0,0,.2);--ck-color-shadow-inner:rgba(0,0,0,.1);--ck-color-button-default-background:transparent;--ck-color-button-default-hover-background:#f0f0f0;--ck-color-button-default-active-background:#f0f0f0;--ck-color-button-default-disabled-background:transparent;--ck-color-button-on-background:#f0f7ff;--ck-color-button-on-hover-background:#dbecff;--ck-color-button-on-active-background:#dbecff;--ck-color-button-on-disabled-background:#f0f2f4;--ck-color-button-on-color:#2977ff;--ck-color-button-action-background:var(--ck-color-base-action);--ck-color-button-action-hover-background:#4d9d30;--ck-color-button-action-active-background:#4d9d30;--ck-color-button-action-disabled-background:#7ec365;--ck-color-button-action-text:var(--ck-color-base-background);--ck-color-button-save:#008a00;--ck-color-button-cancel:#db3700;--ck-color-switch-button-off-background:#939393;--ck-color-switch-button-off-hover-background:#7d7d7d;--ck-color-switch-button-on-background:var(--ck-color-button-action-background);--ck-color-switch-button-on-hover-background:#4d9d30;--ck-color-switch-button-inner-background:var(--ck-color-base-background);--ck-color-switch-button-inner-shadow:rgba(0,0,0,.1);--ck-color-dropdown-panel-background:var(--ck-color-base-background);--ck-color-dropdown-panel-border:var(--ck-color-base-border);--ck-color-input-background:var(--ck-color-base-background);--ck-color-input-border:var(--ck-color-base-border);--ck-color-input-error-border:var(--ck-color-base-error);--ck-color-input-text:var(--ck-color-base-text);--ck-color-input-disabled-background:#f2f2f2;--ck-color-input-disabled-border:var(--ck-color-base-border);--ck-color-input-disabled-text:#757575;--ck-color-list-background:var(--ck-color-base-background);--ck-color-list-button-hover-background:var(--ck-color-button-default-hover-background);--ck-color-list-button-on-background:var(--ck-color-button-on-color);--ck-color-list-button-on-background-focus:var(--ck-color-button-on-color);--ck-color-list-button-on-text:var(--ck-color-base-background);--ck-color-panel-background:var(--ck-color-base-background);--ck-color-panel-border:var(--ck-color-base-border);--ck-color-toolbar-background:var(--ck-color-base-background);--ck-color-toolbar-border:var(--ck-color-base-border);--ck-color-tooltip-background:var(--ck-color-base-text);--ck-color-tooltip-text:var(--ck-color-base-background);--ck-color-engine-placeholder-text:#707070;--ck-color-upload-bar-background:#6cb5f9;--ck-color-link-default:#0000f0;--ck-color-link-selected-background:rgba(31,176,255,.1);--ck-color-link-fake-selection:rgba(31,176,255,.3);--ck-color-highlight-background:#ff0;--ck-disabled-opacity:.5;--ck-focus-outer-shadow-geometry:0 0 0 3px;--ck-focus-outer-shadow:var(--ck-focus-outer-shadow-geometry) var(--ck-color-focus-outer-shadow);--ck-focus-disabled-outer-shadow:var(--ck-focus-outer-shadow-geometry) var(--ck-color-focus-disabled-shadow);--ck-focus-error-outer-shadow:var(--ck-focus-outer-shadow-geometry) var(--ck-color-focus-error-shadow);--ck-focus-ring:1px solid var(--ck-color-focus-border);--ck-font-size-base:13px;--ck-line-height-base:1.84615;--ck-font-face:Helvetica,Arial,Tahoma,Verdana,Sans-Serif;--ck-font-size-tiny:0.7em;--ck-font-size-small:0.75em;--ck-font-size-normal:1em;--ck-font-size-big:1.4em;--ck-font-size-large:1.8em;--ck-ui-component-min-height:2.3em}.ck-reset_all :not(.ck-reset_all-excluded *),.ck.ck-reset,.ck.ck-reset_all{word-wrap:break-word;background:transparent;border:0;margin:0;padding:0;text-decoration:none;transition:none;vertical-align:middle}.ck-reset_all :not(.ck-reset_all-excluded *),.ck.ck-reset_all{border-collapse:collapse;color:var(--ck-color-text);cursor:auto;float:none;font:normal normal normal var(--ck-font-size-base)/var(--ck-line-height-base) var(--ck-font-face);text-align:left;white-space:nowrap}.ck-reset_all .ck-rtl :not(.ck-reset_all-excluded *){text-align:right}.ck-reset_all iframe:not(.ck-reset_all-excluded *){vertical-align:inherit}.ck-reset_all textarea:not(.ck-reset_all-excluded *){white-space:pre-wrap}.ck-reset_all input[type=password]:not(.ck-reset_all-excluded *),.ck-reset_all input[type=text]:not(.ck-reset_all-excluded *),.ck-reset_all textarea:not(.ck-reset_all-excluded *){cursor:text}.ck-reset_all input[type=password][disabled]:not(.ck-reset_all-excluded *),.ck-reset_all input[type=text][disabled]:not(.ck-reset_all-excluded *),.ck-reset_all textarea[disabled]:not(.ck-reset_all-excluded *){cursor:default}.ck-reset_all fieldset:not(.ck-reset_all-excluded *){border:2px groove #dfdee3;padding:10px}.ck-reset_all button:not(.ck-reset_all-excluded *)::-moz-focus-inner{border:0;padding:0}.ck[dir=rtl],.ck[dir=rtl] .ck{text-align:right}:root{--ck-border-radius:2px;--ck-inner-shadow:2px 2px 3px var(--ck-color-shadow-inner) inset;--ck-drop-shadow:0 1px 2px 1px var(--ck-color-shadow-drop);--ck-drop-shadow-active:0 3px 6px 1px var(--ck-color-shadow-drop-active);--ck-spacing-unit:0.6em;--ck-spacing-large:calc(var(--ck-spacing-unit)*1.5);--ck-spacing-standard:var(--ck-spacing-unit);--ck-spacing-medium:calc(var(--ck-spacing-unit)*0.8);--ck-spacing-small:calc(var(--ck-spacing-unit)*0.5);--ck-spacing-tiny:calc(var(--ck-spacing-unit)*0.3);--ck-spacing-extra-tiny:calc(var(--ck-spacing-unit)*0.16)}","",{version:3,sources:["webpack://./../ckeditor5-ui/theme/globals/_hidden.css","webpack://./../ckeditor5-ui/theme/globals/_reset.css","webpack://./../ckeditor5-ui/theme/globals/_zindex.css","webpack://./../ckeditor5-ui/theme/globals/_transition.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/globals/_colors.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/globals/_disabled.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/globals/_focus.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/globals/_fonts.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/globals/_reset.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/globals/_rounded.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/globals/_shadow.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-ui/globals/_spacing.css"],names:[],mappings:"AAQA,WAGC,sBACD,CCPA,2EAGC,qBAAsB,CAEtB,WAAY,CACZ,eAAgB,CAFhB,UAGD,CCPA,MACC,gBAAiB,CACjB,4CACD,CCAA,oDAEC,yBACD,CCNA,MACC,kCAAmD,CACnD,+BAAoD,CACpD,8BAAkD,CAClD,8BAAuD,CACvD,6BAAmD,CACnD,yBAA+C,CAC/C,8BAAsD,CACtD,oCAA4D,CAC5D,6BAAkD,CAIlD,mDAA4D,CAC5D,qEAA+E,CAC/E,qCAA4D,CAC5D,qDAA8D,CAC9D,gDAAyD,CACzD,yCAAqD,CACrD,sCAAsD,CACtD,4CAA0D,CAC1D,sCAAsD,CAItD,gDAAuD,CACvD,kDAAiE,CACjE,mDAAkE,CAClE,yDAA8D,CAE9D,uCAA6D,CAC7D,6CAAoE,CACpE,8CAAoE,CACpE,gDAAiE,CACjE,kCAAyD,CAGzD,+DAAsE,CACtE,iDAAsE,CACtE,kDAAsE,CACtE,oDAAoE,CACpE,6DAAsE,CAEtE,8BAAoD,CACpD,gCAAqD,CAErD,+CAA8D,CAC9D,qDAAiE,CACjE,+EAAqF,CACrF,oDAAuE,CACvE,yEAA8E,CAC9E,oDAAgE,CAIhE,oEAA2E,CAC3E,4DAAoE,CAIpE,2DAAoE,CACpE,mDAA6D,CAC7D,wDAAgE,CAChE,+CAA0D,CAC1D,4CAA2D,CAC3D,4DAAoE,CACpE,sCAAsD,CAItD,0DAAmE,CACnE,uFAA6F,CAC7F,oEAA2E,CAC3E,0EAA+E,CAC/E,8DAAsE,CAItE,2DAAoE,CACpE,mDAA6D,CAI7D,6DAAsE,CACtE,qDAA+D,CAI/D,uDAAgE,CAChE,uDAAiE,CAIjE,0CAAyD,CAIzD,wCAA2D,CAI3D,+BAAoD,CACpD,uDAAmE,CACnE,kDAAgE,CAIhE,oCAAwD,CCvGxD,wBAAyB,CCAzB,0CAA2C,CAK3C,gGAAiG,CAKjG,4GAA6G,CAK7G,sGAAuG,CAKvG,sDAAuD,CCvBvD,wBAAyB,CACzB,6BAA8B,CAC9B,wDAA6D,CAE7D,yBAA0B,CAC1B,2BAA4B,CAC5B,yBAA0B,CAC1B,wBAAyB,CACzB,0BAA2B,CCJ3B,kCJuGD,CIjGA,2EAaC,oBAAqB,CANrB,sBAAuB,CADvB,QAAS,CAFT,QAAS,CACT,SAAU,CAGV,oBAAqB,CAErB,eAAgB,CADhB,qBAKD,CAKA,8DAGC,wBAAyB,CAEzB,0BAA2B,CAG3B,WAAY,CACZ,UAAW,CALX,iGAAkG,CAElG,eAAgB,CAChB,kBAGD,CAGC,qDACC,gBACD,CAEA,mDAEC,sBACD,CAEA,qDACC,oBACD,CAEA,mLAGC,WACD,CAEA,iNAGC,cACD,CAEA,qDAEC,yBAAoC,CADpC,YAED,CAEA,qEAGC,QAAQ,CADR,SAED,CAMD,8BAEC,gBACD,CCnFA,MACC,sBAAuB,CCAvB,gEAAiE,CAKjE,0DAA2D,CAK3D,wEAAyE,CCbzE,uBAA8B,CAC9B,mDAA2D,CAC3D,4CAAkD,CAClD,oDAA4D,CAC5D,mDAA2D,CAC3D,kDAA2D,CAC3D,yDFFD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A class which hides an element in DOM.
 */
.ck-hidden {
	/* Override selector specificity. Otherwise, all elements with some display
	style defined will override this one, which is not a desired result. */
	display: none !important;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck.ck-reset,
.ck.ck-reset_all,
.ck-reset_all *:not(.ck-reset_all-excluded *) {
	box-sizing: border-box;
	width: auto;
	height: auto;
	position: static;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-z-default: 1;
	--ck-z-modal: calc( var(--ck-z-default) + 999 );
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A class that disables all transitions of the element and its children.
 */
.ck-transitions-disabled,
.ck-transitions-disabled * {
	transition: none !important;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-color-base-foreground: 								hsl(0, 0%, 98%);
	--ck-color-base-background: 								hsl(0, 0%, 100%);
	--ck-color-base-border: 									hsl(220, 6%, 81%);
	--ck-color-base-action: 									hsl(104, 50.2%, 42.5%);
	--ck-color-base-focus: 										hsl(209, 92%, 70%);
	--ck-color-base-text: 										hsl(0, 0%, 20%);
	--ck-color-base-active: 									hsl(218.1, 100%, 58%);
	--ck-color-base-active-focus:								hsl(218.2, 100%, 52.5%);
	--ck-color-base-error:										hsl(15, 100%, 43%);

	/* -- Generic colors ------------------------------------------------------------------------ */

	--ck-color-focus-border-coordinates: 						218, 81.8%, 56.9%;
	--ck-color-focus-border: 									hsl(var(--ck-color-focus-border-coordinates));
	--ck-color-focus-outer-shadow:								hsl(212.4, 89.3%, 89%);
	--ck-color-focus-disabled-shadow:							hsla(209, 90%, 72%,.3);
	--ck-color-focus-error-shadow:								hsla(9,100%,56%,.3);
	--ck-color-text: 											var(--ck-color-base-text);
	--ck-color-shadow-drop: 									hsla(0, 0%, 0%, 0.15);
	--ck-color-shadow-drop-active:								hsla(0, 0%, 0%, 0.2);
	--ck-color-shadow-inner: 									hsla(0, 0%, 0%, 0.1);

	/* -- Buttons ------------------------------------------------------------------------------- */

	--ck-color-button-default-background: 						transparent;
	--ck-color-button-default-hover-background: 				hsl(0, 0%, 94.1%);
	--ck-color-button-default-active-background: 				hsl(0, 0%, 94.1%);
	--ck-color-button-default-disabled-background: 				transparent;

	--ck-color-button-on-background: 							hsl(212, 100%, 97.1%);
	--ck-color-button-on-hover-background: 						hsl(211.7, 100%, 92.9%);
	--ck-color-button-on-active-background: 					hsl(211.7, 100%, 92.9%);
	--ck-color-button-on-disabled-background: 					hsl(211, 15%, 95%);
	--ck-color-button-on-color:									hsl(218.1, 100%, 58%);


	--ck-color-button-action-background: 						var(--ck-color-base-action);
	--ck-color-button-action-hover-background: 					hsl(104, 53.2%, 40.2%);
	--ck-color-button-action-active-background: 				hsl(104, 53.2%, 40.2%);
	--ck-color-button-action-disabled-background: 				hsl(104, 44%, 58%);
	--ck-color-button-action-text: 								var(--ck-color-base-background);

	--ck-color-button-save: 									hsl(120, 100%, 27%);
	--ck-color-button-cancel: 									hsl(15, 100%, 43%);

	--ck-color-switch-button-off-background:					hsl(0, 0%, 57.6%);
	--ck-color-switch-button-off-hover-background:				hsl(0, 0%, 49%);
	--ck-color-switch-button-on-background:						var(--ck-color-button-action-background);
	--ck-color-switch-button-on-hover-background:				hsl(104, 53.2%, 40.2%);
	--ck-color-switch-button-inner-background:					var(--ck-color-base-background);
	--ck-color-switch-button-inner-shadow:						hsla(0, 0%, 0%, 0.1);

	/* -- Dropdown ------------------------------------------------------------------------------ */

	--ck-color-dropdown-panel-background: 						var(--ck-color-base-background);
	--ck-color-dropdown-panel-border: 							var(--ck-color-base-border);

	/* -- Input --------------------------------------------------------------------------------- */

	--ck-color-input-background: 								var(--ck-color-base-background);
	--ck-color-input-border: 									var(--ck-color-base-border);
	--ck-color-input-error-border:								var(--ck-color-base-error);
	--ck-color-input-text: 										var(--ck-color-base-text);
	--ck-color-input-disabled-background: 						hsl(0, 0%, 95%);
	--ck-color-input-disabled-border: 							var(--ck-color-base-border);
	--ck-color-input-disabled-text: 							hsl(0, 0%, 46%);

	/* -- List ---------------------------------------------------------------------------------- */

	--ck-color-list-background: 								var(--ck-color-base-background);
	--ck-color-list-button-hover-background: 					var(--ck-color-button-default-hover-background);
	--ck-color-list-button-on-background: 						var(--ck-color-button-on-color);
	--ck-color-list-button-on-background-focus: 				var(--ck-color-button-on-color);
	--ck-color-list-button-on-text:								var(--ck-color-base-background);

	/* -- Panel --------------------------------------------------------------------------------- */

	--ck-color-panel-background: 								var(--ck-color-base-background);
	--ck-color-panel-border: 									var(--ck-color-base-border);

	/* -- Toolbar ------------------------------------------------------------------------------- */

	--ck-color-toolbar-background: 								var(--ck-color-base-background);
	--ck-color-toolbar-border: 									var(--ck-color-base-border);

	/* -- Tooltip ------------------------------------------------------------------------------- */

	--ck-color-tooltip-background: 								var(--ck-color-base-text);
	--ck-color-tooltip-text: 									var(--ck-color-base-background);

	/* -- Engine -------------------------------------------------------------------------------- */

	--ck-color-engine-placeholder-text: 						hsl(0, 0%, 44%);

	/* -- Upload -------------------------------------------------------------------------------- */

	--ck-color-upload-bar-background:		 					hsl(209, 92%, 70%);

	/* -- Link -------------------------------------------------------------------------------- */

	--ck-color-link-default:									hsl(240, 100%, 47%);
	--ck-color-link-selected-background:						hsla(201, 100%, 56%, 0.1);
	--ck-color-link-fake-selection:								hsla(201, 100%, 56%, 0.3);

	/* -- Search result highlight ---------------------------------------------------------------- */

	--ck-color-highlight-background:							hsl(60, 100%, 50%)
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	/**
	 * An opacity value of disabled UI item.
	 */
	--ck-disabled-opacity: .5;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	/**
	 * The geometry of the of focused element's outer shadow.
	 */
	--ck-focus-outer-shadow-geometry: 0 0 0 3px;

	/**
	 * A visual style of focused element's outer shadow.
	 */
	--ck-focus-outer-shadow: var(--ck-focus-outer-shadow-geometry) var(--ck-color-focus-outer-shadow);

	/**
	 * A visual style of focused element's outer shadow (when disabled).
	 */
	--ck-focus-disabled-outer-shadow: var(--ck-focus-outer-shadow-geometry) var(--ck-color-focus-disabled-shadow);

	/**
	 * A visual style of focused element's outer shadow (when has errors).
	 */
	--ck-focus-error-outer-shadow: var(--ck-focus-outer-shadow-geometry) var(--ck-color-focus-error-shadow);

	/**
	 * A visual style of focused element's border or outline.
	 */
	--ck-focus-ring: 1px solid var(--ck-color-focus-border);
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-font-size-base: 13px;
	--ck-line-height-base: 1.84615;
	--ck-font-face: Helvetica, Arial, Tahoma, Verdana, Sans-Serif;

	--ck-font-size-tiny: 0.7em;
	--ck-font-size-small: 0.75em;
	--ck-font-size-normal: 1em;
	--ck-font-size-big: 1.4em;
	--ck-font-size-large: 1.8em;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	/* This is super-important. This is **manually** adjusted so a button without an icon
	is never smaller than a button with icon, additionally making sure that text-less buttons
	are perfect squares. The value is also shared by other components which should stay "in-line"
	with buttons. */
	--ck-ui-component-min-height: 2.3em;
}

/**
 * Resets an element, ignoring its children.
 */
.ck.ck-reset,
.ck.ck-reset_all,
.ck-reset_all *:not(.ck-reset_all-excluded *) {
	/* Do not include inheritable rules here. */
	margin: 0;
	padding: 0;
	border: 0;
	background: transparent;
	text-decoration: none;
	vertical-align: middle;
	transition: none;

	/* https://github.com/ckeditor/ckeditor5-theme-lark/issues/105 */
	word-wrap: break-word;
}

/**
 * Resets an element AND its children.
 */
.ck.ck-reset_all,
.ck-reset_all *:not(.ck-reset_all-excluded *) {
	/* These are rule inherited by all children elements. */
	border-collapse: collapse;
	font: normal normal normal var(--ck-font-size-base)/var(--ck-line-height-base) var(--ck-font-face);
	color: var(--ck-color-text);
	text-align: left;
	white-space: nowrap;
	cursor: auto;
	float: none;
}

.ck-reset_all {
	& .ck-rtl *:not(.ck-reset_all-excluded *) {
		text-align: right;
	}

	& iframe:not(.ck-reset_all-excluded *) {
		/* For IE */
		vertical-align: inherit;
	}

	& textarea:not(.ck-reset_all-excluded *) {
		white-space: pre-wrap;
	}

	& textarea:not(.ck-reset_all-excluded *),
	& input[type="text"]:not(.ck-reset_all-excluded *),
	& input[type="password"]:not(.ck-reset_all-excluded *) {
		cursor: text;
	}

	& textarea[disabled]:not(.ck-reset_all-excluded *),
	& input[type="text"][disabled]:not(.ck-reset_all-excluded *),
	& input[type="password"][disabled]:not(.ck-reset_all-excluded *) {
		cursor: default;
	}

	& fieldset:not(.ck-reset_all-excluded *) {
		padding: 10px;
		border: 2px groove hsl(255, 7%, 88%);
	}

	& button:not(.ck-reset_all-excluded *)::-moz-focus-inner {
		/* See http://stackoverflow.com/questions/5517744/remove-extra-button-spacing-padding-in-firefox */
		padding: 0;
		border: 0
	}
}

/**
 * Default UI rules for RTL languages.
 */
.ck[dir="rtl"],
.ck[dir="rtl"] .ck {
	text-align: right;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * Default border-radius value.
 */
:root{
	--ck-border-radius: 2px;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	/**
	 * A visual style of element's inner shadow (i.e. input).
	 */
	--ck-inner-shadow: 2px 2px 3px var(--ck-color-shadow-inner) inset;

	/**
	 * A visual style of element's drop shadow (i.e. panel).
	 */
	--ck-drop-shadow: 0 1px 2px 1px var(--ck-color-shadow-drop);

	/**
	 * A visual style of element's active shadow (i.e. comment or suggestion).
	 */
	--ck-drop-shadow-active: 0 3px 6px 1px var(--ck-color-shadow-drop-active);
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-spacing-unit: 						0.6em;
	--ck-spacing-large: 					calc(var(--ck-spacing-unit) * 1.5);
	--ck-spacing-standard: 					var(--ck-spacing-unit);
	--ck-spacing-medium: 					calc(var(--ck-spacing-unit) * 0.8);
	--ck-spacing-small: 					calc(var(--ck-spacing-unit) * 0.5);
	--ck-spacing-tiny: 						calc(var(--ck-spacing-unit) * 0.3);
	--ck-spacing-extra-tiny: 				calc(var(--ck-spacing-unit) * 0.16);
}
`],sourceRoot:""}]);const O=P},3488:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,":root{--ck-color-resizer:var(--ck-color-focus-border);--ck-color-resizer-tooltip-background:#262626;--ck-color-resizer-tooltip-text:#f2f2f2;--ck-resizer-border-radius:var(--ck-border-radius);--ck-resizer-tooltip-offset:10px;--ck-resizer-tooltip-height:calc(var(--ck-spacing-small)*2 + 10px)}.ck .ck-widget,.ck .ck-widget.ck-widget_with-selection-handle{position:relative}.ck .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle{position:absolute}.ck .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle .ck-icon{display:block}.ck .ck-widget.ck-widget_with-selection-handle.ck-widget_selected>.ck-widget__selection-handle,.ck .ck-widget.ck-widget_with-selection-handle:hover>.ck-widget__selection-handle{visibility:visible}.ck .ck-size-view{background:var(--ck-color-resizer-tooltip-background);border:1px solid var(--ck-color-resizer-tooltip-text);border-radius:var(--ck-resizer-border-radius);color:var(--ck-color-resizer-tooltip-text);display:block;font-size:var(--ck-font-size-tiny);height:var(--ck-resizer-tooltip-height);line-height:var(--ck-resizer-tooltip-height);padding:0 var(--ck-spacing-small)}.ck .ck-size-view.ck-orientation-above-center,.ck .ck-size-view.ck-orientation-bottom-left,.ck .ck-size-view.ck-orientation-bottom-right,.ck .ck-size-view.ck-orientation-top-left,.ck .ck-size-view.ck-orientation-top-right{position:absolute}.ck .ck-size-view.ck-orientation-top-left{left:var(--ck-resizer-tooltip-offset);top:var(--ck-resizer-tooltip-offset)}.ck .ck-size-view.ck-orientation-top-right{right:var(--ck-resizer-tooltip-offset);top:var(--ck-resizer-tooltip-offset)}.ck .ck-size-view.ck-orientation-bottom-right{bottom:var(--ck-resizer-tooltip-offset);right:var(--ck-resizer-tooltip-offset)}.ck .ck-size-view.ck-orientation-bottom-left{bottom:var(--ck-resizer-tooltip-offset);left:var(--ck-resizer-tooltip-offset)}.ck .ck-size-view.ck-orientation-above-center{left:50%;top:calc(var(--ck-resizer-tooltip-height)*-1);transform:translate(-50%)}:root{--ck-widget-outline-thickness:3px;--ck-widget-handler-icon-size:16px;--ck-widget-handler-animation-duration:200ms;--ck-widget-handler-animation-curve:ease;--ck-color-widget-blurred-border:#dedede;--ck-color-widget-hover-border:#ffc83d;--ck-color-widget-editable-focus-background:var(--ck-color-base-background);--ck-color-widget-drag-handler-icon-color:var(--ck-color-base-background)}.ck .ck-widget{outline-color:transparent;outline-style:solid;outline-width:var(--ck-widget-outline-thickness);transition:outline-color var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve)}.ck .ck-widget.ck-widget_selected,.ck .ck-widget.ck-widget_selected:hover{outline:var(--ck-widget-outline-thickness) solid var(--ck-color-focus-border)}.ck .ck-widget:hover{outline-color:var(--ck-color-widget-hover-border)}.ck .ck-editor__nested-editable{border:1px solid transparent}.ck .ck-editor__nested-editable.ck-editor__nested-editable_focused,.ck .ck-editor__nested-editable:focus{background-color:var(--ck-color-widget-editable-focus-background);border:var(--ck-focus-ring);box-shadow:var(--ck-inner-shadow),0 0;outline:none}.ck .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle{background-color:transparent;border-radius:var(--ck-border-radius) var(--ck-border-radius) 0 0;box-sizing:border-box;left:calc(0px - var(--ck-widget-outline-thickness));opacity:0;padding:4px;top:0;transform:translateY(-100%);transition:background-color var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve),visibility var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve),opacity var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve)}.ck .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle .ck-icon{color:var(--ck-color-widget-drag-handler-icon-color);height:var(--ck-widget-handler-icon-size);width:var(--ck-widget-handler-icon-size)}.ck .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle .ck-icon .ck-icon__selected-indicator{opacity:0;transition:opacity .3s var(--ck-widget-handler-animation-curve)}.ck .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle:hover .ck-icon .ck-icon__selected-indicator{opacity:1}.ck .ck-widget.ck-widget_with-selection-handle:hover>.ck-widget__selection-handle{background-color:var(--ck-color-widget-hover-border);opacity:1}.ck .ck-widget.ck-widget_with-selection-handle.ck-widget_selected:hover>.ck-widget__selection-handle,.ck .ck-widget.ck-widget_with-selection-handle.ck-widget_selected>.ck-widget__selection-handle{background-color:var(--ck-color-focus-border);opacity:1}.ck .ck-widget.ck-widget_with-selection-handle.ck-widget_selected:hover>.ck-widget__selection-handle .ck-icon .ck-icon__selected-indicator,.ck .ck-widget.ck-widget_with-selection-handle.ck-widget_selected>.ck-widget__selection-handle .ck-icon .ck-icon__selected-indicator{opacity:1}.ck[dir=rtl] .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle{left:auto;right:calc(0px - var(--ck-widget-outline-thickness))}.ck.ck-editor__editable.ck-read-only .ck-widget{transition:none}.ck.ck-editor__editable.ck-read-only .ck-widget:not(.ck-widget_selected){--ck-widget-outline-thickness:0px}.ck.ck-editor__editable.ck-read-only .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle,.ck.ck-editor__editable.ck-read-only .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle:hover{background:var(--ck-color-widget-blurred-border)}.ck.ck-editor__editable.ck-blurred .ck-widget.ck-widget_selected,.ck.ck-editor__editable.ck-blurred .ck-widget.ck-widget_selected:hover{outline-color:var(--ck-color-widget-blurred-border)}.ck.ck-editor__editable.ck-blurred .ck-widget.ck-widget_selected.ck-widget_with-selection-handle:hover>.ck-widget__selection-handle,.ck.ck-editor__editable.ck-blurred .ck-widget.ck-widget_selected.ck-widget_with-selection-handle:hover>.ck-widget__selection-handle:hover,.ck.ck-editor__editable.ck-blurred .ck-widget.ck-widget_selected.ck-widget_with-selection-handle>.ck-widget__selection-handle,.ck.ck-editor__editable.ck-blurred .ck-widget.ck-widget_selected.ck-widget_with-selection-handle>.ck-widget__selection-handle:hover{background:var(--ck-color-widget-blurred-border)}.ck.ck-editor__editable blockquote>.ck-widget.ck-widget_with-selection-handle:first-child,.ck.ck-editor__editable>.ck-widget.ck-widget_with-selection-handle:first-child{margin-top:calc(1em + var(--ck-widget-handler-icon-size))}","",{version:3,sources:["webpack://./../ckeditor5-widget/theme/widget.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-widget/widget.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_focus.css","webpack://./../ckeditor5-theme-lark/theme/mixins/_shadow.css"],names:[],mappings:"AAKA,MACC,+CAAgD,CAChD,6CAAsD,CACtD,uCAAgD,CAEhD,kDAAmD,CACnD,gCAAiC,CACjC,kEACD,CAOA,8DAEC,iBAqBD,CAnBC,4EACC,iBAOD,CALC,qFAGC,aACD,CASD,iLACC,kBACD,CAGD,kBACC,qDAAsD,CAEtD,qDAAsD,CACtD,6CAA8C,CAF9C,0CAA2C,CAI3C,aAAc,CADd,kCAAmC,CAGnC,uCAAwC,CACxC,4CAA6C,CAF7C,iCAsCD,CAlCC,8NAKC,iBACD,CAEA,0CAEC,qCAAsC,CADtC,oCAED,CAEA,2CAEC,sCAAuC,CADvC,oCAED,CAEA,8CACC,uCAAwC,CACxC,sCACD,CAEA,6CACC,uCAAwC,CACxC,qCACD,CAGA,8CAEC,QAAS,CADT,6CAAgD,CAEhD,yBACD,CCjFD,MACC,iCAAkC,CAClC,kCAAmC,CACnC,4CAA6C,CAC7C,wCAAyC,CAEzC,wCAAiD,CACjD,sCAAkD,CAClD,2EAA4E,CAC5E,yEACD,CAEA,eAGC,yBAA0B,CAD1B,mBAAoB,CADpB,gDAAiD,CAGjD,6GAUD,CARC,0EAEC,6EACD,CAEA,qBACC,iDACD,CAGD,gCACC,4BAWD,CAPC,yGAKC,iEAAkE,CCnCnE,2BAA2B,CCF3B,qCAA8B,CDC9B,YDqCA,CAIA,4EAKC,4BAA6B,CAa7B,iEAAkE,CAhBlE,qBAAsB,CAoBtB,mDAAoD,CAhBpD,SAAU,CALV,WAAY,CAsBZ,KAAM,CAFN,2BAA4B,CAT5B,6SAgCD,CAnBC,qFAIC,oDAAqD,CADrD,yCAA0C,CAD1C,wCAWD,CANC,kHACC,SAAU,CAGV,+DACD,CAID,wHACC,SACD,CAID,kFAEC,oDAAqD,CADrD,SAED,CAKC,oMAEC,6CAA8C,CAD9C,SAOD,CAHC,gRACC,SACD,CAOH,qFACC,SAAU,CACV,oDACD,CAGA,gDAEC,eAkBD,CAhBC,yEAOC,iCACD,CAGC,gOAEC,gDACD,CAOD,wIAEC,mDAQD,CALE,ghBAEC,gDACD,CAKH,yKAOC,yDACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-color-resizer: var(--ck-color-focus-border);
	--ck-color-resizer-tooltip-background: hsl(0, 0%, 15%);
	--ck-color-resizer-tooltip-text: hsl(0, 0%, 95%);

	--ck-resizer-border-radius: var(--ck-border-radius);
	--ck-resizer-tooltip-offset: 10px;
	--ck-resizer-tooltip-height: calc(var(--ck-spacing-small) * 2 + 10px);
}

.ck .ck-widget {
	/* This is neccessary for type around UI to be positioned properly. */
	position: relative;
}

.ck .ck-widget.ck-widget_with-selection-handle {
	/* Make the widget wrapper a relative positioning container for the drag handle. */
	position: relative;

	& .ck-widget__selection-handle {
		position: absolute;

		& .ck-icon {
			/* Make sure the icon in not a subject to font-size or line-height to avoid
			unnecessary spacing around it. */
			display: block;
		}
	}

	/* Show the selection handle on mouse hover over the widget, but not for nested widgets. */
	&:hover > .ck-widget__selection-handle {
		visibility: visible;
	}

	/* Show the selection handle when the widget is selected, but not for nested widgets. */
	&.ck-widget_selected > .ck-widget__selection-handle {
		visibility: visible;
	}
}

.ck .ck-size-view {
	background: var(--ck-color-resizer-tooltip-background);
	color: var(--ck-color-resizer-tooltip-text);
	border: 1px solid var(--ck-color-resizer-tooltip-text);
	border-radius: var(--ck-resizer-border-radius);
	font-size: var(--ck-font-size-tiny);
	display: block;
	padding: 0 var(--ck-spacing-small);
	height: var(--ck-resizer-tooltip-height);
	line-height: var(--ck-resizer-tooltip-height);

	&.ck-orientation-top-left,
	&.ck-orientation-top-right,
	&.ck-orientation-bottom-right,
	&.ck-orientation-bottom-left,
	&.ck-orientation-above-center {
		position: absolute;
	}

	&.ck-orientation-top-left {
		top: var(--ck-resizer-tooltip-offset);
		left: var(--ck-resizer-tooltip-offset);
	}

	&.ck-orientation-top-right {
		top: var(--ck-resizer-tooltip-offset);
		right: var(--ck-resizer-tooltip-offset);
	}

	&.ck-orientation-bottom-right {
		bottom: var(--ck-resizer-tooltip-offset);
		right: var(--ck-resizer-tooltip-offset);
	}

	&.ck-orientation-bottom-left {
		bottom: var(--ck-resizer-tooltip-offset);
		left: var(--ck-resizer-tooltip-offset);
	}

	/* Class applied if the widget is too small to contain the size label */
	&.ck-orientation-above-center {
		top: calc(var(--ck-resizer-tooltip-height) * -1);
		left: 50%;
		transform: translate(-50%);
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

@import "../mixins/_focus.css";
@import "../mixins/_shadow.css";

:root {
	--ck-widget-outline-thickness: 3px;
	--ck-widget-handler-icon-size: 16px;
	--ck-widget-handler-animation-duration: 200ms;
	--ck-widget-handler-animation-curve: ease;

	--ck-color-widget-blurred-border: hsl(0, 0%, 87%);
	--ck-color-widget-hover-border: hsl(43, 100%, 62%);
	--ck-color-widget-editable-focus-background: var(--ck-color-base-background);
	--ck-color-widget-drag-handler-icon-color: var(--ck-color-base-background);
}

.ck .ck-widget {
	outline-width: var(--ck-widget-outline-thickness);
	outline-style: solid;
	outline-color: transparent;
	transition: outline-color var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve);

	&.ck-widget_selected,
	&.ck-widget_selected:hover {
		outline: var(--ck-widget-outline-thickness) solid var(--ck-color-focus-border);
	}

	&:hover {
		outline-color: var(--ck-color-widget-hover-border);
	}
}

.ck .ck-editor__nested-editable {
	border: 1px solid transparent;

	/* The :focus style is applied before .ck-editor__nested-editable_focused class is rendered in the view.
	These styles show a different border for a blink of an eye, so \`:focus\` need to have same styles applied. */
	&.ck-editor__nested-editable_focused,
	&:focus {
		@mixin ck-focus-ring;
		@mixin ck-box-shadow var(--ck-inner-shadow);

		background-color: var(--ck-color-widget-editable-focus-background);
	}
}

.ck .ck-widget.ck-widget_with-selection-handle {
	& .ck-widget__selection-handle {
		padding: 4px;
		box-sizing: border-box;

		/* Background and opacity will be animated as the handler shows up or the widget gets selected. */
		background-color: transparent;
		opacity: 0;

		/* Transition:
		   * background-color for the .ck-widget_selected state change,
		   * visibility for hiding the handler,
		   * opacity for the proper look of the icon when the handler disappears. */
		transition:
			background-color var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve),
			visibility var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve),
			opacity var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve);

		/* Make only top corners round. */
		border-radius: var(--ck-border-radius) var(--ck-border-radius) 0 0;

		/* Place the drag handler outside the widget wrapper. */
		transform: translateY(-100%);
		left: calc(0px - var(--ck-widget-outline-thickness));
		top: 0;

		& .ck-icon {
			/* Make sure the dimensions of the icon are independent of the fon-size of the content. */
			width: var(--ck-widget-handler-icon-size);
			height: var(--ck-widget-handler-icon-size);
			color: var(--ck-color-widget-drag-handler-icon-color);

			/* The "selected" part of the icon is invisible by default */
			& .ck-icon__selected-indicator {
				opacity: 0;

				/* Note: The animation is longer on purpose. Simply feels better. */
				transition: opacity 300ms var(--ck-widget-handler-animation-curve);
			}
		}

		/* Advertise using the look of the icon that once clicked the handler, the widget will be selected. */
		&:hover .ck-icon .ck-icon__selected-indicator {
			opacity: 1;
		}
	}

	/* Show the selection handler on mouse hover over the widget, but not for nested widgets. */
	&:hover > .ck-widget__selection-handle {
		opacity: 1;
		background-color: var(--ck-color-widget-hover-border);
	}

	/* Show the selection handler when the widget is selected, but not for nested widgets. */
	&.ck-widget_selected,
	&.ck-widget_selected:hover {
		& > .ck-widget__selection-handle {
			opacity: 1;
			background-color: var(--ck-color-focus-border);

			/* When the widget is selected, notify the user using the proper look of the icon. */
			& .ck-icon .ck-icon__selected-indicator {
				opacity: 1;
			}
		}
	}
}

/* In a RTL environment, align the selection handler to the right side of the widget */
/* stylelint-disable-next-line no-descending-specificity */
.ck[dir="rtl"] .ck-widget.ck-widget_with-selection-handle .ck-widget__selection-handle {
	left: auto;
	right: calc(0px - var(--ck-widget-outline-thickness));
}

/* https://github.com/ckeditor/ckeditor5/issues/6415 */
.ck.ck-editor__editable.ck-read-only .ck-widget {
	/* Prevent the :hover outline from showing up because of the used outline-color transition. */
	transition: none;

	&:not(.ck-widget_selected) {
		/* Disable visual effects of hover/active widget when CKEditor is in readOnly mode.
		 * See: https://github.com/ckeditor/ckeditor5/issues/1261
		 *
		 * Leave the unit because this custom property is used in calc() by other features.
		 * See: https://github.com/ckeditor/ckeditor5/issues/6775
		 */
		--ck-widget-outline-thickness: 0px;
	}

	&.ck-widget_with-selection-handle {
		& .ck-widget__selection-handle,
		& .ck-widget__selection-handle:hover {
			background: var(--ck-color-widget-blurred-border);
		}
	}
}

/* Style the widget when it's selected but the editable it belongs to lost focus. */
/* stylelint-disable-next-line no-descending-specificity */
.ck.ck-editor__editable.ck-blurred .ck-widget {
	&.ck-widget_selected,
	&.ck-widget_selected:hover {
		outline-color: var(--ck-color-widget-blurred-border);

		&.ck-widget_with-selection-handle {
			& > .ck-widget__selection-handle,
			& > .ck-widget__selection-handle:hover {
				background: var(--ck-color-widget-blurred-border);
			}
		}
	}
}

.ck.ck-editor__editable > .ck-widget.ck-widget_with-selection-handle:first-child,
.ck.ck-editor__editable blockquote > .ck-widget.ck-widget_with-selection-handle:first-child {
	/* Do not crop selection handler if a widget is a first-child in the blockquote or in the root editable.
	In fact, anything with overflow: hidden.
	https://github.com/ckeditor/ckeditor5-block-quote/issues/28
	https://github.com/ckeditor/ckeditor5-widget/issues/44
	https://github.com/ckeditor/ckeditor5-widget/issues/66 */
	margin-top: calc(1em + var(--ck-widget-handler-icon-size));
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A visual style of focused element's border.
 */
@define-mixin ck-focus-ring {
	/* Disable native outline. */
	outline: none;
	border: var(--ck-focus-ring)
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/**
 * A helper to combine multiple shadows.
 */
@define-mixin ck-box-shadow $shadowA, $shadowB: 0 0 {
	box-shadow: $shadowA, $shadowB;
}

/**
 * Gives an element a drop shadow so it looks like a floating panel.
 */
@define-mixin ck-drop-shadow {
	@mixin ck-box-shadow var(--ck-drop-shadow);
}
`],sourceRoot:""}]);const O=P},8506:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,".ck .ck-widget_with-resizer{position:relative}.ck .ck-widget__resizer{display:none;left:0;pointer-events:none;position:absolute;top:0}.ck-focused .ck-widget_with-resizer.ck-widget_selected>.ck-widget__resizer{display:block}.ck .ck-widget__resizer__handle{pointer-events:all;position:absolute}.ck .ck-widget__resizer__handle.ck-widget__resizer__handle-bottom-right,.ck .ck-widget__resizer__handle.ck-widget__resizer__handle-top-left{cursor:nwse-resize}.ck .ck-widget__resizer__handle.ck-widget__resizer__handle-bottom-left,.ck .ck-widget__resizer__handle.ck-widget__resizer__handle-top-right{cursor:nesw-resize}:root{--ck-resizer-size:10px;--ck-resizer-offset:calc(var(--ck-resizer-size)/-2 - 2px);--ck-resizer-border-width:1px}.ck .ck-widget__resizer{outline:1px solid var(--ck-color-resizer)}.ck .ck-widget__resizer__handle{background:var(--ck-color-focus-border);border:var(--ck-resizer-border-width) solid #fff;border-radius:var(--ck-resizer-border-radius);height:var(--ck-resizer-size);width:var(--ck-resizer-size)}.ck .ck-widget__resizer__handle.ck-widget__resizer__handle-top-left{left:var(--ck-resizer-offset);top:var(--ck-resizer-offset)}.ck .ck-widget__resizer__handle.ck-widget__resizer__handle-top-right{right:var(--ck-resizer-offset);top:var(--ck-resizer-offset)}.ck .ck-widget__resizer__handle.ck-widget__resizer__handle-bottom-right{bottom:var(--ck-resizer-offset);right:var(--ck-resizer-offset)}.ck .ck-widget__resizer__handle.ck-widget__resizer__handle-bottom-left{bottom:var(--ck-resizer-offset);left:var(--ck-resizer-offset)}","",{version:3,sources:["webpack://./../ckeditor5-widget/theme/widgetresize.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-widget/widgetresize.css"],names:[],mappings:"AAKA,4BAEC,iBACD,CAEA,wBACC,YAAa,CAMb,MAAO,CAFP,mBAAoB,CAHpB,iBAAkB,CAMlB,KACD,CAGC,2EACC,aACD,CAGD,gCAIC,kBAAmB,CAHnB,iBAcD,CATC,4IAEC,kBACD,CAEA,4IAEC,kBACD,CCpCD,MACC,sBAAuB,CAGvB,yDAAiE,CACjE,6BACD,CAEA,wBACC,yCACD,CAEA,gCAGC,uCAAwC,CACxC,gDAA6D,CAC7D,6CAA8C,CAH9C,6BAA8B,CAD9B,4BAyBD,CAnBC,oEAEC,6BAA8B,CAD9B,4BAED,CAEA,qEAEC,8BAA+B,CAD/B,4BAED,CAEA,wEACC,+BAAgC,CAChC,8BACD,CAEA,uEACC,+BAAgC,CAChC,6BACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck .ck-widget_with-resizer {
	/* Make the widget wrapper a relative positioning container for the drag handle. */
	position: relative;
}

.ck .ck-widget__resizer {
	display: none;
	position: absolute;

	/* The wrapper itself should not interfere with the pointer device, only the handles should. */
	pointer-events: none;

	left: 0;
	top: 0;
}

.ck-focused .ck-widget_with-resizer.ck-widget_selected {
	& > .ck-widget__resizer {
		display: block;
	}
}

.ck .ck-widget__resizer__handle {
	position: absolute;

	/* Resizers are the only UI elements that should interfere with a pointer device. */
	pointer-events: all;

	&.ck-widget__resizer__handle-top-left,
	&.ck-widget__resizer__handle-bottom-right {
		cursor: nwse-resize;
	}

	&.ck-widget__resizer__handle-top-right,
	&.ck-widget__resizer__handle-bottom-left {
		cursor: nesw-resize;
	}
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-resizer-size: 10px;

	/* Set the resizer with a 50% offset. */
	--ck-resizer-offset: calc( ( var(--ck-resizer-size) / -2 ) - 2px);
	--ck-resizer-border-width: 1px;
}

.ck .ck-widget__resizer {
	outline: 1px solid var(--ck-color-resizer);
}

.ck .ck-widget__resizer__handle {
	width: var(--ck-resizer-size);
	height: var(--ck-resizer-size);
	background: var(--ck-color-focus-border);
	border: var(--ck-resizer-border-width) solid hsl(0, 0%, 100%);
	border-radius: var(--ck-resizer-border-radius);

	&.ck-widget__resizer__handle-top-left {
		top: var(--ck-resizer-offset);
		left: var(--ck-resizer-offset);
	}

	&.ck-widget__resizer__handle-top-right {
		top: var(--ck-resizer-offset);
		right: var(--ck-resizer-offset);
	}

	&.ck-widget__resizer__handle-bottom-right {
		bottom: var(--ck-resizer-offset);
		right: var(--ck-resizer-offset);
	}

	&.ck-widget__resizer__handle-bottom-left {
		bottom: var(--ck-resizer-offset);
		left: var(--ck-resizer-offset);
	}
}
`],sourceRoot:""}]);const O=P},4921:(_,y,k)=>{k.d(y,{Z:()=>O});var T=k(1799),M=k.n(T),B=k(2609),P=k.n(B)()(M());P.push([_.id,'.ck .ck-widget .ck-widget__type-around__button{display:block;overflow:hidden;position:absolute;z-index:var(--ck-z-default)}.ck .ck-widget .ck-widget__type-around__button svg{left:50%;position:absolute;top:50%;z-index:calc(var(--ck-z-default) + 2)}.ck .ck-widget .ck-widget__type-around__button.ck-widget__type-around__button_before{left:min(10%,30px);top:calc(var(--ck-widget-outline-thickness)*-.5);transform:translateY(-50%)}.ck .ck-widget .ck-widget__type-around__button.ck-widget__type-around__button_after{bottom:calc(var(--ck-widget-outline-thickness)*-.5);right:min(10%,30px);transform:translateY(50%)}.ck .ck-widget.ck-widget_selected>.ck-widget__type-around>.ck-widget__type-around__button:after,.ck .ck-widget>.ck-widget__type-around>.ck-widget__type-around__button:hover:after{content:"";display:block;left:1px;position:absolute;top:1px;z-index:calc(var(--ck-z-default) + 1)}.ck .ck-widget>.ck-widget__type-around>.ck-widget__type-around__fake-caret{display:none;left:0;position:absolute;right:0}.ck .ck-widget:hover>.ck-widget__type-around>.ck-widget__type-around__fake-caret{left:calc(var(--ck-widget-outline-thickness)*-1);right:calc(var(--ck-widget-outline-thickness)*-1)}.ck .ck-widget.ck-widget_type-around_show-fake-caret_before>.ck-widget__type-around>.ck-widget__type-around__fake-caret{display:block;top:calc(var(--ck-widget-outline-thickness)*-1 - 1px)}.ck .ck-widget.ck-widget_type-around_show-fake-caret_after>.ck-widget__type-around>.ck-widget__type-around__fake-caret{bottom:calc(var(--ck-widget-outline-thickness)*-1 - 1px);display:block}.ck.ck-editor__editable.ck-read-only .ck-widget__type-around,.ck.ck-editor__editable.ck-restricted-editing_mode_restricted .ck-widget__type-around,.ck.ck-editor__editable.ck-widget__type-around_disabled .ck-widget__type-around{display:none}:root{--ck-widget-type-around-button-size:20px;--ck-color-widget-type-around-button-active:var(--ck-color-focus-border);--ck-color-widget-type-around-button-hover:var(--ck-color-widget-hover-border);--ck-color-widget-type-around-button-blurred-editable:var(--ck-color-widget-blurred-border);--ck-color-widget-type-around-button-radar-start-alpha:0;--ck-color-widget-type-around-button-radar-end-alpha:.3;--ck-color-widget-type-around-button-icon:var(--ck-color-base-background)}.ck .ck-widget .ck-widget__type-around__button{background:var(--ck-color-widget-type-around-button);border-radius:100px;height:var(--ck-widget-type-around-button-size);opacity:0;pointer-events:none;transition:opacity var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve),background var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve);width:var(--ck-widget-type-around-button-size)}.ck .ck-widget .ck-widget__type-around__button svg{height:8px;margin-top:1px;transform:translate(-50%,-50%);transition:transform .5s ease;width:10px}.ck .ck-widget .ck-widget__type-around__button svg *{stroke-dasharray:10;stroke-dashoffset:0;fill:none;stroke:var(--ck-color-widget-type-around-button-icon);stroke-width:1.5px;stroke-linecap:round;stroke-linejoin:round}.ck .ck-widget .ck-widget__type-around__button svg line{stroke-dasharray:7}.ck .ck-widget .ck-widget__type-around__button:hover{animation:ck-widget-type-around-button-sonar 1s ease infinite}.ck .ck-widget .ck-widget__type-around__button:hover svg polyline{animation:ck-widget-type-around-arrow-dash 2s linear}.ck .ck-widget .ck-widget__type-around__button:hover svg line{animation:ck-widget-type-around-arrow-tip-dash 2s linear}.ck .ck-widget.ck-widget_selected>.ck-widget__type-around>.ck-widget__type-around__button,.ck .ck-widget:hover>.ck-widget__type-around>.ck-widget__type-around__button{opacity:1;pointer-events:auto}.ck .ck-widget:not(.ck-widget_selected)>.ck-widget__type-around>.ck-widget__type-around__button{background:var(--ck-color-widget-type-around-button-hover)}.ck .ck-widget.ck-widget_selected>.ck-widget__type-around>.ck-widget__type-around__button,.ck .ck-widget>.ck-widget__type-around>.ck-widget__type-around__button:hover{background:var(--ck-color-widget-type-around-button-active)}.ck .ck-widget.ck-widget_selected>.ck-widget__type-around>.ck-widget__type-around__button:after,.ck .ck-widget>.ck-widget__type-around>.ck-widget__type-around__button:hover:after{background:linear-gradient(135deg,hsla(0,0%,100%,0),hsla(0,0%,100%,.3));border-radius:100px;height:calc(var(--ck-widget-type-around-button-size) - 2px);width:calc(var(--ck-widget-type-around-button-size) - 2px)}.ck .ck-widget.ck-widget_with-selection-handle>.ck-widget__type-around>.ck-widget__type-around__button_before{margin-left:20px}.ck .ck-widget .ck-widget__type-around__fake-caret{animation:ck-widget-type-around-fake-caret-pulse 1s linear infinite normal forwards;background:var(--ck-color-base-text);height:1px;outline:1px solid hsla(0,0%,100%,.5);pointer-events:none}.ck .ck-widget.ck-widget_selected.ck-widget_type-around_show-fake-caret_after,.ck .ck-widget.ck-widget_selected.ck-widget_type-around_show-fake-caret_before{outline-color:transparent}.ck .ck-widget.ck-widget_type-around_show-fake-caret_after.ck-widget_selected:hover,.ck .ck-widget.ck-widget_type-around_show-fake-caret_before.ck-widget_selected:hover{outline-color:var(--ck-color-widget-hover-border)}.ck .ck-widget.ck-widget_type-around_show-fake-caret_after>.ck-widget__type-around>.ck-widget__type-around__button,.ck .ck-widget.ck-widget_type-around_show-fake-caret_before>.ck-widget__type-around>.ck-widget__type-around__button{opacity:0;pointer-events:none}.ck .ck-widget.ck-widget_type-around_show-fake-caret_after.ck-widget_selected.ck-widget_with-resizer>.ck-widget__resizer,.ck .ck-widget.ck-widget_type-around_show-fake-caret_after.ck-widget_with-selection-handle.ck-widget_selected:hover>.ck-widget__selection-handle,.ck .ck-widget.ck-widget_type-around_show-fake-caret_after.ck-widget_with-selection-handle.ck-widget_selected>.ck-widget__selection-handle,.ck .ck-widget.ck-widget_type-around_show-fake-caret_before.ck-widget_selected.ck-widget_with-resizer>.ck-widget__resizer,.ck .ck-widget.ck-widget_type-around_show-fake-caret_before.ck-widget_with-selection-handle.ck-widget_selected:hover>.ck-widget__selection-handle,.ck .ck-widget.ck-widget_type-around_show-fake-caret_before.ck-widget_with-selection-handle.ck-widget_selected>.ck-widget__selection-handle{opacity:0}.ck[dir=rtl] .ck-widget.ck-widget_with-selection-handle .ck-widget__type-around>.ck-widget__type-around__button_before{margin-left:0;margin-right:20px}.ck-editor__nested-editable.ck-editor__editable_selected .ck-widget.ck-widget_selected>.ck-widget__type-around>.ck-widget__type-around__button,.ck-editor__nested-editable.ck-editor__editable_selected .ck-widget:hover>.ck-widget__type-around>.ck-widget__type-around__button{opacity:0;pointer-events:none}.ck-editor__editable.ck-blurred .ck-widget.ck-widget_selected>.ck-widget__type-around>.ck-widget__type-around__button:not(:hover){background:var(--ck-color-widget-type-around-button-blurred-editable)}.ck-editor__editable.ck-blurred .ck-widget.ck-widget_selected>.ck-widget__type-around>.ck-widget__type-around__button:not(:hover) svg *{stroke:#999}@keyframes ck-widget-type-around-arrow-dash{0%{stroke-dashoffset:10}20%,to{stroke-dashoffset:0}}@keyframes ck-widget-type-around-arrow-tip-dash{0%,20%{stroke-dashoffset:7}40%,to{stroke-dashoffset:0}}@keyframes ck-widget-type-around-button-sonar{0%{box-shadow:0 0 0 0 hsla(var(--ck-color-focus-border-coordinates),var(--ck-color-widget-type-around-button-radar-start-alpha))}50%{box-shadow:0 0 0 5px hsla(var(--ck-color-focus-border-coordinates),var(--ck-color-widget-type-around-button-radar-end-alpha))}to{box-shadow:0 0 0 5px hsla(var(--ck-color-focus-border-coordinates),var(--ck-color-widget-type-around-button-radar-start-alpha))}}@keyframes ck-widget-type-around-fake-caret-pulse{0%{opacity:1}49%{opacity:1}50%{opacity:0}99%{opacity:0}to{opacity:1}}',"",{version:3,sources:["webpack://./../ckeditor5-widget/theme/widgettypearound.css","webpack://./../ckeditor5-theme-lark/theme/ckeditor5-widget/widgettypearound.css"],names:[],mappings:"AASC,+CACC,aAAc,CAEd,eAAgB,CADhB,iBAAkB,CAElB,2BAwBD,CAtBC,mDAGC,QAAS,CAFT,iBAAkB,CAClB,OAAQ,CAER,qCACD,CAEA,qFAGC,kBAAoB,CADpB,gDAAoD,CAGpD,0BACD,CAEA,oFAEC,mDAAuD,CACvD,mBAAqB,CAErB,yBACD,CAUA,mLACC,UAAW,CACX,aAAc,CAGd,QAAS,CAFT,iBAAkB,CAClB,OAAQ,CAER,qCACD,CAMD,2EACC,YAAa,CAEb,MAAO,CADP,iBAAkB,CAElB,OACD,CAOA,iFACC,gDAAqD,CACrD,iDACD,CAKA,wHAEC,aAAc,CADd,qDAED,CAKA,uHACC,wDAA6D,CAC7D,aACD,CAoBD,mOACC,YACD,CC3GA,MACC,wCAAyC,CACzC,wEAAyE,CACzE,8EAA+E,CAC/E,2FAA4F,CAC5F,wDAAyD,CACzD,uDAAwD,CACxD,yEACD,CAgBC,+CAGC,oDAAqD,CACrD,mBAAoB,CAFpB,+CAAgD,CAVjD,SAAU,CACV,mBAAoB,CAYnB,uMAAyM,CAJzM,8CAkDD,CA1CC,mDAEC,UAAW,CAGX,cAAe,CAFf,8BAA+B,CAC/B,6BAA8B,CAH9B,UAoBD,CAdC,qDACC,mBAAoB,CACpB,mBAAoB,CAEpB,SAAU,CACV,qDAAsD,CACtD,kBAAmB,CACnB,oBAAqB,CACrB,qBACD,CAEA,wDACC,kBACD,CAGD,qDAIC,6DAcD,CARE,kEACC,oDACD,CAEA,8DACC,wDACD,CAUF,uKAvED,SAAU,CACV,mBAwEC,CAOD,gGACC,0DACD,CAOA,uKAEC,2DAQD,CANC,mLAIC,uEAAkF,CADlF,mBAAoB,CADpB,2DAA4D,CAD5D,0DAID,CAOD,8GACC,gBACD,CAKA,mDAGC,mFAAoF,CAOpF,oCAAqC,CARrC,UAAW,CAOX,oCAAwC,CARxC,mBAUD,CAOC,6JAEC,yBACD,CAUA,yKACC,iDACD,CAMA,uOAlJD,SAAU,CACV,mBAmJC,CAoBA,6yBACC,SACD,CASF,uHACC,aAAc,CACd,iBACD,CAYG,iRAlMF,SAAU,CACV,mBAmME,CAQH,kIACC,qEAKD,CAHC,wIACC,WACD,CAGD,4CACC,GACC,oBACD,CACA,OACC,mBACD,CACD,CAEA,gDACC,OACC,mBACD,CACA,OACC,mBACD,CACD,CAEA,8CACC,GACC,6HACD,CACA,IACC,6HACD,CACA,GACC,+HACD,CACD,CAEA,kDACC,GACC,SACD,CACA,IACC,SACD,CACA,IACC,SACD,CACA,IACC,SACD,CACA,GACC,SACD,CACD",sourcesContent:[`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

.ck .ck-widget {
	/*
	 * Styles of the type around buttons
	 */
	& .ck-widget__type-around__button {
		display: block;
		position: absolute;
		overflow: hidden;
		z-index: var(--ck-z-default);

		& svg {
			position: absolute;
			top: 50%;
			left: 50%;
			z-index: calc(var(--ck-z-default) + 2);
		}

		&.ck-widget__type-around__button_before {
			/* Place it in the middle of the outline */
			top: calc(-0.5 * var(--ck-widget-outline-thickness));
			left: min(10%, 30px);

			transform: translateY(-50%);
		}

		&.ck-widget__type-around__button_after {
			/* Place it in the middle of the outline */
			bottom: calc(-0.5 * var(--ck-widget-outline-thickness));
			right: min(10%, 30px);

			transform: translateY(50%);
		}
	}

	/*
	 * Styles for the buttons when:
	 * - the widget is selected,
	 * - or the button is being hovered (regardless of the widget state).
	 */
	&.ck-widget_selected > .ck-widget__type-around > .ck-widget__type-around__button,
	& > .ck-widget__type-around > .ck-widget__type-around__button:hover {
		&::after {
			content: "";
			display: block;
			position: absolute;
			top: 1px;
			left: 1px;
			z-index: calc(var(--ck-z-default) + 1);
		}
	}

	/*
	 * Styles for the horizontal "fake caret" which is displayed when the user navigates using the keyboard.
	 */
	& > .ck-widget__type-around > .ck-widget__type-around__fake-caret {
		display: none;
		position: absolute;
		left: 0;
		right: 0;
	}

	/*
	 * When the widget is hovered the "fake caret" would normally be narrower than the
	 * extra outline displayed around the widget. Let's extend the "fake caret" to match
	 * the full width of the widget.
	 */
	&:hover > .ck-widget__type-around > .ck-widget__type-around__fake-caret {
		left: calc( -1 * var(--ck-widget-outline-thickness) );
		right: calc( -1 * var(--ck-widget-outline-thickness) );
	}

	/*
	 * Styles for the horizontal "fake caret" when it should be displayed before the widget (backward keyboard navigation).
	 */
	&.ck-widget_type-around_show-fake-caret_before > .ck-widget__type-around > .ck-widget__type-around__fake-caret {
		top: calc( -1 * var(--ck-widget-outline-thickness) - 1px );
		display: block;
	}

	/*
	 * Styles for the horizontal "fake caret" when it should be displayed after the widget (forward keyboard navigation).
	 */
	&.ck-widget_type-around_show-fake-caret_after > .ck-widget__type-around > .ck-widget__type-around__fake-caret {
		bottom: calc( -1 * var(--ck-widget-outline-thickness) - 1px );
		display: block;
	}
}

/*
 * Integration with the read-only mode of the editor.
 */
.ck.ck-editor__editable.ck-read-only .ck-widget__type-around {
	display: none;
}

/*
 * Integration with the restricted editing mode (feature) of the editor.
 */
.ck.ck-editor__editable.ck-restricted-editing_mode_restricted .ck-widget__type-around {
	display: none;
}

/*
 * Integration with the #isEnabled property of the WidgetTypeAround plugin.
 */
.ck.ck-editor__editable.ck-widget__type-around_disabled .ck-widget__type-around {
	display: none;
}
`,`/*
 * Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

:root {
	--ck-widget-type-around-button-size: 20px;
	--ck-color-widget-type-around-button-active: var(--ck-color-focus-border);
	--ck-color-widget-type-around-button-hover: var(--ck-color-widget-hover-border);
	--ck-color-widget-type-around-button-blurred-editable: var(--ck-color-widget-blurred-border);
	--ck-color-widget-type-around-button-radar-start-alpha: 0;
	--ck-color-widget-type-around-button-radar-end-alpha: .3;
	--ck-color-widget-type-around-button-icon: var(--ck-color-base-background);
}

@define-mixin ck-widget-type-around-button-visible {
	opacity: 1;
	pointer-events: auto;
}

@define-mixin ck-widget-type-around-button-hidden {
	opacity: 0;
	pointer-events: none;
}

.ck .ck-widget {
	/*
	 * Styles of the type around buttons
	 */
	& .ck-widget__type-around__button {
		width: var(--ck-widget-type-around-button-size);
		height: var(--ck-widget-type-around-button-size);
		background: var(--ck-color-widget-type-around-button);
		border-radius: 100px;
		transition: opacity var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve), background var(--ck-widget-handler-animation-duration) var(--ck-widget-handler-animation-curve);

		@mixin ck-widget-type-around-button-hidden;

		& svg {
			width: 10px;
			height: 8px;
			transform: translate(-50%,-50%);
			transition: transform .5s ease;
			margin-top: 1px;

			& * {
				stroke-dasharray: 10;
				stroke-dashoffset: 0;

				fill: none;
				stroke: var(--ck-color-widget-type-around-button-icon);
				stroke-width: 1.5px;
				stroke-linecap: round;
				stroke-linejoin: round;
			}

			& line {
				stroke-dasharray: 7;
			}
		}

		&:hover {
			/*
			 * Display the "sonar" around the button when hovered.
			 */
			animation: ck-widget-type-around-button-sonar 1s ease infinite;

			/*
			 * Animate active button's icon.
			 */
			& svg {
				& polyline {
					animation: ck-widget-type-around-arrow-dash 2s linear;
				}

				& line {
					animation: ck-widget-type-around-arrow-tip-dash 2s linear;
				}
			}
		}
	}

	/*
	 * Show type around buttons when the widget gets selected or being hovered.
	 */
	&.ck-widget_selected,
	&:hover {
		& > .ck-widget__type-around > .ck-widget__type-around__button {
			@mixin ck-widget-type-around-button-visible;
		}
	}

	/*
	 * Styles for the buttons when the widget is NOT selected (but the buttons are visible
	 * and still can be hovered).
	 */
	&:not(.ck-widget_selected) > .ck-widget__type-around > .ck-widget__type-around__button {
		background: var(--ck-color-widget-type-around-button-hover);
	}

	/*
	 * Styles for the buttons when:
	 * - the widget is selected,
	 * - or the button is being hovered (regardless of the widget state).
	 */
	&.ck-widget_selected > .ck-widget__type-around > .ck-widget__type-around__button,
	& > .ck-widget__type-around > .ck-widget__type-around__button:hover {
		background: var(--ck-color-widget-type-around-button-active);

		&::after {
			width: calc(var(--ck-widget-type-around-button-size) - 2px);
			height: calc(var(--ck-widget-type-around-button-size) - 2px);
			border-radius: 100px;
			background: linear-gradient(135deg, hsla(0,0%,100%,0) 0%, hsla(0,0%,100%,.3) 100%);
		}
	}

	/*
	 * Styles for the "before" button when the widget has a selection handle. Because some space
	 * is consumed by the handle, the button must be moved slightly to the right to let it breathe.
	 */
	&.ck-widget_with-selection-handle > .ck-widget__type-around > .ck-widget__type-around__button_before {
		margin-left: 20px;
	}

	/*
	 * Styles for the horizontal "fake caret" which is displayed when the user navigates using the keyboard.
	 */
	& .ck-widget__type-around__fake-caret {
		pointer-events: none;
		height: 1px;
		animation: ck-widget-type-around-fake-caret-pulse linear 1s infinite normal forwards;

		/*
		 * The semi-transparent-outline+background combo improves the contrast
		 * when the background underneath the fake caret is dark.
		 */
		outline: solid 1px hsla(0, 0%, 100%, .5);
		background: var(--ck-color-base-text);
	}

	/*
	 * Styles of the widget when the "fake caret" is blinking (e.g. upon keyboard navigation).
	 * Despite the widget being physically selected in the model, its outline should disappear.
	 */
	&.ck-widget_selected {
		&.ck-widget_type-around_show-fake-caret_before,
		&.ck-widget_type-around_show-fake-caret_after {
			outline-color: transparent;
		}
	}

	&.ck-widget_type-around_show-fake-caret_before,
	&.ck-widget_type-around_show-fake-caret_after {
		/*
		 * When the "fake caret" is visible we simulate that the widget is not selected
		 * (despite being physically selected), so the outline color should be for the
		 * unselected widget.
		 */
		&.ck-widget_selected:hover {
			outline-color: var(--ck-color-widget-hover-border);
		}

		/*
		 * Styles of the type around buttons when the "fake caret" is blinking (e.g. upon keyboard navigation).
		 * In this state, the type around buttons would collide with the fake carets so they should disappear.
		 */
		& > .ck-widget__type-around > .ck-widget__type-around__button {
			@mixin ck-widget-type-around-button-hidden;
		}

		/*
		 * Fake horizontal caret integration with the selection handle. When the caret is visible, simply
		 * hide the handle because it intersects with the caret (and does not make much sense anyway).
		 */
		&.ck-widget_with-selection-handle {
			&.ck-widget_selected,
			&.ck-widget_selected:hover {
				& > .ck-widget__selection-handle {
					opacity: 0
				}
			}
		}

		/*
		 * Fake horizontal caret integration with the resize UI. When the caret is visible, simply
		 * hide the resize UI because it creates too much noise. It can be visible when the user
		 * hovers the widget, though.
		 */
		&.ck-widget_selected.ck-widget_with-resizer > .ck-widget__resizer {
			opacity: 0
		}
	}
}

/*
 * Styles for the "before" button when the widget has a selection handle in an RTL environment.
 * The selection handler is aligned to the right side of the widget so there is no need to create
 * additional space for it next to the "before" button.
 */
.ck[dir="rtl"] .ck-widget.ck-widget_with-selection-handle .ck-widget__type-around > .ck-widget__type-around__button_before {
	margin-left: 0;
	margin-right: 20px;
}

/*
 * Hide type around buttons when the widget is selected as a child of a selected
 * nested editable (e.g. mulit-cell table selection).
 *
 * See https://github.com/ckeditor/ckeditor5/issues/7263.
 */
.ck-editor__nested-editable.ck-editor__editable_selected {
	& .ck-widget {
		&.ck-widget_selected,
		&:hover {
			& > .ck-widget__type-around > .ck-widget__type-around__button {
				@mixin ck-widget-type-around-button-hidden;
			}
		}
	}
}

/*
 * Styles for the buttons when the widget is selected but the user clicked outside of the editor (blurred the editor).
 */
.ck-editor__editable.ck-blurred .ck-widget.ck-widget_selected > .ck-widget__type-around > .ck-widget__type-around__button:not(:hover) {
	background: var(--ck-color-widget-type-around-button-blurred-editable);

	& svg * {
		stroke: hsl(0,0%,60%);
	}
}

@keyframes ck-widget-type-around-arrow-dash {
	0% {
		stroke-dashoffset: 10;
	}
	20%, 100% {
		stroke-dashoffset: 0;
	}
}

@keyframes ck-widget-type-around-arrow-tip-dash {
	0%, 20% {
		stroke-dashoffset: 7;
	}
	40%, 100% {
		stroke-dashoffset: 0;
	}
}

@keyframes ck-widget-type-around-button-sonar {
	0% {
		box-shadow: 0 0 0 0 hsla(var(--ck-color-focus-border-coordinates), var(--ck-color-widget-type-around-button-radar-start-alpha));
	}
	50% {
		box-shadow: 0 0 0 5px hsla(var(--ck-color-focus-border-coordinates), var(--ck-color-widget-type-around-button-radar-end-alpha));
	}
	100% {
		box-shadow: 0 0 0 5px hsla(var(--ck-color-focus-border-coordinates), var(--ck-color-widget-type-around-button-radar-start-alpha));
	}
}

@keyframes ck-widget-type-around-fake-caret-pulse {
	0% {
		opacity: 1;
	}
	49% {
		opacity: 1;
	}
	50% {
		opacity: 0;
	}
	99% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
`],sourceRoot:""}]);const O=P},2609:_=>{_.exports=function(y){var k=[];return k.toString=function(){return this.map(function(T){var M=y(T);return T[2]?"@media ".concat(T[2]," {").concat(M,"}"):M}).join("")},k.i=function(T,M,B){typeof T=="string"&&(T=[[null,T,""]]);var P={};if(B)for(var O=0;O<this.length;O++){var q=this[O][0];q!=null&&(P[q]=!0)}for(var Q=0;Q<T.length;Q++){var se=[].concat(T[Q]);B&&P[se[0]]||(M&&(se[2]?se[2]="".concat(M," and ").concat(se[2]):se[2]=M),k.push(se))}},k}},1799:_=>{function y(T,M){return function(B){if(Array.isArray(B))return B}(T)||function(B,P){var O=B&&(typeof Symbol<"u"&&B[Symbol.iterator]||B["@@iterator"]);if(O!=null){var q,Q,se=[],ie=!0,K=!1;try{for(O=O.call(B);!(ie=(q=O.next()).done)&&(se.push(q.value),!P||se.length!==P);ie=!0);}catch(Ae){K=!0,Q=Ae}finally{try{ie||O.return==null||O.return()}finally{if(K)throw Q}}return se}}(T,M)||function(B,P){if(B){if(typeof B=="string")return k(B,P);var O=Object.prototype.toString.call(B).slice(8,-1);if(O==="Object"&&B.constructor&&(O=B.constructor.name),O==="Map"||O==="Set")return Array.from(B);if(O==="Arguments"||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(O))return k(B,P)}}(T,M)||function(){throw new TypeError(`Invalid attempt to destructure non-iterable instance.
In order to be iterable, non-array objects must have a [Symbol.iterator]() method.`)}()}function k(T,M){(M==null||M>T.length)&&(M=T.length);for(var B=0,P=new Array(M);B<M;B++)P[B]=T[B];return P}_.exports=function(T){var M=y(T,4),B=M[1],P=M[3];if(!P)return B;if(typeof btoa=="function"){var O=btoa(unescape(encodeURIComponent(JSON.stringify(P)))),q="sourceMappingURL=data:application/json;charset=utf-8;base64,".concat(O),Q="/*# ".concat(q," */"),se=P.sources.map(function(ie){return"/*# sourceURL=".concat(P.sourceRoot||"").concat(ie," */")});return[B].concat(se).concat([Q]).join(`
`)}return[B].join(`
`)}},6062:(_,y,k)=>{var T,M=function(){return T===void 0&&(T=!!(window&&document&&document.all&&!window.atob)),T},B=function(){var x={};return function(we){if(x[we]===void 0){var he=document.querySelector(we);if(window.HTMLIFrameElement&&he instanceof window.HTMLIFrameElement)try{he=he.contentDocument.head}catch{he=null}x[we]=he}return x[we]}}(),P=[];function O(x){for(var we=-1,he=0;he<P.length;he++)if(P[he].identifier===x){we=he;break}return we}function q(x,we){for(var he={},ze=[],Pe=0;Pe<x.length;Pe++){var Ve=x[Pe],me=we.base?Ve[0]+we.base:Ve[0],Me=he[me]||0,He="".concat(me," ").concat(Me);he[me]=Me+1;var dt=O(He),Ce={css:Ve[1],media:Ve[2],sourceMap:Ve[3]};dt!==-1?(P[dt].references++,P[dt].updater(Ce)):P.push({identifier:He,updater:V(Ce,we),references:1}),ze.push(He)}return ze}function Q(x){var we=document.createElement("style"),he=x.attributes||{};if(he.nonce===void 0){var ze=k.nc;ze&&(he.nonce=ze)}if(Object.keys(he).forEach(function(Ve){we.setAttribute(Ve,he[Ve])}),typeof x.insert=="function")x.insert(we);else{var Pe=B(x.insert||"head");if(!Pe)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");Pe.appendChild(we)}return we}var se,ie=(se=[],function(x,we){return se[x]=we,se.filter(Boolean).join(`
`)});function K(x,we,he,ze){var Pe=he?"":ze.media?"@media ".concat(ze.media," {").concat(ze.css,"}"):ze.css;if(x.styleSheet)x.styleSheet.cssText=ie(we,Pe);else{var Ve=document.createTextNode(Pe),me=x.childNodes;me[we]&&x.removeChild(me[we]),me.length?x.insertBefore(Ve,me[we]):x.appendChild(Ve)}}function Ae(x,we,he){var ze=he.css,Pe=he.media,Ve=he.sourceMap;if(Pe?x.setAttribute("media",Pe):x.removeAttribute("media"),Ve&&typeof btoa<"u"&&(ze+=`
/*# sourceMappingURL=data:application/json;base64,`.concat(btoa(unescape(encodeURIComponent(JSON.stringify(Ve))))," */")),x.styleSheet)x.styleSheet.cssText=ze;else{for(;x.firstChild;)x.removeChild(x.firstChild);x.appendChild(document.createTextNode(ze))}}var Ee=null,Se=0;function V(x,we){var he,ze,Pe;if(we.singleton){var Ve=Se++;he=Ee||(Ee=Q(we)),ze=K.bind(null,he,Ve,!1),Pe=K.bind(null,he,Ve,!0)}else he=Q(we),ze=Ae.bind(null,he,we),Pe=function(){(function(me){if(me.parentNode===null)return!1;me.parentNode.removeChild(me)})(he)};return ze(x),function(me){if(me){if(me.css===x.css&&me.media===x.media&&me.sourceMap===x.sourceMap)return;ze(x=me)}else Pe()}}_.exports=function(x,we){(we=we||{}).singleton||typeof we.singleton=="boolean"||(we.singleton=M());var he=q(x=x||[],we);return function(ze){if(ze=ze||[],Object.prototype.toString.call(ze)==="[object Array]"){for(var Pe=0;Pe<he.length;Pe++){var Ve=O(he[Pe]);P[Ve].references--}for(var me=q(ze,we),Me=0;Me<he.length;Me++){var He=O(he[Me]);P[He].references===0&&(P[He].updater(),P.splice(He,1))}he=me}}}}},p={};function w(_){var y=p[_];if(y!==void 0)return y.exports;var k=p[_]={id:_,exports:{}};return g[_](k,k.exports,w),k.exports}w.n=_=>{var y=_&&_.__esModule?()=>_.default:()=>_;return w.d(y,{a:y}),y},w.d=(_,y)=>{for(var k in y)w.o(y,k)&&!w.o(_,k)&&Object.defineProperty(_,k,{enumerable:!0,get:y[k]})},w.g=function(){if(typeof globalThis=="object")return globalThis;try{return this||new Function("return this")()}catch{if(typeof window=="object")return window}}(),w.o=(_,y)=>Object.prototype.hasOwnProperty.call(_,y),w.nc=void 0;var A={};return(()=>{w.d(A,{default:()=>oh});const _=function(){try{return navigator.userAgent.toLowerCase()}catch{return""}}(),y={isMac:T(_),isWindows:function(o){return o.indexOf("windows")>-1}(_),isGecko:function(o){return!!o.match(/gecko\/\d+/)}(_),isSafari:function(o){return o.indexOf(" applewebkit/")>-1&&o.indexOf("chrome")===-1}(_),isiOS:function(o){return!!o.match(/iphone|ipad/i)||T(o)&&navigator.maxTouchPoints>0}(_),isAndroid:function(o){return o.indexOf("android")>-1}(_),isBlink:function(o){return o.indexOf("chrome/")>-1&&o.indexOf("edge/")<0}(_),features:{isRegExpUnicodePropertySupported:function(){let o=!1;try{o="ć".search(new RegExp("[\\p{L}]","u"))===0}catch{}return o}()}},k=y;function T(o){return o.indexOf("macintosh")>-1}function M(o,e,t,n){t=t||function(c,u){return c===u};const i=Array.isArray(o)?o:Array.prototype.slice.call(o),r=Array.isArray(e)?e:Array.prototype.slice.call(e),s=function(c,u,f){const m=B(c,u,f);if(m===-1)return{firstIndex:-1,lastIndexOld:-1,lastIndexNew:-1};const v=P(c,m),E=P(u,m),I=B(v,E,f),L=c.length-I,R=u.length-I;return{firstIndex:m,lastIndexOld:L,lastIndexNew:R}}(i,r,t);return n?function(c,u){const{firstIndex:f,lastIndexOld:m,lastIndexNew:v}=c;if(f===-1)return Array(u).fill("equal");let E=[];return f>0&&(E=E.concat(Array(f).fill("equal"))),v-f>0&&(E=E.concat(Array(v-f).fill("insert"))),m-f>0&&(E=E.concat(Array(m-f).fill("delete"))),v<u&&(E=E.concat(Array(u-v).fill("equal"))),E}(s,r.length):function(c,u){const f=[],{firstIndex:m,lastIndexOld:v,lastIndexNew:E}=u;return E-m>0&&f.push({index:m,type:"insert",values:c.slice(m,E)}),v-m>0&&f.push({index:m+(E-m),type:"delete",howMany:v-m}),f}(r,s)}function B(o,e,t){for(let n=0;n<Math.max(o.length,e.length);n++)if(o[n]===void 0||e[n]===void 0||!t(o[n],e[n]))return n;return-1}function P(o,e){return o.slice(e).reverse()}function O(o,e,t){t=t||function(L,R){return L===R};const n=o.length,i=e.length;if(n>200||i>200||n+i>300)return O.fastDiff(o,e,t,!0);let r,s;if(i<n){const L=o;o=e,e=L,r="delete",s="insert"}else r="insert",s="delete";const a=o.length,c=e.length,u=c-a,f={},m={};function v(L){const R=(m[L-1]!==void 0?m[L-1]:-1)+1,H=m[L+1]!==void 0?m[L+1]:-1,$=R>H?-1:1;f[L+$]&&(f[L]=f[L+$].slice(0)),f[L]||(f[L]=[]),f[L].push(R>H?r:s);let te=Math.max(R,H),ue=te-L;for(;ue<a&&te<c&&t(o[ue],e[te]);)ue++,te++,f[L].push("equal");return te}let E,I=0;do{for(E=-I;E<u;E++)m[E]=v(E);for(E=u+I;E>u;E--)m[E]=v(E);m[u]=v(u),I++}while(m[u]!==c);return f[u].slice(1)}function q(o,...e){e.forEach(t=>{const n=Object.getOwnPropertyNames(t),i=Object.getOwnPropertySymbols(t);n.concat(i).forEach(r=>{if(r in o.prototype||typeof t=="function"&&(r=="length"||r=="name"||r=="prototype"))return;const s=Object.getOwnPropertyDescriptor(t,r);s.enumerable=!1,Object.defineProperty(o.prototype,r,s)})})}O.fastDiff=M;const Q=function(){return function o(){o.called=!0}};class se{constructor(e,t){this.source=e,this.name=t,this.path=[],this.stop=Q(),this.off=Q()}}const ie=new Array(256).fill("").map((o,e)=>("0"+e.toString(16)).slice(-2));function K(){const o=4294967296*Math.random()>>>0,e=4294967296*Math.random()>>>0,t=4294967296*Math.random()>>>0,n=4294967296*Math.random()>>>0;return"e"+ie[o>>0&255]+ie[o>>8&255]+ie[o>>16&255]+ie[o>>24&255]+ie[e>>0&255]+ie[e>>8&255]+ie[e>>16&255]+ie[e>>24&255]+ie[t>>0&255]+ie[t>>8&255]+ie[t>>16&255]+ie[t>>24&255]+ie[n>>0&255]+ie[n>>8&255]+ie[n>>16&255]+ie[n>>24&255]}const Ae={get(o="normal"){return typeof o!="number"?this[o]||this.normal:o},highest:1e5,high:1e3,normal:0,low:-1e3,lowest:-1e5};function Ee(o,e){const t=Ae.get(e.priority);for(let n=0;n<o.length;n++)if(Ae.get(o[n].priority)<t)return void o.splice(n,0,e);o.push(e)}const Se="https://ckeditor.com/docs/ckeditor5/latest/support/error-codes.html";class V extends Error{constructor(e,t,n){super(function(i,r){const s=new WeakSet,a=(f,m)=>{if(typeof m=="object"&&m!==null){if(s.has(m))return`[object ${m.constructor.name}]`;s.add(m)}return m},c=r?` ${JSON.stringify(r,a)}`:"",u=he(i);return i+c+u}(e,n)),this.name="CKEditorError",this.context=t,this.data=n}is(e){return e==="CKEditorError"}static rethrowUnexpectedError(e,t){if(e.is&&e.is("CKEditorError"))throw e;const n=new V(e.message,t);throw n.stack=e.stack,n}}function x(o,e){console.warn(...ze(o,e))}function we(o,e){console.error(...ze(o,e))}function he(o){return`
Read more: ${Se}#error-${o}`}function ze(o,e){const t=he(o);return e?[o,e,t]:[o,t]}const Pe="36.0.1",Ve=typeof window=="object"?window:w.g;if(Ve.CKEDITOR_VERSION)throw new V("ckeditor-duplicated-modules",null);Ve.CKEDITOR_VERSION=Pe;const me=Symbol("listeningTo"),Me=Symbol("emitterId"),He=Symbol("delegations"),dt=Ce(Object);function Ce(o){return o?class extends o{on(e,t,n){this.listenTo(this,e,t,n)}once(e,t,n){let i=!1;this.listenTo(this,e,(r,...s)=>{i||(i=!0,r.off(),t.call(this,r,...s))},n)}off(e,t){this.stopListening(this,e,t)}listenTo(e,t,n,i={}){let r,s;this[me]||(this[me]={});const a=this[me];Nt(e)||_t(e);const c=Nt(e);(r=a[c])||(r=a[c]={emitter:e,callbacks:{}}),(s=r.callbacks[t])||(s=r.callbacks[t]=[]),s.push(n),function(u,f,m,v,E){f._addEventListener?f._addEventListener(m,v,E):u._addEventListener.call(f,m,v,E)}(this,e,t,n,i)}stopListening(e,t,n){const i=this[me];let r=e&&Nt(e);const s=i&&r?i[r]:void 0,a=s&&t?s.callbacks[t]:void 0;if(!(!i||e&&!s||t&&!a))if(n)Qi(this,e,t,n),a.indexOf(n)!==-1&&(a.length===1?delete s.callbacks[t]:Qi(this,e,t,n));else if(a){for(;n=a.pop();)Qi(this,e,t,n);delete s.callbacks[t]}else if(s){for(t in s.callbacks)this.stopListening(e,t);delete i[r]}else{for(r in i)this.stopListening(i[r].emitter);delete this[me]}}fire(e,...t){try{const n=e instanceof se?e:new se(this,e),i=n.name;let r=xn(this,i);if(n.path.push(this),r){const a=[n,...t];r=Array.from(r);for(let c=0;c<r.length&&(r[c].callback.apply(this,a),n.off.called&&(delete n.off.called,this._removeEventListener(i,r[c].callback)),!n.stop.called);c++);}const s=this[He];if(s){const a=s.get(i),c=s.get("*");a&&pi(a,n,t),c&&pi(c,n,t)}return n.return}catch(n){V.rethrowUnexpectedError(n,this)}}delegate(...e){return{to:(t,n)=>{this[He]||(this[He]=new Map),e.forEach(i=>{const r=this[He].get(i);r?r.set(t,n):this[He].set(i,new Map([[t,n]]))})}}}stopDelegating(e,t){if(this[He])if(e)if(t){const n=this[He].get(e);n&&n.delete(t)}else this[He].delete(e);else this[He].clear()}_addEventListener(e,t,n){(function(s,a){const c=dn(s);if(c[a])return;let u=a,f=null;const m=[];for(;u!==""&&!c[u];)c[u]={callbacks:[],childEvents:[]},m.push(c[u]),f&&c[u].childEvents.push(f),f=u,u=u.substr(0,u.lastIndexOf(":"));if(u!==""){for(const v of m)v.callbacks=c[u].callbacks.slice();c[u].childEvents.push(f)}})(this,e);const i=Rn(this,e),r={callback:t,priority:Ae.get(n.priority)};for(const s of i)Ee(s,r)}_removeEventListener(e,t){const n=Rn(this,e);for(const i of n)for(let r=0;r<i.length;r++)i[r].callback==t&&(i.splice(r,1),r--)}}:dt}function _t(o,e){o[Me]||(o[Me]=e||K())}function Nt(o){return o[Me]}function dn(o){return o._events||Object.defineProperty(o,"_events",{value:{}}),o._events}function Rn(o,e){const t=dn(o)[e];if(!t)return[];let n=[t.callbacks];for(let i=0;i<t.childEvents.length;i++){const r=Rn(o,t.childEvents[i]);n=n.concat(r)}return n}function xn(o,e){let t;return o._events&&(t=o._events[e])&&t.callbacks.length?t.callbacks:e.indexOf(":")>-1?xn(o,e.substr(0,e.lastIndexOf(":"))):null}function pi(o,e,t){for(let[n,i]of o){i?typeof i=="function"&&(i=i(e.name)):i=e.name;const r=new se(e.source,i);r.path=[...e.path],n.fire(r,...t)}}function Qi(o,e,t,n){e._removeEventListener?e._removeEventListener(t,n):o._removeEventListener.call(e,t,n)}["on","once","off","listenTo","stopListening","fire","delegate","stopDelegating","_addEventListener","_removeEventListener"].forEach(o=>{Ce[o]=dt.prototype[o]});const ht=function(o){var e=typeof o;return o!=null&&(e=="object"||e=="function")},it=Symbol("observableProperties"),Ct=Symbol("boundObservables"),wr=Symbol("boundProperties"),Zi=Symbol("decoratedMethods"),jn=Symbol("decoratedOriginal"),Ba=Ke(Ce());function Ke(o){return o?class extends o{set(e,t){if(ht(e))return void Object.keys(e).forEach(i=>{this.set(i,e[i])},this);mo(this);const n=this[it];if(e in this&&!n.has(e))throw new V("observable-set-cannot-override",this);Object.defineProperty(this,e,{enumerable:!0,configurable:!0,get:()=>n.get(e),set(i){const r=n.get(e);let s=this.fire(`set:${e}`,e,i,r);s===void 0&&(s=i),r===s&&n.has(e)||(n.set(e,s),this.fire(`change:${e}`,e,s,r))}}),this[e]=t}bind(...e){if(!e.length||!vr(e))throw new V("observable-bind-wrong-properties",this);if(new Set(e).size!==e.length)throw new V("observable-bind-duplicate-properties",this);mo(this);const t=this[wr];e.forEach(i=>{if(t.has(i))throw new V("observable-bind-rebind",this)});const n=new Map;return e.forEach(i=>{const r={property:i,to:[]};t.set(i,r),n.set(i,r)}),{to:La,toMany:Uc,_observable:this,_bindProperties:e,_to:[],_bindings:n}}unbind(...e){if(!this[it])return;const t=this[wr],n=this[Ct];if(e.length){if(!vr(e))throw new V("observable-unbind-wrong-properties",this);e.forEach(i=>{const r=t.get(i);r&&(r.to.forEach(([s,a])=>{const c=n.get(s),u=c[a];u.delete(r),u.size||delete c[a],Object.keys(c).length||(n.delete(s),this.stopListening(s,"change"))}),t.delete(i))})}else n.forEach((i,r)=>{this.stopListening(r,"change")}),n.clear(),t.clear()}decorate(e){mo(this);const t=this[e];if(!t)throw new V("observablemixin-cannot-decorate-undefined",this,{object:this,methodName:e});this.on(e,(n,i)=>{n.return=t.apply(this,i)}),this[e]=function(...n){return this.fire(e,n)},this[e][jn]=t,this[Zi]||(this[Zi]=[]),this[Zi].push(e)}stopListening(e,t,n){if(!e&&this[Zi]){for(const i of this[Zi])this[i]=this[i][jn];delete this[Zi]}super.stopListening(e,t,n)}}:Ba}function mo(o){o[it]||(Object.defineProperty(o,it,{value:new Map}),Object.defineProperty(o,Ct,{value:new Map}),Object.defineProperty(o,wr,{value:new Map}))}function La(...o){const e=function(...r){if(!r.length)throw new V("observable-bind-to-parse-error",null);const s={to:[]};let a;return typeof r[r.length-1]=="function"&&(s.callback=r.pop()),r.forEach(c=>{if(typeof c=="string")a.properties.push(c);else{if(typeof c!="object")throw new V("observable-bind-to-parse-error",null);a={observable:c,properties:[]},s.to.push(a)}}),s}(...o),t=Array.from(this._bindings.keys()),n=t.length;if(!e.callback&&e.to.length>1)throw new V("observable-bind-to-no-callback",this);if(n>1&&e.callback)throw new V("observable-bind-to-extra-callback",this);var i;e.to.forEach(r=>{if(r.properties.length&&r.properties.length!==n)throw new V("observable-bind-to-properties-length",this);r.properties.length||(r.properties=this._bindProperties)}),this._to=e.to,e.callback&&(this._bindings.get(t[0]).callback=e.callback),i=this._observable,this._to.forEach(r=>{const s=i[Ct];let a;s.get(r.observable)||i.listenTo(r.observable,"change",(c,u)=>{a=s.get(r.observable)[u],a&&a.forEach(f=>{Ho(i,f.property)})})}),function(r){let s;r._bindings.forEach((a,c)=>{r._to.forEach(u=>{s=u.properties[a.callback?0:r._bindProperties.indexOf(c)],a.to.push([u.observable,s]),function(f,m,v,E){const I=f[Ct],L=I.get(v),R=L||{};R[E]||(R[E]=new Set),R[E].add(m),L||I.set(v,R)}(r._observable,a,u.observable,s)})})}(this),this._bindProperties.forEach(r=>{Ho(this._observable,r)})}function Uc(o,e,t){if(this._bindings.size>1)throw new V("observable-bind-to-many-not-one-binding",this);this.to(...function(n,i){const r=n.map(s=>[s,i]);return Array.prototype.concat.apply([],r)}(o,e),t)}function vr(o){return o.every(e=>typeof e=="string")}function Ho(o,e){const t=o[wr].get(e);let n;t.callback?n=t.callback.apply(o,t.to.map(i=>i[0][i[1]])):(n=t.to[0],n=n[0][n[1]]),Object.prototype.hasOwnProperty.call(o,e)?o[e]=n:o.set(e,n)}function Fn(o){let e=0;for(const t of o)e++;return e}function Gt(o,e){const t=Math.min(o.length,e.length);for(let n=0;n<t;n++)if(o[n]!=e[n])return n;return o.length==e.length?"same":o.length<e.length?"prefix":"extension"}function bn(o){return!(!o||!o[Symbol.iterator])}["set","bind","unbind","decorate","on","once","off","listenTo","stopListening","fire","delegate","stopDelegating","_addEventListener","_removeEventListener"].forEach(o=>{Ke[o]=Ba.prototype[o]});const za=typeof da=="object"&&da&&da.Object===Object&&da;var Jn=typeof self=="object"&&self&&self.Object===Object&&self;const en=za||Jn||Function("return this")(),un=en.Symbol;var _e=Object.prototype,hn=_e.hasOwnProperty,Wc=_e.toString,Uo=un?un.toStringTag:void 0;const qc=function(o){var e=hn.call(o,Uo),t=o[Uo];try{o[Uo]=void 0;var n=!0}catch{}var i=Wc.call(o);return n&&(e?o[Uo]=t:delete o[Uo]),i};var Oa=Object.prototype.toString;const Ra=function(o){return Oa.call(o)};var Wo="[object Null]",mi="[object Undefined]",Ei=un?un.toStringTag:void 0;const kn=function(o){return o==null?o===void 0?mi:Wo:Ei&&Ei in Object(o)?qc(o):Ra(o)},tn=Array.isArray,nn=function(o){return o!=null&&typeof o=="object"};var ja="[object String]";const us=function(o){return typeof o=="string"||!tn(o)&&nn(o)&&kn(o)==ja};function Fa(o,e,t={},n=[]){const i=t&&t.xmlns,r=i?o.createElementNS(i,e):o.createElement(e);for(const s in t)r.setAttribute(s,t[s]);!us(n)&&bn(n)||(n=[n]);for(let s of n)us(s)&&(s=o.createTextNode(s)),r.appendChild(s);return r}const Ji=function(o,e){return function(t){return o(e(t))}},Xi=Ji(Object.getPrototypeOf,Object);var Va="[object Object]",Ha=Function.prototype,Dn=Object.prototype,on=Ha.toString,hs=Dn.hasOwnProperty,Gc=on.call(Object);const rn=function(o){if(!nn(o)||kn(o)!=Va)return!1;var e=Xi(o);if(e===null)return!0;var t=hs.call(e,"constructor")&&e.constructor;return typeof t=="function"&&t instanceof t&&on.call(t)==Gc},Ua=function(){this.__data__=[],this.size=0},Xn=function(o,e){return o===e||o!=o&&e!=e},bi=function(o,e){for(var t=o.length;t--;)if(Xn(o[t][0],e))return t;return-1};var fs=Array.prototype.splice;const _r=function(o){var e=this.__data__,t=bi(e,o);return!(t<0)&&(t==e.length-1?e.pop():fs.call(e,t,1),--this.size,!0)},$c=function(o){var e=this.__data__,t=bi(e,o);return t<0?void 0:e[t][1]},Yc=function(o){return bi(this.__data__,o)>-1},Kc=function(o,e){var t=this.__data__,n=bi(t,o);return n<0?(++this.size,t.push([o,e])):t[n][1]=e,this};function eo(o){var e=-1,t=o==null?0:o.length;for(this.clear();++e<t;){var n=o[e];this.set(n[0],n[1])}}eo.prototype.clear=Ua,eo.prototype.delete=_r,eo.prototype.get=$c,eo.prototype.has=Yc,eo.prototype.set=Kc;const Cr=eo,Qc=function(){this.__data__=new Cr,this.size=0},Wa=function(o){var e=this.__data__,t=e.delete(o);return this.size=e.size,t},Zc=function(o){return this.__data__.get(o)},bo=function(o){return this.__data__.has(o)};var qa="[object AsyncFunction]",gs="[object Function]",ps="[object GeneratorFunction]",Ar="[object Proxy]";const ko=function(o){if(!ht(o))return!1;var e=kn(o);return e==gs||e==ps||e==qa||e==Ar},ms=en["__core-js_shared__"];var wo=function(){var o=/[^.]+$/.exec(ms&&ms.keys&&ms.keys.IE_PROTO||"");return o?"Symbol(src)_1."+o:""}();const Ga=function(o){return!!wo&&wo in o};var $a=Function.prototype.toString;const Ti=function(o){if(o!=null){try{return $a.call(o)}catch{}try{return o+""}catch{}}return""};var Ya=/^\[object .+?Constructor\]$/,Jc=Function.prototype,bs=Object.prototype,Xc=Jc.toString,ed=bs.hasOwnProperty,Ka=RegExp("^"+Xc.call(ed).replace(/[\\^$.*+?()[\]{}|]/g,"\\$&").replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g,"$1.*?")+"$");const Qa=function(o){return!(!ht(o)||Ga(o))&&(ko(o)?Ka:Ya).test(Ti(o))},ks=function(o,e){return o==null?void 0:o[e]},Si=function(o,e){var t=ks(o,e);return Qa(t)?t:void 0},Ft=Si(en,"Map"),ei=Si(Object,"create"),yr=function(){this.__data__=ei?ei(null):{},this.size=0},td=function(o){var e=this.has(o)&&delete this.__data__[o];return this.size-=e?1:0,e};var nd="__lodash_hash_undefined__",ws=Object.prototype.hasOwnProperty;const Za=function(o){var e=this.__data__;if(ei){var t=e[o];return t===nd?void 0:t}return ws.call(e,o)?e[o]:void 0};var xr=Object.prototype.hasOwnProperty;const Ja=function(o){var e=this.__data__;return ei?e[o]!==void 0:xr.call(e,o)};var id="__lodash_hash_undefined__";const od=function(o,e){var t=this.__data__;return this.size+=this.has(o)?0:1,t[o]=ei&&e===void 0?id:e,this};function $t(o){var e=-1,t=o==null?0:o.length;for(this.clear();++e<t;){var n=o[e];this.set(n[0],n[1])}}$t.prototype.clear=yr,$t.prototype.delete=td,$t.prototype.get=Za,$t.prototype.has=Ja,$t.prototype.set=od;const vs=$t,qo=function(){this.size=0,this.__data__={hash:new vs,map:new(Ft||Cr),string:new vs}},rd=function(o){var e=typeof o;return e=="string"||e=="number"||e=="symbol"||e=="boolean"?o!=="__proto__":o===null},Dr=function(o,e){var t=o.__data__;return rd(e)?t[typeof e=="string"?"string":"hash"]:t.map},to=function(o){var e=Dr(this,o).delete(o);return this.size-=e?1:0,e},no=function(o){return Dr(this,o).get(o)},_s=function(o){return Dr(this,o).has(o)},sd=function(o,e){var t=Dr(this,o),n=t.size;return t.set(o,e),this.size+=t.size==n?0:1,this};function ti(o){var e=-1,t=o==null?0:o.length;for(this.clear();++e<t;){var n=o[e];this.set(n[0],n[1])}}ti.prototype.clear=qo,ti.prototype.delete=to,ti.prototype.get=no,ti.prototype.has=_s,ti.prototype.set=sd;const Go=ti;var Cs=200;const Xa=function(o,e){var t=this.__data__;if(t instanceof Cr){var n=t.__data__;if(!Ft||n.length<Cs-1)return n.push([o,e]),this.size=++t.size,this;t=this.__data__=new Go(n)}return t.set(o,e),this.size=t.size,this};function io(o){var e=this.__data__=new Cr(o);this.size=e.size}io.prototype.clear=Qc,io.prototype.delete=Wa,io.prototype.get=Zc,io.prototype.has=bo,io.prototype.set=Xa;const $o=io,el=function(o,e){for(var t=-1,n=o==null?0:o.length;++t<n&&e(o[t],t,o)!==!1;);return o},Er=function(){try{var o=Si(Object,"defineProperty");return o({},"",{}),o}catch{}}(),As=function(o,e,t){e=="__proto__"&&Er?Er(o,e,{configurable:!0,enumerable:!0,value:t,writable:!0}):o[e]=t};var ys=Object.prototype.hasOwnProperty;const xs=function(o,e,t){var n=o[e];ys.call(o,e)&&Xn(n,t)&&(t!==void 0||e in o)||As(o,e,t)},vo=function(o,e,t,n){var i=!t;t||(t={});for(var r=-1,s=e.length;++r<s;){var a=e[r],c=n?n(t[a],o[a],a,t,o):void 0;c===void 0&&(c=o[a]),i?As(t,a,c):xs(t,a,c)}return t},ad=function(o,e){for(var t=-1,n=Array(o);++t<o;)n[t]=e(t);return n};var ld="[object Arguments]";const tl=function(o){return nn(o)&&kn(o)==ld};var nl=Object.prototype,cd=nl.hasOwnProperty,il=nl.propertyIsEnumerable;const Yo=tl(function(){return arguments}())?tl:function(o){return nn(o)&&cd.call(o,"callee")&&!il.call(o,"callee")},ol=function(){return!1};var Tr=d&&!d.nodeType&&d,Ds=Tr&&!0&&l&&!l.nodeType&&l,Es=Ds&&Ds.exports===Tr?en.Buffer:void 0;const oo=(Es?Es.isBuffer:void 0)||ol;var dd=9007199254740991,ud=/^(?:0|[1-9]\d*)$/;const Ts=function(o,e){var t=typeof o;return!!(e=e??dd)&&(t=="number"||t!="symbol"&&ud.test(o))&&o>-1&&o%1==0&&o<e};var Ko=9007199254740991;const Ss=function(o){return typeof o=="number"&&o>-1&&o%1==0&&o<=Ko};var ft={};ft["[object Float32Array]"]=ft["[object Float64Array]"]=ft["[object Int8Array]"]=ft["[object Int16Array]"]=ft["[object Int32Array]"]=ft["[object Uint8Array]"]=ft["[object Uint8ClampedArray]"]=ft["[object Uint16Array]"]=ft["[object Uint32Array]"]=!0,ft["[object Arguments]"]=ft["[object Array]"]=ft["[object ArrayBuffer]"]=ft["[object Boolean]"]=ft["[object DataView]"]=ft["[object Date]"]=ft["[object Error]"]=ft["[object Function]"]=ft["[object Map]"]=ft["[object Number]"]=ft["[object Object]"]=ft["[object RegExp]"]=ft["[object Set]"]=ft["[object String]"]=ft["[object WeakMap]"]=!1;const hd=function(o){return nn(o)&&Ss(o.length)&&!!ft[kn(o)]},Is=function(o){return function(e){return o(e)}};var rl=d&&!d.nodeType&&d,h=rl&&!0&&l&&!l.nodeType&&l,b=h&&h.exports===rl&&za.process;const C=function(){try{var o=h&&h.require&&h.require("util").types;return o||b&&b.binding&&b.binding("util")}catch{}}();var D=C&&C.isTypedArray;const S=D?Is(D):hd;var N=Object.prototype.hasOwnProperty;const z=function(o,e){var t=tn(o),n=!t&&Yo(o),i=!t&&!n&&oo(o),r=!t&&!n&&!i&&S(o),s=t||n||i||r,a=s?ad(o.length,String):[],c=a.length;for(var u in o)!e&&!N.call(o,u)||s&&(u=="length"||i&&(u=="offset"||u=="parent")||r&&(u=="buffer"||u=="byteLength"||u=="byteOffset")||Ts(u,c))||a.push(u);return a};var W=Object.prototype;const U=function(o){var e=o&&o.constructor;return o===(typeof e=="function"&&e.prototype||W)},Y=Ji(Object.keys,Object);var ee=Object.prototype.hasOwnProperty;const ae=function(o){if(!U(o))return Y(o);var e=[];for(var t in Object(o))ee.call(o,t)&&t!="constructor"&&e.push(t);return e},J=function(o){return o!=null&&Ss(o.length)&&!ko(o)},de=function(o){return J(o)?z(o):ae(o)},Be=function(o,e){return o&&vo(e,de(e),o)},Je=function(o){var e=[];if(o!=null)for(var t in Object(o))e.push(t);return e};var Ue=Object.prototype.hasOwnProperty;const qt=function(o){if(!ht(o))return Je(o);var e=U(o),t=[];for(var n in o)(n!="constructor"||!e&&Ue.call(o,n))&&t.push(n);return t},At=function(o){return J(o)?z(o,!0):qt(o)},ni=function(o,e){return o&&vo(e,At(e),o)};var Vn=d&&!d.nodeType&&d,Ge=Vn&&!0&&l&&!l.nodeType&&l,Ii=Ge&&Ge.exports===Vn?en.Buffer:void 0,Xe=Ii?Ii.allocUnsafe:void 0;const xt=function(o,e){if(e)return o.slice();var t=o.length,n=Xe?Xe(t):new o.constructor(t);return o.copy(n),n},_o=function(o,e){var t=-1,n=o.length;for(e||(e=Array(n));++t<n;)e[t]=o[t];return e},Ms=function(o,e){for(var t=-1,n=o==null?0:o.length,i=0,r=[];++t<n;){var s=o[t];e(s,t,o)&&(r[i++]=s)}return r},Hn=function(){return[]};var Qo=Object.prototype.propertyIsEnumerable,Un=Object.getOwnPropertySymbols;const ii=Un?function(o){return o==null?[]:(o=Object(o),Ms(Un(o),function(e){return Qo.call(o,e)}))}:Hn,Mi=function(o,e){return vo(o,ii(o),e)},wn=function(o,e){for(var t=-1,n=e.length,i=o.length;++t<n;)o[i+t]=e[t];return o},Sr=Object.getOwnPropertySymbols?function(o){for(var e=[];o;)wn(e,ii(o)),o=Xi(o);return e}:Hn,ki=function(o,e){return vo(o,Sr(o),e)},oi=function(o,e,t){var n=e(o);return tn(o)?n:wn(n,t(o))},Ns=function(o){return oi(o,de,ii)},fd=function(o){return oi(o,At,Sr)},Ps=Si(en,"DataView"),ot=Si(en,"Promise"),Co=Si(en,"Set"),vn=Si(en,"WeakMap");var ro="[object Map]",sl="[object Promise]",al="[object Set]",Bs="[object WeakMap]",Ni="[object DataView]",Ls=Ti(Ps),Pi=Ti(Ft),ll=Ti(ot),Zo=Ti(Co),Ir=Ti(vn),ri=kn;(Ps&&ri(new Ps(new ArrayBuffer(1)))!=Ni||Ft&&ri(new Ft)!=ro||ot&&ri(ot.resolve())!=sl||Co&&ri(new Co)!=al||vn&&ri(new vn)!=Bs)&&(ri=function(o){var e=kn(o),t=e=="[object Object]"?o.constructor:void 0,n=t?Ti(t):"";if(n)switch(n){case Ls:return Ni;case Pi:return ro;case ll:return sl;case Zo:return al;case Ir:return Bs}return e});const so=ri;var gd=Object.prototype.hasOwnProperty;const Mr=function(o){var e=o.length,t=new o.constructor(e);return e&&typeof o[0]=="string"&&gd.call(o,"index")&&(t.index=o.index,t.input=o.input),t},Ao=en.Uint8Array,Jo=function(o){var e=new o.constructor(o.byteLength);return new Ao(e).set(new Ao(o)),e},pd=function(o,e){var t=e?Jo(o.buffer):o.buffer;return new o.constructor(t,o.byteOffset,o.byteLength)};var zs=/\w*$/;const cl=function(o){var e=new o.constructor(o.source,zs.exec(o));return e.lastIndex=o.lastIndex,e};var j=un?un.prototype:void 0,G=j?j.valueOf:void 0;const Z=function(o){return G?Object(G.call(o)):{}},X=function(o,e){var t=e?Jo(o.buffer):o.buffer;return new o.constructor(t,o.byteOffset,o.length)};var re="[object Boolean]",ge="[object Date]",be="[object Map]",ve="[object Number]",ke="[object RegExp]",$e="[object Set]",Ie="[object String]",Oe="[object Symbol]",Ye="[object ArrayBuffer]",xe="[object DataView]",mt="[object Float32Array]",fn="[object Float64Array]",Yt="[object Int8Array]",En="[object Int16Array]",si="[object Int32Array]",yo="[object Uint8Array]",sn="[object Uint8ClampedArray]",T0="[object Uint16Array]",S0="[object Uint32Array]";const I0=function(o,e,t){var n=o.constructor;switch(e){case Ye:return Jo(o);case re:case ge:return new n(+o);case xe:return pd(o,t);case mt:case fn:case Yt:case En:case si:case yo:case sn:case T0:case S0:return X(o,t);case be:return new n;case ve:case Ie:return new n(o);case ke:return cl(o);case $e:return new n;case Oe:return Z(o)}};var Qh=Object.create;const M0=function(){function o(){}return function(e){if(!ht(e))return{};if(Qh)return Qh(e);o.prototype=e;var t=new o;return o.prototype=void 0,t}}(),Zh=function(o){return typeof o.constructor!="function"||U(o)?{}:M0(Xi(o))};var N0="[object Map]";const P0=function(o){return nn(o)&&so(o)==N0};var Jh=C&&C.isMap;const B0=Jh?Is(Jh):P0;var L0="[object Set]";const z0=function(o){return nn(o)&&so(o)==L0};var Xh=C&&C.isSet;const O0=Xh?Is(Xh):z0;var R0=1,j0=2,F0=4,ef="[object Arguments]",tf="[object Function]",V0="[object GeneratorFunction]",nf="[object Object]",yt={};yt[ef]=yt["[object Array]"]=yt["[object ArrayBuffer]"]=yt["[object DataView]"]=yt["[object Boolean]"]=yt["[object Date]"]=yt["[object Float32Array]"]=yt["[object Float64Array]"]=yt["[object Int8Array]"]=yt["[object Int16Array]"]=yt["[object Int32Array]"]=yt["[object Map]"]=yt["[object Number]"]=yt[nf]=yt["[object RegExp]"]=yt["[object Set]"]=yt["[object String]"]=yt["[object Symbol]"]=yt["[object Uint8Array]"]=yt["[object Uint8ClampedArray]"]=yt["[object Uint16Array]"]=yt["[object Uint32Array]"]=!0,yt["[object Error]"]=yt[tf]=yt["[object WeakMap]"]=!1;const md=function o(e,t,n,i,r,s){var a,c=t&R0,u=t&j0,f=t&F0;if(n&&(a=r?n(e,i,r,s):n(e)),a!==void 0)return a;if(!ht(e))return e;var m=tn(e);if(m){if(a=Mr(e),!c)return _o(e,a)}else{var v=so(e),E=v==tf||v==V0;if(oo(e))return xt(e,c);if(v==nf||v==ef||E&&!r){if(a=u||E?{}:Zh(e),!c)return u?ki(e,ni(a,e)):Mi(e,Be(a,e))}else{if(!yt[v])return r?e:{};a=I0(e,v,c)}}s||(s=new $o);var I=s.get(e);if(I)return I;s.set(e,a),O0(e)?e.forEach(function(R){a.add(o(R,t,n,R,e,s))}):B0(e)&&e.forEach(function(R,H){a.set(H,o(R,t,n,H,e,s))});var L=m?void 0:(f?u?fd:Ns:u?At:de)(e);return el(L||e,function(R,H){L&&(R=e[H=R]),xs(a,H,o(R,t,n,H,e,s))}),a};var H0=1,U0=4;const of=function(o,e){return md(o,H0|U0,e=typeof e=="function"?e:void 0)},Os=function(o){return nn(o)&&o.nodeType===1&&!rn(o)};class rf{constructor(e,t){this._config={},t&&this.define(sf(t)),e&&this._setObjectToTarget(this._config,e)}set(e,t){this._setToTarget(this._config,e,t)}define(e,t){this._setToTarget(this._config,e,t,!0)}get(e){return this._getFromSource(this._config,e)}*names(){for(const e of Object.keys(this._config))yield e}_setToTarget(e,t,n,i=!1){if(rn(t))return void this._setObjectToTarget(e,t,i);const r=t.split(".");t=r.pop();for(const s of r)rn(e[s])||(e[s]={}),e=e[s];if(rn(n))return rn(e[t])||(e[t]={}),e=e[t],void this._setObjectToTarget(e,n,i);i&&e[t]!==void 0||(e[t]=n)}_getFromSource(e,t){const n=t.split(".");t=n.pop();for(const i of n){if(!rn(e[i])){e=null;break}e=e[i]}return e?sf(e[t]):void 0}_setObjectToTarget(e,t,n){Object.keys(t).forEach(i=>{this._setToTarget(e,i,t[i],n)})}}function sf(o){return of(o,W0)}function W0(o){return Os(o)?o:void 0}function xo(o){if(o){if(o.defaultView)return o instanceof o.defaultView.Document;if(o.ownerDocument&&o.ownerDocument.defaultView)return o instanceof o.ownerDocument.defaultView.Node}return!1}function dl(o){const e=Object.prototype.toString.apply(o);return e=="[object Window]"||e=="[object global]"}const af=Do(Ce());function Do(o){return o?class extends o{listenTo(e,t,n,i={}){if(xo(e)||dl(e)){const r={capture:!!i.useCapture,passive:!!i.usePassive},s=this._getProxyEmitter(e,r)||new q0(e,r);this.listenTo(s,t,n,i)}else super.listenTo(e,t,n,i)}stopListening(e,t,n){if(xo(e)||dl(e)){const i=this._getAllProxyEmitters(e);for(const r of i)this.stopListening(r,t,n)}else super.stopListening(e,t,n)}_getProxyEmitter(e,t){return function(n,i){const r=n[me];return r&&r[i]?r[i].emitter:null}(this,lf(e,t))}_getAllProxyEmitters(e){return[{capture:!1,passive:!1},{capture:!1,passive:!0},{capture:!0,passive:!1},{capture:!0,passive:!0}].map(t=>this._getProxyEmitter(e,t)).filter(t=>!!t)}}:af}["_getProxyEmitter","_getAllProxyEmitters","on","once","off","listenTo","stopListening","fire","delegate","stopDelegating","_addEventListener","_removeEventListener"].forEach(o=>{Do[o]=af.prototype[o]});class q0 extends Ce(){constructor(e,t){super(),_t(this,lf(e,t)),this._domNode=e,this._options=t}attach(e){if(this._domListeners&&this._domListeners[e])return;const t=this._createDomListener(e);this._domNode.addEventListener(e,t,this._options),this._domListeners||(this._domListeners={}),this._domListeners[e]=t}detach(e){let t;!this._domListeners[e]||(t=this._events[e])&&t.callbacks.length||this._domListeners[e].removeListener()}_addEventListener(e,t,n){this.attach(e),Ce().prototype._addEventListener.call(this,e,t,n)}_removeEventListener(e,t){Ce().prototype._removeEventListener.call(this,e,t),this.detach(e)}_createDomListener(e){const t=n=>{this.fire(e,n)};return t.removeListener=()=>{this._domNode.removeEventListener(e,t,this._options),delete this._domListeners[e]},t}}function lf(o,e){let t=function(n){return n["data-ck-expando"]||(n["data-ck-expando"]=K())}(o);for(const n of Object.keys(e).sort())e[n]&&(t+="-"+n);return t}let bd;try{bd={window,document}}catch{bd={window:{},document:{}}}const Qe=bd;function cf(o){const e=[];let t=o;for(;t&&t.nodeType!=Node.DOCUMENT_NODE;)e.unshift(t),t=t.parentNode;return e}function Pt(o){return Object.prototype.toString.call(o)=="[object Text]"}function ul(o){return Object.prototype.toString.apply(o)=="[object Range]"}function df(o){const e=o.ownerDocument.defaultView.getComputedStyle(o);return{top:parseInt(e.borderTopWidth,10),right:parseInt(e.borderRightWidth,10),bottom:parseInt(e.borderBottomWidth,10),left:parseInt(e.borderLeftWidth,10)}}const uf=["top","right","bottom","left","width","height"];class vt{constructor(e){const t=ul(e);if(Object.defineProperty(this,"_source",{value:e._source||e,writable:!0,enumerable:!1}),ff(e)||t)if(t){const n=vt.getDomRangeRects(e);hl(this,vt.getBoundingRect(n))}else hl(this,e.getBoundingClientRect());else if(dl(e)){const{innerWidth:n,innerHeight:i}=e;hl(this,{top:0,right:n,bottom:i,left:0,width:n,height:i})}else hl(this,e)}clone(){return new vt(this)}moveTo(e,t){return this.top=t,this.right=e+this.width,this.bottom=t+this.height,this.left=e,this}moveBy(e,t){return this.top+=t,this.right+=e,this.left+=e,this.bottom+=t,this}getIntersection(e){const t={top:Math.max(this.top,e.top),right:Math.min(this.right,e.right),bottom:Math.min(this.bottom,e.bottom),left:Math.max(this.left,e.left),width:0,height:0};return t.width=t.right-t.left,t.height=t.bottom-t.top,t.width<0||t.height<0?null:new vt(t)}getIntersectionArea(e){const t=this.getIntersection(e);return t?t.getArea():0}getArea(){return this.width*this.height}getVisible(){const e=this._source;let t=this.clone();if(!hf(e)){let n=e.parentNode||e.commonAncestorContainer;for(;n&&!hf(n);){const i=new vt(n),r=t.getIntersection(i);if(!r)return null;r.getArea()<t.getArea()&&(t=r),n=n.parentNode}}return t}isEqual(e){for(const t of uf)if(this[t]!==e[t])return!1;return!0}contains(e){const t=this.getIntersection(e);return!(!t||!t.isEqual(e))}excludeScrollbarsAndBorders(){const e=this._source;let t,n,i;if(dl(e))t=e.innerWidth-e.document.documentElement.clientWidth,n=e.innerHeight-e.document.documentElement.clientHeight,i=e.getComputedStyle(e.document.documentElement).direction;else{const r=df(e);t=e.offsetWidth-e.clientWidth-r.left-r.right,n=e.offsetHeight-e.clientHeight-r.top-r.bottom,i=e.ownerDocument.defaultView.getComputedStyle(e).direction,this.left+=r.left,this.top+=r.top,this.right-=r.right,this.bottom-=r.bottom,this.width=this.right-this.left,this.height=this.bottom-this.top}return this.width-=t,i==="ltr"?this.right-=t:this.left+=t,this.height-=n,this.bottom-=n,this}static getDomRangeRects(e){const t=[],n=Array.from(e.getClientRects());if(n.length)for(const i of n)t.push(new vt(i));else{let i=e.startContainer;Pt(i)&&(i=i.parentNode);const r=new vt(i.getBoundingClientRect());r.right=r.left,r.width=0,t.push(r)}return t}static getBoundingRect(e){const t={left:Number.POSITIVE_INFINITY,top:Number.POSITIVE_INFINITY,right:Number.NEGATIVE_INFINITY,bottom:Number.NEGATIVE_INFINITY,width:0,height:0};let n=0;for(const i of e)n++,t.left=Math.min(t.left,i.left),t.top=Math.min(t.top,i.top),t.right=Math.max(t.right,i.right),t.bottom=Math.max(t.bottom,i.bottom);return n==0?null:(t.width=t.right-t.left,t.height=t.bottom-t.top,new vt(t))}}function hl(o,e){for(const t of uf)o[t]=e[t]}function hf(o){return!!ff(o)&&o===o.ownerDocument.body}function ff(o){return o!==null&&typeof o=="object"&&o.nodeType===1&&typeof o.getBoundingClientRect=="function"}class Dt{constructor(e,t){Dt._observerInstance||Dt._createObserver(),this._element=e,this._callback=t,Dt._addElementCallback(e,t),Dt._observerInstance.observe(e)}destroy(){Dt._deleteElementCallback(this._element,this._callback)}static _addElementCallback(e,t){Dt._elementCallbacks||(Dt._elementCallbacks=new Map);let n=Dt._elementCallbacks.get(e);n||(n=new Set,Dt._elementCallbacks.set(e,n)),n.add(t)}static _deleteElementCallback(e,t){const n=Dt._getElementCallbacks(e);n&&(n.delete(t),n.size||(Dt._elementCallbacks.delete(e),Dt._observerInstance.unobserve(e))),Dt._elementCallbacks&&!Dt._elementCallbacks.size&&(Dt._observerInstance=null,Dt._elementCallbacks=null)}static _getElementCallbacks(e){return Dt._elementCallbacks?Dt._elementCallbacks.get(e):null}static _createObserver(){Dt._observerInstance=new Qe.window.ResizeObserver(e=>{for(const t of e){const n=Dt._getElementCallbacks(t.target);if(n)for(const i of n)i(t)}})}}function G0(o,e){o instanceof HTMLTextAreaElement&&(o.value=e),o.innerHTML=e}function gf(o){return e=>e+o}function fl(o){let e=0;for(;o.previousSibling;)o=o.previousSibling,e++;return e}function pf(o,e,t){o.insertBefore(t,o.childNodes[e]||null)}function Nr(o){return o&&o.nodeType===Node.COMMENT_NODE}function Xo(o){return!!(o&&o.getClientRects&&o.getClientRects().length)}function mf({element:o,target:e,positions:t,limiter:n,fitInViewport:i,viewportOffsetConfig:r}){ko(e)&&(e=e()),ko(n)&&(n=n());const s=function(v){return v&&v.parentNode?v.offsetParent===Qe.document.body?null:v.offsetParent:null}(o),a=new vt(o),c=new vt(e);let u;const f=i&&function(v){v=Object.assign({top:0,bottom:0,left:0,right:0},v);const E=new vt(Qe.window);return E.top+=v.top,E.height-=v.top,E.bottom-=v.bottom,E.height-=v.bottom,E}(r)||null,m={targetRect:c,elementRect:a,positionedElementAncestor:s,viewportRect:f};if(n||i){const v=n&&new vt(n).getVisible();Object.assign(m,{limiterRect:v,viewportRect:f}),u=function(E,I){const{elementRect:L}=I,R=L.getArea(),H=E.map(ue=>new kd(ue,I)).filter(ue=>!!ue.name);let $=0,te=null;for(const ue of H){const{limiterIntersectionArea:De,viewportIntersectionArea:Ze}=ue;if(De===R)return ue;const qe=Ze**2+De**2;qe>$&&($=qe,te=ue)}return te}(t,m)||new kd(t[0],m)}else u=new kd(t[0],m);return u}function bf(o){const{scrollX:e,scrollY:t}=Qe.window;return o.clone().moveBy(e,t)}Dt._observerInstance=null,Dt._elementCallbacks=null;class kd{constructor(e,t){const n=e(t.targetRect,t.elementRect,t.viewportRect);if(!n)return;const{left:i,top:r,name:s,config:a}=n;this.name=s,this.config=a,this._positioningFunctionCorrdinates={left:i,top:r},this._options=t}get left(){return this._absoluteRect.left}get top(){return this._absoluteRect.top}get limiterIntersectionArea(){const e=this._options.limiterRect;if(e){const t=this._options.viewportRect;if(!t)return e.getIntersectionArea(this._rect);{const n=e.getIntersection(t);if(n)return n.getIntersectionArea(this._rect)}}return 0}get viewportIntersectionArea(){const e=this._options.viewportRect;return e?e.getIntersectionArea(this._rect):0}get _rect(){return this._cachedRect||(this._cachedRect=this._options.elementRect.clone().moveTo(this._positioningFunctionCorrdinates.left,this._positioningFunctionCorrdinates.top)),this._cachedRect}get _absoluteRect(){return this._cachedAbsoluteRect||(this._cachedAbsoluteRect=bf(this._rect),this._options.positionedElementAncestor&&function(e,t){const n=bf(new vt(t)),i=df(t);let r=0,s=0;r-=n.left,s-=n.top,r+=t.scrollLeft,s+=t.scrollTop,r-=i.left,s-=i.top,e.moveBy(r,s)}(this._cachedAbsoluteRect,this._options.positionedElementAncestor)),this._cachedAbsoluteRect}}function kf(o){const e=o.parentNode;e&&e.removeChild(o)}function $0(o,e,t){const n=e.clone().moveBy(0,t),i=e.clone().moveBy(0,-t),r=new vt(o).excludeScrollbarsAndBorders();if(![i,n].every(s=>r.contains(s))){let{scrollX:s,scrollY:a}=o;vf(i,r)?a-=r.top-e.top+t:wf(n,r)&&(a+=e.bottom-r.bottom+t),_f(e,r)?s-=r.left-e.left+t:Cf(e,r)&&(s+=e.right-r.right+t),o.scrollTo(s,a)}}function Y0(o,e){const t=wd(o);let n,i;for(;o!=t.document.body;)i=e(),n=new vt(o).excludeScrollbarsAndBorders(),n.contains(i)||(vf(i,n)?o.scrollTop-=n.top-i.top:wf(i,n)&&(o.scrollTop+=i.bottom-n.bottom),_f(i,n)?o.scrollLeft-=n.left-i.left:Cf(i,n)&&(o.scrollLeft+=i.right-n.right)),o=o.parentNode}function wf(o,e){return o.bottom>e.bottom}function vf(o,e){return o.top<e.top}function _f(o,e){return o.left<e.left}function Cf(o,e){return o.right>e.right}function wd(o){return ul(o)?o.startContainer.ownerDocument.defaultView:o.ownerDocument.defaultView}function K0(o){if(ul(o)){let e=o.commonAncestorContainer;return Pt(e)&&(e=e.parentNode),e}return o.parentNode}function Af(o,e){const t=wd(o),n=new vt(o);if(t===e)return n;{let i=t;for(;i!=e;){const r=i.frameElement,s=new vt(r).excludeScrollbarsAndBorders();n.moveBy(s.left,s.top),i=i.parent}}return n}const Q0={ctrl:"⌃",cmd:"⌘",alt:"⌥",shift:"⇧"},Z0={ctrl:"Ctrl+",alt:"Alt+",shift:"Shift+"},tt=function(){const o={arrowleft:37,arrowup:38,arrowright:39,arrowdown:40,backspace:8,delete:46,enter:13,space:32,esc:27,tab:9,ctrl:1114112,shift:2228224,alt:4456448,cmd:8912896};for(let e=65;e<=90;e++)o[String.fromCharCode(e).toLowerCase()]=e;for(let e=48;e<=57;e++)o[e-48]=e;for(let e=112;e<=123;e++)o["f"+(e-111)]=e;for(const e of"`-=[];',./\\")o[e]=e.charCodeAt(0);return o}(),J0=Object.fromEntries(Object.entries(tt).map(([o,e])=>[e,o.charAt(0).toUpperCase()+o.slice(1)]));function Pr(o){let e;if(typeof o=="string"){if(e=tt[o.toLowerCase()],!e)throw new V("keyboard-unknown-key",null,{key:o})}else e=o.keyCode+(o.altKey?tt.alt:0)+(o.ctrlKey?tt.ctrl:0)+(o.shiftKey?tt.shift:0)+(o.metaKey?tt.cmd:0);return e}function vd(o){return typeof o=="string"&&(o=function(e){return e.split("+").map(t=>t.trim())}(o)),o.map(e=>typeof e=="string"?function(t){if(t.endsWith("!"))return Pr(t.slice(0,-1));const n=Pr(t);return k.isMac&&n==tt.ctrl?tt.cmd:n}(e):e).reduce((e,t)=>t+e,0)}function yf(o){let e=vd(o);return Object.entries(k.isMac?Q0:Z0).reduce((t,[n,i])=>(e&tt[n]&&(e&=~tt[n],t+=i),t),"")+(e?J0[e]:"")}function _d(o,e){const t=e==="ltr";switch(o){case tt.arrowleft:return t?"left":"right";case tt.arrowright:return t?"right":"left";case tt.arrowup:return"up";case tt.arrowdown:return"down"}}function Kt(o){return Array.isArray(o)?o:[o]}function X0(o,e,t=1){if(typeof t!="number")throw new V("translation-service-quantity-not-a-number",null,{quantity:t});const n=Object.keys(Qe.window.CKEDITOR_TRANSLATIONS).length;n===1&&(o=Object.keys(Qe.window.CKEDITOR_TRANSLATIONS)[0]);const i=e.id||e.string;if(n===0||!function(c,u){return!!Qe.window.CKEDITOR_TRANSLATIONS[c]&&!!Qe.window.CKEDITOR_TRANSLATIONS[c].dictionary[u]}(o,i))return t!==1?e.plural:e.string;const r=Qe.window.CKEDITOR_TRANSLATIONS[o].dictionary,s=Qe.window.CKEDITOR_TRANSLATIONS[o].getPluralForm||(c=>c===1?0:1),a=r[i];return typeof a=="string"?a:a[Number(s(t))]}Qe.window.CKEDITOR_TRANSLATIONS||(Qe.window.CKEDITOR_TRANSLATIONS={});const e_=["ar","ara","fa","per","fas","he","heb","ku","kur","ug","uig"];function xf(o){return e_.includes(o)?"rtl":"ltr"}class t_{constructor({uiLanguage:e="en",contentLanguage:t}={}){this.uiLanguage=e,this.contentLanguage=t||this.uiLanguage,this.uiLanguageDirection=xf(this.uiLanguage),this.contentLanguageDirection=xf(this.contentLanguage),this.t=(n,i)=>this._t(n,i)}get language(){return console.warn("locale-deprecated-language-property: The Locale#language property has been deprecated and will be removed in the near future. Please use #uiLanguage and #contentLanguage properties instead."),this.uiLanguage}_t(e,t=[]){t=Kt(t),typeof e=="string"&&(e={string:e});const n=e.plural?t[0]:1;return function(i,r){return i.replace(/%(\d+)/g,(s,a)=>a<r.length?r[a]:s)}(X0(this.uiLanguage,e,n),t)}}class _n extends Ce(){constructor(e={},t={}){super();const n=bn(e);if(n||(t=e),this._items=[],this._itemMap=new Map,this._idProperty=t.idProperty||"id",this._bindToExternalToInternalMap=new WeakMap,this._bindToInternalToExternalMap=new WeakMap,this._skippedIndexesFromExternal=[],n)for(const i of e)this._items.push(i),this._itemMap.set(this._getItemIdBeforeAdding(i),i)}get length(){return this._items.length}get first(){return this._items[0]||null}get last(){return this._items[this.length-1]||null}add(e,t){return this.addMany([e],t)}addMany(e,t){if(t===void 0)t=this._items.length;else if(t>this._items.length||t<0)throw new V("collection-add-item-invalid-index",this);let n=0;for(const i of e){const r=this._getItemIdBeforeAdding(i),s=t+n;this._items.splice(s,0,i),this._itemMap.set(r,i),this.fire("add",i,s),n++}return this.fire("change",{added:e,removed:[],index:t}),this}get(e){let t;if(typeof e=="string")t=this._itemMap.get(e);else{if(typeof e!="number")throw new V("collection-get-invalid-arg",this);t=this._items[e]}return t||null}has(e){if(typeof e=="string")return this._itemMap.has(e);{const t=e[this._idProperty];return t&&this._itemMap.has(t)}}getIndex(e){let t;return t=typeof e=="string"?this._itemMap.get(e):e,t?this._items.indexOf(t):-1}remove(e){const[t,n]=this._remove(e);return this.fire("change",{added:[],removed:[t],index:n}),t}map(e,t){return this._items.map(e,t)}find(e,t){return this._items.find(e,t)}filter(e,t){return this._items.filter(e,t)}clear(){this._bindToCollection&&(this.stopListening(this._bindToCollection),this._bindToCollection=null);const e=Array.from(this._items);for(;this.length;)this._remove(0);this.fire("change",{added:[],removed:e,index:0})}bindTo(e){if(this._bindToCollection)throw new V("collection-bind-to-rebind",this);return this._bindToCollection=e,{as:t=>{this._setUpBindToBinding(n=>new t(n))},using:t=>{typeof t=="function"?this._setUpBindToBinding(t):this._setUpBindToBinding(n=>n[t])}}}_setUpBindToBinding(e){const t=this._bindToCollection,n=(i,r,s)=>{const a=t._bindToCollection==this,c=t._bindToInternalToExternalMap.get(r);if(a&&c)this._bindToExternalToInternalMap.set(r,c),this._bindToInternalToExternalMap.set(c,r);else{const u=e(r);if(!u)return void this._skippedIndexesFromExternal.push(s);let f=s;for(const m of this._skippedIndexesFromExternal)s>m&&f--;for(const m of t._skippedIndexesFromExternal)f>=m&&f++;this._bindToExternalToInternalMap.set(r,u),this._bindToInternalToExternalMap.set(u,r),this.add(u,f);for(let m=0;m<t._skippedIndexesFromExternal.length;m++)f<=t._skippedIndexesFromExternal[m]&&t._skippedIndexesFromExternal[m]++}};for(const i of t)n(0,i,t.getIndex(i));this.listenTo(t,"add",n),this.listenTo(t,"remove",(i,r,s)=>{const a=this._bindToExternalToInternalMap.get(r);a&&this.remove(a),this._skippedIndexesFromExternal=this._skippedIndexesFromExternal.reduce((c,u)=>(s<u&&c.push(u-1),s>u&&c.push(u),c),[])})}_getItemIdBeforeAdding(e){const t=this._idProperty;let n;if(t in e){if(n=e[t],typeof n!="string")throw new V("collection-add-invalid-id",this);if(this.get(n))throw new V("collection-add-item-already-exists",this)}else e[t]=n=K();return n}_remove(e){let t,n,i,r=!1;const s=this._idProperty;if(typeof e=="string"?(n=e,i=this._itemMap.get(n),r=!i,i&&(t=this._items.indexOf(i))):typeof e=="number"?(t=e,i=this._items[t],r=!i,i&&(n=i[s])):(i=e,n=i[s],t=this._items.indexOf(i),r=t==-1||!this._itemMap.get(n)),r)throw new V("collection-remove-404",this);this._items.splice(t,1),this._itemMap.delete(n);const a=this._bindToInternalToExternalMap.get(i);return this._bindToInternalToExternalMap.delete(i),this._bindToExternalToInternalMap.delete(a),this.fire("remove",i,t),[i,t]}[Symbol.iterator](){return this._items[Symbol.iterator]()}}function Bt(o){const e=o.next();return e.done?null:e.value}class gn extends Do(Ke()){constructor(){super(),this._elements=new Set,this._nextEventLoopTimeout=null,this.set("isFocused",!1),this.set("focusedElement",null)}add(e){if(this._elements.has(e))throw new V("focustracker-add-element-already-exist",this);this.listenTo(e,"focus",()=>this._focus(e),{useCapture:!0}),this.listenTo(e,"blur",()=>this._blur(),{useCapture:!0}),this._elements.add(e)}remove(e){e===this.focusedElement&&this._blur(),this._elements.has(e)&&(this.stopListening(e),this._elements.delete(e))}destroy(){this.stopListening()}_focus(e){clearTimeout(this._nextEventLoopTimeout),this.focusedElement=e,this.isFocused=!0}_blur(){clearTimeout(this._nextEventLoopTimeout),this._nextEventLoopTimeout=setTimeout(()=>{this.focusedElement=null,this.isFocused=!1},0)}}class Tn{constructor(){this._listener=new(Do())}listenTo(e){this._listener.listenTo(e,"keydown",(t,n)=>{this._listener.fire("_keydown:"+Pr(n),n)})}set(e,t,n={}){const i=vd(e),r=n.priority;this._listener.listenTo(this._listener,"_keydown:"+i,(s,a)=>{t(a,()=>{a.preventDefault(),a.stopPropagation(),s.stop()}),s.return=!0},{priority:r})}press(e){return!!this._listener.fire("_keydown:"+Pr(e),e)}destroy(){this._listener.stopListening()}}function Bi(o){return bn(o)?new Map(o):function(e){const t=new Map;for(const n in e)t.set(n,e[n]);return t}(o)}const n_=1e4;function Df(o,e){return!!(t=o.charAt(e-1))&&t.length==1&&/[\ud800-\udbff]/.test(t)&&function(n){return!!n&&n.length==1&&/[\udc00-\udfff]/.test(n)}(o.charAt(e));var t}function Ef(o,e){return!!(t=o.charAt(e))&&t.length==1&&/[\u0300-\u036f\u1ab0-\u1aff\u1dc0-\u1dff\u20d0-\u20ff\ufe20-\ufe2f]/.test(t);var t}const i_=function(){const o=new RegExp("\\p{Regional_Indicator}{2}","u").source,e="(?:"+[new RegExp("\\p{Emoji}[\\u{E0020}-\\u{E007E}]+\\u{E007F}","u"),new RegExp("\\p{Emoji}\\u{FE0F}?\\u{20E3}","u"),new RegExp("\\p{Emoji}\\u{FE0F}","u"),new RegExp("(?=\\p{General_Category=Other_Symbol})\\p{Emoji}\\p{Emoji_Modifier}*","u")].map(t=>t.source).join("|")+")";return new RegExp(`${o}|${e}(?:‍${e})*`,"ug")}();function o_(o,e){const t=String(o).matchAll(i_);return Array.from(t).some(n=>n.index<e&&e<n.index+n[0].length)}class oe extends Ke(){constructor(e){super(),this.editor=e,this.set("isEnabled",!0),this._disableStack=new Set}forceDisabled(e){this._disableStack.add(e),this._disableStack.size==1&&(this.on("set:isEnabled",Tf,{priority:"highest"}),this.isEnabled=!1)}clearForceDisabled(e){this._disableStack.delete(e),this._disableStack.size==0&&(this.off("set:isEnabled",Tf),this.isEnabled=!0)}destroy(){this.stopListening()}static get isContextPlugin(){return!1}}function Tf(o){o.return=!1,o.stop()}class je extends Ke(){constructor(e){super(),this.editor=e,this.set("value",void 0),this.set("isEnabled",!1),this._affectsData=!0,this._disableStack=new Set,this.decorate("execute"),this.listenTo(this.editor.model.document,"change",()=>{this.refresh()}),this.on("execute",t=>{this.isEnabled||t.stop()},{priority:"high"}),this.listenTo(e,"change:isReadOnly",(t,n,i)=>{i&&this.affectsData?this.forceDisabled("readOnlyMode"):this.clearForceDisabled("readOnlyMode")})}get affectsData(){return this._affectsData}set affectsData(e){this._affectsData=e}refresh(){this.isEnabled=!0}forceDisabled(e){this._disableStack.add(e),this._disableStack.size==1&&(this.on("set:isEnabled",Sf,{priority:"highest"}),this.isEnabled=!1)}clearForceDisabled(e){this._disableStack.delete(e),this._disableStack.size==0&&(this.off("set:isEnabled",Sf),this.refresh())}execute(...e){}destroy(){this.stopListening()}}function Sf(o){o.return=!1,o.stop()}class If extends je{constructor(e){super(e),this._childCommandsDefinitions=[]}refresh(){}execute(...e){const t=this._getFirstEnabledCommand();return!!t&&t.execute(e)}registerChildCommand(e,t={}){Ee(this._childCommandsDefinitions,{command:e,priority:t.priority||"normal"}),e.on("change:isEnabled",()=>this._checkEnabled()),this._checkEnabled()}_checkEnabled(){this.isEnabled=!!this._getFirstEnabledCommand()}_getFirstEnabledCommand(){const e=this._childCommandsDefinitions.find(({command:t})=>t.isEnabled);return e&&e.command}}class Mf extends Ce(){constructor(e,t=[],n=[]){super(),this._context=e,this._plugins=new Map,this._availablePlugins=new Map;for(const i of t)i.pluginName&&this._availablePlugins.set(i.pluginName,i);this._contextPlugins=new Map;for(const[i,r]of n)this._contextPlugins.set(i,r),this._contextPlugins.set(r,i),i.pluginName&&this._availablePlugins.set(i.pluginName,i)}*[Symbol.iterator](){for(const e of this._plugins)typeof e[0]=="function"&&(yield e)}get(e){const t=this._plugins.get(e);if(!t){let n=e;throw typeof e=="function"&&(n=e.pluginName||e.name),new V("plugincollection-plugin-not-loaded",this._context,{plugin:n})}return t}has(e){return this._plugins.has(e)}init(e,t=[],n=[]){const i=this,r=this._context;(function I(L,R=new Set){L.forEach(H=>{c(H)&&(R.has(H)||(R.add(H),H.pluginName&&!i._availablePlugins.has(H.pluginName)&&i._availablePlugins.set(H.pluginName,H),H.requires&&I(H.requires,R)))})})(e),v(e);const s=[...function I(L,R=new Set){return L.map(H=>c(H)?H:i._availablePlugins.get(H)).reduce((H,$)=>R.has($)?H:(R.add($),$.requires&&(v($.requires,$),I($.requires,R).forEach(te=>H.add(te))),H.add($)),new Set)}(e.filter(I=>!f(I,t)))];(function(I,L){for(const R of L){if(typeof R!="function")throw new V("plugincollection-replace-plugin-invalid-type",null,{pluginItem:R});const H=R.pluginName;if(!H)throw new V("plugincollection-replace-plugin-missing-name",null,{pluginItem:R});if(R.requires&&R.requires.length)throw new V("plugincollection-plugin-for-replacing-cannot-have-dependencies",null,{pluginName:H});const $=i._availablePlugins.get(H);if(!$)throw new V("plugincollection-plugin-for-replacing-not-exist",null,{pluginName:H});const te=I.indexOf($);if(te===-1){if(i._contextPlugins.has($))return;throw new V("plugincollection-plugin-for-replacing-not-loaded",null,{pluginName:H})}if($.requires&&$.requires.length)throw new V("plugincollection-replaced-plugin-cannot-have-dependencies",null,{pluginName:H});I.splice(te,1,R),i._availablePlugins.set(H,R)}})(s,n);const a=function(I){return I.map(L=>{let R=i._contextPlugins.get(L);return R=R||new L(r),i._add(L,R),R})}(s);return E(a,"init").then(()=>E(a,"afterInit")).then(()=>a);function c(I){return typeof I=="function"}function u(I){return c(I)&&I.isContextPlugin}function f(I,L){return L.some(R=>R===I||m(I)===R||m(R)===I)}function m(I){return c(I)?I.pluginName||I.name:I}function v(I,L=null){I.map(R=>c(R)?R:i._availablePlugins.get(R)||R).forEach(R=>{(function(H,$){if(!c(H))throw $?new V("plugincollection-soft-required",r,{missingPlugin:H,requiredBy:m($)}):new V("plugincollection-plugin-not-found",r,{plugin:H})})(R,L),function(H,$){if(u($)&&!u(H))throw new V("plugincollection-context-required",r,{plugin:m(H),requiredBy:m($)})}(R,L),function(H,$){if($&&f(H,t))throw new V("plugincollection-required",r,{plugin:m(H),requiredBy:m($)})}(R,L)})}function E(I,L){return I.reduce((R,H)=>H[L]?i._contextPlugins.has(H)?R:R.then(H[L].bind(H)):R,Promise.resolve())}}destroy(){const e=[];for(const[,t]of this)typeof t.destroy!="function"||this._contextPlugins.has(t)||e.push(t.destroy());return Promise.all(e)}_add(e,t){this._plugins.set(e,t);const n=e.pluginName;if(n){if(this._plugins.has(n))throw new V("plugincollection-plugin-name-conflict",null,{pluginName:n,plugin1:this._plugins.get(n).constructor,plugin2:e});this._plugins.set(n,t)}}}class r_{constructor(e){this.config=new rf(e,this.constructor.defaultConfig);const t=this.constructor.builtinPlugins;this.config.define("plugins",t),this.plugins=new Mf(this,t);const n=this.config.get("language")||{};this.locale=new t_({uiLanguage:typeof n=="string"?n:n.ui,contentLanguage:this.config.get("language.content")}),this.t=this.locale.t,this.editors=new _n,this._contextOwner=null}initPlugins(){const e=this.config.get("plugins")||[],t=this.config.get("substitutePlugins")||[];for(const n of e.concat(t)){if(typeof n!="function")throw new V("context-initplugins-constructor-only",null,{Plugin:n});if(n.isContextPlugin!==!0)throw new V("context-initplugins-invalid-plugin",null,{Plugin:n})}return this.plugins.init(e,[],t)}destroy(){return Promise.all(Array.from(this.editors,e=>e.destroy())).then(()=>this.plugins.destroy())}_addEditor(e,t){if(this._contextOwner)throw new V("context-addeditor-private-context");this.editors.add(e),t&&(this._contextOwner=e)}_removeEditor(e){return this.editors.has(e)&&this.editors.remove(e),this._contextOwner===e?this.destroy():Promise.resolve()}_getEditorConfig(){const e={};for(const t of this.config.names())["plugins","removePlugins","extraPlugins"].includes(t)||(e[t]=this.config.get(t));return e}static create(e){return new Promise(t=>{const n=new this(e);t(n.initPlugins().then(()=>n))})}}class gl extends Ke(){constructor(e){super(),this.context=e}destroy(){this.stopListening()}static get isContextPlugin(){return!0}}var s_=w(6062),ye=w.n(s_),Nf=w(4717),a_={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Nf.Z,a_),Nf.Z.locals;const pl=new WeakMap;function Pf(o){const{view:e,element:t,text:n,isDirectHost:i=!0,keepOnFocus:r=!1}=o,s=e.document;pl.has(s)||(pl.set(s,new Map),s.registerPostFixer(a=>Cd(s,a)),s.on("change:isComposing",()=>{e.change(a=>Cd(s,a))},{priority:"high"})),pl.get(s).set(t,{text:n,isDirectHost:i,keepOnFocus:r,hostElement:i?t:null}),e.change(a=>Cd(s,a))}function l_(o,e){return!!e.hasClass("ck-placeholder")&&(o.removeClass("ck-placeholder",e),!0)}function Cd(o,e){const t=pl.get(o),n=[];let i=!1;for(const[r,s]of t)s.isDirectHost&&(n.push(r),Bf(e,r,s)&&(i=!0));for(const[r,s]of t){if(s.isDirectHost)continue;const a=c_(r);a&&(n.includes(a)||(s.hostElement=a,Bf(e,r,s)&&(i=!0)))}return i}function Bf(o,e,t){const{text:n,isDirectHost:i,hostElement:r}=t;let s=!1;return r.getAttribute("data-placeholder")!==n&&(o.setAttribute("data-placeholder",n,r),s=!0),(i||e.childCount==1)&&function(a,c){if(!a.isAttached()||Array.from(a.getChildren()).some(v=>!v.is("uiElement")))return!1;const f=a.document,m=f.selection.anchor;return!(f.isComposing&&m&&m.parent===a||!c&&f.isFocused&&(!m||m.parent===a))}(r,t.keepOnFocus)?function(a,c){return!c.hasClass("ck-placeholder")&&(a.addClass("ck-placeholder",c),!0)}(o,r)&&(s=!0):l_(o,r)&&(s=!0),s}function c_(o){if(o.childCount){const e=o.getChild(0);if(e.is("element")&&!e.is("uiElement")&&!e.is("attributeElement"))return e}return null}class er{is(){throw new Error("is() method is abstract")}}var d_=4;const Lf=function(o){return md(o,d_)};class tr extends Ce(er){constructor(e){super(),this.document=e,this.parent=null}get index(){let e;if(!this.parent)return null;if((e=this.parent.getChildIndex(this))==-1)throw new V("view-node-not-found-in-parent",this);return e}get nextSibling(){const e=this.index;return e!==null&&this.parent.getChild(e+1)||null}get previousSibling(){const e=this.index;return e!==null&&this.parent.getChild(e-1)||null}get root(){let e=this;for(;e.parent;)e=e.parent;return e}isAttached(){return this.root.is("rootElement")}getPath(){const e=[];let t=this;for(;t.parent;)e.unshift(t.index),t=t.parent;return e}getAncestors(e={}){const t=[];let n=e.includeSelf?this:this.parent;for(;n;)t[e.parentFirst?"push":"unshift"](n),n=n.parent;return t}getCommonAncestor(e,t={}){const n=this.getAncestors(t),i=e.getAncestors(t);let r=0;for(;n[r]==i[r]&&n[r];)r++;return r===0?null:n[r-1]}isBefore(e){if(this==e||this.root!==e.root)return!1;const t=this.getPath(),n=e.getPath(),i=Gt(t,n);switch(i){case"prefix":return!0;case"extension":return!1;default:return t[i]<n[i]}}isAfter(e){return this!=e&&this.root===e.root&&!this.isBefore(e)}_remove(){this.parent._removeChildren(this.index)}_fireChange(e,t){this.fire(`change:${e}`,t),this.parent&&this.parent._fireChange(e,t)}toJSON(){const e=Lf(this);return delete e.parent,e}}tr.prototype.is=function(o){return o==="node"||o==="view:node"};class bt extends tr{constructor(e,t){super(e),this._textData=t}get data(){return this._textData}get _data(){return this.data}set _data(e){this._fireChange("text",this),this._textData=e}isSimilar(e){return e instanceof bt&&(this===e||this.data===e.data)}_clone(){return new bt(this.document,this.data)}}bt.prototype.is=function(o){return o==="$text"||o==="view:$text"||o==="text"||o==="view:text"||o==="node"||o==="view:node"};class Li extends er{constructor(e,t,n){if(super(),this.textNode=e,t<0||t>e.data.length)throw new V("view-textproxy-wrong-offsetintext",this);if(n<0||t+n>e.data.length)throw new V("view-textproxy-wrong-length",this);this.data=e.data.substring(t,t+n),this.offsetInText=t}get offsetSize(){return this.data.length}get isPartial(){return this.data.length!==this.textNode.data.length}get parent(){return this.textNode.parent}get root(){return this.textNode.root}get document(){return this.textNode.document}getAncestors(e={}){const t=[];let n=e.includeSelf?this.textNode:this.parent;for(;n!==null;)t[e.parentFirst?"push":"unshift"](n),n=n.parent;return t}}Li.prototype.is=function(o){return o==="$textProxy"||o==="view:$textProxy"||o==="textProxy"||o==="view:textProxy"};class zi{constructor(...e){this._patterns=[],this.add(...e)}add(...e){for(let t of e)(typeof t=="string"||t instanceof RegExp)&&(t={name:t}),this._patterns.push(t)}match(...e){for(const t of e)for(const n of this._patterns){const i=zf(t,n);if(i)return{element:t,pattern:n,match:i}}return null}matchAll(...e){const t=[];for(const n of e)for(const i of this._patterns){const r=zf(n,i);r&&t.push({element:n,pattern:i,match:r})}return t.length>0?t:null}getElementName(){if(this._patterns.length!==1)return null;const e=this._patterns[0],t=e.name;return typeof e=="function"||!t||t instanceof RegExp?null:t}}function zf(o,e){if(typeof e=="function")return e(o);const t={};return e.name&&(t.name=function(n,i){return n instanceof RegExp?!!i.match(n):n===i}(e.name,o.name),!t.name)||e.attributes&&(t.attributes=function(n,i){const r=new Set(i.getAttributeKeys());return rn(n)?(n.style!==void 0&&x("matcher-pattern-deprecated-attributes-style-key",n),n.class!==void 0&&x("matcher-pattern-deprecated-attributes-class-key",n)):(r.delete("style"),r.delete("class")),Ad(n,r,s=>i.getAttribute(s))}(e.attributes,o),!t.attributes)||e.classes&&(t.classes=function(n,i){return Ad(n,i.getClassNames(),()=>{})}(e.classes,o),!t.classes)||e.styles&&(t.styles=function(n,i){return Ad(n,i.getStyleNames(!0),r=>i.getStyle(r))}(e.styles,o),!t.styles)?null:t}function Ad(o,e,t){const n=function(s){return Array.isArray(s)?s.map(a=>rn(a)?(a.key!==void 0&&a.value!==void 0||x("matcher-pattern-missing-key-or-value",a),[a.key,a.value]):[a,!0]):rn(s)?Object.entries(s):[[s,!0]]}(o),i=Array.from(e),r=[];if(n.forEach(([s,a])=>{i.forEach(c=>{(function(u,f){return u===!0||u===f||u instanceof RegExp&&f.match(u)})(s,c)&&function(u,f,m){if(u===!0)return!0;const v=m(f);return u===v||u instanceof RegExp&&!!String(v).match(u)}(a,c,t)&&r.push(c)})}),n.length&&!(r.length<n.length))return r}var u_="[object Symbol]";const ml=function(o){return typeof o=="symbol"||nn(o)&&kn(o)==u_};var h_=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,f_=/^\w*$/;const g_=function(o,e){if(tn(o))return!1;var t=typeof o;return!(t!="number"&&t!="symbol"&&t!="boolean"&&o!=null&&!ml(o))||f_.test(o)||!h_.test(o)||e!=null&&o in Object(e)};var p_="Expected a function";function yd(o,e){if(typeof o!="function"||e!=null&&typeof e!="function")throw new TypeError(p_);var t=function(){var n=arguments,i=e?e.apply(this,n):n[0],r=t.cache;if(r.has(i))return r.get(i);var s=o.apply(this,n);return t.cache=r.set(i,s)||r,s};return t.cache=new(yd.Cache||Go),t}yd.Cache=Go;const m_=yd;var b_=500,k_=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,w_=/\\(\\)?/g,v_=function(o){var e=m_(o,function(n){return t.size===b_&&t.clear(),n}),t=e.cache;return e}(function(o){var e=[];return o.charCodeAt(0)===46&&e.push(""),o.replace(k_,function(t,n,i,r){e.push(i?r.replace(w_,"$1"):n||t)}),e});const __=v_,C_=function(o,e){for(var t=-1,n=o==null?0:o.length,i=Array(n);++t<n;)i[t]=e(o[t],t,o);return i};var A_=1/0,Of=un?un.prototype:void 0,Rf=Of?Of.toString:void 0;const y_=function o(e){if(typeof e=="string")return e;if(tn(e))return C_(e,o)+"";if(ml(e))return Rf?Rf.call(e):"";var t=e+"";return t=="0"&&1/e==-A_?"-0":t},xd=function(o){return o==null?"":y_(o)},Dd=function(o,e){return tn(o)?o:g_(o,e)?[o]:__(xd(o))},x_=function(o){var e=o==null?0:o.length;return e?o[e-1]:void 0};var D_=1/0;const Ed=function(o){if(typeof o=="string"||ml(o))return o;var e=o+"";return e=="0"&&1/o==-D_?"-0":e},jf=function(o,e){for(var t=0,n=(e=Dd(e,o)).length;o!=null&&t<n;)o=o[Ed(e[t++])];return t&&t==n?o:void 0},Ff=function(o,e,t){var n=-1,i=o.length;e<0&&(e=-e>i?0:i+e),(t=t>i?i:t)<0&&(t+=i),i=e>t?0:t-e>>>0,e>>>=0;for(var r=Array(i);++n<i;)r[n]=o[n+e];return r},E_=function(o,e){return e.length<2?o:jf(o,Ff(e,0,-1))},T_=function(o,e){return e=Dd(e,o),(o=E_(o,e))==null||delete o[Ed(x_(e))]},S_=function(o,e){return o==null||T_(o,e)},bl=function(o,e,t){var n=o==null?void 0:jf(o,e);return n===void 0?t:n},Td=function(o,e,t){(t!==void 0&&!Xn(o[e],t)||t===void 0&&!(e in o))&&As(o,e,t)},I_=function(o){return function(e,t,n){for(var i=-1,r=Object(e),s=n(e),a=s.length;a--;){var c=s[o?a:++i];if(t(r[c],c,r)===!1)break}return e}}(),M_=function(o){return nn(o)&&J(o)},Sd=function(o,e){if((e!=="constructor"||typeof o[e]!="function")&&e!="__proto__")return o[e]},N_=function(o){return vo(o,At(o))},P_=function(o,e,t,n,i,r,s){var a=Sd(o,t),c=Sd(e,t),u=s.get(c);if(u)Td(o,t,u);else{var f=r?r(a,c,t+"",o,e,s):void 0,m=f===void 0;if(m){var v=tn(c),E=!v&&oo(c),I=!v&&!E&&S(c);f=c,v||E||I?tn(a)?f=a:M_(a)?f=_o(a):E?(m=!1,f=xt(c,!0)):I?(m=!1,f=X(c,!0)):f=[]:rn(c)||Yo(c)?(f=a,Yo(a)?f=N_(a):ht(a)&&!ko(a)||(f=Zh(c))):m=!1}m&&(s.set(c,f),i(f,c,n,r,s),s.delete(c)),Td(o,t,f)}},B_=function o(e,t,n,i,r){e!==t&&I_(t,function(s,a){if(r||(r=new $o),ht(s))P_(e,t,a,n,o,i,r);else{var c=i?i(Sd(e,a),s,a+"",e,t,r):void 0;c===void 0&&(c=s),Td(e,a,c)}},At)},nr=function(o){return o},L_=function(o,e,t){switch(t.length){case 0:return o.call(e);case 1:return o.call(e,t[0]);case 2:return o.call(e,t[0],t[1]);case 3:return o.call(e,t[0],t[1],t[2])}return o.apply(e,t)};var Vf=Math.max;const z_=function(o,e,t){return e=Vf(e===void 0?o.length-1:e,0),function(){for(var n=arguments,i=-1,r=Vf(n.length-e,0),s=Array(r);++i<r;)s[i]=n[e+i];i=-1;for(var a=Array(e+1);++i<e;)a[i]=n[i];return a[e]=t(s),L_(o,this,a)}},O_=function(o){return function(){return o}},R_=Er?function(o,e){return Er(o,"toString",{configurable:!0,enumerable:!1,value:O_(e),writable:!0})}:nr;var j_=800,F_=16,V_=Date.now;const H_=function(o){var e=0,t=0;return function(){var n=V_(),i=F_-(n-t);if(t=n,i>0){if(++e>=j_)return arguments[0]}else e=0;return o.apply(void 0,arguments)}}(R_),U_=function(o,e){return H_(z_(o,e,nr),o+"")},W_=function(o,e,t){if(!ht(t))return!1;var n=typeof e;return!!(n=="number"?J(t)&&Ts(e,t.length):n=="string"&&e in t)&&Xn(t[e],o)},Hf=function(o){return U_(function(e,t){var n=-1,i=t.length,r=i>1?t[i-1]:void 0,s=i>2?t[2]:void 0;for(r=o.length>3&&typeof r=="function"?(i--,r):void 0,s&&W_(t[0],t[1],s)&&(r=i<3?void 0:r,i=1),e=Object(e);++n<i;){var a=t[n];a&&o(e,a,n,r)}return e})},Uf=Hf(function(o,e,t){B_(o,e,t)}),q_=function(o,e,t,n){if(!ht(o))return o;for(var i=-1,r=(e=Dd(e,o)).length,s=r-1,a=o;a!=null&&++i<r;){var c=Ed(e[i]),u=t;if(c==="__proto__"||c==="constructor"||c==="prototype")return o;if(i!=s){var f=a[c];(u=n?n(f,c,a):void 0)===void 0&&(u=ht(f)?f:Ts(e[i+1])?[]:{})}xs(a,c,u),a=a[c]}return o},G_=function(o,e,t){return o==null?o:q_(o,e,t)};class $_{constructor(e){this._styles={},this._styleProcessor=e}get isEmpty(){const e=Object.entries(this._styles);return!Array.from(e).length}get size(){return this.isEmpty?0:this.getStyleNames().length}setTo(e){this.clear();const t=Array.from(function(n){let i=null,r=0,s=0,a=null;const c=new Map;if(n==="")return c;n.charAt(n.length-1)!=";"&&(n+=";");for(let u=0;u<n.length;u++){const f=n.charAt(u);if(i===null)switch(f){case":":a||(a=n.substr(r,u-r),s=u+1);break;case'"':case"'":i=f;break;case";":{const m=n.substr(s,u-s);a&&c.set(a.trim(),m.trim()),a=null,r=u+1;break}}else f===i&&(i=null)}return c}(e).entries());for(const[n,i]of t)this._styleProcessor.toNormalizedForm(n,i,this._styles)}has(e){if(this.isEmpty)return!1;const t=this._styleProcessor.getReducedForm(e,this._styles).find(([n])=>n===e);return Array.isArray(t)}set(e,t){if(ht(e))for(const[n,i]of Object.entries(e))this._styleProcessor.toNormalizedForm(n,i,this._styles);else this._styleProcessor.toNormalizedForm(e,t,this._styles)}remove(e){const t=Id(e);S_(this._styles,t),delete this._styles[e],this._cleanEmptyObjectsOnPath(t)}getNormalized(e){return this._styleProcessor.getNormalized(e,this._styles)}toString(){return this.isEmpty?"":this._getStylesEntries().map(e=>e.join(":")).sort().join(";")+";"}getAsString(e){if(this.isEmpty)return;if(this._styles[e]&&!ht(this._styles[e]))return this._styles[e];const t=this._styleProcessor.getReducedForm(e,this._styles).find(([n])=>n===e);return Array.isArray(t)?t[1]:void 0}getStyleNames(e=!1){return this.isEmpty?[]:e?this._styleProcessor.getStyleNames(this._styles):this._getStylesEntries().map(([t])=>t)}clear(){this._styles={}}_getStylesEntries(){const e=[],t=Object.keys(this._styles);for(const n of t)e.push(...this._styleProcessor.getReducedForm(n,this._styles));return e}_cleanEmptyObjectsOnPath(e){const t=e.split(".");if(!(t.length>1))return;const n=t.splice(0,t.length-1).join("."),i=bl(this._styles,n);i&&!Array.from(Object.keys(i)).length&&this.remove(n)}}class Y_{constructor(){this._normalizers=new Map,this._extractors=new Map,this._reducers=new Map,this._consumables=new Map}toNormalizedForm(e,t,n){if(ht(t))Md(n,Id(e),t);else if(this._normalizers.has(e)){const i=this._normalizers.get(e),{path:r,value:s}=i(t);Md(n,r,s)}else Md(n,e,t)}getNormalized(e,t){if(!e)return Uf({},t);if(t[e]!==void 0)return t[e];if(this._extractors.has(e)){const n=this._extractors.get(e);if(typeof n=="string")return bl(t,n);const i=n(e,t);if(i)return i}return bl(t,Id(e))}getReducedForm(e,t){const n=this.getNormalized(e,t);return n===void 0?[]:this._reducers.has(e)?this._reducers.get(e)(n):[[e,n]]}getStyleNames(e){const t=Array.from(this._consumables.keys()).filter(i=>{const r=this.getNormalized(i,e);return r&&typeof r=="object"?Object.keys(r).length:r}),n=new Set([...t,...Object.keys(e)]);return Array.from(n.values())}getRelatedStyles(e){return this._consumables.get(e)||[]}setNormalizer(e,t){this._normalizers.set(e,t)}setExtractor(e,t){this._extractors.set(e,t)}setReducer(e,t){this._reducers.set(e,t)}setStyleRelation(e,t){this._mapStyleNames(e,t);for(const n of t)this._mapStyleNames(n,[e])}_mapStyleNames(e,t){this._consumables.has(e)||this._consumables.set(e,[]),this._consumables.get(e).push(...t)}}function Id(o){return o.replace("-",".")}function Md(o,e,t){let n=t;ht(t)&&(n=Uf({},bl(o,e),t)),G_(o,e,n)}class Wn extends tr{constructor(e,t,n,i){if(super(e),this.name=t,this._attrs=function(r){const s=Bi(r);for(const[a,c]of s)c===null?s.delete(a):typeof c!="string"&&s.set(a,String(c));return s}(n),this._children=[],i&&this._insertChild(0,i),this._classes=new Set,this._attrs.has("class")){const r=this._attrs.get("class");Wf(this._classes,r),this._attrs.delete("class")}this._styles=new $_(this.document.stylesProcessor),this._attrs.has("style")&&(this._styles.setTo(this._attrs.get("style")),this._attrs.delete("style")),this._customProperties=new Map,this._unsafeAttributesToRender=[]}get childCount(){return this._children.length}get isEmpty(){return this._children.length===0}getChild(e){return this._children[e]}getChildIndex(e){return this._children.indexOf(e)}getChildren(){return this._children[Symbol.iterator]()}*getAttributeKeys(){this._classes.size>0&&(yield"class"),this._styles.isEmpty||(yield"style"),yield*this._attrs.keys()}*getAttributes(){yield*this._attrs.entries(),this._classes.size>0&&(yield["class",this.getAttribute("class")]),this._styles.isEmpty||(yield["style",this.getAttribute("style")])}getAttribute(e){if(e=="class")return this._classes.size>0?[...this._classes].join(" "):void 0;if(e=="style"){const t=this._styles.toString();return t==""?void 0:t}return this._attrs.get(e)}hasAttribute(e){return e=="class"?this._classes.size>0:e=="style"?!this._styles.isEmpty:this._attrs.has(e)}isSimilar(e){if(!(e instanceof Wn))return!1;if(this===e)return!0;if(this.name!=e.name||this._attrs.size!==e._attrs.size||this._classes.size!==e._classes.size||this._styles.size!==e._styles.size)return!1;for(const[t,n]of this._attrs)if(!e._attrs.has(t)||e._attrs.get(t)!==n)return!1;for(const t of this._classes)if(!e._classes.has(t))return!1;for(const t of this._styles.getStyleNames())if(!e._styles.has(t)||e._styles.getAsString(t)!==this._styles.getAsString(t))return!1;return!0}hasClass(...e){for(const t of e)if(!this._classes.has(t))return!1;return!0}getClassNames(){return this._classes.keys()}getStyle(e){return this._styles.getAsString(e)}getNormalizedStyle(e){return this._styles.getNormalized(e)}getStyleNames(e){return this._styles.getStyleNames(e)}hasStyle(...e){for(const t of e)if(!this._styles.has(t))return!1;return!0}findAncestor(...e){const t=new zi(...e);let n=this.parent;for(;n&&!n.is("documentFragment");){if(t.match(n))return n;n=n.parent}return null}getCustomProperty(e){return this._customProperties.get(e)}*getCustomProperties(){yield*this._customProperties.entries()}getIdentity(){const e=Array.from(this._classes).sort().join(","),t=this._styles.toString(),n=Array.from(this._attrs).map(i=>`${i[0]}="${i[1]}"`).sort().join(" ");return this.name+(e==""?"":` class="${e}"`)+(t?` style="${t}"`:"")+(n==""?"":` ${n}`)}shouldRenderUnsafeAttribute(e){return this._unsafeAttributesToRender.includes(e)}_clone(e=!1){const t=[];if(e)for(const i of this.getChildren())t.push(i._clone(e));const n=new this.constructor(this.document,this.name,this._attrs,t);return n._classes=new Set(this._classes),n._styles.set(this._styles.getNormalized()),n._customProperties=new Map(this._customProperties),n.getFillerOffset=this.getFillerOffset,n._unsafeAttributesToRender=this._unsafeAttributesToRender,n}_appendChild(e){return this._insertChild(this.childCount,e)}_insertChild(e,t){this._fireChange("children",this);let n=0;const i=function(r,s){return typeof s=="string"?[new bt(r,s)]:(bn(s)||(s=[s]),Array.from(s).map(a=>typeof a=="string"?new bt(r,a):a instanceof Li?new bt(r,a.data):a))}(this.document,t);for(const r of i)r.parent!==null&&r._remove(),r.parent=this,r.document=this.document,this._children.splice(e,0,r),e++,n++;return n}_removeChildren(e,t=1){this._fireChange("children",this);for(let n=e;n<e+t;n++)this._children[n].parent=null;return this._children.splice(e,t)}_setAttribute(e,t){const n=String(t);this._fireChange("attributes",this),e=="class"?Wf(this._classes,n):e=="style"?this._styles.setTo(n):this._attrs.set(e,n)}_removeAttribute(e){return this._fireChange("attributes",this),e=="class"?this._classes.size>0&&(this._classes.clear(),!0):e=="style"?!this._styles.isEmpty&&(this._styles.clear(),!0):this._attrs.delete(e)}_addClass(e){this._fireChange("attributes",this);for(const t of Kt(e))this._classes.add(t)}_removeClass(e){this._fireChange("attributes",this);for(const t of Kt(e))this._classes.delete(t)}_setStyle(e,t){this._fireChange("attributes",this),rn(e)?this._styles.set(e):this._styles.set(e,t)}_removeStyle(e){this._fireChange("attributes",this);for(const t of Kt(e))this._styles.remove(t)}_setCustomProperty(e,t){this._customProperties.set(e,t)}_removeCustomProperty(e){return this._customProperties.delete(e)}}function Wf(o,e){const t=e.split(/\s+/);o.clear(),t.forEach(n=>o.add(n))}Wn.prototype.is=function(o,e){return e?e===this.name&&(o==="element"||o==="view:element"):o==="element"||o==="view:element"||o==="node"||o==="view:node"};class Rs extends Wn{constructor(...e){super(...e),this.getFillerOffset=qf}}function qf(){const o=[...this.getChildren()],e=o[this.childCount-1];if(e&&e.is("element","br"))return this.childCount;for(const t of o)if(!t.is("uiElement"))return null;return this.childCount}Rs.prototype.is=function(o,e){return e?e===this.name&&(o==="containerElement"||o==="view:containerElement"||o==="element"||o==="view:element"):o==="containerElement"||o==="view:containerElement"||o==="element"||o==="view:element"||o==="node"||o==="view:node"};class kl extends Ke(Rs){constructor(...e){super(...e);const t=e[0];this.set("isReadOnly",!1),this.set("isFocused",!1),this.bind("isReadOnly").to(t),this.bind("isFocused").to(t,"isFocused",n=>n&&t.selection.editableElement==this),this.listenTo(t.selection,"change",()=>{this.isFocused=t.isFocused&&t.selection.editableElement==this})}destroy(){this.stopListening()}}kl.prototype.is=function(o,e){return e?e===this.name&&(o==="editableElement"||o==="view:editableElement"||o==="containerElement"||o==="view:containerElement"||o==="element"||o==="view:element"):o==="editableElement"||o==="view:editableElement"||o==="containerElement"||o==="view:containerElement"||o==="element"||o==="view:element"||o==="node"||o==="view:node"};const Gf=Symbol("rootName");class $f extends kl{constructor(e,t){super(e,t),this.rootName="main"}get rootName(){return this.getCustomProperty(Gf)}set rootName(e){this._setCustomProperty(Gf,e)}set _name(e){this.name=e}}$f.prototype.is=function(o,e){return e?e===this.name&&(o==="rootElement"||o==="view:rootElement"||o==="editableElement"||o==="view:editableElement"||o==="containerElement"||o==="view:containerElement"||o==="element"||o==="view:element"):o==="rootElement"||o==="view:rootElement"||o==="editableElement"||o==="view:editableElement"||o==="containerElement"||o==="view:containerElement"||o==="element"||o==="view:element"||o==="node"||o==="view:node"};class ir{constructor(e={}){if(!e.boundaries&&!e.startPosition)throw new V("view-tree-walker-no-start-position",null);if(e.direction&&e.direction!="forward"&&e.direction!="backward")throw new V("view-tree-walker-unknown-direction",e.startPosition,{direction:e.direction});this.boundaries=e.boundaries||null,e.startPosition?this.position=fe._createAt(e.startPosition):this.position=fe._createAt(e.boundaries[e.direction=="backward"?"end":"start"]),this.direction=e.direction||"forward",this.singleCharacters=!!e.singleCharacters,this.shallow=!!e.shallow,this.ignoreElementEnd=!!e.ignoreElementEnd,this._boundaryStartParent=this.boundaries?this.boundaries.start.parent:null,this._boundaryEndParent=this.boundaries?this.boundaries.end.parent:null}[Symbol.iterator](){return this}skip(e){let t,n,i;do i=this.position,{done:t,value:n}=this.next();while(!t&&e(n));t||(this.position=i)}next(){return this.direction=="forward"?this._next():this._previous()}_next(){let e=this.position.clone();const t=this.position,n=e.parent;if(n.parent===null&&e.offset===n.childCount)return{done:!0,value:void 0};if(n===this._boundaryEndParent&&e.offset==this.boundaries.end.offset)return{done:!0,value:void 0};let i;if(n instanceof bt){if(e.isAtEnd)return this.position=fe._createAfter(n),this._next();i=n.data[e.offset]}else i=n.getChild(e.offset);if(i instanceof Wn)return this.shallow?e.offset++:e=new fe(i,0),this.position=e,this._formatReturnValue("elementStart",i,t,e,1);if(i instanceof bt){if(this.singleCharacters)return e=new fe(i,0),this.position=e,this._next();{let r,s=i.data.length;return i==this._boundaryEndParent?(s=this.boundaries.end.offset,r=new Li(i,0,s),e=fe._createAfter(r)):(r=new Li(i,0,i.data.length),e.offset++),this.position=e,this._formatReturnValue("text",r,t,e,s)}}if(typeof i=="string"){let r;this.singleCharacters?r=1:r=(n===this._boundaryEndParent?this.boundaries.end.offset:n.data.length)-e.offset;const s=new Li(n,e.offset,r);return e.offset+=r,this.position=e,this._formatReturnValue("text",s,t,e,r)}return e=fe._createAfter(n),this.position=e,this.ignoreElementEnd?this._next():this._formatReturnValue("elementEnd",n,t,e)}_previous(){let e=this.position.clone();const t=this.position,n=e.parent;if(n.parent===null&&e.offset===0)return{done:!0,value:void 0};if(n==this._boundaryStartParent&&e.offset==this.boundaries.start.offset)return{done:!0,value:void 0};let i;if(n instanceof bt){if(e.isAtStart)return this.position=fe._createBefore(n),this._previous();i=n.data[e.offset-1]}else i=n.getChild(e.offset-1);if(i instanceof Wn)return this.shallow?(e.offset--,this.position=e,this._formatReturnValue("elementStart",i,t,e,1)):(e=new fe(i,i.childCount),this.position=e,this.ignoreElementEnd?this._previous():this._formatReturnValue("elementEnd",i,t,e));if(i instanceof bt){if(this.singleCharacters)return e=new fe(i,i.data.length),this.position=e,this._previous();{let r,s=i.data.length;if(i==this._boundaryStartParent){const a=this.boundaries.start.offset;r=new Li(i,a,i.data.length-a),s=r.data.length,e=fe._createBefore(r)}else r=new Li(i,0,i.data.length),e.offset--;return this.position=e,this._formatReturnValue("text",r,t,e,s)}}if(typeof i=="string"){let r;if(this.singleCharacters)r=1;else{const a=n===this._boundaryStartParent?this.boundaries.start.offset:0;r=e.offset-a}e.offset-=r;const s=new Li(n,e.offset,r);return this.position=e,this._formatReturnValue("text",s,t,e,r)}return e=fe._createBefore(n),this.position=e,this._formatReturnValue("elementStart",n,t,e,1)}_formatReturnValue(e,t,n,i,r){return t instanceof Li&&(t.offsetInText+t.data.length==t.textNode.data.length&&(this.direction!="forward"||this.boundaries&&this.boundaries.end.isEqual(this.position)?n=fe._createAfter(t.textNode):(i=fe._createAfter(t.textNode),this.position=i)),t.offsetInText===0&&(this.direction!="backward"||this.boundaries&&this.boundaries.start.isEqual(this.position)?n=fe._createBefore(t.textNode):(i=fe._createBefore(t.textNode),this.position=i))),{done:!1,value:{type:e,item:t,previousPosition:n,nextPosition:i,length:r}}}}class fe extends er{constructor(e,t){super(),this.parent=e,this.offset=t}get nodeAfter(){return this.parent.is("$text")?null:this.parent.getChild(this.offset)||null}get nodeBefore(){return this.parent.is("$text")?null:this.parent.getChild(this.offset-1)||null}get isAtStart(){return this.offset===0}get isAtEnd(){const e=this.parent.is("$text")?this.parent.data.length:this.parent.childCount;return this.offset===e}get root(){return this.parent.root}get editableElement(){let e=this.parent;for(;!(e instanceof kl);){if(!e.parent)return null;e=e.parent}return e}getShiftedBy(e){const t=fe._createAt(this),n=t.offset+e;return t.offset=n<0?0:n,t}getLastMatchingPosition(e,t={}){t.startPosition=this;const n=new ir(t);return n.skip(e),n.position}getAncestors(){return this.parent.is("documentFragment")?[this.parent]:this.parent.getAncestors({includeSelf:!0})}getCommonAncestor(e){const t=this.getAncestors(),n=e.getAncestors();let i=0;for(;t[i]==n[i]&&t[i];)i++;return i===0?null:t[i-1]}isEqual(e){return this.parent==e.parent&&this.offset==e.offset}isBefore(e){return this.compareWith(e)=="before"}isAfter(e){return this.compareWith(e)=="after"}compareWith(e){if(this.root!==e.root)return"different";if(this.isEqual(e))return"same";const t=this.parent.is("node")?this.parent.getPath():[],n=e.parent.is("node")?e.parent.getPath():[];t.push(this.offset),n.push(e.offset);const i=Gt(t,n);switch(i){case"prefix":return"before";case"extension":return"after";default:return t[i]<n[i]?"before":"after"}}getWalker(e={}){return e.startPosition=this,new ir(e)}clone(){return new fe(this.parent,this.offset)}static _createAt(e,t){if(e instanceof fe)return new this(e.parent,e.offset);{const n=e;if(t=="end")t=n.is("$text")?n.data.length:n.childCount;else{if(t=="before")return this._createBefore(n);if(t=="after")return this._createAfter(n);if(t!==0&&!t)throw new V("view-createpositionat-offset-required",n)}return new fe(n,t)}}static _createAfter(e){if(e.is("$textProxy"))return new fe(e.textNode,e.offsetInText+e.data.length);if(!e.parent)throw new V("view-position-after-root",e,{root:e});return new fe(e.parent,e.index+1)}static _createBefore(e){if(e.is("$textProxy"))return new fe(e.textNode,e.offsetInText);if(!e.parent)throw new V("view-position-before-root",e,{root:e});return new fe(e.parent,e.index)}}fe.prototype.is=function(o){return o==="position"||o==="view:position"};class Ne extends er{constructor(e,t=null){super(),this.start=e.clone(),this.end=t?t.clone():e.clone()}*[Symbol.iterator](){yield*new ir({boundaries:this,ignoreElementEnd:!0})}get isCollapsed(){return this.start.isEqual(this.end)}get isFlat(){return this.start.parent===this.end.parent}get root(){return this.start.root}getEnlarged(){let e=this.start.getLastMatchingPosition(wl,{direction:"backward"}),t=this.end.getLastMatchingPosition(wl);return e.parent.is("$text")&&e.isAtStart&&(e=fe._createBefore(e.parent)),t.parent.is("$text")&&t.isAtEnd&&(t=fe._createAfter(t.parent)),new Ne(e,t)}getTrimmed(){let e=this.start.getLastMatchingPosition(wl);if(e.isAfter(this.end)||e.isEqual(this.end))return new Ne(e,e);let t=this.end.getLastMatchingPosition(wl,{direction:"backward"});const n=e.nodeAfter,i=t.nodeBefore;return n&&n.is("$text")&&(e=new fe(n,0)),i&&i.is("$text")&&(t=new fe(i,i.data.length)),new Ne(e,t)}isEqual(e){return this==e||this.start.isEqual(e.start)&&this.end.isEqual(e.end)}containsPosition(e){return e.isAfter(this.start)&&e.isBefore(this.end)}containsRange(e,t=!1){e.isCollapsed&&(t=!1);const n=this.containsPosition(e.start)||t&&this.start.isEqual(e.start),i=this.containsPosition(e.end)||t&&this.end.isEqual(e.end);return n&&i}getDifference(e){const t=[];return this.isIntersecting(e)?(this.containsPosition(e.start)&&t.push(new Ne(this.start,e.start)),this.containsPosition(e.end)&&t.push(new Ne(e.end,this.end))):t.push(this.clone()),t}getIntersection(e){if(this.isIntersecting(e)){let t=this.start,n=this.end;return this.containsPosition(e.start)&&(t=e.start),this.containsPosition(e.end)&&(n=e.end),new Ne(t,n)}return null}getWalker(e={}){return e.boundaries=this,new ir(e)}getCommonAncestor(){return this.start.getCommonAncestor(this.end)}getContainedElement(){if(this.isCollapsed)return null;let e=this.start.nodeAfter,t=this.end.nodeBefore;return this.start.parent.is("$text")&&this.start.isAtEnd&&this.start.parent.nextSibling&&(e=this.start.parent.nextSibling),this.end.parent.is("$text")&&this.end.isAtStart&&this.end.parent.previousSibling&&(t=this.end.parent.previousSibling),e&&e.is("element")&&e===t?e:null}clone(){return new Ne(this.start,this.end)}*getItems(e={}){e.boundaries=this,e.ignoreElementEnd=!0;const t=new ir(e);for(const n of t)yield n.item}*getPositions(e={}){e.boundaries=this;const t=new ir(e);yield t.position;for(const n of t)yield n.nextPosition}isIntersecting(e){return this.start.isBefore(e.end)&&this.end.isAfter(e.start)}static _createFromParentsAndOffsets(e,t,n,i){return new this(new fe(e,t),new fe(n,i))}static _createFromPositionAndShift(e,t){const n=e,i=e.getShiftedBy(t);return t>0?new this(n,i):new this(i,n)}static _createIn(e){return this._createFromParentsAndOffsets(e,0,e,e.childCount)}static _createOn(e){const t=e.is("$textProxy")?e.offsetSize:1;return this._createFromPositionAndShift(fe._createBefore(e),t)}}function wl(o){return!(!o.item.is("attributeElement")&&!o.item.is("uiElement"))}Ne.prototype.is=function(o){return o==="range"||o==="view:range"};class Oi extends Ce(er){constructor(...e){super(),this._ranges=[],this._lastRangeBackward=!1,this._isFake=!1,this._fakeSelectionLabel="",e.length&&this.setTo(...e)}get isFake(){return this._isFake}get fakeSelectionLabel(){return this._fakeSelectionLabel}get anchor(){if(!this._ranges.length)return null;const e=this._ranges[this._ranges.length-1];return(this._lastRangeBackward?e.end:e.start).clone()}get focus(){if(!this._ranges.length)return null;const e=this._ranges[this._ranges.length-1];return(this._lastRangeBackward?e.start:e.end).clone()}get isCollapsed(){return this.rangeCount===1&&this._ranges[0].isCollapsed}get rangeCount(){return this._ranges.length}get isBackward(){return!this.isCollapsed&&this._lastRangeBackward}get editableElement(){return this.anchor?this.anchor.editableElement:null}*getRanges(){for(const e of this._ranges)yield e.clone()}getFirstRange(){let e=null;for(const t of this._ranges)e&&!t.start.isBefore(e.start)||(e=t);return e?e.clone():null}getLastRange(){let e=null;for(const t of this._ranges)e&&!t.end.isAfter(e.end)||(e=t);return e?e.clone():null}getFirstPosition(){const e=this.getFirstRange();return e?e.start.clone():null}getLastPosition(){const e=this.getLastRange();return e?e.end.clone():null}isEqual(e){if(this.isFake!=e.isFake||this.isFake&&this.fakeSelectionLabel!=e.fakeSelectionLabel||this.rangeCount!=e.rangeCount)return!1;if(this.rangeCount===0)return!0;if(!this.anchor.isEqual(e.anchor)||!this.focus.isEqual(e.focus))return!1;for(const t of this._ranges){let n=!1;for(const i of e._ranges)if(t.isEqual(i)){n=!0;break}if(!n)return!1}return!0}isSimilar(e){if(this.isBackward!=e.isBackward)return!1;const t=Fn(this.getRanges());if(t!=Fn(e.getRanges()))return!1;if(t==0)return!0;for(let n of this.getRanges()){n=n.getTrimmed();let i=!1;for(let r of e.getRanges())if(r=r.getTrimmed(),n.start.isEqual(r.start)&&n.end.isEqual(r.end)){i=!0;break}if(!i)return!1}return!0}getSelectedElement(){return this.rangeCount!==1?null:this.getFirstRange().getContainedElement()}setTo(...e){let[t,n,i]=e;if(typeof n=="object"&&(i=n,n=void 0),t===null)this._setRanges([]),this._setFakeOptions(i);else if(t instanceof Oi||t instanceof Nd)this._setRanges(t.getRanges(),t.isBackward),this._setFakeOptions({fake:t.isFake,label:t.fakeSelectionLabel});else if(t instanceof Ne)this._setRanges([t],i&&i.backward),this._setFakeOptions(i);else if(t instanceof fe)this._setRanges([new Ne(t)]),this._setFakeOptions(i);else if(t instanceof tr){const r=!!i&&!!i.backward;let s;if(n===void 0)throw new V("view-selection-setto-required-second-parameter",this);s=n=="in"?Ne._createIn(t):n=="on"?Ne._createOn(t):new Ne(fe._createAt(t,n)),this._setRanges([s],r),this._setFakeOptions(i)}else{if(!bn(t))throw new V("view-selection-setto-not-selectable",this);this._setRanges(t,i&&i.backward),this._setFakeOptions(i)}this.fire("change")}setFocus(e,t){if(this.anchor===null)throw new V("view-selection-setfocus-no-ranges",this);const n=fe._createAt(e,t);if(n.compareWith(this.focus)=="same")return;const i=this.anchor;this._ranges.pop(),n.compareWith(i)=="before"?this._addRange(new Ne(n,i),!0):this._addRange(new Ne(i,n)),this.fire("change")}_setRanges(e,t=!1){e=Array.from(e),this._ranges=[];for(const n of e)this._addRange(n);this._lastRangeBackward=!!t}_setFakeOptions(e={}){this._isFake=!!e.fake,this._fakeSelectionLabel=e.fake&&e.label||""}_addRange(e,t=!1){if(!(e instanceof Ne))throw new V("view-selection-add-range-not-range",this);this._pushRange(e),this._lastRangeBackward=!!t}_pushRange(e){for(const t of this._ranges)if(e.isIntersecting(t))throw new V("view-selection-range-intersects",this,{addedRange:e,intersectingRange:t});this._ranges.push(new Ne(e.start,e.end))}}Oi.prototype.is=function(o){return o==="selection"||o==="view:selection"};class Nd extends Ce(er){constructor(...e){super(),this._selection=new Oi,this._selection.delegate("change").to(this),e.length&&this._selection.setTo(...e)}get isFake(){return this._selection.isFake}get fakeSelectionLabel(){return this._selection.fakeSelectionLabel}get anchor(){return this._selection.anchor}get focus(){return this._selection.focus}get isCollapsed(){return this._selection.isCollapsed}get rangeCount(){return this._selection.rangeCount}get isBackward(){return this._selection.isBackward}get editableElement(){return this._selection.editableElement}get _ranges(){return this._selection._ranges}*getRanges(){yield*this._selection.getRanges()}getFirstRange(){return this._selection.getFirstRange()}getLastRange(){return this._selection.getLastRange()}getFirstPosition(){return this._selection.getFirstPosition()}getLastPosition(){return this._selection.getLastPosition()}getSelectedElement(){return this._selection.getSelectedElement()}isEqual(e){return this._selection.isEqual(e)}isSimilar(e){return this._selection.isSimilar(e)}_setTo(...e){this._selection.setTo(...e)}_setFocus(e,t){this._selection.setFocus(e,t)}}Nd.prototype.is=function(o){return o==="selection"||o=="documentSelection"||o=="view:selection"||o=="view:documentSelection"};class Br extends se{constructor(e,t,n){super(e,t),this.startRange=n,this._eventPhase="none",this._currentTarget=null}get eventPhase(){return this._eventPhase}get currentTarget(){return this._currentTarget}}const Pd=Symbol("bubbling contexts");function Bd(o){return class extends o{fire(e,...t){try{const n=e instanceof se?e:new se(this,e),i=Ld(this);if(!i.size)return;if(js(n,"capturing",this),Lr(i,"$capture",n,...t))return n.return;const r=n.startRange||this.selection.getFirstRange(),s=r?r.getContainedElement():null,a=!!s&&!!Yf(i,s);let c=s||function(u){if(!u)return null;const f=u.start.parent,m=u.end.parent,v=f.getPath(),E=m.getPath();return v.length>E.length?f:m}(r);if(js(n,"atTarget",c),!a){if(Lr(i,"$text",n,...t))return n.return;js(n,"bubbling",c)}for(;c;){if(c.is("rootElement")){if(Lr(i,"$root",n,...t))return n.return}else if(c.is("element")&&Lr(i,c.name,n,...t))return n.return;if(Lr(i,c,n,...t))return n.return;c=c.parent,js(n,"bubbling",c)}return js(n,"bubbling",this),Lr(i,"$document",n,...t),n.return}catch(n){V.rethrowUnexpectedError(n,this)}}_addEventListener(e,t,n){const i=Kt(n.context||"$document"),r=Ld(this);for(const s of i){let a=r.get(s);a||(a=new(Ce()),r.set(s,a)),this.listenTo(a,e,t,n)}}_removeEventListener(e,t){const n=Ld(this);for(const i of n.values())this.stopListening(i,e,t)}}}{const o=Bd(Object);["fire","_addEventListener","_removeEventListener"].forEach(e=>{Bd[e]=o.prototype[e]})}function js(o,e,t){o instanceof Br&&(o._eventPhase=e,o._currentTarget=t)}function Lr(o,e,t,...n){const i=typeof e=="string"?o.get(e):Yf(o,e);return!!i&&(i.fire(t,...n),t.stop.called)}function Yf(o,e){for(const[t,n]of o)if(typeof t=="function"&&t(e))return n;return null}function Ld(o){return o[Pd]||(o[Pd]=new Map),o[Pd]}class vl extends Bd(Ke()){constructor(e){super(),this.selection=new Nd,this.roots=new _n({idProperty:"rootName"}),this.stylesProcessor=e,this.set("isReadOnly",!1),this.set("isFocused",!1),this.set("isSelecting",!1),this.set("isComposing",!1),this._postFixers=new Set}getRoot(e="main"){return this.roots.get(e)}registerPostFixer(e){this._postFixers.add(e)}destroy(){this.roots.map(e=>e.destroy()),this.stopListening()}_callPostFixers(e){let t=!1;do for(const n of this._postFixers)if(t=n(e),t)break;while(t)}}class or extends Wn{constructor(...e){super(...e),this.getFillerOffset=K_,this._priority=10,this._id=null,this._clonesGroup=null}get priority(){return this._priority}get id(){return this._id}getElementsWithSameId(){if(this.id===null)throw new V("attribute-element-get-elements-with-same-id-no-id",this);return new Set(this._clonesGroup)}isSimilar(e){return this.id!==null||e.id!==null?this.id===e.id:super.isSimilar(e)&&this.priority==e.priority}_clone(e=!1){const t=super._clone(e);return t._priority=this._priority,t._id=this._id,t}}function K_(){if(zd(this))return null;let o=this.parent;for(;o&&o.is("attributeElement");){if(zd(o)>1)return null;o=o.parent}return!o||zd(o)>1?null:this.childCount}function zd(o){return Array.from(o.getChildren()).filter(e=>!e.is("uiElement")).length}or.DEFAULT_PRIORITY=10,or.prototype.is=function(o,e){return e?e===this.name&&(o==="attributeElement"||o==="view:attributeElement"||o==="element"||o==="view:element"):o==="attributeElement"||o==="view:attributeElement"||o==="element"||o==="view:element"||o==="node"||o==="view:node"};class Od extends Wn{constructor(e,t,n,i){super(e,t,n,i),this.getFillerOffset=Q_}_insertChild(e,t){if(t&&(t instanceof tr||Array.from(t).length>0))throw new V("view-emptyelement-cannot-add",[this,t]);return 0}}function Q_(){return null}Od.prototype.is=function(o,e){return e?e===this.name&&(o==="emptyElement"||o==="view:emptyElement"||o==="element"||o==="view:element"):o==="emptyElement"||o==="view:emptyElement"||o==="element"||o==="view:element"||o==="node"||o==="view:node"};class _l extends Wn{constructor(...e){super(...e),this.getFillerOffset=J_}_insertChild(e,t){if(t&&(t instanceof tr||Array.from(t).length>0))throw new V("view-uielement-cannot-add",[this,t]);return 0}render(e,t){return this.toDomElement(e)}toDomElement(e){const t=e.createElement(this.name);for(const n of this.getAttributeKeys())t.setAttribute(n,this.getAttribute(n));return t}}function Z_(o){o.document.on("arrowKey",(e,t)=>function(n,i,r){if(i.keyCode==tt.arrowright){const s=i.domTarget.ownerDocument.defaultView.getSelection(),a=s.rangeCount==1&&s.getRangeAt(0).collapsed;if(a||i.shiftKey){const c=s.focusNode,u=s.focusOffset,f=r.domPositionToView(c,u);if(f===null)return;let m=!1;const v=f.getLastMatchingPosition(E=>(E.item.is("uiElement")&&(m=!0),!(!E.item.is("uiElement")&&!E.item.is("attributeElement"))));if(m){const E=r.viewPositionToDom(v);a?s.collapse(E.parent,E.offset):s.extend(E.parent,E.offset)}}}}(0,t,o.domConverter),{priority:"low"})}function J_(){return null}_l.prototype.is=function(o,e){return e?e===this.name&&(o==="uiElement"||o==="view:uiElement"||o==="element"||o==="view:element"):o==="uiElement"||o==="view:uiElement"||o==="element"||o==="view:element"||o==="node"||o==="view:node"};class Rd extends Wn{constructor(...e){super(...e),this.getFillerOffset=X_}_insertChild(e,t){if(t&&(t instanceof tr||Array.from(t).length>0))throw new V("view-rawelement-cannot-add",[this,t]);return 0}render(){}}function X_(){return null}Rd.prototype.is=function(o,e){return e?e===this.name&&(o==="rawElement"||o==="view:rawElement"||o==="element"||o==="view:element"):o==="rawElement"||o==="view:rawElement"||o===this.name||o==="view:"+this.name||o==="element"||o==="view:element"||o==="node"||o==="view:node"};class rr extends Ce(er){constructor(e,t){super(),this.document=e,this._children=[],t&&this._insertChild(0,t),this._customProperties=new Map}[Symbol.iterator](){return this._children[Symbol.iterator]()}get childCount(){return this._children.length}get isEmpty(){return this.childCount===0}get root(){return this}get parent(){return null}getCustomProperty(e){return this._customProperties.get(e)}*getCustomProperties(){yield*this._customProperties.entries()}_appendChild(e){return this._insertChild(this.childCount,e)}getChild(e){return this._children[e]}getChildIndex(e){return this._children.indexOf(e)}getChildren(){return this._children[Symbol.iterator]()}_insertChild(e,t){this._fireChange("children",this);let n=0;const i=function(r,s){return typeof s=="string"?[new bt(r,s)]:(bn(s)||(s=[s]),Array.from(s).map(a=>typeof a=="string"?new bt(r,a):a instanceof Li?new bt(r,a.data):a))}(this.document,t);for(const r of i)r.parent!==null&&r._remove(),r.parent=this,this._children.splice(e,0,r),e++,n++;return n}_removeChildren(e,t=1){this._fireChange("children",this);for(let n=e;n<e+t;n++)this._children[n].parent=null;return this._children.splice(e,t)}_fireChange(e,t){this.fire("change:"+e,t)}_setCustomProperty(e,t){this._customProperties.set(e,t)}_removeCustomProperty(e){return this._customProperties.delete(e)}}rr.prototype.is=function(o){return o==="documentFragment"||o==="view:documentFragment"};class Kf{constructor(e){this.document=e,this._cloneGroups=new Map,this._slotFactory=null}setSelection(...e){this.document.selection._setTo(...e)}setSelectionFocus(...e){this.document.selection._setFocus(...e)}createDocumentFragment(e){return new rr(this.document,e)}createText(e){return new bt(this.document,e)}createAttributeElement(e,t,n={}){const i=new or(this.document,e,t);return typeof n.priority=="number"&&(i._priority=n.priority),n.id&&(i._id=n.id),n.renderUnsafeAttributes&&i._unsafeAttributesToRender.push(...n.renderUnsafeAttributes),i}createContainerElement(e,t,n={},i={}){let r=null;rn(n)?i=n:r=n;const s=new Rs(this.document,e,t,r);return i.renderUnsafeAttributes&&s._unsafeAttributesToRender.push(...i.renderUnsafeAttributes),s}createEditableElement(e,t,n={}){const i=new kl(this.document,e,t);return n.renderUnsafeAttributes&&i._unsafeAttributesToRender.push(...n.renderUnsafeAttributes),i}createEmptyElement(e,t,n={}){const i=new Od(this.document,e,t);return n.renderUnsafeAttributes&&i._unsafeAttributesToRender.push(...n.renderUnsafeAttributes),i}createUIElement(e,t,n){const i=new _l(this.document,e,t);return n&&(i.render=n),i}createRawElement(e,t,n,i={}){const r=new Rd(this.document,e,t);return n&&(r.render=n),i.renderUnsafeAttributes&&r._unsafeAttributesToRender.push(...i.renderUnsafeAttributes),r}setAttribute(e,t,n){n._setAttribute(e,t)}removeAttribute(e,t){t._removeAttribute(e)}addClass(e,t){t._addClass(e)}removeClass(e,t){t._removeClass(e)}setStyle(e,t,n){rn(e)&&n===void 0?t._setStyle(e):n._setStyle(e,t)}removeStyle(e,t){t._removeStyle(e)}setCustomProperty(e,t,n){n._setCustomProperty(e,t)}removeCustomProperty(e,t){return t._removeCustomProperty(e)}breakAttributes(e){return e instanceof fe?this._breakAttributes(e):this._breakAttributesRange(e)}breakContainer(e){const t=e.parent;if(!t.is("containerElement"))throw new V("view-writer-break-non-container-element",this.document);if(!t.parent)throw new V("view-writer-break-root",this.document);if(e.isAtStart)return fe._createBefore(t);if(!e.isAtEnd){const n=t._clone(!1);this.insert(fe._createAfter(t),n);const i=new Ne(e,fe._createAt(t,"end")),r=new fe(n,0);this.move(i,r)}return fe._createAfter(t)}mergeAttributes(e){const t=e.offset,n=e.parent;if(n.is("$text"))return e;if(n.is("attributeElement")&&n.childCount===0){const s=n.parent,a=n.index;return n._remove(),this._removeFromClonedElementsGroup(n),this.mergeAttributes(new fe(s,a))}const i=n.getChild(t-1),r=n.getChild(t);if(!i||!r)return e;if(i.is("$text")&&r.is("$text"))return Zf(i,r);if(i.is("attributeElement")&&r.is("attributeElement")&&i.isSimilar(r)){const s=i.childCount;return i._appendChild(r.getChildren()),r._remove(),this._removeFromClonedElementsGroup(r),this.mergeAttributes(new fe(i,s))}return e}mergeContainers(e){const t=e.nodeBefore,n=e.nodeAfter;if(!(t&&n&&t.is("containerElement")&&n.is("containerElement")))throw new V("view-writer-merge-containers-invalid-position",this.document);const i=t.getChild(t.childCount-1),r=i instanceof bt?fe._createAt(i,"end"):fe._createAt(t,"end");return this.move(Ne._createIn(n),fe._createAt(t,"end")),this.remove(Ne._createOn(n)),r}insert(e,t){Jf(t=bn(t)?[...t]:[t],this.document);const n=t.reduce((s,a)=>{const c=s[s.length-1],u=!a.is("uiElement");return c&&c.breakAttributes==u?c.nodes.push(a):s.push({breakAttributes:u,nodes:[a]}),s},[]);let i=null,r=e;for(const{nodes:s,breakAttributes:a}of n){const c=this._insertNodes(r,s,a);i||(i=c.start),r=c.end}return i?new Ne(i,r):new Ne(e)}remove(e){const t=e instanceof Ne?e:Ne._createOn(e);if(Fs(t,this.document),t.isCollapsed)return new rr(this.document);const{start:n,end:i}=this._breakAttributesRange(t,!0),r=n.parent,s=i.offset-n.offset,a=r._removeChildren(n.offset,s);for(const u of a)this._removeFromClonedElementsGroup(u);const c=this.mergeAttributes(n);return t.start=c,t.end=c.clone(),new rr(this.document,a)}clear(e,t){Fs(e,this.document);const n=e.getWalker({direction:"backward",ignoreElementEnd:!0});for(const i of n){const r=i.item;let s;if(r.is("element")&&t.isSimilar(r))s=Ne._createOn(r);else if(!i.nextPosition.isAfter(e.start)&&r.is("$textProxy")){const a=r.getAncestors().find(c=>c.is("element")&&t.isSimilar(c));a&&(s=Ne._createIn(a))}s&&(s.end.isAfter(e.end)&&(s.end=e.end),s.start.isBefore(e.start)&&(s.start=e.start),this.remove(s))}}move(e,t){let n;if(t.isAfter(e.end)){const i=(t=this._breakAttributes(t,!0)).parent,r=i.childCount;e=this._breakAttributesRange(e,!0),n=this.remove(e),t.offset+=i.childCount-r}else n=this.remove(e);return this.insert(t,n)}wrap(e,t){if(!(t instanceof or))throw new V("view-writer-wrap-invalid-attribute",this.document);if(Fs(e,this.document),e.isCollapsed){let i=e.start;i.parent.is("element")&&(n=i.parent,!Array.from(n.getChildren()).some(s=>!s.is("uiElement")))&&(i=i.getLastMatchingPosition(s=>s.item.is("uiElement"))),i=this._wrapPosition(i,t);const r=this.document.selection;return r.isCollapsed&&r.getFirstPosition().isEqual(e.start)&&this.setSelection(i),new Ne(i)}return this._wrapRange(e,t);var n}unwrap(e,t){if(!(t instanceof or))throw new V("view-writer-unwrap-invalid-attribute",this.document);if(Fs(e,this.document),e.isCollapsed)return e;const{start:n,end:i}=this._breakAttributesRange(e,!0),r=n.parent,s=this._unwrapChildren(r,n.offset,i.offset,t),a=this.mergeAttributes(s.start);a.isEqual(s.start)||s.end.offset--;const c=this.mergeAttributes(s.end);return new Ne(a,c)}rename(e,t){const n=new Rs(this.document,e,t.getAttributes());return this.insert(fe._createAfter(t),n),this.move(Ne._createIn(t),fe._createAt(n,0)),this.remove(Ne._createOn(t)),n}clearClonedElementsGroup(e){this._cloneGroups.delete(e)}createPositionAt(e,t){return fe._createAt(e,t)}createPositionAfter(e){return fe._createAfter(e)}createPositionBefore(e){return fe._createBefore(e)}createRange(...e){return new Ne(...e)}createRangeOn(e){return Ne._createOn(e)}createRangeIn(e){return Ne._createIn(e)}createSelection(...e){return new Oi(...e)}createSlot(e){if(!this._slotFactory)throw new V("view-writer-invalid-create-slot-context",this.document);return this._slotFactory(this,e)}_registerSlotFactory(e){this._slotFactory=e}_clearSlotFactory(){this._slotFactory=null}_insertNodes(e,t,n){let i,r;if(i=n?jd(e):e.parent.is("$text")?e.parent.parent:e.parent,!i)throw new V("view-writer-invalid-position-container",this.document);r=n?this._breakAttributes(e,!0):e.parent.is("$text")?Fd(e):e;const s=i._insertChild(r.offset,t);for(const f of t)this._addToClonedElementsGroup(f);const a=r.getShiftedBy(s),c=this.mergeAttributes(r);c.isEqual(r)||a.offset--;const u=this.mergeAttributes(a);return new Ne(c,u)}_wrapChildren(e,t,n,i){let r=t;const s=[];for(;r<n;){const c=e.getChild(r),u=c.is("$text"),f=c.is("attributeElement");if(f&&this._wrapAttributeElement(i,c))s.push(new fe(e,r));else if(u||!f||eC(i,c)){const m=i._clone();c._remove(),m._appendChild(c),e._insertChild(r,m),this._addToClonedElementsGroup(m),s.push(new fe(e,r))}else this._wrapChildren(c,0,c.childCount,i);r++}let a=0;for(const c of s)c.offset-=a,c.offset!=t&&(this.mergeAttributes(c).isEqual(c)||(a++,n--));return Ne._createFromParentsAndOffsets(e,t,e,n)}_unwrapChildren(e,t,n,i){let r=t;const s=[];for(;r<n;){const c=e.getChild(r);if(c.is("attributeElement"))if(c.isSimilar(i)){const u=c.getChildren(),f=c.childCount;c._remove(),e._insertChild(r,u),this._removeFromClonedElementsGroup(c),s.push(new fe(e,r),new fe(e,r+f)),r+=f,n+=f-1}else this._unwrapAttributeElement(i,c)?(s.push(new fe(e,r),new fe(e,r+1)),r++):(this._unwrapChildren(c,0,c.childCount,i),r++);else r++}let a=0;for(const c of s)c.offset-=a,!(c.offset==t||c.offset==n)&&(this.mergeAttributes(c).isEqual(c)||(a++,n--));return Ne._createFromParentsAndOffsets(e,t,e,n)}_wrapRange(e,t){const{start:n,end:i}=this._breakAttributesRange(e,!0),r=n.parent,s=this._wrapChildren(r,n.offset,i.offset,t),a=this.mergeAttributes(s.start);a.isEqual(s.start)||s.end.offset--;const c=this.mergeAttributes(s.end);return new Ne(a,c)}_wrapPosition(e,t){if(t.isSimilar(e.parent))return Qf(e.clone());e.parent.is("$text")&&(e=Fd(e));const n=this.createAttributeElement("_wrapPosition-fake-element");n._priority=Number.POSITIVE_INFINITY,n.isSimilar=()=>!1,e.parent._insertChild(e.offset,n);const i=new Ne(e,e.getShiftedBy(1));this.wrap(i,t);const r=new fe(n.parent,n.index);n._remove();const s=r.nodeBefore,a=r.nodeAfter;return s instanceof bt&&a instanceof bt?Zf(s,a):Qf(r)}_wrapAttributeElement(e,t){if(!Xf(e,t)||e.name!==t.name||e.priority!==t.priority)return!1;for(const n of e.getAttributeKeys())if(n!=="class"&&n!=="style"&&t.hasAttribute(n)&&t.getAttribute(n)!==e.getAttribute(n))return!1;for(const n of e.getStyleNames())if(t.hasStyle(n)&&t.getStyle(n)!==e.getStyle(n))return!1;for(const n of e.getAttributeKeys())n!=="class"&&n!=="style"&&(t.hasAttribute(n)||this.setAttribute(n,e.getAttribute(n),t));for(const n of e.getStyleNames())t.hasStyle(n)||this.setStyle(n,e.getStyle(n),t);for(const n of e.getClassNames())t.hasClass(n)||this.addClass(n,t);return!0}_unwrapAttributeElement(e,t){if(!Xf(e,t)||e.name!==t.name||e.priority!==t.priority)return!1;for(const n of e.getAttributeKeys())if(n!=="class"&&n!=="style"&&(!t.hasAttribute(n)||t.getAttribute(n)!==e.getAttribute(n)))return!1;if(!t.hasClass(...e.getClassNames()))return!1;for(const n of e.getStyleNames())if(!t.hasStyle(n)||t.getStyle(n)!==e.getStyle(n))return!1;for(const n of e.getAttributeKeys())n!=="class"&&n!=="style"&&this.removeAttribute(n,t);return this.removeClass(Array.from(e.getClassNames()),t),this.removeStyle(Array.from(e.getStyleNames()),t),!0}_breakAttributesRange(e,t=!1){const n=e.start,i=e.end;if(Fs(e,this.document),e.isCollapsed){const c=this._breakAttributes(e.start,t);return new Ne(c,c)}const r=this._breakAttributes(i,t),s=r.parent.childCount,a=this._breakAttributes(n,t);return r.offset+=r.parent.childCount-s,new Ne(a,r)}_breakAttributes(e,t=!1){const n=e.offset,i=e.parent;if(e.parent.is("emptyElement"))throw new V("view-writer-cannot-break-empty-element",this.document);if(e.parent.is("uiElement"))throw new V("view-writer-cannot-break-ui-element",this.document);if(e.parent.is("rawElement"))throw new V("view-writer-cannot-break-raw-element",this.document);if(!t&&i.is("$text")&&Vd(i.parent)||Vd(i))return e.clone();if(i.is("$text"))return this._breakAttributes(Fd(e),t);if(n==i.childCount){const r=new fe(i.parent,i.index+1);return this._breakAttributes(r,t)}if(n===0){const r=new fe(i.parent,i.index);return this._breakAttributes(r,t)}{const r=i.index+1,s=i._clone();i.parent._insertChild(r,s),this._addToClonedElementsGroup(s);const a=i.childCount-n,c=i._removeChildren(n,a);s._appendChild(c);const u=new fe(i.parent,r);return this._breakAttributes(u,t)}}_addToClonedElementsGroup(e){if(!e.root.is("rootElement"))return;if(e.is("element"))for(const i of e.getChildren())this._addToClonedElementsGroup(i);const t=e.id;if(!t)return;let n=this._cloneGroups.get(t);n||(n=new Set,this._cloneGroups.set(t,n)),n.add(e),e._clonesGroup=n}_removeFromClonedElementsGroup(e){if(e.is("element"))for(const i of e.getChildren())this._removeFromClonedElementsGroup(i);const t=e.id;if(!t)return;const n=this._cloneGroups.get(t);n&&n.delete(e)}}function jd(o){let e=o.parent;for(;!Vd(e);){if(!e)return;e=e.parent}return e}function eC(o,e){return o.priority<e.priority||!(o.priority>e.priority)&&o.getIdentity()<e.getIdentity()}function Qf(o){const e=o.nodeBefore;if(e&&e.is("$text"))return new fe(e,e.data.length);const t=o.nodeAfter;return t&&t.is("$text")?new fe(t,0):o}function Fd(o){if(o.offset==o.parent.data.length)return new fe(o.parent.parent,o.parent.index+1);if(o.offset===0)return new fe(o.parent.parent,o.parent.index);const e=o.parent.data.slice(o.offset);return o.parent._data=o.parent.data.slice(0,o.offset),o.parent.parent._insertChild(o.parent.index+1,new bt(o.root.document,e)),new fe(o.parent.parent,o.parent.index+1)}function Zf(o,e){const t=o.data.length;return o._data+=e.data,e._remove(),new fe(o,t)}const tC=[bt,or,Rs,Od,Rd,_l];function Jf(o,e){for(const t of o){if(!tC.some(n=>t instanceof n))throw new V("view-writer-insert-invalid-node-type",e);t.is("$text")||Jf(t.getChildren(),e)}}function Vd(o){return o&&(o.is("containerElement")||o.is("documentFragment"))}function Fs(o,e){const t=jd(o.start),n=jd(o.end);if(!t||!n||t!==n)throw new V("view-writer-invalid-range-container",e)}function Xf(o,e){return o.id===null&&e.id===null}const eg=o=>o.createTextNode(" "),tg=o=>{const e=o.createElement("span");return e.dataset.ckeFiller="true",e.innerText=" ",e},ng=o=>{const e=o.createElement("br");return e.dataset.ckeFiller="true",e},Ri=7,Cl="⁠".repeat(Ri);function qn(o){return Pt(o)&&o.data.substr(0,Ri)===Cl}function Vs(o){return o.data.length==Ri&&qn(o)}function ig(o){return qn(o)?o.data.slice(Ri):o.data}function nC(o,e){if(e.keyCode==tt.arrowleft){const t=e.domTarget.ownerDocument.defaultView.getSelection();if(t.rangeCount==1&&t.getRangeAt(0).collapsed){const n=t.getRangeAt(0).startContainer,i=t.getRangeAt(0).startOffset;qn(n)&&i<=Ri&&t.collapse(n,0)}}}var og=w(9315),iC={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(og.Z,iC),og.Z.locals;class oC extends Ke(){constructor(e,t){super(),this.domDocuments=new Set,this.domConverter=e,this.markedAttributes=new Set,this.markedChildren=new Set,this.markedTexts=new Set,this.selection=t,this.set("isFocused",!1),this.set("isSelecting",!1),k.isBlink&&!k.isAndroid&&this.on("change:isSelecting",()=>{this.isSelecting||this.render()}),this.set("isComposing",!1),this.on("change:isComposing",()=>{this.isComposing||this.render()}),this._inlineFiller=null,this._fakeSelectionContainer=null}markToSync(e,t){if(e==="text")this.domConverter.mapViewToDom(t.parent)&&this.markedTexts.add(t);else{if(!this.domConverter.mapViewToDom(t))return;if(e==="attributes")this.markedAttributes.add(t);else{if(e!=="children")throw new V("view-renderer-unknown-type",this);this.markedChildren.add(t)}}}render(){if(this.isComposing&&!k.isAndroid)return;let e=null;const t=!(k.isBlink&&!k.isAndroid)||!this.isSelecting;for(const n of this.markedChildren)this._updateChildrenMappings(n);t?(this._inlineFiller&&!this._isSelectionInInlineFiller()&&this._removeInlineFiller(),this._inlineFiller?e=this._getInlineFillerPosition():this._needsInlineFillerAtSelection()&&(e=this.selection.getFirstPosition(),this.markedChildren.add(e.parent))):this._inlineFiller&&this._inlineFiller.parentNode&&(e=this.domConverter.domPositionToView(this._inlineFiller),e&&e.parent.is("$text")&&(e=fe._createBefore(e.parent)));for(const n of this.markedAttributes)this._updateAttrs(n);for(const n of this.markedChildren)this._updateChildren(n,{inlineFillerPosition:e});for(const n of this.markedTexts)!this.markedChildren.has(n.parent)&&this.domConverter.mapViewToDom(n.parent)&&this._updateText(n,{inlineFillerPosition:e});if(t)if(e){const n=this.domConverter.viewPositionToDom(e),i=n.parent.ownerDocument;qn(n.parent)?this._inlineFiller=n.parent:this._inlineFiller=rg(i,n.parent,n.offset)}else this._inlineFiller=null;this._updateFocus(),this._updateSelection(),this.markedTexts.clear(),this.markedAttributes.clear(),this.markedChildren.clear()}_updateChildrenMappings(e){if(!this.domConverter.mapViewToDom(e))return;const t=Array.from(this.domConverter.mapViewToDom(e).childNodes),n=Array.from(this.domConverter.viewChildrenToDom(e,{withChildren:!1})),i=this._diffNodeLists(t,n),r=this._findReplaceActions(i,t,n);if(r.indexOf("replace")!==-1){const s={equal:0,insert:0,delete:0};for(const a of r)if(a==="replace"){const c=s.equal+s.insert,u=s.equal+s.delete,f=e.getChild(c);!f||f.is("uiElement")||f.is("rawElement")||this._updateElementMappings(f,t[u]),kf(n[c]),s.equal++}else s[a]++}}_updateElementMappings(e,t){this.domConverter.unbindDomElement(t),this.domConverter.bindElements(t,e),this.markedChildren.add(e),this.markedAttributes.add(e)}_getInlineFillerPosition(){const e=this.selection.getFirstPosition();return e.parent.is("$text")?fe._createBefore(e.parent):e}_isSelectionInInlineFiller(){if(this.selection.rangeCount!=1||!this.selection.isCollapsed)return!1;const e=this.selection.getFirstPosition(),t=this.domConverter.viewPositionToDom(e);return!!(t&&Pt(t.parent)&&qn(t.parent))}_removeInlineFiller(){const e=this._inlineFiller;if(!qn(e))throw new V("view-renderer-filler-was-lost",this);Vs(e)?e.remove():e.data=e.data.substr(Ri),this._inlineFiller=null}_needsInlineFillerAtSelection(){if(this.selection.rangeCount!=1||!this.selection.isCollapsed)return!1;const e=this.selection.getFirstPosition(),t=e.parent,n=e.offset;if(!this.domConverter.mapViewToDom(t.root)||!t.is("element")||!function(s){if(s.getAttribute("contenteditable")=="false")return!1;const a=s.findAncestor(c=>c.hasAttribute("contenteditable"));return!a||a.getAttribute("contenteditable")=="true"}(t)||n===t.getFillerOffset())return!1;const i=e.nodeBefore,r=e.nodeAfter;return!(i instanceof bt||r instanceof bt)&&(!k.isAndroid||!i&&!r)}_updateText(e,t){const n=this.domConverter.findCorrespondingDomText(e);let i=this.domConverter.viewToDom(e).data;const r=t.inlineFillerPosition;r&&r.parent==e.parent&&r.offset==e.index&&(i=Cl+i),lg(n,i)}_updateAttrs(e){const t=this.domConverter.mapViewToDom(e);if(!t)return;const n=Array.from(t.attributes).map(r=>r.name),i=e.getAttributeKeys();for(const r of i)this.domConverter.setDomElementAttribute(t,r,e.getAttribute(r),e);for(const r of n)e.hasAttribute(r)||this.domConverter.removeDomElementAttribute(t,r)}_updateChildren(e,t){const n=this.domConverter.mapViewToDom(e);if(!n)return;if(k.isAndroid){let m=null;for(const v of Array.from(n.childNodes)){if(m&&Pt(m)&&Pt(v)){n.normalize();break}m=v}}const i=t.inlineFillerPosition,r=n.childNodes,s=Array.from(this.domConverter.viewChildrenToDom(e,{bind:!0}));i&&i.parent===e&&rg(n.ownerDocument,s,i.offset);const a=this._diffNodeLists(r,s),c=k.isAndroid?this._findReplaceActions(a,r,s,{replaceText:!0}):a;let u=0;const f=new Set;for(const m of c)m==="delete"?(f.add(r[u]),kf(r[u])):m!=="equal"&&m!=="replace"||u++;u=0;for(const m of c)m==="insert"?(pf(n,u,s[u]),u++):m==="replace"?(lg(r[u],s[u].data),u++):m==="equal"&&(this._markDescendantTextToSync(this.domConverter.domToView(s[u])),u++);for(const m of f)m.parentNode||this.domConverter.unbindDomElement(m)}_diffNodeLists(e,t){return e=function(n,i){const r=Array.from(n);return r.length==0||!i||r[r.length-1]==i&&r.pop(),r}(e,this._fakeSelectionContainer),O(e,t,rC.bind(null,this.domConverter))}_findReplaceActions(e,t,n,i={}){if(e.indexOf("insert")===-1||e.indexOf("delete")===-1)return e;let r=[],s=[],a=[];const c={equal:0,insert:0,delete:0};for(const u of e)u==="insert"?a.push(n[c.equal+c.insert]):u==="delete"?s.push(t[c.equal+c.delete]):(r=r.concat(O(s,a,i.replaceText?ag:sg).map(f=>f==="equal"?"replace":f)),r.push("equal"),s=[],a=[]),c[u]++;return r.concat(O(s,a,i.replaceText?ag:sg).map(u=>u==="equal"?"replace":u))}_markDescendantTextToSync(e){if(e){if(e.is("$text"))this.markedTexts.add(e);else if(e.is("element"))for(const t of e.getChildren())this._markDescendantTextToSync(t)}}_updateSelection(){if(k.isBlink&&!k.isAndroid&&this.isSelecting&&!this.markedChildren.size)return;if(this.selection.rangeCount===0)return this._removeDomSelection(),void this._removeFakeSelection();const e=this.domConverter.mapViewToDom(this.selection.editableElement);this.isFocused&&e&&(this.selection.isFake?this._updateFakeSelection(e):this._fakeSelectionContainer&&this._fakeSelectionContainer.isConnected?(this._removeFakeSelection(),this._updateDomSelection(e)):this.isComposing&&k.isAndroid||this._updateDomSelection(e))}_updateFakeSelection(e){const t=e.ownerDocument;this._fakeSelectionContainer||(this._fakeSelectionContainer=function(s){const a=s.createElement("div");return a.className="ck-fake-selection-container",Object.assign(a.style,{position:"fixed",top:0,left:"-9999px",width:"42px"}),a.textContent=" ",a}(t));const n=this._fakeSelectionContainer;if(this.domConverter.bindFakeSelection(n,this.selection),!this._fakeSelectionNeedsUpdate(e))return;n.parentElement&&n.parentElement==e||e.appendChild(n),n.textContent=this.selection.fakeSelectionLabel||" ";const i=t.getSelection(),r=t.createRange();i.removeAllRanges(),r.selectNodeContents(n),i.addRange(r)}_updateDomSelection(e){const t=e.ownerDocument.defaultView.getSelection();if(!this._domSelectionNeedsUpdate(t))return;const n=this.domConverter.viewPositionToDom(this.selection.anchor),i=this.domConverter.viewPositionToDom(this.selection.focus);t.collapse(n.parent,n.offset),t.extend(i.parent,i.offset),k.isGecko&&function(r,s){const a=r.parent;if(a.nodeType!=Node.ELEMENT_NODE||r.offset!=a.childNodes.length-1)return;const c=a.childNodes[r.offset];c&&c.tagName=="BR"&&s.addRange(s.getRangeAt(0))}(i,t)}_domSelectionNeedsUpdate(e){if(!this.domConverter.isDomSelectionCorrect(e))return!0;const t=e&&this.domConverter.domSelectionToView(e);return(!t||!this.selection.isEqual(t))&&!(!this.selection.isCollapsed&&this.selection.isSimilar(t))}_fakeSelectionNeedsUpdate(e){const t=this._fakeSelectionContainer,n=e.ownerDocument.getSelection();return!t||t.parentElement!==e||n.anchorNode!==t&&!t.contains(n.anchorNode)||t.textContent!==this.selection.fakeSelectionLabel}_removeDomSelection(){for(const e of this.domDocuments){const t=e.getSelection();if(t.rangeCount){const n=e.activeElement,i=this.domConverter.mapDomToView(n);n&&i&&t.removeAllRanges()}}}_removeFakeSelection(){const e=this._fakeSelectionContainer;e&&e.remove()}_updateFocus(){if(this.isFocused){const e=this.selection.editableElement;e&&this.domConverter.focus(e)}}}function rg(o,e,t){const n=e instanceof Array?e:e.childNodes,i=n[t];if(Pt(i))return i.data=Cl+i.data,i;{const r=o.createTextNode(Cl);return Array.isArray(e)?n.splice(t,0,r):pf(e,t,r),r}}function sg(o,e){return xo(o)&&xo(e)&&!Pt(o)&&!Pt(e)&&!Nr(o)&&!Nr(e)&&o.tagName.toLowerCase()===e.tagName.toLowerCase()}function ag(o,e){return xo(o)&&xo(e)&&Pt(o)&&Pt(e)}function rC(o,e,t){return e===t||(Pt(e)&&Pt(t)?e.data===t.data:!(!o.isBlockFiller(e)||!o.isBlockFiller(t)))}function lg(o,e){const t=o.data;if(t==e)return;const n=M(t,e);for(const i of n)i.type==="insert"?o.insertData(i.index,i.values.join("")):o.deleteData(i.index,i.howMany)}const sC=ng(Qe.document),aC=eg(Qe.document),lC=tg(Qe.document),Al="data-ck-unsafe-attribute-",cg="data-ck-unsafe-element";class yl{constructor(e,t={}){this.document=e,this.renderingMode=t.renderingMode||"editing",this.blockFillerMode=t.blockFillerMode||(this.renderingMode==="editing"?"br":"nbsp"),this.preElements=["pre"],this.blockElements=["address","article","aside","blockquote","caption","center","dd","details","dir","div","dl","dt","fieldset","figcaption","figure","footer","form","h1","h2","h3","h4","h5","h6","header","hgroup","legend","li","main","menu","nav","ol","p","pre","section","summary","table","tbody","td","tfoot","th","thead","tr","ul"],this.inlineObjectElements=["object","iframe","input","button","textarea","select","option","video","embed","audio","img","canvas"],this.unsafeElements=["script","style"],this._domDocument=this.renderingMode==="editing"?Qe.document:Qe.document.implementation.createHTMLDocument(""),this._domToViewMapping=new WeakMap,this._viewToDomMapping=new WeakMap,this._fakeSelectionMapping=new WeakMap,this._rawContentElementMatcher=new zi,this._encounteredRawContentDomNodes=new WeakSet}bindFakeSelection(e,t){this._fakeSelectionMapping.set(e,new Oi(t))}fakeSelectionToView(e){return this._fakeSelectionMapping.get(e)}bindElements(e,t){this._domToViewMapping.set(e,t),this._viewToDomMapping.set(t,e)}unbindDomElement(e){const t=this._domToViewMapping.get(e);if(t){this._domToViewMapping.delete(e),this._viewToDomMapping.delete(t);for(const n of Array.from(e.children))this.unbindDomElement(n)}}bindDocumentFragments(e,t){this._domToViewMapping.set(e,t),this._viewToDomMapping.set(t,e)}shouldRenderAttribute(e,t,n){return this.renderingMode==="data"||!(e=e.toLowerCase()).startsWith("on")&&(e!=="srcdoc"||!t.match(/\bon\S+\s*=|javascript:|<\s*\/*script/i))&&(n==="img"&&(e==="src"||e==="srcset")||n==="source"&&e==="srcset"||!t.match(/^\s*(javascript:|data:(image\/svg|text\/x?html))/i))}setContentOf(e,t){if(this.renderingMode==="data")return void(e.innerHTML=t);const n=new DOMParser().parseFromString(t,"text/html"),i=n.createDocumentFragment(),r=n.body.childNodes;for(;r.length>0;)i.appendChild(r[0]);const s=n.createTreeWalker(i,NodeFilter.SHOW_ELEMENT),a=[];let c;for(;c=s.nextNode();)a.push(c);for(const u of a){for(const m of u.getAttributeNames())this.setDomElementAttribute(u,m,u.getAttribute(m));const f=u.tagName.toLowerCase();this._shouldRenameElement(f)&&(hg(f),u.replaceWith(this._createReplacementDomElement(f,u)))}for(;e.firstChild;)e.firstChild.remove();e.append(i)}viewToDom(e,t={}){if(e.is("$text")){const n=this._processDataFromViewText(e);return this._domDocument.createTextNode(n)}{if(this.mapViewToDom(e))return this.mapViewToDom(e);let n;if(e.is("documentFragment"))n=this._domDocument.createDocumentFragment(),t.bind&&this.bindDocumentFragments(n,e);else{if(e.is("uiElement"))return n=e.name==="$comment"?this._domDocument.createComment(e.getCustomProperty("$rawContent")):e.render(this._domDocument,this),t.bind&&this.bindElements(n,e),n;this._shouldRenameElement(e.name)?(hg(e.name),n=this._createReplacementDomElement(e.name)):n=e.hasAttribute("xmlns")?this._domDocument.createElementNS(e.getAttribute("xmlns"),e.name):this._domDocument.createElement(e.name),e.is("rawElement")&&e.render(n,this),t.bind&&this.bindElements(n,e);for(const i of e.getAttributeKeys())this.setDomElementAttribute(n,i,e.getAttribute(i),e)}if(t.withChildren!==!1)for(const i of this.viewChildrenToDom(e,t))n.appendChild(i);return n}}setDomElementAttribute(e,t,n,i){const r=this.shouldRenderAttribute(t,n,e.tagName.toLowerCase())||i&&i.shouldRenderUnsafeAttribute(t);r||x("domconverter-unsafe-attribute-detected",{domElement:e,key:t,value:n}),e.hasAttribute(t)&&!r?e.removeAttribute(t):e.hasAttribute(Al+t)&&r&&e.removeAttribute(Al+t),e.setAttribute(r?t:Al+t,n)}removeDomElementAttribute(e,t){t!=cg&&(e.removeAttribute(t),e.removeAttribute(Al+t))}*viewChildrenToDom(e,t={}){const n=e.getFillerOffset&&e.getFillerOffset();let i=0;for(const r of e.getChildren()){n===i&&(yield this._getBlockFiller());const s=r.is("element")&&!!r.getCustomProperty("dataPipeline:transparentRendering")&&!Bt(r.getAttributes());s&&this.renderingMode=="data"?yield*this.viewChildrenToDom(r,t):(s&&x("domconverter-transparent-rendering-unsupported-in-editing-pipeline",{viewElement:r}),yield this.viewToDom(r,t)),i++}n===i&&(yield this._getBlockFiller())}viewRangeToDom(e){const t=this.viewPositionToDom(e.start),n=this.viewPositionToDom(e.end),i=this._domDocument.createRange();return i.setStart(t.parent,t.offset),i.setEnd(n.parent,n.offset),i}viewPositionToDom(e){const t=e.parent;if(t.is("$text")){const n=this.findCorrespondingDomText(t);if(!n)return null;let i=e.offset;return qn(n)&&(i+=Ri),{parent:n,offset:i}}{let n,i,r;if(e.offset===0){if(n=this.mapViewToDom(t),!n)return null;r=n.childNodes[0]}else{const s=e.nodeBefore;if(i=s.is("$text")?this.findCorrespondingDomText(s):this.mapViewToDom(s),!i)return null;n=i.parentNode,r=i.nextSibling}return Pt(r)&&qn(r)?{parent:r,offset:Ri}:{parent:n,offset:i?fl(i)+1:0}}}domToView(e,t={}){if(this.isBlockFiller(e))return null;const n=this.getHostViewElement(e);if(n)return n;if(Nr(e)&&t.skipComments)return null;if(Pt(e)){if(Vs(e))return null;{const i=this._processDataFromDomText(e);return i===""?null:new bt(this.document,i)}}{if(this.mapDomToView(e))return this.mapDomToView(e);let i;if(this.isDocumentFragment(e))i=new rr(this.document),t.bind&&this.bindDocumentFragments(e,i);else{i=this._createViewElement(e,t),t.bind&&this.bindElements(e,i);const r=e.attributes;if(r)for(let s=r.length,a=0;a<s;a++)i._setAttribute(r[a].name,r[a].value);if(this._isViewElementWithRawContent(i,t)||Nr(e)){const s=Nr(e)?e.data:e.innerHTML;return i._setCustomProperty("$rawContent",s),this._encounteredRawContentDomNodes.add(e),i}}if(t.withChildren!==!1)for(const r of this.domChildrenToView(e,t))i._appendChild(r);return i}}*domChildrenToView(e,t){for(let n=0;n<e.childNodes.length;n++){const i=e.childNodes[n],r=this.domToView(i,t);r!==null&&(yield r)}}domSelectionToView(e){if(e.rangeCount===1){let i=e.getRangeAt(0).startContainer;Pt(i)&&(i=i.parentNode);const r=this.fakeSelectionToView(i);if(r)return r}const t=this.isDomSelectionBackward(e),n=[];for(let i=0;i<e.rangeCount;i++){const r=e.getRangeAt(i),s=this.domRangeToView(r);s&&n.push(s)}return new Oi(n,{backward:t})}domRangeToView(e){const t=this.domPositionToView(e.startContainer,e.startOffset),n=this.domPositionToView(e.endContainer,e.endOffset);return t&&n?new Ne(t,n):null}domPositionToView(e,t=0){if(this.isBlockFiller(e))return this.domPositionToView(e.parentNode,fl(e));const n=this.mapDomToView(e);if(n&&(n.is("uiElement")||n.is("rawElement")))return fe._createBefore(n);if(Pt(e)){if(Vs(e))return this.domPositionToView(e.parentNode,fl(e));const i=this.findCorrespondingViewText(e);let r=t;return i?(qn(e)&&(r-=Ri,r=r<0?0:r),new fe(i,r)):null}if(t===0){const i=this.mapDomToView(e);if(i)return new fe(i,0)}else{const i=e.childNodes[t-1];if(Pt(i)&&Vs(i))return this.domPositionToView(i.parentNode,fl(i));const r=Pt(i)?this.findCorrespondingViewText(i):this.mapDomToView(i);if(r&&r.parent)return new fe(r.parent,r.index+1)}return null}mapDomToView(e){return this.getHostViewElement(e)||this._domToViewMapping.get(e)}findCorrespondingViewText(e){if(Vs(e))return null;const t=this.getHostViewElement(e);if(t)return t;const n=e.previousSibling;if(n){if(!this.isElement(n))return null;const i=this.mapDomToView(n);if(i){const r=i.nextSibling;return r instanceof bt?r:null}}else{const i=this.mapDomToView(e.parentNode);if(i){const r=i.getChild(0);return r instanceof bt?r:null}}return null}mapViewToDom(e){return this._viewToDomMapping.get(e)}findCorrespondingDomText(e){const t=e.previousSibling;return t&&this.mapViewToDom(t)?this.mapViewToDom(t).nextSibling:!t&&e.parent&&this.mapViewToDom(e.parent)?this.mapViewToDom(e.parent).childNodes[0]:null}focus(e){const t=this.mapViewToDom(e);if(t&&t.ownerDocument.activeElement!==t){const{scrollX:n,scrollY:i}=Qe.window,r=[];dg(t,s=>{const{scrollLeft:a,scrollTop:c}=s;r.push([a,c])}),t.focus(),dg(t,s=>{const[a,c]=r.shift();s.scrollLeft=a,s.scrollTop=c}),Qe.window.scrollTo(n,i)}}isElement(e){return e&&e.nodeType==Node.ELEMENT_NODE}isDocumentFragment(e){return e&&e.nodeType==Node.DOCUMENT_FRAGMENT_NODE}isBlockFiller(e){return this.blockFillerMode=="br"?e.isEqualNode(sC):!(e.tagName!=="BR"||!ug(e,this.blockElements)||e.parentNode.childNodes.length!==1)||e.isEqualNode(lC)||function(t,n){return t.isEqualNode(aC)&&ug(t,n)&&t.parentNode.childNodes.length===1}(e,this.blockElements)}isDomSelectionBackward(e){if(e.isCollapsed)return!1;const t=this._domDocument.createRange();try{t.setStart(e.anchorNode,e.anchorOffset),t.setEnd(e.focusNode,e.focusOffset)}catch{return!1}const n=t.collapsed;return t.detach(),n}getHostViewElement(e){const t=cf(e);for(t.pop();t.length;){const n=t.pop(),i=this._domToViewMapping.get(n);if(i&&(i.is("uiElement")||i.is("rawElement")))return i}return null}isDomSelectionCorrect(e){return this._isDomSelectionPositionCorrect(e.anchorNode,e.anchorOffset)&&this._isDomSelectionPositionCorrect(e.focusNode,e.focusOffset)}registerRawContentMatcher(e){this._rawContentElementMatcher.add(e)}_getBlockFiller(){switch(this.blockFillerMode){case"nbsp":return eg(this._domDocument);case"markedNbsp":return tg(this._domDocument);case"br":return ng(this._domDocument)}}_isDomSelectionPositionCorrect(e,t){if(Pt(e)&&qn(e)&&t<Ri||this.isElement(e)&&qn(e.childNodes[t]))return!1;const n=this.mapDomToView(e);return!n||!n.is("uiElement")&&!n.is("rawElement")}_processDataFromViewText(e){let t=e.data;if(e.getAncestors().some(n=>this.preElements.includes(n.name)))return t;if(t.charAt(0)==" "){const n=this._getTouchingInlineViewNode(e,!1);!(n&&n.is("$textProxy")&&this._nodeEndsWithSpace(n))&&n||(t=" "+t.substr(1))}if(t.charAt(t.length-1)==" "){const n=this._getTouchingInlineViewNode(e,!0),i=n&&n.is("$textProxy")&&n.data.charAt(0)==" ";t.charAt(t.length-2)!=" "&&n&&!i||(t=t.substr(0,t.length-1)+" ")}return t.replace(/ {2}/g,"  ")}_nodeEndsWithSpace(e){if(e.getAncestors().some(n=>this.preElements.includes(n.name)))return!1;const t=this._processDataFromViewText(e);return t.charAt(t.length-1)==" "}_processDataFromDomText(e){let t=e.data;if(function(u,f){return cf(u).some(v=>v.tagName&&f.includes(v.tagName.toLowerCase()))}(e,this.preElements))return ig(e);t=t.replace(/[ \n\t\r]{1,}/g," ");const n=this._getTouchingInlineDomNode(e,!1),i=this._getTouchingInlineDomNode(e,!0),r=this._checkShouldLeftTrimDomText(e,n),s=this._checkShouldRightTrimDomText(e,i);r&&(t=t.replace(/^ /,"")),s&&(t=t.replace(/ $/,"")),t=ig(new Text(t)),t=t.replace(/ \u00A0/g,"  ");const a=i&&this.isElement(i)&&i.tagName!="BR",c=i&&Pt(i)&&i.data.charAt(0)==" ";return(/( |\u00A0)\u00A0$/.test(t)||!i||a||c)&&(t=t.replace(/\u00A0$/," ")),(r||n&&this.isElement(n)&&n.tagName!="BR")&&(t=t.replace(/^\u00A0/," ")),t}_checkShouldLeftTrimDomText(e,t){return!t||(this.isElement(t)?t.tagName==="BR":!this._encounteredRawContentDomNodes.has(e.previousSibling)&&/[^\S\u00A0]/.test(t.data.charAt(t.data.length-1)))}_checkShouldRightTrimDomText(e,t){return!t&&!qn(e)}_getTouchingInlineViewNode(e,t){const n=new ir({startPosition:t?fe._createAfter(e):fe._createBefore(e),direction:t?"forward":"backward"});for(const i of n){if(i.item.is("element")&&this.inlineObjectElements.includes(i.item.name))return i.item;if(i.item.is("containerElement")||i.item.is("element","br"))return null;if(i.item.is("$textProxy"))return i.item}return null}_getTouchingInlineDomNode(e,t){if(!e.parentNode)return null;const n=t?"firstChild":"lastChild",i=t?"nextSibling":"previousSibling";let r=!0,s=e;do if(!r&&s[n]?s=s[n]:s[i]?(s=s[i],r=!1):(s=s.parentNode,r=!0),!s||this._isBlockElement(s))return null;while(!Pt(s)&&s.tagName!="BR"&&!this._isInlineObjectElement(s));return s}_isBlockElement(e){return this.isElement(e)&&this.blockElements.includes(e.tagName.toLowerCase())}_isInlineObjectElement(e){return this.isElement(e)&&this.inlineObjectElements.includes(e.tagName.toLowerCase())}_createViewElement(e,t){if(Nr(e))return new _l(this.document,"$comment");const n=t.keepOriginalCase?e.tagName:e.tagName.toLowerCase();return new Wn(this.document,n)}_isViewElementWithRawContent(e,t){return t.withChildren!==!1&&!!this._rawContentElementMatcher.match(e)}_shouldRenameElement(e){const t=e.toLowerCase();return this.renderingMode==="editing"&&this.unsafeElements.includes(t)}_createReplacementDomElement(e,t){const n=this._domDocument.createElement("span");if(n.setAttribute(cg,e),t){for(;t.firstChild;)n.appendChild(t.firstChild);for(const i of t.getAttributeNames())n.setAttribute(i,t.getAttribute(i))}return n}}function dg(o,e){let t=o;for(;t;)e(t),t=t.parentElement}function ug(o,e){const t=o.parentNode;return!!t&&!!t.tagName&&e.includes(t.tagName.toLowerCase())}function hg(o){o==="script"&&x("domconverter-unsafe-script-element-detected"),o==="style"&&x("domconverter-unsafe-style-element-detected")}class ji extends Do(){constructor(e){super(),this.view=e,this.document=e.document,this.isEnabled=!1}enable(){this.isEnabled=!0}disable(){this.isEnabled=!1}destroy(){this.disable(),this.stopListening()}checkShouldIgnoreEventFromTarget(e){return e&&e.nodeType===3&&(e=e.parentNode),!(!e||e.nodeType!==1)&&e.matches("[data-cke-ignore-events], [data-cke-ignore-events] *")}}const fg=Hf(function(o,e){vo(e,At(e),o)});class zr{constructor(e,t,n){this.view=e,this.document=e.document,this.domEvent=t,this.domTarget=t.target,fg(this,n)}get target(){return this.view.domConverter.mapDomToView(this.domTarget)}preventDefault(){this.domEvent.preventDefault()}stopPropagation(){this.domEvent.stopPropagation()}}class Eo extends ji{constructor(e){super(e),this.useCapture=!1}observe(e){(typeof this.domEventType=="string"?[this.domEventType]:this.domEventType).forEach(t=>{this.listenTo(e,t,(n,i)=>{this.isEnabled&&!this.checkShouldIgnoreEventFromTarget(i.target)&&this.onDomEvent(i)},{useCapture:this.useCapture})})}fire(e,t,n){this.isEnabled&&this.document.fire(e,new zr(this.view,t,n))}}class cC extends Eo{constructor(e){super(e),this.domEventType=["keydown","keyup"]}onDomEvent(e){const t={keyCode:e.keyCode,altKey:e.altKey,ctrlKey:e.ctrlKey,shiftKey:e.shiftKey,metaKey:e.metaKey,get keystroke(){return Pr(this)}};this.fire(e.type,e,t)}}const Hd=function(){return en.Date.now()};var dC=/\s/;const uC=function(o){for(var e=o.length;e--&&dC.test(o.charAt(e)););return e};var hC=/^\s+/;const fC=function(o){return o&&o.slice(0,uC(o)+1).replace(hC,"")};var gg=NaN,gC=/^[-+]0x[0-9a-f]+$/i,pC=/^0b[01]+$/i,mC=/^0o[0-7]+$/i,bC=parseInt;const pg=function(o){if(typeof o=="number")return o;if(ml(o))return gg;if(ht(o)){var e=typeof o.valueOf=="function"?o.valueOf():o;o=ht(e)?e+"":e}if(typeof o!="string")return o===0?o:+o;o=fC(o);var t=pC.test(o);return t||mC.test(o)?bC(o.slice(2),t?2:8):gC.test(o)?gg:+o};var kC="Expected a function",wC=Math.max,vC=Math.min;const Hs=function(o,e,t){var n,i,r,s,a,c,u=0,f=!1,m=!1,v=!0;if(typeof o!="function")throw new TypeError(kC);function E($){var te=n,ue=i;return n=i=void 0,u=$,s=o.apply(ue,te)}function I($){var te=$-c;return c===void 0||te>=e||te<0||m&&$-u>=r}function L(){var $=Hd();if(I($))return R($);a=setTimeout(L,function(te){var ue=e-(te-c);return m?vC(ue,r-(te-u)):ue}($))}function R($){return a=void 0,v&&n?E($):(n=i=void 0,s)}function H(){var $=Hd(),te=I($);if(n=arguments,i=this,c=$,te){if(a===void 0)return function(ue){return u=ue,a=setTimeout(L,e),f?E(ue):s}(c);if(m)return clearTimeout(a),a=setTimeout(L,e),E(c)}return a===void 0&&(a=setTimeout(L,e)),s}return e=pg(e)||0,ht(t)&&(f=!!t.leading,r=(m="maxWait"in t)?wC(pg(t.maxWait)||0,e):r,v="trailing"in t?!!t.trailing:v),H.cancel=function(){a!==void 0&&clearTimeout(a),u=0,n=c=i=a=void 0},H.flush=function(){return a===void 0?s:R(Hd())},H};class _C extends ji{constructor(e){super(e),this._fireSelectionChangeDoneDebounced=Hs(t=>{this.document.fire("selectionChangeDone",t)},200)}observe(){const e=this.document;e.on("arrowKey",(t,n)=>{e.selection.isFake&&this.isEnabled&&n.preventDefault()},{context:"$capture"}),e.on("arrowKey",(t,n)=>{e.selection.isFake&&this.isEnabled&&this._handleSelectionMove(n.keyCode)},{priority:"lowest"})}destroy(){super.destroy(),this._fireSelectionChangeDoneDebounced.cancel()}_handleSelectionMove(e){const t=this.document.selection,n=new Oi(t.getRanges(),{backward:t.isBackward,fake:!1});e!=tt.arrowleft&&e!=tt.arrowup||n.setTo(n.getFirstPosition()),e!=tt.arrowright&&e!=tt.arrowdown||n.setTo(n.getLastPosition());const i={oldSelection:t,newSelection:n,domSelection:null};this.document.fire("selectionChange",i),this._fireSelectionChangeDoneDebounced(i)}}var CC="__lodash_hash_undefined__";const AC=function(o){return this.__data__.set(o,CC),this},yC=function(o){return this.__data__.has(o)};function xl(o){var e=-1,t=o==null?0:o.length;for(this.__data__=new Go;++e<t;)this.add(o[e])}xl.prototype.add=xl.prototype.push=AC,xl.prototype.has=yC;const xC=xl,DC=function(o,e){for(var t=-1,n=o==null?0:o.length;++t<n;)if(e(o[t],t,o))return!0;return!1},EC=function(o,e){return o.has(e)};var TC=1,SC=2;const mg=function(o,e,t,n,i,r){var s=t&TC,a=o.length,c=e.length;if(a!=c&&!(s&&c>a))return!1;var u=r.get(o),f=r.get(e);if(u&&f)return u==e&&f==o;var m=-1,v=!0,E=t&SC?new xC:void 0;for(r.set(o,e),r.set(e,o);++m<a;){var I=o[m],L=e[m];if(n)var R=s?n(L,I,m,e,o,r):n(I,L,m,o,e,r);if(R!==void 0){if(R)continue;v=!1;break}if(E){if(!DC(e,function(H,$){if(!EC(E,$)&&(I===H||i(I,H,t,n,r)))return E.push($)})){v=!1;break}}else if(I!==L&&!i(I,L,t,n,r)){v=!1;break}}return r.delete(o),r.delete(e),v},IC=function(o){var e=-1,t=Array(o.size);return o.forEach(function(n,i){t[++e]=[i,n]}),t},MC=function(o){var e=-1,t=Array(o.size);return o.forEach(function(n){t[++e]=n}),t};var NC=1,PC=2,BC="[object Boolean]",LC="[object Date]",zC="[object Error]",OC="[object Map]",RC="[object Number]",jC="[object RegExp]",FC="[object Set]",VC="[object String]",HC="[object Symbol]",UC="[object ArrayBuffer]",WC="[object DataView]",bg=un?un.prototype:void 0,Ud=bg?bg.valueOf:void 0;const qC=function(o,e,t,n,i,r,s){switch(t){case WC:if(o.byteLength!=e.byteLength||o.byteOffset!=e.byteOffset)return!1;o=o.buffer,e=e.buffer;case UC:return!(o.byteLength!=e.byteLength||!r(new Ao(o),new Ao(e)));case BC:case LC:case RC:return Xn(+o,+e);case zC:return o.name==e.name&&o.message==e.message;case jC:case VC:return o==e+"";case OC:var a=IC;case FC:var c=n&NC;if(a||(a=MC),o.size!=e.size&&!c)return!1;var u=s.get(o);if(u)return u==e;n|=PC,s.set(o,e);var f=mg(a(o),a(e),n,i,r,s);return s.delete(o),f;case HC:if(Ud)return Ud.call(o)==Ud.call(e)}return!1};var GC=1,$C=Object.prototype.hasOwnProperty;const YC=function(o,e,t,n,i,r){var s=t&GC,a=Ns(o),c=a.length;if(c!=Ns(e).length&&!s)return!1;for(var u=c;u--;){var f=a[u];if(!(s?f in e:$C.call(e,f)))return!1}var m=r.get(o),v=r.get(e);if(m&&v)return m==e&&v==o;var E=!0;r.set(o,e),r.set(e,o);for(var I=s;++u<c;){var L=o[f=a[u]],R=e[f];if(n)var H=s?n(R,L,f,e,o,r):n(L,R,f,o,e,r);if(!(H===void 0?L===R||i(L,R,t,n,r):H)){E=!1;break}I||(I=f=="constructor")}if(E&&!I){var $=o.constructor,te=e.constructor;$==te||!("constructor"in o)||!("constructor"in e)||typeof $=="function"&&$ instanceof $&&typeof te=="function"&&te instanceof te||(E=!1)}return r.delete(o),r.delete(e),E};var KC=1,kg="[object Arguments]",wg="[object Array]",Dl="[object Object]",vg=Object.prototype.hasOwnProperty;const QC=function(o,e,t,n,i,r){var s=tn(o),a=tn(e),c=s?wg:so(o),u=a?wg:so(e),f=(c=c==kg?Dl:c)==Dl,m=(u=u==kg?Dl:u)==Dl,v=c==u;if(v&&oo(o)){if(!oo(e))return!1;s=!0,f=!1}if(v&&!f)return r||(r=new $o),s||S(o)?mg(o,e,t,n,i,r):qC(o,e,c,t,n,i,r);if(!(t&KC)){var E=f&&vg.call(o,"__wrapped__"),I=m&&vg.call(e,"__wrapped__");if(E||I){var L=E?o.value():o,R=I?e.value():e;return r||(r=new $o),i(L,R,t,n,r)}}return!!v&&(r||(r=new $o),YC(o,e,t,n,i,r))},_g=function o(e,t,n,i,r){return e===t||(e==null||t==null||!nn(e)&&!nn(t)?e!=e&&t!=t:QC(e,t,n,i,o,r))},ZC=function(o,e,t){var n=(t=typeof t=="function"?t:void 0)?t(o,e):void 0;return n===void 0?_g(o,e,void 0,t):!!n};class Cg extends ji{constructor(e){super(e),this._config={childList:!0,characterData:!0,subtree:!0},this.domConverter=e.domConverter,this.renderer=e._renderer,this._domElements=[],this._mutationObserver=new window.MutationObserver(this._onMutations.bind(this))}flush(){this._onMutations(this._mutationObserver.takeRecords())}observe(e){this._domElements.push(e),this.isEnabled&&this._mutationObserver.observe(e,this._config)}enable(){super.enable();for(const e of this._domElements)this._mutationObserver.observe(e,this._config)}disable(){super.disable(),this._mutationObserver.disconnect()}destroy(){super.destroy(),this._mutationObserver.disconnect()}_onMutations(e){if(e.length===0)return;const t=this.domConverter,n=new Set,i=new Set;for(const s of e){const a=t.mapDomToView(s.target);a&&(a.is("uiElement")||a.is("rawElement")||s.type!=="childList"||this._isBogusBrMutation(s)||i.add(a))}for(const s of e){const a=t.mapDomToView(s.target);if((!a||!a.is("uiElement")&&!a.is("rawElement"))&&s.type==="characterData"){const c=t.findCorrespondingViewText(s.target);c&&!i.has(c.parent)?n.add(c):!c&&qn(s.target)&&i.add(t.mapDomToView(s.target.parentNode))}}let r=!1;for(const s of n)r=!0,this.renderer.markToSync("text",s);for(const s of i){const a=t.mapViewToDom(s),c=Array.from(s.getChildren()),u=Array.from(t.domChildrenToView(a,{withChildren:!1}));ZC(c,u,JC)||(r=!0,this.renderer.markToSync("children",s))}r&&this.view.forceRender()}_isBogusBrMutation(e){let t=null;return e.nextSibling===null&&e.removedNodes.length===0&&e.addedNodes.length==1&&(t=this.domConverter.domToView(e.addedNodes[0],{withChildren:!1})),t&&t.is("element","br")}}function JC(o,e){if(!Array.isArray(o))return o===e||!(!o.is("$text")||!e.is("$text"))&&o.data===e.data}class Wd extends Eo{constructor(e){super(e),this._isFocusChanging=!1,this.domEventType=["focus","blur"],this.useCapture=!0;const t=this.document;t.on("focus",()=>{this._isFocusChanging=!0,this._renderTimeoutId=setTimeout(()=>{this.flush(),e.change(()=>{})},50)}),t.on("blur",(n,i)=>{const r=t.selection.editableElement;r!==null&&r!==i.target||(t.isFocused=!1,this._isFocusChanging=!1,e.change(()=>{}))})}flush(){this._isFocusChanging&&(this._isFocusChanging=!1,this.document.isFocused=!0)}onDomEvent(e){this.fire(e.type,e)}destroy(){this._renderTimeoutId&&clearTimeout(this._renderTimeoutId),super.destroy()}}class XC extends ji{constructor(e){super(e),this.mutationObserver=e.getObserver(Cg),this.focusObserver=e.getObserver(Wd),this.selection=this.document.selection,this.domConverter=e.domConverter,this._documents=new WeakSet,this._fireSelectionChangeDoneDebounced=Hs(t=>{this.document.fire("selectionChangeDone",t)},200),this._clearInfiniteLoopInterval=setInterval(()=>this._clearInfiniteLoop(),1e3),this._documentIsSelectingInactivityTimeoutDebounced=Hs(()=>this.document.isSelecting=!1,5e3),this._loopbackCounter=0}observe(e){const t=e.ownerDocument,n=()=>{this.document.isSelecting&&(this._handleSelectionChange(null,t),this.document.isSelecting=!1,this._documentIsSelectingInactivityTimeoutDebounced.cancel())};this.listenTo(e,"selectstart",()=>{this.document.isSelecting=!0,this._documentIsSelectingInactivityTimeoutDebounced()},{priority:"highest"}),this.listenTo(e,"keydown",n,{priority:"highest",useCapture:!0}),this.listenTo(e,"keyup",n,{priority:"highest",useCapture:!0}),this._documents.has(t)||(this.listenTo(t,"mouseup",n,{priority:"highest",useCapture:!0}),this.listenTo(t,"selectionchange",(i,r)=>{this.document.isComposing&&!k.isAndroid||(this._handleSelectionChange(r,t),this._documentIsSelectingInactivityTimeoutDebounced())}),this._documents.add(t))}destroy(){super.destroy(),clearInterval(this._clearInfiniteLoopInterval),this._fireSelectionChangeDoneDebounced.cancel(),this._documentIsSelectingInactivityTimeoutDebounced.cancel()}_handleSelectionChange(e,t){if(!this.isEnabled)return;const n=t.defaultView.getSelection();if(this.checkShouldIgnoreEventFromTarget(n.anchorNode))return;this.mutationObserver.flush();const i=this.domConverter.domSelectionToView(n);if(i.rangeCount!=0){if(this.view.hasDomSelection=!0,!(this.selection.isEqual(i)&&this.domConverter.isDomSelectionCorrect(n)||++this._loopbackCounter>60))if(this.focusObserver.flush(),this.selection.isSimilar(i))this.view.forceRender();else{const r={oldSelection:this.selection,newSelection:i,domSelection:n};this.document.fire("selectionChange",r),this._fireSelectionChangeDoneDebounced(r)}}else this.view.hasDomSelection=!1}_clearInfiniteLoop(){this._loopbackCounter=0}}class eA extends Eo{constructor(e){super(e),this.domEventType=["compositionstart","compositionupdate","compositionend"];const t=this.document;t.on("compositionstart",()=>{t.isComposing=!0},{priority:"low"}),t.on("compositionend",()=>{t.isComposing=!1},{priority:"low"})}onDomEvent(e){this.fire(e.type,e,{data:e.data})}}class Ag{constructor(e,t={}){this._files=t.cacheFiles?yg(e):null,this._native=e}get files(){return this._files||(this._files=yg(this._native)),this._files}get types(){return this._native.types}getData(e){return this._native.getData(e)}setData(e,t){this._native.setData(e,t)}set effectAllowed(e){this._native.effectAllowed=e}get effectAllowed(){return this._native.effectAllowed}set dropEffect(e){this._native.dropEffect=e}get dropEffect(){return this._native.dropEffect}get isCanceled(){return this._native.dropEffect=="none"||!!this._native.mozUserCancelled}}function yg(o){const e=Array.from(o.files||[]),t=Array.from(o.items||[]);return e.length?e:t.filter(n=>n.kind==="file").map(n=>n.getAsFile())}class tA extends Eo{constructor(e){super(e),this.domEventType=["beforeinput"]}onDomEvent(e){const t=e.getTargetRanges(),n=this.view,i=n.document;let r=null,s=null,a=[];if(e.dataTransfer&&(r=new Ag(e.dataTransfer)),e.data!==null?s=e.data:r&&(s=r.getData("text/plain")),i.selection.isFake)a=Array.from(i.selection.getRanges());else if(t.length)a=t.map(c=>n.domConverter.domRangeToView(c));else if(k.isAndroid){const c=e.target.ownerDocument.defaultView.getSelection();a=Array.from(n.domConverter.domSelectionToView(c).getRanges())}if(k.isAndroid&&e.inputType=="insertCompositionText"&&s&&s.endsWith(`
`))this.fire(e.type,e,{inputType:"insertParagraph",targetRanges:[n.createRange(a[0].end)]});else if(e.inputType=="insertText"&&s&&s.includes(`
`)){const c=s.split(/\n{1,2}/g);let u=a;for(let f=0;f<c.length;f++){const m=c[f];m!=""&&(this.fire(e.type,e,{data:m,dataTransfer:r,targetRanges:u,inputType:e.inputType,isComposing:e.isComposing}),u=[i.selection.getFirstRange()]),f+1<c.length&&(this.fire(e.type,e,{inputType:"insertParagraph",targetRanges:u}),u=[i.selection.getFirstRange()])}}else this.fire(e.type,e,{data:s,dataTransfer:r,targetRanges:a,inputType:e.inputType,isComposing:e.isComposing})}}class nA extends ji{constructor(e){super(e),this.document.on("keydown",(t,n)=>{if(this.isEnabled&&((i=n.keyCode)==tt.arrowright||i==tt.arrowleft||i==tt.arrowup||i==tt.arrowdown)){const r=new Br(this.document,"arrowKey",this.document.selection.getFirstRange());this.document.fire(r,n),r.stop.called&&t.stop()}var i})}observe(){}}class iA extends ji{constructor(e){super(e);const t=this.document;t.on("keydown",(n,i)=>{if(!this.isEnabled||i.keyCode!=tt.tab||i.ctrlKey)return;const r=new Br(t,"tab",t.selection.getFirstRange());t.fire(r,i),r.stop.called&&n.stop()})}observe(){}}class oA extends Ke(){constructor(e){super(),this.document=new vl(e),this.domConverter=new yl(this.document),this.domRoots=new Map,this.set("isRenderingInProgress",!1),this.set("hasDomSelection",!1),this._renderer=new oC(this.domConverter,this.document.selection),this._renderer.bind("isFocused","isSelecting","isComposing").to(this.document,"isFocused","isSelecting","isComposing"),this._initialDomRootAttributes=new WeakMap,this._observers=new Map,this._ongoingChange=!1,this._postFixersInProgress=!1,this._renderingDisabled=!1,this._hasChangedSinceTheLastRendering=!1,this._writer=new Kf(this.document),this.addObserver(Cg),this.addObserver(Wd),this.addObserver(XC),this.addObserver(cC),this.addObserver(_C),this.addObserver(eA),this.addObserver(nA),this.addObserver(tA),this.addObserver(iA),this.document.on("arrowKey",nC,{priority:"low"}),Z_(this),this.on("render",()=>{this._render(),this.document.fire("layoutChanged"),this._hasChangedSinceTheLastRendering=!1}),this.listenTo(this.document.selection,"change",()=>{this._hasChangedSinceTheLastRendering=!0}),this.listenTo(this.document,"change:isFocused",()=>{this._hasChangedSinceTheLastRendering=!0})}attachDomRoot(e,t="main"){const n=this.document.getRoot(t);n._name=e.tagName.toLowerCase();const i={};for(const{name:s,value:a}of Array.from(e.attributes))i[s]=a,s==="class"?this._writer.addClass(a.split(" "),n):this._writer.setAttribute(s,a,n);this._initialDomRootAttributes.set(e,i);const r=()=>{this._writer.setAttribute("contenteditable",(!n.isReadOnly).toString(),n),n.isReadOnly?this._writer.addClass("ck-read-only",n):this._writer.removeClass("ck-read-only",n)};r(),this.domRoots.set(t,e),this.domConverter.bindElements(e,n),this._renderer.markToSync("children",n),this._renderer.markToSync("attributes",n),this._renderer.domDocuments.add(e.ownerDocument),n.on("change:children",(s,a)=>this._renderer.markToSync("children",a)),n.on("change:attributes",(s,a)=>this._renderer.markToSync("attributes",a)),n.on("change:text",(s,a)=>this._renderer.markToSync("text",a)),n.on("change:isReadOnly",()=>this.change(r)),n.on("change",()=>{this._hasChangedSinceTheLastRendering=!0});for(const s of this._observers.values())s.observe(e,t)}detachDomRoot(e){const t=this.domRoots.get(e);Array.from(t.attributes).forEach(({name:i})=>t.removeAttribute(i));const n=this._initialDomRootAttributes.get(t);for(const i in n)t.setAttribute(i,n[i]);this.domRoots.delete(e),this.domConverter.unbindDomElement(t)}getDomRoot(e="main"){return this.domRoots.get(e)}addObserver(e){let t=this._observers.get(e);if(t)return t;t=new e(this),this._observers.set(e,t);for(const[n,i]of this.domRoots)t.observe(i,n);return t.enable(),t}getObserver(e){return this._observers.get(e)}disableObservers(){for(const e of this._observers.values())e.disable()}enableObservers(){for(const e of this._observers.values())e.enable()}scrollToTheSelection(){const e=this.document.selection.getFirstRange();e&&function({target:t,viewportOffset:n=0}){const i=wd(t);let r=i,s=null;for(;r;){let a;a=K0(r==i?t:s),Y0(a,()=>Af(t,r));const c=Af(t,r);if($0(r,c,n),r.parent!=r){if(s=r.frameElement,r=r.parent,!s)return}else r=null}}({target:this.domConverter.viewRangeToDom(e),viewportOffset:20})}focus(){if(!this.document.isFocused){const e=this.document.selection.editableElement;e&&(this.domConverter.focus(e),this.forceRender())}}change(e){if(this.isRenderingInProgress||this._postFixersInProgress)throw new V("cannot-change-view-tree",this);try{if(this._ongoingChange)return e(this._writer);this._ongoingChange=!0;const t=e(this._writer);return this._ongoingChange=!1,!this._renderingDisabled&&this._hasChangedSinceTheLastRendering&&(this._postFixersInProgress=!0,this.document._callPostFixers(this._writer),this._postFixersInProgress=!1,this.fire("render")),t}catch(t){V.rethrowUnexpectedError(t,this)}}forceRender(){this._hasChangedSinceTheLastRendering=!0,this.getObserver(Wd).flush(),this.change(()=>{})}destroy(){for(const e of this._observers.values())e.destroy();this.document.destroy(),this.stopListening()}createPositionAt(e,t){return fe._createAt(e,t)}createPositionAfter(e){return fe._createAfter(e)}createPositionBefore(e){return fe._createBefore(e)}createRange(...e){return new Ne(...e)}createRangeOn(e){return Ne._createOn(e)}createRangeIn(e){return Ne._createIn(e)}createSelection(...e){return new Oi(...e)}_disableRendering(e){this._renderingDisabled=e,e==0&&this.change(()=>{})}_render(){this.isRenderingInProgress=!0,this.disableObservers(),this._renderer.render(),this.enableObservers(),this.isRenderingInProgress=!1}}class To{is(){throw new Error("is() method is abstract")}}class Or extends To{constructor(e){super(),this.parent=null,this._attrs=Bi(e)}get document(){return null}get index(){let e;if(!this.parent)return null;if((e=this.parent.getChildIndex(this))===null)throw new V("model-node-not-found-in-parent",this);return e}get startOffset(){let e;if(!this.parent)return null;if((e=this.parent.getChildStartOffset(this))===null)throw new V("model-node-not-found-in-parent",this);return e}get offsetSize(){return 1}get endOffset(){return this.parent?this.startOffset+this.offsetSize:null}get nextSibling(){const e=this.index;return e!==null&&this.parent.getChild(e+1)||null}get previousSibling(){const e=this.index;return e!==null&&this.parent.getChild(e-1)||null}get root(){let e=this;for(;e.parent;)e=e.parent;return e}isAttached(){return this.root.is("rootElement")}getPath(){const e=[];let t=this;for(;t.parent;)e.unshift(t.startOffset),t=t.parent;return e}getAncestors(e={}){const t=[];let n=e.includeSelf?this:this.parent;for(;n;)t[e.parentFirst?"push":"unshift"](n),n=n.parent;return t}getCommonAncestor(e,t={}){const n=this.getAncestors(t),i=e.getAncestors(t);let r=0;for(;n[r]==i[r]&&n[r];)r++;return r===0?null:n[r-1]}isBefore(e){if(this==e||this.root!==e.root)return!1;const t=this.getPath(),n=e.getPath(),i=Gt(t,n);switch(i){case"prefix":return!0;case"extension":return!1;default:return t[i]<n[i]}}isAfter(e){return this!=e&&this.root===e.root&&!this.isBefore(e)}hasAttribute(e){return this._attrs.has(e)}getAttribute(e){return this._attrs.get(e)}getAttributes(){return this._attrs.entries()}getAttributeKeys(){return this._attrs.keys()}toJSON(){const e={};return this._attrs.size&&(e.attributes=Array.from(this._attrs).reduce((t,n)=>(t[n[0]]=n[1],t),{})),e}_clone(e){return new this.constructor(this._attrs)}_remove(){this.parent._removeChildren(this.index)}_setAttribute(e,t){this._attrs.set(e,t)}_setAttributesTo(e){this._attrs=Bi(e)}_removeAttribute(e){return this._attrs.delete(e)}_clearAttributes(){this._attrs.clear()}}Or.prototype.is=function(o){return o==="node"||o==="model:node"};class Us{constructor(e){this._nodes=[],e&&this._insertNodes(0,e)}[Symbol.iterator](){return this._nodes[Symbol.iterator]()}get length(){return this._nodes.length}get maxOffset(){return this._nodes.reduce((e,t)=>e+t.offsetSize,0)}getNode(e){return this._nodes[e]||null}getNodeIndex(e){const t=this._nodes.indexOf(e);return t==-1?null:t}getNodeStartOffset(e){const t=this.getNodeIndex(e);return t===null?null:this._nodes.slice(0,t).reduce((n,i)=>n+i.offsetSize,0)}indexToOffset(e){if(e==this._nodes.length)return this.maxOffset;const t=this._nodes[e];if(!t)throw new V("model-nodelist-index-out-of-bounds",this);return this.getNodeStartOffset(t)}offsetToIndex(e){let t=0;for(const n of this._nodes){if(e>=t&&e<t+n.offsetSize)return this.getNodeIndex(n);t+=n.offsetSize}if(t!=e)throw new V("model-nodelist-offset-out-of-bounds",this,{offset:e,nodeList:this});return this.length}_insertNodes(e,t){for(const n of t)if(!(n instanceof Or))throw new V("model-nodelist-insertnodes-not-node",this);this._nodes=function(n,i,r,s){if(Math.max(i.length,n.length)>n_)return n.slice(0,r).concat(i).concat(n.slice(r+s,n.length));{const a=Array.from(n);return a.splice(r,s,...i),a}}(this._nodes,Array.from(t),e,0)}_removeNodes(e,t=1){return this._nodes.splice(e,t)}toJSON(){return this._nodes.map(e=>e.toJSON())}}class kt extends Or{constructor(e,t){super(t),this._data=e||""}get offsetSize(){return this.data.length}get data(){return this._data}toJSON(){const e=super.toJSON();return e.data=this.data,e}_clone(){return new kt(this.data,this.getAttributes())}static fromJSON(e){return new kt(e.data,e.attributes)}}kt.prototype.is=function(o){return o==="$text"||o==="model:$text"||o==="text"||o==="model:text"||o==="node"||o==="model:node"};class wi extends To{constructor(e,t,n){if(super(),this.textNode=e,t<0||t>e.offsetSize)throw new V("model-textproxy-wrong-offsetintext",this);if(n<0||t+n>e.offsetSize)throw new V("model-textproxy-wrong-length",this);this.data=e.data.substring(t,t+n),this.offsetInText=t}get startOffset(){return this.textNode.startOffset!==null?this.textNode.startOffset+this.offsetInText:null}get offsetSize(){return this.data.length}get endOffset(){return this.startOffset!==null?this.startOffset+this.offsetSize:null}get isPartial(){return this.offsetSize!==this.textNode.offsetSize}get parent(){return this.textNode.parent}get root(){return this.textNode.root}getPath(){const e=this.textNode.getPath();return e.length>0&&(e[e.length-1]+=this.offsetInText),e}getAncestors(e={}){const t=[];let n=e.includeSelf?this:this.parent;for(;n;)t[e.parentFirst?"push":"unshift"](n),n=n.parent;return t}hasAttribute(e){return this.textNode.hasAttribute(e)}getAttribute(e){return this.textNode.getAttribute(e)}getAttributes(){return this.textNode.getAttributes()}getAttributeKeys(){return this.textNode.getAttributeKeys()}}wi.prototype.is=function(o){return o==="$textProxy"||o==="model:$textProxy"||o==="textProxy"||o==="model:textProxy"};class gt extends Or{constructor(e,t,n){super(t),this._children=new Us,this.name=e,n&&this._insertChild(0,n)}get childCount(){return this._children.length}get maxOffset(){return this._children.maxOffset}get isEmpty(){return this.childCount===0}getChild(e){return this._children.getNode(e)}getChildren(){return this._children[Symbol.iterator]()}getChildIndex(e){return this._children.getNodeIndex(e)}getChildStartOffset(e){return this._children.getNodeStartOffset(e)}offsetToIndex(e){return this._children.offsetToIndex(e)}getNodeByPath(e){let t=this;for(const n of e)t=t.getChild(t.offsetToIndex(n));return t}findAncestor(e,t={}){let n=t.includeSelf?this:this.parent;for(;n;){if(n.name===e)return n;n=n.parent}return null}toJSON(){const e=super.toJSON();if(e.name=this.name,this._children.length>0){e.children=[];for(const t of this._children)e.children.push(t.toJSON())}return e}_clone(e=!1){const t=e?Array.from(this._children).map(n=>n._clone(!0)):void 0;return new gt(this.name,this.getAttributes(),t)}_appendChild(e){this._insertChild(this.childCount,e)}_insertChild(e,t){const n=function(i){return typeof i=="string"?[new kt(i)]:(bn(i)||(i=[i]),Array.from(i).map(r=>typeof r=="string"?new kt(r):r instanceof wi?new kt(r.data,r.getAttributes()):r))}(t);for(const i of n)i.parent!==null&&i._remove(),i.parent=this;this._children._insertNodes(e,n)}_removeChildren(e,t=1){const n=this._children._removeNodes(e,t);for(const i of n)i.parent=null;return n}static fromJSON(e){let t;if(e.children){t=[];for(const n of e.children)n.name?t.push(gt.fromJSON(n)):t.push(kt.fromJSON(n))}return new gt(e.name,e.attributes,t)}}gt.prototype.is=function(o,e){return e?e===this.name&&(o==="element"||o==="model:element"):o==="element"||o==="model:element"||o==="node"||o==="model:node"};class Fi{constructor(e){if(!e||!e.boundaries&&!e.startPosition)throw new V("model-tree-walker-no-start-position",null);const t=e.direction||"forward";if(t!="forward"&&t!="backward")throw new V("model-tree-walker-unknown-direction",e,{direction:t});this.direction=t,this.boundaries=e.boundaries||null,e.startPosition?this.position=e.startPosition.clone():this.position=le._createAt(this.boundaries[this.direction=="backward"?"end":"start"]),this.position.stickiness="toNone",this.singleCharacters=!!e.singleCharacters,this.shallow=!!e.shallow,this.ignoreElementEnd=!!e.ignoreElementEnd,this._boundaryStartParent=this.boundaries?this.boundaries.start.parent:null,this._boundaryEndParent=this.boundaries?this.boundaries.end.parent:null,this._visitedParent=this.position.parent}[Symbol.iterator](){return this}skip(e){let t,n,i,r;do i=this.position,r=this._visitedParent,{done:t,value:n}=this.next();while(!t&&e(n));t||(this.position=i,this._visitedParent=r)}next(){return this.direction=="forward"?this._next():this._previous()}_next(){const e=this.position,t=this.position.clone(),n=this._visitedParent;if(n.parent===null&&t.offset===n.maxOffset)return{done:!0,value:void 0};if(n===this._boundaryEndParent&&t.offset==this.boundaries.end.offset)return{done:!0,value:void 0};const i=Ws(t,n),r=i||xg(t,n,i);if(r instanceof gt)return this.shallow?t.offset++:(t.path.push(0),this._visitedParent=r),this.position=t,sr("elementStart",r,e,t,1);if(r instanceof kt){let s;if(this.singleCharacters)s=1;else{let u=r.endOffset;this._boundaryEndParent==n&&this.boundaries.end.offset<u&&(u=this.boundaries.end.offset),s=u-t.offset}const a=t.offset-r.startOffset,c=new wi(r,a,s);return t.offset+=s,this.position=t,sr("text",c,e,t,s)}return t.path.pop(),t.offset++,this.position=t,this._visitedParent=n.parent,this.ignoreElementEnd?this._next():sr("elementEnd",n,e,t)}_previous(){const e=this.position,t=this.position.clone(),n=this._visitedParent;if(n.parent===null&&t.offset===0)return{done:!0,value:void 0};if(n==this._boundaryStartParent&&t.offset==this.boundaries.start.offset)return{done:!0,value:void 0};const i=t.parent,r=Ws(t,i),s=r||Dg(t,i,r);if(s instanceof gt)return t.offset--,this.shallow?(this.position=t,sr("elementStart",s,e,t,1)):(t.path.push(s.maxOffset),this.position=t,this._visitedParent=s,this.ignoreElementEnd?this._previous():sr("elementEnd",s,e,t));if(s instanceof kt){let a;if(this.singleCharacters)a=1;else{let f=s.startOffset;this._boundaryStartParent==n&&this.boundaries.start.offset>f&&(f=this.boundaries.start.offset),a=t.offset-f}const c=t.offset-s.startOffset,u=new wi(s,c-a,a);return t.offset-=a,this.position=t,sr("text",u,e,t,a)}return t.path.pop(),this.position=t,this._visitedParent=n.parent,sr("elementStart",n,e,t,1)}}function sr(o,e,t,n,i){return{done:!1,value:{type:o,item:e,previousPosition:t,nextPosition:n,length:i}}}class le extends To{constructor(e,t,n="toNone"){if(super(),!e.is("element")&&!e.is("documentFragment"))throw new V("model-position-root-invalid",e);if(!(t instanceof Array)||t.length===0)throw new V("model-position-path-incorrect-format",e,{path:t});e.is("rootElement")?t=t.slice():(t=[...e.getPath(),...t],e=e.root),this.root=e,this.path=t,this.stickiness=n}get offset(){return this.path[this.path.length-1]}set offset(e){this.path[this.path.length-1]=e}get parent(){let e=this.root;for(let t=0;t<this.path.length-1;t++)if(e=e.getChild(e.offsetToIndex(this.path[t])),!e)throw new V("model-position-path-incorrect",this,{position:this});if(e.is("$text"))throw new V("model-position-path-incorrect",this,{position:this});return e}get index(){return this.parent.offsetToIndex(this.offset)}get textNode(){return Ws(this,this.parent)}get nodeAfter(){const e=this.parent;return xg(this,e,Ws(this,e))}get nodeBefore(){const e=this.parent;return Dg(this,e,Ws(this,e))}get isAtStart(){return this.offset===0}get isAtEnd(){return this.offset==this.parent.maxOffset}compareWith(e){if(this.root!=e.root)return"different";const t=Gt(this.path,e.path);switch(t){case"same":return"same";case"prefix":return"before";case"extension":return"after";default:return this.path[t]<e.path[t]?"before":"after"}}getLastMatchingPosition(e,t={}){t.startPosition=this;const n=new Fi(t);return n.skip(e),n.position}getParentPath(){return this.path.slice(0,-1)}getAncestors(){const e=this.parent;return e.is("documentFragment")?[e]:e.getAncestors({includeSelf:!0})}findAncestor(e){const t=this.parent;return t.is("element")?t.findAncestor(e,{includeSelf:!0}):null}getCommonPath(e){if(this.root!=e.root)return[];const t=Gt(this.path,e.path),n=typeof t=="string"?Math.min(this.path.length,e.path.length):t;return this.path.slice(0,n)}getCommonAncestor(e){const t=this.getAncestors(),n=e.getAncestors();let i=0;for(;t[i]==n[i]&&t[i];)i++;return i===0?null:t[i-1]}getShiftedBy(e){const t=this.clone(),n=t.offset+e;return t.offset=n<0?0:n,t}isAfter(e){return this.compareWith(e)=="after"}isBefore(e){return this.compareWith(e)=="before"}isEqual(e){return this.compareWith(e)=="same"}isTouching(e){if(this.root!==e.root)return!1;const t=Math.min(this.path.length,e.path.length);for(let n=0;n<t;n++){const i=this.path[n]-e.path[n];if(i<-1||i>1)return!1;if(i===1)return Eg(e,this,n);if(i===-1)return Eg(this,e,n)}return this.path.length===e.path.length||(this.path.length>e.path.length?qd(this.path,t):qd(e.path,t))}hasSameParentAs(e){return this.root!==e.root?!1:Gt(this.getParentPath(),e.getParentPath())=="same"}getTransformedByOperation(e){let t;switch(e.type){case"insert":t=this._getTransformedByInsertOperation(e);break;case"move":case"remove":case"reinsert":t=this._getTransformedByMoveOperation(e);break;case"split":t=this._getTransformedBySplitOperation(e);break;case"merge":t=this._getTransformedByMergeOperation(e);break;default:t=le._createAt(this)}return t}_getTransformedByInsertOperation(e){return this._getTransformedByInsertion(e.position,e.howMany)}_getTransformedByMoveOperation(e){return this._getTransformedByMove(e.sourcePosition,e.targetPosition,e.howMany)}_getTransformedBySplitOperation(e){const t=e.movedRange;return t.containsPosition(this)||t.start.isEqual(this)&&this.stickiness=="toNext"?this._getCombined(e.splitPosition,e.moveTargetPosition):e.graveyardPosition?this._getTransformedByMove(e.graveyardPosition,e.insertionPosition,1):this._getTransformedByInsertion(e.insertionPosition,1)}_getTransformedByMergeOperation(e){const t=e.movedRange;let n;return t.containsPosition(this)||t.start.isEqual(this)?(n=this._getCombined(e.sourcePosition,e.targetPosition),e.sourcePosition.isBefore(e.targetPosition)&&(n=n._getTransformedByDeletion(e.deletionPosition,1))):n=this.isEqual(e.deletionPosition)?le._createAt(e.deletionPosition):this._getTransformedByMove(e.deletionPosition,e.graveyardPosition,1),n}_getTransformedByDeletion(e,t){const n=le._createAt(this);if(this.root!=e.root)return n;if(Gt(e.getParentPath(),this.getParentPath())=="same"){if(e.offset<this.offset){if(e.offset+t>this.offset)return null;n.offset-=t}}else if(Gt(e.getParentPath(),this.getParentPath())=="prefix"){const i=e.path.length-1;if(e.offset<=this.path[i]){if(e.offset+t>this.path[i])return null;n.path[i]-=t}}return n}_getTransformedByInsertion(e,t){const n=le._createAt(this);if(this.root!=e.root)return n;if(Gt(e.getParentPath(),this.getParentPath())=="same")(e.offset<this.offset||e.offset==this.offset&&this.stickiness!="toPrevious")&&(n.offset+=t);else if(Gt(e.getParentPath(),this.getParentPath())=="prefix"){const i=e.path.length-1;e.offset<=this.path[i]&&(n.path[i]+=t)}return n}_getTransformedByMove(e,t,n){if(t=t._getTransformedByDeletion(e,n),e.isEqual(t))return le._createAt(this);const i=this._getTransformedByDeletion(e,n);return i===null||e.isEqual(this)&&this.stickiness=="toNext"||e.getShiftedBy(n).isEqual(this)&&this.stickiness=="toPrevious"?this._getCombined(e,t):i._getTransformedByInsertion(t,n)}_getCombined(e,t){const n=e.path.length-1,i=le._createAt(t);return i.stickiness=this.stickiness,i.offset=i.offset+this.path[n]-e.offset,i.path=[...i.path,...this.path.slice(n+1)],i}toJSON(){return{root:this.root.toJSON(),path:Array.from(this.path),stickiness:this.stickiness}}clone(){return new this.constructor(this.root,this.path,this.stickiness)}static _createAt(e,t,n="toNone"){if(e instanceof le)return new le(e.root,e.path,e.stickiness);{const i=e;if(t=="end")t=i.maxOffset;else{if(t=="before")return this._createBefore(i,n);if(t=="after")return this._createAfter(i,n);if(t!==0&&!t)throw new V("model-createpositionat-offset-required",[this,e])}if(!i.is("element")&&!i.is("documentFragment"))throw new V("model-position-parent-incorrect",[this,e]);const r=i.getPath();return r.push(t),new this(i.root,r,n)}}static _createAfter(e,t){if(!e.parent)throw new V("model-position-after-root",[this,e],{root:e});return this._createAt(e.parent,e.endOffset,t)}static _createBefore(e,t){if(!e.parent)throw new V("model-position-before-root",e,{root:e});return this._createAt(e.parent,e.startOffset,t)}static fromJSON(e,t){if(e.root==="$graveyard"){const n=new le(t.graveyard,e.path);return n.stickiness=e.stickiness,n}if(!t.getRoot(e.root))throw new V("model-position-fromjson-no-root",t,{rootName:e.root});return new le(t.getRoot(e.root),e.path,e.stickiness)}}function Ws(o,e){const t=e.getChild(e.offsetToIndex(o.offset));return t&&t.is("$text")&&t.startOffset<o.offset?t:null}function xg(o,e,t){return t!==null?null:e.getChild(e.offsetToIndex(o.offset))}function Dg(o,e,t){return t!==null?null:e.getChild(e.offsetToIndex(o.offset)-1)}function Eg(o,e,t){return t+1!==o.path.length&&!!qd(e.path,t+1)&&!!function(n,i){let r=n.parent,s=n.path.length-1,a=0;for(;s>=i;){if(n.path[s]+a!==r.maxOffset)return!1;a=1,s--,r=r.parent}return!0}(o,t+1)}function qd(o,e){for(;e<o.length;){if(o[e]!==0)return!1;e++}return!0}le.prototype.is=function(o){return o==="position"||o==="model:position"};class ne extends To{constructor(e,t){super(),this.start=le._createAt(e),this.end=t?le._createAt(t):le._createAt(e),this.start.stickiness=this.isCollapsed?"toNone":"toNext",this.end.stickiness=this.isCollapsed?"toNone":"toPrevious"}*[Symbol.iterator](){yield*new Fi({boundaries:this,ignoreElementEnd:!0})}get isCollapsed(){return this.start.isEqual(this.end)}get isFlat(){return Gt(this.start.getParentPath(),this.end.getParentPath())=="same"}get root(){return this.start.root}containsPosition(e){return e.isAfter(this.start)&&e.isBefore(this.end)}containsRange(e,t=!1){e.isCollapsed&&(t=!1);const n=this.containsPosition(e.start)||t&&this.start.isEqual(e.start),i=this.containsPosition(e.end)||t&&this.end.isEqual(e.end);return n&&i}containsItem(e){const t=le._createBefore(e);return this.containsPosition(t)||this.start.isEqual(t)}isEqual(e){return this.start.isEqual(e.start)&&this.end.isEqual(e.end)}isIntersecting(e){return this.start.isBefore(e.end)&&this.end.isAfter(e.start)}getDifference(e){const t=[];return this.isIntersecting(e)?(this.containsPosition(e.start)&&t.push(new ne(this.start,e.start)),this.containsPosition(e.end)&&t.push(new ne(e.end,this.end))):t.push(new ne(this.start,this.end)),t}getIntersection(e){if(this.isIntersecting(e)){let t=this.start,n=this.end;return this.containsPosition(e.start)&&(t=e.start),this.containsPosition(e.end)&&(n=e.end),new ne(t,n)}return null}getJoined(e,t=!1){let n=this.isIntersecting(e);if(n||(n=this.start.isBefore(e.start)?t?this.end.isTouching(e.start):this.end.isEqual(e.start):t?e.end.isTouching(this.start):e.end.isEqual(this.start)),!n)return null;let i=this.start,r=this.end;return e.start.isBefore(i)&&(i=e.start),e.end.isAfter(r)&&(r=e.end),new ne(i,r)}getMinimalFlatRanges(){const e=[],t=this.start.getCommonPath(this.end).length,n=le._createAt(this.start);let i=n.parent;for(;n.path.length>t+1;){const r=i.maxOffset-n.offset;r!==0&&e.push(new ne(n,n.getShiftedBy(r))),n.path=n.path.slice(0,-1),n.offset++,i=i.parent}for(;n.path.length<=this.end.path.length;){const r=this.end.path[n.path.length-1],s=r-n.offset;s!==0&&e.push(new ne(n,n.getShiftedBy(s))),n.offset=r,n.path.push(0)}return e}getWalker(e={}){return e.boundaries=this,new Fi(e)}*getItems(e={}){e.boundaries=this,e.ignoreElementEnd=!0;const t=new Fi(e);for(const n of t)yield n.item}*getPositions(e={}){e.boundaries=this;const t=new Fi(e);yield t.position;for(const n of t)yield n.nextPosition}getTransformedByOperation(e){switch(e.type){case"insert":return this._getTransformedByInsertOperation(e);case"move":case"remove":case"reinsert":return this._getTransformedByMoveOperation(e);case"split":return[this._getTransformedBySplitOperation(e)];case"merge":return[this._getTransformedByMergeOperation(e)]}return[new ne(this.start,this.end)]}getTransformedByOperations(e){const t=[new ne(this.start,this.end)];for(const n of e)for(let i=0;i<t.length;i++){const r=t[i].getTransformedByOperation(n);t.splice(i,1,...r),i+=r.length-1}for(let n=0;n<t.length;n++){const i=t[n];for(let r=n+1;r<t.length;r++){const s=t[r];(i.containsRange(s)||s.containsRange(i)||i.isEqual(s))&&t.splice(r,1)}}return t}getCommonAncestor(){return this.start.getCommonAncestor(this.end)}getContainedElement(){if(this.isCollapsed)return null;const e=this.start.nodeAfter,t=this.end.nodeBefore;return e&&e.is("element")&&e===t?e:null}toJSON(){return{start:this.start.toJSON(),end:this.end.toJSON()}}clone(){return new this.constructor(this.start,this.end)}_getTransformedByInsertOperation(e,t=!1){return this._getTransformedByInsertion(e.position,e.howMany,t)}_getTransformedByMoveOperation(e,t=!1){const n=e.sourcePosition,i=e.howMany,r=e.targetPosition;return this._getTransformedByMove(n,r,i,t)}_getTransformedBySplitOperation(e){const t=this.start._getTransformedBySplitOperation(e);let n=this.end._getTransformedBySplitOperation(e);return this.end.isEqual(e.insertionPosition)&&(n=this.end.getShiftedBy(1)),t.root!=n.root&&(n=this.end.getShiftedBy(-1)),new ne(t,n)}_getTransformedByMergeOperation(e){if(this.start.isEqual(e.targetPosition)&&this.end.isEqual(e.deletionPosition))return new ne(this.start);let t=this.start._getTransformedByMergeOperation(e),n=this.end._getTransformedByMergeOperation(e);return t.root!=n.root&&(n=this.end.getShiftedBy(-1)),t.isAfter(n)?(e.sourcePosition.isBefore(e.targetPosition)?(t=le._createAt(n),t.offset=0):(e.deletionPosition.isEqual(t)||(n=e.deletionPosition),t=e.targetPosition),new ne(t,n)):new ne(t,n)}_getTransformedByInsertion(e,t,n=!1){if(n&&this.containsPosition(e))return[new ne(this.start,e),new ne(e.getShiftedBy(t),this.end._getTransformedByInsertion(e,t))];{const i=new ne(this.start,this.end);return i.start=i.start._getTransformedByInsertion(e,t),i.end=i.end._getTransformedByInsertion(e,t),[i]}}_getTransformedByMove(e,t,n,i=!1){if(this.isCollapsed){const m=this.start._getTransformedByMove(e,t,n);return[new ne(m)]}const r=ne._createFromPositionAndShift(e,n),s=t._getTransformedByDeletion(e,n);if(this.containsPosition(t)&&!i&&(r.containsPosition(this.start)||r.containsPosition(this.end))){const m=this.start._getTransformedByMove(e,t,n),v=this.end._getTransformedByMove(e,t,n);return[new ne(m,v)]}let a;const c=this.getDifference(r);let u=null;const f=this.getIntersection(r);if(c.length==1?u=new ne(c[0].start._getTransformedByDeletion(e,n),c[0].end._getTransformedByDeletion(e,n)):c.length==2&&(u=new ne(this.start,this.end._getTransformedByDeletion(e,n))),a=u?u._getTransformedByInsertion(s,n,f!==null||i):[],f){const m=new ne(f.start._getCombined(r.start,s),f.end._getCombined(r.start,s));a.length==2?a.splice(1,0,m):a.push(m)}return a}_getTransformedByDeletion(e,t){let n=this.start._getTransformedByDeletion(e,t),i=this.end._getTransformedByDeletion(e,t);return n==null&&i==null?null:(n==null&&(n=e),i==null&&(i=e),new ne(n,i))}static _createFromPositionAndShift(e,t){const n=e,i=e.getShiftedBy(t);return t>0?new this(n,i):new this(i,n)}static _createIn(e){return new this(le._createAt(e,0),le._createAt(e,e.maxOffset))}static _createOn(e){return this._createFromPositionAndShift(le._createBefore(e),e.offsetSize)}static _createFromRanges(e){if(e.length===0)throw new V("range-create-from-ranges-empty-array",null);if(e.length==1)return e[0].clone();const t=e[0];e.sort((r,s)=>r.start.isAfter(s.start)?1:-1);const n=e.indexOf(t),i=new this(t.start,t.end);if(n>0)for(let r=n-1;e[r].end.isEqual(i.start);r++)i.start=le._createAt(e[r].start);for(let r=n+1;r<e.length&&e[r].start.isEqual(i.end);r++)i.end=le._createAt(e[r].end);return i}static fromJSON(e,t){return new this(le.fromJSON(e.start,t),le.fromJSON(e.end,t))}}ne.prototype.is=function(o){return o==="range"||o==="model:range"};class Tg extends Ce(){constructor(){super(),this._modelToViewMapping=new WeakMap,this._viewToModelMapping=new WeakMap,this._viewToModelLengthCallbacks=new Map,this._markerNameToElements=new Map,this._elementToMarkerNames=new Map,this._deferredBindingRemovals=new Map,this._unboundMarkerNames=new Set,this.on("modelToViewPosition",(e,t)=>{if(t.viewPosition)return;const n=this._modelToViewMapping.get(t.modelPosition.parent);if(!n)throw new V("mapping-model-position-view-parent-not-found",this,{modelPosition:t.modelPosition});t.viewPosition=this.findPositionIn(n,t.modelPosition.offset)},{priority:"low"}),this.on("viewToModelPosition",(e,t)=>{if(t.modelPosition)return;const n=this.findMappedViewAncestor(t.viewPosition),i=this._viewToModelMapping.get(n),r=this._toModelOffset(t.viewPosition.parent,t.viewPosition.offset,n);t.modelPosition=le._createAt(i,r)},{priority:"low"})}bindElements(e,t){this._modelToViewMapping.set(e,t),this._viewToModelMapping.set(t,e)}unbindViewElement(e,t={}){const n=this.toModelElement(e);if(this._elementToMarkerNames.has(e))for(const i of this._elementToMarkerNames.get(e))this._unboundMarkerNames.add(i);t.defer?this._deferredBindingRemovals.set(e,e.root):(this._viewToModelMapping.delete(e),this._modelToViewMapping.get(n)==e&&this._modelToViewMapping.delete(n))}unbindModelElement(e){const t=this.toViewElement(e);this._modelToViewMapping.delete(e),this._viewToModelMapping.get(t)==e&&this._viewToModelMapping.delete(t)}bindElementToMarker(e,t){const n=this._markerNameToElements.get(t)||new Set;n.add(e);const i=this._elementToMarkerNames.get(e)||new Set;i.add(t),this._markerNameToElements.set(t,n),this._elementToMarkerNames.set(e,i)}unbindElementFromMarkerName(e,t){const n=this._markerNameToElements.get(t);n&&(n.delete(e),n.size==0&&this._markerNameToElements.delete(t));const i=this._elementToMarkerNames.get(e);i&&(i.delete(t),i.size==0&&this._elementToMarkerNames.delete(e))}flushUnboundMarkerNames(){const e=Array.from(this._unboundMarkerNames);return this._unboundMarkerNames.clear(),e}flushDeferredBindings(){for(const[e,t]of this._deferredBindingRemovals)e.root==t&&this.unbindViewElement(e);this._deferredBindingRemovals=new Map}clearBindings(){this._modelToViewMapping=new WeakMap,this._viewToModelMapping=new WeakMap,this._markerNameToElements=new Map,this._elementToMarkerNames=new Map,this._unboundMarkerNames=new Set,this._deferredBindingRemovals=new Map}toModelElement(e){return this._viewToModelMapping.get(e)}toViewElement(e){return this._modelToViewMapping.get(e)}toModelRange(e){return new ne(this.toModelPosition(e.start),this.toModelPosition(e.end))}toViewRange(e){return new Ne(this.toViewPosition(e.start),this.toViewPosition(e.end))}toModelPosition(e){const t={viewPosition:e,mapper:this};return this.fire("viewToModelPosition",t),t.modelPosition}toViewPosition(e,t={}){const n={modelPosition:e,mapper:this,isPhantom:t.isPhantom};return this.fire("modelToViewPosition",n),n.viewPosition}markerNameToElements(e){const t=this._markerNameToElements.get(e);if(!t)return null;const n=new Set;for(const i of t)if(i.is("attributeElement"))for(const r of i.getElementsWithSameId())n.add(r);else n.add(i);return n}registerViewToModelLength(e,t){this._viewToModelLengthCallbacks.set(e,t)}findMappedViewAncestor(e){let t=e.parent;for(;!this._viewToModelMapping.has(t);)t=t.parent;return t}_toModelOffset(e,t,n){if(n!=e)return this._toModelOffset(e.parent,e.index,n)+this._toModelOffset(e,t,e);if(e.is("$text"))return t;let i=0;for(let r=0;r<t;r++)i+=this.getModelLength(e.getChild(r));return i}getModelLength(e){if(this._viewToModelLengthCallbacks.get(e.name))return this._viewToModelLengthCallbacks.get(e.name)(e);if(this._viewToModelMapping.has(e))return 1;if(e.is("$text"))return e.data.length;if(e.is("uiElement"))return 0;{let t=0;for(const n of e.getChildren())t+=this.getModelLength(n);return t}}findPositionIn(e,t){let n,i=0,r=0,s=0;if(e.is("$text"))return new fe(e,t);for(;r<t;)n=e.getChild(s),i=this.getModelLength(n),r+=i,s++;return r==t?this._moveViewPositionToTextNode(new fe(e,s)):this.findPositionIn(n,t-(r-i))}_moveViewPositionToTextNode(e){const t=e.nodeBefore,n=e.nodeAfter;return t instanceof bt?new fe(t,t.data.length):n instanceof bt?new fe(n,0):e}}class rA{constructor(){this._consumable=new Map,this._textProxyRegistry=new Map}add(e,t){t=El(t),e instanceof wi&&(e=this._getSymbolForTextProxy(e)),this._consumable.has(e)||this._consumable.set(e,new Map),this._consumable.get(e).set(t,!0)}consume(e,t){return t=El(t),e instanceof wi&&(e=this._getSymbolForTextProxy(e)),!!this.test(e,t)&&(this._consumable.get(e).set(t,!1),!0)}test(e,t){t=El(t),e instanceof wi&&(e=this._getSymbolForTextProxy(e));const n=this._consumable.get(e);if(n===void 0)return null;const i=n.get(t);return i===void 0?null:i}revert(e,t){t=El(t),e instanceof wi&&(e=this._getSymbolForTextProxy(e));const n=this.test(e,t);return n===!1?(this._consumable.get(e).set(t,!0),!0):n!==!0&&null}verifyAllConsumed(e){const t=[];for(const[n,i]of this._consumable)for(const[r,s]of i){const a=r.split(":")[0];s&&e==a&&t.push({event:r,item:n.name||n.description})}if(t.length)throw new V("conversion-model-consumable-not-consumed",null,{items:t})}_getSymbolForTextProxy(e){let t=null;const n=this._textProxyRegistry.get(e.startOffset);if(n){const i=n.get(e.endOffset);i&&(t=i.get(e.parent))}return t||(t=this._addSymbolForTextProxy(e)),t}_addSymbolForTextProxy(e){const t=e.startOffset,n=e.endOffset,i=e.parent,r=Symbol("$textProxy:"+e.data);let s,a;return s=this._textProxyRegistry.get(t),s||(s=new Map,this._textProxyRegistry.set(t,s)),a=s.get(n),a||(a=new Map,s.set(n,a)),a.set(i,r),r}}function El(o){const e=o.split(":");return e[0]=="insert"?e[0]:e[0]=="addMarker"||e[0]=="removeMarker"?o:e.length>1?e[0]+":"+e[1]:e[0]}class Sg extends Ce(){constructor(e){super(),this._conversionApi={dispatcher:this,...e},this._firedEventsMap=new WeakMap}convertChanges(e,t,n){const i=this._createConversionApi(n,e.getRefreshedItems());for(const s of e.getMarkersToRemove())this._convertMarkerRemove(s.name,s.range,i);const r=this._reduceChanges(e.getChanges());for(const s of r)s.type==="insert"?this._convertInsert(ne._createFromPositionAndShift(s.position,s.length),i):s.type==="reinsert"?this._convertReinsert(ne._createFromPositionAndShift(s.position,s.length),i):s.type==="remove"?this._convertRemove(s.position,s.length,s.name,i):this._convertAttribute(s.range,s.attributeKey,s.attributeOldValue,s.attributeNewValue,i);for(const s of i.mapper.flushUnboundMarkerNames()){const a=t.get(s).getRange();this._convertMarkerRemove(s,a,i),this._convertMarkerAdd(s,a,i)}for(const s of e.getMarkersToAdd())this._convertMarkerAdd(s.name,s.range,i);i.mapper.flushDeferredBindings(),i.consumable.verifyAllConsumed("insert")}convert(e,t,n,i={}){const r=this._createConversionApi(n,void 0,i);this._convertInsert(e,r);for(const[s,a]of t)this._convertMarkerAdd(s,a,r);r.consumable.verifyAllConsumed("insert")}convertSelection(e,t,n){const i=Array.from(t.getMarkersAtPosition(e.getFirstPosition())),r=this._createConversionApi(n);if(this._addConsumablesForSelection(r.consumable,e,i),this.fire("selection",{selection:e},r),e.isCollapsed){for(const s of i){const a=s.getRange();if(!sA(e.getFirstPosition(),s,r.mapper))continue;const c={item:e,markerName:s.name,markerRange:a};r.consumable.test(e,"addMarker:"+s.name)&&this.fire(`addMarker:${s.name}`,c,r)}for(const s of e.getAttributeKeys()){const a={item:e,range:e.getFirstRange(),attributeKey:s,attributeOldValue:null,attributeNewValue:e.getAttribute(s)};r.consumable.test(e,"attribute:"+a.attributeKey)&&this.fire(`attribute:${a.attributeKey}:$text`,a,r)}}}_convertInsert(e,t,n={}){n.doNotAddConsumables||this._addConsumablesForInsert(t.consumable,Array.from(e));for(const i of Array.from(e.getWalker({shallow:!0})).map(Ig))this._testAndFire("insert",i,t)}_convertRemove(e,t,n,i){this.fire(`remove:${n}`,{position:e,length:t},i)}_convertAttribute(e,t,n,i,r){this._addConsumablesForRange(r.consumable,e,`attribute:${t}`);for(const s of e){const a={item:s.item,range:ne._createFromPositionAndShift(s.previousPosition,s.length),attributeKey:t,attributeOldValue:n,attributeNewValue:i};this._testAndFire(`attribute:${t}`,a,r)}}_convertReinsert(e,t){const n=Array.from(e.getWalker({shallow:!0}));this._addConsumablesForInsert(t.consumable,n);for(const i of n.map(Ig))this._testAndFire("insert",{...i,reconversion:!0},t)}_convertMarkerAdd(e,t,n){if(t.root.rootName=="$graveyard")return;const i=`addMarker:${e}`;if(n.consumable.add(t,i),this.fire(i,{markerName:e,markerRange:t},n),n.consumable.consume(t,i)){this._addConsumablesForRange(n.consumable,t,i);for(const r of t.getItems()){if(!n.consumable.test(r,i))continue;const s={item:r,range:ne._createOn(r),markerName:e,markerRange:t};this.fire(i,s,n)}}}_convertMarkerRemove(e,t,n){t.root.rootName!="$graveyard"&&this.fire(`removeMarker:${e}`,{markerName:e,markerRange:t},n)}_reduceChanges(e){const t={changes:e};return this.fire("reduceChanges",t),t.changes}_addConsumablesForInsert(e,t){for(const n of t){const i=n.item;if(e.test(i,"insert")===null){e.add(i,"insert");for(const r of i.getAttributeKeys())e.add(i,"attribute:"+r)}}return e}_addConsumablesForRange(e,t,n){for(const i of t.getItems())e.add(i,n);return e}_addConsumablesForSelection(e,t,n){e.add(t,"selection");for(const i of n)e.add(t,"addMarker:"+i.name);for(const i of t.getAttributeKeys())e.add(t,"attribute:"+i);return e}_testAndFire(e,t,n){const i=function(c,u){const f=u.item.is("element")?u.item.name:"$text";return`${c}:${f}`}(e,t),r=t.item.is("$textProxy")?n.consumable._getSymbolForTextProxy(t.item):t.item,s=this._firedEventsMap.get(n),a=s.get(r);if(a){if(a.has(i))return;a.add(i)}else s.set(r,new Set([i]));this.fire(i,t,n)}_testAndFireAddAttributes(e,t){const n={item:e,range:ne._createOn(e)};for(const i of n.item.getAttributeKeys())n.attributeKey=i,n.attributeOldValue=null,n.attributeNewValue=n.item.getAttribute(i),this._testAndFire(`attribute:${i}`,n,t)}_createConversionApi(e,t=new Set,n={}){const i={...this._conversionApi,consumable:new rA,writer:e,options:n,convertItem:r=>this._convertInsert(ne._createOn(r),i),convertChildren:r=>this._convertInsert(ne._createIn(r),i,{doNotAddConsumables:!0}),convertAttributes:r=>this._testAndFireAddAttributes(r,i),canReuseView:r=>!t.has(i.mapper.toModelElement(r))};return this._firedEventsMap.set(i,new Map),i}}function sA(o,e,t){const n=e.getRange(),i=Array.from(o.getAncestors());return i.shift(),i.reverse(),!i.some(r=>{if(n.containsItem(r))return!!t.toViewElement(r).getCustomProperty("addHighlight")})}function Ig(o){return{item:o.item,range:ne._createFromPositionAndShift(o.previousPosition,o.length)}}class Vi extends Ce(To){constructor(...e){super(),this._lastRangeBackward=!1,this._attrs=new Map,this._ranges=[],e.length&&this.setTo(...e)}get anchor(){if(this._ranges.length>0){const e=this._ranges[this._ranges.length-1];return this._lastRangeBackward?e.end:e.start}return null}get focus(){if(this._ranges.length>0){const e=this._ranges[this._ranges.length-1];return this._lastRangeBackward?e.start:e.end}return null}get isCollapsed(){return this._ranges.length===1&&this._ranges[0].isCollapsed}get rangeCount(){return this._ranges.length}get isBackward(){return!this.isCollapsed&&this._lastRangeBackward}isEqual(e){if(this.rangeCount!=e.rangeCount)return!1;if(this.rangeCount===0)return!0;if(!this.anchor.isEqual(e.anchor)||!this.focus.isEqual(e.focus))return!1;for(const t of this._ranges){let n=!1;for(const i of e._ranges)if(t.isEqual(i)){n=!0;break}if(!n)return!1}return!0}*getRanges(){for(const e of this._ranges)yield new ne(e.start,e.end)}getFirstRange(){let e=null;for(const t of this._ranges)e&&!t.start.isBefore(e.start)||(e=t);return e?new ne(e.start,e.end):null}getLastRange(){let e=null;for(const t of this._ranges)e&&!t.end.isAfter(e.end)||(e=t);return e?new ne(e.start,e.end):null}getFirstPosition(){const e=this.getFirstRange();return e?e.start.clone():null}getLastPosition(){const e=this.getLastRange();return e?e.end.clone():null}setTo(...e){let[t,n,i]=e;if(typeof n=="object"&&(i=n,n=void 0),t===null)this._setRanges([]);else if(t instanceof Vi)this._setRanges(t.getRanges(),t.isBackward);else if(t&&typeof t.getRanges=="function")this._setRanges(t.getRanges(),t.isBackward);else if(t instanceof ne)this._setRanges([t],!!i&&!!i.backward);else if(t instanceof le)this._setRanges([new ne(t)]);else if(t instanceof Or){const r=!!i&&!!i.backward;let s;if(n=="in")s=ne._createIn(t);else if(n=="on")s=ne._createOn(t);else{if(n===void 0)throw new V("model-selection-setto-required-second-parameter",[this,t]);s=new ne(le._createAt(t,n))}this._setRanges([s],r)}else{if(!bn(t))throw new V("model-selection-setto-not-selectable",[this,t]);this._setRanges(t,i&&!!i.backward)}}_setRanges(e,t=!1){const n=Array.from(e),i=n.some(r=>{if(!(r instanceof ne))throw new V("model-selection-set-ranges-not-range",[this,e]);return this._ranges.every(s=>!s.isEqual(r))});(n.length!==this._ranges.length||i)&&(this._replaceAllRanges(n),this._lastRangeBackward=!!t,this.fire("change:range",{directChange:!0}))}setFocus(e,t){if(this.anchor===null)throw new V("model-selection-setfocus-no-ranges",[this,e]);const n=le._createAt(e,t);if(n.compareWith(this.focus)=="same")return;const i=this.anchor;this._ranges.length&&this._popRange(),n.compareWith(i)=="before"?(this._pushRange(new ne(n,i)),this._lastRangeBackward=!0):(this._pushRange(new ne(i,n)),this._lastRangeBackward=!1),this.fire("change:range",{directChange:!0})}getAttribute(e){return this._attrs.get(e)}getAttributes(){return this._attrs.entries()}getAttributeKeys(){return this._attrs.keys()}hasAttribute(e){return this._attrs.has(e)}removeAttribute(e){this.hasAttribute(e)&&(this._attrs.delete(e),this.fire("change:attribute",{attributeKeys:[e],directChange:!0}))}setAttribute(e,t){this.getAttribute(e)!==t&&(this._attrs.set(e,t),this.fire("change:attribute",{attributeKeys:[e],directChange:!0}))}getSelectedElement(){return this.rangeCount!==1?null:this.getFirstRange().getContainedElement()}*getSelectedBlocks(){const e=new WeakSet;for(const t of this.getRanges()){const n=Ng(t.start,e);n&&Gd(n,t)&&(yield n);for(const r of t.getWalker()){const s=r.item;r.type=="elementEnd"&&aA(s,e,t)&&(yield s)}const i=Ng(t.end,e);i&&!t.end.isTouching(le._createAt(i,0))&&Gd(i,t)&&(yield i)}}containsEntireContent(e=this.anchor.root){const t=le._createAt(e,0),n=le._createAt(e,"end");return t.isTouching(this.getFirstPosition())&&n.isTouching(this.getLastPosition())}_pushRange(e){this._checkRange(e),this._ranges.push(new ne(e.start,e.end))}_checkRange(e){for(let t=0;t<this._ranges.length;t++)if(e.isIntersecting(this._ranges[t]))throw new V("model-selection-range-intersects",[this,e],{addedRange:e,intersectingRange:this._ranges[t]})}_replaceAllRanges(e){this._removeAllRanges();for(const t of e)this._pushRange(t)}_removeAllRanges(){for(;this._ranges.length>0;)this._popRange()}_popRange(){this._ranges.pop()}}function Mg(o,e){return!e.has(o)&&(e.add(o),o.root.document.model.schema.isBlock(o)&&!!o.parent)}function aA(o,e,t){return Mg(o,e)&&Gd(o,t)}function Ng(o,e){const t=o.parent.root.document.model.schema,n=o.parent.getAncestors({parentFirst:!0,includeSelf:!0});let i=!1;const r=n.find(s=>!i&&(i=t.isLimit(s),!i&&Mg(s,e)));return n.forEach(s=>e.add(s)),r}function Gd(o,e){const t=function(n){const i=n.root.document.model.schema;let r=n.parent;for(;r;){if(i.isBlock(r))return r;r=r.parent}}(o);return t?!e.containsRange(ne._createOn(t),!0):!0}Vi.prototype.is=function(o){return o==="selection"||o==="model:selection"};class vi extends Ce(ne){constructor(e,t){super(e,t),lA.call(this)}detach(){this.stopListening()}toRange(){return new ne(this.start,this.end)}static fromRange(e){return new vi(e.start,e.end)}}function lA(){this.listenTo(this.root.document.model,"applyOperation",(o,e)=>{const t=e[0];t.isDocumentOperation&&cA.call(this,t)},{priority:"low"})}function cA(o){const e=this.getTransformedByOperation(o),t=ne._createFromRanges(e),n=!t.isEqual(this),i=function(s,a){switch(a.type){case"insert":return s.containsPosition(a.position);case"move":case"remove":case"reinsert":case"merge":return s.containsPosition(a.sourcePosition)||s.start.isEqual(a.sourcePosition)||s.containsPosition(a.targetPosition);case"split":return s.containsPosition(a.splitPosition)||s.containsPosition(a.insertionPosition)}return!1}(this,o);let r=null;if(n){t.root.rootName=="$graveyard"&&(r=o.type=="remove"?o.sourcePosition:o.deletionPosition);const s=this.toRange();this.start=t.start,this.end=t.end,this.fire("change:range",s,{deletionPosition:r})}else i&&this.fire("change:content",this.toRange(),{deletionPosition:r})}vi.prototype.is=function(o){return o==="liveRange"||o==="model:liveRange"||o=="range"||o==="model:range"};const qs="selection:";class ai extends Ce(To){constructor(e){super(),this._selection=new dA(e),this._selection.delegate("change:range").to(this),this._selection.delegate("change:attribute").to(this),this._selection.delegate("change:marker").to(this)}get isCollapsed(){return this._selection.isCollapsed}get anchor(){return this._selection.anchor}get focus(){return this._selection.focus}get rangeCount(){return this._selection.rangeCount}get hasOwnRange(){return this._selection.hasOwnRange}get isBackward(){return this._selection.isBackward}get isGravityOverridden(){return this._selection.isGravityOverridden}get markers(){return this._selection.markers}get _ranges(){return this._selection._ranges}getRanges(){return this._selection.getRanges()}getFirstPosition(){return this._selection.getFirstPosition()}getLastPosition(){return this._selection.getLastPosition()}getFirstRange(){return this._selection.getFirstRange()}getLastRange(){return this._selection.getLastRange()}getSelectedBlocks(){return this._selection.getSelectedBlocks()}getSelectedElement(){return this._selection.getSelectedElement()}containsEntireContent(e){return this._selection.containsEntireContent(e)}destroy(){this._selection.destroy()}getAttributeKeys(){return this._selection.getAttributeKeys()}getAttributes(){return this._selection.getAttributes()}getAttribute(e){return this._selection.getAttribute(e)}hasAttribute(e){return this._selection.hasAttribute(e)}refresh(){this._selection.updateMarkers(),this._selection._updateAttributes(!1)}observeMarkers(e){this._selection.observeMarkers(e)}_setFocus(e,t){this._selection.setFocus(e,t)}_setTo(...e){this._selection.setTo(...e)}_setAttribute(e,t){this._selection.setAttribute(e,t)}_removeAttribute(e){this._selection.removeAttribute(e)}_getStoredAttributes(){return this._selection.getStoredAttributes()}_overrideGravity(){return this._selection.overrideGravity()}_restoreGravity(e){this._selection.restoreGravity(e)}static _getStoreAttributeKey(e){return qs+e}static _isStoreAttributeKey(e){return e.startsWith(qs)}}ai.prototype.is=function(o){return o==="selection"||o=="model:selection"||o=="documentSelection"||o=="model:documentSelection"};class dA extends Vi{constructor(e){super(),this.markers=new _n({idProperty:"name"}),this._attributePriority=new Map,this._selectionRestorePosition=null,this._hasChangedRange=!1,this._overriddenGravityRegister=new Set,this._observedMarkers=new Set,this._model=e.model,this._document=e,this.listenTo(this._model,"applyOperation",(t,n)=>{const i=n[0];i.isDocumentOperation&&i.type!="marker"&&i.type!="rename"&&i.type!="noop"&&(this._ranges.length==0&&this._selectionRestorePosition&&this._fixGraveyardSelection(this._selectionRestorePosition),this._selectionRestorePosition=null,this._hasChangedRange&&(this._hasChangedRange=!1,this.fire("change:range",{directChange:!1})))},{priority:"lowest"}),this.on("change:range",()=>{this._validateSelectionRanges(this.getRanges())}),this.listenTo(this._model.markers,"update",(t,n,i,r)=>{this._updateMarker(n,r)}),this.listenTo(this._document,"change",(t,n)=>{(function(i,r){const s=i.document.differ;for(const a of s.getChanges()){if(a.type!="insert")continue;const c=a.position.parent;a.length===c.maxOffset&&i.enqueueChange(r,u=>{const f=Array.from(c.getAttributeKeys()).filter(m=>m.startsWith(qs));for(const m of f)u.removeAttribute(m,c)})}})(this._model,n)})}get isCollapsed(){return this._ranges.length===0?this._document._getDefaultRange().isCollapsed:super.isCollapsed}get anchor(){return super.anchor||this._document._getDefaultRange().start}get focus(){return super.focus||this._document._getDefaultRange().end}get rangeCount(){return this._ranges.length?this._ranges.length:1}get hasOwnRange(){return this._ranges.length>0}get isGravityOverridden(){return!!this._overriddenGravityRegister.size}destroy(){for(let e=0;e<this._ranges.length;e++)this._ranges[e].detach();this.stopListening()}*getRanges(){this._ranges.length?yield*super.getRanges():yield this._document._getDefaultRange()}getFirstRange(){return super.getFirstRange()||this._document._getDefaultRange()}getLastRange(){return super.getLastRange()||this._document._getDefaultRange()}setTo(...e){super.setTo(...e),this._updateAttributes(!0),this.updateMarkers()}setFocus(e,t){super.setFocus(e,t),this._updateAttributes(!0),this.updateMarkers()}setAttribute(e,t){if(this._setAttribute(e,t)){const n=[e];this.fire("change:attribute",{attributeKeys:n,directChange:!0})}}removeAttribute(e){if(this._removeAttribute(e)){const t=[e];this.fire("change:attribute",{attributeKeys:t,directChange:!0})}}overrideGravity(){const e=K();return this._overriddenGravityRegister.add(e),this._overriddenGravityRegister.size===1&&this._updateAttributes(!0),e}restoreGravity(e){if(!this._overriddenGravityRegister.has(e))throw new V("document-selection-gravity-wrong-restore",this,{uid:e});this._overriddenGravityRegister.delete(e),this.isGravityOverridden||this._updateAttributes(!0)}observeMarkers(e){this._observedMarkers.add(e),this.updateMarkers()}_replaceAllRanges(e){this._validateSelectionRanges(e),super._replaceAllRanges(e)}_popRange(){this._ranges.pop().detach()}_pushRange(e){const t=this._prepareRange(e);t&&this._ranges.push(t)}_validateSelectionRanges(e){for(const t of e)if(!this._document._validateSelectionRange(t))throw new V("document-selection-wrong-position",this,{range:t})}_prepareRange(e){if(this._checkRange(e),e.root==this._document.graveyard)return;const t=vi.fromRange(e);return t.on("change:range",(n,i,r)=>{if(this._hasChangedRange=!0,t.root==this._document.graveyard){this._selectionRestorePosition=r.deletionPosition;const s=this._ranges.indexOf(t);this._ranges.splice(s,1),t.detach()}}),t}updateMarkers(){if(!this._observedMarkers.size)return;const e=[];let t=!1;for(const i of this._model.markers){const r=i.name.split(":",1)[0];if(!this._observedMarkers.has(r))continue;const s=i.getRange();for(const a of this.getRanges())s.containsRange(a,!a.isCollapsed)&&e.push(i)}const n=Array.from(this.markers);for(const i of e)this.markers.has(i)||(this.markers.add(i),t=!0);for(const i of Array.from(this.markers))e.includes(i)||(this.markers.remove(i),t=!0);t&&this.fire("change:marker",{oldMarkers:n,directChange:!1})}_updateMarker(e,t){const n=e.name.split(":",1)[0];if(!this._observedMarkers.has(n))return;let i=!1;const r=Array.from(this.markers),s=this.markers.has(e);if(t){let a=!1;for(const c of this.getRanges())if(t.containsRange(c,!c.isCollapsed)){a=!0;break}a&&!s?(this.markers.add(e),i=!0):!a&&s&&(this.markers.remove(e),i=!0)}else s&&(this.markers.remove(e),i=!0);i&&this.fire("change:marker",{oldMarkers:r,directChange:!1})}_updateAttributes(e){const t=Bi(this._getSurroundingAttributes()),n=Bi(this.getAttributes());if(e)this._attributePriority=new Map,this._attrs=new Map;else for(const[r,s]of this._attributePriority)s=="low"&&(this._attrs.delete(r),this._attributePriority.delete(r));this._setAttributesTo(t);const i=[];for(const[r,s]of this.getAttributes())n.has(r)&&n.get(r)===s||i.push(r);for(const[r]of n)this.hasAttribute(r)||i.push(r);i.length>0&&this.fire("change:attribute",{attributeKeys:i,directChange:!1})}_setAttribute(e,t,n=!0){const i=n?"normal":"low";return i=="low"&&this._attributePriority.get(e)=="normal"?!1:super.getAttribute(e)!==t&&(this._attrs.set(e,t),this._attributePriority.set(e,i),!0)}_removeAttribute(e,t=!0){const n=t?"normal":"low";return(n!="low"||this._attributePriority.get(e)!="normal")&&(this._attributePriority.set(e,n),!!super.hasAttribute(e)&&(this._attrs.delete(e),!0))}_setAttributesTo(e){const t=new Set;for(const[n,i]of this.getAttributes())e.get(n)!==i&&this._removeAttribute(n,!1);for(const[n,i]of e)this._setAttribute(n,i,!1)&&t.add(n);return t}*getStoredAttributes(){const e=this.getFirstPosition().parent;if(this.isCollapsed&&e.isEmpty)for(const t of e.getAttributeKeys())t.startsWith(qs)&&(yield[t.substr(qs.length),e.getAttribute(t)])}_getSurroundingAttributes(){const e=this.getFirstPosition(),t=this._model.schema;let n=null;if(this.isCollapsed){const i=e.textNode?e.textNode:e.nodeBefore,r=e.textNode?e.textNode:e.nodeAfter;if(this.isGravityOverridden||(n=Tl(i)),n||(n=Tl(r)),!this.isGravityOverridden&&!n){let s=i;for(;s&&!t.isInline(s)&&!n;)s=s.previousSibling,n=Tl(s)}if(!n){let s=r;for(;s&&!t.isInline(s)&&!n;)s=s.nextSibling,n=Tl(s)}n||(n=this.getStoredAttributes())}else{const i=this.getFirstRange();for(const r of i){if(r.item.is("element")&&t.isObject(r.item))break;if(r.type=="text"){n=r.item.getAttributes();break}}}return n}_fixGraveyardSelection(e){const t=this._model.schema.getNearestSelectionRange(e);t&&this._pushRange(t)}}function Tl(o){return o instanceof wi||o instanceof kt?o.getAttributes():null}class Pg{constructor(e){this._dispatchers=e}add(e){for(const t of this._dispatchers)e(t);return this}}var uA=1,hA=4;const ar=function(o){return md(o,uA|hA)};class fA extends Pg{elementToElement(e){return this.add(function(t){const n=zg(t.model),i=Gs(t.view,"container");return n.attributes.length&&(n.children=!0),r=>{r.on(`insert:${n.name}`,function(s,a=pA){return(c,u,f)=>{if(!a(u.item,f.consumable,{preflight:!0}))return;const m=s(u.item,f,u);if(!m)return;a(u.item,f.consumable);const v=f.mapper.toViewPosition(u.range.start);f.mapper.bindElements(u.item,m),f.writer.insert(v,m),f.convertAttributes(u.item),Vg(m,u.item.getChildren(),f,{reconversion:u.reconversion})}}(i,Fg(n)),{priority:t.converterPriority||"normal"}),(n.children||n.attributes.length)&&r.on("reduceChanges",jg(n),{priority:"low"})}}(e))}elementToStructure(e){return this.add(function(t){const n=zg(t.model),i=Gs(t.view,"container");return n.children=!0,r=>{if(r._conversionApi.schema.checkChild(n.name,"$text"))throw new V("conversion-element-to-structure-disallowed-text",r,{elementName:n.name});var s,a;r.on(`insert:${n.name}`,(s=i,a=Fg(n),(c,u,f)=>{if(!a(u.item,f.consumable,{preflight:!0}))return;const m=new Map;f.writer._registerSlotFactory(function(I,L,R){return(H,$="children")=>{const te=H.createContainerElement("$slot");let ue=null;if($==="children")ue=Array.from(I.getChildren());else{if(typeof $!="function")throw new V("conversion-slot-mode-unknown",R.dispatcher,{modeOrFilter:$});ue=Array.from(I.getChildren()).filter(De=>$(De))}return L.set(te,ue),te}}(u.item,m,f));const v=s(u.item,f,u);if(f.writer._clearSlotFactory(),!v)return;(function(I,L,R){const H=Array.from(L.values()).flat(),$=new Set(H);if($.size!=H.length)throw new V("conversion-slot-filter-overlap",R.dispatcher,{element:I});if($.size!=I.childCount)throw new V("conversion-slot-filter-incomplete",R.dispatcher,{element:I})})(u.item,m,f),a(u.item,f.consumable);const E=f.mapper.toViewPosition(u.range.start);f.mapper.bindElements(u.item,v),f.writer.insert(E,v),f.convertAttributes(u.item),function(I,L,R,H){R.mapper.on("modelToViewPosition",ue,{priority:"highest"});let $=null,te=null;for([$,te]of L)Vg(I,te,R,H),R.writer.move(R.writer.createRangeIn($),R.writer.createPositionBefore($)),R.writer.remove($);function ue(De,Ze){const qe=Ze.modelPosition.nodeAfter,Tt=te.indexOf(qe);Tt<0||(Ze.viewPosition=Ze.mapper.findPositionIn($,Tt))}R.mapper.off("modelToViewPosition",ue)}(v,m,f,{reconversion:u.reconversion})}),{priority:t.converterPriority||"normal"}),r.on("reduceChanges",jg(n),{priority:"low"})}}(e))}attributeToElement(e){return this.add(function(t){t=ar(t);let n=t.model;typeof n=="string"&&(n={key:n});let i=`attribute:${n.key}`;if(n.name&&(i+=":"+n.name),n.values)for(const s of n.values)t.view[s]=Gs(t.view[s],"attribute");else t.view=Gs(t.view,"attribute");const r=Og(t);return s=>{s.on(i,function(a){return(c,u,f)=>{if(!f.consumable.test(u.item,c.name))return;const m=a(u.attributeOldValue,f,u),v=a(u.attributeNewValue,f,u);if(!m&&!v)return;f.consumable.consume(u.item,c.name);const E=f.writer,I=E.document.selection;if(u.item instanceof Vi||u.item instanceof ai)E.wrap(I.getFirstRange(),v);else{let L=f.mapper.toViewRange(u.range);u.attributeOldValue!==null&&m&&(L=E.unwrap(L,m)),u.attributeNewValue!==null&&v&&E.wrap(L,v)}}}(r),{priority:t.converterPriority||"normal"})}}(e))}attributeToAttribute(e){return this.add(function(t){t=ar(t);let n=t.model;typeof n=="string"&&(n={key:n});let i=`attribute:${n.key}`;if(n.name&&(i+=":"+n.name),n.values)for(const s of n.values)t.view[s]=Rg(t.view[s]);else t.view=Rg(t.view);const r=Og(t);return s=>{var a;s.on(i,(a=r,(c,u,f)=>{if(!f.consumable.test(u.item,c.name))return;const m=a(u.attributeOldValue,f,u),v=a(u.attributeNewValue,f,u);if(!m&&!v)return;f.consumable.consume(u.item,c.name);const E=f.mapper.toViewElement(u.item),I=f.writer;if(!E)throw new V("conversion-attribute-to-attribute-on-text",f.dispatcher,u);if(u.attributeOldValue!==null&&m)if(m.key=="class"){const L=Kt(m.value);for(const R of L)I.removeClass(R,E)}else if(m.key=="style"){const L=Object.keys(m.value);for(const R of L)I.removeStyle(R,E)}else I.removeAttribute(m.key,E);if(u.attributeNewValue!==null&&v)if(v.key=="class"){const L=Kt(v.value);for(const R of L)I.addClass(R,E)}else if(v.key=="style"){const L=Object.keys(v.value);for(const R of L)I.setStyle(R,v.value[R],E)}else I.setAttribute(v.key,v.value,E)}),{priority:t.converterPriority||"normal"})}}(e))}markerToElement(e){return this.add(function(t){const n=Gs(t.view,"ui");return i=>{var r;i.on(`addMarker:${t.model}`,(r=n,(s,a,c)=>{a.isOpening=!0;const u=r(a,c);a.isOpening=!1;const f=r(a,c);if(!u||!f)return;const m=a.markerRange;if(m.isCollapsed&&!c.consumable.consume(m,s.name))return;for(const I of m)if(!c.consumable.consume(I.item,s.name))return;const v=c.mapper,E=c.writer;E.insert(v.toViewPosition(m.start),u),c.mapper.bindElementToMarker(u,a.markerName),m.isCollapsed||(E.insert(v.toViewPosition(m.end),f),c.mapper.bindElementToMarker(f,a.markerName)),s.stop()}),{priority:t.converterPriority||"normal"}),i.on(`removeMarker:${t.model}`,(s,a,c)=>{const u=c.mapper.markerNameToElements(a.markerName);if(u){for(const f of u)c.mapper.unbindElementFromMarkerName(f,a.markerName),c.writer.clear(c.writer.createRangeOn(f),f);c.writer.clearClonedElementsGroup(a.markerName),s.stop()}},{priority:t.converterPriority||"normal"})}}(e))}markerToHighlight(e){return this.add(function(t){return n=>{var i;n.on(`addMarker:${t.model}`,(i=t.view,(r,s,a)=>{if(!s.item||!(s.item instanceof Vi||s.item instanceof ai||s.item.is("$textProxy")))return;const c=$d(i,s,a);if(!c||!a.consumable.consume(s.item,r.name))return;const u=a.writer,f=Bg(u,c),m=u.document.selection;if(s.item instanceof Vi||s.item instanceof ai)u.wrap(m.getFirstRange(),f);else{const v=a.mapper.toViewRange(s.range),E=u.wrap(v,f);for(const I of E.getItems())if(I.is("attributeElement")&&I.isSimilar(f)){a.mapper.bindElementToMarker(I,s.markerName);break}}}),{priority:t.converterPriority||"normal"}),n.on(`addMarker:${t.model}`,function(r){return(s,a,c)=>{if(!a.item||!(a.item instanceof gt))return;const u=$d(r,a,c);if(!u||!c.consumable.test(a.item,s.name))return;const f=c.mapper.toViewElement(a.item);if(f&&f.getCustomProperty("addHighlight")){c.consumable.consume(a.item,s.name);for(const m of ne._createIn(a.item))c.consumable.consume(m.item,s.name);f.getCustomProperty("addHighlight")(f,u,c.writer),c.mapper.bindElementToMarker(f,a.markerName)}}}(t.view),{priority:t.converterPriority||"normal"}),n.on(`removeMarker:${t.model}`,function(r){return(s,a,c)=>{if(a.markerRange.isCollapsed)return;const u=$d(r,a,c);if(!u)return;const f=Bg(c.writer,u),m=c.mapper.markerNameToElements(a.markerName);if(m){for(const v of m)c.mapper.unbindElementFromMarkerName(v,a.markerName),v.is("attributeElement")?c.writer.unwrap(c.writer.createRangeOn(v),f):v.getCustomProperty("removeHighlight")(v,u.id,c.writer);c.writer.clearClonedElementsGroup(a.markerName),s.stop()}}}(t.view),{priority:t.converterPriority||"normal"})}}(e))}markerToData(e){return this.add(function(t){t=ar(t);const n=t.model;let i=t.view;return i||(i=r=>({group:n,name:r.substr(t.model.length+1)})),r=>{var s;r.on(`addMarker:${n}`,(s=i,(a,c,u)=>{const f=s(c.markerName,u);if(!f)return;const m=c.markerRange;u.consumable.consume(m,a.name)&&(Lg(m,!1,u,c,f),Lg(m,!0,u,c,f),a.stop())}),{priority:t.converterPriority||"normal"}),r.on(`removeMarker:${n}`,function(a){return(c,u,f)=>{const m=a(u.markerName,f);if(!m)return;const v=f.mapper.markerNameToElements(u.markerName);if(v){for(const I of v)f.mapper.unbindElementFromMarkerName(I,u.markerName),I.is("containerElement")?(E(`data-${m.group}-start-before`,I),E(`data-${m.group}-start-after`,I),E(`data-${m.group}-end-before`,I),E(`data-${m.group}-end-after`,I)):f.writer.clear(f.writer.createRangeOn(I),I);f.writer.clearClonedElementsGroup(u.markerName),c.stop()}function E(I,L){if(L.hasAttribute(I)){const R=new Set(L.getAttribute(I).split(","));R.delete(m.name),R.size==0?f.writer.removeAttribute(I,L):f.writer.setAttribute(I,Array.from(R).join(","),L)}}}}(i),{priority:t.converterPriority||"normal"})}}(e))}}function Bg(o,e){const t=o.createAttributeElement("span",e.attributes);return e.classes&&t._addClass(e.classes),typeof e.priority=="number"&&(t._priority=e.priority),t._id=e.id,t}function Lg(o,e,t,n,i){const r=e?o.start:o.end,s=r.nodeAfter&&r.nodeAfter.is("element")?r.nodeAfter:null,a=r.nodeBefore&&r.nodeBefore.is("element")?r.nodeBefore:null;if(s||a){let c,u;e&&s||!e&&!a?(c=s,u=!0):(c=a,u=!1);const f=t.mapper.toViewElement(c);if(f)return void function(m,v,E,I,L,R){const H=`data-${R.group}-${v?"start":"end"}-${E?"before":"after"}`,$=m.hasAttribute(H)?m.getAttribute(H).split(","):[];$.unshift(R.name),I.writer.setAttribute(H,$.join(","),m),I.mapper.bindElementToMarker(m,L.markerName)}(f,e,u,t,n,i)}(function(c,u,f,m,v){const E=`${v.group}-${u?"start":"end"}`,I=v.name?{name:v.name}:null,L=f.writer.createUIElement(E,I);f.writer.insert(c,L),f.mapper.bindElementToMarker(L,m.markerName)})(t.mapper.toViewPosition(r),e,t,n,i)}function zg(o){return typeof o=="string"&&(o={name:o}),o.attributes?Array.isArray(o.attributes)||(o.attributes=[o.attributes]):o.attributes=[],o.children=!!o.children,o}function Gs(o,e){return typeof o=="function"?o:(t,n)=>function(i,r,s){typeof i=="string"&&(i={name:i});let a;const c=r.writer,u=Object.assign({},i.attributes);if(s=="container")a=c.createContainerElement(i.name,u);else if(s=="attribute"){const f={priority:i.priority||or.DEFAULT_PRIORITY};a=c.createAttributeElement(i.name,u,f)}else a=c.createUIElement(i.name,u);if(i.styles){const f=Object.keys(i.styles);for(const m of f)c.setStyle(m,i.styles[m],a)}if(i.classes){const f=i.classes;if(typeof f=="string")c.addClass(f,a);else for(const m of f)c.addClass(m,a)}return a}(o,n,e)}function Og(o){return o.model.values?(e,t,n)=>{const i=o.view[e];return i?i(e,t,n):null}:o.view}function Rg(o){return typeof o=="string"?e=>({key:o,value:e}):typeof o=="object"?o.value?()=>o:e=>({key:o.key,value:e}):o}function $d(o,e,t){const n=typeof o=="function"?o(e,t):o;return n?(n.priority||(n.priority=10),n.id||(n.id=e.markerName),n):null}function jg(o){const e=function(t){return(n,i)=>{if(!n.is("element",t.name))return!1;if(i.type=="attribute"){if(t.attributes.includes(i.attributeKey))return!0}else if(t.children)return!0;return!1}}(o);return(t,n)=>{const i=[];n.reconvertedElements||(n.reconvertedElements=new Set);for(const r of n.changes){const s=r.type=="attribute"?r.range.start.nodeAfter:r.position.parent;if(s&&e(s,r)){if(!n.reconvertedElements.has(s)){n.reconvertedElements.add(s);const a=le._createBefore(s);i.push({type:"remove",name:s.name,position:a,length:1},{type:"reinsert",name:s.name,position:a,length:1})}}else i.push(r)}n.changes=i}}function Fg(o){return(e,t,n={})=>{const i=["insert"];for(const r of o.attributes)e.hasAttribute(r)&&i.push(`attribute:${r}`);return!!i.every(r=>t.test(e,r))&&(n.preflight||i.forEach(r=>t.consume(e,r)),!0)}}function Vg(o,e,t,n){for(const i of e)gA(o.root,i,t,n)||t.convertItem(i)}function gA(o,e,t,n){const{writer:i,mapper:r}=t;if(!n.reconversion)return!1;const s=r.toViewElement(e);return!(!s||s.root==o)&&!!t.canReuseView(s)&&(i.move(i.createRangeOn(s),r.toViewPosition(le._createBefore(e))),!0)}function pA(o,e,{preflight:t}={}){return t?e.test(o,"insert"):e.consume(o,"insert")}function Hg(o){const{schema:e,document:t}=o.model;for(const n of t.getRootNames()){const i=t.getRoot(n);if(i.isEmpty&&!e.checkChild(i,"$text")&&e.checkChild(i,"paragraph"))return o.insertElement("paragraph",i),!0}return!1}function Ug(o,e,t){const n=t.createContext(o);return!!t.checkChild(n,"paragraph")&&!!t.checkChild(n.push("paragraph"),e)}function Wg(o,e){const t=e.createElement("paragraph");return e.insert(t,o),e.createPositionAt(t,0)}class mA extends Pg{elementToElement(e){return this.add(qg(e))}elementToAttribute(e){return this.add(function(t){t=ar(t),Gg(t);const n=$g(t,!1),i=Yd(t.view),r=i?`element:${i}`:"element";return s=>{s.on(r,n,{priority:t.converterPriority||"low"})}}(e))}attributeToAttribute(e){return this.add(function(t){t=ar(t);let n=null;(typeof t.view=="string"||t.view.key)&&(n=function(r){typeof r.view=="string"&&(r.view={key:r.view});const s=r.view.key;let a;return s=="class"||s=="style"?a={[s=="class"?"classes":"styles"]:r.view.value}:a={attributes:{[s]:r.view.value===void 0?/[\s\S]*/:r.view.value}},r.view.name&&(a.name=r.view.name),r.view=a,s}(t)),Gg(t,n);const i=$g(t,!0);return r=>{r.on("element",i,{priority:t.converterPriority||"low"})}}(e))}elementToMarker(e){return this.add(function(t){const n=function(i){return(r,s)=>{const a=typeof i=="string"?i:i(r,s);return s.writer.createElement("$marker",{"data-name":a})}}(t.model);return qg({...t,model:n})}(e))}dataToMarker(e){return this.add(function(t){t=ar(t),t.model||(t.model=s=>s?t.view+":"+s:t.view);const n={view:t.view,model:t.model},i=Kd(Yg(n,"start")),r=Kd(Yg(n,"end"));return s=>{s.on(`element:${t.view}-start`,i,{priority:t.converterPriority||"normal"}),s.on(`element:${t.view}-end`,r,{priority:t.converterPriority||"normal"});const a=Ae.get("low"),c=Ae.get("highest"),u=Ae.get(t.converterPriority)/c;s.on("element",function(f){return(m,v,E)=>{const I=`data-${f.view}`;function L(R,H){for(const $ of H){const te=f.model($,E),ue=E.writer.createElement("$marker",{"data-name":te});E.writer.insert(ue,R),v.modelCursor.isEqual(R)?v.modelCursor=v.modelCursor.getShiftedBy(1):v.modelCursor=v.modelCursor._getTransformedByInsertion(R,1),v.modelRange=v.modelRange._getTransformedByInsertion(R,1)[0]}}(E.consumable.test(v.viewItem,{attributes:I+"-end-after"})||E.consumable.test(v.viewItem,{attributes:I+"-start-after"})||E.consumable.test(v.viewItem,{attributes:I+"-end-before"})||E.consumable.test(v.viewItem,{attributes:I+"-start-before"}))&&(v.modelRange||Object.assign(v,E.convertChildren(v.viewItem,v.modelCursor)),E.consumable.consume(v.viewItem,{attributes:I+"-end-after"})&&L(v.modelRange.end,v.viewItem.getAttribute(I+"-end-after").split(",")),E.consumable.consume(v.viewItem,{attributes:I+"-start-after"})&&L(v.modelRange.end,v.viewItem.getAttribute(I+"-start-after").split(",")),E.consumable.consume(v.viewItem,{attributes:I+"-end-before"})&&L(v.modelRange.start,v.viewItem.getAttribute(I+"-end-before").split(",")),E.consumable.consume(v.viewItem,{attributes:I+"-start-before"})&&L(v.modelRange.start,v.viewItem.getAttribute(I+"-start-before").split(",")))}}(n),{priority:a+u})}}(e))}}function qg(o){const e=Kd(o=ar(o)),t=Yd(o.view),n=t?`element:${t}`:"element";return i=>{i.on(n,e,{priority:o.converterPriority||"normal"})}}function Yd(o){return typeof o=="string"?o:typeof o=="object"&&typeof o.name=="string"?o.name:null}function Kd(o){const e=new zi(o.view);return(t,n,i)=>{const r=e.match(n.viewItem);if(!r)return;const s=r.match;if(s.name=!0,!i.consumable.test(n.viewItem,s))return;const a=function(c,u,f){return c instanceof Function?c(u,f):f.writer.createElement(c)}(o.model,n.viewItem,i);a&&i.safeInsert(a,n.modelCursor)&&(i.consumable.consume(n.viewItem,s),i.convertChildren(n.viewItem,a),i.updateConversionResult(a,n))}}function Gg(o,e=null){const t=e===null||(r=>r.getAttribute(e)),n=typeof o.model!="object"?o.model:o.model.key,i=typeof o.model!="object"||o.model.value===void 0?t:o.model.value;o.model={key:n,value:i}}function $g(o,e){const t=new zi(o.view);return(n,i,r)=>{if(!i.modelRange&&e)return;const s=t.match(i.viewItem);if(!s||(function(f,m){const v=typeof f=="function"?f(m):f;return typeof v=="object"&&!Yd(v)?!1:!v.classes&&!v.attributes&&!v.styles}(o.view,i.viewItem)?s.match.name=!0:delete s.match.name,!r.consumable.test(i.viewItem,s.match)))return;const a=o.model.key,c=typeof o.model.value=="function"?o.model.value(i.viewItem,r):o.model.value;if(c===null)return;i.modelRange||Object.assign(i,r.convertChildren(i.viewItem,i.modelCursor)),function(f,m,v,E){let I=!1;for(const L of Array.from(f.getItems({shallow:v})))E.schema.checkAttribute(L,m.key)&&(I=!0,L.hasAttribute(m.key)||E.writer.setAttribute(m.key,m.value,L));return I}(i.modelRange,{key:a,value:c},e,r)&&(r.consumable.test(i.viewItem,{name:!0})&&(s.match.name=!0),r.consumable.consume(i.viewItem,s.match))}}function Yg(o,e){return{view:`${o.view}-${e}`,model:(t,n)=>{const i=t.getAttribute("name"),r=o.model(i,n);return n.writer.createElement("$marker",{"data-name":r})}}}class bA extends Ke(){constructor(e,t){super(),this.model=e,this.view=new oA(t),this.mapper=new Tg,this.downcastDispatcher=new Sg({mapper:this.mapper,schema:e.schema});const n=this.model.document,i=n.selection,r=this.model.markers;this.listenTo(this.model,"_beforeChanges",()=>{this.view._disableRendering(!0)},{priority:"highest"}),this.listenTo(this.model,"_afterChanges",()=>{this.view._disableRendering(!1)},{priority:"lowest"}),this.listenTo(n,"change",()=>{this.view.change(s=>{this.downcastDispatcher.convertChanges(n.differ,r,s),this.downcastDispatcher.convertSelection(i,r,s)})},{priority:"low"}),this.listenTo(this.view.document,"selectionChange",function(s,a){return(c,u)=>{const f=u.newSelection,m=[];for(const E of f.getRanges())m.push(a.toModelRange(E));const v=s.createSelection(m,{backward:f.isBackward});v.isEqual(s.document.selection)||s.change(E=>{E.setSelection(v)})}}(this.model,this.mapper)),this.downcastDispatcher.on("insert:$text",(s,a,c)=>{if(!c.consumable.consume(a.item,s.name))return;const u=c.writer,f=c.mapper.toViewPosition(a.range.start),m=u.createText(a.item.data);u.insert(f,m)},{priority:"lowest"}),this.downcastDispatcher.on("insert",(s,a,c)=>{c.convertAttributes(a.item),a.reconversion||!a.item.is("element")||a.item.isEmpty||c.convertChildren(a.item)},{priority:"lowest"}),this.downcastDispatcher.on("remove",(s,a,c)=>{const u=c.mapper.toViewPosition(a.position),f=a.position.getShiftedBy(a.length),m=c.mapper.toViewPosition(f,{isPhantom:!0}),v=c.writer.createRange(u,m),E=c.writer.remove(v.getTrimmed());for(const I of c.writer.createRangeIn(E).getItems())c.mapper.unbindViewElement(I,{defer:!0})},{priority:"low"}),this.downcastDispatcher.on("selection",(s,a,c)=>{const u=c.writer,f=u.document.selection;for(const m of f.getRanges())m.isCollapsed&&m.end.parent.isAttached()&&c.writer.mergeAttributes(m.start);u.setSelection(null)},{priority:"high"}),this.downcastDispatcher.on("selection",(s,a,c)=>{const u=a.selection;if(u.isCollapsed||!c.consumable.consume(u,"selection"))return;const f=[];for(const m of u.getRanges())f.push(c.mapper.toViewRange(m));c.writer.setSelection(f,{backward:u.isBackward})},{priority:"low"}),this.downcastDispatcher.on("selection",(s,a,c)=>{const u=a.selection;if(!u.isCollapsed||!c.consumable.consume(u,"selection"))return;const f=c.writer,m=u.getFirstPosition(),v=c.mapper.toViewPosition(m),E=f.breakAttributes(v);f.setSelection(E)},{priority:"low"}),this.view.document.roots.bindTo(this.model.document.roots).using(s=>{if(s.rootName=="$graveyard")return null;const a=new $f(this.view.document,s.name);return a.rootName=s.rootName,this.mapper.bindElements(s,a),a})}destroy(){this.view.destroy(),this.stopListening()}reconvertMarker(e){const t=typeof e=="string"?e:e.name,n=this.model.markers.get(t);if(!n)throw new V("editingcontroller-reconvertmarker-marker-not-exist",this,{markerName:t});this.model.change(()=>{this.model.markers._refresh(n)})}reconvertItem(e){this.model.change(()=>{this.model.document.differ._refreshItem(e)})}}class $s{constructor(){this._consumables=new Map}add(e,t){let n;e.is("$text")||e.is("documentFragment")?this._consumables.set(e,!0):(this._consumables.has(e)?n=this._consumables.get(e):(n=new kA(e),this._consumables.set(e,n)),n.add(t))}test(e,t){const n=this._consumables.get(e);return n===void 0?null:e.is("$text")||e.is("documentFragment")?n:n.test(t)}consume(e,t){return!!this.test(e,t)&&(e.is("$text")||e.is("documentFragment")?this._consumables.set(e,!1):this._consumables.get(e).consume(t),!0)}revert(e,t){const n=this._consumables.get(e);n!==void 0&&(e.is("$text")||e.is("documentFragment")?this._consumables.set(e,!0):n.revert(t))}static consumablesFromElement(e){const t={element:e,name:!0,attributes:[],classes:[],styles:[]},n=e.getAttributeKeys();for(const s of n)s!="style"&&s!="class"&&t.attributes.push(s);const i=e.getClassNames();for(const s of i)t.classes.push(s);const r=e.getStyleNames();for(const s of r)t.styles.push(s);return t}static createFrom(e,t){if(t||(t=new $s),e.is("$text"))return t.add(e),t;e.is("element")&&t.add(e,$s.consumablesFromElement(e)),e.is("documentFragment")&&t.add(e);for(const n of e.getChildren())t=$s.createFrom(n,t);return t}}const Sl=["attributes","classes","styles"];class kA{constructor(e){this.element=e,this._canConsumeName=null,this._consumables={attributes:new Map,styles:new Map,classes:new Map}}add(e){e.name&&(this._canConsumeName=!0);for(const t of Sl)t in e&&this._add(t,e[t])}test(e){if(e.name&&!this._canConsumeName)return this._canConsumeName;for(const t of Sl)if(t in e){const n=this._test(t,e[t]);if(n!==!0)return n}return!0}consume(e){e.name&&(this._canConsumeName=!1);for(const t of Sl)t in e&&this._consume(t,e[t])}revert(e){e.name&&(this._canConsumeName=!0);for(const t of Sl)t in e&&this._revert(t,e[t])}_add(e,t){const n=tn(t)?t:[t],i=this._consumables[e];for(const r of n){if(e==="attributes"&&(r==="class"||r==="style"))throw new V("viewconsumable-invalid-attribute",this);if(i.set(r,!0),e==="styles")for(const s of this.element.document.stylesProcessor.getRelatedStyles(r))i.set(s,!0)}}_test(e,t){const n=tn(t)?t:[t],i=this._consumables[e];for(const r of n)if(e!=="attributes"||r!=="class"&&r!=="style"){const s=i.get(r);if(s===void 0)return null;if(!s)return!1}else{const s=r=="class"?"classes":"styles",a=this._test(s,[...this._consumables[s].keys()]);if(a!==!0)return a}return!0}_consume(e,t){const n=tn(t)?t:[t],i=this._consumables[e];for(const r of n)if(e!=="attributes"||r!=="class"&&r!=="style"){if(i.set(r,!1),e=="styles")for(const s of this.element.document.stylesProcessor.getRelatedStyles(r))i.set(s,!1)}else{const s=r=="class"?"classes":"styles";this._consume(s,[...this._consumables[s].keys()])}}_revert(e,t){const n=tn(t)?t:[t],i=this._consumables[e];for(const r of n)if(e!=="attributes"||r!=="class"&&r!=="style")i.get(r)===!1&&i.set(r,!0);else{const s=r=="class"?"classes":"styles";this._revert(s,[...this._consumables[s].keys()])}}}class wA extends Ke(){constructor(){super(),this._sourceDefinitions={},this._attributeProperties={},this.decorate("checkChild"),this.decorate("checkAttribute"),this.on("checkAttribute",(e,t)=>{t[0]=new lr(t[0])},{priority:"highest"}),this.on("checkChild",(e,t)=>{t[0]=new lr(t[0]),t[1]=this.getDefinition(t[1])},{priority:"highest"})}register(e,t){if(this._sourceDefinitions[e])throw new V("schema-cannot-register-item-twice",this,{itemName:e});this._sourceDefinitions[e]=[Object.assign({},t)],this._clearCache()}extend(e,t){if(!this._sourceDefinitions[e])throw new V("schema-cannot-extend-missing-item",this,{itemName:e});this._sourceDefinitions[e].push(Object.assign({},t)),this._clearCache()}getDefinitions(){return this._compiledDefinitions||this._compile(),this._compiledDefinitions}getDefinition(e){let t;return t=typeof e=="string"?e:"is"in e&&(e.is("$text")||e.is("$textProxy"))?"$text":e.name,this.getDefinitions()[t]}isRegistered(e){return!!this.getDefinition(e)}isBlock(e){const t=this.getDefinition(e);return!(!t||!t.isBlock)}isLimit(e){const t=this.getDefinition(e);return!!t&&!(!t.isLimit&&!t.isObject)}isObject(e){const t=this.getDefinition(e);return!!t&&!!(t.isObject||t.isLimit&&t.isSelectable&&t.isContent)}isInline(e){const t=this.getDefinition(e);return!(!t||!t.isInline)}isSelectable(e){const t=this.getDefinition(e);return!!t&&!(!t.isSelectable&&!t.isObject)}isContent(e){const t=this.getDefinition(e);return!!t&&!(!t.isContent&&!t.isObject)}checkChild(e,t){return!!t&&this._checkContextMatch(t,e)}checkAttribute(e,t){const n=this.getDefinition(e.last);return!!n&&n.allowAttributes.includes(t)}checkMerge(e,t){if(e instanceof le){const n=e.nodeBefore,i=e.nodeAfter;if(!(n instanceof gt))throw new V("schema-check-merge-no-element-before",this);if(!(i instanceof gt))throw new V("schema-check-merge-no-element-after",this);return this.checkMerge(n,i)}for(const n of t.getChildren())if(!this.checkChild(e,n))return!1;return!0}addChildCheck(e){this.on("checkChild",(t,[n,i])=>{if(!i)return;const r=e(n,i);typeof r=="boolean"&&(t.stop(),t.return=r)},{priority:"high"})}addAttributeCheck(e){this.on("checkAttribute",(t,[n,i])=>{const r=e(n,i);typeof r=="boolean"&&(t.stop(),t.return=r)},{priority:"high"})}setAttributeProperties(e,t){this._attributeProperties[e]=Object.assign(this.getAttributeProperties(e),t)}getAttributeProperties(e){return this._attributeProperties[e]||{}}getLimitElement(e){let t;for(e instanceof le?t=e.parent:t=(e instanceof ne?[e]:Array.from(e.getRanges())).reduce((n,i)=>{const r=i.getCommonAncestor();return n?n.getCommonAncestor(r,{includeSelf:!0}):r},null);!this.isLimit(t)&&t.parent;)t=t.parent;return t}checkAttributeInSelection(e,t){if(e.isCollapsed){const n=[...e.getFirstPosition().getAncestors(),new kt("",e.getAttributes())];return this.checkAttribute(n,t)}{const n=e.getRanges();for(const i of n)for(const r of i)if(this.checkAttribute(r.item,t))return!0}return!1}*getValidRanges(e,t){e=function*(n){for(const i of n)yield*i.getMinimalFlatRanges()}(e);for(const n of e)yield*this._getValidRangesForRange(n,t)}getNearestSelectionRange(e,t="both"){if(this.checkChild(e,"$text"))return new ne(e);let n,i;const r=e.getAncestors().reverse().find(s=>this.isLimit(s))||e.root;t!="both"&&t!="backward"||(n=new Fi({boundaries:ne._createIn(r),startPosition:e,direction:"backward"})),t!="both"&&t!="forward"||(i=new Fi({boundaries:ne._createIn(r),startPosition:e}));for(const s of function*(a,c){let u=!1;for(;!u;){if(u=!0,a){const f=a.next();f.done||(u=!1,yield{walker:a,value:f.value})}if(c){const f=c.next();f.done||(u=!1,yield{walker:c,value:f.value})}}}(n,i)){const a=s.walker==n?"elementEnd":"elementStart",c=s.value;if(c.type==a&&this.isObject(c.item))return ne._createOn(c.item);if(this.checkChild(c.nextPosition,"$text"))return new ne(c.nextPosition)}return null}findAllowedParent(e,t){let n=e.parent;for(;n;){if(this.checkChild(n,t))return n;if(this.isLimit(n))return null;n=n.parent}return null}setAllowedAttributes(e,t,n){const i=n.model;for(const[r,s]of Object.entries(t))i.schema.checkAttribute(e,r)&&n.setAttribute(r,s,e)}removeDisallowedAttributes(e,t){for(const n of e)if(n.is("$text"))Kg(this,n,t);else{const i=ne._createIn(n).getPositions();for(const r of i)Kg(this,r.nodeBefore||r.parent,t)}}getAttributesWithProperty(e,t,n){const i={};for(const[r,s]of e.getAttributes()){const a=this.getAttributeProperties(r);a[t]!==void 0&&(n!==void 0&&n!==a[t]||(i[r]=s))}return i}createContext(e){return new lr(e)}_clearCache(){this._compiledDefinitions=null}_compile(){const e={},t=this._sourceDefinitions,n=Object.keys(t);for(const i of n)e[i]=vA(t[i],i);for(const i of n)_A(e,i);for(const i of n)CA(e,i);for(const i of n)AA(e,i);for(const i of n)yA(e,i),xA(e,i);for(const i of n)DA(e,i),EA(e,i),TA(e,i);this._compiledDefinitions=e}_checkContextMatch(e,t,n=t.length-1){const i=t.getItem(n);if(e.allowIn.includes(i.name)){if(n==0)return!0;{const r=this.getDefinition(i);return this._checkContextMatch(r,t,n-1)}}return!1}*_getValidRangesForRange(e,t){let n=e.start,i=e.start;for(const r of e.getItems({shallow:!0}))r.is("element")&&(yield*this._getValidRangesForRange(ne._createIn(r),t)),this.checkAttribute(r,t)||(n.isEqual(i)||(yield new ne(n,i)),n=le._createAfter(r)),i=le._createAfter(r);n.isEqual(i)||(yield new ne(n,i))}}class lr{constructor(e){if(e instanceof lr)return e;let t;t=typeof e=="string"?[e]:Array.isArray(e)?e:e.getAncestors({includeSelf:!0}),this._items=t.map(IA)}get length(){return this._items.length}get last(){return this._items[this._items.length-1]}[Symbol.iterator](){return this._items[Symbol.iterator]()}push(e){const t=new lr([e]);return t._items=[...this._items,...t._items],t}getItem(e){return this._items[e]}*getNames(){yield*this._items.map(e=>e.name)}endsWith(e){return Array.from(this.getNames()).join(" ").endsWith(e)}startsWith(e){return Array.from(this.getNames()).join(" ").startsWith(e)}}function vA(o,e){const t={name:e,allowIn:[],allowContentOf:[],allowWhere:[],allowAttributes:[],allowAttributesOf:[],allowChildren:[],inheritTypesFrom:[]};return function(n,i){for(const r of n){const s=Object.keys(r).filter(a=>a.startsWith("is"));for(const a of s)i[a]=!!r[a]}}(o,t),cr(o,t,"allowIn"),cr(o,t,"allowContentOf"),cr(o,t,"allowWhere"),cr(o,t,"allowAttributes"),cr(o,t,"allowAttributesOf"),cr(o,t,"allowChildren"),cr(o,t,"inheritTypesFrom"),function(n,i){for(const r of n){const s=r.inheritAllFrom;s&&(i.allowContentOf.push(s),i.allowWhere.push(s),i.allowAttributesOf.push(s),i.inheritTypesFrom.push(s))}}(o,t),t}function _A(o,e){const t=o[e];for(const n of t.allowChildren){const i=o[n];i&&i.allowIn.push(e)}t.allowChildren.length=0}function CA(o,e){for(const t of o[e].allowContentOf)o[t]&&SA(o,t).forEach(n=>{n.allowIn.push(e)});delete o[e].allowContentOf}function AA(o,e){for(const t of o[e].allowWhere){const n=o[t];if(n){const i=n.allowIn;o[e].allowIn.push(...i)}}delete o[e].allowWhere}function yA(o,e){for(const t of o[e].allowAttributesOf){const n=o[t];if(n){const i=n.allowAttributes;o[e].allowAttributes.push(...i)}}delete o[e].allowAttributesOf}function xA(o,e){const t=o[e];for(const n of t.inheritTypesFrom){const i=o[n];if(i){const r=Object.keys(i).filter(s=>s.startsWith("is"));for(const s of r)s in t||(t[s]=i[s])}}delete t.inheritTypesFrom}function DA(o,e){const t=o[e],n=t.allowIn.filter(i=>o[i]);t.allowIn=Array.from(new Set(n))}function EA(o,e){const t=o[e];for(const n of t.allowIn)o[n].allowChildren.push(e)}function TA(o,e){const t=o[e];t.allowAttributes=Array.from(new Set(t.allowAttributes))}function cr(o,e,t){for(const n of o){const i=n[t];typeof i=="string"?e[t].push(i):Array.isArray(i)&&e[t].push(...i)}}function SA(o,e){const t=o[e];return(n=o,Object.keys(n).map(i=>n[i])).filter(i=>i.allowIn.includes(t.name));var n}function IA(o){return typeof o=="string"||o.is("documentFragment")?{name:typeof o=="string"?o:"$documentFragment",*getAttributeKeys(){},getAttribute(){}}:{name:o.is("element")?o.name:"$text",*getAttributeKeys(){yield*o.getAttributeKeys()},getAttribute:e=>o.getAttribute(e)}}function Kg(o,e,t){for(const n of e.getAttributeKeys())o.checkAttribute(e,n)||t.removeAttribute(n,e)}class MA extends Ce(){constructor(e){super(),this._splitParts=new Map,this._cursorParents=new Map,this._modelCursor=null,this._emptyElementsToKeep=new Set,this.conversionApi={...e,consumable:null,writer:null,store:null,convertItem:(t,n)=>this._convertItem(t,n),convertChildren:(t,n)=>this._convertChildren(t,n),safeInsert:(t,n)=>this._safeInsert(t,n),updateConversionResult:(t,n)=>this._updateConversionResult(t,n),splitToAllowedParent:(t,n)=>this._splitToAllowedParent(t,n),getSplitParts:t=>this._getSplitParts(t),keepEmptyElement:t=>this._keepEmptyElement(t)}}convert(e,t,n=["$root"]){this.fire("viewCleanup",e),this._modelCursor=function(s,a){let c;for(const u of new lr(s)){const f={};for(const v of u.getAttributeKeys())f[v]=u.getAttribute(v);const m=a.createElement(u.name,f);c&&a.insert(m,c),c=le._createAt(m,0)}return c}(n,t),this.conversionApi.writer=t,this.conversionApi.consumable=$s.createFrom(e),this.conversionApi.store={};const{modelRange:i}=this._convertItem(e,this._modelCursor),r=t.createDocumentFragment();if(i){this._removeEmptyElements();for(const s of Array.from(this._modelCursor.parent.getChildren()))t.append(s,r);r.markers=function(s,a){const c=new Set,u=new Map,f=ne._createIn(s).getItems();for(const m of f)m.is("element","$marker")&&c.add(m);for(const m of c){const v=m.getAttribute("data-name"),E=a.createPositionBefore(m);u.has(v)?u.get(v).end=E.clone():u.set(v,new ne(E.clone())),a.remove(m)}return u}(r,t)}return this._modelCursor=null,this._splitParts.clear(),this._cursorParents.clear(),this._emptyElementsToKeep.clear(),this.conversionApi.writer=null,this.conversionApi.store=null,r}_convertItem(e,t){const n={viewItem:e,modelCursor:t,modelRange:null};if(e.is("element")?this.fire(`element:${e.name}`,n,this.conversionApi):e.is("$text")?this.fire("text",n,this.conversionApi):this.fire("documentFragment",n,this.conversionApi),n.modelRange&&!(n.modelRange instanceof ne))throw new V("view-conversion-dispatcher-incorrect-result",this);return{modelRange:n.modelRange,modelCursor:n.modelCursor}}_convertChildren(e,t){let n=t.is("position")?t:le._createAt(t,0);const i=new ne(n);for(const r of Array.from(e.getChildren())){const s=this._convertItem(r,n);s.modelRange instanceof ne&&(i.end=s.modelRange.end,n=s.modelCursor)}return{modelRange:i,modelCursor:n}}_safeInsert(e,t){const n=this._splitToAllowedParent(e,t);return!!n&&(this.conversionApi.writer.insert(e,n.position),!0)}_updateConversionResult(e,t){const n=this._getSplitParts(e),i=this.conversionApi.writer;t.modelRange||(t.modelRange=i.createRange(i.createPositionBefore(e),i.createPositionAfter(n[n.length-1])));const r=this._cursorParents.get(e);t.modelCursor=r?i.createPositionAt(r,0):t.modelRange.end}_splitToAllowedParent(e,t){const{schema:n,writer:i}=this.conversionApi;let r=n.findAllowedParent(t,e);if(r){if(r===t.parent)return{position:t};this._modelCursor.parent.getAncestors().includes(r)&&(r=null)}if(!r)return Ug(t,e,n)?{position:Wg(t,i)}:null;const s=this.conversionApi.writer.split(t,r),a=[];for(const u of s.range.getWalker())if(u.type=="elementEnd")a.push(u.item);else{const f=a.pop(),m=u.item;this._registerSplitPair(f,m)}const c=s.range.end.parent;return this._cursorParents.set(e,c),{position:s.position,cursorParent:c}}_registerSplitPair(e,t){this._splitParts.has(e)||this._splitParts.set(e,[e]);const n=this._splitParts.get(e);this._splitParts.set(t,n),n.push(t)}_getSplitParts(e){let t;return t=this._splitParts.has(e)?this._splitParts.get(e):[e],t}_keepEmptyElement(e){this._emptyElementsToKeep.add(e)}_removeEmptyElements(){let e=!1;for(const t of this._splitParts.keys())t.isEmpty&&!this._emptyElementsToKeep.has(t)&&(this.conversionApi.writer.remove(t),this._splitParts.delete(t),e=!0);e&&this._removeEmptyElements()}}class NA{getHtml(e){const t=document.implementation.createHTMLDocument("").createElement("div");return t.appendChild(e),t.innerHTML}}class PA{constructor(e){this.skipComments=!0,this.domParser=new DOMParser,this.domConverter=new yl(e,{renderingMode:"data"}),this.htmlWriter=new NA}toData(e){const t=this.domConverter.viewToDom(e);return this.htmlWriter.getHtml(t)}toView(e){const t=this._toDom(e);return this.domConverter.domToView(t,{skipComments:this.skipComments})}registerRawContentMatcher(e){this.domConverter.registerRawContentMatcher(e)}useFillerType(e){this.domConverter.blockFillerMode=e=="marked"?"markedNbsp":"nbsp"}_toDom(e){e.match(/<(?:html|body|head|meta)(?:\s[^>]*)?>/i)||(e=`<body>${e}</body>`);const t=this.domParser.parseFromString(e,"text/html"),n=t.createDocumentFragment(),i=t.body.childNodes;for(;i.length>0;)n.appendChild(i[0]);return n}}class BA extends Ce(){constructor(e,t){super(),this.model=e,this.mapper=new Tg,this.downcastDispatcher=new Sg({mapper:this.mapper,schema:e.schema}),this.downcastDispatcher.on("insert:$text",(n,i,r)=>{if(!r.consumable.consume(i.item,n.name))return;const s=r.writer,a=r.mapper.toViewPosition(i.range.start),c=s.createText(i.item.data);s.insert(a,c)},{priority:"lowest"}),this.downcastDispatcher.on("insert",(n,i,r)=>{r.convertAttributes(i.item),i.reconversion||!i.item.is("element")||i.item.isEmpty||r.convertChildren(i.item)},{priority:"lowest"}),this.upcastDispatcher=new MA({schema:e.schema}),this.viewDocument=new vl(t),this.stylesProcessor=t,this.htmlProcessor=new PA(this.viewDocument),this.processor=this.htmlProcessor,this._viewWriter=new Kf(this.viewDocument),this.upcastDispatcher.on("text",(n,i,{schema:r,consumable:s,writer:a})=>{let c=i.modelCursor;if(!s.test(i.viewItem))return;if(!r.checkChild(c,"$text")){if(!Ug(c,"$text",r)||i.viewItem.data.trim().length==0)return;const f=c.nodeBefore;c=Wg(c,a),f&&f.is("element","$marker")&&(a.move(a.createRangeOn(f),c),c=a.createPositionAfter(f))}s.consume(i.viewItem);const u=a.createText(i.viewItem.data);a.insert(u,c),i.modelRange=a.createRange(c,c.getShiftedBy(u.offsetSize)),i.modelCursor=i.modelRange.end},{priority:"lowest"}),this.upcastDispatcher.on("element",(n,i,r)=>{if(!i.modelRange&&r.consumable.consume(i.viewItem,{name:!0})){const{modelRange:s,modelCursor:a}=r.convertChildren(i.viewItem,i.modelCursor);i.modelRange=s,i.modelCursor=a}},{priority:"lowest"}),this.upcastDispatcher.on("documentFragment",(n,i,r)=>{if(!i.modelRange&&r.consumable.consume(i.viewItem,{name:!0})){const{modelRange:s,modelCursor:a}=r.convertChildren(i.viewItem,i.modelCursor);i.modelRange=s,i.modelCursor=a}},{priority:"lowest"}),Ke().prototype.decorate.call(this,"init"),Ke().prototype.decorate.call(this,"set"),Ke().prototype.decorate.call(this,"get"),Ke().prototype.decorate.call(this,"toView"),Ke().prototype.decorate.call(this,"toModel"),this.on("init",()=>{this.fire("ready")},{priority:"lowest"}),this.on("ready",()=>{this.model.enqueueChange({isUndoable:!1},Hg)},{priority:"lowest"})}get(e={}){const{rootName:t="main",trim:n="empty"}=e;if(!this._checkIfRootsExists([t]))throw new V("datacontroller-get-non-existent-root",this);const i=this.model.document.getRoot(t);return n!=="empty"||this.model.hasContent(i,{ignoreWhitespaces:!0})?this.stringify(i,e):""}stringify(e,t={}){const n=this.toView(e,t);return this.processor.toData(n)}toView(e,t={}){const n=this.viewDocument,i=this._viewWriter;this.mapper.clearBindings();const r=ne._createIn(e),s=new rr(n);this.mapper.bindElements(e,s);const a=e.is("documentFragment")?e.markers:function(c){const u=[],f=c.root.document;if(!f)return new Map;const m=ne._createIn(c);for(const v of f.model.markers){const E=v.getRange(),I=E.isCollapsed,L=E.start.isEqual(m.start)||E.end.isEqual(m.end);if(I&&L)u.push([v.name,E]);else{const R=m.getIntersection(E);R&&u.push([v.name,R])}}return u.sort(([v,E],[I,L])=>{if(E.end.compareWith(L.start)!=="after")return 1;if(E.start.compareWith(L.end)!=="before")return-1;switch(E.start.compareWith(L.start)){case"before":return 1;case"after":return-1;default:switch(E.end.compareWith(L.end)){case"before":return 1;case"after":return-1;default:return I.localeCompare(v)}}}),new Map(u)}(e);return this.downcastDispatcher.convert(r,a,i,t),s}init(e){if(this.model.document.version)throw new V("datacontroller-init-document-not-empty",this);let t={};if(typeof e=="string"?t.main=e:t=e,!this._checkIfRootsExists(Object.keys(t)))throw new V("datacontroller-init-non-existent-root",this);return this.model.enqueueChange({isUndoable:!1},n=>{for(const i of Object.keys(t)){const r=this.model.document.getRoot(i);n.insert(this.parse(t[i],r),r,0)}}),Promise.resolve()}set(e,t={}){let n={};if(typeof e=="string"?n.main=e:n=e,!this._checkIfRootsExists(Object.keys(n)))throw new V("datacontroller-set-non-existent-root",this);this.model.enqueueChange(t.batchType||{},i=>{i.setSelection(null),i.removeSelectionAttribute(this.model.document.selection.getAttributeKeys());for(const r of Object.keys(n)){const s=this.model.document.getRoot(r);i.remove(i.createRangeIn(s)),i.insert(this.parse(n[r],s),s,0)}})}parse(e,t="$root"){const n=this.processor.toView(e);return this.toModel(n,t)}toModel(e,t="$root"){return this.model.change(n=>this.upcastDispatcher.convert(e,n,t))}addStyleProcessorRules(e){e(this.stylesProcessor)}registerRawContentMatcher(e){this.processor&&this.processor!==this.htmlProcessor&&this.processor.registerRawContentMatcher(e),this.htmlProcessor.registerRawContentMatcher(e)}destroy(){this.stopListening()}_checkIfRootsExists(e){for(const t of e)if(!this.model.document.getRootNames().includes(t))return!1;return!0}}class LA{constructor(e,t){this._helpers=new Map,this._downcast=Kt(e),this._createConversionHelpers({name:"downcast",dispatchers:this._downcast,isDowncast:!0}),this._upcast=Kt(t),this._createConversionHelpers({name:"upcast",dispatchers:this._upcast,isDowncast:!1})}addAlias(e,t){const n=this._downcast.includes(t);if(!this._upcast.includes(t)&&!n)throw new V("conversion-add-alias-dispatcher-not-registered",this);this._createConversionHelpers({name:e,dispatchers:[t],isDowncast:n})}for(e){if(!this._helpers.has(e))throw new V("conversion-for-unknown-group",this);return this._helpers.get(e)}elementToElement(e){this.for("downcast").elementToElement(e);for(const{model:t,view:n}of Qd(e))this.for("upcast").elementToElement({model:t,view:n,converterPriority:e.converterPriority})}attributeToElement(e){this.for("downcast").attributeToElement(e);for(const{model:t,view:n}of Qd(e))this.for("upcast").elementToAttribute({view:n,model:t,converterPriority:e.converterPriority})}attributeToAttribute(e){this.for("downcast").attributeToAttribute(e);for(const{model:t,view:n}of Qd(e))this.for("upcast").attributeToAttribute({view:n,model:t})}_createConversionHelpers({name:e,dispatchers:t,isDowncast:n}){if(this._helpers.has(e))throw new V("conversion-group-exists",this);const i=n?new fA(t):new mA(t);this._helpers.set(e,i)}}function*Qd(o){if(o.model.values)for(const e of o.model.values){const t={key:o.model.key,value:e},n=o.view[e],i=o.upcastAlso?o.upcastAlso[e]:void 0;yield*Qg(t,n,i)}else yield*Qg(o.model,o.view,o.upcastAlso)}function*Qg(o,e,t){if(yield{model:o,view:e},t)for(const n of Kt(t))yield{model:o,view:n}}class li{constructor(e){this.baseVersion=e,this.isDocumentOperation=this.baseVersion!==null,this.batch=null}_validate(){}toJSON(){const e=Object.assign({},this);return e.__className=this.constructor.className,delete e.batch,delete e.isDocumentOperation,e}static get className(){return"Operation"}static fromJSON(e,t){return new this(e.baseVersion)}}function Zd(o,e){const t=Jg(e),n=t.reduce((s,a)=>s+a.offsetSize,0),i=o.parent;Qs(o);const r=o.index;return i._insertChild(r,t),Ks(i,r+t.length),Ks(i,r),new ne(o,o.getShiftedBy(n))}function Zg(o){if(!o.isFlat)throw new V("operation-utils-remove-range-not-flat",this);const e=o.start.parent;Qs(o.start),Qs(o.end);const t=e._removeChildren(o.start.index,o.end.index-o.start.index);return Ks(e,o.start.index),t}function Ys(o,e){if(!o.isFlat)throw new V("operation-utils-move-range-not-flat",this);const t=Zg(o);return Zd(e=e._getTransformedByDeletion(o.start,o.end.offset-o.start.offset),t)}function Jg(o){const e=[];(function t(n){if(typeof n=="string")e.push(new kt(n));else if(n instanceof wi)e.push(new kt(n.data,n.getAttributes()));else if(n instanceof Or)e.push(n);else if(bn(n))for(const i of n)t(i)})(o);for(let t=1;t<e.length;t++){const n=e[t],i=e[t-1];n instanceof kt&&i instanceof kt&&Xg(n,i)&&(e.splice(t-1,2,new kt(i.data+n.data,i.getAttributes())),t--)}return e}function Ks(o,e){const t=o.getChild(e-1),n=o.getChild(e);if(t&&n&&t.is("$text")&&n.is("$text")&&Xg(t,n)){const i=new kt(t.data+n.data,t.getAttributes());o._removeChildren(e-1,2),o._insertChild(e-1,i)}}function Qs(o){const e=o.textNode,t=o.parent;if(e){const n=o.offset-e.startOffset,i=e.index;t._removeChildren(i,1);const r=new kt(e.data.substr(0,n),e.getAttributes()),s=new kt(e.data.substr(n),e.getAttributes());t._insertChild(i,[r,s])}}function Xg(o,e){const t=o.getAttributes(),n=e.getAttributes();for(const i of t){if(i[1]!==e.getAttribute(i[0]))return!1;n.next()}return n.next().done}class at extends li{constructor(e,t,n,i){super(i),this.sourcePosition=e.clone(),this.sourcePosition.stickiness="toNext",this.howMany=t,this.targetPosition=n.clone(),this.targetPosition.stickiness="toNone"}get type(){return this.targetPosition.root.rootName=="$graveyard"?"remove":this.sourcePosition.root.rootName=="$graveyard"?"reinsert":"move"}clone(){return new at(this.sourcePosition,this.howMany,this.targetPosition,this.baseVersion)}getMovedRangeStart(){return this.targetPosition._getTransformedByDeletion(this.sourcePosition,this.howMany)}getReversed(){const e=this.sourcePosition._getTransformedByInsertion(this.targetPosition,this.howMany);return new at(this.getMovedRangeStart(),this.howMany,e,this.baseVersion+1)}_validate(){const e=this.sourcePosition.parent,t=this.targetPosition.parent,n=this.sourcePosition.offset,i=this.targetPosition.offset;if(n+this.howMany>e.maxOffset)throw new V("move-operation-nodes-do-not-exist",this);if(e===t&&n<i&&i<n+this.howMany)throw new V("move-operation-range-into-itself",this);if(this.sourcePosition.root==this.targetPosition.root&&Gt(this.sourcePosition.getParentPath(),this.targetPosition.getParentPath())=="prefix"){const r=this.sourcePosition.path.length-1;if(this.targetPosition.path[r]>=n&&this.targetPosition.path[r]<n+this.howMany)throw new V("move-operation-node-into-itself",this)}}_execute(){Ys(ne._createFromPositionAndShift(this.sourcePosition,this.howMany),this.targetPosition)}toJSON(){const e=super.toJSON();return e.sourcePosition=this.sourcePosition.toJSON(),e.targetPosition=this.targetPosition.toJSON(),e}static get className(){return"MoveOperation"}static fromJSON(e,t){const n=le.fromJSON(e.sourcePosition,t),i=le.fromJSON(e.targetPosition,t);return new this(n,e.howMany,i,e.baseVersion)}}class Qt extends li{constructor(e,t,n){super(n),this.position=e.clone(),this.position.stickiness="toNone",this.nodes=new Us(Jg(t)),this.shouldReceiveAttributes=!1}get type(){return"insert"}get howMany(){return this.nodes.maxOffset}clone(){const e=new Us([...this.nodes].map(n=>n._clone(!0))),t=new Qt(this.position,e,this.baseVersion);return t.shouldReceiveAttributes=this.shouldReceiveAttributes,t}getReversed(){const e=this.position.root.document.graveyard,t=new le(e,[0]);return new at(this.position,this.nodes.maxOffset,t,this.baseVersion+1)}_validate(){const e=this.position.parent;if(!e||e.maxOffset<this.position.offset)throw new V("insert-operation-position-invalid",this)}_execute(){const e=this.nodes;this.nodes=new Us([...e].map(t=>t._clone(!0))),Zd(this.position,e)}toJSON(){const e=super.toJSON();return e.position=this.position.toJSON(),e.nodes=this.nodes.toJSON(),e}static get className(){return"InsertOperation"}static fromJSON(e,t){const n=[];for(const r of e.nodes)r.name?n.push(gt.fromJSON(r)):n.push(kt.fromJSON(r));const i=new Qt(le.fromJSON(e.position,t),n,e.baseVersion);return i.shouldReceiveAttributes=e.shouldReceiveAttributes,i}}class Sn extends li{constructor(e,t,n,i,r,s){super(s),this.name=e,this.oldRange=t?t.clone():null,this.newRange=n?n.clone():null,this.affectsData=r,this._markers=i}get type(){return"marker"}clone(){return new Sn(this.name,this.oldRange,this.newRange,this._markers,this.affectsData,this.baseVersion)}getReversed(){return new Sn(this.name,this.newRange,this.oldRange,this._markers,this.affectsData,this.baseVersion+1)}_execute(){this.newRange?this._markers._set(this.name,this.newRange,!0,this.affectsData):this._markers._remove(this.name)}toJSON(){const e=super.toJSON();return this.oldRange&&(e.oldRange=this.oldRange.toJSON()),this.newRange&&(e.newRange=this.newRange.toJSON()),delete e._markers,e}static get className(){return"MarkerOperation"}static fromJSON(e,t){return new Sn(e.name,e.oldRange?ne.fromJSON(e.oldRange,t):null,e.newRange?ne.fromJSON(e.newRange,t):null,t.model.markers,e.affectsData,e.baseVersion)}}const ep=function(o,e){return _g(o,e)};class jt extends li{constructor(e,t,n,i,r){super(r),this.range=e.clone(),this.key=t,this.oldValue=n===void 0?null:n,this.newValue=i===void 0?null:i}get type(){return this.oldValue===null?"addAttribute":this.newValue===null?"removeAttribute":"changeAttribute"}clone(){return new jt(this.range,this.key,this.oldValue,this.newValue,this.baseVersion)}getReversed(){return new jt(this.range,this.key,this.newValue,this.oldValue,this.baseVersion+1)}toJSON(){const e=super.toJSON();return e.range=this.range.toJSON(),e}_validate(){if(!this.range.isFlat)throw new V("attribute-operation-range-not-flat",this);for(const e of this.range.getItems({shallow:!0})){if(this.oldValue!==null&&!ep(e.getAttribute(this.key),this.oldValue))throw new V("attribute-operation-wrong-old-value",this,{item:e,key:this.key,value:this.oldValue});if(this.oldValue===null&&this.newValue!==null&&e.hasAttribute(this.key))throw new V("attribute-operation-attribute-exists",this,{node:e,key:this.key})}}_execute(){ep(this.oldValue,this.newValue)||function(e,t,n){Qs(e.start),Qs(e.end);for(const i of e.getItems({shallow:!0})){const r=i.is("$textProxy")?i.textNode:i;n!==null?r._setAttribute(t,n):r._removeAttribute(t),Ks(r.parent,r.index)}Ks(e.end.parent,e.end.index)}(this.range,this.key,this.newValue)}static get className(){return"AttributeOperation"}static fromJSON(e,t){return new jt(ne.fromJSON(e.range,t),e.key,e.oldValue,e.newValue,e.baseVersion)}}class Zt extends li{get type(){return"noop"}clone(){return new Zt(this.baseVersion)}getReversed(){return new Zt(this.baseVersion+1)}_execute(){}static get className(){return"NoOperation"}}class In extends li{constructor(e,t,n,i){super(i),this.position=e,this.position.stickiness="toNext",this.oldName=t,this.newName=n}get type(){return"rename"}clone(){return new In(this.position.clone(),this.oldName,this.newName,this.baseVersion)}getReversed(){return new In(this.position.clone(),this.newName,this.oldName,this.baseVersion+1)}_validate(){const e=this.position.nodeAfter;if(!(e instanceof gt))throw new V("rename-operation-wrong-position",this);if(e.name!==this.oldName)throw new V("rename-operation-wrong-name",this)}_execute(){this.position.nodeAfter.name=this.newName}toJSON(){const e=super.toJSON();return e.position=this.position.toJSON(),e}static get className(){return"RenameOperation"}static fromJSON(e,t){return new In(le.fromJSON(e.position,t),e.oldName,e.newName,e.baseVersion)}}class ao extends li{constructor(e,t,n,i,r){super(r),this.root=e,this.key=t,this.oldValue=n,this.newValue=i}get type(){return this.oldValue===null?"addRootAttribute":this.newValue===null?"removeRootAttribute":"changeRootAttribute"}clone(){return new ao(this.root,this.key,this.oldValue,this.newValue,this.baseVersion)}getReversed(){return new ao(this.root,this.key,this.newValue,this.oldValue,this.baseVersion+1)}_validate(){if(this.root!=this.root.root||this.root.is("documentFragment"))throw new V("rootattribute-operation-not-a-root",this,{root:this.root,key:this.key});if(this.oldValue!==null&&this.root.getAttribute(this.key)!==this.oldValue)throw new V("rootattribute-operation-wrong-old-value",this,{root:this.root,key:this.key});if(this.oldValue===null&&this.newValue!==null&&this.root.hasAttribute(this.key))throw new V("rootattribute-operation-attribute-exists",this,{root:this.root,key:this.key})}_execute(){this.newValue!==null?this.root._setAttribute(this.key,this.newValue):this.root._removeAttribute(this.key)}toJSON(){const e=super.toJSON();return e.root=this.root.toJSON(),e}static get className(){return"RootAttributeOperation"}static fromJSON(e,t){if(!t.getRoot(e.root))throw new V("rootattribute-operation-fromjson-no-root",this,{rootName:e.root});return new ao(t.getRoot(e.root),e.key,e.oldValue,e.newValue,e.baseVersion)}}class Lt extends li{constructor(e,t,n,i,r){super(r),this.sourcePosition=e.clone(),this.sourcePosition.stickiness="toPrevious",this.howMany=t,this.targetPosition=n.clone(),this.targetPosition.stickiness="toNext",this.graveyardPosition=i.clone()}get type(){return"merge"}get deletionPosition(){return new le(this.sourcePosition.root,this.sourcePosition.path.slice(0,-1))}get movedRange(){const e=this.sourcePosition.getShiftedBy(Number.POSITIVE_INFINITY);return new ne(this.sourcePosition,e)}clone(){return new Lt(this.sourcePosition,this.howMany,this.targetPosition,this.graveyardPosition,this.baseVersion)}getReversed(){const e=this.targetPosition._getTransformedByMergeOperation(this),t=this.sourcePosition.path.slice(0,-1),n=new le(this.sourcePosition.root,t)._getTransformedByMergeOperation(this);return new wt(e,this.howMany,n,this.graveyardPosition,this.baseVersion+1)}_validate(){const e=this.sourcePosition.parent,t=this.targetPosition.parent;if(!e.parent)throw new V("merge-operation-source-position-invalid",this);if(!t.parent)throw new V("merge-operation-target-position-invalid",this);if(this.howMany!=e.maxOffset)throw new V("merge-operation-how-many-invalid",this)}_execute(){const e=this.sourcePosition.parent;Ys(ne._createIn(e),this.targetPosition),Ys(ne._createOn(e),this.graveyardPosition)}toJSON(){const e=super.toJSON();return e.sourcePosition=e.sourcePosition.toJSON(),e.targetPosition=e.targetPosition.toJSON(),e.graveyardPosition=e.graveyardPosition.toJSON(),e}static get className(){return"MergeOperation"}static fromJSON(e,t){const n=le.fromJSON(e.sourcePosition,t),i=le.fromJSON(e.targetPosition,t),r=le.fromJSON(e.graveyardPosition,t);return new this(n,e.howMany,i,r,e.baseVersion)}}class wt extends li{constructor(e,t,n,i,r){super(r),this.splitPosition=e.clone(),this.splitPosition.stickiness="toNext",this.howMany=t,this.insertionPosition=n,this.graveyardPosition=i?i.clone():null,this.graveyardPosition&&(this.graveyardPosition.stickiness="toNext")}get type(){return"split"}get moveTargetPosition(){const e=this.insertionPosition.path.slice();return e.push(0),new le(this.insertionPosition.root,e)}get movedRange(){const e=this.splitPosition.getShiftedBy(Number.POSITIVE_INFINITY);return new ne(this.splitPosition,e)}clone(){return new wt(this.splitPosition,this.howMany,this.insertionPosition,this.graveyardPosition,this.baseVersion)}getReversed(){const e=this.splitPosition.root.document.graveyard,t=new le(e,[0]);return new Lt(this.moveTargetPosition,this.howMany,this.splitPosition,t,this.baseVersion+1)}_validate(){const e=this.splitPosition.parent,t=this.splitPosition.offset;if(!e||e.maxOffset<t)throw new V("split-operation-position-invalid",this);if(!e.parent)throw new V("split-operation-split-in-root",this);if(this.howMany!=e.maxOffset-this.splitPosition.offset)throw new V("split-operation-how-many-invalid",this);if(this.graveyardPosition&&!this.graveyardPosition.nodeAfter)throw new V("split-operation-graveyard-position-invalid",this)}_execute(){const e=this.splitPosition.parent;if(this.graveyardPosition)Ys(ne._createFromPositionAndShift(this.graveyardPosition,1),this.insertionPosition);else{const t=e._clone();Zd(this.insertionPosition,t)}Ys(new ne(le._createAt(e,this.splitPosition.offset),le._createAt(e,e.maxOffset)),this.moveTargetPosition)}toJSON(){const e=super.toJSON();return e.splitPosition=this.splitPosition.toJSON(),e.insertionPosition=this.insertionPosition.toJSON(),this.graveyardPosition&&(e.graveyardPosition=this.graveyardPosition.toJSON()),e}static get className(){return"SplitOperation"}static getInsertionPosition(e){const t=e.path.slice(0,-1);return t[t.length-1]++,new le(e.root,t,"toPrevious")}static fromJSON(e,t){const n=le.fromJSON(e.splitPosition,t),i=le.fromJSON(e.insertionPosition,t),r=e.graveyardPosition?le.fromJSON(e.graveyardPosition,t):null;return new this(n,e.howMany,i,r,e.baseVersion)}}const _i={};_i[jt.className]=jt,_i[Qt.className]=Qt,_i[Sn.className]=Sn,_i[at.className]=at,_i[Zt.className]=Zt,_i[li.className]=li,_i[In.className]=In,_i[ao.className]=ao,_i[wt.className]=wt,_i[Lt.className]=Lt;class zA{static fromJSON(e,t){return _i[e.__className].fromJSON(e,t)}}const Jd=new Map;function rt(o,e,t){let n=Jd.get(o);n||(n=new Map,Jd.set(o,n)),n.set(e,t)}function OA(o){return[o]}function tp(o,e,t={}){const n=function(i,r){const s=Jd.get(i);return s&&s.has(r)?s.get(r):OA}(o.constructor,e.constructor);try{return n(o=o.clone(),e,t)}catch(i){throw i}}function RA(o,e,t){o=o.slice(),e=e.slice();const n=new jA(t.document,t.useRelations,t.forceWeakRemove);n.setOriginalOperations(o),n.setOriginalOperations(e);const i=n.originalOperations;if(o.length==0||e.length==0)return{operationsA:o,operationsB:e,originalOperations:i};const r=new WeakMap;for(const c of o)r.set(c,0);const s={nextBaseVersionA:o[o.length-1].baseVersion+1,nextBaseVersionB:e[e.length-1].baseVersion+1,originalOperationsACount:o.length,originalOperationsBCount:e.length};let a=0;for(;a<o.length;){const c=o[a],u=r.get(c);if(u==e.length){a++;continue}const f=e[u],m=tp(c,f,n.getContext(c,f,!0)),v=tp(f,c,n.getContext(f,c,!1));n.updateRelation(c,f),n.setOriginalOperations(m,c),n.setOriginalOperations(v,f);for(const E of m)r.set(E,u+v.length);o.splice(a,1,...m),e.splice(u,1,...v)}if(t.padWithNoOps){const c=o.length-s.originalOperationsACount,u=e.length-s.originalOperationsBCount;ip(o,u-c),ip(e,c-u)}return np(o,s.nextBaseVersionB),np(e,s.nextBaseVersionA),{operationsA:o,operationsB:e,originalOperations:i}}class jA{constructor(e,t,n=!1){this.originalOperations=new Map,this._history=e.history,this._useRelations=t,this._forceWeakRemove=!!n,this._relations=new Map}setOriginalOperations(e,t=null){const n=t?this.originalOperations.get(t):null;for(const i of e)this.originalOperations.set(i,n||i)}updateRelation(e,t){if(e instanceof at)t instanceof Lt?e.targetPosition.isEqual(t.sourcePosition)||t.movedRange.containsPosition(e.targetPosition)?this._setRelation(e,t,"insertAtSource"):e.targetPosition.isEqual(t.deletionPosition)?this._setRelation(e,t,"insertBetween"):e.targetPosition.isAfter(t.sourcePosition)&&this._setRelation(e,t,"moveTargetAfter"):t instanceof at&&(e.targetPosition.isEqual(t.sourcePosition)||e.targetPosition.isBefore(t.sourcePosition)?this._setRelation(e,t,"insertBefore"):this._setRelation(e,t,"insertAfter"));else if(e instanceof wt){if(t instanceof Lt)e.splitPosition.isBefore(t.sourcePosition)&&this._setRelation(e,t,"splitBefore");else if(t instanceof at)if(e.splitPosition.isEqual(t.sourcePosition)||e.splitPosition.isBefore(t.sourcePosition))this._setRelation(e,t,"splitBefore");else{const n=ne._createFromPositionAndShift(t.sourcePosition,t.howMany);if(e.splitPosition.hasSameParentAs(t.sourcePosition)&&n.containsPosition(e.splitPosition)){const i=n.end.offset-e.splitPosition.offset,r=e.splitPosition.offset-n.start.offset;this._setRelation(e,t,{howMany:i,offset:r})}}}else if(e instanceof Lt)t instanceof Lt?(e.targetPosition.isEqual(t.sourcePosition)||this._setRelation(e,t,"mergeTargetNotMoved"),e.sourcePosition.isEqual(t.targetPosition)&&this._setRelation(e,t,"mergeSourceNotMoved"),e.sourcePosition.isEqual(t.sourcePosition)&&this._setRelation(e,t,"mergeSameElement")):t instanceof wt&&e.sourcePosition.isEqual(t.splitPosition)&&this._setRelation(e,t,"splitAtSource");else if(e instanceof Sn){const n=e.newRange;if(!n)return;if(t instanceof at){const i=ne._createFromPositionAndShift(t.sourcePosition,t.howMany),r=i.containsPosition(n.start)||i.start.isEqual(n.start),s=i.containsPosition(n.end)||i.end.isEqual(n.end);!r&&!s||i.containsRange(n)||this._setRelation(e,t,{side:r?"left":"right",path:r?n.start.path.slice():n.end.path.slice()})}else if(t instanceof Lt){const i=n.start.isEqual(t.targetPosition),r=n.start.isEqual(t.deletionPosition),s=n.end.isEqual(t.deletionPosition),a=n.end.isEqual(t.sourcePosition);(i||r||s||a)&&this._setRelation(e,t,{wasInLeftElement:i,wasStartBeforeMergedElement:r,wasEndBeforeMergedElement:s,wasInRightElement:a})}}}getContext(e,t,n){return{aIsStrong:n,aWasUndone:this._wasUndone(e),bWasUndone:this._wasUndone(t),abRelation:this._useRelations?this._getRelation(e,t):null,baRelation:this._useRelations?this._getRelation(t,e):null,forceWeakRemove:this._forceWeakRemove}}_wasUndone(e){const t=this.originalOperations.get(e);return t.wasUndone||this._history.isUndoneOperation(t)}_getRelation(e,t){const n=this.originalOperations.get(t),i=this._history.getUndoneOperation(n);if(!i)return null;const r=this.originalOperations.get(e),s=this._relations.get(r);return s&&s.get(i)||null}_setRelation(e,t,n){const i=this.originalOperations.get(e),r=this.originalOperations.get(t);let s=this._relations.get(i);s||(s=new Map,this._relations.set(i,s)),s.set(r,n)}}function np(o,e){for(const t of o)t.baseVersion=e++}function ip(o,e){for(let t=0;t<e;t++)o.push(new Zt(0))}function op(o,e,t){const n=o.nodes.getNode(0).getAttribute(e);if(n==t)return null;const i=new ne(o.position,o.position.getShiftedBy(o.howMany));return new jt(i,e,n,t,0)}function rp(o,e){return o.targetPosition._getTransformedByDeletion(e.sourcePosition,e.howMany)===null}function Rr(o,e){const t=[];for(let n=0;n<o.length;n++){const i=o[n],r=new at(i.start,i.end.offset-i.start.offset,e,0);t.push(r);for(let s=n+1;s<o.length;s++)o[s]=o[s]._getTransformedByMove(r.sourcePosition,r.targetPosition,r.howMany)[0];e=e._getTransformedByMove(r.sourcePosition,r.targetPosition,r.howMany)}return t}rt(jt,jt,(o,e,t)=>{if(o.key===e.key&&o.range.start.hasSameParentAs(e.range.start)){const n=o.range.getDifference(e.range).map(r=>new jt(r,o.key,o.oldValue,o.newValue,0)),i=o.range.getIntersection(e.range);return i&&t.aIsStrong&&n.push(new jt(i,e.key,e.newValue,o.newValue,0)),n.length==0?[new Zt(0)]:n}return[o]}),rt(jt,Qt,(o,e)=>{if(o.range.start.hasSameParentAs(e.position)&&o.range.containsPosition(e.position)){const t=o.range._getTransformedByInsertion(e.position,e.howMany,!e.shouldReceiveAttributes).map(n=>new jt(n,o.key,o.oldValue,o.newValue,o.baseVersion));if(e.shouldReceiveAttributes){const n=op(e,o.key,o.oldValue);n&&t.unshift(n)}return t}return o.range=o.range._getTransformedByInsertion(e.position,e.howMany,!1)[0],[o]}),rt(jt,Lt,(o,e)=>{const t=[];o.range.start.hasSameParentAs(e.deletionPosition)&&(o.range.containsPosition(e.deletionPosition)||o.range.start.isEqual(e.deletionPosition))&&t.push(ne._createFromPositionAndShift(e.graveyardPosition,1));const n=o.range._getTransformedByMergeOperation(e);return n.isCollapsed||t.push(n),t.map(i=>new jt(i,o.key,o.oldValue,o.newValue,o.baseVersion))}),rt(jt,at,(o,e)=>function(n,i){const r=ne._createFromPositionAndShift(i.sourcePosition,i.howMany);let s=null,a=[];r.containsRange(n,!0)?s=n:n.start.hasSameParentAs(r.start)?(a=n.getDifference(r),s=n.getIntersection(r)):a=[n];const c=[];for(let u of a){u=u._getTransformedByDeletion(i.sourcePosition,i.howMany);const f=i.getMovedRangeStart(),m=u.start.hasSameParentAs(f),v=u._getTransformedByInsertion(f,i.howMany,m);c.push(...v)}return s&&c.push(s._getTransformedByMove(i.sourcePosition,i.targetPosition,i.howMany,!1)[0]),c}(o.range,e).map(n=>new jt(n,o.key,o.oldValue,o.newValue,o.baseVersion))),rt(jt,wt,(o,e)=>{if(o.range.end.isEqual(e.insertionPosition))return e.graveyardPosition||o.range.end.offset++,[o];if(o.range.start.hasSameParentAs(e.splitPosition)&&o.range.containsPosition(e.splitPosition)){const t=o.clone();return t.range=new ne(e.moveTargetPosition.clone(),o.range.end._getCombined(e.splitPosition,e.moveTargetPosition)),o.range.end=e.splitPosition.clone(),o.range.end.stickiness="toPrevious",[o,t]}return o.range=o.range._getTransformedBySplitOperation(e),[o]}),rt(Qt,jt,(o,e)=>{const t=[o];if(o.shouldReceiveAttributes&&o.position.hasSameParentAs(e.range.start)&&e.range.containsPosition(o.position)){const n=op(o,e.key,e.newValue);n&&t.push(n)}return t}),rt(Qt,Qt,(o,e,t)=>(o.position.isEqual(e.position)&&t.aIsStrong||(o.position=o.position._getTransformedByInsertOperation(e)),[o])),rt(Qt,at,(o,e)=>(o.position=o.position._getTransformedByMoveOperation(e),[o])),rt(Qt,wt,(o,e)=>(o.position=o.position._getTransformedBySplitOperation(e),[o])),rt(Qt,Lt,(o,e)=>(o.position=o.position._getTransformedByMergeOperation(e),[o])),rt(Sn,Qt,(o,e)=>(o.oldRange&&(o.oldRange=o.oldRange._getTransformedByInsertOperation(e)[0]),o.newRange&&(o.newRange=o.newRange._getTransformedByInsertOperation(e)[0]),[o])),rt(Sn,Sn,(o,e,t)=>{if(o.name==e.name){if(!t.aIsStrong)return[new Zt(0)];o.oldRange=e.newRange?e.newRange.clone():null}return[o]}),rt(Sn,Lt,(o,e)=>(o.oldRange&&(o.oldRange=o.oldRange._getTransformedByMergeOperation(e)),o.newRange&&(o.newRange=o.newRange._getTransformedByMergeOperation(e)),[o])),rt(Sn,at,(o,e,t)=>{if(o.oldRange&&(o.oldRange=ne._createFromRanges(o.oldRange._getTransformedByMoveOperation(e))),o.newRange){if(t.abRelation){const n=ne._createFromRanges(o.newRange._getTransformedByMoveOperation(e));if(t.abRelation.side=="left"&&e.targetPosition.isEqual(o.newRange.start))return o.newRange.end=n.end,o.newRange.start.path=t.abRelation.path,[o];if(t.abRelation.side=="right"&&e.targetPosition.isEqual(o.newRange.end))return o.newRange.start=n.start,o.newRange.end.path=t.abRelation.path,[o]}o.newRange=ne._createFromRanges(o.newRange._getTransformedByMoveOperation(e))}return[o]}),rt(Sn,wt,(o,e,t)=>{if(o.oldRange&&(o.oldRange=o.oldRange._getTransformedBySplitOperation(e)),o.newRange){if(t.abRelation){const n=o.newRange._getTransformedBySplitOperation(e);return o.newRange.start.isEqual(e.splitPosition)&&t.abRelation.wasStartBeforeMergedElement?o.newRange.start=le._createAt(e.insertionPosition):o.newRange.start.isEqual(e.splitPosition)&&!t.abRelation.wasInLeftElement&&(o.newRange.start=le._createAt(e.moveTargetPosition)),o.newRange.end.isEqual(e.splitPosition)&&t.abRelation.wasInRightElement?o.newRange.end=le._createAt(e.moveTargetPosition):o.newRange.end.isEqual(e.splitPosition)&&t.abRelation.wasEndBeforeMergedElement?o.newRange.end=le._createAt(e.insertionPosition):o.newRange.end=n.end,[o]}o.newRange=o.newRange._getTransformedBySplitOperation(e)}return[o]}),rt(Lt,Qt,(o,e)=>(o.sourcePosition.hasSameParentAs(e.position)&&(o.howMany+=e.howMany),o.sourcePosition=o.sourcePosition._getTransformedByInsertOperation(e),o.targetPosition=o.targetPosition._getTransformedByInsertOperation(e),[o])),rt(Lt,Lt,(o,e,t)=>{if(o.sourcePosition.isEqual(e.sourcePosition)&&o.targetPosition.isEqual(e.targetPosition)){if(t.bWasUndone){const n=e.graveyardPosition.path.slice();return n.push(0),o.sourcePosition=new le(e.graveyardPosition.root,n),o.howMany=0,[o]}return[new Zt(0)]}if(o.sourcePosition.isEqual(e.sourcePosition)&&!o.targetPosition.isEqual(e.targetPosition)&&!t.bWasUndone&&t.abRelation!="splitAtSource"){const n=o.targetPosition.root.rootName=="$graveyard",i=e.targetPosition.root.rootName=="$graveyard";if(i&&!n||!(n&&!i)&&t.aIsStrong){const r=e.targetPosition._getTransformedByMergeOperation(e),s=o.targetPosition._getTransformedByMergeOperation(e);return[new at(r,o.howMany,s,0)]}return[new Zt(0)]}return o.sourcePosition.hasSameParentAs(e.targetPosition)&&(o.howMany+=e.howMany),o.sourcePosition=o.sourcePosition._getTransformedByMergeOperation(e),o.targetPosition=o.targetPosition._getTransformedByMergeOperation(e),o.graveyardPosition.isEqual(e.graveyardPosition)&&t.aIsStrong||(o.graveyardPosition=o.graveyardPosition._getTransformedByMergeOperation(e)),[o]}),rt(Lt,at,(o,e,t)=>{const n=ne._createFromPositionAndShift(e.sourcePosition,e.howMany);return e.type=="remove"&&!t.bWasUndone&&!t.forceWeakRemove&&o.deletionPosition.hasSameParentAs(e.sourcePosition)&&n.containsPosition(o.sourcePosition)?[new Zt(0)]:(o.sourcePosition.hasSameParentAs(e.targetPosition)&&(o.howMany+=e.howMany),o.sourcePosition.hasSameParentAs(e.sourcePosition)&&(o.howMany-=e.howMany),o.sourcePosition=o.sourcePosition._getTransformedByMoveOperation(e),o.targetPosition=o.targetPosition._getTransformedByMoveOperation(e),o.graveyardPosition.isEqual(e.targetPosition)||(o.graveyardPosition=o.graveyardPosition._getTransformedByMoveOperation(e)),[o])}),rt(Lt,wt,(o,e,t)=>{if(e.graveyardPosition&&(o.graveyardPosition=o.graveyardPosition._getTransformedByDeletion(e.graveyardPosition,1),o.deletionPosition.isEqual(e.graveyardPosition)&&(o.howMany=e.howMany)),o.targetPosition.isEqual(e.splitPosition)){const n=e.howMany!=0,i=e.graveyardPosition&&o.deletionPosition.isEqual(e.graveyardPosition);if(n||i||t.abRelation=="mergeTargetNotMoved")return o.sourcePosition=o.sourcePosition._getTransformedBySplitOperation(e),[o]}if(o.sourcePosition.isEqual(e.splitPosition)){if(t.abRelation=="mergeSourceNotMoved")return o.howMany=0,o.targetPosition=o.targetPosition._getTransformedBySplitOperation(e),[o];if(t.abRelation=="mergeSameElement"||o.sourcePosition.offset>0)return o.sourcePosition=e.moveTargetPosition.clone(),o.targetPosition=o.targetPosition._getTransformedBySplitOperation(e),[o]}return o.sourcePosition.hasSameParentAs(e.splitPosition)&&(o.howMany=e.splitPosition.offset),o.sourcePosition=o.sourcePosition._getTransformedBySplitOperation(e),o.targetPosition=o.targetPosition._getTransformedBySplitOperation(e),[o]}),rt(at,Qt,(o,e)=>{const t=ne._createFromPositionAndShift(o.sourcePosition,o.howMany)._getTransformedByInsertOperation(e,!1)[0];return o.sourcePosition=t.start,o.howMany=t.end.offset-t.start.offset,o.targetPosition.isEqual(e.position)||(o.targetPosition=o.targetPosition._getTransformedByInsertOperation(e)),[o]}),rt(at,at,(o,e,t)=>{const n=ne._createFromPositionAndShift(o.sourcePosition,o.howMany),i=ne._createFromPositionAndShift(e.sourcePosition,e.howMany);let r,s=t.aIsStrong,a=!t.aIsStrong;if(t.abRelation=="insertBefore"||t.baRelation=="insertAfter"?a=!0:t.abRelation!="insertAfter"&&t.baRelation!="insertBefore"||(a=!1),r=o.targetPosition.isEqual(e.targetPosition)&&a?o.targetPosition._getTransformedByDeletion(e.sourcePosition,e.howMany):o.targetPosition._getTransformedByMove(e.sourcePosition,e.targetPosition,e.howMany),rp(o,e)&&rp(e,o))return[e.getReversed()];if(n.containsPosition(e.targetPosition)&&n.containsRange(i,!0))return n.start=n.start._getTransformedByMove(e.sourcePosition,e.targetPosition,e.howMany),n.end=n.end._getTransformedByMove(e.sourcePosition,e.targetPosition,e.howMany),Rr([n],r);if(i.containsPosition(o.targetPosition)&&i.containsRange(n,!0))return n.start=n.start._getCombined(e.sourcePosition,e.getMovedRangeStart()),n.end=n.end._getCombined(e.sourcePosition,e.getMovedRangeStart()),Rr([n],r);const c=Gt(o.sourcePosition.getParentPath(),e.sourcePosition.getParentPath());if(c=="prefix"||c=="extension")return n.start=n.start._getTransformedByMove(e.sourcePosition,e.targetPosition,e.howMany),n.end=n.end._getTransformedByMove(e.sourcePosition,e.targetPosition,e.howMany),Rr([n],r);o.type!="remove"||e.type=="remove"||t.aWasUndone||t.forceWeakRemove?o.type=="remove"||e.type!="remove"||t.bWasUndone||t.forceWeakRemove||(s=!1):s=!0;const u=[],f=n.getDifference(i);for(const v of f){v.start=v.start._getTransformedByDeletion(e.sourcePosition,e.howMany),v.end=v.end._getTransformedByDeletion(e.sourcePosition,e.howMany);const E=Gt(v.start.getParentPath(),e.getMovedRangeStart().getParentPath())=="same",I=v._getTransformedByInsertion(e.getMovedRangeStart(),e.howMany,E);u.push(...I)}const m=n.getIntersection(i);return m!==null&&s&&(m.start=m.start._getCombined(e.sourcePosition,e.getMovedRangeStart()),m.end=m.end._getCombined(e.sourcePosition,e.getMovedRangeStart()),u.length===0?u.push(m):u.length==1?i.start.isBefore(n.start)||i.start.isEqual(n.start)?u.unshift(m):u.push(m):u.splice(1,0,m)),u.length===0?[new Zt(o.baseVersion)]:Rr(u,r)}),rt(at,wt,(o,e,t)=>{let n=o.targetPosition.clone();o.targetPosition.isEqual(e.insertionPosition)&&e.graveyardPosition&&t.abRelation!="moveTargetAfter"||(n=o.targetPosition._getTransformedBySplitOperation(e));const i=ne._createFromPositionAndShift(o.sourcePosition,o.howMany);if(i.end.isEqual(e.insertionPosition))return e.graveyardPosition||o.howMany++,o.targetPosition=n,[o];if(i.start.hasSameParentAs(e.splitPosition)&&i.containsPosition(e.splitPosition)){let s=new ne(e.splitPosition,i.end);return s=s._getTransformedBySplitOperation(e),Rr([new ne(i.start,e.splitPosition),s],n)}o.targetPosition.isEqual(e.splitPosition)&&t.abRelation=="insertAtSource"&&(n=e.moveTargetPosition),o.targetPosition.isEqual(e.insertionPosition)&&t.abRelation=="insertBetween"&&(n=o.targetPosition);const r=[i._getTransformedBySplitOperation(e)];if(e.graveyardPosition){const s=i.start.isEqual(e.graveyardPosition)||i.containsPosition(e.graveyardPosition);o.howMany>1&&s&&!t.aWasUndone&&r.push(ne._createFromPositionAndShift(e.insertionPosition,1))}return Rr(r,n)}),rt(at,Lt,(o,e,t)=>{const n=ne._createFromPositionAndShift(o.sourcePosition,o.howMany);if(e.deletionPosition.hasSameParentAs(o.sourcePosition)&&n.containsPosition(e.sourcePosition)){if(o.type!="remove"||t.forceWeakRemove){if(o.howMany==1)return t.bWasUndone?(o.sourcePosition=e.graveyardPosition.clone(),o.targetPosition=o.targetPosition._getTransformedByMergeOperation(e),[o]):[new Zt(0)]}else if(!t.aWasUndone){const r=[];let s=e.graveyardPosition.clone(),a=e.targetPosition._getTransformedByMergeOperation(e);o.howMany>1&&(r.push(new at(o.sourcePosition,o.howMany-1,o.targetPosition,0)),s=s._getTransformedByMove(o.sourcePosition,o.targetPosition,o.howMany-1),a=a._getTransformedByMove(o.sourcePosition,o.targetPosition,o.howMany-1));const c=e.deletionPosition._getCombined(o.sourcePosition,o.targetPosition),u=new at(s,1,c,0),f=u.getMovedRangeStart().path.slice();f.push(0);const m=new le(u.targetPosition.root,f);a=a._getTransformedByMove(s,c,1);const v=new at(a,e.howMany,m,0);return r.push(u),r.push(v),r}}const i=ne._createFromPositionAndShift(o.sourcePosition,o.howMany)._getTransformedByMergeOperation(e);return o.sourcePosition=i.start,o.howMany=i.end.offset-i.start.offset,o.targetPosition=o.targetPosition._getTransformedByMergeOperation(e),[o]}),rt(In,Qt,(o,e)=>(o.position=o.position._getTransformedByInsertOperation(e),[o])),rt(In,Lt,(o,e)=>o.position.isEqual(e.deletionPosition)?(o.position=e.graveyardPosition.clone(),o.position.stickiness="toNext",[o]):(o.position=o.position._getTransformedByMergeOperation(e),[o])),rt(In,at,(o,e)=>(o.position=o.position._getTransformedByMoveOperation(e),[o])),rt(In,In,(o,e,t)=>{if(o.position.isEqual(e.position)){if(!t.aIsStrong)return[new Zt(0)];o.oldName=e.newName}return[o]}),rt(In,wt,(o,e)=>{if(Gt(o.position.path,e.splitPosition.getParentPath())=="same"&&!e.graveyardPosition){const t=new In(o.position.getShiftedBy(1),o.oldName,o.newName,0);return[o,t]}return o.position=o.position._getTransformedBySplitOperation(e),[o]}),rt(ao,ao,(o,e,t)=>{if(o.root===e.root&&o.key===e.key){if(!t.aIsStrong||o.newValue===e.newValue)return[new Zt(0)];o.oldValue=e.newValue}return[o]}),rt(wt,Qt,(o,e)=>(o.splitPosition.hasSameParentAs(e.position)&&o.splitPosition.offset<e.position.offset&&(o.howMany+=e.howMany),o.splitPosition=o.splitPosition._getTransformedByInsertOperation(e),o.insertionPosition=o.insertionPosition._getTransformedByInsertOperation(e),[o])),rt(wt,Lt,(o,e,t)=>{if(!o.graveyardPosition&&!t.bWasUndone&&o.splitPosition.hasSameParentAs(e.sourcePosition)){const n=e.graveyardPosition.path.slice();n.push(0);const i=new le(e.graveyardPosition.root,n),r=wt.getInsertionPosition(new le(e.graveyardPosition.root,n)),s=new wt(i,0,r,null,0);return o.splitPosition=o.splitPosition._getTransformedByMergeOperation(e),o.insertionPosition=wt.getInsertionPosition(o.splitPosition),o.graveyardPosition=s.insertionPosition.clone(),o.graveyardPosition.stickiness="toNext",[s,o]}return o.splitPosition.hasSameParentAs(e.deletionPosition)&&!o.splitPosition.isAfter(e.deletionPosition)&&o.howMany--,o.splitPosition.hasSameParentAs(e.targetPosition)&&(o.howMany+=e.howMany),o.splitPosition=o.splitPosition._getTransformedByMergeOperation(e),o.insertionPosition=wt.getInsertionPosition(o.splitPosition),o.graveyardPosition&&(o.graveyardPosition=o.graveyardPosition._getTransformedByMergeOperation(e)),[o]}),rt(wt,at,(o,e,t)=>{const n=ne._createFromPositionAndShift(e.sourcePosition,e.howMany);if(o.graveyardPosition){const r=n.start.isEqual(o.graveyardPosition)||n.containsPosition(o.graveyardPosition);if(!t.bWasUndone&&r){const s=o.splitPosition._getTransformedByMoveOperation(e),a=o.graveyardPosition._getTransformedByMoveOperation(e),c=a.path.slice();c.push(0);const u=new le(a.root,c);return[new at(s,o.howMany,u,0)]}o.graveyardPosition=o.graveyardPosition._getTransformedByMoveOperation(e)}const i=o.splitPosition.isEqual(e.targetPosition);if(i&&(t.baRelation=="insertAtSource"||t.abRelation=="splitBefore"))return o.howMany+=e.howMany,o.splitPosition=o.splitPosition._getTransformedByDeletion(e.sourcePosition,e.howMany),o.insertionPosition=wt.getInsertionPosition(o.splitPosition),[o];if(i&&t.abRelation&&t.abRelation.howMany){const{howMany:r,offset:s}=t.abRelation;return o.howMany+=r,o.splitPosition=o.splitPosition.getShiftedBy(s),[o]}if(o.splitPosition.hasSameParentAs(e.sourcePosition)&&n.containsPosition(o.splitPosition)){const r=e.howMany-(o.splitPosition.offset-e.sourcePosition.offset);return o.howMany-=r,o.splitPosition.hasSameParentAs(e.targetPosition)&&o.splitPosition.offset<e.targetPosition.offset&&(o.howMany+=e.howMany),o.splitPosition=e.sourcePosition.clone(),o.insertionPosition=wt.getInsertionPosition(o.splitPosition),[o]}return e.sourcePosition.isEqual(e.targetPosition)||(o.splitPosition.hasSameParentAs(e.sourcePosition)&&o.splitPosition.offset<=e.sourcePosition.offset&&(o.howMany-=e.howMany),o.splitPosition.hasSameParentAs(e.targetPosition)&&o.splitPosition.offset<e.targetPosition.offset&&(o.howMany+=e.howMany)),o.splitPosition.stickiness="toNone",o.splitPosition=o.splitPosition._getTransformedByMoveOperation(e),o.splitPosition.stickiness="toNext",o.graveyardPosition?o.insertionPosition=o.insertionPosition._getTransformedByMoveOperation(e):o.insertionPosition=wt.getInsertionPosition(o.splitPosition),[o]}),rt(wt,wt,(o,e,t)=>{if(o.splitPosition.isEqual(e.splitPosition)){if(!o.graveyardPosition&&!e.graveyardPosition)return[new Zt(0)];if(o.graveyardPosition&&e.graveyardPosition&&o.graveyardPosition.isEqual(e.graveyardPosition))return[new Zt(0)];if(t.abRelation=="splitBefore")return o.howMany=0,o.graveyardPosition=o.graveyardPosition._getTransformedBySplitOperation(e),[o]}if(o.graveyardPosition&&e.graveyardPosition&&o.graveyardPosition.isEqual(e.graveyardPosition)){const n=o.splitPosition.root.rootName=="$graveyard",i=e.splitPosition.root.rootName=="$graveyard";if(i&&!n||!(n&&!i)&&t.aIsStrong){const r=[];return e.howMany&&r.push(new at(e.moveTargetPosition,e.howMany,e.splitPosition,0)),o.howMany&&r.push(new at(o.splitPosition,o.howMany,o.moveTargetPosition,0)),r}return[new Zt(0)]}if(o.graveyardPosition&&(o.graveyardPosition=o.graveyardPosition._getTransformedBySplitOperation(e)),o.splitPosition.isEqual(e.insertionPosition)&&t.abRelation=="splitBefore")return o.howMany++,[o];if(e.splitPosition.isEqual(o.insertionPosition)&&t.baRelation=="splitBefore"){const n=e.insertionPosition.path.slice();n.push(0);const i=new le(e.insertionPosition.root,n);return[o,new at(o.insertionPosition,1,i,0)]}return o.splitPosition.hasSameParentAs(e.splitPosition)&&o.splitPosition.offset<e.splitPosition.offset&&(o.howMany-=e.howMany),o.splitPosition=o.splitPosition._getTransformedBySplitOperation(e),o.insertionPosition=wt.getInsertionPosition(o.splitPosition),[o]});class an extends Ce(le){constructor(e,t,n="toNone"){if(super(e,t,n),!this.root.is("rootElement"))throw new V("model-liveposition-root-not-rootelement",e);FA.call(this)}detach(){this.stopListening()}toPosition(){return new le(this.root,this.path.slice(),this.stickiness)}static fromPosition(e,t){return new this(e.root,e.path.slice(),t||e.stickiness)}}function FA(){this.listenTo(this.root.document.model,"applyOperation",(o,e)=>{const t=e[0];t.isDocumentOperation&&VA.call(this,t)},{priority:"low"})}function VA(o){const e=this.getTransformedByOperation(o);if(!this.isEqual(e)){const t=this.toPosition();this.path=e.path,this.root=e.root,this.fire("change",t)}}an.prototype.is=function(o){return o==="livePosition"||o==="model:livePosition"||o=="position"||o==="model:position"};class jr{constructor(e={}){typeof e=="string"&&(e=e==="transparent"?{isUndoable:!1}:{},x("batch-constructor-deprecated-string-type"));const{isUndoable:t=!0,isLocal:n=!0,isUndo:i=!1,isTyping:r=!1}=e;this.operations=[],this.isUndoable=t,this.isLocal=n,this.isUndo=i,this.isTyping=r}get type(){return x("batch-type-deprecated"),"default"}get baseVersion(){for(const e of this.operations)if(e.baseVersion!==null)return e.baseVersion;return null}addOperation(e){return e.batch=this,this.operations.push(e),e}}class HA{constructor(e){this._changesInElement=new Map,this._elementSnapshots=new Map,this._changedMarkers=new Map,this._changeCount=0,this._cachedChanges=null,this._cachedChangesWithGraveyard=null,this._refreshedItems=new Set,this._markerCollection=e}get isEmpty(){return this._changesInElement.size==0&&this._changedMarkers.size==0}bufferOperation(e){const t=e;switch(t.type){case"insert":if(this._isInInsertedElement(t.position.parent))return;this._markInsert(t.position.parent,t.position.offset,t.nodes.maxOffset);break;case"addAttribute":case"removeAttribute":case"changeAttribute":for(const n of t.range.getItems({shallow:!0}))this._isInInsertedElement(n.parent)||this._markAttribute(n);break;case"remove":case"move":case"reinsert":{if(t.sourcePosition.isEqual(t.targetPosition)||t.sourcePosition.getShiftedBy(t.howMany).isEqual(t.targetPosition))return;const n=this._isInInsertedElement(t.sourcePosition.parent),i=this._isInInsertedElement(t.targetPosition.parent);n||this._markRemove(t.sourcePosition.parent,t.sourcePosition.offset,t.howMany),i||this._markInsert(t.targetPosition.parent,t.getMovedRangeStart().offset,t.howMany);break}case"rename":{if(this._isInInsertedElement(t.position.parent))return;this._markRemove(t.position.parent,t.position.offset,1),this._markInsert(t.position.parent,t.position.offset,1);const n=ne._createFromPositionAndShift(t.position,1);for(const i of this._markerCollection.getMarkersIntersectingRange(n)){const r=i.getData();this.bufferMarkerChange(i.name,r,r)}break}case"split":{const n=t.splitPosition.parent;this._isInInsertedElement(n)||this._markRemove(n,t.splitPosition.offset,t.howMany),this._isInInsertedElement(t.insertionPosition.parent)||this._markInsert(t.insertionPosition.parent,t.insertionPosition.offset,1),t.graveyardPosition&&this._markRemove(t.graveyardPosition.parent,t.graveyardPosition.offset,1);break}case"merge":{const n=t.sourcePosition.parent;this._isInInsertedElement(n.parent)||this._markRemove(n.parent,n.startOffset,1);const i=t.graveyardPosition.parent;this._markInsert(i,t.graveyardPosition.offset,1);const r=t.targetPosition.parent;this._isInInsertedElement(r)||this._markInsert(r,t.targetPosition.offset,n.maxOffset);break}}this._cachedChanges=null}bufferMarkerChange(e,t,n){const i=this._changedMarkers.get(e);i?(i.newMarkerData=n,i.oldMarkerData.range==null&&n.range==null&&this._changedMarkers.delete(e)):this._changedMarkers.set(e,{newMarkerData:n,oldMarkerData:t})}getMarkersToRemove(){const e=[];for(const[t,n]of this._changedMarkers)n.oldMarkerData.range!=null&&e.push({name:t,range:n.oldMarkerData.range});return e}getMarkersToAdd(){const e=[];for(const[t,n]of this._changedMarkers)n.newMarkerData.range!=null&&e.push({name:t,range:n.newMarkerData.range});return e}getChangedMarkers(){return Array.from(this._changedMarkers).map(([e,t])=>({name:e,data:{oldRange:t.oldMarkerData.range,newRange:t.newMarkerData.range}}))}hasDataChanges(){if(this._changesInElement.size>0)return!0;for(const{newMarkerData:e,oldMarkerData:t}of this._changedMarkers.values()){if(e.affectsData!==t.affectsData)return!0;if(e.affectsData){const n=e.range&&!t.range,i=!e.range&&t.range,r=e.range&&t.range&&!e.range.isEqual(t.range);if(n||i||r)return!0}}return!1}getChanges(e={}){if(this._cachedChanges)return e.includeChangesInGraveyard?this._cachedChangesWithGraveyard.slice():this._cachedChanges.slice();let t=[];for(const n of this._changesInElement.keys()){const i=this._changesInElement.get(n).sort((f,m)=>f.offset===m.offset?f.type!=m.type?f.type=="remove"?-1:1:0:f.offset<m.offset?-1:1),r=this._elementSnapshots.get(n),s=sp(n.getChildren()),a=UA(r.length,i);let c=0,u=0;for(const f of a)if(f==="i")t.push(this._getInsertDiff(n,c,s[c])),c++;else if(f==="r")t.push(this._getRemoveDiff(n,c,r[u])),u++;else if(f==="a"){const m=s[c].attributes,v=r[u].attributes;let E;if(s[c].name=="$text")E=new ne(le._createAt(n,c),le._createAt(n,c+1));else{const I=n.offsetToIndex(c);E=new ne(le._createAt(n,c),le._createAt(n.getChild(I),0))}t.push(...this._getAttributesDiff(E,v,m)),c++,u++}else c++,u++}t.sort((n,i)=>n.position.root!=i.position.root?n.position.root.rootName<i.position.root.rootName?-1:1:n.position.isEqual(i.position)?n.changeCount-i.changeCount:n.position.isBefore(i.position)?-1:1);for(let n=1,i=0;n<t.length;n++){const r=t[i],s=t[n],a=r.type=="remove"&&s.type=="remove"&&r.name=="$text"&&s.name=="$text"&&r.position.isEqual(s.position),c=r.type=="insert"&&s.type=="insert"&&r.name=="$text"&&s.name=="$text"&&r.position.parent==s.position.parent&&r.position.offset+r.length==s.position.offset,u=r.type=="attribute"&&s.type=="attribute"&&r.position.parent==s.position.parent&&r.range.isFlat&&s.range.isFlat&&r.position.offset+r.length==s.position.offset&&r.attributeKey==s.attributeKey&&r.attributeOldValue==s.attributeOldValue&&r.attributeNewValue==s.attributeNewValue;a||c||u?(r.length++,u&&(r.range.end=r.range.end.getShiftedBy(1)),t[n]=null):i=n}t=t.filter(n=>n);for(const n of t)delete n.changeCount,n.type=="attribute"&&(delete n.position,delete n.length);return this._changeCount=0,this._cachedChangesWithGraveyard=t,this._cachedChanges=t.filter(WA),e.includeChangesInGraveyard?this._cachedChangesWithGraveyard.slice():this._cachedChanges.slice()}getRefreshedItems(){return new Set(this._refreshedItems)}reset(){this._changesInElement.clear(),this._elementSnapshots.clear(),this._changedMarkers.clear(),this._refreshedItems=new Set,this._cachedChanges=null}_refreshItem(e){if(this._isInInsertedElement(e.parent))return;this._markRemove(e.parent,e.startOffset,e.offsetSize),this._markInsert(e.parent,e.startOffset,e.offsetSize),this._refreshedItems.add(e);const t=ne._createOn(e);for(const n of this._markerCollection.getMarkersIntersectingRange(t)){const i=n.getData();this.bufferMarkerChange(n.name,i,i)}this._cachedChanges=null}_markInsert(e,t,n){const i={type:"insert",offset:t,howMany:n,count:this._changeCount++};this._markChange(e,i)}_markRemove(e,t,n){const i={type:"remove",offset:t,howMany:n,count:this._changeCount++};this._markChange(e,i),this._removeAllNestedChanges(e,t,n)}_markAttribute(e){const t={type:"attribute",offset:e.startOffset,howMany:e.offsetSize,count:this._changeCount++};this._markChange(e.parent,t)}_markChange(e,t){this._makeSnapshot(e);const n=this._getChangesForElement(e);this._handleChange(t,n),n.push(t);for(let i=0;i<n.length;i++)n[i].howMany<1&&(n.splice(i,1),i--)}_getChangesForElement(e){let t;return this._changesInElement.has(e)?t=this._changesInElement.get(e):(t=[],this._changesInElement.set(e,t)),t}_makeSnapshot(e){this._elementSnapshots.has(e)||this._elementSnapshots.set(e,sp(e.getChildren()))}_handleChange(e,t){e.nodesToHandle=e.howMany;for(const n of t){const i=e.offset+e.howMany,r=n.offset+n.howMany;if(e.type=="insert"&&(n.type=="insert"&&(e.offset<=n.offset?n.offset+=e.howMany:e.offset<r&&(n.howMany+=e.nodesToHandle,e.nodesToHandle=0)),n.type=="remove"&&e.offset<n.offset&&(n.offset+=e.howMany),n.type=="attribute")){if(e.offset<=n.offset)n.offset+=e.howMany;else if(e.offset<r){const s=n.howMany;n.howMany=e.offset-n.offset,t.unshift({type:"attribute",offset:i,howMany:s-n.howMany,count:this._changeCount++})}}if(e.type=="remove"){if(n.type=="insert"){if(i<=n.offset)n.offset-=e.howMany;else if(i<=r)if(e.offset<n.offset){const s=i-n.offset;n.offset=e.offset,n.howMany-=s,e.nodesToHandle-=s}else n.howMany-=e.nodesToHandle,e.nodesToHandle=0;else if(e.offset<=n.offset)e.nodesToHandle-=n.howMany,n.howMany=0;else if(e.offset<r){const s=r-e.offset;n.howMany-=s,e.nodesToHandle-=s}}if(n.type=="remove"&&(i<=n.offset?n.offset-=e.howMany:e.offset<n.offset&&(e.nodesToHandle+=n.howMany,n.howMany=0)),n.type=="attribute"){if(i<=n.offset)n.offset-=e.howMany;else if(e.offset<n.offset){const s=i-n.offset;n.offset=e.offset,n.howMany-=s}else if(e.offset<r)if(i<=r){const s=n.howMany;n.howMany=e.offset-n.offset;const a=s-n.howMany-e.nodesToHandle;t.unshift({type:"attribute",offset:e.offset,howMany:a,count:this._changeCount++})}else n.howMany-=r-e.offset}}if(e.type=="attribute"){if(n.type=="insert")if(e.offset<n.offset&&i>n.offset){if(i>r){const s={type:"attribute",offset:r,howMany:i-r,count:this._changeCount++};this._handleChange(s,t),t.push(s)}e.nodesToHandle=n.offset-e.offset,e.howMany=e.nodesToHandle}else e.offset>=n.offset&&e.offset<r&&(i>r?(e.nodesToHandle=i-r,e.offset=r):e.nodesToHandle=0);if(n.type=="remove"&&e.offset<n.offset&&i>n.offset){const s={type:"attribute",offset:n.offset,howMany:i-n.offset,count:this._changeCount++};this._handleChange(s,t),t.push(s),e.nodesToHandle=n.offset-e.offset,e.howMany=e.nodesToHandle}n.type=="attribute"&&(e.offset>=n.offset&&i<=r?(e.nodesToHandle=0,e.howMany=0,e.offset=0):e.offset<=n.offset&&i>=r&&(n.howMany=0))}}e.howMany=e.nodesToHandle,delete e.nodesToHandle}_getInsertDiff(e,t,n){return{type:"insert",position:le._createAt(e,t),name:n.name,attributes:new Map(n.attributes),length:1,changeCount:this._changeCount++}}_getRemoveDiff(e,t,n){return{type:"remove",position:le._createAt(e,t),name:n.name,attributes:new Map(n.attributes),length:1,changeCount:this._changeCount++}}_getAttributesDiff(e,t,n){const i=[];n=new Map(n);for(const[r,s]of t){const a=n.has(r)?n.get(r):null;a!==s&&i.push({type:"attribute",position:e.start,range:e.clone(),length:1,attributeKey:r,attributeOldValue:s,attributeNewValue:a,changeCount:this._changeCount++}),n.delete(r)}for(const[r,s]of n)i.push({type:"attribute",position:e.start,range:e.clone(),length:1,attributeKey:r,attributeOldValue:null,attributeNewValue:s,changeCount:this._changeCount++});return i}_isInInsertedElement(e){const t=e.parent;if(!t)return!1;const n=this._changesInElement.get(t),i=e.startOffset;if(n){for(const r of n)if(r.type=="insert"&&i>=r.offset&&i<r.offset+r.howMany)return!0}return this._isInInsertedElement(t)}_removeAllNestedChanges(e,t,n){const i=new ne(le._createAt(e,t),le._createAt(e,t+n));for(const r of i.getItems({shallow:!0}))r.is("element")&&(this._elementSnapshots.delete(r),this._changesInElement.delete(r),this._removeAllNestedChanges(r,0,r.maxOffset))}}function sp(o){const e=[];for(const t of o)if(t.is("$text"))for(let n=0;n<t.data.length;n++)e.push({name:"$text",attributes:new Map(t.getAttributes())});else e.push({name:t.name,attributes:new Map(t.getAttributes())});return e}function UA(o,e){const t=[];let n=0,i=0;for(const r of e){if(r.offset>n){for(let s=0;s<r.offset-n;s++)t.push("e");i+=r.offset-n}if(r.type=="insert"){for(let s=0;s<r.howMany;s++)t.push("i");n=r.offset+r.howMany}else if(r.type=="remove"){for(let s=0;s<r.howMany;s++)t.push("r");n=r.offset,i+=r.howMany}else t.push(..."a".repeat(r.howMany).split("")),n=r.offset+r.howMany,i+=r.howMany}if(i<o)for(let r=0;r<o-i-n;r++)t.push("e");return t}function WA(o){const e="position"in o&&o.position.root.rootName=="$graveyard",t="range"in o&&o.range.root.rootName=="$graveyard";return!e&&!t}class qA{constructor(){this._operations=[],this._undoPairs=new Map,this._undoneOperations=new Set,this._baseVersionToOperationIndex=new Map,this._version=0,this._gaps=new Map}get version(){return this._version}set version(e){this._operations.length&&e>this._version+1&&this._gaps.set(this._version,e),this._version=e}get lastOperation(){return this._operations[this._operations.length-1]}addOperation(e){if(e.baseVersion!==this.version)throw new V("model-document-history-addoperation-incorrect-version",this,{operation:e,historyVersion:this.version});this._operations.push(e),this._version++,this._baseVersionToOperationIndex.set(e.baseVersion,this._operations.length-1)}getOperations(e,t=this.version){if(!this._operations.length)return[];const n=this._operations[0];e===void 0&&(e=n.baseVersion);let i=t-1;for(const[a,c]of this._gaps)e>a&&e<c&&(e=c),i>a&&i<c&&(i=a-1);if(i<n.baseVersion||e>this.lastOperation.baseVersion)return[];let r=this._baseVersionToOperationIndex.get(e);r===void 0&&(r=0);let s=this._baseVersionToOperationIndex.get(i);return s===void 0&&(s=this._operations.length-1),this._operations.slice(r,s+1)}getOperation(e){const t=this._baseVersionToOperationIndex.get(e);if(t!==void 0)return this._operations[t]}setOperationAsUndone(e,t){this._undoPairs.set(t,e),this._undoneOperations.add(e)}isUndoingOperation(e){return this._undoPairs.has(e)}isUndoneOperation(e){return this._undoneOperations.has(e)}getUndoneOperation(e){return this._undoPairs.get(e)}reset(){this._version=0,this._undoPairs=new Map,this._operations=[],this._undoneOperations=new Set,this._gaps=new Map,this._baseVersionToOperationIndex=new Map}}class Il extends gt{constructor(e,t,n="main"){super(t),this._document=e,this.rootName=n}get document(){return this._document}toJSON(){return this.rootName}}Il.prototype.is=function(o,e){return e?e===this.name&&(o==="rootElement"||o==="model:rootElement"||o==="element"||o==="model:element"):o==="rootElement"||o==="model:rootElement"||o==="element"||o==="model:element"||o==="node"||o==="model:node"};const Xd="$graveyard";class GA extends Ce(){constructor(e){super(),this.model=e,this.history=new qA,this.selection=new ai(this),this.roots=new _n({idProperty:"rootName"}),this.differ=new HA(e.markers),this._postFixers=new Set,this._hasSelectionChangedFromTheLastChangeBlock=!1,this.createRoot("$root",Xd),this.listenTo(e,"applyOperation",(t,n)=>{const i=n[0];i.isDocumentOperation&&this.differ.bufferOperation(i)},{priority:"high"}),this.listenTo(e,"applyOperation",(t,n)=>{const i=n[0];i.isDocumentOperation&&this.history.addOperation(i)},{priority:"low"}),this.listenTo(this.selection,"change",()=>{this._hasSelectionChangedFromTheLastChangeBlock=!0}),this.listenTo(e.markers,"update",(t,n,i,r,s)=>{const a={...n.getData(),range:r};this.differ.bufferMarkerChange(n.name,s,a),i===null&&n.on("change",(c,u)=>{const f=n.getData();this.differ.bufferMarkerChange(n.name,{...f,range:u},f)})})}get version(){return this.history.version}set version(e){this.history.version=e}get graveyard(){return this.getRoot(Xd)}createRoot(e="$root",t="main"){if(this.roots.get(t))throw new V("model-document-createroot-name-exists",this,{name:t});const n=new Il(this,e,t);return this.roots.add(n),n}destroy(){this.selection.destroy(),this.stopListening()}getRoot(e="main"){return this.roots.get(e)}getRootNames(){return Array.from(this.roots,e=>e.rootName).filter(e=>e!=Xd)}registerPostFixer(e){this._postFixers.add(e)}toJSON(){const e=Lf(this);return e.selection="[engine.model.DocumentSelection]",e.model="[engine.model.Model]",e}_handleChangeBlock(e){this._hasDocumentChangedFromTheLastChangeBlock()&&(this._callPostFixers(e),this.selection.refresh(),this.differ.hasDataChanges()?this.fire("change:data",e.batch):this.fire("change",e.batch),this.selection.refresh(),this.differ.reset()),this._hasSelectionChangedFromTheLastChangeBlock=!1}_hasDocumentChangedFromTheLastChangeBlock(){return!this.differ.isEmpty||this._hasSelectionChangedFromTheLastChangeBlock}_getDefaultRoot(){for(const e of this.roots)if(e!==this.graveyard)return e;return this.graveyard}_getDefaultRange(){const e=this._getDefaultRoot(),t=this.model,n=t.schema,i=t.createPositionFromPath(e,[0]);return n.getNearestSelectionRange(i)||t.createRange(i)}_validateSelectionRange(e){return ap(e.start)&&ap(e.end)}_callPostFixers(e){let t=!1;do for(const n of this._postFixers)if(this.selection.refresh(),t=n(e),t)break;while(t)}}function ap(o){const e=o.textNode;if(e){const t=e.data,n=o.offset-e.startOffset;return!Df(t,n)&&!Ef(t,n)}return!0}class $A extends Ce(){constructor(){super(...arguments),this._markers=new Map}[Symbol.iterator](){return this._markers.values()}has(e){const t=e instanceof Fr?e.name:e;return this._markers.has(t)}get(e){return this._markers.get(e)||null}_set(e,t,n=!1,i=!1){const r=e instanceof Fr?e.name:e;if(r.includes(","))throw new V("markercollection-incorrect-marker-name",this);const s=this._markers.get(r);if(s){const u=s.getData(),f=s.getRange();let m=!1;return f.isEqual(t)||(s._attachLiveRange(vi.fromRange(t)),m=!0),n!=s.managedUsingOperations&&(s._managedUsingOperations=n,m=!0),typeof i=="boolean"&&i!=s.affectsData&&(s._affectsData=i,m=!0),m&&this.fire(`update:${r}`,s,f,t,u),s}const a=vi.fromRange(t),c=new Fr(r,a,n,i);return this._markers.set(r,c),this.fire(`update:${r}`,c,null,t,{...c.getData(),range:null}),c}_remove(e){const t=e instanceof Fr?e.name:e,n=this._markers.get(t);return!!n&&(this._markers.delete(t),this.fire(`update:${t}`,n,n.getRange(),null,n.getData()),this._destroyMarker(n),!0)}_refresh(e){const t=e instanceof Fr?e.name:e,n=this._markers.get(t);if(!n)throw new V("markercollection-refresh-marker-not-exists",this);const i=n.getRange();this.fire(`update:${t}`,n,i,i,n.getData())}*getMarkersAtPosition(e){for(const t of this)t.getRange().containsPosition(e)&&(yield t)}*getMarkersIntersectingRange(e){for(const t of this)t.getRange().getIntersection(e)!==null&&(yield t)}destroy(){for(const e of this._markers.values())this._destroyMarker(e);this._markers=null,this.stopListening()}*getMarkersGroup(e){for(const t of this._markers.values())t.name.startsWith(e+":")&&(yield t)}_destroyMarker(e){e.stopListening(),e._detachLiveRange()}}class Fr extends Ce(To){constructor(e,t,n,i){super(),this.name=e,this._liveRange=this._attachLiveRange(t),this._managedUsingOperations=n,this._affectsData=i}get managedUsingOperations(){if(!this._liveRange)throw new V("marker-destroyed",this);return this._managedUsingOperations}get affectsData(){if(!this._liveRange)throw new V("marker-destroyed",this);return this._affectsData}getData(){return{range:this.getRange(),affectsData:this.affectsData,managedUsingOperations:this.managedUsingOperations}}getStart(){if(!this._liveRange)throw new V("marker-destroyed",this);return this._liveRange.start.clone()}getEnd(){if(!this._liveRange)throw new V("marker-destroyed",this);return this._liveRange.end.clone()}getRange(){if(!this._liveRange)throw new V("marker-destroyed",this);return this._liveRange.toRange()}_attachLiveRange(e){return this._liveRange&&this._detachLiveRange(),e.delegate("change:range").to(this),e.delegate("change:content").to(this),this._liveRange=e,e}_detachLiveRange(){this._liveRange.stopDelegating("change:range",this),this._liveRange.stopDelegating("change:content",this),this._liveRange.detach(),this._liveRange=null}}Fr.prototype.is=function(o){return o==="marker"||o==="model:marker"};class YA extends li{constructor(e,t){super(null),this.sourcePosition=e.clone(),this.howMany=t}get type(){return"detach"}toJSON(){const e=super.toJSON();return e.sourcePosition=this.sourcePosition.toJSON(),e}_validate(){if(this.sourcePosition.root.document)throw new V("detach-operation-on-document-node",this)}_execute(){Zg(ne._createFromPositionAndShift(this.sourcePosition,this.howMany))}static get className(){return"DetachOperation"}}class lo extends To{constructor(e){super(),this.markers=new Map,this._children=new Us,e&&this._insertChild(0,e)}[Symbol.iterator](){return this.getChildren()}get childCount(){return this._children.length}get maxOffset(){return this._children.maxOffset}get isEmpty(){return this.childCount===0}get nextSibling(){return null}get previousSibling(){return null}get root(){return this}get parent(){return null}get document(){return null}getAncestors(){return[]}getChild(e){return this._children.getNode(e)}getChildren(){return this._children[Symbol.iterator]()}getChildIndex(e){return this._children.getNodeIndex(e)}getChildStartOffset(e){return this._children.getNodeStartOffset(e)}getPath(){return[]}getNodeByPath(e){let t=this;for(const n of e)t=t.getChild(t.offsetToIndex(n));return t}offsetToIndex(e){return this._children.offsetToIndex(e)}toJSON(){const e=[];for(const t of this._children)e.push(t.toJSON());return e}static fromJSON(e){const t=[];for(const n of e)n.name?t.push(gt.fromJSON(n)):t.push(kt.fromJSON(n));return new lo(t)}_appendChild(e){this._insertChild(this.childCount,e)}_insertChild(e,t){const n=function(i){return typeof i=="string"?[new kt(i)]:(bn(i)||(i=[i]),Array.from(i).map(r=>typeof r=="string"?new kt(r):r instanceof wi?new kt(r.data,r.getAttributes()):r))}(t);for(const i of n)i.parent!==null&&i._remove(),i.parent=this;this._children._insertNodes(e,n)}_removeChildren(e,t=1){const n=this._children._removeNodes(e,t);for(const i of n)i.parent=null;return n}}lo.prototype.is=function(o){return o==="documentFragment"||o==="model:documentFragment"};class KA{constructor(e,t){this.model=e,this.batch=t}createText(e,t){return new kt(e,t)}createElement(e,t){return new gt(e,t)}createDocumentFragment(){return new lo}cloneElement(e,t=!0){return e._clone(t)}insert(e,t,n=0){if(this._assertWriterUsedCorrectly(),e instanceof kt&&e.data=="")return;const i=le._createAt(t,n);if(e.parent){if(dp(e.root,i.root))return void this.move(ne._createOn(e),i);if(e.root.document)throw new V("model-writer-insert-forbidden-move",this);this.remove(e)}const r=i.root.document?i.root.document.version:null,s=new Qt(i,e,r);if(e instanceof kt&&(s.shouldReceiveAttributes=!0),this.batch.addOperation(s),this.model.applyOperation(s),e instanceof lo)for(const[a,c]of e.markers){const u=le._createAt(c.root,0),f={range:new ne(c.start._getCombined(u,i),c.end._getCombined(u,i)),usingOperation:!0,affectsData:!0};this.model.markers.has(a)?this.updateMarker(a,f):this.addMarker(a,f)}}insertText(e,t,n,i){t instanceof lo||t instanceof gt||t instanceof le?this.insert(this.createText(e),t,n):this.insert(this.createText(e,t),n,i)}insertElement(e,t,n,i){t instanceof lo||t instanceof gt||t instanceof le?this.insert(this.createElement(e),t,n):this.insert(this.createElement(e,t),n,i)}append(e,t){this.insert(e,t,"end")}appendText(e,t,n){t instanceof lo||t instanceof gt?this.insert(this.createText(e),t,"end"):this.insert(this.createText(e,t),n,"end")}appendElement(e,t,n){t instanceof lo||t instanceof gt?this.insert(this.createElement(e),t,"end"):this.insert(this.createElement(e,t),n,"end")}setAttribute(e,t,n){if(this._assertWriterUsedCorrectly(),n instanceof ne){const i=n.getMinimalFlatRanges();for(const r of i)lp(this,e,t,r)}else cp(this,e,t,n)}setAttributes(e,t){for(const[n,i]of Bi(e))this.setAttribute(n,i,t)}removeAttribute(e,t){if(this._assertWriterUsedCorrectly(),t instanceof ne){const n=t.getMinimalFlatRanges();for(const i of n)lp(this,e,null,i)}else cp(this,e,null,t)}clearAttributes(e){this._assertWriterUsedCorrectly();const t=n=>{for(const i of n.getAttributeKeys())this.removeAttribute(i,n)};if(e instanceof ne)for(const n of e.getItems())t(n);else t(e)}move(e,t,n){if(this._assertWriterUsedCorrectly(),!(e instanceof ne))throw new V("writer-move-invalid-range",this);if(!e.isFlat)throw new V("writer-move-range-not-flat",this);const i=le._createAt(t,n);if(i.isEqual(e.start))return;if(this._addOperationForAffectedMarkers("move",e),!dp(e.root,i.root))throw new V("writer-move-different-document",this);const r=e.root.document?e.root.document.version:null,s=new at(e.start,e.end.offset-e.start.offset,i,r);this.batch.addOperation(s),this.model.applyOperation(s)}remove(e){this._assertWriterUsedCorrectly();const t=(e instanceof ne?e:ne._createOn(e)).getMinimalFlatRanges().reverse();for(const n of t)this._addOperationForAffectedMarkers("move",n),QA(n.start,n.end.offset-n.start.offset,this.batch,this.model)}merge(e){this._assertWriterUsedCorrectly();const t=e.nodeBefore,n=e.nodeAfter;if(this._addOperationForAffectedMarkers("merge",e),!(t instanceof gt))throw new V("writer-merge-no-element-before",this);if(!(n instanceof gt))throw new V("writer-merge-no-element-after",this);e.root.document?this._merge(e):this._mergeDetached(e)}createPositionFromPath(e,t,n){return this.model.createPositionFromPath(e,t,n)}createPositionAt(e,t){return this.model.createPositionAt(e,t)}createPositionAfter(e){return this.model.createPositionAfter(e)}createPositionBefore(e){return this.model.createPositionBefore(e)}createRange(e,t){return this.model.createRange(e,t)}createRangeIn(e){return this.model.createRangeIn(e)}createRangeOn(e){return this.model.createRangeOn(e)}createSelection(...e){return this.model.createSelection(...e)}_mergeDetached(e){const t=e.nodeBefore,n=e.nodeAfter;this.move(ne._createIn(n),le._createAt(t,"end")),this.remove(n)}_merge(e){const t=le._createAt(e.nodeBefore,"end"),n=le._createAt(e.nodeAfter,0),i=e.root.document.graveyard,r=new le(i,[0]),s=e.root.document.version,a=new Lt(n,e.nodeAfter.maxOffset,t,r,s);this.batch.addOperation(a),this.model.applyOperation(a)}rename(e,t){if(this._assertWriterUsedCorrectly(),!(e instanceof gt))throw new V("writer-rename-not-element-instance",this);const n=e.root.document?e.root.document.version:null,i=new In(le._createBefore(e),e.name,t,n);this.batch.addOperation(i),this.model.applyOperation(i)}split(e,t){this._assertWriterUsedCorrectly();let n,i,r=e.parent;if(!r.parent)throw new V("writer-split-element-no-parent",this);if(t||(t=r.parent),!e.parent.getAncestors({includeSelf:!0}).includes(t))throw new V("writer-split-invalid-limit-element",this);do{const s=r.root.document?r.root.document.version:null,a=r.maxOffset-e.offset,c=wt.getInsertionPosition(e),u=new wt(e,a,c,null,s);this.batch.addOperation(u),this.model.applyOperation(u),n||i||(n=r,i=e.parent.nextSibling),r=(e=this.createPositionAfter(e.parent)).parent}while(r!==t);return{position:e,range:new ne(le._createAt(n,"end"),le._createAt(i,0))}}wrap(e,t){if(this._assertWriterUsedCorrectly(),!e.isFlat)throw new V("writer-wrap-range-not-flat",this);const n=t instanceof gt?t:new gt(t);if(n.childCount>0)throw new V("writer-wrap-element-not-empty",this);if(n.parent!==null)throw new V("writer-wrap-element-attached",this);this.insert(n,e.start);const i=new ne(e.start.getShiftedBy(1),e.end.getShiftedBy(1));this.move(i,le._createAt(n,0))}unwrap(e){if(this._assertWriterUsedCorrectly(),e.parent===null)throw new V("writer-unwrap-element-no-parent",this);this.move(ne._createIn(e),this.createPositionAfter(e)),this.remove(e)}addMarker(e,t){if(this._assertWriterUsedCorrectly(),!t||typeof t.usingOperation!="boolean")throw new V("writer-addmarker-no-usingoperation",this);const n=t.usingOperation,i=t.range,r=t.affectsData!==void 0&&t.affectsData;if(this.model.markers.has(e))throw new V("writer-addmarker-marker-exists",this);if(!i)throw new V("writer-addmarker-no-range",this);return n?(Zs(this,e,null,i,r),this.model.markers.get(e)):this.model.markers._set(e,i,n,r)}updateMarker(e,t){this._assertWriterUsedCorrectly();const n=typeof e=="string"?e:e.name,i=this.model.markers.get(n);if(!i)throw new V("writer-updatemarker-marker-not-exists",this);if(!t)return x("writer-updatemarker-reconvert-using-editingcontroller",{markerName:n}),void this.model.markers._refresh(i);const r=typeof t.usingOperation=="boolean",s=typeof t.affectsData=="boolean",a=s?t.affectsData:i.affectsData;if(!r&&!t.range&&!s)throw new V("writer-updatemarker-wrong-options",this);const c=i.getRange(),u=t.range?t.range:c;r&&t.usingOperation!==i.managedUsingOperations?t.usingOperation?Zs(this,n,null,u,a):(Zs(this,n,c,null,a),this.model.markers._set(n,u,void 0,a)):i.managedUsingOperations?Zs(this,n,c,u,a):this.model.markers._set(n,u,void 0,a)}removeMarker(e){this._assertWriterUsedCorrectly();const t=typeof e=="string"?e:e.name;if(!this.model.markers.has(t))throw new V("writer-removemarker-no-marker",this);const n=this.model.markers.get(t);if(!n.managedUsingOperations)return void this.model.markers._remove(t);Zs(this,t,n.getRange(),null,n.affectsData)}setSelection(...e){this._assertWriterUsedCorrectly(),this.model.document.selection._setTo(...e)}setSelectionFocus(e,t){this._assertWriterUsedCorrectly(),this.model.document.selection._setFocus(e,t)}setSelectionAttribute(e,t){if(this._assertWriterUsedCorrectly(),typeof e=="string")this._setSelectionAttribute(e,t);else for(const[n,i]of Bi(e))this._setSelectionAttribute(n,i)}removeSelectionAttribute(e){if(this._assertWriterUsedCorrectly(),typeof e=="string")this._removeSelectionAttribute(e);else for(const t of e)this._removeSelectionAttribute(t)}overrideSelectionGravity(){return this.model.document.selection._overrideGravity()}restoreSelectionGravity(e){this.model.document.selection._restoreGravity(e)}_setSelectionAttribute(e,t){const n=this.model.document.selection;if(n.isCollapsed&&n.anchor.parent.isEmpty){const i=ai._getStoreAttributeKey(e);this.setAttribute(i,t,n.anchor.parent)}n._setAttribute(e,t)}_removeSelectionAttribute(e){const t=this.model.document.selection;if(t.isCollapsed&&t.anchor.parent.isEmpty){const n=ai._getStoreAttributeKey(e);this.removeAttribute(n,t.anchor.parent)}t._removeAttribute(e)}_assertWriterUsedCorrectly(){if(this.model._currentWriter!==this)throw new V("writer-incorrect-use",this)}_addOperationForAffectedMarkers(e,t){for(const n of this.model.markers){if(!n.managedUsingOperations)continue;const i=n.getRange();let r=!1;if(e==="move"){const s=t;r=s.containsPosition(i.start)||s.start.isEqual(i.start)||s.containsPosition(i.end)||s.end.isEqual(i.end)}else{const s=t,a=s.nodeBefore,c=s.nodeAfter,u=i.start.parent==a&&i.start.isAtEnd,f=i.end.parent==c&&i.end.offset==0,m=i.end.nodeAfter==c,v=i.start.nodeAfter==c;r=u||f||m||v}r&&this.updateMarker(n.name,{range:i})}}}function lp(o,e,t,n){const i=o.model,r=i.document;let s,a,c,u=n.start;for(const m of n.getWalker({shallow:!0}))c=m.item.getAttribute(e),s&&a!=c&&(a!=t&&f(),u=s),s=m.nextPosition,a=c;function f(){const m=new ne(u,s),v=m.root.document?r.version:null,E=new jt(m,e,a,t,v);o.batch.addOperation(E),i.applyOperation(E)}s instanceof le&&s!=u&&a!=t&&f()}function cp(o,e,t,n){const i=o.model,r=i.document,s=n.getAttribute(e);let a,c;if(s!=t){if(n.root===n){const u=n.document?r.version:null;c=new ao(n,e,s,t,u)}else{a=new ne(le._createBefore(n),o.createPositionAfter(n));const u=a.root.document?r.version:null;c=new jt(a,e,s,t,u)}o.batch.addOperation(c),i.applyOperation(c)}}function Zs(o,e,t,n,i){const r=o.model,s=r.document,a=new Sn(e,t,n,r.markers,!!i,s.version);o.batch.addOperation(a),r.applyOperation(a)}function QA(o,e,t,n){let i;if(o.root.document){const r=n.document,s=new le(r.graveyard,[0]);i=new at(o,e,s,r.version)}else i=new YA(o,e);t.addOperation(i),n.applyOperation(i)}function dp(o,e){return o===e||o instanceof Il&&e instanceof Il}function ZA(o){o.document.registerPostFixer(e=>function(t,n){const i=n.document.selection,r=n.schema,s=[];let a=!1;for(const c of i.getRanges()){const u=JA(c,r);u&&!u.isEqual(c)?(s.push(u),a=!0):s.push(c)}return a&&t.setSelection(function(c){const u=[...c],f=new Set;let m=1;for(;m<u.length;){const v=u[m],E=u.slice(0,m);for(const[I,L]of E.entries())if(!f.has(I)){if(v.isEqual(L))f.add(I);else if(v.isIntersecting(L)){f.add(I),f.add(m);const R=v.getJoined(L);u.push(R)}}m++}return u.filter((v,E)=>!f.has(E))}(s),{backward:i.isBackward}),!1}(e,o))}function JA(o,e){return o.isCollapsed?function(t,n){const i=t.start,r=n.getNearestSelectionRange(i);if(!r){const a=i.getAncestors().reverse().find(c=>n.isObject(c));return a?ne._createOn(a):null}if(!r.isCollapsed)return r;const s=r.start;return i.isEqual(s)?null:new ne(s)}(o,e):function(t,n){const{start:i,end:r}=t,s=n.checkChild(i,"$text"),a=n.checkChild(r,"$text"),c=n.getLimitElement(i),u=n.getLimitElement(r);if(c===u){if(s&&a)return null;if(function(v,E,I){const L=v.nodeAfter&&!I.isLimit(v.nodeAfter)||I.checkChild(v,"$text"),R=E.nodeBefore&&!I.isLimit(E.nodeBefore)||I.checkChild(E,"$text");return L||R}(i,r,n)){const v=i.nodeAfter&&n.isSelectable(i.nodeAfter)?null:n.getNearestSelectionRange(i,"forward"),E=r.nodeBefore&&n.isSelectable(r.nodeBefore)?null:n.getNearestSelectionRange(r,"backward"),I=v?v.start:i,L=E?E.end:r;return new ne(I,L)}}const f=c&&!c.is("rootElement"),m=u&&!u.is("rootElement");if(f||m){const v=i.nodeAfter&&r.nodeBefore&&i.nodeAfter.parent===r.nodeBefore.parent,E=f&&(!v||!hp(i.nodeAfter,n)),I=m&&(!v||!hp(r.nodeBefore,n));let L=i,R=r;return E&&(L=le._createBefore(up(c,n))),I&&(R=le._createAfter(up(u,n))),new ne(L,R)}return null}(o,e)}function up(o,e){let t=o,n=t;for(;e.isLimit(n)&&n.parent;)t=n,n=n.parent;return t}function hp(o,e){return o&&e.isSelectable(o)}function XA(o,e,t={}){if(e.isCollapsed)return;const n=e.getFirstRange();if(n.root.rootName=="$graveyard")return;const i=o.schema;o.change(r=>{if(!t.doNotResetEntireContent&&function(u,f){const m=u.getLimitElement(f);if(!f.containsEntireContent(m))return!1;const v=f.getFirstRange();return v.start.parent==v.end.parent?!1:u.checkChild(m,"paragraph")}(i,e))return void function(u,f){const m=u.model.schema.getLimitElement(f);u.remove(u.createRangeIn(m)),pp(u,u.createPositionAt(m,0),f)}(r,e);const s={};if(!t.doNotAutoparagraph){const u=e.getSelectedElement();u&&Object.assign(s,i.getAttributesWithProperty(u,"copyOnReplace",!0))}const[a,c]=function(u){const f=u.root.document.model,m=u.start;let v=u.end;if(f.hasContent(u,{ignoreMarkers:!0})){const E=function(I){const L=I.parent,R=L.root.document.model.schema,H=L.getAncestors({parentFirst:!0,includeSelf:!0});for(const $ of H){if(R.isLimit($))return null;if(R.isBlock($))return $}}(v);if(E&&v.isTouching(f.createPositionAt(E,0))){const I=f.createSelection(u);f.modifySelection(I,{direction:"backward"});const L=I.getLastPosition(),R=f.createRange(L,v);f.hasContent(R,{ignoreMarkers:!0})||(v=L)}}return[an.fromPosition(m,"toPrevious"),an.fromPosition(v,"toNext")]}(n);a.isTouching(c)||r.remove(r.createRange(a,c)),t.leaveUnmerged||(function(u,f,m){const v=u.model;if(!eu(u.model.schema,f,m))return;const[E,I]=function(L,R){const H=L.getAncestors(),$=R.getAncestors();let te=0;for(;H[te]&&H[te]==$[te];)te++;return[H[te],$[te]]}(f,m);!E||!I||(!v.hasContent(E,{ignoreMarkers:!0})&&v.hasContent(I,{ignoreMarkers:!0})?gp(u,f,m,E.parent):fp(u,f,m,E.parent))}(r,a,c),i.removeDisallowedAttributes(a.parent.getChildren(),r)),mp(r,e,a),!t.doNotAutoparagraph&&function(u,f){const m=u.checkChild(f,"$text"),v=u.checkChild(f,"paragraph");return!m&&v}(i,a)&&pp(r,a,e,s),a.detach(),c.detach()})}function fp(o,e,t,n){const i=e.parent,r=t.parent;if(i!=n&&r!=n){for(e=o.createPositionAfter(i),(t=o.createPositionBefore(r)).isEqual(e)||o.insert(r,e),o.merge(e);t.parent.isEmpty;){const s=t.parent;t=o.createPositionBefore(s),o.remove(s)}eu(o.model.schema,e,t)&&fp(o,e,t,n)}}function gp(o,e,t,n){const i=e.parent,r=t.parent;if(i!=n&&r!=n){for(e=o.createPositionAfter(i),(t=o.createPositionBefore(r)).isEqual(e)||o.insert(i,t);e.parent.isEmpty;){const s=e.parent;e=o.createPositionBefore(s),o.remove(s)}t=o.createPositionBefore(r),function(s,a){const c=a.nodeBefore,u=a.nodeAfter;c.name!=u.name&&s.rename(c,u.name),s.clearAttributes(c),s.setAttributes(Object.fromEntries(u.getAttributes()),c),s.merge(a)}(o,t),eu(o.model.schema,e,t)&&gp(o,e,t,n)}}function eu(o,e,t){const n=e.parent,i=t.parent;return n!=i&&!o.isLimit(n)&&!o.isLimit(i)&&function(r,s,a){const c=new ne(r,s);for(const u of c.getWalker())if(a.isLimit(u.item))return!1;return!0}(e,t,o)}function pp(o,e,t,n={}){const i=o.createElement("paragraph");o.model.schema.setAllowedAttributes(i,n,o),o.insert(i,e),mp(o,t,o.createPositionAt(i,0))}function mp(o,e,t){e instanceof ai?o.setSelection(t):e.setTo(t)}function bp(o,e){const t=[];Array.from(o.getItems({direction:"backward"})).map(n=>e.createRangeOn(n)).filter(n=>(n.start.isAfter(o.start)||n.start.isEqual(o.start))&&(n.end.isBefore(o.end)||n.end.isEqual(o.end))).forEach(n=>{t.push(n.start.parent),e.remove(n)}),t.forEach(n=>{let i=n;for(;i.parent&&i.isEmpty;){const r=e.createRangeOn(i);i=i.parent,e.remove(r)}})}class e1{constructor(e,t,n){this._firstNode=null,this._lastNode=null,this._lastAutoParagraph=null,this._filterAttributesOf=[],this._affectedStart=null,this._affectedEnd=null,this._nodeToSelect=null,this.model=e,this.writer=t,this.position=n,this.canMergeWith=new Set([this.position.parent]),this.schema=e.schema,this._documentFragment=t.createDocumentFragment(),this._documentFragmentPosition=t.createPositionAt(this._documentFragment,0)}handleNodes(e){for(const t of Array.from(e))this._handleNode(t);this._insertPartialFragment(),this._lastAutoParagraph&&this._updateLastNodeFromAutoParagraph(this._lastAutoParagraph),this._mergeOnRight(),this.schema.removeDisallowedAttributes(this._filterAttributesOf,this.writer),this._filterAttributesOf=[]}_updateLastNodeFromAutoParagraph(e){const t=this.writer.createPositionAfter(this._lastNode),n=this.writer.createPositionAfter(e);if(n.isAfter(t)){if(this._lastNode=e,this.position.parent!=e||!this.position.isAtEnd)throw new V("insertcontent-invalid-insertion-position",this);this.position=n,this._setAffectedBoundaries(this.position)}}getSelectionRange(){return this._nodeToSelect?ne._createOn(this._nodeToSelect):this.model.schema.getNearestSelectionRange(this.position)}getAffectedRange(){return this._affectedStart?new ne(this._affectedStart,this._affectedEnd):null}destroy(){this._affectedStart&&this._affectedStart.detach(),this._affectedEnd&&this._affectedEnd.detach()}_handleNode(e){if(this.schema.isObject(e))return void this._handleObject(e);let t=this._checkAndAutoParagraphToAllowedPosition(e);t||(t=this._checkAndSplitToAllowedPosition(e),t)?(this._appendToFragment(e),this._firstNode||(this._firstNode=e),this._lastNode=e):this._handleDisallowedNode(e)}_insertPartialFragment(){if(this._documentFragment.isEmpty)return;const e=an.fromPosition(this.position,"toNext");this._setAffectedBoundaries(this.position),this._documentFragment.getChild(0)==this._firstNode&&(this.writer.insert(this._firstNode,this.position),this._mergeOnLeft(),this.position=e.toPosition()),this._documentFragment.isEmpty||this.writer.insert(this._documentFragment,this.position),this._documentFragmentPosition=this.writer.createPositionAt(this._documentFragment,0),this.position=e.toPosition(),e.detach()}_handleObject(e){this._checkAndSplitToAllowedPosition(e)?this._appendToFragment(e):this._tryAutoparagraphing(e)}_handleDisallowedNode(e){e.is("element")?this.handleNodes(e.getChildren()):this._tryAutoparagraphing(e)}_appendToFragment(e){if(!this.schema.checkChild(this.position,e))throw new V("insertcontent-wrong-position",this,{node:e,position:this.position});this.writer.insert(e,this._documentFragmentPosition),this._documentFragmentPosition=this._documentFragmentPosition.getShiftedBy(e.offsetSize),this.schema.isObject(e)&&!this.schema.checkChild(this.position,"$text")?this._nodeToSelect=e:this._nodeToSelect=null,this._filterAttributesOf.push(e)}_setAffectedBoundaries(e){this._affectedStart||(this._affectedStart=an.fromPosition(e,"toPrevious")),this._affectedEnd&&!this._affectedEnd.isBefore(e)||(this._affectedEnd&&this._affectedEnd.detach(),this._affectedEnd=an.fromPosition(e,"toNext"))}_mergeOnLeft(){const e=this._firstNode;if(!(e instanceof gt)||!this._canMergeLeft(e))return;const t=an._createBefore(e);t.stickiness="toNext";const n=an.fromPosition(this.position,"toNext");this._affectedStart.isEqual(t)&&(this._affectedStart.detach(),this._affectedStart=an._createAt(t.nodeBefore,"end","toPrevious")),this._firstNode===this._lastNode&&(this._firstNode=t.nodeBefore,this._lastNode=t.nodeBefore),this.writer.merge(t),t.isEqual(this._affectedEnd)&&this._firstNode===this._lastNode&&(this._affectedEnd.detach(),this._affectedEnd=an._createAt(t.nodeBefore,"end","toNext")),this.position=n.toPosition(),n.detach(),this._filterAttributesOf.push(this.position.parent),t.detach()}_mergeOnRight(){const e=this._lastNode;if(!(e instanceof gt)||!this._canMergeRight(e))return;const t=an._createAfter(e);if(t.stickiness="toNext",!this.position.isEqual(t))throw new V("insertcontent-invalid-insertion-position",this);this.position=le._createAt(t.nodeBefore,"end");const n=an.fromPosition(this.position,"toPrevious");this._affectedEnd.isEqual(t)&&(this._affectedEnd.detach(),this._affectedEnd=an._createAt(t.nodeBefore,"end","toNext")),this._firstNode===this._lastNode&&(this._firstNode=t.nodeBefore,this._lastNode=t.nodeBefore),this.writer.merge(t),t.getShiftedBy(-1).isEqual(this._affectedStart)&&this._firstNode===this._lastNode&&(this._affectedStart.detach(),this._affectedStart=an._createAt(t.nodeBefore,0,"toPrevious")),this.position=n.toPosition(),n.detach(),this._filterAttributesOf.push(this.position.parent),t.detach()}_canMergeLeft(e){const t=e.previousSibling;return t instanceof gt&&this.canMergeWith.has(t)&&this.model.schema.checkMerge(t,e)}_canMergeRight(e){const t=e.nextSibling;return t instanceof gt&&this.canMergeWith.has(t)&&this.model.schema.checkMerge(e,t)}_tryAutoparagraphing(e){const t=this.writer.createElement("paragraph");this._getAllowedIn(this.position.parent,t)&&this.schema.checkChild(t,e)&&(t._appendChild(e),this._handleNode(t))}_checkAndAutoParagraphToAllowedPosition(e){if(this.schema.checkChild(this.position.parent,e))return!0;if(!this.schema.checkChild(this.position.parent,"paragraph")||!this.schema.checkChild("paragraph",e))return!1;this._insertPartialFragment();const t=this.writer.createElement("paragraph");return this.writer.insert(t,this.position),this._setAffectedBoundaries(this.position),this._lastAutoParagraph=t,this.position=this.writer.createPositionAt(t,0),!0}_checkAndSplitToAllowedPosition(e){const t=this._getAllowedIn(this.position.parent,e);if(!t)return!1;for(t!=this.position.parent&&this._insertPartialFragment();t!=this.position.parent;)if(this.position.isAtStart){const n=this.position.parent;this.position=this.writer.createPositionBefore(n),n.isEmpty&&n.parent===t&&this.writer.remove(n)}else if(this.position.isAtEnd)this.position=this.writer.createPositionAfter(this.position.parent);else{const n=this.writer.createPositionAfter(this.position.parent);this._setAffectedBoundaries(this.position),this.writer.split(this.position),this.position=n,this.canMergeWith.add(this.position.nodeAfter)}return!0}_getAllowedIn(e,t){return this.schema.checkChild(e,t)?e:this.schema.isLimit(e)?null:this._getAllowedIn(e.parent,t)}}function kp(o,e,t="auto"){const n=o.getSelectedElement();if(n&&e.schema.isObject(n)&&!e.schema.isInline(n))return t=="before"||t=="after"?e.createRange(e.createPositionAt(n,t)):e.createRangeOn(n);const i=Bt(o.getSelectedBlocks());if(!i)return e.createRange(o.focus);if(i.isEmpty)return e.createRange(e.createPositionAt(i,0));const r=e.createPositionAfter(i);return o.focus.isTouching(r)?e.createRange(r):e.createRange(e.createPositionBefore(i))}function t1(o,e,t,n,i={}){if(!o.schema.isObject(e))throw new V("insertobject-element-not-an-object",o,{object:e});let r;r=t?t instanceof Vi||t instanceof ai?t:o.createSelection(t,n):o.document.selection;let s=r;i.findOptimalPosition&&o.schema.isBlock(e)&&(s=o.createSelection(kp(r,o,i.findOptimalPosition)));const a=Bt(r.getSelectedBlocks()),c={};return a&&Object.assign(c,o.schema.getAttributesWithProperty(a,"copyOnReplace",!0)),o.change(u=>{s.isCollapsed||o.deleteContent(s,{doNotAutoparagraph:!0});let f=e;const m=s.anchor.parent;!o.schema.checkChild(m,e)&&o.schema.checkChild(m,"paragraph")&&o.schema.checkChild("paragraph",e)&&(f=u.createElement("paragraph"),u.insert(e,f)),o.schema.setAllowedAttributes(f,c,u);const v=o.insertContent(f,s);return v.isCollapsed||i.setSelection&&function(E,I,L,R){const H=E.model;if(L=="on")return void E.setSelection(I,"on");if(L!="after")throw new V("insertobject-invalid-place-parameter-value",H);let $=I.nextSibling;if(H.schema.isInline(I))return void E.setSelection(I,"after");!($&&H.schema.checkChild($,"$text"))&&H.schema.checkChild(I.parent,"paragraph")&&($=E.createElement("paragraph"),H.schema.setAllowedAttributes($,R,E),H.insertContent($,E.createPositionAfter(I))),$&&E.setSelection($,0)}(u,e,i.setSelection,c),v})}const n1=' ,.?!:;"-()';function i1(o,e){const{isForward:t,walker:n,unit:i,schema:r,treatEmojiAsSingleUnit:s}=o,{type:a,item:c,nextPosition:u}=e;if(a=="text")return o.unit==="word"?function(f,m){let v=f.position.textNode;for(v||(v=m?f.position.nodeAfter:f.position.nodeBefore);v&&v.is("$text");){const E=f.position.offset-v.startOffset;if(s1(v,E,m))v=m?f.position.nodeAfter:f.position.nodeBefore;else{if(r1(v.data,E,m))break;f.next()}}return f.position}(n,t):function(f,m,v){const E=f.position.textNode;if(E){const I=E.data;let L=f.position.offset-E.startOffset;for(;Df(I,L)||m=="character"&&Ef(I,L)||v&&o_(I,L);)f.next(),L=f.position.offset-E.startOffset}return f.position}(n,i,s);if(a==(t?"elementStart":"elementEnd")){if(r.isSelectable(c))return le._createAt(c,t?"after":"before");if(r.checkChild(u,"$text"))return u}else{if(r.isLimit(c))return void n.skip(()=>!0);if(r.checkChild(u,"$text"))return u}}function o1(o,e){const t=o.root,n=le._createAt(t,e?"end":0);return e?new ne(o,n):new ne(n,o)}function r1(o,e,t){const n=e+(t?0:-1);return n1.includes(o.charAt(n))}function s1(o,e,t){return e===(t?o.offsetSize:0)}class a1 extends Ke(){constructor(){super(),this.markers=new $A,this.document=new GA(this),this.schema=new wA,this._pendingChanges=[],this._currentWriter=null,["insertContent","insertObject","deleteContent","modifySelection","getSelectedContent","applyOperation"].forEach(e=>this.decorate(e)),this.on("applyOperation",(e,t)=>{t[0]._validate()},{priority:"highest"}),this.schema.register("$root",{isLimit:!0}),this.schema.register("$container",{allowIn:["$root","$container"]}),this.schema.register("$block",{allowIn:["$root","$container"],isBlock:!0}),this.schema.register("$blockObject",{allowWhere:"$block",isBlock:!0,isObject:!0}),this.schema.register("$inlineObject",{allowWhere:"$text",allowAttributesOf:"$text",isInline:!0,isObject:!0}),this.schema.register("$text",{allowIn:"$block",isInline:!0,isContent:!0}),this.schema.register("$clipboardHolder",{allowContentOf:"$root",allowChildren:"$text",isLimit:!0}),this.schema.register("$documentFragment",{allowContentOf:"$root",allowChildren:"$text",isLimit:!0}),this.schema.register("$marker"),this.schema.addChildCheck((e,t)=>{if(t.name==="$marker")return!0}),ZA(this),this.document.registerPostFixer(Hg)}change(e){try{return this._pendingChanges.length===0?(this._pendingChanges.push({batch:new jr,callback:e}),this._runPendingChanges()[0]):e(this._currentWriter)}catch(t){V.rethrowUnexpectedError(t,this)}}enqueueChange(e,t){try{e?typeof e=="function"?(t=e,e=new jr):e instanceof jr||(e=new jr(e)):e=new jr,this._pendingChanges.push({batch:e,callback:t}),this._pendingChanges.length==1&&this._runPendingChanges()}catch(n){V.rethrowUnexpectedError(n,this)}}applyOperation(e){e._execute()}insertContent(e,t,n){return function(i,r,s,a){return i.change(c=>{let u;u=s?s instanceof Vi||s instanceof ai?s:c.createSelection(s,a):i.document.selection,u.isCollapsed||i.deleteContent(u,{doNotAutoparagraph:!0});const f=new e1(i,c,u.anchor),m=[];let v;if(r.is("documentFragment")){if(r.markers.size){const L=[];for(const[R,H]of r.markers){const{start:$,end:te}=H,ue=$.isEqual(te);L.push({position:$,name:R,isCollapsed:ue},{position:te,name:R,isCollapsed:ue})}L.sort(({position:R},{position:H})=>R.isBefore(H)?1:-1);for(const{position:R,name:H,isCollapsed:$}of L){let te=null,ue=null;const De=R.parent===r&&R.isAtStart,Ze=R.parent===r&&R.isAtEnd;De||Ze?$&&(ue=De?"start":"end"):(te=c.createElement("$marker"),c.insert(te,R)),m.push({name:H,element:te,collapsed:ue})}}v=r.getChildren()}else v=[r];f.handleNodes(v);let E=f.getSelectionRange();if(r.is("documentFragment")&&m.length){const L=E?vi.fromRange(E):null,R={};for(let H=m.length-1;H>=0;H--){const{name:$,element:te,collapsed:ue}=m[H],De=!R[$];if(De&&(R[$]=[]),te){const Ze=c.createPositionAt(te,"before");R[$].push(Ze),c.remove(te)}else{const Ze=f.getAffectedRange();if(!Ze){ue&&R[$].push(f.position);continue}ue?R[$].push(Ze[ue]):R[$].push(De?Ze.start:Ze.end)}}for(const[H,[$,te]]of Object.entries(R))$&&te&&$.root===te.root&&c.addMarker(H,{usingOperation:!0,affectsData:!0,range:new ne($,te)});L&&(E=L.toRange(),L.detach())}E&&(u instanceof ai?c.setSelection(E):u.setTo(E));const I=f.getAffectedRange()||i.createRange(u.anchor);return f.destroy(),I})}(this,e,t,n)}insertObject(e,t,n,i){return t1(this,e,t,n,i)}deleteContent(e,t){XA(this,e,t)}modifySelection(e,t){(function(n,i,r={}){const s=n.schema,a=r.direction!="backward",c=r.unit?r.unit:"character",u=!!r.treatEmojiAsSingleUnit,f=i.focus,m=new Fi({boundaries:o1(f,a),singleCharacters:!0,direction:a?"forward":"backward"}),v={walker:m,schema:s,isForward:a,unit:c,treatEmojiAsSingleUnit:u};let E;for(;E=m.next();){if(E.done)return;const I=i1(v,E.value);if(I)return void(i instanceof ai?n.change(L=>{L.setSelectionFocus(I)}):i.setFocus(I))}})(this,e,t)}getSelectedContent(e){return function(t,n){return t.change(i=>{const r=i.createDocumentFragment(),s=n.getFirstRange();if(!s||s.isCollapsed)return r;const a=s.start.root,c=s.start.getCommonPath(s.end),u=a.getNodeByPath(c);let f;f=s.start.parent==s.end.parent?s:i.createRange(i.createPositionAt(u,s.start.path[c.length]),i.createPositionAt(u,s.end.path[c.length]+1));const m=f.end.offset-f.start.offset;for(const v of f.getItems({shallow:!0}))v.is("$textProxy")?i.appendText(v.data,v.getAttributes(),r):i.append(i.cloneElement(v,!0),r);if(f!=s){const v=s._getTransformedByMove(f.start,i.createPositionAt(r,0),m)[0],E=i.createRange(i.createPositionAt(r,0),v.start);bp(i.createRange(v.end,i.createPositionAt(r,"end")),i),bp(E,i)}return r})}(this,e)}hasContent(e,t={}){const n=e instanceof ne?e:ne._createIn(e);if(n.isCollapsed)return!1;const{ignoreWhitespaces:i=!1,ignoreMarkers:r=!1}=t;if(!r){for(const s of this.markers.getMarkersIntersectingRange(n))if(s.affectsData)return!0}for(const s of n.getItems())if(this.schema.isContent(s)&&(!s.is("$textProxy")||!i||s.data.search(/\S/)!==-1))return!0;return!1}createPositionFromPath(e,t,n){return new le(e,t,n)}createPositionAt(e,t){return le._createAt(e,t)}createPositionAfter(e){return le._createAfter(e)}createPositionBefore(e){return le._createBefore(e)}createRange(e,t){return new ne(e,t)}createRangeIn(e){return ne._createIn(e)}createRangeOn(e){return ne._createOn(e)}createSelection(...e){return new Vi(...e)}createBatch(e){return new jr(e)}createOperationFromJSON(e){return zA.fromJSON(e,this.document)}destroy(){this.document.destroy(),this.stopListening()}_runPendingChanges(){const e=[];this.fire("_beforeChanges");try{for(;this._pendingChanges.length;){const t=this._pendingChanges[0].batch;this._currentWriter=new KA(this,t);const n=this._pendingChanges[0].callback(this._currentWriter);e.push(n),this.document._handleChangeBlock(this._currentWriter),this._pendingChanges.shift(),this._currentWriter=null}}finally{this._pendingChanges.length=0,this._currentWriter=null,this.fire("_afterChanges")}return e}}class l1 extends Eo{constructor(e){super(e),this.domEventType="click"}onDomEvent(e){this.fire(e.type,e)}}class Ml extends Eo{constructor(e){super(e),this.domEventType=["mousedown","mouseup","mouseover","mouseout"]}onDomEvent(e){this.fire(e.type,e)}}class Vr{constructor(e){this.document=e}createDocumentFragment(e){return new rr(this.document,e)}createElement(e,t,n){return new Wn(this.document,e,t,n)}createText(e){return new bt(this.document,e)}clone(e,t=!1){return e._clone(t)}appendChild(e,t){return t._appendChild(e)}insertChild(e,t,n){return n._insertChild(e,t)}removeChildren(e,t,n){return n._removeChildren(e,t)}remove(e){const t=e.parent;return t?this.removeChildren(t.getChildIndex(e),1,t):[]}replace(e,t){const n=e.parent;if(n){const i=n.getChildIndex(e);return this.removeChildren(i,1,n),this.insertChild(i,t,n),!0}return!1}unwrapElement(e){const t=e.parent;if(t){const n=t.getChildIndex(e);this.remove(e),this.insertChild(n,e.getChildren(),t)}}rename(e,t){const n=new Wn(this.document,e,t.getAttributes(),t.getChildren());return this.replace(t,n)?n:null}setAttribute(e,t,n){n._setAttribute(e,t)}removeAttribute(e,t){t._removeAttribute(e)}addClass(e,t){t._addClass(e)}removeClass(e,t){t._removeClass(e)}setStyle(e,t,n){rn(e)&&n===void 0?t._setStyle(e):n._setStyle(e,t)}removeStyle(e,t){t._removeStyle(e)}setCustomProperty(e,t,n){n._setCustomProperty(e,t)}removeCustomProperty(e,t){return t._removeCustomProperty(e)}createPositionAt(e,t){return fe._createAt(e,t)}createPositionAfter(e){return fe._createAfter(e)}createPositionBefore(e){return fe._createBefore(e)}createRange(e,t){return new Ne(e,t)}createRangeOn(e){return Ne._createOn(e)}createRangeIn(e){return Ne._createIn(e)}createSelection(...e){return new Oi(...e)}}const c1=/^#([0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i,d1=/^rgb\([ ]?([0-9]{1,3}[ %]?,[ ]?){2,3}[0-9]{1,3}[ %]?\)$/i,u1=/^rgba\([ ]?([0-9]{1,3}[ %]?,[ ]?){3}(1|[0-9]+%|[0]?\.?[0-9]+)\)$/i,h1=/^hsl\([ ]?([0-9]{1,3}[ %]?[,]?[ ]*){3}(1|[0-9]+%|[0]?\.?[0-9]+)?\)$/i,f1=/^hsla\([ ]?([0-9]{1,3}[ %]?,[ ]?){2,3}(1|[0-9]+%|[0]?\.?[0-9]+)\)$/i,g1=new Set(["black","silver","gray","white","maroon","red","purple","fuchsia","green","lime","olive","yellow","navy","blue","teal","aqua","orange","aliceblue","antiquewhite","aquamarine","azure","beige","bisque","blanchedalmond","blueviolet","brown","burlywood","cadetblue","chartreuse","chocolate","coral","cornflowerblue","cornsilk","crimson","cyan","darkblue","darkcyan","darkgoldenrod","darkgray","darkgreen","darkgrey","darkkhaki","darkmagenta","darkolivegreen","darkorange","darkorchid","darkred","darksalmon","darkseagreen","darkslateblue","darkslategray","darkslategrey","darkturquoise","darkviolet","deeppink","deepskyblue","dimgray","dimgrey","dodgerblue","firebrick","floralwhite","forestgreen","gainsboro","ghostwhite","gold","goldenrod","greenyellow","grey","honeydew","hotpink","indianred","indigo","ivory","khaki","lavender","lavenderblush","lawngreen","lemonchiffon","lightblue","lightcoral","lightcyan","lightgoldenrodyellow","lightgray","lightgreen","lightgrey","lightpink","lightsalmon","lightseagreen","lightskyblue","lightslategray","lightslategrey","lightsteelblue","lightyellow","limegreen","linen","magenta","mediumaquamarine","mediumblue","mediumorchid","mediumpurple","mediumseagreen","mediumslateblue","mediumspringgreen","mediumturquoise","mediumvioletred","midnightblue","mintcream","mistyrose","moccasin","navajowhite","oldlace","olivedrab","orangered","orchid","palegoldenrod","palegreen","paleturquoise","palevioletred","papayawhip","peachpuff","peru","pink","plum","powderblue","rosybrown","royalblue","saddlebrown","salmon","sandybrown","seagreen","seashell","sienna","skyblue","slateblue","slategray","slategrey","snow","springgreen","steelblue","tan","thistle","tomato","turquoise","violet","wheat","whitesmoke","yellowgreen","activeborder","activecaption","appworkspace","background","buttonface","buttonhighlight","buttonshadow","buttontext","captiontext","graytext","highlight","highlighttext","inactiveborder","inactivecaption","inactivecaptiontext","infobackground","infotext","menu","menutext","scrollbar","threeddarkshadow","threedface","threedhighlight","threedlightshadow","threedshadow","window","windowframe","windowtext","rebeccapurple","currentcolor","transparent"]);function p1(o){return o.startsWith("#")?c1.test(o):o.startsWith("rgb")?d1.test(o)||u1.test(o):o.startsWith("hsl")?h1.test(o)||f1.test(o):g1.has(o.toLowerCase())}const m1=/^([+-]?[0-9]*([.][0-9]+)?(px|cm|mm|in|pc|pt|ch|em|ex|rem|vh|vw|vmin|vmax)|0)$/,b1=/^[+-]?[0-9]*([.][0-9]+)?%$/,k1=["repeat-x","repeat-y","repeat","space","round","no-repeat"];function w1(o){return k1.includes(o)}const v1=["center","top","bottom","left","right"];function _1(o){return v1.includes(o)}const C1=["fixed","scroll","local"];function A1(o){return C1.includes(o)}const y1=/^url\(/;function x1(o){return y1.test(o)}function D1(o=""){if(o==="")return{top:void 0,right:void 0,bottom:void 0,left:void 0};const e=wp(o),t=e[0],n=e[2]||t,i=e[1]||t;return{top:t,bottom:n,right:i,left:e[3]||i}}function E1({top:o,right:e,bottom:t,left:n}){const i=[];return n!==e?i.push(o,e,t,n):t!==o?i.push(o,e,t):e!==o?i.push(o,e):i.push(o),i.join(" ")}function wp(o){return o.replace(/, /g,",").split(" ").map(e=>e.replace(/,/g,", "))}function T1(o){o.setNormalizer("background",e=>{const t={},n=wp(e);for(const i of n)w1(i)?(t.repeat=t.repeat||[],t.repeat.push(i)):_1(i)?(t.position=t.position||[],t.position.push(i)):A1(i)?t.attachment=i:p1(i)?t.color=i:x1(i)&&(t.image=i);return{path:"background",value:t}}),o.setNormalizer("background-color",e=>({path:"background.color",value:e})),o.setReducer("background",e=>{const t=[];return t.push(["background-color",e.color]),t}),o.setStyleRelation("background",["background-color"])}function S1(o){var e,t;o.setNormalizer("margin",(e="margin",n=>({path:e,value:D1(n)}))),o.setNormalizer("margin-top",n=>({path:"margin.top",value:n})),o.setNormalizer("margin-right",n=>({path:"margin.right",value:n})),o.setNormalizer("margin-bottom",n=>({path:"margin.bottom",value:n})),o.setNormalizer("margin-left",n=>({path:"margin.left",value:n})),o.setReducer("margin",(t="margin",n=>{const{top:i,right:r,bottom:s,left:a}=n,c=[];return[i,r,a,s].every(u=>!!u)?c.push([t,E1(n)]):(i&&c.push([t+"-top",i]),r&&c.push([t+"-right",r]),s&&c.push([t+"-bottom",s]),a&&c.push([t+"-left",a])),c})),o.setStyleRelation("margin",["margin-top","margin-right","margin-bottom","margin-left"])}class I1{constructor(){this._commands=new Map}add(e,t){this._commands.set(e,t)}get(e){return this._commands.get(e)}execute(e,...t){const n=this.get(e);if(!n)throw new V("commandcollection-command-not-found",this,{commandName:e});return n.execute(...t)}*names(){yield*this._commands.keys()}*commands(){yield*this._commands.values()}[Symbol.iterator](){return this._commands[Symbol.iterator]()}destroy(){for(const e of this.commands())e.destroy()}}class M1 extends Tn{constructor(e){super(),this.editor=e}set(e,t,n={}){if(typeof t=="string"){const i=t;t=(r,s)=>{this.editor.execute(i),s()}}super.set(e,t,n)}}class N1 extends Ke(){constructor(e={}){super();const t=this.constructor,n=e.language||t.defaultConfig&&t.defaultConfig.language;this._context=e.context||new r_({language:n}),this._context._addEditor(this,!e.context);const i=Array.from(t.builtinPlugins||[]);this.config=new rf(e,t.defaultConfig),this.config.define("plugins",i),this.config.define(this._context._getEditorConfig()),this.plugins=new Mf(this,i,this._context.plugins),this.locale=this._context.locale,this.t=this.locale.t,this._readOnlyLocks=new Set,this.commands=new I1,this.set("state","initializing"),this.once("ready",()=>this.state="ready",{priority:"high"}),this.once("destroy",()=>this.state="destroyed",{priority:"high"}),this.model=new a1;const r=new Y_;this.data=new BA(this.model,r),this.editing=new bA(this.model,r),this.editing.view.document.bind("isReadOnly").to(this),this.conversion=new LA([this.editing.downcastDispatcher,this.data.downcastDispatcher],this.data.upcastDispatcher),this.conversion.addAlias("dataDowncast",this.data.downcastDispatcher),this.conversion.addAlias("editingDowncast",this.editing.downcastDispatcher),this.keystrokes=new M1(this),this.keystrokes.listenTo(this.editing.view.document)}get isReadOnly(){return this._readOnlyLocks.size>0}set isReadOnly(e){throw new V("editor-isreadonly-has-no-setter")}enableReadOnlyMode(e){if(typeof e!="string"&&typeof e!="symbol")throw new V("editor-read-only-lock-id-invalid",null,{lockId:e});this._readOnlyLocks.has(e)||(this._readOnlyLocks.add(e),this._readOnlyLocks.size===1&&this.fire("change:isReadOnly","isReadOnly",!0,!1))}disableReadOnlyMode(e){if(typeof e!="string"&&typeof e!="symbol")throw new V("editor-read-only-lock-id-invalid",null,{lockId:e});this._readOnlyLocks.has(e)&&(this._readOnlyLocks.delete(e),this._readOnlyLocks.size===0&&this.fire("change:isReadOnly","isReadOnly",!1,!0))}initPlugins(){const e=this.config,t=e.get("plugins"),n=e.get("removePlugins")||[],i=e.get("extraPlugins")||[],r=e.get("substitutePlugins")||[];return this.plugins.init(t.concat(i),n,r)}destroy(){let e=Promise.resolve();return this.state=="initializing"&&(e=new Promise(t=>this.once("ready",t))),e.then(()=>{this.fire("destroy"),this.stopListening(),this.commands.destroy()}).then(()=>this.plugins.destroy()).then(()=>{this.model.destroy(),this.data.destroy(),this.editing.destroy(),this.keystrokes.destroy()}).then(()=>this._context._removeEditor(this))}execute(e,...t){try{return this.commands.execute(e,...t)}catch(n){V.rethrowUnexpectedError(n,this)}}focus(){this.editing.view.focus()}}function Nl(o){return class extends o{setData(e){this.data.set(e)}getData(e){return this.data.get(e)}}}{const o=Nl(Object);Nl.setData=o.prototype.setData,Nl.getData=o.prototype.getData}function tu(o){return class extends o{updateSourceElement(e=this.data.get()){if(!this.sourceElement)throw new V("editor-missing-sourceelement",this);const t=this.config.get("updateSourceElementOnDestroy"),n=this.sourceElement instanceof HTMLTextAreaElement;G0(this.sourceElement,t||n?e:"")}}}tu.updateSourceElement=tu(Object).prototype.updateSourceElement;class vp extends gl{static get pluginName(){return"PendingActions"}init(){this.set("hasAny",!1),this._actions=new _n({idProperty:"_id"}),this._actions.delegate("add","remove").to(this)}add(e){if(typeof e!="string")throw new V("pendingactions-add-invalid-message",this);const t=new(Ke());return t.set("message",e),this._actions.add(t),this.hasAny=!0,t}remove(e){this._actions.remove(e),this.hasAny=!!this._actions.length}get first(){return this._actions.get(0)}[Symbol.iterator](){return this._actions[Symbol.iterator]()}}const ut={bold:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.187 17H5.773c-.637 0-1.092-.138-1.364-.415-.273-.277-.409-.718-.409-1.323V4.738c0-.617.14-1.062.419-1.332.279-.27.73-.406 1.354-.406h4.68c.69 0 1.288.041 1.793.124.506.083.96.242 1.36.478.341.197.644.447.906.75a3.262 3.262 0 0 1 .808 2.162c0 1.401-.722 2.426-2.167 3.075C15.05 10.175 16 11.315 16 13.01a3.756 3.756 0 0 1-2.296 3.504 6.1 6.1 0 0 1-1.517.377c-.571.073-1.238.11-2 .11zm-.217-6.217H7v4.087h3.069c1.977 0 2.965-.69 2.965-2.072 0-.707-.256-1.22-.768-1.537-.512-.319-1.277-.478-2.296-.478zM7 5.13v3.619h2.606c.729 0 1.292-.067 1.69-.2a1.6 1.6 0 0 0 .91-.765c.165-.267.247-.566.247-.897 0-.707-.26-1.176-.778-1.409-.519-.232-1.31-.348-2.375-.348H7z"/></svg>',cancel:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="m11.591 10.177 4.243 4.242a1 1 0 0 1-1.415 1.415l-4.242-4.243-4.243 4.243a1 1 0 0 1-1.414-1.415l4.243-4.242L4.52 5.934A1 1 0 0 1 5.934 4.52l4.243 4.243 4.242-4.243a1 1 0 1 1 1.415 1.414l-4.243 4.243z"/></svg>',caption:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 16h9a1 1 0 0 1 0 2H2a1 1 0 0 1 0-2z"/><path d="M17 1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h14zm0 1.5H3a.5.5 0 0 0-.492.41L2.5 3v9a.5.5 0 0 0 .41.492L3 12.5h14a.5.5 0 0 0 .492-.41L17.5 12V3a.5.5 0 0 0-.41-.492L17 2.5z" fill-opacity=".6"/></svg>',check:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6.972 16.615a.997.997 0 0 1-.744-.292l-4.596-4.596a1 1 0 1 1 1.414-1.414l3.926 3.926 9.937-9.937a1 1 0 0 1 1.414 1.415L7.717 16.323a.997.997 0 0 1-.745.292z"/></svg>',cog:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="m11.333 2 .19 2.263a5.899 5.899 0 0 1 1.458.604L14.714 3.4 16.6 5.286l-1.467 1.733c.263.452.468.942.605 1.46L18 8.666v2.666l-2.263.19a5.899 5.899 0 0 1-.604 1.458l1.467 1.733-1.886 1.886-1.733-1.467a5.899 5.899 0 0 1-1.46.605L11.334 18H8.667l-.19-2.263a5.899 5.899 0 0 1-1.458-.604L5.286 16.6 3.4 14.714l1.467-1.733a5.899 5.899 0 0 1-.604-1.458L2 11.333V8.667l2.262-.189a5.899 5.899 0 0 1 .605-1.459L3.4 5.286 5.286 3.4l1.733 1.467a5.899 5.899 0 0 1 1.46-.605L8.666 2h2.666zM10 6.267a3.733 3.733 0 1 0 0 7.466 3.733 3.733 0 0 0 0-7.466z"/></svg>',eraser:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="m8.636 9.531-2.758 3.94a.5.5 0 0 0 .122.696l3.224 2.284h1.314l2.636-3.736L8.636 9.53zm.288 8.451L5.14 15.396a2 2 0 0 1-.491-2.786l6.673-9.53a2 2 0 0 1 2.785-.49l3.742 2.62a2 2 0 0 1 .491 2.785l-7.269 10.053-2.147-.066z"/><path d="M4 18h5.523v-1H4zm-2 0h1v-1H2z"/></svg>',image:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6.91 10.54c.26-.23.64-.21.88.03l3.36 3.14 2.23-2.06a.64.64 0 0 1 .87 0l2.52 2.97V4.5H3.2v10.12l3.71-4.08zm10.27-7.51c.6 0 1.09.47 1.09 1.05v11.84c0 .59-.49 1.06-1.09 1.06H2.79c-.6 0-1.09-.47-1.09-1.06V4.08c0-.58.49-1.05 1.1-1.05h14.38zm-5.22 5.56a1.96 1.96 0 1 1 3.4-1.96 1.96 1.96 0 0 1-3.4 1.96z"/></svg>',lowVision:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.085 6.22 2.943 4.078a.75.75 0 1 1 1.06-1.06l2.592 2.59A11.094 11.094 0 0 1 10 5.068c4.738 0 8.578 3.101 8.578 5.083 0 1.197-1.401 2.803-3.555 3.887l1.714 1.713a.75.75 0 0 1-.09 1.138.488.488 0 0 1-.15.084.75.75 0 0 1-.821-.16L6.17 7.304c-.258.11-.51.233-.757.365l6.239 6.24-.006.005.78.78c-.388.094-.78.166-1.174.215l-1.11-1.11h.011L4.55 8.197a7.2 7.2 0 0 0-.665.514l-.112.098 4.897 4.897-.005.006 1.276 1.276a10.164 10.164 0 0 1-1.477-.117l-.479-.479-.009.009-4.863-4.863-.022.031a2.563 2.563 0 0 0-.124.2c-.043.077-.08.158-.108.241a.534.534 0 0 0-.028.133.29.29 0 0 0 .008.072.927.927 0 0 0 .082.226c.067.133.145.26.234.379l3.242 3.365.025.01.59.623c-3.265-.918-5.59-3.155-5.59-4.668 0-1.194 1.448-2.838 3.663-3.93zm7.07.531a4.632 4.632 0 0 1 1.108 5.992l.345.344.046-.018a9.313 9.313 0 0 0 2-1.112c.256-.187.5-.392.727-.613.137-.134.27-.277.392-.431.072-.091.141-.185.203-.286.057-.093.107-.19.148-.292a.72.72 0 0 0 .036-.12.29.29 0 0 0 .008-.072.492.492 0 0 0-.028-.133.999.999 0 0 0-.036-.096 2.165 2.165 0 0 0-.071-.145 2.917 2.917 0 0 0-.125-.2 3.592 3.592 0 0 0-.263-.335 5.444 5.444 0 0 0-.53-.523 7.955 7.955 0 0 0-1.054-.768 9.766 9.766 0 0 0-1.879-.891c-.337-.118-.68-.219-1.027-.301zm-2.85.21-.069.002a.508.508 0 0 0-.254.097.496.496 0 0 0-.104.679.498.498 0 0 0 .326.199l.045.005c.091.003.181.003.272.012a2.45 2.45 0 0 1 2.017 1.513c.024.061.043.125.069.185a.494.494 0 0 0 .45.287h.008a.496.496 0 0 0 .35-.158.482.482 0 0 0 .13-.335.638.638 0 0 0-.048-.219 3.379 3.379 0 0 0-.36-.723 3.438 3.438 0 0 0-2.791-1.543l-.028-.001h-.013z"/></svg>',importExport:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)"><path clip-rule="evenodd" d="M19 4.5 14 0H3v12.673l.868-1.041c.185-.222.4-.402.632-.54V1.5h8v5h5v7.626a2.24 2.24 0 0 1 1.5.822V4.5ZM14 5V2l3.3 3H14Zm-3.692 12.5c.062.105.133.206.213.303L11.52 19H8v-.876a2.243 2.243 0 0 0 1.82-.624h.488Zm7.518-.657a.75.75 0 0 0-1.152-.96L15.5 17.29V12H14v5.29l-1.174-1.408a.75.75 0 0 0-1.152.96l2.346 2.816a.95.95 0 0 0 1.46 0l2.346-2.815Zm-15.056-.38a.75.75 0 0 1-.096-1.056l2.346-2.815a.95.95 0 0 1 1.46 0l2.346 2.815a.75.75 0 1 1-1.152.96L6.5 14.96V20H5v-5.04l-1.174 1.408a.75.75 0 0 1-1.056.096Z"/></g><defs><clipPath id="a"><path d="M0 0h20v20H0z"/></clipPath></defs></svg>',paragraph:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 5.5H7v5h3.5a2.5 2.5 0 1 0 0-5zM5 3h6.5v.025a5 5 0 0 1 0 9.95V13H7v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/></svg>',plus:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 0 0-1 1v6H3a1 1 0 1 0 0 2h6v6a1 1 0 1 0 2 0v-6h6a1 1 0 1 0 0-2h-6V3a1 1 0 0 0-1-1Z"/></svg>',text:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)"><path d="M9.816 11.5 7.038 4.785 4.261 11.5h5.555Zm.62 1.5H3.641l-1.666 4.028H.312l5.789-14h1.875l5.789 14h-1.663L10.436 13Z"/><path clip-rule="evenodd" d="m12.09 17-.534-1.292.848-1.971.545 1.319L12.113 17h-.023Zm1.142-5.187.545 1.319L15.5 9.13l1.858 4.316h-3.45l.398.965h3.467L18.887 17H20l-3.873-9h-1.254l-1.641 3.813Z"/></g><defs><clipPath id="a"><path d="M0 0h20v20H0z"/></clipPath></defs></svg>',alignBottom:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="m9.239 13.938-2.88-1.663a.75.75 0 0 1 .75-1.3L9 12.067V4.75a.75.75 0 1 1 1.5 0v7.318l1.89-1.093a.75.75 0 0 1 .75 1.3l-2.879 1.663a.752.752 0 0 1-.511.187.752.752 0 0 1-.511-.187zM4.25 17a.75.75 0 1 1 0-1.5h10.5a.75.75 0 0 1 0 1.5H4.25z"/></svg>',alignMiddle:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.75 11.875a.752.752 0 0 1 .508.184l2.883 1.666a.75.75 0 0 1-.659 1.344l-.091-.044-1.892-1.093.001 4.318a.75.75 0 1 1-1.5 0v-4.317l-1.89 1.092a.75.75 0 0 1-.75-1.3l2.879-1.663a.752.752 0 0 1 .51-.187zM15.25 9a.75.75 0 1 1 0 1.5H4.75a.75.75 0 1 1 0-1.5h10.5zM9.75.375a.75.75 0 0 1 .75.75v4.318l1.89-1.093.092-.045a.75.75 0 0 1 .659 1.344l-2.883 1.667a.752.752 0 0 1-.508.184.752.752 0 0 1-.511-.187L6.359 5.65a.75.75 0 0 1 .75-1.299L9 5.442V1.125a.75.75 0 0 1 .75-.75z"/></svg>',alignTop:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="m10.261 7.062 2.88 1.663a.75.75 0 0 1-.75 1.3L10.5 8.933v7.317a.75.75 0 1 1-1.5 0V8.932l-1.89 1.093a.75.75 0 0 1-.75-1.3l2.879-1.663a.752.752 0 0 1 .511-.187.752.752 0 0 1 .511.187zM15.25 4a.75.75 0 1 1 0 1.5H4.75a.75.75 0 0 1 0-1.5h10.5z"/></svg>',alignLeft:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 3.75c0 .414.336.75.75.75h14.5a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75zm0 8c0 .414.336.75.75.75h14.5a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75zm0 4c0 .414.336.75.75.75h9.929a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75zm0-8c0 .414.336.75.75.75h9.929a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75z"/></svg>',alignCenter:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 3.75c0 .414.336.75.75.75h14.5a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75zm0 8c0 .414.336.75.75.75h14.5a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75zm2.286 4c0 .414.336.75.75.75h9.928a.75.75 0 1 0 0-1.5H5.036a.75.75 0 0 0-.75.75zm0-8c0 .414.336.75.75.75h9.928a.75.75 0 1 0 0-1.5H5.036a.75.75 0 0 0-.75.75z"/></svg>',alignRight:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M18 3.75a.75.75 0 0 1-.75.75H2.75a.75.75 0 1 1 0-1.5h14.5a.75.75 0 0 1 .75.75zm0 8a.75.75 0 0 1-.75.75H2.75a.75.75 0 1 1 0-1.5h14.5a.75.75 0 0 1 .75.75zm0 4a.75.75 0 0 1-.75.75H7.321a.75.75 0 1 1 0-1.5h9.929a.75.75 0 0 1 .75.75zm0-8a.75.75 0 0 1-.75.75H7.321a.75.75 0 1 1 0-1.5h9.929a.75.75 0 0 1 .75.75z"/></svg>',alignJustify:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 3.75c0 .414.336.75.75.75h14.5a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75zm0 8c0 .414.336.75.75.75h14.5a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75zm0 4c0 .414.336.75.75.75h9.929a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75zm0-8c0 .414.336.75.75.75h14.5a.75.75 0 1 0 0-1.5H2.75a.75.75 0 0 0-.75.75z"/></svg>',objectLeft:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" d="M2 3h16v1.5H2zm11.5 9H18v1.5h-4.5zm0-3H18v1.5h-4.5zm0-3H18v1.5h-4.5zM2 15h16v1.5H2z"/><path d="M12.003 7v5.5a1 1 0 0 1-1 1H2.996a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h8.007a1 1 0 0 1 1 1zm-1.506.5H3.5V12h6.997V7.5z"/></svg>',objectCenter:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" d="M2 3h16v1.5H2zm0 12h16v1.5H2z"/><path d="M15.003 7v5.5a1 1 0 0 1-1 1H5.996a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h8.007a1 1 0 0 1 1 1zm-1.506.5H6.5V12h6.997V7.5z"/></svg>',objectRight:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" d="M2 3h16v1.5H2zm0 12h16v1.5H2zm0-9h5v1.5H2zm0 3h5v1.5H2zm0 3h5v1.5H2z"/><path d="M18.003 7v5.5a1 1 0 0 1-1 1H8.996a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h8.007a1 1 0 0 1 1 1zm-1.506.5H9.5V12h6.997V7.5z"/></svg>',objectFullWidth:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" d="M2 3h16v1.5H2zm0 12h16v1.5H2z"/><path d="M18 7v5.5a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1zm-1.505.5H3.504V12h12.991V7.5z"/></svg>',objectInline:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" d="M2 3h16v1.5H2zm11.5 9H18v1.5h-4.5zM2 15h16v1.5H2z"/><path d="M12.003 7v5.5a1 1 0 0 1-1 1H2.996a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h8.007a1 1 0 0 1 1 1zm-1.506.5H3.5V12h6.997V7.5z"/></svg>',objectBlockLeft:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" d="M2 3h16v1.5H2zm0 12h16v1.5H2z"/><path d="M12.003 7v5.5a1 1 0 0 1-1 1H2.996a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h8.007a1 1 0 0 1 1 1zm-1.506.5H3.5V12h6.997V7.5z"/></svg>',objectBlockRight:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path opacity=".5" d="M2 3h16v1.5H2zm0 12h16v1.5H2z"/><path d="M18.003 7v5.5a1 1 0 0 1-1 1H8.996a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h8.007a1 1 0 0 1 1 1zm-1.506.5H9.5V12h6.997V7.5z"/></svg>',objectSizeFull:'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.5 17v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zM1 15.5v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm0-2v1h-1v-1h1zm-19 0v1H0v-1h1zM14.5 2v1h-1V2h1zm2 0v1h-1V2h1zm2 0v1h-1V2h1zm-8 0v1h-1V2h1zm-2 0v1h-1V2h1zm-2 0v1h-1V2h1zm-2 0v1h-1V2h1zm8 0v1h-1V2h1zm-10 0v1h-1V2h1z"/><path d="M18.095 2H1.905C.853 2 0 2.895 0 4v12c0 1.105.853 2 1.905 2h16.19C19.147 18 20 17.105 20 16V4c0-1.105-.853-2-1.905-2zm0 1.5c.263 0 .476.224.476.5v12c0 .276-.213.5-.476.5H1.905a.489.489 0 0 1-.476-.5V4c0-.276.213-.5.476-.5h16.19z"/></svg>',objectSizeLarge:'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.5 17v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zM1 15.5v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm0-2v1h-1v-1h1zm-19 0v1H0v-1h1zM14.5 2v1h-1V2h1zm2 0v1h-1V2h1zm2 0v1h-1V2h1zm-8 0v1h-1V2h1zm-2 0v1h-1V2h1zm-2 0v1h-1V2h1zm-2 0v1h-1V2h1zm8 0v1h-1V2h1zm-10 0v1h-1V2h1z"/><path d="M13 6H2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zm0 1.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V8a.5.5 0 0 1 .5-.5h11z"/></svg>',objectSizeSmall:'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.5 17v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zM1 15.5v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm0-2v1h-1v-1h1zm-19 0v1H0v-1h1zM14.5 2v1h-1V2h1zm2 0v1h-1V2h1zm2 0v1h-1V2h1zm-8 0v1h-1V2h1zm-2 0v1h-1V2h1zm-2 0v1h-1V2h1zm-2 0v1h-1V2h1zm8 0v1h-1V2h1zm-10 0v1h-1V2h1z"/><path d="M7 10H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h5a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2zm0 1.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h5z"/></svg>',objectSizeMedium:'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.5 17v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zm2 0v1h-1v-1h1zM1 15.5v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm-19-2v1H0v-1h1zm19 0v1h-1v-1h1zm0-2v1h-1v-1h1zm-19 0v1H0v-1h1zM14.5 2v1h-1V2h1zm2 0v1h-1V2h1zm2 0v1h-1V2h1zm-8 0v1h-1V2h1zm-2 0v1h-1V2h1zm-2 0v1h-1V2h1zm-2 0v1h-1V2h1zm8 0v1h-1V2h1zm-10 0v1h-1V2h1z"/><path d="M10 8H2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2zm0 1.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-6a.5.5 0 0 1 .5-.5h8z"/></svg>',pencil:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="m7.3 17.37-.061.088a1.518 1.518 0 0 1-.934.535l-4.178.663-.806-4.153a1.495 1.495 0 0 1 .187-1.058l.056-.086L8.77 2.639c.958-1.351 2.803-1.076 4.296-.03 1.497 1.047 2.387 2.693 1.433 4.055L7.3 17.37zM9.14 4.728l-5.545 8.346 3.277 2.294 5.544-8.346L9.14 4.728zM6.07 16.512l-3.276-2.295.53 2.73 2.746-.435zM9.994 3.506 13.271 5.8c.316-.452-.16-1.333-1.065-1.966-.905-.634-1.895-.78-2.212-.328zM8 18.5 9.375 17H19v1.5H8z"/></svg>',pilcrow:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6.999 2H15a1 1 0 0 1 0 2h-1.004v13a1 1 0 1 1-2 0V4H8.999v13a1 1 0 1 1-2 0v-7A4 4 0 0 1 3 6a4 4 0 0 1 3.999-4z"/></svg>',quote:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M3 10.423a6.5 6.5 0 0 1 6.056-6.408l.038.67C6.448 5.423 5.354 7.663 5.22 10H9c.552 0 .5.432.5.986v4.511c0 .554-.448.503-1 .503h-5c-.552 0-.5-.449-.5-1.003v-4.574zm8 0a6.5 6.5 0 0 1 6.056-6.408l.038.67c-2.646.739-3.74 2.979-3.873 5.315H17c.552 0 .5.432.5.986v4.511c0 .554-.448.503-1 .503h-5c-.552 0-.5-.449-.5-1.003v-4.574z"/></svg>',threeVerticalDots:'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle cx="9.5" cy="4.5" r="1.5"/><circle cx="9.5" cy="10.5" r="1.5"/><circle cx="9.5" cy="16.5" r="1.5"/></svg>'};function nu({emitter:o,activator:e,callback:t,contextElements:n}){o.listenTo(document,"mousedown",(i,r)=>{if(!e())return;const s=typeof r.composedPath=="function"?r.composedPath():[],a=typeof n=="function"?n():n;for(const c of a)if(c.contains(r.target)||s.includes(c))return;t()})}function iu(o){const e=o;e.set("_isCssTransitionsDisabled",!1),e.disableCssTransitions=()=>{e._isCssTransitionsDisabled=!0},e.enableCssTransitions=()=>{e._isCssTransitionsDisabled=!1},e.extendTemplate({attributes:{class:[e.bindTemplate.if("_isCssTransitionsDisabled","ck-transitions-disabled")]}})}function ou({view:o}){o.listenTo(o.element,"submit",(e,t)=>{t.preventDefault(),o.fire("submit")},{useCapture:!0})}function ru({keystrokeHandler:o,focusTracker:e,gridItems:t,numberOfColumns:n,uiLanguageDirection:i}){const r=typeof n=="number"?()=>n:n;function s(u){return f=>{const m=t.find(I=>I.element===e.focusedElement),v=t.getIndex(m),E=u(v,t);t.get(E).focus(),f.stopPropagation(),f.preventDefault()}}function a(u,f){return u===f-1?0:u+1}function c(u,f){return u===0?f-1:u-1}o.set("arrowright",s((u,f)=>i==="rtl"?c(u,f.length):a(u,f.length))),o.set("arrowleft",s((u,f)=>i==="rtl"?a(u,f.length):c(u,f.length))),o.set("arrowup",s((u,f)=>{let m=u-r();return m<0&&(m=u+r()*Math.floor(f.length/r()),m>f.length-1&&(m-=r())),m})),o.set("arrowdown",s((u,f)=>{let m=u+r();return m>f.length-1&&(m=u%r()),m}))}class Hi extends _n{constructor(e=[]){super(e,{idProperty:"viewUid"}),this.on("add",(t,n,i)=>{this._renderViewIntoCollectionParent(n,i)}),this.on("remove",(t,n)=>{n.element&&this._parentElement&&n.element.remove()}),this._parentElement=null}destroy(){this.map(e=>e.destroy())}setParent(e){this._parentElement=e;for(const t of this)this._renderViewIntoCollectionParent(t)}delegate(...e){if(!e.length||!e.every(t=>typeof t=="string"))throw new V("ui-viewcollection-delegate-wrong-events",this);return{to:t=>{for(const n of this)for(const i of e)n.delegate(i).to(t);this.on("add",(n,i)=>{for(const r of e)i.delegate(r).to(t)}),this.on("remove",(n,i)=>{for(const r of e)i.stopDelegating(r,t)})}}}_renderViewIntoCollectionParent(e,t){e.isRendered||e.render(),e.element&&this._parentElement&&this._parentElement.insertBefore(e.element,this._parentElement.children[t])}}var _p=w(4793),P1={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(_p.Z,P1),_p.Z.locals;class We extends Do(Ke()){constructor(e){super(),this.element=null,this.isRendered=!1,this.locale=e,this.t=e&&e.t,this._viewCollections=new _n,this._unboundChildren=this.createCollection(),this._viewCollections.on("add",(t,n)=>{n.locale=e,n.t=e&&e.t}),this.decorate("render")}get bindTemplate(){return this._bindTemplate?this._bindTemplate:this._bindTemplate=ci.bind(this,this)}createCollection(e){const t=new Hi(e);return this._viewCollections.add(t),t}registerChild(e){bn(e)||(e=[e]);for(const t of e)this._unboundChildren.add(t)}deregisterChild(e){bn(e)||(e=[e]);for(const t of e)this._unboundChildren.remove(t)}setTemplate(e){this.template=new ci(e)}extendTemplate(e){ci.extend(this.template,e)}render(){if(this.isRendered)throw new V("ui-view-render-already-rendered",this);this.template&&(this.element=this.template.render(),this.registerChild(this.template.getViews())),this.isRendered=!0}destroy(){this.stopListening(),this._viewCollections.map(e=>e.destroy()),this.template&&this.template._revertData&&this.template.revert(this.element)}}class ci extends Ce(){constructor(e){super(),Object.assign(this,xp(yp(e))),this._isRendered=!1,this._revertData=null}render(){const e=this._renderNode({intoFragment:!0});return this._isRendered=!0,e}apply(e){return this._revertData={children:[],bindings:[],attributes:{}},this._renderNode({node:e,intoFragment:!1,isApplying:!0,revertData:this._revertData}),e}revert(e){if(!this._revertData)throw new V("ui-template-revert-not-applied",[this,e]);this._revertTemplateFromNode(e,this._revertData)}*getViews(){yield*function*e(t){if(t.children)for(const n of t.children)Bl(n)?yield n:su(n)&&(yield*e(n))}(this)}static bind(e,t){return{to:(n,i)=>new B1({eventNameOrFunction:n,attribute:n,observable:e,emitter:t,callback:i}),if:(n,i,r)=>new Cp({observable:e,emitter:t,attribute:n,valueIfTrue:i,callback:r})}}static extend(e,t){if(e._isRendered)throw new V("template-extend-render",[this,e]);Sp(e,xp(yp(t)))}_renderNode(e){let t;if(t=e.node?this.tag&&this.text:this.tag?this.text:!this.text,t)throw new V("ui-template-wrong-syntax",this);return this.text?this._renderText(e):this._renderElement(e)}_renderElement(e){let t=e.node;return t||(t=e.node=document.createElementNS(this.ns||"http://www.w3.org/1999/xhtml",this.tag)),this._renderAttributes(e),this._renderElementChildren(e),this._setUpListeners(e),t}_renderText(e){let t=e.node;return t?e.revertData.text=t.textContent:t=e.node=document.createTextNode(""),Pl(this.text)?this._bindToObservable({schema:this.text,updater:L1(t),data:e}):t.textContent=this.text.join(""),t}_renderAttributes(e){if(!this.attributes)return;const t=e.node,n=e.revertData;for(const i in this.attributes){const r=t.getAttribute(i),s=this.attributes[i];n&&(n.attributes[i]=r);const a=Ip(s)?s[0].ns:null;if(Pl(s)){const c=Ip(s)?s[0].value:s;n&&Mp(i)&&c.unshift(r),this._bindToObservable({schema:c,updater:z1(t,i,a),data:e})}else if(i=="style"&&typeof s[0]!="string")this._renderStyleAttribute(s[0],e);else{n&&r&&Mp(i)&&s.unshift(r);const c=s.map(u=>u&&u.value||u).reduce((u,f)=>u.concat(f),[]).reduce(Ep,"");Hr(c)||t.setAttributeNS(a,i,c)}}}_renderStyleAttribute(e,t){const n=t.node;for(const i in e){const r=e[i];Pl(r)?this._bindToObservable({schema:[r],updater:O1(n,i),data:t}):n.style[i]=r}}_renderElementChildren(e){const t=e.node,n=e.intoFragment?document.createDocumentFragment():t,i=e.isApplying;let r=0;for(const s of this.children)if(au(s)){if(!i){s.setParent(t);for(const a of s)n.appendChild(a.element)}}else if(Bl(s))i||(s.isRendered||s.render(),n.appendChild(s.element));else if(xo(s))n.appendChild(s);else if(i){const a={children:[],bindings:[],attributes:{}};e.revertData.children.push(a),s._renderNode({intoFragment:!1,node:n.childNodes[r++],isApplying:!0,revertData:a})}else n.appendChild(s.render());e.intoFragment&&t.appendChild(n)}_setUpListeners(e){if(this.eventListeners)for(const t in this.eventListeners){const n=this.eventListeners[t].map(i=>{const[r,s]=t.split("@");return i.activateDomEventListener(r,s,e)});e.revertData&&e.revertData.bindings.push(n)}}_bindToObservable({schema:e,updater:t,data:n}){const i=n.revertData;Ap(e,t,n);const r=e.filter(s=>!Hr(s)).filter(s=>s.observable).map(s=>s.activateAttributeListener(e,t,n));i&&i.bindings.push(r)}_revertTemplateFromNode(e,t){for(const i of t.bindings)for(const r of i)r();if(t.text)return void(e.textContent=t.text);const n=e;for(const i in t.attributes){const r=t.attributes[i];r===null?n.removeAttribute(i):n.setAttribute(i,r)}for(let i=0;i<t.children.length;++i)this._revertTemplateFromNode(n.childNodes[i],t.children[i])}}class Js{constructor(e){this.attribute=e.attribute,this.observable=e.observable,this.emitter=e.emitter,this.callback=e.callback}getValue(e){const t=this.observable[this.attribute];return this.callback?this.callback(t,e):t}activateAttributeListener(e,t,n){const i=()=>Ap(e,t,n);return this.emitter.listenTo(this.observable,`change:${this.attribute}`,i),()=>{this.emitter.stopListening(this.observable,`change:${this.attribute}`,i)}}}class B1 extends Js{constructor(e){super(e),this.eventNameOrFunction=e.eventNameOrFunction}activateDomEventListener(e,t,n){const i=(r,s)=>{t&&!s.target.matches(t)||(typeof this.eventNameOrFunction=="function"?this.eventNameOrFunction(s):this.observable.fire(this.eventNameOrFunction,s))};return this.emitter.listenTo(n.node,e,i),()=>{this.emitter.stopListening(n.node,e,i)}}}class Cp extends Js{constructor(e){super(e),this.valueIfTrue=e.valueIfTrue}getValue(e){return!Hr(super.getValue(e))&&(this.valueIfTrue||!0)}}function Pl(o){return!!o&&(o.value&&(o=o.value),Array.isArray(o)?o.some(Pl):o instanceof Js)}function Ap(o,e,{node:t}){const n=function(r,s){return r.map(a=>a instanceof Js?a.getValue(s):a)}(o,t);let i;i=o.length==1&&o[0]instanceof Cp?n[0]:n.reduce(Ep,""),Hr(i)?e.remove():e.set(i)}function L1(o){return{set(e){o.textContent=e},remove(){o.textContent=""}}}function z1(o,e,t){return{set(n){o.setAttributeNS(t,e,n)},remove(){o.removeAttributeNS(t,e)}}}function O1(o,e){return{set(t){o.style[e]=t},remove(){o.style[e]=null}}}function yp(o){return of(o,e=>{if(e&&(e instanceof Js||su(e)||Bl(e)||au(e)))return e})}function xp(o){if(typeof o=="string"?o=function(e){return{text:[e]}}(o):o.text&&function(e){e.text=Kt(e.text)}(o),o.on&&(o.eventListeners=function(e){for(const t in e)Dp(e,t);return e}(o.on),delete o.on),!o.text){o.attributes&&function(t){for(const n in t)t[n].value&&(t[n].value=Kt(t[n].value)),Dp(t,n)}(o.attributes);const e=[];if(o.children)if(au(o.children))e.push(o.children);else for(const t of o.children)su(t)||Bl(t)||xo(t)?e.push(t):e.push(new ci(t));o.children=e}return o}function Dp(o,e){o[e]=Kt(o[e])}function Ep(o,e){return Hr(e)?o:Hr(o)?e:`${o} ${e}`}function Tp(o,e){for(const t in e)o[t]?o[t].push(...e[t]):o[t]=e[t]}function Sp(o,e){if(e.attributes&&(o.attributes||(o.attributes={}),Tp(o.attributes,e.attributes)),e.eventListeners&&(o.eventListeners||(o.eventListeners={}),Tp(o.eventListeners,e.eventListeners)),e.text&&o.text.push(...e.text),e.children&&e.children.length){if(o.children.length!=e.children.length)throw new V("ui-template-extend-children-mismatch",o);let t=0;for(const n of e.children)Sp(o.children[t++],n)}}function Hr(o){return!o&&o!==0}function Bl(o){return o instanceof We}function su(o){return o instanceof ci}function au(o){return o instanceof Hi}function Ip(o){return ht(o[0])&&o[0].ns}function Mp(o){return o=="class"||o=="style"}class R1 extends Hi{constructor(e,t=[]){super(t),this.locale=e}attachToDom(){this._bodyCollectionContainer=new ci({tag:"div",attributes:{class:["ck","ck-reset_all","ck-body","ck-rounded-corners"],dir:this.locale.uiLanguageDirection},children:this}).render();let e=document.querySelector(".ck-body-wrapper");e||(e=Fa(document,"div",{class:"ck-body-wrapper"}),document.body.appendChild(e)),e.appendChild(this._bodyCollectionContainer)}detachFromDom(){super.destroy(),this._bodyCollectionContainer&&this._bodyCollectionContainer.remove();const e=document.querySelector(".ck-body-wrapper");e&&e.childElementCount==0&&e.remove()}}var Np=w(6574),j1={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Np.Z,j1),Np.Z.locals;class dr extends We{constructor(){super();const e=this.bindTemplate;this.set("content",""),this.set("viewBox","0 0 20 20"),this.set("fillColor",""),this.set("isColorInherited",!0),this.setTemplate({tag:"svg",ns:"http://www.w3.org/2000/svg",attributes:{class:["ck","ck-icon","ck-reset_all-excluded",e.if("isColorInherited","ck-icon_inherit-color")],viewBox:e.to("viewBox")}})}render(){super.render(),this._updateXMLContent(),this._colorFillPaths(),this.on("change:content",()=>{this._updateXMLContent(),this._colorFillPaths()}),this.on("change:fillColor",()=>{this._colorFillPaths()})}_updateXMLContent(){if(this.content){const e=new DOMParser().parseFromString(this.content.trim(),"image/svg+xml").querySelector("svg"),t=e.getAttribute("viewBox");t&&(this.viewBox=t);for(const{name:n,value:i}of Array.from(e.attributes))dr.presentationalAttributeNames.includes(n)&&this.element.setAttribute(n,i);for(;this.element.firstChild;)this.element.removeChild(this.element.firstChild);for(;e.childNodes.length>0;)this.element.appendChild(e.childNodes[0])}}_colorFillPaths(){this.fillColor&&this.element.querySelectorAll(".ck-icon__fill").forEach(e=>{e.style.fill=this.fillColor})}}dr.presentationalAttributeNames=["alignment-baseline","baseline-shift","clip-path","clip-rule","color","color-interpolation","color-interpolation-filters","color-rendering","cursor","direction","display","dominant-baseline","fill","fill-opacity","fill-rule","filter","flood-color","flood-opacity","font-family","font-size","font-size-adjust","font-stretch","font-style","font-variant","font-weight","image-rendering","letter-spacing","lighting-color","marker-end","marker-mid","marker-start","mask","opacity","overflow","paint-order","pointer-events","shape-rendering","stop-color","stop-opacity","stroke","stroke-dasharray","stroke-dashoffset","stroke-linecap","stroke-linejoin","stroke-miterlimit","stroke-opacity","stroke-width","text-anchor","text-decoration","text-overflow","text-rendering","transform","unicode-bidi","vector-effect","visibility","white-space","word-spacing","writing-mode"];var Pp=w(4906),F1={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Pp.Z,F1),Pp.Z.locals;class nt extends We{constructor(e){super(e);const t=this.bindTemplate,n=K();this.set("class",void 0),this.set("labelStyle",void 0),this.set("icon",void 0),this.set("isEnabled",!0),this.set("isOn",!1),this.set("isVisible",!0),this.set("isToggleable",!1),this.set("keystroke",void 0),this.set("label",void 0),this.set("tabindex",-1),this.set("tooltip",!1),this.set("tooltipPosition","s"),this.set("type","button"),this.set("withText",!1),this.set("withKeystroke",!1),this.children=this.createCollection(),this.labelView=this._createLabelView(n),this.iconView=new dr,this.iconView.extendTemplate({attributes:{class:"ck-button__icon"}}),this.keystrokeView=this._createKeystrokeView(),this.bind("_tooltipString").to(this,"tooltip",this,"label",this,"keystroke",this._getTooltipString.bind(this));const i={tag:"button",attributes:{class:["ck","ck-button",t.to("class"),t.if("isEnabled","ck-disabled",r=>!r),t.if("isVisible","ck-hidden",r=>!r),t.to("isOn",r=>r?"ck-on":"ck-off"),t.if("withText","ck-button_with-text"),t.if("withKeystroke","ck-button_with-keystroke")],type:t.to("type",r=>r||"button"),tabindex:t.to("tabindex"),"aria-labelledby":`ck-editor__aria-label_${n}`,"aria-disabled":t.if("isEnabled",!0,r=>!r),"aria-pressed":t.to("isOn",r=>!!this.isToggleable&&String(!!r)),"data-cke-tooltip-text":t.to("_tooltipString"),"data-cke-tooltip-position":t.to("tooltipPosition")},children:this.children,on:{click:t.to(r=>{this.isEnabled?this.fire("execute"):r.preventDefault()})}};k.isSafari&&(i.on.mousedown=t.to(r=>{this.focus(),r.preventDefault()})),this.setTemplate(i)}render(){super.render(),this.icon&&(this.iconView.bind("content").to(this,"icon"),this.children.add(this.iconView)),this.children.add(this.labelView),this.withKeystroke&&this.keystroke&&this.children.add(this.keystrokeView)}focus(){this.element.focus()}_createLabelView(e){const t=new We,n=this.bindTemplate;return t.setTemplate({tag:"span",attributes:{class:["ck","ck-button__label"],style:n.to("labelStyle"),id:`ck-editor__aria-label_${e}`},children:[{text:this.bindTemplate.to("label")}]}),t}_createKeystrokeView(){const e=new We;return e.setTemplate({tag:"span",attributes:{class:["ck","ck-button__keystroke"]},children:[{text:this.bindTemplate.to("keystroke",t=>yf(t))}]}),e}_getTooltipString(e,t,n){return e?typeof e=="string"?e:(n&&(n=yf(n)),e instanceof Function?e(t,n):`${t}${n?` (${n})`:""}`):""}}var Bp=w(5332),V1={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Bp.Z,V1),Bp.Z.locals;class Xs extends nt{constructor(e){super(e),this.isToggleable=!0,this.toggleSwitchView=this._createToggleView(),this.extendTemplate({attributes:{class:"ck-switchbutton"}})}render(){super.render(),this.children.add(this.toggleSwitchView)}_createToggleView(){const e=new We;return e.setTemplate({tag:"span",attributes:{class:["ck","ck-button__toggle"]},children:[{tag:"span",attributes:{class:["ck","ck-button__toggle__inner"]}}]}),e}}function H1(o){return typeof o=="string"?{model:o,label:o,hasBorder:!1,view:{name:"span",styles:{color:o}}}:{model:o.color,label:o.label||o.color,hasBorder:o.hasBorder!==void 0&&o.hasBorder,view:{name:"span",styles:{color:`${o.color}`}}}}class Lp extends nt{constructor(e){super(e);const t=this.bindTemplate;this.set("color",void 0),this.set("hasBorder",!1),this.icon='<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path class="ck-icon__fill" d="M16.935 5.328a2 2 0 0 1 0 2.829l-7.778 7.778a2 2 0 0 1-2.829 0L3.5 13.107a1.999 1.999 0 1 1 2.828-2.829l.707.707a1 1 0 0 0 1.414 0l5.658-5.657a2 2 0 0 1 2.828 0z"/><path d="M14.814 6.035 8.448 12.4a1 1 0 0 1-1.414 0l-1.413-1.415A1 1 0 1 0 4.207 12.4l2.829 2.829a1 1 0 0 0 1.414 0l7.778-7.778a1 1 0 1 0-1.414-1.415z"/></svg>',this.extendTemplate({attributes:{style:{backgroundColor:t.to("color")},class:["ck","ck-color-grid__tile",t.if("hasBorder","ck-color-table__color-tile_bordered")]}})}render(){super.render(),this.iconView.fillColor="hsl(0, 0%, 100%)"}}var zp=w(6781),U1={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(zp.Z,U1),zp.Z.locals;class Op extends We{constructor(e,t){super(e);const n=t&&t.colorDefinitions||[];this.columns=t&&t.columns?t.columns:5;const i={gridTemplateColumns:`repeat( ${this.columns}, 1fr)`};this.set("selectedColor",void 0),this.items=this.createCollection(),this.focusTracker=new gn,this.keystrokes=new Tn,this.items.on("add",(r,s)=>{s.isOn=s.color===this.selectedColor}),n.forEach(r=>{const s=new Lp;s.set({color:r.color,label:r.label,tooltip:!0,hasBorder:r.options.hasBorder}),s.on("execute",()=>{this.fire("execute",{value:r.color,hasBorder:r.options.hasBorder,label:r.label})}),this.items.add(s)}),this.setTemplate({tag:"div",children:this.items,attributes:{class:["ck","ck-color-grid"],style:i}}),this.on("change:selectedColor",(r,s,a)=>{for(const c of this.items)c.isOn=c.color===a})}focus(){this.items.length&&this.items.first.focus()}focusLast(){this.items.length&&this.items.last.focus()}render(){super.render();for(const e of this.items)this.focusTracker.add(e.element);this.items.on("add",(e,t)=>{this.focusTracker.add(t.element)}),this.items.on("remove",(e,t)=>{this.focusTracker.remove(t.element)}),this.keystrokes.listenTo(this.element),ru({keystrokeHandler:this.keystrokes,focusTracker:this.focusTracker,gridItems:this.items,numberOfColumns:this.columns,uiLanguageDirection:this.locale&&this.locale.uiLanguageDirection})}destroy(){super.destroy(),this.focusTracker.destroy(),this.keystrokes.destroy()}}class W1{constructor(e){this.editor=e,this._components=new Map}*names(){for(const e of this._components.values())yield e.originalName}add(e,t){this._components.set(lu(e),{callback:t,originalName:e})}create(e){if(!this.has(e))throw new V("componentfactory-item-missing",this,{name:e});return this._components.get(lu(e)).callback(this.editor.locale)}has(e){return this._components.has(lu(e))}}function lu(o){return String(o).toLowerCase()}var Rp=w(5485),q1={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Rp.Z,q1),Rp.Z.locals;class Ur extends We{constructor(e,t,n){super(e);const i=this.bindTemplate;this.buttonView=t,this.panelView=n,this.set("isOpen",!1),this.set("isEnabled",!0),this.set("class",void 0),this.set("id",void 0),this.set("panelPosition","auto"),this.keystrokes=new Tn,this.focusTracker=new gn,this.setTemplate({tag:"div",attributes:{class:["ck","ck-dropdown",i.to("class"),i.if("isEnabled","ck-disabled",r=>!r)],id:i.to("id"),"aria-describedby":i.to("ariaDescribedById")},children:[t,n]}),t.extendTemplate({attributes:{class:["ck-dropdown__button"],"data-cke-tooltip-disabled":i.to("isOpen")}})}render(){super.render(),this.focusTracker.add(this.buttonView.element),this.focusTracker.add(this.panelView.element),this.listenTo(this.buttonView,"open",()=>{this.isOpen=!this.isOpen}),this.panelView.bind("isVisible").to(this,"isOpen"),this.on("change:isOpen",(t,n,i)=>{i&&(this.panelPosition==="auto"?this.panelView.position=Ur._getOptimalPosition({element:this.panelView.element,target:this.buttonView.element,fitInViewport:!0,positions:this._panelPositions}).name:this.panelView.position=this.panelPosition)}),this.keystrokes.listenTo(this.element);const e=(t,n)=>{this.isOpen&&(this.isOpen=!1,n())};this.keystrokes.set("arrowdown",(t,n)=>{this.buttonView.isEnabled&&!this.isOpen&&(this.isOpen=!0,n())}),this.keystrokes.set("arrowright",(t,n)=>{this.isOpen&&n()}),this.keystrokes.set("arrowleft",e),this.keystrokes.set("esc",e)}focus(){this.buttonView.focus()}get _panelPositions(){const{south:e,north:t,southEast:n,southWest:i,northEast:r,northWest:s,southMiddleEast:a,southMiddleWest:c,northMiddleEast:u,northMiddleWest:f}=Ur.defaultPanelPositions;return this.locale.uiLanguageDirection!=="rtl"?[n,i,a,c,e,r,s,u,f,t]:[i,n,c,a,e,s,r,f,u,t]}}Ur.defaultPanelPositions={south:(o,e)=>({top:o.bottom,left:o.left-(e.width-o.width)/2,name:"s"}),southEast:o=>({top:o.bottom,left:o.left,name:"se"}),southWest:(o,e)=>({top:o.bottom,left:o.left-e.width+o.width,name:"sw"}),southMiddleEast:(o,e)=>({top:o.bottom,left:o.left-(e.width-o.width)/4,name:"sme"}),southMiddleWest:(o,e)=>({top:o.bottom,left:o.left-3*(e.width-o.width)/4,name:"smw"}),north:(o,e)=>({top:o.top-e.height,left:o.left-(e.width-o.width)/2,name:"n"}),northEast:(o,e)=>({top:o.top-e.height,left:o.left,name:"ne"}),northWest:(o,e)=>({top:o.top-e.height,left:o.left-e.width+o.width,name:"nw"}),northMiddleEast:(o,e)=>({top:o.top-e.height,left:o.left-(e.width-o.width)/4,name:"nme"}),northMiddleWest:(o,e)=>({top:o.top-e.height,left:o.left-3*(e.width-o.width)/4,name:"nmw"})},Ur._getOptimalPosition=mf;const cu='<svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg"><path d="M.941 4.523a.75.75 0 1 1 1.06-1.06l3.006 3.005 3.005-3.005a.75.75 0 1 1 1.06 1.06l-3.549 3.55a.75.75 0 0 1-1.168-.136L.941 4.523z"/></svg>';class jp extends nt{constructor(e){super(e),this.arrowView=this._createArrowView(),this.extendTemplate({attributes:{"aria-haspopup":!0,"aria-expanded":this.bindTemplate.to("isOn",t=>String(t))}}),this.delegate("execute").to(this,"open")}render(){super.render(),this.children.add(this.arrowView)}_createArrowView(){const e=new dr;return e.content=cu,e.extendTemplate({attributes:{class:"ck-dropdown__arrow"}}),e}}var Fp=w(7686),G1={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Fp.Z,G1),Fp.Z.locals;class Ll extends We{constructor(e){super(e);const t=this.bindTemplate;this.set("class",void 0),this.set("labelStyle",void 0),this.set("icon",void 0),this.set("isEnabled",!0),this.set("isOn",!1),this.set("isToggleable",!1),this.set("isVisible",!0),this.set("keystroke",void 0),this.set("withKeystroke",!1),this.set("label",void 0),this.set("tabindex",-1),this.set("tooltip",!1),this.set("tooltipPosition","s"),this.set("type","button"),this.set("withText",!1),this.children=this.createCollection(),this.actionView=this._createActionView(),this.arrowView=this._createArrowView(),this.keystrokes=new Tn,this.focusTracker=new gn,this.setTemplate({tag:"div",attributes:{class:["ck","ck-splitbutton",t.to("class"),t.if("isVisible","ck-hidden",n=>!n),this.arrowView.bindTemplate.if("isOn","ck-splitbutton_open")]},children:this.children})}render(){super.render(),this.children.add(this.actionView),this.children.add(this.arrowView),this.focusTracker.add(this.actionView.element),this.focusTracker.add(this.arrowView.element),this.keystrokes.listenTo(this.element),this.keystrokes.set("arrowright",(e,t)=>{this.focusTracker.focusedElement===this.actionView.element&&(this.arrowView.focus(),t())}),this.keystrokes.set("arrowleft",(e,t)=>{this.focusTracker.focusedElement===this.arrowView.element&&(this.actionView.focus(),t())})}destroy(){super.destroy(),this.focusTracker.destroy(),this.keystrokes.destroy()}focus(){this.actionView.focus()}_createActionView(){const e=new nt;return e.bind("icon","isEnabled","isOn","isToggleable","keystroke","label","tabindex","tooltip","tooltipPosition","type","withText").to(this),e.extendTemplate({attributes:{class:"ck-splitbutton__action"}}),e.delegate("execute").to(this),e}_createArrowView(){const e=new nt,t=e.bindTemplate;return e.icon=cu,e.extendTemplate({attributes:{class:["ck-splitbutton__arrow"],"data-cke-tooltip-disabled":t.to("isOn"),"aria-haspopup":!0,"aria-expanded":t.to("isOn",n=>String(n))}}),e.bind("isEnabled").to(this),e.bind("label").to(this),e.bind("tooltip").to(this),e.delegate("execute").to(this,"open"),e}}class $1 extends We{constructor(e){super(e);const t=this.bindTemplate;this.set("isVisible",!1),this.set("position","se"),this.children=this.createCollection(),this.setTemplate({tag:"div",attributes:{class:["ck","ck-reset","ck-dropdown__panel",t.to("position",n=>`ck-dropdown__panel_${n}`),t.if("isVisible","ck-dropdown__panel-visible")]},children:this.children,on:{selectstart:t.to(n=>n.preventDefault())}})}focus(){if(this.children.length){const e=this.children.first;typeof e.focus=="function"?e.focus():x("ui-dropdown-panel-focus-child-missing-focus",{childView:this.children.first,dropdownPanel:this})}}focusLast(){if(this.children.length){const e=this.children.last;typeof e.focusLast=="function"?e.focusLast():e.focus()}}}class So{constructor(e){if(this.focusables=e.focusables,this.focusTracker=e.focusTracker,this.keystrokeHandler=e.keystrokeHandler,this.actions=e.actions,e.actions&&e.keystrokeHandler)for(const t in e.actions){let n=e.actions[t];typeof n=="string"&&(n=[n]);for(const i of n)e.keystrokeHandler.set(i,(r,s)=>{this[t](),s()})}}get first(){return this.focusables.find(du)||null}get last(){return this.focusables.filter(du).slice(-1)[0]||null}get next(){return this._getFocusableItem(1)}get previous(){return this._getFocusableItem(-1)}get current(){let e=null;return this.focusTracker.focusedElement===null?null:(this.focusables.find((t,n)=>{const i=t.element===this.focusTracker.focusedElement;return i&&(e=n),i}),e)}focusFirst(){this._focus(this.first)}focusLast(){this._focus(this.last)}focusNext(){this._focus(this.next)}focusPrevious(){this._focus(this.previous)}_focus(e){e&&e.focus()}_getFocusableItem(e){const t=this.current,n=this.focusables.length;if(!n)return null;if(t===null)return this[e===1?"first":"last"];let i=(t+n+e)%n;do{const r=this.focusables.get(i);if(du(r))return r;i=(i+n+e)%n}while(i!==t);return null}}function du(o){return!(!o.focus||!Xo(o.element))}class Vp extends We{constructor(e){super(e),this.setTemplate({tag:"span",attributes:{class:["ck","ck-toolbar__separator"]}})}}class Y1 extends We{constructor(e){super(e),this.setTemplate({tag:"span",attributes:{class:["ck","ck-toolbar__line-break"]}})}}var Hp=w(5542),K1={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Hp.Z,K1),Hp.Z.locals;const{threeVerticalDots:Up}=ut,Q1={alignLeft:ut.alignLeft,bold:ut.bold,importExport:ut.importExport,paragraph:ut.paragraph,plus:ut.plus,text:ut.text,threeVerticalDots:ut.threeVerticalDots};class uu extends We{constructor(e,t){super(e);const n=this.bindTemplate,i=this.t;this.options=t||{},this.set("ariaLabel",i("Editor toolbar")),this.set("maxWidth","auto"),this.items=this.createCollection(),this.focusTracker=new gn,this.keystrokes=new Tn,this.set("class",void 0),this.set("isCompact",!1),this.itemsView=new Z1(e),this.children=this.createCollection(),this.children.add(this.itemsView),this.focusables=this.createCollection();const r=e.uiLanguageDirection==="rtl";this._focusCycler=new So({focusables:this.focusables,focusTracker:this.focusTracker,keystrokeHandler:this.keystrokes,actions:{focusPrevious:[r?"arrowright":"arrowleft","arrowup"],focusNext:[r?"arrowleft":"arrowright","arrowdown"]}});const s=["ck","ck-toolbar",n.to("class"),n.if("isCompact","ck-toolbar_compact")];var a;this.options.shouldGroupWhenFull&&this.options.isFloating&&s.push("ck-toolbar_floating"),this.setTemplate({tag:"div",attributes:{class:s,role:"toolbar","aria-label":n.to("ariaLabel"),style:{maxWidth:n.to("maxWidth")}},children:this.children,on:{mousedown:(a=this,a.bindTemplate.to(c=>{c.target===a.element&&c.preventDefault()}))}}),this._behavior=this.options.shouldGroupWhenFull?new X1(this):new J1(this)}render(){super.render();for(const e of this.items)this.focusTracker.add(e.element);this.items.on("add",(e,t)=>{this.focusTracker.add(t.element)}),this.items.on("remove",(e,t)=>{this.focusTracker.remove(t.element)}),this.keystrokes.listenTo(this.element),this._behavior.render(this)}destroy(){return this._behavior.destroy(),this.focusTracker.destroy(),this.keystrokes.destroy(),super.destroy()}focus(){this._focusCycler.focusFirst()}focusLast(){this._focusCycler.focusLast()}fillFromConfig(e,t,n){this.items.addMany(this._buildItemsFromConfig(e,t,n))}_buildItemsFromConfig(e,t,n){const i=function(s){return Array.isArray(s)?{items:s,removeItems:[]}:s?Object.assign({items:[],removeItems:[]},s):{items:[],removeItems:[]}}(e),r=n||i.removeItems;return this._cleanItemsConfiguration(i.items,t,r).map(s=>ht(s)?this._createNestedToolbarDropdown(s,t,r):s==="|"?new Vp:s==="-"?new Y1:t.create(s)).filter(s=>!!s)}_cleanItemsConfiguration(e,t,n){const i=e.filter((r,s,a)=>r==="|"||n.indexOf(r)===-1&&(r==="-"?!this.options.shouldGroupWhenFull||(x("toolbarview-line-break-ignored-when-grouping-items",a),!1):!(!ht(r)&&!t.has(r))||(x("toolbarview-item-unavailable",{item:r}),!1)));return this._cleanSeparatorsAndLineBreaks(i)}_cleanSeparatorsAndLineBreaks(e){const t=s=>s!=="-"&&s!=="|",n=e.length,i=e.findIndex(t);if(i===-1)return[];const r=n-e.slice().reverse().findIndex(t);return e.slice(i,r).filter((s,a,c)=>t(s)?!0:!(a>0&&c[a-1]===s))}_createNestedToolbarDropdown(e,t,n){let{label:i,icon:r,items:s,tooltip:a=!0,withText:c=!1}=e;if(s=this._cleanItemsConfiguration(s,t,n),!s.length)return null;const u=Mn(this.locale);return i||x("toolbarview-nested-toolbar-dropdown-missing-label",e),u.class="ck-toolbar__nested-toolbar-dropdown",u.buttonView.set({label:i,tooltip:a,withText:!!c}),r!==!1?u.buttonView.icon=Q1[r]||r||Up:u.buttonView.withText=!0,zl(u,()=>u.toolbarView._buildItemsFromConfig(s,t,n)),u}}class Z1 extends We{constructor(e){super(e),this.children=this.createCollection(),this.setTemplate({tag:"div",attributes:{class:["ck","ck-toolbar__items"]},children:this.children})}}class J1{constructor(e){const t=e.bindTemplate;e.set("isVertical",!1),e.itemsView.children.bindTo(e.items).using(n=>n),e.focusables.bindTo(e.items).using(n=>n),e.extendTemplate({attributes:{class:[t.if("isVertical","ck-toolbar_vertical")]}})}render(){}destroy(){}}class X1{constructor(e){this.view=e,this.viewChildren=e.children,this.viewFocusables=e.focusables,this.viewItemsView=e.itemsView,this.viewFocusTracker=e.focusTracker,this.viewLocale=e.locale,this.ungroupedItems=e.createCollection(),this.groupedItems=e.createCollection(),this.groupedItemsDropdown=this._createGroupedItemsDropdown(),this.resizeObserver=null,this.cachedPadding=null,this.shouldUpdateGroupingOnNextResize=!1,e.itemsView.children.bindTo(this.ungroupedItems).using(t=>t),this.ungroupedItems.on("change",this._updateFocusCycleableItems.bind(this)),e.children.on("change",this._updateFocusCycleableItems.bind(this)),e.items.on("change",(t,n)=>{const i=n.index,r=Array.from(n.added);for(const s of n.removed)i>=this.ungroupedItems.length?this.groupedItems.remove(s):this.ungroupedItems.remove(s);for(let s=i;s<i+r.length;s++){const a=r[s-i];s>this.ungroupedItems.length?this.groupedItems.add(a,s-this.ungroupedItems.length):this.ungroupedItems.add(a,s)}this._updateGrouping()}),e.extendTemplate({attributes:{class:["ck-toolbar_grouping"]}})}render(e){this.viewElement=e.element,this._enableGroupingOnResize(),this._enableGroupingOnMaxWidthChange(e)}destroy(){this.groupedItemsDropdown.destroy(),this.resizeObserver.destroy()}_updateGrouping(){if(!this.viewElement.ownerDocument.body.contains(this.viewElement))return;if(!Xo(this.viewElement))return void(this.shouldUpdateGroupingOnNextResize=!0);const e=this.groupedItems.length;let t;for(;this._areItemsOverflowing;)this._groupLastItem(),t=!0;if(!t&&this.groupedItems.length){for(;this.groupedItems.length&&!this._areItemsOverflowing;)this._ungroupFirstItem();this._areItemsOverflowing&&this._groupLastItem()}this.groupedItems.length!==e&&this.view.fire("groupedItemsUpdate")}get _areItemsOverflowing(){if(!this.ungroupedItems.length)return!1;const e=this.viewElement,t=this.viewLocale.uiLanguageDirection,n=new vt(e.lastChild),i=new vt(e);if(!this.cachedPadding){const r=Qe.window.getComputedStyle(e),s=t==="ltr"?"paddingRight":"paddingLeft";this.cachedPadding=Number.parseInt(r[s])}return t==="ltr"?n.right>i.right-this.cachedPadding:n.left<i.left+this.cachedPadding}_enableGroupingOnResize(){let e;this.resizeObserver=new Dt(this.viewElement,t=>{e&&e===t.contentRect.width&&!this.shouldUpdateGroupingOnNextResize||(this.shouldUpdateGroupingOnNextResize=!1,this._updateGrouping(),e=t.contentRect.width)}),this._updateGrouping()}_enableGroupingOnMaxWidthChange(e){e.on("change:maxWidth",()=>{this._updateGrouping()})}_groupLastItem(){this.groupedItems.length||(this.viewChildren.add(new Vp),this.viewChildren.add(this.groupedItemsDropdown),this.viewFocusTracker.add(this.groupedItemsDropdown.element)),this.groupedItems.add(this.ungroupedItems.remove(this.ungroupedItems.last),0)}_ungroupFirstItem(){this.ungroupedItems.add(this.groupedItems.remove(this.groupedItems.first)),this.groupedItems.length||(this.viewChildren.remove(this.groupedItemsDropdown),this.viewChildren.remove(this.viewChildren.last),this.viewFocusTracker.remove(this.groupedItemsDropdown.element))}_createGroupedItemsDropdown(){const e=this.viewLocale,t=e.t,n=Mn(e);return n.class="ck-toolbar__grouped-dropdown",n.panelPosition=e.uiLanguageDirection==="ltr"?"sw":"se",zl(n,this.groupedItems),n.buttonView.set({label:t("Show more items"),tooltip:!0,tooltipPosition:e.uiLanguageDirection==="rtl"?"se":"sw",icon:Up}),n}_updateFocusCycleableItems(){this.viewFocusables.clear(),this.ungroupedItems.map(e=>{this.viewFocusables.add(e)}),this.groupedItems.length&&this.viewFocusables.add(this.groupedItemsDropdown)}}var Wp=w(1046),ey={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Wp.Z,ey),Wp.Z.locals;class ty extends We{constructor(e){super(e);const t=this.bindTemplate;this.items=this.createCollection(),this.focusTracker=new gn,this.keystrokes=new Tn,this._focusCycler=new So({focusables:this.items,focusTracker:this.focusTracker,keystrokeHandler:this.keystrokes,actions:{focusPrevious:"arrowup",focusNext:"arrowdown"}}),this.set("ariaLabel",void 0),this.setTemplate({tag:"ul",attributes:{class:["ck","ck-reset","ck-list"],"aria-label":t.to("ariaLabel")},children:this.items})}render(){super.render();for(const e of this.items)this.focusTracker.add(e.element);this.items.on("add",(e,t)=>{this.focusTracker.add(t.element)}),this.items.on("remove",(e,t)=>{this.focusTracker.remove(t.element)}),this.keystrokes.listenTo(this.element)}destroy(){super.destroy(),this.focusTracker.destroy(),this.keystrokes.destroy()}focus(){this._focusCycler.focusFirst()}focusLast(){this._focusCycler.focusLast()}}class qp extends We{constructor(e){super(e);const t=this.bindTemplate;this.set("isVisible",!0),this.children=this.createCollection(),this.setTemplate({tag:"li",attributes:{class:["ck","ck-list__item",t.if("isVisible","ck-hidden",n=>!n)]},children:this.children})}focus(){this.children.first.focus()}}class ny extends We{constructor(e){super(e),this.setTemplate({tag:"li",attributes:{class:["ck","ck-list__separator"]}})}}var Gp=w(7339),iy={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Gp.Z,iy),Gp.Z.locals;var $p=w(3949),oy={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()($p.Z,oy),$p.Z.locals;function Mn(o,e=jp){const t=new e(o),n=new $1(o),i=new Ur(o,t,n);return t.bind("isEnabled").to(i),t instanceof Ll?t.arrowView.bind("isOn").to(i,"isOpen"):t.bind("isOn").to(i,"isOpen"),function(r){(function(s){s.on("render",()=>{nu({emitter:s,activator:()=>s.isOpen,callback:()=>{s.isOpen=!1},contextElements:[s.element]})})})(r),function(s){s.on("execute",a=>{a.source instanceof Xs||(s.isOpen=!1)})}(r),function(s){s.focusTracker.on("change:isFocused",(a,c,u)=>{s.isOpen&&!u&&(s.isOpen=!1)})}(r),function(s){s.keystrokes.set("arrowdown",(a,c)=>{s.isOpen&&(s.panelView.focus(),c())}),s.keystrokes.set("arrowup",(a,c)=>{s.isOpen&&(s.panelView.focusLast(),c())})}(r),function(s){s.on("change:isOpen",(a,c,u)=>{if(u)return;const f=s.panelView.element;f&&f.contains(Qe.document.activeElement)&&s.buttonView.focus()})}(r),function(s){s.on("change:isOpen",(a,c,u)=>{u&&s.panelView.focus()},{priority:"low"})}(r)}(i),i}function zl(o,e,t={}){o.extendTemplate({attributes:{class:["ck-toolbar-dropdown"]}}),o.isOpen?Yp(o,e,t):o.once("change:isOpen",()=>Yp(o,e,t),{priority:"highest"}),t.enableActiveItemFocusOnDropdownOpen&&Ol(o,()=>o.toolbarView.items.find(n=>n.isOn))}function Yp(o,e,t){const n=o.locale,i=n.t,r=o.toolbarView=new uu(n),s=typeof e=="function"?e():e;r.ariaLabel=t.ariaLabel||i("Dropdown toolbar"),t.maxWidth&&(r.maxWidth=t.maxWidth),t.class&&(r.class=t.class),t.isCompact&&(r.isCompact=t.isCompact),t.isVertical&&(r.isVertical=!0),s instanceof Hi?r.items.bindTo(s).using(a=>a):r.items.addMany(s),o.panelView.children.add(r),r.items.delegate("execute").to(o)}function ea(o,e,t={}){o.isOpen?Kp(o,e,t):o.once("change:isOpen",()=>Kp(o,e,t),{priority:"highest"}),Ol(o,()=>o.listView.items.find(n=>n instanceof qp&&n.children.first.isOn))}function Kp(o,e,t){const n=o.locale,i=o.listView=new ty(n),r=typeof e=="function"?e():e;i.ariaLabel=t.ariaLabel,i.items.bindTo(r).using(s=>{if(s.type==="separator")return new ny(n);if(s.type==="button"||s.type==="switchbutton"){const a=new qp(n);let c;return c=s.type==="button"?new nt(n):new Xs(n),c.bind(...Object.keys(s.model)).to(s.model),c.delegate("execute").to(a),a.children.add(c),a}return null}),o.panelView.children.add(i),i.items.delegate("execute").to(o)}function Ol(o,e){o.on("change:isOpen",()=>{if(!o.isOpen)return;const t=e();t&&(typeof t.focus=="function"?t.focus():x("ui-dropdown-focus-child-on-open-child-missing-focus",{view:t}))},{priority:Ae.low-10})}var Qp=w(8793),ry={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(Qp.Z,ry),Qp.Z.locals;const Zp=gf("px"),Jp=Qe.document.body;class Cn extends We{constructor(e){super(e);const t=this.bindTemplate;this.set("top",0),this.set("left",0),this.set("position","arrow_nw"),this.set("isVisible",!1),this.set("withArrow",!0),this.set("class",void 0),this._pinWhenIsVisibleCallback=null,this.content=this.createCollection(),this.setTemplate({tag:"div",attributes:{class:["ck","ck-balloon-panel",t.to("position",n=>`ck-balloon-panel_${n}`),t.if("isVisible","ck-balloon-panel_visible"),t.if("withArrow","ck-balloon-panel_with-arrow"),t.to("class")],style:{top:t.to("top",Zp),left:t.to("left",Zp)}},children:this.content})}show(){this.isVisible=!0}hide(){this.isVisible=!1}attachTo(e){this.show();const t=Cn.defaultPositions,n=Object.assign({},{element:this.element,positions:[t.southArrowNorth,t.southArrowNorthMiddleWest,t.southArrowNorthMiddleEast,t.southArrowNorthWest,t.southArrowNorthEast,t.northArrowSouth,t.northArrowSouthMiddleWest,t.northArrowSouthMiddleEast,t.northArrowSouthWest,t.northArrowSouthEast,t.viewportStickyNorth],limiter:Jp,fitInViewport:!0},e),i=Cn._getOptimalPosition(n),r=parseInt(i.left),s=parseInt(i.top),a=i.name,c=i.config||{},{withArrow:u=!0}=c;this.top=s,this.left=r,this.position=a,this.withArrow=u}pin(e){this.unpin(),this._pinWhenIsVisibleCallback=()=>{this.isVisible?this._startPinning(e):this._stopPinning()},this._startPinning(e),this.listenTo(this,"change:isVisible",this._pinWhenIsVisibleCallback)}unpin(){this._pinWhenIsVisibleCallback&&(this._stopPinning(),this.stopListening(this,"change:isVisible",this._pinWhenIsVisibleCallback),this._pinWhenIsVisibleCallback=null,this.hide())}_startPinning(e){this.attachTo(e);const t=hu(e.target),n=e.limiter?hu(e.limiter):Jp;this.listenTo(Qe.document,"scroll",(i,r)=>{const s=r.target,a=t&&s.contains(t),c=n&&s.contains(n);!a&&!c&&t&&n||this.attachTo(e)},{useCapture:!0}),this.listenTo(Qe.window,"resize",()=>{this.attachTo(e)})}_stopPinning(){this.stopListening(Qe.document,"scroll"),this.stopListening(Qe.window,"resize")}}function hu(o){return Os(o)?o:ul(o)?o.commonAncestorContainer:typeof o=="function"?hu(o()):null}function Xp(o={}){const{sideOffset:e=Cn.arrowSideOffset,heightOffset:t=Cn.arrowHeightOffset,stickyVerticalOffset:n=Cn.stickyVerticalOffset,config:i}=o;return{northWestArrowSouthWest:(a,c)=>({top:r(a,c),left:a.left-e,name:"arrow_sw",...i&&{config:i}}),northWestArrowSouthMiddleWest:(a,c)=>({top:r(a,c),left:a.left-.25*c.width-e,name:"arrow_smw",...i&&{config:i}}),northWestArrowSouth:(a,c)=>({top:r(a,c),left:a.left-c.width/2,name:"arrow_s",...i&&{config:i}}),northWestArrowSouthMiddleEast:(a,c)=>({top:r(a,c),left:a.left-.75*c.width+e,name:"arrow_sme",...i&&{config:i}}),northWestArrowSouthEast:(a,c)=>({top:r(a,c),left:a.left-c.width+e,name:"arrow_se",...i&&{config:i}}),northArrowSouthWest:(a,c)=>({top:r(a,c),left:a.left+a.width/2-e,name:"arrow_sw",...i&&{config:i}}),northArrowSouthMiddleWest:(a,c)=>({top:r(a,c),left:a.left+a.width/2-.25*c.width-e,name:"arrow_smw",...i&&{config:i}}),northArrowSouth:(a,c)=>({top:r(a,c),left:a.left+a.width/2-c.width/2,name:"arrow_s",...i&&{config:i}}),northArrowSouthMiddleEast:(a,c)=>({top:r(a,c),left:a.left+a.width/2-.75*c.width+e,name:"arrow_sme",...i&&{config:i}}),northArrowSouthEast:(a,c)=>({top:r(a,c),left:a.left+a.width/2-c.width+e,name:"arrow_se",...i&&{config:i}}),northEastArrowSouthWest:(a,c)=>({top:r(a,c),left:a.right-e,name:"arrow_sw",...i&&{config:i}}),northEastArrowSouthMiddleWest:(a,c)=>({top:r(a,c),left:a.right-.25*c.width-e,name:"arrow_smw",...i&&{config:i}}),northEastArrowSouth:(a,c)=>({top:r(a,c),left:a.right-c.width/2,name:"arrow_s",...i&&{config:i}}),northEastArrowSouthMiddleEast:(a,c)=>({top:r(a,c),left:a.right-.75*c.width+e,name:"arrow_sme",...i&&{config:i}}),northEastArrowSouthEast:(a,c)=>({top:r(a,c),left:a.right-c.width+e,name:"arrow_se",...i&&{config:i}}),southWestArrowNorthWest:a=>({top:s(a),left:a.left-e,name:"arrow_nw",...i&&{config:i}}),southWestArrowNorthMiddleWest:(a,c)=>({top:s(a),left:a.left-.25*c.width-e,name:"arrow_nmw",...i&&{config:i}}),southWestArrowNorth:(a,c)=>({top:s(a),left:a.left-c.width/2,name:"arrow_n",...i&&{config:i}}),southWestArrowNorthMiddleEast:(a,c)=>({top:s(a),left:a.left-.75*c.width+e,name:"arrow_nme",...i&&{config:i}}),southWestArrowNorthEast:(a,c)=>({top:s(a),left:a.left-c.width+e,name:"arrow_ne",...i&&{config:i}}),southArrowNorthWest:a=>({top:s(a),left:a.left+a.width/2-e,name:"arrow_nw",...i&&{config:i}}),southArrowNorthMiddleWest:(a,c)=>({top:s(a),left:a.left+a.width/2-.25*c.width-e,name:"arrow_nmw",...i&&{config:i}}),southArrowNorth:(a,c)=>({top:s(a),left:a.left+a.width/2-c.width/2,name:"arrow_n",...i&&{config:i}}),southArrowNorthMiddleEast:(a,c)=>({top:s(a),left:a.left+a.width/2-.75*c.width+e,name:"arrow_nme",...i&&{config:i}}),southArrowNorthEast:(a,c)=>({top:s(a),left:a.left+a.width/2-c.width+e,name:"arrow_ne",...i&&{config:i}}),southEastArrowNorthWest:a=>({top:s(a),left:a.right-e,name:"arrow_nw",...i&&{config:i}}),southEastArrowNorthMiddleWest:(a,c)=>({top:s(a),left:a.right-.25*c.width-e,name:"arrow_nmw",...i&&{config:i}}),southEastArrowNorth:(a,c)=>({top:s(a),left:a.right-c.width/2,name:"arrow_n",...i&&{config:i}}),southEastArrowNorthMiddleEast:(a,c)=>({top:s(a),left:a.right-.75*c.width+e,name:"arrow_nme",...i&&{config:i}}),southEastArrowNorthEast:(a,c)=>({top:s(a),left:a.right-c.width+e,name:"arrow_ne",...i&&{config:i}}),westArrowEast:(a,c)=>({top:a.top+a.height/2-c.height/2,left:a.left-c.width-t,name:"arrow_e",...i&&{config:i}}),eastArrowWest:(a,c)=>({top:a.top+a.height/2-c.height/2,left:a.right+t,name:"arrow_w",...i&&{config:i}}),viewportStickyNorth:(a,c,u)=>a.getIntersection(u)?{top:u.top+n,left:a.left+a.width/2-c.width/2,name:"arrowless",config:{withArrow:!1,...i}}:null};function r(a,c){return a.top-c.height-t}function s(a){return a.bottom+t}}Cn.arrowSideOffset=25,Cn.arrowHeightOffset=10,Cn.stickyVerticalOffset=20,Cn._getOptimalPosition=mf,Cn.defaultPositions=Xp();var em=w(3332),sy={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(em.Z,sy),em.Z.locals;const tm="ck-tooltip";class Jt extends Do(){constructor(e){if(super(),Jt._editors.add(e),Jt._instance)return Jt._instance;Jt._instance=this,this.tooltipTextView=new We(e.locale),this.tooltipTextView.set("text",""),this.tooltipTextView.setTemplate({tag:"span",attributes:{class:["ck","ck-tooltip__text"]},children:[{text:this.tooltipTextView.bindTemplate.to("text")}]}),this.balloonPanelView=new Cn(e.locale),this.balloonPanelView.class=tm,this.balloonPanelView.content.add(this.tooltipTextView),this._resizeObserver=null,this._currentElementWithTooltip=null,this._currentTooltipPosition=null,this._pinTooltipDebounced=Hs(this._pinTooltip,600),this.listenTo(Qe.document,"mouseenter",this._onEnterOrFocus.bind(this),{useCapture:!0}),this.listenTo(Qe.document,"mouseleave",this._onLeaveOrBlur.bind(this),{useCapture:!0}),this.listenTo(Qe.document,"focus",this._onEnterOrFocus.bind(this),{useCapture:!0}),this.listenTo(Qe.document,"blur",this._onLeaveOrBlur.bind(this),{useCapture:!0}),this.listenTo(Qe.document,"scroll",this._onScroll.bind(this),{useCapture:!0}),this._watchdogExcluded=!0}destroy(e){const t=e.ui.view&&e.ui.view.body;Jt._editors.delete(e),this.stopListening(e.ui),t&&t.has(this.balloonPanelView)&&t.remove(this.balloonPanelView),Jt._editors.size||(this._unpinTooltip(),this.balloonPanelView.destroy(),this.stopListening(),Jt._instance=null)}static getPositioningFunctions(e){const t=Jt.defaultBalloonPositions;return{s:[t.southArrowNorth,t.southArrowNorthEast,t.southArrowNorthWest],n:[t.northArrowSouth],e:[t.eastArrowWest],w:[t.westArrowEast],sw:[t.southArrowNorthEast],se:[t.southArrowNorthWest]}[e]}_onEnterOrFocus(e,{target:t}){const n=fu(t);var i;n&&n!==this._currentElementWithTooltip&&(this._unpinTooltip(),this._pinTooltipDebounced(n,{text:(i=n).dataset.ckeTooltipText,position:i.dataset.ckeTooltipPosition||"s",cssClass:i.dataset.ckeTooltipClass||""}))}_onLeaveOrBlur(e,{target:t,relatedTarget:n}){if(e.name==="mouseleave"){if(!Os(t)||this._currentElementWithTooltip&&t!==this._currentElementWithTooltip)return;const i=fu(t),r=fu(n);i&&i!==r&&this._unpinTooltip()}else{if(this._currentElementWithTooltip&&t!==this._currentElementWithTooltip)return;this._unpinTooltip()}}_onScroll(e,{target:t}){this._currentElementWithTooltip&&(t.contains(this.balloonPanelView.element)&&t.contains(this._currentElementWithTooltip)||this._unpinTooltip())}_pinTooltip(e,{text:t,position:n,cssClass:i}){const r=Bt(Jt._editors.values()).ui.view.body;r.has(this.balloonPanelView)||r.add(this.balloonPanelView),this.tooltipTextView.text=t,this.balloonPanelView.pin({target:e,positions:Jt.getPositioningFunctions(n)}),this._resizeObserver=new Dt(e,()=>{Xo(e)||this._unpinTooltip()}),this.balloonPanelView.class=[tm,i].filter(s=>s).join(" ");for(const s of Jt._editors)this.listenTo(s.ui,"update",this._updateTooltipPosition.bind(this),{priority:"low"});this._currentElementWithTooltip=e,this._currentTooltipPosition=n}_unpinTooltip(){this._pinTooltipDebounced.cancel(),this.balloonPanelView.unpin();for(const e of Jt._editors)this.stopListening(e.ui,"update");this._currentElementWithTooltip=null,this._currentTooltipPosition=null,this._resizeObserver&&this._resizeObserver.destroy()}_updateTooltipPosition(){Xo(this._currentElementWithTooltip)?this.balloonPanelView.pin({target:this._currentElementWithTooltip,positions:Jt.getPositioningFunctions(this._currentTooltipPosition)}):this._unpinTooltip()}}function fu(o){return Os(o)?o.closest("[data-cke-tooltip-text]:not([data-cke-tooltip-disabled])"):null}Jt.defaultBalloonPositions=Xp({heightOffset:5,sideOffset:13}),Jt._editors=new Set,Jt._instance=null;class ay extends Ke(){constructor(e){super(),this.editor=e,this.componentFactory=new W1(e),this.focusTracker=new gn,this.tooltipManager=new Jt(e),this.set("viewportOffset",this._readViewportOffsetFromConfig()),this.isReady=!1,this.once("ready",()=>{this.isReady=!0}),this._editableElementsMap=new Map,this._focusableToolbarDefinitions=[],this.listenTo(e.editing.view.document,"layoutChanged",()=>this.update()),this._initFocusTracking()}get element(){return null}update(){this.fire("update")}destroy(){this.stopListening(),this.focusTracker.destroy(),this.tooltipManager.destroy(this.editor);for(const e of this._editableElementsMap.values())e.ckeditorInstance=null;this._editableElementsMap=new Map,this._focusableToolbarDefinitions=[]}setEditableElement(e,t){this._editableElementsMap.set(e,t),t.ckeditorInstance||(t.ckeditorInstance=this.editor),this.focusTracker.add(t);const n=()=>{this.editor.editing.view.getDomRoot(e)||this.editor.keystrokes.listenTo(t)};this.isReady?n():this.once("ready",n)}getEditableElement(e="main"){return this._editableElementsMap.get(e)}getEditableElementsNames(){return this._editableElementsMap.keys()}addToolbar(e,t={}){e.isRendered?(this.focusTracker.add(e.element),this.editor.keystrokes.listenTo(e.element)):e.once("render",()=>{this.focusTracker.add(e.element),this.editor.keystrokes.listenTo(e.element)}),this._focusableToolbarDefinitions.push({toolbarView:e,options:t})}get _editableElements(){return console.warn("editor-ui-deprecated-editable-elements: The EditorUI#_editableElements property has been deprecated and will be removed in the near future.",{editorUI:this}),this._editableElementsMap}_readViewportOffsetFromConfig(){const e=this.editor,t=e.config.get("ui.viewportOffset");if(t)return t;const n=e.config.get("toolbar.viewportTopOffset");return n?(console.warn("editor-ui-deprecated-viewport-offset-config: The `toolbar.vieportTopOffset` configuration option is deprecated. It will be removed from future CKEditor versions. Use `ui.viewportOffset.top` instead."),{top:n}):{top:0}}_initFocusTracking(){const e=this.editor,t=e.editing.view;let n,i;e.keystrokes.set("Alt+F10",(r,s)=>{const a=this.focusTracker.focusedElement;Array.from(this._editableElementsMap.values()).includes(a)&&!Array.from(t.domRoots.values()).includes(a)&&(n=a);const c=this._getCurrentFocusedToolbarDefinition();c&&i||(i=this._getFocusableCandidateToolbarDefinitions());for(let u=0;u<i.length;u++){const f=i.shift();if(i.push(f),f!==c&&this._focusFocusableCandidateToolbar(f)){c&&c.options.afterBlur&&c.options.afterBlur();break}}s()}),e.keystrokes.set("Esc",(r,s)=>{const a=this._getCurrentFocusedToolbarDefinition();a&&(n?(n.focus(),n=null):e.editing.view.focus(),a.options.afterBlur&&a.options.afterBlur(),s())})}_getFocusableCandidateToolbarDefinitions(){const e=[];for(const t of this._focusableToolbarDefinitions){const{toolbarView:n,options:i}=t;(Xo(n.element)||i.beforeFocus)&&e.push(t)}return e.sort((t,n)=>nm(t)-nm(n)),e}_getCurrentFocusedToolbarDefinition(){for(const e of this._focusableToolbarDefinitions)if(e.toolbarView.element&&e.toolbarView.element.contains(this.focusTracker.focusedElement))return e;return null}_focusFocusableCandidateToolbar(e){const{toolbarView:t,options:{beforeFocus:n}}=e;return n&&n(),!!Xo(t.element)&&(t.focus(),!0)}}function nm(o){const{toolbarView:e,options:t}=o;let n=10;return Xo(e.element)&&n--,t.isContextual&&n--,n}var im=w(9688),ly={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(im.Z,ly),im.Z.locals;class cy extends We{constructor(e){super(e),this.body=new R1(e)}render(){super.render(),this.body.attachToDom()}destroy(){return this.body.detachFromDom(),super.destroy()}}var om=w(3662),dy={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(om.Z,dy),om.Z.locals;class rm extends We{constructor(e){super(e),this.set("text",void 0),this.set("for",void 0),this.id=`ck-editor__label_${K()}`;const t=this.bindTemplate;this.setTemplate({tag:"label",attributes:{class:["ck","ck-label"],id:this.id,for:t.to("for")},children:[{text:t.to("text")}]})}}class uy extends We{constructor(e,t,n){super(e),this.setTemplate({tag:"div",attributes:{class:["ck","ck-content","ck-editor__editable","ck-rounded-corners"],lang:e.contentLanguage,dir:e.contentLanguageDirection}}),this.name=null,this.set("isFocused",!1),this._editableElement=n,this._hasExternalElement=!!this._editableElement,this._editingView=t}render(){super.render(),this._hasExternalElement?this.template.apply(this.element=this._editableElement):this._editableElement=this.element,this.on("change:isFocused",()=>this._updateIsFocusedClasses()),this._updateIsFocusedClasses()}destroy(){this._hasExternalElement&&this.template.revert(this._editableElement),super.destroy()}_updateIsFocusedClasses(){const e=this._editingView;function t(n){e.change(i=>{const r=e.document.getRoot(n.name);i.addClass(n.isFocused?"ck-focused":"ck-blurred",r),i.removeClass(n.isFocused?"ck-blurred":"ck-focused",r)})}e.isRenderingInProgress?function n(i){e.once("change:isRenderingInProgress",(r,s,a)=>{a?n(i):t(i)})}(this):t(this)}}class hy extends uy{constructor(e,t,n,i={}){super(e,t,n);const r=e.t;this.extendTemplate({attributes:{role:"textbox",class:"ck-editor__editable_inline"}}),this._generateLabel=i.label||(()=>r("Editor editing area: %0",this.name))}render(){super.render();const e=this._editingView;e.change(t=>{const n=e.document.getRoot(this.name);t.setAttribute("aria-label",this._generateLabel(this),n)})}}var sm=w(8847),fy={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(sm.Z,fy),sm.Z.locals;var am=w(4879),gy={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(am.Z,gy),am.Z.locals;class lm extends We{constructor(e){super(e),this.set("value",void 0),this.set("id",void 0),this.set("placeholder",void 0),this.set("isReadOnly",!1),this.set("hasError",!1),this.set("ariaDescribedById",void 0),this.focusTracker=new gn,this.bind("isFocused").to(this.focusTracker),this.set("isEmpty",!0),this.set("inputMode","text");const t=this.bindTemplate;this.setTemplate({tag:"input",attributes:{class:["ck","ck-input",t.if("isFocused","ck-input_focused"),t.if("isEmpty","ck-input-text_empty"),t.if("hasError","ck-error")],id:t.to("id"),placeholder:t.to("placeholder"),readonly:t.to("isReadOnly"),inputmode:t.to("inputMode"),"aria-invalid":t.if("hasError",!0),"aria-describedby":t.to("ariaDescribedById")},on:{input:t.to((...n)=>{this.fire("input",...n),this._updateIsEmpty()}),change:t.to(this._updateIsEmpty.bind(this))}})}render(){super.render(),this.focusTracker.add(this.element),this._setDomElementValue(this.value),this._updateIsEmpty(),this.on("change:value",(e,t,n)=>{this._setDomElementValue(n),this._updateIsEmpty()})}destroy(){super.destroy(),this.focusTracker.destroy()}select(){this.element.select()}focus(){this.element.focus()}_updateIsEmpty(){this.isEmpty=!this.element.value}_setDomElementValue(e){this.element.value=e||e===0?e:""}}class py extends lm{constructor(e){super(e),this.extendTemplate({attributes:{type:"text",class:["ck-input-text"]}})}}class my extends lm{constructor(e,{min:t,max:n,step:i}={}){super(e);const r=this.bindTemplate;this.set("min",t),this.set("max",n),this.set("step",i),this.extendTemplate({attributes:{type:"number",class:["ck-input-number"],min:r.to("min"),max:r.to("max"),step:r.to("step")}})}}var cm=w(2577),by={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(cm.Z,by),cm.Z.locals;class Rl extends We{constructor(e,t){super(e);const n=`ck-labeled-field-view-${K()}`,i=`ck-labeled-field-view-status-${K()}`;this.fieldView=t(this,n,i),this.set("label",void 0),this.set("isEnabled",!0),this.set("isEmpty",!0),this.set("isFocused",!1),this.set("errorText",null),this.set("infoText",null),this.set("class",void 0),this.set("placeholder",void 0),this.labelView=this._createLabelView(n),this.statusView=this._createStatusView(i),this.fieldWrapperChildren=this.createCollection([this.fieldView,this.labelView]),this.bind("_statusText").to(this,"errorText",this,"infoText",(s,a)=>s||a);const r=this.bindTemplate;this.setTemplate({tag:"div",attributes:{class:["ck","ck-labeled-field-view",r.to("class"),r.if("isEnabled","ck-disabled",s=>!s),r.if("isEmpty","ck-labeled-field-view_empty"),r.if("isFocused","ck-labeled-field-view_focused"),r.if("placeholder","ck-labeled-field-view_placeholder"),r.if("errorText","ck-error")]},children:[{tag:"div",attributes:{class:["ck","ck-labeled-field-view__input-wrapper"]},children:this.fieldWrapperChildren},this.statusView]})}_createLabelView(e){const t=new rm(this.locale);return t.for=e,t.bind("text").to(this,"label"),t}_createStatusView(e){const t=new We(this.locale),n=this.bindTemplate;return t.setTemplate({tag:"div",attributes:{class:["ck","ck-labeled-field-view__status",n.if("errorText","ck-labeled-field-view__status_error"),n.if("_statusText","ck-hidden",i=>!i)],id:e,role:n.if("errorText","alert")},children:[{text:n.to("_statusText")}]}),t}focus(){this.fieldView.focus()}}function gu(o,e,t){const n=new py(o.locale);return n.set({id:e,ariaDescribedById:t}),n.bind("isReadOnly").to(o,"isEnabled",i=>!i),n.bind("hasError").to(o,"errorText",i=>!!i),n.on("input",()=>{o.errorText=null}),o.bind("isEmpty","isFocused","placeholder").to(n),n}function ky(o,e,t){const n=new my(o.locale);return n.set({id:e,ariaDescribedById:t,inputMode:"numeric"}),n.bind("isReadOnly").to(o,"isEnabled",i=>!i),n.bind("hasError").to(o,"errorText",i=>!!i),n.on("input",()=>{o.errorText=null}),o.bind("isEmpty","isFocused","placeholder").to(n),n}class pu extends gl{static get pluginName(){return"Notification"}init(){this.on("show:warning",(e,t)=>{window.alert(t.message)},{priority:"lowest"})}showSuccess(e,t={}){this._showNotification({message:e,type:"success",namespace:t.namespace,title:t.title})}showInfo(e,t={}){this._showNotification({message:e,type:"info",namespace:t.namespace,title:t.title})}showWarning(e,t={}){this._showNotification({message:e,type:"warning",namespace:t.namespace,title:t.title})}_showNotification(e){const t=e.namespace?`show:${e.type}:${e.namespace}`:`show:${e.type}`;this.fire(t,{message:e.message,type:e.type,title:e.title||""})}}class ta extends Ke(){constructor(e,t){super(),t&&fg(this,t),e&&this.set(e)}}var dm=w(4650),wy={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(dm.Z,wy),dm.Z.locals;var um=w(7676),vy={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(um.Z,vy),um.Z.locals;const jl=gf("px");class Fl extends oe{static get pluginName(){return"ContextualBalloon"}constructor(e){super(e),this._view=null,this._rotatorView=null,this._fakePanelsView=null,this.positionLimiter=()=>{const t=this.editor.editing.view,n=t.document.selection.editableElement;return n?t.domConverter.mapViewToDom(n.root):null},this.set("visibleView",null),this._viewToStack=new Map,this._idToStack=new Map,this.set("_numberOfStacks",0),this.set("_singleViewMode",!1),this._rotatorView=null,this._fakePanelsView=null}destroy(){super.destroy(),this._view&&this._view.destroy(),this._rotatorView&&this._rotatorView.destroy(),this._fakePanelsView&&this._fakePanelsView.destroy()}get view(){return this._view||this._createPanelView(),this._view}hasView(e){return Array.from(this._viewToStack.keys()).includes(e)}add(e){if(this._view||this._createPanelView(),this.hasView(e.view))throw new V("contextualballoon-add-view-exist",[this,e]);const t=e.stackId||"main";if(!this._idToStack.has(t))return this._idToStack.set(t,new Map([[e.view,e]])),this._viewToStack.set(e.view,this._idToStack.get(t)),this._numberOfStacks=this._idToStack.size,void(this._visibleStack&&!e.singleViewMode||this.showStack(t));const n=this._idToStack.get(t);e.singleViewMode&&this.showStack(t),n.set(e.view,e),this._viewToStack.set(e.view,n),n===this._visibleStack&&this._showView(e)}remove(e){if(!this.hasView(e))throw new V("contextualballoon-remove-view-not-exist",[this,e]);const t=this._viewToStack.get(e);this._singleViewMode&&this.visibleView===e&&(this._singleViewMode=!1),this.visibleView===e&&(t.size===1?this._idToStack.size>1?this._showNextStack():(this.view.hide(),this.visibleView=null,this._rotatorView.hideView()):this._showView(Array.from(t.values())[t.size-2])),t.size===1?(this._idToStack.delete(this._getStackId(t)),this._numberOfStacks=this._idToStack.size):t.delete(e),this._viewToStack.delete(e)}updatePosition(e){e&&(this._visibleStack.get(this.visibleView).position=e),this.view.pin(this._getBalloonPosition()),this._fakePanelsView.updatePosition()}showStack(e){this.visibleStack=e;const t=this._idToStack.get(e);if(!t)throw new V("contextualballoon-showstack-stack-not-exist",this);this._visibleStack!==t&&this._showView(Array.from(t.values()).pop())}_createPanelView(){this._view=new Cn(this.editor.locale),this.editor.ui.view.body.add(this._view),this.editor.ui.focusTracker.add(this._view.element),this._rotatorView=this._createRotatorView(),this._fakePanelsView=this._createFakePanelsView()}get _visibleStack(){return this._viewToStack.get(this.visibleView)}_getStackId(e){return Array.from(this._idToStack.entries()).find(t=>t[1]===e)[0]}_showNextStack(){const e=Array.from(this._idToStack.values());let t=e.indexOf(this._visibleStack)+1;e[t]||(t=0),this.showStack(this._getStackId(e[t]))}_showPrevStack(){const e=Array.from(this._idToStack.values());let t=e.indexOf(this._visibleStack)-1;e[t]||(t=e.length-1),this.showStack(this._getStackId(e[t]))}_createRotatorView(){const e=new _y(this.editor.locale),t=this.editor.locale.t;return this.view.content.add(e),e.bind("isNavigationVisible").to(this,"_numberOfStacks",this,"_singleViewMode",(n,i)=>!i&&n>1),e.on("change:isNavigationVisible",()=>this.updatePosition(),{priority:"low"}),e.bind("counter").to(this,"visibleView",this,"_numberOfStacks",(n,i)=>{if(i<2)return"";const r=Array.from(this._idToStack.values()).indexOf(this._visibleStack)+1;return t("%0 of %1",[r,i])}),e.buttonNextView.on("execute",()=>{e.focusTracker.isFocused&&this.editor.editing.view.focus(),this._showNextStack()}),e.buttonPrevView.on("execute",()=>{e.focusTracker.isFocused&&this.editor.editing.view.focus(),this._showPrevStack()}),e}_createFakePanelsView(){const e=new Cy(this.editor.locale,this.view);return e.bind("numberOfPanels").to(this,"_numberOfStacks",this,"_singleViewMode",(t,n)=>!n&&t>=2?Math.min(t-1,2):0),e.listenTo(this.view,"change:top",()=>e.updatePosition()),e.listenTo(this.view,"change:left",()=>e.updatePosition()),this.editor.ui.view.body.add(e),e}_showView({view:e,balloonClassName:t="",withArrow:n=!0,singleViewMode:i=!1}){this.view.class=t,this.view.withArrow=n,this._rotatorView.showView(e),this.visibleView=e,this.view.pin(this._getBalloonPosition()),this._fakePanelsView.updatePosition(),i&&(this._singleViewMode=!0)}_getBalloonPosition(){let e=Array.from(this._visibleStack.values()).pop().position;return e&&(e.limiter||(e=Object.assign({},e,{limiter:this.positionLimiter})),e=Object.assign({},e,{viewportOffsetConfig:this.editor.ui.viewportOffset})),e}}class _y extends We{constructor(e){super(e);const t=e.t,n=this.bindTemplate;this.set("isNavigationVisible",!0),this.focusTracker=new gn,this.buttonPrevView=this._createButtonView(t("Previous"),'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11.463 5.187a.888.888 0 1 1 1.254 1.255L9.16 10l3.557 3.557a.888.888 0 1 1-1.254 1.255L7.26 10.61a.888.888 0 0 1 .16-1.382l4.043-4.042z"/></svg>'),this.buttonNextView=this._createButtonView(t("Next"),'<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.537 14.813a.888.888 0 1 1-1.254-1.255L10.84 10 7.283 6.442a.888.888 0 1 1 1.254-1.255L12.74 9.39a.888.888 0 0 1-.16 1.382l-4.043 4.042z"/></svg>'),this.content=this.createCollection(),this.setTemplate({tag:"div",attributes:{class:["ck","ck-balloon-rotator"],"z-index":"-1"},children:[{tag:"div",attributes:{class:["ck-balloon-rotator__navigation",n.to("isNavigationVisible",i=>i?"":"ck-hidden")]},children:[this.buttonPrevView,{tag:"span",attributes:{class:["ck-balloon-rotator__counter"]},children:[{text:n.to("counter")}]},this.buttonNextView]},{tag:"div",attributes:{class:"ck-balloon-rotator__content"},children:this.content}]})}render(){super.render(),this.focusTracker.add(this.element)}destroy(){super.destroy(),this.focusTracker.destroy()}showView(e){this.hideView(),this.content.add(e)}hideView(){this.content.clear()}_createButtonView(e,t){const n=new nt(this.locale);return n.set({label:e,icon:t,tooltip:!0}),n}}class Cy extends We{constructor(e,t){super(e);const n=this.bindTemplate;this.set("top",0),this.set("left",0),this.set("height",0),this.set("width",0),this.set("numberOfPanels",0),this.content=this.createCollection(),this._balloonPanelView=t,this.setTemplate({tag:"div",attributes:{class:["ck-fake-panel",n.to("numberOfPanels",i=>i?"":"ck-hidden")],style:{top:n.to("top",jl),left:n.to("left",jl),width:n.to("width",jl),height:n.to("height",jl)}},children:this.content}),this.on("change:numberOfPanels",(i,r,s,a)=>{s>a?this._addPanels(s-a):this._removePanels(a-s),this.updatePosition()})}_addPanels(e){for(;e--;){const t=new We;t.setTemplate({tag:"div"}),this.content.add(t),this.registerChild(t)}}_removePanels(e){for(;e--;){const t=this.content.last;this.content.remove(t),this.deregisterChild(t),t.destroy()}}updatePosition(){if(this.numberOfPanels){const{top:e,left:t}=this._balloonPanelView,{width:n,height:i}=new vt(this._balloonPanelView.element);Object.assign(this,{top:e,left:t,width:n,height:i})}}}var hm=w(5868),Ay={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(hm.Z,Ay),hm.Z.locals;var fm=w(9695),yy={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};ye()(fm.Z,yy),fm.Z.locals;class xy extends ay{constructor(e,t){super(e),this.view=t}init(){const e=this.editor,t=this.view,n=e.editing.view,i=t.editable,r=n.document.getRoot();i.name=r.rootName,t.render();const s=i.element;this.setEditableElement(i.name,s),t.editable.bind("isFocused").to(this.focusTracker),n.attachDomRoot(s),this._initPlaceholder(),this._initToolbar(),this.fire("ready")}destroy(){super.destroy();const e=this.view;this.editor.editing.view.detachDomRoot(e.editable.name),e.destroy()}_initToolbar(){const e=this.editor,t=this.view;t.toolbar.fillFromConfig(e.config.get("toolbar"),this.componentFactory),this.addToolbar(t.toolbar)}_initPlaceholder(){const e=this.editor,t=e.editing.view,n=t.document.getRoot(),i=e.sourceElement,r=e.config.get("placeholder")||i&&i.tagName.toLowerCase()==="textarea"&&i.getAttribute("placeholder");r&&Pf({view:t,element:n,text:r,isDirectHost:!1,keepOnFocus:!0})}}class Dy extends cy{constructor(e,t,n={}){super(e);const i=e.t;this.toolbar=new uu(e,{shouldGroupWhenFull:n.shouldToolbarGroupWhenFull}),this.editable=new hy(e,t,n.editableElement,{label:r=>i("Rich Text Editor. Editing area: %0",r.name)}),this.toolbar.extendTemplate({attributes:{class:["ck-reset_all","ck-rounded-corners"],dir:e.uiLanguageDirection}})}render(){super.render(),this.registerChild([this.toolbar,this.editable])}}class Ey extends Nl(tu(N1)){constructor(e,t={}){if(!Vl(e)&&t.initialData!==void 0)throw new V("editor-create-initial-data",null);super(t),this.config.get("initialData")===void 0&&this.config.set("initialData",function(r){return Vl(r)?(s=r,s instanceof HTMLTextAreaElement?s.value:s.innerHTML):r;var s}(e)),Vl(e)&&(this.sourceElement=e,function(r){const s=r.sourceElement;if(s){if(s.ckeditorInstance)throw new V("editor-source-element-already-used",r);s.ckeditorInstance=r,r.once("destroy",()=>{delete s.ckeditorInstance})}}(this)),this.model.document.createRoot();const n=!this.config.get("toolbar.shouldNotGroupWhenFull"),i=new Dy(this.locale,this.editing.view,{editableElement:this.sourceElement,shouldToolbarGroupWhenFull:n});this.ui=new xy(this,i)}destroy(){const e=this.getData();return this.ui.destroy(),super.destroy().then(()=>{this.sourceElement&&this.updateSourceElement(e)})}static create(e,t={}){return new Promise(n=>{if(Vl(e)&&e.tagName==="TEXTAREA")throw new V("editor-wrong-element",null);const i=new this(e,t);n(i.initPlugins().then(()=>i.ui.init()).then(()=>i.data.init(i.config.get("initialData"))).then(()=>i.fire("ready")).then(()=>i))})}}function Vl(o){return Os(o)}class mu extends Eo{constructor(e){super(e);const t=this.document;function n(i){return(r,s)=>{s.preventDefault();const a=s.dropRange?[s.dropRange]:null,c=new se(t,i);t.fire(c,{dataTransfer:s.dataTransfer,method:r.name,targetRanges:a,target:s.target}),c.stop.called&&s.stopPropagation()}}this.domEventType=["paste","copy","cut","drop","dragover","dragstart","dragend","dragenter","dragleave"],this.listenTo(t,"paste",n("clipboardInput"),{priority:"low"}),this.listenTo(t,"drop",n("clipboardInput"),{priority:"low"}),this.listenTo(t,"dragover",n("dragging"),{priority:"low"})}onDomEvent(e){const t="clipboardData"in e?e.clipboardData:e.dataTransfer,n=e.type=="drop"||e.type=="paste",i={dataTransfer:new Ag(t,{cacheFiles:n})};e.type!="drop"&&e.type!="dragover"||(i.dropRange=function(r,s){const a=s.target.ownerDocument,c=s.clientX,u=s.clientY;let f;return a.caretRangeFromPoint&&a.caretRangeFromPoint(c,u)?f=a.caretRangeFromPoint(c,u):s.rangeParent&&(f=a.createRange(),f.setStart(s.rangeParent,s.rangeOffset),f.collapse(!0)),f?r.domConverter.domRangeToView(f):null}(this.view,e)),this.fire(e.type,e,i)}}const gm=["figcaption","li"];function pm(o){let e="";if(o.is("$text")||o.is("$textProxy"))e=o.data;else if(o.is("element","img")&&o.hasAttribute("alt"))e=o.getAttribute("alt");else if(o.is("element","br"))e=`
`;else{let t=null;for(const n of o.getChildren()){const i=pm(n);t&&(t.is("containerElement")||n.is("containerElement"))&&(gm.includes(t.name)||gm.includes(n.name)?e+=`
`:e+=`

/*!
 * g.Raphael 0.5 - Charting library, based on Raphaël
 *
 * Copyright (c) 2009 Dmitry Baranovskiy (http://g.raphaeljs.com)
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
 */
Raphael.el.popup=function(d,k,h,g){var c=this.paper||this[0].paper,f,j,b,e,a;if(!c){return}switch(this.type){case"text":case"circle":case"ellipse":b=true;break;default:b=false}d=d==null?"up":d;k=k||5;f=this.getBBox();h=typeof h=="number"?h:(b?f.x+f.width/2:f.x);g=typeof g=="number"?g:(b?f.y+f.height/2:f.y);e=Math.max(f.width/2-k,0);a=Math.max(f.height/2-k,0);this.translate(h-f.x-(b?f.width/2:0),g-f.y-(b?f.height/2:0));f=this.getBBox();var i={up:["M",h,g,"l",-k,-k,-e,0,"a",k,k,0,0,1,-k,-k,"l",0,-f.height,"a",k,k,0,0,1,k,-k,"l",k*2+e*2,0,"a",k,k,0,0,1,k,k,"l",0,f.height,"a",k,k,0,0,1,-k,k,"l",-e,0,"z"].join(","),down:["M",h,g,"l",k,k,e,0,"a",k,k,0,0,1,k,k,"l",0,f.height,"a",k,k,0,0,1,-k,k,"l",-(k*2+e*2),0,"a",k,k,0,0,1,-k,-k,"l",0,-f.height,"a",k,k,0,0,1,k,-k,"l",e,0,"z"].join(","),left:["M",h,g,"l",-k,k,0,a,"a",k,k,0,0,1,-k,k,"l",-f.width,0,"a",k,k,0,0,1,-k,-k,"l",0,-(k*2+a*2),"a",k,k,0,0,1,k,-k,"l",f.width,0,"a",k,k,0,0,1,k,k,"l",0,a,"z"].join(","),right:["M",h,g,"l",k,-k,0,-a,"a",k,k,0,0,1,k,-k,"l",f.width,0,"a",k,k,0,0,1,k,k,"l",0,k*2+a*2,"a",k,k,0,0,1,-k,k,"l",-f.width,0,"a",k,k,0,0,1,-k,-k,"l",0,-a,"z"].join(",")};j={up:{x:-!b*(f.width/2),y:-k*2-(b?f.height/2:f.height)},down:{x:-!b*(f.width/2),y:k*2+(b?f.height/2:f.height)},left:{x:-k*2-(b?f.width/2:f.width),y:-!b*(f.height/2)},right:{x:k*2+(b?f.width/2:f.width),y:-!b*(f.height/2)}}[d];this.translate(j.x,j.y);return c.path(i[d]).attr({fill:"#000",stroke:"none"}).insertBefore(this.node?this:this[0])};Raphael.el.tag=function(f,b,l,k){var i=3,e=this.paper||this[0].paper;if(!e){return}var c=e.path().attr({fill:"#000",stroke:"#000"}),j=this.getBBox(),m,h,a,g;switch(this.type){case"text":case"circle":case"ellipse":a=true;break;default:a=false}f=f||0;l=typeof l=="number"?l:(a?j.x+j.width/2:j.x);k=typeof k=="number"?k:(a?j.y+j.height/2:j.y);b=b==null?5:b;h=0.5522*b;if(j.height>=b*2){c.attr({path:["M",l,k+b,"a",b,b,0,1,1,0,-b*2,b,b,0,1,1,0,b*2,"m",0,-b*2-i,"a",b+i,b+i,0,1,0,0,(b+i)*2,"L",l+b+i,k+j.height/2+i,"l",j.width+2*i,0,0,-j.height-2*i,-j.width-2*i,0,"L",l,k-b-i].join(",")})}else{m=Math.sqrt(Math.pow(b+i,2)-Math.pow(j.height/2+i,2));c.attr({path:["M",l,k+b,"c",-h,0,-b,h-b,-b,-b,0,-h,b-h,-b,b,-b,h,0,b,b-h,b,b,0,h,h-b,b,-b,b,"M",l+m,k-j.height/2-i,"a",b+i,b+i,0,1,0,0,j.height+2*i,"l",b+i-m+j.width+2*i,0,0,-j.height-2*i,"L",l+m,k-j.height/2-i].join(",")})}f=360-f;c.rotate(f,l,k);if(this.attrs){this.attr(this.attrs.x?"x":"cx",l+b+i+(!a?this.type=="text"?j.width:0:j.width/2)).attr("y",a?k:k-j.height/2);this.rotate(f,l,k);f>90&&f<270&&this.attr(this.attrs.x?"x":"cx",l-b-i-(!a?j.width:j.width/2)).rotate(180,l,k)}else{if(f>90&&f<270){this.translate(l-j.x-j.width-b-i,k-j.y-j.height/2);this.rotate(f-180,j.x+j.width+b+i,j.y+j.height/2)}else{this.translate(l-j.x+b+i,k-j.y-j.height/2);this.rotate(f,j.x-b-i,j.y+j.height/2)}}return c.insertBefore(this.node?this:this[0])};Raphael.el.drop=function(d,g,f){var e=this.getBBox(),c=this.paper||this[0].paper,a,j,b,i,h;if(!c){return}switch(this.type){case"text":case"circle":case"ellipse":a=true;break;default:a=false}d=d||0;g=typeof g=="number"?g:(a?e.x+e.width/2:e.x);f=typeof f=="number"?f:(a?e.y+e.height/2:e.y);j=Math.max(e.width,e.height)+Math.min(e.width,e.height);b=c.path(["M",g,f,"l",j,0,"A",j*0.4,j*0.4,0,1,0,g+j*0.7,f-j*0.7,"z"]).attr({fill:"#000",stroke:"none"}).rotate(22.5-d,g,f);d=(d+90)*Math.PI/180;i=(g+j*Math.sin(d))-(a?0:e.width/2);h=(f+j*Math.cos(d))-(a?0:e.height/2);this.attrs?this.attr(this.attrs.x?"x":"cx",i).attr(this.attrs.y?"y":"cy",h):this.translate(i-e.x,h-e.y);return b.insertBefore(this.node?this:this[0])};Raphael.el.flag=function(e,k,j){var g=3,c=this.paper||this[0].paper;if(!c){return}var b=c.path().attr({fill:"#000",stroke:"#000"}),i=this.getBBox(),f=i.height/2,a;switch(this.type){case"text":case"circle":case"ellipse":a=true;break;default:a=false}e=e||0;k=typeof k=="number"?k:(a?i.x+i.width/2:i.x);j=typeof j=="number"?j:(a?i.y+i.height/2:i.y);b.attr({path:["M",k,j,"l",f+g,-f-g,i.width+2*g,0,0,i.height+2*g,-i.width-2*g,0,"z"].join(",")});e=360-e;b.rotate(e,k,j);if(this.attrs){this.attr(this.attrs.x?"x":"cx",k+f+g+(!a?this.type=="text"?i.width:0:i.width/2)).attr("y",a?j:j-i.height/2);this.rotate(e,k,j);e>90&&e<270&&this.attr(this.attrs.x?"x":"cx",k-f-g-(!a?i.width:i.width/2)).rotate(180,k,j)}else{if(e>90&&e<270){this.translate(k-i.x-i.width-f-g,j-i.y-i.height/2);this.rotate(e-180,i.x+i.width+f+g,i.y+i.height/2)}else{this.translate(k-i.x+f+g,j-i.y-i.height/2);this.rotate(e,i.x-f-g,i.y+i.height/2)}}return b.insertBefore(this.node?this:this[0])};Raphael.el.label=function(){var c=this.getBBox(),b=this.paper||this[0].paper,a=Math.min(20,c.width+10,c.height+10)/2;if(!b){return}return b.rect(c.x-a/2,c.y-a/2,c.width+a,c.height+a,a).attr({stroke:"none",fill:"#000"}).insertBefore(this.node?this:this[0])};Raphael.el.blob=function(z,j,i){var g=this.getBBox(),B=Math.PI/180,n=this.paper||this[0].paper,r,A,q;if(!n){return}switch(this.type){case"text":case"circle":case"ellipse":A=true;break;default:A=false}r=n.path().attr({fill:"#000",stroke:"none"});z=(+z+1?z:45)+90;q=Math.min(g.height,g.width);j=typeof j=="number"?j:(A?g.x+g.width/2:g.x);i=typeof i=="number"?i:(A?g.y+g.height/2:g.y);var m=Math.max(g.width+q,q*25/12),t=Math.max(g.height+q,q*25/12),u=j+q*Math.sin((z-22.5)*B),b=i+q*Math.cos((z-22.5)*B),v=j+q*Math.sin((z+22.5)*B),d=i+q*Math.cos((z+22.5)*B),o=(v-u)/2,l=(d-b)/2,f=m/2,e=t/2,s=-Math.sqrt(Math.abs(f*f*e*e-f*f*l*l-e*e*o*o)/(f*f*l*l+e*e*o*o)),c=s*f*l/e+(v+u)/2,a=s*-e*o/f+(d+b)/2;r.attr({x:c,y:a,path:["M",j,i,"L",v,d,"A",f,e,0,1,1,u,b,"z"].join(",")});this.translate(c-g.x-g.width/2,a-g.y-g.height/2);return r.insertBefore(this.node?this:this[0])};Raphael.fn.label=function(a,d,b){var c=this.set();b=this.text(a,d,b).attr(Raphael.g.txtattr);return c.push(b.label(),b)};Raphael.fn.popup=function(a,f,d,b,c){var e=this.set();d=this.text(a,f,d).attr(Raphael.g.txtattr);return e.push(d.popup(b,c),d)};Raphael.fn.tag=function(a,f,d,c,b){var e=this.set();d=this.text(a,f,d).attr(Raphael.g.txtattr);return e.push(d.tag(c,b),d)};Raphael.fn.flag=function(a,e,c,b){var d=this.set();c=this.text(a,e,c).attr(Raphael.g.txtattr);return d.push(c.flag(b),c)};Raphael.fn.drop=function(a,e,c,b){var d=this.set();c=this.text(a,e,c).attr(Raphael.g.txtattr);return d.push(c.drop(b),c)};Raphael.fn.blob=function(a,e,c,b){var d=this.set();c=this.text(a,e,c).attr(Raphael.g.txtattr);return d.push(c.blob(b),c)};Raphael.el.lighter=function(b){b=b||2;var a=[this.attrs.fill,this.attrs.stroke];this.fs=this.fs||[a[0],a[1]];a[0]=Raphael.rgb2hsb(Raphael.getRGB(a[0]).hex);a[1]=Raphael.rgb2hsb(Raphael.getRGB(a[1]).hex);a[0].b=Math.min(a[0].b*b,1);a[0].s=a[0].s/b;a[1].b=Math.min(a[1].b*b,1);a[1].s=a[1].s/b;this.attr({fill:"hsb("+[a[0].h,a[0].s,a[0].b]+")",stroke:"hsb("+[a[1].h,a[1].s,a[1].b]+")"});return this};Raphael.el.darker=function(b){b=b||2;var a=[this.attrs.fill,this.attrs.stroke];this.fs=this.fs||[a[0],a[1]];a[0]=Raphael.rgb2hsb(Raphael.getRGB(a[0]).hex);a[1]=Raphael.rgb2hsb(Raphael.getRGB(a[1]).hex);a[0].s=Math.min(a[0].s*b,1);a[0].b=a[0].b/b;a[1].s=Math.min(a[1].s*b,1);a[1].b=a[1].b/b;this.attr({fill:"hsb("+[a[0].h,a[0].s,a[0].b]+")",stroke:"hsb("+[a[1].h,a[1].s,a[1].b]+")"});return this};Raphael.el.resetBrightness=function(){if(this.fs){this.attr({fill:this.fs[0],stroke:this.fs[1]});delete this.fs}return this};(function(){var c=["lighter","darker","resetBrightness"],a=["popup","tag","flag","label","drop","blob"];for(var b in a){(function(d){Raphael.st[d]=function(){return Raphael.el[d].apply(this,arguments)}})(a[b])}for(var b in c){(function(d){Raphael.st[d]=function(){for(var e=0;e<this.length;e++){this[e][d].apply(this[e],arguments)}return this}})(c[b])}})();Raphael.g={shim:{stroke:"none",fill:"#000","fill-opacity":0},txtattr:{font:"12px Arial, sans-serif",fill:"#fff"},colors:(function(){var c=[0.6,0.2,0.05,0.1333,0.75,0],a=[];for(var b=0;b<10;b++){if(b<c.length){a.push("hsb("+c[b]+",.75, .75)")}else{a.push("hsb("+c[b-c.length]+", 1, .5)")}}return a})(),snapEnds:function(j,k,h){var e=j,l=k;if(e==l){return{from:e,to:l,power:0}}function m(d){return Math.abs(d-0.5)<0.25?~~(d)+0.5:Math.round(d)}var g=(l-e)/h,a=~~(g),c=a,b=0;if(a){while(c){b--;c=~~(g*Math.pow(10,b))/Math.pow(10,b)}b++}else{while(!a){b=b||1;a=~~(g*Math.pow(10,b))/Math.pow(10,b);b++}b&&b--}l=m(k*Math.pow(10,b))/Math.pow(10,b);if(l<k){l=m((k+0.5)*Math.pow(10,b))/Math.pow(10,b)}e=m((j-(b>0?0:0.5))*Math.pow(10,b))/Math.pow(10,b);return{from:e,to:l,power:b}},axis:function(p,o,k,D,e,G,g,J,h,a,q){a=a==null?2:a;h=h||"t";G=G||10;q=arguments[arguments.length-1];var C=h=="|"||h==" "?["M",p+0.5,o,"l",0,0.001]:g==1||g==3?["M",p+0.5,o,"l",0,-k]:["M",p,o+0.5,"l",k,0],s=this.snapEnds(D,e,G),H=s.from,z=s.to,F=s.power,E=0,w={font:"11px 'Fontin Sans', Fontin-Sans, sans-serif"},v=q.set(),I;I=(z-H)/G;var n=H,m=F>0?F:0;r=k/G;if(+g==1||+g==3){var b=o,u=(g-1?1:-1)*(a+3+!!(g-1));while(b>=o-k){h!="-"&&h!=" "&&(C=C.concat(["M",p-(h=="+"||h=="|"?a:!(g-1)*a*2),b+0.5,"l",a*2+1,0]));v.push(q.text(p+u,b,(J&&J[E++])||(Math.round(n)==n?n:+n.toFixed(m))).attr(w).attr({"text-anchor":g-1?"start":"end"}));n+=I;b-=r}if(Math.round(b+r-(o-k))){h!="-"&&h!=" "&&(C=C.concat(["M",p-(h=="+"||h=="|"?a:!(g-1)*a*2),o-k+0.5,"l",a*2+1,0]));v.push(q.text(p+u,o-k,(J&&J[E])||(Math.round(n)==n?n:+n.toFixed(m))).attr(w).attr({"text-anchor":g-1?"start":"end"}))}}else{n=H;m=(F>0)*F;u=(g?-1:1)*(a+9+!g);var c=p,r=k/G,A=0,B=0;while(c<=p+k){h!="-"&&h!=" "&&(C=C.concat(["M",c+0.5,o-(h=="+"?a:!!g*a*2),"l",0,a*2+1]));v.push(A=q.text(c,o+u,(J&&J[E++])||(Math.round(n)==n?n:+n.toFixed(m))).attr(w));var l=A.getBBox();if(B>=l.x-5){v.pop(v.length-1).remove()}else{B=l.x+l.width}n+=I;c+=r}if(Math.round(c-r-p-k)){h!="-"&&h!=" "&&(C=C.concat(["M",p+k+0.5,o-(h=="+"?a:!!g*a*2),"l",0,a*2+1]));v.push(q.text(p+k,o+u,(J&&J[E])||(Math.round(n)==n?n:+n.toFixed(m))).attr(w))}}var K=q.path(C);K.text=v;K.all=q.set([K,v]);K.remove=function(){this.text.remove();this.constructor.prototype.remove.call(this)};return K},labelise:function(a,c,b){if(a){return(a+"").replace(/(##+(?:\.#+)?)|(%%+(?:\.%+)?)/g,function(d,f,e){if(f){return(+c).toFixed(f.replace(/^#+\.?/g,"").length)}if(e){return(c*100/b).toFixed(e.replace(/^%+\.?/g,"").length)+"%"}})}else{return(+c).toFixed(0)}}};

/*!
 * g.line-min.js
 * g.Raphael 0.5 - Charting library, based on Raphaël
 *
 * Copyright (c) 2009 Dmitry Baranovskiy (http://g.raphaeljs.com)
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
 */
(function(){function a(g,n){var f=g.length/n,h=0,e=f,m=0,i=[];while(h<g.length){e--;if(e<0){m+=g[h]*(1+e);i.push(m/f);m=g[h++]*-e;e+=f}else{m+=g[h++]}}return i}function d(f,e,p,n,k,j){var h=(p-f)/2,g=(k-p)/2,q=Math.atan((p-f)/Math.abs(n-e)),o=Math.atan((k-p)/Math.abs(n-j));q=e<n?Math.PI-q:q;o=j<n?Math.PI-o:o;var i=Math.PI/2-((q+o)%(Math.PI*2))/2,s=h*Math.sin(i+q),m=h*Math.cos(i+q),r=g*Math.sin(i+o),l=g*Math.cos(i+o);return{x1:p-s,y1:n+m,x2:p+r,y2:n+l}}function b(f,P,O,e,h,A,z,J){var s=this;J=J||{};if(!f.raphael.is(A[0],"array")){A=[A]}if(!f.raphael.is(z[0],"array")){z=[z]}var q=J.gutter||10,B=Math.max(A[0].length,z[0].length),t=J.symbol||"",S=J.colors||s.colors,v=null,p=null,ad=f.set(),T=[];for(var ac=0,L=z.length;ac<L;ac++){B=Math.max(B,z[ac].length)}var ae=f.set();for(ac=0,L=z.length;ac<L;ac++){if(J.shade){ae.push(f.path().attr({stroke:"none",fill:S[ac],opacity:J.nostroke?1:0.3}))}if(z[ac].length>e-2*q){z[ac]=a(z[ac],e-2*q);B=e-2*q}if(A[ac]&&A[ac].length>e-2*q){A[ac]=a(A[ac],e-2*q)}}var W=Array.prototype.concat.apply([],A),U=Array.prototype.concat.apply([],z),u=s.snapEnds(Math.min.apply(Math,W),Math.max.apply(Math,W),A[0].length-1),E=u.from,o=u.to,N=s.snapEnds(Math.min.apply(Math,U),Math.max.apply(Math,U),z[0].length-1),C=N.from,n=N.to,Z=(e-q*2)/((o-E)||1),V=(h-q*2)/((n-C)||1);var G=f.set();if(J.axis){var m=(J.axis+"").split(/[,\s]+/);+m[0]&&G.push(s.axis(P+q,O+q,e-2*q,E,o,J.axisxstep||Math.floor((e-2*q)/20),2,f));+m[1]&&G.push(s.axis(P+e-q,O+h-q,h-2*q,C,n,J.axisystep||Math.floor((h-2*q)/20),3,f));+m[2]&&G.push(s.axis(P+q,O+h-q,e-2*q,E,o,J.axisxstep||Math.floor((e-2*q)/20),0,f));+m[3]&&G.push(s.axis(P+q,O+h-q,h-2*q,C,n,J.axisystep||Math.floor((h-2*q)/20),1,f))}var M=f.set(),aa=f.set(),r;for(ac=0,L=z.length;ac<L;ac++){if(!J.nostroke){M.push(r=f.path().attr({stroke:S[ac],"stroke-width":J.width||2,"stroke-linejoin":"round","stroke-linecap":"round","stroke-dasharray":J.dash||""}))}var g=Raphael.is(t,"array")?t[ac]:t,H=f.set();T=[];for(var ab=0,w=z[ac].length;ab<w;ab++){var l=P+q+((A[ac]||A[0])[ab]-E)*Z,k=O+h-q-(z[ac][ab]-C)*V;(Raphael.is(g,"array")?g[ab]:g)&&H.push(f[Raphael.is(g,"array")?g[ab]:g](l,k,(J.width||2)*3).attr({fill:S[ac],stroke:"none"}));if(J.smooth){if(ab&&ab!=w-1){var R=P+q+((A[ac]||A[0])[ab-1]-E)*Z,F=O+h-q-(z[ac][ab-1]-C)*V,Q=P+q+((A[ac]||A[0])[ab+1]-E)*Z,D=O+h-q-(z[ac][ab+1]-C)*V,af=d(R,F,l,k,Q,D);T=T.concat([af.x1,af.y1,l,k,af.x2,af.y2])}if(!ab){T=["M",l,k,"C",l,k]}}else{T=T.concat([ab?"L":"M",l,k])}}if(J.smooth){T=T.concat([l,k,l,k])}aa.push(H);if(J.shade){ae[ac].attr({path:T.concat(["L",l,O+h-q,"L",P+q+((A[ac]||A[0])[0]-E)*Z,O+h-q,"z"]).join(",")})}!J.nostroke&&r.attr({path:T.join(",")})}function K(an){var ak=[];for(var al=0,ap=A.length;al<ap;al++){ak=ak.concat(A[al])}ak.sort();var aq=[],ah=[];for(al=0,ap=ak.length;al<ap;al++){ak[al]!=ak[al-1]&&aq.push(ak[al])&&ah.push(P+q+(ak[al]-E)*Z)}ak=aq;ap=ak.length;var ag=an||f.set();for(al=0;al<ap;al++){var Y=ah[al]-(ah[al]-(ah[al-1]||P))/2,ao=((ah[al+1]||P+e)-ah[al])/2+(ah[al]-(ah[al-1]||P))/2,x;an?(x={}):ag.push(x=f.rect(Y-1,O,Math.max(ao+1,1),h).attr({stroke:"none",fill:"#000",opacity:0}));x.values=[];x.symbols=f.set();x.y=[];x.x=ah[al];x.axis=ak[al];for(var aj=0,am=z.length;aj<am;aj++){aq=A[aj]||A[0];for(var ai=0,y=aq.length;ai<y;ai++){if(aq[ai]==ak[al]){x.values.push(z[aj][ai]);x.y.push(O+h-q-(z[aj][ai]-C)*V);x.symbols.push(ad.symbols[aj][ai])}}}an&&an.call(x)}!an&&(v=ag)}function I(al){var ah=al||f.set(),x;for(var aj=0,an=z.length;aj<an;aj++){for(var ai=0,ak=z[aj].length;ai<ak;ai++){var ag=P+q+((A[aj]||A[0])[ai]-E)*Z,am=P+q+((A[aj]||A[0])[ai?ai-1:1]-E)*Z,y=O+h-q-(z[aj][ai]-C)*V;al?(x={}):ah.push(x=f.circle(ag,y,Math.abs(am-ag)/2).attr({stroke:"none",fill:"#000",opacity:0}));x.x=ag;x.y=y;x.value=z[aj][ai];x.line=ad.lines[aj];x.shade=ad.shades[aj];x.symbol=ad.symbols[aj][ai];x.symbols=ad.symbols[aj];x.axis=(A[aj]||A[0])[ai];al&&al.call(x)}}!al&&(p=ah)}ad.push(M,ae,aa,G,v,p);ad.lines=M;ad.shades=ae;ad.symbols=aa;ad.axis=G;ad.hoverColumn=function(j,i){!v&&K();v.mouseover(j).mouseout(i);return this};ad.clickColumn=function(i){!v&&K();v.click(i);return this};ad.hrefColumn=function(Y){var ag=f.raphael.is(arguments[0],"array")?arguments[0]:arguments;if(!(arguments.length-1)&&typeof Y=="object"){for(var j in Y){for(var y=0,X=v.length;y<X;y++){if(v[y].axis==j){v[y].attr("href",Y[j])}}}}!v&&K();for(y=0,X=ag.length;y<X;y++){v[y]&&v[y].attr("href",ag[y])}return this};ad.hover=function(j,i){!p&&I();p.mouseover(j).mouseout(i);return this};ad.click=function(i){!p&&I();p.click(i);return this};ad.each=function(i){I(i);return this};ad.eachColumn=function(i){K(i);return this};return ad}var c=function(){};c.prototype=Raphael.g;b.prototype=new c;Raphael.fn.linechart=function(f,k,g,e,j,i,h){return new b(this,f,k,g,e,j,i,h)}})();

/*!
 * g.pie-min.js
 * g.Raphael 0.5 - Charting library, based on Raphaël
 *
 * Copyright (c) 2009 Dmitry Baranovskiy (http://g.raphaeljs.com)
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
 */
(function(){function b(n,h,g,t,e,o){o=o||{};var c=this,q=[],k=n.set(),s=n.set(),m=n.set(),x=[],z=e.length,A=0,D=0,C=0,f=9,B=true;function w(I,H,i,K,G,P){var M=Math.PI/180,E=I+i*Math.cos(-K*M),p=I+i*Math.cos(-G*M),J=I+i/2*Math.cos(-(K+(G-K)/2)*M),O=H+i*Math.sin(-K*M),N=H+i*Math.sin(-G*M),F=H+i/2*Math.sin(-(K+(G-K)/2)*M),L=["M",I,H,"L",E,O,"A",i,i,0,+(Math.abs(G-K)>180),1,p,N,"z"];L.middle={x:J,y:F};return L}s.covers=k;if(z==1){m.push(n.circle(h,g,t).attr({fill:c.colors[0],stroke:o.stroke||"#fff","stroke-width":o.strokewidth==null?1:o.strokewidth}));k.push(n.circle(h,g,t).attr(c.shim));D=e[0];e[0]={value:e[0],order:0,valueOf:function(){return this.value}};m[0].middle={x:h,y:g};m[0].mangle=180}else{for(var y=0;y<z;y++){D+=e[y];e[y]={value:e[y],order:y,valueOf:function(){return this.value}}}e.sort(function(p,i){return i.value-p.value});for(y=0;y<z;y++){if(B&&e[y]*360/D<=1.5){f=y;B=false}if(y>f){B=false;e[f].value+=e[y];e[f].others=true;C=e[f].value}}z=Math.min(f+1,e.length);C&&e.splice(z)&&(e[f].others=true);for(y=0;y<z;y++){var j=A-360*e[y]/D/2;if(!y){A=90-j;j=A-360*e[y]/D/2}if(o.init){var l=w(h,g,1,A,A-360*e[y]/D).join(",")}var v=w(h,g,t,A,A-=360*e[y]/D);var u=n.path(o.init?l:v).attr({fill:o.colors&&o.colors[y]||c.colors[y]||"#666",stroke:o.stroke||"#fff","stroke-width":(o.strokewidth==null?1:o.strokewidth),"stroke-linejoin":"round"});u.value=e[y];u.middle=v.middle;u.mangle=j;q.push(u);m.push(u);o.init&&u.animate({path:v.join(",")},(+o.init-1)||1000,">")}for(y=0;y<z;y++){u=n.path(q[y].attr("path")).attr(c.shim);o.href&&o.href[y]&&u.attr({href:o.href[y]});u.attr=function(){};k.push(u);m.push(u)}}s.hover=function(F,r){r=r||function(){};var E=this;for(var p=0;p<z;p++){(function(G,H,i){var I={sector:G,cover:H,cx:h,cy:g,mx:G.middle.x,my:G.middle.y,mangle:G.mangle,r:t,value:e[i],total:D,label:E.labels&&E.labels[i]};H.mouseover(function(){F.call(I)}).mouseout(function(){r.call(I)})})(m[p],k[p],p)}return this};s.each=function(E){var r=this;for(var p=0;p<z;p++){(function(F,G,i){var H={sector:F,cover:G,cx:h,cy:g,x:F.middle.x,y:F.middle.y,mangle:F.mangle,r:t,value:e[i],total:D,label:r.labels&&r.labels[i]};E.call(H)})(m[p],k[p],p)}return this};s.click=function(E){var r=this;for(var p=0;p<z;p++){(function(F,G,i){var H={sector:F,cover:G,cx:h,cy:g,mx:F.middle.x,my:F.middle.y,mangle:F.mangle,r:t,value:e[i],total:D,label:r.labels&&r.labels[i]};G.click(function(){E.call(H)})})(m[p],k[p],p)}return this};s.inject=function(i){i.insertBefore(k[0])};var d=function(J,E,r,p){var N=h+t+t/5,M=g,I=M+10;J=J||[];p=(p&&p.toLowerCase&&p.toLowerCase())||"east";r=n[r&&r.toLowerCase()]||"circle";s.labels=n.set();for(var H=0;H<z;H++){var O=m[H].attr("fill"),F=e[H].order,G;e[H].others&&(J[F]=E||"Others");J[F]=c.labelise(J[F],e[H],D);s.labels.push(n.set());s.labels[H].push(n[r](N+5,I,5).attr({fill:O,stroke:"none"}));s.labels[H].push(G=n.text(N+20,I,J[F]||e[F]).attr(c.txtattr).attr({fill:o.legendcolor||"#000","text-anchor":"start"}));k[H].label=s.labels[H];I+=G.getBBox().height*1.2}var K=s.labels.getBBox(),L={east:[0,-K.height/2],west:[-K.width-2*t-20,-K.height/2],north:[-t-K.width/2,-t-K.height-10],south:[-t-K.width/2,t+10]}[p];s.labels.translate.apply(s.labels,L);s.push(s.labels)};if(o.legend){d(o.legend,o.legendothers,o.legendmark,o.legendpos)}s.push(m,k);s.series=m;s.covers=k;return s}var a=function(){};a.prototype=Raphael.g;b.prototype=new a;Raphael.fn.piechart=function(c,g,f,d,e){return new b(this,c,g,f,d,e)}})();

/*!
 * g.bar-min.js
 * g.Raphael 0.5 - Charting library, based on Raphaël
 *
 * Copyright (c) 2009 Dmitry Baranovskiy (http://g.raphaeljs.com)
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) license.
 */
(function(){var f=Math.min,a=Math.max;function e(o,m,h,p,j,k,l,i){var s,n={round:"round",sharp:"sharp",soft:"soft",square:"square"};if((j&&!p)||(!j&&!h)){return l?"":i.path()}k=n[k]||"square";p=Math.round(p);h=Math.round(h);o=Math.round(o);m=Math.round(m);switch(k){case"round":if(!j){var g=~~(p/2);if(h<g){g=h;s=["M",o+0.5,m+0.5-~~(p/2),"l",0,0,"a",g,~~(p/2),0,0,1,0,p,"l",0,0,"z"]}else{s=["M",o+0.5,m+0.5-g,"l",h-g,0,"a",g,g,0,1,1,0,p,"l",g-h,0,"z"]}}else{g=~~(h/2);if(p<g){g=p;s=["M",o-~~(h/2),m,"l",0,0,"a",~~(h/2),g,0,0,1,h,0,"l",0,0,"z"]}else{s=["M",o-g,m,"l",0,g-p,"a",g,g,0,1,1,h,0,"l",0,p-g,"z"]}}break;case"sharp":if(!j){var q=~~(p/2);s=["M",o,m+q,"l",0,-p,a(h-q,0),0,f(q,h),q,-f(q,h),q+(q*2<p),"z"]}else{q=~~(h/2);s=["M",o+q,m,"l",-h,0,0,-a(p-q,0),q,-f(q,p),q,f(q,p),q,"z"]}break;case"square":if(!j){s=["M",o,m+~~(p/2),"l",0,-p,h,0,0,p,"z"]}else{s=["M",o+~~(h/2),m,"l",1-h,0,0,-p,h-1,0,"z"]}break;case"soft":if(!j){g=f(h,Math.round(p/5));s=["M",o+0.5,m+0.5-~~(p/2),"l",h-g,0,"a",g,g,0,0,1,g,g,"l",0,p-g*2,"a",g,g,0,0,1,-g,g,"l",g-h,0,"z"]}else{g=f(Math.round(h/5),p);s=["M",o-~~(h/2),m,"l",0,g-p,"a",g,g,0,0,1,g,-g,"l",h-2*g,0,"a",g,g,0,0,1,g,g,"l",0,p-g,"z"]}}if(l){return s.join(",")}else{return i.path(s)}}function d(l,J,H,g,m,V,D){D=D||{};var z=this,W=D.type||"square",u=parseFloat(D.gutter||"20%"),T=l.set(),E=l.set(),n=l.set(),B=l.set(),F=Math.max.apply(Math,V),U=[],I=0,M=D.colors||z.colors,A=V.length;if(Raphael.is(V[0],"array")){F=[];I=A;A=0;for(var R=V.length;R--;){E.push(l.set());F.push(Math.max.apply(Math,V[R]));A=Math.max(A,V[R].length)}if(D.stacked){for(var R=A;R--;){var r=0;for(var Q=V.length;Q--;){r+=+V[Q][R]||0}U.push(r)}}for(var R=V.length;R--;){if(V[R].length<A){for(var Q=A;Q--;){V[R].push(0)}}}F=Math.max.apply(Math,D.stacked?U:F)}F=(D.to)||F;var K=g/(A*(100+u)+u)*100,k=K*u/100,p=D.vgutter==null?20:D.vgutter,C=[],q=J+k,o=(m-2*p)/F;if(!D.stretch){k=Math.round(k);K=Math.floor(K)}!D.stacked&&(K/=I||1);for(var R=0;R<A;R++){C=[];for(var Q=0;Q<(I||1);Q++){var S=Math.round((I?V[Q][R]:V[R])*o),t=H+m-p-S,O=e(Math.round(q+K/2),t+S,K,S,true,W,null,l).attr({stroke:"none",fill:M[I?Q:R]});if(I){E[Q].push(O)}else{E.push(O)}O.y=t;O.x=Math.round(q+K/2);O.w=K;O.h=S;O.value=I?V[Q][R]:V[R];if(!D.stacked){q+=K}else{C.push(O)}}if(D.stacked){var P;B.push(P=l.rect(C[0].x-C[0].w/2,H,K,m).attr(z.shim));P.bars=l.set();var v=0;for(var L=C.length;L--;){C[L].toFront()}for(var L=0,w=C.length;L<w;L++){var O=C[L],G,S=(v+O.value)*o,N=e(O.x,H+m-p-!!v*0.5,K,S,true,W,1,l);P.bars.push(O);v&&O.attr({path:N});O.h=S;O.y=H+m-p-!!v*0.5-S;n.push(G=l.rect(O.x-O.w/2,O.y,K,O.value*o).attr(z.shim));G.bar=O;G.value=O.value;v+=O.value}q+=K}q+=k}B.toFront();q=J+k;if(!D.stacked){for(var R=0;R<A;R++){for(var Q=0;Q<(I||1);Q++){var G;n.push(G=l.rect(Math.round(q),H+p,K,m-p).attr(z.shim));G.bar=I?E[Q][R]:E[R];G.value=G.bar.value;q+=K}q+=k}}T.label=function(y,Z){y=y||[];this.labels=l.set();var aa,h=-Infinity;if(D.stacked){for(var x=0;x<A;x++){var X=0;for(var s=0;s<(I||1);s++){X+=I?V[s][x]:V[x];if(s==I-1){var ab=l.labelise(y[x],X,F);aa=l.text(E[x*(I||1)+s].x,H+m-p/2,ab).attr(txtattr).insertBefore(n[x*(I||1)+s]);var Y=aa.getBBox();if(Y.x-7<h){aa.remove()}else{this.labels.push(aa);h=Y.x+Y.width}}}}}else{for(var x=0;x<A;x++){for(var s=0;s<(I||1);s++){var ab=l.labelise(I?y[s]&&y[s][x]:y[x],I?V[s][x]:V[x],F);aa=l.text(E[x*(I||1)+s].x,Z?H+m-p/2:E[x*(I||1)+s].y-10,ab).attr(txtattr).insertBefore(n[x*(I||1)+s]);var Y=aa.getBBox();if(Y.x-7<h){aa.remove()}else{this.labels.push(aa);h=Y.x+Y.width}}}}return this};T.hover=function(i,h){B.hide();n.show();n.mouseover(i).mouseout(h);return this};T.hoverColumn=function(i,h){n.hide();B.show();h=h||function(){};B.mouseover(i).mouseout(h);return this};T.click=function(h){B.hide();n.show();n.click(h);return this};T.each=function(j){if(!Raphael.is(j,"function")){return this}for(var h=n.length;h--;){j.call(n[h])}return this};T.eachColumn=function(j){if(!Raphael.is(j,"function")){return this}for(var h=B.length;h--;){j.call(B[h])}return this};T.clickColumn=function(h){n.hide();B.show();B.click(h);return this};T.push(E,n,B);T.bars=E;T.covers=n;return T}function b(w,v,u,I,F,l,B){B=B||{};var h=this,n=B.type||"square",o=parseFloat(B.gutter||"20%"),D=w.set(),H=w.set(),q=w.set(),L=w.set(),T=Math.max.apply(Math,l),g=[],J=0,t=B.colors||h.colors,O=l.length;if(Raphael.is(l[0],"array")){T=[];J=O;O=0;for(var N=l.length;N--;){H.push(w.set());T.push(Math.max.apply(Math,l[N]));O=Math.max(O,l[N].length)}if(B.stacked){for(var N=O;N--;){var z=0;for(var M=l.length;M--;){z+=+l[M][N]||0}g.push(z)}}for(var N=l.length;N--;){if(l[N].length<O){for(var M=O;M--;){l[N].push(0)}}}T=Math.max.apply(Math,B.stacked?g:T)}T=(B.to)||T;var Q=Math.floor(F/(O*(100+o)+o)*100),r=Math.floor(Q*o/100),p=[],k=u+r,m=(I-1)/T;!B.stacked&&(Q/=J||1);for(var N=0;N<O;N++){p=[];for(var M=0;M<(J||1);M++){var S=J?l[M][N]:l[N],P=e(v,k+Q/2,Math.round(S*m),Q-1,false,n,null,w).attr({stroke:"none",fill:t[J?M:N]});if(J){H[M].push(P)}else{H.push(P)}P.x=v+Math.round(S*m);P.y=k+Q/2;P.w=Math.round(S*m);P.h=Q;P.value=+S;if(!B.stacked){k+=Q}else{p.push(P)}}if(B.stacked){var A=w.rect(v,p[0].y-p[0].h/2,I,Q).attr(h.shim);L.push(A);A.bars=w.set();var E=0;for(var C=p.length;C--;){p[C].toFront()}for(var C=0,K=p.length;C<K;C++){var P=p[C],R,S=Math.round((E+P.value)*m),G=e(v,P.y,S,Q-1,false,n,1,w);A.bars.push(P);E&&P.attr({path:G});P.w=S;P.x=v+S;q.push(R=w.rect(v+E*m,P.y-P.h/2,P.value*m,Q).attr(h.shim));R.bar=P;E+=P.value}k+=Q}k+=r}L.toFront();k=u+r;if(!B.stacked){for(var N=0;N<O;N++){for(var M=0;M<(J||1);M++){var R=w.rect(v,k,I,Q).attr(h.shim);q.push(R);R.bar=J?H[M][N]:H[N];R.value=R.bar.value;k+=Q}k+=r}}D.label=function(Z,W){Z=Z||[];this.labels=w.set();for(var V=0;V<O;V++){for(var U=0;U<J;U++){var y=w.labelise(J?Z[U]&&Z[U][V]:Z[V],J?l[U][V]:l[V],T),Y=W?H[V*(J||1)+U].x-Q/2+3:v+5,x=W?"end":"start",s;this.labels.push(s=w.text(Y,H[V*(J||1)+U].y,y).attr(txtattr).attr({"text-anchor":x}).insertBefore(q[0]));if(s.getBBox().x<v+5){s.attr({x:v+5,"text-anchor":"start"})}else{H[V*(J||1)+U].label=s}}}return this};D.hover=function(j,i){L.hide();q.show();i=i||function(){};q.mouseover(j).mouseout(i);return this};D.hoverColumn=function(j,i){q.hide();L.show();i=i||function(){};L.mouseover(j).mouseout(i);return this};D.each=function(s){if(!Raphael.is(s,"function")){return this}for(var j=q.length;j--;){s.call(q[j])}return this};D.eachColumn=function(s){if(!Raphael.is(s,"function")){return this}for(var j=L.length;j--;){s.call(L[j])}return this};D.click=function(i){L.hide();q.show();q.click(i);return this};D.clickColumn=function(i){q.hide();L.show();L.click(i);return this};D.push(H,q,L);D.bars=H;D.covers=q;return D}var c=function(){};c.prototype=Raphael.g;b.prototype=d.prototype=new c;Raphael.fn.hbarchart=function(h,l,j,g,i,k){return new b(this,h,l,j,g,i,k)};Raphael.fn.barchart=function(h,l,j,g,i,k){return new d(this,h,l,j,g,i,k)}})();

/***
 * A function that takes some object data and converts it into a graph inside the specified element id.
 * @author Samuel Giles
 */
jQuery.extend((function(){
	
	var createSalesChart = function(inId, json, message){
		var days = json;
		var width = ((days.data.length + 1) * 100) / 2;
		var r = Raphael(inId, width + 170, 600);
		
		var message = message || "Sales figures for week begining: "
		// Build X axis defaults:
		var x = [];
		
		for (var i = 0; i < days.data.length; ++i) {
			x.push(i);
		}

		// Short days of the week.
		var xaxis = ["Thur", "Fri", "Sat", "Sun", "Mon", "Tue", "Wed"];
		
		r.text(190,10, message + days.startDate + " / " + days.month + " / " + days.year);
		var data = r.linechart(50, 20, width, 200, x, days.data, { 
					nostroke: false, 
					axis: "0 0 1 1",
					axisxstep: days.data.length - 1, 
					axisystep: 7,
					symbol: "circle", 
					axisxlabels: xaxis, 
					smooth: true 
				   }).hover(function () {
					   this.marker = this.marker || r.tag(this.x, this.y, "£" + this.value, 0, 5).insertBefore(this);
					   this.marker.show();
					}, function () {
					   this.marker && this.marker.hide();
					});
		
		var xAxes = data.axis[0].text.items;
		
		
		var start = new Date(days.year, days.month, days.startDate);
		
		
		for (var i in xAxes) {
			xAxes[i].attr({'text': xaxis[start.getDay()] + " " + start.getDate()});
			start.setDate(start.getDate() + 1);
		}
		
	};
	
	return {
		salesChart : createSalesChart
	};
}()));
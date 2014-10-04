!function(d){var k=function(a,b){this.element=d(a);this.format=c.parseFormat(b.format||this.element.data("date-format")||"mm/dd/yyyy");this.picker=d(c.template).appendTo("body").on({click:d.proxy(this.click,this)});this.isInput=this.element.is("input");this.component=this.element.is(".date")?this.element.find(".add-on"):!1;if(this.isInput)this.element.on({focus:d.proxy(this.show,this),keyup:d.proxy(this.update,this)});else if(this.component)this.component.on("click",d.proxy(this.show,this));else this.element.on("click",
d.proxy(this.show,this));this.minViewMode=b.minViewMode||this.element.data("date-minviewmode")||0;if("string"===typeof this.minViewMode)switch(this.minViewMode){case "months":this.minViewMode=1;break;case "years":this.minViewMode=2;break;default:this.minViewMode=0}this.viewMode=b.viewMode||this.element.data("date-viewmode")||0;if("string"===typeof this.viewMode)switch(this.viewMode){case "months":this.viewMode=1;break;case "years":this.viewMode=2;break;default:this.viewMode=0}this.startViewMode=this.viewMode;
this.weekStart=b.weekStart||this.element.data("date-weekstart")||0;this.weekEnd=0===this.weekStart?6:this.weekStart-1;this.onRender=b.onRender;this.fillDow();this.fillMonths();this.update();this.showMode()};k.prototype={constructor:k,show:function(a){this.picker.show();this.height=this.component?this.component.outerHeight():this.element.outerHeight();this.place();d(window).on("resize",d.proxy(this.place,this));a&&(a.stopPropagation(),a.preventDefault());var b=this;d(document).on("mousedown",function(a){0==
d(a.target).closest(".datepicker").length&&b.hide()});this.element.trigger({type:"show",date:this.date})},hide:function(){this.picker.hide();d(window).off("resize",this.place);this.viewMode=this.startViewMode;this.showMode();this.isInput||d(document).off("mousedown",this.hide);this.element.trigger({type:"hide",date:this.date})},set:function(){var a=c.formatDate(this.date,this.format);this.isInput?this.element.prop("value",a):(this.component&&this.element.find("input").prop("value",a),this.element.data("date",
a))},setValue:function(a){this.date="string"===typeof a?c.parseDate(a,this.format):new Date(a);this.set();this.viewDate=new Date(this.date.getFullYear(),this.date.getMonth(),1,0,0,0,0);this.fill()},place:function(){var a=this.component?this.component.offset():this.element.offset();this.picker.css({top:a.top+this.height,left:a.left})},update:function(a){this.date=c.parseDate("string"===typeof a?a:this.isInput?this.element.prop("value"):this.element.data("date"),this.format);this.viewDate=new Date(this.date.getFullYear(),
this.date.getMonth(),1,0,0,0,0);this.fill()},fillDow:function(){for(var a=this.weekStart,b="<tr>";a<this.weekStart+7;)b+='<th class="dow">'+c.dates.daysMin[a++%7]+"</th>";b+="</tr>";this.picker.find(".datepicker-days thead").append(b)},fillMonths:function(){for(var a="",b=0;12>b;)a+='<span class="month">'+c.dates.monthsShort[b++]+"</span>";this.picker.find(".datepicker-months td").append(a)},fill:function(){var a=new Date(this.viewDate),b=a.getFullYear(),f=a.getMonth(),m=this.date.valueOf();this.picker.find(".datepicker-days th:eq(1)").text(c.dates.months[f]+
" "+b);var e=new Date(b,f-1,28,0,0,0,0),a=c.getDaysInMonth(e.getFullYear(),e.getMonth());e.setDate(a);e.setDate(a-(e.getDay()-this.weekStart+7)%7);var d=new Date(e);d.setDate(d.getDate()+42);for(var d=d.valueOf(),a=[],g,h,l;e.valueOf()<d;){e.getDay()===this.weekStart&&a.push("<tr>");g=this.onRender(e);h=e.getFullYear();l=e.getMonth();if(l<f&&h===b||h<b)g+=" old";else if(l>f&&h===b||h>b)g+=" new";e.valueOf()===m&&(g+=" active");a.push('<td class="day '+g+'">'+e.getDate()+"</td>");e.getDay()===this.weekEnd&&
a.push("</tr>");e.setDate(e.getDate()+1)}this.picker.find(".datepicker-days tbody").empty().append(a.join(""));f=this.date.getFullYear();a=this.picker.find(".datepicker-months").find("th:eq(1)").text(b).end().find("span").removeClass("active");f===b&&a.eq(this.date.getMonth()).addClass("active");a="";b=10*parseInt(b/10,10);m=this.picker.find(".datepicker-years").find("th:eq(1)").text(b+"-"+(b+9)).end().find("td");b-=1;for(e=-1;11>e;e++)a+='<span class="year'+(-1===e||10===e?" old":"")+(f===b?" active":
"")+'">'+b+"</span>",b+=1;m.html(a)},click:function(a){a.stopPropagation();a.preventDefault();var b=d(a.target).closest("span, td, th");if(1===b.length)switch(b[0].nodeName.toLowerCase()){case "th":switch(b[0].className){case "switch":this.showMode(1);break;case "prev":case "next":this.viewDate["set"+c.modes[this.viewMode].navFnc].call(this.viewDate,this.viewDate["get"+c.modes[this.viewMode].navFnc].call(this.viewDate)+c.modes[this.viewMode].navStep*("prev"===b[0].className?-1:1)),this.fill(),this.set()}break;
case "span":b.is(".month")?(a=b.parent().find("span").index(b),this.viewDate.setMonth(a)):(b=parseInt(b.text(),10)||0,this.viewDate.setFullYear(b));0!==this.viewMode&&(this.date=new Date(this.viewDate),this.element.trigger({type:"changeDate",date:this.date,viewMode:c.modes[this.viewMode].clsName}));this.showMode(-1);this.fill();this.set();break;case "td":if(b.is(".day")&&!b.is(".disabled")){var f=parseInt(b.text(),10)||1;a=this.viewDate.getMonth();b.is(".old")?a-=1:b.is(".new")&&(a+=1);b=this.viewDate.getFullYear();
this.date=new Date(b,a,f,0,0,0,0);this.viewDate=new Date(b,a,Math.min(28,f),0,0,0,0);this.fill();this.set();this.element.trigger({type:"changeDate",date:this.date,viewMode:c.modes[this.viewMode].clsName})}}},mousedown:function(a){a.stopPropagation();a.preventDefault()},showMode:function(a){a&&(this.viewMode=Math.max(this.minViewMode,Math.min(2,this.viewMode+a)));this.picker.find(">div").hide().filter(".datepicker-"+c.modes[this.viewMode].clsName).show()}};d.fn.datepicker=function(a,b){return this.each(function(){var f=
d(this),c=f.data("datepicker"),e="object"===typeof a&&a;c||f.data("datepicker",c=new k(this,d.extend({},d.fn.datepicker.defaults,e)));if("string"===typeof a)c[a](b)})};d.fn.datepicker.defaults={onRender:function(a){return""}};d.fn.datepicker.Constructor=k;var c={modes:[{clsName:"days",navFnc:"Month",navStep:1},{clsName:"months",navFnc:"FullYear",navStep:1},{clsName:"years",navFnc:"FullYear",navStep:10}],dates:{days:"Sunday Monday Tuesday Wednesday Thursday Friday Saturday Sunday".split(" "),daysShort:"Sun Mon Tue Wed Thu Fri Sat Sun".split(" "),
daysMin:"Su Mo Tu We Th Fr Sa Su".split(" "),months:"January February March April May June July August September October November December".split(" "),monthsShort:"Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" ")},isLeapYear:function(a){return 0===a%4&&0!==a%100||0===a%400},getDaysInMonth:function(a,b){return[31,c.isLeapYear(a)?29:28,31,30,31,30,31,31,30,31,30,31][b]},parseFormat:function(a){var b=a.match(/[.\/\-\s].*?/);a=a.split(/\W+/);if(!b||!a||0===a.length)throw Error("Invalid date format.");
return{separator:b,parts:a}},parseDate:function(a,b){var d=a.split(b.separator);a=new Date;var c;a.setHours(0);a.setMinutes(0);a.setSeconds(0);a.setMilliseconds(0);if(d.length===b.parts.length){for(var e=a.getFullYear(),k=a.getDate(),g=a.getMonth(),h=0,l=b.parts.length;h<l;h++)switch(c=parseInt(d[h],10)||1,b.parts[h]){case "dd":case "d":k=c;a.setDate(c);break;case "mm":case "m":g=c-1;a.setMonth(c-1);break;case "yy":e=2E3+c;a.setFullYear(2E3+c);break;case "yyyy":e=c,a.setFullYear(c)}a=new Date(e,g,
k,0,0,0)}return a},formatDate:function(a,b){var c={d:a.getDate(),m:a.getMonth()+1,yy:a.getFullYear().toString().substring(2),yyyy:a.getFullYear()};c.dd=(10>c.d?"0":"")+c.d;c.mm=(10>c.m?"0":"")+c.m;a=[];for(var d=0,e=b.parts.length;d<e;d++)a.push(c[b.parts[d]]);return a.join(b.separator)},headTemplate:'<thead><tr><th class="prev">&lsaquo;</th><th colspan="5" class="switch"></th><th class="next">&rsaquo;</th></tr></thead>',contTemplate:'<tbody><tr><td colspan="7"></td></tr></tbody>'};c.template='<div class="datepicker dropdown-menu"><div class="datepicker-days"><table class=" table-condensed">'+
c.headTemplate+'<tbody></tbody></table></div><div class="datepicker-months"><table class="table-condensed">'+c.headTemplate+c.contTemplate+'</table></div><div class="datepicker-years"><table class="table-condensed">'+c.headTemplate+c.contTemplate+"</table></div></div>"}(window.jQuery);
!function(a){a(function(){a(".action-meta-active").metaActive(),a(".action-meta-tabs").metaTabs(),a(".action-body-tabs").bodyTabs()}),a.fn.metaActive=function(){this.each(function(){function f(){e.hasClass("active")?d.addClass("collapse"):d.removeClass("collapse")}function g(){b.prop("checked")===!0?e.fadeIn(400,function(){a(this).addClass("active")}):e.fadeOut(400,function(){a(this).removeClass("active")})}var b=a(this),c=b.parent().parent().parent().parent().parent(),d=c.find(".toggle-indicator"),e=a("#"+b.prop("id")+"-active");g(),f(),b.on("click",function(){g(),f()})})},a.fn.metaTabs=function(){this.each(function(){function e(){b.find(".tabs-meta-link").removeClass("current"),b.find('.tabs-meta-link[data-tabs-link="'+d.data("tabs-link")+'"]').addClass("current"),b.find(".tabs-meta-main").css("display","none"),b.find(".tabs-meta-main").removeClass("current"),b.find('.tabs-meta-main[data-tabs-main="'+d.data("tabs-link")+'"]').fadeIn(0,function(){a(this).addClass("current")})}var b=a(this),c=b.find(".tabs-meta-link"),d=c.first();e(),c.on("click",function(){d=a(this),e()})})},a.fn.bodyTabs=function(){this.each(function(){function e(){b.find(".tabs-body-link").removeClass("current"),b.find('.tabs-body-link[data-tabs-link="'+d.data("tabs-link")+'"]').addClass("current"),b.find(".tabs-body-main").css("display","none"),b.find(".tabs-body-main").removeClass("current"),b.find('.tabs-body-main[data-tabs-main="'+d.data("tabs-link")+'"]').fadeIn(0,function(){a(this).addClass("current")})}var b=a(this),c=b.find(".tabs-body-link"),d=c.first();e(),c.on("click",function(){d=a(this),e()})})}}(jQuery);
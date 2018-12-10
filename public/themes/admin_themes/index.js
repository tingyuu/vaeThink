// +----------------------------------------------------------------------
// | vaeThink [ Programming makes me happy ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.vaeThink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 听雨 < 389625819@qq.com >
// +---------------------------------------------------------------------
layui.config({
    base: '/themes/admin_themes/module/'
}).define(['element','jquery','vaeyo','colorpicker','form'], function(exports){
    var vaeyo = layui.vaeyo,$ = layui.jquery,element = layui.element,colorpicker = layui.colorpicker,form = layui.form;

    var thetab = layui.sessionData('vaeyoAdmin_tab');
    if(thetab.vaeyoTab &&　thetab.vaeyoTab.length > 0){
    	for (var i = thetab.vaeyoTab.length - 1; i >= 0; i--) {
    		vaeyo.addTab({
				elem:"vaeyo-tab",
				title:thetab.vaeyoTab[i].name,
				content:thetab.vaeyoTab[i].src,
				id:thetab.vaeyoTab[i].id
			})
    	}
    	vaeyo.changeTab(thetab.vaeyoTab[0].id);
    }

	var theme = layui.data('vaeyoAdmin_theme').color;
	if(theme){
		// $('.vaeyo-menulist,.vaeyo-menulist .vaeyo-menulist-2 .layui-icon,.vaeyo-menulist .vaeyo-menulist-3 .layui-icon').css('color', theme[1]);
	 //    $('.layui-layout-admin .layui-header,.layui-layout-admin .layui-side,.vaeyo-tab .layui-tab-title').css('background-color', theme[0]);
	    $('.layui-layout-admin .layui-logo').css('color', theme[1]);
	    $('.layui-layout-admin .layui-logo').css('background-color', theme[0]);
	}

	$(document).ready(function(){
		$(".vaeyo-menulist-2").click(function(){ 
			$(this).next("div").slideToggle("slow")   
			.siblings(".vaeyo-menulist-3:visible").slideUp("slow");
			$(this).children("i").attr("class","layui-icon layui-icon-triangle-d");
			$(this).siblings(".vaeyo-menulist-2").children("i").attr("class","layui-icon layui-icon-triangle-r");
		});
	});

	$("[vaeyo_tab]").on('click', function(e){
		var thetab = layui.sessionData('vaeyoAdmin_tab');
	    if(thetab.vaeyoTab &&　thetab.vaeyoTab.length > 0){
	    	var fromid = thetab.vaeyoTab[0].id,fromsrc = thetab.vaeyoTab[0].src;
	    } else {
	    	var fromid = null,fromsrc = null;
	    }
		vaeyo.addTab({
			elem:"vaeyo-tab",
			title:$(this).attr('vae-title'),
			content:$(this).attr('vae-src'),
			id:$(this).attr('vae-id'),
			fromid:fromid,
			fromsrc:fromsrc
		})
		vaeyo.recordTab();
	});

	$('#0').load(function(){
		setTimeout(function(){
			$('#0').contents().find("[vaeyo_tab]").on('click', function(){
		        vaeyo.addTab({
		            elem:"vaeyo-tab",
		            title:$(this).attr('vae-title'),
		            content:$(this).attr('vae-src'),
		            id:$(this).attr('vae-id')
		        })
		        vaeyo.recordTab();
		    })
		},500)
	})
	
	element.on('tabDelete(vaeyo-tab)', function(data){
		var lastthetab = layui.sessionData('vaeyoAdmin_tab');
		if(lastthetab.vaeyoTab &&lastthetab.vaeyoTab.length > 0){
			var html = $('.vaeyo-tab [lay-id='+lastthetab.vaeyoTab[1].id+']').click();
	    } else {
	    	vaeyo.changeTab(0);
	    }
	  	vaeyo.recordTab();
	});

	$("[vaeyo-home]").on('click', function(){
		var thetabs = layui.sessionData('vaeyoAdmin_tab');
		if(thetabs.vaeyoTab &&　thetabs.vaeyoTab.length > 1){
	    	for (var i = thetabs.vaeyoTab.length; i > 1; i--) {
	    		if(thetabs.vaeyoTab[i-1].id != 0){
	    			element.tabDelete('vaeyo-tab', thetabs.vaeyoTab[i-1].id);
	    		}
	    	}
	    }
	    //$('.vaeyo-tab [lay-id="0"]').click();
		// $(".vaeyo-menulist-2").children("i").attr("class","layui-icon layui-icon-triangle-r");
		// $(".vaeyo-menulist-3:visible").slideUp("slow");
		return false;
	})

	$("[vaeyo-refresh]").on('click', function(){
		if($(this).hasClass("refreshThis")){
			$("[vaeyo-loading]").show();
			$(this).removeClass("refreshThis");
			var iframe = $(".layui-tab-item.layui-show").find("iframe")[0];
			if(iframe){
				var src = parent.document.getElementById(iframe.id).contentWindow.location.href ? parent.document.getElementById(iframe.id).contentWindow.location.href : iframe.src;
				document.getElementById(iframe.id).src=src;
			}
			setTimeout(function(){
				$("[vaeyo-loading]").hide();
			},500)
			setTimeout(function(){
				$("[vaeyo-refresh]").attr("class","refreshThis");
			},1000)
		}else{
			layer.tips("每秒只可刷新一次",this, {
			  tips: 1
			});
		}
		return false;
	})

	$("[vaeyo-del-cache]").on('click', function(e){
		var that = $(this);
		if(that.attr('class') === 'clearThis'){
			layer.tips('正在努力清理中...',this);
			return false;
		}
		$("[vaeyo-loading]").show();
		layer.tips('正在清理系统缓存...',this);
		that.attr('class','clearThis');
		$.ajax({
		  	url:"/admin/api/cacheClear",
		  	success:function(res){
		  		if(res.code == 1){
		  			setTimeout(function(){
		  				that.attr('class','');
		  				layer.tips(res.msg,that);
		  				$("[vaeyo-loading]").hide();
		  			},1000)
		  		} else {
		  			layer.tips(res.msg,that);
		  			$("[vaeyo-loading]").hide();
		  		}
		  	}
		})
	})

	element.on('tab(vaeyo-tab)', function(data){
	  vaeyo.changeTab($(this).attr('lay-id'));
	  vaeyo.recordTab();
	});

	colorpicker.render({
	    elem: '#vaeyo-color'
	    ,color: theme ? theme[0] : '#1E9FFF'
	    ,format: 'rgb'
	    ,predefine: true
	    ,alpha: true
	    ,size: "xs"
	    ,done: function(color){
	      layer.msg("换个颜色换种心情");
	    }
	    ,change: function(color){
	    	var RgbValue = color.replace("rgba(", "").replace(")", "");
	    	var RgbValueArry = RgbValue.split(",");
	    	var $grayLevel = RgbValueArry[0] * 0.299 + RgbValueArry[1] * 0.587 + RgbValueArry[2] * 0.114;
	    	var thatColor;
	    	if ($grayLevel >= 192) { 
	    		thatColor = "#000";
			} else {
			　　thatColor = "#fff";
			}
			// $('.vaeyo-menulist,.vaeyo-menulist .vaeyo-menulist-2 .layui-icon,.vaeyo-menulist .vaeyo-menulist-3 .layui-icon').css('color', thatColor);
	  //       $('.layui-layout-admin .layui-header,.layui-layout-admin .layui-side,.vaeyo-tab .layui-tab-title').css('background-color', color);
	        $('.layui-layout-admin .layui-logo').css('color', thatColor);
	        $('.layui-layout-admin .layui-logo').css('background-color', color);
	        layui.data('vaeyoAdmin_theme', {
			  key: 'color'
			  ,value: [color,thatColor]
			});
			layer.msg("主题设置成功,双击右上角按钮可恢复默认");
	    }
	});

	$('#vaeyo-color').on('dblclick', function(e){
		layui.data('vaeyoAdmin_theme', {
		  key: 'color'
		  ,remove: true
		});
		// $('.vaeyo-menulist,.vaeyo-menulist .vaeyo-menulist-2 .layui-icon,.vaeyo-menulist .vaeyo-menulist-3 .layui-icon').css('color', "#000");
	 //    $('.layui-layout-admin .layui-header,.vaeyo-tab .layui-tab-title').css('background-color', "#000");
	 //    $('.layui-layout-admin .layui-side').css('background-color', "#f0f0f0");
	    $('.layui-layout-admin .layui-logo').css('color', '#fff');
	    $('.layui-layout-admin .layui-logo').css('background-color', '#1E9FFF');
		layer.msg("主题已成功恢复默认");
	})

    exports('index', {});
});  
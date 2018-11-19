// +----------------------------------------------------------------------
// | vaeThink [ Programming makes me happy ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.vaeThink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 听雨 < 389625819@qq.com >
// +---------------------------------------------------------------------
layui.define(['layer','element','form'], function(exports){ 
	var layer = layui.layer,$ = layui.$,element = layui.element,form = layui.form,MOD_NAME = 'element', THIS = 'layui-this', SHOW = 'layui-show';

  	var obj = {
    	addTab: function(e){
        var self = this;
    		var elem = $(".vaeyo-tab .layui-tab-title li[lay-id="+e.id+"]");
    		if(elem.length>0){
    			element.tabChange(e.elem, e.id);
    			return false;
    		}
            $("[vaeyo-loading]").show();
            element.tabAdd(e.elem, {
              title: e.title
              ,content: '<iframe id="'+e.id+'" name="'+e.title+'" src="'+e.content+'" frameborder="0" align="left" width="100%" height="100%" scrolling="yes"></iframe>'
              ,id: e.id
            });
            
            element.tabChange(e.elem, e.id);
            var frm = document.getElementById(e.id);  
            $(frm).load(function(){ 
                setTimeout(function(){
                    $("[vaeyo-loading]").hide();
                    $('#'+e.id).contents().find("[vaeyo_tab]").on('click', function(){
                        self.addTab({
                            elem:"vaeyo-tab",
                            title:$(this).attr('vae-title'),
                            content:$(this).attr('vae-src'),
                            id:$(this).attr('vae-id')
                        })
                        self.recordTab();
                    }) 
                },500)
            }); 
    	},
    	changeTab: function(e){
    		if(e == 0){
    			$(".vaeyo-menulist-2").children("i").attr("class","layui-icon layui-icon-triangle-r");
				$(".vaeyo-menulist-3:visible").slideUp("slow");
				return false;
    		}
    		var elem = $(".vaeyo-menulist ul li[vae-id="+e+"]");
            var theme = "#8dacc4";
    		$(".vaeyo-menulist-3 ul li").css('color',theme);
            elem.css('color',"#fff");
            elem.siblings(".vaeyo-menulist-3:visible").slideUp("slow");
            elem.siblings(".vaeyo-menulist-2").children("i").attr("class","layui-icon layui-icon-triangle-r");
    		elem.parents(".vaeyo-menulist-3").show("show").siblings(".vaeyo-menulist-3:visible").slideUp("slow");
			elem.parents(".vaeyo-menulist-3").siblings(".vaeyo-menulist-2").children("i").attr("class","layui-icon layui-icon-triangle-r");
			elem.parents(".vaeyo-menulist-3").prev(".vaeyo-menulist-2").children("i").attr("class","layui-icon layui-icon-triangle-d");
    	},
        recordTab: function(e){
            var tab = $('[vaeyo-tab-content]',parent.document).find("iframe");
            var thatIframe = $(".layui-tab-item.layui-show",parent.document).find("iframe")[0];
            var tabs = [];
            var thatObj = {
                id:thatIframe.id,
                name:thatIframe.name,
                src:thatIframe.src 
            }
            tabs.push(thatObj);
            var nums = 1;
            for (var i = tab.length - 1; i >= 0; i--) {
                if(tab[i].id !== 0 && tab[i].id != thatIframe.id){
                    var obj = {
                        id:tab[i].id,
                        name:tab[i].name,
                        src:tab[i].src 
                    }
                    tabs.push(obj);
                    nums++;
                }
            }
            if(nums==10){
                layer.tips('点击这里可以关闭全部TAB',$('[vaeyo-home]',parent.document),{tips: 1});
            }
            layui.sessionData('vaeyoAdmin_tab', {
                key: 'vaeyoTab'
                ,value: tabs
            });
        },
        getParam: function(name){
             var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
             var r = window.location.search.substr(1).match(reg);
             if(r!=null)return  unescape(r[2]); return null;
        },
        closeThisTab: function(){
            $('.vaeyo-tab .layui-tab-title .layui-this i',parent.document).click();
        }
  	};
  
    exports('vaeyo', obj);
});    
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
        tabAdd: function(filter, options){
            var self = this;
            var TITLE = '.layui-tab-title'
            ,tabElem = $('.layui-tab[lay-filter='+ filter +']',parent.document)
            ,titElem = tabElem.children(TITLE)
            ,barElem = titElem.children('.layui-tab-bar')
            ,contElem = tabElem.children('.layui-tab-content')
            ,li = '<li lay-id="'+ (options.id||'') +'"'
            +(options.attr ? ' lay-attr="'+ options.attr +'"' : '') +'>'+ (options.title||'unnaming') +'</li>';
            
            barElem[0] ? barElem.before(li) : titElem.append(li);
            contElem.append('<div class="layui-tab-item">'+ (options.content||'') +'</div>');
            call.hideTabMore(true);
            call.tabAuto();
            return this;
        },
        tabChange: function(filter, layid){
            var TITLE = '.layui-tab-title'
            ,tabElem = $('.layui-tab[lay-filter='+ filter +']',parent.document)
            ,titElem = tabElem.children(TITLE)
            ,liElem = titElem.find('>li[lay-id="'+ layid +'"]');
            call.tabClick.call(liElem[0], null, null, liElem);
            return this;
        },
    	addTab: function(e){
        var self = this;
    		var elem = $(".vaeyo-tab .layui-tab-title li[lay-id="+e.id+"]");
    		if(elem.length>0){
    			element.tabChange(e.elem, e.id);
    			return false;
    		}
            $("[vaeyo-loading]").show();
            self.tabAdd(e.elem, {
              title: e.title
              ,content: '<iframe id="'+e.id+'" name="'+e.title+'" src="'+e.content+'" fromid="'+e.fromid+'" fromsrc="'+e.fromsrc+'" frameborder="0" align="left" width="100%" height="100%" scrolling="yes"></iframe>'
              ,id: e.id
            });
            
            self.tabChange(e.elem, e.id);
            var frm = document.getElementById(e.id);  
            $(frm).load(function(){

                var thetab = layui.sessionData('vaeyoAdmin_tab');
                if(thetab.vaeyoTab &&　thetab.vaeyoTab.length > 0){
                  var fromid = thetab.vaeyoTab[0].id,fromsrc = thetab.vaeyoTab[0].src;
                } else {
                  var fromid = null,fromsrc = null;
                }
                setTimeout(function(){
                    $("[vaeyo-loading]").hide();
                    $('#'+e.id).contents().find("[vaeyo_tab]").on('click', function(){
                        self.addTab({
                            elem:"vaeyo-tab",
                            title:$(this).attr('vae-title'),
                            content:$(this).attr('vae-src'),
                            id:$(this).attr('vae-id'),
                            fromid:fromid,
                            fromsrc:fromsrc
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
                src:thatIframe.src,
                fromid:$('#'+thatIframe.id,parent.document).attr('fromid'),
                fromsrc:$('#'+thatIframe.id,parent.document).attr('fromsrc')
            }
            tabs.push(thatObj);
            var nums = 1;
            for (var i = tab.length-1; i >= 0; i--) {
                if(tab[i].id !== 0 && tab[i].id != thatIframe.id){
                    var obj = {
                        id:tab[i].id,
                        name:tab[i].name,
                        src:tab[i].src,
                        fromid:$('#'+tab[i].id,parent.document).attr('fromid'),
                        fromsrc:$('#'+tab[i].id,parent.document).attr('fromsrc')
                    }
                    tabs.push(obj);
                    nums++;
                }
            }
            if(nums==10){
                layer.tips('点击这里可以关闭其他TAB',$('[vaeyo-home]',parent.document),{tips: 1});
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
        },
        backThisTab: function(){
            history.back(-1);
        },
        bundledTab: function(){
            var self = this;
            var thetab = layui.sessionData('vaeyoAdmin_tab');
            if(thetab.vaeyoTab &&　thetab.vaeyoTab.length > 0){
              var fromid = thetab.vaeyoTab[0].id,fromsrc = thetab.vaeyoTab[0].src;
            } else {
              var fromid = null,fromsrc = null;
            }
            setTimeout(function(){
                $("[vaeyo_tab]").on('click', function(){
                    self.addTab({
                        elem:"vaeyo-tab",
                        title:$(this).attr('vae-title'),
                        content:$(this).attr('vae-src'),
                        id:$(this).attr('vae-id'),
                        fromid:fromid,
                        fromsrc:fromsrc
                    })
                    self.recordTab();
                }) 
            },500)
        },
  	};

    //基础事件体
      var call = {
        //Tab点击
        tabClick: function(e, index, liElem, options){
          options = options || {};
          var othis = liElem || $(this)
          ,index = index || othis.parent().children('li').index(othis)
          ,parents = options.headerElem ? othis.parent() : othis.parents('.layui-tab').eq(0)
          ,item = options.bodyElem ? $(options.bodyElem) : parents.children('.layui-tab-content').children('.layui-tab-item')
          ,elemA = othis.find('a')
          ,filter = parents.attr('lay-filter');
          
          if(!(elemA.attr('href') !== 'javascript:;' && elemA.attr('target') === '_blank')){
            othis.addClass(THIS).siblings().removeClass(THIS);
            item.eq(index).addClass(SHOW).siblings().removeClass(SHOW);
          }
          
          layui.event.call(this, MOD_NAME, 'tab('+ filter +')', {
            elem: parents
            ,index: index
          });
        }
        
        //Tab删除
        ,tabDelete: function(e, othis){
          var li = othis || $(this).parent(), index = li.index()
          ,parents = li.parents('.layui-tab').eq(0)
          ,item = parents.children('.layui-tab-content').children('.layui-tab-item')
          ,filter = parents.attr('lay-filter');
          
          if(li.hasClass(THIS)){
            if(li.next()[0]){
              call.tabClick.call(li.next()[0], null, index + 1);
            } else if(li.prev()[0]){
              call.tabClick.call(li.prev()[0], null, index - 1);
            }
          }
          
          li.remove();
          item.eq(index).remove();
          setTimeout(function(){
            call.tabAuto();
          }, 50);
          
          layui.event.call(this, MOD_NAME, 'tabDelete('+ filter +')', {
            elem: parents
            ,index: index
          });
        }
        
        //Tab自适应
        ,tabAuto: function(){
          var SCROLL = 'layui-tab-scroll', MORE = 'layui-tab-more', BAR = 'layui-tab-bar'
          ,CLOSE = 'layui-tab-close', that = this;
          
          $('.layui-tab',parent.document).each(function(){
            var othis = $(this)
            ,title = othis.children('.layui-tab-title')
            ,item = othis.children('.layui-tab-content').children('.layui-tab-item')
            ,STOPE = 'lay-stope="tabmore"'
            ,span = $('<span class="layui-unselect layui-tab-bar" '+ STOPE +'><i '+ STOPE +' class="layui-icon">&#xe61a;</i></span>',parent.document);

            if(that === window && device.ie != 8){
              call.hideTabMore(true)
            }
            
            //允许关闭
            if(othis.attr('lay-allowClose')){
              title.find('li').each(function(){
                var li = $(this);
                if(!li.find('.'+CLOSE)[0]){
                  var close = $('<i class="layui-icon layui-unselect '+ CLOSE +'">&#x1006;</i>');
                  close.on('click', call.tabDelete);
                  li.append(close);
                }
              });
            }
            
            if(typeof othis.attr('lay-unauto') === 'string') return;
            
            //响应式
            if(title.prop('scrollWidth') > title.outerWidth()+1){
              if(title.find('.'+BAR)[0]) return;
              title.append(span);
              othis.attr('overflow', '');
              span.on('click', function(e){
                title[this.title ? 'removeClass' : 'addClass'](MORE);
                this.title = this.title ? '' : '收缩';
              });
            } else {
              title.find('.'+BAR).remove();
              othis.removeAttr('overflow');
            }
          });
        }
        //隐藏更多Tab
        ,hideTabMore: function(e){
          var tsbTitle = $('.layui-tab-title');
          if(e === true || $(e.target).attr('lay-stope') !== 'tabmore'){
            tsbTitle.removeClass('layui-tab-more');
            tsbTitle.find('.layui-tab-bar').attr('title','');
          }
        }
        
        //点击一级菜单
        /*
        ,clickThis: function(){
          var othis = $(this), parents = othis.parents(NAV_ELEM)
          ,filter = parents.attr('lay-filter')
          ,elemA = othis.find('a')
          ,unselect = typeof othis.attr('lay-unselect') === 'string';

          if(othis.find('.'+NAV_CHILD)[0]) return;
          
          if(!(elemA.attr('href') !== 'javascript:;' && elemA.attr('target') === '_blank') && !unselect){
            parents.find('.'+THIS).removeClass(THIS);
            othis.addClass(THIS);
          }
          
          layui.event.call(this, MOD_NAME, 'nav('+ filter +')', othis);
        }
        )
        */
        
        //点击菜单 - a标签触发
        ,clickThis: function(){
          var othis = $(this)
          ,parents = othis.parents(NAV_ELEM)
          ,filter = parents.attr('lay-filter')
          ,parent = othis.parent() 
          ,child = othis.siblings('.'+NAV_CHILD)
          ,unselect = typeof parent.attr('lay-unselect') === 'string';
          
          if(!(othis.attr('href') !== 'javascript:;' && othis.attr('target') === '_blank') && !unselect){
            if(!child[0]){
              parents.find('.'+THIS).removeClass(THIS);
              parent.addClass(THIS);
            }
          }
          
          //如果是垂直菜单
          if(parents.hasClass(NAV_TREE)){
            child.removeClass(NAV_ANIM);
            
            //如果有子菜单，则展开
            if(child[0]){
              parent[child.css('display') === 'none' ? 'addClass': 'removeClass'](NAV_ITEM+'ed');
              if(parents.attr('lay-shrink') === 'all'){
                parent.siblings().removeClass(NAV_ITEM + 'ed');
              }
            }
          }
          
          layui.event.call(this, MOD_NAME, 'nav('+ filter +')', othis);
        }
        
        //点击子菜单选中
        /*
        ,clickChild: function(){
          var othis = $(this), parents = othis.parents(NAV_ELEM)
          ,filter = parents.attr('lay-filter');
          parents.find('.'+THIS).removeClass(THIS);
          othis.addClass(THIS);
          layui.event.call(this, MOD_NAME, 'nav('+ filter +')', othis);
        }
        */
        
        //折叠面板
        ,collapse: function(){
          var othis = $(this), icon = othis.find('.layui-colla-icon')
          ,elemCont = othis.siblings('.layui-colla-content')
          ,parents = othis.parents('.layui-collapse').eq(0)
          ,filter = parents.attr('lay-filter')
          ,isNone = elemCont.css('display') === 'none';
          
          //是否手风琴
          if(typeof parents.attr('lay-accordion') === 'string'){
            var show = parents.children('.layui-colla-item').children('.'+SHOW);
            show.siblings('.layui-colla-title').children('.layui-colla-icon').html('&#xe602;');
            show.removeClass(SHOW);
          }
          
          elemCont[isNone ? 'addClass' : 'removeClass'](SHOW);
          icon.html(isNone ? '&#xe61a;' : '&#xe602;');
          
          layui.event.call(this, MOD_NAME, 'collapse('+ filter +')', {
            title: othis
            ,content: elemCont
            ,show: isNone
          });
        }
      };
  
    exports('vaeyo', obj);
});    
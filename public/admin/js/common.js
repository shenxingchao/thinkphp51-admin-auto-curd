/**
 * Created by shenxingchao on 2018-12-10.
 */
(function ($) {
    //添加一个tabs
    function addTabs(id) {
        $('.active_tab').removeClass('active_tab');
        var tabs = '<span class="tab-item-btn active_tab" data-id="'+ id +'">'+ $('a[target="'+ id +'"]').text()
            +'&nbsp;<i class="fa fa-close tab-item-close"></i></span>';
        $('#tab-menu').append(tabs);
    }
    $('body').on('click','.tab-item-btn',function (e) {
        //点击tab栏  相当于点击左侧菜单 激活当前tab
        $('.active_tab').removeClass('active_tab');
        $(this).addClass('active_tab');
        var menu_obj = $('a[target="'+ $(this).attr('data-id') +'"]');
        menu_obj.click();
        //menu_obj[0].click();//点击tab栏想刷新就使用下面这行 个人感觉不刷新更友好
        //点击tab栏 如果当前菜单存在于树下 则需要依次展开树 如何已经展开 则不需要展开
        if(menu_obj.parents('.treeview').length===0){
            $('.treeview.menu-open').children('a').click();
        }else{
            if(!menu_obj.parents('.treeview').hasClass('menu-open')){
                menu_obj.parents('.treeview').children('a').click();
            }
        }
    });
    $('body').on('click','.tab-item-close',function (e) {
        e.stopPropagation();
        //如果有下一个span激活下一个URL，如果没有 激活上一个
        if($(this).parent('span').next().length>0){
            $(this).parent('span').next().click();
        }
        else{
            $(this).parent('span').prev().click();
        }
        var id = $(this).parent('span').attr('data-id');
        //关闭当前id的iframe
        $('iframe[name="'+ id +'"]').remove();
        //删除标签
        $(this).parent('span').remove();
    });
    //鼠标移入移出tab-item-btn
    $('body').on('mouseover','.tab-item-btn',function () {
        $(this).find('.tab-item-close').show();
    }).on('mouseout','.tab-item-btn',function () {
        $(this).find('.tab-item-close').hide();
    });

    $.fn.extend({
        "addMenus": function (menu) {
            menu = typeof (menu)!=='undefined'?menu:[];
            var html = '';
            $.each(menu, function (index, value) {
                if(typeof (value.child) ==='undefined' || value.child.length === 0){ //没有子菜单
                    html+='<li>'
                        +'<a href="'+ value.href +'" target="iframe-'+ value.id +'">'
                        +'<i class="'+ value.icon +'"></i>'
                        +'<span>'+ value.title +'</span>'
                        +'</a>'
                        +'</li>';
                }else{ //有子菜单  多级请自行扩展 后期在考虑
                    html+='<li class="treeview">'
                        +'<a href="#">'
                        +'<i class="'+ value.icon +'"></i> '
                        +'<span>'+ value.title +'</span>'
                        +'<span class="pull-right-container">'
                        +'<i class="fa fa-angle-left pull-right"></i>'
                        +'</span>'
                        +'</a>'
                        +'<ul class="treeview-menu">';
                    $.each(value.child,function (key,val) {
                        html+='<li>'
                            +'<a href="'+ val.href +'"  target="iframe-'+ val.id +'">'
                            +'<i class="'+ val.icon +'"></i>'
                            + val.title
                            +'</a>'
                            +'</li>';
                    });
                    html+='</ul>'
                        +'</li>';
                }
            });
            $(this).html(html);
            if(html!==''){
                //左侧菜单栏点击，右侧新建一个iframe
                $('.sidebar-menu a').bind('click',function () {
                    if(typeof($(this).attr("target"))==="undefined"){
                        //当前点击无target属性
                    }else{
                        //隐藏激活的iframe
                        $('.active-iframe').removeClass('active-iframe');
                        //激活当前菜单
                        $('.sidebar-menu li').removeClass('active');
                        $(this).parent('li').addClass('active');
                        if($(this).parents('.treeview').length>0){
                            $(this).parents('.treeview').addClass('active');
                        }
                        var id = $(this).attr('target');

                        if($('iframe[name="'+ id +'"]').length===0){
                            //新建一个iframe
                            var iframe_html  = '<iframe id="'+ id +'" class="default-iframe active-iframe" ' +
                                'name="'+ id +'" scrolling="auto" frameborder="0" width="100%" height="100%"></iframe>';
                            $('#tab-content').append(iframe_html);
                            addTabs(id);
                            //当前tab选项卡的长度
                            var tab_position_left = $('.tab-item-btn[data-id="'+ id +'"]').position().left;
                            var tab_width = $('.tab-item-btn[data-id="'+ id +'"]').outerWidth(true);
                            var tabs_width =  tab_position_left + tab_width - $('.tabLeft').outerWidth(true);
                            //获取滚动条的left长度
                            var tab_menu_scrollLeft = $('#tab-menu').scrollLeft();
                            //判断选项卡是否溢出了
                            if(tabs_width - $('#tab-menu').width() > 0){
                                $('#tab-menu').stop().animate({scrollLeft: tab_menu_scrollLeft+parseFloat(tab_width.toFixed(1))},500);
                            }
                        }else{
                            //激活当前iframe
                            $('iframe[name="'+ id +'"]').addClass('active-iframe');
                            //激活当前tab
                            $('.active_tab').removeClass('active_tab');
                            $('.tab-item-btn[data-id="'+ id +'"]').addClass('active_tab');
                            //如果当前tab不在可视窗口内，则移动到第一个
                            var cur_tab_positionLeft =  $('.tab-item-btn[data-id="'+ id +'"]').position().left-$('.tabLeft').outerWidth(true);
                            //获取滚动条的left长度
                            var tab_menu_scrollLeft = $('#tab-menu').scrollLeft();
                            if(cur_tab_positionLeft < 0||cur_tab_positionLeft > $('#tab-menu').width()){
                                $('#tab-menu').stop().animate({scrollLeft:tab_menu_scrollLeft + parseFloat(cur_tab_positionLeft.toFixed(1))},500);
                            }
                        }
                    }
                });
            }
        }
    });
})(jQuery);
//菜单向左滚动
function scrollTabLeft() {
    //获取滚动条的left长度
    var tab_menu_scrollLeft = $('#tab-menu').scrollLeft();
    $('#tab-menu').stop().animate({scrollLeft: tab_menu_scrollLeft - $('#tab-menu').width()},500);
}
//菜单向右滚动
function scrollTabRight() {
    if($('.tab-item-btn').length===0){
        return;
    }
    //获取滚动条的left长度
    var tab_menu_scrollLeft = $('#tab-menu').scrollLeft();
    //判断最后一个可见的tab 移动到该tab的为第一个
    for(var i=0;i<$('.tab-item-btn').length;i++){
        if($('.tab-item-btn').eq(i).position().left-$('.tabLeft').outerWidth(true) > $('#tab-menu').width()){
            break;
        }
    }
    $('#tab-menu').stop().animate({scrollLeft:tab_menu_scrollLeft + $('.tab-item-btn').eq(i-1).position().left-$('.tabLeft').outerWidth(true).toFixed(1)},500);
}
//关闭全部tab
function closeAllTab() {
    //关闭iframe
    $('.default-iframe').remove();
    //删除标签
    $('.tab-item-btn').remove();
}
//除此之外全部关闭
function closeOtherTab() {
    $('.default-iframe').not('.active-iframe').remove();
    $('.tab-item-btn').not('.active_tab').remove();
}
//刷新当前tab
function refreshTab() {
    if( $('a[target="'+ $('.active_tab').attr('data-id') +'"]').length>0)
        $('a[target="'+ $('.active_tab').attr('data-id') +'"]')[0].click();
}
$(function () {
    //iframe自适应高度
    function frameResize() {
        var height = $(window).height() - $('.main-footer').outerHeight() - $('.main-header').outerHeight()- $(".content-tabs").outerHeight();
        $(".content-iframe").css({
            height: height
        });
    }
    frameResize();
    //缩放窗口自适应
    $(window).resize(function() {
        frameResize();
    });
});
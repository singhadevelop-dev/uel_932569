/*
 * DemoBar JS
 * @version 1.0.0
 * By (TAHRI Adel)
 *//*global $:false */
+(function ($) {
    'use strict';

    var start = function () {
            var BarHeight = $('header').outerHeight(); //Header height including padding, border		
            $('.section').css({
                height: $(window).height() - BarHeight,
                width: $(window).width()
            }); //set the nav demo bar height	
            $('.cog ul').css({
                top: BarHeight
            });
        };
         /**
         * [EaseAnimate http://api.jqueryui.com/easings/ for more information]
         * @type {String}
         */
        var EaseAnimate = 'easeOutCirc';
        var MarginTop = $('header').outerHeight();
        //Global Variable
        var globalTop = 10;
        var globalLeft = 0;
        var displayDevices = true;
        var Selecte;
        var redirect = true;

        if(redirect){
          var isIframe = (top.location != self.location);
           if(isIframe){
            top.location.href = location.href;
          }
        }


    //--------------------helper functions-----------------

    /**
     * [scrollbarWidth get scroll bra width]
     * @return {[int]} []
     */
    $.scrollbarWidth = function () {
        var parent, child, width;

        if (width === undefined) {
            parent = $('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo('body');
            child = parent.children();
            width = child.innerWidth() - child.height(99).innerWidth();
            parent.remove();
        }
        return width;
    };
    /**
     * [addDevImg :to add devices image as a background]
     * @param {[url]} img  [image url]
     * @param {[pixel]} width [width of image]
     */
    function addDevImg(img, width) {
        $('.dev').append(' <img src=' + img + ' style="width:' + (width) + 'px;"" >');
    }

    /**
     * [Toggle :Slide Up and Down Devices buttons]
     * @param {[Selecter 'class name']} _class
     */
    function toggleFun(ClassName) {
        if ($(ClassName).hasClass('active')) {
            $(ClassName + ' ul').slideUp(400, 'easeOutCirc');
            $(ClassName + ' ul').removeClass('easeOutCirc');
        } else {
            $('.easeOutCirc').slideUp(400, 'easeOutCirc');
            $('.easeOutCirc').removeClass('easeOutCirc');
            $(ClassName + ' ul').slideDown(400, 'easeOutCirc');
            $(ClassName + ' ul').addClass('easeOutCirc');
            $('.active').removeClass('active');
        }
        $(ClassName).toggleClass('active');
    }

    /**
     * [resizeNow :callback function to resize the website ,depend on the devices size ]
     * @param {[type]} devece .
     * @param {[type]} marginTop : margin top after resize .
     */
    function resizeNow(devece, marginTop) {
        var wd;
        $('.section').stop(true, true).animate({
            marginTop: marginTop,
            width: devece[0],
            height: devece[1]
        }, 800, EaseAnimate);
        if ($('.section').hasClass('no-scrollbar')) {
            if (devece[0] === '100%') {
                wd = '100%';
            } else {
                wd = parseInt(devece[0], 10) + $.scrollbarWidth();
            }
        } else {
            if (devece[0] === '100%') {
                wd = '100%';
            } else {
                wd = parseInt(devece[0], 10);
            }
        }

        $('iframe').stop(true, true).animate({
            width: wd,
            height: devece[1]
        }, 800, 'easeOutCirc');
        $('.right .devices > div').removeClass('curr');
    }


    /**
     * [getMarginTop calculate data-op depend on device background]
     * @return {[Pixel]} [margin top]
     */
    function getMarginTop() {
        var height = $('.dev img').height(),
            width = $('.dev img').width(),
            globalTop = parseInt(height, 10) / 2 - (parseInt(globalTop, 10) - parseInt(globalLeft, 10) + parseInt(width, 10) / 2);
    }

    /**
     * [resize function]
     * @param  {[selecter]} Selecter
     * @param  {[px]} mt        [marging top]
     * @return {[void]}         [callback function]
     */


    function resize(Selecter, mt) {
        Selecte = Selecter;
        var w = $(Selecter).attr('data-width'),
            h = $(Selecter).attr('data-height'),
            img = $(Selecter).attr('data-image'),
            left = $(Selecter).attr('data-left'),
            top = $(Selecter).attr('data-top'),
            size = [w, h],
            dem = parseInt(left, 10) * 2 + parseInt(w, 10);
        if (typeof top !== 'undefined' && top !== false) {
            mt = globalTop = parseInt(top, 10) + 10;
            globalLeft = left;
        } else {
            globalTop = 10;
            globalLeft = 0;
        }
        if (displayDevices !== false) {
            resizeNow(size, mt);
        } else {
            resizeNow(size, 50);
        }
        if (typeof img !== 'undefined' && img !== false && displayDevices !== false) {
            //show dev's image
            $('.dev img').remove();
            addDevImg(img, dem);
            $('.dev').css('marginRight', -1 * (parseInt(w, 10) / 2 + parseInt(left, 10)));

        } else {
            //Hide images 
            $('.dev img').remove();
        }
    }

    //--------------------!helper functions-----------------


    //-------------------------CliCK-----------------------------
    /**
     * [rotate dimension]
     */
    $('.rotate').click(function () {
        var widthVal = $('.section').width(),
            heightVal = $('.section').height(),
            wd;
        $('.section').stop(true, true).animate({
            width: heightVal,
            height: widthVal
        }, 800, EaseAnimate);
        if ($('.section').hasClass('no-scrollbar')) {
            wd = heightVal + $.scrollbarWidth();
        } else {
            wd = heightVal;
        }

        $('iframe').stop(true, true).animate({
            width: wd,
            height: widthVal
        }, 800, 'easeOutCirc');


        if (displayDevices === true) {
            //get image size
            getMarginTop();
            $('.rotate').toggleClass('curr');

            $('.dev img').toggleClass('hide');
        } else {
            $('.dev img').remove();
        }
    });
    /**
     * [Slide Up and Down Settings]
     * @return {[event]} [description]
     */
    $('.cog > a').click(function () {

        if ($(this).hasClass('active-cog')) {
            $('.cog ul').slideUp(400, 'easeOutCirc');
        } else {
            $('.cog ul').slideDown(400, 'easeOutCirc');
        }
        $(this).toggleClass('active-cog');

    });

    /**
     * [Hide and show scroll bar]
     * @return {[event]}
     */
    $('#scroll').click(function () {
        $('.section').toggleClass('no-scrollbar');
        var widthVal = $('.section').width(),
            heightVal = $('.section').height();
        if ($('.section').hasClass('no-scrollbar')) {
            $('#scroll span').css('color', '#c0392b');

            $('.no-scrollbar iframe').stop(true, true).animate({
                width: widthVal + $.scrollbarWidth(),
                height: heightVal
            }, 400, 'easeOutCirc');
        } else {
            $('#scroll span').css('color', '#2ecc71');
            $('iframe').stop(true, true).animate({
                width: widthVal,
                height: heightVal
            }, 400, 'easeOutCirc');
        }

    });
    /**
     * [hide and show devices backgrounds]
     * @return {[event]} [hide and show]
     */
    $('#device').click(function () {
        $('.dev').toggleClass('hide');
        if ($('.dev').hasClass('hide')) {
            $('#device span').css('color', '#c0392b');
            displayDevices = false;
            $('.dev img').stop(true, true).hide(400, 'easeOutCirc');
            resize(Selecte, 50);
        } else {
            displayDevices = true;
            $('#device span').css('color', '#2ecc71');
            $('.dev img').stop(true, true).show(400, 'easeOutCirc');
            resize(Selecte, 50);
        }
    });

    /**
     * [Toggle Function]
     * @return {[event]} [Toggle the menu]
     */
    $('.phone').click(function () {
        toggleFun('.phone');
    });

    $('.tablet').click(function () {
        toggleFun('.tablet');
    });

    $('.phone li').click(function () {
        resize($(this), 50);
    });

    $('.tablet li').click(function () {
        resize($(this), 20);
    });

    /**
     * [click description]
     * @param  {[screen Size]})}
     * @return {[resize]}
     */
    $('.right .screen').on({
        click: function () {
            var size = ['100%', '100%'];
            resizeNow(size, 0);
            $(this).addClass('curr');
            $('.dev img').remove();
        }
    });

    //---------------------------!CliCK---------------------------


    //------------------------- MENU -----------------------
    /**
     * [MarginTop : This variable will get the header heigh and to displace the embed document to bottom ]
     * @type {[Pixel]}
     */

    $('#menu .current').on({
        mouseenter: function () {
            window.menuTime = setTimeout(function () {
                if ($('body').hasClass('menu-opened')) {
                    return;
                }
                $('body').addClass('menu-opened');
            }, MarginTop);
        }
    }).parent().on({
        mouseleave: function () {
            clearTimeout(window.menuTime);
            $('body').removeClass('menu-opened');
        }
    });

    $('#menu li').on({

        click: function () {
            location.href = $(this).data('url');
        },
        mouseenter: function () {
            var MarginLeft = $(this).offset().left + $(this).width() + 41,
                preview = $(this).data('preview');

            $('#preview-img').css({
                top: MarginTop,
                left: MarginLeft
            }).stop().show(200, 'easeOutBounce')
                .find('div').css({
                    backgroundImage: 'url(' + preview + ')'
                });
        },
        mouseleave: function () {
            $('#preview-img').hide();
        }

    });
    //------------------------- !MENU ----------------------


    //-----------------------Purchase Button
    $('.right .purchase, .right .close').on({
        click: function () {
            location.href = $(this).data('url');
        }
    });
    //-----------------------!Purchase Button

    $(window).resize(start).trigger('resize');

}($));
// отрефакторить методы методы должны выполнять одно действие
(function($, undefined){
    var userAgent = navigator.userAgent.toLowerCase();
    $.browser = {
        version: (userAgent.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [])[1],
        safari: /webkit/.test(userAgent),
        opera: /opera/.test(userAgent),
        msie: /msie/.test(userAgent) && !/opera/.test(userAgent),
        mozilla: /mozilla/.test(userAgent) && !/(compatible|webkit)/.test(userAgent)
    };
    $.fn.isMobileTracker = function () {
        var isMobile = {
            Android: function () {
                return navigator.userAgent.match(/Android/i) ? true : false;
            },
            BlackBerry: function () {
                return navigator.userAgent.match(/BlackBerry/i) ? true : false;
            },
            iOS: function () {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
            },
            Windows: function () {
                return navigator.userAgent.match(/IEMobile/i) ? true : false;
            },
            any: function () {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
            }
        };
        return isMobile;
    };
    // дает возможность адаптировать iframe размеры подгоняет под размеры контейнера
    // пример использования
    // $("iframe[src*='//player.vimeo.com'], iframe[src*='//www.youtube.com']").resizeIframes();
    // контейнер для iframe должен быть { display: block }!!! (иначе работать не будет ресайз) 
    // надо добавить ексепшини на пареметры высоты и ширины вводить только без пикселей
    // параметр isWindowsResize = true означает, что iframe будет ресайзится каждый раз при изменении размеров экрана;
    // параметр isWindowsResize = false означает, что iframe срабатывает только один раз при выполнении 
    // и не меняет размеры iframe при изменении размеров экрана
    $.fn.resizeIframes = function (isWindowsResize) {
        isWindowsResize = isWindowsResize || true;
        var ifraims = this;
        ifraims.each(function () {
           if (!$(this).is('[data-aspectRatio]')){
            var width = parseInt(this.width);
            var height = parseInt(this.height);
            if(isNaN(width)){
                console.error('ERROR: resizeIframes() Attribute "width" setted incorrect!');
                console.log($(this).parent().prop('outerHTML'));
            };
            if(isNaN(height)){
                console.error('ERROR: resizeIframes() Attribute "height" setted incorrect!');
                console.log($(this).parent().prop('outerHTML'));
            };
            $(this)
                    .attr('data-aspectRatio', height / width)
                    .removeAttr('height')
                    .removeAttr('width');
            }
        });
        function __resize(ifraims){
            ifraims.each(function () {
                var $el = $(this);
                var newWidth = $el.parent().css("width");
                newWidth = parseInt(newWidth.slice(0, -2));
                $el.width(newWidth).height(newWidth * $el.attr('data-aspectRatio'));
            });
        }
        if(isWindowsResize){
            $(window).resize(function () {
                __resize(ifraims);
            }).resize();
        } else {
           __resize(ifraims);
        }
        return this;
    }

    // дает возможность сделать одинаковую высоту элементам в зависимости от их контента
    /*
    func      возвращает true или false в зависимости от вас 
              для отключения ресайза на разных экранах
    minHeight минимальная высота
    maxHeight максимальная высота
    $("#footer .column").equalHeights(function () {
            var widthScreen = window.innerWidth
                || document.documentElement.clientWidth
                || document.body.clientWidth;
            return (widthScreen > 450);
        });
    */
    $.fn.equalHeights = function (func, minHeight, maxHeight) {
        function ___equalHeights(elements, minHeight, maxHeight) {
            var tallest = (minHeight) ? minHeight : 0;
            elements.each(function () {
                if ($(this).height() > tallest) {
                    $(this).css("min-height", "initial");
                    tallest = $(this).height()
                }
            });
            if ((maxHeight) && tallest > maxHeight) {
                tallest = maxHeight;
            }
            return elements.each(function () {
                $(this).css("min-height", tallest + "px")
            })
        }
        var elements = this,
                funcElement = (func) ? func : function () {return true;};
        if (funcElement())
            if (elements.length) {
                ___equalHeights(elements, minHeight, maxHeight);
            }
        $(window).resize(function () {
            elements.css("min-height", "initial");
            if (funcElement())
                if (elements.length) {
                    ___equalHeights(elements, minHeight, maxHeight);
                }
        });
    }

    $.fn._____init = $.fn.init;
    $.fn.init = function( selector, context ) {
        return (typeof selector === 'string') ? new $.fn._____init(selector, context).data('selector', selector) : new $.fn._____init( selector, context );
    };
    // использовать только если надо получить селектор заданный при поиске елемента
    // ПРИМЕР
    // $('.selector ul li').getSelector(); = '.selector ul li'
    $.fn.getSelector = function() {
        return $(this).data('selector');
    };

    // анимированые якоря на блоки
    // ПРИМЕР
    // $.fn.scrollBreackpointHandler('.header-nav a', 500);
    // $.fn.scrollBreackpointHandler('.scroll_handler_link', 500);
    // в Html создаются ссылки на айдишники блоков страницы 
    // в переменную selectorLinkInBreackPoint заганяем селектор 
    // по которому найдутся все такие ссылки и переходы на блоки будут плавные
    // 
    $.fn.scrollBreackpointHandler = function (selectorLinkInBreackPoint, time) {
        $(document).on('click', selectorLinkInBreackPoint, function (event) {
            event.preventDefault();
            $($.attr(this, 'href')).scrollToElement(time);
        });
        console.log("scrollBreackpointHandler is deprecated! Use please initAnchors()");
        console.log("Example: $('"+selectorLinkInBreackPoint+"').initAnchors("+time+");");
    }
    // анимированые якоря на блоки
    // ПРИМЕР
    // $('.anchor').initAnchors();
    // $('selectorAnchors').initAnchors(400);
    $.fn.initAnchors = function (time) {
        time = time || 500;
        anchorsElements = this;
        $(document).on('click', anchorsElements.getSelector(), function (event) {
            event.preventDefault();
            $($.attr(this, 'href')).scrollToElement(time);
        });
        return anchorsElements;
    }
    //Скролит к елементу с любой позиции при вызове
    // ПРИМЕР
    // time - время скрола по умолчанию 500 милисекунд
    //$('selectorEloment').scrollToElement(500);
    $.fn.scrollToElement = function (time) {
        time = time || 500;
        var element = this;
        $('html, body').animate({
            scrollTop: $(element).offset().top
        }, time);
        return element;
    }
    // скрипт связывающий адаптивное меню и кнопку которая им управляет
    // ПРИМЕР
    // $('.button_menu').handleMenu('.header-nav', 'block');
    $.fn.handleMenu = function (selectorNavMenu, displayMenu) {
        displayMenu = displayMenu || 'block';
        var buttonMenu = this;
        var navMenu = $(selectorNavMenu);
        if (buttonMenu.css("display") === "none") {
            navMenu.css("display", displayMenu);
        } else {
            navMenu.css("display", "none");
        }
        $(window).resize(function () {
            if (buttonMenu.css("display") === "none") {
                navMenu.css("display", displayMenu);
            } else {
                navMenu.css("display", "none");
            }
        });
        buttonMenu.on('click', function () {
            navMenu.slideToggle("fast");
            if ( navMenu.hasClass("open") ) {
                navMenu.removeClass('open');
                buttonMenu.removeClass('closed');
            } else{
                navMenu.addClass('open');                
                buttonMenu.addClass('closed');
            }
        });
    }
})(jQuery);
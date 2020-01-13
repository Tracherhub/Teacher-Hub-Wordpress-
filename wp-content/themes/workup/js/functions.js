(function ($) {
    "use strict";

    if (!$.apusThemeExtensions)
        $.apusThemeExtensions = {};
    
    function ApusThemeCore() {
        var self = this;
        self.init();
    };

    ApusThemeCore.prototype = {
        /**
         *  Initialize
         */
        init: function() {
            var self = this;
            
            self.preloadSite();

            // slick init
            self.initSlick($("[data-carousel=slick]"));

            // Unveil init
            setTimeout(function(){
                self.layzyLoadImage();
            }, 200);
            
            // isoto
            self.initIsotope();

            // Sticky Header
            self.intChangeHeaderMarginTop();
            self.initHeaderSticky();

            // back to top
            self.backToTop();

            // popup image
            self.popupImage();

            $('[data-toggle="tooltip"]').tooltip();

            self.initMobileMenu();

            self.changeContentTop();

            self.sharesocial();

            self.mainMenuInit();
            
            self.dashboardMenu();

            self.advanceFilter();
            
            $('.more').on('click', function(){
                $('.wrapper-morelink').toggleClass('active');
            });
            

            $(document.body).on('click', '.nav [data-toggle="dropdown"]' ,function(){
                if ( this.href && this.href != '#'){
                    window.location.href = this.href;
                }
            });

            self.loadExtension();
        },
        /**
         *  Extensions: Load scripts
         */
        loadExtension: function() {
            var self = this;
            
            if ($.apusThemeExtensions.quantity_increment) {
                $.apusThemeExtensions.quantity_increment.call(self);
            }

            if ($.apusThemeExtensions.shop) {
                $.apusThemeExtensions.shop.call(self);
            }

            if ($.apusThemeExtensions.job_map) {
                $.apusThemeExtensions.job_map.call(self);
            }

            if ($.apusThemeExtensions.job) {
                $.apusThemeExtensions.job.call(self);
            }
        },
        initSlick: function(element) {
            var self = this;
            element.each( function(){
                var config = {
                    infinite: false,
                    arrows: $(this).data( 'nav' ),
                    dots: $(this).data( 'pagination' ),
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    prevArrow:"<button type='button' class='slick-arrow slick-prev'><i class='fa-arrow-left fa' aria-hidden='true'></i></span><span class='textnav'>"+ workup_ajax.previous +"</span></button>",
                    nextArrow:"<button type='button' class='slick-arrow slick-next'><span class='textnav'>"+ workup_ajax.next +"</span><i class='fa-arrow-right fa' aria-hidden='true'></i></button>",
                };
            
                var slick = $(this);
                if( $(this).data('items') ){
                    config.slidesToShow = $(this).data( 'items' );
                    config.slidesToScroll = $(this).data( 'items' );
                }
                if( $(this).data('infinite') ){
                    config.infinite = true;
                }
                if( $(this).data('autoplay') ){
                    config.autoplay = true;
                    config.autoplaySpeed = 1500;
                }
                if( $(this).data('centermode') ){
                    config.centerMode = true;
                }
                if( $(this).data('vertical') ){
                    config.vertical = true;
                }
                if( $(this).data('rows') ){
                    config.rows = $(this).data( 'rows' );
                }
                if( $(this).data('asnavfor') ){
                    config.asNavFor = $(this).data( 'asnavfor' );
                }
                if( $(this).data('slidestoscroll') ){
                    config.slidesToScroll = $(this).data( 'slidestoscroll' );
                }
                if( $(this).data('focusonselect') ){
                    config.focusOnSelect = $(this).data( 'focusonselect' );
                }
                if ($(this).data('large')) {
                    var desktop = $(this).data('large');
                } else {
                    var desktop = config.items;
                }
                if ($(this).data('smalldesktop')) {
                    var smalldesktop = $(this).data('smalldesktop');
                } else {
                    if ($(this).data('large')) {
                        var smalldesktop = $(this).data('large');
                    } else{
                        var smalldesktop = config.items;
                    }
                }
                if ($(this).data('medium')) {
                    var medium = $(this).data('medium');
                } else {
                    var medium = config.items;
                }
                if ($(this).data('smallmedium')) {
                    var smallmedium = $(this).data('smallmedium');
                } else {
                    var smallmedium = 2;
                }
                if ($(this).data('extrasmall')) {
                    var extrasmall = $(this).data('extrasmall');
                } else {
                    var extrasmall = 2;
                }
                if ($(this).data('smallest')) {
                    var smallest = $(this).data('smallest');
                } else {
                    var smallest = 1;
                }
                config.responsive = [
                    {
                        breakpoint: 321,
                        settings: {
                            slidesToShow: smallest,
                            slidesToScroll: smallest,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: extrasmall,
                            slidesToScroll: extrasmall,
                        }
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: smallmedium,
                            slidesToScroll: smallmedium
                        }
                    },
                    {
                        breakpoint: 981,
                        settings: {
                            slidesToShow: medium,
                            slidesToScroll: medium
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: smalldesktop,
                            slidesToScroll: smalldesktop
                        }
                    },
                    {
                        breakpoint: 1501,
                        settings: {
                            slidesToShow: desktop,
                            slidesToScroll: desktop
                        }
                    }
                ];
                if ( $('html').attr('dir') == 'rtl' ) {
                    config.rtl = true;
                }

                $(this).slick( config );

            } );

            // Fix owl in bootstrap tabs
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href");
                var $slick = $("[data-carousel=slick]", target);

                if ($slick.length > 0 && $slick.hasClass('slick-initialized')) {
                    $slick.slick('refresh');
                }
                self.layzyLoadImage();
            });
        },
        layzyLoadImage: function() {
            $(window).off('scroll.unveil resize.unveil lookup.unveil');
            var $images = $('.image-wrapper:not(.image-loaded) .unveil-image'); // Get un-loaded images only
            if ($images.length) {
                $images.unveil(1, function() {
                    $(this).load(function() {
                        $(this).parents('.image-wrapper').first().addClass('image-loaded');
                        $(this).removeAttr('data-src');
                        $(this).removeAttr('data-srcset');
                        $(this).removeAttr('data-sizes');
                    });
                });
            }

            var $images = $('.product-image:not(.image-loaded) .unveil-image'); // Get un-loaded images only
            if ($images.length) {
                $images.unveil(1, function() {
                    $(this).load(function() {
                        $(this).parents('.product-image').first().addClass('image-loaded');
                    });
                });
            }
        },
        initIsotope: function() {
            $('.isotope-items').each(function(){  
                var $container = $(this);
                
                $container.imagesLoaded( function(){
                    $container.isotope({
                        itemSelector : '.isotope-item',
                        transformsEnabled: true,         // Important for videos
                        masonry: {
                            columnWidth: $container.data('columnwidth')
                        }
                    }); 
                });
            });

            /*---------------------------------------------- 
             *    Apply Filter        
             *----------------------------------------------*/
            $('.isotope-filter li a').on('click', function(){
               
                var parentul = $(this).parents('ul.isotope-filter').data('related-grid');
                $(this).parents('ul.isotope-filter').find('li a').removeClass('active');
                $(this).addClass('active');
                var selector = $(this).attr('data-filter'); 
                $('#'+parentul).isotope({ filter: selector }, function(){ });
                
                return(false);
            });
        },
        changeHeaderMarginTop: function() {
            if ($(window).width() > 991) {
                if ( $('.main-sticky-header').length > 0 ) {
                    var header_height = $('.main-sticky-header').outerHeight();
                    $('.main-sticky-header-wrapper').css({'height': header_height});
                }
                // top for cart
                if ( $('#apus-header').length > 0 ) {
                    var header_height = $('#apus-header').outerHeight();
                    $('.search-header').css({'padding-top': header_height});
                }
            }
        },
        intChangeHeaderMarginTop: function() {
            var self = this;
            setTimeout(function(){
                self.changeHeaderMarginTop();
            }, 50);
            $(window).resize(function(){
                setTimeout(function(){
                    self.changeHeaderMarginTop();
                }, 50);
            });
        },

        changeContentTop: function() {
            setTimeout(function(){
                if ($(window).width() < 1200) {
                    if ( $('.header-mobile').length > 0 ) {
                        var header_height = $('.header-mobile').outerHeight();
                        $('.header-mobile ~ #apus-main-content').css({'padding-top': header_height});
                    }
                }
            }, 50);
        },

        initHeaderSticky: function() {
            var self = this;
            var main_sticky = $('.main-sticky-header');
            setTimeout(function(){
                if ( main_sticky.length > 0 ){
                    if ($(window).width() > 991) {
                        var _menu_action = main_sticky.offset().top;
                        $(window).scroll(function(event) {
                            self.headerSticky(main_sticky, _menu_action);
                        });
                        self.headerSticky(main_sticky, _menu_action);
                    }
                }
            }, 50);
        },
        headerSticky: function(main_sticky, _menu_action) {
            if( $(document).scrollTop() > _menu_action ){
                main_sticky.addClass('sticky-header');
            }else{
                main_sticky.removeClass('sticky-header');
            }
        },
        backToTop: function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 400) {
                    $('#back-to-top').addClass('active');
                } else {
                    $('#back-to-top').removeClass('active');
                }
            });
            $('#back-to-top').on('click', function () {
                $('html, body').animate({scrollTop: '0px'}, 800);
                return false;
            });
        },
        
        popupImage: function() {
            // popup
            $(".popup-image").magnificPopup({type:'image'});
            $('.popup-video').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });

            $('.widget-gallery').each(function(){
                var tagID = $(this).attr('id');
                $('#' + tagID).magnificPopup({
                    delegate: '.popup-image-gallery',
                    type: 'image',
                    tLoading: 'Loading image #%curr%...',
                    mainClass: 'mfp-img-mobile',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                    }
                });
            });
        },
        preloadSite: function() {
            // preload page
            if ( $('body').hasClass('apus-body-loading') ) {
                $('body').removeClass('apus-body-loading');
                $('.apus-page-loading').fadeOut(100);
            }
        },

        initMobileMenu: function() {

            // stick mobile
            var self = this;
            var main_sticky = $('.header-mobile');
            setTimeout(function(){
                if ( main_sticky.length > 0 ){
                    if ($(window).width() < 992) {
                        var _menu_action = main_sticky.offset().top;
                        $(window).scroll(function(event) {
                            self.headerSticky(main_sticky, _menu_action);
                        });
                        self.headerSticky(main_sticky, _menu_action);
                    }
                }
            }, 50);

            // menu
            var mobilemenu = $("#navbar-offcanvas").mmenu({
                offCanvas: true,
            }, {
                // configuration
                offCanvas: {
                    pageSelector: "#wrapper-container1"
                }
            });
            
            // sidebar mobile
            if ($(window).width() < 992) {
                $('.sidebar-wrapper:not(.offcanvas-filter-sidebar) > .sidebar-right, .sidebar-wrapper:not(.offcanvas-filter-sidebar) > .sidebar-left').perfectScrollbar();
                var header_h = $('#apus-header-mobile').outerHeight();
                $('.sidebar-wrapper:not(.offcanvas-filter-sidebar) > .sidebar-right, .sidebar-wrapper:not(.offcanvas-filter-sidebar) > .sidebar-left').css({ 'top': header_h });
                $('.sidebar-wrapper:not(.offcanvas-filter-sidebar) > .sidebar-right, .sidebar-wrapper:not(.offcanvas-filter-sidebar) > .sidebar-left').css({ 'height': 'calc(100vh - ' + header_h+ 'px)' });
            }
            $('body').on('click', '.mobile-sidebar-btn', function(){
                if ( $('.sidebar-left').length > 0 ) {
                    $('.sidebar-left').toggleClass('active');
                } else if ( $('.sidebar-right').length > 0 ) {
                    $('.sidebar-right').toggleClass('active');
                }
                $('.mobile-sidebar-panel-overlay').toggleClass('active');
            });
            $('body').on('click', '.mobile-sidebar-panel-overlay, .close-sidebar-btn', function(){
                if ( $('.sidebar-left').length > 0 ) {
                    $('.sidebar-left').removeClass('active');
                } else if ( $('.sidebar-right').length > 0 ) {
                    $('.sidebar-right').removeClass('active');
                }
                $('.mobile-sidebar-panel-overlay').removeClass('active');
            });
        },

        sharesocial: function() {
            $('body').on('click', '.action-button', function(e){
                e.preventDefault();
                $(this).parent().toggleClass('active');
            });
        },
 
        advanceFilter: function() {
            $('body').on('click', '.filter-job-top .toggle-adv', function(e){
                e.preventDefault();
                $('.filter-job-top .advance-fields').toggle('slow');
            });
        },
        mainMenuInit: function() {
            $('.apus-megamenu .megamenu .has-mega-menu.aligned-fullwidth').each(function(e){
                var $this = $(this),
                    i = $this.closest(".elementor-container"),
                    a = $this.closest('.apus-megamenu');
                $this.on('hover', function(){
                    var m = $(this).find('> .dropdown-menu .dropdown-menu-inner'),
                        w = i.width();

                    m.css({
                        width: w,
                        marginLeft: i.offset().left - a.offset().left
                    });
                });

                $this.find('.elementor-element').addClass('no-transparent');
            });
        },
        dashboardMenu: function() {
            $('body').on('click', '.together-sidebar-account', function(e){
                e.preventDefault();
                $('.inner-dashboard.container-fluid').toggleClass('active');
            });

            if ($(window).width() > 991) {
                if ( $('#apus-header').length > 0 ) {
                    var header_height = $('#apus-header').outerHeight();
                    $('.inner-dashboard.container-fluid .sidebar-wrapper').css({'top': header_height});
                }
            }else{
                if ( $('#apus-header-mobile').length > 0 ) {
                    var header_height = $('#apus-header-mobile').outerHeight();
                }
            }
            $('.inner-dashboard.container-fluid aside.sidebar').perfectScrollbar();
        },

        setCookie: function(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires+";path=/";
        },
        getCookie: function(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
            }
            return "";
        }
    }

    $.apusThemeCore = ApusThemeCore.prototype;
    
    
    $.fn.wrapStart = function(numWords){
        return this.each(function(){
            var $this = $(this);
            var node = $this.contents().filter(function(){
                return this.nodeType == 3;
            }).first(),
            text = node.text().trim(),
            first = text.split(' ', 1).join(" ");
            if (!node.length) return;
            node[0].nodeValue = text.slice(first.length);
            node.before('<b>' + first + '</b>');
        });
    };

    $(document).ready(function() {
        // Initialize script
        new ApusThemeCore();

        $('.mod-heading .widget-title > span').wrapStart(1);
    });

})(jQuery);


/*!
 * JavaScript|jQuery functions
 * 
 * Load into wpdevsclubCore namespace
 *
 * @package     WPDevsClub Core
 * @since       1.0.3
 * @author      Tonya <hello@wpdevelopersclub.com>
 * @link        http://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 * @copyright   wpdevelopersclub.com
 */

;(function( $, window, document, undefined ){

    'use_strict';

    var wpdevsclubCore = wpdevsclubCore || {};

    wpdevsclubCore.init = function() {
        
        _headerMenu();

        _cards();

        _qa();

        //_videos();

        _scrollToTop();
        _smoothScroll();

        _inView();

        _stickyFooter();
    }

    /**
     PRIVATE FUNCTIONS
     */

    function _headerMenu() {
        var $navPanel = $('#sliding-nav-panel'),
            $icon = $('.main-menu-icon'),
            $mainNav = $navPanel.find('.widget_nav_menu');

        $navPanel.hide();

        if ( $('body').hasClass('admin-bar')) {
            $navPanel.find('a.close-sliding-panel').css('margin-top', $('#wpadminbar').height() + 30 );
        }

        $icon.on('click', function(){

            $navPanel.slideToggle('slow');

            return false;
        });

        $('.close-sliding-panel').on('click', function(){

            $navPanel.slideToggle('slow');
        });


        $mainNav
            .find('.sub-menu').each(function(){
                $(this).hide();
            }).end()
            .on('click', '.menu-item', function(e){
                if (e.target !== this) return;
                
                $(this).find('.sub-menu:first').slideToggle(function(){
                    $(this).parent().toggleClass('menu-open');
                });
            });
    }

    function _cards() {
        $('.flip').on('click', function(e){
            e.stopPropagation();
            $(this).toggleClass('is-flipped');
        });
    }

    function _qa() {

        $('.qa-question').on('click', function() {
            if( $(this).hasClass('opened') ) {
                $(this).removeClass('opened');
                $(this).parent().find('.qa-answer').slideUp();
            } else {
                $(this).addClass('opened');
                $(this).parent().find('.qa-answer').slideDown();
            }
        });
    }

    function _videos() {
        var video = $( '.wp-video' );

        if ( typeof video == "undefined" ) {
            return false;
        }

        video.fitVids();

        return false;
    }

    function _scrollToTop() {

        $('.scrollup').click(function(){
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });        
    }

    function _smoothScroll() {

        $('a[href*=#]:not([href=#])').click(function()
        {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html,body').animate({
                  scrollTop: target.offset().top
                }, 1000);
                return false;
              }
            }
        });
    } 

    function _inView() {
       
        var wh = $(window).height(),
            ww = $(window).width(),
            dh = $(document).height(),
            $benefits = $('#home-section-1'),      
            benefits = wpdevsclubCore.pages.fp ? $benefits.offset().top : 0;

        $(window).scroll(function(){
            var scroll = $(this).scrollTop();
            if (scroll + 200 >= benefits) {
                $benefits.addClass('inview');
            } else {
                $benefits.removeClass('inview');
            }

            // $('.flip-container').each(function(i, el){
            //     if ( scroll >= benefits ) {
            //         if (ww >= 768) {
            //             _inviewClassHandler(scroll + wh + 210, $(el));
            //         } else {
            //             _inviewClassHandler(scroll + wh + 500, $(el));
            //         }
            //     } else if ($(el).hasClass('inview')) {
            //         $(el).removeClass('inview');
            //     }
            // });


        });
    }

    function _inviewClassHandler( dims, $el ) {
       
        if (dims >= $el.offset().top + $el.height()) {
            $el.addClass('inview');
        } else {
            $el.removeClass('inview');
        }

        return false;
    }

    function isInView( $el ) {

        var winTop = $(window).scrollTop(),
            winBottom = winTop + $(window).height(),
            elTop = $el.offset().top,
            elBottom = elTop + $el.height();

        return ( ( elBottom <= winBottom ) && ( elTop >= winTop ) );
    }

    function _stickyFooter() {
        var $stickyFooter = $('#sticky-footer');

        if ( typeof $stickyFooter === "undefined" ) {
            return false;
        }

        var $handle     = $stickyFooter.find('.sticky-footer-handle'),
            $panel      = $stickyFooter.find('.sticky-footer-panel'),
            $paneItem   = $panel.find('.panel-item');

        $panel
            .delay( 2500)
            .slideToggle( 1250 );

        $handle.on('click', function() {
            $panel.slideToggle( 1000 );
        });

        $paneItem.on('click', function() {

            if ( $(this).hasClass('disable') ) {
                return false;
            }

            var classNames = $(this).attr('class');

            if ( classNames == 'panel-item scroll-to-top' ) {
                return false;
            }

            wpdevsclubCore.siteContainerOverlay.toggleClass('show');

            //* Close all subpanels
            $paneItem.each(function() {
               var $subpanel = $(this).find('.subpanel');

               if (typeof $subpanel === "undedfined") {
                   return true;
               }

               if ( classNames == $(this).attr('class') ) {
                   $subpanel.toggleClass('is-expanded');
               } else {
                   $subpanel.removeClass('is-expanded');
               }
            });
        });

        return false;
    }

    function _closeAllSubPanels( $panel ) {
        $panel.find('.subpanel').each(function() {
            $(this).removeClass('is-expanded');
        });
    }

    $(document).ready(function () {

        wpdevsclubCore.params = typeof wpdevsclub_core_l10 === 'undefined' ? '' : wpdevsclub_core_l10;
        wpdevsclubCore.siteContainerOverlay = $('.site-container .overlay' );

        var body = $('body');
        wpdevsclubCore.pages = {
            fp : body.hasClass('wpdevsclub-home')
        }

        wpdevsclubCore.init();

    });

})(jQuery, window, document);
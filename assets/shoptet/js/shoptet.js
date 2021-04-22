// Shared JS content
(function($) {

    $.fn.shpResponsiveNavigation = function() {

        return this.each(function() {

            var $this = $(this),   //this = div .responsive-nav
                maxWidth,
                visibleLinks,
                hiddenLinks,
                button;

            maxWidth = $(this).width();

            // check if menu is even visible before start
            if(maxWidth > 0) {

                setup($this);

                function setup(resNavDiv) {
                    visibleLinks = resNavDiv.find('.visible-links');
                    visibleLinks.children('li').each(function() {
                        $(this).attr('data-width', $(this).outerWidth());
                    });

                    //hidden navigation
                    if (!resNavDiv.find('.hidden-links').length) {
                        resNavDiv.append('<button class="navigation-btn"><div class="fas fa-bars"></div></button><ul class="hidden-links hidden"></ul>');
                    }
                    hiddenLinks = resNavDiv.find('.hidden-links');
                    button = resNavDiv.find('button');
                }

                function update(resNavDiv) {
                    maxWidth = resNavDiv.width();
                    var filledSpace = button.outerWidth();

                    if((visibleLinks.outerWidth() + filledSpace) > maxWidth) {
                        // push excess to hidden links
                        visibleLinks.children('li').each(function(index) {
                            filledSpace += $(this).data('width');
                            if (filledSpace >= maxWidth) {
                                $(this).appendTo(hiddenLinks);
                            }
                        });


                    } else {
                        filledSpace += visibleLinks.width();

                        // push missing to visible links
                        hiddenLinks.children('li').each(function(index) {
                            filledSpace += $(this).data('width');
                            if (filledSpace < maxWidth) {
                                $(this).appendTo(visibleLinks);
                            }
                        });
                    }

                    if (hiddenLinks.children('li').length == 0) {
                        button.hide();
                    } else {
                        button.show();
                    }
                }

                $(window).resize(function() {
                    update($this);
                });

                $(button).click(function() {
                    hiddenLinks.toggleClass('hidden');
                });
            }
        });
    };

})(jQuery);

$(document).ready(function(){
    /* START RESPONSIVE NAVIGATION */
    $('.responsive-nav').shpResponsiveNavigation();

    /* IFRAME VIDEO RESPONSIVE SNIPPET start */
    var $iframeVideos = $("iframe");
    $iframeVideos.each(function() {
        $(this)
            .data('aspectRatio', $(this).height() / $(this).outerWidth());
    });

    $(window).resize(function() {
        $iframeVideos.each(function() {
            var $el = $(this);
            var parentWidth = $el.parents("div").width();
            if($el.hasClass('fullwidth') || ($el.outerWidth() > parentWidth)) {
                $el.width(parentWidth).height(parentWidth * $el.data('aspectRatio'))
                .removeAttr('height').removeAttr('width');
            }
        });
        // One resize to fix all videos on page load
    }).resize();
    /* IFRAME VIDEO RESPONSIVE SNIPPET end */

    /* MULTILEVEL NAVIGATION start */
    $('.dropdown-menu .dropdown-toggle').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');

        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass("show");
        });

        return false;
    });
    /* MULTILEVEL NAVIGATION end */

});



$(function() {

    function initSlider(slider) {
        isDown = false;
        isMoving = false;
        var isDown;
        var startX;
        var scrollLeft;
        $(slider).find('a[href]').on('click', function (e) {
            if (isMoving) {
                e.preventDefault();
            }
            isMoving = false;
        } );
        slider.addEventListener('mousedown', function(e) {
            isDown = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', function() {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mouseup', function() {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mousemove', function(e) {
            if(!isDown) return;
            isMoving = true;
            e.preventDefault();
            slider.classList.add('active');
            var x = e.pageX - slider.offsetLeft;
            var walk = x - startX;
            slider.scrollLeft = scrollLeft - walk;
        });
    }

    var sliders = document.querySelectorAll('.swipeable');
    for (var i = 0; i < sliders.length; i++) {
        initSlider(sliders[i])
    }
 
});

$(function() {
    var didScroll;
    var st;
    var navbarHeight;
    var $navigation = $('.navigation');
    var lastScrollTop = $(window).scrollTop();
    var delta = 5;
    var shadowHeight = 10;
    var $adminBar = $('#wpadminbar');

    if ($adminBar.length > 0) {
        $navigation.css('top', $adminBar.outerHeight());
    }

    $(window).on('scroll', function() {
        didScroll = true;
    });

    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        st = $(window).scrollTop();
        navbarHeight = ($navigation.outerHeight() + shadowHeight);
        
        if (Math.abs(lastScrollTop - st) <= delta) {
            return;
        }
        
        if (st > lastScrollTop && st > navbarHeight){
            $navigation.css('top', (-1*navbarHeight));
        } else {
            if (st + $(window).height() < $(document).height()) {
                $navigation.css('top', ($adminBar.length > 0 ? $adminBar.outerHeight() : 0));
            }
        }
        
        lastScrollTop = st;
    }
});
    $.Markets = {};

    $.Markets.options = {
        leftSideBar: {
            scrollColor: 'rgba(200,200,200,0.5)',
            scrollWidth: '8px',
            scrollAlwaysVisible: true,
            scrollBorderRadius: '0',
            scrollRailBorderRadius: '0',
            scrollActiveItemWhenPageLoad: true,
            breakpointWidth: 1170
        },
        dropdownMenu: {
            effectIn: 'fadeIn',
            effectOut: 'fadeOut'
        }
    }

    $.Markets.leftSideBar = {
        activate: function () {
            var _this = this;
            var $body = $('body');
            var $overlay = $('.overlay');

            //Close sidebar
            $(window).click(function (e) {
                var $target = $(e.target);
                if (e.target.nodeName.toLowerCase() === 'i') { $target = $(e.target).parent(); }

                if (!$target.hasClass('bars') && _this.isOpen() && $target.parents('#leftsidebar').length === 0) {
                    if (!$target.hasClass('js-right-sidebar')) $overlay.fadeOut();
                    $body.removeClass('overlay-open');
                }
            });

            $.each($('.menu-toggle.toggled'), function (i, val) {
                $(val).next().slideToggle(0);
            });

            //When page load
            $.each($('.menu .list li.active'), function (i, val) {
                var $activeAnchors = $(val).find('a:eq(0)');

                $activeAnchors.addClass('toggled');
                $activeAnchors.next().show();
            });

            //Collapse or Expand Menu
            $('.menu-toggle').on('click', function (e) {
                var $this = $(this);
                var $content = $this.next();

                if ($($this.parents('ul')[0]).hasClass('list')) {
                    var $not = $(e.target).hasClass('menu-toggle') ? e.target : $(e.target).parents('.menu-toggle');

                    $.each($('.menu-toggle.toggled').not($not).next(), function (i, val) {
                        if ($(val).is(':visible')) {
                            $(val).prev().toggleClass('toggled');
                            $(val).slideUp();
                        }
                    });
                }

                $this.toggleClass('toggled');
                $content.slideToggle(320);
            });

            //Set menu height
            _this.setMenuHeight(true);
            _this.checkStatusForResize(true);
            $(window).resize(function () {
                _this.setMenuHeight(false);
                _this.checkStatusForResize(false);
            });

            //Set Waves
            Waves.attach('.menu .list a', ['waves-block']);
            Waves.init();
        },
        setMenuHeight: function (isFirstTime) {
            if (typeof $.fn.slimScroll != 'undefined') {
                var configs = $.Markets.options.leftSideBar;
                var height = ($(window).height() - ($('.legal').outerHeight() + $('.user-info').outerHeight() + $('.navbar').innerHeight()));
                var $el = $('.list');

                if (!isFirstTime) {
                    $el.slimscroll({
                        destroy: true
                    });
                }

                $el.slimscroll({
                    height: height + "px",
                    color: configs.scrollColor,
                    size: configs.scrollWidth,
                    alwaysVisible: configs.scrollAlwaysVisible,
                    borderRadius: configs.scrollBorderRadius,
                    railBorderRadius: configs.scrollRailBorderRadius
                });

                //Scroll active menu item when page load, if option set = true
                if ($.Markets.options.leftSideBar.scrollActiveItemWhenPageLoad) {
                    var item = $('.menu .list li.active')[0];
                    if (item) {
                        var activeItemOffsetTop = item.offsetTop;
                        if (activeItemOffsetTop > 150) $el.slimscroll({ scrollTo: activeItemOffsetTop + 'px' });
                    }
                }
            }
        },
        checkStatusForResize: function (firstTime) {
            var $body = $('body');
            var $openCloseBar = $('.navbar .navbar-header .bars');
            var width = $body.width();

            if (firstTime) {
                $body.find('.content, .sidebar').addClass('no-animate').delay(1000).queue(function () {
                    $(this).removeClass('no-animate').dequeue();
                });
            }

            if (width < $.Markets.options.leftSideBar.breakpointWidth) {
                $body.addClass('ls-closed');
                $openCloseBar.fadeIn();
            }
            else {
                $body.removeClass('ls-closed');
                $openCloseBar.fadeOut();
            }
        },
        isOpen: function () {
            return $('body').hasClass('overlay-open');
        }
    };

    $.Markets.navbar = {
        activate: function () {
            var $body = $('body');
            var $overlay = $('.overlay');

            //Open left sidebar panel
            $('.bars').on('click', function () {
                $body.toggleClass('overlay-open');
                if ($body.hasClass('overlay-open')) { $overlay.fadeIn(); } else { $overlay.fadeOut(); }
            });

            //Close collapse bar on click event
            $('.nav [data-close="true"]').on('click', function () {
                var isVisible = $('.navbar-toggle').is(':visible');
                var $navbarCollapse = $('.navbar-collapse');

                if (isVisible) {
                    $navbarCollapse.slideUp(function () {
                        $navbarCollapse.removeClass('in').removeAttr('style');
                    });
                }
            });
        }
    }


    $(function () {
        $.Markets.leftSideBar.activate();
        $.Markets.navbar.activate();
        setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 50);
    });

    function createRatings(drating){
        var rating = ``;
        if (drating != 0){
            if (drating > 0)
                rating = `<span class="fa fa-star checked"></span>`;
            else
                rating = `<span class="fa fa-star"></span>`;
            if (drating > 1)
                rating = `${rating}<span class="fa fa-star checked"></span>`;
            else
                rating = `${rating}<span class="fa fa-star"></span>`;
            if (drating > 2)
                rating = `${rating}<span class="fa fa-star checked"></span>`;
            else
                rating = `${rating}<span class="fa fa-star"></span>`;
            if (drating > 3)
                rating = `${rating}<span class="fa fa-star checked"></span>`;
            else
                rating = `${rating}<span class="fa fa-star"></span>`;
            if (drating > 4)
                rating = `${rating}<span class="fa fa-star checked"></span>`;
            else
                rating = `${rating}<span class="fa fa-star"></span>`;
        }
        return rating;
    }

// Animate
(function(theme, $) {

    theme = theme || {};

    var instanceName = '__animate';

    var PluginAnimate = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginAnimate.defaults = {
        accX: 0,
        accY: -150,
        delay: 1
    };

    PluginAnimate.prototype = {
        initialize: function($el, opts) {
            if ( $el.data( instanceName ) ) {
                return this;
            }

            this.$el = $el;

            this
                .setData()
                .setOptions(opts)
                .build();

            return this;
        },

        setData: function() {
            this.$el.data(instanceName, this);

            return this;
        },

        setOptions: function(opts) {
            this.options = $.extend(true, {}, PluginAnimate.defaults, opts, {
                wrapper: this.$el
            });

            return this;
        },

        build: function() {
            var self = this,
                $el = this.options.wrapper,
                delay = 0;

            $el.addClass('appear-animation');

            if(!$('html').hasClass('no-csstransitions') && $(window).width() > 767) {

                $el.appear(function() {

                    delay = ($el.attr('data-appear-animation-delay') ? $el.attr('data-appear-animation-delay') : self.options.delay);

                    if(delay > 1) {
                        $el.css('animation-delay', delay + 'ms');
                    }

                    $el.addClass($el.attr('data-appear-animation'));

                    setTimeout(function() {
                        $el.addClass('appear-animation-visible');
                    }, delay);

                }, {accX: self.options.accX, accY: self.options.accY});

            } else {

                $el.addClass('appear-animation-visible');

            }

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginAnimate: PluginAnimate
    });

    // jquery plugin
    $.fn.themePluginAnimate = function(opts) {
        return this.map(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginAnimate($this, opts);
            }

        });
    };

}).apply(this, [ window.theme, jQuery ]);
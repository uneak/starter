// Scrollable
(function(theme, $) {

    theme = theme || {};

    var instanceName = '__scrollable';

    var PluginScrollable = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginScrollable.defaults = {
        contentClass: 'scrollable-content',
        paneClass: 'scrollable-pane',
        sliderClass: 'scrollable-slider',
        alwaysVisible: true,
        preventPageScrolling: true
    };

    PluginScrollable.prototype = {
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
            this.options = $.extend(true, {}, PluginScrollable.defaults, opts, {
                wrapper: this.$el
            });

            return this;
        },

        build: function() {
            this.options.wrapper.nanoScroller(this.options);

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginScrollable: PluginScrollable
    });

    // jquery plugin
    $.fn.themePluginScrollable = function(opts) {
        return this.each(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginScrollable($this, opts);
            }

        });
    }

}).apply(this, [ window.theme, jQuery ]);
// MaxLength
(function(theme, $) {

    theme = theme || {};

    var instanceName = '__maxlength';

    var PluginMaxLength = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginMaxLength.defaults = {
        alwaysShow: true,
        placement: 'bottom-left',
        warningClass: 'label label-success bottom-left',
        limitReachedClass: 'label label-danger bottom-left'
    };

    PluginMaxLength.prototype = {
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
            this.options = $.extend( true, {}, PluginMaxLength.defaults, opts );

            return this;
        },

        build: function() {
            this.$el.maxlength( this.options );

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginMaxLength: PluginMaxLength
    });

    // jquery plugin
    $.fn.themePluginMaxLength = function(opts) {
        return this.each(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginMaxLength($this, opts);
            }

        });
    }

}).apply(this, [ window.theme, jQuery ]);
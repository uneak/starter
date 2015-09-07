// Word Rotate
(function(theme, $) {

    theme = theme || {};

    var instanceName = '__wordRotate';

    var PluginWordRotate = function($el, opts) {
        return this.initialize($el, opts);
    };

    PluginWordRotate.defaults = {
        delay: 2000
    };

    PluginWordRotate.prototype = {
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
            this.options = $.extend(true, {}, PluginWordRotate.defaults, opts, {
                wrapper: this.$el
            });

            return this;
        },

        build: function() {
            var $el = this.options.wrapper,
                itemsWrapper = $el.find(".word-rotate-items"),
                items = itemsWrapper.find("> span"),
                firstItem = items.eq(0),
                firstItemClone = firstItem.clone(),
                itemHeight = firstItem.height(),
                currentItem = 1,
                currentTop = 0;

            itemsWrapper.append(firstItemClone);

            $el
                .height(itemHeight)
                .addClass("active");

            setInterval(function() {

                currentTop = (currentItem * itemHeight);

                itemsWrapper.animate({
                    top: -(currentTop) + "px"
                }, 300, function() {

                    currentItem++;

                    if(currentItem > items.length) {

                        itemsWrapper.css("top", 0);
                        currentItem = 1;

                    }

                });

            }, this.options.delay);

            return this;
        }
    };

    // expose to scope
    $.extend(theme, {
        PluginWordRotate: PluginWordRotate
    });

    // jquery plugin
    $.fn.themePluginWordRotate = function(opts) {
        return this.each(function() {
            var $this = $(this);

            if ($this.data(instanceName)) {
                return $this.data(instanceName);
            } else {
                return new PluginWordRotate($this, opts);
            }

        });
    }

}).apply(this, [ window.theme, jQuery ]);
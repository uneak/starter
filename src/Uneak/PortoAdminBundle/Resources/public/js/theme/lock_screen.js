// Lock Screen
(function( $ ) {

    'use strict';

    var LockScreen = {

        initialize: function() {
            this.$body = $( 'body' );

            this
                .build()
                .events();
        },

        build: function() {
            var lockHTML,
                userinfo;

            userinfo = this.getUserInfo();
            this.lockHTML = this.buildTemplate( userinfo );

            this.$lock        = this.$body.children( '#LockScreenInline' );
            this.$userPicture = this.$lock.find( '#LockUserPicture' );
            this.$userName    = this.$lock.find( '#LockUserName' );
            this.$userEmail   = this.$lock.find( '#LockUserEmail' );

            return this;
        },

        events: function() {
            var _self = this;

            this.$body.find( '[data-lock-screen="true"]' ).on( 'click', function( e ) {
                e.preventDefault();

                _self.show();
            });

            return this;
        },

        formEvents: function( $form ) {
            var _self = this;

            $form.on( 'submit', function( e ) {
                e.preventDefault();

                _self.hide();
            });
        },

        show: function() {
            var _self = this,
                userinfo = this.getUserInfo();

            this.$userPicture.attr( 'src', userinfo.picture );
            this.$userName.text( userinfo.username );
            this.$userEmail.text( userinfo.email );

            this.$body.addClass( 'show-lock-screen' );

            $.magnificPopup.open({
                items: {
                    src: this.lockHTML,
                    type: 'inline'
                },
                modal: true,
                mainClass: 'mfp-lock-screen',
                callbacks: {
                    change: function() {
                        _self.formEvents( this.content.find( 'form' ) );
                    }
                }
            });
        },

        hide: function() {
            $.magnificPopup.close();
        },

        getUserInfo: function() {
            var $info,
                picture,
                name,
                email;

            // always search in case something is changed through ajax
            $info    = $( '#userbox' );
            picture  = $info.find( '.profile-picture img' ).attr( 'data-lock-picture' );
            name     = $info.find( '.profile-info' ).attr( 'data-lock-name' );
            email    = $info.find( '.profile-info' ).attr( 'data-lock-email' );

            return {
                picture: picture,
                username: name,
                email: email
            };
        },

        buildTemplate: function( userinfo ) {
            return [
                '<section id="LockScreenInline" class="body-sign body-locked body-locked-inline">',
                '<div class="center-sign">',
                '<div class="panel panel-sign">',
                '<div class="panel-body">',
                '<form>',
                '<div class="current-user text-center">',
                '<img id="LockUserPicture" src="{{picture}}" alt="John Doe" class="img-circle user-image" />',
                '<h2 id="LockUserName" class="user-name text-dark m-none">{{username}}</h2>',
                '<p  id="LockUserEmail" class="user-email m-none">{{email}}</p>',
                '</div>',
                '<div class="form-group mb-lg">',
                '<div class="input-group input-group-icon">',
                '<input id="pwd" name="pwd" type="password" class="form-control input-lg" placeholder="Password" />',
                '<span class="input-group-addon">',
                '<span class="icon icon-lg">',
                '<i class="fa fa-lock"></i>',
                '</span>',
                '</span>',
                '</div>',
                '</div>',

                '<div class="row">',
                '<div class="col-xs-6">',
                '<p class="mt-xs mb-none">',
                '<a href="#">Not John Doe?</a>',
                '</p>',
                '</div>',
                '<div class="col-xs-6 text-right">',
                '<button type="submit" class="btn btn-primary">Unlock</button>',
                '</div>',
                '</div>',
                '</form>',
                '</div>',
                '</div>',
                '</div>',
                '</section>'
            ]
                .join( '' )
                .replace( /\{\{picture\}\}/, userinfo.picture )
                .replace( /\{\{username\}\}/, userinfo.username )
                .replace( /\{\{email\}\}/, userinfo.email );
        }

    };

    this.LockScreen = LockScreen;

    $(function() {
        LockScreen.initialize();
    });

}).apply(this, [ jQuery ]);
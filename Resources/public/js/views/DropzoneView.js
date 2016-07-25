(function () {
    tuna.view.DropzoneView = Backbone.View.extend({
        
        initialize: function (options) {
            Dropzone.autoDiscover = false;

            this.oThis = options.oThis;

            this.options = options.options;
            this.setupOptions();
            this.createDropzone();
            this.bindEvents();
        },

        createDropzone: function () {
            this.dropzone = this.$el.dropzone(this.defaultOttions);
        },

        bindEvents: function () {
            this.dropzone.on('dragbetterenter', _.bind(function() {
                this.$el.addClass('drag-over');
            }, this));

            this.dropzone.on('dragbetterleave', _.bind(function() {
                this.$el.removeClass('drag-over');
            }, this));
        },
        
        setupOptions: function () {
            var oThis = this;

            oThis.defaultOttions = _.extend({
                url: '/admin/file/upload/',
                acceptedFiles: '.jpg, .jpeg, .gif',
                paramName: 'file',
                clickable:'[data-dropzone-clickable]',
                addedfile: function () {},
                error: function (file, errorMessage) {
                    alert(errorMessage);
                },
                init: function () {
                    this.on('success', _.bind(function(file, response) {
                        oThis.oThis.uploadCallback(response);
                    }, this));

                    this.on("queuecomplete", _.bind(function () {
                        oThis.onSendingComplate();
                        this.removeAllFiles();
                    }, this));

                    this.on("sending", _.bind(function () {
                        oThis.onSending();
                    }, this));
                }
            }, oThis.options);

            this.$el.attr('data-dropover-text', this.options.dropoverText);
        },

        onSendingComplate: function () {
            this.$el.removeClass('sending');
        },

        onSending: function () {
            this.$el.addClass('sending');
        }
    });
})();

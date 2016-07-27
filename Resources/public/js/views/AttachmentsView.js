(function () {
    tuna.view.AttachmentsView = Backbone.View.extend({
        events: {
            "click .delete": "_onClickDelete",
            "change input[type='file']": "_onInputFileChange",
            'click .close': "_onClose",
            'close': "_onClose",
            'open': "_onOpen",
            'click': "_onClick",
            'click .a2lix_translationsLocales li a': "_onLanguageChange"
        },

        initialize: function () {
            this.$el.addClass('magictime');
            this._initSortable();
            this.$wrapper = this.$('.thecodeine_admin_attachments');
            this.$wrapper.data('index', this.$('li.item').length);

            var options = this.$('[data-dropzone-options]').data('dropzone-options');

            new tuna.view.DropzoneView({
                el: $(options.selector),
                options: options,
                oThis: this
            });
        },

        _onClose: function () {
            this.$el.removeClass('slideLeftRetourn').addClass('holeOut');
        },

        _onOpen: function () {
            $('.admin-gallery-container').trigger('close');
            this.$el.removeClass('holeOut').show().addClass('slideLeftRetourn');
        },

        recalculateItemPositions: function () {
            this.$('input.position').each(function (idx) {
                $(this).val(idx);
            });
        },

        _initSortable: function () {
            var oThis = this;
            this.$('.attachments')
                .sortable({
                    handle: '.handle'
                })
                .disableSelection()
                .bind('sortupdate', function () {
                    oThis.recalculateItemPositions();
                });
        },

        _destroySortable: function () {
            this.$('.attachments').sortable('destroy');
        },

        _onClick: function (e) {
            e.stopPropagation();
        },

        addItem: function (response) {
            this._destroySortable();
            var prototype = this.$('.thecodeine_admin_attachments a').data('prototype');
            var index = this.$wrapper.data('index') + 1;
            this.$wrapper.data('index', index);

            var $newForm = $(prototype.replace(/__name__/g, index));

            $newForm.find('.form--path input').val(response.path);
            $newForm.find('.form--filename input').val(response.originalName);
            $newForm.find('.options-container .btn').attr('href', '/uploads/tmp/'+response.path+'');

            this.$('.attachments').append($newForm);

            this._initSortable();
            this.recalculateItemPositions();
        },

        _onClickDelete: function (e) {
            $(e.currentTarget).closest('.item').remove()
        },

        _onLanguageChange: function (e) {
            Backbone.trigger('LanguageChange', e);
        },

        _onInputFileChange: function (e) {
            var fileName = e.target.value.split(/(\\|\/)/g).pop();
            var container = $(e.target.closest('.item')).find('.item-name .tab-content');
            container.find('.attachment-name').remove();
            container.append('<p class="attachment-name">' + Translator.trans('Added') + ': ' + fileName + '</p>')
        },
        uploadCallback: function (response) {
            this.addItem(response);
        }
    });
})();

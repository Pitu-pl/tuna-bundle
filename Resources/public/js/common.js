window.tuna || (window.tuna = {
    locale: 'pl',
    website: {},
    backbone: {},
    templates: {},
    view: {
        helpers: {}
    },
    model: {},
    collection: {},
    router: {},
    features: {},
    config: {
        localeMap: {
            'en': 'en-US',
            'pl': 'pl-PL'
        }
    }
});

/**
 * Main admin website object
 *
 */
tuna.website = {
    init: function (options) {
        this.options = options;

        //init main views
        new tuna.view.NavigationView({el: $('nav')[0]});
        new tuna.view.ListView({el: $('.admin-list')[0]});
        new tuna.view.OptionsView({el: $('.admin-option-container')[0]});
        new tuna.view.GalleryView({el: $('.admin-gallery-container')[0]});
        new tuna.view.AttachmentsView({el: $('.admin-attachments-container')[0]});
        new tuna.view.EditView({el: $('.admin-container')[0], lang: options.lang});
        new tuna.view.AddableEntitySelectView({el: $('.addable-entity-select')});
        new tuna.view.SortableView({el: $('[data-sortable-url]')});

        //WYSIWYG EDITOR
        tuna.view.EditorView && new tuna.view.EditorView({
            selector: '.tab-pane.active .thecodeine_admin_editor',
            lang: options.lang
        });

        $(':checkbox').radiocheck();
        $('select').select2();
    },

    goToUri: function (uri) {
        top.location.href = uri;
    }
};

function tunaConfirm(msg) {
    var dfd = $.Deferred();
    $('#modalConfirm').modal('hide'); // don't allow multiple modals
    $('#modalConfirm .modal-body p').html(msg);
    $('#modalConfirm').modal({
        keyboard: true
    });
    $('#modalConfirm [data-action="accept"]').on('click', function () {
        $('#modalConfirm').off('hide.bs.modal').modal('hide');
        dfd.resolve();
    });
    $('#modalConfirm').on('hide.bs.modal', function (event) {
        dfd.reject();
    });

    return dfd.promise();
}

function tunaAlert(msg) {
    alert(msg);
}

// Add confirmation

define(['jquery', 'core/str', 'core/notification'], function($, str, notification) {

    /* Displays the delete confirmation and on approval redirects to href
       @param {String} href */
    var confirmDelete = function(href) {
        str.get_strings([
            {key: 'delete'},
            {key: 'confirmdeleteentry', component: 'tool_dmarag'},
            {key: 'yes'},
            {key: 'no'}
        ]).done(function(s) {
                notification.confirm(s[0], s[1], s[2], s[3], function() {
                    window.location.href = href;
                });
            }
        ).fail(notification.exception);
    };

    /* Registers the handler for click event
       @param {String} selector */
    var registerClickHandler = function(selector) {
        $(selector).on('click', function(e) {
            e.preventDefault();
            var href = $(e.currentTarget).attr('href');
            confirmDelete(href);
        });
    };

    return  {

        /* Initialise the confirmation for selector */
        init: function(selector) {
            registerClickHandler(selector);
        }
    };
});
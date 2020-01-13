jQuery(document).ready(function($) {
    "use strict";
    $('body .widget .filter-job-horizontal').each(function(){
        var self = $(this);

        var el = self.find('.workup-filter-job-fields'),
            el_adv = self.find('.workup-filter-job-adv-fields'),
            el_sort = self.find('.wp-job-board-filter-sort-field');
            el_sort_adv = self.find('.wp-job-board-filter-sort-adv-field');

        el.sortable({
            update: function(event, ui) {
                var data = el.sortable('toArray', {
                    attribute: 'data-field-id'
                });
                el_sort.attr('value', data).trigger('change');
            }
        });

        $('body').on('change', '.filter-job-horizontal .workup-filter-job-fields input[type=checkbox]', function() {
            if ($(this).is(':checked')) {
                $(this).closest('li').addClass('invisible');
            } else {
                $(this).closest('li').removeClass('invisible');
            }
        });

        // advance
        el_adv.sortable({
            update: function(event, ui) {
                var data = el.sortable('toArray', {
                    attribute: 'data-field-id'
                });

                el_sort_adv.attr('value', data);
            }
        });

        $('body').on('change', '.filter-job-horizontal .workup-filter-job-adv-fields input[type=checkbox]', function() {
            if ($(this).is(':checked')) {
                $(this).closest('li').addClass('invisible');
            } else {
                $(this).closest('li').removeClass('invisible');
            }
        });

        $('body').on('change', '.show_adv_fields', function() {
            var container = $(this).closest('.filter-job-horizontal');
            if ( $(this).is(':checked') ) {
                console.log('aaa');
                container.find('.workup-filter-job-adv-fields-wrapper').show();
            } else {
                console.log('bbb');
                container.find('.workup-filter-job-adv-fields-wrapper').hide();
            }
        });
        if ( self.find('.show_adv_fields').is(':checked') ) {
            self.find('.workup-filter-job-adv-fields-wrapper').show();
        } else {
            self.find('.workup-filter-job-adv-fields-wrapper').hide();
        }
    });
    
});
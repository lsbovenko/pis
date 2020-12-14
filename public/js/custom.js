(function ($) {
    $(document).ready(function () {
        (function () {
            $(".js-disable-after-submit").on('submit', function () {
                $(this).find('[type="submit"]').attr('disabled', 'disabled');
            });

            if ($('#select-status-id option:selected').val() == $('#hidden-active-status-id').val()) {
                $('#textarea-details').hide();
            }
        })();

        $('#select-status-id').on('change', function() {
            if (this.value == $('#hidden-active-status-id').val()) {
                $('#textarea-details').hide();
            } else {
                $('#textarea-details').show();
            }
        });

        var searchIdea = $('#search-idea');
        var searchIdeaVuejs = $('#search-idea-vuejs');

        searchIdea.on('input', function () {
            var searchIdeaVal = $(this).val();
            var searchIdeaVuejsVal = searchIdeaVuejs.val();

            searchIdeaVuejs.val(searchIdeaVal);
            if (!(searchIdeaVal.length === 1 && searchIdeaVuejsVal.length === 0)) {
                setTimeout(function() {
                    if (searchIdeaVal === searchIdea.val()) {
                        searchIdeaVuejs.click();
                    }
                    },300);
            }
        });
        if (searchIdeaVuejs.attr('urlSearch')) {
            searchIdeaVuejs.val(searchIdeaVuejs.attr('urlSearch'));
            searchIdeaVuejs.click();
            searchIdeaVuejs.attr('pageSearch', 0);
        }

        $('#form-search-idea').submit(function () {
            return false;
        });

        var datepicker = $('#datepicker');
        var datepickerDates = $('#datepicker-dates');
        var dp = datepicker.datepicker({
            range: true,
            maxDate: new Date(),
            dateFormat: 'yyyy-mm-dd',
            language: 'en',

            onSelect: function(formattedDate, date, inst) {
                //add value of datepicker to hidden field in filter
                datepickerDates.val(formattedDate);
                if (date.length === 2) {
                    datepickerDates.click();
                }
            }
        });
        if (datepickerDates.attr('urlDates')) {
            var urlDates = datepickerDates.attr('urlDates').split(',');
            dp.data('datepicker').selectDate([new Date(urlDates[0]), new Date(urlDates[1])]);
            datepickerDates.attr('pageDatepicker', 0);
        }

        $('#reset-filters').on('click', function () {
            datepicker.datepicker().data('datepicker').clear();
        });

        /**
         * Disable 'Up/Down/Enter' buttons,
         * because plugin 'bootstrap select' have a bug - buttons 'Up/Down' works incorrect when we use search
         */
        $('.executors-select').keydown(function (e) {
            if (e.which == 38 || e.which == 40 || e.which == 13) {
                e.preventDefault();
                return false;
            }
        });
    });
})(jQuery);

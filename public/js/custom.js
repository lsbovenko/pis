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

        $('#form-search-idea').submit(function () {
            return false;
        });

        var datepicker = $('#datepicker');
        var datepickerDates = $('#datepicker-dates');
        datepicker.datepicker({
            range: true,
            maxDate: new Date(),
            dateFormat: 'yyyy-mm-dd',

            onSelect: function(formattedDate, date, inst) {
                //add value of datepicker to hidden field in filter
                datepickerDates.val(formattedDate);
                if (date.length === 2) {
                    datepickerDates.click();
                }
            }
        });

        $('#reset-filters').on('click', function () {
            datepicker.datepicker().data('datepicker').clear();
        });
    });
})(jQuery);
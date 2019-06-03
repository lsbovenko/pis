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
    });
})(jQuery);
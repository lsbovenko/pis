(function () {


    $(".js-disable-after-submit").on('submit', function () {
        $(this).find('[type="submit"]').attr('disabled','disabled');
    });
})();
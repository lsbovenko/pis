(function () {
    $(".js-disable-after-submit").on('submit', function () {
        $(this).find('[type="submit"]').attr('disabled','disabled');
    });
})();

//filter
(function () {
    var $form = $("#fiter");
    $form.find('select').on('change', function (e) {
        $form.submit();
    });
})();
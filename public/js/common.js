(function ($) {
    "use strict";
    $(document).ready(function () {
        function homeheaderInit() {
            $(window).scroll(
                function () {
                    var topScroll = $(this).scrollTop();
                    if (topScroll > 50) {
                        $('.header').addClass('header-scroll');
                    } else if (topScroll < 50) {
                        $('.header').removeClass('header-scroll');
                    }
                }
            );
        }

        homeheaderInit();
        $('.dropdown-toggle').dropdown();

        // Mobile menu button

        $('.menu-btn').on('click', function () {
            $('.mobile-left-menu').addClass('open');
            $('.overlay').fadeIn(500);
        });
        $('.left-mobile-menu-close').on('click', function () {
            $('.mobile-left-menu').removeClass('open');
            $('.overlay').fadeOut(500);
        });
        $(".td-collapse").hide();
        $(window).resize(function () {
            var windowWidth = $(this).width();
            if (windowWidth < 767) {
                $(".td-collapse").css({'display': 'block'}).hide();
            } else if (windowWidth > 767) {
                $(".td-collapse").css({'display': 'table-cell'}).show();
            }
        });
        $('.collapse-arrow').on("click", function () {
            $(this).parents("tr").find(".td-collapse").slideToggle("slow");
        });

        //Datepicker
        //s$('.input-daterange').datepicker({});
        //Table colHover
        function tableColActive() {
            var index = $('.init-selected-col-td').index();
            $('.tableColHover tr').each(function (i) {
                $(this).children('td').eq(index).addClass('init-selected-col-td');
            });
        };
        tableColActive();

        function tableColHover() {
            $('.tableColHover td').mouseover(function () {
                var index = $(this).index();
                $('.tableColHover tr').each(function (i) {
                    $(this).children('td').eq(index).addClass('select-td');
                });
            });
            $('.tableColHover td').mouseout(function () {
                var index = $(this).index();
                $('.tableColHover tr').each(function (i) {
                    $(this).children('td').eq(index).removeClass('select-td');
                });
            });
        }

        tableColHover();

        //DropDown
        function customerDropDown() {
            $('.customer-select li').on('click', function () {
                var text = $(this).addClass('active').find('a').text();
                $(this).siblings('li').removeClass('active');
                $(this).parents('ul').siblings('.btn').html('<em>' + text + '</em><span class="caret"></span>');
            });
        }

        customerDropDown();

        //Modal function
        function modal() {
            $('.modal-btn').on("click", function () {
                $('body').addClass('modal-open');
                var modalTarget = $(this).attr('data-target');
                $(modalTarget).css({'top': '0', 'opacity': '1'});

            });
            $(".close-btn").on("click", function () {
                $('.modal-box').css({'opacity': '0', 'top': '-9999px'});
            });
        }

        modal();

        // avatarColor
        function getRandomColor() {
            var letters = "01234567890ABCDEF";
            var color = "#";
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function avatarColor(elem1) {
            $(elem1).find('.avatar').each(function (index) {
                $(this).css({'background-color': getRandomColor()});
            })
        }

        avatarColor($('body'));
        $('.sameblock').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
        $('.mobile-btn').on('click', function () {
            $('.left-sidebar').toggleClass('open');
        })
        //  Summernote
        $('#summernote').summernote({
            height: 144,
            placeholder: 'Описание',
            toolbar: [
                ['style', ['bold', 'underline', 'italic']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['picture', 'link']]
            ]
        });
    });
})(jQuery);

var token = jQuery('meta[name="csrf-token"]').attr('content');
var count_like = jQuery('#count_ideas_like');

jQuery(document).on('click','#add_like_user', function () {
    var name = jQuery(this).data('name'),
        id = jQuery(this).data('id'),
        id_idea = jQuery(this).data('idea');

    if (name && id) {
        count_like.html(parseInt(count_like.html()) + 1);
        console.log('add');
        jQuery.ajax({
            url: '/add-like',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: {id: id_idea, user_id: id},
            success: function () {
                jQuery('.btn_like_' + id_idea)
                    .attr('id', 'remove_like_user')
                    .find('.i-support')
                    .addClass('btn_liked');
                jQuery('.liked_users_' + id_idea).html(name + ' ' + jQuery('.liked_users_' + id_idea).html());
                console.log('succes add like');
            }
        });
    }else{
        console.log('error add like');
    }
});

jQuery(document).on('click', '#remove_like_user', function () {
    var name = jQuery(this).data('name'),
        id = jQuery(this).data('id'),
        id_idea = jQuery(this).data('idea');

    if (name && id) {
        count_like.html(parseInt(count_like.html()) - 1);
        console.log('remove');
        jQuery.ajax({
            url: '/remove-like',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: {id: id_idea, user_id: id},
            success: function () {
                jQuery('.btn_like_' + id_idea)
                    .attr('id', 'add_like_user')
                    .find('.i-support')
                    .removeClass('btn_liked');
                var str = jQuery('.liked_users_' + id_idea).html();
                jQuery('.liked_users_' + id_idea).html(str.replace(name + '', ''));
                console.log('succes remove like');
            }
        });
    }else{
        console.log('error add like');
    }
});

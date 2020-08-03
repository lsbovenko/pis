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

        var tags = $('#tags');
        if (tags.length) {
            tags.tagsinput({itemValue: 'id', itemText: 'name'});

            var tagSelect = $('#tags_select');
            EnableDisableCtrlKeyForTagList(tagSelect);

            var tagInput = $('.bootstrap-tagsinput :input');
            AddTagByClickOnTagList(tagSelect, tags, tagInput);

            AddTagByEnterKey(tags, tagInput);

            AddTagByFocusOut(tagInput);

            ShowTagInTagListWhenTagRemove(tags);

            if (tags.val()) {
                AddTagsAndHideTagsInTagListAfterBadSubmit(tags);
            } else {
                var tagsExclude = $('#tags_exclude');
                AddTagsAndHideTagsInTagListAtStart(tagsExclude, tags);
            }
        }

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

        var similarIdeasId = $('#similar_ideas_id');
        var similarIdeasInfo = $('#similar_ideas_info');
        var searchSimilarIdea = $('#search_similar_idea');
        if (similarIdeasId.length) {
            similarIdeasId.tagsinput({itemValue: 'id', itemText: 'name'});
            AddSimilarIdeasAtStart(similarIdeasId, similarIdeasInfo);
            SearchSimilarIdeasAutocomplete(searchSimilarIdea, similarIdeasId, similarIdeasInfo);
            RemoveSimilarIdea(similarIdeasId, similarIdeasInfo);
        }
    });

    function AddSimilarIdeasAtStart(similarIdeasId, similarIdeasInfo) {
        if (similarIdeasInfo.val()) {
            $.each($.parseJSON(similarIdeasInfo.val()), function (index, value) {
                similarIdeasId.tagsinput('add', {id: value.id, name: value.name});
            });
        }
    }

    function SearchSimilarIdeasAutocomplete(searchSimilarIdea, similarIdeasId, similarIdeasInfo) {
        var xhr;
        $(searchSimilarIdea).autocomplete({
            minLength: 3,
            source: function(request, response) {
                if (xhr) {
                    xhr.abort();
                }
                xhr = $.ajax({
                    url: '/get-idea/similar',
                    type: 'get',
                    data: 'search_similar_idea=' + request.term
                        + '&similar_idea_id=' + similarIdeasId.val()
                        + '&idea_id=' + $('#idea_id').val(),
                    beforeSend: function() {
                        $('.loader-small').show();
                    },
                    success: function(similarIdeasResponse) {
                        response(similarIdeasResponse);
                    },
                    complete: function() {
                        $('.loader-small').hide();
                    }
                });
            },
            select: function (event, ui) {
                similarIdeasId.tagsinput('add', {id: ui.item.value, name: ui.item.label});
                similarIdeasInfo.val(JSON.stringify(similarIdeasId.tagsinput('items')));
                searchSimilarIdea.val('');
                event.preventDefault();
            },
            focus: function (event) {
                event.preventDefault();
            }
        });
    }

    function RemoveSimilarIdea(similarIdeasId, similarIdeasInfo) {
        similarIdeasId.on('beforeItemRemove', function (event) {
            var item;
            var newSimilarIdeasInfo = [];
            $.each($.parseJSON(similarIdeasInfo.val()), function (index, value) {
                if (value.id != event.item.id) {
                    item = {};
                    item.id = value.id;
                    item.name = value.name;
                    newSimilarIdeasInfo.push(item);
                }
            });
            similarIdeasInfo.val(JSON.stringify(newSimilarIdeasInfo));
        });
    }

    function EnableDisableCtrlKeyForTagList(tagSelect) {
        $(document).keydown(function (e) {
            if (e.which == 17) {    //CtrlKey
                tagSelect.prop('disabled', true);
            }
        });
        $(document).keyup(function (e) {
            if (e.which == 17) {    //CtrlKey
                tagSelect.prop('disabled', false);
            }
        });
    }

    function AddTagByClickOnTagList(tagSelect, tags, tagInput) {
        tagSelect.on('click', function () {
            var tagOptionSelected = $('#tags_select option:selected');
            if (tagOptionSelected.val()) {
                tags.tagsinput('add', {id: tagOptionSelected.val(), name: tagOptionSelected.text()});
                tagOptionSelected.hide();
            }
            tagInput.focus();
        });
    }

    function AddTagByEnterKey(tags, tagInput) {
        tagInput.on('keypress', function (event) {
            if (event.which == 13) {    //EnterKey
                var tagInputValue = $.trim(tagInput.val());
                var duplicateTagName = false;

                $.each(tags.tagsinput('items'), function (index, value) {
                    if (tagInputValue == value.name) {
                        duplicateTagName = true;
                    }
                });

                $.each($('#tags_select option:not([style="display: none;"])'), function () {
                    if (tagInputValue == $(this).text()) {
                        tags.tagsinput('add', {id: $(this).val(), name: $(this).text()});
                        tagInput.val('');
                        $(this).hide();
                        duplicateTagName = true;
                    }
                });

                if (tagInputValue && !duplicateTagName) {
                    var tagInputNumberOrNaN = parseInt(tagInputValue);
                    //if tagInputValue not a number
                    if (!(!isNaN(tagInputNumberOrNaN) && tagInputValue.length == tagInputNumberOrNaN.toString().length)) {
                        tags.tagsinput('add', {id: tagInputValue, name: tagInputValue});
                        tagInput.val('');
                    }
                }
            }
        });
    }

    function AddTagByFocusOut(tagInput) {
        tagInput.on('focusout', function () {
            tagInput.trigger($.Event('keypress', {which: 13})); //EnterKey
        });
    }

    function ShowTagInTagListWhenTagRemove(tags) {
        tags.on('beforeItemRemove', function (event) {
            $('#tags_select option[value=' + event.item.id + ']').show();
        });
    }

    function AddTagsAndHideTagsInTagListAfterBadSubmit(tags) {
        var tagsId = tags.val().split(',');
        $.each(tagsId, function (index, value) {
            var tagSelectOption = $('#tags_select option[value="' + value + '"]');
            if (tagSelectOption.length) {
                tags.tagsinput('add', {id: value, name: tagSelectOption.text()});
                tagSelectOption.hide();
            } else {
                tags.tagsinput('add', {id: value, name: value});
            }
        });
    }

    function AddTagsAndHideTagsInTagListAtStart(tagsExclude, tags) {
        if (tagsExclude.val()) {
            $.each($.parseJSON(tagsExclude.val()), function (index, value) {
                tags.tagsinput('add', {id: index, name: value});
                $('#tags_select option[value="' + index + '"]').hide();
            });
        }
    }
})(jQuery);

<script>
    $(document).ready(function () {
        /* choose video */

        $('.select-video').click(function (e) {
            e.preventDefault()
            let type = $(this).attr('data-type');
            loadVideosList(type, '')
        });

        $('#videoGrammarSearch').keyup(function () {
            let search = $(this).val();
            loadVideosList(1, search !== '' ? search : '');
        });
        $('#videoLessonSearch').keyup(function () {
            let search = $(this).val();
            loadVideosList(2, search !== '' ? search : '');
        });

        function loadVideosList(type, keyName) {
            let ids = type == 1 ? getIdsVideoGrammar() : getIdsVideoLesson();
            //let jsonIds = JSON.stringify(ids);
            $.ajax({
                url: "{{ route('admin.lesson.getVideos') }}",
                method: 'GET',
                data: {type: type, keyName: keyName},
                success: function (res) {
                    let videos = res.videos;
                    let tblVideoId = type == 1 ? 'videoGrammarList' : 'videoLessonList'
                    let listVideo = `<table id="` + tblVideoId + `" class="table table-hover">`;
                    if (videos.length > 0) {
                        videos.map(video => {
                            let thumb = JSON.parse(video.ytb_thumbnails).default.url;
                            let mChecked = videoIdsHasVideoId(video.id, ids) ? 'checked' : '';
                            let row = `<tr class="${mChecked}">
                                                <td style="width: auto;">
                                                    <input id="check_video" value="${video.id}" type="checkbox" ${mChecked}>
                                                </td>
                                                <td id="thumb" style="width: 80px;">
                                                    <img id="imgThumb" class="thumbList" src="${thumb}" />
                                                </td>
                                                <td id="title">${video.title}</td>
                                            </tr>`;
                            listVideo += row;
                        });
                    } else {
                        listVideo += `<tr><td colspan="100%" align="center">Không có dữ liệu</td></tr>`;
                    }
                    listVideo += '</table>';
                    if (type == 1) {
                        //  modal Grammar
                        $('#listLessonModal').modal('hide');
                        $('#listGrammarModal').modal('show');
                        $('#listGrammarModal .result-content').html(listVideo);
                    } else {
                        //  modal Lesson
                        $('#listGrammarModal').modal('hide');
                        $('#listLessonModal').modal('show');
                        $('#listLessonModal .result-content').html(listVideo);
                    }
                },
                error: function () {
                    console.log('error')
                }
            })
        }

        $(document).on('click', '#videoGrammarList tr', function (event) {
            let mCheckbox = $("[type='checkbox']", this);
            let currentRow = $(this).closest("tr");
            let id = currentRow.find('#check_video').val();
            let thumb = currentRow.find('#imgThumb').attr('src');
            let title = currentRow.find('td#title').text();

            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }

            if (mCheckbox.is(':checked')) {
                if (!videoGrammarExists(id)) {
                    $("#chooseVideoGrammarList ul").append('<li id="' + id + '">' +
                        '<div class="alert  alert-info alert-dismissible" role="alert">' +
                        '<button id="removeVideoGrammar" data-id=' + id + ' type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button>' +
                        '<span id="grammarVideoId" style="display:none;">' + id + '</span>' +
                        '<img style="margin-right: 10px;" width="50" height="30" src="' + thumb + '"/>' +
                        '<span class="tit">' + title + '</span>' +
                        '</div></li>');
                }
                mCheckbox.closest("tr").addClass("checked");
            } else {
                if (videoGrammarExists(id)) {
                    $('#chooseVideoGrammarList ul #' + id).remove();
                }
                mCheckbox.closest("tr").removeClass("checked");
            }
            // set ids to input
            updateValueIdsVideoGrammar()
        });

        $(document).on('click', '#videoLessonList tr', function (event) {
            let mCheckbox = $("[type='checkbox']", this);
            let currentRow = $(this).closest("tr");
            let id = currentRow.find('#check_video').val();
            let thumb = currentRow.find('#imgThumb').attr('src');
            let title = currentRow.find('td#title').text();
            //let ytbId = currentRow.find('#ytb_id').val();

            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }

            if (mCheckbox.is(':checked')) {
                if (!videoLessonExists(id)) {
                    $("#chooseVideoLessonList ul").append('<li id="' + id + '">' +
                        '<div class="alert  alert-info alert-dismissible" role="alert">' +
                        '<button id="removeVideoLesson" data-id=' + id + ' type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span></button>' +
                        '<span id="lessonVideoId" style="display:none;">' + id + '</span>' +
                        '<img style="margin-right: 10px;" width="50" height="30" src="' + thumb + '"/>' +
                        '<span class="tit">' + title + '</span>' +
                        '</div></li>');
                }
                mCheckbox.closest("tr").addClass("checked");
            } else {
                if (videoLessonExists(id)) {
                    $('#chooseVideoLessonList ul #' + id).remove();
                }
                mCheckbox.closest("tr").removeClass("checked");
            }
            // set ids to input
            updateValueIdsVideoLesson();
        });

        $(document).on('click', '#removeVideoGrammar', function (event) {
            event.preventDefault();
            let id = $(this).attr('data-id');
            $('#chooseVideoGrammarList ul #' + id).remove();
            updateValueIdsVideoGrammar();
        });

        $(document).on('click', '#removeVideoLesson', function (event) {
            event.preventDefault();
            let id = $(this).attr('data-id');
            $('#chooseVideoLessonList ul #' + id).remove();
            updateValueIdsVideoLesson();
        });

        function videoIdsHasVideoId(value, arr) {
            let result = false;
            for (let i = 0; i < arr.length; i++) {
                let name = arr[i];
                if (name == value) {
                    result = true;
                    break;
                }
            }
            return result;
        }

        function videoGrammarExists(id) {
            return $('#chooseVideoGrammarList ul li #grammarVideoId:contains(' + id + ')').length;
        }

        function videoLessonExists(id) {
            return $('#chooseVideoLessonList ul li #lessonVideoId:contains(' + id + ')').length;
        }

        function updateValueIdsVideoGrammar() {
            let ids = getIdsVideoGrammar();
            if ($('.videoGrammarIds').length > 0) {
                $(".videoGrammarIds").attr('value', ids);
            }
        }

        function updateValueIdsVideoLesson() {
            let ids = getIdsVideoLesson();
            if ($('.videoLessonIds').length > 0) {
                $(".videoLessonIds").attr('value', ids);
            }
        }

        function getIdsVideoGrammar() {
            let ids = [];
            $('#chooseVideoGrammarList').each(function () {
                $(this).find('ul li #grammarVideoId').each(function () {
                    let current = $(this);
                    if (current.children().length > 0) {
                        return true;
                    }
                    ids.push(current.text());
                });
            });
            return ids;
        }

        function getIdsVideoLesson() {
            let ids = [];
            $('#chooseVideoLessonList').each(function () {
                $(this).find('ul li #lessonVideoId').each(function () {
                    let current = $(this);
                    if (current.children().length > 0) {
                        return true;
                    }
                    ids.push(current.text());
                });
            });
            return ids;
        }

        /* end choose video */

        /* Speak */
        let indexSpeak = getPositionLastItem('.input_fields_speak #itemDynamic');
        $('.add_more_speak').click(function (e) {
            e.preventDefault();
            $('.input_fields_speak').append('<div class="row" id="itemDynamic" data-position="' + indexSpeak + '">\n' +
                '                                        <div class="number">\n' +
                '                                            <span class="badge badge-info">' + (indexSpeak + 1) + '</span>\n' +
                '                                        </div>\n' +
                '                                        <div class="content">\n' +
                '                                        <div class="row" >\n' +
                '                                        <div class="col-sm-5">\n' +
                '                                            <div class="form-group">\n' +
                '                                                <input type="text" class="form-control form-control-sm"\n' +
                '                                                       name="speak_name_en[' + indexSpeak + ']"\n' +
                '                                                       placeholder="Nhập vào nội dung tiếng anh">\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="col-sm-5">\n' +
                '                                        <input name="id_speak[' + indexSpeak + ']" type="text" value="0" hidden>' +
                '                                            <div class="form-group">\n' +
                '                                                <input type="text" class="form-control form-control-sm"\n' +
                '                                                       name="speak_name_vi[' + indexSpeak + ']"\n' +
                '                                                       placeholder="Nhập vào nội dung tiếng việt">\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="col-sm-2">\n' +
                '                                            <div class="form-group">\n' +
                '                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger remove_speak">\n' +
                '                                                    <i class="fa fa-times"></i>&nbsp;&nbsp; Remove\n' +
                '                                                </a>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                        </div>\n' +
                '                                    </div>');

            indexSpeak++;
            setTotalDynamic(1);
        });
        $('.input_fields_speak').on("click", ".remove_speak", function (e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().parent('div').remove();
            setIndexDynamicLesson(1, '.input_fields_speak #itemDynamic .number .badge');
            setIndexDataPosition('.input_fields_speak #itemDynamic');
        })
        /* End Speak */

        /* Write */
        let indexWrite = getPositionLastItem('.input_fields_write #itemDynamic');
        $('.add_more_write').click(function (e) {
            e.preventDefault();
            $('.input_fields_write').append('<div class="row" id="itemDynamic" data-position="' + indexWrite + '">\n' +
                '                                        <div class="number">\n' +
                '                                            <span class="badge badge-info">' + (indexWrite + 1) + '</span>\n' +
                '                                        </div>\n' +
                '                                        <div class="content">\n' +
                '                                            <div class="row">\n' +
                '                                        <div class="col-sm-5">\n' +
                '                                            <div class="form-group">\n' +
                '                                                <input type="text" class="form-control form-control-sm"\n' +
                '                                                       name="write_name_en[' + indexWrite + ']"\n' +
                '                                                       placeholder="Nhập vào nội dung tiếng anh">\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <input name="id_write[' + indexWrite + ']" type="text" value="0" hidden>' +
                '                                        <div class="col-sm-5">\n' +
                '                                            <div class="form-group">\n' +
                '                                                <input type="text" class="form-control form-control-sm"\n' +
                '                                                       name="write_name_vi[' + indexWrite + ']"\n' +
                '                                                       placeholder="Nhập vào nội dung tiếng việt">\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="col-sm-2">\n' +
                '                                            <div class="form-group">\n' +
                '                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger remove_write">\n' +
                '                                                    <i class="fa fa-times"></i>&nbsp;&nbsp; Remove\n' +
                '                                                </a>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                        </div>\n' +
                '                                    </div>'
            );

            indexWrite++;
            setTotalDynamic(2);
        });
        $('.input_fields_write').on("click", ".remove_write", function (e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().parent('div').remove();
            setIndexDynamicLesson(2, '.input_fields_write #itemDynamic .number .badge');
            setIndexDataPosition('.input_fields_write #itemDynamic');
        })
        /* End Write */

        /* exercises */
        let indexEx = getPositionLastItem('.input_fields_exercises .layoutBorder');
        $('.add_more_exercises').click(function (e) {
            e.preventDefault();
            $('.input_fields_exercises').append(`<div class="layoutBorder" id="itemDynamic" data-position="${indexEx}">
                                                        <div class="row">
                                                            <div class="number">
                                                                <span class="badge badge-info">${indexEx + 1}</span>
                                                            </div>
                                                            <div class="content">
                                                                <input name="id_exercises[${indexEx}]" type="text" value="0" hidden>
                                                                <div class="row">
                                                                    <div class="col-sm-10">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control form-control-sm"
                                                                                   name="exercises_name[${indexEx}]"
                                                                                   placeholder="Nhập nội dung câu hỏi">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <div class="form-group">
                                                                            <a class="btn btn-sm btn-danger remove_exercises"
                                                                               href="javascript:void(0)">
                                                                                <i class="fa fa-times"></i>&nbsp;&nbsp; Remove
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-5">
                                                                        <div class="form-group row">
                                                                            <label for="" class="col-sm-1"><span
                                                                                    class="badge badge-question">1</span></label>
                                                                            <div class="col-sm-11">
                                                                                <input type="text" class="form-control form-control-sm"
                                                                                       name="answer_1[${indexEx}]"
                                                                                       placeholder="Nhập câu trả lời">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="" class="col-sm-1"><span
                                                                                    class="badge badge-question">2</span></label>
                                                                            <div class="col-sm-11">
                                                                                <input type="text" class="form-control form-control-sm"
                                                                                       name="answer_2[${indexEx}]"
                                                                                       placeholder="Nhập câu trả lời">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <div class="form-group row">
                                                                            <label for="" class="col-sm-1"><span
                                                                                    class="badge badge-question">3</span></label>
                                                                            <div class="col-sm-11">
                                                                                <input type="text" class="form-control form-control-sm"
                                                                                       name="answer_3[${indexEx}]"
                                                                                       placeholder="Nhập câu trả lời">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="" class="col-sm-1"><span
                                                                                    class="badge badge-question">4</span></label>
                                                                            <div class="col-sm-11">
                                                                                <input type="text" class="form-control form-control-sm"
                                                                                       name="answer_4[${indexEx}]"
                                                                                       placeholder="Nhập câu trả lời">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-10">
                                                                        <div class="row">
                                                                            <span>Chọn đáp án đúng:&nbsp;&nbsp;&nbsp;</span>
                                                                            <div class="col">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio" id="answer_correct_1_${indexEx}"
                                                                                           name="answer_correct[${indexEx}]" value="1" checked>
                                                                                    <label for="answer_correct_1_${indexEx}"><span
                                                                                            class="badge badge-question margin-circle">1</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio" id="answer_correct_2_${indexEx}"
                                                                                           name="answer_correct[${indexEx}]" value="2">
                                                                                    <label for="answer_correct_2_${indexEx}"><span
                                                                                            class="badge badge-question margin-circle">2</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio" id="answer_correct_3_${indexEx}"
                                                                                           name="answer_correct[${indexEx}]" value="3">
                                                                                    <label for="answer_correct_3_${indexEx}"><span
                                                                                            class="badge badge-question margin-circle">3</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                           type="radio" id="answer_correct_4_${indexEx}"
                                                                                           name="answer_correct[${indexEx}]" value="4">
                                                                                    <label for="answer_correct_4_${indexEx}"><span
                                                                                            class="badge badge-question margin-circle">4</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-10">
                                                                        <div class="form-group">
                                                                            <label for="answer_description">Diễn giải đáp án</label>
                                                                            <textarea name="answer_description[${indexEx}]" rows="3"
                                                                                      class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>`);

            indexEx++;
            setTotalDynamic(3);
        });
        $('.input_fields_exercises').on("click", ".remove_exercises", function (e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().parent().parent('div').remove();
            setIndexDynamicLesson(3, '.input_fields_exercises .layoutBorder .number .badge');
            setIndexDataPosition('.input_fields_exercises .layoutBorder');
        })

        /* End exercises */

        function getPositionLastItem(nameItem) {
            if ($(nameItem).length > 0) {
                let lastPosition = $(nameItem).last().attr('data-position');
                lastPosition++
                return lastPosition;
            } else {
                return 1;
            }
        }

        function setIndexDynamicLesson(type, elementId) {
            $(elementId).each(function (index, item) {
                $(item).html(index + 1);
                if (type == 1) {
                    indexSpeak = index + 1;
                } else if (type == 2) {
                    indexWrite = index + 1;
                } else if (type == 3) {
                    indexEx = index + 1;
                }
            });
            setTotalDynamic(1);
            setTotalDynamic(2);
            setTotalDynamic(3);
        }

        function setIndexDataPosition(elementId) {
            $(elementId).each(function (index, item) {
                $(item).attr("data-position", index);
            });
        }

        setTotalDynamic(1);
        setTotalDynamic(2);
        setTotalDynamic(3);

        function setTotalDynamic(type) {
            if (type == 1) {
                let dataList = $('.input_fields_speak #itemDynamic');
                $('#totalSpeak').html(dataList.length);
            } else if (type == 2) {
                let dataList = $('.input_fields_write #itemDynamic');
                $('#totalWrite').html(dataList.length);
            } else if (type == 3) {
                let dataList = $('.input_fields_exercises .layoutBorder');
                $('#totalExercises').html(dataList.length);
            }
        }

    });
</script>

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
        let indexSpeak = 1;
        $('.add_more_speak').click(function (e) {
            e.preventDefault();
            $('.input_fields_speak').append('<div class="row">\n' +
                '                                        <div class="col-sm-5">\n' +
                '                                            <div class="form-group">\n' +
                '                                                <input type="text" class="form-control form-control-sm"\n' +
                '                                                       name="speak_name_en[' + indexSpeak + ']"\n' +
                '                                                       placeholder="Nhập vào nội dung tiếng anh">\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="col-sm-5">\n' +
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
                '                                    </div>');
            indexSpeak++;
        });
        $('.input_fields_speak').on("click", ".remove_speak", function (e) {
            e.preventDefault();
            $(this).parent().parent().parent('div').remove();
        })
        /* End Speak */

        /* Write */
        let indexWrite = 1;
        $('.add_more_write').click(function (e) {
            e.preventDefault();
            $('.input_fields_write').append('<div class="row">\n' +
                '                                        <div class="col-sm-5">\n' +
                '                                            <div class="form-group">\n' +
                '                                                <input type="text" class="form-control form-control-sm"\n' +
                '                                                       name="write_name_en[' + indexWrite + ']"\n' +
                '                                                       placeholder="Nhập vào nội dung tiếng anh">\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
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
                '                                    </div>');
            indexWrite++;
        });
        $('.input_fields_write').on("click", ".remove_write", function (e) {
            e.preventDefault();
            $(this).parent().parent().parent('div').remove();
        })
        /* End Write */

        /* exercises */
        let indexEx = 1;
        $('.add_more_exercises').click(function (e) {
            e.preventDefault();
            $('.input_fields_exercises').append('<div class="layoutBorder">\n' +
                '                                        <div class="row">\n' +
                '                                            <div class="col-sm-10">\n' +
                '                                                <div class="form-group">\n' +
                '                                                    <input type="text" class="form-control form-control-sm"\n' +
                '                                                           name="exercises_name[' + indexEx + ']"\n' +
                '                                                           placeholder="Nhập nội dung câu hỏi">\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-sm-2">\n' +
                '                                                <div class="form-group">\n' +
                '                                                    <a class="btn btn-sm btn-danger remove_exercises"\n' +
                '                                                       href="javascript:void(0)">\n' +
                '                                                        <i class="fa fa-times"></i>&nbsp;&nbsp; Remove\n' +
                '                                                    </a>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="row">\n' +
                '                                            <div class="col-sm-5">\n' +
                '                                                <div class="form-group row">\n' +
                '                                                    <label for="" class="col-sm-1"><span\n' +
                '                                                            class="badge badge-question">1</span></label>\n' +
                '                                                    <div class="col-sm-11">\n' +
                '                                                        <input type="text" class="form-control form-control-sm"\n' +
                '                                                               name="answer_1[' + indexEx + ']"\n' +
                '                                                               placeholder="Nhập câu trả lời">\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                                <div class="form-group row">\n' +
                '                                                    <label for="" class="col-sm-1"><span\n' +
                '                                                            class="badge badge-question">2</span></label>\n' +
                '                                                    <div class="col-sm-11">\n' +
                '                                                        <input type="text" class="form-control form-control-sm"\n' +
                '                                                               name="answer_2[' + indexEx + ']"\n' +
                '                                                               placeholder="Nhập câu trả lời">\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-sm-5">\n' +
                '                                                <div class="form-group row">\n' +
                '                                                    <label for="" class="col-sm-1"><span\n' +
                '                                                            class="badge badge-question">3</span></label>\n' +
                '                                                    <div class="col-sm-11">\n' +
                '                                                        <input type="text" class="form-control form-control-sm"\n' +
                '                                                               name="answer_3[' + indexEx + ']"\n' +
                '                                                               placeholder="Nhập câu trả lời">\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                                <div class="form-group row">\n' +
                '                                                    <label for="" class="col-sm-1"><span\n' +
                '                                                            class="badge badge-question">4</span></label>\n' +
                '                                                    <div class="col-sm-11">\n' +
                '                                                        <input type="text" class="form-control form-control-sm"\n' +
                '                                                               name="answer_4[' + indexEx + ']"\n' +
                '                                                               placeholder="Nhập câu trả lời">\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="row">\n' +
                '                                            <div class="col-sm-10">\n' +
                '                                                <div class="row">\n' +
                '                                                    <span>Chọn đáp án đúng:&nbsp;&nbsp;&nbsp;</span>\n' +
                '                                                    <div class="col">\n' +
                '                                                        <div class="form-check">\n' +
                '                                                            <input class="form-check-input"\n' +
                '                                                                   type="radio" id="answer_correct_1_' + indexEx + '"\n' +
                '                                                                   name="answer_correct[' + indexEx + ']" value="1" checked>\n' +
                '                                                            <label for="answer_correct_1_' + indexEx + '"><span\n' +
                '                                                                    class="badge badge-question margin-circle">1</span>\n' +
                '                                                            </label>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="col">\n' +
                '                                                        <div class="form-check">\n' +
                '                                                            <input class="form-check-input"\n' +
                '                                                                   type="radio" id="answer_correct_2_' + indexEx + '"\n' +
                '                                                                   name="answer_correct[' + indexEx + ']" value="2">\n' +
                '                                                            <label for="answer_correct_2_' + indexEx + '"><span\n' +
                '                                                                    class="badge badge-question margin-circle">2</span>\n' +
                '                                                            </label>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="col">\n' +
                '                                                        <div class="form-check">\n' +
                '                                                            <input class="form-check-input"\n' +
                '                                                                   type="radio" id="answer_correct_3_' + indexEx + '"\n' +
                '                                                                   name="answer_correct[' + indexEx + ']" value="3">\n' +
                '                                                            <label for="answer_correct_3_' + indexEx + '"><span\n' +
                '                                                                    class="badge badge-question margin-circle">3</span>\n' +
                '                                                            </label>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="col">\n' +
                '                                                        <div class="form-check">\n' +
                '                                                            <input class="form-check-input"\n' +
                '                                                                   type="radio" id="answer_correct_4_' + indexEx + '"\n' +
                '                                                                   name="answer_correct[' + indexEx + ']" value="4">\n' +
                '                                                            <label for="answer_correct_4_' + indexEx + '"><span\n' +
                '                                                                    class="badge badge-question margin-circle">4</span>\n' +
                '                                                            </label>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>');
            indexEx++;
        });
        $('.input_fields_exercises').on("click", ".remove_exercises", function (e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent('div').remove();
        })
        /* End exercises */
    });
</script>

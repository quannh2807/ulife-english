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
                data: { type: type, keyName: keyName },
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
                        listVideo += `<tr><td colspan="100%" align="center">Kh??ng c?? d??? li???u</td></tr>`;
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
                        '<span aria-hidden="true">??</span></button>' +
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
                        '<span aria-hidden="true">??</span></button>' +
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
            $('.input_fields_speak').append(`
                <div class="row" id="itemDynamic" data-position="${indexSpeak + 1}">
                    <div class="number">
                        <span class="badge badge-info">${indexSpeak + 1}</span>
                    </div>
                    <div class="content">
                        <div class="row">
                            <input name="id_speak[${indexSpeak}]" type="text" value="0" hidden>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control form-control-sm input-file-dummy"
                                                name="speak_name_en[${indexSpeak}]"
                                                placeholder="Nh???p v??o n???i dung ti???ng anh"
                                                aria-describedby="fileHelp">
                                            <label class="input-group-append mb-0">
                                                <span class="btn btn-sm btn-success input-file-btn">
                                                    <i class="fas fa-file-audio"></i>&nbsp;&nbsp;Ch???n file
                                                    <input type="file" hidden name="speak_file_en[${indexSpeak}]"
                                                        id="speak-file-en-${indexSpeak}" onchange="getFileName('speak-file-en-${indexSpeak}', 'speak-input-en-${indexSpeak}')">
                                                </span>
                                            </label>
                                        </div>
                                        <span style="font-size: 13px;" id="speak-input-en-${indexSpeak}"></span>
                                        <p class="row align-items-center ml-1 my-2 d-none">
                                            <audio controls>
                                                <source src=""
                                                    type="audio/mpeg">
                                                Tr??nh duy???t kh??ng h??? tr??? ph??t audio
                                            </audio>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger ml-2" onclick="removeFile('speak-file-en-${indexSpeak}', 'speak-input-en-${indexSpeak}')"><i class="fas fa-times"></i></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control form-control-sm input-file-dummy"
                                            name="speak_name_vi[${indexSpeak}]"
                                            placeholder="Nh???p v??o n???i dung ti???ng vi???t"
                                            aria-describedby="fileHelp">
                                        <label class="input-group-append mb-0">
                                            <span class="btn btn-sm btn-success input-file-btn">
                                                <i class="fas fa-file-audio"></i>&nbsp;&nbsp;Ch???n file
                                                <input type="file" hidden
                                                    name="speak_file_vi[${indexSpeak}]" id="speak-file-vi-${indexSpeak}"
                                                    onchange="getFileName('speak-file-vi-${indexSpeak}', 'speak-input-vi-${indexSpeak}')">
                                            </span>
                                        </label>
                                    </div>
                                    <span style="font-size: 13px;" id="speak-input-vi-${indexSpeak}"></span>
                                    <p class="row align-items-center ml-1 my-2 d-none">
                                        <audio controls>
                                            <source src=""
                                                type="audio/mpeg">
                                            Tr??nh duy???t kh??ng h??? tr??? ph??t audio
                                        </audio>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger ml-2" onclick="removeFile('speak-file-vi-${indexSpeak}', 'speak-input-vi-${indexSpeak}')"><i class="fas fa-times"></i></a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <a class="btn btn-sm btn-danger remove_speak"
                                        href="javascript:void(0)">
                                        <i class="fa fa-times"></i>&nbsp;&nbsp; Remove
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);

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
            let row = `
            <div class="row" id="itemDynamic" data-position="${indexWrite + 1}">
                <div class="number">
                    <span class="badge badge-info">${indexWrite + 1}</span>
                </div>
                <div class="content">
                    <div class="row">
                        <input name="id_write[${indexWrite}]" type="text" value="0" hidden>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text"
                                    class="form-control form-control-sm input-file-dummy"
                                    name="write_name_en[${indexWrite}]"
                                    placeholder="Nh???p v??o n???i dung ti???ng anh"
                                    aria-describedby="fileHelp">
                                <label class="input-group-append mb-0">
                                    <span class="btn btn-sm btn-success input-file-btn">
                                        <i class="fas fa-file-audio"></i>&nbsp;&nbsp;Ch???n file
                                        <input type="file" hidden name="write_file_en[${indexWrite}]"
                                            id="write-file-en-${indexWrite}" onchange="getFileName('write-file-en-${indexWrite}', 'write-input-en-${indexWrite}')">
                                    </span>
                                </label>
                            </div>
                            <span style="font-size: 13px;" id="write-input-en-${indexWrite}" ></span>
                            <p class="row align-items-center ml-1 my-2 d-none">
                                <audio controls>
                                    <source src=""
                                        type="audio/mpeg">
                                    Tr??nh duy???t kh??ng h??? tr??? ph??t audio
                                </audio>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger ml-2" onclick="removeFile('write-file-en-${indexWrite}', 'write-input-en-${indexWrite}')"><i class="fas fa-times"></i></a>
                            </p>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text"
                                    class="form-control form-control-sm input-file-dummy"
                                    name="write_name_vi[${indexWrite}]"
                                    placeholder="Nh???p v??o n???i dung ti???ng vi???t"
                                    aria-describedby="fileHelp">
                                <label class="input-group-append mb-0">
                                    <span class="btn btn-sm btn-success input-file-btn">
                                        <i class="fas fa-file-audio"></i>&nbsp;&nbsp;Ch???n file
                                        <input type="file" hidden
                                            name="write_file_vi[${indexWrite}]" id="write-file-vi-${indexWrite}"
                                            onchange="getFileName('write-file-vi-${indexWrite}', 'write-input-vi-${indexWrite}')">
                                    </span>
                                </label>
                            </div>
                            <span style="font-size: 13px;" id="write-input-vi-${indexWrite}"></span>
                            <p class="row align-items-center ml-1 my-2 d-none">
                                <audio controls>
                                    <source src=""
                                        type="audio/mpeg">
                                    Tr??nh duy???t kh??ng h??? tr??? ph??t audio
                                </audio>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger ml-2" onclick="removeFile('write-file-vi-${indexWrite}', 'write-input-vi-${indexWrite}')"><i class="fas fa-times"></i></a>
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <a class="btn btn-sm btn-danger remove_write"
                                    href="javascript:void(0)">
                                    <i class="fa fa-times"></i>&nbsp;&nbsp; Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
            $('.input_fields_write').append(row);

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
                                                                                   placeholder="Nh???p n???i dung c??u h???i">
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
                                                                                       placeholder="Nh???p c??u tr??? l???i">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="" class="col-sm-1"><span
                                                                                    class="badge badge-question">2</span></label>
                                                                            <div class="col-sm-11">
                                                                                <input type="text" class="form-control form-control-sm"
                                                                                       name="answer_2[${indexEx}]"
                                                                                       placeholder="Nh???p c??u tr??? l???i">
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
                                                                                       placeholder="Nh???p c??u tr??? l???i">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="" class="col-sm-1"><span
                                                                                    class="badge badge-question">4</span></label>
                                                                            <div class="col-sm-11">
                                                                                <input type="text" class="form-control form-control-sm"
                                                                                       name="answer_4[${indexEx}]"
                                                                                       placeholder="Nh???p c??u tr??? l???i">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-10">
                                                                        <div class="row">
                                                                            <span>Ch???n ????p ??n ????ng:&nbsp;&nbsp;&nbsp;</span>
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
                                                                            <label for="answer_description">Di???n gi???i ????p ??n</label>
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

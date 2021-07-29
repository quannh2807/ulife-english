{{--Laravel Mix - Include Bootstrap 4, jQuery, Admin LTE, see webpack.mix.js--}}
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/all.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('libs/html5lightbox/html5lightbox.js') }}"></script>

<script>
    $('select').select2();
    $('[data-toggle="tooltip"]').tooltip();

    function getYoutubeId(url) {
        let ytb_id = url.split("v=")[1];

        let positionMoreData = ytb_id.indexOf("&");
        if (positionMoreData !== -1) {
            return ytb_id = ytb_id.substring(0, positionMoreData);
        }
        return ytb_id;
    }

    function string_to_slug(str) {
        let title, slug

        //Đổi chữ hoa thành chữ thường
        slug = str.toLowerCase()

        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
        slug = slug.replace(/đ/gi, 'd')
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\|_/gi, '')
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-")
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-')
        slug = slug.replace(/\-\-\-\-/gi, '-')
        slug = slug.replace(/\-\-\-/gi, '-')
        slug = slug.replace(/\-\-/gi, '-')
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@'
        slug = slug.replace(/\@\-|\-\@|\@/gi, '')
        //In slug ra textbox có id “slug”
        return slug
    }


    if ($(".btn-remove").length > 0) {
        $('.btn-remove').click(function (e) {
            e.preventDefault();

            let id = $(this).attr('data-id');

            Swal.fire({
                title: 'Bạn chắc chắn chưa?',
                text: "Dữ liệu bị xoá sẽ không thể khôi phục được!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Huỷ',
                confirmButtonText: 'Đồng ý xoá!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    let url = $(this).attr('href');
                    $.ajax({
                        url: `${url}`,
                        type: 'GET',
                        success: function () {
                            Swal.fire(
                                'Xoá thành công!',
                                'Dữ liệu đã được xoá hoàn toàn.',
                                'success'
                            ).then(() => {
                                $(`#row-${id}`).fadeOut(500, function () {
                                    $(this).remove();
                                })
                            })
                        },
                        fail: function () {
                            Swal.fire(
                                'Có vấn đề xảy ra',
                                'Dữ liệu chưa được xoá',
                                'question'
                            )
                        }
                    });
                }
            })
        });
    }

    if ($(".btn-remove-level").length > 0) {
        $('.btn-remove-level').click(function (e) {
            e.preventDefault();

            let id = $(this).attr('data-id');

            Swal.fire({
                title: 'Bạn muốn xóa level này?',
                text: "Dữ liệu bị xoá sẽ không thể khôi phục được!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Đóng',
                confirmButtonText: 'Đồng ý xoá!',
                width: 350
            }).then(async (result) => {
                if (result.isConfirmed) {
                    let url = $(this).attr('href');
                    $.ajax({
                        url: `${url}`,
                        type: 'GET',
                        success: function () {
                            Swal.fire(
                                'Xoá thành công!',
                                'Dữ liệu đã được xoá hoàn toàn.',
                                'success'
                            ).then(() => {
                                $(`#row-${id}`).fadeOut(500, function () {
                                    $(this).remove();
                                })
                            })
                        },
                        fail: function () {
                            Swal.fire(
                                'Có vấn đề xảy ra',
                                'Dữ liệu chưa được xoá',
                                'question'
                            )
                        }
                    });
                }
            })
        });
    }

    if ($(".btn-remove-topics").length > 0) {
        $('.btn-remove-topics').click(function (e) {
            e.preventDefault();

            let id = $(this).attr('data-id');

            Swal.fire({
                title: 'Bạn muốn xóa Topics?',
                text: "Dữ liệu bị xoá sẽ không thể khôi phục được!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Đóng',
                confirmButtonText: 'Đồng ý xoá!',
                width: 350
            }).then(async (result) => {
                if (result.isConfirmed) {
                    let url = $(this).attr('href');
                    $.ajax({
                        url: `${url}`,
                        type: 'GET',
                        success: function () {
                            Swal.fire(
                                'Xoá thành công!',
                                'Dữ liệu đã được xoá hoàn toàn.',
                                'success'
                            ).then(() => {
                                $(`#row-${id}`).fadeOut(500, function () {
                                    $(this).remove();
                                })
                            })
                        },
                        fail: function () {
                            Swal.fire(
                                'Có vấn đề xảy ra',
                                'Dữ liệu chưa được xoá',
                                'question'
                            )
                        }
                    });
                }
            })
        });
    }

    if ($(".btn-remove-question").length > 0) {
        $('.btn-remove-question').click(function (e) {
            e.preventDefault();

            let id = $(this).attr('data-id');

            Swal.fire({
                title: 'Bạn muốn xóa câu hỏi?',
                text: "Dữ liệu bị xoá sẽ không thể khôi phục được!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Đóng',
                confirmButtonText: 'Đồng ý xoá!',
                width: 350
            }).then(async (result) => {
                if (result.isConfirmed) {
                    let url = $(this).attr('href');
                    $.ajax({
                        url: `${url}`,
                        type: 'GET',
                        success: function () {
                            Swal.fire(
                                'Xoá thành công!',
                                'Dữ liệu đã được xoá hoàn toàn.',
                                'success'
                            ).then(() => {
                                $(`#row-${id}`).fadeOut(500, function () {
                                    $(this).remove();
                                })
                            })
                        },
                        fail: function () {
                            Swal.fire(
                                'Có vấn đề xảy ra',
                                'Dữ liệu chưa được xoá',
                                'question'
                            )
                        }
                    });
                }
            })
        });
    }

    function changeAnswer_1() {
        let answerVal = $('#answer_1').val();
        $('#lbl_answer_1').empty();
        $('#lbl_answer_1').append('<span class="badge badge-question margin-circle">1</span> ' + answerVal);
    }

    function changeAnswer_2() {
        let answerVal = $('#answer_2').val();
        $('#lbl_answer_2').empty();
        $('#lbl_answer_2').append('<span class="badge badge-question margin-circle">2</span> ' + answerVal);
    }

    function changeAnswer_3() {
        let answerVal = $('#answer_3').val();
        $('#lbl_answer_3').empty();
        $('#lbl_answer_3').append('<span class="badge badge-question margin-circle">3</span> ' + answerVal);
    }

    function changeAnswer_4() {
        let answerVal = $('#answer_4').val();
        $('#lbl_answer_4').empty();
        $('#lbl_answer_4').append('<span class="badge badge-question margin-circle">4</span> ' + answerVal);
    }

    // Question - Pick Video
    if ($("#pick_video").length > 0) {
        $('#pick_video').on('click', function () {
            loadVideoList();
        });
    }

    // keyup search modal video
    $('#keyVideoSearch').keyup(function () {
        console.log('search: ' + $(this).val());
        let search = $(this).val();
        if (search !== '') {
            loadVideoList(search);
            console.log('loadVideoList search: ' + $(this).val());
        } else {
            loadVideoList();
            console.log('loadVideoList');
        }
    });

    function loadVideoList(keyName) {
        let videoId = $('#video_id').val();

        $.ajax({
            type: "GET",
            url: '{{ route('admin.question.getVideos') }}',
            data: {id: videoId, keyName: keyName},
            success: function (response) {
                $('.result-content').html(response);
                $('#videoListModal').modal('show');
            }
        });
    }

    $(document).on('click', '#videoList tr', function (event) {
        let mCheckbox = $("[type='checkbox']", this);
        let currentRow = $(this).closest("tr");
        let id = currentRow.find('#check_video').val();
        let thumb = currentRow.find('#imgThumb').attr('src');
        let title = currentRow.find('td#title').text();
        let ytbId = currentRow.find('#ytb_id').val();

        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }

        $('#videoListModal').modal('toggle');
        $("#keyNewsEvent").val('');

        $('#video_id').val(id);
        $('#yt_id').val(ytbId);
        $('#ytb_link').val(title);

        let playUrl = "https://www.youtube.com/watch?v=" + ytbId;
        document.getElementById('divVideo').innerHTML = '<a id="viewVideo" title="Play Video" class="video html5lightbox" href="' + playUrl + '" data-width="640" data-height="360" ><span class="icon fa fa-play">&nbsp;&nbsp;Xem Video</span></a>';
        if (ytbId === "" || ytbId === null) {
            $("#divVideo").hide(1000);
        } else {
            $("#divVideo").show("slow");
        }
        $(".html5lightbox").html5lightbox();
    });

    $("#question-check input:checkbox").on('click', function () {
        let $box = $(this);
        if ($box.is(":checked")) {
            let group = "input:checkbox[name='" + $box.attr("name") + "']";
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    });

    $('.question-detail-view').on('click', function () {
        let id = $(this).attr('data-id');
        showDetailQuestion(id)
    });

    function showDetailQuestion(id) {
        $.ajax({
            type: "GET",
            url: '{{ route('admin.question.detail') }}',
            data: {id: id},
            success: function (response) {
                $('.result-content').html(response);
                $('#questionDetailModal').modal('show');
            }
        });
    }

</script>

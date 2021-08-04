<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment-with-locales.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('plugins/html5lightbox/html5lightbox.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>

<script>
    $('select').select2();
    $('[data-toggle="tooltip"]').tooltip();
    if ($("#reservation").length > 0) {
        $('#reservation').daterangepicker();
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
                        error: function (xhr, status, error) {
                            Swal.fire(
                                'Có vấn đề xảy ra',
                                'Dữ liệu chưa được xoá',
                                'question'
                            )
                        },
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

    function encodeImageFileAsURL(element) {
        let file = element.files[0];
        if (file === undefined) {
            $('#preview-img').attr('src', "{{ asset('images/online_course.jpg') }}");
            return false;
        }
        let reader = new FileReader();
        reader.onloadend = function () {
            $('#preview-img').attr('src', reader.result)
        }
        reader.readAsDataURL(file);
    }

    $('#lesson-description').summernote({
        placeholder: 'Nhập mô tả bài học',
        height: 125,
    });
    //Date range as a button
    if ($("#daterange-btn").length > 0) {
        moment.locale('vi');
        $('#daterange-btn').daterangepicker(
            {
                locale: {
                    "format": "MM/DD/YYYY",
                    "separator": " - ",
                    "applyLabel": "Chọn",
                    "cancelLabel": "Hủy",
                    "fromLabel": "Từ",
                    "toLabel": "Đến",
                    "customRangeLabel": "Tùy chỉnh",
                },

                ranges: {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                    '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Clear': [,]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end, label) {
                if (label === 'Clear') {
                    setTimeout(() => {
                        this.setEndDate(this.endDate[
                            this.endDate.valueOf() - this.startDate.valueOf() > 1440 ? 'subtract' : 'add'
                            ](1, 'days'));
                        $('#valRangeDate').val('');
                        $('#txtDateRange').html('Từ ngày - Đến ngày');
                    })
                } else {
                    let strDate = start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY');
                    $('#valRangeDate').val(strDate);
                    $('#txtDateRange').html(strDate);
                }
            }
        );
    }

    $(window).on('beforeunload', function () {
        $('.input-file-dummy').val('');
    });

    function previewMultiple(event) {
        $('.input-file-dummy').val($('#thumb').val());
        $('#galleryPhotos').empty();
        let urls = URL.createObjectURL(event.target.files[0]);
        document.getElementById("galleryPhotos").innerHTML += '<div class="imagePhoto"><img src="' + urls + '"><a href="javascript:void(0)" class="removePhoto"><i class="fa fa-trash-alt"></i></a></div>';
        $(".removePhoto").click(function () {
            $(this).parent().fadeOut(300);
            $('.input-file-dummy').val('');
        });
    }

    $('.select-multiple').select2({
        placeholder: "Chọn video bài học",
    });

    /* input search clear */
    if ($("#searchInput").length > 0) {
        $("#searchInput").keyup(function () {
            $("#searchClear").toggle(Boolean($(this).val()));
        });
        $("#searchClear").toggle(Boolean($("#searchInput").val()));
        $("#searchClear").click(function () {
            $("#searchInput").val('').focus();
            $('form#frmSearch').submit();
            $(this).hide();
        });
    }
    /* end input search clear */

    /* toastr */
    @if(Session::has('success'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.success("{{ session('success') }}");
    @endif
        @if(Session::has('error'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.error("{{ session('error') }}");
    @endif
        @if(Session::has('info'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.info("{{ session('info') }}");
    @endif
        @if(Session::has('warning'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.warning("{{ session('warning') }}");
    @endif
    /* end toastr */

</script>

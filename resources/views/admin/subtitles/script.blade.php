<script>
    /* subtitles */
    function compareTwoTime(startTime, endTime) {
        return new Date(`1/1/1999 ${startTime}`) < new Date(`1/1/1999 ${endTime}`)
    }

    function convertTimeToSecond(time) {
        let arr = time.split(':')

        let seconds = (+arr[0]) * 60 * 60 + (+arr[1]) * 60 + (+arr[2]);
        return seconds;
    }

    function convertSecondToTime(seconds) {
        /*let time = new Date(seconds * 1000).toISOString().substr(11, 8)
        return time;*/

        /* srtTimestamp */
        let $milliseconds = seconds * 1000;
        $seconds = Math.floor($milliseconds / 1000);
        $minutes = Math.floor($seconds / 60);
        $hours = Math.floor($minutes / 60);
        $milliseconds = $milliseconds % 1000;
        $seconds = $seconds % 60;
        $minutes = $minutes % 60;
        return ($hours < 10 ? '0' : '') + $hours + ':'
            + ($minutes < 10 ? '0' : '') + $minutes + ':'
            + ($seconds < 10 ? '0' : '') + $seconds + ','
            + ($milliseconds < 100 ? '0' : '') + ($milliseconds < 10 ? '0' : '') + $milliseconds;
    }

    function refreshSub() {
        $.ajax({
            method: 'GET',
            url: "{{ route('admin.subtitle.refresh', ['video_id' => $video->id]) }}",
            success: function (res) {
                let subtitles = res.subtitles;
                let tbody = '';

                subtitles.map((item, index) => {
                    tbody += `
                        <tr style="cursor: pointer" id="row-${item.id}" data-id="${item.id}">
                            <td><input type="checkbox" class="sub-checked" data-id="${item.id}"></td>
                            <td key-data="index">${++index}</td>
                            <td>${convertSecondToTime(item.time_start)}</td>
                            <td>${convertSecondToTime(item.time_end)}</td>
                            <td>${item.vi ? item.vi : '<span class="d-inline-block px-1 m-1 bg-danger rounded" style="font-size: 13px">Chưa có phụ đề</span>'}</td>
                            <td>${item.en ? item.en : '<span class="d-inline-block px-1 m-1 bg-danger rounded" style="font-size: 13px">Chưa có phụ đề</span>'}</td>
                            <td class="text-center">
                                <button
                                    data-id="${item.id}"
                                    class="btn btn-sm btn-warning select-sub">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <a
                                    href="{{ url('admin/subtitle/remove') }}/${item.id}"
                                    data-id="${item.id}"
                                    class="btn btn-sm btn-danger btn-remove">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    `;
                });
                $('tbody#list-subtitles').html(tbody);
            },
            error: function (res) {
                console.log(res.responseText)
            }
        });
    }

    // Validate form
    $('#add-sub').validate({
        errorPlacement: function (error, e) {
            e.parents('.form-group').append(error);
        },
        rules: {
            start_time: {
                required: true,
                maxlength: 12,
                pattern: '^([0-9]?[0-9]|2[0-3]):([0-9]?[0-9]|2[0-3]):([0-9]?[0-9]|2[0-3]),([0-9]?[0-9]?[0-9]|3[0-4])$',
            },
            end_time: {
                required: true,
                maxlength: 12,
                pattern: '^([0-9]?[0-9]|2[0-3]):([0-9]?[0-9]|2[0-3]):([0-9]?[0-9]|2[0-3]),([0-9]?[0-9]?[0-9]|3[0-4])$',
                greaterStart: "#start-time",
            },
            vi: {
                required: true,
            },
            en: {
                required: true,
            },
        },
        messages: {
            start_time: {
                required: 'Thời gian bắt đầu không được bỏ trống',
                maxlength: 'Chưa đúng định dạng',
                pattern: 'Lưu ý: định dạng thời gian là 00:00:00,000'
            },
            end_time: {
                required: 'Thời gian kết thúc không được bỏ trống',
                maxlength: 'Chưa đúng định dạng',
                pattern: 'Lưu ý: định dạng thời gian là 00:00:00,000'
            },
            vi: {
                required: 'Phụ đề tiếng việt không được bỏ trống'
            },
            en: {
                required: 'Phụ đề tiếng anh không được bỏ trống'
            },
        }
    });
    jQuery.validator.addMethod("greaterStart", function (value, element) {
        let dateFrom = $("#start-time").val();
        let dateTo = $('#end-time').val();
        return dateTo > dateFrom;
    }, 'Thời gian kết thúc phải lớn hơn thời gian bắt đầu.');

    // scroll to form
    $('#create-sub').click(function () {
        document.querySelector('input#start-time').scrollIntoView({block: 'start', behavior: 'smooth'});
    });
    // create sub
    $('button#btn-create').click(function (e) {
        e.preventDefault();
        let startTime = $('input#start-time').val();
        let endTime = $('input#end-time').val();
        let vi = $('input#vi').val();
        let en = $('input#en').val();

        let valid = $('#add-sub').valid();
        let compare = compareTwoTime(startTime, endTime);

        /*if (!compare) {
            if ($('input#start-time').siblings('span.error').length <= 0) {
                $('input#start-time').parent('.form-group').append('<span class="error">Thời gian bắt đầu không được lớn hơn thời gian kết thúc</span>')
                return;
            }
        } else {
            $('input#start-time').parent('.form-group').children('.error').remove();
        }*/

        if (!valid) return;

        let data = {
            video_id: "{{ $video->id }}",
            time_start: startTime,
            time_end: endTime,
            vi: vi,
            en: en,
        }

        $.ajax({
            url: "{{ route('admin.subtitle.store') }}",
            method: "POST",
            dataType: "json",
            data: data,
            success: async function (data) {
                await Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Thành công',
                    showConfirmButton: false,
                    timer: 1000
                })

                if ($('#have-sub').length > 0) {
                    $('#have-sub').addClass('d-none')
                }
                $('#add-sub')[0].reset();

                // await refreshSub();
                location.reload();
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra',
                    text: 'Something went wrong!',
                })
            }
        })
    });
    // edit sub
    $('.select-sub').click(function () {
        document.querySelector('input#start-time').scrollIntoView({block: 'start', behavior: 'smooth'});
        let sub_id = $(this).attr('data-id');

        $.ajax({
            url: `show/${sub_id}`,
            method: "GET",
            success: function ({selectedSub}) {
                $('input#sub_id').val(sub_id);
                $('input#start-time').val(convertSecondToTime(selectedSub.time_start));
                $('input#end-time').val(convertSecondToTime(selectedSub.time_end));
                $('input#vi').val(selectedSub.vi);
                $('input#en').val(selectedSub.en);
                $('input#ko').val(selectedSub.ko);
                $('#btn-create').html('<i class="fas fa-save"></i>&nbsp;&nbsp;Lưu lại');
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra',
                    text: 'Something went wrong!',
                })
            }
        })
    })

    // import subtitles
    $('#form-upload').validate({
        errorPlacement: function (error, e) {
            e.parents('.form-group').append(error);
        },
        rules: {
            'file_upload': {
                required: true,
            },
            'lang': {
                required: true
            }
        },
        messages: {
            'file_upload': {
                required: 'Không được bỏ trống',
            },
            'lang': {
                required: 'Không được bỏ trống'
            }
        }
    });
    $('.btn-upload').click(function () {
        $('#upload_sub').modal('toggle');

        $('.btn-preview').click(function (e) {
            e.preventDefault();
            let valid = $('#form-upload').valid();
            if (!valid) return;

            let file_sub = $('#upload-file')[0].files;

            if (file_sub.length > 0) {
                let form = new FormData();
                form.append('file_sub', file_sub[0]);

                $.ajax({
                    url: "{{ route('admin.subtitle.previewSub') }}",
                    method: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: form,
                    success: function (res) {
                        $('#preview').removeClass('d-none')

                        let tbody = '';
                        res.subtitles.map((element, index) => {
                            tbody += `
                                     <tr style="cursor: pointer">
                                        <th>${++index}</th>
                                        <td>${convertSecondToTime(element.startTime)}</td>
                                        <td>${convertSecondToTime(element.endTime)}</td>
                                        <td>${element.text}</td>
                                    </tr>
                                `;
                        })

                        $('#preview tbody').append(tbody);
                    },
                    error: function () {
                        console.log('error')
                    }
                })
            }
        })
    });
    $('button.close-modal').on('click', function (e) {
        // do something...
        $('#form-upload').trigger("reset");
        $('#upload_sub').modal('hide');
        $('#preview tbody').empty();
        $('#preview').addClass('d-none');
    })
    // remove sub selected
    $('.main-checked').click(function (e) {
        if ($(this).is(':checked', true)) {
            $(".sub-checked").prop('checked', true);
        } else {
            $(".sub-checked").prop('checked', false);
        }
    });
    $('.btn-remove-all').click(function () {
        let ids = [];

        $(".sub-checked:checked").each(function () {
            ids.push($(this).attr('data-id'));
        })

        if (ids.length <= 0) {
            Swal.fire('Bạn phải chọn phụ đề trước');
            return;
        } else {
            Swal.fire({
                title: 'Bạn chắc chắn chưa?',
                text: "Dữ liệu bị xoá sẽ không thể khôi phục được!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Huỷ',
                confirmButtonText: 'Đồng ý xoá!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // call ajax
                    let selectedSub = ids.join(',');

                    $.ajax({
                        method: 'POST',
                        url: "{{ route('admin.subtitle.destroyAll') }}",
                        data: {ids: selectedSub},
                        success: async function (data) {
                            Swal.fire({
                                title: 'Xóa thành công',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000,
                            })

                            location.reload()
                            // await refreshSub();
                        },
                        error: function (data) {
                            alert(data.responseText)
                        }
                    });
                }
            });
        }
    });
    /* end subtitles */
</script>

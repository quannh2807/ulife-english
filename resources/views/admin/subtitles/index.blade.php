@extends('admin.layouts.master')

@section('page-title', 'Phụ đề')
@section('breadcrumb', 'Phụ đề')

@section('main')
    <div class="card">
        <div class="card-header">
            <h5>Video: {{ $video->title }}</h5>
            <div>
                <img src="{{ $video->ytb_thumbnails->url }}" alt="" width="{{ $video->ytb_thumbnails->width }}"
                     height="{{ $video->ytb_thumbnails->height }}"/>
            </div>
        </div>

        <div class="card-body">
            <button class="btn btn-sm btn-outline-danger btn-remove-all mr-2">
                <i class="fas fa-eraser"></i>
                &nbsp;Xóa phụ đề đã chọn
            </button>

            <button class="btn btn-sm btn-outline-primary btn-upload mr-2">
                <i class="fas fa-upload"></i>
                &nbsp;Import phụ đề
            </button>

            <button class="btn btn-sm btn-outline-primary" id="create-sub">
                <i class="fas fa-plus"></i>
                &nbsp;Tạo phụ đề mới
            </button>
            @if($video->id >0 && count($subtitles) > 0)
                @if(videoHasQuestionSub($video->id))
                    <a href="{{ route('admin.question.editQuestionList',['id' => $video->id]) }}"
                       class="d-inline-block btn btn-sm btn-primary"><i
                            class="fa fa-list"></i>&nbsp;&nbsp;Danh sách câu hỏi</a>
                @else
                    <a href="{{ route('admin.question.createQuestionList',['id' => $video->id]) }}"
                       class="d-inline-block btn btn-sm btn-primary"><i
                            class="fa fa-copy"></i>&nbsp;&nbsp;Tạo danh sách câu hỏi</a>
                @endif
            @endif
        </div>

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 400px;">
            <table class="table table-head-fixed table-hover text-nowrap">
                <thead>
                <tr>
                    <th><input type="checkbox" class="main-checked"></th>
                    <th>#</th>
                    <th>Start-time</th>
                    <th>End-time</th>
                    <th>Tiếng việt</th>
                    <th>Tiếng anh</th>
                    <th>Thao tác</th>
                </tr>
                </thead>

                <tbody>
                @if(count($subtitles) <= 0)
                    <tr id="have-sub">
                        <td colspan="100%" align="center">Video này chưa có phụ đề</td>
                    </tr>
                @endif

                @php
                    $i = 1
                @endphp

                @foreach($subtitles as $subtitle)
                    <tr style="cursor: pointer" id="row-{{ $subtitle->id }}" data-id="{{ $subtitle->id }}">
                        <td><input type="checkbox" class="sub-checked" data-id="{{ $subtitle->id }}"></td>
                        <td key-data="index">{{ $i++ }}</td>
                        <td>{{ \Carbon\Carbon::parse((int)$subtitle->time_start)->format('H:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse((int)$subtitle->time_end)->format('H:i:s') }}</td>
                        <td>{!! $subtitle->vi ?  $subtitle->vi : '<span class="d-inline-block px-1 m-1 bg-danger rounded" style="font-size: 13px">Chưa có phụ đề</span>' !!}</td>
                        <td>{!! $subtitle->en ? $subtitle->en : '<span class="d-inline-block px-1 m-1 bg-danger rounded" style="font-size: 13px">Chưa có phụ đề</span>' !!}</td>
                        <td>
                            <button
                                data-id="{{ $subtitle->id }}"
                                class="btn btn-sm btn-warning select-sub"
                            >
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <a
                                href="{{route('admin.subtitle.destroy', [ 'id' => $subtitle->id ])}}"
                                data-id="{{ $subtitle->id }}"
                                class="btn btn-sm btn-danger btn-remove"
                            >
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card">
        <div class="card-body ">
            <form id="add-sub">
                <div class="row">
                    <div class="col form-group">
                        <label for="start-time">Start time</label>
                        <input type="text" name="start_time" id="start-time" class="form-control"
                               placeholder="00:00:00"/>
                    </div>
                    <div class="col form-group">
                        <label for="end-time">End time</label>
                        <input type="text" name="end_time" id="end-time" class="form-control" placeholder="00:00:00"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="vi" class="pr-2">Tiếng việt</label>
                    <input type="text" name="vi" id="vi" class="flex-grow-1 form-control"
                           placeholder="Phụ đề tiếng Việt"/>
                </div>
                <div class="form-group">
                    <label for="en" class="pr-2">Tiếng anh</label>
                    <input type="text" name="en" id="en" class="flex-grow-1 form-control"
                           placeholder="Phụ đề tiếng Anh">
                </div>

                <button type="submit" class="btn btn-primary" id="btn-create">Tạo mới</button>
            </form>
        </div>
    </div>
    <!-- /.card -->

    <div class="modal fade" id="upload_sub" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form-upload" action="{{ route('admin.video.uploadSub') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="video_id" value="{{ $video->id }}">
                    <div class="modal-header">
                        <h4 class="modal-title">Import phụ đề</h4>
                        <button type="button" class="close close-modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-result">

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="upload-file">Upload phụ đề<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="file" name="file_upload" id="upload-file" class="form-control"
                                               style="border: none"
                                               value="{{ old('file_upload') }}">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="sub-lang">Chọn ngôn ngữ<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <select name="lang" id="lang">
                                            <option value="">-- Chọn ngôn ngữ --</option>
                                            @foreach(config('common.languages') as $key => $lang)
                                                <option
                                                    value="{{ $key }}" {{ old('lang') === $key ? 'selected' : ''}}>{{ $lang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body d-none" id="preview">
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Start-time</th>
                                    <th>End-time</th>
                                    <th>Phụ đề</th>
                                </tr>
                                </thead>

                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default close-modal"><i class="fa fa-times"></i>&nbsp;Đóng
                        </button>

                        <div class="btn-group-sm">
                            <button class="btn btn-sm btn-info btn-preview">
                                Xem trước
                            </button>

                            <button class="btn btn-sm btn-primary" type="submit">
                                Upload phụ đề
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('custom-script')
    <script>
        /* subtitles */
        function compareTwoTime(startTime, endTime) {
            let result = new Date(`1/1/1999 ${startTime}`) < new Date(`1/1/1999 ${endTime}`)
            return result;
        }

        function convertTimeToSecond(time) {
            let arr = time.split(':')

            let seconds = (+arr[0]) * 60 * 60 + (+arr[1]) * 60 + (+arr[2]);
            return seconds;
        }

        function convertSecondToTime(second) {
            let time = new Date(second * 1000).toISOString().substr(11, 8)
            return time;
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
                             <tr data-id="${item.id}" style="cursor: pointer">
                                <td><input type="checkbox" class="sub-checked" data-id="${item.id}"></td>
                                <td key-data="index">${++index}</td>
                                <td>${convertSecondToTime(item.time_start)}</td>
                                <td>${convertSecondToTime(item.time_end)}</td>
                                <td>${item.vi ? item.vi : '<span class="d-inline-block px-1 m-1 bg-danger rounded" style="font-size: 13px">Chưa có phụ đề</span>'}</td>
                                <td>${item.en ? item.en : '<span class="d-inline-block px-1 m-1 bg-danger rounded" style="font-size: 13px">Chưa có phụ đề</span>'}</td>
                                <td>
                                    <button
                                        data-id="${item.id}"
                                        class="btn btn-sm btn-warning select-sub"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <a
                                        href="{{ url('admin/subtitle/remove') }}/${item.id}"
                                        data-id="${item.id}"
                                        class="btn btn-sm btn-danger btn-remove"
                                    >
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                    $('tbody').html(tbody);
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
                    maxlength: 8,
                    pattern: '^([0-9]?[0-9]|2[0-3]):([0-9]?[0-9]|2[0-3]):([0-9]?[0-9]|2[0-3])$',
                },
                end_time: {
                    required: true,
                    maxlength: 8,
                    pattern: '^([0-9]?[0-9]|2[0-3]):([0-9]?[0-9]|2[0-3]):([0-9]?[0-9]|2[0-3])$',
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
                    pattern: 'Lưu ý: định dạng thời gian là 00:00:00'
                },
                end_time: {
                    required: 'Thời gian kết thúc không được bỏ trống',
                    maxlength: 'Chưa đúng định dạng',
                    pattern: 'Lưu ý: định dạng thời gian là 00:00:00'
                },
                vi: {
                    required: 'Phụ đề tiếng việt không được bỏ trống'
                },
                en: {
                    required: 'Phụ đề tiếng anh không được bỏ trống'
                },
            }
        });
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

            if (!compare) {
                if ($('input#start-time').siblings('span.error').length <= 0) {
                    $('input#start-time').parent('.form-group').append('<span class="error">Thời gian bắt đầu không được lớn hơn thời gian kết thúc</span>')
                    return;
                }
            } else {
                $('input#start-time').parent('.form-group').children('.error').remove();
            }

            if (!valid) return;

            let data = {
                video_id: "{{ $video->id }}",
                time_start: convertTimeToSecond(startTime),
                time_end: convertTimeToSecond(endTime),
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

                    await refreshSub();
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
                    $('input#start-time').val(convertSecondToTime(selectedSub.time_start));
                    $('input#end-time').val(convertSecondToTime(selectedSub.time_end));
                    $('input#vi').val(selectedSub.vi);
                    $('input#en').val(selectedSub.en);
                    $('input#ko').val(selectedSub.ko);
                },
                fail: function () {
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

                                await refreshSub();
                                // remove element
                                // $.each(ids, function (index, value) {
                                //     $('table tr').filter(`#row-${value}`).fadeOut('300', function () {
                                //         $(this).remove();
                                //     })
                                // });
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
@endsection

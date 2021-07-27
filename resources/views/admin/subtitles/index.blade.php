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

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 300px;">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Start-time</th>
                    <th>End-time</th>
                    <th>Tiếng việt</th>
                    <th>Tiếng anh</th>
                    <th>Tiếng hàn</th>
                    <th>
                        <button class="btn btn-info btn-sm" id="create-sub">
                            <i class="fas fa-plus"></i>
                        </button>
                    </th>
                </tr>
                </thead>

                <tbody>
                @if(count($subtitles) <= 0)
                    <tr>
                        <td colspan="100%">Video này chưa có subtitles</td>
                    </tr>
                @endif

                @php
                    $i = 1
                @endphp

                @foreach($subtitles as $subtitle)
                    <tr>
                        <th key-data="index">{{ $i++ }}</th>
                        <td>{{ $subtitle->time_start }}</td>
                        <td>{{ $subtitle->time_end }}</td>
                        <td>{{ $subtitle->vi }}</td>
                        <td>{{ $subtitle->en }}</td>
                        <td>{{ $subtitle->ko }}</td>
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
                <div class="d-flex">
                    <div class="form-inline form-group pr-2">
                        <label for="start-time">Start time</label>
                        <input type="text" name="start_time" id="start-time" class="ml-2 form-control"/>
                    </div>
                    <div class="form-inline form-group">
                        <label for="end-time">End time</label>
                        <input type="text" name="end_time" id="end-time" class="ml-2 form-control"/>
                    </div>
                </div>

                <div class="form-inline form-group">
                    <label for="vi" class="pr-2">Tiếng việt</label>
                    <input type="text" name="vi" id="vi" class="flex-grow-1 form-control">
                </div>
                <div class="form-inline form-group">
                    <label for="en" class="pr-2">Tiếng anh</label>
                    <input type="text" name="en" id="en" class="flex-grow-1 form-control">
                </div>
                <div class="form-inline form-group">
                    <label for="ko" class="pr-2">Tiếng Hàn</label>
                    <input type="text" name="ko" id="ko" class="flex-grow-1 form-control">
                </div>

                <button type="submit" class="btn btn-primary" id="btn-create">Tạo mới</button>
            </form>
        </div>
    </div>
    <!-- /.card -->
@endsection

@section('custom-script')
    <script>
        $(document).ready(function () {
            $('#add-sub').validate({
                errorPlacement: function (error, e) {
                    e.parents('.form-group').append(error);
                },
                rules: {
                    start_time: {
                        required: true,
                    },
                    end_time: {
                        required: true,
                    },
                    vi: {
                        required: true,
                    },
                    en: {
                        required: true,
                    },
                    ko: {
                        required: true,
                    },

                },
            });

            $('#create-sub').click(function () {
                document.querySelector('input#start-time').scrollIntoView({block: 'start', behavior: 'smooth'});
            });

            $('button#btn-create').click(function (e) {
                e.preventDefault();
                let valid = $('#add-sub').valid();
                if (!valid) return

                let startTime = $('input#start-time').val();
                let endTime = $('input#end-time').val();
                let vi = $('input#vi').val();
                let en = $('input#en').val();
                let ko = $('input#ko').val();

                let data = {
                    video_id: "{{ $video->id }}",
                    time_start: startTime,
                    time_end: endTime,
                    vi: vi,
                    en: en,
                    ko: ko,
                }

                $.ajax({
                    url: "{{ route('admin.subtitle.store') }}",
                    method: "POST",
                    dataType: "json",
                    data: data,
                    success: async function (data) {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: data.msg,
                        });

                        let newItem = await data.newItem;
                        let row = `
                             <tr>
                                <th>${$('th[key-data=index]').length + 1}</th>
                                <td>${newItem.time_start}</td>
                                <td>${newItem.time_end}</td>
                                <td>${newItem.vi}</td>
                                <td>${newItem.en}</td>
                                <td>${newItem.ko}</td>
                                <td></td>
                            </tr>
                        `;

                        $('tbody').append(row);
                    },
                    fail: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Có lỗi xảy ra',
                            text: 'Something went wrong!',
                        })
                    }
                })
            });
        });
    </script>
@endsection

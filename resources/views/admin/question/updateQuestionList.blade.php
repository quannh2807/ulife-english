@extends('admin.layouts.master')
@section('page-title', 'Cập nhât câu hỏi')
@section('breadcrumb', 'Cập nhât câu hỏi')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách câu hỏi (Tổng: {{count($subtitles)}} - Sub)</h3>
                    <div class="card-tools">
                        @if(count($subtitles) > 0)
                            <a class="d-inline-block btn btn-sm btn-danger mb-1 btn-remove-question-list"
                               data-id="{{$videoId}}"
                               href="{{ route('admin.question.removeQuestionList', ['id' => $videoId]) }}">
                                <i class="far fa-trash-alt"></i>&nbsp;&nbsp;Xóa danh sách câu hỏi
                            </a>
                        @endif
                    </div>
                </div>
                <form action="{{ route('admin.question.updateQuestionList', $videoId)}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 30px;">STT</th>
                                <th style="width: 30px;" class="text-center">#</th>
                                <th style="width: 100px;">Start Time</th>
                                <th style="width: 100px;">End Time</th>
                                <th>Câu hỏi (EN)</th>
                                <th>Câu trả lời</th>
                                {{--<th>Thao tác</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($subtitles) <= 0)
                                <tr id="have-sub">
                                    <td colspan="100%" align="center">Không có dữ liệu</td>
                                </tr>
                            @endif
                            @php
                                $i = 1;
                                $index = 0;
                            @endphp
                            @foreach($subtitles as $item)
                                <tr>
                                    <th key-data="index">{{ $i++ }}</th>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ formatTimeSub($item->time_start, FM_TIME_SUB_VIDEO) }}</td>
                                    <td>{{ formatTimeSub($item->time_end, FM_TIME_SUB_VIDEO) }}</td>
                                    <td>
                                        <label id="status" class="bg-info">{{ $item->name_origin}}</label>
                                        <input class="form-control form-control-sm"
                                               type="text" name="name[]"
                                               placeholder="Nhập nội dung câu hỏi"
                                               value="{{ $item->name ? $item->name : old('name') }}"/>
                                        <div style="display: none">
                                            <input class="form-control form-control-sm"
                                                   style="background: none; border: 0px"
                                                   type="text" name="name_origin[]"
                                                   value="{{ $item->name_origin}}"/>
                                            <input name="id[{{$index}}]" value="{{ $item->id }}"
                                                   class="form-control form-control-sm">
                                            <input name="time_start[]" value="{{$item->time_start}}"
                                                   class="form-control form-control-sm"/>
                                            <input name="time_end[]" value="{{$item->time_end}}"
                                                   class="form-control form-control-sm"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row questionItem">
                                            <span class="badge badge-question">1</span>
                                            <input type="text" class="form-control form-control-sm"
                                                   placeholder="Nhập câu trả lời 1" name="answer_1[]"
                                                   value="{{ $item->answer_1 ? $item->answer_1 : old('answer_1') }}"/>
                                        </div>
                                        <div class="row questionItem">
                                            <span class="badge badge-question">2</span>
                                            <input type="text" class="form-control form-control-sm"
                                                   placeholder="Nhập câu trả lời 2" name="answer_2[]"
                                                   value="{{ $item->answer_2 ? $item->answer_2 : old('answer_2') }}"/>
                                        </div>
                                        <div class="row questionItem" style="margin-bottom: 10px;">
                                            <span class="badge badge-question">3</span>
                                            <input type="text" class="form-control form-control-sm"
                                                   placeholder="Nhập câu trả lời 3" name="answer_3[]"
                                                   value="{{ $item->answer_3 ? $item->answer_3 : old('answer_3') }}"/>
                                        </div>
                                        <div class="row questionItem" style="margin-bottom: 10px;">
                                            <span class="badge badge-question">4</span>
                                            <input type="text" class="form-control form-control-sm"
                                                   placeholder="Nhập câu trả lời 4" name="answer_4[]"
                                                   value="{{ $item->answer_4 ? $item->answer_4 : old('answer_4') }}"/>
                                        </div>
                                        <div class="form-group">
                                            <label style="width: 100%;">Chọn đáp án đúng</label>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" id="answer_correct_1_{{$index}}"
                                                               name="answer_correct[{{$index}}]" value="1"
                                                            {{ $item->answer_correct === '1' ? 'checked' : '' }}>
                                                        <label for="answer_correct_1_{{$index}}"><span
                                                                class="badge badge-question margin-circle">1</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" id="answer_correct_2_{{$index}}"
                                                               name="answer_correct[{{$index}}]" value="2"
                                                            {{ $item->answer_correct === '2' ? 'checked' : '' }}>
                                                        <label for="answer_correct_2_{{$index}}"><span
                                                                class="badge badge-question margin-circle">2</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" id="answer_correct_3_{{$index}}"
                                                               name="answer_correct[{{$index}}]" value="3"
                                                            {{ $item->answer_correct === '3' ? 'checked' : '' }}>
                                                        <label for="answer_correct_3_{{$index}}"><span
                                                                class="badge badge-question margin-circle">3</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                               type="radio" id="answer_correct_4_{{$index}}"
                                                               name="answer_correct[{{$index}}]" value="4"
                                                            {{ $item->answer_correct === '4' ? 'checked' : '' }}>
                                                        <label for="answer_correct_4_{{$index}}"><span
                                                                class="badge badge-question margin-circle">4</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    {{--<td>
                                        <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-edit"> Lưu</i></a>
                                    </td>--}}
                                </tr>
                                <div style="display: none">{{ $index++ }}</div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        @if(count($subtitles) > 0)
                            <div class="d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-info"><i
                                        class="fa fa-edit"></i>&nbsp;&nbsp;Cập nhật
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.modal.video_list')
@endsection
@section('custom-script')
    <script>
        if ($(".btn-remove-question-list").length > 0) {
            $('.btn-remove-question-list').click(function (e) {
                e.preventDefault();
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Bạn muốn xóa danh sách câu hỏi?',
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
                                    window.location.href = "{{ route('admin.video.index')}}";
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
    </script>
@endsection


@extends('admin.layouts.master')

@section('page-title', 'Cập nhật bài học')
@section('breadcrumb', 'Lesson')

@section('main')
    <section class="content">
        <form method="POST" action="{{ route('admin.lesson.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Lesson</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="lesson-name">Tên bài học <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="lesson-name" class="form-control"
                                                   value="{{ old('name') }}" placeholder="Nhập tên bài học">

                                            @error('name')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="lesson-course">Khóa học <span
                                                    class="text-danger">*</span></label>
                                            <select name="course_id" id="lesson-course" class="form-control">
                                                <option value=""></option>
                                            </select>

                                            @error('course_id')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="lesson-description">Mô tả</label>
                                            <textarea name="description" id="lesson-description" class="form-control"
                                                      rows="10">{{ old('description') }}</textarea>

                                            @error('description')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="lesson-level">Trình độ <span
                                                        class="text-danger">*</span></label>
                                                <select name="level_id" id="lesson-level" class="form-control">
                                                    <option selected>-- Chọn trình độ --</option>
                                                    @foreach($levels as $key => $level)
                                                        <option
                                                            value="{{ $level->id }}" {{ old('level_id') ===  $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('level_id')
                                                <p style="color: red;">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="lesson-status">Trạng thái <span
                                                        class="text-danger">*</span></label>
                                                <select name="status" id="lesson-status" class="form-control">
                                                    @foreach(config('common.status') as $key => $value)
                                                        <option
                                                            value="{{ $value }}" {{ old('status') ===  $value ? 'selected' : '' }}>{{ $key }}</option>
                                                    @endforeach
                                                </select>

                                                @error('status')
                                                <p style="color: red;">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="grammar-videos">Video Grammar <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex border rounded">
                                                <select name="grammar_video[]"
                                                        class="rounded-0 form-control col-9 border-0"
                                                        id="grammar-videos" multiple disabled>
                                                </select>
                                                <button class="col-3 btn btn-info rounded-0 select-video"
                                                        data-type="{{ config('common.video_types.Grammar') }}">Chọn
                                                    video
                                                </button>
                                            </div>

                                            @error('grammar_video')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="lesson-videos">Video Bài học <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex border rounded">
                                                <select name="lesson_video[]"
                                                        class="rounded-0 form-control col-9 border-0"
                                                        id="lesson-videos" multiple disabled>
                                                </select>
                                                <button class="col-3 btn btn-info rounded-0 select-video"
                                                        data-type="{{ config('common.video_types.Lesson') }}">Chọn video
                                                </button>
                                            </div>

                                            @error('lesson_video')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>

                                        {{--<div class="form-group">
                                            <label for="">Speaking<span class="text-danger">&nbsp;*</span></label>
                                            <div class="input-group input-group">
                                                <input type="text" class="form-control" disabled
                                                       value="Có 3 câu speaking">
                                                <span class="input-group-append">
                                                <button class="btn btn-info btn-flat"
                                                        id="btn-speaking">Danh sách</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Writting<span class="text-danger">&nbsp;*</span></label>
                                            <div class="input-group input-group">
                                                <input type="text" class="form-control" disabled
                                                       value="Có 3 câu writting">
                                                <span class="input-group-append">
                                                <button class="btn btn-info btn-flat"
                                                        id="btn-writting">Danh sách</button>
                                            </span>
                                            </div>
                                        </div>--}}

                                        <div class="form-group">
                                            <label for="lesson-thumb">Ảnh bài học</label>

                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile"
                                                       name="thumb_img"
                                                       value="{{ old('thumb_img') }}"
                                                       onchange="encodeImageFileAsURL(this)">
                                                <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                                            </div>

                                            @error('thumb_img')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col form-group">
                                            <label for="" class="d-block">Xem trước</label>
                                            <img src="" alt="" class="d-inline-block img-thumbnail" id="preview-img"
                                                 style="max-height: 200px;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Speaking</h3>
                                <div class="card-tools">
                                    {{--<span title="" class="badge bg-primary">3</span>--}}
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-x: scroll">
                                <div class="input_fields_speak">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="speak_name_en[]"
                                                       placeholder="Nhập vào nội dung tiếng anh">
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="speak_name_vn[]"
                                                       placeholder="Nhập vào nội dung tiếng việt">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <a class="btn btn-sm btn-success add_more_speak"
                                                   href="javascript:void(0)">
                                                    <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Speak
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Writing</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-x: scroll">
                                <div class="input_fields_write">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="speak_write_en[]"
                                                       placeholder="Nhập vào nội dung tiếng anh">
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       name="speak_write_vn[]"
                                                       placeholder="Nhập vào nội dung tiếng việt">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <a class="btn btn-sm btn-success add_more_write"
                                                   href="javascript:void(0)">
                                                    <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Write
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Do Exercises</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input_fields_exercises">
                                    <div class="item_exercises">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-sm"
                                                           name="exercises_name[]"
                                                           placeholder="Nhập nội dung câu hỏi">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <a class="btn btn-sm btn-success add_more_exercises"
                                                       href="javascript:void(0)">
                                                        <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Exercises
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
                                                               name="answer_1[0]"
                                                               placeholder="Nhập câu trả lời">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-1"><span
                                                            class="badge badge-question">2</span></label>
                                                    <div class="col-sm-11">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="answer_2[0]"
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
                                                               name="answer_3[0]"
                                                               placeholder="Nhập câu trả lời">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-1"><span
                                                            class="badge badge-question">4</span></label>
                                                    <div class="col-sm-11">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="answer_4[0]"
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
                                                                   type="radio" id="answer_correct_1_0"
                                                                   name="answer_correct[0]" value="1" checked>
                                                            <label for="answer_correct_1_0"><span
                                                                    class="badge badge-question margin-circle">1</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                   type="radio" id="answer_correct_2_0"
                                                                   name="answer_correct[0]" value="2">
                                                            <label for="answer_correct_2_0"><span
                                                                    class="badge badge-question margin-circle">2</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                   type="radio" id="answer_correct_3_0"
                                                                   name="answer_correct[0]" value="3">
                                                            <label for="answer_correct_3_0"><span
                                                                    class="badge badge-question margin-circle">3</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                   type="radio" id="answer_correct_4_0"
                                                                   name="answer_correct[0]" value="4">
                                                            <label for="answer_correct_4_0"><span
                                                                    class="badge badge-question margin-circle">4</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row" style="padding-bottom: 20px;">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Tạo mới
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    @include('admin.lessons.list_grammar_video')
    @include('admin.lessons.list_lesson_video')
    @include('admin.lessons.list_training')
@endsection

@section('custom-script')
    <script>
        $(document).ready(function () {
            $('select#lesson-videos').select2({
                placeholder: 'Chọn video ngữ pháp'
            });
            $('select#grammar-videos').select2({
                placeholder: 'Chọn video bài học'
            });

            $('.select-video').click(function (e) {
                e.preventDefault()
                let type = $(this).attr('data-type');

                $.ajax({
                    url: "{{ route('admin.lesson.getVideos') }}",
                    method: 'GET',
                    data: {type: type},
                    success: function (res) {
                        let videos = res.videos;
                        let listVideo = `<table id="videoList" class="table table-hover">`;

                        if (videos.length > 0) {
                            videos.map(video => {
                                let thumb = JSON.parse(video.ytb_thumbnails).default.url;

                                let row = `<tr>
                                                <td id="id" style="width: auto;">
                                                    <input id="check_video" value="${video.id}" type="checkbox">
                                                </td>
                                                <td id="thumb" style="width: 80px;">
                                                    <img id="imgThumb" class="thumbList" src="${thumb}" />
                                                </td>
                                                <td id="title">${video.title}</td>
                                            </tr>`;

                                listVideo += row;
                            });
                        } else {
                            listVideo += ` <tr><td colspan="8" align="center">Không có dữ liệu</td></tr>`;
                        }
                        listVideo += '</table>';

                        if (type == 1) {
                            $('#listGrammarModal').modal('toggle')
                            $('#listGrammarModal .result-content').replaceWith(listVideo);
                        } else {
                            $('#listLessonModal').modal('toggle')
                            $('#listLessonModal .result-content').replaceWith(listVideo);
                        }
                    },
                    error: function () {
                        console.log('error')
                    }
                })
            });

            /* Speak */
            $('.add_more_speak').click(function (e) {
                e.preventDefault();
                $('.input_fields_speak').append('<div class="row">\n' +
                    '                                        <div class="col-sm-5">\n' +
                    '                                            <div class="form-group">\n' +
                    '                                                <input type="text" class="form-control form-control-sm"\n' +
                    '                                                       name="speak_name_en[]"\n' +
                    '                                                       placeholder="Nhập vào nội dung tiếng anh">\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="col-sm-5">\n' +
                    '                                            <div class="form-group">\n' +
                    '                                                <input type="text" class="form-control form-control-sm"\n' +
                    '                                                       name="speak_name_vn[]"\n' +
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
            });
            $('.input_fields_speak').on("click", ".remove_speak", function (e) {
                e.preventDefault();
                $(this).parent().parent().parent('div').remove();
            })
            /* End Speak */

            /* Write */
            $('.add_more_write').click(function (e) {
                e.preventDefault();
                $('.input_fields_write').append('<div class="row">\n' +
                    '                                        <div class="col-sm-5">\n' +
                    '                                            <div class="form-group">\n' +
                    '                                                <input type="text" class="form-control form-control-sm"\n' +
                    '                                                       name="speak_write_en[]"\n' +
                    '                                                       placeholder="Nhập vào nội dung tiếng anh">\n' +
                    '                                            </div>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="col-sm-5">\n' +
                    '                                            <div class="form-group">\n' +
                    '                                                <input type="text" class="form-control form-control-sm"\n' +
                    '                                                       name="speak_write_vn[]"\n' +
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
                $('.input_fields_exercises').append('<div class="item_exercises">\n' +
                    '                                        <div class="row">\n' +
                    '                                            <div class="col-sm-10">\n' +
                    '                                                <div class="form-group">\n' +
                    '                                                    <input type="text" class="form-control form-control-sm"\n' +
                    '                                                           name="exercises_name[]"\n' +
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
@endsection

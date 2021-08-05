@extends('admin.layouts.master')

@section('page-title', 'Cập nhật bài học')
@section('breadcrumb', 'Lesson')

@section('main')
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><span class="text-danger">*&nbsp;</span>Không được bỏ trống</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('admin.lesson.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lesson-name">Tên bài học <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="lesson-name" class="form-control"
                                       value="{{ old('name') }}" placeholder="Nhập tên bài học">

                                @error('name')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="grammar-videos">Video Grammar <span class="text-danger">*</span></label>
                                <div class="d-flex border rounded">
                                    <select name="grammar_video[]" class="rounded-0 form-control col-9 border-0"
                                            id="grammar-videos" multiple disabled>
                                    </select>
                                    <button class="col-3 btn btn-info rounded-0 select-video"
                                            data-type="{{ config('common.video_types.Grammar') }}">Chọn video
                                    </button>
                                </div>

                                @error('grammar_video')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lesson-videos">Video Bài học <span class="text-danger">*</span></label>
                                <div class="d-flex border rounded">
                                    <select name="lesson_video[]" class="rounded-0 form-control col-9 border-0"
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
                                <label for="lesson-course">Khóa học <span class="text-danger">*</span></label>
                                <select name="course_id" id="lesson-course" class="form-control">
                                    <option value=""></option>
                                </select>

                                @error('course_id')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>--}}

                            <div class="form-group">
                                <label for="lesson-description">Mô tả <span class="text-danger">*</span></label>
                                <textarea name="description" id="lesson-description" class="form-control"
                                          rows="10">{{ old('description') }}</textarea>

                                @error('description')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lesson-level">Trình độ <span class="text-danger">*</span></label>
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
                            <div class="form-group">
                                <label for="lesson-status">Trạng thái <span class="text-danger">*</span></label>
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
                            <div class="form-group">
                                <label for="lesson-thumb">Ảnh bài học</label>

                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="thumb_img"
                                           value="{{ old('thumb_img') }}" onchange="encodeImageFileAsURL(this)">
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

                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary" id="btn-create">Tạo mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('admin.lessons.list_grammar_video')
    @include('admin.lessons.list_lesson_video')
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
        });
    </script>
@endsection

@extends('admin.layouts.master')

@section('page-title', 'Thêm mới bài học')
@section('breadcrumb', 'Thêm mới bài học')

@section('main')
    <section class="content">
        <form action="{{ route('admin.lesson.store') }}" method="POST" enctype="multipart/form-data">
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
                                            <input type="text" name="name" id="lesson-name"
                                                   class="form-control form-control-md"
                                                   value="{{ old('name') }}" placeholder="Nhập tên bài học">

                                            @error('name')
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
                                                <label for="lesson-course">Khóa học <span
                                                        class="text-danger">*</span></label>
                                                <select name="course_id" id="lesson-course"
                                                        class="form-control form-control-md">
                                                    <option selected>-- Chọn khóa học --</option>
                                                    @foreach($course as $key => $item)
                                                        <option
                                                            value="{{ $item->id }}" {{ old('course_id') ===  $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('course_id')
                                                <p style="color: red;">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="lesson-level">Trình độ <span
                                                        class="text-danger">*</span></label>
                                                <select name="level_id" id="lesson-level"
                                                        class="form-control form-control-md">
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
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="lesson-position">Thứ tự<span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="position" id="lesson-position"
                                                       class="form-control form-control-md"
                                                       value="{{ old('position') }}" placeholder="Nhập vào vị trí">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="lesson-status">Trạng thái <span
                                                        class="text-danger">*</span></label>
                                                <select name="status" id="lesson-status"
                                                        class="form-control form-control-md">
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
                                            <label for="lesson-thumb">Ảnh bài học</label>
                                            <div id="grpThumb" class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                           name="inlineRadioUpload"
                                                           id="inlineRadio1" value="1" checked>
                                                    <label class="form-check-label" for="inlineRadio1">Tải ảnh
                                                        lên</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                           name="inlineRadioUpload"
                                                           id="inlineRadio2" value="2">
                                                    <label class="form-check-label" for="inlineRadio2">Từ link</label>
                                                </div>
                                            </div>
                                            <div class="boxThumb">
                                                <div class="input-group">
                                                    <input type="text" class="form-control input-file-dummy"
                                                           placeholder="Chọn ảnh" aria-describedby="fileHelp"
                                                           readonly>
                                                    <label class="input-group-append mb-0">
                                                <span class="btn btn-info input-file-btn">
                                                    <i class="fa fa-image"></i>&nbsp;&nbsp;Chọn ảnh
                                                    <input type="file" hidden
                                                           id="thumbUpload" name="thumb"
                                                           accept="image/*"
                                                           onchange="previewMultiple(event)">
                                                </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="galleryPhotos"></div>
                                            @error('thumb')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
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
                                <h3 class="card-title">Videos</h3>
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
                                            <label for="grammar-videos">Video Grammar <span class="text-danger">*</span></label>
                                            <div class="itemBorder">
                                                <a class="btn btn-sm btn-info add-video-grammar select-video"
                                                   data-type="{{ config('common.video_types.Grammar') }}"
                                                   href="javascript:void(0)">
                                                    <i class="fa fa-plus"></i><span> Chọn video</span>
                                                </a>
                                                <div id="chooseVideoGrammarList">
                                                    <input style="display: none;" type=" text" value=""
                                                           class="videoGrammarIds"
                                                           name="videoGrammarIds">
                                                    <ul>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="grammar-videos">Video Lesson <span class="text-danger">*</span></label>
                                            <div class="itemBorder">
                                                <a class="btn btn-sm btn-info add-video-lesson select-video"
                                                   data-type="{{ config('common.video_types.Lesson') }}"
                                                   href="javascript:void(0)">
                                                    <i class="fa fa-plus"></i><span> Chọn video</span>
                                                </a>
                                                <div id="chooseVideoLessonList">
                                                    <input style="display: none;" type=" text" value=""
                                                           class="videoLessonIds"
                                                           name="videoLessonIds">
                                                    <ul>
                                                    </ul>
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Speaking&nbsp;&nbsp;&nbsp;<span id="totalSpeak"
                                                                                       class="badge bg-success">0</span>
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-x: scroll">
                                <div class="input_fields_speak">
                                    <div class="row" id="itemDynamic" data-position="0">
                                        <div class="number">
                                            <span class="badge badge-info">1</span>
                                        </div>
                                        <div class="content">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="speak_name_en[0]"
                                                               placeholder="Nhập vào nội dung tiếng anh">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="speak_name_vi[0]"
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
                                <h3 class="card-title">Writing&nbsp;&nbsp;&nbsp;<span id="totalWrite"
                                                                                      class="badge bg-success">0</span>
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-x: scroll">
                                <div class="input_fields_write">
                                    <div class="row" id="itemDynamic" data-position="0">
                                        <div class="number">
                                            <span class="badge badge-info">1</span>
                                        </div>
                                        <div class="content">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="write_name_en[0]"
                                                               placeholder="Nhập vào nội dung tiếng anh">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-sm"
                                                               name="write_name_vi[0]"
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
                                <h3 class="card-title">Do Exercises&nbsp;&nbsp;&nbsp;<span id="totalExercises"
                                                                                           class="badge bg-success">0</span>
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input_fields_exercises">
                                    <div class="layoutBorder" id="itemDynamic" data-position="0">
                                        <div class="row">
                                            <div class="number">
                                                <span class="badge badge-info">1</span>
                                            </div>
                                            <div class="content">
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm"
                                                                   name="exercises_name[0]"
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
                                <h3 class="card-title">Atc Out</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <script>
                                    function openFileActOutEn() {
                                        $("#upload-act-out-en").click();
                                    }

                                    function openFileActOutVi() {
                                        $("#upload-act-out-vi").click();
                                    }
                                </script>
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 20px;">
                                        <a class="btn btn-sm btn-outline-success"
                                           onclick="openFileActOutEn();return;">
                                            <i class="fas fa-upload"></i>
                                            &nbsp;Import Sub Tiếng Anh
                                        </a>
                                        <input type="file" class="form-control"
                                               name="upload_act_out_en"
                                               id="upload-act-out-en"
                                               style="border: none"
                                               hidden
                                               value="">

                                        <a class="btn btn-sm btn-outline-info"
                                           onclick="openFileActOutVi();return;">
                                            <i class="fas fa-upload"></i>
                                            &nbsp;Import Sub Tiếng Việt
                                        </a>
                                        <input type="file" class="form-control"
                                               name="upload_act_out_vi"
                                               id="upload-act-out-vi"
                                               style="border: none"
                                               hidden
                                               value="">
                                    </div>
                                </div>
                                <div id="atcOutList">
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
                                    class="fa fa-save"></i>&nbsp;&nbsp;Tạo mới
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    @include('admin.lessons.list_grammar_video')
    @include('admin.lessons.list_lesson_video')

    <div class="modal fade" id="upload_sub" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form-upload" action="{{ route('admin.video.uploadSub') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="video_id" value="">
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
    @include('admin.layouts.script_lesson')
    @include('admin.layouts.script_lesson_act_out')
@endsection

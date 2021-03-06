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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="lesson-name">Tên bài học <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="lesson-name"
                                            class="form-control form-control-md" value="{{ old('name') }}"
                                            placeholder="Nhập tên bài học">

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
                                                <option value="{{ $item->id }}" {{ old('course_id')===$item->id ?
                                                    'selected' : '' }}>{{ $item->name }}</option>
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
                                                <option value="{{ $level->id }}" {{ old('level_id')===$level->id ?
                                                    'selected' : '' }}>{{ $level->name }}</option>
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
                                                class="form-control form-control-md" value="{{ old('position') }}"
                                                placeholder="Nhập vào vị trí">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="lesson-status">Trạng thái <span
                                                    class="text-danger">*</span></label>
                                            <select name="status" id="lesson-status"
                                                class="form-control form-control-md">
                                                @foreach(config('common.status') as $key => $value)
                                                <option value="{{ $value }}" {{ old('status')===$value ? 'selected' : ''
                                                    }}>{{ $key }}</option>
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
                                                <input class="form-check-input" type="radio" name="inlineRadioUpload"
                                                    id="inlineRadio1" value="1" checked>
                                                <label class="form-check-label" for="inlineRadio1">Tải ảnh
                                                    lên</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioUpload"
                                                    id="inlineRadio2" value="2">
                                                <label class="form-check-label" for="inlineRadio2">Từ link</label>
                                            </div>
                                        </div>
                                        <div class="boxThumb">
                                            <div class="input-group">
                                                <input type="text" class="form-control input-file-dummy"
                                                    placeholder="Chọn ảnh" aria-describedby="fileHelp" readonly>
                                                <label class="input-group-append mb-0">
                                                    <span class="btn btn-info input-file-btn">
                                                        <i class="fa fa-image"></i>&nbsp;&nbsp;Chọn ảnh
                                                        <input type="file" hidden id="thumbUpload" name="thumb"
                                                            accept="image/*" onchange="previewMultiple(event)">
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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="grammar-videos">Video Grammar <span
                                                class="text-danger">*</span></label>
                                        <div class="itemBorder">
                                            <a class="btn btn-sm btn-info add-video-grammar select-video"
                                                data-type="{{ config('common.video_types.Grammar') }}"
                                                href="javascript:void(0)">
                                                <i class="fa fa-plus"></i><span> Chọn video</span>
                                            </a>
                                            <div id="chooseVideoGrammarList">
                                                <input style="display: none;" type=" text" value=""
                                                    class="videoGrammarIds" name="videoGrammarIds">
                                                <ul>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="grammar-videos">Video Lesson <span
                                                class="text-danger">*</span></label>
                                        <div class="itemBorder">
                                            <a class="btn btn-sm btn-info add-video-lesson select-video"
                                                data-type="{{ config('common.video_types.Lesson') }}"
                                                href="javascript:void(0)">
                                                <i class="fa fa-plus"></i><span> Chọn video</span>
                                            </a>
                                            <div id="chooseVideoLessonList">
                                                <input style="display: none;" type=" text" value=""
                                                    class="videoLessonIds" name="videoLessonIds">
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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
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
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control form-control-sm input-file-dummy"
                                                        name="speak_name_en[0]"
                                                        placeholder="Nhập vào nội dung tiếng anh"
                                                        aria-describedby="fileHelp">
                                                    <label class="input-group-append mb-0">
                                                        <span class="btn btn-sm btn-success input-file-btn">
                                                            <i class="fas fa-file-audio"></i>&nbsp;&nbsp;Chọn file
                                                            <input type="file" hidden name="speak_file_en[0]"
                                                                id="speak-file-en-0" onchange="getFileName('speak-file-en-0', 'speak-input-en-0')">
                                                        </span>
                                                    </label>
                                                </div>
                                                <span style="font-size: 13px;" id="speak-input-en-0"></span>
                                                <p class="row align-items-center ml-1 my-2 d-none">
                                                    <audio controls>
                                                        <source src=""
                                                            type="audio/mpeg">
                                                        Trình duyệt không hỗ trợ phát audio
                                                    </audio>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger ml-2" onclick="removeFile('speak-file-en-0', 'speak-input-en-0')"><i class="fas fa-times"></i></a>
                                                </p>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control form-control-sm input-file-dummy"
                                                        name="speak_name_vi[0]"
                                                        placeholder="Nhập vào nội dung tiếng việt"
                                                        aria-describedby="fileHelp">
                                                    <label class="input-group-append mb-0">
                                                        <span class="btn btn-sm btn-success input-file-btn">
                                                            <i class="fas fa-file-audio"></i>&nbsp;&nbsp;Chọn file
                                                            <input type="file" hidden name="speak_file_vi[0]"
                                                                id="speak-file-vi-0" onchange="getFileName('speak-file-vi-0', 'speak-input-vi-0')">
                                                        </span>
                                                    </label>
                                                </div>
                                                <span style="font-size: 13px;" id="speak-input-vi-0"></span>
                                                <p class="row align-items-center ml-1 my-2 d-none">
                                                    <audio controls>
                                                        <source src=""
                                                            type="audio/mpeg">
                                                        Trình duyệt không hỗ trợ phát audio
                                                    </audio>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger ml-2" onclick="removeFile('speak-file-vi-0', 'speak-input-vi-0')"><i class="fas fa-times"></i></a>
                                                </p>
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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
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
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control form-control-sm input-file-dummy"
                                                        name="write_name_en[0]"
                                                        placeholder="Nhập vào nội dung tiếng anh"
                                                        aria-describedby="fileHelp">
                                                    <label class="input-group-append mb-0">
                                                        <span class="btn btn-sm btn-success input-file-btn">
                                                            <i class="fas fa-file-audio"></i>&nbsp;&nbsp;Chọn file
                                                            <input type="file" hidden name="write_file_en[0]"
                                                                id="write-file-en-0" onchange="getFileName('write-file-en-0', 'write-input-en-0')">
                                                        </span>
                                                    </label>
                                                </div>
                                                <span style="font-size: 13px;" id="write-input-en-0"></span>
                                                <p class="row align-items-center ml-1 my-2 d-none">
                                                    <audio controls>
                                                        <source src=""
                                                            type="audio/mpeg">
                                                        Trình duyệt không hỗ trợ phát audio
                                                    </audio>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger ml-2" onclick="removeFile('write-file-en-0', 'write-input-en-0')"><i class="fas fa-times"></i></a>
                                                </p>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control form-control-sm input-file-dummy"
                                                        name="write_name_vi[0]"
                                                        placeholder="Nhập vào nội dung tiếng việt"
                                                        aria-describedby="fileHelp">
                                                    <label class="input-group-append mb-0">
                                                        <span class="btn btn-sm btn-success input-file-btn">
                                                            <i class="fas fa-file-audio"></i>&nbsp;&nbsp;Chọn file
                                                            <input type="file" hidden name="write_file_vi[0]"
                                                                id="write-file-vi-0" onchange="getFileName('write-file-vi-0', 'write-input-vi-0')">
                                                        </span>
                                                    </label>
                                                </div>
                                                <span style="font-size: 13px;" id="write-input-vi-0"></span>
                                                <p class="row align-items-center ml-1 my-2 d-none">
                                                    <audio controls>
                                                        <source src=""
                                                            type="audio/mpeg">
                                                        Trình duyệt không hỗ trợ phát audio
                                                    </audio>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger ml-2" onclick="removeFile('write-file-vi-0', 'write-input-vi-0')"><i class="fas fa-times"></i></a>
                                                </p>
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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
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
                                                                name="answer_1[0]" placeholder="Nhập câu trả lời">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-1"><span
                                                                class="badge badge-question">2</span></label>
                                                        <div class="col-sm-11">
                                                            <input type="text" class="form-control form-control-sm"
                                                                name="answer_2[0]" placeholder="Nhập câu trả lời">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-1"><span
                                                                class="badge badge-question">3</span></label>
                                                        <div class="col-sm-11">
                                                            <input type="text" class="form-control form-control-sm"
                                                                name="answer_3[0]" placeholder="Nhập câu trả lời">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-1"><span
                                                                class="badge badge-question">4</span></label>
                                                        <div class="col-sm-11">
                                                            <input type="text" class="form-control form-control-sm"
                                                                name="answer_4[0]" placeholder="Nhập câu trả lời">
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
                                                                <input class="form-check-input" type="radio"
                                                                    id="answer_correct_1_0" name="answer_correct[0]"
                                                                    value="1" checked>
                                                                <label for="answer_correct_1_0"><span
                                                                        class="badge badge-question margin-circle">1</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="answer_correct_2_0" name="answer_correct[0]"
                                                                    value="2">
                                                                <label for="answer_correct_2_0"><span
                                                                        class="badge badge-question margin-circle">2</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="answer_correct_3_0" name="answer_correct[0]"
                                                                    value="3">
                                                                <label for="answer_correct_3_0"><span
                                                                        class="badge badge-question margin-circle">3</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="answer_correct_4_0" name="answer_correct[0]"
                                                                    value="4">
                                                                <label for="answer_correct_4_0"><span
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
                                                        <label for="answer_description">Diễn giải đáp án</label>
                                                        <textarea name="answer_description[0]" rows="3"
                                                            class="form-control"></textarea>
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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
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
                                    <a class="btn btn-sm btn-outline-success" onclick="openFileActOutEn();return;">
                                        <i class="fas fa-upload"></i>
                                        &nbsp;Import Sub Tiếng Anh
                                    </a>
                                    <input type="file" class="form-control" name="upload_act_out_en"
                                        id="upload-act-out-en" style="border: none" hidden value="">

                                    <a class="btn btn-sm btn-outline-info" onclick="openFileActOutVi();return;">
                                        <i class="fas fa-upload"></i>
                                        &nbsp;Import Sub Tiếng Việt
                                    </a>
                                    <input type="file" class="form-control" name="upload_act_out_vi"
                                        id="upload-act-out-vi" style="border: none" hidden value="">
                                </div>
                            </div>
                            <div class="layoutBorder">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="act-out-name-one"><span
                                                    class="badge badge-question">1</span>&nbsp;&nbsp;Tên nhân vật
                                                thứ
                                                nhất<span class="text-danger">*</span></label>
                                            <input type="text" name="actOutNameOne" id="actOutNameOne"
                                                class="form-control form-control-md" value="{{ old('actOutNameOne') }}"
                                                placeholder="Nhập tên nhân vật thứ nhất">
                                        </div>
                                        <div id="characterOne" class="form-group">
                                            <label for="grpAvatarThumb">Avatar</label>
                                            <div id="grpAvatarThumb" class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineCharacterOne" id="avatarOneUpload" value="1"
                                                        checked>
                                                    <label class="form-check-label" for="avatarOneUpload">Tải ảnh
                                                        lên</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineCharacterOne" id="avatarOneLink" value="2">
                                                    <label class="form-check-label" for="avatarOneLink">Từ
                                                        link</label>
                                                </div>
                                            </div>
                                            <div class="boxThumbCharacterOne">
                                                <div class="input-group">
                                                    <input type="text" class="form-control input-file-dummy"
                                                        placeholder="Chọn ảnh" aria-describedby="fileHelp" readonly>
                                                    <label class="input-group-append mb-0">
                                                        <span class="btn btn-info input-file-btn">
                                                            <i class="fa fa-image"></i>&nbsp;&nbsp;Chọn ảnh
                                                            <input type="file" hidden id="characterOneUpload"
                                                                name="characterOneUpload" accept="image/*"
                                                                onchange="previewAvatarOne(event)">
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="characterPhotoOne"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="act-out-name-two"><span
                                                    class="badge badge-question">2</span>&nbsp;&nbsp;Tên nhân vật
                                                thứ
                                                hai<span class="text-danger">*</span></label>
                                            <input type="text" name="actOutNameTwo" id="actOutNameTwo"
                                                class="form-control form-control-md" value="{{ old('actOutNameTwo') }}"
                                                placeholder="Nhập tên nhân vật thứ hai">
                                        </div>
                                        <div id="characterTwo" class="form-group">
                                            <label for="grpAvatarTwo">Avatar</label>
                                            <div id="grpAvatarTwo" class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineCharacterTwo" id="avatarTwoUpload" value="1"
                                                        checked>
                                                    <label class="form-check-label" for="avatarTwoUpload">Tải ảnh
                                                        lên</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineCharacterTwo" id="avatarTwoLink" value="2">
                                                    <label class="form-check-label" for="avatarTwoLink">Từ
                                                        link</label>
                                                </div>
                                            </div>
                                            <div class="boxThumbCharacterTwo">
                                                <div class="input-group">
                                                    <input type="text" class="form-control input-file-dummy"
                                                        placeholder="Chọn ảnh" aria-describedby="fileHelp" readonly>
                                                    <label class="input-group-append mb-0">
                                                        <span class="btn btn-info input-file-btn">
                                                            <i class="fa fa-image"></i>&nbsp;&nbsp;Chọn ảnh
                                                            <input type="file" hidden id="characterTwoUpload"
                                                                name="characterTwoUpload" accept="image/*"
                                                                onchange="previewAvatarTwo(event)">
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="characterPhotoTwo"></div>
                                        </div>
                                    </div>
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
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Tạo mới
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

@include('admin.lessons.list_grammar_video')
@include('admin.lessons.list_lesson_video')

@endsection

@section('custom-script')
@include('admin.layouts.script_lesson')
@include('admin.layouts.script_lesson_act_out')
@endsection

@extends('admin.layouts.master')

@section('page-title', 'Cập nhật bài học')
@section('breadcrumb', 'Cập nhật bài học')

@section('main')
    <section class="content">
        <form action="{{ route('admin.lesson.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $lesson->id }}">
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
                                                   value="{{ $lesson->name ? $lesson->name : old('name') }}"
                                                   placeholder="Nhập tên bài học">

                                            @error('name')
                                            <p style="color: red;">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="lesson-description">Mô tả</label>
                                            <textarea name="description" id="lesson-description" class="form-control"
                                                      rows="10">{{ $lesson->description ? $lesson->description : old('description') }}</textarea>

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
                                                            value="{{ $item->id }}" {{ $lesson->course_id  ==  $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                                            value="{{ $level->id }}" {{ $lesson->level_id ==  $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
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
                                                       value="{{ $lesson->position ? $lesson->position : old('position') }}"
                                                       placeholder="Nhập vào vị trí">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="lesson-status">Trạng thái <span
                                                        class="text-danger">*</span></label>
                                                <select name="status" id="lesson-status"
                                                        class="form-control form-control-md">
                                                    @foreach(config('common.status') as $key => $value)
                                                        <option
                                                            value="{{ $value }}" {{ $lesson->status ==  $value ? 'selected' : '' }}>{{ $key }}</option>
                                                    @endforeach
                                                </select>

                                                @error('status')
                                                <p style="color: red;">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lesson-thumb">Ảnh bài học<span
                                                    class="text-danger">*</span></label>
                                            <div id="grpThumb" class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                           name="inlineRadioUpload"
                                                           data-path="{{$lesson->thumb_img}}"
                                                           id="inlineRadio1" value="1"
                                                           @if(!isUrl($lesson->thumb_img)) checked @else @endif>
                                                    <label class="form-check-label" for="inlineRadio1">Tải ảnh
                                                        lên</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                           name="inlineRadioUpload"
                                                           data-path="{{$lesson->thumb_img}}"
                                                           id="inlineRadio2" value="2"
                                                           @if(isUrl($lesson->thumb_img)) checked @else @endif>
                                                    <label class="form-check-label" for="inlineRadio2">Từ link</label>
                                                </div>
                                            </div>
                                            <div class="boxThumb">
                                                @if(isUrl($lesson->thumb_img))
                                                    <input id="thumbLink" name="thumb" type="text"
                                                           class="form-control input-file-dummy"
                                                           value="{{$lesson->thumb_img}}"
                                                           placeholder="Nhập vào link ảnh">
                                                @else
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-file-dummy"
                                                               readonly
                                                               placeholder="Chọn ảnh" aria-describedby="fileHelp">
                                                        <label class="input-group-append mb-0">
                                                <span class="btn btn-info input-file-btn">
                                                    <i class="fa fa-image"></i>&nbsp;&nbsp;Chọn ảnh
                                                    <input type="file" hidden
                                                           id="thumbUpload" name="thumb"
                                                           onchange="previewMultiple(event)">
                                                </span>
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                            <div id="galleryPhotos">
                                                @if(!empty($lesson->thumb_img))
                                                    <div class="imagePhoto">
                                                        <img
                                                            src="@if(isUrl($lesson->thumb_img)) {{$lesson->thumb_img}} @else {{ asset('storage/' . $lesson->thumb_img) }} @endif">
                                                    </div>
                                                @endif
                                            </div>
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
                                                    <input style="display: none;" type=" text"
                                                           class="videoGrammarIds"
                                                           name="videoGrammarIds"
                                                           value="{{$grammarIds}}">
                                                    <ul>
                                                        @if(!empty($grammarVideoData))
                                                            @foreach($grammarVideoData as $index => $item)
                                                                <li id="{{$item->id}}">
                                                                    <div class="alert  alert-info alert-dismissible"
                                                                         role="alert">
                                                                        <button id="removeVideoGrammar"
                                                                                data-id="{{$item->id}}" type="button"
                                                                                class="close" data-dismiss="alert"
                                                                                aria-label="Close">
                                                                            <span aria-hidden="true">×</span></button>
                                                                        <span id="grammarVideoId"
                                                                              style="display:none;">{{$item->id}}</span>
                                                                        <img style="margin-right: 10px;" width="50"
                                                                             height="30"
                                                                             src="{{ $item->custom_thumbnails ? asset('storage/' . $item->custom_thumbnails) : json_decode($item->ytb_thumbnails, true)['default']['url'] }}"/>
                                                                        <span class="tit">{{$item->title}}</span>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        @endif
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
                                                    <input style="display: none;" type=" text"
                                                           class="videoLessonIds"
                                                           name="videoLessonIds"
                                                           value="{{$lessonIds}}">
                                                    <ul>
                                                        @if(!empty($lessonVideoData))
                                                            @foreach($lessonVideoData as $index => $item)
                                                                <li id="{{$item->id}}">
                                                                    <div class="alert  alert-info alert-dismissible"
                                                                         role="alert">
                                                                        <button id="removeVideoLesson"
                                                                                data-id="{{$item->id}}" type="button"
                                                                                class="close" data-dismiss="alert"
                                                                                aria-label="Close">
                                                                            <span aria-hidden="true">×</span></button>
                                                                        <span id="lessonVideoId"
                                                                              style="display:none;">{{$item->id}}</span>
                                                                        <img style="margin-right: 10px;" width="50"
                                                                             height="30"
                                                                             src="{{ $item->custom_thumbnails ? asset('storage/' . $item->custom_thumbnails) : json_decode($item->ytb_thumbnails, true)['default']['url'] }}"/>
                                                                        <span class="tit">{{$item->title}}</span>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        @endif
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
                                    @if(!$speakingData->isEmpty())
                                        @foreach($speakingData as $index => $item)
                                            <div class="row" id="itemDynamic" data-position="{{$index}}">
                                                <div class="number">
                                                    <span class="badge badge-info">{{$index + 1}}</span>
                                                </div>
                                                <div class="content">
                                                    <div class="row">
                                                        <input name="id_speak[{{$index}}]" type="text"
                                                               value="{{$item->id}}"
                                                               hidden>
                                                        <div class="col-sm-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm"
                                                                       name="speak_name_en[{{$index}}]"
                                                                       placeholder="Nhập vào nội dung tiếng anh"
                                                                       value="{{ $item->en }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm"
                                                                       name="speak_name_vi[{{$index}}]"
                                                                       placeholder="Nhập vào nội dung tiếng việt"
                                                                       value="{{ $item->vi }}">
                                                            </div>
                                                        </div>
                                                        @if($index == 0)
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <a class="btn btn-sm btn-success add_more_speak"
                                                                       href="javascript:void(0)">
                                                                        <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Speak
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-sm btn-danger remove_speak">
                                                                        <i class="fa fa-times"></i>&nbsp;&nbsp; Remove
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row" id="itemDynamic" data-position="0">
                                            <div class="number">
                                                <span class="badge badge-info">1</span>
                                            </div>
                                            <div class="content">
                                                <div class="row">
                                                    <input name="id_speak[0]" type="text" value="0" hidden>
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
                                    @endif
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
                                    @if(!$writingData->isEmpty())
                                        @foreach($writingData as $index => $item)
                                            <div class="row" id="itemDynamic" data-position="{{$index}}">
                                                <div class="number">
                                                    <span class="badge badge-info">{{$index + 1}}</span>
                                                </div>
                                                <div class="content">
                                                    <div class="row">
                                                        <input name="id_write[{{$index}}]" type="text"
                                                               value="{{$item->id}}"
                                                               hidden>
                                                        <div class="col-sm-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm"
                                                                       name="write_name_en[{{$index}}]"
                                                                       placeholder="Nhập vào nội dung tiếng anh"
                                                                       value="{{ $item->en }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm"
                                                                       name="write_name_vi[{{$index}}]"
                                                                       placeholder="Nhập vào nội dung tiếng việt"
                                                                       value="{{ $item->vi }}">
                                                            </div>
                                                        </div>
                                                        @if($index == 0)
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <a class="btn btn-sm btn-success add_more_write"
                                                                       href="javascript:void(0)">
                                                                        <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Write
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-sm btn-danger remove_write">
                                                                        <i class="fa fa-times"></i>&nbsp;&nbsp; Remove
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row" id="itemDynamic" data-position="0">
                                            <div class="number">
                                                <span class="badge badge-info">1</span>
                                            </div>
                                            <div class="content">
                                                <div class="row">
                                                    <input name="id_write[0]" type="text" value="0" hidden>
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
                                    @endif
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
                                    @if($exercisesData->isEmpty())
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
                                                                    <input type="text"
                                                                           class="form-control form-control-sm"
                                                                           name="answer_1[0]"
                                                                           placeholder="Nhập câu trả lời">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-1"><span
                                                                        class="badge badge-question">2</span></label>
                                                                <div class="col-sm-11">
                                                                    <input type="text"
                                                                           class="form-control form-control-sm"
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
                                                                    <input type="text"
                                                                           class="form-control form-control-sm"
                                                                           name="answer_3[0]"
                                                                           placeholder="Nhập câu trả lời">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-1"><span
                                                                        class="badge badge-question">4</span></label>
                                                                <div class="col-sm-11">
                                                                    <input type="text"
                                                                           class="form-control form-control-sm"
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
                                                                               name="answer_correct[0]" value="1"
                                                                               checked>
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
                                    @else
                                        @foreach($exercisesData as $index => $item)
                                            <div class="layoutBorder" id="itemDynamic" data-position="{{$index}}">
                                                <div class="row">
                                                    <div class="number">
                                                        <span class="badge badge-info">{{$index + 1}}</span>
                                                    </div>
                                                    <div class="content">
                                                        <div class="row">
                                                            <input name="id_exercises[{{$index}}]" type="text"
                                                                   value="{{$item->id}}" hidden>
                                                            <div class="col-sm-10">
                                                                <div class="form-group">
                                                                    <input type="text"
                                                                           class="form-control form-control-sm"
                                                                           name="exercises_name[{{$index}}]"
                                                                           placeholder="Nhập nội dung câu hỏi"
                                                                           value="{{ $item->name }}">
                                                                </div>
                                                            </div>
                                                            @if($index ==0)
                                                                <div class="col-sm-2">
                                                                    <div class="form-group">
                                                                        <a class="btn btn-sm btn-success add_more_exercises"
                                                                           href="javascript:void(0)">
                                                                            <i class="fa fa-plus"></i>&nbsp;&nbsp; Add
                                                                            Exercises
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-sm-2">
                                                                    <div class="form-group">
                                                                        <a class="btn btn-sm btn-danger remove_exercises"
                                                                           href="javascript:void(0)">
                                                                            <i class="fa fa-times"></i>&nbsp;&nbsp;
                                                                            Remove
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-1"><span
                                                                            class="badge badge-question">1</span></label>
                                                                    <div class="col-sm-11">
                                                                        <input type="text"
                                                                               class="form-control form-control-sm"
                                                                               name="answer_1[{{$index}}]"
                                                                               placeholder="Nhập câu trả lời"
                                                                               value="{{ $item->answer_1 }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-1"><span
                                                                            class="badge badge-question">2</span></label>
                                                                    <div class="col-sm-11">
                                                                        <input type="text"
                                                                               class="form-control form-control-sm"
                                                                               name="answer_2[{{$index}}]"
                                                                               placeholder="Nhập câu trả lời"
                                                                               value="{{ $item->answer_2 }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-1"><span
                                                                            class="badge badge-question">3</span></label>
                                                                    <div class="col-sm-11">
                                                                        <input type="text"
                                                                               class="form-control form-control-sm"
                                                                               name="answer_3[{{$index}}]"
                                                                               placeholder="Nhập câu trả lời"
                                                                               value="{{ $item->answer_3 }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="" class="col-sm-1"><span
                                                                            class="badge badge-question">4</span></label>
                                                                    <div class="col-sm-11">
                                                                        <input type="text"
                                                                               class="form-control form-control-sm"
                                                                               name="answer_4[{{$index}}]"
                                                                               placeholder="Nhập câu trả lời"
                                                                               value="{{ $item->answer_4 }}">
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
                                                                                   type="radio"
                                                                                   id="answer_correct_1_{{$index}}"
                                                                                   name="answer_correct[{{$index}}]"
                                                                                   value="1"
                                                                                {{ ($item->answer_correct == 1) ? 'checked': '' }}>
                                                                            <label
                                                                                for="answer_correct_1_{{$index}}"><span
                                                                                    class="badge badge-question margin-circle">1</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                   type="radio"
                                                                                   id="answer_correct_2_{{$index}}"
                                                                                   name="answer_correct[{{$index}}]"
                                                                                   value="2"
                                                                                {{ ($item->answer_correct == 2) ? 'checked': '' }}>
                                                                            <label
                                                                                for="answer_correct_2_{{$index}}"><span
                                                                                    class="badge badge-question margin-circle">2</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                   type="radio"
                                                                                   id="answer_correct_3_{{$index}}"
                                                                                   name="answer_correct[{{$index}}]"
                                                                                   value="3"
                                                                                {{ ($item->answer_correct == 3) ? 'checked': '' }}>
                                                                            <label
                                                                                for="answer_correct_3_{{$index}}"><span
                                                                                    class="badge badge-question margin-circle">3</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                   type="radio"
                                                                                   id="answer_correct_4_{{$index}}"
                                                                                   name="answer_correct[{{$index}}]"
                                                                                   value="4"
                                                                                {{ ($item->answer_correct == 4) ? 'checked': '' }}>
                                                                            <label
                                                                                for="answer_correct_4_{{$index}}"><span
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
                                                                    <textarea name="answer_description[{{$index}}]" rows="3"
                                                                              class="form-control">{{$item->description}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
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
                                        <a class="btn btn-sm btn-outline-danger" id="deleteActOut"
                                           data-id="{{ $lesson->id }}">
                                            <i class="fas fa-trash"></i>
                                            &nbsp;Xóa danh Act Out
                                        </a>
                                    </div>
                                </div>

                                <div class="layoutBorder">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="act-out-name-one"><span
                                                        class="badge badge-question">1</span>&nbsp;&nbsp;Tên nhân vật
                                                    thứ nhất<span
                                                        class="text-danger">*</span></label>
                                                <input hidden type="text" name="actOutIdOne" id="actOutIdOne"
                                                       class="form-control form-control-md"
                                                       value="{{!empty($actOutCharacter) && count($actOutCharacter) >= 1 ? $actOutCharacter[0]->id : 0}}">
                                                <input type="text" name="actOutNameOne" id="actOutNameOne"
                                                       class="form-control form-control-md"
                                                       value="{{!empty($actOutCharacter) && count($actOutCharacter) >= 1 ? $actOutCharacter[0]->characterName : ''}}"
                                                       placeholder="Nhập tên nhân vật thứ nhất">
                                            </div>
                                            <div id="characterOne" class="form-group">
                                                <label for="grpAvatarThumb">Avatar</label>
                                                <div id="grpAvatarThumb" class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                               name="inlineCharacterOne"
                                                               data-path-avatar-1="{{!empty($actOutCharacter) && count($actOutCharacter) >= 1 ? $actOutCharacter[0]->image:''}}"
                                                               id="avatarOneUpload" value="1"
                                                               @if(!empty($actOutCharacter) && count($actOutCharacter) >= 1 && !isUrl($actOutCharacter[0]->image)) checked @else @endif>
                                                        <label class="form-check-label" for="avatarOneUpload">Tải ảnh
                                                            lên</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                               name="inlineCharacterOne"
                                                               data-path-avatar-1="{{!empty($actOutCharacter) && count($actOutCharacter) >= 1 ? $actOutCharacter[0]->image :''}}"
                                                               id="avatarOneLink" value="2"
                                                               @if(!empty($actOutCharacter) && count($actOutCharacter) >= 1 && isUrl($actOutCharacter[0]->image)) checked @else @endif>
                                                        <label class="form-check-label" for="avatarOneLink">Từ
                                                            link</label>
                                                    </div>
                                                </div>
                                                <div class="boxThumbCharacterOne">
                                                    @if(!empty($actOutCharacter) && count($actOutCharacter) >= 1 && isUrl($actOutCharacter[0]->image))
                                                        <input id="characterOneUpload" name="characterOneUpload"
                                                               type="text"
                                                               class="form-control input-file-dummy"
                                                               value="{{!empty($actOutCharacter) && count($actOutCharacter) >= 1 ? $actOutCharacter[0]->image : ''}}"
                                                               placeholder="Nhập vào link ảnh">
                                                    @else
                                                        <div class="input-group">
                                                            <input type="text" class="form-control input-file-dummy"
                                                                   readonly
                                                                   placeholder="Chọn ảnh" aria-describedby="fileHelp">
                                                            <label class="input-group-append mb-0">
                                                            <span class="btn btn-info input-file-btn">
                                                                <i class="fa fa-image"></i>&nbsp;&nbsp;Chọn ảnh
                                                                <input type="file" hidden
                                                                       accept="image/*"
                                                                       id="characterOneUpload" name="characterOneUpload"
                                                                       onchange="previewAvatarOne(event)">
                                                            </span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div id="characterPhotoOne">
                                                    @if(!empty($actOutCharacter) && count($actOutCharacter) >= 1 && !empty($actOutCharacter[0]))
                                                        <div class="imagePhoto">
                                                            <img
                                                                src="@if(!empty($actOutCharacter) && count($actOutCharacter) >= 1 && isUrl($actOutCharacter[0]->image)) {{$actOutCharacter[0]->image}} @else {{ asset('storage/' . $actOutCharacter[0]->image) }} @endif">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="act-out-name-two"><span
                                                        class="badge badge-question">2</span>&nbsp;&nbsp;Tên nhân vật
                                                    thứ
                                                    hai<span
                                                        class="text-danger">*</span></label>
                                                <input hidden type="text" name="actOutIdTwo" id="actOutIdTwo"
                                                       class="form-control form-control-md"
                                                       value="{{!empty($actOutCharacter) && count($actOutCharacter) >= 2 ? $actOutCharacter[1]->id : 0}}">
                                                <input type="text" name="actOutNameTwo" id="actOutNameTwo"
                                                       class="form-control form-control-md"
                                                       value="{{!empty($actOutCharacter) && count($actOutCharacter) >= 2 ? $actOutCharacter[1]->characterName : ''}}"
                                                       placeholder="Nhập tên nhân vật thứ hai">
                                            </div>
                                            <div id="characterTwo" class="form-group">
                                                <label for="grpAvatarTwo">Avatar</label>
                                                <div id="grpAvatarTwo" class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                               name="inlineCharacterTwo"
                                                               data-path-avatar-2="{{!empty($actOutCharacter) && count($actOutCharacter) >= 2 ? $actOutCharacter[1]->image : ''}}"
                                                               id="avatarTwoUpload" value="1"
                                                               @if(!empty($actOutCharacter) && count($actOutCharacter) >= 2 && !isUrl($actOutCharacter[1]->image)) checked @else @endif>
                                                        <label class="form-check-label" for="avatarTwoUpload">Tải ảnh
                                                            lên</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                               name="inlineCharacterTwo"
                                                               data-path-avatar-2="{{!empty($actOutCharacter) && count($actOutCharacter) >= 2 ? $actOutCharacter[1]->image : ''}}"
                                                               id="avatarTwoLink" value="2"
                                                               @if(!empty($actOutCharacter) && count($actOutCharacter) >= 2 && isUrl($actOutCharacter[1]->image)) checked @else @endif>
                                                        <label class="form-check-label" for="avatarTwoLink">Từ
                                                            link</label>
                                                    </div>
                                                </div>
                                                <div class="boxThumbCharacterTwo">
                                                    @if(!empty($actOutCharacter) && count($actOutCharacter) >= 2  && isUrl($actOutCharacter[1]->image))
                                                        <input id="characterTwoUpload" name="characterTwoUpload"
                                                               type="text"
                                                               class="form-control input-file-dummy"
                                                               value="{{!empty($actOutCharacter) && count($actOutCharacter) >= 2 ? $actOutCharacter[1]->image: ''}}"
                                                               placeholder="Nhập vào link ảnh">
                                                    @else
                                                        <div class="input-group">
                                                            <input type="text" class="form-control input-file-dummy"
                                                                   readonly
                                                                   placeholder="Chọn ảnh" aria-describedby="fileHelp">
                                                            <label class="input-group-append mb-0">
                                                            <span class="btn btn-info input-file-btn">
                                                                <i class="fa fa-image"></i>&nbsp;&nbsp;Chọn ảnh
                                                                <input type="file" hidden
                                                                       accept="image/*"
                                                                       id="characterTwoUpload" name="characterTwoUpload"
                                                                       onchange="previewAvatarTwo(event)">
                                                            </span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div id="characterPhotoTwo">
                                                    @if(!empty($actOutCharacter) && count($actOutCharacter) >= 2 && !empty($actOutCharacter[1]))
                                                        <div class="imagePhoto">
                                                            <img
                                                                src="@if(!empty($actOutCharacter) && count($actOutCharacter) >= 2 && isUrl($actOutCharacter[1]->image)) {{$actOutCharacter[1]->image}} @else {{ asset('storage/' . $actOutCharacter[1]->image) }} @endif">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="atcOutList">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th style="width: 30px;">#</th>
                                            <th style="width: 150px;">Chọn nhân vật</th>
                                            <th style="width: 160px;">Time</th>
                                            <th>English</th>
                                            <th>Viet Nam</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($actOutData as $index => $item)
                                            <tr style="cursor: pointer">
                                                <td>{{$index+1}}</td>
                                                <td>
                                                    <input hidden name="actOutId[{{$index}}]"
                                                           class="form-control form-control-sm"
                                                           value="{{$item->id}}">
                                                    <div class="form-group">
                                                        <div class="form-check form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="actOutCharacterId[{{$index}}]"
                                                                   id="character1_{{$index}}" value="1"
                                                                {{ ($item->characterId  == 1) ? 'checked': '' }}>
                                                            <label class="form-check-label" for="character1_{{$index}}">Nhân
                                                                vật <span class="badge badge-question">1</span></label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                   name="actOutCharacterId[{{$index}}]"
                                                                   id="character2_{{$index}}" value="2"
                                                                {{ ($item->characterId  == 2) ? 'checked': '' }}>
                                                            <label class="form-check-label" for="character2_{{$index}}">Nhân
                                                                vật <span class="badge badge-question">2</span></label>
                                                        </div>
                                                    </div>
                                                <td>
                                                    <div>
                                                        <span class="item-child-lbl"><i class="fa fa-clock"></i>&nbsp;Time start:&nbsp;</span>
                                                        <span
                                                            class="item-child-val">{{ seconds2SRT($item->time_start) }}</span>
                                                        <input name="actOutTimeStart[{{$index}}]" hidden
                                                               class="form-control form-control-sm"
                                                               value="{{$item->time_start}}">
                                                    </div>
                                                    <div>
                                                        <span class="item-child-lbl"><i class="fa fa-clock"></i>&nbsp;Time end:&nbsp;</span>
                                                        <span
                                                            class="item-child-val">{{ seconds2SRT($item->time_end) }}</span>
                                                        <input name="actOutTimeEnd[{{$index}}]" hidden
                                                               class="form-control form-control-sm"
                                                               value="{{$item->time_end}}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input name="actOutEn[{{$index}}]"
                                                           class="form-control form-control-sm"
                                                           value="{{$item->en}}">
                                                </td>
                                                <td>
                                                    <input name="actOutVi[{{$index}}]"
                                                           class="form-control form-control-sm"
                                                           value="{{$item->vi}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
                                    class="fa fa-edit"></i>&nbsp;&nbsp;Cập nhật
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

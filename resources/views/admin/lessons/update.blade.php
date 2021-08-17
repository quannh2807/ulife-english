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
                                <h3 class="card-title">Speaking</h3>
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
                                            <div class="row" data-position="{{$index}}">
                                                <input name="id_speak[{{$index}}]" type="text" value="{{$item->id}}"
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
                                        @endforeach
                                    @else
                                        <div class="row" data-position="0">
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
                                    @if(!$writingData->isEmpty())
                                        @foreach($writingData as $index => $item)
                                            <div class="row" data-position="{{$index}}">
                                                <input name="id_write[{{$index}}]" type="text" value="{{$item->id}}"
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
                                        @endforeach
                                    @else
                                        <div class="row" data-position="0">
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
                                    @if($exercisesData->isEmpty())
                                        <div class="layoutBorder" data-position="0" data-position="0">
                                            <input name="id_exercises[0]" type="text" value="0" hidden>
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
                                    @else
                                        @foreach($exercisesData as $index => $item)
                                            <div class="layoutBorder" data-position="{{$index}}">
                                                <div class="row">
                                                    <input name="id_exercises[{{$index}}]" type="text"
                                                           value="{{$item->id}}" hidden>
                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm"
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
                                                                    <i class="fa fa-plus"></i>&nbsp;&nbsp; Add Exercises
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <a class="btn btn-sm btn-danger remove_exercises"
                                                                   href="javascript:void(0)">
                                                                    <i class="fa fa-times"></i>&nbsp;&nbsp; Remove
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
                                                                <input type="text" class="form-control form-control-sm"
                                                                       name="answer_1[{{$index}}]"
                                                                       placeholder="Nhập câu trả lời"
                                                                       value="{{ $item->answer_1 }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-1"><span
                                                                    class="badge badge-question">2</span></label>
                                                            <div class="col-sm-11">
                                                                <input type="text" class="form-control form-control-sm"
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
                                                                <input type="text" class="form-control form-control-sm"
                                                                       name="answer_3[{{$index}}]"
                                                                       placeholder="Nhập câu trả lời"
                                                                       value="{{ $item->answer_3 }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-1"><span
                                                                    class="badge badge-question">4</span></label>
                                                            <div class="col-sm-11">
                                                                <input type="text" class="form-control form-control-sm"
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
                                                                           type="radio" id="answer_correct_1_{{$index}}"
                                                                           name="answer_correct[{{$index}}]" value="1"
                                                                        {{ ($item->answer_correct == 1) ? 'checked': '' }}>
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
                                                                        {{ ($item->answer_correct == 2) ? 'checked': '' }}>
                                                                    <label for="answer_correct_2_{{$index}}"><span
                                                                            class="badge badge-question margin-circle">2</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-check">
                                                                    <input class="form-check-input"
                                                                           type="radio" id="answer_correct_3_{{$index}}"
                                                                           name="answer_correct[{{$index}}]" value="3"
                                                                        {{ ($item->answer_correct == 3) ? 'checked': '' }}>
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
                                                                        {{ ($item->answer_correct == 4) ? 'checked': '' }}>
                                                                    <label for="answer_correct_4_{{$index}}"><span
                                                                            class="badge badge-question margin-circle">4</span>
                                                                    </label>
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
@endsection

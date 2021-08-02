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
                                <label for="lesson-videos">Video <span class="text-danger">*</span></label>
                                <select name="videos[]" multiple class="form-control select-multiple" id="lesson-videos">
                                    @foreach($videos as $index => $video)
                                        <option value="{{ $video->id }}">{{ $video->title }}</option>
                                    @endforeach
                                </select>

                                @error('videos')
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
@endsection

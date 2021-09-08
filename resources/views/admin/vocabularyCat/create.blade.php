@extends('admin.layouts.master')
@section('page-title', 'Danh mục Từ vựng')
@section('breadcrumb', 'Thêm mới Danh mục từ vựng')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Thêm mới</h3>
                </div>
                <form action="{{ route('admin.vocabularyCat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Tên<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" class="form-control" id="name"
                                           placeholder="Nhập vào tên" name="name" value="{{ old('name') }}">
                                    @error('name')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cate-status">Trạng thái<span class="text-danger">&nbsp;*</span></label>
                                    <select name="status" class="form-control" id="cate-status">
                                        @foreach(config('common.status') as $key => $status)
                                            <option
                                                value="{{ $status }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea id="description" name="description" class="form-control"
                                              rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="lesson-thumb">Ảnh mô tả</label>
                                    <div id="grpThumb" class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   name="inlineRadioUpload"
                                                   id="inlineRadio1" value="1" checked>
                                            <label class="form-check-label" for="inlineRadio1">Tải ảnh lên</label>
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
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-save"></i>&nbsp;&nbsp;Tạo mới
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom-script')
    <script>
        $('#description').summernote({
            placeholder: 'Nhập mô tả',
            height: 125,
        });
    </script>
@endsection

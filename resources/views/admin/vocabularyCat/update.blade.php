@extends('admin.layouts.master')
@section('page-title', 'Danh mục từ vựng')
@section('breadcrumb', 'Cập nhật Danh mục từ vựng')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Cập nhật</h3>
                </div>
                <form action="{{ route('admin.vocabularyCat.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cate-name">Tên<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" class="form-control" id="cate-name"
                                           placeholder="Nhập vào tên" name="name" value="{{ $data->name }}">
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
                                                value="{{ $status }}" {{ $status === $data->status ? 'selected' : '' }}>{{ $key }}</option>
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
                                              rows="10">{{ $data->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="lesson-thumb">Ảnh mô tả<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-file-dummy"
                                               placeholder="Choose file" aria-describedby="fileHelp">
                                        <label class="input-group-append mb-0">
                                        <span class="btn btn-info input-file-btn">
                                          <i class="fa fa-image"></i>&nbsp;&nbsp;Chọn ảnh
                                            <input type="file" hidden
                                                   id="thumb" name="thumb"
                                                   onchange="previewMultiple(event)">
                                        </span>
                                        </label>
                                    </div>
                                    <div id="galleryPhotos">
                                        <div class="imagePhoto">
                                            @if(!empty($data->thumb))
                                                <img src="{{ asset('storage/' . $data->thumb) }}">
                                                {{--<a href="javascript:void(0)" class="removePhoto">
                                                    <i class="fa fa-trash-alt"></i>
                                                </a>--}}
                                            @endif
                                        </div>
                                    </div>
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
                                    class="fa fa-edit"></i>&nbsp;&nbsp;Cập nhật
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


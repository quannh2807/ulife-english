@extends('admin.layouts.master')
@section('page-title', 'Từ vựng')
@section('breadcrumb', 'Cập nhật từ vựng')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Cập nhật</h3>
                </div>
                <form action="{{ route('admin.vocabulary.categoryUpdate', $catId) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cate-name">Tên<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" class="form-control" id="cate-name"
                                           placeholder="Nhập vào tên" name="name"
                                           value="{{ $data->name ? $data->name : old('name') }}">
                                    @error('name')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="spelling">Phiên âm<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" class="form-control" id="spelling"
                                           placeholder="Nhập vào phiên âm" name="spelling"
                                           value="{{ $data->spelling ? $data->spelling : old('spelling') }}">
                                    @error('spelling')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="description">Mô tả<span class="text-danger">&nbsp;*</span></label>
                                    <textarea id="description" name="description" class="form-control"
                                              rows="4">{{ $data->description ? $data->description : old('description') }}</textarea>
                                    @error('description')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cat_id">Danh mục<span class="text-danger">&nbsp;*</span></label>
                                    <select name="cat_id" class="form-control" id="cat_id">
                                        <option>--Chọn danh mục--</option>
                                        @foreach($category as $index => $item)
                                            @if($item != null)
                                                <option
                                                    value="{{ $item->id }}" {{ $item->id == $data->cat_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('cat_id')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
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
                                <div class="form-group">
                                    <label for="lesson-thumb">Ảnh mô tả<span class="text-danger">*</span></label>
                                    <div id="grpThumb" class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   name="inlineRadioUpload"
                                                   data-path="{{$data->thumb}}"
                                                   id="inlineRadio1" value="1"
                                                   @if(!isUrl($data->thumb)) checked @else @endif>
                                            <label class="form-check-label" for="inlineRadio1">Tải ảnh lên</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   name="inlineRadioUpload"
                                                   data-path="{{$data->thumb}}"
                                                   id="inlineRadio2" value="2"
                                                   @if(isUrl($data->thumb)) checked @else @endif>
                                            <label class="form-check-label" for="inlineRadio2">Từ link</label>
                                        </div>
                                    </div>
                                    <div class="boxThumb">
                                        @if(isUrl($data->thumb))
                                            <input id="thumbLink" name="thumb" type="text"
                                                   class="form-control input-file-dummy"
                                                   value="{{$data->thumb}}"
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
                                        @if(!empty($data->thumb))
                                            <div class="imagePhoto">
                                                <img src="@if(isUrl($data->thumb)) {{$data->thumb}} @else {{ asset('storage/' . $data->thumb) }} @endif">
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

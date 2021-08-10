@extends('admin.layouts.master')

@section('page-title', 'Trình độ')
@section('breadcrumb', 'Thêm mới trình độ')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Thêm mới</h3>
                </div>
                <form action="{{ route('admin.level.store') }}" method="POST">
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
                                    <label for="sub-name">Sub Name</label>
                                    <input type="text" class="form-control" id="sub-name"
                                           placeholder="Nhập vào tên" name="sub_name" value="{{ old('sub_name') }}">
                                    @error('sub_name')
                                    <p style="color: red;">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea name="description" class="form-control"
                                              rows="4"></textarea>
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
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-end">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Tạo mới
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

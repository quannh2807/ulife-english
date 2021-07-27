@extends('admin.layouts.master')

@section('page-title', 'Topics')
@section('breadcrumb', 'Thêm mới Topics')

@section('main')
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Thêm mới</h3>
            </div>
            <form action="{{ route('admin.topics.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cate-name">Tên Level<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="cate-name"
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
                                    <option>Chọn trạng thái</option>
                                    <option value="1">Kích hoạt</option>
                                    <option value="0">Không kích hoạt</option>
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
@endsection

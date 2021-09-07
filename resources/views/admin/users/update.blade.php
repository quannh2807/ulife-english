@extends('admin.layouts.master')

@section('page-title', 'Người dùng')
@section('breadcrumb', 'Thêm mới người dùng')

@section('main')
<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Thêm mới</h3>
            </div>
            <form action="{{ route('admin.user.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="acc_name">Tên tài khoản<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="acc_name" placeholder="Nhập tên tài khoản"
                                    name="acc_name" value="{{ $user->acc_name }}">

                                @error('acc_name')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="full_name">Tên người dùng<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="full_name"
                                    placeholder="Nhập vào tên người dùng" name="full_name"
                                    value="{{ $user->full_name }}">

                                @error('full_name')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="email" placeholder="Nhập email" name="email"
                                    value="{{ $user->email }}">

                                @error('email')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mobile">Di động<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control" id="mobile" placeholder="Nhập số điện thoại"
                                    name="mobile" value="{{ $user->mobile }}">

                                @error('mobile')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">Máy bàn</label>
                                <input type="text" class="form-control" id="phone"
                                    placeholder="Nhập số điện thoại cố định" name="phone" value="{{ $user->phone }}">

                                @error('phone')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="birthday">Ngày sinh<span class="text-danger">&nbsp;*</span></label>
                                <input type="text" class="form-control date-picker" id="birthday" placeholder="Nhập ngày sinh"
                                    name="birthday" value="{{ $user->birthday }}">

                                @error('birthday')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" placeholder="Nhập địa chỉ"
                                    name="address" value="{{ $user->address }}">

                                @error('address')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Trạng thái<span class="text-danger">&nbsp;*</span></label>
                                <select name="status" class="form-control" id="status">
                                    @foreach(config('common.status') as $key => $status)
                                    <option value="{{ $status }}" {{ $user->status === $status ? 'selected' : '' }}>{{ $key }}</option>
                                    @endforeach
                                </select>

                                @error('status')
                                <p style="color: red;">{{$message}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cate-name">Ảnh đại diện</label>

                                <div class="boxThumb">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-file-dummy" placeholder="Chọn ảnh"
                                            aria-describedby="fileHelp" readonly>
                                        <label class="input-group-append mb-0">
                                            <span class="btn btn-info input-file-btn">
                                                <i class="fa fa-image"></i>&nbsp;&nbsp;Chọn ảnh
                                                <input type="file" hidden id="thumbUpload" name="avatar"
                                                    accept="image/*" onchange="previewMultiple(event)">
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div id="galleryPhotos"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i>&nbsp;&nbsp;Chỉnh sửa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

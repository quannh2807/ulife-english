@extends('admin.layouts.master')

@section('page-title', 'DS Bài học')
@section('breadcrumb', 'DS Bài học')

@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách</h3>
            <div class="card-tools">
                <div>
                    <a href="{{ route('admin.lesson.create') }}"
                       class="d-inline-block btn btn-sm btn-primary"><i
                            class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                        mới</a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="frmSearch" action="{{ route('admin.lesson.search') }}" method="GET">
                <div class="row">
                    <div class="item-search">
                        <div class="btn-group" style="margin: 0px 10px">
                            <input type="text" class="form-control form-control-sm"
                                   id="searchInput" name="keyword"
                                   placeholder="Tìm kiếm với tiêu đề hoặc ID"
                                   value="{{ request()->has('keyword') ? request()->get('keyword') : '' }}">
                            <span id="searchClear" class="nav-icon fas fa-times-circle"></span>
                        </div>
                    </div>
                    <div style="margin: 0px 6px;">
                        <div class="input-group">
                            <input id="valRangeDate" name="rangeDate" type="text"
                                   value="{{ request()->has('rangeDate') ? request()->get('rangeDate') : '' }}"
                                   hidden>
                            <button type="button" class="btn btn-sm btn-default float-right btn-block text-left"
                                    id="daterange-btn">
                                <i class="far fa-calendar-alt"></i>&nbsp;&nbsp;<span
                                    id="txtDateRange">{{ request()->has('rangeDate') && !empty(request()->get('rangeDate')) ? request()->get('rangeDate') : 'Từ ngày - Đến ngày' }}</span>
                                <i class="fas fa-caret-down"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-3">
                        <select class="form-control form-control-sm" name="courses">
                            <option value="">--Chọn khóa học--</option>
                            @foreach($courseData as $index => $item)
                                @if($item != null)
                                    <option
                                        value="{{ $item->id }}" {{ request()->has('courses') && request()->get('courses') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="form-control form-control-sm" name="status">
                            <option value="-1">--Trạng thái--</option>
                            @foreach(config('common.status') as $key => $status)
                                <option
                                    value="{{ $status }}" {{ request()->has('status') && request()->get('status') == $status  ? 'selected' : '' }}>{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="submit"
                                class="btn btn-sm btn-success"><i
                                class="fa fa-search"></i><span>&nbsp; Tìm kiếm</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th style="width: 30px;">STT</th>
                    <th style="width: 30px;">#</th>
                    <th style="width: 120px;">Ảnh</th>
                    <th>Tên bài học</th>
                    <th class="text-center">Khóa học</th>
                    <th class="text-center">Thứ tự</th>
                    <th class="text-center">Trình độ</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Thời gian tạo</th>
                    <th align="right" class="text-center" style="width: 130px;">Thao tác</th>
                </tr>
                </thead>

                @php
                    $i = 1
                @endphp

                <tbody class="">
                @if($lessons->isEmpty())
                    <tr>
                        <td colspan="100%" align="center">Không có dữ liệu</td>
                    </tr>
                @endif

                @foreach($lessons as $key => $lesson)
                    @php
                        Carbon\Carbon::setLocale('vi');
                        $now = Carbon\Carbon::now();
                    @endphp

                    <tr id="row-{{$lesson->id}}">
                        <th>{{ $i ++ }}</th>
                        <td>{{ $lesson->id }}</td>
                        <td>
                            <img class="thumbList" width="120" height="80"
                                 src="{{ thumbImagePath($lesson->thumb_img) }}"
                                 alt="{{ $lesson->name }}"
                                 title="{{ $lesson->name }}"/>
                        </td>
                        <td>{{ $lesson->name }}</td>
                        <td class="text-center">
                            <span class="badge badge-primary">{{ $lesson->hasCourse->name }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $lesson->position }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-primary">{{ $lesson->hasLevel->name }}</span>
                        </td>
                        <td class="text-center">{!! htmlStatus($lesson->status) !!}</td>
                        <td class="text-center">{{ $lesson->created_at->diffForHumans($now) }}</td>
                        <td align="center" class="text-center">
                            <a href="{{ route('admin.lesson.edit', ['id' => $lesson->id]) }}"
                               class="d-inline-block btn btn-sm btn-warning m-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="d-inline-block btn btn-sm btn-danger m-1 btn-remove"
                               data-id="{{ $lesson->id }}"
                               href="{{ route('admin.lesson.remove', ['id' => $lesson->id]) }}">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{ $lessons->links() }}
        </div>
    </div>
    <!-- /.card -->
@endsection

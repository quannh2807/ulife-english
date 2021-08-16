@extends('admin.layouts.master')
@section('page-title', 'Danh mục video')
@section('breadcrumb', 'Danh mục video')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách</h3>
                    <div class="card-tools">
                        <div>
                            <a href="{{ route('admin.category.create') }}"
                               class="d-inline-block btn btn-sm btn-primary"><i
                                    class="fa fa-plus"></i>&nbsp;&nbsp;Thêm
                                mới</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="frmSearch" action="{{ route('admin.category.search') }}" method="GET">
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
                            <th>Tên</th>
                            <th>Danh mục cha</th>
                            <th align="center" class="text-center" style="width: 120px;">Trạng thái</th>
                            <th class="text-center" style="width: 80px;">Ngày tạo</th>
                            <th align="right" class="text-center" style="width: 130px;">Thao tác</th>
                        </tr>
                        </thead>

                        @php
                            $i = 1
                        @endphp

                        <tbody>
                        @if($categories->isEmpty())
                            <tr>
                                <td colspan="9" align="center">Không có dữ liệu</td>
                            </tr>
                        @else
                            @foreach($categories as $index => $category)
                                <tr id="row-{{ $category->id }}">
                                    <th>{{ $i ++ }}</th>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->hasParentCate !== null ? $category->hasParentCate->name : '/' }}</td>
                                    <td class="text-center">{!! htmlStatus($category->status) !!}</td>
                                    <td class="text-center">
                                        <span class="lbl-item">
                                            {{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y h:m:s')}}
                                        </span>
                                    </td>
                                    <td align="center" class="text-center">
                                        <a href="{{ route('admin.category.update', ['id' => $category->id]) }}"
                                           class="d-inline-block btn btn-sm btn-warning">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a class="d-inline-block btn btn-sm btn-danger ml-2 btn-remove"
                                           data-id="{{ $category->id }}"
                                           href="{{ route('admin.category.remove', ['id' => $category->id]) }}">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $categories->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@extends('admin.layouts.master')

@section('page-title', 'Video Youtube')
@section('breadcrumb', 'Video Youtube')

@section('main')
    <div class="card">
        <div class="card-header">
            <div class="">
                <form action="{{ route('admin.video.search') }}" method="GET" class="form-inline">
                    <div class="col">
                        <input type="text" name="keyword" class="form-control form-control-sm"
                               placeholder="Tìm kiếm theo tên video" width="100%"
                               value="{{ request()->has('keyword') ? request()->get('keyword') : '' }}">
                    </div>
                    <div class="col">
                        <select name="type" id="" class="form-control form-control-sm">
                            <option value="">-- Chọn loại video --</option>
                            @foreach(config('common.video_types') as $key => $value)
                                <option
                                    value="{{ $value }}" {{ request()->has('type') && request()->get('type') == $value ? 'selected' : '' }}>{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{--<div class="col">
                        <select name="category" id="" class="form-control form-control-sm">
                            <option value="">-- Chọn danh mục video --</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}" {{ request()->has('category') && request()->get('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>--}}
                    <div class="col">
                        <select name="status" class="form-control form-control-sm">
                            <option value="">-- Chọn trạng thái video --</option>
                            @foreach(config('common.status') as $key => $status)
                                <option
                                    value="{{ $status }}" {{ request()->has('status') && request()->get('status') == (string)$status ? 'selected' : '' }}>{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-wrap">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th width="30%">Tên video</th>
                    <th>Loại video</th>
                    <th>Loại danh mục</th>
                    <th>Trạng thái</th>
                    <th align="center" class="text-center btn-group-sm">
                        <a href="{{ route('admin.video.create') }}" class="d-inline-block btn btn-sm btn-primary">
                            Thêm mới
                        </a>
                    </th>
                </tr>
                </thead>

                @php
                    $i = 1
                @endphp

                <tbody class="">
                @foreach($videos as $key => $video)
                    <tr id="row-{{$video->id}}">
                        <th>{{ $i ++ }}</th>
                        <td>
                            <img
                                src="{{ $video->custom_thumbnails ? asset('storage/' . $video->custom_thumbnails) : json_decode($video->ytb_thumbnails, true)['default']['url'] }}"
                                class="rounded mx-auto"
                                style="width: 100px"
                                alt="">
                        </td>
                        <td>{{ $video->title }}</td>
                        <td>{!! $video->type == 1 ? '<span class="d-inline-block px-1 m-1 bg-success rounded" style="font-size: 13px">Grammar</span>' : '<span class="d-inline-block px-1 m-1 bg-info rounded" style="font-size: 13px">Lesson</span>' !!}</td>
                        <td>
                            @foreach($video->hasCategories as $cate)
                                <span class="d-inline-block px-1 m-1 bg-success rounded"
                                      style="font-size: 13px">{{ $cate->name }}</span>
                            @endforeach
                        </td>
                        <td class="text-center">{!! $video->status === 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
                            : '<label id="status" class="active">Kích hoạt</label>' !!}</td>
                        <td align="center" class="text-center">
                            <a href="{{ route('admin.subtitle.index', ['video_id' => $video->id]) }}"
                               class="d-inline-block btn btn-sm btn-info mb-1">
                                <i class="far fa-closed-captioning"></i>
                            </a>
                            <a href="{{ route('admin.video.update', ['id' => $video->id]) }}"
                               class="d-inline-block btn btn-sm btn-warning mb-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="d-inline-block btn btn-sm btn-danger mb-1 btn-remove"
                               data-id="{{ $video->id }}"
                               href="{{ route('admin.video.remove', ['id' => $video->id]) }}">
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
            {{ $videos->links() }}
        </div>
    </div>
    <!-- /.card -->
@endsection

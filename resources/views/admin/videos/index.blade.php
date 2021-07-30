@extends('admin.layouts.master')

@section('page-title', 'Video Youtube')
@section('breadcrumb', 'Video Youtube')

@section('main')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Đây sẽ là nơi đặt các filter</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" name="table_search" class="form-control float-right"
                           placeholder="Search">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-wrap">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên video</th>
                    <th>Kênh</th>
                    <th>Loại danh mục</th>
                    <th>Trạng thái</th>
                    <th align="center" class="text-center">
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
                        <td><img
                                src="{{ $video->custom_thumbnails ? asset('storage/' . $video->custom_thumbnails) : json_decode($video->ytb_thumbnails, true)['default']['url'] }}"
                                class="rounded mx-auto"
                                style="width: {{json_decode($video->ytb_thumbnails, true)['default']['width']}}px"
                                alt=""></td>
                        <td>{{ $video->title }}</td>
                        <td>{{ $video->channel_title }}</td>
                        <td>
                            @foreach($video->hasCategories as $cate)
                                <span class="d-inline-block px-1 m-1 bg-success rounded" style="font-size: 13px">{{ $cate->name }}</span>
                            @endforeach
                        </td>
                        <td class="text-center">{!! $video->status === 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
                            : '<label id="status" class="active">Kích hoạt</label>' !!}</td>
                        <td align="center" class="text-center">
                            <a href="{{ route('admin.subtitle.index', ['video_id' => $video->id]) }}"
                               class="d-inline-block btn btn-sm btn-info m-1">
                                <i class="far fa-closed-captioning"></i>
                            </a>
                            <a href="{{ route('admin.video.update', ['id' => $video->id]) }}"
                               class="d-inline-block btn btn-sm btn-warning m-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a class="d-inline-block btn btn-sm btn-danger m-1"
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

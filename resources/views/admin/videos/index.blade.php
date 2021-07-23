@extends('admin.layouts.master')

@section('page-title', 'Video Youtube')
@section('breadcrumb', 'Video Youtube')

@section('main')
    <div class="col-12">
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
                        <th>Phụ đề</th>
                        <th>Trạng thái</th>
                        <th align="center" class="text-center">
                            <a href="{{ route('admin.video.create') }}" class="d-inline-block btn btn-primary fs-3">Thêm
                                mới</a>
                        </th>
                    </tr>
                    </thead>

                    @php
                        $i = 1
                    @endphp

                    <tbody>
                    @foreach($videos as $key => $video)
                        <tr id="row-{{$video->id}}">
                            <th>{{ $i ++ }}</th>
                            <td><img src="{{ json_decode($video->ytb_thumbnails, true)['default']['url'] }}"
                                     class="rounded mx-auto"
                                     style="width: {{json_decode($video->ytb_thumbnails, true)['default']['width']}}px"
                                     alt=""></td>
                            <td>{{ $video->title }}</td>
                            <td>{{ $video->channel_title }}</td>
                            <td>{{ $video->hasCategory->name }}</td>
                            <td>
{{--                                @if(count($video->hasSubLanguages) > 0)--}}
{{--                                    @foreach($video->hasSubLanguages as $lang)--}}
{{--                                        <p>{{ $lang->name }}</p>--}}
{{--                                    @endforeach--}}
{{--                                @else--}}
                                    Chưa có phụ đề
{{--                                @endif--}}
                            </td>
                            <td>{{ $video->status === 1 ? 'Hiển thị' : 'Ẩn' }}</td>
                            <td align="center" class="text-center">
                                <a href=""
                                   class="d-inline-block btn btn-sm btn-info">
                                    <i class="far fa-closed-captioning"></i>
                                </a>
                                <a href="{{ route('admin.video.update', ['id' => $video->id]) }}"
                                   class="d-inline-block btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a class="d-inline-block btn btn-sm btn-danger btn-remove"
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
            {{--            <div class="card-footer clearfix">--}}
            {{--                {{ $videos->links() }}--}}
            {{--            </div>--}}
        </div>
        <!-- /.card -->
    </div>
@endsection

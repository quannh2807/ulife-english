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
                    <th>Tên bài học</th>
                    <th>Trình độ</th>
                    <th>Trạng thái</th>
                    <th>Thời gian tạo</th>
                    <th>Ảnh</th>
                    <th align="center" class="text-center">
                        <a href="{{ route('admin.lesson.create') }}" class="d-inline-block btn btn-sm btn-primary">
                            Thêm mới
                        </a>
                    </th>
                </tr>
                </thead>

                @php
                    $i = 1
                @endphp

                <tbody class="">
                @if($lessons->isEmpty())
                    <tr>
                        <td colspan="8" align="center">Không có dữ liệu</td>
                    </tr>
                @endif

                @foreach($lessons as $key => $lesson)
                    @php
                        Carbon\Carbon::setLocale('vi');
                        $now = Carbon\Carbon::now();
                    @endphp


                    <tr id="row-{{$lesson->id}}">
                        <th>{{ $i ++ }}</th>
                        <th>{{ $lesson->name }}</th>
                        <th>{{ $lesson->hasLevel->name }}</th>
                        <td>{!! $lesson->status === 0 ? '<label id="status" class="noActive">Không kích hoạt</label>'
                            : '<label id="status" class="active">Kích hoạt</label>' !!}</td>
                        <th>{{ $lesson->created_at->diffForHumans($now) }}</th>
                        <th>
                            <img src="{{ asset('storage/' . $lesson->thumb_img) }}" class="img-thumbnail"
                                 style="width: 100px" alt="">
                        </th>
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
